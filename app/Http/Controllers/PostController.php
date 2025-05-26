<?php

namespace App\Http\Controllers;


use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    // List user's posts with optional filters
    public function index(Request $request)
    {
        $query = Post::with('platforms')->where('user_id', Auth::id());

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('date')) {
            $query->whereDate('scheduled_time', $request->date);
        }
        $posts = $query->orderBy('scheduled_time', 'desc')->get();
        return view("posts.index",with(['posts'=> $posts]));
    }

    // Store a post
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image_url' => 'nullable|url',
            'scheduled_time' => 'nullable|date',
            'status' => 'required|in:draft,scheduled,published',
            'platforms' => 'required|array|min:1',
            'platforms.*' => 'exists:platforms,id'
        ]);

        // Rate limit: max 10 scheduled posts per user per day
        if ($data['status'] === 'scheduled') {
            $scheduledCount = Post::where('user_id', Auth::id())
                ->where('status', 'scheduled')
                ->whereDate('scheduled_time', '=', $data['scheduled_time'] ? date('Y-m-d', strtotime($data['scheduled_time'])) : now()->toDateString())
                ->count();
            if ($scheduledCount >= 10) {
                return back()->withErrors(['scheduled_time' => 'You can only schedule up to 10 posts per day.']);
            }
        }

        $post = Auth::user()->posts()->create($data);
        $post->platforms()->syncWithPivotValues($data['platforms'], [
            'platform_status' => 'pending',
        ]);

        return redirect('posts');
    }

    public function show(Post $post)
    {
        $this->authorizeAccess($post);
        return $post->load('platforms');
    }

    public function update(Request $request, Post $post)
    {
        $this->authorizeAccess($post);

        $data = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'content' => 'sometimes|required|string',
            'image_url' => 'nullable|url',
            'scheduled_time' => 'sometimes|nullable|date',
            'status' => 'sometimes|required|in:draft,scheduled,published',
            'platforms' => 'required|array|min:1',
            'platforms.*' => 'exists:platforms,id'
        ]);

        $post->update($data);

        if (isset($data['platforms'])) {
            $post->platforms()->syncWithPivotValues($data['platforms'], [
                'platform_status' => 'pending',
            ]);
        }

        return redirect()->route('posts.index')->with('status', 'Post updated successfully!');

    }

    public function create()
{
    $user = auth()->user();

    // Only platforms enabled for user
    $platforms = $user->activePlatforms()->get();

    return view('posts.create', compact('platforms'));
}

public function edit(Post $post)
{
    $this->authorizeAccess($post);

    $user = auth()->user();

    // Only platforms enabled for user
    $platforms = $user->activePlatforms()->get();

    return view('posts.edit', compact('post', 'platforms'));
}


    public function destroy(Post $post)
    {
        $this->authorizeAccess($post);
        $post->delete();
        return redirect()->route('posts.index')->with('status', 'Post deleted!');
    }

    protected function authorizeAccess(Post $post)
    {
        if ($post->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }
    }
}
