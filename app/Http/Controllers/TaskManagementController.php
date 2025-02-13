<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RecordNumber;
use App\Models\TaskManagement;
use App\Models\TaskManagementAuditTrail;
use App\Models\User;
use App\Models\TaskManagementGrid;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Helpers;
use App\Models\RoleGroup;

class TaskManagementController extends Controller
{
    public function task_management()
    {
        $record_number = ((RecordNumber::first()->value('counter')) + 1);
        $record = str_pad($record_number, 6, '0', STR_PAD_LEFT);
        $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $due_date = $formattedDate->format('Y-m-d');
        return view("frontend.task-management.task_management_create", compact('due_date', 'record_number'));
    }

    public function task_management_store(Request $request)
    {


        $taskmanagement = new TaskManagement;

        $taskmanagement->form_type = 'Task Management';
        $taskmanagement->record = ((RecordNumber::first()->value('counter')) + 1);
        $taskmanagement->initiator_id = Auth::user()->id;
        $taskmanagement->intiation_date = $request->intiation_date;
        $taskmanagement->record_number = $request->record_number;
        $taskmanagement->short_description = $request->short_description;
        $taskmanagement->final_comments= $request->final_comments;
        $taskmanagement->save();

        $taskmanagement->status = 'Opened';
        $taskmanagement->stage = 1;

        $taskmanagement->save();

        $TaskManagementUpdate = $taskmanagement->id;
        if (! empty($request->TaskManagementData)) {
            $summaryShow = TaskManagementGrid::where(['task_management_id' => $TaskManagementUpdate, 'identifier' => 'Task Management Data'])->firstOrNew();
            $summaryShow->task_management_id = $TaskManagementUpdate;
            $summaryShow->identifier = 'Task Management Data';
            $summaryShow->data = $request->TaskManagementData;
            $summaryShow->save();
        }

        if (! empty($taskmanagement->record)) {
            $history = new TaskManagementAuditTrail;
            $history->task_id = $taskmanagement->id;
            $history->activity_type = 'Record Number';
            $history->previous = 'Null';
            $history->current = Helpers::getDivisionName(session()->get('division')).'/TM/'.Helpers::year($taskmanagement->created_at).'/'.str_pad($taskmanagement->record, 4, '0', STR_PAD_LEFT);
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $taskmanagement->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($taskmanagement->initiator_id)) {
            $history = new TaskManagementAuditTrail;
            $history->task_id = $taskmanagement->id;
            $history->activity_type = 'Initiator';
            $history->previous = 'Null';
            $history->current = Helpers::getInitiatorName($taskmanagement->initiator_id);
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $taskmanagement->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($taskmanagement->intiation_date)) {
            $history = new TaskManagementAuditTrail;
            $history->task_id = $taskmanagement->id;
            $history->activity_type = 'Date of Initiation';
            $history->previous = 'Null';
            $history->current = Helpers::getdateFormat($taskmanagement->intiation_date);
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $taskmanagement->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($taskmanagement->short_description)) {
            $history = new TaskManagementAuditTrail;
            $history->task_id = $taskmanagement->id;
            $history->activity_type = 'Short Description';
            $history->previous = 'Null';
            $history->current = $taskmanagement->short_description;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $taskmanagement->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        $record = RecordNumber::first();
        $record->counter = ((RecordNumber::first()->value('counter')) + 1);
        $record->update();

        toastr()->success('Record is Create Successfully');

        return redirect(url('rcms/qms-dashboard'));

    }

    public function taskManagementUpdate(Request $request, $id)
    {
        $lastDocument = TaskManagement::find($id);
        $taskmanagement = TaskManagement::find($id);

        $taskmanagement->short_description = $request->short_description;
        $taskmanagement->final_comments= $request->final_comments;

        $taskmanagement->update();

        $TaskManagementUpdate = $taskmanagement->id;
        if (! empty($request->TaskManagementData)) {
            $summaryShow = TaskManagementGrid::where(['task_management_id' => $TaskManagementUpdate, 'identifier' => 'Task Management Data'])->firstOrNew();
            $summaryShow->task_management_id = $TaskManagementUpdate;
            $summaryShow->identifier = 'Task Management Data';
            $summaryShow->data = $request->TaskManagementData;
            $summaryShow->save();
        }

        toastr()->success('Record is Update Successfully');

        return back();
    }



    public function task_management_show($id)
    {
        $Task = TaskManagement::find($id);
        $data = TaskManagement::find($id);
        
        $TaskGrid = TaskManagementGrid::find($id);

        $TaskGridData = TaskManagementGrid::where(['task_management_id' => $id, 'identifier' => 'Task Management Data'])->first();

        $record_number = ((RecordNumber::first()->value('counter')) + 1);
        $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
        $data->record = str_pad($data->record, 4, '0', STR_PAD_LEFT);
        $data->assign_to_name = User::where('id', $data->assign_id)->value('name');
        $data->initiator_name = User::where('id', $data->initiator_id)->value('name');
        $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $due_date = $formattedDate->format('Y-m-d');

        return view('frontend.task-management.task_management_view', compact('data', 'record_number','Task', 'TaskGrid', 'TaskGridData'));
    }

    public function AuditTrailTask($id)
    {
        $audit = TaskManagementAuditTrail::where('task_id', $id)->orderByDESC('id')->paginate();
        $today = Carbon::now()->format('d-m-y');
        $document = TaskManagement::where('id', $id)->first();
        $document->initiator = User::where('id', $document->initiator_id)->value('name');
        $data = TaskManagement::find($id);

        return view('frontend.task-management.task_management_auditTrail', compact('audit', 'document', 'today', 'data'));
    }

    public function taskManagementSendStage(Request $request, $id)
    {
        if ($request->username == Auth::user()->Username && Hash::check($request->password, Auth::user()->password)) {
            $taskManage = TaskManagement::find($id);
            $lastDocument = TaskManagement::find($id);

            
            if ($taskManage->stage == 1) {
                $taskManage->stage = "2";
                $taskManage->status = "In Review";
                $taskManage->submit_by = Auth::user()->name;
                $taskManage->submit_on = Carbon::now()->format('d-M-Y');
                $taskManage->submit_comment = $request->comment;
                    $history = new TaskManagementAuditTrail();
                    $history->task_id = $id;
                    $history->activity_type = 'Activity Log';
                    $history->previous = "";
                    $history->current = $taskManage->submit_by;
                    $history->action = 'Approve';
                    $history->comment = $request->comment;
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $lastDocument->status;
                    $history->change_to =   "In Review";
                    $history->change_from = $lastDocument->status;
                    $history->action_name = 'Submit';
                    $history->stage = 'In Review';
                  //  dd($history->action_name );
                    $history->save();


                $taskManage->update();
                toastr()->success('Document Sent');
                return back();
            }

            if ($taskManage->stage == 2) {
                $taskManage->stage = "3";
                $taskManage->status = "In Approve";
                $taskManage->reviewed_by = Auth::user()->name;
                $taskManage->reviewed_on = Carbon::now()->format('d-M-Y');
                $taskManage->reviewed_comment = $request->comment;
                    $history = new TaskManagementAuditTrail();
                    $history->task_id = $id;
                    $history->activity_type = 'Activity Log';
                    $history->previous = "";
                    $history->current = $taskManage->reviewed_by;
                    $history->action = 'Approve';
                    $history->comment = $request->comment;
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $lastDocument->status;
                    $history->change_to =   "In Approve";
                    $history->change_from = $lastDocument->status;
                    $history->action_name = 'Review';
                    $history->stage = 'In Approve';
                  //  dd($history->action_name );
                    $history->save();


                $taskManage->update();
                toastr()->success('Document Sent');
                return back();
            }


        } else {
            toastr()->error('E-signature Not match');
            return back();
        }
    }
}
