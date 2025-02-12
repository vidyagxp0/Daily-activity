<?php

namespace App\Http\Controllers\lims;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SampleStability_Grid;
use App\Models\RecordNumber;
use App\Models\SampleStability;
use App\Models\SamplingStabilityAuditTrail;
use App\Models\QMSDivision;
use App\Models\RoleGroup;
use App\Models\User;
use App\Models\Analytics;
use App\Models\InventoryManagementGrid;

use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\App;
use PDF;

class StabilityManagementController extends Controller
{
    public function index(){
        $record_number = ((RecordNumber::first()->value('counter')) + 1);
        $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
        $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $due_date = $formattedDate->format('Y-m-d');
        $location = QMSDivision::get();

        /***** Get the last Sample ID ****/
        $lastGridRecord = SampleStability_Grid::latest()->first();
        $lastSamplePlan = collect($lastGridRecord->data ?? [])->last();
        if(!empty($lastSamplePlan)){
            $lastSamplePlanId = $lastSamplePlan['samplePlanId'] + 1;
        } else {
            $lastSamplePlanId = 1001;
        }

        /***** Get Qualified Analyst *****/
        $analystData = Analytics::where('status' , 'Closed-Done')->leftjoin('users', 'users.id', 'analytics.employee_id')->get(['analytics.*', 'users.name as userName', 'users.id as userId']);

        /******* Reagent Data *******/
        $inventoryRecords = InventoryManagementGrid::select('data')->get();

        $filteredData = [];
        
        foreach ($inventoryRecords as $record) {
            $data = is_string($record->data) ? json_decode($record->data, true) : $record->data;
        
            if (is_array($data)) {
                foreach ($data as $item) {
                    if (isset($item['reagent_name'], $item['status']) && $item['status'] === 'Approved') {
                        $filteredData[] = [
                            'name' => $item['reagent_name'],
                        ];
                    }
                }
            }
        }

        return view('frontend.sampling-stability.new_sampling_stability', compact('formattedDate', 'due_date', 'record_number', 'currentDate', 'location', 'lastSamplePlanId', 'analystData', 'filteredData'));
    }
    public function edit($id){
        $data = SampleStability::find($id);
        $planningGrid = SampleStability_Grid::where(['ssgrid_id' => $id])->first();
        $samplePlanningData = $planningGrid ? (is_array($planningGrid->data) ? $planningGrid->data : json_decode($planningGrid->data, true)) : [];

        $ss_id = $id;

        /***** Get Qualified Analyst *****/
        $analystData = Analytics::where('status' , 'Closed-Done')->leftjoin('users', 'users.id', 'analytics.employee_id')->get(['analytics.*', 'users.name as userName', 'users.id as userId']);

        /******* Reagent Data *******/
        $inventoryRecords = InventoryManagementGrid::select('data')->get();

        $filteredData = [];
        
        foreach ($inventoryRecords as $record) {
            $IMData = is_string($record->data) ? json_decode($record->data, true) : $record->data;
        
            if (is_array($IMData)) {
                foreach ($IMData as $item) {
                    if (isset($item['reagent_name'], $item['status']) && $item['status'] === 'Approved') {
                        $filteredData[] = [
                            'name' => $item['reagent_name'],
                        ];
                    }
                }
            }
        }
        return view('frontend.sampling-stability.view_sampling_stability', compact('data','ss_id', 'samplePlanningData', 'planningGrid', 'analystData', 'filteredData'));
    }


