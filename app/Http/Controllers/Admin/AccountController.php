<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Helpers\Log\Factory\LogFactory;
use App\Http\Requests\AccountRequest;
use App\Models\Entities\Admin;
use App\Models\Entities\Role;
use App\Models\Repositories\AdminRepository;
use DB;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use LogHelper;
use View;

class AccountController extends Controller
{
    private $adminRepository;
    private $connection;

    public function __construct(AdminRepository $adminRepository)
    {
        $this->adminRepository = $adminRepository;

        $this->connection = DB::connection('mysql');

        LogHelper::setWriteToDB(LogFactory::ADMIN);
        $this->middleware(function ($request, $next) {
            LogHelper::setOperateUser(\Auth::guard('admin')
                                           ->user());

            return $next($request);
        });
    }

    /**
     * 帳號管理列表
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|RedirectResponse|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        try {
            $condition = $request->only(['id', 'email', 'search', 'role']);

            $columns = ['id', 'name', 'email', 'protected', 'role'];
            $admins = $this->adminRepository->getByCondition($columns, $condition, ['id' => 'DESC'], 15);
            $roleList = Role::list();
            unset($condition['admin_role']);

            return view('admin.account.index', compact('condition', 'admins', 'roleList'));
        } catch (Exception $exception) {
            return redirect()
                ->back()
                ->withErrors([$exception->getMessage()]);
        }
    }

    /**
     * 新增帳號
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $admin = new Admin();
        $roleList = Role::list();

        return view('admin.account.create', compact('admin', 'roleList'));
    }

    /**
     * 執行新增帳號
     *
     * @param AccountRequest $request
     *
     * @return RedirectResponse
     * @throws Exception
     */
    public function store(AccountRequest $request)
    {
        try {
            if (!Role::exists($request->get('role'))) {
                throw new Exception('群組設定錯誤');
            }

            $data = $request->all();
            $data['password'] = random_bytes(32);
            $data['protected'] = false;

            $this->connection->beginTransaction();
            $admin = $this->adminRepository->create($data);
            if (!$admin instanceof Admin) {
                throw new Exception('新增失敗');
            }
            $this->connection->commit();
            LogHelper::info(__METHOD__, 'admin account create success.', $this->getLogInfo($admin), true);

            return redirect()
                ->route('admin.accounts.index')
                ->with('message', '新增成功');
        } catch (Exception $exception) {
            $this->connection->rollBack();

            return redirect()
                ->route('admin.accounts.create')
                ->withInput()
                ->withErrors([$exception->getMessage()]);
        }
    }

    /**
     * 編輯帳號
     *
     * @param int $id
     *
     * @return \Illuminate\Contracts\View\Factory|RedirectResponse|\Illuminate\View\View
     */
    public function edit($id)
    {
        try {
            $admin = $this->adminRepository->getUserById($id);
            if (!$admin instanceof Admin) {
                throw new Exception('查無資料');
            }

            if ($admin->protected == Admin::PROTECTED_TRUE) {
                throw new Exception('無法編輯受資料保護的帳戶');
            }

            $roleList = Role::list();

            return view('admin.account.edit', compact('admin', 'roleList'));
        } catch (Exception $exception) {
            return redirect()
                ->route('admin.accounts.index')
                ->withErrors([$exception->getMessage()]);
        }
    }

    /**
     * 執行更新資料
     *
     * @param AccountRequest $request
     * @param int            $id
     *
     * @return RedirectResponse
     */
    public function update(AccountRequest $request, $id)
    {
        try {
            if (!Role::exists($request->get('role'))) {
                throw new Exception('群組設定錯誤');
            }

            $admin = $this->adminRepository->getUserById($id);
            if (!$admin instanceof Admin) {
                throw new Exception('查無資料');
            }

            if ($admin->protected == Admin::PROTECTED_TRUE) {
                throw new Exception('無法編輯資料保護的帳戶');
            }

            $data = $request->all();

            $this->connection->beginTransaction();
            $admin = $this->adminRepository->update($admin, $data);
            if (!$admin instanceof Admin) {
                throw new Exception('更新失敗');
            }
            $this->connection->commit();
            LogHelper::info(__METHOD__, 'admin account update success.', $this->getLogInfo($admin), true);

            return redirect()
                ->route('admin.accounts.index')
                ->with('message', '編輯成功');
        } catch (Exception $exception) {
            return redirect()
                ->route('admin.accounts.edit', $id)
                ->withInput()
                ->withErrors([$exception->getMessage()]);
        }
    }

    /**
     * @param Admin $admin
     *
     * @return array
     */
    private function getLogInfo(Admin $admin)
    {
        return ['admin' => $admin->attributesToArray(), 'changed' => $admin->getChanges(),];
    }
}
