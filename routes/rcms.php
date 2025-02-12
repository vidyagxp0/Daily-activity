<?php

use App\Http\Controllers\ErrataController;
use App\Http\Controllers\ExtensionNewController;
use App\Http\Controllers\PrintRequestController;
use App\Http\Controllers\rcms\ActionItemController;
use App\Http\Controllers\lims\AnalyticsController;
use App\Http\Controllers\rcms\AuditeeController;
use App\Http\Controllers\SupplierAuditController;
use App\Http\Controllers\rcms\CCController;
use App\Http\Controllers\rcms\DashboardController;
use App\Http\Controllers\rcms\LimsDashboardController;
use App\Http\Controllers\PreventiveMaintenanceController;
use App\Http\Controllers\rcms\EffectivenessCheckController;
use App\Http\Controllers\rcms\ExtensionController;
use App\Http\Controllers\rcms\InternalauditController;
use App\Http\Controllers\rcms\LabIncidentController;
use App\Http\Controllers\rcms\ObservationController;
use App\Http\Controllers\rcms\IncidentController;
use App\Http\Controllers\rcms\SupplierController;
use App\Http\Controllers\lims\SamplingStabilityController;
use App\Http\Controllers\UserLoginController;
use App\Http\Controllers\rcms\GlobalChangeControlController;
use App\Http\Controllers\rcms\AuditProgramController;
use App\Http\Controllers\rcms\CapaController;
use App\Http\Controllers\rcms\GlobalCapaController;
use App\Http\Controllers\rcms\FormDivisionController;
use App\Http\Controllers\rcms\ManagementReviewController;
use App\Http\Controllers\rcms\OOTController;
use App\Http\Controllers\rcms\OOSController;
use App\Http\Controllers\rcms\MarketComplaintController;
use App\Http\Controllers\rcms\FailureInvestigationController;
use App\Http\Controllers\rcms\NotificationController;
use App\Http\Controllers\OOSMicroController;
use App\Http\Controllers\rcms\NonConformaceController;
use App\Http\Controllers\EquipmentLifecycleManagementController;
use App\Http\Controllers\rcms\RootCauseController;
use App\Http\Controllers\RiskManagementController;
use App\Http\Controllers\rcms\DeviationController;
use App\Http\Controllers\rcms\LogController;
use App\Http\Controllers\rcms\OOCController;
use App\Http\Controllers\RegulatoryDashboardController;
use App\Http\Controllers\RegulatoryActionController;
use App\Http\Controllers\tms\TrainerController;
use App\Http\Controllers\rcms\QueryManagementController;
use App\Http\Controllers\rcms\MeetingController;
use App\Http\Controllers\rcms\MeetingManagementController;
use App\Http\Controllers\lims\LimsController;
use App\Http\Controllers\lims\SamplePlanningController;
use App\Http\Controllers\lims\StabilityManagementController;
use App\Http\Controllers\lims\ControlSampleController;
use App\Http\Controllers\CallibrationDetailsController;
use  App\Http\Controllers\EhsController;

use App\Models\EffectivenessCheck;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\YearlyTrainingPlannerController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ResamplingController;
use App\Http\Controllers\TrainingMaterialManagementController;
use App\Http\Controllers\InductionTrainingController;
use App\Http\Controllers\JobDescriptionController;
use App\Http\Controllers\DepartmentWiseController;
use App\Http\Controllers\tms\ClassroomTrainingController;
use App\Http\Controllers\tms\TNIController;
use App\Http\Controllers\tms\EmployeeController;
use App\Http\Controllers\tms\JobTrainingController;

// ============================================
//                   RCMS
//============================================

