@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Create a blog') }}</div>

                <div class="card-body">
                @if (session('message'))                            
                            <div class="alert{{ session('message.type') ? ' alert-success' : ' alert-danger'}}">
                                {{ @session('message.msg') }}
                               @if( @session('message.url'))
                                    <a href='{{session("message.url")}}'>See it here!</a>
                               @endif
                            </div>
                        @endif                
                    <form method="POST" action="{{ route('home.post') }}" aria-label="{{ __('Login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="title" class="col-sm-4 col-form-label text-md-right">{{ __('Blog Title') }}</label>

                            <div class="col-md-6">
                                <input id="blog_title" type="text" class="form-control{{ $errors->has('blog_title') ? ' is-invalid' : '' }}" name="blog_title" value="{{ old('blog_title') }}" autofocus>

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
                                <textarea id="blog_post" class="form-control{{ $errors->has('blog_post') ? ' is-invalid' : '' }}" name="blog_post"></textarea>
                                
                                @if ($errors->has('blog_post'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('blog_post') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="blog_post" class="col-md-4 col-form-label text-md-right">{{ __('Edit Password') }}</label>

                            <div class="col-md-6">
                                <input id="blog_password" type="password" class="form-control{{ $errors->has('blog_password') ? ' is-invalid' : '' }}" name="blog_password" >
                                
                                
                                @if ($errors->has('blog_password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('blog_password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>                        


                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Post') }}
                                </button>

                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <posts-component />
        </div>
    </div>
</div>
@endsection
