<?php

namespace App\Http\Controllers;
use App\Models\RecordNumber;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ActionItem;
use App\Models\Capa;
use App\Models\EHSEventHistory;
use App\Models\User;
use App\Models\SanctionAuditTrail;
use App\Models\RoleGroup;
use App\Models\CapaGrid;
use App\Models\Extension;
use App\Models\extension_new;

use App\Models\CC;
use App\Models\Division;
use App\Models\InternalAuditGrid;
use Illuminate\Support\Facades\Http;
use PDF;
use Helpers;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\OpenStage;
use App\Models\QMSDivision;
use App\Models\Sanction;

class SanctionController extends Controller
{
    public function index()
    {
        $record_number = ((RecordNumber::first()->value('counter')) + 1);
        $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
        $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $due_date = $formattedDate->format('Y-m-d');
       return view('frontend.sanction.sanction_create', compact('record_number',) );
       
        
    }
    public function sanction_store(Request $request)
    {

        if (!$request->short_description) {
            toastr()->error("Short description is required");
            return redirect()->back()->withInput();
        }
        $Sanction = new Sanction();
        $Sanction->form_type = "Sanction";
        $Sanction->record = ((RecordNumber::first()->value('counter')) + 1);
        $Sanction->initiator_id = Auth::user()->id;
        $Sanction->division_id = $request->division_id;
        $Sanction->division_code = $request->division_code;
        $Sanction->intiation_date = $request->intiation_date;
        $Sanction->form_type = $request->form_type;
        $Sanction->record_number = $request->record_number;
        $Sanction->parent_id = $request->parent_id;
        $Sanction->parent_type = $request->parent_type;
        $Sanction->assign_to = $request->assign_to;
        $Sanction->due_date = $request->due_date;
        $Sanction->short_description = $request->short_description;
        $Sanction->Type = $request->Type;
        $Sanction->Description = $request->Description;
        $Sanction->Authority_Type = $request->Authority_Type;
        $Sanction->Authority = $request->Authority;
        $Sanction->Fine = $request->Fine;
        $Sanction->Currency = $request->Currency;

        $Sanction->status = 'Opened';
        $Sanction->stage = 1;

        if (!empty($request->Attached_File)) {
            $files = [];
            if ($request->hasfile('Attached_File')) {
                foreach ($request->file('Attached_File') as $file) {
                    $name = $request->name . '-Attached_File' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $Sanction->Attached_File = json_encode($files);
        }

       
        $Sanction->save();

        if (!empty($Sanction->record)) {
            $history = new SanctionAuditTrail();
            $history->sanction_id = $Sanction->id;
            $history->activity_type = 'Record Number';
            $history->previous = "Null";
            $history->current = Helpers::getDivisionName(session()->get('division')) . "/Sanction/" . Helpers::year($Sanction->created_at) . "/" . str_pad($Sanction->record, 4, '0', STR_PAD_LEFT);
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $Sanction->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = "Create";
            $history->save();
        }  



        $record = RecordNumber::first();
        $record->counter = ((RecordNumber::first()->value('counter')) + 1);
        $record->update();

        toastr()->success("Record is Create Successfully");
        return redirect(url('rcms/qms-dashboard'));

    }
    public function show($id)
    {      
        
        $data = Sanction::find($id);
        $Sanction  = Sanction::find($id);
        
        $record_number = ((RecordNumber::first()->value('counter')) + 1);
        $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
        $Sanction->record = str_pad($Sanction->record, 4, '0', STR_PAD_LEFT);
        $Sanction->assign_to_name = User::where('id', $Sanction->assign_id)->value('name');
        $Sanction->initiator_name = User::where('id', $Sanction->initiator_id)->value('name');
        $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $due_date = $formattedDate->format('Y-m-d');
       
        return view('frontend.sanction.sanction_view', compact('data', 'record_number','Sanction'));
    }
    public function update(Request $request, $id)
    {       
        $lastDocument = Sanction::find($id);
        $Sanction = Sanction::find($id);
        
        $Sanction->assign_to = $request->assign_to;
        $Sanction->due_date = $request->due_date;
        $Sanction->short_description = $request->short_description;
        $Sanction->Type = $request->Type;
        $Sanction->Description = $request->Description;
        $Sanction->Authority_Type = $request->Authority_Type;
        $Sanction->Authority = $request->Authority;
        $Sanction->Fine = $request->Fine;
        $Sanction->Currency = $request->Currency;
        

        if (!empty($request->Attached_File)) {
            $files = [];
            if ($request->hasfile('Attached_File')) {
                foreach ($request->file('Attached_File') as $file) {
                    $name = $request->name . 'Attached_File' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $Sanction->Attached_File = json_encode($files);
        }
       
        $Sanction->update();

      
                
        toastr()->success("Record is Update Successfully");
        return back(); 
    }
    public function SanctionCancel(Request $request, $id)
    {
        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $SanctionControl = Sanction::find($id);
            $lastDocument = Sanction::find($id);
            

            if ($SanctionControl->stage == 1) {
                $SanctionControl->stage = "2";
                $SanctionControl->status = "Closed";
                $SanctionControl->Cancel_By = Auth::user()->name;
                $SanctionControl->Cancel_On = Carbon::now()->format('d-M-Y');
                $SanctionControl->Cancel_Comment = $request->comment;
                $history = new SanctionAuditTrail();
                $history->sanction_id = $id;
                $history->activity_type = 'Cancel By,Cancel On';
                $history->action = 'Cancel';
                // $history->previous = "";
                // $history->current = $SanctionControl->Cancel_By;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state =  $SanctionControl->status;
                $history->change_to = "Closed";
                $history->change_from = $lastDocument->status;
                $history->stage = 'Closed';
                if (is_null($lastDocument->Cancel_By) || $lastDocument->Cancel_By === '') {
                    $history->previous = "";
                } else {
                    $history->previous = $lastDocument->Cancel_By . ' , ' . $lastDocument->Cancel_On;
                }
                $history->current = $SanctionControl->Cancel_By . ' , ' . $SanctionControl->Cancel_On;
                if (is_null($lastDocument->Cancel_By) || $lastDocument->Cancel_By === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->save();
                $SanctionControl->update();
                $history = new EHSEventHistory();
                $history->type = "Sanction";
                $history->doc_id = $id;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->stage_id = $SanctionControl->stage;
                $history->status = $SanctionControl->status;
                $history->save();

                // $list = Helpers::getInitiatorUserList();
                // foreach ($list as $u) {
                //     if($u->q_m_s_divisions_id == $SanctionControl->division_id){
                //       $email = Helpers::getInitiatorEmail($u->user_id);
                //       if ($email !== null) {

                //         Mail::send(
                //             'mail.view-mail',
                //             ['data' => $SanctionControl],
                //             function ($message) use ($email) {
                //                 $message->to($email)
                //                     ->subject("Cancelled By ".Auth::user()->name);
                //             }
                //          );
                //       }
                //     }
                // }

                toastr()->success('Document Sent');
                return back();
            }
                    } else {
            toastr()->error('E-signature Not match');
            return back();
        }
    }

    public static function SanctionAuditReport($id)
    {
        $doc = Sanction::find($id);
        if (!empty($doc)) {
            $doc->originator = User::where('id', $doc->initiator_id)->value('name');
            $data = SanctionAuditTrail::where('sanction_id', $id)->get();
            $pdf = App::make('dompdf.wrapper');
            $time = Carbon::now();
            $data = $data->sortBy('created_at');
            $pdf = PDF::loadview('frontend.sanction.sanction_audit_report', compact('data', 'doc'))
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

    public function SanctionAuditTrail($id)
    {
        $audit = SanctionAuditTrail::where('sanction_id', $id)->orderByDESC('id')->paginate();
        $today = Carbon::now()->format('d-m-y');
        $document = Sanction::where('id', $id)->first();
        $document->initiator = User::where('id', $document->initiator_id)->value('name');
        $data = Sanction::find($id);

        return view('frontend.sanction.sanction_audit_trail', compact('audit', 'document', 'today', 'data'));
    }

    public static function SanctionSingleReport($id)
    {
        $data = Sanction::find($id);

        if (!empty($data)) {
           
            $pdf = App::make('dompdf.wrapper');
            $time = Carbon::now();
            $pdf = PDF::loadview('frontend.sanction.sanction_single_report', compact('data', ))
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

