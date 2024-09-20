<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class CraftsmanController extends Controller
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

        if (Auth::user()->hasRole('Admin')) {
            $tukang = User::with('bidang', 'district', 'roles')->whereNotNull("id")->role('Tukang');
        } else {
            $tukang = User::with('bidang', 'district', 'roles')
                ->where('districts_id', Auth::user()->districts_id)
                ->whereNotNull("id")
                ->role('Tukang');
        }

        if ($search) {
            $tukang->where("name", "LIKE", "%$search%")
                ->orWhereHas('district', function ($district) use ($search) {
                    $district->where('name', 'like', '%' . $search . '%');
                })
                ->orWhereHas('bidang', function ($bidang) use ($search) {
                    $bidang->where('name', 'like', '%' . $search . '%');
                })
                ->role('Tukang');
        }

        if ($sort && $dir) {
            $tukang->orderBy($sort, $dir);
        } else {
            $tukang->latest();
        }

        $tukang = $tukang->paginate($limit);

        $tukang->getCollection()->transform(function ($item) {
            $item->picture = $item->picture ? asset($item->picture) : '-';

            $item->district = $item->district ?? '-';
            $item->bidang = $item->bidang ? $item->bidang : '-';

            return $item;
        });


        return Response::json($tukang);
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
            "bidangs_id" => "required|max:255",
            "districts_id" => "required|max:255",
            "sertifikat" => "required|max:255",
            "picture" => "required|max:255|mimes:png,jpg,jpeg",
            "password" => "required|max:50"
        ]);

        if ($validation->fails()) {
            return Response::json([
                "status" => false,
                "message" => $validation->errors()
            ], 400);
        }

        $image = $request->file('picture');
        $imageName = rand() . '.' . $image->getClientOriginalExtension();
        $path = 'tukang/';
        $image->move($path, $imageName);

        $post = $request->except('picture');

        $post["picture"] = $path . $imageName;
        $post["password"] = Hash::make($request->password);

        $user = User::create($post);

        $user->assignRole("Tukang");

        return Response::json([
            "status" => true,
            "message" => "success.",
            "data" => [
                "id" => (int) $user->id
            ]
        ]);
    }

    public function show(string $id)
    {
        $tukang = User::where("id", $id)->with("bidang", "district", "roles")->first();

        if ($tukang  == null) {
            return Response::json([
                "status" => false,
                "message" => "tukang not found."
            ], 404);
        }

        return Response::json([
            "status" => true,
            "message" => "success.",
            "data" => $tukang
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validation = Validator::make($request->all(), [
            "username" => "required|max:255|unique:users,username," . $id,
            "name" => "required|max:255",
            "email" => "required|max:255|unique:users,email," . $id,
            "telp" => "required|max:255",
            "bidangs_id" => "required|max:255",
            "districts_id" => "required|max:255",
            "sertifikat" => "required|max:255",
            "picture" => "max:255|mimes:png,jpg,jpeg",
        ]);

        $tukang = User::where("id", $id)->first();

        if ($tukang == null) {
            return Response::json([
                "status" => false,
                "message" => "tukang not found."
            ], 404);
        }

        if ($validation->fails()) {
            return Response::json([
                "status" => false,
                "message" => $validation->errors()
            ], 400);
        }

        $put = $request->except('picture');

        if ($request->hasFile('picture')) {
            unlink(public_path($tukang->picture));

            $image = $request->file('picture');
            $imageName = rand() . '.' . $image->getClientOriginalExtension();
            $path = 'tukang/';
            $image->move($path, $imageName);

            $put['picture'] = $path . $imageName;

            unset($put["password"]);

            if ($request->password) {
                $put["password"] = Hash::make($request->password);
            }
            $tukang->update($put);
        } else {
            unset($put["password"]);

            if ($request->password) {
                $put["password"] = Hash::make($request->password);
            }
            $tukang->update($put);
        }

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
        $tukang = User::where("id", $id)->first();

        if ($tukang == null) {
            return Response::json([
                "status" => false,
                "message" => "tukang not found."
            ], 404);
        }

        unlink(public_path($tukang->picture));

        $tukang->syncRoles([]);

        $tukang->delete();

        return Response::json([
            "status" => true,
            "message" => "success.",
            "data" => [
                "id" => (int) $id
            ]
        ]);
    }
}
