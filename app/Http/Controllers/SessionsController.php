<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class SessionsController extends Controller
{
    public function create()
    {
        return view('session.login-session');
    }

    public function store()
    {
        $attributes = request()->validate([
            'user_username'=>'required',
            'password'=>'required'
        ]);

        if(Auth::attempt($attributes))
        {
            session()->regenerate();

            $role_id = Auth::user()->user_role_id;
            if ($role_id === 4) {
              return redirect('dashboard-pasien')->with(['success'=>'Berhasil login.']);
            } else if ($role_id === 3) {
              return redirect('dashboard-perawat')->with(['success'=>'Berhasil login.']);
            } else if ($role_id === 2) {
              return redirect('dashboard-dokter')->with(['success'=>'Berhasil login.']);
            } else {
              return redirect('dashboard')->with(['success'=>'Berhasil login.']);
            }
        }
        else{

            return back()->withErrors(['username'=>'Username atau password salah.']);
        }
    }

    public function destroy()
    {

        Auth::logout();

        return redirect('/login')->with(['success'=>'Berhasil logout.']);
    }
}
