<?php

namespace Tests\Feature;

use App\Models\Match;
use App\Models\Season;
use App\Models\Week;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MatchApiTest extends TestCase
{
    use  RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $season = Season::factory()->create(['name'=>'season_1','year'=>2021]);
        $week = week::factory()->create(['title'=>'week_1','season_id'=> $season->id]);
        Match::factory()->create(['title'=>'match_1','week_id'=>$week->id]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testGetAllMatches()
    {
        $response = $this->get('/api/v1/matches');

        $response->assertStatus(200);
        $this->assertCount(1, $response->json()['data']);
    }

    public function testGetMatchById()
    {
        $response = $this->get('/api/v1/matches/1');

        $response->assertStatus(200)->assertJson(["data"=>['title'=>'match_1','week'=> 'week_1']]);
    }


    /**
     * @throws \PHPUnit\Framework\Exception
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     */
    public function testGetMatchesByFilter()
    {
        $season = Season::factory()->create(['name'=>'season_1','year'=>2020]);

        Week::factory()->create(['title'=>'week_1','season_id'=>$season->id,'week'=>1]);
        Week::factory()->create(['title'=>'week_2','season_id'=>$season->id,'week'=>1]);

        Match::factory()->create(['title'=>'match_1','description'=>'des','week_id'=>1]);
        Match::factory()->create(['title'=>'match_2','description'=>'des','week_id'=>2]);

        $response = $this->get('/api/v1/matches?week=1');

        $response->assertStatus(200);
        $this->assertCount(3, $response->json()['data']);
    }
}
