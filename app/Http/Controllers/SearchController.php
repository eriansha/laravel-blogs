<?php

namespace App\Http\Controllers;

use App\Post;
use App\Services\PostService;

class SearchController extends Controller
{
    /**
     * @var postService
     */
    protected $postService;
    
    /**
     * SearchController Constructor
     *
     * @param PostService $postService
     *
     */
    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    /**
     * Search posts
     * 
     * @return \Illuminate\Http\Response
     */
    public function posts()
    {
        $query = request("query");
        $posts = $this->postService->searchByQuery($query, 10);
        return view('posts.index', compact('posts'));
    }
}
