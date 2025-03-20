<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ActionItem;
use App\Models\CC;
use App\Models\AuditProgram;
use App\Models\CallibrationDetails;
use App\Models\Capa;
use App\Models\Deviation;
use App\Models\Document;
use App\Models\EffectivenessCheck;
use App\Models\EquipmentLifecycleManagement;
use App\Models\Errata;
use App\Models\extension_new;
use App\Models\ExternalAudit;
use App\Models\GlobalChangeControl;
use App\Models\Incident;
use App\Models\InternalAudit;
use App\Models\GlobalCapa;
use App\Models\LabIncident;
use App\Models\MarketComplaint;
use App\Models\OOS;
use App\Models\PreventiveMaintenance;
use App\Models\Process;
use App\Models\QMSDivision;
use App\Models\RiskManagement;
use App\Models\RootCauseAnalysis;
use App\Models\Ootc;
use App\Models\Supplier;
use App\Models\SupplierAudit;
use App\Models\User;
use Carbon\Carbon;
use Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;

class ChartController extends Controller
{
    public function process_charts()
    {
        $res = Helpers::getDefaultResponse();

        try {

            $modelClasses = [
                \App\Models\Extension::class,
                \App\Models\ActionItem::class,
                \App\Models\Observation::class,
                \App\Models\RootCauseAnalysis::class,
                \App\Models\RiskAssessment::class,
                \App\Models\ManagementReview::class,
                \App\Models\InternalAudit::class,
                \App\Models\AuditProgram::class,
                // \App\Models\CAPA::class,
                \App\Models\CC::class,
                \App\Models\Document::class,
                \App\Models\LabIncident::class,
                \App\Models\EffectivenessCheck::class,
                \App\Models\OOS::class,
                \App\Models\OOT::class,
                \App\Models\Ootc::class,
                \App\Models\Deviation::class,
                \App\Models\MarketComplaint::class,
                // \App\Models\NonConformance::class,
                \App\Models\FailureInvestigation::class,
                // \App\Models\ERRATA::class,
                // \App\Models\OOS_micro::class
            ];

            $count= [];

            foreach ($modelClasses as $modelClass) {
                array_push($counts, [
                    'classname' => class_basename($modelClass),
                    'count' => self::getProcessCount($modelClass)
                ]);
            }

            $counts = collect($counts)->filter(function ($count) {
                return $count['count'] > 0;
            });


            $res['body'] = $counts->all();


        } catch (\Exception $e) {
            $res['status'] = 'error';
            $res['message'] = $e->getMessage();
        }

        return response()->json($res);
    }

    public function document_status_charts()
    {
        $res = Helpers::getDefaultResponse();

        try {

            $counts = [
                'Draft' => 0,
                'In-HOD Review' => 0,
                'HOD Review Complete' => 0,
                'In-Review' => 0,
                'Reviewed' => 0,
                'For-Approval' => 0,
                'Approved' => 0,
                'Pending-Traning' => 0,
                'Traning-Complete' => 0,
                'Effective' => 0,
                'Obsolete' => 0,
            ];

            foreach ($counts as $status => $count) {
                $documents_count = Document::where('status', $status)->get()->count();

                $counts[$status] = $documents_count;
            }

            $res['body'] = $counts;


        } catch (\Exception $e) {
            $res['status'] = 'error';
            $res['message'] = $e->getMessage();
        }

        return response()->json($res);
    }

    public function overdue_records_by_process_chart()
    {
        $res = Helpers::getDefaultResponse();

        try {
            $overdueCounts = []; // To store the overdue count for each process
            $currentDate = now()->format('d-m-Y');
            $processTables = [
                'Action Item' => ActionItem::class,
                'Audit Program' => AuditProgram::class,
                'CAPA' => Capa::class,
                'Calibration Management' => CallibrationDetails::class,
                'Change Control' => CC::class,
                // 'Complaint Management' => MarketComplaint::class,
                'Deviation' => Deviation::class,
                // 'Due Date Extension' => extension_new::class,
                'Effectiveness Check' => EffectivenessCheck::class,
                'Equiment Lifecycle Management' => EquipmentLifecycleManagement::class,
                // 'ERRATA' => Errata::class,
                // 'External Audit' => ExternalAudit::class,
                'Global CAPA' => Capa::class,
                'Global Change Control' => CC::class,
                'Incident' => Incident::class,
                'Internal Audit' => InternalAudit::class,
                'Lab Incident' => LabIncident::class,
                // 'New Document' => Document::class,
                'OOS/OOT' => OOS::class,
                'Preventive Maintenance' => PreventiveMaintenance::class,
                'Risk Assessment' => RiskManagement::class,
                'Root Cause Analysis' => RootCauseAnalysis::class,
                'Supplier' => Supplier::class,
                'Supplier Audit' => SupplierAudit::class,
            ];

            foreach ($processTables as $processName => $model) {
                $overdueCount = 0;    
                foreach ($model::get() as $entryRecord) {
                    $recordDueDate = \Carbon\Carbon::parse($entryRecord->due_date);
                    $currentDate = \Carbon\Carbon::now();
                    if ($recordDueDate->lessThan($currentDate)) {
                        $overdueCount++;
                    }
                }
                $overdueCounts[$processName] = $overdueCount; // Store the count
            }

            $res['body'] = $overdueCounts;

        } catch (\Exception $e) {
            $res['status'] = 'error';
            $res['message'] = $e->getMessage();
        }

        return response()->json($res);
    }



    public function deviation_classification_charts()
    {
        $res = Helpers::getDefaultResponse();

        try {

            $data = [];

            for ($i = 5; $i >= 0; $i--) {
                $monthly_data = [];
                $month = Carbon::now()->subMonths($i);

                $minor_deviations = Deviation::where('deviations', 'minor')
                    ->whereDate('created_at', '>=', $month->startOfMonth())
                    ->whereDate('created_at', '<=', $month->endOfMonth())
                    ->get()->count();
                $major_deviations = Deviation::where('deviations', 'major')
                    ->whereDate('created_at', '>=', $month->startOfMonth())
                    ->whereDate('created_at', '<=', $month->endOfMonth())
                    ->get()->count();
                $critical_deviations = Deviation::where('deviations', 'critical')
                    ->whereDate('created_at', '>=', $month->startOfMonth())
                    ->whereDate('created_at', '<=', $month->endOfMonth())
                    ->get()->count();


                $monthly_data['month'] = $month->format('M');
                $monthly_data['minor'] = $minor_deviations;
                $monthly_data['major'] = $major_deviations;
                $monthly_data['critical'] = $critical_deviations;

                array_push($data, $monthly_data);

            }

            $res['body'] = $data;

        } catch (\Exception $e) {
            $res['status'] = 'error';
            $res['message'] = $e->getMessage();
        }

        return response()->json($res);
    }

