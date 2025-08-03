<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (!$request->user()->isSuperadmin()) {
            abort(403, 'Akses ditolak.');
        }

        $query = User::query();
        
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }
        
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }
        
        $users = $query->latest()->paginate(10);
        
        return Inertia::render('admin/users/index', [
            'users' => $users,
            'filters' => $request->all(['role', 'search']),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        if (!$request->user()->isSuperadmin()) {
            abort(403, 'Akses ditolak.');
        }

        return Inertia::render('admin/users/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $user = User::create($request->validated());

        return redirect()->route('admin.users.show', $user)
            ->with('success', 'Pengguna berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user, Request $request)
    {
        if (!$request->user()->isSuperadmin()) {
            abort(403, 'Akses ditolak.');
        }

        return Inertia::render('admin/users/show', [
            'user' => $user,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user, Request $request)
    {
        if (!$request->user()->isSuperadmin()) {
            abort(403, 'Akses ditolak.');
        }

        return Inertia::render('admin/users/edit', [
            'user' => $user,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->validated());

        return redirect()->route('admin.users.show', $user)
            ->with('success', 'Pengguna berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user, Request $request)
    {
        if (!$request->user()->isSuperadmin()) {
            abort(403, 'Akses ditolak.');
        }

        if ($user->id === $request->user()->id) {
            return back()->with('error', 'Anda tidak dapat menghapus akun sendiri.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Pengguna berhasil dihapus.');
    }
}