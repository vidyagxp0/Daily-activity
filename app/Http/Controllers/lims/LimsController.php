<?php

namespace App\Http\Controllers\lims;

use App\Http\Controllers\Controller;
use App\Models\ActionItem;
use App\Models\Auditee;
use App\Models\AuditProgram;
use App\Models\Capa;
use App\Models\CC;
use App\Models\Errata;
use App\Models\Extension;
use App\Models\Analytics;
use App\Models\InternalAudit;
use App\Models\InventoryManagement;
use App\Models\Observation;
use App\Models\Receipt;
use App\Models\SampleStability;
use App\Models\Ootc;
use App\Models\QMSDivision;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Carbon\Carbon;
use Helpers;
use PDF;
use App\Models\SamplePlanning;
use App\Models\QMSProcess;
use App\Models\ControlSample;
// use Helpers;
// use PDF;

use Illuminate\Support\Facades\App;
class LimsController extends Controller
{
    public function index(Request $request)
    {
        $loggedInUserId = auth()->id();
        $notificationTable = 'notification_users';

        $table = [];
        $filterType = $request->input('filterType', 'all');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $datasQuery = Receipt::query();
        $ControlSampleQuery = ControlSample::query();
        $datasIMQuery = InventoryManagement::query();
        $Analytics = Analytics::query();
        $stabilityQuery = SampleStability::query(); 
        $sampleManagmentII = SamplePlanning::query(); 

        $currentDate = Carbon::now();

        if ($filterType !== 'all' && $filterType !== '' && $filterType !== 'custom') {
            // $datasQuery->whereNotIn(column: 'status', ['Closed Done']);
            // $datasIMQuery->whereNotIn(column: 'status', ['Closed Done']);

        }
       
        

        switch ($filterType) {
            case 'weekly':
                $startOfPreviousWeek = Carbon::now()->subDays(7);
                $endOfPreviousWeek = Carbon::now();

                $datasQuery->whereBetween('created_at', [$startOfPreviousWeek, $endOfPreviousWeek]);
                $ControlSampleQuery->whereBetween('created_at', [$startOfPreviousWeek, $endOfPreviousWeek]);
                $Analytics->whereBetween('created_at', [$startOfPreviousWeek, $endOfPreviousWeek]);
                $stabilityQuery->whereBetween('created_at', [$startOfPreviousWeek, $endOfPreviousWeek]);
                $sampleManagmentII->whereBetween('created_at', [$startOfPreviousWeek, $endOfPreviousWeek]);
                break;

            case 'fortnight':
                $startOfPreviousfortnight = Carbon::now()->subDays(14);
                $endOfPreviousfortnight = Carbon::now();

                $datasQuery->whereBetween('created_at', [$startOfPreviousfortnight, $endOfPreviousfortnight]);
                $ControlSampleQuery->whereBetween('created_at', [$startOfPreviousfortnight, $endOfPreviousfortnight]);
                $datasIMQuery->whereBetween('created_at', [$startOfPreviousfortnight, $endOfPreviousfortnight]);
                $Analytics->whereBetween('created_at', [$startOfPreviousfortnight, $endOfPreviousfortnight]);
                $stabilityQuery->whereBetween('created_at', [$startOfPreviousfortnight, $endOfPreviousfortnight]);
                $sampleManagmentII->whereBetween('created_at', [$startOfPreviousfortnight, $endOfPreviousfortnight]);

                break;
    
            case 'quarterly':
                $startOfPreviousforquarterly = Carbon::now()->subDays(90);
                $endOfPreviousfortquarterly = Carbon::now();
    
                $datasQuery->whereBetween('created_at', [$startOfPreviousforquarterly, $endOfPreviousfortquarterly]);
                $ControlSampleQuery->whereBetween('created_at', [$startOfPreviousforquarterly, $endOfPreviousfortquarterly]);
                $stabilityQuery->whereBetween('created_at', [$startOfPreviousforquarterly, $endOfPreviousfortquarterly]);
                $sampleManagmentII->whereBetween('created_at', [$startOfPreviousforquarterly, $endOfPreviousfortquarterly]);
                break;

            case 'halfyearly':
                $startOfPrevioushalfyearly = Carbon::now()->subDays(180);
                $endOfPrevioushalfyearly = Carbon::now();
        
                $datasQuery->whereBetween('created_at', [$startOfPrevioushalfyearly, $endOfPrevioushalfyearly]);
                $ControlSampleQuery->whereBetween('created_at', [$startOfPrevioushalfyearly, $endOfPrevioushalfyearly]);
                $stabilityQuery->whereBetween('created_at', [$startOfPrevioushalfyearly, $endOfPrevioushalfyearly]);
                $sampleManagmentII->whereBetween('created_at', [$startOfPrevioushalfyearly, $endOfPrevioushalfyearly]);
                // $Analytics->whereBetween(column: 'created_at', [$startOfPrevioushalfyearly, $endOfPrevioushalfyearly]);

                break;

            case 'monthly':
                $startOfMonth = Carbon::now()->subDays(30);
                $endOfMonth = Carbon::now();

                $datasQuery->whereBetween('created_at', [$startOfMonth, $endOfMonth]);
                $ControlSampleQuery->whereBetween('created_at', [$startOfMonth, $endOfMonth]);
                $datasIMQuery->whereBetween('created_at', [$startOfMonth, $endOfMonth]);
                $Analytics->whereBetween('created_at', [$startOfMonth, $endOfMonth]);
                $stabilityQuery->whereBetween('created_at', [$startOfMonth, $endOfMonth]);
                $sampleManagmentII->whereBetween('created_at', [$startOfMonth, $endOfMonth]);

                break;

            case 'annually':
                $startOfYear = Carbon::now()->subDays(365);
                $endOfYear = Carbon::now();

                $datasQuery->whereBetween('created_at', [$startOfYear, $endOfYear]);
                $ControlSampleQuery->whereBetween('created_at', [$startOfYear, $endOfYear]);
                $datasIMQuery->whereBetween('created_at', [$startOfYear, $endOfYear]);
                $Analytics->whereBetween('created_at', [$startOfYear, $endOfYear]);
                $stabilityQuery->whereBetween('created_at', [$startOfYear, $endOfYear]);
                $sampleManagmentII->whereBetween('created_at', [$startOfYear, $endOfYear]);

                break;

            case 'custom':
                if ($startDate && $endDate) {
                    $start = Carbon::parse($startDate)->startOfDay();
                    $end = Carbon::parse($endDate)->endOfDay();
        
                    $datasQuery->whereBetween('created_at', [$start, $end]);
                    $ControlSampleQuery->whereBetween('created_at', [$start, $end]);
                    $datasIMQuery->whereBetween('created_at', [$start, $end]);
                    $Analytics->whereBetween('created_at', [$start, $end]);
                    $stabilityQuery->whereBetween('created_at', [$start, $end]);
                    $sampleManagmentII->whereBetween('created_at', [$start, $end]);

                }
                break;

            default:
                break;
        }
        

        $datas = $datasQuery->orderByDesc('id')->get();
        $ControlSample = $ControlSampleQuery->orderByDesc('id')->get();
        $datasIM = $datasIMQuery->orderByDesc('id')->get();
        $AnalyticsIM = $Analytics->orderByDesc('id')->get();
        $stabilityData = $stabilityQuery->orderByDesc('id')->get();
        $sampleManagmentIIData = $sampleManagmentII->orderByDesc('id')->get();

        
        foreach ($datas as $data) {
            $data->create = Carbon::parse($data->created_at)->format('d-M-Y h:i A');

            array_push($table, [
                "id" => $data->id,
                "parent" => $data->cc_id ? $data->cc_id : "-",
                // "parent" => $data->parent_record ? $data->parent_record : "-",
                "record" => $data->record,
                "due_date" => $data->due_date,
                "type" => "Sample Management I",
                "parent_id" => $data->parent_id,
                "parent_type" => $data->parent_type,
                "division_id" => $data->division_id,
                "short_description" => $data->short_description ? $data->short_description : "-",
                "initiator_id" => $data->initiator_id,
                "initiated_through" => $data->initiated_through,
                "intiation_date" => $data->intiation_date,
                "stage" => $data->status,
                "date_open" => $data->created_at,
                "date_close" => $data->updated_at,
                "division_name" => Helpers::getDivisionName($data->division_id),
                "filter_date_opened" => Helpers::getdateFormat1($data->created_at),
                "filter_originator" => Helpers::getInitiatorName($data->initiator_id),
                "filter_due_date" => Helpers::getdateFormat($data->due_date),
            ]);
            
        }
        foreach ($sampleManagmentIIData as $data) {
            $data->create = Carbon::parse($data->created_at)->format('d-M-Y h:i A');

            array_push($table, [
                "id" => $data->id,
                "parent" => $data->cc_id ? $data->cc_id : "-",
                "record" => $data->record,
                "due_date" => $data->due_date,
                "type" => "Sample Management II",
                "parent_id" => $data->parent_id,
                "parent_type" => $data->parent_type,
                "division_id" => $data->division_id,
                "short_description" => $data->short_description ? $data->short_description : "-",
                "initiator_id" => $data->initiator_id,
                "initiated_through" => $data->initiated_through,
                "intiation_date" => $data->intiation_date,
                "stage" => $data->status,
                "date_open" => $data->created_at,
                "date_close" => $data->updated_at,
                "division_name" => Helpers::getDivisionName($data->division_id),
                "filter_date_opened" => Helpers::getdateFormat1($data->created_at),
                "filter_originator" => Helpers::getInitiatorName($data->initiator_id),
                "filter_due_date" => Helpers::getdateFormat($data->due_date),
            ]);
            
        }

        foreach ($stabilityData as $data) {
            $data->create = Carbon::parse($data->created_at)->format('d-M-Y h:i A');

            array_push($table, [
                "id" => $data->id,
                "parent" => $data->cc_id ? $data->cc_id : "-",
                "record" => $data->record,
                "due_date" => $data->due_date,
                "type" => "Stability Management",
                "parent_id" => $data->parent_id,
                "parent_type" => $data->parent_type,
                "division_id" => $data->division_id,
                "short_description" => $data->short_description ? $data->short_description : "-",
                "initiator_id" => $data->initiator_id,
                "initiated_through" => $data->initiated_through,
                "intiation_date" => $data->intiation_date,
                "stage" => $data->status,
                "date_open" => $data->created_at,
                "date_close" => $data->updated_at,
                "division_name" => Helpers::getDivisionName($data->division_id),
                "filter_date_opened" => Helpers::getdateFormat1($data->created_at),
                "filter_originator" => Helpers::getInitiatorName($data->initiator_id),
                "filter_due_date" => Helpers::getdateFormat($data->due_date),
            ]);
            
        }

        // foreach ($datasIM as $data) {
        //     $data->create = Carbon::parse($data->created_at)->format('d-M-Y h:i A');

        //     array_push($table, [
        //         "id" => $data->id,
        //         "parent" => $data->cc_id ? $data->cc_id : "-",
        //         // "parent" => $data->parent_record ? $data->parent_record : "-",
        //         "record" => $data->record,
        //         "due_date" => $data->due_date,
        //         "type" => "Inventory Management",
        //         "parent_id" => $data->parent_id,
        //         "parent_type" => $data->parent_type,
        //         "division_id" => $data->division_id,
        //         "short_description" => $data->short_description ? $data->short_description : "-",
        //         "initiator_id" => $data->initiator_id,
        //         "initiated_through" => $data->initiated_through,
        //         "intiation_date" => $data->intiation_date,
        //         "stage" => $data->status,
        //         "date_open" => $data->created_at,
        //         "date_close" => $data->updated_at,
        //         "division_name" => Helpers::getDivisionName($data->division_id),
        //         "filter_date_opened" => Helpers::getdateFormat1($data->created_at),
        //         "filter_originator" => Helpers::getInitiatorName($data->initiator_id),
        //         "filter_due_date" => Helpers::getdateFormat($data->due_date),
        //     ]);
        //     // dd($datasIM);
        // }

        foreach ($datasIM as $data) {
            $data->create = Carbon::parse($data->created_at)->format('d-M-Y h:i A');

            array_push($table, [
                "id" => $data->id,
                "parent" => $data->cc_id ? $data->cc_id : "-",
                // "parent" => $data->parent_record ? $data->parent_record : "-",
                "record" => $data->record,
                "due_date" => $data->due_date,
                "type" => "Inventory Management",
                "parent_id" => $data->parent_id,
                "parent_type" => $data->parent_type,
                "division_id" => $data->division_id,
                "short_description" => $data->short_description ? $data->short_description : "-",
                "initiator_id" => $data->initiator_id,
                "initiated_through" => $data->initiated_through,
                "intiation_date" => $data->intiation_date,
                "stage" => $data->status,
                "date_open" => $data->created_at,
                "date_close" => $data->updated_at,
                "division_name" => Helpers::getDivisionName($data->division_id),
                "filter_date_opened" => Helpers::getdateFormat1($data->created_at),
                "filter_originator" => Helpers::getInitiatorName($data->initiator_id),
                "filter_due_date" => Helpers::getdateFormat($data->due_date),
            ]);
        }

        foreach ($ControlSample as $data) {
            $data->create = Carbon::parse($data->created_at)->format('d-M-Y h:i A');

            array_push($table, [
                "id" => $data->id,
                "parent" => $data->cc_id ? $data->cc_id : "-",
                // "parent" => $data->parent_record ? $data->parent_record : "-",
                "record" => $data->record,
                "due_date" => $data->due_date,
                "type" => "ControlSample Details",
                "parent_id" => $data->parent_id,
                "parent_type" => $data->parent_type,
                "division_id" => $data->division_id,
                "short_description" => $data->short_description ? $data->short_description : "-",
                "initiator_id" => $data->initiator_id,
                "initiated_through" => $data->initiated_through,
                "intiation_date" => $data->intiation_date,
                "stage" => $data->status,
                "date_open" => $data->created_at,
                "date_close" => $data->updated_at,
                "division_name" => Helpers::getDivisionName($data->division_id),
                "filter_date_opened" => Helpers::getdateFormat1($data->created_at),
                "filter_originator" => Helpers::getInitiatorName($data->initiator_id),
                "filter_due_date" => Helpers::getdateFormat($data->due_date),
            ]);
        }
        foreach ($AnalyticsIM as $data) {
            $data->create = Carbon::parse($data->created_at)->format('d-M-Y h:i A');

            array_push($table, [
                "id" => $data->id,
                "parent" => $data->cc_id ? $data->cc_id : "-",
                // "parent" => $data->parent_record ? $data->parent_record : "-",
                "record" => $data->record,
                "due_date" => $data->due_date,
                "type" => "Analytics Qualification",
                "parent_id" => $data->parent_id,
                "parent_type" => $data->parent_type,
                "division_id" => $data->division_id,
                "short_description" => $data->short_description ? $data->short_description : "-",
                "initiator_id" => $data->initiator_id,
                "initiated_through" => $data->initiated_through,
                "intiation_date" => $data->intiation_date,
                "stage" => $data->status,
                "date_open" => $data->created_at,
                "date_close" => $data->updated_at,
                "division_name" => Helpers::getDivisionName($data->division_id),
                "filter_date_opened" => Helpers::getdateFormat1($data->created_at),
                "filter_originator" => Helpers::getInitiatorName($data->initiator_id),
                "filter_due_date" => Helpers::getdateFormat($data->due_date),
            ]);
        }
        $table  = collect($table)->sortBy('record')->reverse()->toArray();

        if ($request->input('export') === 'pdf') {
            $pdf = App::make('dompdf.wrapper');
    
            $pdf = PDF::loadView('frontend.dashboard.dashboard-pdf', compact('table'))
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
    
            $canvas->page_text(
                $width / 4,
                $height / 2,
                "",
                null,
                25,
                [0, 0, 0],
                2,
                6,
                -20
            );
    
            return $pdf->download('Dashboard-Data.pdf');
        }

        $datag = $this->paginate($table);
        $uniqueProcessNames = QMSProcess::select('process_name')->distinct()->pluck('process_name');

        if ($request->ajax()) {
            return response()->json(['data' => $datag->items()]);
        }

        return view('frontend.lims-dashboard.dashboard', compact('datag', 'uniqueProcessNames'));
    }

