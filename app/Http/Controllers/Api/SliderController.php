<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $limit = $request->limit ? $request->limit : 10;

        $sort = $request->sort;
        $dir = $request->dir;

        $slider = Slider::query();

        if ($sort && $dir) {
            $slider->orderBy($sort, $dir);
        } else {
            $slider->latest();
        }

        return Response::json($slider->paginate($limit));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'image' => 'required|mimes:png,jpg,jpeg',
        ]);

        if ($validation->fails()) {
            return Response::json([
                "status" => false,
                "message" => $validation->errors()
            ], 400);
        }

        $post = $request->except('image');

        $file = $request->file('image');
        $fileName = rand() . '.' . $file->getClientOriginalExtension();
        $path = 'sliders/';
        $file->move($path, $fileName);

        $post['image'] = $path . $fileName;

        $slider = Slider::create($post);

        return Response::json([
            "status" => true,
            "message" => "success.",
            "data" => [
                "id" => (int) $slider->id
            ]
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $slider = Slider::find($id);
        if ($slider  == null) {
            return Response::json([
                "status" => false,
                "message" => "Slider not found."
            ], 404);
        }

        return Response::json([
            "status" => true,
            "message" => "success.",
            "data" => $slider
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validation = Validator::make($request->all(), [
            'image' => 'required|mimes:png,jpg,jpeg',
        ]);

        if ($validation->fails()) {
            return Response::json([
                "status" => false,
                "message" => $validation->errors()
            ], 400);
        }

        $put = $request->except('image');

        $slider = Slider::find($id);

        $file = $request->file('image');
        $fileName = rand() . '.' . $file->getClientOriginalExtension();
        $path = 'sliders/';
        $file->move($path, $fileName);

        $put['image'] = $path . $fileName;

        $slider->update($put);

        return Response::json([
            "status" => true,
            "message" => "success.",
            "data" => $slider->id
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $slider = Slider::find($id);

        if ($slider  == null) {
            return Response::json([
                "status" => false,
                "message" => "Slider not found."
            ], 404);
        }

        $slider->delete();

        return Response::json([
            "status" => true,
            "message" => "success.",
            "data" => $id
        ], 200);
    }
}
