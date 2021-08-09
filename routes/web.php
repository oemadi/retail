<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes(['register' => false, 'reset' => false]);


Route::any('/getDataPenyesuaianStok', 'PenyesuaianStokController@getDataPenyesuaianStok')->name('getDataPenyesuaianStok');

Route::any('/getDataSuplier', 'SuplierController@getSuplier')->name('getDataSuplier');
Route::any('/getDataSuplierSelect', 'PenjualanController@getDataSuplierSelect')->name('getDataSuplierSelect');
Route::any('/getDataCustomer', 'CustomerController@getDataCustomer')->name('getDataCustomer');
Route::any('/getDataCabangSelect', 'PenjualanController@getDataCabangSelect')->name('getDataCabangSelect');
Route::any('/getDataMasterPegawai', 'PegawaiController@getDataMasterPegawai')->name('getDataMasterPegawai');
Route::any('/getDataBarang', 'BarangController@getBarang')->name('getDataBarang');
Route::any('/getDataSatuan', 'SatuanController@getSatuan')->name('getDataSatuan');
Route::any('/getDataKategori', 'KategoriController@getKategori')->name('getDataKategori');
Route::any('/getDataJabatan', 'JabatanController@getJabatan')->name('getDataJabatan');
Route::any('/getDataKas', 'KasController@getDataKas')->name('getDataKas');
Route::any('/getDataCabang', 'CabangController@getDataCabang')->name('getDataCabang');

Route::any('/getDataPenggajian', 'PenggajianController@getDataPenggajian')->name('getDataPenggajian');
Route::any('/getDataPegawaiSelect', 'PenggajianController@getDataPegawaiSelect')->name('getDataPegawaiSelect');
Route::any('/getDataPegawaiSelect2', 'PenggajianController@getDataPegawaiSelect2')->name('getDataPegawaiSelect2');

Route::any('/getDataBayarSuplier', 'BayarSuplierController@getDataBayarSuplier')->name('getDataBayarSuplier');
Route::get('/getDataBayarCustomer', 'BayarCustomerController@getDataBayarCustomer')->name('getDataBayarCustomer');

Route::any('/getDataFakturPembelianSelect', 'PembelianController@getDataFakturPembelianSelect')->name('getDataFakturPembelianSelect');
Route::any('/getDataFakturPenjualanSelect', 'PenjualanController@getDataFakturPenjualanSelect')->name('getDataFakturPenjualanSelect');
Route::any('/getDataFakturPembelian', 'PembelianController@getDataFakturPembelian')->name('getDataFakturPembelian');
Route::any('/getDataFakturPenjualan', 'PenjualanController@getDataFakturPenjualan')->name('getDataFakturPenjualan');

Route::any('/getDataPembelian', 'PembelianController@getDataPembelian')->name('getDataPembelian');
Route::any('/getDataPenjualan', 'PenjualanController@getDataPenjualan')->name('getDataPenjualan');

Route::any('/getDataReturnPenjualan', 'ReturnPenjualanController@getDataReturnPenjualan')->name('getDataReturnPenjualan');
Route::any('/getDataReturnPembelian', 'ReturnPembelianController@getDataReturnPembelian')->name('getDataReturnPembelian');


Route::any('/getDataCustomerSelect', 'PenjualanController@getDataCustomerSelect')->name('getDataCustomerSelect');
Route::any('/getDataMasterSuplier', 'SuplierController@getDataMasterSuplier')->name('getDataMasterSuplier');
Route::any('/getDataSuplierSelect', 'PenjualanController@getDataSuplierSelect')->name('getDataSuplierSelect');

Route::any('/getDataMasterBarang', 'BarangController@getDataMasterBarang')->name('getDataMasterBarang');

Route::any('/getDataBarang', 'PenjualanController@getDataBarang')->name('getDataBarang');
Route::any('/getDataBarangSelect2', 'PenjualanController@getDataBarangSelect2')->name('getDataBarangSelect2');


Route::any('/getHutangCustomer', 'HutangCustomerController@getHutangCustomer')->name('getHutangCustomer');
Route::any('/getHutangSuplier', 'HutangSuplierController@getHutangSuplier')->name('getHutangSuplier');


