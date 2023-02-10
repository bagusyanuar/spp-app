<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\Pembayaran;
use App\Models\PembayaranDetail;
use App\Models\PosKelasSiswa;
use App\Models\PosPembayaran;
use App\Models\Siswa;
use App\Models\TahunAjaran;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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
            DB::beginTransaction();
            try {
                $data_pos_kelas_siswa = PosKelasSiswa::find($this->postField('siswa'));
                $bulans = $this->postField('bulan');
                $data_pos_pembayaran = PosPembayaran::where('tahun_ajaran_id', '=', $tahun_ajaran->id)->where('kelas_id', '=', $data_pos_kelas_siswa->kelas_id)
                    ->sum('nominal');
                $per_bulan = round($data_pos_pembayaran / 12, 0);
                $totalBayar = count($bulans) * $per_bulan;
                $data_request = [
                    'tanggal' => Carbon::now(),
                    'pos_kelas_siswa_id' => $data_pos_kelas_siswa->id,
                    'nominal' => $totalBayar,
                    'keterangan' => '',
                ];
                $pembayaran = Pembayaran::create($data_request);
                foreach ($bulans as $bulan) {
                    $data_detail = [
                        'pembayaran_id' => $pembayaran->id,
                        'bulan' => $bulan,
                        'nominal' => $per_bulan
                    ];
                    PembayaranDetail::create($data_detail);
                }
                DB::commit();
                return redirect()->route('pembayaran')->with('success', 'berhasil menyimpan pembayaran');
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->with('failed', 'terjadi kesalahan server...');
            }

        }
        if ($this->request->ajax()) {
            try {
                $siswa_id = $this->field('siswa');
                $data_pos_kelas_siswa = PosKelasSiswa::find($siswa_id);
                $data_pos = PosPembayaran::with(['jenis_pembayaran'])->where('kelas_id', '=', $data_pos_kelas_siswa->kelas_id)
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
            $total = 0;
            $pembayaran = 0;
            $kekurangan = 0;
            $bulan_pembayaran = [];
            $data_pos_kelas = PosKelasSiswa::find($siswa_id);
            if ($data_pos_kelas) {
                $data_siswa = Siswa::find($data_pos_kelas->siswa_id);

                if ($data_siswa) {
                    $total = PosPembayaran::with(['jenis_pembayaran'])->where('kelas_id', '=', $data_pos_kelas->kelas_id)
                        ->where('tahun_ajaran_id', '=', $tahun_ajaran->id)
                        ->sum('nominal');
                    $pembayaran = Pembayaran::with(['pos_kelas_siswa.siswa', 'pos_kelas_siswa.kelas'])
                        ->where('pos_kelas_siswa_id', '=', $data_pos_kelas->id)
//                    ->whereHas('pos_kelas_siswa', function ($q) use ($tahun_ajaran, $data_siswa) {
//                        return $q->where('tahun_ajaran_id', '=', $tahun_ajaran->id)->where('siswa_id', '=', $data_siswa->id);
//                    })
                        ->sum('nominal');
                    $kekurangan = (int)$total - (int)$pembayaran;
                }

                $data_pembayaran = Pembayaran::with(['details'])
                    ->where('pos_kelas_siswa_id', '=', $data_pos_kelas->id)->get();

                foreach ($data_pembayaran as $value) {
                    $details = $value->details;
                    foreach ($details as $vDetail) {
                        array_push($bulan_pembayaran, $vDetail->bulan);
                    }
                }

            }

            return $this->jsonResponse('success', 200, [
                'total' => (int)$total,
                'pembayaran' => (int)$pembayaran,
                'kekurangan' => $kekurangan,
                'bulan_pembayaran' => $bulan_pembayaran
            ]);
        } catch (\Exception $e) {
            return $this->jsonResponse('internal server error ' . $e->getMessage(), 500);
        }
    }

}
