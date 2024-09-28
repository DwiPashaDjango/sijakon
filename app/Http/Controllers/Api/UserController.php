<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $limit = $request->limit ? $request->limit : 10;

        $sort = $request->sort;
        $dir = $request->dir;

        $search = $request->search;

        $users = User::with('district', 'roles')->select('id', 'username', 'name', 'email', 'telp', 'alamat', 'districts_id', 'picture')->whereNotNull("id")->role('User');

        if ($search) {
            $users->where("name", "LIKE", "%$search%")
                ->orWhere("username", "LIKE", "%$search%")
                ->orWhere("alamat", "LIKE", "%$search%")
                ->orWhereHas('district', function ($district) use ($search) {
                    $district->where('name', 'like', '%' . $search . '%');
                })
                ->role('User');
        }

        if ($sort && $dir) {
            $users->orderBy($sort, $dir);
        } else {
            $users->latest();
        }

        return Response::json($users->paginate($limit));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            "username" => "required|max:255|unique:users,username",
            "name" => "required|max:255",
            "email" => "required|max:255|unique:users,email",
            "telp" => "required|max:255",
            "districts_id" => "required|max:255",
            "alamat" => "required|max:255",
            "password" => "required|max:50"
        ]);

        if ($validation->fails()) {
            return Response::json([
                "status" => false,
                "message" => $validation->errors()
            ], 400);
        }

        $post = $request->all();

        $post["password"] = Hash::make($request->password);

        $user = User::create($post);

        $user->assignRole("User");

        return Response::json([
            "status" => true,
            "message" => "success.",
            "data" => [
                "id" => (int) $user->id
            ]
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::where("id", $id)->with("district", "roles")->select('id', 'username', 'name', 'email', 'telp', 'alamat', 'districts_id', 'picture')->first();

        if ($user == null) {
            return Response::json([
                "status" => false,
                "message" => "Usernot found."
            ], 404);
        }

        return Response::json([
            "status" => true,
            "message" => "success.",
            "data" => $user
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validation = Validator::make($request->all(), [
            "username" => "max:255|unique:users,username," . $id,
            "name" => "max:255",
            "email" => "max:255|unique:users,email," . $id,
            "telp" => "max:255",
            "districts_id" => "max:255",
            "alamat" => "required|max:255",
            "password" => "max:50"
        ]);

        $user = User::where("id", $id)->first();

        if ($user == null) {
            return Response::json([
                "status" => false,
                "message" => "User not found."
            ], 404);
        }

        if ($validation->fails()) {
            return Response::json([
                "status" => false,
                "message" => $validation->errors()
            ], 400);
        }

        $put = $request->all();
        unset($put["password"]);

        if ($request->password) {
            $put["password"] = Hash::make($request->password);
        }
        $user->update($put);

        return Response::json([
            "status" => true,
            "message" => "success.",
            "data" => [
                "id" => (int) $id
            ]
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::where("id", $id)->first();

        if ($user == null) {
            return Response::json([
                "status" => false,
                "message" => "User not found."
            ], 404);
        }

        $user->syncRoles([]);

        $user->delete();

        return Response::json([
            "status" => true,
            "message" => "success.",
            "data" => [
                "id" => (int) $id
            ]
        ]);
    }
}
