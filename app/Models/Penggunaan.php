<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penggunaan extends Model
{
    use HasFactory;

    protected $table = 'penggunaan';
    protected $primaryKey = 'id_penggunaan';

    public $timestamps = true;
    protected $fillable =[
        'id_pelanggan',
        'tanggal_penggunaan',
        'meteran_awal',
        'meteran_akhir',
    ];

    public function pelanggan(){
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan', 'id_pelanggan');
    }
    public function tagihan()
    {
    return $this->hasOne(Tagihan::class, 'id_penggunaan', 'id_penggunaan');
    }
}
