@extends('cetak.index')

@section('content')
    <div class="text-center report-title">LAPORAN REKAPITULASI PEMBAYARAN TAHUN AJARAN {{ $tahun_ajaran->periode }}</div>
    <div class="row">
        <div class="col-xs-1">Kelas</div>
        <div class="col-xs-1">: {{ $kelas->nama }}</div>
    </div>
    @php
        $arrBulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    @endphp
    <table id="my-table" class="table display" style="margin-top: 10px">
        <thead>
        <tr>
            <th width="3%" class="text-center f12 text-body-very-small">#</th>
            <th width="8%" class="f12 text-body-very-small">NIS</th>
            <th class="f12 text-body-very-small" width="8%">Nama Siswa</th>
            <th class="f12 text-body-very-small text-center" width="5%">Juli</th>
            <th class="f12 text-body-very-small text-center" width="5%">Agustus</th>
            <th class="f12 text-body-very-small text-center" width="5%">September</th>
            <th class="f12 text-body-very-small text-center" width="5%">Oktober</th>
            <th class="f12 text-body-very-small text-center" width="5%">November</th>
            <th class="f12 text-body-very-small text-center" width="5%">Desember</th>
            <th class="f12 text-body-very-small text-center" width="5%">Januari</th>
            <th class="f12 text-body-very-small text-center" width="5%">Februari</th>
            <th class="f12 text-body-very-small text-center" width="5%">Maret</th>
            <th class="f12 text-body-very-small text-center" width="5%">April</th>
            <th class="f12 text-body-very-small text-center" width="5%">Mei</th>
            <th class="f12 text-body-very-small text-center" width="5%">Juni</th>
        </tr>
        </thead>
        <tbody>
        @foreach($data as $v)
            <tr>
                <td width="5%" class="text-center text-body-very-small">{{ $loop->index + 1 }}</td>
                <td class="text-body-very-small">{{ $v['nis'] }}</td>
                <td class="text-body-very-small">{{ $v['nama'] }}</td>
                <td class="text-body-very-small text-center">{{ $v['bulan'][6]['value'] }}</td>
                <td class="text-body-very-small text-center">{{ $v['bulan'][7]['value'] }}</td>
                <td class="text-body-very-small text-center">{{ $v['bulan'][8]['value'] }}</td>
                <td class="text-body-very-small text-center">{{ $v['bulan'][9]['value'] }}</td>
                <td class="text-body-very-small text-center">{{ $v['bulan'][10]['value'] }}</td>
                <td class="text-body-very-small text-center">{{ $v['bulan'][11]['value'] }}</td>
                <td class="text-body-very-small text-center">{{ $v['bulan'][0]['value'] }}</td>
                <td class="text-body-very-small text-center">{{ $v['bulan'][1]['value'] }}</td>
                <td class="text-body-very-small text-center">{{ $v['bulan'][2]['value'] }}</td>
                <td class="text-body-very-small text-center">{{ $v['bulan'][3]['value'] }}</td>
                <td class="text-body-very-small text-center">{{ $v['bulan'][4]['value'] }}</td>
                <td class="text-body-very-small text-center">{{ $v['bulan'][5]['value'] }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
