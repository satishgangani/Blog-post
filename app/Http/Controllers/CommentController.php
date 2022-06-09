<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'comment' => 'required',
            'post' => 'required',
        ]);
        
        try{
            $comment = Comment::create([
                'post_id' => decrypt($request->post),
                'user_id' => Auth::user()->id,
                'comment' => $request->comment,
            ]);
            return response()->json(['comment' => $comment->comment,'user' => Auth::user()->name], 200);
        }
        catch(\Exception $e){
            return redirect()->back()->withErrors([$e->getMessage()]);
        }
    }
}
