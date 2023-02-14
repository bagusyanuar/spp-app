@extends('layout')

@section('css')
@endsection

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-3">
        <p class="font-weight-bold mb-0" style="font-size: 20px">Halaman Laporan Jurnal Penerimaan</p>
        <ol class="breadcrumb breadcrumb-transparent mb-0">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Laporan Jurnal Penerimaan
            </li>
        </ol>
    </div>
    <div class="w-100 p-2">
        <div class="card card-outline card-info">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div>
                        <p class="font-weight-bold">Laporan Jurnal Penerimaan Tahun
                            Ajaran {{ $tahun_ajaran !== null ? $tahun_ajaran->periode : '-' }}</p>
                    </div>
                    {{--                    <div class="text-right">--}}
                    {{--                        <a href="{{ route('pembayaran.add') }}" class="btn btn-primary"><i--}}
                    {{--                                class="fa fa-credit-card mr-1"></i><span--}}
                    {{--                                class="font-weight-bold">Pembayaran</span></a>--}}
                    {{--                    </div>--}}
                </div>
            </div>
            <div class="card-body">
                <p class="font-weight-bold mb-0">Filter Tanggal</p>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="d-flex align-items-center w-50">
                        <input type="date" class="form-control" name="tgl1" id="tgl1" value="{{ date('Y-m-d') }}">
                        <span class="font-weight-bold mr-2 ml-2">S/D</span>
                        <input type="date" class="form-control" name="tgl2" id="tgl2" value="{{ date('Y-m-d') }}">
                    </div>
                    <div class="text-right">
                        <a href="#" class="btn btn-success" id="btn-cetak">
                            <i class="fa fa-print mr-2"></i>
                            <span>Cetak</span>
                        </a>
                    </div>
                </div>
                <hr>
                <table id="table-data" class="display w-100 table table-bordered">
                    <thead>
                    <tr>
                        <th width="5%" class="text-center">#</th>
                        <th width="15%">Tanggal</th>
                        <th>Nama Siswa</th>
                        <th width="15%">Kelas</th>
                        <th width="15%">Nominal</th>
                        <th width="10%"></th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <hr>
                <div class="text-right">
                    <span class="mr-2 font-weight-bold">Total Penerimaan : </span>
                    <span class="font-weight-bold" id="lbl-total">Rp. 0</span>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('/js/helper.js') }}"></script>
    <script>
        var table;
        var path = '/{{ request()->path() }}';

        function reload() {
            table.ajax.reload();
        }

        $(document).ready(function () {
            table = DataTableGenerator('#table-data', path, [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false, orderable: false},
                {data: 'tanggal'},
                {data: 'pos_kelas_siswa.siswa.nama'},
                {data: 'pos_kelas_siswa.kelas.nama'},
                {
                    data: 'nominal', name: 'nominal', render: function (data) {
                        return 'Rp. ' + data.toLocaleString('id-ID');
                    }
                },
                {
                    data: null, render: function (data) {
                        let urlPrint = '/laporan-penerimaan/' + data['id'] + '/cetak';
                        return '<a href="' + urlPrint + '" target="_blank" class="btn btn-success mr-1"><i class="fa fa-print"></i></a><a href="#" class="btn btn-outline-success"><i class="fa fa-whatsapp"></i></a>';
                    }
                },
            ], [
                {
                    targets: [0, 1, 4],
                    className: 'text-center'
                },
            ], function (d) {
                d.tgl1 = $('#tgl1').val();
                d.tgl2 = $('#tgl2').val();
            }, {
                dom: 'ltipr',
                "fnDrawCallback": function (setting) {
                    let data = this.fnGetData();
                    let total = data.map(item => item['nominal']).reduce((prev, next) => prev + next, 0);
                    $('#lbl-total').html('Rp. ' + formatUang(total));
                }
            });

            $('#tgl1').on('change', function (e) {
                reload();
            });
            $('#tgl2').on('change', function (e) {
                reload();
            });

            $('#btn-cetak').on('click', function (e) {
                e.preventDefault();
                let tgl1 = $('#tgl1').val();
                let tgl2 = $('#tgl2').val();
                window.open('/laporan-penerimaan/cetak?tgl1=' + tgl1 + '&tgl2=' + tgl2, '_blank');
            });
        });
    </script>
@endsection
