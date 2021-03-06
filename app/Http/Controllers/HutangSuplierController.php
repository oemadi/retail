<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\HutangSuplier;
use App\Pembelian;
use DB;
use Session;

class HutangSuplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view("pages.transaksi.hutang_suplier.index");
    }

		public function getHutangSuplier(Request $request){
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

			$totalRecords = HutangSuplier::select('count(*)  as allcount')->where('branch',$branch)->count();

            $totalRecordswithFilterA = DB::select("SELECT count(*) as allcount from hutang_suplier a
            where a.branch= $branch
            ".($id_suplier!="" ?  "and a.suplier_id='".$id_suplier."'"  : "")."
            ");
            $totalRecordswithFilter =  $totalRecordswithFilterA[0]->allcount;


            $records = DB::select("SELECT a.*,b.nama as suplier,c.faktur as faktur_pembelian
            from hutang_suplier a inner join suplier b on b.id=a.suplier_id
            inner join pembelian c on c.id=a.pembelian_id
            where a.branch= $branch
            ".($id_suplier!="" ?  "and a.suplier_id='".$id_suplier."'"  : "")."
            ".($id_status!="all" ?  "and c.status='".$id_status."'"  : "")."
             order by $columnName $columnSortOrder
             limit $start,$rowperpage");

			// $totalRecordswithFilter =  HutangSuplier::select('count(*)  as allcount')
			// ->count();

            // $records = HutangSuplier::orderBy($columnName,$columnSortOrder)
            // ->join('pembelian','pembelian.id','hutang_suplier.pembelian_id')
            // ->join('suplier','suplier.id','hutang_suplier.suplier_id')
			// ->select('hutang_suplier.*','suplier.nama as suplier','pembelian.faktur as faktur_pembelian')
			// ->skip($start)
			// ->take($rowperpage)
			// ->get();

			$data_arr = array();
			foreach($records as $record){

				$data_arr[]=array('id'=>$record->id,'pembelian_id'=>$record->pembelian_id,'suplier'=>$record->suplier,
                'faktur_pembelian'=>$record->faktur_pembelian,'suplier_id'=>$record->suplier_id,
                'total_hutang'=>$record->total_hutang,'total_pembayaran_hutang'=>$record->total_pembayaran_hutang,
                'sisa_hutang'=>$record->sisa_hutang);

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


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $faktur = HutangSuplier::kodeFaktur();
        return view("pages.transaksi.hutang_Suplier.create",compact('faktur'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            //'nama' => 'required|min:3'
        ]);
        $BayarSuplier = new HutangSuplier();
        $BayarSuplier->tanggal_bayar =  date('Y-m-d',strtotime($request->tanggal));
        $BayarSuplier->id_bayar_hutang_Suplier = $request->faktur;
        $BayarSuplier->id_Suplier = $request->id_Suplier;
        $BayarSuplier->id_penjualan = $request->id_penjualan;
        $BayarSuplier->jumlah_bayar = $request->jumlah_bayar;
        $BayarSuplier->sisa_hutang = $request->sisa_hutang;

        if ($BayarSuplier->save()) {
            session()->flash('message', 'Data berhasil disimpan!');
            return redirect()->route('bayarSuplier')->with('status', 'success');
        } else {
            session()->flash('message', 'Data gagal disimpan!');
            return redirect()->route('bayarSuplier')->with('status', 'danger');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $BayarSuplier = HutangSuplier::findOrFail($id);
        return view("pages.BayarSuplier.edit", compact('BayarSuplier'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|min:3'
        ]);
        $BayarSuplier = HutangSuplier::find($id);
        $BayarSuplier->nama = $request->nama;
        if ($BayarSuplier->save()) {
            session()->flash('message', 'Data berhasil diubah!');
            return redirect()->route('BayarSuplier.index')->with('status', 'success');
        } else {
            session()->flash('message', 'Data gagal diubah!');
            return redirect()->route('BayarSuplier.index')->with('status', 'danger');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $BayarSuplier = HutangSuplier::findOrFail($id);
        $relasi = HutangSuplier::with('barang')->find($id);
        if (count($relasi->barang) < 1) {
            if ($BayarSuplier->delete()) {
                session()->flash('message', 'Data berhasil dihapus!');
                return redirect()->route('bayarSuplier.index')->with('status', 'success');
            } else {
                session()->flash('message', 'Data gagal dihapus!');
                return redirect()->route('bayarSuplier.index')->with('status', 'danger');
            }
        } else {
            session()->flash('message', 'Data gagal dihapus!');
            return redirect()->route('bayarSuplier.index')->with('status', 'danger');
        }
    }
}
