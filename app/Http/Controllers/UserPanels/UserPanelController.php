<?php

namespace App\Http\Controllers\UserPanels;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\TheApp_Model;
use App\Models\Karyawan_Model;
use App\Models\Absen_Model;
use App\Models\DaftarLogin_Model;
use Illuminate\Support\Facades\Storage;

class UserPanelController extends Controller
{
    public function index(Request $request)
    {
        $process = $this->setPageSession("Dashboard", "dashboard");
        if ($process) {
            $idKaryawan = $this->getCurrentUserID();
            $loadAbsenFromDB = [];

            if (auth()->user()->type == 'Admin') {
                $loadAbsenFromDB = Absen_Model::with(['karyawan'])->withoutTrashed()->get();
            } else if (auth()->user()->type == 'Karyawan') {
                $loadAbsenFromDB = Absen_Model::with(['karyawan'])->where('id_karyawan', $idKaryawan)->get();
            }

            $absenInUrl = $this->generateAbsenUrl($idKaryawan);
            $absenOutUrl = $this->generateAbsenUrl($idKaryawan, "out");
            // dd($absenInUrl, $absenOutUrl);

            $data = [
                // 'checkInQRCode' => base64_encode($this->genQR($absenInUrl, 144)),
                // 'checkOutQRCode' => base64_encode($this->genQR($absenOutUrl, 144)),
                'checkInQRCode' => env('APP_URL') . '/dashboard/' . $absenInUrl,
                'checkOutQRCode' => env('APP_URL') . '/dashboard/' . $absenOutUrl,
                'site_name' => TheApp_Model::where('na_setting', 'CompanyName')->withoutTrashed()->first(),
                'site_year' => TheApp_Model::where('na_setting', 'SiteCopyrightYear')->withoutTrashed()->first(),
                'aboutus_data' => TheApp_Model::where('na_setting', 'AboutUSText')->withoutTrashed()->first(),
                'company_addr' => TheApp_Model::where('na_setting', 'CompanyAddress')->withoutTrashed()->first(),
                'company_phone' => TheApp_Model::where('na_setting', 'CompanyPhone')->withoutTrashed()->first(),
                'company_email' => TheApp_Model::where('na_setting', 'CompanyEmail')->withoutTrashed()->first(),
                'loadAbsenFromDB' => $loadAbsenFromDB,
            ];

            return $this->setReturnView('pages/userpanels/p_dashboard', $data);
        }
    }

    public function getCurrentUserID()
    {
        $user = auth()->user();
        $idKaryawan = null;
        if ($user) {
            $karyawan = Karyawan_Model::where('id_karyawan', $user->id_karyawan)->first();
            if ($karyawan) {
                $idKaryawan = $karyawan->id_karyawan;
            }
        }
        return $idKaryawan;
    }

    public function generateAbsenUrl($idKaryawan, $act = "in")
    {
        $absenModel = new Absen_Model();
        $absenUrl = $absenModel->generateUrl($idKaryawan, $act);
        return $absenUrl;
    }



    public function loadAbsenModal_In(Request $request)
    {
        $id_karyawan = $request->query('id');
        $karyawan = Karyawan_Model::with(['daftar_login', 'absen'])->find($id_karyawan);
        // dd($karyawan);
        if (!$karyawan) {
            Session::flash('errors', ['Karyawan not found.']);
            return redirect()->back();
        }
        $dataFromDB = [
            'id_karyawan_for_absen' => $id_karyawan,
            'data_karyawan' => $karyawan,
        ];
        Session::put('data_karyawan_for_absen_in', $dataFromDB);
        return redirect()->back();
    }

    public function loadAbsenModal_Out(Request $request)
    {
        $id_karyawan = $request->query('id');
        $karyawan = Karyawan_Model::with(['daftar_login', 'absen'])->find($id_karyawan);
        // dd($karyawan);
        if (!$karyawan) {
            Session::flash('errors', ['Karyawan not found.']);
            return redirect()->back();
        }
        $dataFromDB = [
            'id_karyawan_for_absen' => $id_karyawan,
            'data_karyawan' => $karyawan,
        ];
        Session::put('data_karyawan_for_absen_out', $dataFromDB);
        return redirect()->back();
    }




    public function doAbsenInViaModal(Request $request)
    {
        $id_karyawan = $request->input('absen-karyawan-id');
        $na_karyawan = $request->input('absen-karyawan-name');
        $attendance_status = $request->input('attendance-status');
        $detail = $request->input('absen-karyawan-reason');
        $check_inDT = date('Y-m-d H:i:s');
        $check_outDT = date('Y-m-d H:i:s');


        // Handle the file upload for absen-karyawan-proof
        if ($request->hasFile('absen-karyawan-proof')) {
            $file = $request->file('absen-karyawan-proof');
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            // Store the uploaded file in the storage/app/public directory
            Storage::putFileAs('public/absen/proof', $file, $filename);
            $proof_path = asset(env(key: 'APP_URL')) . '/public/storage/absen/proof/' . $filename;

            $karyawan = Karyawan_Model::find($id_karyawan);
            if ($karyawan) {
                if ($attendance_status === 3 || $attendance_status === 4) {
                    $karyawan->absen()->create([
                        'status' => $attendance_status,
                        'detail' => $detail,
                        'bukti' => $proof_path,
                        'checkin' => $check_inDT,
                        'checkout' => $check_outDT,
                        'id_karyawan' => $karyawan->id_karyawan,
                    ]);
                } else {
                    $karyawan->absen()->create([
                        'status' => $attendance_status,
                        'detail' => $detail,
                        'bukti' => $proof_path,
                        'checkin' => $check_inDT,
                        'id_karyawan' => $karyawan->id_karyawan,
                    ]);
                }
                Session::flash('success', ['Absen added successfully!']);
            } else {    // Handle the case when the specified Karyawan_Model instance is not found
                Session::flash('n_errors', ['Absen adding failed!']);
            }
        } else {    // Handle case where no logo file is provided
            $karyawan = Karyawan_Model::find($id_karyawan);
            if ($karyawan) {
                if ($attendance_status === 3 || $attendance_status === 4) {
                    $karyawan->absen()->create([    // Create the related Absen_Model record
                        'status' => $attendance_status,
                        'detail' => $detail,
                        'checkin' => $check_inDT,
                        'checkout' => $check_outDT,
                        'id_karyawan' => $karyawan->id_karyawan,
                    ]);
                } else {
                    $karyawan->absen()->create([    // Create the related Absen_Model record
                        'status' => $attendance_status,
                        'detail' => $detail,
                        'checkin' => $check_inDT,
                        'id_karyawan' => $karyawan->id_karyawan,
                    ]);
                }
                Session::flash('success', ['Absen added successfully!']);
            } else {    // Handle the case when the specified Karyawan_Model instance is not found
                Session::flash('n_errors', ['Absen adding failed!']);
            }
        }
        return redirect()->back();
    }