    public function store(Request $request){
        $samplePlanning = new SampleStability();
        $samplePlanning->division_id = $request->division_id;
        $samplePlanning->initiator_id = Auth::user()->id;
        $samplePlanning->form_type = "Stability Management";
        $samplePlanning->intiation_date = Carbon::now();
        $samplePlanning->record = DB::table('record_numbers')->value('counter') + 1;
        $samplePlanning->due_date = $request->due_date;
        $samplePlanning->short_description = $request->short_description;
        $samplePlanning->samplePreprationComment = $request->samplePreprationComment;
        if (!empty ($request->supportive_attachment)) {
            $files = [];
            if ($request->hasfile('supportive_attachment')) {
                foreach ($request->file('supportive_attachment') as $file) {
                    $name = $request->name . 'supportive_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $samplePlanning->supportive_attachment = json_encode($files);
        }

        
        $samplePlanning->reviewer_approver = $request->reviewer_approver;
        $samplePlanning->reviewer_comment = $request->reviewer_comment;
        $samplePlanning->review_date = $request->review_date;
        if (!empty ($request->supervisor_attachment)) {
            $files = [];
            if ($request->hasfile('supervisor_attachment')) {
                foreach ($request->file('supervisor_attachment') as $file) {
                    $name = $request->name . 'supervisor_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $samplePlanning->supervisor_attachment = json_encode($files);
        }

        
        $samplePlanning->QA_reviewer_approver = $request->QA_reviewer_approver;
        $samplePlanning->QA_reviewer_comment = $request->QA_reviewer_comment;
        $samplePlanning->QA_review_date = $request->QA_review_date;
        if (!empty ($request->QA_attachment)) {
            $files = [];
            if ($request->hasfile('QA_attachment')) {
                foreach ($request->file('QA_attachment') as $file) {
                    $name = $request->name . 'QA_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $samplePlanning->QA_attachment = json_encode($files);
        }
        $samplePlanning->status = "Opened";
        $samplePlanning->stage = 1;

        $record = RecordNumber::first();
        $record->counter = ((RecordNumber::first()->value('counter')) + 1);
        $record->update();


        $samplePlanning->save();

        $summaryId = $samplePlanning->id;
        $auditorsNew = SampleStability_Grid::where(['ssgrid_id' => $summaryId, 'identifier' => 'SampleStability'])->firstOrCreate();
        $auditorsNew->ssgrid_id = $summaryId;
        $auditorsNew->identifier = 'SampleStability';
        $samplePlanningData = $request->samplePlanningData;

        if (!empty($samplePlanningData) && is_array($samplePlanningData)) {
            foreach ($samplePlanningData as $index => $row) {
                if (isset($row['instrumentReserved']) && is_array($row['instrumentReserved'])) {
                    $row['instrumentReserved'] = implode(',', $row['instrumentReserved']);
                }

                if (isset($row['reagent']) && is_array($row['reagent'])) {
                    $row['reagent'] = implode(',', $row['reagent']);
                }

                if (isset($row['labTechnician']) && is_array($row['labTechnician'])) {
                    $row['labTechnician'] = implode(',', $row['labTechnician']);
                }

                if (!empty($row['specificationAttach'])) {
                    $file = $row['specificationAttach'];
                    $fileName = "SM" . '_specificationAttach_' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('uploads'), $fileName);
        
                    $samplePlanningData[$index]['specificationAttach_path'] = 'uploads/' . $fileName;
                    unset($samplePlanningData[$index]['specificationAttach']);
                } else {
                    $samplePlanningData[$index]['specificationAttach_path'] = null;
                }

                if (!empty($row['STPAttach'])) {
                    $file = $row['STPAttach'];
                    $fileName = "SM" . '_STPAttach_' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('uploads'), $fileName);
        
                    $samplePlanningData[$index]['STPAttach_path'] = 'uploads/' . $fileName;
                    unset($samplePlanningData[$index]['STPAttach']);
                } else {
                    $samplePlanningData[$index]['STPAttach_path'] = null;
                }

                if (!empty($row['supportingDocumentGI'])) {
                    $file = $row['supportingDocumentGI'];
                    $fileName = "SM" . '_supportingDocumentGI_' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('uploads'), $fileName);
        
                    $samplePlanningData[$index]['supportingDocumentGI_path'] = 'uploads/' . $fileName;
                    unset($samplePlanningData[$index]['supportingDocumentGI']);
                } else {
                    $samplePlanningData[$index]['supportingDocumentGI_path'] = null;
                }

                if (!empty($row['attachment'])) {
                    $file = $row['attachment'];
                    $fileName = "SM" . '_attachment_' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('uploads'), $fileName);
        
                    $samplePlanningData[$index]['attachment_path'] = 'uploads/' . $fileName;
                    unset($samplePlanningData[$index]['attachment']);
                } else {
                    $samplePlanningData[$index]['attachment_path'] = null;
                }

                if (!empty($row['supportingDocumentSampleAnalysis'])) {
                    $file = $row['supportingDocumentSampleAnalysis'];
                    $fileName = "SM" . '_supportingDocumentSampleAnalysis_' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('uploads'), $fileName);
        
                    $samplePlanningData[$index]['supportingDocumentSampleAnalysis_path'] = 'uploads/' . $fileName;
                    unset($samplePlanningData[$index]['supportingDocumentSampleAnalysis']);
                } else {
                    $samplePlanningData[$index]['supportingDocumentSampleAnalysis_path'] = null;
                }

                if (!empty($row['stabilityProtocolAttach'])) {
                    $file = $row['stabilityProtocolAttach'];
                    $fileName = "SM" . '_stabilityProtocolAttach_' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('uploads'), $fileName);
        
                    $samplePlanningData[$index]['stabilityProtocolAttach_path'] = 'uploads/' . $fileName;
                    unset($samplePlanningData[$index]['stabilityProtocolAttach']);
                } else {
                    $samplePlanningData[$index]['stabilityProtocolAttach_path'] = null;
                }

                if (!empty($row['stabilityAttachment'])) {
                    $file = $row['stabilityAttachment'];
                    $fileName = "SM" . '_stabilityAttachment_' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('uploads'), $fileName);
        
                    $samplePlanningData[$index]['stabilityAttachment_path'] = 'uploads/' . $fileName;
                    unset($samplePlanningData[$index]['stabilityAttachment']);
                } else {
                    $samplePlanningData[$index]['stabilityAttachment_path'] = null;
                }

                if (!empty($row['supervisorAttach'])) {
                    $file = $row['supervisorAttach'];
                    $fileName = "SM" . '_supervisorAttach_' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('uploads'), $fileName);
        
                    $samplePlanningData[$index]['supervisorAttach_path'] = 'uploads/' . $fileName;
                    unset($samplePlanningData[$index]['supervisorAttach']);
                } else {
                    $samplePlanningData[$index]['supervisorAttach_path'] = null;
                }

                if (!empty($row['QAsupervisorAttach'])) {
                    $file = $row['QAsupervisorAttach'];
                    $fileName = "SM" . '_QAsupervisorAttach_' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('uploads'), $fileName);
        
                    $samplePlanningData[$index]['QAsupervisorAttach_path'] = 'uploads/' . $fileName;
                    unset($samplePlanningData[$index]['QAsupervisorAttach']);
                } else {
                    $samplePlanningData[$index]['QAsupervisorAttach_path'] = null;
                }
            }
        }
        

        
        
        $auditorsNew->data = $samplePlanningData;
        $auditorsNew->save();

        $history = new SamplingStabilityAuditTrail();
        $history->ss_id = $samplePlanning->id;
        $history->activity_type = 'Record Number';
        $history->previous = "Null";
        $history->current = $samplePlanning->record_number;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $samplePlanning->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
        $history->save();

        $history = new SamplingStabilityAuditTrail();
        $history->ss_id = $samplePlanning->id;
        $history->activity_type = 'Site/Location Code';
        $history->previous = "Null";
        $history->current = $samplePlanning->division_id;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $samplePlanning->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
        $history->save();

        $history = new SamplingStabilityAuditTrail();
        $history->ss_id = $samplePlanning->id;
        $history->activity_type = 'Initiator';
        $history->previous = "Null";
        $history->current = $samplePlanning->initiator_id;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $samplePlanning->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
        $history->save(); 
        
        $history = new SamplingStabilityAuditTrail();
        $history->ss_id = $samplePlanning->id;
        $history->activity_type = 'Date of Initiation';
        $history->previous = "Null";
        $history->current = $samplePlanning->intiation_date;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $samplePlanning->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
        $history->save(); 

        $history = new SamplingStabilityAuditTrail();
        $history->ss_id = $samplePlanning->id;
        $history->activity_type = 'Due Date';
        $history->previous = "Null";
        $history->current = $samplePlanning->due_date;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $samplePlanning->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
        $history->save();

        $history = new SamplingStabilityAuditTrail();
        $history->ss_id = $samplePlanning->id;
        $history->activity_type = 'Short Description';
        $history->previous = "Null";
        $history->current = $samplePlanning->short_description;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $samplePlanning->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
        $history->save();

        
        $history = new SamplingStabilityAuditTrail();
        $history->ss_id = $samplePlanning->id;
        $history->activity_type = 'Reviewer/Approver';
        $history->previous = "Null";
        $history->current = $samplePlanning->reviewer_approver;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $samplePlanning->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
        $history->save();

        $history = new SamplingStabilityAuditTrail();
        $history->ss_id = $samplePlanning->id;
        $history->activity_type = 'Reviewer Comment';
        $history->previous = "Null";
        $history->current = $samplePlanning->reviewer_comment;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $samplePlanning->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
        $history->save();

        $history = new SamplingStabilityAuditTrail();
        $history->ss_id = $samplePlanning->id;
        $history->activity_type = 'Review Date';
        $history->previous = "Null";
        $history->current = $samplePlanning->review_date;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $samplePlanning->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
        $history->save();

        $history = new SamplingStabilityAuditTrail();
        $history->ss_id = $samplePlanning->id;
        $history->activity_type = 'Supervisor Attachments';
        $history->previous = "Null";
        $history->current = $samplePlanning->supervisor_attachment;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $samplePlanning->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
        $history->save();

        $history = new SamplingStabilityAuditTrail();
        $history->ss_id = $samplePlanning->id;
        $history->activity_type = 'QA Reviewer/Approver';
        $history->previous = "Null";
        $history->current = $samplePlanning->QA_reviewer_approver;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $samplePlanning->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
        $history->save();

        $history = new SamplingStabilityAuditTrail();
        $history->ss_id = $samplePlanning->id;
        $history->activity_type = 'QA Reviewer Comment';
        $history->previous = "Null";
        $history->current = $samplePlanning->QA_reviewer_comment;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $samplePlanning->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
        $history->save();

        $history = new SamplingStabilityAuditTrail();
        $history->ss_id = $samplePlanning->id;
        $history->activity_type = 'QA Review Date';
        $history->previous = "Null";
        $history->current = $samplePlanning->QA_review_date;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $samplePlanning->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
        $history->save();

        $history = new SamplingStabilityAuditTrail();
        $history->ss_id = $samplePlanning->id;
        $history->activity_type = 'QA Attachment';
        $history->previous = "Null";
        $history->current = $samplePlanning->QA_attachment;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $samplePlanning->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
        $history->save();

        return redirect('rcms/lims-dashboard');
    }

    
    public function update(Request $request, $id){

        $samplePlanning = SampleStability::find($id);
        $lastsamplePlanning = SampleStability::find($id);

        $samplePlanning->short_description = $request->short_description;
        $samplePlanning->samplePreprationComment = $request->samplePreprationComment;
        if (!empty ($request->supportive_attachment)) {
            $files = [];
            if ($request->hasfile('supportive_attachment')) {
                foreach ($request->file('supportive_attachment') as $file) {
                    $name = $request->name . 'supportive_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $samplePlanning->supportive_attachment = json_encode($files);
        }

        
        $samplePlanning->reviewer_approver = $request->reviewer_approver;
        $samplePlanning->reviewer_comment = $request->reviewer_comment;
        $samplePlanning->review_date = $request->review_date;
        if (!empty ($request->supervisor_attachment)) {
            $files = [];
            if ($request->hasfile('supervisor_attachment')) {
                foreach ($request->file('supervisor_attachment') as $file) {
                    $name = $request->name . 'supervisor_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $samplePlanning->supervisor_attachment = json_encode($files);
        }

        
        $samplePlanning->QA_reviewer_approver = $request->QA_reviewer_approver;
        $samplePlanning->QA_reviewer_comment = $request->QA_reviewer_comment;
        $samplePlanning->QA_review_date = $request->QA_review_date;
        if (!empty ($request->QA_attachment)) {
            $files = [];
            if ($request->hasfile('QA_attachment')) {
                foreach ($request->file('QA_attachment') as $file) {
                    $name = $request->name . 'QA_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $samplePlanning->QA_attachment = json_encode($files);
        }
        $samplePlanning->update();
        
        $summaryId = $id;
        $auditorsNew = SampleStability_Grid::where(['ssgrid_id' => $summaryId, 'identifier' => 'SampleStability'])->firstOrCreate();
        $auditorsNew->ssgrid_id = $summaryId;
        $auditorsNew->identifier = 'SampleStability';
        $samplePlanningData = $request->samplePlanningData;

        if (!empty($samplePlanningData) && is_array($samplePlanningData)) {
            foreach ($samplePlanningData as $key => &$row) {

                if (isset($row['instrumentReserved']) && is_array($row['instrumentReserved'])) {
                    $row['instrumentReserved'] = implode(',', $row['instrumentReserved']);
                }

                if (isset($row['reagent']) && is_array($row['reagent'])) {
                    $row['reagent'] = implode(',', $row['reagent']);
                }

                if (isset($row['labTechnician']) && is_array($row['labTechnician'])) {
                    $row['labTechnician'] = implode(',', $row['labTechnician']);
                }

                if (!empty($row['specificationAttach'])) {
                    $file = $row['specificationAttach'];
                    $fileName = "SM" . '_specificationAttach_' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('upload'), $fileName);
                    $samplePlanningData[$key]['specificationAttach_path'] = 'uploads/' . $fileName;
                } elseif (isset($row['specificationAttach_path'])) {
                    $samplePlanningData[$key]['specificationAttach_path'] = $row['specificationAttach_path'];
                }

                if (!empty($row['STPAttach'])) {
                    $file = $row['STPAttach'];
                    $fileName = "SM" . '_STPAttach_' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('upload'), $fileName);
                    $samplePlanningData[$key]['STPAttach_path'] = 'uploads/' . $fileName;
                } elseif (isset($row['STPAttach_path'])) {
                    $samplePlanningData[$key]['STPAttach_path'] = $row['STPAttach_path'];
                }

                if (!empty($row['supportingDocumentGI'])) {
                    $file = $row['supportingDocumentGI'];
                    $fileName = "SM" . '_supportingDocumentGI_' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('upload'), $fileName);
                    $samplePlanningData[$key]['supportingDocumentGI_path'] = 'uploads/' . $fileName;
                } elseif (isset($row['supportingDocumentGI_path'])) {
                    $samplePlanningData[$key]['supportingDocumentGI_path'] = $row['supportingDocumentGI_path'];
                }

                if (!empty($row['attachment'])) {
                    $file = $row['attachment'];
                    $fileName = "SM" . '_attachment_' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('upload'), $fileName);
                    $samplePlanningData[$key]['attachment_path'] = 'uploads/' . $fileName;
                } elseif (isset($row['attachment_path'])) {
                    $samplePlanningData[$key]['attachment_path'] = $row['attachment_path'];
                }

                if (!empty($row['supportingDocumentSampleAnalysis'])) {
                    $file = $row['supportingDocumentSampleAnalysis'];
                    $fileName = "SM" . '_supportingDocumentSampleAnalysis_' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('upload'), $fileName);
                    $samplePlanningData[$key]['supportingDocumentSampleAnalysis_path'] = 'uploads/' . $fileName;
                } elseif (isset($row['supportingDocumentSampleAnalysis_path'])) {
                    $samplePlanningData[$key]['supportingDocumentSampleAnalysis_path'] = $row['supportingDocumentSampleAnalysis_path'];
                }

                if (!empty($row['stabilityProtocolAttach'])) {
                    $file = $row['stabilityProtocolAttach'];
                    $fileName = "SM" . '_stabilityProtocolAttach_' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('upload'), $fileName);
                    $samplePlanningData[$key]['stabilityProtocolAttach_path'] = 'uploads/' . $fileName;
                } elseif (isset($row['stabilityProtocolAttach_path'])) {
                    $samplePlanningData[$key]['stabilityProtocolAttach_path'] = $row['stabilityProtocolAttach_path'];
                }

                if (!empty($row['stabilityAttachment'])) {
                    $file = $row['stabilityAttachment'];
                    $fileName = "SM" . '_stabilityAttachment_' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('upload'), $fileName);
                    $samplePlanningData[$key]['stabilityAttachment_path'] = 'uploads/' . $fileName;
                } elseif (isset($row['stabilityAttachment_path'])) {
                    $samplePlanningData[$key]['stabilityAttachment_path'] = $row['stabilityAttachment_path'];
                }

                if (!empty($row['supervisorAttach'])) {
                    $file = $row['supervisorAttach'];
                    $fileName = "SM" . '_supervisorAttach_' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('upload'), $fileName);
                    $samplePlanningData[$key]['supervisorAttach_path'] = 'uploads/' . $fileName;
                } elseif (isset($row['supervisorAttach_path'])) {
                    $samplePlanningData[$key]['supervisorAttach_path'] = $row['supervisorAttach_path'];
                }

                if (!empty($row['QAsupervisorAttach'])) {
                    $file = $row['QAsupervisorAttach'];
                    $fileName = "SM" . '_QAsupervisorAttach_' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('upload'), $fileName);
                    $samplePlanningData[$key]['QAsupervisorAttach_path'] = 'uploads/' . $fileName;
                } elseif (isset($row['QAsupervisorAttach_path'])) {
                    $samplePlanningData[$key]['QAsupervisorAttach_path'] = $row['QAsupervisorAttach_path'];
                }
            }
        }

        $auditorsNew->data = $samplePlanningData;
        $auditorsNew->save();

        if ($lastsamplePlanning->short_description != $samplePlanning->short_description || !empty ($request->comment)) {

            $history = new SamplingStabilityAuditTrail;
            $history->ss_id = $id;
            $history->activity_type = 'Short Description';
            $history->previous = $lastsamplePlanning->short_description;
            $history->current = $samplePlanning->short_description;
            $history->comment = $samplePlanning->submit_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastsamplePlanning->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastsamplePlanning->status;

            if (is_null($lastsamplePlanning->short_description) || $lastsamplePlanning->short_description === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }
        return back();
    }



    public function sendStage(Request $request, $id){
        if ($request->username == Auth::user()->Username && Hash::check($request->password, Auth::user()->password)) {
            $samplePlanning = SampleStability::find($id);
            $lastDocument = SampleStability::find($id);
            if ($samplePlanning->stage == 1) {
                $samplePlanning->stage = "2";
                $samplePlanning->status = "Pending Analysis";
                $samplePlanning->submitted_by = Auth::user()->name;
                $samplePlanning->submitted_on = Carbon::now()->format('d-M-Y');
                $samplePlanning->submitted_comment = $request->comments;

                $history = new SamplingStabilityAuditTrail();
                $history->ss_id = $id;
                $history->activity_type = 'Sample Registration By, Sample Registration On';
                if (is_null($lastDocument->submitted_by) || $lastDocument->submitted_by === '') {
                    $history->previous = "Null";
                } else {
                    $history->previous = $lastDocument->submitted_by . ' , ' . $lastDocument->submitted_on;
                }
                $history->current = $samplePlanning->submitted_by . ' , ' . $samplePlanning->submitted_on;
                $history->action='Sample Registration';
                $history->comment = $request->comments;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to = "Pending Analysis";
                $history->change_from = $lastDocument->status;
                $history->stage = 'Plan Proposed';
                if (is_null($lastDocument->submitted_by) || $lastDocument->submitted_by === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->save();

                $samplePlanning->update();
                toastr()->success('Sent to Pending Analysis');
                return back();
            }
            if ($samplePlanning->stage == 2) {
                $samplePlanning->stage = "3";
                $samplePlanning->status = "Pending Supervisor Review";
                $samplePlanning->analysis_complete_by = Auth::user()->name;
                $samplePlanning->analysis_complete_on = Carbon::now()->format('d-M-Y');
                $samplePlanning->analysis_complete_comment = $request->comments;

                $history = new SamplingStabilityAuditTrail();
                $history->ss_id = $id;
                $history->activity_type = 'Analysis Complete By, Analysis Complete On';
                if (is_null($lastDocument->analysis_complete_by) || $lastDocument->analysis_complete_by === '') {
                    $history->previous = "Null";
                } else {
                    $history->previous = $lastDocument->analysis_complete_by . ' , ' . $lastDocument->analysis_complete_on;
                }
                $history->current = $samplePlanning->analysis_complete_by . ' , ' . $samplePlanning->analysis_complete_on;
                $history->action='Analysis Complete';
                $history->comment = $request->comments;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to = "Pending Supervisor Review";
                $history->change_from = $lastDocument->status;
                $history->stage = 'Plan Proposed';
                if (is_null($lastDocument->analysis_complete_by) || $lastDocument->analysis_complete_by === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->save();

                $samplePlanning->update();
                toastr()->success('Sent to Pending Supervisor Review');
                return back();
            }
            if ($samplePlanning->stage == 3) {
                $samplePlanning->stage = "4";
                $samplePlanning->status = "Pending QA Review";
                $samplePlanning->supervisor_review_complete_by = Auth::user()->name;
                $samplePlanning->supervisor_review_complete_on = Carbon::now()->format('d-M-Y');
                $samplePlanning->supervisor_review_complete_comment = $request->comments;

                $history = new SamplingStabilityAuditTrail();
                $history->ss_id = $id;
                $history->activity_type = 'Supervisor Review Complete By, Supervisor Review Complete On';
                if (is_null($lastDocument->supervisor_review_complete_by) || $lastDocument->supervisor_review_complete_by === '') {
                    $history->previous = "Null";
                } else {
                    $history->previous = $lastDocument->supervisor_review_complete_by . ' , ' . $lastDocument->supervisor_review_complete_on;
                }
                $history->current = $samplePlanning->supervisor_review_complete_by . ' , ' . $samplePlanning->supervisor_review_complete_on;
                $history->action='Supervisor Review Complete';
                $history->comment = $request->comments;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to = "Pending QA Review";
                $history->change_from = $lastDocument->status;
                $history->stage = 'Plan Proposed';
                if (is_null($lastDocument->supervisor_review_complete_by) || $lastDocument->supervisor_review_complete_by === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->save();

                $samplePlanning->update();
                toastr()->success('Sent to Pending QA Review');
                return back();
            }
            if ($samplePlanning->stage == 4) {
                $samplePlanning->stage = "5";
                $samplePlanning->status = "Closed - Done";
                $samplePlanning->closed_done_by = Auth::user()->name;
                $samplePlanning->closed_done_on = Carbon::now()->format('d-M-Y');
                $samplePlanning->closed_done_comment = $request->comments;

                $history = new SamplingStabilityAuditTrail();
                $history->ss_id = $id;
                $history->activity_type = 'QA Review Complete By, QA Review Complete On';
                if (is_null($lastDocument->closed_done_by) || $lastDocument->closed_done_by === '') {
                    $history->previous = "Null";
                } else {
                    $history->previous = $lastDocument->closed_done_by . ' , ' . $lastDocument->closed_done_on;
                }
                $history->current = $samplePlanning->closed_done_by . ' , ' . $samplePlanning->closed_done_on;
                $history->action='QA Review Complete';
                $history->comment = $request->comments;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to = "Closed - Done";
                $history->change_from = $lastDocument->status;
                $history->stage = 'Plan Proposed';
                if (is_null($lastDocument->closed_done_by) || $lastDocument->closed_done_by === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->save();

                $samplePlanning->update();


                toastr()->success('Sent to Closed - Done');
                return back();
            }
        } else {
            toastr()->error('E-signature Not match');
            return back();
        }
    }

    public function rejectStage(Request $request, $id){
        if ($request->username == Auth::user()->Username && Hash::check($request->password, Auth::user()->password)) {
            $samplePlanning = SampleStability::find($id);
            $lastDocument = SampleStability::find($id);
            if ($samplePlanning->stage == 4) {
                $samplePlanning->stage = "3";
                $samplePlanning->status = "Pending Supervisor Review";
                $samplePlanning->pendingQAToPendingSupervisor_by = Auth::user()->name;
                $samplePlanning->pendingQAToPendingSupervisor_on = Carbon::now()->format('d-M-Y');
                $samplePlanning->pendingQAToPendingSupervisor_comment = $request->comments;

                $history = new SamplingStabilityAuditTrail();
                $history->ss_id = $id;
                $history->activity_type = 'More Info. Required By, More Info. Required On';
                if (is_null($lastDocument->pendingQAToPendingSupervisor_by) || $lastDocument->pendingQAToPendingSupervisor_by === '') {
                    $history->previous = "Null";
                } else {
                    $history->previous = $lastDocument->pendingQAToPendingSupervisor_by . ' , ' . $lastDocument->pendingQAToPendingSupervisor_on;
                }
                $history->current = $samplePlanning->pendingQAToPendingSupervisor_by . ' , ' . $samplePlanning->pendingQAToPendingSupervisor_on;
                $history->action='More Info. Required';
                $history->comment = $request->comments;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to = "Pending Supervisor Review";
                $history->change_from = $lastDocument->status;
                $history->stage = 'Plan Proposed';
                if (is_null($lastDocument->pendingQAToPendingSupervisor_by) || $lastDocument->pendingQAToPendingSupervisor_by === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->save();

                $samplePlanning->update();
                toastr()->success('Sent to Pending Supervisor Review');
                return back();
            }
            if ($samplePlanning->stage == 3) {
                $samplePlanning->stage = "2";
                $samplePlanning->status = "Pending Analysis";
                $samplePlanning->pendingSupervisorToPendingAnalysis_by = Auth::user()->name;
                $samplePlanning->pendingSupervisorToPendingAnalysis_on = Carbon::now()->format('d-M-Y');
                $samplePlanning->pendingSupervisorToPendingAnalysis_comment = $request->comments;

                $history = new SamplingStabilityAuditTrail();
                $history->ss_id = $id;
                $history->activity_type = 'More Info. Required By, More Info. Required On';
                if (is_null($lastDocument->pendingSupervisorToPendingAnalysis_by) || $lastDocument->pendingSupervisorToPendingAnalysis_by === '') {
                    $history->previous = "Null";
                } else {
                    $history->previous = $lastDocument->pendingSupervisorToPendingAnalysis_by . ' , ' . $lastDocument->pendingSupervisorToPendingAnalysis_on;
                }
                $history->current = $samplePlanning->pendingSupervisorToPendingAnalysis_by . ' , ' . $samplePlanning->pendingSupervisorToPendingAnalysis_on;
                $history->action='More Info. Required';
                $history->comment = $request->comments;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to = "Pending Analysis";
                $history->change_from = $lastDocument->status;
                $history->stage = 'Plan Proposed';
                if (is_null($lastDocument->pendingSupervisorToPendingAnalysis_by) || $lastDocument->pendingSupervisorToPendingAnalysis_by === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->save();

                $samplePlanning->update();
                toastr()->success('Sent to Pending Analysis');
                return back();
            }
            if ($samplePlanning->stage == 2) {
                $samplePlanning->stage = "1";
                $samplePlanning->status = "Opened";
                $samplePlanning->pendingAnalysisToOpened_by = Auth::user()->name;
                $samplePlanning->pendingAnalysisToOpened_on = Carbon::now()->format('d-M-Y');
                $samplePlanning->pendingAnalysisToOpened_comment = $request->comments;

                $history = new SamplingStabilityAuditTrail();
                $history->ss_id = $id;
                $history->activity_type = 'More Info. Required By, More Info. Required On';
                if (is_null($lastDocument->pendingAnalysisToOpened_by) || $lastDocument->pendingAnalysisToOpened_by === '') {
                    $history->previous = "Null";
                } else {
                    $history->previous = $lastDocument->pendingAnalysisToOpened_by . ' , ' . $lastDocument->pendingAnalysisToOpened_on;
                }
                $history->current = $samplePlanning->pendingAnalysisToOpened_by . ' , ' . $samplePlanning->pendingAnalysisToOpened_on;
                $history->action='More Info. Required';
                $history->comment = $request->comments;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to = "Opened";
                $history->change_from = $lastDocument->status;
                $history->stage = 'Plan Proposed';
                if (is_null($lastDocument->pendingAnalysisToOpened_by) || $lastDocument->pendingAnalysisToOpened_by === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->save();

                $samplePlanning->update();
                toastr()->success('Sent to Opened');
                return back();
            }
        } else {
            toastr()->error('E-signature Not match');
            return back();
        }
    }

    public function auditTrial($id)
    {
        $audit = SamplingStabilityAuditTrail::where('ss_id', $id)->orderByDESC('id')->paginate(5);
        $today = Carbon::now()->format('d-m-y');
        $document = SampleStability::where('id', $id)->first();
        $document->originator = User::where('id', $document->initiator_id)->value('name');

        $users = User::all();
        return view('frontend.sample-planning.audit-trail', compact('audit', 'document', 'today','users'));
    }

    
    public function audit_pdf($id)
    {
        $doc = SamplingStabilityAuditTrail::find($id);
        
        if (!empty($doc)) {
            $doc->originator = User::where('id', $doc->initiator_id)->value('name');
        }
        $data = SamplingStabilityAuditTrail::where('ss_id', $doc->id)->orderByDesc('id')->get();
        $pdf = App::make('dompdf.wrapper');
        $time = Carbon::now();
       
        $pdf = PDF::loadview('frontend.sample-planning.audit-report', compact('data', 'doc'))
            ->setOptions([
                'defaultFont' => 'sans-serif',
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'isPhpEnabled' => true,
            ]);
        $pdf->setPaper('a4', 'landscape');
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

    public static function singleReport($id)
    {
        $data = SampleStability::find($id);
        if (!empty($data)) {
            $data->originator = User::where('id', $data->initiator)->value('name');

            $users = User::all()->pluck('name', 'id')->toArray();
            $locations = DB::table('q_m_s_divisions')->pluck('name', 'id');
            $gridData = SampleStability_Grid::where(['ssgrid_id' => $id])->first();
            $certificationData = $gridData ? (is_array($gridData->data) ? $gridData->data : json_decode($gridData->data, true)) : [];

            $pdf = App::make('dompdf.wrapper');
            $time = Carbon::now();


            $pdf = PDF::loadview('frontend.sample-planning.single-report', compact('data','gridData','certificationData','users','locations'))
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
            
            return $pdf->stream('Extension' . $id . '.pdf');
        }
    }

    public function exportCsv(Request $request)
    {
     
        $query = SampleStability::query();
    
        if (!empty($request->department_sampleplanning)) {
            $query->whereIn('Initiator_Group', $request->department_sampleplanning);  // Use whereIn for multiple selections
        }

        if ($request->division_id_sampleplanning) {
            $query->where('division_id', $request->division_id_sampleplanning);
        }

        if ($request->initiator_id_sampleplanning) {
            $query->where('initiator_id', $request->initiator_id_sampleplanning);
        }

        if ($request->date_fromsampleplanning) {
            $dateFrom = Carbon::parse($request->date_fromsampleplanning)->startOfDay();
            $query->whereDate('intiation_date', '>=', $dateFrom);
        }

        if ($request->date_tosampleplanning) {
            $dateTo = Carbon::parse($request->date_tosampleplanning)->endOfDay();
            $query->whereDate('intiation_date', '<=', $dateTo);
        }

        
        if ($request->sort_column && $request->sort_order) {
            $query->orderBy($request->sort_column, $request->sort_order);
        }

        $sampleplanning = $query->get();

    
        $fileName = 'sample_planning_log.csv';
        $headers = [
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename=\"$fileName\"",
        ];
    
        $columns = [
            'Sr. No.', 'Initiation Date', 'Record No',
            'Division', 'Department Name', 'Short Description.', 'Due Date',
            'Initiator', 'Status'
        ];
    
        $callback = function () use ($sampleplanning, $columns) {
            $file = fopen('php://output', 'w');
    
            fputcsv($file, $columns);
    
            if ($sampleplanning->isEmpty()) {
                fputcsv($file, ['No records found']);
            } else {
                foreach ($sampleplanning as $index => $row) {
                    $data = [
                        $index + 1, 
                        $row->intiation_date ?? 'Not Applicable', 
                        $row->division ? $row->division->name . '/CC/' . date('Y') . '/' . str_pad($row->record, 4, '0', STR_PAD_LEFT) : 'Not Applicable',
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
        $query = SampleStability::query();
    
        if (!empty($request->department_sampleplanning)) {
            $query->whereIn('Initiator_Group', $request->department_sampleplanning);  // Use whereIn for multiple selections
        }

        if ($request->division_id_sampleplanning) {
            $query->where('division_id', $request->division_id_sampleplanning);
        }

        if ($request->initiator_id_sampleplanning) {
            $query->where('initiator_id', $request->initiator_id_sampleplanning);
        }

        if ($request->date_fromsampleplanning) {
            $dateFrom = Carbon::parse($request->date_fromsampleplanning)->startOfDay();
            $query->whereDate('intiation_date', '>=', $dateFrom);
        }

        if ($request->date_tosampleplanning) {
            $dateTo = Carbon::parse($request->date_tosampleplanning)->endOfDay();
            $query->whereDate('intiation_date', '<=', $dateTo);
        }

        
        if ($request->sort_column && $request->sort_order) {
            $query->orderBy($request->sort_column, $request->sort_order);
        }

        $sampleplanning = $query->get();

        $fileName = "sample_planning_log.xls";
    
        $headers = [
            "Content-Type" => "application/vnd.ms-excel",
            "Content-Disposition" => "attachment; filename=\"$fileName\"",
        ];
    
        $columns = [
            'Sr. No.', 'Initiation Date', 'Record No',
            'Division', 'Department Name', 'Short Description.', 'Due Date',
            'Initiator', 'Status'
        ];
    
        $callback = function () use ($sampleplanning, $columns) {
            echo '<table border="1">';
    
            echo '<tr style="font-weight: bold; background-color: #1F4E79; color: #FFFFFF;">';
            foreach ($columns as $column) {
                echo "<th style='padding: 5px;'>" . htmlspecialchars($column) . "</th>";
            }
            echo '</tr>';
    
            if ($sampleplanning->isEmpty()) {
                echo '<tr>';
                echo "<td colspan='" . count($columns) . "' style='text-align: center;'>No records found</td>";
                echo '</tr>';
            } else {
                foreach ($sampleplanning as $index => $row) {
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

    public function samplePlanningChild(Request $request, $id)
    {
        $samplePlanning = SampleStability::find($id);
        $parent_id = $id;
        $parent_name = "StabilityManagement";
        $parent_type = "StabilityManagement";
        $record_number = ((RecordNumber::first()->value('counter')) + 1);
        $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
        $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $due_date = $formattedDate->format('d-M-Y');

        $parent_data = SampleStability::where('id', $id)->select('record', 'division_id', 'initiator_id', 'short_description')->first();
        $parent_data1 = SampleStability::select('record', 'division_id', 'initiator_id', 'id')->get();
        $parent_record = SampleStability::where('id', $id)->value('record');
        $parent_record = str_pad($parent_record, 4, '0', STR_PAD_LEFT);
        $parent_division_id = SampleStability::where('id', $id)->value('division_id');
        $parent_initiator_id = SampleStability::where('id', $id)->value('initiator_id');
        $parent_intiation_date = SampleStability::where('id', $id)->value('intiation_date');
        $parent_short_description = SampleStability::where('id', $id)->value('short_description');
        $old_record = SampleStability::select('id', 'division_id', 'record')->get();
          
        if ($request->revision == "action-item") {
            $record = ((RecordNumber::first()->value('counter')) + 1);
            $record = str_pad($record, 4, '0', STR_PAD_LEFT);
            $samplePlanning->originator = User::where('id', $samplePlanning->initiator_id)->value('name');
            return view('frontend.action-item.action-item', compact('parent_record','record','parent_id', 'parent_name', 'record_number', 'samplePlanning', 'parent_data', 'parent_data1', 'parent_short_description', 'parent_initiator_id', 'parent_intiation_date', 'parent_division_id', 'due_date', 'old_record', 'parent_type'));
        }
        if ($request->revision == "RCA") {
            $samplePlanning->originator = User::where('id', $samplePlanning->initiator_id)->value('name');
            return view('frontend.forms.root-cause-analysis', compact('parent_record','parent_type','parent_id', 'parent_name', 'record_number', 'samplePlanning', 'parent_data', 'parent_data1', 'parent_short_description', 'parent_initiator_id', 'parent_intiation_date', 'parent_division_id', 'due_date', 'old_record'));
        }
        if ($request->revision == "OOS-OOT") {
            $samplePlanning->originator = User::where('id', $samplePlanning->initiator_id)->value('name');
            return view('frontend.OOS.oos_form', compact('parent_record','parent_type','parent_id', 'parent_name', 'record_number', 'samplePlanning', 'parent_data', 'parent_data1', 'parent_short_description', 'parent_initiator_id', 'parent_intiation_date', 'parent_division_id', 'due_date', 'old_record'));
        }
        if ($request->revision == "CAPA") {
            $old_records = $old_record;
            $samplePlanning->originator = User::where('id', $samplePlanning->initiator_id)->value('name');
            return view('frontend.forms.capa', compact('parent_record','parent_id','parent_type', 'parent_name', 'record_number', 'samplePlanning', 'parent_data', 'parent_data1', 'parent_short_description', 'parent_initiator_id', 'parent_intiation_date', 'parent_division_id', 'due_date', 'old_records'));
        }
        if ($request->revision == "lab-incident") {
            $samplePlanning->originator = User::where('id', $samplePlanning->initiator_id)->value('name');
            return view('frontend.forms.lab-incident', compact('parent_name', 'parent_type', 'parent_id', 'record_number', 'parent_short_description', 'parent_initiator_id', 'parent_intiation_date', 'parent_division_id', 'parent_record', 'samplePlanning'));
        }
        else{
            toastr()->warning('Not Working');
            return back();
        }
    }
}
