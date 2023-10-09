<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\Entities\Admin;
use Auth;
use LogHelper;
use View;

class LoginController extends Controller
{
    /**
     * 登入頁
     *
     * @return View
     */
    public function index()
    {
        return view('admin.auth.index');
    }

    /**
     * 會員登出
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        $admin = Auth::guard('admin')
                     ->user();

        Auth::guard('admin')
            ->logout();

        if ($admin instanceof Admin) {
            LogHelper::info(__METHOD__, 'admin:' . $admin->id . ' logout success.');
        }

        return redirect()->route('admin.login.index');
    }
}
