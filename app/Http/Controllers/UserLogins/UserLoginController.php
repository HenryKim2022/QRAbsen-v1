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


            $modalData = ['modal_add' => '#add_userModal', 'modal_reset' => '#reset_userModal',];
            $data = [
                'site_name' => TheApp_Model::where('na_setting', 'CompanyName')->withoutTrashed()->first(),
                'site_year' => TheApp_Model::where('na_setting', 'SiteCopyrightYear')->withoutTrashed()->first(),
                'aboutus_data' => TheApp_Model::where('na_setting', 'AboutUSText')->withoutTrashed()->first(),
                'company_addr' => TheApp_Model::where('na_setting', 'CompanyAddress')->withoutTrashed()->first(),
                'company_phone' => TheApp_Model::where('na_setting', 'CompanyPhone')->withoutTrashed()->first(),
                'company_email' => TheApp_Model::where('na_setting', 'CompanyEmail')->withoutTrashed()->first(),
                'loadDaftarLoginFromDB' => $loadDaftarLoginFromDB,
                'modalData' => $modalData,
            ];
            return $this->setReturnView('pages/userpanels/p_m_daftarlogin', $data);
        }
    }
}
