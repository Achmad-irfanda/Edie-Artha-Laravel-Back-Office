<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <!-- LOGO -->
    <div class="navbar-brand-box">
        <a href="{{ url('index') }}" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ URL::asset('/assets/images/eam-logo.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('/assets/images/eam-logo.png') }}" alt="" height="20">
            </span>
        </a>

        <a href="{{ url('index') }}" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ URL::asset('/assets/images/eam-logo.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('/assets/images/eam-logo.png') }}" alt="" height="20">
            </span>
        </a>
    </div>

    <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect vertical-menu-btn">
        <i class="fa fa-fw fa-bars"></i>
    </button>

    <div data-simplebar class="sidebar-menu-scroll">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">

                @if (Auth::user()->role == 'ADMIN_GUDANG')
                    <li class="menu-title">Dashboard</li>

                    <li>
                        <a href="{{ route('retail.dashboard') }}">
                            <i class="uil-home-alt"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    <li class="menu-title">Data</li>
                    <li>
                        <a href="{{ route('product.index') }}" class="waves-effect">
                            <i class="uil-store"></i>
                            <span>Sparepart</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('product.create') }}" class=" waves-effect">
                            <i class="uil-plus-circle"></i>
                            <span>Tambah Sparepart</span>
                        </a>
                    </li>
                    <li class="menu-title">Transaksi</li>

                    <li>
                        <a href="{{ route('transaction.index') }}" class=" waves-effect">
                            <i class="uil-invoice"></i>
                            <span>Riwayat Transaksi</span>
                        </a>
                    </li>
                @endif
                @if (Auth::user()->role == 'ADMIN_MEKANIK')
                    <li class="menu-title">Dashboard</li>

                    <li>
                        <a href="{{ route('bengkel.dashboard') }}">
                            <i class="uil-home-alt"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    <li class="menu-title">Data</li>
                    <li>
                        <a href="{{ route('mekanik.index') }}" class=" waves-effect">
                            <i class="uil-wrench"></i>
                            <span>Mekanik</span>
                        </a>
                    </li>



                    <li>
                        <a href="{{ route('mekanik.create') }}" class=" waves-effect">
                            <i class="uil-plus-circle"></i>
                            <span>Tambah Mekanik</span>
                        </a>
                    </li>

                    <li class="menu-title">Transaksi</li>

                    <li>
                        <a href="{{ route('bengkel.transaction') }}" class=" waves-effect">
                            <i class="uil-invoice"></i>
                            <span>Riwayat Transaksi</span>
                        </a>
                    </li>
                @endif


            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
