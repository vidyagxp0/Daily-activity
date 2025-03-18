<?php

use App\Http\Controllers\Api\AllFormsController;
use App\Http\Controllers\Api\ChartController;
use App\Http\Controllers\Api\HelperController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\ProjectPlannerController;
use App\Http\Controllers\UserLoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\Api\LogFilterController;
use App\Http\Controllers\Api\MeetingController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('userLogin', [UserLoginController::class, 'loginapi']);
Route::get('/analyticsData', [DashboardController::class, 'analyticsData']);

Route::get('dashboardStatus', [ApiController::class, 'dashboardStatus']);
Route::get('getProfile', [ApiController::class, 'getProfile']);
Route::get('capaStatus', [ApiController::class, 'capaStatus']);

Route::post('/filter-records', [DocumentController::class, 'filterRecord'])->name('record.filter');

Route::post('upload-files', [HelperController::class, 'upload_file'])->name('api.upload.file');

/**
 * CHARTS ROUTES
 */

 Route::get('/charts/process-charts', [ChartController::class, 'process_charts'])->name('api.process.chart');
 Route::get('/charts/documents-by-status', [ChartController::class, 'document_status_charts'])->name('api.document_by_status.chart');
 Route::get('/charts/overdue-record-distribution', [ChartController::class, 'overdue_records_by_process_chart'])->name('api.overdue_records_by_process_chart.chart');
 Route::get('/charts/deviation-by-classification', [ChartController::class, 'deviation_classification_charts'])->name('api.deviation.chart');
 Route::get('/charts/deviation-by-departments', [ChartController::class, 'deviation_departments_charts'])->name('api.deviation_departments.chart');
 Route::get('/charts/documents-by-originator', [ChartController::class, 'documents_originator_charts'])->name('api.document.originator.chart');
 Route::get('/charts/documents-by-type', [ChartController::class, 'documents_type_charts'])->name('api.document.type.chart');
 Route::get('/charts/documents-in-review/{months}', [ChartController::class, 'documents_review_charts'])->name('api.document.review.chart');
 Route::get('/charts/documents-in-stage/{stage}', [ChartController::class, 'documents_stage_charts'])->name('api.document.stage.chart'); 

 Route::get('/charts/documents-by-severity', [ChartController::class, 'deviationSeverityLevel'])->name('api.document_by_severity.chart');
 Route::get('/charts/documents-by-priority', [ChartController::class, 'documentByPriority'])->name('api.document_by_priority.chart');
 Route::get('/charts/documents-by-priority-deviation', [ChartController::class, 'documentByPriorityDeviation'])->name('api.document_by_priority_deviation.chart');
 Route::get('/charts/documents-by-priority-change-control', [ChartController::class, 'documentByPriorityChangeControl'])->name('api.document_by_priority_change_control.chart');
 Route::get('/charts/documents-by-priority-global-change-control', [ChartController::class, 'documentByPriorityGlobalChangeControl'])->name('api.document_by_priority_global_change_control.chart');
 Route::get('/charts/deviation-stage-distribution', [ChartController::class, 'deviationStageDistribution'])->name('api.deviationStageDistribution.chart');
 Route::get('/charts/global-change-control-stage-distribution', [ChartController::class, 'globalChangeControlStageDistribution'])->name('api.globalChangeControlStageDistribution.chart');

 Route::get('/charts/change-control-stage-distribution', [ChartController::class, 'changeControlStageDistribution'])->name('api.changeControlStageDistribution.chart');
 Route::get('/charts/documents-by-priority-rca', [ChartController::class, 'documentByPriorityRca'])->name('api.document_by_priority_rca.chart');

 Route::get('/charts/documents-by-delayed', [ChartController::class, 'documentDelayed'])->name('api.document_by_delayed.chart');
 Route::get('/charts/documents-by-delayedChangeControl', [ChartController::class, 'documentDelayedChangeControl'])->name('api.document_by_delayedChangeControl.chart');
 Route::get('/charts/documents-by-delayedGlobalChangeControl', [ChartController::class, 'documentDelayedGlobalChangeControl'])->name('api.document_by_delayedGlobalChangeControl.chart');
 Route::get('/charts/documents-by-site', [ChartController::class, 'siteWiseDocument'])->name('api.document_by_site.chart');
 Route::get('/charts/documents-by-siteChangeControl', [ChartController::class, 'siteWiseChangeControlDocument'])->name('api.document_by_siteChangeControl.chart');
 Route::get('/charts/documents-by-siteGlobalChangeControl', [ChartController::class, 'siteWiseGlobalChangeControlDocument'])->name('api.document_by_siteGlobalChangeControl.chart');

 Route::get('/charts/pending-reviewers', [ChartController::class, 'document_pending_review_charts'])->name('api.document.pending.reviewers.chart');
 Route::get('/charts/pending-approvers', [ChartController::class, 'document_pending_approve_charts'])->name('api.document.pending.approvers.chart');
 Route::get('/charts/pending-hod', [ChartController::class, 'document_pending_hod_charts'])->name('api.document.pending.hod.chart');
 Route::get('/charts/pending-training', [ChartController::class, 'document_pending_training_charts'])->name('api.document.pending.training.chart');
 Route::get('flow-counts', [ChartController::class, 'getFlowCounts']);
 
 Route::post('/filter-deviation', [LogFilterController::class, 'deviation_filter'])->name('api.deviation.filter');
 Route::post('/change-control', [LogFilterController::class, 'changecontrol_filter'])->name('api.cccontrol.filter');
 Route::post('/control-sample', [LogFilterController::class, 'controlsample_filter'])->name('api.controlsample.filter');
 Route::post('/sample-plaining', [LogFilterController::class, 'sampleplaining_filter'])->name('api.sampleplanning.filter');
 Route::post('/sample-stability', [LogFilterController::class, 'samplestability_filter'])->name('api.samplestability.filter');
 Route::post('/inventory-management', [LogFilterController::class, 'inventorymanagement_filter'])->name('api.inventorymanagement.filter');
 Route::post('/prementive-maintenance', [LogFilterController::class, 'Preventive_filter'])->name('api.preventiveM.filter');
 Route::post('/errata',[LogFilterController::class,'errata_filter'])->name('api.errata.filter');
 Route::post('/failure-investigation',[LogFilterController::class,'failureInv_filter'])->name('api.failure.filter');
 Route::post('/inernal-audit',[LogFilterController::class,'internal_audit_filter'])->name('api.internalaudit.filter');
 Route::post('/marketcomplaint_data',[LogFilterController::class,'marketcomplaint_filter'])->name('api.marketcomplaint.filter');
 Route::post('/ooc',[LogFilterController::class,'ooc_filter'])->name('api.ooc.filter');
 Route::post('/incident',[LogFilterController::class,'IncidentFilter'])->name('api.incident.filter');
 Route::post('/lab-incident',[LogFilterController::class,'labincident_filter'])->name('api.laboratoryincident.filter');
 Route::post('/acton-item',[LogFilterController::class,'actonitem_filter'])->name('api.actonitem.filter');
 Route::post('/capa',[LogFilterController::class,'capa_filter'])->name('api.capa.filter');
 Route::post('/risk-management',[LogFilterController::class,'risk_management_filter'])->name('api.riskmanagement.filter');
 Route::post('/non-conformance',[LogFilterController::class,'nonconformance_filter'])->name('api.nonconformance.filter');
 Route::post('/oot',[LogFilterController::class,'OOT_Filter'])->name('api.oot.filter');
 
 Route::get('/test',[AllFormsController::class,'AllForms']);
 Route::get('/Change-ControlLog', [LogFilterController::class, 'printPDFCC'])->name('printReportcc');
 Route::get('/sample-stabilityLog', [LogFilterController::class, 'printPDFSS'])->name('printReportss');
 Route::get('/print-report', [LogFilterController::class, 'printPDF'])->name('printReport');
 Route::get('/print-actionitem', [LogFilterController::class, 'printPDFAction'])->name('printactionReport');
 Route::post('/rca',[LogFilterController::class,'rca_filter'])->name('api.rootcauseanalysis.filter');
 Route::get('/print-rca', [LogFilterController::class, 'printPDFRCA'])->name('printPDFrca');
 Route::post('/extension',[LogFilterController::class,'extension_filter'])->name('api.extension.filter');
 Route::get('/print-extension', [LogFilterController::class, 'printPDFExtension'])->name('printPDFextension');
 Route::post('/effectivness-check',[LogFilterController::class,'effectivness'])->name('api.effectivness.filter');
 Route::get('/print-effectivness', [LogFilterController::class, 'printPDFEffectivenesss'])->name('printPDFeffectivness');
 Route::get('/print-riskmt', [LogFilterController::class, 'printPDFriskmt'])->name('printPDFriskmt');
 Route::get('/print-nnconfermance', [LogFilterController::class, 'printPDFnnconfermance'])->name('printPDFnnconfermance');
 Route::get('/print-oot', [LogFilterController::class, 'printPDFoot'])->name('printPDFoot');
 Route::get('/print-errata', [LogFilterController::class, 'printPDFerrata'])->name('printPDFerrata');
 Route::get('/print-ooc', [LogFilterController::class, 'printPDFooc'])->name('printPDFooc');
 Route::get('/print-labincident', [LogFilterController::class, 'printPDFLab'])->name('printPDFLab');
 Route::get('/print-complaintM', [LogFilterController::class, 'printPDFcomplaintM'])->name('printPDFcomplaintM');
 Route::get('/print-Incident', [LogFilterController::class, 'printPDFIncident'])->name('printPDFIncident');
 Route::get('/print-internalAudit', [LogFilterController::class, 'printPDFInternalAudit'])->name('printPDFInternalAudit');
 Route::get('/print-Deviation', [LogFilterController::class, 'printPDFDeviation'])->name('printPDFDeviation');
 Route::get('/print-failureI', [LogFilterController::class, 'printPDFFailureInvestigation'])->name('printPDFFailureInvestigation');
 Route::get('/print-preventiveM', [LogFilterController::class, 'printpreventiveMPDF'])->name('printpreventiveMPDF');
 Route::get('/print-equipmentPdf', [LogFilterController::class, 'printequipmentPdf'])->name('printequipmentPdf');
 Route::get('/print-elmM', [LogFilterController::class, 'printelmPDF'])->name('printelmPDF');
 Route::get('/control-sampleLog', [LogFilterController::class, 'printPDFCS'])->name('printPDFCS');
 Route::get('/inventory-manangementLog', [LogFilterController::class, 'printPDFIM'])->name('printPDFIM');
 Route::post('/filter-document', [LogFilterController::class, 'documentFilter'])->name('api.document.filter');
 Route::post('/filter-pendingApprover', [LogFilterController::class, 'pendingApproverData'])->name('api.pendingApprover.filter');
 Route::get('/sample-plainingLog', [LogFilterController::class, 'printPDFSP'])->name('printPDFSP');
 Route::get('/documents',[DocumentController::class,'getDocList']);
 Route::get('division-wise-process', [ChartController::class, 'getDivisionProcessCounts'])->name('division-wise-process');
 Route::get('get-deviation-data', [ChartController::class, 'getDeviationData'])->name('get-deviation-data');
 Route::get('get-change-control-data', [ChartController::class, 'getChangeControlData'])->name('get-change-control-data');
 Route::get('get-action-item-data', [ChartController::class, 'getActionItemData'])->name('get-action-item-data');
 Route::get('get-global-change-control-data', [ChartController::class, 'getGlobalChangeControlData'])->name('get-global-change-control-data');
 Route::get('get-categorization-data', [ChartController::class, 'getcategorizationData'])->name('get-categorization-data');
 Route::get('get-change-control-categorization-data', [ChartController::class, 'getChangeControlCategorizationData'])->name('get-change-control-categorization-data');
 Route::get('get-global-change-control-categorization-data', [ChartController::class, 'getGlobalChangeControlCategorizationData'])->name('get-global-change-control-categorization-data');
 Route::get('get-action-item-categorization-data', [ChartController::class, 'getActionItemCategorizationData'])->name('get-action-item-categorization-data');


 Route::post('/equipment-management', [LogFilterController::class, 'equipmentlifecycle_filter'])->name('api.elmM.filter');
 Route::post('/analyst-qualification', [LogFilterController::class, 'analytics_filter'])->name('api.analytics.filter');

 Route::post('/calibration-management', [LogFilterController::class, 'calibrationmanagement_filter'])->name('api.calibrationmanagment.filter');
 Route::get('/calibration-managementLog', [LogFilterController::class, 'printPDFCM'])->name('printReportcm');

 
 Route::post('/external-audit', [LogFilterController::class, 'externalaudit_filter'])->name('api.externalaudit.filter');
 Route::get('/external-auditpdf', [LogFilterController::class, 'printPDFEA'])->name('printReportea');
 Route::post('/global-capa', [LogFilterController::class, 'globalcapa_filter'])->name('api.globalcapa.filter');
 Route::get('/global-capapdf', [LogFilterController::class, 'printPDFGCAPA'])->name('printReportglobalcapa');
 Route::post('/new-document', [LogFilterController::class, 'newdocument_filter'])->name('api.newdocument.filter');
 Route::get('/new-documentpdf', [LogFilterController::class, 'printPDFnewdocument'])->name('printReportnewdocument');

 Route::post('/sanction', [LogFilterController::class, 'sanction_filter'])->name('api.sanction.filter');
 Route::get('/sanction-logpdf', [LogFilterController::class, 'printPDFsanction'])->name('printReportsanction');
 Route::get('/analyst-qualificationLog', [LogFilterController::class, 'analyticspdf'])->name('analyticspdf');


 Route::post('/supplier', [LogFilterController::class, 'supplier_filter'])->name('api.supplier.filter');
 Route::get('/supplier-logpdf', [LogFilterController::class, 'printPDFsupplier'])->name('printReportsupplier');

 Route::post('/supplieraudit', [LogFilterController::class, 'supplieraudit_filter'])->name('api.supplieraudit.filter');
 Route::get('/supplier-auditlogpdf', [LogFilterController::class, 'printPDFsupplieraudit'])->name('printReportsupplieraudit');
 Route::get('/audit-programpdf', [LogFilterController::class, 'printPDFauditprogrampdf'])->name('printPDFauditprogrampdf');
 Route::post('/audit-program', [LogFilterController::class, 'auditprogram_filter'])->name('api.auditprogram.filter');

 Route::post('/test',[MeetingController::class,'create_action_item']);
 Route::get('/ehs-event', [LogFilterController::class, 'printReportehsevent'])->name('api.ehsevent.filter');
 Route::get('/ehs-eventLog', [LogFilterController::class, 'printReportehseventLog'])->name('printReportehseventLog');

