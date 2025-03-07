<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\CompanyHoliday;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;


class CompanyController extends Controller
{
    // Get all companies with their holidays
    public function index()
    {
        try {
            $companies = Company::with('holidays')->get();
            return response()->json($companies);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch companies.'], 500);
        }
    }

    // Store a new company and its holidays
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'company_id' => 'required|exists:companies,id',
            'holidays' => 'required|array',
            'holidays.*.start_date' => 'required|date',
            'holidays.*.end_date' => 'required|date|after_or_equal:holidays.*.start_date',
            'holidays.*.reason' => 'required|string|max:255',
        ]);

        // Debugging: Inspect the request payload
        dd($request->all());

        try {
            // Save each holiday
            foreach ($request->holidays as $holiday) {
                CompanyHoliday::create([
                    'company_id' => $request->company_id,
                    'start_date' => $holiday['start_date'],
                    'end_date' => $holiday['end_date'],
                    'reason' => $holiday['reason'],
                ]);
            }

            return redirect('/rcms/qms-dashboard')->with('success', 'Holidays added successfully!');
        } catch (\Exception $e) {
            // Debugging: Inspect the error
            dd($e->getMessage());
        }
    }

    // Store holidays for a specific company (for the current year)
    public function storeHolidays(Request $request)
{
    // Validate the request
    $validatedData = $request->validate([
        'company_id' => 'required|exists:companies,id',
        'holidays' => 'required|array',
        'holidays.*.start_date' => 'required|date',
        'holidays.*.end_date' => 'required|date|after_or_equal:holidays.*.start_date',
        'holidays.*.reason' => 'required|string|max:255',
    ]);

    try {
        // Save each holiday
        foreach ($request->holidays as $holiday) {
            CompanyHoliday::create([
                'company_id' => $request->company_id,
                'start_date' => $holiday['start_date'],
                'end_date' => $holiday['end_date'],
                'reason' => $holiday['reason'],
            ]);
        }

        return response()->json(['success' => true]);
    } catch (\Exception $e) {
        // Log the error
        Log::error('Error saving holidays:', ['error' => $e->getMessage()]);
        return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
    }
}
    
    // Show holidays for all companies
    public function showHolidays()
    {
        $companies = Company::all(); // Fetch all companies
        $holidays = CompanyHoliday::with('company')->get(); // Fetch holidays with company details

        return view('frontend.holidaays.holidays', compact('companies', 'holidays'));
    }

    // Get a company's holidays
    public function getHolidays($company_id)
    {
        try {
            $holidays = CompanyHoliday::where('company_id', $company_id)->get();
            return response()->json($holidays);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch holidays.'], 500);
        }
    }

    // Delete a holiday
    public function deleteHoliday($holiday_id)
    {
        try {
            CompanyHoliday::findOrFail($holiday_id)->delete();
            return response()->json(['message' => 'Holiday deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete holiday.'], 500);
        }
    }
}