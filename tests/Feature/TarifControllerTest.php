<?php

namespace Tests\Feature;

use App\Models\Tarif;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TarifControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the index method.
     *
     * @return void
     */
    public function test_index_displays_all_tarifs()
    {
        // Create some tariffs
        $tarif1 = Tarif::factory()->create();
        $tarif2 = Tarif::factory()->create();

        // Perform a GET request to the index route
        $response = $this->get(route('tarif.index'));

        // Assert that the response status is 200
        $response->assertStatus(200);

        // Assert that the view has the correct data
        $response->assertViewHas('tarifs', function ($tarifs) use ($tarif1, $tarif2) {
            return $tarifs->contains($tarif1) && $tarifs->contains($tarif2);
        });
    }

    /**
     * Test the store method.
     *
     * @return void
     */
    public function test_store_creates_a_new_tarif()
    {
        // Data to be used for the tarif
        $data = [
            'daya' => 1300,
            'tarifperkwh' => 1500,
        ];

        // Perform a POST request to the store route
        $response = $this->post(route('tarif.store'), $data);

        // Assert that the response redirects to the tarif index page
        $response->assertRedirect(route('tarif.index'));

        // Assert that the tarif was successfully created
        $this->assertDatabaseHas('tarif', $data);
    }

    /**
     * Test the store method with validation errors.
     *
     * @return void
     */
    public function test_store_validation_errors()
    {
        // Perform a POST request to the store route with invalid data
        $response = $this->post(route('tarif.store'), []);

        // Assert that the response contains validation errors
        $response->assertSessionHasErrors(['daya', 'tarifperkwh']);
    }
}