Route::any('/getDataHutangCustomer', 'BayarHutangController@getDataHutangCustomer')->name('getDataHutangCustomer');

Route::any('/getKodeFakturJual', 'PenjualanController@getKodeFakturJual')->name('getKodeFakturJual');

Route::any('/getDataStokMasuk', 'StokMasukController@getStokMasuk')->name('getDataStokMasuk');

Route::get('/pdf', 'DashboardController@pdf');
Route::group(['middleware' => 'auth'], function ($app) use ($router) {
    $app->get('/', 'DashboardController@dashboard')->name('dashboard')->middleware(['cek:Admin,Manager,Petugas']);
    $app->get('/grafikLabaRugi', 'DashboardController@grafikLabaRugi')->name('dashboard.grafik_laba')->middleware(['cek:Admin,Manager,Petugas']);


    $app->prefix('profile')->middleware(['cek:Admin,Manager,Petugas'])->name('profile.')->group(function ($app) use ($router) {
        $app->get('/', 'ProfileController@index')->name('index');
        $app->put('/', 'ProfileController@update')->name('update');
        $app->get('/password', 'ProfileController@password')->name('password');
        $app->put('/password', 'ProfileController@updatePassword')->name('update_password');
    });

    $app->resource('jabatan', 'JabatanController')->except(['show', 'destroy'])->middleware(['cek:Admin']);
    $app->prefix('jabatan')->middleware(['cek:Admin'])->name('jabatan.')->group(function ($app) use ($router) {
        $router->get('/{id}/delete', 'JabatanController@destroy')->name('destroy');
    });

    $app->resource('pegawai', 'PegawaiController')->except(['show', 'destroy'])->middleware(['cek:Admin']);
    $app->prefix('pegawai')->middleware(['cek:Admin'])->name('pegawai.')->group(function ($app) use ($router) {
        $router->get('/{id}/delete', 'PegawaiController@destroy')->name('destroy');
        $app->get('/create', 'PegawaiController@create')->name('create');
        $app->get('/{id}/edit', 'PegawaiController@edit')->name('edit');
    });
    $app->prefix('setting')->middleware(['cek:Admin'])->name('setting.')->group(function ($app) use ($router) {
        $app->get('/', 'SettingController@index')->name('index');
        $app->put('/', 'SettingController@update')->name('update');
    });
    $app->prefix('barang')->middleware(['cek:Admin'])->name('barang.')->group(function ($app) use ($router) {
        $app->get('/', 'BarangController@index')->name('index');
        $app->get('/create', 'BarangController@create')->name('create');
        $app->post('/store', 'BarangController@store')->name('store');
        $app->put('/{id}', 'BarangController@update')->name('update');
        $app->get('/{id}/edit', 'BarangController@edit')->name('edit');
        $app->get('/{id}/show', 'BarangController@show')->name('show');
        $app->get('/{id}/delete', 'BarangController@destroy')->name('destroy');
        // stok barang masuk

        $app->prefix('masuk')->name('masuk.')->group(function ($app) use ($router) {
            $app->get('/', 'StokMasukController@index')->name('index');
            $app->get('/create', 'StokMasukController@create')->name('create');
            $app->post('/store', 'StokMasukController@store')->name('store');
        });

        $app->prefix('barcode')->name('barcode.')->group(function ($app) use ($router) {
            $app->get('/', 'BarcodeController@index')->name('index');
            $app->get('/showBarcodes/{id}', 'BarcodeController@getBarcodes')->name('get_barcodes');
        });
    });
    $app->resource('satuan', 'SatuanController')->except(['show', 'destroy'])->middleware(['cek:Admin']);
    $app->prefix('satuan')->middleware(['cek:Admin'])->name('satuan.')->group(function ($app) use ($router) {
        $router->get('/{id}/delete', 'SatuanController@destroy')->name('destroy');
    });

    $app->resource('kategori', 'KategoriController')->except(['show'])->middleware(['cek:Admin']);
    $app->prefix('kategori')->middleware(['cek:Admin'])->name('kategori.')->group(function ($app) use ($router) {
        $router->get('/{id}/delete', 'KategoriController@destroy')->name('destroy');
    });
    $app->resource('cabang', 'CabangController')->except(['show'])->middleware(['cek:Admin']);
    $app->prefix('cabang')->middleware(['cek:Admin'])->name('cabang.')->group(function ($app) use ($router) {
        $router->get('/{id}/delete', 'CabangController@destroy')->name('destroy');
    });
    $app->resource('customer', 'CustomerController')->except(['show'])->middleware(['cek:Admin']);
    $app->prefix('customer')->middleware(['cek:Admin'])->name('customer.')->group(function ($app) use ($router) {
        $app->get('/', 'CustomerController@index')->name('index');
        $router->get('/{id}/delete', 'CustomerController@destroy')->name('destroy');
        $app->get('/{id}/edit', 'CustomerController@edit')->name('edit');
        $app->get('/{id}/show', 'CustomerController@show')->name('show');


    });

    $app->resource('user', 'UserController')->except('show')->middleware(['cek:Admin']);
    $app->prefix('user')->name('user.')->middleware(['cek:Admin'])->group(function ($app) use ($router) {
        $router->get('/{id}/delete', 'UserController@destroy')->name('destroy');
    });


    $app->resource('suplier', 'SuplierController')->except('show')->middleware(['cek:Admin']);
    $app->prefix('suplier')->middleware(['cek:Admin'])->name('suplier.')->group(function ($app) use ($router) {
        $router->get('/{id}/delete', 'SuplierController@destroy')->name('destroy');
    });

    $app->prefix('transaksi')->middleware(['cek:Admin,Petugas'])->name('transaksi.')->group(function ($app) use ($router) {
        $app->prefix('penggajian')->name('penggajian.')->group(function ($app) use ($router) {
            $app->get('/', 'PenggajianController@index')->name('index');
            $app->get('/create', 'PenggajianController@create')->name('create');
            $app->post('/store', 'PenggajianController@store')->name('store');
            // $app->get('/loadTable', 'PenggajianController@loadTable')->name('load_table');
            // $app->get('/getDetail/{id}', 'PenggajianController@get_detail')->name('get_detail');
            $app->get('/slip/{id}', 'PenggajianController@slip')->name('slip');
        });

        $app->prefix('bayarCustomer')->name('bayarCustomer.')->group(function ($app) use ($router) {
            $router->get('/{id}/show', 'BayarCustomerController@show')->name('show');
            $app->post('/store', 'BayarCustomerController@store')->name('store');
         });
        $app->prefix('hutangCustomer')->name('hutangCustomer.')->group(function ($app) use ($router) {
            $app->get('/', 'HutangCustomerController@index')->name('index');
        });
        $app->prefix('bayarSuplier')->name('bayarSuplier.')->group(function ($app) use ($router) {
            $router->get('/{id}/show', 'BayarSuplierController@show')->name('show');
            $app->post('/store', 'BayarSuplierController@store')->name('store');
         });
        $app->prefix('hutangSuplier')->name('hutangSuplier.')->group(function ($app) use ($router) {
            $app->get('/', 'HutangSuplierController@index')->name('index');
        });
        $app->prefix('return')->name('return.')->group(function ($app) use ($router) {
            $app->prefix('penjualan')->name('penjualan.')->group(function ($app) use ($router) {
                $app->get('/', 'ReturnPenjualanController@index')->name('index');
                $app->get('/create', 'ReturnPenjualanController@create')->name('create');
                $app->get('/getAllTransaksi', 'ReturnPenjualanController@getAllTransaksi')->name('get_all_transaksi');
                $app->get('/loadTable', 'ReturnPenjualanController@loadTable')->name('load_table');
                $app->get('/loadKotak', 'ReturnPenjualanController@loadKotak')->name('load_kotak');
                $app->get('/getTransaksyById/{id}', 'ReturnPenjualanController@getTransaksyById')->name('get_transaksi_by_id');
                $app->get('/loadDataReturn/{id}', 'ReturnPenjualanController@loadDataReturn')->name('load_data_return');
                $app->post('/addCart', 'ReturnPenjualanController@addCart')->name('add_cart');
                $app->post('/deleteReturn', 'ReturnPenjualanController@deleteReturn')->name('delete_return');
                $app->post('/store', 'ReturnPenjualanController@store')->name('store');
                $app->get('/loadModal/{id}', 'ReturnPenjualanController@loadModal')->name('load_modal');
            });
            $app->prefix('pembelian')->name('pembelian.')->group(function ($app) use ($router) {
                $app->get('/', 'ReturnPembelianController@index')->name('index');
                $app->get('/create', 'ReturnPembelianController@create')->name('create');
                $app->get('/loadBarangBeli/{id}', 'ReturnPembelianController@loadBarang')->name('load_barang');
                $app->post('/store', 'ReturnPembelianController@store')->name('store');
            });
            $app->prefix('penjualan')->name('penjualan.')->group(function ($app) use ($router) {
                $app->get('/', 'ReturnPenjualanController@index')->name('index');
                $app->get('/create', 'ReturnPenjualanController@create')->name('create');
                $app->get('/loadBarangBeli/{id}', 'ReturnPenjualanController@loadBarang')->name('load_barang');
                $app->post('/store', 'ReturnPenjualanController@store')->name('store');
            });
        });
        $app->prefix('kas')->name('kas.')->group(function ($app) use ($router) {
            $app->get('/', 'KasController@index')->name('index');
            $app->get('/create', 'KasController@create')->name('create');
            $app->post('/store', 'KasController@store')->name('store');
            $app->get('/loadTable', 'KasController@loadTable')->name('load_table');
            $app->get('/loadKotak', 'KasController@loadKotak')->name('load_kotak');
        });
        $app->prefix('penyesuaianStok')->name('penyesuaianStok.')->group(function ($app) use ($router) {
            $app->get('/', 'PenyesuaianStokController@index')->name('index');
            $app->get('/create', 'PenyesuaianStokController@create')->name('create');
            $app->post('/store', 'PenyesuaianStokController@store')->name('store');
          //  $router->get('/{id}/viewData', 'PenyesuaianStokController@viewData')->name('viewData');
        });
        $app->prefix('penyesuaian')->name('penyesuaian.')->group(function ($app) use ($router) {
            $app->get('/', 'PenyesuaianStokController@index')->name('index');
            $app->get('/create', 'PenyesuaianStokController@create')->name('create');
            $app->post('/store', 'PenyesuaianStokController@store')->name('store');
          //  $router->get('/{id}/viewData', 'PenyesuaianStokController@viewData')->name('viewData');
        });
        $app->prefix('pembelian')->name('pembelian.')->group(function ($app) use ($router) {
            $app->get('/', 'PembelianController@index')->name('index');
            $app->get('/create', 'PembelianController@create')->name('create');
            $app->post('/store', 'PembelianController@store')->name('store');
			 $router->get('/{id}/faktur', 'PembelianController@faktur')->name('faktur');
            $app->get('/loadKotak', 'PembelianController@loadKotakAtas')->name('load_kotak_atas');
            $app->get('/loadTable', 'PembelianController@loadTable')->name('load_table');
            $app->get('/loadModal/{id}', 'PembelianController@loadModal')->name('load_modal');
        });
        $app->prefix('penjualan')->name('penjualan.')->group(function ($app) use ($router) {
            $app->get('/', 'PenjualanController@index')->name('index');
            $app->get('/create', 'PenjualanController@create')->name('create');
            $app->post('/store', 'PenjualanController@store')->name('store');
            $router->get('/{id}/faktur', 'PenjualanController@faktur')->name('faktur');
            $app->get('/loadKotak', 'PenjualanController@loadKotakAtas')->name('load_kotak_atas');
            $app->get('/loadTable', 'PenjualanController@loadTable')->name('load_table');
            $app->get('/loadModal/{id}', 'PenjualanController@loadModal')->name('load_modal');
        });
        $app->prefix('grafik')->name('grafik.')->group(function ($app) use ($router) {
            $app->get('/', 'GrafikController@index')->name('index');
            $app->get('/getChartPenjualan', 'GrafikController@getChartPenjualan')->name('getChartPenjualan');
            $app->get('/getChartLaba', 'GrafikController@getChartLaba')->name('getChartLaba');
            $app->get('/getChartTerjual', 'GrafikController@getChartTerjual')->name('getChartTerjual');
        });
    });

    $app->prefix('report')->middleware(['cek:Admin,Manager'])->name('report.')->group(function ($app) use ($router) {
        $app->prefix('barang')->name('barang.')->group(function ($app) use ($router) {
            $app->get('/', 'ReportController@barang')->name('barang');
            $app->get('/print', 'ReportController@barangPrint')->name('print');
        });
        $app->prefix('customer')->name('customer.')->group(function ($app) use ($router) {
            $app->get('/', 'ReportController@customer')->name('customer');
            $app->get('/print', 'ReportController@customerPrint')->name('print');
        });
		 $app->prefix('suplier')->name('suplier.')->group(function ($app) use ($router) {
            $app->get('/', 'ReportController@suplier')->name('suplier');
            $app->get('/print', 'ReportController@suplierPrint')->name('print');
        });
		 $app->prefix('penyesuaianStok')->name('penyesuaianStok.')->group(function ($app) use ($router) {
			 $app->get('/print', 'ReportController@penyesuaianStokPrint')->name('print');

        });
		$app->prefix('penjualan')->name('penjualan.')->group(function ($app) use ($router) {
            $app->get('/', 'ReportController@penjualan')->name('penjualan');
            $app->get('/print', 'ReportController@penjualanPrint')->name('print');
        });
        $app->prefix('saldo')->name('saldo.')->group(function ($app) use ($router) {
            $app->get('/', 'ReportController@saldo')->name('saldo');
            $app->get('/print', 'ReportController@saldoPrint')->name('print');
        });
		$app->prefix('penjualanCabang')->name('penjualanCabang.')->group(function ($app) use ($router) {
            $app->get('/', 'ReportController@penjualanCabang')->name('penjualanCabang');
            $app->get('/print', 'ReportController@penjualanCabangPrint')->name('print');
        });
        $app->prefix('kas')->name('kas.')->group(function ($app) use ($router) {
            $app->get('/', 'ReportController@kas')->name('index');
            $app->get('/print', 'ReportController@kasPrint')->name('print');
        });
		$app->prefix('kasCabang')->name('kasCabang.')->group(function ($app) use ($router) {
            $app->get('/', 'ReportController@kasCabang')->name('kasCabang');
            $app->get('/print', 'ReportController@kasCabangPrint')->name('print');
        });
        $app->prefix('labarugi')->name('labarugi.')->group(function ($app) use ($router) {
            $app->get('/', 'ReportController@LabaRugiindex')->name('index');
            $app->get('/loadTable', 'ReportController@LabaRugiloadTable')->name('load_table');
            $app->get('/print', 'ReportController@LabaRugiPrint')->name('print');
        });

        $app->prefix('pembelian')->name('pembelian.')->group(function ($app) use ($router) {
            $app->get('/', 'ReportController@pembelian')->name('pembelian');
            $app->get('/print', 'ReportController@pembelianPrint')->name('print');
        });
		$app->prefix('pembelianCabang')->name('pembelianCabang.')->group(function ($app) use ($router) {
            $app->get('/', 'ReportController@pembelianCabang')->name('pembelianCabang');
            $app->get('/print', 'ReportController@pembelianCabangPrint')->name('print');
        });
        $app->prefix('bayarSuplier')->name('bayarSuplier.')->group(function ($app) use ($router) {
            $app->get('/', 'ReportController@bayarSuplier')->name('bayarSuplier');
            $app->get('/loadTable', 'ReportController@pembelianLoadTable')->name('load_table');
            $app->get('/print', 'ReportController@bayarSuplierPrint')->name('print');
            $app->get('/excel', 'ExportExcelController@pembelianExcel')->name('excel');
        });

        $app->prefix('bayarCustomer')->name('bayarCustomer.')->group(function ($app) use ($router) {
            $app->get('/', 'ReportController@bayarCustomer')->name('bayarCustomer');
            $app->get('/loadTable', 'ReportController@pembelianLoadTable')->name('load_table');
            $app->get('/print', 'ReportController@bayarCustomerPrint')->name('print');
            $app->get('/excel', 'ExportExcelController@pembelianExcel')->name('excel');
        });
		$app->prefix('tagihanCustomer')->name('tagihanCustomer.')->group(function ($app) use ($router) {
            $app->get('/', 'ReportController@tagihanCustomer')->name('tagihanCustomer');
            $app->get('/print', 'ReportController@tagihanCustomerPrint')->name('print');
        });
		$app->prefix('tagihanCustomerCabang')->name('tagihanCustomerCabang.')->group(function ($app) use ($router) {
            $app->get('/', 'ReportController@tagihanCustomerCabang')->name('tagihanCustomerCabang');
            $app->get('/print', 'ReportController@tagihanCustomerCabangPrint')->name('print');
        });
        $app->prefix('grafik')->name('grafik.')->group(function ($app) use ($router) {
            $app->get('/', 'GrafikController@index')->name('index');
            $app->get('/getChartPenjualan', 'GrafikController@getChartPenjualan')->name('getChartPenjualan');
            $app->get('/getChartLaba', 'GrafikController@getChartLaba')->name('getChartLaba');
            $app->get('/getChartTerjual', 'GrafikController@getChartTerjual')->name('getChartTerjual');
        });

        $app->prefix('hutang')->name('hutang.')->group(function ($app) use ($router) {
            $app->get('/', 'ReportController@hutang')->name('index');
            $app->get('/loadTable', 'ReportController@hutangLoadTable')->name('load_table');
            $app->get('/print', 'ReportController@hutangPrint')->name('print');
            $app->get('/loadKotakAtas', 'ReportController@hutangLoadKotak')->name('load_kotak');
            $app->get('/excel', 'ExportExcelController@hutangExcel')->name('excel');
        });
        $app->prefix('penggajian')->name('penggajian.')->group(function ($app) use ($router) {
            $app->get('/', 'ReportController@penggajian')->name('index');
            $app->get('/loadTable', 'ReportController@penggajianLoadTable')->name('load_table');
            $app->get('/print', 'ReportController@penggajianPrint')->name('print');
            $app->get('/excel', 'ExportExcelController@penggajianExcel')->name('excel');
        });
        $app->prefix('piutang')->name('piutang.')->group(function ($app) use ($router) {
            $app->get('/', 'ReportController@piutang')->name('index');
            $app->get('/loadTable', 'ReportController@piutangLoadTable')->name('load_table');
            $app->get('/print', 'ReportController@piutangPrint')->name('print');
            $app->get('/loadKotakAtas', 'ReportController@piutangLoadKotak')->name('load_kotak');
            $app->get('/excel', 'ExportExcelController@piutangExcel')->name('excel');
        });
        $app->prefix('rekap')->name('rekap.')->group(function ($app) use ($router) {
            $app->get('/', 'RekapController@index')->name('index');
            $app->get('/loadTable', 'RekapController@loadTable')->name('load_table');
            $app->get('/print', 'RekapController@print')->name('print');
        });
    });
    $app->prefix('laporan')->middleware(['cek:Admin,Manager,Petugas'])->name('laporan.')->group(function ($app) use ($router) {
        $app->prefix('grafik')->name('grafik.')->group(function ($app) use ($router) {
            $app->get('/', 'GrafikController@index')->name('index');
            $app->get('/getChartPenjualan', 'GrafikController@getChartPenjualan')->name('getChartPenjualan');
            $app->get('/getChartLaba', 'GrafikController@getChartLaba')->name('getChartLaba');
            $app->get('/getChartTerjual', 'GrafikController@getChartTerjual')->name('getChartTerjual');
        });
    });


});
