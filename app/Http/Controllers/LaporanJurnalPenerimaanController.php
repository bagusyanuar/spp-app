<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\Pembayaran;
use App\Models\TahunAjaran;

class LaporanJurnalPenerimaanController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }


    public function index()
    {
        $tahun_ajaran = TahunAjaran::where('aktif', '=', true)->firstOrFail();
        if ($this->request->ajax()) {
            $tgl1 = $this->field('tgl1');
            $tgl2 = $this->field('tgl2');
            $data = Pembayaran::with(['siswa', 'kelas'])
                ->whereBetween('tanggal', [$tgl1, $tgl2])
                ->orderBy('tanggal', 'ASC')
                ->get();
            return $this->basicDataTables($data);
        }
        return view('laporan-penerimaan.index')->with([
            'tahun_ajaran' => $tahun_ajaran
        ]);
    }
}
