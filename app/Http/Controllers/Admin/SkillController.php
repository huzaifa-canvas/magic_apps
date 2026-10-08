<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Skills;
use App\Models\User;

class SkillController extends Controller
{
    /**
     * List all user skills (latest first).
     *
     * Skills has no user() relationship, so owners are looked up in the
     * controller and passed to the view keyed by id (no model changes).
     */
    public function index()
    {
        $skills = Skills::with('type')
            ->latest()
            ->paginate(20);

        $userIds = $skills->pluck('user_id')->filter()->unique();
        $users = User::whereIn('id', $userIds)->get()->keyBy('id');

        return view('admin.skills.index', compact('skills', 'users'));
    }

    /**
     * Delete a user skill.
     */
    public function destroy(Skills $skill)
    {
        $skill->delete();

        return redirect()->route('admin.skills.index')->with('success', 'Skill deleted.');
    }
}
