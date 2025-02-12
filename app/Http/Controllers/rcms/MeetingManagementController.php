<?php

namespace App\Http\Controllers\rcms;

use App\Http\Controllers\Controller;
use App\Models\RegulatoryInspection;
use App\Models\CriticalAction;
use App\Models\Meeting;
use Illuminate\Http\Request;
use App\Models\RecordNumber;
use Helpers;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use App\Models\QMSProcess;
use App\Models\QMSDivision;
use App\Models\RegulatoryAction;
use Illuminate\Pagination\LengthAwarePaginator;



class MeetingManagementController extends Controller
{
    public function index(Request $request)
    {
        $table = [];

        $Meeting = Meeting::orderByDesc('id')->get();
        $record_number = ((RecordNumber::first()->value('counter')) + 1);
        $record = str_pad($record_number, 4, '0', STR_PAD_LEFT); 
        // $RegulatoryAction = RegulatoryAction::orderByDesc('id')->get();
        // $CriticalAction = CriticalAction::orderByDesc('id')->get();

        foreach ($Meeting as $data) {
            $data->create = Carbon::parse($data->created_at)->format('d-M-Y h:i A');
            
            array_push($table, [
                "id" => $data->id,
                "parent" => $data->cc_id ? $data->cc_id : "-",
                "record" => $data->record,
                "due_date" => $data->due_date,
                "type" => "Meeting",
                "parent_id" => $data->parent_id,
                "parent_type" => $data->parent_type,
                "division_id" => $data->division_id,
                "short_description" => $data->short_description ? $data->short_description : "-",
                "initiator_id" => $data->initiator_id,
                // "initiated_through" => $data->initiated_through,
                "intiation_date" => $data->intiation_date,
                "stage" => $data->status,
                "date_open" => $data->created_at,
                "date_close" => $data->updated_at,
            ]);
        }
      

        $table  = collect($table)->sortBy('record')->reverse()->toArray();
        $datag = $this->paginate($table);
        $uniqueProcessNames = QMSProcess::select('process_name')->distinct()->pluck('process_name');
        return view('frontend.meeting-managment.meeting_create', compact('datag', 'uniqueProcessNames','record_number','record'));
    }

    public function ccViewMeeting($id, $type)
    {

        $division_name = "NA";

        if ($type == "Meeting") {
            $data = Meeting::find($id);
            $single = "single_report/" . $data->id;
            $audit = "audit_pdf/".$data->id;
            $parent = "#";
            $division = QMSDivision::find($data->division_id);
            $division_name = $division->name;
        }

        
      

        $type = $type == 'Capa' ? 'CAPA' : $type;

        $html = '';
        $html = '<div class="block">
        <div class="record_no">
            Record No. ' . str_pad($data->record, 4, '0', STR_PAD_LEFT) .
            '</div>
        <div class="division">
        ' . $division_name . '/ ' . $type . '
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
                    <a href="send-notification" class="list-item">Send Notification</a>
                    <div class="list-drop">
                        <div class="list-item" onclick="showAction()">
                            <div>Run Report</div>
                            <div><i class="fa-solid fa-angle-down"></i></div>
                        </div>
                        <div class="drop-list">
                            <a target="__blank" href="' . $audit . '" class="inner-item">Audit Trail</a>
                            <a target="__blank" href="' . $single . '" class="inner-item">' . $type . ' Single Report</a>
                        </div>
                    </div>
                </div>
            </div>';
        $response['html'] = $html;

        return response()->json($response);
    }
    public function paginate($items, $perPage = 100000, $page = null, $options = ['path' => 'mytaskdata'])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
