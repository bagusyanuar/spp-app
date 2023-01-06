<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\Kelas;

class KelasController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($this->request->method() === 'POST' && $this->request->ajax()) {
            try {
                $data_request = [
                    'nama' => $this->postField('name')
                ];
                Kelas::create($data_request);
                return $this->jsonResponse('success', 200);
            } catch (\Exception $e) {
                return $this->jsonResponse('failed ' . $e->getMessage(), 500);
            }
        }

        if ($this->request->ajax()) {
            $data = Kelas::all();
            return $this->basicDataTables($data);
        }
        return view('kelas.index');
    }

    public function patch()
    {

    }
}
