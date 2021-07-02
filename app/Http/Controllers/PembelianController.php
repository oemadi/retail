<?php

namespace App\Http\Controllers;

use App\Barang;
use App\Detail_Pembelian;
use App\History_stok_barang_masuk;
use App\HutangSuplier;
use App\Pembelian;
use App\Suplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Kas as KasHelper;
use Saldo;
use Session;

class PembelianController extends Controller
{
    public function index()
    {
       // $pembelian = Pembelian::with('suplier')->get();
        //$total = Saldo::getTotalPembelian();
        return view("pages.transaksi.pembelian.index");
    }

	public function getDataPembelian(Request $request){
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

			$totalRecords = Pembelian::select('count(*)  as allcount')->count();
			$totalRecordswithFilter =  Pembelian::select('count(*)  as allcount')
			->count();

			$records = Pembelian::orderBy($columnName,$columnSortOrder)
            ->join('suplier','suplier.id','pembelian.suplier_id')
			->where('pembelian.faktur','like','%'.$searchValue.'%')
			->select('pembelian.*','suplier.nama as suplier')
			->skip($start)
			->take($rowperpage)
			->get();

			$data_arr = array();
			foreach($records as $record){
                $data_arr[]=array('id'=>$record->id,'faktur'=>$record->faktur,
                'tanggal_pembelian'=>$record->tanggal_pembelian,'suplier'=>$record->suplier,
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
        public function getDataFakturPembelian()
        {
            //$id_ship = Session::get('id_ship');
            // HutangCustomer::where('faktur')

            $id = request()->post('faktur_pembelian');
            $res = DB::select("SELECT a.*,b.sisa_hutang from pembelian a
            left join bayar_hutang_suplier b on a.id=b.id_pembelian
            where a.status!='lunas' and a.id='".$id."' order by b.id");
           // dd($res);
            return $res;
        }
     public function getDataFakturPembelianSelect()
        {
            //$id_ship = Session::get('id_ship');
            $id = request()->get('search');
            $id_suplier = request()->get('id_suplier');
            $res = DB::select("SELECT a.* from pembelian a
            where a.suplier_id='".$id_suplier."' and a.status='hutang'
            and a.faktur like '%".$id."%'
             order by a.tanggal_pembelian
            ");
           foreach($res as $row){
               $data[] = array('id'=>$row->id,'text'=>$row->faktur.'-'.$row->tanggal_pembelian);
           }
            return json_encode($data);
        }
    public function create()
    {
        $kodeFaktur = Pembelian::kodeFaktur();
        return view("pages.transaksi.pembelian.create", compact('kodeFaktur'));
    }
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $pembelian = new Pembelian();
            $pembelian->faktur = $request->faktur;
            $pembelian->suplier_id = $request->suplier_id;
            $pembelian->tanggal_pembelian = date('Y-m-d');
            //dd($pembelian);
            $total = 0;
            foreach ($request->data as $row) {
                $total += $row['subtotal'];
            }
            $pembelian->total = $total;
            $pembelian->status = $request->status;
            $pembelian->branch = Session::get('branch');
            $pembelian->save();
            foreach ($request->data as $row) {
                $detail = new Detail_Pembelian();
                $detail->pembelian_id = $pembelian->id;
                $detail->barang_id = $row['kode_barang'];
                $detail->jumlah_beli = $row['jumlah'];
                $detail->subtotal = $row['subtotal'];
                $detail->save();
             //  self::insertDataToHistory($row['kode_barang'], $request->suplier_id, $row['jumlah']);
              // self::updateStokbarang($row['kode_barang'], $row['jumlah']);
            }
            if ($request->status != "tunai") {
                $kodefaktur  = HutangSuplier::kodeFaktur();
                $hutang = new HutangSuplier();
                $hutang->faktur =   $kodefaktur;
                $hutang->pembelian_id = $pembelian->id;
                $hutang->suplier_id = $request->suplier_id;
                $hutang->total_hutang = $total;
                $hutang->total_pembayaran_hutang = 0;
                $hutang->sisa_hutang = $total;
                $hutang->branch = Session::get('branch');
                $hutang->save();
            } else {
                KasHelper::add($pembelian->faktur, 'pengeluaran', 'pembelian', 0, $pembelian->total);
            }
            DB::commit();
            return response()->json(["success", "Pembelian berhasil"]);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(["error", "Pembelian gagal"]);
        }
    }

    public static function updateStokbarang($barang_id, $qty)
    {
        $barang = Barang::find($barang_id);
        $barang->stok_masuk += $qty;
        $barang->stok_akhir += $qty;
        $barang->update();
    }
    public static function insertDataToHistory($barang_id, $suplier_id, $qty)
    {
        $history = new History_stok_barang_masuk();
        $history->barang_id = $barang_id;
        $history->qty = $qty;
        $history->suplier_id = $suplier_id;
        $history->keterangan = "Stok masuk dari suplier";
        $history->save();
    }
}
