<?php

namespace App\Http\Controllers\Api;

use App\Models\Deviation;
use App\Models\CC;
use App\Models\Supplier;
use App\Models\supplierAudit;
use App\Models\ActionItem;
use App\Models\Analytics;
use App\Models\PreventiveMaintenance;
use App\Models\EquipmentLifecycleManagement;
use App\Models\GlobalCapa;
use App\Models\Sanction;
use App\Models\Document;
use App\Models\SampleStability;
use App\Models\InventoryManagement;
use App\Models\ControlSample;
use App\Models\SamplePlanning;
use App\Models\Incident;
use App\Models\CallibrationDetails;
use App\Models\EHSEvent;
use App\Models\Ootc;
use App\Models\OOS;
use App\Models\Auditee;

use App\Models\OOS_micro;
use App\Models\NonConformance;
use App\Models\RootCauseAnalysis;
use App\Models\errata;
use App\Models\FailureInvestigation;
use App\Models\EffectivenessCheck;
use App\Models\extension_new;
use App\Models\MarketComplaint;
use App\Models\RiskManagement;
use App\Models\OutOfCalibration;
use App\Models\LabIncident;
use App\Models\InternalAudit;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Capa;
use App\Models\CapaGrid;
use PDF;
use App\Http\Controllers\Controller;


class LogFilterController extends Controller
{
    public function capa_filter(Request $request)
    {
        $res = [
            'status' => 'ok',
            'message' => 'success',
            'body' => []
        ];
    
        try {
            $query = Capa::query();
            if (!empty($request->department_capa)) {
                $query->whereIn('initiator_Group', $request->department_capa);  // Use whereIn for multiple selections
            }
    
            if ($request->division_id_capa) {
                $query->where('division_id', $request->division_id_capa);
            }
    
            if ($request->initiator_id_capa) {
                $query->where('initiator_id', $request->initiator_id_capa);
            }
    
         
            if ($request->date_fromcapacapa) {
                $dateFrom = Carbon::parse($request->date_fromcapacapa)->startOfDay();
                $query->whereDate('intiation_date', '>=', $dateFrom);
            }
    
            if ($request->date_tocapa) {
                $dateTo = Carbon::parse($request->date_tocapa)->endOfDay();
                $query->whereDate('intiation_date', '<=', $dateTo);
            }
    
            // Apply Sorting if Specified
            if ($request->sort_column && $request->sort_order) {
                $query->orderBy($request->sort_column, $request->sort_order);
            }
    
            $capa = $query->get();
       
            $htmlData = view('frontend.forms.Logs.filterData.capa_data', compact('capa'))->render();
    
            $res['body'] = $htmlData;
    
        } catch (\Exception $e) {
            $res['status'] = 'error';
            $res['message'] = $e->getMessage();
        }
    
        return response()->json($res);
    }
    

    public function changecontrol_filter(Request $request)
{
    $res = [
        'status' => 'ok',
        'message' => 'success',
        'body' => []
    ];

    try {
        $query = CC::query();

        // Handle department filter when multiple departments are selected
        if (!empty($request->department_changecontrol)) {
            $query->whereIn('Initiator_Group', $request->department_changecontrol);  // Use whereIn for multiple selections
        }

        if ($request->division_id_changecontrol) {
            $query->where('division_id', $request->division_id_changecontrol);
        }

        if ($request->initiator_id_changecontrol) {
            $query->where('initiator_id', $request->initiator_id_changecontrol);
        }

        if ($request->date_fromCc) {
            $dateFrom = Carbon::parse($request->date_fromCc)->startOfDay();
            $query->whereDate('intiation_date', '>=', $dateFrom);
        }

        if ($request->date_toCc) {
            $dateTo = Carbon::parse($request->date_toCc)->endOfDay();
            $query->whereDate('intiation_date', '<=', $dateTo);
        }

        if ($request->Clasichange) {
            $query->where('severity_level1', $request->Clasichange);
        }

        if ($request->RadioActivtiyTCC) {
            $query->where('doc_change', $request->RadioActivtiyTCC);
        }

        if ($request->sort_column && $request->sort_order) {
            $query->orderBy($request->sort_column, $request->sort_order);
        }

        $cc_cft = $query->get();

        $htmlData = view('frontend.forms.Logs.filterData.changecontrol_data', compact('cc_cft'))->render();

        $res['body'] = $htmlData;

    } catch (\Exception $e) {
        $res['status'] = 'error';
        $res['message'] = $e->getMessage();
    }

    return response()->json($res);
}

// new process

public function analytics_filter(Request $request)
{
    $res = [
        'status' => 'ok',
        'message' => 'success',
        'body' => []
    ];

    try {
        $query = Analytics::query();

        // Handle department filter when multiple departments are selected
        if (!empty($request->department_analytics)) {
            $query->whereIn('department', $request->department_analytics);  // Use whereIn for multiple selections
        }

        if ($request->division_id_analytics) {
            $query->where('division_id', $request->division_id_analytics);
        }

        if ($request->initiator_id_analytics) {
            $query->where('initiator_id', $request->initiator_id_analytics);
        }

        if ($request->date_fromanalytics) {
            $dateFrom = Carbon::parse($request->date_fromanalytics)->startOfDay();
            $query->whereDate('date_of_initiation', '>=', $dateFrom);
        }

        if ($request->date_toanalytics) {
            $dateTo = Carbon::parse($request->date_toanalytics)->endOfDay();
            $query->whereDate('date_of_initiation', '<=', $dateTo);
        }

        if ($request->sort_column && $request->sort_order) {
            $query->orderBy($request->sort_column, $request->sort_order);
        }

        $analytics = $query->get();

        $htmlData = view('frontend.forms.Logs.filterData.analytics_data', compact('analytics'))->render();

        $res['body'] = $htmlData;

    } catch (\Exception $e) {
        $res['status'] = 'error';
        $res['message'] = $e->getMessage();
    }

    return response()->json($res);
}

public function analyticspdf(Request $request)
{
    $filterCC = $request->all();

    // dd($filterCC);
    $department = $filterCC['department'] ?? null; 
    $changerelateTo = $filterCC['changerelateTo'] ?? null; 
    $classification = $filterCC['dateFrom'] ?? null; 
    $Initiator = $filterCC['Initiator'] ?? null;
    
    $To = $filterCC['dateTo'] ?? null; 
   
    $query = Analytics::query();

    $query->when($department, function ($q) use ($department) {
        return $q->where('Initiator_Group', $department);
    });

   
    $query->when($Initiator, function ($q) use ($Initiator) {
        return $q->where('initiator_id', $Initiator);
    });

    $query->when($classification, function ($q) use ($classification) {
        return $q->where('intiation_date', $classification);
    });

    $query->when($To, function ($q) use ($To) {
        return $q->where('intiation_date', $To);
    });

  
    $filteredDataCC = $query->get();

    $rowsPerPage = 7;
    $totalRows = $filteredDataCC->count();
    $totalPages = ceil($totalRows / $rowsPerPage);
    $paginatedData = $filteredDataCC->chunk($rowsPerPage);

    

    $pdf = Pdf::loadView('frontend.forms.Logs.analyticspdf', compact('rowsPerPage','paginatedData','totalPages','filteredDataCC'))->setPaper('a4', 'landscape');

    return $pdf->stream('report.pdf');
}
public function samplestability_filter(Request $request)
{
    $res = [
        'status' => 'ok',
        'message' => 'success',
        'body' => []
    ];

    try {
        $query = SampleStability::query();

        // Handle department filter when multiple departments are selected
        if (!empty($request->department_samplestability)) {
            $query->whereIn('Initiator_Group', $request->department_samplestability);  // Use whereIn for multiple selections
        }

        if ($request->division_id_samplestability) {
            $query->where('division_id', $request->division_id_samplestability);
        }

        if ($request->initiator_id_samplestability) {
            $query->where('initiator_id', $request->initiator_id_samplestability);
        }

        if ($request->date_fromsamplestability) {
            $dateFrom = Carbon::parse($request->date_fromsamplestability)->startOfDay();
            $query->whereDate('intiation_date', '>=', $dateFrom);
        }

        if ($request->date_tosamplestability) {
            $dateTo = Carbon::parse($request->date_tosamplestability)->endOfDay();
            $query->whereDate('intiation_date', '<=', $dateTo);
        }

        
        if ($request->sort_column && $request->sort_order) {
            $query->orderBy($request->sort_column, $request->sort_order);
        }

        $samplestability = $query->get();

        $htmlData = view('frontend.forms.Logs.filterData.samplestability_data', compact('samplestability'))->render();

        $res['body'] = $htmlData;

    } catch (\Exception $e) {
        $res['status'] = 'error';
        $res['message'] = $e->getMessage();
    }

    return response()->json($res);
}

public function printPDFSS(Request $request)
{
    $filterCC = $request->all();

    // dd($filterCC);
    $department = $filterCC['department'] ?? null; 
    $changerelateTo = $filterCC['changerelateTo'] ?? null; 
    $classification = $filterCC['dateFrom'] ?? null; 
    $Initiator = $filterCC['Initiator'] ?? null;
    
    $To = $filterCC['dateTo'] ?? null; 
   
    $query = SampleStability::query();

    $query->when($department, function ($q) use ($department) {
        return $q->where('Initiator_Group', $department);
    });

   
    $query->when($Initiator, function ($q) use ($Initiator) {
        return $q->where('initiator_id', $Initiator);
    });

    $query->when($classification, function ($q) use ($classification) {
        return $q->where('intiation_date', $classification);
    });

    $query->when($To, function ($q) use ($To) {
        return $q->where('intiation_date', $To);
    });

  
    $filteredDataCC = $query->get();

    $rowsPerPage = 7;
    $totalRows = $filteredDataCC->count();
    $totalPages = ceil($totalRows / $rowsPerPage);
    $paginatedData = $filteredDataCC->chunk($rowsPerPage);

    

    $pdf = Pdf::loadView('frontend.forms.Logs.sslogpdf', compact('rowsPerPage','paginatedData','totalPages','filteredDataCC'))->setPaper('a4', 'landscape');

    return $pdf->stream('report.pdf');
}

// Sample Planning Log Filter 
public function sampleplaining_filter(Request $request)
{
    $res = [
        'status' => 'ok',
        'message' => 'success',
        'body' => []
    ];

    try {
        $query = SamplePlanning::query();

        // Handle department filter when multiple departments are selected
        if (!empty($request->department_sampleplanning)) {
            $query->whereIn('Initiator_Group', $request->department_sampleplanning);  // Use whereIn for multiple selections
        }

        if ($request->division_id_sampleplanning) {
            $query->where('division_id', $request->division_id_sampleplanning);
        }

        if ($request->initiator_id_sampleplanning) {
            $query->where('initiator_id', $request->initiator_id_sampleplanning);
        }

        if ($request->date_fromsampleplanning) {
            $dateFrom = Carbon::parse($request->date_fromsampleplanning)->startOfDay();
            $query->whereDate('intiation_date', '>=', $dateFrom);
        }

        if ($request->date_tosampleplanning) {
            $dateTo = Carbon::parse($request->date_tosampleplanning)->endOfDay();
            $query->whereDate('intiation_date', '<=', $dateTo);
        }

        
        if ($request->sort_column && $request->sort_order) {
            $query->orderBy($request->sort_column, $request->sort_order);
        }

        $sampleplanning = $query->get();

        $htmlData = view('frontend.forms.Logs.filterData.sampleplanning_data', compact('sampleplanning'))->render();

        $res['body'] = $htmlData;

    } catch (\Exception $e) {
        $res['status'] = 'error';
        $res['message'] = $e->getMessage();
    }

    return response()->json($res);
}

public function printPDFSP(Request $request)
{
    $filterCC = $request->all();

    // dd($filterCC);
    $department = $filterCC['department'] ?? null; 
    $changerelateTo = $filterCC['changerelateTo'] ?? null; 
    $classification = $filterCC['dateFrom'] ?? null; 
    $Initiator = $filterCC['Initiator'] ?? null;
    
    $To = $filterCC['dateTo'] ?? null; 
   
    $query = SamplePlanning::query();

    $query->when($department, function ($q) use ($department) {
        return $q->where('Initiator_Group', $department);
    });

   
    $query->when($Initiator, function ($q) use ($Initiator) {
        return $q->where('initiator_id', $Initiator);
    });

    $query->when($classification, function ($q) use ($classification) {
        return $q->where('intiation_date', $classification);
    });

    $query->when($To, function ($q) use ($To) {
        return $q->where('intiation_date', $To);
    });

  
    $filteredDataCC = $query->get();

    $rowsPerPage = 7;
    $totalRows = $filteredDataCC->count();
    $totalPages = ceil($totalRows / $rowsPerPage);
    $paginatedData = $filteredDataCC->chunk($rowsPerPage);

    

    $pdf = Pdf::loadView('frontend.forms.Logs.filterData.splogpdf', compact('rowsPerPage','paginatedData','totalPages','filteredDataCC'))->setPaper('a4', 'landscape');

    return $pdf->stream('report.pdf');
}


// Control Sample Log Filter 

public function controlsample_filter(Request $request)
{
    $res = [
        'status' => 'ok',
        'message' => 'success',
        'body' => []
    ];

    try {
        $query = ControlSample::query();

        // Handle department filter when multiple departments are selected
        if (!empty($request->department_controlsample)) {
            $query->whereIn('market', $request->department_controlsample);  // Use whereIn for multiple selections
        }

        if ($request->division_id_controlsample) {
            $query->where('division_id', $request->division_id_controlsample);
        }

        if ($request->initiator_id_controlsample) {
            $query->where('initiator_id', $request->initiator_id_controlsample);
        }

        if ($request->date_fromcontrolsample) {
            $dateFrom = Carbon::parse($request->date_fromcontrolsample)->startOfDay();
            $query->whereDate('intiation_date', '>=', $dateFrom);
        }

        if ($request->date_tocontrolsample) {
            $dateTo = Carbon::parse($request->date_tocontrolsample)->endOfDay();
            $query->whereDate('intiation_date', '<=', $dateTo);
        }

        
        if ($request->sort_column && $request->sort_order) {
            $query->orderBy($request->sort_column, $request->sort_order);
        }

        $controlsample = $query->get();

        $htmlData = view('frontend.forms.Logs.filterData.controlsample_data', compact('controlsample'))->render();

        $res['body'] = $htmlData;

    } catch (\Exception $e) {
        $res['status'] = 'error';
        $res['message'] = $e->getMessage();
    }

    return response()->json($res);
}

public function printPDFCS(Request $request)
{
    $filterCC = $request->all();

    // dd($filterCC);
    $department = $filterCC['department'] ?? null; 
    $changerelateTo = $filterCC['changerelateTo'] ?? null; 
    $classification = $filterCC['dateFrom'] ?? null; 
    $Initiator = $filterCC['Initiator'] ?? null;
    
    $To = $filterCC['dateTo'] ?? null; 
   
    $query = ControlSample::query();

    $query->when($department, function ($q) use ($department) {
        return $q->where('Initiator_Group', $department);
    });

   
    $query->when($Initiator, function ($q) use ($Initiator) {
        return $q->where('initiator_id', $Initiator);
    });

    $query->when($classification, function ($q) use ($classification) {
        return $q->where('intiation_date', $classification);
    });

    $query->when($To, function ($q) use ($To) {
        return $q->where('intiation_date', $To);
    });

  
    $filteredDataCC = $query->get();

    $rowsPerPage = 7;
    $totalRows = $filteredDataCC->count();
    $totalPages = ceil($totalRows / $rowsPerPage);
    $paginatedData = $filteredDataCC->chunk($rowsPerPage);

    

    $pdf = Pdf::loadView('frontend.forms.Logs.filterData.cslogpdf', compact('rowsPerPage','paginatedData','totalPages','filteredDataCC'))->setPaper('a4', 'landscape');

    return $pdf->stream('report.pdf');
}

// Inventory Management Log Filter

public function inventorymanagement_filter(Request $request)
{
    $res = [
        'status' => 'ok',
        'message' => 'success',
        'body' => []
    ];

    try {
        $query = InventoryManagement::query();

        // Handle department filter when multiple departments are selected
      
        if ($request->division_id_inventorymanagement) {
            $query->where('division_id', $request->division_id_inventorymanagement);
        }

        if ($request->initiator_id_inventorymanagement) {
            $query->where('initiator_id', $request->initiator_id_inventorymanagement);
        }

        if ($request->date_frominventorymanagement) {
            $dateFrom = Carbon::parse($request->date_frominventorymanagement)->startOfDay();
            $query->whereDate('intiation_date', '>=', $dateFrom);
        }

        if ($request->date_toinventorymanagement) {
            $dateTo = Carbon::parse($request->date_toinventorymanagement)->endOfDay();
            $query->whereDate('intiation_date', '<=', $dateTo);
        }

        
        if ($request->sort_column && $request->sort_order) {
            $query->orderBy($request->sort_column, $request->sort_order);
        }

        $inventorymanagement = $query->get();

        $htmlData = view('frontend.forms.Logs.filterData.inventorymanagement_data', compact('inventorymanagement'))->render();

        $res['body'] = $htmlData;

    } catch (\Exception $e) {
        $res['status'] = 'error';
        $res['message'] = $e->getMessage();
    }

    return response()->json($res);
}

public function printPDFIM(Request $request)
{
    $filterCC = $request->all();

    // dd($filterCC);
    $department = $filterCC['department'] ?? null; 
    $changerelateTo = $filterCC['changerelateTo'] ?? null; 
    $classification = $filterCC['dateFrom'] ?? null; 
    $Initiator = $filterCC['Initiator'] ?? null;
    
    $To = $filterCC['dateTo'] ?? null; 
   
    $query = InventoryManagement::query();

    $query->when($department, function ($q) use ($department) {
        return $q->where('Initiator_Group', $department);
    });

   
    $query->when($Initiator, function ($q) use ($Initiator) {
        return $q->where('initiator_id', $Initiator);
    });

    $query->when($classification, function ($q) use ($classification) {
        return $q->where('intiation_date', $classification);
    });

    $query->when($To, function ($q) use ($To) {
        return $q->where('intiation_date', $To);
    });

  
    $filteredDataCC = $query->get();

    $rowsPerPage = 7;
    $totalRows = $filteredDataCC->count();
    $totalPages = ceil($totalRows / $rowsPerPage);
    $paginatedData = $filteredDataCC->chunk($rowsPerPage);

    

    $pdf = Pdf::loadView('frontend.forms.Logs.filterData.inventorymlogpdf', compact('rowsPerPage','paginatedData','totalPages','filteredDataCC'))->setPaper('a4', 'landscape');

    return $pdf->stream('report.pdf');
}
// new process 

