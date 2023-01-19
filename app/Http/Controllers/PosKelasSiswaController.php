<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\Kelas;
use App\Models\TahunAjaran;

class PosKelasSiswaController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $tahun_ajaran = TahunAjaran::where('aktif', '=', true)->first();
        $kelas = Kelas::all();
        return view('pos-kelas-siswa.index')->with([
            'tahun_ajaran' => $tahun_ajaran,
            'kelas' => $kelas,
        ]);
    }
}
