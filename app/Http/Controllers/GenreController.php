<?php

namespace App\Http\Controllers;
use App\Models\Genre;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;

class GenreController extends Controller
{
    public function index()
    {
        return Genre::all();
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $genre = Genre::create($request->all());

        return response()->json($genre, 201);
    }

    public function show($id)
    {
        $genre = Genre::find($id);

        if (is_null($genre)) {
            return response()->json(['message' => 'Genre not found'], 404);
        }

        return response()->json($genre);
    }

    public function update(Request $request, $id)
    {
        $genre = Genre::find($id);

        if (is_null($genre)) {
            return response()->json(['message' => 'Genre not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $genre->update($request->all());

        return response()->json($genre);
    }

    public function destroy($id)
    {
        $genre = Genre::find($id);

        if (is_null($genre)) {
            return response()->json(['message' => 'Genre not found'], 404);
        }

        $genre->delete();

        return response()->json(['message' => 'Genre deleted']);
    }
}
