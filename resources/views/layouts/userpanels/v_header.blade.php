<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
    <meta name="description"
        content="Vuexy admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords"
        content="admin template, Vuexy admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="PIXINVENT">
    <title>{{ $page_title }}</title>
    <link rel="apple-touch-icon" href="{{ asset('public/vuexy/app-assets/images/ico/favicon.ico') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('public/vuexy/app-assets/images/ico/favicon.ico') }}">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600"
        rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('public/vuexy/app-assets/vendors/css/vendors.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('public/vuexy/app-assets/vendors/css/charts/apexcharts.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('public/vuexy/app-assets/vendors/css/extensions/toastr.min.css') }}">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: DataTables Vendor CSS-->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('public/vuexy/app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('public/vuexy/app-assets/vendors/css/tables/datatable/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('public/vuexy/app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('public/vuexy/app-assets/vendors/css/tables/datatable/rowGroup.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('public/vuexy/app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css') }}">
    <!-- END: DataTables Vendor CSS-->

    <!-- BEGIN: Select2 Vendor CSS-->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('public/vuexy/app-assets/vendors/css/forms/select/select2.min.css') }}">
    <!-- END: Select2 Vendor CSS-->


    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('public/vuexy/app-assets/css/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/vuexy/app-assets/css/bootstrap-extended.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/vuexy/app-assets/css/colors.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/vuexy/app-assets/css/components.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/vuexy/app-assets/css/themes/dark-layout.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('public/vuexy/app-assets/css/themes/bordered-layout.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('public/vuexy/app-assets/css/themes/semi-dark-layout.css') }}">

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('public/vuexy/app-assets/css/core/menu/menu-types/vertical-menu.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('public/vuexy/app-assets/css/pages/dashboard-ecommerce.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('public/vuexy/app-assets/css/plugins/charts/chart-apex.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('public/vuexy/app-assets/css/plugins/extensions/ext-component-toastr.css') }}">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('public/vuexy/assets/css/style.css') }}">
    <style>
         @-moz-document url-prefix() {
            input[type="text"].dark-mode,
            input[type="email"].dark-mode,
            input[type="password"].dark-mode {
                background-color: #343a40;
                color: #fff;
            }
        }

        .modal-dialog-centered-cust {
            display: flex;
            align-items: center;
            min-height: fit-content;
        }

        .hover-image {
            cursor: pointer;
        }

        #image-popup {
            display: none;
            position: fixed;
            padding: 10px;
            background-clip: padding-box;
            background-color: #30334e;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            border: 1px solid rgba(20, 21, 33, 0.175);
            border-radius: 0.625rem;
            outline: 0;
            z-index: 9999;
        }
        .dark-layout #image-popup {
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            border: 1px solid rgba(20, 21, 33, 0.175);
        }
        .light-layout .dark-layout #image-popup {
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            border: 1px solid rgba(20, 21, 33, 0.175);
        }

        #image-popup img {
            width: 100%;
        }

        #image-popup .close-btn {
            position: absolute;
            top: 0.15rem;
            right: 0.15rem;
            cursor: pointer;
            color: #fff;
            background-color: rgba(248, 23, 23, 0.267);
        }

        #image-popup .close-btn:hover {
            background-color: rgba(248, 23, 23, 0.945);
        }
    </style>
    <!-- END: Custom CSS-->

    @yield('header_page_cssjs')
</head>
