@extends('movies.layout')
 
@section('content')
    <a href="{{ route('movies.index') }}">Back to Index</a> 
    <h1>Create New Movie</h1>
    
    
    @if ($errors->any())
    <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('movies.store') }}" method="POST">
        @csrf
        
        <input type="text" name="name" class="form-control" placeholder="Movie Name..">
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

@endsection