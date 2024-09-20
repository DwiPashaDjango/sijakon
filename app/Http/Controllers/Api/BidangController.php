<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Bidang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class BidangController extends Controller
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

        $bidang = Bidang::latest();

        if ($search) {
            $bidang->where("name", "LIKE", "%$search%");
        }

        if ($sort && $dir) {
            $bidang->orderBy($sort, $dir);
        } else {
            $bidang->latest();
        }

        return Response::json($bidang->paginate($limit));
    }

    public function select2(Request $request)
    {
        $term = $request->term;

        $form = Bidang::latest();

        if ($term) {
            $form->where('name', 'like', '%' . $term . '%');
        }

        $data = $form->simplePaginate(10);

        $morePages = false;

        if ($data->nextPageUrl() != null) {
            $morePages = true;
        }

        $items = [];
        $index = 0;

        foreach ($data->items() as $key) {

            $items[$index++] = [
                "id" => $key["id"],
                "text" => $key["name"]
            ];
        }

        return Response::json([
            "status" => true,
            "message" => "success.",
            "data" => [
                "items" => $items,
                "pagination" => [
                    "more" => $morePages
                ]
            ]
        ], 200);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required|max:255'
        ]);

        if ($validation->fails()) {
            return Response::json([
                "status" => false,
                "message" => $validation->errors()
            ], 400);
        }

        $post = $request->all();

        $bidang = Bidang::create($post);

        return Response::json([
            "status" => true,
            "message" => "success.",
            "data" => [
                "id" => (int) $bidang->id
            ]
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $bidang = Bidang::find($id);

        if ($bidang  == null) {
            return Response::json([
                "status" => false,
                "message" => "bidang not found."
            ], 404);
        }

        return Response::json([
            "status" => true,
            "message" => "success.",
            "data" => $bidang
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required|max:255'
        ]);

        if ($validation->fails()) {
            return Response::json([
                "status" => false,
                "message" => $validation->errors()
            ], 400);
        }

        $put = $request->all();

        $bidang = Bidang::find($id);

        $bidang->update($put);

        return Response::json([
            "status" => true,
            "message" => "success.",
            "data" => $id
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $bidang = Bidang::find($id);

        if ($bidang  == null) {
            return Response::json([
                "status" => false,
                "message" => "bidang not found."
            ], 404);
        }

        $bidang->delete();

        return Response::json([
            "status" => true,
            "message" => "success.",
            "data" => $id
        ], 200);
    }
}
