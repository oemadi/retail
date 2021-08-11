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
use Session;

class PenjualanController extends Controller
{
    protected $page = "pages.transaksi.penjualan.";
    public function index()
    {
        return view("pages.transaksi.penjualan.index");
    }
    public function faktur($kode)
    {
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
        return view($this->page . "faktur", compact('atas','detail'));
    }
	public function getDataPenjualan(Request $request){
			$draw = $request->get('draw');
			$start = $request->get('start');
			$rowperpage = $request->get('length');

            $id_customer = $request->get('id_customer');
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

			$totalRecords = Penjualan::select('count(*)  as allcount')->where('branch',$branch)->count();

            $totalRecordswithFilterA = DB::select("SELECT count(*) as allcount from penjualan a where a.branch=$branch
            ".($id_customer!="" ?  "and a.customer_id='".$id_customer."'"  : "")."
            ".($id_status!="all" ?  "and a.status='".$id_status."'"  : "")."");
            $totalRecordswithFilter =  $totalRecordswithFilterA[0]->allcount;


            $records = DB::select("SELECT a.*,b.nama as customer from penjualan a
            inner join customer b on b.id=a.customer_id where a.branch=$branch
            ".($id_customer!="" ?  "and a.customer_id='".$id_customer."'"  : "")."
            ".($id_status!="all" ?  "and a.status='".$id_status."'"  : "")."
             order by $columnName $columnSortOrder
             limit $start,$rowperpage");

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
        public function getDataCustomerSelect()
        {
            $branch = Session::get('branch');
            $id = request()->get('search');
            $res = DB::select("SELECT a.* from customer a
            where a.branch=$branch and a.nama like '%".$id."%'
             order by a.nama
            ");
           foreach($res as $row){
               $data[] = array('id'=>$row->id,'text'=>$row->nama.'-'.$row->alamat);
           }
            return json_encode($data);
        }
        public function getDataSuplierSelect()
        {
            // $branch = Session::get('branch');
            $id = request()->get('search');
            $res = DB::select("SELECT a.* from suplier a
            where  a.nama like '%".$id."%'
             order by a.nama
            ");
           foreach($res as $row){
               $data[] = array('id'=>$row->id,'text'=>$row->nama.'-'.$row->alamat);
           }
            return json_encode($data);
        }
        public function getDataKategoriSelect()
        {
            // $branch = Session::get('branch');
            $id = request()->get('search');
            $res = DB::select("SELECT a.* from kategori a
            where  a.nama like '%".$id."%'
             order by a.nama
            ");
           foreach($res as $row){
               $data[] = array('id'=>$row->id,'text'=>$row->nama);
           }
            return json_encode($data);
        }

       public function getDataCabangSelect()
        {
            // $branch = Session::get('branch');
            $id = request()->get('search');
            $res = DB::select("SELECT a.* from cabang a
            where  a.nama like '%".$id."%'
             order by a.nama
            ");
           foreach($res as $row){
               $data[] = array('id'=>$row->id,'text'=>$row->nama.'-'.$row->alamat);
           }
            return json_encode($data);
        }
        public function getDataBarang()
        {
            $branch = Session::get('branch');
            $id = request()->get('search');
            $res = DB::select("SELECT a.* from barang a where a.branch=$branch
             order by a.nama
            ");
           foreach($res as $row){
               $data[] = array('id'=>$row->id,'text'=>$row->kode.' - '.$row->nama);
           }
            return json_encode($data);
        }
        public function getDataBarangSelect2()
        {
            $branch = Session::get('branch');
            $id = request()->post('id_barang');
            $res = DB::select("SELECT a.* from barang a where  a.branch=$branch and a.id='".$id."'");
           // dd($res);
            return $res;
        }


        public function getDataFakturPenjualan()
        {
            $branch = Session::get('branch');
            $id = request()->post('faktur_penjualan');
            $res = DB::select("SELECT a.*,b.sisa_hutang from penjualan a
            left join bayar_hutang_customer b on a.id=b.id_penjualan
            where  a.branch=$branch and a.status!='lunas' and a.id='".$id."' order by b.id");
           // dd($res);
            return $res;
        }

        public function getDataFakturPenjualanSelect()
        {
            $branch = Session::get('branch');
            $id = request()->get('search');
            $id_customer = request()->get('id_customer');
            $res = DB::select("SELECT a.* from penjualan a
            where a.branch=$branch and a.customer_id='".$id_customer."' and a.status='hutang'
            and a.faktur like '%".$id."%'
             order by a.tanggal_penjualan
            ");
           foreach($res as $row){
               $data[] = array('id'=>$row->id,'text'=>$row->faktur.'-'.$row->tanggal_penjualan);
           }
            return json_encode($data);
        }


    public function create()
    {
        return view("pages.transaksi.penjualan.create");
    }
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $penjualan = new penjualan();
            $penjualan->branch = Session::get('branch');;
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
                $detail->karung = $row['karung'];
                $detail->subtotal = $row['subtotal'];
                $detail->save();
              // self::insertDataToHistory($row['kode_barang'], $request->customer_id, $row['jumlah']);
               self::updateStokbarang($row['kode_barang'], $row['jumlah']);
            }

            if ($request->status != "tunai") {

                $hutang = new HutangCustomer();
                $hutang->faktur = HutangCustomer::kodeFaktur();
                $kodefaktur = $hutang->faktur;
                $hutang->penjualan_id = $penjualan->id;
                $hutang->customer_id = $request->customer_id;
                $hutang->total_hutang = $total;
                $hutang->total_pembayaran_hutang = 0;
                $hutang->sisa_hutang = $total;
                $hutang->branch = Session::get('branch');;
                $hutang->save();

            } else {
                KasHelper::add($penjualan->faktur, 'pendapatan', 'penjualan', $penjualan->total,0,Session::get('branch'));
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
        $barang->stok_keluar += $qty;
        $barang->stok_akhir -= $qty;
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