    public function deviation_departments_charts()
    {
        $res = Helpers::getDefaultResponse();

        try {

            $departments = ["CQA", "QAB", "CQC", "MANU", "PSG", "CS", "ITG", "MM", "CL", "TT", "QA", "QM", "IA", "ACC", "LOG", "SM", "BA"];

            $data = [];

            for ($i = 5; $i >= 0; $i--) {
                $monthly_data = [];
                $month = Carbon::now()->subMonths($i);

                foreach ($departments as $department) {
                    $deviations = Deviation::where('Initiator_Group', $department)
                        ->whereDate('created_at', '>=', $month->startOfMonth())
                        ->whereDate('created_at', '<=', $month->endOfMonth())
                        ->get()->count();

                    $data[$department][$month->format('F')] = $deviations;
                }

            }


            $res['body'] = $data;

        } catch (\Exception $e) {
            $res['status'] = 'error';
            $res['message'] = $e->getMessage();
        }

        return response()->json($res);
    }

    public function documents_originator_charts()
    {
        $res = Helpers::getDefaultResponse();

        try {

            $data = Document::join('users', 'documents.originator_id', '=', 'users.id')
                ->select('documents.originator_id', 'users.name as originator_name', DB::raw('count(*) as document_count'))
                ->groupBy('documents.originator_id', 'users.name')
                ->get();

            $res['body'] = $data;

        } catch (\Exception $e) {
            $res['status'] = 'error';
            $res['message'] = $e->getMessage();
        }

        return response()->json($res);
    }

    public function documents_type_charts()
    {
        $res = Helpers::getDefaultResponse();

        try {

            $data = Document::join('document_types', 'documents.document_type_id', '=', 'document_types.id')
                ->select('document_types.name as document_type_name', DB::raw('count(documents.id) as document_count'))
                ->groupBy('document_types.id', 'document_types.name')
                ->get();

            $res['body'] = $data;

        } catch (\Exception $e) {
            $res['status'] = 'error';
            $res['message'] = $e->getMessage();
        }

        return response()->json($res);
    }

    public function documents_review_charts($months)
    {
        $res = Helpers::getDefaultResponse();

        try {

            $today = Carbon::today();
            $monthsLater = $today->copy()->addMonths($months);

            $data = Document::where('next_review_date', '>=', $today)
                ->where('next_review_date', '<=', $monthsLater)
                ->get();

            $res['body'] = $data;

        } catch (\Exception $e) {
            $res['status'] = 'error';
            $res['message'] = $e->getMessage();
        }

        return response()->json($res);
    }

    public function documents_stage_charts($stage)
    {
        $res = Helpers::getDefaultResponse();

        try {

            // $data = Document::where('next_review_date', '>=', $today)
            //     ->where('next_review_date', '<=', $monthsLater)
            //     ->get();

            // $res['body'] = $data;

        } catch (\Exception $e) {
            $res['status'] = 'error';
            $res['message'] = $e->getMessage();
        }

        return response()->json($res);
    }

    public function document_pending_review_charts()
    {
        $res = Helpers::getDefaultResponse();

        try {

            $data = [];

            $pending_review_documents = Document::where('status', 'In-Review')->get();

            foreach ($pending_review_documents as $document) {
                if ($document->reviewers) {
                    $reviewers = explode(',', $document->reviewers);

                    foreach ($reviewers as $reviewer) {

                        $reviewer_name = User::find($reviewer) ? User::find($reviewer)->name : 'NULL';

                        $data[$reviewer_name] = isset($data[$reviewer_name]) ? $data[$reviewer_name] + 1 : 1;
                    }

                }
            }

            $res['body'] = $data;

        } catch (\Exception $e) {
            $res['status'] = 'error';
            $res['message'] = $e->getMessage();
        }

        return response()->json($res);
    }

    public function document_pending_approve_charts()
    {
        $res = Helpers::getDefaultResponse();

        try {

            $data = [];

            $pending_approve_documents = Document::where('status', 'For-Approval')->get();

            foreach ($pending_approve_documents as $document) {
                if ($document->approvers) {
                    $approvers = explode(',', $document->approvers);

                    foreach ($approvers as $approver) {

                        $approver_name = User::find($approver) ? User::find($approver)->name : 'NULL';

                        $data[$approver_name] = isset($data[$approver_name]) ? $data[$approver_name] + 1 : 1;
                    }

                }
            }

            $res['body'] = $data;

        } catch (\Exception $e) {
            $res['status'] = 'error';
            $res['message'] = $e->getMessage();
        }

        return response()->json($res);
    }

    public function document_pending_hod_charts()
    {
        $res = Helpers::getDefaultResponse();

        try {

            $data = [];

            $pending_hod_documents = Document::where('status', 'In-HOD Review')->get();

            foreach ($pending_hod_documents as $document) {
                if ($document->hods) {
                    $hods = explode(',', $document->hods);

                    foreach ($hods as $hod) {

                        $hod_name = User::find($hod) ? User::find($hod)->name : 'NULL';

                        $data[$hod_name] = isset($data[$hod_name]) ? $data[$hod_name] + 1 : 1;
                    }

                }
            }

            $res['body'] = $data;

        } catch (\Exception $e) {
            $res['status'] = 'error';
            $res['message'] = $e->getMessage();
        }

        return response()->json($res);
    }

    public function document_pending_training_charts()
    {
        $res = Helpers::getDefaultResponse();

        try {

            $data = [];

            $pending_training_documents = Document::where('status', 'Pending-Traning')->get();

            foreach ($pending_training_documents as $document) {
                if ($document->trainer) {
                    $trainers = explode(',', $document->trainer);

                    foreach ($trainers as $trainer) {

                        $trainer_name = User::find($trainer) ? User::find($trainer)->name : 'NULL';

                        $data[$trainer_name] = isset($data[$trainer_name]) ? $data[$trainer_name] + 1 : 1;
                    }

                }
            }

            $res['body'] = $data;

        } catch (\Exception $e) {
            $res['status'] = 'error';
            $res['message'] = $e->getMessage();
        }

        return response()->json($res);
    }

