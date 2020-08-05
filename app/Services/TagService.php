<?php

namespace App\Services;

use App\Tag;

class TagService
{
    /**
     * Get all Posts by total page
     * 
     * @param Tag $tag
     * @param Integer $$limmit
     * 
     * @return Array
     */
    public function getPosts(Tag $tag, $limit)
    {
      return $tag->posts()
                 ->latest()
                 ->paginate($limit);
    }
}
