<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class MaterialController extends Controller
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

        $material = Material::with('sumber_data', 'satuan');

        if ($search) {
            $material->where("nama", "LIKE", "%$search%")
                ->orWhereHas('sumber_data', function ($sumber) use ($search) {
                    $sumber->where('name', 'like', "%$search%");
                });
        }

        if ($sort && $dir) {
            $material->orderBy($sort, $dir);
        } else {
            $material->latest();
        }

        $materials = $material->paginate($limit);

        $materials->getCollection()->transform(function ($material) {
            $material->harga = number_format($material->harga, 2);
            return $material;
        });

        return Response::json($materials);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'sumbers_id' => 'required',
            'satuans_id' => 'required',
            'nama' => 'required',
            'jenis' => 'required',
            'harga' => 'required',
        ]);

        if ($validation->fails()) {
            return Response::json([
                "status" => false,
                "message" => $validation->errors()
            ], 400);
        }

        $post = $request->all();

        $material = Material::create($post);

        return Response::json([
            "status" => true,
            "message" => "success.",
            "data" => [
                "id" => (int) $material->id
            ]
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $material = Material::with('sumber_data', 'satuan')->find($id);

        if ($material  == null) {
            return Response::json([
                "status" => false,
                "message" => "Material not found."
            ], 404);
        }

        return Response::json([
            "status" => true,
            "message" => "success.",
            "data" => $material
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validation = Validator::make($request->all(), [
            'sumbers_id' => 'required',
            'satuans_id' => 'required',
            'nama' => 'required',
            'jenis' => 'required',
            'harga' => 'required',
        ]);

        if ($validation->fails()) {
            return Response::json([
                "status" => false,
                "message" => $validation->errors()
            ], 400);
        }

        $put = $request->all();

        $material = Material::find($id);

        $material->update($put);

        return Response::json([
            "status" => true,
            "message" => "success.",
            "data" => $material->id
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $material = Material::find($id);

        if ($material  == null) {
            return Response::json([
                "status" => false,
                "message" => "Material not found."
            ], 404);
        }

        $material->delete();

        return Response::json([
            "status" => true,
            "message" => "success.",
            "data" => $id
        ], 200);
    }

    public function getAllMaterial(Request $request)
    {
        $sumbers_id = $request->sumbers_id;
        $search = $request->search;

        $material = Material::with('sumber_data', 'satuan');

        if (!empty($sumbers_id)) {
            $materials = $material->where('sumbers_id', $sumbers_id)->orderBy('id', 'DESC')->get();
        }

        if (!empty($search)) {
            $materials = $material->where("nama", "LIKE", "%$search%")
                ->orWhereHas('sumber_data', function ($sumber) use ($search) {
                    $sumber->where('name', 'like', "%$search%");
                })
                ->orWhereHas('satuan', function ($satuan) use ($search) {
                    $satuan->where('name', 'like', "%$search%");
                });
        }

        $materials = $material->orderBy('id', 'DESC')->get();

        $materials = $materials->map(function ($material) {
            $material->harga = number_format($material->harga, 2);
            return $material;
        });

        return Response::json([
            "status" => true,
            "message" => "success.",
            "data" => $materials
        ], 200);
    }
}
