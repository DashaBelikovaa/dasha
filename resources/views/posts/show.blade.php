@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $post->title }}</h1>
    <p>{{ $post->content }}</p>
    <p><small class="text-muted">Автор: {{ $post->user->name }} | {{ $post->created_at->diffForHumans() }}</small></p>

    <hr>

    <h2>Комментарии</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @auth
    <form action="{{ route('comments.store', $post->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="content">Добавить комментарий</label>
            <textarea name="content" id="content" class="form-control" rows="3" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Отправить</button>
    </form>
    @else
    <div class="alert alert-info">
        Вы должны быть авторизованы для создания комментариев. <a href="{{ route('login') }}">Войти</a>
    </div>
    @endauth

    <hr>

    @foreach($post->comments as $comment)
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">{{ $comment->user->name }}</h5>
                <p class="card-text">{{ $comment->content }}</p>
                <p class="card-text"><small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small></p>
                @if(Auth::check() && (Auth::id() == $comment->user_id || Auth::user()->isAdmin()))
                    <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Удалить</button>
                    </form>
                @endif
            </div>
        </div>
    @endforeach
</div>
@endsection