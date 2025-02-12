<?php


namespace App\Http\Controllers;
use App\Models\RecordNumber;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ActionItem;
use App\Models\CallibrationDetails;
use App\Models\CalibrationManagementGrid;
use App\Models\Capa;
use App\Models\EHSEventHistory;
use App\Models\User;
use App\Models\SanctionAuditTrail;
use App\Models\RoleGroup;
use App\Models\CapaGrid;
use App\Models\Extension;
use App\Models\extension_new;

use App\Models\CC;
use App\Models\Division;
use App\Models\InternalAuditGrid;
use Illuminate\Support\Facades\Http;
use PDF;
use Helpers;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\OpenStage;
use App\Models\QMSDivision;
use App\Models\CalibrationAuditTrail; 


class CallibrationDetailsController extends Controller
{
    public function index()
    {
        $record_number = ((RecordNumber::first()->value('counter')) + 1);
        $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
        $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $due_date = $formattedDate->format('Y-m-d');
        $parent_id= null;
       return view('frontend.Callibration-Details.Callibration_Details_Create', compact('record_number','parent_id') );
        
    }

    public function CalibrationDetails_store(Request $request)
    {
        
        if (!$request->short_description) {
            toastr()->error("Short description is required");
            return redirect()->back()->withInput();
        }
        $calibration = new CallibrationDetails();
        $calibration->form_type = "Calibration Details";
        $calibration->record = ((RecordNumber::first()->value('counter')) + 1);
        $calibration->initiator_id = Auth::user()->id;
        $calibration->division_id = $request->division_id;
        $calibration->division_code = $request->division_code;
        $calibration->intiation_date = $request->intiation_date;
        $calibration->form_type = $request->form_type;
        $calibration->record_number = $request->record_number;
        $calibration->parent_id = $request->parent_id;
        $calibration->parent_type = $request->parent_type;
        $calibration->assign_to = $request->assign_to;
        $calibration->due_date = $request->due_date;
        $calibration->short_description = $request->short_description;
    

        $calibration->calibration_standard_preference = $request->calibration_standard_preference;
        $calibration->callibration_frequency = $request->callibration_frequency;
        $calibration->last_calibration_date = $request->last_calibration_date;
        $calibration->next_calibration_date = $request->next_calibration_date;
        $calibration->calibration_due_reminder = $request->calibration_due_reminder;
        $calibration->calibration_method_procedure = $request->calibration_method_procedure;
        // $calibration->calibration_procedure_attach = $request->calibration_procedure_attach;
        $calibration->calibration_used = $request->calibration_used;
        $calibration->calibration_parameter = $request->calibration_parameter;
        $calibration->event_based_calibration = $request->event_based_calibration;
        $calibration->event_based_calibration_reason = $request->event_based_calibration_reason;
        $calibration->event_refernce_no = $request->event_refernce_no;
        $calibration->calibration_checklist = $request->calibration_checklist;
        $calibration->calibration_result = $request->calibration_result;
        $calibration->calibration_certificate_result = $request->calibration_certificate_result;
        // $calibration->calibration_certificate = $request->calibration_certificate;
        $calibration->calibrated_by = $request->calibrated_by;
        $calibration->calibration_due_alert = $request->calibration_due_alert;
        $calibration->calibration_cost = $request->calibration_cost;
        $calibration->calibration_comments = $request->calibration_comments;
        $calibration->calibration_comments = $request->calibration_comments;
        $calibration->Imp_review_comm = $request->Imp_review_comm;
        $calibration->qa_rev_comm = $request->qa_rev_comm;


        $calibration->status = 'Opened';
        $calibration->stage = 1;


        if (!empty($request->calibration_procedure_attach)) {
            $files = [];
            if ($request->hasfile('calibration_procedure_attach')) {
                foreach ($request->file('calibration_procedure_attach') as $file) {
                    $name = $request->name . '-calibration_procedure_attach' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $calibration->calibration_procedure_attach = json_encode($files);
        }

    
        if (!empty($request->calibration_certificate)) {
            $files = [];
            if ($request->hasfile('calibration_certificate')) {
                foreach ($request->file('calibration_certificate') as $file) {
                    $name = $request->name . '-calibration_certificate' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $calibration->calibration_certificate = json_encode($files);
        }    

        if (!empty($request->Implementor_Attachment)) {
            $files = [];
            if ($request->hasfile('Implementor_Attachment')) {
                foreach ($request->file('Implementor_Attachment') as $file) {
                    $name = $request->name . '-Implementor_Attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $calibration->Implementor_Attachment = json_encode($files);
        }   

        if (!empty($request->qa_rev_attachment)) {
            $files = [];
            if ($request->hasfile('qa_rev_attachment')) {
                foreach ($request->file('qa_rev_attachment') as $file) {
                    $name = $request->name . '-qa_rev_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $calibration->qa_rev_attachment = json_encode($files);
        }  

        $calibration->save();

        $callibration_details_id = $calibration->id;

        // $callibrationGrid = CalibrationManagementGrid::where(['callibration_details_id' => $callibration_details_id, 'identifier' => 'cmchecklistGrid'])->firstOrNew();
        // $callibrationGrid->callibration_details_id = $callibration_details_id;
        // $callibrationGrid->identifier = 'cmchecklistGrid';
        // $callibrationGrid->data = $request->cmchecklist;
        // // dd($callibrationGrid);
    // $callibrationGrid->save();

        $record = RecordNumber::first();
        $record->counter = ((RecordNumber::first()->value('counter')) + 1);
        $record->update();

        //-------------------------------Audit Trial------------------------------------------------

        if(!empty($request->record_number))
        {
            $history = new CalibrationAuditTrail();
            $history->calibrationDetails_id = $calibration->id;
            $history->activity_type = 'Record Number';
            $history->previous = "Null";
            $history->current =$request->record_number;
            $history->comment = "Null";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $calibration->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
         
            $history->save();
        }

       
        {
            $history = new CalibrationAuditTrail();
            $history->calibrationDetails_id = $calibration->id;
            $history->activity_type = 'Site/Location Code';
            $history->previous = "Null";
            $history->current = Helpers::getDivisionName($calibration->division_id);
            $history->comment = "Null";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $calibration->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
         
            $history->save();
        }

        
        
        {
            $history = new CalibrationAuditTrail();
            $history->calibrationDetails_id = $calibration->id;
            $history->activity_type = 'initiator';
            $history->previous = "Null";
            $history->current =Helpers::getInitiatorName($calibration->initiator_id);
            $history->comment = "Null";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $calibration->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
         
            $history->save();
        }


        if(!empty($request->due_date))
        {
            $history = new CalibrationAuditTrail();
            $history->calibrationDetails_id = $calibration->id;
            $history->activity_type = 'Due Date';
            $history->previous = "Null";
            $history->current =Helpers::getdateFormat($request->due_date);
            $history->comment = "Null";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $calibration->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
         
            $history->save();
        }


        if(!empty($request->short_description))
        {
            $history = new CalibrationAuditTrail();
            $history->calibrationDetails_id = $calibration->id;
            $history->activity_type = 'Short Description';
            $history->previous = "Null";
            $history->current =$request->short_description;
            $history->comment = "Null";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $calibration->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
         
            $history->save();
        }

        if(!empty($request->calibration_standard_preference))
        {
            $history = new CalibrationAuditTrail();
            $history->calibrationDetails_id = $calibration->id;
            $history->activity_type = 'Calibration Standard Reference';
            $history->previous = "Null";
            $history->current =$request->calibration_standard_preference;
            $history->comment = "Null";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $calibration->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
         
            $history->save();
        }
        
        if(!empty($request->callibration_frequency))
        {
            $history = new CalibrationAuditTrail();
            $history->calibrationDetails_id = $calibration->id;
            $history->activity_type = 'Calibration Frequency';
            $history->previous = "Null";
            $history->current =$request->callibration_frequency;
            $history->comment = "Null";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $calibration->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
         
            $history->save();
        }

        if(!empty($request->last_calibration_date))
        {
            $history = new CalibrationAuditTrail();
            $history->calibrationDetails_id = $calibration->id;
            $history->activity_type = 'Last Calibration Date';
            $history->previous = "Null";
            $history->current =Helpers::getdateFormat($request->last_calibration_date);
            $history->comment = "Null";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $calibration->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
         
            $history->save();
        }

    
        if (!empty($calibration->next_calibration_date)) {
            $history = new CalibrationAuditTrail();
            $history->calibrationDetails_id = $calibration->id;
            $history->activity_type = 'Next Calibration Date';
            $history->previous = "Null";
            $history->current = Helpers::getdateFormat($request->next_calibration_date);
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $calibration->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
            $history->save();
        }

        if(!empty($request->calibration_due_reminder))
        {
            $history = new CalibrationAuditTrail();
            $history->calibrationDetails_id = $calibration->id;
            $history->activity_type = 'Calibration Due Reminder';
            $history->previous = "Null";
            $history->current =$request->calibration_due_reminder;
            $history->comment = "Null";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $calibration->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
         
            $history->save();
        }


        if(!empty($request->calibration_method_procedure))
        {
            $history = new CalibrationAuditTrail();
            $history->calibrationDetails_id = $calibration->id;
            $history->activity_type = 'Calibration Method/Procedure';
            $history->previous = "Null";
            $history->current =$request->calibration_method_procedure;
            $history->comment = "Null";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $calibration->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
         
            $history->save();
        }

        

        if(!empty($calibration->calibration_procedure_attach))
        {
            $history = new CalibrationAuditTrail();
            $history->calibrationDetails_id = $calibration->id;
            $history->activity_type = 'Calibration Procedure Reference/Document';
            $history->previous = "Null";
            $history->current =$calibration->calibration_procedure_attach;
            $history->comment = "Null";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $calibration->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
         
            $history->save();
        }

        if(!empty($request->calibration_used))
        {
            $history = new CalibrationAuditTrail();
            $history->calibrationDetails_id = $calibration->id;
            $history->activity_type = 'Calibration Standards Used';
            $history->previous = "Null";
            $history->current =$request->calibration_used;
            $history->comment = "Null";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $calibration->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
         
            $history->save();
        }

       
        if(!empty($request->calibration_parameter))
        {
            $history = new CalibrationAuditTrail();
            $history->calibrationDetails_id = $calibration->id;
            $history->activity_type = 'Calibration Parameter';
            $history->previous = "Null";
            $history->current =$request->calibration_parameter;
            $history->comment = "Null";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $calibration->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
         
            $history->save();
        }

       
        if(!empty($request->event_based_calibration))
        {
            $history = new CalibrationAuditTrail();
            $history->calibrationDetails_id = $calibration->id;
            $history->activity_type = 'Unscheduled or Event Based Calibration';
            $history->previous = "Null";
            $history->current =$request->event_based_calibration;
            $history->comment = "Null";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $calibration->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
         
            $history->save();
        }
      
        if(!empty($request->event_based_calibration_reason))
        {
            $history = new CalibrationAuditTrail();
            $history->calibrationDetails_id = $calibration->id;
            $history->activity_type = 'Reason for Unscheduled or Event Based Calibration';
            $history->previous = "Null";
            $history->current =$request->event_based_calibration_reason;
            $history->comment = "Null";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $calibration->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
         
            $history->save();
        }

        
        if(!empty($request->event_refernce_no))
        {
            $history = new CalibrationAuditTrail();
            $history->calibrationDetails_id = $calibration->id;
            $history->activity_type = 'Event Refernce No';
            $history->previous = "Null";
            $history->current =$request->event_refernce_no;
            $history->comment = "Null";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $calibration->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
         
            $history->save();
        }


       
        if(!empty($request->calibration_checklist))
        {
            $history = new CalibrationAuditTrail();
            $history->calibrationDetails_id = $calibration->id;
            $history->activity_type = 'Calibration Checklist';
            $history->previous = "Null";
            $history->current =$request->calibration_checklist;
            $history->comment = "Null";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $calibration->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
         
            $history->save();
        }

        if(!empty($request->calibration_result))
        {
            $history = new CalibrationAuditTrail();
            $history->calibrationDetails_id = $calibration->id;
            $history->activity_type = 'Calibration Results';
            $history->previous = "Null";
            $history->current =$request->calibration_result;
            $history->comment = "Null";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $calibration->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
         
            $history->save();
        }

        
        if(!empty($request->calibration_certificate_result))
        {
            $history = new CalibrationAuditTrail();
            $history->calibrationDetails_id = $calibration->id;
            $history->activity_type = 'Calibration Certificate Number';
            $history->previous = "Null";
            $history->current =$request->calibration_certificate_result;
            $history->comment = "Null";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $calibration->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
         
            $history->save();
        }


        if(!empty($calibration->calibration_certificate))
        {
            $history = new CalibrationAuditTrail();
            $history->calibrationDetails_id = $calibration->id;
            $history->activity_type = 'Calibration Certificate Attachment';
            $history->previous = "Null";
            $history->current =$calibration->calibration_certificate;
            $history->comment = "Null";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $calibration->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
         
            $history->save();
        }
        

        if(!empty($request->calibrated_by))
        {
            $history = new CalibrationAuditTrail();
            $history->calibrationDetails_id = $calibration->id;
            $history->activity_type = 'calibrated By';
            $history->previous = "Null";
            $history->current =$request->calibrated_by;
            $history->comment = "Null";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $calibration->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
         
            $history->save();
        }


        if(!empty($request->calibration_due_alert))
        {
            $history = new CalibrationAuditTrail();
            $history->calibrationDetails_id = $calibration->id;
            $history->activity_type = 'Calibration Due Alert';
            $history->previous = "Null";
            $history->current =$request->calibration_due_alert;
            $history->comment = "Null";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $calibration->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
         
            $history->save();
        }

        if(!empty($request->calibration_cost))
        {
            $history = new CalibrationAuditTrail();
            $history->calibrationDetails_id = $calibration->id;
            $history->activity_type = 'Cost of Calibration';
            $history->previous = "Null";
            $history->current =$request->calibration_cost;
            $history->comment = "Null";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $calibration->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
         
            $history->save();
        }
       

        if (!empty($calibration->calibration_comments)) {
            $history = new CalibrationAuditTrail();
            $history->calibrationDetails_id = $calibration->id;
            $history->activity_type = 'Calibration Comments/Observations';
            $history->previous = "Null";
            $history->current = $calibration->calibration_comments;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $calibration->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
            $history->save();
        }
        if (!empty($calibration->Imp_review_comm)) {
            $history = new CalibrationAuditTrail();
            $history->calibrationDetails_id = $calibration->id;
            $history->activity_type = 'Implementor Review Comment';
            $history->previous = "Null";
            $history->current = $calibration->Imp_review_comm;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $calibration->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
            $history->save();
        }


        if(!empty($calibration->Implementor_Attachment))
        {
            $history = new CalibrationAuditTrail();
            $history->calibrationDetails_id = $calibration->id;
            $history->activity_type = 'Implementor Attachment';
            $history->previous = "Null";
            $history->current =$calibration->Implementor_Attachment;
            $history->comment = "Null";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $calibration->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
         
            $history->save();
        }

    
        if (!empty($calibration->qa_rev_comm)) {
            $history = new CalibrationAuditTrail();
            $history->calibrationDetails_id = $calibration->id;
            $history->activity_type = ' QA Rev  Comm';
            $history->previous = "Null";
            $history->current = $calibration->qa_rev_comm;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $calibration->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($request->qa_rev_attachment)) {
            $calibrationCertificate = $request->qa_rev_attachment;
        
            // Check if $calibrationCertificate is an array
            if (is_array($calibrationCertificate)) {
                // Convert the array to a string (comma-separated values)
                $calibrationCertificate = implode(', ', $calibrationCertificate);
            }
        
            // Create a new CalibrationAuditTrail entry
            $history = new CalibrationAuditTrail();
            $history->calibrationDetails_id = $calibration->id;
            $history->activity_type = 'Implementor Attachment';
            $history->previous = "Null"; // Replace with actual previous value if applicable
            $history->current = $calibrationCertificate;
            $history->comment = "Null"; // Replace with actual comment if applicable
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $calibration->status;
            $history->change_to = "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
        
            // Save the history entry
            $history->save();
        }
       
  

        toastr()->success("Record is Create Successfully");
        return redirect(url('rcms/qms-dashboard'));
    }

    public function show($id)
    {      
        
        $data = CallibrationDetails::find($id);
        $calibration  = CallibrationDetails::find($id);
        
        
        $record_number = ((RecordNumber::first()->value('counter')) + 1);
        $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
        $calibration->record = str_pad($calibration->record, 4, '0', STR_PAD_LEFT);
        $calibration->assign_to_name = User::where('id', $calibration->assign_id)->value('name');
        $calibration->initiator_name = User::where('id', $calibration->initiator_id)->value('name');
        $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $due_date = $formattedDate->format('Y-m-d');
        $CmCheckListGrid = CalibrationManagementGrid::where(['callibration_details_id' => $id, 'identifier' => 'cmchecklistGrid' ])->first();

    
        return view('frontend.Callibration-Details.Callibration_Details_View', compact('data', 'calibration', 'CmCheckListGrid', 'record_number',));
    }

    public function update(Request $request, $id)
    {

        $lastDocument = CallibrationDetails::find($id);
        $calibration = CallibrationDetails::find($id);

        $calibration->assign_to = $request->assign_to;
        // $calibration->due_date = $request->due_date;
        $calibration->short_description = $request->short_description;
        $calibration->calibration_standard_preference = $request->calibration_standard_preference;
        $calibration->callibration_frequency = $request->callibration_frequency;
        $calibration->last_calibration_date = $request->last_calibration_date;
        $calibration->next_calibration_date = $request->next_calibration_date;
        $calibration->calibration_due_reminder = $request->calibration_due_reminder;
        $calibration->calibration_method_procedure = $request->calibration_method_procedure;
        // $calibration->calibration_procedure_attach = $request->calibration_procedure_attach;
        $calibration->calibration_used = $request->calibration_used;
        $calibration->calibration_parameter = $request->calibration_parameter;
        $calibration->event_based_calibration = $request->event_based_calibration;
        $calibration->event_based_calibration_reason = $request->event_based_calibration_reason;
        $calibration->event_refernce_no = $request->event_refernce_no;
        $calibration->calibration_checklist = $request->calibration_checklist;
        $calibration->calibration_result = $request->calibration_result;
        $calibration->calibration_certificate_result = $request->calibration_certificate_result;
        // $calibration->calibration_certificate = $request->calibration_certificate;
        $calibration->calibrated_by = $request->calibrated_by;
        $calibration->calibration_due_alert = $request->calibration_due_alert;
        $calibration->calibration_cost = $request->calibration_cost;
        $calibration->calibration_comments = $request->calibration_comments;
        $calibration->Imp_review_comm = $request->Imp_review_comm;
        $calibration->qa_rev_comm = $request->qa_rev_comm;
        

        if (!empty($request->calibration_procedure_attach)) {
            $files = [];
            if ($request->hasfile('calibration_procedure_attach')) {
                foreach ($request->file('calibration_procedure_attach') as $file) {
                    $name = $request->name . '-calibration_procedure_attach' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $calibration->calibration_procedure_attach = json_encode($files);
        }
    
        if (!empty($request->calibration_certificate)) {
            $files = [];
            if ($request->hasfile('calibration_certificate')) {
                foreach ($request->file('calibration_certificate') as $file) {
                    $name = $request->name . '-calibration_certificate' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $calibration->calibration_certificate = json_encode($files);
        }

        if (!empty($request->Implementor_Attachment)) {
            $files = [];
            if ($request->hasfile('Implementor_Attachment')) {
                foreach ($request->file('Implementor_Attachment') as $file) {
                    $name = $request->name . '-Implementor_Attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $calibration->Implementor_Attachment = json_encode($files);
        }

        if (!empty($request->qa_rev_attachment)) {
            $files = [];
            if ($request->hasfile('qa_rev_attachment')) {
                foreach ($request->file('qa_rev_attachment') as $file) {
                    $name = $request->name . '-qa_rev_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $calibration->qa_rev_attachment = json_encode($files);
        }
        
       

        $calibration->update();
        $callibration_details_id = $calibration->id;

        $checklistGrid = CalibrationManagementGrid::where(['callibration_details_id' => $callibration_details_id, 'identifier' => 'cmchecklistGrid'])->firstOrNew();
        $checklistGrid->callibration_details_id = $callibration_details_id;
        $checklistGrid->identifier = 'cmchecklistGrid';
        $checklistGrid->data = $request->cmchecklist;
        $checklistGrid->save();

        //----------------------------------------------------------------------------------------

            if ($lastDocument->record_number != $lastDocument->record_number || !empty($request->assign_to_comment)) {
            $history = new CalibrationAuditTrail();
            $history->calibrationDetails_id = $lastDocument->id;
            $history->activity_type = 'Record Number';
            $history->previous = $lastDocument->record_number;
            $history->current = $lastDocument->record_number;
            $history->comment = $request->assign_to_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
    
            // Null or empty check
            if (is_null($lastDocument->record_number) || $lastDocument->record_number === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
    
            $history->save();
        }

        if ($lastDocument->division_code != $lastDocument->division_code || !empty($request->assign_to_comment)) {
            $history = new CalibrationAuditTrail();
            $history->calibrationDetails_id = $lastDocument->id;
            $history->activity_type = 'Site/Location Code';
            $history->previous = $lastDocument->division_code;
            $history->current = $lastDocument->division_code;
            $history->comment = $request->assign_to_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
    
            // Null or empty check
            if (is_null($lastDocument->division_code) || $lastDocument->division_code === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
    
            $history->save();
        }

        if ($lastDocument->initiator_id != $lastDocument->initiator_id || !empty($request->assign_to_comment)) {
            $history = new CalibrationAuditTrail();
            $history->calibrationDetails_id = $lastDocument->id;
            $history->activity_type = 'Initiator';
            $history->previous = $lastDocument->initiator_id;
            $history->current = $lastDocument->initiator_id;
            $history->comment = $request->assign_to_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
    
            // Null or empty check
            if (is_null($lastDocument->initiator_id) || $lastDocument->initiator_id === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
    
            $history->save();
        }
        
        if ($lastDocument->intiation_date != $lastDocument->intiation_date || !empty($request->assign_to_comment)) {
            $history = new CalibrationAuditTrail();
            $history->calibrationDetails_id = $lastDocument->id;
            $history->activity_type = 'Date Of Initiation';
            $history->previous = $lastDocument->intiation_date;
            $history->current = $lastDocument->intiation_date;
            $history->comment = $request->assign_to_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
    
            // Null or empty check
            if (is_null($lastDocument->intiation_date) || $lastDocument->intiation_date === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
    
            $history->save();
        }

       
        if ($lastDocument->assign_to != $lastDocument->assign_to || !empty($request->assign_to_comment)) {
            $history = new CalibrationAuditTrail();
            $history->calibrationDetails_id = $lastDocument->id;
            $history->activity_type = 'Assigned To';
            $history->previous = $lastDocument->assign_to;
            $history->current = $lastDocument->assign_to;
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
            }
    
            $history->save();
        }
        
        if ($lastDocument->due_date != $lastDocument->due_date || !empty($request->assign_to_comment)) {
            $history = new CalibrationAuditTrail();
            $history->calibrationDetails_id = $lastDocument->id;
            $history->activity_type = 'Due Date';
            $history->previous = $lastDocument->due_date;
            $history->current = $lastDocument->due_date;
            $history->comment = $request->assign_to_comment;
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
        

        if ($lastDocument->short_description != $calibration->short_description || !empty($request->short_description_comment)) {

            $existingHistory = CalibrationAuditTrail::where('calibrationDetails_id', $id)
                ->where('activity_type', 'Short Description')
                ->exists();

            $history = new CalibrationAuditTrail();
            $history->calibrationDetails_id = $id;
            $history->activity_type = 'Short Description';
            $history->previous = $lastDocument->short_description;
            $history->current = $calibration->short_description;
            $history->comment = $request->date_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = "Update";

            if ($existingHistory) {
                $history->action_name = "Update";
            } else {
                $history->action_name = "New";
            }

            $history->save();
        }
        
        if ($lastDocument->calibration_standard_preference != $calibration->calibration_standard_preference || !empty($request->calibration_standard_preference_comment)) {

            $existingHistory = CalibrationAuditTrail::where('calibrationDetails_id', $id)
                ->where('activity_type', 'Calibration Standard Reference')
                ->exists();

            $history = new CalibrationAuditTrail();
            $history->calibrationDetails_id = $id;
            $history->activity_type = 'Calibration Standard Reference';
            $history->previous = $lastDocument->calibration_standard_preference;
            $history->current = $calibration->calibration_standard_preference;
            $history->comment = $request->date_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = "Update";

            if ($existingHistory) {
                $history->action_name = "Update";
            } else {
                $history->action_name = "New";
            }

            $history->save();
        }
        if ($lastDocument->callibration_frequency != $calibration->callibration_frequency || !empty($request->callibration_frequency_comment)) {

            $existingHistory = CalibrationAuditTrail::where('calibrationDetails_id', $id)
                ->where('activity_type', 'Callibration Frequency')
                ->exists();

            $history = new CalibrationAuditTrail();
            $history->calibrationDetails_id = $id;
            $history->activity_type = 'Calibration Frequency';
            $history->previous = $lastDocument->callibration_frequency;
            $history->current = $calibration->callibration_frequency;
            $history->comment = $request->date_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = "Update";

            if ($existingHistory) {
                $history->action_name = "Update";
            } else {
                $history->action_name = "New";
            }

            $history->save();
        }

        

        if ($lastDocument->last_calibration_date != $calibration->last_calibration_date || !empty($request->last_calibration_date_comment)) {

            $existingHistory = CalibrationAuditTrail::where('calibrationDetails_id', $id)
                ->where('activity_type', 'Callibration Frequency')
                ->exists();

            $history = new CalibrationAuditTrail();
            $history->calibrationDetails_id = $id;
            $history->activity_type = 'Callibration Frequency';
            $history->previous = $lastDocument->last_calibration_date;
            $history->current = $calibration->last_calibration_date;
            $history->comment = $request->date_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = "Update";

            if ($existingHistory) {
                $history->action_name = "Update";
            } else {
                $history->action_name = "New";
            }

            $history->save();
        }


        if ($lastDocument->last_calibration_date != $calibration->last_calibration_date || !empty($request->last_calibration_date_comment)) {

            $existingHistory = CalibrationAuditTrail::where('calibrationDetails_id', $id)
                ->where('activity_type', 'last Calibration Date')
                ->exists();

            $history = new CalibrationAuditTrail();
            $history->calibrationDetails_id = $id;
            $history->activity_type = 'last_calibration_date';
            $history->previous = $lastDocument->last_calibration_date;
            $history->current = Helpers::getdateFormat($calibration->last_calibration_date);
            $history->comment = $request->date_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = "Update";

            if ($existingHistory) {
                $history->action_name = "Update";
            } else {
                $history->action_name = "New";
            }

            $history->save();
        }

      
        if ($lastDocument->next_calibration_date != $calibration->next_calibration_date || !empty($request->next_calibration_date_comment)) {

            $existingHistory = CalibrationAuditTrail::where('calibrationDetails_id', $id)
                ->where('activity_type', 'Next Calibration Date')
                ->exists();

            $history = new CalibrationAuditTrail();
            $history->calibrationDetails_id = $id;
            $history->activity_type = 'Next Calibration Date';
            $history->previous = $lastDocument->next_calibration_date;
            $history->current = Helpers::getdateFormat($calibration->next_calibration_date);
            $history->comment = $request->date_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = "Update";

            if ($existingHistory) {
                $history->action_name = "Update";
            } else {
                $history->action_name = "New";
            }

            $history->save();
        }

        if ($lastDocument->calibration_method_procedure != $calibration->calibration_method_procedure || !empty($request->calibration_method_procedure_comment)) {

            $existingHistory = CalibrationAuditTrail::where('calibrationDetails_id', $id)
                ->where('activity_type', 'Calibration Method Procedure')
                ->exists();

            $history = new CalibrationAuditTrail();
            $history->calibrationDetails_id = $id;
            $history->activity_type = 'Calibration Method Procedure';
            $history->previous = $lastDocument->calibration_method_procedure;
            $history->current = $calibration->calibration_method_procedure;
            $history->comment = $request->date_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = "Update";

            if ($existingHistory) {
                $history->action_name = "Update";
            } else {
                $history->action_name = "New";
            }

            $history->save();
        }

        
        if ($lastDocument->calibration_due_reminder != $calibration->calibration_due_reminder || !empty($request->calibration_due_reminder_comment)) {

            $existingHistory = CalibrationAuditTrail::where('calibrationDetails_id', $id)
                ->where('activity_type', 'Calibration Due Reminder')
                ->exists();

            $history = new CalibrationAuditTrail();
            $history->calibrationDetails_id = $id;
            $history->activity_type = 'Calibration due Reminder';
            $history->previous = $lastDocument->calibration_due_reminder;
            $history->current = $calibration->calibration_due_reminder;
            $history->comment = $request->date_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = "Update";

            if ($existingHistory) {
                $history->action_name = "Update";
            } else {
                $history->action_name = "New";
            }

            $history->save();
        }

        if ($lastDocument->calibration_procedure_attach != $calibration->calibration_procedure_attach || !empty($request->calibration_procedure_attach_comment)) {

            $existingHistory = CalibrationAuditTrail::where('calibrationDetails_id', $id)
                ->where('activity_type', 'Calibration Procedure Reference/Document')
                ->exists();

            $history = new CalibrationAuditTrail();
            $history->calibrationDetails_id = $id;
            $history->activity_type = 'Calibration Procedure Reference/Document';
            $history->previous = $lastDocument->calibration_procedure_attach;
            $history->current = $calibration->calibration_procedure_attach;
            $history->comment = $request->date_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = "Update";

            if ($existingHistory) {
                $history->action_name = "Update";
            } else {
                $history->action_name = "New";
            }

            $history->save();
        }

    
        if ($lastDocument->calibration_used != $calibration->calibration_used || !empty($request->calibration_used_comment)) {

            $existingHistory = CalibrationAuditTrail::where('calibrationDetails_id', $id)
                ->where('activity_type', 'Calibration Standards Used')
                ->exists();

            $history = new CalibrationAuditTrail();
            $history->calibrationDetails_id = $id;
            $history->activity_type = 'Calibration Standards Used';
            $history->previous = $lastDocument->calibration_used;
            $history->current = $calibration->calibration_used;
            $history->comment = $request->date_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = "Update";

            if ($existingHistory) {
                $history->action_name = "Update";
            } else {
                $history->action_name = "New";
            }

            $history->save();
        }

        
        if ($lastDocument->calibration_parameter != $calibration->calibration_parameter || !empty($request->calibration_parameter_comment)) {

            $existingHistory = CalibrationAuditTrail::where('calibrationDetails_id', $id)
                ->where('activity_type', 'Calibration Parameter')
                ->exists();

            $history = new CalibrationAuditTrail();
            $history->calibrationDetails_id = $id;
            $history->activity_type = 'Calibration Parameter';
            $history->previous = $lastDocument->calibration_parameter;
            $history->current = $calibration->calibration_parameter;
            $history->comment = $request->date_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = "Update";

            if ($existingHistory) {
                $history->action_name = "Update";
            } else {
                $history->action_name = "New";
            }

            $history->save();
        }

        
        if ($lastDocument->event_based_calibration != $calibration->event_based_calibration || !empty($request->calibration_parameter_comment)) {

            $existingHistory = CalibrationAuditTrail::where('calibrationDetails_id', $id)
                ->where('activity_type', 'Unscheduled or Event Based Calibration')
                ->exists();

            $history = new CalibrationAuditTrail();
            $history->calibrationDetails_id = $id;
            $history->activity_type = 'Unscheduled or Event Based Calibration';
            $history->previous = $lastDocument->event_based_calibration;
            $history->current = $calibration->event_based_calibration;
            $history->comment = $request->date_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = "Update";

            if ($existingHistory) {
                $history->action_name = "Update";
            } else {
                $history->action_name = "New";
            }

            $history->save();
        }
       
        if ($lastDocument->event_refernce_no != $calibration->event_refernce_no || !empty($request->calibration_parameter_comment)) {

            $existingHistory = CalibrationAuditTrail::where('calibrationDetails_id', $id)
                ->where('activity_type', 'Event Refernce No')
                ->exists();

            $history = new CalibrationAuditTrail();
            $history->calibrationDetails_id = $id;
            $history->activity_type = 'Event Refernce No';
            $history->previous = $lastDocument->event_refernce_no;
            $history->current = $calibration->event_refernce_no;
            $history->comment = $request->date_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = "Update";

            if ($existingHistory) {
                $history->action_name = "Update";
            } else {
                $history->action_name = "New";
            }

            $history->save();
        }


        if ($lastDocument->calibration_checklist != $calibration->calibration_checklist || !empty($request->calibration_parameter_comment)) {

            $existingHistory = CalibrationAuditTrail::where('calibrationDetails_id', $id)
                ->where('activity_type', 'Calibration Checklist')
                ->exists();

            $history = new CalibrationAuditTrail();
            $history->calibrationDetails_id = $id;
            $history->activity_type = 'Calibration Checklist';
            $history->previous = $lastDocument->calibration_checklist;
            $history->current = $calibration->calibration_checklist;
            $history->comment = $request->date_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = "Update";

            if ($existingHistory) {
                $history->action_name = "Update";
            } else {
                $history->action_name = "New";
            }

            $history->save();
        }
       
      
        if ($lastDocument->calibration_result != $calibration->calibration_result || !empty($request->calibration_parameter_comment)) {

            $existingHistory = CalibrationAuditTrail::where('calibrationDetails_id', $id)
                ->where('activity_type', 'Calibration Results')
                ->exists();

            $history = new CalibrationAuditTrail();
            $history->calibrationDetails_id = $id;
            $history->activity_type = 'Calibration Results';
            $history->previous = $lastDocument->calibration_result;
            $history->current = $calibration->calibration_result;
            $history->comment = $request->date_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = "Update";

            if ($existingHistory) {
                $history->action_name = "Update";
            } else {
                $history->action_name = "New";
            }

            $history->save();
        }

      
        if ($lastDocument->calibration_certificate_result != $calibration->calibration_certificate_result || !empty($request->calibration_parameter_comment)) {

            $existingHistory = CalibrationAuditTrail::where('calibrationDetails_id', $id)
                ->where('activity_type', 'Calibration Certificate Number')
                ->exists();

            $history = new CalibrationAuditTrail();
            $history->calibrationDetails_id = $id;
            $history->activity_type = 'Calibration Certificate Number';
            $history->previous = $lastDocument->calibration_certificate_result;
            $history->current = $calibration->calibration_certificate_result;
            $history->comment = $request->date_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = "Update";

            if ($existingHistory) {
                $history->action_name = "Update";
            } else {
                $history->action_name = "New";
            }

            $history->save();
        }

        if ($lastDocument->calibration_certificate != $calibration->calibration_certificate || !empty($request->calibration_parameter_comment)) {

            $existingHistory = CalibrationAuditTrail::where('calibrationDetails_id', $id)
                ->where('activity_type', 'Calibration Certificate')
                ->exists();

            $history = new CalibrationAuditTrail();
            $history->calibrationDetails_id = $id;
            $history->activity_type = 'Calibration Certificate Attachment';
            $history->previous = $lastDocument->calibration_certificate;
            $history->current = $calibration->calibration_certificate;
            $history->comment = $request->date_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = "Update";

            if ($existingHistory) {
                $history->action_name = "Update";
            } else {
                $history->action_name = "New";
            }

            $history->save();
        }

        
        if ($lastDocument->calibrated_by != $calibration->calibrated_by || !empty($request->calibration_parameter_comment)) {

            $existingHistory = CalibrationAuditTrail::where('calibrationDetails_id', $id)
                ->where('activity_type', 'Calibrated By')
                ->exists();

            $history = new CalibrationAuditTrail();
            $history->calibrationDetails_id = $id;
            $history->activity_type = 'Calibrated By';
            $history->previous = $lastDocument->calibrated_by;
            $history->current = $calibration->calibrated_by;
            $history->comment = $request->date_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = "Update";

            if ($existingHistory) {
                $history->action_name = "Update";
            } else {
                $history->action_name = "New";
            }

            $history->save();
        }

        
      
        if ($lastDocument->calibrated_by != $calibration->calibrated_by || !empty($request->calibration_parameter_comment)) {

            $existingHistory = CalibrationAuditTrail::where('calibrationDetails_id', $id)
                ->where('activity_type', 'Calibrated By')
                ->exists();

            $history = new CalibrationAuditTrail();
            $history->calibrationDetails_id = $id;
            $history->activity_type = 'Calibrated By';
            $history->previous = $lastDocument->calibrated_by;
            $history->current = $calibration->calibrated_by;
            $history->comment = $request->date_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = "Update";

            if ($existingHistory) {
                $history->action_name = "Update";
            } else {
                $history->action_name = "New";
            }

            $history->save();
        }

        
        if ($lastDocument->calibration_due_alert != $calibration->calibration_due_alert || !empty($request->calibration_parameter_comment)) {

            $existingHistory = CalibrationAuditTrail::where('calibrationDetails_id', $id)
                ->where('activity_type', 'Calibration Due Alert')
                ->exists();

            $history = new CalibrationAuditTrail();
            $history->calibrationDetails_id = $id;
            $history->activity_type = 'Calibration Due Alert';
            $history->previous = $lastDocument->calibration_due_alert;
            $history->current = $calibration->calibration_due_alert;
            $history->comment = $request->date_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = "Update";

            if ($existingHistory) {
                $history->action_name = "Update";
            } else {
                $history->action_name = "New";
            }

            $history->save();
        }

        if ($lastDocument->calibration_cost != $calibration->calibration_cost || !empty($request->calibration_parameter_comment)) {

            $existingHistory = CalibrationAuditTrail::where('calibrationDetails_id', $id)
                ->where('activity_type', 'Calibration Cost')
                ->exists();

            $history = new CalibrationAuditTrail();
            $history->calibrationDetails_id = $id;
            $history->activity_type = 'Cost of Calibration';
            $history->previous = $lastDocument->calibration_cost;
            $history->current = $calibration->calibration_cost;
            $history->comment = $request->date_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = "Update";

            if ($existingHistory) {
                $history->action_name = "Update";
            } else {
                $history->action_name = "New";
            }

            $history->save();
        }
        
       
        if ($lastDocument->calibration_comments != $calibration->calibration_comments || !empty($request->calibration_parameter_comment)) {

            $existingHistory = CalibrationAuditTrail::where('calibrationDetails_id', $id)
                ->where('activity_type', 'Calibration Comments')
                ->exists();

            $history = new CalibrationAuditTrail();
            $history->calibrationDetails_id = $id;
            $history->activity_type = 'Calibration Comments//Observations';
            $history->previous = $lastDocument->calibration_comments;
            $history->current = $calibration->calibration_comments;
            $history->comment = $request->date_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = "Update";

            if ($existingHistory) {
                $history->action_name = "Update";
            } else {
                $history->action_name = "New";
            }

            $history->save();
        }
        
        
        if ($lastDocument->Imp_review_comm != $calibration->Imp_review_comm || !empty($request->calibration_parameter_comment)) {

            $existingHistory = CalibrationAuditTrail::where('calibrationDetails_id', $id)
                ->where('activity_type', 'Imp Review Comm')
                ->exists();

            $history = new CalibrationAuditTrail();
            $history->calibrationDetails_id = $id;
            $history->activity_type = 'Imp Review Comm';
            $history->previous = $lastDocument->Imp_review_comm;
            $history->current = $calibration->Imp_review_comm;
            $history->comment = $request->date_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = "Update";

            if ($existingHistory) {
                $history->action_name = "Update";
            } else {
                $history->action_name = "New";
            }

            $history->save();
        }

        if ($lastDocument->Implementor_Attachment != $calibration->Implementor_Attachment || !empty($request->calibration_parameter_comment)) {

            $existingHistory = CalibrationAuditTrail::where('calibrationDetails_id', $id)
                ->where('activity_type', 'Implementor Attachment')
                ->exists();

            $history = new CalibrationAuditTrail();
            $history->calibrationDetails_id = $id;
            $history->activity_type = 'Implementor Attachment';
            $history->previous = $lastDocument->Implementor_Attachment;
            $history->current = $calibration->Implementor_Attachment;
            $history->comment = $request->date_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = "Update";

            if ($existingHistory) {
                $history->action_name = "Update";
            } else {
                $history->action_name = "New";
            }

            $history->save();
        }

        if ($lastDocument->qa_rev_comm != $calibration->qa_rev_comm || !empty($request->calibration_parameter_comment)) {

            $existingHistory = CalibrationAuditTrail::where('calibrationDetails_id', $id)
                ->where('activity_type', 'QA  Rev Comm')
                ->exists();

            $history = new CalibrationAuditTrail();
            $history->calibrationDetails_id = $id;
            $history->activity_type = 'QA  Rev Comm';
            $history->previous = $lastDocument->qa_rev_comm;
            $history->current = $calibration->qa_rev_comm;
            $history->comment = $request->date_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = "Update";

            if ($existingHistory) {
                $history->action_name = "Update";
            } else {
                $history->action_name = "New";
            }

            $history->save();
        }
        

        
        if ($lastDocument->qa_rev_attachment != $calibration->qa_rev_attachment || !empty($request->calibration_parameter_comment)) {

            $existingHistory = CalibrationAuditTrail::where('calibrationDetails_id', $id)
                ->where('activity_type', 'QA Rev Attachment')
                ->exists();

            $history = new CalibrationAuditTrail();
            $history->calibrationDetails_id = $id;
            $history->activity_type = 'QA Rev Attachment';
            $history->previous = $lastDocument->qa_rev_attachment;
            $history->current = $calibration->qa_rev_attachment;
            $history->comment = $request->date_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = "Update";

            if ($existingHistory) {
                $history->action_name = "Update";
            } else {
                $history->action_name = "New";
            }

            $history->save();
        }
        

        toastr()->success("Record is Update Successfully");
        return back(); 
    }

    public function CalibrationDetailsStateChange(Request $request, $id)
        {
            if ($request->username == Auth::user()->Username && Hash::check($request->password, Auth::user()->password)) {
                $calibration = CallibrationDetails::find($id);
                $lastDocument =  CallibrationDetails::find($id);

                if ($calibration->stage == 1) {
                    $calibration->stage = "2";
                    $calibration->status = 'Calibration In Progress';
                    $calibration->Initiate_Calibration_by = Auth::user()->name;
                    $calibration->Initiate_Calibration_on =  Carbon::now('Asia/Kolkata')->format('d-M-Y H:i:s T') . 
                                        ' | GMT: ' . Carbon::now('UTC')->format('d-M-Y H:i:s T');
    
                    // Save comments
                    $calibration->Initiate_Calibration_comments = $request->comment;
    
                    // Create an audit trail for the calibration action
                    $history = new CalibrationAuditTrail();
                    $history->calibrationDetails_id = $id;
                    $history->activity_type = 'Initiate Calibration By';
                    $history->previous = "Opened";
                    $history->current = $calibration->Initiate_Calibration_by;
                    $history->comment = $request->comment;
                    $history->action = 'Initiate Calibration';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $lastDocument->status;
                    $history->change_to = "Calibration In Progress";
                    $history->change_from = $lastDocument->status;
                    $history->action_name = 'Update';
                    $history->stage = 'Calibration In Progress';
    
                    // If Initiate Calibration details are empty, set previous as an empty string
                    if (is_null($lastDocument->Initiate_Calibration_by) || $lastDocument->Initiate_Calibration_by === '') {
                        $history->previous = "";
                    } else {
                        $history->previous = $lastDocument->Initiate_Calibration_by . ' , ' . $lastDocument->Initiate_Calibration_on;
                    }
                    
                    $history->current = $calibration->Initiate_Calibration_by . ' , ' . $calibration->Initiate_Calibration_on;
    
                    // If there was no previous calibration, mark action as 'New'
                    if (is_null($lastDocument->Initiate_Calibration_by) || $lastDocument->Initiate_Calibration_by === '') {
                        $history->action_name = 'New';
                    } else {
                        $history->action_name = 'Update';
                    }
    
                    // Save the history
                    $history->save();
    
                    // Update the calibration details
                    $calibration->update();
    
                    // Display a success message and redirect
                    toastr()->success('Document Sent');
                    return back();
                }
    

                if ($calibration->stage == 2) {
                    $calibration->stage = "3";
                    $calibration->status = 'Pending Out of Limits Actions';
                    $calibration->Out_of_Limits_by  = Auth::user()->name;
                    // $calibration->Out_of_Limits_on = Carbon::now()->format('d-M-Y');
                    $calibration->Out_of_Limits_on =  Carbon::now('Asia/Kolkata')->format('d-M-Y H:i:s T') . 
                    ' | GMT: ' . Carbon::now('UTC')->format('d-M-Y H:i:s T');                    $calibration->Out_of_Limits_comment = $request->comment;

                    $history = new CalibrationAuditTrail();
                    $history->calibrationDetails_id = $id;
                    $history->activity_type = 'Out Of Limits By,Out of Limits On';
                    $history->previous ="Opened";
                    $history->current = $calibration->Out_of_Limits_by;
                    $history->comment = $request->comment;
                    $history->action = 'Out of Limits';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $lastDocument->status;
                    $history->change_to =   "Calibration In Progress";
                    $history->change_from = $lastDocument->status;
                    $history->action_name = 'Update';
                    
                    $history->stage = 'Pending Out of Limits Actions';
                    if (is_null($lastDocument->Out_of_Limits_by) || $lastDocument->Out_of_Limits_on === '') {
                        $history->previous = "";
                    } else {
                        $history->previous = $lastDocument->Out_of_Limits_by . ' , ' . $lastDocument->Out_of_Limits_on;
                    }
                    $history->current = $calibration->submit_by . ' , ' . $calibration->Out_of_Limits_on;
                    if (is_null($lastDocument->Out_of_Limits_by) || $lastDocument->Out_of_Limits_by === '') {
                        $history->action_name = 'New';
                    } else {
                        $history->action_name = 'Update';
                    }
                    $history->save();

                    $calibration->update();
                    toastr()->success('Document Sent');
                    return back();
                }


                if ($calibration->stage == 3) {
                    $calibration->stage = "4";
                    $calibration->status = 'Pending QA Approval';
                    $calibration->Complete_Actions_by = Auth::user()->name;
                    // $calibration->Complete_Actions_on = Carbon::now()->format('d-M-Y');
                    
                    $calibration->Complete_Actions_on =  Carbon::now('Asia/Kolkata')->format('d-M-Y H:i:s T') . 
                                        ' | GMT: ' . Carbon::now('UTC')->format('d-M-Y H:i:s T');
                    $calibration->Complete_Actions_comment = $request->comment;

                    
                    $history = new CalibrationAuditTrail();
                    $history->calibrationDetails_id = $id;
                    $history->activity_type = 'Complete Actions By,Complete Actions On';
                    $history->previous ="Opened";
                    $history->current = $calibration->Out_of_Limits_by;
                    $history->comment = $request->comment;
                    $history->action = 'Complete Actions';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $lastDocument->status;
                    $history->change_to =   "Calibration In Progress";
                    $history->change_from = $lastDocument->status;
                    $history->action_name = 'Update';
                    
                    $history->stage = 'Pending QA Approval';
                    if (is_null($lastDocument->Complete_Actions_by) || $lastDocument->Complete_Actions_on === '') {
                        $history->previous = "";
                    } else {
                        $history->previous = $lastDocument->Complete_Actions_by . ' , ' . $lastDocument->Complete_Actions_on;
                    }
                    $history->current = $calibration->submit_by . ' , ' . $calibration->Complete_Actions_on;
                    if (is_null($lastDocument->Complete_Actions_by) || $lastDocument->Complete_Actions_by === '') {
                        $history->action_name = 'New';
                    } else {
                        $history->action_name = 'Update';
                    }
                    $history->save();

                    $calibration->update();
                    toastr()->success('Document Sent');
                    return back();
                }

                if ($calibration->stage == 4) {
                    $calibration->stage = "5";
                    $calibration->status = 'Closed - Done';
                    $calibration->QA_Approval_by = Auth::user()->name;
                    // $calibration->QA_Approval_on = Carbon::now()->format('d-M-Y');
                    $calibration->QA_Approval_on =  Carbon::now('Asia/Kolkata')->format('d-M-Y H:i:s T') . 
                                        ' | GMT: ' . Carbon::now('UTC')->format('d-M-Y H:i:s T');
                    $calibration->QA_Approval_comment = $request->comment;

                    $history = new CalibrationAuditTrail();
                    $history->calibrationDetails_id = $id;
                    $history->activity_type = 'QA  Approval By ,QA Approval On';
                    $history->previous ="Opened";
                    $history->current = $calibration->QA_Approval_by;
                    $history->comment = $request->comment;
                    $history->action = 'QA Approval';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $lastDocument->status;
                    $history->change_to =   "Pending QA Approval";
                    $history->change_from = $lastDocument->status;
                    $history->action_name = 'Update';
                    
                    $history->stage = 'Closed - Done';
                    if (is_null($lastDocument->QA_Approval_by) || $lastDocument->QA_Approval_on === '') {
                        $history->previous = "";
                    } else {
                        $history->previous = $lastDocument->QA_Approval_by . ' , ' . $lastDocument->QA_Approval_on;
                    }
                    $history->current = $calibration->submit_by . ' , ' . $calibration->QA_Approval_on;
                    if (is_null($lastDocument->QA_Approval_by) || $lastDocument->QA_Approval_by === '') {
                        $history->action_name = 'New';
                    } else {
                        $history->action_name = 'Update';
                    }
                    $history->save();

                    $calibration->update();
                    toastr()->success('Document Sent');
                    return back();
                }

            }else {
                toastr()->error('E-signature Not match');
                return back();
            }
        }

    public function CalibrationDetailsStateChangeNew(Request $request, $id)
    {
        if ($request->username == Auth::user()->Username && Hash::check($request->password, Auth::user()->password)) {
            $calibration = CallibrationDetails::find($id);
            $lastDocument =  CallibrationDetails::find($id);

            if ($calibration->stage == 2) {
                $calibration->stage = "4";
                $calibration->status = 'Pending QA Approval';
                $calibration->Within_Limits_by = Auth::user()->name;
                // $calibration->Within_Limits_on = Carbon::now()->format('d-M-Y');
                $calibration->Within_Limits_on = Carbon::now('Asia/Kolkata')->format('d-M-Y H:i:s T') . 
                                        ' | GMT: ' . Carbon::now('UTC')->format('d-M-Y H:i:s T');
                $calibration->Within_Limits_comment = $request->comment;

                $history = new CalibrationAuditTrail();
                $history->calibrationDetails_id = $id;
                $history->activity_type = 'Submit By ,Submit On';
                $history->previous ="Opened";
                $history->current = $calibration->Initiate_Calibration_by;
                $history->comment = $request->comment;
                $history->action = 'submit';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to =   "Supervisor Review";
                $history->change_from = $lastDocument->status;
                $history->action_name = 'Update';
                
                $history->stage = 'Pending QA Approval';
                if (is_null($lastDocument->submit_by) || $lastDocument->submit_by === '') {
                    $history->previous = "";
                } else {
                    $history->previous = $lastDocument->submit_by . ' , ' . $lastDocument->Out_of_Limits_on;
                }
                $history->current = $calibration->submit_by . ' , ' . $calibration->submit_on;
                if (is_null($lastDocument->submit_by) || $lastDocument->submit_by === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->save();
                $calibration->update();
                toastr()->success('Document Sent');
                return back();
            }
    
        }else {
            toastr()->error('E-signature Not match');
            return back();
        }
    }


    public function RejectCalibrationDetails(Request $request, $id)
    {
        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $calibration = CallibrationDetails::find($id);
            $lastDocument =  CallibrationDetails::find($id);

            if ($calibration->stage == 5) {
                $calibration->stage = "4";
                $calibration->status = "Pending QA Approval";

                $calibration->Re_Qualification_by = Auth::user()->name;
                $calibration->Re_Qualification_on = Carbon::now()->format('d-M-Y');
                $calibration->Re_Qualification_comment = $request->comment;

                $calibration->update();


                toastr()->success('Document Sent');
                return back();
            }
            
            if ($calibration->stage == 3) {
                $calibration->stage = "2";
                $calibration->status = "Supervisor Review";

                $calibration->More_Info_by = Auth::user()->name;
                $calibration->More_Info_on = Carbon::now()->format('d-M-Y');
                $calibration->More_Info_comment = $request->comment;

                $calibration->update();


                toastr()->success('Document Sent');
                return back();
            }


            if ($calibration->stage == 4) {
                $calibration->stage = "3";
                $calibration->status = "Pending Qualification";

                $calibration->More_Info_by_sec_by = Auth::user()->name;
                $calibration->More_Info_by_sec_on = Carbon::now()->format('d-M-Y');
                $calibration->More_Info_by_sec_comment = $request->comment;

                $calibration->update();


                toastr()->success('Document Sent');
                return back();
            }

        }else {
            toastr()->error('E-signature Not match');
            return back();
        }
    }

    public function Calibration_more_info(Request $request, $id)
    {
       
        if ($request->username == Auth::user()->Username && Hash::check($request->password, Auth::user()->password)) {
            $calibration = CallibrationDetails::find($id);
            $lastDocument =  CallibrationDetails::find($id);

            if ($calibration->stage == 4) {
                $calibration->stage = "2";
                $calibration->status = 'Pending QA Approval';
                $calibration->Additional_Work_Required_by = Auth::user()->name;
                $calibration->Additional_Work_Required_on = Carbon::now()->format('d-M-Y');
                $calibration->Additional_Work_Required_comment	 = $request->comment;

                $history = new CalibrationAuditTrail();
                $history->calibrationDetails_id = $id;
                $history->activity_type = 'Additional Work Required By ,Additional Work Required On';
                $history->previous ="Opened";
                $history->current = $calibration->Additional_Work_Required_by;
                $history->comment = $request->comment;
                $history->action = 'Additional Work Required';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to =   "Pending QA Approval";
                $history->change_from = $lastDocument->status;
                $history->action_name = 'Update';
                
                $history->stage = 'Pending QA Approval';
                if (is_null($lastDocument->Additional_Work_Required_by) || $lastDocument->Additional_Work_Required_by === '') {
                    $history->previous = "";
                } else {
                    $history->previous = $lastDocument->Additional_Work_Required_by . ' , ' . $lastDocument->Additional_Work_Required_on;
                }
                $history->current = $calibration->Additional_Work_Required_by . ' , ' . $calibration->submit_on;
                if (is_null($lastDocument->Additional_Work_Required_by) || $lastDocument->Additional_Work_Required_by === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->save();
                $calibration->update();
                toastr()->success('Document Sent');
                return back();
            }  

        }else {
            toastr()->error('E-signature Not match');
            return back();
        }
    }

    public function CalibrationChild(Request $request, $id)
    {

        $parent_id = $id;
        $record = ((RecordNumber::first()->value('counter')) + 1);
        $record = str_pad($record, 4, '0', STR_PAD_LEFT);
        $parent_type = "Calibration Management";
        $parent_name = "Calibration Management";
        $parent_name = $request->$parent_name;
        $record_number = ((RecordNumber::first()->value('counter')) + 1);
        $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
        $record_number = $record;
        $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $due_date = $formattedDate->format('d-M-Y');
        $parent_record = CallibrationDetails::where('id', $id)->value('record');
        $parent_record = str_pad($parent_record, 4, '0', STR_PAD_LEFT);
        $parent_division_id = CallibrationDetails::where('id', $id)->value('division_id');
        $parent_initiator_id = CallibrationDetails::where('id', $id)->value('initiator_id');
        $parent_intiation_date = CallibrationDetails::where('id', $id)->value('intiation_date');
        $parent_created_at = CallibrationDetails::where('id', $id)->value('created_at');
        $parent_short_description = CallibrationDetails::where('id', $id)->value('short_description');
        $hod = User::where('role', 4)->get();
        
      
            $old_record = ActionItem::select('id', 'division_id', 'record')->get();
            
            return view('frontend.action-item.action-item', compact('parent_id', 'record', 'parent_type', 'record_number', 'currentDate', 'formattedDate', 'due_date', 'parent_record', 'parent_record', 'parent_division_id', 'parent_initiator_id', 'parent_intiation_date', 'parent_short_description','old_record'));
         
        
    }

    public function calibrationSingleReport($id)
    {
        $data = CallibrationDetails::find($id);

        if (!empty($data)) {
            // $data->Product_Details = CapaGrid::where('capa_id', $id)->where('type', "Product_Details")->first();
            // $data->Instruments_Details = CapaGrid::where('capa_id', $id)->where('type', "Instruments_Details")->first();
            // $data->Material_Details = CapaGrid::where('capa_id', $id)->where('type', "Material_Details")->first();
            // $data->originator = User::where('id', $data->initiator_id)->value('name');

            // $capa_teamIdsArray = explode(',', $data->capa_team);
            // $capa_teamNames = User::whereIn('id', $capa_teamIdsArray)->pluck('name')->toArray();
            // $capa_teamNamesString = implode(', ', $capa_teamNames);

            $pdf = App::make('dompdf.wrapper');
            $time = Carbon::now();
            $pdf = PDF::loadview('frontend.Callibration-Details.Calibration_Single_Report', compact('data', ))
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
            return $pdf->stream('CAPA' . $id . '.pdf');
        }
    }

    public function auditTrialPDF($id)
    {
        $doc = CallibrationDetails::find($id);
        $doc->originator = User::where('id', $doc->initiator_id)->value('name');
        $data = CalibrationAuditTrail::where('calibrationDetails_id', $doc->id)->orderByDesc('id')->get();
        $pdf = App::make('dompdf.wrapper');
        $time = Carbon::now();
        $pdf = PDF::loadview('frontend.Callibration-Details.calibration_audit_trail_pdf', compact('data', 'doc'))
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

        $canvas->page_text(
            $width / 3,
            $height / 2,
            $doc->status,
            null,
            60,
            [0, 0, 0],
            2,
            6,
            -20
        );
        return $pdf->stream('SOP' . $id . '.pdf');
    }
         
    public function calibrationAuditTrail($id)
    {
        $audit = CalibrationAuditTrail::where('calibrationDetails_id', $id)->orderByDESC('id')->paginate(5);
        $today = Carbon::now()->format('d-m-y');
        $document = CallibrationDetails::where('id', $id)->first();
        $document->originator = User::where('id', $document->initiator_id)->value('name');
        
        return view("frontend.Callibration-Details.calibration_audit_trail", compact('audit', 'document', 'today'));

    }

    public function calibrationActivityLog($id)
    {
        $data = CallibrationDetails::find($id);
        $calibration = CallibrationDetails::find($id);


        if (!empty($data)) {
            // $data->Product_Details = CapaGrid::where('capa_id', $id)->where('type', "Product_Details")->first();
            // $data->Instruments_Details = CapaGrid::where('capa_id', $id)->where('type', "Instruments_Details")->first();
            // $data->Material_Details = CapaGrid::where('capa_id', $id)->where('type', "Material_Details")->first();
            // $data->originator = User::where('id', $data->initiator_id)->value('name');

            // $capa_teamIdsArray = explode(',', $data->capa_team);
            // $capa_teamNames = User::whereIn('id', $capa_teamIdsArray)->pluck('name')->toArray();
            // $capa_teamNamesString = implode(', ', $capa_teamNames);

            $pdf = App::make('dompdf.wrapper');
            $time = Carbon::now();
            $pdf = PDF::loadview('frontend.Callibration-Details.activityLog', compact('data','calibration' ))
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
            return $pdf->stream('Calibration_managment_activity_log' . $id . '.pdf');
        }
    }
    
    public function calibration_detailexportCsv(Request $request)
    {
        $query = CallibrationDetails::query();
    
        if (!empty($request->department_calibrationmanagement)) {
            $query->whereIn('Initiator_Group', $request->department_calibrationmanagement); 
        }

        if ($request->division_id_calibrationmanagement) {
            $query->where('division_id', $request->division_id_calibrationmanagement);
        }

        if ($request->initiator_id_calibrationmanagement) {
            $query->where('initiator_id', $request->initiator_id_calibrationmanagement);
        }

        if ($request->date_fromcm) {
            $dateFrom = Carbon::parse($request->date_fromcm)->startOfDay();
            $query->whereDate('intiation_date', '>=', $dateFrom);
        }

        if ($request->date_tocm) {
            $dateTo = Carbon::parse($request->date_tocm)->endOfDay();
            $query->whereDate('intiation_date', '<=', $dateTo);
        }

     
        if ($request->sort_column && $request->sort_order) {
            $query->orderBy($request->sort_column, $request->sort_order);
        }

        $cm = $query->get();
    
        $fileName = 'calibration_managment_log.csv';
        $headers = [
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename=\"$fileName\"",
        ];
    
        $columns = [
            'Sr. No.', 'Initiation Date', 'Record No',
            'Division', 'Short Description.', 'Due Date',
            'Initiator', 'Status'
        ];
    
        $callback = function () use ($cm, $columns) {
            $file = fopen('php://output', 'w');
    
            fputcsv($file, $columns);
    
            if ($cm->isEmpty()) {
                fputcsv($file, ['No records found']);
            } else {
                foreach ($cm as $index => $row) {
                    $data = [
                        $index + 1, 
                        $row->intiation_date ?? 'Not Applicable', 
                        $row->division ? $row->division->name . '/CM/' . date('Y') . '/' . str_pad($row->record, 4, '0', STR_PAD_LEFT) : 'Not Applicable',
                        $row->division ? $row->division->name : 'Not Applicable', 
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
    
    


    public function calibration_detailexportExcel(Request $request)
    {
        $query = CallibrationDetails::query();
    
      
        if ($request->division_id_calibrationmanagement) {
            $query->where('division_id', $request->division_id_calibrationmanagement);
        }

        if ($request->initiator_id_calibrationmanagement) {
            $query->where('initiator_id', $request->initiator_id_calibrationmanagement);
        }

        if ($request->date_fromcm) {
            $dateFrom = Carbon::parse($request->date_fromcm)->startOfDay();
            $query->whereDate('intiation_date', '>=', $dateFrom);
        }

        if ($request->date_tocm) {
            $dateTo = Carbon::parse($request->date_tocm)->endOfDay();
            $query->whereDate('intiation_date', '<=', $dateTo);
        }

     
        if ($request->sort_column && $request->sort_order) {
            $query->orderBy($request->sort_column, $request->sort_order);
        }

        $cm = $query->get();
    
        $fileName = "calibration_management_log.xls";
    
        $headers = [
            "Content-Type" => "application/vnd.ms-excel",
            "Content-Disposition" => "attachment; filename=\"$fileName\"",
        ];
    
        $columns = [
            'Sr. No.', 'Initiation Date', 'Record No',
            'Division', 'Short Description.', 'Due Date',
            'Initiator', 'Status'
        ];
    
        $callback = function () use ($cm, $columns) {
            echo '<table border="1">';
    
            echo '<tr style="font-weight: bold; background-color: #1F4E79; color: #FFFFFF;">';
            foreach ($columns as $column) {
                echo "<th style='padding: 5px;'>" . htmlspecialchars($column) . "</th>";
            }
            echo '</tr>';
    
            if ($cm->isEmpty()) {
                echo '<tr>';
                echo "<td colspan='" . count($columns) . "' style='text-align: center;'>No records found</td>";
                echo '</tr>';
            } else {
                foreach ($cm as $index => $row) {
                    echo '<tr>';
                    echo "<td style='padding: 5px;'>" . ($index + 1) . "</td>";
                    echo "<td style='padding: 5px;'>" . htmlspecialchars($row->intiation_date ?? 'Not Applicable') . "</td>";
                    echo "<td style='padding: 5px;'>" . htmlspecialchars($row->division ? $row->division->name . '/CM/' . date('Y') . '/' . str_pad($row->record, 4, '0', STR_PAD_LEFT) : 'Not Applicable') . "</td>";
                    echo "<td style='padding: 5px;'>" . htmlspecialchars( $row->division ? $row->division->name : 'Not Applicable') . "</td>";
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
    
    
    public function csvcallibration(Request $request)
    {
        $query = CallibrationDetails::query();
    
        // Apply filters similar to your other methods
        if ($request->department_changecontrol) {
            $query->where('Initiator_Group', $request->department_changecontrol);
        }
    
        if ($request->division_id_changecontrol) {
            $query->where('severity', $request->division_id_changecontrol);
        }
    
        if ($request->Clasichange) {
            $query->where('severity_level1', $request->Clasichange);
        }
    
        if ($request->RadioActivtiyTCC) {
            $query->where('doc_change', $request->RadioActivtiyTCC);
        }
    
        // Fetch the filtered data
        $cc_cft = $query->get();
    
        $fileName = 'callibration_details_log.csv';
        $headers = [
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename=\"$fileName\"",
        ];
    
        $columns = [
            'Sr. No.', 'Initiation Date', 'Record No',
            'Division', 'Department Name', 'Short Description.', 'Due Date',
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
                        $row->division ? $row->division->name . '/Audit/' . date('Y') . '/' . str_pad($row->record, 4, '0', STR_PAD_LEFT) : 'Not Applicable',
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

    public function Excelcallibration (Request $request)
    {
        $query = CallibrationDetails::query();
    
        if ($request->department_changecontrol) {
            $query->where('Initiator_Group', $request->department_changecontrol);
        }
    
        if ($request->division_id_changecontrol) {
            $query->where('severity', $request->division_id_changecontrol);
        }
    
        if ($request->Clasichange) {
            $query->where('severity_level1', $request->Clasichange);
        }
      if ($request->initiator_id_changecontrol) {
            $query->where('initiator_id', $request->initiator_id_changecontrol);
        }
    
        if ($request->RadioActivtiyTCC) {
            $query->where('doc_change', $request->RadioActivtiyTCC);
        }
    
        $cc_cft = $query->get();
    
        $fileName = "calibration_details_log.xls";
    
        $headers = [
            "Content-Type" => "application/vnd.ms-excel",
            "Content-Disposition" => "attachment; filename=\"$fileName\"",
        ];
    
        $columns = [
            'Sr. No.', 'Initiation Date', 'Record No',
            'Division', 'Department Name', 'Short Description.', 'Due Date',
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



    