<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;

class KelasController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        return view('kelas.index');
    }
}
