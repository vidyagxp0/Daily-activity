<?php

namespace App\Http\Controllers;
use App\Models\YearlyTrainingPlanner;
use App\Models\Document;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\YearlyTrainingPlannerAudit;
use App\Models\RoleGroup;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class YearlyTrainingPlannerController extends Controller
{
    public function creatYTPlanner(){
        $data = Document::all();

        return view("frontend.TMS.YearlyTrainingPlanner.yearly_training_planner", compact('data'));
    }

    public function store(Request $request)
    {

        $dataYTP = new YearlyTrainingPlanner();
        $dataYTP->form_type = "yearly-training-planner";
        $dataYTP->stage = '1';
        $dataYTP->status = 'Opened';
        $dataYTP->division_id = $request->division_id;
        $dataYTP->initiator_id = Auth::user()->id;
        $dataYTP->site_division = $request->site_division;
        $dataYTP->department = $request->department;
        $dataYTP->year = $request->year;
        $dataYTP->topic = $request->topic;
        $dataYTP->document_number = $request->document_number;
        $dataYTP->start_date = $request->start_date;
        $dataYTP->end_date = $request->end_date;
        $dataYTP->Review_Comment = $request->Review_Comment;
        $dataYTP->Approval_Comment = $request->Approval_Comment;
        // dd($dataYTP);

        if (!empty($request->Review_Attachments)) {
            $files = [];
            if ($request->hasFile('Review_Attachments')) {
                foreach ($request->file('Review_Attachments') as $file) {
                    $name = $request->name . 'Review_Attachments' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('upload/'), $name);
                    $files[] = $name;
                }
            }
            $dataYTP->Review_Attachments = json_encode($files);
        }

        if (!empty($request->Approval_Attachments)) {
            $files = [];
            if ($request->hasFile('Approval_Attachments')) {
                foreach ($request->file('Approval_Attachments') as $file) {
                    $name = $request->name . 'Approval_Attachments' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('upload/'), $name);
                    $files[] = $name;
                }
            }
            $dataYTP->Approval_Attachments = json_encode($files);
        }

        $dataYTP->save();

        if (!empty($dataYTP->site_division)) {
            $history = new YearlyTrainingPlannerAudit();
            $history->yearly_training_planners_id = $dataYTP->id;
            $history->activity_type = 'Site/Location';
            $history->previous = "Null";
            $history->current = $dataYTP->site_division;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $dataYTP->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($dataYTP->department)) {
            $history = new YearlyTrainingPlannerAudit();
            $history->yearly_training_planners_id = $dataYTP->id;
            $history->activity_type = 'Department';
            $history->previous = "Null";
            $history->current = $dataYTP->department;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $dataYTP->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($dataYTP->year)) {
            $history = new YearlyTrainingPlannerAudit();
            $history->yearly_training_planners_id = $dataYTP->id;
            $history->activity_type = 'Department';
            $history->previous = "Null";
            $history->current = $dataYTP->year;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $dataYTP->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($dataYTP->topic)) {
            $history = new YearlyTrainingPlannerAudit();
            $history->yearly_training_planners_id = $dataYTP->id;
            $history->activity_type = 'Topic/Subject';
            $history->previous = "Null";
            $history->current = $dataYTP->topic;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $dataYTP->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($dataYTP->document_number)) {
            $history = new YearlyTrainingPlannerAudit();
            $history->yearly_training_planners_id = $dataYTP->id;
            $history->activity_type = 'Document Number';
            $history->previous = "Null";
            $history->current = $dataYTP->document_number;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $dataYTP->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($dataYTP->start_date)) {
            $history = new YearlyTrainingPlannerAudit();
            $history->yearly_training_planners_id = $dataYTP->id;
            $history->activity_type = 'Document Number';
            $history->previous = "Null";
            $history->current = $dataYTP->start_date;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $dataYTP->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($dataYTP->end_date)) {
            $history = new YearlyTrainingPlannerAudit();
            $history->yearly_training_planners_id = $dataYTP->id;
            $history->activity_type = 'Document Number';
            $history->previous = "Null";
            $history->current = $dataYTP->end_date;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $dataYTP->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->save();
        }

        toastr()->success("Record is created Successfully");
        return redirect(url('TMS'));

    }


    public function update(Request $request, $id)
    {

        // dd($request->all());
        $dataYTP = YearlyTrainingPlanner::find($id);
        $lastDocument = YearlyTrainingPlanner::find($id);

        $dataYTP->division_id = $request->division_id;
        $dataYTP->initiator_id = Auth::user()->id;
        $dataYTP->site_division = $request->site_division;
        $dataYTP->department = $request->department;
        $dataYTP->year = $request->year;
        $dataYTP->topic = $request->topic;
        $dataYTP->document_number = $request->document_number;
        $dataYTP->start_date = $request->start_date;
        $dataYTP->end_date = $request->end_date;
        $dataYTP->Review_Comment = $request->Review_Comment;
        $dataYTP->Approval_Comment = $request->Approval_Comment;

        if (!empty($request->Review_Attachments) || !empty($request->deleted_Review_Attachments)) {
            $existingFiles = json_decode($dataYTP->Review_Attachments, true) ?? [];

            // Handle deleted files
            if (!empty($request->deleted_Review_Attachments)) {
                $filesToDelete = explode(',', $request->deleted_Review_Attachments);
                $existingFiles = array_filter($existingFiles, function($file) use ($filesToDelete) {
                    return !in_array($file, $filesToDelete);
                });
            }

            // Handle new files
            $newFiles = [];
            if ($request->hasFile('Review_Attachments')) {
                foreach ($request->file('Review_Attachments') as $file) {
                    $name = $request->name . 'Review_Attachments' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('upload/'), $name);
                    $newFiles[] = $name;
                }
            }

            // Merge existing and new files
            $allFiles = array_merge($existingFiles, $newFiles);
            $dataYTP->Review_Attachments = json_encode($allFiles);
        }

        if (!empty($request->Approval_Attachments) || !empty($request->deleted_Approval_Attachments)) {
            $existingFiles = json_decode($dataYTP->Approval_Attachments, true) ?? [];

            // Handle deleted files
            if (!empty($request->deleted_Approval_Attachments)) {
                $filesToDelete = explode(',', $request->deleted_Approval_Attachments);
                $existingFiles = array_filter($existingFiles, function($file) use ($filesToDelete) {
                    return !in_array($file, $filesToDelete);
                });
            }

            // Handle new files
            $newFiles = [];
            if ($request->hasFile('Approval_Attachments')) {
                foreach ($request->file('Approval_Attachments') as $file) {
                    $name = $request->name . 'Approval_Attachments' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('upload/'), $name);
                    $newFiles[] = $name;
                }
            }

            // Merge existing and new files
            $allFiles = array_merge($existingFiles, $newFiles);
            $dataYTP->Approval_Attachments = json_encode($allFiles);
        }

        //  dd($dataYTP);

        $dataYTP->update();


        if ($lastDocument->site_division != $dataYTP->site_division || !empty($request->site_division_comment)) {
            $lastDocumentAuditTrail = YearlyTrainingPlanner::where('id', $dataYTP->id);

            $history = new YearlyTrainingPlannerAudit();
            $history->yearly_training_planners_id = $dataYTP->id;
            $history->activity_type = 'Site/Location';
            $history->previous =  $lastDocument->site_division;
            $history->current = $dataYTP->site_division;
            $history->comment = $request->site_division_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? "Update" : "New";
            $history->save();
        }

        if ($lastDocument->department != $dataYTP->department || !empty($request->department_comment)) {
            $lastDocumentAuditTrail = YearlyTrainingPlanner::where('id', $dataYTP->id);

            $history = new YearlyTrainingPlannerAudit();
            $history->yearly_training_planners_id = $dataYTP->id;
            $history->activity_type = 'Site/Location';
            $history->previous =  $lastDocument->department;
            $history->current = $dataYTP->department;
            $history->comment = $request->department_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? "Update" : "New";
            $history->save();
        }

        if ($lastDocument->year != $dataYTP->year || !empty($request->year_comment)) {
            $lastDocumentAuditTrail = YearlyTrainingPlanner::where('id', $dataYTP->id);

            $history = new YearlyTrainingPlannerAudit();
            $history->yearly_training_planners_id = $dataYTP->id;
            $history->activity_type = 'Site/Location';
            $history->previous =  $lastDocument->year;
            $history->current = $dataYTP->year;
            $history->comment = $request->year_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? "Update" : "New";
            $history->save();
        }

        if ($lastDocument->topic != $dataYTP->topic || !empty($request->topic_comment)) {
            $lastDocumentAuditTrail = YearlyTrainingPlanner::where('id', $dataYTP->id);

            $history = new YearlyTrainingPlannerAudit();
            $history->yearly_training_planners_id = $dataYTP->id;
            $history->activity_type = 'Site/Location';
            $history->previous =  $lastDocument->topic;
            $history->current = $dataYTP->topic;
            $history->comment = $request->topic_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? "Update" : "New";
            $history->save();
        }

        if ($lastDocument->document_number != $dataYTP->document_number || !empty($request->document_number_comment)) {
            $lastDocumentAuditTrail = YearlyTrainingPlanner::where('id', $dataYTP->id);

            $history = new YearlyTrainingPlannerAudit();
            $history->yearly_training_planners_id = $dataYTP->id;
            $history->activity_type = 'Site/Location';
            $history->previous =  $lastDocument->document_number;
            $history->current = $dataYTP->document_number;
            $history->comment = $request->document_number_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? "Update" : "New";
            $history->save();
        }

        if ($lastDocument->document_number != $dataYTP->document_number || !empty($request->document_number_comment)) {
            $lastDocumentAuditTrail = YearlyTrainingPlanner::where('id', $dataYTP->id);

            $history = new YearlyTrainingPlannerAudit();
            $history->yearly_training_planners_id = $dataYTP->id;
            $history->activity_type = 'Site/Location';
            $history->previous =  $lastDocument->document_number;
            $history->current = $dataYTP->document_number;
            $history->comment = $request->document_number_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? "Update" : "New";
            $history->save();
        }

        if ($lastDocument->start_date != $dataYTP->start_date || !empty($request->start_date_comment)) {
            $lastDocumentAuditTrail = YearlyTrainingPlanner::where('id', $dataYTP->id);

            $history = new YearlyTrainingPlannerAudit();
            $history->yearly_training_planners_id = $dataYTP->id;
            $history->activity_type = 'Site/Location';
            $history->previous =  $lastDocument->start_date;
            $history->current = $dataYTP->start_date;
            $history->comment = $request->start_date_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? "Update" : "New";
            $history->save();
        }

        if ($lastDocument->end_date != $dataYTP->end_date || !empty($request->end_date_comment)) {
            $lastDocumentAuditTrail = YearlyTrainingPlanner::where('id', $dataYTP->id);

            $history = new YearlyTrainingPlannerAudit();
            $history->yearly_training_planners_id = $dataYTP->id;
            $history->activity_type = 'Site/Location';
            $history->previous =  $lastDocument->end_date;
            $history->current = $dataYTP->end_date;
            $history->comment = $request->end_date_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? "Update" : "New";
            $history->save();
        }


        toastr()->success("Record is updated Successfully");
        return back();
    }


    public function show($id){

        $data = Document::all();
        $dataYTP = YearlyTrainingPlanner::find($id);
        $today = Carbon::now()->format('d-m-y');
        $document = YearlyTrainingPlanner::where('id', $id)->first();
        $document->initiator = User::where('id', $document->initiator_id)->value('name');
        $selectedYear = $dataYTP->year;
        // dd($dataYTP);

        return view('frontend.TMS.YearlyTrainingPlanner.yearly_training_plan_view', compact('dataYTP','data', 'document','today','selectedYear'));

    }

    public function auditTrial($id)
    {
        $audit = YearlyTrainingPlannerAudit::where('yearly_training_planners_id', $id)->orderByDESC('id')->paginate();
        $dataYTP = YearlyTrainingPlanner::find($id);
        $today = Carbon::now()->format('d-m-y');
        $document = YearlyTrainingPlanner::where('id', $id)->first();
        $document->initiator = User::where('id', $document->initiator_id)->value('name');

        return view('frontend.TMS.YearlyTrainingPlanner.audit-trial-inner', compact('audit','dataYTP','document','today'));

    }


    public function sendStage(Request $request, $id)
    {
        try {

            if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {

                $dataYTP = YearlyTrainingPlanner::find($id);
                $lastDataYTP = YearlyTrainingPlanner::find($id);

                if ($dataYTP->stage == 1) {
                    $dataYTP->stage = "2";
                    $dataYTP->status = "In Review";
                    $dataYTP->y_t_p_submit_by = Auth::user()->name;
                    $dataYTP->y_t_p_submit_on = Carbon::now()->format('d-m-Y');
                    $dataYTP->y_t_p_comment = $request->comment;

                    $history = new YearlyTrainingPlannerAudit();
                    $history->yearly_training_planners_id = $id;
                    $history->activity_type = 'Submit By, Submit On';
                    if (is_null($lastDataYTP->y_t_p_submit_by) || $lastDataYTP->y_t_p_submit_by === '') {
                        $history->previous = "NULL";
                    } else {
                        $history->previous = $lastDataYTP->y_t_p_submit_by . ' , ' . $lastDataYTP->y_t_p_submit_on;
                    }
                    $history->current = $dataYTP->y_t_p_submit_by . ' , ' . $dataYTP->y_t_p_submit_on;
                    if (is_null($lastDataYTP->y_t_p_submit_by) || $lastDataYTP->y_t_p_submit_on === '') {
                        $history->action_name = 'New';
                    } else {
                        $history->action_name = 'Update';
                    }
                    // $history->activity_type = 'Submit';
                    // $history->current = $dataYTP->y_t_p_submit_by;
                    $history->comment = $request->comment;
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to = "In review";
                    $history->change_from = $lastDataYTP->status;
                    $history->action = 'Submit';
                    $history->stage = 'Opened';
                    $history->save();

                    $dataYTP->update();

                    toastr()->success('Document Sent !');

                    return back();
                }

                if ($dataYTP->stage == 2) {
                    $dataYTP->stage = "3";
                    $dataYTP->status = "For Approval";
                    $dataYTP->y_t_p_reviewed_by = Auth::user()->name;
                    $dataYTP->y_t_p_reviewed_on = Carbon::now()->format('d-m-Y');
                    $dataYTP->y_t_p_reviewed_comment = $request->comment;

                    $history = new YearlyTrainingPlannerAudit();
                    $history->yearly_training_planners_id = $id;
                    $history->activity_type = 'Review By, Review On';
                    if (is_null($lastDataYTP->y_t_p_reviewed_by) || $lastDataYTP->y_t_p_reviewed_by === '') {
                        $history->previous = "NULL";
                    } else {
                        $history->previous = $lastDataYTP->y_t_p_reviewed_by . ' , ' . $lastDataYTP->y_t_p_reviewed_on;
                    }
                    $history->current = $dataYTP->y_t_p_reviewed_by . ' , ' . $dataYTP->y_t_p_reviewed_on;
                    if (is_null($lastDataYTP->y_t_p_reviewed_by) || $lastDataYTP->y_t_p_reviewed_on === '') {
                        $history->action_name = 'New';
                    } else {
                        $history->action_name = 'Update';
                    }
                    // $history->activity_type = 'Activity Log';
                    // $history->current = $dataYTP->y_t_p_reviewed_by;
                    $history->comment = $request->comment;
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to = "For Approval";
                    $history->change_from = $lastDataYTP->status;
                    $history->action = 'Review';
                    $history->stage = 'In review';
                    $history->save();

                    $dataYTP->update();

                    toastr()->success('Document Sent !');

                    return back();
                }



                if ($dataYTP->stage == 3) {
                    $dataYTP->stage = "4";
                    $dataYTP->status = "Closed – Done";
                    $dataYTP->y_t_p_approve_by = Auth::user()->name;
                    $dataYTP->y_t_p_approve_on = Carbon::now()->format('d-m-Y');
                    $dataYTP->y_t_p_approve_commnet = $request->comment;

                    $history = new YearlyTrainingPlannerAudit();
                    $history->yearly_training_planners_id = $id;
                    $history->activity_type = 'Approved By, Approved On';
                    if (is_null($lastDataYTP->y_t_p_approve_by) || $lastDataYTP->y_t_p_approve_by === '') {
                        $history->previous = "NULL";
                    } else {
                        $history->previous = $lastDataYTP->y_t_p_approve_by . ' , ' . $lastDataYTP->y_t_p_approve_on;
                    }
                    $history->current = $dataYTP->y_t_p_approve_by . ' , ' . $dataYTP->y_t_p_approve_on;
                    if (is_null($lastDataYTP->y_t_p_approve_by) || $lastDataYTP->y_t_p_approve_on === '') {
                        $history->action_name = 'New';
                    } else {
                        $history->action_name = 'Update';
                    }
                    // $history->activity_type = 'Activity Log';
                    // $history->current = $dataYTP->y_t_p_approve_by;
                    $history->comment = $request->comment;
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to = "Closed – Done";
                    $history->change_from = $lastDataYTP->status;
                    $history->action = 'Approved';
                    $history->stage = 'For Approval';
                    $history->save();

                    $dataYTP->update();

                    toastr()->success('Document Sent !');

                    return back();
                }
            } else {
                toastr()->error('E-signature Not match');
                return back();
            }
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function stageReject(Request $request, $id){


            if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {

                $dataYTP = YearlyTrainingPlanner::find($id);
                $lastDataYTP = YearlyTrainingPlanner::find($id);

            if ($dataYTP->stage == 4) {
                $dataYTP->stage = "3";
                $dataYTP->status = "For Approval";
                $dataYTP->More_info_by = Auth::user()->name;
                $dataYTP->More_info_on = Carbon::now();
                $dataYTP->More_info_comment = $request->comment;

                $history = new YearlyTrainingPlannerAudit();
                $history->yearly_training_planners_id = $id;
                $history->activity_type = 'More Info Required By, More Info Required On';
                if (is_null($lastDataYTP->More_info_by) || $lastDataYTP->More_info_by === '') {
                    $history->previous = "NULL";
                } else {
                    $history->previous = $lastDataYTP->More_info_by . ' , ' . $lastDataYTP->More_info_on;
                }
                $history->current = $dataYTP->More_info_by . ' , ' . $dataYTP->More_info_on;
                if (is_null($lastDataYTP->More_info_by) || $lastDataYTP->More_info_on === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->action = 'More Info Required';
                $history->comment = $request->comments;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDataYTP->status;
                $history->change_to = "For Approval";
                $history->change_from = $lastDataYTP->status;
                $history->stage = '';
                $history->save();

                // $list = Helpers::getInitiatorUserList($dataYTP->division_id);
                //     foreach ($list as $u) {
                //         // if($u->q_m_s_divisions_id == $dataYTP->division_id){
                //             $email = Helpers::getUserEmail($u->user_id);
                //                 if ($email !== null) {
                //                 try {
                //                     Mail::send(
                //                         'mail.view-mail',
                //                         ['data' => $dataYTP, 'site'=>"Errata", 'history' => "Reject", 'process' => 'Errata', 'comment' => $request->comment, 'user'=> Auth::user()->name],
                //                         function ($message) use ($email, $dataYTP) {
                //                             $message->to($email)
                //                             ->subject("Agio Notification: Errata, Record #" . str_pad($dataYTP->record, 4, '0', STR_PAD_LEFT) . " - Activity: Reject Performed");
                //                         }
                //                     );
                //                 } catch(\Exception $e) {
                //                     info('Error sending mail', [$e]);
                //                 }
                //             }
                //         // }
                //     }

                $dataYTP->update();
                return back();
            }

            if ($dataYTP->stage == 3) {
                $dataYTP->stage = "2";
                $dataYTP->status = "In Review";
                $dataYTP->More_info_require_by = Auth::user()->name;
                $dataYTP->More_info_require_on = Carbon::now();
                $dataYTP->More_info_require_comment = $request->comment;

                $history = new YearlyTrainingPlannerAudit();
                $history->yearly_training_planners_id = $id;
                $history->activity_type = 'More Info Required By, More Info Required On';
                if (is_null($lastDataYTP->More_info_require_by) || $lastDataYTP->More_info_require_by === '') {
                    $history->previous = "NULL";
                } else {
                    $history->previous = $lastDataYTP->More_info_require_by . ' , ' . $lastDataYTP->More_info_require_on;
                }
                $history->current = $dataYTP->More_info_require_by . ' , ' . $dataYTP->More_info_require_on;
                if (is_null($lastDataYTP->More_info_require_by) || $lastDataYTP->More_info_require_on === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->action = 'More Info Required';
                $history->comment = $request->comments;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDataYTP->status;
                $history->change_to = "In Review";
                $history->change_from = $lastDataYTP->status;
                $history->stage = '';
                $history->save();

                // $list = Helpers::getInitiatorUserList($dataYTP->division_id);
                //     foreach ($list as $u) {
                //         // if($u->q_m_s_divisions_id == $dataYTP->division_id){
                //             $email = Helpers::getUserEmail($u->user_id);
                //                 if ($email !== null) {
                //                 try {
                //                     Mail::send(
                //                         'mail.view-mail',
                //                         ['data' => $dataYTP, 'site'=>"Errata", 'history' => "Reject", 'process' => 'Errata', 'comment' => $request->comment, 'user'=> Auth::user()->name],
                //                         function ($message) use ($email, $dataYTP) {
                //                             $message->to($email)
                //                             ->subject("Agio Notification: Errata, Record #" . str_pad($dataYTP->record, 4, '0', STR_PAD_LEFT) . " - Activity: Reject Performed");
                //                         }
                //                     );
                //                 } catch(\Exception $e) {
                //                     info('Error sending mail', [$e]);
                //                 }
                //             }
                //         // }
                //     }

                $dataYTP->update();
                return back();
            }

            if ($dataYTP->stage == 2) {
                $dataYTP->stage = "1";
                $dataYTP->status = "Opened";
                $dataYTP->Review_info_require_by = Auth::user()->name;
                $dataYTP->Review_info_require_on = Carbon::now();
                $dataYTP->Review_info_require_comment = $request->comment;

                $history = new YearlyTrainingPlannerAudit();
                $history->yearly_training_planners_id = $id;
                $history->activity_type = 'More Info Required By, More Info Required On';
                if (is_null($lastDataYTP->Review_info_require_by) || $lastDataYTP->Review_info_require_by === '') {
                    $history->previous = "NULL";
                } else {
                    $history->previous = $lastDataYTP->Review_info_require_by . ' , ' . $lastDataYTP->Review_info_require_on;
                }
                $history->current = $dataYTP->Review_info_require_by . ' , ' . $dataYTP->Review_info_require_on;
                if (is_null($lastDataYTP->Review_info_require_by) || $lastDataYTP->Review_info_require_on === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->action = 'More Info Required';
                $history->comment = $request->comments;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDataYTP->status;
                $history->change_to = "Opened";
                $history->change_from = $lastDataYTP->status;
                $history->stage = '';
                $history->save();

                // $list = Helpers::getInitiatorUserList($dataYTP->division_id);
                //     foreach ($list as $u) {
                //         // if($u->q_m_s_divisions_id == $dataYTP->division_id){
                //             $email = Helpers::getUserEmail($u->user_id);
                //                 if ($email !== null) {
                //                 try {
                //                     Mail::send(
                //                         'mail.view-mail',
                //                         ['data' => $dataYTP, 'site'=>"Errata", 'history' => "Reject", 'process' => 'Errata', 'comment' => $request->comment, 'user'=> Auth::user()->name],
                //                         function ($message) use ($email, $dataYTP) {
                //                             $message->to($email)
                //                             ->subject("Agio Notification: Errata, Record #" . str_pad($dataYTP->record, 4, '0', STR_PAD_LEFT) . " - Activity: Reject Performed");
                //                         }
                //                     );
                //                 } catch(\Exception $e) {
                //                     info('Error sending mail', [$e]);
                //                 }
                //             }
                //         // }
                //     }

                $dataYTP->update();
                return back();
            }

        } else {
            toastr()->error('E-signature Not match');
            return back();
        }
    }
    public function stageCancel(Request $request, $id){


        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {

            $dataYTP = YearlyTrainingPlanner::find($id);
            $lastDataYTP = YearlyTrainingPlanner::find($id);

            if ($dataYTP->stage == 1) {
                $dataYTP->stage = "0";
                $dataYTP->status = "Closed - Cancelled";
                $dataYTP->Cancel_by = Auth::user()->name;
                $dataYTP->Cancel_on = Carbon::now();
                $dataYTP->Cancel_comment = $request->comment;

                $history = new YearlyTrainingPlannerAudit();
                $history->yearly_training_planners_id = $id;
                $history->activity_type = 'Cancel By, Cancel On';
                if (is_null($lastDataYTP->Cancel_by) || $lastDataYTP->Cancel_by === '') {
                    $history->previous = "NULL";
                } else {
                    $history->previous = $lastDataYTP->Cancel_by . ' , ' . $lastDataYTP->Cancel_on;
                }
                $history->current = $dataYTP->Cancel_by . ' , ' . $dataYTP->Cancel_on;
                if (is_null($lastDataYTP->Cancel_by) || $lastDataYTP->Cancel_on === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->action = 'Cancel';
                $history->comment = $request->comments;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDataYTP->status;
                $history->change_to = "Closed - Cancelled";
                $history->change_from = $lastDataYTP->status;
                $history->stage = '';
                $history->save();

                // $list = Helpers::getInitiatorUserList($dataYTP->division_id);
                //     foreach ($list as $u) {
                //         // if($u->q_m_s_divisions_id == $dataYTP->division_id){
                //             $email = Helpers::getUserEmail($u->user_id);
                //                 if ($email !== null) {
                //                 try {
                //                     Mail::send(
                //                         'mail.view-mail',
                //                         ['data' => $dataYTP, 'site'=>"Errata", 'history' => "Reject", 'process' => 'Errata', 'comment' => $request->comment, 'user'=> Auth::user()->name],
                //                         function ($message) use ($email, $dataYTP) {
                //                             $message->to($email)
                //                             ->subject("Agio Notification: Errata, Record #" . str_pad($dataYTP->record, 4, '0', STR_PAD_LEFT) . " - Activity: Reject Performed");
                //                         }
                //                     );
                //                 } catch(\Exception $e) {
                //                     info('Error sending mail', [$e]);
                //                 }
                //             }
                //         // }
                //     }

                $dataYTP->update();
                return back();
            }
        } else {
            toastr()->error('E-signature Not match');
            return back();
        }
    }
}
