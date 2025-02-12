<?php

namespace App\Http\Controllers\rcms;

use App\Models\ChangeControlFields;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\ActionItem;
use App\Models\AdditionalInformation;
use App\Models\{Capa, GlobalChangeControl, GlobalChangeControlResponse, EffectivenessCheck, extension_new, RootCauseAnalysis};
use App\Models\RecordNumber;
use App\Models\CCStageHistory;
use App\Models\GlobalImpactAssessment;
use App\Models\ChangeClosure;
use App\Models\GlobalChangeControlAuditTrail;
use App\Models\table_cc_impactassement;
use App\Models\ChangeControlStageComment;
use App\Models\Docdetail;
use App\Models\ChangeControlComment;
use App\Models\GlobalChangeControlCft;
use App\Models\CCImpactAssessment;
use App\Mail\RecordAssignMail;

use App\Models\Evaluation;
use App\Models\ExternalReview;
use App\Models\SetDivision;
use App\Models\QMSProcess;
use App\Models\Process;
use App\Models\Division;
use App\Models\DocumentLanguage;
use App\Models\Extension;
use App\Models\GroupComments;
use App\Models\QaApprovalComments;
use App\Models\NotificationUser;
use App\Models\Qareview;
use App\Models\QMSDivision;
use App\Models\RiskAssessment;
use App\Models\RiskManagement;
use App\Models\RcmDocHistory;
use App\Models\RiskLevelKeywords;
use App\Models\RoleGroup;
use App\Models\User;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Dompdf\Options;
use Helpers;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use PDF;

use Illuminate\Support\Facades\File;

