<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\TahunAjaran;
use Illuminate\Support\Facades\DB;

class TahunAjaranContoller extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($this->request->method() === 'POST' && $this->request->ajax()) {
            try {
                $exists = TahunAjaran::with([])->where('periode', '=', $this->postField('periode'))->exists();
                if ($exists) {
                    return $this->jsonResponse('Tahun ajaran udah di buat...', 500);
                }
                $data_request = [
                    'periode' => $this->postField('periode')
                ];
                $active_exists = TahunAjaran::where('aktif', '=', true)->first();
                if ($active_exists === null) {
                    $data_request['aktif'] = true;
                }
                TahunAjaran::create($data_request);
                return $this->jsonResponse('success', 200);
            } catch (\Exception $e) {
                return $this->jsonResponse('failed ' . $e->getMessage(), 500);
            }
        }

        if ($this->request->ajax()) {
            $data = TahunAjaran::all();
            return $this->basicDataTables($data);
        }
        return view('tahun-ajaran.index');
    }

    public function patch($id)
    {
        try {
            $data = TahunAjaran::find($id);
            $data_request = [
                'periode' => $this->postField('periode')
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
            TahunAjaran::destroy($id);
            return $this->jsonResponse('success', 200);
        } catch (\Exception $e) {
            return $this->jsonResponse('failed', 500);
        }
    }
    public function change($id)
    {
        DB::beginTransaction();
        try {
            $status = true;
            TahunAjaran::where('id', '=', $id)->update([
                'aktif' => $status
            ]);
            TahunAjaran::where('id', '!=', $id)->update([
                'aktif' => !$status
            ]);
            DB::commit();
            return $this->jsonResponse('success', 200);
        } catch (\Exception $e) {
            return $this->jsonResponse('failed ' . $e->getMessage(), 500);
        }
    }
}
