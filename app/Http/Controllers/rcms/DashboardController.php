<?php

namespace App\Http\Controllers\rcms;

use App\Http\Controllers\Controller;
use App\Models\ActionItem;
use App\Models\Capa;
use App\Models\GlobalCapa;
use App\Models\PreventiveMaintenance;
use App\Models\EHSEvent;
use App\Models\RiskAssessment;
use App\Models\SampleStability;
use App\Models\Sanction;
use App\Models\QMSProcess;
use App\Models\EquipmentLifecycleManagement;
use App\Models\CC;
use App\Models\EffectivenessCheck;
use App\Models\Extension;
use App\Models\InternalAudit;
use App\Models\ManagementReview;
use App\Models\GlobalChangeControl;
use App\Models\OutOfCalibration;
use App\Models\RiskManagement;
use App\Models\LabIncident;
use App\Models\Supplier;
use App\Models\Auditee;
use App\Models\NonConformance;
use App\Models\AuditProgram;
use App\Models\{Division,Deviation, Document, extension_new, ExternalAudit, Incident, Meeting, OOT, SupplierAudit};
use App\Http\Controllers\EquipmentLifecycleManagementController;
use App\Models\RootCauseAnalysis;
use App\Models\Observation;
use App\Models\QMSDivision;
use App\Models\FailureInvestigation;
use App\Models\QueryManagement;
use App\Models\Ootc;
use App\Models\RecordNumber;
use Helpers;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use App\Models\OOS;
use App\Models\errata;

use App\Models\MarketComplaint;

use App\Models\OOS_micro;
use App\Models\CallibrationDetails;
use PDF;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\App;

use Illuminate\Support\Facades\DB;


class DashboardController extends Controller
{
    // public function index(){
    //     if(Helpers::checkRoles(3)){
    //         $data = CC::where('initiator_id',Auth::user()->id)->orderbyDESC('id')->get();
    //         $child = [];
    //         $childs = [];
    //         foreach($data as $datas){
    //             $datas->originator = User::where('id',$datas->initiator_id)->value('name');
    //             $datas->actionItem = ActionItem::where('cc_id',$datas->id)->get();
    //             $datas->extension = Extension::where('cc_id',$datas->id)->get();


    //         }


    //         return view('frontend.rcms.dashboard',compact('data'));
    //     }
    // }

