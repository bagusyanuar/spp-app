@extends('layout')

@section('css')
@endsection

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-3">
        <p class="font-weight-bold mb-0" style="font-size: 20px">Halaman Siswa</p>
        <ol class="breadcrumb breadcrumb-transparent mb-0">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Siswa
            </li>
        </ol>
    </div>
    <div class="w-100 p-2">
        <div class="card card-outline card-info">
            <div class="card-header">
                <div class="mb-2">
                    <a href="{{ route('siswa.store') }}" class="btn btn-primary"><i
                            class="fa fa-plus mr-1"></i><span
                            class="">Tambah</span></a>
                    <a href="#" class="btn btn-success"><i
                            class="fa fa-print mr-1"></i><span
                            class="">Cetak</span></a>
                </div>
            </div>
            <div class="card-body">
                <table id="table-data" class="display w-100 table table-bordered">
                    <thead>
                    <tr>
                        <th width="5%" class="text-center"></th>
                        <th width="5%" class="text-center">#</th>
                        <th width="15%">NIS</th>
                        <th>Nama</th>
                        <th width="10%">Kelas</th>
                        <th width="10%" class="text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection

@section('js')
    <script src="{{ asset('/js/helper.js') }}"></script>
    <script>
        var table;

        function destroy(id) {
            let url = '{{ route('tahun-ajaran') }}' + '/' + id + '/delete';
            AjaxPost(url, {}, function () {
                clear();
                SuccessAlert('Berhasil!', 'Berhasil menghapus data...');
                reload();
            });
        }

        function reload() {
            table.ajax.reload();
            setExpand();
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

        function detailElement(d) {
            return '<div class="f14">' +
                '<p class="font-weight-bold">Detail Informasi Siswa</p>' +
                '<div class="row mb-0">' +
                '<div class="col-lg-3 col-md-4 col-sm-6">' +
                '<p class="mb-0">No. Handphone</p>' +
                '</div>' +
                '<div class="col-lg-9 col-md-8 col-sm-6">: +62' + d['no_hp'] + '</div>' +
                '</div>' +
                '<div class="row mb-0">' +
                '<div class="col-lg-3 col-md-4 col-sm-6">' +
                '<p class="mb-0">Jenis Kelamin</p>' +
                '</div>' +
                '<div class="col-lg-9 col-md-8 col-sm-6">: ' + d['jenis_kelamin'] + '</div>' +
                '</div>' +
                '<div class="row">' +
                '<div class="col-lg-3 col-md-4 col-sm-6">' +
                '<p class="mb-0">Alamat</p>' +
                '</div>' +
                '<div class="col-lg-9 col-md-8 col-sm-6">: ' + d['alamat'] + '</div>' +
                '</div>' +
                '<div class="row">' +
                '<div class="col-lg-3 col-md-4 col-sm-6">' +
                '<p class="mb-0">Tempat, Tanggal Lahir</p>' +
                '</div>' +
                '<div class="col-lg-9 col-md-8 col-sm-6">: ' + d['tempat_lahir'] + ', '+d['tanggal_lahir']+'</div>' +
                '</div>' +
                '<div class="row">' +
                '<div class="col-lg-3 col-md-4 col-sm-6">' +
                '<p class="mb-0">Ibu Kandung</p>' +
                '</div>' +
                '<div class="col-lg-9 col-md-8 col-sm-6">: ' + d['ibu'] + '</div>' +
                '</div>' +
                '<div class="row">' +
                '<div class="col-lg-3 col-md-4 col-sm-6">' +
                '<p class="mb-0">Ayah Kandung</p>' +
                '</div>' +
                '<div class="col-lg-9 col-md-8 col-sm-6">: ' + d['ayah'] + '</div>' +
                '</div>' +
                '<div class="row">' +
                '<div class="col-lg-3 col-md-4 col-sm-6">' +
                '<p class="mb-0">No. Handphone Ortu</p>' +
                '</div>' +
                '<div class="col-lg-9 col-md-8 col-sm-6">: +62' + d['no_hp_ortu'] + '</div>' +
                '</div>' +
                '</div>';
        }
        function setExpand() {
            $('#table-data tbody').on('click', 'td.dt-control', function () {
                var tr = $(this).closest('tr');
                var row = table.row(tr);
                var i = $(this).children();

                if (row.child.isShown()) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('shown');
                    i.removeClass('fa fa-minus-square-o');
                    i.addClass('fa fa-plus-square-o');
                } else {
                    row.child(detailElement(row.data())).show();
                    tr.addClass('shown');
                    i.removeClass('fa fa-plus-square-o');
                    i.addClass('fa fa-minus-square-o');
                }
            });
        }
        $(document).ready(function () {
            table = DataTableGenerator('#table-data', '/siswa', [
                {
                    className: 'dt-control text-center',
                    searchable: false, orderable: false,
                    data: null, render: function () {
                        return '<i class="fa fa-plus-square-o main-text expand-icon"></i>';
                    }
                },
                {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false, orderable: false},
                {data: 'nis', orderable: true, className: 'text-center'},
                {data: 'nama'},
                {data: 'kelas.nama', className: 'text-center'},
                {
                    className: 'text-center',
                    searchable: false, orderable: false,
                    data: null, render: function (data) {
                        return '<a href="#" class="btn btn-sm btn-warning btn-edit" data-id="' + data['id'] + '"><i class="fa fa-edit f12"></i></a>' +
                            '<a href="#" class="btn btn-sm btn-danger btn-delete" data-id="' + data['id'] + '"><i class="fa fa-trash f12"></i></a>';
                    }
                },
            ], [

            ], function (d) {
            }, {
                "fnDrawCallback": function (setting) {
                    setExpand();
                    deleteEvent();
                }
            });
            deleteEvent();
            setExpand();
        });
    </script>
@endsection
