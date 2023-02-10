<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayaran';

    protected $fillable = [
        'pos_kelas_siswa_id',
        'tanggal',
        'nominal',
        'keterangan',
    ];

    public function pos_kelas_siswa()
    {
        return $this->belongsTo(PosKelasSiswa::class, 'pos_kelas_siswa_id');
    }

    public function details()
    {
        return $this->hasMany(PembayaranDetail::class, 'pembayaran_id');
    }
}
