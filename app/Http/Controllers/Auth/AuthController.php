<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TheApp_Model;
use App\Models\DaftarLogin_Model;
use App\Models\Karyawan_Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;



class AuthController extends Controller
{
    //
    public function showLogin(Request $request){
        $process = $this->setPageSession("Login Page", "login");
        if ($process) {
            $data = [
                'site_name' => TheApp_Model::where('na_setting', 'CompanyName')->withoutTrashed()->first(),
            ];
            return $this->setReturnView('pages/auths/p_login', $data);
        }
    }

    public function doLogin(Request $request){
        $validator = Validator::make($request->all(), []);
        $validator->after(function ($validator) use ($request) {        // Custom Validation: Check username/email exist
            $usernameEmail = $request->input('username-email');
            $password = $request->input('login-password');
            $user = DaftarLogin_Model::where(function ($query) use ($usernameEmail) {
                $query->where('username', $usernameEmail)
                    ->orWhere('email', $usernameEmail);
            })->first();

            if ($usernameEmail && $password) {
                if (!$user) {
                    $validator->errors()->add('username-email', 'The username or email not registered.');
                } elseif (!Hash::check($password, $user->password)) {
                    $validator->errors()->add('login-password', 'The password is incorrect.');
                }
            } else if ($usernameEmail) {
                $validator->errors()->add('password-email', 'The password required.');
            } else if ($password) {
                $validator->errors()->add('username-email', 'The username/email required.');
            } else {
                $validator->errors()->add('username-email', 'The username/email required.');
                $validator->errors()->add('password-email', 'The password required.');
            }
        });
        $validator->validate();


        // Get Field Value
        $credentials = $request->only('username-email', 'login-password');
        $usernameEmail = $credentials['username-email'];
        $password = $credentials['login-password'];
        $rememberMe = $request->boolean('remember-me');
        // Attempt Authentication
        if (
            Auth::attempt(['username' => $usernameEmail, 'password' => $password])
            || Auth::attempt(['email' => $usernameEmail, 'password' => $password], $rememberMe)
        ) {
            // Authentication successful
            $request->session()->regenerate();
            Session::flash('success', ['Welcome back :)']);

            $user = auth()->user();
            $authenticated_user_data = Karyawan_Model::with('daftar_login.karyawan', 'jabatan.karyawan')->find($user->id_karyawan);
            // dd($authenticated_user_data->toArray());
            Session::put('authenticated_user_data', $authenticated_user_data);

            if ($user->type === "admin") {
                return redirect()->route('userPanels.dashboard'); // Redirect to admin dashboard
            } elseif ($user->type === "karyawan") {
                return redirect()->route('userPanels.dashboard'); // Redirect to karyawan dashboard
            }else{
                return redirect()->route('login.page'); // Redirect to login page
            }
        } else {
            // Authentication failed
            Session::flash('errors', ['Invalid credentials.']);
            return redirect()->back();
        }
    }




    public function showRegister(Request $request){
        $process = $this->setPageSession("Register Page", "register");
        if ($process) {
            $data = [
                'site_name' => TheApp_Model::where('na_setting', 'CompanyName')->withoutTrashed()->first(),
            ];
            return $this->setReturnView('pages/auths/p_register', $data);
        }
    }

    public function doRegister(Request $request){
        $validator = Validator::make($request->all(), [
            'register-id-karyawan'     => 'required|string',
            'register-name-karyawan'   => 'required|string',
            'register-username' => 'required|string|unique:tb_daftar_login,username',
            'register-email'    => 'required|email|unique:tb_daftar_login,email',
            'register-password' => 'required|min:6',
            'register-confirm-password'  => 'required|same:register-password',
            'register-privacy-policy'    => 'required|accepted',
        ],
        [
            'register-id-karyawan.required' => 'The id field is required.',
            'register-name-karyawan.required' => 'The name field is required.',
            'register-username.required' => 'The username field is required.',
            'register-email.required' => 'The email field is required.',
            'register-password.required' => 'The password field is required.',
            'register-confirm-password.required' => 'The confirm password field is required.',
            'register-privacy-policy.required' => 'You must accept the terms and conditions.',
            'register-email.email' => 'The email must be a valid email address.',
            'register-confirm-password.min' => 'The password must be at least :min characters.',
            'register-confirm-password.same' => 'The confirm password must match the password.',
        ]);
        if ($validator->fails()) {
            $toast_message = $validator->errors()->all();
            Session::flash('errors', $toast_message);
            return redirect()->back()->withErrors($validator)->withInput();
        }


        $karyawan = Karyawan_Model::create([
            'id_karyawan' => $request->input('register-id-karyawan'),
            'na_karyawan' => $request->input('register-name-karyawan'),
        ]);

        $id_karyawan = $karyawan->id_karyawan;

        DaftarLogin_Model::create([
            'username' => $request->input('register-username'),
            'email' => $request->input('register-email'),
            'password' => Hash::make($request->input('register-password')),
            'type' => "2",
            'id_karyawan' => $id_karyawan,
        ]);
        Session::flash('success', ['Registration successful!']);
        return redirect()->route('login.page');
    }




    public function doLogoutUPanel(Request $request){
        $process = $this->setPageSession("Login Page", "login");
        if ($process) {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            Session::flash('success', ['Logged Out :)']);
            return Redirect::to('/login');
        }
    }

    public function doLogoutULanding(Request $request){
        $process = $this->setPageSession("Landing Page", "landing-page");
        if ($process) {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            Session::flash('success', ['Logged Out :)']);
            return Redirect::to('/');
        }
    }



}