    public function deviationSeverityLevel()
    {
        $res = Helpers::getDefaultResponse();

        try {

            $data = [];

            for ($i = 5; $i >= 0; $i--) {
                $monthly_data = [];
                $month = Carbon::now()->subMonths($i);

                $negligible_deviations = Deviation::where('severity_rate', 'negligible')
                    ->whereDate('created_at', '>=', $month->startOfMonth())
                    ->whereDate('created_at', '<=', $month->endOfMonth())
                    ->get()->count();
                $moderate_deviations = Deviation::where('severity_rate', 'moderate')
                    ->whereDate('created_at', '>=', $month->startOfMonth())
                    ->whereDate('created_at', '<=', $month->endOfMonth())
                    ->get()->count();
                $major_deviations = Deviation::where('severity_rate', 'major')
                    ->whereDate('created_at', '>=', $month->startOfMonth())
                    ->whereDate('created_at', '<=', $month->endOfMonth())
                    ->get()->count();
                $fatal_deviations = Deviation::where('severity_rate', 'fatal')
                    ->whereDate('created_at', '>=', $month->startOfMonth())
                    ->whereDate('created_at', '<=', $month->endOfMonth())
                    ->get()->count();


                $monthly_data['month'] = $month->format('M');
                $monthly_data['negligible'] = $negligible_deviations;
                $monthly_data['moderate'] = $moderate_deviations;
                $monthly_data['major'] = $major_deviations;
                $monthly_data['fatal'] = $fatal_deviations;

                array_push($data, $monthly_data);

            }

            $res['body'] = $data;

        } catch (\Exception $e) {
            $res['status'] = 'error';
            $res['message'] = $e->getMessage();
        }

        return response()->json($res);
    }

    public function documentByPriority()
    {
        $res = Helpers::getDefaultResponse();

        try {

            $data = [];

            for ($i = 5; $i >= 0; $i--) {
                $monthly_data = [];
                $month = Carbon::now()->subMonths($i);

                $low_priority = RiskManagement::where('priority_level', 'low')
                    ->whereDate('created_at', '>=', $month->startOfMonth())
                    ->whereDate('created_at', '<=', $month->endOfMonth())
                    ->get()->count();
                $medium_priority = RiskManagement::where('priority_level', 'medium')
                    ->whereDate('created_at', '>=', $month->startOfMonth())
                    ->whereDate('created_at', '<=', $month->endOfMonth())
                    ->get()->count();
                $high_priority = RiskManagement::where('priority_level', 'high')
                    ->whereDate('created_at', '>=', $month->startOfMonth())
                    ->whereDate('created_at', '<=', $month->endOfMonth())
                    ->get()->count();


                $monthly_data['month'] = $month->format('M');
                $monthly_data['low'] = $low_priority;
                $monthly_data['medium'] = $medium_priority;
                $monthly_data['high'] = $high_priority;

                array_push($data, $monthly_data);

            }

            $res['body'] = $data;

        } catch (\Exception $e) {
            $res['status'] = 'error';
            $res['message'] = $e->getMessage();
        }

        return response()->json($res);
    }

    public function documentByPriorityDeviation()
    {
        $res = Helpers::getDefaultResponse();

        try {

            $data = [];

            for ($i = 5; $i >= 0; $i--) {
                $monthly_data = [];
                $month = Carbon::now()->subMonths($i);

                $low_priority = Deviation::where('priority_data', 'low')
                    ->whereDate('created_at', '>=', $month->startOfMonth())
                    ->whereDate('created_at', '<=', $month->endOfMonth())
                    ->get()->count();
                $medium_priority = Deviation::where('priority_data', 'medium')
                    ->whereDate('created_at', '>=', $month->startOfMonth())
                    ->whereDate('created_at', '<=', $month->endOfMonth())
                    ->get()->count();
                $high_priority = Deviation::where('priority_data', 'high')
                    ->whereDate('created_at', '>=', $month->startOfMonth())
                    ->whereDate('created_at', '<=', $month->endOfMonth())
                    ->get()->count();


                $monthly_data['month'] = $month->format('M');
                $monthly_data['low'] = $low_priority;
                $monthly_data['medium'] = $medium_priority;
                $monthly_data['high'] = $high_priority;

                array_push($data, $monthly_data);

            }

            $res['body'] = $data;

        } catch (\Exception $e) {
            $res['status'] = 'error';
            $res['message'] = $e->getMessage();
        }

        return response()->json($res);
    }

    public function documentByPriorityChangeControl()
    {
        $res = Helpers::getDefaultResponse();

        try {

            $data = [];

            for ($i = 5; $i >= 0; $i--) {
                $monthly_data = [];
                $month = Carbon::now()->subMonths($i);

                $low_priority = CC::where('priority_data', 'low')
                    ->whereDate('created_at', '>=', $month->startOfMonth())
                    ->whereDate('created_at', '<=', $month->endOfMonth())
                    ->get()->count();
                $medium_priority = CC::where('priority_data', 'medium')
                    ->whereDate('created_at', '>=', $month->startOfMonth())
                    ->whereDate('created_at', '<=', $month->endOfMonth())
                    ->get()->count();
                $high_priority = CC::where('priority_data', 'high')
                    ->whereDate('created_at', '>=', $month->startOfMonth())
                    ->whereDate('created_at', '<=', $month->endOfMonth())
                    ->get()->count();


                $monthly_data['month'] = $month->format('M');
                $monthly_data['low'] = $low_priority;
                $monthly_data['medium'] = $medium_priority;
                $monthly_data['high'] = $high_priority;

                array_push($data, $monthly_data);

            }

            $res['body'] = $data;

        } catch (\Exception $e) {
            $res['status'] = 'error';
            $res['message'] = $e->getMessage();
        }

        return response()->json($res);
    }

    // ===================Extension =================
    // public function documentByPriorityExtension()
    // {
    //     $res = Helpers::getDefaultResponse();

    //     try {

    //         $data = [];

    //         for ($i = 5; $i >= 0; $i--) {
    //             $monthly_data = [];
    //             $month = Carbon::now()->subMonths($i);

    //             $low_priority = extension_new::where('priority_data', 'Low')
    //                 ->whereDate('created_at', '>=', $month->startOfMonth())
    //                 ->whereDate('created_at', '<=', $month->endOfMonth())
    //                 ->get()->count();
    //             $medium_priority = extension_new::where('priority_data', 'Medium')
    //                 ->whereDate('created_at', '>=', $month->startOfMonth())
    //                 ->whereDate('created_at', '<=', $month->endOfMonth())
    //                 ->get()->count();
    //             $high_priority = extension_new::where('priority_data', 'High')
    //                 ->whereDate('created_at', '>=', $month->startOfMonth())
    //                 ->whereDate('created_at', '<=', $month->endOfMonth())
    //                 ->get()->count();


    //             $monthly_data['month'] = $month->format('M');
    //             $monthly_data['low'] = $low_priority;
    //             $monthly_data['medium'] = $medium_priority;
    //             $monthly_data['high'] = $high_priority;

    //             array_push($data, $monthly_data);

    //         }

    //         $res['body'] = $data;

    //     } catch (\Exception $e) {
    //         $res['status'] = 'error';
    //         $res['message'] = $e->getMessage();
    //     }

    //     return response()->json($res);
    // }


    // public function stageByPriorityExtension(){
    //     try {
    //         $data = DB::table('extension_news')
    //             ->select('status', DB::raw('count(*) as count'))
    //             ->groupBy('status')
    //             ->get();

