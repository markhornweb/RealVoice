<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function userStatisticsCard() {
        $allUsersCount = User::all()->count();

        $activeUserCount = User::where("is_active", 1)->count();

        return view('usercount', compact('allUsersCount', 'activeUserCount'));

    }

    public function userStatisticsChart(Request $request) {
        if($request->type == "daily") {
            $result = $this->dailyStatistics();
        } else if($request->type == "weekly") {
            $result = $this->weeklyStatistics();
        } else if($request->type == "monthly") {
            $result = $this->monthlyStatistics();
        } else {
            $result = $this->yearlyStatistics();
        }

        return $result;
    }

    private function dailyStatistics()
    {
        $startDate = Carbon::now()->subDays(9)->startOfDay();
        $endDate = Carbon::now()->endOfDay();
        
        $dates = [];
        $currentDate = clone $startDate;
        while ($currentDate <= $endDate) {
            $dates[] = $currentDate->format('Y-m-d');
            $currentDate->addDay();
        }
        
        $usersCountByDay = User::whereBetween('created_at', [$startDate, $endDate])
                            ->groupBy(\DB::raw('DATE(created_at)'))
                            ->orderBy('date')
                            ->get(array(
                                    \DB::raw('DATE(created_at) as date'),
                                    \DB::raw('COUNT(*) as count')
                            ));
        
        $result = [];
        foreach ($dates as $date) {
            $result[$date] = 0;
        }
        foreach ($usersCountByDay as $data) {
            $result[$data->date] = $data->count;
        }

        return $result;
    }

    public function weeklyStatistics()
    {
        $startDate = Carbon::now()->subWeeks(7)->startOfWeek();
        $endDate = Carbon::now()->endOfWeek();

        $weeks = [];
        $currentWeek = clone $startDate;
        while ($currentWeek <= $endDate) {
            $weeks[] = $currentWeek->format('Y-W');
            $currentWeek->addWeek();
        }

        $usersCountByWeek = User::whereBetween('created_at', [$startDate, $endDate])
                            ->selectRaw('DATE_FORMAT(created_at, "%Y-%u") as week, COUNT(*) as count')
                            ->groupBy('week')
                            ->orderBy('week')
                            ->get();

        $result = [];

        foreach ($weeks as $week) {
            $result[$week] = 0;
        }
        foreach ($usersCountByWeek as $data) {
            $result[$data->week] = $data->count;
        }

        return $result;
    }

    public function monthlyStatistics()
    {
        $startDate = Carbon::now()->subMonths(11)->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();
        
        $dates = [];
        $currentDate = clone $startDate;
        while ($currentDate <= $endDate) {
            $dates[] = $currentDate->format('Y-m');
            $currentDate->addMonth();
        }
        
        $usersCountByMonth = User::whereBetween('created_at', [$startDate, $endDate])
                            ->groupBy(\DB::raw('DATE_FORMAT(created_at, "%Y-%m")'))
                            ->orderBy('month')
                            ->get(array(
                                \DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                                \DB::raw('COUNT(*) as count')
                            ));
        
        $result = [];
        foreach ($dates as $date) {
            $result[$date] = 0;
        }
        foreach ($usersCountByMonth as $data) {
            $result[$data->month] = $data->count;
        }

        return $result;
    }

    public function yearlyStatistics()
    {
        $startDate = Carbon::now()->subYears(9)->startOfYear();
        $endDate = Carbon::now()->endOfYear();
        
        $dates = [];
        $currentDate = clone $startDate;
        while ($currentDate <= $endDate) {
            $dates[] = $currentDate->format('Y');
            $currentDate->addYear();
        }
        
        $usersCountByYear = User::whereBetween('created_at', [$startDate, $endDate])
                            ->groupBy(\DB::raw('YEAR(created_at)'))
                            ->orderBy('year')
                            ->get(array(
                                \DB::raw('YEAR(created_at) as year'),
                                \DB::raw('COUNT(*) as count')
                            ));
        
        $result = [];
        foreach ($dates as $date) {
            $result[$date] = 0;
        }
        foreach ($usersCountByYear as $data) {
            $result[$data->year] = $data->count;
        }

        return $result;
    }
}
