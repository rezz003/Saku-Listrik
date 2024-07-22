<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayaran';
    protected $primaryKey = 'id_pembayaran';

    public $timestamps = true;  // Enable timestamps
    protected $fillable = [
        'id_pelanggan',
        'id_tagihan',
        'id_user',
        'tanggal_pembayaran',
        'biaya_admin',
        'total_bayar',
        'bukti_pembayaran'
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan');
    }
    public function tagihan()
    {
        return $this->belongsTo(Tagihan::class, 'id_tagihan');
    }
}
