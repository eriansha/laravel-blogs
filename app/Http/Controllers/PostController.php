<?php

namespace App\Http\Controllers;

use App\{Post, Category, Tag};
use App\Services\PostService;
use App\Http\Requests\PostRequest;

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
        return view('posts.index', ['posts' => $this->postService->getPosts(6)]);
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

    /**
     * Display create page
     * 
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create', [
            'post' => new Post(),
            'categories' => Category::get(),
            'tags' => Tag::get()
        ]);
    }

    /**
     * Create a post
     * 
     * @param PostRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        $this->postService->createPost($request->all());
        session()->flash('success', 'The post was created');

        return redirect('posts');
    }

    /**
     * Display edit page
     * 
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('posts.edit', [
            'post' => $post,
            'categories' => Category::get(),
            'tags' => Tag::get()
        ]);
    }

    /**
     * Update a single post with new value
     * 
     * @param PostRequest $request
     * @param Post $post
     * 
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, Post $post)
    {            
        $this->authorize('update', $post);
        $this->postService->editPost($post, $request->all());
        
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
