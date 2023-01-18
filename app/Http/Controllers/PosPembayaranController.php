<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\JenisPembayaran;
use App\Models\Kelas;
use App\Models\PosPembayaran;
use App\Models\TahunAjaran;

class PosPembayaranController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $tahun_ajaran = TahunAjaran::where('aktif', '=', true)->first();
        if ($this->request->method() === 'POST' && $this->request->ajax()) {
            try {
                $is_exists = PosPembayaran::with([])
                    ->where('tahun_ajaran_id', '=', $tahun_ajaran->id)
                    ->where('jenis_pembayaran_id', '=', $this->postField('jenis_pembayaran'))
                    ->where('kelas_id', '=', $this->postField('kelas'))
                    ->exists();
                if ($is_exists) {
                    return $this->jsonResponse('jenis pembayaran sudah disimpan...', 500);
                }
                $data_request = [
                    'tahun_ajaran_id' => $tahun_ajaran->id,
                    'jenis_pembayaran_id' => $this->postField('jenis_pembayaran'),
                    'kelas_id' => $this->postField('kelas'),
                    'nominal' => $this->postField('nominal'),
                ];
                PosPembayaran::create($data_request);
                return $this->jsonResponse('success', 200);
            } catch (\Exception $e) {
                return $this->jsonResponse('failed ' . $e->getMessage(), 500);
            }
        }

        $kelas = Kelas::all();
        $jenis_pembayaran = JenisPembayaran::all();
        if ($this->request->ajax()) {
            $kelas = $this->field('kelas');
            $data = PosPembayaran::with(['tahun_ajaran', 'kelas', 'jenis_pembayaran'])
                ->where('tahun_ajaran_id', '=', $tahun_ajaran->id)
                ->where('kelas_id', '=', $kelas)
                ->get();
            return $this->basicDataTables($data);
        }
        return view('pos-pembayaran.index')->with([
            'tahun_ajaran' => $tahun_ajaran,
            'kelas' => $kelas,
            'jenis_pembayaran' => $jenis_pembayaran,
        ]);
    }

    public function destroy($id)
    {
        try {
            PosPembayaran::destroy($id);
            return $this->jsonResponse('success', 200);
        } catch (\Exception $e) {
            return $this->jsonResponse('failed', 500);
        }
    }
}
