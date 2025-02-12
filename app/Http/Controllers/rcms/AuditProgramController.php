<?php

namespace App\Http\Controllers\rcms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AuditProgram;
use App\Models\RecordNumber;
use App\Models\RoleGroup;
use App\Models\InternalAuditGrid;
use App\Models\InternalAudit;
use App\Models\User;
use App\Models\Auditee;


use App\Models\{InternalAuditTrial,IA_checklist_tablet_compression,IA_checklist_tablet_coating,Checklist_Capsule, IA_checklist__formulation_research, IA_checklist_analytical_research, IA_checklist_dispensing, IA_checklist_engineering, IA_checklist_hr, IA_checklist_manufacturing_filling, IA_checklist_production_injection, IA_checklist_stores, IA_dispencing_manufacturing, IA_liquid_ointment, IA_ointment_paking, IA_quality_control, InternalAuditChecklistGrid};
use App\Models\{IA_checklist_capsule_paking};
use App\Models\InternalAuditorGrid;
use App\Models\InternalAuditObservationGrid;
use App\Models\InternalAuditStageHistory;
use App\Models\IA_checklist_compression;



use App\Models\AuditProgramGrid;
use Carbon\Carbon;
use PDF;
use Helpers;
use Illuminate\Support\Facades\Mail;
use App\Models\AuditProgramAuditTrial;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use GuzzleHttp\Client;

class AuditProgramController extends Controller
{

