<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\ReportCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $data = [];

        if ($user->isSuperadmin()) {
            $data = [
                'totalUsers' => User::count(),
                'totalReports' => Report::count(),
                'pendingReports' => Report::submitted()->count(),
                'verifiedReports' => Report::verified()->count(),
                'categories' => ReportCategory::active()->count(),
                'recentReports' => Report::with(['user', 'reportCategory'])
                    ->latest()
                    ->take(5)
                    ->get(),
            ];
        } elseif ($user->isAdminBidang()) {
            $data = [
                'pendingReports' => Report::submitted()->count(),
                'verifiedReports' => Report::verified()->count(),
                'rejectedReports' => Report::rejected()->count(),
                'myVerifications' => Report::where('verified_by', $user->id)->count(),
                'recentReports' => Report::with(['user', 'reportCategory'])
                    ->submitted()
                    ->latest()
                    ->take(5)
                    ->get(),
            ];
        } elseif ($user->isAdminKecamatan()) {
            $data = [
                'myReports' => Report::where('user_id', $user->id)->count(),
                'draftReports' => Report::where('user_id', $user->id)->draft()->count(),
                'submittedReports' => Report::where('user_id', $user->id)->submitted()->count(),
                'verifiedReports' => Report::where('user_id', $user->id)->verified()->count(),
                'recentReports' => Report::with(['reportCategory'])
                    ->where('user_id', $user->id)
                    ->latest()
                    ->take(5)
                    ->get(),
            ];
        }

        return Inertia::render('dashboard', [
            'user' => $user,
            'stats' => $data,
        ]);
    }
}