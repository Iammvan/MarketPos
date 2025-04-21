<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>@yield('title') - MarketPOS</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
    <link rel="icon" href="{{ asset('assets/img/kaiadmin/favicon.ico') }}" type="image/x-icon" />

    <!-- Fonts and icons -->
    <script src="{{ asset('assets/js/plugin/webfront/webfront.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/webfont/webfont.min.js') }}"></script>

    <script>
        WebFont.load({
            google: {
                families: ["Public Sans:300,400,500,600,700"]
            },
            custom: {
                families: [
                    "Font Awesome 5 Solid",
                    "Font Awesome 5 Regular",
                    "Font Awesome 5 Brands",
                    "simple-line-icons",
                ],
                urls: ["assets/css/fonts.min.css"],
            },
            active: function() {
                sessionStorage.fonts = true;
            },
        });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/plugins.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/kaiadmin.min.css') }}" />

    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />
</head>

<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <div class="sidebar" data-background-color="dark">
            <div class="sidebar-logo">
                <div class="logo-header" data-background-color="dark">
                    <div class="nav-toggle">
                        <button class="btn btn-toggle toggle-sidebar">
                            <i class="gg-menu-right"></i>
                        </button>
                        <button class="btn btn-toggle sidenav-toggler">
                            <i class="gg-menu-left"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="sidebar-wrapper scrollbar scrollbar-inner">
                <div class="sidebar-content">
                    <ul class="nav nav-secondary">
                        <li class="nav-item">
                            <a href="{{ route('kategori.index') }}">
                                <i class="fas fa-desktop"></i>
                                <p>Kategori</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('barang.index') }}">
                                <i class="fas fa-desktop"></i>
                                <p>Barang</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('pemasok.index') }}">
                                <i class="fas fa-desktop"></i>
                                <p>Pemasok</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('pembelian.index') }}">
                                <i class="fas fa-desktop"></i>
                                <p>Pembelian Barang</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('user.index') }}">
                                <i class="fas fa-desktop"></i>
                                <p>User</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('pengajuan.index') }}">
                                <i class="fas fa-file-alt"></i>
                                <p>Pengajuan Barang</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('absensi.index') }}">
                                <i class="fas fa-file-alt"></i>
                                <p>Absensi Barang</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- End Sidebar -->

        <div class="main-panel">
            <div class="main-header">
                <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
                    <div class="container-fluid">
                        <nav
                            class="navbar navbar-header-left navbar-expand-lg navbar-form nav-search p-0 d-none d-lg-flex">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <button type="submit" class="btn btn-search pe-1">
                                        <i class="fa fa-search search-icon"></i>
                                    </button>
                                </div>
                                <input type="text" placeholder="Search ..." class="form-control" />
                            </div>
                        </nav>

                        <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
                            <li class="nav-item topbar-icon hidden-caret">
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="nav-link bg-transparent border-0"
                                        style="cursor: pointer;">
                                        <i class="fas fa-sign-out-alt"></i>
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>

            <div class="container">
                @yield('content')
            </div>

            <footer class="footer">
                <div class="container-fluid d-flex justify-content-center">
                    <div class="copyright">
                        2025, ivan kodari <i class="fa fa-heart heart text-danger"></i>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- Core JS Files -->
    <script src="{{ asset('assets/js/core/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/chart.js/chart.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/chart-circle/circles.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/jsvectormap/jsvectormap.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/jsvectormap/world.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('assets/js/kaiadmin.min.js') }}"></script>
</body>

</html>