class GlobalChangeControlController extends Controller
{
    public function create()
    {

        $riskData = RiskLevelKeywords::all();
        $record_number = ((RecordNumber::first()->value('counter')) + 1);
        $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
        $preRiskAssessment = RiskManagement::all();

        $division = QMSDivision::where('name', Helpers::getDivisionName(session()->get('division')))->first();

        $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $due_date = $formattedDate->format('d-M-Y');
        $hod = User::get();
        $cft = User::get();
        $pre = GlobalChangeControl::all();

        return view('frontend.global-cc.create', compact("riskData", "preRiskAssessment", "due_date", "hod", "cft", "pre"));
    }
    public function store(Request $request)
    {
        $openState = new GlobalChangeControl();
        $openState->form_type = "Global Change Control";
        $openState->division_id = $request->division_id;
        $openState->initiator_id = Auth::user()->id;
        $openState->record = DB::table('record_numbers')->value('counter') + 1;
        $openState->parent_id = $request->parent_id;
        $openState->parent_type = $request->parent_type;
        $openState->intiation_date = $request->intiation_date;
        $openState->due_days = $request->due_days;

        $openState->severity_level1 = $request->severity_level1;
        $openState->product_name = $request->product_name;
        $openState->Initiator_Group = $request->Initiator_Group;
        $openState->initiator_group_code = $request->initiator_group_code;
        $openState->short_description = $request->short_description;
        $openState->priority_data = $request->priority_data;
        $openState->risk_assessment_required = $request->risk_assessment_required;
        $openState->hod_person = $request->hod_person;
        $openState->doc_change = $request->doc_change;
        $openState->If_Others = $request->others;
        $openState->initiated_through = $request->initiated_through;
        $openState->initiated_through_req = $request->initiated_through_req;

        $openState->repeat = $request->repeat;
        $openState->repeat_nature = $request->repeat_nature;
        $openState->current_practice = $request->current_practice;
        $openState->proposed_change = $request->proposed_change;
        $openState->reason_change = $request->reason_change;
        $openState->other_comment = $request->other_comment;

        $openState->qa_comments = $request->qa_comments;

        $openState->risk_identification = $request->risk_identification;
        $openState->severity = $request->severity;
        $openState->Occurance = $request->Occurance;
        $openState->migration_action = $request->migration_action;

        $openState->qa_appro_comments = $request->qa_appro_comments;

        $openState->qa_closure_comments = $request->qa_closure_comments;
        $openState->due_date_extension = $request->due_date_extension;

        $openState->qa_head = $request->qa_head;
        // $openState->related_records = implode(',', $request->related_records);

        $openState->feedback = $request->feedback;
        if (!empty($request->tran_attach)) {
            $files = [];
            if ($request->hasfile('tran_attach')) {
                foreach ($request->file('tran_attach') as $file) {
                    $name = "GlobalCC" . '-tran_attach' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $openState->tran_attach = json_encode($files);
        }

        
        $openState->qa_eval_comments = $request->qa_eval_comments;
        if (!empty($request->qa_eval_attach)) {
            $files = [];
            if ($request->hasfile('qa_eval_attach')) {
                foreach ($request->file('qa_eval_attach') as $file) {
                    $name = "GlobalCC" . '-qa_eval_attach' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $openState->qa_eval_attach = json_encode($files);
        }

        if (!empty($request->in_attachment)) {
            $files = [];
            if ($request->hasfile('in_attachment')) {
                foreach ($request->file('in_attachment') as $file) {
                    $name = "GlobalCC" . '-in_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $openState->in_attachment = json_encode($files);
        }

        if (!empty($request->risk_assessment_atch)) {
            $files = [];
            if ($request->hasfile('risk_assessment_atch')) {
                foreach ($request->file('risk_assessment_atch') as $file) {
                    $name = "GlobalCC" . '-risk_assessment_atch' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $openState->risk_assessment_atch = json_encode($files);
        }

        $openState->status = 'Opened';
        $openState->stage = 1;
        $openState->save();

        $getId = $openState->id;
        if(!empty($getId)){
            $impactChecklist = new GlobalImpactAssessment();
            $impactChecklist->cc_id = $getId;
            $impactChecklist->remark_que1 = $request->remark_que1;
            $impactChecklist->remark_que2 = $request->remark_que2;
            $impactChecklist->remark_que3 = $request->remark_que3;
            $impactChecklist->remark_que4 = $request->remark_que4;
            $impactChecklist->remark_que5 = $request->remark_que5;
            $impactChecklist->remark_que6 = $request->remark_que6;
            $impactChecklist->remark_que7 = $request->remark_que7;
            $impactChecklist->remark_que8 = $request->remark_que8;
            $impactChecklist->remark_que9 = $request->remark_que9;
            $impactChecklist->remark_que10 = $request->remark_que10;
            $impactChecklist->remark_que11 = $request->remark_que11;
            $impactChecklist->remark_que12 = $request->remark_que12;
            $impactChecklist->remark_que13 = $request->remark_que13;
            $impactChecklist->remark_que14 = $request->remark_que14;
            $impactChecklist->remark_que15 = $request->remark_que15;
            $impactChecklist->remark_que16 = $request->remark_que16;
            $impactChecklist->remark_que17 = $request->remark_que17;
            $impactChecklist->remark_que18 = $request->remark_que18;
            $impactChecklist->remark_que19 = $request->remark_que19;
            $impactChecklist->remark_que20 = $request->remark_que20;
            $impactChecklist->remark_que21 = $request->remark_que21;
            $impactChecklist->remark_que22 = $request->remark_que22;
            $impactChecklist->remark_que23 = $request->remark_que23;
            $impactChecklist->remark_que24 = $request->remark_que24;
            $impactChecklist->remark_que25 = $request->remark_que25;
            $impactChecklist->remark_que26 = $request->remark_que26;
            $impactChecklist->remark_que27 = $request->remark_que27;
            $impactChecklist->remark_que28 = $request->remark_que28;
            $impactChecklist->remark_que29 = $request->remark_que29;
            $impactChecklist->remark_que30 = $request->remark_que30;
            $impactChecklist->remark_que31 = $request->remark_que31;
            $impactChecklist->remark_que32 = $request->remark_que32;
            $impactChecklist->remark_que33 = $request->remark_que33;
            $impactChecklist->save(); 
        }

        $userNotification = new NotificationUser();
        $userNotification->record_id = $openState->id;
        $userNotification->record_type = "GlobalCC";
        $userNotification->to_id = Auth::user()->id;
        $userNotification->save();

        $fields = new ChangeControlFields();
        $fields->cc_id = $openState->id;
        $fields->impact_operations = $request->impact_operations;
        $fields->impact_product_quality = $request->impact_product_quality;
        $fields->regulatory_impact = $request->regulatory_impact;
        $fields->risk_level = $request->risk_level;
        $fields->validation_requirment = $request->validation_requirment;
        $fields->save();

        /* CFT Data Feilds Start */

        $Cft = new GlobalChangeControlCft();
        $Cft->cc_id = $openState->id;
        $Cft->Production_Review = $request->Production_Review;
        $Cft->Production_person = $request->Production_person;
        $Cft->Production_assessment = $request->Production_assessment;
        $Cft->Production_feedback = $request->Production_feedback;
        $Cft->production_on = $request->production_on;
        $Cft->production_by = $request->production_by;

        $Cft->Warehouse_review = $request->Warehouse_review;
        $Cft->Warehouse_assessment = $request->Warehouse_assessment;
        $Cft->Warehouse_feedback = $request->Warehouse_feedback;
        $Cft->Warehouse_by = $request->Warehouse_Review_Completed_By;
        $Cft->Warehouse_on = $request->Warehouse_on;

        $Cft->Quality_review = $request->Quality_review;
        $Cft->Quality_Control_Person = $request->Quality_Control_Person;
        $Cft->Quality_Control_assessment = $request->Quality_Control_assessment;
        $Cft->Quality_Control_feedback = $request->Quality_Control_feedback;
        $Cft->Quality_Control_by = $request->Quality_Control_by;
        $Cft->Quality_Control_on = $request->Quality_Control_on;

        $Cft->Quality_Assurance_Review = $request->Quality_Assurance_Review;
        $Cft->QualityAssurance_person = $request->QualityAssurance_person;
        $Cft->QualityAssurance_assessment = $request->QualityAssurance_assessment;
        $Cft->QualityAssurance_feedback = $request->QualityAssurance_feedback;
        $Cft->QualityAssurance_by = $request->QualityAssurance_by;
        $Cft->QualityAssurance_on = $request->QualityAssurance_on;

        $Cft->Engineering_review = $request->Engineering_review;
        $Cft->Engineering_person = $request->Engineering_person;
        $Cft->Engineering_assessment = $request->Engineering_assessment;
        $Cft->Engineering_feedback = $request->Engineering_feedback;
        $Cft->Engineering_by = $request->Engineering_by;
        $Cft->Engineering_on = $request->Engineering_on;

        $Cft->Human_Resource_review = $request->Human_Resource_review;
        $Cft->Human_Resource_person = $request->Human_Resource_person;
        $Cft->Human_Resource_assessment = $request->Human_Resource_assessment;
        $Cft->Human_Resource_feedback = $request->Human_Resource_feedback;
        $Cft->Human_Resource_by = $request->Human_Resource_by;
        $Cft->Human_Resource_on = $request->Human_Resource_on;

        $Cft->ResearchDevelopment_Review = $request->ResearchDevelopment_Review;
        $Cft->ResearchDevelopment_person = $request->ResearchDevelopment_person;
        $Cft->ResearchDevelopment_assessment = $request->ResearchDevelopment_assessment;
        $Cft->ResearchDevelopment_feedback = $request->ResearchDevelopment_feedback;
        $Cft->ResearchDevelopment_by = $request->ResearchDevelopment_by;
        $Cft->ResearchDevelopment_on = $request->ResearchDevelopment_on;

        $Cft->RegulatoryAffair_Review = $request->RegulatoryAffair_Review;
        $Cft->RegulatoryAffair_person = $request->RegulatoryAffair_person;
        $Cft->RegulatoryAffair_assessment = $request->RegulatoryAffair_assessment;
        $Cft->RegulatoryAffair_feedback = $request->RegulatoryAffair_feedback;
        $Cft->RegulatoryAffair_by = $request->RegulatoryAffair_by;
        $Cft->RegulatoryAffair_on = $request->RegulatoryAffair_on;

        $Cft->Microbiology_Review = $request->Microbiology_Review;
        $Cft->Microbiology_person = $request->Microbiology_person;
        $Cft->Microbiology_assessment = $request->Microbiology_assessment;
        $Cft->Microbiology_feedback = $request->Microbiology_feedback;
        $Cft->Microbiology_by = $request->Microbiology_by;
        $Cft->Microbiology_on = $request->Microbiology_on;

        $Cft->Other1_person = $request->Other1_person;
        $Cft->Other1_Department_person = $request->Other1_Department_person;
        $Cft->Other1_assessment = $request->Other1_assessment;
        $Cft->Other1_feedback = $request->Other1_feedback;
        $Cft->Other1_by = $request->Other1_by;
        $Cft->Other1_on = $request->Other1_on;

        $Cft->Other2_review = $request->Other2_review;
        $Cft->Other2_person = $request->Other2_person;
        $Cft->Other2_Department_person = $request->Other2_Department_person;
        $Cft->Other2_Assessment = $request->Other2_Assessment;
        $Cft->Other2_feedback = $request->Other2_feedback;
        $Cft->Other2_by = $request->Other2_by;
        $Cft->Other2_on = $request->Other2_on;

        $Cft->Other3_review = $request->Other3_review;
        $Cft->Other3_person = $request->Other3_person;
        $Cft->Other3_Department_person = $request->Other3_Department_person;
        $Cft->Other3_Assessment = $request->Other3_Assessment;
        $Cft->Other3_feedback = $request->Other3_feedback;
        $Cft->Other3_by = $request->Other3_by;
        $Cft->Other3_on = $request->Other3_on;

        $Cft->Other4_review = $request->Other4_review;
        $Cft->Other4_person = $request->Other4_person;
        $Cft->Other4_Department_person = $request->Other4_Department_person;
        $Cft->Other4_Assessment = $request->Other4_Assessment;
        $Cft->Other4_feedback = $request->Other4_feedback;
        $Cft->Other4_by = $request->Other4_by;
        $Cft->Other4_on = $request->Other4_on;

        $Cft->Other5_review = $request->Other5_review;
        $Cft->Other5_person = $request->Other5_person;
        $Cft->Other5_Department_person = $request->Other5_Department_person;
        $Cft->Other5_Assessment = $request->Other5_Assessment;
        $Cft->Other5_feedback = $request->Other5_feedback;
        $Cft->Other5_by = $request->Other5_by;
        $Cft->Other5_on = $request->Other5_on;

        
        if (!empty ($request->RA_attachment)) {
            $files = [];
            if ($request->hasfile('RA_attachment')) {
                foreach ($request->file('RA_attachment') as $file) {
                    $name = $request->name . 'RA_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $Cft->RA_attachment = json_encode($files);
        }
        if (!empty ($request->Quality_Assurance_attachment)) {
            $files = [];
            if ($request->hasfile('Quality_Assurance_attachment')) {
                foreach ($request->file('Quality_Assurance_attachment') as $file) {
                    $name = $request->name . 'Quality_Assurance_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $Cft->Quality_Assurance_attachment = json_encode($files);
        }
        if (!empty ($request->Production_Table_Attachment)) {
            $files = [];
            if ($request->hasfile('Production_Table_Attachment')) {
                foreach ($request->file('Production_Table_Attachment') as $file) {
                    $name = $request->name . 'Production_Table_Attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $Cft->Production_Table_Attachment = json_encode($files);
        }
        if (!empty ($request->ProductionLiquid_attachment)) {
            $files = [];
            if ($request->hasfile('ProductionLiquid_attachment')) {
                foreach ($request->file('ProductionLiquid_attachment') as $file) {
                    $name = $request->name . 'ProductionLiquid_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $Cft->ProductionLiquid_attachment = json_encode($files);
        }
        if (!empty ($request->Production_Injection_Attachment)) {
            $files = [];
            if ($request->hasfile('Production_Injection_Attachment')) {
                foreach ($request->file('Production_Injection_Attachment') as $file) {
                    $name = $request->name . 'Production_Injection_Attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $Cft->Production_Injection_Attachment = json_encode($files);
        }    
        


        if (!empty ($request->Store_attachment)) {
            $files = [];
            if ($request->hasfile('Store_attachment')) {
                foreach ($request->file('Store_attachment') as $file) {
                    $name = $request->name . 'Store_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $Cft->Store_attachment = json_encode($files);
        }
        if (!empty ($request->Quality_Control_attachment)) {
            $files = [];
            if ($request->hasfile('Quality_Control_attachment')) {
                foreach ($request->file('Quality_Control_attachment') as $file) {
                    $name = $request->name . 'Quality_Control_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $Cft->Quality_Control_attachment = json_encode($files);
        }
        if (!empty ($request->ResearchDevelopment_attachment)) {
            $files = [];
            if ($request->hasfile('ResearchDevelopment_attachment')) {
                foreach ($request->file('ResearchDevelopment_attachment') as $file) {
                    $name = $request->name . 'ResearchDevelopment_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $Cft->ResearchDevelopment_attachment = json_encode($files);
        }
        if (!empty ($request->Engineering_attachment)) {
            $files = [];
            if ($request->hasfile('Engineering_attachment')) {
                foreach ($request->file('Engineering_attachment') as $file) {
                    $name = $request->name . 'Engineering_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $Cft->Engineering_attachment = json_encode($files);
        }
        if (!empty ($request->Human_Resource_attachment)) {
            $files = [];
            if ($request->hasfile('Human_Resource_attachment')) {
                foreach ($request->file('Human_Resource_attachment') as $file) {
                    $name = $request->name . 'Human_Resource_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $Cft->Human_Resource_attachment = json_encode($files);
        }
        if (!empty ($request->Microbiology_attachment)) {
            $files = [];
            if ($request->hasfile('Microbiology_attachment')) {
                foreach ($request->file('Microbiology_attachment') as $file) {
                    $name = $request->name . 'Microbiology_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $Cft->Microbiology_attachment = json_encode($files);
        }
        if (!empty ($request->RegulatoryAffair_attachment)) {
            $files = [];
            if ($request->hasfile('RegulatoryAffair_attachment')) {
                foreach ($request->file('RegulatoryAffair_attachment') as $file) {
                    $name = $request->name . 'RegulatoryAffair_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $Cft->RegulatoryAffair_attachment = json_encode($files);
        }
        if (!empty ($request->CorporateQualityAssurance_attachment)) {
            $files = [];
            if ($request->hasfile('CorporateQualityAssurance_attachment')) {
                foreach ($request->file('CorporateQualityAssurance_attachment') as $file) {
                    $name = $request->name . 'CorporateQualityAssurance_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $Cft->CorporateQualityAssurance_attachment = json_encode($files);
        }
        if (!empty ($request->Environment_Health_Safety_attachment)) {
            $files = [];
            if ($request->hasfile('Environment_Health_Safety_attachment')) {
                foreach ($request->file('Environment_Health_Safety_attachment') as $file) {
                    $name = $request->name . 'Environment_Health_Safety_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $Cft->Environment_Health_Safety_attachment = json_encode($files);
        }            
        if (!empty ($request->Information_Technology_attachment)) {
            $files = [];
            if ($request->hasfile('Information_Technology_attachment')) {
                foreach ($request->file('Information_Technology_attachment') as $file) {
                    $name = $request->name . 'Information_Technology_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $Cft->Information_Technology_attachment = json_encode($files);
        }
        if (!empty ($request->ContractGiver_attachment)) {
            $files = [];
            if ($request->hasfile('ContractGiver_attachment')) {
                foreach ($request->file('ContractGiver_attachment') as $file) {
                    $name = $request->name . 'ContractGiver_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $Cft->ContractGiver_attachment = json_encode($files);
        }

        
        if (!empty ($request->Other1_attachment)) {
            $files = [];
            if ($request->hasfile('Other1_attachment')) {
                foreach ($request->file('Other1_attachment') as $file) {
                    $name = $request->name . 'Other1_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $Cft->Other1_attachment = json_encode($files);
        }
        if (!empty ($request->Other2_attachment)) {
            $files = [];
            if ($request->hasfile('Other2_attachment')) {
                foreach ($request->file('Other2_attachment') as $file) {
                    $name = $request->name . 'Other2_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $Cft->Other2_attachment = json_encode($files);
        }
        if (!empty ($request->Other3_attachment)) {
            $files = [];
            if ($request->hasfile('Other3_attachment')) {
                foreach ($request->file('Other3_attachment') as $file) {
                    $name = $request->name . 'Other3_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $Cft->Other3_attachment = json_encode($files);
        }
        if (!empty ($request->Other4_attachment)) {
            $files = [];
            if ($request->hasfile('Other4_attachment')) {
                foreach ($request->file('Other4_attachment') as $file) {
                    $name = $request->name . 'Other4_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $Cft->Other4_attachment = json_encode($files);
        }
        if (!empty ($request->Other5_attachment)) {
            $files = [];
            if ($request->hasfile('Other5_attachment')) {
                foreach ($request->file('Other5_attachment') as $file) {
                    $name = $request->name . 'Other5_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $Cft->Other5_attachment = json_encode($files);
        }

        $Cft->save();

        /* CFT Fields Ends */

        $counter = DB::table('record_numbers')->value('counter');
        $recordNumber = str_pad($counter, 5, '0', STR_PAD_LEFT);
        $newCounter = $counter + 1;
        DB::table('record_numbers')->update(['counter' => $newCounter]);

        // $externalReview = new ExternalReview();
        // $externalReview->cc_id = $openState->id;
        // $externalReview->process_name = "Global CC";
        // $externalReview->save();

        $history = new GlobalChangeControlAuditTrail;
        $history->cc_id = $openState->id;
        $history->activity_type = 'Inititator';
        $history->previous = "NULL";
        $history->current = Auth::user()->name;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $openState->status;
        $history->change_to =   "Opened";
        $history->change_from = "NULL";
        $history->action_name = 'Create';
        $history->save();

        $history = new GlobalChangeControlAuditTrail;
        $history->cc_id = $openState->id;
        $history->activity_type = 'Initiation Date';
        $history->previous = "NULL";
        $history->current = Helpers::getdateFormat($openState->intiation_date);
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $openState->status;
        $history->change_to =   "Opened";
        $history->change_from = "NULL";
        $history->action_name = 'Create';
        $history->save();

            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $openState->id;
            $history->activity_type = 'Initiation Department';
            $history->previous = "NULL";
            $history->current = Helpers::getFullDepartmentName($openState->Initiator_Group);
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $openState->status;
            $history->change_to =   "Opened";
            $history->change_from = "NULL";
            $history->action_name = 'Create';
            $history->save();

            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $openState->id;
            $history->activity_type = 'Initiation Department Code';
            $history->previous = "NULL";
            $history->current = $openState->initiator_group_code;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $openState->status;
            $history->change_to =   "Opened";
            $history->change_from = "NULL";
            $history->action_name = 'Create';
            $history->save();

            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $openState->id;
            $history->activity_type = 'Short Description';
            $history->previous = "NULL";
            $history->current = $openState->short_description;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $openState->status;
            $history->change_to =   "Opened";
            $history->change_from = "NULL";
            $history->action_name = 'Create';
            $history->save();

            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $openState->id;
            $history->activity_type = 'Due Date';
            $history->previous = "NULL";
            $history->current = Helpers::getdateFormat($request->due_date);
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $openState->status;
            $history->change_to =   "Opened";
            $history->change_from = "NULL";
            $history->action_name = 'Create';
            $history->save();

        if(!empty($request->assign_to)){            
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $openState->id;
            $history->activity_type = 'Assigned To';
            $history->previous = "NULL";
            $history->current = $openState->assign_to;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $openState->status;
            $history->change_to =   "Opened";
            $history->change_from = "NULL";
            $history->action_name = 'Create';
            $history->save();
        }

        if(!empty($request->product_name)){
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $openState->id;
            $history->activity_type = 'Product/Material';
            $history->previous = "NULL";
            $history->current = $openState->product_name;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $openState->status;
            $history->change_to =   "Opened";
            $history->change_from = "NULL";
            $history->action_name = 'Create';
            $history->save();
        }

        if(!empty($request->validation_requirment)){
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $openState->id;
            $history->activity_type = 'Validation Requirement';
            $history->previous = "NULL";
            $history->current = $request->validation_requirment;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $openState->status;
            $history->change_to =   "Opened";
            $history->change_from = "NULL";
            $history->action_name = 'Create';
            $history->save();
        }

        if(!empty($request->severity)){
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $openState->id;
            $history->activity_type = 'Change Related To';
            $history->previous = "NULL";
            $history->current = $openState->severity;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $openState->status;
            $history->change_to =   "Opened";
            $history->change_from = "NULL";
            $history->action_name = 'Create';
            $history->save();
        }

        if(!empty($request->initiated_through)){
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $openState->id;
            $history->activity_type = 'Initiated Through';
            $history->previous = "NULL";
            $history->current = $openState->initiated_through;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $openState->status;
            $history->change_to =   "Opened";
            $history->change_from = "NULL";
            $history->action_name = 'Create';
            $history->save();
        }

        if(!empty($request->initiated_through_req)){
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $openState->id;
            $history->activity_type = 'Others';
            $history->previous = "NULL";
            $history->current = $openState->initiated_through_req;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $openState->status;
            $history->change_to =   "Opened";
            $history->change_from = "NULL";
            $history->action_name = 'Create';
            $history->save();
        }


        if(!empty($request->repeat)){
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $openState->id;
            $history->activity_type = 'Repeat';
            $history->previous = "NULL";
            $history->current = $openState->repeat;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $openState->status;
            $history->change_to =   "Opened";
            $history->change_from = "NULL";
            $history->action_name = 'Create';
            $history->save();
        }

        if(!empty($request->repeat_nature)){
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $openState->id;
            $history->activity_type = 'Repeat Nature';
            $history->previous = "NULL";
            $history->current = $openState->repeat_nature;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $openState->status;
            $history->change_to =   "Opened";
            $history->change_from = "NULL";
            $history->action_name = 'Create';
            $history->save();
        }

        if(!empty($request->others)){
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $openState->id;
            $history->activity_type = 'If Others';
            $history->previous = "NULL";
            $history->current = $openState->others;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $openState->status;
            $history->change_to =   "Opened";
            $history->change_from = "NULL";
            $history->action_name = 'Create';
            $history->save();
        }

        if(!empty($request->priority_data)){            
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $openState->id;
            $history->activity_type = 'Priority';
            $history->previous = "NULL";
            $history->current = $openState->priority_data;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $openState->status;
            $history->change_to =   "Opened";
            $history->change_from = "NULL";
            $history->action_name = 'Create';
            $history->save();
        }

        if(!empty($request->hod_person)){            
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $openState->id;
            $history->activity_type = 'HOD Person';
            $history->previous = "NULL";
            $history->current = Helpers::getInitiatorName($openState->hod_person);
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $openState->status;
            $history->change_to =   "Opened";
            $history->change_from = "NULL";
            $history->action_name = 'Create';
            $history->save();
        }

        if(!empty($request->risk_assessment_required)){            
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $openState->id;
            $history->activity_type = 'Risk Assessment Required';
            $history->previous = "NULL";
            $history->current = $openState->risk_assessment_required;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $openState->status;
            $history->change_to =   "Opened";
            $history->change_from = "NULL";
            $history->action_name = 'Create';
            $history->save();
        }
  
           
        
        if(!empty($request->doc_change)){    
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $openState->id;
            $history->activity_type = 'Nature Of Change';
            $history->previous = "NULL";
            $history->current = $openState->doc_change;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $openState->status;
            $history->change_to =   "Opened";
                $history->change_from = "NULL";
                $history->action_name = 'Create';
            $history->save();
        }

        if(!empty($openState->in_attachment)){    
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $openState->id;
            $history->activity_type = 'Initial Attachment';
            $history->previous = "NULL";
            $history->current = $openState->in_attachment;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $openState->status;
            $history->change_to =   "Opened";
            $history->change_from = "NULL";
            $history->action_name = 'Create';
            $history->save();
        }

        if(!empty($openState->risk_assessment_atch)){    
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $openState->id;
            $history->activity_type = 'Risk Assessment Attachment';
            $history->previous = "NULL";
            $history->current = $openState->risk_assessment_atch;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $openState->status;
            $history->change_to =   "Opened";
            $history->change_from = "NULL";
            $history->action_name = 'Create';
            $history->save();
        }

        if(!empty($openState->HOD_attachment)){    
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $openState->id;
            $history->activity_type = 'HOD Attachments';
            $history->previous = "NULL";
            $history->current = $openState->HOD_attachment;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $openState->status;
            $history->change_to =   "Opened";
            $history->change_from = "NULL";
            $history->action_name = 'Create';
            $history->save();
        }

        if(!empty($review->qa_head)){    
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $openState->id;
            $history->activity_type = 'QA Attachments';
            $history->previous = "NULL";
            $history->current = $review->qa_head;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $openState->status;
            $history->change_to =   "Opened";
            $history->change_from = "NULL";
            $history->action_name = 'Create';
            $history->save();
        }


        if(!empty($Cft->RA_attachment)){    
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $openState->id;
            $history->activity_type = 'RA Attachments';
            $history->previous = "NULL";
            $history->current = $Cft->RA_attachment;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $openState->status;
            $history->change_to =   "Opened";
            $history->change_from = "NULL";
            $history->action_name = 'Create';
            $history->save();
        }

        if(!empty($Cft->Quality_Assurance_attachment)){    
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $openState->id;
            $history->activity_type = 'Quality Assurance Attachments';
            $history->previous = "NULL";
            $history->current = $Cft->Quality_Assurance_attachment;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $openState->status;
            $history->change_to =   "Opened";
            $history->change_from = "NULL";
            $history->action_name = 'Create';
            $history->save();
        }

        if(!empty($Cft->Production_Table_Attachment)){    
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $openState->id;
            $history->activity_type = 'Production Tablet Attachments';
            $history->previous = "NULL";
            $history->current = $Cft->Production_Table_Attachment;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $openState->status;
            $history->change_to =   "Opened";
            $history->change_from = "NULL";
            $history->action_name = 'Create';
            $history->save();
        }

        if(!empty($Cft->ProductionLiquid_attachment)){    
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $openState->id;
            $history->activity_type = 'Production Liquid Attachments';
            $history->previous = "NULL";
            $history->current = $Cft->ProductionLiquid_attachment;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $openState->status;
            $history->change_to =   "Opened";
            $history->change_from = "NULL";
            $history->action_name = 'Create';
            $history->save();
        }

        if(!empty($Cft->Production_Injection_Attachment)){    
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $openState->id;
            $history->activity_type = 'Production Injection Attachments';
            $history->previous = "NULL";
            $history->current = $Cft->Production_Injection_Attachment;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $openState->status;
            $history->change_to =   "Opened";
            $history->change_from = "NULL";
            $history->action_name = 'Create';
            $history->save();
        }

        if(!empty($Cft->Store_attachment)){    
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $openState->id;
            $history->activity_type = 'Store Attachments';
            $history->previous = "NULL";
            $history->current = $Cft->Store_attachment;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $openState->status;
            $history->change_to =   "Opened";
            $history->change_from = "NULL";
            $history->action_name = 'Create';
            $history->save();
        }

        if(!empty($Cft->Quality_Control_attachment)){    
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $openState->id;
            $history->activity_type = 'Quality Control Attachments';
            $history->previous = "NULL";
            $history->current = $Cft->Quality_Control_attachment;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $openState->status;
            $history->change_to =   "Opened";
            $history->change_from = "NULL";
            $history->action_name = 'Create';
            $history->save();
        }

        if(!empty($Cft->ResearchDevelopment_attachment)){    
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $openState->id;
            $history->activity_type = 'Research Development Attachments';
            $history->previous = "NULL";
            $history->current = $Cft->ResearchDevelopment_attachment;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $openState->status;
            $history->change_to =   "Opened";
            $history->change_from = "NULL";
            $history->action_name = 'Create';
            $history->save();
        }

        if(!empty($Cft->Engineering_attachment)){    
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $openState->id;
            $history->activity_type = 'Engineering Attachments';
            $history->previous = "NULL";
            $history->current = $Cft->Engineering_attachment;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $openState->status;
            $history->change_to =   "Opened";
            $history->change_from = "NULL";
            $history->action_name = 'Create';
            $history->save();
        }

        if(!empty($Cft->Human_Resource_attachment)){    
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $openState->id;
            $history->activity_type = 'Human Resource Attachments';
            $history->previous = "NULL";
            $history->current = $Cft->Human_Resource_attachment;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $openState->status;
            $history->change_to =   "Opened";
            $history->change_from = "NULL";
            $history->action_name = 'Create';
            $history->save();
        }

        if(!empty($Cft->Microbiology_attachment)){    
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $openState->id;
            $history->activity_type = 'Microbiology Attachments';
            $history->previous = "NULL";
            $history->current = $Cft->Microbiology_attachment;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $openState->status;
            $history->change_to =   "Opened";
            $history->change_from = "NULL";
            $history->action_name = 'Create';
            $history->save();
        }

        if(!empty($Cft->RegulatoryAffair_attachment)){    
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $openState->id;
            $history->activity_type = 'Regulatory Affair Attachments';
            $history->previous = "NULL";
            $history->current = $Cft->RegulatoryAffair_attachment;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $openState->status;
            $history->change_to =   "Opened";
            $history->change_from = "NULL";
            $history->action_name = 'Create';
            $history->save();
        }

        if(!empty($Cft->CorporateQualityAssurance_attachment)){    
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $openState->id;
            $history->activity_type = 'Corporate Quality Assurance Attachments';
            $history->previous = "NULL";
            $history->current = $Cft->CorporateQualityAssurance_attachment;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $openState->status;
            $history->change_to =   "Opened";
            $history->change_from = "NULL";
            $history->action_name = 'Create';
            $history->save();
        }

        if(!empty($Cft->Environment_Health_Safety_attachment)){    
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $openState->id;
            $history->activity_type = 'Safety Attachments';
            $history->previous = "NULL";
            $history->current = $Cft->Environment_Health_Safety_attachment;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $openState->status;
            $history->change_to =   "Opened";
            $history->change_from = "NULL";
            $history->action_name = 'Create';
            $history->save();
        }

        if(!empty($Cft->Information_Technology_attachment)){    
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $openState->id;
            $history->activity_type = 'Information Technology Attachments';
            $history->previous = "NULL";
            $history->current = $Cft->Information_Technology_attachment;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $openState->status;
            $history->change_to =   "Opened";
            $history->change_from = "NULL";
            $history->action_name = 'Create';
            $history->save();
        }

        if(!empty($Cft->ContractGiver_attachment)){    
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $openState->id;
            $history->activity_type = 'Contract Giver Attachments';
            $history->previous = "NULL";
            $history->current = $Cft->ContractGiver_attachment;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $openState->status;
            $history->change_to =   "Opened";
            $history->change_from = "NULL";
            $history->action_name = 'Create';
            $history->save();
        }

        if(!empty($Cft->Other1_attachment)){    
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $openState->id;
            $history->activity_type = 'Other 1 Attachments';
            $history->previous = "NULL";
            $history->current = $Cft->Other1_attachment;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $openState->status;
            $history->change_to =   "Opened";
            $history->change_from = "NULL";
            $history->action_name = 'Create';
            $history->save();
        }

        if(!empty($Cft->Other2_attachment)){    
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $openState->id;
            $history->activity_type = 'Other 2 Attachments';
            $history->previous = "NULL";
            $history->current = $Cft->Other2_attachment;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $openState->status;
            $history->change_to =   "Opened";
            $history->change_from = "NULL";
            $history->action_name = 'Create';
            $history->save();
        }

        if(!empty($Cft->Other3_attachment)){    
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $openState->id;
            $history->activity_type = 'Other 3 Attachments';
            $history->previous = "NULL";
            $history->current = $Cft->Other3_attachment;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $openState->status;
            $history->change_to =   "Opened";
            $history->change_from = "NULL";
            $history->action_name = 'Create';
            $history->save();
        }

        if(!empty($Cft->Other4_attachment)){    
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $openState->id;
            $history->activity_type = 'Other 4 Attachments';
            $history->previous = "NULL";
            $history->current = $Cft->Other4_attachment;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $openState->status;
            $history->change_to =   "Opened";
            $history->change_from = "NULL";
            $history->action_name = 'Create';
            $history->save();
        }

        if(!empty($Cft->Other5_attachment)){    
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $openState->id;
            $history->activity_type = 'Other 5 Attachments';
            $history->previous = "NULL";
            $history->current = $Cft->Other5_attachment;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $openState->status;
            $history->change_to =   "Opened";
            $history->change_from = "NULL";
            $history->action_name = 'Create';
            $history->save();
        }

        if(!empty($evaluation->qa_eval_attach)){    
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $openState->id;
            $history->activity_type = 'QA Evaluation Attachments';
            $history->previous = "NULL";
            $history->current = $evaluation->qa_eval_attach;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $openState->status;
            $history->change_to =   "Opened";
            $history->change_from = "NULL";
            $history->action_name = 'Create';
            $history->save();
        }

        if(!empty($request->If_Others)){    
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $openState->id;
            $history->activity_type = 'If Others';
            $history->previous = "NULL";
            $history->current = $openState->If_Others;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $openState->status;
            $history->change_to =   "Opened";
                $history->change_from = "NULL";
                $history->action_name = 'Create';
            $history->save();
        }

        if(!empty($request->Division_Code)){    
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $openState->id;
            $history->activity_type = 'Division Code';
            $history->previous = "NULL";
            $history->current = $openState->Division_Code;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $openState->status;
            $history->change_to =   "Opened";
                $history->change_from = "NULL";
                $history->action_name = 'Create';
            $history->save();
        }

        if(!empty($request->current_practice)){    
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $openState->id;
            $history->activity_type = 'Current Practice';
            $history->previous = "NULL";
            $history->current = $openState->current_practice;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $openState->status;
            $history->change_to =   "Opened";
                $history->change_from = "NULL";
                $history->action_name = 'Create';
            $history->save();
        }

        if(!empty($request->proposed_change)){    
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $openState->id;
            $history->activity_type = 'Proposed Change';
            $history->previous = "NULL";
            $history->current = $openState->proposed_change;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $openState->status;
            $history->change_to =   "Opened";
                $history->change_from = "NULL";
                $history->action_name = 'Create';
            $history->save();
        }

        if(!empty($request->other_comment)){    
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $openState->id;
            $history->activity_type = 'Reason for Change';
            $history->previous = "NULL";
            $history->current = $openState->other_comment;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $openState->status;
            $history->change_to =   "Opened";
                $history->change_from = "NULL";
                $history->action_name = 'Create';
            $history->save();
        }

        // if(!empty($request->supervisor_comment)){    
        //     $history = new GlobalChangeControlAuditTrail;
        //     $history->cc_id = $openState->id;
        //     $history->activity_type = 'Supervisor Comments';
        //     $history->previous = "NULL";
        //     $history->current = $openState->supervisor_comment;
        //     $history->comment = "Not Applicable";
        //     $history->user_id = Auth::user()->id;
        //     $history->user_name = Auth::user()->name;
        //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        //     $history->origin_state = $openState->status;
        //     $history->change_to =   "Opened";
        //         $history->change_from = "NULL";
        //         $history->action_name = 'Create';
        //     $history->save();
        // }

        if(!empty($request->type_chnage)){    
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $openState->id;
            $history->activity_type = 'Type of Change';
            $history->previous = "NULL";
            $history->current = $openState->type_chnage;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $openState->status;
            $history->change_to =   "Opened";
                $history->change_from = "NULL";
                $history->action_name = 'Create';
            $history->save();
        }

        if(!empty($request->qa_head)){    
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $openState->id;
            $history->activity_type = 'QA Attachments';
            $history->previous = "NULL";
            $history->current = $openState->qa_head;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $openState->status;
            $history->change_to =   "Opened";
                $history->change_from = "NULL";
                $history->action_name = 'Create';
            $history->save();
        }


        if(!empty($request->qa_comments)){    
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $openState->id;
            $history->activity_type = 'QA Review Comments';
            $history->previous = "NULL";
            $history->current = $openState->qa_comments;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $openState->status;
            $history->change_to =   "Opened";
                $history->change_from = "NULL";
                $history->action_name = 'Create';
            $history->save();
        }

        if(!empty($request->related_records)){    
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $openState->id;
            $history->activity_type = 'Related Records';
            $history->previous = "NULL";
            $history->current = $openState->related_records;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $openState->status;
            $history->change_to =   "Opened";
                $history->change_from = "NULL";
                $history->action_name = 'Create';
            $history->save();
        }

        if(!empty($evaluation->qa_eval_comments)){    
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $openState->id;
            $history->activity_type = 'QA Evaluation Comments';
            $history->previous = "NULL";
            $history->current = $evaluation->qa_eval_comments;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $openState->status;
            $history->change_to =   "Opened";
            $history->change_from = "NULL";
            $history->action_name = 'Create';
            $history->save();
        }


        if(!empty($request->qa_eval_attach)){    
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $openState->id;
            $history->activity_type = 'QA Evaluation Attachments';
            $history->previous = "NULL";
            $history->current = $openState->qa_eval_attach;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $openState->status;
            $history->change_to =   "Opened";
                $history->change_from = "NULL";
                $history->action_name = 'Create';
            $history->save();
        }

        if(!empty($request->train_comments)){    
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $openState->id;
            $history->activity_type = 'Training Comments';
            $history->previous = "NULL";
            $history->current = $openState->train_comments;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $openState->status;
            $history->change_to =   "Opened";
                $history->change_from = "NULL";
                $history->action_name = 'Create';
            $history->save();
        }


        if(!empty($request->training_required)){    
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $openState->id;
            $history->activity_type = 'Training Required';
            $history->previous = "NULL";
            $history->current = $openState->training_required;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $openState->status;
            $history->change_to =   "Opened";
                $history->change_from = "NULL";
                $history->action_name = 'Create';
            $history->save();
        }
        
        if(!empty($request->Microbiology)){    
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $openState->id;
            $history->activity_type = 'CFT Reviewer';
            $history->previous = "NULL";
            $history->current = $openState->Microbiology;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $openState->status;
            $history->change_to =   "Opened";
                $history->change_from = "NULL";
                $history->action_name = 'Create';
            $history->save();
        }


        if(!empty($request->Microbiology_Person)){    
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $openState->id;
            $history->activity_type = 'CFT Reviewer Person';
            $history->previous = "NULL";
            $history->current = $openState->Microbiology_Person;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $openState->status;
            $history->change_to =   "Opened";
                $history->change_from = "NULL";
                $history->action_name = 'Create';
            $history->save();
        }

        if(!empty($request->qa_comments)){    
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $openState->id;
            $history->activity_type = 'QA Comments';
            $history->previous = "NULL";
            $history->current = $openState->qa_comments;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $openState->status;
            $history->change_to =   "Opened";
                $history->change_from = "NULL";
                $history->action_name = 'Create';
            $history->save();
        }

        if(!empty($request->designee_comments)){    
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $openState->id;
            $history->activity_type = 'QA Head Designee Comments';
            $history->previous = "NULL";
            $history->current = $openState->designee_comments;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $openState->status;
            $history->change_to =   "Opened";
                $history->change_from = "NULL";
                $history->action_name = 'Create';
            $history->save();
        }

        if(!empty($request->Warehouse_comments)){    
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $openState->id;
            $history->activity_type = 'Warehouse Comments';
            $history->previous = "NULL";
            $history->current = $openState->Warehouse_comments;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $openState->status;
            $history->change_to =   "Opened";
                $history->change_from = "NULL";
                $history->action_name = 'Create';
            $history->save();
        }
        if(!empty($request->Engineering_comments)){    
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $openState->id;
            $history->activity_type = 'Engineering Comments';
            $history->previous = "NULL";
            $history->current = $openState->Engineering_comments;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $openState->status;
            $history->change_to =   "Opened";
                $history->change_from = "NULL";
                $history->action_name = 'Create';
            $history->save();
        }
        if(!empty($request->Instrumentation_comments)){    
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $openState->id;
            $history->activity_type = 'Instrumentation Comments';
            $history->previous = "NULL";
            $history->current = $openState->Instrumentation_comments;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $openState->status;
            $history->change_to =   "Opened";
                $history->change_from = "NULL";
                $history->action_name = 'Create';
            $history->save();
        }
        if(!empty($request->Validation_comments)){    
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $openState->id;
            $history->activity_type = 'Validation Comments';
            $history->previous = "NULL";
            $history->current = $openState->Validation_comments;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $openState->status;
            $history->change_to =   "Opened";
                $history->change_from = "NULL";
                $history->action_name = 'Create';
            $history->save();
        }
        if(!empty($request->Others_comments)){    
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $openState->id;
            $history->activity_type = 'Others Comments';
            $history->previous = "NULL";
            $history->current = $openState->Others_comments;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $openState->status;
            $history->change_to =   "Opened";
                $history->change_from = "NULL";
                $history->action_name = 'Create';
            $history->save();
        }
        if(!empty($request->Group_comments)){    
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $openState->id;
            $history->activity_type = 'Comments';
            $history->previous = "NULL";
            $history->current = $openState->Group_comments;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $openState->status;
            $history->change_to =   "Opened";
                $history->change_from = "NULL";
                $history->action_name = 'Create';
            $history->save();
        }

        if(!empty($comments->group_attachments)){    
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $openState->id;
            $history->activity_type = 'Attachments';
            $history->previous = "NULL";
            $history->current = $comments->group_attachments;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $openState->status;
            $history->change_to =   "Opened";
                $history->change_from = "NULL";
                $history->action_name = 'Create';
            $history->save();
        }

        if(!empty($request->risk_identification)){    
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $openState->id;
            $history->activity_type = 'Risk Identification';
            $history->previous = "NULL";
            $history->current = $openState->risk_identification;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $openState->status;
            $history->change_to =   "Opened";
                $history->change_from = "NULL";
                $history->action_name = 'Create';
            $history->save();
        }

        if(!empty($request->Occurance)){    
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $openState->id;
            $history->activity_type = 'Occurance';
            $history->previous = "NULL";

            if($request->Occurance == 1){
                $history->current = "Very Likely";
            } elseif($request->Occurance == 2){
                $history->current = "Likely";
            } elseif($request->Occurance == 3){
                $history->current = "Unlikely";
            }elseif ($request->Occurance == 4){
                $history->current = "Rare";
            }else {
                $history->current = "Extremely Unlikely";
            }

            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $openState->status;
            $history->change_to =   "Opened";
            $history->change_from = "NULL";
            $history->action_name = 'Create';
            $history->save();
        }

        if(!empty($request->Detection)){    
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $openState->id;
            $history->activity_type = 'Detection';
            $history->previous = "NULL";
            
            if($request->Detection == 1){
                $history->current = "Likely";
            } elseif($request->Detection == 2){
                $history->current = "Unlikely";
            } elseif($request->Detection == 3){
                $history->current = "Rare";
            } else {
                $history->current = "Impossible";
            }

            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $openState->status;
            $history->change_to =   "Opened";
            $history->change_from = "NULL";
            $history->action_name = 'Create';
            $history->save();
        }

        if(!empty($request->RPN)){    
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $openState->id;
            $history->activity_type = 'RPN';
            $history->previous = "NULL";
            $history->current = $openState->RPN;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $openState->status;
            $history->change_to =   "Opened";
                $history->change_from = "NULL";
                $history->action_name = 'Create';
            $history->save();
        }


        if(!empty($request->risk_evaluation)){    
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $openState->id;
            $history->activity_type = 'Risk Evaluation';
            $history->previous = "NULL";
            $history->current = $openState->risk_evaluation;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $openState->status;
            $history->change_to =   "Opened";
                $history->change_from = "NULL";
                $history->action_name = 'Create';
            $history->save();
        }

        if(!empty($request->migration_action)){    
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $openState->id;
            $history->activity_type = 'comments';
            $history->previous = "NULL";
            $history->current = $openState->migration_action;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $openState->status;
            $history->change_to =   "Opened";
                $history->change_from = "NULL";
                $history->action_name = 'Create';
            $history->save();
        }
        if(!empty($request->qa_appro_comments)){    
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $openState->id;
            $history->activity_type = 'QA Approval Commnent';
            $history->previous = "NULL";
            $history->current = $openState->qa_appro_comments;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $openState->status;
            $history->change_to =   "Opened";
                $history->change_from = "NULL";
                $history->action_name = 'Create';
            $history->save();
        }
        if(!empty($request->feedback)){    
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $openState->id;
            $history->activity_type = 'Feedback';
            $history->previous = "NULL";
            $history->current = $openState->feedback;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $openState->status;
            $history->change_to =   "Opened";
                $history->change_from = "NULL";
                $history->action_name = 'Create';
            $history->save();
        }

        if(!empty($approcomments->tran_attach)){    
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $openState->id;
            $history->activity_type = 'Training Attachments';
            $history->previous = "NULL";
            $history->current = $approcomments->tran_attach;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $openState->status;
            $history->change_to =   "Opened";
                $history->change_from = "NULL";
                $history->action_name = 'Create';
            $history->save();
        }

        if(!empty($request->qa_closure_comments)){    
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $openState->id;
            $history->activity_type = 'QA Closure Comments';
            $history->previous = "NULL";
            $history->current = $openState->qa_closure_comments;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $openState->status;
            $history->change_to =   "Opened";
                $history->change_from = "NULL";
                $history->action_name = 'Create';
            $history->save();
        }
        if(!empty($request->Effectiveness_checker)){    
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $openState->id;
            $history->activity_type = 'Effectiveness Check';
            $history->previous = "NULL";
            $history->current = $openState->Effectiveness_checker;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $openState->status;
            $history->change_to =   "Opened";
                $history->change_from = "NULL";
                $history->action_name = 'Create';
            $history->save();
        }
        if(!empty($request->feedbackeffective_check)){    
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $openState->id;
            $history->activity_type = 'Feedback';
            $history->previous = "NULL";
            $history->current = $openState->feedbackeffective_check;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $openState->status;
            $history->change_to =   "Opened";
                $history->change_from = "NULL";
                $history->action_name = 'Create';
            $history->save();
        }

        if(!empty($request->feedbackeffective_check_date)){    
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $openState->id;
            $history->activity_type = 'Effectiveness Check Date';
            $history->previous = "NULL";
            $history->current = $openState->feedbackeffective_check_date;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $openState->status;
            $history->change_to =   "Opened";
                $history->change_from = "NULL";
                $history->action_name = 'Create';
            $history->save();
        }

        if(!empty($closure->attach_list)){    
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $openState->id;
            $history->activity_type = 'List Of Attachments 2';
            $history->previous = "NULL";
            $history->current = $closure->attach_list;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $openState->status;
            $history->change_to =   "Opened";
                $history->change_from = "NULL";
                $history->action_name = 'Create';
            $history->save();
        }

        return redirect('rcms/qms-dashboard');
    }

    public function show($id)
    {
        $data = GlobalChangeControl::find($id);
        $userIds = explode(',', $data->external_users);
        // $userReviews = ExternalReview::where(['cc_id' => $id, "process_name" => "GlobalCC"])->get();

        // $loggedInUserId = Auth::id();
        // $isUserReviewExist = $userReviews->contains(function ($review) use ($loggedInUserId) {
        //     return $review->user_id === $loggedInUserId;
        // });

        // $rows = [];
        // foreach ($userIds as $userId) {
        //     $userReview = $userReviews->firstWhere('user_id', $userId);
        //     if (!$userReview) {
        //         $userReview = new ExternalReview([
        //             'user_id' => $userId,
        //             "process_name" => "GlobalCC",
        //             'external_review_attachment' => null,
        //             'external_review_comment' => null,
        //         ]);
        //     }
        //     $rows[] = $userReview;
        // }

        $getImpactData  = GlobalImpactAssessment::where('cc_id' , $id)->first();
        // $getExternalData = ExternalReview::where(['cc_id' => $id, "process_name" => "GlobalCC"])->first();
        $cftReviewerIds = explode(',', $data->reviewer_person_value);
        $cc_lid = $data->id;
        $data->originator = User::where('id', $data->initiator_id)->value('name');
        $division = GlobalChangeControl::where('global_change_controls.id', $id)->leftjoin('q_m_s_divisions', 'q_m_s_divisions.id', 'global_change_controls.division_id')->first(['name']);

        $docdetail = Docdetail::where('cc_id', $id)->first();
        $review = Qareview::where('cc_id', $id)->first();
        $cc_cfts = GlobalChangeControlCft::where('cc_id', $id)->first();
        $fields = ChangeControlFields::where('cc_id', $id)->first();

        $evaluation = Evaluation::where('cc_id', $id)->first();
        $info = AdditionalInformation::where('cc_id', $id)->first();
        $comments = GroupComments::where('cc_id', $id)->first();
        $data1  = ChangeControlComment::where('cc_id', $id)->first();
        
        $approcomments = QaApprovalComments::where('cc_id', $id)->first();
        $closure = ChangeClosure::where('cc_id', $id)->first();
        $hod = User::get();
        $cft = User::get();
        $pre = GlobalChangeControl::all();        
        $previousRelated = explode(',', $data->related_records);

        $preRiskAssessment = RiskManagement::all();
        $due_date_extension = $data->due_date_extension;


        $due_date_extension = $data->due_date_extension;
        $impactassement   =  table_cc_impactassement::where('cc_id', $id)->get();
        return view('frontend.global-cc.edit', compact(
            'data',
            'docdetail',
            // 'rows',
            'cftReviewerIds',
            'data1',
            'preRiskAssessment',
            'review',
            'evaluation',
            // 'getExternalData',
            'fields',
            'info',
            'getImpactData',
            'division',
            'cc_cfts',
            'comments',
            'impactassement',
            // 'assessment',
            'approcomments',
            'closure',
            "hod",
            "cft",
            "due_date_extension",
            "cc_lid",
            "pre",
            "previousRelated",
            // "isUserReviewExist",
            // "userReviews",
        ));
    }

    public function update(Request $request, $id)
    {
        $lastDocCft = GlobalChangeControlCft::where('cc_id', $id)->first();
        $fields = GlobalChangeControl::find($id);

        $lastDocument = GlobalChangeControl::find($id);
        $openState = GlobalChangeControl::find($id);
        $cc_cfts = GlobalChangeControlCft::find($id);
        $lastCft = GlobalChangeControlCft::where('cc_id', $openState->id)->first();
        $review = Qareview::where('cc_id', $openState->id)->first();
        $Cft = GlobalChangeControlCft::where('cc_id', $id)->first();
    
        
        $openState->severity_level1 = $request->severity_level1;
        $openState->product_name = $request->product_name;
        $openState->Initiator_Group = $request->Initiator_Group;
        $openState->initiator_group_code = $request->initiator_group_code;
        $openState->short_description = $request->short_description;
        $openState->priority_data = $request->priority_data;
        $openState->risk_assessment_required = $request->risk_assessment_required;
        $openState->hod_person = $request->hod_person;
        $openState->doc_change = $request->doc_change;
        $openState->If_Others = $request->others;
        $openState->initiated_through = $request->initiated_through;
        $openState->initiated_through_req = $request->initiated_through_req;

        $openState->repeat = $request->repeat;
        $openState->repeat_nature = $request->repeat_nature;
        $openState->current_practice = $request->current_practice;
        $openState->proposed_change = $request->proposed_change;
        $openState->reason_change = $request->reason_change;
        $openState->other_comment = $request->other_comment;

        $openState->qa_comments = $request->qa_comments;

        $openState->risk_identification = $request->risk_identification;
        $openState->severity = $request->severity;
        $openState->Occurance = $request->Occurance;
        $openState->migration_action = $request->migration_action;

        $openState->qa_appro_comments = $request->qa_appro_comments;

        $openState->qa_closure_comments = $request->qa_closure_comments;
        $openState->due_date_extension = $request->due_date_extension;

        $openState->qa_head = $request->qa_head;
        // $openState->related_records = implode(',', $request->related_records);

        $openState->feedback = $request->feedback;
        if (!empty($request->tran_attach)) {
            $files = [];
            if ($request->hasfile('tran_attach')) {
                foreach ($request->file('tran_attach') as $file) {
                    $name = "GlobalCC" . '-tran_attach' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $openState->tran_attach = json_encode($files);
        }

        
        $openState->qa_eval_comments = $request->qa_eval_comments;
        if (!empty($request->qa_eval_attach)) {
            $files = [];
            if ($request->hasfile('qa_eval_attach')) {
                foreach ($request->file('qa_eval_attach') as $file) {
                    $name = "GlobalCC" . '-qa_eval_attach' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $openState->qa_eval_attach = json_encode($files);
        }

        if (!empty($request->in_attachment)) {
            $files = [];
            if ($request->hasfile('in_attachment')) {
                foreach ($request->file('in_attachment') as $file) {
                    $name = "GlobalCC" . '-in_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $openState->in_attachment = json_encode($files);
        }

        if (!empty($request->risk_assessment_atch)) {
            $files = [];
            if ($request->hasfile('risk_assessment_atch')) {
                foreach ($request->file('risk_assessment_atch') as $file) {
                    $name = "GlobalCC" . '-risk_assessment_atch' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $openState->risk_assessment_atch = json_encode($files);
        }

        if (!empty($request->hod_assessment_attachment)) {
            $files = [];
            if ($request->hasfile('hod_assessment_attachment')) {
                foreach ($request->file('hod_assessment_attachment') as $file) {
                    $name = "GlobalCC" . '-hod_assessment_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $openState->hod_assessment_attachment = json_encode($files);
        }
        
        $openState->hod_assessment_comments = $request->hod_assessment_comments;
        $openState->qa_review_comments = $request->qa_review_comments;


        if (!empty($request->qa_final_attach)) {
            $files = [];
            if ($request->hasfile('qa_final_attach')) {
                foreach ($request->file('qa_final_attach') as $file) {
                    $name = "GlobalCC" . '-qa_final_attach' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $openState->qa_final_attach = json_encode($files);
        }
        $openState->qa_final_comments = $request->qa_final_comments;
        $openState->QA_CQA_person = $request->QA_CQA_person;
        $openState->RA_data_person = $request->RA_data_person;

        if (!empty($request->intial_update_attach)) {
            $files = [];
            if ($request->hasfile('intial_update_attach')) {
                foreach ($request->file('intial_update_attach') as $file) {
                    $name = "GlobalCC" . '-intial_update_attach' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $openState->intial_update_attach = json_encode($files);
        }
        $openState->intial_update_comments = $request->intial_update_comments;

        if (!empty($request->hod_final_review_attach)) {
            $files = [];
            if ($request->hasfile('hod_final_review_attach')) {
                foreach ($request->file('hod_final_review_attach') as $file) {
                    $name = "GlobalCC" . '-hod_final_review_attach' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $openState->hod_final_review_attach = json_encode($files);
        }
        $openState->hod_final_review_comment = $request->hod_final_review_comment;
        $openState->implementation_verification_comments = $request->implementation_verification_comments;
        $openState->qa_cqa_comments = $request->qa_cqa_comments;

        if (!empty($request->attach_list)) {
            $files = [];
            if ($request->hasfile('attach_list')) {
                foreach ($request->file('attach_list') as $file) {
                    $name = "GlobalCC" . '-attach_list' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $openState->attach_list = json_encode($files);
        }
        if (!empty($request->qa_cqa_attach)) {
            $files = [];
            if ($request->hasfile('qa_cqa_attach')) {
                foreach ($request->file('qa_cqa_attach') as $file) {
                    $name = "GlobalCC" . '-qa_cqa_attach' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $openState->qa_cqa_attach = json_encode($files);
        }
        if($openState->stage == 3){
            $initiationDate = Carbon::createFromFormat('Y-m-d', $lastDocument->intiation_date);
            $daysToAdd = $request->due_days;
            $dueDate = $initiationDate->addDays($daysToAdd);
            $openState->record_number = $request->record_number;
        }

        $openState->external_users = implode(',',$request->external_users);
        // $userIds = explode(',', $openState->external_users);
        // $users = User::whereIn('id', $userIds)->get();
        // $userId = $users->pluck('id');
        // if(!empty($userId)){
        //     foreach ($userId as $users) {
        //         $data = ExternalReview::where(['cc_id' => $lastDocument->id, "user_id" => $users])->where(['process_name' => "GlobalCC"])->firstOrCreate();
        //         $data->cc_id = $id;
        //         $data->process_name = "GlobalCC";
        //         $data->user_id = $users;
        //         $data->save();
        //     }
        // }
        // foreach ($userIds as $userId) {
        //     if (empty($userId)) {
        //         continue;
        //     }
        //     NotificationUser::updateOrCreate([
        //         'record_id' => $id,
        //         'record_type' => "GlobalCC",
        //         'from_id' => Auth::user()->id,
        //         'to_id' => $userId,
        //     ]);
        
        //     if ($userId != auth()->user()->id) {
        //         continue;
        //     }
        
        //     $attachment = $request->file("user_reviews.{$userId}.external_review_attachment");
        //     $attachmentPath = null;
        
        //     if ($attachment) {
        //         $attachmentPath = 'uploads/' . $attachment->getClientOriginalName();
        //         $attachment->move(public_path('uploads'), $attachmentPath);
        //     } else {
        //         $existingReview = ExternalReview::where('cc_id', $id)->where('user_id', $userId)->where(['process_name' => "GlobalCC"])->first();
        //         if ($existingReview) {
        //             $attachmentPath = $existingReview->external_review_attachment;
        //         }
        //     }
        
        //     $comment = $request->input("user_reviews.{$userId}.external_review_comment");
        
        //     if ($userId) {
        //         if (isset($lastDocument) && isset($lastDocument->id)) {
        //             $update = ExternalReview::where(['cc_id' => $lastDocument->id, 'user_id' => $userId])->where(['process_name' => "GlobalCC"])->firstOrCreate();
        //             $update->external_review_comment = $comment;
        //             $update->cc_id = $id;
        //             $update->process_name = "GlobalCC";
        //             $update->user_id = $userId;
        //             $update->external_review_attachment = $attachmentPath;
        //             $update->save();
        //         } else {
        //             Log::error('Last document ID is null or invalid');
        //         }
        //     }
        // }
        

        $openState->update();

        $comments = ChangeControlComment::where('cc_id', $id)->firstOrCreate();
        $comments->cc_id = $id;
        $comments->save();

        $impactChecklist = GlobalImpactAssessment::where(['cc_id' => $id])->first();
        $impactChecklist->cc_id = $id;
        $impactChecklist->remark_que1 = $request->remark_que1;
        $impactChecklist->remark_que2 = $request->remark_que2;
        $impactChecklist->remark_que3 = $request->remark_que3;
        $impactChecklist->remark_que4 = $request->remark_que4;
        $impactChecklist->remark_que5 = $request->remark_que5;
        $impactChecklist->remark_que6 = $request->remark_que6;
        $impactChecklist->remark_que7 = $request->remark_que7;
        $impactChecklist->remark_que8 = $request->remark_que8;
        $impactChecklist->remark_que9 = $request->remark_que9;
        $impactChecklist->remark_que10 = $request->remark_que10;
        $impactChecklist->remark_que11 = $request->remark_que11;
        $impactChecklist->remark_que12 = $request->remark_que12;
        $impactChecklist->remark_que13 = $request->remark_que13;
        $impactChecklist->remark_que14 = $request->remark_que14;
        $impactChecklist->remark_que15 = $request->remark_que15;
        $impactChecklist->remark_que16 = $request->remark_que16;
        $impactChecklist->remark_que17 = $request->remark_que17;
        $impactChecklist->remark_que18 = $request->remark_que18;
        $impactChecklist->remark_que19 = $request->remark_que19;
        $impactChecklist->remark_que20 = $request->remark_que20;
        $impactChecklist->remark_que21 = $request->remark_que21;
        $impactChecklist->remark_que22 = $request->remark_que22;
        $impactChecklist->remark_que23 = $request->remark_que23;
        $impactChecklist->remark_que24 = $request->remark_que24;
        $impactChecklist->remark_que25 = $request->remark_que25;
        $impactChecklist->remark_que26 = $request->remark_que26;
        $impactChecklist->remark_que27 = $request->remark_que27;
        $impactChecklist->remark_que28 = $request->remark_que28;
        $impactChecklist->remark_que29 = $request->remark_que29;
        $impactChecklist->remark_que30 = $request->remark_que30;
        $impactChecklist->remark_que31 = $request->remark_que31;
        $impactChecklist->remark_que32 = $request->remark_que32;
        $impactChecklist->remark_que33 = $request->remark_que33;
        $impactChecklist->update();        
        

        /*********** CFT Code starts **********/
        if($openState->stage == 3 || $openState->stage == 4 ){

            $Cft = GlobalChangeControlCft::withoutTrashed()->where('cc_id', $id)->first();
            if($Cft && $openState->stage == 4 ){
                $Cft->Production_Review = $request->Production_Review == null ? $Cft->Production_Review : $request->Production_Review;
                $Cft->Production_person = $request->Production_person == null ? $Cft->Production_person : $request->Production_person;
                
                $Cft->Quality_review = $request->Quality_review == null ? $Cft->Quality_review : $request->Quality_review;
                $Cft->Quality_Control_Person = $request->Quality_Control_Person == null ? $Cft->Quality_Control_Person : $request->Quality_Control_Person;

                $Cft->Warehouse_review = $request->Warehouse_review == null ? $Cft->Warehouse_review : $request->Warehouse_review;
                $Cft->Warehouse_person = $request->Warehouse_person == null ? $Cft->Warehouse_person : $request->Warehouse_person;
                
                $Cft->Engineering_review = $request->Engineering_review == null ? $Cft->Engineering_review : $request->Engineering_review;
                $Cft->Engineering_person = $request->Engineering_person == null ? $Cft->Engineering_person : $request->Engineering_person;

                $Cft->ResearchDevelopment_Review = $request->ResearchDevelopment_Review == null ? $Cft->ResearchDevelopment_Review : $request->ResearchDevelopment_Review;
                $Cft->ResearchDevelopment_person = $request->ResearchDevelopment_person == null ? $Cft->ResearchDevelopment_person : $request->ResearchDevelopment_person;

                $Cft->RegulatoryAffair_Review = $request->RegulatoryAffair_Review == null ? $Cft->RegulatoryAffair_Review : $request->RegulatoryAffair_Review;
                $Cft->RegulatoryAffair_person = $request->RegulatoryAffair_person == null ? $Cft->RegulatoryAffair_person : $request->RegulatoryAffair_person;

                $Cft->CQA_Review = $request->CQA_Review == null ? $Cft->CQA_Review : $request->CQA_Review;
                $Cft->CQA_person = $request->CQA_person == null ? $Cft->CQA_person : $request->CQA_person;

                $Cft->Microbiology_Review = $request->Microbiology_Review == null ? $Cft->Microbiology_Review : $request->Microbiology_Review;
                $Cft->Microbiology_person = $request->Microbiology_person == null ? $Cft->Microbiology_person : $request->Microbiology_person;

                $Cft->SystemIT_Review = $request->SystemIT_Review == null ? $Cft->SystemIT_Review : $request->SystemIT_Review;
                $Cft->SystemIT_person = $request->SystemIT_person == null ? $Cft->SystemIT_person : $request->SystemIT_person;
                
                $Cft->Quality_Assurance_Review = $request->Quality_Assurance_Review == null ? $Cft->Quality_Assurance_Review : $request->Quality_Assurance_Review;
                $Cft->QualityAssurance_person = $request->QualityAssurance_person == null ? $Cft->QualityAssurance_person : $request->QualityAssurance_person;

                $Cft->Human_Resource_review = $request->Human_Resource_review == null ? $Cft->Human_Resource_review : $request->Human_Resource_review;
                $Cft->Human_Resource_person = $request->Human_Resource_person == null ? $Cft->Human_Resource_person : $request->Human_Resource_person;
                
                $Cft->Other1_review = $request->Other1_review  == null ? $Cft->Other1_review : $request->Other1_review;
                $Cft->Other1_person = $request->Other1_person  == null ? $Cft->Other1_person : $request->Other1_person;
                $Cft->Other1_Department_person = $request->Other1_Department_person  == null ? $Cft->Other1_Department_person : $request->Other1_Department_person;

                $Cft->Other2_review = $request->Other2_review  == null ? $Cft->Other2_review : $request->Other2_review;
                $Cft->Other2_person = $request->Other2_person  == null ? $Cft->Other2_person : $request->Other2_person;
                $Cft->Other2_Department_person = $request->Other2_Department_person  == null ? $Cft->Other2_Department_person : $request->Other2_Department_person;

                $Cft->Other3_review = $request->Other3_review  == null ? $Cft->Other3_review : $request->Other3_review;
                $Cft->Other3_person = $request->Other3_person  == null ? $Cft->Other3_person : $request->Other3_person;
                $Cft->Other3_Department_person = $request->Other3_Department_person  == null ? $Cft->Other3_Department_person : $request->Other3_Department_person;
                
                $Cft->Other4_review = $request->Other4_review  == null ? $Cft->Other4_review : $request->Other4_review;
                $Cft->Other4_person = $request->Other4_person  == null ? $Cft->Other4_person : $request->Other4_person;
                $Cft->Other4_Department_person = $request->Other4_Department_person  == null ? $Cft->Other4_Department_person : $request->Other4_Department_person;

                $Cft->Other5_review = $request->Other5_review  == null ? $Cft->Other5_review : $request->Other5_review;
                $Cft->Other5_person = $request->Other5_person  == null ? $Cft->Other5_person : $request->Other5_person;
                $Cft->Other5_Department_person = $request->Other5_Department_person  == null ? $Cft->Other5_Department_person : $request->Other5_Department_person;

            }
            else{
                $Cft->Production_Review = $request->Production_Review;
                $Cft->Production_person = $request->Production_person;

                $Cft->Warehouse_review = $request->Warehouse_review;
                $Cft->Warehouse_person = $request->Warehouse_person;

                $Cft->Quality_review = $request->Quality_review;
                $Cft->Quality_Control_Person = $request->Quality_Control_Person;
                
                $Cft->Engineering_review = $request->Engineering_review;
                $Cft->Engineering_person = $request->Engineering_person;

                $Cft->ResearchDevelopment_Review = $request->ResearchDevelopment_Review;
                $Cft->ResearchDevelopment_person = $request->ResearchDevelopment_person;

                $Cft->RegulatoryAffair_Review = $request->RegulatoryAffair_Review;
                $Cft->RegulatoryAffair_person = $request->RegulatoryAffair_person;

                $Cft->CQA_Review = $request->CQA_Review;
                $Cft->CQA_person = $request->CQA_person;

                $Cft->Microbiology_Review = $request->Microbiology_Review;
                $Cft->Microbiology_person = $request->Microbiology_person;

                $Cft->SystemIT_Review = $request->SystemIT_Review;
                $Cft->SystemIT_person = $request->SystemIT_person;
                
                $Cft->Quality_Assurance_Review = $request->Quality_Assurance_Review;
                $Cft->QualityAssurance_person = $request->QualityAssurance_person;

                $Cft->Human_Resource_review = $request->Human_Resource_review;
                $Cft->Human_Resource_person = $request->Human_Resource_person;
                
                $Cft->Other1_review = $request->Other1_review;
                $Cft->Other1_person = $request->Other1_person;
                $Cft->Other1_Department_person = $request->Other1_Department_person;

                $Cft->Other2_review = $request->Other2_review;
                $Cft->Other2_person = $request->Other2_person;
                $Cft->Other2_Department_person = $request->Other2_Department_person;

                $Cft->Other3_review = $request->Other3_review;
                $Cft->Other3_person = $request->Other3_person;
                $Cft->Other3_Department_person = $request->Other3_Department_person;
                
                $Cft->Other4_review = $request->Other4_review;
                $Cft->Other4_person = $request->Other4_person;
                $Cft->Other4_Department_person = $request->Other4_Department_person;

                $Cft->Other5_review = $request->Other5_review;
                $Cft->Other5_person = $request->Other5_person;
                $Cft->Other5_Department_person = $request->Other5_Department_person;

            }
        
            $Cft->Production_assessment = $request->Production_assessment;
            $Cft->Production_feedback = $request->Production_feedback;

            $Cft->Quality_Control_assessment = $request->Quality_Control_assessment;
            $Cft->Quality_Control_feedback = $request->Quality_Control_feedback;

            $Cft->Warehouse_assessment = $request->Warehouse_assessment;
            $Cft->Warehouse_feedback = $request->Warehouse_feedback;

            $Cft->Engineering_assessment = $request->Engineering_assessment;
            $Cft->Engineering_feedback = $request->Engineering_feedback;

            $Cft->ResearchDevelopment_assessment = $request->ResearchDevelopment_assessment;
            $Cft->ResearchDevelopment_feedback = $request->ResearchDevelopment_feedback;

            $Cft->RegulatoryAffair_assessment = $request->RegulatoryAffair_assessment;
            $Cft->RegulatoryAffair_feedback = $request->RegulatoryAffair_feedback;

            $Cft->CQA_comment = $request->CQA_comment;

            $Cft->Microbiology_assessment = $request->Microbiology_assessment;
            $Cft->Microbiology_feedback = $request->Microbiology_feedback;

            $Cft->SystemIT_comment = $request->SystemIT_comment;

            $Cft->QualityAssurance_assessment = $request->QualityAssurance_assessment;
            $Cft->QualityAssurance_feedback = $request->QualityAssurance_feedback;

            $Cft->Human_Resource_assessment = $request->Human_Resource_assessment;
            $Cft->Human_Resource_feedback = $request->Human_Resource_feedback;
            
            $Cft->Other1_Department_person = $request->Other1_Department_person;
            $Cft->Other1_assessment = $request->Other1_assessment;

            $Cft->Other2_Department_person = $request->Other2_Department_person;
            $Cft->Other2_Assessment = $request->Other2_Assessment;

            $Cft->Other3_Department_person = $request->Other3_Department_person;
            $Cft->Other3_Assessment = $request->Other3_Assessment;

            $Cft->Other4_Department_person = $request->Other4_Department_person;
            $Cft->Other4_Assessment = $request->Other4_Assessment;

            $Cft->Other5_Department_person = $request->Other5_Department_person;
            $Cft->Other5_Assessment = $request->Other5_Assessment;


            if (!empty ($request->production_attachment)) {
                $files = [];
                if ($request->hasfile('production_attachment')) {
                    foreach ($request->file('production_attachment') as $file) {
                        $name = $request->name . 'production_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                        $file->move('upload/', $name);
                        $files[] = $name;
                    }
                }
                $Cft->production_attachment = json_encode($files);
            }
            
            if (!empty ($request->Quality_Control_attachment)) {
                $files = [];
                if ($request->hasfile('Quality_Control_attachment')) {
                    foreach ($request->file('Quality_Control_attachment') as $file) {
                        $name = $request->name . 'Quality_Control_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                        $file->move('upload/', $name);
                        $files[] = $name;
                    }
                }
                $Cft->Quality_Control_attachment = json_encode($files);
            }

            if (!empty ($request->Warehouse_attachment)) {
                $files = [];
                if ($request->hasfile('Warehouse_attachment')) {
                    foreach ($request->file('Warehouse_attachment') as $file) {
                        $name = $request->name . 'Warehouse_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                        $file->move('upload/', $name);
                        $files[] = $name;
                    }
                }
                $Cft->Warehouse_attachment = json_encode($files);
            }
            if (!empty ($request->Engineering_attachment)) {
                $files = [];
                if ($request->hasfile('Engineering_attachment')) {
                    foreach ($request->file('Engineering_attachment') as $file) {
                        $name = $request->name . 'Engineering_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                        $file->move('upload/', $name);
                        $files[] = $name;
                    }
                }
                $Cft->Engineering_attachment = json_encode($files);
            }

            if (!empty ($request->ResearchDevelopment_attachment)) {
                $files = [];
                if ($request->hasfile('ResearchDevelopment_attachment')) {
                    foreach ($request->file('ResearchDevelopment_attachment') as $file) {
                        $name = $request->name . 'ResearchDevelopment_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                        $file->move('upload/', $name);
                        $files[] = $name;
                    }
                }
                $Cft->ResearchDevelopment_attachment = json_encode($files);
            }   

            if (!empty ($request->RegulatoryAffair_attachment)) {
                $files = [];
                if ($request->hasfile('RegulatoryAffair_attachment')) {
                    foreach ($request->file('RegulatoryAffair_attachment') as $file) {
                        $name = $request->name . 'RegulatoryAffair_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                        $file->move('upload/', $name);
                        $files[] = $name;
                    }
                }
                $Cft->RegulatoryAffair_attachment = json_encode($files);
            }

            if (!empty ($request->CQA_attachment)) {
                $files = [];
                if ($request->hasfile('CQA_attachment')) {
                    foreach ($request->file('CQA_attachment') as $file) {
                        $name = $request->name . 'CQA_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                        $file->move('upload/', $name);
                        $files[] = $name;
                    }
                }
                $Cft->CQA_attachment = json_encode($files);
            }

            if (!empty ($request->Microbiology_attachment)) {
                $files = [];
                if ($request->hasfile('Microbiology_attachment')) {
                    foreach ($request->file('Microbiology_attachment') as $file) {
                        $name = $request->name . 'Microbiology_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                        $file->move('upload/', $name);
                        $files[] = $name;
                    }
                }
                $Cft->Microbiology_attachment = json_encode($files);
            }

            if (!empty ($request->Quality_Assurance_attachment)) {
                $files = [];
                if ($request->hasfile('Quality_Assurance_attachment')) {
                    foreach ($request->file('Quality_Assurance_attachment') as $file) {
                        $name = $request->name . 'Quality_Assurance_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                        $file->move('upload/', $name);
                        $files[] = $name;
                    }
                }
                $Cft->Quality_Assurance_attachment = json_encode($files);
            }

            if (!empty ($request->SystemIT_attachment)) {
                $files = [];
                if ($request->hasfile('SystemIT_attachment')) {
                    foreach ($request->file('SystemIT_attachment') as $file) {
                        $name = $request->name . 'SystemIT_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                        $file->move('upload/', $name);
                        $files[] = $name;
                    }
                }
                $Cft->SystemIT_attachment = json_encode($files);
            }

            if (!empty ($request->Human_Resource_attachment)) {
                $files = [];
                if ($request->hasfile('Human_Resource_attachment')) {
                    foreach ($request->file('Human_Resource_attachment') as $file) {
                        $name = $request->name . 'Human_Resource_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                        $file->move('upload/', $name);
                        $files[] = $name;
                    }
                }
                $Cft->Human_Resource_attachment = json_encode($files);
            }

            if (!empty ($request->Other1_attachment)) {
                $files = [];
                if ($request->hasfile('Other1_attachment')) {
                    foreach ($request->file('Other1_attachment') as $file) {
                        $name = $request->name . 'Other1_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                        $file->move('upload/', $name);
                        $files[] = $name;
                    }
                }
                $Cft->Other1_attachment = json_encode($files);
            }

            if (!empty ($request->Other2_attachment)) {
                $files = [];
                if ($request->hasfile('Other2_attachment')) {
                    foreach ($request->file('Other2_attachment') as $file) {
                        $name = $request->name . 'Other2_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                        $file->move('upload/', $name);
                        $files[] = $name;
                    }
                }
                $Cft->Other2_attachment = json_encode($files);
            }

            if (!empty ($request->Other3_attachment)) {
                $files = [];
                if ($request->hasfile('Other3_attachment')) {
                    foreach ($request->file('Other3_attachment') as $file) {
                        $name = $request->name . 'Other3_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                        $file->move('upload/', $name);
                        $files[] = $name;
                    }
                }
                $Cft->Other3_attachment = json_encode($files);
            }

            if (!empty ($request->Other4_attachment)) {
                $files = [];
                if ($request->hasfile('Other4_attachment')) {
                    foreach ($request->file('Other4_attachment') as $file) {
                        $name = $request->name . 'Other4_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                        $file->move('upload/', $name);
                        $files[] = $name;
                    }
                }

                $Cft->Other4_attachment = json_encode($files);
            }

            if (!empty ($request->Other5_attachment)) {
                $files = [];
                if ($request->hasfile('Other5_attachment')) {
                    foreach ($request->file('Other5_attachment') as $file) {
                        $name = $request->name . 'Other5_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                        $file->move('upload/', $name);
                        $files[] = $name;
                    }
                }
                $Cft->Other5_attachment = json_encode($files);
            }
            $Cft->save();


            $IsCFTRequired = GlobalChangeControlResponse::withoutTrashed()->where(['is_required' => 1, 'cc_id' => $id])->latest()->first();
            $cftUsers = DB::table('global_change_controls_cfts')->where(['cc_id' => $id])->first();
            $columns = ['Production_person', 'Quality_Control_Person', 'Warehouse_person', 'Engineering_person', 'ResearchDevelopment_person', 'RegulatoryAffair_person', 'CQA_person', 'Microbiology_person', 'QualityAssurance_person','SystemIT_person', 'Human_Resource_person','Other1_person','Other2_person','Other3_person','Other4_person','Other5_person'];
            $valuesArray = [];
            foreach ($columns as $index => $column) {
                $value = $cftUsers->$column;
                if ($value != null && $value != 0) {
                    $valuesArray[] = $value;
                }
            }
            
            $valuesArray = array_unique($valuesArray);
            // Convert the array to a re-indexed array
            $valuesArray = array_values($valuesArray);
            // foreach ($valuesArray as $u) {
            //         $email = Helpers::getInitiatorEmail($u);
            //         if ($email !== null) {
            //             try {
            //                 Mail::send(
            //                     'mail.view-mail',
            //                     ['data' => $deviation],
            //                     function ($message) use ($email) {
            //                         $message->to($email)
            //                             ->subject("CFT Assgineed by " . Auth::user()->name);
            //                     }
            //                 );
            //             } catch (\Exception $e) {
            //             }
            //     }
            // }
        }



        $areRaAttachSame = $lastDocCft->RA_attachment == json_encode($request->RA_attachment);
        $areQAAttachSame = $lastDocCft->Quality_Assurance_attachment == json_encode($request->Quality_Assurance_attachment);
        $arePTAttachSame = $lastDocCft->Production_Table_Attachment == json_encode($request->Production_Table_Attachment);
        $arePlAttachSame = $lastDocCft->ProductionLiquid_attachment == json_encode($request->ProductionLiquid_attachment);
        $arePiAttachSame = $lastDocCft->Production_Injection_Attachment == json_encode($request->Production_Injection_Attachment);
        $areStoreAttachSame = $lastDocCft->Store_attachment == json_encode($request->Store_attachment);
        $areQcAttachSame = $lastDocCft->Quality_Control_attachment == json_encode($request->Quality_Control_attachment);
        $areRdAttachSame = $lastDocCft->ResearchDevelopment_attachment == json_encode($request->ResearchDevelopment_attachment);
        $areEngAttachSame = $lastDocCft->Engineering_attachment == json_encode($request->Engineering_attachment);
        $areHrAttachSame = $lastDocCft->Human_Resource_attachment == json_encode($request->Human_Resource_attachment);
        $areMicroAttachSame = $lastDocCft->Microbiology_attachment == json_encode($request->Microbiology_attachment);
        $areRegAffairAttachSame = $lastDocCft->RegulatoryAffair_attachment == json_encode($request->RegulatoryAffair_attachment);
        $areCQAAttachSame = $lastDocCft->CorporateQualityAssurance_attachment == json_encode($request->CorporateQualityAssurance_attachment);
        $areSafetyAttachSame = $lastDocCft->Environment_Health_Safety_attachment == json_encode($request->Environment_Health_Safety_attachment);
        $areItAttachSame = $lastDocCft->Information_Technology_attachment == json_encode($request->Information_Technology_attachment);
        $areContractGiverAttachSame = $lastDocCft->ContractGiver_attachment == json_encode($request->ContractGiver_attachment);
        $areOther1AttachSame = $lastDocCft->Other1_attachment == json_encode($request->Other1_attachment);
        $areOther2AttachSame = $lastDocCft->Other2_attachment == json_encode($request->Other2_attachment);
        $areOther3AttachSame = $lastDocCft->Other3_attachment == json_encode($request->Other3_attachment);
        $areOther4AttachSame = $lastDocCft->Other4_attachment == json_encode($request->Other4_attachment);
        $areOther5AttachSame = $lastDocCft->Other5_attachment == json_encode($request->Other5_attachment);


        /********** Audit Trail Code Starts ********/

        if ($lastDocument->short_description != $openState->short_description) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
            ->where('activity_type', 'Short Description')
            ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'Short Description';
            if($lastDocument->short_description == null){
                $history->previous = "NULL";
            } else{
                $history->previous = $lastDocument->short_description;
            }
            $history->current = $openState->short_description;
            $history->comment = $request->short_desc_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        } 

        if ($lastDocument->priority_data != $openState->priority_data) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
            ->where('activity_type', 'Short Description')
            ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'Priority';
            if($lastDocument->priority_data == null){
                $history->previous = "NULL";
            } else{
                $history->previous = $lastDocument->priority_data;
            }
            $history->current = $openState->priority_data;
            $history->comment = $request->short_desc_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        } 

        if ($lastDocument->risk_assessment_required != $request->risk_assessment_required) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
            ->where('activity_type', 'Risk Assessment Required')
            ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'Risk Assessment Required';
            $history->previous = $lastDocument->risk_assessment_required;
            $history->current = $openState->risk_assessment_required;
            $history->comment = $request->short_desc_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        } 

        if ($lastDocument->hod_person != $request->hod_person) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
            ->where('activity_type', 'HOD Person')
            ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'HOD Person';
            $history->previous = Helpers::getInitiatorName($lastDocument->hod_person);
            $history->current = Helpers::getInitiatorName($openState->hod_person);
            $history->comment = $request->Initiator_Group_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }

        if ($lastDocument->validation_requirment != $request->validation_requirment) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
            ->where('activity_type', 'Validation Requirement')
            ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'Validation Requirement';
            $history->previous = $lastDocument->validation_requirment;
            $history->current = $request->validation_requirment;
            $history->comment = $request->Initiator_Group_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }

        if ($lastDocument->qa_comments != $request->qa_review_comments) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
            ->where('activity_type', 'QA Initial Review Comments')
            ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'QA Initial Review Comments';
            $history->previous = $lastDocument->qa_comments;
            $history->current = $request->qa_review_comments;
            $history->comment = "";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }

        if ($lastDocument->Initiator_Group != $request->Initiator_Group) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
            ->where('activity_type', 'Initiation Department')
            ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'Initiation Department';
            $history->previous = $lastDocument->Initiator_Group;
            $history->current = $openState->Initiator_Group;
            $history->comment = $request->Initiator_Group_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }


        if ($lastDocument->assign_to != $request->assign_to) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
            ->where('activity_type', 'Assigned To')
            ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'Assigned To';
            $history->previous = $lastDocument->assign_to;
            $history->current = $openState->assign_to;
            $history->comment = $request->assign_to_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }

        if ($lastDocument->due_date != $request->due_date) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
            ->where('activity_type', 'Due Date')
            ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'Due Date';
            $history->previous = $lastDocument->due_date;
            $history->current = $openState->due_date;
            $history->comment = $request->due_date_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }

        if ($lastDocument->doc_change != $openState->doc_change) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
            ->where('activity_type', 'Nature Of Change')
            ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'Nature Of Change';
            $history->previous = $lastDocument->doc_change;
            $history->current = $openState->doc_change;
            $history->comment = "";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }

        /************** Attachment Code Start **************/
        
        
        /************** Attachment Code Ends **************/
        if ($lastDocument->If_Others != $openState->If_Others) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
                ->where('activity_type', 'If Others')
                ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'If Others';
            $history->previous = $lastDocument->If_Others;
            $history->current = $openState->If_Others;
            $history->comment = $request->If_Others_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }
        
        if ($lastDocument->Division_Code != $request->Division_Code) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
                ->where('activity_type', 'Division Code')
                ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'Division Code';
            $history->previous = $lastDocument->Division_Code;
            $history->current = $openState->Division_Code;
            $history->comment = $request->Division_Code_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }
        
        if ($lastDocument->initiated_through != $request->initiated_through) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
                ->where('activity_type', 'Initiated Through')
                ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'Initiated Through';
            $history->previous = $lastDocument->initiated_through;
            $history->current = $openState->initiated_through;
            $history->comment = "";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }
        
        if ($lastDocument->repeat != $request->repeat) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
                ->where('activity_type', 'Repeat')
                ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'Repeat';
            $history->previous = $lastDocument->repeat;
            $history->current = $openState->repeat;
            $history->comment = "";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }
        
        if ($lastDocument->repeat_nature != $request->repeat_nature) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
                ->where('activity_type', 'Repeat Nature')
                ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'Repeat Nature';
            $history->previous = $lastDocument->repeat_nature;
            $history->current = $openState->repeat_nature;
            $history->comment = "";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }
        
        if ($lastDocument->others != $openState->others) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
                ->where('activity_type', 'Other')
                ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'Other';
            $history->previous = $lastDocument->others;
            $history->current = $openState->others;
            $history->comment = "";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }
        
        if ($lastDocument->initiated_through_req != $request->initiated_through_req) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
                ->where('activity_type', 'Others')
                ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'Others';
            $history->previous = $lastDocument->initiated_through_req;
            $history->current = $openState->initiated_through_req;
            $history->comment = "";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }
        

        /************ Risk Assessment ************/

        if ($lastDocument->risk_identification != $openState->risk_identification) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
                ->where('activity_type', 'Risk Identification')
                ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'Risk Identification';
            $history->previous = $lastDocument->risk_identification;
            $history->current = $openState->risk_identification;
            $history->comment = "";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }


        if ($lastDocument->severity != $openState->severity) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
                ->where('activity_type', 'Change Related To')
                ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'Change Related To';
            $history->previous = $lastDocument->severity;
            $history->current = $openState->severity;
            $history->comment = "";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }

        if ($lastDocument->severity != $openState->severity) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
                ->where('activity_type', 'Change Related To')
                ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'Change Related To';
            $history->previous = $lastDocument->severity;
            $history->current = $openState->severity;
            $history->comment = "";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }
    
        
        if ($lastDocument->Occurance != $openState->Occurance) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
                ->where('activity_type', 'Occurance')
                ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'Occurance';
        
            if ($request->Occurance == 1) {
                $history->previous = "Very Likely";
            } elseif ($request->Occurance == 2) {
                $history->previous = "Likely";
            } elseif ($request->Occurance == 3) {
                $history->previous = "Unlikely";
            } elseif ($request->Occurance == 4) {
                $history->previous = "Rare";
            } else {
                $history->previous = "Extremely Unlikely";
            }
        
            if ($request->Occurance == 1) {
                $history->current = "Very Likely";
            } elseif ($request->Occurance == 2) {
                $history->current = "Likely";
            } elseif ($request->Occurance == 3) {
                $history->current = "Unlikely";
            } elseif ($request->Occurance == 4) {
                $history->current = "Rare";
            } else {
                $history->current = "Extremely Unlikely";
            }
        
            $history->comment = "";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }
        
        if ($lastDocument->Detection != $openState->Detection) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
                ->where('activity_type', 'Detection')
                ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'Detection';
        
            if ($request->Detection == 1) {
                $history->previous = "Likely";
            } elseif ($request->Detection == 2) {
                $history->previous = "Unlikely";
            } elseif ($request->Detection == 3) {
                $history->previous = "Rare";
            } else {
                $history->previous = "Impossible";
            }
        
            if ($request->Detection == 1) {
                $history->current = "Likely";
            } elseif ($request->Detection == 2) {
                $history->current = "Unlikely";
            } elseif ($request->Detection == 3) {
                $history->current = "Rare";
            } else {
                $history->current = "Impossible";
            }
        
            $history->comment = "";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }
        
        if ($lastDocument->RPN != $openState->RPN) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
                ->where('activity_type', 'RPN')
                ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'RPN';
            $history->previous = $lastDocument->RPN;
            $history->current = $openState->RPN;
            $history->comment = "";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }
        
        if ($lastDocument->risk_evaluation != $openState->risk_evaluation) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
                ->where('activity_type', 'Risk Evaluation')
                ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'Risk Evaluation';
            $history->previous = $lastDocument->risk_evaluation;
            $history->current = $openState->risk_evaluation;
            $history->comment = "";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }
        
        if ($lastDocument->migration_action != $openState->migration_action) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
                ->where('activity_type', 'comments')
                ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'comments';
            $history->previous = $lastDocument->migration_action;
            $history->current = $openState->migration_action;
            $history->comment = "";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }
        
        /************ Risk Assessment End ************/

        /************ Change Details History ************/

        if ($lastDocument->current_practice != $openState->current_practice) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
                ->where('activity_type', 'Current Practice')
                ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'Current Practice';
            $history->previous = $lastDocument->current_practice;
            $history->current = $openState->current_practice;
            $history->comment = $request->current_practice_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }
        
        if ($lastDocument->proposed_change != $openState->proposed_change) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
                ->where('activity_type', 'Proposed Change')
                ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'Proposed Change';
            $history->previous = $lastDocument->proposed_change;
            $history->current = $openState->proposed_change;
            $history->comment = $request->proposed_change_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }
        
        if ($lastDocument->reason_change != $openState->reason_change) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
                ->where('activity_type', 'Reason for Change')
                ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'Reason for Change';
            $history->previous = $lastDocument->reason_change;
            $history->current = $openState->reason_change;
            $history->comment = $request->reason_change_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }
        
        if ($lastDocument->other_comment != $openState->other_comment) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
                ->where('activity_type', 'Any Other Comments')
                ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'Any Other Comments';
            $history->previous = $lastDocument->other_comment;
            $history->current = $openState->other_comment;
            $history->comment = $request->other_comment_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }
        
        /************ Change Details History End ************/
        
        /************ HOD Review ************/
        if ($lastDocument->HOD_Remarks != $openState->HOD_Remarks) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
                ->where('activity_type', 'HOD Remarks')
                ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'HOD Remarks';
            $history->previous = $lastDocument->HOD_Remarks;
            $history->current = $openState->HOD_Remarks;
            $history->comment = "";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }
        /************ HOD Review End ************/
        
        /************ QA Initial ************/
        if ($lastDocument->due_days != $openState->due_days) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
                ->where('activity_type', 'Due Days')
                ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'Due Days';
            $history->previous = $lastDocument->due_days;
            $history->current = $openState->due_days;
            $history->comment = $request->type_chnage_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }
        
        if ($lastDocument->severity_level1 != $openState->severity_level1) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
                ->where('activity_type', 'Classification of Change')
                ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'Classification of Change';
            $history->previous = $lastDocument->severity_level1;
            $history->current = $openState->severity_level1;
            $history->comment = $request->type_chnage_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }

        if ($lastDocument->qa_comments != $request->qa_comments && $request->qa_comments != null) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
                ->where('activity_type', 'QA Initial Review Comments')
                ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'QA Initial Review Comments';
            $history->previous = $lastDocument->qa_comments;
            $history->current = $request->qa_comments;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }
        

        // if ($lastDocument->qa_head != $request->qa_head) {
        //     $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
        //         ->where('activity_type', 'QA Attachments')
        //         ->exists();
        //     $history = new GlobalChangeControlAuditTrail;
        //     $history->cc_id = $id;
        //     $history->activity_type = 'QA Attachments';
        //     $history->previous = $lastDocument->qa_head;
        //     $history->current = $request->qa_head;
        //     $history->comment = $request->type_chnage_comment;
        //     $history->user_id = Auth::user()->id;
        //     $history->user_name = Auth::user()->name;
        //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        //     $history->origin_state = $lastDocument->status;
        //     $history->change_to = "Not Applicable";
        //     $history->change_from = $lastDocument->status;
        //     $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
        //     $history->save();
        // }

        
       // Convert $request->qa_head to a string if it is an array
$requestQaHead = is_array($request->qa_head) ? implode(',', $request->qa_head) : $request->qa_head;

// Convert $lastDocument->qa_head to a string if it is an array
$lastDocumentQaHead = is_array($lastDocument->qa_head) ? implode(',', $lastDocument->qa_head) : $lastDocument->qa_head;

if ($lastDocumentQaHead != $requestQaHead && $requestQaHead != null) {
    $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
        ->where('activity_type', 'QA Attachments')
        ->exists();
        
    $history = new GlobalChangeControlAuditTrail;
    $history->cc_id = $id;
    $history->activity_type = 'QA Attachments';
    $history->previous = $lastDocumentQaHead;
    $history->current = $requestQaHead;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = "Not Applicable";
    $history->change_from = $lastDocument->status;
    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
    $history->save();
}

        /************ QA Initial End ************/

        /************ CFT Review ************/
        if ($lastCft->RA_Review != $request->RA_Review && $request->RA_Review != null) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
                ->where('activity_type', 'RA Review Required')
                ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'RA Review Required';
            $history->previous = $lastCft->RA_Review;
            $history->current = $request->RA_Review;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }
        
        if ($lastCft->RA_person != $request->RA_person && $request->RA_person != null) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
                ->where('activity_type', 'RA Person')
                ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'RA Person';
            $history->previous = $lastCft->RA_person;
            $history->current = $request->RA_person;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }
        
        if ($lastCft->RA_assessment != $request->RA_assessment && $request->RA_assessment != null) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
                ->where('activity_type', 'RA Assessment')
                ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'RA Assessment';
            $history->previous = $lastCft->RA_assessment;
            $history->current = $request->RA_assessment;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }
        
        if ($lastCft->RA_feedback != $request->RA_feedback && $request->RA_feedback != null) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
                ->where('activity_type', 'RA Comment')
                ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'RA Comment';
            $history->previous = $lastCft->RA_feedback;
            $history->current = $request->RA_feedback;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }
        
        if ($lastCft->RA_by != $request->RA_by && $request->RA_by != null) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
                ->where('activity_type', 'RA Review By')
                ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'RA Review By';
            $history->previous = $lastCft->RA_by;
            $history->current = $request->RA_by;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }
        
        if ($lastCft->RA_on != $request->RA_on && $request->RA_on != null) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
                ->where('activity_type', 'RA Review On')
                ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'RA Review On';
            $history->previous = $lastCft->RA_on;
            $history->current = $request->RA_on;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }
        //====================CFT Table ===================
        if ($lastCft->hod_assessment_comments != $request->hod_assessment_comments && $request->hod_assessment_comments != null) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
                ->where('activity_type', 'HOD Assessment Comments')
                ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'HOD Assessment Comments';
            $history->previous = $lastCft->hod_assessment_attachment;
            $history->current = $request->hod_assessment_comments;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }

        if ($lastCft->hod_assessment_attachment != $Cft->hod_assessment_attachment && $Cft->hod_assessment_attachment != null) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
                ->where('activity_type', 'HOD Assessment Attachment')
                ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'HOD Assessment Attachment';
            $history->previous = $lastCft->hod_assessment_comments;
            $history->current = $Cft->hod_assessment_attachment;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }

        if ($lastCft->RA_data_person != $request->RA_data_person && $request->RA_data_person != null) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
                ->where('activity_type', 'RA Person')
                ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'RA Person';
            $history->previous = $lastCft->RA_data_person;
            $history->current = $request->RA_data_person;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }

        if ($lastCft->QA_CQA_person != $request->QA_CQA_person && $request->QA_CQA_person != null) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
                ->where('activity_type', 'QA/CQA Head Approval Person')
                ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'QA/CQA Head Approval Person';
            $history->previous = $lastCft->QA_CQA_person;
            $history->current = $request->QA_CQA_person;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }
        if ($lastCft->qa_final_comments != $request->qa_final_comments && $request->qa_final_comments != null) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
                ->where('activity_type', 'QA Final Review Comments')
                ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'QA Final Review Comments';
            $history->previous = $lastCft->qa_final_comments;
            $history->current = $request->qa_final_comments;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }     
        

        if ($lastDocument->qa_comments != $request->qa_comments && $request->qa_comments != null) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
                ->where('activity_type', 'QA Initial Review Comments')
                ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'QA Initial Review Comments';
            $history->previous = $lastDocument->qa_comments;
            $history->current = $request->qa_comments;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }     
        


        if ($lastCft->RA_attachment_second != $request->RA_attachment_second && $request->RA_attachment_second != null) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
                ->where('activity_type', 'RA Attachments')
                ->exists();
            
            // Check if RA_attachment_second is an array and convert it to a string if necessary
            $previousAttachment = is_array($lastCft->RA_attachment_second) ? json_encode($lastCft->RA_attachment_second) : $lastCft->RA_attachment_second;
            $currentAttachment = is_array($request->RA_attachment_second) ? json_encode($request->RA_attachment_second) : $request->RA_attachment_second;
        
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'RA Attachments';
            $history->previous = $previousAttachment;
            $history->current = $currentAttachment;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }
        
        if (is_array($request->qa_cqa_comments)) {
            $request->qa_cqa_comments = implode(', ', $request->qa_cqa_comments);
        }
        if ($lastCft->qa_cqa_comments != $request->qa_cqa_comments && $request->qa_cqa_comments != null) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
                ->where('activity_type', 'QA/CQA Head/Manager Designee Approval Comments')
                ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'QA/CQA Head/Manager Designee Approval Comments';
            $history->previous = is_array($lastCft->qa_cqa_comments) ? implode(', ', $lastCft->qa_cqa_comments) : $lastCft->qa_cqa_comments;
            $history->current = $request->qa_cqa_comments;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }
        
        if (is_array($request->qa_cqa_attach)) {
            $request->qa_cqa_attach = implode(', ', $request->qa_cqa_attach);
        }
        if ($lastCft->qa_cqa_attach != $request->qa_cqa_attach && $request->qa_cqa_attach != null) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
                ->where('activity_type', 'QA/CQA Head/Manager Designee Approval Attachments')
                ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'QA/CQA Head/Manager Designee Approval Attachments';
            $history->previous = is_array($lastCft->qa_cqa_attach) ? implode(', ', $lastCft->qa_cqa_attach) : $lastCft->qa_cqa_attach;
            $history->current = $request->qa_cqa_attach;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }
        
        /*************** Quality Assurance ***************/
        if ($lastCft->Quality_Assurance_Review != $request->Quality_Assurance_Review && $request->Quality_Assurance_Review != null) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
                ->where('activity_type', 'Quality Assurance Review Required')
                ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'Quality Assurance Review Required';
            $history->previous = $lastCft->Quality_Assurance_Review;
            $history->current = $request->Quality_Assurance_Review;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }
        
        if ($lastCft->QualityAssurance_person != $request->QualityAssurance_person && $request->QualityAssurance_person != null) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
                ->where('activity_type', 'Quality Assurance Person')
                ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'Quality Assurance Person';
            $history->previous = $lastCft->QualityAssurance_person;
            $history->current = $request->QualityAssurance_person;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }
        
        if ($lastCft->QualityAssurance_assessment != $request->QualityAssurance_assessment && $request->QualityAssurance_assessment != null) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
                ->where('activity_type', 'Quality Assurance Assessment')
                ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'Quality Assurance Assessment';
            $history->previous = $lastCft->QualityAssurance_assessment;
            $history->current = $request->QualityAssurance_assessment;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }
        
        if ($lastCft->QualityAssurance_feedback != $request->QualityAssurance_feedback && $request->QualityAssurance_feedback != null) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
                ->where('activity_type', 'Quality Assurance Feedback')
                ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'Quality Assurance Feedback';
            $history->previous = $lastCft->QualityAssurance_feedback;
            $history->current = $request->QualityAssurance_feedback;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }
        
        if ($lastCft->QualityAssurance_by != $request->QualityAssurance_by && $request->QualityAssurance_by != null) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
                ->where('activity_type', 'Quality Assurance Review By')
                ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'Quality Assurance Review By';
            $history->previous = $lastCft->QualityAssurance_by;
            $history->current = $request->QualityAssurance_by;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }
        
        if ($lastCft->QualityAssurance_on != $request->QualityAssurance_on && $request->QualityAssurance_on != null) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
                ->where('activity_type', 'Quality Assurance Review On')
                ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'Quality Assurance Review On';
            $history->previous = $lastCft->QualityAssurance_on;
            $history->current = $request->QualityAssurance_on;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }
        
        /*************** Production Tablet ***************/
        if ($lastCft->Production_Table_Review != $request->Production_Table_Review && $request->Production_Table_Review != null) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
                ->where('activity_type', 'Production Tablet Review Required')
                ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'Production Tablet Review Required';
            $history->previous = $lastCft->Production_Table_Review;
            $history->current = $request->Production_Table_Review;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }
        
        if ($lastCft->Production_Table_Person != $request->Production_Table_Person && $request->Production_Table_Person != null) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
                ->where('activity_type', 'Production Tablet Person')
                ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'Production Tablet Person';
            $history->previous = $lastCft->Production_Table_Person;
            $history->current = $request->Production_Table_Person;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }
        
        if ($lastCft->Production_Table_Assessment != $request->Production_Table_Assessment && $request->Production_Table_Assessment != null) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
                ->where('activity_type', 'Production Tablet Assessment')
                ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'Production Tablet Assessment';
            $history->previous = $lastCft->Production_Table_Assessment;
            $history->current = $request->Production_Table_Assessment;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }
        
        if ($lastCft->Production_Table_Feedback != $request->Production_Table_Feedback && $request->Production_Table_Feedback != null) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
                ->where('activity_type', 'Production Tablet Feeback')
                ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'Production Tablet Feeback';
            $history->previous = $lastCft->Production_Table_Feedback;
            $history->current = $request->Production_Table_Feedback;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }
        
        if ($lastCft->Production_Table_By != $request->Production_Table_By && $request->Production_Table_By != null) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
                ->where('activity_type', 'Production Tablet Review By')
                ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'Production Tablet Review By';
            $history->previous = $lastCft->Production_Table_By;
            $history->current = $request->Production_Table_By;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }
        
        if ($lastCft->Production_Table_On != $request->Production_Table_On && $request->Production_Table_On != null) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
                ->where('activity_type', 'Production Tablet On')
                ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'Production Tablet On';
            $history->previous = $lastCft->Production_Table_On;
            $history->current = $request->Production_Table_On;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }
        
        /*************** Production Liquid ***************/
        if ($lastCft->ProductionLiquid_Review != $request->ProductionLiquid_Review && $request->ProductionLiquid_Review != null) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
                ->where('activity_type', 'Production Liquid Review Required')
                ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'Production Liquid Review Required';
            $history->previous = $lastCft->ProductionLiquid_Review;
            $history->current = $request->ProductionLiquid_Review;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }
        
        if ($lastCft->ProductionLiquid_person != $request->ProductionLiquid_person && $request->ProductionLiquid_person != null) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
                ->where('activity_type', 'Production Liquid Person')
                ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'Production Liquid Person';
            $history->previous = $lastCft->ProductionLiquid_person;
            $history->current = $request->ProductionLiquid_person;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }
        
        if ($lastCft->ProductionLiquid_assessment != $request->ProductionLiquid_assessment && $request->ProductionLiquid_assessment != null) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
                ->where('activity_type', 'Production Liquid Assessment')
                ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'Production Liquid Assessment';
            $history->previous = $lastCft->ProductionLiquid_assessment;
            $history->current = $request->ProductionLiquid_assessment;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }
        
        if ($lastCft->ProductionLiquid_feedback != $request->ProductionLiquid_feedback && $request->ProductionLiquid_feedback != null) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
                ->where('activity_type', 'Production Liquid Feedback')
                ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'Production Liquid Feedback';
            $history->previous = $lastCft->ProductionLiquid_feedback;
            $history->current = $request->ProductionLiquid_feedback;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }
        
        if ($lastCft->ProductionLiquid_by != $request->ProductionLiquid_by && $request->ProductionLiquid_by != null) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
                ->where('activity_type', 'Production Liquid Review By')
                ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'Production Liquid Review By';
            $history->previous = $lastCft->ProductionLiquid_by;
            $history->current = $request->ProductionLiquid_by;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }
        
        if ($lastCft->ProductionLiquid_on != $request->ProductionLiquid_on && $request->ProductionLiquid_on != null) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
                ->where('activity_type', 'Production Liquid Review On')
                ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'Production Liquid Review On';
            $history->previous = $lastCft->ProductionLiquid_on;
            $history->current = $request->ProductionLiquid_on;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }
        

        /*************** Production Injection ***************/
        // Production Injection
if ($lastCft->Production_Injection_Review != $request->Production_Injection_Review && $request->Production_Injection_Review != null) {
    $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
        ->where('activity_type', 'Production Injection Review Required')
        ->exists();
    $history = new GlobalChangeControlAuditTrail;
    $history->cc_id = $id;
    $history->activity_type = 'Production Injection Review Required';
    $history->previous = $lastCft->Production_Injection_Review;
    $history->current = $request->Production_Injection_Review;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = "Not Applicable";
    $history->change_from = $lastDocument->status;
    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
    $history->save();
}

if ($lastCft->Production_Injection_Person != $request->Production_Injection_Person && $request->Production_Injection_Person != null) {
    $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
        ->where('activity_type', 'Production Injection Person')
        ->exists();
    $history = new GlobalChangeControlAuditTrail;
    $history->cc_id = $id;
    $history->activity_type = 'Production Injection Person';
    $history->previous = $lastCft->Production_Injection_Person;
    $history->current = $request->Production_Injection_Person;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = "Not Applicable";
    $history->change_from = $lastDocument->status;
    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
    $history->save();
}

if ($lastCft->Production_Injection_Assessment != $request->Production_Injection_Assessment && $request->Production_Injection_Assessment != null) {
    $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
        ->where('activity_type', 'Production Injection Assessment')
        ->exists();
    $history = new GlobalChangeControlAuditTrail;
    $history->cc_id = $id;
    $history->activity_type = 'Production Injection Assessment';
    $history->previous = $lastCft->Production_Injection_Assessment;
    $history->current = $request->Production_Injection_Assessment;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = "Not Applicable";
    $history->change_from = $lastDocument->status;
    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
    $history->save();
}

if ($lastCft->Production_Injection_Feedback != $request->Production_Injection_Feedback && $request->Production_Injection_Feedback != null) {
    $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
        ->where('activity_type', 'Production Injection Feedback')
        ->exists();
    $history = new GlobalChangeControlAuditTrail;
    $history->cc_id = $id;
    $history->activity_type = 'Production Injection Feedback';
    $history->previous = $lastCft->Production_Injection_Feedback;
    $history->current = $request->Production_Injection_Feedback;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = "Not Applicable";
    $history->change_from = $lastDocument->status;
    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
    $history->save();
}

if ($lastCft->Production_Injection_By != $request->Production_Injection_By && $request->Production_Injection_By != null) {
    $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
        ->where('activity_type', 'Production Injection Review By')
        ->exists();
    $history = new GlobalChangeControlAuditTrail;
    $history->cc_id = $id;
    $history->activity_type = 'Production Injection Review By';
    $history->previous = $lastCft->Production_Injection_By;
    $history->current = $request->Production_Injection_By;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = "Not Applicable";
    $history->change_from = $lastDocument->status;
    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
    $history->save();
}

if ($lastCft->Production_Injection_On != $request->Production_Injection_On && $request->Production_Injection_On != null) {
    $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
        ->where('activity_type', 'Production Injection On')
        ->exists();
    $history = new GlobalChangeControlAuditTrail;
    $history->cc_id = $id;
    $history->activity_type = 'Production Injection On';
    $history->previous = $lastCft->Production_Injection_On;
    $history->current = $request->Production_Injection_On;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = "Not Applicable";
    $history->change_from = $lastDocument->status;
    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
    $history->save();
}

// Stores
if ($lastCft->Store_Review != $request->Store_Review && $request->Store_Review != null) {
    $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
        ->where('activity_type', 'Store Review Required')
        ->exists();
    $history = new GlobalChangeControlAuditTrail;
    $history->cc_id = $id;
    $history->activity_type = 'Store Review Required';
    $history->previous = $lastCft->Store_Review;
    $history->current = $request->Store_Review;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = "Not Applicable";
    $history->change_from = $lastDocument->status;
    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
    $history->save();
}

if ($lastCft->Store_person != $request->Store_person && $request->Store_person != null) {
    $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
        ->where('activity_type', 'Store Person')
        ->exists();
    $history = new GlobalChangeControlAuditTrail;
    $history->cc_id = $id;
    $history->activity_type = 'Store Person';
    $history->previous = $lastCft->Store_person;
    $history->current = $request->Store_person;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = "Not Applicable";
    $history->change_from = $lastDocument->status;
    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
    $history->save();
}

if ($lastCft->Store_assessment != $request->Store_assessment && $request->Store_assessment != null) {
    $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
        ->where('activity_type', 'Store Assessment')
        ->exists();
    $history = new GlobalChangeControlAuditTrail;
    $history->cc_id = $id;
    $history->activity_type = 'Store Assessment';
    $history->previous = $lastCft->Store_assessment;
    $history->current = $request->Store_assessment;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = "Not Applicable";
    $history->change_from = $lastDocument->status;
    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
    $history->save();
}

if ($lastCft->Store_feedback != $request->Store_feedback && $request->Store_feedback != null) {
    $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
        ->where('activity_type', 'Store Feedback')
        ->exists();
    $history = new GlobalChangeControlAuditTrail;
    $history->cc_id = $id;
    $history->activity_type = 'Store Feedback';
    $history->previous = $lastCft->Store_feedback;
    $history->current = $request->Store_feedback;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = "Not Applicable";
    $history->change_from = $lastDocument->status;
    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
    $history->save();
}

if ($lastCft->Store_by != $request->Store_by && $request->Store_by != null) {
    $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
        ->where('activity_type', 'Store Review By')
        ->exists();
    $history = new GlobalChangeControlAuditTrail;
    $history->cc_id = $id;
    $history->activity_type = 'Store Review By';
    $history->previous = $lastCft->Store_by;
    $history->current = $request->Store_by;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = "Not Applicable";
    $history->change_from = $lastDocument->status;
    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
    $history->save();
}

if ($lastCft->Store_on != $request->Store_on && $request->Store_on != null) {
    $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
        ->where('activity_type', 'Store Review On')
        ->exists();
    $history = new GlobalChangeControlAuditTrail;
    $history->cc_id = $id;
    $history->activity_type = 'Store Review On';
    $history->previous = $lastCft->Store_on;
    $history->current = $request->Store_on;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = "Not Applicable";
    $history->change_from = $lastDocument->status;
    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
    $history->save();
}

// Quality Control
if ($lastCft->Quality_review != $request->Quality_review && $request->Quality_review != null) {
    $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
        ->where('activity_type', 'Quality Control Required')
        ->exists();
    $history = new GlobalChangeControlAuditTrail;
    $history->cc_id = $id;
    $history->activity_type = 'Quality Control Required';
    $history->previous = $lastCft->Quality_review;
    $history->current = $request->Quality_review;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = "Not Applicable";
    $history->change_from = $lastDocument->status;
    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
    $history->save();
}

if ($lastCft->Quality_Control_Person != $request->Quality_Control_Person && $request->Quality_Control_Person != null) {
    $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
        ->where('activity_type', 'Quality Control Person')
        ->exists();
    $history = new GlobalChangeControlAuditTrail;
    $history->cc_id = $id;
    $history->activity_type = 'Quality Control Person';
    $history->previous = $lastCft->Quality_Control_Person;
    $history->current = $request->Quality_Control_Person;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = "Not Applicable";
    $history->change_from = $lastDocument->status;
    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
    $history->save();
}

if ($lastCft->Quality_Control_assessment != $request->Quality_Control_assessment && $request->Quality_Control_assessment != null) {
    $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
        ->where('activity_type', 'Quality Control Assessment')
        ->exists();
    $history = new GlobalChangeControlAuditTrail;
    $history->cc_id = $id;
    $history->activity_type = 'Quality Control Assessment';
    $history->previous = $lastCft->Quality_Control_assessment;
    $history->current = $request->Quality_Control_assessment;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = "Not Applicable";
    $history->change_from = $lastDocument->status;
    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
    $history->save();
}

if ($lastCft->Quality_Control_feedback != $request->Quality_Control_feedback && $request->Quality_Control_feedback != null) {
    $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
        ->where('activity_type', 'Quality Control Feedback')
        ->exists();
    $history = new GlobalChangeControlAuditTrail;
    $history->cc_id = $id;
    $history->activity_type = 'Quality Control Feedback';
    $history->previous = $lastCft->Quality_Control_feedback;
    $history->current = $request->Quality_Control_feedback;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = "Not Applicable";
    $history->change_from = $lastDocument->status;
    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
    $history->save();
}

if ($lastCft->Quality_Control_by != $request->Quality_Control_by && $request->Quality_Control_by != null) {
    $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
        ->where('activity_type', 'Quality Control By')
        ->exists();
    $history = new GlobalChangeControlAuditTrail;
    $history->cc_id = $id;
    $history->activity_type = 'Quality Control By';
    $history->previous = $lastCft->Quality_Control_by;
    $history->current = $request->Quality_Control_by;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = "Not Applicable";
    $history->change_from = $lastDocument->status;
    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
    $history->save();
}

if ($lastCft->Quality_Control_on != $request->Quality_Control_on && $request->Quality_Control_on != null) {
    $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
        ->where('activity_type', 'Quality Control On')
        ->exists();
    $history = new GlobalChangeControlAuditTrail;
    $history->cc_id = $id;
    $history->activity_type = 'Quality Control On';
    $history->previous = $lastCft->Quality_Control_on;
    $history->current = $request->Quality_Control_on;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = "Not Applicable";
    $history->change_from = $lastDocument->status;
    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
    $history->save();
}

// Research & Development
if ($lastCft->ResearchDevelopment_Review != $request->ResearchDevelopment_Review && $request->ResearchDevelopment_Review != null) {
    $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
        ->where('activity_type', 'Research & Development Required')
        ->exists();
    $history = new GlobalChangeControlAuditTrail;
    $history->cc_id = $id;
    $history->activity_type = 'Research & Development Required';
    $history->previous = $lastCft->ResearchDevelopment_Review;
    $history->current = $request->ResearchDevelopment_Review;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = "Not Applicable";
    $history->change_from = $lastDocument->status;
    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
    $history->save();
}

if ($lastCft->ResearchDevelopment_person != $request->ResearchDevelopment_person && $request->ResearchDevelopment_person != null) {
    $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
        ->where('activity_type', 'Research & Development Person')
        ->exists();
    $history = new GlobalChangeControlAuditTrail;
    $history->cc_id = $id;
    $history->activity_type = 'Research & Development Person';
    $history->previous = $lastCft->ResearchDevelopment_person;
    $history->current = $request->ResearchDevelopment_person;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = "Not Applicable";
    $history->change_from = $lastDocument->status;
    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
    $history->save();
}

if ($lastCft->ResearchDevelopment_assessment != $request->ResearchDevelopment_assessment && $request->ResearchDevelopment_assessment != null) {
    $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
        ->where('activity_type', 'Research & Development Assessment')
        ->exists();
    $history = new GlobalChangeControlAuditTrail;
    $history->cc_id = $id;
    $history->activity_type = 'Research & Development Assessment';
    $history->previous = $lastCft->ResearchDevelopment_assessment;
    $history->current = $request->ResearchDevelopment_assessment;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = "Not Applicable";
    $history->change_from = $lastDocument->status;
    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
    $history->save();
}

if ($lastCft->ResearchDevelopment_feedback != $request->ResearchDevelopment_feedback && $request->ResearchDevelopment_feedback != null) {
    $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
        ->where('activity_type', 'Research & Development Feedback')
        ->exists();
    $history = new GlobalChangeControlAuditTrail;
    $history->cc_id = $id;
    $history->activity_type = 'Research & Development Feedback';
    $history->previous = $lastCft->ResearchDevelopment_feedback;
    $history->current = $request->ResearchDevelopment_feedback;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = "Not Applicable";
    $history->change_from = $lastDocument->status;
    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
    $history->save();
}

if ($lastCft->ResearchDevelopment_by != $request->ResearchDevelopment_by && $request->ResearchDevelopment_by != null) {
    $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
        ->where('activity_type', 'Research & Development By')
        ->exists();
    $history = new GlobalChangeControlAuditTrail;
    $history->cc_id = $id;
    $history->activity_type = 'Research & Development By';
    $history->previous = $lastCft->ResearchDevelopment_by;
    $history->current = $request->ResearchDevelopment_by;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = "Not Applicable";
    $history->change_from = $lastDocument->status;
    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
    $history->save();
}

if ($lastCft->ResearchDevelopment_on != $request->ResearchDevelopment_on && $request->ResearchDevelopment_on != null) {
    $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
        ->where('activity_type', 'Research & Development On')
        ->exists();
    $history = new GlobalChangeControlAuditTrail;
    $history->cc_id = $id;
    $history->activity_type = 'Research & Development On';
    $history->previous = $lastCft->ResearchDevelopment_on;
    $history->current = $request->ResearchDevelopment_on;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = "Not Applicable";
    $history->change_from = $lastDocument->status;
    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
    $history->save();
}

        /*************** Engineering ***************/
        // Engineering
if ($lastCft->Engineering_review != $request->Engineering_review && $request->Engineering_review != null) {
    $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
        ->where('activity_type', 'Engineering Review Required')
        ->exists();
    $history = new GlobalChangeControlAuditTrail;
    $history->cc_id = $id;
    $history->activity_type = 'Engineering Review Required';
    $history->previous = $lastCft->Engineering_review;
    $history->current = $request->Engineering_review;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = "Not Applicable";
    $history->change_from = $lastDocument->status;
    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
    $history->save();
}

if ($lastCft->Engineering_person != $request->Engineering_person && $request->Engineering_person != null) {
    $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
        ->where('activity_type', 'Engineering Person')
        ->exists();
    $history = new GlobalChangeControlAuditTrail;
    $history->cc_id = $id;
    $history->activity_type = 'Engineering Person';
    $history->previous = $lastCft->Engineering_person;
    $history->current = $request->Engineering_person;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = "Not Applicable";
    $history->change_from = $lastDocument->status;
    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
    $history->save();
}

if ($lastCft->Engineering_assessment != $request->Engineering_assessment && $request->Engineering_assessment != null) {
    $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
        ->where('activity_type', 'Engineering Assessment')
        ->exists();
    $history = new GlobalChangeControlAuditTrail;
    $history->cc_id = $id;
    $history->activity_type = 'Engineering Assessment';
    $history->previous = $lastCft->Engineering_assessment;
    $history->current = $request->Engineering_assessment;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = "Not Applicable";
    $history->change_from = $lastDocument->status;
    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
    $history->save();
}

if ($lastCft->Engineering_feedback != $request->Engineering_feedback && $request->Engineering_feedback != null) {
    $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
        ->where('activity_type', 'Engineering Feedback')
        ->exists();
    $history = new GlobalChangeControlAuditTrail;
    $history->cc_id = $id;
    $history->activity_type = 'Engineering Feedback';
    $history->previous = $lastCft->Engineering_feedback;
    $history->current = $request->Engineering_feedback;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = "Not Applicable";
    $history->change_from = $lastDocument->status;
    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
    $history->save();
}

if ($lastCft->Engineering_by != $request->Engineering_by && $request->Engineering_by != null) {
    $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
        ->where('activity_type', 'Engineering Review By')
        ->exists();
    $history = new GlobalChangeControlAuditTrail;
    $history->cc_id = $id;
    $history->activity_type = 'Engineering Review By';
    $history->previous = $lastCft->Engineering_by;
    $history->current = $request->Engineering_by;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = "Not Applicable";
    $history->change_from = $lastDocument->status;
    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
    $history->save();
}

if ($lastCft->Engineering_on != $request->Engineering_on && $request->Engineering_on != null) {
    $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
        ->where('activity_type', 'Engineering Review On')
        ->exists();
    $history = new GlobalChangeControlAuditTrail;
    $history->cc_id = $id;
    $history->activity_type = 'Engineering Review On';
    $history->previous = $lastCft->Engineering_on;
    $history->current = $request->Engineering_on;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = "Not Applicable";
    $history->change_from = $lastDocument->status;
    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
    $history->save();
}

// Human Resource
if ($lastCft->Human_Resource_review != $request->Human_Resource_review && $request->Human_Resource_review != null) {
    $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
        ->where('activity_type', 'Human Resource Review Required')
        ->exists();
    $history = new GlobalChangeControlAuditTrail;
    $history->cc_id = $id;
    $history->activity_type = 'Human Resource Review Required';
    $history->previous = $lastCft->Human_Resource_review;
    $history->current = $request->Human_Resource_review;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = "Not Applicable";
    $history->change_from = $lastDocument->status;
    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
    $history->save();
}

if ($lastCft->Human_Resource_person != $request->Human_Resource_person && $request->Human_Resource_person != null) {
    $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
        ->where('activity_type', 'Human Resource Person')
        ->exists();
    $history = new GlobalChangeControlAuditTrail;
    $history->cc_id = $id;
    $history->activity_type = 'Human Resource Person';
    $history->previous = $lastCft->Human_Resource_person;
    $history->current = $request->Human_Resource_person;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = "Not Applicable";
    $history->change_from = $lastDocument->status;
    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
    $history->save();
}

if ($lastCft->Human_Resource_assessment != $request->Human_Resource_assessment && $request->Human_Resource_assessment != null) {
    $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
        ->where('activity_type', 'Human Resource Assessment')
        ->exists();
    $history = new GlobalChangeControlAuditTrail;
    $history->cc_id = $id;
    $history->activity_type = 'Human Resource Assessment';
    $history->previous = $lastCft->Human_Resource_assessment;
    $history->current = $request->Human_Resource_assessment;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = "Not Applicable";
    $history->change_from = $lastDocument->status;
    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
    $history->save();
}

if ($lastCft->Human_Resource_feedback != $request->Human_Resource_feedback && $request->Human_Resource_feedback != null) {
    $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
        ->where('activity_type', 'Human Resource Feedback')
        ->exists();
    $history = new GlobalChangeControlAuditTrail;
    $history->cc_id = $id;
    $history->activity_type = 'Human Resource Feedback';
    $history->previous = $lastCft->Human_Resource_feedback;
    $history->current = $request->Human_Resource_feedback;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = "Not Applicable";
    $history->change_from = $lastDocument->status;
    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
    $history->save();
}

if ($lastCft->Human_Resource_by != $request->Human_Resource_by && $request->Human_Resource_by != null) {
    $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
        ->where('activity_type', 'Human Resource Review By')
        ->exists();
    $history = new GlobalChangeControlAuditTrail;
    $history->cc_id = $id;
    $history->activity_type = 'Human Resource Review By';
    $history->previous = $lastCft->Human_Resource_by;
    $history->current = $request->Human_Resource_by;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = "Not Applicable";
    $history->change_from = $lastDocument->status;
    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
    $history->save();
}

if ($lastCft->Human_Resource_on != $request->Human_Resource_on && $request->Human_Resource_on != null) {
    $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
        ->where('activity_type', 'Human Resource Review On')
        ->exists();
    $history = new GlobalChangeControlAuditTrail;
    $history->cc_id = $id;
    $history->activity_type = 'Human Resource Review On';
    $history->previous = $lastCft->Human_Resource_on;
    $history->current = $request->Human_Resource_on;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = "Not Applicable";
    $history->change_from = $lastDocument->status;
    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
    $history->save();
}

// Microbiology
if ($lastCft->Microbiology_Review != $request->Microbiology_Review && $request->Microbiology_Review != null) {
    $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
        ->where('activity_type', 'Microbiology Review Required')
        ->exists();
    $history = new GlobalChangeControlAuditTrail;
    $history->cc_id = $id;
    $history->activity_type = 'Microbiology Review Required';
    $history->previous = $lastCft->Microbiology_Review;
    $history->current = $request->Microbiology_Review;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = "Not Applicable";
    $history->change_from = $lastDocument->status;
    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
    $history->save();
}

if ($lastCft->Microbiology_person != $request->Microbiology_person && $request->Microbiology_person != null) {
    $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
        ->where('activity_type', 'Microbiology Person')
        ->exists();
    $history = new GlobalChangeControlAuditTrail;
    $history->cc_id = $id;
    $history->activity_type = 'Microbiology Person';
    $history->previous = $lastCft->Microbiology_person;
    $history->current = $request->Microbiology_person;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = "Not Applicable";
    $history->change_from = $lastDocument->status;
    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
    $history->save();
}

if ($lastCft->Microbiology_assessment != $request->Microbiology_assessment && $request->Microbiology_assessment != null) {
    $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
        ->where('activity_type', 'Microbiology Assessment')
        ->exists();
    $history = new GlobalChangeControlAuditTrail;
    $history->cc_id = $id;
    $history->activity_type = 'Microbiology Assessment';
    $history->previous = $lastCft->Microbiology_assessment;
    $history->current = $request->Microbiology_assessment;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = "Not Applicable";
    $history->change_from = $lastDocument->status;
    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
    $history->save();
}

if ($lastCft->Microbiology_feedback != $request->Microbiology_feedback && $request->Microbiology_feedback != null) {
    $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
        ->where('activity_type', 'Microbiology Feedback')
        ->exists();
    $history = new GlobalChangeControlAuditTrail;
    $history->cc_id = $id;
    $history->activity_type = 'Microbiology Feedback';
    $history->previous = $lastCft->Microbiology_feedback;
    $history->current = $request->Microbiology_feedback;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = "Not Applicable";
    $history->change_from = $lastDocument->status;
    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
    $history->save();
}

if ($lastCft->Microbiology_by != $request->Microbiology_by && $request->Microbiology_by != null) {
    $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
        ->where('activity_type', 'Microbiology Review By')
        ->exists();
    $history = new GlobalChangeControlAuditTrail;
    $history->cc_id = $id;
    $history->activity_type = 'Microbiology Review By';
    $history->previous = $lastCft->Microbiology_by;
    $history->current = $request->Microbiology_by;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = "Not Applicable";
    $history->change_from = $lastDocument->status;
    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
    $history->save();
}

if ($lastCft->Microbiology_on != $request->Microbiology_on && $request->Microbiology_on != null) {
    $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
        ->where('activity_type', 'Microbiology Review On')
        ->exists();
    $history = new GlobalChangeControlAuditTrail;
    $history->cc_id = $id;
    $history->activity_type = 'Microbiology Review On';
    $history->previous = $lastCft->Microbiology_on;
    $history->current = $request->Microbiology_on;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = "Not Applicable";
    $history->change_from = $lastDocument->status;
    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
    $history->save();
}

// Regulatory Affair
if ($lastCft->RegulatoryAffair_Review != $request->RegulatoryAffair_Review && $request->RegulatoryAffair_Review != null) {
    $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
        ->where('activity_type', 'Regulatory Affair Review Required')
        ->exists();
    $history = new GlobalChangeControlAuditTrail;
    $history->cc_id = $id;
    $history->activity_type = 'Regulatory Affair Review Required';
    $history->previous = $lastCft->RegulatoryAffair_Review;
    $history->current = $request->RegulatoryAffair_Review;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = "Not Applicable";
    $history->change_from = $lastDocument->status;
    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
    $history->save();
}

if ($lastCft->RegulatoryAffair_person != $request->RegulatoryAffair_person && $request->RegulatoryAffair_person != null) {
    $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
        ->where('activity_type', 'Regulatory Affair Person')
        ->exists();
    $history = new GlobalChangeControlAuditTrail;
    $history->cc_id = $id;
    $history->activity_type = 'Regulatory Affair Person';
    $history->previous = $lastCft->RegulatoryAffair_person;
    $history->current = $request->RegulatoryAffair_person;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = "Not Applicable";
    $history->change_from = $lastDocument->status;
    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
    $history->save();
}

if ($lastCft->RegulatoryAffair_assessment != $request->RegulatoryAffair_assessment && $request->RegulatoryAffair_assessment != null) {
    $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
        ->where('activity_type', 'Regulatory Affair Assessment')
        ->exists();
    $history = new GlobalChangeControlAuditTrail;
    $history->cc_id = $id;
    $history->activity_type = 'Regulatory Affair Assessment';
    $history->previous = $lastCft->RegulatoryAffair_assessment;
    $history->current = $request->RegulatoryAffair_assessment;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = "Not Applicable";
    $history->change_from = $lastDocument->status;
    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
    $history->save();
}

if ($lastCft->RegulatoryAffair_feedback != $request->RegulatoryAffair_feedback && $request->RegulatoryAffair_feedback != null) {
    $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
        ->where('activity_type', 'Regulatory Affair Feedback')
        ->exists();
    $history = new GlobalChangeControlAuditTrail;
    $history->cc_id = $id;
    $history->activity_type = 'Regulatory Affair Feedback';
    $history->previous = $lastCft->RegulatoryAffair_feedback;
    $history->current = $request->RegulatoryAffair_feedback;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = "Not Applicable";
    $history->change_from = $lastDocument->status;
    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
    $history->save();
}

if ($lastCft->RegulatoryAffair_by != $request->RegulatoryAffair_by && $request->RegulatoryAffair_by != null) {
    $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
        ->where('activity_type', 'Regulatory Affair Review By')
        ->exists();
    $history = new GlobalChangeControlAuditTrail;
    $history->cc_id = $id;
    $history->activity_type = 'Regulatory Affair Review By';
    $history->previous = $lastCft->RegulatoryAffair_by;
    $history->current = $request->RegulatoryAffair_by;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = "Not Applicable";
    $history->change_from = $lastDocument->status;
    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
    $history->save();
}

if ($lastCft->RegulatoryAffair_on != $request->RegulatoryAffair_on && $request->RegulatoryAffair_on != null) {
    $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
        ->where('activity_type', 'Regulatory Affair Review On')
        ->exists();
    $history = new GlobalChangeControlAuditTrail;
    $history->cc_id = $id;
    $history->activity_type = 'Regulatory Affair Review On';
    $history->previous = $lastCft->RegulatoryAffair_on;
    $history->current = $request->RegulatoryAffair_on;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = "Not Applicable";
    $history->change_from = $lastDocument->status;
    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
    $history->save();
}


        /*************** Corporate Quality Assurance ***************/
        if ($lastCft->CorporateQualityAssurance_Review != $request->CorporateQualityAssurance_Review && $request->CorporateQualityAssurance_Review != null) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
            ->where('activity_type', 'Corporate Quality Assurance Review Required')
            ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'Corporate Quality Assurance Review Required';
            $history->previous = $lastCft->CorporateQualityAssurance_Review;
            $history->current = $request->CorporateQualityAssurance_Review;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }
        if ($lastCft->CorporateQualityAssurance_person != $request->CorporateQualityAssurance_person && $request->CorporateQualityAssurance_person != null) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
            ->where('activity_type', 'Corporate Quality Assurance Person')
            ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'Corporate Quality Assurance Person';
            $history->previous = $lastCft->CorporateQualityAssurance_person;
            $history->current = $request->CorporateQualityAssurance_person;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }
        if ($lastCft->CorporateQualityAssurance_assessment != $request->CorporateQualityAssurance_assessment && $request->CorporateQualityAssurance_assessment != null) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
            ->where('activity_type', 'Corporate Quality Assurance Assessment')
            ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'Corporate Quality Assurance Assessment';
            $history->previous = $lastCft->CorporateQualityAssurance_assessment;
            $history->current = $request->CorporateQualityAssurance_assessment;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }
        if ($lastCft->CorporateQualityAssurance_feedback != $request->CorporateQualityAssurance_feedback && $request->CorporateQualityAssurance_feedback != null) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
            ->where('activity_type', 'Corporate Quality Assurance Feedback')
            ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'Corporate Quality Assurance Feedback';
            $history->previous = $lastCft->CorporateQualityAssurance_feedback;
            $history->current = $request->CorporateQualityAssurance_feedback;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }
        if ($lastCft->CorporateQualityAssurance_by != $request->CorporateQualityAssurance_by && $request->CorporateQualityAssurance_by != null) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
            ->where('activity_type', 'Corporate Quality Assurance Review By')
            ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'Corporate Quality Assurance Review By';
            $history->previous = $lastCft->CorporateQualityAssurance_by;
            $history->current = $request->CorporateQualityAssurance_by;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }
        if ($lastCft->CorporateQualityAssurance_on != $request->CorporateQualityAssurance_on && $request->CorporateQualityAssurance_on != null) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
            ->where('activity_type', 'Corporate Quality Assurance Review On')
            ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'Corporate Quality Assurance Review On';
            $history->previous = $lastCft->CorporateQualityAssurance_on;
            $history->current = $request->CorporateQualityAssurance_on;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }

        /*************** Safety ***************/
        if ($lastCft->Environment_Health_review != $request->Environment_Health_review && $request->Environment_Health_review != null) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
            ->where('activity_type', 'Safety Review Required')
            ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'Safety Review Required';
            $history->previous = $lastCft->Environment_Health_review;
            $history->current = $request->Environment_Health_review;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }
        if ($lastCft->Environment_Health_Safety_person != $request->Environment_Health_Safety_person && $request->Environment_Health_Safety_person != null) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
            ->where('activity_type', 'Safety Person')
            ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'Safety Person';
            $history->previous = $lastCft->Environment_Health_Safety_person;
            $history->current = $request->Environment_Health_Safety_person;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }
        if ($lastCft->Health_Safety_assessment != $request->Health_Safety_assessment && $request->Health_Safety_assessment != null) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
            ->where('activity_type', 'Safety Assessment')
            ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'Safety Assessment';
            $history->previous = $lastCft->Health_Safety_assessment;
            $history->current = $request->Health_Safety_assessment;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }
        if ($lastCft->Health_Safety_feedback != $request->Health_Safety_feedback && $request->Health_Safety_feedback != null) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
            ->where('activity_type', 'Safety Feedback')
            ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'Safety Feedback';
            $history->previous = $lastCft->Health_Safety_feedback;
            $history->current = $request->Health_Safety_feedback;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }
        if ($lastCft->Environment_Health_Safety_by != $request->Environment_Health_Safety_by && $request->Environment_Health_Safety_by != null) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
            ->where('activity_type', 'Safety Review By')
            ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'Safety Review By';
            $history->previous = $lastCft->Environment_Health_Safety_by;
            $history->current = $request->Environment_Health_Safety_by;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }
        if ($lastCft->Environment_Health_Safety_on != $request->Environment_Health_Safety_on && $request->Environment_Health_Safety_on != null) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
            ->where('activity_type', 'Safety Review On')
            ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'Safety Review On';
            $history->previous = $lastCft->Environment_Health_Safety_on;
            $history->current = $request->Environment_Health_Safety_on;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }

        /*************** Information Technology ***************/
        if ($lastCft->Information_Technology_review != $request->Information_Technology_review && $request->Information_Technology_review != null) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
            ->where('activity_type', 'Information Technology Review Required')
            ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'Information Technology Review Required';
            $history->previous = $lastCft->Information_Technology_review;
            $history->current = $request->Information_Technology_review;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }
        if ($lastCft->Information_Technology_person != $request->Information_Technology_person && $request->Information_Technology_person != null) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
            ->where('activity_type', 'Information Technology Person')
            ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'Information Technology Person';
            $history->previous = $lastCft->Information_Technology_person;
            $history->current = $request->Information_Technology_person;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }
        if ($lastCft->Information_Technology_assessment != $request->Information_Technology_assessment && $request->Information_Technology_assessment != null) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
            ->where('activity_type', 'Information Technology Assessment')
            ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'Information Technology Assessment';
            $history->previous = $lastCft->Information_Technology_assessment;
            $history->current = $request->Information_Technology_assessment;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }
        if ($lastCft->Information_Technology_feedback != $request->Information_Technology_feedback && $request->Information_Technology_feedback != null) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
            ->where('activity_type', 'Information Technology Feedback')
            ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'Information Technology Feedback';
            $history->previous = $lastCft->Information_Technology_feedback;
            $history->current = $request->Information_Technology_feedback;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }
        if ($lastCft->Information_Technology_by != $request->Information_Technology_by && $request->Information_Technology_by != null) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
            ->where('activity_type', 'Information Technology Review By')
            ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'Information Technology Review By';
            $history->previous = $lastCft->Information_Technology_by;
            $history->current = $request->Information_Technology_by;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }
        if ($lastCft->Information_Technology_on != $request->Information_Technology_on && $request->Information_Technology_on != null) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
            ->where('activity_type', 'Information Technology Review On')
            ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'Information Technology Review On';
            $history->previous = $lastCft->Information_Technology_on;
            $history->current = $request->Information_Technology_on;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }

        /*************** Contract Giver ***************/
        if ($lastCft->ContractGiver_Review != $request->ContractGiver_Review && $request->ContractGiver_Review != null) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
            ->where('activity_type', 'Contract Giver Review Required')
            ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'Contract Giver Review Required';
            $history->previous = $lastCft->ContractGiver_Review;
            $history->current = $request->ContractGiver_Review;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }
        if ($lastCft->ContractGiver_person != $request->ContractGiver_person && $request->ContractGiver_person != null) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
            ->where('activity_type', 'Contract Giver Person')
            ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'Contract Giver Person';
            $history->previous = $lastCft->ContractGiver_person;
            $history->current = $request->ContractGiver_person;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }
        if ($lastCft->ContractGiver_assessment != $request->ContractGiver_assessment && $request->ContractGiver_assessment != null) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
            ->where('activity_type', 'Contract Giver Assessment')
            ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'Contract Giver Assessment';
            $history->previous = $lastCft->ContractGiver_assessment;
            $history->current = $request->ContractGiver_assessment;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }
        if ($lastCft->ContractGiver_feedback != $request->ContractGiver_feedback && $request->ContractGiver_feedback != null) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
            ->where('activity_type', 'Contract Giver Feedback')
            ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'Contract Giver Feedback';
            $history->previous = $lastCft->ContractGiver_feedback;
            $history->current = $request->ContractGiver_feedback;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }
        if ($lastCft->ContractGiver_by != $request->ContractGiver_by && $request->ContractGiver_by != null) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
            ->where('activity_type', 'Contract Giver Review By')
            ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'Contract Giver Review By';
            $history->previous = $lastCft->ContractGiver_by;
            $history->current = $request->ContractGiver_by;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }
        if ($lastCft->ContractGiver_on != $request->ContractGiver_on && $request->ContractGiver_on != null) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
            ->where('activity_type', 'Contract Giver Review On')
            ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'Contract Giver Review On';
            $history->previous = $lastCft->ContractGiver_on;
            $history->current = $request->ContractGiver_on;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }
        
        if ($lastDocument->Microbiology_Person != $openState->Microbiology_Person && $request->Microbiology_Person != null) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
            ->where('activity_type', 'CFT Reviewer Person')
            ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'CFT Reviewer Person';
            $history->previous = $lastDocument->Microbiology_Person;
            $history->current = $openState->Microbiology_Person;
            $history->comment = $request->Microbiology_Person_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }
    
        /*************** Other 1 ***************/
        if ($lastCft->Other1_review != $request->Other1_review && $request->Other1_review != null) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
            ->where('activity_type', 'Other 1 Review Required')
            ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'Other 1 Review Required';
            $history->previous = $lastCft->Other1_review;
            $history->current = $request->Other1_review;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }
        if ($lastCft->Other1_person != $request->Other1_person && $request->Other1_person != null) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
            ->where('activity_type', 'Other 1 Person')
            ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'Other 1 Person';
            $history->previous = $lastCft->Other1_person;
            $history->current = $request->Other1_person;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }
        if ($lastCft->Other1_Department_person != $request->Other1_Department_person && $request->Other1_Department_person != null) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
            ->where('activity_type', 'Other 1 Review Required')
            ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'Other 1 Review Required';
            $history->previous = $lastCft->Other1_Department_person;
            $history->current = $request->Other1_Department_person;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }
        if ($lastCft->Other1_assessment != $request->Other1_assessment && $request->Other1_assessment != null) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
            ->where('activity_type', 'Other 1 Assessment')
            ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'Other 1 Assessment';
            $history->previous = $lastCft->Other1_assessment;
            $history->current = $request->Other1_assessment;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }
        if ($lastCft->Other1_feedback != $request->Other1_feedback && $request->Other1_feedback != null) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
            ->where('activity_type', 'Other 1 Feedback')
            ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'Other 1 Feedback';
            $history->previous = $lastCft->Other1_feedback;
            $history->current = $request->Other1_feedback;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }
        if ($lastCft->Other1_by != $request->Other1_by && $request->Other1_by != null) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
            ->where('activity_type', 'Other 1 Review By')
            ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'Other 1 Review By';
            $history->previous = $lastCft->Other1_by;
            $history->current = $request->Other1_by;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }
        if ($lastCft->Other1_on != $request->Other1_on && $request->Other1_on != null) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
            ->where('activity_type', '')
            ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'Other 1 Review On';
            $history->previous = $lastCft->Other1_on;
            $history->current = $request->Other1_on;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }


        /*************** Other 2 ***************/
        if ($lastCft->Other2_review != $request->Other2_review && $request->Other2_review != null) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
            ->where('activity_type', 'Other 2 Review Required')
            ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'Other 2 Review Required';
            $history->previous = $lastCft->Other2_review;
            $history->current = $request->Other2_review;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }
        if ($lastCft->Other2_person != $request->Other2_person && $request->Other2_person != null) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
            ->where('activity_type', 'Other 2 Person')
            ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'Other 2 Person';
            $history->previous = $lastCft->Other2_person;
            $history->current = $request->Other2_person;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }
        if ($lastCft->Other2_Department_person != $request->Other2_Department_person && $request->Other2_Department_person != null) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
            ->where('activity_type', 'Other 2 Review Required')
            ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'Other 2 Review Required';
            $history->previous = $lastCft->Other2_Department_person;
            $history->current = $request->Other2_Department_person;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }
        if ($lastCft->Other2_assessment != $request->Other2_assessment && $request->Other2_assessment != null) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
            ->where('activity_type', 'Other 2 Assessment')
            ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'Other 2 Assessment';
            $history->previous = $lastCft->Other2_assessment;
            $history->current = $request->Other2_assessment;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }
        if ($lastCft->Other2_feedback != $request->Other2_feedback && $request->Other2_feedback != null) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
            ->where('activity_type', 'Other 2 Feedback')
            ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'Other 2 Feedback';
            $history->previous = $lastCft->Other2_feedback;
            $history->current = $request->Other2_feedback;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }
        if ($lastCft->Other2_by != $request->Other2_by && $request->Other2_by != null) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
            ->where('activity_type', 'Other 2 Review By')
            ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'Other 2 Review By';
            $history->previous = $lastCft->Other2_by;
            $history->current = $request->Other2_by;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }
        if ($lastCft->Other2_on != $request->Other2_on && $request->Other2_on != null) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
            ->where('activity_type', 'Other 2 Review On')
            ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'Other 2 Review On';
            $history->previous = $lastCft->Other2_on;
            $history->current = $request->Other2_on;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }

        /*************** Other 3 ***************/
        // Other 3 Review Required
