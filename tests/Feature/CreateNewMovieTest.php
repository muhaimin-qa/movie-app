<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Movie;
use App\Models\User;
use App\Models\Watchlist;
use Tests\TestCase;
use Illuminate\Support\Facades\Http;

class CreateNewMovieTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** @test */
    public function user_can_view_movie_index_page()
    {
        //Create 1 user
        $user = User::factory()->create(['id' => '1']);
        $user->save();

        //Populate movie database
        $movie = Movie::factory()->create();
        $movie->save();

        $response = $this->get('/movies');

        $response->assertStatus(200);
    }

    /** @test */
    public function user_can_view_movie_detail_page()
    {
        //Create 1 user
        $user = User::factory()->create(['id' => '1']);
        $user->save();

        //Create 1 movie
        $movie = Movie::factory()->create();
        $movie->save();

        $response = $this->get(route('movies.show', $movie->id));

        $response->assertStatus(200);
    }

    /** @test */
    public function user_can_create_new_movie(){

        //Create 1 user
        $user = User::factory()->create(['id' => '1']);
        $user->save();
        
        $faker = \Faker\Factory::create();

        $response = $this->post(route('movies.store'),[
            'name' => $faker->name(),
        ]);

        $response->assertRedirect(route('movies.index'));
        
    }

    /** @test */
    // User cannot create movie without name
    // Negative testing
    public function user_cannot_create_new_movie_without_name(){

        //Create 1 user
        $user = User::factory()->create(['id' => '1']);
        $user->save();

        //Create 1 movie, set name = null
        $movie = Movie::factory()->create([
            'name' => null,
        ]);
        
        $response = $this->post(route('movies.store'),[
            'name' => $movie->name,
        ]);

        $response->assertSessionHasErrors(['name']);
        
    }

    /** @test */
    // Test user can add movie to watchlist
    public function user_can_add_movie_to_watchlist()
    {
        //mcm biasa create 1 user id=1
        $user = User::factory()->create(['id' => '1']);
        $user->save();

        //create satu movie dulu
        $movie = Movie::factory()->create();
        $movie->save();

        //pilih movie tu, add ke watchlist
        $response = $this->post(route('add_to_watchlist'),[
        'name' => $movie->name,
            'user_id' => $user->id,
            'movie_id' => $movie->id,
            'is_watched' => 'NO'
        ]);
        
        $response->assertRedirect(route('movies.index'));
    }

    /** @test */
    // Test user can update movie to watched
    public function user_can_update_movie_to_watched()
    {

         //mcm biasa create 1 user id=1
         $user = User::factory()->create(['id' => '1']);
         $user->save();

 
        //create 1 movie dalam watchlist
        $watchlist = Watchlist::factory()->create(['is_watched' => 'NO']);
        $watchlist->save();

        $response = $this->post(route('update_watch',[$watchlist->id]),[
            'is_watched' => 'YES',
        ]);

        $response->assertRedirect(route('movies.index'));

    }

    /** @test */
    // Test user can update movie to unwatched
    public function user_can_update_movie_to_unwatched()
    {

         //mcm biasa create 1 user id=1
         $user = User::factory()->create(['id' => '1']);
         $user->save();

 
        //create 1 movie dalam watchlist
        $watchlist = Watchlist::factory()->create(['is_watched' => 'YES']);
        $watchlist->save();

        $response = $this->post(route('update_watch',[$watchlist->id]),[
            'is_watched' => 'NO',
        ]);

        $response->assertRedirect(route('movies.index'));

    }

    /** @test */
    // Testing php artisan import:movieDatabase Avengers (search keyword = game)
    // Mock Http response, return mock result with 2 data only
    public function test_artisan_command_import_new_movies_to_db(){

        //mock response
        Http::fake([
            'https://imdb8.p.rapidapi.com/auto-complete*' => Http::response(
                [
                      "d" => [
                            [
                               "id" => "tt0944947", 
                               "l" => "Game of Thrones", 
                            ], 
                            [
                                
                                "id" => "tt10919420", 
                                "l" => "Squid Game", 
 
                            ] 
                         ], 
                      "q" => "game", 
                      "v" => 1    
                ], 
                200
            )]);
        
    
        $this->artisan('import:movieDatabase')
        ->expectsQuestion('Enter search keyword','game')
        ->expectsOutput('Database import success!')
        ->assertExitCode(0);
    
    }

     /** @test */
    // Negative testing php artisan import:movieDatabase without search param, will throw exception message in console
    public function test_artisan_command_import_new_movies_to_db_has_error(){

        $this->expectExceptionMessage('Trying to access array offset on value of type null');
        $this->artisan('import:movieDatabase')->expectsQuestion('Enter search keyword','');
    
    }


    /** @test */
    // Testing php artisan create:newUser 1 (quantity = 1)
    public function test_artisan_command_create_new_user(){
        $this->artisan('create:newUser')
        ->expectsQuestion('How many user?', 1)
        ->assertExitCode(0);
    
    }
}
