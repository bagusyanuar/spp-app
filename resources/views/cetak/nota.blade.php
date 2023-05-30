@extends('cetak.index')

@section('content')
    @php
        $arrBulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    @endphp
    <div class="text-center report-title">BUKTI PEMBAYARAN SPP</div>
    <div class="row" style="margin-top: 10px;">
        <div class="col-xs-2 f-bold text-body-small">Nama Siswa</div>
        <div class="col-xs-4 text-body-small">: {{ $data->pos_kelas_siswa->siswa->nama }}</div>
        <div class="col-xs-2 f-bold text-body-small">Kelas</div>
        <div class="col-xs-3 text-body-small">: {{ $data->pos_kelas_siswa->kelas->nama }}</div>
    </div>
    <div class="row">
        <div class="col-xs-2 f-bold text-body-small">NIS</div>
        <div class="col-xs-4 text-body-small">: {{ $data->pos_kelas_siswa->siswa->nis }}</div>
    </div>
    <hr style="margin-bottom: 0;">
    <table id="my-table" class="table display" style="margin-top: 10px">
        <thead>
        <tr>
            <th width="10%" class="text-center text-body-small">#</th>
            <th class="text-body-small">Pembayaran Bulan</th>
            <th width="15%" class="text-right text-body-small">Nominal</th>
        </tr>
        </thead>
        <tbody>
        @foreach($data->details as $v)
            <tr>
                <td width="5%" class="text-center text-body-small">{{ $loop->index + 1 }}</td>
                <td class="text-body-small">{{ $arrBulan[$v->bulan] }}</td>
                <td class="text-right text-body-small">{{ number_format($v->nominal, 0 , ',', '.') }}</td>
            </tr>
            @foreach($v->keterangan as $k)
                <tr>
                    <td width="5%" class="text-center"></td>
                    <td class="text-body-small" colspan="2">{{ $k }}</td>
                </tr>
            @endforeach
        @endforeach
        </tbody>
    </table>
    <hr style="margin-bottom: 5px;">
    <div class="row">
        <div class="col-xs-9 f-bold text-body-small" style="text-align: right;">Total Pembayaran</div>
        <div class="col-xs-2 f-bold text-body-small" style="text-align: right;">
            : {{ number_format($data->nominal, 0, ',', '.') }}</div>
    </div>
    <hr style="margin-bottom: 5px; margin-top: 5px;">
    <div class="row">
        <div class="col-xs-8 f-bold report-header-sub-title" style="text-align: right;"></div>
        <div class="col-xs-3 f-bold text-body-small" style="text-align: center;">
            Wonogiri, {{ \Carbon\Carbon::parse($data->tanggal)->format('d F Y') }}</div>
    </div>
    <br>
    <br>
    <br>
    <div class="row">
        <div class="col-xs-8 f-bold report-header-sub-title" style="text-align: right;"></div>
        <div class="col-xs-3 f-bold text-body-small" style="text-align: center;">(Admin)</div>
    </div>
@endsection
