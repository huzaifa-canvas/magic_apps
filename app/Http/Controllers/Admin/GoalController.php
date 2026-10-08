<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Goal;

class GoalController extends Controller
{
    /**
     * List all user goals (latest first).
     */
    public function index()
    {
        $goals = Goal::with('user')
            ->latest()
            ->paginate(20);

        return view('admin.goals.index', compact('goals'));
    }

    /**
     * Delete a user goal.
     */
    public function destroy(Goal $goal)
    {
        $goal->delete();

        return redirect()->route('admin.goals.index')->with('success', 'Goal deleted.');
    }
}
