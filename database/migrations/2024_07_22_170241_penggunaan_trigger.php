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
        DB::unprepared("
            CREATE TRIGGER after_penggunaan_insert
            AFTER INSERT ON penggunaan
            FOR EACH ROW
            BEGIN
                DECLARE jumlah_kwh INT;
                DECLARE tarif_per_kwh DECIMAL(10, 2);
                DECLARE total_tagihan DECIMAL(10, 2);

                SET jumlah_kwh = NEW.meteran_akhir - NEW.meteran_awal;
                SELECT tarifperkwh INTO tarif_per_kwh FROM tarif WHERE id_tarif = (SELECT id_tarif FROM pelanggan WHERE id_pelanggan = NEW.id_pelanggan);
                SET total_tagihan = jumlah_kwh * tarif_per_kwh;

                INSERT INTO tagihan (id_penggunaan, id_pelanggan, tanggal_tagihan, jumlah_kwh, total_tagihan, status)
                VALUES (NEW.id_penggunaan, NEW.id_pelanggan, NOW(), jumlah_kwh, total_tagihan, 'Belum Dibayar');
            END
        ");

        DB::unprepared("
            CREATE TRIGGER after_penggunaan_update
            AFTER UPDATE ON penggunaan
            FOR EACH ROW
            BEGIN
                DECLARE jumlah_kwh INT;
                DECLARE tarif_per_kwh DECIMAL(10, 2);
                DECLARE total_tagihan DECIMAL(10, 2);

                SET jumlah_kwh = NEW.meteran_akhir - NEW.meteran_awal;
                SELECT tarifperkwh INTO tarif_per_kwh FROM tarif WHERE id_tarif = (SELECT id_tarif FROM pelanggan WHERE id_pelanggan = NEW.id_pelanggan);
                SET total_tagihan = jumlah_kwh * tarif_per_kwh;

                UPDATE tagihan
                SET jumlah_kwh = jumlah_kwh,
                    total_tagihan = total_tagihan,
                    tanggal_tagihan = NOW()
                WHERE id_penggunaan = NEW.id_penggunaan;
            END
        ");

        DB::unprepared("
            CREATE TRIGGER after_penggunaan_delete
            AFTER DELETE ON penggunaan
            FOR EACH ROW
            BEGIN
                DELETE FROM tagihan
                WHERE id_penggunaan = OLD.id_penggunaan;
            END
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP TRIGGER IF EXISTS after_penggunaan_insert");
        DB::unprepared("DROP TRIGGER IF EXISTS after_penggunaan_update");
        DB::unprepared("DROP TRIGGER IF EXISTS after_penggunaan_delete");
    }
};
