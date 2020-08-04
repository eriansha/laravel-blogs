<?php

namespace App\Services;

use App\Post;
use Illuminate\Support\Facades\Storage;

class PostService
{
    /**
     * Get all Posts by total page
     * 
     * @param Integer $totalPage
     * @return Array
     */
    public function getPosts($totalPage)
    {
      return Post::latest()->paginate($totalPage);
    }

    /**
     * Get posts by category
     * 
     * @param Integer $categoryId
     * @param Integer $limit
     * 
     * @return Array
     */
    public function getByCategory($categoryId, $limit)
    {
      return Post::where('category_id', $categoryId)
                 ->latest()
                 ->limit($limit)
                 ->get();
    }

    /**
     * Delete post, including the image in the public drive
     * 
     * @param Post $post
     * 
     * @return Post
     */
    public function deletePost($post)
    {
      Storage::delete($post->thumbnail);
      $post->tags()->detach();
      $post->delete();

      return $post;
    }
}
