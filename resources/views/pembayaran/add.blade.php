@extends('layout')

@section('css')
    <link href="{{ asset('/adminlte/plugins/select2/select2.css') }}" rel="stylesheet">
    <style>
        .select2-selection {
            height: 40px !important;
            line-height: 40px !important;
        }

        .select2-container--default .select2-selection--multiple {
            border: 1px solid #d2d6de;
            height: 54px !important;
            overflow-y: scroll;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            color: black !important;
        }
    </style>
@endsection

@section('content')
    @if (\Illuminate\Support\Facades\Session::has('failed'))
        <script>
            Swal.fire("Gagal!", '{{\Illuminate\Support\Facades\Session::get('failed')}}', "error")
        </script>
    @endif
    <div class="d-flex align-items-center justify-content-between mb-3">
        <p class="font-weight-bold mb-0" style="font-size: 20px">Halaman Pembayaran Siswa</p>
        <ol class="breadcrumb breadcrumb-transparent mb-0">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('pembayaran') }}">Pembayaran Siswa</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Pembayaran
            </li>
        </ol>
    </div>
    <div class="w-100 p-2">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12">
                <div class="card card-outline card-info">
                    <div class="card-header">
                        <p class="font-weight-bold mb-0">Pembayaran Siswa Tahun
                            Ajaran {{ $tahun_ajaran !== null ? $tahun_ajaran->periode : '-' }}</p>

                    </div>
                    <div class="card-body">
                        <form method="post" id="form-save">
                            @csrf
                            <div class="form-group w-100">
                                <label for="siswa">Siswa</label>
                                <select class="select2" name="siswa" id="siswa" style="width: 100%;">
                                    <option value="">--pilih siswa--</option>
                                    @foreach($siswa as $v)
                                        <option value="{{ $v->id }}">{{ $v->siswa->nama }} ({{ $v->siswa->nis }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group w-100">
                                <label for="per-bulan" class="form-label">Per Bulan</label>
                                <input type="number" class="form-control" id="per-bulan" placeholder="Per Bulan"
                                       name="per-bulan" readonly value="0">
                            </div>
                            <div class="w-100 mb-3">
                                <label for="bulan">Pembayaran Bulan</label>
                                <select class="select2" name="bulan[]" id="bulan" multiple
                                        style="width: 100%; height: 100px;">
                                    <option value="">--pilih siswa--</option>
                                    @foreach($bulan as $v)
                                        <option value="{{ $v['index'] }}">{{ $v['nama'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <hr>
                            <div class="row text-right">
                                <div class="col-9"><p class="font-weight-bold mb-0">Total : Rp. </p></div>
                                <div class="col-3"><p class="font-weight-bold mb-0"><span id="total-bayar">0</span></p>
                                </div>
                            </div>
                            <hr>
                            <div class="text-right">
                                <a href="#" id="btn-save" class="btn btn-primary"><i
                                        class="fa fa-save mr-1"></i><span
                                        class="font-weight-bold">Simpan</span></a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            {{--            <div class="col-sm-12 col-md-7 col-lg-7">--}}
            {{--                <div class="card card-outline card-info">--}}
            {{--                    <div class="card-header">--}}
            {{--                        <p class="font-weight-bold mb-0">Pos Pembayaran</p>--}}
            {{--                    </div>--}}
            {{--                    <div class="card-body">--}}
            {{--                        <table id="table-data" class="display w-100 table table-bordered mb-3">--}}
            {{--                            <thead>--}}
            {{--                            <tr>--}}
            {{--                                <th width="10%" class="text-center">#</th>--}}
            {{--                                <th>Jenis Pembayaran</th>--}}
            {{--                                <th width="25%">Nominal</th>--}}
            {{--                            </tr>--}}
            {{--                            </thead>--}}
            {{--                            <tbody>--}}
            {{--                            </tbody>--}}
            {{--                        </table>--}}
            {{--                        <hr>--}}
            {{--                        <div class="text-right pr-2">--}}
            {{--                            <div class="row">--}}
            {{--                                <div class="col-9"><p class="font-weight-bold mb-0">Total : Rp. </p></div>--}}
            {{--                                <div class="col-3"><p class="font-weight-bold mb-0"><span id="total">0</span></p></div>--}}
            {{--                            </div>--}}
            {{--                            <div class="row">--}}
            {{--                                <div class="col-9"><p class="font-weight-bold mb-0">Terbayar : Rp. </p></div>--}}
            {{--                                <div class="col-3"><p class="font-weight-bold mb-0"><span id="pembayaran">0</span></p>--}}
            {{--                                </div>--}}
            {{--                            </div>--}}
            {{--                            <div class="row">--}}
            {{--                                <div class="col-9"><p class="font-weight-bold mb-0">Kekurangan : Rp. </p></div>--}}
            {{--                                <div class="col-3"><p class="font-weight-bold mb-0"><span id="kekurangan">0</span></p>--}}
            {{--                                </div>--}}
            {{--                            </div>--}}

            {{--                        </div>--}}
            {{--                    </div>--}}
            {{--                </div>--}}
            {{--            </div>--}}
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('/adminlte/plugins/select2/select2.js') }}"></script>
    <script src="{{ asset('/adminlte/plugins/select2/select2.full.js') }}"></script>
    <script src="{{ asset('/js/helper.js') }}"></script>
    <script>
        var table;
        var path = '/{{ request()->path() }}';
        var arrBulan = [
            {
                index: 6,
                nama: 'Juli'
            }, {
                index: 7,
                nama: 'Agustus'
            }, {
                index: 8,
                nama: 'September'
            }, {
                index: 9,
                nama: 'Oktober'
            }, {
                index: 10,
                nama: 'November'
            }, {
                index: 11,
                nama: 'Desember'
            },
            {
                index: 0,
                nama: 'Januari'
            }, {
                index: 1,
                nama: 'Februari'
            }, {
                index: 2,
                nama: 'Maret'
            }, {
                index: 3,
                nama: 'April'
            }, {
                index: 4,
                nama: 'Mei'
            }, {
                index: 5,
                nama: 'Juni'
            },
        ];

        function reload() {
            table.ajax.reload();
        }

        async function getTotalPembayaranSiswa() {
            try {
                let elBulan = $('#bulan');
                let siswa = $('#siswa').val();
                let response = await $.get('/pembayaran/total-pembayaran-siswa?siswa=' + siswa);
                elBulan.empty();
                console.log(response);
                if (response['status'] === 200) {
                    let total = response['payload']['total'].toLocaleString('id-ID');
                    let pembayaran = response['payload']['pembayaran'].toLocaleString('id-ID');
                    let kekurangan = response['payload']['kekurangan'].toLocaleString('id-ID');
                    let bulanPembayaran = response['payload']['bulan_pembayaran'];
                    let perBulan = response['payload']['per_bulan'];
                    $.each(arrBulan, function (k, v) {
                        let include = !!bulanPembayaran.includes(v['index']);
                        let el = '<option value="' + v['index'] + '">' + v['nama'] + '</option>';
                        if (include) {
                            el = '<option value="' + v['index'] + '" disabled>' + v['nama'] + '</option>';
                        }
                        elBulan.append(el);
                    });
                    $('.select2').select2({
                        width: 'resolve'
                    });
                    $('#per-bulan').val(perBulan);
                    // $('#total').html(total);
                    // $('#pembayaran').html(pembayaran);
                    // $('#kekurangan').html(kekurangan);
                } else {
                    $('#per-bulan').val(0);
                    // $('#total').html(0);
                    // $('#pembayaran').html(0);
                    // $('#kekurangan').html(0);
                }
            } catch (e) {
                $('#per-bulan').val(0);
                // $('#total').html(0);
                // $('#pembayaran').html(0);
                // $('#kekurangan').html(0);
                let error_message = JSON.parse(e.responseText);
                ErrorAlert('Error', error_message.message);
            } finally {
                totalBayar();
            }
        }

        function totalBayar() {
            let perBulan = parseInt($('#per-bulan').val());
            let bulan = $('#bulan').val().length;
            let totalBayar = perBulan * bulan;
            $('#total-bayar').html(totalBayar.toLocaleString('id-ID'));
        }

        $(document).ready(function () {
            $('.select2').select2({
                width: 'resolve'
            });
            table = DataTableGenerator('#table-data', path, [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false, orderable: false},
                {data: 'jenis_pembayaran.nama'},
                {
                    data: 'nominal', name: 'nominal', render: function (data) {
                        return 'Rp. ' + data.toLocaleString('id-ID');
                    }
                },

            ], [
                {
                    targets: [0, 2],
                    className: 'text-center'
                },
            ], function (d) {
                d.siswa = $('#siswa').val();
            }, {
                "fnDrawCallback": function (setting) {
                },
                dom: 't'
            });

            $('#siswa').on('change', function () {
                getTotalPembayaranSiswa();
                reload();
            });

            $('#btn-save').on('click', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: "Konfirmasi!",
                    text: "Apakah anda yakin menyimpan data?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Batal',
                }).then((result) => {
                    if (result.value) {
                        $('#form-save').submit();
                    }
                });
            });
            getTotalPembayaranSiswa();
            $('#bulan').on('change', function () {
                totalBayar();
            });
        });
    </script>
@endsection
