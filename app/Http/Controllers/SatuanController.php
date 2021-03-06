<?php

namespace App\Http\Controllers;

use App\Satuan;
use Illuminate\Http\Request;

class SatuanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $satuan = Satuan::all();
        return view("pages.satuan.index", compact('satuan'));
    }
	public function getSatuan(Request $request){
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
			
			$totalRecords = Satuan::select('count(*)  as allcount')->count();
			$totalRecordswithFilter =  Satuan::select('count(*)  as allcount')
			->where('nama','like','%'.$searchValue.'%')
			->count();
			
			$records = Satuan::orderBy($columnName,$columnSortOrder)
			->where('satuan.nama','like','%'.$searchValue.'%')
			->select('satuan.*')
			->skip($start)
			->take($rowperpage)
			->get();
			
			$data_arr = array();
			foreach($records as $record){
		
				$id= $record->id;
				$nama= $record->nama;
				$aksi= $record->id;         
				
				$data_arr[]=array('id'=>$id,'nama'=>$nama);
				
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
        return view("pages.satuan.create");
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
            'nama' => 'required|min:2'
        ]);
        $satuan = new Satuan();
        $satuan->nama = $request->nama;
        if ($satuan->save()) {
            session()->flash('message', 'Data berhasil disimpan!');
            return redirect()->route('satuan.index')->with('status', 'success');
        } else {
            session()->flash('message', 'Data gagal disimpan!');
            return redirect()->route('satuan.index')->with('status', 'danger');
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
        $satuan = Satuan::findOrFail($id);
        return view("pages.satuan.edit", compact('satuan'));
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
            'nama' => 'required|min:2'
        ]);
        $satuan = Satuan::find($id);
        $satuan->nama = $request->nama;
        if ($satuan->save()) {
            session()->flash('message', 'Data berhasil diubah!');
            return redirect()->route('satuan.index')->with('status', 'success');
        } else {
            session()->flash('message', 'Data gagal diubah!');
            return redirect()->route('satuan.index')->with('status', 'danger');
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
        $satuan = Satuan::findOrFail($id);
        $relasi = Satuan::with('barang')->find($id);
        if (count($relasi->barang) < 1) {
            if ($satuan->delete()) {
                session()->flash('message', 'Data berhasil dihapus!');
                return redirect()->route('satuan.index')->with('status', 'success');
            } else {
                session()->flash('message', 'Data gagal dihapus!');
                return redirect()->route('satuan.index')->with('status', 'danger');
            }
        } else {
            session()->flash('message', 'Data gagal dihapus!');
            return redirect()->route('satuan.index')->with('status', 'danger');
        }
    }
}
