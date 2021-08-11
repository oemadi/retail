<?php

namespace App\Http\Controllers;

use App\Barang;
use App\Detail_pembelian;
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
	 protected $page = "pages.transaksi.pembelian.";
    public function index()
    {
        return view("pages.transaksi.pembelian.index");
    }
	public function faktur($kode)
    {
            $atas = Pembelian::where('pembelian.id',$kode)
            ->join('suplier','suplier.id','pembelian.suplier_id')
            ->select('pembelian.*','suplier.nama as namasuplier','suplier.alamat')
			->first();
// dd($atas->faktur);
			$detail = Pembelian::where('pembelian.id',$kode)
            ->join('detail_pembelian','pembelian.id','detail_pembelian.pembelian_id')
            ->join('barang','barang.id','detail_pembelian.barang_id')
            ->select('barang.*','detail_pembelian.jumlah_beli','detail_pembelian.karung','detail_pembelian.harga','detail_pembelian.subtotal')
			->get();
        return view($this->page . "faktur", compact('atas','detail'));
    }

	public function getDataPembelian(Request $request){
			$draw = $request->get('draw');
			$start = $request->get('start');
			$rowperpage = $request->get('length');
            $id_suplier = $request->get('id_suplier');
            $id_status = $request->get('id_status');

			$columnIndex_arr = $request->get('order');
			$columnName_arr = $request->get('columns');
			$order_arr = $request->get('order');
			$search_arr = $request->get('search');

			$columnIndex = $columnIndex_arr[0]['column'];
			$columnName = $columnName_arr[$columnIndex]['data'];
			$columnSortOrder = $order_arr[0]['dir'];
			$searchValue =$search_arr['value'];
            $branch = Session::get('branch');

			$totalRecords = Pembelian::select('count(*)  as allcount')->where('branch',$branch)->count();
            $totalRecordswithFilterA = DB::select("SELECT count(*) as allcount from pembelian a where a.branch=$branch
            ".($id_suplier!="" ?  "and a.suplier_id='".$id_suplier."'"  : "")."
            ".($id_status!="all" ?  "and a.status='".$id_status."'"  : "")."");
            $totalRecordswithFilter =  $totalRecordswithFilterA[0]->allcount;


            $records = DB::select("SELECT a.*,b.nama as suplier from pembelian a
            inner join suplier b on b.id=a.suplier_id where  a.branch=$branch
            ".($id_suplier!="" ?  "and a.suplier_id='".$id_suplier."'"  : "")."
            ".($id_status!="all" ?  "and a.status='".$id_status."'"  : "")."
             order by $columnName $columnSortOrder
             limit $start,$rowperpage");


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
            $branch = Session::get('branch');
            $id = request()->post('faktur_pembelian');
            $res = DB::select("SELECT a.*,b.sisa_hutang from pembelian a
            left join bayar_hutang_suplier b on a.id=b.id_pembelian
            where a.status!='lunas' and a.branch=$branch and a.id='".$id."' order by b.id");
           // dd($res);
            return $res;
        }
     public function getDataFakturPembelianSelect()
        {
            $branch = Session::get('branch');
            $id = request()->get('search');
            $id_suplier = request()->get('id_suplier');
            $res = DB::select("SELECT a.* from pembelian a
            where a.suplier_id='".$id_suplier."' and a.branch=$branch  and a.status='hutang'
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
            $pembelian->branch = Session::get('branch');
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
            $pembelian->save();
          foreach ($request->data as $row) {
                $detail = new Detail_pembelian();
                $detail->pembelian_id = $pembelian->id;
                $detail->barang_id = $row['kode_barang'];
                $detail->jumlah_beli = $row['jumlah'];
                $detail->harga = $row['harga'];
                $detail->karung = $row['karung'];
                $detail->subtotal = $row['subtotal'];
                $detail->save();
             //  self::insertDataToHistory($row['kode_barang'], $request->suplier_id, $row['jumlah']);
                self::updateStokbarang($row['kode_barang'], $row['jumlah']);
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
                $hutang->status = 'belum lunas';
                $hutang->branch = Session::get('branch');
                $hutang->save();
            } else {
                KasHelper::add($request->faktur, 'pengeluaran', 'pembelian', 0, $pembelian->total,Session::get('branch'));
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
