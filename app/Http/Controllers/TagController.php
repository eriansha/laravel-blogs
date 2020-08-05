<?php

namespace App\Http\Controllers;

use App\Tag;
use App\Services\TagService;

class TagController extends Controller
{
    /**
     * @var TagService
     */
    protected $tagService;
    
    /**
     * PostController Constructor
     *
     * @param TagService $postService
     *
     */
    public function __construct(TagService $tagService)
    {
        $this->tagService = $tagService;
    }

    /**
     * Show tag and related posts
     * 
     * @param Tag $tag
     * 
     * @return \Illuminate\Http\Response
     */
    public function show(Tag $tag)
    {
        $posts = $this->tagService->getPosts($tag, 6);
        return view('posts.index', compact(['tag', 'posts']));
    }
}
