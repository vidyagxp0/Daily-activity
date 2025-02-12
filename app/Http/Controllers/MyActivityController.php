<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Document;
use App\Models\DocumentType;
use App\Models\DocumentHistory;
use App\Models\Department;
use App\Models\StageManage;
use App\Models\{RoleGroup,
ActionItem,
extension_new,
EffectivenessCheck,
InternalAudit,
Capa,
RiskManagement
};
use App\Models\OOS;
use App\Models\errata;
use App\Models\MarketComplaint;
use App\Models\OOS_micro;
use App\Models\User;
use App\Models\CC;
use App\Models\QMSProcess;
use App\Models\Extension;
use App\Models\ManagementReview;
use App\Models\OutOfCalibration;
use App\Models\LabIncident;
use App\Models\Auditee;
use App\Models\NonConformance;
use App\Models\AuditProgram;
use App\Models\{Division,Deviation, Incident};
use App\Models\RootCauseAnalysis;
use App\Models\Observation;
use App\Models\QMSDivision;
use App\Models\FailureInvestigation;
use App\Models\Ootc;
use App\Models\RecordNumber;
use App\Models\Grouppermission;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\Paginator as PaginationPaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Helpers;
use Carbon\Carbon;

class MyActivityController extends Controller
{
    public function index()
    {
        $now = Carbon::now();
        $recentRecord = $now->subHours(24);
        $table = [];

        $datas = CC::where('created_at', '>=', $recentRecord)->orderByDesc('id')->get();
        $datas1 = ActionItem::where('created_at', '>=', $recentRecord)->orderByDesc('id')->get();
        $datas2 = extension_new::where('created_at', '>=', $recentRecord)->orderByDesc('id')->get();
        $datas3 = EffectivenessCheck::where('created_at', '>=', $recentRecord)->orderByDesc('id')->get();
        $datas4 = InternalAudit::where('created_at', '>=', $recentRecord)->orderByDesc('id')->get();
        $datas5 = Capa::where('created_at', '>=', $recentRecord)->orderByDesc('id')->get();
        $datas6 = RiskManagement::where('created_at', '>=', $recentRecord)->orderByDesc('id')->get();
        $datas7 = ManagementReview::where('created_at', '>=', $recentRecord)->orderByDesc('id')->get();
        $datas8 = LabIncident::where('created_at', '>=', $recentRecord)->orderByDesc('id')->get();
        $datas9 = Auditee::where('created_at', '>=', $recentRecord)->orderByDesc('id')->get();
        $datas10 = AuditProgram::where('created_at', '>=', $recentRecord)->orderByDesc('id')->get();
        $datas11 = RootCauseAnalysis::where('created_at', '>=', $recentRecord)->orderByDesc('id')->get();
        $datas12 = Observation::where('created_at', '>=', $recentRecord)->orderByDesc('id')->get();
        $datas13 = OOS::where('created_at', '>=', $recentRecord)->orderByDesc('id')->get();
        $datas14 = MarketComplaint::where('created_at', '>=', $recentRecord)->orderByDesc('id')->get();
        $deviation = Deviation::where('created_at', '>=', $recentRecord)->orderByDesc('id')->get();
        $ooc = OutOfCalibration::where('created_at', '>=', $recentRecord)->orderByDesc('id')->get();
        $failureInvestigation = FailureInvestigation::where('created_at', '>=', $recentRecord)->orderByDesc('id')->get();
        $datas15 = Ootc::where('created_at', '>=', $recentRecord)->orderByDesc('id')->get();
        $datas16 = errata::where('created_at', '>=', $recentRecord)->orderByDesc('id')->get();
        $datas17 = OOS_micro::where('created_at', '>=', $recentRecord)->orderByDesc('id')->get();
        $datas25 = NonConformance::where('created_at', '>=', $recentRecord)->orderByDesc('id')->get();
        $incident = Incident::where('created_at', '>=', $recentRecord)->orderByDesc('id')->get();

        foreach ($datas as $data) {
            $data->create = Carbon::parse($data->created_at)->format('d-M-Y h:i A');

            array_push($table, [
                "id" => $data->id,
                "parent" => $data->cc_id ? $data->cc_id : "-",
                // "parent" => $data->parent_record ? $data->parent_record : "-",
                "record" => $data->record,
                "due_date" => $data->due_date,
                "type" => "Change-Control",
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
            ]);
        }

        foreach ($datas1 as $data) {
            $data->create = Carbon::parse($data->created_at)->format('d-M-Y h:i A');

            array_push($table, [
                "id" => $data->id,
                "parent" => $data->cc_id ? $data->cc_id : "-",
                "record" => $data->record,
                "type" => "Action-Item",
                "due_date" => $data->due_date,
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
            ]);
        }
        foreach ($datas2 as $data) {
            $data->create = Carbon::parse($data->created_at)->format('d-M-Y h:i A');
            // dd($data);
            array_push($table, [
                "id" => $data->id,
                "parent" => $data->cc_id ? $data->cc_id : "-",
                "record" => $data->record_number,
                "type" => "Extension",
                "parent_id" => $data->parent_id,
                "parent_type" => $data->parent_type,
                "division_id" => $data->site_location_code,
                "short_description" => $data->short_description ? $data->short_description : "-",
                "initiator_id" => $data->initiator,
                "initiated_through" => $data->initiated_through,
                "intiation_date" => $data->intiation_date,
                "stage" => $data->status,
                "date_open" => $data->created_at,
                "due_date" => $data->due_date,
                "date_close" => $data->updated_at,
            ]);
        }
        foreach ($datas3 as $data) {
            $data->create = Carbon::parse($data->created_at)->format('d-M-Y h:i A');

            array_push($table, [
                "id" => $data->id,
                "parent" => $data->parent_record ? $data->parent_record : "-",
                "record" => $data->record,
                "type" => "Effectiveness-Check",
                "parent_id" => $data->parent_record,
                "parent_type" => $data->parent_type,
                "division_id" => $data->division_id,
                "short_description" => $data->short_description ? $data->short_description : "-",
                "initiator_id" => $data->initiator_id,
                "initiated_through" => $data->initiated_through,
                "intiation_date" => $data->intiation_date,
                "stage" => $data->status,
                "date_open" => $data->created_at,
                "date_close" => $data->updated_at,
                "due_date" => $data->due_date,
            ]);
        }
        foreach ($datas4 as $data) {
            $data->create = Carbon::parse($data->created_at)->format('d-M-Y h:i A');

            array_push($table, [
                "id" => $data->id,
                "parent" => $data->parent_record ? $data->parent_record : "-",
                "record" => $data->record,
                "type" => "Internal-Audit",
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
                "due_date" => $data->due_date,
            ]);
        }
        foreach ($datas5 as $data) {
            $data->create = Carbon::parse($data->created_at)->format('d-M-Y h:i A');
            $revised_date = Extension::where('parent_id', $data->id)->where('parent_type', "Capa")->value('revised_date');

            array_push($table, [
                "id" => $data->id,
                "parent" => $data->parent_record ? $data->parent_record : "-",
                "record" => $data->record,
                "type" => "Capa",
                "parent_id" => $data->parent_id,
                "parent_type" => $data->parent_type,
                "division_id" => $data->division_id,
                "short_description" => $data->short_description ? $data->short_description : "-",
                "initiator_id" => $data->initiator_id,
                "initiated_through" => $data->initiated_through,
                "intiation_date" => $revised_date ? $revised_date : $data->intiation_date,
                "stage" => $data->status,
                "date_open" => $data->created_at,
                "date_close" => $data->updated_at,
                "due_date" => $data->due_date,
            ]);
        }
        foreach ($datas6 as $data) {
            $data->create = Carbon::parse($data->created_at)->format('d-M-Y h:i A');

            array_push($table, [
                "id" => $data->id,
                "parent" => $data->parent_record ? $data->parent_record : "-",
                "record" => $data->record,
                "type" => "Risk-Assesment",
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
                "due_date" => $data->due_date,
            ]);
        }
        foreach ($datas7 as $data) {
            $data->create = Carbon::parse($data->created_at)->format('d-M-Y h:i A');

            array_push($table, [
                "id" => $data->id,
                "parent" => $data->parent_record ? $data->parent_record : "-",
                "record" => $data->record,
                "type" => "Management-Review",
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
                "due_date" => $data->due_date,
            ]);
        }
        foreach ($datas8 as $data) {
            $data->create = Carbon::parse($data->created_at)->format('d-M-Y h:i A');
            array_push($table, [
                "id" => $data->id,
                "parent" => $data->parent_record ? $data->parent_record : "-",
                "record" => $data->record,
                "type" => "Lab-Incident",
                "parent_id" => $data->parent_id,
                "parent_type" => $data->parent_type,
                "division_id" => $data->division_id,
                "short_description" => $data->short_desc ? $data->short_desc : "-",
                "initiator_id" => $data->initiator_id,
                "initiated_through" => $data->initiated_through,
                "intiation_date" => $data->intiation_date,
                "stage" => $data->status,
                "date_open" => $data->created_at,
                "date_close" => $data->updated_at,
                "due_date" => $data->due_date,
            ]);
        }
        foreach ($datas9 as $data) {
            $data->create = Carbon::parse($data->created_at)->format('d-M-Y h:i A');

            array_push($table, [
                "id" => $data->id,
                "parent" => $data->parent_record ? $data->parent_record : "-",
                "record" => $data->record,
                "type" => "External-Audit",
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
                "due_date" => $data->due_date,
            ]);
        }
        foreach ($datas10 as $data) {
            $data->create = Carbon::parse($data->created_at)->format('d-M-Y h:i A');

            array_push($table, [
                "id" => $data->id,
                "parent" => $data->parent_record ? $data->parent_record : "-",
                "record" => $data->record,
                "type" => "Audit-Program",
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
                "due_date" => $data->due_date,
            ]);
        }
        foreach ($datas11 as $data) {
            $data->create = Carbon::parse($data->created_at)->format('d-M-Y h:i A');

            array_push($table, [
                "id" => $data->id,
                "parent" => $data->parent_record ? $data->parent_record : "-",
                "record" => $data->record,
                "due_date" => $data->due_date,
                "division_id" => $data->division_id,
                "type" => "Root-Cause-Analysis",
                "parent_id" => $data->parent_id,
                "parent_type" => $data->parent_type,
                "short_description" => $data->short_description ? $data->short_description : "-",
                "initiator_id" => $data->initiator_id,
                "initiated_through" => $data->initiated_through,
                "intiation_date" => $data->intiation_date,
                "stage" => $data->status,
                "date_open" => $data->created_at,
                "date_close" => $data->updated_at,
            ]);
        }
        foreach ($datas12 as $data) {
            $data->create = Carbon::parse($data->created_at)->format('d-M-Y h:i A');
            array_push($table, [
                "id" => $data->id,
                "parent" => $data->parent_record ? $data->parent_record : "-",
                "record" => $data->record,
                "division_id" => $data->division_code,
                "type" => "Observation",
                "parent_id" => $data->parent_id,
                "parent_type" => $data->parent_type,
                "short_description" => $data->short_description ? $data->short_description : "-",
                "initiator_id" => $data->initiator_id,
                "initiated_through" => $data->initiated_through,
                "intiation_date" => $data->intiation_date,
                "stage" => $data->status,
                "date_open" => $data->created_at,
                "date_close" => $data->updated_at,
                "due_date" => $data->due_date,

            ]);
        }
        foreach ($datas13 as $data) {
            $data->create = Carbon::parse($data->created_at)->format('d-M-Y h:i A');
            array_push($table, [
                "id" => $data->id,
                "parent" => $data->parent_record ? $data->parent_record : "-",
                "record" => $data->record,
                "division_id" => $data->division_id,
                "type" => "OOS Chemical",
                "parent_id" => $data->parent_id,
                "parent_type" => $data->parent_type,
                "short_description" => $data->description_gi ? $data->description_gi : "-",
                "initiator_id" => $data->initiator_id,
                "initiated_through" => $data->initiated_through_gi,
                "intiation_date" => $data->intiation_date,
                "stage" => $data->status,
                "date_open" => $data->created_at,
                "date_close" => $data->updated_at,
                "due_date" => $data->due_date,
            ]);
        }
        foreach ($datas14 as $data) {
            $data->create = Carbon::parse($data->created_at)->format('d-M-Y h:i A');
            array_push($table, [
                "id" => $data->id,
                "parent" => $data->parent_record ? $data->parent_record : "-",
                "record" => $data->record,
                "due_date" => $data->due_date_gi,
                "division_id" => $data->division_id,
                "type" => "Market Complaint",
                "parent_id" => $data->parent_id,
                "parent_type" => $data->parent_type,
                "short_description" => $data->description_gi ? $data->description_gi : "-",
                "initiator_id" => $data->initiator_id,
                "initiated_through" => $data->initiated_through_gi,
                "intiation_date" => $data->intiation_date,
                "stage" => $data->status,
                "date_open" => $data->created_at,
                "date_close" => $data->updated_at,
            ]);
        }
        foreach ($datas15 as $data) {
            $data->create = Carbon::parse($data->created_at)->format('d-M-Y h:i A');
            array_push($table, [
                "id" => $data->id,
                "parent" => $data->parent_record ? $data->parent_record : "-",
                "record" => $data->record_number,
                "division_id" => $data->division_id,
                "type" => "OOT",
                "parent_id" => $data->parent_id,
                "parent_type" => $data->parent_type,
                "short_description" => $data->short_description ? $data->short_description : "-",
                "initiator_id" => $data->initiator_id,
                "due_date" => $data->due_date,
                "stage" => $data->status,
                "date_open" => $data->created_at,
                "initiated_through" => $data->initiated_through? $data->initiated_through : "-",
                "date_close" => $data->updated_at,
            ]);
        }
        foreach ($datas16 as $data) {
            $data->create = Carbon::parse($data->created_at)->format('d-M-Y h:i A');
            array_push($table, [
                "id" => $data->id,
                "parent" => $data->parent_record ? $data->parent_record : "-",
                "record" => $data->record,
                "division_id" => $data->division_id,
                "type" => "ERRATA",
                "parent_id" => $data->parent_id,
                "parent_type" => $data->parent_type,
                "short_description" => $data->short_description ? $data->short_description : "-",
                "initiator_id" => $data->initiator_id,
                "initiated_through" => $data->initiated_by,
                "intiation_date" => $data->intiation_date,
                "stage" => $data->status,
                "due_date" => $data->due_date,
                "date_open" => $data->created_at,
                "date_close" => $data->updated_at,
            ]);
        }
         foreach ($datas17 as $data) {
            $data->create = Carbon::parse($data->created_at)->format('d-M-Y h:i A');
            array_push($table, [
                "id" => $data->id,
                "parent" => $data->parent_record ? $data->parent_record : "-",
                "record" => $data->record,
                "division_id" => $data->division_id,
                "type" => "OOS Microbiology",
                "parent_id" => $data->parent_id,
                "parent_type" => $data->parent_type,
                "short_description" => $data->description_gi ? $data->description_gi : "-",
                "initiator_id" => $data->initiator_id,
                "initiated_through" => $data->initiated_through_gi,
                "intiation_date" => $data->intiation_date,
                "stage" => $data->status,
                "date_open" => $data->created_at,
                "date_close" => $data->updated_at,
                "due_date" => $data->due_date,
            ]);
        }
        foreach ($deviation as $data) {
            $data->create = Carbon::parse($data->created_at)->format('d-M-Y h:i A');
            array_push($table, [
                "id" => $data->id,
                "parent" => $data->parent_record ? $data->parent_record : "-",
                "record" => $data->record,
                "division_id" => $data->division_id,
                "type" => "Deviation",
                "parent_id" => $data->parent_id,
                "parent_type" => $data->parent_type,
                "short_description" => $data->short_description ? $data->short_description : "-",
                "initiator_id" => $data->initiator_id,
                "intiation_date" => $data->intiation_date,
                "stage" => $data->status,
                "initiated_through" => $data->initiated_through,
                "date_open" => $data->created_at,
                "date_close" => $data->updated_at,
                "due_date" => $data->due_date,
            ]);
        }
        foreach ($ooc as $data) {
            $data->create = Carbon::parse($data->created_at)->format('d-M-Y h:i A');
            array_push($table, [
                "id" => $data->id,
                "due_date" => $data->due_date,
                "parent" => $data->parent_record ? $data->parent_record : "-",
                "record" => $data->record,
                "type" => "Out Of Calibration",
                "parent_id" => $data->parent_id,
                "parent_type" => $data->parent_type,
                "division_id" => $data->division_id,
                "short_description" => $data->description_ooc ? $data->description_ooc : "-",
                "initiator_id" => $data->initiator_id,
                "initiated_through" => $data->initiated_through_gi,
                "intiation_date" => $data->intiation_date,
                "stage" => $data->status,
                "date_open" => $data->created_at,
                "date_close" => $data->updated_at,
            ]);
        }
        foreach ($failureInvestigation as $data) {
            $data->create = Carbon::parse($data->created_at)->format('d-M-Y h:i A');

            array_push($table, [
                "id" => $data->id,
                "parent" => $data->cc_id ? $data->cc_id : "-",
                "record" => $data->record,
                "type" => "Failure Investigation",
                "parent_id" => $data->parent_id,
                "parent_type" => $data->parent_type,
                "division_id" => $data->division_id,
                "short_description" => $data->short_description ? $data->short_description : "-",
                "initiator_id" => $data->initiator_id,
                "initiated_through" => $data->initiated_through,
                "intiation_date" => $data->intiation_date,
                "stage" => $data->status,
                "date_open" => $data->created_at,
                "due_date" => $data->due_date,
                "date_close" => $data->updated_at,
            ]);
        }
        foreach ($datas25 as $data) {
            $data->create = Carbon::parse($data->created_at)->format('d-M-Y h:i A');
            array_push($table, [
                "id" => $data->id,
                "parent" => $data->cc_id ? $data->cc_id : "-",
                "record" => $data->record,
                "type" => "Non Conformance",
                "parent_id" => $data->parent_id,
                "parent_type" => $data->parent_type,
                "division_id" => $data->division_id,
                "short_description" => $data->short_description ? $data->short_description : "-",
                "initiator_id" => $data->initiator_id,
                "initiated_through" => $data->initiated_through,
                "intiation_date" => $data->intiation_date,
                "stage" => $data->status,
                "date_open" => $data->created_at,
                "due_date" => $data->due_date,
                "date_close" => $data->updated_at,
            ]);
        }
        foreach ($incident as $data) {
            $data->create = Carbon::parse($data->created_at)->format('d-M-Y h:i A');
            array_push($table, [
                "id" => $data->id,
                "parent" => $data->cc_id ? $data->cc_id : "-",
                "record" => $data->record,
                "type" => "Incident",
                "parent_id" => $data->parent_id,
                "parent_type" => $data->parent_type,
                "division_id" => $data->division_id,
                "short_description" => $data->short_description ? $data->short_description : "-",
                "initiator_id" => $data->initiator_id,
                "initiated_through" => $data->initiated_through,
                "intiation_date" => $data->intiation_date,
                "stage" => $data->status,
                "date_open" => $data->created_at,
                "due_date" => $data->due_date,
                "date_close" => $data->updated_at,
            ]);
        }
        $table  = collect($table)->sortBy('record')->reverse()->toArray();
        $datag = $this->paginate($table);
        $uniqueProcessNames = QMSProcess::select('process_name')->distinct()->pluck('process_name');
        return view('frontend.myactivity', compact('datas', 'uniqueProcessNames', 'datag'));
    }


