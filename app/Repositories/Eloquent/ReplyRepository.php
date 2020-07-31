<?php

namespace App\Repositories\Eloquent;

use App\Models\Reply;
use App\Repositories\Contracts\IReply;
use App\Repositories\Contracts\IQuestion;

class ReplyRepository extends BaseRepository implements IReply
{
    public function model()
    {
        return Reply::class;
    }

    public function like($id)
    {
        $reply = $this->model->findOrFail($id);
        if($reply->isLikedByUser(auth()->id())){
            $reply->unlike();
        }else{
            $reply->like();
        }

        return $reply->likes()->count();
    }

    public function isLikedByUser($id)
    {
        $reply = $this->model->findOrFail($id);
        return $reply->isLikedByUser(auth()->id());
    }
}
