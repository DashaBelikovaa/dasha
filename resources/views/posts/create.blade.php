@extends('layouts.app')

@section('content')
<div class="container">
    @auth
        <h1>Создать пост</h1>

        <form action="{{ route('posts.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="title">Заголовок</label>
                <input type="text" name="title" id="title" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="category_id">Категория</label>
                <select name="category_id" id="category_id" class="form-control" required>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="tags">Теги</label>
                <select name="tags[]" id="tags" class="form-control" multiple>
                    @foreach($tags as $tag)
                        <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="content">Содержание</label>
                <textarea name="content" id="content" class="form-control" rows="10" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Создать</button>
        </form>
    @else
        <div class="alert alert-danger">
            Вы должны быть авторизованы для создания поста.
        </div>
        <a href="{{ route('login') }}" class="btn btn-primary">Войти</a>
    @endauth
</div>
@endsection