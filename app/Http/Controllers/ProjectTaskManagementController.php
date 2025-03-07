<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProjectTaskManagement;

class ProjectTaskManagementController extends Controller
{
    // Create Form
    public function create() {
        return view('frontend.Project-Planner.projectplanner');
    }

    // Store Data
    public function store(Request $request) {
        // Validate data
        $request->validate([
            'dataprojectplanner' => 'required|array',
        ]);

        // Save data to database
        $taskGrid = new ProjectTaskManagement();
        $taskGrid->identifier = 'Task Management Data';
        $taskGrid->data = json_encode($request->dataprojectplanner); // Encode data as JSON
        $taskGrid->save();
        
        toastr()->success('Record is Created Successfully');
        return redirect(url('rcms/qms-dashboard'));
    }

    // Update Data
    public function update(Request $request, $id) {
        $taskmanagement = ProjectTaskManagement::find($id);

        if ($taskmanagement && !empty($request->dataprojectplanner)) {
            $taskmanagement->data = json_encode($request->dataprojectplanner); // Encode data as JSON
            $taskmanagement->save();
            toastr()->success('Record is Updated Successfully');
        } else {
            toastr()->error('No valid data provided');
        }

        return back();
    }

    // Fetch and Display Data
    public function index($id) {
        $task = ProjectTaskManagement::find($id);
    
        if (!$task) {
            toastr()->error('Task not found');
            return back();
        }
    
        // Decode JSON data as an associative array
        $tasks = json_decode($task->data, true) ?? [];
    
        return view('frontend.Project-Planner.projectplannerview', compact('task', 'tasks'));
    }
}
    