    public function Preventive_filter(Request $request)
    {
        $res = [
            'status' => 'ok',
            'message' => 'success',
            'body' => []
        ];
    
        try {
            $query = PreventiveMaintenance::query();
    
            
            if (!empty($request->department_preventive)) {
                $query->whereIn('pm_schedule', $request->department_preventive);  // Use whereIn for multiple selections
            }
            
            if ($request->division_id_preventive) {
                $query->where('division_id', $request->division_id_preventive);
            }

            if ($request->initiator_id_preventive) {
                $query->where('initiator_id', $request->initiator_id_preventive);
            }
    
            if ($request->date_frompreventive) {
                $dateFrom = Carbon::parse($request->date_frompreventive)->startOfDay();
                $query->whereDate('intiation_date', '>=', $dateFrom);
            }

            if ($request->date_topreventive) {
                $dateTo = Carbon::parse($request->date_topreventive)->endOfDay();
                $query->whereDate('intiation_date', '<=', $dateTo);
            }
            if ($request->sort_column && $request->sort_order) {
                $query->orderBy($request->sort_column, $request->sort_order);
            }
    
            $preventiveM = $query->get();
    
            $htmlData = view('frontend.forms.Logs.filterData.preventive_data', compact('preventiveM'))->render();
    
            $res['body'] = $htmlData;
    
        } catch (\Exception $e) {
            $res['status'] = 'error';
            $res['message'] = $e->getMessage();
        }
    
        return response()->json($res);
    }
    



    

    
    public function failureInv_filter(Request $request)
    {
        $res = [
            'status' => 'ok',
            'message' => 'success',
            'body' => []
        ];

        try {

            
            $query = FailureInvestigation::query();
            
            if ($request->department_failureLog)
            {
                $query->where('Initiator_Group', $request->department_failureLog);
            }

            if($request->div_id_failure)
            {
                $query->where('division_id',$request->div_id_failure);
            }

            

            // if($request->nchange)
            // {
            //     $query->where('doc_change',$request->nchange);
            // }

            if ($request->period_failure) {
                $currentDate = Carbon::now();
                switch ($request->period_failure) {
                    case 'Yearly':
                        $startDate = $currentDate->startOfYear();
                        break;
                    case 'Quarterly':
                        $startDate = $currentDate->firstOfQuarter();
                        break;
                    case 'Monthly':
                        $startDate = $currentDate->startOfMonth();
                        break;
                    default:
                        $startDate = null;
                        break;
                }
                if ($startDate) {
                    $query->whereDate('intiation_date', '>=', $startDate);
                }
            }

            
            if ($request->dateFailureFrom) {
           
                $datefrom = Carbon::parse($request->dateFailureFrom)->startOfDay();
               
                $query->whereDate('intiation_date', '>=', $datefrom);
            }
            
            if ($request->dateFailureTo) {
                $dateTo = Carbon::parse($request->dateFailureTo)->startOfDay();
                $query->whereDate('intiation_date', '>=', $dateTo);

            }
            
            


            $failure = $query->get();

            $htmlData = view('frontend.forms.Logs.filterData.failureinvestigation_data', compact('failure'))->render();
            

            $res['body'] = $htmlData;


        } catch (\Exception $e) {
            $res['status'] = 'error';
            $res['message'] = $e->getMessage();
        }


        return response()->json($res);
        
    }
    
    
    public function IncidentFilter(Request $request)
{
    $res = [
        'status' => 'ok',
        'message' => 'success',
        'body' => []
    ];

    try {
        $query = Incident::query();

        if ($request->departmentIncident) {
            $query->where('Initiator_Group', $request->departmentIncident);
        }

        if ($request->division_idIncident) {
            $query->where('division_id', $request->division_idIncident);
        }

        if ($request->period) {
            $currentDate = Carbon::now();
            switch ($request->period) {
                case 'Yearly':
                    $startDate = $currentDate->startOfYear();
                    break;
                case 'Quarterly':
                    $startDate = $currentDate->firstOfQuarter();
                    break;
                case 'Monthly':
                    $startDate = $currentDate->startOfMonth();
                    break;
                default:
                    $startDate = null;
                    break;
            }
            if ($startDate) {
                $query->whereDate('intiation_date', '>=', $startDate);
            }
        }

        if ($request->date_fromIncident) {
            $dateFrom = Carbon::parse($request->date_fromIncident)->startOfDay();
            $query->whereDate('intiation_date', '>=', $dateFrom);
           }

        if ($request->date_toIncident) {
            $dateTo = Carbon::parse($request->date_toIncident)->endOfDay();
            $query->whereDate('intiation_date', '<=', $dateTo);
           }

        $Inc = $query->get();

        $htmlData = view('frontend.forms.logs.filterData.Inc_data', compact('Inc'))->render();

        $res['body'] = $htmlData;
    } catch (\Exception $e) {
        $res['status'] = 'error';
        $res['message'] = $e->getMessage();
    }

    return response()->json($res);
}

    
        public function internal_audit_filter(Request $request)
        {
            $res = [
                'status' => 'ok',
                'message' => 'success',
                'body' => []
            ];
    
            try {
    
                
                $query = InternalAudit::query();
                
                if ($request->department)
                {
                    $query->where('Initiator_Group', $request->department);
                }
    
                if($request->division_id)
                {
                    $query->where('division_id',$request->division_id);
                }
    
                
    
                if($request->taudit)
                {
                    $query->where('audit_type',$request->taudit);
                }
    
                if ($request->period) {
                    $currentDate = Carbon::now();
                    switch ($request->period) {
                        case 'Yearly':
                            $startDate = $currentDate->startOfYear();
                            break;
                        case 'Quarterly':
                            $startDate = $currentDate->firstOfQuarter();
                            break;
                        case 'Monthly':
                            $startDate = $currentDate->startOfMonth();
                            break;
                        default:
                            $startDate = null;
                            break;
                    }
                    if ($startDate) {
                        $query->whereDate('intiation_date', '>=', $startDate);
                    }
                }
                if ($request->date_from) {
                   
                    $dateFrom = Carbon::parse($request->date_from)->startOfDay();
                   
                    $query->whereDate('intiation_date', '>=', $dateFrom);
                }
        
                if ($request->date_to) {
                  
                    $dateTo = Carbon::parse($request->date_to)->endOfDay();
                  
                    $query->whereDate('intiation_date', '<=', $dateTo);
                }
                
    
    
                $internal_audi = $query->get();
    
                $htmlData = view('frontend.forms.Logs.filterData.internal_audit_data', compact('internal_audi'))->render();
                
    
                $res['body'] = $htmlData;
    
    
            } catch (\Exception $e) {
                $res['status'] = 'error';
                $res['message'] = $e->getMessage();
    
            }
    
    
            return response()->json($res);
            
        }






