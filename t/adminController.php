<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class adminController extends Controller
{
    public function showadmin()
    {
        return view('adminPanel.layout.home');
    }

    public function login()
    {
        return view('adminPanel.login.login');
    }

    public function openAdminDashborad()
    {
        $remmberme = request('remember') == 1 ? true : false ;
        if (Auth()->attempt(['email' => request('email'), 'password' => request('password')]  , $remmberme )) {
            
            return redirect('adminPanel');
            
        }else {
            session()->flash('error', 'You Have Something Wrong with Password or Email');
            return redirect('adminPanel/login');

        }
    }

    public function logoutAdmin()
    {
        Auth()->logout();
        return redirect('adminPanel/login');
    }
}
