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

    public function postComment(Request $request){
        $blog_id = $request->input('blog_id');
        if(!$blog_id) return response('Invalid resource',404);

        $new_comment = $request->input('comment');
        if(!$new_comment) return response('Invalid resource',404);

        $post = Posts::find($blog_id);
        if(!$post) return response('Invalid resource',404);

        $comment = new Comments;
        $comment->blog_id = $blog_id;
        $comment->blog_comment = $new_comment;

        if(!$comment->save()) return response('Unexpected error',404);
        return response('All ok',200);
    }

    public function getComments(Request $request,$blog_id){        
        if(!$blog_id) return response('Invalid resource 2', 404);
        $blog = Posts::find($blog_id);
        if(!$blog) return response('Invalid resource 1',404);

        $comments = Comments::where('blog_id',1)->orderBy('id','desc')->Simplepaginate(5);
        $extra = collect(['hasPages' => $comments->hasPages()]);
        $response = $extra->merge($comments);
        return response()->json($response);
    }

    public function getPosts(Request $request){
        $posts = Posts::paginate(15);
        return response()->json($posts);
    }

    public function genPosts(){
        for($i = 8; $i<49; $i++){
            $post = new Posts;
            $post->blog_title = "{$i}th post mofo";
            $post->blog_post = "GAGA OOGAGA YAMAM YAMAMAM";
            $post->slug = 'nobody cares';
            $post->password = '123456';
            $post->save();
        }
    }
}