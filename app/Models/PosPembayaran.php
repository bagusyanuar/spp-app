<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PosPembayaran extends Model
{
    use HasFactory;

    protected $table = 'pos_pembayaran';

    protected $fillable = [
        'tahun_ajaran_id',
        'kelas_id',
        'jenis_pembayaran_id',
        'nominal',
    ];

    public function tahun_ajaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'tahun_ajaran_id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function jenis_pembayaran()
    {
        return $this->belongsTo(JenisPembayaran::class, 'jenis_pembayaran_id');
    }
}
