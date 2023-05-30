<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Support\Facades\Validator;

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
                $validator = Validator::make(request()->all(), [
                    'nis' => 'required',
                    'nama' => 'required',
                    'jenis_kelamin' => 'required',
                    'tanggal_lahir' => 'required',
                    'no_hp' => 'required',
                    'alamat' => 'required',
                    'status' => 'required',
                    'ibu' => 'required',
                    'ayah' => 'required',
                    'no_hp_ortu' => 'required',
                ],
                    [
                        'nis.required' => 'Kolom nis harus di isi',
                        'nama.required' => 'Kolom nama siswa harus di isi',
                        'jenis_kelamin.required' => 'kolom jenis kelamin harus di isi',
                        'tanggal_lahir.required' => 'kolom tanggal lahir harus di isi',
                        'no_hp.required' => 'kolom nomor handphone harus di isi',
                        'alamat.required' => 'kolom alamat harus di isi',
                        'status.required' => 'kolom status harus di isi',
                        'ibu.required' => 'kolom nama ibu harus di isi',
                        'ayah.required' => 'kolom nama ayah harus di isi',
                        'no_hp_ortu.required' => 'kolom nomor handphone orang tua harus di isi',
                    ]
                );
                if ($validator->fails()) {
                    return redirect()->back()->withInput(request()->input())->withErrors($validator->errors());
                }
                Siswa::create($data_request);
                return redirect()->back()->with('success', 'Berhasil menambah data');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'terjadi kesalahan server');
            }
        }
        $kelas = Kelas::all(); //read (R)
        return view('siswa.add')->with(['kelas' => $kelas]);
    }

    public function edit_page($id)
    {
        $data = Siswa::findOrFail($id); //read (R)
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
                $data->update($data_request); //update (U)
                return redirect('/siswa')->with('success', 'Berhasil merubah data');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'terjadi kesalahan server');
            }
        }
        return view('siswa.edit')->with(['data' => $data]);
    }

    public function destroy()
    {
        try {
            $id = $this->postField('id');
            Siswa::destroy($id); //delete (D)
            return $this->jsonResponse('success', 200);
        } catch (\Exception $e) {
            return $this->jsonResponse('failed', 500);
        }
    }
}
