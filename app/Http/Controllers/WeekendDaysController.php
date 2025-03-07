<?php

namespace App\Http\Controllers;

use App\Models\WeekendDays;
use Illuminate\Http\Request;

class WeekendDaysController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'weekend_days' => 'required|array',
            'year' => 'required|string',
        ]);

        WeekendDays::create([
            'company_name' => $request->company_name,
            'weekend_days' => json_encode($request->weekend_days),
            'year' => $request->year,
        ]);

        return back()->with('success', 'Weekend Days Saved Successfully!');
    }
}
