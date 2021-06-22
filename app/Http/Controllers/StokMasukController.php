<?php

namespace App\Http\Controllers;

use App\Barang;
use App\History_stok_barang_masuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StokMasukController extends Controller
{
    public function index()
    {
        $histories = History_stok_barang_masuk::with('suplier')->with('barang')->paginate(10);
        return view("pages.barang.stok_masuk.index", compact('histories'));
    }
   
	public function getStokMasuk(Request $request){
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
			
			$totalRecords = History_stok_barang_masuk::select('count(*)  as allcount')->count();
			$totalRecordswithFilter =  History_stok_barang_masuk::select('count(*)  as allcount')
			->where('barang_id','like','%'.$searchValue.'%')
			->count();
			
			$records =  History_stok_barang_masuk::select('history_stok_barang_masuk.*','suplier.nama as nama_suplier','barang.nama as nama_barang')
			->leftJoin('suplier', 'suplier.id', '=', 'history_stok_barang_masuk.suplier_id')
            ->join('barang', 'barang.id', '=', 'history_stok_barang_masuk.barang_id')
			->orderBy($columnName,$columnSortOrder)
			->where('history_stok_barang_masuk.barang_id','like','%'.$searchValue.'%')
			
			->skip($start)
			->take($rowperpage)
			->get();
			
			$data_arr = array();
			foreach($records as $record){
		
				$id= $record->id;
				$barang_id= $record->barang_id;
				$nama= $record->nama_barang;
				$suplier= $record->nama_suplier;
				$qty= $record->qty;
				$tgl= $record->created_at->format('Y-m-d');				
				$keterangan = $record->keterangan;
				$data_arr[]=array('id'=>$id,'barang_id'=>$barang_id,'qty'=>$qty,'nama'=>$nama,'suplier'=>$suplier,'tgl'=>$tgl,'keterangan'=>$keterangan);
				
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
        $barang = Barang::get();
        return view("pages.barang.stok_masuk.create", compact('barang'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'barcode' => 'required',
            'nama_barang' => 'required',
            'stok_saat_ini' => 'required',
            'keterangan' => 'required',
            'qty' => 'required|integer|min:0',
        ]);
        try {
            DB::beginTransaction();
            $history = new History_stok_barang_masuk();
            $history->barang_id = $request->barcode;
            $history->qty = $request->qty;
            $history->keterangan = $request->keterangan;
            $history->save();

            $barang = Barang::findOrFail($request->barcode);
            $barang->stok_masuk += (int) $request->qty;
            $barang->stok_akhir += (int) $request->qty;
            $barang->save();
            DB::commit();
            session()->flash('message', 'Stok Berhasil ditambah!');
            return redirect()->route('barang.masuk.index')->with('status', 'success');
        } catch (\Throwable $th) {
            DB::rollBack();
            session()->flash('message', 'Stok gagal ditambah!');
            return redirect()->route('barang.masuk.index')->with('status', 'danger');
        }
    }
}
