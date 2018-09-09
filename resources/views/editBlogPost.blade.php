@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Post - {{$post->blog_title}}</div>

                <div class="card-body">
                @if (session('message'))                            
                            <div class="alert{{ session('message.type') ? ' alert-success' : ' alert-danger'}}">
                                {{ @session('message.msg') }}
                            </div>
                        @endif                
                    <form method="POST" action="{{ route('edit.blog.post', ['blog_id'=>$post->id,'blog_slug'=>$post->slug]) }}" aria-label="{{ __('Login') }}">
                        @csrf
                        <input type="hidden" name="blog_id" value="{{$post->id}}">
                        <div class="form-group row">
                            <label for="title" class="col-sm-4 col-form-label text-md-right">{{ __('Blog Title') }}</label>

                            <div class="col-md-6">
                                <input id="blog_title" type="text" class="form-control{{ $errors->has('blog_title') ? ' is-invalid' : '' }}" name="blog_title" value="{{ $post->blog_title }}" autofocus>

                                @if ($errors->has('blog_title'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('blog_title') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="blog_post" class="col-md-4 col-form-label text-md-right">{{ __('Blog Post') }}</label>

                            <div class="col-md-6">
                                <!--<input id="password" type="password" class="form-control{{ $errors->has('blog_post') ? ' is-invalid' : '' }}" name="password" required>-->
                                <textarea id="blog_post" class="form-control{{ $errors->has('blog_post') ? ' is-invalid' : '' }}" name="blog_post">{!! $post->blog_post !!}</textarea>
                                
                                @if ($errors->has('blog_post'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('blog_post') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Save') }}
                                </button>

                            </div>
                        </div>
                    </form>
                </div>
            </div>

           
        </div>
    </div>
</div>
@endsection
