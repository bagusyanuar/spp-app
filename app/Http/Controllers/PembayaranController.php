<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\Pembayaran;
use App\Models\TahunAjaran;
use Carbon\Carbon;

class PembayaranController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $tahun_ajaran = TahunAjaran::where('aktif', '=', true)->first();
        if ($this->request->ajax()) {
            $data = Pembayaran::with(['siswa', 'kelas', 'tahun_ajaran'])
                ->where('tahun_ajaran_id', '=', $tahun_ajaran->id)
                ->where('tanggal', '=', Carbon::now()->format('Y-m-d'))
                ->orderBy('id', 'DESC')
                ->get();
            return $this->basicDataTables($data);
        }
        return view('pembayaran.index')->with([
            'tahun_ajaran' => $tahun_ajaran,
        ]);
    }

    public function add()
    {
        $tahun_ajaran = TahunAjaran::where('aktif', '=', true)->first();
        return view('pembayaran.add')->with([
            'tahun_ajaran' => $tahun_ajaran,
        ]);
    }
}