if ($lastCft->Other3_review != $request->Other3_review && $request->Other3_review != null) {
    $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
        ->where('activity_type', 'Other 3 Review Required')
        ->exists();
    $history = new GlobalChangeControlAuditTrail;
    $history->cc_id = $id;
    $history->activity_type = 'Other 3 Review Required';
    $history->previous = $lastCft->Other3_review;
    $history->current = $request->Other3_review;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = "Not Applicable";
    $history->change_from = $lastDocument->status;
    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
    $history->save();
}

// Other 3 Person
if ($lastCft->Other3_person != $request->Other3_person && $request->Other3_person != null) {
    $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
        ->where('activity_type', 'Other 3 Person')
        ->exists();
    $history = new GlobalChangeControlAuditTrail;
    $history->cc_id = $id;
    $history->activity_type = 'Other 3 Person';
    $history->previous = $lastCft->Other3_person;
    $history->current = $request->Other3_person;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = "Not Applicable";
    $history->change_from = $lastDocument->status;
    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
    $history->save();
}

// Other 3 Department Person
if ($lastCft->Other3_Department_person != $request->Other3_Department_person && $request->Other3_Department_person != null) {
    $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
        ->where('activity_type', 'Other 3 Department Person')
        ->exists();
    $history = new GlobalChangeControlAuditTrail;
    $history->cc_id = $id;
    $history->activity_type = 'Other 3 Department Person';
    $history->previous = $lastCft->Other3_Department_person;
    $history->current = $request->Other3_Department_person;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = "Not Applicable";
    $history->change_from = $lastDocument->status;
    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
    $history->save();
}

