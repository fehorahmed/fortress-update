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
                        {{ config('app.name') }}-{{ auth()->user()->project->name ?? '' }}</h3>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                @if (\Illuminate\Support\Facades\Auth::user()->admin_status == 1)
                    <li class="nav-item dropdown ml-0 ml-sm-4">
                        <a class="nav-link dropdown-toggle profile-link" id="access-permission-btn" role="button"
                            style="cursor: pointer">
                            <i class="fa fa-setting text-danger"></i>Projects
                        </a>
                    </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-bell"></i>
                        <span
                            class="badge badge-warning navbar-badge">{{ count(auth()->user()->unreadNotifications) }}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-item dropdown-header">{{ count(auth()->user()->unreadNotifications) }}
                            Notifications <a class="text-center btn btn-primary btn-sm"
                                href="{{ route('vendor.mark_read') }}">Mark as read</a></span>
                        <div class="dropdown-divider"></div>
                        @foreach (auth()->user()->unreadNotifications as $notification)
                            <a href="" class="dropdown-item">
                                <i class="fas fa-envelope mr-2"></i>
                                @if ($notification->data['type'] == 'New Requisition')
                                    {{ $notification->data['title'] }}
                                @endif
                                <span
                                    class="float-right text-muted text-sm">{{ $notification->created_at->diffForHumans() }}</span>
                            </a>
                            <div class="dropdown-divider"></div>
                        @endforeach

                        <a href="{{ route('vendor.notification') }}" class="dropdown-item dropdown-footer">See All
                            Notifications</a>
                    </div>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
                        <img height="30" class="img-circle"
                            src="{{ asset('themes/backend/dist/img/user2-160x160.jpg') }}" alt="">
                        {{ Auth::user()->name ?? '' }}
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
            <a href="{{ route('dashboard') }}" class="brand-link">
                <img src="{{ asset('img/logo.jpeg') }}" alt="AdminLTE Logo" class="brand-image  elevation-3"
                    style="opacity: .8">
                <span class="brand-text font-weight-light"><b>Admin</b>Panel</span>
            </a>

            <!-- Sidebar -->
            <div
                class="sidebar os-host os-theme-light os-host-overflow os-host-overflow-y os-host-resize-disabled os-host-scrollbar-horizontal-hidden os-host-transition">

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">

                        <li class="nav-item">
                            <a href="{{ route('dashboard') }}"
                                class="nav-link {{ Route::currentRouteName() == 'dashboard' ? 'active' : '' }}">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>

                        <?php
                        $subMenu = ['user.all', 'user.add', 'user.edit', 'project.all', 'project.add', 'project.edit', 'warehouse.all', 'warehouse.add', 'warehouse.edit', 'unit.all', 'unit.add', 'unit.edit'];
                        ?>

                        <li class="nav-item {{ in_array(Route::currentRouteName(), $subMenu) ? 'menu-open' : '' }}">
                            <a href="#"
                                class="nav-link {{ in_array(Route::currentRouteName(), $subMenu) ? 'active' : '' }}">
                                <i class="nav-icon fas fa-list"></i>
                                <p>
                                    Administrator
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <?php
                                $subSubMenu = ['user.all', 'user.add', 'user.edit'];
                                ?>
                                {{--                                @can('users') --}}
                                @if (Auth::user()->role == 3)
                                    <li
                                        class="nav-item {{ Route::currentRouteName() == 'user.all' ? 'active' : '' }}">
                                        <a href="{{ route('user.all') }}"
                                            class="nav-link {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'active' : '' }}">
                                            <i
                                                class="far {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                                            <p> Users</p>
                                        </a>
                                    </li>
                                @endif
                                {{--                                @endcan --}}
                                <?php
                                $subSubMenu = ['project.all', 'project.add', 'project.edit'];
                                ?>
                                {{--                                @can('projects') --}}
                                @if (Auth::user()->role == 3)
                                    <li
                                        class="nav-item {{ Route::currentRouteName() == 'project.all' ? 'active' : '' }}">
                                        <a href="{{ route('project.all') }}"
                                            class="nav-link {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'active' : '' }}">
                                            <i
                                                class="far {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                                            <p> Projects</p>
                                        </a>
                                    </li>
                                @endif

                                @can('administrator')
                                    <?php
                                    $subSubMenu = ['warehouse.all', 'warehouse.add', 'warehouse.edit'];
                                    ?>
                                    @can('warehouses')
                                        <li
                                            class="nav-item {{ Route::currentRouteName() == 'warehouse.all' ? 'active' : '' }}">
                                            <a href="{{ route('warehouse.all') }}"
                                                class="nav-link {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'active' : '' }}">
                                                <i
                                                    class="far {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                                                <p> Warehouses</p>
                                            </a>
                                        </li>
                                    @endcan
                                    <?php
                                    $subSubMenu = ['unit.all', 'unit.add', 'unit.edit'];
                                    ?>
                                    @can('units')
                                        <li class="nav-item {{ Route::currentRouteName() == 'unit.all' ? 'active' : '' }}">
                                            <a href="{{ route('unit.all') }}"
                                                class="nav-link {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'active' : '' }}">
                                                <i
                                                    class="far {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                                                <p> Units</p>
                                            </a>
                                        </li>
                                    @endcan
                                @endcan
                            </ul>
                        </li>


                        <!--Bank & Account-->
                        <?php
                        $subMenu = ['bank', 'bank.add', 'bank.edit', 'branch', 'branch.add', 'branch.edit', 'bank_account', 'bank_account.add', 'bank_account.edit', 'cash'];
                        ?>
                        @can('bank_and_account')
                            <li class="nav-item {{ in_array(Route::currentRouteName(), $subMenu) ? 'menu-open' : '' }}">
                                <a href="#"
                                    class="nav-link {{ in_array(Route::currentRouteName(), $subMenu) ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-list"></i>
                                    <p>
                                        Bank & Account
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">

                                    <?php
                                    $subSubMenu = ['bank', 'bank.add', 'bank.edit'];
                                    ?>
                                    @can('bank')
                                        <li class="nav-item {{ Route::currentRouteName() == 'bank' ? 'active' : '' }}">
                                            <a href="{{ route('bank') }}"
                                                class="nav-link {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'active' : '' }}">
                                                <i
                                                    class="far {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                                                <p>Bank</p>
                                            </a>
                                        </li>
                                    @endcan

                                    <?php
                                    $subSubMenu = ['branch', 'branch.add', 'branch.edit'];
                                    ?>
                                    @can('branch')
                                        <li class="nav-item {{ Route::currentRouteName() == 'branch' ? 'active' : '' }}">
                                            <a href="{{ route('branch') }}"
                                                class="nav-link {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'active' : '' }}">
                                                <i
                                                    class="far {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                                                <p>Branch</p>
                                            </a>
                                        </li>
                                    @endcan
                                    <?php
                                    $subSubMenu = ['bank_account', 'bank_account.add', 'bank_account.edit'];
                                    ?>
                                    @can('account')
                                        <li
                                            class="nav-item {{ Route::currentRouteName() == 'bank_account' ? 'active' : '' }}">
                                            <a href="{{ route('bank_account') }}"
                                                class="nav-link {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'active' : '' }}">
                                                <i
                                                    class="far {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                                                <p>Accounts</p>
                                            </a>
                                        </li>
                                    @endcan
                                    <?php
                                    $subSubMenu = ['cash'];
                                    ?>
                                    @can('cash')
                                        <li class="nav-item {{ Route::currentRouteName() == 'cash' ? 'active' : '' }}">
                                            <a href="{{ route('cash') }}"
                                                class="nav-link {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'active' : '' }}">
                                                <i
                                                    class="far {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                                                <p>Cash</p>
                                            </a>
                                        </li>
                                    @endcan

                                </ul>
                            </li>

                        @endcan

                        <!--Project Control-->
                        <?php
                        $subMenu = ['purchase_product', 'purchase_product.add', 'purchase_product.edit', 'segment.projects', 'segment.project.add', 'segment', 'segment.add', 'segment.edit', 'duration', 'duration.add', 'duration.edit', 'project.installment', 'project.installment.add', 'project.installment.edit', 'stakeholder.projects', 'stakeholder.all', 'stakeholder.add', 'stakeholder.edit', 'budget.distribute', 'profit.budget.distribute', 'stake_holder.report'];
                        ?>
                        @can('project_control')
                            <li class="nav-item {{ in_array(Route::currentRouteName(), $subMenu) ? 'menu-open' : '' }}">
                                <a href="#"
                                    class="nav-link {{ in_array(Route::currentRouteName(), $subMenu) ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-list"></i>
                                    <p>
                                        Project Control
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <?php
                                    $subSubMenu = ['stakeholder.projects', 'stakeholder.all', 'stakeholder.add', 'stakeholder.edit', 'stakeholder.projects', 'stakeholder.all', 'stakeholder.add', 'stakeholder.edit'];
                                    ?>
                                    @can('stakeholders')
                                        <li
                                            class="nav-item {{ Route::currentRouteName() == 'stakeholder.projects' ? 'active' : '' }}">
                                            <a href="{{ route('stakeholder.projects') }}"
                                                class="nav-link {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'active' : '' }}">
                                                <i
                                                    class="far {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                                                <p>Add Stakeholders</p>
                                            </a>
                                        </li>
                                    @endcan
                                    <?php
                                    $subSubMenu = ['stake_holder.report'];
                                    ?>
                                    <li
                                        class="nav-item {{ Route::currentRouteName() == 'stake_holder.report' ? 'active' : '' }}">
                                        <a href="{{ route('stake_holder.report') }}"
                                            class="nav-link {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'active' : '' }}">
                                            <i
                                                class="far {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                                            <p>Stakeholder Report</p>
                                        </a>
                                    </li>
                                    <?php
                                    $subSubMenu = ['duration', 'duration.add', 'duration.edit'];
                                    ?>
                                    @can('project_duration')
                                        <li class="nav-item {{ Route::currentRouteName() == 'duration' ? 'active' : '' }}">
                                            <a href="{{ route('duration') }}"
                                                class="nav-link {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'active' : '' }}">
                                                <i
                                                    class="far {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                                                <p> Duration & Budget</p>
                                            </a>
                                        </li>
                                    @endcan

                                    {{--                                <?php--}}
                                    {{--                                $subSubMenu = ['project.installment', 'project.installment.add', 'project.installment.edit'];--}}
                                    {{--                                ?> ?> --}}
                                    {{--                                @can('project_budget') --}}
                                    {{--                                    <li class="nav-item {{ Route::currentRouteName() == 'project.installment' ? 'active' : '' }}"> --}}
                                    {{--                                        <a href="{{ route('project.installment') }}" --}}
                                    {{--                                           class="nav-link {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'active' : '' }}"> --}}
                                    {{--                                            <i --}}
                                    {{--                                                class="far {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i> --}}
                                    {{--                                            <p>  Installment </p> --}}
                                    {{--                                        </a> --}}
                                    {{--                                    </li> --}}
                                    {{--                                @endcan --}}

                                    <?php
                                    $subSubMenu = ['budget.distribute'];
                                    ?>
                                    @can('budget_distribution')
                                        <li
                                            class="nav-item {{ Route::currentRouteName() == 'budget.distribute' ? 'active' : '' }}">
                                            <a href="{{ route('budget.distribute') }}"
                                                class="nav-link {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'active' : '' }}">
                                                <i
                                                    class="far {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                                                <p>Budget Distribution</p>
                                            </a>
                                        </li>
                                    @endcan

                                    {{--                            <?php--}}
                                                                    {{--                            $subSubMenu = ['project.profit.budget'];--}}
                                                                    {{--                            ?> ?> --}}
                                    {{--                            <li --}}
                                    {{--                                class="nav-item {{ Route::currentRouteName() == 'project.profit.budget' ? 'active' : '' }}"> --}}
                                    {{--                                <a href="{{ route('project.profit.budget') }}" --}}
                                    {{--                                   class="nav-link {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'active' : '' }}"> --}}
                                    {{--                                    <i --}}
                                    {{--                                        class="far {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i> --}}
                                    {{--                                    <p>Project Profit Budget</p> --}}
                                    {{--                                </a> --}}
                                    {{--                            </li> --}}


                                    <?php
                                    $subSubMenu = ['segment.projects', 'segment', 'segment.add', 'segment.edit'];
                                    ?>
                                    @can('segment')
                                        <li
                                            class="nav-item {{ Route::currentRouteName() == 'segment.projects' ? 'active' : '' }}">
                                            <a href="{{ route('segment.projects') }}"
                                                class="nav-link {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'active' : '' }}">
                                                <i
                                                    class="far {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                                                <p>Add Segment</p>
                                            </a>
                                        </li>
                                    @endcan

                                    <?php
                                    $subSubMenu = ['purchase_product', 'purchase_product.add', 'purchase_product.edit'];
                                    ?>
                                    @can('product')
                                        <li
                                            class="nav-item {{ Route::currentRouteName() == 'purchase_product' ? 'active' : '' }}">
                                            <a href="{{ route('purchase_product') }}"
                                                class="nav-link {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'active' : '' }}">
                                                <i
                                                    class="far {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                                                <p>Add Product & Unit</p>
                                            </a>
                                        </li>
                                    @endcan

                                    {{--                            <?php--}}
                                                                    {{--                            $subSubMenu = ['stakeholder_project_add'];--}}
                                                                    {{--                            ?> ?> --}}
                                    {{--                            <li --}}
                                    {{--                                class="nav-item {{ Route::currentRouteName() == 'stakeholder_project_add' ? 'active' : '' }}"> --}}
                                    {{--                                <a href="{{ route('stakeholder_project_add') }}" --}}
                                    {{--                                   class="nav-link {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'active' : '' }}"> --}}
                                    {{--                                    <i --}}
                                    {{--                                        class="far {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i> --}}
                                    {{--                                    <p> Stakeholder to Project</p> --}}
                                    {{--                                </a> --}}
                                    {{--                            </li> --}}

                                </ul>
                            </li>
                        @endcan

                        <!--Stake Holder-->
                        <?php
                        $subMenu = ['stakeholder.payment', 'payment_details_by_stakeholder', 'stakeholder.payment_receipt'];
                        ?>
                        @can('stakeholder_payment')
                            <li class="nav-item {{ in_array(Route::currentRouteName(), $subMenu) ? 'menu-open' : '' }}">
                                <a href="#"
                                    class="nav-link {{ in_array(Route::currentRouteName(), $subMenu) ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-list"></i>
                                    <p>
                                        Stakeholder Receipt
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">

                                    {{--                                <?php--}}
                                    {{--                                $subSubMenu = ['stakeholder.projects', 'stakeholder.all', 'stakeholder.add', 'stakeholder.edit'];--}}
                                    {{--                                ?> ?> --}}
                                    {{--                                @can('stakeholders') --}}
                                    {{--                                    <li --}}
                                    {{--                                        class="nav-item {{ Route::currentRouteName() == 'stakeholder.projects' ? 'active' : '' }}"> --}}
                                    {{--                                        <a href="{{ route('stakeholder.projects') }}" --}}
                                    {{--                                           class="nav-link {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'active' : '' }}"> --}}
                                    {{--                                            <i --}}
                                    {{--                                                class="far {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i> --}}
                                    {{--                                            <p> Stakeholders</p> --}}
                                    {{--                                        </a> --}}
                                    {{--                                    </li> --}}
                                    {{--                                @endcan --}}

                                    {{--                            <?php--}}
                                                                    {{--                            $subSubMenu = ['profit.budget.distribute'];--}}
                                                                    {{--                            ?> ?> --}}
                                    {{--                            <li --}}
                                    {{--                                class="nav-item {{ Route::currentRouteName() == 'profit.budget.distribute' ? 'active' : '' }}"> --}}
                                    {{--                                <a href="{{ route('profit.budget.distribute') }}" --}}
                                    {{--                                   class="nav-link {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'active' : '' }}"> --}}
                                    {{--                                    <i --}}
                                    {{--                                        class="far {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i> --}}
                                    {{--                                    <p>Profit Distribution</p> --}}
                                    {{--                                </a> --}}
                                    {{--                            </li> --}}

                                    <?php
                                    $subSubMenu = ['stakeholder.payment'];
                                    ?>
                                    @can('stakeholder_payment')
                                        <li
                                            class="nav-item {{ Route::currentRouteName() == 'stakeholder.payment' ? 'active' : '' }}">
                                            <a href="{{ route('stakeholder.payment') }}"
                                                class="nav-link {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'active' : '' }}">
                                                <i
                                                    class="far {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                                                <p>Stakeholder Installment</p>
                                            </a>
                                        </li>
                                    @endcan

                                </ul>
                            </li>
                        @endcan

                        <!--Estimation & Costing  BOQ-->
                        <?php
                        $subMenu = ['estimate_product', 'costing.projects', 'estimate_product.add', 'estimate_product.edit', 'estimate_project', 'estimate_project.add', 'estimate_project.edit', 'costing', 'costing.add', 'costing.edit', 'costing.details', 'costing_report.details', 'costing_segment.add', 'costing_segment.edit', 'costing_segment', 'costing_report'];
                        ?>
                        @can('bill_of_quantity')
                            <li class="nav-item {{ in_array(Route::currentRouteName(), $subMenu) ? 'menu-open' : '' }}">
                                <a href="#"
                                    class="nav-link {{ in_array(Route::currentRouteName(), $subMenu) ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-list"></i>
                                    <p>
                                        Bill of Quantity
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">


                                    <?php
                                    $subSubMenu = ['costing.projects', 'costing', 'costing.add', 'costing.edit'];
                                    ?>
                                    @can('all_boq_costing')
                                        <li
                                            class="nav-item {{ Route::currentRouteName() == 'costing.projects' ? 'active' : '' }}">
                                            <a href="{{ route('costing.projects') }}"
                                                class="nav-link {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'active' : '' }}">
                                                <i
                                                    class="far {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                                                <p> All BOQ Costing</p>
                                            </a>
                                        </li>
                                    @endcan
                                    <?php
                                    $subSubMenu = ['costing_report.details', 'costing_report'];
                                    ?>
                                    @can('boq_report')
                                        <li
                                            class="nav-item {{ Route::currentRouteName() == 'purchase_product' ? 'active' : '' }}">
                                            <a href="{{ route('costing_report') }}"
                                                class="nav-link {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'active' : '' }}">
                                                <i
                                                    class="far {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                                                <p> BOQ Report</p>
                                            </a>
                                        </li>
                                    @endcan

                                </ul>
                            </li>
                        @endcan
                        {{-- <!--Requisition-->

                    <?php
                    $subMenu = ['boq_edit', 'requisition.details', 'requisition.add', 'requisition', 'requisition.edit', 'segment.view', 'requisition.project.report', 'requisition.view.edit', 'requisition.boq.report'];
                    ?>
                    @can('requisition')
                        <li
                            class="nav-item {{ in_array(Route::currentRouteName(), $subMenu) ? 'menu-open' : '' }}">
                            <a href="#"
                               class="nav-link {{ in_array(Route::currentRouteName(), $subMenu) ? 'active' : '' }}">
                                <i class="nav-icon fas fa-list"></i>
                                <p>
                                    Requisition
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">

                                <?php
                                $subSubMenu = ['boq_edit'];
                                ?>
                                @can('requisitions')
                                    <li class="nav-item {{ Route::currentRouteName() == 'boq_edit' ? 'active' : '' }}">
                                        <a href="{{ route('boq_edit') }}"
                                           class="nav-link {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'active' : '' }}">
                                            <i
                                                class="far {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                                            <p> Requisitions</p>
                                        </a>
                                    </li>
                                @endcan

                                <?php
                                $subSubMenu = ['requisition.project.report'];
                                ?>
                                @can('requisition_report')
                                    <li
                                        class="nav-item {{ Route::currentRouteName() == 'requisition.project.report' ? 'active' : '' }}">
                                        <a href="{{ route('requisition.project.report') }}"
                                           class="nav-link {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'active' : '' }}">
                                            <i
                                                class="far {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                                            <p> Requisition Report</p>
                                        </a>
                                    </li>
                                @endcan

                                <?php
                                $subSubMenu = ['requisition.boq.report'];
                                ?>
                                @can('requisition_and_boq')
                                    <li
                                        class="nav-item {{ Route::currentRouteName() == 'requisition.boq.report' ? 'active' : '' }}">
                                        <a href="{{ route('requisition.boq.report') }}"
                                           class="nav-link {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'active' : '' }}">
                                            <i
                                                class="far {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                                            <p> Requisition & BOQ</p>
                                        </a>
                                    </li>
                                @endcan

                            </ul>
                        </li>
                    @endcan --}}

                        <!--Purchase Control-->
                        <?php
                        $subMenu = ['supplier', 'supplier.add', 'supplier.edit', 'contractor', 'contractor.add', 'contractor.edit', 'contractor_budget', 'contractor_budget.add', 'contractor_budget.edit', 'purchase_order.create', 'purchase_receipt.all', 'purchase_receive.details', 'purchase_receipt.details', 'purchase_inventory.all.project', 'purchase_inventory.details', 'purchase_inventory.all', 'utilize.all.project', 'purchase_requisition_report.all', 'purchase_product.utilize.all', 'purchase_product.utilize.add', 'purchase_receipt.payment_details'];
                        ?>
                        @can('purchase_control')
                            <li class="nav-item {{ in_array(Route::currentRouteName(), $subMenu) ? 'menu-open' : '' }}">
                                <a href="#"
                                    class="nav-link {{ in_array(Route::currentRouteName(), $subMenu) ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-list"></i>
                                    <p>
                                        Purchase Control
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">

                                    <?php
                                    $subSubMenu = ['supplier', 'supplier.add', 'supplier.edit'];
                                    ?>
                                    @can('supplier')
                                        <li class="nav-item {{ Route::currentRouteName() == 'supplier' ? 'active' : '' }}">
                                            <a href="{{ route('supplier') }}"
                                                class="nav-link {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'active' : '' }}">
                                                <i
                                                    class="far {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                                                <p> Supplier</p>
                                            </a>
                                        </li>
                                    @endcan

                                    <?php
                                    $subSubMenu = ['contractor', 'contractor.add', 'contractor.edit'];
                                    ?>
                                    @can('supplier')
                                        <li class="nav-item {{ Route::currentRouteName() == 'contractor' ? 'active' : '' }}">
                                            <a href="{{ route('contractor') }}"
                                                class="nav-link {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'active' : '' }}">
                                                <i
                                                    class="far {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                                                <p>Contractor</p>
                                            </a>
                                        </li>
                                    @endcan

                                    <?php
                                    $subSubMenu = ['contractor_budget', 'contractor_budget.add', 'contractor_budget.edit'];
                                    ?>
                                    @can('supplier')
                                        <li class="nav-item {{ Route::currentRouteName() == 'contractor' ? 'active' : '' }}">
                                            <a href="{{ route('contractor_budget') }}"
                                                class="nav-link {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'active' : '' }}">
                                                <i
                                                    class="far {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                                                <p>Contractor Budget</p>
                                            </a>
                                        </li>
                                    @endcan

                                    <?php
                                    $subSubMenu = ['purchase_order.create'];
                                    ?>
                                    @can('purchase')
                                        <li
                                            class="nav-item {{ Route::currentRouteName() == 'purchase_order.create' ? 'active' : '' }}">
                                            <a href="{{ route('purchase_order.create') }}"
                                                class="nav-link {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'active' : '' }}">
                                                <i
                                                    class="far {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                                                <p> Purchase</p>
                                            </a>
                                        </li>
                                    @endcan

                                    <?php
                                    $subSubMenu = ['purchase_receipt.all'];
                                    ?>

                                    @can('purchase_receipt')
                                        <li
                                            class="nav-item {{ Route::currentRouteName() == 'purchase_receipt.all' ? 'active' : '' }}">
                                            <a href="{{ route('purchase_receipt.all') }}"
                                                class="nav-link {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'active' : '' }}">
                                                <i
                                                    class="far {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                                                <p> Receipt</p>
                                            </a>
                                        </li>
                                    @endcan
                                    <?php
                                    $subSubMenu = ['purchase_inventory.all.project', 'purchase_inventory.all'];
                                    ?>

                                    @can('purchase_inventory')
                                        <li
                                            class="nav-item {{ Route::currentRouteName() == 'purchase_inventory.all.project' ? 'active' : '' }}">
                                            <a href="{{ route('purchase_inventory.all.project') }}"
                                                class="nav-link {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'active' : '' }}">
                                                <i
                                                    class="far {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                                                <p> Inventory</p>
                                            </a>
                                        </li>
                                    @endcan
                                    <?php
                                    $subSubMenu = ['utilize.all.project'];
                                    ?>
                                    @can('utilize')
                                        <li
                                            class="nav-item {{ Route::currentRouteName() == 'utilize.all.project' ? 'active' : '' }}">
                                            <a href="{{ route('utilize.all.project') }}"
                                                class="nav-link {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'active' : '' }}">
                                                <i
                                                    class="far {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                                                <p> Utilize</p>
                                            </a>
                                        </li>
                                    @endcan


                                    <?php
                                    $subSubMenu = ['purchase_requisition_report.all'];
                                    ?>

                                    @can('purchase_and_requisition')
                                        <li
                                            class="nav-item {{ Route::currentRouteName() == 'purchase_requisition_report.all' ? 'active' : '' }}">
                                            <a href="{{ route('purchase_requisition_report.all') }}"
                                                class="nav-link {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'active' : '' }}">
                                                <i
                                                    class="far {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                                                <p> Purchase & Requisition</p>
                                            </a>
                                        </li>
                                    @endcan

                                </ul>
                            </li>
                        @endcan

                        <?php
                        $subMenu = ['loan_holder', 'loan_holder.add', 'loan_holder.edit', 'loan.all', 'loan.add', 'loan_detail'];
                        ?>
                        @if (Auth::user()->role != 3)
                            <li
                                class="nav-item {{ in_array(Route::currentRouteName(), $subMenu) ? 'menu-open' : '' }}">
                                <a href="#"
                                    class="nav-link {{ in_array(Route::currentRouteName(), $subMenu) ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-list"></i>
                                    <p>
                                        Loan System
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">

                                    <?php
                                    $subSubMenu = ['loan_holder', 'loan_holder.add', 'loan_holder.edit'];
                                    ?>

                                    <li
                                        class="nav-item {{ Route::currentRouteName() == 'loan_holder' ? 'active' : '' }}">
                                        <a href="{{ route('loan_holder') }}"
                                            class="nav-link {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'active' : '' }}">
                                            <i
                                                class="far {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                                            <p> Loan Holder</p>
                                        </a>
                                    </li>
                                    <?php
                                    $subSubMenu = ['loan.all', 'loan.add', 'loan_detail'];
                                    ?>
                                    <li
                                        class="nav-item {{ Route::currentRouteName() == 'loan.all' ? 'active' : '' }}">
                                        <a href="{{ route('loan.all') }}"
                                            class="nav-link {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'active' : '' }}">
                                            <i
                                                class="far {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                                            <p>Loan</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endif


                        <!--Physical Progress-->
                        <?php
                        $subMenu = ['physical.project.all', 'physical_progress.add', 'physical.project.report', 'physical_progress_view'];
                        ?>
                        @can('physical_progress')
                            <li class="nav-item {{ in_array(Route::currentRouteName(), $subMenu) ? 'menu-open' : '' }}">
                                <a href="#"
                                    class="nav-link {{ in_array(Route::currentRouteName(), $subMenu) ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-list"></i>
                                    <p>
                                        Physical Progress
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">

                                    <?php
                                    $subSubMenu = ['physical.project.all'];
                                    ?>
                                    @can('physical_progress_add')
                                        <li
                                            class="nav-item {{ Route::currentRouteName() == 'physical.project.all' ? 'active' : '' }}">
                                            <a href="{{ route('physical.project.all') }}"
                                                class="nav-link {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'active' : '' }}">
                                                <i
                                                    class="far {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                                                <p> Physical Progress Add</p>
                                            </a>
                                        </li>
                                    @endcan

                                    <?php
                                    $subSubMenu = ['physical.project.report'];
                                    ?>
                                    @can('physical_progress_report')
                                        <li
                                            class="nav-item {{ Route::currentRouteName() == 'physical.project.report' ? 'active' : '' }}">
                                            <a href="{{ route('physical.project.report') }}"
                                                class="nav-link {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'active' : '' }}">
                                                <i
                                                    class="far {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                                                <p> Physical P Report</p>
                                            </a>
                                        </li>
                                    @endcan

                                </ul>
                            </li>

                        @endcan
                        <!--Project Documentation-->

                        <?php
                        $subMenu = ['documentation.project.all', 'documentation.project.add', 'documentation.project.edit', 'documentation.project.view', 'project.galary.all', 'project.gallary.view'];
                        ?>
                        @can('project_documentation')
                            <li class="nav-item {{ in_array(Route::currentRouteName(), $subMenu) ? 'menu-open' : '' }}">
                                <a href="#"
                                    class="nav-link {{ in_array(Route::currentRouteName(), $subMenu) ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-list"></i>
                                    <p>
                                        Project Documentation
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">

                                    <?php
                                    $subSubMenu = ['documentation.project.all'];
                                    ?>
                                    @can('documentation_info')
                                        <li
                                            class="nav-item {{ Route::currentRouteName() == 'documentation.project.all' ? 'active' : '' }}">
                                            <a href="{{ route('documentation.project.all') }}"
                                                class="nav-link {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'active' : '' }}">
                                                <i
                                                    class="far {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                                                <p> Documentation info</p>
                                            </a>
                                        </li>
                                    @endcan

                                    <?php
                                    $subSubMenu = ['project.galary.all'];
                                    ?>
                                    @can('project_gallery')
                                        <li
                                            class="nav-item {{ Route::currentRouteName() == 'project.galary.all' ? 'active' : '' }}">
                                            <a href="{{ route('project.galary.all') }}"
                                                class="nav-link {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'active' : '' }}">
                                                <i
                                                    class="far {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                                                <p>Project Gallery </p>
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </li>
                        @endcan

                        <!--Accounts P M C-->
                        <?php
                        $subMenu = ['account_head.type', 'account_head.type.add', 'account_head.type.edit', 'account_head.sub_type', 'account_head.sub_type.add', 'account_head.sub_type.edit', 'balance_transfer.add', 'balance_transfer.all', 'transaction.project_wise', 'transaction.project_wise.add', 'transaction.project_wise.edit', 'balance_transfer.edit', 'project.report.transaction', 'project.report.receive_and_payment', 'report.all_receive_payment', 'supplier_payment.all', 'supplier_payment_details', 'contractor_payment.all', 'contractor_payment_details'];
                        ?>
                        @can('p_m_c')
                            <li class="nav-item {{ in_array(Route::currentRouteName(), $subMenu) ? 'menu-open' : '' }}">
                                <a href="#"
                                    class="nav-link {{ in_array(Route::currentRouteName(), $subMenu) ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-list"></i>
                                    <p>
                                        Accounts
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">

                                    <?php
                                    $subSubMenu = ['account_head.type', 'account_head.type.add', 'account_head.type.edit'];
                                    ?>
                                    @can('account_head_type')
                                        <li
                                            class="nav-item {{ Route::currentRouteName() == 'account_head.type' ? 'active' : '' }}">
                                            <a href="{{ route('account_head.type') }}"
                                                class="nav-link {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'active' : '' }}">
                                                <i
                                                    class="far {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                                                <p>Account Head Type</p>
                                            </a>
                                        </li>
                                    @endcan

                                    <?php
                                    $subSubMenu = ['account_head.sub_type', 'account_head.sub_type.add', 'account_head.sub_type.edit'];
                                    ?>
                                    @can('account_sub_head_type')
                                        <li
                                            class="nav-item {{ Route::currentRouteName() == 'account_head.sub_type' ? 'active' : '' }}">
                                            <a href="{{ route('account_head.sub_type') }}"
                                                class="nav-link {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'active' : '' }}">
                                                <i
                                                    class="far {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                                                <p>Account Sub Head Type</p>
                                            </a>
                                        </li>
                                    @endcan

                                    <?php
                                    $subSubMenu = ['supplier_payment.all', 'supplier_payment_details'];
                                    ?>

                                    @can('supplier_payment')
                                        <li
                                            class="nav-item {{ Route::currentRouteName() == 'supplier_payment.all' ? 'active' : '' }}">
                                            <a href="{{ route('supplier_payment.all') }}"
                                                class="nav-link {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'active' : '' }}">
                                                <i
                                                    class="far {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                                                <p> Supplier Payment</p>
                                            </a>
                                        </li>
                                    @endcan

                                    <?php
                                    $subSubMenu = ['contractor_payment.all', 'contractor_payment_details'];
                                    ?>

                                    @can('supplier_payment')
                                        <li
                                            class="nav-item {{ Route::currentRouteName() == 'supplier_payment.all' ? 'active' : '' }}">
                                            <a href="{{ route('contractor_payment.all') }}"
                                                class="nav-link {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'active' : '' }}">
                                                <i
                                                    class="far {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                                                <p>Contractor Payment</p>
                                            </a>
                                        </li>
                                    @endcan

                                    <?php
                                    $subSubMenu = ['transaction.project_wise', 'transaction.project_wise.add', 'transaction.project_wise.edit'];
                                    ?>
                                    @can('project_wise_transaction')
                                        <li
                                            class="nav-item {{ Route::currentRouteName() == 'transaction.project_wise' ? 'active' : '' }}">
                                            <a href="{{ route('transaction.project_wise') }}"
                                                class="nav-link {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'active' : '' }}">
                                                <i
                                                    class="far {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                                                <p>Transaction</p>
                                            </a>
                                        </li>
                                    @endcan
                                    <?php
                                    $subSubMenu = ['balance_transfer.add', 'balance_transfer.all', 'balance_transfer.edit'];
                                    ?>
                                    @can('balance_transfer')
                                        <li
                                            class="nav-item {{ Route::currentRouteName() == 'balance_transfer.all' ? 'active' : '' }}">
                                            <a href="{{ route('balance_transfer.all') }}"
                                                class="nav-link {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'active' : '' }}">
                                                <i
                                                    class="far {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                                                <p>Balance Transfer</p>
                                            </a>
                                        </li>
                                    @endcan
                                    <?php
                                    $subSubMenu = ['project.report.transaction'];
                                    ?>
                                    {{--                                @can('progress_report') --}}
                                    <li
                                        class="nav-item {{ Route::currentRouteName() == 'project.report.transaction' ? 'active' : '' }}">
                                        <a href="{{ route('project.report.transaction') }}"
                                            class="nav-link {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'active' : '' }}">
                                            <i
                                                class="far {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                                            <p>Transaction Report</p>
                                        </a>
                                    </li>
                                    <?php
                                    $subSubMenu = ['project.report.receive_and_payment'];
                                    ?>
                                    {{--                                @can('progress_report') --}}
                                    <li
                                        class="nav-item {{ Route::currentRouteName() == 'project.report.receive_and_payment' ? 'active' : '' }}">
                                        <a href="{{ route('project.report.receive_and_payment') }}"
                                            class="nav-link {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'active' : '' }}">
                                            <i
                                                class="far {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                                            <p>Group Receive & Payment</p>
                                        </a>
                                    </li>
                                    <?php
                                    $subSubMenu = ['report.all_receive_payment'];
                                    ?>
                                    <li
                                        class="nav-item {{ Route::currentRouteName() == 'report.all_receive_payment' ? 'active' : '' }}">
                                        <a href="{{ route('report.all_receive_payment') }}"
                                            class="nav-link {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'active' : '' }}">
                                            <i
                                                class="far {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                                            <p>All Receive & Payment</p>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                        @endcan



                        <!--Report-->
                        <?php
                        $subMenu = ['contractor.ledger', 'supplier.ledger', 'purchase.report', 'stakeholder.report', 'project.report', 'progress.report', 'report.transaction', 'report.receive_and_payment', 'report.bank_statement', 'report.cash_statement'];
                        ?>
                        {{--                    @can('report') --}}
                        <li class="nav-item {{ in_array(Route::currentRouteName(), $subMenu) ? 'menu-open' : '' }}">
                            <a href="#"
                                class="nav-link {{ in_array(Route::currentRouteName(), $subMenu) ? 'active' : '' }}">
                                <i class="nav-icon fas fa-list"></i>
                                <p>
                                    Reports
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <?php
                                $subSubMenu = ['supplier.ledger'];
                                ?>
                                {{--                            @can('supplier_report') --}}
                                <li
                                    class="nav-item {{ Route::currentRouteName() == 'supplier.ledger' ? 'active' : '' }}">
                                    <a href="{{ route('supplier.ledger') }}"
                                        class="nav-link {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'active' : '' }}">
                                        <i
                                            class="far {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                                        <p>Supplier Ledger</p>
                                    </a>
                                </li>
                                {{--                                @endcan --}}

                                <?php
                                $subSubMenu = ['contractor.ledger'];
                                ?>
                                <li
                                    class="nav-item {{ Route::currentRouteName() == 'contractor.ledger' ? 'active' : '' }}">
                                    <a href="{{ route('contractor.ledger') }}"
                                        class="nav-link {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'active' : '' }}">
                                        <i
                                            class="far {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                                        <p>Contractor Ledger</p>
                                    </a>
                                </li>

                                <?php
                                $subSubMenu = ['purchase.report'];
                                ?>
                                {{--                                @can('purchase_report') --}}
                                <li
                                    class="nav-item {{ Route::currentRouteName() == 'purchase.report' ? 'active' : '' }}">
                                    <a href="{{ route('purchase.report') }}"
                                        class="nav-link {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'active' : '' }}">
                                        <i
                                            class="far {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                                        <p>Purchase Report</p>
                                    </a>
                                </li>
                                {{--                                @endcan --}}
                                <?php
                                $subSubMenu = ['stakeholder.report'];
                                ?>
                                {{--                                @can('stakeholder_report') --}}
                                <li
                                    class="nav-item {{ Route::currentRouteName() == 'stakeholder.report' ? 'active' : '' }}">
                                    <a href="{{ route('stakeholder.report') }}"
                                        class="nav-link {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'active' : '' }}">
                                        <i
                                            class="far {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                                        <p>Stakeholder Report</p>
                                    </a>
                                </li>
                                {{--                                @endcan --}}

                                <?php
                                $subSubMenu = ['project.report'];
                                ?>
                                {{--                                @can('project_report') --}}
                                <li
                                    class="nav-item {{ Route::currentRouteName() == 'project.report' ? 'active' : '' }}">
                                    <a href="{{ route('project.report') }}"
                                        class="nav-link {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'active' : '' }}">
                                        <i
                                            class="far {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                                        <p>Project Report</p>
                                    </a>
                                </li>
                                {{--                                @endcan --}}
                                <?php
                                $subSubMenu = ['progress.report'];
                                ?>
                                {{--                                @can('progress_report') --}}
                                <li
                                    class="nav-item {{ Route::currentRouteName() == 'progress.report' ? 'active' : '' }}">
                                    <a href="{{ route('progress.report') }}"
                                        class="nav-link {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'active' : '' }}">
                                        <i
                                            class="far {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                                        <p>Progress Report</p>
                                    </a>
                                </li>
                                {{--                        @endcan --}}
                                <?php
                                $subSubMenu = ['report.transaction'];
                                ?>
                                {{--                                @can('progress_report') --}}
                                @if (Auth::user()->role == 3)
                                    <li
                                        class="nav-item {{ Route::currentRouteName() == 'report.transaction' ? 'active' : '' }}">
                                        <a href="{{ route('report.transaction') }}"
                                            class="nav-link {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'active' : '' }}">
                                            <i
                                                class="far {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                                            <p>Transaction Report</p>
                                        </a>
                                    </li>
                                    <?php
                                    $subSubMenu = ['report.receive_and_payment'];
                                    ?>
                                    {{--                                @can('progress_report') --}}
                                    <li
                                        class="nav-item {{ Route::currentRouteName() == 'project.report.receive_and_payment' ? 'active' : '' }}">
                                        <a href="{{ route('project.report.receive_and_payment') }}"
                                            class="nav-link {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'active' : '' }}">
                                            <i
                                                class="far {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                                            <p>Receive & Payment Report</p>
                                        </a>
                                    </li>
                                @endif
                                <?php
                                $subSubMenu = ['report.bank_statement'];
                                ?>
                                {{--                                @can('progress_report') --}}
                                <li
                                    class="nav-item {{ Route::currentRouteName() == 'report.bank_statement' ? 'active' : '' }}">
                                    <a href="{{ route('report.bank_statement') }}"
                                        class="nav-link {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'active' : '' }}">
                                        <i
                                            class="far {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                                        <p>Bank Statement</p>
                                    </a>
                                </li>
                                {{--                        @endcan --}}
                                <?php
                                $subSubMenu = ['report.cash_statement'];
                                ?>
                                {{--                                @can('progress_report') --}}
                                <li
                                    class="nav-item {{ Route::currentRouteName() == 'report.cash_statement' ? 'active' : '' }}">
                                    <a href="{{ route('report.cash_statement') }}"
                                        class="nav-link {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'active' : '' }}">
                                        <i
                                            class="far {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                                        <p>Cash Statement</p>
                                    </a>
                                </li>
                                {{--                        @endcan --}}
                            </ul>
                        </li>
                        {{--                    @endcan --}}

                        @if (Auth::user()->role != 3)
                            <?php
                            $subMenu = ['sms.template', 'sms.template.add', 'sms.template.edit', 'sms.log', 'sms.sent'];
                            ?>
                            <li
                                class="nav-item {{ in_array(Route::currentRouteName(), $subMenu) ? 'menu-open' : '' }}">
                                <a href="#"
                                    class="nav-link {{ in_array(Route::currentRouteName(), $subMenu) ? 'active' : '' }}">
                                    <i class="nav-icon fa fa-envelope" aria-hidden="true"></i>
                                    <p>
                                        SMS Panel
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <?php
                                    $subSubMenu = ['sms.template'];
                                    ?>
                                    <li
                                        class="nav-item {{ Route::currentRouteName() == 'sms.template' ? 'active' : '' }}">
                                        <a href="{{ route('sms.template') }}"
                                            class="nav-link {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'active' : '' }}">
                                            <i
                                                class="far {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                                            <p>SMS Templete</p>
                                        </a>
                                    </li>
                                    <?php
                                    $subSubMenu = ['sms.log'];
                                    ?>
                                    <li
                                        class="nav-item {{ Route::currentRouteName() == 'sms.log' ? 'active' : '' }}">
                                        <a href="{{ route('sms.log') }}"
                                            class="nav-link {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'active' : '' }}">
                                            <i
                                                class="far {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                                            <p>SMS Log</p>
                                        </a>
                                    </li>
                                    <?php
                                    $subSubMenu = ['sms.sent'];
                                    ?>
                                    <li
                                        class="nav-item {{ Route::currentRouteName() == 'sms.sent' ? 'active' : '' }}">
                                        <a href="{{ route('sms.sent') }}"
                                            class="nav-link {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'active' : '' }}">
                                            <i
                                                class="far {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                                            <p>SMS Sent</p>
                                        </a>
                                    </li>
                                    {{--                                <?php--}}
                                    {{--                                $subSubMenu = ['sms.send.stakeholder'];--}}
                                    {{--                                ?> ?> --}}
                                    {{--                                <li --}}
                                    {{--                                    class="nav-item {{ Route::currentRouteName() == 'sms.send.stakeholder' ? 'active' : '' }}"> --}}
                                    {{--                                    <a href="{{ route('sms.send.stakeholder') }}" --}}
                                    {{--                                       class="nav-link {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'active' : '' }}"> --}}
                                    {{--                                        <i --}}
                                    {{--                                            class="far {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i> --}}
                                    {{--                                        <p>Sms Send Update </p> --}}
                                    {{--                                    </a> --}}
                                    {{--                                </li> --}}
                                </ul>
                            </li>
                        @endif
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
                                @if (Auth::user()->role == 3)
                                    <option selected value="3">Super Admin</option>
                                @else
                                    <option value="3">Super Admin</option>
                                @endif
                                @if (Auth::user()->role == 2)
                                    <option selected value="2">Project Admin</option>
                                @else
                                    <option value="2">Project Admin</option>
                                @endif
                                {{--                            @if (Auth::user()->role == 1) --}}
                                {{--                                <option selected value="1">Stack Holder</option> --}}
                                {{--                            @else --}}
                                {{--                                <option value="1">Stack Holder</option> --}}
                                {{--                            @endif --}}
                            </select>
                        </div>
                        <div id="modal-project-area" style="display: none" class="form-group">
                            <label for="modal-project">Project</label>
                            <select style="width: 100%" class="form-control select2" id="modal-project"
                                name="project">
                                <option value="">Select Project</option>
                                @foreach (\App\Models\Project::where('status', 1)->get() as $project)
                                    <option {{ Auth::user()->project_id == $project->id ? 'selected' : '' }}
                                        value="{{ $project->id }}">{{ $project->name ?? '' }}</option>
                                @endforeach
                            </select>
                        </div>
                        {{--                    <div id="modal-stack-holder-area" style="display: none" class="form-group"> --}}
                        {{--                        <label for="modal-stack-holder">Stack Holder</label> --}}
                        {{--                        <select style="width: 100%" class="form-control select2" id="modal-stack-holder" name="stack_holder"> --}}
                        {{--                            <option value="">Select Stack Holder</option> --}}
                        {{--                            @foreach (\App\Models\Stakeholder::orderBy('name')->get() as $stackHolder) --}}
                        {{--                                <option {{ Auth::user()->stakeholder_id == $stackHolder->id ? 'selected' : '' }} value="{{ $stackHolder->id }}">{{ $stackHolder->name??'' }} ({{$stackHolder->id_no}})</option> --}}
                        {{--                            @endforeach --}}
                        {{--                        </select> --}}
                        {{--                    </div> --}}
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
                    if (getRole == '3')
                        $("#modal-project-area").hide()
                    else if (getRole == '2')
                        $("#modal-project-area").show()
                    else {
                        $("#modal-project-area").hide()
                    }
                } else {
                    $("#modal-project-area").hide()
                    //$("#modal-stack-holder-area").hide();
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