        public function labincident_filter(Request $request)
    {
        $res = [
            'status' => 'ok',
            'message' => 'success',
            'body' => []
        ];

        try {

            
            $query = LabIncident::query();
            
            if ($request->department_Lab)
            {
                $query->where('Initiator_Group', $request->department_Lab);
            }
            if($request->divivisionLab_id)
            {
                $query->where('division_id',$request->divivisionLab_id);
            }

            if ($request->period_lab) {
                $currentDate = Carbon::now();
                switch ($request->period_lab) {
                    case 'Yearly':
                        $startDate = $currentDate->startOfYear();
                        break;
                    case 'Quarterly':
                        $startDate = $currentDate->firstOfQuarter();
                        break;
                    case 'Monthly':
                        $startDate = $currentDate->startOfMonth();
                        break;
                    default:
                        $startDate = null;
                        break;
                }
                if ($startDate) {
                    $query->whereDate('intiation_date', '>=', $startDate);
                }
            }

            if ($request->dateFrom) {
               
                $datefrom = Carbon::parse($request->dateFrom)->startOfDay();
               
                $query->whereDate('intiation_date', '>=', $datefrom);
            }
    
            if ($request->dateTo) {
              
                $dateo = Carbon::parse($request->dateTo)->endOfDay();
              
                $query->whereDate('intiation_date', '<=', $dateo);
            }
            if($request->TypeOFIncidence)
            {
                $query->where('type_incidence_ia',$request->TypeOFIncidence);
            }


            $labincident = $query->get();

            $htmlData = view('frontend.forms.Logs.filterData.labincident_data', compact('labincident'))->render();
            

            $res['body'] = $htmlData;


        } catch (\Exception $e) {
            $res['status'] = 'error';
            $res['message'] = $e->getMessage();

        }


        return response()->json($res);
        
    }


    public function marketcomplaint_filter(Request $request)
    {
        $res = [
            'status' => 'ok',
            'message' => 'success',
            'body' => []
        ];

        try {

            
            $query = MarketComplaint::query();
            
            

            if (!empty($request->department_market)) {
                $query->whereIn('Initiator_Group', $request->department_market);  // Use whereIn for multiple selections
            }
            if ($request->initiator_id_market) {
                $query->where('initiator_id', $request->initiator_id_market);
            }
    

            if($request->division_id_market)
            {
                $query->where('division_id',$request->division_id_market);
            }
            

            if ($request->date_frommarket) {
               
                $datefrom = Carbon::parse($request->date_frommarket)->startOfDay();
               
                $query->whereDate('intiation_date', '>=', $datefrom);
            }
    
            if ($request->date_tomarket) {
              
                $dateo = Carbon::parse($request->date_tomarket)->endOfDay();
              
                $query->whereDate('intiation_date', '<=', $dateo);
            }

            $marketcomplaint = $query->get();

            $htmlData = view('frontend.forms.Logs.filterData.marketcomplaint_data', compact('marketcomplaint'))->render();
            

            $res['body'] = $htmlData;


        } catch (\Exception $e) {
            $res['status'] = 'error';
            $res['message'] = $e->getMessage();

        }


        return response()->json($res);
        
    }

    public function OOT_Filter(Request $request)
    {
        $res = [
            'status' => 'ok',
            'message' => 'success',
            'body' => []
        ];
    
        try {
            // Query for OOT table
            $ootQuery = Ootc::query();
    
            if (!empty($request->department_oos)) {
                $ootQuery->whereIn('initiator_group', $request->department_oos);
            }
    
            if ($request->division_id_oos) {
                $ootQuery->where('division_id', $request->division_id_oos);
            }
    
            if ($request->initiator_id_oos) {
                $ootQuery->where('initiator_id', $request->initiator_id_oos);
            }
    
            if ($request->date_fromoos) {
                $dateFrom = Carbon::parse($request->date_fromoos)->startOfDay();
                $ootQuery->whereDate('intiation_date', '>=', $dateFrom);
            }
    
            if ($request->date_tooos) {
                $dateTo = Carbon::parse($request->date_tooos)->endOfDay();
                $ootQuery->whereDate('intiation_date', '<=', $dateTo);
            }
    
            // Get OOT filtered data
            $oots = $ootQuery->get();
    
            // Query for OOS table
            $oosQuery = OOS::query();
    
            if (!empty($request->department_oos)) {
                $oosQuery->whereIn('initiator_group', $request->department_oos);
            }
    
            if ($request->division_id_oos) {
                $oosQuery->where('division_id', $request->division_id_oos);
            }
    
            if ($request->initiator_id_oos) {
                $oosQuery->where('initiator_id', $request->initiator_id_oos);
            }
    
            if ($request->date_fromoos) {
                $dateFrom = Carbon::parse($request->date_fromoos)->startOfDay();
                $oosQuery->whereDate('intiation_date', '>=', $dateFrom);
            }
    
            if ($request->date_tooos) {
                $dateTo = Carbon::parse($request->date_tooos)->endOfDay();
                $oosQuery->whereDate('intiation_date', '<=', $dateTo);
            }
    
            // Get OOS filtered data
            $oos = $oosQuery->get();
    
            // Render both OOT and OOS data to the view
            $htmlData = view('frontend.forms.Logs.filterData.OOS_OOT_log_data', compact('oots', 'oos'))->render();
    
            $res['body'] = $htmlData;
        } catch (\Exception $e) {
            $res['status'] = 'error';
            $res['message'] = $e->getMessage();
        }
    
        return response()->json($res);
    }
    

    public function nonconformance_filter(Request $request)
    {
        $res = [
            'status' => 'ok',
            'message' => 'success',
            'body' => []
        ];
    
        try {
    
    
            $query = NonConformance::query();
    
            if ($request->department_non) 
            {
                $query->where('Initiator_Group', $request->department_non);
            }
            if ($request->division_non) {
                $query->where('division_id', $request->division_non);
            }
    
            if ($request->period_non) {
                $currentDate = Carbon::now();
                switch ($request->period_non) {
                    case 'Yearly':
                        $startDate = $currentDate->startOfYear();
                        break;
                    case 'Quarterly':
                        $startDate = $currentDate->firstOfQuarter();
                        break;
                    case 'Monthly':
                        $startDate = $currentDate->startOfMonth();
                        break;
                    default:
                        $startDate = null;
                        break;
                }
                if ($startDate) {
                    $query->whereDate('intiation_date', '>=', $startDate);
                }
            }
    
            if ($request->dateFrom_non) {
    
                $datefrom = Carbon::parse($request->dateFrom_non)->startOfDay();
    
                $query->whereDate('intiation_date', '>=', $datefrom);
            }
    
            if ($request->dateTo_non) {
                $dateto = Carbon::parse($request->dateTo_non)->endOfDay();
                $query->whereDate('intiation_date', '<=', $dateto);
            }
           
            if ($request->TypeOfDocument) {
                $query->where('type_incidence_ia', $request->TypeOfDocument);
            }
    
    
            $nonconformance = $query->get();
    
            $htmlData = view('frontend.forms.Logs.filterData.nonconformancedata', compact('nonconformance'))->render();
    
    
            $res['body'] = $htmlData;
    
    
        } catch (\Exception $e) {
            $res['status'] = 'error';
            $res['message'] = $e->getMessage();
    
        }
    
    
        return response()->json($res);
    
    }
    

    public function ooc_filter(Request $request)
    {
        $res = [
            'status' => 'ok',
            'message' => 'success',
            'body' => []
        ];

        try {

            
            $query = OutOfCalibration::query();
            
            if ($request->department_outofcalibration)
            {
                $query->where('Initiator_Group', $request->department_outofcalibration);
            }

            if($request->div_id_outofcalibration)
            {
                $query->where('division_id',$request->div_id_outofcalibration);
            }

            if ($request->instrument_equipment && $request->instrument_value) {
                if ($request->instrument_equipment === 'instrument_name') {
                    $query->where('instrument_name', $request->instrument_value);
                } elseif ($request->instrument_equipment === 'instrument_id') {
                    $query->where('instrument_id', $request->instrument_value);
                }
            }
    
            // if($request->categoryofcomplaints)
            // {
            //     $query->where('categorization_of_complaint_gi',$request->categoryofcomplaints);
            // }

            if ($request->period_outofcalibration) {
                $currentDate = Carbon::now();
                switch ($request->period_outofcalibration) {
                    case 'Yearly':
                        $startDate = $currentDate->startOfYear();
                        break;
                    case 'Quarterly':
                        $startDate = $currentDate->firstOfQuarter();
                        break;
                    case 'Monthly':
                        $startDate = $currentDate->startOfMonth();
                        break;
                    default:
                        $startDate = null;
                        break;
                }
                if ($startDate) {
                    $query->whereDate('intiation_date', '>=', $startDate);
                }
            }

            if ($request->date_OOC_from) {
               
                $datefrom = Carbon::parse($request->date_OOC_from)->startOfDay();
               
                $query->whereDate('intiation_date', '>=', $datefrom);
            }
    
            if ($request->date_OOC_to) {
              
                $dateo = Carbon::parse($request->date_OOC_to)->endOfDay();
              
                $query->whereDate('intiation_date', '<=', $dateo);
            }

            $oocs = $query->get();

            $htmlData = view('frontend.forms.Logs.filterData.outofcalibration_data', compact('oocs'))->render();
            

            $res['body'] = $htmlData;


        } catch (\Exception $e) {
            $res['status'] = 'error';
            $res['message'] = $e->getMessage();

        }


        return response()->json($res);
        
    }

    
    public function errata_filter(Request $request)
    {
        $res = [
            'status' => 'ok',
            'message' => 'success',
            'body' => []
        ];

        try {

            
            $query = errata::query();
            
            if ($request->department_e)
            {
                $query->where('department_code', $request->department_e);
            }

            if($request->division_id)
            {
                $query->where('division_id',$request->division_id);
            }

            if($request->nchange)
            {
                $query->where('doc_change',$request->nchange);
            }

            if ($request->period) {
                $currentDate = Carbon::now();
                switch ($request->period) {
                    case 'Yearly':
                        $startDate = $currentDate->startOfYear();
                        break;
                    case 'Quarterly':
                        $startDate = $currentDate->firstOfQuarter();
                        break;
                    case 'Monthly':
                        $startDate = $currentDate->startOfMonth();
                        break;
                    default:
                        $startDate = null;
                        break;
                }
                if ($startDate) {
                    $query->whereDate('intiation_date', '>=', $startDate);
                }
            }

            if ($request->date_from) {
                $query->whereDate('intiation_date', '>=', Carbon::parse($request->date_from));
            }
            
            if ($request->date_to) {
                $query->whereDate('intiation_date', '<=', Carbon::parse($request->date_to));
            }

            if($request->error_er)
            {
                $query->where('type_of_error',$request->error_er);
            }
            


            $erratalog = $query->get();

            $htmlData = view('frontend.forms.Logs.filterData.errata_data', compact('erratalog'))->render();
            

            $res['body'] = $htmlData;


        } catch (\Exception $e) {
            $res['status'] = 'error';
            $res['message'] = $e->getMessage();
        }


        return response()->json($res);
    }

