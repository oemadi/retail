<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\HutangCustomer;
// use App\Pembelian;
use DB;
use Session;

class HutangCustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view("pages.transaksi.hutang_customer.index");
    }

		public function getHutangCustomer(Request $request){
			$draw = $request->get('draw');
			$start = $request->get('start');
			$rowperpage = $request->get('length');
            $id_customer = $request->get('id_customer');
            $id_status = $request->get('id_status');

			$columnIndex_arr = $request->get('order');
			$columnName_arr = $request->get('columns');
			$order_arr = $request->get('order');
			$search_arr = $request->get('search');

			$columnIndex = $columnIndex_arr[0]['column'];
			$columnName = $columnName_arr[$columnIndex]['data'];
			$columnSortOrder = $order_arr[0]['dir'];
			$searchValue =$search_arr['value'];
            $branch = Session::get('branch');

			$totalRecords = HutangCustomer::select('count(*)  as allcount')->count();

            $totalRecordswithFilterA = DB::select("SELECT count(*) as allcount from hutang_customer a where a.branch= $branch
            ".($id_customer!="" ?  "and a.customer_id='".$id_customer."'"  : "")."
            ".($id_status!="all" ?  "and a.status='".$id_status."'"  : "")."");
            $totalRecordswithFilter =  $totalRecordswithFilterA[0]->allcount;

            $records = DB::select("SELECT a.*,b.nama as customer,c.faktur as faktur_penjualan
            from hutang_customer a
            inner join customer b on b.id=a.customer_id
            inner join penjualan c on c.id=a.penjualan_id
            where a.branch= $branch
            ".($id_customer!="" ?  "and a.customer_id='".$id_customer."'"  : "")."
            ".($id_status!="all" ?  "and a.status='".$id_status."'"  : "")."
             order by $columnName $columnSortOrder
             limit $start,$rowperpage");

			// $totalRecordswithFilter =  HutangCustomer::select('count(*)  as allcount')
			// ->count();
            // $records = HutangCustomer::orderBy($columnName,$columnSortOrder)
            // ->join('customer','customer.id','hutang_customer.customer_id')
            // ->join('penjualan','penjualan.id','hutang_customer.penjualan_id')
			// ->select('hutang_customer.*','customer.nama as customer',
            // 'penjualan.faktur as faktur_penjualan')
			// ->skip($start)
			// ->take($rowperpage)
			// ->get();

          //  dd($records);

			$data_arr = array();
			foreach($records as $record){

				$data_arr[]=array('id'=>$record->id,'penjualan_id'=>$record->penjualan_id,'faktur_penjualan'=>$record->faktur_penjualan,
                'customer'=>$record->customer,'customer_id'=>$record->customer_id,
                'total_hutang'=>$record->total_hutang,'total_pembayaran_hutang'=>$record->total_pembayaran_hutang,
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
    public function create()
    {
        $faktur = HutangCustomer::kodeFaktur();
        return view("pages.transaksi.hutang_customer.create",compact('faktur'));
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
        $BayarCustomer = new HutangCustomer();
        $BayarCustomer->tanggal_bayar =  date('Y-m-d',strtotime($request->tanggal));
        $BayarCustomer->id_bayar_hutang_customer = $request->faktur;
        $BayarCustomer->id_customer = $request->id_customer;
        $BayarCustomer->id_penjualan = $request->id_penjualan;
        $BayarCustomer->jumlah_bayar = $request->jumlah_bayar;
        $BayarCustomer->sisa_hutang = $request->sisa_hutang;

        if ($BayarCustomer->save()) {
            session()->flash('message', 'Data berhasil disimpan!');
            return redirect()->route('bayarCustomer')->with('status', 'success');
        } else {
            session()->flash('message', 'Data gagal disimpan!');
            return redirect()->route('bayarCustomer')->with('status', 'danger');
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
        $BayarCustomer = HutangCustomer::findOrFail($id);
        return view("pages.BayarCustomer.edit", compact('BayarCustomer'));
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
        $BayarCustomer = HutangCustomer::find($id);
        $BayarCustomer->nama = $request->nama;
        if ($BayarCustomer->save()) {
            session()->flash('message', 'Data berhasil diubah!');
            return redirect()->route('BayarCustomer.index')->with('status', 'success');
        } else {
            session()->flash('message', 'Data gagal diubah!');
            return redirect()->route('BayarCustomer.index')->with('status', 'danger');
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
        $BayarCustomer = HutangCustomer::findOrFail($id);
        $relasi = HutangCustomer::with('barang')->find($id);
        if (count($relasi->barang) < 1) {
            if ($BayarCustomer->delete()) {
                session()->flash('message', 'Data berhasil dihapus!');
                return redirect()->route('bayarCustomer.index')->with('status', 'success');
            } else {
                session()->flash('message', 'Data gagal dihapus!');
                return redirect()->route('bayarCustomer.index')->with('status', 'danger');
            }
        } else {
            session()->flash('message', 'Data gagal dihapus!');
            return redirect()->route('bayarCustomer.index')->with('status', 'danger');
        }
    }
}
