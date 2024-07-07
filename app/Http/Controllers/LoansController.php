<?php

namespace App\Http\Controllers;
use App\Models\Loan;

use Illuminate\Http\Request;

class LoansController extends Controller
{
    public function index()
    {
        $loans = Loan::all();

        return response()->json([
            'success' => true,
            'data' => $loans
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'member_id' => 'required|exists:members,id',
            'issued_date' => 'nullable|date',
            'due_date' => 'nullable|date',
            'returned_date' => 'nullable|date',
            'fine_amount' => 'nullable|numeric',
        ]);

        $loan = Loan::create($request->all());

        return response()->json([
            'success' => true,
            'data' => $loan
        ], 201);
    }

    public function show($id)
    {
        $loan = Loan::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $loan
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'book_id' => 'exists:books,id',
            'member_id' => 'exists:members,id',
            'issued_date' => 'nullable|date',
            'due_date' => 'nullable|date',
            'returned_date' => 'nullable|date',
            'fine_amount' => 'nullable|numeric',
        ]);

        $loan = Loan::findOrFail($id);
        $loan->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Loan updated successfully',
            'data' => $loan
        ]);
    }
    public function returnBook(Request $request, $id)
    {
        $request->validate([
            'returned_date' => 'required|date',
            'fine_amount' => 'nullable|numeric',
        ]);

        $loan = Loan::findOrFail($id);
        $loan->update([
            'returned_date' => $request->returned_date,
            'fine_amount' => $request->fine_amount ?? 0,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Book returned successfully',
            'data' => $loan
        ]);
    }

    public function destroy($id)
    {
        $loan = Loan::findOrFail($id);
        $loan->delete();

        return response()->json([
            'success' => true,
            'message' => 'Loan deleted successfully'
        ]);
    }
}