    public function risk_management_filter(Request $request)
    {
        $res = [
            'status' => 'ok',
            'message' => 'success',
            'body' => []
        ];

        try {

            
            $query = RiskManagement::query();
            
          
            if (!empty($request->department_risk)) {
                $query->whereIn('Initiator_Group', $request->department_risk);  // Use whereIn for multiple selections
            }
    
            if ($request->division_id_risk) {
                $query->where('division_id', $request->division_id_risk);
            }
    
            if ($request->initiator_id_risk) {
                $query->where('initiator_id', $request->initiator_id_risk);
            }
    
            if($request->sor)
            {
                $query->where('source_of_risk',$request->sor);
            }

            if ($request->period) {
                $currentDate = Carbon::now();
                switch ($request->period) {
                    case 'Yearly':
                        $startDate = $currentDate->startOfYear();
                        break;
                    case 'Quarterly':
                        $startDate = $currentDate->firstOfQuarter();
                        break;
                    case 'Monthly':
                        $startDate = $currentDate->startOfMonth();
                        break;
                    default:
                        $startDate = null;
                        break;
                }
                if ($startDate) {
                    $query->whereDate('intiation_date', '>=', $startDate);
                }
            }

            if ($request->date_from_risk) {
                $query->whereDate('intiation_date', '>=', Carbon::parse($request->date_from_risk));
            }
            
            if ($request->date_to_risk) {
                $query->whereDate('intiation_date', '<=', Carbon::parse($request->date_to_risk));
            }

            if($request->error_er)
            {
                $query->where('type_of_error',$request->error_er);
            }
            


            $riskmlog = $query->get();

            $htmlData = view('frontend.forms.Logs.filterData.riskmanagement_data', compact('riskmlog'))->render();
            

            $res['body'] = $htmlData;


        } catch (\Exception $e) {
            $res['status'] = 'error';
            $res['message'] = $e->getMessage();
        }


        return response()->json($res);
    }

    public function deviation_filter(Request $request)
{
    $res = [
        'status' => 'ok',
        'message' => 'success',
        'body' => []
    ];

    try {
        $query = Deviation::query();

        if (!empty($request->department_deviation)) {
            $query->whereIn('Initiator_Group', $request->department_deviation);  // Use whereIn for multiple selections
        }

        if ($request->division_id_deviation) {
            $query->where('division_id', $request->division_id_deviation);
        }

        if ($request->initiator_id_deviation) {
            $query->where('initiator_id', $request->initiator_id_deviation);
        }

        if ($request->date_fromdeviation) {
            $dateFrom = Carbon::parse($request->date_fromdeviation)->startOfDay();
            $query->whereDate('intiation_date', '>=', $dateFrom);
        }

        if ($request->date_todeviation) {
            $dateTo = Carbon::parse($request->date_todeviation)->endOfDay();
            $query->whereDate('intiation_date', '<=', $dateTo);
        }

      
        if ($request->sort_column && $request->sort_order) {
            $query->orderBy($request->sort_column, $request->sort_order);
        }


        $deviation = $query->get();

        $htmlData = view('frontend.forms.Logs.filterData.deviation_data', compact('deviation'))->render();

        $res['body'] = $htmlData;
    } catch (\Exception $e) {
        $res['status'] = 'error';
        $res['message'] = $e->getMessage();
    }

    return response()->json($res);
}

    


public function printPDFCC(Request $request)
{
    $filterCC = $request->all();

    // dd($filterCC);
    $department = $filterCC['department'] ?? null; 
    $changerelateTo = $filterCC['changerelateTo'] ?? null; 
    $classification = $filterCC['dateFrom'] ?? null; 
    $Initiator = $filterCC['Initiator'] ?? null;
    
    $To = $filterCC['dateTo'] ?? null; 
    $changeCategory = $filterCC['RadioActivtiyCCC'] ?? null;
    $changeCategorytcc = $filterCC['RadioActivtiyTCC'] ?? null;

    $query = CC::query();

    $query->when($department, function ($q) use ($department) {
        return $q->where('initiator_Group', $department);
    });

    $query->when($changerelateTo, function ($q) use ($changerelateTo) {
        return $q->where('severity', $changerelateTo);
    });

    $query->when($Initiator, function ($q) use ($Initiator) {
        return $q->where('initiator_id', $Initiator);
    });

    $query->when($classification, function ($q) use ($classification) {
        return $q->where('intiation_date', $classification);
    });

    $query->when($To, function ($q) use ($To) {
        return $q->where('intiation_date', $To);
    });

    if ($changeCategory) {
        $categories = explode(',', $changeCategory); 
        $query->whereIn('doc_change', $categories);
    }

    if ($changeCategorytcc) {
        $categoriestcc = explode(',', $changeCategory); 
        $query->whereIn('doc_change', $categoriestcc);
    }

    $filteredDataCC = $query->get();

    $rowsPerPage = 7;
    $totalRows = $filteredDataCC->count();
    $totalPages = ceil($totalRows / $rowsPerPage);
    $paginatedData = $filteredDataCC->chunk($rowsPerPage);

    

    $pdf = Pdf::loadView('frontend.forms.Logs.cclogpdf', compact('rowsPerPage','paginatedData','totalPages','filteredDataCC','changeCategory','changeCategorytcc'))->setPaper('a4', 'landscape');

    return $pdf->stream('report.pdf');
}

public function printPDF(Request $request)
{
    $filters = $request->all(); 
    
    $department = $filterCC['department'] ?? null; 
    $changerelateTo = $filterCC['changerelateTo'] ?? null; 
    $classification = $filterCC['dateFrom'] ?? null; 
    $Initiator = $filterCC['Initiator'] ?? null;
    
    $To = $filterCC['dateTo'] ?? null; 
   
    $query = Capa::query();

    $query->when($department, function ($q) use ($department) {
        return $q->where('initiator_Group', $department);
    });

  
    $query->when($Initiator, function ($q) use ($Initiator) {
        return $q->where('initiator_id', $Initiator);
    });

    $query->when($classification, function ($q) use ($classification) {
        return $q->where('intiation_date', $classification);
    });

    $query->when($To, function ($q) use ($To) {
        return $q->where('intiation_date', $To);
    });

   
    $filteredDataCC = $query->get();

    $rowsPerPage = 7;
    $totalRows = $filteredDataCC->count();
    $totalPages = ceil($totalRows / $rowsPerPage);
    $paginatedData = $filteredDataCC->chunk($rowsPerPage);

    

    $pdf = Pdf::loadView('frontend.forms.Logs.capapdf', compact('rowsPerPage','paginatedData','totalPages','filteredDataCC'))->setPaper('a4', 'landscape');

    return $pdf->stream('report.pdf');
}

public function actonitem_filter(Request $request)
{
    $res = [
        'status' => 'ok',
        'message' => 'success',
        'body' => []
    ];

    try {
        $query = ActionItem::query();

        if (!empty($request->departmentaction)) {
            $query->whereIn('departments', $request->departmentaction);  // Use whereIn for multiple selections
        }

        if ($request->division_action) {
            $query->where('division_id', $request->division_action);
        }

        if ($request->initiator_id_action) {
            $query->where('initiator_id', $request->initiator_id_action);
        }

        if ($request->date_fromAction) {
            $dateFrom = Carbon::parse($request->date_fromAction)->startOfDay();
            $query->whereDate('created_at', '>=', $dateFrom);
        }

        if ($request->date_toAction) {
            $dateTo = Carbon::parse($request->date_toAction)->endOfDay();
            $query->whereDate('created_at', '<=', $dateTo);
        }

       
        if ($request->sort_column && $request->sort_order) {
            $query->orderBy($request->sort_column, $request->sort_order);
        }

        $actionitem  = $query->get();

        $htmlData = view('frontend.forms.Logs.filterData.actonitem_filter_log_data', compact('actionitem'))->render();

        $res['body'] = $htmlData;

    } catch (\Exception $e) {
        $res['status'] = 'error';
        $res['message'] = $e->getMessage();
    }

    return response()->json($res);
}




// public function printPDFAction (Request $request)
// {
//     $filterDD = $request->all();
//     // dd($filterDD);
    
//     $Actionclassificaton = $filterDD['department'] ?? null;
//     $Division = $filterDD['division'] ?? null;
//     $dateFrom = isset($filterDD['date_from']) ? Carbon::parse($filterDD['date_from'])->startOfDay() : null;
//     $dateTo = isset($filterDD['date_to']) ? Carbon::parse($filterDD['date_to'])->endOfDay() : null;
    
//     $query = ActionItem::query(); 
    
//     if ($Actionclassificaton) {
//         $query->where('departments', $Actionclassificaton);
//     }

//     if ($Division) {
//         $query->where('division_id', $Division);
//     }
                
//                     if ($dateFrom && $dateTo) {
//                         $query->whereBetween('created_at', [$dateFrom, $dateTo]);
//                     }
                    
//                     $FilterDDD = $query->get();
                    
//     // if ($FilterDDD->isEmpty()) {
//     //     return "No data found";
//     // }

//     $pdf = Pdf::loadView('frontend.forms.Logs.actionitemlogpdf', compact('FilterDDD'))->setPaper('a4', 'landscape');

//     return $pdf->stream('report.pdf');
// }


public function printPDFAction(Request $request)
{
    $filterCC = $request->all();

    // dd($filterCC);
    $department = $filterCC['department'] ?? null; 
    $changerelateTo = $filterCC['changerelateTo'] ?? null; 
    $classification = $filterCC['dateFrom'] ?? null; 
    $Initiator = $filterCC['Initiator'] ?? null;
    
    $To = $filterCC['dateTo'] ?? null; 
   
    $query = ActionItem::query();

    $query->when($department, function ($q) use ($department) {
        return $q->where('departments', $department);
    });

   
    $query->when($Initiator, function ($q) use ($Initiator) {
        return $q->where('initiator_id', $Initiator);
    });

    $query->when($classification, function ($q) use ($classification) {
        return $q->where('created_at', $classification);
    });

    $query->when($To, function ($q) use ($To) {
        return $q->where('created_at', $To);
    });

  
    $filteredData = $query->get();

    $rowsPerPage = 7;
    $totalRows = $filteredData->count();
    $totalPages = ceil($totalRows / $rowsPerPage);
    $paginatedData = $filteredData->chunk($rowsPerPage);

    $pdf = Pdf::loadView('frontend.forms.Logs.actionitemlogpdf', compact('filteredData','rowsPerPage','paginatedData','totalPages'))->setPaper('a4', 'landscape');

    return $pdf->stream('report.pdf');
}






public function rca_filter(Request $request)
{
    $res = [
        'status' => 'ok',
        'message' => 'success',
        'body' => []
    ];

    try {
        $query = RootCauseAnalysis::query();

        if (!empty($request->department_changecontrol)) {
            $query->whereIn('initiator_Group', $request->department_changecontrol);  // Use whereIn for multiple selections
        }

        if ($request->division_rca) {
            $query->where('division_id', $request->division_rca);
        }

        if ($request->initiator_id_rca) {
            $query->where('initiator_id', $request->initiator_id_rca);
        }

       
        if ($request->date_fromrca) {
            $dateFrom = Carbon::parse($request->date_fromrca)->startOfDay();
            $query->whereDate('created_at', '>=', $dateFrom);
        }

        if ($request->date_torca) {
            $dateTo = Carbon::parse($request->date_torca)->endOfDay();
            $query->whereDate('created_at', '<=', $dateTo);
        }

        // Apply Sorting if Specified
        if ($request->sort_column && $request->sort_order) {
            $query->orderBy($request->sort_column, $request->sort_order);
        }

        $rootcause = $query->get();
        $htmlData = view('frontend.forms.Logs.rca_filter_log_data', compact('rootcause'))->render();

        $res['body'] = $htmlData;

    } catch (\Exception $e) {
        $res['status'] = 'error';
        $res['message'] = $e->getMessage();
    }

    return response()->json($res);
}



public function printPDFRCA (Request $request)
{
    $filterDD = $request->all();
    // dd($filterDD);
    
    $Actionclassificaton = $filterDD['department'] ?? null;
    $Division = $filterDD['division'] ?? null;
    $dateFrom = isset($filterDD['date_from']) ? Carbon::parse($filterDD['date_from'])->startOfDay() : null;
    $dateTo = isset($filterDD['date_to']) ? Carbon::parse($filterDD['date_to'])->endOfDay() : null;
    
    $query = RootCauseAnalysis::query(); 
    
    if ($Actionclassificaton) {
        $query->where('initiator_Group', $Actionclassificaton);
    }

    if ($Division) {
        $query->where('division_id', $Division);
    }
                
                    if ($dateFrom && $dateTo) {
                        $query->whereBetween('created_at', [$dateFrom, $dateTo]);
                    }
                    
                    $FilterDDD = $query->get();
                    
    // if ($FilterDDD->isEmpty()) {
    //     return "No data found";
    // }

    $pdf = Pdf::loadView('frontend.forms.Logs.rcalogpdf', compact('FilterDDD'))->setPaper('a4', 'landscape');

    return $pdf->stream('report.pdf');
}
    





public function extension_filter(Request $request)
{
    $res = [
        'status' => 'ok',
        'message' => 'success',
        'body' => []
    ];

    try {
        $query = extension_new::query();

        if ($request->departmentextension) {
            $query->where('priority_data', $request->departmentextension);
        }

        if ($request->division_extension) {
            $query->where('site_location_code', $request->division_extension);
        }

        if ($request->date_fromextension) {
            $dateFrom = Carbon::parse($request->date_fromextension)->startOfDay();
            $query->whereDate('created_at', '>=', $dateFrom);
        }

        if ($request->date_to_extension) {
            $dateTo = Carbon::parse($request->date_to_extension)->endOfDay();
            $query->whereDate('created_at', '<=', $dateTo);
        }

        // Apply Sorting if Specified
        if ($request->sort_column && $request->sort_order) {
            $query->orderBy($request->sort_column, $request->sort_order);
        }

        $extension = $query->get();
        $htmlData = view('frontend.forms.Logs.extension_data', compact('extension'))->render();

        $res['body'] = $htmlData;

    } catch (\Exception $e) {
        $res['status'] = 'error';
        $res['message'] = $e->getMessage();
    }

    return response()->json($res);
}




public function printPDFExtension (Request $request)
{
    $filterDD = $request->all();
    
    $Actionclassificaton = $filterDD['department'] ?? null;
    // dd($Actionclassificaton);
    $Division = $filterDD['division'] ?? null;
    $dateFrom = isset($filterDD['date_from']) ? Carbon::parse($filterDD['date_from'])->startOfDay() : null;
    $dateTo = isset($filterDD['date_to']) ? Carbon::parse($filterDD['date_to'])->endOfDay() : null;
    
    $query = extension_new::query(); 
    
    if ($Actionclassificaton) {
        $query->where('priority_data', $Actionclassificaton);
    }

    if ($Division) {
        $query->where('division_id', $Division);
    }
                
                    if ($dateFrom && $dateTo) {
                        $query->whereBetween('created_at', [$dateFrom, $dateTo]);
                    }
                    
                    $FilterDDD = $query->get();
                    
    

    $pdf = Pdf::loadView('frontend.forms.Logs.extension_pdf', compact('FilterDDD'))->setPaper('a4', 'landscape');

    return $pdf->stream('report.pdf');
}



public function effectivness(Request $request)
{
    $res = [
        'status' => 'ok',
        'message' => 'success',
        'body' => []
    ];

    try {
        $query = EffectivenessCheck::query();

        if (!empty($request->departmenteffectivness)) {
            $query->whereIn('Initiator_Group', $request->departmenteffectivness);  
        }

        if ($request->division_effectivness) {
            $query->where('division_id', $request->division_effectivness);
        }

        if ($request->date_fromeffectivness && $request->date_toeffectiveness) {
            $dateFrom = Carbon::parse($request->date_fromeffectivness)->format('Y-m-d');
            $dateTo = Carbon::parse($request->date_toeffectiveness)->format('Y-m-d');
            
            $query->whereBetween('intiation_date', [$dateFrom, $dateTo]); // Use whereBetween for date range
        } elseif ($request->date_fromeffectivness) {
            $dateFrom = Carbon::parse($request->date_fromeffectivness)->format('Y-m-d');
            $query->where('intiation_date', '>=', $dateFrom);
        } elseif ($request->date_toeffectiveness) {
            $dateTo = Carbon::parse($request->date_toeffectiveness)->format('Y-m-d');
            $query->where('intiation_date', '<=', $dateTo);
        }

        if ($request->initiator_id_effectiveness) {
            $query->where('initiator_id', $request->initiator_id_effectiveness);
        }

        if ($request->sort_column && $request->sort_order) {
            $query->orderBy($request->sort_column, $request->sort_order);
        }

        $effectivness = $query->get();

        if ($effectivness->isEmpty()) {
            $res['status'] = 'no_data';
            $res['message'] = 'No records found for the given criteria.';
        } else {
            $htmlData = view('frontend.forms.Logs.filterData.effectiveness_data', compact('effectivness'))->render();
            $res['body'] = $htmlData;
        }

    } catch (\Exception $e) {
        $res['status'] = 'error';
        $res['message'] = $e->getMessage();
    }

    return response()->json($res);
}





    


