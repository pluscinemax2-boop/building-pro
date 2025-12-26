<?php

namespace App\Http\Controllers;

use App\Models\ForumCategory;
use App\Models\ForumThread;
use App\Models\ForumReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForumController extends Controller
{
    public function search(Request $request)
    {
        $q = $request->input('q');
        $threads = ForumThread::where('title', 'like', "%$q%")
            ->orWhere('body', 'like', "%$q%")
            ->with('user', 'category')
            ->get();
        $replies = ForumReply::where('body', 'like', "%$q%")
            ->with('user', 'thread.category')
            ->get();
        return view('forum.search', compact('q', 'threads', 'replies'));
    }
    public function index()
    {
        $categories = ForumCategory::withCount('threads')->get();
        return view('forum.index', compact('categories'));
    }

    public function category($id)
    {
        $category = ForumCategory::with('threads.user')->findOrFail($id);
        return view('forum.category', compact('category'));
    }

    public function thread($id)
    {
        $thread = ForumThread::with(['user', 'replies.user', 'category'])->findOrFail($id);
        return view('forum.thread', compact('thread'));
    }

    public function createThread($categoryId)
    {
        $category = ForumCategory::findOrFail($categoryId);
        return view('forum.create_thread', compact('category'));
    }

    public function storeThread(Request $request, $categoryId)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ]);
        $thread = ForumThread::create([
            'forum_category_id' => $categoryId,
            'user_id' => Auth::id(),
            'title' => $request->title,
            'body' => $request->body,
        ]);
        return redirect()->route('forum.thread', $thread->id)->with('success', 'Thread created successfully.');
    }

    public function storeReply(Request $request, $threadId)
    {
        $request->validate([
            'body' => 'required|string',
        ]);
        ForumReply::create([
            'forum_thread_id' => $threadId,
            'user_id' => Auth::id(),
            'body' => $request->body,
        ]);
        return redirect()->route('forum.thread', $threadId)->with('success', 'Reply posted.');
    }
}
