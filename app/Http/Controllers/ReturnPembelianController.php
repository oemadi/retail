<?php

namespace App\Http\Controllers;

use App\Barang;
use App\Detail_pembelian;
use App\Detail_return_pembelian;
use App\HutangSuplier;
use App\Pembelian;
use App\Return_pembelian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Kas as KasHelper;
use Saldo;
use Session;

class ReturnPembelianController extends Controller
{
    public function index()
    {
        // $total = Saldo::getReturnPembelian();
        // $return = Return_pembelian::with('pembelian.suplier')->get();
        return view("pages.transaksi.return.pembelian.index");
    }
    public function getDataReturnPembelian(Request $request){
        $draw = $request->get('draw');
        $start = $request->get('start');
        $rowperpage = $request->get('length');

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column'];
        $columnName = $columnName_arr[$columnIndex]['data'];
        $columnSortOrder = $order_arr[0]['dir'];
        $searchValue =$search_arr['value'];

        $totalRecords = Return_pembelian::select('count(*)  as allcount')->count();
        $totalRecordswithFilter =  Return_pembelian::select('count(*)  as allcount')->count();

        $records = Return_pembelian::orderBy($columnName,$columnSortOrder)
        ->join('pembelian','pembelian.id','return_pembelian.pembelian_id')
        ->join('suplier','suplier.id','pembelian.suplier_id')
        ->where('return_pembelian.faktur','like','%'.$searchValue.'%')
        ->select('return_pembelian.*','pembelian.faktur as faktur_pembelian','suplier.nama as suplier')
        ->skip($start)
        ->take($rowperpage)
        ->get();

        $data_arr = array();
        foreach($records as $record){
            $data_arr[]=array('id'=>$record->id,'faktur'=>$record->faktur,'faktur_pembelian'=>$record->faktur_pembelian,
            'tanggal_return_pembelian'=>$record->tanggal_return_pembelian,'suplier'=>$record->suplier,
            'total_bayar'=>$record->total_bayar,'status'=>$record->status);
            $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
            );

        }
            echo json_encode($response);
            exit();
    }
    public function create()
    {
        $faktur = Return_pembelian::kodeFaktur();
        $pembelian = Pembelian::with('suplier')->whereDoesntHave('return_pembelian')->get();
        return view("pages.transaksi.return.pembelian.create", compact('pembelian', 'faktur'));
    }
    public function loadBarang($id)
    {
        $pembelian = Pembelian::with('detail_pembelian.barang')->find($id);
        $html = '';
        foreach ($pembelian->detail_pembelian as $key => $row) {
            $html .= '<tr>';
            $html .= '<td>' . $row->barang->nama . '</td>';
            $html .= '<td>' . $row->barang->harga_beli . '</td>';
            $html .= '<td>' . $row->jumlah_beli . '</td>';
            $html .= '<td>' . $row->subtotal . '</td>';
            $html .= '<td><button class="btn btn-sm btn-warning btn-pilih-barang" data-id="' . $row->id . '" data-kbarang="' . $row->barang->id . '" data-nbarang="' . $row->barang->nama . '" data-qty="' . $row->jumlah_beli . '" data-harga="' . $row->barang->harga_beli . '"><i class="fa fa-check-square-o"></i></button></td>';
            $html .= '</td>';
        }
        return response()->json([$pembelian, $html]);
    }
    public function store(Request $request)
    {

        try {
            DB::beginTransaction();
            $pembelian = Pembelian::where('faktur', $request->faktur_pembelian)->first();
            $new = [];
            $total = 0;
            foreach ($request->data as $key => $row) {
                if ($request->faktur_pembelian == $row['faktur_pembelian']) {
                    $new[$key]['kode_barang'] = $row['kode_barang'];
                    $new[$key]['jumlah_dikembalikan'] = $row['jumlah_dikembalikan'];
                    $total += $row['subtotal'];
                }
            }

            $return = new Return_pembelian();
            $return->faktur = $request->faktur;
            $return->pembelian_id = $pembelian->id;
            $return->tanggal_pembelian = $pembelian->tanggal_pembelian;
            $return->tanggal_return_pembelian = date('Y-m-d');
            $return->total_bayar = $total;
            $return->branch = Session::get('branch');
            $return->save();

            foreach ($new as $row) {
                $detail = new Detail_return_pembelian();
                $detail->barang_id = $row['kode_barang'];
                $detail->return_beli_id = $return->id;
                $detail->jumlah_beli = $row['jumlah_dikembalikan'];
                $detail->save();
            }
            KasHelper::add($return->faktur, 'pendapatan', 'return pembelian', $return->total_bayar, 0,Session::get('branch'));
            self::updateDataAfterReturn($pembelian->id);
            DB::commit();
            return response()->json(['success', 'Return pembelian berhasil!']);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(['error', 'Return pembelian gagal!']);
        }
    }
    public static function updateDataAfterReturn($pembelian_id)
    {
        $pembelian = Pembelian::with('detail_pembelian')->find($pembelian_id);
        $return = Return_pembelian::with('detail_return_pembelian.barang')->where('pembelian_id', $pembelian_id)->first();
        $kurangi = 0;
        if ($pembelian->status == "tunai") {
            foreach ($return->detail_return_pembelian as $key => $row) {
                $detail = Detail_pembelian::where('pembelian_id', $pembelian->id)->where('barang_id', $row->barang_id)->first();
                $detail->jumlah_beli -= $row->jumlah_beli;
                $detail->subtotal -= $row->jumlah_beli * $row->barang->harga_beli;
                $kurangi += $row->jumlah_beli * $row->barang->harga_beli;
                $detail->save();
                $barang = Barang::find($row->barang_id);
                $barang->stok_akhir -= $row->jumlah_beli;
                $barang->stok_masuk -= $row->jumlah_beli;
                $barang->save();
            }
        } else {
            foreach ($return->detail_return_pembelian as $key => $row) {
                $detail = Detail_pembelian::where('pembelian_id', $pembelian->id)->where('barang_id', $row->barang_id)->first();
                $detail->jumlah_beli -= $row->jumlah_beli;
                $detail->subtotal -= $row->jumlah_beli * $row->barang->harga_beli;
                $kurangi += $row->jumlah_beli * $row->barang->harga_beli;
                $detail->save();
                $barang = Barang::find($row->barang_id);
                $barang->stok_akhir -= $row->jumlah_beli;
                $barang->stok_masuk -= $row->jumlah_beli;
                $barang->save();
            }
            $hutang = HutangSuplier::where('pembelian_id', $pembelian->id)->first();
            $th = $hutang->total_hutang;
            $hutang->total_hutang -= $kurangi;
            $hutang->sisa_hutang -= $th - $hutang->pembayaran_hutang;
            if ($hutang->sisa_hutang <= 0) {
                $hutang->sisa_hutang = 0;
                $hutang->status = "lunas";
            }
            $hutang->save();
        }
        $pembelian->total -= $kurangi;
        $pembelian->save();
    }
}
