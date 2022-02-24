@extends('movies.layout')
 
@section('content')
<a href="{{ route('movies.index')}}">Back</a>
<h1>{{$movie->name}}</h1>
<p>Created at: {{$movie->created_at}}</p>
<p>IMDB ID: {{$movie->movie_id}}</p>

@endsection