<?php

namespace App\Http\Controllers\Landings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TheApp_Model;

use SimpleSoftwareIO\QrCode\Facades\QrCode;

class LandingController extends Controller
{
    //
    public function index(Request $request)
    {
        $process = $this->setPageSession("Landing Page", "landing-page");
        if ($process) {
            // $categories = Category_Model::with('tb_institution')->withoutTrashed()->get();
            // $loadInstReviewFromDB = Institution_Model::withoutTrashed()->get();
            // $developers = Developer_Model::withoutTrashed()->with('tb_users')->get();


            $pointedGenQR = base64_encode($this->genQRnonAuth());
            if (auth()->check()) {
                $pointedGenQR = base64_encode($this->genQRnonAuth("/landing-page/logout", "red"));
            }

            $data = [
                'site_name' => TheApp_Model::where('na_setting', 'CompanyName')->withoutTrashed()->first(),
                'site_year' => TheApp_Model::where('na_setting', 'SiteCopyrightYear')->withoutTrashed()->first(),
                'aboutus_data' => TheApp_Model::where('na_setting', 'AboutUSText')->withoutTrashed()->first(),
                'company_addr' => TheApp_Model::where('na_setting', 'CompanyAddress')->withoutTrashed()->first(),
                'company_phone' => TheApp_Model::where('na_setting', 'CompanyPhone')->withoutTrashed()->first(),
                'company_email' => TheApp_Model::where('na_setting', 'CompanyEmail')->withoutTrashed()->first(),
                'loginQRCode' => $pointedGenQR,
                // 'loginQRCode' => base64_encode($this->genQR()),

            ];


            return $this->setReturnView('pages/landings/p_landing', $data);
        }
    }


}
