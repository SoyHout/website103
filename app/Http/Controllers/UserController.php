<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use \Spatie\Permission\Models\Role;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rows = User::with('roles')->get();
        return view('users.index', compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request -> validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:8',
            'roles' => 'required|exists:roles,name'
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);

        $user->syncRoles([$validated['roles']]);
        return redirect() -> route('user.index') -> with('success', 'User Created Successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('users.index', compact('user')); // Assuming you have a view for showing user details
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $row = User::findOrFail($id);
        $roles = Role::all();
        return view('users.edit', compact('row', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $row = User::findOrFail($id);
        $validated = $request -> validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users,email,'.$id,
            'password' => 'nullable|string|min:8',
            'roles' => 'required|exists:roles,name'
        ]);

        $row -> update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);
        
        if($request -> password){
            $row -> update([
                'password' => bcrypt($validated['password']),
            ]);
        }

        $row->syncRoles([$validated['roles']]);
        return redirect() -> route('user.index') -> with('success', 'User Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $row = User::findOrFail($id);
        $row -> delete();
        return redirect() -> route('user.index') -> with('success', 'User Deleted Successfully!');
        // --- IGNORE ---
    }
}
