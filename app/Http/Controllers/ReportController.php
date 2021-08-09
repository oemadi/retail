<?php

namespace App\Http\Controllers;
use App\Cabang;
use App\Customer;
use App\Suplier;
use App\Barang;
use App\Gaji;
use App\Hutang;
use App\Kas;
use App\Pembelian;
use App\Penjualan;
use App\BayarHutangSuplier;
use App\BayarHutangCustomer;
use App\Piutang;
use App\Return_pembelian;
use App\Return_penjualan;
use App\Transaksi;
use App\PenyesuaianStok;
use App\DetailPenyesuaianStok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Saldo;
use PDF;
use Helper;


class ReportController extends Controller
{
    protected $page = "pages.report.";

	public function customer()
    {

        return view("pages.report.customer.index");
    }
    public function suplier()
    {

        return view("pages.report.suplier.index");
    }

    public function kas()
    {

        return view("pages.report.kas.index");
    }

    public function kasCabang()
    {
        return view("pages.report.kas_cabang.index");
    }

	   public function penyesuaianStokPrint()
    {
        $id = request()->get('id');
//		dd($id);
        $data =  PenyesuaianStok::find($id);

        $pdf = PDF::loadView('pages.transaksi.penyesuaian_stok.print', compact('data'))->setPaper('a4', 'portait');
        $pdf->getDomPDF()->setHttpContext(
        stream_context_create([
            'ssl' => [
                'allow_self_signed'=> TRUE,
                'verify_peer' => FALSE,
                'verify_peer_name' => FALSE,
            ]
        ])
    );
        return $pdf->stream();
    }
    public function kasPrint()
    {
          $tgl1 = tanggal_english((request()->get('tanggal_awal')));
          $tgl2 = tanggal_english((request()->get('tanggal_akhir')));
  //dd($tgl1,$tgl2);
          $kas = Kas::whereDate('tanggal', ">=", $tgl1)->whereDate('tanggal', "<=",$tgl2)->get();

        $pdf = PDF::loadView('pages.report.kas.print', compact('kas'))->setPaper('a4', 'portait');
        $pdf->getDomPDF()->setHttpContext(
        stream_context_create([
            'ssl' => [
                'allow_self_signed'=> TRUE,
                'verify_peer' => FALSE,
                'verify_peer_name' => FALSE,
            ]
        ])
    );
        return $pdf->stream();
    }
	    public function kasCabangPrint()
    {
        $tgl1 = tanggal_english((request()->get('tanggal_awal')));
        $tgl2 = tanggal_english((request()->get('tanggal_akhir')));
        $kas = Kas::where('branch',request()->get('cabang'))
        ->whereDate('tanggal', ">=", $tgl1)->whereDate('tanggal', "<=", $tgl2)->get();

        $pdf = PDF::loadView('pages.report.kas_cabang.print', compact('kas'))->setPaper('a4', 'portait');
        $pdf->getDomPDF()->setHttpContext(
        stream_context_create([
            'ssl' => [
                'allow_self_signed'=> TRUE,
                'verify_peer' => FALSE,
                'verify_peer_name' => FALSE,
            ]
        ])
    );
        return $pdf->stream();

    }


    public function saldo()
    {
        return view("pages.report.saldo.index");
    }

