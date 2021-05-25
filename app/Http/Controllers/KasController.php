<?php

namespace App\Http\Controllers;

use App\Kas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KasController extends Controller
{
    public function index()
    {
        $kas = Kas::all();
        $pendapatan = DB::table('kas')->sum('pemasukan');
        $pengeluaran = DB::table('kas')->sum('pengeluaran');
        return view("pages.laporan.kas.index", compact('kas', 'pendapatan', 'pengeluaran'));
    }
	public function getKas(Request $request){
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
			
			$totalRecords = Kas::select('count(*)  as allcount')
				->whereBetween('kas.tanggal', array($awal,$akhir))
				->count();
			$totalRecordswithFilter =  Kas::select('count(*)  as allcount')
			->where('faktur','like','%'.$searchValue.'%')
				->whereBetween('kas.tanggal', array($awal,$akhir))
			->count();
	
			$records = Kas::orderBy($columnName,$columnSortOrder)
			->where('kas.faktur','like','%'.$searchValue.'%')
			->whereBetween('kas.tanggal', array($awal,$akhir))
			->select('kas.*')
			->skip($start)
			->take($rowperpage)
			->get();
			
			$data_arr = array();
			foreach($records as $record){
		
				$id= $record->id;
				$tanggal = $record->tanggal;
				$faktur = $record->faktur;
				$tipe = $record->tipe;
				$jenis = $record->jenis;
				$pemasukan = $record->pemasukan;
				$pengeluaran = $record->pengeluaran;
				$keterangan = $record->keterangan;
				
				$data_arr[]=array('id'=>$id,'tanggal'=>$tanggal,'faktur'=>$faktur,'tipe'=>$tipe,
				'jenis'=>$jenis,'pemasukan'=>$pemasukan,'pengeluaran'=>$pengeluaran,'keterangan'=>$keterangan);
				
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
        $faktur = Kas::kodeFaktur();
        return view("pages.laporan.kas.create", compact('faktur'));
    }
    public function store(Request $request)
    {
        $kas = new Kas();
        $kas->tanggal = $request->tanggal;
        $kas->faktur = $request->faktur;
        $kas->tipe = $request->tipe;
        if ($request->tipe == "pendapatan") {
            $kas->pemasukan = $request->pemasukan;
            $kas->pengeluaran = 0;
            $kas->jenis = $request->jenis_pemasukan;
        } else {
            $kas->pengeluaran = $request->pengeluaran;
            $kas->pemasukan = 0;
            $kas->jenis = $request->jenis_pengeluaran;
        }
        if ($request->keterangan) {
            $kas->keterangan = $request->keterangan;
        } else {
            $kas->keterangan = "Tambah Data Kas lewat user";
        }
        if ($kas->save()) {
            session()->flash('message', 'Data berhasil disimpan!');
            return redirect()->route('transaksi.kas.index')->with('status', 'success');
        } else {
            session()->flash('message', 'Data gagal disimpan!');
            return redirect()->route('transaksi.kas.index')->with('status', 'danger');
        }
    }
    public function loadTable()
    {
        if (request()->get('filter') == "all") {
            $kas = Kas::get();
        } else {
            $kas = Kas::whereDate('tanggal', ">=", request()->get('tanggal_awal'))->whereDate('tanggal', "<=", request()->get('tanggal_akhir'))->get();
        }
        return view("pages.laporan.kas.table", compact('kas'));
    }
    public function loadKotak()
    {
        if (request()->get('filter') == "all") {
            $pendapatan = DB::table('kas')->sum('pemasukan');
            $pengeluaran = DB::table('kas')->sum('pengeluaran');
        } else {
            $pendapatan = DB::table('kas')->whereDate('tanggal', ">=", request()->get('tanggal_awal'))->whereDate('tanggal', "<=", request()->get('tanggal_akhir'))->sum('pemasukan');
            $pengeluaran = DB::table('kas')->whereDate('tanggal', ">=", request()->get('tanggal_awal'))->whereDate('tanggal', "<=", request()->get('tanggal_akhir'))->sum('pengeluaran');
        }
        return view("pages.laporan.kas.kotak_total", compact('pendapatan', 'pengeluaran'));
    }
}
