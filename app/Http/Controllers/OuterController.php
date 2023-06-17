<?php

namespace App\Http\Controllers;

use App\Models\Articles;
use Illuminate\Http\Request;

class OuterController extends Controller
{
    public function index(){
        // echo "Anjing galak";
        $articles = Articles::get();
        return view('index',[
            'title' => 'Seleruh Artikel',
            'articles' => $articles
        ]);
    }

    public function article_detail($id)
    {
        
        return view('article',[
            'title' => 'artikel detail' . $id,
            'article' => Articles::find($id)
        ]);
    }

}