    public function printPDFEffectivenesss (Request $request)
{
    $filterDD = $request->all();
    $Division = $filterDD['division'] ?? null;
    $dateFrom = isset($filterDD['date_from']) ? Carbon::parse($filterDD['date_from'])->startOfDay() : null;
    $dateTo = isset($filterDD['date_to']) ? Carbon::parse($filterDD['date_to'])->endOfDay() : null;
    
    $query = EffectivenessCheck::query(); 
    
   
    if ($Division) {
        $query->where('division_id', $Division);
    }
                
                    if ($dateFrom && $dateTo) {
                        $query->whereBetween('created_at', [$dateFrom, $dateTo]);
                    }
                    
                    $FilterDDD = $query->get();
                    
    

    $pdf = Pdf::loadView('frontend.forms.Logs.filterData.effectiveness_pdf', compact('FilterDDD'))->setPaper('a4', 'landscape');

    return $pdf->stream('report.pdf');
}

public function printPDFLab (Request $request)
{
    $filterDD = $request->all();
    // dd($filterDD);
    
    $Actionclassificaton = $filterDD['department'] ?? null;
    $Division = $filterDD['division'] ?? null;
    $dateFrom = isset($filterDD['date_from']) ? Carbon::parse($filterDD['date_from'])->startOfDay() : null;
    $dateTo = isset($filterDD['date_to']) ? Carbon::parse($filterDD['date_to'])->endOfDay() : null;
    
    $query = LabIncident::query(); 
    
    if ($Actionclassificaton) {
        $query->where('departments', $Actionclassificaton);
    }

    if ($Division) {
        $query->where('division_id', $Division);
    }
                
                    if ($dateFrom && $dateTo) {
                        $query->whereBetween('created_at', [$dateFrom, $dateTo]);
                    }
                    
                    $FilterDDD = $query->get();
                    $rowsPerPage = 7;
                    $totalRows = $FilterDDD->count();
                    $totalPages = ceil($totalRows / $rowsPerPage);
                    $paginatedData = $FilterDDD->chunk($rowsPerPage);
                        
    

    $pdf = Pdf::loadView('frontend.forms.Logs.lablogprintFile', compact('totalPages','FilterDDD','paginatedData'))->setPaper('a4', 'landscape');

    return $pdf->stream('report.pdf');
}

public function printPDFcomplaintM (Request $request)
{
    $filterCC = $request->all();

    // dd($filterCC);
    $department = $filterCC['department'] ?? null; 
    $changerelateTo = $filterCC['changerelateTo'] ?? null; 
    $classification = $filterCC['dateFrom'] ?? null; 
    $Initiator = $filterCC['Initiator'] ?? null;
    
    $To = $filterCC['dateTo'] ?? null; 

    $query = MarketComplaint::query();

    $query->when($department, function ($q) use ($department) {
        return $q->where('Initiator_Group', $department);
    });

  
    $query->when($Initiator, function ($q) use ($Initiator) {
        return $q->where('initiator_id', $Initiator);
    });

    $query->when($classification, function ($q) use ($classification) {
        return $q->where('intiation_date', $classification);
    });

    $query->when($To, function ($q) use ($To) {
        return $q->where('intiation_date', $To);
    });

 
  
    $filteredDataCC = $query->get();

    $rowsPerPage = 7;
    $totalRows = $filteredDataCC->count();
    $totalPages = ceil($totalRows / $rowsPerPage);
    $paginatedData = $filteredDataCC->chunk($rowsPerPage);


    $pdf = Pdf::loadView('frontend.forms.Logs.complaint_management_Log_pdf', compact('totalPages','filteredDataCC','paginatedData'))->setPaper('a4', 'landscape');

    return $pdf->stream('report.pdf');
}

public function printPDFIncident (Request $request)
{
    $filterDD = $request->all();
    // dd(  $filterDD);
    
    $Actionclassificaton = $filterDD['department'] ?? null;
    $Division = $filterDD['division'] ?? null;
    $dateFrom = isset($filterDD['date_from']) ? Carbon::parse($filterDD['date_from'])->startOfDay() : null;
    $dateTo = isset($filterDD['date_to']) ? Carbon::parse($filterDD['date_to'])->endOfDay() : null;
    
    $query = Incident::query(); 
    
    if ($Actionclassificaton) {
        $query->where('departments', $Actionclassificaton);
    }

    if ($Division) {
        $query->where('division_id', $Division);
    }
                
                    if ($dateFrom && $dateTo) {
                        $query->whereBetween('created_at', [$dateFrom, $dateTo]);
                    }
                    
                    $FilterDDD = $query->get();
                    
    // if ($FilterDDD->isEmpty()) {
    //     return "No data found";
    // }

    $pdf = Pdf::loadView('frontend.forms.Logs.incident_pdf_log', compact('FilterDDD'))->setPaper('a4', 'landscape');

    return $pdf->stream('report.pdf');
}


public function printPDFInternalAudit (Request $request)
{
    $filterDD = $request->all();
    // dd(  $filterDD);
    
    $Actionclassificaton = $filterDD['department'] ?? null;
    $Division = $filterDD['division'] ?? null;
    $dateFrom = isset($filterDD['date_from']) ? Carbon::parse($filterDD['date_from'])->startOfDay() : null;
    $dateTo = isset($filterDD['date_to']) ? Carbon::parse($filterDD['date_to'])->endOfDay() : null;
    
    $query = InternalAudit::query(); 
    
    if ($Actionclassificaton) {
        $query->where('departments', $Actionclassificaton);
    }

    if ($Division) {
        $query->where('division_id', $Division);
    }
                
                    if ($dateFrom && $dateTo) {
                        $query->whereBetween('created_at', [$dateFrom, $dateTo]);
                    }
                    
                    $FilterDDD = $query->get();
                    
    // if ($FilterDDD->isEmpty()) {
    //     return "No data found";
    // }

    $pdf = Pdf::loadView('frontend.forms.Logs.internal_audit_log_pdf', compact('FilterDDD'))->setPaper('a4', 'landscape');

    return $pdf->stream('report.pdf');
}

public function printPDFDeviation (Request $request)
{
    $filterDD = $request->all();
    // dd(  $filterDD);
    
    $Actionclassificaton = $filterDD['department'] ?? null;
    $Division = $filterDD['division'] ?? null;
    $dateFrom = isset($filterDD['date_from']) ? Carbon::parse($filterDD['date_from'])->startOfDay() : null;
    $dateTo = isset($filterDD['date_to']) ? Carbon::parse($filterDD['date_to'])->endOfDay() : null;
    
    $query = Deviation::query(); 
    
    if ($Actionclassificaton) {
        $query->where('departments', $Actionclassificaton);
    }

    if ($Division) {
        $query->where('division_id', $Division);
    }
                
    if ($dateFrom && $dateTo) {
        $query->whereBetween('created_at', [$dateFrom, $dateTo]);
    }
    
    $FilterDDD = $query->get();

    
    $rowsPerPage = 7;
    $totalRows = $FilterDDD->count();
    $totalPages = ceil($totalRows / $rowsPerPage);
    $paginatedData = $FilterDDD->chunk($rowsPerPage);

    $pdf = Pdf::loadView('frontend.forms.Logs.deviation_log_pdf', compact('paginatedData','totalRows','totalPages','FilterDDD'))->setPaper('a4', 'landscape');

    return $pdf->stream('report.pdf');
}

public function printPDFFailureInvestigation (Request $request)
{
    $filterDD = $request->all();
    // dd(  $filterDD);
    
    $Actionclassificaton = $filterDD['department'] ?? null;
    $Division = $filterDD['division'] ?? null;
    $dateFrom = isset($filterDD['date_from']) ? Carbon::parse($filterDD['date_from'])->startOfDay() : null;
    $dateTo = isset($filterDD['date_to']) ? Carbon::parse($filterDD['date_to'])->endOfDay() : null;
    
    $query = FailureInvestigation::query(); 
    
    if ($Actionclassificaton) {
        $query->where('departments', $Actionclassificaton);
    }

    if ($Division) {
        $query->where('division_id', $Division);
    }
                
                    if ($dateFrom && $dateTo) {
                        $query->whereBetween('created_at', [$dateFrom, $dateTo]);
                    }
                    
                    $FilterDDD = $query->get();
                    
    // if ($FilterDDD->isEmpty()) {
    //     return "No data found";
    // }

    $pdf = Pdf::loadView('frontend.forms.Logs.failureinvestigation_pdf', compact('FilterDDD'))->setPaper('a4', 'landscape');

    return $pdf->stream('report.pdf');
}

public function printPDFriskmt (Request $request)
{
    $filterDD = $request->all();
    // dd(  $filterDD);
    
    $Actionclassificaton = $filterDD['department'] ?? null;
    $Division = $filterDD['division'] ?? null;
    $dateFrom = isset($filterDD['date_from']) ? Carbon::parse($filterDD['date_from'])->startOfDay() : null;
    $dateTo = isset($filterDD['date_to']) ? Carbon::parse($filterDD['date_to'])->endOfDay() : null;
    
    $query = RiskManagement::query(); 
    
    if ($Actionclassificaton) {
        $query->where('departments', $Actionclassificaton);
    }

    if ($Division) {
        $query->where('division_id', $Division);
    }
                
                    if ($dateFrom && $dateTo) {
                        $query->whereBetween('created_at', [$dateFrom, $dateTo]);
                    }
                    
                    $FilterDDD = $query->get();

                    $rowsPerPage = 7;
                    $totalRows = $FilterDDD->count();
                    $totalPages = ceil($totalRows / $rowsPerPage);
                    $paginatedData = $FilterDDD->chunk($rowsPerPage);
        

    $pdf = Pdf::loadView('frontend.forms.Logs.riskmanagement_log_pdf', compact('FilterDDD','paginatedData','totalRows','totalPages'))->setPaper('a4', 'landscape');

    return $pdf->stream('report.pdf');
}

public function printPDFnnconfermance (Request $request)
{
    $filterDD = $request->all();
    // dd(  $filterDD);
    
    $Actionclassificaton = $filterDD['department'] ?? null;
    $Division = $filterDD['division'] ?? null;
    $dateFrom = isset($filterDD['date_from']) ? Carbon::parse($filterDD['date_from'])->startOfDay() : null;
    $dateTo = isset($filterDD['date_to']) ? Carbon::parse($filterDD['date_to'])->endOfDay() : null;
    
    $query = NonConformance::query(); 
    
    if ($Actionclassificaton) {
        $query->where('departments', $Actionclassificaton);
    }

    if ($Division) {
        $query->where('division_id', $Division);
    }
                
                    if ($dateFrom && $dateTo) {
                        $query->whereBetween('created_at', [$dateFrom, $dateTo]);
                    }
                    
                    $FilterDDD = $query->get();
                    
    // if ($FilterDDD->isEmpty()) {
    //     return "No data found";
    // }

    $pdf = Pdf::loadView('frontend.forms.Logs.nonconfermance_log_pdf', compact('FilterDDD'))->setPaper('a4', 'landscape');

    return $pdf->stream('report.pdf');
}

public function printPDFoot (Request $request)
{
    $filterDD = $request->all();
    
    $Actionclassificaton = $filterDD['department'] ?? null;
    $Division = $filterDD['division'] ?? null;
    $dateFrom = isset($filterDD['date_from']) ? Carbon::parse($filterDD['date_from'])->startOfDay() : null;
    $dateTo = isset($filterDD['date_to']) ? Carbon::parse($filterDD['date_to'])->endOfDay() : null;
    
    $query = Ootc::query(); 
    
    if ($Actionclassificaton) {
        $query->where('departments', $Actionclassificaton);
    }

    if ($Division) {
        $query->where('division_id', $Division);
    }
                
                    if ($dateFrom && $dateTo) {
                        $query->whereBetween('created_at', [$dateFrom, $dateTo]);
                    }
                    
                    $FilterDDD = $query->get();
                    
                    $rowsPerPage = 7;
                    $totalRows = $FilterDDD->count();
                    $totalPages = ceil($totalRows / $rowsPerPage);
                    $paginatedData = $FilterDDD->chunk($rowsPerPage);

    $pdf = Pdf::loadView('frontend.forms.Logs.oot_log_pdf', compact('FilterDDD','rowsPerPage','paginatedData','totalPages'))->setPaper('a4', 'landscape');

    return $pdf->stream('report.pdf');
}

public function printPDFerrata (Request $request)
{
    $filterDD = $request->all();
    // dd(  $filterDD);
    
    $Actionclassificaton = $filterDD['department'] ?? null;
    $Division = $filterDD['division'] ?? null;
    $dateFrom = isset($filterDD['date_from']) ? Carbon::parse($filterDD['date_from'])->startOfDay() : null;
    $dateTo = isset($filterDD['date_to']) ? Carbon::parse($filterDD['date_to'])->endOfDay() : null;
    
    $query = errata::query(); 
    
    if ($Actionclassificaton) {
        $query->where('departments', $Actionclassificaton);
    }

    if ($Division) {
        $query->where('division_id', $Division);
    }
                
                    if ($dateFrom && $dateTo) {
                        $query->whereBetween('created_at', [$dateFrom, $dateTo]);
                    }
                    
                    $FilterDDD = $query->get();
                    
    // if ($FilterDDD->isEmpty()) {
    //     return "No data found";
    // }

    $pdf = Pdf::loadView('frontend.forms.Logs.errata_log_pdf', compact('FilterDDD'))->setPaper('a4', 'landscape');

    return $pdf->stream('report.pdf');
}

public function printPDFooc (Request $request)
{
    $filterDD = $request->all();
    // dd(  $filterDD);
    
    $Actionclassificaton = $filterDD['department'] ?? null;
    $Division = $filterDD['division'] ?? null;
    $dateFrom = isset($filterDD['date_from']) ? Carbon::parse($filterDD['date_from'])->startOfDay() : null;
    $dateTo = isset($filterDD['date_to']) ? Carbon::parse($filterDD['date_to'])->endOfDay() : null;
    
    $query = errata::query(); 
    
    if ($Actionclassificaton) {
        $query->where('department', $Actionclassificaton);
    }

    if ($Division) {
        $query->where('division_id', $Division);
    }
                
                    if ($dateFrom && $dateTo) {
                        $query->whereBetween('created_at', [$dateFrom, $dateTo]);
                    }
                    
                    $FilterDDD = $query->get();
                    
    // if ($FilterDDD->isEmpty()) {
    //     return "No data found";
    // }

    $pdf = Pdf::loadView('frontend.forms.Logs.ooc_log_pdf', compact('FilterDDD'))->setPaper('a4', 'landscape');

    return $pdf->stream('report.pdf');
}

public function printpreventiveMPDF(Request $request)
{
    $filterCC = $request->all();

    // dd($filterCC);
    $department = $filterCC['department'] ?? null; 
    $changerelateTo = $filterCC['changerelateTo'] ?? null; 
    $classification = $filterCC['dateFrom'] ?? null; 
    $Initiator = $filterCC['Initiator'] ?? null;
    
    $To = $filterCC['dateTo'] ?? null; 
    $changeCategory = $filterCC['RadioActivtiyCCC'] ?? null;
    $changeCategorytcc = $filterCC['RadioActivtiyTCC'] ?? null;

    $query = PreventiveMaintenance::query();

    $query->when($department, function ($q) use ($department) {
        return $q->where('pm_schedule', $department);
    });

  
    $query->when($Initiator, function ($q) use ($Initiator) {
        return $q->where('initiator_id', $Initiator);
    });

    $query->when($classification, function ($q) use ($classification) {
        return $q->where('intiation_date', $classification);
    });

    $query->when($To, function ($q) use ($To) {
        return $q->where('intiation_date', $To);
    });

    if ($changeCategory) {
        $categories = explode(',', $changeCategory); 
        $query->whereIn('doc_change', $categories);
    }

    if ($changeCategorytcc) {
        $categoriestcc = explode(',', $changeCategory); 
        $query->whereIn('doc_change', $categoriestcc);
    }

    $filteredDataCC = $query->get();

    
    $rowsPerPage = 7;
    $totalRows = $filteredDataCC->count();
    $totalPages = ceil($totalRows / $rowsPerPage);
    $paginatedData = $filteredDataCC->chunk($rowsPerPage);


    

    $pdf = Pdf::loadView('frontend.forms.Logs.preventivepdf', compact('filteredDataCC','changeCategory','changeCategorytcc','rowsPerPage','totalPages','paginatedData'))->setPaper('a4', 'landscape');

    return $pdf->stream('report.pdf');
}


public function equipmentlifecycle_filter(Request $request)
    {
        $ddd = $request->all();
        // dd($ddd);
        $res = [
            'status' => 'ok',
            'message' => 'success',
            'body' => []
        ];
    
        try {
            $query = EquipmentLifecycleManagement::query();
    
        

            if (!empty($request->department_equipment)) {
                $query->whereIn('criticality_level', $request->department_equipment);  // Use whereIn for multiple selections
            }
    
            
            if ($request->division_id_equipment) {
                $query->where('division_id', $request->division_id_equipment);
            }

            if ($request->initiator_id_equipment) {
                $query->where('initiator_id', $request->initiator_id_equipment);
            }
    
            if ($request->date_fromequipment) {
                $dateFrom = Carbon::parse($request->date_fromequipment)->startOfDay();
                $query->whereDate('intiation_date', '>=', $dateFrom);
            }

            if ($request->date_toequipment) {
                $dateTo = Carbon::parse($request->date_toequipment)->endOfDay();
                $query->whereDate('intiation_date', '<=', $dateTo);
            }
            if ($request->sort_column && $request->sort_order) {
                $query->orderBy($request->sort_column, $request->sort_order);
            }
    
            $EquipmentLc = $query->get();
    
            $htmlData = view('frontend.forms.Logs.filterData.equipmentlifecycle_data', compact('EquipmentLc'))->render();
    
            $res['body'] = $htmlData;
    
        } catch (\Exception $e) {
            $res['status'] = 'error';
            $res['message'] = $e->getMessage();
        }
    
        return response()->json($res);
    }

