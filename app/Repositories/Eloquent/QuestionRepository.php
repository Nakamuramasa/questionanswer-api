<?php

namespace App\Repositories\Eloquent;

use App\Models\Question;
use App\Repositories\Contracts\IQuestion;
use App\Repositories\Eloquent\BaseRepository;

class QuestionRepository extends BaseRepository implements IQuestion
{
    public function model()
    {
        return Question::class;
    }

    public function applyTags($id, array $data)
    {
        $question = $this->find($id);
        $question->retag($data);
    }

    public function addReply($questionId, array $data)
    {
        $question = $this->find($questionId);
        $reply = $question->replies()->create($data);

        return $reply;
    }

    public function like($id)
    {
        $question = $this->model->findOrFail($id);
        if($question->isLikedByUser(auth()->id())){
            $question->unlike();
        }else{
            $question->like();
        }

        return $question->likes()->count();
    }

    public function isLikedByUser($id)
    {
        $question = $this->model->findOrFail($id);
        return $question->isLikedByUser(auth()->id());
    }
}
