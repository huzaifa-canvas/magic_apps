<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FeedPost;

class FeedPostController extends Controller
{
    /**
     * List all feed posts (latest first) for moderation.
     */
    public function index()
    {
        $posts = FeedPost::with('user')
            ->withCount('comments')
            ->latest()
            ->paginate(20);

        return view('admin.feed_posts.index', compact('posts'));
    }

    /**
     * Show a single feed post with attachments and comment count.
     */
    public function show(FeedPost $feedPost)
    {
        $feedPost->load(['user', 'attachments']);
        $commentCount = $feedPost->comments()->count();

        return view('admin.feed_posts.show', compact('feedPost', 'commentCount'));
    }

    /**
     * Toggle the published flag of a feed post.
     */
    public function togglePublish(FeedPost $feedPost)
    {
        $feedPost->is_published = ! $feedPost->is_published;
        $feedPost->save();

        $state = $feedPost->is_published ? 'published' : 'unpublished';

        return redirect()->back()->with('success', "Post #{$feedPost->id} {$state}.");
    }

    /**
     * Delete a feed post.
     */
    public function destroy(FeedPost $feedPost)
    {
        $feedPost->delete();

        return redirect()->route('admin.feed-posts.index')->with('success', 'Feed post deleted.');
    }
}
