<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BayarHutangCustomer;
use App\HutangCustomer;
use App\Penjualan;
use App\Customer;
// use App\Pembelian;
use DB;
use Session;
use Kas as KasHelper;

class BayarCustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view("pages.transaksi.bayar_customer.index");
    }
    public function getDataPegawaiSelect()
    {
        //$id_ship = Session::get('id_customer');
        $id = request()->get('search');
        $res = DB::select("SELECT a.* from pegawai a
        where a.nama like '%".$id."%'
         order by a.nama limit 10
        ");
       foreach($res as $row){
           $data[] = array('id'=>$row->id,'text'=>$row->nama.'-'.$row->alamat);
       }
        return json_encode($data);
    }
    public function getDataHutangCustomer()
    {
        $id = request()->get('search');
        $res = DB::select("SELECT a.* from pegawai a
        where a.nama like '%".$id."%'
         order by a.nama limit 10
        ");
       foreach($res as $row){
           $data[] = array('id'=>$row->id,'text'=>$row->nama.'-'.$row->alamat);
       }
        return json_encode($data);
    }
    //getDataHutangCustomer
    public function getDataPegawaiSelect2()
    {
        //$id_ship = Session::get('id_ship');
        $id = request()->post('id_pegawai');
        $res = DB::select("SELECT a.* from pegawai a where a.id=$id");
       // dd($res);
        return $res;
    }
		public function getDataBayarCustomer(Request $request){

            $draw = $request->get('draw');
            $start = $request->get('start');
            $rowperpage = $request->get('length');
            $penjualan_id =  $request->get('penjualanid');

            $columnIndex_arr = $request->get('order');
            $columnName_arr = $request->get('columns');
            $order_arr = $request->get('order');
            $search_arr = $request->get('search');

          //  dd($penjualan_id);
            $columnIndex = $columnIndex_arr[0]['column'];
            $columnName = $columnName_arr[$columnIndex]['data'];
            $columnSortOrder = $order_arr[0]['dir'];
            $searchValue =$search_arr['value'];

			$totalRecords = BayarHutangCustomer::select('count(*)  as allcount')->count();
			$totalRecordswithFilter =  BayarHutangCustomer::select('count(*)  as allcount')
			->count();

            $records = BayarHutangCustomer::orderBy($columnName,$columnSortOrder)
            ->join('customer','customer.id','bayar_hutang_customer.id_customer')
            ->join('penjualan','penjualan.id','bayar_hutang_customer.id_penjualan')
			->select('bayar_hutang_customer.*','customer.nama as customer',
            'penjualan.faktur as faktur_penjualan')
            ->where('penjualan.id', $penjualan_id)
			->skip($start)
			->take($rowperpage)
			->get();
           // dd($records);
			$data_arr = array();
			foreach($records as $record){

				$data_arr[]=array('id'=>$record->id,'id_bayar_hutang_customer'=>$record->id_bayar_hutang_customer,
                'customer'=>$record->customer,'tanggal_bayar'=>$record->tanggal_bayar,
                'faktur_penjualan'=>$record->faktur_penjualan,'jumlah_bayar'=>$record->jumlah_bayar,
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
    public function show($id)
    {

       $data = HutangCustomer::where('penjualan_id',$id)
       ->join('penjualan','penjualan.id','hutang_customer.penjualan_id')
       ->join('customer','customer.id','hutang_customer.customer_id')
       ->select('hutang_customer.*','customer.nama as customer','penjualan.faktur as faktur_penjualan')
       ->first();

        $faktur = BayarHutangCustomer::kodeFaktur();
        return view("pages.transaksi.bayar_customer.create",compact('faktur','data'));
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
        $BayarCustomer = new BayarHutangCustomer();
        $BayarCustomer->tanggal_bayar =  date('Y-m-d',strtotime($request->tanggal));
        $BayarCustomer->id_bayar_hutang_customer = $request->faktur;
        $BayarCustomer->id_customer = $request->id_customer;
        $BayarCustomer->id_penjualan = $request->id_penjualan;
        $BayarCustomer->jumlah_bayar = $request->jumlah_bayar;
        $BayarCustomer->sisa_hutang = $request->sisa_hutang;
        if($request->sisa_hutang<=0){
            $UpdatePenjualan = Penjualan::where('id',$request->id_penjualan)->first();
            $UpdatePenjualan->status='lunas';
            $UpdatePenjualan->save();
        }
        if ($BayarCustomer->save()) {
            $UpdateCustomer = HutangCustomer::where('penjualan_id',$request->id_penjualan)->first();
            $UpdateCustomer->total_pembayaran_hutang =  $UpdateCustomer->total_pembayaran_hutang + $request->jumlah_bayar;
            $UpdateCustomer->sisa_hutang = $UpdateCustomer->total_hutang -  $UpdateCustomer->total_pembayaran_hutang ;
            $UpdateCustomer->save();

            // $UpdateSuplier = HutangSuplier::where('suplier_id',$request->id_suplier)->first();
            // $UpdateSuplier->total_pembayaran_hutang =  $UpdateSuplier->total_pembayaran_hutang + $request->jumlah_bayar;
            // $UpdateSuplier->sisa_hutang = $UpdateSuplier->total_hutang -  $UpdateSuplier->total_pembayaran_hutang ;
            // $UpdateSuplier->save();

            KasHelper::add($request->faktur, 'pendapatan', 'bayar hutang',$request->jumlah_bayar,0);
            echo json_encode(array('status'=>'success'));
        } else {
            echo json_encode(array('status'=>'failed'));
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $BayarCustomer = BayarHutangCustomer::findOrFail($id);
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
        $BayarCustomer = BayarHutangCustomer::find($id);
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
        $BayarCustomer = BayarHutangCustomer::findOrFail($id);
        $relasi = BayarHutangCustomer::with('barang')->find($id);
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
