<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BadanUsaha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class BadanUsahaController extends Controller
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

        $bidang = BadanUsaha::query();

        if ($search) {
            $bidang->where("name", "LIKE", "%$search%")
                ->orWhere('alamat', 'like', "%$search%")
                ->orWhere('telp', 'like', "%$search%")
                ->orWhere('nib', 'like', "%$search%")
                ->orWhere('pjbu', 'like', "%$search%")
                ->orWhere('jenis', 'like', "%$search%");
        }

        if ($sort && $dir) {
            $bidang->orderBy($sort, $dir);
        } else {
            $bidang->latest();
        }

        return Response::json($bidang->paginate($limit));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'nib' => 'required',
            'pjbu' => 'required',
            'jenis' => 'required',
            'kualifikasi' => 'required',
            'telp' => 'required',
            'alamat' => 'required',
            'kode_sublifikasi' => 'required',
        ]);

        if ($validation->fails()) {
            return Response::json([
                "status" => false,
                "message" => $validation->errors()
            ], 400);
        }

        $post = $request->all();

        $badanUsaha = BadanUsaha::create($post);

        return Response::json([
            "status" => true,
            "message" => "success.",
            "data" => [
                "id" => (int) $badanUsaha->id
            ]
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $badanUsaha = BadanUsaha::find($id);

        if ($badanUsaha  == null) {
            return Response::json([
                "status" => false,
                "message" => "Badan Usaha not found."
            ], 404);
        }

        return Response::json([
            "status" => true,
            "message" => "success.",
            "data" => $badanUsaha
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'nib' => 'required',
            'pjbu' => 'required',
            'jenis' => 'required',
            'kualifikasi' => 'required',
            'telp' => 'required',
            'alamat' => 'required',
            'kode_sublifikasi' => 'required',
        ]);

        if ($validation->fails()) {
            return Response::json([
                "status" => false,
                "message" => $validation->errors()
            ], 400);
        }

        $put = $request->all();

        $badanUsaha = BadanUsaha::find($id);

        $badanUsaha->update($put);

        return Response::json([
            "status" => true,
            "message" => "success.",
            "data" => [
                "id" => (int) $badanUsaha->id
            ]
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $badanUsaha = BadanUsaha::find($id);

        if ($badanUsaha  == null) {
            return Response::json([
                "status" => false,
                "message" => "Badan Usaha not found."
            ], 404);
        }

        $badanUsaha->delete();

        return Response::json([
            "status" => true,
            "message" => "success.",
            "data" => [
                "id" => $id
            ]
        ]);
    }
}
