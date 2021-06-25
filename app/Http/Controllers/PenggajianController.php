<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Gaji;
use App\Pegawai;

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

			$totalRecords = Penggajian::select('count(*)  as allcount')->count();
			$totalRecordswithFilter =  Penggajian::select('count(*)  as allcount')
			->count();

			$records = Penggajian::orderBy($columnName,$columnSortOrder)
            ->join('pegawai','pegawai.id','gaji.pegawai_id')
			->select('gaji.*','pegawai.nama','pegawai.gaji')
			->skip($start)
			->take($rowperpage)
			->get();

			$data_arr = array();
			foreach($records as $record){

				$data_arr[]=array('id'=>$record->id,'nama'=>$record->tanggal_gaji,'faktur'=>$record->faktur,
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
        $pegawai = Pegawai::get();
        return view("pages.transaksi.penggajian.create",compact('faktur','pegawai'));
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
            'nama' => 'required|min:3'
        ]);
        $penggajian = new penggajian();
        $penggajian->nama = $request->nama;
        if ($penggajian->save()) {
            session()->flash('message', 'Data berhasil disimpan!');
            return redirect()->route('penggajian.index')->with('status', 'success');
        } else {
            session()->flash('message', 'Data gagal disimpan!');
            return redirect()->route('penggajian.index')->with('status', 'danger');
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
