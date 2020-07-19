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
}
