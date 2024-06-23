<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') | {{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('img/favicon.ico') }}">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('themes/backend/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">


    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="{{ asset('themes/backend/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- SweetAlert2 -->
    <link rel="stylesheet"
        href="{{ asset('themes/backend/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('themes/backend/plugins/toastr/toastr.min.css') }}">
    <!-- DataTables -->
    <link rel="stylesheet"
        href="{{ asset('themes/backend/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('themes/backend/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('themes/backend/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="{{ asset('themes/backend/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet"
        href="{{ asset('themes/backend/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') }}">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet"
        href="{{ asset('themes/backend/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('themes/backend/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('themes/backend/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

    <!-- bootstrap datepicker -->
    <link rel="stylesheet"
        href="{{ asset('themes/backend/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">

    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('themes/backend/dist/css/adminlte.min.css') }}">
    <style>
        @media (min-width: 768px) {
            .col-form-label {
                text-align: right;
            }
        }

        .form-group.has-error label {
            color: #dd4b39;
        }

        .form-group.has-error .form-control,
        .form-group.has-error .input-group-addon {
            border-color: #dd4b39;
            box-shadow: none;
        }

        .form-group.has-error .help-block {
            color: #dd4b39;
        }

        .help-block {
            display: block;
            margin-top: 5px;
            margin-bottom: 10px;
        }

        .toast {
            min-width: 300px;
        }

        .select2 {
            width: 100% !important;
        }

        .form-group.has-error .select2-container span.selection span.select2-selection.select2-selection--single {
            border-color: #dd4b39;
            box-shadow: none;
        }

        .input-group.date-time.has-error .form-control {
            border-color: #dd4b39;
            box-shadow: none;
        }

        .input-group.date-time.has-error>.help-block {
            color: #dd4b39;
        }

        .content-header h1 {
            font-size: 1.5rem;
        }

        .content-header {
            padding: 5px .5rem;
        }

        .brand-link {
            line-height: 1.9;
        }

        .card-primary.card-outline {
            border-top: 3px solid #009f4b;
        }

        .btn-primary {
            background-color: #009f4b;
            border-color: #009f4b;
        }

        .btn-primary:hover {
            background-color: #009f4b;
            border-color: #009f4b;
        }

        .sidebar-dark-primary .nav-sidebar>.nav-item>.nav-link.active,
        .sidebar-light-primary .nav-sidebar>.nav-item>.nav-link.active {
            background-color: #009f4b;
        }

        a {
            color: #009f4b;
        }

        .brand-link {
            line-height: 1.5;
        }

        .btn-primary:not(:disabled):not(.disabled).active,
        .btn-primary:not(:disabled):not(.disabled):active,
        .show>.btn-primary.dropdown-toggle {
            background-color: #009f4b;
            border-color: #009f4b;
        }

        .navbar-light .navbar-nav .nav-link {
            color: rgb(0 159 75);
        }

        .dropdown-item.active,
        .dropdown-item:active {
            background-color: #009f4b;
        }

        .navbar-light .navbar-nav .nav-link:focus,
        .navbar-light .navbar-nav .nav-link:hover {
            color: rgb(0 159 75);
        }

        .bg-gradient-primary {
            background: #009f4b linear-gradient(180deg, #009f4b, #009f4b) repeat-x !important;
            color: #fff;
        }

        .bg-gradient-primary.btn.active,
        .bg-gradient-primary.btn:active,
        .bg-gradient-primary.btn:not(:disabled):not(.disabled).active,
        .bg-gradient-primary.btn:not(:disabled):not(.disabled):active {
            background: #009f4b linear-gradient(180deg, #009f4b, #009f4b) repeat-x !important;
            border-color: #009f4b;
        }

        .bg-gradient-primary.btn:hover {
            background: #009f4b linear-gradient(180deg, #009f4b, #009f4b) repeat-x !important;
            border-color: #009f4b;
        }

        .btn-primary.focus,
        .btn-primary:focus {
            background-color: #009f4b;
            border-color: #009f4b;
            box-shadow: 0 0 0 0 rgb(0 159 75);
        }

        .select2-container--default .select2-results__option--highlighted[aria-selected],
        .select2-container--default .select2-results__option--highlighted[aria-selected]:hover {
            background-color: #009f4b;
        }

        .datepicker table tr td.active,
        .datepicker table tr td.active.disabled,
        .datepicker table tr td.active.disabled:hover,
        .datepicker table tr td.active:hover {
            background-color: #009f4b;
            background-image: -moz-linear-gradient(to bottom, #009f4b, #009f4b);
            background-image: -ms-linear-gradient(to bottom, #009f4b, #009f4b);
            background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#009f4b), to(#009f4b));
            background-image: -webkit-linear-gradient(to bottom, #009f4b, #009f4b);
            background-image: -o-linear-gradient(to bottom, #009f4b, #009f4b);
            background-image: linear-gradient(to bottom, #009f4b, #009f4b);
            background-repeat: repeat-x;
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#08c', endColorstr='#0044cc', GradientType=0);
            border-color: #009f4b #009f4b #009f4b;
            border-color: rgb(0 159 75) rgb(2, 160, 76) rgb(2, 160, 76);
            filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
            color: #fff;
            text-shadow: 0 -1px 0 rgb(2, 160, 76);
        }

        .datepicker table tr td.active.active,
        .datepicker table tr td.active.disabled,
        .datepicker table tr td.active.disabled.active,
        .datepicker table tr td.active.disabled.disabled,
        .datepicker table tr td.active.disabled:active,
        .datepicker table tr td.active.disabled:hover,
        .datepicker table tr td.active.disabled:hover.active,
        .datepicker table tr td.active.disabled:hover.disabled,
        .datepicker table tr td.active.disabled:hover:active,
        .datepicker table tr td.active.disabled:hover:hover,
        .datepicker table tr td.active.disabled:hover[disabled],
        .datepicker table tr td.active.disabled[disabled],
        .datepicker table tr td.active:active,
        .datepicker table tr td.active:hover,
        .datepicker table tr td.active:hover.active,
        .datepicker table tr td.active:hover.disabled,
        .datepicker table tr td.active:hover:active,
        .datepicker table tr td.active:hover:hover,
        .datepicker table tr td.active:hover[disabled],
        .datepicker table tr td.active[disabled] {
            background-color: #009f4b;
        }

        fieldset {
            display: block;
            margin-inline-start: 2px;
            margin-inline-end: 2px;
            padding-block-start: 0.35em;
            padding-inline-start: 0.75em;
            padding-inline-end: 0.75em;
            padding-block-end: 0.625em;
            min-inline-size: min-content;
            border-width: 2px;
            border-style: groove;
            border-color: threedface;
            border-image: initial;
            padding-bottom: 0;
        }

        legend {
            width: auto;
            margin-bottom: 0;
        }

        table.dataTable.dtr-inline.collapsed>tbody>tr>td.dtr-control:before,
        table.dataTable.dtr-inline.collapsed>tbody>tr>th.dtr-control:before {
            background-color: #009f4b;
        }

        [class*=sidebar-dark] .brand-link,
        [class*=sidebar-dark] .brand-link .pushmenu {
            color: rgb(0 159 75);
            background: #fff;
        }

        [class*=sidebar-dark] .brand-link .pushmenu:hover,
        [class*=sidebar-dark] .brand-link:hover {
            color: #009f4b;
        }

        .nav-link {
            padding: .5rem .5rem;
        }

        .layout-navbar-fixed .wrapper .sidebar-dark-primary .brand-link:not([class*=navbar]) {
            background-color: #ffffff;
        }
    </style>
    @yield('style')
</head>

<body class="sidebar-mini layout-fixed layout-navbar-fixed">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <h3 class="nav-link font-weight-bold active" style="color: #009f4b;font-size: 22px;margin: 0">
                        {{ config('app.name') }}</h3>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                {{--            <li class="nav-item dropdown ml-0 ml-sm-4"> --}}
                {{--                <a class="nav-link dropdown-toggle profile-link" id="access-permission-btn" role="button" style="cursor: pointer"> --}}
                {{--                    <i class="fa fa-setting text-danger"></i>Stack Holder --}}
                {{--                </a> --}}
                {{--            </li> --}}

                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
                        {{ Auth::user()->name }}
                        <img height="30" class="img-circle"
                            src="{{ asset('themes/backend/dist/img/user2-160x160.jpg') }}" alt="">

                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px;">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="{{ route('logout') }}" class="dropdown-item"
                                onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                <i class="fas fa-sign-out-alt mr-2"></i> Sign Out
                            </a>
                        </form>
                    </div>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="{{ route('home') }}" class="brand-link">
                <img src="{{ asset('img/logo.jpeg') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
                    style="opacity: .8">
                <span class="brand-text font-weight-light"><b>Stakeholder</b>Panel</span>
            </a>

            <!-- Sidebar -->
            <div
                class="sidebar os-host os-theme-light os-host-overflow os-host-overflow-y os-host-resize-disabled os-host-scrollbar-horizontal-hidden os-host-transition">

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <li class="nav-item">
                            <a href="{{ route('home') }}"
                                class="nav-link {{ Route::currentRouteName() == 'home' ? 'active' : '' }}">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>

                        <?php
                        $subMenu = ['stakeholder.view.payment'];
                        ?>

                        <li class="nav-item {{ in_array(Route::currentRouteName(), $subMenu) ? 'menu-open' : '' }}">
                            <a href="#"
                                class="nav-link {{ in_array(Route::currentRouteName(), $subMenu) ? 'active' : '' }}">
                                <i class="nav-icon fas fa-list"></i>
                                <p>
                                    Your Payments
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <?php
                                $subSubMenu = ['stakeholder.view.payment'];
                                ?>
                                <li
                                    class="nav-item {{ Route::currentRouteName() == 'stakeholder.view.payment' ? 'active' : '' }}">
                                    <a href="{{ route('stakeholder.view.payment') }}"
                                        class="nav-link {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'active' : '' }}">
                                        <i
                                            class="far {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                                        <p> All Payments</p>
                                    </a>
                                </li>

                            </ul>
                        </li>


                        {{--                    Project Details --}}
                        <?php
                        $subMenu = ['stakeholder.project', 'stakeholder.project.progress'];
                        ?>

                        <li class="nav-item {{ in_array(Route::currentRouteName(), $subMenu) ? 'menu-open' : '' }}">
                            <a href="#"
                                class="nav-link {{ in_array(Route::currentRouteName(), $subMenu) ? 'active' : '' }}">
                                <i class="nav-icon fas fa-list"></i>
                                <p>
                                    Project Details
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <?php
                                $subSubMenu = ['stakeholder.project'];
                                ?>
                                <li
                                    class="nav-item {{ Route::currentRouteName() == 'stakeholder.project' ? 'active' : '' }}">
                                    <a href="{{ route('stakeholder.project') }}"
                                        class="nav-link {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'active' : '' }}">
                                        <i
                                            class="far {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                                        <p> Project info</p>
                                    </a>
                                </li>
                                <?php
                                $subSubMenu = ['stakeholder.project.progress'];
                                ?>
                                <li
                                    class="nav-item {{ Route::currentRouteName() == 'stakeholder.project.progress' ? 'active' : '' }}">
                                    <a href="{{ route('stakeholder.project.progress') }}"
                                        class="nav-link {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'active' : '' }}">
                                        <i
                                            class="far {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                                        <p> Project Progress</p>
                                    </a>
                                </li>


                            </ul>
                        </li>


                        {{-- Project Gallary --}}
                        <?php
                        $subMenu = ['stakeholder.gallery', 'stakeholder.documentation', 'stakeholder.documentation.details'];
                        ?>

                        <li class="nav-item {{ in_array(Route::currentRouteName(), $subMenu) ? 'menu-open' : '' }}">
                            <a href="#"
                                class="nav-link {{ in_array(Route::currentRouteName(), $subMenu) ? 'active' : '' }}">
                                <i class="nav-icon fas fa-list"></i>
                                <p>
                                    Project Gallery
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <?php
                                $subSubMenu = ['stakeholder.gallery'];
                                ?>
                                <li
                                    class="nav-item {{ Route::currentRouteName() == 'stakeholder.gallery' ? 'active' : '' }}">
                                    <a href="{{ route('stakeholder.gallery') }}"
                                        class="nav-link {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'active' : '' }}">
                                        <i
                                            class="far {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                                        <p> Gallery </p>
                                    </a>
                                </li>

                                <?php
                                $subSubMenu = ['stakeholder.documentation'];
                                ?>
                                <li
                                    class="nav-item {{ Route::currentRouteName() == 'stakeholder.documentation' ? 'active' : '' }}">
                                    <a href="{{ route('stakeholder.documentation') }}"
                                        class="nav-link {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'active' : '' }}">
                                        <i
                                            class="far {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                                        <p> Documentation</p>
                                    </a>
                                </li>

                            </ul>
                        </li>



                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0"> @yield('title') </h1>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">
                    @yield('content')
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Main Footer -->
        <footer class="main-footer">
            <!-- To the right -->
            <div class="float-right d-none d-sm-inline">
                Design & Developed By <a target="_blank" href="https://techandbyte.com">Tech & Byte</a>
            </div>
            <!-- Default to the left -->
            <strong>Copyright &copy; 2022-{{ date('Y') }} <a
                    href="{{ route('dashboard') }}">{{ config('app.name') }}</a>.</strong> All rights reserved.
        </footer>
    </div>
    <!-- ./wrapper -->
    <!-- ./Modals -->
    <div class="modal fade" id="modal-access-permission">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Access Permission Information</h4>
                </div>
                <div class="modal-body">
                    <form name="modal-access-permission-form" id="modal-access-permission-form">
                        <div class="form-group">
                            <label for="modal-role">Role</label>
                            <select class="form-control" id="modal-role" name="role">
                                <option value="">Select Role</option>
                                @if (Auth::user()->role == 0)
                                    <option selected value="0">Super Admin</option>
                                @else
                                    <option value="0">Super Admin</option>
                                @endif
                                @if (Auth::user()->role == 2)
                                    <option selected value="2">Project Admin</option>
                                @else
                                    <option value="2">Project Admin</option>
                                @endif
                                @if (Auth::user()->role == 1)
                                    <option selected value="1">Stack Holder</option>
                                @else
                                    <option value="1">Stack Holder</option>
                                @endif
                            </select>
                        </div>
                        <div id="modal-project-area" style="display: none" class="form-group">
                            <label for="modal-project">Project</label>
                            <select style="width: 100%" class="form-control select2" id="modal-project"
                                name="user">
                                <option value="">Select Project</option>
                                @foreach (\App\Models\User::where('project_id', '!=', 'null')->get() as $user)
                                    <option {{ Auth::user()->id == $user->id ? 'selected' : '' }}
                                        value="{{ $user->id }}">{{ $user->project->name ?? '' }}
                                        ({{ $user->name ?? '' }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary"
                        id="modal-access-permission-btn-save">Save</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- ./Modals End -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="{{ asset('themes/backend/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('themes/backend/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Select2 -->
    <script src="{{ asset('themes/backend/plugins/select2/js/select2.full.min.js') }}"></script>
    <!-- Bootstrap4 Duallistbox -->
    <script src="{{ asset('themes/backend/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js') }}">
    </script>
    <!-- InputMask -->
    <script src="{{ asset('themes/backend/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('themes/backend/plugins/inputmask/jquery.inputmask.min.js') }}"></script>
    <!-- date-range-picker -->
    <script src="{{ asset('themes/backend/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <!-- bootstrap color picker -->
    <script src="{{ asset('themes/backend/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') }}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ asset('themes/backend/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}">
    </script>
    <!-- SweetAlert2 -->
    <script src="{{ asset('themes/backend/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <!-- Toastr -->
    <script src="{{ asset('themes/backend/plugins/toastr/toastr.min.js') }}"></script>
    <!-- DataTables  & Plugins -->
    <script src="{{ asset('themes/backend/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('themes/backend/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('themes/backend/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('themes/backend/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('themes/backend/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('themes/backend/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('themes/backend/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('themes/backend/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('themes/backend/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('themes/backend/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('themes/backend/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('themes/backend/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

    <!-- bootstrap datepicker -->
    <script src="{{ asset('themes/backend/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>


    <script src="{{ asset('themes/backend/dist/js/sweetalert2@9.js') }}"></script>
    <script>
        $(function() {

            $('body').on('click', '#access-permission-btn', function() {
                $("#modal-access-permission").modal("show");
            });

            $("#access-permission-btn").trigger("change");

            $("#modal-role").change(function() {

                var getRole = $(this).val();
                if (getRole != '') {
                    if (getRole == '1' || getRole == '4')
                        $("#modal-project-area").hide()
                    else
                        $("#modal-project-area").show()
                } else {
                    $("#modal-project-area").hide()
                }


            });
            $("#modal-role").trigger("change");



            $('#modal-access-permission-btn-save').click(function() {
                var formData = new FormData($('#modal-access-permission-form')[0]);
                $.ajax({
                    type: "POST",
                    url: "{{ route('access_permission_role') }}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            $("#modal-access-permission").modal("hide");
                            Swal.fire(
                                'Changed!',
                                response.message,
                                'success'
                            ).then((result) => {

                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: response.message,
                            });
                        }
                    }
                });
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var message = '{{ session('message') }}';
            var error = '{{ session('error') }}';

            if (!window.performance || window.performance.navigation.type != window.performance.navigation
                .TYPE_BACK_FORWARD) {
                if (message != '')
                    $(document).Toasts('create', {
                        icon: 'fas fa-envelope fa-lg',
                        class: 'bg-success',
                        title: 'Success',
                        autohide: true,
                        delay: 2000,
                        body: message
                    })

                if (error != '')
                    $(document).Toasts('create', {
                        icon: 'fas fa-envelope fa-lg',
                        class: 'bg-danger',
                        title: 'Error',
                        autohide: true,
                        delay: 2000,
                        body: error
                    })
            }
        });
    </script>

    <script>
        $(function() {

            //Date picker
            $('.date-picker').datepicker({
                autoclose: true,
                format: 'dd-mm-yyyy'
            });

            //Initialize Select2 Elements
            $('.select2').select2()

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })

            //Datemask dd/mm/yyyy
            $('#datemask').inputmask('dd-mm-yyyy', {
                'placeholder': 'dd-mm-yyyy'
            })
            //Datemask2 mm/dd/yyyy
            $('#datemask2').inputmask('mm-dd-yyyy', {
                'placeholder': 'mm-dd-yyyy'
            })
            //Money Euro
            $('[data-mask]').inputmask()

            //Date picker
            $('#reservationdate').datetimepicker({
                format: 'L'
            });

            //Date and time picker
            $('.date-time').datetimepicker({
                format: 'DD-MM-YYYY hh:mm A',
                icons: {
                    time: 'far fa-clock'
                }
            });
            //Date and time picker
            $('.date,.start_date,.end_date').datetimepicker({
                format: 'DD-MM-YYYY',
            });
            //Date range picker
            $('#reservation').daterangepicker()
            //Date range picker with time picker
            $('#reservationtime').daterangepicker({
                timePicker: true,
                timePickerIncrement: 30,
                locale: {
                    format: 'MM-DD-YYYY hh:mm A'
                }
            })
            //Date range as a button
            $('#daterange-btn').daterangepicker({
                    ranges: {
                        'Today': [moment(), moment()],
                        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                        'This Month': [moment().startOf('month'), moment().endOf('month')],
                        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                            'month').endOf('month')]
                    },
                    startDate: moment().subtract(29, 'days'),
                    endDate: moment()
                },
                function(start, end) {
                    $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format(
                        'MMMM D, YYYY'))
                }
            )

            //Timepicker
            $('#timepicker').datetimepicker({
                format: 'LT'
            })

            //Bootstrap Duallistbox
            $('.duallistbox').bootstrapDualListbox()

            //Colorpicker
            $('.my-colorpicker1').colorpicker()
            //color picker with addon
            $('.my-colorpicker2').colorpicker()

            $('.my-colorpicker2').on('colorpickerChange', function(event) {
                $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
            })

            $("input[data-bootstrap-switch]").each(function() {
                $(this).bootstrapSwitch('state', $(this).prop('checked'));
            })

        })
    </script>
    @yield('script')
    <!-- AdminLTE App -->
    <script src="{{ asset('themes/backend/dist/js/adminlte.min.js') }}"></script>
</body>

</html>
