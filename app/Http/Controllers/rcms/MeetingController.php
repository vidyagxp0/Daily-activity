<?php

namespace App\Http\Controllers\rcms;
use PDF;
use App\Http\Controllers\Controller;
use App\Models\Meeting;
use App\Models\MeetingGrid;
use App\Models\MeetingManagementAuditTrail;
use App\Models\RecordNumber;
use App\Models\RoleGroup;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class MeetingController extends Controller
{
    public function index(){
        $record_number = ((RecordNumber::first()->value('counter')) + 1);
        $record = str_pad($record_number, 4, '0', STR_PAD_LEFT); 
        // $auditeeId = explode(',', $meeting->attandees);
        return response()->view('frontend.meeting-managment.meeting_create',compact( 'record_number'));       
    }

    public function store(Request $request){
        $meeting = new Meeting();
        $meeting->type = "Meeting";
        $meeting->record = ((RecordNumber::first()->value('counter')) + 1);
        $meeting->division_id = $request->division_id;
        $meeting->parent_id = $request->parent_id;
        $meeting->record_number = $request->record_number;
       

        $meeting->parent_type = $request->parent_type;
        $meeting->initiator_id = $request->initiator_id;
        $meeting->assign_to = $request->assign_to;
        $meeting->due_date = $request->due_date;
        $meeting->scheduled_start_date = $request->scheduled_start_date;
        $meeting->scheduled_end_date = $request->scheduled_end_date;
        $meeting->attandees = implode(',',$request->attandees);
        $meeting->description = $request->description;
        $meeting->related_urls = $request->related_urls;
        $meeting->short_description = $request->short_description;

        $meeting->actual_start_date = $request->actual_start_date;
        $meeting->actual_end_date = $request->actual_end_date;
        $meeting->meeting_minutes = $request->meeting_minutes;
        $meeting->decisions = $request->decisions;
        $meeting->country = $request->country;
        $meeting->state = $request->state;
        $meeting->city = $request->city;
        $meeting->zone = $request->zone;

        $meeting->site_name = $request->site_name;
        $meeting->building = $request->building;
        $meeting->floor = $request->floor;
        $meeting->room = $request->room;
        $meeting->stage = 1;
        $meeting->status = "Opened";

        if (!empty($request->attachment_files)) {
            $files = [];
            if ($request->hasfile('attachment_files')) {
                foreach ($request->file('attachment_files') as $file) {
                    $name = "Meetings-" . 'attachment_files' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $meeting->attachment_files = json_encode($files);
        }
        $meeting->save();
        
        $record = RecordNumber::first();
        $record->counter = ((RecordNumber::first()->value('counter')) + 1);
        $record->update();


        $data1 = new MeetingGrid();
        $data1->meeting_id = $meeting->id;
        if (!empty($request->grid_date)) {
            $data1->grid_date = serialize($request->grid_date);
        }
        if (!empty($request->topic)) {
            $data1->topic = serialize($request->topic);
        }
        if (!empty($request->responsible)) {
            $data1->responsible = serialize($request->responsible);
        }
        if (!empty($request->scheduled_start_time_grid)) {
            $data1->scheduled_start_time_grid = serialize($request->scheduled_start_time_grid);
        }
        if (!empty($request->scheduled_end_time_grid)) {
            $data1->scheduled_end_time_grid = serialize($request->scheduled_end_time_grid);
        }
        if (!empty($request->remarks)) {
            $data1->remarks = serialize($request->remarks);
        }
        $data1->save();


        if (!empty($meeting->description)) {
            $history = new MeetingManagementAuditTrail();
            $history->meeting_id = $meeting->id;
            $history->activity_type = 'Description';
            $history->previous = "NA";
            $history->current = $meeting->description;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $meeting->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiator";
            $history->action_name = "store";
            $history->save();
        }
        if (!empty($meeting->due_date)) {
            $history = new MeetingManagementAuditTrail();
            $history->meeting_id = $meeting->id;
            $history->activity_type = 'Due Date';
            $history->previous = "NA";
            $history->current = $meeting->due_date;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $meeting->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiator";
            $history->action_name = "store";
            $history->save();
        }
        if (!empty($meeting->short_description)) {
            $history = new MeetingManagementAuditTrail();
            $history->meeting_id = $meeting->id;
            $history->activity_type = 'Short Description';
            $history->previous = "NA";
            $history->current = $meeting->short_description;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $meeting->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiator";
            $history->action_name = "store";
            $history->save();
        }
        if (!empty($meeting->scheduled_start_date)) {
            $history = new MeetingManagementAuditTrail();
            $history->meeting_id = $meeting->id;
            $history->activity_type = 'Scheduled Start Date';
            $history->previous = "NA";
            $history->current = $meeting->scheduled_start_date;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $meeting->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiator";
            $history->action_name = "store";
            $history->save();
        }
        if (!empty($meeting->scheduled_end_date)) {
            $history = new MeetingManagementAuditTrail();
            $history->meeting_id = $meeting->id;
            $history->activity_type = 'Scheduled End Date';
            $history->previous = "NA";
            $history->current = $meeting->scheduled_end_date;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $meeting->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiator";
            $history->action_name = "store";
            $history->save();
        }


        toastr()->success('Record is created Successfully');
        return redirect('rcms/qms-dashboard');
    }

    public function show($id){
        $meeting = Meeting::find($id);
        $data = $meeting;
        $auditeeId = explode(',', $meeting->attandees);
        
        return response()->view('frontend.meeting-managment.meeting_view', compact('meeting', 'auditeeId',  'data'));

    }

    public function update(Request $request, $id){
        
        $meeting = Meeting::find($id);
        $meeting->type = "Meeting";
        // $meeting->record = ((RecordNumber::first()->value('counter')) + 1);
        // $meeting->division_id = $request->division_id;
        $meeting->parent_id = $request->parent_id;
        $meeting->record_number = $request->record_number;
        $meeting->parent_type = $request->parent_type;
        $meeting->initiator_id = $request->initiator_id;
        $meeting->assign_to = $request->assign_to;
        $meeting->due_date = $request->due_date;
        $meeting->scheduled_start_date = $request->scheduled_start_date;
        $meeting->scheduled_end_date = $request->scheduled_end_date;
        $meeting->attandees = implode(',',$request->attandees);
        $meeting->description = $request->description;
        $meeting->related_urls = $request->related_urls;
        $meeting->short_description = $request->short_description;

        $meeting->actual_start_date = $request->actual_start_date;
        $meeting->actual_end_date = $request->actual_end_date;
        $meeting->meeting_minutes = $request->meeting_minutes;
        $meeting->decisions = $request->decisions;
        $meeting->country = $request->country;
        $meeting->state = $request->state;
        $meeting->city = $request->city;
        $meeting->zone = $request->zone;

        $meeting->site_name = $request->site_name;
        $meeting->building = $request->building;
        $meeting->floor = $request->floor;
        $meeting->room = $request->room;
        $meeting->stage = 1;
        $meeting->status = "Opened";

        if (!empty($request->attachment_files)) {
            $files = [];
            if ($request->hasfile('attachment_files')) {
                foreach ($request->file('attachment_files') as $file) {
                    $name = "Meetings-" . 'attachment_files' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $meeting->attachment_files = json_encode($files);
        }
        $meeting->update();
        
        $data1 =  MeetingGrid::where('meeting_id', $id)->first();
        $data1->meeting_id = $id;
        if (!empty($request->grid_date)) {
            $data1->grid_date = serialize($request->grid_date);
        }
        if (!empty($request->topic)) {
            $data1->topic = serialize($request->topic);
        }
        if (!empty($request->responsible)) {
            $data1->responsible = serialize($request->responsible);
        }
        if (!empty($request->scheduled_start_time_grid)) {
            $data1->scheduled_start_time_grid = serialize($request->scheduled_start_time_grid);
        }
        if (!empty($request->scheduled_end_time_grid)) {
            $data1->scheduled_end_time_grid = serialize($request->scheduled_end_time_grid);
        }
        if (!empty($request->remarks)) {
            $data1->remarks = serialize($request->remarks);
        }
        $data1->update();

        toastr()->success('Record is created Successfully');
        return redirect()->back();
    }

    public function meetingStateChange(Request $request,$id)
    {
        if ($request->username == Auth::user()->Username && Hash::check($request->password, Auth::user()->password)) {
            $meeting = Meeting::find($id);
            $lastDocument =  Meeting::find($id);
            // $data = Meeting::find($id);


           if( $meeting->stage == 1){
            $meeting->stage = "2";
            $meeting->submitted_by = Auth::user()->name;
            $meeting->submitted_on = Carbon::now()->format('d-M-Y');
            $meeting->submitted_comment = $request->comment;
            $meeting->status = "In Progress";

            $attendees = explode(',', $meeting->attandees);

            $users = User::whereIn('id', $attendees)->get();
            $body_data = [
                'initiator_id' => auth()->id(),
                'initiator_name' => Auth::user()->name,
                'initiator_email' => Auth::user()->email,
                'schedule_start' => $meeting->scheduled_start_date,
                'schedule_end' => $meeting->scheduled_end_date,
                'desc' => $meeting->description,
                'users' => $users
            ];

            $res = Http::post("https://mms.mydemosoftware.com/api/generate/meeting", $body_data);
            // return $res->json();

            if ($res->json()['status'] == 'ok') {
            
                $meeting_code = $res->json()['data']['related_url'];

                $meeting->meeting_id = $meeting_code;
                $meeting->save();
            } else {
                toastr()->error($res->json()['message']);

                return redirect()->back();
            }


            // $meeting->update();

            return redirect()->back();
           }
           if( $meeting->stage == 2)
           {
            $meeting->stage = "3";
            $meeting->complete_by = Auth::user()->name;
            $meeting->complete_on = Carbon::now()->format('d-M-Y');
            $meeting->complete_comment = $request->comment;
            $meeting->status = "Close Done";

            // dd($meeting->stage);
            $meeting->update();
            return redirect()->back();
           }
        }else {
            toastr()->error('E-signature Not match');
            return back();
        }
    }

    public function MeetingAuditTrial($id)
    {
        $detail = MeetingManagementAuditTrail::find($id);

        $detail_data = MeetingManagementAuditTrail::where('activity_type', $detail->activity_type)->where('meeting_id', $detail->meeting_id)->latest()->get();
        $audit = MeetingManagementAuditTrail::where('meeting_id', $id)->orderByDESC('id')->paginate(5);
        $doc = Meeting::where('id', $detail->meeting_id)->first();
        $document = $doc; 
        $doc->origiator_name = User::find($doc->initiator_id);
        return view('frontend.meeting-management.audit_inner_report', compact('detail', 'document', 'doc','audit', 'detail_data'));

    }

    public static function singleReport($id)
    {
        $data = Meeting::find($id);
        if (!empty($data))
         {
            // $data->Product_Details = CapaGrid::where('capa_id', $id)->where('type', "Product_Details")->first();
            // $data->Instruments_Details = CapaGrid::where('capa_id', $id)->where('type', "Instruments_Details")->first();
            // $data->Material_Details = CapaGrid::where('capa_id', $id)->where('type', "Material_Details")->first();
            $data->originator = User::where('id', $data->initiator_id)->value('name');
            $pdf = App::make('dompdf.wrapper');
            $time = Carbon::now();
            $pdf = PDF::loadview('frontend.meeting-management.single_report', compact('data'))
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
