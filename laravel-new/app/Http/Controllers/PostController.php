<?php

namespace App\Http\Controllers;
use App\Models\Post; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\PostResource;

class PostController extends Controller
{
    // GET /api/posts
    public function index(Request $request)
    {
        $posts = Post::query()
            ->when($request->search, function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('content', 'like', '%' . $request->search . '%');
            })
            ->latest()
            ->paginate(5);

        return PostResource::collection($posts);
    }

    // POST /api/posts
    public function store(Request $request)
    {
    //     $request->validate([
    //         'title' => 'required|min:3',
    //         'content' => 'required|min:5',
    //     ]);

    //     $post = Post::create([
    //     'title' => $request->title,
    //     'content' => $request->content,
    //     'user_id' => auth()->id(), // ✅ user_id post egasini chiqaradi!
    // ]);

    // return new PostResource($post);

    if (!auth()->user()->is_admin) {
        return response()->json([
            'message' => 'Only admin can create posts'
        ], 403);
    }

    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'content' => 'required|string',
    ]);

    $post = auth()->user()->posts()->create($validated);

    return new PostResource($post);
    }

    // GET /api/posts/{id}
    public function show($id)
    {
        return response()->json(Post::findOrFail($id));
    }

    // PUT /api/posts/{id}
    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        $post->update($request->only('title', 'content'));

        return response()->json($post);
    }

    // DELETE /api/posts/{id}
    public function destroy($id)
    {
        // Post::destroy($id);
        Post::findOrFail($id)->delete();

        return response()->json(['message' => 'Deleted']);
    }
}
