<?php

namespace App\Http\Controllers\rcms;

use App\Http\Controllers\Controller;
use App\Models\RecordNumber;
use Illuminate\Http\Request;
use App\Models\InternalAudit;
use App\Models\{InternalAuditTrial,IA_checklist_tablet_compression,IA_checklist_tablet_coating,Checklist_Capsule, IA_checklist__formulation_research, IA_checklist_analytical_research, IA_checklist_dispensing, IA_checklist_engineering, IA_checklist_hr, IA_checklist_manufacturing_filling, IA_checklist_production_injection, IA_checklist_stores, IA_dispencing_manufacturing, IA_liquid_ointment, IA_ointment_paking, IA_quality_control, InternalAuditChecklistGrid};
use App\Models\{IA_checklist_capsule_paking};
use App\Models\RoleGroup;
use App\Models\InternalAuditGrid;
use App\Models\InternalAuditorGrid;
use App\Models\InternalAuditObservationGrid;
use App\Models\InternalAuditStageHistory;
use App\Models\User;
use App\Models\IA_checklist_compression;
use PDF;
use Helpers;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\NotificationUser;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;


class InternalauditController extends Controller
{
    public function internal_audit()
    {
        $old_record = InternalAudit::select('id', 'division_id', 'record')->get();
        $record_number = ((RecordNumber::first()->value('counter')) + 1);
        $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
        $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $due_date = $formattedDate->format('Y-m-d');
        // return $old_record;

        return view("frontend.forms.audit", compact('due_date', 'record_number', 'old_record'));

    }
    public function create(request $request)
    {
        // dd($request->all());
        // return "breaking";
       $internalAudit = new InternalAudit();
        $internalAudit->form_type = "Internal-audit";
        $internalAudit->record = ((RecordNumber::first()->value('counter')) + 1);
        $internalAudit->initiator_id = Auth::user()->id;
        $internalAudit->division_id = $request->division_id;
        $internalAudit->external_agencies = $request->external_agencies;
       // $internalAudit->severity_level = $request->severity_level_select;
       $internalAudit->severity_level_form = $request->severity_level_form;
        $internalAudit->division_code = $request->division_code;
        $internalAudit->parent_id = $request->parent_id;
        $internalAudit->parent_type = $request->parent_type;
        $internalAudit->intiation_date = $request->intiation_date;
        $internalAudit->assign_to = $request->assign_to;
        $internalAudit->due_date = $request->due_date;
        $internalAudit->audit_schedule_start_date= $request->audit_schedule_start_date;
        $internalAudit->audit_schedule_end_date= $request->audit_schedule_end_date;
        $internalAudit->initiator_Group= $request->initiator_Group;
        $internalAudit->initiator_group_code= $request->initiator_group_code;
        $internalAudit->short_description = $request->short_description;
        $internalAudit->audit_type = $request->audit_type;
        $internalAudit->if_other = $request->if_other;
        $internalAudit->initiated_through = $request->initiated_through;
        $internalAudit->initiated_if_other = $request->initiated_if_other;
        $internalAudit->repeat = $request->repeat;
        $internalAudit->repeat_nature = $request->repeat_nature;
        $internalAudit->due_date_extension = $request->due_date_extension;
        $internalAudit->initial_comments = $request->initial_comments;
        $internalAudit->start_date = $request->start_date;
        $internalAudit->end_date = $request->end_date;
        $internalAudit->External_Auditing_Agency= $request->External_Auditing_Agency;
        $internalAudit->Relevant_Guideline= $request->Relevant_Guideline;
        $internalAudit->QA_Comments= $request->QA_Comments;
        $internalAudit->Others= $request->Others;
        // $internalAudit->file_attachment_guideline = $request->file_attachment_guideline;
        $internalAudit->Audit_Category= $request->Audit_Category;

        $internalAudit->Supplier_Details= $request->Supplier_Details;
        $internalAudit->Supplier_Site= $request->Supplier_Site;
        //$internalAudit->Facility =  implode(',', $request->Facility);
        //$internalAudit->Group = implode(',', $request->Group);
        $internalAudit->material_name = $request->material_name;
        $internalAudit->if_comments = $request->if_comments;
        $internalAudit->lead_auditor = $request->lead_auditor;
        $internalAudit->Audit_team =  implode(',', $request->Audit_team);
        $internalAudit->Auditee =  implode(',', $request->Auditee);
        $internalAudit->Auditor_Details = $request->Auditor_Details;
        $internalAudit->Comments = $request->Comments;
        $internalAudit->Audit_Comments1 = $request->Audit_Comments1;
        $internalAudit->Remarks = $request->Remarks;
        $internalAudit->refrence_record=  implode(',', $request->refrence_record);
        $internalAudit->Audit_Comments2 = $request->Audit_Comments2;
        $internalAudit->due_date = $request->due_date;
        $internalAudit->audit_start_date= $request->audit_start_date;

        $internalAudit->audit_end_date = $request->audit_end_date;
        // $internalAudit->external_others=$request->external_others;
        $internalAudit->response_1 = $request->response_1;
        $internalAudit->response_2 = $request->response_2;
        $internalAudit->response_3 = $request->response_3;
        $internalAudit->response_4 = $request->response_4;
        $internalAudit->response_5 = $request->response_5;
        $internalAudit->response_6 = $request->response_6;
        $internalAudit->response_7 = $request->response_7;
        $internalAudit->response_8 = $request->response_8;
        $internalAudit->response_9 = $request->response_9;
        $internalAudit->response_10 = $request->response_10;
        $internalAudit->response_11 = $request->response_11;
        $internalAudit->response_12 = $request->response_12;
        $internalAudit->response_13 = $request->response_13;
        $internalAudit->response_14 = $request->response_14;
        $internalAudit->response_15 = $request->response_15;
        $internalAudit->response_16 = $request->response_16;
        $internalAudit->response_17 = $request->response_17;
        $internalAudit->response_18 = $request->response_18;
        $internalAudit->response_19 = $request->response_19;
        $internalAudit->response_20 = $request->response_20;
        $internalAudit->response_21 = $request->response_21;
        $internalAudit->response_22 = $request->response_22;
        $internalAudit->response_23 = $request->response_23;
        $internalAudit->response_24 = $request->response_24;
        $internalAudit->response_25 = $request->response_25;
        $internalAudit->response_26 = $request->response_26;
        $internalAudit->response_27 = $request->response_27;
        $internalAudit->response_28 = $request->response_28;
        $internalAudit->response_29 = $request->response_29;
        $internalAudit->response_30 = $request->response_30;
        $internalAudit->response_31 = $request->response_31;
        $internalAudit->response_32 = $request->response_32;
        $internalAudit->response_33 = $request->response_33;
        $internalAudit->response_34 = $request->response_34;
        $internalAudit->response_35 = $request->response_35;
        $internalAudit->response_36 = $request->response_36;
        $internalAudit->response_37 = $request->response_37;
        $internalAudit->response_38 = $request->response_38;
        $internalAudit->response_39 = $request->response_39;
        $internalAudit->response_40 = $request->response_40;
        $internalAudit->response_41 = $request->response_41;
        $internalAudit->response_42 = $request->response_42;
        $internalAudit->response_43 = $request->response_43;
        $internalAudit->response_44 = $request->response_44;
        $internalAudit->response_45 = $request->response_45;
        $internalAudit->response_46 = $request->response_46;
        $internalAudit->response_47 = $request->response_47;
        $internalAudit->response_48 = $request->response_48;
        $internalAudit->response_49 = $request->response_49;
        $internalAudit->response_50 = $request->response_50;
        $internalAudit->response_51 = $request->response_52;
        $internalAudit->response_52 = $request->response_52;
        $internalAudit->response_53 = $request->response_53;
        $internalAudit->response_54 = $request->response_54;
        $internalAudit->response_55 = $request->response_55;
        $internalAudit->response_56 = $request->response_56;
        $internalAudit->response_57 = $request->response_57;
        $internalAudit->response_58 = $request->response_58;
        $internalAudit->response_59 = $request->response_59;
        $internalAudit->response_60 = $request->response_60;
        $internalAudit->response_61 = $request->response_61;
        $internalAudit->response_62 = $request->response_62;
        $internalAudit->response_63 = $request->response_63;


        $internalAudit->remark_1 = $request->remark_1;
        $internalAudit->remark_2 = $request->remark_2;
        $internalAudit->remark_3 = $request->remark_3;
        $internalAudit->remark_4 = $request->remark_4;
        $internalAudit->remark_5 = $request->remark_5;
        $internalAudit->remark_6 = $request->remark_6;
        $internalAudit->remark_7 = $request->remark_7;
        $internalAudit->remark_8 = $request->remark_8;
        $internalAudit->remark_9 = $request->remark_9;
        $internalAudit->remark_10 = $request->remark_10;
        $internalAudit->remark_11 = $request->remark_11;
        $internalAudit->remark_12 = $request->remark_12;
        $internalAudit->remark_13 = $request->remark_13;
        $internalAudit->remark_14 = $request->remark_14;
        $internalAudit->remark_15 = $request->remark_15;
        $internalAudit->remark_16 = $request->remark_16;
        $internalAudit->remark_17 = $request->remark_17;
        $internalAudit->remark_18 = $request->remark_18;
        $internalAudit->remark_19 = $request->remark_19;
        $internalAudit->remark_20 = $request->remark_20;
        $internalAudit->remark_21 = $request->remark_21;
        $internalAudit->remark_22 = $request->remark_22;
        $internalAudit->remark_23 = $request->remark_23;
        $internalAudit->remark_24 = $request->remark_24;
        $internalAudit->remark_25 = $request->remark_25;
        $internalAudit->remark_26 = $request->remark_26;
        $internalAudit->remark_27 = $request->remark_27;
        $internalAudit->remark_28 = $request->remark_28;
        $internalAudit->remark_29 = $request->remark_29;
        $internalAudit->remark_30 = $request->remark_30;
        $internalAudit->remark_31 = $request->remark_31;
        $internalAudit->remark_32 = $request->remark_32;
        $internalAudit->remark_33 = $request->remark_33;
        $internalAudit->remark_34 = $request->remark_34;
        $internalAudit->remark_35 = $request->remark_35;
        $internalAudit->remark_36 = $request->remark_36;
        $internalAudit->remark_37 = $request->remark_37;
        $internalAudit->remark_38 = $request->remark_38;
        $internalAudit->remark_39 = $request->remark_39;
        $internalAudit->remark_40 = $request->remark_40;
        $internalAudit->remark_41 = $request->remark_41;
        $internalAudit->remark_42 = $request->remark_42;
        $internalAudit->remark_43 = $request->remark_43;
        $internalAudit->remark_44 = $request->remark_44;
        $internalAudit->remark_45 = $request->remark_45;
        $internalAudit->remark_46 = $request->remark_46;
        $internalAudit->remark_47 = $request->remark_47;
        $internalAudit->remark_48 = $request->remark_48;
        $internalAudit->remark_49 = $request->remark_49;
        $internalAudit->remark_50 = $request->remark_50;
        $internalAudit->remark_51 = $request->remark_51;
        $internalAudit->remark_52 = $request->remark_52;
        $internalAudit->remark_53 = $request->remark_53;
        $internalAudit->remark_54 = $request->remark_54;
        $internalAudit->remark_55 = $request->remark_55;
        $internalAudit->remark_56 = $request->remark_56;
        $internalAudit->remark_57 = $request->remark_57;
        $internalAudit->remark_58 = $request->remark_58;
        $internalAudit->remark_59 = $request->remark_59;
        $internalAudit->remark_60 = $request->remark_60;
        $internalAudit->remark_61 = $request->remark_61;
        $internalAudit->remark_62 = $request->remark_62;
        $internalAudit->remark_63 = $request->remark_63;
        
        $internalAudit->save();
//------------------------------------response and remarks input---------------------------------
//$internalaudit   = new table_cc_impactassement();

//$internalAudit->save();
          $ia_id = $internalAudit->id;


        $auditAssessmentGrid = InternalAuditChecklistGrid::where(['ia_id' => $internalAudit->id, 'identifier' => 'auditAssessmentChecklist'])->firstOrNew();
        $auditAssessmentGrid->ia_id = $internalAudit->id;
        $auditAssessmentGrid->identifier = 'auditAssessmentChecklist';
        $auditAssessmentGrid->data = $request->auditAssessmentChecklist;
        $auditAssessmentGrid->save();

        $auditPersonnelGrid = InternalAuditChecklistGrid::where(['ia_id' => $internalAudit->id, 'identifier' => 'auditPersonnelChecklist'])->firstOrNew();
        $auditPersonnelGrid->ia_id = $internalAudit->id;
        $auditPersonnelGrid->identifier = 'auditPersonnelChecklist';
        $auditPersonnelGrid->data = $request->auditPersonnelChecklist;
        $auditPersonnelGrid->save();

        $auditfacilityGrid = InternalAuditChecklistGrid::where(['ia_id' => $internalAudit->id, 'identifier' => 'auditfacilityChecklist'])->firstOrNew();
        $auditfacilityGrid->ia_id = $internalAudit->id;
        $auditfacilityGrid->identifier = 'auditfacilityChecklist';
        $auditfacilityGrid->data = $request->auditfacilityChecklist;
        $auditfacilityGrid->save();

        $auditMachinesGrid = InternalAuditChecklistGrid::where(['ia_id' => $internalAudit->id, 'identifier' => 'auditMachinesChecklist'])->firstOrNew();
        $auditMachinesGrid->ia_id = $internalAudit->id;
        $auditMachinesGrid->identifier = 'auditMachinesChecklist';
        $auditMachinesGrid->data = $request->auditMachinesChecklist;
        $auditMachinesGrid->save();

        $auditProductionGrid = InternalAuditChecklistGrid::where(['ia_id' => $internalAudit->id, 'identifier' => 'auditProductionChecklist'])->firstOrNew();
        $auditProductionGrid->ia_id = $internalAudit->id;
        $auditProductionGrid->identifier = 'auditProductionChecklist';
        $auditProductionGrid->data = $request->auditProductionChecklist;
        $auditProductionGrid->save();

        $auditMaterialsGrid = InternalAuditChecklistGrid::where(['ia_id' => $internalAudit->id, 'identifier' => 'auditMaterialsChecklist'])->firstOrNew();
        $auditMaterialsGrid->ia_id = $internalAudit->id;
        $auditMaterialsGrid->identifier = 'auditMaterialsChecklist';
        $auditMaterialsGrid->data = $request->auditMaterialsChecklist;
        $auditMaterialsGrid->save();

        $auditQualityGrid = InternalAuditChecklistGrid::where(['ia_id' => $internalAudit->id, 'identifier' => 'auditQualityControlChecklist'])->firstOrNew();
        $auditQualityGrid->ia_id = $internalAudit->id;
        $auditQualityGrid->identifier = 'auditQualityControlChecklist';
        $auditQualityGrid->data = $request->auditQualityControlChecklist;
        $auditQualityGrid->save();
        
        $auditQualityAssuranceGrid = InternalAuditChecklistGrid::where(['ia_id' => $internalAudit->id, 'identifier' => 'auditQualityAssuranceChecklist'])->firstOrNew();
        $auditQualityAssuranceGrid->ia_id = $internalAudit->id;
        $auditQualityAssuranceGrid->identifier = 'auditQualityAssuranceChecklist';
        $auditQualityAssuranceGrid->data = $request->auditQualityAssuranceChecklist;
        $auditQualityAssuranceGrid->save();

        $auditPackagingGrid = InternalAuditChecklistGrid::where(['ia_id' => $internalAudit->id, 'identifier' => 'auditPackagingChecklist'])->firstOrNew();
        $auditPackagingGrid->ia_id = $internalAudit->id;
        $auditPackagingGrid->identifier = 'auditPackagingChecklist';
        $auditPackagingGrid->data = $request->auditPackagingChecklist;
        $auditPackagingGrid->save();

        $auditsheGrid = InternalAuditChecklistGrid::where(['ia_id' => $internalAudit->id, 'identifier' => 'auditSheChecklist'])->firstOrNew();
        $auditsheGrid->ia_id = $internalAudit->id;
        $auditsheGrid->identifier = 'auditSheChecklist';
        $auditsheGrid->data = $request->auditSheChecklist;
        $auditsheGrid->save();
        
        $internalAuditComments = InternalAuditChecklistGrid::where(['ia_id' => $ia_id])->firstOrNew();        
        $internalAuditComments->auditSheChecklist_comment = $request->auditSheChecklist_comment;
        if (!empty($request->auditSheChecklist_attachment)) {
            $files = [];
            if ($request->hasfile('auditSheChecklist_attachment')) {
                foreach ($request->file('auditSheChecklist_attachment') as $file) {
                    $name = $request->name . 'auditSheChecklist_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $internalAuditComments->auditSheChecklist_attachment = json_encode($files);
            
        }

        $internalAuditComments->save();


        $internalAudit->status = 'Opened';
        $internalAudit->stage = 1;

        if (!empty($request->inv_attachment)) {
            $files = [];
            if ($request->hasfile('inv_attachment')) {
                foreach ($request->file('inv_attachment') as $file) {
                    $name = $request->name . 'inv_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $internalAudit->inv_attachment = json_encode($files);
        }


        if (!empty($request->file_attachment)) {
            $files = [];
            if ($request->hasfile('file_attachment')) {
                foreach ($request->file('file_attachment') as $file) {
                    $name = $request->name . 'file_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }

            $internalAudit->file_attachment = json_encode($files);
        }
        if (!empty($request->file_attachment_guideline)) {
            $files = [];
            if ($request->hasfile('file_attachment_guideline')) {
                foreach ($request->file('file_attachment_guideline') as $file) {
                    $name = $request->name . 'file_attachment_guideline' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $internalAudit->file_attachment_guideline = json_encode($files);
        }


        if (!empty($request->Audit_file)) {
            $files = [];
            if ($request->hasfile('Audit_file')) {
                foreach ($request->file('Audit_file') as $file) {
                    $name = $request->name . 'Audit_file' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $internalAudit->Audit_file = json_encode($files);
        }

        if (!empty($request->report_file)) {
            $files = [];
            if ($request->hasfile('report_file')) {
                foreach ($request->file('report_file') as $file) {
                    $name = $request->name . 'report_file' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $internalAudit->report_file = json_encode($files);
        }
        if (!empty($request->myfile)) {
            $files = [];
            if ($request->hasfile('myfile')) {
                foreach ($request->file('myfile') as $file) {
                    $name = $request->name . 'myfile' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $internalAudit->myfile = json_encode($files);
        }
        //dd($internalAudit);
         //return $internalAudit;
        $internalAudit->save();

        // $userNotification = new NotificationUser();
        // $userNotification->record_id = $internalAudit->id;
        // $userNotification->record_type = "Internal Audit";
        // $userNotification->to_id = Auth::user()->id;
        // $userNotification->save();

        $record = RecordNumber::first();
        $record->counter = ((RecordNumber::first()->value('counter')) + 1);
        $record->update();


        // -----------------grid----  Audit Agenda+
        $data3 = new InternalAuditGrid();
        $data3->audit_id = $internalAudit->id;
        $data3->type = "internal_audit";
        if (!empty($request->audit)) {
            $data3->area_of_audit = serialize($request->audit);
        }
        if (!empty($request->scheduled_start_date)) {
            $data3->start_date = serialize($request->scheduled_start_date);
        }
        if (!empty($request->scheduled_start_time)) {
            $data3->start_time = serialize($request->scheduled_start_time);
        }
        if (!empty($request->scheduled_end_date)) {
            $data3->end_date = serialize($request->scheduled_end_date);
        }
        if (!empty($request->scheduled_end_time)) {
            $data3->end_time = serialize($request->scheduled_end_time);
        }
        if (!empty($request->auditor)) {
            $data3->auditor = serialize($request->auditor);
        }
        if (!empty($request->auditee)) {
            $data3->auditee = serialize($request->auditee);
        }
        if (!empty($request->remarks)) {
            $data3->remark = serialize($request->remarks);
        }
        $data3->save();


        $data4 = new InternalAuditGrid();
        $data4->audit_id = $internalAudit->id;
        $data4->type = "Observation_field";
        if (!empty($request->observation_id)) {
            $data4->observation_id = serialize($request->observation_id);
        }
        // if (!empty($request->date)) {
        //     $data4->date = serialize($request->date);
        // }
        // if (!empty($request->auditorG)) {
        //     $data4->auditor = serialize($request->auditorG);
        // }
        // if (!empty($request->auditeeG)) {
        //     $data4->auditee = serialize($request->auditeeG);
        // }
        if (!empty($request->observation_description)) {
            $data4->observation_description = serialize($request->observation_description);
        }
        // if (!empty($request->severity_level)) {
        //     $data4->severity_level = serialize($request->severity_level);
        // }
        if (!empty($request->area)) {
            $data4->area = serialize($request->area);
        }
        // if (!empty($request->observation_category)) {
        //     $data4->observation_category = serialize($request->observation_category);
        // }
        //  if (!empty($request->capa_required)) {
        //     $data4->capa_required = serialize($request->capa_required);
        // }
         if (!empty($request->auditee_response)) {
            $data4->auditee_response = serialize($request->auditee_response);
        }
        // if (!empty($request->auditor_review_on_response)) {
        //     $data4->auditor_review_on_response = serialize($request->auditor_review_on_response);
        // }
        // if (!empty($request->qa_comment)) {
        //     $data4->qa_comment = serialize($request->qa_comment);
        // }
        // if (!empty($request->capa_details)) {
        //     $data4->capa_details = serialize($request->capa_details);
        // }
        // if (!empty($request->capa_due_date)) {
        //     $data4->capa_due_date = serialize($request->capa_due_date);
        // }
        // if (!empty($request->capa_owner)) {
        //     $data4->capa_owner = serialize($request->capa_owner);
        // }
        // if (!empty($request->action_taken)) {
        //     $data4->action_taken = serialize($request->action_taken);
        // }
        // if (!empty($request->capa_completion_date)) {
        //     $data4->capa_completion_date = serialize($request->capa_completion_date);
        // }
        // if (!empty($request->status_Observation)) {
        //     $data4->status = serialize($request->status_Observation);
        // }
        // if (!empty($request->remark_observation)) {
        //     $data4->remark = serialize($request->remark_observation);
        // }
        $data4->save();
        if (!empty($internalAudit->record)) {
            $history = new InternalAuditTrial();
            $history->internalAudit_id = $internalAudit->id;
            $history->activity_type = 'Record Number';
            $history->previous = "Not Applicable";
            $history->current = Helpers::getDivisionName(session()->get('division')) . "/IA/" . Helpers::year($internalAudit->created_at) . "/" . str_pad($internalAudit->record, 4, '0', STR_PAD_LEFT);
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $internalAudit->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($request->division_code)) {
            $history = new InternalAuditTrial();
            $history->internalAudit_id = $internalAudit->id;
            $history->activity_type = 'Site/Location Code';
            $history->previous = "Not Applicable";
            $history->current = $internalAudit->division_code;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $internalAudit->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
            $history->save();
        }
        if (!empty($internalAudit->initiator_id)) {
            $history = new InternalAuditTrial();
            $history->internalAudit_id = $internalAudit->id;
            $history->activity_type = 'Initiator';
            $history->previous = "Not Applicable";
            $history->current = Helpers::getInitiatorName($internalAudit->initiator_id);
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $internalAudit->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($request->intiation_date)) {
            $history = new InternalAuditTrial();
            $history->internalAudit_id = $internalAudit->id;
            $history->activity_type = 'Date Of Null';
            $history->previous = "Not Applicable";
            $history->current =  Helpers::getdateFormat($request->intiation_date);
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $internalAudit->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($internalAudit->assign_to)) {
            $history = new InternalAuditTrial();
            $history->InternalAudit_id = $internalAudit->id;
            $history->activity_type = 'Assigned to';
            $history->previous = "Not Applicable";
            $history->current = Helpers::getInitiatorName($internalAudit->assign_to);
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $internalAudit->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($internalAudit->sch_audit_start_date)) {
            $history = new InternalAuditTrial();
            $history->InternalAudit_id = $internalAudit->id;
            $history->activity_type = 'Scheduled audit date';
            $history->previous = "Not Applicable";
            $history->current =  Helpers::getdateFormat($internalAudit->sch_audit_start_date);
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $internalAudit->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
            $history->save();
        }
        if (!empty($internalAudit->auditee_department)) {
            $history = new InternalAuditTrial();
            $history->InternalAudit_id = $internalAudit->id;
            $history->activity_type = 'Auditee department Name';
            $history->previous = "Not Applicable";
            $history->current = Helpers::getFullDepartmentName($internalAudit->auditee_department);
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $internalAudit->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
            $history->save();
        }
        if (!empty($internalAudit->Initiator_Group)) {
            $history = new InternalAuditTrial();
            $history->InternalAudit_id = $internalAudit->id;
            $history->activity_type = 'Initiator Group';
            $history->previous = "Not Applicable";
            $history->current = Helpers::getFullDepartmentName($internalAudit->Initiator_Group);
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $internalAudit->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($internalAudit->initiator_group_code)) {
            $history = new InternalAuditTrial();
            $history->InternalAudit_id = $internalAudit->id;
            $history->activity_type = 'Initiator Group  Code';
            $history->previous = "Not Applicable";
            $history->current = $internalAudit->initiator_group_code;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $internalAudit->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($internalAudit->short_description)) {
            $history = new InternalAuditTrial();
            $history->InternalAudit_id = $internalAudit->id;
            $history->activity_type = 'Short Description';
            $history->previous = "Not Applicable";
            $history->current = $internalAudit->short_description;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $internalAudit->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
            $history->save();
        }
        if (!empty($internalAudit->file_attachment_guideline)) {
            $history = new InternalAuditTrial();
            $history->InternalAudit_id = $internalAudit->id;
            $history->activity_type = 'Guideline Attachment';
            $history->previous = "Not Applicable";
            $history->current = $internalAudit->file_attachment_guideline;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $internalAudit->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
            $history->save();
        }
        if (!empty($internalAudit->External_Auditing_Agency)) {
            $history = new InternalAuditTrial();
            $history->InternalAudit_id = $internalAudit->id;
            $history->activity_type = 'External Auditing Agency';
            $history->previous = "Not Applicable";
            $history->current = $internalAudit->External_Auditing_Agency;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $internalAudit->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($internalAudit->initiated_through)) {
            $history = new InternalAuditTrial();
            $history->InternalAudit_id = $internalAudit->id;
            $history->activity_type = 'Initiated Through';
            $history->previous = "Not Applicable";
            $history->current = $internalAudit->initiated_through;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $internalAudit->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
            $history->save();
        }


        if (!empty($internalAudit->audit_type)) {
            $history = new InternalAuditTrial();
            $history->InternalAudit_id = $internalAudit->id;
            $history->activity_type = 'Type of Audit';
            $history->previous = "Not Applicable";
            $history->current = $internalAudit->audit_type;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $internalAudit->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($internalAudit->if_other)) {
            $history = new InternalAuditTrial();
            $history->InternalAudit_id = $internalAudit->id;
            $history->activity_type = 'If Other';
            $history->previous = "Not Applicable";
            $history->current = $internalAudit->if_other;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $internalAudit->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
            $history->save();
        }
        if (!empty($internalAudit->initiated_if_other)) {
            $history = new InternalAuditTrial();
            $history->InternalAudit_id = $internalAudit->id;
            $history->activity_type = 'Others';
            $history->previous = "Not Applicable";
            $history->current = $internalAudit->initiated_if_other;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $internalAudit->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($internalAudit->initial_comments)) {
            $history = new InternalAuditTrial();
            $history->InternalAudit_id = $internalAudit->id;
            $history->activity_type = 'Description';
            $history->previous = "Not Applicable";
            $history->current = $internalAudit->initial_comments;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $internalAudit->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($internalAudit->external_agencies)) {
            $history = new InternalAuditTrial();
            $history->InternalAudit_id = $internalAudit->id;
            $history->activity_type = 'External Agencies';
            $history->previous = "Not Applicable";
            $history->current = $internalAudit->external_agencies;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $internalAudit->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($internalAudit->Others)) {
            $history = new InternalAuditTrial();
            $history->InternalAudit_id = $internalAudit->id;
            $history->activity_type = 'Others';
            $history->previous = "Not Applicable";
            $history->current = $internalAudit->Others;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $internalAudit->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($internalAudit->audit_schedule_start_date)) {
            $history = new InternalAuditTrial();
            $history->InternalAudit_id = $internalAudit->id;
            $history->activity_type = 'Audit Schedule Start Date';
            $history->previous = "Not Applicable";
            $history->current = $internalAudit->audit_schedule_start_date;
            $history->comment = "Na";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $internalAudit->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($internalAudit->audit_schedule_end_date)) {
            $history = new InternalAuditTrial();
            $history->InternalAudit_id = $internalAudit->id;
            $history->activity_type = 'End Date';
            $history->previous = "Not Applicable";
            $history->current = $internalAudit->audit_schedule_end_date;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $internalAudit->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
            $history->save();
        }

        // if (!empty($internalAudit->audit_agenda)) {
        //     $history = new InternalAuditTrial();
        //     $history->InternalAudit_id = $internalAudit->id;
        //     $history->activity_type = 'Audit Agenda';
        //     $history->previous = "Not Applicable";
        //     $history->current = $internalAudit->audit_agenda;
        //     $history->comment = "Not Applicable";
        //     $history->user_id = Auth::user()->id;
        //     $history->user_name = Auth::user()->name;
        //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        //     $history->origin_state = $internalAudit->status;
        //     $history->change_to =   "Opened";
        //     $history->change_from = "Null";
        //     $history->action_name = 'Create';
        //     $history->save();
        // }

        // if (!empty($internalAudit->Facility)) {
        //     $history = new InternalAuditTrial();
        //     $history->InternalAudit_id = $internalAudit->id;
        //     $history->activity_type = 'Facility Name';
        //     $history->previous = "Not Applicable";
        //     $history->current = $internalAudit->Facility;
        //     $history->comment = "Not Applicable";
        //     $history->user_id = Auth::user()->id;
        //     $history->user_name = Auth::user()->name;
        //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        //     $history->origin_state = $internalAudit->status;
        //     $history->save();
        // }

        // if (!empty($internalAudit->Group)) {
        //     $history = new InternalAuditTrial();
        //     $history->InternalAudit_id = $internalAudit->id;
        //     $history->activity_type = 'Group Name';
        //     $history->previous = "Not Applicable";
        //     $history->current = $internalAudit->Group;
        //     $history->comment = "Not Applicable";
        //     $history->user_id = Auth::user()->id;
        //     $history->user_name = Auth::user()->name;
        //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        //     $history->origin_state = $internalAudit->status;
        //     $history->save();
        // }

        if (!empty($internalAudit->material_name)) {
            $history = new InternalAuditTrial();
            $history->InternalAudit_id = $internalAudit->id;
            $history->activity_type = 'Product/Material Name';
            $history->previous = "Not Applicable";
            $history->current = $internalAudit->material_name;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $internalAudit->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($internalAudit->if_comments)) {
            $history = new InternalAuditTrial();
            $history->InternalAudit_id = $internalAudit->id;
            $history->activity_type = 'Comments(If Any)';
            $history->previous = "Not Applicable";
            $history->current = $internalAudit->if_comments;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $internalAudit->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($internalAudit->lead_auditor)) {
            $history = new InternalAuditTrial();
            $history->InternalAudit_id = $internalAudit->id;
            $history->activity_type = 'Lead Auditor';
            $history->previous = "Not Applicable";
            $history->current = $internalAudit->lead_auditor;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $internalAudit->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
            $history->save();
        }
        if (!empty($internalAudit->due_date_extension)) {
            $history = new InternalAuditTrial();
            $history->InternalAudit_id = $internalAudit->id;
            $history->activity_type = 'Due Date Extension Justification';
            $history->previous = "Not Applicable";
            $history->current = $internalAudit->due_date_extension;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $internalAudit->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($internalAudit->Audit_team)) {
            $history = new InternalAuditTrial();
            $history->InternalAudit_id = $internalAudit->id;
            $history->activity_type = 'Audit Team';
            $history->previous = "Not Applicable";
            $history->current = $internalAudit->Audit_team;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $internalAudit->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($internalAudit->Auditee)) {
            $history = new InternalAuditTrial();
            $history->InternalAudit_id = $internalAudit->id;
            $history->activity_type = 'Auditee';
            $history->previous = "Not Applicable";
            $history->current = $internalAudit->Auditee;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $internalAudit->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($internalAudit->Auditor_Details)) {
            $history = new InternalAuditTrial();
            $history->InternalAudit_id = $internalAudit->id;
            $history->activity_type = 'External Auditor Details';
            $history->previous = "Not Applicable";
            $history->current = $internalAudit->Auditor_Details;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $internalAudit->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($internalAudit->Relevant_Guideline)) {
            $history = new InternalAuditTrial();
            $history->InternalAudit_id = $internalAudit->id;
            $history->activity_type = 'Relevant Guidelines / Industry Standards';
            $history->previous = "Not Applicable";
            $history->current = $internalAudit->Relevant_Guideline;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $internalAudit->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($internalAudit->QA_Comments)) {
            $history = new InternalAuditTrial();
            $history->InternalAudit_id = $internalAudit->id;
            $history->activity_type = 'QA Comments';
            $history->previous = "Not Applicable";
            $history->current = $internalAudit->QA_Comments;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $internalAudit->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($internalAudit->Audit_Category)) {
            $history = new InternalAuditTrial();
            $history->InternalAudit_id = $internalAudit->id;
            $history->activity_type = 'Audit Category';
            $history->previous = "Not Applicable";
            $history->current = $internalAudit->Audit_Category;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $internalAudit->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($internalAudit->Supplier_Details)) {
            $history = new InternalAuditTrial();
            $history->InternalAudit_id = $internalAudit->id;
            $history->activity_type = 'Supplier/Vendor/Manufacturer Details';
            $history->previous = "Not Applicable";
            $history->current = $internalAudit->Supplier_Details;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $internalAudit->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($internalAudit->Supplier_Site)) {
            $history = new InternalAuditTrial();
            $history->InternalAudit_id = $internalAudit->id;
            $history->activity_type = 'Supplier/Vendor/Manufacturer Site';
            $history->previous = "Not Applicable";
            $history->current = $internalAudit->Supplier_Site;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $internalAudit->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
            $history->save();
        }


        if (!empty($internalAudit->Comments)) {
            $history = new InternalAuditTrial();
            $history->InternalAudit_id = $internalAudit->id;
            $history->activity_type = 'Comments';
            $history->previous = "Not Applicable";
            $history->current = $internalAudit->Comments;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $internalAudit->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($internalAudit->severity_level_form)) {
            $history = new InternalAuditTrial();
            $history->InternalAudit_id = $internalAudit->id;
            $history->activity_type = 'Severity Level';
            $history->previous = "Not Applicable";
            $history->current = $internalAudit->severity_level_form;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $internalAudit->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($internalAudit->Audit_Comments1)) {
            $history = new InternalAuditTrial();
            $history->InternalAudit_id = $internalAudit->id;
            $history->activity_type = 'Audit Comments';
            $history->previous = "Not Applicable";
            $history->current = $internalAudit->Audit_Comments1;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $internalAudit->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
            $history->save();
        }
        if (!empty($internalAudit->refrence_record)) {
            $history = new InternalAuditTrial();
            $history->InternalAudit_id = $internalAudit->id;
            $history->activity_type = 'Reference Record';
            $history->previous = "Not Applicable";
            $history->current = implode(',', $request->refrence_record);
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $internalAudit->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
            $history->save();
        }
        if (!empty($internalAudit->res_ver)) {
            $history = new InternalAuditTrial();
            $history->InternalAudit_id = $internalAudit->id;
            $history->activity_type = 'Response Verification Comment';
            $history->previous = "Not Applicable";
            $history->current = $internalAudit->res_ver;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $internalAudit->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
            $history->save();
        }
        if (!empty($internalAudit->attach_file_rv)) {
            $history = new InternalAuditTrial();
            $history->InternalAudit_id = $internalAudit->id;
            $history->activity_type = 'Response verification Attachments';
            $history->previous = "Not Applicable";
            $history->current = $internalAudit->attach_file_rv;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $internalAudit->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($internalAudit->Remarks)) {
            $history = new InternalAuditTrial();
            $history->InternalAudit_id = $internalAudit->id;
            $history->activity_type = 'Remarks';
            $history->previous = "Not Applicable";
            $history->current = $internalAudit->Remarks;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $internalAudit->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($internalAudit->Reference_Recores1)) {
            $history = new InternalAuditTrial();
            $history->InternalAudit_id = $internalAudit->id;
            $history->activity_type = 'Reference Records';
            $history->previous = "Not Applicable";
            $history->current = $internalAudit->Reference_Recores1;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $internalAudit->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($internalAudit->Reference_Recores2)) {
            $history = new InternalAuditTrial();
            $history->InternalAudit_id = $internalAudit->id;
            $history->activity_type = 'Reference Records';
            $history->previous = "Not Applicable";
            $history->current = $internalAudit->Reference_Recores2;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $internalAudit->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($internalAudit->Audit_Comments2)) {
            $history = new InternalAuditTrial();
            $history->InternalAudit_id = $internalAudit->id;
            $history->activity_type = 'Audit Comments';
            $history->previous = "Not Applicable";
            $history->current = $internalAudit->Audit_Comments2;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $internalAudit->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($internalAudit->inv_attachment)) {
            $history = new InternalAuditTrial();
            $history->InternalAudit_id = $internalAudit->id;
            $history->activity_type = 'Initial Attachment';
            $history->previous = "Not Applicable";
            $history->current = $internalAudit->inv_attachment;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $internalAudit->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($internalAudit->file_attachment)) {
            $history = new InternalAuditTrial();
            $history->InternalAudit_id = $internalAudit->id;
            $history->activity_type = 'File Attachment';
            $history->previous = "Not Applicable";
            $history->current = $internalAudit->file_attachment;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $internalAudit->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
            $history->save();
        }
        if (!empty($internalAudit->file_attachment_guideline)) {
            $history = new InternalAuditTrial();
            $history->InternalAudit_id = $internalAudit->id;
            $history->activity_type = 'Audit Preparation and Execution Attachment';
            $history->previous = "Not Applicable";
            $history->current = $internalAudit->file_attachment_guideline;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $internalAudit->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($internalAudit->Audit_file)) {
            $history = new InternalAuditTrial();
            $history->InternalAudit_id = $internalAudit->id;
            $history->activity_type = 'Audit Attachments';
            $history->previous = "Not Applicable";
            $history->current = $internalAudit->Audit_file;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $internalAudit->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($internalAudit->report_file)) {
            $history = new InternalAuditTrial();
            $history->InternalAudit_id = $internalAudit->id;
            $history->activity_type = 'Report Attachments';
            $history->previous = "Not Applicable";
            $history->current = $internalAudit->report_file;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $internalAudit->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($internalAudit->myfile)) {
            $history = new InternalAuditTrial();
            $history->InternalAudit_id = $internalAudit->id;
            $history->activity_type = 'Audit Attachment';
            $history->previous = "Not Applicable";
            $history->current = $internalAudit->myfile;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $internalAudit->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
            $history->save();
        }



        if (!empty($internalAudit->due_date)) {
            $history = new InternalAuditTrial();
            $history->InternalAudit_id = $internalAudit->id;
            $history->activity_type = 'Due Date';
            $history->previous = "Not Applicable";
             $history->current =  Helpers::getdateFormat( $internalAudit->due_date);
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $internalAudit->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($internalAudit->audit_start_date)) {
            $history = new InternalAuditTrial();
            $history->InternalAudit_id = $internalAudit->id;
            $history->activity_type = 'Audit Start Date';
            $history->previous = "Not Applicable";
            $history->current = Helpers::getdateFormat($internalAudit->audit_start_date);
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $internalAudit->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($internalAudit->audit_end_date)) {
            $history = new InternalAuditTrial();
            $history->InternalAudit_id = $internalAudit->id;
            $history->activity_type = 'Audit End Date';
            $history->previous = "Not Applicable";
            $history->current = Helpers::getdateFormat( $internalAudit->audit_end_date);
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $internalAudit->status;
            $history->change_to =   "Opened";
            $history->change_from = "Null";
            $history->action_name = 'Create';
            $history->save();
        }
        toastr()->success('Record is created Successfully');

        return redirect('rcms/qms-dashboard');
    }


    public function update(request $request, $id)
    {
        $lastDocument = InternalAudit::find($id);
        $internalAudit = InternalAudit::find($id);

        $internalAudit->parent_id = $request->parent_id;
        $internalAudit->parent_type = $request->parent_type;
        $internalAudit->intiation_date = $request->intiation_date;
        $internalAudit->assign_to = $request->assign_to;
        $internalAudit->due_date= $request->due_date;
        $internalAudit->initiator_group= $request->initiator_group;
        $internalAudit->initiator_group_code= $request->initiator_group_code;
        $internalAudit->short_description = $request->short_description;
        $internalAudit->audit_type = $request->audit_type;
        $internalAudit->if_other = $request->if_other;
        $internalAudit->Others= $request->Others;
        // $internalAudit->external_others=$request->external_others;
        $internalAudit->Relevant_Guideline= $request->Relevant_Guideline;
        $internalAudit->initiated_through = $request->initiated_through;
        $internalAudit->initiated_if_other = $request->initiated_if_other;
        $internalAudit->repeat = $request->repeat;
        $internalAudit->QA_Comments= $request->QA_Comments;
        // $internalAudit->file_attachment_guideline = $request->file_attachment_guideline;
        $internalAudit->Supplier_Details= $request->Supplier_Details;
        $internalAudit->Supplier_Site= $request->Supplier_Site;
        $internalAudit->Audit_Category= $request->Audit_Category;
        $internalAudit->repeat_nature = $request->repeat_nature;
        $internalAudit->due_date_extension = $request->due_date_extension;
        $internalAudit->External_Auditing_Agency= $request->External_Auditing_Agency;
        $internalAudit->initial_comments = $request->initial_comments;
        $internalAudit->initiator_Group= $request->initiator_Group;

        $internalAudit->start_date = $request->start_date;
        $internalAudit->end_date = $request->end_date;
        $internalAudit->audit_agenda = $request->audit_agenda;
        //$internalAudit->Facility =  implode(',', $request->Facility);
        // $internalAudit->Group = implode(',', $request->Group);
        $internalAudit->external_agencies = $request->external_agencies;
        $internalAudit->material_name = $request->material_name;
        $internalAudit->if_comments = $request->if_comments;
        $internalAudit->lead_auditor = $request->lead_auditor;
        $internalAudit->Audit_team =  implode(',', $request->Audit_team);
        $internalAudit->Auditee =  implode(',', $request->Auditee);
        $internalAudit->Auditor_Details = $request->Auditor_Details;
        $internalAudit->Comments = $request->Comments;
        $internalAudit->Audit_Comments1 = $request->Audit_Comments1;
        $internalAudit->Remarks = $request->Remarks;
        $internalAudit->refrence_record=implode(',', $request->refrence_record);
        $internalAudit->severity_level_form= $request->severity_level_form;
        $internalAudit->audit_schedule_start_date= $request->audit_schedule_start_date;
        $internalAudit->audit_schedule_end_date= $request->audit_schedule_end_date;

        $internalAudit->Audit_Comments2 = $request->Audit_Comments2;
        $internalAudit->due_date= $request->due_date;
        $internalAudit->audit_start_date= $request->audit_start_date;
        $internalAudit->audit_end_date = $request->audit_end_date;


        // ===================update==============checklist=========

        $internalAudit->response_1 = $request->response_1;
        $internalAudit->response_2 = $request->response_2;
        $internalAudit->response_3 = $request->response_3;
        $internalAudit->response_4 = $request->response_4;
        $internalAudit->response_5 = $request->response_5;
        $internalAudit->response_6 = $request->response_6;
        $internalAudit->response_7 = $request->response_7;
        $internalAudit->response_8 = $request->response_8;
        $internalAudit->response_9 = $request->response_9;
        $internalAudit->response_10 = $request->response_10;
        $internalAudit->response_11 = $request->response_11;
        $internalAudit->response_12 = $request->response_12;
        $internalAudit->response_13 = $request->response_13;
        $internalAudit->response_14 = $request->response_14;
        $internalAudit->response_15 = $request->response_15;
        $internalAudit->response_16 = $request->response_16;
        $internalAudit->response_17 = $request->response_17;
        $internalAudit->response_18 = $request->response_18;
        $internalAudit->response_19 = $request->response_19;
        $internalAudit->response_20 = $request->response_20;
        $internalAudit->response_21 = $request->response_21;
        $internalAudit->response_22 = $request->response_22;
        $internalAudit->response_23 = $request->response_23;
        $internalAudit->response_24 = $request->response_24;
        $internalAudit->response_25 = $request->response_25;
        $internalAudit->response_26 = $request->response_26;
        $internalAudit->response_27 = $request->response_27;
        $internalAudit->response_28 = $request->response_28;
        $internalAudit->response_29 = $request->response_29;
        $internalAudit->response_30 = $request->response_30;
        $internalAudit->response_31 = $request->response_31;
        $internalAudit->response_32 = $request->response_32;
        $internalAudit->response_33 = $request->response_33;
        $internalAudit->response_34 = $request->response_34;
        $internalAudit->response_35 = $request->response_35;
        $internalAudit->response_36 = $request->response_36;
        $internalAudit->response_37 = $request->response_37;
        $internalAudit->response_38 = $request->response_38;
        $internalAudit->response_39 = $request->response_39;
        $internalAudit->response_40 = $request->response_40;
        $internalAudit->response_41 = $request->response_41;
        $internalAudit->response_42 = $request->response_42;
        $internalAudit->response_43 = $request->response_43;
        $internalAudit->response_44 = $request->response_44;
        $internalAudit->response_45 = $request->response_45;
        $internalAudit->response_46 = $request->response_46;
        $internalAudit->response_47 = $request->response_47;
        $internalAudit->response_48 = $request->response_48;
        $internalAudit->response_49 = $request->response_49;
        $internalAudit->response_50 = $request->response_50;
        $internalAudit->response_51 = $request->response_52;
        $internalAudit->response_52 = $request->response_52;
        $internalAudit->response_53 = $request->response_53;
        $internalAudit->response_54 = $request->response_54;
        $internalAudit->response_55 = $request->response_55;
        $internalAudit->response_56 = $request->response_56;
        $internalAudit->response_57 = $request->response_57;
        $internalAudit->response_58 = $request->response_58;
        $internalAudit->response_59 = $request->response_59;
        $internalAudit->response_60 = $request->response_60;
        $internalAudit->response_61 = $request->response_61;
        $internalAudit->response_62 = $request->response_62;
        $internalAudit->response_63 = $request->response_63;


        $internalAudit->remark_1 = $request->remark_1;
        $internalAudit->remark_2 = $request->remark_2;
        $internalAudit->remark_3 = $request->remark_3;
        $internalAudit->remark_4 = $request->remark_4;
        $internalAudit->remark_5 = $request->remark_5;
        $internalAudit->remark_6 = $request->remark_6;
        $internalAudit->remark_7 = $request->remark_7;
        $internalAudit->remark_8 = $request->remark_8;
        $internalAudit->remark_9 = $request->remark_9;
        $internalAudit->remark_10 = $request->remark_10;
        $internalAudit->remark_11 = $request->remark_11;
        $internalAudit->remark_12 = $request->remark_12;
        $internalAudit->remark_13 = $request->remark_13;
        $internalAudit->remark_14 = $request->remark_14;
        $internalAudit->remark_15 = $request->remark_15;
        $internalAudit->remark_16 = $request->remark_16;
        $internalAudit->remark_17 = $request->remark_17;
        $internalAudit->remark_18 = $request->remark_18;
        $internalAudit->remark_19 = $request->remark_19;
        $internalAudit->remark_20 = $request->remark_20;
        $internalAudit->remark_21 = $request->remark_21;
        $internalAudit->remark_22 = $request->remark_22;
        $internalAudit->remark_23 = $request->remark_23;
        $internalAudit->remark_24 = $request->remark_24;
        $internalAudit->remark_25 = $request->remark_25;
        $internalAudit->remark_26 = $request->remark_26;
        $internalAudit->remark_27 = $request->remark_27;
        $internalAudit->remark_28 = $request->remark_28;
        $internalAudit->remark_29 = $request->remark_29;
        $internalAudit->remark_30 = $request->remark_30;
        $internalAudit->remark_31 = $request->remark_31;
        $internalAudit->remark_32 = $request->remark_32;
        $internalAudit->remark_33 = $request->remark_33;
        $internalAudit->remark_34 = $request->remark_34;
        $internalAudit->remark_35 = $request->remark_35;
        $internalAudit->remark_36 = $request->remark_36;
        $internalAudit->remark_37 = $request->remark_37;
        $internalAudit->remark_38 = $request->remark_38;
        $internalAudit->remark_39 = $request->remark_39;
        $internalAudit->remark_40 = $request->remark_40;
        $internalAudit->remark_41 = $request->remark_41;
        $internalAudit->remark_42 = $request->remark_42;
        $internalAudit->remark_43 = $request->remark_43;
        $internalAudit->remark_44 = $request->remark_44;
        $internalAudit->remark_45 = $request->remark_45;
        $internalAudit->remark_46 = $request->remark_46;
        $internalAudit->remark_47 = $request->remark_47;
        $internalAudit->remark_48 = $request->remark_48;
        $internalAudit->remark_49 = $request->remark_49;
        $internalAudit->remark_50 = $request->remark_50;
        $internalAudit->remark_51 = $request->remark_51;
        $internalAudit->remark_52 = $request->remark_52;
        $internalAudit->remark_53 = $request->remark_53;
        $internalAudit->remark_54 = $request->remark_54;
        $internalAudit->remark_55 = $request->remark_55;
        $internalAudit->remark_56 = $request->remark_56;
        $internalAudit->remark_57 = $request->remark_57;
        $internalAudit->remark_58 = $request->remark_58;
        $internalAudit->remark_59 = $request->remark_59;
        $internalAudit->remark_60 = $request->remark_60;
        $internalAudit->remark_61 = $request->remark_61;
        $internalAudit->remark_62 = $request->remark_62;
        $internalAudit->remark_63 = $request->remark_63;
        $internalAudit->Description_Deviation = $request->Description_Deviation;

        // =======================new teblet compresion ====
        $checklistTabletCompression = IA_checklist_tablet_compression::where(['ia_id' => $id])->firstOrCreate();
        $checklistTabletCompression->ia_id = $id;


        for ($i = 1; $i <= 49; $i++)
        {
            $string = 'tablet_compress_response_'. $i;
            $checklistTabletCompression->$string = $request->$string;
        }

        for ($i = 1; $i <= 49; $i++)
        {
            $string = 'tablet_compress_remark_'. $i;
            $checklistTabletCompression->$string = $request->$string;
        }
        // dd($checklistTabletCompression->tablet_compress_remark_1)
        $checklistTabletCompression->tablet_compress_response_final_comment = $request->tablet_compress_response_final_comment;
        $checklistTabletCompression->save();


        // =======================new teblet coating ====
        $checklistTabletCoating = IA_checklist_tablet_coating::where(['ia_id' => $id])->firstOrCreate();
        $checklistTabletCoating->ia_id = $id;


        for ($i = 1; $i <= 49; $i++)
        {
            $string = 'tablet_coating_response_'. $i;
            $checklistTabletCoating->$string = $request->$string;
        }

        for ($i = 1; $i <= 49; $i++)
        {
            $string = 'tablet_coating_remark_'. $i;
            $checklistTabletCoating->$string = $request->$string;
        }
        // dd($checklistTabletCompression->tablet_compress_remark_1)
        $checklistTabletCoating->tablet_coating_remark_comment = $request->tablet_coating_remark_comment;
        $checklistTabletCoating->save();


        //==================== onitnment controller==================================================================
$liquid_ointments = IA_liquid_ointment::where(['ia_id' => $id])->firstOrCreate();
$liquid_ointments->ia_id = $id;


 for ($i = 1; $i <= 48; $i++)
 {
     $string = 'liquid_ointments_response_'. $i;
    $liquid_ointments->$string = $request->$string;
 }

 for ($i = 1; $i <= 48; $i++)
 {
    $string = 'liquid_ointments_remark_'. $i;
     $liquid_ointments->$string = $request->$string;
 }
 // dd($checklistTabletCompression->tablet_compress_remark_1)
 $liquid_ointments->Description_oinments_comment = $request->Description_oinments_comment;
$liquid_ointments->save();

//======================================  Checklist_Capsule==========================================================================================================================================================

$Checklist_Capsule = Checklist_Capsule::where(['ia_id' => $id])->firstOrCreate();
$Checklist_Capsule->ia_id = $id;


for ($i = 1; $i <= 50; $i++)
{
    $string = 'capsule_response_'. $i;
    $Checklist_Capsule->$string = $request->$string;
}

for ($i = 1; $i <= 50; $i++)
{
    $string = 'capsule_remark_'. $i;
    $Checklist_Capsule->$string = $request->$string;
}
// dd($checklistTabletCompression->tablet_compress_remark_1)
$Checklist_Capsule->Description_Deviation = $request->Description_Deviation;
$Checklist_Capsule->save();

//=========================================================================================



        // =======================new teblet paking====
        $checklistTabletPaking = IA_checklist_capsule_paking::where(['ia_id' => $id])->firstOrCreate();
        $checklistTabletPaking->ia_id = $id;


        for ($i = 1; $i <= 49; $i++)
        {
            $string = 'tablet_capsule_packing_'. $i;
            $checklistTabletPaking->$string = $request->$string;
        }

        for ($i = 1; $i <= 49; $i++)
        {
            $string = 'tablet_capsule_packing_remark_'. $i;
            $checklistTabletPaking->$string = $request->$string;
        }
        // dd($checklistTabletCompression->tablet_compress_remark_1)
        $checklistTabletPaking->tablet_capsule_packing_comment = $request->tablet_capsule_packing_comment;
        $checklistTabletPaking->save();

  // =======================new teblet dispencing_and_manufactuirng ====
  $dispencing_and_manufactuirng = IA_dispencing_manufacturing::where(['ia_id' => $id])->firstOrCreate();
  $dispencing_and_manufactuirng->ia_id = $id;


  for ($i = 1; $i <= 66; $i++)
  {
      $string = 'dispensing_and_manufacturing_'. $i;
      $dispencing_and_manufactuirng->$string = $request->$string;
  }

  for ($i = 1; $i <= 66; $i++)
  {
      $string = 'dispensing_and_manufacturing_remark_'. $i;
      $dispencing_and_manufactuirng->$string = $request->$string;
  }
  // dd($checklistTabletCompression->tablet_compress_remark_1)
  $dispencing_and_manufactuirng->dispensing_and_manufacturing_comment = $request->dispensing_and_manufacturing_comment;
  $dispencing_and_manufactuirng->save();

  // =======================new tebletointment packing ====
  $ointment_packing = IA_ointment_paking::where(['ia_id' => $id])->firstOrCreate();
  $ointment_packing->ia_id = $id;


  for ($i = 1; $i <= 51; $i++)
  {
      $string = 'ointment_packing_'. $i;
      $ointment_packing->$string = $request->$string;
  }

  for ($i = 1; $i <= 51; $i++)
  {
      $string = 'ointment_packing_remark_'. $i;
      $ointment_packing->$string = $request->$string;
  }
  // dd($checklistTabletCompression->tablet_compress_remark_1)
  $ointment_packing->ointment_packing_comment = $request->ointment_packing_comment;
  $ointment_packing->save();

   // =======================new engneering checklist ====
   $engineering_checklist = IA_checklist_engineering::where(['ia_id' => $id])->firstOrCreate();
   $engineering_checklist->ia_id = $id;
 
 
   for ($i = 1; $i <= 34; $i++)
   {
       $string = 'engineering_response_'. $i;
       $engineering_checklist->$string = $request->$string;
   }
 
   for ($i = 1; $i <= 34; $i++)
   {
       $string = 'engineering_remark_'. $i;
       $engineering_checklist->$string = $request->$string;
   }
   // dd($checklistTabletCompression->tablet_compress_remark_1)
   $engineering_checklist->engineering_response_comment = $request->engineering_response_comment;
   $engineering_checklist->save();

    // =======================new quality control checklist ====
    $quality_control_checklist = IA_quality_control::where(['ia_id' => $id])->firstOrCreate();
    $quality_control_checklist->ia_id = $id;
  
  
    for ($i = 1; $i <= 84; $i++)
    {
        $string = 'quality_control_response_'. $i;
        $quality_control_checklist->$string = $request->$string;
    }
  
    for ($i = 1; $i <= 84; $i++)
    {
        $string = 'quality_control_remark__'. $i;
        $quality_control_checklist->$string = $request->$string;
    }
    // dd($checklistTabletCompression->tablet_compress_remark_1)
    $quality_control_checklist->quality_control_response_comment = $request->quality_control_response_comment;
    $quality_control_checklist->save();

 // =======================new checklist stores ====
 $checklist_stores = IA_checklist_stores::where(['ia_id' => $id])->firstOrCreate();
 $checklist_stores->ia_id = $id;


 for ($i = 1; $i <= 31; $i++)
 {
     $string = 'checklist_stores_response_'. $i;
     $checklist_stores->$string = $request->$string;
 }

 for ($i = 1; $i <= 31; $i++)
 {
     $string = 'checklist_stores_remark_'. $i;
     $checklist_stores->$string = $request->$string;
 }
 // dd($checklistTabletCompression->tablet_compress_remark_1)
 $checklist_stores->checklist_stores_response_comment = $request->checklist_stores_response_comment;
 $checklist_stores->save();


  // =======================new human resources ====
  $checklist_human_resources = IA_checklist_hr::where(['ia_id' => $id])->firstOrCreate();
  $checklist_human_resources->ia_id = $id;
 
 
  for ($i = 1; $i <= 35; $i++)
  {
      $string = 'checklist_hr_response_'. $i;
      $checklist_human_resources->$string = $request->$string;
  }
 
  for ($i = 1; $i <= 35; $i++)
  {
      $string = 'checklist_hr_remark_'. $i;
      $checklist_human_resources->$string = $request->$string;
  }
  // dd($checklistTabletCompression->tablet_compress_remark_1)
  $checklist_human_resources->checklist_hr_response_comment = $request->checklist_hr_response_comment;
  $checklist_human_resources->save();

  // =======================new human resources ====
  $checklist_production_dispensing = IA_checklist_dispensing::where(['ia_id' => $id])->firstOrCreate();
  $checklist_production_dispensing->ia_id = $id;
 
 
  for ($i = 1; $i <= 14; $i++)
  {
      $string = 'response_dispensing_'. $i;
      $checklist_production_dispensing->$string = $request->$string;
  }
 
  for ($i = 1; $i <= 14; $i++)
  {
      $string = 'remark_dispensing_'. $i;
      $checklist_production_dispensing->$string = $request->$string;
  }
  for ($i = 1; $i <= 50; $i++)
  {
      $string = 'response_injection_'. $i;
      $checklist_production_dispensing->$string = $request->$string;
  }
 
  for ($i = 1; $i <= 50; $i++)
  {
      $string = 'remark_injection_'. $i;
      $checklist_production_dispensing->$string = $request->$string;
  }
  for ($i = 1; $i <= 7; $i++)
  {
      $string = 'response_documentation_'. $i;
      $checklist_production_dispensing->$string = $request->$string;
  }
 
  for ($i = 1; $i <= 7; $i++)
  {
      $string = 'remark_documentation_'. $i;
      $checklist_production_dispensing->$string = $request->$string;
  }
  // dd($checklistTabletCompression->tablet_compress_remark_1)
  $checklist_production_dispensing->remark_documentation_name_comment = $request->remark_documentation_name_comment;
  $checklist_production_dispensing->save();

// ======================================checklist injecection production=================
  $checklist_production_injection = IA_checklist_production_injection::where(['ia_id' => $id])->firstOrCreate();
  $checklist_production_injection->ia_id = $id;
 
 
  
  for ($i = 1; $i <= 41; $i++)
  {
      $string = 'response_injection_packing_'. $i;
      $checklist_production_injection->$string = $request->$string;
  }
 
  for ($i = 1; $i <= 41; $i++)
  {
      $string = 'remark_injection_packing_'. $i;
      $checklist_production_injection->$string = $request->$string;
  }
  for ($i = 1; $i <= 6; $i++)
  {
      $string = 'response_documentation_production_'. $i;
      $checklist_production_injection->$string = $request->$string;
  }
 
  for ($i = 1; $i <= 6; $i++)
  {
      $string = 'remark_documentation_production_'. $i;
      $checklist_production_injection->$string = $request->$string;
  }
  // dd($checklistTabletCompression->tablet_compress_remark_1)
  $checklist_production_injection->response_injection_packing_comment = $request->response_injection_packing_comment;
  $checklist_production_injection->save();

  // ====================================== IA_checklist_manufacturing_filling =================
  $checklist_manufacturing_production = IA_checklist_manufacturing_filling::where(['ia_id' => $id])->firstOrCreate();
  $checklist_manufacturing_production->ia_id = $id;
 
 
  
  for ($i = 1; $i <= 44; $i++)
  {
      $string = 'response_powder_manufacturing_filling_'. $i;
      $checklist_manufacturing_production->$string = $request->$string;
  }
 
  for ($i = 1; $i <= 44; $i++)
  {
      $string = 'remark_powder_manufacturing_filling_'. $i;
      $checklist_manufacturing_production->$string = $request->$string;
  }
  for ($i = 1; $i <= 3; $i++)
  {
      $string = 'response_packing_'. $i;
      $checklist_manufacturing_production->$string = $request->$string;
  }
 
  for ($i = 1; $i <= 3; $i++)
  {
      $string = 'remark_packing_'. $i;
      $checklist_manufacturing_production->$string = $request->$string;
  }
  // dd($checklistTabletCompression->tablet_compress_remark_1)
  $checklist_manufacturing_production->remark_powder_manufacturing_filling_comment = $request->remark_powder_manufacturing_filling_comment;
  $checklist_manufacturing_production->save();


   // ====================================== IA_checklist_analytical_research =================
   $checklist_analytical_research = IA_checklist_analytical_research::where(['ia_id' => $id])->firstOrCreate();
   $checklist_analytical_research->ia_id = $id;
  
  
   
   for ($i = 1; $i <= 26; $i++)
   {
       $string = 'response_analytical_research_development_'. $i;
       $checklist_analytical_research->$string = $request->$string;
   }
  
   for ($i = 1; $i <= 26; $i++)
   {
       $string = 'remark_analytical_research_development_'. $i;
       $checklist_analytical_research->$string = $request->$string;
   }
  
   // dd($checklistTabletCompression->tablet_compress_remark_1)
   $checklist_analytical_research->remark_analytical_research_comment = $request->remark_analytical_research_comment;
   $checklist_analytical_research->save();
 
 // ====================================== IA_checklist_analytical_research =================
 $checklist__formulation_research = IA_checklist__formulation_research::where(['ia_id' => $id])->firstOrCreate();
 $checklist__formulation_research->ia_id = $id;


 
 for ($i = 1; $i <= 24; $i++)
 {
     $string = 'response_formulation_research_development_'. $i;
     $checklist__formulation_research->$string = $request->$string;
 }

 for ($i = 1; $i <= 24; $i++)
 {
     $string = 'remark_formulation_research_development_'. $i;
     $checklist__formulation_research->$string = $request->$string;
 }

 // dd($checklistTabletCompression->tablet_compress_remark_1)
 $checklist__formulation_research->remark_formulation_research_development_comment = $request->remark_formulation_research_development_comment;
 $checklist__formulation_research->save();


        if (!empty($request->inv_attachment)) {
            $files = [];
            if ($request->hasfile('inv_attachment')) {
                foreach ($request->file('inv_attachment') as $file) {
                    $name = $request->name . 'inv_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $internalAudit->inv_attachment = json_encode($files);
        }


        if (!empty($request->file_attachment)) {
            $files = [];
            if ($request->hasfile('file_attachment')) {
                foreach ($request->file('file_attachment') as $file) {
                    $name = $request->name . 'file_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $internalAudit->file_attachment = json_encode($files);
        }
        if (!empty($request->file_attachment_guideline)) {
            $files = [];
            if ($request->hasfile('file_attachment_guideline')) {
                foreach ($request->file('file_attachment_guideline') as $file) {
                    $name = $request->name . 'file_attachment_guideline' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $internalAudit->file_attachment_guideline= json_encode($files);
        }


        if (!empty($request->Audit_file)) {
            $files = [];
            if ($request->hasfile('Audit_file')) {
                foreach ($request->file('Audit_file') as $file) {
                    $name = $request->name . 'Audit_file' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $internalAudit->Audit_file = json_encode($files);
        }

        if (!empty($request->report_file)) {
            $files = [];
            if ($request->hasfile('report_file')) {
                foreach ($request->file('report_file') as $file) {
                    $name = $request->name . 'report_file' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $internalAudit->report_file = json_encode($files);
        }
        if (!empty($request->myfile)) {
            $files = [];
            if ($request->hasfile('myfile')) {
                foreach ($request->file('myfile') as $file) {
                    $name = $request->name . 'myfile' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $internalAudit->myfile = json_encode($files);
        }
        if (!empty($request->supproting_attachment)) {
            $files = [];
            if ($request->hasfile('supproting_attachment')) {
                foreach ($request->file('supproting_attachment') as $file) {
                    $name = $request->name . 'supproting_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $internalAudit->supproting_attachment = json_encode($files);
        }

        if (!empty($request->tablet_coating_supporting_attachment)) {
            $files = [];
            if ($request->hasfile('tablet_coating_supporting_attachment')) {
                foreach ($request->file('tablet_coating_supporting_attachment') as $file) {
                    $name = $request->name . 'tablet_coating_supporting_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $internalAudit->tablet_coating_supporting_attachment = json_encode($files);
        }
        if (!empty($request->dispensing_and_manufacturing_attachment)) {
            $files = [];
            if ($request->hasfile('dispensing_and_manufacturing_attachment')) {
                foreach ($request->file('dispensing_and_manufacturing_attachment') as $file) {
                    $name = $request->name . 'dispensing_and_manufacturing_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $internalAudit->dispensing_and_manufacturing_attachment = json_encode($files);

        }
        if (!empty($request->ointment_packing_attachment)) {
            $files = [];
            if ($request->hasfile('ointment_packing_attachment')) {
                foreach ($request->file('ointment_packing_attachment') as $file) {
                    $name = $request->name . 'ointment_packing_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $internalAudit->ointment_packing_attachment = json_encode($files);
        }
        if (!empty($request->engineering_response_attachment)) {
            $files = [];
            if ($request->hasfile('engineering_response_attachment')) {
                foreach ($request->file('engineering_response_attachment') as $file) {
                    $name = $request->name . 'engineering_response_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $internalAudit->engineering_response_attachment = json_encode($files);
        }
        if (!empty($request->quality_control_response_attachment)) {
            $files = [];
            if ($request->hasfile('quality_control_response_attachment')) {
                foreach ($request->file('quality_control_response_attachment') as $file) {
                    $name = $request->name . 'quality_control_response_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $internalAudit->quality_control_response_attachment = json_encode($files);
        }
        if (!empty($request->checklist_stores_response_attachment)) {
            $files = [];
            if ($request->hasfile('checklist_stores_response_attachment')) {
                foreach ($request->file('checklist_stores_response_attachment') as $file) {
                    $name = $request->name . 'checklist_stores_response_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $internalAudit->checklist_stores_response_attachment = json_encode($files);
        }
        if (!empty($request->checklist_hr_response_attachment)) {
            $files = [];
            if ($request->hasfile('checklist_hr_response_attachment')) {
                foreach ($request->file('checklist_hr_response_attachment') as $file) {
                    $name = $request->name . 'checklist_hr_response_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $internalAudit->checklist_hr_response_attachment = json_encode($files);
        }
        if (!empty($request->remark_injection_packing_attachment)) {
            $files = [];
            if ($request->hasfile('remark_injection_packing_attachment')) {
                foreach ($request->file('remark_injection_packing_attachment') as $file) {
                    $name = $request->name . 'remark_injection_packing_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $internalAudit->remark_injection_packing_attachment = json_encode($files);
        }
        if (!empty($request->remark_analytical_research_attachment)) {
            $files = [];
            if ($request->hasfile('remark_analytical_research_attachment')) {
                foreach ($request->file('remark_analytical_research_attachment') as $file) {
                    $name = $request->name . 'remark_analytical_research_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $internalAudit->remark_analytical_research_attachment = json_encode($files);
        }
        if (!empty($request->remark_powder_manufacturing_filling_attachment)) {
            $files = [];
            if ($request->hasfile('remark_powder_manufacturing_filling_attachment')) {
                foreach ($request->file('remark_powder_manufacturing_filling_attachment') as $file) {
                    $name = $request->name . 'remark_powder_manufacturing_filling_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $internalAudit->remark_powder_manufacturing_filling_attachment = json_encode($files);
        }
        if (!empty($request->remark_formulation_research_development_attachment)) {
            $files = [];
            if ($request->hasfile('remark_formulation_research_development_attachment')) {
                foreach ($request->file('remark_formulation_research_development_attachment') as $file) {
                    $name = $request->name . 'remark_formulation_research_development_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $internalAudit->remark_formulation_research_development_attachment = json_encode($files);
        }
        if (!empty($request->remark_documentation_name_attachment)) {
            $files = [];
            if ($request->hasfile('remark_documentation_name_attachment')) {
                foreach ($request->file('remark_documentation_name_attachment') as $file) {
                    $name = $request->name . 'remark_documentation_name_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $internalAudit->remark_documentation_name_attachment = json_encode($files);
        }
        if (!empty($request->tablet_capsule_packing_attachment)) {
            $files = [];
            if ($request->hasfile('tablet_capsule_packing_attachment')) {
                foreach ($request->file('tablet_capsule_packing_attachment') as $file) {
                    $name = $request->name . 'tablet_capsule_packing_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $internalAudit->tablet_capsule_packing_attachment = json_encode($files);
        }
        if (!empty($request->file_attach_add_2)) {
            $files = [];
            if ($request->hasfile('file_attach_add_2')) {
                foreach ($request->file('file_attach_add_2') as $file) {
                    $name = $request->name . 'file_attach_add_2' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $internalAudit->file_attach_add_2 = json_encode($files);
        }
        if (!empty($request->file_attach_add_1)) {
            $files = [];
            if ($request->hasfile('file_attach_add_1')) {
                foreach ($request->file('file_attach_add_1') as $file) {
                    $name = $request->name . 'file_attach_add_1' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $internalAudit->file_attach_add_1 = json_encode($files);
        }

        if (!empty($request->file_attach)) {
            $files = [];
            if ($request->hasfile('file_attach')) {
                foreach ($request->file('file_attach') as $file) {
                    $name = $request->name . 'file_attach' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $internalAudit->file_attach = json_encode($files);
            // dd($internalAudit->file_attach);
        }


        $internalAudit->update();

        $ia_id = $internalAudit->id;

        $auditAssessmentGrid = InternalAuditChecklistGrid::where(['ia_id' => $ia_id, 'identifier' => 'auditAssessmentChecklist'])->firstOrNew();
        $auditAssessmentGrid->ia_id = $ia_id;
        $auditAssessmentGrid->identifier = 'auditAssessmentChecklist';
        $auditAssessmentGrid->data = $request->auditAssessmentChecklist;
        $auditAssessmentGrid->save();

        $auditPersonnelGrid = InternalAuditChecklistGrid::where(['ia_id' => $ia_id, 'identifier' => 'auditPersonnelChecklist'])->firstOrNew();
        $auditPersonnelGrid->ia_id = $ia_id;
        $auditPersonnelGrid->identifier = 'auditPersonnelChecklist';
        $auditPersonnelGrid->data = $request->auditPersonnelChecklist;
        $auditPersonnelGrid->save();

        $auditfacilityGrid = InternalAuditChecklistGrid::where(['ia_id' => $ia_id, 'identifier' => 'auditfacilityChecklist'])->firstOrNew();
        $auditfacilityGrid->ia_id = $ia_id;
        $auditfacilityGrid->identifier = 'auditfacilityChecklist';
        $auditfacilityGrid->data = $request->auditfacilityChecklist;
        $auditfacilityGrid->save();

        $auditMachinesGrid = InternalAuditChecklistGrid::where(['ia_id' => $ia_id, 'identifier' => 'auditMachinesChecklist'])->firstOrNew();
        $auditMachinesGrid->ia_id = $ia_id;
        $auditMachinesGrid->identifier = 'auditMachinesChecklist';
        $auditMachinesGrid->data = $request->auditMachinesChecklist;
        $auditMachinesGrid->save();

        $auditProductionGrid = InternalAuditChecklistGrid::where(['ia_id' => $ia_id, 'identifier' => 'auditProductionChecklist'])->firstOrNew();
        $auditProductionGrid->ia_id = $ia_id;
        $auditProductionGrid->identifier = 'auditProductionChecklist';
        $auditProductionGrid->data = $request->auditProductionChecklist;
        $auditProductionGrid->save();

        $auditMaterialsGrid = InternalAuditChecklistGrid::where(['ia_id' => $ia_id, 'identifier' => 'auditMaterialsChecklist'])->firstOrNew();
        $auditMaterialsGrid->ia_id = $ia_id;
        $auditMaterialsGrid->identifier = 'auditMaterialsChecklist';
        $auditMaterialsGrid->data = $request->auditMaterialsChecklist;
        $auditMaterialsGrid->save();

        $auditQualityGrid = InternalAuditChecklistGrid::where(['ia_id' => $ia_id, 'identifier' => 'auditQualityControlChecklist'])->firstOrNew();
        $auditQualityGrid->ia_id = $ia_id;
        $auditQualityGrid->identifier = 'auditQualityControlChecklist';
        $auditQualityGrid->data = $request->auditQualityControlChecklist;
        $auditQualityGrid->save();

        $auditQualityAssuranceGrid = InternalAuditChecklistGrid::where(['ia_id' => $ia_id, 'identifier' => 'auditQualityAssuranceChecklist'])->firstOrNew();
        $auditQualityAssuranceGrid->ia_id = $ia_id;
        $auditQualityAssuranceGrid->identifier = 'auditQualityAssuranceChecklist';
        $auditQualityAssuranceGrid->data = $request->auditQualityAssuranceChecklist;
        $auditQualityAssuranceGrid->save();

        $auditPackagingGrid = InternalAuditChecklistGrid::where(['ia_id' => $ia_id, 'identifier' => 'auditPackagingChecklist'])->firstOrNew();
        $auditPackagingGrid->ia_id = $ia_id;
        $auditPackagingGrid->identifier = 'auditPackagingChecklist';
        $auditPackagingGrid->data = $request->auditPackagingChecklist;
        $auditPackagingGrid->save();

        $auditsheGrid = InternalAuditChecklistGrid::where(['ia_id' => $ia_id, 'identifier' => 'auditSheChecklist'])->firstOrNew();
        $auditsheGrid->ia_id = $ia_id;
        $auditsheGrid->identifier = 'auditSheChecklist';
        $auditsheGrid->data = $request->auditSheChecklist;
        $auditsheGrid->save();

        $internalAuditComments = InternalAuditChecklistGrid::where(['ia_id' => $ia_id])->firstOrNew();        
        $internalAuditComments->auditSheChecklist_comment = $request->auditSheChecklist_comment;
        if (!empty($request->auditSheChecklist_attachment)) {
            $files = [];
            if ($request->hasfile('auditSheChecklist_attachment')) {
                foreach ($request->file('auditSheChecklist_attachment') as $file) {
                    $name = "IA-" . 'auditSheChecklist_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $internalAuditComments->auditSheChecklist_attachment = json_encode($files);
            // dd($internalAuditComments->auditSheChecklist_attachment);
        }
        $internalAuditComments->save();

        $data3 = InternalAuditGrid::where('audit_id',$internalAudit->id)->where('type','internal_audit')->first();
        if (!empty($request->audit)) {
            $data3->area_of_audit = serialize($request->audit);
        }
        if (!empty($request->scheduled_start_date)) {
            $data3->start_date = serialize($request->scheduled_start_date);
        }
        if (!empty($request->scheduled_start_time)) {
            $data3->start_time = serialize($request->scheduled_start_time);
        }
        if (!empty($request->scheduled_end_date)) {
            $data3->end_date = serialize($request->scheduled_end_date);
        }
        if (!empty($request->scheduled_end_time)) {
            $data3->end_time = serialize($request->scheduled_end_time);
        }
        if (!empty($request->auditor)) {
            $data3->auditor = serialize($request->auditor);
        }
        if (!empty($request->auditee)) {
            $data3->auditee = serialize($request->auditee);
        }
        if (!empty($request->remark)) {
            $data3->remark = serialize($request->remark);
        }
        $data3->update();

        $data4 = InternalAuditGrid::where('audit_id',$internalAudit->id)->where('type','Observation_field')->first();

        if (!empty($request->observation_id)) {
            $data4->observation_id = serialize($request->observation_id);
        }
        if (!empty($request->date)) {
            $data4->date = serialize($request->date);
        }
        if (!empty($request->auditorG)) {
            $data4->auditor = serialize($request->auditorG);
        }
        if (!empty($request->auditeeG)) {
            $data4->auditee = serialize($request->auditeeG);
        }
        if (!empty($request->observation_description)) {
            $data4->observation_description = serialize($request->observation_description);
        }
        if (!empty($request->severity_level)) {
            $data4->severity_level = serialize($request->severity_level);
        }
        if (!empty($request->area)) {
            $data4->area = serialize($request->area);
        }
        if (!empty($request->observation_category)) {
            $data4->observation_category = serialize($request->observation_category);
        }
         if (!empty($request->capa_required)) {
            $data4->capa_required = serialize($request->capa_required);
        }
         if (!empty($request->auditee_response)) {
            $data4->auditee_response = serialize($request->auditee_response);
        }
        if (!empty($request->auditor_review_on_response)) {
            $data4->auditor_review_on_response = serialize($request->auditor_review_on_response);
        }
        if (!empty($request->qa_comment)) {
            $data4->qa_comment = serialize($request->qa_comment);
        }
        if (!empty($request->capa_details)) {
            $data4->capa_details = serialize($request->capa_details);
        }
        if (!empty($request->capa_due_date)) {
            $data4->capa_due_date = serialize($request->capa_due_date);
        }
        if (!empty($request->capa_owner)) {
            $data4->capa_owner = serialize($request->capa_owner);
        }
        if (!empty($request->action_taken)) {
            $data4->action_taken = serialize($request->action_taken);
        }
        if (!empty($request->capa_completion_date)) {
            $data4->capa_completion_date = serialize($request->capa_completion_date);
        }
        if (!empty($request->status_Observation)) {
            $data4->status = serialize($request->status_Observation);
        }
        if (!empty($request->remark_observation)) {
            $data4->remark = serialize($request->remark_observation);
        }
        $data4->update();

        if ($lastDocument->short_description != $internalAudit->short_description || !empty($request->comment)) {

            $history = new InternalAuditTrial();
            $history->InternalAudit_id = $id;
            $history->activity_type = 'Short Description';
            $history->previous = $lastDocument->short_description;
            $history->current = $internalAudit->short_description;
            $history->comment = $request->comment;
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

        // if ($lastDocument->date != $internalAudit->date || !empty($request->date_comment)) {

        //     $history = new InternalAuditTrial();
        //     $history->InternalAudit_id = $id;
        //     $history->activity_type = 'Date of Initiator';
        //     $history->previous = $lastDocument->date;
        //     $history->current = $internalAudit->date;
        //     $history->comment = $request->date_comment;
        //     $history->user_id = Auth::user()->id;
        //     $history->user_name = Auth::user()->name;
        //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        //     $history->origin_state = $lastDocument->status;
        //     $history->save();
        // }
        // if ($lastDocument->assign_to != $internalAudit->assign_to || !empty($request->assign_to_comment)) {

        //     $history = new InternalAuditTrial();
        //     $history->InternalAudit_id = $id;
        //     $history->activity_type = 'Assigned to';
        //     $history->previous = $lastDocument->assign_to;
        //     $history->current = $internalAudit->assign_to;
        //     $history->comment = $request->date_comment;
        //     $history->user_id = Auth::user()->id;
        //     $history->user_name = Auth::user()->name;
        //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        //     $history->origin_state = $lastDocument->status;
        //     $history->save();
        // }





        if ($lastDocument->assign_to != $request->assign_to) {
            $lastDocumentAuditTrail = InternalAuditTrial::where('InternalAudit_id', $id)
            ->where('activity_type', 'Assigned to')
            ->exists();
            $history = new InternalAuditTrial;
            $history->InternalAudit_id = $id;
            $history->activity_type = 'Assigned to';
            $history->previous = Helpers::getInitiatorName($lastDocument->assign_to);
            $history->current =Helpers::getInitiatorName($internalAudit->assign_to);
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

        // if ($lastDocument->Initiator_Group!= $internalAudit->Initiator_Group|| !empty($request->Initiator_Group_comment)) {

        //     $history = new InternalAuditTrial();
        //     $history->InternalAudit_id = $id;
        //     $history->activity_type = 'Initiator Group ';
        //     $history->previous = $lastDocument->Initiator_Group;
        //     $history->current = $internalAudit->Initiator_Group;
        //     $history->comment = $request->date_comment;
        //     $history->user_id = Auth::user()->id;
        //     $history->user_name = Auth::user()->name;
        //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        //     $history->origin_state = $lastDocument->status;
        //     $history->save();
        // }


        // dd(Helpers::getInitiatorGroupData($internalAudit->Initiator_Group));
        // dd($request->Initiator_Group);
        // dd($request->Initiator_Group);
        if($lastDocument->Initiator_Group != $request->Initiator_Group){
            $lastDocumentAuditTrail = InternalAuditTrial::where('InternalAudit_id', $internalAudit->id)
            ->where('activity_type', 'Initiator Group ')
            ->exists();
            $history = new InternalAuditTrial;
            $history->InternalAudit_id = $lastDocument->id;
            $history->activity_type = 'Initiator Group ';
            if($lastDocument->Initiator_Group == null){
                $history->previous = "Not Applicable";
            } else{
                $history->previous = Helpers::getFullDepartmentName($lastDocument->Initiator_Group);
            }
            $history->current = Helpers::getFullDepartmentName($request->Initiator_Group);
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

        if($lastDocument->initiator_group_code != $request->initiator_group_code){
            $lastDocumentAuditTrail = InternalAuditTrial::where('InternalAudit_id', $internalAudit->id)
            ->where('activity_type', 'Initiator Group  Code')
            ->exists();
            $history = new InternalAuditTrial;
            $history->InternalAudit_id = $lastDocument->id;
            $history->activity_type = 'Initiator Group  Code';
            if($lastDocument->initiator_group_code == null){
                $history->previous = "Not Applicable";
            } else{
                $history->previous = $lastDocument->initiator_group_code;
            }
            $history->current = $request->initiator_group_code;
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

        if($lastDocument->res_ver != $request->res_ver){
            $lastDocumentAuditTrail = InternalAuditTrial::where('InternalAudit_id', $internalAudit->id)
            ->where('activity_type', 'Response Verification Comment')
            ->exists();
            $history = new InternalAuditTrial;
            $history->InternalAudit_id = $lastDocument->id;
            $history->activity_type = 'Response Verification Comment';
            if($lastDocument->res_ver == null){
                $history->previous = "Not Applicable";
            } else{
                $history->previous = $lastDocument->res_ver;
            }
            $history->current = $request->res_ver;
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

        // if($lastDocument->attach_file_rv != $request->attach_file_rv){
        //     $lastDocumentAuditTrail = InternalAuditTrial::where('InternalAudit_id', $internalAudit->id)
        //     ->where('activity_type', 'Response verification Attachments')
        //     ->exists();
        //     $history = new InternalAuditTrial;
        //     $history->InternalAudit_id = $lastDocument->id;
        //     $history->activity_type = 'Response verification Attachments';
        //     if($lastDocument->attach_file_rv == null){
        //         $history->previous = "Not Applicable";
        //     } else{
        //         $history->previous = $lastDocument->attach_file_rv;
        //     }
        //     $history->current = $request->attach_file_rv;
        //     $history->comment = "Not Applicable";
        //     $history->user_id = Auth::user()->id;
        //     $history->user_name = Auth::user()->name;
        //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        //     $history->origin_state = $lastDocument->status;
        //     $history->change_to =   "Not Applicable";
        //     $history->change_from = $lastDocument->status;
        //     $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
        //     $history->save();
        // }

        $previousAttachments5 = $lastDocument->attach_file_rv;
        $areIniAttachmentsSame5 = $previousAttachments5 == $internalAudit->attach_file_rv;

        if ($areIniAttachmentsSame5 != true) {
            $lastDocumentAuditTrail = InternalAuditTrial::where('InternalAudit_id', $internalAudit->id)
                ->where('activity_type', 'Response verification Attachments')
                ->exists();
                    $history = new InternalAuditTrial;
                    $history->InternalAudit_id = $id;
                    $history->activity_type = 'Response verification Attachments';
                    $history->previous = $previousAttachments5;
                    $history->current = $internalAudit->attach_file_rv;
                    $history->comment = "Not Applicable";
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $lastDocument->status;
                    $history->change_to =   "Not Applicable";
                    $history->change_from = $lastDocument->status;
                    if ($lastDocumentAuditTrail) {
                        $history->action_name = "Update";
                    } else {
                        $history->action_name = "New";
                    }
                    $history->save();
                }

        // if ($lastDocument->short_description != $internalAudit->short_description || !empty($request->short_description_comment)) {

        //     $history = new InternalAuditTrial();
        //     $history->InternalAudit_id = $id;
        //     $history->activity_type = 'Short Description';
        //     $history->previous = $lastDocument->short_description;
        //     $history->current = $internalAudit->short_description;
        //     $history->comment = $request->date_comment;
        //     $history->user_id = Auth::user()->id;
        //     $history->user_name = Auth::user()->name;
        //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        //     $history->origin_state = $lastDocument->status;
        //     $history->save();
        // }
        // dd($lastDocument->short_description != $request->short_description);

      
        if($lastDocument->due_date != $request->due_date){
            $lastDocumentAuditTrail = InternalAuditTrial::where('InternalAudit_id', $internalAudit->id)
            ->where('activity_type', 'Due Date')
            ->exists();
            $history = new InternalAuditTrial;
            $history->InternalAudit_id = $lastDocument->id;
            $history->activity_type = 'Due Date';
            if($lastDocument->due_date == null){
                $history->previous = "Not Applicable";
            } else{
                $history->previous = Helpers::getdateFormat($lastDocument->due_date);
            }
            $history->current =Helpers::getdateFormat( $request->due_date);
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
        // dd($lastDocument->auditee_department != $request->auditee_department);
        if($lastDocument->auditee_department != $request->auditee_department){
            $lastDocumentAuditTrail = InternalAuditTrial::where('InternalAudit_id', $internalAudit->id)
            ->where('activity_type', 'Auditee department Name')
            ->exists();
            $history = new InternalAuditTrial;
            $history->InternalAudit_id = $lastDocument->id;
            $history->activity_type = 'Auditee department Name';
            if($lastDocument->auditee_department == null){
                $history->previous = "Not Applicable";
            } else{
                $history->previous =Helpers::getFullDepartmentName($lastDocument->auditee_department);
            }
            $history->current = Helpers::getFullDepartmentName($request->auditee_department);
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
        if($lastDocument->sch_audit_start_date != $request->sch_audit_start_date){
            $lastDocumentAuditTrail = InternalAuditTrial::where('InternalAudit_id', $internalAudit->id)
            ->where('activity_type', 'Scheduled audit date')
            ->exists();
            $history = new InternalAuditTrial;
            $history->InternalAudit_id = $lastDocument->id;
            $history->activity_type = 'Scheduled audit date';
            if($lastDocument->sch_audit_start_date == null){
                $history->previous = "Not Applicable";
            } else{
                $history->previous =  Helpers::getdateFormat($lastDocument->sch_audit_start_date);
            }
            $history->current =  Helpers::getdateFormat($request->sch_audit_start_date);
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
        if($lastDocument->Auditee_comment != $request->Auditee_comment){
            $lastDocumentAuditTrail = InternalAuditTrial::where('InternalAudit_id', $internalAudit->id)
            ->where('activity_type', 'Auditee Comment')
            ->exists();
            $history = new InternalAuditTrial;
            $history->InternalAudit_id = $lastDocument->id;
            $history->activity_type = 'Auditee Comment';
            if($lastDocument->Auditee_comment == null){
                $history->previous = "Not Applicable";
            } else{
                $history->previous = $lastDocument->Auditee_comment;
            }
            $history->current = $request->Auditee_comment;
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
        if($lastDocument->Auditor_comment != $request->Auditor_comment){
            $lastDocumentAuditTrail = InternalAuditTrial::where('InternalAudit_id', $internalAudit->id)
            ->where('activity_type', 'Auditor Comment')
            ->exists();
            $history = new InternalAuditTrial;
            $history->InternalAudit_id = $lastDocument->id;
            $history->activity_type = 'Auditor Comment';
            if($lastDocument->Auditor_comment == null){
                $history->previous = "Not Applicable";
            } else{
                $history->previous = $lastDocument->Auditor_comment;
            }
            $history->current = $request->Auditor_comment;
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

        if($lastDocument->initiated_through != $request->initiated_through){
            $lastDocumentAuditTrail = InternalAuditTrial::where('InternalAudit_id', $internalAudit->id)
            ->where('activity_type', 'Initiated Through')
            ->exists();
            $history = new InternalAuditTrial;
            $history->InternalAudit_id = $lastDocument->id;
            $history->activity_type = 'Initiated Through';
            if($lastDocument->initiated_through == null){
                $history->previous = "Not Applicable";
            } else{
                $history->previous = $lastDocument->initiated_through;
            }
            $history->current = $request->initiated_through;
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

        if ($lastDocument->audit_type != $internalAudit->audit_type || !empty($request->audit_type_comment)) {

            $history = new InternalAuditTrial();
            $history->InternalAudit_id = $id;
            $history->activity_type = 'Type of Audit';
            $history->previous = $lastDocument->audit_type;
            $history->current = $internalAudit->audit_type;
            $history->comment = $request->date_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->save();
        }

        if($lastDocument->audit_type != $request->audit_type){
            $lastDocumentAuditTrail = InternalAuditTrial::where('InternalAudit_id', $internalAudit->id)
            ->where('activity_type', 'Type of Audit')
            ->exists();
            $history = new InternalAuditTrial;
            $history->InternalAudit_id = $lastDocument->id;
            $history->activity_type = 'Type of Audit';
            if($lastDocument->audit_type == null){
                $history->previous = "Not Applicable";
            } else{
                $history->previous = $lastDocument->audit_type;
            }
            $history->current = $request->audit_type;
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

        if ($lastDocument->if_other != $internalAudit->if_other || !empty($request->if_other_comment)) {

            $history = new InternalAuditTrial();
            $history->InternalAudit_id = $id;
            $history->activity_type = 'If Other';
            $history->previous = $lastDocument->if_other;
            $history->current = $internalAudit->if_other;
            $history->comment = $request->date_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->save();
        }

        // if($lastDocument->if_other != $request->if_other){
        //     $lastDocumentAuditTrail = InternalAuditTrial::where('InternalAudit_id', $internalAudit->id)
        //     ->where('activity_type', 'If Other')
        //     ->exists();
        //     $history = new InternalAuditTrial;
        //     $history->InternalAudit_id = $lastDocument->id;
        //     $history->activity_type = 'If Other';
        //     if($lastDocument->if_other == null){
        //         $history->previous = "Not Applicable";
        //     } else{
        //         $history->previous = $lastDocument->if_other;
        //     }
        //     $history->current = $request->if_other;
        //     $history->comment = "Not Applicable";
        //     $history->user_id = Auth::user()->id;
        //     $history->user_name = Auth::user()->name;
        //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        //     $history->origin_state = $lastDocument->status;
        //     $history->change_to =   "Not Applicable";
        //     $history->change_from = $lastDocument->status;
        //     $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
        //     $history->save();
        // }

        if($lastDocument->initiated_if_other != $request->initiated_if_other){
            $lastDocumentAuditTrail = InternalAuditTrial::where('InternalAudit_id', $internalAudit->id)
            ->where('activity_type', 'Other')
            ->exists();
            $history = new InternalAuditTrial;
            $history->InternalAudit_id = $lastDocument->id;
            $history->activity_type = 'Other';
            if($lastDocument->initiated_if_other == null){
                $history->previous = "Not Applicable";
            } else{
                $history->previous = $lastDocument->initiated_if_other;
            }
            $history->current = $request->initiated_if_other;
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

        // if ($lastDocument->initial_comments != $internalAudit->initial_comments || !empty($request->initial_comments_comment)) {

        //     $history = new InternalAuditTrial();
        //     $history->InternalAudit_id = $id;
        //     $history->activity_type = 'Initial Comments';
        //     $history->previous = $lastDocument->initial_comments;
        //     $history->current = $internalAudit->initial_comments;
        //     $history->comment = $request->date_comment;
        //     $history->user_id = Auth::user()->id;
        //     $history->user_name = Auth::user()->name;
        //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        //     $history->origin_state = $lastDocument->status;
        //     $history->save();
        // }


        if($lastDocument->initial_comments != $request->initial_comments){
            $lastDocumentAuditTrail = InternalAuditTrial::where('InternalAudit_id', $internalAudit->id)
            ->where('activity_type', 'Description')
            ->exists();
            $history = new InternalAuditTrial;
            $history->InternalAudit_id = $lastDocument->id;
            $history->activity_type = 'Description';
            if($lastDocument->initial_comments == null){
                $history->previous = "Not Applicable";
            } else{
                $history->previous = $lastDocument->initial_comments;
            }
            $history->current = $request->initial_comments;
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

        if($lastDocument->external_agencies != $request->external_agencies){
            $lastDocumentAuditTrail = InternalAuditTrial::where('InternalAudit_id', $internalAudit->id)
            ->where('activity_type', 'External Agencies')
            ->exists();
            $history = new InternalAuditTrial;
            $history->InternalAudit_id = $lastDocument->id;
            $history->activity_type = 'External Agencies';
            if($lastDocument->external_agencies == null){
                $history->previous = "Not Applicable";
            } else{
                $history->previous = $lastDocument->external_agencies;
            }
            $history->current = $request->external_agencies;
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


        if($lastDocument->Others != $request->Others){
            $lastDocumentAuditTrail = InternalAuditTrial::where('InternalAudit_id', $internalAudit->id)
            ->where('activity_type', 'Others')
            ->exists();
            $history = new InternalAuditTrial;
            $history->InternalAudit_id = $lastDocument->id;
            $history->activity_type = 'Others';
            if($lastDocument->Others == null){
                $history->previous = "Not Applicable";
            } else{
                $history->previous = $lastDocument->Others;
            }
            $history->current = $request->Others;
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

        if($lastDocument->audit_schedule_start_date != $request->audit_schedule_start_date){
            $lastDocumentAuditTrail = InternalAuditTrial::where('InternalAudit_id', $internalAudit->id)
            ->where('activity_type', 'Audit Schedule Start Date')
            ->exists();
            $history = new InternalAuditTrial;
            $history->InternalAudit_id = $lastDocument->id;
            $history->activity_type = 'Audit Schedule Start Date';
            if($lastDocument->audit_schedule_start_date == null){
                $history->previous = "Not Applicable";
            } else{
                $history->previous = $lastDocument->audit_schedule_start_date;
            }
            $history->current = $request->audit_schedule_start_date;
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

        if($lastDocument->audit_schedule_end_date != $request->audit_schedule_end_date){
            $lastDocumentAuditTrail = InternalAuditTrial::where('InternalAudit_id', $internalAudit->id)
            ->where('activity_type', 'Audit Schedule End Date')
            ->exists();
            $history = new InternalAuditTrial;
            $history->InternalAudit_id = $lastDocument->id;
            $history->activity_type = 'Audit Schedule End Date';
            if($lastDocument->audit_schedule_end_date == null){
                $history->previous = "Not Applicable";
            } else{
                $history->previous = $lastDocument->audit_schedule_end_date;
            }
            $history->current = $request->audit_schedule_end_date;
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

        if($lastDocument->material_name != $request->material_name){
            $lastDocumentAuditTrail = InternalAuditTrial::where('InternalAudit_id', $internalAudit->id)
            ->where('activity_type', 'Product/Material Name')
            ->exists();
            $history = new InternalAuditTrial;
            $history->InternalAudit_id = $lastDocument->id;
            $history->activity_type = 'Product/Material Name';
            if($lastDocument->material_name == null){
                $history->previous = "Not Applicable";
            } else{
                $history->previous = $lastDocument->material_name;
            }
            $history->current = $request->material_name;
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


        if($lastDocument->if_comments != $request->if_comments){
            $lastDocumentAuditTrail = InternalAuditTrial::where('InternalAudit_id', $internalAudit->id)
            ->where('activity_type', 'Comments(If Any)')
            ->exists();
            $history = new InternalAuditTrial;
            $history->InternalAudit_id = $lastDocument->id;
            $history->activity_type = 'Comments(If Any)';
            if($lastDocument->if_comments == null){
                $history->previous = "Not Applicable";
            } else{
                $history->previous = $lastDocument->if_comments;
            }
            $history->current = $request->if_comments;
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

        if($lastDocument->lead_auditor != $request->lead_auditor){
            $lastDocumentAuditTrail = InternalAuditTrial::where('InternalAudit_id', $internalAudit->id)
            ->where('activity_type', 'Lead Auditor')
            ->exists();
            $history = new InternalAuditTrial;
            $history->InternalAudit_id = $lastDocument->id;
            $history->activity_type = 'Lead Auditor';
            if($lastDocument->lead_auditor == null){
                $history->previous = "Not Applicable";
            } else{
                $history->previous = $lastDocument->lead_auditor;
            }
            $history->current = $request->lead_auditor;
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

        if($lastDocument->Auditor_Details != $request->Auditor_Details){
            $lastDocumentAuditTrail = InternalAuditTrial::where('InternalAudit_id', $internalAudit->id)
            ->where('activity_type', 'External Auditor Details')
            ->exists();
            $history = new InternalAuditTrial;
            $history->InternalAudit_id = $lastDocument->id;
            $history->activity_type = 'External Auditor Details';
            if($lastDocument->Auditor_Details == null){
                $history->previous = "Not Applicable";
            } else{
                $history->previous = $lastDocument->Auditor_Details;
            }
            $history->current = $request->Auditor_Details;
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

        if($lastDocument->External_Auditing_Agency != $request->External_Auditing_Agency){
            $lastDocumentAuditTrail = InternalAuditTrial::where('InternalAudit_id', $internalAudit->id)
            ->where('activity_type', 'External Auditing Agency')
            ->exists();
            $history = new InternalAuditTrial;
            $history->InternalAudit_id = $lastDocument->id;
            $history->activity_type = 'External Auditing Agency';
            if($lastDocument->External_Auditing_Agency == null){
                $history->previous = "Not Applicable";
            } else{
                $history->previous = $lastDocument->External_Auditing_Agency;
            }
            $history->current = $request->External_Auditing_Agency;
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

        if($lastDocument->Relevant_Guideline != $request->Relevant_Guideline){
            $lastDocumentAuditTrail = InternalAuditTrial::where('InternalAudit_id', $internalAudit->id)
            ->where('activity_type', 'Relevant Guidelines / Industry Standards')
            ->exists();
            $history = new InternalAuditTrial;
            $history->InternalAudit_id = $lastDocument->id;
            $history->activity_type = 'Relevant Guidelines / Industry Standards';
            if($lastDocument->Relevant_Guideline == null){
                $history->previous = "Not Applicable";
            } else{
                $history->previous = $lastDocument->Relevant_Guideline;
            }
            $history->current = $request->Relevant_Guideline;
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
        if($lastDocument->QA_Comments != $request->QA_Comments){
            $lastDocumentAuditTrail = InternalAuditTrial::where('InternalAudit_id', $internalAudit->id)
            ->where('activity_type', 'QA Comments')
            ->exists();
            $history = new InternalAuditTrial;
            $history->InternalAudit_id = $lastDocument->id;
            $history->activity_type = 'QA Comments';
            if($lastDocument->QA_Comments == null){
                $history->previous = "Not Applicable";
            } else{
                $history->previous = $lastDocument->QA_Comments;
            }
            $history->current = $request->QA_Comments;
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
        if($lastDocument->Audit_Category != $request->Audit_Category){
            $lastDocumentAuditTrail = InternalAuditTrial::where('InternalAudit_id', $internalAudit->id)
            ->where('activity_type', 'Audit Category')
            ->exists();
            $history = new InternalAuditTrial;
            $history->InternalAudit_id = $lastDocument->id;
            $history->activity_type = 'Audit Category';
            if($lastDocument->Audit_Category == null){
                $history->previous = "Not Applicable";
            } else{
                $history->previous = $lastDocument->Audit_Category;
            }
            $history->current = $request->Audit_Category;
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
        if($lastDocument->Supplier_Details != $request->Supplier_Details){
            $lastDocumentAuditTrail = InternalAuditTrial::where('InternalAudit_id', $internalAudit->id)
            ->where('activity_type', 'Supplier/Vendor/Manufacturer Details')
            ->exists();
            $history = new InternalAuditTrial;            $history->InternalAudit_id = $lastDocument->id;
            $history->activity_type = 'Supplier/Vendor/Manufacturer Details';
            if($lastDocument->Supplier_Details == null){
                $history->previous = "Not Applicable";
            } else{
                $history->previous = $lastDocument->Supplier_Details;
            }
            $history->current = $request->Supplier_Details;
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
        if($lastDocument->Supplier_Site != $request->Supplier_Site){
            $lastDocumentAuditTrail = InternalAuditTrial::where('InternalAudit_id', $internalAudit->id)
            ->where('activity_type', 'Supplier/Vendor/Manufacturer Site')
            ->exists();
            $history = new InternalAuditTrial;
            $history->InternalAudit_id = $lastDocument->id;
            $history->activity_type = 'Supplier/Vendor/Manufacturer Site';
            if($lastDocument->Supplier_Site == null){
                $history->previous = "Not Applicable";
            } else{
                $history->previous = $lastDocument->Supplier_Site;
            }
            $history->current = $request->Supplier_Site;
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
        if($lastDocument->Comments != $request->Comments){
            $lastDocumentAuditTrail = InternalAuditTrial::where('InternalAudit_id', $internalAudit->id)
            ->where('activity_type', 'Comments')
            ->exists();
            $history = new InternalAuditTrial;
            $history->InternalAudit_id = $lastDocument->id;
            $history->activity_type = 'Comments';
            if($lastDocument->Comments == null){
                $history->previous = "Not Applicable";
            } else{
                $history->previous = $lastDocument->Comments;
            }
            $history->current = $request->Comments;
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
        if($lastDocument->audit_start_date != $request->audit_start_date){
            $lastDocumentAuditTrail = InternalAuditTrial::where('InternalAudit_id', $internalAudit->id)
            ->where('activity_type', 'Audit Start Date')
            ->exists();
            $history = new InternalAuditTrial;
            $history->InternalAudit_id = $lastDocument->id;
            $history->activity_type = 'Audit Start Date';
            if($lastDocument->audit_start_date == null){
                $history->previous = "Not Applicable";
            } else{
                $history->previous =Helpers::getdateFormat ($lastDocument->audit_start_date);
            }
            $history->current = Helpers::getdateFormat($request->audit_start_date);
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
        if($lastDocument->audit_end_date != $request->audit_end_date){
            $lastDocumentAuditTrail = InternalAuditTrial::where('InternalAudit_id', $internalAudit->id)
            ->where('activity_type', 'Audit End Date')
            ->exists();
            $history = new InternalAuditTrial;
            $history->InternalAudit_id = $lastDocument->id;
            $history->activity_type = 'Audit End Date';
            if($lastDocument->audit_end_date == null){
                $history->previous = "Not Applicable";
            } else{
                $history->previous = Helpers::getdateFormat ($lastDocument->audit_end_date);
            }
            $history->current =Helpers::getdateFormat( $request->audit_end_date);
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
        if($lastDocument->severity_level_form != $request->severity_level_form){
            $lastDocumentAuditTrail = InternalAuditTrial::where('InternalAudit_id', $internalAudit->id)
            ->where('activity_type', 'Severity Level')
            ->exists();
            $history = new InternalAuditTrial;
            $history->InternalAudit_id = $lastDocument->id;
            $history->activity_type = 'Severity Level';
            if($lastDocument->severity_level_form == null){
                $history->previous = "Not Applicable";
            } else{
                $history->previous = $lastDocument->severity_level_form;
            }
            $history->current = $request->severity_level_form;
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
        if($lastDocument->Audit_Comments1 != $request->Audit_Comments1){
            $lastDocumentAuditTrail = InternalAuditTrial::where('InternalAudit_id', $internalAudit->id)
            ->where('activity_type', 'Audit Comments')
            ->exists();
            $history = new InternalAuditTrial;
            $history->InternalAudit_id = $lastDocument->id;
            $history->activity_type = 'Audit Comments';
            if($lastDocument->Audit_Comments1 == null){
                $history->previous = "Not Applicable";
            } else{
                $history->previous = $lastDocument->Audit_Comments1;
            }
            $history->current = $request->Audit_Comments1;
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
        if($lastDocument->Remarks != $request->Remarks){
            $lastDocumentAuditTrail = InternalAuditTrial::where('InternalAudit_id', $internalAudit->id)
            ->where('activity_type', 'Remarks')
            ->exists();
            $history = new InternalAuditTrial;
            $history->InternalAudit_id = $lastDocument->id;
            $history->activity_type = 'Remarks';
            if($lastDocument->Remarks == null){
                $history->previous = "Not Applicable";
            } else{
                $history->previous = $lastDocument->Remarks;
            }
            $history->current = $request->Remarks;
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
        // if($lastDocument->refrence_record != implode(',', $request->refrence_record)){
        //     $lastDocumentAuditTrail = InternalAuditTrial::where('InternalAudit_id', $internalAudit->id)
        //     ->where('activity_type', 'Reference Record')
        //     ->exists();
        //     $history = new InternalAuditTrial;
        //     $history->InternalAudit_id = $lastDocument->id;
        //     $history->activity_type = 'Reference Record';
        //     if($lastDocument->refrence_record == null){
        //         $history->previous = "Not Applicable";
        //     } else{
        //         $history->previous = implode(',', $lastDocument->refrence_record);
        //     }
        //     $history->current = $request->refrence_record;
        //     $history->comment = "Not Applicable";
        //     $history->user_id = Auth::user()->id;
        //     $history->user_name = Auth::user()->name;
        //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        //     $history->origin_state = $lastDocument->status;
        //     $history->change_to =   "Not Applicable";
        //     $history->change_from = $lastDocument->status;
        //     $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
        //     $history->save();
        // }
        if($lastDocument->Audit_team != $request->Audit_team){
            $lastDocumentAuditTrail = InternalAuditTrial::where('InternalAudit_id', $internalAudit->id)
            ->where('activity_type', 'Audit Team')
            ->exists();
            $history = new InternalAuditTrial;
            $history->InternalAudit_id = $lastDocument->id;
            $history->activity_type = 'Audit Team';
            if($lastDocument->Audit_team == null){
                $history->previous = "Not Applicable";
            } else{
                $history->previous = $lastDocument->Remarks;
            }
            $history->current = $request->Remarks;
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
        if($lastDocument->Auditee != $request->Auditee){
            $lastDocumentAuditTrail = InternalAuditTrial::where('InternalAudit_id', $internalAudit->id)
            ->where('activity_type', 'Auditee')
            ->exists();
            $history = new InternalAuditTrial;
            $history->InternalAudit_id = $lastDocument->id;
            $history->activity_type = 'Auditee';
            if($lastDocument->Auditee == null){
                $history->previous = "Not Applicable";
            } else{
                $history->previous = $lastDocument->Remarks;
            }
            $history->current = $request->Remarks;
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
        if($lastDocument->Audit_Comments2 != $request->Audit_Comments2){
            $lastDocumentAuditTrail = InternalAuditTrial::where('InternalAudit_id', $internalAudit->id)
            ->where('activity_type', 'Audit Comments')
            ->exists();
            $history = new InternalAuditTrial;
            $history->InternalAudit_id = $lastDocument->id;
            $history->activity_type = 'Audit Comments';
            if($lastDocument->Audit_Comments2 == null){
                $history->previous = "Not Applicable";
            } else{
                $history->previous = $lastDocument->Audit_Comments2;
            }
            $history->current = $request->Audit_Comments2;
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
        // if ($lastDocument->file_attachment_guideline != $internalAudit->file_attachment_guideline || !empty($request->file_attachment_comment)) {

        //     $history = new InternalAuditTrial();
        //     $history->InternalAudit_id = $id;
        //     $history->activity_type = 'Audit Preparation and Execution Attachment';
        //     $history->previous = $lastDocument->file_attachment_guideline;
        //     $history->current = $internalAudit->file_attachment_guideline;
        //     $history->comment = $request->date_comment;
        //     $history->user_id = Auth::user()->id;
        //     $history->user_name = Auth::user()->name;
        //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        //     $history->origin_state = $lastDocument->status;
        //     $history->save();
        // }
        if($lastDocument->due_date_extension != $request->due_date_extension){
            $lastDocumentAuditTrail = InternalAuditTrial::where('InternalAudit_id', $internalAudit->id)
            ->where('activity_type', 'Due Date Extension Justification')
            ->exists();
            $history = new InternalAuditTrial;
            $history->InternalAudit_id = $lastDocument->id;
            $history->activity_type = 'Due Date Extension Justification';
            if($lastDocument->due_date_extension == null){
                $history->previous = "Not Applicable";
            } else{
                $history->previous = $lastDocument->due_date_extension;
            }
            $history->current = $request->due_date_extension;
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

$previousAttachments = $lastDocument->inv_attachment;
$areIniAttachmentsSame = $previousAttachments == $internalAudit->inv_attachment;

if ($areIniAttachmentsSame != true) {
    $lastDocumentAuditTrail = InternalAuditTrial::where('InternalAudit_id', $internalAudit->id)
        ->where('activity_type', 'Initial Attachment')
        ->exists();
            $history = new InternalAuditTrial;
            $history->InternalAudit_id = $id;
            $history->activity_type = 'Initial Attachment';
            $history->previous = $previousAttachments;
            $history->current = $internalAudit->inv_attachment;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            if ($lastDocumentAuditTrail) {
                $history->action_name = "Update";
            } else {
                $history->action_name = "New";
            }
            $history->save();
        }



$previousAttachments1 = $lastDocument->file_attachment;
$areIniAttachmentsSame1 = $previousAttachments1 == $internalAudit->file_attachment;

if ($areIniAttachmentsSame1 != true) {
    $lastDocumentAuditTrail = InternalAuditTrial::where('InternalAudit_id', $internalAudit->id)
        ->where('activity_type', 'File Attachment')
        ->exists();
            $history = new InternalAuditTrial;
            $history->InternalAudit_id = $id;
            $history->activity_type = 'File Attachment';
            $history->previous = $previousAttachments1;
            $history->current = $internalAudit->file_attachment;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            if ($lastDocumentAuditTrail) {
                $history->action_name = "Update";
            } else {
                $history->action_name = "New";
            }
            $history->save();
        }



$previousAttachments2 = $lastDocument->file_attachment_guideline;
$areIniAttachmentsSame2 = $previousAttachments2 == $internalAudit->file_attachment_guideline;

if ($areIniAttachmentsSame2 != true) {
    $lastDocumentAuditTrail = InternalAuditTrial::where('InternalAudit_id', $internalAudit->id)
        ->where('activity_type', 'Guideline Attachment')
        ->exists();
            $history = new InternalAuditTrial;
            $history->InternalAudit_id = $id;
            $history->activity_type = 'Guideline Attachment';
            $history->previous = $previousAttachments2;
            $history->current = $internalAudit->file_attachment_guideline;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            if ($lastDocumentAuditTrail) {
                $history->action_name = "Update";
            } else {
                $history->action_name = "New";
            }
            $history->save();
        }


        $previousAttachments3 = $lastDocument->Audit_file;
        $areIniAttachmentsSame3 = $previousAttachments3 == $internalAudit->Audit_file;

        if ($areIniAttachmentsSame2 != true) {
            // Check if a similar record already exists
            $lastDocumentAuditTrail = InternalAuditTrial::where('InternalAudit_id', $internalAudit->id)
                ->where('activity_type', 'Audit Preparation and Execution Attachment') // Match specific activity
                ->where('previous', $previousAttachments2) // Match the previous value
                ->where('current', $internalAudit->file_attachment_guideline) // Match the current value
                ->exists();
        
            // Prepare the new history entry
            $history = new InternalAuditTrial;
            $history->InternalAudit_id = $id;
            $history->activity_type = 'Audit Preparation and Execution Attachment';
            $history->previous = $previousAttachments2;
            $history->current = $internalAudit->file_attachment_guideline;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
        
            // Determine if it's a new entry or an update
            if ($lastDocumentAuditTrail) {
                $history->action_name = "Update"; // Entry exists, treat as an update
            } else {
                $history->action_name = "New"; // No similar entry, treat as new
            }
        
            // Save the history record
            $history->save();
        }
        
                $previousAttachments4 = $lastDocument->report_file;
                $areIniAttachmentsSame4 = $previousAttachments4 == $internalAudit->report_file;

                if ($areIniAttachmentsSame4 != true) {
                    $lastDocumentAuditTrail = InternalAuditTrial::where('InternalAudit_id', $internalAudit->id)
                        ->where('activity_type', 'Report Attachment')
                        ->exists();
                            $history = new InternalAuditTrial;
                            $history->InternalAudit_id = $id;
                            $history->activity_type = 'Report Attachment';
                            $history->previous = $previousAttachments4;
                            $history->current = $internalAudit->report_file;
                            $history->comment = "Not Applicable";
                            $history->user_id = Auth::user()->id;
                            $history->user_name = Auth::user()->name;
                            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                            $history->origin_state = $lastDocument->status;
                            $history->change_to =   "Not Applicable";
                            $history->change_from = $lastDocument->status;
                            if ($lastDocumentAuditTrail) {
                                $history->action_name = "Update";
                            } else {
                                $history->action_name = "New";
                            }
                            $history->save();
                        }


                $previousAttachments5 = $lastDocument->myfile;
                $areIniAttachmentsSame5 = $previousAttachments5 == $internalAudit->myfile;

                if ($areIniAttachmentsSame5 != true) {
                    $lastDocumentAuditTrail = InternalAuditTrial::where('InternalAudit_id', $internalAudit->id)
                        ->where('activity_type', 'Audit Attachment')
                        ->exists();
                            $history = new InternalAuditTrial;
                            $history->InternalAudit_id = $id;
                            $history->activity_type = 'Audit Attachment';
                            $history->previous = $previousAttachments5;
                            $history->current = $internalAudit->myfile;
                            $history->comment = "Not Applicable";
                            $history->user_id = Auth::user()->id;
                            $history->user_name = Auth::user()->name;
                            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                            $history->origin_state = $lastDocument->status;
                            $history->change_to =   "Not Applicable";
                            $history->change_from = $lastDocument->status;
                            if ($lastDocumentAuditTrail) {
                                $history->action_name = "Update";
                            } else {
                                $history->action_name = "New";
                            }
                            $history->save();
                        }


        toastr()->success('Record is Update Successfully');

        return back();
    }

    public function internalAuditShow($id)
    {
        $old_record = InternalAudit::select('id', 'division_id', 'record')->get();
        $data = InternalAudit::find($id);
        $checklist1 = IA_checklist_tablet_compression::where('ia_id', $id)->first();
        $checklist2 = IA_checklist_tablet_coating::where('ia_id', $id)->first();
        $checklist4 = Checklist_Capsule::where('ia_id', $id)->first();
        $checklist3 = IA_checklist_capsule_paking::where('ia_id', $id)->first();
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

        // dd($checklist1);
        $data->record = str_pad($data->record, 4, '0', STR_PAD_LEFT);
        $data->assign_to_name = User::where('id', $data->assign_id)->value('name');
        $data->initiator_name = User::where('id', $data->initiator_id)->value('name');
        $grid_data = InternalAuditGrid::where('audit_id', $id)->where('type', "internal_audit")->first();
     //   dd($grid_data);
        $grid_data1 = InternalAuditGrid::where('audit_id', $id)->where('type', "Observation_field")->first();
        // return dd($checklist1);

        $auditAssessmentChecklist = InternalAuditChecklistGrid::where(['ia_id' => $id, 'identifier' => 'auditAssessmentChecklist'])->first();
        $auditPersonnelChecklist = InternalAuditChecklistGrid::where(['ia_id' => $id, 'identifier' => 'auditPersonnelChecklist'])->firstOrNew();
        $auditfacilityChecklist = InternalAuditChecklistGrid::where(['ia_id' => $id, 'identifier' => 'auditfacilityChecklist'])->firstOrNew();
        $auditMachinesChecklist = InternalAuditChecklistGrid::where(['ia_id' => $id, 'identifier' => 'auditMachinesChecklist'])->firstOrNew();
        $auditProductionChecklist = InternalAuditChecklistGrid::where(['ia_id' => $id, 'identifier' => 'auditProductionChecklist'])->firstOrNew();
        $auditMaterialsChecklist = InternalAuditChecklistGrid::where(['ia_id' => $id, 'identifier' => 'auditMaterialsChecklist'])->firstOrNew();
        $auditQualityControlChecklist = InternalAuditChecklistGrid::where(['ia_id' => $id, 'identifier' => 'auditQualityControlChecklist'])->firstOrNew();
        $auditQualityAssuranceChecklist = InternalAuditChecklistGrid::where(['ia_id' => $id, 'identifier' => 'auditQualityAssuranceChecklist'])->firstOrNew();
        $auditPackagingChecklist = InternalAuditChecklistGrid::where(['ia_id' => $id, 'identifier' => 'auditPackagingChecklist'])->firstOrNew();
        $auditSheChecklist = InternalAuditChecklistGrid::where(['ia_id' => $id, 'identifier' => 'auditSheChecklist'])->firstOrNew();
        $gridcomment = InternalAuditChecklistGrid::where(['ia_id' => $id])->first();
            // dd($gridcomment);

        return view('frontend.internalAudit.view', compact('data','checklist1','checklist2','checklist3', 'checklist4','checklist5','checklist6','checklist7','checklist9','checklist10','checklist11','checklist12','checklist13','checklist14','checklist15','checklist16','checklist17','old_record','grid_data','grid_data1', 'auditAssessmentChecklist','auditPersonnelChecklist','auditfacilityChecklist','auditMachinesChecklist','auditProductionChecklist','auditMaterialsChecklist','auditQualityControlChecklist','auditQualityAssuranceChecklist','auditPackagingChecklist','auditSheChecklist','gridcomment'));
    }

    public function InternalAuditStateChange(Request $request, $id)
    {
        // dd(($request->username == Auth::user()->Username));

        if ($request->username == Auth::user()->Username && Hash::check($request->password, Auth::user()->password)) {
            $changeControl = InternalAudit::find($id);
            $lastDocument = InternalAudit::find($id);

            if ($changeControl->stage == 1) {
                $changeControl->stage = "2";
                $changeControl->status = "Audit Preparation";
                $changeControl->audit_schedule_by = Auth::user()->name;
                $changeControl->audit_schedule_on = Carbon::now()->format('d-M-Y');
                            $history = new InternalAuditTrial();
                            $history->InternalAudit_id = $id;
                            $history->activity_type = 'Activity Log';
                            $history->current = $changeControl->audit_schedule_by;
                            $history->comment = $request->comment;
                            $history->user_id = Auth::user()->id;
                            $history->user_name = Auth::user()->name;
                            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                            $history->origin_state = $lastDocument->status;
                            $history->stage = "Audit Schedule";
                            $history->save();
                //        $list = Helpers::getLeadAuditorUserList();
                //     foreach ($list as $u) {
                //         if($u->q_m_s_divisions_id == $changeControl->division_id){
                //             $email = Helpers::getInitiatorEmail($u->user_id);
                //              if ($email !== null) {

                //               Mail::send(
                //                   'mail.view-mail',
                //                    ['data' => $changeControl],
                //                 function ($message) use ($email) {
                //                     $message->to($email)
                //                         ->subject("Document sent ".Auth::user()->name);
                //                 }
                //               );
                //             }
                //      }
                //   }
                $changeControl->update();
                toastr()->success('Document Sent');
                return back();
            }
            // if ($changeControl->stage == 2) {
            //     $changeControl->stage = "1";
            //     $changeControl->status = "Audit Preparation";
            //     $changeControl->rejected_by = Auth::user()->name;
            //     $changeControl->rejected_on = Carbon::now()->format('d-M-Y');
            //     $changeControl->update();
            //     toastr()->success('Document Sent');
            //     return back();
            // }
            if ($changeControl->stage == 2) {
                $changeControl->stage = "3";
                $changeControl->status = "Pending Audit";
                $changeControl->audit_preparation_completed_by = Auth::user()->name;
                $changeControl->audit_preparation_completed_on = Carbon::now()->format('d-M-Y');
                $history = new InternalAuditTrial();
                            $history->InternalAudit_id = $id;
                            $history->activity_type = 'Activity Log';
                            $history->current = $changeControl->audit_preparation_completed_by;
                            $history->comment = $request->comment;
                            $history->user_id = Auth::user()->id;
                            $history->user_name = Auth::user()->name;
                            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                            $history->origin_state = $lastDocument->status;
                            $history->stage = "Audit Preparation Completed";
                            $history->save();
                //             $list = Helpers::getAuditManagerUserList();
                //     foreach ($list as $u) {
                //         if($u->q_m_s_divisions_id == $changeControl->division_id){
                //             $email = Helpers::getInitiatorEmail($u->user_id);
                //              if ($email !== null) {

                //               Mail::send(
                //                   'mail.view-mail',
                //                    ['data' => $changeControl],
                //                 function ($message) use ($email) {
                //                     $message->to($email)
                //                         ->subject("Document sent ".Auth::user()->name);
                //                 }
                //               );
                //             }
                //      }
                //   }
                $changeControl->update();
                toastr()->success('Document Sent');
                return back();
            }
            if ($changeControl->stage == 3) {
                $changeControl->stage = "4";
                $changeControl->status = "Pending Response";
                $changeControl->audit_mgr_more_info_reqd_by = Auth::user()->name;
                $changeControl->audit_mgr_more_info_reqd_on = Carbon::now()->format('d-M-Y');
                $history = new InternalAuditTrial();
                            $history->InternalAudit_id = $id;
                            $history->activity_type = 'Activity Log';
                            $history->current = $changeControl->audit_mgr_more_info_reqd_by;
                            $history->comment = $request->comment;
                            $history->user_id = Auth::user()->id;
                            $history->user_name = Auth::user()->name;
                            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                            $history->origin_state = $lastDocument->status;
                            $history->stage = "Audit Mgr More Info Reqd";
                            $history->save();
                        //     $list = Helpers::getLeadAuditeeUserList();
                        //     foreach ($list as $u) {
                        //         if($u->q_m_s_divisions_id == $changeControl->division_id){
                        //             $email = Helpers::getInitiatorEmail($u->user_id);

                        //              if ($email !== null) {

                        //               Mail::send(
                        //                   'mail.view-mail',
                        //                    ['data' => $changeControl],
                        //                 function ($message) use ($email) {
                        //                     $message->to($email)
                        //                         ->subject("Document sent ".Auth::user()->name);
                        //                 }
                        //               );
                        //             }
                        //      }
                        //   }

                $changeControl->update();
                toastr()->success('Document Sent');
                return back();
            }
            if ($changeControl->stage == 4) {
                $changeControl->stage = "5";
                $changeControl->status = "CAPA Execution in Progress";
                $changeControl->audit_observation_submitted_by = Auth::user()->name;
                $changeControl->audit_observation_submitted_on = Carbon::now()->format('d-M-Y');
                $history = new InternalAuditTrial();
                            $history->InternalAudit_id = $id;
                            $history->activity_type = 'Activity Log';
                            $history->current = $changeControl->audit_observation_submitted_by;
                            $history->comment = $request->comment;
                            $history->user_id = Auth::user()->id;
                            $history->user_name = Auth::user()->name;
                            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                            $history->origin_state = $lastDocument->status;
                            $history->stage = "Audit Observation Submitted";
                            $history->save();
                $changeControl->update();
                toastr()->success('Document Sent');
                return back();
            }

            if ($changeControl->stage == 5) {
                $changeControl->stage = "6";
                $changeControl->status = "Closed - Done";
                $changeControl->audit_lead_more_info_reqd_by = Auth::user()->name;
                $changeControl->audit_lead_more_info_reqd_on = Carbon::now()->format('d-M-Y');
                $changeControl->audit_response_completed_by = Auth::user()->name;
                $changeControl->audit_response_completed_on = Carbon::now()->format('d-M-Y');
                $changeControl->response_feedback_verified_by = Auth::user()->name;
                $changeControl->response_feedback_verified_on = Carbon::now()->format('d-M-Y');
                            $history = new InternalAuditTrial();
                            $history->InternalAudit_id = $id;
                            $history->activity_type = 'Activity Log';
                            $history->current = $changeControl->audit_lead_more_info_reqd_by;
                            $history->comment = $request->comment;
                            $history->user_id = Auth::user()->id;
                            $history->user_name = Auth::user()->name;
                            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                            $history->origin_state = $lastDocument->status;
                            $history->stage = "Audit Lead More Info Reqd";
                            $history->save();
                $changeControl->update();
                toastr()->success('Document Sent');
                return back();
            }



        } else {
            toastr()->error('E-signature Not match');
            return back();
        }
    }
    public function RejectStateChange(Request $request, $id)
    {

        if ($request->username == Auth::user()->Username && Hash::check($request->password, Auth::user()->password)) {
            $changeControl = InternalAudit::find($id);
            $lastDocument = InternalAudit::find($id);

            if ($changeControl->stage == 4) {
                $changeControl->stage = "6";
                $changeControl->status = "Closed - Done";
                $changeControl->update();
                $history = new InternalAuditStageHistory();
                $history->type = "Internal Audit";
                $history->doc_id = $id;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->stage_id = $changeControl->stage;
                $history->status = $changeControl->status;
                $history->save();
                toastr()->success('Document Sent');
                return back();
            }
            if ($changeControl->stage == 2) {
                $changeControl->stage = "1";
                $changeControl->status = "Opened";
                $changeControl->rejected_by = Auth::user()->name;
                $changeControl->rejected_on = Carbon::now()->format('d-M-Y');
                            $history = new InternalAuditTrial();
                            $history->InternalAudit_id = $id;
                            $history->activity_type = 'Activity Log';
                            $history->current = $changeControl->rejected_by;
                            $history->comment = $request->comment;
                            $history->user_id = Auth::user()->id;
                            $history->user_name = Auth::user()->name;
                            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                            $history->origin_state = $lastDocument->status;
                            $history->stage = "Rejected";
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
                        //                         ->subject("Document is Rejected ".Auth::user()->name);
                        //                 }
                        //               );
                        //             }
                        //      }
                        //   }

                $changeControl->update();
                $history = new InternalAuditStageHistory();
                $history->type = "Internal Audit";
                $history->doc_id = $id;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->stage_id = $changeControl->stage;
                $history->status = $changeControl->status;
                $history->save();
                toastr()->success('Document Sent');
                return back();
            }
            if ($changeControl->stage == 3) {
                $changeControl->stage = "1";
                $changeControl->status = "Opened";
                $changeControl->update();
                $history = new InternalAuditStageHistory();
                $history->type = "Internal Audit";
                $history->doc_id = $id;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->stage_id = $changeControl->stage;
                $history->status = $changeControl->status;
                $history->save();
                toastr()->success('Document Sent');
                return back();
            }
        } else {
            toastr()->error('E-signature Not match');
            return back();
        }
    }
    public function InternalAuditCancel(Request $request, $id)
    {
        if ($request->username == Auth::user()->Username && Hash::check($request->password, Auth::user()->password)) {
            $changeControl = InternalAudit::find($id);
            $lastDocument = InternalAudit::find($id);

            if ($changeControl->stage == 1) {
                $changeControl->stage = "0";
                $changeControl->status = "Closed-Cancelled";
                $changeControl->cancelled_by = Auth::user()->name;
                $changeControl->cancelled_on = Carbon::now()->format('d-M-Y');
                                $history = new InternalAuditTrial();
                                $history->InternalAudit_id = $id;
                                $history->activity_type = 'Activity Log';
                                $history->current = $changeControl->cancelled_by;
                                $history->comment = $request->comment;
                                $history->user_id = Auth::user()->id;
                                $history->user_name = Auth::user()->name;
                                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                                $history->origin_state = $lastDocument->status;
                                $history->stage = "Cancelled";
                                $history->save();
                //                   $list = Helpers::getHodUserList();
                //     foreach ($list as $u) {
                //         if($u->q_m_s_divisions_id == $changeControl->division_id){
                //             $email = Helpers::getLeadAuditorUserList($u->user_id);
                //              if ($email !== null) {

                //               Mail::send(
                //                   'mail.view-mail',
                //                    ['data' => $changeControl],
                //                 function ($message) use ($email) {
                //                     $message->to($email)
                //                         ->subject("Document is cancel By ".Auth::user()->name);
                //                 }
                //               );
                //             }
                //      }
                //   }
                $changeControl->update();
                $history = new InternalAuditStageHistory();
                $history->type = "Internal Audit";
                $history->doc_id = $id;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->stage_id = $changeControl->stage;
                $history->status = $changeControl->status;
                $history->save();
                toastr()->success('Document Sent');
                return back();
            }
            if ($changeControl->stage == 2) {
                $changeControl->stage = "0";
                $changeControl->status = "Closed-Cancelled";
                $changeControl->cancelled_by = Auth::user()->name;
                $changeControl->cancelled_on = Carbon::now()->format('d-M-Y');
                            $history = new InternalAuditTrial();
                            $history->InternalAudit_id = $id;
                            $history->activity_type = 'Activity Log';
                            $history->current = $changeControl->cancelled_by;
                            $history->comment = $request->comment;
                            $history->user_id = Auth::user()->id;
                            $history->user_name = Auth::user()->name;
                            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                            $history->origin_state = $lastDocument->status;
                            $history->stage = "Cancelled";
                            $history->save();
                $changeControl->update();
                $history = new InternalAuditStageHistory();
                $history->type = "Internal Audit";
                $history->doc_id = $id;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->stage_id = $changeControl->stage;
                $history->status = $changeControl->status;
                $history->save();
                toastr()->success('Document Sent');
                return back();
            }
            if ($changeControl->stage == 3) {
                $changeControl->stage = "0";
                $changeControl->status = "Closed-Cancelled";
                $changeControl->cancelled_by = Auth::user()->name;
                $changeControl->cancelled_on = Carbon::now()->format('d-M-Y');
                            $history = new InternalAuditTrial();
                            $history->InternalAudit_id = $id;
                            $history->activity_type = 'Activity Log';
                            $history->current = $changeControl->cancelled_by;
                            $history->comment = $request->comment;
                            $history->user_id = Auth::user()->id;
                            $history->user_name = Auth::user()->name;
                            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                            $history->origin_state = $lastDocument->status;
                            $history->stage = "Cancelled";
                            $history->save();
                $changeControl->update();
                $history = new InternalAuditStageHistory();
                $history->type = "Internal Audit";
                $history->doc_id = $id;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->stage_id = $changeControl->stage;
                $history->status = $changeControl->status;
                $history->save();
                toastr()->success('Document Sent');
                return back();
            }
        } else {
            toastr()->error('E-signature Not match');
            return back();
        }
    }


    public function InternalAuditTrialShow($id)
    {
        $audit = InternalAuditTrial::where('InternalAudit_id', $id)->orderByDESC('id')->paginate();
        $today = Carbon::now()->format('d-m-y');
        $document = InternalAudit::where('id', $id)->first();
        $document->initiator = User::where('id', $document->initiator_id)->value('name');
        return view('frontend.internalAudit.audit-trial', compact('audit', 'document', 'today'));
    }

    public function InternalAuditTrialDetails($id)
    {
        $detail = InternalAuditTrial::find($id);

        $detail_data = InternalAuditTrial::where('activity_type', $detail->activity_type)->where('InternalAudit_id', $detail->InternalAudit_id)->latest()->get();

        $doc = InternalAudit::where('id', $detail->InternalAudit_id)->first();

        $doc->origiator_name = User::find($doc->initiator_id);
        return view('frontend.internalAudit.audit-trial-inner', compact('detail', 'doc', 'detail_data'));
    }

        public function internal_audit_child(Request $request, $id)
        {
            $parent_id = $id;
            $parent_type = "Observations";
            $record_number = ((RecordNumber::first()->value('counter')) + 1);
            $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
            $currentDate = Carbon::now();
            $formattedDate = $currentDate->addDays(30);
            $due_date = $formattedDate->format('d-M-Y');
            return view('frontend.forms.observation', compact('record_number', 'due_date', 'parent_id', 'parent_type'));
        }


    // public static function singleReport($id)
    // {
    //     $data = InternalAudit::find($id);
    //     if (!empty($data)) {
    //         $data->originator = User::where('id', $data->initiator_id)->value('name');
    //         $pdf = App::make('dompdf.wrapper');
    //         $time = Carbon::now();
    //         $pdf = PDF::loadview('frontend.internalAudit.singleReport', compact('data'))
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

    //         $directoryPath = public_path("user/pdf/reg/");
    //         $filePath = $directoryPath . '/reg' . $id . '.pdf';

    //         if (!File::isDirectory($directoryPath)) {
    //             File::makeDirectory($directoryPath, 0755, true, true); // Recursive creation with read/write permissions
    //         }  

    //         $pdf->save($filePath);
    //         return $pdf->stream('Internal-Audit' . $id . '.pdf');
    //     }
    // }
    public static function singleReport($id)
    {
        $data = InternalAudit::find($id);
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
            $pdf = PDF::loadview('frontend.internalAudit.singleReport', compact('data','checklist1','checklist2','checklist3','checklist4','checklist5','checklist6','checklist7','checklist9','checklist10','checklist11','checklist12','checklist13','checklist14','checklist15','checklist16','checklist17','grid_data','grid_Data3','grid_Data5','auditorview'))
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
            return $pdf->stream('Internal-Audit' . $id . '.pdf');
        }
    }

    public function singleReportShow($id)
    {
        $data = InternalAudit::find($id);
        return view('frontend.internalAudit.IAshow_pdf', compact('id', 'data'));
    }
    public static function auditReport($id)
    {
        $doc = InternalAudit::find($id);
        if (!empty($doc)) {
            $doc->originator = User::where('id', $doc->initiator_id)->value('name');
            $data = InternalAuditTrial::where('InternalAudit_id', $id)->get();
            $pdf = App::make('dompdf.wrapper');
            $time = Carbon::now();
            $pdf = PDF::loadview('frontend.internalAudit.auditReport', compact('data', 'doc'))
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
            return $pdf->stream('Internal-Audit' . $id . '.pdf');
        }
    }


    
     // CSV Export Function for Action Item Log
     public function exportCsv(Request $request)
     {
      $query = InternalAudit::query();

      if ($request->departmentaction) {
          $query->where('departments', $request->departmentaction);
      }

      if ($request->division_action) {
          $query->where('division_id', $request->division_action);
      }

      if ($request->date_fromAction) {
          $dateFrom = Carbon::parse($request->date_fromAction)->startOfDay();
          $query->whereDate('created_at', '>=', $dateFrom);
      }

      if ($request->date_toAction) {
          $dateTo = Carbon::parse($request->date_toAction)->endOfDay();
          $query->whereDate('created_at', '<=', $dateTo);
      }

      // Apply Sorting if Specified
      if ($request->sort_column && $request->sort_order) {
          $query->orderBy($request->sort_column, $request->sort_order);
      }

      $actionitem = $query->get();
      
         $fileName = 'InternalAudit_Log.csv';
         $headers = [
             "Content-Type" => "text/csv",
             "Content-Disposition" => "attachment; filename=\"$fileName\"",
         ];
 
         $columns = [
             'Sr. No.', 'Action Item No.', 'Department', 'Division', 'Details',
             'Date Created', 'Due Date', 'Assigned To', 'Status'
         ];
 
         $callback = function () use ($actionitem, $columns) {
             $file = fopen('php://output', 'w');
             fputcsv($file, $columns);
 
             if ($actionitem->isEmpty()) {
                 fputcsv($file, ['No records found']);
             } else {
                 foreach ($actionitem as $index => $row) {
                     $data = [
                         $index + 1, // Sr. No.
                         $row->action_no ?? 'Not Applicable',
                         $row->departments ?? 'Not Applicable',
                         $row->division_id ?? 'Not Applicable',
                         $row->details ?? 'Not Applicable',
                         $row->created_at ? Carbon::parse($row->created_at)->format('d-M-Y') : 'Not Applicable',
                         $row->due_date ? Carbon::parse($row->due_date)->format('d-M-Y') : 'Not Applicable',
                         $row->assigned_to ?? 'Not Applicable',
                         $row->status ?? 'Not Applicable'
                     ];
                     fputcsv($file, $data);
                 }
             }
 
             fclose($file);
         };
 
         return response()->stream($callback, 200, $headers);
     }
 
     // Excel Export Function for Action Item Log
     public function exportExcel(Request $request)
     {
      $query = InternalAudit::query();

      if ($request->departmentaction) {
          $query->where('departments', $request->departmentaction);
      }

      if ($request->division_action) {
          $query->where('division_id', $request->division_action);
      }

      if ($request->date_fromAction) {
          $dateFrom = Carbon::parse($request->date_fromAction)->startOfDay();
          $query->whereDate('created_at', '>=', $dateFrom);
      }

      if ($request->date_toAction) {
          $dateTo = Carbon::parse($request->date_toAction)->endOfDay();
          $query->whereDate('created_at', '<=', $dateTo);
      }

      // Apply Sorting if Specified
      if ($request->sort_column && $request->sort_order) {
          $query->orderBy($request->sort_column, $request->sort_order);
      }

      $actionitem = $query->get();
      
         $fileName = "InternalAudit_Log.xls";
         $headers = [
             "Content-Type" => "application/vnd.ms-excel",
             "Content-Disposition" => "attachment; filename=\"$fileName\"",
         ];
 
         $columns = [
             'Sr. No.', 'Action Item No.', 'Department', 'Division', 'Details',
             'Date Created', 'Due Date', 'Assigned To', 'Status'
         ];
 
         $callback = function () use ($actionitem, $columns) {
             echo '<table border="1">';
             echo '<tr style="font-weight: bold; background-color: #1F4E79; color: #FFFFFF;">';
             foreach ($columns as $column) {
                 echo "<th style='padding: 5px;'>" . htmlspecialchars($column) . "</th>";
             }
             echo '</tr>';
 
             if ($actionitem->isEmpty()) {
                 echo '<tr>';
                 echo "<td colspan='" . count($columns) . "' style='text-align: center;'>No records found</td>";
                 echo '</tr>';
             } else {
                 foreach ($actionitem as $index => $row) {
                     echo '<tr>';
                     echo "<td style='padding: 5px;'>" . ($index + 1) . "</td>";
                     echo "<td style='padding: 5px;'>" . htmlspecialchars($row->action_no ?? 'Not Applicable') . "</td>";
                     echo "<td style='padding: 5px;'>" . htmlspecialchars($row->departments ?? 'Not Applicable') . "</td>";
                     echo "<td style='padding: 5px;'>" . htmlspecialchars($row->division_id ?? 'Not Applicable') . "</td>";
                     echo "<td style='padding: 5px;'>" . htmlspecialchars($row->details ?? 'Not Applicable') . "</td>";
                     echo "<td style='padding: 5px;'>" . ($row->created_at ? Carbon::parse($row->created_at)->format('d-M-Y') : 'Not Applicable') . "</td>";
                     echo "<td style='padding: 5px;'>" . ($row->due_date ? Carbon::parse($row->due_date)->format('d-M-Y') : 'Not Applicable') . "</td>";
                     echo "<td style='padding: 5px;'>" . htmlspecialchars($row->assigned_to ?? 'Not Applicable') . "</td>";
                     echo "<td style='padding: 5px;'>" . htmlspecialchars($row->status ?? 'Not Applicable') . "</td>";
                     echo '</tr>';
                 }
             }
 
             echo '</table>';
         };
 
         return response()->stream($callback, 200, $headers);
     }
}
