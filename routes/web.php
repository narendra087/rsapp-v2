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

  Route::get('dashboard', [AdminController::class, 'index'])->name('dashboard');

  Route::get('tambah-pasien', [AdminController::class, 'create'])->name('tambah.pasien');
  Route::post('tambah-pasien', [AdminController::class, 'store']);
	// Route::get('dashboard', function () {
	// 	return view('dashboard');
	// })->name('dashboard');

  Route::group(['middleware' => 'role:4'], function () {
      Route::get('dashboard-pasien', [PatientController::class, 'index'])->name('dashboard.pasien');
      Route::get('form-keluhan', [PatientController::class, 'create'])->name('form.keluhan');
      Route::post('form-keluhan', [PatientController::class, 'store']);
      Route::get('hasil-analisa/{id}', [PatientController::class, 'show'])->name('hasil.analisa');
      // Route::get('dashboard-pasien', function () {
      //   return view('pasien/dashboard-pasien');
      // })->name('dashboard.pasien');

      // Route::get('form-keluhan', function () {
      //   return view('pasien/form-keluhan');
      // })->name('form.keluhan');
  });

  Route::group(['middleware' => 'role:3'], function () {
    Route::get('dashboard-perawat', [PerawatController::class, 'index'])->name('dashboard.perawat');
    Route::get('form-analisa/{id}', [PerawatController::class, 'create'])->name('form.analisis');
    Route::post('form-analisa/{id}', [PerawatController::class, 'store'])->name('form.analisis');
    Route::get('validasi-keluhan/{id}', [PerawatController::class, 'validasiKeluhan'])->name('validasi.keluhan');
    Route::post('validasi-keluhan/{id}', [PerawatController::class, 'updateKeluhan']);
    Route::post('validasi-user/{userId}', [PerawatController::class, 'updatePasien']);

  });

  Route::group(['middleware' => 'role:2'], function () {

    Route::get('dashboard-dokter', [DokterController::class, 'index'])->name('dashboard.dokter');
    Route::get('form-diagnosa', [DokterController::class, 'create'])->name('form.diagnosa');

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
