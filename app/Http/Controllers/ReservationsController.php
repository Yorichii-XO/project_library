<?php

namespace App\Http\Controllers;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationsController extends Controller
{
    public function index()
    {
        $reservations = Reservation::all();

        return response()->json([
            'success' => true,
            'data' => $reservations
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'member_id' => 'required|exists:members,id',
            'reserved_date' => 'nullable|date',
            'notification_sent' => 'boolean',
        ]);

        $reservation = Reservation::create($request->all());

        return response()->json([
            'success' => true,
            'data' => $reservation
        ], 201);
    }

    public function show($id)
    {
        $reservation = Reservation::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $reservation
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'book_id' => 'exists:books,id',
            'member_id' => 'exists:members,id',
            'reserved_date' => 'nullable|date',
            'notification_sent' => 'boolean',
        ]);

        $reservation = Reservation::findOrFail($id);
        $reservation->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Reservation updated successfully',
            'data' => $reservation
        ]);
    }

    public function destroy($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->delete();

        return response()->json([
            'success' => true,
            'message' => 'Reservation deleted successfully'
        ]);
    }
}
