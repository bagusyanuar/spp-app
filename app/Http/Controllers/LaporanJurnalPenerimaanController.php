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
            $data = Pembayaran::with(['pos_kelas_siswa.siswa', 'pos_kelas_siswa.kelas'])
                ->whereBetween('tanggal', [$tgl1, $tgl2])
                ->orderBy('tanggal', 'ASC')
                ->get();
            return $this->basicDataTables($data);
        }
        return view('laporan-penerimaan.index')->with([
            'tahun_ajaran' => $tahun_ajaran
        ]);
    }

    public function cetak()
    {
        $tgl1 = $this->field('tgl1');
        $tgl2 = $this->field('tgl2');
        $data = Pembayaran::with(['pos_kelas_siswa.siswa', 'pos_kelas_siswa.kelas'])
            ->whereBetween('tanggal', [$tgl1, $tgl2])
            ->orderBy('tanggal', 'ASC')
            ->get();
        return $this->convertToPdf('cetak.jurnal-penerimaan', ['data' => $data, 'tgl1' => $tgl1, 'tgl2' => $tgl2]);
    }

    public function cetakDetail($id)
    {
        $data = Pembayaran::with(['pos_kelas_siswa.siswa', 'pos_kelas_siswa.kelas', 'details'])
            ->where('id', '=', $id)
            ->firstOrFail();
        $html = view('cetak.nota')->with(['data' => $data]);
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($html)->setPaper('a5', 'landscape');
        return $pdf->stream();
    }
}
