<?php

namespace App\Http\Controllers;

use App\Suplier;
use Illuminate\Http\Request;

class SuplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $suplier = Suplier::orderBy("created_at", "DESC")->paginate(10);
        return view("pages.suplier.index", compact('suplier'));
    }
		public function getDataMasterSuplier(Request $request){
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

			$totalRecords = Suplier::select('count(*)  as allcount')->count();
			$totalRecordswithFilter =  Suplier::select('count(*)  as allcount')
			->where('nama','like','%'.$searchValue.'%')
			->count();

			$records = Suplier::orderBy($columnName,$columnSortOrder)
			->where('suplier.nama','like','%'.$searchValue.'%')
			->select('suplier.*')
			->skip($start)
			->take($rowperpage)
			->get();

			$data_arr = array();
			foreach($records as $record){

				$id= $record->id;
				$nama= $record->nama;
				$kontak= $record->kontak;
				$alamat= $record->alamat;
				$no_hp= $record->no_hp;
                $email= $record->email;
				$data_arr[]=array('id'=>$id,'nama'=>$nama,'kontak'=>$kontak,
                'alamat'=>$alamat,'no_hp'=>$no_hp,'email'=>$email);

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
        return view("pages.suplier.create");
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
            'nama' => 'required|min:4',
            'kontak' => 'required',
            'no_hp' => 'required',
            'alamat' => 'required|min:10',
        ]);
        $suplier = new Suplier();
        $suplier->nama = $request->nama;
        $suplier->no_hp = $request->no_hp;
        $suplier->alamat = $request->alamat;
        $suplier->kontak = $request->kontak;
        $suplier->email = $request->email;

        if ($request->email) {
            $suplier->email = $request->email;
        }
        if ($suplier->save()) {
            session()->flash('message', 'Data berhasil disimpan!');
            return redirect()->route('suplier.index')->with('status', 'success');
        } else {
            session()->flash('message', 'Data gagal disimpan!');
            return redirect()->route('suplier.index')->with('status', 'danger');
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
        $suplier = Suplier::findOrFail($id);
        return view("pages.suplier.edit", compact('suplier'));
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
            'nama' => 'required',
            'alamat' => 'required',
        ]);
        $suplier =  Suplier::find($id);
        $suplier->nama = $request->nama;
        $suplier->alamat = $request->alamat;
        if ($request->no_hp) {
            $suplier->no_hp = $request->no_hp;
        }
        if ($request->email) {
            $suplier->email = $request->email;
        }
        if ($suplier->save()) {
            session()->flash('message', 'Data berhasil diubah!');
            return redirect()->route('suplier.index')->with('status', 'success');
        } else {
            session()->flash('message', 'Data gagal diubah!');
            return redirect()->route('suplier.index')->with('status', 'danger');
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
        $suplier = Suplier::find($id);
        // $relasiHutang = Suplier::with('hutang')->find($id);
        // $relasiPembelian = Suplier::with('pembelian')->find($id);
        $suplier->delete();
        session()->flash('message', 'Data berhasil dihapus!');
        return redirect()->route('suplier.index')->with('status', 'success');

        // if (count($relasiHutang->hutang) < 1 && count($relasiPembelian->pembelian) < 1) {
        //     if ($suplier->delete()) {
        //         session()->flash('message', 'Data berhasil dihapus!');
        //         return redirect()->route('suplier.index')->with('status', 'success');
        //     } else {
        //         session()->flash('message', 'Data gagal dihapus!');
        //         return redirect()->route('suplier.index')->with('status', 'danger');
        //     }
        // } else {
        //     session()->flash('message', 'Data gagal dihapus!');
        //     return redirect()->route('suplier.index')->with('status', 'danger');
        // }
    }
}
