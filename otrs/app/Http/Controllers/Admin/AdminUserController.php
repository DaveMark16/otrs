<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $users = $query->latest()->paginate(15)->withQueryString();

        $stats = [
            'total'    => User::count(),
            'active'   => User::where('status', 'active')->count(),
            'inactive' => User::where('status', 'inactive')->count(),
            'admins'   => User::whereIn('role', ['admin', 'superadmin'])->count(),
        ];

        return view('admin.users.index', compact('users', 'stats'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'   => 'required|string|max:255',
            'email'  => 'required|email|unique:users,email,' . $user->id,
            'phone'  => 'nullable|string|max:20',
            'role'   => 'required|in:traveler,business,tourist,commuter,corporate,passenger,admin,superadmin',
            'status' => 'required|in:active,inactive',
        ]);

        $user->update($request->only(['name', 'email', 'phone', 'role', 'status']));

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted.');
    }

    public function toggle(User $user)
    {
        $user->update(['status' => $user->status === 'active' ? 'inactive' : 'active']);
        return back()->with('success', 'User status updated.');
    }

    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:traveler,business,tourist,commuter,corporate,passenger,admin,superadmin',
        ]);

        if ($user->id === auth()->id() && ! in_array($request->role, ['admin', 'superadmin'])) {
            return back()->with('error', 'You cannot remove your own admin role.');
        }

        $user->update(['role' => $request->role]);
        return back()->with('success', "Role updated to {$request->role}.");
    }
}
