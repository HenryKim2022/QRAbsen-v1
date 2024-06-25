@php
    $page = Session::get('page');
    $page_title = $page['page_title'];
    // $authenticated_user_data = Session::get('authenticated_user_data');
@endphp

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
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-left mb-0">{{ $page_title }}</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('userPanels.dashboard') }}">UserPanels</a>
                                    </li>
                                    <li class="breadcrumb-item active"> {{ $page_title }}
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

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
                                        <th>Act</th>
                                        <th>Employee Name</th>
                                        <th>Status</th>
                                        <th>Details</th>
                                        <th>Proof</th>
                                        <th>Check-in</th>
                                        <th>Check-out</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($loadDaftarAbsenFromDB as $userLogin)
                                        <tr>
                                            <td>
                                                <div class="dropdown d-lg-block d-sm-block d-md-block">
                                                    <button class="btn btn-icon navbar-toggler" type="button"
                                                        id="tableActionDropdown" data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        <i data-feather="align-justify" class="font-medium-5"></i>
                                                    </button>
                                                    <!-- dropdown menu -->
                                                    <div class="dropdown-menu dropdown-menu-end"
                                                        aria-labelledby="tableActionDropdown">
                                                        <a class="edit-record dropdown-item d-flex align-items-center"
                                                            absen_id_value = "{{ $userLogin->id_absen }}"
                                                            karyawan_id_value = "{{ $userLogin->karyawan->id_karyawan }}"
                                                            onclick="openModal('{{ $modalData['modal_edit'] }}')">
                                                            <i data-feather="edit" class="mr-1" style="color: #28c76f;"></i>
                                                            Edit
                                                        </a>
                                                        <a class="delete-record dropdown-item d-flex align-items-center"
                                                            absen_id_value = "{{ $userLogin->id_absen }}"
                                                            onclick="openModal('{{ $modalData['modal_delete'] }}')">
                                                            <i data-feather="trash" class="mr-1" style="color: #ea5455;"></i>
                                                            Delete
                                                        </a>
                                                    </div>
                                                    <!--/ dropdown menu -->
                                                </div>
                                            </td>
                                            <td>{{ $userLogin->karyawan->na_karyawan ?: '-' }}</td>
                                            <td>{{ $userLogin->status ?: '-' }}</td>
                                            <td>{{ $userLogin->detail ?: '-' }}</td>
                                            <td>
                                                @if ($userLogin->bukti)
                                                    <div class="d-flex align-items-center justify-content-around">
                                                        <img src="{{ asset('public/absen/uploads/proof/' . $userLogin->bukti) }}" alt="Proof 0"
                                                            style="height: 24px; width: 24px;" class="hover-image">
                                                    </div>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                @if ($userLogin->checkin)
                                                    {{ \Carbon\Carbon::parse($userLogin->checkin)->isoFormat('dddd, DD MMMM YYYY, h:mm:ss A') }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                @if ($userLogin->checkout)
                                                    {{ \Carbon\Carbon::parse($userLogin->checkout)->isoFormat('dddd, DD MMMM YYYY, h:mm:ss A') }}
                                                @else
                                                    -
                                                @endif
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



        <!-- BEGIN: AddAbsenModal--> @include('modals.userpanels.m_daftarabsen.v_add_absenModal') <!-- END: AddAbsenModal-->
        <!-- BEGIN: EditAbsenModal--> @include('modals.userpanels.m_daftarabsen.v_edit_absenModal') <!-- END: EditAbsenModal-->
        <!-- BEGIN: DelAbsenModal--> @include('modals.userpanels.m_daftarabsen.v_del_absenModal') <!-- END: DelAbsenModal-->
        <!-- BEGIN: ResetAbsenModal--> @include('modals.userpanels.m_daftarabsen.v_reset_absenModal') <!-- END: ResetAbsenModal-->




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
            const modalId = 'edit_absenModal';
            const modalSelector = document.getElementById(modalId);
            const modalToShow = new bootstrap.Modal(modalSelector);
            const targetedModalForm = document.querySelector('#' + modalId + ' #edit_absenModalFORM');

            $(document).on('click', '.edit-record', function(event) {
                var absenID = $(this).attr('absen_id_value');
                var karyawanID = $(this).attr('karyawan_id_value');
                console.log('Edit button clicked for absen_id:', absenID);

                setTimeout(() => {
                    $.ajax({
                        url: '{{ route('m.absen.getabsen') }}',
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}' // Update the CSRF token here
                        },
                        data: {
                            absenID: absenID,
                            karyawanID: karyawanID
                        },
                        success: function(response) {
                            console.log(response);
                            $('#absen_id').val(response.absen_id);
                            $('#absen-karyawan-reason').val(response.reason);
                            $('#absen-karyawan-proof').val(response.proof);
                            setEmpList(response);
                            setAbsenStatusList(response);
                            setAttendeeActionList(response);
                            $('#karyawan_id').val(response.id_karyawan);

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
                    ' #employee-id');
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



            function setAbsenStatusList(response) {
                var empAbsenStatusSelect = $('#' + modalId + ' select[name="attendance-status"]');
                empAbsenStatusSelect.empty(); // Clear existing options
                empAbsenStatusSelect.append($('<option disabled>', {
                    value: "",
                    text: "Select Employee Status"
                }));

                var receivedStatus = response.status;
                var statusList = [{
                        value: '',
                        text: 'Select Employee Status',
                        selected: receivedStatus === ''
                    },
                    {
                        value: '1',
                        text: 'Absent',
                        selected: receivedStatus === 'Absent'
                    },
                    {
                        value: '2',
                        text: 'Present',
                        selected: receivedStatus === 'Present'
                    },
                    {
                        value: '3',
                        text: 'Permit',
                        selected: receivedStatus === 'Permit'
                    },
                    {
                        value: '4',
                        text: 'Unwell',
                        selected: receivedStatus === 'Unwell'
                    }
                ];

                $.each(statusList, function(index, empAbsenStatusOption) {
                    var option;
                    if (index === 0) {
                        option = $('<option disabled>');
                        option.attr('value', empAbsenStatusOption.value);
                        option.text(`${empAbsenStatusOption.text}`);
                    } else {
                        option = $('<option>');
                        option.attr('value', empAbsenStatusOption.value);
                        option.text(`[${empAbsenStatusOption.value}] ${empAbsenStatusOption.text}`);
                    }

                    if (empAbsenStatusOption.selected) {
                        option.attr('selected', 'selected');
                    }

                    empAbsenStatusSelect.append(option);
                });
            }


            function setAttendeeActionList(response) {
                var attActionSelect = $('#' + modalId + ' select[name="attendance-action"]');
                attActionSelect.empty(); // Clear existing options

                var receivedAct = response.action;
                var actionList = [{
                        value: '',
                        text: 'Select Action',
                        selected: true
                        // selected: receivedAct === ''
                    },
                    {
                        value: '1',
                        text: 'Check-in',
                        selected: false
                        // selected: receivedAct === 'Check-in'
                    },
                    {
                        value: '2',
                        text: 'Check-out',
                        selected: false
                        // selected: receivedAct === 'Check-out'
                    }
                ];

                $.each(actionList, function(index, attActionOption) {
                    var option;
                    if (index === 0) {
                        option = $('<option disabled>', {
                            value: attActionOption.value
                        }).text(attActionOption.text);
                    } else {
                        option = $('<option>', {
                            value: attActionOption.value,
                            text: `[${attActionOption.value}] ${attActionOption.text}`
                        });
                    }

                    if (attActionOption.selected) {
                        option.attr('selected', 'selected');
                    }

                    attActionSelect.append(option);
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
            whichModal = "delete_absenModal";
            const modalSelector = document.querySelector('#' + whichModal);
            const modalToShow = new bootstrap.Modal(modalSelector);

            setTimeout(() => {
                $('.delete-record').on('click', function() {
                    var absenID = $(this).attr('absen_id_value');
                    $('#' + whichModal + ' #absen_id').val(absenID);
                    modalToShow.show();
                });
            }, 200);

        });
    </script>
@endsection
