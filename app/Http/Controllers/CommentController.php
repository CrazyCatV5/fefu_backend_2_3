<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    private const PAGE_SIZE = 5;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Post $post) : JsonResponse
    {
        $comments = $post->comments()->with('user')->ordered()->paginate(self::PAGE_SIZE);
        return response()->json(CommentResource::collection($comments));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Post $post) : JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'text' => 'required|max:200',
        ]);

        if ($validator->fails())
            return response()->json(['errors' => $validator->errors()->all()], 422);

        $comment = new Comment();
        $comment->text = $validator->validated()['text'];
        $comment->user_id = User::inRandomOrder()->first()->id;
        $comment->post_id = $post->id;
        $comment->save();

        return response()->json(new CommentResource($comment), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post, Comment $comment)  : JsonResponse
    {
        return response()->json(new CommentResource($comment));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Post $post, Request $request, Comment $comment) : JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'text' => 'required|max:200',
        ]);

        if ($validator->fails())
            return response()->json(['errors' => $validator->errors()->all()], 422);

        $comment->text = $validator->validated()['text'];
        $comment->save();

        return response()->json(new CommentResource($comment));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post, Comment $comment) : JsonResponse
    {
        $comment->delete();
        return response()->json(['message' => 'Comment removed successfully']);
    }
}
