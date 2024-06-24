@extends('layouts.userpanels.v_main')

@section('header_page_cssjs')
@endsection


@section('page-content')
    {{-- @if (auth()->user()->type == 'Admin')
        <h1>HI MIN :)</h1>
    @endif

    @if (auth()->user()->type == 'Karyawan')
        <h1>HI WAN :)</h1>
    @endif --}}

    {{-- {{ dd($authenticated_user_data) }} --}}

    @auth
        <section id="dashboard-ecommerce">
            <div class="row match-height">
                <!-- QRCodeCheck-out Card -->
                <div class="col-lg-4 col-md-6 col-12">
                </div>
                <!--/ QRCodeCheck-out Card -->

                <!-- TableAbsen Card -->
                <div class="col-lg-12 col-md-12 col-12">
                    <div class="card card-developer-meetup">
                        <div class="card-body p-1">
                            <table id="daftarLoginKaryawanTable" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>OfficeRole</th>
                                        <th>Assigned to</th>
                                        <th>Created</th>
                                        <th>Last-Update</th>
                                        <th>Act</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- {{dd($loadDaftarJabatanFromDB->toArray());}} --}}
                                    @foreach ($loadDaftarJabatanFromDB as $jab)
                                        <tr>
                                            <td>{{ $jab->na_jabatan ?: '-' }}</td>
                                            <td>{{ $jab->karyawan !== null ? $jab->karyawan->na_karyawan : '-' }}</td>
                                            <td>
                                                @if ($jab->created_at)
                                                    {{ \Carbon\Carbon::parse($jab->created_at)->isoFormat('dddd, DD MMMM YYYY, h:mm:ss A') }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                @if ($jab->updated_at)
                                                    {{ \Carbon\Carbon::parse($jab->updated_at)->isoFormat('dddd, DD MMMM YYYY, h:mm:ss A') }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                <div class="dropdown d-lg-block d-sm-block d-md-block">
                                                    <button class="btn btn-icon navbar-toggler" type="button"
                                                        id="tableActionDropdown" data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        <i data-feather="align-justify" class="font-medium-5"></i>
                                                    </button>
                                                    <!-- dropdown menu -->
                                                    <div class="dropdown-menu dropdown-menu-right"
                                                        aria-labelledby="tableActionDropdown">
                                                        <a class="edit-record dropdown-item d-flex align-items-center"
                                                            jabatan_id_value = "{{ $jab->id_jabatan }}"
                                                            karyawan_id_value = "{{ $jab->id_karyawan }}"
                                                            onclick="openModal('{{ $modalData['modal_edit'] }}')">
                                                            <i data-feather="edit" class="mr-1" style="color: #28c76f;"></i>
                                                            Edit
                                                        </a>
                                                        <a class="delete-record dropdown-item d-flex align-items-center"
                                                            jabatan_id_value = "{{ $jab->id_jabatan }}"
                                                            onclick="openModal('{{ $modalData['modal_delete'] }}')">
                                                            <i data-feather="trash" class="mr-1" style="color: #ea5455;"></i>
                                                            Delete
                                                        </a>
                                                    </div>
                                                    <!--/ dropdown menu -->
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
                <!--/ TableAbsen Card -->



            </div>



        </section>



        <!-- BEGIN: AddJabatanModal--> @include('modals.userpanels.m_daftarjabatan.v_add_jabatanModal') <!-- END: AddJabatanModal-->
        <!-- BEGIN: EditJabatanModal--> @include('modals.userpanels.m_daftarjabatan.v_edit_jabatanModal') <!-- END: EditJabatanModal-->
        <!-- BEGIN: DelJabatanModal--> @include('modals.userpanels.m_daftarjabatan.v_del_jabatanModal') <!-- END: DelJabatanModal-->
        <!-- BEGIN: ResetJabatanModal--> @include('modals.userpanels.m_daftarjabatan.v_reset_jabatanModal') <!-- END: ResetJabatanModal-->




    @endauth
@endsection


@section('footer_page_js')
    <script src="{{ asset('public/vuexy/app-assets/js/scripts/components/components-modals.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#daftarLoginKaryawanTable').DataTable({
                lengthMenu: [5, 10, 15, 20, 25, 50, 100, 150, 200, 250],
                pageLength: 10,
                responsive: true,
                ordering: true,
                searching: true,
                language: {
                    lengthMenu: 'Display _MENU_ records per page',
                    info: 'Showing page _PAGE_ of _PAGES_',
                    search: 'Search',
                    paginate: {
                        first: 'First',
                        last: 'Last',
                        next: '&rarr;',
                        previous: '&larr;'
                    }
                },
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });
        });
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modalId = 'edit_roleModal';
            const modalSelector = document.getElementById(modalId);
            const modalToShow = new bootstrap.Modal(modalSelector);
            const targetedModalForm = document.querySelector('#' + modalId + ' #edit_roleModalFORM');

            $(document).on('click', '.edit-record', function(event) {
                var jabID = $(this).attr('jabatan_id_value');
                var karyawanID = $(this).attr('karyawan_id_value');
                console.log('Edit button clicked for jabatan_id:', jabID);

                setTimeout(() => {
                    $.ajax({
                        url: '{{ route('m.emp.roles.getrole') }}',
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}' // Update the CSRF token here
                        },
                        data: {
                            jabatanID: jabID,
                            karyawanID: karyawanID
                        },
                        success: function(response) {
                            console.log(response);
                            $('#jabatan_id').val(response.id_jabatan);
                            $('#karyawan_id').val(response.id_karyawan);
                            $('#role-name').val(response.na_jabatan);
                            setEmpList(response);

                            console.log('SHOWING MODAL');
                            modalToShow.show();
                        },
                        error: function(error) {
                            console.log("Err [JS]:\n");
                            console.log(error);
                        }
                    });
                }); // <-- Closing parenthesis for setTimeout
            });




            function setEmpList(response) {
                var empSelect = $('#' + modalId +
                    ' #role-karyawan-id');
                empSelect.empty(); // Clear existing options
                empSelect.append($('<option>', {
                    value: "",
                    text: "Select Employee"
                }));
                $.each(response.employeeList, function(index,
                    empOption) {
                    var option = $('<option>', {
                        value: empOption.value,
                        text: `[${empOption.value}] ${empOption.text}`
                    });
                    if (empOption.selected) {
                        option.attr('selected',
                            'selected'); // Select the option
                    }
                    empSelect.append(option);
                });

            }

            const saveRecordBtn = document.querySelector('#' + modalId + ' #confirmSave');
            if (saveRecordBtn) {
                saveRecordBtn.addEventListener('click', function(event) {
                    event.preventDefault(); // Prevent the default button behavior
                    targetedModalForm.submit(); // Submit the form if validation passes
                });
            }
        });
    </script>



    <script>
        $(document).ready(function() {
            $('.toggle-password').click(function() {
                var passwordInput = $('#Password');
                var passwordFieldType = passwordInput.attr('type');
                var passwordIcon = $('.password-icon');

                if (passwordFieldType === 'password') {
                    passwordInput.attr('type', 'text');
                    passwordIcon.attr('data-feather', 'eye-off');
                } else {
                    passwordInput.attr('type', 'password');
                    passwordIcon.attr('data-feather', 'eye');
                }

                feather.replace(); // Refresh the Feather icons after changing the icon attribute
            });
        });
    </script>




    <script>
        document.addEventListener('DOMContentLoaded', function() {
            whichModal = "delete_roleModal";
            const modalSelector = document.querySelector('#' + whichModal);
            const modalToShow = new bootstrap.Modal(modalSelector);

            setTimeout(() => {
                $('.delete-record').on('click', function() {
                    var absenID = $(this).attr('jabatan_id_value');
                    $('#' + whichModal + ' #jabatan_id').val(absenID);
                    modalToShow.show();
                });
            }, 200);

        });
    </script>
@endsection
