<?php

namespace App\Http\Controllers;

use App\Models\CC;
use App\Models\Deviation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Helpers;
class VidyaGxPAcademyController extends Controller
{
    public function index()
    {
        // CC, Regulatory Insepection, Deviation, CAPA

        $due_dates = [];


        $today = today();

        CC::all()->map(function ($query) use (&$due_dates, $today) {
            $due_dates[] = [
                'type' => 'CC',
                'title' =>  Helpers::getDivisionCode($query->division_id) . '/CC/' . date('Y') . '/' . str_pad($query->record, 4, '0', STR_PAD_LEFT),
                'start' => Carbon::parse($query->due_date)->toDateString(),
                'backgroundColor' => Carbon::parse($query->due_date)->subDays(2)->lt($today) ? 'red' : 'green'
            ];
        });
        Deviation::all()->map(function ($query) use (&$due_dates, $today) {
            $due_dates[] = [
                'type' => 'Deviation',
                'title' => $query->record,
                'start' => Carbon::parse($query->due_date)->toDateString(),
                'backgroundColor' => Carbon::parse($query->due_date)->subDays(2)->lt($today) ? 'red' : 'green'
            ];
        });

        
        
        return view('frontend.rcms.vacademy', compact('due_dates'));
    }
}
