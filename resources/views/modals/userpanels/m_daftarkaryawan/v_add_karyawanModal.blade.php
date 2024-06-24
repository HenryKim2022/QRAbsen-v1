
 <div class="modal fade text-left modal-success" id="add_karyawanModal" data-bs-backdrop="static" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel113" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="myModalLabel113">Add Role Informations</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>

             <div class="modal-body">
                <form action="{{ route('m.emp.roles.add') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    {{-- $idKaryawanForAbsen  --}}
                    <!--  <img src="{ Session::get('data')['qr_code_link'] }}" alt="QR Code"> -->

                    <div class="row g-1">
                        {{-- <div class="col-xl-6 col-md-6 col-12 pr-sm-1 pr-md-1 pr-lg-0 pr-xl-0">
                            <div class="form-group mb-0">
                                <label>Employee</label>
                                <select class="select2 form-control form-control-lg" name="role-karyawan-id" id="role-karyawan-id">
                                    <option value="">Select Employee</option>
                                    @foreach($employee_list as $employee)
                                        <option value="{{ $employee->id_karyawan }}">
                                            {{ $employee->na_karyawan }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div> --}}

                        <div class="col-xl-6 col-md-6 col-12">
                            <div class="form-group">
                                <label class="form-label" for="role-name">RoleName</label>
                                <input class="form-control form-control-merge" id="role-name" name="role-name"
                                    placeholder="e.g. Office Boy 1" aria-describedby="role-name" tabindex="4"></input>
                            </div>
                        </div>
                        <div class="col-xl-6 col-md-6 col-12">
                            <div class="form-group">
                                <label class="form-label" for="role-name">RoleName</label>
                                <input class="form-control form-control-merge" id="role-name" name="role-name"
                                    placeholder="e.g. Office Boy 1" aria-describedby="role-name" tabindex="4"></input>
                            </div>
                        </div>



                        <div class="col-xl-12 col-md-12 col-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>


             <div class="modal-footer d-none">
                 <button type="button" class="btn btn-success" data-dismiss="modal">Okay</button>
             </div>
         </div>
     </div>
 </div>



