<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Gaji;
use App\Pegawai;
use DB;
use Kas as KasHelper;
use Session;

class PenggajianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view("pages.transaksi.penggajian.index");
    }
    public function getDataPegawaiSelect()
    {
       $branch =  Session::get('branch');
        $id = request()->get('search');
        $res = DB::select("SELECT a.* from pegawai a
        where a.branch=$branch and a.nama like '%".$id."%'
         order by a.nama limit 10
        ");
       foreach($res as $row){
           $data[] = array('id'=>$row->id,'text'=>$row->nama.'-'.$row->alamat);
       }
        return json_encode($data);
    }
    public function getDataPegawaiSelect2()
    {
        $branch =  Session::get('branch');
        $id = request()->post('id_pegawai');
        $res = DB::select("SELECT a.* from pegawai a where a.id=$id");
       // dd($res);
        return $res;
    }
		public function getDataPenggajian(Request $request){
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
            $branch = Session::get('branch');

			$totalRecords = Gaji::select('count(*)  as allcount')->where('branch',$branch)->count();
			$totalRecordswithFilter =  Gaji::select('count(*)  as allcount')
			->join('pegawai','pegawai.id','gaji.pegawai_id')
            ->where('pegawai.branch',$branch)
            ->where('pegawai.nama','like','%'.$searchValue.'%')
            ->count();
// dd($searchValue);
			$records = Gaji::orderBy($columnName,$columnSortOrder)
            ->join('pegawai','pegawai.id','gaji.pegawai_id')
			->select('gaji.*','pegawai.nama','pegawai.gaji')
            ->where('pegawai.branch',$branch)
            ->where('pegawai.nama','like','%'.$searchValue.'%')
			->skip($start)
			->take($rowperpage)
			->get();

			$data_arr = array();
			foreach($records as $record){

				$data_arr[]=array('id'=>$record->id,'tanggal_gaji'=>$record->tanggal_gaji,'faktur'=>$record->faktur,
                'nama'=>$record->nama,'total_gaji'=>$record->total_gaji,'potongan'=>$record->potongan,
                'gaji_bersih'=>$record->gaji_bersih);

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
        $faktur = Gaji::kodeFaktur();
        return view("pages.transaksi.penggajian.create",compact('faktur'));
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
        $penggajian = new Gaji();
        $penggajian->tanggal_gaji =  date('Y-m-d',strtotime($request->tanggal));
      //  dd(date('Y-m-d',strtotime($request->tanggal)));
        $penggajian->faktur = $request->faktur;
        $penggajian->pegawai_id = $request->id_pegawai;
        $penggajian->total_gaji = $request->gaji;
        $penggajian->potongan = $request->potongan;
        $penggajian->gaji_bersih = $request->gaji_bersih;
        $penggajian->branch = Session::get('branch');

        if ($penggajian->save()) {
            KasHelper::add($penggajian->faktur, 'pengeluaran', 'penggajian',0,$request->gaji,Session::get('branch'));
            return json_encode(array("status"=>"berhasil"));
        } else {
            return json_encode(array("status"=>"gagal"));
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
        $penggajian = penggajian::findOrFail($id);
        return view("pages.penggajian.edit", compact('penggajian'));
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
        $penggajian = penggajian::find($id);
        $penggajian->nama = $request->nama;
        if ($penggajian->save()) {
            session()->flash('message', 'Data berhasil diubah!');
            return redirect()->route('penggajian.index')->with('status', 'success');
        } else {
            session()->flash('message', 'Data gagal diubah!');
            return redirect()->route('penggajian.index')->with('status', 'danger');
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
        $penggajian = penggajian::findOrFail($id);
        $relasi = penggajian::with('barang')->find($id);
        if (count($relasi->barang) < 1) {
            if ($penggajian->delete()) {
                session()->flash('message', 'Data berhasil dihapus!');
                return redirect()->route('penggajian.index')->with('status', 'success');
            } else {
                session()->flash('message', 'Data gagal dihapus!');
                return redirect()->route('penggajian.index')->with('status', 'danger');
            }
        } else {
            session()->flash('message', 'Data gagal dihapus!');
            return redirect()->route('pelanggan.index')->with('status', 'danger');
        }
    }
}
