<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Movie;
use App\Models\User;
use App\Models\Watchlist;
use Tests\TestCase;

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
        $user = User::factory()->create();
        $user->save();

        //Populate movie db first
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

        //Create Watchlist
        $watchlist = Watchlist::factory()->create();
        $watchlist->save();

        $response = $this->get(route('movies.show', $movie->id));

        $response->assertStatus(200);
    }

    /** @test */
    public function user_can_create_new_movie(){

        //Create 1 user
        $user = User::factory()->create(['id' => '1']);
        $user->save();

        //Create 1 movie
        $movie = Movie::factory()->create();
        
    
        $response = $this->post(route('movies.store'),[
            'name' => $movie->name,
        ]);

        $response->assertRedirect(route('movies.index'));
        
    }

    /** @test */
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
            'user_id' => '1',
            'movie_id' => $movie->id,
            'is_watched' => 'NO'
        ]);
        
        $response->assertRedirect(route('movies.index'));
    }

    /** @test */
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
    //testing php artisan import:movieDatabase Avengers (search = Avengers)
    public function test_artisan_command_import_new_movies_to_db(){
        $this->artisan('import:movieDatabase Kuala')->assertExitCode(0);
    
    }

    /** @test */
    //testing php artisan create:newUser 1 (quantity = 1)
    public function test_artisan_command_create_new_user(){
        $this->artisan('create:newUser 1')->assertExitCode(0);
    
    }

    //create negative testing
    public function user_cannot_create_user_without_name(){
        
    }
}
