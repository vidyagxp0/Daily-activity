<?php

namespace App\Http\Controllers;

use App\Models\LoginLogoutActivity;
use App\Models\User;
use App\Models\User_monitoring;
use Illuminate\Http\Request;

class UserMonitoringController extends Controller
{
    public function index()
    {
        $now = now();

        $max_time = $now->subMinutes(5);

        $login_activities = User_monitoring::where('created_at', '>=', $max_time)
                           ->get();
        // $login_activities = User_monitoring::where('created_at', '>=', today())
        //                    ->get();

        return view('admin.usermonitoring.monitoring', compact('login_activities'));
    }
}

