@extends('movies.layout')
 
@section('content')
    
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    
    <div class="row">
        <a href="{{ route('movies.create') }}">AAAAAA Create New Movie</a>
        <p>My Watchlist</p>
        <table>
            <tr>
                <th style="width: 5%">ID</th>
                <th>Movie Title</th>
                <th style="width:20%">Watched?</th>
            </tr>
            
            @if($watchlist)
            @foreach ($watchlist as $w)
            <tr>
                
                <td>{{ $w->movie_id }}</td>
                <td>{{ $w->name }}</td>
                <td>
                    @if($w->is_watched == 'YES')
                
                    {{ $w->is_watched }} ({{ $w->updated_at }})

                    <form action="{{ route('update_watch',$w->id) }}" method="POST">
                        @csrf
                        
                        <input type="hidden" name="is_watched" class="form-control" placeholder="" value="NO">
                        <button type="submit" class="btn btn-warning btn-sm">Unwatched</button>
                    </form>
                    
                    @else
                    
                    {{ $w->is_watched }}

                    <form action="{{ route('update_watch',$w->id) }}" method="POST">
                        @csrf
                        
                        <input type="hidden" name="is_watched" class="form-control" placeholder="" value="YES">
                        <button type="submit" class="btn btn-primary btn-sm">Watched</button>
                    </form>
                    @endif 
                </td>
                
            </tr>
            @endforeach
            @else
            No Watchlist
            @endif
        </table>
       <br/><br/>

       <p>Movie list</p>
        <table>
            <tr>
                <th style="width: 5%">IMDB ID</th>
                <th>Movie Title</th>
                <th style="width:5%">Action</th>
                
            </tr>
            @foreach ($favoriteMovies as $fav)
            <tr>
                <td>{{$fav->movie_id}}</td>
                <td>{{$fav->name}} <a href="{{ route('movies.show', $fav->id) }}">More</a></td>
                <td>
                    <form action="{{ route('add_to_watchlist')}}" method="POST">
                        @csrf
                        
                        <input type="hidden" name="name" class="form-control" placeholder="" value="{{ $fav->name }}">
                        <input type="hidden" name="user_id" class="form-control" placeholder="" value="1">
                        <input type="hidden" name="movie_id" class="form-control" placeholder="" value="{{ $fav->id }}">
                        <input type="hidden" name="is_watched" class="form-control" placeholder="" value="NO">
                        <button type="submit" class="btn btn-primary btn-sm">Add to Watchlist</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </table>
    </div>
@endsection
