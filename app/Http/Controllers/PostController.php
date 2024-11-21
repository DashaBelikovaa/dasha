<?php
namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('user')->latest()->get();
        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        if (!Auth::user()->isAdmin()) {
            return redirect()->route('posts.index')->with('error', 'Только администраторы могут создавать посты.');
        }

        $categories = Category::all();
        $tags = Tag::all();
        return view('posts.create', compact('categories', 'tags'));
    }

    public function store(Request $request)
    {
        if (!Auth::user()->isAdmin()) {
            return redirect()->route('posts.index')->with('error', 'Только администраторы могут создавать посты.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ]);

        $post = new Post([
            'user_id' => Auth::id(),
            'category_id' => $request->category_id,
            'title' => $request->title,
            'content' => $request->content,
        ]);

        $post->save();

        if ($request->has('tags')) {
            $post->tags()->sync($request->tags);
        }

        return redirect()->route('posts.index')->with('success', 'Пост успешно создан.');
    }

    public function show($id)
    {
        $post = Post::with('user', 'comments.user')->findOrFail($id);
        return view('posts.show', compact('post'));
    }

    public function edit($id)
    {
        if (!Auth::user()->isAdmin()) {
            return redirect()->route('posts.index')->with('error', 'Только администраторы могут редактировать посты.');
        }

        $post = Post::findOrFail($id);
        $categories = Category::all();
        $tags = Tag::all();
        return view('posts.edit', compact('post', 'categories', 'tags'));
    }

    public function update(Request $request, $id)
    {
        if (!Auth::user()->isAdmin()) {
            return redirect()->route('posts.index')->with('error', 'Только администраторы могут редактировать посты.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ]);

        $post = Post::findOrFail($id);
        $post->title = $request->title;
        $post->content = $request->content;
        $post->category_id = $request->category_id;
        $post->save();

        if ($request->has('tags')) {
            $post->tags()->sync($request->tags);
        } else {
            $post->tags()->detach();
        }

        return redirect()->route('posts.index')->with('success', 'Пост успешно обновлен.');
    }

    public function destroy($id)
    {
        if (!Auth::user()->isAdmin()) {
            return redirect()->route('posts.index')->with('error', 'Только администраторы могут удалять посты.');
        }

        $post = Post::findOrFail($id);
        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Пост успешно удален.');
    }
}