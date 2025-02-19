<?php

namespace App\Http\Controllers;

use App\Http\Middleware\CommentOwner;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'post_id' => 'required|exists:posts,id',
            'comment_content' => 'required',
        ]);

        $request['user_id'] = auth()->user()->id;
        // dd($request);
        $comment = Comment::create($request->all());

        // return response()->json($comment->loadMissing(['Commentator']));
        return new CommentResource($comment->loadMissing(['Commentator:id,username']));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'comment_content' => 'required',
        ]);

        $comment = Comment::find($id);
        $comment->comment_content = $request->comment_content;
        $comment->save();
        // $comment = Comment::update($request->only('comment_content'));
        return new CommentResource($comment->loadMissing(['Commentator:id,username']));
    }

    public function delete($id)
    {
        $comment = Comment::find($id);
        $comment->delete();

        return new CommentResource($comment->loadMissing(['Commentator:id,username']));
    }
}
