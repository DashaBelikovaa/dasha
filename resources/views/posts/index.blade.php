@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Форум</h1>

    <a href="{{ route('posts.create') }}" class="btn btn-primary">Создать пост</a>

    <hr>

    @foreach($posts as $post)
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title"><a href="{{ route('posts.show', $post->id) }}">{{ $post->title }}</a></h5>
                <p class="card-text">{{ Str::limit($post->content, 200) }}</p>
                <p class="card-text"><small class="text-muted">Автор: {{ $post->user->name }} | {{ $post->created_at->diffForHumans() }}</small></p>
            </div>
        </div>
    @endforeach
</div>
@endsection