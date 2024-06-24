<?php

namespace App\Http\Controllers\Employees;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TheApp_Model;
use App\Models\Karyawan_Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;


class EmployeeController extends Controller
{
    //
    public function index(Request $request)
    {
        $process = $this->setPageSession("Manage Attende", "m-absen");
        if ($process) {
            $loadDaftarKaryawanFromDB = [];
            $loadDaftarKaryawanFromDB = Karyawan_Model::withoutTrashed()->get();

            $user = auth()->user();
            $authenticated_user_data = Karyawan_Model::with('daftar_login.karyawan', 'jabatan.karyawan')->find($user->id_karyawan);

            $modalData = [
                'modal_add' => '#add_karyawanModal',
                'modal_edit' => '#edit_karyawanModal',
                'modal_delete' => '#delete_karyawanModal',
                'modal_reset' => '#reset_karyawanModal',
            ];

            $data = [
                'site_name' => TheApp_Model::where('na_setting', 'CompanyName')->withoutTrashed()->first(),
                'site_year' => TheApp_Model::where('na_setting', 'SiteCopyrightYear')->withoutTrashed()->first(),
                'aboutus_data' => TheApp_Model::where('na_setting', 'AboutUSText')->withoutTrashed()->first(),
                'company_addr' => TheApp_Model::where('na_setting', 'CompanyAddress')->withoutTrashed()->first(),
                'company_phone' => TheApp_Model::where('na_setting', 'CompanyPhone')->withoutTrashed()->first(),
                'company_email' => TheApp_Model::where('na_setting', 'CompanyEmail')->withoutTrashed()->first(),
                'loadDaftarKaryawanFromDB' => $loadDaftarKaryawanFromDB,
                'modalData' => $modalData,
                'employee_list' => Karyawan_Model::withoutTrashed()->get(),
                'authenticated_user_data' => $authenticated_user_data,
            ];
            return $this->setReturnView('pages/userpanels/p_m_daftarkaryawan', $data);
        }
    }




    public function delete_emp(Request $request)
    {
        $karyawanID = $request->input('del_karyawan_id');

        $authenticated_user_data = Session::get('authenticated_user_data');
        $current_user_rel_karyawan = $authenticated_user_data->id_karyawan;
        $is_current_user = ($karyawanID == $current_user_rel_karyawan);
        if ($is_current_user){
            Session::flash('n_errors', ["Err[500]: You're not allowed to delete your own data while u're active!"]);
        }else{
            $karyawan = Karyawan_Model::where('id_karyawan', $karyawanID)->whereNull('deleted_at')->first();
            if ($karyawan) {
                $karyawan->delete();

                $user = auth()->user();
                $authenticated_user_data = Karyawan_Model::with('daftar_login.karyawan', 'jabatan.karyawan')->find($user->id_karyawan);
                Session::put('authenticated_user_data', $authenticated_user_data);
                Session::flash('success', ['Role deletion successful!']);
            } else {
                Session::flash('n_errors', ['Err[404]: Role deletion failed!']);
            }

        }

        return redirect()->back();
    }



    public function reset_emp(Request $request)
    {
        $user = auth()->user();
        $karyawanID = $user->id_karyawan;
        // Soft delete all karyawan records except the one with the given karyawanID
        Karyawan_Model::where('id_karyawan', '!=', $karyawanID)->delete();

        // Reset the auto-increment value of the table
        DB::statement('ALTER TABLE tb_karyawan AUTO_INCREMENT = 1');
        $user = auth()->user();
        $authenticated_user_data = Karyawan_Model::with('daftar_login.karyawan', 'jabatan.karyawan')->find($user->id_karyawan);
        Session::put('authenticated_user_data', $authenticated_user_data);

        Session::flash('success', ['All karyawan data (excluding me) reset successfully!']);
        return redirect()->back();
    }

}
