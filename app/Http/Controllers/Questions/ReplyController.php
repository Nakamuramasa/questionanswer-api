<?php

namespace App\Http\Controllers\Questions;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ReplyResource;
use App\Repositories\Contracts\IReply;
use App\Repositories\Contracts\IQuestion;

class ReplyController extends Controller
{
    protected $replies;
    protected $questions;

    public function __construct(IReply $replies, IQuestion $questions)
    {
        $this->replies = $replies;
        $this->questions = $questions;
    }

    public function store(Request $request, $questionId)
    {
        $this->validate($request, [
            'body' => ['required']
        ]);

        $reply = $this->questions->addReply($questionId, [
            'body' => $request->body,
            'user_id' => auth()->id()
        ]);

        return new ReplyResource($reply);
    }

    public function update(Request $request, $id)
    {
        $reply = $this->replies->find($id);
        $this->authorize('update', $reply);

        $this->validate($request, [
            'body' => ['required']
        ]);

        $reply = $this->replies->update($id, [
            'body' => $request->body
        ]);

        return new ReplyResource($reply);
    }

    public function destroy($id)
    {
        $reply = $this->replies->find($id);
        $this->authorize('delete', $reply);

        $this->replies->delete($id);

        return response()->json(['message' => 'Reply deleted'], 200);
    }

    public function like($id){
        $total = $this->replies->like($id);
        return response()->json([
            'message' => 'Successful',
            'total' => $total
        ], 200);
    }

    public function checkIfUserHasLiked($replyId)
    {
        $isLiked = $this->replies->isLikedByUser($replyId);
        return response()->json(['liked' => $isLiked], 200);
    }
}
