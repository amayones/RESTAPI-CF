<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\PostDetailResource;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();

        // return response()->json(['data' => $posts]);
        return PostDetailResource::collection($posts->loadMissing([
            'Writer:id,username',
            'Comment:id,post_id,user_id,comment_content'
        ]));
    }

    public function show($id)
    {
        $post = Post::find($id);

        return new PostDetailResource($post->loadMissing([
            'Writer:id,username',
            'Comment:id,post_id,user_id,comment_content'
        ]));
    }

    public function create(Request $request)
    {
        // return $request->file;
        $request->validate([
            'title' => 'required',
            'news_content' => 'required'
        ]);

        $image = null;
        if ($request->file) {
            $fileName = $this->generateRandomString();
            $extension = $request->file->extension();
            $image = $fileName . '.' . $extension;

            Storage::putFileAs('image', $request->file, $image);
        }

        $request['image'] = $image;
        $request['author_id'] = Auth::user()->id;
        // dd($request['author_id']);
        $post = Post::create($request->all());
        // dd($post);
        return new PostDetailResource($post->loadMissing('Writer:id,username'));
    }

    public function update(Request $request, $id)
    {
        // dd('ini method update');
        $request->validate([
            'title' => 'required',
            'news_content' => 'required'
        ]);

        $post = Post::findOrFail($id);
        $post->update($request->all());

        return new PostDetailResource($post->loadMissing('Writer:id,username'));
    }

    public function delete($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return new PostDetailResource($post->loadMissing('Writer:id,username'));
    }

    function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }

        return $randomString;
    }
}
