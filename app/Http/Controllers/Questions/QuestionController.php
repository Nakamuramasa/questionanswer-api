<?php

namespace App\Http\Controllers\Questions;

use App\Models\Question;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\QuestionResource;

class QuestionController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => ['required'],
            'body' => ['required', 'min:20', 'max:140'],
            'tags' => ['required']
        ]);

        $slug = Str::slug($request->title);

        $question = auth()->user()->questions()->create([
            'title' => $request->title,
            'slug' => $slug,
            'body' => $request->body
        ]);

        $question->retag($request->tags);

        return response()->json($question, 200);
    }

    public function update(Request $request, $id)
    {
        $question = Question::findOrFail($id);
        $this->authorize('update', $question);

        $this->validate($request, [
            'title' => ['required', 'unique:questions,title,'. $id],
            'body' => ['required', 'min:20', 'max:140'],
            'tags' => ['required']
        ]);

        $slug = Str::slug($request->title);

        $question->update([
            'title' => $request->title,
            'slug' => $slug,
            'body' => $request->body
        ]);

        $question->retag($request->tags);

        return new QuestionResource($question);
    }

    public function destroy($id)
    {
        $question = Question::findOrFail($id);
        $this->authorize('delete', $question);
        $question->delete();

        return response()->json(['message' => 'Record deleted'], 200);
    }
}
