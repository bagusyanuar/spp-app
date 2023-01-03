<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <link rel="stylesheet" href="{{ asset('/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/adminlte/css/adminlte.min.css')}}">
    <link href="{{ asset('/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/sweetalert2.css') }}" rel="stylesheet">
    <script src="{{ asset('/js/sweetalert2.min.js')}}"></script>
    <title>Sistem Informasi SPP</title>
    @yield('css')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<nav class="main-header navbar navbar-expand elevation-1">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link navbar-link-item" data-widget="pushmenu" href="#" role="button"><i
                    class="fa fa-bars"></i></a>
        </li>
    </ul>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a href="/logout" class="nav-link navbar-link-item">Logout</a>
        </li>
    </ul>
</nav>
<aside class="main-sidebar sidebar-dark-primary elevation-1" style="height: auto">
    <a href="#" class="brand-link">
        <img src="{{ asset('assets/icon/logo.png') }}"
             alt="AdminLTE Logo"
             class="brand-image"
        >
        <span class="brand-text font-weight-light">SPP App</span>
    </a>
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">Alexander Pierce</a>
            </div>
        </div>
        <div class="">
            <ul class="nav nav-sidebar nav-pills flex-column">
                <nav class="mt-2 nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                     data-accordion="false">
                    <li class="nav-header">Menu</li>
                    <li class="nav-item">
                        <a href="#"
                           class="nav-link">
                            <i class="fa fa-tachometer nav-icon" aria-hidden="true"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#"
                           class="nav-link">
                            <i class="fa fa-credit-card nav-icon" aria-hidden="true"></i>
                            <p>Pembayaran Siswa</p>
                        </a>
                    </li>
                    <li class="nav-item has-treeview {{ request()->is('persediaan-keluar*') ? 'menu-open' : ''}}">
                        <a href="#" class="nav-link {{ request()->is('persediaan-keluar*') ? 'active' : ''}}">
                            <i class="nav-icon fa fa-money"></i>
                            <p>
                                Keuangan
                                <i class="right fa fa-angle-down"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="#"
                                   class="nav-link">
                                    <i class="fa fa-circle-o nav-icon" aria-hidden="true"></i>
                                    <p>Pos Keuangan</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#"
                                   class="nav-link">
                                    <i class="fa fa-circle-o nav-icon" aria-hidden="true"></i>
                                    <p>Jenis Pembayaran</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item has-treeview {{ request()->is('persediaan-keluar*') ? 'menu-open' : ''}}">
                        <a href="#" class="nav-link {{ request()->is('persediaan-keluar*') ? 'active' : ''}}">
                            <i class="nav-icon fa fa-database"></i>
                            <p>
                                Manajemen Data
                                <i class="right fa fa-angle-down"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="#"
                                   class="nav-link">
                                    <i class="fa fa-circle-o nav-icon" aria-hidden="true"></i>
                                    <p>Tahun Ajaran</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#"
                                   class="nav-link">
                                    <i class="fa fa-circle-o nav-icon" aria-hidden="true"></i>
                                    <p>Kelas</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#"
                                   class="nav-link">
                                    <i class="fa fa-circle-o nav-icon" aria-hidden="true"></i>
                                    <p>Siswa</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                </nav>
            </ul>
        </div>
    </div>
</aside>
<div class="content-wrapper p-3">
    @yield('content-title')
    @yield('content')
</div>
<footer class="main-footer">
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 3.2.0
    </div>
</footer>
<script src="{{ asset('/jQuery/jquery-3.4.1.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
<script src="{{ asset('/bootstrap/js/bootstrap.js') }}"></script>
<script src="{{ asset ('/adminlte/js/adminlte.js') }}"></script>
<script src="{{ asset('/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ asset('/datatables/dataTables.bootstrap4.min.js') }}"></script>
@yield('js')
</body>
</html>
