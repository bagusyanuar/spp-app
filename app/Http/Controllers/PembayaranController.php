<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\Pembayaran;
use App\Models\PosKelasSiswa;
use App\Models\PosPembayaran;
use App\Models\Siswa;
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
            $data = Pembayaran::with(['pos_kelas_siswa.siswa', 'pos_kelas_siswa.kelas'])
                ->whereHas('pos_kelas_siswa', function ($q) use ($tahun_ajaran) {
                    return $q->where('tahun_ajaran_id', '=', $tahun_ajaran->id);
                })
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
        if ($this->request->method() === 'POST') {
            try {
                $data_siswa = Siswa::find($this->postField('siswa'));
                $data_request = [
                    'tanggal' => Carbon::now(),
                    'siswa_id' => $this->postField('siswa'),
                    'kelas_id' => $data_siswa->kelas_id,
                    'tahun_ajaran_id' => $tahun_ajaran->id,
                    'nominal' => $this->postField('nominal')
                ];
                Pembayaran::create($data_request);
                return redirect()->route('pembayaran')->with('success', 'berhasil menyimpan pembayaran');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'terjadi kesalahan server...');
            }

        }
        if ($this->request->ajax()) {
            try {
                $siswa_id = $this->field('siswa');
                $data_siswa = Siswa::find($siswa_id);
                $data_pos = PosPembayaran::with(['jenis_pembayaran'])->where('kelas_id', '=', $data_siswa->kelas_id)
                    ->where('tahun_ajaran_id', '=', $tahun_ajaran->id)
                    ->get();
                return $this->basicDataTables($data_pos);
            } catch (\Exception $e) {
                return $this->basicDataTables([]);
            }
        }
        $siswa = PosKelasSiswa::with(['siswa', 'kelas'])->where('tahun_ajaran_id', '=', $tahun_ajaran->id)->get();
        $bulan = [
            [
                'index' => 0,
                'nama' => 'Januari'
            ], [
                'index' => 1,
                'nama' => 'Februari'
            ], [
                'index' => 2,
                'nama' => 'Maret'
            ], [
                'index' => 3,
                'nama' => 'April'
            ], [
                'index' => 4,
                'nama' => 'Mei'
            ], [
                'index' => 5,
                'nama' => 'Juni'
            ], [
                'index' => 6,
                'nama' => 'Juli'
            ], [
                'index' => 7,
                'nama' => 'Agusutus'
            ], [
                'index' => 8,
                'nama' => 'September'
            ], [
                'index' => 9,
                'nama' => 'Oktober'
            ], [
                'index' => 10,
                'nama' => 'November'
            ], [
                'index' => 11,
                'nama' => 'Desember'
            ],
        ];
        return view('pembayaran.add')->with([
            'tahun_ajaran' => $tahun_ajaran,
            'siswa' => $siswa,
            'bulan' => $bulan,
        ]);
    }

    public function total_pembayaran_siswa()
    {
        try {
            $tahun_ajaran = TahunAjaran::where('aktif', '=', true)->first();
            $siswa_id = $this->field('siswa');
            $data_siswa = Siswa::find($siswa_id);
            $total = 0;
            $pembayaran = 0;
            $kekurangan = 0;
            if ($data_siswa) {
                $total = PosPembayaran::with(['jenis_pembayaran'])->where('kelas_id', '=', $data_siswa->kelas_id)
                    ->where('tahun_ajaran_id', '=', $tahun_ajaran->id)
                    ->sum('nominal');
                $pembayaran = Pembayaran::with(['pos_kelas_siswa.siswa', 'pos_kelas_siswa.kelas'])
                    ->whereHas('pos_kelas_siswa', function ($q) use ($tahun_ajaran, $siswa_id) {
                        return $q->where('tahun_ajaran_id', '=', $tahun_ajaran->id)->where('siswa_id', '=', $siswa_id);
                    })
                    ->sum('nominal');
                $kekurangan = (int)$total - (int)$pembayaran;
            }
            return $this->jsonResponse('success', 200, [
                'total' => (int)$total,
                'pembayaran' => (int)$pembayaran,
                'kekurangan' => $kekurangan
            ]);
        } catch (\Exception $e) {
            return $this->jsonResponse('internal server error ' . $e->getMessage(), 500);
        }
    }
}
