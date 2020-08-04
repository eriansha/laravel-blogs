<?php

namespace App\Services;

use App\Post;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
     * Create a post
     * 
     * @param PostRequest $params
     * 
     * @return Post
     */
    public function createPost($params)
    {
      // create slug by title
      $slug = Str::slug($params['title']);

      // set thumbnail if any
      $thumbnail = request()->file('thumbnail') ? request()->file('thumbnail')->store('images/posts') : null;

      // add fields to $params
      $params['slug'] = $slug;
      $params['category_id'] = request('category');
      $params['thumbnail'] = $thumbnail;

      // create new post
      $post = auth()->user()->posts()->create($params);
      $post->tags()->attach($params['tags']);
    }

    public function editPost(Post $post, $params)
    {
        // set thumbnail with current thumbnail  
        // $thumbnail = $post->thumbnail;

        // // delete current thumbnail if there's a new one
        // if ($params['thumbnail'])
        // {
        //     Storage::delete($post->thumbnail);
        //     $thumbnail =  request()->file('thumbnail')->store('images/posts');
        // }
        
        // $params['category_id'] = request('category');
        // $params['thumbnail'] = $thumbnail;

        // // create new post
        // $post->update($params);
        // $post->tags()->sync(request('tags'));
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