    public function dashboard_child($id, $process)
    {
        $table = [];
        if ($process == 1) {
            $datas1 = ActionItem::where('cc_id', $id)->orderByDesc('id')->get();
            $datas2 = Extension::where('cc_id', $id)->orderByDesc('id')->get();
            foreach ($datas1 as $data) {
                array_push($table, [
                    "id" => $data->id,
                    "parent" => $data->cc_id ? $data->cc_id : "-",
                    "record" => $data->record,
                    "type" => "Action Item",
                    "short_description" => $data->short_description ? $data->short_description : "-",
                    "initiator_id" => $data->initiator_id,
                    "intiation_date" => $data->intiation_date,
                    "stage" => $data->status,
                    "date_open" => $data->created_at,
                    "date_close" => $data->updated_at,
                ]);
            }

            foreach ($datas2 as $data) {
                array_push($table, [
                    "id" => $data->id,
                    "parent" => $data->cc_id ? $data->cc_id : "-",
                    "record" => $data->record,
                    "type" => "Extension",
                    "short_description" => $data->short_description ? $data->short_description : "-",
                    "initiator_id" => $data->initiator_id,
                    "intiation_date" => $data->intiation_date,
                    "stage" => $data->status,
                    "date_open" => $data->created_at,
                    "date_close" => $data->updated_at,
                ]);
            }
        } else {
            if ($process == 2) {
                $ab = ActionItem::find($id);
                $data = CC::where('id', $ab->cc_id)->orderByDesc('id')->first();
                $datas1 = ActionItem::where('cc_id', $ab->cc_id)->orderByDesc('id')->get();
                $datas2 = Extension::where('cc_id', $ab->cc_id)->orderByDesc('id')->get();
                foreach ($data as $datas) {
                    array_push($table, [
                        "id" => $data->id,
                        "parent" => $data->cc_id ? $data->cc_id : "-",
                        "record" => $data->record,
                        "type" => "Change-Control",
                        "short_description" => $data->short_description ? $data->short_description : "-",
                        "initiator_id" => $data->initiator_id,
                        "intiation_date" => $data->intiation_date,
                        "stage" => $data->status,
                        "date_open" => $data->created_at,
                        "date_close" => $data->updated_at,
                    ]);
                }

                foreach ($datas1 as $data) {
                    array_push($table, [
                        "id" => $data->id,
                        "parent" => $data->cc_id ? $data->cc_id : "-",
                        "record" => $data->record,
                        "type" => "Action Item",
                        "short_description" => $data->short_description ? $data->short_description : "-",
                        "initiator_id" => $data->initiator_id,
                        "intiation_date" => $data->intiation_date,
                        "stage" => $data->status,
                        "date_open" => $data->created_at,
                        "date_close" => $data->updated_at,
                    ]);
                }

                foreach ($datas2 as $data) {
                    array_push($table, [
                        "id" => $data->id,
                        "parent" => $data->cc_id ? $data->cc_id : "-",
                        "record" => $data->record,
                        "type" => "Extension",
                        "short_description" => $data->short_description ? $data->short_description : "-",
                        "initiator_id" => $data->initiator_id,
                        "intiation_date" => $data->intiation_date,
                        "stage" => $data->status,
                        "date_open" => $data->created_at,
                        "date_close" => $data->updated_at,
                    ]);
                }
            } elseif ($process == 3) {
                $ab = Extension::find($id);
                $data = CC::where('id', $ab->cc_id)->orderByDesc('id')->first();
                $datas1 = ActionItem::where('cc_id', $ab->cc_id)->orderByDesc('id')->get();
                $datas2 = Extension::where('cc_id', $ab->cc_id)->orderByDesc('id')->get();
                foreach ($data as $datas) {
                    array_push($table, [
                        "id" => $data->id,
                        "parent"            => $data->cc_id ? $data->cc_id : "-",
                        "record"            => $data->record,
                        "type"              => "Change-Control",
                        "short_description" => $data->short_description ? $data->short_description : "-",
                        "initiator_id"      => $data->initiator_id,
                        "intiation_date"    => $data->intiation_date,
                        "stage"             => $data->status,
                        "date_open"         => $data->created_at,
                        "date_close"        => $data->updated_at,
                    ]);
                }

                foreach ($datas1 as $data) {
                    array_push($table, [
                        "id" => $data->id,
                        "parent"            => $data->cc_id ? $data->cc_id : "-",
                        "record"            => $data->record,
                        "type"              => "Action Item",
                        "short_description" => $data->short_description ? $data->short_description : "-",
                        "initiator_id"      => $data->initiator_id,
                        "intiation_date"    => $data->intiation_date,
                        "stage"             => $data->status,
                        "date_open"         => $data->created_at,
                        "date_close"        => $data->updated_at,
                    ]);
                }

                foreach ($datas2 as $data) {
                    array_push($table, [
                        "id" => $data->id,
                        "parent"            => $data->cc_id ? $data->cc_id : "-",
                        "record"            => $data->record,
                        "type"              => "Extension",
                        "short_description" => $data->short_description ? $data->short_description : "-",
                        "initiator_id"      => $data->initiator_id,
                        "intiation_date"    => $data->intiation_date,
                        "stage"             => $data->status,
                        "date_open"         => $data->created_at,
                        "date_close"        => $data->updated_at,
                    ]);
                }
            }
        }
        $table = collect($table)->sortBy('date_open')->reverse()->toArray();
        $datag = json_encode($table);
        return view('frontend.rcms.dashboard', compact('datag'));
    }
    public function dashboard_child_new($id, $process)
    {
        $table = [];

        if ($process == "extension") {

            $data = Extension::where('id', $id)->orderByDesc('id')->first();

            if ($data->parent_type == "Capa") {
                $data2 = Capa::where('id', $data->parent_id)->first();
                $data2->create = Carbon::parse($data2->created_at)->format('d-M-Y h:i A');
                array_push(
                    $table,
                    [
                        "id" => $data2->id,
                        "parent" => $data2->parent_record ? $data2->parent_record : "-",
                        "record" => $data2->record,
                        "type" => "Capa",
                        "parent_id" => $data2->parent_id,
                        "parent_type" => $data2->parent_type,
                        "division_id" => $data2->division_id,
                        "short_description" => $data2->short_description ? $data2->short_description : "-",
                        "initiator_id" => $data->initiator_id,
                        "intiation_date" => $data2->intiation_date,
                        "stage" => $data2->status,
                        "date_open" => $data2->create,
                        "date_close" => $data2->updated_at,
                    ]
                );
            }
            if ($data->parent_type == "Internal_audit") {
                $data2 = InternalAudit::where('id', $data->parent_id)->first();
                $data2->create = Carbon::parse($data2->created_at)->format('d-M-Y h:i A');
                array_push(
                    $table,
                    [
                        "id" => $data2->id,
                        "parent" => $data2->parent_record ? $data2->parent_record : "-",
                        "record" => $data2->record,
                        "type" => "Internal-Audit",
                        "parent_id" => $data2->parent_id,
                        "parent_type" => $data2->parent_type,
                        "division_id" => $data2->division_id,
                        "short_description" => $data2->short_description ? $data2->short_description : "-",
                        "initiator_id" => $data->initiator_id,
                        "intiation_date" => $data2->intiation_date,
                        "stage" => $data2->status,
                        "date_open" => $data2->create,
                        "date_close" => $data2->updated_at,
                    ]
                );
            }
            if ($data->parent_type == "External_audit") {
                $data2 = Auditee::where('id', $data->parent_id)->first();
                $data2->create = Carbon::parse($data2->created_at)->format('d-M-Y h:i A');
                array_push(
                    $table,
                    [
                        "id" => $data2->id,
                        "parent" => $data2->parent_record ? $data2->parent_record : "-",
                        "record" => $data2->record,
                        "type" => "External Audit",
                        "parent_id" => $data2->parent_id,
                        "parent_type" => $data2->parent_type,
                        "division_id" => $data2->division_id,
                        "short_description" => $data2->short_description ? $data2->short_description : "-",
                        "initiator_id" => $data->initiator_id,
                        "intiation_date" => $data2->intiation_date,
                        "stage" => $data2->status,
                        "date_open" => $data2->create,
                        "date_close" => $data2->updated_at,
                    ]
                );
            }
            if ($data->parent_type == "Action_item") {
                $data2 = ActionItem::where('id', $data->parent_id)->first();
                $data2->create = Carbon::parse($data2->created_at)->format('d-M-Y h:i A');
                array_push(
                    $table,
                    [
                        "id" => $data2->id,
                        "parent" => $data2->parent_record ? $data2->parent_record : "-",
                        "record" => $data2->record,
                        "type" => "Action Item",
                        "parent_id" => $data2->parent_id,
                        "parent_type" => $data2->parent_type,
                        "division_id" => $data2->division_id,
                        "short_description" => $data2->short_description ? $data2->short_description : "-",
                        "initiator_id" => $data->initiator_id,
                        "intiation_date" => $data2->intiation_date,
                        "stage" => $data2->status,
                        "date_open" => $data2->create,
                        "date_close" => $data2->updated_at,
                    ]
                );
            }
            if ($data->parent_type == "Audit_program") {
                $data2 = AuditProgram::where('id', $data->parent_id)->first();
                $data2->create = Carbon::parse($data2->created_at)->format('d-M-Y h:i A');
                array_push(
                    $table,
                    [
                        "id" => $data2->id,
                        "parent" => $data2->parent_record ? $data2->parent_record : "-",
                        "record" => $data2->record,
                        "type" => "Audit-Program",
                        "parent_id" => $data2->parent_id,
                        "parent_type" => $data2->parent_type,
                        "division_id" => $data2->division_id,
                        "short_description" => $data2->short_description ? $data2->short_description : "-",
                        "initiator_id" => $data->initiator_id,
                        "intiation_date" => $data2->intiation_date,
                        "stage" => $data2->status,
                        "date_open" => $data2->create,
                        "date_close" => $data2->updated_at,
                    ]
                );
            }
            if ($data->parent_type == "Observation") {
                $data2 = Observation::where('id', $data->parent_id)->first();
                $data2->create = Carbon::parse($data2->created_at)->format('d-M-Y h:i A');
                array_push(
                    $table,
                    [
                        "id" => $data2->id,
                        "parent" => $data2->parent_record ? $data2->parent_record : "-",
                        "record" => $data2->record,
                        "type" => "Observation",
                        "parent_id" => $data2->parent_id,
                        "parent_type" => $data2->parent_type,
                        "division_id" => $data2->division_id,
                        "short_description" => $data2->short_description ? $data2->short_description : "-",
                        "initiator_id" => $data->initiator_id,
                        "intiation_date" => $data2->intiation_date,
                        "stage" => $data2->status,
                        "date_open" => $data2->create,
                        "date_close" => $data2->updated_at,
                    ]
                );
            }
            if ($data->parent_type == "Change_control") {
                $data2 = CC::where('id', $data->parent_id)->first();
                $data2->create = Carbon::parse($data2->created_at)->format('d-M-Y h:i A');
                array_push(
                    $table,
                    [
                        "id" => $data2->id,
                        "parent" => $data2->parent_record ? $data2->parent_record : "-",
                        "record" => $data2->record,
                        "type" => "Change-Control",
                        "parent_id" => $data2->parent_id,
                        "parent_type" => $data2->parent_type,
                        "division_id" => $data2->division_id,
                        "short_description" => $data2->short_description ? $data2->short_description : "-",
                        "initiator_id" => $data->initiator_id,
                        "intiation_date" => $data2->intiation_date,
                        "stage" => $data2->status,
                        "date_open" => $data2->create,
                        "date_close" => $data2->updated_at,
                    ]
                );
            }
            if ($data->parent_type == "ERRATA") {
                $data2 = Errata::where('id', $data->parent_id)->first();
                $data2->create = Carbon::parse($data2->created_at)->format('d-M-Y h:i A');
                array_push(
                    $table,
                    [
                        "id" => $data2->id,
                        "parent" => $data2->parent_record ? $data2->parent_record : "-",
                        "record" => $data2->record,
                        "type" => "ERRATA",
                        "parent_id" => $data2->parent_id,
                        "parent_type" => $data2->parent_type,
                        "division_id" => $data2->division_id,
                        "short_description" => $data2->short_description ? $data2->short_description : "-",
                        "initiator_id" => $data->initiator_id,
                        "intiation_date" => $data2->intiation_date,
                        "stage" => $data2->status,
                        "date_open" => $data2->create,
                        "date_close" => $data2->updated_at,
                    ]
                );
            }
            if ($data->parent_type == "Sample Management II") {
                $data2 = SamplePlanning::where('id', $data->parent_id)->first();
                $data2->create = Carbon::parse($data2->created_at)->format('d-M-Y h:i A');
                array_push(
                    $table,
                    [
                        "id" => $data2->id,
                        "parent" => $data2->parent_record ? $data2->parent_record : "-",
                        "record" => $data2->record,
                        "type" => "Sample Management II",
                        "parent_id" => $data2->parent_id,
                        "parent_type" => $data2->parent_type,
                        "division_id" => $data2->division_id,
                        "short_description" => $data2->short_description ? $data2->short_description : "-",
                        "initiator_id" => $data->initiator_id,
                        "intiation_date" => $data2->intiation_date,
                        "stage" => $data2->status,
                        "date_open" => $data2->create,
                        "date_close" => $data2->updated_at,
                    ]
                );
            }
        } else {
            return redirect(url('rcms/qms-dashboard'));
        }

        $table  = collect($table)->sortBy('record')->reverse()->toArray();
        $datag = $this->paginate($table);



        // return redirect(url('rcms/qms-dashboard'));
        return view('frontend.rcms.dashboard', compact('datag'));
    }

