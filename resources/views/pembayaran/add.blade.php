@extends('layout')

@section('css')
@endsection

@section('content')
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
                <hr>
                <hr>
            </div>
        </div>

    </div>
@endsection

@section('js')
    <script src="{{ asset('/js/helper.js') }}"></script>
@endsection
