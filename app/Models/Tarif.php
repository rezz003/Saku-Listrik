<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     title="Tarif",
 *     description="Model tarif",
 *     @OA\Xml(
 *         name="Tarif"
 *     )
 * )
 */
class Tarif extends Model
{
    use HasFactory;

    protected $table = 'tarif';

    protected $primaryKey = 'id_tarif';

    public $timestamps = true;
    protected $fillable = [
        'daya',
        'tarifperkwh',
    ];

    /**
     * @OA\Property(
     *     title="ID",
     *     description="ID of the tariff",
     *     format="int64",
     *     example=1
     * )
     *
     * @var integer
     */
    // public $id_tarif;

    /**
     * @OA\Property(
     *     title="Daya",
     *     description="Daya listrik dalam watt",
     *     example=900
     * )
     *
     * @var integer
     */
    // public $daya;

    /**
     * @OA\Property(
     *     title="Tarif per KWh",
     *     description="Tarif per KWh dalam rupiah",
     *     example=1352
     * )
     *
     * @var float
     */
    // public $tarifperkwh;

    public function pelanggan()
    {
        return $this->hasMany(Pelanggan::class, 'id_tarif');
    }
   
}
