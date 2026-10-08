<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserReport;

class ReportController extends Controller
{
    /**
     * List all user reports (latest first).
     */
    public function index()
    {
        $reports = UserReport::with(['reporter', 'reported'])
            ->latest()
            ->paginate(20);

        return view('admin.reports.index', compact('reports'));
    }

    /**
     * Show a single user report.
     */
    public function show(UserReport $report)
    {
        $report->load(['reporter', 'reported']);

        return view('admin.reports.show', compact('report'));
    }

    /**
     * Delete a user report.
     */
    public function destroy(UserReport $report)
    {
        $report->delete();

        return redirect()->route('admin.reports.index')->with('success', 'Report deleted.');
    }
}
