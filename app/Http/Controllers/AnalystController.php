<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\RecordNumber;
use Carbon\Carbon;
use App\Models\Employee;


class AnalystController extends Controller
{
    public function index()
    {
        $record = ((RecordNumber::first()->value('counter')) + 1);
        $record = str_pad($record, 4, '0', STR_PAD_LEFT);
        $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $due_date = $formattedDate->format('Y-m-d');
        $employees = Employee::all();
        return view('frontend.TMS.analyst-qualification.create', compact('due_date', 'record','employees'));
    }
}
