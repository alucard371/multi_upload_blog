<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\PostImage;
use App\Comment;
use Auth;
use Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::with('post_images')->orderBy('created_at', 'desc')->get();
        $postsComments = Post::with('comments')->orderBy('created_at', 'desc')->get();
        return response()->json(['error' => false, 'posts' => $posts, 'postsComments' => $postsComments]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('post.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $title = $request->title;
        $body = $request->body;
        $images = $request->images;

        //creating post
        $post = Post::create([
        'title' => $title,
        'body' => $body,
        'user_id' => $user->id,
        ]);

        //storing images
        foreach($images as $image)
        {
            $imagepath = Storage::disk('uploads')->put($user->email.'/posts', $image);
            PostImage::create([
                'post_image_caption' => $title,
                'post_image_path' => '/uploads'.$imagepath,
                'post_id' => $post->id
            ]);
        }

        return response()->json(['error' => false, 'data' => $post]);


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
