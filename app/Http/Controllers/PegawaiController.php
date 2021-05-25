<?php

namespace App\Http\Controllers;

use App\Jabatan;
use App\Pegawai;
use Illuminate\Http\Request;

class PegawaiController extends Controller
{
    public function index()
    {
        return view("pages.pegawai.index");
    }
	public function getPegawai(Request $request){
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
		
		$totalRecords = Pegawai::select('count(*)  as allcount')->count();
		$totalRecordswithFilter =  Pegawai::select('count(*)  as allcount')
		->where('nama','like','%'.$searchValue.'%')
		->count();
		
		$records = Pegawai::orderBy($columnName,$columnSortOrder)
		->where('Pegawai.nama','like','%'.$searchValue.'%')
		->select('Pegawai.*')
		->skip($start)
		->take($rowperpage)
		->get();
		
		$data_arr = array();
		foreach($records as $record){
	
			$id= $record->id;
			$nama= $record->nama;
			$alamat= $record->alamat;
			$email= $record->email;
			$no_hp= $record->no_telp;
			$jabatan_id= $record->jabatan_id;
			$aksi= $record->id;         
			
			$data_arr[]=array('id'=>$id,'nama'=>$nama,'alamat'=>$alamat,'no_hp'=>$no_hp,'email'=>$email,'jabatan_id'=>$jabatan_id);
			
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
        $jabatan = Jabatan::all();
        return view("pages.pegawai.create", compact('jabatan'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'no_telp' => 'required|min:9',
            'alamat' => 'required|min:10',
            'jabatan_id' => 'required'
        ]);
        $pegawai = new Pegawai();
        $pegawai->nama = $request->nama;
        $pegawai->no_telp = $request->no_telp;
        $pegawai->alamat = $request->alamat;
        $pegawai->jabatan_id = $request->jabatan_id;
        if ($request->email) {
            $pegawai->email = $request->email;
        }
        if ($pegawai->save()) {
            session()->flash('message', 'Data berhasil disimpan!');
            return redirect()->route('pegawai.index')->with('status', 'success');
        } else {
            session()->flash('message', 'Data gagal disimpan!');
            return redirect()->route('pegawai.index')->with('status', 'danger');
        }
    }
    public function edit($id)
    {
        $jabatan = Jabatan::all();
        $pegawai = Pegawai::findOrFail($id);
        return view("pages.pegawai.edit", compact('jabatan', 'pegawai'));
    }
    public function update(Request $request, Pegawai $pegawai)
    {
        $request->validate([
            'nama' => 'required',
            'no_telp' => 'required|min:9',
            'alamat' => 'required|min:10',
            'jabatan_id' => 'required'
        ]);
        $pegawai->nama = $request->nama;
        $pegawai->no_telp = $request->no_telp;
        $pegawai->alamat = $request->alamat;
        $pegawai->jabatan_id = $request->jabatan_id;
        if ($request->email) {
            $pegawai->email = $request->email;
        }
        if ($pegawai->update()) {
            session()->flash('message', 'Data berhasil diubah!');
            return redirect()->route('pegawai.index')->with('status', 'success');
        } else {
            session()->flash('message', 'Data gagal diubah!');
            return redirect()->route('pegawai.index')->with('status', 'danger');
        }
    }
    public function destroy($id)
    {
        $pegawai = Pegawai::findOrFail($id);
        $relasi = Pegawai::with('gaji')->find($id);
        if (count($relasi->gaji) < 1) {
            if ($pegawai->delete()) {
                session()->flash('message', 'Data berhasil dihapus!');
                return redirect()->route('pegawai.index')->with('status', 'success');
            } else {
                session()->flash('message', 'Data gagal dihapus!');
                return redirect()->route('pegawai.index')->with('status', 'danger');
            }
        } else {
            session()->flash('message', 'Data gagal dihapus!');
            return redirect()->route('pegawai.index')->with('status', 'danger');
        }
    }
}
