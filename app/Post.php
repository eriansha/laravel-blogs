<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['title', 'slug', 'body'];

    public function category()
    {
      return $this->belongsTo(Category::class);
    }

    public function scopeLatestFirst()
    {
      return $this->latest()->first();
    }

    public function scopeLatestPost()
    {
      return $this->latest()->get();
    }
}
