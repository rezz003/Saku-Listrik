<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tagihan extends Model
{
    use HasFactory;

    protected $table = 'tagihan';
    protected $primaryKey = 'id_tagihan';

    public $timestamps = true;
    
    protected $fillable = [
        'id_penggunaan',
        'id_pelanggan',
        'tanggal_tagihan',
        'jumlah_kwh',
        'total_tagihan',
        'status',
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan');
    }
}