    public function printequipmentPdf(Request $request)
    {
        $filterCC = $request->all();
    
        // Filter logic
        $query = EquipmentLifecycleManagement::query();
    
        $department = $filterCC['department'] ?? null; 
        $changerelateTo = $filterCC['changerelateTo'] ?? null; 
        $classification = $filterCC['dateFrom'] ?? null; 
        $Initiator = $filterCC['Initiator'] ?? null;
        $To = $filterCC['dateTo'] ?? null; 
        $changeCategory = $filterCC['RadioActivtiyCCC'] ?? null;
        $changeCategorytcc = $filterCC['RadioActivtiyTCC'] ?? null;
    
        $query->when($department, function ($q) use ($department) {
            return $q->where('criticality_level', $department);
        });
    
      
        $query->when($Initiator, function ($q) use ($Initiator) {
            return $q->where('initiator_id', $Initiator);
        });
    
        $query->when($classification, function ($q) use ($classification) {
            return $q->where('intiation_date', $classification);
        });
    
        $query->when($To, function ($q) use ($To) {
            return $q->where('intiation_date', $To);
        });
    
        if ($changeCategory) {
            $categories = explode(',', $changeCategory); 
            $query->whereIn('doc_change', $categories);
        }
    
        if ($changeCategorytcc) {
            $categoriestcc = explode(',', $changeCategorytcc); 
            $query->whereIn('doc_change', $categoriestcc);
        }
    
        $filteredDataCC = $query->get();
    
        $rowsPerPage = 7;
        $totalRows = $filteredDataCC->count();
        $totalPages = ceil($totalRows / $rowsPerPage);
        $paginatedData = $filteredDataCC->chunk($rowsPerPage);
    
        $pdf = Pdf::loadView('frontend.forms.Logs.equipmentlifecyclePDF', [
            'paginatedData' => $paginatedData,
            'totalPages' => $totalPages,
            'rowsPerPage' => $rowsPerPage
        ])->setPaper('a4', 'landscape');
    
        return $pdf->stream('report.pdf');
    }
    

