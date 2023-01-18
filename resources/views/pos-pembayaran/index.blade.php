@extends('layout')

@section('css')
@endsection

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-3">
        <p class="font-weight-bold mb-0" style="font-size: 20px">Halaman Pos Pembayaran</p>
        <ol class="breadcrumb breadcrumb-transparent mb-0">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Pos Pembayaran
            </li>
        </ol>
    </div>
    <div class="w-100 p-2">
        <div class="card card-outline card-info">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div>
                        <p class="font-weight-bold">Pos Pembayaran Siswa Tahun
                            Ajaran {{ $tahun_ajaran !== null ? $tahun_ajaran->periode : '-' }}</p>
                    </div>
                    <div class="text-right">
                        <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#modalAdd"><i
                                class="fa fa-plus mr-1"></i><span
                                class="font-weight-bold">Tambah</span></a>
                    </div>
                </div>

            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-3 col-md-4 col-sm-12">
                        <div class="w-100 mb-2">
                            <label for="kelas">Kelas</label>
                            <select id="kelas" class="form-control" name="kelas" form="form-input">
                                @foreach($kelas as $v)
                                    <option value="{{ $v->id }}">{{ $v->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <hr>
                <table id="table-data" class="display w-100 table table-bordered">
                    <thead>
                    <tr>
                        <th width="5%" class="text-center">#</th>
                        <th>Jenis Pembayaran</th>
                        <th width="15%">Nominal</th>
                        <th width="10%" class="text-center">Action</th>
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
    <div class="modal fade" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="modalAddLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAddLabel">Tambah Jenis Pembayaran</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="w-100 mb-2">
                        <label for="jenis_pembayaran">Jenis Pembayaran</label>
                        <select id="jenis_pembayaran" class="form-control" name="jenis_pembayaran" form="form-input">
                            @foreach($jenis_pembayaran as $v)
                                <option value="{{ $v->id }}">{{ $v->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="w-100 mb-1">
                        <label for="nominal" class="form-label">Nominal</label>
                        <input type="number" class="form-control" id="nominal" value="0"
                               name="nominal">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button id="btn-save" type="button" class="btn btn-primary"><i class="fa fa-save mr-2"></i>Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('/js/helper.js') }}"></script>
    <script>
        var table;

        function clear() {
            $('#nominal').val(0);
        }

        function store() {
            let url = '{{ route('pos-pembayaran') }}';
            let data = {
                kelas: $('#kelas').val(),
                jenis_pembayaran: $('#jenis_pembayaran').val(),
                nominal: $('#nominal').val(),
            };
            AjaxPost(url, data, function () {
                clear();
                SuccessAlert('Berhasil!', 'Berhasil menyimpan data...');
                reload();
                $('#modalAdd').modal('hide');
            });
        }

        function destroy(id) {
            let url = '{{ route('pos-pembayaran') }}' + '/' + id + '/delete';
            AjaxPost(url, {}, function () {
                clear();
                SuccessAlert('Berhasil!', 'Berhasil menghapus data...');
                reload();
            });
        }

        function reload() {
            table.ajax.reload();
        }


        function deleteEvent() {
            $('.btn-delete').on('click', function (e) {
                e.preventDefault();
                let id = this.dataset.id;
                Swal.fire({
                    title: "Konfirmasi!",
                    text: "Apakah anda yakin menghapus data?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Batal',
                }).then((result) => {
                    if (result.value) {
                        destroy(id);
                    }
                });

            })
        }

        $(document).ready(function () {
            table = DataTableGenerator('#table-data', '/pos-pembayaran', [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false, orderable: false},
                {data: 'jenis_pembayaran.nama'},
                {
                    data: 'nominal', name: 'nominal', render: function (data) {
                        return 'Rp. ' + data.toLocaleString('id-ID');
                    }
                },
                {
                    data: null, render: function (data) {
                        return '<a href="#" class="btn btn-sm btn-danger btn-delete" data-id="' + data['id'] + '"><i class="fa fa-trash f12"></i></a>';
                    }
                },
            ], [
                {
                    targets: [0, 2, 3],
                    className: 'text-center'
                },
            ], function (d) {
                d.kelas = $('#kelas').val();
            }, {
                "fnDrawCallback": function (setting) {
                    let data = this.fnGetData();
                    let total = data.map(item => item['nominal']).reduce((prev, next) => prev + next, 0);
                    $('#total').html(total.toLocaleString('id-ID'));
                    deleteEvent();
                }
            });

            $('#btn-save').on('click', function () {
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
                        store();
                    }
                });
            });
            deleteEvent();

            $('#modalAdd').on('hidden.bs.modal', function (e) {
                clear();
            });

            $('#kelas').on('change', function () {
                reload();
            })
        });
    </script>
@endsection
