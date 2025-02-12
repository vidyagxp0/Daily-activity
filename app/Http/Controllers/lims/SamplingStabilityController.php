<?php

namespace App\Http\Controllers\lims;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\OpenStage;
use Illuminate\Support\Facades\App;
use PDF;
use App\Models\RoleGroup;
use Helpers;
use App\Models\User;
use App\Models\SampleStability_Grid;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use App\Models\RecordNumber;
use App\Models\SampleStability;
use App\Models\SamplingStabilityAuditTrail;
use Carbon\Carbon;

class SamplingStabilityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $record_number = ((RecordNumber::first()->value('counter')) + 1);
        $record_numbers = str_pad($record_number, 4, '0', STR_PAD_LEFT);
        $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $due_date = $formattedDate->format('d-M-Y');

        return view('frontend.sampling-stability.new_sampling_stability', compact('formattedDate', 'due_date', 'record_numbers'));  //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $sample = new SampleStability();
        $sample->record = $request->record;
        // dd($sample->record);
        $sample->form_type =  "Sampling Stability";
        $sample->division_id = $request->division_id;
        $sample->initiator_id = $request->initiator_id;
        $sample->division_code = $request->division_code;
        $sample->intiation_date = $request->intiation_date;
        $sample->due_date = $request->due_date;
        $sample->parent_id = $request->parent_id;
        $sample->parent_type = $request->parent_type;
        $sample->short_desc = $request->short_desc;
        $sample->Initiator_Group = $request->Initiator_Group;
        $sample->initiator_group_code = $request->initiator_group_code;
        $sample->assign_to = $request->assign_to;
        $sample->samplePlanId = $request->samplePlanId;
        $sample->sampleId = $request->sampleId;
        $sample->sampleName = $request->sampleName;
        $sample->sampleType = $request->sampleType;
        $sample->productMaterialName = $request->productMaterialName;
        $sample->batchLotNumber = $request->batchLotNumber;
        $sample->samplePriority = $request->samplePriority;
        $sample->sampleQuantity = $request->sampleQuantity;
        $sample->UOM = $request->UOM;
        $sample->market = $request->market;
        $sample->sampleBarCode = $request->sampleBarCode;
        $sample->specificationId = $request->specificationId;
        # $sample->specification_attachment = $request->specification_attachment;
        $sample->stpId = $request->stpId;
        $sample->stp_attachment = $request->stp_attachment;
        $sample->testName = $request->testName;
        $sample->testMethod = $request->testMethod;
        $sample->testParameter = $request->testParameter;
        $sample->testingFrequency = $request->testingFrequency;
        $sample->testingLocation = $request->testingLocation;
        $sample->requiredInstrument = $request->requiredInstrument;
        $sample->testGrouping = $request->testGrouping;
        $sample->lsl = $request->lsl;
        $sample->usl = $request->usl;
        $sample->labTechnician = $request->labTechnician;
        $sample->sampleCostEstimation = $request->sampleCostEstimation;
        $sample->resourceUtilization = $request->resourceUtilization;
        $sample->assignedDepartment = $request->assignedDepartment;
        $sample->testGrouping_ii = $request->testGrouping_ii;
        $sample->sampleCollectionDate = $request->sampleCollectionDate;
        // $sample->suupportive_attachment_gi = $request->suupportive_attachment_gi;
        $sample->analysisType = $request->analysisType;
        $sample->analysisResult = $request->analysisResult;
        $sample->analysisDate = $request->analysisDate;
        $sample->testingStartDate = $request->testingStartDate;
        $sample->testingEndDate = $request->testingEndDate;
        $sample->delayJustification = $request->delayJustification;
        $sample->testingOutCome = $request->testingOutCome;
        $sample->passFail = $request->passFail;
        $sample->testPlanId = $request->testPlanId;
        $sample->turnAroundTime = $request->turnAroundTime;
        $sample->sampleRetestingDate = $request->sampleRetestingDate;
        $sample->reviewDate = $request->reviewDate;
        $sample->sampleStorageLocation = $request->sampleStorageLocation;
        $sample->transportationMethod = $request->transportationMethod;
        $sample->samplePreparationMethod = $request->samplePreparationMethod;
        $sample->samplePackagingDetail = $request->samplePackagingDetail;
        $sample->sampleLabel = $request->sampleLabel;
        $sample->regulatoryRequirement = $request->regulatoryRequirement;
        $sample->qualityControlCheck = $request->qualityControlCheck;
        $sample->controlSampleReference = $request->controlSampleReference;
        $sample->referencesample = $request->referencesample;
        $sample->controlSample = $request->controlSample;
        $sample->sampleIntegrityStatus = $request->sampleIntegrityStatus;
        $sample->assignedDepartmentII = $request->assignedDepartmentII;
        $sample->assignedDepartment = $request->assignedDepartment;
        $sample->riskAssessment = $request->riskAssessment;
        $sample->supervisor = $request->supervisor;
        $sample->instruments_reserved = $request->instruments_reserved;
        $sample->lab_availability = $request->lab_availability;
        $sample->sample_date = $request->sample_date;
        $sample->sample_movement_history = $request->sample_movement_history;
        $sample->testing_progress = $request->testing_progress;
        $sample->deviation_logs = $request->deviation_logs;
        $sample->commentNotes = $request->commentNotes;
        // $sample->analysis_attachment = $request->analysis_attachment;
        $sample->samplingFrequency = $request->samplingFrequency;
        $sample->sampleDisposition = $request->sampleDisposition;
        // $sample->supportive_attachment = $request->supportive_attachment;
        $sample->reviewerApprover = $request->reviewerApprover;
        $sample->reviewerComment = $request->reviewerComment;
        $sample->reviewDate = $request->reviewDate;
        $sample->stabilityStudyType = $request->stabilityStudyType;
        $sample->selectDisposition = $request->selectDisposition;
        // $sample->stabilityStudyProtocol = $request->stabilityStudyProtocol;
        $sample->protocolApprovalDate = $request->protocolApprovalDate;
        $sample->regulatoryCountry = $request->regulatoryCountry;
        $sample->ichZone = $request->ichZone;
        $sample->photostabilityResults = $request->photostabilityResults;
        $sample->reconstitutionStability = $request->reconstitutionStability;
        $sample->testingInterval = $request->testingInterval;
        $sample->shelfLife = $request->shelfLife;
        // $sample->supportiveAttachment = $request->supportiveAttachment;
        $sample->qaReviewerApprover = $request->qaReviewerApprover;
        $sample->qaReviewDate = $request->qaReviewDate;
        $sample->qaReviewerComment = $request->qaReviewerComment;
        $sample->initiatorName = $request->initiatorName;
        $sample->dateOfInitiation = $request->dateOfInitiation;
        $sample->labTechnicianName = $request->labTechnicianName;
        $sample->dateOfLabTechReview = $request->dateOfLabTechReview;
        $sample->supervisorName = $request->supervisorName;
        $sample->dateOfSupervisionReview = $request->dateOfSupervisionReview;
        $sample->qaReview = $request->qaReview;
        $sample->dateOfQaReview = $request->dateOfQaReview;

        $sample->status = 'Opened';
        $sample->stage = 1;

        // Attachments specification_attachment 
        if (!empty($request->specification_attachment)) {
            $files = [];
            if ($request->hasfile('specification_attachment')) {
                foreach ($request->file('specification_attachment') as $file) {
                    $name = $request->name . 'specification_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $sample->specification_attachment = json_encode($files);
        }


                // Attachments Supportive Attachment 
                if (!empty($request->suupportive_attachment_gi)) {
                    $files = [];
                    if ($request->hasfile('suupportive_attachment_gi')) {
                        foreach ($request->file('suupportive_attachment_gi') as $file) {
                            $name = $request->name . 'suupportive_attachment_gi' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                            $file->move('upload/', $name);
                            $files[] = $name;
                        }
                    }
                    $sample->suupportive_attachment_gi = json_encode($files);
                }


                if (!empty($request->analysis_attachment)) {
                    $files = [];
                    if ($request->hasfile('analysis_attachment')) {
                        foreach ($request->file('analysis_attachment') as $file) {
                            $name = $request->name . 'analysis_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                            $file->move('upload/', $name);
                            $files[] = $name;
                        }
                    }
                    $sample->analysis_attachment = json_encode($files);
                }

                
                // dd($sample->analysis_attachment);
                
                
                if (!empty($request->supportive_attachment)) {
                    $files = [];
                    if ($request->hasfile('supportive_attachment')) {
                        foreach ($request->file('supportive_attachment') as $file) {
                            $name = $request->name . 'supportive_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                            $file->move('upload/', $name);
                            $files[] = $name;
                        }
                    }
                    $sample->supportive_attachment = json_encode($files);
                }

                if (!empty($request->supportiveAttachment)) {
                    $files = [];
                    if ($request->hasfile('supportiveAttachment')) {
                        foreach ($request->file('supportiveAttachment') as $file) {
                            $name = $request->name . 'supportiveAttachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                            $file->move('upload/', $name);
                            $files[] = $name;
                        }
                    }
                    $sample->supportiveAttachment = json_encode($files);
                }

                if (!empty($request->stabilityStudyProtocol)) {
                    $files = [];
                    if ($request->hasfile('stabilityStudyProtocol')) {
                        foreach ($request->file('stabilityStudyProtocol') as $file) {
                            $name = $request->name . 'stabilityStudyProtocol' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                            $file->move('upload/', $name);
                            $files[] = $name;
                        }
                    }
                    $sample->stabilityStudyProtocol = json_encode($files);
                }

                if (!empty($request->supportiveAttachmentsss)) {
                    $files = [];
                    if ($request->hasfile('supportiveAttachmentsss')) {
                        foreach ($request->file('supportiveAttachmentsss') as $file) {
                            $name = $request->name . 'supportiveAttachmentsss' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                            $file->move('upload/', $name);
                            $files[] = $name;
                        }
                    }
                    $sample->supportiveAttachmentsss = json_encode($files);
                }



                if (!empty($request->qa_supportive_attachment)) {
                    $files = [];
                    if ($request->hasfile('qa_supportive_attachment')) {
                        foreach ($request->file('qa_supportive_attachment') as $file) {
                            $name = $request->name . 'qa_supportive_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                            $file->move('upload/', $name);
                            $files[] = $name;
                        }
                    }
                    $sample->qa_supportive_attachment = json_encode($files);
                }
               
                $record = RecordNumber::first();
                $record->counter = ((RecordNumber::first()->value('counter')) + 1);
                $record->update();

                $sample->save();


                if(!empty($sample->record)){
                    $history = new SamplingStabilityAuditTrail();
                    $history->ss_id = $sample->id;
                    $history->activity_type = 'Record Number';
                    $history->previous = "Null";
                    $history->current = Helpers::getDivisionName(session()->get('division')) . "/SS/" . date('Y') . "/" . str_pad($sample->record, 4, '0', STR_PAD_LEFT);
                    $history->comment = "Not Applicable";
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $sample->status;
                    $history->change_to = "Opened";
                    $history->change_from = "Null";
                    $history->action_name = 'Create';
                    $history->save();
                }

                if(!empty($sample->division_code)){
                    $history = new SamplingStabilityAuditTrail();
                    $history->ss_id = $sample->id;
                    $history->activity_type = 'Site/Location Code';
                    $history->previous = "Null";
                    $history->current = $request->division_code;
                    $history->comment = "Not Applicable";
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $sample->status;
                    $history->change_to = "Opened";
                    $history->change_from = "Null";
                    $history->action_name = 'Create'; 
                    $history->save();
                }

                if(!empty($sample->originator_id)){
                    $history = new SamplingStabilityAuditTrail();
                    $history->ss_id = $sample->id;
                    $history->activity_type = 'Initiator';
                    $history->previous = "Null";
                    $history->current = Auth::user()->name;
                    $history->comment = "Not Applicable";
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $sample->status;
                    $history->change_to = "Opened";
                    $history->change_from = "Null";
                    $history->action_name = 'Create'; 
                    $history->save();
                }

                if(!empty($sample->intiation_date)){
                    $history = new SamplingStabilityAuditTrail();
                    $history->ss_id = $sample->id;
                    $history->activity_type = 'Date of Initiation';
                    $history->previous = "Null";
                    $history->current = Helpers::getdateFormat($request->intiation_date);
                    $history->comment = "Not Applicable";
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $sample->status;
                    $history->change_to = "Opened";
                    $history->change_from = "Null";
                    $history->action_name = 'Create'; 
                    $history->save();
                }

                if(!empty($sample->due_date)){
                    $history = new SamplingStabilityAuditTrail();
                    $history->ss_id = $sample->id;
                    $history->activity_type = 'Due Date';
                    $history->previous = "Null";
                    $history->current = Helpers::getdateFormat($request->due_date);
                    $history->comment = "Not Applicable";
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $sample->status;
                    $history->change_to = "Opened";
                    $history->change_from = "Null";
                    $history->action_name = 'Create'; 
                    $history->save();
                }

                if(!empty($sample->Initiator_Group)){
                    $history = new SamplingStabilityAuditTrail();
                    $history->ss_id = $sample->id;
                    $history->activity_type = 'Initiator Group';
                    $history->previous = "Null";
                    $history->current = Helpers::getInitiatorGroupFullName($request->Initiator_Group);
                    $history->comment = "Not Applicable";
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $sample->status;
                    $history->change_to = "Opened";
                    $history->change_from = "Null";
                    $history->action_name = 'Create'; 
                    $history->save();
                }

                if(!empty($sample->initiator_group_code)){
                    $history = new SamplingStabilityAuditTrail();
                    $history->ss_id = $sample->id;
                    $history->activity_type = 'Initiator Group Code';
                    $history->previous = "Null";
                    $history->current = $request->initiator_group_code;
                    $history->comment = "Not Applicable";
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $sample->status;
                    $history->change_to = "Opened";
                    $history->change_from = "Null";
                    $history->action_name = 'Create'; 
                    $history->save();
                }

                if(!empty($sample->short_desc)){
                    $history = new SamplingStabilityAuditTrail();
                    $history->ss_id = $sample->id;
                    $history->activity_type = 'Short Description';
                    $history->previous = "Null";
                    $history->current = $request->short_desc;
                    $history->comment = "Not Applicable";
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $sample->status;
                    $history->change_to = "Opened";
                    $history->change_from = "Null";
                    $history->action_name = 'Create'; 
                    $history->save();
                }

                if(!empty($sample->samplePlanId)){
                    $history = new SamplingStabilityAuditTrail();
                    $history->ss_id = $sample->id;
                    $history->activity_type = 'Sample Plan ID';
                    $history->previous = "Null";
                    $history->current = $request->samplePlanId;
                    $history->comment = "Not Applicable";
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $sample->status;
                    $history->change_to = "Opened";
                    $history->change_from = "Null";
                    $history->action_name = 'Create'; 
                    $history->save();
                }

                if(!empty($sample->sampleId)){
                    $history = new SamplingStabilityAuditTrail();
                    $history->ss_id = $sample->id;
                    $history->activity_type = 'Sample ID';
                    $history->previous = "Null";
                    $history->current = $request->sampleId;
                    $history->comment = "Not Applicable";
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $sample->status;
                    $history->change_to = "Opened";
                    $history->change_from = "Null";
                    $history->action_name = 'Create'; 
                    $history->save();
                }

                if(!empty($sample->sampleName)){
                    $history = new SamplingStabilityAuditTrail();
                    $history->ss_id = $sample->id;
                    $history->activity_type = 'Sample Name';
                    $history->previous = "Null";
                    $history->current = $request->sampleName;
                    $history->comment = "Not Applicable";
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $sample->status;
                    $history->change_to = "Opened";
                    $history->change_from = "Null";
                    $history->action_name = 'Create'; 
                    $history->save();
                }

                if(!empty($sample->sampleType)){
                    $history = new SamplingStabilityAuditTrail();
                    $history->ss_id = $sample->id;
                    $history->activity_type = 'Sample Type';
                    $history->previous = "Null";
                    $history->current = $request->sampleType;
                    $history->comment = "Not Applicable";
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $sample->status;
                    $history->change_to = "Opened";
                    $history->change_from = "Null";
                    $history->action_name = 'Create'; 
                    $history->save();
                }

                if(!empty($sample->productMaterialName)){
                    $history = new SamplingStabilityAuditTrail();
                    $history->ss_id = $sample->id;
                    $history->activity_type = 'Product / Material Name';
                    $history->previous = "Null";
                    $history->current = $request->productMaterialName;
                    $history->comment = "Not Applicable";
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $sample->status;
                    $history->change_to = "Opened";
                    $history->change_from = "Null";
                    $history->action_name = 'Create'; 
                    $history->save();
                }

                if(!empty($sample->batchLotNumber)){
                    $history = new SamplingStabilityAuditTrail();
                    $history->ss_id = $sample->id;
                    $history->activity_type = 'Batch/Lot Number';
                    $history->previous = "Null";
                    $history->current = $request->batchLotNumber;
                    $history->comment = "Not Applicable";
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $sample->status;
                    $history->change_to = "Opened";
                    $history->change_from = "Null";
                    $history->action_name = 'Create'; 
                    $history->save();
                }

                if(!empty($sample->samplePriority)){
                    $history = new SamplingStabilityAuditTrail();
                    $history->ss_id = $sample->id;
                    $history->activity_type = 'Sample Priority';
                    $history->previous = "Null";
                    $history->current = $request->samplePriority;
                    $history->comment = "Not Applicable";
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $sample->status;
                    $history->change_to = "Opened";
                    $history->change_from = "Null";
                    $history->action_name = 'Create'; 
                    $history->save();
                }

                if(!empty($sample->sampleQuantity)){
                    $history = new SamplingStabilityAuditTrail();
                    $history->ss_id = $sample->id;
                    $history->activity_type = 'Sample Quantity';
                    $history->previous = "Null";
                    $history->current = $request->sampleQuantity;
                    $history->comment = "Not Applicable";
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $sample->status;
                    $history->change_to = "Opened";
                    $history->change_from = "Null";
                    $history->action_name = 'Create'; 
                    $history->save();
                }

                if(!empty($sample->UOM)){
                    $history = new SamplingStabilityAuditTrail();
                    $history->ss_id = $sample->id;
                    $history->activity_type = 'UOM';
                    $history->previous = "Null";
                    $history->current = $request->UOM;
                    $history->comment = "Not Applicable";
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $sample->status;
                    $history->change_to = "Opened";
                    $history->change_from = "Null";
                    $history->action_name = 'Create'; 
                    $history->save();
                }

                if(!empty($sample->market)){
                    $history = new SamplingStabilityAuditTrail();
                    $history->ss_id = $sample->id;
                    $history->activity_type = 'Market';
                    $history->previous = "Null";
                    $history->current = $request->market;
                    $history->comment = "Not Applicable";
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $sample->status;
                    $history->change_to = "Opened";
                    $history->change_from = "Null";
                    $history->action_name = 'Create'; 
                    $history->save();
                }

                if(!empty($sample->sampleBarCode)){
                    $history = new SamplingStabilityAuditTrail();
                    $history->ss_id = $sample->id;
                    $history->activity_type = 'Sample Barcode';
                    $history->previous = "Null";
                    $history->current = $request->sampleBarCode;
                    $history->comment = "Not Applicable";
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $sample->status;
                    $history->change_to = "Opened";
                    $history->change_from = "Null";
                    $history->action_name = 'Create'; 
                    $history->save();
                }

                if(!empty($sample->specificationId)){
                    $history = new SamplingStabilityAuditTrail();
                    $history->ss_id = $sample->id;
                    $history->activity_type = 'Specification Id';
                    $history->previous = "Null";
                    $history->current = $request->specificationId;
                    $history->comment = "Not Applicable";
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $sample->status;
                    $history->change_to = "Opened";
                    $history->change_from = "Null";
                    $history->action_name = 'Create'; 
                    $history->save();
                }

                if(!empty($sample->stpId)){
                    $history = new SamplingStabilityAuditTrail();
                    $history->ss_id = $sample->id;
                    $history->activity_type = 'STP Id';
                    $history->previous = "Null";
                    $history->current = $request->stpId;
                    $history->comment = "Not Applicable";
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $sample->status;
                    $history->change_to = "Opened";
                    $history->change_from = "Null";
                    $history->action_name = 'Create'; 
                    $history->save();
                }

                if(!empty($sample->testName)){
                    $history = new SamplingStabilityAuditTrail();
                    $history->ss_id = $sample->id;
                    $history->activity_type = 'Test Name';
                    $history->previous = "Null";
                    $history->current = $request->testName;
                    $history->comment = "Not Applicable";
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $sample->status;
                    $history->change_to = "Opened";
                    $history->change_from = "Null";
                    $history->action_name = 'Create'; 
                    $history->save();
                }

                if(!empty($sample->testMethod)){
                    $history = new SamplingStabilityAuditTrail();
                    $history->ss_id = $sample->id;
                    $history->activity_type = 'Test Method';
                    $history->previous = "Null";
                    $history->current = $request->testMethod;
                    $history->comment = "Not Applicable";
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $sample->status;
                    $history->change_to = "Opened";
                    $history->change_from = "Null";
                    $history->action_name = 'Create'; 
                    $history->save();
                }

                if(!empty($sample->testParameter)){
                    $history = new SamplingStabilityAuditTrail();
                    $history->ss_id = $sample->id;
                    $history->activity_type = 'Test Parameters';
                    $history->previous = "Null";
                    $history->current = $request->testParameter;
                    $history->comment = "Not Applicable";
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $sample->status;
                    $history->change_to = "Opened";
                    $history->change_from = "Null";
                    $history->action_name = 'Create'; 
                    $history->save();
                }

                if(!empty($sample->testingFrequency)){
                    $history = new SamplingStabilityAuditTrail();
                    $history->ss_id = $sample->id;
                    $history->activity_type = 'Testing Frequency';
                    $history->previous = "Null";
                    $history->current = $request->testingFrequency;
                    $history->comment = "Not Applicable";
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $sample->status;
                    $history->change_to = "Opened";
                    $history->change_from = "Null";
                    $history->action_name = 'Create'; 
                    $history->save();
                }

                if(!empty($sample->testingLocation)){
                    $history = new SamplingStabilityAuditTrail();
                    $history->ss_id = $sample->id;
                    $history->activity_type = 'Testing Location';
                    $history->previous = "Null";
                    $history->current = $request->testingLocation;
                    $history->comment = "Not Applicable";
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $sample->status;
                    $history->change_to = "Opened";
                    $history->change_from = "Null";
                    $history->action_name = 'Create'; 
                    $history->save();
                }

                if(!empty($sample->requiredInstrument)){
                    $history = new SamplingStabilityAuditTrail();
                    $history->ss_id = $sample->id;
                    $history->activity_type = 'Select Required Instruments';
                    $history->previous = "Null";
                    $history->current = $request->requiredInstrument;
                    $history->comment = "Not Applicable";
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $sample->status;
                    $history->change_to = "Opened";
                    $history->change_from = "Null";
                    $history->action_name = 'Create'; 
                    $history->save();
                }

                if(!empty($sample->testGrouping)){
                    $history = new SamplingStabilityAuditTrail();
                    $history->ss_id = $sample->id;
                    $history->activity_type = 'Test Grouping';
                    $history->previous = "Null";
                    $history->current = $request->testGrouping;
                    $history->comment = "Not Applicable";
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $sample->status;
                    $history->change_to = "Opened";
                    $history->change_from = "Null";
                    $history->action_name = 'Create'; 
                    $history->save();
                }

                if(!empty($sample->lsl)){
                    $history = new SamplingStabilityAuditTrail();
                    $history->ss_id = $sample->id;
                    $history->activity_type = 'LSL';
                    $history->previous = "Null";
                    $history->current = $request->lsl;
                    $history->comment = "Not Applicable";
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $sample->status;
                    $history->change_to = "Opened";
                    $history->change_from = "Null";
                    $history->action_name = 'Create'; 
                    $history->save();
                }

                if(!empty($sample->lsl)){
                    $history = new SamplingStabilityAuditTrail();
                    $history->ss_id = $sample->id;
                    $history->activity_type = 'LSL';
                    $history->previous = "Null";
                    $history->current = $request->lsl;
                    $history->comment = "Not Applicable";
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $sample->status;
                    $history->change_to = "Opened";
                    $history->change_from = "Null";
                    $history->action_name = 'Create'; 
                    $history->save();
                }

                if(!empty($sample->usl)){
                    $history = new SamplingStabilityAuditTrail();
                    $history->ss_id = $sample->id;
                    $history->activity_type = 'USL';
                    $history->previous = "Null";
                    $history->current = $request->usl;
                    $history->comment = "Not Applicable";
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $sample->status;
                    $history->change_to = "Opened";
                    $history->change_from = "Null";
                    $history->action_name = 'Create'; 
                    $history->save();
                }

                if(!empty($sample->labTechnician)){
                    $history = new SamplingStabilityAuditTrail();
                    $history->ss_id = $sample->id;
                    $history->activity_type = 'Lab Technician';
                    $history->previous = "Null";
                    $history->current = $request->labTechnician;
                    $history->comment = "Not Applicable";
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $sample->status;
                    $history->change_to = "Opened";
                    $history->change_from = "Null";
                    $history->action_name = 'Create'; 
                    $history->save();
                }

                if(!empty($sample->sampleCostEstimation)){
                    $history = new SamplingStabilityAuditTrail();
                    $history->ss_id = $sample->id;
                    $history->activity_type = 'Sample Cost Estimation';
                    $history->previous = "Null";
                    $history->current = $request->sampleCostEstimation;
                    $history->comment = "Not Applicable";
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $sample->status;
                    $history->change_to = "Opened";
                    $history->change_from = "Null";
                    $history->action_name = 'Create'; 
                    $history->save();
                }

                if(!empty($sample->resourceUtilization)){
                    $history = new SamplingStabilityAuditTrail();
                    $history->ss_id = $sample->id;
                    $history->activity_type = 'Resource Utilization';
                    $history->previous = "Null";
                    $history->current = $request->resourceUtilization;
                    $history->comment = "Not Applicable";
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $sample->status;
                    $history->change_to = "Opened";
                    $history->change_from = "Null";
                    $history->action_name = 'Create'; 
                    $history->save();
                }

                if(!empty($sample->assignedDepartment)){
                    $history = new SamplingStabilityAuditTrail();
                    $history->ss_id = $sample->id;
                    $history->activity_type = 'Assigned Department';
                    $history->previous = "Null";
                    $history->current = $request->assignedDepartment;
                    $history->comment = "Not Applicable";
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $sample->status;
                    $history->change_to = "Opened";
                    $history->change_from = "Null";
                    $history->action_name = 'Create'; 
                    $history->save();
                }

                if(!empty($sample->testGrouping_ii)){
                    $history = new SamplingStabilityAuditTrail();
                    $history->ss_id = $sample->id;
                    $history->activity_type = 'Test Grouping';
                    $history->previous = "Null";
                    $history->current = $request->testGrouping_ii;
                    $history->comment = "Not Applicable";
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $sample->status;
                    $history->change_to = "Opened";
                    $history->change_from = "Null";
                    $history->action_name = 'Create'; 
                    $history->save();
                }

                if(!empty($sample->sampleCollectionDate)){
                    $history = new SamplingStabilityAuditTrail();
                    $history->ss_id = $sample->id;
                    $history->activity_type = 'Sample Collection Date';
                    $history->previous = "Null";
                    $history->current = Helpers::getdateFormat($request->sampleCollectionDate);
                    $history->comment = "Not Applicable";
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $sample->status;
                    $history->change_to = "Opened";
                    $history->change_from = "Null";
                    $history->action_name = 'Create'; 
                    $history->save();
                }

                if(!empty($sample->analysisType)){
                    $history = new SamplingStabilityAuditTrail();
                    $history->ss_id = $sample->id;
                    $history->activity_type = 'Analysis Type';
                    $history->previous = "Null";
                    $history->current = $request->analysisType;
                    $history->comment = "Not Applicable";
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $sample->status;
                    $history->change_to = "Opened";
                    $history->change_from = "Null";
                    $history->action_name = 'Create'; 
                    $history->save();
                }

                if(!empty($sample->analysisResult)){
                    $history = new SamplingStabilityAuditTrail();
                    $history->ss_id = $sample->id;
                    $history->activity_type = 'Analysis Result';
                    $history->previous = "Null";
                    $history->current = $request->analysisResult;
                    $history->comment = "Not Applicable";
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $sample->status;
                    $history->change_to = "Opened";
                    $history->change_from = "Null";
                    $history->action_name = 'Create'; 
                    $history->save();
                }

                if(!empty($sample->analysisDate)){
                    $history = new SamplingStabilityAuditTrail();
                    $history->ss_id = $sample->id;
                    $history->activity_type = 'Analysis Date';
                    $history->previous = "Null";
                    $history->current = Helpers::getdateFormat($request->analysisDate);
                    $history->comment = "Not Applicable";
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $sample->status;
                    $history->change_to = "Opened";
                    $history->change_from = "Null";
                    $history->action_name = 'Create'; 
                    $history->save();
                }

                if(!empty($sample->testingStartDate)){
                    $history = new SamplingStabilityAuditTrail();
                    $history->ss_id = $sample->id;
                    $history->activity_type = 'Testing Start Date';
                    $history->previous = "Null";
                    $history->current = Helpers::getdateFormat($request->testingStartDate);
                    $history->comment = "Not Applicable";
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $sample->status;
                    $history->change_to = "Opened";
                    $history->change_from = "Null";
                    $history->action_name = 'Create'; 
                    $history->save();
                }

                if(!empty($sample->testingEndDate)){
                    $history = new SamplingStabilityAuditTrail();
                    $history->ss_id = $sample->id;
                    $history->activity_type = 'Testing End Date';
                    $history->previous = "Null";
                    $history->current = Helpers::getdateFormat($request->testingEndDate);
                    $history->comment = "Not Applicable";
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $sample->status;
                    $history->change_to = "Opened";
                    $history->change_from = "Null";
                    $history->action_name = 'Create'; 
                    $history->save();
                }

                if(!empty($sample->delayJustification)){
                    $history = new SamplingStabilityAuditTrail();
                    $history->ss_id = $sample->id;
                    $history->activity_type = 'Delay Justification';
                    $history->previous = "Null";
                    $history->current = $request->delayJustification;
                    $history->comment = "Not Applicable";
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $sample->status;
                    $history->change_to = "Opened";
                    $history->change_from = "Null";
                    $history->action_name = 'Create'; 
                    $history->save();
                }

                if(!empty($sample->testingOutCome)){
                    $history = new SamplingStabilityAuditTrail();
                    $history->ss_id = $sample->id;
                    $history->activity_type = 'Testing Outcome';
                    $history->previous = "Null";
                    $history->current = $request->testingOutCome;
                    $history->comment = "Not Applicable";
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $sample->status;
                    $history->change_to = "Opened";
                    $history->change_from = "Null";
                    $history->action_name = 'Create'; 
                    $history->save();
                }

                if(!empty($sample->passFail)){
                    $history = new SamplingStabilityAuditTrail();
                    $history->ss_id = $sample->id;
                    $history->activity_type = 'Pass/Fail';
                    $history->previous = "Null";
                    $history->current = $request->passFail;
                    $history->comment = "Not Applicable";
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $sample->status;
                    $history->change_to = "Opened";
                    $history->change_from = "Null";
                    $history->action_name = 'Create'; 
                    $history->save();
                }

                if(!empty($sample->testPlanId)){
                    $history = new SamplingStabilityAuditTrail();
                    $history->ss_id = $sample->id;
                    $history->activity_type = 'Test Plan ID';
                    $history->previous = "Null";
                    $history->current = $request->testPlanId;
                    $history->comment = "Not Applicable";
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $sample->status;
                    $history->change_to = "Opened";
                    $history->change_from = "Null";
                    $history->action_name = 'Create'; 
                    $history->save();
                }

                if(!empty($sample->turnAroundTime)){
                    $history = new SamplingStabilityAuditTrail();
                    $history->ss_id = $sample->id;
                    $history->activity_type = 'Turnaround Time (TAT)';
                    $history->previous = "Null";
                    $history->current = $request->turnAroundTime;
                    $history->comment = "Not Applicable";
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $sample->status;
                    $history->change_to = "Opened";
                    $history->change_from = "Null";
                    $history->action_name = 'Create'; 
                    $history->save();
                }

                if(!empty($sample->sampleRetestingDate)){
                    $history = new SamplingStabilityAuditTrail();
                    $history->ss_id = $sample->id;
                    $history->activity_type = 'Sample Retesting Date';
                    $history->previous = "Null";
                    $history->current = Helpers::getdateFormat($request->sampleRetestingDate);
                    $history->comment = "Not Applicable";
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $sample->status;
                    $history->change_to = "Opened";
                    $history->change_from = "Null";
                    $history->action_name = 'Create'; 
                    $history->save();
                }

                if(!empty($sample->reviewDate)){
                    $history = new SamplingStabilityAuditTrail();
                    $history->ss_id = $sample->id;
                    $history->activity_type = 'Review Date';
                    $history->previous = "Null";
                    $history->current = Helpers::getdateFromat($request->reviewDate);
                    $history->comment = "Not Applicable";
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $sample->status;
                    $history->change_to = "Opened";
                    $history->change_from = "Null";
                    $history->action_name = 'Create'; 
                    $history->save();
                }

                if(!empty($sample->sampleStorageLocation)){
                    $history = new SamplingStabilityAuditTrail();
                    $history->ss_id = $sample->id;
                    $history->activity_type = 'Sample Storage Location';
                    $history->previous = "Null";
                    $history->current = $request->sampleStorageLocation;
                    $history->comment = "Not Applicable";
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $sample->status;
                    $history->change_to = "Opened";
                    $history->change_from = "Null";
                    $history->action_name = 'Create'; 
                    $history->save();
                }

                if(!empty($sample->transportationMethod)){
                    $history = new SamplingStabilityAuditTrail();
                    $history->ss_id = $sample->id;
                    $history->activity_type = 'Transportation Method';
                    $history->previous = "Null";
                    $history->current = $request->transportationMethod;
                    $history->comment = "Not Applicable";
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $sample->status;
                    $history->change_to = "Opened";
                    $history->change_from = "Null";
                    $history->action_name = 'Create'; 
                    $history->save();
                }

                if(!empty($sample->samplePreparationMethod)){
                    $history = new SamplingStabilityAuditTrail();
                    $history->ss_id = $sample->id;
                    $history->activity_type = 'Sample Preparation Method';
                    $history->previous = "Null";
                    $history->current = $request->samplePreparationMethod;
                    $history->comment = "Not Applicable";
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $sample->status;
                    $history->change_to = "Opened";
                    $history->change_from = "Null";
                    $history->action_name = 'Create'; 
                    $history->save();
                }

                if(!empty($sample->samplePackagingDetail)){
                    $history = new SamplingStabilityAuditTrail();
                    $history->ss_id = $sample->id;
                    $history->activity_type = 'Sample Packaging Details';
                    $history->previous = "Null";
                    $history->current = $request->samplePackagingDetail;
                    $history->comment = "Not Applicable";
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $sample->status;
                    $history->change_to = "Opened";
                    $history->change_from = "Null";
                    $history->action_name = 'Create'; 
                    $history->save();
                }

                if(!empty($sample->sampleLabel)){
                    $history = new SamplingStabilityAuditTrail();
                    $history->ss_id = $sample->id;
                    $history->activity_type = 'Sample Label';
                    $history->previous = "Null";
                    $history->current = $request->sampleLabel;
                    $history->comment = "Not Applicable";
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $sample->status;
                    $history->change_to = "Opened";
                    $history->change_from = "Null";
                    $history->action_name = 'Create'; 
                    $history->save();
                }

                if(!empty($sample->qualityControlCheck)){
                    $history = new SamplingStabilityAuditTrail();
                    $history->ss_id = $sample->id;
                    $history->activity_type = 'Regulatory Requirements';
                    $history->previous = "Null";
                    $history->current = $request->qualityControlCheck;
                    $history->comment = "Not Applicable";
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $sample->status;
                    $history->change_to = "Opened";
                    $history->change_from = "Null";
                    $history->action_name = 'Create'; 
                    $history->save();
                }   

                if(!empty($sample->controlSampleReference)){
                    $history = new SamplingStabilityAuditTrail();
                    $history->ss_id = $sample->id;
                    $history->activity_type = 'Quality Control Checks';
                    $history->previous = "Null";
                    $history->current = $request->controlSampleReference;
                    $history->comment = "Not Applicable";
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $sample->status;
                    $history->change_to = "Opened";
                    $history->change_from = "Null";
                    $history->action_name = 'Create'; 
                    $history->save();
                }   

                if(!empty($sample->referencesample)){
                    $history = new SamplingStabilityAuditTrail();
                    $history->ss_id = $sample->id;
                    $history->activity_type = 'Control Sample Reference';
                    $history->previous = "Null";
                    $history->current = $request->referencesample;
                    $history->comment = "Not Applicable";
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $sample->status;
                    $history->change_to = "Opened";
                    $history->change_from = "Null";
                    $history->action_name = 'Create'; 
                    $history->save();
                }   

                if(!empty($sample->controlSample)){
                    $history = new SamplingStabilityAuditTrail();
                    $history->ss_id = $sample->id;
                    $history->activity_type = 'Control Sample';
                    $history->previous = "Null";
                    $history->current = $request->controlSample;
                    $history->comment = "Not Applicable";
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $sample->status;
                    $history->change_to = "Opened";
                    $history->change_from = "Null";
                    $history->action_name = 'Create'; 
                    $history->save();
                }   

                if(!empty($sample->sampleIntegrityStatus)){
                    $history = new SamplingStabilityAuditTrail();
                    $history->ss_id = $sample->id;
                    $history->activity_type = 'Sample Integrity Status';
                    $history->previous = "Null";
                    $history->current = $request->sampleIntegrityStatus;
                    $history->comment = "Not Applicable";
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $sample->status;
                    $history->change_to = "Opened";
                    $history->change_from = "Null";
                    $history->action_name = 'Create'; 
                    $history->save();
                }   

                if(!empty($sample->assignedDepartmentII)){
                    $history = new SamplingStabilityAuditTrail();
                    $history->ss_id = $sample->id;
                    $history->activity_type = 'Assigned Department';
                    $history->previous = "Null";
                    $history->current = $request->assignedDepartmentII;
                    $history->comment = "Not Applicable";
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $sample->status;
                    $history->change_to = "Opened";
                    $history->change_from = "Null";
                    $history->action_name = 'Create'; 
                    $history->save();
                }   

                if(!empty($sample->riskAssessment)){
                    $history = new SamplingStabilityAuditTrail();
                    $history->ss_id = $sample->id;
                    $history->activity_type = 'Risk Assessment';
                    $history->previous = "Null";
                    $history->current = $request->riskAssessment;
                    $history->comment = "Not Applicable";
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $sample->status;
                    $history->change_to = "Opened";
                    $history->change_from = "Null";
                    $history->action_name = 'Create'; 
                    $history->save();
                }   

                if(!empty($sample->supervisor)){
                    $history = new SamplingStabilityAuditTrail();
                    $history->ss_id = $sample->id;
                    $history->activity_type = 'Supervisor';
                    $history->previous = "Null";
                    $history->current = $request->supervisor;
                    $history->comment = "Not Applicable";
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $sample->status;
                    $history->change_to = "Opened";
                    $history->change_from = "Null";
                    $history->action_name = 'Create'; 
                    $history->save();
                }   

                if(!empty($sample->instruments_reserved)){
                    $history = new SamplingStabilityAuditTrail();
                    $history->ss_id = $sample->id;
                    $history->activity_type = 'Instruments Reserved';
                    $history->previous = "Null";
                    $history->current = $request->instruments_reserved;
                    $history->comment = "Not Applicable";
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $sample->status;
                    $history->change_to = "Opened";
                    $history->change_from = "Null";
                    $history->action_name = 'Create'; 
                    $history->save();
                }   

                if(!empty($sample->lab_availability)){
                    $history = new SamplingStabilityAuditTrail();
                    $history->ss_id = $sample->id;
                    $history->activity_type = 'Lab Availability';
                    $history->previous = "Null";
                    $history->current = $request->lab_availability;
                    $history->comment = "Not Applicable";
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $sample->status;
                    $history->change_to = "Opened";
                    $history->change_from = "Null";
                    $history->action_name = 'Create'; 
                    $history->save();
                }   

                if(!empty($sample->sample_date)){
                    $history = new SamplingStabilityAuditTrail();
                    $history->ss_id = $sample->id;
                    $history->activity_type = 'Sample Date';
                    $history->previous = "Null";
                    $history->current = Helpers::getdateFormat($request->sample_date);
                    $history->comment = "Not Applicable";
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $sample->status;
                    $history->change_to = "Opened";
                    $history->change_from = "Null";
                    $history->action_name = 'Create'; 
                    $history->save();
                }   

                if(!empty($sample->sample_movement_history)){
                    $history = new SamplingStabilityAuditTrail();
                    $history->ss_id = $sample->id;
                    $history->activity_type = 'Sample Movement History';
                    $history->previous = "Null";
                    $history->current = $request->sample_movement_history;
                    $history->comment = "Not Applicable";
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $sample->status;
                    $history->change_to = "Opened";
                    $history->change_from = "Null";
                    $history->action_name = 'Create'; 
                    $history->save();
                }   

                if(!empty($sample->testing_progress)){
                    $history = new SamplingStabilityAuditTrail();
                    $history->ss_id = $sample->id;
                    $history->activity_type = 'Testing Progress';
                    $history->previous = "Null";
                    $history->current = $request->testing_progress;
                    $history->comment = "Not Applicable";
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $sample->status;
                    $history->change_to = "Opened";
                    $history->change_from = "Null";
                    $history->action_name = 'Create'; 
                    $history->save();
                }   

                if(!empty($sample->deviation_logs)){
                    $history = new SamplingStabilityAuditTrail();
                    $history->ss_id = $sample->id;
                    $history->activity_type = 'Deviation Logs';
                    $history->previous = "Null";
                    $history->current = $request->deviation_logs;
                    $history->comment = "Not Applicable";
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $sample->status;
                    $history->change_to = "Opened";
                    $history->change_from = "Null";
                    $history->action_name = 'Create'; 
                    $history->save();
                }   

                if(!empty($sample->commentNotes)){
                    $history = new SamplingStabilityAuditTrail();
                    $history->ss_id = $sample->id;
                    $history->activity_type = 'Comments/Notes';
                    $history->previous = "Null";
                    $history->current = $request->commentNotes;
                    $history->comment = "Not Applicable";
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $sample->status;
                    $history->change_to = "Opened";
                    $history->change_from = "Null";
                    $history->action_name = 'Create'; 
                    $history->save();
                }   

                if(!empty($sample->samplingFrequency)){
                    $history = new SamplingStabilityAuditTrail();
                    $history->ss_id = $sample->id;
                    $history->activity_type = 'Sampling Frequency';
                    $history->previous = "Null";
                    $history->current = $request->samplingFrequency;
                    $history->comment = "Not Applicable";
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $sample->status;
                    $history->change_to = "Opened";
                    $history->change_from = "Null";
                    $history->action_name = 'Create'; 
                    $history->save();
                }   

                if(!empty($sample->sampleDisposition)){
                    $history = new SamplingStabilityAuditTrail();
                    $history->ss_id = $sample->id;
                    $history->activity_type = 'Sample Disposition';
                    $history->previous = "Null";
                    $history->current = $request->sampleDisposition;
                    $history->comment = "Not Applicable";
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $sample->status;
                    $history->change_to = "Opened";
                    $history->change_from = "Null";
                    $history->action_name = 'Create'; 
                    $history->save();
                }   

                if(!empty($sample->reviewerApprover)){
                    $history = new SamplingStabilityAuditTrail();
                    $history->ss_id = $sample->id;
                    $history->activity_type = 'Reviewer/Approver';
                    $history->previous = "Null";
                    $history->current = $request->reviewerApprover;
                    $history->comment = "Not Applicable";
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $sample->status;
                    $history->change_to = "Opened";
                    $history->change_from = "Null";
                    $history->action_name = 'Create'; 
                    $history->save();
                }   

                if(!empty($sample->reviewDate)){
                    $history = new SamplingStabilityAuditTrail();
                    $history->ss_id = $sample->id;
                    $history->activity_type = 'Review Date';
                    $history->previous = "Null";
                    $history->current = Helpers::getdateFormat($request->reviewDate);
                    $history->comment = "Not Applicable";
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $sample->status;
                    $history->change_to = "Opened";
                    $history->change_from = "Null";
                    $history->action_name = 'Create'; 
                    $history->save();
                }   

                if(!empty($sample->reviewerComment)){
                    $history = new SamplingStabilityAuditTrail();
                    $history->ss_id = $sample->id;
                    $history->activity_type = 'Reviewer Comment';
                    $history->previous = "Null";
                    $history->current = $request->reviewerComment;
                    $history->comment = "Not Applicable";
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $sample->status;
                    $history->change_to = "Opened";
                    $history->change_from = "Null";
                    $history->action_name = 'Create'; 
                    $history->save();
                }   

                if(!empty($sample->stabilityStudyType)){
                    $history = new SamplingStabilityAuditTrail();
                    $history->ss_id = $sample->id;
                    $history->activity_type = 'Stability Study Type';
                    $history->previous = "Null";
                    $history->current = $request->stabilityStudyType;
                    $history->comment = "Not Applicable";
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $sample->status;
                    $history->change_to = "Opened";
                    $history->change_from = "Null";
                    $history->action_name = 'Create'; 
                    $history->save();
                }   

                if(!empty($sample->ichZone)){
                    $history = new SamplingStabilityAuditTrail();
                    $history->ss_id = $sample->id;
                    $history->activity_type = 'ICH Zone';
                    $history->previous = "Null";
                    $history->current = $request->ichZone;
                    $history->comment = "Not Applicable";
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $sample->status;
                    $history->change_to = "Opened";
                    $history->change_from = "Null";
                    $history->action_name = 'Create'; 
                    $history->save();
                }   

                if(!empty($sample->sampleDisposition)){
                    $history = new SamplingStabilityAuditTrail();
                    $history->ss_id = $sample->id;
                    $history->activity_type = 'Sample Disposition';
                    $history->previous = "Null";
                    $history->current = $request->sampleDisposition;
                    $history->comment = "Not Applicable";
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $sample->status;
                    $history->change_to = "Opened";
                    $history->change_from = "Null";
                    $history->action_name = 'Create'; 
                    $history->save();
                }   

                if(!empty($sample->photostabilityResults)){
                    $history = new SamplingStabilityAuditTrail();
                    $history->ss_id = $sample->id;
                    $history->activity_type = 'Photostability Testing Results';
                    $history->previous = "Null";
                    $history->current = $request->photostabilityResults;
                    $history->comment = "Not Applicable";
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $sample->status;
                    $history->change_to = "Opened";
                    $history->change_from = "Null";
                    $history->action_name = 'Create'; 
                    $history->save();
                }   

                if(!empty($sample->reconstitutionStability)){
                    $history = new SamplingStabilityAuditTrail();
                    $history->ss_id = $sample->id;
                    $history->activity_type = 'Reconstitution Stability';
                    $history->previous = "Null";
                    $history->current = $request->reconstitutionStability;
                    $history->comment = "Not Applicable";
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $sample->status;
                    $history->change_to = "Opened";
                    $history->change_from = "Null";
                    $history->action_name = 'Create'; 
                    $history->save();
                }   

                if(!empty($sample->protocolApprovalDate)){
                    $history = new SamplingStabilityAuditTrail();
                    $history->ss_id = $sample->id;
                    $history->activity_type = 'Stability Protocol Approval Date';
                    $history->previous = "Null";
                    $history->current = Helpers::getdateFormat($request->protocolApprovalDate);
                    $history->comment = "Not Applicable";
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $sample->status;
                    $history->change_to = "Opened";
                    $history->change_from = "Null";
                    $history->action_name = 'Create'; 
                    $history->save();
                }   

                if(!empty($sample->testingInterval)){
                    $history = new SamplingStabilityAuditTrail();
                    $history->ss_id = $sample->id;
                    $history->activity_type = 'Testing Interval (months)';
                    $history->previous = "Null";
                    $history->current = $request->testingInterval;
                    $history->comment = "Not Applicable";
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $sample->status;
                    $history->change_to = "Opened";
                    $history->change_from = "Null";
                    $history->action_name = 'Create'; 
                    $history->save();
                }   

                if(!empty($sample->regulatoryCountry)){
                    $history = new SamplingStabilityAuditTrail();
                    $history->ss_id = $sample->id;
                    $history->activity_type = 'Country of Regulatory Submissions';
                    $history->previous = "Null";
                    $history->current = $request->regulatoryCountry;
                    $history->comment = "Not Applicable";
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $sample->status;
                    $history->change_to = "Opened";
                    $history->change_from = "Null";
                    $history->action_name = 'Create'; 
                    $history->save();
                }   

                if(!empty($sample->shelfLife)){
                    $history = new SamplingStabilityAuditTrail();
                    $history->ss_id = $sample->id;
                    $history->activity_type = 'Shelf Life Recommendation';
                    $history->previous = "Null";
                    $history->current = $request->shelfLife;
                    $history->comment = "Not Applicable";
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $sample->status;
                    $history->change_to = "Opened";
                    $history->change_from = "Null";
                    $history->action_name = 'Create'; 
                    $history->save();
                }   

                if(!empty($sample->qaReviewerApprover)){
                    $history = new SamplingStabilityAuditTrail();
                    $history->ss_id = $sample->id;
                    $history->activity_type = 'QA Reviewer/Approver';
                    $history->previous = "Null";
                    $history->current = $request->qaReviewerApprover;
                    $history->comment = "Not Applicable";
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $sample->status;
                    $history->change_to = "Opened";
                    $history->change_from = "Null";
                    $history->action_name = 'Create'; 
                    $history->save();
                }   

                if(!empty($sample->qaReviewDate)){
                    $history = new SamplingStabilityAuditTrail();
                    $history->ss_id = $sample->id;
                    $history->activity_type = 'QA Review Date';
                    $history->previous = "Null";
                    $history->current = Helpers::getdateFormat($request->qaReviewDate);
                    $history->comment = "Not Applicable";
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $sample->status;
                    $history->change_to = "Opened";
                    $history->change_from = "Null";
                    $history->action_name = 'Create'; 
                    $history->save();
                }   

                if(!empty($sample->qaReviewerComment)){
                    $history = new SamplingStabilityAuditTrail();
                    $history->ss_id = $sample->id;
                    $history->activity_type = 'QA Reviewer Comment';
                    $history->previous = "Null";
                    $history->current = $request->qaReviewerComment;
                    $history->comment = "Not Applicable";
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $sample->status;
                    $history->change_to = "Opened";
                    $history->change_from = "Null";
                    $history->action_name = 'Create'; 
                    $history->save();
                }   

                if(!empty($sample->initiatorName)){
                    $history = new SamplingStabilityAuditTrail();
                    $history->ss_id = $sample->id;
                    $history->activity_type = 'Initiator Name';
                    $history->previous = "Null";
                    $history->current = $request->initiatorName;
                    $history->comment = "Not Applicable";
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $sample->status;
                    $history->change_to = "Opened";
                    $history->change_from = "Null";
                    $history->action_name = 'Create'; 
                    $history->save();
                }   

                if(!empty($sample->labTechnicianName)){
                    $history = new SamplingStabilityAuditTrail();
                    $history->ss_id = $sample->id;
                    $history->activity_type = 'Lab Technician Name';
                    $history->previous = "Null";
                    $history->current = $request->labTechnicianName;
                    $history->comment = "Not Applicable";
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $sample->status;
                    $history->change_to = "Opened";
                    $history->change_from = "Null";
                    $history->action_name = 'Create'; 
                    $history->save();
                }   

                if(!empty($sample->dateOfInitiation)){
                    $history = new SamplingStabilityAuditTrail();
                    $history->ss_id = $sample->id;
                    $history->activity_type = 'Date of Initiation';
                    $history->previous = "Null";
                    $history->current = Helpers::getadateFormat($request->dateOfInitiation);
                    $history->comment = "Not Applicable";
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $sample->status;
                    $history->change_to = "Opened";
                    $history->change_from = "Null";
                    $history->action_name = 'Create'; 
                    $history->save();
                }   

                if(!empty($sample->dateOfLabTechReview)){
                    $history = new SamplingStabilityAuditTrail();
                    $history->ss_id = $sample->id;
                    $history->activity_type = 'Date of Lab Technician Review';
                    $history->previous = "Null";
                    $history->current = Helpers::getadateFormat($request->dateOfLabTechReview);
                    $history->comment = "Not Applicable";
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $sample->status;
                    $history->change_to = "Opened";
                    $history->change_from = "Null";
                    $history->action_name = 'Create'; 
                    $history->save();
                }   

                if(!empty($sample->supervisorName)){
                    $history = new SamplingStabilityAuditTrail();
                    $history->ss_id = $sample->id;
                    $history->activity_type = 'Supervisor Name';
                    $history->previous = "Null";
                    $history->current = $request->supervisorName;
                    $history->comment = "Not Applicable";
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $sample->status;
                    $history->change_to = "Opened";
                    $history->change_from = "Null";
                    $history->action_name = 'Create'; 
                    $history->save();
                }   

                if(!empty($sample->qaReview)){
                    $history = new SamplingStabilityAuditTrail();
                    $history->ss_id = $sample->id;
                    $history->activity_type = 'QA Review';
                    $history->previous = "Null";
                    $history->current = $request->qaReview;
                    $history->comment = "Not Applicable";
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $sample->status;
                    $history->change_to = "Opened";
                    $history->change_from = "Null";
                    $history->action_name = 'Create'; 
                    $history->save();
                }   

                if(!empty($sample->dateOfSupervisionReview)){
                    $history = new SamplingStabilityAuditTrail();
                    $history->ss_id = $sample->id;
                    $history->activity_type = 'Date of Supervision Review';
                    $history->previous = "Null";
                    $history->current = Helpers::getdateFormat($request->dateOfSupervisionReview);
                    $history->comment = "Not Applicable";
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $sample->status;
                    $history->change_to = "Opened";
                    $history->change_from = "Null";
                    $history->action_name = 'Create'; 
                    $history->save();
                }   

                if(!empty($sample->dateOfQaReview)){
                    $history = new SamplingStabilityAuditTrail();
                    $history->ss_id = $sample->id;
                    $history->activity_type = 'Date of QA Review';
                    $history->previous = "Null";
                    $history->current = Helpers::getdateFormat($request->dateOfQaReview);
                    $history->comment = "Not Applicable";
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $sample->status;
                    $history->change_to = "Opened";
                    $history->change_from = "Null";
                    $history->action_name = 'Create'; 
                    $history->save();
                }   


                toastr()->success("Record is created Successfully");
                return redirect(url('rcms/qms-dashboard'));
                
            }

    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id){
        $samples = SampleStability::find($id);
        // dd($samples);

        return view('frontend.sampling-stability.view_sampling_stability', compact('samples'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $lastDocument = SampleStability::find($id);
        $sample = SampleStability::find($id);

        $sample->due_date = $request->due_date;
        $sample->short_desc = $request->short_desc;
        $sample->Initiator_Group = $request->Initiator_Group;
        $sample->initiator_group_code = $request->initiator_group_code;
        $sample->assign_to = $request->assign_to;
        $sample->samplePlanId = $request->samplePlanId;
        $sample->sampleId = $request->sampleId;
        $sample->sampleName = $request->sampleName;
        $sample->sampleType = $request->sampleType;
        $sample->productMaterialName = $request->productMaterialName;
        $sample->batchLotNumber = $request->batchLotNumber;
        $sample->samplePriority = $request->samplePriority;
        $sample->sampleQuantity = $request->sampleQuantity;
        $sample->UOM = $request->UOM;
        $sample->market = $request->market;
        $sample->sampleBarCode = $request->sampleBarCode;
        $sample->specificationId = $request->specificationId;
        //$sample->specification_attachment = $request->specification_attachment;
        $sample->stpId = $request->stpId;
        $sample->stp_attachment = $request->stp_attachment;
        $sample->testName = $request->testName;
        $sample->testMethod = $request->testMethod;
        $sample->testParameter = $request->testParameter;
        $sample->testingFrequency = $request->testingFrequency;
        $sample->testingLocation = $request->testingLocation;
        $sample->requiredInstrument = $request->requiredInstrument;
        $sample->testGrouping = $request->testGrouping;
        $sample->lsl = $request->lsl;
        $sample->usl = $request->usl;
        $sample->labTechnician = $request->labTechnician;
        $sample->sampleCostEstimation = $request->sampleCostEstimation;
        $sample->resourceUtilization = $request->resourceUtilization;
        $sample->assignedDepartment = $request->assignedDepartment;
        $sample->testGrouping_ii = $request->testGrouping_ii;
        $sample->sampleCollectionDate = $request->sampleCollectionDate;
        // $sample->suupportive_attachment_gi = $request->suupportive_attachment_gi;
        $sample->analysisType = $request->analysisType;
        // dd($sample->analysisType);
        $sample->analysisResult = $request->analysisResult;
        $sample->analysisDate = $request->analysisDate;
        $sample->testingStartDate = $request->testingStartDate;
        $sample->testingEndDate = $request->testingEndDate;
        $sample->delayJustification = $request->delayJustification;
        $sample->testingOutCome = $request->testingOutCome;
        $sample->passFail = $request->passFail;
        $sample->testPlanId = $request->testPlanId;
        $sample->turnAroundTime = $request->turnAroundTime;
        $sample->sampleRetestingDate = $request->sampleRetestingDate;
        $sample->reviewDate = $request->reviewDate;
        $sample->sampleStorageLocation = $request->sampleStorageLocation;
        $sample->transportationMethod = $request->transportationMethod;
        $sample->samplePreparationMethod = $request->samplePreparationMethod;
        $sample->samplePackagingDetail = $request->samplePackagingDetail;
        $sample->sampleLabel = $request->sampleLabel;
        $sample->regulatoryRequirement = $request->regulatoryRequirement;
        $sample->qualityControlCheck = $request->qualityControlCheck;
        $sample->controlSampleReference = $request->controlSampleReference;
        $sample->referencesample = $request->referencesample;
        $sample->controlSample = $request->controlSample;
        $sample->sampleIntegrityStatus = $request->sampleIntegrityStatus;
        $sample->assignedDepartmentII = $request->assignedDepartmentII;
        $sample->assignedDepartment = $request->assignedDepartment;
        $sample->riskAssessment = $request->riskAssessment;
        $sample->supervisor = $request->supervisor;
        $sample->instruments_reserved = $request->instruments_reserved;
        $sample->lab_availability = $request->lab_availability;
        $sample->sample_date = $request->sample_date;
        $sample->sample_movement_history = $request->sample_movement_history;
        $sample->testing_progress = $request->testing_progress;
        $sample->deviation_logs = $request->deviation_logs;
        $sample->commentNotes = $request->commentNotes;
        // $sample->analysis_attachment = $request->analysis_attachment;
        $sample->samplingFrequency = $request->samplingFrequency;
        $sample->sampleDisposition = $request->sampleDisposition;
        // $sample->supportive_attachment = $request->supportive_attachment;
        $sample->reviewerApprover = $request->reviewerApprover;
        $sample->reviewerComment = $request->reviewerComment;
        $sample->reviewDate = $request->reviewDate;
        $sample->stabilityStudyType = $request->stabilityStudyType;
        $sample->selectDisposition = $request->selectDisposition;
        // $sample->stabilityStudyProtocol = $request->stabilityStudyProtocol;
        $sample->protocolApprovalDate = $request->protocolApprovalDate;
        $sample->regulatoryCountry = $request->regulatoryCountry;
        $sample->ichZone = $request->ichZone;
        $sample->photostabilityResults = $request->photostabilityResults;
        $sample->reconstitutionStability = $request->reconstitutionStability;
        $sample->testingInterval = $request->testingInterval;
        $sample->shelfLife = $request->shelfLife;
        // $sample->supportiveAttachment = $request->supportiveAttachment;
        $sample->qaReviewerApprover = $request->qaReviewerApprover;
        $sample->qaReviewDate = $request->qaReviewDate;
        $sample->qaReviewerComment = $request->qaReviewerComment;
        $sample->initiatorName = $request->initiatorName;
        $sample->dateOfInitiation = $request->dateOfInitiation;
        $sample->labTechnicianName = $request->labTechnicianName;
        $sample->dateOfLabTechReview = $request->dateOfLabTechReview;
        $sample->supervisorName = $request->supervisorName;
        $sample->dateOfSupervisionReview = $request->dateOfSupervisionReview;
        $sample->qaReview = $request->qaReview;
        $sample->dateOfQaReview = $request->dateOfQaReview;

        $sample->update();

        if ($lastDocument->due_date != $sample->due_date || !empty($request->comment)) {
            $history = new SamplingStabilityAuditTrail();
            $history->ss_id = $id;
            $history->activity_type = 'Due Date';
            $history->previous = $lastDocument->due_date;
            $history->current = $sample->due_date;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
                if (is_null($lastDocument->due_date) || $lastDocument->due_date === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }

        if ($lastDocument->Initiator_Group != $sample->Initiator_Group || !empty($request->comment)) {
            $history = new SamplingStabilityAuditTrail();
            $history->ss_id = $id;
            $history->activity_type = 'Initiator Group';
            $history->previous = Helpers::getInitiatorGroupFullName($lastDocument->Initiator_Group);
            $history->current = Helpers::getInitiatorGroupFullName($sample->Initiator_Group);
            $history->comment = $request->comment;
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

        if ($lastDocument->initiator_group_code != $sample->initiator_group_code || !empty($request->comment)) {
            $history = new SamplingStabilityAuditTrail();
            $history->ss_id = $id;
            $history->activity_type = 'Initiator Group Code';
            $history->previous = $lastDocument->initiator_group_code;
            $history->current = $sample->initiator_group_code;
            $history->comment = $request->comment;
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

        if ($lastDocument->short_desc != $sample->short_desc || !empty($request->comment)) {
            $history = new SamplingStabilityAuditTrail();
            $history->ss_id = $id;
            $history->activity_type = 'Short Description';
            $history->previous = $lastDocument->short_desc;
            $history->current = $sample->short_desc;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
                if (is_null($lastDocument->short_desc) || $lastDocument->short_desc === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }

        if ($lastDocument->samplePlanId != $sample->samplePlanId || !empty($request->comment)) {
            $history = new SamplingStabilityAuditTrail();
            $history->ss_id = $id;
            $history->activity_type = 'Sample Plan ID';
            $history->previous = $lastDocument->samplePlanId;
            $history->current = $sample->samplePlanId;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
                if (is_null($lastDocument->samplePlanId) || $lastDocument->samplePlanId === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }

        if ($lastDocument->sampleId != $sample->sampleId || !empty($request->comment)) {
            $history = new SamplingStabilityAuditTrail();
            $history->ss_id = $id;
            $history->activity_type = 'Sample ID';
            $history->previous = $lastDocument->sampleId;
            $history->current = $sample->sampleId;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
                if (is_null($lastDocument->sampleId) || $lastDocument->sampleId === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }

        if ($lastDocument->sampleName != $sample->sampleName || !empty($request->comment)) {
            $history = new SamplingStabilityAuditTrail();
            $history->ss_id = $id;
            $history->activity_type = 'Sample Name';
            $history->previous = $lastDocument->sampleName;
            $history->current = $sample->sampleName;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
                if (is_null($lastDocument->sampleName) || $lastDocument->sampleName === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }

        if ($lastDocument->sampleType != $sample->sampleType || !empty($request->comment)) {
            $history = new SamplingStabilityAuditTrail();
            $history->ss_id = $id;
            $history->activity_type = 'Sample Type';
            $history->previous = $lastDocument->sampleType;
            $history->current = $sample->sampleType;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
                if (is_null($lastDocument->sampleType) || $lastDocument->sampleType === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }

        if ($lastDocument->productMaterialName != $sample->productMaterialName || !empty($request->comment)) {
            $history = new SamplingStabilityAuditTrail();
            $history->ss_id = $id;
            $history->activity_type = 'Product / Material Name';
            $history->previous = $lastDocument->productMaterialName;
            $history->current = $sample->productMaterialName;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
                if (is_null($lastDocument->productMaterialName) || $lastDocument->productMaterialName === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }

        if ($lastDocument->batchLotNumber != $sample->batchLotNumber || !empty($request->comment)) {
            $history = new SamplingStabilityAuditTrail();
            $history->ss_id = $id;
            $history->activity_type = 'Batch/Lot Number';
            $history->previous = $lastDocument->batchLotNumber;
            $history->current = $sample->batchLotNumber;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
                if (is_null($lastDocument->batchLotNumber) || $lastDocument->batchLotNumber === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }

        if ($lastDocument->samplePriority != $sample->samplePriority || !empty($request->comment)) {
            $history = new SamplingStabilityAuditTrail();
            $history->ss_id = $id;
            $history->activity_type = 'Sample Priority';
            $history->previous = $lastDocument->samplePriority;
            $history->current = $sample->samplePriority;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
                if (is_null($lastDocument->samplePriority) || $lastDocument->samplePriority === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }

        if ($lastDocument->sampleQuantity != $sample->sampleQuantity || !empty($request->comment)) {
            $history = new SamplingStabilityAuditTrail();
            $history->ss_id = $id;
            $history->activity_type = 'Sample Quantity';
            $history->previous = $lastDocument->sampleQuantity;
            $history->current = $sample->sampleQuantity;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
                if (is_null($lastDocument->sampleQuantity) || $lastDocument->sampleQuantity === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }

        if ($lastDocument->UOM != $sample->UOM || !empty($request->comment)) {
            $history = new SamplingStabilityAuditTrail();
            $history->ss_id = $id;
            $history->activity_type = 'UOM';
            $history->previous = $lastDocument->UOM;
            $history->current = $sample->UOM;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
                if (is_null($lastDocument->UOM) || $lastDocument->UOM === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }

        if ($lastDocument->market != $sample->market || !empty($request->comment)) {
            $history = new SamplingStabilityAuditTrail();
            $history->ss_id = $id;
            $history->activity_type = 'Market';
            $history->previous = $lastDocument->market;
            $history->current = $sample->market;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
                if (is_null($lastDocument->market) || $lastDocument->market === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }

        if ($lastDocument->sampleBarCode != $sample->sampleBarCode || !empty($request->comment)) {
            $history = new SamplingStabilityAuditTrail();
            $history->ss_id = $id;
            $history->activity_type = 'Sample Barcode';
            $history->previous = $lastDocument->sampleBarCode;
            $history->current = $sample->sampleBarCode;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
                if (is_null($lastDocument->sampleBarCode) || $lastDocument->sampleBarCode === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }

        if ($lastDocument->specificationId != $sample->specificationId || !empty($request->comment)) {
            $history = new SamplingStabilityAuditTrail();
            $history->ss_id = $id;
            $history->activity_type = 'Specification Id';
            $history->previous = $lastDocument->specificationId;
            $history->current = $sample->specificationId;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
                if (is_null($lastDocument->specificationId) || $lastDocument->specificationId === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }

        if ($lastDocument->stpId != $sample->stpId || !empty($request->comment)) {
            $history = new SamplingStabilityAuditTrail();
            $history->ss_id = $id;
            $history->activity_type = 'STP Id';
            $history->previous = $lastDocument->stpId;
            $history->current = $sample->stpId;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
                if (is_null($lastDocument->stpId) || $lastDocument->stpId === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }

        if ($lastDocument->testName != $sample->testName || !empty($request->comment)) {
            $history = new SamplingStabilityAuditTrail();
            $history->ss_id = $id;
            $history->activity_type = 'Test Name';
            $history->previous = $lastDocument->testName;
            $history->current = $sample->testName;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
                if (is_null($lastDocument->testName) || $lastDocument->testName === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }

        if ($lastDocument->testMethod != $sample->testMethod || !empty($request->comment)) {
            $history = new SamplingStabilityAuditTrail();
            $history->ss_id = $id;
            $history->activity_type = 'Test Method';
            $history->previous = $lastDocument->testMethod;
            $history->current = $sample->testMethod;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
                if (is_null($lastDocument->testMethod) || $lastDocument->testMethod === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }

        if ($lastDocument->testParameter != $sample->testParameter || !empty($request->comment)) {
            $history = new SamplingStabilityAuditTrail();
            $history->ss_id = $id;
            $history->activity_type = 'Test Parameters';
            $history->previous = $lastDocument->testParameter;
            $history->current = $sample->testParameter;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
                if (is_null($lastDocument->testParameter) || $lastDocument->testParameter === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }

        if ($lastDocument->testingFrequency != $sample->testingFrequency || !empty($request->comment)) {
            $history = new SamplingStabilityAuditTrail();
            $history->ss_id = $id;
            $history->activity_type = 'Testing Frequency';
            $history->previous = $lastDocument->testingFrequency;
            $history->current = $sample->testingFrequency;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
                if (is_null($lastDocument->testingFrequency) || $lastDocument->testingFrequency === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }

        if ($lastDocument->testingLocation != $sample->testingLocation || !empty($request->comment)) {
            $history = new SamplingStabilityAuditTrail();
            $history->ss_id = $id;
            $history->activity_type = 'Testing Location';
            $history->previous = $lastDocument->testingLocation;
            $history->current = $sample->testingLocation;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
                if (is_null($lastDocument->testingLocation) || $lastDocument->testingLocation === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }

        if ($lastDocument->requiredInstrument != $sample->requiredInstrument || !empty($request->comment)) {
            $history = new SamplingStabilityAuditTrail();
            $history->ss_id = $id;
            $history->activity_type = 'Select Required Instruments';
            $history->previous = $lastDocument->requiredInstrument;
            $history->current = $sample->requiredInstrument;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
                if (is_null($lastDocument->requiredInstrument) || $lastDocument->requiredInstrument === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }

        if ($lastDocument->testGrouping != $sample->testGrouping || !empty($request->comment)) {
            $history = new SamplingStabilityAuditTrail();
            $history->ss_id = $id;
            $history->activity_type = 'Test Grouping';
            $history->previous = $lastDocument->testGrouping;
            $history->current = $sample->testGrouping;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
                if (is_null($lastDocument->testGrouping) || $lastDocument->testGrouping === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }

        if ($lastDocument->lsl != $sample->lsl || !empty($request->comment)) {
            $history = new SamplingStabilityAuditTrail();
            $history->ss_id = $id;
            $history->activity_type = 'LSL';
            $history->previous = $lastDocument->lsl;
            $history->current = $sample->lsl;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
                if (is_null($lastDocument->lsl) || $lastDocument->lsl === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }

        if ($lastDocument->usl != $sample->usl || !empty($request->comment)) {
            $history = new SamplingStabilityAuditTrail();
            $history->ss_id = $id;
            $history->activity_type = 'USL';
            $history->previous = $lastDocument->usl;
            $history->current = $sample->usl;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
                if (is_null($lastDocument->usl) || $lastDocument->usl === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }

        if ($lastDocument->labTechnician != $sample->labTechnician || !empty($request->comment)) {
            $history = new SamplingStabilityAuditTrail();
            $history->ss_id = $id;
            $history->activity_type = 'Lab Technician';
            $history->previous = $lastDocument->labTechnician;
            $history->current = $sample->labTechnician;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
                if (is_null($lastDocument->labTechnician) || $lastDocument->labTechnician === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }

        if ($lastDocument->sampleCostEstimation != $sample->sampleCostEstimation || !empty($request->comment)) {
            $history = new SamplingStabilityAuditTrail();
            $history->ss_id = $id;
            $history->activity_type = 'Sample Cost Estimation';
            $history->previous = $lastDocument->sampleCostEstimation;
            $history->current = $sample->sampleCostEstimation;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
                if (is_null($lastDocument->sampleCostEstimation) || $lastDocument->sampleCostEstimation === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }

        if ($lastDocument->resourceUtilization != $sample->resourceUtilization || !empty($request->comment)) {
            $history = new SamplingStabilityAuditTrail();
            $history->ss_id = $id;
            $history->activity_type = 'Resource Utilization';
            $history->previous = $lastDocument->resourceUtilization;
            $history->current = $sample->resourceUtilization;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
                if (is_null($lastDocument->resourceUtilization) || $lastDocument->resourceUtilization === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }

        if ($lastDocument->assignedDepartment != $sample->assignedDepartment || !empty($request->comment)) {
            $history = new SamplingStabilityAuditTrail();
            $history->ss_id = $id;
            $history->activity_type = 'Assigned Department';
            $history->previous = $lastDocument->assignedDepartment;
            $history->current = $sample->assignedDepartment;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
                if (is_null($lastDocument->assignedDepartment) || $lastDocument->assignedDepartment === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }

        if ($lastDocument->testGrouping_ii != $sample->testGrouping_ii || !empty($request->comment)) {
            $history = new SamplingStabilityAuditTrail();
            $history->ss_id = $id;
            $history->activity_type = 'Test Grouping';
            $history->previous = $lastDocument->testGrouping_ii;
            $history->current = $sample->testGrouping_ii;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
                if (is_null($lastDocument->testGrouping_ii) || $lastDocument->testGrouping_ii === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }

        if ($lastDocument->sampleCollectionDate != $sample->sampleCollectionDate || !empty($request->comment)) {
            $history = new SamplingStabilityAuditTrail();
            $history->ss_id = $id;
            $history->activity_type = 'Sample Collection Date';
            $history->previous = $lastDocument->sampleCollectionDate;
            $history->current = $sample->sampleCollectionDate;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
                if (is_null($lastDocument->sampleCollectionDate) || $lastDocument->sampleCollectionDate === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }

        if ($lastDocument->analysisType != $sample->analysisType || !empty($request->comment)) {
            $history = new SamplingStabilityAuditTrail();
            $history->ss_id = $id;
            $history->activity_type = 'Analysis Type';
            $history->previous = $lastDocument->analysisType;
            $history->current = $sample->analysisType;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
                if (is_null($lastDocument->analysisType) || $lastDocument->analysisType === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }

        if ($lastDocument->analysisResult != $sample->analysisResult || !empty($request->comment)) {
            $history = new SamplingStabilityAuditTrail();
            $history->ss_id = $id;
            $history->activity_type = 'Analysis Result';
            $history->previous = $lastDocument->analysisResult;
            $history->current = $sample->analysisResult;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
                if (is_null($lastDocument->analysisResult) || $lastDocument->analysisResult === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }

        if ($lastDocument->analysisDate != $sample->analysisDate || !empty($request->comment)) {
            $history = new SamplingStabilityAuditTrail();
            $history->ss_id = $id;
            $history->activity_type = 'Analysis Date';
            $history->previous = $lastDocument->analysisDate;
            $history->current = $sample->analysisDate;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
                if (is_null($lastDocument->analysisDate) || $lastDocument->analysisDate === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }

        if ($lastDocument->testingStartDate != $sample->testingStartDate || !empty($request->comment)) {
            $history = new SamplingStabilityAuditTrail();
            $history->ss_id = $id;
            $history->activity_type = 'Testing Start Date';
            $history->previous = $lastDocument->testingStartDate;
            $history->current = $sample->testingStartDate;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
                if (is_null($lastDocument->testingStartDate) || $lastDocument->testingStartDate === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }

        if ($lastDocument->testingEndDate != $sample->testingEndDate || !empty($request->comment)) {
            $history = new SamplingStabilityAuditTrail();
            $history->ss_id = $id;
            $history->activity_type = 'Testing End Date';
            $history->previous = $lastDocument->testingEndDate;
            $history->current = $sample->testingEndDate;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
                if (is_null($lastDocument->testingEndDate) || $lastDocument->testingEndDate === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }

        if ($lastDocument->delayJustification != $sample->delayJustification || !empty($request->comment)) {
            $history = new SamplingStabilityAuditTrail();
            $history->ss_id = $id;
            $history->activity_type = 'Delay Justification';
            $history->previous = $lastDocument->delayJustification;
            $history->current = $sample->delayJustification;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
                if (is_null($lastDocument->delayJustification) || $lastDocument->delayJustification === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }

        if ($lastDocument->testingOutCome != $sample->testingOutCome || !empty($request->comment)) {
            $history = new SamplingStabilityAuditTrail();
            $history->ss_id = $id;
            $history->activity_type = 'Testing Outcome';
            $history->previous = $lastDocument->testingOutCome;
            $history->current = $sample->testingOutCome;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
                if (is_null($lastDocument->testingOutCome) || $lastDocument->testingOutCome === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }

        if ($lastDocument->passFail != $sample->passFail || !empty($request->comment)) {
            $history = new SamplingStabilityAuditTrail();
            $history->ss_id = $id;
            $history->activity_type = 'Pass/Fail';
            $history->previous = $lastDocument->passFail;
            $history->current = $sample->passFail;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
                if (is_null($lastDocument->passFail) || $lastDocument->passFail === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }

        if ($lastDocument->testPlanId != $sample->testPlanId || !empty($request->comment)) {
            $history = new SamplingStabilityAuditTrail();
            $history->ss_id = $id;
            $history->activity_type = 'Test Plan ID';
            $history->previous = $lastDocument->testPlanId;
            $history->current = $sample->testPlanId;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
                if (is_null($lastDocument->testPlanId) || $lastDocument->testPlanId === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }

        if ($lastDocument->turnAroundTime != $sample->turnAroundTime || !empty($request->comment)) {
            $history = new SamplingStabilityAuditTrail();
            $history->ss_id = $id;
            $history->activity_type = 'Turnaround Time (TAT)';
            $history->previous = $lastDocument->turnAroundTime;
            $history->current = $sample->turnAroundTime;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
                if (is_null($lastDocument->turnAroundTime) || $lastDocument->turnAroundTime === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }

        if ($lastDocument->sampleRetestingDate != $sample->sampleRetestingDate || !empty($request->comment)) {
            $history = new SamplingStabilityAuditTrail();
            $history->ss_id = $id;
            $history->activity_type = 'Sample Retesting Date';
            $history->previous = $lastDocument->sampleRetestingDate;
            $history->current = $sample->sampleRetestingDate;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
                if (is_null($lastDocument->sampleRetestingDate) || $lastDocument->sampleRetestingDate === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }

        if ($lastDocument->reviewDate != $sample->reviewDate || !empty($request->comment)) {
            $history = new SamplingStabilityAuditTrail();
            $history->ss_id = $id;
            $history->activity_type = 'Review Date';
            $history->previous = $lastDocument->reviewDate;
            $history->current = $sample->reviewDate;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
                if (is_null($lastDocument->reviewDate) || $lastDocument->reviewDate === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }

        if ($lastDocument->sampleStorageLocation != $sample->sampleStorageLocation || !empty($request->comment)) {
            $history = new SamplingStabilityAuditTrail();
            $history->ss_id = $id;
            $history->activity_type = 'Sample Storage Location';
            $history->previous = $lastDocument->sampleStorageLocation;
            $history->current = $sample->sampleStorageLocation;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
                if (is_null($lastDocument->sampleStorageLocation) || $lastDocument->sampleStorageLocation === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }

        if ($lastDocument->transportationMethod != $sample->transportationMethod || !empty($request->comment)) {
            $history = new SamplingStabilityAuditTrail();
            $history->ss_id = $id;
            $history->activity_type = 'Transportation Method';
            $history->previous = $lastDocument->transportationMethod;
            $history->current = $sample->transportationMethod;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
                if (is_null($lastDocument->transportationMethod) || $lastDocument->transportationMethod === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }

        if ($lastDocument->samplePreparationMethod != $sample->samplePreparationMethod || !empty($request->comment)) {
            $history = new SamplingStabilityAuditTrail();
            $history->ss_id = $id;
            $history->activity_type = 'Sample Preparation Method';
            $history->previous = $lastDocument->samplePreparationMethod;
            $history->current = $sample->samplePreparationMethod;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
                if (is_null($lastDocument->samplePreparationMethod) || $lastDocument->samplePreparationMethod === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }

        if ($lastDocument->samplePackagingDetail != $sample->samplePackagingDetail || !empty($request->comment)) {
            $history = new SamplingStabilityAuditTrail();
            $history->ss_id = $id;
            $history->activity_type = 'Sample Packaging Details';
            $history->previous = $lastDocument->samplePackagingDetail;
            $history->current = $sample->samplePackagingDetail;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
                if (is_null($lastDocument->samplePackagingDetail) || $lastDocument->samplePackagingDetail === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }

        if ($lastDocument->sampleLabel != $sample->sampleLabel || !empty($request->comment)) {
            $history = new SamplingStabilityAuditTrail();
            $history->ss_id = $id;
            $history->activity_type = 'Sample Label';
            $history->previous = $lastDocument->sampleLabel;
            $history->current = $sample->sampleLabel;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
                if (is_null($lastDocument->sampleLabel) || $lastDocument->sampleLabel === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }

        if ($lastDocument->regulatoryRequirement != $sample->regulatoryRequirement || !empty($request->comment)) {
            $history = new SamplingStabilityAuditTrail();
            $history->ss_id = $id;
            $history->activity_type = 'Regulatory Requirements';
            $history->previous = $lastDocument->regulatoryRequirement;
            $history->current = $sample->regulatoryRequirement;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
                if (is_null($lastDocument->regulatoryRequirement) || $lastDocument->regulatoryRequirement === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }

        if ($lastDocument->qualityControlCheck != $sample->qualityControlCheck || !empty($request->comment)) {
            $history = new SamplingStabilityAuditTrail();
            $history->ss_id = $id;
            $history->activity_type = 'Quality Control Checks';
            $history->previous = $lastDocument->qualityControlCheck;
            $history->current = $sample->qualityControlCheck;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
                if (is_null($lastDocument->qualityControlCheck) || $lastDocument->qualityControlCheck === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }

        if ($lastDocument->controlSampleReference != $sample->controlSampleReference || !empty($request->comment)) {
            $history = new SamplingStabilityAuditTrail();
            $history->ss_id = $id;
            $history->activity_type = 'Control Sample Reference';
            $history->previous = $lastDocument->controlSampleReference;
            $history->current = $sample->controlSampleReference;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
                if (is_null($lastDocument->controlSampleReference) || $lastDocument->controlSampleReference === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }

        if ($lastDocument->referencesample != $sample->referencesample || !empty($request->comment)) {
            $history = new SamplingStabilityAuditTrail();
            $history->ss_id = $id;
            $history->activity_type = 'Reference Sample';
            $history->previous = $lastDocument->referencesample;
            $history->current = $sample->referencesample;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
                if (is_null($lastDocument->referencesample) || $lastDocument->referencesample === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }

        if ($lastDocument->controlSample != $sample->controlSample || !empty($request->comment)) {
            $history = new SamplingStabilityAuditTrail();
            $history->ss_id = $id;
            $history->activity_type = 'Control Sample';
            $history->previous = $lastDocument->controlSample;
            $history->current = $sample->controlSample;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
                if (is_null($lastDocument->controlSample) || $lastDocument->controlSample === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }

        if ($lastDocument->sampleIntegrityStatus != $sample->sampleIntegrityStatus || !empty($request->comment)) {
            $history = new SamplingStabilityAuditTrail();
            $history->ss_id = $id;
            $history->activity_type = 'Sample Integrity Status';
            $history->previous = $lastDocument->sampleIntegrityStatus;
            $history->current = $sample->sampleIntegrityStatus;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
                if (is_null($lastDocument->sampleIntegrityStatus) || $lastDocument->sampleIntegrityStatus === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }

        if ($lastDocument->assignedDepartmentII != $sample->assignedDepartmentII || !empty($request->comment)) {
            $history = new SamplingStabilityAuditTrail();
            $history->ss_id = $id;
            $history->activity_type = 'Assigned Department';
            $history->previous = $lastDocument->assignedDepartmentII;
            $history->current = $sample->assignedDepartmentII;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
                if (is_null($lastDocument->assignedDepartmentII) || $lastDocument->assignedDepartmentII === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }

        if ($lastDocument->riskAssessment != $sample->riskAssessment || !empty($request->comment)) {
            $history = new SamplingStabilityAuditTrail();
            $history->ss_id = $id;
            $history->activity_type = 'Risk Assessment';
            $history->previous = $lastDocument->riskAssessment;
            $history->current = $sample->riskAssessment;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
                if (is_null($lastDocument->riskAssessment) || $lastDocument->riskAssessment === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }

        if ($lastDocument->supervisor != $sample->supervisor || !empty($request->comment)) {
            $history = new SamplingStabilityAuditTrail();
            $history->ss_id = $id;
            $history->activity_type = 'Supervisor';
            $history->previous = $lastDocument->supervisor;
            $history->current = $sample->supervisor;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
                if (is_null($lastDocument->supervisor) || $lastDocument->supervisor === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }

        if ($lastDocument->instruments_reserved != $sample->instruments_reserved || !empty($request->comment)) {
            $history = new SamplingStabilityAuditTrail();
            $history->ss_id = $id;
            $history->activity_type = 'Instruments Reserved';
            $history->previous = $lastDocument->instruments_reserved;
            $history->current = $sample->instruments_reserved;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
                if (is_null($lastDocument->instruments_reserved) || $lastDocument->instruments_reserved === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }

        if ($lastDocument->lab_availability != $sample->lab_availability || !empty($request->comment)) {
            $history = new SamplingStabilityAuditTrail();
            $history->ss_id = $id;
            $history->activity_type = 'Lab Availability';
            $history->previous = $lastDocument->lab_availability;
            $history->current = $sample->lab_availability;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
                if (is_null($lastDocument->lab_availability) || $lastDocument->lab_availability === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }

        if ($lastDocument->sample_date != $sample->sample_date || !empty($request->comment)) {
            $history = new SamplingStabilityAuditTrail();
            $history->ss_id = $id;
            $history->activity_type = 'Sample Date';
            $history->previous = $lastDocument->sample_date;
            $history->current = $sample->sample_date;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
                if (is_null($lastDocument->sample_date) || $lastDocument->sample_date === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }

        if ($lastDocument->sample_movement_history != $sample->sample_movement_history || !empty($request->comment)) {
            $history = new SamplingStabilityAuditTrail();
            $history->ss_id = $id;
            $history->activity_type = 'Sample Movement History';
            $history->previous = $lastDocument->sample_movement_history;
            $history->current = $sample->sample_movement_history;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
                if (is_null($lastDocument->sample_movement_history) || $lastDocument->sample_movement_history === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }

                if (!empty($request->stp_attachment)) {
                    $files = [];
                    if ($request->hasfile('stp_attachment')) {
                        foreach ($request->file('stp_attachment') as $file) {
                            $name = $request->name . 'stp_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                            $file->move('upload/', $name);
                            $files[] = $name;
                        }
                    }
                    $sample->stp_attachment = json_encode($files);
                }
                
        if ($lastDocument->testing_progress != $sample->testing_progress || !empty($request->comment)) {
            $history = new SamplingStabilityAuditTrail();
            $history->ss_id = $id;
            $history->activity_type = 'Testing Progress';
            $history->previous = $lastDocument->testing_progress;
            $history->current = $sample->testing_progress;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
                if (is_null($lastDocument->testing_progress) || $lastDocument->testing_progress === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }

        if ($lastDocument->deviation_logs != $sample->deviation_logs || !empty($request->comment)) {
            $history = new SamplingStabilityAuditTrail();
            $history->ss_id = $id;
            $history->activity_type = 'Deviation Logs';
            $history->previous = $lastDocument->deviation_logs;
            $history->current = $sample->deviation_logs;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
                if (is_null($lastDocument->deviation_logs) || $lastDocument->deviation_logs === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }

        if ($lastDocument->commentNotes != $sample->commentNotes || !empty($request->comment)) {
            $history = new SamplingStabilityAuditTrail();
            $history->ss_id = $id;
            $history->activity_type = 'Comments/Notes';
            $history->previous = $lastDocument->commentNotes;
            $history->current = $sample->commentNotes;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
                if (is_null($lastDocument->commentNotes) || $lastDocument->commentNotes === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }

        if ($lastDocument->samplingFrequency != $sample->samplingFrequency || !empty($request->comment)) {
            $history = new SamplingStabilityAuditTrail();
            $history->ss_id = $id;
            $history->activity_type = 'Sampling Frequency';
            $history->previous = $lastDocument->samplingFrequency;
            $history->current = $sample->samplingFrequency;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
                if (is_null($lastDocument->samplingFrequency) || $lastDocument->samplingFrequency === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }

        if ($lastDocument->sampleDisposition != $sample->sampleDisposition || !empty($request->comment)) {
            $history = new SamplingStabilityAuditTrail();
            $history->ss_id = $id;
            $history->activity_type = 'Sample Disposition';
            $history->previous = $lastDocument->sampleDisposition;
            $history->current = $sample->sampleDisposition;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
                if (is_null($lastDocument->sampleDisposition) || $lastDocument->sampleDisposition === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }

        if ($lastDocument->reviewerApprover != $sample->reviewerApprover || !empty($request->comment)) {
            $history = new SamplingStabilityAuditTrail();
            $history->ss_id = $id;
            $history->activity_type = 'Reviewer/Approver';
            $history->previous = $lastDocument->reviewerApprover;
            $history->current = $sample->reviewerApprover;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
                if (is_null($lastDocument->reviewerApprover) || $lastDocument->reviewerApprover === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }

        if ($lastDocument->reviewDate != $sample->reviewDate || !empty($request->comment)) {
            $history = new SamplingStabilityAuditTrail();
            $history->ss_id = $id;
            $history->activity_type = 'Review Date';
            $history->previous = $lastDocument->reviewDate;
            $history->current = $sample->reviewDate;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
                if (is_null($lastDocument->reviewDate) || $lastDocument->reviewDate === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }

        if ($lastDocument->qaReviewerComment != $sample->qaReviewerComment || !empty($request->comment)) {
            $history = new SamplingStabilityAuditTrail();
            $history->ss_id = $id;
            $history->activity_type = 'Reviewer Comment';
            $history->previous = $lastDocument->qaReviewerComment;
            $history->current = $sample->qaReviewerComment;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
                if (is_null($lastDocument->qaReviewerComment) || $lastDocument->qaReviewerComment === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }

        if ($lastDocument->stabilityStudyType != $sample->stabilityStudyType || !empty($request->comment)) {
            $history = new SamplingStabilityAuditTrail();
            $history->ss_id = $id;
            $history->activity_type = 'Stability Study Type';
            $history->previous = $lastDocument->stabilityStudyType;
            $history->current = $sample->stabilityStudyType;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
                if (is_null($lastDocument->stabilityStudyType) || $lastDocument->stabilityStudyType === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }

        if ($lastDocument->ichZone != $sample->ichZone || !empty($request->comment)) {
            $history = new SamplingStabilityAuditTrail();
            $history->ss_id = $id;
            $history->activity_type = 'ICH Zone';
            $history->previous = $lastDocument->ichZone;
            $history->current = $sample->ichZone;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
                if (is_null($lastDocument->ichZone) || $lastDocument->ichZone === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }

        if ($lastDocument->sampleDisposition != $sample->sampleDisposition || !empty($request->comment)) {
            $history = new SamplingStabilityAuditTrail();
            $history->ss_id = $id;
            $history->activity_type = 'Sample Disposition';
            $history->previous = $lastDocument->sampleDisposition;
            $history->current = $sample->sampleDisposition;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
                if (is_null($lastDocument->sampleDisposition) || $lastDocument->sampleDisposition === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }

        if ($lastDocument->photostabilityResults != $sample->photostabilityResults || !empty($request->comment)) {
            $history = new SamplingStabilityAuditTrail();
            $history->ss_id = $id;
            $history->activity_type = 'Photostability Testing Results';
            $history->previous = $lastDocument->photostabilityResults;
            $history->current = $sample->photostabilityResults;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
                if (is_null($lastDocument->photostabilityResults) || $lastDocument->photostabilityResults === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }

        if ($lastDocument->reconstitutionStability != $sample->reconstitutionStability || !empty($request->comment)) {
            $history = new SamplingStabilityAuditTrail();
            $history->ss_id = $id;
            $history->activity_type = 'Reconstitution Stability';
            $history->previous = $lastDocument->reconstitutionStability;
            $history->current = $sample->reconstitutionStability;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
                if (is_null($lastDocument->reconstitutionStability) || $lastDocument->reconstitutionStability === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }

        if ($lastDocument->protocolApprovalDate != $sample->protocolApprovalDate || !empty($request->comment)) {
            $history = new SamplingStabilityAuditTrail();
            $history->ss_id = $id;
            $history->activity_type = 'Stability Protocol Approval Date';
            $history->previous = $lastDocument->protocolApprovalDate;
            $history->current = $sample->protocolApprovalDate;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
                if (is_null($lastDocument->protocolApprovalDate) || $lastDocument->protocolApprovalDate === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }



        // Grid



        $ssGrid = $sample->id;
        // if($request->has('instrumentDetail')){
        if (!empty($request->testparameterrow)) {
        $TestParameter = SampleStability_Grid::where(['ssgrid_id' => $ssGrid, 'identifier' => 'Test Parameter Row'])->firstOrNew();
        $TestParameter->ssgrid_id = $ssGrid;
        $TestParameter->identifier = 'Test Parameter Row';
        $TestParameter->data = $request->testparameterrow;
        $TestParameter->save();
        }

        toastr()->success("Record is created Successfully");
        return redirect(url('rcms/qms-dashboard'));
        if ($lastDocument->testingInterval != $sample->testingInterval || !empty($request->comment)) {
            $history = new SamplingStabilityAuditTrail();
            $history->ss_id = $id;
            $history->activity_type = 'Testing Interval (months)';
            $history->previous = $lastDocument->testingInterval;
            $history->current = $sample->testingInterval;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
                if (is_null($lastDocument->testingInterval) || $lastDocument->testingInterval === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }

        if ($lastDocument->regulatoryCountry != $sample->regulatoryCountry || !empty($request->comment)) {
            $history = new SamplingStabilityAuditTrail();
            $history->ss_id = $id;
            $history->activity_type = 'Country of Regulatory Submissions';
            $history->previous = $lastDocument->regulatoryCountry;
            $history->current = $sample->regulatoryCountry;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
                if (is_null($lastDocument->regulatoryCountry) || $lastDocument->regulatoryCountry === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }

        if ($lastDocument->shelfLife != $sample->shelfLife || !empty($request->comment)) {
            $history = new SamplingStabilityAuditTrail();
            $history->ss_id = $id;
            $history->activity_type = 'Shelf Life Recommendation';
            $history->previous = $lastDocument->shelfLife;
            $history->current = $sample->shelfLife;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
                if (is_null($lastDocument->shelfLife) || $lastDocument->shelfLife === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }

        if ($lastDocument->qaReviewerApprover != $sample->qaReviewerApprover || !empty($request->comment)) {
            $history = new SamplingStabilityAuditTrail();
            $history->ss_id = $id;
            $history->activity_type = 'QA Reviewer/Approver';
            $history->previous = $lastDocument->qaReviewerApprover;
            $history->current = $sample->qaReviewerApprover;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
                if (is_null($lastDocument->qaReviewerApprover) || $lastDocument->qaReviewerApprover === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id){
        $samples = SampleStability::find($id);
        $ssgrid = SampleStability_Grid::where('ssgrid_id',$id)->first();

        // dd($samples);

        return view('frontend.sampling-stability.view_sampling_stability', compact('samples','ssgrid'));
    }
        if ($lastDocument->qaReviewDate != $sample->qaReviewDate || !empty($request->comment)) {
            $history = new SamplingStabilityAuditTrail();
            $history->ss_id = $id;
            $history->activity_type = 'QA Review Date';
            $history->previous = $lastDocument->qaReviewDate;
            $history->current = $sample->qaReviewDate;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
                if (is_null($lastDocument->qaReviewDate) || $lastDocument->qaReviewDate === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }

        if ($lastDocument->qaReviewerComment != $sample->qaReviewerComment || !empty($request->comment)) {
            $history = new SamplingStabilityAuditTrail();
            $history->ss_id = $id;
            $history->activity_type = 'QA Reviewer Comment';
            $history->previous = $lastDocument->qaReviewerComment;
            $history->current = $sample->qaReviewerComment;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
                if (is_null($lastDocument->qaReviewerComment) || $lastDocument->qaReviewerComment === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }

        if ($lastDocument->initiatorName != $sample->initiatorName || !empty($request->comment)) {
            $history = new SamplingStabilityAuditTrail();
            $history->ss_id = $id;
            $history->activity_type = 'Initiator Name';
            $history->previous = $lastDocument->initiatorName;
            $history->current = $sample->initiatorName;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
                if (is_null($lastDocument->initiatorName) || $lastDocument->initiatorName === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }

        if ($lastDocument->labTechnicianName != $sample->labTechnicianName || !empty($request->comment)) {
            $history = new SamplingStabilityAuditTrail();
            $history->ss_id = $id;
            $history->activity_type = 'Lab Technician Name';
            $history->previous = $lastDocument->labTechnicianName;
            $history->current = $sample->labTechnicianName;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
                if (is_null($lastDocument->labTechnicianName) || $lastDocument->labTechnicianName === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }

        $sample->due_date = $request->due_date;
        $sample->short_desc = $request->short_desc;
        $sample->Initiator_Group = $request->Initiator_Group;
        $sample->initiator_group_code = $request->initiator_group_code;
        $sample->assign_to = $request->assign_to;
        $sample->samplePlanId = $request->samplePlanId;
        $sample->sampleId = $request->sampleId;
        $sample->sampleName = $request->sampleName;
        $sample->sampleType = $request->sampleType;
        $sample->productMaterialName = $request->productMaterialName;
        $sample->batchLotNumber = $request->batchLotNumber;
        $sample->samplePriority = $request->samplePriority;
        $sample->sampleQuantity = $request->sampleQuantity;
        $sample->UOM = $request->UOM;
        $sample->market = $request->market;
        $sample->sampleBarCode = $request->sampleBarCode;
        $sample->specificationId = $request->specificationId;
        $sample->stpId = $request->stpId;
        $sample->stp_attachment = $request->stp_attachment;
        $sample->testName = $request->testName;
        $sample->testMethod = $request->testMethod;
        $sample->testParameter = $request->testParameter;
        $sample->testingFrequency = $request->testingFrequency;
        $sample->testingLocation = $request->testingLocation;
        $sample->requiredInstrument = $request->requiredInstrument;
        $sample->testGrouping = $request->testGrouping;
        $sample->lsl = $request->lsl;
        $sample->usl = $request->usl;
        $sample->labTechnician = $request->labTechnician;
        $sample->sampleCostEstimation = $request->sampleCostEstimation;
        $sample->resourceUtilization = $request->resourceUtilization;
        $sample->assignedDepartment = $request->assignedDepartment;
        $sample->testGrouping_ii = $request->testGrouping_ii;
        $sample->sampleCollectionDate = $request->sampleCollectionDate;
        // $sample->suupportive_attachment_gi = $request->suupportive_attachment_gi;
        $sample->analysisType = $request->analysisType;
        // dd($sample->analysisType);
        $sample->analysisResult = $request->analysisResult;
        $sample->analysisDate = $request->analysisDate;
        $sample->testingStartDate = $request->testingStartDate;
        $sample->testingEndDate = $request->testingEndDate;
        $sample->delayJustification = $request->delayJustification;
        $sample->testingOutCome = $request->testingOutCome;
        $sample->passFail = $request->passFail;
        $sample->testPlanId = $request->testPlanId;
        $sample->turnAroundTime = $request->turnAroundTime;
        $sample->sampleRetestingDate = $request->sampleRetestingDate;
        $sample->reviewDate = $request->reviewDate;
        $sample->sampleStorageLocation = $request->sampleStorageLocation;
        $sample->transportationMethod = $request->transportationMethod;
        $sample->samplePreparationMethod = $request->samplePreparationMethod;
        $sample->samplePackagingDetail = $request->samplePackagingDetail;
        $sample->sampleLabel = $request->sampleLabel;
        $sample->regulatoryRequirement = $request->regulatoryRequirement;
        $sample->qualityControlCheck = $request->qualityControlCheck;
        $sample->controlSampleReference = $request->controlSampleReference;
        $sample->referencesample = $request->referencesample;
        $sample->controlSample = $request->controlSample;
        $sample->sampleIntegrityStatus = $request->sampleIntegrityStatus;
        $sample->assignedDepartmentII = $request->assignedDepartmentII;
        $sample->assignedDepartment = $request->assignedDepartment;
        $sample->riskAssessment = $request->riskAssessment;
        $sample->supervisor = $request->supervisor;
        $sample->instruments_reserved = $request->instruments_reserved;
        $sample->lab_availability = $request->lab_availability;
        $sample->sample_date = $request->sample_date;
        $sample->sample_movement_history = $request->sample_movement_history;
        $sample->testing_progress = $request->testing_progress;
        $sample->deviation_logs = $request->deviation_logs;
        $sample->commentNotes = $request->commentNotes;
        // $sample->analysis_attachment = $request->analysis_attachment;
        $sample->samplingFrequency = $request->samplingFrequency;
        $sample->sampleDisposition = $request->sampleDisposition;
        // $sample->supportive_attachment = $request->supportive_attachment;
        $sample->reviewerApprover = $request->reviewerApprover;
        $sample->reviewerComment = $request->reviewerComment;
        $sample->reviewDate = $request->reviewDate;
        $sample->stabilityStudyType = $request->stabilityStudyType;
        $sample->selectDisposition = $request->selectDisposition;
        // $sample->stabilityStudyProtocol = $request->stabilityStudyProtocol;
        $sample->protocolApprovalDate = $request->protocolApprovalDate;
        $sample->regulatoryCountry = $request->regulatoryCountry;
        $sample->ichZone = $request->ichZone;
        $sample->photostabilityResults = $request->photostabilityResults;
        $sample->reconstitutionStability = $request->reconstitutionStability;
        $sample->testingInterval = $request->testingInterval;
        $sample->shelfLife = $request->shelfLife;
        // $sample->supportiveAttachment = $request->supportiveAttachment;
        $sample->qaReviewerApprover = $request->qaReviewerApprover;
        $sample->qaReviewDate = $request->qaReviewDate;
        $sample->qaReviewerComment = $request->qaReviewerComment;
        $sample->initiatorName = $request->initiatorName;
        $sample->dateOfInitiation = $request->dateOfInitiation;
        $sample->labTechnicianName = $request->labTechnicianName;
        $sample->dateOfLabTechReview = $request->dateOfLabTechReview;
        $sample->supervisorName = $request->supervisorName;
        $sample->dateOfSupervisionReview = $request->dateOfSupervisionReview;
        $sample->qaReview = $request->qaReview;
        $sample->dateOfQaReview = $request->dateOfQaReview;



         // Attachments specification_attachment 
         if (!empty($request->specification_attachment)) {
            $files = [];
            if ($request->hasfile('specification_attachment')) {
                foreach ($request->file('specification_attachment') as $file) {
                    $name = $request->name . 'specification_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $sample->specification_attachment = json_encode($files);
        }


                // Attachments Supportive Attachment 
                if (!empty($request->suupportive_attachment_gi)) {
                    $files = [];
                    if ($request->hasfile('suupportive_attachment_gi')) {
                        foreach ($request->file('suupportive_attachment_gi') as $file) {
                            $name = $request->name . 'suupportive_attachment_gi' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                            $file->move('upload/', $name);
                            $files[] = $name;
                        }
                    }
                    $sample->suupportive_attachment_gi = json_encode($files);
                }


                if (!empty($request->analysis_attachment)) {
                    $files = [];
                    if ($request->hasfile('analysis_attachment')) {
                        foreach ($request->file('analysis_attachment') as $file) {
                            $name = $request->name . 'analysis_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                            $file->move('upload/', $name);
                            $files[] = $name;
                        }
                    }
                    $sample->analysis_attachment = json_encode($files);
                }

                
                // dd($sample->analysis_attachment);
                
                
                if (!empty($request->supportive_attachment)) {
                    $files = [];
                    if ($request->hasfile('supportive_attachment')) {
                        foreach ($request->file('supportive_attachment') as $file) {
                            $name = $request->name . 'supportive_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                            $file->move('upload/', $name);
                            $files[] = $name;
                        }
                    }
                    $sample->supportive_attachment = json_encode($files);
                }

                if (!empty($request->supportiveAttachment)) {
                    $files = [];
                    if ($request->hasfile('supportiveAttachment')) {
                        foreach ($request->file('supportiveAttachment') as $file) {
                            $name = $request->name . 'supportiveAttachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                            $file->move('upload/', $name);
                            $files[] = $name;
                        }
                    }
                    $sample->supportiveAttachment = json_encode($files);
                }

                if (!empty($request->stabilityStudyProtocol)) {
                    $files = [];
                    if ($request->hasfile('stabilityStudyProtocol')) {
                        foreach ($request->file('stabilityStudyProtocol') as $file) {
                            $name = $request->name . 'stabilityStudyProtocol' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                            $file->move('upload/', $name);
                            $files[] = $name;
                        }
                    }
                    $sample->stabilityStudyProtocol = json_encode($files);
                }

                if (!empty($request->supportiveAttachmentsss)) {
                    $files = [];
                    if ($request->hasfile('supportiveAttachmentsss')) {
                        foreach ($request->file('supportiveAttachmentsss') as $file) {
                            $name = $request->name . 'supportiveAttachmentsss' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                            $file->move('upload/', $name);
                            $files[] = $name;
                        }
                    }
                    $sample->supportiveAttachmentsss = json_encode($files);
                }



                if (!empty($request->qa_supportive_attachment)) {
                    $files = [];
                    if ($request->hasfile('qa_supportive_attachment')) {
                        foreach ($request->file('qa_supportive_attachment') as $file) {
                            $name = $request->name . 'qa_supportive_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                            $file->move('upload/', $name);
                            $files[] = $name;
                        }
                    }
                    $sample->qa_supportive_attachment = json_encode($files);
                }


                if (!empty($request->stp_attachment)) {
                    $files = [];
                    if ($request->hasfile('stp_attachment')) {
                        foreach ($request->file('stp_attachment') as $file) {
                            $name = $request->name . 'stp_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                            $file->move('upload/', $name);
                            $files[] = $name;
                        }
                    }
                    $sample->stp_attachment = json_encode($files);
                }


                

                // dd($sample->qa_supportive_attachment);

        // Attachments 


        $sample->update();
        if ($lastDocument->dateOfInitiation != $sample->dateOfInitiation || !empty($request->comment)) {
            $history = new SamplingStabilityAuditTrail();
            $history->ss_id = $id;
            $history->activity_type = 'Date of Initiation';
            $history->previous = Helpers::getdateFormat($lastDocument->dateOfInitiation);
            $history->current = Helpers::getdateFormat($sample->dateOfInitiation);
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
                if (is_null($lastDocument->dateOfInitiation) || $lastDocument->dateOfInitiation === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }

        if ($lastDocument->dateOfLabTechReview != $sample->dateOfLabTechReview || !empty($request->comment)) {
            $history = new SamplingStabilityAuditTrail();
            $history->ss_id = $id;
            $history->activity_type = 'Date of Lab Technician Review';
            $history->previous = $lastDocument->dateOfLabTechReview;
            $history->current = $sample->dateOfLabTechReview;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
                if (is_null($lastDocument->dateOfLabTechReview) || $lastDocument->dateOfLabTechReview === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }

        if ($lastDocument->supervisorName != $sample->supervisorName || !empty($request->comment)) {
            $history = new SamplingStabilityAuditTrail();
            $history->ss_id = $id;
            $history->activity_type = 'Supervisor Name';
            $history->previous = $lastDocument->supervisorName;
            $history->current = $sample->supervisorName;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
                if (is_null($lastDocument->supervisorName) || $lastDocument->supervisorName === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }

        if ($lastDocument->qaReview != $sample->qaReview || !empty($request->comment)) {
            $history = new SamplingStabilityAuditTrail();
            $history->ss_id = $id;
            $history->activity_type = 'QA Review';
            $history->previous = $lastDocument->qaReview;
            $history->current = $sample->qaReview;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
                if (is_null($lastDocument->qaReview) || $lastDocument->qaReview === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }

        if ($lastDocument->dateOfSupervisionReview != $sample->dateOfSupervisionReview || !empty($request->comment)) {
            $history = new SamplingStabilityAuditTrail();
            $history->ss_id = $id;
            $history->activity_type = 'Date of Supervision Review';
            $history->previous = $lastDocument->dateOfSupervisionReview;
            $history->current = $sample->dateOfSupervisionReview;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
                if (is_null($lastDocument->dateOfSupervisionReview) || $lastDocument->dateOfSupervisionReview === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }

        if ($lastDocument->dateOfQaReview != $sample->dateOfQaReview || !empty($request->comment)) {
            $history = new SamplingStabilityAuditTrail();
            $history->ss_id = $id;
            $history->activity_type = 'Date of QA Review';
            $history->previous = $lastDocument->dateOfQaReview;
            $history->current = $sample->dateOfQaReview;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
                if (is_null($lastDocument->dateOfQaReview) || $lastDocument->dateOfQaReview === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }


        $ssGrid = $sample->id;
        // if($request->has('instrumentDetail')){
        if (!empty($request->testparameterrow)) {
        $TestParameter = SampleStability_Grid::where(['ssgrid_id' => $ssGrid, 'identifier' => 'Test Parameter Row'])->firstOrNew();
        $TestParameter->ssgrid_id = $ssGrid;
        $TestParameter->identifier = 'Test Parameter Row';
        $TestParameter->data = $request->testparameterrow;
        $TestParameter->save();
        }

        toastr()->success("Record is Updated Successfully");
        return back();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function SSStateChange(Request $request, $id)
    {
        if ($request->username == Auth::user()->Username && Hash::check($request->password, Auth::user()->password)) {
            $sampler = SampleStability::find($id);
            $lastDocument = SampleStability::find($id);
            if ($sampler->stage == 1) {
                    $sampler->stage = "2";
                    $sampler->status = "Pending Analysis";
                    $sampler->submitted_by = Auth::user()->name;
                    $sampler->submitted_on = Carbon::now()->format('d-M-Y');
                    $sampler->submitted_comment = $request->comments;

                    $history = new SamplingStabilityAuditTrail();
                    $history->ss_id = $id;
                    $history->activity_type = 'Sample Registration By, Sample Registration On';
                    if (is_null($lastDocument->submitted_by) || $lastDocument->submitted_by === '') {
                        $history->previous = "Null";
                    } else {
                        $history->previous = $lastDocument->submitted_by . ' , ' . $lastDocument->submitted_on;
                    }
                    $history->current = $sampler->submitted_by . ' , ' . $sampler->submitted_on;
                    $history->action='Sample Registration';
                    $history->comment = $request->comments;
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $lastDocument->status;
                    $history->change_to =   "Pending Analysis";
                    $history->change_from = $lastDocument->status;
                    $history->stage = 'Sample Regsitration';
                    if (is_null($lastDocument->submitted_by) || $lastDocument->submitted_by === '') {
                        $history->action_name = 'New';
                    } else {
                        $history->action_name = 'Update';
                    }
                    $history->save();

                 

                    $sampler->update();

                    toastr()->success('Sent to Pending Initiating Department Update');
                    return back();
            }
            if ($sampler->stage == 2) {
                    $sampler->stage = "3";
                    $sampler->status = "Pending Supervisor Review";
                    $sampler->analysis_complete_by = Auth::user()->name;
                    $sampler->analysis_complete_on = Carbon::now()->format('d-M-Y');
                    $sampler->analysis_complete_comment = $request->comments;

                    $history = new SamplingStabilityAuditTrail();
                    $history->ss_id = $id;
                    $history->activity_type = 'Analysis Complete By, Analysis Complete On';
                    if (is_null($lastDocument->analysis_complete_by) || $lastDocument->analysis_complete_by === '') {
                        $history->previous = "Null";
                    } else {
                        $history->previous = $lastDocument->analysis_complete_by . ' , ' . $lastDocument->analysis_complete_on;
                    }
                    $history->current = $sampler->analysis_complete_by . ' , ' . $sampler->analysis_complete_on;
                    $history->action = 'Analysis Complete';
                    $history->comment = $request->comments;
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $lastDocument->status;
                    $history->change_to =   "Pending Supervisor Review";
                    $history->change_from = $lastDocument->status;
                    $history->stage = 'Pending Supervisor Review';
                    if (is_null($lastDocument->analysis_complete_by) || $lastDocument->analysis_complete_by === '') {
                        $history->action_name = 'New';
                    } else {
                        $history->action_name = 'Update';
                    }
                    $history->save();

                  
                    
                    $sampler->update();

                    toastr()->success('Document Sent');
                    return back();
            }
            if ($sampler->stage == 3) {
                $sampler->stage = "4";
                $sampler->status = "Pending QA Review";
                $sampler->supervisor_review_complete_by = Auth::user()->name;
                $sampler->supervisor_review_complete_on = Carbon::now()->format('d-M-Y');
                $sampler->supervisor_review_complete_comment = $request->comments;

                $history = new SamplingStabilityAuditTrail();
                $history->ss_id = $id;

                $history->activity_type = 'Superviosr Review Complete By, Superviosr Review Complete On';
                if (is_null($lastDocument->supervisor_review_complete_by) || $lastDocument->supervisor_review_complete_by === '') {
                    $history->previous = "Null";
                } else {
                    $history->previous = $lastDocument->supervisor_review_complete_by . ' , ' . $lastDocument->supervisor_review_complete_on;
                }
                $history->current = $sampler->supervisor_review_complete_by . ' , ' . $sampler->supervisor_review_complete_on;

                $history->action = 'Superviosr Review Complete';
                $history->comment = $request->comments;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to =  "Pending QA Review";
                $history->change_from = $lastDocument->status;
                $history->stage = 'Superviosr Review Complete';
                if (is_null($lastDocument->supervisor_review_complete_by) || $lastDocument->supervisor_review_complete_by === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->save();

              
               
                $sampler->update();

                toastr()->success('Document Sent');
                return back();
            }
            if ($sampler->stage == 4) {
                $sampler->stage = "5";
                $sampler->status = "Closed Done";
                $sampler->closed_done_by = Auth::user()->name;
                $sampler->closed_done_on = Carbon::now()->format('d-M-Y');
                $sampler->closed_done_comment = $request->comments;

                $history = new SamplingStabilityAuditTrail();
                $history->ss_id = $id;
                $history->activity_type = 'QA Review Complete By , QA Review Complete By ';
                if (is_null($lastDocument->closed_done_by) || $lastDocument->closed_done_by === '') {
                    $history->previous = "Null";
                } else {
                    $history->previous = $lastDocument->closed_done_by . ' , ' . $lastDocument->closed_done_on;
                }
                $history->current = $sampler->closed_done_by . ' , ' . $sampler->closed_done_on;
                $history->action = 'QA Review Complete';
                $history->comment = $request->comments;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to = "Closed Done";
                $history->change_from = $lastDocument->status;
                $history->stage = 'QA Review Complete';
                if (is_null($lastDocument->closed_done_by) || $lastDocument->closed_done_by === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->save();

                $list = Helpers::getCqaDepartmentList($sampler->division_id);
                $userIds = collect($list)->pluck('user_id')->toArray();
                $users = User::whereIn('id', $userIds)->select('id', 'name', 'email')->get();
                $userId = $users->pluck('id')->implode(',');
                if(!empty($users)){
                    try {
                        $history = new samplerAuditTrail();
                        $history->sampler_id = $id;
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
                        $history->change_from = "Pending CQA Review After Purchase Sample Request";
                        $history->stage = "";
                        $history->action_name = "";
                        $history->mailUserId = $userId;
                        $history->role_name = "CQA";
                        $history->save();
                    } catch (\Throwable $e) {
                        \Log::error('Mail failed to send: ' . $e->getMessage());
                    }
                }

                foreach ($list as $u) {
                    // if($u->q_m_s_divisions_id == $sampler->division_id){
                        $email = Helpers::getCQAEmail($u->user_id);
                        if (!empty($email)) {
                            try {
                                Mail::send(
                                    'mail.view-mail',
                                    ['data' => $sampler, 'history' => "Purchase Sample Request Initiated & Acknowledgement By PD ", 'process' => 'sampler', 'comment' => $request->comments, 'user'=> Auth::user()->name],
                                    function ($message) use ($email, $sampler) {
                                        $message->to($email)
                                        ->subject("QMS Notification: sampler, Record #" . str_pad($sampler->record, 4, '0', STR_PAD_LEFT) . " - Activity: Purchase Sample Request Initiated & Acknowledgement By PD Performed");
                                    }
                                );
                            } catch (\Exception $e) {
                                \Log::error('Mail failed to send: ' . $e->getMessage());
                            }
                        }
                    // }
                }

                $sampler->update();

                toastr()->success('Document Sent');
                return back();
            }
            if ($sampler->stage == 5) {
                $sampler->stage = "6";
                $sampler->status = "Pending F&D Review";
                $sampler->purchaseSampleanalysis_by = Auth::user()->name;
                $sampler->purchaseSampleanalysis_on = Carbon::now()->format('d-M-Y');
                $sampler->purchaseSampleanalysis_comment = $request->comments;

                $history = new samplerAuditTrail();
                $history->sampler_id = $id;
                $history->activity_type = 'Activity Log';
                $history->activity_type = 'Purchase Sample Analysis Satisfactory By , Purchase Sample Analysis Satisfactory On';
                if (is_null($lastDocument->purchaseSampleanalysis_by) || $lastDocument->purchaseSampleanalysis_by === '') {
                    $history->previous = "Null";
                } else {
                    $history->previous = $lastDocument->purchaseSampleanalysis_by . ' , ' . $lastDocument->purchaseSampleanalysis_on;
                }
                $history->current = $sampler->purchaseSampleanalysis_by . ' , ' . $sampler->purchaseSampleanalysis_on;
                $history->action = 'Purchase Sample Analysis Satisfactory';
                $history->comment = $request->comments;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to = "Pending F&D Review";
                $history->change_from = $lastDocument->status;
                $history->stage = 'Plan Proposed';
                if (is_null($lastDocument->purchaseSampleanalysis_by) || $lastDocument->purchaseSampleanalysis_by === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->save();

                $list = Helpers::getFormulationDepartmentList($sampler->division_id);
                $userIds = collect($list)->pluck('user_id')->toArray();
                $users = User::whereIn('id', $userIds)->select('id', 'name', 'email')->get();
                $userId = $users->pluck('id')->implode(',');
                if(!empty($users)){
                    try {
                        $history = new samplerAuditTrail();
                        $history->sampler_id = $id;
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
                        $history->change_from = "Pending F&D Review";
                        $history->stage = "";
                        $history->action_name = "";
                        $history->mailUserId = $userId;
                        $history->role_name = "Formulation Department";
                        $history->save();
                    } catch (\Throwable $e) {
                        \Log::error('Mail failed to send: ' . $e->getMessage());
                    }
                }

                foreach ($list as $u) {
                    // if($u->q_m_s_divisions_id == $sampler->division_id){
                        $email = Helpers::getFormulationDeptEmail($u->user_id);
                        if (!empty($email)) {
                            try {
                                Mail::send(
                                    'mail.view-mail',
                                    ['data' => $sampler, 'history' => "Purchase Sample Analysis Satisfactory ", 'process' => 'sampler', 'comment' => $request->comments, 'user'=> Auth::user()->name],
                                    function ($message) use ($email, $sampler) {
                                        $message->to($email)
                                        ->subject("QMS Notification: sampler, Record #" . str_pad($sampler->record, 4, '0', STR_PAD_LEFT) . " - Activity: Purchase Sample Analysis Satisfactory Performed");
                                    }
                                );
                            } catch (\Exception $e) {
                                \Log::error('Mail failed to send: ' . $e->getMessage());
                            }
                        }
                    // }
                }
                $sampler->update();

                toastr()->success('Document Sent');
                return back();
            }
        
        
         
         
           
        } else {
            toastr()->error('E-signature Not match');
            return back();
        }
    }

    public function SSAuditTrial($id)
    {
        //$auditrecord = SamplingStabilityAuditTrail::where('ss_id', $id)->orderByDESC('id')->paginate(5);
        $audit = SamplingStabilityAuditTrail::where('ss_id',$id)->orderByDesc('id')->paginate();
        $today = Carbon::now()->format('d-m-y');
        $document = SampleStability::where('id',$id)->first();
        $audit->initiator = User::where('id', $document->initiator_id)->value('name');
    //dd($document);
        return view('frontend.sampling-stability.sampling_stability_audit_trail',compact('audit','document','today'));
    
    
    }

    public function SstabilityAuditReport($id)
    {

        $detail = SamplingStabilityAuditTrail::find($id);
        

        $detail_data = SamplingStabilityAuditTrail::where('activity_type', $detail->activity_type)->where('ss_id', $detail->ss_id)->latest()->get();

        $doc = SampleStability::where('id', $detail->ss_id)->first();

        $doc->origiator_name = User::find($doc->initiator_id);
        return view('frontend.sampling-stability.sampling_stability_audit_report', compact('detail', 'doc', 'detail_data'));


    }

    public static function singleReport($id)
    {    
        $data = SampleStability::find($id);

        if (!empty($data)) {
            $teamData = explode(',', $data->investigation_team);
            $users = User::whereIn('id', $teamData)->pluck('name');
            $userNames = $users->implode(', ');

            $data->originator_id = User::where('id', $data->initiator_id)->value('name');
            $pdf = App::make('dompdf.wrapper');
            $time = Carbon::now();
            $pdf = PDF::loadview('frontend.sampling-stability.singleReport_sample_stability', compact('data','userNames'))
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
            return $pdf->stream('Sample Stability' . $id . '.pdf');
        }
    }




    public function SSChildRoot(Request $request ,$id)
    {
        $cc = SampleStability::find($id);
               $cft = [];
               $parent_id = $id;
               $parent_type = "Sample Stability";
               $old_records = SampleStability::select('id', 'division_id', 'record')->get();
               $data = SampleStability::select('id', 'division_id', 'record')->get();
               $old_record = SampleStability::select('id', 'division_id', 'record')->get();
               $record_number = ((RecordNumber::first()->value('counter')) + 1);
               $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
               $record = ((RecordNumber::first()->value('counter')) + 1);
               $record = str_pad($record_number, 4, '0', STR_PAD_LEFT);
               $parent_record =  ((RecordNumber::first()->value('counter')) + 1);
               $parent_record = str_pad($parent_record, 4, '0', STR_PAD_LEFT);
               $currentDate = Carbon::now();
               $parent_intiation_date = SampleStability::where('id', $id)->value('intiation_date');
               $parent_initiator_id = $id;


               $formattedDate = $currentDate->addDays(30);
               $due_date = $formattedDate->format('d-M-Y');
               $oocOpen = OpenStage::find(1);
               if (!empty($oocOpen->cft)) $cft = explode(',', $oocOpen->cft);


               if ($request->revision == "capa-child") {
                $cc->originator = User::where('id', $cc->initiator_id)->value('name');
                return view('frontend.forms.capa', compact('record_number', 'due_date', 'parent_id', 'parent_type', 'old_records', 'cft'));
                }

               

               if ($request->revision == "OOS") {
                $cc->originator = User::where('id', $cc->initiator_id)->value('name');
                return view('frontend.forms.OOS.OOT.oos_oot', compact('record_number','record', 'due_date', 'parent_id','parent_type','old_record','parent_intiation_date','parent_record','parent_initiator_id'));
            }

            if ($request->revision == "OOT") {
                $cc->originator = User::where('id', $cc->initiator_id)->value('name');
                return view('frontend.OOT.OOT_form', compact('record_number','record', 'due_date', 'parent_id','parent_type','old_record','parent_intiation_date','parent_record','parent_initiator_id','data'));
            }

               if ($request->revision == "Lab-Incident") {
                $cc->originator = User::where('id', $cc->initiator_id)->value('name');
                return view('frontend.forms.lab-incident', compact('record_number','record', 'due_date', 'parent_id','parent_type','old_record','parent_intiation_date','parent_record','parent_initiator_id'));
            }

            
            if ($request->revision == "Action-Item") {
                $cc->originator = User::where('id', $cc->initiator_id)->value('name');
                return view('frontend.action-item.action-item', compact('record_number','record', 'due_date', 'parent_id','parent_type','old_record','parent_intiation_date','parent_record','parent_initiator_id'));
            }
            if ($request->revision == "rca") {
                $cc->originator = User::where('id', $cc->initiator_id)->value('name');
                return view('frontend.forms.root-cause-analysis', compact('record_number','record', 'due_date', 'parent_id','parent_type','old_record','parent_intiation_date','parent_record','parent_initiator_id'));
            }
        



    }

    public function RejectSSStateChange (Request $request, $id)
{
    if ($request->username == Auth::user()->Username && Hash::check($request->password, Auth::user()->password)) {
        $samples = SampleStability::find($id);


        if ($samples->stage == 2) {
            $samples->stage = "1";
            $samples->status = "Opened";
            $samples->update();
            toastr()->success('Document Sent');
            return back();
        }

        if ($samples->stage == 3) {
            $samples->stage = "2";
            $samples->status = "Pending Initial Assessment & Lab Investigation";
            $samples->update();
            toastr()->success('Document Sent');
            return back();
        }
        if ($samples->stage == 4) {
            $samples->stage = "3";
            $samples->status = "Under Stage II B Investigation";
            $samples->update();
            toastr()->success('Document Sent');
            return back();
        }
}
else {
    toastr()->error('E-signature Not match');
    return back();
}
}

   
}
