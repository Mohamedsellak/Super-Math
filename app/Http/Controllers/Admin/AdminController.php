<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Question;
use App\Models\CreditHistory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Show the admin dashboard with real data.
     */
    public function index()
    {
        // Time range: last 6 months including current
        $now = Carbon::now();
        $months = collect(range(0, 5))->map(fn ($i) => $now->copy()->subMonths(5 - $i)->startOfMonth());
        $monthKeyFormat = 'Y-m';

        // User registrations per month
        $rawUserMonthly = User::select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") as ym'), DB::raw('COUNT(*) as total'))
            ->where('created_at', '>=', $months->first())
            ->groupBy('ym')
            ->pluck('total', 'ym');
        $userGrowthLabels = $months->map(fn ($d) => $d->format('M'));
        $userGrowthData = $months->map(fn ($d) => (int) ($rawUserMonthly[$d->format($monthKeyFormat)] ?? 0));

        $currentMonthUsers = $userGrowthData->last();
        $prevMonthUsers = $userGrowthData->count() > 1 ? $userGrowthData[$userGrowthData->count() - 2] : 0;
        $userGrowthPercent = $prevMonthUsers > 0 ? round((($currentMonthUsers - $prevMonthUsers) / max($prevMonthUsers, 1)) * 100, 1) : null;

        // Question difficulty distribution (already pre-counted)
        $difficultyCounts = Question::select('difficulty', DB::raw('COUNT(*) as total'))
            ->groupBy('difficulty')
            ->pluck('total', 'difficulty');
        $easyCount = (int) ($difficultyCounts['easy'] ?? 0);
        $mediumCount = (int) ($difficultyCounts['medium'] ?? 0);
        $hardCount = (int) ($difficultyCounts['hard'] ?? 0);

        // Total counts
        $totalUsers = User::count();
        $totalQuestions = Question::count();

        // Universities / institutions & regions
        $institutionsCount = Question::distinct('institution')->count('institution');
        $regionsCount = Question::distinct('region')->count('region');

        // Recent questions
        $recentQuestions = Question::latest()->take(5)->get();

        // Revenue stats (if any purchases)
        $totalRevenue = CreditHistory::where('action', 'purchase')->sum('amount');
        $rawRevenueMonthly = CreditHistory::where('action', 'purchase')
            ->select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") as ym'), DB::raw('SUM(amount) as total'))
            ->where('created_at', '>=', $months->first())
            ->groupBy('ym')
            ->pluck('total', 'ym');
        $revenueMonthlyData = $months->map(fn ($d) => (float) ($rawRevenueMonthly[$d->format($monthKeyFormat)] ?? 0.0));
        $currentRevenue = $revenueMonthlyData->last();
        $prevRevenue = $revenueMonthlyData->count() > 1 ? $revenueMonthlyData[$revenueMonthlyData->count() - 2] : 0.0;
        $revenueGrowthPercent = $prevRevenue > 0 ? round((($currentRevenue - $prevRevenue) / max($prevRevenue, 0.01)) * 100, 1) : null;

        // Active users approximation (users updated within last 15 minutes)
        $activeUsers = User::where('updated_at', '>=', now()->subMinutes(15))->count();

        return view('admin.dashboard', [
            'totalUsers' => $totalUsers,
            'totalQuestions' => $totalQuestions,
            'easyCount' => $easyCount,
            'mediumCount' => $mediumCount,
            'hardCount' => $hardCount,
            'institutionsCount' => $institutionsCount,
            'regionsCount' => $regionsCount,
            'recentQuestions' => $recentQuestions,
            'userGrowthLabels' => $userGrowthLabels,
            'userGrowthData' => $userGrowthData,
            'userGrowthPercent' => $userGrowthPercent,
            'totalRevenue' => $totalRevenue,
            'revenueMonthlyData' => $revenueMonthlyData,
            'revenueGrowthPercent' => $revenueGrowthPercent,
            'activeUsers' => $activeUsers,
        ]);
    }
}
