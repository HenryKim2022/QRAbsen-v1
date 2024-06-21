@php
    $page = Session::get('page');
    $page_title = $page['page_title'];
    $authenticated_user_data = Session::get('authenticated_user_data');
    // dd($authenticated_user_data);

    $data_karyawan_for_absen_in = Session::get('data_karyawan_for_absen_in');
    $data_karyawan_for_absen_out = Session::get('data_karyawan_for_absen_out');

    $loadDataUserFromDB = Session::get('loadDataUserFromDB');

@endphp



<!DOCTYPE html>
<html class="loading dark-layout" lang="en" data-layout="dark-layout" data-textdirection="ltr">
<!-- BEGIN: Head--> @include('layouts.userpanels.v_header') <!-- END: Head-->

<body class="vertical-layout vertical-menu-modern  navbar-floating footer-static  " data-open="click"
    data-menu="vertical-menu-modern" data-col="">
    <!-- BEGIN: Nav-head--> @include('layouts.userpanels.v_topnav') <!-- END: Nav-head-->
    <!-- BEGIN: Nav-side--> @include('layouts.userpanels.v_sidenav') <!-- END: Nav-side-->
    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div id="image-popup" class="modal-dialog-centered-cust col-8 col-sm-6 col-md-4 p-2">
                <span class="close-btn btn btn-sm btn-text-primary rounded-pill btn-icon"><i class="feather feather-x"></i></span>
                <img src="" alt="Large Image" />
            </div>

            @yield('page-content')
        </div>
    </div>
    <!-- END: Content-->

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>
    <!-- BEGIN: Footer--> @include('layouts.userpanels.v_footer') <!-- END: Footer-->




    <!-- BEGIN: Footer JS Coll's--> @include('res.userpanels.v_js_userpanels') <!-- END: Footer JS Coll's-->
    <!-- BEGIN: PAGE JS's--> @yield('footer_page_js') <!-- END: PAGE JS's-->

    <!-- BEGIN: AboutUSModal--> @include('modals.userpanels.v_aboutUsModal') <!-- END: AboutUSModal-->
    <!-- BEGIN: ContactUSModal--> @include('modals.userpanels.v_contactUsModal') <!-- END: ContactUSModal-->





    {{-- ////////////////////////////////////////////////////////////////////// TOAST //////////////////////////////////////////////////////////////////////  --}}
    {{-- TOAST: ERROR/FAILED --}}
    @if ($errors->any())
        @php
            $errorMessages = $errors->all();
        @endphp

        @foreach ($errorMessages as $index => $message)
            @if ($index == 0)
                <input type="hidden" class="error-message" data-delay="{{ ($index + 1) * 0 }}"
                    value="{{ $message }}">
            @else
                <input type="hidden" class="error-message" data-delay="{{ ($index + 1) * 1000 }}"
                    value="{{ $message }}">
            @endif
        @endforeach
    @endif
    <script>
        $(document).ready(function() {
            @if ($errors->any())
                @php
                    $errorMessages = $errors->all();
                @endphp

                @foreach ($errorMessages as $index => $message)
                    var toastErrorMsg_{{ $index }} = "{{ $message }}";
                    var delay_{{ $index }} = {{ ($index + 1) * 1000 }};

                    setTimeout(function() {
                        toastr.error(toastErrorMsg_{{ $index }}, '', {
                            closeButton: false,
                            debug: false,
                            newestOnTop: false,
                            progressBar: true,
                            positionClass: 'toast-top-right',
                            preventDuplicates: false,
                            onclick: null,
                            showDuration: '300',
                            hideDuration: '1000',
                            timeOut: '5000',
                            extendedTimeOut: '1000',
                            showEasing: 'swing',
                            hideEasing: 'linear',
                            showMethod: 'fadeIn',
                            hideMethod: 'fadeOut'
                        });
                    }, delay_{{ $index }});
                @endforeach
            @endif
        });
    </script>


    {{-- TOAST: SUCCESS --}}
    @if (Session::has('success'))
        @foreach (Session::get('success') as $index => $message)
            @if ($index == 1)
                <input type="hidden" class="success-message" data-delay="{{ ($index + 1) * 0 }}"
                    value="{{ $message }}">
            @else
                <input type="hidden" class="success-message" data-delay="{{ ($index + 1) * 1000 }}"
                    value="{{ $message }}">
            @endif
        @endforeach
    @endif

    <script>
        $(document).ready(function() {
            @if (Session::has('success'))
                @foreach (Session::get('success') as $index => $message)
                    var toastSuccessMsg_{{ $index }} = "{{ $message }}";
                    var delay_{{ $index }} = {{ ($index + 1) * 1000 }};

                    setTimeout(function() {
                        toastr.success(toastSuccessMsg_{{ $index }}, '', {
                            closeButton: false,
                            debug: false,
                            newestOnTop: false,
                            progressBar: true,
                            positionClass: 'toast-top-right',
                            preventDuplicates: false,
                            onclick: null,
                            showDuration: '300',
                            hideDuration: '1000',
                            timeOut: '5000',
                            extendedTimeOut: '1000',
                            showEasing: 'swing',
                            hideEasing: 'linear',
                            showMethod: 'fadeIn',
                            hideMethod: 'fadeOut'
                        });
                    }, delay_{{ $index }});
                @endforeach
            @endif
        });
    </script>





    {{-- TOAST: NORMAL ERROR MESSAGE --}}
    @if (Session::has('n_errors'))
        @foreach (Session::get('n_errors') as $index => $message)
            @if ($index == 1)
                <input type="hidden" class="n-error-message" data-delay="{{ ($index + 1) * 0 }}"
                    value="{{ $message }}">
            @else
                <input type="hidden" class="n-error-message" data-delay="{{ ($index + 1) * 1000 }}"
                    value="{{ $message }}">
            @endif
        @endforeach
    @endif
    <script>
        $(document).ready(function() {
            @if (Session::has('n_errors'))
                @foreach (Session::get('n_errors') as $index => $message)
                    var toastNErrorMsg_{{ $index }} = "{{ $message }}";
                    var delay_{{ $index }} = {{ ($index + 1) * 1000 }};

                    setTimeout(function() {
                        toastr.error(toastNErrorMsg_{{ $index }}, '', {
                            closeButton: false,
                            debug: false,
                            newestOnTop: false,
                            progressBar: true,
                            positionClass: 'toast-top-right',
                            preventDuplicates: false,
                            onclick: null,
                            showDuration: '300',
                            hideDuration: '1000',
                            timeOut: '5000',
                            extendedTimeOut: '1000',
                            showEasing: 'swing',
                            hideEasing: 'linear',
                            showMethod: 'fadeIn',
                            hideMethod: 'fadeOut'
                        });
                    }, delay_{{ $index }});
                @endforeach
            @endif
        });
    </script>

    {{-- ////////////////////////////////////////////////////////////////////// ./TOAST //////////////////////////////////////////////////////////////////////  --}}




    <!-- AbsenIn Modal -->
    @if ($data_karyawan_for_absen_in && $data_karyawan_for_absen_in['id_karyawan_for_absen'])
        <div class="modal fade" id="qrCodeModal_In" tabindex="-1" role="dialog" aria-labelledby="qrCodeModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="qrCodeModalLabel">CheckIn Your Attendance</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('userPanels.absen.do.in') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            {{-- $idKaryawanForAbsen  --}}
                            <!--  <img src="{ Session::get('data')['qr_code_link'] }}" alt="QR Code"> -->

                            <div class="row g-1">
                                <div class="col-xl-4 col-md-4 col-12 pr-0">
                                    <div class="form-group">
                                        <label class="form-label" for="absen-karyawan-id">ID Karyawan</label>
                                        <div class="input-group input-group-merge form-password-toggle">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text cursor-pointer">
                                                    <i data-feather="user"></i>
                                                </span>
                                            </div>
                                            <input class="form-control form-control-merge" id="absen-karyawan-id" type="text"
                                                name="absen-karyawan-id" placeholder="············" aria-describedby="absen-karyawan-id"
                                                tabindex="1" value="{{ $data_karyawan_for_absen_in['data_karyawan']->id_karyawan ?? '' }}"
                                                readonly />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-8 col-md-8 col-12">
                                    <div class="form-group">
                                        <label class="form-label" for="absen-karyawan-name">Employee Name</label>
                                        <div class="input-group input-group-merge form-password-toggle">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text cursor-pointer">
                                                    <i data-feather="user"></i>
                                                </span>
                                            </div>
                                            <input class="form-control form-control-merge" id="absen-karyawan-name" type="text"
                                                name="absen-karyawan-name" placeholder="············" aria-describedby="absen-karyawan-name"
                                                tabindex="3" value="{{ $data_karyawan_for_absen_in['data_karyawan']->na_karyawan ?? '' }}"
                                                readonly />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-12 col-md-12 col-12">
                                    <div class="form-group">
                                        <label>Attendance Status</label>
                                        <select class="select2 form-control form-control-lg" name="attendance-status">
                                            <option value="" selected disabled>Select status</option>
                                            <option value="1">absent</option>
                                            <option value="2">present</option>
                                            <option value="3">permit</option>
                                            <option value="4">unwell</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-xl-12 col-md-12 col-12">
                                    <div class="form-group">
                                        <label class="form-label" for="absen-karyawan-reason">Reason</label>
                                        <textarea class="form-control form-control-merge" id="absen-karyawan-reason"
                                            name="absen-karyawan-reason" placeholder="e.g. Sakit diare parah"
                                            aria-describedby="absen-karyawan-reason" tabindex="4"></textarea>
                                    </div>
                                </div>

                                <div class="col-xl-12 col-md-12 col-12">
                                    <div class="form-group">
                                        <label class="form-label" for="absen-karyawan-proof">Proof</label>
                                        <input type="file" class="form-control form-control-merge" id="absen-karyawan-proof"
                                            name="absen-karyawan-proof" aria-describedby="absen-karyawan-proof" tabindex="5">
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


                </div>
            </div>
        </div>

        <!-- JavaScript code to show the modal -->
        <script>
            $(document).ready(function() {
                $('#qrCodeModal_In').modal('show');
                {!! Session::forget('data_karyawan_for_absen_in') !!}
            });
        </script>
    @endif


        <!-- AbsenOut Modal -->
    @if ($data_karyawan_for_absen_out && $data_karyawan_for_absen_out['id_karyawan_for_absen'])
        <div class="modal fade" id="qrCodeModal_Out" tabindex="-1" role="dialog" aria-labelledby="qrCodeModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="qrCodeModalLabel">CheckOut Your Attendance</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('userPanels.absen.do.out') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            {{-- $idKaryawanForAbsen  --}}
                            <!--  <img src="{ Session::get('data')['qr_code_link'] }}" alt="QR Code"> -->

                            <div class="row g-1">
                                <div class="col-xl-4 col-md-4 col-12 pr-0">
                                    <div class="form-group">
                                        <label class="form-label" for="absen-karyawan-id">ID Karyawan</label>
                                        <div class="input-group input-group-merge form-password-toggle">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text cursor-pointer">
                                                    <i data-feather="user"></i>
                                                </span>
                                            </div>
                                            <input class="form-control form-control-merge" id="absen-karyawan-id" type="text"
                                                name="absen-karyawan-id" placeholder="e.g 00000000" aria-describedby="absen-karyawan-id"
                                                tabindex="1" value="{{ $data_karyawan_for_absen_out['data_karyawan']->id_karyawan ?? '' }}"
                                                readonly />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-8 col-md-8 col-12">
                                    <div class="form-group">
                                        <label class="form-label" for="absen-karyawan-name">Employee Name</label>
                                        <div class="input-group input-group-merge form-password-toggle">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text cursor-pointer">
                                                    <i data-feather="user"></i>
                                                </span>
                                            </div>
                                            <input class="form-control form-control-merge" id="absen-karyawan-name" type="text"
                                                name="absen-karyawan-name" placeholder="e.g henry" aria-describedby="absen-karyawan-name"
                                                tabindex="3" value="{{ $data_karyawan_for_absen_out['data_karyawan']->na_karyawan ?? '' }}"
                                                readonly />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-12 col-md-12 col-12">
                                    <div class="form-group">
                                        <label>Attendance Status</label>
                                        <select class="select2 form-control form-control-lg" name="attendance-status">
                                            <option value="" selected disabled>Select status</option>
                                            <option value="1">absent</option>
                                            <option value="2">present</option>
                                            <option value="3">permit</option>
                                            <option value="4">unwell</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-xl-12 col-md-12 col-12">
                                    <div class="form-group">
                                        <label class="form-label" for="absen-karyawan-reason">Reason</label>
                                        <textarea class="form-control form-control-merge" id="absen-karyawan-reason"
                                            name="absen-karyawan-reason" placeholder="e.g. Sakit diare parah"
                                            aria-describedby="absen-karyawan-reason" tabindex="4"></textarea>
                                    </div>
                                </div>

                                <div class="col-xl-12 col-md-12 col-12">
                                    <div class="form-group">
                                        <label class="form-label" for="absen-karyawan-proof">Proof</label>
                                        <input type="file" class="form-control form-control-merge" id="absen-karyawan-proof"
                                            name="absen-karyawan-proof" aria-describedby="absen-karyawan-proof" tabindex="5">
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


                </div>
            </div>
        </div>

        <!-- JavaScript code to show the modal -->
        <script>
            $(document).ready(function() {
                $('#qrCodeModal_Out').modal('show');
                {!! Session::forget('data_karyawan_for_absen_out') !!}
            });
        </script>
    @endif



</body>

</html>
