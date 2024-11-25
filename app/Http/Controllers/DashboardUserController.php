<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class DashboardUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = \App\Models\User::latest()->paginate(10);
        return view('dashboard.user.index', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|min:3',
            'email' => 'required',
            'password' => 'required|confirmed',
            'alamat' => 'required',
            'no_telp' => 'required',
        ]);
        $validated['remember_token'] = Str::random(10);
        $validated['email_verified_at'] = now();
        User::create($validated);
        return redirect('dashboard-user');
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
        return view('dashboard.user.edit', ['user' => User::find($id)]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|min:3',
            'email' => 'required',
            'password' => 'required|confirmed',
            'alamat' => 'required',
            'no_telp' => 'required',
        ]);
        $validated['remember_token'] = Str::random(10);
        $validated['email_verified_at'] = now();
        $validated['password'] = Hash::make($validated['password']);
        User::where('id', $id)->update($validated);
        return redirect('dashboard-user');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        User::destroy($id);
        return redirect('/dashboard-user');
    }
}
