<!-- BEGIN: Vendor JS-->
<script src="{{ asset('public/vuexy/app-assets/vendors/js/vendors.min.js') }}"></script>
<!-- BEGIN Vendor JS-->

<!-- BEGIN: Page Vendor JS-->
{{-- <script src="{{ asset('public/vuexy/app-assets/vendors/js/charts/apexcharts.min.js') }}"></script> --}}
<script src="{{ asset('public/vuexy/app-assets/vendors/js/extensions/toastr.min.js') }}"></script>
<!-- END: Page Vendor JS-->

<!-- BEGIN: Theme JS-->
<script src="{{ asset('public/vuexy/app-assets/js/core/app-menu.js') }}"></script>
<script src="{{ asset('public/vuexy/app-assets/js/core/app.js') }}"></script>
<!-- END: Theme JS-->

<!-- BEGIN: Page JS-->
{{-- <script src="{{ asset('public/vuexy/app-assets/js/scripts/pages/dashboard-ecommerce.js') }}"></script> --}}
<script src="{{ asset('public/vuexy/app-assets/js/scripts/components/components-modals.js') }}"></script>
<!-- END: Page JS-->

<script>
    $(window).on('load', function() {
        if (feather) {
            feather.replace({
                width: 14,
                height: 14
            });
        }
    })
</script>

<script>
    $(document).ready(function() {
        // Check if there are elements with the class 'select2' present
        if ($('.select2').length > 0) {
            // Initialize Select2
            $('.select2').select2();
        }
    });
</script>
