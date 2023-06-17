@extends('Layout/isUser')
@section('content')
    <h5>{{$title}}</h5>
    <form action={{ route('edit_action') }} method="post">
        @csrf
        <input type="hidden" name="id" value={{$article->id}}>
        <input type="text" name="title" value={{$article->title}} placeholder="Title">
        <textarea type="text" name="description" rows="4" cols="50">
            {{$article->description}}
        </textarea>
        <input type="text" name="tag" value={{$article->tag}} placeholder="Tag">
        <button type="submit">Simpan</button>
    </form>
@endsection