<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function home()
    {
        $role_id = Auth::user()->user_role_id;
        if ($role_id === 4) {
            return redirect('dashboard-pasien');
        } else if ($role_id === 3) {
            return redirect('dashboard-perawat');
        } else if ($role_id === 2) {
            return redirect('dashboard-dokter');
        } else {
            return redirect('dashboard');
        }
    }
}