    public function saldoPrint()
    {
        $tgl1 = tanggal_english((request()->get('tanggal_awal')));
        $tgl2 =  tanggal_english((request()->get('tanggal_akhir')));

        $saldo = Penjualan::with('customer')
        ->whereDate('tanggal_penjualan', ">=", $tgl1)
        ->whereDate('tanggal_penjualan', "<=", $tgl2)
        ->get();

        $pdf = PDF::loadView('pages.report.saldo.print', compact('saldo','tgl1','tgl2'))->setPaper('a4', 'portait');
        $pdf->getDomPDF()->setHttpContext(
        stream_context_create([
            'ssl' => [
                'allow_self_signed'=> TRUE,
                'verify_peer' => FALSE,
                'verify_peer_name' => FALSE,
            ]
        ])
    );
        return $pdf->stream();
    }
    public function barang()
    {
        return view("pages.report.barang.index");
    }
    public function pembelian()
    {
        return view("pages.report.pembelian.index");
    }
	  public function pembelianCabang()
    {
        return view("pages.report.pembelian_cabang.index");
    }
    public function penjualan()
    {
        return view("pages.report.penjualan.index");
    }
	public function penjualanCabang()
    {
        return view("pages.report.penjualan_cabang.index");
    }
    public function bayarSuplier()
    {
          return view("pages.report.bayar_suplier.index");
    }
    public function bayarCustomer()
    {
        return view("pages.report.bayar_customer.index");
    }
	public function tagihanCustomer()
    {
        return view("pages.report.tagihan_customer.index");
    }
	public function tagihanCustomerCabang()
    {
        return view("pages.report.tagihan_customer_cabang.index");
    }
    //      $pembelian = BayarHutangSuplier::with('suplier')->get();
    // $pembelian = BayarHutangSuplier::with('suplier')->get();
    public function barangPrint()
    {
        $data =  Barang::get();

        $pdf = PDF::loadView('pages.report.barang.print', compact('data'))->setPaper('a4', 'portait');
        $pdf->getDomPDF()->setHttpContext(
        stream_context_create([
            'ssl' => [
                'allow_self_signed'=> TRUE,
                'verify_peer' => FALSE,
                'verify_peer_name' => FALSE,
            ]
        ])
    );
        return $pdf->stream();

    }
    public function bayarSuplierPrint()
    {
        $tgl1 = tanggal_english((request()->get('tanggal_awal')));
        $tgl2 =  tanggal_english((request()->get('tanggal_akhir')));
        $data =  BayarHutangSuplier::whereDate('tanggal_bayar', ">=", $tgl1)
        ->whereDate('tanggal_bayar', "<=", $tgl2)
        ->get();

        $pdf = PDF::loadView('pages.report.bayar_suplier.print2', compact('data','tgl1','tgl2'))->setPaper('a4', 'portait');
        $pdf->getDomPDF()->setHttpContext(
        stream_context_create([
            'ssl' => [
                'allow_self_signed'=> TRUE,
                'verify_peer' => FALSE,
                'verify_peer_name' => FALSE,
            ]
        ])
    );
        return $pdf->stream();

    }
    public function customerPrint()
    {
        $data = Customer::get();

        $pdf = PDF::loadView('pages.report.customer.print', compact('data'))->setPaper('a4', 'portait');
        $pdf->getDomPDF()->setHttpContext(
        stream_context_create([
            'ssl' => [
                'allow_self_signed'=> TRUE,
                'verify_peer' => FALSE,
                'verify_peer_name' => FALSE,
            ]
        ])
    );
        return $pdf->stream();

    }
	    public function suplierPrint()
    {
        $data = Suplier::get();

        $pdf = PDF::loadView('pages.report.suplier.print', compact('data'))->setPaper('a4', 'portait');
        $pdf->getDomPDF()->setHttpContext(
        stream_context_create([
            'ssl' => [
                'allow_self_signed'=> TRUE,
                'verify_peer' => FALSE,
                'verify_peer_name' => FALSE,
            ]
        ])
    );
        return $pdf->stream();

    }
    public function bayarCustomerPrint()
    {
        $tgl1 = tanggal_english((request()->get('tanggal_awal')));
        $tgl2 =  tanggal_english((request()->get('tanggal_akhir')));
        $data = BayarHutangCustomer::with('customer')
        ->whereDate('tanggal_bayar', ">=",$tgl1)
        ->whereDate('tanggal_bayar', "<=",$tgl2)
        ->get();
        $pdf = PDF::loadView('pages.report.bayar_customer.print2', compact('data','tgl1','tgl2'))->setPaper('a4', 'portait');
        $pdf->getDomPDF()->setHttpContext(
        stream_context_create([
            'ssl' => [
                'allow_self_signed'=> TRUE,
                'verify_peer' => FALSE,
                'verify_peer_name' => FALSE,
            ]
        ])
    );
        return $pdf->stream();

    }
	    public function tagihanCustomerCabangPrint()
    {
        if(request()->get('status_lunas')=="0"){
            $data = Penjualan::with('BayarHutangCustomer')
            ->where('branch',request()->get('id_cabang'))
            ->get();
        }else{
            $data = Penjualan::with('BayarHutangCustomer')
            ->where('branch',request()->get('id_cabang'))
            ->where('status',request()->get('status_lunas'))
            ->get();
        }
		$cabang = Cabang::where('id',request()->get('id_cabang'))->first();

        $pdf = PDF::loadView('pages.report.tagihan_customer_cabang.print2', compact('data','cabang'))->setPaper('a4', 'portait');
        $pdf->getDomPDF()->setHttpContext(
        stream_context_create([
            'ssl' => [
                'allow_self_signed'=> TRUE,
                'verify_peer' => FALSE,
                'verify_peer_name' => FALSE,
            ]
        ])
    );
        return $pdf->stream();
    }
	    public function tagihanCustomerPrint()
    {
        if(request()->get('status_lunas')=="0"){
        $data = Penjualan::with('BayarHutangCustomer')
        ->where('customer_id',request()->get('id_customer'))
        ->get();
        }else{
        $data = Penjualan::with('BayarHutangCustomer')
        ->where('customer_id',request()->get('id_customer'))
        ->where('status',request()->get('status_lunas'))
        ->get();
        }
		$cus = Customer::where('id',request()->get('id_customer'))->first();
        $pdf = PDF::loadView('pages.report.tagihan_customer.print2', compact('data','cus'))->setPaper('a4', 'portait');
        $pdf->getDomPDF()->setHttpContext(
        stream_context_create([
            'ssl' => [
                'allow_self_signed'=> TRUE,
                'verify_peer' => FALSE,
                'verify_peer_name' => FALSE,
            ]
        ])
    );
        return $pdf->stream();

    }




