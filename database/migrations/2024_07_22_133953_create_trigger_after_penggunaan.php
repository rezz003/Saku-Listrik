<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("
        CREATE TRIGGER after_penggunaan_insert
        AFTER INSERT ON penggunaan
        FOR EACH ROW
        BEGIN
            INSERT INTO tagihan (id_penggunaan, id_pelanggan, tanggal_tagihan, jumlah_kwh, total_tagihan, status)
            VALUES (
                NEW.id_penggunaan,
                NEW.id_pelanggan,
                NOW(),
                NEW.meteran_akhir - NEW.meteran_awal,
                (NEW.meteran_akhir - NEW.meteran_awal) * (SELECT tarifperkwh FROM pelanggan WHERE id_pelanggan = NEW.id_pelanggan),
                'Dibuat'
            );
        END;
    ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trigger_after_penggunaan');
    }
};
