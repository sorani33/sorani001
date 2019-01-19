<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Tag;


class TagBoardController extends Controller
{
    public function index () {
        $posts = Post::all();
        $tags = Tag::all();

        $hash = array(
            'posts' => $posts,
            'tags' => $tags
        );

        return view('tagboard')->with($hash);
    }


    public function submit () {
      $post = new Post();

      // postTへ登録
      $post->body = request()->body;
      $post->save();

      // post_tagT（$post->tags()）へ登録
      $post->tags()->attach(request()->tags);

      return redirect('tagboard');
    }

}
