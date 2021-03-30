<?php

namespace Tests\Feature;

use App\Models\Season;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SeasonApiTest extends TestCase
{
    use  RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        Season::factory()->create(['name'=>'season_1','year'=>2021]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testGetAllSeasons()
    {
        $response = $this->get('/api/v1/seasons');

        $response->assertStatus(200);
        $this->assertCount(1, $response->json()[0]['data']);
    }

    public function testGetSeasonById()
    {
        $response = $this->get('/api/v1/seasons/1');

        $response->assertStatus(200)->assertJson(["data"=>['name'=>'season_1','year'=> "2021"]]);
    }

    public function testCreateSeason()
    {
        $response = $this->post('/api/v1/seasons/', [
            'name' => 'season_2',
            'year' => '2010'
        ]);

        $response->assertStatus(201)->assertJson(["data"=>['name'=>'season_1','year'=> "2021"]]);
    }
}
