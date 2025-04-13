<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <img src="{{ asset('AdminLTE/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">DKM</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Dashboard link -->
                <li class="nav-item">
                    <a href="{{ route('welcome') }}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <!-- Master dropdown -->
                @if (Auth::user()->jabatan == 'Bendahara DKM'|| Auth::user()->jabatan == 'Petugas Qurban')
                @else
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>
                            Data Master
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('donatur.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-th"></i>
                                <p>Donatur</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('register') }}" class="nav-link">
                                <i class="nav-icon fas fa-th"></i>
                                <p>Petugas</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('mustahik.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-th"></i>
                                <p>Mustahik</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('muzakki.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-th"></i>
                                <p>Muzakki</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endif
                 <!-- Master dropdown -->
                 @if (Auth::user()->jabatan == 'Bendahara DKM' || Auth::user()->jabatan == 'Petugas Qurban')
                @else
                 <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>
                            Data Infaq
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('infaq.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-th"></i>
                                <p>Infaq</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('infaq.report') }}" class="nav-link">
                                <i class="nav-icon fas fa-th"></i>
                                <p>Laporan Infaq</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endif
                <!-- Master dropdown -->
                @if (Auth::user()->jabatan == 'Bendahara DKM' || Auth::user()->jabatan == 'Petugas Qurban')
                @else
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>
                            Data Zakat
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('zakat.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-th"></i>
                                <p>Zakat</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('zakat.report') }}" class="nav-link">
                                <i class="nav-icon fas fa-th"></i>
                                <p>Laporan Zakat</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endif
                <!-- Master dropdown -->
                @if (Auth::user()->jabatan == 'Administrator' || Auth::user()->jabatan == 'Petugas Qurban')
                @else
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>
                            Data Penyaluran
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('penyaluran.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-th"></i>
                                <p>Zakat</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endif
                <!-- Master dropdown -->
                @if (Auth::user()->jabatan == 'Administrator' || Auth::user()->jabatan == 'Petugas Qurban')
                @else
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>
                            Data Pengeluaran
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('pengeluaran.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-th"></i>
                                <p>Pengeluaran</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endif
                <!-- Master dropdown -->
                @if (Auth::user()->jabatan == 'Bendahara DKM'|| Auth::user()->jabatan == 'Administrator')
                @else
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>
                            Data Qurban
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('petugas.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-th"></i>
                                <p>Petugas Qurban</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('penerima-qurban.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-th"></i>
                                <p>Penerima Qurban</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('shohibul-qurban.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-th"></i>
                                <p>Shohibul Qurban</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('aturan-pembagian.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-th"></i>
                                <p>Aturan Pembagian</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('nasabah-qurban.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-th"></i>
                                <p>Nasabah Qurban</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('harga-hewan-qurban.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-tags"></i>
                                <p>Harga Hewan Qurban</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('tabungan-qurban.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-money-bill"></i>
                                <p>Tabungan Qurban</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('keuangan-qurban.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-money-bill"></i>
                                <p>Keuangan Qurban</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('shohibul-qurban.report') }}" class="nav-link">
                                <i class="nav-icon fas fa-file-alt"></i>
                                <p>Laporan Shohibul Qurban</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('penerima-qurban.report') }}" class="nav-link">
                                <i class="nav-icon fas fa-file-alt"></i>
                                <p>Laporan Distribusi Qurban</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('shohibul-qurban.laporan-hewan') }}" class="nav-link">
                                <i class="nav-icon fas fa-file-alt"></i>
                                <p>Laporan Hewan Qurban</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('shohibul-qurban.nametag-hewan') }}" class="nav-link">
                                <i class="nav-icon fas fa-tag"></i>
                                <p>Nametag Hewan Qurban</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endif
                @if (Auth::user()->jabatan == 'Bendahara DKM' || Auth::user()->jabatan == 'Petugas Qurban')
                @else
                <li class="nav-item">
                    <a href="{{ route('sholat.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Sholat</p>
                    </a>
                </li>
                @endif
                @if (Auth::user()->jabatan == 'Bendahara DKM' || Auth::user()->jabatan == 'Petugas Qurban')
                @else
                <li class="nav-item">
                    <a href="{{ route('kajian.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Kegiatan</p>
                    </a>
                </li>
                @endif
                @if (Auth::user()->jabatan == 'Bendahara DKM' || Auth::user()->jabatan == 'Petugas Qurban')
                @else
                <li class="nav-item">
                    <a href="{{ route('inventories.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Inventori</p>
                    </a>
                </li>

                @endif
                <!-- Logout link -->
                <li class="nav-item">
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    <a href="#" class="nav-link"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Logout</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
