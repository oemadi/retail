<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ url('public/asset_toko') }}/{{logo()}}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{ Auth::user()->nama }}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MAIN NAVIGATION</li>
            <li class="{{ set_active('dashboard') }}">
                <a href="{{ route('dashboard') }}">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>
            </li>
            @if (Auth::user()->level == "Admin")
            <li
                class="treeview {{ set_active(['satuan.index','satuan.create','satuan.edit','kategori.index','kategori.create','kategori.edit','barang.create','barang.index','barang.edit','barang.masuk.index','barang.masuk.create','barang.barcode.index']) }}">
                <a href="#">
                    <i class="fa fa-archive"></i>
                    <span>Barang</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ set_active(['satuan.index','satuan.create','satuan.edit']) }}">
                        <a href="{{ route('satuan.index') }}"><i class="fa fa-circle-o"></i> Satuan</a>
                    </li>

                    <li class="{{ set_active(['kategori.index','kategori.create','kategori.edit']) }}">
                        <a href="{{ route('kategori.index') }}"><i class="fa fa-circle-o"></i> Kategori</a>
                    </li>

                    <li class="{{ set_active(['barang.index','barang.create','barang.edit']) }}">
                        <a href="{{ route('barang.index') }}"><i class="fa fa-circle-o"></i> Barang</a>
                    </li>
                    {{-- <li class="{{ set_active(['barang.masuk.index']) }}">
                        <a href="{{ route('barang.masuk.index') }}"><i class="fa fa-circle-o"></i> Stok Masuk</a>
                    </li> --}}
                </ul>
            </li>
            @endif


            @if (Auth::user()->level == "Admin")
            <li
                class="treeview {{ set_active(['suplier.index','suplier.create','suplier.edit','customer.create','customer.index','customer.edit','pegawai.create','pegawai.index','pegawai.edit']) }}">
                <a href="#">
                    <i class="fa fa-folder"></i>
                    <span>Master Data</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ set_active(['suplier.index','suplier.create','suplier.edit']) }}">
                        <a href="{{ route('suplier.index') }}">
                            <i class="fa fa-truck"></i> <span>Suplier</span>
                        </a>
                    </li>
                    <li class="{{ set_active(['customer.create','customer.index','customer.edit']) }}">
                        <a href="{{ route('customer.index') }}">
                            <i class="fa fa-user"></i> <span>Customer</span>
                        </a>
                    </li>
                    <li class="{{ set_active(['pegawai.create','pegawai.index','pegawai.edit']) }}">
                        <a href="{{ route('pegawai.index') }}">
                            <i class="fa fa-user"></i> <span>Pegawai</span>
                        </a>
                    </li>
                </ul>
            </li>
            @endif

            {{-- @if (Auth::user()->level == "Admin" or Auth::user()->level == "Petugas")

            <li class="{{ set_active(['kasir.index']) }}">
                <a href="{{ route('kasir.index') }}">
                    <i class="fa fa-th"></i> <span>Kasir</span>
                </a>
            </li>
            @endif --}}

            @if (Auth::user()->level == "Admin" or Auth::user()->level == "Petugas")
            <li
                class="treeview {{ set_active(['transaksi.hutangSuplier.index','transaksi.hutangCustomer.index','transaksi.penjualan.index','transaksi.penjualan.create','transaksi.penyesuaianStok.index','transaksi.penyesuaianStok.create','transaksi.piutang.index','transaksi.return.penjualan.index','transaksi.pembelian.index','transaksi.pembelian.create','transaksi.hutang.index','transaksi.return.penjualan.index','transaksi.return.penjualan.create','transaksi.return.pembelian.index','transaksi.return.pembelian.create','transaksi.penjualan.periode.index','transaksi.penjualan.barang.index','transaksi.penggajian.index','transaksi.penggajian.create','transaksi.kas.index','transaksi.kas.create','transaksi.penjualan.all']) }}">
                <a href="#">
                    <i class="fa fa-pie-chart"></i>
                    <span>Transaksi</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ set_active(['transaksi.penyesuaianStok.index','transaksi.penyesuaianStok.create','transaksi.penyesuaianStok.create']) }}">
                        <a href="{{ route('transaksi.penyesuaianStok.index') }}"><i class="fa fa-money"></i> Penyesuaian Stok</a>
                    </li>
                    <li class="{{ set_active(['transaksi.kas.index','transaksi.kas.create']) }}">
                        <a href="{{ route('transaksi.kas.index') }}"><i class="fa fa-money"></i> Kas</a>
                    </li>
                    <li class="{{ set_active(['transaksi.pembelian.index','transaksi.pembelian.create']) }}">
                        <a href="{{ route('transaksi.pembelian.index') }}"><i class="fa fa-shopping-basket"></i>
                            Pembelian</a>
                    </li>
                    <li class="{{ set_active(['transaksi.penjualan.index','transaksi.penjualan.create']) }}">
                        <a href="{{ route('transaksi.penjualan.index') }}"><i class="fa fa-shopping-basket"></i>
                            Penjualan</a>
                    </li>
                    <li class="{{ set_active(['transaksi.penggajian.index','transaksi.penggajian.create']) }}">
                        <a href="{{ route('transaksi.penggajian.index') }}"><i class="fa fa-credit-card"></i>
                            Penggajian</a>
                    </li>

                    <li class="{{ set_active(['transaksi.hutangSuplier.index']) }}">
                        <a href="{{ route('transaksi.hutangSuplier.index') }}"><i class="fa fa-calendar-o"></i>
                            Hutang Suplier</a>
                    </li>

                    <li class="{{ set_active(['transaksi.hutangCustomer.index']) }}">
                        <a href="{{ route('transaksi.hutangCustomer.index') }}"><i class="fa fa-calendar-o"></i>
                            Hutang Customer</a>
                    </li>

                    <li
                        class="treeview {{ set_active(['transaksi.return.penjualan.index','transaksi.return.penjualan.create','transaksi.return.pembelian.index','transaksi.return.pembelian.create']) }}">
                        <a href="#"><i class="fa fa-sticky-note"></i> Return
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li
                                class="{{ set_active(['transaksi.return.penjualan.index','transaksi.return.penjualan.create']) }}">
                                <a href="{{ route('transaksi.return.penjualan.index') }}"><i class="fa fa-circle-o"></i>
                                    Penjualan</a></li>
                            <li
                                class="{{ set_active(['transaksi.return.pembelian.index','transaksi.return.pembelian.create']) }}">
                                <a href="{{ route('transaksi.return.pembelian.index') }}"><i class="fa fa-circle-o"></i>
                                    Pembelian</a></li>
                        </ul>
                    </li>
                </ul>
            </li>
            @endif

            @if (Auth::user()->level == "Admin" or Auth::user()->level == "Manager")
            <li
                class="treeview {{ set_active(['report.barang.barang','report.suplier.suplier','report.customer.customer',
                'report.saldo.saldo','report.pembelian.pembelian','report.pembelianCabang.pembelianCabang','report.kas.index',
                'report.kasCabang.kasCabang','report.penjualan.penjualan',
                'report.penjualanCabang.penjualanCabang','report.bayarCustomer.bayarCustomer','report.bayarSuplier.bayarSuplier',
                'report.tagihanCustomer.tagihanCustomer','report.tagihanCustomerCabang.tagihanCustomerCabang','report.penggajian.index']) }}">
                <a href="#">
                    <i class="fa fa-pie-chart"></i>
                    <span>Report</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ set_active(['report.barang.barang']) }}">
                        <a href="{{ route('report.barang.barang') }}"><i class="fa fa-bar-chart"></i>
                            Stok Barang</a>
                    </li>
                    <li class="{{ set_active(['report.customer.customer']) }}">
                        <a href="{{ route('report.customer.customer') }}"><i class="fa fa-user"></i>
                            Customer</a>
                    </li>
					  <li class="{{ set_active(['report.suplier.suplier']) }}">
                        <a href="{{ route('report.suplier.suplier') }}"><i class="fa fa-user"></i>
                            Suplier</a>
                    </li>
					<li class="{{ set_active(['report.saldo.saldo']) }}">
                        <a href="{{ route('report.saldo.saldo') }}"><i class="fa fa-money"></i>
                            Laba Rugi Penjualan</a>
                    </li>
                    <li class="{{ set_active(['report.penjualan.penjualan']) }}">
                        <a href="{{ route('report.penjualan.penjualan') }}"><i class="fa fa-shopping-cart"></i>
                            Penjualan</a>
                    </li>
					<li class="{{ set_active(['report.penjualanCabang.penjualanCabang']) }}">
                        <a href="{{ route('report.penjualanCabang.penjualanCabang') }}"><i class="fa fa-shopping-cart"></i>
                            Penjualan All Cabang</a>
                    </li>
                    <li class="{{ set_active(['report.pembelian.pembelian']) }}">
                        <a href="{{ route('report.pembelian.pembelian') }}"><i class="fa fa-shopping-cart"></i>
                            Pembelian</a>
                    </li>
					<li class="{{ set_active(['report.pembelianCabang.pembelianCabang']) }}">
                        <a href="{{ route('report.pembelianCabang.pembelianCabang') }}"><i class="fa fa-shopping-cart"></i>
                            Pembelian All Cabang</a>
                    </li>
                    <li class="{{ set_active(['report.bayarSuplier.bayarSuplier']) }}">
                        <a href="{{ route('report.bayarSuplier.bayarSuplier') }}"><i class="fa fa-calendar-minus-o"></i> Bayar ke Suplier</a>
                    </li>
                    <li class="{{ set_active(['report.bayarCustomer.bayarCustomer']) }}">
                        <a href="{{ route('report.bayarCustomer.bayarCustomer') }}"><i class="fa fa-money"></i> Bayar dari Customer</a>
                    </li>
					 <li class="{{ set_active(['report.tagihanCustomer.tagihanCustomer']) }}">
                        <a href="{{ route('report.tagihanCustomer.tagihanCustomer') }}"><i class="fa fa-money"></i> Tagihan Customer</a>
                    </li>
					 <li class="{{ set_active(['report.tagihanCustomerCabang.tagihanCustomerCabang']) }}">
                        <a href="{{ route('report.tagihanCustomerCabang.tagihanCustomerCabang') }}"><i class="fa fa-money"></i> Tagihan Customer All Cabang</a>
                    </li>
                    <li class="{{ set_active(['report.kas.index']) }}">
                        <a href="{{ route('report.kas.index') }}"><i class="fa fa-money"></i> Kas</a>
                    </li>
					<li class="{{ set_active(['report.kasCabang.kasCabang']) }}">
                        <a href="{{ route('report.kasCabang.kasCabang') }}"><i class="fa fa-money"></i> Kas All Cabang</a>
                    </li>
                    {{-- <li class="{{ set_active(['report.labarugi.index']) }}">
                        <a href="{{ route('report.labarugi.index') }}"><i class="fa fa-line-chart"></i> Laba Rugi</a>
                    </li> --}}
                    <li class="{{ set_active(['report.penggajian.index']) }}">
                        <a href="{{ route('report.penggajian.index') }}"><i class="fa fa-money"></i> Penggajian</a>
                    </li>
                    {{-- <li class="{{ set_active(['report.grafik.index']) }}">
                        <a href="{{ route('report.grafik.index') }}"><i class="fa fa-bar-chart"></i> Grafik</a>
                    </li>
                    <li class="{{ set_active(['report.rekap.index']) }}">
                        <a href="{{ route('report.rekap.index') }}"><i class="fa fa-pie-chart"></i> Rekap</a>
                    </li> --}}
                </ul>
            </li>
            @endif


            @if (Auth::user()->level == "Admin")
            <li class="header">Pengaturan</li>
            <li class="{{ set_active(['user.create','user.index','user.edit']) }}">
                <a href="{{ route('user.index') }}">
                    <i class="fa fa-users"></i> <span>Pengguna</span>
                </a>
            </li>
            <li class="{{ set_active(['cabang.create','cabang.index','cabang.edit']) }}">
                <a href="{{ route('cabang.index') }}">
                    <i class="fa fa-gear"></i> <span>Cabang</span>
                </a>
            </li>
            {{-- <li class="{{ set_active(['setting.index']) }}">
                <a href="{{ route('setting.index') }}">
                    <i class="fa fa-gear"></i> <span>Pengaturan Toko</span>
                </a>
            </li> --}}
            @endif
        </ul>
    </section>

</aside>
