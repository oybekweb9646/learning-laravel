<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

final class UserController extends Controller
{
    /**
     * GET /users
     */
    public function index()
    {
        return User::query()
            ->select('id','name','email','role','created_at')
            ->paginate(15);
    }

    /**
     * POST /users
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:8',
            'role'     => 'required|in:admin,manager,user',
        ]);

        return response()->json(
            User::create($data),
            201
        );
    }

    /**
     * GET /users/{id}
     */
    public function show(User $user)
    {
        return $user->only([
            'id','name','email','role','created_at'
        ]);
    }

    /**
     * PUT /users/{id}
     */
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name'  => 'sometimes|string|max:255',
            'email' => "sometimes|email|unique:users,email,{$user->id}",
            'password' => 'sometimes|min:8',
            'role' => 'sometimes|in:admin,manager,user',
        ]);

        $user->update($data);

        return response()->json($user);
    }

    /**
     * DELETE /users/{id}
     */
    public function destroy(User $user)
    {
        $user->delete();

        return response()->noContent();
    }
}

