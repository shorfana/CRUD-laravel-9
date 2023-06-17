@extends('Layout/isGuest')

@section('content')
    <h1>{{$title}}</h1>
    <div>
        <h3> {{$article->title}}</h3>
        <p>{{$article->description}}</p>
        <i>{{$article->tag}}</i>
    </div>
    <a href="/">Kembali</a>
@endsection