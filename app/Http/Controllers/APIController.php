<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use App\Posts;
use App\Comments;


class APIController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function castVote(Request $request){
        $blog_id = $request->input('blog_id');
        if(!$blog_id) return response('Invalid resource',404);
        
        $allowed = ['upvote','downvote','removeupvote','removedownvote'];
        
        $post = Posts::find($blog_id);
        if(!$post) return response('Invalid resource',404);
        
        $voteType = $request->input('voteType');
        if(!in_array($voteType,$allowed)) return response('Invalid resource',404);
        
        switch($voteType){
            case('upvote'):
                $post->blog_upvotes += 1;                
            break;

            case('downvote'):
                $post->blog_downvotes += 1;
            break;

            case('removeupvote'):
                $post->blog_upvotes -= 1;
            break;

            case('removedownvote'):
                $post->blog_downvotes -= 1;
            break;
        }
        $upvotes = $post->blog_upvotes;
        $downvotes = $post->blog_downvotes;
        $post->save();        
        
        return response()->json([
           'upvotes' => $upvotes, 'downvotes' => $downvotes
       ]);
    }
}