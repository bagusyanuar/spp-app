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
                $data_request = [
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
}
