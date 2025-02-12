<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\ActionItem;
use App\Models\PreventiveMaintenance;
use App\Models\CallibrationDetails;
use App\Models\AttachmentGrid;
use App\Models\Capa;
use App\Models\CapaGrid;
use App\Models\CC;
use App\Models\CcCft;
use App\Models\Docdetail;
use App\Models\ChangeClosure;
use App\Models\QaApprovalComments;
use App\Models\RiskAssessment;
use App\Models\GroupComments;
use App\Models\AdditionalInformation;
use App\Models\Evaluation;
use App\Models\Qareview;
use App\Models\Deviation;
use App\Models\Division;
use App\Models\Document;
use App\Models\EHSEventHistory;
use App\Models\Equipmentgrid;
use App\Models\EquipmentInfoAuditTrail;
use App\Models\EquipmentInformation;
use App\Models\EquipmentLifecycleManagement;
use App\Models\EquipmentLifecycleManagementTrainingData;
use App\Models\Question;
use App\Models\extension_new;
use App\Models\InternalAuditGrid;

use App\Models\OpenStage;
use App\Models\QMSDivision;
use App\Models\RecordNumber;
use App\Models\RiskLevelKeywords;
use App\Models\RiskManagement;
use App\Models\RoleGroup;
use App\Models\EmpTrainingQuizResult;
use App\Models\TrainingDetailsGrid;
use App\Models\User;
use Carbon\Carbon;
use Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use PDF;
use Illuminate\Support\Facades\Crypt;

class EquipmentLifecycleManagementController extends Controller
{
    public function index()
    {
        $record_number = ((RecordNumber::first()->value('counter')) + 1);
        $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
        $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $due_date = $formattedDate->format('Y-m-d');
        $documents = Document::all();
       return view('frontend.Equipment-Lifecycle-Management.Equipment_Information_Create', compact('record_number','documents') );
        
    }

    public function EquipmentInfo_store(Request $request)
{
    
    if (!$request->short_description) {
        toastr()->error("Short description is required");
        return redirect()->back()->withInput();
    }
    $equipment = new EquipmentLifecycleManagement();
    $equipgrid = new AttachmentGrid();
    $equipment->form_type = "ELM";
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
    $equipment->equipment_id = $request->equipment_id;
    $equipment->equipment_name_description = $request->equipment_name_description;
    $equipment->manufacturer = $request->manufacturer;
    $equipment->model_number = $request->model_number;
    $equipment->serial_number = $request->serial_number;
    $equipment->location = $request->location;
    $equipment->purchase_date = $request->purchase_date;
    $equipment->installation_date = $request->installation_date;
    $equipment->warranty_expiration_date = $request->warranty_expiration_date;
    $equipment->criticality_level = $request->criticality_level;
    $equipment->asset_type = $request->asset_type;

    $equipment->urs_description = $request->urs_description;
    $equipment->system_level_risk_assessment_details = $request->system_level_risk_assessment_details;
    $equipment->failure_mode_effect_analysis = $request->failure_mode_effect_analysis;
    // $equipment->supporting_documents = $request->supporting_documents;
    $equipment->frs_description = $request->frs_description;
    // $equipment->frs_attachment = $request->frs_attachment;
    $equipment->functional_risk_assessment_details = $request->functional_risk_assessment_details;



    //Failure Mode and Effect Analysis+

    if (!empty($request->risk_factor)) {
        $equipment->risk_factor = serialize($request->risk_factor);
    }
    if (!empty($request->risk_element)) {
        $equipment->risk_element = serialize($request->risk_element);
    }
    if (!empty($request->problem_cause)) {
        $equipment->problem_cause = serialize($request->problem_cause);
    }
    if (!empty($request->existing_risk_control)) {
        $equipment->existing_risk_control = serialize($request->existing_risk_control);
    }
    if (!empty($request->initial_severity)) {
        $equipment->initial_severity = serialize($request->initial_severity);
    }
    if (!empty($request->initial_detectability)) {
        $equipment->initial_detectability = serialize($request->initial_detectability);
    }
    if (!empty($request->initial_probability)) {
        $equipment->initial_probability = serialize($request->initial_probability);
    }
    if (!empty($request->initial_rpn)) {
        $equipment->initial_rpn = serialize($request->initial_rpn);
    }
    if (!empty($request->risk_acceptance)) {
        $equipment->risk_acceptance = serialize($request->risk_acceptance);
    }
    if (!empty($request->risk_control_measure)) {
        $equipment->risk_control_measure = serialize($request->risk_control_measure);
    }
    if (!empty($request->residual_severity)) {
        $equipment->residual_severity = serialize($request->residual_severity);
    }
    if (!empty($request->residual_probability)) {
        $equipment->residual_probability = serialize($request->residual_probability);
    }
    if (!empty($request->residual_detectability)) {
        $equipment->residual_detectability = serialize($request->residual_detectability);
    }
    if (!empty($request->residual_rpn)) {
        $equipment->residual_rpn = serialize($request->residual_rpn);
    }
    if (!empty($request->risk_acceptance2)) {
        $equipment->risk_acceptance2 = serialize($request->risk_acceptance2);
    }
    if (!empty($request->mitigation_proposal)) {
        $equipment->mitigation_proposal = serialize($request->mitigation_proposal);
    }


    //-------------Equipment Qualification Grid start------------//

    if (!empty($request->doc_name_IQ)) {
        $equipgrid->doc_name_IQ = serialize($request->doc_name_IQ);
    }
    if (!empty($request->doc_id_IQ)) {
        $equipgrid->doc_id_IQ = serialize($request->doc_id_IQ);
    }
    if (!empty($request->doc_remark_IQ)) {
        $equipgrid->doc_remark_IQ = serialize($request->doc_remark_IQ);
    }

    if (!empty($request->doc_name_DQ)) {
        $equipgrid->doc_name_DQ = serialize($request->doc_name_DQ);
    }
    if (!empty($request->doc_id_DQ)) {
        $equipgrid->doc_id_DQ = serialize($request->doc_id_DQ);
    }
    if (!empty($request->doc_remark_DQ)) {
        $equipgrid->doc_remark_DQ = serialize($request->doc_remark_DQ);
    }

    if (!empty($request->doc_name_OQ)) {
        $equipgrid->doc_name_OQ = serialize($request->doc_name_OQ);
    }
    if (!empty($request->doc_id_OQ)) {
        $equipgrid->doc_id_OQ = serialize($request->doc_id_OQ);
    }
    if (!empty($request->doc_remark_OQ)) {
        $equipgrid->doc_remark_OQ = serialize($request->doc_remark_OQ);
    }

    if (!empty($request->doc_name_PQ)) {
        $equipgrid->doc_name_PQ = serialize($request->doc_name_PQ);
    }
    if (!empty($request->doc_id_PQ)) {
        $equipgrid->doc_id_PQ = serialize($request->doc_id_PQ);
    }
    if (!empty($request->doc_remark_PQ)) {
        $equipgrid->doc_remark_PQ = serialize($request->doc_remark_PQ);
    }

    $equipgrid->save();
//-----------------Equipment Qualification Grid start------------------//


    // // Spare Part Information

    // if (!empty($request->SpareEquipment_Name)) {
    //     $equipment->SpareEquipment_Name = serialize($request->SpareEquipment_Name);
    // }
    // if (!empty($request->SpareEquipment_ID)) {
    //     $equipment->SpareEquipment_ID = serialize($request->SpareEquipment_ID);
    // }
    // if (!empty($request->SparePart_ID)) {
    //     $equipment->SparePart_ID = serialize($request->SparePart_ID);
    // }
    // if (!empty($request->SparePart_Name)) {
    //     $equipment->SparePart_Name = serialize($request->SparePart_Name);
    // }
    // if (!empty($request->SpareManufacturer)) {
    //     $equipment->SpareManufacturer = serialize($request->SpareManufacturer);
    // }
    // if (!empty($request->SpareModel_Number)) {
    //     $equipment->SpareModel_Number = serialize($request->SpareModel_Number);
    // }
    // if (!empty($request->SpareSerial_Number)) {
    //     $equipment->SpareSerial_Number = serialize($request->SpareSerial_Number);
    // }
    // if (!empty($request->SpareOEM)) {
    //     $equipment->SpareOEM = serialize($request->SpareOEM);
    // }
    // if (!empty($request->SparePart_Category)) {
    //     $equipment->SparePart_Category = serialize($request->SparePart_Category);
    // }
    // if (!empty($request->SparePart_Group)) {
    //     $equipment->SparePart_Group = serialize($request->SparePart_Group);
    // }
    // if (!empty($request->SparePart_Dimensions)) {
    //     $equipment->SparePart_Dimensions = serialize($request->SparePart_Dimensions);
    // }
    // if (!empty($request->SpareMaterial)) {
    //     $equipment->SpareMaterial = serialize($request->SpareMaterial);
    // }
    // if (!empty($request->SpareWeight)) {
    //     $equipment->SpareWeight = serialize($request->SpareWeight);
    // }
    // if (!empty($request->SpareColor)) {
    //     $equipment->SpareColor = serialize($request->SpareColor);
    // }
    // if (!empty($request->SparePart_Lifecycle_Stage)) {
    //     $equipment->SparePart_Lifecycle_Stage = serialize($request->SparePart_Lifecycle_Stage);
    // }
    // if (!empty($request->SparePart_Status)) {
    //     $equipment->SparePart_Status = serialize($request->SparePart_Status);
    // }
    // if (!empty($request->SpareAvailability)) {
    //     $equipment->SpareAvailability = serialize($request->SpareAvailability);
    // }
    // if (!empty($request->SpareQuantity_on_Hand)) {
    //     $equipment->SpareQuantity_on_Hand = serialize($request->SpareQuantity_on_Hand);
    // }
    // if (!empty($request->SpareQuantity_on_Order)) {
    //     $equipment->SpareQuantity_on_Order = serialize($request->SpareQuantity_on_Order);
    // }
    // if (!empty($request->SpareReorder_Point)) {
    //     $equipment->SpareReorder_Point = serialize($request->SpareReorder_Point);
    // }
    // if (!empty($request->SpareSafety_Stock)) {
    //     $equipment->SpareSafety_Stock = serialize($request->SpareSafety_Stock);
    // }
    // if (!empty($request->SpareMinimum_Order_Quantity)) {
    //     $equipment->SpareMinimum_Order_Quantity = serialize($request->SpareMinimum_Order_Quantity);
    // }
    // if (!empty($request->SpareLead_Time)) {
    //     $equipment->SpareLead_Time = serialize($request->SpareLead_Time);
    // }
    // if (!empty($request->SpareStock_Location)) {
    //     $equipment->SpareStock_Location = serialize($request->SpareStock_Location);
    // }
    // if (!empty($request->SpareBin_Number)) {
    //     $equipment->SpareBin_Number = serialize($request->SpareBin_Number);
    // }
    // if (!empty($request->SpareStock_Keeping_Unit)) {
    //     $equipment->SpareStock_Keeping_Unit = serialize($request->SpareStock_Keeping_Unit);
    // }
    // if (!empty($request->SpareLot_Number)) {
    //     $equipment->SpareLot_Number = serialize($request->SpareLot_Number);
    // }
    // if (!empty($request->SpareExpiry_Date)) {
    //     $equipment->SpareExpiry_Date = serialize($request->SpareExpiry_Date);
    // }
    // if (!empty($request->SpareSupplier_Name)) {
    //     $equipment->SpareSupplier_Name = serialize($request->SpareSupplier_Name);
    // }
    // if (!empty($request->SpareSupplier_Contact_Information)) {
    //     $equipment->SpareSupplier_Contact_Information = serialize($request->SpareSupplier_Contact_Information);
    // }
    // if (!empty($request->SpareSupplier_Lead_Time)) {
    //     $equipment->SpareSupplier_Lead_Time = serialize($request->SpareSupplier_Lead_Time);
    // }
    // if (!empty($request->SpareSupplier_Price)) {
    //     $equipment->SpareSupplier_Price = serialize($request->SpareSupplier_Price);
    // }
    // if (!empty($request->SpareSupplier_Part_Number)) {
    //     $equipment->SpareSupplier_Part_Number = serialize($request->SpareSupplier_Part_Number);
    // }
    // if (!empty($request->SpareSupplier_Warranty_Information)) {
    //     $equipment->SpareSupplier_Warranty_Information = serialize($request->SpareSupplier_Warranty_Information);
    // }
    // if (!empty($request->SpareSupplier_Performance_Metrics)) {
    //     $equipment->SpareSupplier_Performance_Metrics = serialize($request->SpareSupplier_Performance_Metrics);
    // }


    // Installation Qualification (IQ)
    $equipment->iq_test_plan = $request->iq_test_plan;
    $equipment->iq_protocol = $request->iq_protocol;
    $equipment->iq_execution = $request->iq_execution;
    $equipment->iq_report = $request->iq_report;
    // $equipment->iq_attachment = $request->iq_attachment;

    // Design Qualification (DQ)
    $equipment->dq_test_plan = $request->dq_test_plan;
    $equipment->dq_protocol = $request->dq_protocol;
    $equipment->dq_execution = $request->dq_execution;
    $equipment->dq_report = $request->dq_report;
    // $equipment->dq_attachment = $request->dq_attachment;

    // Operational Qualification (OQ)
    $equipment->oq_test_plan = $request->oq_test_plan;
    $equipment->oq_protocol = $request->oq_protocol;
    $equipment->oq_execution = $request->oq_execution;
    $equipment->oq_report = $request->oq_report;
    // $equipment->oq_attachment = $request->oq_attachment;

    // Performance Qualification (PQ)
    $equipment->pq_test_plan = $request->pq_test_plan;
    $equipment->pq_protocol = $request->pq_protocol;
    $equipment->pq_execution = $request->pq_execution;
    $equipment->pq_report = $request->pq_report;
    // $equipment->pq_attachment = $request->pq_attachment;

    $equipment->migration_details = $request->migration_details;
    // $equipment->migration_attachment = $request->migration_attachment;
    $equipment->configuration_specification_details = $request->configuration_specification_details;
    // $equipment->configuration_specification_attachment = $request->configuration_specification_attachment;
    $equipment->requirement_traceability_details = $request->requirement_traceability_details;
    // $equipment->requirement_traceability_attachment = $request->requirement_traceability_attachment;
    $equipment->validation_summary_report = $request->validation_summary_report;
    $equipment->periodic_qualification_pending_on = $request->periodic_qualification_pending_on;
    $equipment->periodic_qualification_notification = $request->periodic_qualification_notification;

    $equipment->calibration_standard_preference = $request->calibration_standard_preference;
    $equipment->callibration_frequency = $request->callibration_frequency;
    $equipment->last_calibration_date = $request->last_calibration_date;
    $equipment->next_calibration_date = $request->next_calibration_date;
    $equipment->calibration_due_reminder = $request->calibration_due_reminder;
    $equipment->calibration_method_procedure = $request->calibration_method_procedure;
    // $equipment->calibration_procedure_attach = $request->calibration_procedure_attach;
    $equipment->calibration_used = $request->calibration_used;
    $equipment->calibration_parameter = $request->calibration_parameter;
    $equipment->event_based_calibration = $request->event_based_calibration;
    $equipment->event_based_calibration_reason = $request->event_based_calibration_reason;
    $equipment->event_refernce_no = $request->event_refernce_no;
    $equipment->calibration_checklist = $request->calibration_checklist;
    $equipment->calibration_result = $request->calibration_result;
    $equipment->calibration_certificate_result = $request->calibration_certificate_result;
    // $equipment->calibration_certificate = $request->calibration_certificate;
    $equipment->calibrated_by = $request->calibrated_by;
    $equipment->calibration_due_alert = $request->calibration_due_alert;
    $equipment->calibration_cost = $request->calibration_cost;
    $equipment->calibration_comments = $request->calibration_comments;

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

    $equipment->training_required = $request->training_required;
    $equipment->trining_description = $request->trining_description;
    $equipment->training_type = $request->training_type;
    // $equipment->training_attachment = $request->training_attachment;

    $equipment->supervisor_comment = $request->supervisor_comment;
    // $equipment->Supervisor_document = $request->Supervisor_document;

    $equipment->QA_comment = $request->QA_comment;
    // $equipment->QA_document = $request->QA_document;

    $equipment->Equipment_Lifecycle_Stage = $request->Equipment_Lifecycle_Stage;
    $equipment->Expected_Useful_Life = $request->Expected_Useful_Life;
    $equipment->End_of_life_Date = $request->End_of_life_Date;
    $equipment->Decommissioning_and_Disposal_Records = $request->Decommissioning_and_Disposal_Records;
    $equipment->Replacement_History = $request->Replacement_History;

    $equipment->status = 'Opened';
    $equipment->stage = 1;

    if (!empty($request->supporting_documents)) {
        $files = [];
        if ($request->hasfile('supporting_documents')) {
            foreach ($request->file('supporting_documents') as $file) {
                $name = $request->name . '-supporting_documents' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                $file->move('upload/', $name);
                $files[] = $name;
            }
        }
        $equipment->supporting_documents = json_encode($files);
    }

    if (!empty($request->calibration_procedure_attach)) {
        $files = [];
        if ($request->hasfile('calibration_procedure_attach')) {
            foreach ($request->file('calibration_procedure_attach') as $file) {
                $name = $request->name . '-calibration_procedure_attach' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                $file->move('upload/', $name);
                $files[] = $name;
            }
        }
        $equipment->calibration_procedure_attach = json_encode($files);
    }

    if (!empty($request->frs_attachment)) {
        $files = [];
        if ($request->hasfile('frs_attachment')) {
            foreach ($request->file('frs_attachment') as $file) {
                $name = $request->name . '-frs_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                $file->move('upload/', $name);
                $files[] = $name;
            }
        }
        $equipment->frs_attachment = json_encode($files);
    }

    // if (!empty($request->iq_attachment)) {
    //     $files = [];
    //     if ($request->hasfile('iq_attachment')) {
    //         foreach ($request->file('iq_attachment') as $file) {
    //             $name = $request->name . '-iq_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
    //             $file->move('upload/', $name);
    //             $files[] = $name;
    //         }
    //     }
    //     $equipment->iq_attachment = json_encode($files);
    // }

    if (!empty($request->dq_attachment)) {
        $files = [];
        if ($request->hasfile('dq_attachment')) {
            foreach ($request->file('dq_attachment') as $file) {
                $name = $request->name . '-dq_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                $file->move('upload/', $name);
                $files[] = $name;
            }
        }
        $equipment->dq_attachment = json_encode($files);
    }

    if (!empty($request->oq_attachment)) {
        $files = [];
        if ($request->hasfile('oq_attachment')) {
            foreach ($request->file('oq_attachment') as $file) {
                $name = $request->name . '-oq_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                $file->move('upload/', $name);
                $files[] = $name;
            }
        }
        $equipment->oq_attachment = json_encode($files);
    }

    if (!empty($request->pq_attachment)) {
        $files = [];
        if ($request->hasfile('pq_attachment')) {
            foreach ($request->file('pq_attachment') as $file) {
                $name = $request->name . '-pq_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                $file->move('upload/', $name);
                $files[] = $name;
            }
        }
        $equipment->pq_attachment = json_encode($files);
    }
    if (!empty($request->migration_attachment)) {
        $files = [];
        if ($request->hasfile('migration_attachment')) {
            foreach ($request->file('migration_attachment') as $file) {
                $name = $request->name . '-migration_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                $file->move('upload/', $name);
                $files[] = $name;
            }
        }
        $equipment->migration_attachment = json_encode($files);
    }
    if (!empty($request->configuration_specification_attachment)) {
        $files = [];
        if ($request->hasfile('configuration_specification_attachment')) {
            foreach ($request->file('configuration_specification_attachment') as $file) {
                $name = $request->name . '-configuration_specification_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                $file->move('upload/', $name);
                $files[] = $name;
            }
        }
        $equipment->configuration_specification_attachment = json_encode($files);
    }
    if (!empty($request->requirement_traceability_attachment)) {
        $files = [];
        if ($request->hasfile('requirement_traceability_attachment')) {
            foreach ($request->file('requirement_traceability_attachment') as $file) {
                $name = $request->name . '-requirement_traceability_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                $file->move('upload/', $name);
                $files[] = $name;
            }
        }
        $equipment->requirement_traceability_attachment = json_encode($files);
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
        $equipment->calibration_certificate = json_encode($files);
    }
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
    if (!empty($request->training_attachment)) {
        $files = [];
        if ($request->hasfile('training_attachment')) {
            foreach ($request->file('training_attachment') as $file) {
                $name = $request->name . '-training_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                $file->move('upload/', $name);
                $files[] = $name;
            }
        }
        $equipment->training_attachment = json_encode($files);
    }
    if (!empty($request->Supervisor_document)) {
        $files = [];
        if ($request->hasfile('Supervisor_document')) {
            foreach ($request->file('Supervisor_document') as $file) {
                $name = $request->name . '-Supervisor_document' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                $file->move('upload/', $name);
                $files[] = $name;
            }
        }
        $equipment->Supervisor_document = json_encode($files);
    }

    if (!empty($request->QA_document)) {
        $files = [];
        if ($request->hasfile('QA_document')) {
            foreach ($request->file('QA_document') as $file) {
                $name = $request->name . '-QA_document' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                $file->move('upload/', $name);
                $files[] = $name;
            }
        }
        $equipment->QA_document = json_encode($files);
    }

    $equipment->save();

    $griddata = $equipment->id;
    $sparepart = Equipmentgrid::where(['eq_id' => $griddata, 'identifier' => 'Spare Part Information'])->firstOrNew();
    $sparepart->eq_id = $griddata;
    $sparepart->identifier = 'Spare Part Information';
    $sparepart->data = $request->spare_part;
    $sparepart->save();


    $trainingGrid = TrainingDetailsGrid::where(['equipmentInfo_id' => $equipment->id, "identifier" => "TrainingPlan"])->firstOrCreate();
    $trainingGrid->equipmentInfo_id = $equipment->id;        
    $trainingPlanData = $request->trainingPlanData;

    foreach ($trainingPlanData as $index => $data) {
        if (!empty($data['file'])) {
            $file = $data['file'];
            $fileName = "Training" . '_file_' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('upload'), $fileName);

            $trainingPlanData[$index]['file_path'] = 'upload/' . $fileName;
            unset($trainingPlanData[$index]['file']);
        } else {
            $trainingPlanData[$index]['file_path'] = null;
        }
    }