    public function reviewdetails($id)
    {

        $document = Document::find($id);
        $document->last_modify = DocumentHistory::where('document_id', $document->id)->latest()->first();
        $stagereview = StageManage::withoutTrashed()->where('user_id', Auth::user()->id)->where('document_id', $id)->where('stage', "Reviewed")->latest()->first();
        $stagereview_submit = StageManage::withoutTrashed()->where('user_id', Auth::user()->id)->where('document_id', $id)->where('stage', "Review-Submit")->latest()->first();
        
        $approverviews = StageManage::withoutTrashed()->where('user_id', Auth::user()->id)->where('document_id', $id)->where('stage', "Approved-temp")->latest()->first();
        $approverviews_submit = StageManage::withoutTrashed()->where('user_id', Auth::user()->id)->where('document_id', $id)->where('stage', "Approver accept with comment")->latest()->first();
        $stageapprove1 = StageManage::withoutTrashed()->where('user_id',Auth::user()->id)->where('document_id',$id)->where('stage',"Approver accept with comment")->latest()->first();
        
        $stagehod_submit = StageManage::withoutTrashed()->where('user_id',Auth::user()->id)->where('document_id',$id)->where('stage',"HOD Review-Submit")->latest()->first();
        $stagehod = StageManage::withoutTrashed()->where('user_id',Auth::user()->id)->where('document_id',$id)->where('stage',"HOD Review Complete")->latest()->first();
        
        $stageapprove = StageManage::withoutTrashed()->where('user_id',Auth::user()->id)->where('document_id',$id)->where('stage',"Approved")->latest()->first();
        $stageapprove_submit = StageManage::withoutTrashed()->where('user_id',Auth::user()->id)->where('document_id',$id)->where('stage',"Approval-Submit")->latest()->first();
       // $stageapprove = '';
    //    $stageapprove = StageManage::withoutTrashed()->where('user_id',Auth::user()->id)->where('document_id',$id)->where('stage',"Approval-Submit")->latest()->first();

        //$stageapprove_submit = '';
        $hod_reject = StageManage::withoutTrashed()->where('user_id', Auth::user()->id)->where('document_id', $id)->where('stage', "Cancel-by-HOD")->latest()->first();
        $review_reject = StageManage::withoutTrashed()->where('user_id', Auth::user()->id)->where('document_id', $id)->where('stage', "Cancel-by-Reviewer")->latest()->first();
        $approval_reject = StageManage::withoutTrashed()->where('user_id', Auth::user()->id)->where('document_id', $id)->where('stage', "Cancel-by-Approver")->latest()->first();
        $document->department_name = Department::find($document->department_id);
        $document->doc_type = DocumentType::find($document->document_type_id);
        $document->oreginator = User::find($document->originator_id);
        $reviewer = User::where('role', 2)->get();
        $approvers = User::where('role', 1)->get();
        $reviewergroup = Grouppermission::where('role_id', 2)->get();
        $approversgroup = Grouppermission::where('role_id', 1)->get();
        return view('frontend.documents.review-details', compact('document', 'reviewer', 'approvers', 'reviewergroup', 'approversgroup', 'stagereview', 'stagereview_submit', 'stageapprove', 'stageapprove_submit', 'review_reject', 'approval_reject', 'stagehod_submit', 'stagehod', 'hod_reject', 'approverviews', 'approverviews_submit', 'stageapprove1'));

    }

    public function paginate($items, $perPage = 10, $page = null, $options = ['path' => 'myactivity'])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
