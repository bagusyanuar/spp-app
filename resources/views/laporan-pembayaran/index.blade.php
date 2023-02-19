@extends('layout')

@section('css')
@endsection

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-3">
        <p class="font-weight-bold mb-0" style="font-size: 20px">Halaman Laporan Pembayaran</p>
        <ol class="breadcrumb breadcrumb-transparent mb-0">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Laporan Pembayaran
            </li>
        </ol>
    </div>
    <div class="w-100 p-2">
        <div class="card card-outline card-info">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div>
                        <p class="font-weight-bold">Laporan Pembayaran Siswa Tahun
                            Ajaran {{ $tahun_ajaran !== null ? $tahun_ajaran->periode : '-' }}</p>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-end mb-3">
                    <div class="w-25">
                        <label for="kelas">Kelas</label>
                        <select id="kelas" class="form-control" name="kelas" form="form-input">
                            @foreach($kelas as $v)
                                <option value="{{ $v->id }}">{{ $v->nama }}</option>
                            @endforeach
                        </select>
                    </div>
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
                        <th>NIS</th>
                        <th>Nama Siswa</th>
                        <th>Juli</th>
                        <th>Agustus</th>
                        <th>September</th>
                        <th>Oktober</th>
                        <th>November</th>
                        <th>Desember</th>
                        <th>Januari</th>
                        <th>Februari</th>
                        <th>Maret</th>
                        <th>April</th>
                        <th>Mei</th>
                        <th>Juni</th>
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
                scrollX: true,
                scrollCollapse: true,
                paging: true,
                ajax: {
                    type: 'GET',
                    url: '/laporan-pembayaran/data',
                    'data': function (d) {
                        d.kelas = $('#kelas').val()
                    }
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false, orderable: false},
                    {data: 'nis'},
                    {data: 'nama'},
                    {
                        data: null, render: function (data) {
                            //juli
                            return data['bulan'][6]['value'];
                        }
                    },
                    {
                        data: null, render: function (data) {
                            //agustus
                            return data['bulan'][7]['value'];
                        }
                    },
                    {
                        data: null, render: function (data) {
                            //september
                            return data['bulan'][8]['value'];
                        }
                    },
                    {
                        data: null, render: function (data) {
                            //oktober
                            return data['bulan'][9]['value'];
                        }
                    },
                    {
                        data: null, render: function (data) {
                            //november
                            return data['bulan'][10]['value'];
                        }
                    }, {
                        data: null, render: function (data) {
                            //desember
                            return data['bulan'][11]['value'];
                        }
                    }, {
                        data: null, render: function (data) {
                            //januari
                            return data['bulan'][0]['value'];
                        }
                    }, {
                        data: null, render: function (data) {
                            //februari
                            return data['bulan'][1]['value'];
                        }
                    }, {
                        data: null, render: function (data) {
                            //maret
                            return data['bulan'][2]['value'];
                        }
                    }, {
                        data: null, render: function (data) {
                            //april
                            return data['bulan'][3]['value'];
                        }
                    }, {
                        data: null, render: function (data) {
                            //mei
                            return data['bulan'][4]['value'];
                        }
                    },
                    {
                        data: null, render: function (data) {
                            //juni
                            return data['bulan'][5]['value'];
                        }
                    },
                ],
                columnDefs: [
                    {"width": "150px", "targets": [1]},
                    {"width": "300px", "targets": [2]},
                    {"width": "80px", "targets": [3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14]},
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

            $('#kelas').on('change', function (e) {
                reload();
            });
            // $('#tgl2').on('change', function (e) {
            //     reload();
            // });

            $('#btn-cetak').on('click', function (e) {
                e.preventDefault();
                let kelas = $('#kelas').val();
                window.open('/laporan-pembayaran/cetak?kelas=' + kelas, '_blank');
            });
        });
    </script>
@endsection
