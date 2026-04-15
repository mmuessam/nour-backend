<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use App\Models\HelpCase;
use Illuminate\Http\Request;

class DonationController extends Controller
{
    public function index(Request $request)
    {
        $query = Donation::with(['case', 'addedBy'])
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc');

        if ($request->case_id) {
            $query->where('case_id', $request->case_id);
        }

        return response()->json($query->get());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'case_id'     => 'required|exists:cases,id',
            'amount'      => 'required|integer|min:1',
            'source'      => 'required|in:organization,external,admin,volunteer',
            'source_name' => 'required|string',
            'method'      => 'required|string',
            'date'        => 'required|date',
            'notes'       => 'nullable|string',
        ]);

        $count = Donation::count() + 1;
        $data['donation_number'] = 'DON-' . str_pad($count, 3, '0', STR_PAD_LEFT);
        $data['added_by'] = $request->user()->id;

        $donation = Donation::create($data);

        // Update case collected amount
        HelpCase::where('id', $data['case_id'])->increment('collected', $data['amount']);

        return response()->json($donation->load(['case', 'addedBy']), 201);
    }

    public function show(string $id)
    {
        return response()->json(Donation::with(['case', 'addedBy'])->findOrFail($id));
    }

    public function update(Request $request, string $id)
    {
        $donation = Donation::findOrFail($id);
        $data = $request->validate([
            'amount'      => 'sometimes|integer|min:1',
            'source'      => 'sometimes|in:organization,external,admin,volunteer',
            'source_name' => 'sometimes|string',
            'method'      => 'sometimes|string',
            'date'        => 'sometimes|date',
            'notes'       => 'nullable|string',
        ]);

        // Adjust collected if amount changed
        if (isset($data['amount']) && $data['amount'] !== $donation->amount) {
            $diff = $data['amount'] - $donation->amount;
            HelpCase::where('id', $donation->case_id)->increment('collected', $diff);
        }

        $donation->update($data);
        return response()->json($donation->load(['case', 'addedBy']));
    }

    public function destroy(string $id)
    {
        $donation = Donation::findOrFail($id);
        HelpCase::where('id', $donation->case_id)->decrement('collected', $donation->amount);
        $donation->delete();
        return response()->json(['message' => 'تم الحذف']);
    }
}
