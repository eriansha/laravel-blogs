<?php

namespace App\Http\Controllers;

use App\{Post, Category, Tag};
use App\Http\Requests\PostRequest;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::latest()->paginate(6);
        return view('posts.index', compact('posts'));
    }
    
    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    public function create()
    {
        return view('posts.create', [
            'post' => new Post(),
            'categories' => Category::get(),
            'tags' => Tag::get()
        ]);
    }

    public function store(PostRequest $request)
    {
        $params = $request->all();

        // add title to the slug
        $params['slug'] = Str::slug(request('title'));
        $params['category_id'] = request('category');

        // create new post
        $post = Post::create($params);
        $post->tags()->attach(request('tags'));

        session()->flash('success', 'The post was created');

        return redirect('posts');
    }

    public function edit(Post $post)
    {
        return view('posts.edit', [
            'post' => $post,
            'categories' => Category::get(),
            'tags' => Tag::get()
        ]);
    }

    public function update(PostRequest $request, Post $post)
    {            
        $params = $request->all();
        $params['category_id'] = request('category');

        // create new post
        $post->update($params);
        $post->tags()->sync(request('tags'));
        
        session()->flash('success', 'The post was updated');

        return redirect('posts');
    }

    public function destroy(Post $post)
    {
        $post->tags()->detach();
        $post->delete();
        session()->flash('success', 'The post was deleted');
        return redirect('posts');
    }
}
