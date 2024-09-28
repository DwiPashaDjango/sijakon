<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SumberProyek;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class SumberProyekController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Select2 the form for creating a new resource.
     */
    public function select2(Request $request)
    {
        $term = $request->term;

        $form = SumberProyek::latest();

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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
