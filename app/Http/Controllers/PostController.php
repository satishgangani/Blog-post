<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    protected $tags;

    public function __construct()
    {
        $this->tags = Tag::orderBy('title')->get();
    }
    /**
     * Display a specific post.
     */
    public function index($post)
    {
        $post = Post::where('id', decrypt($post))->first();
        return view('posts.index', compact('post'));
    }

    /**
     * Redirect to post create page.
     */
    public function create(Request $request)
    {
        $tags = $this->tags;
        return view('posts.add',compact('tags'));
    }

    /**
     * Store a newly created post in database.
     */
    public function store(PostRequest $request)
    {
        $tags = [];
        $request->validated();
        foreach($request->tags as $tag){
            array_push($tags, decrypt($tag));
        }
        try{
            Post::create([
                'title' => $request->title,
                'description' => $request->description,
                'tags' => $tags,
                'author_id' => Auth::user()->id,
                'post_date' => $request->post_date,
            ]);
            return redirect()->route('home')->withSuccess(['New post added.']);
        }
        catch(\Exception $e){
            return redirect()->back()->withErrors([$e->getMessage()]);
        }
    }

    /**
     * Show the form for editing the specified post.
     */
    public function edit($post)
    {
        try{
            $post = Post::find(decrypt($post));
            $tags = $this->tags;
            return view('posts.edit',compact('post','tags'));
        }
        catch(\Exception $e){
            return redirect()->back()->withErrors([$e->getMessage()]);
        }
        
    }

    /**
     * Update the specified post in database.
     */
    public function update(PostRequest $request)
    {
        $tags = [];
        $request->validated();
        foreach($request->tags as $tag){
            array_push($tags, decrypt($tag));
        }
        try{
            $post = Post::where('id', decrypt($request->post))->first();
            if($post->author_id == Auth::user()->id){
                $post->update([
                    'title' => $request->title,
                    'description' => $request->description,
                    'tags' => $tags,
                    'post_date' => $request->post_date,
                ]);
            }
            return redirect()->route('home')->withSuccess(['Post Updated.']);
        }
        catch(\Exception $e){
            return redirect()->back()->withErrors([$e->getMessage()]);
        }
    }

    /**
     * Remove the specified post from database if no comments are given.
     */
    public function destroy($post)
    {
        try{
            $post = Post::find(decrypt($post));
            if($post->comments->count() == 0){
                $post->delete();
            }
            return redirect()->route('home')->withSuccess(['Post deleted successfully.']);
        }
        catch(\Exception $e){
            return redirect()->back()->withErrors([$e->getMessage()]);
        }
    }
}
