<?php

namespace App\Http\Controllers\lims;
use App\Models\RecordNumber;
use App\Models\User;
use App\Models\ControlSampleGrid;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\ControlSample;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


use Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\RoleGroup;
use App\Models\auditTrailSampleControl;
use App\Models\InternalAuditGrid;
use App\Models\AuditTrialExternal;
use PDF;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;


class ControlSampleController extends Controller
{
    public function index(){

       // dd($request->all());

        $record_number = ((RecordNumber::first()->value('counter')) + 1);
        $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
        $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $due_date = $formattedDate->format('Y-m-d');
        return view('frontend.control-sample.controlSampleNew', compact('record_number'));
    }

    public function store(Request $request) 
    {
        if (!$request->short_description) {
            toastr()->error("Short description is required");
            return redirect()->back()->withInput();
        }
        $ControlSample = new ControlSample();
        $ControlSample->form_type = "ControlSample Details";
        $ControlSample->record = ((RecordNumber::first()->value('counter')) + 1);
        $ControlSample->initiator_id = Auth::user()->id;
        $ControlSample->division_id = $request->division_id;
        $ControlSample->division_code = $request->division_code;
        $ControlSample->intiation_date = $request->intiation_date;
        $ControlSample->form_type = $request->form_type;
        $ControlSample->record_number = $request->record_number;
        $ControlSample->parent_id = $request->parent_id;
        $ControlSample->sample_id = $request->sample_id;
        $ControlSample->assign_to = $request->assign_to;
        $ControlSample->due_date = $request->due_date;
        $ControlSample->short_description = $request->short_description;
        $ControlSample->product_name = $request->product_name;
        $ControlSample->product_code = $request->product_code;
        $ControlSample->sample_type = $request->sample_type;
        $ControlSample->market = $request->market;
        $ControlSample->ar_number = $request->ar_number;
        $ControlSample->batch_number = $request->batch_number;
        $ControlSample->manufacturing_date = $request->manufacturing_date;
        $ControlSample->expiry_date = $request->expiry_date;
        $ControlSample->quantity = $request->expiry_date;
        $ControlSample->quantity_withdrawn = $request->quantity_withdrawn;
        $ControlSample->unit_of_measurment = $request->unit_of_measurment;
        $ControlSample->storage_location = $request->storage_location;
        $ControlSample->storage_condition = $request->storage_condition;
        $ControlSample->vi_scheduled_on = $request->vi_scheduled_on;
        $ControlSample->vi_performed_by = $request->vi_performed_by;
        $ControlSample->abnormal_observation = $request->abnormal_observation;
        $ControlSample->observation_date = $request->observation_date;
        $ControlSample->destruction_due_on = $request->destruction_due_on;
        $ControlSample->destroyed_by = $request->destroyed_by;
        $ControlSample->neutralizing_agent = $request->neutralizing_agent;
        $ControlSample->destruction_date = $request->destruction_date;
        $ControlSample->remarks = $request->remarks;
        $ControlSample->reagion_item = $request->reagion_item;
        $ControlSample->status = $request->status;
        if (!empty($request->supportive_attachment)) {
            $files = [];
            if ($request->hasfile('supportive_attachment')) {
                foreach ($request->file('supportive_attachment') as $file) {
                    $name = $request->name . '-supportive_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $ControlSample->supportive_attachment = json_encode($files);
        }  

        $ControlSample->status = 'Opened';
        $ControlSample->stage = 1;

        // $ControlSample->save();

        $record = RecordNumber::first();
        $record->counter = ((RecordNumber::first()->value('counter')) + 1);
        $record->update();

        $ControlSample->save();

           

            $control_samples_id = $ControlSample->id;

            $ControlSampleGrid = ControlSampleGrid::where(['control_samples_id' => $control_samples_id, 'identifier' => 'ControlSampleGrid'])->firstOrNew();
            $ControlSampleGrid->control_samples_id = $control_samples_id;
            $ControlSampleGrid->identifier = 'ControlSampleGrid';
            $ControlSampleGrid->data = $request->ControlSampleGrid;
            // dd($ControlSampleGrid);
            $ControlSampleGrid->save();
            
            


    //-----------------------------Audit Trail---------------------------------------------------
    

       

    if (!empty($ControlSample->record)) {
        $history = new auditTrailSampleControl();
        $history->control_samples_id = $ControlSample->id;
        $history->activity_type = 'Record Number';
        $history->previous = "Null";
        $history->current = Helpers::getDivisionName(session()->get('division')) . "/CS/" . Helpers::year($ControlSample->created_at) . "/" . str_pad($ControlSample->record, 4, '0', STR_PAD_LEFT);
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ControlSample->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';

        $history->save();
    }

    if(!empty($ControlSample->division_code))
    {

        $history = new auditTrailSampleControl();
        $history->control_samples_id = $ControlSample->id;
        $history->activity_type = 'Site/Location Code';
        $history->previous = "Null";
        $history->current = $ControlSample->division_code;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ControlSample->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';

        $history->save();
    }

        $history = new auditTrailSampleControl();
        $history->control_samples_id = $ControlSample->id;
        $history->activity_type = 'Initiator';
        $history->previous = "Null";
        $history->current =Auth::user()->name;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ControlSample->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';

        $history->save();


        if (!empty($ControlSample->intiation_date)) {
            $history = new auditTrailSampleControl();
            $history->control_samples_id = $ControlSample->id;
            $history->activity_type = 'Date of Initiation';
            $history->previous = "Null";
            $history->current =Helpers::getdateFormat($ControlSample->intiation_date);
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $ControlSample->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
    
            $history->save();
        }

        
        if (!empty($ControlSample->assign_to)) {
            $history = new auditTrailSampleControl();
            $history->control_samples_id = $ControlSample->id;
            $history->activity_type = 'Assigned To';
            $history->previous = "Null";
            $history->current =Helpers::getInitiatorName($ControlSample->assign_to);
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $ControlSample->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
         
            $history->save();
        }


        if (!empty($ControlSample->due_date)) {
            $history = new auditTrailSampleControl();
            $history->control_samples_id = $ControlSample->id;
            $history->activity_type = 'Due Date';
            $history->previous = "Null";
            $history->current = Helpers::getdateFormat($ControlSample->due_dete);
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $ControlSample->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
            $history->save();
        }
 

        if (!empty($ControlSample->short_description)) {
            $history = new auditTrailSampleControl();
            $history->control_samples_id = $ControlSample->id;
            $history->activity_type = 'Short Description';
            $history->previous = "Null";
            $history->current = $ControlSample->short_description;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $ControlSample->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
        
            $history->save();
        }


        // if (!empty($ControlSample->product_name)) {
        //     $history = new auditTrailSampleControl();
        //     $history->control_samples_id = $ControlSample->id;
        //     $history->activity_type = 'Product Name';
        //     $history->previous = "Null";
        //     $history->current =$ControlSample->product_name;
        //     $history->comment = "NA";
        //     $history->user_id = Auth::user()->id;
        //     $history->user_name = Auth::user()->name;
        //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        //     $history->origin_state = $ControlSample->status;
        //     $history->change_to =   "Opened";
        //     $history->change_from = "Null";
        //     $history->action_name = 'Create';
        
        //     $history->save();
        // }

        if (!empty($ControlSample->sample_id)) {
            $history = new auditTrailSampleControl();
            $history->control_samples_id = $ControlSample->id;
            $history->activity_type = 'Sample Id';
            $history->previous = "Null";
            $history->current =$ControlSample->sample_id;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $ControlSample->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($ControlSample->reagion_item)) {
            $history = new auditTrailSampleControl();
            $history->control_samples_id = $ControlSample->id;
            $history->activity_type = 'Reagent Item Required?';
            $history->previous = "Null";
            $history->current =$ControlSample->reagion_item;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $ControlSample->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
        
            $history->save();
        }

    // if (!empty($ControlSample->product_code)) {
    //     $history = new auditTrailSampleControl();
    //     $history->control_samples_id = $ControlSample->id;
    //     $history->activity_type = 'Product Code';
    //     $history->previous = "Null";
    //     $history->current =$ControlSample->product_code;
    //     $history->comment = "NA";
    //     $history->user_id = Auth::user()->id;
    //     $history->user_name = Auth::user()->name;
    //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    //     $history->origin_state = $ControlSample->status;
    //     $history->change_to =   "Opened";
    //     $history->change_from = "Null";
    //     $history->action_name = 'Create';
    //     $history->save();
    // }

    // if (!empty($ControlSample->sample_type)) {
    //     $history = new auditTrailSampleControl();
    //     $history->control_samples_id = $ControlSample->id;
    //     $history->activity_type = 'Sample Type';
    //     $history->previous = "Null";
    //     $history->current =$ControlSample->sample_type;
    //     $history->comment = "NA";
    //     $history->user_id = Auth::user()->id;
    //     $history->user_name = Auth::user()->name;
    //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    //     $history->origin_state = $ControlSample->status;
    //     $history->change_to =   "Opened";
    //     $history->change_from = "Null";
    //     $history->action_name = 'Create';
     
    //     $history->save();
    // }

    // if (!empty($ControlSample->market)) {
    //     $history = new auditTrailSampleControl();
    //     $history->control_samples_id = $ControlSample->id;
    //     $history->activity_type = 'Market';
    //     $history->previous = "Null";
    //     $history->current =$ControlSample->market;
    //     $history->comment = "NA";
    //     $history->user_id = Auth::user()->id;
    //     $history->user_name = Auth::user()->name;
    //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    //     $history->origin_state = $ControlSample->status;
    //     $history->change_to =   "Opened";
    //     $history->change_from = "Null";
    //     $history->action_name = 'Create';
     
    //     $history->save();
    // }

    // if (!empty($ControlSample->ar_number)) {
    //     $history = new auditTrailSampleControl();
    //     $history->control_samples_id = $ControlSample->id;
    //     $history->activity_type = 'AR Number';
    //     $history->previous = "Null";
    //     $history->current =$ControlSample->ar_number;
    //     $history->comment = "NA";
    //     $history->user_id = Auth::user()->id;
    //     $history->user_name = Auth::user()->name;
    //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    //     $history->origin_state = $ControlSample->status;
    //     $history->change_to =   "Opened";
    //     $history->change_from = "Null";
    //     $history->action_name = 'Create';
     
    //     $history->save();
    // }

    // if (!empty($ControlSample->batch_number)) {
    //     $history = new auditTrailSampleControl();
    //     $history->control_samples_id = $ControlSample->id;
    //     $history->activity_type = 'Batch Number';
    //     $history->previous = "Null";
    //     $history->current =$ControlSample->batch_number;
    //     $history->comment = "NA";
    //     $history->user_id = Auth::user()->id;
    //     $history->user_name = Auth::user()->name;
    //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    //     $history->origin_state = $ControlSample->status;
    //     $history->change_to =   "Opened";
    //     $history->change_from = "Null";
    //     $history->action_name = 'Create';
     
    //     $history->save();
    // }

    // if (!empty($ControlSample->manufacturing_date)) {
    //     $history = new auditTrailSampleControl();
    //     $history->control_samples_id = $ControlSample->id;
    //     $history->activity_type = 'Manufacturing Date';
    //     $history->previous = "Null";
    //     $history->current =$ControlSample->manufacturing_date;
    //     $history->comment = "NA";
    //     $history->user_id = Auth::user()->id;
    //     $history->user_name = Auth::user()->name;
    //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    //     $history->origin_state = $ControlSample->status;
    //     $history->change_to =   "Opened";
    //     $history->change_from = "Null";
    //     $history->action_name = 'Create';
     
    //     $history->save();
    // }

    // if (!empty($ControlSample->expiry_date)) {
    //     $history = new auditTrailSampleControl();
    //     $history->control_samples_id = $ControlSample->id;
    //     $history->activity_type = 'Expiry Date';
    //     $history->previous = "Null";
    //     $history->current =$ControlSample->expiry_date;
    //     $history->comment = "NA";
    //     $history->user_id = Auth::user()->id;
    //     $history->user_name = Auth::user()->name;
    //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    //     $history->origin_state = $ControlSample->status;
    //     $history->change_to =   "Opened";
    //     $history->change_from = "Null";
    //     $history->action_name = 'Create';
     
    //     $history->save();
    // }


    // if (!empty($ControlSample->quantity)) {
    //     $history = new auditTrailSampleControl();
    //     $history->control_samples_id = $ControlSample->id;
    //     $history->activity_type = 'Quantity';
    //     $history->previous = "Null";
    //     $history->current =$ControlSample->quantity;
    //     $history->comment = "NA";
    //     $history->user_id = Auth::user()->id;
    //     $history->user_name = Auth::user()->name;
    //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    //     $history->origin_state = $ControlSample->status;
    //     $history->change_to =   "Opened";
    //     $history->change_from = "Null";
    //     $history->action_name = 'Create';
    
    //     $history->save();
    // }

    // if (!empty($ControlSample->quantity_withdrawn)) {
    //     $history = new auditTrailSampleControl();
    //     $history->control_samples_id = $ControlSample->id;
    //     $history->activity_type = 'Quantity Withdrawn';
    //     $history->previous = "Null";
    //     $history->current =$ControlSample->quantity_withdrawn;
    //     $history->comment = "NA";
    //     $history->user_id = Auth::user()->id;
    //     $history->user_name = Auth::user()->name;
    //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    //     $history->origin_state = $ControlSample->status;
    //     $history->change_to =   "Opened";
    //     $history->change_from = "Null";
    //     $history->action_name = 'Create';
    
    //     $history->save();
    // }

    // if (!empty($ControlSample->unit_of_measurment)) {
    //     $history = new auditTrailSampleControl();
    //     $history->control_samples_id = $ControlSample->id;
    //     $history->activity_type = 'Unit of Measurement (UOM)';
    //     $history->previous = "Null";
    //     $history->current =$ControlSample->unit_of_measurment;
    //     $history->comment = "NA";
    //     $history->user_id = Auth::user()->id;
    //     $history->user_name = Auth::user()->name;
    //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    //     $history->origin_state = $ControlSample->status;
    //     $history->change_to =   "Opened";
    //     $history->change_from = "Null";
    //     $history->action_name = 'Create';
    
    //     $history->save();
    // }

    // if (!empty($ControlSample->storage_location)) {
    //     $history = new auditTrailSampleControl();
    //     $history->control_samples_id = $ControlSample->id;
    //     $history->activity_type = 'Storage Location';
    //     $history->previous = "Null";
    //     $history->current =$ControlSample->storage_location;
    //     $history->comment = "NA";
    //     $history->user_id = Auth::user()->id;
    //     $history->user_name = Auth::user()->name;
    //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    //     $history->origin_state = $ControlSample->status;
    //     $history->change_to =   "Opened";
    //     $history->change_from = "Null";
    //     $history->action_name = 'Create';
    
    //     $history->save();
    // }

    // if (!empty($ControlSample->storage_condition)) {
    //     $history = new auditTrailSampleControl();
    //     $history->control_samples_id = $ControlSample->id;
    //     $history->activity_type = 'Storage Condition';
    //     $history->previous = "Null";
    //     $history->current =$ControlSample->storage_condition;
    //     $history->comment = "NA";
    //     $history->user_id = Auth::user()->id;
    //     $history->user_name = Auth::user()->name;
    //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    //     $history->origin_state = $ControlSample->status;
    //     $history->change_to =   "Opened";
    //     $history->change_from = "Null";
    //     $history->action_name = 'Create';
    
    //     $history->save();
    // }


    // if (!empty($ControlSample->vi_scheduled_on)) {
    //     $history = new auditTrailSampleControl();
    //     $history->control_samples_id = $ControlSample->id;
    //     $history->activity_type = 'Visual Inspection Scheduled On';
    //     $history->previous = "Null";
    //     $history->current =$ControlSample->vi_scheduled_on;
    //     $history->comment = "NA";
    //     $history->user_id = Auth::user()->id;
    //     $history->user_name = Auth::user()->name;
    //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    //     $history->origin_state = $ControlSample->status;
    //     $history->change_to =   "Opened";
    //     $history->change_from = "Null";
    //     $history->action_name = 'Create';
    
    //     $history->save();
    // }

    // if (!empty($ControlSample->vi_performed_by)) {
    //     $history = new auditTrailSampleControl();
    //     $history->control_samples_id = $ControlSample->id;
    //     $history->activity_type = 'Visual Inspection Performed By';
    //     $history->previous = "Null";
    //     $history->current =$ControlSample->vi_performed_by;
    //     $history->comment = "NA";
    //     $history->user_id = Auth::user()->id;
    //     $history->user_name = Auth::user()->name;
    //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    //     $history->origin_state = $ControlSample->status;
    //     $history->change_to =   "Opened";
    //     $history->change_from = "Null";
    //     $history->action_name = 'Create';
    
    //     $history->save();
    // }


    // if (!empty($ControlSample->abnormal_observation)) {
    //     $history = new auditTrailSampleControl();
    //     $history->control_samples_id = $ControlSample->id;
    //     $history->activity_type = 'Abnormal Observation';
    //     $history->previous = "Null";
    //     $history->current =$ControlSample->abnormal_observation;
    //     $history->comment = "NA";
    //     $history->user_id = Auth::user()->id;
    //     $history->user_name = Auth::user()->name;
    //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    //     $history->origin_state = $ControlSample->status;
    //     $history->change_to =   "Opened";
    //     $history->change_from = "Null";
    //     $history->action_name = 'Create';
    
    //     $history->save();
    // }


    // if (!empty($ControlSample->observation_date)) {
    //     $history = new auditTrailSampleControl();
    //     $history->control_samples_id = $ControlSample->id;
    //     $history->activity_type = 'Observation Date';
    //     $history->previous = "Null";
    //     $history->current =$ControlSample->observation_date;
    //     $history->comment = "NA";
    //     $history->user_id = Auth::user()->id;
    //     $history->user_name = Auth::user()->name;
    //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    //     $history->origin_state = $ControlSample->status;
    //     $history->change_to =   "Opened";
    //     $history->change_from = "Null";
    //     $history->action_name = 'Create';
    
    //     $history->save();
    // }


    // if (!empty($ControlSample->destruction_due_on)) {
    //     $history = new auditTrailSampleControl();
    //     $history->control_samples_id = $ControlSample->id;
    //     $history->activity_type = 'Destruction Due On';
    //     $history->previous = "Null";
    //     $history->current =$ControlSample->destruction_due_on;
    //     $history->comment = "NA";
    //     $history->user_id = Auth::user()->id;
    //     $history->user_name = Auth::user()->name;
    //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    //     $history->origin_state = $ControlSample->status;
    //     $history->change_to =   "Opened";
    //     $history->change_from = "Null";
    //     $history->action_name = 'Create';
    
    //     $history->save();
    // }



    // if (!empty($ControlSample->destroyed_by)) {
    //     $history = new auditTrailSampleControl();
    //     $history->control_samples_id = $ControlSample->id;
    //     $history->activity_type = 'Destroyed By';
    //     $history->previous = "Null";
    //     $history->current =$ControlSample->destroyed_by;
    //     $history->comment = "NA";
    //     $history->user_id = Auth::user()->id;
    //     $history->user_name = Auth::user()->name;
    //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    //     $history->origin_state = $ControlSample->status;
    //     $history->change_to =   "Opened";
    //     $history->change_from = "Null";
    //     $history->action_name = 'Create';
    
    //     $history->save();
    // }

    // if (!empty($ControlSample->neutralizing_agent)) {
    //     $history = new auditTrailSampleControl();
    //     $history->control_samples_id = $ControlSample->id;
    //     $history->activity_type = 'Neutralizing Agent';
    //     $history->previous = "Null";
    //     $history->current =$ControlSample->neutralizing_agent;
    //     $history->comment = "NA";
    //     $history->user_id = Auth::user()->id;
    //     $history->user_name = Auth::user()->name;
    //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    //     $history->origin_state = $ControlSample->status;
    //     $history->change_to =   "Opened";
    //     $history->change_from = "Null";
    //     $history->action_name = 'Create';
    
    //     $history->save();
    // }

    // if (!empty($ControlSample->destruction_date)) {
    //     $history = new auditTrailSampleControl();
    //     $history->control_samples_id = $ControlSample->id;
    //     $history->activity_type = 'Destruction Date';
    //     $history->previous = "Null";
    //     $history->current =$ControlSample->destruction_date;
    //     $history->comment = "NA";
    //     $history->user_id = Auth::user()->id;
    //     $history->user_name = Auth::user()->name;
    //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    //     $history->origin_state = $ControlSample->status;
    //     $history->change_to =   "Opened";
    //     $history->change_from = "Null";
    //     $history->action_name = 'Create';
    
    //     $history->save();
    // }

    // if (!empty($ControlSample->status)) {
    //     $history = new auditTrailSampleControl();
    //     $history->control_samples_id = $ControlSample->id;
    //     $history->activity_type = 'Status';
    //     $history->previous = "Null";
    //     $history->current =$ControlSample->status;
    //     $history->comment = "NA";
    //     $history->user_id = Auth::user()->id;
    //     $history->user_name = Auth::user()->name;
    //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    //     $history->origin_state = $ControlSample->status;
    //     $history->change_to =   "Opened";
    //     $history->change_from = "Null";
    //     $history->action_name = 'Create';
    
    //     $history->save();
    // }

    // if (!empty($ControlSample->remarks)) {
    //     $history = new auditTrailSampleControl();
    //     $history->control_samples_id = $ControlSample->id;
    //     $history->activity_type = 'Remarks';
    //     $history->previous = "Null";
    //     $history->current =$ControlSample->remarks;
    //     $history->comment = "NA";
    //     $history->user_id = Auth::user()->id;
    //     $history->user_name = Auth::user()->name;
    //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    //     $history->origin_state = $ControlSample->status;
    //     $history->change_to =   "Opened";
    //     $history->change_from = "Null";
    //     $history->action_name = 'Create';
    
    //     $history->save();
    // }

    // List of fields to track for changes
$fieldsToTrack = [
    'product_name', 'product_code', 'sample_type', 'market', 'ar_no', 
    'batch_number', 'manufacturing_date', 'expiry_date', 'quantity', 
    'uom', 'visual_inspection_scheduled_on', 'schedule_date', 'quantity_withdrawn', 
    'reason_for_withdrawal', 'current_quantity', 'storage_location', 'storage_condition', 
    'inspection_date', 'inspection_detail', 'inspection_done_by', 'destruction_due_on', 
    'destruction_date', 'destroyed_by', 'neutralizing_agent', 'instruction_for_destruction', 
    'remarks'
];

// Loop through all fields to log changes
foreach ($fieldsToTrack as $field) {
    if (!empty($ControlSample->$field)) {
        $history = new auditTrailSampleControl();
        $history->control_samples_id = $ControlSample->id;
        $history->activity_type = ucfirst(str_replace('_', ' ', $field)); // Format field name
        $history->previous = "Null"; // Set as "Null" initially (can be updated to previous value if editing)
        $history->current = $ControlSample->$field;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ControlSample->status;
        $history->change_to = "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';

        $history->save();
    }
}


if(!empty($ControlSample->Implementor_Attachment))
        {
            $history = new auditTrailSampleControl();
            $history->control_samples_id = $ControlSample->id;
            $history->activity_type = 'Supportive Attachment';
            $history->previous = "Null";
            $history->current =$ControlSample->Implementor_Attachment;
            $history->comment = "Null";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $ControlSample->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
         
            $history->save();
        }

         //-----------------------------Audit Trail---------------------------------------------------
 
        toastr()->success("Record is Create Successfully");
        return redirect(url('rcms/lims-dashboard'));


    }


    public function controSampleShow($id)
    {
        $data = ControlSample::find($id);
        
        $controlSampleData  = ControlSample::find($id);
        
        $record_number = ((RecordNumber::first()->value('counter')) + 1);
        $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
        $controlSampleData->record = str_pad($controlSampleData->record, 4, '0', STR_PAD_LEFT);
        $controlSampleData->assign_to_name = User::where('id', $controlSampleData->assign_id)->value('name');
        $controlSampleData->initiator_name = User::where('id', $controlSampleData->initiator_id)->value('name');
        $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $due_date = $formattedDate->format('Y-m-d');
        

        $ControlSampleGrid = ControlSampleGrid::where(['control_samples_id' => $id, 'identifier' => 'ControlSampleGrid' ])->first();
    
        // dd($ControlSampleGrid);
        // $ControlSampleGridData = $ControlSampleGrid ? json_decode($ControlSampleGrid->data, true) : [];
        return view ('frontend.control-sample.controSampleView', compact('data','ControlSampleGrid', 'controlSampleData','record_number'));
    }




    public function AuditTrialSampleControlShow($id)
    {

    $audit = auditTrailSampleControl::where('control_samples_id', $id)->orderByDESC('id')->get()->unique('activity_type');
        $audit = auditTrailSampleControl::where('control_samples_id', $id)->orderByDESC('id')->paginate(5);
        $today = Carbon::now()->format('d-m-y');
        $document = ControlSample::where('id', $id)->first();
        $document->initiator = User::where('id', $document->initiator_id)->value('name');
      //  return view('frontend.externalAudit.audit-trial', compact('audit', 'document', 'today'));
      return view('frontend.control-sample.audit-trial', compact('audit', 'document', 'today'));
     }
    public function controlSampleUpdate(Request $request ,$id)
    {

        
        $lastDocument = ControlSample::find($id);
        $controlSampleData = ControlSample::find($id);

        $controlSampleData->parent_id = $request->parent_id;
        $controlSampleData->sample_id = $request->sample_id;
        $controlSampleData->assign_to = $request->assign_to;
        $controlSampleData->due_date = $request->due_date;
        $controlSampleData->short_description = $request->short_description;
        $controlSampleData->product_name = $request->product_name;
        $controlSampleData->product_code = $request->product_code;
        $controlSampleData->sample_type = $request->sample_type;
        $controlSampleData->market = $request->market;
        $controlSampleData->ar_number = $request->ar_number;
        $controlSampleData->batch_number = $request->batch_number;
        $controlSampleData->manufacturing_date = $request->manufacturing_date;
        $controlSampleData->expiry_date = $request->expiry_date;
        $controlSampleData->quantity = $request->expiry_date;
        $controlSampleData->quantity_withdrawn = $request->quantity_withdrawn;
        $controlSampleData->unit_of_measurment = $request->unit_of_measurment;
        $controlSampleData->storage_location = $request->storage_location;
        $controlSampleData->storage_condition = $request->storage_condition;
        $controlSampleData->vi_scheduled_on = $request->vi_scheduled_on;
        $controlSampleData->vi_performed_by = $request->vi_performed_by;
        $controlSampleData->abnormal_observation = $request->abnormal_observation;
        $controlSampleData->observation_date = $request->observation_date;
        $controlSampleData->destruction_due_on = $request->destruction_due_on;
        $controlSampleData->destroyed_by = $request->destroyed_by;
        $controlSampleData->neutralizing_agent = $request->neutralizing_agent;
        $controlSampleData->destruction_date = $request->destruction_date;
        $controlSampleData->remarks = $request->remarks;
        $controlSampleData->reagion_item = $request->reagion_item;
        $controlSampleData->status = $request->status;

        // =============================================Update Grid ================================//

        $control_samples_id = $controlSampleData->id;

        $ControlSampleGrid = ControlSampleGrid::where(['control_samples_id' => $control_samples_id, 'identifier' => 'ControlSampleGrid'])->firstOrNew();
        $ControlSampleGrid->control_samples_id = $control_samples_id;
        $ControlSampleGrid->identifier = 'ControlSampleGrid';
        $ControlSampleGrid->data = $request->ControlSampleGrid;
        // dd( $ControlSampleGrid);
        $ControlSampleGrid->save();

        

        if (!empty($request->supportive_attachment)) {
            $files = [];
            if ($request->hasfile('supportive_attachment')) {
                foreach ($request->file('supportive_attachment') as $file) {
                    $name = $request->name . '-supportive_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $controlSampleData->supportive_attachment = json_encode($files);
        }
        
        $controlSampleData->update();

            

        if ($lastDocument->short_description != $controlSampleData->short_description || !empty($request->short_description_comment)) {

            $history = new auditTrailSampleControl();
            $history->control_samples_id = $id;
             $history->activity_type = 'Short Description';
            $history->previous = $lastDocument->short_description;
            $history->current = $controlSampleData->short_description;
            $history->comment = $request->date_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            if (is_null($lastDocument->short_description) || $lastDocument->short_description === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
         
            $history->save();
        }



        // if ($lastDocument->due_date != $controlSampleData->due_date || !empty($request->due_date_comment)) {

        //     $history = new auditTrailSampleControl();
        //     $history->control_samples_id = $id;
        //      $history->activity_type = 'Due Date';
        //     $history->previous = $lastDocument->due_date;
        //     $history->current = $controlSampleData->due_date;
        //     $history->comment = $request->date_comment;
        //     $history->user_id = Auth::user()->id;
        //     $history->user_name = Auth::user()->name;
        //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        //     $history->origin_state = $lastDocument->status;
        //     $history->change_to =   "Not Applicable";
        //     $history->change_from = $lastDocument->status;
        //     if (is_null($lastDocument->due_date) || $lastDocument->due_date === '') {
        //         $history->action_name = "New";
        //     } else {
        //         $history->action_name = "Update";
        //     }
         
        //     $history->save();
        // }


        if ($lastDocument->assign_to != $controlSampleData->assign_to || !empty($request->assign_to_comment)) {

            $history = new auditTrailSampleControl();
            $history->control_samples_id = $id;
             $history->activity_type = 'Assigned To';
            $history->previous = $lastDocument->assign_to;
            $history->current = Helpers::getInitiatorName($controlSampleData->assign_to);
            $history->comment = Helpers::getInitiatorName($request->date_comment);
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            if (is_null($lastDocument->assign_to) || $lastDocument->assign_to === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
         
            $history->save();
        }


        
        if ($lastDocument->reagion_item != $controlSampleData->reagion_item || !empty($request->reagion_item_comment)) {

            $history = new auditTrailSampleControl();
            $history->control_samples_id = $id;
             $history->activity_type = 'Reagent Item Required?';
            $history->previous = $lastDocument->reagion_item;
            $history->current = Helpers::getInitiatorName($controlSampleData->reagion_item);
            $history->comment = Helpers::getInitiatorName($request->date_comment);
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            if (is_null($lastDocument->assign_to) || $lastDocument->assign_to === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
         
            $history->save();
        }

        // if ($lastDocument->product_name != $controlSampleData->product_name || !empty($request->product_name_comment)) {

        //     $history = new auditTrailSampleControl();
        //     $history->control_samples_id = $id;
        //      $history->activity_type = 'Product Name';
        //     $history->previous = $lastDocument->product_name;
        //     $history->current = $controlSampleData->product_name;
        //     $history->comment = $request->date_comment;
        //     $history->user_id = Auth::user()->id;
        //     $history->user_name = Auth::user()->name;
        //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        //     $history->origin_state = $lastDocument->status;
        //     $history->change_to =   "Not Applicable";
        //     $history->change_from = $lastDocument->status;
        //     if (is_null($lastDocument->product_name) || $lastDocument->product_name === '') {
        //         $history->action_name = "New";
        //     } else {
        //         $history->action_name = "Update";
        //     }
         
        //     $history->save();
        // }


        // if ($lastDocument->product_code != $controlSampleData->product_code || !empty($request->product_code_comment)) {

        //     $history = new auditTrailSampleControl();
        //     $history->control_samples_id = $id;
        //      $history->activity_type = 'Product Code';
        //     $history->previous = $lastDocument->product_code;
        //     $history->current = $controlSampleData->product_code;
        //     $history->comment = $request->date_comment;
        //     $history->user_id = Auth::user()->id;
        //     $history->user_name = Auth::user()->name;
        //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        //     $history->origin_state = $lastDocument->status;
        //     $history->change_to =   "Not Applicable";
        //     $history->change_from = $lastDocument->status;
        //     if (is_null($lastDocument->product_code) || $lastDocument->product_code === '') {
        //         $history->action_name = "New";
        //     } else {
        //         $history->action_name = "Update";
        //     }
         
        //     $history->save();
        // }


        // if ($lastDocument->sample_type != $controlSampleData->sample_type || !empty($request->sample_type_comment)) {

        //     $history = new auditTrailSampleControl();
        //     $history->control_samples_id = $id;
        //      $history->activity_type = 'Sample Type';
        //     $history->previous = $lastDocument->sample_type;
        //     $history->current = $controlSampleData->sample_type;
        //     $history->comment = $request->date_comment;
        //     $history->user_id = Auth::user()->id;
        //     $history->user_name = Auth::user()->name;
        //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        //     $history->origin_state = $lastDocument->status;
        //     $history->change_to =   "Not Applicable";
        //     $history->change_from = $lastDocument->status;
        //     if (is_null($lastDocument->sample_type) || $lastDocument->sample_type === '') {
        //         $history->action_name = "New";
        //     } else {
        //         $history->action_name = "Update";
        //     }
         
        //     $history->save();
        // }

        // if ($lastDocument->market != $controlSampleData->market || !empty($request->market_comment)) {

        //     $history = new auditTrailSampleControl();
        //     $history->control_samples_id = $id;
        //      $history->activity_type = 'Market';
        //     $history->previous = $lastDocument->market;
        //     $history->current = $controlSampleData->market;
        //     $history->comment = $request->date_comment;
        //     $history->user_id = Auth::user()->id;
        //     $history->user_name = Auth::user()->name;
        //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        //     $history->origin_state = $lastDocument->status;
        //     $history->change_to =   "Not Applicable";
        //     $history->change_from = $lastDocument->status;
        //     if (is_null($lastDocument->market) || $lastDocument->market === '') {
        //         $history->action_name = "New";
        //     } else {
        //         $history->action_name = "Update";
        //     }
         
        //     $history->save();
        // }


        // if ($lastDocument->ar_number != $controlSampleData->ar_number || !empty($request->ar_number_comment)) {

        //     $history = new auditTrailSampleControl();
        //     $history->control_samples_id = $id;
        //      $history->activity_type = 'AR Number';
        //     $history->previous = $lastDocument->ar_number;
        //     $history->current = $controlSampleData->ar_number;
        //     $history->comment = $request->date_comment;
        //     $history->user_id = Auth::user()->id;
        //     $history->user_name = Auth::user()->name;
        //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        //     $history->origin_state = $lastDocument->status;
        //     $history->change_to =   "Not Applicable";
        //     $history->change_from = $lastDocument->status;
        //     if (is_null($lastDocument->ar_number) || $lastDocument->ar_number === '') {
        //         $history->action_name = "New";
        //     } else {
        //         $history->action_name = "Update";
        //     }
         
        //     $history->save();
        // }

        //     if ($lastDocument->batch_number != $controlSampleData->batch_number || !empty($request->batch_number_comment)) {

        //     $history = new auditTrailSampleControl();
        //     $history->control_samples_id = $id;
        //     $history->activity_type = 'Batch Number';
        //     $history->previous = $lastDocument->batch_number;
        //     $history->current = $controlSampleData->batch_number;
        //     $history->comment = $request->date_comment;
        //     $history->user_id = Auth::user()->id;
        //     $history->user_name = Auth::user()->name;
        //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        //     $history->origin_state = $lastDocument->status;
        //     $history->change_to =   "Not Applicable";
        //     $history->change_from = $lastDocument->status;
        //     if (is_null($lastDocument->batch_number) || $lastDocument->batch_number === '') {
        //         $history->action_name = "New";
        //     } else {
        //         $history->action_name = "Update";
        //     }
         
        //     $history->save();
        // }

        // if ($lastDocument->manufacturing_date != $controlSampleData->manufacturing_date || !empty($request->manufacturing_date_comment)) {

        //     $history = new auditTrailSampleControl();
        //     $history->control_samples_id = $id;
        //      $history->activity_type = 'Manufacturing Date';
        //     $history->previous = $lastDocument->manufacturing_date;
        //     $history->current = $controlSampleData->manufacturing_date;
        //     $history->comment = $request->date_comment;
        //     $history->user_id = Auth::user()->id;
        //     $history->user_name = Auth::user()->name;
        //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        //     $history->origin_state = $lastDocument->status;
        //     $history->change_to =   "Not Applicable";
        //     $history->change_from = $lastDocument->status;
        //     if (is_null($lastDocument->manufacturing_date) || $lastDocument->manufacturing_date === '') {
        //         $history->action_name = "New";
        //     } else {
        //         $history->action_name = "Update";
        //     }
         
        //     $history->save();
        // }


        // if ($lastDocument->expiry_date != $controlSampleData->expiry_date || !empty($request->expiry_date_comment)) {

        //     $history = new auditTrailSampleControl();
        //     $history->control_samples_id = $id;
        //      $history->activity_type = 'Expiry Date';
        //     $history->previous = $lastDocument->expiry_date;
        //     $history->current = $controlSampleData->expiry_date;
        //     $history->comment = $request->date_comment;
        //     $history->user_id = Auth::user()->id;
        //     $history->user_name = Auth::user()->name;
        //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        //     $history->origin_state = $lastDocument->status;
        //     $history->change_to =   "Not Applicable";
        //     $history->change_from = $lastDocument->status;
        //     if (is_null($lastDocument->expiry_date) || $lastDocument->expiry_date === '') {
        //         $history->action_name = "New";
        //     } else {
        //         $history->action_name = "Update";
        //     }
         
        //     $history->save();
        // }

        // if ($lastDocument->quantity != $controlSampleData->quantity || !empty($request->quantity_comment)) {

        //     $history = new auditTrailSampleControl();
        //     $history->control_samples_id = $id;
        //     $history->activity_type = 'Quantity';
        //     $history->previous = $lastDocument->quantity;
        //     $history->current = $controlSampleData->quantity;
        //     $history->comment = $request->date_comment;
        //     $history->user_id = Auth::user()->id;
        //     $history->user_name = Auth::user()->name;
        //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        //     $history->origin_state = $lastDocument->status;
        //     $history->change_to =   "Not Applicable";
        //     $history->change_from = $lastDocument->status;
        //     if (is_null($lastDocument->quantity) || $lastDocument->quantity === '') {
        //         $history->action_name = "New";
        //     } else {
        //         $history->action_name = "Update";
        //     }
         
        //     $history->save();
        // }

        // 
        
        // if ($lastDocument->quantity_withdrawn != $controlSampleData->quantity_withdrawn || !empty($request->quantity_withdrawn_comment)) {

        //     $history = new auditTrailSampleControl();
        //     $history->control_samples_id = $id;
        //      $history->activity_type = 'Quantity Withdrawn';
        //     $history->previous = $lastDocument->quantity_withdrawn;
        //     $history->current = $controlSampleData->quantity_withdrawn;
        //     $history->comment = $request->date_comment;
        //     $history->user_id = Auth::user()->id;
        //     $history->user_name = Auth::user()->name;
        //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        //     $history->origin_state = $lastDocument->status;
        //     $history->change_to =   "Not Applicable";
        //     $history->change_from = $lastDocument->status;
        //     if (is_null($lastDocument->quantity_withdrawn) || $lastDocument->quantity_withdrawn === '') {
        //         $history->action_name = "New";
        //     } else {
        //         $history->action_name = "Update";
        //     }
         
        //     $history->save();
        // }


        // if ($lastDocument->unit_of_measurment != $controlSampleData->unit_of_measurment || !empty($request->unit_of_measurment_comment)) {

        //     $history = new auditTrailSampleControl();
        //     $history->control_samples_id = $id;
        //      $history->activity_type = 'Unit of Measurement (UOM)';
        //     $history->previous = $lastDocument->unit_of_measurment;
        //     $history->current = $controlSampleData->unit_of_measurment;
        //     $history->comment = $request->date_comment;
        //     $history->user_id = Auth::user()->id;
        //     $history->user_name = Auth::user()->name;
        //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        //     $history->origin_state = $lastDocument->status;
        //     $history->change_to =   "Not Applicable";
        //     $history->change_from = $lastDocument->status;
        //     if (is_null($lastDocument->unit_of_measurment) || $lastDocument->unit_of_measurment === '') {
        //         $history->action_name = "New";
        //     } else {
        //         $history->action_name = "Update";
        //     }
         
        //     $history->save();
        // }


        // if ($lastDocument->storage_location != $controlSampleData->storage_location || !empty($request->storage_location_comment)) {

        //     $history = new auditTrailSampleControl();
        //     $history->control_samples_id = $id;
        //      $history->activity_type = 'Storage Location';
        //     $history->previous = $lastDocument->storage_location;
        //     $history->current = $controlSampleData->storage_location;
        //     $history->comment = $request->date_comment;
        //     $history->user_id = Auth::user()->id;
        //     $history->user_name = Auth::user()->name;
        //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        //     $history->origin_state = $lastDocument->status;
        //     $history->change_to =   "Not Applicable";
        //     $history->change_from = $lastDocument->status;
        //     if (is_null($lastDocument->storage_location) || $lastDocument->storage_location === '') {
        //         $history->action_name = "New";
        //     } else {
        //         $history->action_name = "Update";
        //     }
         
        //     $history->save();
        // }

        //     if ($lastDocument->storage_condition != $controlSampleData->storage_condition || !empty($request->storage_condition_comment)) {

        //     $history = new auditTrailSampleControl();
        //     $history->control_samples_id = $id;
        //     $history->activity_type = 'Storage Condition';
        //     $history->previous = $lastDocument->storage_condition;
        //     $history->current = $controlSampleData->storage_condition;
        //     $history->comment = $request->date_comment;
        //     $history->user_id = Auth::user()->id;
        //     $history->user_name = Auth::user()->name;
        //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        //     $history->origin_state = $lastDocument->status;
        //     $history->change_to =   "Not Applicable";
        //     $history->change_from = $lastDocument->status;
        //     if (is_null($lastDocument->storage_condition) || $lastDocument->storage_condition === '') {
        //         $history->action_name = "New";
        //     } else {
        //         $history->action_name = "Update";
        //     }
         
        //     $history->save();
        // }

        // if ($lastDocument->vi_scheduled_on != $controlSampleData->vi_scheduled_on || !empty($request->vi_scheduled_on_comment)) {

        //     $history = new auditTrailSampleControl();
        //     $history->control_samples_id = $id;
        //     $history->activity_type = 'Visual Inspection Scheduled On';
        //     $history->previous = $lastDocument->vi_scheduled_on;
        //     $history->current = $controlSampleData->vi_scheduled_on;
        //     $history->comment = $request->date_comment;
        //     $history->user_id = Auth::user()->id;
        //     $history->user_name = Auth::user()->name;
        //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        //     $history->origin_state = $lastDocument->status;
        //     $history->change_to =   "Not Applicable";
        //     $history->change_from = $lastDocument->status;
        //     if (is_null($lastDocument->vi_scheduled_on) || $lastDocument->vi_scheduled_on === '') {
        //         $history->action_name = "New";
        //     } else {
        //         $history->action_name = "Update";
        //     }
         
        //     $history->save();
        // }


        // if ($lastDocument->vi_performed_by != $controlSampleData->vi_performed_by || !empty($request->vi_performed_by_comment)) {

        //     $history = new auditTrailSampleControl();
        //     $history->control_samples_id = $id;
        //      $history->activity_type = 'Visual Inspection Performed By';
        //     $history->previous = $lastDocument->vi_performed_by;
        //     $history->current = $controlSampleData->vi_performed_by;
        //     $history->comment = $request->date_comment;
        //     $history->user_id = Auth::user()->id;
        //     $history->user_name = Auth::user()->name;
        //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        //     $history->origin_state = $lastDocument->status;
        //     $history->change_to =   "Not Applicable";
        //     $history->change_from = $lastDocument->status;
        //     if (is_null($lastDocument->vi_performed_by) || $lastDocument->vi_performed_by === '') {
        //         $history->action_name = "New";
        //     } else {
        //         $history->action_name = "Update";
        //     }
         
        //     $history->save();
        // }

        // if ($lastDocument->abnormal_observation != $controlSampleData->abnormal_observation || !empty($request->abnormal_observation_comment)) {

        //     $history = new auditTrailSampleControl();
        //     $history->control_samples_id = $id;
        //     $history->activity_type = 'Abnormal Observation';
        //     $history->previous = $lastDocument->abnormal_observation;
        //     $history->current = $controlSampleData->abnormal_observation;
        //     $history->comment = $request->date_comment;
        //     $history->user_id = Auth::user()->id;
        //     $history->user_name = Auth::user()->name;
        //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        //     $history->origin_state = $lastDocument->status;
        //     $history->change_to =   "Not Applicable";
        //     $history->change_from = $lastDocument->status;
        //     if (is_null($lastDocument->abnormal_observation) || $lastDocument->abnormal_observation === '') {
        //         $history->action_name = "New";
        //     } else {
        //         $history->action_name = "Update";
        //     }
         
        //     $history->save();
        // }
        // if ($lastDocument->observation_date != $controlSampleData->observation_date || !empty($request->observation_date_comment)) {

        //     $history = new auditTrailSampleControl();
        //     $history->control_samples_id = $id;
        //      $history->activity_type = 'Observation Date';
        //     $history->previous = $lastDocument->observation_date;
        //     $history->current = $controlSampleData->observation_date;
        //     $history->comment = $request->date_comment;
        //     $history->user_id = Auth::user()->id;
        //     $history->user_name = Auth::user()->name;
        //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        //     $history->origin_state = $lastDocument->status;
        //     $history->change_to =   "Not Applicable";
        //     $history->change_from = $lastDocument->status;
        //     if (is_null($lastDocument->observation_date) || $lastDocument->observation_date === '') {
        //         $history->action_name = "New";
        //     } else {
        //         $history->action_name = "Update";
        //     }
         
        //     $history->save();
        // }


        // if ($lastDocument->destroyed_by != $controlSampleData->destroyed_by || !empty($request->destroyed_by_comment)) {

        //     $history = new auditTrailSampleControl();
        //     $history->control_samples_id = $id;
        //      $history->activity_type = 'Destroyed By';
        //     $history->previous = $lastDocument->destroyed_by;
        //     $history->current = $controlSampleData->destroyed_by;
        //     $history->comment = $request->date_comment;
        //     $history->user_id = Auth::user()->id;
        //     $history->user_name = Auth::user()->name;
        //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        //     $history->origin_state = $lastDocument->status;
        //     $history->change_to =   "Not Applicable";
        //     $history->change_from = $lastDocument->status;
        //     if (is_null($lastDocument->destroyed_by) || $lastDocument->destroyed_by === '') {
        //         $history->action_name = "New";
        //     } else {
        //         $history->action_name = "Update";
        //     }
         
        //     $history->save();
        // }


    //  if ($lastDocument->neutralizing_agent != $controlSampleData->neutralizing_agent || !empty($request->neutralizing_agent_comment)) {

    //     $history = new auditTrailSampleControl();
    //     $history->control_samples_id = $id;
    //      $history->activity_type = 'Neutralizing Agent';
    //     $history->previous = $lastDocument->neutralizing_agent;
    //     $history->current = $controlSampleData->neutralizing_agent;
    //     $history->comment = $request->date_comment;
    //     $history->user_id = Auth::user()->id;
    //     $history->user_name = Auth::user()->name;
    //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    //     $history->origin_state = $lastDocument->status;
    //     $history->change_to =   "Not Applicable";
    //     $history->change_from = $lastDocument->status;
    //     if (is_null($lastDocument->neutralizing_agent) || $lastDocument->neutralizing_agent === '') {
    //         $history->action_name = "New";
    //     } else {
    //         $history->action_name = "Update";
    //     }
     
    //     $history->save();
    // }

    // if ($lastDocument->destruction_date != $controlSampleData->destruction_date || !empty($request->destruction_date_comment)) {

    //     $history = new auditTrailSampleControl();
    //     $history->control_samples_id = $id;
    //      $history->activity_type = 'Destruction Date';
    //     $history->previous = $lastDocument->destruction_date;
    //     $history->current = $controlSampleData->destruction_date;
    //     $history->comment = $request->date_comment;
    //     $history->user_id = Auth::user()->id;
    //     $history->user_name = Auth::user()->name;
    //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    //     $history->origin_state = $lastDocument->status;
    //     $history->change_to =   "Not Applicable";
    //     $history->change_from = $lastDocument->status;
    //     if (is_null($lastDocument->destruction_date) || $lastDocument->destruction_date === '') {
    //         $history->action_name = "New";
    //     } else {
    //         $history->action_name = "Update";
    //     }
     
    //     $history->save();
    // }


    // if ($lastDocument->status != $controlSampleData->status || !empty($request->status_comment)) {

    //     $history = new auditTrailSampleControl();
    //     $history->control_samples_id = $id;
    //      $history->activity_type = 'Status';
    //     $history->previous = $lastDocument->status;
    //     $history->current = $controlSampleData->status;
    //     $history->comment = $request->date_comment;
    //     $history->user_id = Auth::user()->id;
    //     $history->user_name = Auth::user()->name;
    //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    //     $history->origin_state = $lastDocument->status;
    //     $history->change_to =   "Not Applicable";
    //     $history->change_from = $lastDocument->status;
    //     if (is_null($lastDocument->status) || $lastDocument->status === '') {
    //         $history->action_name = "New";
    //     } else {
    //         $history->action_name = "Update";
    //     }
     
    //     $history->save();
    // }

    // if ($lastDocument->remarks != $controlSampleData->remarks || !empty($request->remarks_comment)) {

    //         $history = new auditTrailSampleControl();
    //         $history->control_samples_id = $id;
    //          $history->activity_type = 'Remarks';
    //         $history->previous = $lastDocument->remarks;
    //         $history->current = $controlSampleData->remarks;
    //         $history->comment = $request->date_comment;
    //         $history->user_id = Auth::user()->id;
    //         $history->user_name = Auth::user()->name;
    //         $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    //         $history->origin_state = $lastDocument->status;
    //         $history->change_to =   "Not Applicable";
    //         $history->change_from = $lastDocument->status;
    //         if (is_null($lastDocument->remarks) || $lastDocument->remarks === '') {
    //             $history->action_name = "New";
    //         } else {
    //             $history->action_name = "Update";
    //         }
        
    //         $history->save();
    //     }


    // if ($lastDocument->observation_date != $controlSampleData->observation_date || !empty($request->observation_date_comment)) {

    //     $history = new auditTrailSampleControl();
    //     $history->control_samples_id = $id;
    //      $history->activity_type = 'Observation Date';
    //     $history->previous = $lastDocument->observation_date;
    //     $history->current = $controlSampleData->observation_date;
    //     $history->comment = $request->date_comment;
    //     $history->user_id = Auth::user()->id;
    //     $history->user_name = Auth::user()->name;
    //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    //     $history->origin_state = $lastDocument->status;
    //     $history->change_to =   "Not Applicable";
    //     $history->change_from = $lastDocument->status;
    //     if (is_null($lastDocument->observation_date) || $lastDocument->observation_date === '') {
    //         $history->action_name = "New";
    //     } else {
    //         $history->action_name = "Update";
    //     }
     
    //     $history->save();
    // }


    // if ($lastDocument->destroyed_by != $controlSampleData->destroyed_by || !empty($request->destroyed_by_comment)) {

    //     $history = new auditTrailSampleControl();
    //     $history->control_samples_id = $id;
    //      $history->activity_type = 'Destroyed By';
    //     $history->previous = $lastDocument->destroyed_by;
    //     $history->current = $controlSampleData->destroyed_by;
    //     $history->comment = $request->date_comment;
    //     $history->user_id = Auth::user()->id;
    //     $history->user_name = Auth::user()->name;
    //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    //     $history->origin_state = $lastDocument->status;
    //     $history->change_to =   "Not Applicable";
    //     $history->change_from = $lastDocument->status;
    //     if (is_null($lastDocument->destroyed_by) || $lastDocument->destroyed_by === '') {
    //         $history->action_name = "New";
    //     } else {
    //         $history->action_name = "Update";
    //     }
     
    //     $history->save();
    // }


    // List of fields to track for changes
$fieldsToTrack = [
    'product_name', 'product_code', 'sample_type', 'market', 'ar_no', 
    'batch_number', 'manufacturing_date', 'expiry_date', 'quantity', 
    'uom', 'visual_inspection_scheduled_on', 'schedule_date', 'quantity_withdrawn', 
    'reason_for_withdrawal', 'current_quantity', 'storage_location', 'storage_condition', 
    'inspection_date', 'inspection_detail', 'inspection_done_by', 'destruction_due_on', 
    'destruction_date', 'destroyed_by', 'neutralizing_agent', 'instruction_for_destruction', 
    'remarks'
];

// Loop through all fields to log changes
foreach ($fieldsToTrack as $field ) {
    if (!empty($lastDocument->$field != $controlSampleData->field || !empty($request->NA))) {
        $history = new auditTrailSampleControl();
        $history->control_samples_id = $controlSampleData->id;
        $history->activity_type = ucfirst(str_replace('_', ' ', $field)); // Format field name
        $history->previous = "Null"; // Set as "Null" initially (can be updated to previous value if editing)
        $history->current = $controlSampleData->$field;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $controlSampleData->status;
        $history->change_to = "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';

        $history->save();
    }
}


    if ($lastDocument->Implementor_Attachment != $controlSampleData->Implementor_Attachment || !empty ($request->comment)) {

        $history = new auditTrailSampleControl;
        $history->control_samples_id = $id;
        $history->activity_type = 'Supportive Attachment';
        $history->previous = $lastDocument->Implementor_Attachment;
        $history->current = $controlSampleData->Implementor_Attachment;
        $history->comment = $controlSampleData->submit_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to =   "Not Applicable";
        $history->change_from = $lastDocument->status;

        if (is_null($lastDocument->Implementor_Attachment) || $lastDocument->Implementor_Attachment === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }
        $history->save();
    }
        toastr()->success("Record is Update Successfully");
        return back();

    }

    public function ControlSampleStateChange(Request $request, $id)
        {
            if ($request->username == Auth::user()->Username && Hash::check($request->password, Auth::user()->password)) {
                $controlSample = ControlSample::find($id);
                $lastDocument =  ControlSample::find($id);

                if ($controlSample->stage == 1) {
                    $controlSample->stage = "2";
                    $controlSample->status = 'Pending Inspection of Control Sample';
                    $controlSample->submit_by = Auth::user()->name;
                    $controlSample->submit_on = Carbon::now()->format('d-M-Y');
                    $controlSample->submit_comment = $request->comment;  
               
    
                    // $history = new controlSampleAuditTrail();
                    // $history->controlSampleDetails_id = $id;
                    // $history->activity_type = 'Submit';
                    // $history->previous = "Opened";
                    // $history->current = $controlSample->Initiate_controlSample_by;
                    // $history->comment = $request->comment;
                    // $history->action = 'Submit';
                    // $history->user_id = Auth::user()->id;
                    // $history->user_name = Auth::user()->name;
                    // $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    // $history->origin_state = $lastDocument->status;
                    // $history->change_to = "open";
                    // $history->change_from = $lastDocument->status;
                    // $history->action_name = 'Update';
                    // $history->stage = 'controlSample In Progress';
    
                    // if (is_null($lastDocument->Initiate_controlSample_by) || $lastDocument->Initiate_controlSample_by === '') {
                    //     $history->previous = "";
                    // } else {
                    //     $history->previous = $lastDocument->Initiate_controlSample_by . ' , ' . $lastDocument->Initiate_controlSample_on;
                    // }
                    
                    // $history->current = $controlSample->Initiate_controlSample_by . ' , ' . $controlSample->Initiate_controlSample_on;
    
                  
                    // if (is_null($lastDocument->Initiate_controlSample_by) || $lastDocument->Initiate_controlSample_by === '') {
                    //     $history->action_name = 'New';
                    // } else {
                    //     $history->action_name = 'Update';
                    // }
    
                    // $history->save();
                      
                    $controlSample->update();
                    toastr()->success('Document Sent');
                    return back();
                }
    

                if ($controlSample->stage == 2) {
                    $controlSample->stage = "3";
                    $controlSample->status = 'Pending Distraction';
                    $controlSample->control_sample_insp_by = Auth::user()->name;
                    $controlSample->control_sample_insp_on = Carbon::now()->format('d-M-Y');
                    $controlSample->control_sample_ins_comment = $request->comment;  
               
                    // $controlSample->Out_of_Limits_by  = Auth::user()->name;
                    // // $controlSample->Out_of_Limits_on = Carbon::now()->format('d-M-Y');
                    // $controlSample->Out_of_Limits_on =  Carbon::now('Asia/Kolkata')->format('d-M-Y H:i:s T') . 
                    // ' | GMT: ' . Carbon::now('UTC')->format('d-M-Y H:i:s T');                   
                    //  $controlSample->Out_of_Limits_comment = $request->comment;

                    // $history = new CalibrationAuditTrail();
                    // $history->calibrationDetails_id = $id;
                    // $history->activity_type = 'Distraction Complete by, Distraction Complete On';
                    // $history->previous ="Opened";
                    // $history->current = $controlSample->Out_of_Limits_by;
                    // $history->comment = $request->comment;
                    // $history->action = 'Out of Limits';
                    // $history->user_id = Auth::user()->id;
                    // $history->user_name = Auth::user()->name;
                    // $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    // $history->origin_state = $lastDocument->status;
                    // $history->change_to =   "Pending Inspection of Control Sample";
                    // $history->change_from = $lastDocument->status;
                    // $history->action_name = 'Update';
                    
                    // $history->stage = 'Pending Distraction';
                    // if (is_null($lastDocument->Out_of_Limits_by) || $lastDocument->Out_of_Limits_on === '') {
                    //     $history->previous = "";
                    // } else {
                    //     $history->previous = $lastDocument->Out_of_Limits_by . ' , ' . $lastDocument->Out_of_Limits_on;
                    // }
                    // $history->current = $controlSample->submit_by . ' , ' . $controlSample->Out_of_Limits_on;
                    // if (is_null($lastDocument->Out_of_Limits_by) || $lastDocument->Out_of_Limits_by === '') {
                    //     $history->action_name = 'New';
                    // } else {
                    //     $history->action_name = 'Update';
                    // }
                    // $history->save();

                    $controlSample->update();
                    toastr()->success('Document Sent');
                    return back();
                }


                if ($controlSample->stage == 3) {
                    $controlSample->stage = "4";
                    $controlSample->status = 'Closed - Done';
                    $controlSample->distraction_complete_by = Auth::user()->name;
                    $controlSample->distraction_complete_on = Carbon::now()->format('d-M-Y');
                    $controlSample->distraction_complete_comment = $request->comment;  
               
                    // $controlSample->Complete_Actions_by = Auth::user()->name;
                    // // $calibration->Complete_Actions_on = Carbon::now()->format('d-M-Y');
                    
                    // $controlSample->Complete_Actions_on =  Carbon::now('Asia/Kolkata')->format('d-M-Y H:i:s T') . 
                    //                     ' | GMT: ' . Carbon::now('UTC')->format('d-M-Y H:i:s T');
                    // $controlSample->Complete_Actions_comment = $request->comment;

                    
                    // $history = new CalibrationAuditTrail();
                    // $history->calibrationDetails_id = $id;
                    // $history->activity_type = 'Distraction Complete By';
                    // $history->previous ="Opened";
                    // $history->current = $controlSample->Out_of_Limits_by;
                    // $history->comment = $request->comment;
                    // $history->action = 'Complete Actions';
                    // $history->user_id = Auth::user()->id;
                    // $history->user_name = Auth::user()->name;
                    // $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    // $history->origin_state = $lastDocument->status;
                    // $history->change_to =   "Calibration In Progress";
                    // $history->change_from = $lastDocument->status;
                    // $history->action_name = 'Update';
                    
                    // $history->stage = 'Pending Distraction';
                    // if (is_null($lastDocument->Complete_Actions_by) || $lastDocument->Complete_Actions_on === '') {
                    //     $history->previous = "";
                    // } else {
                    //     $history->previous = $lastDocument->Complete_Actions_by . ' , ' . $lastDocument->Complete_Actions_on;
                    // }
                    // $history->current = $controlSample->submit_by . ' , ' . $controlSample->Complete_Actions_on;
                    // if (is_null($lastDocument->Complete_Actions_by) || $lastDocument->Complete_Actions_by === '') {
                    //     $history->action_name = 'New';
                    // } else {
                    //     $history->action_name = 'Update';
                    // }
                    // $history->save();

                    $controlSample->update();
                    toastr()->success('Document Sent');
                    return back();
                }

                
            }else {
                toastr()->error('E-signature Not match');
                return back();
            }
        }


        public function RejectControlSample(Request $request, $id)
    {
        if ($request->username == Auth::user()->Username && Hash::check($request->password, Auth::user()->password)) {
            $controlSample = ControlSample::find($id);
            $lastDocument =  ControlSample::find($id);

            if ($controlSample->stage == 4) {
                $controlSample->stage = "3";
                $controlSample->status = "Closed - Done";

                // $controlSample->Re_Qualification_by = Auth::user()->name;
                // $controlSample->Re_Qualification_on = Carbon::now()->format('d-M-Y');
                // $controlSample->Re_Qualification_comment = $request->comment;

                $controlSample->update();


                toastr()->success('Document Sent');
                return back();
            }
            
            if ($controlSample->stage == 3) {
                $controlSample->stage = "2";
                $controlSample->status = "Pending Inspection of Control Sample  ";

                $controlSample->more_info_second_by = Auth::user()->name;
                $controlSample->more_info_second_on = Carbon::now()->format('d-M-Y');
                $controlSample->more_info_second_comment = $request->comment;

                $controlSample->update();


                toastr()->success('Document Sent');
                return back();
            }


            if ($controlSample->stage == 2) {
                $controlSample->stage = "1";
                $controlSample->status = "Opened";

                $controlSample->more_info_by = Auth::user()->name;
                $controlSample->more_info_on = Carbon::now()->format('d-M-Y');
                $controlSample->more_info_comment = $request->comment;

                $controlSample->update();


                toastr()->success('Document Sent');
                return back();
            }

        }else {
            toastr()->error('E-signature Not match');
            return back();
        }
    }



        public function singleReport($id)
        {

            $data = ControlSample::find($id);
          //  dd($data);
            if (!empty($data)) {
                $data->originator = User::where('id', $data->initiator_id)->value('name');
                $gridData = ControlSampleGrid::where(['control_samples_id' => $id])->first();
                $controlsampleData = $gridData ? (is_array($gridData->data) ? $gridData->data : json_decode($gridData->data, true)) : [];
                $pdf = App::make('dompdf.wrapper');
                $time = Carbon::now();
                $pdf = PDF::loadview('frontend.control-sample.singleReport', compact('data','controlsampleData','gridData'))
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
                return $pdf->stream('External-Audit' . $id . '.pdf');
            }

        }



        public static function auditReport($id)
    {  $doc = ControlSample::find($id);
        if (!empty($doc)) {
            $doc->originator = User::where('id', $doc->initiator_id)->value('name');
           $data = auditTrailSampleControl::where('audit_trail_sample_controls', $id)->orderByDesc('id')->get();
          //  $data= ControlSample::all();
           
            $pdf = App::make('dompdf.wrapper');
            $time = Carbon::now();
            $pdf = PDF::loadview('frontend.control-sample.auditReport', compact('data', 'doc',))
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
            return $pdf->stream('External-Audit' . $id . '.pdf');
        }
    }


    
    
    Public function activitylogPrint($id)
    {
        $data = ControlSample::find($id);
       // dd($data);
        if (!empty($data)) {
            $data->originator = User::where('id', $data->initiator_id)->value('name');
            $pdf = App::make('dompdf.wrapper');
            $time = Carbon::now();
            $pdf = PDF::loadview('frontend.control-sample.Activitylogprint', compact('data'))
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
            return $pdf->stream('External-Audit' . $id . '.pdf');
        }
    }

    public function exportCsv(Request $request)
    {
     
        $query = ControlSample::query();

        // Handle department filter when multiple departments are selected
        if (!empty($request->department_controlsample)) {
            $query->whereIn('Initiator_Group', $request->department_controlsample);  // Use whereIn for multiple selections
        }

        if ($request->division_id_controlsample) {
            $query->where('division_id', $request->division_id_controlsample);
        }

        if ($request->initiator_id_controlsample) {
            $query->where('initiator_id', $request->initiator_id_controlsample);
        }

        if ($request->date_fromcontrolsample) {
            $dateFrom = Carbon::parse($request->date_fromcontrolsample)->startOfDay();
            $query->whereDate('intiation_date', '>=', $dateFrom);
        }

        if ($request->date_tocontrolsample) {
            $dateTo = Carbon::parse($request->date_tocontrolsample)->endOfDay();
            $query->whereDate('intiation_date', '<=', $dateTo);
        }

        
        if ($request->sort_column && $request->sort_order) {
            $query->orderBy($request->sort_column, $request->sort_order);
        }

        $controlsample = $query->get();

    
        $fileName = 'control_sample_log.csv';
        $headers = [
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename=\"$fileName\"",
        ];
    
        $columns = [
            'Sr. No.', 'Initiation Date', 'Record No',
            'Division', 'Department Name', 'Short Description.', 'Due Date',
            'Initiator', 'Status'
        ];
    
        $callback = function () use ($controlsample, $columns) {
            $file = fopen('php://output', 'w');
    
            fputcsv($file, $columns);
    
            if ($controlsample->isEmpty()) {
                fputcsv($file, ['No records found']);
            } else {
                foreach ($controlsample as $index => $row) {
                    $data = [
                        $index + 1, 
                        $row->intiation_date ?? 'Not Applicable', 
                        $row->division ? $row->division->name . '/CS/' . date('Y') . '/' . str_pad($row->record, 4, '0', STR_PAD_LEFT) : 'Not Applicable',
                        $row->division ? $row->division->name : 'Not Applicable', 
                        $row->Initiator_Group ?? 'Not Applicable', 
                        $row->short_desc ?? 'Not Applicable', 
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
    
    


    public function exportExcel(Request $request)
    {
       
        $query = ControlSample::query();

        // Handle department filter when multiple departments are selected
        if (!empty($request->department_controlsample)) {
            $query->whereIn('Initiator_Group', $request->department_controlsample);  // Use whereIn for multiple selections
        }

        if ($request->division_id_controlsample) {
            $query->where('division_id', $request->division_id_controlsample);
        }

        if ($request->initiator_id_controlsample) {
            $query->where('initiator_id', $request->initiator_id_controlsample);
        }

        if ($request->date_fromcontrolsample) {
            $dateFrom = Carbon::parse($request->date_fromcontrolsample)->startOfDay();
            $query->whereDate('intiation_date', '>=', $dateFrom);
        }

        if ($request->date_tocontrolsample) {
            $dateTo = Carbon::parse($request->date_tocontrolsample)->endOfDay();
            $query->whereDate('intiation_date', '<=', $dateTo);
        }

        
        if ($request->sort_column && $request->sort_order) {
            $query->orderBy($request->sort_column, $request->sort_order);
        }

        $controlsample = $query->get();

        $fileName = "control_sample.xls";
    
        $headers = [
            "Content-Type" => "application/vnd.ms-excel",
            "Content-Disposition" => "attachment; filename=\"$fileName\"",
        ];
    
        $columns = [
            'Sr. No.', 'Initiation Date', 'Record No',
            'Division', 'Department Name', 'Short Description.', 'Due Date',
            'Initiator', 'Status'
        ];
    
        $callback = function () use ($controlsample, $columns) {
            echo '<table border="1">';
    
            echo '<tr style="font-weight: bold; background-color: #1F4E79; color: #FFFFFF;">';
            foreach ($columns as $column) {
                echo "<th style='padding: 5px;'>" . htmlspecialchars($column) . "</th>";
            }
            echo '</tr>';
    
            if ($controlsample->isEmpty()) {
                echo '<tr>';
                echo "<td colspan='" . count($columns) . "' style='text-align: center;'>No records found</td>";
                echo '</tr>';
            } else {
                foreach ($controlsample as $index => $row) {
                    echo '<tr>';
                    echo "<td style='padding: 5px;'>" . ($index + 1) . "</td>";
                    echo "<td style='padding: 5px;'>" . htmlspecialchars($row->intiation_date ?? 'Not Applicable') . "</td>";
                    echo "<td style='padding: 5px;'>" . htmlspecialchars($row->division ? $row->division->name . '/CS/' . date('Y') . '/' . str_pad($row->record, 4, '0', STR_PAD_LEFT) : 'Not Applicable') . "</td>";
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
