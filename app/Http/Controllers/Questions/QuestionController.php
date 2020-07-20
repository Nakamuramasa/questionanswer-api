<?php

namespace App\Http\Controllers\Questions;

use App\Models\Question;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\QuestionResource;
use App\Repositories\Contracts\IQuestion;
use App\Repositories\Eloquent\Criteria\{
    LatestFirst,
    ForUser,
    EagerLoad
};

class QuestionController extends Controller
{
    protected $questions;

    public function __construct(IQuestion $questions)
    {
        $this->questions = $questions;
    }

    public function index()
    {
        $questions = $this->questions->withCriteria([
            new LatestFirst,
            // new ForUser(1),
            new EagerLoad(['user', 'replies'])
        ])->all();
        return QuestionResource::collection($questions);
    }

    public function findQuestion($id)
    {
        $question = $this->questions->find($id);
        return new QuestionResource($question);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => ['required'],
            'body' => ['required', 'min:20', 'max:140'],
            'tags' => ['required']
        ]);

        $slug = Str::slug($request->title);

        $question = $this->questions->create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'slug' => $slug,
            'body' => $request->body
        ]);

        $question->retag($request->tags);

        return response()->json($question, 200);
    }

    public function update(Request $request, $id)
    {
        $question = $this->questions->find($id);
        $this->authorize('update', $question);

        $this->validate($request, [
            'title' => ['required', 'unique:questions,title,'. $id],
            'body' => ['required', 'min:20', 'max:140'],
            'tags' => ['required']
        ]);

        $slug = Str::slug($request->title);

        $question = $this->questions->update($id, [
            'title' => $request->title,
            'slug' => $slug,
            'body' => $request->body
        ]);

        $this->questions->applyTags($id, $request->tags);

        return new QuestionResource($question);
    }

    public function destroy($id)
    {
        $question = $this->questions->find($id);
        $this->authorize('delete', $question);
        $this->questions->delete($id);

        return response()->json(['message' => 'Record deleted'], 200);
    }
}
