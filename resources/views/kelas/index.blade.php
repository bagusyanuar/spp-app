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
            <div class="card-body">
                <div class="text-right mb-2">
                    <a href="#" class="btn btn-primary"><i class="fa fa-plus mr-1"></i><span
                            class="font-weight-bold">Tambah</span></a>
                </div>
                <table id="table-data" class="display w-100 table table-bordered">
                    <thead>
                    <tr>
                        <th width="5%" class="text-center">#</th>
                        <th>Nama Kelas</th>
                        <th width="10%" class="text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    {{--            @foreach($data as $v)--}}
                    {{--                <tr>--}}
                    {{--                    <td width="5%" class="text-center">{{ $loop->index + 1 }}</td>--}}
                    {{--                    <td width="20%">{{ $v->jurusan->nama }}</td>--}}
                    {{--                    <td>{{ $v->nama }}</td>--}}
                    {{--                    <td class="text-center">--}}
                    {{--                        <a href="{{ route('kelas.edit', ['id' => $v->id]) }}" class="btn btn-sm btn-warning btn-edit"--}}
                    {{--                           data-id="{{ $v->id }}"><i class="fa fa-edit"></i></a>--}}
                    {{--                        <a href="#" class="btn btn-sm btn-danger btn-delete" data-id="{{ $v->id }}"><i--}}
                    {{--                                class="fa fa-trash"></i></a>--}}
                    {{--                    </td>--}}
                    {{--                </tr>--}}
                    {{--            @endforeach--}}
                    </tbody>
                </table>
            </div>
        </div>

    </div>

@endsection

@section('js')
    <script>
        $(document).ready(function () {
            $('#table-data').DataTable({
                "fnDrawCallback": function (setting) {
                }
            });
        });
    </script>
@endsection
