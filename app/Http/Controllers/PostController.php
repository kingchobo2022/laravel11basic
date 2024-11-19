<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{ 
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::paginate(3);
        return view('posts.index', compact( 'posts')); // ['posts' => $posts]
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->check()) {
            return to_route('login');
        }
        return view('posts.create'); // 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'min:3', 'max:255'],
            'content' => ['required', 'min:5'],
            'photo' => ['required', 'image'],
        ]);

        $validated['photo'] = $request->file('photo')->store('photos');

        auth()->user()->posts()->create($validated);

        return to_route('posts.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //$post = Post::findOrFail($id);
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        // Gate::authorize('update', $post); // PostPolicy 클래스의 update 메서드호출
        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => ['required', 'min:3', 'max:200'],
            'content' => ['required', 'min:5'],
            'photo' => ['sometimes', 'image'],
        ]);

        if ($request->hasFile('photo')) {
            File::delete(storage_path('app/public/'. $post->photo));
            $validated['photo'] = $request->file('photo')->store('photos');
        }

        $post->update($validated);
        return to_route('posts.show', ['post' => $post]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        Gate::authorize('delete', $post);
        File::delete(storage_path('app/public/'. $post->photo));
        $post->delete();
        return to_route('posts.index');
    }
}
