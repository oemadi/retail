<?php

namespace App\Http\Controllers;
use DB;
use App\Satuan;
use App\Kategori;
use App\Barang;
use Illuminate\Http\Request;
use Milon\Barcode\DNS1D;
use Session;
use Helper;

class BarangController extends Controller
{
    public function index()
    {
        return view("pages.barang.index");
    }
	public function getDataMasterBarang(Request $request){
		$draw = $request->get('draw');
		$start = $request->get('start');
		$rowperpage = $request->get('length');

        $id_kategori = $request->get('id_kategori');
        $id_barang = $request->get('id_barang');

		$columnIndex_arr = $request->get('order');
		$columnName_arr = $request->get('columns');
		$order_arr = $request->get('order');
		$search_arr = $request->get('search');

		$columnIndex = $columnIndex_arr[0]['column'];
		$columnName = $columnName_arr[$columnIndex]['data'];
		$columnSortOrder = $order_arr[0]['dir'];
		$searchValue =$search_arr['value'];

        $branch = Session::get('branch');

		$totalRecords = Barang::select('count(*)  as allcount')->count();

        $totalRecordswithFilterA = DB::select("SELECT count(*) as allcount from barang a where a.branch=$branch
        ".($id_kategori!="" ?  "and a.kategori_id='".$id_kategori."'"  : "")."
        ".($id_barang!="" ?  "and a.id='".$id_barang."'"  : "")."");
        $totalRecordswithFilter =  $totalRecordswithFilterA[0]->allcount;

        $records = DB::select("SELECT a.*,b.nama as kategori_nama,c.nama as satuan_nama from barang a
            inner join kategori b on b.id=a.kategori_id
            inner join satuan c on c.id=a.satuan_id
            where  a.branch=$branch
            ".($id_kategori!="" ?  "and a.kategori_id='".$id_kategori."'"  : "")."
            ".($id_barang!="" ?  "and a.id='".$id_barang."'"  : "")."
             order by $columnName $columnSortOrder
             limit $start,$rowperpage");

		$data_arr = array();
		foreach($records as $record){
			$id= $record->id;
            $kode= $record->kode;
			$nama= $record->nama;
			$harga_beli= format_uang($record->harga_beli);
			$harga_jual= format_uang($record->harga_jual);
			$stok_awal= ($record->stok_awal);
			$stok_masuk= ($record->stok_masuk);
			$stok_akhir= ($record->stok_akhir);
			$stok_keluar= ($record->stok_keluar);
            $stok_penyesuaian_penambahan = format_uang($record->stok_penyesuaian_penambahan);
            $stok_penyesuaian_pengurangan = format_uang($record->stok_penyesuaian_pengurangan);
			// $ppn= $record->ppn;
			// $pph= $record->pph;
			// $keuntungan= $record->keuntungan;
			// $persentase_pph_ppn_keuntungan= $record->persentase_pph_ppn_keuntungan;
			$satuan_id= $record->satuan_nama;
			$kategori_id= $record->kategori_nama;

			$data_arr[]=array('id'=>$id,'kode'=>$kode,'nama'=>$nama,'harga_beli'=>$harga_beli,'harga_jual'=>$harga_jual,
			'stok_awal'=>$stok_awal,'stok_masuk'=>$stok_masuk,'stok_akhir'=>$stok_akhir,
			'stok_keluar'=>$stok_keluar,'stok_penyesuaian_penambahan'=>$stok_penyesuaian_penambahan,
            'stok_penyesuaian_pengurangan'=>$stok_penyesuaian_pengurangan,
			'satuan_id'=>$satuan_id,'kategori_id'=>$kategori_id
			);

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
        $kodeBarang = Barang::kodeBarang();
        $satuan = Satuan::get();
        $kategori = Kategori::get();
        return view("pages.barang.create", compact('satuan', 'kategori', 'kodeBarang'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'kode_barang' => 'required',
            'nama_barang' => 'required|min:3',
            'harga_jual' => 'required|numeric',
            'harga_beli' => 'required|numeric',
            'stok_awal' => 'required|integer',
            'satuan' => 'required',
            'kategori' => 'required',
        ]);
        // $ppn = ($request->harga_beli / 100) * 10;
        // $pph = ($request->harga_beli / 100) * 1.5;
        $branch = Session::get('branch');
        $barang = new Barang();
        $barang->branch = $branch;
        $barang->kode = $request->kode_barang;
        $barang->id = $request->id_barang;
        $barang->nama = $request->nama_barang;
        $barang->harga_jual = $request->harga_jual;
        $barang->harga_beli = $request->harga_beli;
        $barang->stok_awal = $request->stok_awal;
        $barang->stok_masuk = 0;
        $barang->stok_akhir = $request->stok_awal;
        $barang->stok_keluar = 0;
        // $barang->ppn = $ppn;
        // $barang->persentase_pph_ppn_keuntungan = $request->ppn_pph;
        // $barang->pph = $pph;
        // $barang->keuntungan = ($request->harga_beli / 100) * ($request->ppn_pph - 11.5);
        $barang->satuan_id = $request->satuan;
        $barang->kategori_id = $request->kategori;
        if ($barang->save()) {
            session()->flash('message', 'Data berhasil disimpan!');
            return redirect()->route('barang.index')->with('status', 'success');
        } else {
            session()->flash('message', 'Data gagal disimpan!');
            return redirect()->route('barang.index')->with('status', 'danger');
        }
    }

    public function show($id)
    {
        $response = Barang::findOrFail($id);
        return response()->json($response);
    }
    public function updateStok(Request $request, $id)
    {
        $barang = Barang::findOrFail($id);
        $request->validate([
            'penambahan_stok_masuk' => 'required|integer|min:0'
        ]);
        $barang->stok_masuk += (int) $request->penambahan_stok_masuk;
        $barang->stok_akhir += (int) $request->penambahan_stok_masuk;
        if ($barang->save()) {
            session()->flash('message', 'Data stok berhasil ditambah!');
            return redirect()->route('barang.index')->with('status', 'success');
        } else {
            session()->flash('message', 'Data stok gagal ditambah!');
            return redirect()->route('barang.index')->with('status', 'danger');
        }
    }
    public function edit($id)
    {
        $satuan = Satuan::get();
        $kategori = Kategori::get();
        $barang = Barang::with('satuan', 'kategori')->where('id', $id)->firstOrFail();
        return view("pages.barang.edit", compact('barang', 'satuan', 'kategori'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_barang' => 'required|min:3',
            'harga_jual' => 'required|numeric',
            'harga_beli' => 'required|numeric',
            'satuan' => 'required',
            'kategori' => 'required',
        ]);
        // $ppn = ($request->harga_beli / 100) * 10;
        // $pph = ($request->harga_beli / 100) * 1.5;
        $barang = Barang::findOrFail($request->id);
        $barang->nama = $request->nama_barang;
        // $barang->ppn = $ppn;
        // $barang->persentase_pph_ppn_keuntungan = $request->ppn_pph;
        // $barang->pph = $pph;
        // $barang->keuntungan = ($request->harga_beli / 100) * ($request->ppn_pph - 11.5);
        $barang->harga_jual = $request->harga_jual;
        $barang->harga_beli = $request->harga_beli;
        $barang->satuan_id = $request->satuan;
        $barang->kategori_id = $request->kategori;
        if ($barang->save()) {
            session()->flash('message', 'Data berhasil diubah!');
            return redirect()->route('barang.index')->with('status', 'success');
        } else {
            session()->flash('message', 'Data gagal diubah!');
            return redirect()->route('barang.index')->with('status', 'danger');
        }
    }
    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);
        if ($barang->delete()) {
            session()->flash('message', 'Data berhasil dihapus!');
            return redirect()->route('barang.index')->with('status', 'success');
        } else {
            session()->flash('message', 'Data gagal dihapus!');
            return redirect()->route('barang.index')->with('status', 'danger');
        }
    }
}
