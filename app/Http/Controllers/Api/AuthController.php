<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validation = Validator::make($request->all(), [
            "email" => "required|max:255",
            "password" => "required|max:50"
        ], [
            'email' => 'Email tidak boleh kosong.',
            'password' => 'password tidak boleh kosong'
        ]);

        if ($validation->fails()) {
            return Response::json([
                "status" => false,
                "message" => $validation->errors()
            ], 400);
        }

        $user = User::where("email", $request->email)->with("roles")->first();

        if ($user) {
            if (!Hash::check($request->password, $user["password"])) {
                return Response::json([
                    "status" => false,
                    "message" => [
                        "password" => ["Password is not match."]
                    ]
                ], 400);
            } else {
                $token = $user->createToken("Authorization");

                return Response::json([
                    "status" => true,
                    "message" => "success.",
                    "data" => [
                        "user" => $user,
                        "token" => $token
                    ]
                ]);
            }
        } else {
            return Response::json([
                "status" => false,
                "message" => [
                    "account" => ["Account Not Found"]
                ]
            ], 404);
        }
    }

    public function show()
    {
        $user = User::where("id", Auth::id())->select(DB::raw("*, CONCAT('" . env("APP_URL") . "/', COALESCE(picture, 'assets/images/users/user-dummy-img.jpg')) AS picture"))->with("roles")->first();

        return Response::json([
            "status" => true,
            "message" => "success.",
            "data" => $user
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return Response::json([
            "status" => true,
            "message" => "success.",
            "data" => [
                "id" => (int) Auth::id()
            ]
        ], 200);
    }
}
