@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            <div class="card">
                <div class="card-header">{{ $post->blog_title }}</div>

                <div class="card-body">
                {!! $post->blog_post !!}
                </div>
                <vote-component blog_id = "{{ $post->id }}" upvotes="{{$post->blog_upvotes}}" downvotes="{{$post->blog_downvotes}}"/>
            </div>
                        
            <comment-component blog_id="{{$post->id}}"/> 
           
            <div class='card'>
                <div class='card-header'>Comments</div>
                <div class='card-body'>
                    Comments here
                </div>
            </div>           
        
        </div>
    </div>
</div>
@endsection
