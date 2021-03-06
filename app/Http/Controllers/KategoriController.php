<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Kategori;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("pages.kategori.index");
    }
		public function getKategori(Request $request){
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

			$totalRecords = Kategori::select('count(*)  as allcount')->count();
			$totalRecordswithFilter =  Kategori::select('count(*)  as allcount')
			->where('nama','like','%'.$searchValue.'%')
			->count();

			$records = Kategori::orderBy($columnName,$columnSortOrder)
			->where('kategori.nama','like','%'.$searchValue.'%')
			->select('kategori.*')
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
        return view("pages.kategori.create");
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
        $kategori = new Kategori();
        $kategori->nama = $request->nama;
        if ($kategori->save()) {
            session()->flash('message', 'Data berhasil disimpan!');
            return redirect()->route('kategori.index')->with('status', 'success');
        } else {
            session()->flash('message', 'Data gagal disimpan!');
            return redirect()->route('kategori.index')->with('status', 'danger');
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
        $kategori = Kategori::findOrFail($id);
        return view("pages.kategori.edit", compact('kategori'));
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
        $kategori = Kategori::find($id);
        $kategori->nama = $request->nama;
        if ($kategori->save()) {
            session()->flash('message', 'Data berhasil diubah!');
            return redirect()->route('kategori.index')->with('status', 'success');
        } else {
            session()->flash('message', 'Data gagal diubah!');
            return redirect()->route('kategori.index')->with('status', 'danger');
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
        $kategori = Kategori::findOrFail($id);
        $relasi = Kategori::with('barang')->find($id);
        if (count($relasi->barang) < 1) {
            if ($kategori->delete()) {
                session()->flash('message', 'Data berhasil dihapus!');
                return redirect()->route('kategori.index')->with('status', 'success');
            } else {
                session()->flash('message', 'Data gagal dihapus!');
                return redirect()->route('kategori.index')->with('status', 'danger');
            }
        } else {
            session()->flash('message', 'Data gagal dihapus!');
            return redirect()->route('pelanggan.index')->with('status', 'danger');
        }
    }
}
