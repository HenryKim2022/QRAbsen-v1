<?php

namespace App\Http\Controllers\UserLogins;

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


class UserLoginController extends Controller
{
    //
    public function index(Request $request){
        $process = $this->setPageSession("Login Page", "login");
        if ($process) {
            $loadDaftarLoginFromDB = [];
            $loadDaftarLoginFromDB = DaftarLogin_Model::with(['karyawan'])->withoutTrashed()->get();

            $user = auth()->user();
            $authenticated_user_data = Karyawan_Model::with('daftar_login.karyawan', 'jabatan.karyawan')->find($user->id_karyawan);

            $modalData = [
                'modal_add' => '#add_userModal',
                'modal_edit' => '#edit_userModal',
                'modal_delete' => '#delete_userModal',
                'modal_reset' => '#reset_userModal',
            ];

            $data = [
                'site_name' => TheApp_Model::where('na_setting', 'CompanyName')->withoutTrashed()->first(),
                'site_year' => TheApp_Model::where('na_setting', 'SiteCopyrightYear')->withoutTrashed()->first(),
                'aboutus_data' => TheApp_Model::where('na_setting', 'AboutUSText')->withoutTrashed()->first(),
                'company_addr' => TheApp_Model::where('na_setting', 'CompanyAddress')->withoutTrashed()->first(),
                'company_phone' => TheApp_Model::where('na_setting', 'CompanyPhone')->withoutTrashed()->first(),
                'company_email' => TheApp_Model::where('na_setting', 'CompanyEmail')->withoutTrashed()->first(),
                'loadDaftarLoginFromDB' => $loadDaftarLoginFromDB,
                'modalData' => $modalData,
                'employee_list' => Karyawan_Model::withoutTrashed()->get(),
                'authenticated_user_data' => $authenticated_user_data,
            ];
            return $this->setReturnView('pages/userpanels/p_m_daftarlogin', $data);
        }
    }




    public function get_user(Request $request)
    {
        $userID = $request->input('userID');
        $karyawan = Karyawan_Model::with('daftar_login.karyawan')->find($userID);
        if ($karyawan) {
            // Load the select input for Mark & Category (this loading is diff with load_select_list_for_addmodal())
            $employeeList = DaftarLogin_Model::all()->map(function ($user) use ($karyawan) {
                $selected = ($user->id_karyawan == $karyawan->id_karyawan);
                return [
                    'value' => $user->user_id,
                    'text' => $user->karyawan->na_karyawan,
                    'selected' => $selected,
                ];
            });

            $userTypeList = DaftarLogin_Model::all()->map(function ($user) use ($karyawan) {
                $selected = ($user->id_karyawan == $karyawan->id_karyawan);
                return [
                    'value' => $user->convertUserTypeBack($user->type),
                    'text' => $user->type,
                    'selected' => $selected,
                ];
            });

            // Return queried data as a JSON response
            return response()->json([
                'user_id' => $userID,
                'na_karyawan' => $karyawan->na_karyawan,
                'username' => $karyawan->daftar_login->username,
                'email' => $karyawan->daftar_login->email,
                'password' => null,     /// CANT REVERSE HASHED ByCrypt PASSWORD : DONOT CHANGE!
                'id_karyawan' => $karyawan->id_karyawan,
                'employeeList' => $employeeList,
                'userTypeList' => $userTypeList,

            ]);
        } else {
            // Handle the case when the mark is not found
            return response()->json(['error' => 'Karyawan not found'], 404);
        }
    }




}
