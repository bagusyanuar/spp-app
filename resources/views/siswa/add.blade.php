@extends('layout')

@section('css')
@endsection

@section('content')
    @if (\Illuminate\Support\Facades\Session::has('success'))
        <script>
            Swal.fire("Berhasil!", '{{\Illuminate\Support\Facades\Session::get('success')}}', "success")
        </script>
    @endif

    @if (\Illuminate\Support\Facades\Session::has('failed'))
        <script>
            Swal.fire("Gagal", '{{\Illuminate\Support\Facades\Session::get('failed')}}', "error")
        </script>
    @endif
    <div class="d-flex align-items-center justify-content-between mb-3">
        <p class="font-weight-bold mb-0" style="font-size: 20px">Halaman Tambah Siswa</p>
        <ol class="breadcrumb breadcrumb-transparent mb-0">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('siswa') }}">Siswa</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Tambah Siswa
            </li>
        </ol>
    </div>
    <div class="w-100 p-2">
        <div class="row">
            <div class="col-lg-9 col-md-8 col-sm-12">
                <div class="card card-outline card-info">
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab"
                                   aria-controls="home" aria-selected="true">Data Pribadi</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                                   aria-controls="profile" aria-selected="false">Data Sekolah</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab"
                                   aria-controls="contact" aria-selected="false">Data Keluarga</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active pt-2" id="home" role="tabpanel"
                                 aria-labelledby="home-tab">
                                <form method="post" id="form-input">
                                    @csrf

                                    <div class="w-100 mb-2">
                                        <label for="nama" class="form-label">Nama Lengkap *</label>
                                        <input type="text" class="form-control" id="nama" placeholder="Nama Lengkap"
                                               name="nama">
                                    </div>
                                    <div class="w-100 mb-2">
                                        <label class="form-label">Jenis Kelamin</label>
                                        <div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="jenis_kelamin"
                                                       id="jenis_kelamin_pria" value="laki-laki" checked>
                                                <label class="form-check-label" for="jenis_kelamin_pria">Laki -
                                                    Laki</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="jenis_kelamin"
                                                       id="jenis_kelamin_wanita" value="perempuan">
                                                <label class="form-check-label"
                                                       for="jenis_kelamin_wanita">Perempuan</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="w-100 mb-2">
                                        <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                                        <input type="text" class="form-control" id="tempat_lahir"
                                               placeholder="Tempat Lahir"
                                               name="tempat_lahir">
                                    </div>
                                    <div class="w-100 mb-2">
                                        <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                        <input type="date" class="form-control" id="tanggal_lahir"
                                               placeholder="Tanggal Lahir"
                                               name="tanggal_lahir" value="{{ date('Y-m-d') }}">
                                    </div>
                                    <div class="w-100 mb-2">
                                        <label for="no_hp" class="form-label">No. Handphone</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="inputGroupPrepend">+62</span>
                                            </div>
                                            <input type="number" class="form-control" id="no_hp"
                                                   name="no_hp" aria-describedby="inputGroupPrepend">
                                        </div>
                                    </div>
                                    <div class="w-100 mb-2">
                                        <label for="alamat" class="form-label">Alamat</label>
                                        <textarea rows="3" class="form-control" id="alamat"
                                                  name="alamat"></textarea>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade pt-2" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                <div class="w-100 mb-2">
                                    <label for="nis" class="form-label">NIS</label>
                                    <input type="text" class="form-control" id="nis" placeholder="NIS"
                                           name="nis" form="form-input">
                                </div>
                                <div class="w-100 mb-2">
                                    <label for="kelas">Kelas</label>
                                    <select id="kelas" class="form-control" name="kelas" form="form-input">
                                        @foreach($kelas as $v)
                                            <option value="{{ $v->id }}">{{ $v->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="tab-pane fade pt-2" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                                <div class="w-100 mb-2">
                                    <label for="ibu" class="form-label">Nama Ibu Kandung</label>
                                    <input type="text" class="form-control" id="ibu" placeholder="Nama Ibu Kandung"
                                           name="ibu" form="form-input">
                                </div>
                                <div class="w-100 mb-2">
                                    <label for="ayah" class="form-label">Nama Ayah Kandung</label>
                                    <input type="text" class="form-control" id="ayah" placeholder="Nama Ayah Kandung"
                                           name="ayah" form="form-input">
                                </div>
                                <div class="w-100 mb-2">
                                    <label for="no_hp_ortu" class="form-label">No. Handphone Orang Tua *</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="inputGroupPrepend2">+62</span>
                                        </div>
                                        <input type="number" class="form-control" id="no_hp_ortu"
                                               name="no_hp_ortu" aria-describedby="inputGroupPrepend2"
                                               form="form-input">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-12">
                <div class="card card-outline card-info">
                    <div class="card-body">
                        <label class="form-label">Status</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="status_aktif" value="1"
                                   checked form="form-input">
                            <label class="form-check-label" for="status_aktif">
                                Aktif
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="status_non_aktif" value="0" form="form-input">
                            <label class="form-check-label" for="status_non_aktif">
                                Tidak Aktif
                            </label>
                        </div>
                        <hr>
                        <button type="submit" id="btn-save" form="form-input" class="btn btn-success w-100"><i
                                class="fa fa-send mr-2"></i>Simpan
                        </button>
                    </div>
                </div>
            </div>
        </div>


    </div>
@endsection

@section('js')
    <script src="{{ asset('/js/helper.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#btn-save').on('click',  function (e) {
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
                        $('#form-input').submit();
                    }
                });
            })
        });
    </script>
@endsection
