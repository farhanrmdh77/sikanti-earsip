<?php

namespace App\Http\Controllers\Auth;

use App\Subbagian; // [TAMBAHAN 1]: Memanggil model Subbagian
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * [TAMBAHAN 2]: Menimpa fungsi bawaan untuk mengirim data ke View
     * Menampilkan form registrasi dengan membawa data subbagian.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        // Mengambil semua data subbagian dari database
        $subbagians = Subbagian::all();
        
        // Mengirim variabel $subbagians ke halaman view register
        return view('auth.register', compact('subbagians'));
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'subbag_id' => ['required', 'integer'], // [TAMBAHAN 3]: Validasi wajib diisi
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'subbag_id' => $data['subbag_id'],
            'role' => 'Admin',
        ]);
    }
}