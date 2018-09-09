@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Post - {{ $post->blog_title }}</div>

                <div class="card-body">
                @if (session('message'))                            
                            <div class="alert{{ session('message.type') ? ' alert-success' : ' alert-danger'}}">
                                {{ @session('message.msg') }}
                            </div>
                        @endif                
                    <form method="POST" action="{{ route('edit.prompt.post',['id' => $post->id,'slug'=>$post->slug]) }}" aria-label="{{ __('Blog Password') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="title" class="col-sm-4 col-form-label text-md-right">{{ __('Blog Password') }}</label>

                            <div class="col-md-6">
                                <input id="blog_id" name="blog_id" type="hidden" value="{{$post->id}}">
                                <input id="blog_password" type="password" class="form-control{{ $errors->has('blog_password') ? ' is-invalid' : '' }}" name="blog_password" value="{{ old('blog_title') }}" autofocus>

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
                                    {{ __('Submit password') }}
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
