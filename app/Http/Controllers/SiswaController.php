<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\Kelas;
use App\Models\Siswa;

class SiswaController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($this->request->ajax()) {
            $data = Siswa::with('kelas')->get();
            return $this->basicDataTables($data);
        }
        return view('siswa.index');
    }

    public function store()
    {
        if ($this->request->method() === 'POST') {
            $data_request = [
                'nis' => $this->postField('nis'),
                'kelas_id' => $this->postField('kelas'),
                'nama' => $this->postField('nama'),
                'jenis_kelamin' => $this->postField('jenis_kelamin'),
                'tempat_lahir' => $this->postField('tempat_lahir'),
                'tanggal_lahir' => $this->postField('tanggal_lahir'),
                'no_hp' => $this->postField('no_hp'),
                'alamat' => $this->postField('alamat'),
                'status' => $this->postField('status'),
                'ibu' => $this->postField('ibu'),
                'ayah' => $this->postField('ayah'),
                'no_hp_ortu' => $this->postField('no_hp_ortu'),
            ];
            try {
                Siswa::create($data_request);
                return redirect()->back()->with('success', 'Berhasil menambah data');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'terjadi kesalahan server');
            }
            dd($data_request);
        }
        $kelas = Kelas::all();
        return view('siswa.add')->with(['kelas' => $kelas]);
    }
}
