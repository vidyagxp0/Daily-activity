<?php

namespace App\Http\Controllers\rcms;

use App\Http\Controllers\Controller;
use App\Models\Deviation;
use App\Models\PreventiveMaintenance;
use App\Models\EquipmentLifecycleManagement;
use App\Models\Capa;
use App\Models\Analytics;
use App\Models\Supplier;
use App\Models\SampleStability; 
use App\Models\SupplierAudit;
use App\Models\InventoryManagement;
use App\Models\CC;
use App\Models\GlobalCapa;
use App\Models\ControlSample;
use App\Models\SamplePlanning;
use App\Models\Sanction;
use App\Models\CallibrationDetails;
use App\Models\EHSEvent;
use App\Models\Auditee;
use App\Models\CapaGrid;
use App\Models\AuditProgram;
use App\Models\NonConformance;
use App\Models\Incident;
use App\Models\Document;
use App\Models\ActionItem;
use App\Models\EffectivenessCheck;
use App\Models\extension_new;
use App\Models\RootCauseAnalysis;
use App\Models\errata;
use App\Models\FailureInvestigation;
use App\Models\lab_incidents_grid;
use App\Models\MarketComplaintGrids;
use App\Models\LabIncident;
use App\Models\Ootc;
use App\Models\OOS;
use App\Models\MarketComplaint;
use App\Models\OutOfCalibration;
use App\Models\RiskManagement;
use App\Models\InternalAudit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;