    //         $response = [
    //             'labels' => $data->pluck('status'),
    //             'series' => $data->pluck('count')
    //         ];

    //         return response()->json([
    //             'status' => 'ok',
    //             'body' => $response
    //         ]);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => $e->getMessage()
    //         ]);
    //     }
    // }
    // =================


    // public function documentByPriorityGlobalChangeControl()
    // {
    //     $res = Helpers::getDefaultResponse();

    //     try {

    //         $data = [];

    //         for ($i = 5; $i >= 0; $i--) {
    //             $monthly_data = [];
    //             $month = Carbon::now()->subMonths($i);

    //             $low_priority = GlobalChangeControl::where('priority_data', 'low')
    //                 ->whereDate('created_at', '>=', $month->startOfMonth())
    //                 ->whereDate('created_at', '<=', $month->endOfMonth())
    //                 ->get()->count();
    //             $medium_priority = GlobalChangeControl::where('priority_data', 'medium')
    //                 ->whereDate('created_at', '>=', $month->startOfMonth())
    //                 ->whereDate('created_at', '<=', $month->endOfMonth())
    //                 ->get()->count();
    //             $high_priority = GlobalChangeControl::where('priority_data', 'high')
    //                 ->whereDate('created_at', '>=', $month->startOfMonth())
    //                 ->whereDate('created_at', '<=', $month->endOfMonth())
    //                 ->get()->count();


    //             $monthly_data['month'] = $month->format('M');
    //             $monthly_data['low'] = $low_priority;
    //             $monthly_data['medium'] = $medium_priority;
    //             $monthly_data['high'] = $high_priority;

    //             array_push($data, $monthly_data);

    //         }

    //         $res['body'] = $data;

    //     } catch (\Exception $e) {
    //         $res['status'] = 'error';
    //         $res['message'] = $e->getMessage();
    //     }

    //     return response()->json($res);
    // }


    public function documentByPriorityGlobalChangeControl()
    {
        $res = Helpers::getDefaultResponse();

        try {

            $data = [];

            for ($i = 5; $i >= 0; $i--) {
                $monthly_data = [];
                $month = Carbon::now()->subMonths($i);

                $low_priority = GlobalChangeControl::where('priority_data', 'low')
                    ->whereDate('created_at', '>=', $month->startOfMonth())
                    ->whereDate('created_at', '<=', $month->endOfMonth())
                    ->get()->count();
                $medium_priority = GlobalChangeControl::where('priority_data', 'medium')
                    ->whereDate('created_at', '>=', $month->startOfMonth())
                    ->whereDate('created_at', '<=', $month->endOfMonth())
                    ->get()->count();
                $high_priority = GlobalChangeControl::where('priority_data', 'high')
                    ->whereDate('created_at', '>=', $month->startOfMonth())
                    ->whereDate('created_at', '<=', $month->endOfMonth())
                    ->get()->count();


                $monthly_data['month'] = $month->format('M');
                $monthly_data['low'] = $low_priority;
                $monthly_data['medium'] = $medium_priority;
                $monthly_data['high'] = $high_priority;

                array_push($data, $monthly_data);

            }

            $res['body'] = $data;

        } catch (\Exception $e) {
            $res['status'] = 'error';
            $res['message'] = $e->getMessage();
        }

        return response()->json($res);
    }

    // ===================Extension =================
    public function documentByPriorityExtension()
    {
        $res = Helpers::getDefaultResponse();

        try {

            $data = [];

            for ($i = 5; $i >= 0; $i--) {
                $monthly_data = [];
                $month = Carbon::now()->subMonths($i);

                $low_priority = extension_new::where('priority_data', 'Low')
                    ->whereDate('created_at', '>=', $month->startOfMonth())
                    ->whereDate('created_at', '<=', $month->endOfMonth())
                    ->get()->count();
                $medium_priority = extension_new::where('priority_data', 'Medium')
                    ->whereDate('created_at', '>=', $month->startOfMonth())
                    ->whereDate('created_at', '<=', $month->endOfMonth())
                    ->get()->count();
                $high_priority = extension_new::where('priority_data', 'High')
                    ->whereDate('created_at', '>=', $month->startOfMonth())
                    ->whereDate('created_at', '<=', $month->endOfMonth())
                    ->get()->count();


                $monthly_data['month'] = $month->format('M');
                $monthly_data['low'] = $low_priority;
                $monthly_data['medium'] = $medium_priority;
                $monthly_data['high'] = $high_priority;

                array_push($data, $monthly_data);

            }

            $res['body'] = $data;

        } catch (\Exception $e) {
            $res['status'] = 'error';
            $res['message'] = $e->getMessage();
        }

        return response()->json($res);
    }


