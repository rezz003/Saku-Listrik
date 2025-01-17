<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory;

    protected $table = 'pelanggan';
    protected $primaryKey = 'id_pelanggan';

    public $timestamps = true;
    protected $fillable =[
        'username',
        'nomor_kwh',
        'nama_pelanggan',
        'alamat',
        'id_tarif',
    ];

    public function tarif()
    {
        return $this->belongsTo(Tarif::class, 'id_tarif');
    }

    public function penggunaan()
    {
        return $this->hasMany(Penggunaan::class,'id_pelanggan');
    }

    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class,'id_pembayaran');
    }
}
