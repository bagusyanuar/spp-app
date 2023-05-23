<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\Kelas;
use App\Models\PosKelasSiswa;
use App\Models\Siswa;
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

        if ($this->request->ajax()) {
            if ($this->request->method() === 'POST') {
                try {
                    $kelas_id = $this->postField('kelas');
                    $siswa_id = $this->postField('siswa');
                    $is_exists = PosKelasSiswa::with(['siswa'])
                        ->where('siswa_id', '=', $siswa_id)
                        ->where('tahun_ajaran_id', '=', $tahun_ajaran->id)
                        ->exists();
                    if ($is_exists) {
                        return $this->jsonResponse('siswa sudah terdaftar di tahun ajaran sekarang...', 500);
                    }

                    $data_request = [
                        'siswa_id' => $siswa_id,
                        'kelas_id' => $kelas_id,
                        'tahun_ajaran_id' => $tahun_ajaran->id
                    ];
                    PosKelasSiswa::create($data_request);
                    return $this->jsonResponse('success', 200);
                } catch (\Exception $e) {
                    return $this->jsonResponse('failed ' . $e->getMessage(), 500);
                }


            }
            $kelas_id = $this->field('kelas');
            $data = PosKelasSiswa::with(['siswa'])
                ->where('tahun_ajaran_id', '=', $tahun_ajaran->id)
                ->where('kelas_id', '=', $kelas_id)
                ->get();
            return $this->basicDataTables($data);
        }
        $kelas = Kelas::all();
        $siswa = Siswa::with([])->where('status', '=', 1)->get();
        return view('pos-kelas-siswa.index')->with([
            'tahun_ajaran' => $tahun_ajaran,
            'kelas' => $kelas,
            'siswa' => $siswa
        ]);
    }

    public function destroy($id) {
        try {
            PosKelasSiswa::destroy($id);
            return $this->jsonResponse('success', 200);
        } catch (\Exception $e) {
            return $this->jsonResponse('failed', 500);
        }
    }
}
