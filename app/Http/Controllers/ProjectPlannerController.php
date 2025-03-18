<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\CompanyHoliday;
use App\Models\CompanyWeekend;
use App\Models\ProjectPlanner;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class ProjectPlannerController extends Controller
{
    // Company CRUD
    public function createCompany(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:companies,name',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            $company = Company::create($request->only('name'));
            return response()->json($company, 201);
        } catch (\Exception $e) {
            Log::error('Error creating company: ' . $e->getMessage());
            return response()->json(['message' => 'An error occurred while creating the company'], 500);
        }
    }

    public function getAllCompanies()
{
    try {
        $companies = Company::select('company_id', 'name')->get();
        return response()->json($companies);
    } catch (\Exception $e) {
        Log::error('Error fetching companies: ' . $e->getMessage());
        return response()->json(['message' => 'An error occurred while fetching companies'], 500);
    }
}


    public function getCompany($id)
    {
        try {
            $company = Company::find($id);
            if (!$company) {
                return response()->json(['message' => 'Company not found'], 404);
            }
            return response()->json($company);
        } catch (\Exception $e) {
            Log::error('Error fetching company: ' . $e->getMessage());
            return response()->json(['message' => 'An error occurred while fetching the company'], 500);
        }
    }

    public function updateCompany(Request $request, $id)
    {
        try {
            $company = Company::find($id);
            if (!$company) {
                return response()->json(['message' => 'Company not found'], 404);
            }

            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:companies,name,' . $id,
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            $company->update($request->only('name'));
            return response()->json($company);
        } catch (\Exception $e) {
            Log::error('Error updating company: ' . $e->getMessage());
            return response()->json(['message' => 'An error occurred while updating the company'], 500);
        }
    }

    public function deleteCompany($id)
    {
        try {
            $company = Company::find($id);
            if (!$company) {
                return response()->json(['message' => 'Company not found'], 404);
            }
            $company->delete();
            return response()->json(['message' => 'Company deleted']);
        } catch (\Exception $e) {
            Log::error('Error deleting company: ' . $e->getMessage());
            return response()->json(['message' => 'An error occurred while deleting the company'], 500);
        }
    }

    // Company Holidays CRUD
    public function createHoliday(Request $request, $companyId)
    {
        try {
            $validator = Validator::make($request->all(), [
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
                'reason' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            $holiday = CompanyHoliday::create([
                'company_id' => $companyId,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'reason' => $request->reason,
            ]);

            return response()->json($holiday, 201);
        } catch (\Exception $e) {
            Log::error('Error creating holiday: ' . $e->getMessage());
            return response()->json(['message' => 'An error occurred while creating the holiday'. $e->getMessage()], 500);
        }
    }

    public function getHolidays($companyId)
    {
        try {
            $holidays = CompanyHoliday::where('company_id', $companyId)->get();
            return response()->json($holidays);
        } catch (\Exception $e) {
            Log::error('Error fetching holidays: ' . $e->getMessage());
            return response()->json(['message' => 'An error occurred while fetching holidays'], 500);
        }
    }

    public function updateHoliday(Request $request, $id)
    {
        try {
            $holiday = CompanyHoliday::find($id);
            if (!$holiday) {
                return response()->json(['message' => 'Holiday not found'], 404);
            }

            $validator = Validator::make($request->all(), [
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
                'reason' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            $holiday->update($request->only(['start_date', 'end_date', 'reason']));
            return response()->json($holiday);
        } catch (\Exception $e) {
            Log::error('Error updating holiday: ' . $e->getMessage());
            return response()->json(['message' => 'An error occurred while updating the holiday'], 500);
        }
    }

    public function deleteHoliday($id)
    {
        try {
            $holiday = CompanyHoliday::find($id);
            if (!$holiday) {
                return response()->json(['message' => 'Holiday not found'], 404);
            }
            $holiday->delete();
            return response()->json(['message' => 'Holiday deleted']);
        } catch (\Exception $e) {
            Log::error('Error deleting holiday: ' . $e->getMessage());
            return response()->json(['message' => 'An error occurred while deleting the holiday'], 500);
        }
    }

    // Company Weekends CRUD
    public function createWeekend(Request $request, $companyId)
    {
        try {
            $validator = Validator::make($request->all(), [
                'weekend_days' => 'required|array',
                'year' => 'required|digits:4',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            // Ensure only one weekend record per company
            $existingWeekend = CompanyWeekend::where('company_id', $companyId)->first();
            if ($existingWeekend) {
                return response()->json(['message' => 'Weekend record already exists for this company'], 400);
            }

            $weekend = CompanyWeekend::create([
                'company_id' => $companyId,
                'weekend_days' => $request->weekend_days,
                'year' => $request->year,
            ]);

            return response()->json($weekend, 201);
        } catch (\Exception $e) {
            Log::error('Error creating weekend: ' . $e->getMessage());
            return response()->json(['message' => 'An error occurred while creating the weekend'], 500);
        }
    }

    public function getWeekend($companyId)
    {
        try {
            $weekend = CompanyWeekend::where('company_id', $companyId)->first();
            if (!$weekend) {
                return response()->json(['message' => 'Weekend record not found'], 404);
            }
            return response()->json($weekend);
        } catch (\Exception $e) {
            Log::error('Error fetching weekend: ' . $e->getMessage());
            return response()->json(['message' => 'An error occurred while fetching the weekend'], 500);
        }
    }

    public function updateWeekend(Request $request, $id)
    {
        try {
            $weekend = CompanyWeekend::find($id);
            if (!$weekend) {
                return response()->json(['message' => 'Weekend record not found'], 404);
            }

            $validator = Validator::make($request->all(), [
                'weekend_days' => 'required|array',
                'year' => 'required|digits:4',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            $weekend->update($request->only(['weekend_days', 'year']));
            return response()->json($weekend);
        } catch (\Exception $e) {
            Log::error('Error updating weekend: ' . $e->getMessage());
            return response()->json(['message' => 'An error occurred while updating the weekend'], 500);
        }
    }

    public function deleteWeekend($id)
    {
        try {
            $weekend = CompanyWeekend::find($id);
            if (!$weekend) {
                return response()->json(['message' => 'Weekend record not found'], 404);
            }
            $weekend->delete();
            return response()->json(['message' => 'Weekend record deleted']);
        } catch (\Exception $e) {
            Log::error('Error deleting weekend: ' . $e->getMessage());
            return response()->json(['message' => 'An error occurred while deleting the weekend'], 500);
        }
    }

    // Project Planner CRUD
    public function createProjectPlanner(Request $request, $companyId)
    {
        try {
            $validator = Validator::make($request->all(), [
                'company_name' => 'required',
                'year' => 'required',
                'description' => 'required',
                'comments' => 'nullable',
                'supporting_document' => 'nullable',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            // Ensure only one project planner per company per year
            $year = now()->year;
            $existingPlanner = ProjectPlanner::where('company_id', $companyId)
                ->whereYear('created_at', $year)
                ->first();

            if ($existingPlanner) {
                return response()->json(['message' => 'Project planner already exists for this company for the current year'], 400);
            }

            $projectPlanner = ProjectPlanner::create([
                'company_id' => $companyId,
                'company_name' => $request->company_name,
                'year' => $request->year,
                'description' => $request->description,
                'comments' => $request->comments,
                'supporting_document' => $request->supporting_document,
                'project_details' => $request->project_details ?? [],
            ]);
            

            return response()->json($projectPlanner, 201);
        } catch (\Exception $e) {
            Log::error('Error creating project planner: ' . $e->getMessage());
            return response()->json(['message' => 'An error occurred while creating the project planner'. $e->getMessage()], 500);
        }
    }

    public function getProjectPlanner($companyId)
    {
        try {
            $projectPlanner = ProjectPlanner::where('company_id', $companyId)->first();
            if (!$projectPlanner) {
                return response()->json(['message' => 'Project planner not found'], 404);
            }
            return response()->json($projectPlanner);
        } catch (\Exception $e) {
            Log::error('Error fetching project planner: ' . $e->getMessage());
            return response()->json(['message' => 'An error occurred while fetching the project planner'], 500);
        }
    }

    public function updateProjectPlanner(Request $request, $id)
    {
        try {
            $projectPlanner = ProjectPlanner::find($id);
            if (!$projectPlanner) {
                return response()->json(['message' => 'Project planner not found'], 404);
            }

            $validator = Validator::make($request->all(), [
                'company_name' => 'required',
                'year' => 'required',
                'description' => 'required',
                'comments' => 'nullable',
                'supporting_document' => 'nullable',
                'project_details' => 'required|array',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            $projectPlanner->update([
                'company_name' => $request->company_name,
                'year' => $request->year,
                'description' => $request->description,
                'comments' => $request->comments,
                'supporting_document' => $request->supporting_document,
                'project_details' => $request->project_details ?? [],
            ]);
            
            return response()->json($projectPlanner);
        } catch (\Exception $e) {
            Log::error('Error updating project planner: ' . $e->getMessage());
            return response()->json(['message' => 'An error occurred while updating the project planner'], 500);
        }
    }

    public function deleteProjectPlanner($id)
    {
        try {
            $projectPlanner = ProjectPlanner::find($id);
            if (!$projectPlanner) {
                return response()->json(['message' => 'Project planner not found'], 404);
            }
            $projectPlanner->delete();
            return response()->json(['message' => 'Project planner deleted']);
        } catch (\Exception $e) {
            Log::error('Error deleting project planner: ' . $e->getMessage());
            return response()->json(['message' => 'An error occurred while deleting the project planner'], 500);
        }
    }

    public function getWeekendAndHolidays($companyId)
    {
        try {
            // Fetch weekend days
            $weekend = CompanyWeekend::where('company_id', $companyId)->first();
            if (!$weekend) {
                return response()->json(['message' => 'Weekend record not found for this company'], 404);
            }

            // Fetch holidays
            $holidays = CompanyHoliday::where('company_id', $companyId)->get();

            return response()->json([
                'weekend_days' => $weekend->weekend_days,
                'holidays' => $holidays,
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching weekend and holidays: ' . $e->getMessage());
            return response()->json(['message' => 'An error occurred while fetching weekend and holidays'], 500);
        }
    }
}