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
                        <img class="img-fluid rounded-0" src="{{ 'public/storage/landings/img/landing_image_1.png' }}"
                            alt="">
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
