<?php

namespace App\Console\Commands;

use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Console\Command;

class importMovieDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:movieDatabase {search : Search what movie}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import movie database from IMDB API';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        info('haha');

        //get data from API
        $response = Http::withHeaders([
            'x-rapidapi-host' => 'imdb8.p.rapidapi.com',
            'x-rapidapi-key' => 'c11f77d905mshd2273d8fab8857ap1f310fjsnc352c64d4366'
        ])->get('https://imdb8.p.rapidapi.com/auto-complete', [
            'q' => $this->argument('search'),
        ])->json()['d'];

        //create movie in database based on response data
        foreach($response as $movie)
        {
            
            Movie::create([
                'movie_id' => $movie['id'],
                'name' => $movie['l'],
                'favorite' => "NO",
                'created_at' => now(),
            ]);

            $this->info('Added '.$movie['l']);
        }

        
        $this->info('Database import success!');
        
    }
}