    public function auditprogram()
    {
        $old_record = AuditProgram::select('id', 'division_id', 'record')->get();
        $record_number = ((RecordNumber::first()->value('counter')) + 1);
        $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
        $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $due_date = $formattedDate->format('Y-m-d');
        return view('frontend.forms.audit-program', compact('due_date', 'record_number', 'old_record'));
    }
    public function create(request $request)
    {
        // return $request;
        // if (!$request->short_description) {
        //     toastr()->info("Short Description is required");
        //     return redirect()->back()->withInput();
        // }
        // if (!$request->country) {
        //     toastr()->info("Country is required");
        //     return redirect()->back()->withInput();
        // }
        // if (!$request->state) {
        //     toastr()->info("State is required");
        //     return redirect()->back()->withInput();
        // }
        // if (!$request->City) {
        //     toastr()->info("City is required");
        //     return redirect()->back()->withInput();
        // }
        $data = new AuditProgram();
        // $data->form_type = "audit-program";
        $data->record = ((RecordNumber::first()->value('counter')) + 1);
        $data->initiator_id = Auth::user()->id;
        $data->division_id = $request->division_id;
        $data->division_code = $request->division_code;
        $data->parent_id = $request->parent_id;
        $data->parent_type = $request->parent_type;
        $data->intiation_date = $request->intiation_date;
        $data->short_description = $request->short_description;

        $data->initiated_through = $request->initiated_through;
        $data->initiated_through_req = $request->initiated_through_req;
        $data->repeat = $request->repeat;
        $data->repeat_nature = $request->repeat_nature;
        $data->due_date_extension = $request->due_date_extension;


        $data->Initiator_Group = $request->Initiator_Group;
        $data->initiator_group_code = $request->initiator_group_code;
        $data->assign_to = $request->assign_to;
        $data->due_date = $request->due_date;
        $data->type = $request->type;
        $data->year = $request->year;
        $data->Quarter = $request->Quarter;
        $data->description = $request->description;
        $data->comments = $request->comments;
        $data->related_url = $request->related_url;
        $data->url_description = $request->url_description;
        //$data->suggested_audits = $request->suggested_audits;
        $data->zone = $request->zone;
        $data->country = $request->country;
        $data->City = $request->City;
        $data->state = $request->state;
        $data->severity1_level = $request->severity1_level;

        $data->status = 'Opened';
        $data->stage = 1;

        if (!empty($request->attachments)) {
            $files = [];
            if ($request->hasfile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    $name = $request->name . '-attachments' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $data->attachments = json_encode($files);
        }
        $data->save();

        $record = RecordNumber::first();
        $record->counter = ((RecordNumber::first()->value('counter')) + 1);
        $record->update();

        // ----------------grid-------
        $data1 = new AuditProgramGrid();
        $data1->audit_program_id = $data->id;

        if (!empty($request->serial_number)) {
            $data1->serial_number = serialize($request->serial_number);
        }
        if (!empty($request->Auditees)) {
            $data1->auditor = serialize($request->Auditees);
        }
        if (!empty($request->start_date)) {
            $data1->start_date = serialize($request->start_date);
        }
        if (!empty($request->end_date)) {
            $data1->end_date = serialize($request->end_date);
        }
        if (!empty($request->lead_investigator)) {
            $data1->lead_investigator = serialize($request->lead_investigator);
        }
        if (!empty($request->comment)) {
            $data1->comment = serialize($request->comment);
        }
        $data1->save();


        if (!empty($data->short_description)) {
            $history = new AuditProgramAuditTrial();
            $history->AuditProgram_id = $data->id;
            $history->activity_type = 'Short Description';
            $history->previous = "Null";
            $history->current = $data->short_description;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $data->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
            $history->save();
        }


        if (!empty($data->intiation_date)) {
            $history = new AuditProgramAuditTrial();
            $history->AuditProgram_id = $data->id;
            $history->activity_type = 'Date of Initiator';
            $history->previous = "Null";
            $history->current = Helpers::getdateFormat($data->intiation_date);
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $data->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
         
            $history->save();
        }
        $history = new AuditProgramAuditTrial();
        $history->AuditProgram_id = $data->id;
        $history->activity_type = 'Initiator';
        $history->previous = "Null";
        $history->current =Auth::user()->name;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $data->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';

        $history->save();

        if (!empty($data->record)) {
            $history = new AuditProgramAuditTrial();
            $history->AuditProgram_id = $data->id;
            $history->activity_type = 'Record Number';
            $history->previous = "Null";
            $history->current = Helpers::getDivisionName(session()->get('division')) . "/AP/" . Helpers::year($data->created_at) . "/" . str_pad($data->record, 4, '0', STR_PAD_LEFT);
             
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $data->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';

            $history->save();
        }





        if (!empty($data->assign_to)) {
            $history = new AuditProgramAuditTrial();
            $history->AuditProgram_id = $data->id;
            $history->activity_type = 'Assigned to';
            $history->previous = "Null";
            $history->current = $data->assign_to ? Helpers::getInitiatorName($data->assign_to) : 'Not-Applicable';
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $data->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
         
            $history->save();
        }









     

        if (!empty($data->due_date)) {
            $history = new AuditProgramAuditTrial();
            $history->AuditProgram_id = $data->id;
            $history->activity_type = 'Date Due';
            $history->previous = "Null";
            $history->current =Helpers::getdateFormat( $data->due_date);
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $data->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
            $history->save();
        }


        if (!empty($data->division_code)) {
            $history = new AuditProgramAuditTrial();
            $history->AuditProgram_id = $data->id;
            $history->activity_type = 'Site/Location Code';
            $history->previous = "Null";
            $history->current = $data->division_code;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $data->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
            $history->save();
        }


        if (!empty($data->severity1_level)) {
            $history = new AuditProgramAuditTrial();
            $history->AuditProgram_id = $data->id;
            $history->activity_type = 'Severity Level';
            $history->previous = "Null";
            $history->current = $data->severity1_level;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $data->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($data->initiated_through_req)) {
            $history = new AuditProgramAuditTrial();
            $history->AuditProgram_id = $data->id;
            $history->activity_type = 'Type(Others)';
            $history->previous = "Null";
            $history->current = $data->initiated_through_req;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $data->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
            $history->save();
        }


        if (!empty($data->year)) {
            $history = new AuditProgramAuditTrial();
            $history->AuditProgram_id = $data->id;
            $history->activity_type = 'Year';
            $history->previous = "Null";
            $history->current = $data->year;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $data->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
            $history->save();
        }

      

        if (!empty($data->due_date_extension)) {
            $history = new AuditProgramAuditTrial();
            $history->AuditProgram_id = $data->id;
            $history->activity_type = 'Due Date Extension Justification';
            $history->previous = "Null";
            $history->current = $data->due_date_extension;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $data->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
            $history->save();
        }
        if (!empty($data->initiated_through)) {
            $history = new AuditProgramAuditTrial();
            $history->AuditProgram_id = $data->id;
            $history->activity_type = 'Initiated Through';
            $history->previous = "Null";
            $history->current = $data->initiated_through;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $data->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
            $history->save();
        }
        if (!empty($data->type)) {
            $history = new AuditProgramAuditTrial();
            $history->AuditProgram_id = $data->id;
            $history->activity_type = 'Type';
            $history->previous = "Null";
            $history->current = $data->type;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $data->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
            $history->save();
        }

      
        if (!empty($data->Quarter)) {
            $history = new AuditProgramAuditTrial();
            $history->AuditProgram_id = $data->id;
            $history->activity_type = 'Quarter';
            $history->previous = "Null";
            $history->current = $data->Quarter;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $data->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($data->description)) {
            $history = new AuditProgramAuditTrial();
            $history->AuditProgram_id = $data->id;
            $history->activity_type = 'Description';
            $history->previous = "Null";
            $history->current = $data->description;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $data->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($data->comments)) {
            $history = new AuditProgramAuditTrial();
            $history->AuditProgram_id = $data->id;
            $history->activity_type = 'Comments';
            $history->previous = "Null";
            $history->current = $data->comments;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $data->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
            $history->save();
        }
        
        if (!empty($data->related_url)) {
            $history = new AuditProgramAuditTrial();
            $history->AuditProgram_id = $data->id;
            $history->activity_type = 'Related URl,s';
            $history->previous = "Null";
            $history->current = $data->related_url;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $data->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
            $history->save();
        }
        if (!empty($data->url_description)) {
            $history = new AuditProgramAuditTrial();
            $history->AuditProgram_id = $data->id;
            $history->activity_type = ' URl,s Description';
            $history->previous = "Null";
            $history->current = $data->url_description;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $data->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($data->initiator_group_code)) {
            $history = new AuditProgramAuditTrial();
            $history->AuditProgram_id = $data->id;
            $history->activity_type = 'Initiator Group Code';
            $history->previous = "Null";
            $history->current = $data->initiator_group_code;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $data->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
            $history->save();
        }


        if (!empty($data->Initiator_Group)) {
            $history = new AuditProgramAuditTrial();
            $history->AuditProgram_id = $data->id;
            $history->activity_type = 'Initiator Group';
            $history->previous = "Null";
            $history->current = Helpers::getFullDepartmentName($data->Initiator_Group);
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $data->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
            $history->save();
        }
        if (!empty($data->zone)) {
            $history = new AuditProgramAuditTrial();
            $history->AuditProgram_id = $data->id;
            $history->activity_type = 'Zone';
            $history->previous = "Null";
            $history->current = $data->zone;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $data->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($data->country)) {
            $history = new AuditProgramAuditTrial();
            $history->AuditProgram_id = $data->id;
            $history->activity_type = 'Country';
            $history->previous = "Null";
            $history->current = $data->country;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $data->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($data->City)) {
            $history = new AuditProgramAuditTrial();
            $history->AuditProgram_id = $data->id;
            $history->activity_type = 'City';
            $history->previous = "Null";
            $history->current = $data->City;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $data->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($data->state)) {
            $history = new AuditProgramAuditTrial();
            $history->AuditProgram_id = $data->id;
            $history->activity_type = 'State/District';
            $history->previous = "Null";
            $history->current = $data->state;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $data->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($data->attachments)) {
            $history = new AuditProgramAuditTrial();
            $history->AuditProgram_id = $data->id;
            $history->activity_type = 'Attached Files';
            $history->previous = "Null";
            $history->current = $data->attachments;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $data->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
            $history->save();
        }

        toastr()->success('Record is created Successfully');

        return redirect('rcms/qms-dashboard');
    }
    public function UpdateAuditProgram(request $request, $id)
    {


        if (!$request->short_description) {
            toastr()->info("Short Description is required");
            return redirect()->back()->withInput();
        }
        $lastDocument = AuditProgram::find($id);
        $data = AuditProgram::find($id);
        $data->record = ((RecordNumber::first()->value('counter')) + 1);
        $data->initiator_id = Auth::user()->id;
        $data->short_description = $request->short_description;

        $data->initiated_through = $request->initiated_through;
        $data->initiated_through_req = $request->initiated_through_req;
        $data->repeat = $request->repeat;
        $data->repeat_nature = $request->repeat_nature;
        $data->due_date_extension = $request->due_date_extension;

        $data->assign_to = $request->assign_to;
        $data->due_date = $request->due_date;
        $data->Initiator_Group = $request->Initiator_Group;
        $data->initiator_group_code = $request->initiator_group_code;
        $data->type = $request->type;
        $data->year = $request->year;
        $data->Quarter = $request->Quarter;
        $data->description = $request->description; 
        $data->comments = $request->comments;
        $data->related_url = $request->related_url;
        $data->url_description = $request->url_description;
        //$data->suggested_audits = $request->suggested_audits;
        $data->zone = $request->zone;
        $data->country = $request->country;
        $data->City = $request->City;
        $data->state = $request->state;
        $data->severity1_level = $request->severity1_level;
        if (!empty($request->attachments)) {
            $files = [];
            if ($request->hasfile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    $name = $request->name . 'attachments' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $data->attachments = json_encode($files);
        }
        $data->update();

        // ------------------------------
        $data1 = AuditProgramGrid::where('audit_program_id', $data->id)->first();
        $data1->delete();
        $data1 = new AuditProgramGrid();
        $data1->audit_program_id = $data->id;

        if (!empty($request->serial_number)) {
            $data1->serial_number = serialize($request->serial_number);
        }
        if (!empty($request->Auditees)) {
            $data1->auditor = serialize($request->Auditees);
        }
        if (!empty($request->start_date)) {
            $data1->start_date = serialize($request->start_date);
        }
        if (!empty($request->end_date)) {
            $data1->end_date = serialize($request->end_date);
        }
        if (!empty($request->lead_investigator)) {
            $data1->lead_investigator = serialize($request->lead_investigator);
        }
        if (!empty($request->comment)) {
            $data1->comment = serialize($request->comment);
        }
        $data1->save();

        // --------------------

        if ($lastDocument->short_description != $data->short_description || !empty($request->short_description_comment)) {
            $history = new AuditProgramAuditTrial();
            $history->AuditProgram_id = $id;
            $history->activity_type = 'Short Description';
            $history->previous = $lastDocument->short_description;
            $history->current = $data->short_description;
            $history->comment = $request->short_description_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
           $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->short_description) || $lastDocument->short_description === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
                $history->save();
            }
        if ($lastDocument->assign_to != $data->assign_to || !empty($request->assign_to_comment)) {

            $history = new AuditProgramAuditTrial();
            $history->AuditProgram_id = $id;
            $history->activity_type = 'Assigned to';
            $history->previous = Helpers::getInitiatorName($lastDocument->assign_to);
            $history->current = Helpers::getInitiatorName($data->assign_to);
            $history->comment = $request->assign_to_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
    
            // Null or empty check
            if (is_null($lastDocument->assign_to) || $lastDocument->assign_to === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }            $history->save();
        }
        if ($lastDocument->due_date != $data->due_date || !empty($request->due_date_comment)) {

            $history = new AuditProgramAuditTrial();
            $history->AuditProgram_id = $id;
            $history->activity_type = 'Date Due';
            $history->previous = Helpers::getdateFormat($lastDocument->due_date);
            $history->current = Helpers::getdateFormat($data->due_date);
            $history->comment = $request->due_date_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
        $history->change_from = $lastDocument->status;

        // Null or empty check
        if (is_null($lastDocument->due_date) || $lastDocument->due_date === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }
            $history->save();
        }
        if ($lastDocument->type != $data->type || !empty($request->type_comment)) {

            $history = new AuditProgramAuditTrial();
            $history->AuditProgram_id = $id;
            $history->activity_type = 'Type';
            $history->previous = $lastDocument->type;
            $history->current = $data->type;
            $history->comment = $request->type_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
        $history->change_from = $lastDocument->status;

        // Null or empty check
        if (is_null($lastDocument->type) || $lastDocument->type === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }
            $history->save();
        }
        if ($lastDocument->year != $data->year || !empty($request->year_comment)) {

            $history = new AuditProgramAuditTrial();
            $history->AuditProgram_id = $id;
            $history->activity_type = 'Year';
            $history->previous = $lastDocument->year;
            $history->current = $data->year;
            $history->comment = $request->year_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
        $history->change_from = $lastDocument->status;

        // Null or empty check
        if (is_null($lastDocument->year) || $lastDocument->year === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }
            $history->save();
        }
        if ($lastDocument->Quarter != $data->Quarter || !empty($request->Quarter_comment)) {

            $history = new AuditProgramAuditTrial();
            $history->AuditProgram_id = $id;
            $history->activity_type = 'Quarter';
            $history->previous = $lastDocument->Quarter;
            $history->current = $data->Quarter;
            $history->comment = $request->Quarter_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
        $history->change_from = $lastDocument->status;

        // Null or empty check
        if (is_null($lastDocument->Quarter) || $lastDocument->Quarter === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }
            $history->save();
        }
        if ($lastDocument->description != $data->description || !empty($request->description_comment)) {

            $history = new AuditProgramAuditTrial();
            $history->AuditProgram_id = $id;
            $history->activity_type = 'Description';
            $history->previous = $lastDocument->description;
            $history->current = $data->description;
            $history->comment = $request->description_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
        $history->change_from = $lastDocument->status;

        // Null or empty check
        if (is_null($lastDocument->description) || $lastDocument->description === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }
            $history->save();
        }
        if ($lastDocument->comments != $data->comments || !empty($request->comments_comment)) {

            $history = new AuditProgramAuditTrial();
            $history->AuditProgram_id = $id;
            $history->activity_type = 'Comments';
            $history->previous = $lastDocument->comments;
            $history->current = $data->comments;
            $history->comment = $request->comments_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
        $history->change_from = $lastDocument->status;

        // Null or empty check
        if (is_null($lastDocument->comments) || $lastDocument->comments === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }
            $history->save();
        }
    
        if ($lastDocument->related_url != $data->related_url || !empty($request->related_url_comment)) {

            $history = new AuditProgramAuditTrial();
            $history->AuditProgram_id = $id;
            $history->activity_type = 'Related URl,s';
            $history->previous = $lastDocument->related_url;
            $history->current = $data->related_url;
            $history->comment = $request->related_url_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
        $history->change_from = $lastDocument->status;

        // Null or empty check
        if (is_null($lastDocument->related_url) || $lastDocument->related_url === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }
            $history->save();
        }
        if ($lastDocument->url_description != $data->url_description || !empty($request->url_description_comment)) {

            $history = new AuditProgramAuditTrial();
            $history->AuditProgram_id = $id;
            $history->activity_type = 'URl,s Description';
            $history->previous = $lastDocument->url_description;
            $history->current = $data->url_description;
            $history->comment = $request->url_description_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
        $history->change_from = $lastDocument->status;
         if (is_null($lastDocument->url_description) || $lastDocument->url_description === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }
            $history->save();
        }
      

        if ($lastDocument->Initiator_Group != $data->Initiator_Group || !empty($request->Initiator_Group_comment)) {

            $history = new AuditProgramAuditTrial();
            $history->AuditProgram_id = $id;
            $history->activity_type = 'Initiator Group ';
            $history->previous = $lastDocument->Initiator_Group;
            $history->current = $data->Initiator_Group;
            $history->comment = $request->Initiator_Group_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
        $history->change_from = $lastDocument->status;
         if (is_null($lastDocument->Initiator_Group) || $lastDocument->Initiator_Group === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }
            $history->save();
        }


       
        if ($lastDocument->initiator_group_code != $data->initiator_group_code || !empty($request->initiator_group_code_comment)) {

            $history = new AuditProgramAuditTrial();
            $history->AuditProgram_id = $id;
            $history->activity_type = 'Initiator Group Code';
            $history->previous = $lastDocument->initiator_group_code;
            $history->current = $data->initiator_group_code;
            $history->comment = $request->initiator_group_code_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
        $history->change_from = $lastDocument->status;
         if (is_null($lastDocument->initiator_group_code) || $lastDocument->initiator_group_code === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }
            $history->save();
        }





        if ($lastDocument->zone != $data->zone || !empty($request->zone_comment)) {

            $history = new AuditProgramAuditTrial();
            $history->AuditProgram_id = $id;
            $history->activity_type = 'Zone';
            $history->previous = $lastDocument->zone;
            $history->current = $data->zone;
            $history->comment = $request->zone_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
        $history->change_from = $lastDocument->status;

        // Null or empty check
        if (is_null($lastDocument->zone) || $lastDocument->zone === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }
            $history->save();
        }
        if ($lastDocument->country != $data->country || !empty($request->country_comment)) {

            $history = new AuditProgramAuditTrial();
            $history->AuditProgram_id = $id;
            $history->activity_type = 'Country';
            $history->previous = $lastDocument->country;
            $history->current = $data->country;
            $history->comment = $request->country_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
        $history->change_from = $lastDocument->status;

        // Null or empty check
        if (is_null($lastDocument->country) || $lastDocument->country === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }
            $history->save();
        }
        if ($lastDocument->City != $data->City || !empty($request->City_comment)) {

            $history = new AuditProgramAuditTrial();
            $history->AuditProgram_id = $id;
            $history->activity_type = 'City';
            $history->previous = $lastDocument->City;
            $history->current = $data->City;
            $history->comment = $request->City_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
        $history->change_from = $lastDocument->status;

        // Null or empty check
        if (is_null($lastDocument->City) || $lastDocument->City === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }
            $history->save();
        }
        if ($lastDocument->state != $data->state || !empty($request->state_comment)) {

            $history = new AuditProgramAuditTrial();
            $history->AuditProgram_id = $id;
            $history->activity_type = 'State/District';
            $history->previous = $lastDocument->state;
            $history->current = $data->state;
            $history->comment = $request->state_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
        $history->change_from = $lastDocument->status;

        // Null or empty check
        if (is_null($lastDocument->state) || $lastDocument->state === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }
            $history->save();
        }
        if ($lastDocument->attachments != $data->attachments || !empty($request->attachments_comment)) {

            $history = new AuditProgramAuditTrial();
            $history->AuditProgram_id = $id;
            $history->activity_type = 'Attached Files';
            $history->previous = $lastDocument->attachments;
            $history->current = $data->attachments;
            $history->comment = $request->attachments_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
        $history->change_from = $lastDocument->status;

        // Null or empty check
        if (is_null($lastDocument->attachments) || $lastDocument->attachments === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }
            $history->save();
        }
        toastr()->success('Record is update Successfully');

        return back();
    }


    public function AuditProgramShow($id)
    {

        $data = AuditProgram::find($id);
        $data->record = str_pad($data->record, 4, '0', STR_PAD_LEFT);
        $data->assign_to_name = User::where('id', $data->assign_id)->value('name');
        $data->initiator_name = User::where('id', $data->initiator_id)->value('name');
        $AuditProgramGrid = AuditProgramGrid::where('audit_program_id', $id)->first();
        $startdate = [];
        if($AuditProgramGrid->start_date){
            $startdate = unserialize($AuditProgramGrid->start_date);
        }
        $enddate = [];
        if($AuditProgramGrid->end_date){
            $enddate = unserialize($AuditProgramGrid->end_date);
        }
        $client = new Client();
        $stateList = $client->get('https://geodata.phplift.net/api/index.php?type=getStates&countryId='.$data->country);
        $data->stateArr = json_decode($stateList->getBody(), true);
        $cityList = $client->get('https://geodata.phplift.net/api/index.php?type=getCities&countryId=&stateId='.$data->state);
        $data->cityArr = json_decode($cityList->getBody(), true); 
        $countryList = $client->get('https://geodata.phplift.net/api/index.php?type=getCountries');
        $data->countryArr = json_decode($countryList->getBody(), true);
 

        return view('frontend.audit-program.view', compact('data', 'AuditProgramGrid', 'startdate', 'enddate'));
    }


    public function AuditStateChange(Request $request, $id)
    {
        if ($request->username == Auth::user()->Username && Hash::check($request->password, Auth::user()->password)) {
            $changeControl = AuditProgram::find($id);
            $lastDocument = AuditProgram::find($id);

            if ($changeControl->stage == 1) {
                // // Get the user's IP address
                // $userIP = $request->ip(); // Laravel's way to get client IP
    
                // // Get the user's timezone using the helper function
                // $userTimeZone = Helpers::getUserTimeZone($userIP); // Explicitly call it with a backslash
    
                // // Get the current time in the user's timezone
                // $submittedOn = Carbon::now($userTimeZone)->format('d-M-Y H:i:s T');
    
                // Set the dynamically detected time for submission
                $changeControl->stage = "2";
                $changeControl->status = "Pending Approval";
                $changeControl->submitted_by = Auth::user()->name;
                $changeControl->submitted_on = Carbon::now()->format('d-M-Y');
                $changeControl->submitted_comment = $request->comment;
                // Save the activity in the history log
                $history = new AuditProgramAuditTrial();
                $history->AuditProgram_id = $id;
                $history->activity_type = 'Activity Log';
                $history->previous = "";
                $history->current = $changeControl->submitted_by;
                $history->action = 'Submit';
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to =   "Pending Approval";
                $history->change_from = $lastDocument->status;
                $history->action_name = 'Submit';
                $history->stage = 'Pending Approval';
                $history->save();
    
    



                    /********** Notification User **********/
                    $list = Helpers::getQAHeadUserList($changeControl->division_id);
                    $userIds = collect($list)->pluck('user_id')->toArray();
                    $users = User::whereIn('id', $userIds)->select('id', 'name', 'email')->get();
                    $userId = $users->pluck('id');


                    if(!empty($users)){
                    try {
                        $history = new AuditProgramAuditTrial();
                        $history->AuditProgram_id = $id;
                        $history->activity_type = "Not Applicable";
                        $history->previous = "Not Applicable";
                        $history->current = "Not Applicable";
                        $history->action = 'Notification';
                        $history->comment = "";
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->origin_state = "Not Applicable";
                        $history->change_to = "Pending Approval";
                        $history->change_from = "Opened";
                        $history->stage = "";
                        $history->action_name = "";
                        $history->mailUserId = $userId;
                        $history->role_name = "Lead Auditor";
                        $history->save();
                    } catch (\Throwable $e) {
                        \Log::error('Mail failed to send: ' . $e->getMessage());
                    }
                    }

                    foreach ($users as $userValue) {
                        DB::table('notifications')->insert([
                            'activity_id' => $changeControl->id,
                            'activity_type' => "Notification",
                            'from_id' => Auth::user()->id,
                            'user_name' => $userValue->name,
                            'to_id' => $userValue->id,
                            'process_name' => "Submit",
                            'division_id' => $changeControl->division_id,
                            'short_description' => $changeControl->short_description,
                            'initiator_id' => $changeControl->initiator_id,
                            'due_date' => $changeControl->due_date,
                            'record' => $changeControl->record,
                            'site' => "Submit",
                            'comment' => $request->comments,
                            'status' => $changeControl->status,
                            'stage' => $changeControl->stage,
                            'created_at' => Carbon::now(),
                        ]);
                    }

                    foreach ($list as $u) {
                        $email = Helpers::getUserEmail($u->user_id);
                            if ($email !== null) {
                            try {
                                Mail::send(
                                    'mail.view-mail',
                                    ['data' => $changeControl, 'site' => "audit-program", 'history' => "Submit", 'process' => 'Submit', 'comment' => $request->comments, 'user' => Auth::user()->name],
                                    function ($message) use ($email, $changeControl) {
                                        $message->to($email)
                                        ->subject("Medicef Notification: Submit, Record #" . str_pad($changeControl->record, 4, '0', STR_PAD_LEFT) . " - Activity: Submit Performed");
                                    }
                                );
                            } catch(\Exception $e) {
                                info('Error sending mail', [$e]);
                            }
                        }
                    }







                //     $list = Helpers::getInitiatorUserList();
                    
                //     foreach ($list as $u) {
                       
                //         if($u->q_m_s_divisions_id ==$changeControl->division_id){
                //             $email = Helpers::getInitiatorEmail($u->user_id);
                //              if ($email !== null) {
                          
                //               Mail::send(
                //                   'mail.view-mail',
                //                    ['data' => $changeControl],
                //                 function ($message) use ($email) {
                //                     $message->to($email)
                //                         ->subject("Document is Submitted By ".Auth::user()->name);
                //                 }
                //               );
                //             }
                //      } 
                //   }
                $changeControl->update();
                toastr()->success('Document Sent');
                return back();
            }
            if ($changeControl->stage == 2) {
                $changeControl->stage = "3";
                $changeControl->status = "Pending Audit";
                $changeControl->approved_by = Auth::user()->name;
                $changeControl->approved_on = Carbon::now()->format('d-M-Y');
                $changeControl->approved_comment = $request->comment;
                    $history = new AuditProgramAuditTrial();
                    $history->AuditProgram_id = $id;
                    $history->activity_type = 'Activity Log';
                    $history->previous = "";
                    $history->current = $changeControl->approved_by;
                    $history->action = 'Approve';
                    $history->comment = $request->comment;
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $lastDocument->status;
                    $history->change_to =   "Pending Audit";
                    $history->change_from = $lastDocument->status;
                    $history->action_name = 'Approve';
                    $history->stage = 'Pending Audit';
                  //  dd($history->action_name );
                    $history->save();



                    /********** Notification User **********/
                    $list = Helpers::getQAUserList($changeControl->division_id);
                    $userIds = collect($list)->pluck('user_id')->toArray();
                    $users = User::whereIn('id', $userIds)->select('id', 'name', 'email')->get();
                    $userId = $users->pluck('id');


                    if(!empty($users)){
                    try {
                        $history = new AuditProgramAuditTrial();
                        $history->AuditProgram_id = $id;
                        $history->activity_type = "Not Applicable";
                        $history->previous = "Not Applicable";
                        $history->current = "Not Applicable";
                        $history->action = 'Notification';
                        $history->comment = "";
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->origin_state = "Not Applicable";
                        $history->change_to = "Pending Audit";
                        $history->change_from = "Pending Approval";
                        $history->stage = "";
                        $history->action_name = "";
                        $history->mailUserId = $userId;
                        $history->role_name = "Lead Auditor";
                        $history->save();
                    } catch (\Throwable $e) {
                        \Log::error('Mail failed to send: ' . $e->getMessage());
                    }
                    }

                    foreach ($users as $userValue) {
                        DB::table('notifications')->insert([
                            'activity_id' => $changeControl->id,
                            'activity_type' => "Notification",
                            'from_id' => Auth::user()->id,
                            'user_name' => $userValue->name,
                            'to_id' => $userValue->id,
                            'process_name' => "Approve",
                            'division_id' => $changeControl->division_id,
                            'short_description' => $changeControl->short_description,
                            'initiator_id' => $changeControl->initiator_id,
                            'due_date' => $changeControl->due_date,
                            'record' => $changeControl->record,
                            'site' => "audit-program",
                            'comment' => $request->comments,
                            'status' => $changeControl->status,
                            'stage' => $changeControl->stage,
                            'created_at' => Carbon::now(),
                        ]);
                    }

                    foreach ($list as $u) {
                        $email = Helpers::getUserEmail($u->user_id);
                            if ($email !== null) {
                            try {
                                Mail::send(
                                    'mail.view-mail',
                                    ['data' => $changeControl, 'site' => "audit-program", 'history' => "Approve", 'process' => 'Approve', 'comment' => $request->comments, 'user' => Auth::user()->name],
                                    function ($message) use ($email, $changeControl) {
                                        $message->to($email)
                                        ->subject("Medicef Notification: Approve, Record #" . str_pad($changeControl->record, 4, '0', STR_PAD_LEFT) . " - Activity: Approve Performed");
                                    }
                                );
                            } catch(\Exception $e) {
                                info('Error sending mail', [$e]);
                            }
                        }
                    }


                $changeControl->update();
                toastr()->success('Document Sent');
                return back();
            }
            if ($changeControl->stage == 3) {
                $changeControl->stage = "4";
                $changeControl->status = "Closed-Done";
                $changeControl->Audit_Completed_By = Auth::user()->name;
                $changeControl->Audit_Completed_On = Carbon::now()->format('d-M-Y');
                $changeControl->Audit_Completed_comment = $request->comment;
                        $history = new AuditProgramAuditTrial();
                        $history->AuditProgram_id = $id;
                        $history->activity_type = 'Activity Log';
                        $history->previous = "";
                        $history->current = $changeControl->Audit_Completed_By;
                        $history->action = 'Audit Completed';
                        $history->comment = $request->comment;
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->origin_state = $lastDocument->status;
                        $history->change_to =   "Closed-Done";
                        $history->change_from = $lastDocument->status;
                        $history->action_name = 'Audit Completed';
                        $history->stage = 'Closed-Done';

                      //  dd($history->action_name );
                        $history->save();



                            /********** Notification User **********/
                    $list = Helpers::getQAHeadUserList($changeControl->division_id);
                    $userIds = collect($list)->pluck('user_id')->toArray();
                    $users = User::whereIn('id', $userIds)->select('id', 'name', 'email')->get();
                    $userId = $users->pluck('id');


                    if(!empty($users)){
                    try {
                        $history = new AuditProgramAuditTrial();
                        $history->AuditProgram_id = $id;
                        $history->activity_type = "Not Applicable";
                        $history->previous = "Not Applicable";
                        $history->current = "Not Applicable";
                        $history->action = 'Notification';
                        $history->comment = "";
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->origin_state = "Not Applicable";
                        $history->change_to = "Close-Done";
                        $history->change_from = "Pending Audit";
                        $history->stage = "";
                        $history->action_name = "";
                        $history->mailUserId = $userId;
                        $history->role_name = "Lead Auditor";
                        $history->save();
                    } catch (\Throwable $e) {
                        \Log::error('Mail failed to send: ' . $e->getMessage());
                    }
                    }

                    foreach ($users as $userValue) {
                        DB::table('notifications')->insert([
                            'activity_id' => $changeControl->id,
                            'activity_type' => "Notification",
                            'from_id' => Auth::user()->id,
                            'user_name' => $userValue->name,
                            'to_id' => $userValue->id,
                            'process_name' => "Audit Completed",
                            'division_id' => $changeControl->division_id,
                            'short_description' => $changeControl->short_description,
                            'initiator_id' => $changeControl->initiator_id,
                            'due_date' => $changeControl->due_date,
                            'record' => $changeControl->record,
                            'site' => "audit-program",
                            'comment' => $request->comments,
                            'status' => $changeControl->status,
                            'stage' => $changeControl->stage,
                            'created_at' => Carbon::now(),
                        ]);
                    }

                    foreach ($list as $u) {
                        $email = Helpers::getUserEmail($u->user_id);
                            if ($email !== null) {
                            try {
                                Mail::send(
                                    'mail.view-mail',
                                    ['data' => $changeControl, 'site' => "audit-program", 'history' => "Audit Completed", 'process' => 'Audit Completed', 'comment' => $request->comments, 'user' => Auth::user()->name],
                                    function ($message) use ($email, $changeControl) {
                                        $message->to($email)
                                        ->subject("Medicef Notification: Audit Completed, Record #" . str_pad($changeControl->record, 4, '0', STR_PAD_LEFT) . " - Activity: Audit Completed Activity Performed");
                                    }
                                );
                            } catch(\Exception $e) {
                                info('Error sending mail', [$e]);
                            }
                        }
                    }
                $changeControl->update();
                toastr()->success('Document Sent');
                return back();
            }
        } else {
            toastr()->error('E-signature Not match');
            return back();
        }
    }

    public function AuditRejectStateChange(Request $request, $id)
    {
        if ($request->username == Auth::user()->Username && Hash::check($request->password, Auth::user()->password)) {
            $changeControl = AuditProgram::find($id);
            $lastDocument = AuditProgram::find($id);

            if ($changeControl->stage == 2) {
                $changeControl->stage = "1";
                $changeControl->status = "Opened";
                $changeControl->rejected_by = Auth::user()->name;
                $changeControl->rejected_on  = Carbon::now()->format('d-M-Y');
                $changeControl->Reject_comment = $request->comment;
                        $history = new AuditProgramAuditTrial();
                        $history->AuditProgram_id = $id;
                        $history->activity_type = 'Activity Log';
                        $history->previous = "";
                        $history->current = $changeControl->rejected_by;
                        $history->action = 'More Info Required';
                        $history->comment = $request->comment;
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->origin_state = $lastDocument->status;
                        $history->change_to =   "Opened";
                        $history->change_from = $lastDocument->status;
                        $history->action_name = 'More Info Required';
                        $history->stage = 'Opened';
                        $history->save();
                    //     $list = Helpers::getAuditManagerUserList();
                    //     foreach ($list as $u) {
                    //         if($u->q_m_s_divisions_id == $changeControl->division_id){
                    //             $email = Helpers::getInitiatorEmail($u->user_id);
                    //              if ($email !== null) {
                              
                    //               Mail::send(
                    //                   'mail.view-mail',
                    //                    ['data' => $changeControl],
                    //                 function ($message) use ($email) {
                    //                     $message->to($email)
                    //                         ->subject("Document is Rejected By ".Auth::user()->name);
                    //                 }
                    //               );
                    //             }
                    //      } 
                    //   }
               
                $changeControl->update();
                toastr()->success('Document Sent');
                return back();
            }
        } else {
            toastr()->error('E-signature Not match');
            return back();
        }
    }

    public function AuditProgramCancel(Request $request, $id)
    {
        if ($request->username == Auth::user()->Username && Hash::check($request->password, Auth::user()->password)) {
            $changeControl = AuditProgram::find($id);
            $lastDocument = AuditProgram::find($id);

            if ($changeControl->stage == 1) {
                $changeControl->stage = "0";
                $changeControl->status = "Closed-Cancelled";
                $changeControl->cancelled_by   = Auth::user()->name;
                $changeControl->cancelled_on = Carbon::now()->format('d-M-Y');
                $changeControl->cancel_1_comment = $request->comment;
                            $history = new AuditProgramAuditTrial();
                            $history->AuditProgram_id = $id;
                            $history->activity_type = 'Activity Log';
                            $history->previous = "";
                            $history->current = $changeControl->cancelled_by;
                            $history->comment = $request->comment;
                            $history->action= 'Cancel';
                            $history->user_id = Auth::user()->id;
                            $history->user_name = Auth::user()->name;
                            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                            $history->origin_state = $lastDocument->status;
                            $history->change_to =   "Closed-Cancelled";
                            $history->change_from = $lastDocument->status;
                            $history->action_name = 'Closed-Cancelled';
                            $history->stage = 'Closed-Cancelled';

                            // Null or empty check
                            if (is_null($lastDocument->model_number) || $lastDocument->model_number === '') {
                                $history->action_name = "New";
                            } else {
                                $history->action_name = "Update";
                            }
                            $history->stage = 'Cancelled';
                            $history->save();


                        /********** Notification User **********/
                        $list = Helpers::getHodUserList($changeControl->division_id);
                        $userIds = collect($list)->pluck('user_id')->toArray();
                        $users = User::whereIn('id', $userIds)->select('id', 'name', 'email')->get();
                        $userId = $users->pluck('id');


                        if(!empty($users)){
                        try {
                            $history = new AuditProgramAuditTrial();
                            $history->AuditProgram_id = $id;
                            $history->activity_type = "Not Applicable";
                            $history->previous = "Not Applicable";
                            $history->current = "Not Applicable";
                            $history->action = 'Notification';
                            $history->comment = "";
                            $history->user_id = Auth::user()->id;
                            $history->user_name = Auth::user()->name;
                            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                            $history->origin_state = "Not Applicable";
                            $history->change_to = "Close-Done";
                            $history->change_from = "Opened";
                            $history->stage = "";
                            $history->action_name = "";
                            $history->mailUserId = $userId;
                            $history->role_name = "Lead Auditor";
                            $history->save();
                        } catch (\Throwable $e) {
                            \Log::error('Mail failed to send: ' . $e->getMessage());
                        }
                        }

                        foreach ($users as $userValue) {
                            DB::table('notifications')->insert([
                                'activity_id' => $changeControl->id,
                                'activity_type' => "Notification",
                                'from_id' => Auth::user()->id,
                                'user_name' => $userValue->name,
                                'to_id' => $userValue->id,
                                'process_name' => " Audit Program",
                                'division_id' => $changeControl->division_id,
                                'short_description' => $changeControl->short_description,
                                'initiator_id' => $changeControl->initiator_id,
                                'due_date' => $changeControl->due_date,
                                'record' => $changeControl->record,
                                'site' => " Audit Program",
                                'comment' => $request->comments,
                                'status' => $changeControl->status,
                                'stage' => $changeControl->stage,
                                'created_at' => Carbon::now(),
                            ]);
                        }

                        foreach ($list as $u) {
                            $email = Helpers::getUserEmail($u->user_id);
                                if ($email !== null) {
                                try {
                                    Mail::send(
                                        'mail.view-mail',
                                        ['data' => $changeControl, 'site' => " Audit Program", 'history' => "Cancel", 'process' => ' Audit Program', 'comment' => $request->comments, 'user' => Auth::user()->name],
                                        function ($message) use ($email, $changeControl) {
                                            $message->to($email)
                                            ->subject("Medicef Notification:  Audit Program, Record #" . str_pad($changeControl->record, 4, '0', STR_PAD_LEFT) . " - Activity: Cancel Performed");
                                        }
                                    );
                                } catch(\Exception $e) {
                                    info('Error sending mail', [$e]);
                                }
                            }
                        }







                        $changeControl->update();
                        toastr()->success('Document Sent');
                        return back();
                    }
            if ($changeControl->stage == 2) {
                $changeControl->stage = "0";
                $changeControl->status = "Closed - Cancelled";
                $changeControl->cancel_second_by  = Auth::user()->name;
                $changeControl->cancel_second_on = Carbon::now()->format('d-M-Y');
                $changeControl->cancel_2_comment = $request->comment;      
                        $history = new AuditProgramAuditTrial();
                        $history->AuditProgram_id = $id;
                        $history->activity_type = 'Activity Log';
                        $history->previous = "";
                        $history->current = $changeControl->cancelled_by;
                        $history->comment = $request->comment;
                        $history->action= 'Cancel';
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->origin_state = $lastDocument->status;
                        $history->change_to = "'Closed-Cancelled";
                        $history->change_from = $lastDocument->status;
                        $history->action_name = 'Closed-Cancelled';
                        $history->stage = 'Closed-Cancelled';
        $history->change_from = $lastDocument->status;

        // Null or empty check
        if (is_null($lastDocument->model_number) || $lastDocument->model_number === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }
                        $history->stage = 'Cancelled';
                        $history->save();
                $changeControl->update();
                toastr()->success('Document Sent');
                return back();
            }
            if ($changeControl->stage == 3) {
                $changeControl->stage = "0";
                $changeControl->status = "Closed - Cancelled";
                $changeControl->cancel_third_by  = Auth::user()->name;
                $changeControl->cancel_third_on = Carbon::now()->format('d-M-Y');
            //    $changeControl->cancel_third_on = $request->comment;
                $changeControl->Reject_comment_2 = $request->comment;      
               
                        $history = new AuditProgramAuditTrial();
                        $history->AuditProgram_id = $id;
                        $history->activity_type = 'Activity Log';
                        $history->previous = "";
                        $history->current = $changeControl->cancel_third_by;
                        $history->action= 'Cancel';
                        $history->comment = $request->comment;
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->origin_state = $lastDocument->status;
                        $history->change_to = "'Closed-Cancelled"; 
                        $history->change_from = $lastDocument->status;
                        $history->action_name = 'Closed-Cancelled';
                        $history->stage = 'Closed-Cancelled';
                    
      
                        $history->stage = 'Cancelled';
                        $history->save();
                $changeControl->update();
                toastr()->success('Document Sent');
                return back();
            }
        }
    }

    public function AuditProgramTrialShow($id)
    {         

        $audit = AuditProgramAuditTrial::where('AuditProgram_id', $id)->orderByDESC('id')->paginate();
        $today = Carbon::now()->format('d-m-y');
        $document = AuditProgram::where('id', $id)->first();
        $document->initiator = User::where('id', $document->initiator_id)->value('name');

        return view('frontend.audit-program.audit-trial', compact('audit', 'document', 'today'));
    }
    public function auditProgramDetails($id)
    {

        $detail = AuditProgramAuditTrial::find($id);

        $detail_data = AuditProgramAuditTrial::where('activity_type', $detail->activity_type)->where('AuditProgram_id', $detail->AuditProgram_id)->latest()->get();

        $doc = AuditProgram::where('id', $detail->AuditProgram_id)->first();

        $doc->origiator_name = User::find($doc->initiator_id);
        return view('frontend.audit-program.audit-trial-inner', compact('detail', 'doc', 'detail_data'));
    }

    public function child_audit_program(Request $request, $id)
    {
        $parent_id = $id;
        $parent_type = "Audit_Program";
        $record_number = ((RecordNumber::first()->value('counter')) + 1);
        $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
        $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $due_date = $formattedDate->format('d-M-Y');
       // $old_record = InternalAudit::select('id', 'division_id', 'record')->get();
       $internal_audit_records = InternalAudit::select('id', 'division_id', 'record')->get();
       $auditee_records = Auditee::select('id', 'division_id', 'record')->get();
       $old_record = $internal_audit_records->merge($auditee_records);
        // if ($request->child_type == "Internal_Audit") {
        //     return view('frontend.forms.audit', compact('old_record','record_number', 'due_date', 'parent_id', 'parent_type'));
        // }
        
        // if ($request->child_type == "extension") {
        //     $parent_due_date = "";
        //     $parent_id = $id;
        //     $parent_name = $request->parent_name;
        //     if ($request->due_date) {
        //         $parent_due_date = $request->due_date;
        //     }

        //     $record_number = ((RecordNumber::first()->value('counter')) + 1);
        //     $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
        //     return view('frontend.forms.extension', compact('parent_id', 'parent_name', 'record_number', 'parent_due_date'));
        // }
        // else {
        //     return view('frontend.forms.auditee', compact('old_record','record_number', 'due_date', 'parent_id', 'parent_type'));
        // }

        if ($request->child_type == "Internal_Audit") {
            return view('frontend.forms.audit', compact('old_record', 'record_number', 'due_date', 'parent_id', 'parent_type'));
        } elseif ($request->child_type == "External_Audit") {
            $parent_due_date = $request->due_date ?? "";
            return view('frontend.forms.auditee', compact('old_record', 'record_number', 'due_date', 'parent_id', 'parent_type'));
        } else {
            return view('frontend.forms.extension', compact('old_record', 'record_number', 'due_date', 'parent_id', 'parent_type'));
        }
        
    }

    public function activityprint($id)
    {

      //  return "hello";
        $data = AuditProgram::find($id);
        if (!empty($data)) {
            $data->originator = User::where('id', $data->initiator_id)->value('name');
            $pdf = App::make('dompdf.wrapper');
            $time = Carbon::now();
            $pdf = PDF::loadview('frontend.audit-program.Activitylogprint', compact('data'))
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
            return $pdf->stream('Audit-Program' . $id . '.pdf');
        }
    }


    // public static function faimilyReport($id)
    // {
    //     $data = AuditProgram::find($id);
    //     $ExternalAudit = Auditee::where('parent_id',$id)->get();
    //     $InternalAudit =  InternalAudit::where('parent_id', $id)->get();
    //     $grid_data = InternalAuditGrid::where('audit_id',$id)->where('type', "internal_audit")->first();
    //     if (!empty($grid_data)) {
    //         // Unserialize the necessary fields
    //         $grid_data->area_of_audit = unserialize($grid_data->area_of_audit);
    //         $grid_data->start_date = unserialize($grid_data->start_date);
    //         $grid_data->start_time = unserialize($grid_data->start_time);
    //         $grid_data->end_date = unserialize($grid_data->end_date);
    //         $grid_data->end_time = unserialize($grid_data->end_time);
    //         $grid_data->auditor = unserialize($grid_data->auditor);
    //         $grid_data->auditee = unserialize($grid_data->auditee);
    //         $grid_data->remark = unserialize($grid_data->remark);
    //     }
    //      if (!empty($data)) {
    //         $data->originator = User::where('id', $data->initiator_id)->value('name');
    //         $pdf = App::make('dompdf.wrapper');
            
    //         $time = Carbon::now();
    //         $pdf = PDF::loadview('frontend.audit-program.faimilyReport', compact('data','ExternalAudit','InternalAudit','grid_data'))
    //             ->setOptions([
    //                 'defaultFont' => 'sans-serif',
    //                 'isHtml5ParserEnabled' => true,
    //                 'isRemoteEnabled' => true,
    //                 'isPhpEnabled' => true,
    //             ]);
    //         $pdf->setPaper('A4');
    //         $pdf->render();
    //         $canvas = $pdf->getDomPDF()->getCanvas();
    //         $height = $canvas->get_height();
    //         $width = $canvas->get_width();
    //         $canvas->page_script('$pdf->set_opacity(0.1,"Multiply");');
    //         $canvas->page_text($width / 4, $height / 2, $data->status, null, 25, [0, 0, 0], 2, 6, -20);
    //         return $pdf->stream('Audit-Program' . $id . '.pdf');
    //     }
    // }


    public static function faimilyReport($id)
    {
        $data = AuditProgram::find($id);
        $ExternalAudit = Auditee::where('parent_id',$id)->get();
        $AuditProgramGrid = AuditProgramGrid::where('audit_program_id', $data->id)->first();
     
        $InternalAudit =  InternalAudit::where('parent_id', $id)->get();
        $checklist1 = IA_checklist_tablet_compression::where('ia_id', $id)->first();
        $checklist2 = IA_checklist_tablet_coating::where('ia_id', $id)->first();
        $checklist3 = IA_checklist_capsule_paking::where('ia_id', $id)->first();
        $checklist4 = Checklist_Capsule::where('ia_id', $id)->first();
        $checklist5 = IA_liquid_ointment::where('ia_id', $id)->first();
        $checklist6 = IA_dispencing_manufacturing::where('ia_id', $id)->first();
        $checklist7 = IA_ointment_paking::where('ia_id', $id)->first();
        $checklist9 = IA_checklist_engineering::where('ia_id', $id)->first();
        $checklist10 = IA_quality_control::where('ia_id', $id)->first();
        $checklist11 = IA_checklist_stores::where('ia_id', $id)->first();
        $checklist12 = IA_checklist_hr::where('ia_id', $id)->first();
        $checklist13 = IA_checklist_dispensing::where('ia_id', $id)->first();
        $checklist14 = IA_checklist_production_injection::where('ia_id', $id)->first();
        $checklist15 = IA_checklist_manufacturing_filling::where('ia_id', $id)->first();
        $checklist16 = IA_checklist_analytical_research::where('ia_id', $id)->first();
        $checklist17 = IA_checklist__formulation_research::where('ia_id', $id)->first();
         $auditorview = InternalAuditorGrid::where(['auditor_id'=>$id, 'identifier'=>'Auditors'])->first();
        $grid_data = InternalAuditGrid::where('audit_id', $id)->where('type', "internal_audit")->first();
        $grid_Data3 = InternalAuditObservationGrid::where(['io_id' =>$id, 'identifier' => 'observations'])->first();
        $grid_Data5 = InternalAuditObservationGrid::where(['io_id' => $id, 'identifier' => 'Initial'])->first();
        if (!empty($grid_data)) {
            // Unserialize the necessary fields
            $grid_data->area_of_audit = unserialize($grid_data->area_of_audit);
            $grid_data->start_date = unserialize($grid_data->start_date);
            $grid_data->start_time = unserialize($grid_data->start_time);
            $grid_data->end_date = unserialize($grid_data->end_date);
            $grid_data->end_time = unserialize($grid_data->end_time);
            $grid_data->auditor = unserialize($grid_data->auditor);
            $grid_data->auditee = unserialize($grid_data->auditee);
            $grid_data->remark = unserialize($grid_data->remark);
        }

        if (!empty($data)) {
            $data->originator = User::where('id', $data->initiator_id)->value('name');
            $pdf = App::make('dompdf.wrapper');
            
            $time = Carbon::now();
            $pdf = PDF::loadview('frontend.audit-program.faimilyReport', compact('data','ExternalAudit','AuditProgramGrid','InternalAudit','checklist1','checklist2','checklist3','checklist4','checklist5','checklist6','checklist7','checklist9','checklist10','checklist11','checklist12','checklist13','checklist14','checklist15','checklist16','checklist17','grid_data','grid_Data3','grid_Data5','auditorview'))
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
            return $pdf->stream('Audit-Program' . $id . '.pdf');
        }
    }


    


    public static function singleReport($id)
    {
        $data = AuditProgram::find($id);
        $AuditProgramGrid = AuditProgramGrid::where('audit_program_id', $data->id)->first();
        //dd($AuditProgramGrid);
        if (!empty($data)) {
            $data->originator = User::where('id', $data->initiator_id)->value('name');
            $pdf = App::make('dompdf.wrapper');
            $time = Carbon::now();
            $pdf = PDF::loadview('frontend.audit-program.singleReport', compact('data','AuditProgramGrid'))
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
            return $pdf->stream('Audit-Program' . $id . '.pdf');
        }
    }

    public static function auditReport($id)
    {
        $doc = AuditProgram::find($id);
        if (!empty($doc)) {
            $doc->originator = User::where('id', $doc->initiator_id)->value('name');
            $data = AuditProgramAuditTrial::where('AuditProgram_id', $id)->get();
            $pdf = App::make('dompdf.wrapper');
            $time = Carbon::now();
            $pdf = PDF::loadview('frontend.audit-program.auditReport', compact('data', 'doc'))
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
            $canvas->page_text($width / 4, $height / 2, $doc->status, null, 25, [0, 0, 0], 2, 6, -20);
            return $pdf->stream('AuditProgram-AuditTrial' . $id . '.pdf');
        }
    }


    public function auditprogram_exportCsv(Request $request)
    {
        $query = AuditProgram::query();
            if (!empty($request->department_auditprogram)) {
                $query->whereIn('Initiator_Group', $request->department_auditprogram);  // Use whereIn for multiple selections
            }
    
            if ($request->division_id_auditprogram) {
                $query->where('division_id', $request->division_id_auditprogram);
            }
    
            if ($request->initiator_id_auditprogram) {
                $query->where('initiator_id', $request->initiator_id_auditprogram);
            }
    
            if ($request->date_fromauditprogram) {
                $dateFrom = Carbon::parse($request->date_fromauditprogram)->startOfDay();
                $query->whereDate('intiation_date', '>=', $dateFrom);
            }
    
            if ($request->date_toauditprogram) {
                $dateTo = Carbon::parse($request->date_toauditprogram)->endOfDay();
                $query->whereDate('intiation_date', '<=', $dateTo);
            }
    
      
      
        $auditprogram = $query->get();
    
        $fileName = 'AuditProgram_csv.csv';
        $headers = [
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename=\"$fileName\"",
        ];
    
        $columns = [
            'Sr. No.', 'Initiation Date', 'Record No',
            'Division', 'Department Name', 'Short Description.', 'Due Date',
            'Initiator', 'Status'
        ];
    
        $callback = function () use ($auditprogram, $columns) {
            $file = fopen('php://output', 'w');
    
            fputcsv($file, $columns);
    
            if ($auditprogram->isEmpty()) {
                fputcsv($file, ['No records found']);
            } else {
                foreach ($auditprogram as $index => $row) {
                    $data = [
                        $index + 1, 
                        $row->intiation_date ?? 'Not Applicable', 
                        $row->division ? $row->division->name . '/CC/' . date('Y') . '/' . str_pad($row->record, 4, '0', STR_PAD_LEFT) : 'Not Applicable',
                        $row->division ? $row->division->name : 'Not Applicable', 
                        $row->Initiator_Group ?? 'Not Applicable', 
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
    
    


    public function auditprogram_exportExcel(Request $request)
    {
        $query = AuditProgram::query();
        if (!empty($request->department_auditprogram)) {
            $query->whereIn('Initiator_Group', $request->department_auditprogram);  // Use whereIn for multiple selections
        }

        if ($request->division_id_auditprogram) {
            $query->where('division_id', $request->division_id_auditprogram);
        }

        if ($request->initiator_id_auditprogram) {
            $query->where('initiator_id', $request->initiator_id_auditprogram);
        }

        if ($request->date_fromauditprogram) {
            $dateFrom = Carbon::parse($request->date_fromauditprogram)->startOfDay();
            $query->whereDate('intiation_date', '>=', $dateFrom);
        }

        if ($request->date_toauditprogram) {
            $dateTo = Carbon::parse($request->date_toauditprogram)->endOfDay();
            $query->whereDate('intiation_date', '<=', $dateTo);
        }

  
  
    $auditprogram = $query->get();

        $fileName = "AuditProgram_csv.xls";
    
        $headers = [
            "Content-Type" => "application/vnd.ms-excel",
            "Content-Disposition" => "attachment; filename=\"$fileName\"",
        ];
    
        $columns = [
            'Sr. No.', 'Initiation Date', 'Record No',
            'Division', 'Department Name', 'Short Description.', 'Due Date',
            'Initiator', 'Status'
        ];
    
        $callback = function () use ($auditprogram, $columns) {
            echo '<table border="1">';
    
            echo '<tr style="font-weight: bold; background-color: #1F4E79; color: #FFFFFF;">';
            foreach ($columns as $column) {
                echo "<th style='padding: 5px;'>" . htmlspecialchars($column) . "</th>";
            }
            echo '</tr>';
    
            if ($auditprogram->isEmpty()) {
                echo '<tr>';
                echo "<td colspan='" . count($columns) . "' style='text-align: center;'>No records found</td>";
                echo '</tr>';
            } else {
                foreach ($auditprogram as $index => $row) {
                    echo '<tr>';
                    echo "<td style='padding: 5px;'>" . ($index + 1) . "</td>";
                    echo "<td style='padding: 5px;'>" . htmlspecialchars($row->intiation_date ?? 'Not Applicable') . "</td>";
                    echo "<td style='padding: 5px;'>" . htmlspecialchars($row->division ? $row->division->name . '/CC/' . date('Y') . '/' . str_pad($row->record, 4, '0', STR_PAD_LEFT) : 'Not Applicable') . "</td>";
                    echo "<td style='padding: 5px;'>" . htmlspecialchars( $row->division ? $row->division->name : 'Not Applicable') . "</td>";
                    echo "<td style='padding: 5px;'>" . htmlspecialchars($row->Initiator_Group ?? 'Not Applicable') . "</td>";
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