// Other 3 Assessment
if ($lastCft->Other3_assessment != $request->Other3_assessment && $request->Other3_assessment != null) {
    $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
        ->where('activity_type', 'Other 3 Assessment')
        ->exists();
    $history = new GlobalChangeControlAuditTrail;
    $history->cc_id = $id;
    $history->activity_type = 'Other 3 Assessment';
    $history->previous = $lastCft->Other3_assessment;
    $history->current = $request->Other3_assessment;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = "Not Applicable";
    $history->change_from = $lastDocument->status;
    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
    $history->save();
}

// Other 3 Feedback
if ($lastCft->Other3_feedback != $request->Other3_feedback && $request->Other3_feedback != null) {
    $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
        ->where('activity_type', 'Other 3 Feedback')
        ->exists();
    $history = new GlobalChangeControlAuditTrail;
    $history->cc_id = $id;
    $history->activity_type = 'Other 3 Feedback';
    $history->previous = $lastCft->Other3_feedback;
    $history->current = $request->Other3_feedback;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = "Not Applicable";
    $history->change_from = $lastDocument->status;
    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
    $history->save();
}

// Other 3 Review By
if ($lastCft->Other3_by != $request->Other3_by && $request->Other3_by != null) {
    $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
        ->where('activity_type', 'Other 3 Review By')
        ->exists();
    $history = new GlobalChangeControlAuditTrail;
    $history->cc_id = $id;
    $history->activity_type = 'Other 3 Review By';
    $history->previous = $lastCft->Other3_by;
    $history->current = $request->Other3_by;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = "Not Applicable";
    $history->change_from = $lastDocument->status;
    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
    $history->save();
}

