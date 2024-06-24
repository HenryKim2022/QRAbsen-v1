 <div class="modal fade text-left modal-success" id="edit_roleModal" data-bs-backdrop="static" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel113" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="myModalLabel113">Edit Role Informations</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             <div class="modal-body">
                 <form class="row g-2 needs-validation mt-1" method="POST" action="{{ route('m.emp.roles.edit') }}" id="edit_roleModalFORM"
                     novalidate>
                     @csrf
                     <input type="hidden" id="jabatan_id" name="jabatan_id" value="" />
                     <input type="hidden" id="karyawan_id" name="karyawan_id" value="" />
                     <div class="col-xl-6 col-md-6 col-12 pr-sm-1 pr-md-1 pr-lg-0 pr-xl-0">
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
                    </div>

                    <div class="col-xl-6 col-md-6 col-12">
                        <div class="form-group">
                            <label class="form-label" for="role-name">RoleName</label>
                            <input class="form-control form-control-merge" id="role-name" name="role-name"
                                placeholder="e.g. Office Boy 1" aria-describedby="role-name" tabindex="4"></input>
                        </div>
                    </div>


                     <div class="col-12 mb-3 mt-2">
                        <div class="form-check">
                          <input type="checkbox" class="form-check-input" id="bsvalidationcheckbox1" name="bsvalidationcheckbox1" data-default-checked="false" required />
                          <label class="form-check-label" for="bsvalidationcheckbox1">Proceed to save</label>
                          <div class="feedback text-muted">You must agree before saving.</div>
                        </div>
                      </div>
                     <div class="modal-footer w-100 px-0 py-1">
                         <div class="col-12 text-center">
                             <div class="d-flex flex-col justify-content-end">
                                 <button class="modal-btn btn btn-primary" data-dismiss="modal" id="confirmCancel"
                                     type="button">Cancel</button>
                                 <button class="modal-btn btn btn-success ml-1" id="confirmSave" {{-- type="submit" --}}>Save</button>
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


