<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BayarHutangSuplier;
use App\HutangSuplier;
use App\Pembelian;
use App\Suplier;
// use App\Pembelian;
use DB;
use Session;
use Kas as KasHelper;

class BayarSuplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view("pages.transaksi.bayar_Suplier.index");
    }
    public function getDataPegawaiSelect()
    {
        //$id_ship = Session::get('id_suplier');
        $id = request()->get('search');
        $res = DB::select("SELECT a.* from pegawai a
        where a.nama like '%".$id."%'
         order by a.nama limit 10
        ");
       foreach($res as $row){
           $data[] = array('id'=>$row->id,'text'=>$row->nama.'-'.$row->alamat);
       }
        return json_encode($data);
    }
    public function getDataHutangSuplier()
    {
        $id = request()->get('search');
        $res = DB::select("SELECT a.* from pegawai a
        where a.nama like '%".$id."%'
         order by a.nama limit 10
        ");
       foreach($res as $row){
           $data[] = array('id'=>$row->id,'text'=>$row->nama.'-'.$row->alamat);
       }
        return json_encode($data);
    }
    //getDataHutangSuplier
    public function getDataPegawaiSelect2()
    {
        //$id_ship = Session::get('id_ship');
        $id = request()->post('id_pegawai');
        $res = DB::select("SELECT a.* from pegawai a where a.id=$id");
       // dd($res);
        return $res;
    }
		public function getDataBayarSuplier(Request $request){
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

			$totalRecords = BayarHutangSuplier::select('count(*)  as allcount')->count();
			$totalRecordswithFilter =  BayarHutangSuplier::select('count(*)  as allcount')
			->count();
            $id_suplier = Session::get('id_suplier');
            $records = BayarHutangSuplier::orderBy($columnName,$columnSortOrder)
            ->join('suplier','suplier.id','bayar_hutang_Suplier.id_suplier')
            ->join('pembelian','pembelian.id','bayar_hutang_Suplier.id_pembelian')
			->select('bayar_hutang_Suplier.*','Suplier.nama as Suplier',
            'pembelian.faktur as faktur_pembelian')
            ->where('pembelian.Suplier_id', $id_suplier)
			->skip($start)
			->take($rowperpage)
			->get();
			$data_arr = array();
			foreach($records as $record){

				$data_arr[]=array('id'=>$record->id,'id_bayar_hutang_suplier'=>$record->id_bayar_hutang_suplier,
                'suplier'=>$record->suplier,'tanggal_bayar'=>$record->tanggal_bayar,
                'faktur_pembelian'=>$record->faktur_pembelian,'jumlah_bayar'=>$record->jumlah_bayar,
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
    public function show($id)
    {
       // dd($id);
       $res = Suplier::where('id',$id)->first();
      // dd($res->nama);
        Session::put(array('id_suplier'=>$id,'nama_suplier'=>$res->nama));
        $faktur = BayarHutangSuplier::kodeFaktur();
        return view("pages.transaksi.bayar_suplier.create",compact('faktur'));
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
        $BayarSuplier = new BayarHutangSuplier();
        $BayarSuplier->tanggal_bayar =  date('Y-m-d',strtotime($request->tanggal));
        $BayarSuplier->id_bayar_hutang_Suplier = $request->faktur;
        $BayarSuplier->id_suplier = $request->id_suplier;
        $BayarSuplier->id_pembelian = $request->id_pembelian;
        $BayarSuplier->jumlah_bayar = $request->jumlah_bayar;
        $BayarSuplier->sisa_hutang = $request->sisa_hutang;
        if($request->sisa_hutang<=0){
            $Updatepembelian = Pembelian::where('id',$request->id_pembelian)->first();
            $Updatepembelian->status='lunas';
            $Updatepembelian->save();
        }
        if ($BayarSuplier->save()) {
            $UpdateSuplier = HutangSuplier::where('suplier_id',$request->id_suplier)->first();
            $UpdateSuplier->total_pembayaran_hutang =  $UpdateSuplier->total_pembayaran_hutang + $request->jumlah_bayar;
            $UpdateSuplier->sisa_hutang = $UpdateSuplier->total_hutang -  $UpdateSuplier->total_pembayaran_hutang ;
            $UpdateSuplier->save();
            KasHelper::add($request->faktur, 'pengeluaran', 'bayar piutang',0,$request->jumlah_bayar);
            echo json_encode(array('status'=>'success'));
        } else {
            echo json_encode(array('status'=>'failed'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $BayarSuplier = BayarHutangSuplier::findOrFail($id);
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
        $BayarSuplier = BayarHutangSuplier::find($id);
        $BayarSuplier->nama = $request->nama;
        if ($BayarSuplier->save()) {
            session()->flash('message', 'Data berhasil diubah!');
            return redirect()->route('bayarSuplier.index')->with('status', 'success');
        } else {
            session()->flash('message', 'Data gagal diubah!');
            return redirect()->route('bayarSuplier.index')->with('status', 'danger');
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
        $BayarSuplier = BayarHutangSuplier::findOrFail($id);
        $relasi = BayarHutangSuplier::with('barang')->find($id);
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