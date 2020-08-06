<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'slug', 'body', 'category_id', 'thumbnail'];

    /**
     * associating all the related model with Post.
     *
     * @var array
     */
    protected $with = ['author', 'category', 'tags'];

    /**
     * Category association
     * 
     * @return Category
     */
    public function category()
    {
      return $this->belongsTo(Category::class);
    }

    /**
     * Tag association
     * 
     * @return Tag
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * User association
     * 
     * @return User
     */
    public function author()
    {
      return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Getter customize thumbnnail with '/storage/' prefix path
     * 
     * @return String
     */
    public function getTakeImageAttribute()
    {
      return "/storage/" . $this->thumbnail;
    }

    /**
     * Getter customize tags id from Post
     * 
     * @return Collection
     */
    public function getTagIdsAttribute()
    {
      return $this->tags->pluck('id');
    }
}
