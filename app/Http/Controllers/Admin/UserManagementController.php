<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('profile');

        if ($search = $request->get('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($role = $request->get('role')) {
            $query->where('user_role', $role);
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(20)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function show($id)
    {
        $user = User::with('profile')->findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    public function toggleSessionPermission(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->can_manage_sessions = ! $user->can_manage_sessions;
        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'Permission updated successfully.',
            'can_manage_sessions' => $user->can_manage_sessions,
        ]);
    }

    public function toggleActive(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->is_active = ! $user->is_active;
        $user->save();

        return back()->with('success', 'User has been '.($user->is_active ? 'activated' : 'deactivated').'.');
    }

    public function toggleRole(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Prevent an admin from removing their own admin access (avoids self lock-out).
        if ((int) $id === (int) auth()->id()) {
            return back()->with('error', 'You cannot change your own role.');
        }

        // user_role is not mass-assignable by design, so set it explicitly.
        $user->user_role = $user->user_role === 'admin' ? 'user' : 'admin';
        $user->save();

        return back()->with('success', 'User role changed to '.$user->user_role.'.');
    }
}
