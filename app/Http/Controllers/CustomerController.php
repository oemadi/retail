<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Session;
class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$Cusomter = Cusomter::paginate(10);
        return view("pages.customer.index");
    }
	public function getDataCustomer(Request $request){
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

		$totalRecords = Customer::select('count(*)  as allcount')->where('branch',$branch)->count();
		$totalRecordswithFilter =  Customer::select('count(*)  as allcount')
		->where('branch',$branch)->where('nama','like','%'.$searchValue.'%')->count();

		$records = Customer::orderBy($columnName,$columnSortOrder)
		->where('branch',$branch)
        ->where('customer.nama','like','%'.$searchValue.'%')
		->select('customer.*')
		->skip($start)
		->take($rowperpage)
		->get();

		$data_arr = array();
		foreach($records as $record){
			$id= $record->id;
			$nama= $record->nama;
			$alamat= $record->alamat;
			$no_hp= $record->no_hp;
			$data_arr[]=array('id'=>$id,'nama'=>$nama,'alamat'=>$alamat,'no_hp'=>$no_hp);

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
        return view("pages.customer.create");
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
            'no_hp' => 'required'

        ]);
        $branch = Session::get('branch');
        $Customer = new Customer();
        $Customer->branch = $branch;
        $Customer->nama = $request->nama;
        $Customer->alamat = $request->alamat;
        $Customer->no_hp = $request->no_hp;
        if ($Customer->save()) {
            session()->flash('message', 'Data berhasil disimpan!');
            return redirect()->route('customer.index')->with('status', 'success');
        } else {
            session()->flash('message', 'Data gagal disimpan!');
            return redirect()->route('customer.index')->with('status', 'danger');
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
        $customer = Customer::findOrFail($id);
        return view("pages.customer.edit", compact('customer'));
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
            'no_hp' => 'required'
        ]);
        $Customer = Customer::findOrFail($id);
        $Customer->nama = $request->nama;
        $Customer->alamat = $request->alamat;
        $Customer->no_hp = $request->no_hp;
        if ($Customer->save()) {
            session()->flash('message', 'Data berhasil diubah!');
            return redirect()->route('customer.index')->with('status', 'success');
        } else {
            session()->flash('message', 'Data gagal diubah!');
            return redirect()->route('customer.index')->with('status', 'danger');
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
        $Customer = Customer::findOrFail($id);
        $relasi = Customer::with('transaksi')->find($id);
        if (count($relasi->transaksi) < 1) {
            if ($Customer->delete()) {
                session()->flash('message', 'Data berhasil dihapus!');
                return redirect()->route('customer.index')->with('status', 'success');
            } else {
                session()->flash('message', 'Data gagal dihapus!');
                return redirect()->route('customer.index')->with('status', 'danger');
            }
        } else {
            session()->flash('message', 'Data gagal dihapus!');
            return redirect()->route('customer.index')->with('status', 'danger');
        }
    }
}
