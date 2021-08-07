<?php

namespace App\Http\Controllers;
use App\Barang;
use App\PenyesuaianStok;
use App\DetailPenyesuaianStok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;

class PenyesuaianStokController extends Controller
{
    public function index()
    {
        return view("pages.transaksi.penyesuaian_stok.index");
    }
	public function getDataPenyesuaianStok(Request $request){
			$draw = $request->get('draw');
			$start = $request->get('start');
			$rowperpage = $request->get('length');
			$awal = $request->post('awal');
			$akhir = $request->post('akhir');

			$columnIndex_arr = $request->get('order');
			$columnName_arr = $request->get('columns');
			$order_arr = $request->get('order');
			$search_arr = $request->get('search');

			$columnIndex = $columnIndex_arr[0]['column'];
			$columnName = $columnName_arr[$columnIndex]['data'];
			$columnSortOrder = $order_arr[0]['dir'];
			$searchValue =$search_arr['value'];
            $branch = Session::get('branch');

			$totalRecords = PenyesuaianStok::select('count(*)  as allcount')
			->where('branch',$branch)->whereBetween('penyesuaian_stok.tanggal', array($awal,$akhir))->count();

			$totalRecordswithFilter =  PenyesuaianStok::select('count(*)  as allcount')
			->where('branch',$branch)->where('faktur','like','%'.$searchValue.'%')
			->whereBetween('penyesuaian_stok.tanggal', array($awal,$akhir))
			->count();

			$records = PenyesuaianStok::join('users','penyesuaian_stok.user_is','users.id')
            ->orderBy($columnName,$columnSortOrder)
			->where('penyesuaian_stok.branch',$branch)->where('penyesuaian_stok.faktur','like','%'.$searchValue.'%')
			->select('penyesuaian_stok.*','users.nama')
			->skip($start)
			->take($rowperpage)
			->get();
//dd($records);
			$data_arr = array();
			foreach($records as $record){

				$id= $record->id;
				$tanggal = $record->tanggal;
				$faktur = $record->faktur;
				$user = $record->nama;

				$data_arr[]=array('id'=>$id,'tanggal'=>$tanggal,'faktur'=>$faktur,'user'=>$user);

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
        $faktur = PenyesuaianStok::kodeFaktur();
        return view("pages.transaksi.penyesuaian_stok.create", compact('faktur'));
    }
    public function store(Request $request)
    {
            try {
            DB::beginTransaction();
            $PenyesuaianStok = new PenyesuaianStok();
            $branch = Session::get('branch');
            $PenyesuaianStok->branch=$branch;
            $PenyesuaianStok->tanggal = $request->tanggal;
            $PenyesuaianStok->faktur = $request->faktur;
            $PenyesuaianStok->user_is = $request->user;
            $PenyesuaianStok->save();
            foreach ($request->data as $row) {
                //dd($PenyesuaianStok->id);
                $detail = new DetailPenyesuaianStok();
                $detail->penyesuaianStok_id = $PenyesuaianStok->id;
                $detail->barang_id = $row['kode_barang'];
                $detail->jumlah = $row['jumlah'];
                $detail->keterangan = $row['keterangan'];
                $detail->jenis = $row['jenis'];
                $detail->save();
              // self::insertDataToHistory($row['kode_barang'], $request->customer_id, $row['jumlah']);
                self::updateStokbarang($row['jenis'],$row['kode_barang'], $row['jumlah']);
            }

            // if ($request->status != "tunai") {

            //     $hutang = new HutangCustomer();
            //     $hutang->faktur = HutangCustomer::kodeFaktur();
            //     $kodefaktur = $hutang->faktur;
            //     $hutang->penjualan_id = $penjualan->id;
            //     $hutang->customer_id = $request->customer_id;
            //     $hutang->total_hutang = $total;
            //     $hutang->total_pembayaran_hutang = 0;
            //     $hutang->sisa_hutang = $total;
            //     $hutang->branch = Session::get('branch');;
            //     $hutang->save();

            // } else {
            //     KasHelper::add($penjualan->faktur, 'pendapatan', 'penjualan', $penjualan->total,0);
            // }
            DB::commit();
            return response()->json(["success", "penyesuaian berhasil"]);

         //   $response = Penjualan::with('customer', 'detail_penjualan.barang')->find($penjualan->id);
           // dd($response);
          ///  return response()->json(["berhasil", $response]);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(["error", "penyesuaian gagal"]);
        }

    }
    public function show($id)
    {
        $PenyesuaianStok = PenyesuaianStok::findOrFail($id);
        return view("pages.transakasi.penyesuaianStok.edit", compact('PenyesuaianStok'));
    }
    public function viewData($id)
    {

       // dd($id);
           $atas = penyesuaianStok::findOrFail($id);
           $data = DetailPenyesuaianStok::with('Barang')->where('penyesuaianStok_id',$id)->get();

        return view("pages.transaksi.penyesuaian_stok.viewData", compact('atas','data'));
    }
    public static function updateStokbarang($jenis,$barang_id, $qty)
    {
        if($jenis=="penambahan"){
        $barang = Barang::find($barang_id);
        $barang->stok_penyesuaian_penambahan += $qty;
        $barang->stok_akhir += $qty;
        $barang->update();
        }else{
        $barang = Barang::find($barang_id);
        $barang->stok_penyesuaian_pengurangan += $qty;
        $barang->stok_akhir = $barang->stok_akhir-$qty;
        $barang->update();
        }
    }

}
