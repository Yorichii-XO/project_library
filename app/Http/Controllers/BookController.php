<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Support\Facades\Validator;
class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::query();

        // Apply search filters if provided
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('title', 'like', "%$search%")
                  ->orWhere('author', 'like', "%$search%")
                  ->orWhere('genre', 'like', "%$search%");
        }

        // Paginate the results
        $books = $query->paginate(10); // Adjust the pagination size as needed

        return response()->json([
            'success' => true,
            'data' => $books
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'genre' => 'required|string|max:255',
            'published_year' => 'required|integer',
            'isbn' => 'required|string|max:255|unique:books',
            'copies_available' => 'required|integer',
        ]);

        $book = Book::create($request->all());
        return response()->json($book, 201);
    }

    public function show($id)
    {
        $book = Book::findOrFail($id);
        return response()->json($book);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'string|max:255',
            'author' => 'string|max:255',
            'genre' => 'string|max:255',
            'published_year' => 'integer',
            'isbn' => 'string|max:255|unique:books,isbn,'.$id,
            'copies_available' => 'integer',
        ]);

        $book = Book::findOrFail($id);
        $book->update($request->all());
        return response()->json($book);
    }

    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        $book->delete();
        return response()->json(null, 204);
    }
}
