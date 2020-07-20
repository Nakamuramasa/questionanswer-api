<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentTaggable\Taggable;

class Question extends Model
{
    use Taggable;

    protected $fillable = ['user_id', 'title', 'slug', 'body'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function replies()
    {
        return $this->morphMany(Reply::class, 'repliable')
                ->orderBy('created_at', 'asc');
    }
}
