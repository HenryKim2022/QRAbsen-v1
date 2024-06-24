<?php

namespace App\Http\Controllers\Absens;

use App\Http\Controllers\Controller;
use App\Models\Absen_Model;
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



class AbsenController extends Controller
{
    //
    public function index(Request $request)
    {
        $process = $this->setPageSession("Manage Attende", "m-absen");
        if ($process) {
            $loadDaftarAbsenFromDB = [];
            $loadDaftarAbsenFromDB = Absen_Model::with(['karyawan'])->withoutTrashed()->get();

            $user = auth()->user();
            $authenticated_user_data = Karyawan_Model::with('daftar_login.karyawan', 'jabatan.karyawan')->find($user->id_karyawan);

            $modalData = [
                'modal_add' => '#add_absenModal',
                'modal_edit' => '#edit_absenModal',
                'modal_delete' => '#delete_absenModal',
                'modal_reset' => '#reset_absenModal',
            ];

            $data = [
                'site_name' => TheApp_Model::where('na_setting', 'CompanyName')->withoutTrashed()->first(),
                'site_year' => TheApp_Model::where('na_setting', 'SiteCopyrightYear')->withoutTrashed()->first(),
                'aboutus_data' => TheApp_Model::where('na_setting', 'AboutUSText')->withoutTrashed()->first(),
                'company_addr' => TheApp_Model::where('na_setting', 'CompanyAddress')->withoutTrashed()->first(),
                'company_phone' => TheApp_Model::where('na_setting', 'CompanyPhone')->withoutTrashed()->first(),
                'company_email' => TheApp_Model::where('na_setting', 'CompanyEmail')->withoutTrashed()->first(),
                'loadDaftarAbsenFromDB' => $loadDaftarAbsenFromDB,
                'modalData' => $modalData,
                'employee_list' => Karyawan_Model::withoutTrashed()->get(),
                'authenticated_user_data' => $authenticated_user_data,
            ];
            return $this->setReturnView('pages/userpanels/p_m_daftarabsen', $data);
        }
    }




    public function get_absen(Request $request)
    {
        $absenID = $request->input('absenID');
        $daftarAbsen = Absen_Model::with('karyawan')->where('id_absen', $absenID)->first();

        if ($daftarAbsen) {
            $karyawan = $daftarAbsen->karyawan;
            // Load the select input for Mark & Category (this loading is different from load_select_list_for_addmodal())
            $employeeList = Absen_Model::all()->map(function ($user) use ($karyawan) {
                $selected = ($user->id_karyawan == $karyawan->id_karyawan);
                return [
                    'value' => $user->karyawan->id_karyawan,
                    'text' => $user->karyawan->na_karyawan,
                    'selected' => $selected,
                ];
            });

            $action = ($daftarAbsen->checkin !== null && $daftarAbsen->checkout === null) ? 'Check-in' : 'Check-out';
            // Return queried data as a JSON response
            return response()->json([
                'absen_id' => $absenID,
                'employeeList' => $employeeList,
                'status' => $daftarAbsen->status,
                'action' => $action,
                'reason' => $daftarAbsen->detail,
                'bukti' => $daftarAbsen->bukti,
                'id_karyawan' => $karyawan->id_karyawan,
            ]);
        } else {
            // Handle the case when the user with the given user_id is not found
            return response()->json(['error' => 'User not found'], 404);
        }
    }



