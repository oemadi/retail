<?php

namespace App\Http\Controllers;

use App\Barang;
use App\Detail_penjualan;
use App\Detail_return_jual;
use App\HutangCustomer;
use App\Penjualan;
use App\Return_penjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Kas as KasHelper;
use Saldo;
use Session;

class ReturnPenjualanController extends Controller
{
    public function index()
    {
        return view("pages.transaksi.return.penjualan.index");
    }
    public function getDataReturnPenjualan(Request $request){
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

        $totalRecords = Return_penjualan::select('count(*)  as allcount')->count();
        $totalRecordswithFilter =  Return_penjualan::select('count(*)  as allcount')->count();

        $records = Return_penjualan::orderBy($columnName,$columnSortOrder)
        ->join('penjualan','penjualan.id','return_penjualan.penjualan_id')
        ->join('customer','customer.id','penjualan.customer_id')
        ->where('return_penjualan.faktur','like','%'.$searchValue.'%')
        ->select('return_penjualan.*','penjualan.faktur as faktur_penjualan','customer.nama as customer')
        ->skip($start)
        ->take($rowperpage)
        ->get();

        $data_arr = array();
        foreach($records as $record){
            $data_arr[]=array('id'=>$record->id,'faktur'=>$record->faktur,
            'faktur_penjualan'=>$record->faktur_penjualan,'tanggal_return_jual'=>$record->tanggal_return_jual,
            'customer'=>$record->customer,'total_bayar'=>$record->total_bayar,'status'=>$record->status);
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
        $faktur = Return_penjualan::kodeFaktur();
        $penjualan = penjualan::with('customer')->whereDoesntHave('return_penjualan')->get();
        return view("pages.transaksi.return.penjualan.create", compact('penjualan', 'faktur'));
    }
    public function loadBarang($id)
    {
        $penjualan = Penjualan::with('detail_penjualan.barang')->find($id);

        $html = '';
        foreach ($penjualan->detail_penjualan as $key => $row) {
            $html .= '<tr>';
            $html .= '<td>' . $row->barang->nama . '</td>';
            $html .= '<td>' . $row->barang->harga_jual . '</td>';
            $html .= '<td>' . $row->jumlah_jual . '</td>';
            $html .= '<td>' . $row->subtotal . '</td>';
            $html .= '<td><button class="btn btn-sm btn-warning btn-pilih-barang" data-id="' . $row->id . '" data-kbarang="' . $row->barang->id . '" data-nbarang="' . $row->barang->nama . '" data-qty="' . $row->jumlah_jual . '" data-harga="' . $row->barang->harga_jual . '"><i class="fa fa-check-square-o"></i></button></td>';
            $html .= '</td>';
        }
      //  dd($html);
        return response()->json([$penjualan, $html]);
    }

    public function store(Request $request)
    {

        try {
            DB::beginTransaction();
            $penjualan = Penjualan::where('faktur', $request->faktur_penjualan)->first();
            $new = [];
            $total = 0;
            foreach ($request->data as $key => $row) {
                if ($request->faktur_penjualan == $row['faktur_penjualan']) {
                    $new[$key]['kode_barang'] = $row['kode_barang'];
                    $new[$key]['jumlah_dikembalikan'] = $row['jumlah_dikembalikan'];
                    $total += $row['subtotal'];
                }
            }
            //dd($request->faktur_penjualan);
            $return = new Return_penjualan();
            $return->faktur = $request->faktur;
            $return->penjualan_id = $penjualan->id;
            $return->tanggal_return_jual = date('Y-m-d');
            $return->total_bayar = $total;
            $return->branch = Session::get('branch');
            $return->save();

            foreach ($new as $row) {
                $detail = new Detail_return_jual();
                $detail->barang_id = $row['kode_barang'];
                $detail->return_jual_id = $return->id;
                $detail->jumlah_jual = $row['jumlah_dikembalikan'];
                $detail->save();
            }
            KasHelper::add($return->faktur, 'pengeluaran', 'return penjualan',0,$return->total_bayar,Session::get('branch'));
            self::updateDataAfterReturn($penjualan->id);
            DB::commit();
            return response()->json(['success', 'Return penjualan berhasil!']);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(['error', 'Return penjualan gagal!']);
        }
    }
    public static function updateDataAfterReturn($penjualan_id)
    {
        $penjualan = penjualan::with('detail_penjualan')->find($penjualan_id);
        $return = Return_penjualan::with('detail_return_jual.barang')->where('penjualan_id', $penjualan_id)->first();
        $kurangi = 0;
        if ($penjualan->status == "tunai") {
            foreach ($return->detail_return_jual as $key => $row) {
                $detail = Detail_penjualan::where('penjualan_id', $penjualan->id)->where('barang_id', $row->barang_id)->first();
                $detail->jumlah_jual += $row->jumlah_jual;
                $detail->subtotal += $row->jumlah_jual * $row->barang->harga_jual;
                $kurangi -= $row->jumlah_jual * $row->barang->harga_jual;
                $detail->save();
                $barang = Barang::find($row->barang_id);
                $barang->stok_akhir += $row->jumlah_jual;
                $barang->stok_masuk += $row->jumlah_jual;
                $barang->save();
            }
        } else {
            foreach ($return->detail_return_jual as $key => $row) {
                $detail = Detail_penjualan::where('penjualan_id', $penjualan->id)->where('barang_id', $row->barang_id)->first();
                $detail->jumlah_jual += $row->jumlah_jual;
                $detail->subtotal += $row->jumlah_jual * $row->barang->harga_jual;
                $kurangi -= $row->jumlah_jual * $row->barang->harga_jual;
                $detail->save();
                $barang = Barang::find($row->barang_id);
                $barang->stok_akhir += $row->jumlah_jual;
                $barang->stok_masuk += $row->jumlah_jual;
                $barang->save();
            }
            $hutang = HutangCustomer::where('penjualan_id', $penjualan->id)->first();
            $th = $hutang->total_hutang;
            $hutang->total_hutang += $kurangi;
            $hutang->sisa_hutang += $th - $hutang->pembayaran_hutang;
            if ($hutang->sisa_hutang <= 0) {
                $hutang->sisa_hutang = 0;
                $hutang->status = "lunas";
            }
            $hutang->save();
        }
        $penjualan->total += $kurangi;
        $penjualan->save();
    }
}
