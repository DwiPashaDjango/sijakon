<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function login()
    {
        return view("auth.login");
    }

    public function login_post(Request $request)
    {
        $req = Request::create("/api/auth/login", "POST", $request->all());

        $req->headers->set("Accept", "application/json");
        $req->headers->set("Content-Type", "application/json");

        $response = App::handle($req);

        $data = json_decode($response->getContent(), true);

        if (isset($data) && $data["status"] == true) {
            Session::put("authorization", $data["data"]["token"]["plainTextToken"]);
            Session::put("role", $data["data"]["user"]["roles"][0]["name"]);
        }

        return $response;
    }

    public function logout_post()
    {
        $req = Request::create("/api/auth/logout", "POST");

        $req->headers->set("Accept", "application/json");
        $req->headers->set("Content-Type", "application/json");
        $req->headers->set("Authorization", "Bearer " . Session::get("authorization"));

        App::handle($req);

        Session::flush();

        return Response::json([
            "status" => true,
            "message" => "success."
        ], 200);
    }
}
