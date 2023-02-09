@extends('layout')

@section('css')
@endsection

@section('content')
    @if (\Illuminate\Support\Facades\Session::has('success'))
        <script>
            Swal.fire("Berhasil!", '{{\Illuminate\Support\Facades\Session::get('success')}}', "success")
        </script>
    @endif
    <div class="d-flex align-items-center justify-content-between mb-3">
        <p class="font-weight-bold mb-0" style="font-size: 20px">Halaman Pembayaran Siswa</p>
        <ol class="breadcrumb breadcrumb-transparent mb-0">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Pembayaran Siswa
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
                    <div class="text-right">
                        <a href="{{ route('pembayaran.add') }}" class="btn btn-primary"><i
                                class="fa fa-credit-card mr-1"></i><span
                                class="font-weight-bold">Pembayaran</span></a>
                    </div>
                </div>

            </div>
            <div class="card-body">
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
                    <p class="font-weight-bold">Total Pembayaran : Rp. <span id="total">0</span></p>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('js')
    <script src="{{ asset('/js/helper.js') }}"></script>
    <script>
        var table;
        $(document).ready(function () {
            table = DataTableGenerator('#table-data', '/pembayaran', [
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
                    data: null,  render: function (data) {
                        return '<a href="#" class="btn btn-success"><i class="fa fa-print"></i></a>';
                    }
                },
            ], [
                {
                    targets: [0, 1, 4, 5],
                    className: 'text-center'
                },
            ], function (d) {
                d.kelas = $('#kelas').val();
            }, {
                "fnDrawCallback": function (setting) {

                }
            });
        });
    </script>
@endsection
