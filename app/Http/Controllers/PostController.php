<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
{
    public function fetch(Request $request)
    {
        $query = Post::query();
        if ($request->filled('search')) {
            $query->where('title', 'like', "%{$request->search}%")
                ->orWhere('category', 'like', "%{$request->search}%");
        }
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }
        $users = $query->paginate(10);
        return response()->json($users);
    }
    public function index()
    {
        $posts = Post::all();
        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(PostRequest $request)
    {
        try {
            $validated =  $request->validated();
            $mediaPath = null;
            if ($request->hasFile('media')) {
                $file = $request->file('media');
                $mediaPath = $file->store('media', 'public');
            }

            Post::create([
                'title' => $validated['title'],
                'content' => $validated['content'],
                'category' => $validated['category'],
                'media' => $mediaPath,
                'user_id' => $validated['user_id'],
            ]);

            return redirect()->route('posts.create')->with('success', 'Post created successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }



    public function show(Post $post)
    {

        if (auth()->user()->id !== $post->user_id) {
            abort(403);
        }
        return view('posts.show', compact('post'));
    }

    public function edit(Post $post)
    {

        if (auth()->user()->id !== $post->user_id) {
            abort(403);
        }
        return view('posts.edit', compact('post'));
    }


    public function update(PostRequest $request, Post $post)
    {
        try {
            if (auth()->user()->id !== $post->user_id) {
                abort(403);
            }

            $validated = $request->validated();
            $mediaPath = $post->media;

            if ($request->hasFile('media')) {
                $file = $request->file('media');
                $mediaPath = $file->store('media', 'public');
            }
            $post->update([
                'title' => $validated['title'],
                'content' => $validated['content'],
                'category' => $validated['category'],
                'media' => $mediaPath,
                'user_id' => auth()->user()->id,
                'updated_at' => now(),
            ]);

            return redirect()->route('posts.index')->with('success', 'Post updated successfully!');
        } catch (\Exception $e) {

            Log::error('Post update failed: ' . $e->getMessage());


            return redirect()->back()->withErrors('An error occurred while updating the post. Please try again later.');
        }
    }



    public function destroy(Post $post)
    {
        try {
            if (auth()->user()->id !== $post->user_id) {
                abort(403); 
            }

            $post->delete();

            return redirect()->route('posts.index')->with('success', 'Post deleted successfully!');
        } catch (\Exception $e) {
            Log::error('Post deletion failed: ' . $e->getMessage());

            return redirect()->back()->withErrors('An error occurred while deleting the post. Please try again later.');
        }
    }
}
