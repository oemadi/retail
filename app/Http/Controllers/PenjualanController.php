<?php

namespace App\Http\Controllers;

use App\Barang;
use App\Detail_penjualan;
use App\History_stok_barang_masuk;
use App\HutangCustomer;
use App\Penjualan;
use App\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Kas as KasHelper;
use Saldo;

class PenjualanController extends Controller
{
    public function index()
    {
        return view("pages.transaksi.penjualan.index");
    }
	public function getDataPenjualan(Request $request){
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

			$totalRecords = Penjualan::select('count(*)  as allcount')->count();
			$totalRecordswithFilter =  Penjualan::select('count(*)  as allcount')
			->count();

			$records = Penjualan::orderBy($columnName,$columnSortOrder)
            ->join('customer','customer.id','penjualan.customer_id')
			->where('penjualan.faktur','like','%'.$searchValue.'%')
			->select('penjualan.*','customer.nama as customer')
			->skip($start)
			->take($rowperpage)
			->get();

			$data_arr = array();
			foreach($records as $record){
                $data_arr[]=array('id'=>$record->id,'faktur'=>$record->faktur,
                'tanggal_penjualan'=>$record->tanggal_penjualan,'customer'=>$record->customer,
                'total'=>$record->total,'status'=>$record->status);
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
        public function getKodeFakturJual()
        {
            $data =  penjualan::kodeFaktur();
            return json_encode($data);
        }
        public function getDataCustomer()
        {
            //$id_ship = Session::get('id_ship');
            $id = request()->get('search');
            $res = DB::select("SELECT a.* from customer a
            ".($id!="" ?  "where a.nama like '%".$id."%'"  : "")."
             order by a.nama limit 10
            ");
           foreach($res as $row){
               $data[] = array('id'=>$row->id,'text'=>$row->nama.'-'.$row->alamat);
           }
            return json_encode($data);
        }
    public function loadTable()
    {
        $penjualan = penjualan::with('Customer');
        if (request()->get('tanggal_awal') != "all") {
            $penjualan = $penjualan->whereDate('tanggal_penjualan', ">=", request()->get('tanggal_awal'));
        }
        if (request()->get('tanggal_akhir') != "all") {
            $penjualan = $penjualan->whereDate('tanggal_penjualan', "<=", request()->get('tanggal_akhir'));
        }
        if (request()->get('penjualan') != "all") {
            $penjualan = $penjualan->where('status', request()->get('penjualan'));
        }
        $penjualan = $penjualan->get();
        return view("pages.transaksi.penjualan.table", compact('Customer', 'penjualan'));
    }
    public function loadKotakAtas()
    {
        $total = Saldo::getTotalpenjualan();
        return view("pages.transaksi.penjualan.kotak_atas", compact('total'));
    }
    public function create()
    {

        $customer = Customer::get();
        $barang = Barang::get();
        return view("pages.transaksi.penjualan.create", compact('barang', 'customer'));
    }
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $penjualan = new penjualan();
            $penjualan->faktur = $request->faktur;
            $penjualan->customer_id = $request->customer_id;
            $penjualan->tanggal_penjualan = date('Y-m-d');
            //dd($penjualan);
            $total = 0;
            foreach ($request->data as $row) {
                $total += $row['subtotal'];
            }
            $penjualan->total = $total;
            $penjualan->status = $request->status;
            $penjualan->save();
            foreach ($request->data as $row) {
                $detail = new Detail_penjualan();
                $detail->penjualan_id = $penjualan->id;
                $detail->barang_id = $row['kode_barang'];
                $detail->harga = $row['harga'];
                $detail->jumlah_jual = $row['jumlah'];
                $detail->subtotal = $row['subtotal'];
                $detail->save();
              // self::insertDataToHistory($row['kode_barang'], $request->customer_id, $row['jumlah']);
               self::updateStokbarang($row['kode_barang'], $row['jumlah']);
            }
            if ($request->status != "tunai") {
                $hutang = new HutangCustomer();
                $hutang->faktur = HutangCustomer::kodeFaktur();
                $hutang->tanggal_hutang = date('Y-m-d');
                $hutang->tanggal_tempo = $request->tempo;
                $hutang->customer_id = $request->customer_id;
                $hutang->penjualan_id = $penjualan->id;
                $hutang->total_hutang = $total;
                $hutang->pembayaran_hutang = 0;
                $hutang->sisa_hutang = $total;
                $hutang->save();
            } else {
                KasHelper::add($penjualan->faktur, 'pendapatan', 'penjualan', $penjualan->total,0);
            }
            DB::commit();
            //return response()->json(["success", "penjualan berhasil"]);

            $response = Penjualan::with('customer', 'detail_penjualan.barang')->find($penjualan->id);
           // dd($response);
            return response()->json(["berhasil", $response]);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(["error", "penjualan gagal"]);
        }
    }
    public function loadModal($id)
    {
        $penjualan = penjualan::with('Customer', 'detail_penjualan.barang')->find($id);
        return view("pages.transaksi.penjualan.modal", compact('penjualan'));
    }
    public static function updateStokbarang($barang_id, $qty)
    {
        $barang = Barang::find($barang_id);
        $barang->stok_masuk += $qty;
        $barang->stok_akhir += $qty;
        $barang->update();
    }
    public static function insertDataToHistory($barang_id, $Customer_id, $qty)
    {
        $history = new History_stok_barang_masuk();
        $history->barang_id = $barang_id;
        $history->qty = $qty;
        $history->Customer_id = $Customer_id;
        $history->keterangan = "Stok masuk dari Customer";
        $history->save();
    }
}