    // ==============================calibrationmanagement_filter

    public function calibrationmanagement_filter(Request $request)
    {
        $res = [
            'status' => 'ok',
            'message' => 'success',
            'body' => []
        ];
    
        try {
            $query = CallibrationDetails::query();
    
            if (!empty($request->department_calibrationmanagement)) {
            $query->whereIn('callibration_frequency', $request->department_calibrationmanagement);  // Use whereIn for multiple selections
        }

    
            if ($request->division_id_calibrationmanagement) {
                $query->where('division_id', $request->division_id_calibrationmanagement);
            }
    
            if ($request->initiator_id_calibrationmanagement) {
                $query->where('initiator_id', $request->initiator_id_calibrationmanagement);
            }
    
            if ($request->date_fromcm) {
                $dateFrom = Carbon::parse($request->date_fromcm)->startOfDay();
                $query->whereDate('intiation_date', '>=', $dateFrom);
            }
    
            if ($request->date_tocm) {
                $dateTo = Carbon::parse($request->date_tocm)->endOfDay();
                $query->whereDate('intiation_date', '<=', $dateTo);
            }
    
         
            if ($request->sort_column && $request->sort_order) {
                $query->orderBy($request->sort_column, $request->sort_order);
            }
    
            $cm = $query->get();
    
            $htmlData = view('frontend.forms.Logs.filterData.calibrationmanament_data', compact('cm'))->render();
    
            $res['body'] = $htmlData;
    
        } catch (\Exception $e) {
            $res['status'] = 'error';
            $res['message'] = $e->getMessage();
        }
    
        return response()->json($res);
    }


    // PDF calibration-managementLog

    public function printPDFCM(Request $request)
{
    $filterCC = $request->all();

    $changerelateTo = $filterCC['changerelateTo'] ?? null; 
    $classification = $filterCC['dateFrom'] ?? null; 
    $Initiator = $filterCC['Initiator'] ?? null;
    
    $To = $filterCC['dateTo'] ?? null; 
   
    $query = CallibrationDetails::query();

    $query->when($changerelateTo, function ($q) use ($changerelateTo) {
        return $q->where('division_id', $changerelateTo);
    });

  
    $query->when($Initiator, function ($q) use ($Initiator) {
        return $q->where('initiator_id', $Initiator);
    });

    $query->when($classification, function ($q) use ($classification) {
        return $q->where('intiation_date', $classification);
    });

    $query->when($To, function ($q) use ($To) {
        return $q->where('intiation_date', $To);
    });

  
    $filteredDataCC = $query->get();

    $rowsPerPage = 7;
    $totalRows = $filteredDataCC->count();
    $totalPages = ceil($totalRows / $rowsPerPage);
    $paginatedData = $filteredDataCC->chunk($rowsPerPage);

    
 

    $pdf = Pdf::loadView('frontend.forms.Logs.filterData.cmlogpdf', compact('rowsPerPage','paginatedData','totalPages','filteredDataCC'))->setPaper('a4', 'landscape');

    return $pdf->stream('report.pdf');
}

// ==============================External Audit


public function externalaudit_filter(Request $request)
    {
        $res = [
            'status' => 'ok',
            'message' => 'success',
            'body' => []
        ];
    
        try {
            $query = Auditee::query();
    
            if (!empty($request->department_ea)) {
                $query->whereIn('Initiator_Group', $request->department_ea); 
            }
    
            if ($request->division_id_ea) {
                $query->where('division_id', $request->division_id_ea);
            }
    
            if ($request->initiator_id_ea) {
                $query->where('initiator_id', $request->initiator_id_ea);
            }
    
            if ($request->date_fromea) {
                $dateFrom = Carbon::parse($request->date_fromea)->startOfDay();
                $query->whereDate('created_at', '>=', $dateFrom);
            }
    
            if ($request->date_toea) {
                $dateTo = Carbon::parse($request->date_toea)->endOfDay();
                $query->whereDate('created_at', '<=', $dateTo);
            }
    
            if ($request->sort_column && $request->sort_order) {
                $query->orderBy($request->sort_column, $request->sort_order);
            }
    
            $ea = $query->get();
    
            $htmlData = view('frontend.forms.Logs.filterData.externalaudit_data', compact('ea   '))->render();
    
            $res['body'] = $htmlData;
    
        } catch (\Exception $e) {
            $res['status'] = 'error';
            $res['message'] = $e->getMessage();
        }
    
        return response()->json($res);
    }

    // PDF EXTERNAL External Audit 


    public function printPDFEA(Request $request)
{
    $filterCC = $request->all();

    // dd($filterCC);
    $department = $filterCC['department'] ?? null; 
    $changerelateTo = $filterCC['changerelateTo'] ?? null; 
    $classification = $filterCC['dateFrom'] ?? null; 
    $Initiator = $filterCC['Initiator'] ?? null;
    
    $To = $filterCC['dateTo'] ?? null; 
  
    $query = Auditee::query();

    $query->when($department, function ($q) use ($department) {
        return $q->where('initiator_Group', $department);
    });

   
    $query->when($Initiator, function ($q) use ($Initiator) {
        return $q->where('initiator_id', $Initiator);
    });

    $query->when($classification, function ($q) use ($classification) {
        return $q->where('intiation_date', $classification);
    });

    $query->when($To, function ($q) use ($To) {
        return $q->where('intiation_date', $To);
    });

   
    $filteredDataCC = $query->get();

    $rowsPerPage = 7;
    $totalRows = $filteredDataCC->count();
    $totalPages = ceil($totalRows / $rowsPerPage);
    $paginatedData = $filteredDataCC->chunk($rowsPerPage);

    

    $pdf = Pdf::loadView('frontend.forms.Logs.filterData.externalauditlogpdf', compact('rowsPerPage','paginatedData','totalPages','filteredDataCC'))->setPaper('a4', 'landscape');

    return $pdf->stream('report.pdf');
}







// Global capa filter 

public function globalcapa_filter(Request $request)
    {
        $res = [
            'status' => 'ok',
            'message' => 'success',
            'body' => []
        ];
    
        try {
            $query = GlobalCapa::query();
    
            if (!empty($request->department_globalcapa)) {
                $query->whereIn('initiator_Group', $request->department_globalcapa); 
            }
    
            if ($request->division_id_globalcapa) {
                $query->where('division_id', $request->division_id_globalcapa);
            }
    
            if ($request->initiator_id_globalcapa) {
                $query->where('initiator_id', $request->initiator_id_globalcapa);
            }
    
            if ($request->date_fromglobalcapa) {
                $dateFrom = Carbon::parse($request->date_fromglobalcapa)->startOfDay();
                $query->whereDate('created_at', '>=', $dateFrom);
            }
    
            if ($request->date_toglobalcapa) {
                $dateTo = Carbon::parse($request->date_toglobalcapa)->endOfDay();
                $query->whereDate('created_at', '<=', $dateTo);
            }
    
            if ($request->sort_column && $request->sort_order) {
                $query->orderBy($request->sort_column, $request->sort_order);
            }
    
            $gcapas = $query->get();
    
            $htmlData = view('frontend.forms.Logs.filterData.globalcapa_data', compact('gcapas'))->render();
    
            $res['body'] = $htmlData;
    
        } catch (\Exception $e) {
            $res['status'] = 'error';
            $res['message'] = $e->getMessage();
        }
    
        return response()->json($res);
    }


    
// Global CAPA =======


public function printPDFGCAPA(Request $request)
{
    $filterglobalcapa = $request->all();

    $department = $filterglobalcapa['department'] ?? null;
    $changerelateTo = $filterglobalcapa['changerelateTo'] ?? null; 
    $Initiator = $filterglobalcapa['Initiator'] ?? null;
    $dateFrom = $filterglobalcapa['dateFrom'] ?? null; 
    $dateTo = $filterglobalcapa['dateTo'] ?? null; 

    $query = GlobalCapa::query();

    $query->when($department, function ($q) use ($department) {
        return $q->where('initiator_Group', $department);
    });

    $query->when($Initiator, function ($q) use ($Initiator) {
        return $q->where('initiator_id', $Initiator);
    });

    $query->when($dateFrom, function ($q) use ($dateFrom) {
        return $q->whereDate('created_at', '>=', $dateFrom);
    });

    $query->when($dateTo, function ($q) use ($dateTo) {
        return $q->whereDate('created_at', '<=', $dateTo);
    });

    $filterglobalcapa = $query->get();
    

    $rowsPerPage = 7;
    $totalRows = $filterglobalcapa->count();
    $totalPages = ceil($totalRows / $rowsPerPage);
    $paginatedData = $filterglobalcapa->chunk($rowsPerPage);

    $pdf = Pdf::loadView('frontend.forms.Logs.filterData.globalcapalogpdf', compact('rowsPerPage', 'paginatedData', 'totalPages', 'filterglobalcapa'))->setPaper('a4', 'landscape');

    return $pdf->stream('report.pdf');
}

//  new document filter   

public function newdocument_filter(Request $request)
    {
        $res = [
            'status' => 'ok',
            'message' => 'success',
            'body' => []
        ];
    
        try {
            $query = Document::query();
    
            if (!empty($request->department_newdocument)) {
                $query->whereIn('department_id', $request->department_newdocument); 
            }
    
            if ($request->division_id_newdocument) {
                $query->where('division_id', $request->division_id_newdocument);
            }
    
            if ($request->initiator_id_newdocument) {
                $query->where('originator_id', $request->initiator_id_newdocument);
            }
    
            if ($request->date_fromnewdocument) {
                $dateFrom = Carbon::parse($request->date_fromnewdocument)->startOfDay();
                $query->whereDate('created_at', '>=', $dateFrom);
            }
    
            if ($request->date_tonewdocument) {
                $dateTo = Carbon::parse($request->date_tonewdocument)->endOfDay();
                $query->whereDate('created_at', '<=', $dateTo);
            }
    
            if ($request->sort_column && $request->sort_order) {
                $query->orderBy($request->sort_column, $request->sort_order);
            }
    
            $newdocument = $query->get();
    
            $htmlData = view('frontend.forms.Logs.filterData.newdocument_data', compact('newdocument'))->render();
    
            $res['body'] = $htmlData;
    
        } catch (\Exception $e) {
            $res['status'] = 'error';
            $res['message'] = $e->getMessage();
        }
    
        return response()->json($res);
    }


    // new document filter pdf 