    public function edit_absen(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'employee-id' => 'sometimes|required',
                'attendance-status' => 'required|numeric|min:1',
                'attendance-action' => 'required|numeric|min:1',
                'bsvalidationcheckbox1' => 'required',
            ],
            [
                'employee-id.required' => 'The employee field is required.',
                'attendance-status.required' => 'The status field is required.',
                'attendance-status.numeric' => 'The status field must be a number.',
                'attendance-status.min' => 'The status field must have a minimum value of 1.',
                'attendance-action.required' => 'The action field is required.',
                'attendance-action.numeric' => 'The action field must be a number.',
                'attendance-action.min' => 'The action field must have a minimum value of 1.',
                'bsvalidationcheckbox1.required' => 'The saving agreement field is required.',
            ]
        );
        if ($validator->fails()) {
            $toast_message = $validator->errors()->all();
            Session::flash('errors', $toast_message);
            return redirect()->back()->withErrors($validator)->withInput();
        }


        $attendance_action = intval($request->input('attendance-action'));
        if ($attendance_action === 1) {          // IF Check-in
            $this->doingEditCheckIn($request);
        } else if ($attendance_action === 2) {   // IF Check-out
            $this->doingEditCheckOut($request);
        }
        return redirect()->back();
    }


    public function doingEditCheckIn(Request $request)
    {
        $absen = Absen_Model::find($request->input('absen_id'));
        if ($absen) {
            $id_karyawan = $request->input('karyawan_id');
            $attendance_status = $request->input('attendance-status');
            $detail = $request->input('absen-karyawan-reason');

            $absen->status = $attendance_status;
            $absen->detail = $detail;
            $absen->id_karyawan = $id_karyawan;
            // Handle the file upload for absen-karyawan-proof
            if ($request->hasFile('absen-karyawan-proof')) {
                $file = $request->file('absen-karyawan-proof');
                $filename = uniqid() . '.' . $file->getClientOriginalExtension();
                // Store the uploaded file in the storage/app/public directory
                Storage::putFileAs('public/absen/proof', $file, $filename);
                $proof_path = asset(env(key: 'APP_URL')) . '/public/storage/absen/proof/' . $filename;

                $absen->bukti = $proof_path;
                $karyawan = Karyawan_Model::find($id_karyawan);
                if ($karyawan) {
                    if ($attendance_status === 3 || $attendance_status === 4) {
                        $absen->checkin = date('Y-m-d H:i:s');
                        $absen->checkout = date('Y-m-d H:i:s');
                    } else {
                        $absen->checkin = date('Y-m-d H:i:s');
                    }
                    $absen->save();
                    Session::flash('success', ['Absen check-in update successfully!']);
                } else {    // Handle the case when the specified Karyawan_Model instance is not found
                    Session::flash('n_errors', ['Err[1]: Absen check-in update failed!']);
                }
            } else {    // Handle case where no logo file is provided
                $karyawan = Karyawan_Model::where('id_karyawan', $id_karyawan)->first();
                if ($karyawan) {
                    if ($attendance_status === 3 || $attendance_status === 4) {
                        $absen->checkin = date('Y-m-d H:i:s');
                        $absen->checkout = date('Y-m-d H:i:s');
                    } else {
                        $absen->checkin = date('Y-m-d H:i:s');
                    }
                    $absen->save();
                    Session::flash('success', ['Absen check-in update successfully!']);
                    return Redirect::back();
                } else {    // Handle the case when the specified Karyawan_Model instance is not found
                    Session::flash('n_errors', ['Err[2]: Absen check-in update failed!']);
                }
            }
        } else {
            Session::flash('errors', ['Err[404]: Absen check-in update failed!']);
        }



        // return redirect()->back();
    }


    public function doingEditCheckOut(Request $request)
    {
        $absen = Absen_Model::find($request->input('absen_id'));
        if ($absen) {
            $id_karyawan = $request->input('karyawan_id');
            $attendance_status = $request->input('attendance-status');
            $detail = $request->input('absen-karyawan-reason');

            $absen->status = $attendance_status;
            $absen->detail = $detail;
            $absen->id_karyawan = $id_karyawan;

            // Handle the file upload for absen-karyawan-proof
            if ($request->hasFile('absen-karyawan-proof')) {
                $file = $request->file('absen-karyawan-proof');
                $filename = uniqid() . '.' . $file->getClientOriginalExtension();
                // Store the uploaded file in the storage/app/public directory
                Storage::putFileAs('public/absen/proof', $file, $filename);
                $proof_path = asset(env(key: 'APP_URL')) . '/public/storage/absen/proof/' . $filename;

                $karyawan = Karyawan_Model::find($id_karyawan);
                if ($karyawan) {
                    $lastAddedAbsen = $karyawan->absen()->latest()->first();    // Find the last added Absen_Model record for the $karyawan
                    if ($lastAddedAbsen) {
                        $lastCheckout = $lastAddedAbsen->checkout;  //Access the current checkout in DB (optional)
                        $lastAddedAbsen->checkout = date('Y-m-d H:i:s');   //Update the checkout
                        if ($attendance_status !== null && $attendance_status !== '') {
                            $lastAddedAbsen->status = $attendance_status;   // Update the status only if $attendance_status is not null
                        } else {
                            // $lastAddedAbsen->status = 0;    // Set a default value if $attendance_status is null or empty
                        }
                        if ($detail == null && $detail == '') {
                            $lastAddedAbsen->detail = "BackHome";
                        }
                        $lastAddedAbsen->save();

                        Session::flash('success', ['Absen check-out update successfully!']);
                    } else {
                        Session::flash('n_errors', ['No Absen record found for the specified Employee!']);    // Handle the case when no Absen_Model record is found for the $karyawan
                    }
                } else {
                    Session::flash('n_errors', ['Absen check-out update failed!']);     // Handle the case when the specified Karyawan_Model instance is not found
                }
            } else {
                $karyawan = Karyawan_Model::find($id_karyawan);
                if ($karyawan) {
                    $lastAddedAbsen = $karyawan->absen()->latest()->first();    // Find the last added Absen_Model record for the $karyawan
                    if ($lastAddedAbsen) {
                        $lastCheckout = $lastAddedAbsen->checkout;  //Access the current checkout in DB (optional)
                        $lastAddedAbsen->checkout = date('Y-m-d H:i:s');   //Update the checkout
                        if ($attendance_status !== null && $attendance_status !== '') {
                            $lastAddedAbsen->status = $attendance_status;   // Update the status only if $attendance_status is not null
                        } else {
                            // $lastAddedAbsen->status = 0;    // Set a default value if $attendance_status is null or empty
                        }
                        if ($detail == null && $detail == '') {
                            $lastAddedAbsen->detail = "BackHome";
                        }
                        $lastAddedAbsen->save();

                        Session::flash('success', ['Absen check-out update successfully!']);
                    } else {
                        Session::flash('n_errors', ['No Absen record found for the specified Employee!']);    // Handle the case when no Absen_Model record is found for the $karyawan
                    }
                } else {
                    Session::flash('n_errors', ['Absen check-out update failed!']);     // Handle the case when the specified Karyawan_Model instance is not found
                }
            }
            return redirect()->back();
        } else {
            Session::flash('errors', ['Err[404]: Absen update failed!']);
        }
    }







    public function add_absen(Request $request)
    {
        $attendance_action = $request->input('attendance-action');
        if ($attendance_action === 1) {          // IF Check-in
            $this->doingCheckIn($request);
        } else if ($attendance_action === 2) {   // IF Check-out
            $this->doingCheckOut($request);
        }
        return redirect()->back();
    }

    public function doingCheckIn(Request $request)
    {
        $id_karyawan = $request->input('absen-karyawan-id');
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


    public function doingCheckOut(Request $request)
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




    public function delete_absen(Request $request)
    {
        $absenID = $request->input('absen_id');
        $absen = Absen_Model::with('karyawan')->where('id_absen', $absenID)->first();
        if ($absen) {
            $absen->delete();
            Session::flash('success', ['Employee check-in/out deletion successful!']);
        } else {
            Session::flash('errors', ['Err[404]: Employee check-in/out deletion failed!']);
        }
        return redirect()->back();
    }

    public function reset_absen(Request $request)
    {
        Absen_Model::query()->delete();
        DB::statement('ALTER TABLE tb_absen AUTO_INCREMENT = 1');
        Session::flash('success', ['All absen data reset successfully!']);
        return redirect()->back();
    }
}
