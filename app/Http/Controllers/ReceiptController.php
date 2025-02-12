<?php

namespace App\Http\Controllers;

use App\Models\Receipt;
use App\Models\ReceiptCoordinatorGrid;
use App\Models\SampleManagementAudit;
use App\Models\RecordNumber;
use App\Models\RoleGroup;
use App\Models\User;
use PDF;
use Helpers;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Facades\File;

class ReceiptController extends Controller
{
    public function index()
    {
        $record_number = ((RecordNumber::first()->value('counter')) + 1);
        $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
        $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $due_date = $formattedDate->format('Y-m-d');
       return view('frontend.Receipt.receipt', compact('record_number',) );
        
    }

    public function receipt_store(Request $request)
    {
        $equipment = new Receipt();
        $equipment->form_type = "Sample Management";
        $equipment->record = ((RecordNumber::first()->value('counter')) + 1);
        $equipment->mode_receipt = $request->mode_receipt;
        $equipment->intiation_date = $request->intiation_date;
        $equipment->record_number = $request->record_number;
        $equipment->receipt_division = $request->receipt_division;
        $equipment->received_from = $request->received_from;
        $equipment->brief_description = $request->brief_description;
        $equipment->source_of_sample = $request->source_of_sample;
        $equipment->stakeholder_email = $request->stakeholder_email;
        $equipment->stakeholder_contact = $request->stakeholder_contact;
        $equipment->date_of_receipt = $request->date_of_receipt;
        $equipment->date_of_review = $request->date_of_review;
        $equipment->due_date = $request->due_date;
        $equipment->other_mode = $request->other_mode;
        $equipment->receptionist_diary = $request->receptionist_diary;
        $equipment->received_from_1 = $request->received_from_1;
        $equipment->brief_description_of_sample_1 = $request->brief_description_of_sample_1;
        $equipment->sample_type = $request->sample_type;
        $equipment->sample_analysis_type = $request->sample_analysis_type;
        $equipment->specifications = $request->specifications;
        $equipment->details = $request->details;
        $equipment->initiator_Group = $request->initiator_Group;
        $equipment->initiator_group_code = $request->initiator_group_code;
        $equipment->other_sample_analysis = $request->other_sample_analysis;
        $equipment->other_sample_type = $request->other_sample_type;
        $equipment->analysis_type = implode(',',$request->analysis_type); 
        $equipment->Acknowledgement = $request->Acknowledgement;
        $equipment->moa_change_needed = $request->moa_change_needed;
        $equipment->moa_change_details = $request->moa_change_details;
        $equipment->analysis_start_date = $request->analysis_start_date;
        $equipment->analysis_end_date = $request->analysis_end_date;
        $equipment->turn_around_time = $request->turn_around_time;
        $equipment->review_1_assesment = $request->review_1_assesment;
        $equipment->Review1_Comment = $request->Review1_Comment;
        $equipment->review_2_assesment = $request->review_2_assesment;
        $equipment->Review2_Comment = $request->Review2_Comment;
        $equipment->approver_Comment = $request->approver_Comment;
        $equipment->approver_assesment = $request->approver_assesment;
        $equipment->review_1_person = implode(',',$request->review_1_person);
        $equipment->review_2_person = implode(',',$request->review_2_person);
        $equipment->approver_person = implode(',',$request->approver_person);

        $equipment->Sample_at_ipc_Comment = $request->Sample_at_ipc_Comment;
        $equipment->Sample_coordinator_Comment = $request->Sample_coordinator_Comment;
        $equipment->sample_analysis_Comment = $request->sample_analysis_Comment;
        $equipment->related_substance_Comment = $request->related_substance_Comment;
        $equipment->assay_analysis_Comment = $request->assay_analysis_Comment;
        $equipment->dissolution_analysis_Comment = $request->dissolution_analysis_Comment;

        // $equipment->Division = $request->input('Division');
        // $equipment->title = $request->input('title');
        // $equipment->date = $request->input('date'); 
        // $equipment->objective = $request->input('objective');
        // $equipment->background = $request->input('background');
        // $equipment->method = $request->input('method');

        // $equipment->objective_assay = $request->objective_assay;
        // $equipment->background_assay = $request->background_assay;
        // $equipment->method_assay = $request->method_assay;
        // $equipment->conclusion_assay = $request->conclusion_assay;

        // $equipment->objective_dissolution = $request->objective_dissolution;
        // $equipment->background_dissolution = $request->background_dissolution;
        // $equipment->method_dissolution = $request->method_dissolution;
        
        $equipment->initiator_id = Auth::user()->id;
        // $equipment->division_id = $request->division_id;
        // $equipment->division_code = $request->division_code;
        // $equipment->intiation_date = $request->intiation_date;
        // // $equipment->received_from = $request->received_from;
        // $equipment->record_number = $request->record_number;
        // $equipment->parent_id = $request->parent_id;
        // $equipment->parent_type = $request->parent_type;
        // $equipment->assign_to = $request->assign_to;
        // $equipment->short_description = $request->short_description;
        // $equipment->reagent_name = $request->reagent_name;
        // $equipment->reagent_code = $request->reagent_code;
        // $equipment->cas_number = $request->cas_number;
        // $equipment->physical_form = $request->physical_form;
        // $equipment->hazard_classification = $request->hazard_classification;
        // $equipment->manufacturer_name = $request->manufacturer_name;
        // $equipment->supplier_contact_info = $request->supplier_contact_info;
        // // $equipment->certificate_of_analysis = $request->certificate_of_analysis;
        // $equipment->supplier_lot_number = $request->supplier_lot_number;
        // $equipment->usage_date = $request->usage_date;
        // $equipment->geade_purity = $request->geade_purity;
        // $equipment->status_gi = $request->status_gi;
        // $equipment->purpose_of_use = $request->purpose_of_use;
        // $equipment->quality_used = $request->quality_used;
        // $equipment->logged_by = $request->logged_by;
        // $equipment->storage_condition = $request->storage_condition;
        // $equipment->container_type = $request->container_type;
        // $equipment->shelf_life = $request->shelf_life;
        // $equipment->supplier_name = $request->supplier_name;
        // $equipment->handling_instructions = $request->handling_instructions;
        // $equipment->risk_assesment_code = $request->risk_assesment_code;
        // $equipment->disposal_guidelines = $request->disposal_guidelines;
        // $equipment->regualatory_info = $request->regualatory_info;
    
    
        $equipment->status = 'Opened';
        $equipment->stage = 1;
    
        if (!empty($request->attachment_analysis)) {
            $files = [];
            if ($request->hasfile('attachment_analysis')) {
                foreach ($request->file('attachment_analysis') as $file) {
                    $name = $request->name . '-attachment_analysis' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $equipment->attachment_analysis = json_encode($files);
        }

        if (!empty($request->attachment_receptionist)) {
            $files = [];
            if ($request->hasfile('attachment_receptionist')) {
                foreach ($request->file('attachment_receptionist') as $file) {
                    $name = $request->name . '-attachment_receptionist' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $equipment->attachment_receptionist = json_encode($files);
        }

        if (!empty($request->review1_attachment)) {
            $files = [];
            if ($request->hasfile('review1_attachment')) {
                foreach ($request->file('review1_attachment') as $file) {
                    $name = $request->name . '-review1_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $equipment->review1_attachment = json_encode($files);
        }

        if (!empty($request->review2_attachment)) {
            $files = [];
            if ($request->hasfile('review2_attachment')) {
                foreach ($request->file('review2_attachment') as $file) {
                    $name = $request->name . '-review2_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $equipment->review2_attachment = json_encode($files);
        }

        if (!empty($request->approver_attachment)) {
            $files = [];
            if ($request->hasfile('approver_attachment')) {
                foreach ($request->file('approver_attachment') as $file) {
                    $name = $request->name . '-approver_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $equipment->approver_attachment = json_encode($files);
        }

        if (!empty($request->Sample_at_ipc_attachment)) {
            $files = [];
            if ($request->hasfile('Sample_at_ipc_attachment')) {
                foreach ($request->file('Sample_at_ipc_attachment') as $file) {
                    $name = $request->name . '-Sample_at_ipc_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $equipment->Sample_at_ipc_attachment = json_encode($files);
        }

        if (!empty($request->Sample_coordinator_attachment)) {
            $files = [];
            if ($request->hasfile('Sample_coordinator_attachment')) {
                foreach ($request->file('Sample_coordinator_attachment') as $file) {
                    $name = $request->name . '-Sample_coordinator_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $equipment->Sample_coordinator_attachment = json_encode($files);
        }

        if (!empty($request->sample_analysis_attachment)) {
            $files = [];
            if ($request->hasfile('sample_analysis_attachment')) {
                foreach ($request->file('sample_analysis_attachment') as $file) {
                    $name = $request->name . '-sample_analysis_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $equipment->sample_analysis_attachment = json_encode($files);
        }

        if (!empty($request->related_substance_attachment)) {
            $files = [];
            if ($request->hasfile('related_substance_attachment')) {
                foreach ($request->file('related_substance_attachment') as $file) {
                    $name = $request->name . '-related_substance_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $equipment->related_substance_attachment = json_encode($files);
        }

        if (!empty($request->assay_analysis_attachment)) {
            $files = [];
            if ($request->hasfile('assay_analysis_attachment')) {
                foreach ($request->file('assay_analysis_attachment') as $file) {
                    $name = $request->name . '-assay_analysis_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $equipment->assay_analysis_attachment = json_encode($files);
        }

        if (!empty($request->dissolution_analysis_attachment)) {
            $files = [];
            if ($request->hasfile('dissolution_analysis_attachment')) {
                foreach ($request->file('dissolution_analysis_attachment') as $file) {
                    $name = $request->name . '-dissolution_analysis_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $equipment->dissolution_analysis_attachment = json_encode($files);
        }

        $equipment->save();

        $receipt_coordinator_id = $equipment->id;

        $ReceiptCoordinatorGrid = ReceiptCoordinatorGrid::where(['receipt_coordinator_id' => $receipt_coordinator_id, 'identifier' => 'Sample Coordinator'])->firstOrNew();
        $ReceiptCoordinatorGrid->receipt_coordinator_id = $receipt_coordinator_id;
        $ReceiptCoordinatorGrid->identifier = 'Sample Coordinator';
        $ReceiptCoordinatorGrid->data = $request->sample_coordinator;
        // dd($ReceiptCoordinatorGrid);
        $ReceiptCoordinatorGrid->save();

        // first grid
        $Details_of_Standards = ReceiptCoordinatorGrid::where(['receipt_coordinator_id' => $receipt_coordinator_id, 'identifier' => 'Details of Standards'])->firstOrNew();
        $Details_of_Standards->receipt_coordinator_id = $receipt_coordinator_id;
        $Details_of_Standards->identifier = 'Details of Standards';
        $Details_of_Standards->data = $request->standards_samples_details;
        $Details_of_Standards->save();

        // storev second grid data 
        $Details_of_Chemicals = ReceiptCoordinatorGrid::where(['receipt_coordinator_id' => $receipt_coordinator_id, 'identifier' => 'Details of Chemicals'])->firstOrNew();
        $Details_of_Chemicals->receipt_coordinator_id = $receipt_coordinator_id;
        $Details_of_Chemicals->identifier = 'Details of Chemicals';
        $Details_of_Chemicals->data = $request->chemicals_reagents_details;
        $Details_of_Chemicals->save();

        // third grid data for Proposed Corrective Action grid
        $Details_of_Instruments = ReceiptCoordinatorGrid::where(['receipt_coordinator_id' => $receipt_coordinator_id, 'identifier' => 'Details of Instruments'])->firstOrNew();
        $Details_of_Instruments->receipt_coordinator_id = $receipt_coordinator_id;
        $Details_of_Instruments->identifier = 'Details of Instruments';
        $Details_of_Instruments->data = $request->instruments_used_details;
        $Details_of_Instruments->save();

        // fourth grid data for Proposed Corrective Action grid
        $Details_of_Related_Substances = ReceiptCoordinatorGrid::where(['receipt_coordinator_id' => $receipt_coordinator_id, 'identifier' => 'Related Substances Test Results'])->firstOrNew();
        $Details_of_Related_Substances->receipt_coordinator_id = $receipt_coordinator_id;
        $Details_of_Related_Substances->identifier = 'Related Substances Test Results';
        $Details_of_Related_Substances->data = $request->related_substances_test_details;
        $Details_of_Related_Substances->save();

        $grid = ReceiptCoordinatorGrid::where(['receipt_coordinator_id'=>$receipt_coordinator_id, 'identifier'=>'Product_MaterialDetails'])->firstOrNew();
        $grid->receipt_coordinator_id = $receipt_coordinator_id;
        $grid->identifier='Product_MaterialDetails';
        $grid->data=json_encode($request->Product_Material);
        $grid->save();

        $grid = ReceiptCoordinatorGrid::where(['receipt_coordinator_id'=>$receipt_coordinator_id, 'identifier'=>'Report_Approval'])->firstOrNew();
        $grid->receipt_coordinator_id = $receipt_coordinator_id;
        $grid->identifier='Report_Approval';
        $grid->data=json_encode($request->Report_Approval);
        $grid->save();

        $grid = ReceiptCoordinatorGrid::where(['receipt_coordinator_id'=>$receipt_coordinator_id, 'identifier'=>'Details_Instruments'])->firstOrNew();
        $grid->receipt_coordinator_id = $receipt_coordinator_id;
        $grid->identifier='Details_Instruments';
        $grid->data=json_encode($request->Details_Instruments);
        $grid->save();

        $grid = ReceiptCoordinatorGrid::where(['receipt_coordinator_id'=>$receipt_coordinator_id, 'identifier'=>'Assay_Test'])->firstOrNew();
        $grid->receipt_coordinator_id = $receipt_coordinator_id;
        $grid->identifier='Assay_Test';
        $grid->data=json_encode($request->Assay_Test);
        $grid->save();

        $dissolutionGrid = ReceiptCoordinatorGrid::where(['receipt_coordinator_id' => $receipt_coordinator_id, 'identifier' => 'Product_MaterialDetail'])->firstOrNew();
        $dissolutionGrid->receipt_coordinator_id = $receipt_coordinator_id;
        $dissolutionGrid->identifier = 'Product_MaterialDetail';
        $dissolutionGrid->data = json_encode($request->Product_MaterialDetails);
        $dissolutionGrid->save();

        $dissolutionGrid = ReceiptCoordinatorGrid::where(['receipt_coordinator_id' => $receipt_coordinator_id, 'identifier' => 'ChemicalsDetails'])->firstOrNew();
        $dissolutionGrid->receipt_coordinator_id = $receipt_coordinator_id;
        $dissolutionGrid->identifier = 'ChemicalsDetails';
        $dissolutionGrid->data = json_encode($request->ChemicalsDetails);
        $dissolutionGrid->save();

        $dissolutionGrid = ReceiptCoordinatorGrid::where(['receipt_coordinator_id' => $receipt_coordinator_id, 'identifier' => 'InstrumentDetails'])->firstOrNew();
        $dissolutionGrid->receipt_coordinator_id = $receipt_coordinator_id;
        $dissolutionGrid->identifier = 'InstrumentDetails';
        $dissolutionGrid->data = json_encode($request->InstrumentDetails);
        $dissolutionGrid->save();

        $dissolutionGrid = ReceiptCoordinatorGrid::where(['receipt_coordinator_id' => $receipt_coordinator_id, 'identifier' => 'DissolutionTest'])->firstOrNew();
        $dissolutionGrid->receipt_coordinator_id = $receipt_coordinator_id;
        $dissolutionGrid->identifier = 'DissolutionTest';
        $dissolutionGrid->data = json_encode($request->DissolutionTest);
        $dissolutionGrid->save();


        /////-----------------------audit trail--------------------

        if(!empty($request->receipt_division))
        {
            $history = new SampleManagementAudit();
            $history->samplemanagement_id = $equipment->id;
            $history->activity_type = 'Division';
            $history->previous = "Null";
            $history->current = Helpers::getFullDivisionName($request->receipt_division);
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

        if(!empty($request->record_number))
        {
            $history = new SampleManagementAudit();
            $history->samplemanagement_id = $equipment->id;
            $history->activity_type = 'Reception Diary Number';
            $history->previous = "Null";
            $history->current = $request->record_number;
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

        
    
        if(!empty($request->mode_receipt))
        {
            $history = new SampleManagementAudit();
            $history->samplemanagement_id = $equipment->id;
            $history->activity_type = 'Mode of Receipt';
            $history->previous = "Null";
            $history->current = $request->mode_receipt;
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

        if(!empty($request->other_mode))
        {
            $history = new SampleManagementAudit();
            $history->samplemanagement_id = $equipment->id;
            $history->activity_type = 'Others';
            $history->previous = "Null";
            $history->current = $request->other_mode;
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
            $history = new SampleManagementAudit();
            $history->samplemanagement_id = $equipment->id;
            $history->activity_type = 'Due Date';
            $history->previous = "Null";
            $history->current = Carbon::parse($request->due_date)->format('d-M-Y');
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
            $history = new SampleManagementAudit();
            $history->samplemanagement_id = $equipment->id;
            $history->activity_type = 'Date';
            $history->previous = "Null";
            $history->current = Carbon::parse($request->intiation_date)->format('d-M-Y');;
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

      

        if(!empty($request->received_from))
        {
            $history = new SampleManagementAudit();
            $history->samplemanagement_id = $equipment->id;
            $history->activity_type = 'Received From';
            $history->previous = "Null";
            $history->current = $request->received_from;
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

        if(!empty($request->brief_description))
        {
            $history = new SampleManagementAudit();
            $history->samplemanagement_id = $equipment->id;
            $history->activity_type = 'Brief Description of Sample';
            $history->previous = "Null";
            $history->current = $request->brief_description;
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

        if(!empty($request->date_of_review))
        {
            $history = new SampleManagementAudit();
            $history->samplemanagement_id = $equipment->id;
            $history->activity_type = 'Date Of Review';
            $history->previous = "Null";
            $history->current = Carbon::parse($request->date_of_review)->format('d-M-Y');;
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

        if(!empty($request->source_of_sample))
        {
            $history = new SampleManagementAudit();
            $history->samplemanagement_id = $equipment->id;
            $history->activity_type = 'Source of sample';
            $history->previous = "Null";
            $history->current = $request->source_of_sample;
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

        if(!empty($request->date_of_review))
        {
            $history = new SampleManagementAudit();
            $history->samplemanagement_id = $equipment->id;
            $history->activity_type = 'Date of Review';
            $history->previous = "Null";
            $history->current = Carbon::parse($request->date_of_review)->format('d-M-Y');
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

        if(!empty($request->stakeholder_email))
        {
            $history = new SampleManagementAudit();
            $history->samplemanagement_id = $equipment->id;
            $history->activity_type = 'Stakeholder Email Address';
            $history->previous = "Null";
            $history->current = $request->stakeholder_email;
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

        if(!empty($request->stakeholder_contact))
        {
            $history = new SampleManagementAudit();
            $history->samplemanagement_id = $equipment->id;
            $history->activity_type = 'Stakeholder Contact Number';
            $history->previous = "Null";
            $history->current = $request->stakeholder_contact;
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

        if(!empty($request->date_of_receipt))
        {
            $history = new SampleManagementAudit();
            $history->samplemanagement_id = $equipment->id;
            $history->activity_type = 'Date Of Receipt';
            $history->previous = "Null";
            $history->current = Carbon::parse($request->date_of_receipt)->format('d-M-Y');
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

        if(!empty($request->Sample_at_ipc_Comment))
        {
            $history = new SampleManagementAudit();
            $history->samplemanagement_id = $equipment->id;
            $history->activity_type = 'Comment';
            $history->previous = "Null";
            $history->current = $request->Sample_at_ipc_Comment;
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

        if (!empty($request->Sample_at_ipc_attachment)) {
            $attachments = is_array($request->Sample_at_ipc_attachment) 
                ? implode(', ', $request->Sample_at_ipc_attachment) 
                : $request->Sample_at_ipc_attachment;
        
            $history = new SampleManagementAudit();
            $history->samplemanagement_id = $equipment->id;
            $history->activity_type = 'Attachment';
            $history->previous = "Null";
            $history->current = $attachments;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $equipment->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->save();
        }
        

        if(!empty($request->receptionist_diary))
        {
            $history = new SampleManagementAudit();
            $history->samplemanagement_id = $equipment->id;
            $history->activity_type = 'Receptionist Diary Number';
            $history->previous = "Null";
            $history->current = $request->receptionist_diary;
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

        if(!empty($request->received_from_1))
        {
            $history = new SampleManagementAudit();
            $history->samplemanagement_id = $equipment->id;
            $history->activity_type = 'Received From';
            $history->previous = "Null";
            $history->current = $request->received_from_1;
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

        if(!empty($request->brief_description_of_sample_1))
        {
            $history = new SampleManagementAudit();
            $history->samplemanagement_id = $equipment->id;
            $history->activity_type = 'Brief Description of Sample';
            $history->previous = "Null";
            $history->current = $request->brief_description_of_sample_1;
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

        if (!empty($request->sample_type)) {
            // Map sample type values to their full names
            $sampleTypeNames = [
                'N' => 'New Drug Substance',
                'I' => 'Indian Pharmacopoeia Reference Standard',
                'T' => 'Proficiency Testing',
                'C' => 'Inter Laboratory Comparison',
                'P' => 'Phytopharmaceutical',
                'M' => 'Miscellaneous',
                '0' => 'Others',
            ];
        
            // Get the full name of the sample type
            $currentSampleType = $sampleTypeNames[$request->sample_type] ?? 'Unknown';
            $history = new SampleManagementAudit();
            $history->samplemanagement_id = $equipment->id;
            $history->activity_type = 'Sample type';
            $history->previous = "Null"; // Update this if you have the previous value
            $history->current = $currentSampleType; // Store the full name
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $equipment->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->save();
        }

        if(!empty($equipment->attachment_receptionist))
        {
            $history = new SampleManagementAudit();
            $history->samplemanagement_id = $equipment->id;
            $history->activity_type = 'Attachment';
            $history->previous = "Null";
            $history->current = $equipment->attachment_receptionist;
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

        if(!empty($request->Sample_coordinator_Comment))
        {
            $history = new SampleManagementAudit();
            $history->samplemanagement_id = $equipment->id;
            $history->activity_type = 'Sample Coordinator Comment';
            $history->previous = "Null";
            $history->current = $request->Sample_coordinator_Comment;
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

        if(!empty($request->Sample_coordinator_attachment))
        {
            $history = new SampleManagementAudit();
            $history->samplemanagement_id = $equipment->id;
            $history->activity_type = 'Sample Coordinator Attachment';
            $history->previous = "Null";
            $history->current = $request->Sample_coordinator_attachment;
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

        if(!empty($request->analysis_type))
        {
            $history = new SampleManagementAudit();
            $history->samplemanagement_id = $equipment->id;
            $history->activity_type = 'Analysis Type';
            $history->previous = "Null";
            $history->current = json_encode($request->analysis_type);
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

        if(!empty($request->specifications))
        {
            $history = new SampleManagementAudit();
            $history->samplemanagement_id = $equipment->id;
            $history->activity_type = 'Selection of Specifications or Standard Test Protocols (STPs)';
            $history->previous = "Null";
            $history->current = $request->specifications;
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

        if(!empty($equipment->attachment_analysis))
        {
            $history = new SampleManagementAudit();
            $history->samplemanagement_id = $equipment->id;
            $history->activity_type = 'Attachment';
            $history->previous = "Null";
            $history->current = $equipment->attachment_analysis;
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

        if(!empty($request->Acknowledgement))
        {
            $history = new SampleManagementAudit();
            $history->samplemanagement_id = $equipment->id;
            $history->activity_type = 'Acknowledgement';
            $history->previous = "Null";
            $history->current = $request->Acknowledgement;
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

        if(!empty($request->moa_change_needed))
        {
            $history = new SampleManagementAudit();
            $history->samplemanagement_id = $equipment->id;
            $history->activity_type = 'MOA Change Needed';
            $history->previous = "Null";
            $history->current = $request->moa_change_needed;
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

        if(!empty($request->moa_change_details))
        {
            $history = new SampleManagementAudit();
            $history->samplemanagement_id = $equipment->id;
            $history->activity_type = 'MOA Change Details';
            $history->previous = "Null";
            $history->current = $request->moa_change_details;
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

        if(!empty($request->analysis_start_date))
        {
            $history = new SampleManagementAudit();
            $history->samplemanagement_id = $equipment->id;
            $history->activity_type = 'Analysis Start Date';
            $history->previous = "Null";
            $history->current = $request->analysis_start_date;
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

        if(!empty($request->analysis_end_date))
        {
            $history = new SampleManagementAudit();
            $history->samplemanagement_id = $equipment->id;
            $history->activity_type = 'Analysis End Date';
            $history->previous = "Null";
            $history->current = $request->analysis_end_date;
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

        if(!empty($request->turn_around_time))
        {
            $history = new SampleManagementAudit();
            $history->samplemanagement_id = $equipment->id;
            $history->activity_type = 'Turn Around Time (TAT)';
            $history->previous = "Null";
            $history->current = $request->turn_around_time;
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

        if(!empty($request->sample_analysis_Comment))
        {
            $history = new SampleManagementAudit();
            $history->samplemanagement_id = $equipment->id;
            $history->activity_type = 'Sample Analysis Comment';
            $history->previous = "Null";
            $history->current = $request->sample_analysis_Comment;
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

        if(!empty($request->sample_analysis_attachment))
        {
            $history = new SampleManagementAudit();
            $history->samplemanagement_id = $equipment->id;
            $history->activity_type = 'Sample Analysis Attachment';
            $history->previous = "Null";
            $history->current = $request->sample_analysis_attachment;
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

        if(!empty($request->related_substance_Comment))
        {
            $history = new SampleManagementAudit();
            $history->samplemanagement_id = $equipment->id;
            $history->activity_type = 'Related Substance Comment';
            $history->previous = "Null";
            $history->current = $request->related_substance_Comment;
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

        if(!empty($request->related_substance_attachment))
        {
            $history = new SampleManagementAudit();
            $history->samplemanagement_id = $equipment->id;
            $history->activity_type = 'Related Substance Attachment';
            $history->previous = "Null";
            $history->current = $request->related_substance_attachment;
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

        if(!empty($request->assay_analysis_Comment))
        {
            $history = new SampleManagementAudit();
            $history->samplemanagement_id = $equipment->id;
            $history->activity_type = 'Assay Analysis Comment';
            $history->previous = "Null";
            $history->current = $request->assay_analysis_Comment;
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

        if(!empty($request->assay_analysis_attachment))
        {
            $history = new SampleManagementAudit();
            $history->samplemanagement_id = $equipment->id;
            $history->activity_type = 'Assay Analysis Attachment';
            $history->previous = "Null";
            $history->current = $request->assay_analysis_attachment;
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

        if(!empty($request->dissolution_analysis_Comment))
        {
            $history = new SampleManagementAudit();
            $history->samplemanagement_id = $equipment->id;
            $history->activity_type = 'Dissolution Analysis Comment';
            $history->previous = "Null";
            $history->current = $request->dissolution_analysis_Comment;
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

        if(!empty($request->dissolution_analysis_attachment))
        {
            $history = new SampleManagementAudit();
            $history->samplemanagement_id = $equipment->id;
            $history->activity_type = 'Dissolution Analysis Attachment';
            $history->previous = "Null";
            $history->current = $request->dissolution_analysis_attachment;
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

        if(!empty($request->review_1_assesment))
        {
            $history = new SampleManagementAudit();
            $history->samplemanagement_id = $equipment->id;
            $history->activity_type = 'Review-1 Assesment';
            $history->previous = "Null";
            $history->current = $request->review_1_assesment;
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

        if(!empty($request->Review1_Comment))
        {
            $history = new SampleManagementAudit();
            $history->samplemanagement_id = $equipment->id;
            $history->activity_type = 'Review-1 Comment';
            $history->previous = "Null";
            $history->current = $request->Review1_Comment;
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

        if(!empty($equipment->review1_attachment))
        {
            $history = new SampleManagementAudit();
            $history->samplemanagement_id = $equipment->id;
            $history->activity_type = 'Review-1 Attachment';
            $history->previous = "Null";
            $history->current = $equipment->review1_attachment;
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

        if(!empty($request->review_2_assesment))
        {
            $history = new SampleManagementAudit();
            $history->samplemanagement_id = $equipment->id;
            $history->activity_type = 'Review-2 Assesment';
            $history->previous = "Null";
            $history->current = $request->review_2_assesment;
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

        if(!empty($request->Review2_Comment))
        {
            $history = new SampleManagementAudit();
            $history->samplemanagement_id = $equipment->id;
            $history->activity_type = 'Review-2 Comment';
            $history->previous = "Null";
            $history->current = $request->Review2_Comment;
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

        if(!empty($equipment->review2_attachment))
        {
            $history = new SampleManagementAudit();
            $history->samplemanagement_id = $equipment->id;
            $history->activity_type = 'Review-2 Attachment';
            $history->previous = "Null";
            $history->current = $equipment->review2_attachment;
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

        if(!empty($request->approver_assesment))
        {
            $history = new SampleManagementAudit();
            $history->samplemanagement_id = $equipment->id;
            $history->activity_type = 'Assesment Of Approver';
            $history->previous = "Null";
            $history->current = $request->approver_assesment;
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

        if(!empty($request->approver_Comment))
        {
            $history = new SampleManagementAudit();
            $history->samplemanagement_id = $equipment->id;
            $history->activity_type = 'Approver Comment';
            $history->previous = "Null";
            $history->current = $request->approver_Comment;
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

        if(!empty($equipment->approver_attachment))
        {
            $history = new SampleManagementAudit();
            $history->samplemanagement_id = $equipment->id;
            $history->activity_type = 'Approver Attachment';
            $history->previous = "Null";
            $history->current = $equipment->approver_attachment;
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
        
        $record = RecordNumber::first();
        $record->counter = ((RecordNumber::first()->value('counter')) + 1);
        $record->update();
    
        toastr()->success("Record is Create Successfully");
        return redirect(url('rcms/lims-dashboard'));
    }

    public function show($id)
    {      
        
        $data = Receipt::find($id);
        $equipment  = Receipt::find($id);
        $ReceiptCoordinatorGrid = ReceiptCoordinatorGrid::where(['receipt_coordinator_id' => $equipment->id, 'identifier' => 'Sample Coordinator'])->first();
        $record_number = ((RecordNumber::first()->value('counter')) + 1);
        $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
        $equipment->record = str_pad($equipment->record, 4, '0', STR_PAD_LEFT);
        $equipment->assign_to_name = User::where('id', $equipment->assign_id)->value('name');
        $equipment->initiator_name = User::where('id', $equipment->initiator_id)->value('name');
        $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $Details_of_Standards = ReceiptCoordinatorGrid::where('receipt_coordinator_id', $id)->where('identifier', "Details of Standards")->first();
        $Details_of_Chemicals = ReceiptCoordinatorGrid::where('receipt_coordinator_id', $id)->where('identifier', "Details of Chemicals")->first();
        $Details_of_Instruments = ReceiptCoordinatorGrid::where('receipt_coordinator_id', $id)->where('identifier', "Details of Instruments")->first();
        $Details_of_Related_Substances = ReceiptCoordinatorGrid::where('receipt_coordinator_id', $id)->where('identifier', "Related Substances Test Results")->first();
        $dataGrid = ReceiptCoordinatorGrid::where('receipt_coordinator_id',$id)->where('identifier','Product_MaterialDetails')->first();
        $dataGrid2 = ReceiptCoordinatorGrid::where('receipt_coordinator_id',$id)->where('identifier','Report_Approval')->first();
        $dataGrid3 = ReceiptCoordinatorGrid::where('receipt_coordinator_id',$id)->where('identifier','Details_Instruments')->first();
        $dataGrid4 = ReceiptCoordinatorGrid::where('receipt_coordinator_id',$id)->where('identifier','Assay_Test')->first();
        $dissolutionGrid = ReceiptCoordinatorGrid::where('receipt_coordinator_id',$id)->where('identifier','Product_MaterialDetail')->first();
        $dissolutionGrid2 = ReceiptCoordinatorGrid::where('receipt_coordinator_id',$id)->where('identifier','ChemicalsDetails')->first();
        $dissolutionGrid3 = ReceiptCoordinatorGrid::where('receipt_coordinator_id',$id)->where('identifier','InstrumentDetails')->first();
        $dissolutionGrid4 = ReceiptCoordinatorGrid::where('receipt_coordinator_id',$id)->where('identifier','DissolutionTest')->first();
        $due_date = $formattedDate->format('Y-m-d');
    
        return view('frontend.Receipt.receipt_view', compact('data', 'equipment', 'record_number','ReceiptCoordinatorGrid','Details_of_Standards','Details_of_Chemicals','Details_of_Instruments','Details_of_Related_Substances','dissolutionGrid','dissolutionGrid2','dissolutionGrid3','dissolutionGrid4','dataGrid','dataGrid2','dataGrid3','dataGrid4'));
    }

    public function update(Request $request, $id)
    {

        $lastDocument = Receipt::find($id);
        $equipment = Receipt::find($id);

        $equipment->mode_receipt = $request->mode_receipt;
        $equipment->intiation_date = $request->intiation_date;
        // $equipment->record_number = $request->record_number;
        // $equipment->receipt_division = $request->receipt_division;
        $equipment->received_from = $request->received_from;
        $equipment->brief_description = $request->brief_description;
        $equipment->source_of_sample = $request->source_of_sample;
        $equipment->stakeholder_email = $request->stakeholder_email;
        $equipment->stakeholder_contact = $request->stakeholder_contact;
        $equipment->date_of_receipt = $request->date_of_receipt;
        $equipment->date_of_review = $request->date_of_review;
        $equipment->due_date = $request->due_date;
        $equipment->other_mode = $request->other_mode;
        $equipment->receptionist_diary = $request->receptionist_diary;
        $equipment->received_from_1 = $request->received_from_1;
        $equipment->brief_description_of_sample_1 = $request->brief_description_of_sample_1;
        $equipment->sample_type = $request->sample_type;
        $equipment->sample_analysis_type = $request->sample_analysis_type;
        $equipment->specifications = $request->specifications;
        $equipment->details = $request->details;
        $equipment->initiator_Group = $request->initiator_Group;
        $equipment->initiator_group_code = $request->initiator_group_code;
        $equipment->other_sample_analysis = $request->other_sample_analysis;
        $equipment->other_sample_type = $request->other_sample_type;
        $equipment->analysis_type = implode(',',$request->analysis_type);
        $equipment->Acknowledgement = $request->Acknowledgement;
        $equipment->moa_change_needed = $request->moa_change_needed;
        $equipment->moa_change_details = $request->moa_change_details;
        $equipment->analysis_start_date = $request->analysis_start_date;
        $equipment->analysis_end_date = $request->analysis_end_date;
        $equipment->turn_around_time = $request->turn_around_time;
        $equipment->review_1_assesment = $request->review_1_assesment;
        $equipment->Review1_Comment = $request->Review1_Comment;
        $equipment->review_2_assesment = $request->review_2_assesment;
        $equipment->Review2_Comment = $request->Review2_Comment;
        $equipment->approver_Comment = $request->approver_Comment;
        $equipment->approver_assesment = $request->approver_assesment;
        $equipment->review_1_person = implode(',',$request->review_1_person);
        $equipment->review_2_person = implode(',',$request->review_2_person);
        $equipment->approver_person = implode(',',$request->approver_person);

        $equipment->Sample_at_ipc_Comment = $request->Sample_at_ipc_Comment;
        $equipment->Sample_coordinator_Comment = $request->Sample_coordinator_Comment;
        $equipment->sample_analysis_Comment = $request->sample_analysis_Comment;
        $equipment->related_substance_Comment = $request->related_substance_Comment;
        $equipment->assay_analysis_Comment = $request->assay_analysis_Comment;
        $equipment->dissolution_analysis_Comment = $request->dissolution_analysis_Comment;

        // $equipment->Division = $request->input('Division');
        // $equipment->title = $request->input('title');
        // $equipment->date = $request->input('date'); 
        // $equipment->objective = $request->input('objective');
        // $equipment->background = $request->input('background');
        // $equipment->method = $request->input('method');

        // $equipment->objective_assay = $request->objective_assay;
        // $equipment->background_assay = $request->background_assay;
        // $equipment->method_assay = $request->method_assay;
        // $equipment->conclusion_assay = $request->conclusion_assay;

        // $equipment->objective_dissolution = $request->objective_dissolution;
        // $equipment->background_dissolution = $request->background_dissolution;
        // $equipment->method_dissolution = $request->method_dissolution;
        
        if (!empty($request->attachment_analysis)) {
            $files = [];
            if ($request->hasfile('attachment_analysis')) {
                foreach ($request->file('attachment_analysis') as $file) {
                    $name = $request->name . '-attachment_analysis' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $equipment->attachment_analysis = json_encode($files);
        }
        if (!empty($request->attachment_receptionist)) {
            $files = [];
            if ($request->hasfile('attachment_receptionist')) {
                foreach ($request->file('attachment_receptionist') as $file) {
                    $name = $request->name . '-attachment_receptionist' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $equipment->attachment_receptionist = json_encode($files);
        }
        if (!empty($request->review1_attachment)) {
            $files = [];
            if ($request->hasfile('review1_attachment')) {
                foreach ($request->file('review1_attachment') as $file) {
                    $name = $request->name . '-review1_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $equipment->review1_attachment = json_encode($files);
        }

        if (!empty($request->review2_attachment)) {
            $files = [];
            if ($request->hasfile('review2_attachment')) {
                foreach ($request->file('review2_attachment') as $file) {
                    $name = $request->name . '-review2_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $equipment->review2_attachment = json_encode($files);
        }

        if (!empty($request->approver_attachment)) {
            $files = [];
            if ($request->hasfile('approver_attachment')) {
                foreach ($request->file('approver_attachment') as $file) {
                    $name = $request->name . '-approver_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $equipment->approver_attachment = json_encode($files);
        }

        if (!empty($request->Sample_at_ipc_attachment)) {
            $files = [];
            if ($request->hasfile('Sample_at_ipc_attachment')) {
                foreach ($request->file('Sample_at_ipc_attachment') as $file) {
                    $name = $request->name . '-Sample_at_ipc_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $equipment->Sample_at_ipc_attachment = json_encode($files);
        }

        if (!empty($request->Sample_coordinator_attachment)) {
            $files = [];
            if ($request->hasfile('Sample_coordinator_attachment')) {
                foreach ($request->file('Sample_coordinator_attachment') as $file) {
                    $name = $request->name . '-Sample_coordinator_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $equipment->Sample_coordinator_attachment = json_encode($files);
        }

        if (!empty($request->sample_analysis_attachment)) {
            $files = [];
            if ($request->hasfile('sample_analysis_attachment')) {
                foreach ($request->file('sample_analysis_attachment') as $file) {
                    $name = $request->name . '-sample_analysis_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $equipment->sample_analysis_attachment = json_encode($files);
        }

        if (!empty($request->related_substance_attachment)) {
            $files = [];
            if ($request->hasfile('related_substance_attachment')) {
                foreach ($request->file('related_substance_attachment') as $file) {
                    $name = $request->name . '-related_substance_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $equipment->related_substance_attachment = json_encode($files);
        }

        if (!empty($request->assay_analysis_attachment)) {
            $files = [];
            if ($request->hasfile('assay_analysis_attachment')) {
                foreach ($request->file('assay_analysis_attachment') as $file) {
                    $name = $request->name . '-assay_analysis_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $equipment->assay_analysis_attachment = json_encode($files);
        }

        if (!empty($request->dissolution_analysis_attachment)) {
            $files = [];
            if ($request->hasfile('dissolution_analysis_attachment')) {
                foreach ($request->file('dissolution_analysis_attachment') as $file) {
                    $name = $request->name . '-dissolution_analysis_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $equipment->dissolution_analysis_attachment = json_encode($files);
        }
        
        $equipment->update();
        $receipt_coordinator_id = $equipment->id;

        $ReceiptCoordinatorGrid = ReceiptCoordinatorGrid::where(['receipt_coordinator_id' => $receipt_coordinator_id, 'identifier' => 'Sample Coordinator'])->firstOrNew();
        $ReceiptCoordinatorGrid->receipt_coordinator_id = $receipt_coordinator_id;
        $ReceiptCoordinatorGrid->identifier = 'Sample Coordinator';
        $ReceiptCoordinatorGrid->data = $request->sample_coordinator;
        // dd($ReceiptCoordinatorGrid);
        $ReceiptCoordinatorGrid->save();

           $Details_of_Standards = ReceiptCoordinatorGrid::where(['receipt_coordinator_id' => $receipt_coordinator_id, 'identifier' => 'Details of Standards'])->firstOrNew();
           $Details_of_Standards->receipt_coordinator_id = $receipt_coordinator_id;
           $Details_of_Standards->identifier = 'Details of Standards';
           $Details_of_Standards->data = $request->standards_samples_details;
           $Details_of_Standards->save();
   
           $Details_of_Chemicals = ReceiptCoordinatorGrid::where(['receipt_coordinator_id' => $receipt_coordinator_id, 'identifier' => 'Details of Chemicals'])->firstOrNew();
           $Details_of_Chemicals->receipt_coordinator_id = $receipt_coordinator_id;
           $Details_of_Chemicals->identifier = 'Details of Chemicals';
           $Details_of_Chemicals->data = $request->chemicals_reagents_details;
           $Details_of_Chemicals->save();
   
           $Details_of_Instruments = ReceiptCoordinatorGrid::where(['receipt_coordinator_id' => $receipt_coordinator_id, 'identifier' => 'Details of Instruments'])->firstOrNew();
           $Details_of_Instruments->receipt_coordinator_id = $receipt_coordinator_id;
           $Details_of_Instruments->identifier = 'Details of Instruments';
           $Details_of_Instruments->data = $request->instruments_used_details;
           $Details_of_Instruments->save();
   
           $Details_of_Related_Substances = ReceiptCoordinatorGrid::where(['receipt_coordinator_id' => $receipt_coordinator_id, 'identifier' => 'Related Substances Test Results'])->firstOrNew();
           $Details_of_Related_Substances->receipt_coordinator_id = $receipt_coordinator_id;
           $Details_of_Related_Substances->identifier = 'Related Substances Test Results';
           $Details_of_Related_Substances->data = $request->related_substances_test_details;
           $Details_of_Related_Substances->save();   
   
           $grid = ReceiptCoordinatorGrid::where(['receipt_coordinator_id'=>$receipt_coordinator_id, 'identifier'=>'Product_MaterialDetails'])->firstOrNew();
           $grid->receipt_coordinator_id = $receipt_coordinator_id;
           $grid->identifier='Product_MaterialDetails';
           $grid->data=json_encode($request->Product_Material);
           $grid->save();
   
           $grid = ReceiptCoordinatorGrid::where(['receipt_coordinator_id'=>$receipt_coordinator_id, 'identifier'=>'Report_Approval'])->firstOrNew();
           $grid->receipt_coordinator_id = $receipt_coordinator_id;
           $grid->identifier='Report_Approval';
           $grid->data=json_encode($request->Report_Approval);
           $grid->save();
   
           $grid = ReceiptCoordinatorGrid::where(['receipt_coordinator_id'=>$receipt_coordinator_id, 'identifier'=>'Details_Instruments'])->firstOrNew();
           $grid->receipt_coordinator_id = $receipt_coordinator_id;
           $grid->identifier='Details_Instruments';
           $grid->data=json_encode($request->Details_Instruments);
           $grid->save();
   
           $grid = ReceiptCoordinatorGrid::where(['receipt_coordinator_id'=>$receipt_coordinator_id, 'identifier'=>'Assay_Test'])->firstOrNew();
           $grid->receipt_coordinator_id = $receipt_coordinator_id;
           $grid->identifier='Assay_Test';
           $grid->data=json_encode($request->Assay_Test);
           $grid->save();

           $dissolutionGrid = ReceiptCoordinatorGrid::where(['receipt_coordinator_id' => $receipt_coordinator_id, 'identifier' => 'Product_MaterialDetail'])->firstOrNew();
           $dissolutionGrid->receipt_coordinator_id = $receipt_coordinator_id;
           $dissolutionGrid->identifier = 'Product_MaterialDetail';
           $dissolutionGrid->data = json_encode($request->Product_MaterialDetails);
           $dissolutionGrid->save();
   
           $dissolutionGrid = ReceiptCoordinatorGrid::where(['receipt_coordinator_id' => $receipt_coordinator_id, 'identifier' => 'ChemicalsDetails'])->firstOrNew();
           $dissolutionGrid->receipt_coordinator_id = $receipt_coordinator_id;
           $dissolutionGrid->identifier = 'ChemicalsDetails';
           $dissolutionGrid->data = json_encode($request->ChemicalsDetails);
           $dissolutionGrid->save();
   
           $dissolutionGrid = ReceiptCoordinatorGrid::where(['receipt_coordinator_id' => $receipt_coordinator_id, 'identifier' => 'InstrumentDetails'])->firstOrNew();
           $dissolutionGrid->receipt_coordinator_id = $receipt_coordinator_id;
           $dissolutionGrid->identifier = 'InstrumentDetails';
           $dissolutionGrid->data = json_encode($request->InstrumentDetails);
           $dissolutionGrid->save();
   
           $dissolutionGrid = ReceiptCoordinatorGrid::where(['receipt_coordinator_id' => $receipt_coordinator_id, 'identifier' => 'DissolutionTest'])->firstOrNew();
           $dissolutionGrid->receipt_coordinator_id = $receipt_coordinator_id;
           $dissolutionGrid->identifier = 'DissolutionTest';
           $dissolutionGrid->data = json_encode($request->DissolutionTest);
           $dissolutionGrid->save();

        //------------------------audit trail code ---------------//
   
        if ($lastDocument->receipt_division != $equipment->receipt_division || !empty($request->status_gi_comment))
        {   
            $history = new SampleManagementAudit();
            $history->samplemanagement_id = $id;
            $history->activity_type = 'Division';
            $history->previous = $lastDocument->receipt_division;
            $history->current = Helpers::getFullDivisionName($equipment->receipt_division);
            $history->comment = $request->status_gi_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            if (is_null($lastDocument->receipt_division) || $lastDocument->receipt_division === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }        
            $history->save();
        }

        if ($lastDocument->mode_receipt != $equipment->mode_receipt || !empty($request->status_gi_comment))
        {   
            $history = new SampleManagementAudit();
            $history->samplemanagement_id = $id;
            $history->activity_type = 'Mode of Receipt';
            $history->previous = $lastDocument->mode_receipt;
            $history->current = $equipment->mode_receipt;
            $history->comment = $request->status_gi_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            if (is_null($lastDocument->mode_receipt) || $lastDocument->mode_receipt === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }        
            $history->save();
        }

        if ($lastDocument->due_date != $equipment->due_date || !empty($request->status_gi_comment))
        {   
            $history = new SampleManagementAudit();
            $history->samplemanagement_id = $id;
            $history->activity_type = 'Due Date';
            $history->previous = Carbon::parse($lastDocument->due_date)->format('d-M-Y');
            $history->current =  Carbon::parse($equipment->due_date)->format('d-M-Y');
            $history->comment = $request->status_gi_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            if (is_null($lastDocument->due_date) || $lastDocument->due_date === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }        
            $history->save();
        }

        if ($lastDocument->other_mode != $equipment->other_mode || !empty($request->status_gi_comment))
        {   
            $history = new SampleManagementAudit();
            $history->samplemanagement_id = $id;
            $history->activity_type = 'Others';
            $history->previous = $lastDocument->other_mode;
            $history->current = $equipment->other_mode;
            $history->comment = $request->status_gi_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            if (is_null($lastDocument->other_mode) || $lastDocument->other_mode === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }        
            $history->save();
        }

        if ($lastDocument->received_from != $equipment->received_from || !empty($request->status_gi_comment))
        {   
            $history = new SampleManagementAudit();
            $history->samplemanagement_id = $id;
            $history->activity_type = 'Received From';
            $history->previous = $lastDocument->received_from;
            $history->current = $equipment->received_from;
            $history->comment = $request->status_gi_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            if (is_null($lastDocument->received_from) || $lastDocument->received_from === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }        
            $history->save();
        }

        if ($lastDocument->brief_description != $equipment->brief_description || !empty($request->status_gi_comment))
        {   
            $history = new SampleManagementAudit();
            $history->samplemanagement_id = $id;
            $history->activity_type = 'Brief Description of Sample';
            $history->previous = $lastDocument->brief_description;
            $history->current = $equipment->brief_description;
            $history->comment = $request->status_gi_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            if (is_null($lastDocument->brief_description) || $lastDocument->brief_description === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }        
            $history->save();
        }

        if ($lastDocument->source_of_sample != $equipment->source_of_sample || !empty($request->status_gi_comment))
        {   
            $history = new SampleManagementAudit();
            $history->samplemanagement_id = $id;
            $history->activity_type = 'Source of sample';
            $history->previous = $lastDocument->source_of_sample;
            $history->current = $equipment->source_of_sample;
            $history->comment = $request->status_gi_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            if (is_null($lastDocument->source_of_sample) || $lastDocument->source_of_sample === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }        
            $history->save();
        }

        if ($lastDocument->date_of_review != $equipment->date_of_review || !empty($request->status_gi_comment))
        {   
            $history = new SampleManagementAudit();
            $history->samplemanagement_id = $id;
            $history->activity_type = 'Date of Review';
            $history->previous = Carbon::parse($lastDocument->date_of_review)->format('d-M-Y');
            $history->current =  Carbon::parse($equipment->date_of_review)->format('d-M-Y');
            $history->comment = $request->status_gi_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            if (is_null($lastDocument->date_of_review) || $lastDocument->date_of_review === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }        
            $history->save();
        }

        if ($lastDocument->stakeholder_email != $equipment->stakeholder_email || !empty($request->status_gi_comment))
        {   
            $history = new SampleManagementAudit();
            $history->samplemanagement_id = $id;
            $history->activity_type = 'Stakeholder Email Address';
            $history->previous = $lastDocument->stakeholder_email;
            $history->current = $equipment->stakeholder_email;
            $history->comment = $request->status_gi_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            if (is_null($lastDocument->stakeholder_email) || $lastDocument->stakeholder_email === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }        
            $history->save();
        }

        if ($lastDocument->stakeholder_contact != $equipment->stakeholder_contact || !empty($request->status_gi_comment))
        {   
            $history = new SampleManagementAudit();
            $history->samplemanagement_id = $id;
            $history->activity_type = 'Stakeholder Contact Number';
            $history->previous = $lastDocument->stakeholder_contact;
            $history->current = $equipment->stakeholder_contact;
            $history->comment = $request->status_gi_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            if (is_null($lastDocument->stakeholder_contact) || $lastDocument->stakeholder_contact === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }        
            $history->save();
        }

        if ($lastDocument->Sample_at_ipc_Comment != $equipment->Sample_at_ipc_Comment || !empty($request->Sample_at_ipc_Comment_comment))
        {   
            $history = new SampleManagementAudit();
            $history->samplemanagement_id = $id;
            $history->activity_type = 'Comment';
            $history->previous = $lastDocument->Sample_at_ipc_Comment;
            $history->current = $equipment->Sample_at_ipc_Comment;
            $history->comment = $request->Sample_at_ipc_Comment_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            if (is_null($lastDocument->Sample_at_ipc_Comment) || $lastDocument->Sample_at_ipc_Comment === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }        
            $history->save();
        }

        if ($lastDocument->Sample_at_ipc_attachment != $equipment->Sample_at_ipc_attachment || !empty($request->Sample_at_ipc_attachment_comment))
        {   
            $history = new SampleManagementAudit();
            $history->samplemanagement_id = $id;
            $history->activity_type = 'Attachment';
            $history->previous = $lastDocument->Sample_at_ipc_attachment;
            $history->current = $equipment->Sample_at_ipc_attachment;
            $history->comment = $request->Sample_at_ipc_attachment_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            if (is_null($lastDocument->Sample_at_ipc_attachment) || $lastDocument->Sample_at_ipc_attachment === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }        
            $history->save();
        }

        if ($lastDocument->date_of_receipt != $equipment->date_of_receipt || !empty($request->status_gi_comment))
        {   
            $history = new SampleManagementAudit();
            $history->samplemanagement_id = $id;
            $history->activity_type = 'Date of Receipt';
            $history->previous = Carbon::parse($lastDocument->date_of_receipt)->format('d-M-Y');
            $history->current = Carbon::parse($equipment->date_of_receipt)->format('d-M-Y');
            $history->comment = $request->status_gi_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            if (is_null($lastDocument->date_of_receipt) || $lastDocument->date_of_receipt === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }        
            $history->save();
        }

        if ($lastDocument->receptionist_diary != $equipment->receptionist_diary || !empty($request->status_gi_comment))
        {   
            $history = new SampleManagementAudit();
            $history->samplemanagement_id = $id;
            $history->activity_type = 'Receptionist Diary Number';
            $history->previous = $lastDocument->receptionist_diary;
            $history->current = $equipment->receptionist_diary;
            $history->comment = $request->status_gi_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            if (is_null($lastDocument->receptionist_diary) || $lastDocument->receptionist_diary === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }        
            $history->save();
        }

        if ($lastDocument->received_from_1 != $equipment->received_from_1 || !empty($request->status_gi_comment))
        {   
            $history = new SampleManagementAudit();
            $history->samplemanagement_id = $id;
            $history->activity_type = 'Received From';
            $history->previous = $lastDocument->received_from_1;
            $history->current = $equipment->received_from_1;
            $history->comment = $request->status_gi_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            if (is_null($lastDocument->received_from_1) || $lastDocument->received_from_1 === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }        
            $history->save();
        }

        if ($lastDocument->brief_description_of_sample_1 != $equipment->brief_description_of_sample_1 || !empty($request->status_gi_comment))
        {   
            $history = new SampleManagementAudit();
            $history->samplemanagement_id = $id;
            $history->activity_type = 'Brief Description of Sample';
            $history->previous = $lastDocument->brief_description_of_sample_1;
            $history->current = $equipment->brief_description_of_sample_1;
            $history->comment = $request->status_gi_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            if (is_null($lastDocument->brief_description_of_sample_1) || $lastDocument->brief_description_of_sample_1 === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }        
            $history->save();
        }

        if ($lastDocument->sample_type != $equipment->sample_type || !empty($request->status_gi_comment))
        {   
            // Map sample type values to their full names
            $sampleTypeNames = [
                'N' => 'New Drug Substance',
                'I' => 'Indian Pharmacopoeia Reference Standard',
                'T' => 'Proficiency Testing',
                'C' => 'Inter Laboratory Comparison',
                'P' => 'Phytopharmaceutical',
                'M' => 'Miscellaneous',
                '0' => 'Others',
            ];
        
            // Get the full names of the sample types
            $previousSampleType = $sampleTypeNames[$lastDocument->sample_type] ?? 'Unknown';
            $currentSampleType = $sampleTypeNames[$equipment->sample_type] ?? 'Unknown';
        
            $history = new SampleManagementAudit();
            $history->samplemanagement_id = $id;
            $history->activity_type = 'Sample type';
            $history->previous = $previousSampleType; // Store full name of previous sample type
            $history->current = $currentSampleType; // Store full name of current sample type
            $history->comment = $request->status_gi_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            if (is_null($lastDocument->sample_type) || $lastDocument->sample_type === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }        
            $history->save();
        }
        
        if ($lastDocument->attachment_receptionist != $equipment->attachment_receptionist || !empty($request->status_gi_comment))
        {   
            $history = new SampleManagementAudit();
            $history->samplemanagement_id = $id;
            $history->activity_type = 'Attachment';
            $history->previous = $lastDocument->attachment_receptionist;
            $history->current = $equipment->attachment_receptionist;
            $history->comment = $request->status_gi_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            if (is_null($lastDocument->attachment_receptionist) || $lastDocument->attachment_receptionist === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }        
            $history->save();
        }

        if ($lastDocument->Sample_coordinator_Comment != $equipment->Sample_coordinator_Comment || !empty($request->Sample_coordinator_Comment_comment))
        {   
            $history = new SampleManagementAudit();
            $history->samplemanagement_id = $id;
            $history->activity_type = 'Sample Coordinator Comment';
            $history->previous = $lastDocument->Sample_coordinator_Comment;
            $history->current = $equipment->Sample_coordinator_Comment;
            $history->comment = $request->Sample_coordinator_Comment_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            if (is_null($lastDocument->Sample_coordinator_Comment) || $lastDocument->Sample_coordinator_Comment === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }        
            $history->save();
        }

        if ($lastDocument->Sample_coordinator_attachment != $equipment->Sample_coordinator_attachment || !empty($request->Sample_coordinator_attachment_comment))
        {   
            $history = new SampleManagementAudit();
            $history->samplemanagement_id = $id;
            $history->activity_type = 'Sample Coordinator Attachment';
            $history->previous = $lastDocument->Sample_coordinator_attachment;
            $history->current = $equipment->Sample_coordinator_attachment;
            $history->comment = $request->Sample_coordinator_attachment_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            if (is_null($lastDocument->Sample_coordinator_attachment) || $lastDocument->Sample_coordinator_attachment === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }        
            $history->save();
        }

        if ($lastDocument->analysis_type != $equipment->analysis_type || !empty($request->status_gi_comment))
        {   
            $history = new SampleManagementAudit();
            $history->samplemanagement_id = $id;
            $history->activity_type = 'Analysis Type';
            $history->previous = $lastDocument->analysis_type;
            $history->current = $equipment->analysis_type;
            $history->comment = $request->status_gi_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            if (is_null($lastDocument->analysis_type) || $lastDocument->analysis_type === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }        
            $history->save();
        }

        if ($lastDocument->specifications != $equipment->specifications || !empty($request->status_gi_comment))
        {   
            $history = new SampleManagementAudit();
            $history->samplemanagement_id = $id;
            $history->activity_type = 'Selection of Specifications or Standard Test Protocols (STPs)';
            $history->previous = $lastDocument->specifications;
            $history->current = $equipment->specifications;
            $history->comment = $request->status_gi_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            if (is_null($lastDocument->specifications) || $lastDocument->specifications === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }        
            $history->save();
        }

        if ($lastDocument->details != $equipment->details || !empty($request->status_gi_comment))
        {   
            $history = new SampleManagementAudit();
            $history->samplemanagement_id = $id;
            $history->activity_type = 'Details';
            $history->previous = $lastDocument->details;
            $history->current = $equipment->details;
            $history->comment = $request->status_gi_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            if (is_null($lastDocument->details) || $lastDocument->details === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }        
            $history->save();
        }

        if ($lastDocument->attachment_analysis != $equipment->attachment_analysis || !empty($request->status_gi_comment))
        {   
            $history = new SampleManagementAudit();
            $history->samplemanagement_id = $id;
            $history->activity_type = 'Attachment';
            $history->previous = $lastDocument->attachment_analysis;
            $history->current = $equipment->attachment_analysis;
            $history->comment = $request->status_gi_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            if (is_null($lastDocument->attachment_analysis) || $lastDocument->attachment_analysis === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }        
            $history->save();
        }

        if ($lastDocument->Acknowledgement != $equipment->Acknowledgement || !empty($request->status_gi_comment))
        {   
            $history = new SampleManagementAudit();
            $history->samplemanagement_id = $id;
            $history->activity_type = 'Acknowledgement';
            $history->previous = $lastDocument->Acknowledgement;
            $history->current = $equipment->Acknowledgement;
            $history->comment = $request->status_gi_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            if (is_null($lastDocument->Acknowledgement) || $lastDocument->Acknowledgement === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }        
            $history->save();
        }

        if ($lastDocument->moa_change_needed != $equipment->moa_change_needed || !empty($request->status_gi_comment))
        {   
            $history = new SampleManagementAudit();
            $history->samplemanagement_id = $id;
            $history->activity_type = 'MOA Change Needed';
            $history->previous = $lastDocument->moa_change_needed;
            $history->current = $equipment->moa_change_needed;
            $history->comment = $request->status_gi_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            if (is_null($lastDocument->moa_change_needed) || $lastDocument->moa_change_needed === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }        
            $history->save();
        }

        if ($lastDocument->moa_change_details != $equipment->moa_change_details || !empty($request->status_gi_comment))
        {   
            $history = new SampleManagementAudit();
            $history->samplemanagement_id = $id;
            $history->activity_type = 'MOA Change Details';
            $history->previous = $lastDocument->moa_change_details;
            $history->current = $equipment->moa_change_details;
            $history->comment = $request->status_gi_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            if (is_null($lastDocument->moa_change_details) || $lastDocument->moa_change_details === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }        
            $history->save();
        }

        if ($lastDocument->analysis_start_date != $equipment->analysis_start_date || !empty($request->status_gi_comment))
        {   
            $history = new SampleManagementAudit();
            $history->samplemanagement_id = $id;
            $history->activity_type = 'Analysis Start Date';
            $history->previous = $lastDocument->analysis_start_date;
            $history->current = $equipment->analysis_start_date;
            $history->comment = $request->status_gi_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            if (is_null($lastDocument->analysis_start_date) || $lastDocument->analysis_start_date === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }        
            $history->save();
        }

        if ($lastDocument->analysis_end_date != $equipment->analysis_end_date || !empty($request->status_gi_comment))
        {   
            $history = new SampleManagementAudit();
            $history->samplemanagement_id = $id;
            $history->activity_type = 'Analysis End Date';
            $history->previous = $lastDocument->analysis_end_date;
            $history->current = $equipment->analysis_end_date;
            $history->comment = $request->status_gi_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            if (is_null($lastDocument->analysis_end_date) || $lastDocument->analysis_end_date === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }        
            $history->save();
        }

        if ($lastDocument->turn_around_time != $equipment->turn_around_time || !empty($request->status_gi_comment))
        {   
            $history = new SampleManagementAudit();
            $history->samplemanagement_id = $id;
            $history->activity_type = 'Turn Around Time (TAT)';
            $history->previous = $lastDocument->turn_around_time;
            $history->current = $equipment->turn_around_time;
            $history->comment = $request->status_gi_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            if (is_null($lastDocument->turn_around_time) || $lastDocument->turn_around_time === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }        
            $history->save();
        }

        if ($lastDocument->sample_analysis_Comment != $equipment->sample_analysis_Comment || !empty($request->sample_analysis_Comment_comment))
        {   
            $history = new SampleManagementAudit();
            $history->samplemanagement_id = $id;
            $history->activity_type = 'Sample Analysis Comment';
            $history->previous = $lastDocument->sample_analysis_Comment;
            $history->current = $equipment->sample_analysis_Comment;
            $history->comment = $request->sample_analysis_Comment_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            if (is_null($lastDocument->sample_analysis_Comment) || $lastDocument->sample_analysis_Comment === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }        
            $history->save();
        }

        if ($lastDocument->sample_analysis_attachment != $equipment->sample_analysis_attachment || !empty($request->sample_analysis_attachment_comment))
        {   
            $history = new SampleManagementAudit();
            $history->samplemanagement_id = $id;
            $history->activity_type = 'Sample Analysis Attachment';
            $history->previous = $lastDocument->sample_analysis_attachment;
            $history->current = $equipment->sample_analysis_attachment;
            $history->comment = $request->sample_analysis_attachment_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            if (is_null($lastDocument->sample_analysis_attachment) || $lastDocument->sample_analysis_attachment === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }        
            $history->save();
        }

        if ($lastDocument->related_substance_Comment != $equipment->related_substance_Comment || !empty($request->related_substance_Comment_comment))
        {   
            $history = new SampleManagementAudit();
            $history->samplemanagement_id = $id;
            $history->activity_type = 'Related Substance Comment';
            $history->previous = $lastDocument->related_substance_Comment;
            $history->current = $equipment->related_substance_Comment;
            $history->comment = $request->related_substance_Comment_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            if (is_null($lastDocument->related_substance_Comment) || $lastDocument->related_substance_Comment === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }        
            $history->save();
        }

        if ($lastDocument->related_substance_attachment != $equipment->related_substance_attachment || !empty($request->related_substance_attachment_comment))
        {   
            $history = new SampleManagementAudit();
            $history->samplemanagement_id = $id;
            $history->activity_type = 'Related Substance Attachment';
            $history->previous = $lastDocument->related_substance_attachment;
            $history->current = $equipment->related_substance_attachment;
            $history->comment = $request->related_substance_attachment_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            if (is_null($lastDocument->related_substance_attachment) || $lastDocument->related_substance_attachment === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }        
            $history->save();
        }

        if ($lastDocument->assay_analysis_Comment != $equipment->assay_analysis_Comment || !empty($request->assay_analysis_Comment_comment))
        {   
            $history = new SampleManagementAudit();
            $history->samplemanagement_id = $id;
            $history->activity_type = 'Assay Analysis Comment';
            $history->previous = $lastDocument->assay_analysis_Comment;
            $history->current = $equipment->assay_analysis_Comment;
            $history->comment = $request->assay_analysis_Comment_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            if (is_null($lastDocument->assay_analysis_Comment) || $lastDocument->assay_analysis_Comment === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }        
            $history->save();
        }

        if ($lastDocument->assay_analysis_attachment != $equipment->assay_analysis_attachment || !empty($request->assay_analysis_attachment_comment))
        {   
            $history = new SampleManagementAudit();
            $history->samplemanagement_id = $id;
            $history->activity_type = 'Assay Analysis Attachment';
            $history->previous = $lastDocument->assay_analysis_attachment;
            $history->current = $equipment->assay_analysis_attachment;
            $history->comment = $request->assay_analysis_attachment_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            if (is_null($lastDocument->assay_analysis_attachment) || $lastDocument->assay_analysis_attachment === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }        
            $history->save();
        }

        if ($lastDocument->dissolution_analysis_Comment != $equipment->dissolution_analysis_Comment || !empty($request->dissolution_analysis_Comment_comment))
        {   
            $history = new SampleManagementAudit();
            $history->samplemanagement_id = $id;
            $history->activity_type = 'Dissolution Analysis Comment';
            $history->previous = $lastDocument->dissolution_analysis_Comment;
            $history->current = $equipment->dissolution_analysis_Comment;
            $history->comment = $request->dissolution_analysis_Comment_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            if (is_null($lastDocument->dissolution_analysis_Comment) || $lastDocument->dissolution_analysis_Comment === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }        
            $history->save();
        }

        if ($lastDocument->dissolution_analysis_attachment != $equipment->dissolution_analysis_attachment || !empty($request->dissolution_analysis_attachment_comment))
        {   
            $history = new SampleManagementAudit();
            $history->samplemanagement_id = $id;
            $history->activity_type = 'Dissolution Analysis Attachment';
            $history->previous = $lastDocument->dissolution_analysis_attachment;
            $history->current = $equipment->dissolution_analysis_attachment;
            $history->comment = $request->dissolution_analysis_attachment_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            if (is_null($lastDocument->dissolution_analysis_attachment) || $lastDocument->dissolution_analysis_attachment === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }        
            $history->save();
        }

        if ($lastDocument->review_1_assesment != $equipment->review_1_assesment || !empty($request->status_gi_comment))
        {   
            $history = new SampleManagementAudit();
            $history->samplemanagement_id = $id;
            $history->activity_type = 'Review-1 Assesment';
            $history->previous = $lastDocument->review_1_assesment;
            $history->current = $equipment->review_1_assesment;
            $history->comment = $request->status_gi_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            if (is_null($lastDocument->review_1_assesment) || $lastDocument->review_1_assesment === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }        
            $history->save();
        }

        if ($lastDocument->Review1_Comment != $equipment->Review1_Comment || !empty($request->status_gi_comment))
        {   
            $history = new SampleManagementAudit();
            $history->samplemanagement_id = $id;
            $history->activity_type = 'Review-1 Comment';
            $history->previous = $lastDocument->Review1_Comment;
            $history->current = $equipment->Review1_Comment;
            $history->comment = $request->status_gi_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            if (is_null($lastDocument->Review1_Comment) || $lastDocument->Review1_Comment === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }        
            $history->save();
        }

        if ($lastDocument->review1_attachment != $equipment->review1_attachment || !empty($request->status_gi_comment))
        {   
            $history = new SampleManagementAudit();
            $history->samplemanagement_id = $id;
            $history->activity_type = 'Review-1 Attachment';
            $history->previous = $lastDocument->review1_attachment;
            $history->current = $equipment->review1_attachment;
            $history->comment = $request->status_gi_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            if (is_null($lastDocument->review1_attachment) || $lastDocument->review1_attachment === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }        
            $history->save();
        }
        
        if ($lastDocument->review_2_assesment != $equipment->review_2_assesment || !empty($request->status_gi_comment))
        {   
            $history = new SampleManagementAudit();
            $history->samplemanagement_id = $id;
            $history->activity_type = 'Review-2 Assesment';
            $history->previous = $lastDocument->review_2_assesment;
            $history->current = $equipment->review_2_assesment;
            $history->comment = $request->status_gi_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            if (is_null($lastDocument->review_2_assesment) || $lastDocument->review_2_assesment === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }        
            $history->save();
        }

        if ($lastDocument->Review2_Comment != $equipment->Review2_Comment || !empty($request->status_gi_comment))
        {   
            $history = new SampleManagementAudit();
            $history->samplemanagement_id = $id;
            $history->activity_type = 'Review-2 Comment';
            $history->previous = $lastDocument->Review2_Comment;
            $history->current = $equipment->Review2_Comment;
            $history->comment = $request->status_gi_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            if (is_null($lastDocument->Review2_Comment) || $lastDocument->Review2_Comment === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }        
            $history->save();
        }

        if ($lastDocument->review2_attachment != $equipment->review2_attachment || !empty($request->status_gi_comment))
        {   
            $history = new SampleManagementAudit();
            $history->samplemanagement_id = $id;
            $history->activity_type = 'Review-2 Attachment';
            $history->previous = $lastDocument->review2_attachment;
            $history->current = $equipment->review2_attachment;
            $history->comment = $request->status_gi_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            if (is_null($lastDocument->review2_attachment) || $lastDocument->review2_attachment === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }        
            $history->save();
        }

        if ($lastDocument->approver_assesment != $equipment->approver_assesment || !empty($request->status_gi_comment))
        {   
            $history = new SampleManagementAudit();
            $history->samplemanagement_id = $id;
            $history->activity_type = 'Assesment Of Approver';
            $history->previous = $lastDocument->approver_assesment;
            $history->current = $equipment->approver_assesment;
            $history->comment = $request->status_gi_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            if (is_null($lastDocument->approver_assesment) || $lastDocument->approver_assesment === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }        
            $history->save();
        }

        if ($lastDocument->approver_Comment != $equipment->approver_Comment || !empty($request->status_gi_comment))
        {   
            $history = new SampleManagementAudit();
            $history->samplemanagement_id = $id;
            $history->activity_type = 'Approver Comment';
            $history->previous = $lastDocument->approver_Comment;
            $history->current = $equipment->approver_Comment;
            $history->comment = $request->status_gi_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            if (is_null($lastDocument->approver_Comment) || $lastDocument->approver_Comment === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }        
            $history->save();
        }

        if ($lastDocument->approver_attachment != $equipment->approver_attachment || !empty($request->status_gi_comment))
        {   
            $history = new SampleManagementAudit();
            $history->samplemanagement_id = $id;
            $history->activity_type = 'Approver Attachment';
            $history->previous = $lastDocument->approver_attachment;
            $history->current = $equipment->approver_attachment;
            $history->comment = $request->status_gi_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            if (is_null($lastDocument->approver_attachment) || $lastDocument->approver_attachment === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }        
            $history->save();
        }

        toastr()->success("Record is Update Successfully");
        return back(); 
    }

    public static function AssayTestingReport($id)
    {
        $data = Receipt::find($id);
        $dataGrid = ReceiptCoordinatorGrid::where('receipt_coordinator_id', $id)->where('identifier', 'Product_MaterialDetails')->first();
        $dataGrid2 = ReceiptCoordinatorGrid::where('receipt_coordinator_id', $id)->where('identifier', 'Report_Approval')->first();
        $dataGrid3 = ReceiptCoordinatorGrid::where('receipt_coordinator_id', $id)->where('identifier', 'Details_Instruments')->first();
        $dataGrid4 = ReceiptCoordinatorGrid::where('receipt_coordinator_id', $id)->where('identifier', 'Assay_Test')->first();
    
        if (!empty($data)) {
            $pdf = App::make('dompdf.wrapper');
            $time = Carbon::now();
            $pdf = PDF::loadview('frontend.Receipt.assay_testing_report', compact('data', 'dataGrid', 'dataGrid2', 'dataGrid3', 'dataGrid4'))
                ->setOptions([
                    'defaultFont' => 'sans-serif',
                    'isHtml5ParserEnabled' => true,
                    'isRemoteEnabled' => true,
                    'isPhpEnabled' => true,
                ]);
            $pdf->setPaper('A4');
            
            // Render the PDF to calculate total pages
            $pdf->render();
            $canvas = $pdf->getDomPDF()->getCanvas();
            $height = $canvas->get_height();
            $width = $canvas->get_width();
    
            // Add pagination and watermark
            $canvas->page_script(function ($pageNumber, $totalPages, $canvas, $fontMetrics) use ($width, $height) {
                // Add watermark
                $canvas->set_opacity(0.1, "Multiply");
                $canvas->text($width / 4, $height / 2, "Watermark Text", null, 25, [0, 0, 0], 2, 6, -20);
    
                // Add page numbers
                $font = $fontMetrics->getFont("sans-serif");
                $canvas->set_opacity(1); // Reset opacity for page numbers
                $canvas->text($width - 70, $height - 30, "Page $pageNumber of $totalPages", $font, 10, [0, 0, 0]);
            });
    
            return $pdf->stream('assayTestingReceipt' . $id . '.pdf');
        }
    }
    

    public static function dissolution_report($id)
    {
        $data = Receipt::find($id);
        if (!empty($data)) {
            $data->originator_id = User::where('id', $data->initiator_id)->value('name');
            $dissolutionGrid = ReceiptCoordinatorGrid::where(['receipt_coordinator_id' => $id, 'identifier' => 'Product_MaterialDetail'])->first();
            $dissolutionGrid2 = ReceiptCoordinatorGrid::where(['receipt_coordinator_id' => $id, 'identifier' => 'ChemicalsDetails'])->first();
            $dissolutionGrid3 = ReceiptCoordinatorGrid::where(['receipt_coordinator_id' => $id, 'identifier' => 'InstrumentDetails'])->first();
            $dissolutionGrid4 = ReceiptCoordinatorGrid::where('receipt_coordinator_id', $id)->where('identifier', 'DissolutionTest')->first();
    
            $pdf = App::make('dompdf.wrapper');
            $time = Carbon::now();
            $pdf = PDF::loadView('frontend.Receipt.dissolution_report', compact('data', 'dissolutionGrid', 'dissolutionGrid2', 'dissolutionGrid3', 'dissolutionGrid4'))
                ->setOptions([
                    'defaultFont' => 'sans-serif',
                    'isHtml5ParserEnabled' => true,
                    'isRemoteEnabled' => true,
                    'isPhpEnabled' => true,
                ]);
            $pdf->setPaper('A4');
    
            // Render the PDF to calculate total pages
            $pdf->render();
            $canvas = $pdf->getDomPDF()->getCanvas();
            $height = $canvas->get_height();
            $width = $canvas->get_width();
    
            // Add pagination and watermark
            $canvas->page_script(function ($pageNumber, $totalPages, $canvas, $fontMetrics) use ($width, $height, $data) {
                // Add watermark
                $canvas->set_opacity(0.1, "Multiply");
                $canvas->text($width / 4, $height / 2, $data->status, null, 25, [0, 0, 0], 2, 6, -20);
    
                // Add page numbers
                $font = $fontMetrics->getFont("sans-serif");
                $canvas->set_opacity(1); // Reset opacity for page numbers
                $canvas->text($width - 70, $height - 30, "Page $pageNumber of $totalPages", $font, 10, [0, 0, 0]);
            });
    
            return $pdf->stream('dissolution' . $id . '.pdf');
        }
    }
    
    public function detailstandardanalysis($id)
    {
        $data = Receipt::find($id);
        $equipment = Receipt::find($id);
        $Details_of_Standards = ReceiptCoordinatorGrid::where('receipt_coordinator_id', $data->id)->where('identifier', "Details of Standards")->first();
        $Details_of_Chemicals = ReceiptCoordinatorGrid::where(['receipt_coordinator_id' => $data->id, 'identifier' => 'Details of Chemicals'])->first();
        $Details_of_Instruments = ReceiptCoordinatorGrid::where(['receipt_coordinator_id' => $data->id, 'identifier' => 'Details of Instruments'])->first();
        $Details_of_Related_Substances = ReceiptCoordinatorGrid::where(['receipt_coordinator_id' => $data->id, 'identifier' => 'Related Substances Test Results'])->first();
    
        // Decode JSON data if needed
        if (!empty($Details_of_Standards) && is_string($Details_of_Standards->data)) {
            $Details_of_Standards->data = json_decode($Details_of_Standards->data, true);
        }
        if (!empty($Details_of_Chemicals) && is_string($Details_of_Chemicals->data)) {
            $Details_of_Chemicals->data = json_decode($Details_of_Chemicals->data, true);
        }
        if (!empty($Details_of_Instruments) && is_string($Details_of_Instruments->data)) {
            $Details_of_Instruments->data = json_decode($Details_of_Instruments->data, true);
        }
        if (!empty($Details_of_Related_Substances) && is_string($Details_of_Related_Substances->data)) {
            $Details_of_Related_Substances->data = json_decode($Details_of_Related_Substances->data, true);
        }
    
        if (!empty($data)) {
            $data->originator = User::where('id', $data->initiator_id)->value('name');
            $pdf = App::make('dompdf.wrapper');
            $time = Carbon::now();
            $pdf = PDF::loadview('frontend.Receipt.detail_standard_analysis', compact('data', 'Details_of_Standards', 'Details_of_Chemicals', 'Details_of_Instruments', 'Details_of_Related_Substances', 'equipment'))
                ->setOptions([
                    'defaultFont' => 'sans-serif',
                    'isHtml5ParserEnabled' => true,
                    'isRemoteEnabled' => true,
                    'isPhpEnabled' => true,
                ]);
            $pdf->setPaper('A4');
    
            // Render the PDF to calculate total pages
            $pdf->render();
            $canvas = $pdf->getDomPDF()->getCanvas();
            $height = $canvas->get_height();
            $width = $canvas->get_width();
    
            // Add pagination and watermark
            $canvas->page_script(function ($pageNumber, $totalPages, $canvas, $fontMetrics) use ($width, $height, $data) {
                // Add watermark
                $canvas->set_opacity(0.1, "Multiply");
                $canvas->text($width / 4, $height / 2, $data->status, null, 25, [0, 0, 0], 2, 6, -20);
    
                // Add page numbers
                $font = $fontMetrics->getFont("sans-serif");
                $canvas->set_opacity(1); // Reset opacity for page numbers
                $canvas->text($width - 70, $height - 30, "Page $pageNumber of $totalPages", $font, 10, [0, 0, 0]);
            });
    
            return $pdf->stream('example.pdf' . $id . '.pdf');
        }
    }
    

    public function receiptStateChange(Request $request, $id)
    {
        if ($request->username == Auth::user()->Username && Hash::check($request->password, Auth::user()->password)) {
            $equipment = Receipt::find($id);
            $lastDocument =  Receipt::find($id);

            if ($equipment->stage == 1) {
                $equipment->stage = "2";
                $equipment->status = 'Pending Front Office Review';
                $equipment->pending_front_offiece_review_by = Auth::user()->name;
                $equipment->pending_front_offiece_review_on = Carbon::now()->format('d-M-Y');
                $equipment->pending_front_offiece_review_comment = $request->comment;
                
                $equipment->update();
                toastr()->success('Document Sent');
                return back();
            }

            if ($equipment->stage == 2) {
                if (!$equipment->date_of_receipt || !$equipment->sample_type) {
                    // Flash message for warning (field not filled)
                    Session::flash('swal', [
                        'title' => 'Mandatory Fields Required!',
                        'message' => 'Date of Receipt and Sample type is yet to be filled!',
                        'type' => 'warning',  // Type can be success, error, warning, info, etc.
                    ]);
            
                    return redirect()->back();
                } else {
                    // Flash message for success (when the form is filled correctly)
                    Session::flash('swal', [
                        'title' => 'Success!',
                        'message' => 'Sent for Pending Review By Sample Coordinator Stage',
                        'type' => 'success',
                    ]);
                }
                $equipment->stage = "3";
                $equipment->status = 'Pending Review By Sample Coordinator';
                $equipment->pending_Review_by_sample_coordinator  = Auth::user()->name;
                $equipment->pending_Review_on_sample_coordinator = Carbon::now()->format('d-M-Y');
                $equipment->pending_Review_comment_sample_coordinator = $request->comment;

              

                $equipment->update();
                toastr()->success('Document Sent');
                return back();
            }

            if ($equipment->stage == 3) {
                 if (!$equipment->Sample_coordinator_Comment) {
                    // Flash message for warning (field not filled)
                    Session::flash('swal', [
                        'title' => 'Mandatory Fields Required!',
                        'message' => 'Sample Coordinator Grid and Comment is yet to be filled!',
                        'type' => 'warning',  // Type can be success, error, warning, info, etc.
                    ]);
            
                    return redirect()->back();
                } else {
                    // Flash message for success (when the form is filled correctly)
                    Session::flash('swal', [
                        'title' => 'Success!',
                        'message' => 'Sent for Pending Allocation of Sample for Analysis',
                        'type' => 'success',
                    ]);
                }
                $equipment->stage = "4";
                $equipment->status = 'Pending Allocation of Sample for Analysis';
                $equipment->pending_allocation_sample_coordinator_by  = Auth::user()->name;
                $equipment->pending_allocation_sample_coordinator_on = Carbon::now()->format('d-M-Y');
                $equipment->pending_allocation_sample_coordinator_comment = $request->comment;
                $equipment->update();
                toastr()->success('Document Sent');
                return back();
            }

            if ($equipment->stage == 4) {
                if (!$equipment->analysis_type && !$equipment->specifications) {
                    // Flash message for warning (field not filled)
                    Session::flash('swal', [
                        'title' => 'Mandatory Fields Required!',
                        'message' => 'Analysis Type And Selection of Specifications is yet to be filled!',
                        'type' => 'warning',  // Type can be success, error, warning, info, etc.
                    ]);
            
                    return redirect()->back();
                } else {
                    // Flash message for success (when the form is filled correctly)
                    Session::flash('swal', [
                        'title' => 'Success!',
                        'message' => 'Sent for Pending Sample Acknowledgement',
                        'type' => 'success',
                    ]);
                }
                $equipment->stage = "5";
                $equipment->status = 'Pending Sample Acknowledgement';
                $equipment->pending_sample_acknowledgement_by  = Auth::user()->name;
                $equipment->pending_sample_acknowledgement_on = Carbon::now()->format('d-M-Y');
                $equipment->pending_sample_acknowledgement_comment = $request->comment;
                $equipment->update();
                toastr()->success('Document Sent');
                return back();
            }

            if ($equipment->stage == 5) {
                if (!$equipment->Acknowledgement && !$equipment->moa_change_needed) {
                    // Flash message for warning (field not filled)
                    Session::flash('swal', [
                        'title' => 'Mandatory Fields Required!',
                        'message' => 'Acknowledgement And MOA Change Needed is yet to be filled!',
                        'type' => 'warning',  // Type can be success, error, warning, info, etc.
                    ]);
            
                    return redirect()->back();
                } else {
                    // Flash message for success (when the form is filled correctly)
                    Session::flash('swal', [
                        'title' => 'Success!',
                        'message' => 'Sent for Pending Sample Analysis',
                        'type' => 'success',
                    ]);
                }
                $equipment->stage = "6";
                $equipment->status = 'Pending Sample Analysis';
                $equipment->Pending_sample_analysis_by  = Auth::user()->name;
                $equipment->Pending_sample_analysis_on = Carbon::now()->format('d-M-Y');
                $equipment->Pending_sample_analysis_comment = $request->comment;

              
                $equipment->update();
                toastr()->success('Document Sent');
                return back();
            }

            if ($equipment->stage == 6) {
                $equipment->stage = "7";
                $equipment->status = 'Closed - Done';
                $equipment->closed_done1_by  = Auth::user()->name;
                $equipment->closed_done1_on = Carbon::now()->format('d-M-Y');
                $equipment->closed_done1_comment = $request->comment;

              
                $equipment->update();
                toastr()->success('Document Sent');
                return back();
            }

            if ($equipment->stage == 8) {
                if (!$equipment->review_1_assesment) {
                    // Flash message for warning (field not filled)
                    Session::flash('swal', [
                        'title' => 'Mandatory Fields Required!',
                        'message' => 'Review-1 Assesment is yet to be filled!',
                        'type' => 'warning',  // Type can be success, error, warning, info, etc.
                    ]);
            
                    return redirect()->back();
                } else {
                    // Flash message for success (when the form is filled correctly)
                    Session::flash('swal', [
                        'title' => 'Success!',
                        'message' => 'Sent for Pending Verification for Review-2',
                        'type' => 'success',
                    ]);
                }
                $equipment->stage = "9";
                $equipment->status = 'Pending Verification for Review-2';
                $equipment->pending_verification2_by  = Auth::user()->name;
                $equipment->pending_verification2_on = Carbon::now()->format('d-M-Y');
                $equipment->pending_verification2_comment = $request->comment;

              
                $equipment->update();
                toastr()->success('Document Sent');
                return back();
            }

            if ($equipment->stage == 9) {
                if (!$equipment->review_2_assesment) {
                    // Flash message for warning (field not filled)
                    Session::flash('swal', [
                        'title' => 'Mandatory Fields Required!',
                        'message' => 'Review-2 Assesment is yet to be filled!',
                        'type' => 'warning',  // Type can be success, error, warning, info, etc.
                    ]);
            
                    return redirect()->back();
                } else {
                    // Flash message for success (when the form is filled correctly)
                    Session::flash('swal', [
                        'title' => 'Success!',
                        'message' => 'Sent for Pending Verification for Approval',
                        'type' => 'success',
                    ]);
                }
                $equipment->stage = "10";
                $equipment->status = 'Pending Verification for Approval';
                $equipment->pending_verification_approve_by  = Auth::user()->name;
                $equipment->pending_verification_approve_on = Carbon::now()->format('d-M-Y');
                $equipment->pending_verification_approve_comment = $request->comment;

              
                $equipment->update();
                toastr()->success('Document Sent');
                return back();
            }

            if ($equipment->stage == 10) {
                if (!$equipment->approver_assesment) {
                    // Flash message for warning (field not filled)
                    Session::flash('swal', [
                        'title' => 'Mandatory Fields Required!',
                        'message' => 'Assesment Of Approver is yet to be filled!',
                        'type' => 'warning',  // Type can be success, error, warning, info, etc.
                    ]);
            
                    return redirect()->back();
                } else {
                    // Flash message for success (when the form is filled correctly)
                    Session::flash('swal', [
                        'title' => 'Success!',
                        'message' => 'Sent for Closed - Done',
                        'type' => 'success',
                    ]);
                }
                $equipment->stage = "11";
                $equipment->status = 'Closed - Done';
                $equipment->closed_done2_by  = Auth::user()->name;
                $equipment->closed_done2_on = Carbon::now()->format('d-M-Y');
                $equipment->closed_done2_comment = $request->comment;

              
                $equipment->update();
                toastr()->success('Document Sent');
                return back();
            }

        }else {
            toastr()->error('E-signature Not match');
            return back();
        }
    }

    public function receiptSecondStateChange(Request $request, $id)
    {
        if ($request->username == Auth::user()->Username && Hash::check($request->password, Auth::user()->password)) {
            $equipment = Receipt::find($id);
            $lastDocument = Receipt::find($id);
            
            if ($equipment->stage == 6) {
                if (empty($equipment->related_substance_Comment) && 
                    empty($equipment->assay_analysis_Comment) && 
                    empty($equipment->dissolution_analysis_Comment)
                ) {
                    Session::flash('swal', [
                        'title' => 'Mandatory Fields Required!',
                        'message' => 'Comment is yet to be filled!',
                        'type' => 'warning',  // Type can be success, error, warning, info, etc.
                    ]);
                
                    return redirect()->back();
                } else {
                    Session::flash('swal', [
                        'title' => 'Success!',
                        'message' => 'Sent for Pending Verification for Review-1',
                        'type' => 'success',
                    ]);
                }
                $equipment->stage = "8";           
                $equipment->status = 'Pending Verification for Review-1';
                $equipment->pending_verification1_by  = Auth::user()->name;
                $equipment->pending_verification1_on = Carbon::now()->format('d-M-Y');
                $equipment->pending_verification1_comment = $request->comment;

              
                $equipment->update();
                toastr()->success('Document Sent');
                return back();
            }
                    } else {
            toastr()->error('E-signature Not match');
            return back();
        }
    }

    public function receiptCancel(Request $request, $id)
    {
        if ($request->username == Auth::user()->Username && Hash::check($request->password, Auth::user()->password)) {
            $equipment = Receipt::find($id);
            $lastDocument = Receipt::find($id);
            

            if ($equipment->stage == 1) {
                $equipment->stage = "0";
                $equipment->status = "Closed - Cancelled";
                $equipment->Cancel_By = Auth::user()->name;
                $equipment->Cancel_On = Carbon::now()->format('d-M-Y');
                $equipment->Cancel_Comment = $request->comment;
                $equipment->update();

            

                toastr()->success('Document Sent');
                return back();
            }
                    } else {
            toastr()->error('E-signature Not match');
            return back();
        }
    }

    public function MoreInfoReceipt(Request $request, $id)
    {
        if ($request->username == Auth::user()->Username && Hash::check($request->password, Auth::user()->password)) {
            $equipment = Receipt::find($id);
            $lastDocument =  Receipt::find($id);


            if ($equipment->stage == 2) {
                $equipment->stage = "1";
                $equipment->status = "Opened";
                $equipment->more_info1_by = Auth::user()->name;
                $equipment->more_info1_on = Carbon::now()->format('d-M-Y');
                $equipment->more_info1_comment = $request->comment;
                $equipment->update();

                toastr()->success('Document Sent');
                return back();
            }

            if ($equipment->stage == 3) {
                $equipment->stage = "1";
                $equipment->status = "Opened";
                $equipment->more_info2_by = Auth::user()->name;
                $equipment->more_info2_on = Carbon::now()->format('d-M-Y');
                $equipment->more_info2_comment = $request->comment;
                $equipment->update();

                toastr()->success('Document Sent');
                return back();
            }
            
            if ($equipment->stage == 4) {
                $equipment->stage = "3";
                $equipment->status = "Pending Review By Sample Coordinator";
                $equipment->more_info3_by = Auth::user()->name;
                $equipment->more_info3_on = Carbon::now()->format('d-M-Y');
                $equipment->more_info3_comment = $request->comment;
                $equipment->update();

                toastr()->success('Document Sent');
                return back();
            }

            if ($equipment->stage == 5) {
                $equipment->stage = "4";
                $equipment->status = "Pending Allocation of Sample for Analysis";
                $equipment->MON_change_neended_by = Auth::user()->name;
                $equipment->MON_change_neended_on = Carbon::now()->format('d-M-Y');
                $equipment->MON_change_neended_comment = $request->comment;
                $equipment->update();

                toastr()->success('Document Sent1111');
                return back();
            }

            if ($equipment->stage == 8) {
                $equipment->stage = "6";
                $equipment->status = "Pending Sample Analysis";
                $equipment->more_info4_by = Auth::user()->name;
                $equipment->more_info4_on = Carbon::now()->format('d-M-Y');
                $equipment->more_info4_comment = $request->comment;
                $equipment->update();

                toastr()->success('Document Sent');
                return back();
            }

          

            if ($equipment->stage == 9) {
                $equipment->stage = "8";
                $equipment->status = "Pending Verification for Review-2";
                $equipment->more_info6_by = Auth::user()->name;
                $equipment->more_info6_on = Carbon::now()->format('d-M-Y');
                $equipment->more_info6_comment = $request->comment;
                $equipment->update();

                toastr()->success('Document Sent');
                return back();
            }

            if ($equipment->stage == 10) {
                $equipment->stage = "9";
                $equipment->status = "Pending Verification for Review-1";
                $equipment->more_info5_by = Auth::user()->name;
                $equipment->more_info5_on = Carbon::now()->format('d-M-Y');
                $equipment->more_info5_comment = $request->comment;
                $equipment->update();

                toastr()->success('Document Sent');
                return back();
            }


        }else {
            toastr()->error('E-signature Not match');
            return back();
        }
    }

    public function ReceiptAuditTrail($id)
    {
        $audit = SampleManagementAudit::where('samplemanagement_id', $id)->orderByDESC('id')->paginate();
        $today = Carbon::now()->format('d-m-y');
        $document = Receipt::where('id', $id)->first();
        $document->initiator = User::where('id', $document->initiator_id)->value('name');
        $data = Receipt::find($id);

        return view('frontend.Receipt.sample_management_audit', compact('audit', 'document', 'today', 'data'));
    }

    public static function Receipt_auditreport($id)
    {
        $doc = Receipt::find($id);
        if (!empty($doc)) {
            $doc->originator = User::where('id', $doc->initiator_id)->value('name');
            $data = SampleManagementAudit::where('samplemanagement_id', $id)->get();
            $pdf = App::make('dompdf.wrapper');
            $time = Carbon::now();
            $pdf = PDF::loadview('frontend.Receipt.sample_management_audit_report', compact('data', 'doc'))
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

    public static function Receipt_singlereport($id)
    {
        $data = Receipt::find($id);
        $equipment = ReceiptCoordinatorGrid::find($id);
        if (!empty($data)) {
            
            $data->originator = User::where('id', $data->initiator_id)->value('name');
            $pdf = App::make('dompdf.wrapper');
            $time = Carbon::now();
            $ReceiptCoordinatorGrid = ReceiptCoordinatorGrid::where(['receipt_coordinator_id' => $equipment->id, 'identifier' => 'Sample Coordinator'])->first();
            $pdf = PDF::loadview('frontend.Receipt.sample_management_single_report', compact('data','ReceiptCoordinatorGrid'))
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

}
