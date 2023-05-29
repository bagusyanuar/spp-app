<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\TahunAjaran;

class DashboardController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $tahun_ajaran = TahunAjaran::where('aktif', '=', true)->first();
        return view('dashboard')->with([
            'tahun_ajaran' => $tahun_ajaran
        ]);
    }
}
