<?php

namespace App\Services;

use App\Category;

class CategoryService
{
    /**
     * Get all tags
     * 
     * @return Array
     */
    public function getAll()
    {
      return Category::get();
    }
  
    /**
     * Get all Posts by total page
     * 
     * @param Category $category
     * @param Integer $$limmit
     * 
     * @return Array
     */
    public function getPosts(Category $category, $limit)
    {
      return $category->posts()
                      ->latest()
                      ->paginate($limit);
    }
}
