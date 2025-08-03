<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReportRequest;
use App\Http\Requests\UpdateReportRequest;
use App\Models\Report;
use App\Models\ReportCategory;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        
        $query = Report::with(['user', 'reportCategory', 'verifier']);
        
        // Filter based on user role
        if ($user->isAdminKecamatan()) {
            $query->where('user_id', $user->id);
        } elseif ($user->isAdminBidang()) {
            // Admin bidang can see all submitted reports
            $query->whereIn('status', ['submitted', 'verified', 'rejected']);
        }
        
        // Apply filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('category')) {
            $query->where('report_category_id', $request->category);
        }
        
        if ($request->filled('district')) {
            $query->where('district', $request->district);
        }
        
        $reports = $query->latest()->paginate(10);
        
        return Inertia::render('reports/index', [
            'reports' => $reports,
            'categories' => ReportCategory::active()->get(),
            'filters' => $request->all(['status', 'category', 'district']),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $categories = ReportCategory::active()->with('templateFields')->get();
        
        return Inertia::render('reports/create', [
            'categories' => $categories,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReportRequest $request)
    {
        $report = Report::create([
            'user_id' => $request->user()->id,
            'report_category_id' => $request->report_category_id,
            'title' => $request->title,
            'description' => $request->description,
            'data' => $request->data,
            'report_date' => $request->report_date,
            'district' => $request->user()->district,
            'status' => $request->status ?? 'draft',
        ]);

        return redirect()->route('reports.show', $report)
            ->with('success', 'Laporan berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Report $report, Request $request)
    {
        $user = $request->user();
        
        // Check access permissions
        if ($user->isAdminKecamatan() && $report->user_id !== $user->id) {
            abort(403, 'Anda tidak memiliki akses ke laporan ini.');
        }
        
        $report->load(['user', 'reportCategory.templateFields', 'verifier']);
        
        return Inertia::render('reports/show', [
            'report' => $report,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Report $report, Request $request)
    {
        $user = $request->user();
        
        // Only allow editing if it's the owner and status is draft
        if ($user->isAdminKecamatan() && ($report->user_id !== $user->id || $report->status !== 'draft')) {
            abort(403, 'Laporan ini tidak dapat diedit.');
        }
        
        $report->load(['reportCategory.templateFields']);
        $categories = ReportCategory::active()->with('templateFields')->get();
        
        return Inertia::render('reports/edit', [
            'report' => $report,
            'categories' => $categories,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReportRequest $request, Report $report)
    {
        $user = $request->user();
        
        // Handle verification by Admin Bidang/Superadmin
        if ($user->isAdminBidang() || $user->isSuperadmin()) {
            $report->update([
                'status' => $request->status,
                'verified_by' => $user->id,
                'verified_at' => now(),
                'verification_notes' => $request->verification_notes,
            ]);
            
            $message = $request->status === 'verified' ? 'Laporan berhasil diverifikasi.' : 'Laporan berhasil ditolak.';
            
            return redirect()->route('reports.show', $report)
                ->with('success', $message);
        }
        
        // Handle regular update by Admin Kecamatan
        $report->update($request->validated());

        return redirect()->route('reports.show', $report)
            ->with('success', 'Laporan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Report $report, Request $request)
    {
        $user = $request->user();
        
        // Check permissions
        if ($user->isAdminKecamatan() && ($report->user_id !== $user->id || $report->status !== 'draft')) {
            abort(403, 'Laporan ini tidak dapat dihapus.');
        }
        
        $report->delete();

        return redirect()->route('reports.index')
            ->with('success', 'Laporan berhasil dihapus.');
    }


}