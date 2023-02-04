<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\TahunAjaran;

class LaporanPembayaranController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $tahun_ajaran = TahunAjaran::where('aktif', '=', true)->firstOrFail();
        return view('laporan-pembayaran.index')->with([
            'tahun_ajaran' => $tahun_ajaran
        ]);
    }
}
