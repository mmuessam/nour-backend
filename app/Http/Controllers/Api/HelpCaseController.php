<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HelpCase;
use App\Models\Category;
use Illuminate\Http\Request;

class HelpCaseController extends Controller
{
    public function index(Request $request)
    {
        $query = HelpCase::with(['category', 'creator'])
            ->orderBy('created_at', 'desc');

        if ($request->status && $request->status !== 'all') {
            $query->where('status', $request->status);
        }
        if ($request->category_id) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%'.$request->search.'%')
                  ->orWhere('case_number', 'like', '%'.$request->search.'%')
                  ->orWhere('beneficiary', 'like', '%'.$request->search.'%');
            });
        }

        return response()->json($query->get());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'beneficiary' => 'nullable|string',
            'target'      => 'required|integer|min:1',
            'status'      => 'in:active,urgent,completed,paused',
            'priority'    => 'in:low,medium,high,critical',
            'location'    => 'nullable|string',
            'image'       => 'nullable|string',
        ]);

        // Generate case number
        $count = HelpCase::count() + 1;
        $data['case_number'] = 'NR-' . date('Y') . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
        $data['created_by']  = $request->user()->id;
        $data['collected']   = 0;

        $case = HelpCase::create($data);

        // Update category cases count
        Category::where('id', $data['category_id'])->increment('cases_count');

        return response()->json($case->load(['category', 'creator']), 201);
    }

    public function show(string $id)
    {
        $case = HelpCase::with(['category', 'creator', 'donations.addedBy', 'updates.addedBy'])
            ->findOrFail($id);
        return response()->json($case);
    }

    public function update(Request $request, string $id)
    {
        $case = HelpCase::findOrFail($id);
        $data = $request->validate([
            'title'       => 'sometimes|string',
            'category_id' => 'sometimes|exists:categories,id',
            'description' => 'nullable|string',
            'beneficiary' => 'nullable|string',
            'target'      => 'sometimes|integer|min:1',
            'collected'   => 'sometimes|integer|min:0',
            'status'      => 'sometimes|in:active,urgent,completed,paused',
            'priority'    => 'sometimes|in:low,medium,high,critical',
            'location'    => 'nullable|string',
            'image'       => 'nullable|string',
        ]);
        $case->update($data);
        return response()->json($case->load(['category', 'creator']));
    }

    public function destroy(string $id)
    {
        $case = HelpCase::findOrFail($id);
        Category::where('id', $case->category_id)->decrement('cases_count');
        $case->delete();
        return response()->json(['message' => 'تم الحذف']);
    }
}