//  ====extension==
Route::get('/charts/document_by_priority_extension', [ChartController::class, 'documentByPriorityExtension'])->name('api.document_by_priority_extension.chart');
Route::get('/charts/extension_Stage_Distribution', [ChartController::class, 'stageByPriorityExtension'])->name('api.extension_Stage_Distribution.chart');



/******* CAPA, Global CAPA, Incident Starts ********/

Route::get('capa-initial-categorization', [ChartController::class, 'getCapaInitialCategorization'])->name('capa-initial-categorization');
Route::get('capa-post-categorization', [ChartController::class, 'getCapaPostCategorization'])->name('capa-post-categorization');
Route::get('capa-ontime-delayed-records', [ChartController::class, 'getOnTimeVsDelayedRecords'])->name('capa-ontime-delayed-records');
Route::get('capa-sitewise-records', [ChartController::class, 'getCapaByDivision'])->name('capa-sitewise-records');
Route::get('capa-priority-records', [ChartController::class, 'getCapaPriorityData'])->name('capa-priority-records');
Route::get('capa-status-records', [ChartController::class, 'getCapaByStatus'])->name('capa-status-records');


/******* CAPA, Global CAPA, Incident Ends ********/

/******* Sample Managementstatus Chart Strats ********/

Route::get('samplemanagementstatuschart', [ChartController::class, 'samplemanagementstatuschart'])->name('samplemanagementstatuschart');
Route::get('samplemanagementdepartmentchart', [ChartController::class, 'samplemanagementdepartmentchart'])->name('samplemanagementdepartmentchart');
Route::get('samplemanagementdivisionchart', [ChartController::class, 'samplemanagementdivisionchart'])->name('samplemanagementdivisionchart');
Route::get('samplemanagementsampletypechart', [ChartController::class, 'samplemanagementsampletypechart'])->name('samplemanagementsampletypechart');

