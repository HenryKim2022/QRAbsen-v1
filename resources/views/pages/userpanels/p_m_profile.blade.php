@php
    $page = Session::get('page');
    $page_title = $page['page_title'];
    $authenticated_user_data = Session::get('authenticated_user_data');
    // dd($authenticated_user_data->toArray());


    $typeValues = ['Guest', 'Admin', 'Karyawan'];    // Convert the text type User (e.g Admin to 1) value to its numeric representation
    $typeIndex = array_search(auth()->user()->type, $typeValues);
    $convertedUserType = $typeIndex !== false ? $typeIndex : null;

@endphp

@extends('layouts.userpanels.v_main')

@section('header_page_cssjs')
    <link rel="stylesheet" type="text/css" href="{{ 'public/vuexy/app-assets/css/pages/page-profile.css' }}">
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

            <div class="container row match-height pr-0">

                <div class="content-body">
                    <!-- profile header -->
                    <div id="user-profile">
                        <div class="row">
                            <div class="col-12 pr-0">
                                <div class="card profile-header mb-2">
                                    <!-- profile cover photo -->
                                    <img class="card-img-top"
                                        src="{{ 'public/vuexy/app-assets/images/profile/user-uploads/timeline.jpg' }}"
                                        alt="User Profile Image" />
                                    <!--/ profile cover photo -->

                                    <div class="position-relative">
                                        <!-- profile picture -->
                                        <div class="profile-img-container d-flex align-items-center">
                                            <div class="profile-img">
                                                <img src="{{ $authenticated_user_data->foto_karyawan == null ? env('APP_DEFAULT_AVATAR') : 'public/avatar/uploads/' . $authenticated_user_data->foto_karyawan }}"
                                                    class="rounded img-fluid" alt="Card image" />
                                            </div>
                                            <!-- profile title -->
                                            <div class="profile-title ml-3">
                                                <h2 class="text-white">
                                                    {{ $authenticated_user_data->na_karyawan ?: 'Pemuda Pancasila :P' }}
                                                </h2>
                                                @php
                                                    $roles = [];
                                                    $role1 =
                                                        $authenticated_user_data->daftar_login->type == 'Admin'
                                                            ? 'WebSite ' . $authenticated_user_data->daftar_login->type
                                                            : $authenticated_user_data->daftar_login->type;
                                                    $role2 = $authenticated_user_data->jabatan;

                                                    // Add the first role to the roles array
                                                    if ($role1) {
                                                        $roles[] = $role1;
                                                    }

                                                    // Add the additional roles from the jabatan relationship
                                                    if ($role2) {
                                                        foreach ($role2 as $role) {
                                                            $roles[] = $role->na_jabatan;
                                                        }
                                                    }

                                                    $allRoles = implode(' & ', $roles);
                                                @endphp

                                                <p class="text-white">
                                                    {{ $allRoles ?: 'Pasukan Rendang' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- tabs pill -->
                                    <div class="profile-header-nav">
                                        <!-- navbar -->
                                        <nav
                                            class="navbar navbar-expand-md navbar-light justify-content-end justify-content-md-between w-100">
                                            <button class="btn btn-icon navbar-toggler" type="button"
                                                aria-controls="navbarSupportedContent"
                                                aria-expanded="false" aria-label="Toggle navigation">
                                                <i data-feather="align-justify" class="font-medium-5"></i>
                                            </button>
                                            {{-- <button class="btn btn-icon navbar-toggler" type="button" data-toggle="collapse"
                                                data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                                                aria-expanded="false" aria-label="Toggle navigation">
                                                <i data-feather="align-justify" class="font-medium-5"></i>
                                            </button>

                                            <!-- collapse  -->
                                            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                                <div
                                                    class="profile-tabs d-flex justify-content-between flex-wrap mt-1 mt-md-0 p-2">


                                                </div>
                                            </div>
                                            <!--/ collapse  --> --}}
                                        </nav>
                                        <!--/ navbar -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/ profile header -->

                    <!-- account setting page -->
                    <section id="page-account-settings">
                        <div class="row">
                            <!-- left menu section -->
                            <div class="col-md-3 mb-2 mb-md-0">
                                <ul class="nav nav-pills flex-column nav-left">
                                    <!-- information -->
                                    <li class="nav-item">
                                        <a class="nav-link active" id="account-pill-info" data-toggle="pill"
                                            href="#account-vertical-profile" aria-expanded="true">
                                            <i data-feather="user" class="font-medium-3 mr-1"></i>
                                            <span class="font-weight-bold">Profile</span>
                                        </a>
                                    </li>

                                    <!-- general -->
                                    <li class="nav-item">
                                        <a class="nav-link" id="account-pill-general" data-toggle="pill"
                                            href="#account-vertical-general" aria-expanded="false">
                                            <i data-feather="edit" class="font-medium-3 mr-1"></i>
                                            <span class="font-weight-bold">Edit BioData</span>
                                        </a>
                                    </li>
                                    <!-- change password -->
                                    <li class="nav-item">
                                        <a class="nav-link" id="account-pill-password" data-toggle="pill"
                                            href="#account-vertical-password" aria-expanded="false">
                                            <i data-feather="lock" class="font-medium-3 mr-1"></i>
                                            <span class="font-weight-bold">Change Account Auth</span>
                                        </a>
                                    </li>


                                </ul>
                            </div>
                            <!--/ left menu section -->

                            <!-- right content section -->
                            <div class="col-md-9 p-0">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="tab-content">

                                            <div class="tab-pane active" id="account-vertical-profile" role="tabpanel"
                                                aria-labelledby="account-pill-info" aria-expanded="false">
                                                <div class="container">
                                                    <table>
                                                        <tbody>
                                                            <tr>
                                                                <td><strong>UserID</strong></td>
                                                                <td class="pl-2">: </td>
                                                                <td>{{ $authenticated_user_data->daftar_login->user_id }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>EmployeeID</strong></td>
                                                                <td class="pl-2">: </td>
                                                                <td>{{ $authenticated_user_data->id_karyawan }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Username</strong></td>
                                                                <td class="pl-2">: </td>
                                                                <td>{{ $authenticated_user_data->daftar_login->username }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Name</strong></td>
                                                                <td class="pl-2">: </td>
                                                                <td>{{ $authenticated_user_data->na_karyawan }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Office Role</strong></td>
                                                                <td class="pl-2">: </td>
                                                                <td>
                                                                    @if ($authenticated_user_data->jabatan->count() > 0)
                                                                        @foreach ($authenticated_user_data->jabatan as $role)
                                                                            {{ $role->na_jabatan }}@if (!$loop->last)
                                                                                ,
                                                                            @endif
                                                                        @endforeach
                                                                    @else
                                                                        N/A
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Email</strong></td>
                                                                <td class="pl-2">: </td>
                                                                <td>{{ $authenticated_user_data->daftar_login->email }}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    {{-- <br><br><br><br><br> --}}
                                                </div>
                                            </div>

                                            <!-- general tab -->
                                            <div role="tabpanel" class="tab-pane" id="account-vertical-general"
                                                aria-labelledby="account-pill-general" aria-expanded="true">
                                                <!-- header media -->
                                                <div class="media">
                                                    <a href="javascript:void(0);" class="mr-25">
                                                        <img src="{{ $authenticated_user_data->foto_karyawan == null ? env('APP_DEFAULT_AVATAR') : 'public/avatar/uploads/' . $authenticated_user_data->foto_karyawan }}"
                                                            id="account-upload-img" class="rounded mr-50" alt="profile image"
                                                            height="80" width="80" />
                                                    </a>
                                                    <!-- upload and reset button -->
                                                    <div class="media-body mt-75 ml-1">
                                                        <label for="account-upload"
                                                            class="btn btn-sm btn-primary mb-75 mr-75">Upload</label>
                                                        <input type="file" id="account-upload" hidden accept="image/png, image/jpeg, image/*" />
                                                        <button
                                                            class="btn btn-sm acc-avatar-reset btn-outline-secondary mb-75">Reset</button>
                                                        <p>Allowed JPG, GIF or PNG. Max size of 800kB</p>
                                                    </div>
                                                    <!--/ upload and reset button -->
                                                </div>
                                                <script>
                                                    document.addEventListener('DOMContentLoaded', function() {
                                                        const uploadInput = document.getElementById('account-upload');
                                                        const uploadedAvatar = document.getElementById('account-upload-img');
                                                        const userId = '{{ $authenticated_user_data->id_karyawan }}';

                                                        uploadInput.addEventListener('change', function() {
                                                            const file = uploadInput.files[0];
                                                            const reader = new FileReader();

                                                            reader.onload = function(e) {
                                                                const uploadedImage = e.target.result;
                                                                uploadedAvatar.src = uploadedImage;

                                                                const formData = new FormData();
                                                                formData.append('id_karyawan', userId);
                                                                formData.append('foto_karyawan', file);

                                                                const xhr = new XMLHttpRequest();
                                                                xhr.open('POST', '{{ route('userPanels.avatar.edit') }}');
                                                                xhr.setRequestHeader('X-CSRF-Token', '{{ csrf_token() }}');
                                                                xhr.onload = function() {
                                                                    const response = JSON.parse(xhr.responseText);
                                                                    if (response.reload) {
                                                                        window.location.reload();
                                                                    }
                                                                };
                                                                xhr.send(formData);
                                                            };

                                                            reader.readAsDataURL(file);
                                                        });


                                                        var userProfilePhotoPreview = uploadedAvatar;
                                                        var userProfilePhotoInput = uploadInput;
                                                        userProfilePhotoInput.addEventListener('change', function() {
                                                            const file = this.files[0];
                                                            if (file && file.type.startsWith('image/')) {
                                                                const img = document.createElement('img');
                                                                img.src = URL.createObjectURL(file);

                                                                img.onload = function() {
                                                                    userProfilePhotoPreview.src = img.src;
                                                                };
                                                            }
                                                        });
                                                        var resetButton = document.querySelector('.acc-avatar-reset');
                                                        resetButton.addEventListener('click', function() {
                                                            userProfilePhotoPreview.src =
                                                                '{{ $authenticated_user_data->foto_karyawan == null ? env('APP_DEFAULT_AVATAR') : 'public/avatar/uploads/' . $authenticated_user_data->foto_karyawan }}';
                                                            userProfilePhotoInput.value = null;
                                                        });
                                                    });
                                                </script>
                                                <!--/ header media -->




                                                <!-- form -->
                                                <form class="validate-form mt-2" action="{{ route('userPanels.biodata.edit') }}" method="POST">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-12 col-sm-6">
                                                            <div class="form-group">
                                                                <input type="hidden" class="form-control" id="id_karyawan"
                                                                name="id_karyawan" placeholder="ID"
                                                                value="{{ $authenticated_user_data->id_karyawan ?: 'My Girlfriend :)' }}" />
                                                                <label for="account-name">Name</label>
                                                                <input type="text" class="form-control" id="account-name"
                                                                    name="account-name" placeholder="Name"
                                                                    value="{{ $authenticated_user_data->na_karyawan ?: 'My Girlfriend :)' }}" />
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-sm-6">
                                                            <div class="form-group">
                                                                <label for="birth-loc">Birth Location</label>
                                                                <input type="text" class="form-control" id="brith-loc"
                                                                    name="birth-loc" placeholder="Location of Birth"
                                                                    value="{{ $authenticated_user_data->tlah_karyawan ?: 'Heaven Residence :)' }}" />
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-sm-6">
                                                            <div class="form-group">
                                                                <label for="birth-date">Birth Date</label>
                                                                <input type="date" class="form-control" id="brith-date"
                                                                    name="birth-date" placeholder="Date of Birth"
                                                                    value="{{ $authenticated_user_data->tglah_karyawan ?: 'Heaven :)' }}" />
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-sm-6">
                                                            <div class="form-group">
                                                                <label>Religion</label>
                                                                <select class="select2 form-control form-control-lg"
                                                                    name="religion" id="religion">
                                                                    <option value=""
                                                                        {{ !$authenticated_user_data->agama_karyawan ? 'selected' : '' }}>
                                                                        Select religion</option>
                                                                    <option value="Islam"
                                                                        {{ $authenticated_user_data->agama_karyawan == 'Islam' ? 'selected' : '' }}>
                                                                        Islam</option>
                                                                    <option value="Kristen"
                                                                        {{ $authenticated_user_data->agama_karyawan == 'Kristen' ? 'selected' : '' }}>
                                                                        Kristen</option>
                                                                    <option value="Hindu"
                                                                        {{ $authenticated_user_data->agama_karyawan == 'Hindu' ? 'selected' : '' }}>
                                                                        Hindu</option>
                                                                    <option value="Buddha"
                                                                        {{ $authenticated_user_data->agama_karyawan == 'Buddha' ? 'selected' : '' }}>
                                                                        Buddha</option>
                                                                    <option value="Konghucu"
                                                                        {{ $authenticated_user_data->agama_karyawan == 'Konghucu' ? 'selected' : '' }}>
                                                                        Konghucu</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-sm-6">
                                                            <div class="form-group">
                                                                <label for="address">Address</label>
                                                                <input type="text" class="form-control" id="address"
                                                                    name="address" placeholder="Address"
                                                                    value="{{ $authenticated_user_data->alamat_karyawan ?: 'Heaven :)' }}" />
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-sm-6">
                                                            <div class="form-group">
                                                                <label for="notelp">No. Telp</label>
                                                                <input type="text" class="form-control" id="notelp"
                                                                    name="notelp" placeholder="No. Telp"
                                                                    value="{{ $authenticated_user_data->notelp_karyawan ?: '+62 ' }}" />
                                                            </div>
                                                        </div>



                                                        <div class="col-12">
                                                            <button type="submit" class="btn btn-primary mt-2 mr-1">Save
                                                                changes</button>
                                                            <button type="reset"
                                                                class="btn btn-outline-secondary mt-2">Cancel</button>
                                                        </div>
                                                    </div>
                                                </form>
                                                <!--/ form -->
                                            </div>
                                            <!--/ general tab -->

                                            <!-- change password -->
                                            <div class="tab-pane fade" id="account-vertical-password" role="tabpanel"
                                                aria-labelledby="account-pill-password" aria-expanded="false">
                                                <!-- form -->
                                                <form class="validate-form" action="{{ route('userPanels.accdata.edit') }}" method="POST">
                                                    @csrf
                                                    <div class="row">
                                                        <!-- HTML -->
                                                        <div class="col-12 col-sm-6">
                                                            <div class="form-group">
                                                                <input type="hidden" class="form-control"
                                                                    id="id" name="user_id"
                                                                    placeholder="ID"
                                                                    value="{{ $authenticated_user_data->daftar_login->user_id }}" />
                                                                <input type="hidden" class="form-control"
                                                                    id="type" name="type"
                                                                    placeholder="TYPE"
                                                                    value="{{ $convertedUserType }}" />
                                                                <label for="account-username">Username</label>
                                                                <input type="text" class="form-control"
                                                                    id="account-username" name="username"
                                                                    placeholder="Username"
                                                                    value="{{ $authenticated_user_data->daftar_login->username }}" />
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-sm-6">
                                                            <div class="form-group">
                                                                <label for="account-e-mail">E-mail</label>
                                                                <input type="email" class="form-control"
                                                                    id="account-e-mail" name="email" placeholder="Email"
                                                                    value="{{ $authenticated_user_data->daftar_login->email }}" />
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-sm-6">
                                                            <div class="form-group">
                                                                <label for="account-retype-new-password"> New
                                                                    Password</label>
                                                                <div
                                                                    class="input-group form-password-toggle input-group-merge">
                                                                    <input type="password" class="form-control"
                                                                        id="account-retype-new-password"
                                                                        name="new-password"
                                                                        placeholder="New Password" />
                                                                    <div class="input-group-append">
                                                                        <div class="input-group-text cursor-pointer">
                                                                            <i data-feather="eye"></i>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>



                                                        <div class="col-12 col-sm-6">
                                                            <div class="form-group">
                                                                <label for="account-retype-new-password">Retype New
                                                                    Password</label>
                                                                <div
                                                                    class="input-group form-password-toggle input-group-merge">
                                                                    <input type="password" class="form-control"
                                                                        id="account-retype-new-password"
                                                                        name="confirm-new-password"
                                                                        placeholder="Retype Password" />
                                                                    <div class="input-group-append">
                                                                        <div class="input-group-text cursor-pointer">
                                                                            <i data-feather="eye"></i>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <button type="submit" class="btn btn-primary mr-1 mt-1">Save
                                                                changes</button>
                                                            <button type="reset"
                                                                class="btn btn-outline-secondary mt-1">Cancel</button>
                                                        </div>
                                                    </div>
                                                </form>
                                                <!--/ form -->
                                            </div>
                                            <!--/ change password -->




                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--/ right content section -->
                        </div>
                    </section>
                    <!-- / account setting page -->

                </div>


            </div>



        </section>


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
@endsection
