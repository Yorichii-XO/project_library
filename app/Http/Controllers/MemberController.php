<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\User;
class MemberController extends Controller
{
    public function index(Request $request)
    {
        $query = Member::query();

        // Apply search filters if provided
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%");
        }

        // Paginate the results
        $members = $query->paginate(3); // Adjust the pagination size as needed

        return response()->json([
            'success' => true,
            'data' => $members
        ]);
    }

    public function show($id)
    {
        $member = Member::findOrFail($id);
        return response()->json($member);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:members',
            'membership_date' => 'required|date',
            'membership_status' => 'required|in:active,inactive',
        ]);

        //  $member = Member::create($request->all());
        // return response()->json($member, 201);
        Member::create($request->all());
        return response()->json(['message' => 'Create member Successfully ']);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|max:255|unique:members,email,'.$id,
            'membership_date' => 'sometimes|date',
            'membership_status' => 'sometimes|in:active,inactive',
        ]);

        $member = Member::findOrFail($id);
        $member->update($request->all());
        return response()->json($member);
    }

    public function destroy($id)
    {
        $member = Member::findOrFail($id);
        $member->delete();
        return response()->json(null, 204);
    }
}