    public function limsRecordModal($id, $type)
    {

        $division_name = "NA";

        if ($type == "Sample Management I") {
            $data = Receipt::find($id);
            $single = route('ReceiptSingleReport',['id'=> $data->id]);
            $family = "#";
            $audit = route('ReceiptAuditReport',['id'=> $data->id]);
            // $division = QMSDivision::find($data->division_id);
            // $division_name = $division->name;
        }
        elseif ($type == "Sample Management II") {
            $data = SamplePlanning::find($id);
            $single = route('sample-planning-single-report', ['id' => $data->id]);
            $family = "#";
            $audit = route('sample-planning-audit-report',['id'=> $data->id]);
            $division = QMSDivision::find($data->division_id);
            $division_name = $division->name;
        }
        elseif ($type == "ControlSample Details") {
            $data = ControlSample::find($id);
            $single = route('controlSample_singleReport', ['id' => $data->id]);
            $family = "#";
            $audit = route('controlSample_auditReport',['id'=> $data->id]);
            $division = QMSDivision::find($data->division_id);
            $division_name = $division->name;
        }
        elseif ($type == "Inventory Management") {
            $data =InventoryManagement::find($id);
            $single = route('inventory_singlereport', ['id' => $data->id]);
            $family = "#";
            $audit = route('inventory_auditreport',['id'=> $data->id]);
            $division = QMSDivision::find($data->division_id);
            $division_name = $division->name;
        }
        elseif ($type == "Stability Management") {
            $data = SampleStability::find($id);
            $single = route('stability-management-single-report', ['id' => $data->id]);
            $family = "#";
            $audit = route('stability-management-audit-report',['id'=> $data->id]);
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
                            <a target="__blank" href="' . $audit . '" class="inner-item">Audit Trail Report</a>
                            <a target="__blank" href="' . $single . '" class="inner-item">' . $type . ' Single Report</a>
                            <a target="__blank" href="' . $family . '" class="inner-item">' . $type . ' Family Report</a>
                        </div>
                    </div>
                </div>
            </div>';
        $response['html'] = $html;

        return response()->json($response);
    }

    public function paginate($items, $perPage = 100000, $page = null, $options = ['path' => 'mytaskdata'])
    {
        $page = $page ?: (LengthAwarePaginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof \Illuminate\Support\Collection ? $items : collect($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
