<?php

namespace App\Http\Controllers;

use App\Barang;
use App\Cabang;
use App\Customer;
use App\Return_penjualan;
use App\Suplier;
use App\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Saldo;
use Session;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $data_branch = Cabang::where('id',$user->branch)->first();
        Session::put(array('branch'=>$user->branch,'branch_name'=>$data_branch->nama));
        $totalBarang = Barang::count();
        $totalCustomer = Customer::count();
        $omsetBulanIni = Saldo::getOmsetBulanIni();
        $labaRugi = Saldo::getLabaBulanIni();
        $pengingat  = Barang::where('stok_akhir', '<', 5)->orderBy('stok_akhir', 'ASC')->get();
        $terlaris = Barang::orderBy('stok_keluar', 'DESC')->get();
        return view('pages.dashboard', compact('totalBarang', 'totalCustomer', 'omsetBulanIni', 'labaRugi', 'pengingat', 'terlaris'));
      //  dd(branch);
    }

    public function grafikLabaRugi()
    {
        $bulanRow = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        $laba = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
        $lb = [];
        $rg = [];
        $transaksi = Transaksi::whereYear('tanggal_transaksi', date('Y'))->get();

        foreach ($transaksi as $row) {
            $bulan = explode('-', $row->tanggal_transaksi);
            $bulan = $bulan[1];
            $hpp = 0;
            $untung = 0;
            if ($row->status == "hutang") {
                foreach ($row->detail_transaksi as $detail_transaksi) {
                    $ppn_pph = 11.5;
                    $keuntungan_persentase = $detail_transaksi->barang->persentase_pph_ppn_keuntungan - $ppn_pph;
                    $untung += (($detail_transaksi->harga / 100) * $keuntungan_persentase) * $detail_transaksi->jumlah_beli;
                }
                $untung -= $row->piutang->sisa_hutang;
            } else {
                foreach ($row->detail_transaksi as $detail_transaksi) {
                    $ppn_pph = 11.5;
                    $keuntungan_persentase = $detail_transaksi->barang->persentase_pph_ppn_keuntungan - $ppn_pph;
                    $untung += (($detail_transaksi->harga / 100) * $keuntungan_persentase) * $detail_transaksi->jumlah_beli;
                }
            }
            $hitung = $untung;

            $laba[$bulan - 1] += $hitung;
        }
        for ($i = 0; $i < 12; $i++) {
            if ($laba[$i] < 0) {
                $lb[$i] = 0;
                $rg[$i] = abs($laba[$i]);
            } else {
                $rg[$i] = 0;
                $lb[$i] = abs($laba[$i]);
            }
        }
        return response()->json([
            'bulan' => $bulanRow,
            'laba' => $lb,
            'rugi' => $rg
        ]);
    }
}
