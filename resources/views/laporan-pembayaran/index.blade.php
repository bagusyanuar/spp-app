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
                        <p class="font-weight-bold">Pembayaran Siswa Tahun
                            Ajaran {{ $tahun_ajaran !== null ? $tahun_ajaran->periode : '-' }}</p>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="text-right">
                        <a href="#" class="btn btn-success" id="btn-cetak">
                            <i class="fa fa-print mr-2"></i>
                            <span>Cetak</span>
                        </a>
                    </div>
                </div>
                <hr>
                <table id="table-data" class="display table table-bordered no-wrap" style="width: 1500px">
                    <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th >NIS</th>
                        <th >Nama Siswa</th>
                        <th >Juni</th>
                        <th >Juli</th>
                        <th >Agustus</th>
                        <th >September</th>
                        <th >Oktober</th>
                        <th >November</th>
                        <th >Desember</th>
                        <th >Januari</th>
                        <th >Februari</th>
                        <th >Maret</th>
                        <th >April</th>
                        <th >Mei</th>
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
    <script src="https://cdn.datatables.net/fixedcolumns/4.2.1/js/dataTables.fixedColumns.min.js"></script>
    <script>
        var table;
        var path = '/{{ request()->path() }}';
        function reload() {
            table.ajax.reload();
        }
        $(document).ready(function () {
            table = $('#table-data').removeAttr('width').DataTable({
                scrollX:        true,
                scrollCollapse: true,
                paging:         true,
                columnDefs: [
                    { "width": "400px", "targets": [1] },
                    { "width": "400px", "targets": [2] },
                    { "width": "80px", "targets": [3, 4, 5, 6, 7, 8, 9] },
                ]
            });
            // table = DataTableGenerator('#table-data',path, [
            //     {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false, orderable: false},
            //     {data: 'tanggal'},
            //     {data: 'siswa.nama'},
            //     {data: 'kelas.nama'},
            //     {
            //         data: 'nominal', name: 'nominal', render: function (data) {
            //             return 'Rp. ' + data.toLocaleString('id-ID');
            //         }
            //     },
            // ], [
            //     {
            //         targets: [0, 1, 4],
            //         className: 'text-center'
            //     },
            // ], function (d) {
            //     d.tgl1 = $('#tgl1').val();
            //     d.tgl2 = $('#tgl2').val();
            // }, {
            //     dom: 'ltipr',
            //     "fnDrawCallback": function (setting) {
            //         let data = this.fnGetData();
            //         let total = data.map(item => item['nominal']).reduce((prev, next) => prev + next, 0);
            //         $('#lbl-total').html('Rp. '+formatUang(total));
            //     }
            // });

            $('#tgl1').on('change', function (e) {
                reload();
            });
            $('#tgl2').on('change', function (e) {
                reload();
            });
        });
    </script>
@endsection
