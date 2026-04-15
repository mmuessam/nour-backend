<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CaseUpdate;
use Illuminate\Http\Request;

class CaseUpdateController extends Controller
{
    public function index(Request $request)
    {
        $query = CaseUpdate::with('addedBy')->orderBy('created_at', 'desc');

        if ($request->case_id) {
            $query->where('case_id', $request->case_id);
        }

        return response()->json($query->get());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'case_id'         => 'required|exists:cases,id',
            'title'           => 'required|string',
            'details'         => 'nullable|string',
            'donation_amount' => 'nullable|integer|min:0',
            'emoji'           => 'nullable|string',
        ]);

        $data['added_by'] = $request->user()->id;

        $update = CaseUpdate::create($data);
        return response()->json($update->load('addedBy'), 201);
    }

    public function show(string $id)
    {
        return response()->json(CaseUpdate::with('addedBy')->findOrFail($id));
    }

    public function update(Request $request, string $id)
    {
        $update = CaseUpdate::findOrFail($id);
        $data = $request->validate([
            'title'           => 'sometimes|string',
            'details'         => 'nullable|string',
            'donation_amount' => 'nullable|integer|min:0',
            'emoji'           => 'nullable|string',
        ]);
        $update->update($data);
        return response()->json($update->load('addedBy'));
    }

    public function destroy(string $id)
    {
        CaseUpdate::findOrFail($id)->delete();
        return response()->json(['message' => 'تم الحذف']);
    }
}
