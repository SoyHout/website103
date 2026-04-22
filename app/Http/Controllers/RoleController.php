<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rows = Role::all();
        return view('roles.index', compact('rows')); // Assuming you have a view for listing roles
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('roles.create'); // Assuming you have a view for listing roles
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request -> validate([
            'name' => 'required|unique:roles|max:50',
            'description' => 'max:200'
        ]);

        Role::create([
            'name' => $request -> name,
            'description' => $request -> description
        ]);

        return redirect()->route('role.index'); // Redirect to roles index after storing
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $row = Role::findOrFail($id);
        return view('roles.edit', compact('row'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $row = Role::findOrFail($id);
        $validated = $request -> validate([
            'name'=>'required|unique:roles,name,'.$id.'|max:50',
            'description' => 'max:200'
        ]);

        $row->update([
            'name'=> $request->name,
            'description'=>$request->description

        ]);

        return redirect()->route('role.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $row = Role::findOrFail($id);
        $row -> delete();
        return redirect() -> route('role.index');
    }
}