// Other 3 Review On
if ($lastCft->Other3_on != $request->Other3_on && $request->Other3_on != null) {
    $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
        ->where('activity_type', 'Other 3 Review On')
        ->exists();
    $history = new GlobalChangeControlAuditTrail;
    $history->cc_id = $id;
    $history->activity_type = 'Other 3 Review On';
    $history->previous = $lastCft->Other3_on;
    $history->current = $request->Other3_on;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = "Not Applicable";
    $history->change_from = $lastDocument->status;
    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
    $history->save();
}

        /*************** Other 4 ***************/
        if ($lastCft->Other4_review != $request->Other4_review && $request->Other4_review != null) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
                ->where('activity_type', 'Other 4 Review Required')
                ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'Other 4 Review Required';
            $history->previous = $lastCft->Other4_review;
            $history->current = $request->Other4_review;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }
        
        if ($lastCft->Other4_person != $request->Other4_person && $request->Other4_person != null) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
                ->where('activity_type', 'Other 4 Person')
                ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'Other 4 Person';
            $history->previous = $lastCft->Other4_person;
            $history->current = $request->Other4_person;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }
        
        if ($lastCft->Other4_Department_person != $request->Other4_Department_person && $request->Other4_Department_person != null) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
                ->where('activity_type', 'Other 4 Department Person')
                ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'Other 4 Department Person';
            $history->previous = $lastCft->Other4_Department_person;
            $history->current = $request->Other4_Department_person;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }
        
        if ($lastCft->Other4_assessment != $request->Other4_assessment && $request->Other4_assessment != null) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
                ->where('activity_type', 'Other 4 Assessment')
                ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'Other 4 Assessment';
            $history->previous = $lastCft->Other4_assessment;
            $history->current = $request->Other4_assessment;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }
        
        if ($lastCft->Other4_feedback != $request->Other4_feedback && $request->Other4_feedback != null) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
                ->where('activity_type', 'Other 4 Feedback')
                ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'Other 4 Feedback';
            $history->previous = $lastCft->Other4_feedback;
            $history->current = $request->Other4_feedback;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }
        
        if ($lastCft->Other4_by != $request->Other4_by && $request->Other4_by != null) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
                ->where('activity_type', 'Other 4 Review By')
                ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'Other 4 Review By';
            $history->previous = $lastCft->Other4_by;
            $history->current = $request->Other4_by;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }
        
        if ($lastCft->Other4_on != $request->Other4_on && $request->Other4_on != null) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
                ->where('activity_type', 'Other 4 Review On')
                ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'Other 4 Review On';
            $history->previous = $lastCft->Other4_on;
            $history->current = $request->Other4_on;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }
        

        /*************** Other 5 ***************/
        if ($lastCft->Other5_review != $request->Other5_review && $request->Other5_review != null) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
                ->where('activity_type', 'Other 5 Review Required')
                ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'Other 5 Review Required';
            $history->previous = $lastCft->Other5_review;
            $history->current = $request->Other5_review;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }
        
        if ($lastCft->Other5_person != $request->Other5_person && $request->Other5_person != null) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
                ->where('activity_type', 'Other 5 Person')
                ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'Other 5 Person';
            $history->previous = $lastCft->Other5_person;
            $history->current = $request->Other5_person;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }
        
        if ($lastCft->Other5_Department_person != $request->Other5_Department_person && $request->Other5_Department_person != null) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
                ->where('activity_type', 'Other 5 Department Person')
                ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'Other 5 Department Person';
            $history->previous = $lastCft->Other5_Department_person;
            $history->current = $request->Other5_Department_person;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }
        
        if ($lastCft->Other5_assessment != $request->Other5_assessment && $request->Other5_assessment != null) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
                ->where('activity_type', 'Other 5 Assessment')
                ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'Other 5 Assessment';
            $history->previous = $lastCft->Other5_assessment;
            $history->current = $request->Other5_assessment;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }
        
        if ($lastCft->Other5_feedback != $request->Other5_feedback && $request->Other5_feedback != null) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
                ->where('activity_type', 'Other 5 Feedback')
                ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'Other 5 Feedback';
            $history->previous = $lastCft->Other5_feedback;
            $history->current = $request->Other5_feedback;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }
        
        if ($lastCft->Other5_by != $request->Other5_by && $request->Other5_by != null) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
                ->where('activity_type', 'Other 5 Review By')
                ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'Other 5 Review By';
            $history->previous = $lastCft->Other5_by;
            $history->current = $request->Other5_by;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }
        
        if ($lastCft->Other5_on != $request->Other5_on && $request->Other5_on != null) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
                ->where('activity_type', 'Other 5 Review On')
                ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'Other 5 Review On';
            $history->previous = $lastCft->Other5_on;
            $history->current = $request->Other5_on;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }
        
        /************ CFT Review End ************/

         /************ Evalution ************/

        //  if ($lastevaluation->qa_eval_comments != $evaluation->qa_eval_comments ) {
        //     // dd($lastevaluation->qa_eval_comments);
        //     $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
        //         ->where('activity_type', 'QA Evaluation Comments')
        //         ->exists();
        //     $history = new GlobalChangeControlAuditTrail;
        //     $history->cc_id = $id;
        //     $history->activity_type = 'QA Evaluation Comments';
        //     $history->previous = $lastevaluation->qa_eval_comments;
        //     $history->current = $evaluation->qa_eval_comments;
        //     // dd($history->current);
        //     $history->comment = $request->qa_eval_comments_comment;
        //     $history->user_id = Auth::user()->id;
        //     $history->user_name = Auth::user()->name;
        //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        //     $history->origin_state = $lastDocument->status;
        //     $history->change_to =   "Not Applicable";
        //     $history->change_from = $lastDocument->status;
        //     $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
        //     $history->save();
        // }

        if ($lastDocument->qa_eval_comments != $request->qa_eval_comments && $request->qa_eval_comments != null) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
                ->where('activity_type', 'QA Evaluation Comments')
                ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'QA Evaluation Comments';
            $history->previous = $lastDocument->qa_eval_comments;
            $history->current = $request->qa_eval_comments;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }
        if (is_array($request->qa_eval_attach)) {
            $request->qa_eval_attach = implode(', ', $request->qa_eval_attach);
        }
        if ($lastDocument->qa_eval_attach != $request->qa_eval_attach && $request->qa_eval_attach != null) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
                ->where('activity_type', 'QA Evaluation Attachments')
                ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'QA Evaluation Attachments';
            $history->previous = is_array($lastDocument->qa_eval_attach) ? implode(', ', $lastDocument->qa_eval_attach) : $lastDocument->qa_eval_attach;
            $history->current = $request->qa_eval_attach;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }
        

        if ($lastDocument->intial_update_comments != $request->intial_update_comments && $request->intial_update_comments != null) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
                ->where('activity_type', 'Initiator Update Comments')
                ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'Initiator Update Comments';
            $history->previous = $lastDocument->intial_update_comments;
            $history->current = $request->intial_update_comments;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }



        if ($lastCft->hod_final_review_comment != $request->hod_final_review_comment && $request->hod_final_review_comment != null) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
                ->where('activity_type', 'HOD Final Review Comments')
                ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'HOD Final Review Comments';
            $history->previous = $lastCft->hod_final_review_comment;
            $history->current = $request->hod_final_review_comment;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }

        if (is_array($request->hod_final_review_attach)) {
            $request->hod_final_review_attach = implode(', ', $request->hod_final_review_attach);
        }
        if (is_array($lastCft->hod_final_review_attach)) {
            $lastCft->hod_final_review_attach = implode(', ', $lastCft->hod_final_review_attach);
        }
        
        if ($lastCft->hod_final_review_attach != $request->hod_final_review_attach && $request->hod_final_review_attach != null) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
                ->where('activity_type', 'HOD Final Review Attachments')
                ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'HOD Final Review Attachments';
            $history->previous = $lastCft->hod_final_review_attach;
            $history->current = $request->hod_final_review_attach;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }

       
        
        /************ Evalution End ************/

        /************ QA Approval ************/

        if ($lastDocument->qa_appro_comments != $openState->qa_appro_comments ) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
                ->where('activity_type', 'QA Approval Comment')
                ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'QA Approval Comment';
            $history->previous = $lastDocument->qa_appro_comments;
            $history->current = $openState->qa_appro_comments;
            $history->comment = $request->qa_appro_comments_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }

        if ($lastDocument->implementation_verification_comments != $openState->implementation_verification_comments ) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
                ->where('activity_type', 'Feedback')
                ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'Implementation Verification Comments';
            $history->previous = $lastDocument->implementation_verification_comments;
            $history->current = $openState->implementation_verification_comments;
            $history->comment = $request->feedback_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }
        if ($lastDocument->feedback != $openState->feedback ) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
                ->where('activity_type', 'Feedback')
                ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'Training Feedback';
            $history->previous = $lastDocument->feedback;
            $history->current = $openState->feedback;
            $history->comment = $request->feedback_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
        }

        /************ QA Approval Ends ************/

        /************ Change Closure ************/
        if ($lastDocument->qa_closure_comments != $openState->qa_closure_comments) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
                ->where('activity_type', 'QA Closure Comment')
                ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'QA Closure Comment';
            $history->previous = $lastDocument->qa_closure_comments;
            $history->current = $openState->qa_closure_comments;
            $history->comment = "";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
            // return $closure;
        }
        if ($lastDocument->due_date_extension != $openState->due_date_extension) {
            $lastDocumentAuditTrail = RcmDocHistory::where('cc_id', $id)
                ->where('activity_type', 'Due Date Extension')
                ->exists();
            $history = new GlobalChangeControlAuditTrail;
            $history->cc_id = $id;
            $history->activity_type = 'Due Date Extension';
            $history->previous = $lastDocument->due_date_extension;
            $history->current = $openState->due_date_extension;
            $history->comment = "";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->save();
            // return $closure;
        }

        /************ Change Closure Ends ************/
        return back();
    }


    public function destroy($id)
    {
    }

    public function stageChange(Request $request, $id)
    {
        if($request->username == Auth::user()->Username && Hash::check($request->password, Auth::user()->password)) {
            $changeControl = GlobalChangeControl::find($id);
            $lastDocument = GlobalChangeControl::find($id);

            $evaluation = Evaluation::where('cc_id', $id)->first();
            $updateCFT = GlobalChangeControlCft::where('cc_id', $id)->latest()->first();
            $cftDetails = GlobalChangeControlResponse::withoutTrashed()->where(['status' => 'In-progress', 'cc_id' => $id])->distinct('cft_user_id')->count();
            if ($changeControl->stage == 1) {
                    $changeControl->stage = "2";
                    $changeControl->status = "HOD Assessment";
                    $changeControl->submit_by = Auth::user()->name;
                    $changeControl->submit_on = Carbon::now()->format('d-M-Y');
                    $changeControl->submit_comment = $request->comments;

                    $history = new GlobalChangeControlAuditTrail();
                    $history->cc_id = $id;

                    $history->activity_type = 'Submit By, Submit On';
                    if (is_null($lastDocument->submit_by) || $lastDocument->submit_by === '') {
                        $history->previous = "NULL";
                    } else {
                        $history->previous = $lastDocument->submit_by . ' , ' . $lastDocument->submit_on;
                    }
                    $history->current = $changeControl->submit_by . ' , ' . $changeControl->submit_on;
                    if (is_null($lastDocument->submit_by) || $lastDocument->submit_on === '') {
                        $history->action_name = 'New';
                    } else {
                        $history->action_name = 'Update';
                    }

                    $history->action = 'Submit';
                    $history->comment = $request->comments;
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $lastDocument->status;
                    $history->change_to = "HOD Assessment";
                    $history->change_from = $lastDocument->status;
                    $history->stage = 'Plan Proposed';
                    
                    $history->save();

                    /********** Notification User **********/
                    $list = Helpers::getHodUserList($changeControl->division_id);
                    $userIds = collect($list)->pluck('user_id')->toArray();
                    $users = User::whereIn('id', $userIds)->select('id', 'name', 'email')->get();
                    $userIds = $users->pluck('id');

                    foreach ($users as $userValue) {
                        DB::table('notifications')->insert([
                            'activity_id' => $changeControl->id,
                            'activity_type' => "Notification",
                            'from_id' => Auth::user()->id,
                            'user_name' => $userValue->name,
                            'to_id' => $userValue->id,
                            'process_name' => "Change Control",
                            'division_id' => $changeControl->division_id,
                            'short_description' => $changeControl->short_description,
                            'initiator_id' => $changeControl->initiator_id,
                            'due_date' => $changeControl->due_date,
                            'record' => $changeControl->record,
                            'site' => "GlobalCC",
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
                                    ['data' => $changeControl, 'site' => "GlobalCC", 'history' => "Submit", 'process' => 'Change Control', 'comment' => $request->comments, 'user' => Auth::user()->name],
                                    function ($message) use ($email, $changeControl) {
                                        $message->to($email)
                                        ->subject("Medicef Notification: Change Control, Record #" . str_pad($changeControl->record, 4, '0', STR_PAD_LEFT) . " - Activity: Submit Performed");
                                    }
                                );
                            } catch(\Exception $e) {
                                info('Error sending mail', [$e]);
                            }
                        }
                    }

                    // if ($userIds->isNotEmpty()) {
                    //     try {
                    //         foreach ($userIds as $userId) {
                    //             DB::table('notification_users')->insert([
                    //                 'record_id' => $changeControl->id,
                    //                 'record_type' => "GlobalCC",
                    //                 'from_id' => Auth::user()->id,
                    //                 'to_id' => $userId,
                    //                 'roles_id' => 4,
                    //             ]);
                    //         }
                    //     } catch (\Throwable $e) {
                    //         \Log::error('Notification creation failed: ' . $e->getMessage());
                    //     }
                    // }

                    $changeControl->update();
                    toastr()->success('Sent to HOD Assessment');
                    return back();

            }
            if ($changeControl->stage == 2) {
           
                if (empty($lastDocument->hod_assessment_comments))
                {
                    Session::flash('swal', [
                        'type' => 'warning',
                        'title' => 'Mandatory Fields!',
                        'message' => 'Initial HOD Review Tab is yet to be filled'
                    ]);
                    
                    return redirect()->back();
                }
                else {
                    Session::flash('swal', [
                        'type' => 'success',
                        'title' => 'Success',
                        'message' => 'Document Sent'
                    ]);
                }
                    $changeControl->stage = "3";
                    $changeControl->status = "QA/CQA Initial Assessment";
                    $changeControl->hod_review_by = Auth::user()->name;
                    $changeControl->hod_review_on = Carbon::now()->format('d-M-Y');
                    $changeControl->hod_review_comment = $request->comments;

                    $history = new GlobalChangeControlAuditTrail();
                    $history->cc_id = $id;
                    $history->activity_type = 'Activity Log';
                    
                    $history->activity_type = 'HOD Assessment Complete By, HOD Assessment Complete On';
                    if (is_null($lastDocument->hod_review_by) || $lastDocument->hod_review_by === '') {
                        $history->previous = "NULL";
                    } else {
                        $history->previous = $lastDocument->hod_review_by . ' , ' . $lastDocument->hod_review_on;
                    }
                    $history->current = $changeControl->hod_review_by . ' , ' . $changeControl->hod_review_on;
                    if (is_null($lastDocument->hod_review_by) || $lastDocument->hod_review_on === '') {
                        $history->action_name = 'New';
                    } else {
                        $history->action_name = 'Update';
                    }

                    $history->action = 'HOD Assessment Complete';
                    $history->comment = $request->comments;
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $lastDocument->status;
                    $history->change_to = "QA/CQA Initial Assessment";
                    $history->change_from = $lastDocument->status;
                    $history->stage = 'Plan Proposed';
                    $history->save();


                    $list = Helpers::getQAUserList($changeControl->division_id);
                    $userIds = collect($list)->pluck('user_id')->toArray();
                    $users = User::whereIn('id', $userIds)->select('id', 'name', 'email')->get();
                    $userIds = $users->pluck('id');

                    foreach ($users as $userValue) {
                        DB::table('notifications')->insert([
                            'activity_id' => $changeControl->id,
                            'activity_type' => "Notification",
                            'from_id' => Auth::user()->id,
                            'user_name' => $userValue->name,
                            'to_id' => $userValue->id,
                            'process_name' => "Change Control",
                            'division_id' => $changeControl->division_id,
                            'short_description' => $changeControl->short_description,
                            'initiator_id' => $changeControl->initiator_id,
                            'due_date' => $changeControl->due_date,
                            'record' => $changeControl->record,
                            'site' => "GlobalCC",
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
                                    ['data' => $changeControl, 'site' => "GlobalCC", 'history' => "HOD Assessment Complete", 'process' => 'Change Control', 'comment' => $request->comments, 'user' => Auth::user()->name],
                                    function ($message) use ($email, $changeControl) {
                                        $message->to($email)
                                        ->subject("Medicef Notification: Change Control, Record #" . str_pad($changeControl->record, 4, '0', STR_PAD_LEFT) . " - Activity: HOD Assessment Performed");
                                    }
                                );
                            } catch(\Exception $e) {
                                info('Error sending mail', [$e]);
                            }
                        }
                    }

                    // if ($userIds->isNotEmpty()) {
                    //     try {
                    //         foreach ($userIds as $userId) {
                    //             DB::table('notification_users')->insert([
                    //                 'record_id' => $changeControl->id,
                    //                 'record_type' => "GlobalCC",
                    //                 'from_id' => Auth::user()->id,
                    //                 'to_id' => $userId,
                    //                 'roles_id' => 4,
                    //             ]);
                    //         }
                    //     } catch (\Throwable $e) {
                    //         \Log::error('Notification creation failed: ' . $e->getMessage());
                    //     }
                    // }

                    $changeControl->update();
                    toastr()->success('Sent to QA Initial Assessment');
                    return back();
            }
            if ($changeControl->stage == 3) {
                // if (empty($updateCFT->RA_Review))
                // {
                //     Session::flash('swal', [
                //         'type' => 'warning',
                //         'title' => 'Mandatory Fields!',
                //         'message' => 'CFT Tab is yet to be filled'
                //     ]);
                    
                //     return redirect()->back();
                // }
                // else {
                //     Session::flash('swal', [
                //         'type' => 'success',
                //         'title' => 'Success',
                //         'message' => 'Document Sent'
                //     ]);
                // }

                $changeControl->stage = "4";
                $changeControl->status = "CFT Assessment";

                    // Code for the CFT required
                $stage = new GlobalChangeControlResponse();
                $stage->cc_id = $id;
                $stage->cft_user_id = Auth::user()->id;
                $stage->status = "CFT Required";
                
                $stage->comment = $request->comment;
                $stage->is_required = 1;
                $stage->save();

                $changeControl->QA_initial_review_by = Auth::user()->name;
                $changeControl->QA_initial_review_on = Carbon::now()->format('d-M-Y');
                $changeControl->QA_initial_review_comment = $request->comments;

                $history = new GlobalChangeControlAuditTrail();
                $history->cc_id = $id;
                $history->activity_type = 'Activity Log';
                
                $history->activity_type = 'QA/CQA Initial Assessment Complete By, QA/CQA Initial Assessment Complete On';
                if (is_null($lastDocument->QA_initial_review_by) || $lastDocument->QA_initial_review_by === '') {
                    $history->previous = "NULL";
                } else {
                    $history->previous = $lastDocument->QA_initial_review_by . ' , ' . $lastDocument->QA_initial_review_on;
                }
                $history->current = $changeControl->QA_initial_review_by . ' , ' . $changeControl->QA_initial_review_on;
                if (is_null($lastDocument->QA_initial_review_by) || $lastDocument->QA_initial_review_on === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }

                $history->action = 'QA/CQA Initial Assessment Complete';
                $history->comment = $request->comments;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to = "CFT Assessment";
                $history->change_from = $lastDocument->status;
                $history->stage = 'Plan Proposed';
                $history->save();

                $list = Helpers::getCftUserList($changeControl->division_id);
                $userIds = collect($list)->pluck('user_id')->toArray();
                $users = User::whereIn('id', $userIds)->select('id', 'name', 'email')->get();
                $userIds = $users->pluck('id');

                foreach ($users as $userValue) {
                    DB::table('notifications')->insert([
                        'activity_id' => $changeControl->id,
                        'activity_type' => "Notification",
                        'from_id' => Auth::user()->id,
                        'user_name' => $userValue->name,
                        'to_id' => $userValue->id,
                        'process_name' => "Change Control",
                        'division_id' => $changeControl->division_id,
                        'short_description' => $changeControl->short_description,
                        'initiator_id' => $changeControl->initiator_id,
                        'due_date' => $changeControl->due_date,
                        'record' => $changeControl->record,
                        'site' => "GlobalCC",
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
                                ['data' => $changeControl, 'site' => "GlobalCC", 'history' => "QA/CQA Initial Assessment Complete", 'process' => 'Change Control', 'comment' => $request->comments, 'user' => Auth::user()->name],
                                function ($message) use ($email, $changeControl) {
                                    $message->to($email)
                                    ->subject("Medicef Notification: Change Control, Record #" . str_pad($changeControl->record, 4, '0', STR_PAD_LEFT) . " - Activity: QA/CQA Initial Assessment Performed");
                                }
                            );
                        } catch(\Exception $e) {
                            info('Error sending mail', [$e]);
                        }
                    }
                }

                
                // if ($userIds->isNotEmpty()) {
                //     try {
                //         foreach ($userIds as $userId) {
                //             DB::table('notification_users')->insert([
                //                 'record_id' => $changeControl->id,
                //                 'record_type' => "GlobalCC",
                //                 'from_id' => Auth::user()->id,
                //                 'to_id' => $userId,
                //                 'roles_id' => 4,
                //             ]);
                //         }
                //     } catch (\Throwable $e) {
                //         \Log::error('Notification creation failed: ' . $e->getMessage());
                //     }
                // }

                $changeControl->update();
                toastr()->success('Sent to CFT Assessment');
                return back();
            }
            
            if ($changeControl->stage == 4) {

                $IsCFTRequired = GlobalChangeControlResponse::withoutTrashed()->where(['is_required' => 1, 'cc_id' => $id])->latest()->first();
                $cftUsers = DB::table('global_change_controls_cfts')->where(['cc_id' => $id])->first();

                /****** CFT Person ******/
                $columns = ['Production_person', 'Quality_Control_Person', 'Warehouse_person', 'Engineering_person', 'ResearchDevelopment_person', 'RegulatoryAffair_person', 'CQA_person', 'Microbiology_person', 'QualityAssurance_person','SystemIT_person','Human_Resource_person','Other1_person','Other2_person','Other3_person','Other4_person','Other5_person'];
                // Initialize an array to store the values

                $valuesArray = [];

                // Iterate over the columns and retrieve the values
                foreach ($columns as $index => $column) {
                    $value = $cftUsers->$column;
                    if ($index == 0 && $cftUsers->$column == Auth::user()->id) {
                        $updateCFT->Production_by = Auth::user()->name;
                        $updateCFT->production_on = Carbon::now()->format('Y-m-d');

                        $history = new GlobalChangeControlAuditTrail();
                        $history->cc_id = $id;
                        $history->activity_type = 'Production Completed By, Production Completed On';

                        if (is_null($lastDocument->Production_by) || $lastDocument->production_on == '') {
                            $history->previous = "";
                        } else {
                            $history->previous = $lastDocument->Production_by . ' , ' . $lastDocument->production_on;
                        }

                        $history->action = 'CFT Review Complete';
                        
                        $history->current = $updateCFT->Production_by . ', ' . $updateCFT->production_on;

                        $history->comment = $request->comment;
                        $history->user_id = Auth::user()->name;
                        $history->user_name = Auth::user()->name;
                        $history->change_to = "Not Applicable";
                        $history->change_from = $lastDocument->status;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->origin_state = $lastDocument->status;
                        $history->stage = 'CFT Review';

                        if (is_null($lastDocument->Production_by) || $lastDocument->production_on == '') {
                            $history->action_name = 'New';
                        } else {
                            $history->action_name = 'Update';
                        }

                        $history->save();
                    }

                    if ($index == 1 && $cftUsers->$column == Auth::user()->id) {
                        $updateCFT->Quality_Control_by = Auth::user()->name;
                        $updateCFT->Quality_Control_on = Carbon::now()->format('Y-m-d'); // Corrected line
                    
                        $history = new GlobalChangeControlAuditTrail();
                        $history->cc_id = $id;
                        $history->activity_type = 'Quality Control Completed By, Quality Control Completed On';
                    
                        if (is_null($lastDocument->Quality_Control_by) || $lastDocument->Quality_Control_on == '') {
                            $history->previous = "";
                        } else {
                            $history->previous = $lastDocument->Quality_Control_by . ' ,' .Helpers::getdateFormat ($lastDocument->Quality_Control_on);
                        }
                    
                        $history->action = 'CFT Review Complete';
                        $history->current = $updateCFT->Quality_Control_by . ',' .Helpers::getdateFormat ($updateCFT->Quality_Control_on);
                        $history->comment = $request->comment;
                        $history->user_id = Auth::user()->id; // Use `id` instead of `name` for `user_id`
                        $history->user_name = Auth::user()->name;
                        $history->change_to = "Not Applicable";
                        $history->change_from = $lastDocument->status;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->origin_state = $lastDocument->status;
                        $history->stage = 'CFT Review';
                    
                        if (is_null($lastDocument->Quality_Control_by) || $lastDocument->Quality_Control_on == '') {
                            $history->action_name = 'New';
                        } else {
                            $history->action_name = 'Update';
                        }
                    
                        $history->save();
                    }

                    if($index == 2 && $cftUsers->$column == Auth::user()->id){
                        $updateCFT->Warehouse_by = Auth::user()->name;
                        $updateCFT->Warehouse_on = Carbon::now()->format('Y-m-d');
                        $history = new GlobalChangeControlAuditTrail();
                        $history->cc_id = $id;
                        $history->activity_type = 'Warehouse Completed By, Warehouse Completed On';
                        if(is_null($lastDocument->Warehouse_by) || $lastDocument->Warehouse_on == ''){
                            $history->previous = "";
                        }else{
                            $history->previous = $lastDocument->Warehouse_by. ' ,' .Helpers::getdateFormat ($lastDocument->Warehouse_on);
                        }
                        $history->action='CFT Review Complete';
                        $history->current = $updateCFT->Warehouse_by. ',' . Helpers::getdateFormat($updateCFT->Warehouse_on);
                        $history->comment = $request->comment;
                        $history->user_id = Auth::user()->name;
                        $history->user_name = Auth::user()->name;
                        $history->change_to =   "Not Applicable";
                        $history->change_from = $lastDocument->status;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->origin_state = $lastDocument->status;
                        $history->stage = 'CFT Review';
                        if(is_null($lastDocument->Warehouse_by) || $lastDocument->Warehouse_on == '')
                        {
                            $history->action_name = 'New';
                        } else {
                            $history->action_name = 'Update';
                        }
                        $history->save();
                    }
                    
                    if($index == 3 && $cftUsers->$column == Auth::user()->id){
                        $updateCFT->Engineering_by = Auth::user()->name;
                        $updateCFT->Engineering_on = Carbon::now()->format('Y-m-d');
                        $history = new GlobalChangeControlAuditTrail();
                        $history->cc_id = $id;
                        $history->activity_type = 'Engineering Completed By, Engineering Completed On';
                        if(is_null($lastDocument->Engineering_by) || $lastDocument->Engineering_on == ''){
                            $history->previous = "";
                        }else{
                            $history->previous = $lastDocument->Engineering_by. ' ,' . Helpers::getdateFormat($lastDocument->Engineering_on);
                        }
                        $history->action='CFT Review Complete';
                        $history->current = $updateCFT->Engineering_by. ',' . Helpers::getdateFormat($updateCFT->Engineering_on);
                        $history->comment = $request->comment;
                        $history->user_id = Auth::user()->name;
                        $history->user_name = Auth::user()->name;
                        $history->change_to =   "Not Applicable";
                        $history->change_from = $lastDocument->status;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->origin_state = $lastDocument->status;
                        $history->stage = 'CFT Review';
                        if(is_null($lastDocument->Engineering_by) || $lastDocument->Engineering_on == '')
                        {
                            $history->action_name = 'New';
                        } else {
                            $history->action_name = 'Update';
                        }
                        $history->save();
                    }

                    if($index == 4 && $cftUsers->$column == Auth::user()->id){
                        $updateCFT->ResearchDevelopment_by = Auth::user()->name;
                        $updateCFT->ResearchDevelopment_on = Carbon::now()->format('Y-m-d');
                        $history = new GlobalChangeControlAuditTrail();
                        $history->cc_id = $id;
                        $history->activity_type = 'Research Development Completed By, Research Development Completed On';
                        if(is_null($lastDocument->ResearchDevelopment_by) || $lastDocument->ResearchDevelopment_on == ''){
                            $history->previous = "";
                        }else{
                            $history->previous = $lastDocument->ResearchDevelopment_by. ' ,' .Helpers::getdateFormat ($lastDocument->ResearchDevelopment_on);
                        }
                        $history->action='CFT Review Complete';
                        $history->current = $updateCFT->ResearchDevelopment_by. ',' . Helpers::getdateFormat($updateCFT->ResearchDevelopment_on);
                        $history->comment = $request->comment;
                        $history->user_id = Auth::user()->name;
                        $history->user_name = Auth::user()->name;
                        $history->change_to =   "Not Applicable";
                        $history->change_from = $lastDocument->status;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->origin_state = $lastDocument->status;
                        $history->stage = 'CFT Review';
                        if(is_null($lastDocument->ResearchDevelopment_by) || $lastDocument->ResearchDevelopment_on == '')
                        {
                            $history->action_name = 'New';
                        } else {
                            $history->action_name = 'Update';
                        }
                        $history->save();
                    }

                    if($index == 5 && $cftUsers->$column == Auth::user()->id){
                        $updateCFT->RegulatoryAffair_by = Auth::user()->name;
                        $updateCFT->RegulatoryAffair_on = Carbon::now()->format('Y-m-d');
                        $history = new GlobalChangeControlAuditTrail();
                        $history->cc_id = $id;
                        $history->activity_type = 'Regulatory Affair Completed By, Regulatory Affair Completed On';
                        if(is_null($lastDocument->RegulatoryAffair_by) || $lastDocument->RegulatoryAffair_on == ''){
                            $history->previous = "";
                        }else{
                            $history->previous = $lastDocument->RegulatoryAffair_by. ' ,' . Helpers::getdateFormat($lastDocument->RegulatoryAffair_on);
                        }
                        $history->action='CFT Review Complete';
                        $history->current = $updateCFT->RegulatoryAffair_by. ',' . Helpers::getdateFormat($updateCFT->RegulatoryAffair_on);
                        $history->user_id = Auth::user()->name;
                        $history->user_name = Auth::user()->name;
                        $history->change_to =   "Not Applicable";
                        $history->change_from = $lastDocument->status;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->origin_state = $lastDocument->status;
                        $history->stage = 'CFT Review';
                        if(is_null($lastDocument->RegulatoryAffair_by) || $lastDocument->RegulatoryAffair_on == '')
                        {
                            $history->action_name = 'New';
                        } else {
                            $history->action_name = 'Update';
                        }
                        $history->save();
                    }

                    
                    if($index == 6 && $cftUsers->$column == Auth::user()->id){
                        $updateCFT->CQA_by = Auth::user()->name;
                        $updateCFT->CQA_on = Carbon::now()->format('Y-m-d');
                        $history = new GlobalChangeControlAuditTrail();
                        $history->cc_id = $id;
                        $history->activity_type = 'CQA Completed By, CQA Completed On';
                        if(is_null($lastDocument->CQA_by) || $lastDocument->CQA_on == ''){
                            $history->previous = "";
                        } else {
                            $history->previous = $lastDocument->CQA_by. ' ,' . Helpers::getdateFormat($lastDocument->CQA_on);
                        }
                        $history->action='CFT Review Complete';
                        $history->current = $updateCFT->CQA_by. ',' . Helpers::getdateFormat($updateCFT->CQA_on);
                        $history->user_id = Auth::user()->name;
                        $history->user_name = Auth::user()->name;
                        $history->change_to = "Not Applicable";
                        $history->change_from = $lastDocument->status;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->origin_state = $lastDocument->status;
                        $history->stage = 'CFT Review';
                        if(is_null($lastDocument->CQA_by) || $lastDocument->CQA_on == ''){
                            $history->action_name = 'New';
                        } else {
                            $history->action_name = 'Update';
                        }
                        $history->save();
                    }
                    
                    if($index == 7 && $cftUsers->$column == Auth::user()->id){
                        $updateCFT->Microbiology_by = Auth::user()->name;
                        $updateCFT->Microbiology_on = Carbon::now()->format('Y-m-d');
                        $history = new GlobalChangeControlAuditTrail();
                        $history->cc_id = $id;
                        $history->activity_type = 'Microbiology Completed By, Microbiology Completed On';
                        if(is_null($lastDocument->Microbiology_by) || $lastDocument->Microbiology_on == ''){
                            $history->previous = "";
                        } else {
                            $history->previous = $lastDocument->Microbiology_by. ' ,' . Helpers::getdateFormat($lastDocument->Microbiology_on);
                        }
                        $history->action='CFT Review Complete';
                        $history->current = $updateCFT->Microbiology_by. ',' . Helpers::getdateFormat($updateCFT->Microbiology_on);
                        $history->user_id = Auth::user()->name;
                        $history->user_name = Auth::user()->name;
                        $history->change_to = "Not Applicable";
                        $history->change_from = $lastDocument->status;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->origin_state = $lastDocument->status;
                        $history->stage = 'CFT Review';
                        if(is_null($lastDocument->Microbiology_by) || $lastDocument->Microbiology_on == ''){
                            $history->action_name = 'New';
                        } else {
                            $history->action_name = 'Update';
                        }
                        $history->save();
                    }

                    if($index == 8 && $cftUsers->$column == Auth::user()->id){
                        $updateCFT->QualityAssurance_by = Auth::user()->name;
                        $updateCFT->QualityAssurance_on = Carbon::now()->format('Y-m-d');
                        $history = new GlobalChangeControlAuditTrail();
                        $history->cc_id = $id;
                        $history->activity_type = 'Quality Assurance Completed By, Quality Assurance Completed On';
                        if(is_null($lastDocument->QualityAssurance_by) || $lastDocument->QualityAssurance_on == ''){
                            $history->previous = "";
                        } else {
                            $history->previous = $lastDocument->QualityAssurance_by. ' ,' . Helpers::getdateFormat($lastDocument->QualityAssurance_on);
                        }
                        $history->action='CFT Review Complete';
                        $history->current = $updateCFT->QualityAssurance_by. ',' . Helpers::getdateFormat($updateCFT->QualityAssurance_on);
                        $history->user_id = Auth::user()->name;
                        $history->user_name = Auth::user()->name;
                        $history->change_to = "Not Applicable";
                        $history->change_from = $lastDocument->status;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->origin_state = $lastDocument->status;
                        $history->stage = 'CFT Review';
                        if(is_null($lastDocument->QualityAssurance_by) || $lastDocument->QualityAssurance_on == ''){
                            $history->action_name = 'New';
                        } else {
                            $history->action_name = 'Update';
                        }
                        $history->save();
                    }

                    if($index == 9 && $cftUsers->$column == Auth::user()->id){
                        $updateCFT->SystemIT_by = Auth::user()->name;
                        $updateCFT->SystemIT_on = Carbon::now()->format('Y-m-d');
                        $history = new GlobalChangeControlAuditTrail();
                        $history->cc_id = $id;
                        $history->activity_type = 'System IT Completed By, System IT Completed On';
                        if(is_null($lastDocument->SystemIT_by) || $lastDocument->SystemIT_on == ''){
                            $history->previous = "";
                        } else {
                            $history->previous = $lastDocument->SystemIT_by. ' ,' . Helpers::getdateFormat($lastDocument->SystemIT_on);
                        }
                        $history->action='CFT Review Complete';
                        $history->current = $updateCFT->SystemIT_by. ',' . Helpers::getdateFormat($updateCFT->SystemIT_on);
                        $history->user_id = Auth::user()->name;
                        $history->user_name = Auth::user()->name;
                        $history->change_to = "Not Applicable";
                        $history->change_from = $lastDocument->status;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->origin_state = $lastDocument->status;
                        $history->stage = 'CFT Review';
                        if(is_null($lastDocument->SystemIT_by) || $lastDocument->SystemIT_on == ''){
                            $history->action_name = 'New';
                        } else {
                            $history->action_name = 'Update';
                        }
                        $history->save();
                    }

                    if($index == 10 && $cftUsers->$column == Auth::user()->id){
                        $updateCFT->Human_Resource_by = Auth::user()->name;
                        $updateCFT->Human_Resource_on = Carbon::now()->format('Y-m-d');
                        $history = new GlobalChangeControlAuditTrail();
                        $history->cc_id = $id;
                        $history->activity_type = 'Human Resource Completed By, Human Resource Completed On';
                        if(is_null($lastDocument->Human_Resource_by) || $lastDocument->Human_Resource_on == ''){
                            $history->previous = "";
                        } else {
                            $history->previous = $lastDocument->Human_Resource_by. ' ,' . Helpers::getdateFormat($lastDocument->Human_Resource_on);
                        }
                        $history->action='CFT Review Complete';
                        $history->current = $updateCFT->Human_Resource_by. ',' . Helpers::getdateFormat($updateCFT->Human_Resource_on);
                        $history->user_id = Auth::user()->name;
                        $history->user_name = Auth::user()->name;
                        $history->change_to = "Not Applicable";
                        $history->change_from = $lastDocument->status;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->origin_state = $lastDocument->status;
                        $history->stage = 'CFT Review';
                        if(is_null($lastDocument->Human_Resource_by) || $lastDocument->Human_Resource_on == ''){
                            $history->action_name = 'New';
                        } else {
                            $history->action_name = 'Update';
                        }
                        $history->save();
                    }

                    if($index == 11 && $cftUsers->$column == Auth::user()->id){
                        $updateCFT->Other1_by = Auth::user()->name;
                        $updateCFT->Other1_on = Carbon::now()->format('Y-m-d');
                        $history = new GlobalChangeControlAuditTrail();
                        $history->cc_id = $id;
                        $history->activity_type = 'Other 1 Completed By, Other 1 Completed On';
                        if(is_null($lastDocument->Other1_by) || $lastDocument->Other1_on == ''){
                            $history->previous = "";
                        } else {
                            $history->previous = $lastDocument->Other1_by. ' ,' . Helpers::getdateFormat($lastDocument->Other1_on);
                        }
                        $history->action='CFT Review Complete';
                        $history->current = $updateCFT->Other1_by. ',' . Helpers::getdateFormat($updateCFT->Other1_on);
                        $history->user_id = Auth::user()->name;
                        $history->user_name = Auth::user()->name;
                        $history->change_to = "Not Applicable";
                        $history->change_from = $lastDocument->status;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->origin_state = $lastDocument->status;
                        $history->stage = 'CFT Review';
                        if(is_null($lastDocument->Other1_by) || $lastDocument->Other1_on == ''){
                            $history->action_name = 'New';
                        } else {
                            $history->action_name = 'Update';
                        }
                        $history->save();
                    }

                    if($index == 12 && $cftUsers->$column == Auth::user()->id){
                        $updateCFT->Other2_by = Auth::user()->name;
                        $updateCFT->Other2_on = Carbon::now()->format('Y-m-d');
                        $history = new GlobalChangeControlAuditTrail();
                        $history->cc_id = $id;
                        $history->activity_type = 'Other 2 Completed By, Other 2 Completed On';
                        if(is_null($lastDocument->Other2_by) || $lastDocument->Other2_on == ''){
                            $history->previous = "";
                        } else {
                            $history->previous = $lastDocument->Other2_by. ' ,' . Helpers::getdateFormat($lastDocument->Other2_on);
                        }
                        $history->action='CFT Review Complete';
                        $history->current = $updateCFT->Other2_by. ',' . Helpers::getdateFormat($updateCFT->Other2_on);
                        $history->user_id = Auth::user()->name;
                        $history->user_name = Auth::user()->name;
                        $history->change_to = "Not Applicable";
                        $history->change_from = $lastDocument->status;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->origin_state = $lastDocument->status;
                        $history->stage = 'CFT Review';
                        if(is_null($lastDocument->Other2_by) || $lastDocument->Other2_on == ''){
                            $history->action_name = 'New';
                        } else {
                            $history->action_name = 'Update';
                        }
                        $history->save();
                    }

                    if($index == 13 && $cftUsers->$column == Auth::user()->id){
                        $updateCFT->Other3_by = Auth::user()->name;
                        $updateCFT->Other3_on = Carbon::now()->format('Y-m-d');
                        $history = new GlobalChangeControlAuditTrail();
                        $history->cc_id = $id;
                        $history->activity_type = 'Other 3 Completed By, Other 3 Completed On';
                        if(is_null($lastDocument->Other3_by) || $lastDocument->Other3_on == ''){
                            $history->previous = "";
                        } else {
                            $history->previous = $lastDocument->Other3_by. ' ,' . Helpers::getdateFormat($lastDocument->Other3_on);
                        }
                        $history->action='CFT Review Complete';
                        $history->current = $updateCFT->Other3_by. ',' . Helpers::getdateFormat($updateCFT->Other3_on);
                        $history->user_id = Auth::user()->name;
                        $history->user_name = Auth::user()->name;
                        $history->change_to = "Not Applicable";
                        $history->change_from = $lastDocument->status;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->origin_state = $lastDocument->status;
                        $history->stage = 'CFT Review';
                        if(is_null($lastDocument->Other3_by) || $lastDocument->Other3_on == ''){
                            $history->action_name = 'New';
                        } else {
                            $history->action_name = 'Update';
                        }
                        $history->save();
                    }

                    if($index == 14 && $cftUsers->$column == Auth::user()->id){
                        $updateCFT->Other4_by = Auth::user()->name;
                        $updateCFT->Other4_on = Carbon::now()->format('Y-m-d');
                        $history = new GlobalChangeControlAuditTrail();
                        $history->cc_id = $id;
                        $history->activity_type = 'Other 4 Completed By, Other 4 Completed On';
                        if(is_null($lastDocument->Other4_by) || $lastDocument->Other4_on == ''){
                            $history->previous = "";
                        } else {
                            $history->previous = $lastDocument->Other4_by. ' ,' . Helpers::getdateFormat($lastDocument->Other4_on);
                        }
                        $history->action='CFT Review Complete';
                        $history->current = $updateCFT->Other4_by. ',' . Helpers::getdateFormat($updateCFT->Other4_on);
                        $history->user_id = Auth::user()->name;
                        $history->user_name = Auth::user()->name;
                        $history->change_to = "Not Applicable";
                        $history->change_from = $lastDocument->status;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->origin_state = $lastDocument->status;
                        $history->stage = 'CFT Review';
                        if(is_null($lastDocument->Other4_by) || $lastDocument->Other4_on == ''){
                            $history->action_name = 'New';
                        } else {
                            $history->action_name = 'Update';
                        }
                        $history->save();
                    }

                    if($index == 15 && $cftUsers->$column == Auth::user()->id){
                        $updateCFT->Other5_by = Auth::user()->name;
                        $updateCFT->Other5_on = Carbon::now()->format('Y-m-d');
                        $history = new GlobalChangeControlAuditTrail();
                        $history->cc_id = $id;
                        $history->activity_type = 'Other 5 Completed By, Other 5 Completed On';
                        if(is_null($lastDocument->Other5_by) || $lastDocument->Other5_on == ''){
                            $history->previous = "";
                        } else {
                            $history->previous = $lastDocument->Other5_by. ' ,' . Helpers::getdateFormat($lastDocument->Other5_on);
                        }
                        $history->action='CFT Review Complete';
                        $history->current = $updateCFT->Other5_by. ',' . Helpers::getdateFormat($updateCFT->Other5_on);
                        $history->user_id = Auth::user()->name;
                        $history->user_name = Auth::user()->name;
                        $history->change_to = "Not Applicable";
                        $history->change_from = $lastDocument->status;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->origin_state = $lastDocument->status;
                        $history->stage = 'CFT Review';
                        if(is_null($lastDocument->Other5_by) || $lastDocument->Other5_on == ''){
                            $history->action_name = 'New';
                        } else {
                            $history->action_name = 'Update';
                        }
                        $history->save();
                    }
                    $updateCFT->update();

                    // Check if the value is not null and not equal to 0
                    if ($value != null && $value != 0) {
                        $valuesArray[] = $value;
                    }
                }
                if ($IsCFTRequired) {
                    if (count(array_unique($valuesArray)) == ($cftDetails + 1)) {
                        $stage = new GlobalChangeControlResponse();
                        $stage->cc_id = $id;
                        $stage->cft_user_id = Auth::user()->id;
                        $stage->status = "Completed";
                        $stage->comment = $request->comments;
                        $stage->save();
                    } else {
                        $stage = new GlobalChangeControlResponse();
                        $stage->cc_id = $id;
                        $stage->cft_user_id = Auth::user()->id;
                        $stage->status = "In-progress";
                        $stage->comment = $request->comments;
                        $stage->save();
                    }
                }
                
                $checkCFTCount = GlobalChangeControlResponse::withoutTrashed()->where(['status' => 'Completed', 'cc_id' => $id])->count();
                $Cft = GlobalChangeControlCft::withoutTrashed()->where('cc_id', $id)->first();
                
                if (!$IsCFTRequired || $checkCFTCount) {
                    $changeControl->stage = "5";
                    $changeControl->status = "External Review";                
                    $changeControl->cft_review_by = Auth::user()->name;
                    $changeControl->cft_review_on = Carbon::now()->format('d-M-Y');
                    $changeControl->cft_review_comment = $request->comments;

                    $history = new GlobalChangeControlAuditTrail();
                    $history->cc_id = $id;

                    $history->activity_type = 'CFT Review Complete By, CFT Review Complete On';
                    if (is_null($lastDocument->cft_review_by) || $lastDocument->cft_review_by === '') {
                        $history->previous = "NULL";
                    } else {
                        $history->previous = $lastDocument->cft_review_by . ' , ' . $lastDocument->cft_review_on;
                    }
                    $history->current = $changeControl->cft_review_by . ' , ' . $changeControl->cft_review_on;
                    if (is_null($lastDocument->cft_review_by) || $lastDocument->cft_review_on === '') {
                        $history->action_name = 'New';
                    } else {
                    $history->action_name = 'Update';
                    }

                    $history->action = 'CFT Review Complete';
                    $history->comment = $request->comment;
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $lastDocument->status;
                    $history->change_to = "External Review";
                    $history->change_from = $lastDocument->status;
                    $history->stage = 'Plan Proposed';
                    $history->save();
                       
                    $changeControl->update();
                }
                toastr()->success('Sent External Review');
                return back();
            }


            if ($changeControl->stage == 5) {
                // $getExternalReview = ExternalReview::where(['cc_id' => $id, "proccess_name" => "GlobalCC"])->get();
                // foreach ($getExternalReview as $row) {
                //     if (empty($row->external_review_comment)) {
                //         Session::flash('swal', [
                //             'type' => 'warning',
                //             'title' => 'Mandatory Fields!',
                //             'message' => 'External Review Tab is yet to be filled!'
                //         ]);
                //         return redirect()->back();
                //     }
                // }

                $changeControl->stage = "6";
                $changeControl->status = "QA/CQA Final Review";
                $changeControl->RA_review_required_by = Auth::user()->name;
                $changeControl->RA_review_required_on = Carbon::now()->format('d-M-Y');
                $changeControl->RA_review_required_comment = $request->comments;

                $history = new GlobalChangeControlAuditTrail();
                $history->cc_id = $id;

                $history->activity_type = 'RA Approval By, RA Approval On';
                if (is_null($lastDocument->RA_review_required_by) || $lastDocument->RA_review_required_by === '') {
                    $history->previous = "NULL";
                } else {
                    $history->previous = $lastDocument->RA_review_required_by . ' , ' . $lastDocument->RA_review_required_on;
                }
                $history->current = $changeControl->RA_review_required_by . ' , ' . $changeControl->RA_review_required_on;
                if (is_null($lastDocument->RA_review_required_by) || $lastDocument->RA_review_required_on === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }

                $history->action = 'RA Approval Required';
                $history->comment = $request->comments;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to = "QA/CQA Final Review";
                $history->change_from = $lastDocument->status;
                $history->stage = 'Plan Proposed';
                $history->save();
                

                $list = Helpers::getRAUsersList($changeControl->division_id);
                $userIds = collect($list)->pluck('user_id')->toArray();
                $users = User::whereIn('id', $userIds)->select('id', 'name', 'email')->get();
                $userIds = $users->pluck('id');
                
                foreach ($users as $userValue) {
                    DB::table('notifications')->insert([
                        'activity_id' => $changeControl->id,
                        'activity_type' => "Notification",
                        'from_id' => Auth::user()->id,
                        'user_name' => $userValue->name,
                        'to_id' => $userValue->id,
                        'process_name' => "Change Control",
                        'division_id' => $changeControl->division_id,
                        'short_description' => $changeControl->short_description,
                        'initiator_id' => $changeControl->initiator_id,
                        'due_date' => $changeControl->due_date,
                        'record' => $changeControl->record,
                        'site' => "GlobalCC",
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
                                ['data' => $changeControl, 'site' => "GlobalCC", 'history' => "RA Approval Required", 'process' => 'Change Control', 'comment' => $request->comments, 'user' => Auth::user()->name],
                                function ($message) use ($email, $changeControl) {
                                    $message->to($email)
                                    ->subject("Medicef Notification: Change Control, Record #" . str_pad($changeControl->record, 4, '0', STR_PAD_LEFT) . " - Activity: RA Approval Required Performed");
                                }
                            );
                        } catch(\Exception $e) {
                            info('Error sending mail', [$e]);
                        }
                    }
                }

                // if ($userIds->isNotEmpty()) {
                //     try {
                //         foreach ($userIds as $userId) {
                //             DB::table('notification_users')->insert([
                //                 'record_id' => $changeControl->id,
                //                 'record_type' => "GlobalCC",
                //                 'from_id' => Auth::user()->id,
                //                 'to_id' => $userId,
                //                 'roles_id' => 4,
                //             ]);
                //         }
                //     } catch (\Throwable $e) {
                //         \Log::error('Notification creation failed: ' . $e->getMessage());
                //     }
                // }

                $changeControl->update();
                toastr()->success('Sent to QA/CQA Final Review');
                return back();
            }
            if ($changeControl->stage == 6) {
                $changeControl->stage = "7";
                $changeControl->status = "Pending RA Approval";

                
                $changeControl->RA_review_required_by = Auth::user()->name;
                $changeControl->RA_review_required_on = Carbon::now()->format('d-M-Y');
                $changeControl->RA_review_required_comment = $request->comments;

                $history = new GlobalChangeControlAuditTrail();
                $history->cc_id = $id;

                $history->activity_type = 'RA Approval Required By, RA Approval Required On';
                if (is_null($lastDocument->RA_review_required_by) || $lastDocument->RA_review_required_by === '') {
                    $history->previous = "NULL";
                } else {
                    $history->previous = $lastDocument->RA_review_required_by . ' , ' . $lastDocument->RA_review_required_on;
                }
                $history->current = $changeControl->RA_review_required_by . ' , ' . $changeControl->RA_review_required_on;
                if (is_null($lastDocument->RA_review_required_by) || $lastDocument->RA_review_required_on === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }

                $history->action = 'RA Approval Required';
                $history->comment = $request->comments;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to = "Pending RA Approval";
                $history->change_from = $lastDocument->status;
                $history->stage = 'Plan Proposed';
                $history->save();
                
                
                $list = Helpers::getQAUserList($changeControl->division_id);
                $userIds = collect($list)->pluck('user_id')->toArray();
                $users = User::whereIn('id', $userIds)->select('id', 'name', 'email')->get();
                $userIds = $users->pluck('id');
                
                foreach ($users as $userValue) {
                    DB::table('notifications')->insert([
                        'activity_id' => $changeControl->id,
                        'activity_type' => "Notification",
                        'from_id' => Auth::user()->id,
                        'user_name' => $userValue->name,
                        'to_id' => $userValue->id,
                        'process_name' => "Change Control",
                        'division_id' => $changeControl->division_id,
                        'short_description' => $changeControl->short_description,
                        'initiator_id' => $changeControl->initiator_id,
                        'due_date' => $changeControl->due_date,
                        'record' => $changeControl->record,
                        'site' => "GlobalCC",
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
                                ['data' => $changeControl, 'site' => "GlobalCC", 'history' => "RA Approval Complete", 'process' => 'Change Control', 'comment' => $request->comments, 'user' => Auth::user()->name],
                                function ($message) use ($email, $changeControl) {
                                    $message->to($email)
                                    ->subject("Medicef Notification: Change Control, Record #" . str_pad($changeControl->record, 4, '0', STR_PAD_LEFT) . " - Activity: RA Approval Complete Performed");
                                }
                            );
                        } catch(\Exception $e) {
                            info('Error sending mail', [$e]);
                        }
                    }
                }

                // if ($userIds->isNotEmpty()) {
                //     try {
                //         foreach ($userIds as $userId) {
                //             DB::table('notification_users')->insert([
                //                 'record_id' => $changeControl->id,
                //                 'record_type' => "GlobalCC",
                //                 'from_id' => Auth::user()->id,
                //                 'to_id' => $userId,
                //                 'roles_id' => 4,
                //             ]);
                //         }
                //     } catch (\Throwable $e) {
                //         \Log::error('Notification creation failed: ' . $e->getMessage());
                //     }
                // }


                $changeControl->update();
                toastr()->success('Sent Pending RA Approval');
                return back();
            }
            if ($changeControl->stage == 7) {
                $changeControl->stage = "8";
                $changeControl->status = "QA/CQA Head/Manager Designee Approval";
                $changeControl->RA_review_completed_by = Auth::user()->name;
                $changeControl->RA_review_completed_on = Carbon::now()->format('d-M-Y');    
                $changeControl->RA_review_completed_comment = $request->comments;

                $history = new GlobalChangeControlAuditTrail();
                $history->cc_id = $id;

                $history->activity_type = 'RA Review Completed By, RA Review Completed On';
                if (is_null($lastDocument->RA_review_completed_by) || $lastDocument->RA_review_completed_by === '') {
                    $history->previous = "NULL";
                } else {
                    $history->previous = $lastDocument->RA_review_completed_by . ' , ' . $lastDocument->RA_review_completed_on;
                }
                $history->current = $changeControl->RA_review_completed_by . ' , ' . $changeControl->RA_review_completed_on;
                if (is_null($lastDocument->RA_review_completed_by) || $lastDocument->RA_review_completed_on === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }

                $history->action = 'RA Review Completed';
                $history->comment = $request->comments;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to = "QA/CQA Head/Manager Designee Approval";
                $history->change_from = $lastDocument->status;
                $history->stage = 'Plan Proposed';
                $history->save();
                
                
                $list = Helpers::getInitiatorUserList($changeControl->division_id);
                $userIds = collect($list)->pluck('user_id')->toArray();
                $users = User::whereIn('id', $userIds)->select('id', 'name', 'email')->get();
                $userIds = $users->pluck('id');
                
                foreach ($users as $userValue) {
                    DB::table('notifications')->insert([
                        'activity_id' => $changeControl->id,
                        'activity_type' => "Notification",
                        'from_id' => Auth::user()->id,
                        'user_name' => $userValue->name,
                        'to_id' => $userValue->id,
                        'process_name' => "Change Control",
                        'division_id' => $changeControl->division_id,
                        'short_description' => $changeControl->short_description,
                        'initiator_id' => $changeControl->initiator_id,
                        'due_date' => $changeControl->due_date,
                        'record' => $changeControl->record,
                        'site' => "GlobalCC",
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
                                ['data' => $changeControl, 'site' => "GlobalCC", 'history' => "RA Review Completed", 'process' => 'Change Control', 'comment' => $request->comments, 'user' => Auth::user()->name],
                                function ($message) use ($email, $changeControl) {
                                    $message->to($email)
                                    ->subject("Medicef Notification: Change Control, Record #" . str_pad($changeControl->record, 4, '0', STR_PAD_LEFT) . " - Activity: RA Review Performed");
                                }
                            );
                        } catch(\Exception $e) {
                            info('Error sending mail', [$e]);
                        }
                    }
                }

                // if ($userIds->isNotEmpty()) {
                //     try {
                //         foreach ($userIds as $userId) {
                //             DB::table('notification_users')->insert([
                //                 'record_id' => $changeControl->id,
                //                 'record_type' => "GlobalCC",
                //                 'from_id' => Auth::user()->id,
                //                 'to_id' => $userId,
                //                 'roles_id' => 4,
                //             ]);
                //         }
                //     } catch (\Throwable $e) {
                //         \Log::error('Notification creation failed: ' . $e->getMessage());
                //     }
                // }


                $changeControl->update();
                toastr()->success('Sent to QA/CQA Head/Manager Designee Approval');
                return back();
            }
        } else {
            toastr()->error('E-signature Not match');
            return back();
        }
    }


    public function reject(Request $request, $id)
    {
        if ($request->username == Auth::user()->Username && Hash::check($request->password, Auth::user()->password)) {
            $changeControl = GlobalChangeControl::find($id);
            $lastDocument = GlobalChangeControl::find($id);
            $evaluation = Evaluation::where('cc_id', $id)->first();
            $updateCFT = GlobalChangeControlCft::where('cc_id', $id)->latest()->first();
            $cftDetails = GlobalChangeControlResponse::withoutTrashed()
                ->where(['status' => 'In-progress', 'cc_id' => $id])
                ->distinct('cft_user_id')
                ->count();

            if ($changeControl->stage == 8) {
                $changeControl->stage = 9;
                $changeControl->status = "Closed - Rejected";
                $changeControl->RA_review_completed_by = Auth::user()->name;
                $changeControl->RA_review_completed_on = Carbon::now()->format('d-M-Y');
                $changeControl->RA_review_completed_comment = $request->comments;

                $history = new GlobalChangeControlAuditTrail();
                $history->cc_id = $id;
                $history->activity_type = 'Rejected By, Rejected On';

                $history->previous = is_null($lastDocument->RA_review_completed_by) || $lastDocument->RA_review_completed_by === ''
                    ? "NULL"
                    : $lastDocument->RA_review_completed_by . ' , ' . $lastDocument->RA_review_completed_on;

                $history->current = $changeControl->RA_review_completed_by . ' , ' . $changeControl->RA_review_completed_on;

                $history->action_name = is_null($lastDocument->RA_review_completed_by) || $lastDocument->RA_review_completed_on === ''
                    ? 'New'
                    : 'Update';

                $history->action = 'Rejected';
                $history->comment = $request->comments;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to = "Closed - Rejected";
                $history->change_from = $lastDocument->status;
                $history->stage = 'Plan Proposed';
                $history->save();

                // Send email notifications (commented out)
                // $list = Helpers::getHodUserList();
                // foreach ($list as $u) {
                //     if ($u->q_m_s_divisions_id == $changeControl->division_id) {
                //         $email = Helpers::getInitiatorEmail($u->user_id);
                //         if ($email !== null) {
                //             Mail::send(
                //                 'mail.view-mail',
                //                 ['data' => $changeControl],
                //                 function ($message) use ($email) {
                //                     $message->to($email)
                //                         ->subject("Document is Sent By " . Auth::user()->name);
                //                 }
                //             );
                //         }
                //     }
                // }

                $changeControl->update();
                toastr()->success('Sent to Closed - Rejected');
                return back();
            }
        } else {
            toastr()->error('E-signature Not match');
            return back();
        }
    }


    public function sentToQAHeadApproval(Request $request, $id)
    {
        if ($request->username == Auth::user()->Username && Hash::check($request->password, Auth::user()->password)) {
            $changeControl = GlobalChangeControl::find($id);
         
            $lastDocument = GlobalChangeControl::find($id);
            $evaluation = Evaluation::where('cc_id', $id)->first();
            $updateCFT = GlobalChangeControlCft::where('cc_id', $id)->latest()->first();
            if ($changeControl->stage == 6) {
                    $changeControl->stage = "8";
                    $changeControl->status = "QA/CQA Head/Manager Designee Approval";
                    $changeControl->QA_final_review_by = Auth::user()->name;
                    $changeControl->QA_final_review_on = Carbon::now()->format('d-M-Y');
                    $changeControl->QA_final_review_comment = $request->comments;

                    $history = new GlobalChangeControlAuditTrail();
                    $history->cc_id = $id;

                    $history->activity_type = 'QA/CQA Final Review Complete By, QA/CQA Final Review Complete On';
                    if (is_null($lastDocument->QA_final_review_by) || $lastDocument->QA_final_review_by === '') {
                        $history->previous = "NULL";
                    } else {
                        $history->previous = $lastDocument->QA_final_review_by . ' , ' . $lastDocument->QA_final_review_on;
                    }
                    $history->current = $changeControl->QA_final_review_by . ' , ' . $changeControl->QA_final_review_on;
                    if (is_null($lastDocument->QA_final_review_by) || $lastDocument->QA_final_review_on === '') {
                        $history->action_name = 'New';
                    } else {
                        $history->action_name = 'Update';
                    }

                    $history->action = 'QA/CQA Final Review Complete';
                    $history->comment = $request->comments;
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $lastDocument->status;
                    $history->change_to = "QA/CQA Head/Manager Designee Approval";
                    $history->change_from = $lastDocument->status;
                    $history->stage = 'Plan Proposed';
                    $history->save();

                    $list = Helpers::getQAHeadUserList($changeControl->division_id);
                    $userIds = collect($list)->pluck('user_id')->toArray();
                    $users = User::whereIn('id', $userIds)->select('id', 'name', 'email')->get();
                    $userIds = $users->pluck('id');
                    
                    foreach ($users as $userValue) {
                        DB::table('notifications')->insert([
                            'activity_id' => $changeControl->id,
                            'activity_type' => "Notification",
                            'from_id' => Auth::user()->id,
                            'user_name' => $userValue->name,
                            'to_id' => $userValue->id,
                            'process_name' => "Change Control",
                            'division_id' => $changeControl->division_id,
                            'short_description' => $changeControl->short_description,
                            'initiator_id' => $changeControl->initiator_id,
                            'due_date' => $changeControl->due_date,
                            'record' => $changeControl->record,
                            'site' => "GlobalCC",
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
                                    ['data' => $changeControl, 'site' => "GlobalCC", 'history' => "QA/CQA Final Review Complete", 'process' => 'Change Control', 'comment' => $request->comments, 'user' => Auth::user()->name],
                                    function ($message) use ($email, $changeControl) {
                                        $message->to($email)
                                        ->subject("Medicef Notification: Change Control, Record #" . str_pad($changeControl->record, 4, '0', STR_PAD_LEFT) . " - Activity: QA/CQA Final Review Performed");
                                    }
                                );
                            } catch(\Exception $e) {
                                info('Error sending mail', [$e]);
                            }
                        }
                    }

                    $changeControl->update();
                    toastr()->success('Sent to QA Head/Manager Designee Approval');
                    return back();

            }
            if ($changeControl->stage == 7) {
                    $changeControl->stage = "9";
                    $changeControl->status = "Pending Initiator Update";
                    $changeControl->approved_by = Auth::user()->name;
                    $changeControl->approved_on = Carbon::now()->format('d-M-Y');
                    $changeControl->approved_comment = $request->comments;


                    $history = new GlobalChangeControlAuditTrail();
                    $history->cc_id = $id;
                    
                    $history->activity_type = 'QA/CQA Head/Manager Designee Approval By, QA/CQA Head/Manager Designee ApprovalOn';
                    if (is_null($lastDocument->approved_by) || $lastDocument->approved_by === '') {
                        $history->previous = "NULL";
                    } else {
                        $history->previous = $lastDocument->approved_by . ' , ' . $lastDocument->approved_on;
                    }
                    $history->current = $changeControl->approved_by . ' , ' . $changeControl->approved_on;
                    if (is_null($lastDocument->approved_by) || $lastDocument->approved_on === '') {
                        $history->action_name = 'New';
                    } else {
                        $history->action_name = 'Update';
                    }

                    $history->action = 'Approved';
                    $history->comment = $request->comments;
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $lastDocument->status;
                    $history->change_to = "Pending Initiator Update";
                    $history->change_from = $lastDocument->status;
                    $history->stage = 'Plan Proposed';
                    $history->save();
                    
                    $list = Helpers::getInitiatorUserList($changeControl->division_id);
                    $userIds = collect($list)->pluck('user_id')->toArray();
                    $users = User::whereIn('id', $userIds)->select('id', 'name', 'email')->get();
                    $userIds = $users->pluck('id');
                    
                    foreach ($users as $userValue) {
                        DB::table('notifications')->insert([
                            'activity_id' => $changeControl->id,
                            'activity_type' => "Notification",
                            'from_id' => Auth::user()->id,
                            'user_name' => $userValue->name,
                            'to_id' => $userValue->id,
                            'process_name' => "Change Control",
                            'division_id' => $changeControl->division_id,
                            'short_description' => $changeControl->short_description,
                            'initiator_id' => $changeControl->initiator_id,
                            'due_date' => $changeControl->due_date,
                            'record' => $changeControl->record,
                            'site' => "GlobalCC",
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
                                    ['data' => $changeControl, 'site' => "GlobalCC", 'history' => "Approved", 'process' => 'Change Control', 'comment' => $request->comments, 'user' => Auth::user()->name],
                                    function ($message) use ($email, $changeControl) {
                                        $message->to($email)
                                        ->subject("Medicef Notification: Change Control, Record #" . str_pad($changeControl->record, 4, '0', STR_PAD_LEFT) . " - Activity: Approved Performed");
                                    }
                                );
                            } catch(\Exception $e) {
                                info('Error sending mail', [$e]);
                            }
                        }
                    }
                    $changeControl->update();
                    toastr()->success('Sent to Pending Initiator Update');
                    return back();
            }

            if ($changeControl->stage == 9) {
                $changeControl->stage = "10";
                $changeControl->status = "HOD Final Review";
                $changeControl->initiator_update_complete_by = Auth::user()->name;
                $changeControl->initiator_update_complete_on = Carbon::now()->format('d-M-Y');
                $changeControl->initiator_update_complete_comment = $request->comments;

                $history = new GlobalChangeControlAuditTrail();
                $history->cc_id = $id;
    
                $lastDocument = ChangeControlComment::find($id);
                $history->activity_type = 'Initiator Updated Complete By, Initiator Updated Complete On';
                if (is_null($lastDocument->initiator_update_complete_by) || $lastDocument->initiator_update_complete_by === '') {
                    $history->previous = "NULL";
                } else {
                    $history->previous = $lastDocument->initiator_update_complete_by . ' , ' . $lastDocument->initiator_update_complete_on;
                }
                $history->current = $changeControl->initiator_update_complete_by . ' , ' . $changeControl->initiator_update_complete_on;
                if (is_null($lastDocument->initiator_update_complete_by) || $lastDocument->initiator_update_complete_on === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
    
                $history->action = 'Initiator Updated Complete';
                $history->comment = $request->comments;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to = "HOD Final Review";
                $history->change_from = $lastDocument->status;
                $history->stage = 'Plan Proposed';
                $history->save();


                $list = Helpers::getInitiatorUserList($changeControl->division_id);
                $userIds = collect($list)->pluck('user_id')->toArray();
                $users = User::whereIn('id', $userIds)->select('id', 'name', 'email')->get();
                $userIds = $users->pluck('id');
                    
                foreach ($users as $userValue) {
                    DB::table('notifications')->insert([
                        'activity_id' => $changeControl->id,
                        'activity_type' => "Notification",
                        'from_id' => Auth::user()->id,
                        'user_name' => $userValue->name,
                        'to_id' => $userValue->id,
                        'process_name' => "Change Control",
                        'division_id' => $changeControl->division_id,
                        'short_description' => $changeControl->short_description,
                        'initiator_id' => $changeControl->initiator_id,
                        'due_date' => $changeControl->due_date,
                        'record' => $changeControl->record,
                        'site' => "GlobalCC",
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
                                ['data' => $changeControl, 'site' => "GlobalCC", 'history' => "Approved", 'process' => 'Change Control', 'comment' => $request->comments, 'user' => Auth::user()->name],
                                function ($message) use ($email, $changeControl) {
                                    $message->to($email)
                                    ->subject("Medicef Notification: Change Control, Record #" . str_pad($changeControl->record, 4, '0', STR_PAD_LEFT) . " - Activity: Approved Performed");
                                }
                            );
                        } catch(\Exception $e) {
                            info('Error sending mail', [$e]);
                        }
                    }
                }
                $changeControl->update();    
                toastr()->success('Sent to HOD Final Review');
                return back();
            }
        
            if ($changeControl->stage == 9) {
                $changeControl->stage = "10";
                $changeControl->status = "HOD Final Review";

                $changeControl->initiator_update_complete_by = Auth::user()->name;
                $changeControl->initiator_update_complete_on = Carbon::now()->format('d-M-Y');
                $changeControl->initiator_update_complete_comment = $request->comments;

                $history = new GlobalChangeControlAuditTrail();
                $history->cc_id = $id;
                
                $lastDocument = ChangeControlComment::find($id);
                $history->activity_type = 'Initiator Updated Complete By, Initiator Updated Complete On';
                if (is_null($lastDocument->initiator_update_complete_by) || $lastDocument->initiator_update_complete_by === '') {
                    $history->previous = "NULL";
                } else {
                    $history->previous = $lastDocument->initiator_update_complete_by . ' , ' . $lastDocument->initiator_update_complete_on;
                }
                $history->current = $changeControl->initiator_update_complete_by . ' , ' . $changeControl->initiator_update_complete_on;
                if (is_null($lastDocument->initiator_update_complete_by) || $lastDocument->initiator_update_complete_on === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }

                $history->action = 'Initiator Updated Complete';
                $history->comment = $request->comments;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to = "HOD Final Review";
                $history->change_from = $lastDocument->status;
                $history->stage = 'Plan Proposed';
                $history->save();

                $list = Helpers::getHodUserList($changeControl->division_id);
                $userIds = collect($list)->pluck('user_id')->toArray();
                $users = User::whereIn('id', $userIds)->select('id', 'name', 'email')->get();
                $userIds = $users->pluck('id');
                    
                foreach ($users as $userValue) {
                    DB::table('notifications')->insert([
                        'activity_id' => $changeControl->id,
                        'activity_type' => "Notification",
                        'from_id' => Auth::user()->id,
                        'user_name' => $userValue->name,
                        'to_id' => $userValue->id,
                        'process_name' => "Change Control",
                        'division_id' => $changeControl->division_id,
                        'short_description' => $changeControl->short_description,
                        'initiator_id' => $changeControl->initiator_id,
                        'due_date' => $changeControl->due_date,
                        'record' => $changeControl->record,
                        'site' => "GlobalCC",
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
                                ['data' => $changeControl, 'site' => "GlobalCC", 'history' => "Initiator Updated Complete", 'process' => 'Change Control', 'comment' => $request->comments, 'user' => Auth::user()->name],
                                function ($message) use ($email, $changeControl) {
                                    $message->to($email)
                                    ->subject("Medicef Notification: Change Control, Record #" . str_pad($changeControl->record, 4, '0', STR_PAD_LEFT) . " - Activity: Initiator Updated Performed");
                                }
                            );
                        } catch(\Exception $e) {
                            info('Error sending mail', [$e]);
                        }
                    }
                }
                $changeControl->update();
                toastr()->success('Sent to HOD Final Review');
                return back();
            }


            if ($changeControl->stage == 10) {
                $changeControl->stage = "11";
                $changeControl->status = "Implementation Verification by QA";

                $comments->cc_id = $id;
                
                $comments->HOD_finalReview_complete_by = Auth::user()->name;
                $comments->HOD_finalReview_complete_on = Carbon::now()->format('d-M-Y');
                $comments->HOD_finalReview_complete_comment = $request->comments;
                $comments->save();
                $history = new GlobalChangeControlAuditTrail();
                $history->cc_id = $id;
                $lastDocument = ChangeControlComment::find($id);
                $history->activity_type = 'HOD Final Review Complete By, HOD Final Review Complete On';
                if (is_null($lastDocument->HOD_finalReview_complete_by) || $lastDocument->HOD_finalReview_complete_by === '') {
                    $history->previous = "NULL";
                } else {
                    $history->previous = $lastDocument->HOD_finalReview_complete_by . ' , ' . $lastDocument->HOD_finalReview_complete_on;
                }
                $history->current = $comments->HOD_finalReview_complete_by . ' , ' . $comments->HOD_finalReview_complete_on;
                if (is_null($lastDocument->HOD_finalReview_complete_by) || $lastDocument->HOD_finalReview_complete_on === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }

                $history->action = 'HOD Final Review Complete';
                $history->comment = $request->comments;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to = "Implementation Verification by QA";
                $history->change_from = $lastDocument->status;
                $history->stage = 'Plan Proposed';
                $history->save();
                
                $list = Helpers::getQAUserList($changeControl->division_id);
                $userIds = collect($list)->pluck('user_id')->toArray();
                $users = User::whereIn('id', $userIds)->select('id', 'name', 'email')->get();
                $userIds = $users->pluck('id');
                    
                foreach ($users as $userValue) {
                    DB::table('notifications')->insert([
                        'activity_id' => $changeControl->id,
                        'activity_type' => "Notification",
                        'from_id' => Auth::user()->id,
                        'user_name' => $userValue->name,
                        'to_id' => $userValue->id,
                        'process_name' => "Change Control",
                        'division_id' => $changeControl->division_id,
                        'short_description' => $changeControl->short_description,
                        'initiator_id' => $changeControl->initiator_id,
                        'due_date' => $changeControl->due_date,
                        'record' => $changeControl->record,
                        'site' => "GlobalCC",
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
                                ['data' => $changeControl, 'site' => "GlobalCC", 'history' => "HOD Final Review Complete", 'process' => 'Change Control', 'comment' => $request->comments, 'user' => Auth::user()->name],
                                function ($message) use ($email, $changeControl) {
                                    $message->to($email)
                                    ->subject("Medicef Notification: Change Control, Record #" . str_pad($changeControl->record, 4, '0', STR_PAD_LEFT) . " - Activity: HOD Final Review Complete Performed");
                                }
                            );
                        } catch(\Exception $e) {
                            info('Error sending mail', [$e]);
                        }
                    }
                }

                // if ($userIds->isNotEmpty()) {
                //     try {
                //         foreach ($userIds as $userId) {
                //             DB::table('notification_users')->insert([
                //                 'record_id' => $changeControl->id,
                //                 'record_type' => "GlobalCC",
                //                 'from_id' => Auth::user()->id,
                //                 'to_id' => $userId,
                //                 'roles_id' => 4,
                //             ]);
                //         }
                //     } catch (\Throwable $e) {
                //         \Log::error('Notification creation failed: ' . $e->getMessage());
                //     }
                // }

                $changeControl->update();
                toastr()->success('Sent to Implementation Verification by QA');
                return back();
            }


            if ($changeControl->stage == 11) {
                $changeControl->stage = "12";
                $changeControl->status = "QA/CQA Closure Approval";

                $comments->cc_id = $id;
                $comments->HOD_finalReview_complete_by = Auth::user()->name;
                $comments->HOD_finalReview_complete_on = Carbon::now()->format('d-M-Y');
                $comments->HOD_finalReview_complete_comment = $request->comments;
                $comments->save();

                $history = new GlobalChangeControlAuditTrail();
                $history->cc_id = $id;
                
                $history->activity_type = 'Implementation verification by QA/CQA Complete By, Implementation verification by QA/CQA Complete On';
                if (is_null($lastDocument->HOD_finalReview_complete_by) || $lastDocument->HOD_finalReview_complete_by === '') {
                    $history->previous = "NULL";
                } else {
                    $history->previous = $lastDocument->HOD_finalReview_complete_by . ' , ' . $lastDocument->HOD_finalReview_complete_on;
                }
                $history->current = $changeControl->HOD_finalReview_complete_by . ' , ' . $changeControl->HOD_finalReview_complete_on;
                if (is_null($lastDocument->HOD_finalReview_complete_by) || $lastDocument->HOD_finalReview_complete_on === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }

                $history->action = 'Send For Final QA/CQA Head Approval';
                $history->comment = $request->comments;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to = "QA/CQA Closure Approval";
                $history->change_from = $lastDocument->status;
                $history->stage = 'Plan Proposed';
                $history->save();
                
                
                $list = Helpers::getQAHeadUserList($changeControl->division_id);
                $userIds = collect($list)->pluck('user_id')->toArray();
                $users = User::whereIn('id', $userIds)->select('id', 'name', 'email')->get();
                $userIds = $users->pluck('id');
                    
                foreach ($users as $userValue) {
                    DB::table('notifications')->insert([
                        'activity_id' => $changeControl->id,
                        'activity_type' => "Notification",
                        'from_id' => Auth::user()->id,
                        'user_name' => $userValue->name,
                        'to_id' => $userValue->id,
                        'process_name' => "Change Control",
                        'division_id' => $changeControl->division_id,
                        'short_description' => $changeControl->short_description,
                        'initiator_id' => $changeControl->initiator_id,
                        'due_date' => $changeControl->due_date,
                        'record' => $changeControl->record,
                        'site' => "GlobalCC",
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
                                ['data' => $changeControl, 'site' => "GlobalCC", 'history' => "Send For Final QA/CQA Head Approval", 'process' => 'Change Control', 'comment' => $request->comments, 'user' => Auth::user()->name],
                                function ($message) use ($email, $changeControl) {
                                    $message->to($email)
                                    ->subject("Medicef Notification: Change Control, Record #" . str_pad($changeControl->record, 4, '0', STR_PAD_LEFT) . " - Activity: Send For Final QA/CQA Head Approval Performed");
                                }
                            );
                        } catch(\Exception $e) {
                            info('Error sending mail', [$e]);
                        }
                    }
                }

                // if ($userIds->isNotEmpty()) {
                //     try {
                //         foreach ($userIds as $userId) {
                //             DB::table('notification_users')->insert([
                //                 'record_id' => $changeControl->id,
                //                 'record_type' => "GlobalCC",
                //                 'from_id' => Auth::user()->id,
                //                 'to_id' => $userId,
                //                 'roles_id' => 4,
                //             ]);
                //         }
                //     } catch (\Throwable $e) {
                //         \Log::error('Notification creation failed: ' . $e->getMessage());
                //     }
                // }

                $changeControl->update();
                toastr()->success('Sent to Implementation Verification by QA/CQA');
                return back();
            }


        } else {
            toastr()->error('E-signature Not match');
            return back();
        }   
    }

    public function sentoPostImplementation(Request $request, $id)
    {
        if ($request->username == Auth::user()->Username && Hash::check($request->password, Auth::user()->password)) {
            $changeControl = GlobalChangeControl::find($id);
            $lastDocument = GlobalChangeControl::find($id);
            $comments = ChangeControlComment::where('cc_id', $id)->firstOrCreate();
            $evaluation = Evaluation::where('cc_id', $id)->first();
            $updateCFT = GlobalChangeControlCft::where('cc_id', $id)->latest()->first();
            if ($changeControl->stage == 8) {
                $changeControl->stage = "10";
                $changeControl->status = "Pending Initiator Update";
                $changeControl->approved_by = Auth::user()->name;
                $changeControl->approved_on = Carbon::now()->format('d-M-Y');
                $changeControl->approved_comment = $request->comments;

                $history = new GlobalChangeControlAuditTrail();
                $history->cc_id = $id;
                
                $history->activity_type = 'QA/CQA Head/Manager Designee Approval By, QA/CQA Head/Manager Designee Approval On';
                if (is_null($lastDocument->approved_by) || $lastDocument->approved_by === '') {
                    $history->previous = "NULL";
                } else {
                    $history->previous = $lastDocument->approved_by . ' , ' . $lastDocument->approved_on;
                }
                $history->current = $changeControl->approved_by . ' , ' . $changeControl->approved_on;
                if (is_null($lastDocument->approved_by) || $lastDocument->approved_on === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }

                $history->action = 'Approved';
                $history->comment = $request->comments;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to = "Pending Initiator Update";
                $history->change_from = $lastDocument->status;
                $history->stage = 'Plan Proposed';
                $history->save();

                //  $list = Helpers::getHodUserList();
                //     foreach ($list as $u) {
                //         if($u->q_m_s_divisions_id == $changeControl->division_id){
                //             $email = Helpers::getInitiatorEmail($u->user_id);
                //              if ($email !== null) {
                //               Mail::send(
                //                   'mail.view-mail',
                //                    ['data' => $changeControl],
                //                 function ($message) use ($email) {
                //                     $message->to($email)
                //                         ->subject("Document is Send By".Auth::user()->name);
                //                 }
                //               );
                //             }
                //      }
                //   }
                $changeControl->update();
                toastr()->success('Sent to Pending Initiator Update');
                return back();
            }

            if ($changeControl->stage == 10) {
                if (is_null($lastDocument->intial_update_comments))
                {
                    Session::flash('swal', [
                        'type' => 'warning',
                        'title' => 'Mandatory Fields!',
                        'message' => 'Initiator Update Tab is yet to be filled'
                    ]);

                    return redirect()->back();
                }
                 else {
                    Session::flash('swal', [
                        'type' => 'success',
                        'title' => 'Success',
                        'message' => 'Document Sent'
                    ]);
                }
                $changeControl->stage = "11";
                $changeControl->status = "HOD Final Review";
              
                
                $comments->cc_id =$id;
                $comments->initiator_update_complete_by = Auth::user()->name;
                $comments->initiator_update_complete_on = Carbon::now()->format('d-M-Y');
                $comments->initiator_update_complete_comment = $request->comments;
             
                $comments->save(); 
    
                
                $history = new GlobalChangeControlAuditTrail();
                $history->cc_id = $id;
    
                $history->activity_type = 'Initiator Updated Complete By, Initiator Updated Complete On';
                if (is_null($lastDocument->initiator_update_complete_by) || $lastDocument->initiator_update_complete_by === '') {
                    $history->previous = "NULL";
                } else {
                    $history->previous = $lastDocument->initiator_update_complete_by . ' , ' . $lastDocument->initiator_update_complete_on;
                }
                $history->current = $comments->initiator_update_complete_by . ' , ' . $comments->initiator_update_complete_on;
                if (is_null($lastDocument->initiator_update_complete_by) || $lastDocument->initiator_update_complete_on === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
    
                $history->action = 'Initiator Updated Complete';
                $history->comment = $request->comments;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to = "HOD Final Review";
                $history->change_from = $lastDocument->status;
                $history->stage = 'Plan Proposed';
                $history->save();
    
                $changeControl->update();
                toastr()->success('Sent to HOD Final Review');
                return back();
            }
            
            if ($changeControl->stage == 11) {
                if (is_null($lastDocument->hod_final_review_comment))
                {
                    Session::flash('swal', [
                        'type' => 'warning',
                        'title' => 'Mandatory Fields!',
                        'message' => 'HOD Final Review Tab is yet to be filled'
                    ]);

                    return redirect()->back();
                }
                 else {
                    // dd($updateCFT->intial_update_comments);
                    Session::flash('swal', [
                        'type' => 'success',
                        'title' => 'Success',
                        'message' => 'Document Sent'
                    ]);
                }
                $changeControl->stage = "12";
                $changeControl->status = "Implementation verification by QA/CQA";
                $changeControl->closure_approved_by = Auth::user()->name;
                $changeControl->closure_approved_on = Carbon::now()->format('d-M-Y');
                $changeControl->closure_approved_comment = $request->comments;

                $history = new GlobalChangeControlAuditTrail();
                $history->cc_id = $id;
                
                $history->activity_type = 'HOD Final Review Complete By, HOD Final Review Complete On';
                if (is_null($lastDocument->closure_approved_by) || $lastDocument->closure_approved_by === '') {
                    $history->previous = "NULL";
                } else {
                    $history->previous = $lastDocument->closure_approved_by . ' , ' . $lastDocument->closure_approved_on;
                }
                $history->current = $changeControl->closure_approved_by . ' , ' . $changeControl->closure_approved_on;
                if (is_null($lastDocument->closure_approved_by) || $lastDocument->closure_approved_on === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }

                $history->action = 'HOD Final Review Complete';
                $history->comment = $request->comments;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to = "Implementation verification by QA/CQA";
                $history->change_from = $lastDocument->status;
                $history->stage = 'Plan Proposed';
                $history->save();
                //  $list = Helpers::getHodUserList();
                //     foreach ($list as $u) {
                //         if($u->q_m_s_divisions_id == $changeControl->division_id){
                //             $email = Helpers::getInitiatorEmail($u->user_id);
                //              if ($email !== null) {
                //               Mail::send(
                //                   'mail.view-mail',
                //                    ['data' => $changeControl],
                //                 function ($message) use ($email) {
                //                     $message->to($email)
                //                         ->subject("Document is Send By".Auth::user()->name);
                //                 }
                //               );
                //             }
                //      }
                //   }
                $changeControl->update();
                toastr()->success('Sent to Closed Done');
                return back();
        }

        if ($changeControl->stage == 12) {
            if (is_null($lastDocument->implementation_verification_comments))
            {
                Session::flash('swal', [
                    'type' => 'warning',
                    'title' => 'Mandatory Fields!',
                    'message' => 'Implementation Verification Tab is yet to be filled'
                ]);

                return redirect()->back();
            }
             else {
                Session::flash('swal', [
                    'type' => 'success',
                    'title' => 'Success',
                    'message' => 'Document Sent'
                ]);
            }
            $changeControl->stage = "13";
            $changeControl->status = "QA/CQA Closure Approval";
            $comments->cc_id =$id;
            $comments->send_for_final_qa_head_approval = Auth::user()->name;
            $comments->send_for_final_qa_head_approval_on = Carbon::now()->format('d-M-Y');
            $comments->send_for_final_qa_head_approval_comment = $request->comments;
            
            $comments->save();
            $history = new GlobalChangeControlAuditTrail();
            $history->cc_id = $id;
            
            $history->activity_type = 'Implementation verification by QA/CQA By, Implementation verification by QA/CQA On';
            if (is_null($lastDocument->send_for_final_qa_head_approval) || $lastDocument->send_for_final_qa_head_approval === '') {
                $history->previous = "NULL";
            } else {
                $history->previous = $lastDocument->send_for_final_qa_head_approval . ' , ' . $lastDocument->send_for_final_qa_head_approval_on;
            }
            $history->current = $comments->send_for_final_qa_head_approval . ' , ' . $comments->send_for_final_qa_head_approval_on;
            if (is_null($lastDocument->send_for_final_qa_head_approval) || $lastDocument->send_for_final_qa_head_approval_on === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->action = 'Send For Final QA/CQA Head Approval';
            $history->comment = $request->comments;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "QA/CQA Closure Approval";
            $history->change_from = $lastDocument->status;
            $history->stage = 'Plan Proposed';
            $history->save();
            //  $list = Helpers::getHodUserList();
            //     foreach ($list as $u) {
            //         if($u->q_m_s_divisions_id == $changeControl->division_id){
            //             $email = Helpers::getInitiatorEmail($u->user_id);
            //              if ($email !== null) {
            //               Mail::send(
            //                   'mail.view-mail',
            //                    ['data' => $changeControl],
            //                 function ($message) use ($email) {
            //                     $message->to($email)
            //                         ->subject("Document is Send By".Auth::user()->name);
            //                 }
            //               );
            //             }
            //      }
            //   }
            $changeControl->update();
            toastr()->success('Sent to Closed Done');
            return back();
        }

        if ($changeControl->stage == 13) {
            if (is_null($changeControl->qa_closure_comments))
            {
                Session::flash('swal', [
                    'type' => 'warning',
                    'title' => 'Mandatory Fields!',
                    'message' => 'Change Closure Tab is yet to be filled'
                ]);

                return redirect()->back();
            }
            else {
                // dd($updateCFT->intial_update_comments);
                Session::flash('swal', [
                    'type' => 'success',
                    'title' => 'Success',
                    'message' => 'Document Sent'
                ]);
            }
            $changeControl->stage = "14";
            $changeControl->status = "Closed Done";

            $comments->cc_id =$id;
            $comments->closure_approved_by = Auth::user()->name;
            $comments->closure_approved_on = Carbon::now()->format('d-M-Y');
            $comments->closure_approved_comment = $request->comments;
            
            $comments->save();
        

            $history = new GlobalChangeControlAuditTrail();
            $history->cc_id = $id;
            
            $history->activity_type = 'QA/CQA Closure Approval By, Closure Approval On';
            if (is_null($lastDocument->closure_approved_by) || $lastDocument->closure_approved_by === '') {
                $history->previous = "NULL";
            } else {
                $history->previous = $lastDocument->closure_approved_by . ' , ' . $lastDocument->closure_approved_on;
            }
            $history->current = $comments->closure_approved_by . ' , ' . $changeControl->closure_approved_on;
            if (is_null($lastDocument->closure_approved_by) || $lastDocument->closure_approved_on === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->action = 'Closure Approved';
            $history->comment = $request->comments;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Closed Done";
            $history->change_from = $lastDocument->status;
            $history->stage = 'Plan Proposed';
            $history->save();
            //  $list = Helpers::getHodUserList();
            //     foreach ($list as $u) {
            //         if($u->q_m_s_divisions_id == $changeControl->division_id){
            //             $email = Helpers::getInitiatorEmail($u->user_id);
            //              if ($email !== null) {
            //               Mail::send(
            //                   'mail.view-mail',
            //                    ['data' => $changeControl],
            //                 function ($message) use ($email) {
            //                     $message->to($email)
            //                         ->subject("Document is Send By".Auth::user()->name);
            //                 }
            //               );
            //             }
            //      }
            //   }
            $changeControl->update();
            toastr()->success('Sent to Closed Done');
            return back();
        }
        } else {
            toastr()->error('E-signature Not match');
            return back();
        }
    }

    public function stagereject(Request $request, $id)
    {
        if ($request->username == Auth::user()->Username && Hash::check($request->password, Auth::user()->password)) {
            $changeControl = GlobalChangeControl::find($id);
            $lastDocument = GlobalChangeControl::find($id);
            $lastdata = ChangeControlComment::where('cc_id', $id)->first();
            $comment = ChangeControlComment::where('cc_id', $id)->firstOrCreate();
            $stageComment = ChangeControlStageComment::where('cc_id', $id)->firstOrCreate();
            $evaluation = Evaluation::where('cc_id', $id)->first();
            $updateCFT = GlobalChangeControlCft::where('cc_id', $id)->latest()->first();

            if ($changeControl->stage == 13) {
                $changeControl->stage = "12";
                $changeControl->status = "Implementation Verification by QA/CQA";

                $changeControl->QaClouseToPostImplementationBy = Auth::user()->name;
                $changeControl->QaClouseToPostImplementationOn = Carbon::now()->format('d-M-Y');
                $changeControl->QaClouseToPostImplementationComment = $request->comments;


                $history = new GlobalChangeControlAuditTrail();
                $history->cc_id = $id;
                
                $history->activity_type = 'More Info Required By, More Info Required On';
                if (is_null($lastDocument->QaClouseToPostImplementationBy) || $lastDocument->QaClouseToPostImplementationBy === '') {
                    $history->previous = "NULL";
                } else {
                    $history->previous = $lastDocument->QaClouseToPostImplementationBy . ' , ' . $lastDocument->QaClouseToPostImplementationOn;
                }
                $history->current = $changeControl->QaClouseToPostImplementationBy . ' , ' . $changeControl->QaClouseToPostImplementationOn;
                if (is_null($lastDocument->QaClouseToPostImplementationBy) || $lastDocument->QaClouseToPostImplementationOn === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }

                $history->action = 'More Information Required';
                $history->comment = $request->comments;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to = "Implementation Verification by QA/CQA";
                $history->change_from = $lastDocument->status;
                $history->stage = 'Plan Proposed';
                $history->save();

                //  $list = Helpers::getHodUserList();
                //     foreach ($list as $u) {
                //         if($u->q_m_s_divisions_id == $changeControl->division_id){
                //             $email = Helpers::getInitiatorEmail($u->user_id);
                //              if ($email !== null) {
                //               Mail::send(
                //                   'mail.view-mail',
                //                    ['data' => $changeControl],
                //                 function ($message) use ($email) {
                //                     $message->to($email)
                //                         ->subject("Document is Send By".Auth::user()->name);
                //                 }
                //               );
                //             }
                //      }
                //   }
                $changeControl->update();
                toastr()->success('Sent to Implementation verification by QA/CQA');
                return back();

            }

            if ($changeControl->stage == 12) {
                $changeControl->stage = "11";
                $changeControl->status = "HOD Final Review";

                $stageComment->cc_id = $id;
                $stageComment->implementationToHODFinalBy = Auth::user()->name;
                $stageComment->implementationToHODFinalOn = Carbon::now()->format('d-M-Y');
                $stageComment->implementationToHODFinalComment = $request->comments;
                $stageComment->save();

                $history = new GlobalChangeControlAuditTrail();
                $history->cc_id = $id;
                
                $history->activity_type = 'More Info Required By, More Info Required On';
                if (is_null($lastDocument->implementationToHODFinalBy) || $lastDocument->implementationToHODFinalBy === '') {
                    $history->previous = "NULL";
                } else {
                    $history->previous = $lastDocument->implementationToHODFinalBy . ' , ' . $lastDocument->implementationToHODFinalOn;
                }
                $history->current = $stageComment->implementationToHODFinalBy . ' , ' . $stageComment->implementationToHODFinalOn;
                if (is_null($lastDocument->implementationToHODFinalBy) || $lastDocument->implementationToHODFinalOn === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }

                $history->action = 'More Information Required';
                $history->comment = $request->comments;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to = "HOD Final Review";
                $history->change_from = $lastDocument->status;
                $history->stage = 'Plan Proposed';
                $history->save();

                //  $list = Helpers::getHodUserList();
                //     foreach ($list as $u) {
                //         if($u->q_m_s_divisions_id == $changeControl->division_id){
                //             $email = Helpers::getInitiatorEmail($u->user_id);
                //              if ($email !== null) {
                //               Mail::send(
                //                   'mail.view-mail',
                //                    ['data' => $changeControl],
                //                 function ($message) use ($email) {
                //                     $message->to($email)
                //                         ->subject("Document is Send By".Auth::user()->name);
                //                 }
                //               );
                //             }
                //      }
                //   }
                $changeControl->update();
                toastr()->success('Sent to HOD Final Review');
                return back();

            }

            if ($changeControl->stage == 11) {
                $changeControl->stage = "10";
                $changeControl->status = "Pending Initiator Update";

                $stageComment->cc_id = $id;
                $stageComment->HodFinalToPendingInitiatorBy = Auth::user()->name;
                $stageComment->HodFinalToPendingInitiatorOn = Carbon::now()->format('d-M-Y');
                $stageComment->HodFinalToPendingInitiatorComment = $request->comments;
                $stageComment->save();

                $history = new GlobalChangeControlAuditTrail();
                $history->cc_id = $id;
                
                $history->activity_type = 'More Info Required By, More Info Required On';
                if (is_null($lastDocument->HodFinalToPendingInitiatorBy) || $lastDocument->HodFinalToPendingInitiatorBy === '') {
                    $history->previous = "NULL";
                } else {
                    $history->previous = $lastDocument->HodFinalToPendingInitiatorBy . ' , ' . $lastDocument->HodFinalToPendingInitiatorOn;
                }
                $history->current = $stageComment->HodFinalToPendingInitiatorBy . ' , ' . $stageComment->HodFinalToPendingInitiatorOn;
                if (is_null($lastDocument->HodFinalToPendingInitiatorBy) || $lastDocument->HodFinalToPendingInitiatorOn === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }

                $history->action = 'More Information Required';
                $history->comment = $request->comments;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to = "Pending Initiator Update";
                $history->change_from = $lastDocument->status;
                $history->stage = 'Plan Proposed';
                $history->save();

                //  $list = Helpers::getHodUserList();
                //     foreach ($list as $u) {
                //         if($u->q_m_s_divisions_id == $changeControl->division_id){
                //             $email = Helpers::getInitiatorEmail($u->user_id);
                //              if ($email !== null) {
                //               Mail::send(
                //                   'mail.view-mail',
                //                    ['data' => $changeControl],
                //                 function ($message) use ($email) {
                //                     $message->to($email)
                //                         ->subject("Document is Send By".Auth::user()->name);
                //                 }
                //               );
                //             }
                //      }
                //   }
                $changeControl->update();
                toastr()->success('Sent to Pending Initiator Update');
                return back();

            }

            if ($changeControl->stage == 8) {
                $changeControl->stage = "6";
                $changeControl->status = "QA/CQA Final Review";
                $changeControl->qa_head_to_qaFinal_by = Auth::user()->name;
                $changeControl->qa_head_to_qaFinal_on = Carbon::now()->format('d-M-Y');
                $changeControl->qa_head_to_qaFinal_comment = $request->comments;

                $history = new GlobalChangeControlAuditTrail();
                $history->cc_id = $id;
                
                $history->activity_type = 'More Info Required By, More Info Required On';
                if (is_null($lastDocument->qa_head_to_qaFinal_by) || $lastDocument->qa_head_to_qaFinal_by === '') {
                    $history->previous = "NULL";
                } else {
                    $history->previous = $lastDocument->qa_head_to_qaFinal_by . ' , ' . $lastDocument->qa_head_to_qaFinal_on;
                }
                $history->current = $changeControl->qa_head_to_qaFinal_by . ' , ' . $changeControl->qa_head_to_qaFinal_on;
                if (is_null($lastDocument->qa_head_to_qaFinal_by) || $lastDocument->qa_head_to_qaFinal_on === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }

                $history->action = 'More Information Required';
                $history->comment = $request->comments;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to = "QA/CQA Final Review";
                $history->change_from = $lastDocument->status;
                $history->stage = 'Plan Proposed';
                $history->save();

                //  $list = Helpers::getHodUserList();
                //     foreach ($list as $u) {
                //         if($u->q_m_s_divisions_id == $changeControl->division_id){
                //             $email = Helpers::getInitiatorEmail($u->user_id);
                //              if ($email !== null) {
                //               Mail::send(
                //                   'mail.view-mail',
                //                    ['data' => $changeControl],
                //                 function ($message) use ($email) {
                //                     $message->to($email)
                //                         ->subject("Document is Send By".Auth::user()->name);
                //                 }
                //               );
                //             }
                //      }
                //   }
                $changeControl->update();
                toastr()->success('Sent to QA/CQA Final Review');
                return back();

            }

            if ($changeControl->stage == 10) {
                    $changeControl->stage = "9";
                    $changeControl->status = "Pending Initiator Update";
                    $changeControl->QaClouseToPostImplementationBy = Auth::user()->name;
                    $changeControl->QaClouseToPostImplementationOn = Carbon::now()->format('d-M-Y');
                    $changeControl->QaClouseToPostImplementationComment = $request->comments;

                    $history = new GlobalChangeControlAuditTrail();
                    $history->cc_id = $id;
                    
                    // $history->activity_type = 'More Info Required By, More Info Required On';
                    // if (is_null($lastDocument->QaClouseToPostImplementationBy) || $lastDocument->QaClouseToPostImplementationBy === '') {
                    //     $history->previous = "NULL";
                    // } else {
                    //     $history->previous = $lastDocument->QaClouseToPostImplementationBy . ' , ' . $lastDocument->QaClouseToPostImplementationOn;
                    // }
                    // $history->current = $changeControl->QaClouseToPostImplementationBy . ' , ' . $changeControl->QaClouseToPostImplementationOn;
                    // if (is_null($lastDocument->QaClouseToPostImplementationBy) || $lastDocument->QaClouseToPostImplementationOn === '') {
                    //     $history->action_name = 'New';
                    // } else {
                    //     $history->action_name = 'Update';
                    // }
                    $history->activity_type = 'Not Applicable';
                    $history->previous = 'Not Applicable';
                    $history->action_name = 'Not Applicable';
                    $history->action = 'More Info Required';
                    $history->current = 'Not Applicable';
                    $history->action = 'More Info Required';
                    $history->comment = $request->comments;
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $lastDocument->status;
                    $history->change_to = "Pending Initiator Update";
                    $history->change_from = $lastDocument->status;
                    $history->stage = 'Plan Proposed';
                    $history->save();

                    //  $list = Helpers::getHodUserList();
                    //     foreach ($list as $u) {
                    //         if($u->q_m_s_divisions_id == $changeControl->division_id){
                    //             $email = Helpers::getInitiatorEmail($u->user_id);
                    //              if ($email !== null) {
                    //               Mail::send(
                    //                   'mail.view-mail',
                    //                    ['data' => $changeControl],
                    //                 function ($message) use ($email) {
                    //                     $message->to($email)
                    //                         ->subject("Document is Send By".Auth::user()->name);
                    //                 }
                    //               );
                    //             }
                    //      }
                    //   }
                    $changeControl->update();
                    $history = new CCStageHistory();
                    $history->type = "Change-Control";
                    $history->doc_id = $id;
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->stage_id = $changeControl->stage;
                    $history->comments = $request->comments;
                    $history->status = $changeControl->status;
                    $history->save();

                    $history = new CCStageHistory();
                    $history->type = "Activity-log";
                    $history->doc_id = $id;
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->stage_id = $changeControl->stage;
                    $history->comments = $request->comments;
                    $history->status = $changeControl->status;
                    $history->save();
                    // Helpers::hodMail($changeControl);
                    toastr()->success('Sent to Post Implementation');
                    return back();

            }
            if ($changeControl->stage == 9) {
                    $changeControl->stage = "7";
                    $changeControl->status = "QA/CQA Head/Manager Designee Approval";
                    $changeControl->postImplementationToQaHeadBy = Auth::user()->name;
                    $changeControl->postImplementationToQaHeadOn = Carbon::now()->format('d-M-Y');
                    $changeControl->postImplementationToQaHeadComment = $request->comments;

                    $history = new GlobalChangeControlAuditTrail();
                    $history->cc_id = $id;
                    
                    // $history->activity_type = 'More Info Required By, More Info Required On';
                    // if (is_null($lastDocument->postImplementationToQaHeadBy) || $lastDocument->postImplementationToQaHeadBy === '') {
                    //     $history->previous = "NULL";
                    // } else {
                    //     $history->previous = $lastDocument->postImplementationToQaHeadBy . ' , ' . $lastDocument->postImplementationToQaHeadOn;
                    // }
                    // $history->current = $changeControl->postImplementationToQaHeadBy . ' , ' . $changeControl->postImplementationToQaHeadOn;
                    // if (is_null($lastDocument->postImplementationToQaHeadBy) || $lastDocument->postImplementationToQaHeadOn === '') {
                    //     $history->action_name = 'New';
                    // } else {
                    //     $history->action_name = 'Update';
                    // }
                    $history->activity_type = 'Not Applicable';
                    $history->previous = 'Not Applicable';
                    $history->action_name = 'Not Applicable';
                    $history->action = 'More Info Required';
                    $history->current = 'Not Applicable';
                    $history->action = 'More Info Required';
                    $history->comment = $request->comments;
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $lastDocument->status;
                    $history->change_to = "QA/CQA Head/Manager Designee Approval";
                    $history->change_from = $lastDocument->status;
                    $history->stage = 'Plan Proposed';
                    $history->save();
                    //  $list = Helpers::getHodUserList();
                    //     foreach ($list as $u) {
                    //         if($u->q_m_s_divisions_id == $changeControl->division_id){
                    //             $email = Helpers::getInitiatorEmail($u->user_id);
                    //              if ($email !== null) {
                    //               Mail::send(
                    //                   'mail.view-mail',
                    //                    ['data' => $changeControl],
                    //                 function ($message) use ($email) {
                    //                     $message->to($email)
                    //                         ->subject("Document is Send By".Auth::user()->name);
                    //                 }
                    //               );
                    //             }
                    //      }
                    //   }
                    $changeControl->update();
                    $history = new CCStageHistory();
                    $history->type = "Change-Control";
                    $history->doc_id = $id;
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->stage_id = $changeControl->stage;
                    $history->comments = $request->comments;
                    $history->status = $changeControl->status;
                    $history->save();

                    $history = new CCStageHistory();
                    $history->type = "Activity-log";
                    $history->doc_id = $id;
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->stage_id = $changeControl->stage;
                    $history->comments = $request->comments;
                    $history->status = $changeControl->status;
                    $history->save();
                    // Helpers::hodMail($changeControl);
                    toastr()->success('Sent to QA Head/Manager Designee Approval');
                    return back();
            }
            if ($changeControl->stage == 7) {
                $changeControl->stage = "6";
                $changeControl->status = "Pending RA Approval";

                $comment->cc_id = $id;
                $comment->QaHeadToQaFinalBy = Auth::user()->name;
                $comment->QaHeadToQaFinalOn = Carbon::now()->format('d-M-Y');
                $comment->QaHeadToQaFinalComment = $request->comments;
                $comment->save();

                $history = new GlobalChangeControlAuditTrail();
                $history->cc_id = $id;
                
                // $history->activity_type = 'More Info Required By, More Info Required On';
                // if (is_null($lastDocument->QaHeadToQaFinalBy) || $lastDocument->QaHeadToQaFinalBy === '') {
                //     $history->previous = "NULL";
                // } else {
                //     $history->previous = $lastDocument->QaHeadToQaFinalBy . ' , ' . $lastDocument->QaHeadToQaFinalOn;
                // }
                // $history->current = $changeControl->QaHeadToQaFinalBy . ' , ' . $changeControl->QaHeadToQaFinalOn;
                // if (is_null($lastDocument->QaHeadToQaFinalBy) || $lastDocument->QaHeadToQaFinalOn === '') {
                //     $history->action_name = 'New';
                // } else {
                //     $history->action_name = 'Update';
                // }
                $history->activity_type = 'Not Applicable';
                $history->previous = 'Not Applicable';
                $history->action_name = 'Not Applicable';
                $history->action = 'More Info Required';
                $history->current = 'Not Applicable';
                $history->action = 'More Info Required';
                $history->comment = $request->comments;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to = "QA/CQA Final Review";
                $history->change_from = $lastDocument->status;
                $history->stage = 'Plan Proposed';
                $history->save();

                //  $list = Helpers::getHodUserList();
                //     foreach ($list as $u) {
                //         if($u->q_m_s_divisions_id == $changeControl->division_id){
                //             $email = Helpers::getInitiatorEmail($u->user_id);
                //              if ($email !== null) {
                //               Mail::send(
                //                   'mail.view-mail',
                //                    ['data' => $changeControl],
                //                 function ($message) use ($email) {
                //                     $message->to($email)
                //                         ->subject("Document is Send By".Auth::user()->name);
                //                 }
                //               );
                //             }
                //      }
                //   }
                $changeControl->update();
                $history = new CCStageHistory();
                $history->type = "Change-Control";
                $history->doc_id = $id;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->stage_id = $changeControl->stage;
                $history->comments = $request->comments;
                $history->status = $changeControl->status;
                $history->save();

                $history = new CCStageHistory();
                $history->type = "Activity-log";
                $history->doc_id = $id;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->stage_id = $changeControl->stage;
                $history->comments = $request->comments;
                $history->status = $changeControl->status;
                $history->save();
                // Helpers::hodMail($changeControl);
                toastr()->success('Sent to Pending RA Approval');
                return back();
            }
            if ($changeControl->stage == 5) {
                $changeControl->stage = "4";
                $changeControl->status = "CFT Review";

                $comment->cc_id = $id;
                $comment->comment = Auth::user()->name;
                $comment->comment = Carbon::now()->format('d-M-Y');
                $comment->comment = $request->comments;
                $comment->save();

                $history = new GlobalChangeControlAuditTrail();
                $history->cc_id = $id;
                $history->activity_type = 'Activity Log';
                $history->previous = "";
                $history->current = "";
                $history->action = 'More Info Required';
                $history->comment = $request->comments;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to = "CFT Review";
                $history->change_from = $lastDocument->status;
                $history->stage = 'Plan Proposed';
                $history->save();
                //  $list = Helpers::getHodUserList();
                //     foreach ($list as $u) {
                //         if($u->q_m_s_divisions_id == $changeControl->division_id){
                //             $email = Helpers::getInitiatorEmail($u->user_id);
                //              if ($email !== null) {
                //               Mail::send(
                //                   'mail.view-mail',
                //                    ['data' => $changeControl],
                //                 function ($message) use ($email) {
                //                     $message->to($email)
                //                         ->subject("Document is Send By".Auth::user()->name);
                //                 }
                //               );
                //             }
                //      }
                //   }
                $changeControl->update();
                $history = new CCStageHistory();
                $history->type = "Change-Control";
                $history->doc_id = $id;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->stage_id = $changeControl->stage;
                $history->comments = $request->comments;
                $history->status = $changeControl->status;
                $history->save();

                $history = new CCStageHistory();
                $history->type = "Activity-log";
                $history->doc_id = $id;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->stage_id = $changeControl->stage;
                $history->comments = $request->comments;
                $history->status = $changeControl->status;
                $history->save();
                // Helpers::hodMail($changeControl);
                toastr()->success('Sent to CFT Review');
                return back();
            }
            if ($changeControl->stage == 4) {
                $changeControl->stage = "3";
                $changeControl->status = "QA/CQA Initial Review";

                $comment->cc_id = $id;
                $comment->cftToQaInitialBy = Auth::user()->name;
                $comment->cftToQaInitialOn = Carbon::now()->format('d-M-Y');
                $comment->cftToQaInitialComment = $request->comments;
                $comment->save();

                $history = new GlobalChangeControlAuditTrail();
                $history->cc_id = $id;
                
                // $history->activity_type = 'More Info Required By, More Info Required On';
                // if (is_null($lastDocument->cftToQaInitialBy) || $lastDocument->cftToQaInitialBy === '') {
                //     $history->previous = "NULL";
                // } else {
                //     $history->previous = $lastDocument->cftToQaInitialBy . ' , ' . $lastDocument->cftToQaInitialOn;
                // }
                // $history->current = $changeControl->cftToQaInitialBy . ' , ' . $changeControl->cftToQaInitialOn;
                // if (is_null($lastDocument->cftToQaInitialBy) || $lastDocument->cftToQaInitialOn === '') {
                //     $history->action_name = 'New';
                // } else {
                //     $history->action_name = 'Update';
                // }
                $history->activity_type = 'Not Applicable';
                $history->previous = 'Not Applicable';
                $history->action_name = 'Not Applicable';
                $history->action = 'More Info Required';
                $history->current = 'Not Applicable';
                $history->action = 'More Info Required';
                $history->comment = $request->comments;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to = "QA/CQA Initial Review";
                $history->change_from = $lastDocument->status;
                $history->stage = 'Plan Proposed';
                $history->save();
                //  $list = Helpers::getHodUserList();
                //     foreach ($list as $u) {
                //         if($u->q_m_s_divisions_id == $changeControl->division_id){
                //             $email = Helpers::getInitiatorEmail($u->user_id);
                //              if ($email !== null) {
                //               Mail::send(
                //                   'mail.view-mail',
                //                    ['data' => $changeControl],
                //                 function ($message) use ($email) {
                //                     $message->to($email)
                //                         ->subject("Document is Send By".Auth::user()->name);
                //                 }
                //               );
                //             }
                //      }
                //   }
                $changeControl->update();
                $history = new CCStageHistory();
                $history->type = "Change-Control";
                $history->doc_id = $id;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->stage_id = $changeControl->stage;
                $history->comments = $request->comments;
                $history->status = $changeControl->status;
                $history->save();

                $history = new CCStageHistory();
                $history->type = "Activity-log";
                $history->doc_id = $id;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->stage_id = $changeControl->stage;
                $history->comments = $request->comments;
                $history->status = $changeControl->status;
                $history->save();
                toastr()->success('Sent to QA/CQA Initial Review');
                return back();
            }
            if ($changeControl->stage == 3) {
                $changeControl->stage = "2";
                $changeControl->status = "HOD Review";

                $comment->cc_id = $id;
                $comment->QaInitialToHodBy = Auth::user()->name;
                $comment->QaInitialToHodOn = Carbon::now()->format('d-M-Y');
                $comment->QaInitialToHodComment = $request->comments;
                $comment->save();

                $history = new GlobalChangeControlAuditTrail();
                $history->cc_id = $id;
                
                // $history->activity_type = 'More Info Required By, More Info Required On';
                // if (is_null($lastdata->QaInitialToHodBy) || $lastdata->QaInitialToHodBy === '') {
                //     $history->previous = "NULL";
                // } else {
                //     $history->previous = $lastdata->QaInitialToHodBy . ' , ' . $lastdata->QaInitialToHodOn;
                // }
                // $history->current = $changeControl->QaInitialToHodBy . ' , ' . $changeControl->QaInitialToHodOn;
                // if (is_null($lastdata->QaInitialToHodBy) || $lastdata->QaInitialToHodOn === '') {
                //     $history->action_name = 'New';
                // } else {
                //     $history->action_name = 'Update';
                // }
                $history->activity_type = 'Not Applicable';
                $history->previous = 'Not Applicable';
                $history->action_name = 'Not Applicable';
                $history->action = 'More Info Required';
                $history->current = 'Not Applicable';
                $history->action = 'More Info Required';
                $history->comment = $request->comments;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to = "HOD Review";
                $history->change_from = $lastDocument->status;
                $history->stage = 'Plan Proposed';
                $history->save();
                //  $list = Helpers::getHodUserList();
                //     foreach ($list as $u) {
                //         if($u->q_m_s_divisions_id == $changeControl->division_id){
                //             $email = Helpers::getInitiatorEmail($u->user_id);
                //              if ($email !== null) {
                //               Mail::send(
                //                   'mail.view-mail',
                //                    ['data' => $changeControl],
                //                 function ($message) use ($email) {
                //                     $message->to($email)
                //                         ->subject("Document is Send By".Auth::user()->name);
                //                 }
                //               );
                //             }
                //      }
                //   }
                $changeControl->update();
                $history = new CCStageHistory();
                $history->type = "Change-Control";
                $history->doc_id = $id;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->stage_id = $changeControl->stage;
                $history->comments = $request->comments;
                $history->status = $changeControl->status;
                $history->save();

                $history = new CCStageHistory();
                $history->type = "Activity-log";
                $history->doc_id = $id;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->comments = $request->comments;
                $history->stage_id = $changeControl->stage;
                $history->status = $changeControl->status;
                $history->save();
                // Helpers::hodMail($changeControl);
                toastr()->success('Sent to HOD Review');
                return back();
            }
            if ($changeControl->stage == 2) {
                $changeControl->stage = "1";
                $changeControl->status = "Opened";

                $comment->cc_id = $id;
                $comment->HodToOpenedBy = Auth::user()->name;
                $comment->HodToOpenedOn = Carbon::now()->format('d-M-Y');
                $comment->HodToOpenedComment = $request->comments;
                $comment->save();

                $history = new GlobalChangeControlAuditTrail();
                $history->cc_id = $id;
                
                // $history->activity_type = 'More Info Required By, More Info Required On';
                // if (is_null($lastdata->HodToOpenedBy) || $lastdata->HodToOpenedBy === '') {
                //     $history->previous = "NULL";
                // } else {
                //     $history->previous = $lastdata->HodToOpenedBy . ' , ' . $lastdata->HodToOpenedOn;
                // }
                // $history->current = $comment->HodToOpenedBy . ' , ' . $comment->HodToOpenedOn;
                // if (is_null($lastdata->HodToOpenedBy) || $lastdata->HodToOpenedOn === '') {
                //     $history->action_name = 'New';
                // } else {
                //     $history->action_name = 'Update';
                // }
                $history->activity_type = 'Not Applicable';
                $history->previous = 'Not Applicable';
                $history->action_name = 'Not Applicable';
                $history->action = 'More Info Required';
                $history->current = 'Not Applicable';
                $history->action = 'More Info Required';
                $history->comment = $request->comments;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to = "Opened";
                $history->change_from = $lastDocument->status;
                $history->stage = 'Plan Proposed';
                $history->save();
                //  $list = Helpers::getHodUserList();
                //     foreach ($list as $u) {
                //         if($u->q_m_s_divisions_id == $changeControl->division_id){
                //             $email = Helpers::getInitiatorEmail($u->user_id);
                //              if ($email !== null) {
                //               Mail::send(
                //                   'mail.view-mail',
                //                    ['data' => $changeControl],
                //                 function ($message) use ($email) {
                //                     $message->to($email)
                //                         ->subject("Document is Send By".Auth::user()->name);
                //                 }
                //               );
                //             }
                //      }
                //   }
                $changeControl->update();
                $history = new CCStageHistory();
                $history->type = "Change-Control";
                $history->doc_id = $id;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->stage_id = $changeControl->stage;
                $history->comments = $request->comments;
                $history->status = $changeControl->status;
                $history->save();

                $history = new CCStageHistory();
                $history->type = "Activity-log";
                $history->doc_id = $id;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->comments = $request->comments;
                $history->stage_id = $changeControl->stage;
                $history->status = $changeControl->status;
                $history->save();
                // Helpers::hodMail($changeControl);
                toastr()->success('Sent to Opened');
                return back();
            }
            if ($changeControl->stage == 1) {
                $changeControl->stage = "0";
                $changeControl->status = "Close - Cancelled";

                $comment->cc_id = $id;
                $comment->openedToCancelBy = Auth::user()->name;
                $comment->openedToCancelOn = Carbon::now()->format('d-M-Y');
                $comment->openedToCancelComment = $request->comments;
                $comment->save();

                $history = new GlobalChangeControlAuditTrail();
                $history->cc_id = $id;
                
                $history->activity_type = 'Cancel By, Cancel On';
                if (is_null($lastDocument->openedToCancelBy) || $lastDocument->openedToCancelBy === '') {
                    $history->previous = "NULL";
                } else {
                    $history->previous = $lastDocument->openedToCancelBy . ' , ' . $lastDocument->openedToCancelOn;
                }
                $history->current = $changeControl->openedToCancelBy . ' , ' . $changeControl->openedToCancelOn;
                if (is_null($lastDocument->openedToCancelBy) || $lastDocument->openedToCancelOn === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }

                $history->action = 'Cancel';
                $history->comment = $request->comments;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to = "Close - Cancelled";
                $history->change_from = $lastDocument->status;
                $history->stage = 'Plan Proposed';
                $history->save();
                //  $list = Helpers::getHodUserList();
                //     foreach ($list as $u) {
                //         if($u->q_m_s_divisions_id == $changeControl->division_id){
                //             $email = Helpers::getInitiatorEmail($u->user_id);
                //              if ($email !== null) {
                //               Mail::send(
                //                   'mail.view-mail',
                //                    ['data' => $changeControl],
                //                 function ($message) use ($email) {
                //                     $message->to($email)
                //                         ->subject("Document is Send By".Auth::user()->name);
                //                 }
                //               );
                //             }
                //      }
                //   }
                $changeControl->update();
                $history = new CCStageHistory();
                $history->type = "Change-Control";
                $history->doc_id = $id;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->stage_id = $changeControl->stage;
                $history->comments = $request->comments;
                $history->status = $changeControl->status;
                $history->save();

                $history = new CCStageHistory();
                $history->type = "Activity-log";
                $history->doc_id = $id;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->comments = $request->comments;
                $history->stage_id = $changeControl->stage;
                $history->status = $changeControl->status;
                $history->save();
                // Helpers::hodMail($changeControl);
                toastr()->success('Sent to Close - Cancelled');
                return back();
            }
        } else {
            toastr()->error('E-signature Not match');
            return back();
        }
    }   

    public function sendToInitiator(Request $request, $id)
    {
        if ($request->username == Auth::user()->Username && Hash::check($request->password, Auth::user()->password)) {
            $changeControl = GlobalChangeControl::find($id);
            $lastDocument = GlobalChangeControl::find($id);
            $cftResponse = GlobalChangeControlResponse::withoutTrashed()->where(['cc_id' => $id])->get();
            $list = Helpers::getInitiatorUserList();
            $cftResponse->each(function ($response) {
            $response->delete();
        });

        $changeControl->stage = "1";
        $changeControl->status = "Opened";
        $changeControl->qa_final_to_initiator_by = Auth::user()->name;
        $changeControl->qa_final_to_initiator_on = Carbon::now()->format('d-M-Y');
        $changeControl->qa_final_to_initiator_comment = $request->comments;
        
        $history = new GlobalChangeControlAuditTrail();
        $history->cc_id = $id;
        
        $history->activity_type = 'Send To Initiator By, Send To Initiator On';
        if (is_null($lastDocument->qa_final_to_initiator_by) || $lastDocument->qa_final_to_initiator_by === '') {
            $history->previous = "NULL";
        } else {
            $history->previous = $lastDocument->qa_final_to_initiator_by . ' , ' . $lastDocument->qa_final_to_initiator_on;
        }
        $history->current = $changeControl->qa_final_to_initiator_by . ' , ' . $changeControl->qa_final_to_initiator_on;
        if (is_null($lastDocument->qa_final_to_initiator_by) || $lastDocument->qa_final_to_initiator_on === '') {
            $history->action_name = 'New';
        } else {
            $history->action_name = 'Update';
        }

        $history->action = 'Send To Initiator';
        $history->comment = $request->comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to = "Opened";
        $history->change_from = $lastDocument->status;        
        $history->save();
        $changeControl->update();

        $history = new GlobalChangeControlAuditTrail();
        $history->type = "GlobalCC";
        $history->doc_id = $id;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->stage_id = $changeControl->stage;
        $history->status = "Send to Opened State";
        $history->save();
        // foreach ($list as $u) {
        //     if ($u->q_m_s_divisions_id == $deviation->division_id) {
        //         $email = Helpers::getInitiatorEmail($u->user_id);
        //         if ($email !== null) {

        //             try {
        //                 Mail::send(
        //                     'mail.view-mail',
        //                     ['data' => $deviation],
        //                     function ($message) use ($email) {
        //                         $message->to($email)
        //                             ->subject("Activity Performed By " . Auth::user()->name);
        //                     }
        //                 );
        //             } catch (\Exception $e) {
        //                 //log error
        //             }
        //         }
        //     }
        // }
        $changeControl->update();
        toastr()->success('Document Sent');
        return back();

        } else {
            toastr()->error('E-signature Not match');
            return back();
        }
    }

    public function sendToHod(Request $request, $id)
    {
        if ($request->username == Auth::user()->Username && Hash::check($request->password, Auth::user()->password)) {
            $changeControl = GlobalChangeControl::find($id);
            $lastDocument = GlobalChangeControl::find($id);
            $cftResponse = GlobalChangeControlResponse::withoutTrashed()->where(['cc_id' => $id])->get();
            $list = Helpers::getInitiatorUserList();
            $cftResponse->each(function ($response) {
            $response->delete();
        });


        $changeControl->stage = "2";
        $changeControl->status = "HOD Review";
        $changeControl->qa_final_to_HOD_by = Auth::user()->name;
        $changeControl->qa_final_to_HOD_on = Carbon::now()->format('d-M-Y');
        $changeControl->qa_final_to_HOD_comment = $request->comments;

        $history = new GlobalChangeControlAuditTrail();
        $history->cc_id = $id;
        
        $history->activity_type = 'Send To HOD By, Send To HOD On';
        if (is_null($lastDocument->qa_final_to_HOD_by) || $lastDocument->qa_final_to_HOD_by === '') {
            $history->previous = "NULL";
        } else {
            $history->previous = $lastDocument->qa_final_to_HOD_by . ' , ' . $lastDocument->qa_final_to_HOD_on;
        }
        $history->current = $changeControl->qa_final_to_HOD_by . ' , ' . $changeControl->qa_final_to_HOD_on;
        if (is_null($lastDocument->qa_final_to_HOD_by) || $lastDocument->qa_final_to_HOD_on === '') {
            $history->action_name = 'New';
        } else {
            $history->action_name = 'Update';
        }

        $history->action= 'Send To HOD';
        $history->comment = $request->comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to =   "HOD Review";
        $history->change_from = $lastDocument->status;        
        $history->save();
        $changeControl->update();
        
        $history = new GlobalChangeControlAuditTrail();
        $history->type = "GlobalCC";
        $history->doc_id = $id;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->stage_id = $changeControl->stage;
        $history->status = "Send HOD Review";
        $history->save();
        // foreach ($list as $u) {
        //     if ($u->q_m_s_divisions_id == $deviation->division_id) {
        //         $email = Helpers::getInitiatorEmail($u->user_id);
        //         if ($email !== null) {

        //             try {
        //                 Mail::send(
        //                     'mail.view-mail',
        //                     ['data' => $deviation],
        //                     function ($message) use ($email) {
        //                         $message->to($email)
        //                             ->subject("Activity Performed By " . Auth::user()->name);
        //                     }
        //                 );
        //             } catch (\Exception $e) {
        //                 //log error
        //             }
        //         }
        //     }
        // }
        $changeControl->update();
        toastr()->success('Document Sent');
        return back();

        } else {
            toastr()->error('E-signature Not match');
            return back();
        }
    }

    public function sendToInitialQA(Request $request, $id)
    {
        if ($request->username == Auth::user()->Username && Hash::check($request->password, Auth::user()->password)) {
            $changeControl = GlobalChangeControl::find($id);
            $lastDocument = GlobalChangeControl::find($id);
            $cftResponse = GlobalChangeControlResponse::withoutTrashed()->where(['cc_id' => $id])->get();
            $list = Helpers::getInitiatorUserList();
            $cftResponse->each(function ($response) {
            $response->delete();
        });


        $changeControl->stage = "3";
        $changeControl->status = "QA/CQA Initial Review";
        $changeControl->qa_final_to_qainital_by = Auth::user()->name;
        $changeControl->qa_final_to_qainital_on = Carbon::now()->format('d-M-Y');
        $changeControl->qa_final_to_qainital_comment = $request->comments;

        $history = new GlobalChangeControlAuditTrail();
        $history->cc_id = $id;
        
        $history->activity_type = 'Send To QA/CQA Initial By, Send To QA/CQA Initial On';
        if (is_null($lastDocument->qa_final_to_qainital_by) || $lastDocument->qa_final_to_qainital_by === '') {
            $history->previous = "NULL";
        } else {
            $history->previous = $lastDocument->qa_final_to_qainital_by . ' , ' . $lastDocument->qa_final_to_qainital_on;
        }
        $history->current = $changeControl->qa_final_to_qainital_by . ' , ' . $changeControl->qa_final_to_qainital_on;
        if (is_null($lastDocument->qa_final_to_qainital_by) || $lastDocument->qa_final_to_qainital_on === '') {
            $history->action_name = 'New';
        } else {
            $history->action_name = 'Update';
        }

        $history->action= 'Send To QA/CQA Initial';
        $history->comment = $request->comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to =   "QA/CQA Initial Review";
        $history->change_from = $lastDocument->status;        
        $history->save();
        $changeControl->update();

        $history = new GlobalChangeControlAuditTrail();
        $history->type = "GlobalCC";
        $history->doc_id = $id;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->stage_id = $changeControl->stage;
        $history->status = "Sent to QA Initial Review";
        $history->save();
        // foreach ($list as $u) {
        //     if ($u->q_m_s_divisions_id == $deviation->division_id) {
        //         $email = Helpers::getInitiatorEmail($u->user_id);
        //         if ($email !== null) {

        //             try {
        //                 Mail::send(
        //                     'mail.view-mail',
        //                     ['data' => $deviation],
        //                     function ($message) use ($email) {
        //                         $message->to($email)
        //                             ->subject("Activity Performed By " . Auth::user()->name);
        //                     }
        //                 );
        //             } catch (\Exception $e) {
        //                 //log error
        //             }
        //         }
        //     }
        // }
        $changeControl->update();
        toastr()->success('Document Sent');
        return back();

        } else {
            toastr()->error('E-signature Not match');
            return back();
        }
    }


    public function stagecancel(Request $request, $id)
    {
        if ($request->username == Auth::user()->Username && Hash::check($request->password, Auth::user()->password)) {
            $changeControl = GlobalChangeControl::find($id);
            $openState = GlobalChangeControl::find($id);
            $lastDocument = GlobalChangeControl::find($id);

            $changeControl->stage = "0";
            $changeControl->status = "Closed-Cancelled";
            $changeControl->cancelled_by = Auth::user()->name;
            $changeControl->cancelled_on = Carbon::now()->format('d-M-Y');
            $changeControl->cancelled_comment = $request->comments;
            $changeControl->update();

            $history = new GlobalChangeControlAuditTrail();
            $history->cc_id = $id;
            
            $history->activity_type = 'Cancel By, Cancel On';
            if (is_null($lastDocument->cancelled_by) || $lastDocument->cancelled_by === '') {
                $history->previous = "NULL";
            } else {
                $history->previous = $lastDocument->cancelled_by . ' , ' . $lastDocument->cancelled_on;
            }
            $history->current = $changeControl->cancelled_by . ' , ' . $changeControl->cancelled_on;
            if (is_null($lastDocument->cancelled_by) || $lastDocument->cancelled_on === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->action= 'Cancel';
            $history->comment = $request->comments;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Closed - Cancelled";
            $history->change_from = $lastDocument->status;
            $history->stage = 'Plan Proposed';
            $history->save();

            $history = new CCStageHistory();
            $history->type = "Change-Control";
            $history->doc_id = $id;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->stage_id = $changeControl->stage;
            $history->status = $changeControl->status;
            $history->save();
            toastr()->success('Document Sent');
            return back();
        } else {
            toastr()->error('E-signature Not match');
            return back();
        }
    }
    public function child(Request $request, $id)
    {
        $cc = GlobalChangeControl::find($id);
        $parent_id = $id;
        $parent_name = "GlobalCC";
        $parent_type = "GlobalCC";
        $record_number = ((RecordNumber::first()->value('counter')) + 1);
        $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
        $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $due_date = $formattedDate->format('d-M-Y');

        $parent_data = GlobalChangeControl::where('id', $id)->select('record', 'division_id', 'initiator_id', 'short_description')->first();
        $parent_data1 = GlobalChangeControl::select('record', 'division_id', 'initiator_id', 'id')->get();
        $parent_record = GlobalChangeControl::where('id', $id)->value('record');
        $parent_record = str_pad($parent_record, 4, '0', STR_PAD_LEFT);
        $parent_division_id = GlobalChangeControl::where('id', $id)->value('division_id');
        $parent_initiator_id = GlobalChangeControl::where('id', $id)->value('initiator_id');
        $parent_intiation_date = GlobalChangeControl::where('id', $id)->value('intiation_date');
        $parent_short_description = GlobalChangeControl::where('id', $id)->value('short_description');
        $old_record = GlobalChangeControl::select('id', 'division_id', 'record')->get();
          
     //   $data =$parent_data1;
        if ($request->revision == "Action-Item") {
            $record = ((RecordNumber::first()->value('counter')) + 1);
        $record = str_pad($record, 4, '0', STR_PAD_LEFT);
            $cc->originator = User::where('id', $cc->initiator_id)->value('name');
            return view('frontend.action-item.action-item', compact('parent_record','record','parent_id', 'parent_name', 'record_number', 'cc', 'parent_data', 'parent_data1', 'parent_short_description', 'parent_initiator_id', 'parent_intiation_date', 'parent_division_id', 'due_date', 'old_record', 'parent_type'));
        }
        if ($request->revision == "RCA") {
            $cc->originator = User::where('id', $cc->initiator_id)->value('name');
            return view('frontend.forms.root-cause-analysis', compact('parent_record','parent_type','parent_id', 'parent_name', 'record_number', 'cc', 'parent_data', 'parent_data1', 'parent_short_description', 'parent_initiator_id', 'parent_intiation_date', 'parent_division_id', 'due_date', 'old_record'));
        }
        if ($request->revision == "Capa") {
            $old_records = $old_record;
            $cc->originator = User::where('id', $cc->initiator_id)->value('name');
            return view('frontend.forms.capa', compact('parent_record','parent_id','parent_type', 'parent_name', 'record_number', 'cc', 'parent_data', 'parent_data1', 'parent_short_description', 'parent_initiator_id', 'parent_intiation_date', 'parent_division_id', 'due_date', 'old_records'));
        }
        if ($request->revision == "Extension") {
            $cc->originator = User::where('id', $cc->initiator_id)->value('name');
            $relatedRecords = Helpers::getAllRelatedRecords();
            return view('frontend.extension.extension_new', compact('parent_name', 'parent_type', 'parent_id', 'record_number', 'parent_short_description', 'parent_initiator_id', 'parent_intiation_date', 'parent_division_id', 'parent_record', 'cc','relatedRecords'));
        }
        if ($request->revision == "New Document") {
            $division = SetDivision::where('user_id', Auth::id())->latest()->first();
            $request->session()->put('division', $cc->division_id);

            $process = QMSProcess::where('process_name', 'New Document')->first();

            //  if(!empty( $division)){
            //     $division->dname = Division::where('id', $division->division_id)->value('name');
            //     $division->pname = Process::where('id', $division->process_id)->value('process_name');
            //     $process = QMSProcess::where([
            //         'process_name' => 'New Document',
            //         'division_id' => $division->division_id
            //     ])->first();
            // } else {
            //     return "Division not found";
            // }
            $ccId = $id;

            $ccrecord = GlobalChangeControl::get();

            $reviewer = DB::table('user_roles')
                ->join('users', 'user_roles.user_id', '=', 'users.id')
                ->select('user_roles.q_m_s_processes_id', 'users.id', 'users.role', 'users.name')
                ->where('user_roles.q_m_s_processes_id', $process->id)
                ->where('user_roles.q_m_s_roles_id', 2)
                ->groupBy('user_roles.q_m_s_processes_id', 'users.id', 'users.role', 'users.name')
                ->get();



            $approvers = DB::table('user_roles')
                ->join('users', 'user_roles.user_id', '=', 'users.id')
                ->select('user_roles.q_m_s_processes_id', 'users.id', 'users.role', 'users.name')
                ->where('user_roles.q_m_s_processes_id', $process->id)
                ->where('user_roles.q_m_s_roles_id', 1)
                ->groupBy('user_roles.q_m_s_processes_id', 'users.id', 'users.role', 'users.name')
                ->get();

            $hods = DB::table('user_roles')
                ->join('users', 'user_roles.user_id', '=', 'users.id')
                ->select('user_roles.q_m_s_processes_id', 'users.id', 'users.role', 'users.name')
                ->where('user_roles.q_m_s_processes_id', $process->id)
                ->where('user_roles.q_m_s_roles_id', 4)
                ->groupBy('user_roles.q_m_s_processes_id', 'users.id', 'users.role', 'users.name')
                ->get();

            $drafter = DB::table('user_roles')
                ->join('users', 'user_roles.user_id', '=', 'users.id')
                ->select('user_roles.q_m_s_processes_id', 'users.id', 'users.role', 'users.name') // Include all selected columns in the select statement
                ->where('user_roles.q_m_s_processes_id', $process->id)
                ->where('user_roles.q_m_s_roles_id', 40)
                ->groupBy('user_roles.q_m_s_processes_id', 'users.id', 'users.role', 'users.name') // Include all selected columns in the group by clause
                ->get();

            $qa = DB::table('user_roles')
                ->join('users', 'user_roles.user_id', '=', 'users.id')
                ->select('user_roles.q_m_s_processes_id', 'users.id', 'users.role', 'users.name') // Include all selected columns in the select statement
                ->where('user_roles.q_m_s_processes_id', $process->id)
                ->where('user_roles.q_m_s_roles_id', 7)
                ->groupBy('user_roles.q_m_s_processes_id', 'users.id', 'users.role', 'users.name') // Include all selected columns in the group by clause
                ->get();

            $trainer = User::get();

            $reviewergroup = \App\Models\Grouppermission::where('role_id', 2)->get();
            $approversgroup = \App\Models\Grouppermission::where('role_id', 1)->get();

            $cc->originator = User::where('id', $cc->initiator_id)->value('name');
            $users = User::all();   
            $documentLanguages = DocumentLanguage::all();
            $trainer = User::get();
            return view('frontend.documents.create', 
            compact('parent_name','hods','approvers','reviewer', 'ccId','users','trainer','documentLanguages', 'parent_type', 'parent_id', 'record_number', 'parent_short_description', 'parent_initiator_id', 'parent_intiation_date', 'parent_division_id', 'parent_record', 'cc', 'ccrecord', 'drafter', 'qa', 'approversgroup', 'reviewergroup', 'trainer'));
        }
        

        if ($request->revision == "Effective-Check") {
            $cc->originator = User::where('id', $cc->initiator_id)->value('name');
            return view('frontend.forms.effectiveness-check', compact('parent_record','parent_type','parent_id', 'parent_name', 'record_number', 'cc', 'parent_data', 'parent_data1', 'parent_short_description', 'parent_initiator_id', 'parent_intiation_date', 'parent_division_id', 'due_date', 'old_record',));
        }
        else{
            toastr()->warning('Not Working');
            return back();
        }
    }

    public function auditTrial($id)
    {
        $audit = GlobalChangeControlAuditTrail::where('cc_id', $id)->orderByDESC('id')->paginate(5);
        $today = Carbon::now()->format('d-m-y');
        $document = GlobalChangeControl::where('id', $id)->first();
        $document->originator = User::where('id', $document->initiator_id)->value('name');
        $users = User::all();
        return view('frontend.global-cc.auditTrail', compact('audit', 'document', 'today','users'));
    }

    public function audit_trail_filter(Request $request,$id)
                {
                   $query= GlobalChangeControlAuditTrail::query();
                             $query->where('cc_id',$id);

                     if($request->filled('typedata'))
                     {  
                        switch($request->typedata)
                        {
                            case 'cft_review':

                                $cft_field= ['CFT Review Complete'];
                                $query->where('action',$cft_field);
                                break;

                             case 'stage':

                                $stage = ['Submit By, Submit On','HOD Assessment Complete By,
                                 HOD Assessment Complete On','QA/CQA Initial Assessment Complete By, QA/CQA Initial Assessment Complete On','CFT Assessment Complete By','RA Approval By, RA Approval On','RA Approval Complete By, RA Approval Complete On','Rejected By, Rejected On','QA/CQA Final Review Complete By, QA/CQA Final Review Complete On','QA/CQA Head/Manager Designee Approval By, QA/CQA Head/Manager Designee ApprovalOn','Initiator Updated Complete By, Initiator Updated Complete On','HOD Final Review Complete By, HOD Final Review Complete On', 'Implementation verification by QA/CQA Complete By, Implementation verification by QA/CQA Complete On','QA/CQA Head/Manager Designee Approval By, QA/CQA Head/Manager Designee Approval On','Pending Initiator Update By, Pending Initiator Update On','Approved By, Approved On','HOD Final Review Complete By, HOD Final Review Complete On','Implementation verification by QA/CQA By, Implementation verification by CQA/QA On','QA/CQA Closure Approval By, Closure Approval On','More Info Required By, More Info Required On'];




                                  
                                $query->whereIn('activity_type',$stage);
                                break;
                                
                                case 'user_action':
                                    $user_action = [
                                        'Submit', 'HOD Assessment Complete', 'QA/CQA Initial Assessment Complete','CFT Assessment Complete', 'RA Approval Required','RA Approval Complete', 'Approved','QA/CQA Final Review Complete','HOD Final Review Complete','Initiator Updated Complete','Rejected', 'Send For Final QA/CQA Head Approval','Send For Final Approval','Closure Approved','More Info Required','Send To Initiator','Send To HOD','Send To QA/CQA Initial','Initiator Updated Completed', 'More Info Required','More Info Required','Cancel','More Info Required','Cancel','Rejected'
                                    ];
                                $query->whereIn('action',$user_action);     
                                break;



                                case 'notification':
                                    $notification = [ 'user notification'
                                        
                                    ];
                                $query->where('action',$notification);     
                                break;



                                case 'business':
                                    $business = [ 'business'
                                        
                                    ];
                                $query->where('action',$business);     
                                break;
                              default;
                              break;  
                        }
                         
                     }        
                     if ($request->filled('user')) {
                        $query->where('user_id', $request->user);
                    }
                
                    if ($request->filled('from_date')) {
                        $query->whereDate('created_at', '>=', $request->from_date);
                    }
                
                    if ($request->filled('to_date')) {
                        $query->whereDate('created_at', '<=', $request->to_date);
                    }
                
                    $audit = $query->orderByDesc('id')->get();
                
                    $filter_request = true;
                    
                    $responseHtml = view('frontend.rcms.CC.CC_filter', compact('audit', 'filter_request'))->render();
                
                 return response()->json(['html' => $responseHtml]);



                }

    public function auditDetails($id)
    {
        $detail = GlobalChangeControlAuditTrail::find($id);
        $detail_data = GlobalChangeControlAuditTrail::where('activity_type', $detail->activity_type)->where('cc_id', $detail->cc_id)->latest()->get();
        $doc = GlobalChangeControl::where('id', $detail->cc_id)->first();
        $doc->origiator_name = User::find($doc->initiator_id);
        return view('frontend.globa-cc.audit-trail-inner', compact('detail', 'doc', 'detail_data'));
    }

    public function summery_pdf($id)
    {
        $data = GlobalChangeControl::find($id);
        if (!empty($data)) {
            $data->originator = User::where('id', $data->initiator_id)->value('name');
        } else {
            $datas = ActionItem::find($id);

            if (empty($datas)) {
                $datas = Extension::find($id);
                $data = GlobalChangeControl::find($datas->cc_id);
                $data->originator = User::where('id', $data->initiator_id)->value('name');
                $data->created_at = $datas->created_at;
            } else {
                $data = GlobalChangeControl::find($datas->cc_id);
                $data->originator = User::where('id', $data->initiator_id)->value('name');
                $data->created_at = $datas->created_at;
            }
        }

        // pdf related work
        $pdf = App::make('dompdf.wrapper');
        $time = Carbon::now();
        $pdf = PDF::loadview('frontend.change-control.summary_pdf', compact('data', 'time'))
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
            $data->status,
            null,
            60,
            [0, 0, 0],
            2,
            6,
            -20
        );

        if ($data->documents) {

            $pdfArray = explode(',', $data->documents);
            foreach ($pdfArray as $pdfFile) {
                $existingPdfPath = public_path('upload/PDF/' . $pdfFile);
                $permissions = 0644; // Example permission value, change it according to your needs
                if (file_exists($existingPdfPath)) {
                    // Create a new Dompdf instance
                    $options = new Options();
                    $options->set('chroot', public_path());
                    $options->set('isPhpEnabled', true);
                    $options->set('isRemoteEnabled', true);
                    $options->set('isHtml5ParserEnabled', true);
                    $options->set('allowedFileExtensions', ['pdf']); // Allow PDF file extension

                    $dompdf = new Dompdf($options);

                    chmod($existingPdfPath, $permissions);

                    // Load the existing PDF file
                    $dompdf->loadHtmlFile($existingPdfPath);

                    // Render the PDF
                    $dompdf->render();

                    // Output the PDF to the browser
                    $dompdf->stream();
                }
            }
        }

        return $pdf->stream('SOP' . $id . '.pdf');
    }

    public function audit_pdf($id)
    {
        $doc = GlobalChangeControl::find($id);
        if (!empty($doc)) {
            $doc->originator = User::where('id', $doc->initiator_id)->value('name');
        } else {
            $datas = ActionItem::find($id);

            if (empty($datas)) {
                $datas = Extension::find($id);
                $doc = GlobalChangeControl::find($datas->cc_id);
                $doc->originator = User::where('id', $doc->initiator_id)->value('name');
                $doc->created_at = $datas->created_at;
            } else {
                $doc = GlobalChangeControl::find($datas->cc_id);
                $doc->originator = User::where('id', $doc->initiator_id)->value('name');
                $doc->created_at = $datas->created_at;
            }
        }
        $data = GlobalChangeControlAuditTrail::where('cc_id', $doc->id)->orderByDesc('id')->get();
        $pdf = App::make('dompdf.wrapper');
        $time = Carbon::now();
       
        $pdf = PDF::loadview('frontend.global-cc.auditReport', compact('data', 'doc'))
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

    public function ccView($id)
    {

        $data = GlobalChangeControl::find($id);
        if (empty($data)) {
            $data = ActionItem::find($id);
            if (empty($data)) {
                $data = Extension::find($id);
            }
        }
        $html = '';
        $html = '<div class="block">
        <div class="record_no">
            Record No. ' . str_pad($data->record, 4, '0', STR_PAD_LEFT) .
            '</div>
        <div class="short_desc">' .
            $data->short_description . '
        </div>
        <div class="division">
            QMS - EMEA / Change Control
        </div>
        <div class="status">' .
            $data->status . '
        </div>
            </div>
            <div class="block">
                <div class="block-head">
                    Actions
                </div>
                <div class="block-list">
                    <a href="/rcms/audit/' . $data->id . '" class="list-item">View History</a>
                    <a href="send-notification" class="list-item">Send Notification</a>
                    <div class="list-drop">
                        <div class="list-item" onclick="showAction()">
                            <div>Run Report</div>
                            <div><i class="fa-solid fa-angle-down"></i></div>
                        </div>
                        <div class="drop-list">
                            <a target="_blank" href="summary/' . $data->id . '" class="inner-item">Change Control Summary</a>
                            <a target="_blank" href="/rcms/audit/' . $data->id . '" class="inner-item">Audit Trail</a>
                            <a target="_blank" href="/rcms/change_control_single_pdf/' . $data->id . '" class="inner-item">Change Control Single Report</a>
                            <a target="_blank" href="/rcms/change_control_family_pdf" class="inner-item">Change Control Parent with Immediate Child</a>
                        </div>
                    </div>
                </div>
            </div>';
        $response['html'] = $html;

        return response()->json($response);
    }

    public function single_pdf($id)
    { 
        $data = GlobalChangeControl::find($id);
        $cftData =  GlobalChangeControlCft::where('cc_id', $id)->first();
        $cc_cfts =  GlobalChangeControlCft::where('cc_id', $id)->first();
        if (!empty($data)) {
            $data->originator = User::where('id', $data->initiator_id)->value('name');

            $pdf = App::make('dompdf.wrapper');
            $time = Carbon::now();
            $pdf = PDF::loadview('frontend.global-cc.singleReport', compact(
                'data',
                'cftData',
                'cc_cfts',
            ))
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
                $width / 4,
                $height / 2,
                $data->status,
                null,
                25,
                [0, 0, 0],
                2,
                6,
                -20
            );


            $directoryPath = public_path("user/pdf/reg/");
            $filePath = $directoryPath . '/reg' . $id . '.pdf';

            if (!File::isDirectory($directoryPath)) {
                File::makeDirectory($directoryPath, 0755, true, true); // Recursive creation with read/write permissions
            }  

            $pdf->save($filePath);

            return $pdf->stream('SOP' . $id . '.pdf');
        }
    }


    public function singleReportShow($id)
    {
        $data = GlobalChangeControl::find($id);
        return view('frontend.global-cc.global-cc-singlePdf-show', compact('id', 'data'));
    }

    public function familyReport($id)
    {
        $data = GlobalChangeControl::find($id);
        $cftData =  GlobalChangeControlCft::where('cc_id', $id)->first();
        $cc_cfts =  GlobalChangeControlCft::where('cc_id', $id)->first();
        if (!empty($data)) {
            $data->originator = User::where('id', $data->initiator_id)->value('name');

            $Extension = extension_new::where('parent_id', $id)->get();
            $RCA = RootCauseAnalysis::where('parent_id', $id)->get();
            $ActionItem =  ActionItem::where('parent_id', $id)->get();
            $CAPA =  Capa::where('parent_id', $id)->get();
            $EffectivenessCheck =  EffectivenessCheck::where('parent_id', $id)->get();
     
            $pdf = App::make('dompdf.wrapper');
            $time = Carbon::now();
            $pdf = PDF::loadview('frontend.global-cc.global-cc-family-report', compact(
                'data',
                'cftData',
                'cc_cfts',
                'Extension',
                'RCA',
                'ActionItem',
                'CAPA',
                'EffectivenessCheck',
                'fields'
            ))
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
                $width / 4,
                $height / 2,
                $data->status,
                null,
                25,
                [0, 0, 0],
                2,
                6,
                -20
            );
            return $pdf->stream('SOP' . $id . '.pdf');
        }
    }


    public function parent_child()
    {
        $pdf = App::make('dompdf.wrapper');
        $time = Carbon::now();
        $pdf = PDF::loadview('frontend.change-control.change_control_family_pdf')
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
            $width / 4,
            $height / 2,
            "Opened",
            null,
            25,
            [0, 0, 0],
            2,
            6,
            -20
        );



        return $pdf->stream('SOP.pdf');
    }

    public function eCheck($id)
    {
        $data = GlobalChangeControl::find($id);
        return view('frontend.effectivenessCheck.create', compact('data'));
    }

    public function ImpactUpdate($id)
    {
    }

    public function changeControlEffectivenessCheck(Request $request, $id)
    {
        $cc = GlobalChangeControl::find($id);
        $parent_id = $id;
        $parent_name = "GlobalCC";
        $parent_type = "GlobalCC";

        $parent_record = GlobalChangeControl::where('id', $id)->value('record');
        $parent_record = str_pad($parent_record, 4, '0', STR_PAD_LEFT);

        $record_number = ((RecordNumber::first()->value('counter')) + 1);
        $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
        $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $due_date = $formattedDate->format('d-M-Y');

        return view("frontend.forms.effectiveness-check", compact('due_date','parent_record','parent_id','parent_type', 'parent_name', 'record_number'));
    }



    public function exportCsv(Request $request)
    {
        $query = GlobalChangeControl::query();
    
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
    
        $fileName = 'change_control_log.csv';
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
    
    


    public function exportExcel(Request $request)
    {
        $query = GlobalChangeControl::query();
    
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
    
        $fileName = "change_control_log.xls";
    
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