    $trainingGrid->data = $trainingPlanData;
    $trainingGrid->identifier = "TrainingPlan";
    $trainingGrid->save();


    /////-----------------------audit trail--------------------

    if(!empty($request->record_number))
    {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Record Number';
        $history->previous = "Null";
        $history->current =$request->record_number;
        $history->comment = "Null";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $equipment->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }

    
    if(!empty($request->division_code))
    {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Site/Location Code';
        $history->previous = "Null";
        $history->current = Helpers::getDivisionName($request->division_code);
        $history->comment = "Null";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $equipment->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }

    if(!empty($request->originator_id))
    {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Initiator';
        $history->previous = "Null";
        $history->current = Helpers::getInitiatorName($request->originator_id);
        $history->comment = "Null";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $equipment->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }

    if(!empty($request->intiation_date))
    {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Date of Initiation';
        $history->previous = "Null";
        $history->current = Helpers::getdateFormat($request->intiation_date);
        $history->comment = "Null";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $equipment->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }

    
    if(!empty($request->assign_to))
    {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Assigned to';
        $history->previous = "Null";
        $history->current =Helpers::getInitiatorName($request->assign_to);
        $history->comment = "Null";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $equipment->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }

    if(!empty($request->due_date))
    {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Due Date';
        $history->previous = "Null";
        $history->current = Helpers::getdateFormat($request->due_date);
        $history->comment = "Null";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $equipment->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }

    
    if(!empty($request->short_description))
    {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Short Description';
        $history->previous = "Null";
        $history->current =$request->short_description;
        $history->comment = "Null";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $equipment->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }

    
    if(!empty($request->equipment_id))
    {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Equipment/Instrument ID/Tag Number';
        $history->previous = "Null";
        $history->current =$request->equipment_id;
        $history->comment = "Null";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $equipment->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }

      
    if(!empty($request->equipment_name_description))
    {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Equipment/Instrument Name/Description';
        $history->previous = "Null";
        $history->current =$request->equipment_name_description;
        $history->comment = "Null";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $equipment->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }

    if(!empty($request->manufacturer))
    {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Manufacturer';
        $history->previous = "Null";
        $history->current =$request->manufacturer;
        $history->comment = "Null";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $equipment->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }

    if(!empty($request->model_number))
    {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Model Number';
        $history->previous = "Null";
        $history->current =$request->model_number;
        $history->comment = "Null";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $equipment->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }

    
    if(!empty($request->serial_number))
    {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Serial Number';
        $history->previous = "Null";
        $history->current =$request->serial_number;
        $history->comment = "Null";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $equipment->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }

    if(!empty($request->location))
    {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Location';
        $history->previous = "Null";
        $history->current =$request->location;
        $history->comment = "Null";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $equipment->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }

    if(!empty($request->purchase_date))
    {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Purchase Date';
        $history->previous = "Null";
        $history->current = Helpers::getdateFormat($request->purchase_date);
        $history->comment = "Null";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $equipment->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }

    
    if(!empty($request->installation_date))
    {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Installation Date';
        $history->previous = "Null";
        $history->current = Helpers::getdateFormat($request->installation_date);
        $history->comment = "Null";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $equipment->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
        
    }

    
    if(!empty($request->warranty_expiration_date))
    {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Warranty Expiration Date';
        $history->previous = "Null";
        $history->current = Helpers::getdateFormat($request->warranty_expiration_date);
        $history->comment = "Null";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $equipment->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }

    
    if(!empty($request->criticality_level))
    {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Criticality Level';
        $history->previous = "Null";
        $history->current =$request->criticality_level;
        $history->comment = "Null";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $equipment->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }

    if(!empty($request->asset_type))
    {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Asset Type';
        $history->previous = "Null";
        $history->current =$request->asset_type;
        $history->comment = "Null";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $equipment->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }

    if(!empty($request->urs_description))
    {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'URS Description';
        $history->previous = "Null";
        $history->current =$request->urs_description;
        $history->comment = "Null";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $equipment->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }

    

    
    if(!empty($request->system_level_risk_assessment_details))
    {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Initial/Business/System Level Risk Assessment Details';
        $history->previous = "Null";
        $history->current =$request->system_level_risk_assessment_details;
        $history->comment = "Null";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $equipment->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }



    
    if(!empty($request->Supporting_Documents))
    {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Supporting Documents';
        $history->previous = "Null";
        // $history->current =$request->Supporting_Documents;
        $history->current = is_array($request->Supporting_Documents) ? json_encode($request->Supporting_Documents) : $request->Supporting_Documents;
        $history->comment = "Null";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $equipment->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }

    

    if(!empty($request->frs_description))
    {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'FRS Description';
        $history->previous = "Null";
        $history->current =$request->frs_description;
        $history->comment = "Null";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $equipment->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }

    if(!empty($request->frs_attachment))
    {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'FRS Attachments';
        $history->previous = "Null";
        // $history->current =$request->frs_attachment;
        $history->current = is_array($request->frs_attachment) 
        ? json_encode($request->frs_attachment) 
        : $request->frs_attachment;
        $history->comment = "Null";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $equipment->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }


    if(!empty($request->functional_risk_assessment_details))
    {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Functional Risk Assessment Details';
        $history->previous = "Null";
        $history->current =$request->functional_risk_assessment_details;
        $history->comment = "Null";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $equipment->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }

    
    if(!empty($request->iq_test_plan))
    {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'IQ Test Plan';
        $history->previous = "Null";
        $history->current =$request->iq_test_plan;
        $history->comment = "Null";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $equipment->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }

    if(!empty($request->iq_protocol))
    {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'IQ Protocol';
        $history->previous = "Null";
        $history->current =$request->iq_protocol;
        $history->comment = "Null";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $equipment->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }


    if(!empty($request->iq_execution))
    {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'IQ Execution';
        $history->previous = "Null";
        $history->current =$request->iq_execution;
        $history->comment = "Null";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $equipment->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }

    if(!empty($request->iq_report))
    {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'IQ Report';
        $history->previous = "Null";
        $history->current =$request->iq_report;
        $history->comment = "Null";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $equipment->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }


    // if(!empty($request->iq_attachment))
    // {
    //     $history = new EquipmentInfoAuditTrail();
    //     $history->equipmentInfo_id = $equipment->id;
    //     $history->activity_type = 'Equipment Qualification Attachment';
    //     $history->previous = "Null";
    //     $history->current =$request->iq_attachment;
    //     $history->comment = "Null";
    //     $history->user_id = Auth::user()->id;
    //     $history->user_name = Auth::user()->name;
    //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    //     $history->origin_state = $equipment->status;
    //     $history->change_to =   "Opened";
    //     $history->change_from = "Null";
    //     $history->action_name = 'Create';
     
    //     $history->save();
    // }


    
    if(!empty($request->dq_test_plan))
    {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'DQ Test Plan';
        $history->previous = "Null";
        $history->current =$request->dq_test_plan;
        $history->comment = "Null";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $equipment->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }


     
    if(!empty($request->dq_protocol))
    {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'DQ Protocol';
        $history->previous = "Null";
        $history->current =$request->dq_protocol;
        $history->comment = "Null";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $equipment->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }

    if(!empty($request->dq_execution))
    {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'DQ Execution';
        $history->previous = "Null";
        $history->current =$request->dq_execution;
        $history->comment = "Null";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $equipment->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }


    if(!empty($request->dq_report))
    {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'DQ Report';
        $history->previous = "Null";
        $history->current =$request->dq_report;
        $history->comment = "Null";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $equipment->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }

    if(!empty($request->dq_attachment))
    {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Equipment Qualification Attachment';
        $history->previous = "Null";
        $history->current =$request->dq_attachment;
        $history->comment = "Null";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $equipment->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }


    if(!empty($request->oq_test_plan))
    {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'OQ Test Plan';
        $history->previous = "Null";
        $history->current =$request->oq_test_plan;
        $history->comment = "Null";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $equipment->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }


    if(!empty($request->oq_protocol))
    {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'OQ Protocol';
        $history->previous = "Null";
        $history->current =$request->oq_protocol;
        $history->comment = "Null";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $equipment->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }

    

    if(!empty($request->oq_execution))
    {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'OQ Execution';
        $history->previous = "Null";
        $history->current =$request->oq_execution;
        $history->comment = "Null";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $equipment->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }

    
    if(!empty($request->oq_report))
    {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'OQ Report';
        $history->previous = "Null";
        $history->current =$request->oq_report;
        $history->comment = "Null";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $equipment->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }


    if(!empty($request->oq_attachment))
    {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Equipment Qualification Attachment';
        $history->previous = "Null";
        $history->current =$request->oq_attachment;
        $history->comment = "Null";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $equipment->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }

    if(!empty($request->pq_test_plan))
    {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'PQ Test Plan';
        $history->previous = "Null";
        $history->current =$request->pq_test_plan;
        $history->comment = "Null";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $equipment->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }

    if(!empty($request->pq_protocol))
    {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'PQ Protocol';
        $history->previous = "Null";
        $history->current =$request->pq_protocol;
        $history->comment = "Null";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $equipment->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }

    
    if(!empty($request->pq_execution))
    {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'PQ Execution';
        $history->previous = "Null";
        $history->current =$request->pq_execution;
        $history->comment = "Null";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $equipment->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }

    if(!empty($request->pq_report))
    {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'PQ Report';
        $history->previous = "Null";
        $history->current =$request->pq_report;
        $history->comment = "Null";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $equipment->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }


    if(!empty($request->pq_attachment))
    {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Equipment Qualification Attachment';
        $history->previous = "Null";
        $history->current =$request->pq_attachment;
        $history->comment = "Null";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $equipment->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }

    if(!empty($request->migration_details))
    {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Migration Details';
        $history->previous = "Null";
        $history->current =$request->igration_details;
        $history->comment = "Null";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $equipment->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }

   
    if(!empty($request->migration_attachment))
    {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Migration Attachment';
        $history->previous = "Null";
        // $history->current =$request->migration_attachment;
        $history->current = is_array($request->migration_attachment) ? json_encode($request->migration_attachment) : $request->migration_attachment;

        $history->comment = "Null";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $equipment->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }


    if(!empty($request->configuration_specification_details))
    {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Configuration Specification Details';
        $history->previous = "Null";
        $history->current =$request->configuration_specification_details;
        $history->comment = "Null";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $equipment->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }


    
    if(!empty($request->configuration_specification_attachment))
    {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Configuration Specification Attachment';
        $history->previous = "Null";
        // $history->current =$request->configuration_specification_attachment;
        $history->current = is_array($request->configuration_specification_attachment) ? json_encode($request->configuration_specification_attachment) : $request->configuration_specification_attachment;

        $history->comment = "Null";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $equipment->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }


    
    if(!empty($request->requirement_traceability_details))
    {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Rquirement Traceability Details';
        $history->previous = "Null";
        $history->current =$request->requirement_traceability_details;
        $history->comment = "Null";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $equipment->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }

      
    if(!empty($request->requirement_traceability_attachment))
    {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Requirement Traceability Attachment';
        $history->previous = "Null";
        // $history->current =$request->requirement_traceability_attachment;
        $history->current = is_array($request->requirement_traceability_attachment) ? json_encode($request->requirement_traceability_attachment) : $request->requirement_traceability_attachment;

        $history->comment = "Null";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $equipment->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }


     
    if(!empty($request->validation_summary_report))
    {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Validation Summary Report';
        $history->previous = "Null";
        $history->current =$request->validation_summary_report;
        $history->comment = "Null";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $equipment->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }


     
    if(!empty($request->periodic_qualification_pending_on_checkdate))
    {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Periodic Qualification Pending On';
        $history->previous = "Null";
        $history->current = Helpers::getdateFormat($request->periodic_qualification_pending_on_checkdate);
        $history->comment = "Null";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $equipment->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }

    if(!empty($request->periodic_qualification_notification))
    {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Periodic Qualification Notification (Days)';
        $history->previous = "Null";
        $history->current =$request->periodic_qualification_notification;
        $history->comment = "Null";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $equipment->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }

    if(!empty($request->calibration_standard_preference))
    {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Calibration Standard Reference';
        $history->previous = "Null";
        $history->current =$request->calibration_standard_preference;
        $history->comment = "Null";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $equipment->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }

    
    if(!empty($request->callibration_frequency))
    {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Calibration Frequency';
        $history->previous = "Null";
        $history->current =$request->callibration_frequency;
        $history->comment = "Null";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $equipment->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }

    if(!empty($request->last_calibration_date))
    {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Last Calibration Date';
        $history->previous = "Null";
        $history->current = Helpers::getdateFormat($request->last_calibration_date);
        $history->comment = "Null";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $equipment->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }

    if(!empty($request->next_calibration_date))
    {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Next Calibration Date';
        $history->previous = "Null";
        $history->current = Helpers::getdateFormat($request->next_calibration_date);
        $history->comment = "Null";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $equipment->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }

    
    if(!empty($request->calibration_due_reminder))
    {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Calibration Due Reminder';
        $history->previous = "Null";
        $history->current =$request->calibration_due_reminder;
        $history->comment = "Null";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $equipment->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }

    if(!empty($request->calibration_method_procedure))
    {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Calibration Method/Procedure';
        $history->previous = "Null";
        $history->current =$request->calibration_method_procedure;
        $history->comment = "Null";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $equipment->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }

    
    if(!empty($request->calibration_procedure_attach))
    {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Calibration Procedure Reference/Document';
        $history->previous = "Null";
        // $history->current =$request->calibration_procedure_attach;
        $history->current = is_array($request->calibration_procedure_attach) ? json_encode($request->calibration_procedure_attach) : $request->calibration_procedure_attach;

        $history->comment = "Null";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $equipment->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }

    
    if(!empty($request->calibration_used))
    {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Calibration Standards Used';
        $history->previous = "Null";
        $history->current =$request->calibration_used;
        $history->comment = "Null";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $equipment->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }

      
    if(!empty($request->calibration_parameter))
    {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Calibration Parameters';
        $history->previous = "Null";
        $history->current =$request->calibration_parameter;
        $history->comment = "Null";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $equipment->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }

    if(!empty($request->event_based_calibration))
    {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Unscheduled or Event Based Calibration?';
        $history->previous = "Null";
        $history->current =$request->event_based_calibration;
        $history->comment = "Null";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $equipment->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }

    if(!empty($request->event_based_calibration_reason))
    {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Reason for Unscheduled or Event Based Calibration';
        $history->previous = "Null";
        $history->current =$request->event_based_calibration_reason;
        $history->comment = "Null";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $equipment->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }

    
    if(!empty($request->event_refernce_no))
    {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Event Reference No';
        $history->previous = "Null";
        $history->current =$request->event_refernce_no;
        $history->comment = "Null";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $equipment->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }

    if(!empty($request->calibration_checklist))
    {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Calibration Checklist';
        $history->previous = "Null";
        $history->current =$request->calibration_checklist;
        $history->comment = "Null";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $equipment->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }

    if(!empty($request->calibration_result))
    {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Calibration Results';
        $history->previous = "Null";
        $history->current =$request->calibration_result;
        $history->comment = "Null";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $equipment->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }

    
    if(!empty($request->calibration_certificate_result))
    {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Calibration Certificate Number';
        $history->previous = "Null";
        $history->current =$request->calibration_certificate_result;
        $history->comment = "Null";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $equipment->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
        
    }

    
    if(!empty($request->calibration_certificate))
    {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Calibration Certificate Attachment';
        $history->previous = "Null";
        // $history->current =$request->calibration_certificate;
        $history->current = is_array($request->calibration_certificate) ? json_encode($request->calibration_certificate) : $request->calibration_certificate;

        $history->comment = "Null";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $equipment->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }

    
    if(!empty($request->calibrated_by))
    {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Calibrated By';
        $history->previous = "Null";
        $history->current =$request->calibrated_by;
        $history->comment = "Null";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $equipment->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }

    if(!empty($request->calibration_due_alert))
    {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Calibration Due Alert';
        $history->previous = "Null";
        $history->current =$request->calibration_due_alert;
        $history->comment = "Null";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $equipment->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }

    if(!empty($request->calibration_cost))
    {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Cost of Calibration';
        $history->previous = "Null";
        $history->current =$request->calibration_cost;
        $history->comment = "Null";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $equipment->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }

    
    if(!empty($request->calibration_comments))
    {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Calibration Comments/Observations';
        $history->previous = "Null";
        $history->current =$request->calibration_comments;
        $history->comment = "Null";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $equipment->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }

    if(!empty($request->pm_schedule))
    {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'PM Schedule';
        $history->previous = "Null";
        $history->current =$request->pm_schedule;
        $history->comment = "Null";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $equipment->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }

    
    if(!empty($request->last_pm_date))
    {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Last Preventive Maintenance Date';
        $history->previous = "Null";
        $history->current = Helpers::getdateFormat($request->last_pm_date);
        $history->comment = "Null";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $equipment->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }

    if(!empty($request->next_pm_date))
    {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Next Preventive Maintenance Date';
        $history->previous = "Null";
        $history->current = Helpers::getdateFormat($request->next_pm_date);
        $history->comment = "Null";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $equipment->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }

    if(!empty($request->pm_task_description))
    {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'PM Task Description';
        $history->previous = "Null";
        $history->current =$request->pm_task_description;
        $history->comment = "Null";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $equipment->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }

    
    if(!empty($request->event_based_PM))
    {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Unscheduled or Event Based Preventive Maintenance?';
        $history->previous = "Null";
        $history->current =$request->event_based_PM;
        $history->comment = "Null";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $equipment->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }

    if(!empty($request->eventbased_pm_reason))
    {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Reason for Unscheduled or Event Based Preventive Maintenance';
        $history->previous = "Null";
        $history->current =$request->eventbased_pm_reason;
        $history->comment = "Null";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $equipment->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }

    
    if(!empty($request->PMevent_refernce_no))
    {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Event Reference No.';
        $history->previous = "Null";
        $history->current =$request->PMevent_refernce_no;
        $history->comment = "Null";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $equipment->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }

    
    if(!empty($request->pm_procedure_document))
    {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'PM Procedure Reference/Document';
        $history->previous = "Null";
        // $history->current =$request->pm_procedure_document;
        $history->current = is_array($request->pm_procedure_document) ? json_encode($request->pm_procedure_document) : $request->pm_procedure_document;

        $history->comment = "Null";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $equipment->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }

      

    if(!empty($request->pm_performed_by))
    {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Performed By';
        $history->previous = "Null";
        $history->current =$request->pm_performed_by;
        $history->comment = "Null";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $equipment->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }

    if(!empty($request->maintenance_observation))
    {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Maintenance Comments/Observations';
        $history->previous = "Null";
        $history->current =$request->maintenance_observation;
        $history->comment = "Null";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $equipment->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }

    
    if(!empty($request->replaced_parts))
    {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Parts Replaced During Maintenance';
        $history->previous = "Null";
        $history->current =$request->replaced_parts;
        $history->comment = "Null";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $equipment->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }

    if(!empty($request->work_order_number))
    {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Maintenance Work Order Number';
        $history->previous = "Null";
        $history->current =$request->work_order_number;
        $history->comment = "Null";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $equipment->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }

    if(!empty($request->pm_checklist))
    {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'PM Checklist';
        $history->previous = "Null";
        $history->current =$request->pm_checklist;
        $history->comment = "Null";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $equipment->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }

    
    if(!empty($request->emergency_flag_maintenance))
    {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Emergency Maintenance Flag';
        $history->previous = "Null";
        $history->current =$request->emergency_flag_maintenance;
        $history->comment = "Null";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $equipment->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
        
    }

    
    if(!empty($request->cost_of_maintenance))
    {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Cost of Maintenance';
        $history->previous = "Null";
        $history->current =$request->cost_of_maintenance;
        $history->comment = "Null";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $equipment->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }

    if(!empty($request->training_required))
    {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Training Required?';
        $history->previous = "Null";
        $history->current =$request->training_required;
        $history->comment = "Null";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $equipment->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }

    
    if(!empty($request->trining_description))
    {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Training Description';
        $history->previous = "Null";
        $history->current =$request->trining_description;
        $history->comment = "Null";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $equipment->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }

    if(!empty($request->training_type))
    {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Training Type';
        $history->previous = "Null";
        $history->current =$request->training_type;
        $history->comment = "Null";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $equipment->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }

    if(!empty($request->training_attachment))
    {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Training Attachment';
        $history->previous = "Null";
        // $history->current =$request->training_attachment;
        $history->current = is_array($request->training_attachment) ? json_encode($request->training_attachment) : $request->training_attachment;

        $history->comment = "Null";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $equipment->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }

    if(!empty($request->supervisor_comment))
    {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Supervisor Review Comments';
        $history->previous = "Null";
        $history->current =$request->supervisor_comment;
        $history->comment = "Null";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $equipment->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }

    
    if(!empty($request->Supervisor_document))
    {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Supervisor Documents';
        $history->previous = "Null";
        // $history->current =$request->Supervisor_document;
        $history->current = is_array($request->Supervisor_document) ? json_encode($request->Supervisor_document) : $request->Supervisor_document;

        $history->comment = "Null";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $equipment->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    } 

    if(!empty($request->QA_comment))
    {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'QA Review Comments';
        $history->previous = "Null";
        $history->current =$request->QA_comment;
        $history->comment = "Null";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $equipment->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }

    
    if(!empty($request->QA_document))
    {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'QA Documents';
        $history->previous = "Null";
        // $history->current =$request->QA_document;
        $history->current = is_array($request->QA_document) ? json_encode($request->QA_document) : $request->QA_document;
        $history->comment = "Null";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $equipment->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }

    if(!empty($request->Equipment_Lifecycle_Stage))
    {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Equipment Lifecycle Stage';
        $history->previous = "Null";
        $history->current =$request->Equipment_Lifecycle_Stage;
        $history->comment = "Null";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $equipment->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }

    
    if(!empty($request->Expected_Useful_Life))
    {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Expected Useful Life';
        $history->previous = "Null";
        $history->current =$request->Expected_Useful_Life;
        $history->comment = "Null";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $equipment->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }

