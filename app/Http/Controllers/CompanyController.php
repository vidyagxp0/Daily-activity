<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\CompanyHoliday;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CompanyController extends Controller
{
    // Get all companies
    public function index()
    {
        return response()->json(Company::with('holidays')->get());
    }

    // Store a new company
    public function store(Request $request)
    {
        $request->validate(['name' => 'required|unique:companies']);

        $company = Company::create(['name' => $request->name]);

        return response()->json(['message' => 'Company created successfully', 'company' => $company]);
    }

    // Store holidays for a company (Only for current year)
    public function storeHolidays(Request $request, $company_id)
    {
        $request->validate([
            'holidays' => 'required|array',
            'holidays.*.start_date' => 'required|date_format:Y-m-d',
            'holidays.*.end_date' => 'required|date_format:Y-m-d|after_or_equal:holidays.*.start_date',
            'holidays.*.reason' => 'required|string|max:255',
        ]);
    
        $company = Company::findOrFail($company_id);
        
        foreach ($request->holidays as $holiday) {
            CompanyHoliday::create([
                'company_id' => $company->id,
                'start_date' => $holiday['start_date'],
                'end_date' => $holiday['end_date'],
                'reason' => $holiday['reason']
            ]);
        }
    
        // ✅ Corrected redirection to the dashboard
        return redirect()->to(url('rcms/qms-dashboard'))->with('success', 'Holidays added successfully!');
    }
    
    public function showHolidays()
    {
        $companies = Company::all(); // Fetch all companies
        $holidays = CompanyHoliday::with('company')->get(); // Fetch holidays with company details
    
        return view('frontend.holidaays.holidays', compact('companies', 'holidays'));
    }

    // Get a company's holidays
    public function getHolidays($company_id)
    {
        $holidays = CompanyHoliday::where('company_id', $company_id)->get();
        return response()->json($holidays);
    }

    // Delete a holiday
    public function deleteHoliday($holiday_id)
    {
        CompanyHoliday::findOrFail($holiday_id)->delete();
        return response()->json(['message' => 'Holiday deleted successfully']);
    }
}
