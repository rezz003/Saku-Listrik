<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Tarif;
use Illuminate\View\View;

/**
 * @OA\Info(
 *     title="Tarif API",
 *     version="1.0.0",
 *     description="API untuk mengelola tarif listrik"
 * )
 */
class TarifController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/tarif",
     *     summary="Get list of tariffs",
     *     @OA\Response(
     *         response=200,
     *         description="A list of tariffs",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Tarif")
     *         )
     *     )
     * )
     */
    public function index() : View
    {
        $tarifs = Tarif::all();
        return view('tarif.index', compact('tarifs'));
    }

    /**
     * @OA\Post(
     *     path="/api/tarif",
     *     summary="Add a new tariff",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Tarif")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Tariff created successfully"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $tarifs = new Tarif;
        $tarifs->daya = $request->daya;
        $tarifs->tarifperkwh = $request->tarifperkwh;
        $tarifs->save();

        return redirect('/tarif')->with('success', 'Tarif Berhasil Ditambahkan');
    }

    public function destroy($id)
    {
        try {
            $tarifs = Tarif::findOrFail($id);
            $tarifs->delete();
    
            return redirect('/tarif')->with('success', 'Tarif berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus tarif.');
        }
    }

    public function update(Request $request, $id)
    {
    $request->validate([
        'daya' => 'required|numeric',
        'tarifperkwh' => 'required|numeric',
    ]);

    try {
        $tarif = Tarif::findOrFail($id);
        $tarif->daya = $request->daya;
        $tarif->tarifperkwh = $request->tarifperkwh;
        $tarif->save();

        return redirect('/tarif')->with('success', 'Tarif berhasil diperbarui.');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui Tarif.');
    }
    }
}
