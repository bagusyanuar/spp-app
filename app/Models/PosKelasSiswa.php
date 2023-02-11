<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PosKelasSiswa extends Model
{
    use HasFactory;

    protected $table = 'pos_kelas_siswa';

    protected $fillable = [
        'siswa_id',
        'kelas_id',
        'tahun_ajaran_id'
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function tahun_ajaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'tahun_ajaran_id');
    }

    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class, 'pos_kelas_siswa_id');
    }
}
