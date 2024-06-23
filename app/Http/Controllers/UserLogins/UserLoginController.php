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
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;


class UserLoginController extends Controller
{
    //
    public function index(Request $request)
    {
        $process = $this->setPageSession("Manage Users", "m-user");
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
        $daftarLogin = DaftarLogin_Model::with('karyawan')->where('user_id', $userID)->first();

        if ($daftarLogin) {
            $karyawan = $daftarLogin->karyawan;
            // Load the select input for Mark & Category (this loading is different from load_select_list_for_addmodal())
            $employeeList = DaftarLogin_Model::all()->map(function ($user) use ($karyawan) {
                $selected = ($user->id_karyawan == $karyawan->id_karyawan);
                return [
                    'value' => $user->karyawan->id_karyawan,
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
                'username' => $daftarLogin->username,
                'email' => $daftarLogin->email,
                'id_karyawan' => $karyawan->id_karyawan,
                'employeeList' => $employeeList,
                'userTypeList' => $userTypeList,
            ]);
        } else {
            // Handle the case when the user with the given user_id is not found
            return response()->json(['error' => 'User not found'], 404);
        }
    }



    public function add_user(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'modalAddEmployee'  => 'sometimes|required',
                'modalAddUsername'  => [
                    'sometimes',
                    'required',
                    'string',
                    Rule::unique('tb_daftar_login', 'username')->ignore($request->input('user_id'), 'user_id')
                ],
                'modalAddEmail'  => [
                    'sometimes',
                    'required',
                    'email',
                    Rule::unique('tb_daftar_login', 'email')->ignore($request->input('modalEditEmail'), 'email')
                ],
                'modalAddUserType'  => 'sometimes|required|min:1',
                'modalAddPassword' => 'sometimes|required',
            ],
            [
                'modalAddEmployee' => 'The employee field is required.',
                'modalAddUsername' => 'The username field is required.',
                'modalAddEmail' => 'The email field is required.',
                'modalAddUserType' => 'The user-type field is required.',
                'modalAddPassword'  => 'The password field is required.',
            ]
        );
        if ($validator->fails()) {
            $toast_message = $validator->errors()->all();
            Session::flash('errors', $toast_message);
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $inst = new DaftarLogin_Model();
        $inst->username = $request->input('modalAddUsername');
        $inst->email = $request->input('modalAddEmail');
        $inst->password = $request->input('modalAddPassword');
        $inst->type = $request->input('modalAddUserType');
        $inst->id_karyawan = $request->input('modalAddEmployee');

        Session::flash('success', ['Institution added successfully!']);
        $inst->save();
        return redirect()->back();
    }



    public function edit_user(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'modalEditEmployee'  => 'sometimes|required',
                'modalEditUsername'  => [
                    'sometimes',
                    'required',
                    'string',
                    Rule::unique('tb_daftar_login', 'username')->ignore($request->input('modalEditUsername'), 'username')
                ],

                'modalEditEmail'  => [
                    'sometimes',
                    'required',
                    'email',
                    Rule::unique('tb_daftar_login', 'email')->ignore($request->input('modalEditEmail'), 'email')
                ],
                'modalEditUserType'  => 'sometimes|required|min:1',
                'bsvalidationcheckbox1'  => 'required',
            ],
            [
                'modalEditEmployee' => 'The employee field is required.',
                'modalEditUsername' => 'The username field is required.',
                'modalEditEmail' => 'The email field is required.',
                'modalEditUserType' => 'The user-type field is required.',
                'bsvalidationcheckbox1'  => 'The saving agreement field is required.',
            ]
        );
        if ($validator->fails()) {
            $toast_message = $validator->errors()->all();
            Session::flash('errors', $toast_message);
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = DaftarLogin_Model::find($request->input('user_id'));
        if ($user) {
            $user->id_karyawan = $request->input('modalEditEmployee');
            $user->username = $request->input('modalEditUsername');
            $user->email = $request->input('modalEditEmail');
            $user->type = $request->input('modalEditUserType');
            if ($request->input('modalEditPassword')) {
                $user->password = bcrypt($request->input('modalEditPassword'));
            }

            $user->save();
            Session::flash('success', ['User updated successfully!']);
            return Redirect::back();
        } else {
            Session::flash('errors', ['Err[404]: User update failed!']);
        }
    }



    public function delete_user(Request $request)
    {
        $inst = DaftarLogin_Model::find($request->input('user_id'));
        if ($inst) {
            $inst->delete();
            Session::flash('success', ['User deletion successful!']);
        } else {
            Session::flash('errors', ['Err[404]: User deletion failed!']);
        }
        return redirect()->back();
    }

    public function reset_user(Request $request)
    {
        DaftarLogin_Model::query()->delete();
        DB::statement('ALTER TABLE tb_daftar_login AUTO_INCREMENT = 1');
        Session::flash('success', ['All users data reset successfully!']);
        return redirect()->back();
    }
}