    public function index(Request $request)
    {
        $loggedInUserId = auth()->id();
        $notificationTable = 'notification_users';

        $table = [];
        $filterType = $request->input('filterType', 'all');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $meetingQuery = Meeting::query();
        $datasQuery = CC::query(); 
        $globalCCQuery = GlobalChangeControl::query();  
        $datasQuery->whereExists(function ($query) use ($notificationTable, $loggedInUserId) {
            $query->select(DB::raw(1))
                ->from($notificationTable)
                ->whereRaw("$notificationTable.record_id = c_c_s.id")
                ->where("$notificationTable.to_id", $loggedInUserId)
                ->where("$notificationTable.record_type", "CC");
        });

        $supplierAuditQuery = SupplierAudit::query();
        $supplierQuery = Supplier::query();
        $datas1Query = ActionItem::query();
        $datas2Query = extension_new::query();
        $datas3Query = EffectivenessCheck::query();
        $datas4Query = InternalAudit::query();
        $datas5Query = Capa::query();
        $datas28Query = GlobalCapa::query();
        $equipmentQuery = EquipmentLifecycleManagement::query();
        // $sstability = SampleStability::query();

        $EHSQuery = EHSEvent::query();      
        $SanctionQuery = Sanction::query();      


        $datasPMQuery = PreventiveMaintenance::query();
        // $datasPMQuery->whereExists(function ($query) use ($notificationTable, $loggedInUserId) {
        //     $query->select(DB::raw(1))
        //         ->from($notificationTable)
        //         ->whereRaw("$notificationTable.record_id = preventive_maintenances.id")
        //         ->where("$notificationTable.to_id", $loggedInUserId)
        //         ->where("$notificationTable.record_type", "Preventive Maintenance");
        // });

        $datas6Query = RiskManagement::query();
        $datas7Query = ManagementReview::query();
        $datas8Query = LabIncident::query();
        $datas9Query = Auditee::query();
        $datas10Query = AuditProgram::query();
        $datas11Query = RootCauseAnalysis::query();
        $datas12Query = Observation::query();
        $datas13Query = OOS::query();
        $datas14Query = MarketComplaint::query();

        $deviationQuery = Deviation::query();
        $deviationQuery->whereExists(function ($query) use ($notificationTable, $loggedInUserId) {
            $query->select(DB::raw(1))
                ->from($notificationTable)
                ->whereRaw("$notificationTable.record_id = deviations.id")
                ->where("$notificationTable.to_id", $loggedInUserId)
                ->where("$notificationTable.record_type", "Deviation");
        });

        $oocQuery = OutOfCalibration::query();
        $failureInvestigationQuery = FailureInvestigation::query();
        $datas15Query = Ootc::query();
        $datas16Query = errata::query();
        $datas17Query = OOS_micro::query();
        $datas25Query = NonConformance::query();
        $incidentQuery = Incident::query();
        $queryManagementQuery = QueryManagement::query();
        $datasPMQuery = PreventiveMaintenance::query();
        $calibrationQuery = CallibrationDetails::query();

        $currentDate = Carbon::now();

        if ($filterType !== 'all' && $filterType !== '' && $filterType !== 'custom') {
            $datasQuery->whereNotIn('status', ['Closed Done']);
            $globalCCQuery->whereNotIn('status', ['Closed Done']);
            $datas1Query->whereNotIn('status', ['Closed - Done']);
            $supplierQuery->whereNotIn('status', ['Closed - Done']);
            $meetingQuery->whereNotIn('status', ['Closed - Done']);
            $supplierAuditQuery->whereNotIn('status', ['Closed - Done']);
            $datas2Query->whereNotIn('status', ['Closed - Done']);
            $datas3Query->whereNotIn('status', ['Closed - Effective']);
            $datas4Query->whereNotIn('status', ['Closed - Done']);
            $datas5Query->whereNotIn('status', ['Closed - Done']);
            $datas28Query->whereNotIn('status', ['Closed - Done']);
            $equipmentQuery->whereNotIn('status', ['Closed - Done']);
            $EHSQuery->whereNotIn('status', ['Closed - Done']);
            $SanctionQuery->whereNotIn('status', ['Closed - Done']);
            $datasPMQuery->whereNotIn('status', ['Closed - Done']);
            $datas6Query->whereNotIn('status', ['Closed - Done']);
            $datas7Query->whereNotIn('status', ['Closed - Done']);
            $datas8Query->whereNotIn('status', ['Closed-Done']);
            $datas9Query->whereNotIn('status', ['Closed - Done']);
            $datas10Query->whereNotIn('status', ['Closed - Done']);
            $datas11Query->whereNotIn('status', ['Closed - Done']);
            $datas12Query->whereNotIn('status', ['Closed - Done']);
            $datas13Query->whereNotIn('status', ['Close-Done']);
            $datas14Query->whereNotIn('status', ['Closed Done']);
            $datas15Query->whereNotIn('status', ['Close done']);
            $datas16Query->whereNotIn('status', ['Closed Done']);
            $datas17Query->whereNotIn('status', ['Close-Done']);
            $datas25Query->whereNotIn('status', ['Closed-Done']);
            $incidentQuery->whereNotIn('status', ['Closed-Done']);
            $deviationQuery->whereNotIn('status', ['Closed-Done']);
            $oocQuery->whereNotIn('status', ['Closed-Done']);
            // $sstability->whereNotIn('status', ['Closed-Done']);
            $failureInvestigationQuery->whereNotIn('status', ['Closed-Done']);
            $queryManagementQuery->whereNotIn('status', ['Closed-Done']);
            $calibrationQuery->whereNotIn('status', ['Closed-Done']);
        }
       
        

        switch ($filterType) {
            case 'weekly':
                $startOfPreviousWeek = Carbon::now()->subDays(7);
                $endOfPreviousWeek = Carbon::now();

                $datasQuery->whereBetween('created_at', [$startOfPreviousWeek, $endOfPreviousWeek]);
                $globalCCQuery->whereBetween('created_at', [$startOfPreviousWeek, $endOfPreviousWeek]);
                $supplierQuery->whereBetween('created_at', [$startOfPreviousWeek, $endOfPreviousWeek]);
                $meetingQuery->whereBetween('created_at', [$startOfPreviousWeek, $endOfPreviousWeek]);
                $supplierAuditQuery->whereBetween('created_at', [$startOfPreviousWeek, $endOfPreviousWeek]);
                $datas1Query->whereBetween('created_at', [$startOfPreviousWeek, $endOfPreviousWeek]);
                $datas2Query->whereBetween('created_at', [$startOfPreviousWeek, $endOfPreviousWeek]);
                $datas3Query->whereBetween('created_at', [$startOfPreviousWeek, $endOfPreviousWeek]);
                $datas4Query->whereBetween('created_at', [$startOfPreviousWeek, $endOfPreviousWeek]);
                $datas5Query->whereBetween('created_at', [$startOfPreviousWeek, $endOfPreviousWeek]);
                $datas28Query->whereBetween('created_at', [$startOfPreviousWeek, $endOfPreviousWeek]);
                $equipmentQuery->whereBetween('created_at', [$startOfPreviousWeek, $endOfPreviousWeek]);
                $EHSQuery->whereBetween('created_at', [$startOfPreviousWeek, $endOfPreviousWeek]);
                $SanctionQuery->whereBetween('created_at', [$startOfPreviousWeek, $endOfPreviousWeek]);
                $datasPMQuery->whereBetween('created_at', [$startOfPreviousWeek, $endOfPreviousWeek]);
                $datas6Query->whereBetween('created_at', [$startOfPreviousWeek, $endOfPreviousWeek]);
                $datas7Query->whereBetween('created_at', [$startOfPreviousWeek, $endOfPreviousWeek]);
                $datas8Query->whereBetween('created_at', [$startOfPreviousWeek, $endOfPreviousWeek]);
                $datas9Query->whereBetween('created_at', [$startOfPreviousWeek, $endOfPreviousWeek]);
                $datas10Query->whereBetween('created_at', [$startOfPreviousWeek, $endOfPreviousWeek]);
                $datas11Query->whereBetween('created_at', [$startOfPreviousWeek, $endOfPreviousWeek]);
                $datas12Query->whereBetween('created_at', [$startOfPreviousWeek, $endOfPreviousWeek]);
                $datas13Query->whereBetween('created_at', [$startOfPreviousWeek, $endOfPreviousWeek]);
                $datas14Query->whereBetween('created_at', [$startOfPreviousWeek, $endOfPreviousWeek]);
                $deviationQuery->whereBetween('created_at', [$startOfPreviousWeek, $endOfPreviousWeek]);
                $oocQuery->whereBetween('created_at', [$startOfPreviousWeek, $endOfPreviousWeek]);
                $failureInvestigationQuery->whereBetween('created_at', [$startOfPreviousWeek, $endOfPreviousWeek]);
                $datas15Query->whereBetween('created_at', [$startOfPreviousWeek, $endOfPreviousWeek]);
                $datas16Query->whereBetween('created_at', [$startOfPreviousWeek, $endOfPreviousWeek]);
                $datas17Query->whereBetween('created_at', [$startOfPreviousWeek, $endOfPreviousWeek]);
                $datas25Query->whereBetween('created_at', [$startOfPreviousWeek, $endOfPreviousWeek]);
                $incidentQuery->whereBetween('created_at', [$startOfPreviousWeek, $endOfPreviousWeek]);
                $queryManagementQuery->whereBetween('created_at', [$startOfPreviousWeek, $endOfPreviousWeek]);
                $calibrationQuery->whereBetween('created_at', [$startOfPreviousWeek, $endOfPreviousWeek]);
                break;

            case 'fortnight':
                $startOfPreviousfortnight = Carbon::now()->subDays(14);
                $endOfPreviousfortnight = Carbon::now();

                $datasQuery->whereBetween('created_at', [$startOfPreviousfortnight, $endOfPreviousfortnight]);
                $globalCCQuery->whereBetween('created_at', [$startOfPreviousfortnight, $endOfPreviousfortnight]);
                $supplierQuery->whereBetween('created_at', [$startOfPreviousfortnight, $endOfPreviousfortnight]);
                $meetingQuery->whereBetween('created_at', [$startOfPreviousfortnight, $endOfPreviousfortnight]);
                $supplierAuditQuery->whereBetween('created_at', [$startOfPreviousfortnight, $endOfPreviousfortnight]);
                $datas1Query->whereBetween('created_at', [$startOfPreviousfortnight, $endOfPreviousfortnight]);
                $datas2Query->whereBetween('created_at', [$startOfPreviousfortnight, $endOfPreviousfortnight]);
                $datas3Query->whereBetween('created_at', [$startOfPreviousfortnight, $endOfPreviousfortnight]);
                $datas4Query->whereBetween('created_at', [$startOfPreviousfortnight, $endOfPreviousfortnight]);
                $datas5Query->whereBetween('created_at', [$startOfPreviousfortnight, $endOfPreviousfortnight]);
                $datas28Query->whereBetween('created_at', [$startOfPreviousfortnight, $endOfPreviousfortnight]);
                $equipmentQuery->whereBetween('created_at', [$startOfPreviousfortnight, $endOfPreviousfortnight]);
                $EHSQuery->whereBetween('created_at', [$startOfPreviousfortnight, $endOfPreviousfortnight]);
                $SanctionQuery->whereBetween('created_at', [$startOfPreviousfortnight, $endOfPreviousfortnight]);
                $datasPMQuery->whereBetween('created_at', [$startOfPreviousfortnight, $endOfPreviousfortnight]);
                $datas6Query->whereBetween('created_at', [$startOfPreviousfortnight, $endOfPreviousfortnight]);
                $datas7Query->whereBetween('created_at', [$startOfPreviousfortnight, $endOfPreviousfortnight]);
                $datas8Query->whereBetween('created_at', [$startOfPreviousfortnight, $endOfPreviousfortnight]);
                $datas9Query->whereBetween('created_at', [$startOfPreviousfortnight, $endOfPreviousfortnight]);
                $datas10Query->whereBetween('created_at', [$startOfPreviousfortnight, $endOfPreviousfortnight]);
                $datas11Query->whereBetween('created_at', [$startOfPreviousfortnight, $endOfPreviousfortnight]);
                $datas12Query->whereBetween('created_at', [$startOfPreviousfortnight, $endOfPreviousfortnight]);
                $datas13Query->whereBetween('created_at', [$startOfPreviousfortnight, $endOfPreviousfortnight]);
                $datas14Query->whereBetween('created_at', [$startOfPreviousfortnight, $endOfPreviousfortnight]);
                $deviationQuery->whereBetween('created_at', [$startOfPreviousfortnight, $endOfPreviousfortnight]);
                $oocQuery->whereBetween('created_at', [$startOfPreviousfortnight, $endOfPreviousfortnight]);
                $failureInvestigationQuery->whereBetween('created_at', [$startOfPreviousfortnight, $endOfPreviousfortnight]);
                $datas15Query->whereBetween('created_at', [$startOfPreviousfortnight, $endOfPreviousfortnight]);
                $datas16Query->whereBetween('created_at', [$startOfPreviousfortnight, $endOfPreviousfortnight]);
                $datas17Query->whereBetween('created_at', [$startOfPreviousfortnight, $endOfPreviousfortnight]);
                $datas25Query->whereBetween('created_at', [$startOfPreviousfortnight, $endOfPreviousfortnight]);
                $incidentQuery->whereBetween('created_at', [$startOfPreviousfortnight, $endOfPreviousfortnight]);
                $queryManagementQuery->whereBetween('created_at', [$startOfPreviousfortnight, $endOfPreviousfortnight]);
                $calibrationQuery->whereBetween('created_at', [$startOfPreviousfortnight, $endOfPreviousfortnight]);
                break;
    
            case 'quarterly':
                $startOfPreviousforquarterly = Carbon::now()->subDays(90);
                $endOfPreviousfortquarterly = Carbon::now();
    
                $datasQuery->whereBetween('created_at', [$startOfPreviousforquarterly, $endOfPreviousfortquarterly]);
                $globalCCQuery->whereBetween('created_at', [$startOfPreviousforquarterly, $endOfPreviousfortquarterly]);
                $supplierQuery->whereBetween('created_at', [$startOfPreviousforquarterly, $endOfPreviousfortquarterly]);
                $meetingQuery->whereBetween('created_at', [$startOfPreviousforquarterly, $endOfPreviousfortquarterly]);
                $supplierAuditQuery->whereBetween('created_at', [$startOfPreviousforquarterly, $endOfPreviousfortquarterly]);
                $datas1Query->whereBetween('created_at', [$startOfPreviousforquarterly, $endOfPreviousfortquarterly]);
                $datas2Query->whereBetween('created_at', [$startOfPreviousforquarterly, $endOfPreviousfortquarterly]);
                $datas3Query->whereBetween('created_at', [$startOfPreviousforquarterly, $endOfPreviousfortquarterly]);
                $datas4Query->whereBetween('created_at', [$startOfPreviousforquarterly, $endOfPreviousfortquarterly]);
                $datas5Query->whereBetween('created_at', [$startOfPreviousforquarterly, $endOfPreviousfortquarterly]);
                $datas28Query->whereBetween('created_at', [$startOfPreviousforquarterly, $endOfPreviousfortquarterly]);
                $equipmentQuery->whereBetween('created_at', [$startOfPreviousforquarterly, $endOfPreviousfortquarterly]);
                $EHSQuery->whereBetween('created_at', [$startOfPreviousforquarterly, $endOfPreviousfortquarterly]);
                $SanctionQuery->whereBetween('created_at', [$startOfPreviousforquarterly, $endOfPreviousfortquarterly]);
                $datasPMQuery->whereBetween('created_at', [$startOfPreviousforquarterly, $endOfPreviousfortquarterly]);
                $datas6Query->whereBetween('created_at', [$startOfPreviousforquarterly, $endOfPreviousfortquarterly]);
                $datas7Query->whereBetween('created_at', [$startOfPreviousforquarterly, $endOfPreviousfortquarterly]);
                $datas8Query->whereBetween('created_at', [$startOfPreviousforquarterly, $endOfPreviousfortquarterly]);
                $datas9Query->whereBetween('created_at', [$startOfPreviousforquarterly, $endOfPreviousfortquarterly]);
                $datas10Query->whereBetween('created_at', [$startOfPreviousforquarterly, $endOfPreviousfortquarterly]);
                $datas11Query->whereBetween('created_at', [$startOfPreviousforquarterly, $endOfPreviousfortquarterly]);
                $datas12Query->whereBetween('created_at', [$startOfPreviousforquarterly, $endOfPreviousfortquarterly]);
                $datas13Query->whereBetween('created_at', [$startOfPreviousforquarterly, $endOfPreviousfortquarterly]);
                $datas14Query->whereBetween('created_at', [$startOfPreviousforquarterly, $endOfPreviousfortquarterly]);
                $deviationQuery->whereBetween('created_at', [$startOfPreviousforquarterly, $endOfPreviousfortquarterly]);
                $oocQuery->whereBetween('created_at', [$startOfPreviousforquarterly, $endOfPreviousfortquarterly]);
                $failureInvestigationQuery->whereBetween('created_at', [$startOfPreviousforquarterly, $endOfPreviousfortquarterly]);
                $datas15Query->whereBetween('created_at', [$startOfPreviousforquarterly, $endOfPreviousfortquarterly]);
                $datas16Query->whereBetween('created_at', [$startOfPreviousforquarterly, $endOfPreviousfortquarterly]);
                $datas17Query->whereBetween('created_at', [$startOfPreviousforquarterly, $endOfPreviousfortquarterly]);
                $datas25Query->whereBetween('created_at', [$startOfPreviousforquarterly, $endOfPreviousfortquarterly]);
                $incidentQuery->whereBetween('created_at', [$startOfPreviousforquarterly, $endOfPreviousfortquarterly]);
                $queryManagementQuery->whereBetween('created_at', [$startOfPreviousforquarterly, $endOfPreviousfortquarterly]);
                $calibrationQuery->whereBetween('created_at', [$startOfPreviousforquarterly, $endOfPreviousfortquarterly]);
                break;

            case 'halfyearly':
                $startOfPrevioushalfyearly = Carbon::now()->subDays(180);
                $endOfPrevioushalfyearly = Carbon::now();
        
                $datasQuery->whereBetween('created_at', [$startOfPrevioushalfyearly, $endOfPrevioushalfyearly]);
                $globalCCQuery->whereBetween('created_at', [$startOfPrevioushalfyearly, $endOfPrevioushalfyearly]);
                $supplierQuery->whereBetween('created_at', [$startOfPrevioushalfyearly, $endOfPrevioushalfyearly]);
                $meetingQuery->whereBetween('created_at', [$startOfPrevioushalfyearly, $endOfPrevioushalfyearly]);
                $supplierAuditQuery->whereBetween('created_at', [$startOfPrevioushalfyearly, $endOfPrevioushalfyearly]);
                $datas1Query->whereBetween('created_at', [$startOfPrevioushalfyearly, $endOfPrevioushalfyearly]);
                $datas2Query->whereBetween('created_at', [$startOfPrevioushalfyearly, $endOfPrevioushalfyearly]);
                $datas3Query->whereBetween('created_at', [$startOfPrevioushalfyearly, $endOfPrevioushalfyearly]);
                $datas4Query->whereBetween('created_at', [$startOfPrevioushalfyearly, $endOfPrevioushalfyearly]);
                $datas28Query->whereBetween('created_at', [$startOfPrevioushalfyearly, $endOfPrevioushalfyearly]);
                $datas5Query->whereBetween('created_at', [$startOfPrevioushalfyearly, $endOfPrevioushalfyearly]);
                $equipmentQuery->whereBetween('created_at', [$startOfPrevioushalfyearly, $endOfPrevioushalfyearly]);
                $EHSQuery->whereBetween('created_at', [$startOfPrevioushalfyearly, $endOfPrevioushalfyearly]);
                $SanctionQuery->whereBetween('created_at', [$startOfPrevioushalfyearly, $endOfPrevioushalfyearly]);
                $datasPMQuery->whereBetween('created_at', [$startOfPrevioushalfyearly, $endOfPrevioushalfyearly]);
                $datas6Query->whereBetween('created_at', [$startOfPrevioushalfyearly, $endOfPrevioushalfyearly]);
                $datas7Query->whereBetween('created_at', [$startOfPrevioushalfyearly, $endOfPrevioushalfyearly]);
                $datas8Query->whereBetween('created_at', [$startOfPrevioushalfyearly, $endOfPrevioushalfyearly]);
                $datas9Query->whereBetween('created_at', [$startOfPrevioushalfyearly, $endOfPrevioushalfyearly]);
                $datas10Query->whereBetween('created_at', [$startOfPrevioushalfyearly, $endOfPrevioushalfyearly]);
                $datas11Query->whereBetween('created_at', [$startOfPrevioushalfyearly, $endOfPrevioushalfyearly]);
                $datas12Query->whereBetween('created_at', [$startOfPrevioushalfyearly, $endOfPrevioushalfyearly]);
                $datas13Query->whereBetween('created_at', [$startOfPrevioushalfyearly, $endOfPrevioushalfyearly]);
                $datas14Query->whereBetween('created_at', [$startOfPrevioushalfyearly, $endOfPrevioushalfyearly]);
                $deviationQuery->whereBetween('created_at', [$startOfPrevioushalfyearly, $endOfPrevioushalfyearly]);
                $oocQuery->whereBetween('created_at', [$startOfPrevioushalfyearly, $endOfPrevioushalfyearly]);
                $failureInvestigationQuery->whereBetween('created_at', [$startOfPrevioushalfyearly, $endOfPrevioushalfyearly]);
                $datas15Query->whereBetween('created_at', [$startOfPrevioushalfyearly, $endOfPrevioushalfyearly]);
                $datas16Query->whereBetween('created_at', [$startOfPrevioushalfyearly, $endOfPrevioushalfyearly]);
                $datas17Query->whereBetween('created_at', [$startOfPrevioushalfyearly, $endOfPrevioushalfyearly]);
                $datas25Query->whereBetween('created_at', [$startOfPrevioushalfyearly, $endOfPrevioushalfyearly]);
                $incidentQuery->whereBetween('created_at', [$startOfPrevioushalfyearly, $endOfPrevioushalfyearly]);
                $queryManagementQuery->whereBetween('created_at', [$startOfPrevioushalfyearly, $endOfPrevioushalfyearly]);
                $calibrationQuery->whereBetween('created_at', [$startOfPrevioushalfyearly, $endOfPrevioushalfyearly]);
                break;

            case 'monthly':
                $startOfMonth = Carbon::now()->subDays(30);
                $endOfMonth = Carbon::now();

                $datasQuery->whereBetween('created_at', [$startOfMonth, $endOfMonth]);
                $globalCCQuery->whereBetween('created_at', [$startOfMonth, $endOfMonth]);
                $supplierQuery->whereBetween('created_at', [$startOfMonth, $endOfMonth]);
                $meetingQuery->whereBetween('created_at', [$startOfMonth, $endOfMonth]);
                $supplierAuditQuery->whereBetween('created_at', [$startOfMonth, $endOfMonth]);
                $datas1Query->whereBetween('created_at', [$startOfMonth, $endOfMonth]);
                $datas2Query->whereBetween('created_at', [$startOfMonth, $endOfMonth]);
                $datas3Query->whereBetween('created_at', [$startOfMonth, $endOfMonth]);
                $datas4Query->whereBetween('created_at', [$startOfMonth, $endOfMonth]);
                $datas5Query->whereBetween('created_at', [$startOfMonth, $endOfMonth]);
                $datas28Query->whereBetween('created_at', [$startOfMonth, $endOfMonth]);
                $equipmentQuery->whereBetween('created_at', [$startOfMonth, $endOfMonth]);
                $EHSQuery->whereBetween('created_at', [$startOfMonth, $endOfMonth]);
                $SanctionQuery->whereBetween('created_at', [$startOfMonth, $endOfMonth]);
                $datasPMQuery->whereBetween('created_at', [$startOfMonth, $endOfMonth]);
                $datas6Query->whereBetween('created_at', [$startOfMonth, $endOfMonth]);
                $datas7Query->whereBetween('created_at', [$startOfMonth, $endOfMonth]);
                $datas8Query->whereBetween('created_at', [$startOfMonth, $endOfMonth]);
                $datas9Query->whereBetween('created_at', [$startOfMonth, $endOfMonth]);
                $datas10Query->whereBetween('created_at', [$startOfMonth, $endOfMonth]);
                $datas11Query->whereBetween('created_at', [$startOfMonth, $endOfMonth]);
                $datas12Query->whereBetween('created_at', [$startOfMonth, $endOfMonth]);
                $datas13Query->whereBetween('created_at', [$startOfMonth, $endOfMonth]);
                $datas14Query->whereBetween('created_at', [$startOfMonth, $endOfMonth]);
                $deviationQuery->whereBetween('created_at', [$startOfMonth, $endOfMonth]);
                $oocQuery->whereBetween('created_at', [$startOfMonth, $endOfMonth]);
                $failureInvestigationQuery->whereBetween('created_at', [$startOfMonth, $endOfMonth]);
                $datas15Query->whereBetween('created_at', [$startOfMonth, $endOfMonth]);
                $datas16Query->whereBetween('created_at', [$startOfMonth, $endOfMonth]);
                $datas17Query->whereBetween('created_at', [$startOfMonth, $endOfMonth]);
                $datas25Query->whereBetween('created_at', [$startOfMonth, $endOfMonth]);
                $incidentQuery->whereBetween('created_at', [$startOfMonth, $endOfMonth]);
                $queryManagementQuery->whereBetween('created_at', [$startOfMonth, $endOfMonth]);
                $calibrationQuery->whereBetween('created_at', [$startOfMonth, $endOfMonth]);
                break;

            case 'annually':
                $startOfYear = Carbon::now()->subDays(365);
                $endOfYear = Carbon::now();

                $datasQuery->whereBetween('created_at', [$startOfYear, $endOfYear]);
                $globalCCQuery->whereBetween('created_at', [$startOfYear, $endOfYear]);
                $supplierQuery->whereBetween('created_at', [$startOfYear, $endOfYear]);
                $meetingQuery->whereBetween('created_at', [$startOfYear, $endOfYear]);
                $supplierAuditQuery->whereBetween('created_at', [$startOfYear, $endOfYear]);
                $datas1Query->whereBetween('created_at', [$startOfYear, $endOfYear]);
                $datas2Query->whereBetween('created_at', [$startOfYear, $endOfYear]);
                $datas3Query->whereBetween('created_at', [$startOfYear, $endOfYear]);
                $datas4Query->whereBetween('created_at', [$startOfYear, $endOfYear]);
                $datas5Query->whereBetween('created_at', [$startOfYear, $endOfYear]);
                $datas28Query->whereBetween('created_at', [$startOfYear, $endOfYear]);
                $equipmentQuery->whereBetween('created_at', [$startOfYear, $endOfYear]);
                $EHSQuery->whereBetween('created_at', [$startOfYear, $endOfYear]);
                $SanctionQuery->whereBetween('created_at', [$startOfYear, $endOfYear]);
                $datasPMQuery->whereBetween('created_at', [$startOfYear, $endOfYear]);
                $datas6Query->whereBetween('created_at', [$startOfYear, $endOfYear]);
                $datas7Query->whereBetween('created_at', [$startOfYear, $endOfYear]);
                $datas8Query->whereBetween('created_at', [$startOfYear, $endOfYear]);
                $datas9Query->whereBetween('created_at', [$startOfYear, $endOfYear]);
                $datas10Query->whereBetween('created_at', [$startOfYear, $endOfYear]);
                $datas11Query->whereBetween('created_at', [$startOfYear, $endOfYear]);
                $datas12Query->whereBetween('created_at', [$startOfYear, $endOfYear]);
                $datas13Query->whereBetween('created_at', [$startOfYear, $endOfYear]);
                $datas14Query->whereBetween('created_at', [$startOfYear, $endOfYear]);
                $deviationQuery->whereBetween('created_at', [$startOfYear, $endOfYear]);
                $oocQuery->whereBetween('created_at', [$startOfYear, $endOfYear]);
                $failureInvestigationQuery->whereBetween('created_at', [$startOfYear, $endOfYear]);
                $datas15Query->whereBetween('created_at', [$startOfYear, $endOfYear]);
                $datas16Query->whereBetween('created_at', [$startOfYear, $endOfYear]);
                $datas17Query->whereBetween('created_at', [$startOfYear, $endOfYear]);
                $datas25Query->whereBetween('created_at', [$startOfYear, $endOfYear]);
                $incidentQuery->whereBetween('created_at', [$startOfYear, $endOfYear]);
                $queryManagementQuery->whereBetween('created_at', [$startOfYear, $endOfYear]);
                $calibrationQuery->whereBetween('created_at', [$startOfYear, $endOfYear]);
                break;

            case 'custom':
                if ($startDate && $endDate) {
                    $start = Carbon::parse($startDate)->startOfDay();
                    $end = Carbon::parse($endDate)->endOfDay();
        
                    $datasQuery->whereBetween('created_at', [$start, $end]);
                    $globalCCQuery->whereBetween('created_at', [$start, $end]);
                    $supplierQuery->whereBetween('created_at', [$start, $end]);
                    $meetingQuery->whereBetween('created_at', [$start, $end]);
                    $supplierAuditQuery->whereBetween('created_at', [$start, $end]);
                    $datas1Query->whereBetween('created_at', [$start, $end]);
                    $datas2Query->whereBetween('created_at', [$start, $end]);
                    $datas3Query->whereBetween('created_at', [$start, $end]);
                    $datas4Query->whereBetween('created_at', [$start, $end]);
                    $datas5Query->whereBetween('created_at', [$start, $end]);
                    $datas28Query->whereBetween('created_at', [$start, $end]);
                    $equipmentQuery->whereBetween('created_at', [$start, $end]);
                    $EHSQuery->whereBetween('created_at', [$start, $end]);
                    $SanctionQuery->whereBetween('created_at', [$start, $end]);
                    $datasPMQuery->whereBetween('created_at', [$start, $end]);
                    $datas6Query->whereBetween('created_at', [$start, $end]);
                    $datas7Query->whereBetween('created_at', [$start, $end]);
                    $datas8Query->whereBetween('created_at', [$start, $end]);
                    $datas9Query->whereBetween('created_at', [$start, $end]);
                    $datas10Query->whereBetween('created_at', [$start, $end]);
                    $datas11Query->whereBetween('created_at', [$start, $end]);
                    $datas12Query->whereBetween('created_at', [$start, $end]);
                    $datas13Query->whereBetween('created_at', [$start, $end]);
                    $datas14Query->whereBetween('created_at', [$start, $end]);
                    $deviationQuery->whereBetween('created_at', [$start, $end]);
                    $oocQuery->whereBetween('created_at', [$start, $end]);
                    $failureInvestigationQuery->whereBetween('created_at', [$start, $end]);
                    $datas15Query->whereBetween('created_at', [$start, $end]);
                    $datas16Query->whereBetween('created_at', [$start, $end]);
                    $datas17Query->whereBetween('created_at', [$start, $end]);
                    $datas25Query->whereBetween('created_at', [$start, $end]);
                    $incidentQuery->whereBetween('created_at', [$start, $end]);
                    $queryManagementQuery->whereBetween('created_at', [$start, $end]);
                    $calibrationQuery->whereBetween('created_at', [$start, $end]);
                }
                break;

            default:
                break;
        }
        

        $datas = $datasQuery->orderByDesc('id')->get();
        $globalCC = $globalCCQuery->orderByDesc('id')->get();
        $supplier = $supplierQuery->orderByDesc('id')->get();
        $meeting = $meetingQuery->orderByDesc('id')->get();
        $supplierAudit = $supplierAuditQuery->orderByDesc('id')->get();
        $datas1 = $datas1Query->orderByDesc('id')->get();
        $datas2 = $datas2Query->orderByDesc('id')->get();
        $datas3 = $datas3Query->orderByDesc('id')->get();
        $datas4 = $datas4Query->orderByDesc('id')->get();
        $datas5 = $datas5Query->orderByDesc('id')->get();
        $datas28 = $datas28Query->orderByDesc('id')->get();
        // dd($datas28);
        $equipment = $equipmentQuery->orderByDesc('id')->get();
        $EHS = $EHSQuery->orderByDesc('id')->get();
        $Sanction = $SanctionQuery->orderByDesc('id')->get();
        $datasPM = $datasPMQuery->orderByDesc('id')->get();
        $datas6 = $datas6Query->orderByDesc('id')->get();
        $datas7 = $datas7Query->orderByDesc('id')->get();
        $datas8 = $datas8Query->orderByDesc('id')->get();
        $datas9 = $datas9Query->orderByDesc('id')->get();
        $datas10 = $datas10Query->orderByDesc('id')->get();
        $datas11 = $datas11Query->orderByDesc('id')->get();
        $datas12 = $datas12Query->orderByDesc('id')->get();
        $datas13 = $datas13Query->orderByDesc('id')->get();
        $datas14 = $datas14Query->orderByDesc('id')->get();
        $deviation = $deviationQuery->orderByDesc('id')->get();
        $ooc = $oocQuery->orderByDesc('id')->get();
        $failureInvestigation = $failureInvestigationQuery->orderByDesc('id')->get();
        $datas15 = $datas15Query->orderByDesc('id')->get();
        $datas16 = $datas16Query->orderByDesc('id')->get();
        $datas17 = $datas17Query->orderByDesc('id')->get();
        $datas25 = $datas25Query->orderByDesc('id')->get();
        $incident = $incidentQuery->orderByDesc('id')->get();
        $queryManagement = $queryManagementQuery->orderByDesc('id')->get();
        $calibration =$calibrationQuery->orderByDesc('id')->get();
        // $ssstability =$sstability->orderByDesc('id')->get();
        
        
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
                "division_name" => Helpers::getDivisionName($data->division_id),
                "filter_date_opened" => Helpers::getdateFormat1($data->created_at),
                "filter_originator" => Helpers::getInitiatorName($data->initiator_id),
                "filter_due_date" => Helpers::getdateFormat($data->due_date),
            ]);
        }

        foreach ($globalCC as $data) {
            $data->create = Carbon::parse($data->created_at)->format('d-M-Y h:i A');

            array_push($table, [
                "id" => $data->id,
                "parent" => "-",
                "record" => $data->record,
                "due_date" => $data->due_date,
                "type" => "Global Change Control",
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

        foreach ($supplier as $data) {
            $data->create = Carbon::parse($data->created_at)->format('d-M-Y h:i A');

            array_push($table, [
                "id" => $data->id,
                "parent" => "-",
                // "parent" => $data->parent_record ? $data->parent_record : "-",
                "record" => $data->record,
                "due_date" => $data->due_date,
                "type" => "Supplier",
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

        foreach ($meeting as $data) {
            $data->create = Carbon::parse($data->created_at)->format('d-M-Y h:i A');

            array_push($table, [
                "id" => $data->id,
                "parent" => "-",
                // "parent" => $data->parent_record ? $data->parent_record : "-",
                "record" => $data->record,
                "due_date" => $data->due_date,
                "type" => "Meeting",
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

        foreach ($supplierAudit as $data) {
            $data->create = Carbon::parse($data->created_at)->format('d-M-Y h:i A');

            array_push($table, [
                "id" => $data->id,
                "parent" => "-",
                // "parent" => $data->parent_record ? $data->parent_record : "-",
                "record" => $data->record,
                "due_date" => $data->due_date,
                "type" => "Supplier Audit",
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

        foreach ($datas1 as $data) {
            $data->create = Carbon::parse($data->created_at)->format('d-M-Y h:i A');

            array_push($table, [
                "id" => $data->id,
                "parent" => $data->cc_id ? $data->cc_id : "-",
                "record" => $data->record,
                "type" => "Action Item",
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
                "division_name" => Helpers::getDivisionName($data->division_id),
                "filter_date_opened" => Helpers::getdateFormat1($data->created_at),
                "filter_originator" => Helpers::getInitiatorName($data->initiator_id),
                "filter_due_date" => Helpers::getdateFormat($data->due_date),
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
                "division_name" => Helpers::getDivisionName($data->division_id),
                "filter_date_opened" => Helpers::getdateFormat1($data->created_at),
                "filter_originator" => Helpers::getInitiatorName($data->initiator),
                "filter_due_date" => Helpers::getdateFormat($data->due_date),
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

                "division_name" => Helpers::getDivisionName($data->division_id),
                "filter_date_opened" => Helpers::getdateFormat1($data->created_at),
                "filter_originator" => Helpers::getInitiatorName($data->initiator_id),
                "filter_due_date" => Helpers::getdateFormat($data->due_date),
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

                "division_name" => Helpers::getDivisionName($data->division_id),
                "filter_date_opened" => Helpers::getdateFormat1($data->created_at),
                "filter_originator" => Helpers::getInitiatorName($data->initiator_id),
                "filter_due_date" => Helpers::getdateFormat($data->due_date),
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

                "division_name" => Helpers::getDivisionName($data->division_id),
                "filter_date_opened" => Helpers::getdateFormat1($data->created_at),
                "filter_originator" => Helpers::getInitiatorName($data->initiator_id),
                "filter_due_date" => Helpers::getdateFormat($data->due_date),
            ]);
        }

        foreach ($datas28 as $data) {
            $data->create = Carbon::parse($data->created_at)->format('d-M-Y h:i A');
            $revised_date = Extension::where('parent_id', $data->id)->where('parent_type', "Global Capa")->value('revised_date');

            array_push($table, [
                "id" => $data->id,
                "parent" => $data->parent_record ? $data->parent_record : "-",
                "record" => $data->record,
                "type" => "Global Capa",
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

                "division_name" => Helpers::getDivisionName($data->division_id),
                "filter_date_opened" => Helpers::getdateFormat1($data->created_at),
                "filter_originator" => Helpers::getInitiatorName($data->initiator_id),
                "filter_due_date" => Helpers::getdateFormat($data->due_date),
            ]);
        }

        foreach ($equipment as $data) {
            $data->create = Carbon::parse($data->created_at)->format('d-M-Y h:i A');
            $revised_date = Extension::where('parent_id', $data->id)->where('parent_type', "Capa")->value('revised_date');

            array_push($table, [
                "id" => $data->id,
                "parent" => $data->parent_record ? $data->parent_record : "-",
                "record" => $data->record,
                "type" => "Equipment/Instrument Lifecycle Management",
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

                "division_name" => Helpers::getDivisionName($data->division_id),
                "filter_date_opened" => Helpers::getdateFormat1($data->created_at),
                "filter_originator" => Helpers::getInitiatorName($data->initiator_id),
                "filter_due_date" => Helpers::getdateFormat($data->due_date),
            ]);
        }

        foreach ($EHS as $data) {
            $data->create = Carbon::parse($data->created_at)->format('d-M-Y h:i A');
            $revised_date = Extension::where('parent_id', $data->id)->where('parent_type', "Capa")->value('revised_date');

            array_push($table, [
                "id" => $data->id,
                "parent" => $data->parent_record ? $data->parent_record : "-",
                "record" => $data->record,
                "type" => "EHS & Environment Sustainability",
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

                "division_name" => Helpers::getDivisionName($data->division_id),
                "filter_date_opened" => Helpers::getdateFormat1($data->created_at),
                "filter_originator" => Helpers::getInitiatorName($data->initiator_id),
                "filter_due_date" => Helpers::getdateFormat($data->due_date),
            ]);
        }
        foreach ($Sanction as $data) {
            $data->create = Carbon::parse($data->created_at)->format('d-M-Y h:i A');
            $revised_date = Extension::where('parent_id', $data->id)->where('parent_type', "Capa")->value('revised_date');

            array_push($table, [
                "id" => $data->id,
                "parent" => $data->parent_record ? $data->parent_record : "-",
                "record" => $data->record,
                "type" => "Sanction",
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

                "division_name" => Helpers::getDivisionName($data->division_id),
                "filter_date_opened" => Helpers::getdateFormat1($data->created_at),
                "filter_originator" => Helpers::getInitiatorName($data->initiator_id),
                "filter_due_date" => Helpers::getdateFormat($data->due_date),
            ]);
        }

        foreach ($datasPM as $data) {
            $data->create = Carbon::parse($data->created_at)->format('d-M-Y h:i A');
            $revised_date = Extension::where('parent_id', $data->id)->where('parent_type', "Preventive Maintenance")->value('revised_date');

            array_push($table, [
                "id" => $data->id,
                "parent" => $data->parent_record ? $data->parent_record : "-",
                "record" => $data->record,
                "type" => "Preventive Maintenance",
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

                "division_name" => Helpers::getDivisionName($data->division_id),
                "filter_date_opened" => Helpers::getdateFormat1($data->created_at),
                "filter_originator" => Helpers::getInitiatorName($data->initiator_id),
                "filter_due_date" => Helpers::getdateFormat($data->due_date),
            ]);
        }
        foreach ($datas6 as $data) {
            $data->create = Carbon::parse($data->created_at)->format('d-M-Y h:i A');

            array_push($table, [
                "id" => $data->id,
                "parent" => $data->parent_record ? $data->parent_record : "-",
                "record" => $data->record,
                "type" => "Risk Assessment",
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

                "division_name" => Helpers::getDivisionName($data->division_id),
                "filter_date_opened" => Helpers::getdateFormat1($data->created_at),
                "filter_originator" => Helpers::getInitiatorName($data->initiator_id),
                "filter_due_date" => Helpers::getdateFormat($data->due_date),
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

                "division_name" => Helpers::getDivisionName($data->division_id),
                "filter_date_opened" => Helpers::getdateFormat1($data->created_at),
                "filter_originator" => Helpers::getInitiatorName($data->initiator_id),
                "filter_due_date" => Helpers::getdateFormat($data->due_date),
            ]);
        }
        foreach ($datas8 as $data) {
            $data->create = Carbon::parse($data->created_at)->format('d-M-Y h:i A');
            array_push($table, [
                "id" => $data->id,
                "parent" => $data->parent_record ? $data->parent_record : "-",
                "record" => $data->record,
                "type" => "Lab Incident",
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

                "division_name" => Helpers::getDivisionName($data->division_id),
                "filter_date_opened" => Helpers::getdateFormat1($data->created_at),
                "filter_originator" => Helpers::getInitiatorName($data->initiator_id),
                "filter_due_date" => Helpers::getdateFormat($data->due_date),
            ]);
        }
        foreach ($datas9 as $data) {
            $data->create = Carbon::parse($data->created_at)->format('d-M-Y h:i A');

            array_push($table, [
                "id" => $data->id,
                "parent" => $data->parent_record ? $data->parent_record : "-",
                "record" => $data->record,
                "type" => "External Audit",
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

                "division_name" => Helpers::getDivisionName($data->division_id),
                "filter_date_opened" => Helpers::getdateFormat1($data->created_at),
                "filter_originator" => Helpers::getInitiatorName($data->initiator_id),
                "filter_due_date" => Helpers::getdateFormat($data->due_date),
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

                "division_name" => Helpers::getDivisionName($data->division_id),
                "filter_date_opened" => Helpers::getdateFormat1($data->created_at),
                "filter_originator" => Helpers::getInitiatorName($data->initiator_id),
                "filter_due_date" => Helpers::getdateFormat($data->due_date),
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
                "type" => "Root Cause Analysis",
                "parent_id" => $data->parent_id,
                "parent_type" => $data->parent_type,
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

                "division_name" => Helpers::getDivisionName($data->division_id),
                "filter_date_opened" => Helpers::getdateFormat1($data->created_at),
                "filter_originator" => Helpers::getInitiatorName($data->initiator_id),
                "filter_due_date" => Helpers::getdateFormat($data->due_date),

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

                "division_name" => Helpers::getDivisionName($data->division_id),
                "filter_date_opened" => Helpers::getdateFormat1($data->created_at),
                "filter_originator" => Helpers::getInitiatorName($data->initiator_id),
                "filter_due_date" => Helpers::getdateFormat($data->due_date),
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
                "type" => "Complaint Management",
                "parent_id" => $data->parent_id,
                "parent_type" => $data->parent_type,
                "short_description" => $data->description_gi ? $data->description_gi : "-",
                "initiator_id" => $data->initiator_id,
                "initiated_through" => $data->initiated_through_gi,
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

                "division_name" => Helpers::getDivisionName($data->division_id),
                "filter_date_opened" => Helpers::getdateFormat1($data->created_at),
                "filter_originator" => Helpers::getInitiatorName($data->initiator_id),
                "filter_due_date" => Helpers::getdateFormat($data->due_date),
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

                "division_name" => Helpers::getDivisionName($data->division_id),
                "filter_date_opened" => Helpers::getdateFormat1($data->created_at),
                "filter_originator" => Helpers::getInitiatorName($data->initiator_id),
                "filter_due_date" => Helpers::getdateFormat($data->due_date),
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

                "division_name" => Helpers::getDivisionName($data->division_id),
                "filter_date_opened" => Helpers::getdateFormat1($data->created_at),
                "filter_originator" => Helpers::getInitiatorName($data->initiator_id),
                "filter_due_date" => Helpers::getdateFormat($data->due_date),
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

                "division_name" => Helpers::getDivisionName($data->division_id),
                "filter_date_opened" => Helpers::getdateFormat1($data->created_at),
                "filter_originator" => Helpers::getInitiatorName($data->initiator_id),
                "filter_due_date" => Helpers::getdateFormat($data->due_date),
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

                "division_name" => Helpers::getDivisionName($data->division_id),
                "filter_date_opened" => Helpers::getdateFormat1($data->created_at),
                "filter_originator" => Helpers::getInitiatorName($data->initiator_id),
                "filter_due_date" => Helpers::getdateFormat($data->due_date),
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

                "division_name" => Helpers::getDivisionName($data->division_id),
                "filter_date_opened" => Helpers::getdateFormat1($data->created_at),
                "filter_originator" => Helpers::getInitiatorName($data->initiator_id),
                "filter_due_date" => Helpers::getdateFormat($data->due_date),
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

                "division_name" => Helpers::getDivisionName($data->division_id),
                "filter_date_opened" => Helpers::getdateFormat1($data->created_at),
                "filter_originator" => Helpers::getInitiatorName($data->initiator_id),
                "filter_due_date" => Helpers::getdateFormat($data->due_date),
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

                "division_name" => Helpers::getDivisionName($data->division_id),
                "filter_date_opened" => Helpers::getdateFormat1($data->created_at),
                "filter_originator" => Helpers::getInitiatorName($data->initiator_id),
                "filter_due_date" => Helpers::getdateFormat($data->due_date),
            ]);
        }

        foreach ($queryManagement as $data) {
            $data->create = Carbon::parse($data->created_at)->format('d-M-Y h:i A');
            array_push($table, [
                "id" => $data->id,
                "parent" => $data->cc_id ? $data->cc_id : "-",
                "record" => $data->record,
                "type" => "Query Management",
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

                "division_name" => Helpers::getDivisionName($data->division_id),
                "filter_date_opened" => Helpers::getdateFormat1($data->created_at),
                "filter_originator" => Helpers::getInitiatorName($data->initiator_id),
                "filter_due_date" => Helpers::getdateFormat($data->due_date),
            ]);
        }
        foreach ($calibration as $data) {
            $data->create = Carbon::parse($data->created_at)->format('d-M-Y h:i A');
            array_push($table, [
                "id" => $data->id,
                "parent" => $data->cc_id ? $data->cc_id : "-",
                "record" => $data->record,
                "type" => "Calibration Management",
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

                "division_name" => Helpers::getDivisionName($data->division_id),
                "filter_date_opened" => Helpers::getdateFormat1($data->created_at),
                "filter_originator" => Helpers::getInitiatorName($data->initiator_id),
                "filter_due_date" => Helpers::getdateFormat($data->due_date),
            ]);
        }

        // foreach ($ssstability as $data) {
        //     $data->create = Carbon::parse($data->created_at)->format('d-M-Y h:i A');
        //     array_push($table, [
        //         "id" => $data->id,
        //         // "parent" => $data->cc_id ? $data->cc_id : "-",
        //         "record" => $data->record,
        //         "type" => "Sampling Stability",
        //         "parent_id" => $data->parent_id,
        //         "parent_type" => $data->parent_type,
        //         "division_id" => $data->division_id,
        //         "short_description" => $data->short_desc ? $data->short_desc : "-",
        //         "initiator_id" => $data->initiator_id,
        //         "initiated_through" => $data->initiated_through,
        //         "intiation_date" => $data->intiation_date,
        //         "stage" => $data->status,
        //         "date_open" => $data->created_at,
        //         "due_date" => $data->due_date,
        //         "date_close" => $data->updated_at,

        //         "division_name" => Helpers::getDivisionName($data->division_id),
        //         "filter_date_opened" => Helpers::getdateFormat1($data->created_at),
        //         "filter_originator" => Helpers::getInitiatorName($data->initiator_id),
        //         "filter_due_date" => Helpers::getdateFormat($data->due_date),
        //     ]);
        // }
        $table  = collect($table)->sortBy('record')->reverse()->toArray();

        // if ($request->input('export') === 'pdf') {
        //     $pdf = Pdf::loadView('frontend.dashboard.dashboard-pdf', compact('table'));
        //     return $pdf->download('Dashboard-Data.pdf');
        // }

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

        return view('frontend.rcms.dashboard', compact('datag', 'uniqueProcessNames'));
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
                $data2 = errata::where('id', $data->parent_id)->first();
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
        } else {
            return redirect(url('rcms/qms-dashboard'));
        }

        $table  = collect($table)->sortBy('record')->reverse()->toArray();
        $datag = $this->paginate($table);



        // return redirect(url('rcms/qms-dashboard'));
        return view('frontend.rcms.dashboard', compact('datag'));
    }

    public function ccView($id, $type)
    {

        $division_name = "NA";

        if ($type == "OOT") {
            $data = Ootc::find($id);
            $single = "ootcSingleReport/" . $data->id;
            $family = "#";
            $audit = "audit_pdf/".$data->id;
            $division = QMSDivision::find($data->division_id);
            $division_name = $division->name;
        } elseif ($type == "Supplier") {
            $data = Supplier::find($id);
            // $single = "deviationSingleReport/". $data->id;
            $family = "supplier_family_report/" . $data->id;
            // $record = $data->record;
            $single = "supplier-single-report/". $data->id;
            $audit = "supplier-audit-trail-pdf/". $data->id;
            $parent="#";
        } elseif ($type == "Supplier Audit") {
            $data = SupplierAudit::find($id);
            $single = "singleReport/". $data->id;
            $family = "#";
            $audit = "auditReport/" .$data->id;
            $division = QMSDivision::find($data->division_id);
            $division_name = $division->name;
        } elseif ($type == "Failure Investigation") {
            $data = FailureInvestigation::find($id);
            $single = "failure-investigation-single-report/" . $data->id;
            $family = "#";
            $audit = "failure-investigation-audit-pdf/".$data->id;
            $division = QMSDivision::find($data->division_id);
            $division_name = $division->name;
        } elseif ($type == "ERRATA") {
            $data = errata::find($id);
            $single = "errata_single_pdf/" . $data->id;
            $family = "#";
            $audit = "errata_audit/" . $data->id;
            $division = QMSDivision::find($data->division_id);
            $division_name = $division->name;
        } elseif ($type == "Capa") {
            $data = Capa::find($id);
            $single = "capa_showpdf/" . $data->id;
            $family = "capaFamilyReport/" . $data->id;
            $audit = "capaAuditReport/" . $data->id;
            $division = QMSDivision::find($data->division_id);
            $division_name = $division->name;
        }elseif ($type == "Global Capa") {
            $data = GlobalCapa::find($id);
            $single = "capa_showpdf/" . $data->id;
            $family = "globalcapaFamilyReport/" . $data->id;
            $audit = "globalcapaAuditReport/" . $data->id;
            $division = QMSDivision::find($data->division_id);
            $division_name = $division->name;
        } elseif ($type == "Lab Incident") {
            $data = LabIncident::find($id);
            $single = "labincident_showpdf/" . $data->id;
            $family = "labincidentFamilyReport/" .$data->id;
            $audit = "LabIncidentAuditReport/" . $data->id;
            $division = QMSDivision::find($data->division_id);
            $division_name = $division->name;
        } elseif ($type == "Preventive Maintenance") {
            $data = PreventiveMaintenance::find($id);
            $single = "preventiveMaintenance_show/" . $data->id;
            $family = "PreventiveMaintenanceFamilyReport/" .$data->id;
            $audit = "PreventiveMaintenanceAuditReport/" . $data->id;
            $division = QMSDivision::find($data->division_id);
            $division_name = $division->name;
        }
         elseif ($type == "Deviation") {
            $data = Deviation::find($id);
            $single = "deviation_showpdf/" . $data->id;
            $family = "deviationFamilyReport/" .$data->id;
            $audit = "DeviationAuditTrialPdf/" . $data->id;
            $division = QMSDivision::find($data->division_id);
            $division_name = $division->name;
        } elseif ($type == "Internal-Audit") {
            $data = InternalAudit::find($id);
            $single = "IAshow_pdf/" . $data->id;
            $family = "#";
            $audit = "internalauditReport/" . $data->id;
            $division = QMSDivision::find($data->division_id);
            $division_name = $division->name;
        } elseif ($type == "Risk Assessment") {
            $data = RiskManagement::find($id);
            $single = "RA_showpdf/" . $data->id;
            $family = "riskFamilyReport/" . $data->id;
            $audit = "riskAuditReport/" . $data->id;
            $division = QMSDivision::find($data->division_id);
            $division_name = $division->name;
        } elseif ($type == "Out Of Calibration") {
            $data = OutOfCalibration::find($id);
            $recordno = ((RecordNumber::first()->value('counter')) + 1);
            $single = "OOCSingleReport/" . $data->id;
            $family = "#";
            $audit = "ooc_Audit_Report/" . $data->id;
            $division = QMSDivision::find($data->division_id);
            $division_name = $division->name;
        }elseif ($type == "Lab Incident") {
            $data = LabIncident::find($id);
            $single = "LabIncidentSingleReport/" . $data->id;
            $family = "labincidentFamilyReport/" .$data->id;
            $audit = "LabIncidentAuditReport/" . $data->id;
            $division = QMSDivision::find($data->division_id);
            $division_name = $division->name;
        } elseif ($type == "External Audit") {
            $data = Auditee::find($id);
            $single = "Eaudit_showpfd/" . $data->id;
            $family = "ParentReportshowpdf/" . $data->id;
            $audit = "ExternalAuditTrialReport/" . $data->id;
            $division = QMSDivision::find($data->division_id);
            $division_name = $division->name;
        } elseif ($type == "Audit-Program") {
            $data = AuditProgram::find($id);
            $single = "auditProgramSingleReport/" . $data->id;
            $family = "faimilyReport/" . $data->id;
            $audit = "auditProgramAuditReport/" . $data->id;
            $division = QMSDivision::find($data->division_id);
            $division_name = $division->name;
        } elseif ($type == "Action Item") {
            $data = ActionItem::find($id);
            $single = "at_showpdf/"  . $data->id;
            $family = "#";
            $audit = "actionitemauditTrailPdfNew/" . $data->id;
            $division = QMSDivision::find($data->division_id);
            $division_name = $division->name;
        } elseif ($type == "Extension") {
            $data = extension_new::find($id);
            $single = "showpdf/" .$data->id;
            $family = "extensionFamilyreport/" .$data->id;
            $audit = "extensionAuditReport/" .$data->id;
            $division = QMSDivision::find($data->site_location_code);
            $division_name = $division->name;
        }
        elseif ($type == "Observation") {
            $data = Observation::find($id);
            $single = "ObservationSingleReport/" .$data->id;
            $audit = "ObservationAuditTrialShow/" .$data->id;
            $family = "#";
            $division = QMSDivision::find($data->division_id);
            $division_name = $division ? $division->name : '';
        } elseif ($type == "Effectiveness-Check") {
            $data = EffectivenessCheck::find($id);
            $single = "effective_showpdf/" .$data->id;
            $family = "#";
            $audit = "effectiveAuditReport/" .$data->id;
            $division = QMSDivision::find($data->division_id);
            $division_name = $division->name;
        } elseif ($type == "Management-Review") {
            $data = ManagementReview::find($id);
            $single = "managementReview/" . $data->id;
            $family = "#";
            $audit = "managementReviewReport/" . $data->id;
            $division = QMSDivision::find($data->division_id);
            $division_name = $division->name;
        }elseif ($type == "OOS Chemical") {
            $data = OOS::find($id);
            $single = "oos/single_report/" . $data->id;
            $family = "#";
            $audit = "oos/audit_report/" . $data->id;
            $division = QMSDivision::find($data->division_id);
            $division_name = $division->name;
        }elseif ($type == "OOS Microbiology") {
            $data = OOS_micro::find($id);
            $single = "oos_micro/single_report/" . $data->id;
            $family = "#";
            $audit = "oos_micro/audit_report/" . $data->id;
            $division = QMSDivision::find($data->division_id);
            $division_name = $division->name;
        }
        elseif ($type == "Root Cause Analysis") {
            $data = RootCauseAnalysis::find($id);
            $single = "rca_showpdf/" . $data->id;
            $family = "rootFamilyReport/" .$data->id;
            $audit = "rootAuditReport/" . $data->id;
            $division = QMSDivision::find($data->division_id);
            $division_name = $division->name;
        }
        elseif ($type == "Query Management") {
            $data = QueryManagement::find($id);
            $single = "query-managements-single-report/" . $data->id;
            $family = "#";
            $audit = "query-managements-audit-report/" . $data->id;
            $division = QMSDivision::find($data->division_id);
            $division_name = $division->name;
        }
        elseif ($type == "Market demo") {
            $data = MarketComplaint::find($id);
            $single = "marketComplaintSingleReport/" . $data->id;
            $family = "#";
            $audit = "MarketComplaintAuditReport/" . $data->id;
            $division = QMSDivision::find($data->division_id);
            $division_name = $division->name;

        }

        elseif ($type == "Complaint Management") {
            $data = MarketComplaint::find($id);
            $audit = "marketcomplaint/marketauditTrailPdf/" . $data->id;
            $single = "Mk_showpdf/" . $data->id;
            $family = "mk_family_report/". $data->id;
            $division = QMSDivision::find($data->division_id);
            $division_name = $division->name;

        }

        elseif ($type == "Change-Control") {
            $data = CC::find($id);
            $audit = "audit/" . $data->id;
            $single = "changeControl-single-show/" . $data->id;
            $family = "changeControlFamilyReport/" . $data->id;
            $division = QMSDivision::find($data->division_id);
            $division_name = $division->name;
        }

        elseif ($type == "Incident") {
            $data = Incident::find($id);
            $single = "incident_showpdf/" . $data->id;
            $family = "#";
            $audit = "incident-audit-pdf/" . $data->id;
            $division = QMSDivision::find($data->division_id);
            $division_name = $division->name;
        }
        elseif ($type == "Calibration Management") {
            $data = CallibrationDetails::find($id);
            $single = "CalibrationSingleReport/" . $data->id;
            $family = "#";
            $audit = "calibrationAuditTrailPdf/" . $data->id;
            $division = QMSDivision::find($data->division_id);
            $division_name = $division->name;
        }
        elseif ($type == "Equipment/Instrument Lifecycle Management") {
            $data = EquipmentLifecycleManagement::find($id);
            $single = "equipmentlifecycleSingleReport/" . $data->id;
            $family = "equipmentLifeFamilyreport/" . $data->id; 
            $audit = "equipmentlifecycleAuditReport/" . $data->id;
            $division = QMSDivision::find($data->division_id);
            $division_name = $division->name;
        }

        elseif ($type == "EHS & Environment Sustainability") {
            $data = EHSEvent::find($id);
            $single = "ehsSingleReport/" . $data->id;
            $family = "EHSFamilyReport/" . $data->id;
            $audit = "ehsAuditReport/" . $data->id;
            $division = QMSDivision::find($data->division_id);
            $division_name = $division->name;
        }
        elseif ($type == "Sanction") {
            $data = Sanction::find($id);
            $single = "SanctionSingleReport/" . $data->id;
            $family = "#" . $data->id;
            $audit = "SanctionAuditReport/" . $data->id;
            $division = QMSDivision::find($data->division_id);
            $division_name = $division->name;
        }
        elseif ($type == "Non Conformance") {
            $data = NonConformance::find($id);
            $single = "non-conformance-single-report/" . $data->id;
            $family = "#";
            $audit = "non-conformance-audit-pdf/" . $data->id;
            $division = QMSDivision::find($data->division_id);
            $division_name = $division->name;
        }
        elseif ($type == "Global Change Control") {
            $data = GlobalChangeControl::find($id);
            $single = "global-cc-single-pdf/" . $data->id;
            $family = "#";
            $audit = "global-cc-audit-report/" . $data->id;
            $division = QMSDivision::find($data->division_id);
            $division_name = $division->name;
        }
        elseif ($type == "Control Sample") {
            $data = ControlSample::find($id);
            $single = "#" . $data->id;
            $family = "#";
            $audit = "global-cc-audit-report/" . $data->id;
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
                            <a target="__blank" href="' . $family . '" class="inner-item">' . $type . ' Family Report</a>
                        </div>
                    </div>
                </div>
            </div>';
        $response['html'] = $html;

        return response()->json($response);
    }

    //----------PAginator

    public function paginate($items, $perPage = 100000, $page = null, $options = ['path' => 'mytaskdata'])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

//     public function qmsRecordAnalytics(Request $request)
// {
//     $records = [];
//     $process = $request->process;

//     $stages = [
//         'CAPA' => [
//             ['stage' => 'Opened', 'days' => 10],
//             ['stage' => 'HOD Review', 'days' => 20],
//             ['stage' => 'QA/CQA Review', 'days' => 30],
//             ['stage' => 'QA/CQA Approval', 'days' => 10],
//             ['stage' => 'CAPA In progress', 'days' => 10],
//             ['stage' => 'HOD Final Review', 'days' => 10],
//             ['stage' => 'QA/CQA Closure Review', 'days' => 10],
//             ['stage' => 'QAH/CQAH Approval', 'days' => 10],
//             ['stage' => 'Closed - Done', 'days' => 10],

//         ],
//         'Change Control' => [
//             ['stage' => 'Opened', 'days' => 10],
//             ['stage' => 'HOD Assessment', 'days' => 15],
//             ['stage' => 'QA/CQA Initial Assessment', 'days' => 25],
//             ['stage' => 'CFT Assessment', 'days' => 35],
//             ['stage' => 'QA/CQA Final Review', 'days' => 10],
//             ['stage' => 'Pending RA Approval', 'days' => 10],
//             ['stage' => 'QA/CQA Head/Manager Designee Approval', 'days' => 10],
//             ['stage' => 'Pending Initiator Update', 'days' => 10],
//             ['stage' => 'HOD Final Review', 'days' => 10],
//             ['stage' => 'Implementation Verification by QA/CQA', 'days' => 10],
//             ['stage' => 'QA/CQA Closure Approval', 'days' => 10],
//             ['stage' => 'Closed - Done', 'days' => 10],

//         ],
//         'LabIncident' => [
//             ['stage' => 'Stage 1', 'days' => 12],
//             ['stage' => 'Stage 2', 'days' => 22],
//             ['stage' => 'Stage 3', 'days' => 32]
//         ],
//     ];

//     if ($process) {
//         switch ($process) {
//             case 'CAPA':
//                 $query = Capa::query();
//                 break;

//             case 'Change Control':
//                 $query = CC::query();
//                 break;

//             case 'LabIncident':
//                 $query = LabIncident::query();
//                 break;

//             default:
//                 $query = null;
//                 break;
//         }

//         if ($query) {
//             if ($request->has('initiator') && $request->initiator) {
//                 $query->where('initiator_id', $request->initiator);
//             }
//             if ($request->has('startDate') && $request->has('endDate') && $request->startDate && $request->endDate) {
//                 $query->whereBetween('created_at', [$request->startDate, $request->endDate]);
//             }
//             $records = $query->get();
//         }
//     }

//     return view('frontend.rcms.QMSRecordAnalytics', compact('records', 'stages', 'process'));
// }


    public function qmsRecordAnalytics(Request $request)
    {
        $records = [];
        $process = $request->process;

        $fieldMappings = [
            'Change Control' => [
                'Opened' => ['start' => 'created_at', 'end' => 'submit_on'],
                'HOD Assessment' => ['start' => 'submit_on', 'end' => 'hod_review_on'],
                'QA/CQA Initial Assessment' => ['start' => 'hod_review_on', 'end' => 'QA_initial_review_on'],
                'CFT Assessment' => ['start' => 'QA_initial_review_on', 'end' => 'cft_review_on'],
                'QA/CQA Final Review' => ['start' => 'cft_review_on', 'end' => 'QA_final_review_on'],
                'Pending RA Approval' => ['start' => 'QA_final_review_on', 'end' => 'pending_RA_review_on'],
                'QA/CQA Head/Manager Designee Approval' => ['start' => 'pending_RA_review_on', 'end' => 'QA_head_approval_on'],
                'Pending Initiator Update' => ['start' => 'QA_head_approval_on', 'end' => 'initiator_update_complete_on'],
                'HOD Final Review' => ['start' => 'initiator_update_complete_on', 'end' => 'HOD_finalReview_complete_on'],
                'Implementation Verification by QA/CQA' => ['start' => 'initiator_update_complete_on', 'end' => 'closure_approved_on'],
                'QA/CQA Closure Approval' => ['start' => 'closure_approved_on', 'end' => 'closure_approved_on'],
            ],

            'CAPA' => [
                'Opened' => ['start' => 'created_at', 'end' => 'plan_proposed_on'],
                'HOD Review' => ['start' => 'plan_proposed_on', 'end' => 'hod_review_completed_on'],
                'QA/CQA Review' => ['start' => 'hod_review_completed_on', 'end' => 'qa_review_completed_on'],
                'QA/CQA Approval' => ['start' => 'qa_review_completed_on', 'end' => 'approved_on'],
                'CAPA In progress' => ['start' => 'approved_on', 'end' => 'completed_on'],
                'HOD Final Review' => ['start' => 'completed_on', 'end' => 'hod_final_review_completed_on'],
                'QA/CQA Closure Review' => ['start' => 'hod_final_review_completed_on', 'end' => 'qa_closure_review_completed_on'],
                'QAH/CQAH Approval' => ['start' => 'qa_closure_review_completed_on', 'end' => 'qah_approval_completed_on'],
                'Closed - Done' => ['start' => 'qah_approval_completed_on', 'end' => 'qah_approval_completed_on'],
            ],

            'Deviation' => [
                'Opened' => ['start' => 'created_at', 'end' => 'submit_on'],
                'HOD Review' => ['start' => 'submit_on', 'end' => 'hod_review_completed_on'],
                'QA Initial Review' => ['start' => 'hod_review_completed_on', 'end' => 'QA_Initial_Review_Complete_On'],
                'CFT Review' => ['start' => 'QA_Initial_Review_Complete_On', 'end' => 'CFT_Review_Complete_On'],
                'QA Final Review' => ['start' => 'CFT_Review_Complete_On', 'end' => 'QA_Final_Review_Complete_On'],
                'QA Head/Manager Designee Approval' => ['start' => 'QA_Final_Review_Complete_On', 'end' => 'QA_head_approved_on'],
                'Pending Initiator Update' => ['start' => 'QA_head_approved_on', 'end' => 'pending_initiator_approved_on'],
                'QA Final Approval' => ['start' => 'pending_initiator_approved_on', 'end' => 'QA_final_approved_on'],
                'Closed - Done' => ['start' => 'QA_final_approved_on', 'end' => 'QA_final_approved_on'],
            ],

            'Lab Incident' => [
                'Opened' => ['start' => 'created_at', 'end' => 'submitted_on'],
                'Pending Incident Verification' => ['start' => 'submitted_on', 'end' => 'verification_completed_on'],
                'Pending Preliminary Investigation' => ['start' => 'verification_completed_on', 'end' => 'preliminary_completed_on'],
                'Evaluation of Finding' => ['start' => 'preliminary_completed_on', 'end' => 'all_activities_completed_on'],
                'Pending Solution & Sample Test' => ['start' => 'all_activities_completed_on', 'end' => 'no_assignable_cause_on'],
                'Pending Extended Investigation' => ['start' => 'no_assignable_cause_on', 'end' => 'review_completed_on'],
                'CAPA Initiation & Approval' => ['start' => 'review_completed_on', 'end' => 'extended_inv_complete_on'],
                'Final QA/Head Assessment' => ['start' => 'extended_inv_complete_on', 'end' => 'assesment_completed_on'],
                'Pending Approval' => ['start' => 'assesment_completed_on', 'end' => 'closure_completed_on'],
                'Closed - Done' => ['start' => 'closure_completed_on', 'end' => 'closure_completed_on'],
            ],

            'Incident' => [
                'Opened' => ['start' => 'created_at', 'end' => 'submit_on'],
                'HOD Review' => ['start' => 'submit_on', 'end' => 'HOD_Review_Complete_On'],
                'QA Initial Review' => ['start' => 'HOD_Review_Complete_On', 'end' => 'QA_Initial_Review_Complete_On'],
                'CFT Review' => ['start' => 'QA_Initial_Review_Complete_On', 'end' => 'CFT_Review_Complete_On'],
                'QA Final Review' => ['start' => 'CFT_Review_Complete_On', 'end' => 'QA_Final_Review_Complete_On'],
                'QA Head/Manager Designee Approval' => ['start' => 'QA_Final_Review_Complete_On', 'end' => 'QA_head_approved_on'],
                'Pending Initiator Update' => ['start' => 'QA_head_approved_on', 'end' => 'pending_initiator_approved_on'],
                'QA Final Approval' => ['start' => 'pending_initiator_approved_on', 'end' => 'QA_final_approved_on'],
                'Closed - Done' => ['start' => 'QA_final_approved_on', 'end' => 'QA_final_approved_on'],
            ],

            'Action Item' => [
                'Opened' => ['start' => 'created_at', 'end' => 'submitted_on'],
                'Acknowledge' => ['start' => 'submitted_on', 'end' => 'acknowledgement_on'],
                'Work Completion' => ['start' => 'acknowledgement_on', 'end' => 'work_completion_on'],
                'QA/CQA Verification' => ['start' => 'work_completion_on', 'end' => 'qa_varification_on'],
                'Closed - Done' => ['start' => 'qa_varification_on', 'end' => 'qa_varification_on'],
            ],

            'RCA' => [
                'Opened' => ['start' => 'created_at', 'end' => 'acknowledge_on'],
                'HOD Review' => ['start' => 'acknowledge_on', 'end' => 'HOD_Review_Complete_On'],
                'Initial QA/CQA Review' => ['start' => 'HOD_Review_Complete_On', 'end' => 'QQQA_Review_Complete_On'],
                'Investigation in Progress' => ['start' => 'QQQA_Review_Complete_On', 'end' => 'submitted_on'],
                'HOD Final Review' => ['start' => 'submitted_on', 'end' => 'HOD_Final_Review_Complete_On'],
                'Final QA/CQA Review' => ['start' => 'HOD_Final_Review_Complete_On', 'end' => 'Final_QA_Review_Complete_On'],
                'QAH/CQAH Final Review' => ['start' => 'Final_QA_Review_Complete_On', 'end' => 'evaluation_complete_on'],
                'Closed - Done' => ['start' => 'evaluation_complete_on', 'end' => 'evaluation_complete_on'],
            ],

            'Risk Assessment' => [
                'Opened' => ['start' => 'created_at', 'end' => 'submitted_on'],
                'Risk Analysis & Work Group Assignment' => ['start' => 'submitted_on', 'end' => 'evaluated_on'],
                'Risk Processing & Action Plan' => ['start' => 'evaluated_on', 'end' => 'plan_complete_on'],
                'Pending HOD Approval' => ['start' => 'plan_complete_on', 'end' => 'plan_approved_on'],
                'Actions Items in Progress' => ['start' => 'plan_approved_on', 'end' => 'actions_completed_on'],
                'Residual Risk Evaluation' => ['start' => 'actions_completed_on', 'end' => 'risk_analysis_completed_on'],
                'Closed - Done' => ['start' => 'risk_analysis_completed_on', 'end' => 'risk_analysis_completed_on'],
            ],

            'External Audit' => [
                'Opened' => ['start' => 'created_at', 'end' => 'audit_schedule_on'],
                'Audit Preparation' => ['start' => 'audit_schedule_on', 'end' => 'audit_preparation_completed_on'],
                'Pending Audit' => ['start' => 'audit_preparation_completed_on', 'end' => 'audit_mgr_more_info_reqd_on'],
                'Pending Response' => ['start' => 'audit_mgr_more_info_reqd_on', 'end' => 'audit_observation_submitted_on'],
                'CAPA Execution in Progress' => ['start' => 'audit_observation_submitted_on', 'end' => 'audit_response_completed_on'],
                'Closed - Done' => ['start' => 'audit_response_completed_on', 'end' => 'audit_response_completed_on'],
            ],

            // 'Internal Audit' => [
            //     'Opened' => ['start' => 'created_at', 'end' => 'audit_schedule_on'],
            //     'Audit Preparation' => ['start' => 'audit_schedule_on', 'end' => 'audit_preparation_completed_on'],
            //     'Pending Audit' => ['start' => 'audit_preparation_completed_on', 'end' => 'audit_mgr_more_info_reqd_on'],
            //     'Pending Response' => ['start' => 'audit_mgr_more_info_reqd_on', 'end' => 'audit_observation_submitted_on'],
            //     'CAPA Execution in Progress' => ['start' => 'audit_observation_submitted_on', 'end' => 'audit_response_completed_on'],
            //     'Closed - Done' => ['start' => 'audit_response_completed_on', 'end' => 'audit_response_completed_on'],
            // ],

            'Audit Program' => [
                'Opened' => ['start' => 'created_at', 'end' => 'submitted_on'],
                'Pending Approval' => ['start' => 'submitted_on', 'end' => 'approved_on'],
                'Pending Audit' => ['start' => 'approved_on', 'end' => 'Audit_Completed_On'],
                'Closed - Done' => ['start' => 'Audit_Completed_On', 'end' => 'Audit_Completed_On'],
            ],

            'New Document' => [
                'Initiate' => ['start' => 'created_at', 'end' => 'submitted_on'],
                'Pending Draft Creation' => ['start' => 'submitted_on', 'end' => 'approved_on'],
                'HOD Review' => ['start' => 'approved_on', 'end' => 'Audit_Completed_On'],
                'QA Review' => ['start' => 'Audit_Completed_On', 'end' => 'Audit_Completed_On'],
                'Reviewer Review' => ['start' => 'created_at', 'end' => 'audit_schedule_on'],
                'Approver Pending' => ['start' => 'audit_schedule_on', 'end' => 'audit_preparation_completed_on'],
                'Pending-Traning' => ['start' => 'audit_preparation_completed_on', 'end' => 'audit_mgr_more_info_reqd_on'],
                'Traning Started' => ['start' => 'audit_mgr_more_info_reqd_on', 'end' => 'audit_observation_submitted_on'],
                'Traning-Complete' => ['start' => 'audit_observation_submitted_on', 'end' => 'audit_response_completed_on'],
                'Effective' => ['start' => 'audit_observation_submitted_on', 'end' => 'audit_response_completed_on'],
                'Closed - Done' => ['start' => 'audit_response_completed_on', 'end' => 'audit_response_completed_on'],
            ],

            'Effectiveness Check' => [
                'Opened' => ['start' => 'created_at', 'end' => 'submit_on'],
                'Acknowledge' => ['start' => 'submit_on', 'end' => 'work_complition_on'],
                'Work Completion' => ['start' => 'work_complition_on', 'end' => 'effectiveness_check_complete_on'],
                'HOD Review' => ['start' => 'effectiveness_check_complete_on', 'end' => 'hod_review_complete_on'],
                'QA/CQA Review' => ['start' => 'hod_review_complete_on', 'end' => 'effective_approval_complete_on'],
                'Closed - Effective' => ['start' => 'effective_approval_complete_on', 'end' => 'effective_approval_complete_on'],
            ],

            'Complaint Managment' => [
                'Opened' => ['start' => 'created_at', 'end' => 'submitted_on'],
                'Supervisor Review' => ['start' => 'submitted_on', 'end' => 'complete_review_on'],
                'Investigation and Root Cause Analysis' => ['start' => 'complete_review_on', 'end' => 'investigation_completed_on'],
                'CAPA Plan' => ['start' => 'investigation_completed_on', 'end' => 'propose_plan_on'],
                'Pending Approval' => ['start' => 'propose_plan_on', 'end' => 'approve_plan_on'],
                'Pending Actions Completion' => ['start' => 'approve_plan_on', 'end' => 'all_capa_closed_on'],
                'Pending Response Letter' => ['start' => 'all_capa_closed_on', 'end' => 'closed_done_on'],
                'Closed - Done' => ['start' => 'closed_done_on', 'end' => 'closed_done_on'],
            ],

            'Due Date Extension' => [
                'Opened' => ['start' => 'created_at', 'end' => 'submit_on'],
                'In Review' => ['start' => 'submit_on', 'end' => 'submit_on_review'],
                'In Approved' => ['start' => 'submit_on_review', 'end' => 'submit_on_inapproved'],
                'Closed - Reject' => ['start' => 'submit_on_inapproved', 'end' => 'submit_on_inapproved'],
            ],

            'EHS & Environment Sustainability' => [
                'Opened' => ['start' => 'created_at', 'end' => 'Submit_On'],
                'Pending Review' => ['start' => 'Submit_On', 'end' => 'Review_Complete_On'],
                'Pending Investigation' => ['start' => 'Review_Complete_On', 'end' => 'Complete_Investigation_On'],
                'Root Cause and Risk Analysis' => ['start' => 'Complete_Investigation_On', 'end' => 'Analysis_Complete_On'],
                'Pending Action Planning' => ['start' => 'Analysis_Complete_On', 'end' => 'Training_required_on'],
                'Pending Training' => ['start' => 'Training_required_on', 'end' => 'Training_complete_on'],
                'Training Complete' => ['start' => 'Training_complete_on', 'end' => 'Propose_Plan_On'],
                'Pending Approval' => ['start' => 'Propose_Plan_On', 'end' => 'Approve_Plan_On'],
                'CAPA Execution in Progres' => ['start' => 'Approve_Plan_On', 'end' => 'All_CAPA_Closed_On'],
                'Closed - Done' => ['start' => 'All_CAPA_Closed_On', 'end' => 'All_CAPA_Closed_On'],

            ],

            'Equipment/Instrument Lifecycle Management' => [
                'Opened' => ['start' => 'created_at', 'end' => 'submit_on'],
                'Supervisor Review' => ['start' => 'submit_on', 'end' => 'Supervisor_Approval_on'],
                'Pending Qualification' => ['start' => 'Supervisor_Approval_on', 'end' => 'Complete_Qualification_on'],
                'Pending Training' => ['start' => 'Complete_Qualification_on', 'end' => 'Training_required_on'],
                'Training Evalution' => ['start' => 'Training_required_on', 'end' => 'Complete_Training_on'],
                'Pending QA Approval' => ['start' => 'Complete_Training_on', 'end' => 'Take_Out_of_Service_on'],
                'Active Equipment' => ['start' => 'Take_Out_of_Service_on', 'end' => 'Forward_to_Storage_on'],
                'Out of Service' => ['start' => 'Forward_to_Storage_on', 'end' => 'forword_storage_on'],
                'In Storage' => ['start' => 'forword_storage_on', 'end' => 'retire_on'],
                'Closed - Retired' => ['start' => 'retire_on', 'end' => 'retire_on'],
            ],

            'ERRATA' => [
                'Opened' => ['start' => 'created_at', 'end' => 'submitted_on'],
                'Pending Review' => ['start' => 'submitted_on', 'end' => 'review_completed_on'],
                'Pending Correction' => ['start' => 'review_completed_on', 'end' => 'correction_completed_on'],
                'Pending HOD Review' => ['start' => 'correction_completed_on', 'end' => 'hod_review_complete_on'],
                'Pending QA Head Approval' => ['start' => 'hod_review_complete_on', 'end' => 'qa_head_approval_completed_on'],
                'Closed-Done' => ['start' => 'qa_head_approval_completed_on', 'end' => 'qa_head_approval_completed_on'],
            ],

            'Global Change Control' => [
                'Opened' => ['start' => 'created_at', 'end' => 'submit_on'],
                'HOD Assessment' => ['start' => 'submit_on', 'end' => 'hod_review_on'],
                'QA/CQA Initial Assessment' => ['start' => 'hod_review_on', 'end' => 'QA_initial_review_on'],
                'CFT Assessment' => ['start' => 'QA_initial_review_on', 'end' => 'cft_review_on'],
                'QA/CQA Final Review' => ['start' => 'cft_review_on', 'end' => 'QA_final_review_on'],
                'Pending RA Approval' => ['start' => 'QA_final_review_on', 'end' => 'pending_RA_review_on'],
                'QA/CQA Head/Manager Designee Approval' => ['start' => 'pending_RA_review_on', 'end' => 'QA_head_approval_on'],
                'Pending Initiator Update' => ['start' => 'QA_head_approval_on', 'end' => 'initiator_update_complete_on'],
                'HOD Final Review' => ['start' => 'initiator_update_complete_on', 'end' => 'HOD_finalReview_complete_on'],
                'Implementation Verification by QA/CQA' => ['start' => 'initiator_update_complete_on', 'end' => 'closure_approved_on'],
                'QA/CQA Closure Approval' => ['start' => 'closure_approved_on', 'end' => 'closure_approved_on'],
            ],

            'Global CAPA' => [
                'Opened' => ['start' => 'created_at', 'end' => 'plan_proposed_on'],
                'HOD Review' => ['start' => 'plan_proposed_on', 'end' => 'HOD_Review_Complete_On'],
                'QA/CQA Review' => ['start' => 'HOD_Review_Complete_On', 'end' => 'qa_review_completed_on'],
                'QA/CQA Approval' => ['start' => 'qa_review_completed_on', 'end' => 'approved_on'],
                'CAPA In progress' => ['start' => 'approved_on', 'end' => 'completed_on'],
                'HOD Final Review' => ['start' => 'completed_on', 'end' => 'hod_final_review_completed_on'],
                'QA/CQA Closure Review' => ['start' => 'hod_final_review_completed_on', 'end' => 'qa_closure_review_completed_on'],
                'QAH/CQAH Approval' => ['start' => 'qa_closure_review_completed_on', 'end' => 'qah_approval_completed_on'],
                'Closed - Done' => ['start' => 'qah_approval_completed_on', 'end' => 'qah_approval_completed_on'],
            ],

            'Preventive Maintenance' => [
                'Opened' => ['start' => 'created_at', 'end' => 'submit_on'],
                'Supervisor Review' => ['start' => 'submit_on', 'end' => 'Supervisor_Approval_on'],
                'Work in Progress' => ['start' => 'Supervisor_Approval_on', 'end' => 'Complete_on'],
                'Pending QA Approval' => ['start' => 'Complete_on', 'end' => 'qa_approval_on'],
                'Closed-Done' => ['start' => 'qa_approval_on', 'end' => 'qa_approval_on'],
            ],

            'Meeting' => [
                'Opened' => ['start' => 'created_at', 'end' => 'submitted_on'],
                'In Progress' => ['start' => 'submitted_on', 'end' => 'complete_on'],
                'Closed-Done' => ['start' => 'complete_on', 'end' => 'complete_on'],
            ],

            'Sanction' => [
                'Opened' => ['start' => 'created_at', 'end' => 'Cancel_On'],
                'Closed' => ['start' => 'Cancel_On', 'end' => 'Cancel_On'],
            ],

            'Supllier' => [
                'Opened' => ['start' => 'created_at', 'end' => 'submitted_on'],
                'Pending Initiating Department Update' => ['start' => 'submitted_on', 'end' => 'request_justified_on'],
                'Pending Update FROM CQA' => ['start' => 'request_justified_on', 'end' => 'prepurchase_sample_on'],
                'Pending Purchase Sample Request' => ['start' => 'prepurchase_sample_on', 'end' => 'pendigPurchaseSampleRequested_on'],
                'Pending CQA Review After Purchase Sample Request' => ['start' => 'pendigPurchaseSampleRequested_on', 'end' => 'purchaseSampleanalysis_on'],
                'Pending F&D Review' => ['start' => 'purchaseSampleanalysis_on', 'end' => 'FdReviewCompleted_on'],
                'Pending Acknowledgement By Purchase Department' => ['start' => 'FdReviewCompleted_on', 'end' => 'acknowledgByPD_on'],
                'Pending CQA Final Review' => ['start' => 'acknowledgByPD_on', 'end' => 'requirementFullfilled_on'],
                'Pending Manufacturer Risk Assessment' => ['start' => 'requirementFullfilled_on', 'end' => 'riskRatingObservedAsHigh_on'],
                'Pending Manufacturer Audit' => ['start' => 'riskRatingObservedAsHigh_on', 'end' => 'manufacturerAuditPassed_on'],
                'Approved Manufacturer/Supplier' => ['start' => 'manufacturerAuditPassed_on', 'end' => 'periodicRevolutionInitiated_on'],
                'Pending Manufacturer Risk Assessment' => ['start' => 'periodicRevolutionInitiated_on', 'end' => 'riskRatingObservedAsHighMedium_on'],
                'Pending Manufacturer Audit' => ['start' => 'riskRatingObservedAsHighMedium_on', 'end' => 'riskRatingObservedAsHighMedium_on'],
            ],



        ];

        if ($process) {
            switch ($process) {
                case 'CAPA':
                    $query = Capa::query();
                    break;
                case 'Change Control':
                    $query = CC::query();
                    break;
                case 'Deviation':
                    $query = Deviation::query();
                    break;    
                case 'Lab Incident':
                    $query = LabIncident::query();
                    break;
                case 'Action Item':
                    $query = ActionItem::query();
                    break;
                case 'RCA':
                    $query = RootCauseAnalysis::query();
                    break;
                case 'Risk Assessment':
                    $query = RiskManagement::query();
                    break;
                case 'External Audit':
                    $query = Auditee::query();
                    break;
                case 'Internal Audit':
                    $query = InternalAudit::query();
                    break;
                case 'Audit Program':
                    $query = AuditProgram::query();
                    break;
                case 'New Document':
                    $query = Document::query();
                    break;
                case 'Effectiveness Check':
                    $query = EffectivenessCheck::query();
                    break;
                case 'Complaint Managment':
                    $query = MarketComplaint::query();
                    break;

                case 'Due Date Extension':
                    $query = extension_new::query();
                    break;

                case 'EHS & Environment Sustainability':
                    $query = EHSEvent::query();
                    break;
                        
                case 'Equipment/Instrument Lifecycle Management':
                    $query = EquipmentLifecycleManagement::query();
                    break;

                case 'ERRATA':
                    $query = errata::query();
                    break;

                case 'Global CAPA':
                    $query = Capa::query();
                    break;

                case 'Global Change Control':
                    $query = CC::query();
                    break;

                case 'Incident':
                    $query = Incident::query();
                    break;

                case 'Meeting':
                    $query = Meeting::query();
                    break;

                case 'Preventive Maintenance':
                    $query = PreventiveMaintenance::query();
                    break;

                case 'Sanction':
                    $query = Sanction::query();
                    break;

                case 'Supllier':
                    $query = Supplier::query();
                    break;

                case 'Supllier Audit':
                    $query = SupplierAudit::query();
                    break;
    
                default:
                    $query = null;
                    break;
            }

            if ($query) {
                if ($request->has('initiator') && $request->initiator) {
                    $query->where('initiator_id', $request->initiator);
                }
                if ($request->has('startDate') && $request->has('endDate') && $request->startDate && $request->endDate) {
                    $query->whereBetween('created_at', [$request->startDate, $request->endDate]);
                }
                $records = $query->get();

                foreach ($records as $record) {
                    $stageDurations = [];
                    foreach ($fieldMappings[$process] as $stage => $fields) {
                        $start = $record->{$fields['start']} ?? null;
                        $end = $record->{$fields['end']} ?? null;
                
                        if ($start && $end) {
                            $daysDifference = \Carbon\Carbon::parse($start)->diffInDays(\Carbon\Carbon::parse($end));
                            $stageDurations[] = [
                                'stage' => $stage,
                                'days' => $daysDifference,
                            ];
                        } else {
                            $stageDurations[] = [
                                'stage' => $stage,
                                'days' => null,
                            ];
                        }
                    }
                    // Include the active stage from the 'stage' column
                    $record->active_stage_number = $record->stage ?? null; // Assuming 'stage' holds the active stage
                    $record->active_stage = $record->status ?? null; // Assuming 'stage' holds the active stage
                    $record->stage_durations = $stageDurations;
                    // dd($record->active_stage);
                }
                
            }
        }

        return view('frontend.rcms.QMSRecordAnalytics', compact('records', 'process'));
    }


    
    
    
}
