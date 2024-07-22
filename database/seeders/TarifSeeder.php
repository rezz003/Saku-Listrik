<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TarifSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tarif')->insert([
            ['daya' => 450, 'tarifperkwh' => 415],
            ['daya' => 900, 'tarifperkwh' => 600],
        ]);
    }
}
