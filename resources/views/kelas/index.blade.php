@extends('layout')

@section('css')
@endsection

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-3">
        <p class="font-weight-bold mb-0" style="font-size: 20px">Halaman Kelas</p>
        <ol class="breadcrumb breadcrumb-transparent mb-0">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Kelas
            </li>
        </ol>
    </div>
    <div class="w-100 p-2">
        <div class="card card-outline card-info">
            <div class="card-header">
                <div class="text-right mb-2">
                    <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal"><i
                            class="fa fa-plus mr-1"></i><span
                            class="font-weight-bold">Tambah</span></a>
                </div>
            </div>
            <div class="card-body">
                <table id="table-data" class="display w-100 table table-bordered">
                    <thead>
                    <tr>
                        <th width="5%" class="text-center">#</th>
                        <th>Nama Kelas</th>
                        <th width="10%" class="text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Kelas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="w-100 mb-1">
                        <label for="nama" class="form-label">Nama Kelas</label>
                        <input type="text" class="form-control" id="nama" placeholder="Nama Kelas"
                               name="nama">
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
            $('#nama').val('');
        }

        function store() {
            let url = '{{ route('kelas') }}';
            let data = {
                name: $('#nama').val()
            };
            AjaxPost(url, data, function () {
                clear();
                SuccessAlert('Berhasil!', 'Berhasil menyimpan data...');
                reload();
            });
        }

        function reload() {
            table.ajax.reload();
        }

        function editEvent() {
            $('.btn-edit').on('click', function (e) {
                e.preventDefault();
                let id = this.dataset.id;
                let name = this.dataset.name;
                $('#nama').val(name);
                $('#exampleModal').modal('show');
            })
        }

        function deleteEvent() {
            $('.btn-delete').on('click', function (e) {
                e.preventDefault();
                let id = this.dataset.id;
            })
        }

        $(document).ready(function () {
            table = DataTableGenerator('#table-data', '/kelas', [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false, orderable: false},
                {data: 'nama'},
                {
                    data: null, render: function (data) {
                        return '<a href="#" class="btn btn-sm btn-warning btn-edit" data-id="' + data['id'] + '" data-name="' + data['nama'] + '"><i class="fa fa-edit f12"></i></a>' +
                            '<a href="#" class="btn btn-sm btn-danger btn-delete" data-id="' + data['id'] + '"><i class="fa fa-trash f12"></i></a>';
                    }
                },
            ], [
                {
                    targets: [0, 2],
                    className: 'text-center'
                },
            ], function (d) {
            }, {
                "fnDrawCallback": function (setting) {
                    editEvent();
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

            $('#exampleModal').on('hidden.bs.modal', function (e) {
                clear();
            })
        });
    </script>
@endsection
