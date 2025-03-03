<!-- BEGIN: Footer-->
<footer class="footer footer-static footer-light">
    @if ($site_name)
        <p class="clearfix mb-0">
            <span class="float-md-left d-block d-md-inline-block mt-25 text-sm-center text-md-center text-center">
                COPYRIGHT &copy; {{ $site_year->text_setting }}<a class="ml-25" href="{{ $site_name->url_setting }}"
                    target="_blank">{{ $site_name->text_setting }}</a>
                <span class="d-none d-sm-inline-block">, All rights Reserved</span>
            </span>
            {{-- <span class="float-md-right d-none d-md-block">Hand-crafted & Made with<i data-feather="heart"></i></span> --}}
            <span class="float-md-right d-none d-md-block">Technopex {{ $site_year->text_setting }}</i></span>
        </p>
    @endif
</footer>
<button class="btn btn-primary btn-icon scroll-top" type="button"><i data-feather="arrow-up"></i></button>
<!-- END: Footer-->
