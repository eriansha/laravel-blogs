<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::paginate(6);
        return view('posts.index', compact('posts'));
    }
    
    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store()
    {
        // validate the fields
        $params = request()->validate([
            'title' => 'required|min:3',
            'body' => 'required'
        ]);

        // add title to the slug
        $params['slug'] = Str::slug(request('title'));
        // create new post
        Post::create($params);

        return back();
    }
}
