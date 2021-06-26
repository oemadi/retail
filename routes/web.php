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
Route::any('/getDataSuplier', 'SuplierController@getSuplier')->name('getDataSuplier');
Route::any('/getDataAnggota', 'AnggotaController@getAnggota')->name('getDataAnggota');
Route::any('/getDataPegawai', 'PegawaiController@getPegawai')->name('getDataPegawai');
Route::any('/getDataBarang', 'BarangController@getBarang')->name('getDataBarang');
Route::any('/getDataSatuan', 'SatuanController@getSatuan')->name('getDataSatuan');
Route::any('/getDataKategori', 'KategoriController@getKategori')->name('getDataKategori');
Route::any('/getDataJabatan', 'JabatanController@getJabatan')->name('getDataJabatan');
Route::any('/getDataKas', 'KasController@getKas')->name('getDataKas');

Route::any('/getDataPenggajian', 'PenggajianController@getDataPenggajian')->name('getDataPenggajian');
Route::any('/getDataPegawaiSelect', 'PenggajianController@getDataPegawaiSelect')->name('getDataPegawaiSelect');
Route::any('/getDataPegawaiSelect2', 'PenggajianController@getDataPegawaiSelect2')->name('getDataPegawaiSelect2');

Route::any('/getDataBayarCustomer', 'BayarCustomerController@getDataBayarCustomer')->name('getDataBayarCustomer');

Route::any('/getDataFakturPenjualanSelect', 'PenjualanController@getDataFakturPenjualanSelect')->name('getDataFakturPenjualanSelect');
Route::any('/getDataFakturPenjualan', 'PenjualanController@getDataFakturPenjualan')->name('getDataFakturPenjualan');

Route::any('/getDataPembelian', 'PembelianController@getDataPembelian')->name('getDataPembelian');
Route::any('/getDataPenjualan', 'PenjualanController@getDataPenjualan')->name('getDataPenjualan');

Route::any('/getDataCustomer', 'PenjualanController@getDataCustomer')->name('getDataCustomer');
Route::any('/getDataSuplier', 'PenjualanController@getDataSuplier')->name('getDataSuplier');
Route::any('/getDataBarang', 'PenjualanController@getDataBarang')->name('getDataBarang');
Route::any('/getDataBarangSelect2', 'PenjualanController@getDataBarangSelect2')->name('getDataBarangSelect2');


Route::any('/getHutangCustomer', 'HutangCustomerController@getHutangCustomer')->name('getHutangCustomer');

Route::any('/getDataHutangCustomer', 'BayarHutangController@getDataHutangCustomer')->name('getDataHutangCustomer');

Route::any('/getKodeFakturJual', 'PenjualanController@getKodeFakturJual')->name('getKodeFakturJual');

Route::any('/getDataAnggotaSelect', 'KasirController@getDataAnggotaSelect')->name('getDataAnggotaSelect');

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

    $app->resource('anggota', 'anggotaController')->except('show')->middleware(['cek:Admin']);
    $app->prefix('anggota')->middleware(['cek:Admin'])->name('anggota.')->group(function ($app) use ($router) {
        $router->get('/{id}/delete', 'anggotaController@destroy')->name('destroy');
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
            // $app->get('/', 'BayarCustomerController@index')->name('index');
            $router->get('/{id}/show', 'BayarCustomerController@show')->name('show');
          //  $router->get('/{id}/view', 'BayarCustomerController@create')->name('view');
            $app->post('/store', 'BayarCustomerController@store')->name('store');
         });
        $app->prefix('hutangCustomer')->name('hutangCustomer.')->group(function ($app) use ($router) {
            $app->get('/', 'HutangCustomerController@index')->name('index');
        });
        // $app->prefix('piutang')->name('piutang.')->group(function ($app) use ($router) {
        //     $app->get('/', 'PiutangController@index')->name('index');
        //     $app->get('/loadTable', 'PiutangController@loadTable')->name('load_table');
        //     $app->get('/loadModal/{id}', 'PiutangController@loadModal')->name('load_modal');
        //     $app->get('/loadData/getPiutangById/{id}', 'PiutangController@getPiutangById')->name('get_piutang_by_id');
        //     $app->get('/loadKotakAtas', 'PiutangController@loadKotakAtas')->name('load_kotak_atas');
        //     $app->post('/update', 'PiutangController@updatePiutang')->name('proses_bayar_piutang');
        // });
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
                $app->post('/store', 'ReturnPenjualanController@store')->name('submit');
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
        $app->prefix('pembelian')->name('pembelian.')->group(function ($app) use ($router) {
            $app->get('/', 'PembelianController@index')->name('index');
            $app->get('/create', 'PembelianController@create')->name('create');
            $app->post('/store', 'PembelianController@store')->name('store');
            $app->get('/loadKotak', 'PembelianController@loadKotakAtas')->name('load_kotak_atas');
            $app->get('/loadTable', 'PembelianController@loadTable')->name('load_table');
            $app->get('/loadModal/{id}', 'PembelianController@loadModal')->name('load_modal');
        });
        $app->prefix('penjualan')->name('penjualan.')->group(function ($app) use ($router) {
            $app->get('/', 'PenjualanController@index')->name('index');
            $app->get('/create', 'PenjualanController@create')->name('create');
            $app->post('/store', 'PenjualanController@store')->name('store');
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
        $app->prefix('penjualan')->name('penjualan.')->group(function ($app) use ($router) {
            $app->get('/barang', 'ReportController@penjualanPerBarang')->name('barang');
            $app->get('/barang/loadTable', 'ReportController@penjualanPerBarangLoadTable')->name('barang_load_table');
            $app->get('/barang/print', 'ReportController@penjualanPerBarangPrint')->name('barang_print');
            $app->get('/barang/excel', 'ExportExcelController@penjualanBarangExport')->name('barang_export');


            $app->get('/periode', 'ReportController@penjualanPerPeriode')->name('periode');
            $app->get('/periode/loadTable', 'ReportController@penjualanPerPeriodeLoadTable')->name('periode_load_table');
            $app->get('/periode/print', 'ReportController@penjualanPerPeriodePrint')->name('periode_print');
            $app->get('/periode/excel', 'ExportExcelController@penjualanPeriodeExport')->name('barang_periode');
        });
        $app->prefix('kas')->name('kas.')->group(function ($app) use ($router) {
            $app->get('/', 'ReportController@kas')->name('index');
            $app->get('/loadTable', 'ReportController@kasloadTable')->name('load_table');
            $app->get('/loadKotak', 'ReportController@kasloadKotak')->name('load_kotak');
            $app->get('/print', 'ReportController@kasPrint')->name('print');
            $app->get('/excel', 'ExportExcelController@kasExcel')->name('excel');
        });

        $app->prefix('labarugi')->name('labarugi.')->group(function ($app) use ($router) {
            $app->get('/', 'ReportController@LabaRugiindex')->name('index');
            $app->get('/loadTable', 'ReportController@LabaRugiloadTable')->name('load_table');
            $app->get('/print', 'ReportController@LabaRugiPrint')->name('print');
            $app->get('/excel', 'ExportExcelController@labarugiExcel')->name('excel');
        });

        $app->prefix('pembelian')->name('pembelian.')->group(function ($app) use ($router) {
            $app->get('/', 'ReportController@pembelian')->name('pembelian');
            $app->get('/loadTable', 'ReportController@pembelianLoadTable')->name('load_table');
            $app->get('/print', 'ReportController@pembelianPrint')->name('print');
            $app->get('/excel', 'ExportExcelController@pembelianExcel')->name('excel');
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
