<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use App\Models\Platform;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Posts created in the past 7 days (grouped by day)
        $postsLast7Days = Post::where('created_at', '>=', Carbon::now()->subDays(6)->startOfDay())
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Users created in the past 7 days
        $usersLast7Days = User::where('created_at', '>=', Carbon::now()->subDays(6)->startOfDay())
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Posts per platform
        $postsPerPlatform = Platform::withCount(['posts'])->get();

        // Scheduled vs Published counts (last 7 days)
        $scheduledCount = Post::where('status', 'scheduled')
            ->where('created_at', '>=', Carbon::now()->subDays(6)->startOfDay())
            ->count();
        $publishedCount = Post::where('status', 'published')
            ->where('created_at', '>=', Carbon::now()->subDays(6)->startOfDay())
            ->count();
        $successRate = ($publishedCount + $scheduledCount) > 0
            ? round($publishedCount / ($publishedCount + $scheduledCount) * 100, 1)
            : 0;

        return view('dashboard', [
            'postsLast7Days' => $postsLast7Days,
            'usersLast7Days' => $usersLast7Days,
            'postsPerPlatform' => $postsPerPlatform,
            'scheduledCount' => $scheduledCount,
            'publishedCount' => $publishedCount,
            'successRate' => $successRate,
        ]);
    }
} 