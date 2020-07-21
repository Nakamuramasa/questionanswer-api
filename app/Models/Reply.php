<?php

namespace App\Models;

use App\Models\Traits\Likeable;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use Likeable;

    protected $fillable = ['body', 'user_id'];

    public function repliable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