Route::group(['prefix' => 'rcms'], function () {
    Route::view('rcms', 'frontend.rcms.main-screen');
    Route::get('rcms_login', [UserLoginController::class, 'userlogin']);
    Route::view('rcms_dashboard', 'frontend.rcms.dashboard');
    Route::view('form-division', 'frontend.forms.form-division');
    Route::view('form-division-regulatory', 'frontend.rcms.Regulatorylayout.form-division-regulatory');
    Route::get('/logout', [UserLoginController::class, 'rcmslogout'])->name('rcms.logout');
    // Route::post('/storeSessionTime', [UserLoginController::class, 'storeLogout'])->name('rcms.storeSessionTime');
    Route::post('/store-session-time', [UserLoginController::class, 'storeSessionTime'])->name('rcms.storeSessionTime');

    Route::get('/qms-logs/{slug}', [LogController::class, 'index'])->name('rcms.logs.show');
    Route::get('/login-logout-session', [UserLoginController::class, 'mySession'])->name('rcms.mySession');
    Route::get('/employee/login', [UserLoginController::class, 'employeeLoginForm'])->name('employee.login');
    Route::post('/employee/login', [UserLoginController::class, 'employeeLogin'])->name('employee.login.submit');
    Route::get('documents/viewpdf/{id}', action: [DocumentController::class, 'viewPdf']);

    // Route::middleware(['rcms'])->group(
        Route::middleware(['rcms', 'active-account'])->group(
        function () {

            Route::get('traineraudittrail/{id}', [TrainerController::class, 'AuditTrial'])->name('audittrail');
            Route::get('auditDetailsTrainer/{id}', [TrainerController::class, 'auditDetailstrainer'])->name('trainerauditDetails');
            Route::post('job_trainer_send/{id}', [JobTrainingController::class, 'sendStage']);
            Route::post('classroom_trainer_send/{id}', [ClassroomTrainingController::class, 'sendStage']);
            Route::get('traineraudittrail/{id}', [TrainerController::class, 'trainerAuditTrial'])->name('trainer.audittrail');
            Route::get('trainer_report/{id}', [TrainerController::class, 'trainerReport'])->name('trainer_report');

            Route::post('job_description_send/{id}', [JobDescriptionController::class, 'sendJDStage']);


            Route::get('job_training_report/{id}', [JobTrainingController::class, 'jobReport'])->name('job_training_report');
            Route::get('classroom_training_report/{id}', [ClassroomTrainingController::class, 'jobReport'])->name('classroom_training_report');
            // Route::get('auditDetailsTrainer/{id}', [TrainerController::class, 'auditDetailstrainer'])->name('trainerauditDetails');
            Route::get('employeeaudittrail/{id}', [EmployeeController::class, 'AuditTrial'])->name('audittrail');
            Route::get('jobdescriptionaudittrail/{id}', [JobDescriptionController::class, 'AuditTrial'])->name('auditTrail');

            Route::get('reports/{id}', [EmployeeController::class, 'report'])->name('reports');
            Route::get('report/{id}', [JobDescriptionController::class, 'report'])->name('report');
            // Route::get('auditDetailsEmployee/{id}', [EmployeeController::class, 'auditDetailsEmployee'])->name('employeeauditDetails');
            Route::get('job_traineeaudittrail/{id}', [JobTrainingController::class, 'jobAuditTrial'])->name('job_audittrail');
            Route::get('classroom_traineeaudittrail/{id}', [ClassroomTrainingController::class, 'classroomAuditTrial'])->name('classroom_audittrail');
            // Route::get('auditDetailsEmployee/{id}', [JobTrainingController::class, 'auditDetailsJobTrainee'])->name('jobTraineeauditDetails');
            Route::get('induction_traineeaudittrail/{id}', [InductionTrainingController::class, 'inductionAuditTrial'])->name('induction_audittrail');
            Route::get('induction_report/{id}', [InductionTrainingController::class, 'inductionReport'])->name('induction_report');
            // Route::get('auditDetailsEmployee/{id}', [InductionTrainingController::class, 'auditDetailsInduction'])->name('InductionauditDetails');
            Route::post('employee_Child/{id}', [EmployeeController::class, 'Employee_Child'])->name('employee.child');
            Route::post('job_training_Child/{id}', [InductionTrainingController::class, 'Induction_Child'])->name('induction.child');

            Route::resource('CC', CCController::class);

            Route::post('send-initiator/{id}', [CCController::class, 'sendToInitiator']);
            Route::post('send-hod/{id}', [CCController::class, 'sendToHod']);
            Route::post('send-initialQA/{id}', [CCController::class, 'sendToInitialQA']);
            Route::post('send-cft-from-QA/{id}', [CCController::class, 'sendToCft']);
            Route::get('/export-csv', [CCController::class, 'exportCsv'])->name('export.csv');
            Route::get('/export-excel', [CCController::class, 'exportExcel'])->name('export.excel');

        Route::get('/rcms/exportpm-csv', [PreventiveMaintenanceController::class, 'exportPmCsv'])->name('exportPmCsv');
        Route::get('/rcms/exportpm-excel', [PreventiveMaintenanceController::class, 'exportPmExcel'])->name('exportPmExcel');


            Route::get('action-items-create', [ActionItemController::class, 'showAction']);
            Route::resource('actionItem', ActionItemController::class);
            Route::post('action-stage-cancel-new/{id}', [ActionItemController::class, 'actionStageCancel']);
            // Logs Export - CSV ,EXCEL Routes
            Route::get('/actionitem/export-csv', [ActionItemController::class, 'exportCsv'])->name('export.csv.actionitem');
            Route::get('/actionitem/export-excel', [ActionItemController::class, 'exportExcel'])->name('export.excel.actionitem');
            Route::get('/rcms/exportcsv', [MarketComplaintController::class, 'exportCsv'])->name('exportcsvcomplaintcmt');
            Route::get('/rcms/exportexcel', [MarketComplaintController::class, 'exportExcel'])->name('exportxlscomplaintcmt');
           
            Route::get('/rcms/exportcsvinc', [IncidentController::class, 'exportCsv'])->name('exportcsvinc');
            Route::get('/rcms/exportexcelinc', [IncidentController::class, 'exportExcel'])->name('exportxlsinc');
           

            Route::get('/rcms/exportcsvIA', [InternalauditController::class, 'exportCsv'])->name('exportcsvIA');
            Route::get('/rcms/exportexcelIA', [InternalauditController::class, 'exportExcel'])->name('exportxlsIA');
          
            
            Route::get('/rcms/exportcsvdvt', [DeviationController::class, 'exportCsv'])->name('exportcsvdvt');
            Route::get('/rcms/exportexceldvt', [DeviationController::class, 'exportExcel'])->name('exportexceldvt');
          

           
         
            Route::get('/rcms/exportcsvfi', [FailureInvestigationController::class, 'exportCsv'])->name('exportcsvfi');
            Route::get('/rcms/exportexcelfi', [FailureInvestigationController::class, 'exportExcel'])->name('exportexcelfi');
         
         
             Route::get('/rcms/exportcsvrm', [RiskManagementController::class, 'exportCsv'])->name('exportcsvrm');
            Route::get('/rcms/exportexcelrm', [RiskManagementController::class, 'exportExcel'])->name('exportexcelrm');

            Route::get('/rcms/exportcsvnc', [NonConformaceController::class, 'exportCsv'])->name('exportcsvnc');
            Route::get('/rcms/exportexcelnc', [NonConformaceController::class, 'exportExcel'])->name('exportexcelnc');
         
            Route::get('/rcms/exportcsvOOT', [OOTController::class, 'exportCsv'])->name('exportcsvOOT');
            Route::get('/rcms/exportexcelOOT', [OOTController::class, 'exportExcel'])->name('exportexceOOT');
            
            Route::get('/rcms/exportcsverrata', [ErrataController::class, 'exportCsv'])->name('exportcsverrata');
            Route::get('/rcms/exportexceerrata', [ErrataController::class, 'exportExcel'])->name('exportexceerrata');
         
            Route::get('/rcms/exportcsvooc', [OOCController::class, 'exportCsv'])->name('exportcsvooc');
            Route::get('/rcms/exportexceooc', [OOCController::class, 'exportExcel'])->name('exportexceooc');
         
            
            Route::get('exportdeviationcsv', [DeviationController::class, 'exportCsv'])->name('exportdeviationcsv');
            Route::get('exportdeviationexcel', [DeviationController::class, 'exportExcel'])->name('exportdeviationexcel');
            Route::get('/rcms/exportcsvsp', [SamplePlanningController::class, 'exportCsv'])->name('exportcsvsp');
            Route::get('/rcms/exportexcesp', [SamplePlanningController::class, 'exportExcel'])->name('exportexcesp');
            /*********** LIMS Route Starts *********/
            Route::get('lims-dashboard', [LimsController::class, 'index'])->name('lims.dashboard');

            Route::get('recordModalLims/{id}/{type}', [LimsController::class, 'limsRecordModal'])->name('recordModalLims');

            Route::get('sample-planning', [SamplePlanningController::class, 'index'])->name('sample-planning');
            Route::post('store-sample-planning', [SamplePlanningController::class, 'store'])->name('store-sample-planning');
            Route::get('edit-sample-planning/{id}', [SamplePlanningController::class, 'edit'])->name('edit-sample-planning');
            Route::any('update-sample-planning/{id}', [SamplePlanningController::class, 'update'])->name('update-sample-planning');
            Route::post('sample-planning-sendStage/{id}', [SamplePlanningController::class, 'sendStage'])->name('sample-planning-sendStage');
            Route::post('sample-planning-rejectStage/{id}', [SamplePlanningController::class, 'rejectStage'])->name('sample-planning-rejectStage');
            Route::get('sample-planning-audit-trail/{id}', [SamplePlanningController::class, 'auditTrial'])->name('sample-planning-audit-trail');
            Route::get('sample-planning-audit-report/{id}', [SamplePlanningController::class, 'audit_pdf'])->name('sample-planning-audit-report');
            Route::get('sample-planning-single-report/{id}', [SamplePlanningController::class, 'singleReport'])->name('sample-planning-single-report');
            Route::get('sample-planning-single-report-show/{id}', [SamplePlanningController::class, 'singleReportShow'])->name('sample-planning-single-report-show');
            Route::post('sample-planning-child/{id}', [SamplePlanningController::class, 'samplePlanningChild'])->name('sample-planning-child');

            Route::get('stability-management', [StabilityManagementController::class, 'index'])->name('stability-management');
            Route::post('store-stability-management', [StabilityManagementController::class, 'store'])->name('store-stability-management');
            Route::get('edit-stability-management/{id}', [StabilityManagementController::class, 'edit'])->name('edit-stability-management');
            Route::any('update-stability-management/{id}', [StabilityManagementController::class, 'update'])->name('update-stability-management');
            Route::post('stability-management-sendStage/{id}', [StabilityManagementController::class, 'sendStage'])->name('stability-management-sendStage');
            Route::post('stability-management-rejectStage/{id}', [StabilityManagementController::class, 'rejectStage'])->name('stability-management-rejectStage');
            Route::get('stability-management-audit-trail/{id}', [StabilityManagementController::class, 'auditTrial'])->name('stability-management-audit-trail');
            Route::get('stability-management-audit-report/{id}', [StabilityManagementController::class, 'audit_pdf'])->name('stability-management-audit-report');
            Route::get('stability-management-single-report/{id}', [StabilityManagementController::class, 'singleReport'])->name('stability-management-single-report');
            Route::post('stability-management-child/{id}', [StabilityManagementController::class, 'samplePlanningChild'])->name('stability-management-child');
            /*********** LIMS Route Ends *********/

            Route::get('analytics_qualification', [AnalyticsController::class, 'index'])->name('analytics_qualification');
            Route::post('analytics', [AnalyticsController::class, 'store'])->name('analytics.store');
            Route::post('analytics/{id}', [AnalyticsController::class, 'update'])->name('analytics.update');
            Route::get('analytics_qualification_view/{id}', [AnalyticsController::class, 'show'])->name('analytics_qualification.show');
            Route::post('analytics_sendstage/{id}', [AnalyticsController::class, 'sendStage'])->name('analytics_sendstage');
            Route::post('analytics/rejectStage/{id}', [AnalyticsController::class, 'rejectStage']);
            Route::get('getEmployeeDetails/{id}', [AnalyticsController::class, 'getEmployeeDetails']);
            Route::get('analytics/audittrail/{id}', [AnalyticsController::class, 'analyticsAuditTrial'])->name('analytics.audittrail');
            Route::get('analytics_report/{id}', [AnalyticsController::class, 'analyticsReport'])->name('analytics_report');



            Route::get('action-item-audittrialshow/{id}', [ActionItemController::class, 'actionItemAuditTrialShow'])->name('showActionItemAuditTrial');
            Route::get('action-item-audittrialdetails/{id}', [ActionItemController::class, 'actionItemAuditTrialDetails'])->name('showaudittrialactionItem');
            Route::get('actionitemSingleReport/{id}', [ActionItemController::class, 'singleReport'])->name('actionitemSingleReport');
            Route::get('at_showpdf/{id}', [ActionItemController::class, 'singleReportShow'])->name('at_showpdf');
            
            Route::get('actionitemAuditReport/{id}', [ActionItemController::class, 'auditReport'])->name('actionitemAuditReport');
            Route::get('actionitemauditTrailPdfNew/{id}', [ActionItemController::class, 'auditTrailPdf'])->name('actionitemauditTrailPdfNew');
            Route::post('send-At-new/{id}', [ActionItemController::class, 'stageChange']);
            Route::post('moreinfoState_actionitem/{id}', [ActionItemController::class, 'actionmoreinfo']);

                // ========================================regulatory action ================
                Route::get('regulatory-action-task-create', [RegulatoryActionController::class, 'showAction']);
                Route::get('regulatory-action-view/{id}', [RegulatoryActionController::class, 'show']);
                Route::post('regulatory-action-task' , [RegulatoryActionController::class,'Create'])->name('regulatory_action_create');
                Route::post('regulatory-actionView/{id}' , [RegulatoryActionController::class,'update']);
                Route::post('action-stage-cancel/{id}', [RegulatoryActionController::class, 'actionStageCancel']);
                Route::get('RegulatoryActionAuditTrialShow/{id}', [RegulatoryActionController::class, 'RegulatoryActionAuditTrialShow'])->name('RegulatoryActionAuditTrialShow');
                // Route::get('action-item-audittrialdetails/{id}', [RegulatoryActionController::class, 'RegulatoryActionAuditTrialShow'])->name('showaudittrialactionItem');
                Route::get('regulatoryactionSingleReport/{id}', [RegulatoryActionController::class, 'singleReport'])->name('regulatoryactionSingleReport');
                Route::get('regulatoryactionAuditReport/{id}', [RegulatoryActionController::class, 'auditReport'])->name('regulatoryactionAuditReport');
                Route::get('actionitemauditTrailPdf/{id}', [RegulatoryActionController::class, 'auditTrailPdf'])->name('actionitemauditTrailPdf');
                Route::post('action-stage-cancel/{id}', [RegulatoryActionController::class, 'actionStageCancel']);
                Route::post('send-At/{id}', [RegulatoryActionController::class, 'stageChange']);
// ========================
            Route::get('effective-audit-trial-show/{id}', [EffectivenessCheckController::class, 'effectiveAuditTrialShow'])->name('show_effective_AuditTrial');
            Route::get('effective-audit-trial-details/{id}', [EffectivenessCheckController::class, 'effectiveAuditTrialDetails'])->name('show_audittrial_effective');
            Route::get('effectiveSingleReport/{id}', [EffectivenessCheckController::class, 'singleReport'])->name('effectiveSingleReport');
            Route::get('effective_showpdf/{id}', [EffectivenessCheckController::class, 'singleReportShow'])->name('effective_showpdf');

            Route::get('effectiveAuditReport/{id}', [EffectivenessCheckController::class, 'auditReport'])->name('effectiveAuditReport');
            Route::post('closed-cancelled/{id}', [EffectivenessCheckController::class, 'closedCancelled'])->name('closed-cancelled');
            Route::post('effectiveness_child/{id}', [EffectivenessCheckController::class, 'effectiveness_child'])->name('effectiveness_child');
            Route::post('send-not-effective/{id}', [EffectivenessCheckController::class, 'sendToNotEffective'])->name('send-not-effective');
            Route::post('closed-cancelled/{id}', [EffectivenessCheckController::class, 'closedCancelled'])->name('closed-cancelled');
            Route::get('actionitemauditTrailPdf/{id}', [ActionItemController::class, 'auditTrailPdf'])->name('actionitemauditTrailPdf');
            Route::get('/actionItemFilter/{id}',[ActionItemController::class,'audit_trail_filter_action'])->name('actionItemFilter');
            Route::post('action-stage-cancel/{id}', [ActionItemController::class, 'actionStageCancel']);

            // ------------------extension _child---------------------------
            Route::post('extension_child/{id}', [ExtensionController::class, 'extension_child'])->name('extension_child');
            Route::resource('extension', ExtensionController::class);
            Route::post('send-extension/{id}', [ExtensionController::class, 'stageChange']);
            Route::post('send-reject-extention/{id}', [ExtensionController::class, 'stagereject']);
            Route::post('send-cancel-extention/{id}', [ExtensionController::class, 'stagecancel']);
            Route::get('extension-audit-trial/{id}', [ExtensionController::class, 'extensionAuditTrial']);
            Route::get('extension-audit-trial-details/{id}', [ExtensionController::class, 'extensionAuditTrialDetails']);
            Route::get('extensionSingleReport/{id}', [ExtensionController::class, 'singleReport'])->name('extensionSingleReport');
            Route::get('extensionAuditReport/{id}', [ExtensionNewController::class, 'auditReport'])->name('extensionAuditReport');

            /********** TNI Routes Start *********/

            Route::get('create-tni', [TNIController::class, 'create'])->name('create-tni');
            Route::post('tni-store', [TNIController::class, 'store'])->name('tni-store');
            Route::get('document-detail/{id}', [TNIController::class, 'getDocumentDetail'])->name('document-detail');
            Route::get('edit-tni/{id}', [TNIController::class, 'show']);
            Route::get('report/{id}', [TNIController::class, 'report'])->name('report');
            Route::post('tni-update/{id}', [TNIController::class, 'update'])->name('tni-update');
            Route::post('tni-stage-change/{id}', [TNIController::class, 'stageChange'])->name('tni-stage-change');
            Route::post('tni-stage-reject/{id}', [TNIController::class, 'stageReject'])->name('tni-stage-reject');
            Route::post('tni-closed-cancelled/{id}', [TNIController::class, 'closeCancelled'])->name('tni-closed-cancelled');


            
            Route::get('department-wise-employee', [DepartmentWiseController::class, 'index'])->name('department-wise-employee');
            Route::post('department-wise-store', [DepartmentWiseController::class, 'create'])->name('department-wise-store');
            Route::get('departmentwise_view/{id}', [DepartmentWiseController::class, 'show'])->name('departmentwise_view');
            Route::put('department_wise_update/update/{id}', [DepartmentWiseController::class, 'update'])->name('departmentwise_update');
            Route::post('dwse-stage-change/{id}', [DepartmentWiseController::class, 'stageChange'])->name('dwse-stage-change');
            Route::post('dwse-stage-reject/{id}', [DepartmentWiseController::class, 'stageReject'])->name('dwse-stage-reject');
            Route::get('/department-wise/{id}/report', [DepartmentWiseController::class, 'report'])->name('departmentwise.report');
            Route::get('/department_wise_report', [DepartmentWiseController::class, 'department_wise_report'])->name('department_wise_report');





            /********** TNI Routes Ends *********/


            Route::post('send-At/{id}', [ActionItemController::class, 'stageChange']);
            Route::post('send-rejection-field/{id}', [CCController::class, 'stagereject']);
            Route::post('send-cft-field/{id}', [CCController::class, 'stageCFTnotReq']);

            Route::post('send-cancel/{id}', [CCController::class, 'stagecancel']);
            Route::post('send-cc/{id}', [CCController::class, 'stageChange']);
            Route::post('child/{id}', [CCController::class, 'child']);
            Route::get('qms-dashboard', [DashboardController::class, 'index'])->name('qms.dashboard');
            // Route::get('ksi-overview', [DashboardController::class, 'index'])->name('qms.dashboard');
            Route::get('qms-dashboard/{id}/{process}', [DashboardController::class, 'dashboard_child']);
            Route::get('qms-dashboard_new/{id}/{process}', [DashboardController::class, 'dashboard_child_new']);
            Route::get('qms-record-analytics', [DashboardController::class, 'qmsRecordAnalytics'])->name('qmsRecordAnalytics');
            Route::get('audit-trial/{id}', [CCController::class, 'auditTrial']);
            Route::get('audit-detail/{id}', [CCController::class, 'auditDetails']);
            Route::get('summary/{id}', [CCController::class, 'summery_pdf']);
            Route::get('audit/{id}', [CCController::class, 'audit_pdf']);
            Route::get('changeControlFamilyReport/{id}', [CCController::class, 'familyReport'])->name('changeControlFamilyReport');
            
            Route::post('send-qa-approval/{id}', [CCController::class, 'sentToQAHeadApproval'])->name('send-qa-approval');
            Route::post('send-reject/{id}', [CCController::class, 'reject'])->name('send-reject');
            Route::post('send-post-implementation/{id}', [CCController::class, 'sentoPostImplementation'])->name('send-post-implementation');
            Route::get('ccView/{id}/{type}', [DashboardController::class, 'ccView'])->name('ccView');
            // Route::get('ccView/{id}/{type}', [RegulatoryDashboardController::class, 'ccViewRegulatory'])->name('ccView');            
            Route::get('get-doc-detail/{id}', [CCController::class, 'getDocumentDetail'])->name('get-doc-detail');
            Route::view('summary_pdf', 'frontend.change-control.summary_pdf');
            Route::view('audit_trial_pdf', 'frontend.change-control.audit_trial_pdf');
            Route::view('change_control_single_pdf', 'frontend.change-control.change_control_single_pdf');
            Route::get('change_control_family_pdf', [CCController::class, 'parent_child']);
            Route::get('changeControl-single-show/{id}', [CCController::class, 'singleReportShow'])->name('changeControl-single-show');

            Route::get('change_control_single_pdf/{id}', [CCController::class, 'single_pdf']);
            Route::get('eCheck/{id}', [CCController::class, 'eCheck']);
            Route::resource('effectiveness', EffectivenessCheckController::class);
            Route::post('send-effectiveness/{id}', [EffectivenessCheckController::class, 'stageChange']);
            Route::post('effectiveness-reject/{id}', [EffectivenessCheckController::class, 'reject']);
            Route::post('moreinfo_effectiveness/{id}',[EffectivenessCheckController::class,'cancel'])->name('moreinfo_effectiveness');
            Route::post('effectiveness_child/{id}', [EffectivenessCheckController::class, 'effectiveness_child'])->name('effectiveness_child');
            Route::view('helpdesk-personnel', 'frontend.rcms.helpdesk-personnel');
            Route::view('send-notification', 'frontend.rcms.send-notification');
            Route::get('new-change-control', [CCController::class, 'changecontrol']);

            //----------------------------------------------By Pankaj-----------------------

            Route::post('audit', [InternalauditController::class, 'create'])->name('createInternalAudit');
            Route::get('internalAuditShow/{id}', [InternalauditController::class, 'internalAuditShow'])->name('showInternalAudit');
            Route::post('update/{id}', [InternalauditController::class, 'update'])->name('updateInternalAudit');
            Route::post('InternalAuditStateChange/{id}', [InternalauditController::class, 'InternalAuditStateChange'])->name('AuditStateChange');
            Route::get('InternalAuditTrialShow/{id}', [InternalauditController::class, 'InternalAuditTrialShow'])->name('ShowInternalAuditTrial');
            Route::get('InternalAuditTrialDetails/{id}', [InternalauditController::class, 'InternalAuditTrialDetails'])->name('showaudittrialinternalaudit');
            Route::get('internalObservationSingleReport/{id}', [InternalauditController::class, 'observationSingleReport']);
            Route::get('/incident/{id}',[IncidentController::class,'audit_trail_filter_incident'])->name('incident_filter');
            Route::get('audit_trail/{id}', action: [YearlyTrainingPlannerController::class, 'auditTrial'])->name('audit_trail');

            //-------------------------


            // User Notification Route
            Route::get('user-notification', [NotificationController::class, 'userNotification'])->name('user-notification');
            Route::get('/notifications/{id}/seen', [NotificationController::class, 'notificationSeen'])->name('notifications.seen');
            Route::get('/notifications/{id}', [NotificationController::class, 'show'])->name('notification.details');

            Route::post('labcreate', [LabIncidentController::class, 'create'])->name('labIncidentCreate');
            Route::get('LabIncidentShow/{id}', [LabIncidentController::class, 'LabIncidentShow'])->name('ShowLabIncident');
            Route::post('LabIncidentStateChange/{id}', [LabIncidentController::class, 'LabIncidentStateChange'])->name('StageChangeLabIncident');
            Route::post('LabIncidentStateTwo/{id}', [LabIncidentController::class, 'LabIncidentStateTwo'])->name('StageChangeLabtwo');
            Route::post('RejectStateChangeEsign/{id}', [LabIncidentController::class, 'RejectStateChange'])->name('RejectStateChange');
            Route::post('updateLabIncident/{id}', [LabIncidentController::class, 'updateLabIncident'])->name('LabIncidentUpdate');
            Route::post('LabIncidentCancel/{id}', [LabIncidentController::class, 'LabIncidentCancel'])->name('LabIncidentCancel');
            Route::post('LabIncidentChildCapa/{id}', [LabIncidentController::class, 'lab_incident_capa_child'])->name('lab_incident_capa_child');
            Route::post('LabIncidentChildRoot/{id}', [LabIncidentController::class, 'lab_incident_root_child'])->name('lab_incident_root_child');
            Route::post('labincidentRiskChild/{id}', [LabIncidentController::class, 'labincidentRiskChild'])->name('labincidentRisk_Child');
            Route::get('LabIncidentAuditTrial/{id}', [LabIncidentController::class, 'LabIncidentAuditTrial'])->name('audittrialLabincident');
            Route::get('auditDetailsLabIncident/{id}', [LabIncidentController::class, 'auditDetailsLabIncident'])->name('LabIncidentauditDetails');
            Route::post('root_cause_analysis/{id}', [LabIncidentController::class, 'root_cause_analysis'])->name('Child_root_cause_analysis');
            Route::get('LabIncidentSingleReport/{id}', [LabIncidentController::class, 'singleReport'])->name('LabIncidentSingleReport');
            Route::get('labincident_showpdf/{id}', [LabIncidentController::class, 'singleReportShow'])->name('labincident_showpdf');

            Route::get('LabIncidentAuditReport/{id}', [LabIncidentController::class, 'auditReport'])->name('LabIncidentAuditReport');
            Route::post('labExtChild/{id}', [LabIncidentController::class, 'lab_incident_extension_child'])->name('lab_incident_extension_child');
            Route::get('labincidentFamilyReport/{id}', [LabIncidentController::class, 'familyReport'])->name('labincidentFamilyReport');
            Route::get('labincident_activity_pdf/{id}', [LabIncidentController::class, 'LabIncidentActivityLogPdf'])->name('labincident_activity_pdf');


            /********** Query Management Route Starts **********/

            Route::get('query-managements', [QueryManagementController::class, 'create'])->name('query-managements');
            Route::post('query-managements-store', [QueryManagementController::class, 'store'])->name('query-managements-store');
            Route::get('query-managements-edit/{id}', [QueryManagementController::class, 'edit'])->name('query-managements-edit');
            Route::any('query-managements-update/{id}', [QueryManagementController::class, 'update'])->name('query-managements-update');
            Route::get('query-managements-audit-trail/{id}', [QueryManagementController::class, 'auditTrail'])->name('query-managements-audit-trail');
            Route::get('query-managements-audit-report/{id}', [QueryManagementController::class, 'auditReport'])->name('query-managements-audit-report');
            Route::get('query-managements-single-report/{id}', [QueryManagementController::class, 'singleReport'])->name('query-managements-single-report');
            Route::post('send-stage/{id}', [QueryManagementController::class, 'sendStage'])->name('send-stage');
            Route::post('closed-cancelled/{id}', [QueryManagementController::class, 'closedCancelled'])->name('closed-cancelled');
            Route::post('stage-reject/{id}', [QueryManagementController::class, 'stageReject'])->name('stage-reject');
            Route::post('cft-not-required/{id}', [QueryManagementController::class, 'cftNotRequired'])->name('cft-not-required');
            Route::post('sendTo-HOD/{id}', [QueryManagementController::class, 'sendToHOD'])->name('sendTo-HOD');
            Route::post('sendTo-initiator/{id}', [QueryManagementController::class, 'sendToInitiator'])->name('sendTo-initiator');
            Route::post('action-item-child/{id}', [CCController::class, 'actionItemChild'])->name('action-item-child');

            /********** Query Management Route Ends **********/

            /********** Global CC Route Starts **********/

            Route::get('global-change-control', [GlobalChangeControlController::class, 'create'])->name('global-change-control');
            Route::post('global-cc-store', [GlobalChangeControlController::class, 'store'])->name('global-cc-store');
            Route::get('global-cc-edit/{id}', [GlobalChangeControlController::class, 'show'])->name('global-cc-edit');
            Route::any('global-cc-update/{id}', [GlobalChangeControlController::class, 'update'])->name('global-cc-update');
            Route::get('global-cc-audit-trail/{id}', [GlobalChangeControlController::class, 'auditTrial'])->name('global-cc-audit-trail');
            Route::get('global-cc-audit-report/{id}', [GlobalChangeControlController::class, 'audit_pdf'])->name('global-cc-audit-report');
            Route::get('global-cc-single-report/{id}', [GlobalChangeControlController::class, 'single_pdf'])->name('global-cc-single-report');
            Route::get('global-cc-single-pdf/{id}', [GlobalChangeControlController::class, 'singleReportShow'])->name('global-cc-single-pdf');
            Route::get('global-cc-family-report/{id}', [GlobalChangeControlController::class, 'familyReport'])->name('global-cc-family-report');

            Route::post('send-stage/{id}', [GlobalChangeControlController::class, 'stageChange'])->name('send-stage');
            Route::post('closed-rejected/{id}', [GlobalChangeControlController::class, 'reject'])->name('closed-rejected');
            Route::post('stage-reject/{id}', [GlobalChangeControlController::class, 'stagereject'])->name('stage-reject');
            Route::post('qa-cqa-head-approval/{id}', [GlobalChangeControlController::class, 'sentToQAHeadApproval'])->name('qa-cqa-head-approval');
            Route::post('post-implementation/{id}', [GlobalChangeControlController::class, 'sentoPostImplementation'])->name('post-implementation');
            Route::post('sendTo-hod/{id}', [GlobalChangeControlController::class, 'sendToHod'])->name('sendTo-hod');
            Route::post('sendTo-initiator/{id}', [GlobalChangeControlController::class, 'sendToInitiator'])->name('sendTo-initiator');
            Route::post('sendTo-qaInitial/{id}', [GlobalChangeControlController::class, 'sendToInitialQA'])->name('sendTo-qaInitial');
            Route::post('closed-cancelled/{id}', [GlobalChangeControlController::class, 'stagecancel'])->name('closed-cancelled');

            /********** Global CC Route Ends **********/


            Route::post('create', [AuditProgramController::class, 'create'])->name('createAuditProgram');
            Route::get('AuditProgramShow/{id}', [AuditProgramController::class, 'AuditProgramShow'])->name('ShowAuditProgram');
            Route::post('AuditStateChange/{id}', [AuditProgramController::class, 'AuditStateChange'])->name('StateChangeAuditProgram');
            Route::post('AuditRejectStateChange/{id}', [AuditProgramController::class, 'AuditRejectStateChange'])->name('AuditProgramStateRecject');
            Route::post('UpdateAuditProgram/{id}', [AuditProgramController::class, 'UpdateAuditProgram'])->name('AuditProgramUpdate');
            Route::get('AuditProgramTrialShow/{id}', [AuditProgramController::class, 'AuditProgramTrialShow'])->name('showAuditProgramTrial');
            Route::get('auditProgramDetails/{id}', [AuditProgramController::class, 'auditProgramDetails'])->name('auditProgramAuditTrialDetails');
            Route::post('child_audit_program/{id}', [AuditProgramController::class, 'child_audit_program'])->name('auditProgramChild');
            Route::post('AuditProgramCancel/{id}', [AuditProgramController::class, 'AuditProgramCancel'])->name('AuditProgramCancel');
            Route::get('auditProgramSingleReport/{id}', [AuditProgramController::class, 'singleReport'])->name('auditProgramSingleReport');
            Route::get('auditProgramAuditReport/{id}', [AuditProgramController::class, 'auditReport'])->name('auditProgramAuditReport');
            Route::get('activitylogPrintdata/{id}', [AuditProgramController::class, 'activityprint'])->name('activitylogPrintdata');
            Route::get('faimilyReport/{id}', [AuditProgramController::class, 'faimilyReport'])->name('faimilyReport');

           
            Route::get('print-histories/{id}', [PrintRequestController::class, 'printHistories'])->name('print-histories');
            Route::get('/rcms/export-csvauditprogram', [AuditProgramController::class, 'auditprogram_exportCsv'])->name('export.auditprogram.csv');
            Route::get('/rcms/export-excelauditprogram', [AuditProgramController::class, 'auditprogram_exportExcel'])->name('export.auditprogram.excel');
            //new route for download print histories   
            Route::get('download-histories/{id}', [PrintRequestController::class, 'downloadHistories'])->name('download-histories');

                       

            Route::get('observationshow/{id}', [ObservationController::class, 'observationshow'])->name('showobservation');
            Route::post('observationstore', [ObservationController::class, 'observationstore'])->name('observationstore');
            Route::post('observationupdate/{id}', [ObservationController::class, 'observationupdate'])->name('observationupdate');
            Route::post('observation_send_stage/{id}', [ObservationController::class, 'observation_send_stage'])->name('observation_change_stage');
            Route::post('RejectStateChange/{id}', [ObservationController::class, 'RejectStateChange'])->name('RejectStateChangeObservation');
            Route::post('observation_child/{id}', [ObservationController::class, 'observation_child'])->name('observationchild');
            Route::post('boostStage/{id}', [ObservationController::class, 'boostStage'])->name('updatestageobservation');
            Route::get('Observation_AuditTrial_Show/{id}', [ObservationController::class, 'ObservationAuditTrialShow'])->name('ShowObservationAuditTrial');
            Route::get('ObservationAuditTrialDetails/{id}', [ObservationController::class, 'ObservationAuditTrialDetails'])->name('showaudittrialobservation');
            Route::get('ObservationSingleReport/{id}', [ObservationController::class, 'ObservationSingleReport']);
            Route::get('ObservationAuditTrialShow/{id}', [ObservationController::class, 'ObservationAuditTrailPdf'])->name('Observationaudit.pdf');
            Route::post('observation_cancel-model/{id}', [ObservationController::class, 'ObservationCancel'])->name('observation_cancel-model');
            Route::post('observation_child/{id}', [ObservationController::class, 'observation_child'])->name('observation_child');
            Route::post('observation_capanot_stage/{id}', [ObservationController::class, 'CapanotStage'])->name('observation_capanot_stage');


            //----------------------------------------------By PRIYA SHRIVASTAVA------------------
            Route::post('formDivision', [FormDivisionController::class, 'formDivision'])->name('formDivision');
            Route::get('ExternalAuditSingleReport/{id}', [AuditeeController::class, 'singleReport'])->name('ExternalAuditSingleReport');
            Route::get('Eaudit_showpfd/{id}', [AuditeeController::class, 'singleReportShow'])->name('Eaudit_showpfd');
            Route::get('ParentReportshowpdf/{id}', [AuditeeController::class, 'ParentReportshow'])->name('ParentReportshowpdf');
            Route::get('activitylogPrint/{id}', [AuditeeController::class, 'activitylogPrint'])->name('activitylogPrint');




            Route::get('ExternalAuditTrialReport/{id}', [AuditeeController::class, 'auditReport'])->name('ExternalAuditTrialReport');
            Route::get('capaSingleReport/{id}', [CapaController::class, 'singleReport'])->name('capaSingleReport');
            Route::get('capa_showpdf/{id}', [CapaController::class, 'singleReportShow'])->name('capa_showpdf');

            //============================global capa======================
            Route::get('capaSingleReport/{id}', [GlobalCapaController::class, 'singleReport'])->name('capaSingleReport');
            Route::get('capa_showpdf/{id}', [GlobalCapaController::class, 'singleReport'])->name('capa_showpdf');
            Route::get('globalcapaAuditReport/{id}', [GlobalCapaController::class, 'auditReport'])->name('globalcapaAuditReport');
            Route::get('globalcapaFamilyReport/{id}', [GlobalCapaController::class, 'familyReport'])->name('globalcapaFamilyReport');

            //==========================================

            Route::get('capaAuditReport/{id}', [CapaController::class, 'auditReport'])->name('capaAuditReport');
            Route::get('capaFamilyReport/{id}', [CapaController::class, 'familyReport'])->name('capaFamilyReport');


            Route::get('riskSingleReport/{id}', [RiskManagementController::class, 'singleReport'])->name('riskSingleReport');
            Route::get('RA_showpdf/{id}', [RiskManagementController::class, 'singleReportShow'])->name('RA_showpdf');
            Route::get('riskAuditReport/{id}', [RiskManagementController::class, 'auditReport'])->name('riskAuditReport');

            Route::get('riskActivityPdf/{id}', [RiskManagementController::class, 'RiskActivityPdf'])->name('riskActivityPdf');

            //Risk Family Report Route
            Route::get('riskFamilyReport/{id}', [RiskManagementController::class, 'RiskfamilyReport'])->name('riskFamilyReport');

            Route::get('rootSingleReport/{id}', [RootCauseController::class, 'singleReport'])->name('rootSingleReport');
            Route::get('rca_showpdf/{id}', [RootCauseController::class, 'singleReportShow'])->name('rca_showpdf');

            Route::get('rootAuditReport/{id}', [RootCauseController::class, 'auditReport'])->name('rootAuditReport');

            Route::get('rootActivityPdf/{id}', [RootCauseController::class, 'RootActivityPdf'])->name('rootActivityPdf');


            Route::get('rootFamilyReport/{id}', [RootCauseController::class, 'familyReport'])->name('rootFamilyReport');



            // Logs Export CSV AND EXCEL Route

            Route::get('/rca/export-csv', [RootCauseController::class, 'exportCsv'])->name('export.csv.rca');
            Route::get('/rca/export-excel', [RootCauseController::class, 'exportExcel'])->name('export.excel.rca');

            Route::get('managementReview/{id}', [ManagementReviewController::class, 'managementReport'])->name('managementReport');
            Route::get('managementReviewReport/{id}', [ManagementReviewController::class, 'managementReviewReport'])->name('managementReviewReport');
            Route::post('child_management_Review/{id}', [ManagementReviewController::class, 'child_management_Review'])->name('childmanagementReview');
            Route::get('internalSingleReport/{id}', [InternalauditController::class, 'singleReport'])->name('internalSingleReport');
            Route::get('IAshow_pdf/{id}', [InternalauditController::class, 'singleReportShow'])->name('IAshow_pdf');

            Route::get('internalauditReport/{id}', [InternalauditController::class, 'auditReport'])->name('internalauditReport');
            // Route::get('oos_micro/audit_report/{id}', [OOSMicroController::class, 'auditReport'])->name('audit_report');
            // Route::get('oos_micro/single_report/{id}', [OOSMicroController::class, 'singleReport'])->name('oos_micro/single_report');

            Route::post('errata/stages/{id}',[ErrataController::class, 'stageChange'])->name('errata.stage');
            Route::post('errata/stagesreject/{id}',[ErrataController::class, 'stageReject'])->name('errata.stagereject');
            Route::get('errata_audit/{id}', [ErrataController::class, 'auditTrailPdf'])->name('errataaudit.pdf');
            Route::get('errata_single_pdf/{id}',[ErrataController::class, 'singleReports']);


            /********************* Deviation Routes Starts *******************/

            Route::get('deviation', [DeviationController::class, 'deviation'])->name('deviation');
            Route::get('DeviationAuditTrialPdf/{id}', [DeviationController::class, 'deviationAuditTrailPdf']);
            Route::post('deviationstore', [DeviationController::class, 'store'])->name('deviationstore');
            Route::get('devshow/{id}', [DeviationController::class, 'devshow'])->name('devshow');
            Route::post('deviationupdate/{id}', [DeviationController::class, 'update'])->name('deviationupdate');
            Route::post('deviation/reject/{id}', [DeviationController::class, 'deviation_reject'])->name('deviation_reject');
            Route::post('deviation/cancel/{id}', [DeviationController::class, 'deviationCancel'])->name('deviationCancel');
            Route::post('deviation/cftnotrequired/{id}', [DeviationController::class, 'deviationIsCFTRequired'])->name('deviationIsCFTRequired');
            Route::post('deviation/check/{id}', [DeviationController::class, 'check'])->name('check');
            Route::post('deviation/check2/{id}', [DeviationController::class, 'check2'])->name('check2');
            Route::post('deviation/check3/{id}', [DeviationController::class, 'check3'])->name('check3');
            Route::post('deviation/pending_initiator_update/{id}', [DeviationController::class, 'pending_initiator_update'])->name('pending_initiator_update');
            Route::post('deviation/stage/{id}', [DeviationController::class, 'deviation_send_stage'])->name('deviation_send_stage');
            Route::post('deviation/cftnotreqired/{id}', [DeviationController::class, 'cftnotreqired'])->name('cftnotreqired');
            Route::post('deviation/Qa/{id}', [DeviationController::class, 'deviation_qa_more_info'])->name('deviation_qa_more_info');
            Route::get('deviationSingleReport/{id}', [DeviationController::class, 'singleReport'])->name('deviationSingleReport');
            Route::get('deviation_showpdf/{id}', [DeviationController::class, 'singleReportShow'])->name('deviation_showpdf');

            Route::get('activityLog/{id}', [DeviationController::class, 'activityLog'])->name('deviation_activityLog');


            Route::get('deviationFamilyReport/{id}', [DeviationController::class, 'familyReport'])->name('deviationFamilyReport');

            Route::post('dev-launch-extension-deviation/{id}', [DeviationController::class, 'launchExtensionDeviation'])->name('dev-launch-extension-deviation');
            Route::post('dev-launch-extension-capa/{id}', [DeviationController::class, 'launchExtensionCapa'])->name('dev-launch-extension-capa');
            Route::post('dev-launch-extension-qrm/{id}', [DeviationController::class, 'launchExtensionQrm'])->name('dev-launch-extension-qrm');
            Route::post('dev-launch-extension-investigation/{id}', [DeviationController::class, 'launchExtensionInvestigation'])->name('dev-launch-extension-investigation');

            /********************* Deviation Routes Ends *******************/


            /********************* Non Conformance Routes Starts *******************/

            Route::get('non-conformance', [NonConformaceController::class, 'index']);
            Route::post('nonConformaceStore', [NonConformaceController::class, 'store'])->name('nonConformaceStore');
            Route::get('non-conformance-show/{id}', [NonConformaceController::class, 'show'])->name('non-conformance-show');
            Route::post('non-conformance-update/{id}', [NonConformaceController::class, 'update'])->name('non-conformance-update');
            Route::post('non_conformance_reject/{id}', [NonConformaceController::class, 'nonConformaceReject'])->name('non_conformance_reject');
            Route::post('nonConformaceCancel/{id}', [NonConformaceController::class, 'nonConformaceCancel'])->name('nonConformaceCancel');
            Route::post('nonConformaceIsCFTRequired/{id}', [NonConformaceController::class, 'nonConformaceCftNotrequired'])->name('nonConformaceIsCFTRequired');
            Route::post('nonConformaceCheck/{id}', [NonConformaceController::class, 'nonConformaceCheck'])->name('nonConformaceCheck');
            Route::post('nonConformaceCheck2/{id}', [NonConformaceController::class, 'nonConformaceCheck2'])->name('nonConformaceCheck2');
            Route::post('nonConformaceCheck3/{id}', [NonConformaceController::class, 'nonConformaceCheck3'])->name('nonConformaceCheck3');
            Route::post('nonConformaceStageChange/{id}', [NonConformaceController::class, 'non_conformance_send_stage'])->name('nonConformaceStageChange');
            Route::post('nonConformaceCftnotreqired/{id}', [NonConformaceController::class, 'cftnotreqired'])->name('nonConformaceCftnotreqired');
            Route::post('nonConformaceQaMoreInfo/{id}', [NonConformaceController::class, 'failure_inv_qa_more_info'])->name('nonConformaceQaMoreInfo');

            Route::get('non-conformance-audit-trail/{id}', [NonConformaceController::class, 'NonConformaceAuditTrail'])->name('non-conformance-audit-trail');
            Route::get('non-conformance-audit-pdf/{id}', [NonConformaceController::class, 'NonConformaceAuditTrailPdf'])->name('non-conformance-audit-pdf');
            Route::get('non-conformance-single-report/{id}', [NonConformaceController::class, 'singleReport'])->name('non-conformance-single-report');

            Route::post('launch-extension-non-conformance/{id}', [NonConformaceController::class, 'launchExtensionDeviation'])->name('launch-extension-non-conformance');
            Route::post('launch-extension-capa/{id}', [NonConformaceController::class, 'launchExtensionCapa'])->name('launch-extension-capa');
            Route::post('launch-extension-qrm/{id}', [NonConformaceController::class, 'launchExtensionQrm'])->name('launch-extension-qrm');
            Route::post('launch-extension-investigation/{id}', [NonConformaceController::class, 'launchExtensionInvestigation'])->name('launch-extension-investigation');

            /********************* Non Conformance Routes Ends *******************/

            /********************* Fallure Investigation Routes Starts *******************/

            Route::get('failure-investigation', [FailureInvestigationController::class, 'index']);
            Route::post('failureInvestigationStore', [FailureInvestigationController::class, 'store'])->name('failureInvestigationStore');
            Route::get('failure-investigation-show/{id}', [FailureInvestigationController::class, 'show'])->name('failure-investigation-show');
            Route::post('failure-investigation-update/{id}', [FailureInvestigationController::class, 'update'])->name('failure-investigation-update');
            Route::post('failure_investigation_reject/{id}', [FailureInvestigationController::class, 'failureInvestigationReject'])->name('failure_investigation_reject');
            Route::post('failureInvestigationCancel/{id}', [FailureInvestigationController::class, 'failureInvestigationCancel'])->name('failureInvestigationCancel');
            Route::post('failureInvestigationIsCFTRequired/{id}', [FailureInvestigationController::class, 'failureInvestigationCftNotrequired'])->name('failureInvestigationIsCFTRequired');
            Route::post('failureInvestigationCheck/{id}', [FailureInvestigationController::class, 'failureInvestigationCheck'])->name('failureInvestigationCheck');
            Route::post('failureInvestigationCheck2/{id}', [FailureInvestigationController::class, 'failureInvestigationCheck2'])->name('failureInvestigationCheck2');
            Route::post('failureInvestigationCheck3/{id}', [FailureInvestigationController::class, 'failureInvestigationCheck3'])->name('failureInvestigationCheck3');
            Route::post('failureInvestigationStageChange/{id}', [FailureInvestigationController::class, 'failure_investigation_send_stage'])->name('failureInvestigationStageChange');
            Route::post('failureInvestigationCftnotreqired/{id}', [FailureInvestigationController::class, 'cftnotreqired'])->name('failureInvestigationCftnotreqired');
            Route::post('failureInvestigationQaMoreInfo/{id}', [FailureInvestigationController::class, 'failure_inv_qa_more_info'])->name('failureInvestigationQaMoreInfo');

            Route::get('failure-investigation-audit-trail/{id}', [FailureInvestigationController::class, 'failureInvestigationAuditTrail'])->name('failure-investigation-audit-trail');
            Route::get('failure-investigation-audit-pdf/{id}', [FailureInvestigationController::class, 'failureInvestigationAuditTrailPdf'])->name('failure-investigation-audit-pdf');
            Route::get('failure-investigation-single-report/{id}', [FailureInvestigationController::class, 'singleReport'])->name('failure-investigation-single-report');

            Route::post('launch-extension-failure-investigation/{id}', [FailureInvestigationController::class, 'launchExtensionDeviation'])->name('launch-extension-failure-investigation');
            Route::post('launch-extension-capa/{id}', [FailureInvestigationController::class, 'launchExtensionCapa'])->name('launch-extension-capa');
            Route::post('launch-extension-qrm/{id}', [FailureInvestigationController::class, 'launchExtensionQrm'])->name('launch-extension-qrm');
            Route::post('launch-extension-investigation/{id}', [FailureInvestigationController::class, 'launchExtensionInvestigation'])->name('launch-extension-investigation');

            /********************* Fallure Investigation Routes Ends *******************/

            // =====================extesnion new report and audit trail ===============
            Route::get('singleReportNew/{id}', [ExtensionNewController::class, 'singleReport'])->name('singleReportNew');
            Route::get('showpdf/{id}', [ExtensionNewController::class, 'singleReportShow'])->name('showpdf');
            Route::get('extensionFamilyreport/{id}', [ExtensionNewController::class, 'extensionFamilyReport'])->name('extensionFamilyreport');
            Route::get('extensionactivityreport/{id}', [ExtensionNewController::class, 'activitylogReport'])->name('activitylogreport');


            Route::get('audit_trailNew/{id}', [ExtensionNewController::class, 'extensionNewAuditTrail']);
            Route::get('extensionAuditReport/{id}', [ExtensionNewController::class, 'auditReport'])->name('extensionAuditReport');
            Route::get('preventiveMaintenance_show/{id}', [PreventiveMaintenanceController::class, 'preventiveMaintenance_show'])->name('preventiveMaintenance_show');
            //----------------------------------- OOT ----------------------------------//

            Route::get('oot/', [OOTController::class, 'index']);
            Route::post('oot/create', [OOTController::class, 'store'])->name('oot.store');
            Route::get('oot_view/{id}', [OOTController::class,'ootShow'])->name('rcms/oot_view');
            Route::post('oot/update/{id}',[OOTController::class, 'update'])->name('update');
            // Route::get('oot_audit/{id}',[OOTController::class,'OotAuditTrial']);
            Route::post('oot/stage/{id}',[OOTController::class,'oot_send_stage'])->name('ootStage');
            Route::get('oot_audit_history/{id}', [OOTController::class, 'OotAuditTrial']);
            Route::get('rcms/auditdetails/{id}', [OOTController::class, 'OotAuditDetail'])->name('auditdetails');
            Route::get('ootcSingleReport/{id}', [OOTController::class, 'singleReport']);
            Route::post('sendstage/{id}',[OOTController::class,'oot_send_stage']);
            Route::post('cancel/{id}', [OOTController::class, 'ootCancel']);
            Route::post('thirdStage/{id}', [OOTController::class, 'stageChange']);
            Route::post('reject/{id}', [OOTController::class, 'oot_reject']);
            Route::get('audit_pdf/{id}',[OOTController::class,'auditTiailPdf']);


            Route::get('OOCSingleReport/{id}',[OOCController::class, 'singleReports']);








            /**
             * OOT
             */
            Route::group(['prefix' => 'oot', 'as' => 'oot.'], function() {
                Route::get('/', [OOTController::class, 'index'])->name('index');
                Route::post('/ootstore', [OOTController::class, 'store'])->name('ootstore');
            });

            /**
             * OOS
             */
            Route::group(['prefix' => 'oos', 'as' => 'oos.'], function() {
                Route::get('/',[OOSController::class, 'index'])->name('index');
                Route::post('/oosstore', [OOSController::class, 'store'])->name('oosstore');
                Route::get('oos_view/{id}', [OOSController::class, 'show'])->name('oos_view');
                Route::post('oosupdate/{id}', [OOSController::class, 'update'])->name('oosupdate');
    
                Route::post('sendstage/{id}',[OOSController::class,'send_stage'])->name('send_stage');
                Route::post('requestmoreinfo_back_stage/{id}',[OOSController::class,'requestmoreinfo_back_stage'])->name('requestmoreinfo_back_stage');
                Route::post('assignable_send_stage/{id}',[OOSController::class,'assignable_send_stage'])->name('assignable_send_stage');
                Route::post('cancel_stage/{id}', [OOSController::class, 'cancel_stage'])->name('cancel_stage');
                Route::post('thirdStage/{id}', [OOSController::class, 'stageChange'])->name('thirdStage');
                Route::post('reject_stage/{id}', [OOSController::class, 'reject_stage'])->name('reject_stage');
                Route::post('capa_child/{id}', [CapaController::class, 'child_change_control'])->name('capa_child_changecontrol');
                
                Route::get('AuditTrial/{id}', [OOSController::class, 'AuditTrial'])->name('audit_trial');
                Route::get('auditDetails/{id}', [OOSController::class, 'auditDetails'])->name('audit_details');
                Route::get('audit_report/{id}', [OOSController::class, 'auditReport'])->name('audit_report');
                Route::get('single_report/{id}', [OOSController::class, 'singleReport'])->name('single_report');
    
            });

            /** 
             * oos micro
             */

            Route::group(['prefix' => 'oos_micro', 'as' => 'oos_micro.'], function() {

                    Route::get('/', [OOSMicroController::class, 'index'])->name('index');
                    Route::post('/store', [OOSMicroController::class, 'store'])->name('store');
                    Route::get('edit/{id}',[OOSMicroController::class, 'edit'])->name('edit');
                    Route::post('update/{id}',[OOSMicroController::class, 'update'])->name('update');
                    Route::post('sendstage/{id}',[OOSMicroController::class,'send_stage'])->name('send_stage');
                    Route::post('requestmoreinfo_back_stage/{id}',[OOSMicroController::class,'requestmoreinfo_back_stage'])->name('requestmoreinfo_back_stage');
                    Route::post('child/{id}', [OOSMicroController::class, 'child'])->name('child');
                    Route::post('assignable_send_stage/{id}',[OOSMicroController::class,'assignable_send_stage'])->name('assignable_send_stage');
                    Route::post('cancel_stage/{id}', [OOSMicroController::class, 'cancel_stage'])->name('cancel_stage');;
                    Route::post('thirdStage/{id}', [OOSMicroController::class, 'stageChange'])->name('thirdStage');
                    Route::post('reject_stage/{id}', [OOSMicroController::class, 'reject_stage'])->name('reject_stage');
                    
                    Route::get('AuditTrial/{id}', [OOSMicroController::class, 'AuditTrial'])->name('audit_trial');
                    Route::get('auditDetails/{id}', [OOSMicroController::class, 'auditDetails'])->name('audit_details');
                    Route::get('audit_report/{id}', [OOSMicroController::class, 'auditReport'])->name('audit_report');
                    Route::get('single_report/{id}', [OOSMicroController::class, 'singleReport'])->name('single_report');
                    
            });

            /**
             * market coplaint
             */
            Route::group(['prefix' => 'marketcomplaint', 'as' => 'marketcomplaint.'], function() {
                Route::get('/market_complaint_new',[MarketComplaintController::class, 'index'])->name('market_complaint_new');
                Route::post('/marketcomplaint/store', [MarketComplaintController::class, 'store'])->name('mcstore');
                Route::get('/marketcomplaint_view/{id}', [MarketComplaintController::class, 'show'])->name('marketcomplaint_view');
                Route::put('/marketcomplaintupdate/{id}', [MarketComplaintController::class, 'update'])->name('marketcomplaintupdate');
                Route::post('mar_comp_stagechange/{id}',[MarketComplaintController::class,'marketComplaintStateChange'])->name('mar_comp_stagechange');
                Route::post('mar_comp_reject_stateChange/{id}', [MarketComplaintController::class, 'marketComplaintRejectState'])->name('mar_comp_reject_stateChange');
                Route::post('MarketComplaintCancel/{id}', [MarketComplaintController::class, 'MarketComplaintCancel'])->name('MarketComplaintCancel');          

                Route::get('auditDetailsMarket/{id}', [MarketComplaintController::class, 'auditDetailsMarket'])->name('marketauditDetails');

                Route::get('MarketComplaintAuditReport/{id}', [MarketComplaintController::class, 'MarketAuditTrial'])->name('MarketComplaintAuditReport');
                Route::get('MarketAuditReport/{id}', [MarketComplaintController::class, 'auditReport'])->name('marketAuditReport');
                Route::get('marketauditTrailPdf/{id}', [MarketComplaintController::class, 'auditTrailPdf'])->name('marketauditTrailPdf');
            Route::post('MarketComplaintC_AChild/{id}', [MarketComplaintController::class, 'MarketComplaintCapa_ActionChild'])->name('capa_action_child');
            Route::post('MarketComplaintRCA_ActionChild/{id}', [MarketComplaintController::class, 'MarketComplaintRca_actionChild'])->name('rca_action_child');
            Route::post('MarketComplaintRegul_Effec_Child/{id}', [MarketComplaintController::class, 'MarketComplaintRegu_Effec_Child'])->name('Regu_Effec_child');
            Route::get('acknoledgment_report/{id}',[MarketComplaintController::class,'AcknoledgmentReport'])->name('acknoledgment_report');

            });
            Route::get('complaintManagementactivityLog/{id}', [MarketComplaintController::class, 'complaintManagementactivityLog'])->name('complaintManagementactivityLog');
            Route::get('mk_family_report/{id}', [MarketComplaintController::class, 'marketComplaintFamilyReport'])->name('mk_family_report');

            Route::get('pdf-report/{id}', [MarketComplaintController::class, 'singleReport'])->name('pdf-report');
            Route::get('Mk_showpdf/{id}', [MarketComplaintController::class, 'singleReportShow'])->name('Mk_showpdf');
            Route::post('MarketCAuditTrial/{id}', [MarketComplaintController::class, 'store_audit_review_mc'])->name('store_audit_review_mc');

            // Regulatory inspection==================
            Route::view('Compliance_dashboard', 'frontend.rcms.Compliance_dashboard');
            Route::view('gmp_inspection_databases', 'frontend.rcms.gmp_inspection_databases');

            Route::get('regulatory_dashboard', [RegulatoryDashboardController::class, 'index'])->name('regulatory_dashboard');    

            /********************* Incident Routes Starts *******************/

            Route::get('incident', [IncidentController::class, 'index'])->name('incident');    
            Route::post('incident-store', [IncidentController::class, 'store'])->name('incident-store');
            Route::get('incident-show/{id}', [IncidentController::class, 'incidentShow'])->name('incident-show');
            Route::post('incident-update/{id}', [IncidentController::class, 'update'])->name('incident-update');
            Route::post('incident-reject/{id}', [IncidentController::class, 'incidentReject'])->name('incident-reject');
            Route::post('incident-cancel/{id}', [IncidentController::class, 'incidentCancel'])->name('incident-cancel');
            Route::post('incidentIsCFTRequired/{id}', [IncidentController::class, 'incidentIsCFTRequired'])->name('incidentIsCFTRequired');
            Route::post('incidentCheck/{id}', [IncidentController::class, 'incidentCheck'])->name('incidentCheck');
            Route::post('incidentCheck2/{id}', [IncidentController::class, 'incidentCheck2'])->name('incidentCheck2');
            Route::post('incidentCheck3/{id}', [IncidentController::class, 'incidentCheck3'])->name('incidentCheck3');
            Route::post('new_incident_stage/{id}', [IncidentController::class, 'new_incident_stage'])->name('new_incident_stage');
            Route::post('incidentStageChange/{id}', [IncidentController::class, 'incident_send_stage'])->name('incidentStageChange');
            Route::post('incidentCftnotreqired/{id}', [IncidentController::class, 'cftnotreqired'])->name('incidentCftnotreqired');
            Route::post('incidentQaMoreInfo/{id}', [IncidentController::class, 'incident_qa_more_info'])->name('incidentQaMoreInfo');

            Route::get('incident-audit-trail/{id}', [IncidentController::class, 'incidentAuditTrail'])->name('incident-audit-trail');
            Route::get('incident-audit-pdf/{id}', [IncidentController::class, 'incidentAuditTrailPdf'])->name('incident-audit-pdf');
            Route::get('incident-single-report/{id}', [IncidentController::class, 'singleReport'])->name('incident-single-report');
            Route::get('incident_showpdf/{id}', [IncidentController::class, 'singleReportShow'])->name('incident_showpdf');

            Route::post('launch-extension-incident/{id}', [IncidentController::class, 'launchExtensionIncident'])->name('launch-extension-incident');
            Route::post('launch-extension-capa/{id}', [IncidentController::class, 'launchExtensionCapa'])->name('launch-extension-capa');
            Route::post('launch-extension-qrm/{id}', [IncidentController::class, 'launchExtensionQrm'])->name('launch-extension-qrm');
            Route::post('launch-extension-investigation/{id}', [IncidentController::class, 'launchExtensionInvestigation'])->name('launch-extension-investigation');

             /******************* Meeting Route Starts ******************/            
             Route::get('meetings', [MeetingController::class, 'index'])->name('meetings');    
             Route::post('meetings-store', [MeetingController::class, 'store'])->name('meetings-store');
             Route::get('meeting-show/{id}', [MeetingController::class, 'show'])->name('meeting-show');
             Route::post('meeting-update/{id}', [MeetingController::class, 'update'])->name('meeting-update');
             Route::post('meeting_stage_change/{id}',[MeetingController::class,'meetingStateChange'])->name('meeting_stage_change');
             Route::get('meeting-audit-trial/{id}', [MeetingController::class, 'MeetingAuditTrial'])->name('meeting-audit-trial');
             Route::get('single_report/{id}', [MeetingController::class, 'singleReport'])->name('single_report');

             // Route::post('mar_comp_reject_stateChange/{id}', [MarketComplaintController::class, 'marketComplaintRejectState'])->name('mar_comp_reject_stateChange');
             /******************* Meeting Route Ends ******************/

             // meeting dashboard controller ========================
             Route::get('meeting-management', [MeetingManagementController::class, 'index'])->name('meeting-management');  
             Route::get('ccViewMeeting/{id}/{type}', [MeetingManagementController::class, 'ccViewMeeting'])->name('ccViewMeeting');

            /********************* Incident Routes Ends *******************/

             /*********** Supplier Routes ************/
             Route::get('supplier', [SupplierController::class, 'index']);
             Route::post('supplier-store', [SupplierController::class, 'store'])->name('supplier-store');
             Route::get('supplier-show/{id}', [SupplierController::class, 'show']);
             Route::post('supplier-update/{id}', [SupplierController::class, 'update'])->name('supplier-update');
             Route::get('supplier-single-report/show/{id}', [SupplierController::class, 'singleReportShow'])->name('supplier.single.report.show');
             Route::get('supplier-single-report/{id}', [SupplierController::class, 'singleReport'])->name('supplierReport');

             Route::get('supplier_family_report/{id}', [SupplierController::class, 'supplierFamilyReport'])->name('supplier_family_report');
             Route::get('supplierActivityLog/{id}', [SupplierController::class, 'supplierActivityLog'])->name('supplierActivityLog');


             Route::get('supplier-audit-trail/{id}', [SupplierController::class, 'auditTrail']);
             Route::get('supplier-audit-trail-pdf/{id}', [SupplierController::class, 'auditTrailPdf']);
             Route::post('supplier-send-stage/{id}', [SupplierController::class, 'supplierSendStage'])->name('supplier-send-stage');
             Route::post('sendTo-supplier-approved/{id}', [SupplierController::class, 'sendToSupplierApproved'])->name('sendTo-supplier-approved');
             Route::post('supplier-close-cancelled/{id}', [SupplierController::class, 'cancelDocument'])->name('supplier-close-cancelled');
             Route::post('supplier-approved-to-obselete/{id}', [SupplierController::class, 'supplierApprovedToObselete'])->name('supplier-approved-to-obselete');
             Route::post('sendToPendingSupplierAudit/{id}', [SupplierController::class, 'sendToPendingSupplierAudit'])->name('sendToPendingSupplierAudit');
             Route::post('supplier_child/{id}', [SupplierController::class, 'supplier_child'])->name('supplier_child_1');            
             Route::post('supplierstore_audit_review/{id}', [SupplierController::class, 'store_audit_review'])->name('supplierstore_audit_review');
             Route::post('approvedBy-contract-giver/{id}', [SupplierController::class, 'approvedByContractGiver'])->name('approvedBy-contract-giver');
             Route::post('link-manufacturer/{id}', [SupplierController::class, 'linkManufacturerToApprovedManufacturer'])->name('link-manufacturer');
             Route::post('pending-manufacturer-audit-more-info/{id}', [SupplierController::class, 'pendingManufacturerAuditMoreInfo'])->name('pending-manufacturer-audit-more-info');
             Route::get('notification-detail/{slug}/{id}', [SupplierController::class, 'notificationDetail'])->name('notification-detail');
 
             Route::post('supplier-reject-stage/{id}', [SupplierController::class, 'supplierStageReject'])->name('supplier-reject-stage');
             Route::post('sendTo-pendig-CQA/{id}', [SupplierController::class, 'sendToPendingCQAReview'])->name('sendTo-pendig-CQA');
             Route::post('manufacturer-reject/{id}', [SupplierController::class, 'manufacturerRejected'])->name('manufacturer-reject');
             Route::post('risk-rating-observed-low/{id}', [SupplierController::class, 'sendToApprovedManufacturerFromPendingManufacturer'])->name('risk-rating-observed-low');

             Route::get('export-csvsupplier', [SupplierController::class, 'supplier_exportcsv'])->name('export.supplier.csv');
             Route::get('export-excelsupplier', [SupplierController::class, 'supplier_exportExcel'])->name('export.supplier.excel');
            /********************* Supplier Routes Ends *******************/


            Route::get('supplierauditsingleReportshow/{id}', [SupplierAuditController::class, 'supplierAuditReportShow']);
                   //****************************************SupplierAudit Log**************************************** */
                   Route::get('export-csvsupplier', [SupplierAuditController::class, 'supplier_exportcsv'])->name('export.supplier.csv');
                   Route::get('export-excelsupplier', [SupplierAuditController::class, 'supplier_exportExcel'])->name('export.supplier.excel');

                        //*********************equipment information********************* */
                        Route::get('equipmentlifecycleSingleReport/{id}', [EquipmentLifecycleManagementController::class, 'equipmentInfoSingleReport'])->name('equipmentlifecycleSingleReport');
                        Route::get('equipmentlifecycleAuditReport/{id}', [EquipmentLifecycleManagementController::class, 'auditReport'])->name('equipmentlifecycleAuditReport');
                        Route::get('equipmentLifeFamilyreport/{id}', [EquipmentLifecycleManagementController::class, 'equipmentFamilyReport'])->name('equipmentlifeFamilyReport');

                  //*******************************Audit Program Log*************************************** */
                  Route::get('export-csvaudit', [AuditProgramController::class, 'csvaudit'])->name('export.csvaudit');
                  Route::get('export-excelaudit', [AuditProgramController::class, 'Excelaudit'])->name('export.Excelaudit');
                  //***********************************************Callibration Management  Log************************************************/
                  Route::get('export-csvcallibration', [CallibrationDetailsController::class, 'csvcallibration'])->name('export.csvcallibration');
                  Route::get('export-excelcallibration', [CallibrationDetailsController::class, 'Excelcallibration'])->name('export.Excelcallibration');
                //***********************************************Environment Sustainability LOG<************************************************/
                Route::get('export-csvehs', [EhsController::class, 'csvehs'])->name('export.csvehs');
                Route::get('export-excelehs', [EhsController::class, 'excelehs'])->name('export.excelehs');

                              
                //****************************************ControlSample Log******************************************/
                Route::get('export-csvsample', [ControlSampleController::class, 'sample_exportcsv'])->name('export.sample.csv');
                Route::get('export-excelsample', [ControlSampleController::class, 'sample_exportExcel'])->name('export.sample.excel');

                //****************************************NewDocument Log******************************************/
                Route::get('export-csvdocument', [DocumentController::class, 'newdocument_exportcsv'])->name('export.document.csv');
                Route::get('export-exceldocument', [DocumentController::class, 'document_exportExcel'])->name('export.document.excel');
                Route::post('launch-extension-investigation/{id}', [IncidentController::class, 'launchExtensionInvestigation'])->name('launch-extension-investigation');
                Route::post('send-qa-approval/{id}', [CCController::class, 'sentToQAHeadApproval'])->name('send-qa-approval');
                Route::post('send-reject/{id}', [CCController::class, 'reject'])->name('send-reject');
                Route::post('send-post-implementation/{id}', [CCController::class, 'sentoPostImplementation'])->name('send-post-implementation');
                Route::post('moreinfoState_actionitem/{id}', [ActionItemController::class, 'actionmoreinfo']);
                Route::post('LabIncidentStateCancel/{id}', [LabIncidentController::class, 'LabIncidentStateCancel'])->name('StageChangeLabcancel');
                Route::post('RejectStateChangeNew/{id}', [OOTController::class, 'RejectStateChangeNew'])->name('RejectStateChangeNew');
                Route::post('OOTChildRoot/{id}', [OOTController::class, 'OOTChildRoot'])->name('o_o_t_root_child');
                Route::post('oo_t_capa_child/{id}', [OOTController::class, 'oo_t_capa_child'])->name('oo_t_capa_child');
                Route::post('OOTChildExtensionOOT/{id}', [OOTController::class, 'OOTChildExtensionOOT'])->name('OOTChildExtensionOOT');
                Route::get('resamplingSingleReport/{id}', [ResamplingController::class, 'singleReport'])->name('resamplingSingleReport');
                Route::get('resamplingAuditReport/{id}', [ResamplingController::class, 'auditReport'])->name('resamplingAuditReport');
                Route::post('deviation/ReqCancel/{id}', [DeviationController::class, 'Request_Cancel'])->name('Request_Cancel');
                Route::get('SummaryResponseReport/{id}', [AuditeeController::class, 'SummaryResponseReport'])->name('SummaryResponseReport');
                Route::post('management/cftnotrequired/{id}', [ManagementReviewController::class, 'managementIsCFTRequired'])->name('managementIsCFTRequired');
                Route::post('Done_stage/{id}', [OOSController::class, 'Done_stage'])->name('Done_stage');
                Route::post('Done_One_stage/{id}', [OOSController::class, 'Done_One_stage'])->name('Done_One_stage');
                Route::post('Done_Two_stage/{id}', [OOSController::class, 'Done_Two_stage'])->name('Done_Two_stage');
                Route::get('capa', [CapaController::class, 'capa'])->name('capa');
                Route::post('child/{id}', [OOSController::class, 'child'])->name('child');
                Route::post('Done_stage/{id}', [OOSMicroController::class, 'Done_stage'])->name('Done_stage');
                Route::post('Done_One_stage/{id}', [OOSMicroController::class, 'Done_One_stage'])->name('Done_One_stage');
                Route::post('Done_Two_stage/{id}', [OOSMicroController::class, 'Done_Two_stage'])->name('Done_Two_stage');
                
        }
    );
});