Route::get('samplemanagementturnaroundchart', [ChartController::class, 'samplemanagementturnaroundchart'])->name('samplemanagementturnaroundchart');







Route::prefix('project-planner')->group(function () {
    // Company Routes
    Route::post('/companies', [ProjectPlannerController::class, 'createCompany']);
    Route::get('/companies/{id}', [ProjectPlannerController::class, 'getCompany']);
    Route::put('/companies/{id}', [ProjectPlannerController::class, 'updateCompany']);
    Route::delete('/companies/{id}', [ProjectPlannerController::class, 'deleteCompany']);
    Route::get('/get-all-companies', [ProjectPlannerController::class, 'getAllCompanies']);


    // Company Holidays Routes
    Route::post('/companies/{companyId}/holidays', [ProjectPlannerController::class, 'createHoliday']);
    Route::get('/companies/{companyId}/holidays', [ProjectPlannerController::class, 'getHolidays']);
    Route::put('/holidays/{id}', [ProjectPlannerController::class, 'updateHoliday']);
    Route::delete('/holidays/{id}', [ProjectPlannerController::class, 'deleteHoliday']);

    // Company Weekends Routes
    Route::post('/companies/{companyId}/weekends', [ProjectPlannerController::class, 'createWeekend']);
    Route::get('/companies/{companyId}/weekends', [ProjectPlannerController::class, 'getWeekend']);
    Route::put('/weekends/{id}', [ProjectPlannerController::class, 'updateWeekend']);
    Route::delete('/weekends/{id}', [ProjectPlannerController::class, 'deleteWeekend']);

    // Project Planner Routes
    Route::post('/companies/{companyId}/project-planner', [ProjectPlannerController::class, 'createProjectPlanner']);
    Route::get('/companies/{companyId}/project-planner', [ProjectPlannerController::class, 'getProjectPlanner']);
    Route::put('/project-planner/{id}', [ProjectPlannerController::class, 'updateProjectPlanner']);
    Route::delete('/project-planner/{id}', [ProjectPlannerController::class, 'deleteProjectPlanner']);

    Route::get('/companies/{companyId}/weekend-and-holidays', [ProjectPlannerController::class, 'getWeekendAndHolidays']);
});