    public function penjualanPrint()
    {
        $tgl1 = tanggal_english((request()->get('tanggal_awal')));
        $tgl2 =  tanggal_english((request()->get('tanggal_akhir')));

        if(request()->get('status')=="0"){
            $penjualan = Penjualan::with('customer')
            ->whereDate('tanggal_penjualan', ">=", $tgl1)
            ->whereDate('tanggal_penjualan', "<=", $tgl2)
            ->get();
        }else{
            $penjualan = Penjualan::with('customer')
            ->whereDate('tanggal_penjualan', ">=", $tgl1)
            ->whereDate('tanggal_penjualan', "<=", $tgl2)
            ->where('status',request()->get('status'))
            ->get();
        }
        $pdf = PDF::loadView('pages.report.penjualan.print2', compact('penjualan','tgl1','tgl2'))->setPaper('a4', 'portait');
        $pdf->getDomPDF()->setHttpContext(
        stream_context_create([
            'ssl' => [
                'allow_self_signed'=> TRUE,
                'verify_peer' => FALSE,
                'verify_peer_name' => FALSE,
            ]
        ])
    );
        return $pdf->stream();
    }
    public function penjualanPrintStruk()
    {
            $kode = request()->get('id_penjualan');
           // dd($kode);
            $atas = Penjualan::where('penjualan.id',$kode)
            ->join('customer','customer.id','penjualan.customer_id')
            ->select('penjualan.*','customer.nama as namacustomer','customer.alamat')
			->first();
// dd($atas->faktur);
			$detail = Penjualan::where('penjualan.id',$kode)
            ->join('detail_penjualan','penjualan.id','detail_penjualan.penjualan_id')
            ->join('barang','barang.id','detail_penjualan.barang_id')
            ->select('barang.*','detail_penjualan.jumlah_jual','detail_penjualan.harga',
            'detail_penjualan.subtotal')
			->get();
        return view("pages.transaksi.penjualan.faktur", compact('atas','detail'));
    }
  public function penjualanCabangPrint()
    {
        $tgl1 = tanggal_english((request()->get('tanggal_awal')));
        $tgl2 =  tanggal_english((request()->get('tanggal_akhir')));
        if(request()->get('status')=="0"){
        $penjualan = Penjualan::with('customer')
		->where('branch',request()->get('cabang'))
        ->whereDate('tanggal_penjualan', ">=", $tgl1)
        ->whereDate('tanggal_penjualan', "<=", $tgl2)
        ->get();
        }else{
            $penjualan = Penjualan::with('customer')
            ->where('branch',request()->get('cabang'))
            ->whereDate('tanggal_penjualan', ">=", $tgl1)
            ->whereDate('tanggal_penjualan', "<=", $tgl2)
            ->where('status',request()->get('status'))
            ->get();

        }
		$cabang = Cabang::where('id',request()->get('cabang'))->first();
        $pdf = PDF::loadView('pages.report.penjualan_cabang.print2', compact('penjualan','tgl1','tgl2','cabang'))->setPaper('a4', 'portait');
        $pdf->getDomPDF()->setHttpContext(
        stream_context_create([
            'ssl' => [
                'allow_self_signed'=> TRUE,
                'verify_peer' => FALSE,
                'verify_peer_name' => FALSE,
            ]
        ])
    );
        return $pdf->stream();
    }
    public function pembelianPrint()
    {
        $tgl1 = tanggal_english((request()->get('tanggal_awal')));
        $tgl2 =  tanggal_english((request()->get('tanggal_akhir')));
        if(request()->get('status')=="0"){
            $pembelian = Pembelian::with('suplier')
            ->whereDate('tanggal_pembelian', ">=",$tgl1)
            ->whereDate('tanggal_pembelian', "<=",$tgl2)
            ->get();
        }else{
            $pembelian = Pembelian::with('suplier')
            ->whereDate('tanggal_pembelian', ">=",$tgl1)
            ->whereDate('tanggal_pembelian', "<=",$tgl2)
            ->where('status',request()->get('status'))
            ->get();
        }
        $pdf = PDF::loadView('pages.report.pembelian.print2', compact('pembelian','tgl1','tgl2'))->setPaper('a4', 'portait');
        $pdf->getDomPDF()->setHttpContext(
        stream_context_create([
            'ssl' => [
                'allow_self_signed'=> TRUE,
                'verify_peer' => FALSE,
                'verify_peer_name' => FALSE,
            ]
        ])
    );
        return $pdf->stream();
    }

