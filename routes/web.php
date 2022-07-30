<?php

use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\InfoUserController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PerawatController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ResetController;
use App\Http\Controllers\SessionsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::group(['middleware' => 'auth'], function () {

    Route::get('/', [HomeController::class, 'home']);

    // !!! Route group for admin
    Route::group(['middleware' => 'admin'], function () {
        Route::get('dashboard', [AdminController::class, 'index'])->name('dashboard');
        Route::get('tambah-user', [AdminController::class, 'create'])->name('tambah.user');
        Route::post('tambah-user', [AdminController::class, 'store']);
        Route::get('edit-user/{id}', [AdminController::class, 'show'])->name('edit.user');;
        Route::post('edit-user/{id}', [AdminController::class, 'edit']);
        Route::post('rubah-status/{id}', [AdminController::class, 'changeStatus'])->name('rubah.status');
    });

    // !!! Route group for pasien
    Route::group(['middleware' => 'role:4'], function () {
        Route::get('dashboard-pasien', [PatientController::class, 'index'])->name('dashboard.pasien');
        Route::get('self-assessment', [PatientController::class, 'create'])->name('self.assessment');
        Route::post('self-assessment', [PatientController::class, 'store']);
        Route::get('detail-assessment/{id}', [PatientController::class, 'show'])->name('detail.assessment');
        Route::get('download/{filename}', [AdminController::class, 'download'])->name('download');
    });

    // !!! Route group for perawat
    Route::group(['middleware' => 'role:3'], function () {
        Route::get('dashboard-perawat', [PerawatController::class, 'index'])->name('dashboard.perawat');
        Route::get('analisa/{id}', [PerawatController::class, 'create'])->name('analisa');
        Route::post('analisa/{id}', [PerawatController::class, 'store'])->name('analisa');
        Route::get('update-pengkajian/{id}', [PerawatController::class, 'show'])->name('update.pengkajian');
        Route::post('update-pengkajian/{id}', [PerawatController::class, 'update'])->name('update.pengkajian');
        Route::get('validasi-assessment/{id}', [PerawatController::class, 'validasiKeluhan'])->name('validasi');
        Route::post('validasi-assessment/{id}', [PerawatController::class, 'updateKeluhan'])->name('validasi.assessment');
        Route::post('validasi-user/{userId}', [PerawatController::class, 'updatePasien']);
        Route::get('detail-pengkajian/{id}', [PerawatController::class, 'detail'])->name('detail.pengkajian');
        Route::get('download-data-pendukung/{filename}', [AdminController::class, 'download'])->name('download.data.pendukung');
    });

    // !!! Route group for dokter
    Route::group(['middleware' => 'role:2'], function () {
        Route::get('dashboard-dokter', [DokterController::class, 'index'])->name('dashboard.dokter');
        Route::get('diagnosa/{id}', [DokterController::class, 'create'])->name('diagnosa');
        Route::post('diagnosa/{id}', [DokterController::class, 'store'])->name('diagnosa');
        Route::get('detail-diagnosa/{id}', [DokterController::class, 'show'])->name('detail.diagnosa');
        Route::get('download-data-pasien/{filename}', [AdminController::class, 'download'])->name('download.data.pasien');
    });

	Route::get('billing', function () {
		return view('billing');
	})->name('billing');

	Route::get('profile', function () {
		return view('profile');
	})->name('profile');

	Route::get('rtl', function () {
		return view('rtl');
	})->name('rtl');

	Route::get('user-management', function () {
		return view('laravel-examples/user-management');
	})->name('user-management');

	Route::get('tables', function () {
		return view('tables');
	})->name('tables');

    Route::get('virtual-reality', function () {
		return view('virtual-reality');
	})->name('virtual-reality');

    Route::get('static-sign-in', function () {
		return view('static-sign-in');
	})->name('sign-in');

    Route::get('static-sign-up', function () {
		return view('static-sign-up');
	})->name('sign-up');

    Route::get('/logout', [SessionsController::class, 'destroy']);
	Route::get('/user-profile', [InfoUserController::class, 'create']);
	Route::post('/user-profile', [InfoUserController::class, 'store']);
    Route::get('/login', function () {
		return view('dashboard');
	})->name('sign-up');
});



Route::group(['middleware' => 'guest'], function () {
    Route::get('/register', [RegisterController::class, 'create']);
    Route::post('/register', [RegisterController::class, 'store']);
    Route::get('/login', [SessionsController::class, 'create']);
    Route::post('/session', [SessionsController::class, 'store']);
	Route::get('/login/forgot-password', [ResetController::class, 'create']);
	Route::post('/forgot-password', [ResetController::class, 'sendEmail']);
	Route::get('/reset-password/{token}', [ResetController::class, 'resetPass'])->name('password.reset');
	Route::post('/reset-password', [ChangePasswordController::class, 'changePassword'])->name('password.update');

});

Route::get('/login', function () {
    return view('session/login-session');
})->name('login');
