<?php

namespace App\Http\Controllers\rcms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\RecordNumber;
use App\Models\QueryManagement;
use App\Models\User;
use App\Models\QueryManagementAuditTrail;
use App\Models\QueryManagementCft;
use App\Models\QueryManagementCftResponse;

use App\Models\NotificationUser;
use App\Models\RoleGroup;

use PDF;
use Helpers;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class QueryManagementController extends Controller
{
    public function create(){
        $record_number = ((RecordNumber::first()->value('counter')) + 1);
        $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
        $preItem = QueryManagement::all();
        $users = User::all();
        return view('frontend.query-management.query_management', compact('record_number','preItem'));
    }

    public function store(Request $request){
        $data = new QueryManagement();
        $data->parent_id = $request->parent_id;
        $data->form_type = "Query Management";
        $data->parent_type = $request->parent_type;
        $data->record = DB::table('record_numbers')->value('counter') + 1;
        $data->division_id = $request->division_id;
        $data->initiator_id = Auth::user()->id;
        $data->initiation_date = $request->initiation_date;
        $data->due_date = $request->due_date;
        $data->short_description = $request->short_description;
        $data->reference_document = implode(',',$request->reference_document);
        $data->query_volume = $request->query_volume;
        $data->query_medium = $request->query_medium;

        if (!empty($request->mail_attachment)) {
            $files = [];
            if ($request->hasfile('mail_attachment')) {
                foreach ($request->file('mail_attachment') as $file) {
                    $name = 'QM-' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $data->mail_attachment = json_encode($files);
        }

        $data->assign_to = $request->assign_to;
        $data->contact_mailId = $request->contact_mailId;
        $data->contact_mobile = $request->contact_mobile;
        $data->affiliation = $request->affiliation;
        if (!empty($request->initial_attachment)) {
            $files = [];
            if ($request->hasfile('initial_attachment')) {
                foreach ($request->file('initial_attachment') as $file) {
                    $name = 'QM-' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $data->initial_attachment = json_encode($files);
        }

        /****** Admin 1******/
        $data->reviewer_comment = $request->reviewer_comment;
        if (!empty($request->reviewer_attachment)) {
            $files = [];
            if ($request->hasfile('reviewer_attachment')) {
                foreach ($request->file('reviewer_attachment') as $file) {
                    $name = 'QM-' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $data->reviewer_attachment = json_encode($files);
        }

        /****** Admin 2******/
        $data->admin1_comment = $request->admin1_comment;
        if (!empty($request->admin1_attachment)) {
            $files = [];
            if ($request->hasfile('admin1_attachment')) {
                foreach ($request->file('admin1_attachment') as $file) {
                    $name = 'QM-' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $data->admin1_attachment = json_encode($files);
        }

        /****** HOD ******/
        $data->HOD_comment = $request->HOD_comment;
        if (!empty($request->HOD_attachment)) {
            $files = [];
            if ($request->hasfile('HOD_attachment')) {
                foreach ($request->file('HOD_attachment') as $file) {
                    $name = 'QM-' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $data->HOD_attachment = json_encode($files);
        }

        /****** Outcome ******/
        $data->resolution_status = $request->resolution_status;
        $data->category_tags = implode(',',$request->category_tags);
        $data->response_details = $request->response_details;
        $data->followup_action = $request->followup_action;
        if (!empty($request->supporting_doc)) {
            $files = [];
            if ($request->hasfile('supporting_doc')) {
                foreach ($request->file('supporting_doc') as $file) {
                    $name = 'QM-' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $data->supporting_doc = json_encode($files);
        }
        $data->stage = 1;
        $data->status = "Opened";

        $record = RecordNumber::first();
        $record->counter = ((RecordNumber::first()->value('counter')) + 1);
        $record->update();

        $data->save();

        // $userNotification = new NotificationUser();
        // $userNotification->record_id = $data->id;
        // $userNotification->record_type = "Query Management";
        // $userNotification->to_id = Auth::user()->id;
        // $userNotification->save();

        /* CFT Data Feilds Start */

        $Cft = new QueryManagementCft();
        $Cft->query_management_id = $data->id;
        $Cft->RA_Review = $request->RA_Review;
        $Cft->RA_Comments = $request->RA_Comments;
        $Cft->RA_person = $request->RA_person;
        $Cft->RA_assessment = $request->RA_assessment;
        $Cft->RA_feedback = $request->RA_feedback;
        $Cft->RA_attachment = $request->RA_attachment;
        $Cft->RA_by = $request->RA_by;
        $Cft->RA_on = $request->RA_on;

        $Cft->Production_Table_Review = $request->Production_Table_Review;
        $Cft->Production_Table_Person = $request->Production_Table_Person;
        $Cft->Production_Table_Assessment = $request->Production_Table_Assessment;
        $Cft->Production_Table_Feedback = $request->Production_Table_Feedback;
        $Cft->Production_Table_Attachment = $request->Production_Table_Attachment;
        $Cft->Production_Table_By = $request->Production_Table_By;
        $Cft->Production_Table_On = $request->Production_Table_On;

        $Cft->Production_Injection_Review = $request->Production_Injection_Review;
        $Cft->Production_Injection_Person = $request->Production_Injection_Person;
        $Cft->Production_Injection_Assessment = $request->Production_Injection_Assessment;
        $Cft->Production_Injection_Feedback = $request->Production_Injection_Feedback;
        $Cft->Production_Injection_Attachment = $request->Production_Injection_Attachment;
        $Cft->Production_Injection_By = $request->Production_Injection_By;
        $Cft->Production_Injection_On = $request->Production_Injection_On;

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

        $Cft->Environment_Health_review = $request->Environment_Health_review;
        $Cft->Environment_Health_Safety_person = $request->Environment_Health_Safety_person;
        $Cft->Health_Safety_assessment = $request->Health_Safety_assessment;
        $Cft->Health_Safety_feedback = $request->Health_Safety_feedback;
        $Cft->Environment_Health_Safety_by = $request->Environment_Health_Safety_by;
        $Cft->Environment_Health_Safety_on = $request->Environment_Health_Safety_on;

        $Cft->Human_Resource_review = $request->Human_Resource_review;
        $Cft->Human_Resource_person = $request->Human_Resource_person;
        $Cft->Human_Resource_assessment = $request->Human_Resource_assessment;
        $Cft->Human_Resource_feedback = $request->Human_Resource_feedback;
        $Cft->Human_Resource_by = $request->Human_Resource_by;
        $Cft->Human_Resource_on = $request->Human_Resource_on;

        $Cft->Information_Technology_review = $request->Information_Technology_review;
        $Cft->Information_Technology_person = $request->Information_Technology_person;
        $Cft->Information_Technology_assessment = $request->Information_Technology_assessment;
        $Cft->Information_Technology_feedback = $request->Information_Technology_feedback;
        $Cft->Information_Technology_by = $request->Information_Technology_by;
        $Cft->Information_Technology_on = $request->Information_Technology_on;

        $Cft->ProductionLiquid_Review = $request->ProductionLiquid_Review;
        $Cft->ProductionLiquid_person = $request->ProductionLiquid_person;
        $Cft->ProductionLiquid_assessment = $request->ProductionLiquid_assessment;
        $Cft->ProductionLiquid_feedback = $request->ProductionLiquid_feedback;
        $Cft->ProductionLiquid_by = $request->ProductionLiquid_by;
        $Cft->ProductionLiquid_on = $request->ProductionLiquid_on;

        $Cft->Store_Review = $request->Store_Review;
        $Cft->Store_person = $request->Store_person;
        $Cft->Store_assessment = $request->Store_assessment;
        $Cft->Store_feedback = $request->Store_feedback;
        $Cft->Store_by = $request->Store_by;
        $Cft->Store_on = $request->Store_on;

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

        $Cft->CorporateQualityAssurance_Review = $request->CorporateQualityAssurance_Review;
        $Cft->CorporateQualityAssurance_person = $request->CorporateQualityAssurance_person;
        $Cft->CorporateQualityAssurance_assessment = $request->CorporateQualityAssurance_assessment;
        $Cft->CorporateQualityAssurance_feedback = $request->CorporateQualityAssurance_feedback;
        $Cft->CorporateQualityAssurance_by = $request->CorporateQualityAssurance_by;
        $Cft->CorporateQualityAssurance_on = $request->CorporateQualityAssurance_on;

        $Cft->ContractGiver_Review = $request->ContractGiver_Review;
        $Cft->ContractGiver_person = $request->ContractGiver_person;
        $Cft->ContractGiver_assessment = $request->ContractGiver_assessment;
        $Cft->ContractGiver_feedback = $request->ContractGiver_feedback;
        $Cft->ContractGiver_by = $request->ContractGiver_by;
        $Cft->ContractGiver_on = $request->ContractGiver_on;

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

        /******* Audit Trail Code *******/
        $history = new QueryManagementAuditTrail;
        $history->query_management_id = $data->id;
        $history->activity_type = 'Division Code';
        $history->previous = "Null";
        $history->current = Helpers::getDivisionName($request->division_id);
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $data->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();

        $history = new QueryManagementAuditTrail;
        $history->query_management_id = $data->id;
        $history->activity_type = 'Submitter Name';
        $history->previous = "Null";
        $history->current = Auth::user()->name;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $data->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();

        $history = new QueryManagementAuditTrail;
        $history->query_management_id = $data->id;
        $history->activity_type = 'Submission Date';
        $history->previous = "Null";
        $history->current = Helpers::getdateFormat($data->intiation_date);
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $data->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();

        $history = new QueryManagementAuditTrail;
        $history->query_management_id = $data->id;
        $history->activity_type = 'Due Date ';
        $history->previous = "Null";
        $history->current = Helpers::getdateFormat($data->due_date);
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $data->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();

        $history = new QueryManagementAuditTrail;
        $history->query_management_id = $data->id;
        $history->activity_type = 'Short Description';
        $history->previous = "Null";
        $history->current = $request->short_description;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $data->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();

        if(!empty($request->due_date)){
            $history = new QueryManagementAuditTrail;
            $history->query_management_id = $data->id;
            $history->activity_type = 'Due Date';
            $history->previous = "Null";
            $history->current = Helpers::getdateFormat($request->due_date);
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $data->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->save();
        }

        if(!empty($data->reference_document)){
            $history = new QueryManagementAuditTrail;
            $history->query_management_id = $data->id;
            $history->activity_type = 'Reference Document';
            $history->previous = "Null";
            $history->current = $data->reference_document;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $data->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->save();
        }

        if(!empty($request->query_volume)){
            $history = new QueryManagementAuditTrail;
            $history->query_management_id = $data->id;
            $history->activity_type = 'Volume';
            $history->previous = "Null";
            $history->current = $request->query_volume;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $data->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->save();
        }

        if(!empty($request->query_medium)){
            $history = new QueryManagementAuditTrail;
            $history->query_management_id = $data->id;
            $history->activity_type = 'Query Medium';
            $history->previous = "Null";
            $history->current = $request->query_medium;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $data->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->save();
        }

        if(!empty($request->mail_attachment)){
            $history = new QueryManagementAuditTrail;
            $history->query_management_id = $data->id;
            $history->activity_type = 'Mail Attachment';
            $history->previous = "Null";
            $history->current = $data->mail_attachment;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $data->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->save();
        }

        if(!empty($request->assign_to)){
            $history = new QueryManagementAuditTrail;
            $history->query_management_id = $data->id;
            $history->activity_type = 'Assigned Reviewer';
            $history->previous = "Null";
            $history->current = Helpers::getInitiatorName($request->assign_to);
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $data->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->save();
        }

        if(!empty($request->contact_mailId)){
            $history = new QueryManagementAuditTrail;
            $history->query_management_id = $data->id;
            $history->activity_type = 'Contact Person Mail ID';
            $history->previous = "Null";
            $history->current = $request->contact_mailId;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $data->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->save();
        }

        if(!empty($request->contact_mobile)){
            $history = new QueryManagementAuditTrail;
            $history->query_management_id = $data->id;
            $history->activity_type = 'Contact Person Phone No.';
            $history->previous = "Null";
            $history->current = $request->contact_mobile;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $data->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->save();
        }

        if(!empty($request->affiliation)){
            $history = new QueryManagementAuditTrail;
            $history->query_management_id = $data->id;
            $history->activity_type = 'Affiliation';
            $history->previous = "Null";
            $history->current = $request->affiliation;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $data->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->save();
        }

        if(!empty($request->initial_attachment)){
            $history = new QueryManagementAuditTrail;
            $history->query_management_id = $data->id;
            $history->activity_type = 'Initial Attachment';
            $history->previous = "Null";
            $history->current = $data->initial_attachment;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $data->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->save();
        }

        if(!empty($request->reviewer_comment)){
            $history = new QueryManagementAuditTrail;
            $history->query_management_id = $data->id;
            $history->activity_type = 'Admin 1 Comments';
            $history->previous = "Null";
            $history->current = $request->reviewer_comment;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $data->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->save();
        }

        if(!empty($request->reviewer_attachment)){
            $history = new QueryManagementAuditTrail;
            $history->query_management_id = $data->id;
            $history->activity_type = 'Admin 1 Attachments';
            $history->previous = "Null";
            $history->current = $data->reviewer_attachment;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $data->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->save();
        }

        if(!empty($request->admin1_comment)){
            $history = new QueryManagementAuditTrail;
            $history->query_management_id = $data->id;
            $history->activity_type = 'Admin 2 Comments';
            $history->previous = "Null";
            $history->current = $request->admin1_comment;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $data->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->save();
        }

        if(!empty($request->admin1_attachment)){
            $history = new QueryManagementAuditTrail;
            $history->query_management_id = $data->id;
            $history->activity_type = 'Admin 2 Attachments';
            $history->previous = "Null";
            $history->current = $data->admin1_attachment;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $data->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->save();
        }

        if(!empty($request->HOD_comment)){
            $history = new QueryManagementAuditTrail;
            $history->query_management_id = $data->id;
            $history->activity_type = 'HOD Comments';
            $history->previous = "Null";
            $history->current = $request->HOD_comment;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $data->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->save();
        }

        if(!empty($request->HOD_attachment)){
            $history = new QueryManagementAuditTrail;
            $history->query_management_id = $data->id;
            $history->activity_type = 'HOD Attachments';
            $history->previous = "Null";
            $history->current = $data->HOD_attachment;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $data->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->save();
        }

        if(!empty($request->resolution_status)){
            $history = new QueryManagementAuditTrail;
            $history->query_management_id = $data->id;
            $history->activity_type = 'Resolution Status';
            $history->previous = "Null";
            $history->current = $request->resolution_status;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $data->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->save();
        }

        if(!empty($request->category_tags)){
            $history = new QueryManagementAuditTrail;
            $history->query_management_id = $data->id;
            $history->activity_type = 'Category Tags';
            $history->previous = "Null";
            $history->current = $data->category_tags;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $data->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->save();
        }

        if(!empty($request->response_details)){
            $history = new QueryManagementAuditTrail;
            $history->query_management_id = $data->id;
            $history->activity_type = 'Response Details';
            $history->previous = "Null";
            $history->current = $request->response_details;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $data->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->save();
        }

        if(!empty($request->followup_action)){
            $history = new QueryManagementAuditTrail;
            $history->query_management_id = $data->id;
            $history->activity_type = 'Follow-up Actions';
            $history->previous = "Null";
            $history->current = $request->followup_action;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $data->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->save();
        }

        if(!empty($request->supporting_doc)){
            $history = new QueryManagementAuditTrail;
            $history->query_management_id = $data->id;
            $history->activity_type = 'Supporting Documents';
            $history->previous = "Null";
            $history->current = $data->supporting_doc;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $data->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->save();
        }

        

        toastr()->success("Record is created Successfully");
        return redirect(url('rcms/qms-dashboard'));
    }

    public function edit($id){
        $data = QueryManagement::find($id);
        $preItem = QueryManagement::all();
        return view('frontend.query-management.query_management_view', compact('data','preItem'));
    }

    public function update(Request $request, $id){
        $data = QueryManagement::find($id);
        $lastDocument = QueryManagement::find($id);        
        $lastDocCft = QueryManagementCft::where('query_management_id', $id)->first();

        $data->due_date = $request->due_date;
        $data->short_description = $request->short_description;
        $data->reference_document = implode(',',$request->reference_document);
        $data->query_volume = $request->query_volume;
        $data->query_medium = $request->query_medium;

        if (!empty($request->mail_attachment)) {
            $files = [];
            if ($request->hasfile('mail_attachment')) {
                foreach ($request->file('mail_attachment') as $file) {
                    $name = 'QM-' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $data->mail_attachment = json_encode($files);
        }

        $data->assign_to = $request->assign_to;
        $data->contact_mailId = $request->contact_mailId;
        $data->contact_mobile = $request->contact_mobile;
        $data->affiliation = $request->affiliation;
        if (!empty($request->initial_attachment)) {
            $files = [];
            if ($request->hasfile('initial_attachment')) {
                foreach ($request->file('initial_attachment') as $file) {
                    $name = 'QM-' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $data->initial_attachment = json_encode($files);
        }

        /****** Admin 1******/
        $data->reviewer_comment = $request->reviewer_comment;
        if (!empty($request->reviewer_attachment)) {
            $files = [];
            if ($request->hasfile('reviewer_attachment')) {
                foreach ($request->file('reviewer_attachment') as $file) {
                    $name = 'QM-' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $data->reviewer_attachment = json_encode($files);
        }

        /****** Admin 2******/
        $data->admin1_comment = $request->admin1_comment;
        if (!empty($request->admin1_attachment)) {
            $files = [];
            if ($request->hasfile('admin1_attachment')) {
                foreach ($request->file('admin1_attachment') as $file) {
                    $name = 'QM-' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $data->admin1_attachment = json_encode($files);
        }

        /****** HOD ******/
        $data->HOD_comment = $request->HOD_comment;
        if (!empty($request->HOD_attachment)) {
            $files = [];
            if ($request->hasfile('HOD_attachment')) {
                foreach ($request->file('HOD_attachment') as $file) {
                    $name = 'QM-' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $data->HOD_attachment = json_encode($files);
        }

        /****** Outcome ******/
        $data->resolution_status = $request->resolution_status;
        $data->category_tags = implode(',',$request->category_tags);
        $data->response_details = $request->response_details;
        $data->followup_action = $request->followup_action;
        if (!empty($request->supporting_doc)) {
            $files = [];
            if ($request->hasfile('supporting_doc')) {
                foreach ($request->file('supporting_doc') as $file) {
                    $name = 'QM-' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $data->supporting_doc = json_encode($files);
        }
        $data->update();

        /****** CFT Code starts ******/
        if ($data->stage == 5 || $data->stage == 6 ){

            $Cft = QueryManagementCft::where('query_management_id', $id)->first();
            if($Cft && $data->stage == 6 ){
                // $Cft->RA_Review = $request->RA_Review == null ? $Cft->RA_Review : $request->RA_Review;
                // $Cft->RA_person = $request->RA_person == null ? $Cft->RA_person : $request->RA_person;

                $Cft->Production_Injection_Person = $request->Production_Injection_Person == null ? $Cft->Production_Injection_Person : $request->Production_Injection_Person;
                $Cft->Production_Injection_Review = $request->Production_Injection_Review == null ? $Cft->Production_Injection_Review : $request->Production_Injection_Review;

                $Cft->Production_Table_Person = $request->Production_Table_Person == null ? $Cft->Production_Table_Person : $request->Production_Table_Person;
                $Cft->Production_Table_Review = $request->Production_Table_Review == null ? $Cft->Production_Table_Review : $request->Production_Table_Review;

                $Cft->Production_Injection_Person = $request->Production_Injection_Person == null ? $Cft->Production_Injection_Person : $request->Production_Injection_Person;
                $Cft->Production_Injection_Review = $request->Production_Injection_Review == null ? $Cft->Production_Injection_Review : $request->Production_Injection_Review;

                $Cft->ProductionLiquid_Review = $request->ProductionLiquid_Review == null ? $Cft->ProductionLiquid_Review : $request->ProductionLiquid_Review;
                $Cft->ProductionLiquid_person = $request->ProductionLiquid_person == null ? $Cft->ProductionLiquid_person : $request->ProductionLiquid_person;

                $Cft->Store_person = $request->Store_person == null ? $Cft->Store_person : $request->Store_person;
                $Cft->Store_Review = $request->Store_Review == null ? $Cft->Store_Review : $request->Store_Review;

                $Cft->ResearchDevelopment_person = $request->ResearchDevelopment_person == null ? $Cft->ResearchDevelopment_person : $request->ResearchDevelopment_person;
                $Cft->ResearchDevelopment_Review = $request->ResearchDevelopment_Review == null ? $Cft->ResearchDevelopment_Review : $request->ResearchDevelopment_Review;

                $Cft->Microbiology_person = $request->Microbiology_person == null ? $Cft->Microbiology_person : $request->Microbiology_person;
                $Cft->Microbiology_Review = $request->Microbiology_Review == null ? $Cft->Microbiology_Review : $request->Microbiology_Review;

                $Cft->RegulatoryAffair_person = $request->RegulatoryAffair_person == null ? $Cft->RegulatoryAffair_person : $request->RegulatoryAffair_person;
                $Cft->RegulatoryAffair_Review = $request->RegulatoryAffair_Review == null ? $Cft->RegulatoryAffair_Review : $request->RegulatoryAffair_Review;

                $Cft->CorporateQualityAssurance_person = $request->CorporateQualityAssurance_person == null ? $Cft->CorporateQualityAssurance_person : $request->CorporateQualityAssurance_person;
                $Cft->CorporateQualityAssurance_Review = $request->CorporateQualityAssurance_Review == null ? $Cft->CorporateQualityAssurance_Review : $request->CorporateQualityAssurance_Review;

                $Cft->ContractGiver_person = $request->ContractGiver_person == null ? $Cft->ContractGiver_person : $request->ContractGiver_person;
                $Cft->ContractGiver_Review = $request->ContractGiver_Review == null ? $Cft->ContractGiver_Review : $request->ContractGiver_Review;

                $Cft->Quality_review = $request->Quality_review == null ? $Cft->Quality_review : $request->Quality_review;;
                $Cft->Quality_Control_Person = $request->Quality_Control_Person == null ? $Cft->Quality_Control_Person : $request->Quality_Control_Person;

                $Cft->Quality_Assurance_Review = $request->Quality_Assurance_Review == null ? $Cft->Quality_Assurance_Review : $request->Quality_Assurance_Review;
                $Cft->QualityAssurance_person = $request->QualityAssurance_person == null ? $Cft->QualityAssurance_person : $request->QualityAssurance_person;

                $Cft->Engineering_review = $request->Engineering_review == null ? $Cft->Engineering_review : $request->Engineering_review;
                $Cft->Engineering_person = $request->Engineering_person == null ? $Cft->Engineering_person : $request->Engineering_person;

                $Cft->Environment_Health_review = $request->Environment_Health_review == null ? $Cft->Environment_Health_review : $request->Environment_Health_review;
                $Cft->Environment_Health_Safety_person = $request->Environment_Health_Safety_person == null ? $Cft->Environment_Health_Safety_person : $request->Environment_Health_Safety_person;

                $Cft->Human_Resource_review = $request->Human_Resource_review == null ? $Cft->Human_Resource_review : $request->Human_Resource_review;
                $Cft->Human_Resource_person = $request->Human_Resource_person == null ? $Cft->Human_Resource_person : $request->Human_Resource_person;

                $Cft->Information_Technology_review = $request->Information_Technology_review == null ? $Cft->Information_Technology_review : $request->Information_Technology_review;
                $Cft->Information_Technology_person = $request->Information_Technology_person == null ? $Cft->Information_Technology_person : $request->Information_Technology_person;

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

                $Cft->Production_Table_Review = $request->Production_Table_Review;
                $Cft->Production_Table_Person = $request->Production_Table_Person;

                $Cft->Production_Injection_Review = $request->Production_Injection_Review;
                $Cft->Production_Injection_Person = $request->Production_Injection_Person;

                $Cft->ProductionLiquid_person = $request->ProductionLiquid_person;
                $Cft->ProductionLiquid_Review = $request->ProductionLiquid_Review;

                $Cft->Store_person = $request->Store_person;
                $Cft->Store_Review = $request->Store_Review;

                $Cft->ResearchDevelopment_person = $request->ResearchDevelopment_person;
                $Cft->ResearchDevelopment_Review = $request->ResearchDevelopment_Review;

                $Cft->Microbiology_person = $request->Microbiology_person;
                $Cft->Microbiology_Review = $request->Microbiology_Review;

                $Cft->RegulatoryAffair_person = $request->RegulatoryAffair_person;
                $Cft->RegulatoryAffair_Review = $request->RegulatoryAffair_Review;

                $Cft->CorporateQualityAssurance_person = $request->CorporateQualityAssurance_person;
                $Cft->CorporateQualityAssurance_Review = $request->CorporateQualityAssurance_Review;

                $Cft->ContractGiver_person = $request->ContractGiver_person;
                $Cft->ContractGiver_Review = $request->ContractGiver_Review;

                $Cft->Quality_review = $request->Quality_review;
                $Cft->Quality_Control_Person = $request->Quality_Control_Person;

                $Cft->Quality_Assurance_Review = $request->Quality_Assurance_Review;
                $Cft->QualityAssurance_person = $request->QualityAssurance_person;

                $Cft->Engineering_review = $request->Engineering_review;
                $Cft->Engineering_person = $request->Engineering_person;

                $Cft->Environment_Health_review = $request->Environment_Health_review;
                $Cft->Environment_Health_Safety_person = $request->Environment_Health_Safety_person;

                $Cft->Human_Resource_review = $request->Human_Resource_review;
                $Cft->Human_Resource_person = $request->Human_Resource_person;

                $Cft->Information_Technology_review = $request->Information_Technology_review;
                $Cft->Information_Technology_person = $request->Information_Technology_person;

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
            // $Cft->RA_assessment = $request->RA_assessment;
            // $Cft->RA_feedback = $request->RA_feedback;

            $Cft->Production_Injection_Assessment = $request->Production_Injection_Assessment;
            $Cft->Production_Injection_Feedback = $request->Production_Injection_Feedback;

            $Cft->Production_Table_Assessment = $request->Production_Table_Assessment;
            $Cft->Production_Table_Feedback = $request->Production_Table_Feedback;

            $Cft->ProductionLiquid_feedback = $request->ProductionLiquid_feedback;
            $Cft->ProductionLiquid_assessment = $request->ProductionLiquid_assessment;

            $Cft->Store_feedback = $request->Store_feedback;
            $Cft->Store_assessment = $request->Store_assessment;

            $Cft->ResearchDevelopment_feedback = $request->ResearchDevelopment_feedback;
            $Cft->ResearchDevelopment_assessment = $request->ResearchDevelopment_assessment;

            $Cft->Microbiology_feedback = $request->Microbiology_feedback;
            $Cft->Microbiology_assessment = $request->Microbiology_assessment;

            $Cft->RegulatoryAffair_feedback = $request->RegulatoryAffair_feedback;
            $Cft->RegulatoryAffair_assessment = $request->RegulatoryAffair_assessment;

            $Cft->CorporateQualityAssurance_feedback = $request->CorporateQualityAssurance_feedback;
            $Cft->CorporateQualityAssurance_assessment = $request->CorporateQualityAssurance_assessment;

            $Cft->ContractGiver_feedback = $request->ContractGiver_feedback;
            $Cft->ContractGiver_assessment = $request->ContractGiver_assessment;

            $Cft->Quality_Control_assessment = $request->Quality_Control_assessment;
            $Cft->Quality_Control_feedback = $request->Quality_Control_feedback;

            $Cft->QualityAssurance_assessment = $request->QualityAssurance_assessment;
            $Cft->QualityAssurance_feedback = $request->QualityAssurance_feedback;

            $Cft->Engineering_assessment = $request->Engineering_assessment;
            $Cft->Engineering_feedback = $request->Engineering_feedback;

            $Cft->Health_Safety_assessment = $request->Health_Safety_assessment;
            $Cft->Health_Safety_feedback = $request->Health_Safety_feedback;

            $Cft->Human_Resource_assessment = $request->Human_Resource_assessment;
            $Cft->Human_Resource_feedback = $request->Human_Resource_feedback;

            $Cft->Information_Technology_assessment = $request->Information_Technology_assessment;
            $Cft->Information_Technology_feedback = $request->Information_Technology_feedback;

            $Cft->Other1_assessment = $request->Other1_assessment;
            $Cft->Other1_feedback = $request->Other1_feedback;

            $Cft->Other2_Assessment = $request->Other2_Assessment;
            $Cft->Other2_feedback = $request->Other2_feedback;

            $Cft->Other3_Assessment = $request->Other3_Assessment;
            $Cft->Other3_feedback = $request->Other3_feedback;

            $Cft->Other4_Assessment = $request->Other4_Assessment;
            $Cft->Other4_feedback = $request->Other4_feedback;

            $Cft->Other5_Assessment = $request->Other5_Assessment;
            $Cft->Other5_feedback = $request->Other5_feedback;


            // if (!empty ($request->RA_attachment)) {
            //     $files = [];
            //     if ($request->hasfile('RA_attachment')) {
            //         foreach ($request->file('RA_attachment') as $file) {
            //             $name = $request->name . 'RA_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
            //             $file->move('upload/', $name);
            //             $files[] = $name;
            //         }
            //     }
            //     $Cft->RA_attachment = json_encode($files);
            // }
            // $areRaAttachSame = $lastDocCft->RA_attachment == $Cft->RA_attachment;

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
            $areQAAttachSame = $lastDocCft->Quality_Assurance_attachment == $Cft->Quality_Assurance_attachment;

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
            $arePTAttachSame = $lastDocCft->Production_Table_Attachment == $Cft->Production_Table_Attachment;

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
            $arePlAttachSame = $lastDocCft->ProductionLiquid_attachment == $Cft->ProductionLiquid_attachment;

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
            $arePiAttachSame = $lastDocCft->Production_Injection_Attachment == $Cft->Production_Injection_Attachment;

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
            $areStoreAttachSame = $lastDocCft->Store_attachment == $Cft->Store_attachment;

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
            $areQcAttachSame = $lastDocCft->Quality_Control_attachment == $Cft->Quality_Control_attachment;

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
            $areRdAttachSame = $lastDocCft->ResearchDevelopment_attachment == $Cft->ResearchDevelopment_attachment;

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
            $areEngAttachSame = $lastDocCft->Engineering_attachment == $Cft->Engineering_attachment;

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
            $areHrAttachSame = $lastDocCft->Human_Resource_attachment == $Cft->Human_Resource_attachment;

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
            $areMicroAttachSame = $lastDocCft->Microbiology_attachment == $Cft->Microbiology_attachment;

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
            $areRegAffairAttachSame = $lastDocCft->RegulatoryAffair_attachment == $Cft->RegulatoryAffair_attachment;

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
            $areCQAAttachSame = $lastDocCft->CorporateQualityAssurance_attachment == $Cft->CorporateQualityAssurance_attachment;

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
            $areSafetyAttachSame = $lastDocCft->Environment_Health_Safety_attachment == $Cft->Environment_Health_Safety_attachment;

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
            $areItAttachSame = $lastDocCft->Information_Technology_attachment == $Cft->Information_Technology_attachment;

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
            $areContractGiverAttachSame = $lastDocCft->ContractGiver_attachment == $Cft->ContractGiver_attachment;

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
            $areOther1AttachSame = $lastDocCft->Other1_attachment == $Cft->Other1_attachment;

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
            $areOther2AttachSame = $lastDocCft->Other2_attachment == $Cft->Other2_attachment;

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
            $areOther3AttachSame = $lastDocCft->Other3_attachment == $Cft->Other3_attachment;

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
            $areOther4AttachSame = $lastDocCft->Other4_attachment == $Cft->Other4_attachment;

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
            $areOther5AttachSame = $lastDocCft->Other5_attachment == $Cft->Other5_attachment;
            $Cft->save();

            $IsCFTRequired = QueryManagementCftResponse::withoutTrashed()->where(['is_required' => 1, 'query_management_id' => $id])->latest()->first();
            $cftUsers = DB::table('query_management_cfts')->where(['query_management_id' => $id])->first();

            $columns = ['QualityAssurance_person', 'Production_Table_Person', 'ProductionLiquid_person', 'Production_Injection_Person', 'Store_person', 'Quality_Control_Person', 'ResearchDevelopment_person', 'Engineering_person', 'Human_Resource_person', 'Microbiology_person', 'RegulatoryAffair_person', 'Environment_Health_Safety_person', 'Information_Technology_person', 'ContractGiver_person', 'Other1_person', 'Other2_person', 'Other3_person', 'Other4_person', 'Other5_person', 'CorporateQualityAssurance_person'];


            // Initialize an array to store the values
            $valuesArray = [];

            foreach ($columns as $index => $column) {
                $value = $cftUsers->$column;
                // Check if the value is not null and not equal to 0
                if ($value != null && $value != 0) {
                    $valuesArray[] = $value;
                }
            }
            // Remove duplicates from the array
            $valuesArray = array_unique($valuesArray);

            // Convert the array to a re-indexed array
            $valuesArray = array_values($valuesArray);

            // foreach ($valuesArray as $u) {
            //         $email = Helpers::getInitiatorEmail($u);
            //         if ($email !== null) {
            //             try {
            //                 Mail::send(
            //                     'mail.view-mail',
            //                     ['data' => $openState],
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

        /***** CFT Code Ends ******/


        if($lastDocument->short_description != $request->short_description){
            $lastDocumentAuditTrail = QueryManagementAuditTrail::where('query_management_id', $data->id)
            ->where('activity_type', 'Short Description')
            ->exists();
            $history = new QueryManagementAuditTrail;
            $history->query_management_id = $data->id;
            $history->activity_type = 'Short Description';
            if($lastDocument->short_description == null){
                $history->previous = "NULL";
            } else{
                $history->previous = $lastDocument->short_description;
            }
            $history->current = $request->short_description;
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

        if($lastDocument->reference_document != $data->reference_document){
            $lastDocumentAuditTrail = QueryManagementAuditTrail::where('query_management_id', $data->id)
            ->where('activity_type', 'Reference Document')
            ->exists();
            $history = new QueryManagementAuditTrail;
            $history->query_management_id = $data->id;
            $history->activity_type = 'Reference Document';
            if($lastDocument->reference_document == null){
                $history->previous = "NULL";
            } else{
                $history->previous = $lastDocument->reference_document;
            }
            $history->current = $data->reference_document;
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

        if($lastDocument->query_volume != $data->query_volume){
            $lastDocumentAuditTrail = QueryManagementAuditTrail::where('query_management_id', $data->id)
            ->where('activity_type', 'Volume')
            ->exists();
            $history = new QueryManagementAuditTrail;
            $history->query_management_id = $data->id;
            $history->activity_type = 'Volume';
            if($lastDocument->query_volume == null){
                $history->previous = "NULL";
            } else{
                $history->previous = $lastDocument->query_volume;
            }
            $history->current = $data->query_volume;
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

        if($lastDocument->query_medium != $data->query_medium){
            $lastDocumentAuditTrail = QueryManagementAuditTrail::where('query_management_id', $data->id)
            ->where('activity_type', 'Query Medium')
            ->exists();
            $history = new QueryManagementAuditTrail;
            $history->query_management_id = $data->id;
            $history->activity_type = 'Query Medium';
            if($lastDocument->query_medium == null){
                $history->previous = "NULL";
            } else{
                $history->previous = $lastDocument->query_medium;
            }
            $history->current = $data->query_medium;
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

        if($lastDocument->mail_attachment != $data->mail_attachment){
            $lastDocumentAuditTrail = QueryManagementAuditTrail::where('query_management_id', $data->id)
            ->where('activity_type', 'Mail Attachment')
            ->exists();
            $history = new QueryManagementAuditTrail;
            $history->query_management_id = $data->id;
            $history->activity_type = 'Mail Attachment';
            if($lastDocument->mail_attachment == null){
                $history->previous = "NULL";
            } else{
                $history->previous = $lastDocument->mail_attachment;
            }
            $history->current = $data->mail_attachment;
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

        if($lastDocument->assign_to != $request->assign_to){
            $lastDocumentAuditTrail = QueryManagementAuditTrail::where('query_management_id', $data->id)
            ->where('activity_type', 'Mail Attachment')
            ->exists();
            $history = new QueryManagementAuditTrail;
            $history->query_management_id = $data->id;
            $history->activity_type = 'Mail Attachment';
            if($lastDocument->assign_to == null){
                $history->previous = "NULL";
            } else{
                $history->previous = Helpers::getInitiatorName($lastDocument->assign_to);
            }
            $history->current = Helpers::getInitiatorName($request->assign_to);
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

        if($lastDocument->contact_mailId != $data->contact_mailId){
            $lastDocumentAuditTrail = QueryManagementAuditTrail::where('query_management_id', $data->id)
            ->where('activity_type', 'Contact Person Mail ID')
            ->exists();
            $history = new QueryManagementAuditTrail;
            $history->query_management_id = $data->id;
            $history->activity_type = 'Contact Person Mail ID';
            if($lastDocument->contact_mailId == null){
                $history->previous = "NULL";
            } else{
                $history->previous = $lastDocument->contact_mailId;
            }
            $history->current = $data->contact_mailId;
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

        if($lastDocument->contact_mobile != $data->contact_mobile){
            $lastDocumentAuditTrail = QueryManagementAuditTrail::where('query_management_id', $data->id)
            ->where('activity_type', 'Contact Person Phone No.')
            ->exists();
            $history = new QueryManagementAuditTrail;
            $history->query_management_id = $data->id;
            $history->activity_type = 'Contact Person Phone No.';
            if($lastDocument->contact_mobile == null){
                $history->previous = "NULL";
            } else{
                $history->previous = $lastDocument->contact_mobile;
            }
            $history->current = $data->contact_mobile;
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

        if($lastDocument->affiliation != $data->affiliation){
            $lastDocumentAuditTrail = QueryManagementAuditTrail::where('query_management_id', $data->id)
            ->where('activity_type', 'Affiliation')
            ->exists();
            $history = new QueryManagementAuditTrail;
            $history->query_management_id = $data->id;
            $history->activity_type = 'Affiliation';
            if($lastDocument->affiliation == null){
                $history->previous = "NULL";
            } else{
                $history->previous = $lastDocument->affiliation;
            }
            $history->current = $data->affiliation;
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

        if($lastDocument->initial_attachment != $data->initial_attachment){
            $lastDocumentAuditTrail = QueryManagementAuditTrail::where('query_management_id', $data->id)
            ->where('activity_type', 'Initial Attachment')
            ->exists();
            $history = new QueryManagementAuditTrail;
            $history->query_management_id = $data->id;
            $history->activity_type = 'Initial Attachment';
            if($lastDocument->initial_attachment == null){
                $history->previous = "NULL";
            } else{
                $history->previous = $lastDocument->initial_attachment;
            }
            $history->current = $data->initial_attachment;
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

        if($lastDocument->reviewer_comment != $data->reviewer_comment){
            $lastDocumentAuditTrail = QueryManagementAuditTrail::where('query_management_id', $data->id)
            ->where('activity_type', 'Admin 1 Comments')
            ->exists();
            $history = new QueryManagementAuditTrail;
            $history->query_management_id = $data->id;
            $history->activity_type = 'Admin 1 Comments';
            if($lastDocument->reviewer_comment == null){
                $history->previous = "NULL";
            } else{
                $history->previous = $lastDocument->reviewer_comment;
            }
            $history->current = $data->reviewer_comment;
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

        if($lastDocument->reviewer_attachment != $data->reviewer_attachment){
            $lastDocumentAuditTrail = QueryManagementAuditTrail::where('query_management_id', $data->id)
            ->where('activity_type', 'Admin 1 Attachments')
            ->exists();
            $history = new QueryManagementAuditTrail;
            $history->query_management_id = $data->id;
            $history->activity_type = 'Admin 1 Attachments';
            if($lastDocument->reviewer_attachment == null){
                $history->previous = "NULL";
            } else{
                $history->previous = $lastDocument->reviewer_attachment;
            }
            $history->current = $data->reviewer_attachment;
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

        if($lastDocument->admin1_comment != $data->admin1_comment){
            $lastDocumentAuditTrail = QueryManagementAuditTrail::where('query_management_id', $data->id)
            ->where('activity_type', 'Admin 2 Comments')
            ->exists();
            $history = new QueryManagementAuditTrail;
            $history->query_management_id = $data->id;
            $history->activity_type = 'Admin 2 Comments';
            if($lastDocument->admin1_comment == null){
                $history->previous = "NULL";
            } else{
                $history->previous = $lastDocument->admin1_comment;
            }
            $history->current = $data->admin1_comment;
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

        if($lastDocument->admin1_attachment != $data->admin1_attachment){
            $lastDocumentAuditTrail = QueryManagementAuditTrail::where('query_management_id', $data->id)
            ->where('activity_type', 'Admin 2 Attachments')
            ->exists();
            $history = new QueryManagementAuditTrail;
            $history->query_management_id = $data->id;
            $history->activity_type = 'Admin 2 Attachments';
            if($lastDocument->admin1_attachment == null){
                $history->previous = "NULL";
            } else{
                $history->previous = $lastDocument->admin1_attachment;
            }
            $history->current = $data->admin1_attachment;
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

        if($lastDocument->HOD_comment != $data->HOD_comment){
            $lastDocumentAuditTrail = QueryManagementAuditTrail::where('query_management_id', $data->id)
            ->where('activity_type', 'HOD Comments')
            ->exists();
            $history = new QueryManagementAuditTrail;
            $history->query_management_id = $data->id;
            $history->activity_type = 'HOD Comments';
            if($lastDocument->HOD_comment == null){
                $history->previous = "NULL";
            } else{
                $history->previous = $lastDocument->HOD_comment;
            }
            $history->current = $data->HOD_comment;
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

        if($lastDocument->HOD_attachment != $data->HOD_attachment){
            $lastDocumentAuditTrail = QueryManagementAuditTrail::where('query_management_id', $data->id)
            ->where('activity_type', 'HOD Attachments')
            ->exists();
            $history = new QueryManagementAuditTrail;
            $history->query_management_id = $data->id;
            $history->activity_type = 'HOD Attachments';
            if($lastDocument->HOD_attachment == null){
                $history->previous = "NULL";
            } else{
                $history->previous = $lastDocument->HOD_attachment;
            }
            $history->current = $data->HOD_attachment;
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

        if($lastDocument->resolution_status != $data->resolution_status){
            $lastDocumentAuditTrail = QueryManagementAuditTrail::where('query_management_id', $data->id)
            ->where('activity_type', 'Resolution Status')
            ->exists();
            $history = new QueryManagementAuditTrail;
            $history->query_management_id = $data->id;
            $history->activity_type = 'Resolution Status';
            if($lastDocument->resolution_status == null){
                $history->previous = "NULL";
            } else{
                $history->previous = $lastDocument->resolution_status;
            }
            $history->current = $data->resolution_status;
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

        if($lastDocument->category_tags != $data->category_tags){
            $lastDocumentAuditTrail = QueryManagementAuditTrail::where('query_management_id', $data->id)
            ->where('activity_type', 'Category Tags')
            ->exists();
            $history = new QueryManagementAuditTrail;
            $history->query_management_id = $data->id;
            $history->activity_type = 'Category Tags';
            if($lastDocument->category_tags == null){
                $history->previous = "NULL";
            } else{
                $history->previous = $lastDocument->category_tags;
            }
            $history->current = $data->category_tags;
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

        if($lastDocument->response_details != $data->response_details){
            $lastDocumentAuditTrail = QueryManagementAuditTrail::where('query_management_id', $data->id)
            ->where('activity_type', 'Response Details')
            ->exists();
            $history = new QueryManagementAuditTrail;
            $history->query_management_id = $data->id;
            $history->activity_type = 'Response Details';
            if($lastDocument->response_details == null){
                $history->previous = "NULL";
            } else{
                $history->previous = $lastDocument->response_details;
            }
            $history->current = $data->response_details;
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

        if($lastDocument->followup_action != $data->followup_action){
            $lastDocumentAuditTrail = QueryManagementAuditTrail::where('query_management_id', $data->id)
            ->where('activity_type', 'Follow-up Actions')
            ->exists();
            $history = new QueryManagementAuditTrail;
            $history->query_management_id = $data->id;
            $history->activity_type = 'Follow-up Actions';
            if($lastDocument->followup_action == null){
                $history->previous = "NULL";
            } else{
                $history->previous = $lastDocument->followup_action;
            }
            $history->current = $data->followup_action;
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

        if($lastDocument->supporting_doc != $data->supporting_doc){
            $lastDocumentAuditTrail = QueryManagementAuditTrail::where('query_management_id', $data->id)
            ->where('activity_type', 'Supporting Documents')
            ->exists();
            $history = new QueryManagementAuditTrail;
            $history->query_management_id = $data->id;
            $history->activity_type = 'Supporting Documents';
            if($lastDocument->supporting_doc == null){
                $history->previous = "NULL";
            } else{
                $history->previous = $lastDocument->supporting_doc;
            }
            $history->current = $data->supporting_doc;
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

        toastr()->success("Record is update Successfully");
        return redirect()->back();
    }

    public function singleReport($id){
        $data = QueryManagement::find($id);
        if (!empty($data)) {
            $data->originator = User::where('id', $data->initiator_id)->value('name');

            $pdf = App::make('dompdf.wrapper');
            $time = Carbon::now();
            $pdf = PDF::loadview('frontend.query-management.single_report', compact(
                'data'
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
                $width / 8,
                $height / 2,
                $data->status,
                null,
                20,
                [0, 0, 0],
                2,
                6,
                -20
            );

            return $pdf->stream('SOP' . $id . '.pdf');
        }
    }

    public function auditTrail($id){
        $audit = QueryManagementAuditTrail::where('query_management_id', $id)->orderByDESC('id')->paginate(5);
        $today = Carbon::now()->format('d-m-y');
        $document = QueryManagement::where('id', $id)->first();
        $document->originator = User::where('id', $document->initiator_id)->value('name');

        return view('frontend.query-management.audit_trail', compact('audit', 'document', 'today')); 
    }

    public function auditReport($id){
        $doc = QueryManagement::find($id);
        if (!empty($doc)) {
            $doc->originator = User::where('id', $doc->initiator_id)->value('name');
            $data = QueryManagementAuditTrail::where('query_management_id', $doc->id)->orderByDesc('id')->get();

            $pdf = App::make('dompdf.wrapper');
            $time = Carbon::now();
            $pdf = PDF::loadview('frontend.query-management.audit_report', compact('data', 'doc'))
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
            return $pdf->stream('QM' . $id . '.pdf');
        }
    }

    public function sendStage(Request $request, $id)
    {
        if($request->username == Auth::user()->Username && Hash::check($request->password, Auth::user()->password)) {
            $queryManagement = QueryManagement::find($id);            
            $lastDocument = QueryManagement::find($id);

            $updateCFT = QueryManagementCft::where('query_management_id', $id)->latest()->first();
            $cftDetails = QueryManagementCftResponse::withoutTrashed()->where(['status' => 'In-progress', 'query_management_id' => $id])->distinct('cft_user_id')->count();

            if ($queryManagement->stage == 1) {
                $queryManagement->stage = "2";
                $queryManagement->status = "Pending Query Review";
                $queryManagement->submitted_by = Auth::user()->name;
                $queryManagement->submitted_on = Carbon::now()->format('d-M-Y');
                $queryManagement->submitted_comment = $request->comments;

                $history = new QueryManagementAuditTrail();
                $history->query_management_id = $id;
                $history->activity_type = 'Submit By, Submit On';
                if (is_null($lastDocument->submitted_by) || $lastDocument->submitted_by === '') {
                    $history->previous = "NULL";
                } else {
                    $history->previous = $lastDocument->submitted_by . ' , ' . $lastDocument->submitted_on;
                }
                $history->current = $queryManagement->submitted_by . ' , ' . $queryManagement->submitted_on;
                if (is_null($lastDocument->submitted_by) || $lastDocument->submitted_on === '') {
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
                $history->change_to = "Pending Query Review";
                $history->change_from = $lastDocument->status;
                $history->stage = 'Plan Proposed';                    
                $history->save();

                $list = Helpers::getHodUserList($queryManagement->division_id);
                $userIds = collect($list)->pluck('user_id')->toArray();
                $users = User::whereIn('id', $userIds)->select('id', 'name', 'email')->get();

                foreach ($users as $userValue) {
                    DB::table('notifications')->insert([
                        'activity_id' => $queryManagement->id,
                        'activity_type' => "Notification",
                        'from_id' => Auth::user()->id,
                        'user_name' => $userValue->name,
                        'to_id' => $userValue->id,
                        'process_name' => "Query Management",
                        'division_id' => $queryManagement->division_id,
                        'short_description' => $queryManagement->short_description,
                        'initiator_id' => $queryManagement->initiator_id,
                        'due_date' => $queryManagement->due_date,
                        'record' => $queryManagement->record,
                        'site' => "Query Management",
                        'comment' => $request->comments,
                        'status' => $queryManagement->status,
                        'stage' => $queryManagement->stage,
                        'created_at' => Carbon::now(),
                    ]);
                }

                // foreach ($list as $u) {
                //     $email = Helpers::getUserEmail($u->user_id);
                //         if ($email !== null) {
                //         try {
                //             Mail::send(
                //                 'mail.view-mail',
                //                 ['data' => $queryManagement, 'site' => "CC", 'history' => "Submit", 'process' => 'Change Control', 'comment' => $request->comments, 'user' => Auth::user()->name],
                //                 function ($message) use ($email, $queryManagement) {
                //                     $message->to($email)
                //                     ->subject("IPC Notification: Change Control, Record #" . str_pad($queryManagement->record, 4, '0', STR_PAD_LEFT) . " - Activity: Submit Performed");
                //                 }
                //             );
                //         } catch(\Exception $e) {
                //             info('Error sending mail', [$e]);
                //         }
                //     }
                // }

                $queryManagement->update();
                toastr()->success('Sent to HOD Assessment');
                return back();

            }
            if ($queryManagement->stage == 2) {
                $queryManagement->stage = "3";
                $queryManagement->status = "Pending Acknowledgement from Admin 2";
                $queryManagement->queryReviewCompleted_by = Auth::user()->name;
                $queryManagement->queryReviewCompleted_on = Carbon::now()->format('d-M-Y');
                $queryManagement->queryReviewCompleted_comment = $request->comments;

                $history = new QueryManagementAuditTrail();
                $history->query_management_id = $id;
                $history->activity_type = 'Query Review Complete By, Query Review Complete On';
                if (is_null($lastDocument->queryReviewCompleted_by) || $lastDocument->queryReviewCompleted_by === '') {
                    $history->previous = "NULL";
                } else {
                    $history->previous = $lastDocument->queryReviewCompleted_by . ' , ' . $lastDocument->queryReviewCompleted_on;
                }
                $history->current = $queryManagement->queryReviewCompleted_by . ' , ' . $queryManagement->queryReviewCompleted_on;
                if (is_null($lastDocument->queryReviewCompleted_by) || $lastDocument->queryReviewCompleted_on === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->action = 'Query Review Complete';
                $history->comment = $request->comments;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to = "Pending Acknowledgement from Admin 2";
                $history->change_from = $lastDocument->status;
                $history->stage = 'Plan Proposed';                    
                $history->save();

                $list = Helpers::getHodUserList($queryManagement->division_id);
                $userIds = collect($list)->pluck('user_id')->toArray();
                $users = User::whereIn('id', $userIds)->select('id', 'name', 'email')->get();


                foreach ($users as $userValue) {
                    DB::table('notifications')->insert([
                        'activity_id' => $queryManagement->id,
                        'activity_type' => "Notification",
                        'from_id' => Auth::user()->id,
                        'user_name' => $userValue->name,
                        'to_id' => $userValue->id,
                        'process_name' => "Query Management",
                        'division_id' => $queryManagement->division_id,
                        'short_description' => $queryManagement->short_description,
                        'initiator_id' => $queryManagement->initiator_id,
                        'due_date' => $queryManagement->due_date,
                        'record' => $queryManagement->record,
                        'site' => "Query Management",
                        'comment' => $request->comments,
                        'status' => $queryManagement->status,
                        'stage' => $queryManagement->stage,
                        'created_at' => Carbon::now(),
                    ]);
                }

                // foreach ($list as $u) {
                //     $email = Helpers::getUserEmail($u->user_id);
                //         if ($email !== null) {
                //         try {
                //             Mail::send(
                //                 'mail.view-mail',
                //                 ['data' => $queryManagement, 'site' => "CC", 'history' => "Submit", 'process' => 'Change Control', 'comment' => $request->comments, 'user' => Auth::user()->name],
                //                 function ($message) use ($email, $queryManagement) {
                //                     $message->to($email)
                //                     ->subject("IPC Notification: Change Control, Record #" . str_pad($queryManagement->record, 4, '0', STR_PAD_LEFT) . " - Activity: Submit Performed");
                //                 }
                //             );
                //         } catch(\Exception $e) {
                //             info('Error sending mail', [$e]);
                //         }
                //     }
                // }

                $queryManagement->update();
                toastr()->success('Sent to HOD Assessment');
                return back();
            }
            if ($queryManagement->stage == 3) {
                $queryManagement->stage = "4";
                $queryManagement->status = "Pending Admin 2 Review";
                $queryManagement->AcknowledgementCompleted_by = Auth::user()->name;
                $queryManagement->AcknowledgementCompleted_on = Carbon::now()->format('d-M-Y');
                $queryManagement->AcknowledgementCompleted_comment = $request->comments;

                $history = new QueryManagementAuditTrail();
                $history->query_management_id = $id;
                $history->activity_type = 'Acknowledgement Complete By, Acknowledgement Complete On';
                if (is_null($lastDocument->AcknowledgementCompleted_by) || $lastDocument->AcknowledgementCompleted_by === '') {
                    $history->previous = "NULL";
                } else {
                    $history->previous = $lastDocument->AcknowledgementCompleted_by . ' , ' . $lastDocument->AcknowledgementCompleted_on;
                }
                $history->current = $queryManagement->AcknowledgementCompleted_by . ' , ' . $queryManagement->AcknowledgementCompleted_on;
                if (is_null($lastDocument->AcknowledgementCompleted_by) || $lastDocument->AcknowledgementCompleted_on === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->action = 'Acknowledgement Complete';
                $history->comment = $request->comments;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to = "Pending Admin 2 Review";
                $history->change_from = $lastDocument->status;
                $history->stage = 'Plan Proposed';                    
                $history->save();

                $list = Helpers::getHodUserList($queryManagement->division_id);
                $userIds = collect($list)->pluck('user_id')->toArray();
                $users = User::whereIn('id', $userIds)->select('id', 'name', 'email')->get();


                foreach ($users as $userValue) {
                    DB::table('notifications')->insert([
                        'activity_id' => $queryManagement->id,
                        'activity_type' => "Notification",
                        'from_id' => Auth::user()->id,
                        'user_name' => $userValue->name,
                        'to_id' => $userValue->id,
                        'process_name' => "Query Management",
                        'division_id' => $queryManagement->division_id,
                        'short_description' => $queryManagement->short_description,
                        'initiator_id' => $queryManagement->initiator_id,
                        'due_date' => $queryManagement->due_date,
                        'record' => $queryManagement->record,
                        'site' => "Query Management",
                        'comment' => $request->comments,
                        'status' => $queryManagement->status,
                        'stage' => $queryManagement->stage,
                        'created_at' => Carbon::now(),
                    ]);
                }

                // foreach ($list as $u) {
                //     $email = Helpers::getUserEmail($u->user_id);
                //         if ($email !== null) {
                //         try {
                //             Mail::send(
                //                 'mail.view-mail',
                //                 ['data' => $queryManagement, 'site' => "CC", 'history' => "Submit", 'process' => 'Change Control', 'comment' => $request->comments, 'user' => Auth::user()->name],
                //                 function ($message) use ($email, $queryManagement) {
                //                     $message->to($email)
                //                     ->subject("IPC Notification: Change Control, Record #" . str_pad($queryManagement->record, 4, '0', STR_PAD_LEFT) . " - Activity: Submit Performed");
                //                 }
                //             );
                //         } catch(\Exception $e) {
                //             info('Error sending mail', [$e]);
                //         }
                //     }
                // }

                $queryManagement->update();
                toastr()->success('Sent to HOD Assessment');
                return back();
            }
            if ($queryManagement->stage == 4) {
                $queryManagement->stage = "5";
                $queryManagement->status = "Pending HOD Review";
                $queryManagement->Admin2Completed_by = Auth::user()->name;
                $queryManagement->Admin2Completed_on = Carbon::now()->format('d-M-Y');
                $queryManagement->Admin2Completed_comment = $request->comments;

                $history = new QueryManagementAuditTrail();
                $history->query_management_id = $id;
                $history->activity_type = 'Admin 2 Review Complete By, Admin 2 Review Complete On';
                if (is_null($lastDocument->Admin2Completed_by) || $lastDocument->Admin2Completed_by === '') {
                    $history->previous = "NULL";
                } else {
                    $history->previous = $lastDocument->Admin2Completed_by . ' , ' . $lastDocument->Admin2Completed_on;
                }
                $history->current = $queryManagement->Admin2Completed_by . ' , ' . $queryManagement->Admin2Completed_on;
                if (is_null($lastDocument->Admin2Completed_by) || $lastDocument->Admin2Completed_on === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->action = 'Admin 2 Review Complete';
                $history->comment = $request->comments;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to = "Pending HOD Review";
                $history->change_from = $lastDocument->status;
                $history->stage = 'Plan Proposed';                    
                $history->save();

                $list = Helpers::getHodUserList($queryManagement->division_id);
                $userIds = collect($list)->pluck('user_id')->toArray();
                $users = User::whereIn('id', $userIds)->select('id', 'name', 'email')->get();


                foreach ($users as $userValue) {
                    DB::table('notifications')->insert([
                        'activity_id' => $queryManagement->id,
                        'activity_type' => "Notification",
                        'from_id' => Auth::user()->id,
                        'user_name' => $userValue->name,
                        'to_id' => $userValue->id,
                        'process_name' => "Query Management",
                        'division_id' => $queryManagement->division_id,
                        'short_description' => $queryManagement->short_description,
                        'initiator_id' => $queryManagement->initiator_id,
                        'due_date' => $queryManagement->due_date,
                        'record' => $queryManagement->record,
                        'site' => "Query Management",
                        'comment' => $request->comments,
                        'status' => $queryManagement->status,
                        'stage' => $queryManagement->stage,
                        'created_at' => Carbon::now(),
                    ]);
                }

                // foreach ($list as $u) {
                //     $email = Helpers::getUserEmail($u->user_id);
                //         if ($email !== null) {
                //         try {
                //             Mail::send(
                //                 'mail.view-mail',
                //                 ['data' => $queryManagement, 'site' => "CC", 'history' => "Submit", 'process' => 'Change Control', 'comment' => $request->comments, 'user' => Auth::user()->name],
                //                 function ($message) use ($email, $queryManagement) {
                //                     $message->to($email)
                //                     ->subject("IPC Notification: Change Control, Record #" . str_pad($queryManagement->record, 4, '0', STR_PAD_LEFT) . " - Activity: Submit Performed");
                //                 }
                //             );
                //         } catch(\Exception $e) {
                //             info('Error sending mail', [$e]);
                //         }
                //     }
                // }

                $queryManagement->update();
                toastr()->success('Sent to HOD Assessment');
                return back();
            }
            if ($queryManagement->stage == 5) {
                $queryManagement->stage = "6";
                $queryManagement->status = "Pending CFT Review";
                $queryManagement->cftRequired_by = Auth::user()->name;
                $queryManagement->cftRequired_on = Carbon::now()->format('d-M-Y');
                $queryManagement->cftRequired_comment = $request->comments;

                $history = new QueryManagementAuditTrail();
                $history->query_management_id = $id;
                $history->activity_type = 'CFT Review Required By, CFT Review Required On';
                if (is_null($lastDocument->cftRequired_by) || $lastDocument->cftRequired_by === '') {
                    $history->previous = "NULL";
                } else {
                    $history->previous = $lastDocument->cftRequired_by . ' , ' . $lastDocument->cftRequired_on;
                }
                $history->current = $queryManagement->cftRequired_by . ' , ' . $queryManagement->cftRequired_on;
                if (is_null($lastDocument->cftRequired_by) || $lastDocument->cftRequired_on === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->action = 'CFT Review Required';
                $history->comment = $request->comments;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to = "Pending CFT Review";
                $history->change_from = $lastDocument->status;
                $history->stage = 'Plan Proposed';                    
                $history->save();

                $list = Helpers::getHodUserList($queryManagement->division_id);
                $userIds = collect($list)->pluck('user_id')->toArray();
                $users = User::whereIn('id', $userIds)->select('id', 'name', 'email')->get();


                foreach ($users as $userValue) {
                    DB::table('notifications')->insert([
                        'activity_id' => $queryManagement->id,
                        'activity_type' => "Notification",
                        'from_id' => Auth::user()->id,
                        'user_name' => $userValue->name,
                        'to_id' => $userValue->id,
                        'process_name' => "Query Management",
                        'division_id' => $queryManagement->division_id,
                        'short_description' => $queryManagement->short_description,
                        'initiator_id' => $queryManagement->initiator_id,
                        'due_date' => $queryManagement->due_date,
                        'record' => $queryManagement->record,
                        'site' => "Query Management",
                        'comment' => $request->comments,
                        'status' => $queryManagement->status,
                        'stage' => $queryManagement->stage,
                        'created_at' => Carbon::now(),
                    ]);
                }

                // foreach ($list as $u) {
                //     $email = Helpers::getUserEmail($u->user_id);
                //         if ($email !== null) {
                //         try {
                //             Mail::send(
                //                 'mail.view-mail',
                //                 ['data' => $queryManagement, 'site' => "CC", 'history' => "Submit", 'process' => 'Change Control', 'comment' => $request->comments, 'user' => Auth::user()->name],
                //                 function ($message) use ($email, $queryManagement) {
                //                     $message->to($email)
                //                     ->subject("IPC Notification: Change Control, Record #" . str_pad($queryManagement->record, 4, '0', STR_PAD_LEFT) . " - Activity: Submit Performed");
                //                 }
                //             );
                //         } catch(\Exception $e) {
                //             info('Error sending mail', [$e]);
                //         }
                //     }
                // }

                $queryManagement->update();
                toastr()->success('Sent to HOD Assessment');
                return back();
            }
            

            if ($queryManagement->stage == 6) {

                $IsCFTRequired = QueryManagementCftResponse::withoutTrashed()->where(['is_required' => 1, 'query_management_id' => $id])->latest()->first();
                $cftUsers = DB::table('query_management_cfts')->where(['query_management_id' => $id])->first();

                /****** CFT Person ******/
                $columns = ['QualityAssurance_person', 'Production_Table_Person', 'ProductionLiquid_person', 'Production_Injection_Person', 'Store_person', 'Quality_Control_Person', 'ResearchDevelopment_person', 'Engineering_person', 'Human_Resource_person', 'Microbiology_person', 'RegulatoryAffair_person', 'Environment_Health_Safety_person', 'Information_Technology_person', 'ContractGiver_person', 'Other1_person', 'Other2_person', 'Other3_person', 'Other4_person', 'Other5_person', 'CorporateQualityAssurance_person'];
                // Initialize an array to store the values

                $valuesArray = [];

                // Iterate over the columns and retrieve the values
                foreach ($columns as $index => $column) {
                    $value = $cftUsers->$column;
                    // return dd($index == 0 && $cftUsers->$column == Auth::user()->name);
                    if ($index == 0 && $cftUsers->$column == Auth::user()->id) {
                        $updateCFT->QualityAssurance_by = Auth::user()->name;
                        $updateCFT->QualityAssurance_on = Carbon::now()->format('Y-m-d');

                        $history = new QueryManagementAuditTrail();
                        $history->query_management_id = $id;
                        $history->activity_type = 'Quality Assurance Completed By, Quality Assurance Completed On';

                        if (is_null($lastDocument->QualityAssurance_by) || $lastDocument->QualityAssurance_on == '') {
                            $history->previous = "";
                        } else {
                            $history->previous = $lastDocument->QualityAssurance_by . ' , ' . $lastDocument->QualityAssurance_on;
                        }

                        $history->action = 'CFT Review Complete';
                        
                        $history->current = $updateCFT->QualityAssurance_by . ', ' . $updateCFT->QualityAssurance_on;

                        $history->comment = $request->comment;
                        $history->user_id = Auth::user()->name;
                        $history->user_name = Auth::user()->name;
                        $history->change_to = "Not Applicable";
                        $history->change_from = $lastDocument->status;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->origin_state = $lastDocument->status;
                        $history->stage = 'CFT Review';

                        if (is_null($lastDocument->QualityAssurance_by) || $lastDocument->QualityAssurance_on == '') {
                            $history->action_name = 'New';
                        } else {
                            $history->action_name = 'Update';
                        }

                        $history->save();
                    }

                    if ($index == 1 && $cftUsers->$column == Auth::user()->id) {
                        $updateCFT->Production_Table_By = Auth::user()->name;
                        $updateCFT->Production_Table_On = Carbon::now()->format('Y-m-d');

                        $history = new QueryManagementAuditTrail();
                        $history->query_management_id = $id;
                        $history->activity_type = 'Production Tablet Completed By, Production Tablet Completed On';

                        if (is_null($lastDocument->Production_Table_By) || $lastDocument->Production_Table_On == '') {
                            $history->previous = "";
                        } else {
                            $history->previous = $lastDocument->Production_Table_By . ' , ' . $lastDocument->Production_Table_On;
                        }

                        $history->action = 'CFT Review Complete';
                        
                        $history->current = $updateCFT->Production_Table_By . ', ' . $updateCFT->Production_Table_On;

                        $history->comment = $request->comment;
                        $history->user_id = Auth::user()->name;
                        $history->user_name = Auth::user()->name;
                        $history->change_to = "Not Applicable";
                        $history->change_from = $lastDocument->status;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->origin_state = $lastDocument->status;
                        $history->stage = 'CFT Review';

                        if (is_null($lastDocument->Production_Table_By) || $lastDocument->Production_Table_On == '') {
                            $history->action_name = 'New';
                        } else {
                            $history->action_name = 'Update';
                        }

                        $history->save();
                    }

                    if ($index == 2 && $cftUsers->$column == Auth::user()->id) {
                        $updateCFT->ProductionLiquid_by = Auth::user()->name;
                        $updateCFT->ProductionLiquid_on = Carbon::now()->format('Y-m-d');

                        $history = new QueryManagementAuditTrail();
                        $history->query_management_id = $id;
                        $history->activity_type = 'Production Liquid Completed By, Production Liquid Completed On';

                        if (is_null($lastDocument->ProductionLiquid_by) || $lastDocument->ProductionLiquid_on == '') {
                            $history->previous = "";
                        } else {
                            $history->previous = $lastDocument->ProductionLiquid_by . ' , ' . $lastDocument->ProductionLiquid_on;
                        }

                        $history->action = 'CFT Review Complete';
                        
                        $history->current = $updateCFT->ProductionLiquid_by . ', ' . $updateCFT->ProductionLiquid_on;

                        $history->comment = $request->comment;
                        $history->user_id = Auth::user()->name;
                        $history->user_name = Auth::user()->name;
                        $history->change_to = "Not Applicable";
                        $history->change_from = $lastDocument->status;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->origin_state = $lastDocument->status;
                        $history->stage = 'CFT Review';

                        if (is_null($lastDocument->ProductionLiquid_by) || $lastDocument->ProductionLiquid_on == '') {
                            $history->action_name = 'New';
                        } else {
                            $history->action_name = 'Update';
                        }

                        $history->save();
                    }

                    if ($index == 3 && $cftUsers->$column == Auth::user()->id) {
                        $updateCFT->Production_Injection_By = Auth::user()->name;
                        $updateCFT->Production_Injection_On = Carbon::now()->format('Y-m-d');

                        $history = new QueryManagementAuditTrail();
                        $history->query_management_id = $id;
                        $history->activity_type = 'Production Injection Completed By, Production Injection Completed On';

                        if (is_null($lastDocument->Production_Injection_By) || $lastDocument->Production_Injection_On == '') {
                            $history->previous = "";
                        } else {
                            $history->previous = $lastDocument->Production_Injection_By . ' , ' . $lastDocument->Production_Injection_On;
                        }

                        $history->action = 'CFT Review Complete';
                        
                        $history->current = $updateCFT->Production_Injection_By . ', ' . $updateCFT->Production_Injection_On;

                        $history->comment = $request->comment;
                        $history->user_id = Auth::user()->name;
                        $history->user_name = Auth::user()->name;
                        $history->change_to = "Not Applicable";
                        $history->change_from = $lastDocument->status;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->origin_state = $lastDocument->status;
                        $history->stage = 'CFT Review';

                        if (is_null($lastDocument->Production_Injection_By) || $lastDocument->Production_Injection_On == '') {
                            $history->action_name = 'New';
                        } else {
                            $history->action_name = 'Update';
                        }

                        $history->save();
                    }

                    if ($index == 4 && $cftUsers->$column == Auth::user()->id) {
                        $updateCFT->Store_by = Auth::user()->name;
                        $updateCFT->Store_on = Carbon::now()->format('Y-m-d');

                        $history = new QueryManagementAuditTrail();
                        $history->query_management_id = $id;
                        $history->activity_type = 'Store Review Completed By, Store Review Completed On';

                        if (is_null($lastDocument->Store_by) || $lastDocument->Store_on == '') {
                            $history->previous = "";
                        } else {
                            $history->previous = $lastDocument->Store_by . ' , ' . $lastDocument->Store_on;
                        }

                        $history->action = 'CFT Review Complete';
                        
                        $history->current = $updateCFT->Store_by . ', ' . $updateCFT->Store_on;

                        $history->comment = $request->comment;
                        $history->user_id = Auth::user()->name;
                        $history->user_name = Auth::user()->name;
                        $history->change_to = "Not Applicable";
                        $history->change_from = $lastDocument->status;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->origin_state = $lastDocument->status;
                        $history->stage = 'CFT Review';

                        if (is_null($lastDocument->Store_by) || $lastDocument->Store_on == '') {
                            $history->action_name = 'New';
                        } else {
                            $history->action_name = 'Update';
                        }

                        $history->save();
                    }

                    if ($index == 5 && $cftUsers->$column == Auth::user()->id) {
                        $updateCFT->Quality_Control_by = Auth::user()->name;
                        $updateCFT->Quality_Control_on = Carbon::now()->format('Y-m-d');

                        $history = new QueryManagementAuditTrail();
                        $history->query_management_id = $id;
                        $history->activity_type = 'Quality Control By, Quality Control On';

                        if (is_null($lastDocument->Quality_Control_by) || $lastDocument->Quality_Control_on == '') {
                            $history->previous = "";
                        } else {
                            $history->previous = $lastDocument->Quality_Control_by . ' , ' . $lastDocument->Quality_Control_on;
                        }

                        $history->action = 'CFT Review Complete';
                        
                        $history->current = $updateCFT->Quality_Control_by . ', ' . $updateCFT->Quality_Control_on;

                        $history->comment = $request->comment;
                        $history->user_id = Auth::user()->name;
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

                    if ($index == 5 && $cftUsers->$column == Auth::user()->id) {
                        $updateCFT->ResearchDevelopment_by = Auth::user()->name;
                        $updateCFT->ResearchDevelopment_on = Carbon::now()->format('Y-m-d');

                        $history = new QueryManagementAuditTrail();
                        $history->query_management_id = $id;
                        $history->activity_type = 'Research & Development By, Research & Development On';

                        if (is_null($lastDocument->ResearchDevelopment_by) || $lastDocument->ResearchDevelopment_on == '') {
                            $history->previous = "";
                        } else {
                            $history->previous = $lastDocument->ResearchDevelopment_by . ' , ' . $lastDocument->ResearchDevelopment_on;
                        }

                        $history->action = 'CFT Review Complete';
                        
                        $history->current = $updateCFT->ResearchDevelopment_by . ', ' . $updateCFT->ResearchDevelopment_on;

                        $history->comment = $request->comment;
                        $history->user_id = Auth::user()->name;
                        $history->user_name = Auth::user()->name;
                        $history->change_to = "Not Applicable";
                        $history->change_from = $lastDocument->status;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->origin_state = $lastDocument->status;
                        $history->stage = 'CFT Review';

                        if (is_null($lastDocument->ResearchDevelopment_by) || $lastDocument->ResearchDevelopment_on == '') {
                            $history->action_name = 'New';
                        } else {
                            $history->action_name = 'Update';
                        }

                        $history->save();
                    }

                    if ($index == 6 && $cftUsers->$column == Auth::user()->id) {
                        $updateCFT->Engineering_by = Auth::user()->name;
                        $updateCFT->Engineering_on = Carbon::now()->format('Y-m-d');

                        $history = new QueryManagementAuditTrail();
                        $history->query_management_id = $id;
                        $history->activity_type = 'Engineering By, Engineering On';

                        if (is_null($lastDocument->Engineering_by) || $lastDocument->Engineering_on == '') {
                            $history->previous = "";
                        } else {
                            $history->previous = $lastDocument->Engineering_by . ' , ' . $lastDocument->Engineering_on;
                        }

                        $history->action = 'CFT Review Complete';
                        
                        $history->current = $updateCFT->Engineering_by . ', ' . $updateCFT->Engineering_on;

                        $history->comment = $request->comment;
                        $history->user_id = Auth::user()->name;
                        $history->user_name = Auth::user()->name;
                        $history->change_to = "Not Applicable";
                        $history->change_from = $lastDocument->status;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->origin_state = $lastDocument->status;
                        $history->stage = 'CFT Review';

                        if (is_null($lastDocument->Engineering_by) || $lastDocument->Engineering_on == '') {
                            $history->action_name = 'New';
                        } else {
                            $history->action_name = 'Update';
                        }

                        $history->save();
                    }

                    if ($index == 7 && $cftUsers->$column == Auth::user()->id) {
                        $updateCFT->Human_Resource_by = Auth::user()->name;
                        $updateCFT->Human_Resource_on = Carbon::now()->format('Y-m-d');

                        $history = new QueryManagementAuditTrail();
                        $history->query_management_id = $id;
                        $history->activity_type = 'Human Resource By, Human Resource On';

                        if (is_null($lastDocument->Human_Resource_by) || $lastDocument->Human_Resource_on == '') {
                            $history->previous = "";
                        } else {
                            $history->previous = $lastDocument->Human_Resource_by . ' , ' . $lastDocument->Human_Resource_on;
                        }

                        $history->action = 'CFT Review Complete';
                        
                        $history->current = $updateCFT->Human_Resource_by . ', ' . $updateCFT->Human_Resource_on;

                        $history->comment = $request->comment;
                        $history->user_id = Auth::user()->name;
                        $history->user_name = Auth::user()->name;
                        $history->change_to = "Not Applicable";
                        $history->change_from = $lastDocument->status;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->origin_state = $lastDocument->status;
                        $history->stage = 'CFT Review';

                        if (is_null($lastDocument->Human_Resource_by) || $lastDocument->Human_Resource_on == '') {
                            $history->action_name = 'New';
                        } else {
                            $history->action_name = 'Update';
                        }

                        $history->save();
                    }

                    if ($index == 8 && $cftUsers->$column == Auth::user()->id) {
                        $updateCFT->Microbiology_by = Auth::user()->name;
                        $updateCFT->Microbiology_on = Carbon::now()->format('Y-m-d');

                        $history = new QueryManagementAuditTrail();
                        $history->query_management_id = $id;
                        $history->activity_type = 'Microbiology By, Microbiology On';

                        if (is_null($lastDocument->Microbiology_by) || $lastDocument->Microbiology_on == '') {
                            $history->previous = "";
                        } else {
                            $history->previous = $lastDocument->Microbiology_by . ' , ' . $lastDocument->Microbiology_on;
                        }

                        $history->action = 'CFT Review Complete';
                        
                        $history->current = $updateCFT->Microbiology_by . ', ' . $updateCFT->Microbiology_on;

                        $history->comment = $request->comment;
                        $history->user_id = Auth::user()->name;
                        $history->user_name = Auth::user()->name;
                        $history->change_to = "Not Applicable";
                        $history->change_from = $lastDocument->status;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->origin_state = $lastDocument->status;
                        $history->stage = 'CFT Review';

                        if (is_null($lastDocument->Microbiology_by) || $lastDocument->Microbiology_on == '') {
                            $history->action_name = 'New';
                        } else {
                            $history->action_name = 'Update';
                        }

                        $history->save();
                    }

                    if ($index == 9 && $cftUsers->$column == Auth::user()->id) {
                        $updateCFT->RegulatoryAffair_by = Auth::user()->name;
                        $updateCFT->RegulatoryAffair_on = Carbon::now()->format('Y-m-d');

                        $history = new QueryManagementAuditTrail();
                        $history->query_management_id = $id;
                        $history->activity_type = 'Regulatory Affair By, Regulatory Affair On';

                        if (is_null($lastDocument->RegulatoryAffair_by) || $lastDocument->RegulatoryAffair_on == '') {
                            $history->previous = "";
                        } else {
                            $history->previous = $lastDocument->RegulatoryAffair_by . ' , ' . $lastDocument->RegulatoryAffair_on;
                        }

                        $history->action = 'CFT Review Complete';
                        
                        $history->current = $updateCFT->RegulatoryAffair_by . ', ' . $updateCFT->RegulatoryAffair_on;

                        $history->comment = $request->comment;
                        $history->user_id = Auth::user()->name;
                        $history->user_name = Auth::user()->name;
                        $history->change_to = "Not Applicable";
                        $history->change_from = $lastDocument->status;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->origin_state = $lastDocument->status;
                        $history->stage = 'CFT Review';

                        if (is_null($lastDocument->RegulatoryAffair_by) || $lastDocument->RegulatoryAffair_on == '') {
                            $history->action_name = 'New';
                        } else {
                            $history->action_name = 'Update';
                        }

                        $history->save();
                    }

                    if ($index == 10 && $cftUsers->$column == Auth::user()->id) {
                        $updateCFT->Environment_Health_Safety_by = Auth::user()->name;
                        $updateCFT->Environment_Health_Safety_on = Carbon::now()->format('Y-m-d');

                        $history = new QueryManagementAuditTrail();
                        $history->query_management_id = $id;
                        $history->activity_type = 'Enviroment Health Safety By, Enviroment Health Safety On';

                        if (is_null($lastDocument->Environment_Health_Safety_by) || $lastDocument->Environment_Health_Safety_on == '') {
                            $history->previous = "";
                        } else {
                            $history->previous = $lastDocument->Environment_Health_Safety_by . ' , ' . $lastDocument->Environment_Health_Safety_on;
                        }

                        $history->action = 'CFT Review Complete';
                        
                        $history->current = $updateCFT->Environment_Health_Safety_by . ', ' . $updateCFT->Environment_Health_Safety_on;

                        $history->comment = $request->comment;
                        $history->user_id = Auth::user()->name;
                        $history->user_name = Auth::user()->name;
                        $history->change_to = "Not Applicable";
                        $history->change_from = $lastDocument->status;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->origin_state = $lastDocument->status;
                        $history->stage = 'CFT Review';

                        if (is_null($lastDocument->Environment_Health_Safety_by) || $lastDocument->Environment_Health_Safety_on == '') {
                            $history->action_name = 'New';
                        } else {
                            $history->action_name = 'Update';
                        }

                        $history->save();
                    }

                    if ($index == 11 && $cftUsers->$column == Auth::user()->id) {
                        $updateCFT->Information_Technology_by = Auth::user()->name;
                        $updateCFT->Information_Technology_on = Carbon::now()->format('Y-m-d');

                        $history = new QueryManagementAuditTrail();
                        $history->query_management_id = $id;
                        $history->activity_type = 'Information Technology By, Information Technology On';

                        if (is_null($lastDocument->Information_Technology_by) || $lastDocument->Information_Technology_on == '') {
                            $history->previous = "";
                        } else {
                            $history->previous = $lastDocument->Information_Technology_by . ' , ' . $lastDocument->Information_Technology_on;
                        }

                        $history->action = 'CFT Review Complete';
                        
                        $history->current = $updateCFT->Information_Technology_by . ', ' . $updateCFT->Information_Technology_on;

                        $history->comment = $request->comment;
                        $history->user_id = Auth::user()->name;
                        $history->user_name = Auth::user()->name;
                        $history->change_to = "Not Applicable";
                        $history->change_from = $lastDocument->status;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->origin_state = $lastDocument->status;
                        $history->stage = 'CFT Review';

                        if (is_null($lastDocument->Information_Technology_by) || $lastDocument->Information_Technology_on == '') {
                            $history->action_name = 'New';
                        } else {
                            $history->action_name = 'Update';
                        }

                        $history->save();
                    }

                    if ($index == 12 && $cftUsers->$column == Auth::user()->id) {
                        $updateCFT->ContractGiver_by = Auth::user()->name;
                        $updateCFT->ContractGiver_on = Carbon::now()->format('Y-m-d');

                        $history = new QueryManagementAuditTrail();
                        $history->query_management_id = $id;
                        $history->activity_type = 'Contract Giver By, Contract Giver On';

                        if (is_null($lastDocument->ContractGiver_by) || $lastDocument->ContractGiver_on == '') {
                            $history->previous = "";
                        } else {
                            $history->previous = $lastDocument->ContractGiver_by . ' , ' . $lastDocument->ContractGiver_on;
                        }

                        $history->action = 'CFT Review Complete';
                        
                        $history->current = $updateCFT->ContractGiver_by . ', ' . $updateCFT->ContractGiver_on;

                        $history->comment = $request->comment;
                        $history->user_id = Auth::user()->name;
                        $history->user_name = Auth::user()->name;
                        $history->change_to = "Not Applicable";
                        $history->change_from = $lastDocument->status;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->origin_state = $lastDocument->status;
                        $history->stage = 'CFT Review';

                        if (is_null($lastDocument->ContractGiver_by) || $lastDocument->ContractGiver_on == '') {
                            $history->action_name = 'New';
                        } else {
                            $history->action_name = 'Update';
                        }

                        $history->save();
                    }

                    if ($index == 13 && $cftUsers->$column == Auth::user()->id) {
                        $updateCFT->CorporateQualityAssurance_by = Auth::user()->name;
                        $updateCFT->CorporateQualityAssurance_on = Carbon::now()->format('Y-m-d');

                        $history = new QueryManagementAuditTrail();
                        $history->query_management_id = $id;
                        $history->activity_type = 'Corporate Quality Assurance By, Corporate Quality Assurance On';

                        if (is_null($lastDocument->CorporateQualityAssurance_by) || $lastDocument->CorporateQualityAssurance_on == '') {
                            $history->previous = "";
                        } else {
                            $history->previous = $lastDocument->CorporateQualityAssurance_by . ' , ' . $lastDocument->CorporateQualityAssurance_on;
                        }

                        $history->action = 'CFT Review Complete';
                        
                        $history->current = $updateCFT->CorporateQualityAssurance_by . ', ' . $updateCFT->CorporateQualityAssurance_on;

                        $history->comment = $request->comment;
                        $history->user_id = Auth::user()->name;
                        $history->user_name = Auth::user()->name;
                        $history->change_to = "Not Applicable";
                        $history->change_from = $lastDocument->status;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->origin_state = $lastDocument->status;
                        $history->stage = 'CFT Review';

                        if (is_null($lastDocument->CorporateQualityAssurance_by) || $lastDocument->CorporateQualityAssurance_on == '') {
                            $history->action_name = 'New';
                        } else {
                            $history->action_name = 'Update';
                        }

                        $history->save();
                    }

                    if($index == 14 && $cftUsers->$column == Auth::user()->id){
                        $updateCFT->Other1_by = Auth::user()->name;
                        $updateCFT->Other1_on = Carbon::now()->format('Y-m-d');
                        $history = new QueryManagementAuditTrail();
                        $history->query_management_id = $id;
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

                    if($index == 15 && $cftUsers->$column == Auth::user()->id){
                        $updateCFT->Other2_by = Auth::user()->name;
                        $updateCFT->Other2_on = Carbon::now()->format('Y-m-d');
                        $history = new QueryManagementAuditTrail();
                        $history->query_management_id = $id;
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

                    if($index == 16 && $cftUsers->$column == Auth::user()->id){
                        $updateCFT->Other3_by = Auth::user()->name;
                        $updateCFT->Other3_on = Carbon::now()->format('Y-m-d');
                        $history = new QueryManagementAuditTrail();
                        $history->query_management_id = $id;
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

                    if($index == 17 && $cftUsers->$column == Auth::user()->id){
                        $updateCFT->Other4_by = Auth::user()->name;
                        $updateCFT->Other4_on = Carbon::now()->format('Y-m-d');
                        $history = new QueryManagementAuditTrail();
                        $history->query_management_id = $id;
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

                    if($index == 18 && $cftUsers->$column == Auth::user()->id){
                        $updateCFT->Other5_by = Auth::user()->name;
                        $updateCFT->Other5_on = Carbon::now()->format('Y-m-d');
                        $history = new QueryManagementAuditTrail();
                        $history->query_management_id = $id;
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
                        $stage = new QueryManagementCftResponse();
                        $stage->query_management_id = $id;
                        $stage->cft_user_id = Auth::user()->id;
                        $stage->status = "Completed";
                        $stage->comment = $request->comments;
                        $stage->save();
                    } else {
                        $stage = new QueryManagementCftResponse();
                        $stage->query_management_id = $id;
                        $stage->cft_user_id = Auth::user()->id;
                        $stage->status = "In-progress";
                        $stage->comment = $request->comments;
                        $stage->save();
                    }
                }

                $checkCFTCount = QueryManagementCftResponse::withoutTrashed()->where(['status' => 'Completed', 'query_management_id' => $id])->count();
                $Cft = QueryManagementCft::withoutTrashed()->where('query_management_id', $id)->first();

                if (!$IsCFTRequired || $checkCFTCount) {
                        $queryManagement->stage = "7";
                        $queryManagement->status = "Pending Admin 2 Update";                
                        $queryManagement->cftCompleted_by = Auth::user()->name;
                        $queryManagement->cftCompleted_on = Carbon::now()->format('d-M-Y');
                        $queryManagement->cftCompleted_comment = $request->comments;

                        $history = new QueryManagementAuditTrail();
                        $history->query_management_id = $id;

                        $history->activity_type = 'CFT Review Complete By, CFT Review Complete On';
                        if (is_null($lastDocument->cftCompleted_by) || $lastDocument->cftCompleted_by === '') {
                            $history->previous = "NULL";
                        } else {
                            $history->previous = $lastDocument->cftCompleted_by . ' , ' . $lastDocument->cftCompleted_on;
                        }
                        $history->current = $queryManagement->cftCompleted_by . ' , ' . $queryManagement->cftCompleted_on;
                        if (is_null($lastDocument->cftCompleted_by) || $lastDocument->cftCompleted_on === '') {
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
                        $history->change_to = "Pending Admin 2 Update";
                        $history->change_from = $lastDocument->status;
                        $history->stage = 'Plan Proposed';
                        $history->save();
                        //  $list = Helpers::getHodUserList();
                        //     foreach ($list as $u) {
                        //         if($u->q_m_s_divisions_id == $queryManagement->division_id){
                        //             $email = Helpers::getInitiatorEmail($u->user_id);
                        //              if ($email !== null) {
                        //               Mail::send(
                        //                   'mail.view-mail',
                        //                    ['data' => $queryManagement],
                        //                 function ($message) use ($email) {
                        //                     $message->to($email)
                        //                         ->subject("Document is Send By".Auth::user()->name);
                        //                 }
                        //               );
                        //             }
                        //      }
                        //   }
                        $queryManagement->update();
                    }
                // Helpers::hodMail($queryManagement);
                toastr()->success('Sent Change Owner Update');
                return back();
            }

            if ($queryManagement->stage == 7) {
                $queryManagement->stage = "8";
                $queryManagement->status = "Pending Admin 1 Update";
                $queryManagement->Admin2UpdateComplete_by = Auth::user()->name;
                $queryManagement->Admin2UpdateComplete_on = Carbon::now()->format('d-M-Y');
                $queryManagement->Admin2UpdateComplete_comment = $request->comments;

                $history = new QueryManagementAuditTrail();
                $history->query_management_id = $id;
                $history->activity_type = 'Admin 2 Update Complete By, Admin 2 Update Complete On';
                if (is_null($lastDocument->Admin2UpdateComplete_by) || $lastDocument->Admin2UpdateComplete_by === '') {
                    $history->previous = "NULL";
                } else {
                    $history->previous = $lastDocument->Admin2UpdateComplete_by . ' , ' . $lastDocument->Admin2UpdateComplete_on;
                }
                $history->current = $queryManagement->Admin2UpdateComplete_by . ' , ' . $queryManagement->Admin2UpdateComplete_on;
                if (is_null($lastDocument->Admin2UpdateComplete_by) || $lastDocument->Admin2UpdateComplete_on === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->action = 'Admin 2 Update Complete';
                $history->comment = $request->comments;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to = "Pending Admin 1 Update";
                $history->change_from = $lastDocument->status;
                $history->stage = 'Plan Proposed';                    
                $history->save();

                $list = Helpers::getHodUserList($queryManagement->division_id);
                $userIds = collect($list)->pluck('user_id')->toArray();
                $users = User::whereIn('id', $userIds)->select('id', 'name', 'email')->get();


                foreach ($users as $userValue) {
                    DB::table('notifications')->insert([
                        'activity_id' => $queryManagement->id,
                        'activity_type' => "Notification",
                        'from_id' => Auth::user()->id,
                        'user_name' => $userValue->name,
                        'to_id' => $userValue->id,
                        'process_name' => "Query Management",
                        'division_id' => $queryManagement->division_id,
                        'short_description' => $queryManagement->short_description,
                        'initiator_id' => $queryManagement->initiator_id,
                        'due_date' => $queryManagement->due_date,
                        'record' => $queryManagement->record,
                        'site' => "Query Management",
                        'comment' => $request->comments,
                        'status' => $queryManagement->status,
                        'stage' => $queryManagement->stage,
                        'created_at' => Carbon::now(),
                    ]);
                }

                // foreach ($list as $u) {
                //     $email = Helpers::getUserEmail($u->user_id);
                //         if ($email !== null) {
                //         try {
                //             Mail::send(
                //                 'mail.view-mail',
                //                 ['data' => $queryManagement, 'site' => "CC", 'history' => "Submit", 'process' => 'Change Control', 'comment' => $request->comments, 'user' => Auth::user()->name],
                //                 function ($message) use ($email, $queryManagement) {
                //                     $message->to($email)
                //                     ->subject("IPC Notification: Change Control, Record #" . str_pad($queryManagement->record, 4, '0', STR_PAD_LEFT) . " - Activity: Submit Performed");
                //                 }
                //             );
                //         } catch(\Exception $e) {
                //             info('Error sending mail', [$e]);
                //         }
                //     }
                // }

                $queryManagement->update();
                toastr()->success('Sent to HOD Assessment');
                return back();
            }

            if ($queryManagement->stage == 8) {
                $queryManagement->stage = "9";
                $queryManagement->status = "Pending Response for Stakeholders";
                $queryManagement->Admin1UpdateComplete_by = Auth::user()->name;
                $queryManagement->Admin1UpdateComplete_on = Carbon::now()->format('d-M-Y');
                $queryManagement->Admin1UpdateComplete_comment = $request->comments;

                $history = new QueryManagementAuditTrail();
                $history->query_management_id = $id;
                $history->activity_type = 'Admin 1 Update Complete By, Admin 1 Update Complete On';
                if (is_null($lastDocument->Admin1UpdateComplete_by) || $lastDocument->Admin1UpdateComplete_by === '') {
                    $history->previous = "NULL";
                } else {
                    $history->previous = $lastDocument->Admin1UpdateComplete_by . ' , ' . $lastDocument->Admin1UpdateComplete_on;
                }
                $history->current = $queryManagement->Admin1UpdateComplete_by . ' , ' . $queryManagement->Admin1UpdateComplete_on;
                if (is_null($lastDocument->Admin1UpdateComplete_by) || $lastDocument->Admin1UpdateComplete_on === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->action = 'Admin 1 Update Complete';
                $history->comment = $request->comments;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to = "Pending Response for Stakeholders";
                $history->change_from = $lastDocument->status;
                $history->stage = 'Plan Proposed';                    
                $history->save();

                $list = Helpers::getHodUserList($queryManagement->division_id);
                $userIds = collect($list)->pluck('user_id')->toArray();
                $users = User::whereIn('id', $userIds)->select('id', 'name', 'email')->get();


                foreach ($users as $userValue) {
                    DB::table('notifications')->insert([
                        'activity_id' => $queryManagement->id,
                        'activity_type' => "Notification",
                        'from_id' => Auth::user()->id,
                        'user_name' => $userValue->name,
                        'to_id' => $userValue->id,
                        'process_name' => "Query Management",
                        'division_id' => $queryManagement->division_id,
                        'short_description' => $queryManagement->short_description,
                        'initiator_id' => $queryManagement->initiator_id,
                        'due_date' => $queryManagement->due_date,
                        'record' => $queryManagement->record,
                        'site' => "Query Management",
                        'comment' => $request->comments,
                        'status' => $queryManagement->status,
                        'stage' => $queryManagement->stage,
                        'created_at' => Carbon::now(),
                    ]);
                }

                // foreach ($list as $u) {
                //     $email = Helpers::getUserEmail($u->user_id);
                //         if ($email !== null) {
                //         try {
                //             Mail::send(
                //                 'mail.view-mail',
                //                 ['data' => $queryManagement, 'site' => "CC", 'history' => "Submit", 'process' => 'Change Control', 'comment' => $request->comments, 'user' => Auth::user()->name],
                //                 function ($message) use ($email, $queryManagement) {
                //                     $message->to($email)
                //                     ->subject("IPC Notification: Change Control, Record #" . str_pad($queryManagement->record, 4, '0', STR_PAD_LEFT) . " - Activity: Submit Performed");
                //                 }
                //             );
                //         } catch(\Exception $e) {
                //             info('Error sending mail', [$e]);
                //         }
                //     }
                // }

                $queryManagement->update();
                toastr()->success('Sent to HOD Assessment');
                return back();
            }

            if ($queryManagement->stage == 9) {
                $queryManagement->stage = "10";
                $queryManagement->status = "Pending Acknowledgement from Stakeholders";
                $queryManagement->responseSent_by = Auth::user()->name;
                $queryManagement->responseSent_on = Carbon::now()->format('d-M-Y');
                $queryManagement->responseSent_comment = $request->comments;

                $history = new QueryManagementAuditTrail();
                $history->query_management_id = $id;
                $history->activity_type = 'Response Sent By, Response Sent On';
                if (is_null($lastDocument->responseSent_by) || $lastDocument->responseSent_by === '') {
                    $history->previous = "NULL";
                } else {
                    $history->previous = $lastDocument->responseSent_by . ' , ' . $lastDocument->responseSent_on;
                }
                $history->current = $queryManagement->responseSent_by . ' , ' . $queryManagement->responseSent_on;
                if (is_null($lastDocument->responseSent_by) || $lastDocument->responseSent_on === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->action = 'Response Sent';
                $history->comment = $request->comments;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to = "Pending Acknowledgement from Stakeholders";
                $history->change_from = $lastDocument->status;
                $history->stage = 'Plan Proposed';                    
                $history->save();

                $list = Helpers::getHodUserList($queryManagement->division_id);
                $userIds = collect($list)->pluck('user_id')->toArray();
                $users = User::whereIn('id', $userIds)->select('id', 'name', 'email')->get();


                foreach ($users as $userValue) {
                    DB::table('notifications')->insert([
                        'activity_id' => $queryManagement->id,
                        'activity_type' => "Notification",
                        'from_id' => Auth::user()->id,
                        'user_name' => $userValue->name,
                        'to_id' => $userValue->id,
                        'process_name' => "Query Management",
                        'division_id' => $queryManagement->division_id,
                        'short_description' => $queryManagement->short_description,
                        'initiator_id' => $queryManagement->initiator_id,
                        'due_date' => $queryManagement->due_date,
                        'record' => $queryManagement->record,
                        'site' => "Query Management",
                        'comment' => $request->comments,
                        'status' => $queryManagement->status,
                        'stage' => $queryManagement->stage,
                        'created_at' => Carbon::now(),
                    ]);
                }

                // foreach ($list as $u) {
                //     $email = Helpers::getUserEmail($u->user_id);
                //         if ($email !== null) {
                //         try {
                //             Mail::send(
                //                 'mail.view-mail',
                //                 ['data' => $queryManagement, 'site' => "CC", 'history' => "Submit", 'process' => 'Change Control', 'comment' => $request->comments, 'user' => Auth::user()->name],
                //                 function ($message) use ($email, $queryManagement) {
                //                     $message->to($email)
                //                     ->subject("IPC Notification: Change Control, Record #" . str_pad($queryManagement->record, 4, '0', STR_PAD_LEFT) . " - Activity: Submit Performed");
                //                 }
                //             );
                //         } catch(\Exception $e) {
                //             info('Error sending mail', [$e]);
                //         }
                //     }
                // }

                $queryManagement->update();
                toastr()->success('Sent to HOD Assessment');
                return back();
            }

            if ($queryManagement->stage == 10) {
                $queryManagement->stage = "11";
                $queryManagement->status = "Closed - Done";
                $queryManagement->pendingAcknowledgementComplete_by = Auth::user()->name;
                $queryManagement->pendingAcknowledgementComplete_on = Carbon::now()->format('d-M-Y');
                $queryManagement->pendingAcknowledgementComplete_comment = $request->comments;

                $history = new QueryManagementAuditTrail();
                $history->query_management_id = $id;
                $history->activity_type = 'Pending Acknowledgement Received By, Pending Acknowledgement Received On';
                if (is_null($lastDocument->pendingAcknowledgementComplete_by) || $lastDocument->pendingAcknowledgementComplete_by === '') {
                    $history->previous = "NULL";
                } else {
                    $history->previous = $lastDocument->pendingAcknowledgementComplete_by . ' , ' . $lastDocument->pendingAcknowledgementComplete_on;
                }
                $history->current = $queryManagement->pendingAcknowledgementComplete_by . ' , ' . $queryManagement->pendingAcknowledgementComplete_on;
                if (is_null($lastDocument->pendingAcknowledgementComplete_by) || $lastDocument->pendingAcknowledgementComplete_on === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->action = 'Pending Acknowledgement Received';
                $history->comment = $request->comments;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to = "Closed - Done";
                $history->change_from = $lastDocument->status;
                $history->stage = 'Plan Proposed';                    
                $history->save();

                $list = Helpers::getHodUserList($queryManagement->division_id);
                $userIds = collect($list)->pluck('user_id')->toArray();
                $users = User::whereIn('id', $userIds)->select('id', 'name', 'email')->get();


                foreach ($users as $userValue) {
                    DB::table('notifications')->insert([
                        'activity_id' => $queryManagement->id,
                        'activity_type' => "Notification",
                        'from_id' => Auth::user()->id,
                        'user_name' => $userValue->name,
                        'to_id' => $userValue->id,
                        'process_name' => "Query Management",
                        'division_id' => $queryManagement->division_id,
                        'short_description' => $queryManagement->short_description,
                        'initiator_id' => $queryManagement->initiator_id,
                        'due_date' => $queryManagement->due_date,
                        'record' => $queryManagement->record,
                        'site' => "Query Management",
                        'comment' => $request->comments,
                        'status' => $queryManagement->status,
                        'stage' => $queryManagement->stage,
                        'created_at' => Carbon::now(),
                    ]);
                }

                // foreach ($list as $u) {
                //     $email = Helpers::getUserEmail($u->user_id);
                //         if ($email !== null) {
                //         try {
                //             Mail::send(
                //                 'mail.view-mail',
                //                 ['data' => $queryManagement, 'site' => "CC", 'history' => "Submit", 'process' => 'Change Control', 'comment' => $request->comments, 'user' => Auth::user()->name],
                //                 function ($message) use ($email, $queryManagement) {
                //                     $message->to($email)
                //                     ->subject("IPC Notification: Change Control, Record #" . str_pad($queryManagement->record, 4, '0', STR_PAD_LEFT) . " - Activity: Submit Performed");
                //                 }
                //             );
                //         } catch(\Exception $e) {
                //             info('Error sending mail', [$e]);
                //         }
                //     }
                // }

                $queryManagement->update();
                toastr()->success('Sent to HOD Assessment');
                return back();
            }

            if ($queryManagement->stage == 11) {
                $queryManagement->stage = "12";
                $queryManagement->status = "Pending Addendum Submission";
                $queryManagement->reopen_by = Auth::user()->name;
                $queryManagement->reopen_on = Carbon::now()->format('d-M-Y');
                $queryManagement->reopen_comment = $request->comments;

                $history = new QueryManagementAuditTrail();
                $history->query_management_id = $id;
                $history->activity_type = 'Reopen By, Reopen On';
                if (is_null($lastDocument->reopen_by) || $lastDocument->reopen_by === '') {
                    $history->previous = "NULL";
                } else {
                    $history->previous = $lastDocument->reopen_by . ' , ' . $lastDocument->reopen_on;
                }
                $history->current = $queryManagement->reopen_by . ' , ' . $queryManagement->reopen_on;
                if (is_null($lastDocument->reopen_by) || $lastDocument->reopen_on === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->action = 'Reopen';
                $history->comment = $request->comments;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to = "Pending Addendum Submission";
                $history->change_from = $lastDocument->status;
                $history->stage = 'Plan Proposed';                    
                $history->save();

                $list = Helpers::getHodUserList($queryManagement->division_id);
                $userIds = collect($list)->pluck('user_id')->toArray();
                $users = User::whereIn('id', $userIds)->select('id', 'name', 'email')->get();


                foreach ($users as $userValue) {
                    DB::table('notifications')->insert([
                        'activity_id' => $queryManagement->id,
                        'activity_type' => "Notification",
                        'from_id' => Auth::user()->id,
                        'user_name' => $userValue->name,
                        'to_id' => $userValue->id,
                        'process_name' => "Query Management",
                        'division_id' => $queryManagement->division_id,
                        'short_description' => $queryManagement->short_description,
                        'initiator_id' => $queryManagement->initiator_id,
                        'due_date' => $queryManagement->due_date,
                        'record' => $queryManagement->record,
                        'site' => "Query Management",
                        'comment' => $request->comments,
                        'status' => $queryManagement->status,
                        'stage' => $queryManagement->stage,
                        'created_at' => Carbon::now(),
                    ]);
                }

                // foreach ($list as $u) {
                //     $email = Helpers::getUserEmail($u->user_id);
                //         if ($email !== null) {
                //         try {
                //             Mail::send(
                //                 'mail.view-mail',
                //                 ['data' => $queryManagement, 'site' => "CC", 'history' => "Submit", 'process' => 'Change Control', 'comment' => $request->comments, 'user' => Auth::user()->name],
                //                 function ($message) use ($email, $queryManagement) {
                //                     $message->to($email)
                //                     ->subject("IPC Notification: Change Control, Record #" . str_pad($queryManagement->record, 4, '0', STR_PAD_LEFT) . " - Activity: Submit Performed");
                //                 }
                //             );
                //         } catch(\Exception $e) {
                //             info('Error sending mail', [$e]);
                //         }
                //     }
                // }

                $queryManagement->update();
                toastr()->success('Sent to HOD Assessment');
                return back();
            }
        } else {
            toastr()->error('E-signature Not match');
            return back();
        }
    }

    public function closedCancelled(Request $request, $id){
        
    }

    public function sendToInitiator(Request $request, $id)
    {
        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $queryManagement = QueryManagement::find($id);
            $lastDocument = QueryManagement::find($id);
            $cftResponse = QueryManagementCftResponse::withoutTrashed()->where(['query_management_id' => $id])->get();

            $queryManagement->stage = "1";
            $queryManagement->status = "Opened";
            $queryManagement->sentToInitiator_by = Auth::user()->name;
            $queryManagement->sentToInitiator_on = Carbon::now()->format('d-M-Y');
            $queryManagement->sentToInitiator_comment = $request->comments;
        
            $history = new QueryManagementAuditTrail();
            $history->query_management_id = $id;
            
            $history->activity_type = 'Send To Initiator By, Send To Initiator On';
            if (is_null($lastDocument->sentToInitiator_by) || $lastDocument->sentToInitiator_by === '') {
                $history->previous = "NULL";
            } else {
                $history->previous = $lastDocument->sentToInitiator_by . ' , ' . $lastDocument->sentToInitiator_on;
            }
            $history->current = $queryManagement->sentToInitiator_by . ' , ' . $queryManagement->sentToInitiator_on;
            if (is_null($lastDocument->sentToInitiator_by) || $lastDocument->sentToInitiator_on === '') {
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
            $queryManagement->update();
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
            toastr()->success('Document Sent');
            return back();

        } else {
            toastr()->error('E-signature Not match');
            return back();
        }
    }

    public function sendToHOD(Request $request, $id){
        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $queryManagement = QueryManagement::find($id);
            $lastDocument = QueryManagement::find($id);
            $cftResponse = QueryManagementCftResponse::withoutTrashed()->where(['query_management_id' => $id])->get();

            $queryManagement->stage = "5";
            $queryManagement->status = "Pending HOD Review";
            $queryManagement->sentToHOD = Auth::user()->name;
            $queryManagement->sentToHOD_on = Carbon::now()->format('d-M-Y');
            $queryManagement->sentToHOD_comment = $request->comments;
        
            $history = new QueryManagementAuditTrail();
            $history->query_management_id = $id;
            
            $history->activity_type = 'Send To HOD By, Send To HOD On';
            if (is_null($lastDocument->sentToHOD) || $lastDocument->sentToHOD === '') {
                $history->previous = "NULL";
            } else {
                $history->previous = $lastDocument->sentToHOD . ' , ' . $lastDocument->sentToHOD_on;
            }
            $history->current = $queryManagement->sentToHOD . ' , ' . $queryManagement->sentToHOD_on;
            if (is_null($lastDocument->sentToHOD) || $lastDocument->sentToHOD_on === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->action = 'Pending HOD Review';
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Opened";
            $history->change_from = $lastDocument->status;        
            $history->save();
            $queryManagement->update();
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
            toastr()->success('Document Sent');
            return back();

        } else {
            toastr()->error('E-signature Not match');
            return back();
        }
    }

    public function sendToAdmin1(Request $request, $id){
        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $queryManagement = QueryManagement::find($id);
            $lastDocument = QueryManagement::find($id);
            $cftResponse = QueryManagementCftResponse::withoutTrashed()->where(['query_management_id' => $id])->get();

            $queryManagement->stage = "5";
            $queryManagement->status = "Pending HOD Review";
            $queryManagement->sentToAdmin1_by = Auth::user()->name;
            $queryManagement->sentToAdmin1_on = Carbon::now()->format('d-M-Y');
            $queryManagement->sentToAdmin1_comment = $request->comments;
        
            $history = new QueryManagementAuditTrail();
            $history->query_management_id = $id;
            
            $history->activity_type = 'Send To HOD By, Send To HOD On';
            if (is_null($lastDocument->sentToAdmin1_by) || $lastDocument->sentToAdmin1_by === '') {
                $history->previous = "NULL";
            } else {
                $history->previous = $lastDocument->sentToAdmin1_by . ' , ' . $lastDocument->sentToAdmin1_on;
            }
            $history->current = $queryManagement->sentToAdmin1_by . ' , ' . $queryManagement->sentToAdmin1_on;
            if (is_null($lastDocument->sentToAdmin1_by) || $lastDocument->sentToAdmin1_on === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->action = 'Pending HOD Review';
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Opened";
            $history->change_from = $lastDocument->status;        
            $history->save();
            $queryManagement->update();
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
            toastr()->success('Document Sent');
            return back();

        } else {
            toastr()->error('E-signature Not match');
            return back();
        }
    }

    public function stageReject(Request $request, $id){
        if($request->username == Auth::user()->Username && Hash::check($request->password, Auth::user()->password)) {
            $queryManagement = QueryManagement::find($id);            
            $lastDocument = QueryManagement::find($id);

            if ($queryManagement->stage == 9) {
                $queryManagement->stage = "8";
                $queryManagement->status = "Pending Admin 1 Update";
                $queryManagement->pendingResponseToAdmin1_by = Auth::user()->name;
                $queryManagement->pendingResponseToAdmin1_on = Carbon::now()->format('d-M-Y');
                $queryManagement->pendingResponseToAdmin1_comment = $request->comments;

                $history = new QueryManagementAuditTrail();
                $history->query_management_id = $id;
                $history->activity_type = 'Required More Information By, Required More Information On';
                if (is_null($lastDocument->pendingResponseToAdmin1_by) || $lastDocument->pendingResponseToAdmin1_by === '') {
                    $history->previous = "NULL";
                } else {
                    $history->previous = $lastDocument->pendingResponseToAdmin1_by . ' , ' . $lastDocument->pendingResponseToAdmin1_on;
                }
                $history->current = $queryManagement->pendingResponseToAdmin1_by . ' , ' . $queryManagement->pendingResponseToAdmin1_on;
                if (is_null($lastDocument->pendingResponseToAdmin1_by) || $lastDocument->pendingResponseToAdmin1_on === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->action = 'Required More Information';
                $history->comment = $request->comments;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to = "Pending Admin 1 Update";
                $history->change_from = $lastDocument->status;
                $history->stage = 'Plan Proposed';                    
                $history->save();

                $list = Helpers::getHodUserList($queryManagement->division_id);
                $userIds = collect($list)->pluck('user_id')->toArray();
                $users = User::whereIn('id', $userIds)->select('id', 'name', 'email')->get();

                foreach ($users as $userValue) {
                    DB::table('notifications')->insert([
                        'activity_id' => $queryManagement->id,
                        'activity_type' => "Notification",
                        'from_id' => Auth::user()->id,
                        'user_name' => $userValue->name,
                        'to_id' => $userValue->id,
                        'process_name' => "Query Management",
                        'division_id' => $queryManagement->division_id,
                        'short_description' => $queryManagement->short_description,
                        'initiator_id' => $queryManagement->initiator_id,
                        'due_date' => $queryManagement->due_date,
                        'record' => $queryManagement->record,
                        'site' => "Query Management",
                        'comment' => $request->comments,
                        'status' => $queryManagement->status,
                        'stage' => $queryManagement->stage,
                        'created_at' => Carbon::now(),
                    ]);
                }

                // foreach ($list as $u) {
                //     $email = Helpers::getUserEmail($u->user_id);
                //         if ($email !== null) {
                //         try {
                //             Mail::send(
                //                 'mail.view-mail',
                //                 ['data' => $queryManagement, 'site' => "CC", 'history' => "Submit", 'process' => 'Change Control', 'comment' => $request->comments, 'user' => Auth::user()->name],
                //                 function ($message) use ($email, $queryManagement) {
                //                     $message->to($email)
                //                     ->subject("IPC Notification: Change Control, Record #" . str_pad($queryManagement->record, 4, '0', STR_PAD_LEFT) . " - Activity: Submit Performed");
                //                 }
                //             );
                //         } catch(\Exception $e) {
                //             info('Error sending mail', [$e]);
                //         }
                //     }
                // }

                $queryManagement->update();
                toastr()->success('Sent to Pending Admin 1 Update');
                return back();

            }
            if ($queryManagement->stage == 8) {
                $queryManagement->stage = "7";
                $queryManagement->status = "Pending Admin 2 Update";
                $queryManagement->pendingAdmin1ToAdmin2_by = Auth::user()->name;
                $queryManagement->pendingAdmin1ToAdmin2_on = Carbon::now()->format('d-M-Y');
                $queryManagement->pendingAdmin1ToAdmin2_comment = $request->comments;

                $history = new QueryManagementAuditTrail();
                $history->query_management_id = $id;
                $history->activity_type = 'More Information Required By, More Information Required On';
                if (is_null($lastDocument->pendingAdmin1ToAdmin2_by) || $lastDocument->pendingAdmin1ToAdmin2_by === '') {
                    $history->previous = "NULL";
                } else {
                    $history->previous = $lastDocument->pendingAdmin1ToAdmin2_by . ' , ' . $lastDocument->pendingAdmin1ToAdmin2_on;
                }
                $history->current = $queryManagement->pendingAdmin1ToAdmin2_by . ' , ' . $queryManagement->pendingAdmin1ToAdmin2_on;
                if (is_null($lastDocument->pendingAdmin1ToAdmin2_by) || $lastDocument->pendingAdmin1ToAdmin2_on === '') {
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
                $history->change_to = "Pending Admin 2 Update";
                $history->change_from = $lastDocument->status;
                $history->stage = 'Plan Proposed';                    
                $history->save();

                $list = Helpers::getHodUserList($queryManagement->division_id);
                $userIds = collect($list)->pluck('user_id')->toArray();
                $users = User::whereIn('id', $userIds)->select('id', 'name', 'email')->get();


                foreach ($users as $userValue) {
                    DB::table('notifications')->insert([
                        'activity_id' => $queryManagement->id,
                        'activity_type' => "Notification",
                        'from_id' => Auth::user()->id,
                        'user_name' => $userValue->name,
                        'to_id' => $userValue->id,
                        'process_name' => "Query Management",
                        'division_id' => $queryManagement->division_id,
                        'short_description' => $queryManagement->short_description,
                        'initiator_id' => $queryManagement->initiator_id,
                        'due_date' => $queryManagement->due_date,
                        'record' => $queryManagement->record,
                        'site' => "Query Management",
                        'comment' => $request->comments,
                        'status' => $queryManagement->status,
                        'stage' => $queryManagement->stage,
                        'created_at' => Carbon::now(),
                    ]);
                }

                // foreach ($list as $u) {
                //     $email = Helpers::getUserEmail($u->user_id);
                //         if ($email !== null) {
                //         try {
                //             Mail::send(
                //                 'mail.view-mail',
                //                 ['data' => $queryManagement, 'site' => "CC", 'history' => "Submit", 'process' => 'Change Control', 'comment' => $request->comments, 'user' => Auth::user()->name],
                //                 function ($message) use ($email, $queryManagement) {
                //                     $message->to($email)
                //                     ->subject("IPC Notification: Change Control, Record #" . str_pad($queryManagement->record, 4, '0', STR_PAD_LEFT) . " - Activity: Submit Performed");
                //                 }
                //             );
                //         } catch(\Exception $e) {
                //             info('Error sending mail', [$e]);
                //         }
                //     }
                // }

                $queryManagement->update();
                toastr()->success('Sent to Pending Admin 2 Update');
                return back();
            }
            if ($queryManagement->stage == 6) {
                $queryManagement->stage = "5";
                $queryManagement->status = "Pending HOD Review";
                $queryManagement->pendingCftToPendingHod_by = Auth::user()->name;
                $queryManagement->pendingCftToPendingHod_on = Carbon::now()->format('d-M-Y');
                $queryManagement->pendingCftToPendingHod_comment = $request->comments;

                $history = new QueryManagementAuditTrail();


                $history->query_management_id = $id;
                $history->activity_type = 'More Information Required By, More Information Required On';
                if (is_null($lastDocument->pendingCftToPendingHod_by) || $lastDocument->pendingCftToPendingHod_by === '') {
                    $history->previous = "NULL";
                } else {
                    $history->previous = $lastDocument->pendingCftToPendingHod_by . ' , ' . $lastDocument->pendingCftToPendingHod_on;
                }
                $history->current = $queryManagement->pendingCftToPendingHod_by . ' , ' . $queryManagement->pendingCftToPendingHod_on;
                if (is_null($lastDocument->pendingCftToPendingHod_by) || $lastDocument->pendingCftToPendingHod_on === '') {
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
                $history->change_to = "Pending HOD Review";
                $history->change_from = $lastDocument->status;
                $history->stage = 'Plan Proposed';                    
                $history->save();

                $list = Helpers::getHodUserList($queryManagement->division_id);
                $userIds = collect($list)->pluck('user_id')->toArray();
                $users = User::whereIn('id', $userIds)->select('id', 'name', 'email')->get();


                foreach ($users as $userValue) {
                    DB::table('notifications')->insert([
                        'activity_id' => $queryManagement->id,
                        'activity_type' => "Notification",
                        'from_id' => Auth::user()->id,
                        'user_name' => $userValue->name,
                        'to_id' => $userValue->id,
                        'process_name' => "Query Management",
                        'division_id' => $queryManagement->division_id,
                        'short_description' => $queryManagement->short_description,
                        'initiator_id' => $queryManagement->initiator_id,
                        'due_date' => $queryManagement->due_date,
                        'record' => $queryManagement->record,
                        'site' => "Query Management",
                        'comment' => $request->comments,
                        'status' => $queryManagement->status,
                        'stage' => $queryManagement->stage,
                        'created_at' => Carbon::now(),
                    ]);
                }

                // foreach ($list as $u) {
                //     $email = Helpers::getUserEmail($u->user_id);
                //         if ($email !== null) {
                //         try {
                //             Mail::send(
                //                 'mail.view-mail',
                //                 ['data' => $queryManagement, 'site' => "CC", 'history' => "Submit", 'process' => 'Change Control', 'comment' => $request->comments, 'user' => Auth::user()->name],
                //                 function ($message) use ($email, $queryManagement) {
                //                     $message->to($email)
                //                     ->subject("IPC Notification: Change Control, Record #" . str_pad($queryManagement->record, 4, '0', STR_PAD_LEFT) . " - Activity: Submit Performed");
                //                 }
                //             );
                //         } catch(\Exception $e) {
                //             info('Error sending mail', [$e]);
                //         }
                //     }
                // }

                $queryManagement->update();
                toastr()->success('Sent to HOD Assessment');
                return back();
            }
            if ($queryManagement->stage == 5) {
                $queryManagement->stage = "3";
                $queryManagement->status = "Pending Acknowledgement from Admin 2";
                $queryManagement->pendingHodToPendingAck_by = Auth::user()->name;
                $queryManagement->pendingHodToPendingAck_on = Carbon::now()->format('d-M-Y');
                $queryManagement->pendingHodToPendingAck_comment = $request->comments;

                $history = new QueryManagementAuditTrail();
                $history->query_management_id = $id;
                $history->activity_type = 'More Information Required By, More Information Required On';
                if (is_null($lastDocument->pendingHodToPendingAck_by) || $lastDocument->pendingHodToPendingAck_by === '') {
                    $history->previous = "NULL";
                } else {
                    $history->previous = $lastDocument->pendingHodToPendingAck_by . ' , ' . $lastDocument->pendingHodToPendingAck_on;
                }
                $history->current = $queryManagement->pendingHodToPendingAck_by . ' , ' . $queryManagement->pendingHodToPendingAck_on;
                if (is_null($lastDocument->pendingHodToPendingAck_by) || $lastDocument->pendingHodToPendingAck_on === '') {
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
                $history->change_to = "Pending Acknowledgement from Admin 2";
                $history->change_from = $lastDocument->status;
                $history->stage = 'Plan Proposed';                    
                $history->save();

                $list = Helpers::getHodUserList($queryManagement->division_id);
                $userIds = collect($list)->pluck('user_id')->toArray();
                $users = User::whereIn('id', $userIds)->select('id', 'name', 'email')->get();


                foreach ($users as $userValue) {
                    DB::table('notifications')->insert([
                        'activity_id' => $queryManagement->id,
                        'activity_type' => "Notification",
                        'from_id' => Auth::user()->id,
                        'user_name' => $userValue->name,
                        'to_id' => $userValue->id,
                        'process_name' => "Query Management",
                        'division_id' => $queryManagement->division_id,
                        'short_description' => $queryManagement->short_description,
                        'initiator_id' => $queryManagement->initiator_id,
                        'due_date' => $queryManagement->due_date,
                        'record' => $queryManagement->record,
                        'site' => "Query Management",
                        'comment' => $request->comments,
                        'status' => $queryManagement->status,
                        'stage' => $queryManagement->stage,
                        'created_at' => Carbon::now(),
                    ]);
                }

                // foreach ($list as $u) {
                //     $email = Helpers::getUserEmail($u->user_id);
                //         if ($email !== null) {
                //         try {
                //             Mail::send(
                //                 'mail.view-mail',
                //                 ['data' => $queryManagement, 'site' => "CC", 'history' => "Submit", 'process' => 'Change Control', 'comment' => $request->comments, 'user' => Auth::user()->name],
                //                 function ($message) use ($email, $queryManagement) {
                //                     $message->to($email)
                //                     ->subject("IPC Notification: Change Control, Record #" . str_pad($queryManagement->record, 4, '0', STR_PAD_LEFT) . " - Activity: Submit Performed");
                //                 }
                //             );
                //         } catch(\Exception $e) {
                //             info('Error sending mail', [$e]);
                //         }
                //     }
                // }

                $queryManagement->update();
                toastr()->success('Sent to HOD Assessment');
                return back();
            }
            if ($queryManagement->stage == 3) {
                $queryManagement->stage = "2";
                $queryManagement->status = "Pending Query Review";
                $queryManagement->pendingAckToPendingQuery_by = Auth::user()->name;
                $queryManagement->pendingAckToPendingQuery_on = Carbon::now()->format('d-M-Y');
                $queryManagement->pendingAckToPendingQuery_comment = $request->comments;

                $history = new QueryManagementAuditTrail();
                $history->query_management_id = $id;
                $history->activity_type = 'More Information Required By, More Information Required On';
                if (is_null($lastDocument->pendingAckToPendingQuery_by) || $lastDocument->pendingAckToPendingQuery_by === '') {
                    $history->previous = "NULL";
                } else {
                    $history->previous = $lastDocument->pendingAckToPendingQuery_by . ' , ' . $lastDocument->pendingAckToPendingQuery_on;
                }
                $history->current = $queryManagement->pendingAckToPendingQuery_by . ' , ' . $queryManagement->pendingAckToPendingQuery_on;
                if (is_null($lastDocument->pendingAckToPendingQuery_by) || $lastDocument->pendingAckToPendingQuery_on === '') {
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
                $history->change_to = "Pending Query Review";
                $history->change_from = $lastDocument->status;
                $history->stage = 'Plan Proposed';                    
                $history->save();

                $list = Helpers::getHodUserList($queryManagement->division_id);
                $userIds = collect($list)->pluck('user_id')->toArray();
                $users = User::whereIn('id', $userIds)->select('id', 'name', 'email')->get();


                foreach ($users as $userValue) {
                    DB::table('notifications')->insert([
                        'activity_id' => $queryManagement->id,
                        'activity_type' => "Notification",
                        'from_id' => Auth::user()->id,
                        'user_name' => $userValue->name,
                        'to_id' => $userValue->id,
                        'process_name' => "Query Management",
                        'division_id' => $queryManagement->division_id,
                        'short_description' => $queryManagement->short_description,
                        'initiator_id' => $queryManagement->initiator_id,
                        'due_date' => $queryManagement->due_date,
                        'record' => $queryManagement->record,
                        'site' => "Query Management",
                        'comment' => $request->comments,
                        'status' => $queryManagement->status,
                        'stage' => $queryManagement->stage,
                        'created_at' => Carbon::now(),
                    ]);
                }

                // foreach ($list as $u) {
                //     $email = Helpers::getUserEmail($u->user_id);
                //         if ($email !== null) {
                //         try {
                //             Mail::send(
                //                 'mail.view-mail',
                //                 ['data' => $queryManagement, 'site' => "CC", 'history' => "Submit", 'process' => 'Change Control', 'comment' => $request->comments, 'user' => Auth::user()->name],
                //                 function ($message) use ($email, $queryManagement) {
                //                     $message->to($email)
                //                     ->subject("IPC Notification: Change Control, Record #" . str_pad($queryManagement->record, 4, '0', STR_PAD_LEFT) . " - Activity: Submit Performed");
                //                 }
                //             );
                //         } catch(\Exception $e) {
                //             info('Error sending mail', [$e]);
                //         }
                //     }
                // }

                $queryManagement->update();
                toastr()->success('Sent to Pending Query Review');
                return back();
            }
            if ($queryManagement->stage == 2) {
                $queryManagement->stage = "1";
                $queryManagement->status = "Opened";
                $queryManagement->pendingQueryReviewToOpened_by = Auth::user()->name;
                $queryManagement->pendingQueryReviewToOpened_on = Carbon::now()->format('d-M-Y');
                $queryManagement->pendingQueryReviewToOpened_comment = $request->comments;

                $history = new QueryManagementAuditTrail();
                $history->query_management_id = $id;
                $history->activity_type = 'More Information Required By, More Information Required On';
                if (is_null($lastDocument->pendingQueryReviewToOpened_by) || $lastDocument->pendingQueryReviewToOpened_by === '') {
                    $history->previous = "NULL";
                } else {
                    $history->previous = $lastDocument->pendingQueryReviewToOpened_by . ' , ' . $lastDocument->pendingQueryReviewToOpened_on;
                }
                $history->current = $queryManagement->pendingQueryReviewToOpened_by . ' , ' . $queryManagement->pendingQueryReviewToOpened_on;
                if (is_null($lastDocument->pendingQueryReviewToOpened_by) || $lastDocument->pendingQueryReviewToOpened_on === '') {
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
                $history->change_to = "Opened";
                $history->change_from = $lastDocument->status;
                $history->stage = 'Plan Proposed';                    
                $history->save();

                $list = Helpers::getHodUserList($queryManagement->division_id);
                $userIds = collect($list)->pluck('user_id')->toArray();
                $users = User::whereIn('id', $userIds)->select('id', 'name', 'email')->get();


                foreach ($users as $userValue) {
                    DB::table('notifications')->insert([
                        'activity_id' => $queryManagement->id,
                        'activity_type' => "Notification",
                        'from_id' => Auth::user()->id,
                        'user_name' => $userValue->name,
                        'to_id' => $userValue->id,
                        'process_name' => "Query Management",
                        'division_id' => $queryManagement->division_id,
                        'short_description' => $queryManagement->short_description,
                        'initiator_id' => $queryManagement->initiator_id,
                        'due_date' => $queryManagement->due_date,
                        'record' => $queryManagement->record,
                        'site' => "Query Management",
                        'comment' => $request->comments,
                        'status' => $queryManagement->status,
                        'stage' => $queryManagement->stage,
                        'created_at' => Carbon::now(),
                    ]);
                }

                // foreach ($list as $u) {
                //     $email = Helpers::getUserEmail($u->user_id);
                //         if ($email !== null) {
                //         try {
                //             Mail::send(
                //                 'mail.view-mail',
                //                 ['data' => $queryManagement, 'site' => "CC", 'history' => "Submit", 'process' => 'Change Control', 'comment' => $request->comments, 'user' => Auth::user()->name],
                //                 function ($message) use ($email, $queryManagement) {
                //                     $message->to($email)
                //                     ->subject("IPC Notification: Change Control, Record #" . str_pad($queryManagement->record, 4, '0', STR_PAD_LEFT) . " - Activity: Submit Performed");
                //                 }
                //             );
                //         } catch(\Exception $e) {
                //             info('Error sending mail', [$e]);
                //         }
                //     }
                // }

                $queryManagement->update();
                toastr()->success('Sent to Opened');
                return back();
            }

            if ($queryManagement->stage == 1) {
                $queryManagement->stage = "0";
                $queryManagement->status = "Closed - Cancelled";
                $queryManagement->cancelled_by = Auth::user()->name;
                $queryManagement->cancelled_on = Carbon::now()->format('d-M-Y');
                $queryManagement->cancelled_comment = $request->comments;

                $history = new QueryManagementAuditTrail();
                $history->query_management_id = $id;
                $history->activity_type = 'Cancel By, Cancel On';
                if (is_null($lastDocument->cancelled_by) || $lastDocument->cancelled_by === '') {
                    $history->previous = "NULL";
                } else {
                    $history->previous = $lastDocument->cancelled_by . ' , ' . $lastDocument->cancelled_on;
                }
                $history->current = $queryManagement->cancelled_by . ' , ' . $queryManagement->cancelled_on;
                if (is_null($lastDocument->cancelled_by) || $lastDocument->cancelled_on === '') {
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
                $history->change_to = "Closed - Cancelled";
                $history->change_from = $lastDocument->status;
                $history->stage = 'Plan Proposed';                    
                $history->save();

                $list = Helpers::getHodUserList($queryManagement->division_id);
                $userIds = collect($list)->pluck('user_id')->toArray();
                $users = User::whereIn('id', $userIds)->select('id', 'name', 'email')->get();


                foreach ($users as $userValue) {
                    DB::table('notifications')->insert([
                        'activity_id' => $queryManagement->id,
                        'activity_type' => "Notification",
                        'from_id' => Auth::user()->id,
                        'user_name' => $userValue->name,
                        'to_id' => $userValue->id,
                        'process_name' => "Query Management",
                        'division_id' => $queryManagement->division_id,
                        'short_description' => $queryManagement->short_description,
                        'initiator_id' => $queryManagement->initiator_id,
                        'due_date' => $queryManagement->due_date,
                        'record' => $queryManagement->record,
                        'site' => "Query Management",
                        'comment' => $request->comments,
                        'status' => $queryManagement->status,
                        'stage' => $queryManagement->stage,
                        'created_at' => Carbon::now(),
                    ]);
                }

                // foreach ($list as $u) {
                //     $email = Helpers::getUserEmail($u->user_id);
                //         if ($email !== null) {
                //         try {
                //             Mail::send(
                //                 'mail.view-mail',
                //                 ['data' => $queryManagement, 'site' => "CC", 'history' => "Submit", 'process' => 'Change Control', 'comment' => $request->comments, 'user' => Auth::user()->name],
                //                 function ($message) use ($email, $queryManagement) {
                //                     $message->to($email)
                //                     ->subject("IPC Notification: Change Control, Record #" . str_pad($queryManagement->record, 4, '0', STR_PAD_LEFT) . " - Activity: Submit Performed");
                //                 }
                //             );
                //         } catch(\Exception $e) {
                //             info('Error sending mail', [$e]);
                //         }
                //     }
                // }

                $queryManagement->update();
                toastr()->success('Sent to Closed - Cancelled');
                return back();
            }
        } else {
            toastr()->error('E-signature Not match');
            return back();
        }
    }

    public function cftNotRequired(Request $request, $id){
        
    }

    public function actionItemChild(Request $request, $id)
    {
        $queryManagement = QueryManagement::find($id);
        $parent_id = $id;
        $parent_type = "Query Management";
        $record_number = ((RecordNumber::first()->value('counter')) + 1);
        $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
        $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $due_date = $formattedDate->format('d-M-Y');         

        $queryManagement->originator = User::where('id', $queryManagement->initiator_id)->value('name');
        return view('frontend.action-item.action-item', compact('parent_id', 'parent_type', 'queryManagement'));
    }
}
