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
use App\Helpers\Slugger;

class BlogController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function view($id,$slug){
        $post = Posts::where('id',$id)->get()->first();
        if(!$post) abort(404);
        $comments = Comments::where('blog_id',$id)->get();
        return view('blog',['post' => $post,'comments' => $comments]);
    }

    public function editPrompt($id,$slug){
        $post = Posts::where('id',$id)->get()->first();
        if(!$post) abort(404);
        return view('editPrompt',['post' => $post]);
    }

    public function editPromptPost(Request $request){
        $validated = $request->validate([
            'blog_password' => 'required',
            'blog_id' => 'required'
        ]);
        $post = Posts::where('id',$validated['blog_id'])->get()->first();        
        if($validated['blog_password'] != $post->password){
            return redirect()->back()->with('message',['type'=>0,'msg'=>'Invalid password']);
        }
        return redirect(URL::temporarySignedRoute(
            'edit.blog',
            now()->addMinutes(30),
            ['blog_id'=>$post->id,'blog_slug'=>$post->slug]));

    }

    public function editBlog(Request $request, $id,$slug){
        if(!$request->hasValidSignature()) {
           abort(404);
        }
        if(!isset($_SESSION['allowed_edit'])) $_SESSION['allowed_edit'] = [];
        //store it in session so FORM Submit is secure from curious users as well        
        if(!in_array($id,$_SESSION['allowed_edit'])) $_SESSION['allowed_edit'][] = $id;

        $post = Posts::where('id',$id)->get()->first();
        return view('editBlogPost',['post'=>$post]);               
    }

    public function editBlogPost(Request $request){
        
        //Validate if session has edit id in there  
        $validated = $request->validate([
            'blog_title' => 'required',
            'blog_post' => 'required',
            'blog_id' => 'required'
        ]);
        if(!in_array($id,$_SESSION['allowed_edit'])) abort(404);
        $post = Posts::find($validated['blog_id']);
        $post->blog_title = $validated['blog_title'];
        $post->blog_post = $validated['blog_post'];
        $slug = Slugger::slugit($validated['blog_title']);
        $post->slug = $slug;
        if($post->save()){
            return redirect()->route('blog.view',
                [
                    'blog_id' => $validated['blog_id'],'blog_slug'=>$slug 
                ]
            );
        } else {
           return redirect()->back()->with('message',['msg' => 'Aww :( An unexpected error occured', 'type' => 0]);
        }
    }

}