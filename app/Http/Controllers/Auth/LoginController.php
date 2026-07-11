<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Pengaturan; // Pastikan model Pengaturan dipanggil untuk logo/nama aplikasi

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * ========================================================
     * OVERRIDE: FORCE TAMPILAN LOGIN BARU & KIRIM PENGATURAN
     * ========================================================
     */
    public function showLoginForm()
    {
        // Mengambil data pengaturan untuk ditampilkan di halaman Login (Logo, Nama, dll)
        // Sesuaikan 'Pengaturan::first()' jika model pengaturan Anda berbeda namanya
        $app_setting = \App\Pengaturan::first(); 

        // Memaksa sistem membuka file resources/views/auth/login.blade.php
        return view('auth.login', compact('app_setting'));
    }
}