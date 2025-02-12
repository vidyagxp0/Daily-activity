<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ActionItem;
use App\Models\CC;
use App\Models\GlobalChangeControl;
use App\Models\AuditProgram;
use App\Models\CallibrationDetails;
use App\Models\Capa;
use App\Models\GlobalCapa;
use App\Models\Deviation;
use App\Models\Document;
use App\Models\EffectivenessCheck;
use App\Models\EquipmentLifecycleManagement;
use App\Models\Errata;
use App\Models\extension_new;
use App\Models\ExternalAudit;
use App\Models\Incident;
use App\Models\InternalAudit;
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
use Illuminate\Support\Facades\Log;

class KSIController extends Controller
{

    public function getProcessCounts()
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
                'Global Capa' => GlobalCapa::count(),
                'Global Change Control' => GlobalChangeControl::count(),
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

            // Filter out flows with a count of 0
            $filteredFlows = array_filter($flows, function ($count) {
                return $count > 0;
            });

            // Map the filtered flows to the response format
            $res['body'] = array_map(function ($flow, $count) {
                return [
                    'name' => $flow,
                    'count' => $count
                ];
            }, array_keys($filteredFlows), $filteredFlows);
        } catch (\Exception $e) {
            $res['status'] = 'error';
            $res['message'] = $e->getMessage();
        }

        return response()->json($res);
    }


    public function drillChartStages($label)
    {
        return view('frontend.ksi-overview.ksi-overview-stage', ['label' => $label]);
    }

    public function drillChartDateDistribution($label, $process)
    {
        return view('frontend.ksi-overview.ksi-overview-date-distribution', ['label' => $label, 'process' => $process]);
    }

    public function drillChartLogs($label, $process)
    {
        return view('frontend.ksi-overview.ksi-overview-logs', ['label' => $label, 'process' => $process]);
    }

    public function getActionItemStageDistribution()
    {
        try {
            $data = DB::table('action_items')
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

    public function getChangeControlStageDistribution()
    {
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

    public function getAuditProgramStageDistribution()
    {
        try {
            $data = DB::table('audit_programs')
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

    public function getCAPAStageDistribution()
    {
        try {
            $data = DB::table('capas')
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

    public function getCalibrationManagementStageDistribution()
    {
        try {
            $data = DB::table('callibration_details')
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

    public function getDeviationStageDistribution()
    {
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

    public function getEffectivenessCheckStageDistribution()
    {
        try {
            $data = DB::table('effectiveness_checks')
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

    public function getEquipmentLCMStageDistribution()
    {
        try {
            $data = DB::table('equipment_lifecycle_information')
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

    public function getGlobalCAPAStageDistribution()
    {
        try {
            $data = DB::table('global_capa')
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

    public function getGlobalChangeControlStageDistribution()
    {
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

    public function getIncidentStageDistribution()
    {
        try {
            $data = DB::table('incidents')
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
    public function getInternalAuditStageDistribution()
    {
        try {
            $data = DB::table('internal_audits')
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

    public function getLabIncidentStageDistribution()
    {
        try {
            $data = DB::table('lab_incidents')
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

    public function getPreventiveMaintenanceStageDistribution()
    {
        try {
            $data = DB::table('preventive_maintenances')
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
    public function getRiskAssessmentStageDistribution()
    {
        try {
            $data = DB::table('risk_assessments')
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
    public function getRootCauseAnalysisStageDistribution()
    {
        try {
            $data = DB::table('root_cause_analyses')
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
    public function getSupplierStageDistribution()
    {
        try {
            $data = DB::table('suppliers')
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
    public function getSupplierAuditStageDistribution()
    {
        try {
            $data = DB::table('supplier_audits')
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


    public function fetchMonthlyDistribution($process, $label)
    {
        try {
            $endDate = Carbon::now();
            $startDate = $endDate->copy()->subYear()->startOfMonth();

            $months = [];
            for ($i = 0; $i < 12; $i++) {
                $months[] = $endDate->copy()->subMonths($i)->format('M Y');
            }
            $months = array_reverse($months);
            if ($label === 'Action Item') {
                $data = DB::table('action_items')
                    ->select(DB::raw("DATE_FORMAT(created_at, '%b %Y') as month"), DB::raw('COUNT(*) as count'))
                    ->where('status', $process)
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->groupBy('month')
                    ->get()
                    ->keyBy('month');
            } else if ($label === 'Audit Program') {
                $data = DB::table('audit_programs')
                    ->select(DB::raw("DATE_FORMAT(created_at, '%b %Y') as month"), DB::raw('COUNT(*) as count'))
                    ->where('status', $process)
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->groupBy('month')
                    ->get()
                    ->keyBy('month');
            } else if ($label === 'CAPA') {
                $data = DB::table('capas')
                    ->select(DB::raw("DATE_FORMAT(created_at, '%b %Y') as month"), DB::raw('COUNT(*) as count'))
                    ->where('status', $process)
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->groupBy('month')
                    ->get()
                    ->keyBy('month');
            } else if ($label === 'Calibration Management') {
                $data = DB::table('callibration_details')
                    ->select(DB::raw("DATE_FORMAT(created_at, '%b %Y') as month"), DB::raw('COUNT(*) as count'))
                    ->where('status', $process)
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->groupBy('month')
                    ->get()
                    ->keyBy('month');
            } else if ($label === 'Change Control') {
                $data = DB::table('c_c_s')
                    ->select(DB::raw("DATE_FORMAT(created_at, '%b %Y') as month"), DB::raw('COUNT(*) as count'))
                    ->where('status', $process)
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->groupBy('month')
                    ->get()
                    ->keyBy('month');
            } else if ($label === 'Deviation') {
                $data = DB::table('deviations')
                    ->select(DB::raw("DATE_FORMAT(created_at, '%b %Y') as month"), DB::raw('COUNT(*) as count'))
                    ->where('status', $process)
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->groupBy('month')
                    ->get()
                    ->keyBy('month');
            } else if ($label === 'Effectiveness Check') {
                $data = DB::table('effectiveness_checks')
                    ->select(DB::raw("DATE_FORMAT(created_at, '%b %Y') as month"), DB::raw('COUNT(*) as count'))
                    ->where('status', $process)
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->groupBy('month')
                    ->get()
                    ->keyBy('month');
            } else if ($label === 'Equipment Lifecycle') {
                $data = DB::table('equipment_lifecycle_information')
                    ->select(DB::raw("DATE_FORMAT(created_at, '%b %Y') as month"), DB::raw('COUNT(*) as count'))
                    ->where('status', $process)
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->groupBy('month')
                    ->get()
                    ->keyBy('month');
            } else if ($label === 'Global Capa') {
                $data = DB::table('global_capa')
                    ->select(DB::raw("DATE_FORMAT(created_at, '%b %Y') as month"), DB::raw('COUNT(*) as count'))
                    ->where('status', $process)
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->groupBy('month')
                    ->get()
                    ->keyBy('month');
            } else if ($label === 'Global Change Control') {
                $data = DB::table('global_change_controls')
                    ->select(DB::raw("DATE_FORMAT(created_at, '%b %Y') as month"), DB::raw('COUNT(*) as count'))
                    ->where('status', $process)
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->groupBy('month')
                    ->get()
                    ->keyBy('month');
            } else if ($label === 'Incident') {
                $data = DB::table('incidents')
                    ->select(DB::raw("DATE_FORMAT(created_at, '%b %Y') as month"), DB::raw('COUNT(*) as count'))
                    ->where('status', $process)
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->groupBy('month')
                    ->get()
                    ->keyBy('month');
            } else if ($label === 'Internal Audit') {
                $data = DB::table('internal_audits')
                    ->select(DB::raw("DATE_FORMAT(created_at, '%b %Y') as month"), DB::raw('COUNT(*) as count'))
                    ->where('status', $process)
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->groupBy('month')
                    ->get()
                    ->keyBy('month');
            } else if ($label === 'LabIncident') {
                $data = DB::table('lab_incidents')
                    ->select(DB::raw("DATE_FORMAT(created_at, '%b %Y') as month"), DB::raw('COUNT(*) as count'))
                    ->where('status', $process)
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->groupBy('month')
                    ->get()
                    ->keyBy('month');
            } else if ($label === 'Preventive Maintenance') {
                $data = DB::table('preventive_maintenances')
                    ->select(DB::raw("DATE_FORMAT(created_at, '%b %Y') as month"), DB::raw('COUNT(*) as count'))
                    ->where('status', $process)
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->groupBy('month')
                    ->get()
                    ->keyBy('month');
            } else if ($label === 'Risk Assessment') {
                $data = DB::table('risk_assessments')
                    ->select(DB::raw("DATE_FORMAT(created_at, '%b %Y') as month"), DB::raw('COUNT(*) as count'))
                    ->where('status', $process)
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->groupBy('month')
                    ->get()
                    ->keyBy('month');
            } else if ($label === 'Root Cause Analysis') {
                $data = DB::table('root_cause_analyses')
                    ->select(DB::raw("DATE_FORMAT(created_at, '%b %Y') as month"), DB::raw('COUNT(*) as count'))
                    ->where('status', $process)
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->groupBy('month')
                    ->get()
                    ->keyBy('month');
            } else if ($label === 'Supplier') {
                $data = DB::table('suppliers')
                    ->select(DB::raw("DATE_FORMAT(created_at, '%b %Y') as month"), DB::raw('COUNT(*) as count'))
                    ->where('status', $process)
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->groupBy('month')
                    ->get()
                    ->keyBy('month');
            } else if ($label === 'Supplier Audit') {
                $data = DB::table('supplier_audits')
                    ->select(DB::raw("DATE_FORMAT(created_at, '%b %Y') as month"), DB::raw('COUNT(*) as count'))
                    ->where('status', $process)
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->groupBy('month')
                    ->get()
                    ->keyBy('month');
            }
            $series = [];
            foreach ($months as $month) {
                $series[] = $data->has($month) ? $data[$month]->count : 0;
            }

            return response()->json([
                'status' => 'ok',
                'body' => [
                    'labels' => $months,
                    'series' => $series
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function fetchProcessData($process, $label)
    {
        try {

            // Determine which table to query based on $process
            if ($process === 'Action Item') {
                $data = DB::table('action_items')->where('status', $label);
            } elseif ($process === 'Audit Program') {
                $data = DB::table('audit_programs')->where('status', $label);
            } elseif ($process === 'CAPA') {
                $data = DB::table('capas')->where('status', $label);
            } elseif ($process === 'Calibration Management') {
                $data = DB::table('callibration_details')->where('status', $label);
            } elseif ($process === 'Change Control') {
                $data = DB::table('c_c_s')->where('status', $label);
            } elseif ($process === 'Deviation') {
                $data = DB::table('deviations')->where('status', $label);
            } elseif ($process === 'Effectiveness Check') {
                $data = DB::table('effectiveness_checks')->where('status', $label);
            } elseif ($process === 'Equipment Lifecycle') {
                $data = DB::table('equipment_lifecycle_information')->where('status', $label);
            } elseif ($process === 'Global Capa') {
                $data = DB::table('global_capa')->where('status', $label);
            } elseif ($process === 'Global Change Control') {
                $data = DB::table('global_change_controls')->where('status', $label);
            } elseif ($process === 'Incident') {
                $data = DB::table('incidents')->where('status', $label);
            } elseif ($process === 'Internal Audit') {
                $data = DB::table('internal_audits')->where('status', $label);
            } elseif ($process === 'LabIncident') {
                $data = DB::table('lab_incidents')->where('status', $label);
            } elseif ($process === 'Preventive Maintenance') {
                $data = DB::table('preventive_maintenances')->where('status', $label);
            } elseif ($process === 'Risk Assessment') {
                $data = DB::table('risk_assessments')->where('status', $label);
            } elseif ($process === 'Root Cause Analysis') {
                $data = DB::table('root_cause_analyses')->where('status', $label);
            } elseif ($process === 'Supplier') {
                $data = DB::table('suppliers')->where('status', $label);
            } elseif ($process === 'Supplier Audit') {
                $data = DB::table('supplier_audits')->where('status', $label);
            } else {
                Log::error('Invalid process specified', ['process' => $process]);
                return response()->json(['status' => 'error', 'message' => 'Invalid process specified.']);
            }


            if ($data) {
                $data = $data->get()->map(function ($item) {
                    $item->division = Helpers::divisionNameForQMS($item->division_id);
                    $item->originator = Helpers::getInitiatorName($item->initiator_id);
                    return $item;
                });
            }

            return response()->json([
                'status' => 'ok',
                'body' => $data
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching process data', ['error' => $e->getMessage()]);
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }



}

