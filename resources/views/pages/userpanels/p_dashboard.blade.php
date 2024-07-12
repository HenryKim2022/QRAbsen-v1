@php
    $page = Session::get('page');
    $page_title = $page['page_title'];
    // $authenticated_user_data = Session::get('authenticated_user_data');
@endphp

@extends('layouts.userpanels.v_main')

@section('header_page_cssjs')
@endsection


@section('page-content')
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
                <!-- QRCodeCheck-in Card -->
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="card card-developer-meetup">
                        <div class="meetup-img-wrapper rounded-top text-center">
                            {{-- <div class="placeholder-text text-muted">ScanQR to Check-in</div> --}}
                            <div class="placeholder-text text-muted">For Check-in</div>
                        </div>
                        <div class="card-body">
                            <div class="media">
                                <div class="avatar bg-light-primary rounded mr-1">
                                    <div class="avatar-content">
                                        <i data-feather="calendar" class="avatar-icon font-medium-3"></i>
                                    </div>
                                </div>
                                <div class="media-body">
                                    <h6 class="mb-0">{{ date('D, M j, Y') }}</h6>
                                    <small>{{ date('h:i A', strtotime('07:59')) }} to
                                        {{ date('h:i A', strtotime('17:01', time() + 8 * 60 * 60)) }}</small>
                                </div>
                            </div>

                            <div class="avatar-group h-auto w-auto d-flex align-items-center justify-content-center">
                                <div data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom"
                                    data-original-title="ClickMe :)" class="pull-up">
                                    {{-- <img class="img-fluid rounded-0 hover-qr-image"
                                        src="data:image/png;base64,{{ $checkInQRCode }}" alt="QR Image"> --}}
                                        <a href="{{ $checkInQRCode }}">
                                            <button class="btn btn-sm btn-danger"> Check In </button>
                                        </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/ QRCodeCheck-in Card -->

                <!-- Company Landing Image Card -->
                <div class="col-lg-4 col-12 h-100 px-0">
                    {{-- <div class="row"> --}}
                    {{-- <div class="card card-company-table bg-transparent">
                            <div class="card-body p-0">
                                <img class="img-fluid rounded-0" src="{{ 'public/storage/landings/img/landing_image_1.png' }}"
                                    alt="">
                            </div>
                        </div> --}}
                    <div class="card card-company-table bg-transparent">
                        <div class="card-body p-0">
                            <img class="card-img-top col-lg-12" src="{{ 'public/storage/landings/img/landing_image_2.png' }}"
                                alt="AppMain Image" />
                            <style>
                                .AppMain-img-container {
                                    position: absolute;
                                    color: #30334e;
                                    bottom: 5.6rem;
                                    right: 1.04rem;
                                    z-index: 2;
                                    top: -12.04rem;
                                }

                                .fw-600 {
                                    font-weight: 600;
                                }

                                .fw-250 {
                                    font-weight: 250;
                                }

                                .text-end {
                                    text-align: end;
                                }

                                @media (max-width: 767px) {

                                    /* Styles for smartphone */
                                    .AppMain-img-container {
                                        right: 3.04rem;
                                    }
                                }


                                @media (min-width: 768px) {
                                    /* Styles for desktops */
                                    .AppMain-img-container {
                                        top: -10.04rem;
                                        right: 1.64rem;
                                    }
                                }
                            </style>
                            <div class="position-relative d-none">
                                <!-- app picture -->
                                <div class="AppMain-img-container d-flex align-items-center">
                                    <!-- app title -->
                                    <div class="AppMain-title mr-1">
                                        <h5 class="fw-600 mt-2 mb-0 text-end" style="color: #30334e">
                                            <a>Employee Attende</a>
                                        </h5>
                                        <p class="font-small-1 fw-600 font-italic text-end">"Do not late !"</p>
                                    </div>
                                    <!-- app img -->
                                    <div class="AppMain-img">
                                        <svg viewBox="0 0 139 95" version="1.1" xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink" height="24">
                                            <defs>
                                                <linearGradient id="linearGradient-1" x1="100%" y1="10.5120544%"
                                                    x2="50%" y2="89.4879456%">
                                                    <stop stop-color="#000000" offset="0%"></stop>
                                                    <stop stop-color="#FFFFFF" offset="100%"></stop>
                                                </linearGradient>
                                                <linearGradient id="linearGradient-2" x1="64.0437835%" y1="46.3276743%"
                                                    x2="37.373316%" y2="100%">
                                                    <stop stop-color="#EEEEEE" stop-opacity="0" offset="0%"></stop>
                                                    <stop stop-color="#FFFFFF" offset="100%"></stop>
                                                </linearGradient>
                                            </defs>
                                            <g id="Page-1" stroke="none" stroke-width="1" fill="none"
                                                fill-rule="evenodd">
                                                <g id="Artboard" transform="translate(-400.000000, -178.000000)">
                                                    <g id="Group" transform="translate(400.000000, 178.000000)">
                                                        <path class="text-primary" id="Path"
                                                            d="M-5.68434189e-14,2.84217094e-14 L39.1816085,2.84217094e-14 L69.3453773,32.2519224 L101.428699,2.84217094e-14 L138.784583,2.84217094e-14 L138.784199,29.8015838 C137.958931,37.3510206 135.784352,42.5567762 132.260463,45.4188507 C128.736573,48.2809251 112.33867,64.5239941 83.0667527,94.1480575 L56.2750821,94.1480575 L6.71554594,44.4188507 C2.46876683,39.9813776 0.345377275,35.1089553 0.345377275,29.8015838 C0.345377275,24.4942122 0.230251516,14.560351 -5.68434189e-14,2.84217094e-14 Z"
                                                            style="fill:currentColor"></path>
                                                        <path id="Path1"
                                                            d="M69.3453773,32.2519224 L101.428699,1.42108547e-14 L138.784583,1.42108547e-14 L138.784199,29.8015838 C137.958931,37.3510206 135.784352,42.5567762 132.260463,45.4188507 C128.736573,48.2809251 112.33867,64.5239941 83.0667527,94.1480575 L56.2750821,94.1480575 L32.8435758,70.5039241 L69.3453773,32.2519224 Z"
                                                            fill="url(#linearGradient-1)" opacity="0.2"></path>
                                                        <polygon id="Path-2" fill="#000000" opacity="0.049999997"
                                                            points="69.3922914 32.4202615 32.8435758 70.5039241 54.0490008 16.1851325">
                                                        </polygon>
                                                        <polygon id="Path-21" fill="#000000" opacity="0.099999994"
                                                            points="69.3922914 32.4202615 32.8435758 70.5039241 58.3683556 20.7402338">
                                                        </polygon>
                                                        <polygon id="Path-3" fill="url(#linearGradient-2)"
                                                            opacity="0.099999994"
                                                            points="101.428699 0 83.0667527 94.1480575 130.378721 47.0740288">
                                                        </polygon>
                                                    </g>
                                                </g>
                                            </g>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Countdown Card -->
                    <div class="card card-company-table bg-transparent col-12">
                        <div class="card-body w-100">
                            <div class="d-flex justify-content-center align-self-center countdown-timer">
                                <div class="digit days reserve-3d text-center mr-2">
                                    <div class="label"><a class="font-small-4">Days</a></div>
                                    <div class="value">00</div>
                                </div>
                                <div class="digit hours reserve-3d text-center mr-2">
                                    <div class="label"><a class="font-small-4">Hours</a></div>
                                    <div class="value">00</div>
                                </div>
                                <div class="digit minutes reserve-3d text-center mr-2">
                                    <div class="label"><a class="font-small-4">Minutes</a></div>
                                    <div class="value">00</div>
                                </div>
                                <div class="digit seconds reserve-3d text-center">
                                    <div class="label"><a class="font-small-4">Seconds</a></div>
                                    <div class="value">00</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/ Countdown Card -->

                    {{-- </div> --}}
                </div>


                <!-- QRCodeCheck-out Card -->
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="card card-developer-meetup">
                        <div class="meetup-img-wrapper rounded-top text-center">
                            {{-- <div class="placeholder-text text-muted">ScanQR to Check-out</div> --}}
                            <div class="placeholder-text text-muted">For Check-out</div>
                        </div>
                        <div class="card-body">
                            <div class="media">
                                <div class="avatar bg-light-primary rounded mr-1">
                                    <div class="avatar-content">
                                        <i data-feather="calendar" class="avatar-icon font-medium-3"></i>
                                    </div>
                                </div>
                                <div class="media-body">
                                    <h6 class="mb-0">{{ date('D, M j, Y') }}</h6>
                                    <small>{{ date('h:i A', strtotime('07:59')) }} to
                                        {{ date('h:i A', strtotime('17:01', time() + 8 * 60 * 60)) }}</small>
                                </div>
                            </div>

                            <div class="avatar-group h-auto w-auto d-flex align-items-center justify-content-center">
                                <div data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom"
                                    data-original-title="ClickMe :)" class="pull-up">
                                    {{-- <img class="img-fluid rounded-0 hover-qr-image"
                                        src="data:image/png;base64,{{ $checkOutQRCode }}" alt="QR Image"> --}}
                                        <a href="{{ $checkOutQRCode }}">
                                            <button class="btn btn-sm btn-danger"> Check Out </button>
                                        </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/ QRCodeCheck-out Card -->

                <!-- TableAbsen Card -->
                <div class="col-lg-12 col-md-12 col-12">
                    <div class="card card-developer-meetup">
                        <div class="card-body p-1">
                            <table id="dashboardKaryawanTable" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Employee Name</th>
                                        <th>Status</th>
                                        <th>Details</th>
                                        <th>Proof</th>
                                        <th>Check-in</th>
                                        <th>Check-out</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($loadAbsenFromDB as $absen)
                                        <tr>
                                            <td>{{ $absen->karyawan->na_karyawan ?: '-' }}</td>
                                            <td>{{ $absen->status ?: '-' }}</td>
                                            <td>{{ $absen->detail ?: '-' }}</td>
                                            <td>
                                                @if ($absen->bukti)
                                                    <div class="d-flex align-items-center justify-content-around">
                                                        <img src="{{ asset('public/absen/uploads/proof/' . $absen->bukti) }}" alt="Proof 0"
                                                            style="height: 24px; width: 24px;" class="hover-image">
                                                    </div>
                                                @else
                                                <div class="d-flex align-items-center justify-content-around">
                                                    -
                                                </div>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($absen->checkin)
                                                    {{ \Carbon\Carbon::parse($absen->checkin)->isoFormat('dddd, DD MMMM YYYY, h:mm:ss A') }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                @if ($absen->checkout)
                                                    {{ \Carbon\Carbon::parse($absen->checkout)->isoFormat('dddd, DD MMMM YYYY, h:mm:ss A') }}
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


    @endauth
@endsection


@section('footer_page_js')
    <script src="{{ 'public/vuexy/app-assets/js/scripts/components/components-modals.js' }}"></script>


    <script>
        // Set the current time, target time, and stop time
        const currentTime = new Date();
        const targetDate = new Date();
        targetDate.setHours(6, 0, 0, 0); // Set the target time to 06:00 AM
        const stopTime = new Date();
        stopTime.setHours(0, 0, 0, 0); // Set the stop time to 00:00 AM (midnight)

        // If the target time or stop time has already passed for today, move them to tomorrow
        if (targetDate <= currentTime) {
            targetDate.setDate(targetDate.getDate() + 1);
        }
        if (stopTime <= currentTime) {
            stopTime.setDate(stopTime.getDate() + 1);
        }

        // Start the countdown timer with the provided targetDate and stopTime values
        function startCountdown(targetDate, stopTime) {
            // Update the countdown every second
            const countdown = setInterval(() => {
                const now = new Date().getTime();
                const timeRemaining = targetDate - now;

                // Calculate hours, minutes, and seconds remaining
                const hours = Math.floor((timeRemaining % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((timeRemaining % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((timeRemaining % (1000 * 60)) / 1000);

                // Update the countdown timer display
                updateTimer('.countdown-timer .hours', hours);
                updateTimer('.countdown-timer .minutes', minutes);
                updateTimer('.countdown-timer .seconds', seconds);

                // Stop the countdown when the stop time is reached
                if (now >= stopTime) {
                    clearInterval(countdown);
                    // Display any desired message when the countdown stops
                    document.querySelector('.countdown-timer').textContent = "Countdown Stopped!";
                }
            }, 1000);
        }

        // Helper function to update individual timer digits
        function updateTimer(selector, value) {
            document.querySelector(selector + ' .value').textContent = value.toString().padStart(2, '0');
        }

        // Start the countdown with the targetDate and stopTime values
        startCountdown(targetDate, stopTime);
    </script>

    @auth
        <script>
            $(document).ready(function() {
                $('#dashboardKaryawanTable').DataTable({
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
    @endauth
@endsection
