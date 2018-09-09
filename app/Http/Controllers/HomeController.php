<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use App\Posts;
use App\Helpers\Slugger;

class HomeController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function home(){
        return view('homep');
    }

    public function post(Request $request){
        $validated = $request->validate([
            'blog_title' => 'required|',
            'blog_post' => 'required|',
            'blog_password' => 'required|'
        ]);
        
        //Generate slug 
        $slug = Slugger::slugit($validated['blog_title']);                
        $posts = new Posts;
        $posts->blog_title = $validated['blog_title'];
        $posts->blog_post = $validated['blog_post'];
        $posts->slug = $slug;
        $posts->password = $validated['blog_password'];
        if($posts->save()){
            $url = url('/'.$posts->id.'/'.$slug);            
            return redirect()->back()->with('message',['msg' => 'Success! Your blog has been posted!','url' => $url,'type' => 1]);
        } else {
            return redirect()->back()->with('message',['msg' => 'Aww :( An error occured im sorry :(','type' => 0]);
        }
    }


}

