<div class="panel panel-default">
    <div class="panel-body">
    @include('pages/report/logo')
        <div class="row">
            <div class="col-md-12">
<p style="margin-top:60px;line-height:5px;font-weight:bold;font-size:16px;" align="left">REKAP STOK DALAM KG</p>
<table width="100%" class="layout">
                    <thead>
                        <tr>
                            <td>#</td>
                            <td>Barang</td>
                            <td>Kategori</td>
                            <td align="center">Stok Awal </td>
                            <td align="center">Stok Masuk</td>
                            <td align="center">Stok Keluar</td>
							<td align="center">Penyesuaian Masuk</td>
							<td align="center">Penyesuaian Keluar</td>
							<td align="center" >Stok Akhir</td>
                        </tr>
                    </thead>
                    <tbody>
                        @php

                        @foreach ($data as $key => $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $row->nama }}</td>
							<td>{{ $row->kategori }}</td>
                            <td align="right">{{ format_angka($row->stok_awal) }}</td>
                            <td align="right">{{ format_angka($row->stok_masuk) }}</td>
							<td align="right">{{ format_angka($row->stok_keluar) }}</td>
                            <td align="right">{{ format_angka($row->stok_penyesuaian_penambahan) }}</td>
							<td align="right">{{ format_angka($row->stok_penyesuaian_pengurangan) }}</td>
							<td align="right">{{ format_angka($row->stok_akhir) }}</td>

                        </tr>

                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    </div>
