<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Equipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class EquipmentController extends Controller
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

        $bidang = Equipment::with('sumber_data', 'satuan');

        if ($search) {
            $bidang->where("nama", "LIKE", "%$search%")
                ->orWhereHas('sumber_data', function ($sumber) use ($search) {
                    $sumber->where('name', 'like', "%$search%");
                });
        }

        if ($sort && $dir) {
            $bidang->orderBy($sort, $dir);
        } else {
            $bidang->latest();
        }

        $bidangs = $bidang->paginate($limit);

        $bidangs->getCollection()->transform(function ($bidang) {
            $bidang->harga = number_format($bidang->harga, 2);
            return $bidang;
        });

        return Response::json($bidangs);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'sumbers_id' => 'required',
            'nama' => 'required',
            'jenis' => 'required',
            'satuans_id' => 'required',
            'harga' => 'required',
        ]);

        if ($validation->fails()) {
            return Response::json([
                "status" => false,
                "message" => $validation->errors()
            ], 400);
        }

        $post = $request->all();

        $equipment = Equipment::create($post);

        return Response::json([
            "status" => true,
            "message" => "success.",
            "data" => [
                "id" => (int) $equipment->id
            ]
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $equipment = Equipment::with('sumber_data', 'satuan')->find($id);

        if ($equipment  == null) {
            return Response::json([
                "status" => false,
                "message" => "Equipment not found."
            ], 404);
        }

        return Response::json([
            "status" => true,
            "message" => "success.",
            "data" => $equipment
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validation = Validator::make($request->all(), [
            'sumbers_id' => 'required',
            'nama' => 'required',
            'jenis' => 'required',
            'satuans_id' => 'required',
            'harga' => 'required',
        ]);

        if ($validation->fails()) {
            return Response::json([
                "status" => false,
                "message" => $validation->errors()
            ], 400);
        }

        $put = $request->all();

        $equipment = Equipment::find($id);

        $equipment->update($put);

        return Response::json([
            "status" => true,
            "message" => "success.",
            "data" => $equipment->id
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $equipment = Equipment::find($id);

        if ($equipment  == null) {
            return Response::json([
                "status" => false,
                "message" => "Equipment not found."
            ], 404);
        }

        $equipment->delete();

        return Response::json([
            "status" => true,
            "message" => "success.",
            "data" => $id
        ], 200);
    }

    public function getAllEquipment(Request $request)
    {
        $sumbers_id = $request->sumbers_id;
        $search = $request->search;

        $equipment = Equipment::with('sumber_data', 'satuan');

        if (!empty($sumbers_id)) {
            $equipments = $equipment->where('sumbers_id', $sumbers_id)->orderBy('id', 'DESC')->get();
        }

        if (!empty($search)) {
            $equipments = $equipment->where("nama", "LIKE", "%$search%")
                ->orWhereHas('sumber_data', function ($sumber) use ($search) {
                    $sumber->where('name', 'like', "%$search%");
                })
                ->orWhereHas('satuan', function ($satuan) use ($search) {
                    $satuan->where('name', 'like', "%$search%");
                });
        }

        $equipments = $equipment->orderBy('id', 'DESC')->get();

        $equipments = $equipments->map(function ($equipment) {
            $equipment->harga = number_format($equipment->harga, 2);
            return $equipment;
        });

        return Response::json([
            "status" => true,
            "message" => "success.",
            "data" => $equipments
        ], 200);
    }
}
