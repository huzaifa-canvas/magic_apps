<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Idea;

class IdeaController extends Controller
{
    /**
     * List all ideas (latest first) for moderation.
     */
    public function index()
    {
        $ideas = Idea::with('user')
            ->latest()
            ->paginate(20);

        return view('admin.ideas.index', compact('ideas'));
    }

    /**
     * Show a single idea with attachments.
     */
    public function show(Idea $idea)
    {
        $idea->load(['user', 'attachments']);

        return view('admin.ideas.show', compact('idea'));
    }

    /**
     * Toggle the published flag of an idea.
     */
    public function togglePublish(Idea $idea)
    {
        $idea->is_published = ! $idea->is_published;
        $idea->save();

        $state = $idea->is_published ? 'published' : 'unpublished';

        return redirect()->back()->with('success', "Idea #{$idea->id} {$state}.");
    }

    /**
     * Toggle the featured flag of an idea and stamp featured_at.
     */
    public function toggleFeatured(Idea $idea)
    {
        $idea->is_featured = ! $idea->is_featured;
        $idea->featured_at = $idea->is_featured ? now() : null;
        $idea->save();

        $state = $idea->is_featured ? 'featured' : 'unfeatured';

        return redirect()->back()->with('success', "Idea #{$idea->id} {$state}.");
    }

    /**
     * Delete an idea.
     */
    public function destroy(Idea $idea)
    {
        $idea->delete();

        return redirect()->route('admin.ideas.index')->with('success', 'Idea deleted.');
    }
}
