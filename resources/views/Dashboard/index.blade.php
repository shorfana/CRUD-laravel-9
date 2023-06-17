@extends('Layout/isUser')
@section('content')
    <h3>{{ $title }}</h3>
    {{session()->get('message')}}
    <form action={{ route('dashboard_logout') }} method="POST">
        @csrf
        <input type="hidden" name="token" value={{ $users->token }} />   
        <button type="submit">Logout</button> 
    </form>  
    <hr>  
    <div>
        <form action="{{route('article_add_action')}}" method="POST">
            @csrf
            <input type="text" name="title" placeholder="judul">
            <input type="text" name="description" placeholder="deskripsi">
            <input type="text" name="tag" placeholder="tag">
            <button type="submit">Buat Artikel</button>
        </form>
    </div>
    <table class="table table-striped table-bordered table-paginate" cellspacing="0" width="100%">
        <tr>
            <th>id</th>
            <th>title</th>
            <th>description</th>
            <th>tag</th>
            <th>action</th>
        </tr>
        @foreach ($articles as $ar)
        <tr>
            <td>{{$ar->id}}</td>
            <td>{{$ar->title}}</td>
            <td>{{$ar->description}}</td>
            <td>{{$ar->tag}}</td>
            <td>
                <div>
                    <a href="/edit/{{$ar->id}}">edit</a>
                    {{-- <a href="">hapus</a> --}}
                    <form action={{route('article_delete_action')}} method="POST">
                        @csrf
                        <input type="hidden" name="id" value={{$ar->id}}/>
                        <button>hapus</button>
                    </form>
                </div>
            </td>
        </tr>
        @endforeach
    </table>
@endsection