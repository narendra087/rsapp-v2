<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        $pasien = User::all();
        return view('dashboard', compact('pasien'));
    }

    public function create()
    {
        $role = Role::all();
        return view('admin/tambah-pasien', compact('role'));
    }

    public function store()
    {
        $data = request()->validate([
            'username' => ['required', 'min:2', 'max:50', Rule::unique('users', 'user_username')],
            'name' => ['required', 'max:50'],
            'email' => ['required', 'email', 'max:50', Rule::unique('users', 'email')],
            'password' => ['required', 'min:5', 'max:20'],
            'birthday' => ['required'],
            'phone' => ['required', 'digits_between:6,12', 'numeric'],
            'address' => ['required'],
            'role' => ['required'],
        ]);

        $form['password'] = bcrypt($data['password'] );
        $form['user_username'] = $data['username'];
        $form['email'] = $data['email'];
        $form['user_name'] = $data['name'];
        $form['user_birthday'] = $data['birthday'];
        $form['user_phone'] = $data['phone'];
        $form['user_address'] = $data['address'];
        $form['user_role_id'] = $data['role'];

        $form['user_status'] = 'Active';

        session()->flash('success', 'Your account has been created.');
        User::create($form);

        return redirect('/dashboard');
    }
}