    public function printPDFnewdocument (Request $request)
{
    $filterCC = $request->all();

    // dd($filterCC);
    $department = $filterCC['department'] ?? null; 
    $changerelateTo = $filterCC['changerelateTo'] ?? null; 
    $classification = $filterCC['dateFrom'] ?? null; 
    $Initiator = $filterCC['Initiator'] ?? null;
    
    $To = $filterCC['dateTo'] ?? null; 
    $changeCategory = $filterCC['RadioActivtiyCCC'] ?? null;
    $changeCategorytcc = $filterCC['RadioActivtiyTCC'] ?? null;

    $query = CC::query();

    $query->when($department, function ($q) use ($department) {
        return $q->where('department_id', $department);
    });

    $query->when($Initiator, function ($q) use ($Initiator) {
        return $q->where('originator_id', $Initiator);
    });

    $query->when($classification, function ($q) use ($classification) {
        return $q->where('intiation_date', $classification);
    });

    $query->when($To, function ($q) use ($To) {
        return $q->where('intiation_date', $To);
    });

    
    $filteredDataCC = $query->get();

    $rowsPerPage = 7;
    $totalRows = $filteredDataCC->count();
    $totalPages = ceil($totalRows / $rowsPerPage);
    $paginatedData = $filteredDataCC->chunk($rowsPerPage);

    

    $pdf = Pdf::loadView('frontend.forms.Logs.filterData.newdocumentpdf', compact('rowsPerPage','paginatedData','totalPages','filteredDataCC'))->setPaper('a4', 'landscape');

    return $pdf->stream('report.pdf');
}

public function sanction_filter(Request $request)
{
    $res = [
        'status' => 'ok',
        'message' => 'success',
        'body' => []
    ];

    try {
        $query = Sanction::query();

        if (!empty($request->department_sanction)) {
            $query->whereIn('Type', $request->department_sanction);  
        }

        if ($request->division_id_sanction) {
            $query->where('division_id', $request->division_id_sanction);
        }

        if ($request->initiator_id_sanction) {
            $query->where('initiator_id', $request->initiator_id_sanction);
        }

        if ($request->date_from_sanction) {
            $dateFrom = Carbon::parse($request->date_from_sanction)->startOfDay();
            $query->whereDate('intiation_date', '>=', $dateFrom);
        }

        if ($request->date_to_sanction) {
            $dateTo = Carbon::parse($request->date_to_sanction)->endOfDay();
            $query->whereDate('intiation_date', '<=', $dateTo);
        }


        if ($request->sort_column && $request->sort_order) {
            $query->orderBy($request->sort_column, $request->sort_order);
        }

        $sanction = $query->get();
        

        $htmlData = view('frontend.forms.Logs.filterData.sanction_data', compact('sanction'))->render();

        $res['body'] = $htmlData;

    } catch (\Exception $e) {
        $res['status'] = 'error';
        $res['message'] = $e->getMessage();
    }

    return response()->json($res);
}


public function printPDFsanction(Request $request)
{
    $filterCC = $request->all();

    // dd($filterCC);
    $department = $filterCC['department'] ?? null; 
    $changerelateTo = $filterCC['changerelateTo'] ?? null; 
    $classification = $filterCC['dateFrom'] ?? null; 
    $Initiator = $filterCC['Initiator'] ?? null;
    
    $To = $filterCC['dateTo'] ?? null; 
    $changeCategory = $filterCC['RadioActivtiyCCC'] ?? null;
    $changeCategorytcc = $filterCC['RadioActivtiyTCC'] ?? null;

    $query = Sanction::query();

    $query->when($department, function ($q) use ($department) {
        return $q->where('Type', $department);
    });

    $query->when($Initiator, function ($q) use ($Initiator) {
        return $q->where('initiator_id', $Initiator);
    });

    $query->when($classification, function ($q) use ($classification) {
        return $q->where('intiation_date', $classification);
    });

    $query->when($To, function ($q) use ($To) {
        return $q->where('intiation_date', $To);
    });

   
    $filteredDataCC = $query->get();

    $rowsPerPage = 7;
    $totalRows = $filteredDataCC->count();
    $totalPages = ceil($totalRows / $rowsPerPage);
    $paginatedData = $filteredDataCC->chunk($rowsPerPage);

    

    $pdf = Pdf::loadView('frontend.forms.Logs.filterData.sanction_logpdf', compact('rowsPerPage','paginatedData','totalPages','filteredDataCC','changeCategory','changeCategorytcc'))->setPaper('a4', 'landscape');

    return $pdf->stream('report.pdf');
}




public function supplier_filter(Request $request)
{
    $res = [
        'status' => 'ok',
        'message' => 'success',
        'body' => []
    ];

    try {
        $query = Supplier::query();

        if (!empty($request->department_supplier)) {
            $query->whereIn('initiation_group', $request->department_supplier);  
        }

        if ($request->division_id_supplier) {
            $query->where('division_id', $request->division_id_supplier);
        }

        if ($request->initiator_id_supplier) {
            $query->where('initiator_id', $request->initiator_id_supplier);
        }

        if ($request->date_fromsupplier) {
            $dateFrom = Carbon::parse($request->date_fromsupplier)->startOfDay();
            $query->whereDate('intiation_date', '>=', $dateFrom);
        }

        if ($request->date_tosupplier) {
            $dateTo = Carbon::parse($request->date_tosupplier)->endOfDay();
            $query->whereDate('intiation_date', '<=', $dateTo);
        }


        if ($request->sort_column && $request->sort_order) {
            $query->orderBy($request->sort_column, $request->sort_order);
        }

        $supplier = $query->get();
        

        $htmlData = view('frontend.forms.Logs.filterData.supplier_data', compact('supplier'))->render();

        $res['body'] = $htmlData;

    } catch (\Exception $e) {
        $res['status'] = 'error';
        $res['message'] = $e->getMessage();
    }

    return response()->json($res);
}

public function printPDFsupplier (Request $request)
{
    $filterCC = $request->all();

    // dd($filterCC);
    $department = $filterCC['department'] ?? null; 
    $changerelateTo = $filterCC['changerelateTo'] ?? null; 
    $classification = $filterCC['dateFrom'] ?? null; 
    $Initiator = $filterCC['Initiator'] ?? null;
    
    $To = $filterCC['dateTo'] ?? null; 
    $changeCategory = $filterCC['RadioActivtiyCCC'] ?? null;
    $changeCategorytcc = $filterCC['RadioActivtiyTCC'] ?? null;

    $query = Supplier::query();

    $query->when($department, function ($q) use ($department) {
        return $q->where('initiation_group', $department);
    });

    $query->when($Initiator, function ($q) use ($Initiator) {
        return $q->where('initiator_id', $Initiator);
    });

    $query->when($classification, function ($q) use ($classification) {
        return $q->where('intiation_date', $classification);
    });

    $query->when($To, function ($q) use ($To) {
        return $q->where('intiation_date', $To);
    });

   
    $filteredDataCC = $query->get();

    $rowsPerPage = 7;
    $totalRows = $filteredDataCC->count();
    $totalPages = ceil($totalRows / $rowsPerPage);
    $paginatedData = $filteredDataCC->chunk($rowsPerPage);

    

    $pdf = Pdf::loadView('frontend.forms.Logs.filterData.supplier_logpdf', compact('rowsPerPage','paginatedData','totalPages','filteredDataCC','changeCategory','changeCategorytcc'))->setPaper('a4', 'landscape');

    return $pdf->stream('report.pdf');
}

// supplier audit 
public function supplieraudit_filter(Request $request)
{
    $res = [
        'status' => 'ok',
        'message' => 'success',
        'body' => []
    ];

    try {
        $query = supplierAudit::query();

        if (!empty($request->department_supplieraudit)) {
            $query->whereIn('Initiator_Group', $request->department_supplieraudit);  
        }

        if ($request->division_id_supplieraudit) {
            $query->where('division_id', $request->division_id_supplieraudit);
        }

        if ($request->initiator_id_supplieraudit) {
            $query->where('initiator_id', $request->initiator_id_supplieraudit);
        }

        if ($request->date_fromsupplieraudit) {
            $dateFrom = Carbon::parse($request->date_fromsupplieraudit)->startOfDay();
            $query->whereDate('intiation_date', '>=', $dateFrom);
        }

        if ($request->date_tosupplieraudit) {
            $dateTo = Carbon::parse($request->date_tosupplieraudit)->endOfDay();
            $query->whereDate('intiation_date', '<=', $dateTo);
        }


        if ($request->sort_column && $request->sort_order) {
            $query->orderBy($request->sort_column, $request->sort_order);
        }

        $supplieraudit = $query->get();
        

        $htmlData = view('frontend.forms.Logs.filterData.supplieraudit_data', compact('supplieraudit'))->render();

        $res['body'] = $htmlData;

    } catch (\Exception $e) {
        $res['status'] = 'error';
        $res['message'] = $e->getMessage();
    }

    return response()->json($res);
}

public function printPDFsupplieraudit (Request $request)
{
    $filterCC = $request->all();

    // dd($filterCC);
    $department = $filterCC['department'] ?? null; 
    $changerelateTo = $filterCC['changerelateTo'] ?? null; 
    $classification = $filterCC['dateFrom'] ?? null; 
    $Initiator = $filterCC['Initiator'] ?? null;
    
    $To = $filterCC['dateTo'] ?? null; 
    $changeCategory = $filterCC['RadioActivtiyCCC'] ?? null;
    $changeCategorytcc = $filterCC['RadioActivtiyTCC'] ?? null;

    $query = supplierAudit::query();

    $query->when($department, function ($q) use ($department) {
        return $q->where('Initiator_Group', $department);
    });

    $query->when($Initiator, function ($q) use ($Initiator) {
        return $q->where('initiator_id', $Initiator);
    });

    $query->when($classification, function ($q) use ($classification) {
        return $q->where('intiation_date', $classification);
    });

    $query->when($To, function ($q) use ($To) {
        return $q->where('intiation_date', $To);
    });

   
    $filteredDataCC = $query->get();

    $rowsPerPage = 7;
    $totalRows = $filteredDataCC->count();
    $totalPages = ceil($totalRows / $rowsPerPage);
    $paginatedData = $filteredDataCC->chunk($rowsPerPage);

    

    $pdf = Pdf::loadView('frontend.forms.Logs.filterData.supplieraudit_logpdf', compact('rowsPerPage','paginatedData','totalPages','filteredDataCC','changeCategory','changeCategorytcc'))->setPaper('a4', 'landscape');

    return $pdf->stream('report.pdf');
}


public function auditprogram_filter(Request $request)
{
    $res = [
        'status' => 'ok',
        'message' => 'success',
        'body' => []
    ];

    try {
        $query = AuditProgram::query();
            if (!empty($request->department_auditprogram)) {
                $query->whereIn('Initiator_Group', $request->department_auditprogram);  // Use whereIn for multiple selections
            }
    
            if ($request->division_id_auditprogram) {
                $query->where('division_id', $request->division_id_auditprogram);
            }
    
            if ($request->initiator_id_auditprogram) {
                $query->where('initiator_id', $request->initiator_id_auditprogram);
            }
    
            if ($request->date_fromauditprogram) {
                $dateFrom = Carbon::parse($request->date_fromauditprogram)->startOfDay();
                $query->whereDate('intiation_date', '>=', $dateFrom);
            }
    
            if ($request->date_toauditprogram) {
                $dateTo = Carbon::parse($request->date_toauditprogram)->endOfDay();
                $query->whereDate('intiation_date', '<=', $dateTo);
            }
    
    
            if ($request->sort_column && $request->sort_order) {
                $query->orderBy($request->sort_column, $request->sort_order);
            }
    
        $auditprogram = $query->get();
        

        $htmlData = view('frontend.forms.Logs.filterData.auditprogram_data', compact('auditprogram'))->render();

        $res['body'] = $htmlData;

    } catch (\Exception $e) {
        $res['status'] = 'error';
        $res['message'] = $e->getMessage();
    }

    return response()->json($res);
}



public function printPDFauditprogrampdf  (Request $request)
{
    $filterCC = $request->all();

    // dd($filterCC);
    $department = $filterCC['department'] ?? null; 
    $changerelateTo = $filterCC['changerelateTo'] ?? null; 
    $classification = $filterCC['dateFrom'] ?? null; 
    $Initiator = $filterCC['Initiator'] ?? null;
    
    $To = $filterCC['dateTo'] ?? null; 
    $query = AuditProgram::query();

    $query->when($department, function ($q) use ($department) {
        return $q->where('Initiator_Group', $department);
    });

    $query->when($Initiator, function ($q) use ($Initiator) {
        return $q->where('initiator_id', $Initiator);
    });

    $query->when($classification, function ($q) use ($classification) {
        return $q->where('intiation_date', $classification);
    });

    $query->when($To, function ($q) use ($To) {
        return $q->where('intiation_date', $To);
    });

   
    $filteredDataCC = $query->get();

    $rowsPerPage = 7;
    $totalRows = $filteredDataCC->count();
    $totalPages = ceil($totalRows / $rowsPerPage);
    $paginatedData = $filteredDataCC->chunk($rowsPerPage);

    

    $pdf = Pdf::loadView('frontend.forms.Logs.filterData.auditprogrampdf', compact('rowsPerPage','paginatedData','totalPages','filteredDataCC'))->setPaper('a4', 'landscape');

    return $pdf->stream('report.pdf');
}

    
}    

