<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\Kelas;
use App\Models\Pembayaran;
use App\Models\PosKelasSiswa;
use App\Models\PosPembayaran;
use App\Models\TahunAjaran;
use Illuminate\Support\Facades\DB;

class LaporanPembayaranController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $tahun_ajaran = TahunAjaran::where('aktif', '=', true)->firstOrFail();
        $kelas = Kelas::all();
        return view('laporan-pembayaran.index')->with([
            'tahun_ajaran' => $tahun_ajaran,
            'kelas' => $kelas,
        ]);
    }

    public function getData()
    {
        $tahun_ajaran = TahunAjaran::where('aktif', '=', true)->firstOrFail();
        $kelas = $this->field('kelas');
        $data_siswa = PosKelasSiswa::with(['siswa', 'kelas'])
            ->where('kelas_id', '=', $kelas)
            ->where('tahun_ajaran_id', '=', $tahun_ajaran->id)
            ->get();

        $total_pembayaran_kelas = PosPembayaran::with([])->where('tahun_ajaran_id', '=', $tahun_ajaran->id)
            ->where('kelas_id', '=', $kelas)
            ->get()
            ->sum('nominal');

        $per_bulan = round($total_pembayaran_kelas / 12, 0, PHP_ROUND_HALF_UP);
        $results = [];
        foreach ($data_siswa as $pos_siswa) {
            $tmp['id'] = $pos_siswa->id;
            $tmp['nama'] = $pos_siswa->siswa->nama;
            $tmp['nis'] = $pos_siswa->siswa->nis;
            $tmp['per_bulan'] = $per_bulan;
            $membayar = Pembayaran::with([])->where('siswa_id', $pos_siswa->siswa->id)
                ->where('kelas_id', '=', $kelas)
                ->where('tahun_ajaran_id', '=', $tahun_ajaran->id)
                ->get()->sum('nominal');
            $tmp['membayar'] = $membayar;
            $mod = fmod($membayar, $per_bulan);
            $tmp['mod'] = $mod;
            array_push($results, $tmp);
        }
        return $this->basicDataTables($results);
    }

    private function splitter($membayar, $per_bulan)
    {
        $result = [];
        $iTotal = 12;
        $mod = fmod($membayar, $per_bulan);
        for ($i = 0; $i < 12; $i++) {
            array_push($result, 0);
        }
        return $result;
    }
}
