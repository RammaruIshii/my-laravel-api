<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function index(): JsonResponse
    {
        $users = User::all();
        return response()->json($users);
    }

    public function filter(Request $request): JsonResponse
    {
        $name = $request->input('name');
        $users = User::where('name', $name)
                     ->join('profiles', 'users.id', '=', 'profiles.user_id')
                     ->select('users.*', 'profiles.bio')
                     ->get();
        return response()->json($users);
    }

    public function store(Request $request): JsonResponse
    {
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email')
        ]);
        return response()->json($user, 201);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $user = User::findOrFail($id);
        $user->update($request->only(['name', 'email']));
        return response()->json($user);
    }

    public function destroy($id): JsonResponse
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(['message' => 'User deleted successfully']);
    }

    public function clear(): JsonResponse
    {
        User::truncate();
        return response()->json(['message' => 'All users cleared successfully']);
    }
}