    public function stageByPriorityExtension(){
        try {
            $data = DB::table('extension_news')
                ->select('status', DB::raw('count(*) as count'))
                ->groupBy('status')
                ->get();

            $response = [
                'labels' => $data->pluck('status'),
                'series' => $data->pluck('count')
            ];

            return response()->json([
                'status' => 'ok',
                'body' => $response
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
    // =================

    public function deviationStageDistribution(){
        try {
            $data = DB::table('deviations')
                ->select('status', DB::raw('count(*) as count'))
                ->groupBy('status')
                ->get();

            $response = [
                'labels' => $data->pluck('status'),
                'series' => $data->pluck('count')
            ];

            return response()->json([
                'status' => 'ok',
                'body' => $response
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function changeControlStageDistribution(){
        try {
            $data = DB::table('c_c_s')
                ->select('status', DB::raw('count(*) as count'))
                ->groupBy('status')
                ->get();

            $response = [
                'labels' => $data->pluck('status'),
                'series' => $data->pluck('count')
            ];

            return response()->json([
                'status' => 'ok',
                'body' => $response
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }


    public function globalChangeControlStageDistribution(){
        try {
            $data = DB::table('global_change_controls')
                ->select('status', DB::raw('count(*) as count'))
                ->groupBy('status')
                ->get();

            $response = [
                'labels' => $data->pluck('status'),
                'series' => $data->pluck('count')
            ];

            return response()->json([
                'status' => 'ok',
                'body' => $response
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function documentByPriorityRca()
    {
        $res = Helpers::getDefaultResponse();

        try {

            $data = [];

            for ($i = 5; $i >= 0; $i--) {
                $monthly_data = [];
                $month = Carbon::now()->subMonths($i);

                $low_priority = RootCauseAnalysis::where('priority_level', 'low')
                    ->whereDate('created_at', '>=', $month->startOfMonth())
                    ->whereDate('created_at', '<=', $month->endOfMonth())
                    ->get()->count();
                $medium_priority = RootCauseAnalysis::where('priority_level', 'medium')
                    ->whereDate('created_at', '>=', $month->startOfMonth())
                    ->whereDate('created_at', '<=', $month->endOfMonth())
                    ->get()->count();
                $high_priority = RootCauseAnalysis::where('priority_level', 'high')
                    ->whereDate('created_at', '>=', $month->startOfMonth())
                    ->whereDate('created_at', '<=', $month->endOfMonth())
                    ->get()->count();


                $monthly_data['month'] = $month->format('M');
                $monthly_data['low'] = $low_priority;
                $monthly_data['medium'] = $medium_priority;
                $monthly_data['high'] = $high_priority;

                array_push($data, $monthly_data);

            }

            $res['body'] = $data;

        } catch (\Exception $e) {
            $res['status'] = 'error';
            $res['message'] = $e->getMessage();
        }

        return response()->json($res);
    }

    public function documentDelayed()
    {
        $res = Helpers::getDefaultResponse();

        try {

            $data = [];

            for ($i = 5; $i >= 0; $i--) {
                $monthly_data = [];
                $month = Carbon::now()->subMonths($i);

                $delayedDoc = Deviation::where('stage', '<', 9)
                    ->where('due_date', '<', Carbon::now())
                    ->whereDate('created_at', '>=', $month->startOfMonth())
                    ->whereDate('created_at', '<=', $month->endOfMonth())
                    ->get()->count();

                $onTimeDoc = Deviation::where('stage', '=', 9)
                    ->where('due_date', '<', Carbon::now())
                    ->whereDate('created_at', '>=', $month->startOfMonth())
                    ->whereDate('created_at', '<=', $month->endOfMonth())
                    ->get()->count();

                $monthly_data['month'] = $month->format('M');
                $monthly_data['delayed'] = $delayedDoc;
                $monthly_data['onTime'] = $onTimeDoc;

                array_push($data, $monthly_data);

            }

            $res['body'] = $data;

        } catch (\Exception $e) {
            $res['status'] = 'error';
            $res['message'] = $e->getMessage();
        }

        return response()->json($res);
    }

    public function documentDelayedChangeControl()
    {
        $res = Helpers::getDefaultResponse();

        try {

            $data = [];

            for ($i = 5; $i >= 0; $i--) {
                $monthly_data = [];
                $month = Carbon::now()->subMonths($i);

                $delayedDoc = CC::where('stage', '<', 9)
                    ->where('due_date', '<', Carbon::now())
                    ->whereDate('created_at', '>=', $month->startOfMonth())
                    ->whereDate('created_at', '<=', $month->endOfMonth())
                    ->get()->count();

                $onTimeDoc = CC::where('stage', '=', 9)
                    ->where('due_date', '<', Carbon::now())
                    ->whereDate('created_at', '>=', $month->startOfMonth())
                    ->whereDate('created_at', '<=', $month->endOfMonth())
                    ->get()->count();

                $monthly_data['month'] = $month->format('M');
                $monthly_data['delayed'] = $delayedDoc;
                $monthly_data['onTime'] = $onTimeDoc;

                array_push($data, $monthly_data);

            }

            $res['body'] = $data;

        } catch (\Exception $e) {
            $res['status'] = 'error';
            $res['message'] = $e->getMessage();
        }

        return response()->json($res);
    }

    public function documentDelayedGlobalChangeControl()
    {
        $res = Helpers::getDefaultResponse();

        try {

            $data = [];

            for ($i = 5; $i >= 0; $i--) {
                $monthly_data = [];
                $month = Carbon::now()->subMonths($i);

                $delayedDoc = GlobalChangeControl::where('stage', '<', 9)
                    ->where('due_date', '<', Carbon::now())
                    ->whereDate('created_at', '>=', $month->startOfMonth())
                    ->whereDate('created_at', '<=', $month->endOfMonth())
                    ->get()->count();

                $onTimeDoc = GlobalChangeControl::where('stage', '=', 9)
                    ->where('due_date', '<', Carbon::now())
                    ->whereDate('created_at', '>=', $month->startOfMonth())
                    ->whereDate('created_at', '<=', $month->endOfMonth())
                    ->get()->count();

                $monthly_data['month'] = $month->format('M');
                $monthly_data['delayed'] = $delayedDoc;
                $monthly_data['onTime'] = $onTimeDoc;

                array_push($data, $monthly_data);

            }

            $res['body'] = $data;

        } catch (\Exception $e) {
            $res['status'] = 'error';
            $res['message'] = $e->getMessage();
        }

        return response()->json($res);
    }

    public function siteWiseDocument()
    {
        $res = Helpers::getDefaultResponse();

        try {

            $data = [];

            for ($i = 5; $i >= 0; $i--) {
                $monthly_data = [];
                $month = Carbon::now()->subMonths($i);

                $corporateDoc = DB::table('deviations')
                    ->join('q_m_s_divisions', 'deviations.division_id', '=', 'q_m_s_divisions.id')
                    ->select('deviations.*', 'q_m_s_divisions.name as division_name')
                    ->whereDate('deviations.created_at', '>=', $month->startOfMonth())
                    ->whereDate('deviations.created_at', '<=', $month->endOfMonth())
                    ->where('q_m_s_divisions.name', 'Corporate')
                    ->get()->count();

                $plantDoc = DB::table('deviations')
                    ->join('q_m_s_divisions', 'deviations.division_id', '=', 'q_m_s_divisions.id')
                    ->select('deviations.*', 'q_m_s_divisions.name as division_name')
                    ->whereDate('deviations.created_at', '>=', $month->startOfMonth())
                    ->whereDate('deviations.created_at', '<=', $month->endOfMonth())
                    ->where('q_m_s_divisions.name', 'Plant')
                    ->get()->count();

                $monthly_data['month'] = $month->format('M');
                $monthly_data['corporate'] = $corporateDoc;
                $monthly_data['plant'] = $plantDoc;

                array_push($data, $monthly_data);

            }

            $res['body'] = $data;

        } catch (\Exception $e) {
            $res['status'] = 'error';
            $res['message'] = $e->getMessage();
        }

        return response()->json($res);
    }

    public function siteWiseChangeControlDocument()
    {
        $res = Helpers::getDefaultResponse();

        try {

            $data = [];

            for ($i = 5; $i >= 0; $i--) {
                $monthly_data = [];
                $month = Carbon::now()->subMonths($i);

                $corporateDoc = DB::table('c_c_s')
                    ->join('q_m_s_divisions', 'c_c_s.division_id', '=', 'q_m_s_divisions.id')
                    ->select('c_c_s.*', 'q_m_s_divisions.name as division_name')
                    ->whereDate('c_c_s.created_at', '>=', $month->startOfMonth())
                    ->whereDate('c_c_s.created_at', '<=', $month->endOfMonth())
                    ->where('q_m_s_divisions.name', 'Corporate')
                    ->get()->count();

                $plantDoc = DB::table('c_c_s')
                    ->join('q_m_s_divisions', 'c_c_s.division_id', '=', 'q_m_s_divisions.id')
                    ->select('c_c_s.*', 'q_m_s_divisions.name as division_name')
                    ->whereDate('c_c_s.created_at', '>=', $month->startOfMonth())
                    ->whereDate('c_c_s.created_at', '<=', $month->endOfMonth())
                    ->where('q_m_s_divisions.name', 'Plant')
                    ->get()->count();

                $monthly_data['month'] = $month->format('M');
                $monthly_data['corporate'] = $corporateDoc;
                $monthly_data['plant'] = $plantDoc;

                array_push($data, $monthly_data);

            }

            $res['body'] = $data;

        } catch (\Exception $e) {
            $res['status'] = 'error';
            $res['message'] = $e->getMessage();
        }

        return response()->json($res);
    }

    public function siteWiseGlobalChangeControlDocument()
    {
        $res = Helpers::getDefaultResponse();

        try {

            $data = [];

            for ($i = 5; $i >= 0; $i--) {
                $monthly_data = [];
                $month = Carbon::now()->subMonths($i);

                $corporateDoc = DB::table('global_change_controls')
                    ->join('q_m_s_divisions', 'global_change_controls.division_id', '=', 'q_m_s_divisions.id')
                    ->select('global_change_controls.*', 'q_m_s_divisions.name as division_name')
                    ->whereDate('global_change_controls.created_at', '>=', $month->startOfMonth())
                    ->whereDate('global_change_controls.created_at', '<=', $month->endOfMonth())
                    ->where('q_m_s_divisions.name', 'Corporate')
                    ->get()->count();

                $plantDoc = DB::table('global_change_controls')
                    ->join('q_m_s_divisions', 'global_change_controls.division_id', '=', 'q_m_s_divisions.id')
                    ->select('global_change_controls.*', 'q_m_s_divisions.name as division_name')
                    ->whereDate('global_change_controls.created_at', '>=', $month->startOfMonth())
                    ->whereDate('global_change_controls.created_at', '<=', $month->endOfMonth())
                    ->where('q_m_s_divisions.name', 'Plant')
                    ->get()->count();

                $monthly_data['month'] = $month->format('M');
                $monthly_data['corporate'] = $corporateDoc;
                $monthly_data['plant'] = $plantDoc;

                array_push($data, $monthly_data);

            }

            $res['body'] = $data;

        } catch (\Exception $e) {
            $res['status'] = 'error';
            $res['message'] = $e->getMessage();
        }

        return response()->json($res);
    }


    public function getFlowCounts()
    {
        $res = ['status' => 'ok', 'body' => []];

        try {
            $flows = [
                'Action Item' => ActionItem::count(),
                'Audit Program' => AuditProgram::count(),
                'CAPA' => Capa::count(),
                'Calibration Management' => CallibrationDetails::count(),
                'Change Control' => CC::count(),
                'Complaint Management' => MarketComplaint::count(),
                'Deviation' => Deviation::count(),
                'Extension' => extension_new::count(),
                'Effectiveness Check' => EffectivenessCheck::count(),
                'Equipment Lifecycle' => EquipmentLifecycleManagement::count(),
                'Errata' => Errata::count(),
                'Global Capa' => Capa::count(),
                'Global Change Control' => CC::count(),
                'Incident' => Incident::count(),
                'Internal Audit' => InternalAudit::count(),
                'LabIncident' => LabIncident::count(),
                'OOS/OOT' => Ootc::count(),
                'Preventive Maintenance' => PreventiveMaintenance::count(),
                'Risk Assesment' => RiskManagement::count(),
                'Root Cause Analysis' => RootCauseAnalysis::count(),
                'Supplier' => Supplier::count(),
                'Supplier Audit' => SupplierAudit::count(),
            ];

            $res['body'] = array_map(function($flow, $count) {
                return [
                    'name' => $flow,
                    'count' => $count
                ];
            }, array_keys($flows), $flows);

        } catch (\Exception $e) {
            $res['status'] = 'error';
            $res['message'] = $e->getMessage();
        }

        return response()->json($res);
    }


    // Helpers

    static function getProcessCount($model_namespace, $field = null, $value = null)
    {
        try {
            if ($field && $value) {
                return $model_namespace::where($field, $value)->get()->count();
            } else {
                return $model_namespace::get()->count();
            }
        } catch (\Exception $e) {
            return 0;
        }
    }
    public function getDivisionProcessCounts()
    {
        $res = [
            'status' => 'success',
            'message' => null,
            'body' => []
        ];

        try {
            $processes = [
               

                            'Action Item' => 'action_items',
                            'Audit Program' => 'audit_programs',
                            'CAPA' => 'capas',
                            'Calibration Management' => 'out_of_calibrations',
                            'Change Control' => 'c_c_s',
                            'Complaint Management' => 'marketcompalints',
                            'Deviation' => 'deviations',
                            'Due Date Extension' => 'extensions',
                            'Effectiveness Check' => 'effectiveness_checks',
                            'Equipment/Instrument Lifecycle Management' => 'equipment_lifecycle_information',
                            'ERRATA' => 'erratas',
                            'External Audit' => 'auditees',
                            'Global CAPA' => 'capas',
                            'Global Change Control' => 'c_c_s',
                            'Incident' => 'incidents',
                            'Internal Audit' => 'internal_audits',
                            'Lab Incident' => 'lab_incidents',
                            'New Document' => 'documents',
                            'OOS/OOT' => 'o_o_t_s',
                            'Preventive Maintenance' => 'preventive_maintenances',
                            'Risk Assessment' => 'risk_assessments',
                            'Root Cause Analysis' => 'root_cause_analyses',
                            'Supplier' => 'suppliers',
                            'Supplier Audit' => 'supplier_audits',

                        ];

            $divisions = ['Corporate Quality Assurance (CQA)', 'Plant 1', 'Plant 2', 'Plant 3', 'Plant 4', 'C1'];

            $data = [];

            foreach ($divisions as $division) {
                $divisionData = [
                    'division' => $division,
                    'processCounts' => []
                ];

                foreach ($processes as $processName => $tableName) {
                    $processCount = DB::table($tableName)
                        ->where('division_id', function ($query) use ($division) {
                            $query->select('id')
                                ->from('q_m_s_divisions')
                                ->where('name', $division)
                                ->limit(1);
                        })
                        ->count();

                    $divisionData['processCounts'][] = [
                        'process' => $processName,
                        'count' => $processCount
                    ];
                }

                $data[] = $divisionData;
            }

            $res['body'] = $data;
        } catch (\Exception $e) {
            $res['status'] = 'error';
            $res['message'] = $e->getMessage();
        }

        return response()->json($res);
    }
    public function getDeviationData()
    {
        // Fetching the data from the 'DeviationCategory' model
        $data = Deviation::select('Deviation_category', \DB::raw('count(*) as count'))
        ->groupBy('Deviation_category')  // Group by Deviation_category
        ->get(); // Fetch the grouped data
        
        // Prepare data in the form of an associative array
        $deviationData = [
            'major' => 0,
            'minor' => 0,
            'critical' => 0
        ];

        // Loop through and map the counts to the categories
        foreach ($data as $entry) {
            if ($entry->    Deviation_category == 'major') {
                $deviationData['major'] = $entry->count;
            } elseif ($entry->  Deviation_category == 'minor') {
                $deviationData['minor'] = $entry->count;
            } elseif ($entry->  Deviation_category == 'critical') {
                $deviationData['critical'] = $entry->count;
            }
        }

        return response()->json($deviationData);
    }


    public function getChangeControlData()
    {
        // Fetching the data from the 'DeviationCategory' model
        $data = CC::select('severity_level1', \DB::raw('count(*) as count'))
        ->groupBy('severity_level1')  // Group by Deviation_category
        ->get(); // Fetch the grouped data
        
        // Prepare data in the form of an associative array
        $deviationData = [
            'major' => 0,
            'minor' => 0,
            'critical' => 0
        ];

        // Loop through and map the counts to the categories
        foreach ($data as $entry) {
            if ($entry->    severity_level1 == 'major') {
                $deviationData['major'] = $entry->count;
            } elseif ($entry->  severity_level1 == 'minor') {
                $deviationData['minor'] = $entry->count;
            } elseif ($entry->  severity_level1 == 'critical') {
                $deviationData['critical'] = $entry->count;
            }
        }

        return response()->json($deviationData);
    }


    public function getActionItemData()
    {
        // Fetching the data from the 'DeviationCategory' model
        $data = ActionItem::select('initial_categorization', \DB::raw('count(*) as count'))
        ->groupBy('initial_categorization')  // Group by Deviation_category
        ->get(); // Fetch the grouped data
        
        // Prepare data in the form of an associative array
        $deviationData = [
            'major' => 0,
            'minor' => 0,
            'critical' => 0
        ];

        // Loop through and map the counts to the categories
        foreach ($data as $entry) {
            if ($entry->    initial_categorization == 'major') {
                $deviationData['major'] = $entry->count;
            } elseif ($entry->  initial_categorization == 'minor') {
                $deviationData['minor'] = $entry->count;
            } elseif ($entry->  initial_categorization == 'critical') {
                $deviationData['critical'] = $entry->count;
            }
        }

        return response()->json($deviationData);
    }


    public function getGlobalChangeControlData()
    {
        // Fetching the data from the 'DeviationCategory' model
        $data = GlobalChangeControl::select('severity_level1', \DB::raw('count(*) as count'))
        ->groupBy('severity_level1')  // Group by Deviation_category
        ->get(); // Fetch the grouped data
        
        // Prepare data in the form of an associative array
        $deviationData = [
            'major' => 0,
            'minor' => 0,
            'critical' => 0
        ];

        // Loop through and map the counts to the categories
        foreach ($data as $entry) {
            if ($entry->    severity_level1 == 'major') {
                $deviationData['major'] = $entry->count;
            } elseif ($entry->  severity_level1 == 'minor') {
                $deviationData['minor'] = $entry->count;
            } elseif ($entry->  severity_level1 == 'critical') {
                $deviationData['critical'] = $entry->count;
            }
        }

        return response()->json($deviationData);
    }
    public function getcategorizationData()
    {
        // Fetching the data from the 'DeviationCategory' model
        $data = Deviation::select('Post_Categorization', \DB::raw('count(*) as count'))
        ->groupBy('Post_Categorization')  // Group by Post_Categorization
        ->get(); // Fetch the grouped data
        
        // Prepare data in the form of an associative array
        $deviationData = [
            'major' => 0,
            'minor' => 0,
            'critical' => 0
        ];

        // Loop through and map the counts to the categories
        foreach ($data as $entry) {
            if ($entry-> Post_Categorization == 'major') {
                $deviationData['major'] = $entry->count;
            } elseif ($entry->Post_Categorization == 'minor') {
                $deviationData['minor'] = $entry->count;
            } elseif ($entry->Post_Categorization == 'critical') {
                $deviationData['critical'] = $entry->count;
            }
        }

        return response()->json($deviationData);
    }

    public function getChangeControlCategorizationData()
    {
        // Fetching the data from the 'DeviationCategory' model
        $data = CC::select('bd_domestic', \DB::raw('count(*) as count'))
        ->groupBy('bd_domestic')  // Group by bd_domestic
        ->get(); // Fetch the grouped data
        
        // Prepare data in the form of an associative array
        $deviationData = [
            'major' => 0,
            'minor' => 0,
            'critical' => 0
        ];

        // Loop through and map the counts to the categories
        foreach ($data as $entry) {
            if ($entry->bd_domestic == 'major') {
                $deviationData['major'] = $entry->count;
            } elseif ($entry->bd_domestic == 'minor') {
                $deviationData['minor'] = $entry->count;
            } elseif ($entry->bd_domestic == 'critical') {
                $deviationData['critical'] = $entry->count;
            }
        }

        return response()->json($deviationData);
    }

    /*********** Capa ************/

    public function getCapaInitialCategorization(){
        $data = Capa::select('Initial_Categorization', \DB::raw('count(*) as count'))
        ->groupBy('Initial_Categorization')  // Group by Initial_Categorization
        ->get(); // Fetch the grouped data

        // Prepare data in the form of an associative array
        $deviationData = [
            'Major' => 0,
            'Minor' => 0,
            'Critical' => 0
        ];

        // Loop through and map the counts to the categories
        foreach ($data as $entry) {
            if ($entry->Initial_Categorization == 'Major') {
                $deviationData['Major'] = $entry->count;
            } elseif ($entry->Initial_Categorization == 'Minor') {
                $deviationData['Minor'] = $entry->count;
            } elseif ($entry->Initial_Categorization == 'Critical') {
                $deviationData['Critical'] = $entry->count;
            }
        }

        return response()->json($deviationData);
    }

    public function getCapaPostCategorization(){
        $data = Capa::select('Post_Categorization', \DB::raw('count(*) as count'))
        ->groupBy('Post_Categorization')
        ->get();

        $deviationData = [
            'Major' => 0,
            'Minor' => 0,
            'Critical' => 0
        ];

        foreach ($data as $entry) {
            if ($entry->Post_Categorization == 'Major') {
                $deviationData['Major'] = $entry->count;
            } elseif ($entry->Post_Categorization == 'Minor') {
                $deviationData['Minor'] = $entry->count;
            } elseif ($entry->Post_Categorization == 'Critical') {
                $deviationData['Critical'] = $entry->count;
            }
        }

        return response()->json($deviationData);
    }

    public function getOnTimeVsDelayedRecords() {
        $today = \Carbon\Carbon::today();
    
        $onTime = \DB::table('capas')
            ->where('due_date', '>=', $today)
            ->where('status', 'Closed - Done')
            ->count();
    
        $delayed = \DB::table('capas')
            ->where('due_date', '<', $today)
            ->where('status', '!=', 'Closed - Done')
            ->count();
    
        return response()->json([
            'On Time' => $onTime,
            'Delayed' => $delayed,
        ]);
    }
    
    public function getCapaByDivision() {
        $data = \DB::table('q_m_s_divisions')
            ->leftJoin('capas', 'capas.division_id', '=', 'q_m_s_divisions.id')
            ->select('q_m_s_divisions.name as division_name', \DB::raw('COUNT(capas.id) as count'))
            ->groupBy('q_m_s_divisions.id', 'q_m_s_divisions.name')
            ->orderBy('q_m_s_divisions.name')
            ->get();
    
        return response()->json($data);
    }

    public function getCapaPriorityData(){
        $data = Capa::select('priority_data', \DB::raw('count(*) as count'))
        ->groupBy('priority_data')
        ->get();

        $deviationData = [
            'High' => 0,
            'Medium' => 0,
            'Low' => 0
        ];

        foreach ($data as $entry) {
            if ($entry->priority_data == 'High') {
                $deviationData['High'] = $entry->count;
            } elseif ($entry->priority_data == 'Medium') {
                $deviationData['Medium'] = $entry->count;
            } elseif ($entry->priority_data == 'Low') {
                $deviationData['Low'] = $entry->count;
            }
        }

        return response()->json($deviationData);
    }

    public function getCapaByStatus() {
        $statuses = [
            'Opened',
            'HOD Review',
            'QA/CQA Review',
            'QA/CQA Approval',
            'CAPA In progress',
            'HOD Final Review',
            'QA/CQA Closure Review',
            'QA/CQA Approval',
            'Closed - Done'
        ];
    
        $data = collect($statuses)->mapWithKeys(function($status) {
            $count = \DB::table('capas')
                ->where('status', $status)
                ->count();
    
            return [$status => $count];
        });
    
        return response()->json($data);
    }

    /*********** Capa ************/


    public function getGlobalChangeControlCategorizationData()
    {
        // Fetching the data from the 'DeviationCategory' model
        $data = GlobalChangeControl::select('Post_Categorization', \DB::raw('count(*) as count'))
        ->groupBy('Post_Categorization')  // Group by bd_domestic
        ->get(); // Fetch the grouped data
        
        // Prepare data in the form of an associative array
        $deviationData = [
            'major' => 0,
            'minor' => 0,
            'critical' => 0
        ];

        // Loop through and map the counts to the categories
        foreach ($data as $entry) {
            if ($entry->Post_Categorization	 == 'major') {
                $deviationData['major'] = $entry->count;
            } elseif ($entry->Post_Categorization	 == 'minor') {
                $deviationData['minor'] = $entry->count;
            } elseif ($entry->Post_Categorization	 == 'critical') {
                $deviationData['critical'] = $entry->count;
            }
        }

        return response()->json($deviationData);
    }


    public function getActionItemCategorizationData()
    {
        // Fetching the data from the 'DeviationCategory' model
        $data = ActionItem::select('Post_Categorization', \DB::raw('count(*) as count'))
        ->groupBy('Post_Categorization')  // Group by bd_domestic
        ->get(); // Fetch the grouped data
        
        // Prepare data in the form of an associative array
        $deviationData = [
            'major' => 0,
            'minor' => 0,
            'critical' => 0
        ];

        // Loop through and map the counts to the categories
        foreach ($data as $entry) {
            if ($entry->Post_Categorization	 == 'major') {
                $deviationData['major'] = $entry->count;
            } elseif ($entry->Post_Categorization	 == 'minor') {
                $deviationData['minor'] = $entry->count;
            } elseif ($entry->Post_Categorization	 == 'critical') {
                $deviationData['critical'] = $entry->count;
            }
        }

        return response()->json($deviationData);
    }
    public function samplemanagementstatuschart(){
        try {
            $data = DB::table('receipts')
                ->select('status', DB::raw('count(*) as count'))
                ->groupBy('status')
                ->get();
    
            $response = [
                'labels' => $data->pluck('status'),
                'series' => $data->pluck('count')
            ];
    
            return response()->json([
                'status' => 'ok',
                'body' => $response
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
    public function samplemanagementdepartmentchart(){
        try {
            $data = DB::table('receipts')
                ->select('initiator_Group', DB::raw('count(*) as count'))
                ->groupBy('initiator_Group')
                ->get();
    
            $response = [
                'labels' => $data->pluck('initiator_Group'),
                'series' => $data->pluck('count')
            ];
    
            return response()->json([
                'initiator_Group' => 'ok',
                'body' => $response
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'initiator_Group' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function samplemanagementdivisionchart(){
        try {
            $data = DB::table('receipts')
                ->select('receipt_division', DB::raw('count(*) as count'))
                ->groupBy('receipt_division')
                ->get();
    
            $response = [
                'labels' => $data->pluck('receipt_division'),
                'series' => $data->pluck('count')
            ];
    
            return response()->json([
                'receipt_division' => 'ok',
                'body' => $response
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'receipt_division' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function samplemanagementsampletypechart(){
        try {
            $data = DB::table('receipts')
                ->select('sample_type', DB::raw('count(*) as count'))
                ->groupBy('sample_type')
                ->get();
    
            $response = [
                'labels' => $data->pluck('sample_type'),
                'series' => $data->pluck('count')
            ];
    
            return response()->json([
                'sample_type' => 'ok',
                'body' => $response
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'sample_type' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function samplemanagementturnaroundchart(){
        try {
            $data = DB::table('receipts')
                ->select('turn_around_time', DB::raw('count(*) as count'))
                ->groupBy('turn_around_time')
                ->get();
    
            $response = [
                'labels' => $data->pluck('turn_around_time'),
                'series' => $data->pluck('count')
            ];
    
            return response()->json([
                'turn_around_time' => 'ok',
                'body' => $response
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'turn_around_time' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function taskmanagementchart()
    {
        try {
            $data = DB::table('task_management_grids')
            ->selectRaw("JSON_UNQUOTE(JSON_EXTRACT(data, '$[0].work_in_progress_detail')) as work_in_progress_detail, COUNT(*) as count")
            ->whereRaw("JSON_EXTRACT(data, '$[0].work_in_progress_detail') IS NOT NULL")
            ->groupBy('work_in_progress_detail')
            ->get();
            // dd($data);
    
            // JSON response format
            $response = [
                'labels' => $data->pluck('work_in_progress_detail')->toArray(),
                'series' => $data->pluck('count')->toArray()
            ];
    
            return response()->json([
                'data' => 'ok',
                'body' => $response
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'data' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
    

}