class LogController extends Controller
{
    public function index($slug)
    {
        switch ($slug) {
            case 'pending-approver':
                $approverPending = Document::where('stage','6')->get();               
                return view('frontend.forms.Logs.pending_approver_logs',compact('approverPending'));
                break;

            case 'document':
                $document = Document::get();               
                return view('frontend.forms.Logs.document_logs',compact('document'));
                break;
            case 'capa':
                $capa = Capa::get();
                
                $filtercapa = CapaGrid::where([ 'type'=>'Action_Item_details'])->get();
              
               
                return view('frontend.forms.Logs.capa_log',compact('capa','filtercapa'));
                break;
            case 'deviation':
                $deviation = Deviation::get();
                return view('frontend.forms.Logs.deviation_log', compact('deviation'));
                break;

            case 'change-control':
                $cc_cft = CC::get();
                    
                   
                    return view('frontend.forms.Logs.ChangeControlLog',compact('cc_cft'));
                    break;

                
            case 'errata':
                        $erratalog = errata::get();
                            
                           
                            return view('frontend.forms.Logs.errata_log',compact('erratalog'));
                            break;

            case 'preventive-maintenance':
                $preventiveM = PreventiveMaintenance::get();
                    
                    
                    return view('frontend.forms.Logs.preventiveMLog',compact('preventiveM'));
                    break;

                    case 'equipmentinstrument-lifecycle-management':
                       
                        $EquipmentLc = EquipmentLifecycleManagement::get();
                            
                            
                            return view('frontend.forms.Logs.equipmentlifecycle_log',compact('EquipmentLc'));
                            break;

            case 'internal-audit':
                        $internal_audi = InternalAudit::get();
                                
                            return view('frontend.forms.Logs.Internal_audit_Log',compact('internal_audi'));
                            break;
            case 'risk-assessment':
            
                // $riskmlog = RiskManagement::with(['Action' => function ($query) {
                // $query->where('type', 'Action_Plan')->take(5);  }])->get();
                $riskmlog = RiskManagement::get();
                                    
                return view('frontend.forms.Logs.riskmanagementLog',compact('riskmlog'));
                break;

            case 'non-conformance':
                        $nonconformance = NonConformance::get();
                        
                        return view('frontend.forms.Logs.non_conformance_log',compact('nonconformance'));
                                       
                    
        
            case 'failure-investigation':
                       
            $failure = FailureInvestigation::get();
                                    
                                   
              return view('frontend.forms.Logs.Failure_investigation_Log',compact('failure'));
              break;        
            

                case 'lab-incident':
                
                    $labincident =LabIncident::with('incidentInvestigationReports')->get();
                
        
                
                                            
                                        
                    return view('frontend.forms.Logs.laboratoryIncidentLog',compact('labincident'));
                    break;        
                

             case 'rca':
                
                $rootcause = RootCauseAnalysis::get();
                
                    return view('frontend.forms.Logs.rootcauselog',compact('rootcause'));
                        
                    break;        
                        
            case 'acton-item':
            
                $actionitem = ActionItem::get();
                $users = User::all();
                
        
                    return view('frontend.forms.Logs.actonitem_filter_log' , compact('actionitem','users'));
              
                    case 'complaint-management':
                
                        $marketcomplaint = MarketComplaint::with('productDetails')->get();

                        
                            return view('frontend.forms.Logs.Market-complaint-registerLog',compact('marketcomplaint'));
                                
                            break;        

            case 'oos':
                
            
            $oots =  Ootc::get();
            $oos = OOS::get();

            return view('frontend.forms.Logs.OOS_OOT_log' , compact('oots','oos'));

            case 'ooc':
            
                $oocs = OutOfCalibration::get();
                
                $users = User::all();
                
        
                    return view('frontend.forms.Logs.OOC_log' , compact('oocs','users'));
                   
                    case 'incident':
                        $Inc = Incident::with(['Grid' => function ($query) {
                            $query->where('type','Product')->take(3);
                        }] )->take(3)->get();
                        return view('frontend.forms.Logs.incidentLog',compact('Inc'));

            case 'effectivness-check':

                $effectivness = EffectivenessCheck::get();
                
                               
                return view('frontend.forms.Logs.filterData.effectivness_log',compact('effectivness'));


                
            case 'due-date-extension':
                $extension = extension_new::get();
                
                return view('frontend.forms.Logs.filterData.extension_new_log',compact('extension'));
                
            case 'audit-program':
                $auditprogram = AuditProgram::get();
                
                return view('frontend.forms.Logs.filterData.auditprogram_log',compact('auditprogram'));

            case 'ehs-environment-sustainability':
                $ehs = EHSEvent::get();
                
                return view('frontend.forms.Logs.filterData.ehs_log',compact('ehs'));
            
                
                                      
            case 'calibration-management':
                $cm = CallibrationDetails::get();
                    
                return view('frontend.forms.Logs.filterData.calibrationmanagement_Log',compact('cm'));

                case 'external-audit':
                    $ea = Auditee::get();
                        
                    return view('frontend.forms.Logs.filterData.externalaudit_log',compact('ea'));

                    case 'global-capa':
                    $gcapas = GlobalCapa::get();
                            
                    return view('frontend.forms.Logs.filterData.globalcapalog',compact('gcapas'));

                    case 'new-document':
                        $newdocument = Document::get();
                                
                        return view('frontend.forms.Logs.filterData.newdocumentLog',compact('newdocument'));

                        case 'sanction':
                            $sanction = Sanction::get();
                                    
                            return view('frontend.forms.Logs.filterData.sanction_log',compact('sanction'));
                   

                        case 'supplier':
                            $supplier = Supplier::get();
                                        
                            return view('frontend.forms.Logs.filterData.supplier_log',compact('supplier'));

                        case 'supplier-audit':
                            $supplieraudit = SupplierAudit::get();
                                            
                            return view('frontend.forms.Logs.filterData.supplierauditlog',compact('supplieraudit'));
                       
                            case 'control-sample':
                                $controlsample = ControlSample::get();
                                                
                                return view('frontend.forms.Logs.filterData.controlsample_log',compact('controlsample'));
                        
                                case 'sample-plaining':
                                    $sampleplanning = SamplePlanning::get();
                                                    
                                    return view('frontend.forms.Logs.filterData.samplingplaning_log',compact('sampleplanning'));
                         case 'sample-stability':
                                    $samplestability = SampleStability::get();
                                                        
                                    return view('frontend.forms.Logs.filterData.samplestability_log',compact('samplestability'));
                        case 'inventory-management':
                                   $inventorymanagement = InventoryManagement::get();
                                                            
                                    return view('frontend.forms.Logs.filterData.inventorymanagement_log',compact('inventorymanagement'));
                                    


                                    case 'analyst-qualification':
                                        $analytics = Analytics::get();
                                                                 
                                         return view('frontend.forms.Logs.filterData.analytics_log',compact('analytics'));
                         
            default:

            return $slug;

                break;
        }
    }
}
