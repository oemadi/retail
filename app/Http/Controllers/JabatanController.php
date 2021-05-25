<?php

namespace App\Http\Controllers;

use App\Jabatan;
use Illuminate\Http\Request;

class JabatanController extends Controller
{
    public function index()
    {
        return view("pages.jabatan.index");
    }
		public function getJabatan(Request $request){
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
			
			$totalRecords = Jabatan::select('count(*)  as allcount')->count();
			$totalRecordswithFilter =  Jabatan::select('count(*)  as allcount')
			->where('nama','like','%'.$searchValue.'%')
			->count();
			
			$records = Jabatan::orderBy($columnName,$columnSortOrder)
			->where('jabatan.nama','like','%'.$searchValue.'%')
			->select('jabatan.*')
			->skip($start)
			->take($rowperpage)
			->get();
			
			$data_arr = array();
			foreach($records as $record){
		
				$id= $record->id;
				$nama = $record->nama;
				$gaji_pokok = $record->gaji_pokok;
				$lain_lain = $record->lain_lain;
				$deskripsi = $record->deskripsi;
				
				$data_arr[]=array('id'=>$id,'nama'=>$nama,'gaji_pokok'=>$gaji_pokok,'lain_lain'=>$lain_lain,'deskripsi'=>$deskripsi);
				
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
        return view("pages.jabatan.create");
    }
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'gaji_pokok' => 'required|integer',
            'lain_lain' => 'required|integer',
            'deskripsi' => 'required|min:8'
        ]);
        $jabatan = new Jabatan();
        $jabatan->nama = $request->nama;
        $jabatan->gaji_pokok = $request->gaji_pokok;
        $jabatan->lain_lain = $request->lain_lain;
        $jabatan->deskripsi = $request->deskripsi;
        if ($jabatan->save()) {
            session()->flash('message', 'Data berhasil disimpan!');
            return redirect()->route('jabatan.index')->with('status', 'success');
        } else {
            session()->flash('message', 'Data gagal disimpan!');
            return redirect()->route('jabatan.index')->with('status', 'danger');
        }
    }
    public function edit($id)
    {
        $jabatan = Jabatan::find($id);
        return view("pages.jabatan.edit", compact('jabatan'));
    }
    public function update(Request $request, Jabatan $jabatan)
    {

        $request->validate([
            'nama' => 'required',
            'gaji_pokok' => 'required|integer',
            'lain_lain' => 'required|integer',
            'deskripsi' => 'required|min:8'
        ]);
        $jabatan->nama = $request->nama;
        $jabatan->gaji_pokok = $request->gaji_pokok;
        $jabatan->lain_lain = $request->lain_lain;
        $jabatan->deskripsi = $request->deskripsi;
        if ($jabatan->update()) {
            session()->flash('message', 'Data berhasil diubah!');
            return redirect()->route('jabatan.index')->with('status', 'success');
        } else {
            session()->flash('message', 'Data gagal diubah!');
            return redirect()->route('jabatan.index')->with('status', 'danger');
        }
    }
    public function destroy($id)
    {
        $jabatan = Jabatan::findOrFail($id);
        $relasi = Jabatan::with('pegawai')->find($id);
        if (count($relasi->pegawai) < 1) {
            if ($jabatan->delete()) {
                session()->flash('message', 'Data berhasil dihapus!');
                return redirect()->route('jabatan.index')->with('status', 'success');
            } else {
                session()->flash('message', 'Data gagal dihapus!');
                return redirect()->route('jabatan.index')->with('status', 'danger');
            }
        } else {
            session()->flash('message', 'Data gagal dihapus!');
            return redirect()->route('jabatan.index')->with('status', 'danger');
        }
    }
}
