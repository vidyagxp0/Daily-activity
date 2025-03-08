<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RecordNumber;
use App\Models\ProjectTaskManagement;

class ProjectTaskManagementController extends Controller
{
    // Create Form
    public function create()
    {
        $record_number = ((RecordNumber::first()->value('counter')) + 1);
        $record = str_pad($record_number, 6, '0', STR_PAD_LEFT);
        return view('frontend.Project-Planner.projectplanner',compact( 'record_number'));
    }

    // Store Data
    public function store(Request $request)
    {
        $request->validate([
            'dataprojectplanner' => 'required|array',
        ]);

        ProjectTaskManagement::create([
            'identifier' => 'Task Management Data',
            'data' => json_encode($request->dataprojectplanner),
        ]);

        toastr()->success('Record Created Successfully');
        return redirect(url('rcms/qms-dashboard'));
    }

    // Update Data
    public function update(Request $request, $id)
    {
        $task = ProjectTaskManagement::find($id);

        if ($task && !empty($request->dataprojectplanner)) {
            $task->update(['data' => json_encode($request->dataprojectplanner)]);
            toastr()->success('Record Updated Successfully');
        } else {
            toastr()->error('Invalid Data Provided');
        }

        return back();
    }

    // Fetch Holidays & Weekends for Selected Company
    public function getHolidaysWeekends(Request $request)
    {
        $companyId = $request->company_id;

        if (!$companyId) {
            return response()->json(['holidays' => [], 'weekends' => []]);
        }

        $holidays = DB::table('company_holidays')
            ->where('company_id', $companyId)
            ->pluck('date')
            ->toArray();

        $weekends = DB::table('weekend_days')
            ->where('company_id', $companyId)
            ->pluck('day')
            ->toArray();

        return response()->json(['holidays' => $holidays, 'weekends' => $weekends]);
    }

    // Calculate End Date Based on Working Days
    public function calculateEndDate(Request $request)
    {
        $startDate = Carbon::parse($request->start_date);
        $days = $request->no_of_days;
        $holidays = $request->holidays;
        $weekends = $request->weekends;
        $count = 0;

        while ($count < $days) {
            $startDate->addDay();
            if (!in_array($startDate->format('Y-m-d'), $holidays) && !in_array($startDate->format('l'), $weekends)) {
                $count++;
            }
        }

        return response()->json(['end_date' => $startDate->format('Y-m-d')]);
    }

    // Fetch & Display Data
    public function index($id)
    {
        $task = ProjectTaskManagement::find($id);
        $record_number = ((RecordNumber::first()->value('counter')) + 1);
        $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);

        if (!$task) {
            toastr()->error('Task Not Found');
            return back();
        }

        $tasks = json_decode($task->data, true) ?? [];
        return view('frontend.Project-Planner.projectplannerview', compact('task', 'tasks','record_number'));
    }
}
    