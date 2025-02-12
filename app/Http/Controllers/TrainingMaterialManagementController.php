<?php

namespace App\Http\Controllers;

use App\Models\TrainingMaterialManagement;
use Illuminate\Http\Request;

use App\Models\TrainingMaterialManagementAudit;
use App\Models\EmployeeGrid;
use App\Models\RecordNumber;
use App\Models\RoleGroup;
use App\Models\Document;
use App\Models\Training;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use PDF;
use Helpers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class TrainingMaterialManagementController extends Controller
{


    public function trainingmaterialmanagement()
    {
        $trainingTMM = TrainingMaterialManagement::get();

        $ref_doc = Document::all();
        $record_number = ((RecordNumber::first()->value('counter')) + 1);
        $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);

        return view("frontend.TMS.TMM.training_material_management", compact('trainingTMM','record_number','ref_doc'));
    }

    public function store(Request $request)
    {


        $trainingTMM = new TrainingMaterialManagement();

        $trainingTMM->traning_material_id = ((RecordNumber::first()->value('counter')) + 1);

        $trainingTMM->form_type = "training-material-management";
        $trainingTMM->stage = '1';
        $trainingTMM->status = 'Opened';
        $trainingTMM->division_id = $request->division_id;
        $trainingTMM->initiator_id = Auth::user()->id;
        $trainingTMM->TMM_id = $request->TMM_id;
        $trainingTMM->site_division = $request->site_division;
        $trainingTMM->Prepared_by = Auth::user()->id;
        $trainingTMM->Prepared_date = $request->Prepared_date;
        // $trainingTMM->traning_material_id = $request->traning_material_id;
        $trainingTMM->title = $request->title;
        $trainingTMM->short_description = $request->short_description;
        $trainingTMM->description = $request->description;
        $trainingTMM->Type_of_Material = $request->Type_of_Material;
        $trainingTMM->Instructor = $request->Instructor;
        $trainingTMM->version_num = $request->version_num;
        $trainingTMM->Creation_date = $request->Creation_date;
        $trainingTMM->last_updated_date = $request->last_updated_date;
        $trainingTMM->Keywords = $request->Keywords;
        $trainingTMM->Training_Category = $request->Training_Category;
        $trainingTMM->training_duration = $request->training_duration;
        $trainingTMM->regulatory_requirement = $request->regulatory_requirement;
        $trainingTMM->revision_history = $request->revision_history;
        $trainingTMM->review_frequency = $request->review_frequency;
        $trainingTMM->approver = $request->approver;
        $trainingTMM->external_links = $request->external_links;
        $trainingTMM->Department = implode(',', $request->Department);
        $trainingTMM->Reference_Document = $request->Reference_Document;

        if (!empty($request->Supporting_Documents)) {
            $files = [];
            if ($request->hasFile('Supporting_Documents')) {
                foreach ($request->file('Supporting_Documents') as $file) {
                    $name = $request->name . 'Supporting_Documents' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('upload/'), $name);
                    $files[] = $name;
                }
            }
            $trainingTMM->Supporting_Documents = json_encode($files);
        }

        if (!empty($request->Attachments)) {
            $files = [];
            if ($request->hasFile('Attachments')) {
                foreach ($request->file('Attachments') as $file) {
                    $name = $request->name . 'Attachments' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('upload/'), $name);
                    $files[] = $name;
                }
            }
            $trainingTMM->Attachments = json_encode($files);
        }


        $trainingTMM->save();

        $traning_material_id = RecordNumber::first();
        $traning_material_id->counter = ((RecordNumber::first()->value('counter')) + 1);
        $traning_material_id->update();


        // if (!empty($request->site_division)) {
        //     $validation2 = new TrainingMaterialManagementAudit();
        //     $validation2->TMM_id = $trainingTMM->id;
        //     $validation2->activity_type = 'Site/Location';
        //     $validation2->previous = "Null";
        //     $validation2->current = $request->site_division;
        //     $validation2->comment = "NA";
        //     $validation2->user_id = Auth::user()->id;
        //     $validation2->user_name = Auth::user()->name;
        //     $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        //     $validation2->change_to =   "Opened";
        //     $validation2->change_from = "Initiation";
        //     $validation2->action_name = 'Create';

        //     $validation2->save();
        // }

        if (!empty($trainingTMM->site_division)) {
            $history = new TrainingMaterialManagementAudit();
            $history->TMM_id = $trainingTMM->id;
            $history->activity_type = 'Site/Location';
            $history->previous = "Null";
            $history->current = $trainingTMM->site_division;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $trainingTMM->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->save();
        }
        if (!empty($trainingTMM->traning_material_id)) {
            $history = new TrainingMaterialManagementAudit();
            $history->TMM_id = $trainingTMM->id;
            $history->activity_type = 'Training Module ID';
            $history->previous = "Null";
            $history->current = $trainingTMM->traning_material_id;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $trainingTMM->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->save();
        }
        if (!empty($trainingTMM->short_description)) {
            $history = new TrainingMaterialManagementAudit();
            $history->TMM_id = $trainingTMM->id;
            $history->activity_type = 'Short Description';
            $history->previous = "Null";
            $history->current = $trainingTMM->short_description;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $trainingTMM->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->save();
        }
        if (!empty($trainingTMM->title)) {
            $history = new TrainingMaterialManagementAudit();
            $history->TMM_id = $trainingTMM->id;
            $history->activity_type = 'Title';
            $history->previous = "Null";
            $history->current = $trainingTMM->title;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $trainingTMM->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->save();
        }
        if (!empty($trainingTMM->description)) {
            $history = new TrainingMaterialManagementAudit();
            $history->TMM_id = $trainingTMM->id;
            $history->activity_type = 'Description';
            $history->previous = "Null";
            $history->current = $trainingTMM->description;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $trainingTMM->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->save();
        }
        if (!empty($trainingTMM->Type_of_Material)) {
            $history = new TrainingMaterialManagementAudit();
            $history->TMM_id = $trainingTMM->id;
            $history->activity_type = 'Type of Module';
            $history->previous = "Null";
            $history->current = $trainingTMM->Type_of_Material;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $trainingTMM->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->save();
        }
        if (!empty($trainingTMM->Instructor)) {
            $history = new TrainingMaterialManagementAudit();
            $history->TMM_id = $trainingTMM->id;
            $history->activity_type = 'Author/Instructor';
            $history->previous = "Null";
            $history->current = Helpers::getInitiatorName($trainingTMM->Instructor);
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $trainingTMM->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->save();
        }
        if (!empty($trainingTMM->version_num)) {
            $history = new TrainingMaterialManagementAudit();
            $history->TMM_id = $trainingTMM->id;
            $history->activity_type = 'Version Number';
            $history->previous = "Null";
            $history->current = $trainingTMM->version_num;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $trainingTMM->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->save();
        }
        if (!empty($trainingTMM->last_updated_date)) {
            $history = new TrainingMaterialManagementAudit();
            $history->TMM_id = $trainingTMM->id;
            $history->activity_type = 'Last Updated Date';
            $history->previous = "Null";
            $history->current = Helpers::getdateFormat($trainingTMM->last_updated_date);
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $trainingTMM->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->save();
        }
        if (!empty($trainingTMM->Attachments)) {
            $history = new TrainingMaterialManagementAudit();
            $history->TMM_id = $trainingTMM->id;
            $history->activity_type = 'Attachments';
            $history->previous = "Null";
            $history->current = $trainingTMM->Attachments;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $trainingTMM->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->save();
        }
        if (!empty($trainingTMM->Training_Category)) {
            $history = new TrainingMaterialManagementAudit();
            $history->TMM_id = $trainingTMM->id;
            $history->activity_type = 'Training Category';
            $history->previous = "Null";
            $history->current = $trainingTMM->Training_Category;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $trainingTMM->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->save();
        }
        if (!empty($trainingTMM->Keywords)) {
            $history = new TrainingMaterialManagementAudit();
            $history->TMM_id = $trainingTMM->id;
            $history->activity_type = 'Tags/Keywords';
            $history->previous = "Null";
            $history->current = $trainingTMM->Keywords;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $trainingTMM->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->save();
        }
        if (!empty($trainingTMM->Department)) {
            $history = new TrainingMaterialManagementAudit();
            $history->TMM_id = $trainingTMM->id;
            $history->activity_type = 'Department';
            $history->previous = "Null";
            $history->current = $trainingTMM->Department;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $trainingTMM->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->save();
        }
        if (!empty($trainingTMM->training_duration)) {
            $history = new TrainingMaterialManagementAudit();
            $history->TMM_id = $trainingTMM->id;
            $history->activity_type = 'Training Duration (In Minutes)';
            $history->previous = "Null";
            $history->current = $trainingTMM->training_duration;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $trainingTMM->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->save();
        }
        if (!empty($trainingTMM->regulatory_requirement)) {
            $history = new TrainingMaterialManagementAudit();
            $history->TMM_id = $trainingTMM->id;
            $history->activity_type = 'Regulatory Requirement';
            $history->previous = "Null";
            $history->current = $trainingTMM->regulatory_requirement;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $trainingTMM->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->save();
        }
        if (!empty($trainingTMM->revision_history)) {
            $history = new TrainingMaterialManagementAudit();
            $history->TMM_id = $trainingTMM->id;
            $history->activity_type = 'Revision History';
            $history->previous = "Null";
            $history->current = $trainingTMM->revision_history;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $trainingTMM->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->save();
        }
        if (!empty($trainingTMM->review_frequency)) {
            $history = new TrainingMaterialManagementAudit();
            $history->TMM_id = $trainingTMM->id;
            $history->activity_type = 'Review Frequency';
            $history->previous = "Null";
            $history->current = $trainingTMM->review_frequency;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $trainingTMM->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->save();
        }
        if (!empty($trainingTMM->approver)) {
            $history = new TrainingMaterialManagementAudit();
            $history->TMM_id = $trainingTMM->id;
            $history->activity_type = 'Reviewer/Approver';
            $history->previous = "Null";
            $history->current = Helpers::getInitiatorName($trainingTMM->approver);
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $trainingTMM->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->save();
        }
        if (!empty($trainingTMM->Supporting_Documents)) {
            $history = new TrainingMaterialManagementAudit();
            $history->TMM_id = $trainingTMM->id;
            $history->activity_type = 'Supporting Documents';
            $history->previous = "Null";
            $history->current = $trainingTMM->Supporting_Documents;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $trainingTMM->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->save();
        }
        if (!empty($trainingTMM->external_links)) {
            $history = new TrainingMaterialManagementAudit();
            $history->TMM_id = $trainingTMM->id;
            $history->activity_type = 'External Links';
            $history->previous = "Null";
            $history->current = $trainingTMM->external_links;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $trainingTMM->status;
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

        $trainingTMM = TrainingMaterialManagement::find($id);
        $lastDocument = TrainingMaterialManagement::find($id);

        $trainingTMM->TMM_id = $request->TMM_id;
        $trainingTMM->site_division = $request->site_division;
        // $trainingTMM->status = 'Opened';
        // $trainingTMM->division_id = $request->division_id;
        $trainingTMM->initiator_id = Auth::user()->id;
        // $trainingTMM->traning_material_id = $request->traning_material_id;
        $trainingTMM->title = $request->title;
        $trainingTMM->short_description = $request->short_description;
        // $trainingTMM->Prepared_by = $request->Prepared_by;
        // $trainingTMM->Prepared_date = $request->Prepared_date;
        $trainingTMM->description = $request->description;
        $trainingTMM->Type_of_Material = $request->Type_of_Material;
        $trainingTMM->Instructor = $request->Instructor;
        $trainingTMM->version_num = $request->version_num;
        $trainingTMM->Creation_date = $request->Creation_date;
        $trainingTMM->last_updated_date = $request->last_updated_date;
        $trainingTMM->Keywords = $request->Keywords;
        $trainingTMM->Training_Category = $request->Training_Category;
        $trainingTMM->training_duration = $request->training_duration;
        $trainingTMM->regulatory_requirement = $request->regulatory_requirement;
        $trainingTMM->revision_history = $request->revision_history;
        $trainingTMM->review_frequency = $request->review_frequency;
        $trainingTMM->approver = $request->approver;
        $trainingTMM->external_links = $request->external_links;
        $trainingTMM->Department = implode(',', $request->Department);
        $trainingTMM->Reference_Document = $request->Reference_Document;



        if (!empty($request->Supporting_Documents) || !empty($request->deleted_Supporting_Documents)) {
            $existingFiles = json_decode($trainingTMM->Supporting_Documents, true) ?? [];

            // Handle deleted files
            if (!empty($request->deleted_Supporting_Documents)) {
                $filesToDelete = explode(',', $request->deleted_Supporting_Documents);
                $existingFiles = array_filter($existingFiles, function($file) use ($filesToDelete) {
                    return !in_array($file, $filesToDelete);
                });
            }

            // Handle new files
            $newFiles = [];
            if ($request->hasFile('Supporting_Documents')) {
                foreach ($request->file('Supporting_Documents') as $file) {
                    $name = $request->name . 'Supporting_Documents' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('upload/'), $name);
                    $newFiles[] = $name;
                }
            }

            // Merge existing and new files
            $allFiles = array_merge($existingFiles, $newFiles);
            $trainingTMM->Supporting_Documents = json_encode($allFiles);
        }

        if (!empty($request->Attachments) || !empty($request->deleted_Attachments)) {
            $existingFiles = json_decode($trainingTMM->Attachments, true) ?? [];

            // Handle deleted files
            if (!empty($request->deleted_Attachments)) {
                $filesToDelete = explode(',', $request->deleted_Attachments);
                $existingFiles = array_filter($existingFiles, function($file) use ($filesToDelete) {
                    return !in_array($file, $filesToDelete);
                });
            }

            // Handle new files
            $newFiles = [];
            if ($request->hasFile('Attachments')) {
                foreach ($request->file('Attachments') as $file) {
                    $name = $request->name . 'Attachments' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('upload/'), $name);
                    $newFiles[] = $name;
                }
            }

            // Merge existing and new files
            $allFiles = array_merge($existingFiles, $newFiles);
            $trainingTMM->Attachments = json_encode($allFiles);
        }


        $trainingTMM->update();


        if ($lastDocument->site_division != $trainingTMM->site_division || !empty($request->site_division_comment)) {
            $lastDocumentAuditTrail = TrainingMaterialManagementAudit::where('TMM_id', $trainingTMM->id)
                ->where('activity_type', 'Site/Location')
                ->exists();
            $history = new TrainingMaterialManagementAudit();
            $history->TMM_id = $trainingTMM->id;
            $history->activity_type = 'Site/Location';
            $history->previous =  $lastDocument->site_division;
            $history->current = $trainingTMM->site_division;
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
        if ($lastDocument->traning_material_id != $trainingTMM->traning_material_id || !empty($request->traning_material_id_comment)) {
            $lastDocumentAuditTrail = TrainingMaterialManagementAudit::where('TMM_id', $trainingTMM->id)
                ->where('activity_type', 'Training Module ID')
                ->exists();
            $history = new TrainingMaterialManagementAudit();
            $history->TMM_id = $trainingTMM->id;
            $history->activity_type = 'Training Module ID';
            $history->previous =  $lastDocument->traning_material_id;
            $history->current = $trainingTMM->traning_material_id;
            $history->comment = $request->traning_material_id_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? "Update" : "New";
            $history->save();
        }

        if ($lastDocument->short_description != $trainingTMM->short_description || !empty($request->short_description_comment)) {
            $lastDocumentAuditTrail = TrainingMaterialManagementAudit::where('TMM_id', $trainingTMM->id)
                ->where('activity_type', 'Short Description')
                ->exists();
            $history = new TrainingMaterialManagementAudit();
            $history->TMM_id = $trainingTMM->id;
            $history->activity_type = 'Short Description';
            $history->previous =  $lastDocument->short_description;
            $history->current = $trainingTMM->short_description;
            $history->comment = $request->short_description_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? "Update" : "New";
            $history->save();
        }
        if ($lastDocument->title != $trainingTMM->title || !empty($request->title_comment)) {
            $lastDocumentAuditTrail = TrainingMaterialManagementAudit::where('TMM_id', $trainingTMM->id)
                ->where('activity_type', 'Title')
                ->exists();
            $history = new TrainingMaterialManagementAudit();
            $history->TMM_id = $trainingTMM->id;
            $history->activity_type = 'Title';
            $history->previous =  $lastDocument->title;
            $history->current = $trainingTMM->title;
            $history->comment = $request->title_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? "Update" : "New";
            $history->save();
        }
        if ($lastDocument->description != $trainingTMM->description || !empty($request->description_comment)) {
            $lastDocumentAuditTrail = TrainingMaterialManagementAudit::where('TMM_id', $trainingTMM->id)
                ->where('activity_type', 'Description')
                ->exists();
            $history = new TrainingMaterialManagementAudit();
            $history->TMM_id = $trainingTMM->id;
            $history->activity_type = 'Description';
            $history->previous =  $lastDocument->description;
            $history->current = $trainingTMM->description;
            $history->comment = $request->description_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? "Update" : "New";
            $history->save();
        }
        if ($lastDocument->Type_of_Material != $trainingTMM->Type_of_Material || !empty($request->Type_of_Material_comment)) {
            $lastDocumentAuditTrail = TrainingMaterialManagementAudit::where('TMM_id', $trainingTMM->id)
                ->where('activity_type', 'Type of Module')
                ->exists();
            $history = new TrainingMaterialManagementAudit();
            $history->TMM_id = $trainingTMM->id;
            $history->activity_type = 'Type of Module';
            $history->previous =  $lastDocument->Type_of_Material;
            $history->current = $trainingTMM->Type_of_Material;
            $history->comment = $request->Type_of_Material_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? "Update" : "New";
            $history->save();
        }
        if ($lastDocument->Instructor != $trainingTMM->Instructor || !empty($request->Instructor_comment)) {
            $lastDocumentAuditTrail = TrainingMaterialManagementAudit::where('TMM_id', $trainingTMM->id)
                ->where('activity_type', 'Author/Instructor')
                ->exists();
            $history = new TrainingMaterialManagementAudit();
            $history->TMM_id = $trainingTMM->id;
            $history->activity_type = 'Author/Instructor';
            $history->previous =  Helpers::getInitiatorName($lastDocument->Instructor);
            $history->current = Helpers::getInitiatorName($trainingTMM->Instructor);
            $history->comment = $request->Instructor_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? "Update" : "New";
            $history->save();
        }
        if ($lastDocument->version_num != $trainingTMM->version_num || !empty($request->version_num_comment)) {
            $lastDocumentAuditTrail = TrainingMaterialManagementAudit::where('TMM_id', $trainingTMM->id)
                ->where('activity_type', 'Version Number')
                ->exists();
            $history = new TrainingMaterialManagementAudit();
            $history->TMM_id = $trainingTMM->id;
            $history->activity_type = 'Version Number';
            $history->previous =  $lastDocument->version_num;
            $history->current = $trainingTMM->version_num;
            $history->comment = $request->version_num_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? "Update" : "New";
            $history->save();
        }
        if ($lastDocument->last_updated_date != $trainingTMM->last_updated_date || !empty($request->last_updated_date_comment)) {
            $lastDocumentAuditTrail = TrainingMaterialManagementAudit::where('TMM_id', $trainingTMM->id)
                ->where('activity_type', 'Last Updated Date')
                ->exists();
            $history = new TrainingMaterialManagementAudit();
            $history->TMM_id = $trainingTMM->id;
            $history->activity_type = 'Last Updated Date';
            $history->previous =  Helpers::getdateFormat($lastDocument->last_updated_date);
            $history->current = Helpers::getdateFormat($trainingTMM->last_updated_date);
            $history->comment = $request->last_updated_date_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? "Update" : "New";
            $history->save();
        }

        if ($lastDocument->Attachments != $trainingTMM->Attachments || !empty($request->Attachments_comment)) {
            $lastDocumentAuditTrail = TrainingMaterialManagementAudit::where('TMM_id', $trainingTMM->id)
                ->where('activity_type', 'Attachments')
                ->exists();
            $history = new TrainingMaterialManagementAudit();
            $history->TMM_id = $trainingTMM->id;
            $history->activity_type = 'Attachments';
            $history->previous =  str_replace(',', ', ', $lastDocument->Attachments);
            $history->current = str_replace(',', ', ', $trainingTMM->Attachments);
            $history->comment = $request->Attachments_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? "Update" : "New";
            $history->save();
        }
        if ($lastDocument->Training_Category != $trainingTMM->Training_Category || !empty($request->Training_Category_comment)) {
            $lastDocumentAuditTrail = TrainingMaterialManagementAudit::where('TMM_id', $trainingTMM->id)
                ->where('activity_type', 'Training Category')
                ->exists();
            $history = new TrainingMaterialManagementAudit();
            $history->TMM_id = $trainingTMM->id;
            $history->activity_type = 'Training Category';
            $history->previous =  $lastDocument->Training_Category;
            $history->current = $trainingTMM->Training_Category;
            $history->comment = $request->Training_Category_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? "Update" : "New";
            $history->save();
        }
        if ($lastDocument->Keywords != $trainingTMM->Keywords || !empty($request->Keywords_comment)) {
            $lastDocumentAuditTrail = TrainingMaterialManagementAudit::where('TMM_id', $trainingTMM->id)
                ->where('activity_type', 'Tags/Keywords')
                ->exists();
            $history = new TrainingMaterialManagementAudit();
            $history->TMM_id = $trainingTMM->id;
            $history->activity_type = 'Tags/Keywords';
            $history->previous =  $lastDocument->Keywords;
            $history->current = $trainingTMM->Keywords;
            $history->comment = $request->Keywords_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? "Update" : "New";
            $history->save();
        }
        if ($lastDocument->Department != $trainingTMM->Department || !empty($request->Department_comment)) {
            $lastDocumentAuditTrail = TrainingMaterialManagementAudit::where('TMM_id', $trainingTMM->id)
                ->where('activity_type', 'Department')
                ->exists();
            $history = new TrainingMaterialManagementAudit();
            $history->TMM_id = $trainingTMM->id;
            $history->activity_type = 'Department';
            $history->previous =  str_replace(',', ', ', $lastDocument->Department);
            $history->current = str_replace(',', ', ', $trainingTMM->Department);
            $history->comment = $request->Department_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? "Update" : "New";
            $history->save();
        }
        if ($lastDocument->training_duration != $trainingTMM->training_duration || !empty($request->training_duration_comment)) {
            $lastDocumentAuditTrail = TrainingMaterialManagementAudit::where('TMM_id', $trainingTMM->id)
                ->where('activity_type', 'Training Duration (In Minutes)')
                ->exists();
            $history = new TrainingMaterialManagementAudit();
            $history->TMM_id = $trainingTMM->id;
            $history->activity_type = 'Training Duration (In Minutes)';
            $history->previous =  $lastDocument->training_duration;
            $history->current = $trainingTMM->training_duration;
            $history->comment = $request->training_duration_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? "Update" : "New";
            $history->save();
        }
        if ($lastDocument->regulatory_requirement != $trainingTMM->regulatory_requirement || !empty($request->regulatory_requirement_comment)) {
            $lastDocumentAuditTrail = TrainingMaterialManagementAudit::where('TMM_id', $trainingTMM->id)
                ->where('activity_type', 'Regulatory Requirement')
                ->exists();
            $history = new TrainingMaterialManagementAudit();
            $history->TMM_id = $trainingTMM->id;
            $history->activity_type = 'Regulatory Requirement';
            $history->previous =  $lastDocument->regulatory_requirement;
            $history->current = $trainingTMM->regulatory_requirement;
            $history->comment = $request->regulatory_requirement_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? "Update" : "New";
            $history->save();
        }
        if ($lastDocument->revision_history != $trainingTMM->revision_history || !empty($request->revision_history_comment)) {
            $lastDocumentAuditTrail = TrainingMaterialManagementAudit::where('TMM_id', $trainingTMM->id)
                ->where('activity_type', 'Revision History')
                ->exists();
            $history = new TrainingMaterialManagementAudit();
            $history->TMM_id = $trainingTMM->id;
            $history->activity_type = 'Revision History';
            $history->previous =  $lastDocument->revision_history;
            $history->current = $trainingTMM->revision_history;
            $history->comment = $request->revision_history_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? "Update" : "New";
            $history->save();
        }
        if ($lastDocument->review_frequency != $trainingTMM->review_frequency || !empty($request->review_frequency_comment)) {
            $lastDocumentAuditTrail = TrainingMaterialManagementAudit::where('TMM_id', $trainingTMM->id)
                ->where('activity_type', 'Review Frequency')
                ->exists();
            $history = new TrainingMaterialManagementAudit();
            $history->TMM_id = $trainingTMM->id;
            $history->activity_type = 'Review Frequency';
            $history->previous =  $lastDocument->review_frequency;
            $history->current = $trainingTMM->review_frequency;
            $history->comment = $request->review_frequency_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? "Update" : "New";
            $history->save();
        }
        if ($lastDocument->approver != $trainingTMM->approver || !empty($request->approver_comment)) {
            $lastDocumentAuditTrail = TrainingMaterialManagementAudit::where('TMM_id', $trainingTMM->id)
                ->where('activity_type', 'Reviewer/Approver')
                ->exists();
            $history = new TrainingMaterialManagementAudit();
            $history->TMM_id = $trainingTMM->id;
            $history->activity_type = 'Reviewer/Approver';
            $history->previous =  Helpers::getInitiatorName($lastDocument->approver);
            $history->current = Helpers::getInitiatorName($trainingTMM->approver);
            $history->comment = $request->approver_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? "Update" : "New";
            $history->save();
        }
        if ($lastDocument->Supporting_Documents != $trainingTMM->Supporting_Documents || !empty($request->Supporting_Documents_comment)) {
            $lastDocumentAuditTrail = TrainingMaterialManagementAudit::where('TMM_id', $trainingTMM->id)
                ->where('activity_type', 'Supporting Documents')
                ->exists();
            $history = new TrainingMaterialManagementAudit();
            $history->TMM_id = $trainingTMM->id;
            $history->activity_type = 'Supporting Documents';
            $history->previous =  str_replace(',', ', ', $lastDocument->Supporting_Documents);
            $history->current = str_replace(',', ', ', $trainingTMM->Supporting_Documents);
            $history->comment = $request->Supporting_Documents_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? "Update" : "New";
            $history->save();
        }
        if ($lastDocument->external_links != $trainingTMM->external_links || !empty($request->external_links_comment)) {
            $lastDocumentAuditTrail = TrainingMaterialManagementAudit::where('TMM_id', $trainingTMM->id)
                ->where('activity_type', 'External Links')
                ->exists();
            $history = new TrainingMaterialManagementAudit();
            $history->TMM_id = $trainingTMM->id;
            $history->activity_type = 'External Links';
            $history->previous =  $lastDocument->external_links;
            $history->current = $trainingTMM->external_links;
            $history->comment = $request->external_links_comment;
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


    public function show($id)
    {

        $trainingTMM = TrainingMaterialManagement::find($id);
        
        $record_number = ((RecordNumber::first()->value('counter')) + 1);
        $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
        $savedDepartmentId = explode(',', $trainingTMM->Department);
        $ref_doc = Document::all();
        return view('frontend.TMS.TMM.view_training_material_management', compact('trainingTMM', 'savedDepartmentId','record_number','ref_doc'));
    }

    public function audittrail($id)
    {
        $audit = TrainingMaterialManagementAudit::where('TMM_id', $id)->orderByDESC('id')->paginate();
        $trainingTMM = TrainingMaterialManagement::find($id);
        $today = Carbon::now()->format('d-m-y');
        $document = TrainingMaterialManagement::where('id', $id)->first();
        $document->initiator = User::where('id', $document->initiator_id)->value('name');

        return view('frontend.TMS.TMM.audit-trial-inner', compact('audit','trainingTMM','document','today'));
    }

    public function sendStage(Request $request, $id)
    {
        try {

            if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {

                $trainingTMM = TrainingMaterialManagement::find($id);
                $lastTrainingTMM = TrainingMaterialManagement::find($id);

                if ($trainingTMM->stage == 1) {
                    $trainingTMM->stage = "2";
                    $trainingTMM->status = "Pending Training Module Creation";
                    $trainingTMM->Create_Training_Material_by = Auth::user()->name;
                    $trainingTMM->Create_Training_Material_on = Carbon::now()->format('d-m-Y');
                    $trainingTMM->Create_Training_Material_comment = $request->comment;

                    $history = new TrainingMaterialManagementAudit();
                    $history->TMM_id = $id;
                    $history->activity_type = 'Activity Log';
                    $history->current = $trainingTMM->Create_Training_Material_by;
                    $history->comment = $request->comment;
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to = "Pending Training Module Creation";
                    $history->change_from = $lastTrainingTMM->status;
                    $history->action = 'Create Training Module';
                    $history->stage = 'Opened';
                    $trainingTMM->update();

                    toastr()->success('Document Sent !');

                    return back();
                }

                if ($trainingTMM->stage == 2) {
                    $trainingTMM->stage = "3";
                    $trainingTMM->status = "Pending HOD Review";
                    $trainingTMM->Training_Material_Created_by = Auth::user()->name;
                    $trainingTMM->Training_Material_Created_on = Carbon::now()->format('d-m-Y');
                    $trainingTMM->Training_Material_Created_comment = $request->comment;

                    $history = new TrainingMaterialManagementAudit();
                    $history->TMM_id = $id;
                    $history->activity_type = 'Activity Log';
                    $history->current = $trainingTMM->Training_Material_Created_by;
                    $history->comment = $request->comment;
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to = "Pending HOD Review";
                    $history->change_from = $lastTrainingTMM->status;
                    $history->action = 'Training Module Created';
                    $history->stage = 'Pending Training Module Creation';
                    $trainingTMM->update();

                    toastr()->success('Document Sent !');

                    return back();
                }

                if ($trainingTMM->stage == 3) {
                    $trainingTMM->stage = "4";
                    $trainingTMM->status = "Pending QA Review";
                    $trainingTMM->HOD_Review_Complete_by = Auth::user()->name;
                    $trainingTMM->HOD_Review_Complete_on = Carbon::now()->format('d-m-Y');
                    $trainingTMM->HOD_Review_Complete_comment = $request->comment;

                    $history = new TrainingMaterialManagementAudit();
                    $history->TMM_id = $id;
                    $history->activity_type = 'Activity Log';
                    $history->current = $trainingTMM->HOD_Review_Complete_by;
                    $history->comment = $request->comment;
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to = "Pending QA Review";
                    $history->change_from = $lastTrainingTMM->status;
                    $history->action = 'HOD Review Complete';
                    $history->stage = 'Pending HOD Review';
                    $trainingTMM->update();

                    toastr()->success('Document Sent !');

                    return back();
                }

                if ($trainingTMM->stage == 4) {
                    $trainingTMM->stage = "5";
                    $trainingTMM->status = "Closed – Done";
                    $trainingTMM->Complete_by = Auth::user()->name;
                    $trainingTMM->Complete_on = Carbon::now()->format('d-m-Y');
                    $trainingTMM->Complete_comment = $request->comment;

                    $history = new TrainingMaterialManagementAudit();
                    $history->TMM_id = $id;
                    $history->activity_type = 'Activity Log';
                    $history->current = $trainingTMM->Complete_by;
                    $history->comment = $request->comment;
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to = "Closed – Done";
                    $history->change_from = $lastTrainingTMM->status;
                    $history->action = 'QA Review Complete';
                    $history->stage = 'Pending QA Review';
                    $trainingTMM->update();

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




}
