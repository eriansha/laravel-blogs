<?php

namespace App\Http\Controllers;

use App\{Post, Category, Tag};
use App\Services\PostService;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * @var postService
     */
    protected $postService;
    
    /**
     * PostController Constructor
     *
     * @param PostService $postService
     *
     */
    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('posts.index', ['posts' => $this->postService->getIndex(6)]);
    }
    
    /**
     * Show a single post and suggested other posts that have same category
     * 
     * @param Post $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        $posts = $this->postService->getByCategory($post->category_id, 6);
        return view('posts.show', compact('post', 'posts'));
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
        $slug = Str::slug(request('title'));

        $thumbnail = request()->file('thumbnail') ? request()->file('thumbnail')->store('images/posts') : null;

        // add fields to $params
        $params['slug'] = $slug;
        $params['category_id'] = request('category');
        $params['thumbnail'] = $thumbnail;

        // create new post
        $post = auth()->user()->posts()->create($params);
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
        $this->authorize('update', $post);

        // delete current thumbnail if there's a new one
        if (request()->file('thumbnail'))
        {
            \Storage::delete($post->thumbnail);
            $thumbnail =  request()->file('thumbnail')->store('images/posts');
        }
        // set thumbnail with current thumbnail
        else
        {
            $thumbnail = $post->thumbnail;
        }
        
        $params = $request->all();
        $params['category_id'] = request('category');
        $params['thumbnail'] = $thumbnail;

        // create new post
        $post->update($params);
        $post->tags()->sync(request('tags'));
        
        session()->flash('success', 'The post was updated');

        return redirect('posts');
    }

    /**
     * Delete single post
     * 
     * @param Post $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        if (auth()->user()->is($post->author))
        {
            $this->postService->deletePost($post);
            
            session()->flash('success', 'The post was deleted');
            return redirect('posts');
        }
        else
        {
            session()->flash('error', 'It was not your post');
            return redirect('posts');
        }
    }
}