    public function pembelianCabangPrint()
    {
        $tgl1 = tanggal_english((request()->get('tanggal_awal')));
        $tgl2 =  tanggal_english((request()->get('tanggal_akhir')));
        if(request()->get('status')=="0"){
        $pembelian = Pembelian::with('suplier')
		->where('branch',request()->get('cabang'))
        ->whereDate('tanggal_pembelian', ">=",$tgl1)
        ->whereDate('tanggal_pembelian', "<=", $tgl2)
        ->get();
        }else{
            $pembelian = Pembelian::with('suplier')
            ->where('branch',request()->get('cabang'))
            ->whereDate('tanggal_pembelian', ">=",$tgl1)
            ->whereDate('tanggal_pembelian', "<=", $tgl2)
            ->where('status',request()->get('status'))
            ->get();
        }
		$cabang = Cabang::where('id',request()->get('cabang'))->first();
        $pdf = PDF::loadView('pages.report.pembelian_cabang.print2', compact('pembelian','tgl1','tgl2','cabang'))->setPaper('a4', 'portait');
        $pdf->getDomPDF()->setHttpContext(
        stream_context_create([
            'ssl' => [
                'allow_self_signed'=> TRUE,
                'verify_peer' => FALSE,
                'verify_peer_name' => FALSE,
            ]
        ])
    );
        return $pdf->stream();
    }

    public function penggajian()
    {
        $years = Gaji::select(DB::raw('YEAR(tanggal_gaji) as year'))->distinct()->get();
        $penggajian = Gaji::with('pegawai')->get();
        return view("pages.report.penggajian.index", compact('penggajian', 'years'));
    }

    public function penggajianPrint()
    {

        $penggajian = Gaji::with('pegawai')
        ->whereMonth('tanggal_gaji', request()->get('bulan'))
        ->whereYear('tanggal_gaji', request()->get('tahun'))->get();

        $pdf = PDF::loadView('pages.report.penggajian.print', compact('penggajian'))->setPaper('a4', 'portait');
        $pdf->getDomPDF()->setHttpContext(
        stream_context_create([
            'ssl' => [
                'allow_self_signed'=> TRUE,
                'verify_peer' => FALSE,
                'verify_peer_name' => FALSE,
            ]
        ])
    );
        return $pdf->stream();
    }
}
