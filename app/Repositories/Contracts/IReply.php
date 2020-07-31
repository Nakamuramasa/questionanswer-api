<?php

namespace App\Repositories\Contracts;

interface IReply
{
    public function like($id);
    public function isLikedByUser($id);
}
