<?php

namespace App\Http\Controllers;

use App\Models\Users;
use App\Models\Articles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class UsersController extends Controller
{
    public function login_form()
    {
        if(Session::has('token'))
        {

            return to_route('dashboard_index');
        }
        else
        {
            return view('Login',[
                "title" => "Form Login"
            ]);
        }
    }

    public function login_action(Request $request)
    {
        // Validator
        $validate = Validator::make($request->all(),[
            'username' => 'required',
            'password' => 'required'
        ]);
        if($validate->fails()){
            return back()->withErrors($validate->errors());
        }
        $users = Users::where('username', $request->username)->first();
        if($users == null){
            return redirect()->back()->with('error','username tidak ditemukan');
        }
        $db_password = $users->password;
        $hashed_password = Hash::check($request->password,$db_password);

        if($hashed_password){
            $users->token = Str::random(20);
            $users->save();
            $request->session()->put('token', $users->token);
            return to_route('dashboard_index');
        }else{
            return redirect()->back()->with('error', 'maaf data anda tidak sesuai');
        }
    }

    public function dashboard_index()
    {
        if(Session::has('token'))
        {
            $users = Users::where('token',Session::get('token'))->first();
            $articles = Articles::get();

            return view('Dashboard/index',[
                "title" => "DASHBOARD ADMIN",
                'users' => $users,
                'articles' => $articles,
                'isActiveh' => 'active',
                'isActivea' => ''
            ]);
        }else{
            return redirect()->back();
        }
    }

    public function dashboard_logout(Request $request)
    {
        // dd($request);
        Users::where('token', $request->token)->update([
            'token' => NULL
        ]);
        Session::pull('token');
        return to_route('login_form');
    }

    public function article_add_action(Request $request)
    {

        $request->validate([
            'title' => ['required', 'max:255', 'min:10'],
            'description' => ['required'],
            'tag' => ['nullable'],
        ]);

        $created = Articles::create([
            "title" => $request->title,
            "description" => $request->description,
            "tag" => $request->tag,
        ]);

        if ($created) {
            return redirect()->back()->with('message', 'artikel berhasil dibuat');
        } else {
            return redirect()->back()->with('message', 'artikel gagal dibuat');
        }
    }

    public function article_delete_action(Request $request)
    {
        Articles::find($request->id)->delete();
        return redirect()->back()->with('message', 'artikel berhasil dihapus');
    }

    public function edit_view($id)
    {
        $data_article = Articles::find($id);
        return view('Dashboard/viewEdit',[
            'title' => 'Form Edit',
            'article' => $data_article
        ]);
    }

    public function edit_action(Request $request)
    {
        $data_article = Articles::find($request->id);
        $data_article->title = $request->title;
        $data_article->description = $request->description;
        $data_article->tag = $request->tag;
        
        if($data_article->save()){
            return to_route('dashboard_index')->with('message','article berhasil diubah');
        }else{
            return redirect()->back()->with('error', 'artikel gagal diubah');
        }
    }

    public function register_view()
    {
        return view('Layout/register',[
            'title' => 'Form Register',
        ]);
    }

    public function register_action(Request $request)
    {
        // Validator
        $validate = Validator::make($request->all(),[
            'username' => 'required|min:5',
            'password' => 'required'
        ]);
        if($validate->fails()){
            return back()->withErrors($validate->errors());
        }
        $created = Users::create([
            "username" => $request->username,
            "password" => bcrypt($request->password)
        ]);
        if($created)
        {
            return to_route('login_form')->with('message','akun berhasil dibuat'); 
        }
        else
        {
            return to_route('login_form')->with('message','akun gagal dibuat'); 
        }
    }

}
