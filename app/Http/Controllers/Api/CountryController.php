<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\District;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class CountryController extends Controller
{
    public function index(Request $request)
    {
        $limit = $request->limit ? $request->limit : 10;

        $sort = $request->sort;
        $dir = $request->dir;

        $search = $request->search;

        $bidang = District::latest();

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

        $form = District::latest();

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

        $district = District::create($post);

        return Response::json([
            "status" => true,
            "message" => "success.",
            "data" => [
                "id" => (int) $district->id
            ]
        ]);
    }

    public function show(string $id)
    {
        $district = District::find($id);

        if ($district  == null) {
            return Response::json([
                "status" => false,
                "message" => "district not found."
            ], 404);
        }

        return Response::json([
            "status" => true,
            "message" => "success.",
            "data" => $district
        ], 200);
    }

    public function update(Request $request, $id)
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

        $district = District::find($id);

        $district->update($put);

        return Response::json([
            "status" => true,
            "message" => "success.",
            "data" => $id
        ], 200);
    }

    public function destroy(string $id)
    {
        $district = District::find($id);

        if ($district  == null) {
            return Response::json([
                "status" => false,
                "message" => "district not found."
            ], 404);
        }

        $district->delete();

        return Response::json([
            "status" => true,
            "message" => "success.",
            "data" => $id
        ], 200);
    }

    public function getDistrictApi() {
        $client = new Client();

        $response = $client->get('https://www.emsifa.com/api-wilayah-indonesia/api/districts/2171.json');
        $districts = json_decode($response->getBody(), true);

        foreach ($districts as $districtData) {
            District::updateOrCreate(
                ['id' => $districtData['id']],
                ['name' => $districtData['name']]
            );
        }

        return "Data distrik berhasil disimpan!";
    }
}
