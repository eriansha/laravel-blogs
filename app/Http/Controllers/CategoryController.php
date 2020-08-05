<?php

namespace App\Http\Controllers;

use App\Category;
use App\Services\CategoryService;

class CategoryController extends Controller
{
    /**
     * @var CategoryService
     */
    protected $categoryService;
    
    /**
     * PostController Constructor
     *
     * @param CategoryService $postService
     *
     */
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * Show category and related posts
     * 
     * @param Category $category
     * 
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        $posts = $this->categoryService->getPosts($category, 6);
        return view('posts.index', compact('posts', 'category'));
    }
}