    if(!empty($request->End_of_life_Date))
    {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'End-of-life Date';
        $history->previous = "Null";
        $history->current = Helpers::getDateFormat($request->End_of_life_Date);
        $history->comment = "Null";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $equipment->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }

    if(!empty($request->Decommissioning_and_Disposal_Records))
    {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Decommissioning and Disposal Records';
        $history->previous = "Null";
        $history->current =$request->Decommissioning_and_Disposal_Records;
        $history->comment = "Null";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $equipment->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }

    
    if(!empty($request->Replacement_History))
    {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Replacement History';
        $history->previous = "Null";
        $history->current =$request->Replacement_History;
        $history->comment = "Null";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $equipment->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
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

public function show($id)
{      
    
    $data = EquipmentLifecycleManagement::find($id);
    $equipment  = EquipmentLifecycleManagement::find($id);
    $documents = Document::all();
    $equipgrid  = AttachmentGrid::find($id);
    $trainingGrid = TrainingDetailsGrid::where(['equipmentInfo_id' => $id, 'identifier' => "TrainingPlan"])->first();
    $sparepart = Equipmentgrid::where(['eq_id' => $id, 'identifier' => 'Spare Part Information'])->first();

    $trainingPlanData = $trainingGrid ? (is_array($trainingGrid->data) ? $trainingGrid->data : json_decode($trainingGrid->data, true)) : [];

    
    $record_number = ((RecordNumber::first()->value('counter')) + 1);
    $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
    $equipment->record = str_pad($equipment->record, 4, '0', STR_PAD_LEFT);
    $equipment->assign_to_name = User::where('id', $equipment->assign_id)->value('name');
    $equipment->initiator_name = User::where('id', $equipment->initiator_id)->value('name');
    $currentDate = Carbon::now();
    $formattedDate = $currentDate->addDays(30);
    $due_date = $formattedDate->format('Y-m-d');
   
    return view('frontend.Equipment-Lifecycle-Management.Equipment_Information_View', compact('data', 'equipment', 'record_number','documents','trainingPlanData', 'equipgrid','sparepart'));
}

public function update(Request $request, $id)
{

    $lastDocument = EquipmentLifecycleManagement::find($id);
    $equipment = EquipmentLifecycleManagement::find($id);
    $equipgrid = AttachmentGrid::find($id);

    $equipment->assign_to = $request->assign_to;
    // $equipment->due_date = $request->due_date;
    $equipment->short_description = $request->short_description;
    $equipment->equipment_id = $request->equipment_id;
    $equipment->equipment_name_description = $request->equipment_name_description;
    $equipment->manufacturer = $request->manufacturer;
    $equipment->model_number = $request->model_number;
    $equipment->serial_number = $request->serial_number;
    $equipment->location = $request->location;
    $equipment->purchase_date = $request->purchase_date;
    $equipment->installation_date = $request->installation_date;
    $equipment->warranty_expiration_date = $request->warranty_expiration_date;
    $equipment->criticality_level = $request->criticality_level;
    $equipment->asset_type = $request->asset_type;

    $equipment->urs_description = $request->urs_description;
    $equipment->system_level_risk_assessment_details = $request->system_level_risk_assessment_details;
    $equipment->failure_mode_effect_analysis = $request->failure_mode_effect_analysis;
    // $equipment->supporting_documents = $request->supporting_documents;
    $equipment->frs_description = $request->frs_description;
    // $equipment->frs_attachment = $request->frs_attachment;
    $equipment->functional_risk_assessment_details = $request->functional_risk_assessment_details;

    // Installation Qualification (IQ)
    $equipment->iq_test_plan = $request->iq_test_plan;
    $equipment->iq_protocol = $request->iq_protocol;
    $equipment->iq_execution = $request->iq_execution;
    $equipment->iq_report = $request->iq_report;
    // $equipment->iq_attachment = $request->iq_attachment;

    // Design Qualification (DQ)
    $equipment->dq_test_plan = $request->dq_test_plan;
    $equipment->dq_protocol = $request->dq_protocol;
    $equipment->dq_execution = $request->dq_execution;
    $equipment->dq_report = $request->dq_report;
    // $equipment->dq_attachment = $request->dq_attachment;

    // Operational Qualification (OQ)
    $equipment->oq_test_plan = $request->oq_test_plan;
    $equipment->oq_protocol = $request->oq_protocol;
    $equipment->oq_execution = $request->oq_execution;
    $equipment->oq_report = $request->oq_report;
    // $equipment->oq_attachment = $request->oq_attachment;

    // Performance Qualification (PQ)
    $equipment->pq_test_plan = $request->pq_test_plan;
    $equipment->pq_protocol = $request->pq_protocol;
    $equipment->pq_execution = $request->pq_execution;
    $equipment->pq_report = $request->pq_report;
    // $equipment->pq_attachment = $request->pq_attachment;

    $equipment->migration_details = $request->migration_details;
    // $equipment->migration_attachment = $request->migration_attachment;
    $equipment->configuration_specification_details = $request->configuration_specification_details;
    // $equipment->configuration_specification_attachment = $request->configuration_specification_attachment;
    $equipment->requirement_traceability_details = $request->requirement_traceability_details;
    // $equipment->requirement_traceability_attachment = $request->requirement_traceability_attachment;
    $equipment->validation_summary_report = $request->validation_summary_report;
    $equipment->periodic_qualification_pending_on = $request->periodic_qualification_pending_on;
    $equipment->periodic_qualification_notification = $request->periodic_qualification_notification;


    //Failure Mode and Effect Analysis+

    if (!empty($request->risk_factor)) {
        $equipment->risk_factor = serialize($request->risk_factor);
    }
    if (!empty($request->risk_element)) {
        $equipment->risk_element = serialize($request->risk_element);
    }
    if (!empty($request->problem_cause)) {
        $equipment->problem_cause = serialize($request->problem_cause);
    }
    if (!empty($request->existing_risk_control)) {
        $equipment->existing_risk_control = serialize($request->existing_risk_control);
    }
    if (!empty($request->initial_severity)) {
        $equipment->initial_severity = serialize($request->initial_severity);
    }
    if (!empty($request->initial_detectability)) {
        $equipment->initial_detectability = serialize($request->initial_detectability);
    }
    if (!empty($request->initial_probability)) {
        $equipment->initial_probability = serialize($request->initial_probability);
    }
    if (!empty($request->initial_rpn)) {
        $equipment->initial_rpn = serialize($request->initial_rpn);
    }
    if (!empty($request->risk_acceptance)) {
        $equipment->risk_acceptance = serialize($request->risk_acceptance);
    }
    if (!empty($request->risk_control_measure)) {
        $equipment->risk_control_measure = serialize($request->risk_control_measure);
    }
    if (!empty($request->residual_severity)) {
        $equipment->residual_severity = serialize($request->residual_severity);
    }
    if (!empty($request->residual_probability)) {
        $equipment->residual_probability = serialize($request->residual_probability);
    }
    if (!empty($request->residual_detectability)) {
        $equipment->residual_detectability = serialize($request->residual_detectability);
    }
    if (!empty($request->residual_rpn)) {
        $equipment->residual_rpn = serialize($request->residual_rpn);
    }
    if (!empty($request->risk_acceptance2)) {
        $equipment->risk_acceptance2 = serialize($request->risk_acceptance2);
    }
    if (!empty($request->mitigation_proposal)) {
        $equipment->mitigation_proposal = serialize($request->mitigation_proposal);
    }


    //-------------Equipment Qualification Grid start------------//

    if (!empty($request->doc_name_IQ)) {
        $equipgrid->doc_name_IQ = serialize($request->doc_name_IQ);
    }
    if (!empty($request->doc_id_IQ)) {
        $equipgrid->doc_id_IQ = serialize($request->doc_id_IQ);
    }
    if (!empty($request->doc_remark_IQ)) {
        $equipgrid->doc_remark_IQ = serialize($request->doc_remark_IQ);
    }

    if (!empty($request->doc_name_DQ)) {
        $equipgrid->doc_name_DQ = serialize($request->doc_name_DQ);
    }
    if (!empty($request->doc_id_DQ)) {
        $equipgrid->doc_id_DQ = serialize($request->doc_id_DQ);
    }
    if (!empty($request->doc_remark_DQ)) {
        $equipgrid->doc_remark_DQ = serialize($request->doc_remark_DQ);
    }

    if (!empty($request->doc_name_OQ)) {
        $equipgrid->doc_name_OQ = serialize($request->doc_name_OQ);
    }
    if (!empty($request->doc_id_OQ)) {
        $equipgrid->doc_id_OQ = serialize($request->doc_id_OQ);
    }
    if (!empty($request->doc_remark_OQ)) {
        $equipgrid->doc_remark_OQ = serialize($request->doc_remark_OQ);
    }

    if (!empty($request->doc_name_PQ)) {
        $equipgrid->doc_name_PQ = serialize($request->doc_name_PQ);
    }
    if (!empty($request->doc_id_PQ)) {
        $equipgrid->doc_id_PQ = serialize($request->doc_id_PQ);
    }
    if (!empty($request->doc_remark_PQ)) {
        $equipgrid->doc_remark_PQ = serialize($request->doc_remark_PQ);
    }

    $equipgrid->update();
//-----------------Equipment Qualification Grid start------------------//



    // // Spare Part Information

    // if (!empty($request->SpareEquipment_Name)) {
    //     $equipment->SpareEquipment_Name = serialize($request->SpareEquipment_Name);
    // }
    // if (!empty($request->SpareEquipment_ID)) {
    //     $equipment->SpareEquipment_ID = serialize($request->SpareEquipment_ID);
    // }
    // if (!empty($request->SparePart_ID)) {
    //     $equipment->SparePart_ID = serialize($request->SparePart_ID);
    // }
    // if (!empty($request->SparePart_Name)) {
    //     $equipment->SparePart_Name = serialize($request->SparePart_Name);
    // }
    // if (!empty($request->SpareManufacturer)) {
    //     $equipment->SpareManufacturer = serialize($request->SpareManufacturer);
    // }
    // if (!empty($request->SpareModel_Number)) {
    //     $equipment->SpareModel_Number = serialize($request->SpareModel_Number);
    // }
    // if (!empty($request->SpareSerial_Number)) {
    //     $equipment->SpareSerial_Number = serialize($request->SpareSerial_Number);
    // }
    // if (!empty($request->SpareOEM)) {
    //     $equipment->SpareOEM = serialize($request->SpareOEM);
    // }
    // if (!empty($request->SparePart_Category)) {
    //     $equipment->SparePart_Category = serialize($request->SparePart_Category);
    // }
    // if (!empty($request->SparePart_Group)) {
    //     $equipment->SparePart_Group = serialize($request->SparePart_Group);
    // }
    // if (!empty($request->SparePart_Dimensions)) {
    //     $equipment->SparePart_Dimensions = serialize($request->SparePart_Dimensions);
    // }
    // if (!empty($request->SpareMaterial)) {
    //     $equipment->SpareMaterial = serialize($request->SpareMaterial);
    // }
    // if (!empty($request->SpareWeight)) {
    //     $equipment->SpareWeight = serialize($request->SpareWeight);
    // }
    // if (!empty($request->SpareColor)) {
    //     $equipment->SpareColor = serialize($request->SpareColor);
    // }
    // if (!empty($request->SparePart_Lifecycle_Stage)) {
    //     $equipment->SparePart_Lifecycle_Stage = serialize($request->SparePart_Lifecycle_Stage);
    // }
    // if (!empty($request->SparePart_Status)) {
    //     $equipment->SparePart_Status = serialize($request->SparePart_Status);
    // }
    // if (!empty($request->SpareAvailability)) {
    //     $equipment->SpareAvailability = serialize($request->SpareAvailability);
    // }
    // if (!empty($request->SpareQuantity_on_Hand)) {
    //     $equipment->SpareQuantity_on_Hand = serialize($request->SpareQuantity_on_Hand);
    // }
    // if (!empty($request->SpareQuantity_on_Order)) {
    //     $equipment->SpareQuantity_on_Order = serialize($request->SpareQuantity_on_Order);
    // }
    // if (!empty($request->SpareReorder_Point)) {
    //     $equipment->SpareReorder_Point = serialize($request->SpareReorder_Point);
    // }
    // if (!empty($request->SpareSafety_Stock)) {
    //     $equipment->SpareSafety_Stock = serialize($request->SpareSafety_Stock);
    // }
    // if (!empty($request->SpareMinimum_Order_Quantity)) {
    //     $equipment->SpareMinimum_Order_Quantity = serialize($request->SpareMinimum_Order_Quantity);
    // }
    // if (!empty($request->SpareLead_Time)) {
    //     $equipment->SpareLead_Time = serialize($request->SpareLead_Time);
    // }
    // if (!empty($request->SpareStock_Location)) {
    //     $equipment->SpareStock_Location = serialize($request->SpareStock_Location);
    // }
    // if (!empty($request->SpareBin_Number)) {
    //     $equipment->SpareBin_Number = serialize($request->SpareBin_Number);
    // }
    // if (!empty($request->SpareStock_Keeping_Unit)) {
    //     $equipment->SpareStock_Keeping_Unit = serialize($request->SpareStock_Keeping_Unit);
    // }
    // if (!empty($request->SpareLot_Number)) {
    //     $equipment->SpareLot_Number = serialize($request->SpareLot_Number);
    // }
    // if (!empty($request->SpareExpiry_Date)) {
    //     $equipment->SpareExpiry_Date = serialize($request->SpareExpiry_Date);
    // }
    // if (!empty($request->SpareSupplier_Name)) {
    //     $equipment->SpareSupplier_Name = serialize($request->SpareSupplier_Name);
    // }
    // if (!empty($request->SpareSupplier_Contact_Information)) {
    //     $equipment->SpareSupplier_Contact_Information = serialize($request->SpareSupplier_Contact_Information);
    // }
    // if (!empty($request->SpareSupplier_Lead_Time)) {
    //     $equipment->SpareSupplier_Lead_Time = serialize($request->SpareSupplier_Lead_Time);
    // }
    // if (!empty($request->SpareSupplier_Price)) {
    //     $equipment->SpareSupplier_Price = serialize($request->SpareSupplier_Price);
    // }
    // if (!empty($request->SpareSupplier_Part_Number)) {
    //     $equipment->SpareSupplier_Part_Number = serialize($request->SpareSupplier_Part_Number);
    // }
    // if (!empty($request->SpareSupplier_Warranty_Information)) {
    //     $equipment->SpareSupplier_Warranty_Information = serialize($request->SpareSupplier_Warranty_Information);
    // }
    // if (!empty($request->SpareSupplier_Performance_Metrics)) {
    //     $equipment->SpareSupplier_Performance_Metrics = serialize($request->SpareSupplier_Performance_Metrics);
    // }

    // //-----------



    $equipment->calibration_standard_preference = $request->calibration_standard_preference;
    $equipment->callibration_frequency = $request->callibration_frequency;
    $equipment->last_calibration_date = $request->last_calibration_date;
    $equipment->next_calibration_date = $request->next_calibration_date;
    $equipment->calibration_due_reminder = $request->calibration_due_reminder;
    $equipment->calibration_method_procedure = $request->calibration_method_procedure;
    // $equipment->calibration_procedure_attach = $request->calibration_procedure_attach;
    $equipment->calibration_used = $request->calibration_used;
    $equipment->calibration_parameter = $request->calibration_parameter;
    $equipment->event_based_calibration = $request->event_based_calibration;
    $equipment->event_based_calibration_reason = $request->event_based_calibration_reason;
    $equipment->event_refernce_no = $request->event_refernce_no;
    $equipment->calibration_checklist = $request->calibration_checklist;
    $equipment->calibration_result = $request->calibration_result;
    $equipment->calibration_certificate_result = $request->calibration_certificate_result;
    // $equipment->calibration_certificate = $request->calibration_certificate;
    $equipment->calibrated_by = $request->calibrated_by;
    $equipment->calibration_due_alert = $request->calibration_due_alert;
    $equipment->calibration_cost = $request->calibration_cost;
    $equipment->calibration_comments = $request->calibration_comments;

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

    $equipment->training_required = $request->training_required;
    $equipment->trining_description = $request->trining_description;
    $equipment->training_type = $request->training_type;
    // $equipment->training_attachment = $request->training_attachment;

    $equipment->supervisor_comment = $request->supervisor_comment;
    // $equipment->Supervisor_document = $request->Supervisor_document;

    $equipment->QA_comment = $request->QA_comment;
    // $equipment->QA_document = $request->QA_document;

    $equipment->Equipment_Lifecycle_Stage = $request->Equipment_Lifecycle_Stage;
    $equipment->Expected_Useful_Life = $request->Expected_Useful_Life;
    $equipment->End_of_life_Date = $request->End_of_life_Date;
    $equipment->Decommissioning_and_Disposal_Records = $request->Decommissioning_and_Disposal_Records;
    $equipment->Replacement_History = $request->Replacement_History;
    

    
    if (!empty($request->supporting_documents)) {
        $files = [];
        if ($request->hasfile('supporting_documents')) {
            foreach ($request->file('supporting_documents') as $file) {
                $name = $request->name . '-supporting_documents' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                $file->move('upload/', $name);
                $files[] = $name;
            }
        }
        $equipment->supporting_documents = json_encode($files);
    }

    if (!empty($request->calibration_procedure_attach)) {
        $files = [];
        if ($request->hasfile('calibration_procedure_attach')) {
            foreach ($request->file('calibration_procedure_attach') as $file) {
                $name = $request->name . '-calibration_procedure_attach' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                $file->move('upload/', $name);
                $files[] = $name;
            }
        }
        $equipment->calibration_procedure_attach = json_encode($files);
    }

    if (!empty($request->frs_attachment)) {
        $files = [];
        if ($request->hasfile('frs_attachment')) {
            foreach ($request->file('frs_attachment') as $file) {
                $name = $request->name . '-frs_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                $file->move('upload/', $name);
                $files[] = $name;
            }
        }
        $equipment->frs_attachment = json_encode($files);
    }

    // if (!empty($request->iq_attachment)) {
    //     $files = [];
    //     if ($request->hasfile('iq_attachment')) {
    //         foreach ($request->file('iq_attachment') as $file) {
    //             $name = $request->name . '-iq_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
    //             $file->move('upload/', $name);
    //             $files[] = $name;
    //         }
    //     }
    //     $equipment->iq_attachment = json_encode($files);
    // }

    if (!empty($request->dq_attachment)) {
        $files = [];
        if ($request->hasfile('dq_attachment')) {
            foreach ($request->file('dq_attachment') as $file) {
                $name = $request->name . '-dq_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                $file->move('upload/', $name);
                $files[] = $name;
            }
        }
        $equipment->dq_attachment = json_encode($files);
    }

    if (!empty($request->oq_attachment)) {
        $files = [];
        if ($request->hasfile('oq_attachment')) {
            foreach ($request->file('oq_attachment') as $file) {
                $name = $request->name . '-oq_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                $file->move('upload/', $name);
                $files[] = $name;
            }
        }
        $equipment->oq_attachment = json_encode($files);
    }

    if (!empty($request->pq_attachment)) {
        $files = [];
        if ($request->hasfile('pq_attachment')) {
            foreach ($request->file('pq_attachment') as $file) {
                $name = $request->name . '-pq_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                $file->move('upload/', $name);
                $files[] = $name;
            }
        }
        $equipment->pq_attachment = json_encode($files);
    }
    if (!empty($request->migration_attachment)) {
        $files = [];
        if ($request->hasfile('migration_attachment')) {
            foreach ($request->file('migration_attachment') as $file) {
                $name = $request->name . '-migration_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                $file->move('upload/', $name);
                $files[] = $name;
            }
        }
        $equipment->migration_attachment = json_encode($files);
    }
    if (!empty($request->configuration_specification_attachment)) {
        $files = [];
        if ($request->hasfile('configuration_specification_attachment')) {
            foreach ($request->file('configuration_specification_attachment') as $file) {
                $name = $request->name . '-configuration_specification_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                $file->move('upload/', $name);
                $files[] = $name;
            }
        }
        $equipment->configuration_specification_attachment = json_encode($files);
    }
    if (!empty($request->requirement_traceability_attachment)) {
        $files = [];
        if ($request->hasfile('requirement_traceability_attachment')) {
            foreach ($request->file('requirement_traceability_attachment') as $file) {
                $name = $request->name . '-requirement_traceability_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                $file->move('upload/', $name);
                $files[] = $name;
            }
        }
        $equipment->requirement_traceability_attachment = json_encode($files);
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
        $equipment->calibration_certificate = json_encode($files);
    }
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
    if (!empty($request->training_attachment)) {
        $files = [];
        if ($request->hasfile('training_attachment')) {
            foreach ($request->file('training_attachment') as $file) {
                $name = $request->name . '-training_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                $file->move('upload/', $name);
                $files[] = $name;
            }
        }
        $equipment->training_attachment = json_encode($files);
    }
    if (!empty($request->Supervisor_document)) {
        $files = [];
        if ($request->hasfile('Supervisor_document')) {
            foreach ($request->file('Supervisor_document') as $file) {
                $name = $request->name . '-Supervisor_document' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                $file->move('upload/', $name);
                $files[] = $name;
            }
        }
        $equipment->Supervisor_document = json_encode($files);
    }

    if (!empty($request->QA_document)) {
        $files = [];
        if ($request->hasfile('QA_document')) {
            foreach ($request->file('QA_document') as $file) {
                $name = $request->name . '-QA_document' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                $file->move('upload/', $name);
                $files[] = $name;
            }
        }
        $equipment->QA_document = json_encode($files);
    }


    $equipment->update();

//spare grid update
    $griddata = $equipment->id;
    $sparepart = Equipmentgrid::where(['eq_id' => $griddata, 'identifier' => 'Spare Part Information'])->firstOrNew();
    $sparepart->eq_id = $griddata;
    $sparepart->identifier = 'Spare Part Information';
    $sparepart->data = $request->spare_part;
    $sparepart->save();


    $trainingGrid = TrainingDetailsGrid::where(['equipmentInfo_id' => $equipment->id, "identifier" => "TrainingPlan"])->firstOrCreate();
    $trainingGrid->equipmentInfo_id = $equipment->id;        
    $trainingPlanData = $request->trainingPlanData;

    foreach ($trainingPlanData as $index => $data) {
        if (!empty($data['file'])) {
            $file = $data['file'];
            $fileName = "Training" . '_file_' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('upload'), $fileName);

            $trainingPlanData[$index]['file_path'] = 'upload/' . $fileName;
            unset($trainingPlanData[$index]['file']);
        } else {
            $trainingPlanData[$index]['file_path'] = null;
        }
    }

    $trainingGrid->data = $trainingPlanData;
    $trainingGrid->identifier = "TrainingPlan";
    $trainingGrid->save();

    //--------------------------------------------------------------------------
    
    if ($lastDocument->assign_to != $equipment->assign_to || !empty($request->assign_to_comment)) {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Assigned To';
        $history->previous = Helpers::getInitiatorName($lastDocument->assign_to);
        $history->current = Helpers::getInitiatorName($equipment->assign_to);
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

    if ($lastDocument->due_date != $equipment->due_date || !empty($request->due_date_comment)) {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Due Date';
        $history->previous = Helpers::getdateFormat($lastDocument->due_date);
        $history->current = Helpers::getdateFormat($equipment->due_date);
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

    if ($lastDocument->short_description != $equipment->short_description || !empty($request->short_description_comment)) {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Short Description';
        $history->previous = $lastDocument->short_description;
        $history->current = $equipment->short_description;
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

    if ($lastDocument->equipment_id != $equipment->equipment_id || !empty($request->equipment_id_comment)) {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Equipment/Instrument ID/Tag Number';
        $history->previous = $lastDocument->equipment_id;
        $history->current = $equipment->equipment_id;
        $history->comment = $request->equipment_id_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to = "Not Applicable";
        $history->change_from = $lastDocument->status;

        // Null or empty check
        if (is_null($lastDocument->equipment_id) || $lastDocument->equipment_id === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }

        $history->save();
    }

    if ($lastDocument->equipment_name_description != $equipment->equipment_name_description || !empty($request->equipment_name_description_comment)) {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Equipment/Instrument Name/Description';
        $history->previous = $lastDocument->equipment_name_description;
        $history->current = $equipment->equipment_name_description;
        $history->comment = $request->equipment_name_description_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to = "Not Applicable";
        $history->change_from = $lastDocument->status;

        // Null or empty check
        if (is_null($lastDocument->equipment_name_description) || $lastDocument->equipment_name_description === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }

        $history->save();
    }

    if ($lastDocument->manufacturer != $equipment->manufacturer || !empty($request->manufacturer_comment)) {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Manufacturer';
        $history->previous = $lastDocument->manufacturer;
        $history->current = $equipment->manufacturer;
        $history->comment = $request->manufacturer_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to = "Not Applicable";
        $history->change_from = $lastDocument->status;

        // Null or empty check
        if (is_null($lastDocument->manufacturer) || $lastDocument->manufacturer === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }

        $history->save();
    }

    
    if ($lastDocument->model_number != $equipment->model_number || !empty($request->model_number_comment)) {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Model Number';
        $history->previous = $lastDocument->model_number;
        $history->current = $equipment->model_number;
        $history->comment = $request->model_number_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to = "Not Applicable";
        $history->change_from = $lastDocument->status;

        // Null or empty check
        if (is_null($lastDocument->model_number) || $lastDocument->model_number === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }

        $history->save();
    }

    if ($lastDocument->serial_number != $equipment->serial_number || !empty($request->serial_number_comment)) {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Serial Number';
        $history->previous = $lastDocument->serial_number;
        $history->current = $equipment->serial_number;
        $history->comment = $request->serial_number_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to = "Not Applicable";
        $history->change_from = $lastDocument->status;

        // Null or empty check
        if (is_null($lastDocument->serial_number) || $lastDocument->serial_number === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }

        $history->save();
    }

    if ($lastDocument->location != $equipment->location || !empty($request->location_comment)) {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Location';
        $history->previous = $lastDocument->location;
        $history->current = $equipment->location;
        $history->comment = $request->location_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to = "Not Applicable";
        $history->change_from = $lastDocument->status;

        // Null or empty check
        if (is_null($lastDocument->location) || $lastDocument->location === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }

        $history->save();
    }

    if ($lastDocument->location != $equipment->location || !empty($request->location_comment)) {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Location';
        $history->previous = $lastDocument->location;
        $history->current = $equipment->location;
        $history->comment = $request->location_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to = "Not Applicable";
        $history->change_from = $lastDocument->status;

        // Null or empty check
        if (is_null($lastDocument->location) || $lastDocument->location === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }

        $history->save();
    }

    if ($lastDocument->purchase_date != $equipment->purchase_date || !empty($request->purchase_date_comment)) {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Purchase Date';
        $history->previous = Helpers::getdateFormat($lastDocument->purchase_date);
        $history->current = Helpers::getdateFormat($equipment->purchase_date);
        $history->comment = $request->purchase_date_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to = "Not Applicable";
        $history->change_from = $lastDocument->status;

        // Null or empty check
        if (is_null($lastDocument->purchase_date) || $lastDocument->purchase_date === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }

        $history->save();
    }


    if ($lastDocument->installation_date != $equipment->installation_date || !empty($request->installation_date_comment)) {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Installation Date';
        $history->previous = Helpers::getdateFormat($lastDocument->installation_date);
        $history->current = Helpers::getdateFormat($equipment->installation_date);
        $history->comment = $request->installation_date_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to = "Not Applicable";
        $history->change_from = $lastDocument->status;

        // Null or empty check
        if (is_null($lastDocument->installation_date) || $lastDocument->installation_date === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }

        $history->save();
    }

    if ($lastDocument->warranty_expiration_date != $equipment->warranty_expiration_date || !empty($request->warranty_expiration_date_comment)) {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Warranty Expiration Date';
        $history->previous = Helpers::getdateFormat($lastDocument->warranty_expiration_date);
        $history->current = Helpers::getdateFormat($equipment->warranty_expiration_date);
        $history->comment = $request->warranty_expiration_date_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to = "Not Applicable";
        $history->change_from = $lastDocument->status;

        // Null or empty check
        if (is_null($lastDocument->warranty_expiration_date) || $lastDocument->warranty_expiration_date === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }

        $history->save();
    }


    if ($lastDocument->criticality_level != $equipment->criticality_level || !empty($request->criticality_level_comment)) {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Criticality Level';
        $history->previous = $lastDocument->criticality_level;
        $history->current = $equipment->criticality_level;
        $history->comment = $request->criticality_level_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to = "Not Applicable";
        $history->change_from = $lastDocument->status;

        // Null or empty check
        if (is_null($lastDocument->criticality_level) || $lastDocument->criticality_level === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }

        $history->save();
    }

    
    if ($lastDocument->asset_type != $equipment->asset_type || !empty($request->asset_type_comment)) {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Asset Type';
        $history->previous = $lastDocument->asset_type;
        $history->current = $equipment->asset_type;
        $history->comment = $request->asset_type_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to = "Not Applicable";
        $history->change_from = $lastDocument->status;

        // Null or empty check
        if (is_null($lastDocument->asset_type) || $lastDocument->asset_type === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }

        $history->save();
    }

    if ($lastDocument->urs_description != $equipment->urs_description || !empty($request->urs_description_comment)) {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'URS Description';
        $history->previous = $lastDocument->urs_description;
        $history->current = $equipment->urs_description;
        $history->comment = $request->urs_description_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to = "Not Applicable";
        $history->change_from = $lastDocument->status;

        // Null or empty check
        if (is_null($lastDocument->urs_description) || $lastDocument->urs_description === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }

        $history->save();
    }


    if ($lastDocument->system_level_risk_assessment_details != $equipment->system_level_risk_assessment_details || !empty($request->system_level_risk_assessment_details_comment)) {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Initial/Business/System Level Risk Assessment Details';
        $history->previous = $lastDocument->system_level_risk_assessment_details;
        $history->current = $equipment->system_level_risk_assessment_details;
        $history->comment = $request->system_level_risk_assessment_details_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to = "Not Applicable";
        $history->change_from = $lastDocument->status;

        // Null or empty check
        if (is_null($lastDocument->system_level_risk_assessment_details) || $lastDocument->system_level_risk_assessment_details === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }

        $history->save();
    }

    
    if ($lastDocument->Supporting_Documents != $equipment->Supporting_Documents || !empty($request->Supporting_Documents_comment)) {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Supporting Documents';
        $history->previous = $lastDocument->Supporting_Documents;
        $history->current = $equipment->Supporting_Documents;
        $history->comment = $request->Supporting_Documents_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to = "Not Applicable";
        $history->change_from = $lastDocument->status;

        // Null or empty check
        if (is_null($lastDocument->Supporting_Documents) || $lastDocument->Supporting_Documents === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }

        $history->save();
    }


    if ($lastDocument->frs_description != $equipment->frs_description || !empty($request->frs_description_comment)) {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'FRS Description';
        $history->previous = $lastDocument->frs_description;
        $history->current = $equipment->frs_description;
        $history->comment = $request->frs_description_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to = "Not Applicable";
        $history->change_from = $lastDocument->status;

        // Null or empty check
        if (is_null($lastDocument->frs_description) || $lastDocument->frs_description === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }

        $history->save();
    }


    
    if ($lastDocument->frs_attachment != $equipment->frs_attachment || !empty($request->frs_attachment_comment)) {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'FRS Attachment';
        $history->previous = $lastDocument->frs_attachment;
        $history->current = $equipment->frs_attachment;
        $history->comment = $request->frs_attachment_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to = "Not Applicable";
        $history->change_from = $lastDocument->status;

        // Null or empty check
        if (is_null($lastDocument->frs_attachment) || $lastDocument->frs_attachment === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }

        $history->save();
    }


    
    if ($lastDocument->functional_risk_assessment_details != $equipment->functional_risk_assessment_details || !empty($request->functional_risk_assessment_details_comment)) {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Functional Risk Assessment Details';
        $history->previous = $lastDocument->functional_risk_assessment_details;
        $history->current = $equipment->functional_risk_assessment_details;
        $history->comment = $request->functional_risk_assessment_details_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to = "Not Applicable";
        $history->change_from = $lastDocument->status;

        // Null or empty check
        if (is_null($lastDocument->functional_risk_assessment_details) || $lastDocument->functional_risk_assessment_details === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }

        $history->save();
    }


    if ($lastDocument->iq_test_plan != $equipment->iq_test_plan || !empty($request->iq_test_plan_comment)) {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'IQ Test Plan';
        $history->previous = $lastDocument->iq_test_plan;
        $history->current = $equipment->iq_test_plan;
        $history->comment = $request->iq_test_plan_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to = "Not Applicable";
        $history->change_from = $lastDocument->status;

        // Null or empty check
        if (is_null($lastDocument->iq_test_plan) || $lastDocument->iq_test_plan === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }

        $history->save();
    }


    if ($lastDocument->iq_protocol != $equipment->iq_protocol || !empty($request->iq_protocol_comment)) {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'IQ Protocol';
        $history->previous = $lastDocument->iq_protocol;
        $history->current = $equipment->iq_protocol;
        $history->comment = $request->iq_protocol_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to = "Not Applicable";
        $history->change_from = $lastDocument->status;

        // Null or empty check
        if (is_null($lastDocument->iq_protocol) || $lastDocument->iq_protocol === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }

        $history->save();
    }


    if ($lastDocument->iq_execution != $equipment->iq_execution || !empty($request->iq_execution_comment)) {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'IQ Execution';
        $history->previous = $lastDocument->iq_execution;
        $history->current = $equipment->iq_execution;
        $history->comment = $request->iq_execution_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to = "Not Applicable";
        $history->change_from = $lastDocument->status;

        // Null or empty check
        if (is_null($lastDocument->iq_execution) || $lastDocument->iq_execution === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }

        $history->save();
    }



    if ($lastDocument->iq_report != $equipment->iq_report || !empty($request->iq_report_comment)) {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'IQ Report';
        $history->previous = $lastDocument->iq_report;
        $history->current = $equipment->iq_report;
        $history->comment = $request->iq_report_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to = "Not Applicable";
        $history->change_from = $lastDocument->status;

        // Null or empty check
        if (is_null($lastDocument->iq_report) || $lastDocument->iq_report === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }

        $history->save();
    }


    // if ($lastDocument->iq_attachment != $equipment->iq_attachment || !empty($request->iq_attachment_comment)) {
    //     $history = new EquipmentInfoAuditTrail();
    //     $history->equipmentInfo_id = $equipment->id;
    //     $history->activity_type = 'Equipment Qualification Attachment';
    //     $history->previous = $lastDocument->iq_attachment;
    //     $history->current = $equipment->iq_attachment;
    //     $history->comment = $request->iq_attachment_comment;
    //     $history->user_id = Auth::user()->id;
    //     $history->user_name = Auth::user()->name;
    //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    //     $history->origin_state = $lastDocument->status;
    //     $history->change_to = "Not Applicable";
    //     $history->change_from = $lastDocument->status;

    //     // Null or empty check
    //     if (is_null($lastDocument->iq_attachment) || $lastDocument->iq_attachment === '') {
    //         $history->action_name = "New";
    //     } else {
    //         $history->action_name = "Update";
    //     }

    //     $history->save();
    // }

    if ($lastDocument->dq_test_plan != $equipment->dq_test_plan || !empty($request->dq_test_plan_comment)) {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'DQ Test Plan';
        $history->previous = $lastDocument->dq_test_plan;
        $history->current = $equipment->dq_test_plan;
        $history->comment = $request->dq_test_plan_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to = "Not Applicable";
        $history->change_from = $lastDocument->status;

        // Null or empty check
        if (is_null($lastDocument->dq_test_plan) || $lastDocument->dq_test_plan === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }

        $history->save();
    }


    if ($lastDocument->dq_protocol != $equipment->dq_protocol || !empty($request->dq_protocol_comment)) {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'DQ Protocol';
        $history->previous = $lastDocument->dq_protocol;
        $history->current = $equipment->dq_protocol;
        $history->comment = $request->dq_protocol_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to = "Not Applicable";
        $history->change_from = $lastDocument->status;

        // Null or empty check
        if (is_null($lastDocument->dq_protocol) || $lastDocument->dq_protocol === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }

        $history->save();
    }


    if ($lastDocument->dq_execution != $equipment->dq_execution || !empty($request->dq_execution_comment)) {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'DQ Execution';
        $history->previous = $lastDocument->dq_execution;
        $history->current = $equipment->dq_execution;
        $history->comment = $request->dq_execution_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to = "Not Applicable";
        $history->change_from = $lastDocument->status;

        // Null or empty check
        if (is_null($lastDocument->dq_execution) || $lastDocument->dq_execution === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }

        $history->save();
    }


    if ($lastDocument->dq_report != $equipment->dq_report || !empty($request->dq_report_comment)) {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'DQ Report';
        $history->previous = $lastDocument->dq_report;
        $history->current = $equipment->dq_report;
        $history->comment = $request->dq_report_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to = "Not Applicable";
        $history->change_from = $lastDocument->status;

        // Null or empty check
        if (is_null($lastDocument->dq_report) || $lastDocument->dq_report === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }

        $history->save();
    }


    if ($lastDocument->dq_attachment != $equipment->dq_attachment || !empty($request->dq_attachment_comment)) {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Equipment Qualification Attachment';
        $history->previous = $lastDocument->dq_attachment;
        $history->current = $equipment->dq_attachment;
        $history->comment = $request->dq_attachment_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to = "Not Applicable";
        $history->change_from = $lastDocument->status;

        // Null or empty check
        if (is_null($lastDocument->dq_attachment) || $lastDocument->dq_attachment === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }

        $history->save();
    }


    
    if ($lastDocument->oq_test_plan != $equipment->oq_test_plan || !empty($request->oq_test_plan_comment)) {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'OQ Test Plan';
        $history->previous = $lastDocument->oq_test_plan;
        $history->current = $equipment->oq_test_plan;
        $history->comment = $request->oq_test_plan_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to = "Not Applicable";
        $history->change_from = $lastDocument->status;

        // Null or empty check
        if (is_null($lastDocument->oq_test_plan) || $lastDocument->oq_test_plan === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }

        $history->save();
    }



    
    if ($lastDocument->oq_protocol != $equipment->oq_protocol || !empty($request->oq_protocol_comment)) {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'OQ Protocol';
        $history->previous = $lastDocument->oq_protocol;
        $history->current = $equipment->oq_protocol;
        $history->comment = $request->oq_protocol_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to = "Not Applicable";
        $history->change_from = $lastDocument->status;

        // Null or empty check
        if (is_null($lastDocument->oq_protocol) || $lastDocument->oq_protocol === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }

        $history->save();
    }


    if ($lastDocument->oq_execution != $equipment->oq_execution || !empty($request->oq_execution_comment)) {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'OQ Execution';
        $history->previous = $lastDocument->oq_execution;
        $history->current = $equipment->oq_execution;
        $history->comment = $request->oq_execution_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to = "Not Applicable";
        $history->change_from = $lastDocument->status;

        // Null or empty check
        if (is_null($lastDocument->oq_execution) || $lastDocument->oq_execution === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }

        $history->save();
    }


    if ($lastDocument->oq_report != $equipment->oq_report || !empty($request->oq_report_comment)) {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'OQ Report';
        $history->previous = $lastDocument->oq_report;
        $history->current = $equipment->oq_report;
        $history->comment = $request->oq_report_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to = "Not Applicable";
        $history->change_from = $lastDocument->status;

        // Null or empty check
        if (is_null($lastDocument->oq_report) || $lastDocument->oq_report === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }

        $history->save();
    }

    if ($lastDocument->oq_attachment != $equipment->oq_attachment || !empty($request->oq_attachment_comment)) {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Equipment Qualification Attachment';
        $history->previous = $lastDocument->oq_attachment;
        $history->current = $equipment->oq_attachment;
        $history->comment = $request->oq_attachment_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to = "Not Applicable";
        $history->change_from = $lastDocument->status;

        // Null or empty check
        if (is_null($lastDocument->oq_attachment) || $lastDocument->oq_attachment === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }

        $history->save();
    }


    if ($lastDocument->pq_test_plan != $equipment->pq_test_plan || !empty($request->pq_test_plan_comment)) {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'PQ Test Plan';
        $history->previous = $lastDocument->pq_test_plan;
        $history->current = $equipment->pq_test_plan;
        $history->comment = $request->pq_test_plan_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to = "Not Applicable";
        $history->change_from = $lastDocument->status;

        // Null or empty check
        if (is_null($lastDocument->pq_test_plan) || $lastDocument->pq_test_plan === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }

        $history->save();
    }

    if ($lastDocument->pq_protocol != $equipment->pq_protocol || !empty($request->pq_protocol_comment)) {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'PQ Protocol';
        $history->previous = $lastDocument->pq_protocol;
        $history->current = $equipment->pq_protocol;
        $history->comment = $request->pq_protocol_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to = "Not Applicable";
        $history->change_from = $lastDocument->status;

        // Null or empty check
        if (is_null($lastDocument->pq_protocol) || $lastDocument->pq_protocol === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }

        $history->save();
    }


    if ($lastDocument->pq_execution != $equipment->pq_execution || !empty($request->pq_execution_comment)) {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'PQ Execution';
        $history->previous = $lastDocument->pq_execution;
        $history->current = $equipment->pq_execution;
        $history->comment = $request->pq_execution_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to = "Not Applicable";
        $history->change_from = $lastDocument->status;

        // Null or empty check
        if (is_null($lastDocument->pq_execution) || $lastDocument->pq_execution === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }

        $history->save();
    }


    
    if ($lastDocument->pq_report != $equipment->pq_report || !empty($request->pq_report_comment)) {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'PQ Report';
        $history->previous = $lastDocument->pq_report;
        $history->current = $equipment->pq_report;
        $history->comment = $request->pq_report_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to = "Not Applicable";
        $history->change_from = $lastDocument->status;

        // Null or empty check
        if (is_null($lastDocument->pq_report) || $lastDocument->pq_report === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }

        $history->save();
    }


    if ($lastDocument->pq_attachment != $equipment->pq_attachment || !empty($request->pq_attachment_comment)) {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Equipment Qualification Attachment';
        $history->previous = $lastDocument->pq_attachment;
        $history->current = $equipment->pq_attachment;
        $history->comment = $request->pq_attachment_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to = "Not Applicable";
        $history->change_from = $lastDocument->status;

        // Null or empty check
        if (is_null($lastDocument->pq_attachment) || $lastDocument->pq_attachment === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }

        $history->save();
    }


    if ($lastDocument->migration_details != $equipment->migration_details || !empty($request->migration_details_comment)) {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Migration Details';
        $history->previous = $lastDocument->migration_details;
        $history->current = $equipment->migration_details;
        $history->comment = $request->migration_details_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to = "Not Applicable";
        $history->change_from = $lastDocument->status;

        // Null or empty check
        if (is_null($lastDocument->migration_details) || $lastDocument->migration_details === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }

        $history->save();
    }

    if ($lastDocument->migration_attachment != $equipment->migration_attachment || !empty($request->migration_attachment_comment)) {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Migration Attachment';
        $history->previous = $lastDocument->migration_attachment;
        $history->current = $equipment->migration_attachment;
        $history->comment = $request->migration_attachment_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to = "Not Applicable";
        $history->change_from = $lastDocument->status;

        // Null or empty check
        if (is_null($lastDocument->migration_attachment) || $lastDocument->migration_attachment === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }

        $history->save();
    }


    if ($lastDocument->configuration_specification_details != $equipment->configuration_specification_details || !empty($request->configuration_specification_details_comment)) {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Configuration Specification Details';
        $history->previous = $lastDocument->configuration_specification_details;
        $history->current = $equipment->configuration_specification_details;
        $history->comment = $request->configuration_specification_details_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to = "Not Applicable";
        $history->change_from = $lastDocument->status;

        // Null or empty check
        if (is_null($lastDocument->configuration_specification_details) || $lastDocument->configuration_specification_details === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }

        $history->save();
    }


    if ($lastDocument->configuration_specification_attachment != $equipment->configuration_specification_attachment || !empty($request->configuration_specification_attachment_comment)) {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Configuration Specification Attachment';
        $history->previous = $lastDocument->configuration_specification_attachment;
        $history->current = $equipment->configuration_specification_attachment;
        $history->comment = $request->configuration_specification_attachment_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to = "Not Applicable";
        $history->change_from = $lastDocument->status;

        // Null or empty check
        if (is_null($lastDocument->configuration_specification_attachment) || $lastDocument->configuration_specification_attachment === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }

        $history->save();
    }


    if ($lastDocument->requirement_traceability_details != $equipment->requirement_traceability_details || !empty($request->requirement_traceability_details_comment)) {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Rquirement Traceability Details';
        $history->previous = $lastDocument->requirement_traceability_details;
        $history->current = $equipment->requirement_traceability_details;
        $history->comment = $request->requirement_traceability_details_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to = "Not Applicable";
        $history->change_from = $lastDocument->status;

        // Null or empty check
        if (is_null($lastDocument->requirement_traceability_details) || $lastDocument->requirement_traceability_details === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }

        $history->save();
    }


    
    if ($lastDocument->requirement_traceability_attachment != $equipment->requirement_traceability_attachment || !empty($request->requirement_traceability_attachment_comment)) {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Requirement Traceability Attachment';
        $history->previous = $lastDocument->requirement_traceability_attachment;
        $history->current = $equipment->requirement_traceability_attachment;
        $history->comment = $request->requirement_traceability_attachment_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to = "Not Applicable";
        $history->change_from = $lastDocument->status;

        // Null or empty check
        if (is_null($lastDocument->requirement_traceability_attachment) || $lastDocument->requirement_traceability_attachment === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }

        $history->save();
    }


      
    if ($lastDocument->validation_summary_report != $equipment->validation_summary_report || !empty($request->validation_summary_report_comment)) {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Validation Summary Report';
        $history->previous = $lastDocument->validation_summary_report;
        $history->current = $equipment->validation_summary_report;
        $history->comment = $request->validation_summary_report_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to = "Not Applicable";
        $history->change_from = $lastDocument->status;

        // Null or empty check
        if (is_null($lastDocument->validation_summary_report) || $lastDocument->validation_summary_report === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }

        $history->save();
    }


    if ($lastDocument->periodic_qualification_pending_on != $equipment->periodic_qualification_pending_on || !empty($request->periodic_qualification_pending_on_comment)) {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Periodic Qualification Pending On';
        $history->previous = Helpers::getdateFormat($lastDocument->periodic_qualification_pending_on);
        $history->current = Helpers::getdateFormat($equipment->periodic_qualification_pending_on);
        $history->comment = $request->periodic_qualification_pending_on_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to = "Not Applicable";
        $history->change_from = $lastDocument->status;

        // Null or empty check
        if (is_null($lastDocument->periodic_qualification_pending_on) || $lastDocument->periodic_qualification_pending_on === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }

        $history->save();
    }


    
    if ($lastDocument->periodic_qualification_notification != $equipment->periodic_qualification_notification || !empty($request->periodic_qualification_notification_comment)) {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Periodic Qualification Notification (Days)';
        $history->previous = $lastDocument->periodic_qualification_notification;
        $history->current = $equipment->periodic_qualification_notification;
        $history->comment = $request->periodic_qualification_notification_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to = "Not Applicable";
        $history->change_from = $lastDocument->status;

        // Null or empty check
        if (is_null($lastDocument->periodic_qualification_notification) || $lastDocument->periodic_qualification_notification === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }

        $history->save();
    }

    if ($lastDocument->calibration_standard_preference != $equipment->calibration_standard_preference || !empty($request->calibration_standard_preference_comment)) {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Calibration Standard Reference';
        $history->previous = $lastDocument->calibration_standard_preference;
        $history->current = $equipment->calibration_standard_preference;
        $history->comment = $request->calibration_standard_preference_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to = "Not Applicable";
        $history->change_from = $lastDocument->status;

        // Null or empty check
        if (is_null($lastDocument->calibration_standard_preference) || $lastDocument->calibration_standard_preference === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }

        $history->save();
    }

    
    if ($lastDocument->callibration_frequency != $equipment->callibration_frequency || !empty($request->callibration_frequency_comment)) {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Calibration Frequency';
        $history->previous = $lastDocument->callibration_frequency;
        $history->current = $equipment->callibration_frequency;
        $history->comment = $request->callibration_frequency_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to = "Not Applicable";
        $history->change_from = $lastDocument->status;

        // Null or empty check
        if (is_null($lastDocument->callibration_frequency) || $lastDocument->callibration_frequency === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }

        $history->save();
    }

    if ($lastDocument->last_calibration_date != $equipment->last_calibration_date || !empty($request->last_calibration_date_comment)) {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Last Calibration Date';
        $history->previous = Helpers::getdateFormat($lastDocument->last_calibration_date);
        $history->current = Helpers::getdateFormat($equipment->last_calibration_date);
        $history->comment = $request->last_calibration_date_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to = "Not Applicable";
        $history->change_from = $lastDocument->status;

        // Null or empty check
        if (is_null($lastDocument->last_calibration_date) || $lastDocument->last_calibration_date === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }

        $history->save();
    }

    if ($lastDocument->next_calibration_date != $equipment->next_calibration_date || !empty($request->next_calibration_date_comment)) {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Next Calibration Date';
        $history->previous = Helpers::getdateFormat($lastDocument->next_calibration_date);
        $history->current = Helpers::getdateFormat($equipment->next_calibration_date);
        $history->comment = $request->next_calibration_date_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to = "Not Applicable";
        $history->change_from = $lastDocument->status;

        // Null or empty check
        if (is_null($lastDocument->next_calibration_date) || $lastDocument->next_calibration_date === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }

        $history->save();
    }

    if ($lastDocument->calibration_due_reminder != $equipment->calibration_due_reminder || !empty($request->calibration_due_reminder_comment)) {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Calibration Due Reminder';
        $history->previous = $lastDocument->calibration_due_reminder;
        $history->current = $equipment->calibration_due_reminder;
        $history->comment = $request->calibration_due_reminder_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to = "Not Applicable";
        $history->change_from = $lastDocument->status;

        // Null or empty check
        if (is_null($lastDocument->calibration_due_reminder) || $lastDocument->calibration_due_reminder === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }

        $history->save();
    }

    if ($lastDocument->calibration_method_procedure != $equipment->calibration_method_procedure || !empty($request->calibration_method_procedure_comment)) {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Calibration Method/Procedure';
        $history->previous = $lastDocument->calibration_method_procedure;
        $history->current = $equipment->calibration_method_procedure;
        $history->comment = $request->calibration_method_procedure_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to = "Not Applicable";
        $history->change_from = $lastDocument->status;

        // Null or empty check
        if (is_null($lastDocument->calibration_method_procedure) || $lastDocument->calibration_method_procedure === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }

        $history->save();
    }

    
    if ($lastDocument->calibration_procedure_attach != $equipment->calibration_procedure_attach || !empty($request->calibration_procedure_attach_comment)) {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Calibration Procedure Reference/Document';
        $history->previous = $lastDocument->calibration_procedure_attach;
        $history->current = $equipment->calibration_procedure_attach;
        $history->comment = $request->calibration_procedure_attach_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to = "Not Applicable";
        $history->change_from = $lastDocument->status;

        // Null or empty check
        if (is_null($lastDocument->calibration_procedure_attach) || $lastDocument->calibration_procedure_attach === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }

        $history->save();
    }

    if ($lastDocument->calibration_used != $equipment->calibration_used || !empty($request->calibration_used_comment)) {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Calibration Standards Used';
        $history->previous = $lastDocument->calibration_used;
        $history->current = $equipment->calibration_used;
        $history->comment = $request->calibration_used_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to = "Not Applicable";
        $history->change_from = $lastDocument->status;

        // Null or empty check
        if (is_null($lastDocument->calibration_used) || $lastDocument->calibration_used === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }

        $history->save();
    }

    if ($lastDocument->calibration_parameter != $equipment->calibration_parameter || !empty($request->calibration_parameter_comment)) {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Calibration Parameters';
        $history->previous = $lastDocument->calibration_parameter;
        $history->current = $equipment->calibration_parameter;
        $history->comment = $request->calibration_parameter_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to = "Not Applicable";
        $history->change_from = $lastDocument->status;

        // Null or empty check
        if (is_null($lastDocument->calibration_parameter) || $lastDocument->calibration_parameter === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }

        $history->save();
    }

    if ($lastDocument->event_based_calibration!= $equipment->event_based_calibration || !empty($request->event_based_calibration_comment)) {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Unscheduled or Event Based Calibration?';
        $history->previous = $lastDocument->event_based_calibration;
        $history->current = $equipment->event_based_calibration;
        $history->comment = $request->event_based_calibration_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to = "Not Applicable";
        $history->change_from = $lastDocument->status;

        // Null or empty check
        if (is_null($lastDocument->event_based_calibration) || $lastDocument->event_based_calibration=== '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }

        $history->save();
    }

    if ($lastDocument->event_based_calibration_reason != $equipment->event_based_calibration_reason || !empty($request->event_based_calibration_reason_comment)) {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Reason for Unscheduled or Event Based Calibration';
        $history->previous = $lastDocument->event_based_calibration_reason;
        $history->current = $equipment->event_based_calibration_reason;
        $history->comment = $request->event_based_calibration_reason_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to = "Not Applicable";
        $history->change_from = $lastDocument->status;

        // Null or empty check
        if (is_null($lastDocument->event_based_calibration_reason) || $lastDocument->event_based_calibration_reason === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }

        $history->save();
    }


    if ($lastDocument->event_refernce_no != $equipment->event_refernce_no || !empty($request->event_refernce_no_comment)) {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Event Reference No.';
        $history->previous = $lastDocument->event_refernce_no;
        $history->current = $equipment->event_refernce_no;
        $history->comment = $request->event_refernce_no_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to = "Not Applicable";
        $history->change_from = $lastDocument->status;

        // Null or empty check
        if (is_null($lastDocument->event_refernce_no) || $lastDocument->event_refernce_no === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }

        $history->save();
    }

    if ($lastDocument->calibration_checklist != $equipment->calibration_checklist || !empty($request->calibration_checklist_comment)) {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Calibration Checklist';
        $history->previous = $lastDocument->calibration_checklist;
        $history->current = $equipment->calibration_checklist;
        $history->comment = $request->calibration_checklist_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to = "Not Applicable";
        $history->change_from = $lastDocument->status;

        // Null or empty check
        if (is_null($lastDocument->calibration_checklist) || $lastDocument->calibration_checklist === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }

        $history->save();
    }


    if ($lastDocument->calibration_result != $equipment->calibration_result || !empty($request->calibration_result_comment)) {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Calibration Results';
        $history->previous = $lastDocument->calibration_result;
        $history->current = $equipment->calibration_result;
        $history->comment = $request->calibration_result_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to = "Not Applicable";
        $history->change_from = $lastDocument->status;

        // Null or empty check
        if (is_null($lastDocument->calibration_result) || $lastDocument->calibration_result === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }

        $history->save();
    }

    
    if ($lastDocument->calibration_certificate_result != $equipment->calibration_certificate_result || !empty($request->calibration_certificate_result_comment)) {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Calibration Certificate Number';
        $history->previous = $lastDocument->calibration_certificate_result;
        $history->current = $equipment->calibration_certificate_result;
        $history->comment = $request->calibration_certificate_result_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to = "Not Applicable";
        $history->change_from = $lastDocument->status;

        // Null or empty check
        if (is_null($lastDocument->calibration_certificate_result) || $lastDocument->calibration_certificate_result === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }

        $history->save();
    }

    if ($lastDocument->calibration_certificate != $equipment->calibration_certificate || !empty($request->calibration_certificate_comment)) {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Calibration Certificate Attachment';
        $history->previous = $lastDocument->calibration_certificate;
        $history->current = $equipment->calibration_certificate;
        $history->comment = $request->calibration_certificate_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to = "Not Applicable";
        $history->change_from = $lastDocument->status;

        // Null or empty check
        if (is_null($lastDocument->calibration_certificate) || $lastDocument->calibration_certificate === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }

        $history->save();
    }

    if ($lastDocument->calibrated_by != $equipment->calibrated_by || !empty($request->calibrated_by_comment)) {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Calibrated By';
        $history->previous = $lastDocument->calibrated_by;
        $history->current = $equipment->calibrated_by;
        $history->comment = $request->calibrated_by_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to = "Not Applicable";
        $history->change_from = $lastDocument->status;

        // Null or empty check
        if (is_null($lastDocument->calibrated_by) || $lastDocument->calibrated_by === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }

        $history->save();
    }

    
    if ($lastDocument->calibration_due_alert != $equipment->calibration_due_alert || !empty($request->calibration_due_alert_comment)) {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Calibration Due Alert';
        $history->previous = $lastDocument->calibration_due_alert;
        $history->current = $equipment->calibration_due_alert;
        $history->comment = $request->calibration_due_alert_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to = "Not Applicable";
        $history->change_from = $lastDocument->status;

        // Null or empty check
        if (is_null($lastDocument->calibration_due_alert) || $lastDocument->calibration_due_alert === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }

        $history->save();
    }

    if ($lastDocument->calibration_cost != $equipment->calibration_cost || !empty($request->calibration_cost_comment)) {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Cost of Calibration';
        $history->previous = $lastDocument->calibration_cost;
        $history->current = $equipment->calibration_cost;
        $history->comment = $request->calibration_cost_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to = "Not Applicable";
        $history->change_from = $lastDocument->status;

        // Null or empty check
        if (is_null($lastDocument->calibration_cost) || $lastDocument->calibration_cost === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }

        $history->save();
    }

    if ($lastDocument->calibration_comments != $equipment->calibration_comments || !empty($request->calibration_comments_comment)) {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Calibration Comments/Observations';
        $history->previous = $lastDocument->calibration_comments;
        $history->current = $equipment->calibration_comments;
        $history->comment = $request->calibration_comments_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to = "Not Applicable";
        $history->change_from = $lastDocument->status;

        // Null or empty check
        if (is_null($lastDocument->calibration_comments) || $lastDocument->calibration_comments === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }

        $history->save();
    }

    if ($lastDocument->pm_schedule != $equipment->pm_schedule || !empty($request->pm_schedule_comment)) {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'PM Schedule';
        $history->previous = $lastDocument->pm_schedule;
        $history->current = $equipment->pm_schedule;
        $history->comment = $request->pm_schedule_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to = "Not Applicable";
        $history->change_from = $lastDocument->status;

        // Null or empty check
        if (is_null($lastDocument->pm_schedule) || $lastDocument->pm_schedule === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }

        $history->save();
    }


    if ($lastDocument->last_pm_date != $equipment->last_pm_date || !empty($request->last_pm_date_comment)) {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Last Preventive Maintenance Date';
        $history->previous = Helpers::getdateFormat($lastDocument->last_pm_date);
        $history->current = Helpers::getdateFormat($equipment->last_pm_date);
        $history->comment = $request->last_pm_date_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to = "Not Applicable";
        $history->change_from = $lastDocument->status;

        // Null or empty check
        if (is_null($lastDocument->last_pm_date) || $lastDocument->last_pm_date === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }

        $history->save();
    }


    if ($lastDocument->next_pm_date != $equipment->next_pm_date || !empty($request->next_pm_date_comment)) {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Next Preventive Maintenance Date';
        $history->previous = Helpers::getdateFormat($lastDocument->next_pm_date);
        $history->current = Helpers::getdateFormat($equipment->next_pm_date);
        $history->comment = $request->next_pm_date_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to = "Not Applicable";
        $history->change_from = $lastDocument->status;

        // Null or empty check
        if (is_null($lastDocument->next_pm_date) || $lastDocument->next_pm_date === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }

        $history->save();
    }

    if ($lastDocument->pm_task_description != $equipment->pm_task_description || !empty($request->pm_task_description_comment)) {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'PM Task Description';
        $history->previous = $lastDocument->pm_task_description;
        $history->current = $equipment->pm_task_description;
        $history->comment = $request->pm_task_description_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to = "Not Applicable";
        $history->change_from = $lastDocument->status;

        // Null or empty check
        if (is_null($lastDocument->pm_task_description) || $lastDocument->pm_task_description === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }

        $history->save();
    }


    if ($lastDocument->event_based_PM != $equipment->event_based_PM || !empty($request->event_based_PM_comment)) {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Unscheduled or Event Based Preventive Maintenance?';
        $history->previous = $lastDocument->event_based_PM;
        $history->current = $equipment->event_based_PM;
        $history->comment = $request->event_based_PM_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to = "Not Applicable";
        $history->change_from = $lastDocument->status;

        // Null or empty check
        if (is_null($lastDocument->event_based_PM) || $lastDocument->event_based_PM === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }

        $history->save();
    }


    if ($lastDocument->eventbased_pm_reason != $equipment->eventbased_pm_reason || !empty($request->eventbased_pm_reason_comment)) {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Reason for Unscheduled or Event Based Preventive Maintenance';
        $history->previous = $lastDocument->eventbased_pm_reason;
        $history->current = $equipment->eventbased_pm_reason;
        $history->comment = $request->eventbased_pm_reason_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to = "Not Applicable";
        $history->change_from = $lastDocument->status;

        // Null or empty check
        if (is_null($lastDocument->eventbased_pm_reason) || $lastDocument->eventbased_pm_reason === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }

        $history->save();
    }


    if ($lastDocument->PMevent_refernce_no != $equipment->PMevent_refernce_no || !empty($request->PMevent_refernce_no_comment)) {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Event Reference No.';
        $history->previous = $lastDocument->PMevent_refernce_no;
        $history->current = $equipment->PMevent_refernce_no;
        $history->comment = $request->PMevent_refernce_no_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to = "Not Applicable";
        $history->change_from = $lastDocument->status;

        // Null or empty check
        if (is_null($lastDocument->PMevent_refernce_no) || $lastDocument->PMevent_refernce_no === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }

        $history->save();
    }



    
    if ($lastDocument->pm_procedure_document != $equipment->pm_procedure_document || !empty($request->pm_procedure_document_comment)) {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'PM Procedure Reference/Document';
        $history->previous = $lastDocument->pm_procedure_document;
        $history->current = $equipment->pm_procedure_document;
        $history->comment = $request->pm_procedure_document_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to = "Not Applicable";
        $history->change_from = $lastDocument->status;

        // Null or empty check
        if (is_null($lastDocument->pm_procedure_document) || $lastDocument->pm_procedure_document === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }

        $history->save();
    }


    
    if ($lastDocument->pm_performed_by != $equipment->pm_performed_by || !empty($request->pm_performed_by_comment)) {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Performed By';
        $history->previous = $lastDocument->pm_performed_by;
        $history->current = $equipment->pm_performed_by;
        $history->comment = $request->pm_performed_by_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to = "Not Applicable";
        $history->change_from = $lastDocument->status;

        // Null or empty check
        if (is_null($lastDocument->pm_performed_by) || $lastDocument->pm_performed_by === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }

        $history->save();
    }


    if ($lastDocument->maintenance_observation != $equipment->maintenance_observation || !empty($request->maintenance_observation_comment)) {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Maintenance Comments/Observations';
        $history->previous = $lastDocument->maintenance_observation;
        $history->current = $equipment->maintenance_observation;
        $history->comment = $request->maintenance_observation_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to = "Not Applicable";
        $history->change_from = $lastDocument->status;

        // Null or empty check
        if (is_null($lastDocument->maintenance_observation) || $lastDocument->maintenance_observation === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }

        $history->save();
    }

    
    if ($lastDocument->replaced_parts != $equipment->replaced_parts || !empty($request->replaced_parts_comment)) {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Parts Replaced During Maintenance';
        $history->previous = $lastDocument->replaced_parts;
        $history->current = $equipment->replaced_parts;
        $history->comment = $request->replaced_parts_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to = "Not Applicable";
        $history->change_from = $lastDocument->status;

        // Null or empty check
        if (is_null($lastDocument->replaced_parts) || $lastDocument->replaced_parts === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }

        $history->save();
    }


    if ($lastDocument->work_order_number != $equipment->work_order_number || !empty($request->work_order_number_comment)) {
        $history = new EquipmentInfoAuditTrail();
        $history->equipmentInfo_id = $equipment->id;
        $history->activity_type = 'Maintenance Work Order Number';
        $history->previous = $lastDocument->work_order_number;
        $history->current = $equipment->work_order_number;
        $history->comment = $request->work_order_number_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to = "Not Applicable";
        $history->change_from = $lastDocument->status;

        // Null or empty check
        if (is_null($lastDocument->work_order_number) || $lastDocument->work_order_number === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }

        $history->save();
    }

        if ($lastDocument->pm_checklist != $equipment->pm_checklist || !empty($request->pm_checklist_comment)) {
            $history = new EquipmentInfoAuditTrail();
            $history->equipmentInfo_id = $equipment->id;
            $history->activity_type = 'PM Checklist';
            $history->previous = $lastDocument->pm_checklist;
            $history->current = $equipment->pm_checklist;
            $history->comment = $request->pm_checklist_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
    
            // Null or empty check
            if (is_null($lastDocument->pm_checklist) || $lastDocument->pm_checklist === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
    
            $history->save();
        }


            if ($lastDocument->emergency_flag_maintenance != $equipment->emergency_flag_maintenance || !empty($request->emergency_flag_maintenance_comment)) {
                $history = new EquipmentInfoAuditTrail();
                $history->equipmentInfo_id = $equipment->id;
                $history->activity_type = 'Emergency Maintenance Flag';
                $history->previous = $lastDocument->emergency_flag_maintenance;
                $history->current = $equipment->emergency_flag_maintenance;
                $history->comment = $request->emergency_flag_maintenance_comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to = "Not Applicable";
                $history->change_from = $lastDocument->status;
        
                // Null or empty check
                if (is_null($lastDocument->emergency_flag_maintenance) || $lastDocument->emergency_flag_maintenance === '') {
                    $history->action_name = "New";
                } else {
                    $history->action_name = "Update";
                }
        
                $history->save();

            }


                if ($lastDocument->cost_of_maintenance != $equipment->cost_of_maintenance || !empty($request->cost_of_maintenance_comment)) {
                    $history = new EquipmentInfoAuditTrail();
                    $history->equipmentInfo_id = $equipment->id;
                    $history->activity_type = 'Cost of Maintenance';
                    $history->previous = $lastDocument->cost_of_maintenance;
                    $history->current = $equipment->cost_of_maintenance;
                    $history->comment = $request->cost_of_maintenance_comment;
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $lastDocument->status;
                    $history->change_to = "Not Applicable";
                    $history->change_from = $lastDocument->status;
            
                    // Null or empty check
                    if (is_null($lastDocument->cost_of_maintenance) || $lastDocument->cost_of_maintenance === '') {
                        $history->action_name = "New";
                    } else {
                        $history->action_name = "Update";
                    }
            
                    $history->save();
                }


                if ($lastDocument->training_required != $equipment->training_required || !empty($request->training_required_comment)) {
                    $history = new EquipmentInfoAuditTrail();
                    $history->equipmentInfo_id = $equipment->id;
                    $history->activity_type = 'Training Required?';
                    $history->previous = $lastDocument->training_required;
                    $history->current = $equipment->training_required;
                    $history->comment = $request->training_required_comment;
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $lastDocument->status;
                    $history->change_to = "Not Applicable";
                    $history->change_from = $lastDocument->status;
            
                    // Null or empty check
                    if (is_null($lastDocument->training_required) || $lastDocument->training_required === '') {
                        $history->action_name = "New";
                    } else {
                        $history->action_name = "Update";
                    }
            
                    $history->save();
                }
            
                
                if ($lastDocument->trining_description != $equipment->trining_description || !empty($request->trining_description_comment)) {
                    $history = new EquipmentInfoAuditTrail();
                    $history->equipmentInfo_id = $equipment->id;
                    $history->activity_type = 'Training Description';
                    $history->previous = $lastDocument->trining_description;
                    $history->current = $equipment->trining_description;
                    $history->comment = $request->trining_description_comment;
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $lastDocument->status;
                    $history->change_to = "Not Applicable";
                    $history->change_from = $lastDocument->status;
            
                    // Null or empty check
                    if (is_null($lastDocument->trining_description) || $lastDocument->trining_description === '') {
                        $history->action_name = "New";
                    } else {
                        $history->action_name = "Update";
                    }
            
                    $history->save();
                }
            
                if ($lastDocument->training_type != $equipment->training_type || !empty($request->training_type_comment)) {
                    $history = new EquipmentInfoAuditTrail();
                    $history->equipmentInfo_id = $equipment->id;
                    $history->activity_type = 'Training Type';
                    $history->previous = $lastDocument->training_type;
                    $history->current = $equipment->training_type;
                    $history->comment = $request->training_type_comment;
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $lastDocument->status;
                    $history->change_to = "Not Applicable";
                    $history->change_from = $lastDocument->status;
            
                    // Null or empty check
                    if (is_null($lastDocument->training_type) || $lastDocument->training_type === '') {
                        $history->action_name = "New";
                    } else {
                        $history->action_name = "Update";
                    }
            
                    $history->save();
                }
            
                if ($lastDocument->training_attachment != $equipment->training_attachment || !empty($request->training_attachment_comment)) {
                    $history = new EquipmentInfoAuditTrail();
                    $history->equipmentInfo_id = $equipment->id;
                    $history->activity_type = 'Training Attachment';
                    $history->previous = $lastDocument->training_attachment;
                    $history->current = $equipment->training_attachment;
                    $history->comment = $request->training_attachment_comment;
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $lastDocument->status;
                    $history->change_to = "Not Applicable";
                    $history->change_from = $lastDocument->status;
            
                    // Null or empty check
                    if (is_null($lastDocument->training_attachment) || $lastDocument->training_attachment === '') {
                        $history->action_name = "New";
                    } else {
                        $history->action_name = "Update";
                    }
            
                    $history->save();
                }

                if ($lastDocument->supervisor_comment != $equipment->supervisor_comment || !empty($request->supervisor_comment_comment)) {
                    $history = new EquipmentInfoAuditTrail();
                    $history->equipmentInfo_id = $equipment->id;
                    $history->activity_type = 'Supervisor Review Comments';
                    $history->previous = $lastDocument->supervisor_comment;
                    $history->current = $equipment->supervisor_comment;
                    $history->comment = $request->supervisor_comment_comment;
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $lastDocument->status;
                    $history->change_to = "Not Applicable";
                    $history->change_from = $lastDocument->status;
            
                    // Null or empty check
                    if (is_null($lastDocument->supervisor_comment) || $lastDocument->supervisor_comment === '') {
                        $history->action_name = "New";
                    } else {
                        $history->action_name = "Update";
                    }
            
                    $history->save();
                }
            
                
                if ($lastDocument->Supervisor_document != $equipment->Supervisor_document || !empty($request->Supervisor_document_comment)) {
                    $history = new EquipmentInfoAuditTrail();
                    $history->equipmentInfo_id = $equipment->id;
                    $history->activity_type = 'Supervisor Documents';
                    $history->previous = $lastDocument->Supervisor_document;
                    $history->current = $equipment->Supervisor_document;
                    $history->comment = $request->Supervisor_document_comment;
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $lastDocument->status;
                    $history->change_to = "Not Applicable";
                    $history->change_from = $lastDocument->status;
            
                    // Null or empty check
                    if (is_null($lastDocument->Supervisor_document) || $lastDocument->Supervisor_document === '') {
                        $history->action_name = "New";
                    } else {
                        $history->action_name = "Update";
                    }
            
                    $history->save();
                }

                if ($lastDocument->QA_comment != $equipment->QA_comment || !empty($request->QA_comment_comment)) {
                    $history = new EquipmentInfoAuditTrail();
                    $history->equipmentInfo_id = $equipment->id;
                    $history->activity_type = 'QA Review Comments';
                    $history->previous = $lastDocument->QA_comment;
                    $history->current = $equipment->QA_comment;
                    $history->comment = $request->QA_comment_comment;
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $lastDocument->status;
                    $history->change_to = "Not Applicable";
                    $history->change_from = $lastDocument->status;
            
                    // Null or empty check
                    if (is_null($lastDocument->QA_comment) || $lastDocument->QA_comment === '') {
                        $history->action_name = "New";
                    } else {
                        $history->action_name = "Update";
                    }
            
                    $history->save();
                }
            
                
                if ($lastDocument->QA_document != $equipment->QA_document || !empty($request->QA_document_comment)) {
                    $history = new EquipmentInfoAuditTrail();
                    $history->equipmentInfo_id = $equipment->id;
                    $history->activity_type = 'QA Documents';
                    $history->previous = $lastDocument->QA_document;
                    $history->current = $equipment->QA_document;
                    $history->comment = $request->QA_document_comment;
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $lastDocument->status;
                    $history->change_to = "Not Applicable";
                    $history->change_from = $lastDocument->status;
            
                    // Null or empty check
                    if (is_null($lastDocument->QA_document) || $lastDocument->QA_document === '') {
                        $history->action_name = "New";
                    } else {
                        $history->action_name = "Update";
                    }
            
                    $history->save();
                }


                if ($lastDocument->Equipment_Lifecycle_Stage != $equipment->Equipment_Lifecycle_Stage || !empty($request->Equipment_Lifecycle_Stage_comment)) {
                    $history = new EquipmentInfoAuditTrail();
                    $history->equipmentInfo_id = $equipment->id;
                    $history->activity_type = 'Equipment Lifecycle Stage';
                    $history->previous = $lastDocument->Equipment_Lifecycle_Stage;
                    $history->current = $equipment->Equipment_Lifecycle_Stage;
                    $history->comment = $request->Equipment_Lifecycle_Stage_comment;
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $lastDocument->status;
                    $history->change_to = "Not Applicable";
                    $history->change_from = $lastDocument->status;
            
                    // Null or empty check
                    if (is_null($lastDocument->Equipment_Lifecycle_Stage) || $lastDocument->Equipment_Lifecycle_Stage === '') {
                        $history->action_name = "New";
                    } else {
                        $history->action_name = "Update";
                    }
            
                    $history->save();
            
                }
                      
                if ($lastDocument->Expected_Useful_Life != $equipment->Expected_Useful_Life || !empty($request->Expected_Useful_Life_comment)) {
                    $history = new EquipmentInfoAuditTrail();
                    $history->equipmentInfo_id = $equipment->id;
                    $history->activity_type = 'Expected Useful Life';
                    $history->previous = $lastDocument->Expected_Useful_Life;
                    $history->current = $equipment->Expected_Useful_Life;
                    $history->comment = $request->Expected_Useful_Life_comment;
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $lastDocument->status;
                    $history->change_to = "Not Applicable";
                    $history->change_from = $lastDocument->status;
            
                    // Null or empty check
                    if (is_null($lastDocument->Expected_Useful_Life) || $lastDocument->Expected_Useful_Life === '') {
                        $history->action_name = "New";
                    } else {
                        $history->action_name = "Update";
                    }
            
                    $history->save();
            
            
                }
                            
                if ($lastDocument->End_of_life_Date != $equipment->End_of_life_Date || !empty($request->End_of_life_Date_comment)) {
                    $history = new EquipmentInfoAuditTrail();
                    $history->equipmentInfo_id = $equipment->id;
                    $history->activity_type = 'End-of-life Date';
                    $history->previous = Helpers::getDateFormat($lastDocument->End_of_life_Date);
                    $history->current = Helpers::getDateFormat($equipment->End_of_life_Date);
                    $history->comment = $request->End_of_life_Date_comment;
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $lastDocument->status;
                    $history->change_to = "Not Applicable";
                    $history->change_from = $lastDocument->status;
            
                    // Null or empty check
                    if (is_null($lastDocument->End_of_life_Date) || $lastDocument->End_of_life_Date === '') {
                        $history->action_name = "New";
                    } else {
                        $history->action_name = "Update";
                    }
            
                    $history->save();
            
                }
            
            
                    if ($lastDocument->Decommissioning_and_Disposal_Records != $equipment->Decommissioning_and_Disposal_Records || !empty($request->Decommissioning_and_Disposal_Records_comment)) {
                        $history = new EquipmentInfoAuditTrail();
                        $history->equipmentInfo_id = $equipment->id;
                        $history->activity_type = 'Decommissioning and Disposal Records';
                        $history->previous = $lastDocument->Decommissioning_and_Disposal_Records;
                        $history->current = $equipment->Decommissioning_and_Disposal_Records;
                        $history->comment = $request->Decommissioning_and_Disposal_Records_comment;
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->origin_state = $lastDocument->status;
                        $history->change_to = "Not Applicable";
                        $history->change_from = $lastDocument->status;
                
                        // Null or empty check
                        if (is_null($lastDocument->Decommissioning_and_Disposal_Records) || $lastDocument->Decommissioning_and_Disposal_Records === '') {
                            $history->action_name = "New";
                        } else {
                            $history->action_name = "Update";
                        }
                
                        $history->save();
            
                    }
            
            
                        if ($lastDocument->Replacement_History != $equipment->Replacement_History || !empty($request->Replacement_History_comment)) {
                            $history = new EquipmentInfoAuditTrail();
                            $history->equipmentInfo_id = $equipment->id;
                            $history->activity_type = 'Replacement History';
                            $history->previous = $lastDocument->Replacement_History;
                            $history->current = $equipment->Replacement_History;
                            $history->comment = $request->Replacement_History_comment;
                            $history->user_id = Auth::user()->id;
                            $history->user_name = Auth::user()->name;
                            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                            $history->origin_state = $lastDocument->status;
                            $history->change_to = "Not Applicable";
                            $history->change_from = $lastDocument->status;
                    
                            // Null or empty check
                            if (is_null($lastDocument->Replacement_History) || $lastDocument->Replacement_History === '') {
                                $history->action_name = "New";
                            } else {
                                $history->action_name = "Update";
                            }
                    
                            $history->save();
            
                        }



    

    //----------------------------------------------------------------

    toastr()->success("Record is Update Successfully");
    return back(); 
}

public function EquipmentStateChange(Request $request, $id)
    {
        if ($request->username == Auth::user()->Username && Hash::check($request->password, Auth::user()->password)) {
            $equipment = EquipmentLifecycleManagement::find($id);
            $lastDocument =  EquipmentLifecycleManagement::find($id);

            if ($equipment->stage == 1) {
                $equipment->stage = "2";
                $equipment->status = 'Supervisor Review';
                $equipment->submit_by = Auth::user()->name;
                $equipment->submit_on = Carbon::now('Asia/Kolkata')->setTimezone('UTC')->format('Y-m-d H:i:s');
                $equipment->submit_comments = $request->comment;

                $history = new EquipmentInfoAuditTrail();
                $history->equipmentInfo_id = $equipment->id;
                $history->activity_type = 'Submit By,Submit On';
                $history->action = 'Submit';
                $history->comment = $equipment->submit_comments;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;

                $history->change_to = "Supervisor Review";
                $history->change_from = $lastDocument->status;
                $history->stage = 'Supervisor Review';
                if (is_null($lastDocument->submit_by) || $lastDocument->submit_by === '') {
                    $history->previous = "";
                } else {
                    $history->previous = $lastDocument->submit_by . ' , ' . $lastDocument->submit_on;
                }
                $history->current = $equipment->submit_by . ' , ' . $equipment->submit_on;
                if (is_null($lastDocument->submit_by) || $lastDocument->submit_by === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->save();

                 /**** Notification User ****/
                 $list = Helpers::getQAHeadUserList($equipment->division_id);
                 $userIds = collect($list)->pluck('user_id')->toArray();
                 $users = User::whereIn('id', $userIds)->select('id', 'name', 'email')->get();
                 $userIds = $users->pluck('id');

                 if(!empty($users)){
                    try {
                        $history = new EquipmentInfoAuditTrail();
                        $history->equipmentInfo_id = $id;
                        $history->activity_type = "Not Applicable";
                        $history->previous = "Not Applicable";
                        $history->current = "Not Applicable";
                        $history->action = 'Notification';
                        $history->comment = "";
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->origin_state = "Not Applicable";
                        $history->change_to = "Not Applicable";
                        $history->change_from = "Supervisor Review";
                        $history->stage = "";
                        $history->action_name = "";
                        $history->mailUserId = $userIds;
                        $history->role_name = "Initiator";
                        $history->save();
                    } catch (\Throwable $e) {
                        \Log::error('Mail failed to send: ' . $e->getMessage());
                    }
                }


                 foreach ($users as $userValue) {
                     DB::table('notifications')->insert([
                         'activity_id' => $equipment->id,
                         'activity_type' => "Notification",
                         'from_id' => Auth::user()->id,
                         'user_name' => $userValue->name,
                         'to_id' => $userValue->id,
                         'process_name' => "Equipment/Instrument Lifecycle Management",
                         'division_id' => $equipment->division_id,
                         'short_description' => $equipment->short_description,
                         'initiator_id' => $equipment->initiator_id,
                         'due_date' => $equipment->due_date,
                         'record' => $equipment->record,
                         'site' => "Equipment/Instrument Lifecycle Management",
                         'comment' => $request->comments,
                         'status' => $equipment->status,
                         'stage' => $equipment->stage,
                         'created_at' => Carbon::now(),
                     ]);
                 }

                //  foreach ($list as $u) {
                //      $email = Helpers::getUserEmail($u->user_id);
                //          if ($email !== null) {
                //          try {
                //              Mail::send(
                //                  'mail.view-mail',
                //                  ['data' => $equipment, 'site' => "Equipment/Instrument Lifecycle Management", 'history' => "Submit", 'process' => 'Equipment/Instrument Lifecycle Management', 'comment' => $request->comments, 'user' => Auth::user()->name],
                //                  function ($message) use ($email, $equipment) {
                //                      $message->to($email)
                //                      ->subject("Medicef Notification: equipment, Record #" . str_pad($equipment->record, 4, '0', STR_PAD_LEFT) . " - Activity: Submit Performed");
                //                  }
                //              );

                           
                //          } catch(\Exception $e) {
                //              info('Error sending mail', [$e]);
                //          }
                //      }
                //  }




                $equipment->update();
                toastr()->success('Document Sent');
                return back();
            }

            if ($equipment->stage == 2) {
                $equipment->stage = "3";
                $equipment->status = 'Pending Qualification';
                $equipment->Supervisor_Approval_by  = Auth::user()->name;
                $equipment->Supervisor_Approval_on = Carbon::now('Asia/Kolkata')->setTimezone('UTC')->format('Y-m-d H:i:s');
                $equipment->Supervisor_Approval_comment = $request->comment;


                $history = new EquipmentInfoAuditTrail();
                $history->equipmentInfo_id = $equipment->id;
                $history->activity_type = 'Supervisor Approval By,Supervisor Approval On';
                $history->action = 'Supervisor Approval';
                $history->comment = $equipment->Supervisor_Approval_comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;

                $history->change_to = "Pending Qualification";
                $history->change_from = $lastDocument->status;
                $history->stage = 'Pending Qualification';
                if (is_null($lastDocument->Supervisor_Approval_by) || $lastDocument->Supervisor_Approval_by === '') {
                    $history->previous = "";
                } else {
                    $history->previous = $lastDocument->Supervisor_Approval_by . ' , ' . $lastDocument->Supervisor_Approval_on;
                }
                $history->current = $equipment->Supervisor_Approval_by . ' , ' . $equipment->Supervisor_Approval_on;
                if (is_null($lastDocument->Supervisor_Approval_by) || $lastDocument->Supervisor_Approval_by === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->save();



                /**** Notification User ****/
                $list = Helpers::getQAHeadUserList($equipment->division_id);
                $userIds = collect($list)->pluck('user_id')->toArray();
                $users = User::whereIn('id', $userIds)->select('id', 'name', 'email')->get();
                $userIds = $users->pluck('id');

                if(!empty($users)){
                   try {
                       $history = new EquipmentInfoAuditTrail();
                       $history->equipmentInfo_id = $id;
                       $history->activity_type = "Not Applicable";
                       $history->previous = "Not Applicable";
                       $history->current = "Not Applicable";
                       $history->action = 'Notification';
                       $history->comment = "";
                       $history->user_id = Auth::user()->id;
                       $history->user_name = Auth::user()->name;
                       $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                       $history->origin_state = "Not Applicable";
                       $history->change_to = "Not Applicable";
                       $history->change_from = "Pending Qualification";
                       $history->stage = "";
                       $history->action_name = "";
                       $history->mailUserId = $userIds;
                       $history->role_name = "Supervisor";
                       $history->save();
                   } catch (\Throwable $e) {
                       \Log::error('Mail failed to send: ' . $e->getMessage());
                   }
               }


                foreach ($users as $userValue) {
                    DB::table('notifications')->insert([
                        'activity_id' => $equipment->id,
                        'activity_type' => "Notification",
                        'from_id' => Auth::user()->id,
                        'user_name' => $userValue->name,
                        'to_id' => $userValue->id,
                        'process_name' => "Equipment/Instrument Lifecycle Management",
                        'division_id' => $equipment->division_id,
                        'short_description' => $equipment->short_description,
                        'initiator_id' => $equipment->initiator_id,
                        'due_date' => $equipment->due_date,
                        'record' => $equipment->record,
                        'site' => "Equipment/Instrument Lifecycle Management",
                        'comment' => $request->comments,
                        'status' => $equipment->status,
                        'stage' => $equipment->stage,
                        'created_at' => Carbon::now(),
                    ]);
                }

                // foreach ($list as $u) {
                //     $email = Helpers::getUserEmail($u->user_id);
                //         if ($email !== null) {
                //         try {
                //             Mail::send(
                //                 'mail.view-mail',
                //                 ['data' => $equipment, 'site' => "Equipment/Instrument Lifecycle Management", 'history' => "Supervisor Approva", 'process' => 'Equipment/Instrument Lifecycle Management', 'comment' => $request->comments, 'user' => Auth::user()->name],
                //                 function ($message) use ($email, $equipment) {
                //                     $message->to($email)
                //                     ->subject("Medicef Notification: equipment, Record #" . str_pad($equipment->record, 4, '0', STR_PAD_LEFT) . " - Activity: Supervisor Approva Performed");
                //                 }
                //             );

                          
                //         } catch(\Exception $e) {
                //             info('Error sending mail', [$e]);
                //         }
                //     }
                // }


                $equipment->update();
                toastr()->success('Document Sent');
                return back();
            }

            if ($equipment->stage == 3) {
                $equipment->stage = "4";
                $equipment->status = 'Pending Training';
                $equipment->Complete_Qualification_by  = Auth::user()->name;
                $equipment->Complete_Qualification_on = Carbon::now('Asia/Kolkata')->setTimezone('UTC')->format('Y-m-d H:i:s');
                $equipment->Complete_Qualification_comment = $request->comment;


                $history = new EquipmentInfoAuditTrail();
                $history->equipmentInfo_id = $equipment->id;
                $history->activity_type = 'Complete Qualification By,Complete Qualification On';
                $history->action = 'Complete Qualification';
                $history->comment = $equipment->Complete_Qualification_comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;

                $history->change_to = "Pending Training";
                $history->change_from = $lastDocument->status;
                $history->stage = 'Pending Training';
                if (is_null($lastDocument->Complete_Qualification_by) || $lastDocument->Complete_Qualification_by === '') {
                    $history->previous = "";
                } else {
                    $history->previous = $lastDocument->Complete_Qualification_by . ' , ' . $lastDocument->Complete_Qualification_on;
                }
                $history->current = $equipment->Complete_Qualification_by . ' , ' . $equipment->Complete_Qualification_on;
                if (is_null($lastDocument->Complete_Qualification_by) || $lastDocument->Complete_Qualification_by === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->save();


                 /**** Notification User ****/
                 $list = Helpers::getQAHeadUserList($equipment->division_id);
                 $userIds = collect($list)->pluck('user_id')->toArray();
                 $users = User::whereIn('id', $userIds)->select('id', 'name', 'email')->get();
                 $userIds = $users->pluck('id');
 
                 if(!empty($users)){
                    try {
                        $history = new EquipmentInfoAuditTrail();
                        $history->equipmentInfo_id = $id;
                        $history->activity_type = "Not Applicable";
                        $history->previous = "Not Applicable";
                        $history->current = "Not Applicable";
                        $history->action = 'Notification';
                        $history->comment = "";
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->origin_state = "Not Applicable";
                        $history->change_to = "Not Applicable";
                        $history->change_from = "Pending Training";
                        $history->stage = "";
                        $history->action_name = "";
                        $history->mailUserId = $userIds;
                        $history->role_name = "Qualification";
                        $history->save();
                    } catch (\Throwable $e) {
                        \Log::error('Mail failed to send: ' . $e->getMessage());
                    }
                }
 
 
                 foreach ($users as $userValue) {
                     DB::table('notifications')->insert([
                         'activity_id' => $equipment->id,
                         'activity_type' => "Notification",
                         'from_id' => Auth::user()->id,
                         'user_name' => $userValue->name,
                         'to_id' => $userValue->id,
                         'process_name' => "Equipment/Instrument Lifecycle Management",
                         'division_id' => $equipment->division_id,
                         'short_description' => $equipment->short_description,
                         'initiator_id' => $equipment->initiator_id,
                         'due_date' => $equipment->due_date,
                         'record' => $equipment->record,
                         'site' => "Equipment/Instrument Lifecycle Management",
                         'comment' => $request->comments,
                         'status' => $equipment->status,
                         'stage' => $equipment->stage,
                         'created_at' => Carbon::now(),
                     ]);
                 }
 
                //  foreach ($list as $u) {
                //      $email = Helpers::getUserEmail($u->user_id);
                //          if ($email !== null) {
                //          try {
                //              Mail::send(
                //                  'mail.view-mail',
                //                  ['data' => $equipment, 'site' => "Equipment/Instrument Lifecycle Management", 'history' => "Complete Qualification", 'process' => 'Equipment/Instrument Lifecycle Management', 'comment' => $request->comments, 'user' => Auth::user()->name],
                //                  function ($message) use ($email, $equipment) {
                //                      $message->to($email)
                //                      ->subject("Medicef Notification: equipment, Record #" . str_pad($equipment->record, 4, '0', STR_PAD_LEFT) . " - Activity: Complete Qualification Performed");
                //                  }
                //              );
 
                           
                //          } catch(\Exception $e) {
                //              info('Error sending mail', [$e]);
                //          }
                //      }
                //  }





                $equipment->update();
                toastr()->success('Document Sent');
                return back();
            }

            if ($equipment->stage == 4) {
                if (is_null($equipment->training_required))
                {
                    Session::flash('swal', [
                        'type' => 'warning',
                        'title' => 'Mandatory Fields!',
                        'message' => 'Training Required tab is yet to be filled'
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
                $getTrainingData = TrainingDetailsGrid::where(['equipmentInfo_id' => $id, 'identifier' => "TrainingPlan"])->first();
                $trainingPlanData = $getTrainingData ? (is_array($getTrainingData->data) ? $getTrainingData->data : json_decode($getTrainingData->data, true)) : [];

                if(!empty($trainingPlanData)){
                    foreach ($trainingPlanData as $data) {

                        $dddd = EquipmentLifecycleManagementTrainingData::create([
                            'equipmentInfo_id' => $id,
                            'trainingTopic' => $data['trainingTopic'],
                            'documentNumber' => $data['documentNumber'],
                            'documentName' => $data['documentName'],
                            'sopType' => $data['sopType'],
                            'trainingType' => $data['trainingType'],
                            'trainees' => $data['trainees'],
                            'startDate' => $data['startDate'],
                            'endDate' => $data['endDate'],
                            'trainer' => $data['trainer'],
                            'trainingAttempt' => $data['trainingAttempt'],
                            'per_screen_run_time' => $data['per_screen_run_time'],
                            'total_minimum_time' => $data['total_minimum_time'],
                        ]);
                    }
                }
                $equipment->stage = "5";
                $equipment->status = 'Training Evalution';
                $equipment->Training_required_by  = Auth::user()->name;
                $equipment->Training_required_on = Carbon::now('Asia/Kolkata')->setTimezone('UTC')->format('Y-m-d H:i:s');
                $equipment->Training_required_comment = $request->comment;


                $history = new EquipmentInfoAuditTrail();
                $history->equipmentInfo_id = $equipment->id;
                $history->activity_type = 'Start Training By,Start Training On';
                $history->action = 'Start Training';
                $history->comment = $equipment->Training_required_comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;

                $history->change_to = "Training Evalution";
                $history->change_from = $lastDocument->status;
                $history->stage = 'Training Evalution';
                if (is_null($lastDocument->Training_required_by) || $lastDocument->Training_required_by === '') {
                    $history->previous = "";
                } else {
                    $history->previous = $lastDocument->Training_required_by . ' , ' . $lastDocument->Training_required_on;
                }
                $history->current = $equipment->Training_required_by . ' , ' . $equipment->Training_required_on;
                if (is_null($lastDocument->Training_required_by) || $lastDocument->Training_required_by === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->save();


                /**** Notification User ****/
                $list = Helpers::getQAHeadUserList($equipment->division_id);
                $userIds = collect($list)->pluck('user_id')->toArray();
                $users = User::whereIn('id', $userIds)->select('id', 'name', 'email')->get();
                $userIds = $users->pluck('id');

                if(!empty($users)){
                   try {
                       $history = new EquipmentInfoAuditTrail();
                       $history->equipmentInfo_id = $id;
                       $history->activity_type = "Not Applicable";
                       $history->previous = "Not Applicable";
                       $history->current = "Not Applicable";
                       $history->action = 'Notification';
                       $history->comment = "";
                       $history->user_id = Auth::user()->id;
                       $history->user_name = Auth::user()->name;
                       $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                       $history->origin_state = "Not Applicable";
                       $history->change_to = "Not Applicable";
                       $history->change_from = "Training Evalution";
                       $history->stage = "";
                       $history->action_name = "";
                       $history->mailUserId = $userIds;
                       $history->role_name = "Training Co-ordinator";
                       $history->save();
                   } catch (\Throwable $e) {
                       \Log::error('Mail failed to send: ' . $e->getMessage());
                   }
               }


                foreach ($users as $userValue) {
                    DB::table('notifications')->insert([
                        'activity_id' => $equipment->id,
                        'activity_type' => "Notification",
                        'from_id' => Auth::user()->id,
                        'user_name' => $userValue->name,
                        'to_id' => $userValue->id,
                        'process_name' => "Equipment/Instrument Lifecycle Management",
                        'division_id' => $equipment->division_id,
                        'short_description' => $equipment->short_description,
                        'initiator_id' => $equipment->initiator_id,
                        'due_date' => $equipment->due_date,
                        'record' => $equipment->record,
                        'site' => "Equipment/Instrument Lifecycle Management",
                        'comment' => $request->comments,
                        'status' => $equipment->status,
                        'stage' => $equipment->stage,
                        'created_at' => Carbon::now(),
                    ]);
                }

                // foreach ($list as $u) {
                //     $email = Helpers::getUserEmail($u->user_id);
                //         if ($email !== null) {
                //         try {
                //             Mail::send(
                //                 'mail.view-mail',
                //                 ['data' => $equipment, 'site' => "Equipment/Instrument Lifecycle Management", 'history' => "Complete Training", 'process' => 'Equipment/Instrument Lifecycle Management', 'comment' => $request->comments, 'user' => Auth::user()->name],
                //                 function ($message) use ($email, $equipment) {
                //                     $message->to($email)
                //                     ->subject("Medicef Notification: equipment, Record #" . str_pad($equipment->record, 4, '0', STR_PAD_LEFT) . " - Activity: Complete Training Performed");
                //                 }
                //             );

                          
                //         } catch(\Exception $e) {
                //             info('Error sending mail', [$e]);
                //         }
                //     }
                // }


                $equipment->update();
                toastr()->success('Document Sent');
                return back();
            }

            

            if ($equipment->stage == 6) {
                $equipment->stage = "7";
                $equipment->status = 'Active Equipment';
                $equipment->Take_Out_of_Service_by = Auth::user()->name;
                $equipment->Take_Out_of_Service_on = Carbon::now('Asia/Kolkata')->setTimezone('UTC')->format('Y-m-d H:i:s');
                $equipment->Take_Out_of_Service_comment = $request->comment;


                $history = new EquipmentInfoAuditTrail();
                $history->equipmentInfo_id = $equipment->id;
                $history->activity_type = 'QA Approval By,QA Approval On';
                $history->action = 'QA Approval';
                $history->comment = $equipment->Take_Out_of_Service_comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;

                $history->change_to = "Active Equipment";
                $history->change_from = $lastDocument->status;
                $history->stage = 'Active Equipment';
                if (is_null($lastDocument->Take_Out_of_Service_by) || $lastDocument->Take_Out_of_Service_by === '') {
                    $history->previous = "";
                } else {
                    $history->previous = $lastDocument->Take_Out_of_Service_by . ' , ' . $lastDocument->Take_Out_of_Service_on;
                }
                $history->current = $equipment->Take_Out_of_Service_by . ' , ' . $equipment->Take_Out_of_Service_on;
                if (is_null($lastDocument->Take_Out_of_Service_by) || $lastDocument->Take_Out_of_Service_by === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->save();



                  /**** Notification User ****/
                  $list = Helpers::getQAHeadUserList($equipment->division_id);
                  $userIds = collect($list)->pluck('user_id')->toArray();
                  $users = User::whereIn('id', $userIds)->select('id', 'name', 'email')->get();
                  $userIds = $users->pluck('id');
  
                  if(!empty($users)){
                     try {
                         $history = new EquipmentInfoAuditTrail();
                         $history->equipmentInfo_id = $id;
                         $history->activity_type = "Not Applicable";
                         $history->previous = "Not Applicable";
                         $history->current = "Not Applicable";
                         $history->action = 'Notification';
                         $history->comment = "";
                         $history->user_id = Auth::user()->id;
                         $history->user_name = Auth::user()->name;
                         $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                         $history->origin_state = "Not Applicable";
                         $history->change_to = "Not Applicable";
                         $history->change_from = "Active Equipment";
                         $history->stage = "";
                         $history->action_name = "";
                         $history->mailUserId = $userIds;
                         $history->role_name = "Supervisor";
                         $history->save();
                     } catch (\Throwable $e) {
                         \Log::error('Mail failed to send: ' . $e->getMessage());
                     }
                 }
  
  
                  foreach ($users as $userValue) {
                      DB::table('notifications')->insert([
                          'activity_id' => $equipment->id,
                          'activity_type' => "Notification",
                          'from_id' => Auth::user()->id,
                          'user_name' => $userValue->name,
                          'to_id' => $userValue->id,
                          'process_name' => "Equipment/Instrument Lifecycle Management",
                          'division_id' => $equipment->division_id,
                          'short_description' => $equipment->short_description,
                          'initiator_id' => $equipment->initiator_id,
                          'due_date' => $equipment->due_date,
                          'record' => $equipment->record,
                          'site' => "Equipment/Instrument Lifecycle Management",
                          'comment' => $request->comments,
                          'status' => $equipment->status,
                          'stage' => $equipment->stage,
                          'created_at' => Carbon::now(),
                      ]);
                  }
  
                //   foreach ($list as $u) {
                //       $email = Helpers::getUserEmail($u->user_id);
                //           if ($email !== null) {
                //           try {
                //               Mail::send(
                //                   'mail.view-mail',
                //                   ['data' => $equipment, 'site' => "Equipment/Instrument Lifecycle Management", 'history' => "Take Out of Service", 'process' => 'Equipment/Instrument Lifecycle Management', 'comment' => $request->comments, 'user' => Auth::user()->name],
                //                   function ($message) use ($email, $equipment) {
                //                       $message->to($email)
                //                       ->subject("Medicef Notification: equipment, Record #" . str_pad($equipment->record, 4, '0', STR_PAD_LEFT) . " - Activity: Take Out of Service Performed");
                //                   }
                //               );
  
                            
                //           } catch(\Exception $e) {
                //               info('Error sending mail', [$e]);
                //           }
                //       }
                //   }
 


                $equipment->update();
                toastr()->success('Document Sent');
                return back();
            }

            if ($equipment->stage == 7) {
                $equipment->stage = "8";
                $equipment->status = 'Out of Service';
                $equipment->Forward_to_Storage_by = Auth::user()->name;
                $equipment->Forward_to_Storage_on = Carbon::now('Asia/Kolkata')->setTimezone('UTC')->format('Y-m-d H:i:s');
                $equipment->Forward_to_Storage_comment = $request->comment;


                $history = new EquipmentInfoAuditTrail();
                $history->equipmentInfo_id = $equipment->id;
                $history->activity_type = 'Take Out of Service By,Take Out of Service On';
                $history->action = 'Take Out of Service';
                $history->comment = $equipment->Forward_to_Storage_comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;

                $history->change_to = "Out of Service";
                $history->change_from = $lastDocument->status;
                $history->stage = 'Out of Service';
                if (is_null($lastDocument->Forward_to_Storage_by) || $lastDocument->Forward_to_Storage_by === '') {
                    $history->previous = "";
                } else {
                    $history->previous = $lastDocument->Forward_to_Storage_by . ' , ' . $lastDocument->Forward_to_Storage_on;
                }
                $history->current = $equipment->Forward_to_Storage_by . ' , ' . $equipment->Forward_to_Storage_on;
                if (is_null($lastDocument->Forward_to_Storage_by) || $lastDocument->Forward_to_Storage_by === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->save();

                

                $equipment->update();
                toastr()->success('Document Sent');
                return back();
            }

            if ($equipment->stage == 8) {
                $equipment->stage = "9";
                $equipment->status = 'In Storage';
                $equipment->forword_storage_by = Auth::user()->name;
                $equipment->forword_storage_on = Carbon::now('Asia/Kolkata')->setTimezone('UTC')->format('Y-m-d H:i:s');
                $equipment->forword_storage_comment = $request->comment;


                $history = new EquipmentInfoAuditTrail();
                $history->equipmentInfo_id = $equipment->id;
                $history->activity_type = 'Forward to Storage By,Forward to Storage On';
                $history->action = 'Forward to Storage';
                $history->comment = $equipment->forword_storage_comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;

                $history->change_to = "In Storage";
                $history->change_from = $lastDocument->status;
                $history->stage = 'In Storage';
                if (is_null($lastDocument->forword_storage_by) || $lastDocument->forword_storage_by === '') {
                    $history->previous = "";
                } else {
                    $history->previous = $lastDocument->forword_storage_by . ' , ' . $lastDocument->forword_storage_on;
                }
                $history->current = $equipment->forword_storage_by . ' , ' . $equipment->forword_storage_on;
                if (is_null($lastDocument->forword_storage_by) || $lastDocument->forword_storage_by === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->save();


                $equipment->update();
                toastr()->success('Document Sent');
                return back();
            }

            if ($equipment->stage == 9) {
                $equipment->stage = "10";
                $equipment->status = 'Closed Retire';
                $equipment->retire_by = Auth::user()->name;
                $equipment->retire_on = Carbon::now('Asia/Kolkata')->setTimezone('UTC')->format('Y-m-d H:i:s');
                $equipment->retire_comment = $request->comment;


                $history = new EquipmentInfoAuditTrail();
                $history->equipmentInfo_id = $equipment->id;
                $history->activity_type = 'Retire By,Retire On';
                $history->action = 'Retire';
                $history->comment = $equipment->retire_comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;

                $history->change_to = "Closed - Retired";
                $history->change_from = $lastDocument->status;
                $history->stage = 'Closed - Retired';
                if (is_null($lastDocument->retire_by) || $lastDocument->retire_by === '') {
                    $history->previous = "";
                } else {
                    $history->previous = $lastDocument->retire_by . ' , ' . $lastDocument->retire_on;
                }
                $history->current = $equipment->retire_by . ' , ' . $equipment->retire_on;
                if (is_null($lastDocument->retire_by) || $lastDocument->retire_by === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
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

public function RejectEquipment(Request $request, $id)
    {
        if ($request->username == Auth::user()->Username && Hash::check($request->password, Auth::user()->password)) {
            $equipment = EquipmentLifecycleManagement::find($id);
            $lastDocument =  EquipmentLifecycleManagement::find($id);


            if ($equipment->stage == 3) {
                $equipment->stage = "2";
                $equipment->status = "Supervisor Review";

                $equipment->More_Info_by = Auth::user()->name;
                $equipment->More_Info_on = Carbon::now('Asia/Kolkata')->setTimezone('UTC')->format('Y-m-d H:i:s');
                $equipment->More_Info_comment = $request->comment;


                $history = new EquipmentInfoAuditTrail();
                $history->equipmentInfo_id = $equipment->id;
                $history->activity_type = 'More Info Required By,More Info Required On';
                $history->action = 'More Info Required';
                $history->comment = $equipment->More_Info_comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;

                $history->change_to = "Supervisor Review";
                $history->change_from = $lastDocument->status;
                $history->stage = 'Supervisor Review';
                if (is_null($lastDocument->More_Info_by) || $lastDocument->More_Info_by === '') {
                    $history->previous = "";
                } else {
                    $history->previous = $lastDocument->More_Info_by . ' , ' . $lastDocument->More_Info_on;
                }
                $history->current = $equipment->More_Info_by . ' , ' . $equipment->More_Info_on;
                if (is_null($lastDocument->More_Info_by) || $lastDocument->More_Info_by === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->save();


                $equipment->update();


                toastr()->success('Document Sent');
                return back();
            }


            if ($equipment->stage == 4) {
                $equipment->stage = "3";
                $equipment->status = "Pending Qualification";

                $equipment->More_Info_by_sec_by = Auth::user()->name;
                $equipment->More_Info_by_sec_on = Carbon::now('Asia/Kolkata')->setTimezone('UTC')->format('Y-m-d H:i:s');
                $equipment->More_Info_by_sec_comment = $request->comment;


                $history = new EquipmentInfoAuditTrail();
                $history->equipmentInfo_id = $equipment->id;
                $history->activity_type = 'More Info Required By,More Info Required On';
                $history->action = 'More Info Required';
                $history->comment = $equipment->More_Info_by_sec_comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;

                $history->change_to = "Pending Qualification";
                $history->change_from = $lastDocument->status;
                $history->stage = 'Pending Qualification';
                if (is_null($lastDocument->More_Info_by_sec_by) || $lastDocument->More_Info_by_sec_by === '') {
                    $history->previous = "";
                } else {
                    $history->previous = $lastDocument->More_Info_by_sec_by . ' , ' . $lastDocument->More_Info_by_sec_on;
                }
                $history->current = $equipment->More_Info_by_sec_by . ' , ' . $equipment->More_Info_by_sec_on;
                if (is_null($lastDocument->More_Info_by_sec_by) || $lastDocument->More_Info_by_sec_by === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->save();


                $equipment->update();


                toastr()->success('Document Sent');
                return back();
            }

            if ($equipment->stage == 6) {
                $equipment->stage = "3";
                $equipment->status = "Pending Qualification";

                $equipment->Re_Qualification_by = Auth::user()->name;
                $equipment->Re_Qualification_on = Carbon::now('Asia/Kolkata')->setTimezone('UTC')->format('Y-m-d H:i:s');
                $equipment->Re_Qualification_comment = $request->comment;


                $history = new EquipmentInfoAuditTrail();
                $history->equipmentInfo_id = $equipment->id;
                $history->activity_type = 'Re-Qualification By,Re-Qualification On';
                $history->action = 'Re-Qualification';
                $history->comment = $equipment->Re_Qualification_comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;

                $history->change_to = "Pending Qualification";
                $history->change_from = $lastDocument->status;
                $history->stage = 'Pending Qualification';
                if (is_null($lastDocument->Re_Qualification_by) || $lastDocument->Re_Qualification_by === '') {
                    $history->previous = "";
                } else {
                    $history->previous = $lastDocument->Re_Qualification_by . ' , ' . $lastDocument->Re_Qualification_on;
                }
                $history->current = $equipment->Re_Qualification_by . ' , ' . $equipment->Re_Qualification_on;
                if (is_null($lastDocument->Re_Qualification_by) || $lastDocument->Re_Qualification_by === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->save();


                $equipment->update();


                toastr()->success('Document Sent');
                return back();
            }

            if ($equipment->stage == 8) {
                $equipment->stage = "7";
                $equipment->status = "Active Equipment";

                $equipment->Re_Active_by = Auth::user()->name;
                $equipment->Re_Active_on = Carbon::now('Asia/Kolkata')->setTimezone('UTC')->format('Y-m-d H:i:s');
                $equipment->Re_Active_comment = $request->comment;


                $history = new EquipmentInfoAuditTrail();
                $history->equipmentInfo_id = $equipment->id;
                $history->activity_type = 'Re-Activate By,Re-Activate On';
                $history->action = 'Re-Activate';
                $history->comment = $equipment->Re_Active_comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;

                $history->change_to = "Active Equipment";
                $history->change_from = $lastDocument->status;
                $history->stage = 'Active Equipment';
                if (is_null($lastDocument->Re_Active_by) || $lastDocument->Re_Active_by === '') {
                    $history->previous = "";
                } else {
                    $history->previous = $lastDocument->Re_Active_by . ' , ' . $lastDocument->Re_Active_on;
                }
                $history->current = $equipment->Re_Active_by . ' , ' . $equipment->Re_Active_on;
                if (is_null($lastDocument->Re_Active_by) || $lastDocument->Re_Active_by === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
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

    public function RejectEquipmentReQualification(Request $request, $id)
    {
        if ($request->username == Auth::user()->Username && Hash::check($request->password, Auth::user()->password)) {
            $equipment = EquipmentLifecycleManagement::find($id);
            $lastDocument =  EquipmentLifecycleManagement::find($id);


            if ($equipment->stage == 8) {
                $equipment->stage = "3";
                $equipment->status = "Pending Qualification";

                $equipment->Re_Qualification_by_sec = Auth::user()->name;
                $equipment->Re_Qualification_on_sec = Carbon::now('Asia/Kolkata')->setTimezone('UTC')->format('Y-m-d H:i:s');
                $equipment->Re_Qualification_comment_sec = $request->comment;

                $history = new EquipmentInfoAuditTrail();
                $history->equipmentInfo_id = $equipment->id;
                $history->activity_type = 'Re-Qualification By,Re-Qualification On';
                $history->action = 'Re-Qualification';
                $history->comment = $equipment->Re_Qualification_comment_sec;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;

                $history->change_to = "Pending Qualification";
                $history->change_from = $lastDocument->status;
                $history->stage = 'Pending Qualification';
                if (is_null($lastDocument->Re_Qualification_by_sec) || $lastDocument->Re_Qualification_by_sec === '') {
                    $history->previous = "";
                } else {
                    $history->previous = $lastDocument->Re_Qualification_by_sec . ' , ' . $lastDocument->Re_Qualification_on_sec;
                }
                $history->current = $equipment->Re_Qualification_by_sec . ' , ' . $equipment->Re_Qualification_on_sec;
                if (is_null($lastDocument->Re_Qualification_by_sec) || $lastDocument->Re_Qualification_by_sec === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
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

    public function EquipmentCancel(Request $request, $id)
    {
        if ($request->username == Auth::user()->Username && Hash::check($request->password, Auth::user()->password)) {
            $EquipmentControl = EquipmentLifecycleManagement::find($id);
            $lastDocument = EquipmentLifecycleManagement::find($id);
            

            if ($EquipmentControl->stage == 1) {
                $EquipmentControl->stage = "0";
                $EquipmentControl->status = "Closed - Cancelled";
                $EquipmentControl->cancel_By = Auth::user()->name;
                $EquipmentControl->cancel_On = Carbon::now('Asia/Kolkata')->setTimezone('UTC')->format('Y-m-d H:i:s');
                $EquipmentControl->cancel_comment = $request->comment;
                

                $history = new EquipmentInfoAuditTrail();
                $history->equipmentInfo_id = $EquipmentControl->id;
                $history->activity_type = 'Cancel By,Cancel On';
                $history->action = 'Cancel';
                $history->comment = $EquipmentControl->cancel_comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;

                $history->change_to = "Closed - Cancelled";
                $history->change_from = $lastDocument->status;
                $history->stage = 'Closed - Cancelled';
                if (is_null($lastDocument->cancel_By) || $lastDocument->cancel_By === '') {
                    $history->previous = "";
                } else {
                    $history->previous = $lastDocument->cancel_By . ' , ' . $lastDocument->cancel_On;
                }
                $history->current = $EquipmentControl->cancel_By . ' , ' . $EquipmentControl->cancel_On;
                if (is_null($lastDocument->cancel_By) || $lastDocument->cancel_By === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->save();

                $EquipmentControl->update();

                toastr()->success('Document Sent');
                return back();
            }

            if ($EquipmentControl->stage == 2) {
                $EquipmentControl->stage = "0";
                $EquipmentControl->status = "Closed - Cancelled";
                $EquipmentControl->cancelled_By = Auth::user()->name;
                $EquipmentControl->cancelled_On = Carbon::now('Asia/Kolkata')->setTimezone('UTC')->format('Y-m-d H:i:s');
                $EquipmentControl->cancelled_comment = $request->comment;

                $history = new EquipmentInfoAuditTrail();
                $history->equipmentInfo_id = $EquipmentControl->id;
                $history->activity_type = 'Cancel By,Cancel On';
                $history->action = 'Cancel';
                $history->comment = $EquipmentControl->cancelled_comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;

                $history->change_to = "Closed - Cancelled";
                $history->change_from = $lastDocument->status;
                $history->stage = 'Closed - Cancelled';
                if (is_null($lastDocument->cancelled_By) || $lastDocument->cancelled_By === '') {
                    $history->previous = "";
                } else {
                    $history->previous = $lastDocument->cancelled_By . ' , ' . $lastDocument->cancelled_On;
                }
                $history->current = $EquipmentControl->cancelled_By . ' , ' . $EquipmentControl->cancelled_On;
                if (is_null($lastDocument->cancelled_By) || $lastDocument->cancelled_By === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->save();

                $EquipmentControl->update();

                toastr()->success('Document Sent');
                return back();

            }
                    } else {
            toastr()->error('E-signature Not match');
            return back();
        }
    }


    public function EquipmentInfoAuditTrail($id)
    {
        $audit = EquipmentInfoAuditTrail::where('equipmentInfo_id', $id)->orderByDESC('id')->paginate();
        $today = Carbon::now()->format('d-m-y');
        $document = EquipmentLifecycleManagement::where('id', $id)->first();
        $document->initiator = User::where('id', $document->initiator_id)->value('name');
        $data = EquipmentLifecycleManagement::find($id);

        return view('frontend.Equipment-Lifecycle-Management.equipment_info_audit_trail', compact('audit', 'document', 'today', 'data'));
    }


    public static function equipmentInfoSingleReport($id)
    {
        $data = EquipmentLifecycleManagement::find($id);
        $equipgrid  = AttachmentGrid::find($id);

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
            $pdf = PDF::loadview('frontend.Equipment-Lifecycle-Management.equipment_info_single_report', compact('data', 'equipgrid'))
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


    public static function equipmentntactivitylogReport($id)
    {
        // dd("test");
        $data = EquipmentLifecycleManagement::find($id);
        $equipgrid  = AttachmentGrid::find($id);

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
            $pdf = PDF::loadview('frontend.Equipment-Lifecycle-Management.activitylog', compact('data', 'equipgrid'))
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
    public static function equipmentFamilyReport($id)
    {
        $data = EquipmentLifecycleManagement::find($id);
        $equipgrid  = AttachmentGrid::find($id);

        if (!empty($data)) {
            // $data->Product_Details = CapaGrid::where('capa_id', $id)->where('type', "Product_Details")->first();
            // $data->Instruments_Details = CapaGrid::where('capa_id', $id)->where('type', "Instruments_Details")->first();
            // $data->Material_Details = CapaGrid::where('capa_id', $id)->where('type', "Material_Details")->first();
            // $data->originator = User::where('id', $data->initiator_id)->value('name');

            // $capa_teamIdsArray = explode(',', $data->capa_team);
            // $capa_teamNames = User::whereIn('id', $capa_teamIdsArray)->pluck('name')->toArray();
            // $capa_teamNamesString = implode(', ', $capa_teamNames);
            $fields = DB::table('change_control_fields')->where('cc_id', $id)->first();
            // dd($fields);
            $cc_cfts =  CcCft::where('cc_id', $id)->first();
            $docdetail = Docdetail::where('cc_id', $data->id)->first();
            $review = Qareview::where('cc_id', $data->id)->first();
            $evaluation = Evaluation::where('cc_id', $data->id)->first();
            $info = AdditionalInformation::where('cc_id', $data->id)->first();
            $comments = GroupComments::where('cc_id', $data->id)->first();
            $assessment = RiskAssessment::where('cc_id', $data->id)->first();
            $approcomments = QaApprovalComments::where('cc_id', $data->id)->first();
            $closure = ChangeClosure::where('cc_id', $data->id)->first();
            $json_decode = Docdetail::where(['cc_id' => $data->id, 'identifier' =>'AffectedDocDetail'])->first();
            $affectedDoc = json_decode($data, true);
            $commnetData = DB::table('change_control_comments')->where('cc_id', $id)->first();
            $Preventive_Maintenance = PreventiveMaintenance::where('parent_id', $id)->get();
            // dd( $Preventive_Maintenance);
            $Calibration_Management = CallibrationDetails::where('parent_id', $id)->get();
            $Deviation = Deviation::where('parent_id', $id)->get();
            // dd( $Deviation);
            $Action_Item = ActionItem::where('parent_id', $id)->get();
            // dd($Action_Item);
            $Change_Control = CC::where('parent_id', $id)->get();
            $cftData =  CcCft::where('cc_id', $id)->first();




            $pdf = App::make('dompdf.wrapper');
            $time = Carbon::now();
            $pdf = PDF::loadview('frontend.Equipment-Lifecycle-Management.equipment_life_cycle__family_report', compact('data',
             'equipgrid',
             'fields',
             'cc_cfts',
             'docdetail',
             'review','cftData',
             'evaluation',
             'info','comments','assessment','approcomments','closure','affectedDoc','commnetData',
             'Preventive_Maintenance',  
             'Calibration_Management',
             'Deviation',
             'Action_Item',
             'Change_Control'
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
            $canvas->page_text($width / 4, $height / 2, $data->status, null, 25, [0, 0, 0], 2, 6, -20);
            return $pdf->stream('CAPA' . $id . '.pdf');
        }
    }


    public static function auditReport($id)
    {
        $doc = EquipmentLifecycleManagement::find($id);
        if (!empty($doc)) {
            $doc->originator = User::where('id', $doc->initiator_id)->value('name');
            $data = EquipmentInfoAuditTrail::where('equipmentInfo_id', $id)->get();
            $pdf = App::make('dompdf.wrapper');
            $time = Carbon::now();
            $data = $data->sortBy('created_at');
            $pdf = PDF::loadview('frontend.Equipment-Lifecycle-Management.auditReport', compact('data', 'doc'))
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
            return $pdf->stream('CAPA-Audit' . $id . '.pdf');
        }
    }

    
    public function equipmentChild(Request $request, $id)
    {

        $cft = [];
        $parent_id = $id;
        $record = ((RecordNumber::first()->value('counter')) + 1);
        $record = str_pad($record, 4, '0', STR_PAD_LEFT);
        $parent_type = "Equipment/Instrument Lifecycle Management";
        $parent_name = "Equipment/Instrument Lifecycle Management";
        $parent_name = $request->$parent_name;
        $record_number = ((RecordNumber::first()->value('counter')) + 1);
        $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
        $record_number = $record;
        $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $due_date = $formattedDate->format('d-M-Y');
        $equipment = EquipmentLifecycleManagement::find($id);
        $parent_record = EquipmentLifecycleManagement::where('id', $id)->value('record');
        $parent_record = str_pad($parent_record, 4, '0', STR_PAD_LEFT);
        $parent_division_id = EquipmentLifecycleManagement::where('id', $id)->value('division_id');
        $parent_initiator_id = EquipmentLifecycleManagement::where('id', $id)->value('initiator_id');
        $parent_intiation_date = EquipmentLifecycleManagement::where('id', $id)->value('intiation_date');
        $parent_created_at = EquipmentLifecycleManagement::where('id', $id)->value('created_at');
        $parent_short_description = EquipmentLifecycleManagement::where('id', $id)->value('short_description');
        $hod = User::where('role', 4)->get();
        
        if ($request->child_type == "Change Control") {
            $old_records = Capa::select('id', 'division_id', 'record')->get();            
            $riskData = RiskLevelKeywords::all();
            $preRiskAssessment = RiskManagement::all();    
            $division = QMSDivision::where('name', Helpers::getDivisionName(session()->get('division')))->first();        
            $hod = User::get();
            $cft = User::get();
            $pre = CC::all();
    
            return view('frontend.change-control.new-change-control', compact("riskData", "preRiskAssessment", "due_date", "hod", "cft", "pre", 'due_date', 'record_number', 'parent_id', 'parent_type', 'parent_record','old_records'));
        } 
        elseif ($request->child_type == "Deviation") {
            $old_record = Deviation::select('id', 'division_id', 'record')->get();
            $pre = Deviation::all();
            return view('frontend.forms.deviation.deviation_new', compact('formattedDate', 'due_date', 'old_record', 'pre', 'record_number', 'parent_id', 'parent_type', 'parent_record','parent_intiation_date', 'parent_initiator_id', 'parent_division_id', 'record', 'currentDate', 'parent_short_description'));
        }

        elseif ($request->child_type == "Action Item"){
            $old_record = ActionItem::select('id', 'division_id', 'record')->get();
            
            return view('frontend.action-item.action-item', compact('parent_id', 'record', 'parent_type', 'record_number', 'currentDate', 'formattedDate', 'due_date', 'parent_record', 'parent_record', 'parent_division_id', 'parent_initiator_id', 'parent_intiation_date', 'parent_short_description','old_record'));
        }
        elseif ($request->child_type == "Preventive Maintenance"){
            
            return view('frontend.preventive-maintenance.preventive_maintenance', compact('parent_id', 'record', 'parent_type', 'record_number', 'currentDate', 'formattedDate', 'due_date', 'parent_record', 'parent_record', 'parent_division_id', 'parent_initiator_id', 'parent_intiation_date', 'parent_short_description', 'equipment'));
        }
        else {
           return view('frontend.Callibration-Details.Callibration_Details_Create', compact('formattedDate', 'due_date', 'record_number', 'parent_id', 'parent_type', 'parent_record','parent_intiation_date', 'parent_initiator_id', 'parent_division_id', 'equipment') );
        }
    }


    public function equipment_exportcsv(Request $request)
    {
     
        $query = EquipmentLifecycleManagement::query();

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

    
        $fileName = 'equipment_log.csv';
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
    
    


    public function equipment_exportExcel(Request $request)
    {
       
        $query = EquipmentLifecycleManagement::query();

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

        $fileName = "equipment.xls";
    
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
    
            echo '<tr style="font-weight: bold; background-color:rgb(228, 203, 63); color: #FFFFFF;">';
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

    public function viewrendersop($id, $total_minimum_time, $per_screen_running_time, $job_training_id, $sop_spent_time){
        $id = Crypt::decryptString($id);
        $totalMinimumTime = Crypt::decryptString($total_minimum_time);
        $perScreenRunningTime = Crypt::decryptString($per_screen_running_time);
        $sop_spent_time = Crypt::decryptString($sop_spent_time);
        return view('frontend.Equipment-Lifecycle-Management.equipmentlifecycle-training_deatils', compact('id', 'totalMinimumTime', 'perScreenRunningTime', 'job_training_id', 'sop_spent_time'));
    }


    public function equipmentQuestionShow($sopids, $inductiontrainingid){
        $inductiontrainingid = EquipmentLifecycleManagementTrainingData::find($inductiontrainingid);
        $inductiontrainingid->trainingAttempt = $inductiontrainingid->trainingAttempt == -1 ? 0 : ( $inductiontrainingid->trainingAttempt == 0 ? 0 : $inductiontrainingid->trainingAttempt - 1);
        $inductiontrainingid->save();

        // Convert the sopids string to an array and trim any extra whitespace
        $sopids = array_map('trim', explode(',', $sopids));

        // Fetch all questions based on cleaned sopids
        $questions = Question::whereIn('document_id', $sopids)
        ->inRandomOrder() // Randomize the order
        ->take(10)        // Limit to 10 records
        ->get();
        // Dump the questions for debugging
            return view('frontend.Equipment-Lifecycle-Management.equipmentlifecycle_question_answer', compact('questions', 'inductiontrainingid'));
    }

    public function checkAnswerequipment(Request $request)
    {
        // Fetch all questions in a random order

        $allQuestions = Question::inRandomOrder()->get();

        // Filter questions to include only Single and Multi Selection Questions
        $filteredQuestions = $allQuestions->filter(function ($question) {
            return in_array($question->type, ['Single Selection Questions', 'Multi Selection Questions']);
        });

        // Take the first 10 questions from the filtered list
        $questions = $filteredQuestions->take(10);

        $correctCount = 0; // Initialize correct answer count
        $totalQuestions = $request->question_count; // Total number of selected questions (should be 10)

        foreach ($questions as $question) {
            // Retrieve user's answer for each question
            $userAnswer = $request->input('question_' . $question->id);
            $correctAnswers = unserialize($question->answers); // Correct answers for the question
            $questionType = $question->type;

            if ($questionType === 'Single Selection Questions') {
                // If it's a single selection question, check if the user's answer matches the correct answer
                if ($userAnswer == $correctAnswers[0]) {
                    $correctCount++;
                }
            } elseif ($questionType === 'Multi Selection Questions') {
                // If it's a multi-selection question, check if the user's answer matches exactly with the correct answer set
                if (is_array($userAnswer)) {
                    // Check if the user's answer matches exactly with the correct answer set
                    if (count(array_diff($correctAnswers, $userAnswer)) === 0 && count(array_diff($userAnswer, $correctAnswers)) === 0) {
                        $correctCount++;
                    }
                }
            }
        }

        // Calculate the correct percentage for the 10 questions
        $score = ($correctCount / $totalQuestions) * 100; // This will be based on 10 questions


        $result = $score >= 80 ? 'Pass' : 'Fail';

        if($request->trainingAttempt == 0 || $result == 'Pass'){
            $equipment = EquipmentLifecycleManagement::find($request->equipmentInfo_id);
            $lastDocument = EquipmentLifecycleManagement::find($request->equipmentInfo_id);

                $equipment->stage = "6";
                $equipment->status = "Pending QA Approval";

                $equipment->Complete_Training_by = Auth::user()->name;
                $equipment->Complete_Training_on = Carbon::now('Asia/Kolkata')->setTimezone('UTC')->format('Y-m-d H:i:s');
                $equipment->Complete_Training_comment = $request->comments;

                $history = new EquipmentInfoAuditTrail();
                $history->equipmentInfo_id = $equipment->id;

                $history->activity_type = 'Training Complete By, Training Complete On';
                if (is_null($lastDocument->Complete_Training_by) || $lastDocument->Complete_Training_by === '') {
                    $history->previous = "NULL";
                } else {
                    $history->previous = $lastDocument->Complete_Training_by . ' , ' . $lastDocument->Complete_Training_on;
                }
                $history->current = $equipment->Complete_Training_by . ' , ' . $equipment->Complete_Training_on;
                if (is_null($lastDocument->Complete_Training_by) || $lastDocument->Complete_Training_on === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }

                $history->action = 'Training Complete';
                $history->comment = $request->comments;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to = "Pending QA Approval";
                $history->change_from = $lastDocument->status;
                $history->stage = 'Pending QA Approval';
                $history->save();

                 /**** Notification User ****/
                 $list = Helpers::getQAHeadUserList($equipment->division_id);
                 $userIds = collect($list)->pluck('user_id')->toArray();
                 $users = User::whereIn('id', $userIds)->select('id', 'name', 'email')->get();
                 $userIds = $users->pluck('id');
 
                 if(!empty($users)){
                    try {
                        $history = new EquipmentInfoAuditTrail();
                        $history->equipmentInfo_id = $request->equipmentInfo_id;
                        $history->activity_type = "Not Applicable";
                        $history->previous = "Not Applicable";
                        $history->current = "Not Applicable";
                        $history->action = 'Notification';
                        $history->comment = "";
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->origin_state = "Not Applicable";
                        $history->change_to = "Not Applicable";
                        $history->change_from = "Pending QA Approval";
                        $history->stage = "";
                        $history->action_name = "";
                        $history->mailUserId = $userIds;
                        $history->role_name = "QA";
                        $history->save();
                    } catch (\Throwable $e) {
                        \Log::error('Mail failed to send: ' . $e->getMessage());
                    }
                }
 
 
                 foreach ($users as $userValue) {
                     DB::table('notifications')->insert([
                         'activity_id' => $equipment->id,
                         'activity_type' => "Notification",
                         'from_id' => Auth::user()->id,
                         'user_name' => $userValue->name,
                         'to_id' => $userValue->id,
                         'process_name' => "Equipment/Instrument Lifecycle Management",
                         'division_id' => $equipment->division_id,
                         'short_description' => $equipment->short_description,
                         'initiator_id' => $equipment->initiator_id,
                         'due_date' => $equipment->due_date,
                         'record' => $equipment->record,
                         'site' => "Equipment/Instrument Lifecycle Management",
                         'comment' => $request->comments,
                         'status' => $equipment->status,
                         'stage' => $equipment->stage,
                         'created_at' => Carbon::now(),
                     ]);
                 }
 
                //  foreach ($list as $u) {
                //      $email = Helpers::getUserEmail($u->user_id);
                //          if ($email !== null) {
                //          try {
                //              Mail::send(
                //                  'mail.view-mail',
                //                  ['data' => $equipment, 'site' => "Equipment/Instrument Lifecycle Management", 'history' => "QA Approval", 'process' => 'Equipment/Instrument Lifecycle Management', 'comment' => $request->comments, 'user' => Auth::user()->name],
                //                  function ($message) use ($email, $equipment) {
                //                      $message->to($email)
                //                      ->subject("Medicef Notification: equipment, Record #" . str_pad($equipment->record, 4, '0', STR_PAD_LEFT) . " - Activity: QA Approval Performed");
                //                  }
                //              );
 
                           
                //          } catch(\Exception $e) {
                //              info('Error sending mail', [$e]);
                //          }
                //      }
                //  }



                //  $list = Helpers::getHodUserList();
                //     foreach ($list as $u) {
                //         if($u->q_m_s_divisions_id == $equipment->division_id){
                //             $email = Helpers::getInitiatorEmail($u->user_id);
                //              if ($email !== null) {
                //               Mail::send(
                //                   'mail.view-mail',
                //                    ['data' => $equipment],
                //                 function ($message) use ($email) {
                //                     $message->to($email)
                //                         ->subject("Document is Send By".Auth::user()->name);
                //                 }
                //               );
                //             }
                //      }
                //   }
                $equipment->update();
        
        }

            $storeResult = new EmpTrainingQuizResult();
            $storeResult->emp_id = $request->emp_id;
            $storeResult->training_id = $request->training_id;
            $storeResult->employee_name = $request->employee_name;
            $storeResult->training_type = "Equipment/Lifecycle Management Training";
            $storeResult->correct_answers = $correctCount;
            $storeResult->incorrect_answers = $totalQuestions - $correctCount;
            $storeResult->total_questions = $totalQuestions;
            $storeResult->score = $score."%";
            $storeResult->result = $result;
            $storeResult->attempt_number = $request->trainingAttempt + 1;
            $storeResult->department = $request->department;
            $storeResult->documentNumber = $request->documentNumber;

            $storeResult->save();

        return view('frontend.Equipment-Lifecycle-Management.equipment_quiz_result', [
            'totalQuestions' => $totalQuestions, // Total questions shown
            'correctCount' => $correctCount, // Number of correctly answered questions
            'score' => $score, // Final score for these 10 questions
            'result' => $result // Pass or Fail based on 80%
        ]);
    }


    public function saveReadingTime(Request $request)
    {
        $sop_spent_time = $request->input('sop_spent_time');
        $id = $request->input('id');
        $jobTraining = EquipmentLifecycleManagementTrainingData::findOrFail($id);

        $jobTraining->sop_spent_time = $sop_spent_time;
        $jobTraining->update();

        return response()->json(['success' => true]);
    }


    
}
