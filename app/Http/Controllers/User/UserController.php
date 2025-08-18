<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CreditHistory;
use App\Models\Question;
use App\Models\Subject;
use App\Models\Topic;
use App\Models\User; // added

class UserController extends Controller
{

    /**
     * Show the user dashboard with real data.
     */
    public function index()
    {
        /** @var User $user */
        $user = Auth::user();

        // Basic stats
        $availableCredits = (int) ($user->credit ?? 0);
        $creditExpiresAt = $user->credit_expires_at;

        // Downloads count (credits spent on downloads)
        $downloadsCount = CreditHistory::where('user_id', $user->id)
            ->where('action', 'Download')
            ->count();

        // Recent credit history (latest 5)
        $recentCreditHistory = $user->creditHistories()
            ->latest()
            ->take(5)
            ->get();

        // Content counts
        $questionsCount = Question::count();
        $subjectsCount = Subject::count();
        $topicsCount = Topic::count();

        // Chart data: last 14 days of downloads
        $downloadsPerDay = CreditHistory::selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->where('user_id', $user->id)
            ->where('action', 'Download')
            ->where('created_at', '>=', now()->subDays(13)->startOfDay())
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date');

        $period = collect();
        for ($i = 13; $i >= 0; $i--) {
            $date = now()->subDays($i)->toDateString();
            $period->push([
                'date' => $date,
                'label' => now()->subDays($i)->format('d M'),
                'count' => (int) ($downloadsPerDay[$date]->total ?? 0)
            ]);
        }

        $downloadsChartLabels = $period->pluck('label');
        $downloadsChartData = $period->pluck('count');

        return view('user.dashboard', compact(
            'user',
            'availableCredits',
            'creditExpiresAt',
            'downloadsCount',
            'recentCreditHistory',
            'questionsCount',
            'subjectsCount',
            'topicsCount',
            'downloadsChartLabels',
            'downloadsChartData'
        ));
    }

}
