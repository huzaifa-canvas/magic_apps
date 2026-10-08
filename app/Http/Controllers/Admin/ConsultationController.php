<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Consultations;

class ConsultationController extends Controller
{
    /**
     * List all consultations (latest first) for moderation.
     */
    public function index()
    {
        $consultations = Consultations::with(['user', 'category'])
            ->latest()
            ->paginate(20);

        return view('admin.consultations.index', compact('consultations'));
    }

    /**
     * Show a single consultation.
     */
    public function show(Consultations $consultation)
    {
        $consultation->load(['user', 'category']);

        return view('admin.consultations.show', compact('consultation'));
    }

    /**
     * Toggle status between active and inactive.
     */
    public function toggleStatus(Consultations $consultation)
    {
        $consultation->status = $consultation->status === 'active' ? 'inactive' : 'active';
        $consultation->save();

        return redirect()->back()->with('success', "Consultation #{$consultation->id} marked {$consultation->status}.");
    }

    /**
     * Delete a consultation.
     */
    public function destroy(Consultations $consultation)
    {
        $consultation->delete();

        return redirect()->route('admin.consultations.index')->with('success', 'Consultation deleted.');
    }
}
