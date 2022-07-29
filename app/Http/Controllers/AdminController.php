<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Role;
use App\Models\User;
use App\Models\Response;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        $user = User::join('roles', 'roles.id', '=', 'users.user_role_id')->get(['users.*', 'roles.role_name']);

        $pasien = User::where('user_role_id', 4)->get();
        $selesai = Response::where('response_form_id', 1)->where('response_status_id', 3)->get();
        $menunggu = Response::where('response_form_id', 1)->where('response_status_id', '!=' ,3)->get();

        $count['pasien'] = count($pasien);
        $count['selesai'] = count($selesai);
        $count['menunggu'] = count($menunggu);

        return view('dashboard', compact('user', 'count'));
    }

    public function create()
    {
        $role = Role::all();
        return view('admin/tambah-user', compact('role'));
    }

    public function store()
    {
        $data = request()->validate([
            'username' => ['required', 'min:2', 'max:50', Rule::unique('users', 'user_username')],
            'name' => ['required', 'max:50'],
            'email' => ['required', 'email', 'max:50', Rule::unique('users', 'email')],
            'password' => ['required', 'min:5', 'max:16'],
            'birthday' => ['required'],
            'phone' => ['required', 'digits_between:6,12', 'numeric'],
            'address' => ['required'],
            'role' => ['required'],
        ],[
            '*.required' => 'Bagian ini diperlukan.',
            '*.numeric' => 'Bagian ini harus berisikan angka.',
            '*.email' => 'Format email tidak valid.',
            'username.min' => 'Username minimal berisi 2 karakter',
            'username.max' => 'Username maksimal berisi 50 karakter',
            'username.unique' => 'Username sudah digunakan.',
            'phone.digits_between' => 'Nomor telepon minimal berisi 6-12 angka',
            'email.max' => 'Email maksimal berisi 50 karakter',
            'email.unique' => 'Email sudah digunakan.',
            'password.min' => 'Password minimal berisi 5 karakter',
            'password.max' => 'Password maksimal berisi 16 karakter',
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

    public function show($id)
    {
        $role = Role::all();
        $user = User::find($id);
        return view('admin/edit-user', compact('role', 'user'));
    }

    public function edit(Request $request, $id)
    {
        $data = request()->validate([
            'name' => ['required', 'max:50'],
            'password' => ['nullable', 'min:5', 'max:16'],
            'birthday' => ['required'],
            'phone' => ['required', 'digits_between:6,12', 'numeric'],
            'address' => ['required'],
            'role' => ['required'],
        ],[
            '*.required' => 'Bagian ini diperlukan.',
            '*.numeric' => 'Bagian ini harus berisikan angka.',
            '*.email' => 'Format email tidak valid.',
            'username.min' => 'Username minimal berisi 2 karakter',
            'username.max' => 'Username maksimal berisi 50 karakter',
            'username.unique' => 'Username sudah digunakan.',
            'phone.digits_between' => 'Nomor telepon minimal berisi 6-12 angka',
            'password.min' => 'Password minimal berisi 5 karakter',
            'password.max' => 'Password maksimal berisi 16 karakter',
        ]);

        $user = User::find($id);

        if ($request->get('password') != null) {
            $user->password = bcrypt($request->get['password'] );
        }

        $user->user_name = $request->get('name');
        $user->user_phone = $request->get('phone');
        $user->user_birthday = $request->get('birthday');
        $user->user_address = $request->get('address');
        $user->user_role_id = $request->get('role');
        $user->update();

        return redirect()->back()->with('updated','Data Pasien telah berhasil diperbarui.');
    }

    public function changeStatus($id)
    {
        $admin = User::find(Auth::user()->id);
        if ($admin->user_role_id != 1 && $admin->user_role_id != 3) {
            return redirect()->back()->with('warning','Tidak mempunyai hak akses.');
        }

        $user = User::find($id);
        $user->user_status = $user->user_status == 'Active' ? 'Inactive' : 'Active';
        $user->update();

        return redirect()->back()->with('updated','Data Pasien telah berhasil diperbarui.');
    }

    public function download($filename)
    {
        return response()->download(storage_path('app/uploads/'.$filename));
    }
}
