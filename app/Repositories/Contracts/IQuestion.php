<?php

namespace App\Repositories\Contracts;

interface IQuestion
{
    public function applyTags($id, array $data);
    public function addReply($questionId, array $data);
}
