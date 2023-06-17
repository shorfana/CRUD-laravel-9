@extends('Layout/isGuest')
@section('content')
    <h3>{{$title}}</h3>
    <div>
        @foreach ($articles as $ar)
            <div>
                <h3><a href="/article/{{$ar->id}}"> {{$ar->title}}</a></h3>    
            </div>            
            <hr>
        @endforeach
    </div>
@endsection