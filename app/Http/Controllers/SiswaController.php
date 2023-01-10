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
        $kelas = Kelas::all();
        return view('siswa.add')->with(['kelas' => $kelas]);
    }
}
