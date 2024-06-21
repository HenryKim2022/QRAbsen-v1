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
                            <div class="placeholder-text text-muted">ScanQR to Check-in</div>
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
                                    data-original-title="ScanMe :)" class="pull-up">
                                    <img class="img-fluid rounded-0 hover-image"
                                        src="data:image/png;base64,{{ $checkInQRCode }}" alt="QR Image">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/ QRCodeCheck-in Card -->

                <!-- Company Landing Image Card -->
                <div class="col-lg-4 col-12 h-100">
                    <div class="row">
                        <div class="card card-company-table bg-transparent">
                            <div class="card-body p-0">
                                <img class="img-fluid rounded-0" src="{{ 'public/storage/landings/img/landing_image_1.png' }}"
                                    alt="">
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

                    </div>
                </div>


                <!-- QRCodeCheck-out Card -->
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="card card-developer-meetup">
                        <div class="meetup-img-wrapper rounded-top text-center">
                            <div class="placeholder-text text-muted">ScanQR to Check-out</div>
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
                                    data-original-title="ScanMe :)" class="pull-up">
                                    <img class="img-fluid rounded-0 hover-image"
                                        src="data:image/png;base64,{{ $checkOutQRCode }}" alt="QR Image">
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
                                                        <img src="{{ $absen->bukti }}" alt="Proof 0"
                                                            style="height: 24px; width: 24px;" class="hover-image">
                                                    </div>
                                                @else
                                                    -
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
        // Set the current time and target time
        const currentTime = new Date();
        const targetDate = new Date();
        targetDate.setHours(17, 1, 0, 0); // Set the target time to 5:01 PM

        // If the target time has already passed for today, move it to tomorrow
        if (targetDate <= currentTime) {
            targetDate.setDate(targetDate.getDate() + 1);
        }
        // Start the countdown timer with the provided targetDate value
        function startCountdown(targetDate) {
            // Update the countdown every second
            const countdown = setInterval(() => {
                const now = new Date().getTime();
                const timeRemaining = targetDate - now;

                // Calculate days, hours, minutes, and seconds remaining
                const days = Math.floor(timeRemaining / (1000 * 60 * 60 * 24));
                const hours = Math.floor((timeRemaining % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((timeRemaining % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((timeRemaining % (1000 * 60)) / 1000);

                // Update the countdown timer display
                updateTimer('.countdown-timer .days', days);
                updateTimer('.countdown-timer .hours', hours);
                updateTimer('.countdown-timer .minutes', minutes);
                updateTimer('.countdown-timer .seconds', seconds);

                // Stop the countdown when the target date is reached
                if (timeRemaining < 0) {
                    clearInterval(countdown);
                    // Display any desired message when the countdown ends
                    document.querySelector('.countdown-timer').textContent = "Countdown Finished!";
                }
            }, 1000);
        }
        // Helper function to update individual timer digits
        function updateTimer(selector, value) {
            document.querySelector(selector + ' .value').textContent = value.toString().padStart(2, '0');
        }
        // Start the countdown with the targetDate value
        startCountdown(targetDate);
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
