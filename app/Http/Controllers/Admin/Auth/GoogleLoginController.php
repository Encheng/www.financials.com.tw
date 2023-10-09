<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\Entities\Admin;
use App\Models\Entities\Role;
use App\Models\Repositories\AdminRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Two\User as GoogleUser;
use LogHelper;
use Socialite;

class GoogleLoginController extends Controller
{
    private $adminRepository;

    public function __construct(AdminRepository $adminRepository)
    {
        $this->redirectTo = route('admin.index');
        $this->adminRepository = $adminRepository;
    }

    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirect()
    {
        // TODO: 特例開通
        $admin = $this->adminRepository->getUserByCondition('peterlu@cw.com.tw', ['status' => Admin::STATUS_ENABLE]);
        $this->guard()->login($admin);
        return redirect()->intended(route('admin.index'));
        // return Socialite::driver('google')
        //                 ->redirect();
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function callback(Request $request)
    {
        try {
            $user = Socialite::driver('google')
                             ->user();

            if (!$user instanceof GoogleUser) {
                throw new Exception();
            }

            $admin = $this->adminRepository->getUserByCondition($user->email, ['status' => Admin::STATUS_ENABLE]);
            if (!$admin instanceof Admin) {
                LogHelper::warning(__METHOD__, 'user not found.', ['email' => $user->email]);

                return redirect()
                    ->route('admin.login.index')
                    ->withErrors(['尚未建立帳號']);
            }

            // 檢查用戶權限配置
            if (Role::exists($admin->role) === false) {
                $roles = array_keys(Role::list());
                $admin->role = array_diff($admin->role, array_diff($admin->role, $roles));
            }
            $admin->name = $user->name;
            $admin->login_at = date('Y-m-d H:i:s');
            $admin->save();

            $this->guard()
                 ->login($admin);

            return redirect()->intended(route('admin.index'));
        } catch (Exception $exception) {
            LogHelper::error(__METHOD__, 'login error.', ['message' => $exception->getMessage()]);

            return redirect()
                ->route('admin.login.index')
                ->withErrors(['系統錯誤']);
        }
    }

    /**
     * @inheritDoc
     */
    protected function authenticated(Request $request, $admin)
    {
        if (!$admin instanceof Admin) {
            return false;
        }

        /** @var Admin $admin */
        LogHelper::info(__METHOD__, 'login success.', ['admin_id' => $admin->id]);

        return redirect()->to($this->redirectPath());
    }

    /**
     * @inheritDoc
     */
    protected function guard()
    {
        return Auth::guard('admin');
    }

    /**
     * @inheritDoc
     */
    protected function accountList()
    {
        return ['peterlu@cw.com.tw'];
    }
}
