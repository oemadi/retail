<?php

namespace App\Http\Controllers;

use App\Anggota;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AnggotaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$anggota = anggota::paginate(10);
        return view("pages.anggota.index");
    }
	public function getanggota(Request $request){
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

		$totalRecords = Anggota::select('count(*)  as allcount')->count();
		$totalRecordswithFilter =  Anggota::select('count(*)  as allcount')
		->where('nama','like','%'.$searchValue.'%')
		->count();

		$records = Anggota::orderBy($columnName,$columnSortOrder)
		->where('anggota.nama','like','%'.$searchValue.'%')
		->select('anggota.*')
		->skip($start)
		->take($rowperpage)
		->get();

		$data_arr = array();
		foreach($records as $record){
			$id= $record->id;
			$nama= $record->nama;
			$alamat= $record->alamat;
			$email= $record->email;
			$no_hp= $record->no_hp;
			$data_arr[]=array('id'=>$id,'nama'=>$nama,'alamat'=>$alamat,'no_hp'=>$no_hp,'email'=>$email);

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
        return view("pages.anggota.create");
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
            'nama' => 'required|min:3',
            'alamat' => 'required|min:7',
            'no_hp' => 'required|min:10',
            'email' => 'required|email|unique:anggota,email'
        ]);
        $anggota = new Anggota();
        $anggota->nama = $request->nama;
        $anggota->alamat = $request->alamat;
        $anggota->no_hp = $request->no_hp;
        $anggota->email = $request->email;
        if ($anggota->save()) {
            session()->flash('message', 'Data berhasil disimpan!');
            return redirect()->route('anggota.index')->with('status', 'success');
        } else {
            session()->flash('message', 'Data gagal disimpan!');
            return redirect()->route('anggota.index')->with('status', 'danger');
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
        $anggota = anggota::findOrFail($id);
        return view("pages.anggota.edit", compact('anggota'));
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
            'nama' => 'required|min:3',
            'alamat' => 'required|min:7',
            'no_hp' => 'required|min:10',
            'email' => [
                'email', 'required', Rule::unique('anggota')->ignore($id)
            ]
        ]);
        $anggota = Anggota::findOrFail($id);
        $anggota->nama = $request->nama;
        $anggota->alamat = $request->alamat;
        $anggota->no_hp = $request->no_hp;
        $anggota->email = $request->email;
        if ($anggota->save()) {
            session()->flash('message', 'Data berhasil diubah!');
            return redirect()->route('anggota.index')->with('status', 'success');
        } else {
            session()->flash('message', 'Data gagal diubah!');
            return redirect()->route('anggota.index')->with('status', 'danger');
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
        $anggota = Anggota::findOrFail($id);
        $relasi = Anggota::with('transaksi')->find($id);
        if (count($relasi->transaksi) < 1) {
            if ($anggota->delete()) {
                session()->flash('message', 'Data berhasil dihapus!');
                return redirect()->route('anggota.index')->with('status', 'success');
            } else {
                session()->flash('message', 'Data gagal dihapus!');
                return redirect()->route('anggota.index')->with('status', 'danger');
            }
        } else {
            session()->flash('message', 'Data gagal dihapus!');
            return redirect()->route('anggota.index')->with('status', 'danger');
        }
    }
}
