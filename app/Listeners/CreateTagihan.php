<?php

namespace App\Listeners;

use App\Events\PenggunaanCreated;
use App\Models\Tagihan;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreateTagihan
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(PenggunaanCreated $event): void
    {
        $penggunaan = $event->penggunaan;
        $jumlah_kwh = $penggunaan->meteran_akhir - $penggunaan->meteran_awal;
        $tarif = $penggunaan->pelanggan->tarif->tarifperkwh;
        $total_tagihan = $jumlah_kwh * $tarif;

        $tagihan = new Tagihan();
        $tagihan->id_penggunaan = $penggunaan->id_penggunaan;
        $tagihan->id_pelanggan = $penggunaan->id_pelanggan;
        $tagihan->tanggal_tagihan = now();
        $tagihan->jumlah_kwh = $jumlah_kwh;
        $tagihan->total_tagihan = $total_tagihan;
        $tagihan->status = 'Dibuat';
        $tagihan->save();
    }
}
