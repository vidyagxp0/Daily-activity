<?php

namespace App\Http\Controllers;
use App\Models\PreventiveMaintenance;
use App\Models\PreventiveMaintenanceAudit;
use App\Models\PreventiveMaintenanceGrid;
use App\Models\User;
use Carbon\Carbon;
use App\Models\RecordNumber;
use App\Models\QMSDivision;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;

use App\Models\RoleGroup;
use PDF;
use Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PreventiveMaintenanceController extends Controller
{
    public function index()
    {
        $record_number = ((RecordNumber::first()->value('counter')) + 1);
        $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
        $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $due_date = $formattedDate->format('Y-m-d');
        $parent_id = null;
       return view('frontend.preventive-maintenance.preventive_maintenance', compact('record_number','parent_id') );
        
    }

    public function preventivemaintenance_store(Request $request)
    {
        
        if (!$request->short_description) {
            toastr()->error("Short description is required");
            return redirect()->back()->withInput();
        }
        $equipment = new PreventiveMaintenance();
        $equipment->form_type = "Preventive Maintenance";
        $equipment->record = ((RecordNumber::first()->value('counter')) + 1);
        $equipment->initiator_id = Auth::user()->id;
        $equipment->division_id = $request->division_id;
        $equipment->division_code = $request->division_code;
        $equipment->intiation_date = $request->intiation_date;
        // $equipment->form_type = $request->form_type;
        $equipment->record_number = $request->record_number;
        $equipment->parent_id = $request->parent_id;
        $equipment->parent_type = $request->parent_type;
        $equipment->assign_to = $request->assign_to;
        $equipment->due_date = $request->due_date;
        $equipment->short_description = $request->short_description;
        $equipment->pm_schedule = $request->pm_schedule;
        $equipment->last_pm_date = $request->last_pm_date;
        $equipment->next_pm_date = $request->next_pm_date;
        $equipment->pm_task_description = $request->pm_task_description;
        $equipment->event_based_PM = $request->event_based_PM;
        $equipment->eventbased_pm_reason = $request->eventbased_pm_reason;
        $equipment->PMevent_refernce_no = $request->PMevent_refernce_no;
        // $equipment->pm_procedure_document = $request->pm_procedure_document;
        $equipment->pm_performed_by = $request->pm_performed_by;
        $equipment->maintenance_observation = $request->maintenance_observation;
        $equipment->replaced_parts = $request->replaced_parts;
        $equipment->work_order_number = $request->work_order_number;
        $equipment->pm_checklist = $request->pm_checklist;
        $equipment->emergency_flag_maintenance = $request->emergency_flag_maintenance;
        $equipment->cost_of_maintenance = $request->cost_of_maintenance;

        

        $equipment->status = 'Opened';
        $equipment->stage = 1;
    
        if (!empty($request->pm_procedure_document)) {
            $files = [];
            if ($request->hasfile('pm_procedure_document')) {
                foreach ($request->file('pm_procedure_document') as $file) {
                    $name = $request->name . '-pm_procedure_document' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $equipment->pm_procedure_document = json_encode($files);
        }
    
        $equipment->save();

        $preventive_maintenance_id = $equipment->id;

        $PreventiveMaintenanceGrid = PreventiveMaintenanceGrid::where(['preventive_maintenance_id' => $preventive_maintenance_id, 'identifier' => 'pmcheck'])->firstOrNew();
        $PreventiveMaintenanceGrid->preventive_maintenance_id = $preventive_maintenance_id;
        $PreventiveMaintenanceGrid->identifier = 'pmcheck';
        $PreventiveMaintenanceGrid->data = $request->pmchecklist;
        $PreventiveMaintenanceGrid->save();
    
    
        /////-----------------------audit trail--------------------
    
        if(!empty($request->record_number))
        {
            $history = new PreventiveMaintenanceAudit();
            $history->preventivemaintenance_id = $equipment->id;
            $history->activity_type = 'Record Number';
            $history->previous = "Null";
            $history->current =$request->record_number;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $equipment->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
         
            $history->save();
        }
    
        
        if(!empty($request->division_code))
        {
            $history = new PreventiveMaintenanceAudit();
            $history->preventivemaintenance_id = $equipment->id;
            $history->activity_type = 'Site/Location Code';
            $history->previous = "Null";
            $history->current =$request->division_code;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $equipment->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
         
            $history->save();
        }
    
        if(!empty($request->originator_id))
        {
            $history = new PreventiveMaintenanceAudit();
            $history->preventivemaintenance_id = $equipment->id;
            $history->activity_type = 'Initiator';
            $history->previous = "Null";
            $history->current =$request->originator_id;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $equipment->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
         
            $history->save();
        }
    
        if(!empty($request->intiation_date))
        {
            $history = new PreventiveMaintenanceAudit();
            $history->preventivemaintenance_id = $equipment->id;
            $history->activity_type = 'Date of Initiation';
            $history->previous = "Null";
            $history->current = Helpers::getdateFormat($request->intiation_date);
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $equipment->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
         
            $history->save();
        }
    
        
        if(!empty($request->assign_to))
        {
            $history = new PreventiveMaintenanceAudit();
            $history->preventivemaintenance_id = $equipment->id;
            $history->activity_type = 'Assigned to';
            $history->previous = "Null";
            $history->current = Helpers::getInitiatorName($request->assign_to);
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $equipment->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
         
            $history->save();
        }
    
        if(!empty($request->due_date))
        {
            $history = new PreventiveMaintenanceAudit();
            $history->preventivemaintenance_id = $equipment->id;
            $history->activity_type = 'Due Date';
            $history->previous = "Null";
            $history->current = Helpers::getdateFormat($request->due_date);
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $equipment->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
         
            $history->save();
        }
    
        
        if(!empty($request->short_description))
        {
            $history = new PreventiveMaintenanceAudit();
            $history->preventivemaintenance_id = $equipment->id;
            $history->activity_type = 'Short Description';
            $history->previous = "Null";
            $history->current =$request->short_description;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $equipment->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
         
            $history->save();
        }

        if(!empty($request->pm_schedule))
        {
            $history = new PreventiveMaintenanceAudit();
            $history->preventivemaintenance_id = $equipment->id;
            $history->activity_type = 'PM Schedule';
            $history->previous = "Null";
            $history->current =$request->pm_schedule;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $equipment->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
         
            $history->save();
        }

        if(!empty($request->last_pm_date))
        {
            $history = new PreventiveMaintenanceAudit();
            $history->preventivemaintenance_id = $equipment->id;
            $history->activity_type = 'Last Preventive Maintenance Date';
            $history->previous = "Null";
            $history->current = Helpers::getdateFormat($request->last_pm_date);
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $equipment->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
         
            $history->save();
        }

        if(!empty($request->next_pm_date))
        {
            $history = new PreventiveMaintenanceAudit();
            $history->preventivemaintenance_id = $equipment->id;
            $history->activity_type = 'Next Preventive Maintenance Date';
            $history->previous = "Null";
            $history->current = Helpers::getdateFormat($request->next_pm_date);
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $equipment->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
         
            $history->save();
        }

        if(!empty($request->pm_task_description))
        {
            $history = new PreventiveMaintenanceAudit();
            $history->preventivemaintenance_id = $equipment->id;
            $history->activity_type = 'PM Task Description';
            $history->previous = "Null";
            $history->current =$request->pm_task_description;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $equipment->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
         
            $history->save();
        }

        if(!empty($request->event_based_PM))
        {
            $history = new PreventiveMaintenanceAudit();
            $history->preventivemaintenance_id = $equipment->id;
            $history->activity_type = 'Unscheduled or Event Based Preventive Maintenance?';
            $history->previous = "Null";
            $history->current =$request->event_based_PM;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $equipment->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
         
            $history->save();
        }

        if(!empty($request->eventbased_pm_reason))
        {
            $history = new PreventiveMaintenanceAudit();
            $history->preventivemaintenance_id = $equipment->id;
            $history->activity_type = 'Reason for Unscheduled or Event Based Preventive Maintenance';
            $history->previous = "Null";
            $history->current =$request->eventbased_pm_reason;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $equipment->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
         
            $history->save();
        }

        if(!empty($request->PMevent_refernce_no))
        {
            $history = new PreventiveMaintenanceAudit();
            $history->preventivemaintenance_id = $equipment->id;
            $history->activity_type = 'Event Reference No.';
            $history->previous = "Null";
            $history->current =$request->PMevent_refernce_no;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $equipment->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
         
            $history->save();
        }

        if(!empty($request->pm_performed_by))
        {
            $history = new PreventiveMaintenanceAudit();
            $history->preventivemaintenance_id = $equipment->id;
            $history->activity_type = 'Performed By';
            $history->previous = "Null";
            $history->current =$request->pm_performed_by;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $equipment->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
         
            $history->save();
        }

        if(!empty($request->maintenance_observation))
        {
            $history = new PreventiveMaintenanceAudit();
            $history->preventivemaintenance_id = $equipment->id;
            $history->activity_type = 'Maintenance Comments/Observations';
            $history->previous = "Null";
            $history->current =$request->maintenance_observation;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $equipment->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
         
            $history->save();
        }

        if(!empty($request->replaced_parts))
        {
            $history = new PreventiveMaintenanceAudit();
            $history->preventivemaintenance_id = $equipment->id;
            $history->activity_type = 'Parts Replaced During Maintenance';
            $history->previous = "Null";
            $history->current =$request->replaced_parts;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $equipment->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
         
            $history->save();
        }

        if(!empty($request->work_order_number))
        {
            $history = new PreventiveMaintenanceAudit();
            $history->preventivemaintenance_id = $equipment->id;
            $history->activity_type = 'Maintenance Work Order Number';
            $history->previous = "Null";
            $history->current =$request->work_order_number;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $equipment->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
         
            $history->save();
        }

        if(!empty($request->pm_checklist))
        {
            $history = new PreventiveMaintenanceAudit();
            $history->preventivemaintenance_id = $equipment->id;
            $history->activity_type = 'PM Checklist';
            $history->previous = "Null";
            $history->current =$request->pm_checklist;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $equipment->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
         
            $history->save();
        }

        if(!empty($request->emergency_flag_maintenance))
        {
            $history = new PreventiveMaintenanceAudit();
            $history->preventivemaintenance_id = $equipment->id;
            $history->activity_type = 'Emergency Maintenance Flag';
            $history->previous = "Null";
            $history->current =$request->emergency_flag_maintenance;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $equipment->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
         
            $history->save();
        }

        if(!empty($request->cost_of_maintenance))
        {
            $history = new PreventiveMaintenanceAudit();
            $history->preventivemaintenance_id = $equipment->id;
            $history->activity_type = 'Cost of Maintenance';
            $history->previous = "Null";
            $history->current =$request->cost_of_maintenance;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $equipment->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
         
            $history->save();
        }
    
        ///-----------------------------------------------------------
    
        $record = RecordNumber::first();
        $record->counter = ((RecordNumber::first()->value('counter')) + 1);
        $record->update();
    
        toastr()->success("Record is Create Successfully");
        return redirect(url('rcms/qms-dashboard'));
    }

   

public function update(Request $request, $id)
{

    $lastDocument = PreventiveMaintenance::find($id);
    $equipment = PreventiveMaintenance::find($id);

    $equipment->assign_to = $request->assign_to;
    // $equipment->due_date = $request->due_date;
    $equipment->short_description = $request->short_description;
    $equipment->pm_schedule = $request->pm_schedule;
    $equipment->last_pm_date = $request->last_pm_date;
    $equipment->next_pm_date = $request->next_pm_date;
    $equipment->pm_task_description = $request->pm_task_description;
    $equipment->event_based_PM = $request->event_based_PM;
    $equipment->eventbased_pm_reason = $request->eventbased_pm_reason;
    $equipment->PMevent_refernce_no = $request->PMevent_refernce_no;
    // $equipment->pm_procedure_document = $request->pm_procedure_document;
    $equipment->pm_performed_by = $request->pm_performed_by;
    $equipment->maintenance_observation = $request->maintenance_observation;
    $equipment->replaced_parts = $request->replaced_parts;
    $equipment->work_order_number = $request->work_order_number;
    $equipment->pm_checklist = $request->pm_checklist;
    $equipment->emergency_flag_maintenance = $request->emergency_flag_maintenance;
    $equipment->cost_of_maintenance = $request->cost_of_maintenance;

    $preventive_maintenance_id = $equipment->id;

    $PreventiveMaintenanceGrid = PreventiveMaintenanceGrid::where(['preventive_maintenance_id' => $preventive_maintenance_id, 'identifier' => 'pmcheck'])->firstOrNew();
    $PreventiveMaintenanceGrid->preventive_maintenance_id = $preventive_maintenance_id;
    $PreventiveMaintenanceGrid->identifier = 'pmcheck';
    $PreventiveMaintenanceGrid->data = $request->pmchecklist;
    // dd( $PreventiveMaintenanceGrid);
    $PreventiveMaintenanceGrid->save();


    if (!empty($request->pm_procedure_document)) {
        $files = [];
        if ($request->hasfile('pm_procedure_document')) {
            foreach ($request->file('pm_procedure_document') as $file) {
                $name = $request->name . '-pm_procedure_document' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                $file->move('upload/', $name);
                $files[] = $name;
            }
        }
        $equipment->pm_procedure_document = json_encode($files);
    }
    $equipment->update();

    if ($lastDocument->short_description != $equipment->short_description || !empty($request->short_description_comment)) {

        $history = new PreventiveMaintenanceAudit();
        $history->preventivemaintenance_id = $id;
        $history->activity_type = 'Short Description';
        $history->previous = $lastDocument->short_description;
        $history->current = $equipment->short_description;
        $history->comment = $request->short_description_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to =   "Not Applicable";
        $history->change_from = $lastDocument->status;
        $history->action_name = 'Update';
     
        $history->save();
    }

    if ($lastDocument->pm_schedule != $equipment->pm_schedule || !empty($request->pm_schedule_comment)) {

        $history = new PreventiveMaintenanceAudit();
        $history->preventivemaintenance_id = $id;
        $history->activity_type = 'PM Schedule';
        $history->previous = $lastDocument->pm_schedule;
        $history->current = $equipment->pm_schedule;
        $history->comment = $request->pm_schedule_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to =   "Not Applicable";
        $history->change_from = $lastDocument->status;
        $history->action_name = 'Update';
     
        $history->save();
    }

    if ($lastDocument->last_pm_date != $equipment->last_pm_date || !empty($request->last_pm_date_comment)) {

        $history = new PreventiveMaintenanceAudit();
        $history->preventivemaintenance_id = $id;
        $history->activity_type = 'Last Preventive Maintenance Date';
        $history->previous = Helpers::getdateFormat($lastDocument->last_pm_date);
        $history->current = Helpers::getdateFormat($equipment->last_pm_date);
        $history->comment = $request->last_pm_date_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to =   "Not Applicable";
        $history->change_from = $lastDocument->status;
        $history->action_name = 'Update';
     
        $history->save();
    }

    if ($lastDocument->next_pm_date != $equipment->next_pm_date || !empty($request->next_pm_date_comment)) {

        $history = new PreventiveMaintenanceAudit();
        $history->preventivemaintenance_id = $id;
        $history->activity_type = 'Next Preventive Maintenance Date';
        $history->previous = Helpers::getdateFormat($lastDocument->next_pm_date);
        $history->current = Helpers::getdateFormat($equipment->next_pm_date);
        $history->comment = $request->next_pm_date_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to =   "Not Applicable";
        $history->change_from = $lastDocument->status;
        $history->action_name = 'Update';
     
        $history->save();
    }

    if ($lastDocument->pm_task_description != $equipment->pm_task_description || !empty($request->pm_task_description_comment)) {

        $history = new PreventiveMaintenanceAudit();
        $history->preventivemaintenance_id = $id;
        $history->activity_type = 'PM Task Description';
        $history->previous = $lastDocument->pm_task_description;
        $history->current = $equipment->pm_task_description;
        $history->comment = $request->pm_task_description_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to =   "Not Applicable";
        $history->change_from = $lastDocument->status;
        $history->action_name = 'Update';
     
        $history->save();
    }

    if ($lastDocument->event_based_PM != $equipment->event_based_PM || !empty($request->event_based_PM_comment)) {

        $history = new PreventiveMaintenanceAudit();
        $history->preventivemaintenance_id = $id;
        $history->activity_type = 'Unscheduled or Event Based Preventive Maintenance?';
        $history->previous = $lastDocument->event_based_PM;
        $history->current = $equipment->event_based_PM;
        $history->comment = $request->event_based_PM_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to =   "Not Applicable";
        $history->change_from = $lastDocument->status;
        $history->action_name = 'Update';
     
        $history->save();
    }

    if ($lastDocument->PMevent_refernce_no != $equipment->PMevent_refernce_no || !empty($request->PMevent_refernce_no_comment)) {

        $history = new PreventiveMaintenanceAudit();
        $history->preventivemaintenance_id = $id;
        $history->activity_type = 'Event Reference No.';
        $history->previous = $lastDocument->PMevent_refernce_no;
        $history->current = $equipment->PMevent_refernce_no;
        $history->comment = $request->PMevent_refernce_no_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to =   "Not Applicable";
        $history->change_from = $lastDocument->status;
        $history->action_name = 'Update';
     
        $history->save();
    }

    if ($lastDocument->pm_performed_by != $equipment->pm_performed_by || !empty($request->pm_performed_by_comment)) {

        $history = new PreventiveMaintenanceAudit();
        $history->preventivemaintenance_id = $id;
        $history->activity_type = 'Performed By';
        $history->previous = $lastDocument->pm_performed_by;
        $history->current = $equipment->pm_performed_by;
        $history->comment = $request->pm_performed_by_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to =   "Not Applicable";
        $history->change_from = $lastDocument->status;
        $history->action_name = 'Update';
     
        $history->save();
    }

    if ($lastDocument->maintenance_observation != $equipment->maintenance_observation || !empty($request->maintenance_observation_comment)) {

        $history = new PreventiveMaintenanceAudit();
        $history->preventivemaintenance_id = $id;
        $history->activity_type = 'Maintenance Comments/Observations';
        $history->previous = $lastDocument->maintenance_observation;
        $history->current = $equipment->maintenance_observation;
        $history->comment = $request->maintenance_observation_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to =   "Not Applicable";
        $history->change_from = $lastDocument->status;
        $history->action_name = 'Update';
     
        $history->save();
    }

    if ($lastDocument->replaced_parts != $equipment->replaced_parts || !empty($request->replaced_parts_comment)) {

        $history = new PreventiveMaintenanceAudit();
        $history->preventivemaintenance_id = $id;
        $history->activity_type = 'Parts Replaced During Maintenance';
        $history->previous = $lastDocument->replaced_parts;
        $history->current = $equipment->replaced_parts;
        $history->comment = $request->replaced_parts_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to =   "Not Applicable";
        $history->change_from = $lastDocument->status;
        $history->action_name = 'Update';
     
        $history->save();
    }

    if ($lastDocument->work_order_number != $equipment->work_order_number || !empty($request->work_order_number_comment)) {

        $history = new PreventiveMaintenanceAudit();
        $history->preventivemaintenance_id = $id;
        $history->activity_type = 'Maintenance Work Order Number';
        $history->previous = $lastDocument->work_order_number;
        $history->current = $equipment->work_order_number;
        $history->comment = $request->work_order_number_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to =   "Not Applicable";
        $history->change_from = $lastDocument->status;
        $history->action_name = 'Update';
     
        $history->save();
    }

    if ($lastDocument->pm_checklist != $equipment->pm_checklist || !empty($request->pm_checklist_comment)) {

        $history = new PreventiveMaintenanceAudit();
        $history->preventivemaintenance_id = $id;
        $history->activity_type = 'PM Checklist';
        $history->previous = $lastDocument->pm_checklist;
        $history->current = $equipment->pm_checklist;
        $history->comment = $request->pm_checklist_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to =   "Not Applicable";
        $history->change_from = $lastDocument->status;
        $history->action_name = 'Update';
     
        $history->save();
    }

    if ($lastDocument->emergency_flag_maintenance != $equipment->emergency_flag_maintenance || !empty($request->emergency_flag_maintenance_comment)) {

        $history = new PreventiveMaintenanceAudit();
        $history->preventivemaintenance_id = $id;
        $history->activity_type = 'Emergency Maintenance Flag';
        $history->previous = $lastDocument->emergency_flag_maintenance;
        $history->current = $equipment->emergency_flag_maintenance;
        $history->comment = $request->emergency_flag_maintenance_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to =   "Not Applicable";
        $history->change_from = $lastDocument->status;
        $history->action_name = 'Update';
     
        $history->save();
    }
    if ($lastDocument->cost_of_maintenance != $equipment->cost_of_maintenance || !empty($request->cost_of_maintenance_comment)) {

        $history = new PreventiveMaintenanceAudit();
        $history->preventivemaintenance_id = $id;
        $history->activity_type = 'Cost of Maintenance';
        $history->previous = $lastDocument->cost_of_maintenance;
        $history->current = $equipment->cost_of_maintenance;
        $history->comment = $request->cost_of_maintenance_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to =   "Not Applicable";
        $history->change_from = $lastDocument->status;
        $history->action_name = 'Update';
     
        $history->save();
    }

    toastr()->success("Record is Update Successfully");
    return back(); 
}

public function show($id)
{      
    
    $data = PreventiveMaintenance::find($id);
    $equipment  = PreventiveMaintenance::find($id);
    $PreventiveMaintenance_grid = PreventiveMaintenanceGrid::where(['preventive_maintenance_id' => $equipment->id, 'identifier' => 'pmcheck'])->first();
    $record_number = ((RecordNumber::first()->value('counter')) + 1);
    $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
    $equipment->record = str_pad($equipment->record, 4, '0', STR_PAD_LEFT);
    $equipment->assign_to_name = User::where('id', $equipment->assign_id)->value('name');
    $equipment->initiator_name = User::where('id', $equipment->initiator_id)->value('name');
    $currentDate = Carbon::now();
    $formattedDate = $currentDate->addDays(30);
    $due_date = $formattedDate->format('Y-m-d');

    // return $PreventiveMaintenance_grid->data;
   
    return view('frontend.preventive-maintenance.preventive_maintenance_View', compact('data', 'equipment', 'record_number','PreventiveMaintenance_grid'));
}

public function PreventiveStateChange(Request $request, $id)
    {
        if ($request->username == Auth::user()->Username && Hash::check($request->password, Auth::user()->password)) {
            $equipment = PreventiveMaintenance::find($id);
            $lastDocument =  PreventiveMaintenance::find($id);

            if ($equipment->stage == 1) {
                $equipment->stage = "2";
                $equipment->status = 'Supervisor Review';
                $equipment->submit_by = Auth::user()->name;
                $equipment->submit_on = Carbon::now()->format('d-M-Y');
                $equipment->submit_comments = $request->comment;

                $history = new PreventiveMaintenanceAudit();
                $history->preventivemaintenance_id = $id;
                $history->activity_type = 'Submit By ,Submit On';
                if (is_null($lastDocument->submit_by) || $lastDocument->submit_by === '') {
                    $history->previous = "NULL";
                } else {
                    $history->previous = $lastDocument->submit_by . ' , ' . $lastDocument->submit_on;
                }
                $history->current = $equipment->submit_by . ' , ' . $equipment->submit_on;
                if (is_null($lastDocument->submit_by) || $lastDocument->submit_on === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->comment = $request->comment;  
                $history->action = 'submit';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to =   "Supervisor Review";
                $history->change_from = $lastDocument->status;
             
                $history->save();
                
                // $history->stage = 'Supervisor Review';
                // if (is_null($lastDocument->submit_by) || $lastDocument->submit_by === '') {
                //     $history->previous = "";
                // } else {
                //     $history->previous = $lastDocument->submit_by . ' , ' . $lastDocument->submit_on;
                // }
                // $history->current = $root->submit_by . ' , ' . $root->submit_on;
                // if (is_null($lastDocument->submit_by) || $lastDocument->submit_by === '') {
                //     $history->action_name = 'New';
                // } else {
                //     $history->action_name = 'Update';
                // }
                // $history->save();
                $equipment->update();
                toastr()->success('Document Sent');
                return back();
            }

            if ($equipment->stage == 2) {
                $equipment->stage = "3";
                $equipment->status = 'Work in Progress';
                $equipment->Supervisor_Approval_by  = Auth::user()->name;
                $equipment->Supervisor_Approval_on = Carbon::now()->format('d-M-Y');
                $equipment->Supervisor_Approval_comment = $request->comment;

                $history = new PreventiveMaintenanceAudit();
                $history->preventivemaintenance_id = $id;
                $history->activity_type = 'Supervisor Approval By ,Supervisor Approval On';
                if (is_null($lastDocument->Supervisor_Approval_by) || $lastDocument->Supervisor_Approval_by === '') {
                    $history->previous = "NULL";
                } else {
                    $history->previous = $lastDocument->Supervisor_Approval_by . ' , ' . $lastDocument->Supervisor_Approval_on;
                }
                $history->current = $equipment->Supervisor_Approval_by . ' , ' . $equipment->Supervisor_Approval_on;
                if (is_null($lastDocument->Supervisor_Approval_by) || $lastDocument->Supervisor_Approval_on === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->comment = $request->comment;  
                $history->action = 'Supervisor Approval';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to =   "Work in Progress";
                $history->change_from = $lastDocument->status;
             
                $history->save();

                $equipment->update();
                toastr()->success('Document Sent');
                return back();
            }

            if ($equipment->stage == 3) {
                $equipment->stage = "4";
                $equipment->status = 'Pending QA Approval';
                $equipment->Complete_by  = Auth::user()->name;
                $equipment->Complete_on = Carbon::now()->format('d-M-Y');
                $equipment->Complete_comment = $request->comment;

                $history = new PreventiveMaintenanceAudit();
                $history->preventivemaintenance_id = $id;
                $history->activity_type = 'Complete By ,Complete On';
                if (is_null($lastDocument->Complete_by) || $lastDocument->Complete_by === '') {
                    $history->previous = "NULL";
                } else {
                    $history->previous = $lastDocument->Complete_by . ' , ' . $lastDocument->Complete_on;
                }
                $history->current = $equipment->Complete_by . ' , ' . $equipment->Complete_on;
                if (is_null($lastDocument->Complete_by) || $lastDocument->Complete_on === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->comment = $request->comment;  
                $history->action = 'Complete';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to =   "Pending QA Approval";
                $history->change_from = $lastDocument->status;
             
                $history->save();

                $equipment->update();
                toastr()->success('Document Sent');
                return back();
            }

            if ($equipment->stage == 4) {
                $equipment->stage = "5";
                $equipment->status = 'Pending QA Approval';
                $equipment->qa_approval_by  = Auth::user()->name;
                $equipment->qa_approval_on = Carbon::now()->format('d-M-Y');
                $equipment->qa_approval_comment = $request->comment;

                $history = new PreventiveMaintenanceAudit();
                $history->preventivemaintenance_id = $id;
                $history->activity_type = 'QA Approval By ,QA Approval On';
                if (is_null($lastDocument->Complete_by) || $lastDocument->Complete_by === '') {
                    $history->previous = "NULL";
                } else {
                    $history->previous = $lastDocument->Complete_by . ' , ' . $lastDocument->Complete_on;
                }
                $history->current = $equipment->Complete_by . ' , ' . $equipment->Complete_on;
                if (is_null($lastDocument->Complete_by) || $lastDocument->Complete_on === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->previous ="";
                $history->current = $equipment->submit_by;
                $history->comment = $request->comment;  
                $history->action = 'QA Approval';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to =   "Pending QA Approval";
                $history->change_from = $lastDocument->status;
             
                $history->save();

                $equipment->update();
                toastr()->success('Document Sent');
                return back();
            }

        }else {
            toastr()->error('E-signature Not match');
            return back();
        }
    }

    public function PreventiveCancel(Request $request, $id)
    {
        if ($request->username == Auth::user()->Username && Hash::check($request->password, Auth::user()->password)) {
            $equipment = PreventiveMaintenance::find($id);
            $lastDocument = PreventiveMaintenance::find($id);
            

            if ($equipment->stage == 2) {
                $equipment->stage = "0";
                $equipment->status = "Closed - Cancelled";
                $equipment->Cancel_By = Auth::user()->name;
                $equipment->Cancel_On = Carbon::now()->format('d-M-Y');
                $equipment->Cancel_Comment = $request->comment;

                $history = new PreventiveMaintenanceAudit();
                $history->preventivemaintenance_id = $id;
                $history->activity_type = 'Cancel By ,Cancel On';
                if (is_null($lastDocument->Cancel_By) || $lastDocument->Cancel_By === '') {
                    $history->previous = "NULL";
                } else {
                    $history->previous = $lastDocument->Cancel_By . ' , ' . $lastDocument->Cancel_On;
                }
                $history->current = $equipment->Cancel_By . ' , ' . $equipment->Cancel_On;
                if (is_null($lastDocument->Cancel_By) || $lastDocument->Cancel_On === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->comment = $request->comment;  
                $history->action = 'Cancel';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to =   "Closed - Cancelled";
                $history->change_from = $lastDocument->status;
             
                $history->save();
                // $history = new PreventiveMaintenanceAudit();
                // $history->sanction_id = $id;
                // $history->activity_type = 'Cancel By,Cancel On';
                // $history->action = 'Cancel';
                // // $history->previous = "";
                // // $history->current = $SanctionControl->Cancel_By;
                // $history->comment = $request->comment;
                // $history->user_id = Auth::user()->id;
                // $history->user_name = Auth::user()->name;
                // $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                // $history->origin_state =  $SanctionControl->status;
                // $history->change_to = "Closed";
                // $history->change_from = $lastDocument->status;
                // $history->stage = 'Closed';
                // if (is_null($lastDocument->Cancel_By) || $lastDocument->Cancel_By === '') {
                //     $history->previous = "";
                // } else {
                //     $history->previous = $lastDocument->Cancel_By . ' , ' . $lastDocument->Cancel_On;
                // }
                // $history->current = $SanctionControl->Cancel_By . ' , ' . $SanctionControl->Cancel_On;
                // if (is_null($lastDocument->Cancel_By) || $lastDocument->Cancel_By === '') {
                //     $history->action_name = 'New';
                // } else {
                //     $history->action_name = 'Update';
                // }
                // $history->save();
                // $SanctionControl->update();
                // $history = new EHSEventHistory();
                // $history->type = "Sanction";
                // $history->doc_id = $id;
                // $history->user_id = Auth::user()->id;
                // $history->user_name = Auth::user()->name;
                // $history->stage_id = $SanctionControl->stage;
                // $history->status = $SanctionControl->status;
                // $history->save();

                // $list = Helpers::getInitiatorUserList();
                // foreach ($list as $u) {
                //     if($u->q_m_s_divisions_id == $SanctionControl->division_id){
                //       $email = Helpers::getInitiatorEmail($u->user_id);
                //       if ($email !== null) {

                //         Mail::send(
                //             'mail.view-mail',
                //             ['data' => $SanctionControl],
                //             function ($message) use ($email) {
                //                 $message->to($email)
                //                     ->subject("Cancelled By ".Auth::user()->name);
                //             }
                //          );
                //       }
                //     }
                // }

                toastr()->success('Document Sent');
                return back();
            }
                    } else {
            toastr()->error('E-signature Not match');
            return back();
        }
    }

    public function MoreInfoPreventive(Request $request, $id)
    {
        if ($request->username == Auth::user()->Username && Hash::check($request->password, Auth::user()->password)) {
            $equipment = PreventiveMaintenance::find($id);
            $lastDocument =  PreventiveMaintenance::find($id);


            if ($equipment->stage == 4) {
                $equipment->stage = "2";
                $equipment->status = "Pending QA Approval";

                $equipment->additional_work_by = Auth::user()->name;
                $equipment->additional_work_on = Carbon::now()->format('d-M-Y');
                $equipment->additional_work_comment = $request->comment;
                $history = new PreventiveMaintenanceAudit();
                $history->preventivemaintenance_id = $id;
                $history->activity_type = 'Additional Work Required By ,Additional Work Required On';
                if (is_null($lastDocument->additional_work_by) || $lastDocument->additional_work_by === '') {
                    $history->previous = "NULL";
                } else {
                    $history->previous = $lastDocument->additional_work_by . ' , ' . $lastDocument->additional_work_on;
                }
                $history->current = $equipment->additional_work_by . ' , ' . $equipment->additional_work_on;
                if (is_null($lastDocument->additional_work_by) || $lastDocument->additional_work_on === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
               
                $history->comment = $request->comment;  
                $history->action = 'Additional Work Required';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to =   "Pending QA Approval";
                $history->change_from = $lastDocument->status;
             
                $history->save();
                $equipment->update();


                toastr()->success('Document Sent');
                return back();
            }

        }else {
            toastr()->error('E-signature Not match');
            return back();
        }
    }

    public function PrevantiveAuditTrail($id)
    {
        $audit = PreventiveMaintenanceAudit::where('preventivemaintenance_id', $id)->orderByDESC('id')->paginate();
        $today = Carbon::now()->format('d-m-y');
        $document = PreventiveMaintenance::where('id', $id)->first();
        $document->initiator = User::where('id', $document->initiator_id)->value('name');
        $data = PreventiveMaintenance::find($id);

        return view('frontend.preventive-maintenance.preventive_maintenance_audit', compact('audit', 'document', 'today', 'data'));
    }

    
    public  function PreventiveMaintenance_show($id)
    {
        $data = PreventiveMaintenance::find($id);
        // dd($data->record);
        if (!empty($data)) {
            $data->originator = User::where('id', $data->initiator_id)->value('name');
            $data->division = QMSDivision::where('id', $data->division_id)->value('name');

            // dd($data->division);
            $pdf = App::make('dompdf.wrapper');
            $time = Carbon::now();
            $pdf = PDF::loadview('frontend.preventive-maintenance.preventive_maintenance_singleReport', compact('data'))
                ->setOptions([
                    'defaultFont' => 'sans-serif',
                    'isHtml5ParserEnabled' => true,
                    'isRemoteEnabled' => true,
                    'isPhpEnabled' => true,
                ]);
            $pdf->setPaper('A4');
            $pdf->render();
            $canvas = $pdf->getDomPDF()->getCanvas();
            $height = $canvas->get_height();
            $width = $canvas->get_width();
            $canvas->page_script('$pdf->set_opacity(0.1,"Multiply");');
            $canvas->page_text($width / 4, $height / 2, $data->status, null, 25, [0, 0, 0], 2, 6, -20);

            $directoryPath = public_path("user/pdf/reg/");
            $filePath = $directoryPath . '/reg' . $id . '.pdf';

            if (!File::isDirectory($directoryPath)) {
                File::makeDirectory($directoryPath, 0755, true, true); // Recursive creation with read/write permissions
            }  

            $pdf->save($filePath);
            return $pdf->stream('Lab-Incident' . $id . '.pdf');
        }
    }

    public function exportPmCsv(Request $request)
    {
        $query = PreventiveMaintenance::query();
    
        // Apply filters similar to your other methods
        if ($request->department_preventive) {
            $query->where('pm_schedule', $request->department_preventive);
        }
    
        if ($request->division_id_preventive) {
            $query->where('division_id', $request->division_id_preventive);
        }

    
        if ($request->initiator_id_preventive) {
            $query->where('initiator_id', $request->initiator_id_preventive);
        }
    
        if ($request->date_frompreventive) {
            $query->where('date_frompreventive', $request->date_frompreventive);
        }

        if ($request->date_topreventive) {
            $dateTo = Carbon::parse($request->date_topreventive)->endOfDay();
            $query->whereDate('intiation_date', '<=', $dateTo);
        }
        if ($request->date_topreventive) {
            $dateTo = Carbon::parse($request->date_topreventive)->endOfDay();
            $query->whereDate('intiation_date', '<=', $dateTo);
        }
    
        // Fetch the filtered data
        $cc_cft = $query->get();
    
        $fileName = 'preventiveM_log.csv';
        $headers = [
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename=\"$fileName\"",
        ];
    
        $columns = [
            'Sr. No.', 'Initiation Date', 'Record No',
            'Division', 'PM Schedule', 'Short Description.', 'Due Date',
            'Initiator', 'Status'
        ];
    
        $callback = function () use ($cc_cft, $columns) {
            $file = fopen('php://output', 'w');
    
            fputcsv($file, $columns);
    
            if ($cc_cft->isEmpty()) {
                fputcsv($file, ['No records found']);
            } else {
                foreach ($cc_cft as $index => $row) {
                    $data = [
                        $index + 1, 
                        $row->intiation_date ?? 'Not Applicable', 
                        $row->division ? $row->division->name . '/CC/' . date('Y') . '/' . str_pad($row->record, 4, '0', STR_PAD_LEFT) : 'Not Applicable',
                        $row->division ? $row->division->name : 'Not Applicable', 
                        $row->pm_schedule ?? 'Not Applicable', 
                        $row->short_description ?? 'Not Applicable', 
                        $row->due_date ?? 'Not Applicable', 
                        $row->initiator ? $row->initiator->name : 'Not Applicable', 
                        $row->status ?? 'Not Applicable' 
                         
                    ];
    
                    fputcsv($file, $data);
                }
            }
    
            fclose($file);
        };
    
        return response()->stream($callback, 200, $headers);
    }
    
    


    public function exportPmExcel(Request $request)
    {
        $query = PreventiveMaintenance::query();
    
        if ($request->department_preventive) {
            $query->where('pm_schedule', $request->department_preventive);
        }
    
        if ($request->division_id_preventive) {
            $query->where('division_id', $request->division_id_preventive);
        }

    
        if ($request->initiator_id_preventive) {
            $query->where('initiator_id', $request->initiator_id_preventive);
        }
    
        if ($request->date_frompreventive) {
            $query->where('date_frompreventive', $request->date_frompreventive);
        }

        if ($request->date_topreventive) {
            $dateTo = Carbon::parse($request->date_topreventive)->endOfDay();
            $query->whereDate('intiation_date', '<=', $dateTo);
        }
        if ($request->date_topreventive) {
            $dateTo = Carbon::parse($request->date_topreventive)->endOfDay();
            $query->whereDate('intiation_date', '<=', $dateTo);
        }
    
    
        $cc_cft = $query->get();
    
        $fileName = "preventiveM_log.xls";
    
        $headers = [
            "Content-Type" => "application/vnd.ms-excel",
            "Content-Disposition" => "attachment; filename=\"$fileName\"",
        ];
    
        $columns = [
            'Sr. No.', 'Initiation Date', 'Record No',
            'Division', 'PM Schedule', 'Short Description.', 'Due Date',
            'Initiator', 'Status'
        ];
    
        $callback = function () use ($cc_cft, $columns) {
            echo '<table border="1">';
    
            echo '<tr style="font-weight: bold; background-color: #1F4E79; color: #FFFFFF;">';
            foreach ($columns as $column) {
                echo "<th style='padding: 5px;'>" . htmlspecialchars($column) . "</th>";
            }
            echo '</tr>';
    
            if ($cc_cft->isEmpty()) {
                echo '<tr>';
                echo "<td colspan='" . count($columns) . "' style='text-align: center;'>No records found</td>";
                echo '</tr>';
            } else {
                foreach ($cc_cft as $index => $row) {
                    echo '<tr>';
                    echo "<td style='padding: 5px;'>" . ($index + 1) . "</td>";
                    echo "<td style='padding: 5px;'>" . htmlspecialchars($row->intiation_date ?? 'Not Applicable') . "</td>";
                    echo "<td style='padding: 5px;'>" . htmlspecialchars($row->division ? $row->division->name . '/CC/' . date('Y') . '/' . str_pad($row->record, 4, '0', STR_PAD_LEFT) : 'Not Applicable') . "</td>";
                    echo "<td style='padding: 5px;'>" . htmlspecialchars( $row->division ? $row->division->name : 'Not Applicable') . "</td>";
                    echo "<td style='padding: 5px;'>" . htmlspecialchars($row->pm_schedule ?? 'Not Applicable') . "</td>";
                    echo "<td style='padding: 5px;'>" . htmlspecialchars($row->short_description ?? 'Not Applicable') . "</td>";
                    echo "<td style='padding: 5px;'>" . htmlspecialchars($row->due_date ?? 'Not Applicable') . "</td>";
                    echo "<td style='padding: 5px;'>" . htmlspecialchars($row->initiator ? $row->initiator->name : 'Not Applicable') . "</td>";
                    echo "<td style='padding: 5px;'>" . htmlspecialchars($row->status ?? 'Not Applicable') . "</td>";
                  
                    echo '</tr>';
                }
            }
    
            echo '</table>';
        };
    
        return response()->stream($callback, 200, $headers);
    }
}
