<?php

namespace App\Http\Controllers;

use App\Post;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Str;

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
        return view('posts.create', ['post' => new Post()]);
    }

    public function store(PostRequest $request)
    {
        $params = $request->all();

        // add title to the slug
        $params['slug'] = Str::slug(request('title'));
        // create new post
        Post::create($params);

        session()->flash('success', 'The post was created');

        return redirect('posts');
    }

    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

    public function update(PostRequest $request, Post $post)
    {            
        $params = $request->all();

        // create new post
        $post->update($params);
        
        session()->flash('success', 'The post was updated');

        return redirect('posts');
    }
}
