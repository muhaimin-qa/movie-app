<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Watchlist;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $favoriteMovies = Movie::all();
        $watchlist = Watchlist::all();

        return view('movies.index', compact('favoriteMovies', 'watchlist'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('movies.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        Movie::create($request->all());

        return redirect()->route('movies.index')->with('success', 'Success Create!');
    }

    //User add to watchlist    
    public function add_to_watchlist(Request $request)
    {
        $watchlist = new Watchlist;

        //default add to user id = 1
        $watchlist->user_id = '1';
        $watchlist->movie_id = $request->movie_id;
        $watchlist->name = $request->name;
        $watchlist->is_watched = $request->is_watched;
        $watchlist->created_at = now();

        //check if movie exist in watchlist
        if (Watchlist::where('movie_id', '=', $request->movie_id)->exists()) {
            return redirect()->route('movies.index')->with('success',$request->name.' already in Watchlist');
        }
        else{
            if ($watchlist->save()) {
                return redirect()->route('movies.index')->with('success',$request->name.' added to watchlist');
            }
        }

        
    }
    
    //user watched/unwatched the movie in watchlsit
    public function update_watch(Request $request, Watchlist $watchlist)
    {
        $watchlist->update($request->all());
        
        if($request->is_watched == "YES"){
            return redirect()->route('movies.index')->with('success','Movie set to watched');
        }

        return redirect()->route('movies.index')->with('success','Movie set to unwatched');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function show(Movie $movie)
    {
        $movie = Movie::findOrFail($movie->id);

        return view('movies.show', compact('movie'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function edit(Movie $movie)
    {
        return view('movies.edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function destroy(Movie $movie)
    {
        //
    }
}
