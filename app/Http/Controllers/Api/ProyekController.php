<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Proyek;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class ProyekController extends Controller
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

        $proyek = Proyek::with('sumber_proyek', 'district');

        if ($search) {
            $proyek->where("nama", "LIKE", "%$search%")
                ->orWhereHas('sumber_proyek', function ($sumber) use ($search) {
                    $sumber->where('name', 'like', "%$search%");
                })
                ->orWhereHas('district', function ($district) use ($search) {
                    $district->where('name', 'like', "%$search%");
                });
        }

        if ($sort && $dir) {
            $proyek->orderBy($sort, $dir);
        } else {
            $proyek->latest();
        }

        $proyeks = $proyek->paginate($limit);

        return Response::json($proyeks);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'sumbers_id' => 'required',
            'districts_id' => 'required',
            'jml_karyawan' => 'required',
            'tgl_mulai' => 'required',
            'tgl_selesai' => 'required',
        ]);

        if ($validation->fails()) {
            return Response::json([
                "status" => false,
                "message" => $validation->errors()
            ], 400);
        }

        $post = $request->all();

        $proyek = Proyek::create($post);

        return Response::json([
            "status" => true,
            "message" => "success.",
            "data" => [
                "id" => (int) $proyek->id
            ]
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $proyek = Proyek::with('sumber_proyek', 'district')->find($id);

        if ($proyek  == null) {
            return Response::json([
                "status" => false,
                "message" => "Proyek not found."
            ], 404);
        }

        return Response::json([
            "status" => true,
            "message" => "success.",
            "data" => $proyek
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validation = Validator::make($request->all(), [
            'sumbers_id' => 'required',
            'districts_id' => 'required',
            'jml_karyawan' => 'required',
            'tgl_mulai' => 'required',
            'tgl_selesai' => 'required',
        ]);

        if ($validation->fails()) {
            return Response::json([
                "status" => false,
                "message" => $validation->errors()
            ], 400);
        }

        $put = $request->all();

        $proyek = Proyek::find($id);

        $proyek->update($put);

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
        $proyek = Proyek::find($id);

        if ($proyek  == null) {
            return Response::json([
                "status" => false,
                "message" => "Proyek not found."
            ], 404);
        }

        $proyek->delete();

        return Response::json([
            "status" => true,
            "message" => "success.",
            "data" => (int) $id
        ], 200);
    }
}
