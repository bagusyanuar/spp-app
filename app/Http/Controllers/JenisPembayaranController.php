<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\JenisPembayaran;

class JenisPembayaranController extends CustomController
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
                JenisPembayaran::create($data_request);
                return $this->jsonResponse('success', 200);
            } catch (\Exception $e) {
                return $this->jsonResponse('failed ' . $e->getMessage(), 500);
            }
        }

        if ($this->request->ajax()) {
            $data = JenisPembayaran::all();
            return $this->basicDataTables($data);
        }
        return view('jenis-pembayaran.index');
    }

    public function patch($id)
    {
        try {
            $data = JenisPembayaran::find($id);
            $data_request = [
                'nama' => $this->postField('name')
            ];
            $data->update($data_request);
            return $this->jsonResponse('success', 200);
        }catch (\Exception $e) {
            return $this->jsonResponse('failed ' . $e->getMessage(), 500);
        }
    }

    public function destroy($id)
    {
        try {
            JenisPembayaran::destroy($id);
            return $this->jsonResponse('success', 200);
        } catch (\Exception $e) {
            return $this->jsonResponse('failed', 500);
        }
    }
}
