<?php

namespace App\Http\Controllers\rcms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SetDivision;
use Illuminate\Support\Facades\Auth;
class FormDivisionController extends Controller
{
    public function formDivision(Request $request)
    {
        $request->session()->forget('division');
        $request->session()->put('division', $request->division_id);
        if ($request->process_name == "Internal Audit") {
            return redirect('audit');
        } elseif ($request->process_name == "External Audit") {
            return redirect('auditee');
        }
        elseif ($request->process_name == "Observation") {
            return redirect('observation');
        }
        elseif ($request->process_name == "Action Item") {
            return redirect('rcms/action-items-create');
        }
         elseif ($request->process_name == "CAPA") {
            return redirect('capa');
        } elseif ($request->process_name == "Global CAPA") {
            return redirect('globalCapa');
        } elseif ($request->process_name == "Audit Program") {
            return redirect('audit-program');
        } elseif ($request->process_name == "Lab Incident") {
            return redirect('lab-incident');
        } elseif ($request->process_name == "Risk Assessment") {
            return redirect('risk-management');
        } elseif ($request->process_name == "Due Date Extension") {
            return redirect('extension-new');
        } elseif ($request->process_name == "Effectiveness Check") {
            return redirect('effectiveness-check');
        } elseif ($request->process_name == "Root Cause Analysis") {
            return redirect('root-cause-analysis');
        } elseif ($request->process_name == "Failure Investigation") {
            return redirect('rcms/failure-investigation');
        }elseif ($request->process_name == "Non Conformance") {
            return redirect('rcms/non-conformance');
        }
         elseif ($request->process_name == "Change Control") {
            return redirect()->route('CC.create');
        } elseif ($request->process_name == "Global Change Control") {
            return redirect()->route('global-change-control');
        } elseif ($request->process_name == "Management Review") {
            return redirect('meeting');
        }
        elseif ($request->process_name == 'OOS/OOT') {
            return redirect()->route('oos.index');
        }
        elseif ($request->process_name == 'OOS Chemical') {
            return redirect()->route('oos.index');
        }
        elseif ($request->process_name == 'OOT') {
            return redirect()->route('oot.index');
        }
        elseif ($request->process_name == 'OOC') {
            return redirect()->route('ooc.index');
        }
        elseif ($request->process_name == 'OOS Microbiology') {
            return redirect()->route('oos_micro.index');
        }
        elseif ($request->process_name == 'ERRATA') {
            return redirect()->route('errata_new');
        }
        elseif ($request->process_name == 'Complaint Management') {
            return redirect()->route('marketcomplaint.market_complaint_new');
        }
        elseif ($request->process_name == "Supplier Audit") {
            return redirect('supplier_audit_index');
        }
        elseif ($request->process_name == 'Deviation') {
            return redirect()->route('deviation');
        }
        elseif ($request->process_name == 'Query Management') {
            return redirect()->route('query-managements');
        }
        elseif ($request->process_name == 'Preventive Maintenance') {
            return redirect()->route('preventivemaintenance');
        }
        elseif ($request->process_name == 'Calibration Management') {
            return redirect()->route('create-calibration');
        }
        elseif ($request->process_name == 'Control Sample') {
            return redirect()->route('control-sample-new');
        }
        elseif ($request->process_name == "New Document") {

            $new = new SetDivision;
            $new->division_id = $request->division_id;
            $new->process_id = $request->process_id;
            $new->user_id = Auth::user()->id;
            $new->save();

            return redirect('documents/create');
        }
        elseif ($request->process_name == 'Incident') {
            return redirect()->route('incident');
        }
        elseif ($request->process_name == "Regulatory Inspection") {
            return redirect('regulatory_inspection_index');
        }
        elseif ($request->process_name == "Regulatory Change") {
            return redirect('rcms/regulatory-action-task-create');
        }
        elseif ($request->process_name == "Critical Action") {
            return redirect('critical-action');
        }
        elseif ($request->process_name == "Supplier") {
            return redirect('rcms/supplier');
        }
        elseif ($request->process_name == "Equipment/Instrument Lifecycle Management") {
            return redirect('EquipmentInformation');
        }elseif ($request->process_name == "EHS & Environment Sustainability") {
            return redirect('ehsevent');
        }elseif ($request->process_name == "Sanction") {
            return redirect('sanction');
        } elseif ($request->process_name == 'Meeting') {
            return redirect()->route('meetings');
        }elseif ($request->process_name == 'Inventory Management') {
            return redirect()->route('inventorymanagment');
        } elseif ($request->process_name == 'Sample Management I') {
            return redirect()->route('receipt');
        } elseif ($request->process_name == 'Sample Management II') {
            return redirect()->route('sample-planning');
        }elseif ($request->process_name == 'Stability Management') {
            return redirect()->route('stability-management');
        }
        elseif ($request->process_name == 'Task Management') {
            return redirect('task-management');
        }
        elseif ($request->process_name == 'Analyst Qualification') {
            return redirect('rcms/analytics_qualification');
        }
       
    }

    public function formDivisionRegulatory(Request $request)
    {
        $request->session()->forget('division');
        $request->session()->put('division', $request->division_id);
        if ($request->process_name == "Internal Audit") {
            return redirect('audit');
        } 
    }
}
