@extends('cetak.index')

@section('content')
    <div class="text-center report-title">LAPORAN REKAPITULASI PEMBAYARAN</div>
    @php
        $arrBulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    @endphp
    <table id="my-table" class="table display" style="margin-top: 10px">
        <thead>
        <tr>
            <th width="3%" class="text-center f12 text-body-very-small">#</th>
            <th width="8%" class="f12 text-body-very-small">NIS</th>
            <th class="f12 text-body-very-small" width="8%">Nama Siswa</th>
            <th class="f12 text-body-very-small" width="5%">Juni</th>
            <th class="f12 text-body-very-small" width="5%">Juli</th>
            <th class="f12 text-body-very-small" width="5%">Agustus</th>
            <th class="f12 text-body-very-small" width="5%">September</th>
            <th class="f12 text-body-very-small" width="5%">Oktober</th>
            <th class="f12 text-body-very-small" width="5%">November</th>
            <th class="f12 text-body-very-small" width="5%">Desember</th>
            <th class="f12 text-body-very-small" width="5%">Januari</th>
            <th class="f12 text-body-very-small" width="5%">Februari</th>
            <th class="f12 text-body-very-small" width="5%">Maret</th>
            <th class="f12 text-body-very-small" width="5%">April</th>
            <th class="f12 text-body-very-small" width="5%">Mei</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
@endsection
