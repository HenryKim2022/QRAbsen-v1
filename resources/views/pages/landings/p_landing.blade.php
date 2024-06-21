@extends('layouts.landings.v_main')

@section('header_page_cssjs')
    <style>
        .brand-text {
            color: #7367F0 !important;
            margin-bottom: 0;
            font-weight: 600;
            letter-spacing: 0.01rem;
            font-size: 1.45rem;
            -webkit-animation: 0.3s cubic-bezier(0.25, 0.8, 0.25, 1) 0s normal forwards 1 fadein;
            animation: 0.3s cubic-bezier(0.25, 0.8, 0.25, 1) 0s normal forwards 1 fadein;
        }
    </style>
@endsection
@section('footer_page_js')
@endsection

@section('page-content')
    <section id="dashboard-ecommerce">
        <div class="row match-height">
            <!-- Company Landing Image Card -->
            {{-- @guest --}}
            <div class="col-lg-8 col-12">
                {{-- @endguest
                @auth
                    <div class="col-lg-12 col-12">
                    @endauth --}}
                <div class="card card-company-table bg-transparent">
                    <div class="card-body p-0">
                        <img class="card-img-top" src="{{ 'public/storage/landings/img/landing_image_2.png' }}"
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
                                    right: 2.04rem;
                                }
                                .AppMain-img-container .AppMain-title h5{
                                    font-size: 1.2rem;
                                }
                                .AppMain-img-container .AppMain-title p{
                                    font-size: 0.7rem;
                                }
                            }


                            @media (min-width: 768px) {

                                /* Styles for desktops */
                                .AppMain-img-container {
                                    top: -32.04rem;
                                    right: 5.04rem;
                                }

                                .AppMain-img-container .AppMain-title h5{
                                    font-size: 2.5rem;
                                }
                                .AppMain-img-container .AppMain-title p{
                                    font-size: 1.2rem;
                                }
                            }
                        </style>
                        <div class="position-relative">
                            <!-- app picture -->
                            <div class="AppMain-img-container d-flex align-items-center">
                                <!-- app title -->
                                <div class="AppMain-title mr-1">
                                    <h5 class="fw-600 mt-2 mb-0 text-end" style="color: #30334e">
                                        <a>Employee Attende</a>
                                    </h5>
                                    <p class="fw-600 font-italic text-end">"Do not late !"</p>
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
            </div>

            <!-- QRCode Logins/ Logouts Card -->
            <div class="col-lg-4 col-md-6 col-12">
                <div class="card card-developer-meetup">
                    <div class="meetup-img-wrapper rounded-top text-center">
                        @guest
                            <div class="placeholder-text text-muted">ScanQR to Login</div>
                        @endguest
                        @auth
                            <div class="placeholder-text text-muted">ScanQR to Logout</div>
                        @endauth
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
                                    {{ date('h:i A', strtotime('18:01', time() + 8 * 60 * 60)) }}</small>
                            </div>
                        </div>

                        <div class="avatar-group h-auto w-auto d-flex align-items-center justify-content-center">
                            <div data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom"
                                data-original-title="ScanMe :)" class="pull-up">
                                <img class="img-fluid rounded-0 hover-image" src="data:image/png;base64,{{ $loginQRCode }}"
                                    alt="QR Image">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Developer Meetup Card -->


        </div>



    </section>
@endsection
