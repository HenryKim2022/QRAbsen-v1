<?php

namespace App\Http\Controllers\OfficeRoles;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TheApp_Model;
use App\Models\Jabatan_Model;
use App\Models\Karyawan_Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;


class OfficeRoleController extends Controller
{
    //
    public function index(Request $request)
    {
        $process = $this->setPageSession("Manage OfficeRole", "m-role");
        if ($process) {
            $loadDaftarJabatanFromDB = [];
            $loadDaftarJabatanFromDB = Jabatan_Model::with(['karyawan'])->withoutTrashed()->get();

            $user = auth()->user();
            $authenticated_user_data = Karyawan_Model::with('daftar_login.karyawan', 'daftar_login_4get.karyawan','jabatan.karyawan')->find($user->id_karyawan);

            $modalData = [
                'modal_add' => '#add_roleModal',
                'modal_edit' => '#edit_roleModal',
                'modal_delete' => '#delete_roleModal',
                'modal_reset' => '#reset_roleModal',
            ];

            $data = [
                'site_name' => TheApp_Model::where('na_setting', 'CompanyName')->withoutTrashed()->first(),
                'site_year' => TheApp_Model::where('na_setting', 'SiteCopyrightYear')->withoutTrashed()->first(),
                'aboutus_data' => TheApp_Model::where('na_setting', 'AboutUSText')->withoutTrashed()->first(),
                'company_addr' => TheApp_Model::where('na_setting', 'CompanyAddress')->withoutTrashed()->first(),
                'company_phone' => TheApp_Model::where('na_setting', 'CompanyPhone')->withoutTrashed()->first(),
                'company_email' => TheApp_Model::where('na_setting', 'CompanyEmail')->withoutTrashed()->first(),
                'loadDaftarJabatanFromDB' => $loadDaftarJabatanFromDB,
                'modalData' => $modalData,
                'employee_list' => Karyawan_Model::withoutTrashed()->get(),
                'authenticated_user_data' => $authenticated_user_data,
            ];
            return $this->setReturnView('pages/userpanels/p_m_daftarjabatan', $data);
        }
    }





    public function get_role(Request $request)
    {
        $jabatanID = $request->input('jabatanID');
        $daftarJabatan = Jabatan_Model::with('karyawan')->where('id_jabatan', $jabatanID)->first();

        if ($daftarJabatan) {
            $karyawan = $daftarJabatan->karyawan;
            // Load the select input for Mark & Category (this loading is different from load_select_list_for_addmodal())
            $employeeList = Jabatan_Model::all()->map(function ($user) use ($karyawan) {
                $selected = ($user->id_karyawan == $karyawan->id_karyawan);
                return [
                    'value' => $user->karyawan->id_karyawan,
                    'text' => $user->karyawan->na_karyawan,
                    'selected' => $selected,
                ];
            });

            // Return queried data as a JSON response
            return response()->json([
                'id_jabatan' => $jabatanID,
                'na_jabatan' => $daftarJabatan->na_karyawan,
                'id_karyawan' => $karyawan->id_karyawan,
                'employeeList' => $employeeList,
            ]);
        } else {
            // Handle the case when the user with the given user_id is not found
            return response()->json(['error' => 'OfficeRole not found'], 404);
        }
    }





    public function add_role(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'role-karyawan-id'  => 'required',
            ],
            [
                'role-karyawan-id' => 'The employee field is required.',
            ]
        );
        if ($validator->fails()) {
            $toast_message = $validator->errors()->all();
            Session::flash('errors', $toast_message);
            return redirect()->back()->withErrors($validator)->withInput();
        }


        $id_karyawan = $request->input('role-karyawan-id');
        if ($id_karyawan) {          // IF Check-in
            $roles = new Jabatan_Model();
            $roles->na_jabatan = $request->input('role-name');
            $roles->id_karyawan = $id_karyawan;
            $roles->save();

            $authenticated_user_data = Jabatan_Model::find($roles->user_id);      // Re-auth after saving
            $user = auth()->user();
            $authenticated_user_data = Karyawan_Model::with('daftar_login.karyawan', 'jabatan.karyawan')->find($user->id_karyawan);
            Session::put('authenticated_user_data', $authenticated_user_data);

            Session::flash('success', ['Role added successfully!']);
        }
        return redirect()->back();
    }



    public function delete_role(Request $request)
    {
        $jabatanID = $request->input('jabatan_id');
        $jabatan = Jabatan_Model::with('karyawan')->where('id_jabatan', $jabatanID)->first();
        if ($jabatan) {
            $jabatan->delete();

            $authenticated_user_data = Jabatan_Model::find($jabatan->id_jabatan);      // Re-auth after saving
            $user = auth()->user();
            $authenticated_user_data = Karyawan_Model::with('daftar_login.karyawan', 'jabatan.karyawan')->find($user->id_karyawan);
            Session::put('authenticated_user_data', $authenticated_user_data);

            Session::flash('success', ['Role deletion successful!']);
        } else {
            Session::flash('errors', ['Err[404]: Role deletion failed!']);
        }
        return redirect()->back();
    }

    public function reset_role(Request $request)
    {
        Jabatan_Model::query()->delete();
        DB::statement('ALTER TABLE tb_jabatan AUTO_INCREMENT = 1');

        $user = auth()->user();
        $authenticated_user_data = Karyawan_Model::with('daftar_login.karyawan', 'jabatan.karyawan')->find($user->id_karyawan);
        Session::put('authenticated_user_data', $authenticated_user_data);

        Session::flash('success', ['All role data reset successfully!']);
        return redirect()->back();
    }


}