    public function doAbsenOutViaModal(Request $request)
    {
        $id_karyawan = $request->input('absen-karyawan-id');
        $na_karyawan = $request->input('absen-karyawan-name');
        $attendance_status = $request->input('attendance-status');
        $detail = $request->input('absen-karyawan-reason');
        $check_outDT = date('Y-m-d H:i:s');

        // Handle the file upload for absen-karyawan-proof
        if ($request->hasFile('absen-karyawan-proof')) {
            $file = $request->file('absen-karyawan-proof');
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            // Store the uploaded file in the storage/app/public directory
            Storage::putFileAs('public/absen/proof', $file, $filename);
            $proof_path = asset(env(key: 'APP_URL')) . '/public/storage/absen/proof/' . $filename;


            $karyawan = Karyawan_Model::find($id_karyawan);
            if ($karyawan) {
                $karyawan->bukti = $proof_path;
                $lastAddedAbsen = $karyawan->absen()->latest()->first();    // Find the last added Absen_Model record for the $karyawan
                if ($lastAddedAbsen) {
                    $lastCheckout = $lastAddedAbsen->checkout;  //Access the current checkout in DB (optional)
                    $lastAddedAbsen->checkout = $check_outDT;   //Update the checkout
                    if ($attendance_status !== null && $attendance_status !== '') {
                        $lastAddedAbsen->status = $attendance_status;   // Update the status only if $attendance_status is not null
                    } else {
                        // $lastAddedAbsen->status = 0;    // Set a default value if $attendance_status is null or empty
                    }
                    if ($detail == null && $detail == '') {
                        $lastAddedAbsen->detail = "BackHome";
                    }
                    $lastAddedAbsen->save();

                    Session::flash('success', ['Absen added successfully!']);
                } else {
                    Session::flash('n_errors', ['No Absen record found for the specified Karyawan!']);    // Handle the case when no Absen_Model record is found for the $karyawan
                }
            } else {
                Session::flash('n_errors', ['Absen adding failed!']);     // Handle the case when the specified Karyawan_Model instance is not found
            }
        } else {
            $karyawan = Karyawan_Model::find($id_karyawan);
            if ($karyawan) {
                $lastAddedAbsen = $karyawan->absen()->latest()->first();    // Find the last added Absen_Model record for the $karyawan
                if ($lastAddedAbsen) {
                    $lastCheckout = $lastAddedAbsen->checkout;  //Access the current checkout in DB (optional)
                    $lastAddedAbsen->checkout = $check_outDT;   //Update the checkout
                    if ($attendance_status !== null && $attendance_status !== '') {
                        $lastAddedAbsen->status = $attendance_status;   // Update the status only if $attendance_status is not null
                    } else {
                        // $lastAddedAbsen->status = 0;    // Set a default value if $attendance_status is null or empty
                    }
                    if ($detail == null && $detail == '') {
                        $lastAddedAbsen->detail = "BackHome";
                    }
                    $lastAddedAbsen->save();

                    Session::flash('success', ['Absen added successfully!']);
                } else {
                    Session::flash('n_errors', ['No Absen record found for the specified Karyawan!']);    // Handle the case when no Absen_Model record is found for the $karyawan
                }
            } else {
                Session::flash('n_errors', ['Absen adding failed!']);     // Handle the case when the specified Karyawan_Model instance is not found
            }
        }
        return redirect()->back();
    }



    public function profile(Request $request)
    {
        $process = $this->setPageSession("MyProfile", "my-profile");
        if ($process) {
            $idKaryawan = $this->getCurrentUserID();
            $data = [
                'loadDataKaryawanFromDB' => DaftarLogin_Model::with(['karyawan'])->where('id_karyawan', $idKaryawan)->get(),
                'site_name' => TheApp_Model::where('na_setting', 'CompanyName')->withoutTrashed()->first(),
                'site_year' => TheApp_Model::where('na_setting', 'SiteCopyrightYear')->withoutTrashed()->first(),
                'aboutus_data' => TheApp_Model::where('na_setting', 'AboutUSText')->withoutTrashed()->first(),
                'company_addr' => TheApp_Model::where('na_setting', 'CompanyAddress')->withoutTrashed()->first(),
                'company_phone' => TheApp_Model::where('na_setting', 'CompanyPhone')->withoutTrashed()->first(),
                'company_email' => TheApp_Model::where('na_setting', 'CompanyEmail')->withoutTrashed()->first(),
                'authenticated_user_data' => auth()->user(),


            ];
            return $this->setReturnView('pages/userpanels/p_m_profile', $data);
        }
    }






}
