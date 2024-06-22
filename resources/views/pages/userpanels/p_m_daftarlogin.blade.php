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
                                        <th>Employee Name</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Avatar</th>
                                        <th>Created</th>
                                        <th>Last-Update</th>
                                        <th>Act</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($loadDaftarLoginFromDB as $userLogin)
                                        <tr>
                                            <td>{{ $userLogin->karyawan->na_karyawan ?: '-' }}</td>
                                            <td>{{ $userLogin->username ?: '-' }}</td>
                                            <td>{{ $userLogin->email ?: '-' }}</td>
                                            <td>
                                                @if ($userLogin->karyawan->foto_karyawan)
                                                    <div class="d-flex align-items-center justify-content-around">
                                                        <img src="{{ 'public/avatar/uploads/' . $userLogin->karyawan->foto_karyawan }}"
                                                            alt="Proof 0" style="height: 24px; width: 24px;"
                                                            class="hover-image">
                                                    </div>
                                                @else
                                                    <div class="d-flex align-items-center justify-content-around">
                                                        <img src="{{ env('APP_DEFAULT_AVATAR') }}" alt="Proof 0"
                                                            style="height: 24px; width: 24px;" class="hover-image">
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($userLogin->created_at)
                                                    {{ \Carbon\Carbon::parse($userLogin->created_at)->isoFormat('dddd, DD MMMM YYYY, h:mm:ss A') }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                @if ($userLogin->updated_at)
                                                    {{ \Carbon\Carbon::parse($userLogin->updated_at)->isoFormat('dddd, DD MMMM YYYY, h:mm:ss A') }}
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
                                                            user_id_value = "{{ $userLogin->user_id }}"
                                                            onclick="openModal('{{ $modalData['modal_edit'] }}')">
                                                            <i data-feather="edit" class="mr-1" style="color: #28c76f;"></i>
                                                            Edit
                                                        </a>
                                                        <a class="delete-record dropdown-item d-flex align-items-center"
                                                            user_id_value = "{{ $userLogin->user_id }}"
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



        <!-- BEGIN: AddUserModal--> @include('modals.userpanels.m_daftarlogin.v_add_userModal') <!-- END: AddUserModal-->
        <!-- BEGIN: EditUserModal--> @include('modals.userpanels.m_daftarlogin.v_edit_userModal') <!-- END: EditUserModal-->
        <!-- BEGIN: DelUserModal--> @include('modals.userpanels.m_daftarlogin.v_del_userModal') <!-- END: DelUserModal-->
        <!-- BEGIN: ResetUserModal--> @include('modals.userpanels.m_daftarlogin.v_reset_userModal') <!-- END: ResetUserModal-->




    @endauth
@endsection


@section('footer_page_js')
    <script src="{{ 'public/vuexy/app-assets/js/scripts/components/components-modals.js' }}"></script>

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
            const modalId = 'edit_userModal';
            const modalSelector = document.getElementById(modalId);
            const modalToShow = new bootstrap.Modal(modalSelector);
            const targetedModalForm = document.querySelector('#' + modalId + ' #edit_userModalFORM');

            $(document).on('click', '.edit-record', function(event) {
                var userID = $(this).attr('user_id_value');
                console.log('Edit button clicked for user_id:', userID);

                setTimeout(() => {
                    $.ajax({
                        url: '{{ route('m.user.getuser') }}',
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}' // Update the CSRF token here
                        },
                        data: {
                            userID: userID
                        },
                        success: function(response) {
                            console.log(response);
                            $('#user_id').val(response.user_id);
                            $('#modalEditUsername').val(response.username);
                            $('#modalEditEmail').val(response.email);
                            $('#modalEditPassword').val(response.password);
                            $('#modalEditEmployee').val(response.id_karyawan);

                            setEmpList();

                            function setEmpList() {
                                // Populate the select options for modalEditInstitutionMARKID1
                                var empSelect = $('#' + modalId +
                                    ' #modalEditEmployee');
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


                            setUserTypeList();

                            function setUserTypeList() {
                                // Populate the select options for modalEditInstitutionMARKID1
                                var userTypeSelect = $('#' + modalId +
                                    ' #modalEditUserType');
                                userTypeSelect.empty(); // Clear existing options
                                userTypeSelect.append($('<option>', {
                                    value: "",
                                    text: "Select UserType"
                                }));
                                $.each(response.userTypeList, function(index,
                                    userTypeOption) {
                                    var option = $('<option>', {
                                        value: userTypeOption.value,
                                        text: `[${userTypeOption.value}] ${userTypeOption.text}`
                                    });
                                    if (userTypeOption.selected) {
                                        option.attr('selected',
                                            'selected'); // Select the option
                                    }
                                    userTypeSelect.append(option);
                                });

                            }








                            console.log('SHOWING MODAL');
                            modalToShow.show();
                        },
                        error: function(error) {
                            console.log("Err:\n");
                            console.log(error);
                        }
                    });
                });
            });

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
        document.addEventListener('DOMContentLoaded', function() {
            whichModal = "delete_userModal";
            const modalSelector = document.querySelector('#' + whichModal);
            const modalToShow = new bootstrap.Modal(modalSelector);

            setTimeout(() => {
                $('.delete-record').on('click', function() {
                    var userID = $(this).attr('user_id_value');
                    $('#' + whichModal + ' #user_id').val(userID);
                    modalToShow.show();
                });
            }, 200);

        });
    </script>
@endsection
