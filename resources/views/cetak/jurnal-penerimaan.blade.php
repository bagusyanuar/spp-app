@extends('cetak.index')

@section('content')
    <div class="text-center report-title">LAPORAN JURNAL PENERIMAAN</div>
    <div class="text-center text-body font-weight-bold">Periode {{ \Carbon\Carbon::parse($tgl1)->format('d F Y') }}
        - {{ \Carbon\Carbon::parse($tgl2)->format('d F Y') }}</div>
    <table id="my-table" class="table display" style="margin-top: 10px">
        <thead>
        <tr>
            <th width="5%" class="text-center f12 text-body-small">#</th>
            <th width="10%" class="f12 text-body-small">Tanggal</th>
            <th class="f12 text-body-small">Nama Siswa</th>
            <th class="f12 text-body-small" width="15%">Kelas</th>
            <th width="15%" class="f12 text-body-small text-right">Nominal</th>
        </tr>
        </thead>
        <tbody>
        @foreach($data as $v)
            <tr>
                <td width="5%" class="text-center text-body-small">{{ $loop->index + 1 }}</td>
                <td class="text-body-small">{{ $v->tanggal }}</td>
                <td class="text-body-small">{{ $v->pos_kelas_siswa->siswa->nama }}</td>
                <td class="text-body-small">{{ $v->pos_kelas_siswa->kelas->nama }}</td>
                <td class="text-right text-body-small">{{ number_format($v->nominal, 0, ',', '.') }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <hr>
    <div class="row">
        <div class="col-xs-9 f-bold text-body-small" style="text-align: right;">Total Penerimaan </div>
        <div class="col-xs-2 f-bold text-body-small" style="text-align: right;">: {{ number_format($data->sum('nominal'), 0, ',', '.') }}</div>
    </div>
    <hr>
    <div class="row">
        <div class="col-xs-8 f-bold report-header-sub-title" style="text-align: right;"></div>
        <div class="col-xs-3 f-bold text-body-small" style="text-align: center;">Wonogiri, {{ \Carbon\Carbon::now()->format('d F Y') }}</div>
    </div>
    <br>
    <br>
    <br>
    <div class="row">
        <div class="col-xs-8 f-bold report-header-sub-title" style="text-align: right;"></div>
        <div class="col-xs-3 f-bold text-body-small" style="text-align: center;">(Admin)</div>
    </div>
@endsection
