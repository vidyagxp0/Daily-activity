

<?php

use App\Http\Controllers\ActionItemController;
use App\Http\Controllers\Ajax\AjaxController;
use App\Http\Controllers\Api\KSIController;
use App\Http\Controllers\lims\InventoryManagementController;
use App\Http\Controllers\MyActivityController;
use App\Http\Controllers\rcms\MarketComplaintController;
use App\Http\Controllers\OpenStageController;
use App\Http\Controllers\PreventiveMaintenanceController;
use App\Http\Controllers\rcms\InternalauditController;
use App\Http\Controllers\rcms\RootCauseController;
use App\Http\Controllers\EquipmentLifecycleManagementController;
use App\Http\Controllers\lims\SamplingStabilityController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\TaskManagementController;
use App\Http\Controllers\TMSController;
use App\Http\Controllers\RegulatoryController;
use App\Http\Controllers\RiskManagementController;
use App\Http\Controllers\ChangeControlController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\DocumentDetailsController;
use App\Http\Controllers\rcms\DesktopController;
use App\Http\Controllers\LimsDashboardController;
use App\Http\Controllers\UserLoginController;
use App\Http\Controllers\EhsController;
use App\Http\Controllers\SanctionController;
use App\Http\Controllers\BlackListController;
use App\Http\Controllers\MytaskController;
use App\Http\Controllers\CabinateController;
use App\Http\Controllers\rcms\{CCController,DeviationController, IncidentController};
use App\Http\Controllers\rcms\EffectivenessCheckController;
use App\Http\Controllers\rcms\ObservationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocumentContentController;
use App\Http\Controllers\ErrataController;
use App\Http\Controllers\ExtensionNewController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\CriticalActionController;
use App\Http\Controllers\lims\ControlSampleController;
// use App\Http\Controllers\tms\JobTrainingController;
use App\Http\Controllers\InductionTrainingcontroller;
use App\Http\Controllers\OOSMicroController;
use App\Http\Controllers\rcms\AuditeeController;
use App\Http\Controllers\rcms\NonConformaceController;
use App\Http\Controllers\rcms\CapaController;
use App\Http\Controllers\rcms\GlobalCapaController;
use App\Http\Controllers\rcms\FailureInvestigationController;
use App\Http\Controllers\rcms\LabIncidentController;
use App\Http\Controllers\rcms\AuditProgramController;
use App\Http\Controllers\rcms\ExtensionController;
use App\Http\Controllers\rcms\ManagementReviewController;
use App\Http\Controllers\rcms\OOCController;
use App\Http\Controllers\rcms\OOSController;
use App\Http\Controllers\rcms\RcmsDashboardController;
use App\Http\Controllers\tms\EmployeeController;
// use App\Http\Controllers\tms\JobTrainingController;
use App\Http\Controllers\CallibrationDetailsController;

use App\Http\Controllers\tms\QuestionBankController;
use App\Http\Controllers\tms\QuestionController;
use App\Http\Controllers\tms\QuizeController;
use App\Http\Controllers\rcms\OOTController;
use App\Http\Controllers\SupplierAuditController;

use App\Http\Controllers\tms\TrainerController;
use App\Imports\DocumentsImport;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\tms\JobTrainingController;
use App\Http\Controllers\VidyaGxPAcademyController;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\CC;
use App\Http\Controllers\tms\ClassroomTrainingController;
use App\Http\Controllers\TrainingMaterialManagementController;
use App\Http\Controllers\tms\TNIEmployeeController;
use App\Http\Controllers\DepartmentWiseController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\ResamplingController;
use App\Http\Controllers\JobDescriptionController;
use App\Http\Controllers\ScormController;
use App\Http\Controllers\AnalystController;
Use App\Http\Controllers\lims\AnalyticsController;
use App\Http\Controllers\YearlyTrainingPlannerController;
use App\Http\Controllers\tms\TNIController;
use App\Http\Controllers\CompanyController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//!---------------- EMP login  ---------------------------//
Route::group(['middleware' => ['auth:employee']], function () {
    // All employee authenticated routes here
    


    Route::get('/induction-training-chart', [TMSController::class, 'showInductionTrainingChart']);


    Route::resource('TMS', TMSController::class);
    Route::get('induction_training_certificate/{id}', [InductionTrainingController::class, 'showCertificate']);

    Route::get('documents/viewpdf/{id}', action: [DocumentController::class, 'viewPdf']);
    Route::get('classroom_training-details/{id}/{total_minimum_time}/{per_screen_running_time}/{job_training_id}/{sop_spent_time}', [ClassroomTrainingController::class, 'viewrendersop']);
    Route::get('sop_training_details/{id}/{total_minimum_time}/{per_screen_run_time}/{sop_training_id}/{sop_spent_time}', [TMSController::class, 'viewrendersop']);




    Route::get('/logout-employee', [UserLoginController::class, 'logoutEmployee'])->name('logout-employee');
    // Route::get('/tms-training', [TMSController::class, 'TMSTraining'])->name('tms.training');

    Route::get('/tms-training/{id?}', [TMSController::class, 'TMSTraining'])->name('tms.training');


    Route::get('induction_training-details/{id}/{total_minimum_time}/{per_screen_running_time}/{job_training_id}/{sop_spent_time}', [InductionTrainingController::class, 'viewrendersopinduction']);
    Route::get('department_wise_training-details/{id}/{total_minimum_time}/{per_screen_running_time}/{job_training_id}/{sop_spent_time}', [DepartmentWiseController::class, 'viewrendersopdepartment']);
    Route::post('save-otj-reading-time', [JobTrainingController::class, 'saveReadingTime']);
    Route::post('save-sop-reading-time', [DocumentController::class, 'saveReadingTime']);
    
    Route::post('save-classroom-reading-time', [ClassroomTrainingController::class, 'saveReadingTime']);
    Route::get('classroom_training_certificate/{id}', [ClassroomTrainingController::class, 'showCertificate']);
    Route::post('save-induction-reading-time', [InductionTrainingController::class, 'saveReadingTime']);
    Route::post('save-department-reading-time', [DepartmentWiseController::class, 'saveReadingTime']);
    Route::post('save-tni-matrix-reading-time', [TNIController::class, 'saveReadingTime']);
    Route::post('save-change-control-reading-time', [CCController::class, 'saveReadingTime']);
    Route::get('change-control-training-detail/{id}/{total_minimum_time}/{per_screen_running_time}/{job_training_id}/{sop_spent_time}', [CCController::class, 'viewrendersop']);
    Route::get('sop_question_training/{id}/{job_id}', [TMSController::class, 'questionshow']);
    Route::get('status-chart', [TMSController::class, 'showChart'])->name('status-chart');

    
    Route::get('training-graph', [TMSController::class, 'ShowInductionChart'])->name('inductionpiechart');
    Route::get('tnimatrixequestionshow/{id}/{tnim_id}', [TNIController::class, 'tnimatrixequestionshow']);
    Route::post('/check-answer-tni-matrix', [TNIController::class, 'checkAnswerTniMatrix'])->name('check_answer_tni_matrix');
    
});

//!---------------- EMP login  ---------------------------//
Route::get('/test-email', function () {
    $records = CC::where('status', '!=', 'Closed Done')
                ->whereDate('due_date', '>=', now())
                ->whereDate('due_date', '<=', now()->addDays(7))
                ->get();
    $userEmail = 'himanshupatil5690@gmail.com'; // Change this to any email you want to test with
    $subject = 'Test Email from Laravel';
    $message = "'This is a test email sent from Laravel'. {$records}";

    // Test sending email
    $result = Mail::raw($message, function ($mail) use ($userEmail, $subject) {
        $mail->to($userEmail)
            ->subject($subject);
    });

    return $result ? 'Email sent successfully!' : 'Failed to send email.';
});


Route::get('/', [UserLoginController::class, 'userlogin']);
Route::get('/login', [UserLoginController::class, 'userlogin'])->name('login');
Route::post('/logincheck', [UserLoginController::class, 'logincheck']);
Route::get('/logout', [UserLoginController::class, 'logout'])->name('logout');
Route::get('/rcms/otp-verification/{id}', [UserLoginController::class, 'showOtpForm'])->name('otp-verification');
// Route::get('/rcms/otp-verification', [UserLoginController::class, 'showOtpForm'])->name('otp-verification');
Route::post('/rcms/otp-verification', [UserLoginController::class, 'otpVerification'])->name('otp-verification-submit');

// Route::post('rcms/otp-verification', [UserLoginController::class, 'otpVerification'])->name('otp-verification');

// Route::post('rcms/otp-verification', [UserLoginController::class, 'otpVerification'])->name('');



Route::post('/update-profile', [UserLoginController::class, 'updateProfile'])->name('update-profile');


Route::post('/rcms_check', [UserLoginController::class, 'rcmscheck']);
Route::post('CC-effectiveness-check/{id}', [CCController::class, 'changeControlEffectivenessCheck'])->name('CC-effectiveness-check');
//Route::get('/', [UserLoginController::class, 'userlogin']);
Route::get('/error', function () {
    return view('error');
})->name('error.route');

//!---------------- starting login  ---------------------------//

Route::get('/', [UserLoginController::class, 'userlogin']);
Route::view('forgot-password', 'frontend.forgot-password');
// Route::view('dashboard', 'frontend.dashboard');




Route::get('data-fields', function () {
    return view('frontend.change-control.data-fields');
});
Route::middleware(['auth', 'prevent-back-history', 'user-activity'])->group(function () {
    Route::resource('change-control', OpenStageController::class);
    Route::get('change-control-audit/{id}', [OpenStageController::class, 'auditTrial']);
    Route::get('change-control-audit-detail/{id}', [OpenStageController::class, 'auditDetails']);
    Route::post('division/change/{id}', [OpenStageController::class, 'division'])->name('division_change');
    Route::get('send-notification/{id}', [OpenStageController::class, 'notification']);
    Route::resource('documents', DocumentController::class);
    Route::post('revision/{id}', [DocumentController::class, 'revision']);
    Route::get('delegate/{id}', [DocumentController::class, 'delegate']);
    Route::post('delegate-updated', [DocumentController::class, 'delegateUpdate']);
    Route::get('/documentExportPDF', [DocumentController::class, 'documentExportPDF'])->name('documentExportPDF');
    Route::get('/documentExportEXCEL', [DocumentController::class, 'documentExportEXCEL'])->name('documentExportEXCEL');
    Route::post('/import', [DocumentController::class, 'import'])->name('csv.import');
    Route::post('/importpdf', [ImportController::class, 'PDFimport']);
    Route::post('division_submit', [DocumentController::class, 'division'])->name('division_submit');
    //Route::post('set/division', [DocumentController::class, 'division'])->name('division_submit');
    Route::post('dcrDivision', [DocumentController::class, 'dcrDivision'])->name('dcrDivision_submit');
    Route::get('documents/generatePdf/{id}', [DocumentController::class, 'createPDF']);

    Route::get('documents/reviseCreate/{id}', [DocumentController::class, 'revise_create']);

    Route::get('documents/printPDF/{id}', [DocumentController::class, 'printPDF'])->name('document.print.pdf');
    Route::post('documents/pdfHistory/', [DocumentController::class, 'storePrintHistory'])->name('document.print.pdf.history');
    //Annexures
    Route::get('documents/printAnnexure/{document}/{annexure}', [DocumentController::class, 'printAnnexure'])->name('document.print.annexure');//annexure
    Route::get('documents/setReadonly/{document}/{annexure}', [DocumentController::class, 'setReadonly'])->name('document.set.readonly');
    Route::get('documents/reviseAnnexure/{document}/{annexure}', [DocumentController::class, 'reviseAnnexure'])->name('document.revise.annexure');
    Route::post('documents/saveAnnexures/{document}', [DocumentController::class, 'saveAnnexures'])->name('document.save.annexures');

Route::get('documents/{document}/annexures', [DocumentController::class, 'showAnnexures'])->name('documents.annexures');
    // Route::post('documents/{id}/save', [DocumentController::class, 'saveDocument'])->name('saveDocument');

    // Route::post('documents/saveAnnexures/{document}', [DocumentController::class, 'saveAnnexures'])->name('document.save.annexures');

    // Route::get('documents/setReadonly/{document}/{annexure}', [DocumentController::class, 'setReadonly'])->name('document.set.readonly');

    Route::get('documents/viewpdf/{id}', [DocumentController::class, 'viewPdf']);
    Route::get('documents/revision-history/{id}', [DocumentController::class, 'revision_history'])->name('document.revision.history');
    Route::get('documents/printPDFAnx/{id}', [DocumentController::class, 'printPDFAnx'])->name('document.print.pdf');
    Route::get('documents/printPDF/{id}', [DocumentController::class, 'printPDF']);
    Route::resource('documentsContent', DocumentContentController::class);
    Route::get('doc-details/{id}', [DocumentDetailsController::class, 'viewdetails']);
    Route::put('sendforstagechanage', [DocumentDetailsController::class, 'sendforstagechanage']);
    Route::put('sendfordraft', [DocumentDetailsController::class, 'sendfordraft']);
    Route::get('notification/{id}', [DocumentDetailsController::class, 'notification']);
    Route::get('/get-data', [DocumentDetailsController::class, 'getData'])->name('get.data');
    Route::post('/send-notification', [DocumentDetailsController::class, 'sendNotification']);
    Route::get('/search', [DocumentDetailsController::class, 'search']);
    Route::get('/advanceSearch', [DocumentDetailsController::class, 'searchAdvance']);
    Route::get('auditPrint/{id}', [DocumentDetailsController::class, 'printAudit']);
    Route::get('mytaskdata', [MytaskController::class, 'index']);
    Route::get('myactivity', [MyActivityController::class, 'index']);
    Route::get('/vacademy', [VidyaGxPAcademyController::class, 'index']);
    Route::get('mydms', [CabinateController::class, 'index']);
    Route::get('email', [CabinateController::class, 'email']);
    Route::get('rev-details/{id}', [MytaskController::class, 'reviewdetails']);
    Route::post('send-change-control/{id}', [ChangeControlController::class, 'statechange']);
    Route::get('audit-trial/{id}', [DocumentDetailsController::class, 'auditTrial']);
    Route::get('audit-individual/{id}/{user}', [DocumentDetailsController::class, 'auditTrialIndividual']);
    Route::get('audit-detail/{id}', [DocumentDetailsController::class, 'auditDetails'])->name('audit-detail');
    Route::post('update-doc/{id}', [DocumentDetailsController::class, 'updatereviewers'])->name('update-doc');
    Route::get('audit-details/{id}', [DocumentDetailsController::class, 'getAuditDetail'])->name('audit-details');


    // pdf to word/////////////////////////////////////////////////////
    Route::get('/document/download-word/{id}', [DocumentController::class, 'downloadWord'])->name('download.word');

    Route::get('/document/download-print/{id}', [DocumentController::class, 'printDownloadPDF'])->name('document.print.downloadpdf');

    Route::get('dashboard', [DashboardController::class, 'index']);
    Route::get('analytics', [DashboardController::class, 'analytics']);
    Route::post('subscribe', [DashboardController::class, 'subscribe']);
    Route::resource('TMS', TMSController::class);
    Route::get('TMS-details/{id}/{sopId}', [TMSController::class, 'viewTraining']);
    Route::get('/yearly-training', [TMSController::class, 'YearlyTraining'])->name('yearly.training');
    Route::post('/yearly-training-post', [TMSController::class, 'YearlyTrainingPost']);
    Route::post('/designation-training-post', [TMSController::class, 'designationTrainingCount']); //graphs route --
    Route::post('/jobrole-training-post', [TMSController::class, 'jobTrainingCount']);

    // Route::get('/department_wise_report', [DepartmentWiseController::class, 'department_wise_report'])->name('department_wise_report');
    Route::post('/department-wise-post', [DepartmentWiseController::class, 'DepartmentWisePost']);

    // Route::get('department_wise_training_details/{id}', [DepartmentWiseController::class, 'viewrendersopjobrole']);
   
         Route::post('save-reading-time', [DepartmentWiseController::class, 'saveReadingTime']);

    Route::get('departmentwisequestionshow/{id}/{department_wise_id}', [DepartmentWiseController::class, 'departmentwisequestionshow']);
    Route::post('/check-answer-department-wise', [DepartmentWiseController::class, 'checkAnswerDepartmentWise'])->name('check_answer_department_wise');
    // Route::get('/induction_training_certificate/{id}', [InductionTrainingController::class, 'showCertificate']);

    // web.php (routes file)
Route::get('/api/employees', [DepartmentWiseController::class, 'fetchEmployees']);

    // Route::get('tniEmp_sop_details/{id}', [TNIEmployeeController::class, 'viewrendersoptniemp']);
    Route::get('tniEmp_sop_details/{id}/{total_minimum_time}/{per_screen_running_time}/{tni_emp_training_id}/{sop_spent_time}', [TNIEmployeeController::class, 'viewrendersoptniemp']);

    Route::get('tniquestionshow/{id}/{department_wise_id}', [TNIEmployeeController::class, 'tniquestionshow']);
    Route::post('/check_answer_tni_emp', [TNIEmployeeController::class, 'checkAnswerTni'])->name('check_answer_tni_emp');


    Route::get('tni_sop_details/{id}', [TNIController::class, 'viewrendersoptnimatrix']);
    // Route::get('tni_sop_details/{id}/{total_minimum_time}/{per_screen_running_time}/{tni_training_id}/{sop_spent_time}', [TNIController::class, 'viewrendersoptnimatrix']);
    Route::post('/check-answer-tni-employee', [TNIController::class, 'checkAnswerTniEmployee'])->name('check_answer_tni_employee');


    Route::get('/training-attandance', [TMSController::class, 'TrainingAttandance'])->name('training.attandance');
    Route::get('TMMNumberingLog', [TMSController::class, 'TrainingModuleNumberingLog'])->name('TMMNumberingLog');
    Route::get('/training-need-identification', [TMSController::class, 'TNIMatrix'])->name('training.tni');

    Route::get('/sop-training-history', [TMSController::class, 'SOPTrainingHistory'])->name('SOP.Training.History');
    Route::post('/SOP-history', [TMSController::class, 'SOPHistory']);


    Route::get('/employee-training-history', [TMSController::class, 'EmployeeTrainingHistory'])->name('employee.training.history');
    Route::get('/list-of-qualified-trainers', [TMSController::class, 'Listofqualifiedtrainers'])->name('List.qualified.trainers');
    Route::post('/list-of-qualified-trainers-post', [TMSController::class, 'ListofqualifiedtrainersPost']);
    Route::post('/training-history', [TMSController::class, 'TrainingHistory']);

    Route::get('training/{id}/', [TMSController::class, 'training']);
    Route::get('trainingQuestion/{id}/', [TMSController::class, 'trainingQuestion']);
    Route::get('training-notification/{id}', [TMSController::class, 'notification']);
    Route::post('trainingComplete/{id}', [TMSController::class, 'trainingStatus']);
    Route::get('training-overall-status/{id}', [TMSController::class, 'trainingOverallStatus']);
    //Route::post('trainingSubmitData/{id}', [TMSController::class, 'trainingSubmitData']);
    Route::get('tms-audit/{id}', [TMSController::class, 'auditTrial']);
    Route::get('tms-audit-detail/{id}', [TMSController::class, 'auditDetails']);
    // Route::post('import', function () {
    //     Excel::import(new DocumentsImport, request()->file('file'));
    //     return redirect()->back()->with('success', 'Data Imported Successfully');
    // });
    Route::get('example/{id}/', [TMSController::class, 'example']);

    // Questions Part
    Route::resource('question', QuestionController::class);
    Route::get('questiondata/{id}', [QuestionBankController::class, 'datag'])->name('questiondata');
    Route::resource('question-bank', QuestionBankController::class);
    Route::resource('quize', QuizeController::class);
    Route::get('data/{id}', [QuizeController::class, 'datag'])->name('data');
    Route::get('datag/{id}', [QuizeController::class, 'data'])->name('datag');
    //-----------------------QMS----------------
    Route::get('qms-dashboard', [RcmsDashboardController::class, 'index']);


    Route::get('/annexure/{id}/revise', [DocumentController::class, 'revise_annexure'])->name('annexure.revise');
    Route::get('/annexure/{id}/obsolete', [DocumentController::class, 'obsolete_annexure'])->name('annexure.obsolete');
});

// ====================================Capa=======================
Route::get('capa', [CapaController::class, 'capa']);
Route::post('capastore', [CapaController::class, 'capastore'])->name('capastore');
Route::post('capaUpdate/{id}', [CapaController::class, 'capaUpdate'])->name('capaUpdate');
Route::get('capashow/{id}', [CapaController::class, 'capashow'])->name('capashow');
Route::post('capa/stage/{id}', [CapaController::class, 'capa_send_stage'])->name('capa_send_stage');
Route::post('capa/cancel/{id}', [CapaController::class, 'capaCancel'])->name('capaCancel');
Route::post('capa/reject/{id}', [CapaController::class, 'capa_reject'])->name('capa_reject');
Route::post('capa/Qa/{id}', [CapaController::class, 'capa_qa_more_info'])->name('capa_qa_more_info');
Route::get('CapaAuditTrial/{id}', [CapaController::class, 'CapaAuditTrial']);
Route::get('auditDetailsCapa/{id}', [CapaController::class, 'auditDetailsCapa'])->name('showCapaAuditDetails');
Route::post('capa_child/{id}', [CapaController::class, 'child_change_control'])->name('capa_child_changecontrol');
Route::post('effectiveness_check/{id}', [CapaController::class, 'effectiveness_check'])->name('capa_effectiveness_check');
Route::get('/capa/export-csv', [CapaController::class, 'exportCsv'])->name('export_capa.csv');
Route::get('/capa/export-excel', [CapaController::class, 'exportExcel'])->name('export_capa.excel');

// ====================================Global Capa=======================
Route::get('globalCapa', [GlobalCapaController::class, 'globalCapa']);
Route::post('globalCapaStore', [GlobalCapaController::class, 'globalCapaStore'])->name('globa_globalCapaStore');
Route::post('globalCapaUpdate/{id}', [GlobalCapaController::class, 'globalcapaUpdate'])->name('global_globalcapaUpdate');
Route::get('globalCapaShow/{id}', [GlobalCapaController::class, 'globalCapaShow'])->name('global_globalCapaShow');
Route::post('globalCapa/stage/{id}', [GlobalCapaController::class, 'global_capa_send_stage'])->name('global_global_capa_send_stage');
Route::post('globalCapa/cancel/{id}', [GlobalCapaController::class, 'globalCapaCancel'])->name('global_globalCapaCancel');
Route::post('globalCapa/reject/{id}', [GlobalCapaController::class, 'global_capa_reject'])->name('global_global_capa_reject');
Route::post('globalCapa/Qa/{id}', [GlobalCapaController::class, 'global_qa_more_info'])->name('global_global_capa');
Route::get('GlobalCapaAuditTrial/{id}', [GlobalCapaController::class, 'GlobalCapaAuditTrial']);
Route::get('auditDetailsGlobalCapa/{id}', [GlobalCapaController::class, 'auditDetailsCapa'])->name('global_showCapaAuditDetails');
Route::post('global_capa_child/{id}', [GlobalCapaController::class, 'child_global_control'])->name('global_capa_child_changecontrol');
Route::post('globaleffectiveness_check/{id}', [GlobalCapaController::class, 'effectiveness_check']);
Route::get('/globalcapa/export-csv', [GlobalCapaController::class, 'exportCsv']);
Route::get('/globalcapa/export-excel', [GlobalCapaController::class, 'exportExcel']);
Route::get('changeControlQuestionShow/{documentNumber}/{changeControlId}', [CCController::class, 'changeControlQuestionShow']);
Route::post('/check_answer_changeControl', [CCController::class, 'checkAnswerChangeControl'])->name('check_answer_changeControl');
// Route::get('change-control-training-detail/{id}', [CCController::class, 'viewTrainingDetail']);

// ==============================management review ==========================manage

Route::post('managestore', [ManagementReviewController::class, 'managestore'])->name('managestore');
Route::post('manageUpdate/{id}', [ManagementReviewController::class, 'manageUpdate'])->name('manageUpdate');
Route::get('manageshow/{id}', [ManagementReviewController::class, 'manageshow'])->name('manageshow');
Route::post('manage/stage/{id}', [ManagementReviewController::class, 'manage_send_stage'])->name('manage_send_stage');
Route::post('manage/cancel/{id}', [ManagementReviewController::class, 'manageCancel'])->name('manageCancel');
Route::post('manage/reject/{id}', [ManagementReviewController::class, 'manage_reject'])->name('manage_reject');
Route::post('manage_send_more_require_stage/{id}', [ManagementReviewController::class, 'manage_send_more_require_stage'])->name('manage_send_more_require_stage');
Route::post('manage/Qa/{id}', [ManagementReviewController::class, 'manage_qa_more_info'])->name('manage_qa_more_info');
Route::get('ManagementReviewAuditTrial/{id}', [ManagementReviewController::class, 'ManagementReviewAuditTrial']);
Route::get('ManagementReviewAuditDetails/{id}', [ManagementReviewController::class, 'ManagementReviewAuditDetails']);
Route::get('/management/{id}',[ManagementReviewController::class,'audit_trail_managementReview_filter'])->name('api.management-review.filter');


/********************************************* Deviation Starts *******************************************/

Route::post('deviation_child/{id}', [DeviationController::class, 'deviation_child_1'])->name('deviation_child_1');

Route::get('DeviationAuditTrial/{id}', [DeviationController::class, 'DeviationAuditTrial']);
Route::post('DeviationAuditTrial/{id}', [DeviationController::class, 'store_audit_review'])->name('store_audit_review');
Route::get('/Deviation/{id}',[DeviationController::class,'audit_trail_filter'])->name('api.Deviation.filter');

/********************************************* Deviation Ends *******************************************/

/********************************************* Deviation Starts *******************************************/

Route::post('failure_investigation_child_1/{id}', [FailureInvestigationController::class, 'failure_investigation_child_1'])->name('failure_investigation_child_1');
Route::post('non_conformances_child_1/{id}', [NonConformaceController::class, 'non_conformances_child_1'])->name('non_conformances_child_1');
Route::post('incident_child_1/{id}', [IncidentController::class, 'incident_child_1'])->name('incident_child_1');

/********************************************* Deviation Ends *******************************************/

// ==============================end ==============================
//! ============================================
//!                    Risk Management
//! ============================================
Route::get('risk-management', [RiskManagementController::class, 'risk']);
Route::get('RiskManagement/{id}', [RiskManagementController::class, 'show'])->name('showRiskManagement');
Route::post('risk_store', [RiskManagementController::class, 'store'])->name('risk_store');
Route::post('riskAssesmentUpdate/{id}', [RiskManagementController::class, 'riskUpdate'])->name('riskUpdate');
Route::post('riskAssesmentStateChange{id}', [RiskManagementController::class, 'riskAssesmentStateChange'])->name('riskAssesmentStateUpdate');
Route::post('reject_Risk/{id}', [RiskManagementController::class, 'RejectStateChange'])->name('reject_Risk');
Route::post('cancel_Risk/{id}', [RiskManagementController::class, 'CancelStateChange'])->name('cancel_Risk');

Route::get('riskAuditTrial/{id}', [RiskManagementController::class, 'riskAuditTrial']);
Route::get('auditDetailsrisk/{id}', [RiskManagementController::class, 'auditDetailsrisk'])->name('showriskAuditDetails');
Route::post('child/{id}', [RiskManagementController::class, 'child'])->name('riskAssesmentChild');
Route::post('riskassesmentCancel/{id}', [RiskManagementController::class, 'riskassesmentCancel'])->name('riskassesmentCancel');

Route::post('RMAuditReview/{id}', [RiskManagementController::class, 'rm_AuditReview'])->name('RMAuditReview');
Route::get('ra_filter/{id}', [RiskManagementController::class, 'audit_filter'])->name('ra_filter');





// ======================================================


// ====================================root cause analysis=======================
Route::post('RCAChildRoot/{id}', [RootCauseController::class, 'RCAChildRoot'])->name('R_C_A_root_child');
Route::get('root-cause-analysis', [RootCauseController::class, 'rootcause']);
Route::post('rootstore', [RootCauseController::class, 'root_store'])->name('root_store');
Route::post('rootUpdate/{id}', [RootCauseController::class, 'root_update'])->name('root_update');
Route::get('rootshow/{id}', [RootCauseController::class, 'root_show'])->name('root_show');
Route::post('root/stage/{id}', [RootCauseController::class, 'root_send_stage'])->name('root_send_stage');
Route::post('root/cancel/{id}', [RootCauseController::class, 'root_Cancel'])->name('root_Cancel');
Route::post('root/reject/{id}', [RootCauseController::class, 'root_reject'])->name('root_reject');
Route::get('rootAuditTrial/{id}', [RootCauseController::class, 'rootAuditTrial']);
Route::get('auditDetailsRoot/{id}', [RootCauseController::class, 'auditDetailsroot'])->name('showrootAuditDetails');


// ====================================Traning Material Management=======================
Route::get('training-module-management', [TrainingMaterialManagementController::class, 'trainingmaterialmanagement']);
Route::post('/tms/TMM', [TrainingMaterialManagementController::class, 'store'])->name('TMM.store');
Route::post('/tms/TMM/{id}', [TrainingMaterialManagementController::class, 'update'])->name('TMM.update');
Route::get('TMM_view/{id}', [TrainingMaterialManagementController::class, 'show'])->name('TMM_view');
Route::post('tms/tmm/sendstage/{id}', [TrainingMaterialManagementController::class, 'sendStage']);


//=========================================Yearly Training Planner==============================
Route::get('yearly_trainning_plan_create', [YearlyTrainingPlannerController::class, 'creatYTPlanner']);
Route::post('/tms/YTP', [YearlyTrainingPlannerController::class, 'store'])->name('YTP.store');
Route::post('/tms/YTP/{id}', [YearlyTrainingPlannerController::class, 'update'])->name('YTP.update');
Route::get('/ytp_view/{id}', [YearlyTrainingPlannerController::class, 'show'])->name('ytp_view');
// Route::get('tms/YTP/ytp_view/{id}', [YearlyTrainingPlannerController::class, 'sendStage'])->name('ytp_view');
Route::post('tms/YTP/ytp_views/{id}', [YearlyTrainingPlannerController::class, 'sendStage'])->name('ytp_views');
Route::post('tms/YTP/stageReject/{id}', [YearlyTrainingPlannerController::class, 'stageReject']);
Route::post('tms/YTP/stageCancel/{id}', [YearlyTrainingPlannerController::class, 'stageCancel']);


Route::get('tni_employee_report/{id}', [TNIEmployeeController::class, 'tniEmployeeReport'])->name('tni_employee_report');


// ====================================InternalauditController=======================
Route::post('internalauditreject/{id}', [InternalauditController::class, 'RejectStateChange']);
Route::post('nocapastate/{id}', [InternalauditController::class, 'noCapastate']);
Route::post('InternalAuditCancel/{id}', [InternalauditController::class, 'InternalAuditCancel']);
Route::post('InternalAuditChild/{id}', [InternalauditController::class, 'internal_audit_child'])->name('internal_audit_child');
Route::post('multiple_child/{id}', [InternalauditController::class, 'multiple_child'])->name('multiple_child');
Route::post('internalAuditReview/{id}', [InternalauditController::class, 'internalAuditReview'])->name('internalAuditReview');
// external audit----------------------------
//-----------------Sanction------------------------//
Route::get('sanction', [SanctionController::class, 'index']);
Route::get('showSanction/{id}', [SanctionController::class, 'show'])->name('showSanction');
Route::post('sanction_store', [SanctionController::class, 'sanction_store'])->name('sanction_store');
Route::post('updateSanction/{id}', [SanctionController::class, 'update'])->name('updateSanction');
Route::post('SanctionCancel/{id}', [SanctionController::class, 'SanctionCancel'])->name('SanctionCancel');
Route::get('SanctionAuditTrail/{id}', [SanctionController::class, 'SanctionAuditTrail'])->name('SanctionAuditTrail');
Route::get('rcms/SanctionAuditReport/{id}', [SanctionController::class, 'SanctionAuditReport'])->name('SanctionAuditReport');
Route::get('rcms/SanctionSingleReport/{id}', [SanctionController::class, 'SanctionSingleReport'])->name('SanctionSingleReport');


// ehsevent
Route::get('ehsevent', [EhsController::class, 'index']);
Route::get('showEhs_event/{id}', [EhsController::class, 'show'])->name('showEhs_event');
Route::post('ehs_event_store', [EhsController::class, 'ehs_event_store'])->name('ehs_event_store');
Route::post('updateEhs_event/{id}', [EhsController::class, 'update'])->name('updateEhs_event');
Route::post('ehsEventStateChange/{id}', [EhsController::class, 'ehsEventStateChange'])->name('ehsEventStateChange');
// Route::post('ehsEventRejectState/{id}', [EhsController::class, 'ehsEventRejectState'])->name('ehsEventRejectState');
Route::post('EHSCancel/{id}', [EhsController::class, 'EHSCancel'])->name('EHSCancel');
Route::post('ehsMoreInfo/{id}', [EhsController::class, 'ehsMoreInfo'])->name('ehsMoreInfo');
Route::post('ehsChild/{id}', [EhsController::class, 'ehsChild'])->name('ehsChild');
Route::get('ehsAuditTrail/{id}', [EhsController::class, 'ehsAuditTrail'])->name('ehsAuditTrail');
Route::get('rcms/ehsAuditReport/{id}', [EhsController::class, 'ehsAuditReport'])->name('ehsAuditReport');
Route::get('rcms/ehsSingleReport/{id}', [EhsController::class, 'ehsSingleReport'])->name('ehsSingleReport');
Route::get('rcms/EHSFamilyReport/{id}', [EhsController::class, 'familyReport'])->name('EHSFamilyReport');
Route::get('EHSActivityLog/{id}', [EhsController::class, 'EHSActivityLog'])->name('EHSActivityLog');




// ----------------------------------Preventive Maintenance--------------------------------

Route::get('preventivemaintenance', [ PreventiveMaintenanceController::class, 'index'])->name('preventivemaintenance');
Route::get('showpreventive/{id}', [ PreventiveMaintenanceController::class, 'show'])->name('showpreventive');
Route::post('preventivemaintenance_store', [ PreventiveMaintenanceController::class, 'preventivemaintenance_store'])->name('preventivemaintenance_store');
Route::post('updatePreventiveMaintenance/{id}', [ PreventiveMaintenanceController::class, 'update'])->name('updatePreventiveMaintenance');
Route::post('PreventiveStateChange/{id}', [ PreventiveMaintenanceController::class, 'PreventiveStateChange'])->name('PreventiveStateChange');
Route::post('MoreInfoPreventive/{id}', [ PreventiveMaintenanceController::class, 'MoreInfoPreventive'])->name('MoreInfoPreventive');
Route::post('PreventiveCancel/{id}', [ PreventiveMaintenanceController::class, 'PreventiveCancel'])->name('PreventiveCancel');
// Route::post('RejectEquipmentReQualification/{id}', [ PreventiveMaintenanceController::class, 'RejectEquipmentReQualification'])->name('RejectEquipmentReQualification');
Route::get('PrevantiveAuditTrail/{id}', [ PreventiveMaintenanceController::class, 'PrevantiveAuditTrail'])->name('PrevantiveAuditTrail');
// Route::post('equipmentChild/{id}', [ PreventiveMaintenanceController::class, 'equipmentChild'])->name('equipmentChild');


// ----------------------------------Inventory Management--------------------------------

Route::get('inventorymanagment', [ InventoryManagementController::class, 'index'])->name('inventorymanagment');
Route::get('showinventory/{id}', [ InventoryManagementController::class, 'show'])->name('showinventory');
Route::post('inventorymanagment_store', [ InventoryManagementController::class, 'inventorymanagment_store'])->name('inventorymanagment_store');
Route::post('updateinventorymanagment/{id}', [ InventoryManagementController::class, 'update'])->name('updateinventorymanagment');
Route::post('InventoryStateChange/{id}', [ InventoryManagementController::class, 'InventoryStateChange'])->name('InventoryStateChange');
Route::post('MoreInfoInventory/{id}', [ InventoryManagementController::class, 'MoreInfoInventory'])->name('MoreInfoInventory');
Route::post('InventoryCancel/{id}', action: [ InventoryManagementController::class, 'InventoryCancel'])->name('InventoryCancel');
Route::get('InventoryAuditTrail/{id}', [ InventoryManagementController::class, 'InventoryAuditTrail'])->name('InventoryAuditTrail');
Route::get('exportcsvem', [InventoryManagementController::class, 'exportCsv'])->name('exportcsvem');
Route::get('exportexceem', [InventoryManagementController::class, 'exportExcel'])->name('exportexceem');
Route::get('inventory_singlereport/{id}', [InventoryManagementController::class, 'inventory_singlereport'])->name('inventory_singlereport');
Route::get('inventory_auditreport/{id}', [InventoryManagementController::class, 'inventory_auditreport'])->name('inventory_auditreport');
Route::post('inventoryChild/{id}', [InventoryManagementController::class, 'inventoryChild'])->name('inventoryChild');

// ----------------------------------Receipt--------------------------------


Route::get('show/{id}', [AuditeeController::class, 'show'])->name('showExternalAudit');
Route::post('auditee_store', [AuditeeController::class, 'store'])->name('auditee_store');
Route::post('update/{id}', [AuditeeController::class, 'update'])->name('updateExternalAudit');
Route::post('ExternalAuditStateChange/{id}', [AuditeeController::class, 'ExternalAuditStateChange'])->name('externalAuditStateChange');
Route::post('stateAuditee/{id}', [AuditeeController::class, 'RejectStateChange'])->name('stateAuditee');
Route::post('RejectStateAuditee/{id}', [AuditeeController::class, 'RejectStateChange'])->name('RejectStateAuditee');
Route::post('CancelStateExternalAudit/{id}', [AuditeeController::class, 'externalAuditCancel'])->name('CancelStateExternalAudit');
Route::get('ExternalAuditTrialShow/{id}', [AuditeeController::class, 'AuditTrialExternalShow'])->name('ShowexternalAuditTrial');
Route::get('ExternalAuditTrialDetails/{id}', [AuditeeController::class, 'AuditTrialExternalDetails'])->name('ExternalAuditTrialDetailsShow');
Route::post('child_external/{id}', [AuditeeController::class, 'child_external'])->name('childexternalaudit');


//------------------Callibration Details----------------------//
Route::get('create-calibration', [CallibrationDetailsController::class, 'index'])->name('create-calibration');
Route::get('showCalibrationDetails/{id}', [CallibrationDetailsController::class, 'show'])->name('showCalibrationDetails');
Route::post('CalibrationDetails_store', [CallibrationDetailsController::class, 'CalibrationDetails_store'])->name('CalibrationDetails_store');
Route::post('updateCalibrationDetails/{id}', [CallibrationDetailsController::class, 'update'])->name('updateCalibrationDetails');
Route::post('CalibrationDetailsStateChange/{id}', [CallibrationDetailsController::class, 'CalibrationDetailsStateChange'])->name('CalibrationDetailsStateChange');
Route::post('CalibrationDetailsStateChangeNew/{id}', [CallibrationDetailsController::class, 'CalibrationDetailsStateChangeNew'])->name('CalibrationDetailsStateChangeNew');
Route::post('RejectCalibrationDetails/{id}', [CallibrationDetailsController::class, 'RejectCalibrationDetails'])->name('RejectCalibrationDetails');
Route::post('CalibrationCancel/{id}', [CallibrationDetailsController::class, 'CalibrationCancel'])->name('CalibrationCancel');
Route::post('Calibrationback/{id}', [CallibrationDetailsController::class, 'Calibration_more_info'])->name('Calibrationback');
Route::post('CalibrationChild/{id}', [CallibrationDetailsController::class, 'CalibrationChild'])->name('CalibrationChild');
Route::get('rcms/CalibrationSingleReport/{id}', [CallibrationDetailsController::class, 'calibrationSingleReport'])->name('CalibrationSingleReport');
Route::get('calibrationAuditTrail/{id}', [CallibrationDetailsController::class, 'calibrationAuditTrail']);
Route::get('rcms/calibrationAuditTrailPdf/{id}', [CallibrationDetailsController::class, 'auditTrialPDF']);
Route::get('calibrationActivityLog/{id}', [CallibrationDetailsController::class, 'calibrationActivityLog']);
Route::get('export-csv', [CallibrationDetailsController::class, 'calibration_detailexportCsv'])->name('export.calibrationmanagement.csv');
Route::get('export-excel', [CallibrationDetailsController::class, 'calibration_detailexportExcel'])->name('export.calibrationmanagement.excel');



//-----------------------------------------Control Sample-----------------------

Route::get('control-sample-new',[ControlSampleController::class,'index'])->name('control-sample-new');
Route::post('control-sample-store',[ControlSampleController::class,'store'])->name('control-sample-store');
Route::get('controlSample-show/{id}',[ControlSampleController::class,'controSampleShow'])->name('controleSampleShow');
Route::post('update-controlSample/{id}',[ControlSampleController::class,'controlSampleUpdate'])->name('UpdateControlsample');
Route::post('controlSampleStageChange/{id}',[ControlSampleController::class,'ControlSampleStateChange'])->name('controlSampleStageChange');
Route::post('RejectControlSample/{id}', [ControlSampleController::class, 'RejectControlSample'])->name('RejectControlSample');
Route::get('controlSample_singleReport/{id}',[ControlSampleController::class,'singleReport'])->name('controlSample_singleReport');
Route::get('controlSample_auditReport/{id}',[ControlSampleController::class,'auditReport'])->name('controlSample_auditReport');
Route::get('AuditTrialSampleControlShow/{id}', [ControlSampleController::class, 'AuditTrialSampleControlShow'])->name('AuditTrialSampleControlShow');
Route::get('controlsampleActivitylog/{id}', [ControlSampleController::class, 'activitylogPrint'])->name('controlsampleActivitylog');
Route::get('exportcsvcs', [ControlSampleController::class, 'exportCsv'])->name('exportcsvcs');
Route::get('exportexcecs', [ControlSampleController::class, 'exportExcel'])->name('exportexcecs');
Route::post('UpdateStateAuditee/{id}', [AuditeeController::class, 'UpdateStateChange'])->name('UpdateStateAuditee');
//------------------Callibration Details----------------------//
Route::get('create-calibration', [CallibrationDetailsController::class, 'index'])->name('create-calibration');
Route::get('showCalibrationDetails/{id}', [CallibrationDetailsController::class, 'show'])->name('showCalibrationDetails');
Route::post('CalibrationDetails_store', [CallibrationDetailsController::class, 'CalibrationDetails_store'])->name('CalibrationDetails_store');
Route::post('updateCalibrationDetails/{id}', [CallibrationDetailsController::class, 'update'])->name('updateCalibrationDetails');
Route::post('CalibrationDetailsStateChange/{id}', [CallibrationDetailsController::class, 'CalibrationDetailsStateChange'])->name('CalibrationDetailsStateChange');
Route::post('CalibrationDetailsStateChangeNew/{id}', [CallibrationDetailsController::class, 'CalibrationDetailsStateChangeNew'])->name('CalibrationDetailsStateChangeNew');
Route::post('RejectCalibrationDetails/{id}', [CallibrationDetailsController::class, 'RejectCalibrationDetails'])->name('RejectCalibrationDetails');
Route::post('CalibrationCancel/{id}', [CallibrationDetailsController::class, 'CalibrationCancel'])->name('CalibrationCancel');
Route::post('Calibrationback/{id}', [CallibrationDetailsController::class, 'Calibration_more_info'])->name('Calibrationback');
Route::post('CalibrationChild/{id}', [CallibrationDetailsController::class, 'CalibrationChild'])->name('CalibrationChild');
Route::get('rcms/CalibrationSingleReport/{id}', [CallibrationDetailsController::class, 'calibrationSingleReport'])->name('CalibrationSingleReport');
Route::get('calibrationAuditTrail/{id}', [CallibrationDetailsController::class, 'calibrationAuditTrail']);
Route::get('rcms/calibrationAuditTrailPdf/{id}', [CallibrationDetailsController::class, 'auditTrialPDF']);
Route::get('calibrationActivityLog/{id}', [CallibrationDetailsController::class, 'calibrationActivityLog']);
Route::get('export-csv', [CallibrationDetailsController::class, 'calibration_detailexportCsv'])->name('export.calibrationmanagement.csv');
Route::get('export-excel', [CallibrationDetailsController::class, 'calibration_detailexportExcel'])->name('export.calibrationmanagement.excel');



//-----------------------------------------Control Sample-----------------------

Route::get('control-sample-new',[ControlSampleController::class,'index'])->name('control-sample-new');
Route::post('control-sample-store',[ControlSampleController::class,'store'])->name('control-sample-store');
Route::get('controlSample-show/{id}',[ControlSampleController::class,'controSampleShow'])->name('controleSampleShow');
Route::post('update-controlSample/{id}',[ControlSampleController::class,'controlSampleUpdate'])->name('UpdateControlsample');
Route::post('controlSampleStageChange/{id}',[ControlSampleController::class,'ControlSampleStateChange'])->name('controlSampleStageChange');
Route::post('RejectControlSample/{id}', [ControlSampleController::class, 'RejectControlSample'])->name('RejectControlSample');
Route::get('controlSample_singleReport/{id}',[ControlSampleController::class,'singleReport'])->name('controlSample_singleReport');
Route::get('controlSample_auditReport/{id}',[ControlSampleController::class,'auditReport'])->name('controlSample_auditReport');
Route::get('AuditTrialSampleControlShow/{id}', [ControlSampleController::class, 'AuditTrialSampleControlShow'])->name('AuditTrialSampleControlShow');
Route::get('controlsampleActivitylog/{id}', [ControlSampleController::class, 'activitylogPrint'])->name('controlsampleActivitylog');
Route::get('exportcsvcs', [ControlSampleController::class, 'exportCsv'])->name('exportcsvcs');
Route::get('exportexcecs', [ControlSampleController::class, 'exportExcel'])->name('exportexcecs');


//----------------------Lab Incident view-----------------
Route::get('lab-incident', [LabIncidentController::class, 'labincident']);
//Route::post('RejectStateChange/{id}', [RootCauseController::class, 'RejectStateChange'])->name('RejectStateChange');
// Route::post('RejectStateChange/{id}', [LabIncidentController::class, 'RejectStateChange']);
// Route::post('LabIncidentStateChange/{id}', [LabIncidentController::class, 'LabIncidentStateChange'])->name('StageChangeLabIncident');
Route::post('RejectStateChange/{id}', [LabIncidentController::class, 'RejectStateChange']);
Route::post('StageChangeLabIncident/{id}', [LabIncidentController::class, 'LabIncidentStateChange']);
Route::post('LabIncidentCancel/{id}', [LabIncidentController::class, 'LabIncidentCancelStage']);
Route::get('/labincident/export-csv', [LabIncidentController::class, 'exportCsv'])->name('export.csv.labincident');
Route::get('/labincident/export-excel', [LabIncidentController::class, 'exportExcel'])->name('export.excel.labincident');


Route::get('audit-program', [AuditProgramController::class, 'auditprogram']);
Route::get('/labincident/{id}',[LabIncidentController::class,'audit_trail_filter_lab_incident'])->name('lab_incident_filter');
Route::post('storereview/{id}', [LabIncidentController::class, 'store_audit_review_lab'])->name('store_audit_reviewlab');
Route::get('/audit_program/{id}',[AuditProgramController::class,'audit_trail_filter_audit_program'])->name('audit_program_filter');

//---------------------------Market Complaint  -------------------------//
Route::post('McAuditTrial/{id}', [MarketComplaintController::class, 'mc_AuditReview'])->name('McAuditTrial');
Route::get('mcFilter/{id}',[MarketComplaintController::class,'audit_filter'])->name('mc_filter');
Route::post('mC/cftnotrequired/{id}', [MarketComplaintController::class, 'MarkComplaintCFTRequired'])->name('MarkComplaintCFTRequired');
Route::get('/observation/{id}',[ObservationController::class,'audit_trail_filter_observation'])->name('observation_filter');




Route::get('data-fields', function () {
    return view('frontend.data-fields');
});
Route::view('emp', 'emp');

Route::view('tasks', 'frontend.tasks');
Route::view('tasks', 'frontend.T');

Route::view('review-details', 'frontend.documents.review-details');
Route::view('audit-trial-inner', 'frontend.documents.audit-trial-inner');
Route::view('new-pdf', 'frontend.documents.new-pdf');
Route::view('new-login', 'frontend.new-login');
Route::view('ksi-overview', 'frontend.ksi-overview.ksi-overview');


// ============================================
//                    TMS
// ============================================
Route::view('activity_log', 'frontend.TMS.activity_log');

Route::view('helpdesk-personnel', 'frontend.helpdesk-personnel');

// Route::view('send-notification', 'frontend.send-notification');

Route::view('designate-proxy', 'frontend.designate-proxy');

Route::view('person-details', 'frontend.person-details');

Route::view('basic-search', 'frontend.basic-search');

//! ============================================ //
//!                    TMS
//! ============================================ //

Route::view('create-training', 'frontend.TMS.create-training');

Route::view('example', 'frontend.TMS.example');

Route::view('create-quiz', 'frontend.TMS.create-quiz');

Route::view('document-view', 'frontend.TMS.document-view');

Route::view('training-page', 'frontend.TMS.training-page');

Route::view('question-training', 'frontend.TMS.question-training');

Route::view('edit-question', 'frontend.TMS.edit-question');

Route::view('change-control-list', 'frontend.change-control.change-control-list');

Route::view('change-control-list-print', 'frontend.change-control.change-control-list-print');

Route::view('change-control-view', 'frontend.change-control.change-control-view');

Route::view('reviewer-panel', 'frontend.change-control.reviewer-panel');

Route::view('change-control-form', 'frontend.change-control.data-fields');

//Route::view('new-change-control', 'frontend.change-control.new-change-control');
Route::get("new-change-control", [CCController::class, "changecontrol"]);

Route::view('audit-pdf', 'frontend.documents.audit-pdf');

// Route::view('employee_new', 'frontend.TMS.Employee.employee_new')->name('employee_new');

Route::view('trainer_qualification', 'frontend.TMS.Trainer_qualification.trainer_qualification')->name('trainer_qualification');
// ====================induction training =================
Route::get('job_training',[JobTrainingController::class ,'index'])->name('job_training');
Route::get('job_training/show/{id}',[JobTrainingController::class ,'edit'])->name('job_training_view');

Route::post('job_trainingcreate', [JobTrainingController::class, 'store'])->name('job_trainingcreate');
Route::put('job_trainingupdate/{id}', [JobTrainingController::class, 'update'])->name('job_trainingupdate');





Route::get('induction_training', [InductionTrainingController::class, 'index'])->name('induction_training.index');
Route::get('induction_training/show/{id}', [InductionTrainingController::class, 'edit'])->name('induction_training_view');
Route::post('induction_training', [InductionTrainingController::class, 'store'])->name('induction_training.store');
Route::put('induction_training/{id}', [InductionTrainingController::class, 'update'])->name('induction_training.update');
// Route::get('PreventiveMaintenance_show/{id}', [PreventiveMaintenanceController::class, 'PreventiveMaintenance_show'])->name('PreventiveMaintenance_show');

//new route
Route::get('/employees/{id}', [InductionTrainingController::class, 'getEmployeeDetails']);

Route::get('/fetch-question/{documentId}', [InductionTrainingController::class, 'fetchQuestion']);
Route::get('/documents/view/{id}', [InductionTrainingController::class, 'viewSop'])->name('documents.view');

Route::view('yearly_trainning_plan', 'frontend.TMS.Yearly_training_planner.yearly_training_planner')->name('yearly_trainning_plan');
//---------------- Job Description--------------------------
Route::get('/employees/{id}', [JobDescriptionController::class, 'getEmployeeData']);
Route::get('job_description',[JobDescriptionController::class ,'index'])->name('job_description');
Route::get('job_description/show/{id}',[JobDescriptionController::class ,'edit'])->name('job_description_view');
Route::post('job_descriptioncreate', [JobDescriptionController::class, 'store'])->name('job_descriptioncreate');
Route::put('job_descriptionupdate/{id}', [JobDescriptionController::class, 'update'])->name('job_descriptionupdate');
Route::post('tms/jobDescription/cancelstages/{id}',[JobDescriptionController::class ,'cancelStages']);
//---------------- Scorm-------------------------
Route::get('scorm_new', [ScormController::class, 'createScorm'])->name('scorm_new');
Route::post('/tms/scorm', [ScormController::class, 'store'])->name('scorm.store');
Route::post('/tms/scorm/{id}', [ScormController::class, 'update'])->name('scorm.update');
Route::get('scorm_view/{id}', [ScormController::class, 'show'])->name('scorm.show');
Route::post('tms/jobTraining/cancelstage/{id}',[JobTrainingController::class ,'cancelStage']);
Route::get('/get-sop-description/{id}', [JobTrainingController::class, 'getSopDescription']);
Route::get('/fetch-questions/{documentId}', [JobTrainingController::class, 'fetchQuestions']);
Route::get('trainingQuestions/{id}/', [JobTrainingController::class, 'trainingQuestions']);
Route::get('/training_certificate', [JobTrainingController::class, 'showCertificate']);
Route::get('/employees/{id}', [JobTrainingController::class, 'getEmployeeDetail']);
Route::get('job_training-details/{id}', [JobTrainingController::class, 'viewrendersop']);
Route::get('question_training/{id}', [JobTrainingController::class, 'questionrendersop']);
Route::get('on_the_job_question_training/{id}/{job_id}', [JobTrainingController::class, 'questionshow']);
Route::get('job_training_certificate/{id}', [JobTrainingController::class, 'showJobCertificate']);

Route::post('/check-answer-otj', [JobTrainingController::class, 'checkAnswerOtj'])->name('check_answer_otj');
Route::post('/check-answer-induction', [InductionTrainingcontroller::class, 'checkAnswerInduction'])->name('check_answer_induction');


Route::get('induction_training-details/{id}/{total_minimum_time}/{per_screen_running_time}/{job_training_id}/{sop_spent_time}', [InductionTrainingController::class, 'viewrendersopinduction']);
Route::get('induction_question_training/{id}/{induction_id}', [InductionTrainingController::class, 'inductionquestionshow']);
Route::get('/induction_training_certificate/{id}', [InductionTrainingController::class, 'showCertificate']);


//! ============================================
//!                    RCMS
//! ============================================
Route::get('chart-data', [DesktopController::class, 'fetchChartData']);

Route::view('rcms_login', 'frontend.rcms.login');

Route::view('rcms_dashboard', 'frontend.rcms.dashboard');
Route::get('rcms_desktop', [DesktopController::class, 'rcms_desktop']);
Route::post('dashboard_search', [DesktopController::class, 'dashboard_search'])->name('dashboard_search');
Route::post('dashboard_search', [DesktopController::class, 'main_dashboard_search'])->name('main_dashboard_search');
// Route::view('rcms_desktop', 'frontend.rcms.desktop');

Route::view('rcms_reports', 'frontend.rcms.reports');

Route::view('Quality-Dashboard-Report', 'frontend.rcms.Quality-Dashboard');

Route::view('Supplier-Dashboard-Report', 'frontend.rcms.Supplier-Dashboard');

Route::view('QMSDashboardFormat', 'frontend.rcms.QMSDashboardFormat');



//! ============================================
//!                    FORMS
//! ============================================


Route::view('deviation', 'frontend.forms.deviation');

Route::view('extension_form', 'frontend.forms.extension');

Route::view('cc-form', 'frontend.forms.change-control');

Route::view('audit-management', 'frontend.forms.audit-management');

Route::view('out-of-specification', 'frontend.forms.out-of-specification');

// Route::view('risk-management', 'frontend.forms.risk-management');


Route::view('action-item', 'frontend.forms.action-item');




// Route::view('effectiveness-check', 'frontend.forms.effectiveness-check');
Route::get('effectiveness-check', [EffectivenessCheckController::class, 'effectiveness_check']);

Route::view('quality-event', 'frontend.forms.quality-event');

Route::view('vendor-entity', 'frontend.forms.vendor-entity');

// Route::view('auditee', 'frontend.forms.auditee');
Route::get('auditee', [AuditeeController::class, 'external_audit']);


Route::get('meeting', [ManagementReviewController::class, 'meeting']);

// Route::view('market-complaint', 'frontend.forms.market-complaint');

//Route::view('lab-incident', 'frontend.forms.lab-incident');

Route::view('classroom-training', 'frontend.forms.classroom-training');
// Route::view('classroom', 'frontend.forms.cc_show');


Route::view('employee', 'frontend.forms.employee');

Route::view('requirement-template', 'frontend.forms.requirement-template');

Route::view('scar', 'frontend.forms.scar');

Route::view('external-audit', 'frontend.forms.external-audit');

Route::view('contract', 'frontend.forms.contract');

Route::view('supplier', 'frontend.forms.supplier');

Route::view('supplier-initiated-change', 'frontend.forms.supplier-initiated-change');

Route::view('supplier-investigation', 'frontend.forms.supplier-investigation');

Route::view('supplier-issue-notification', 'frontend.forms.supplier-issue-notification');

Route::view('supplier-audit', 'frontend.forms.supplier-audit');

// Route::view('audit', 'frontend.forms.audit');
Route::get('audit', [InternalauditController::class, 'internal_audit']);

Route::view('supplier-questionnaire', 'frontend.forms.supplier-questionnaire');

Route::view('substance', 'frontend.forms.substance');

Route::view('supplier-action-item', 'frontend.forms.supplier-action-item');

Route::view('registration-template', 'frontend.forms.registration-template');

Route::view('project', 'frontend.forms.project');

Route::get('extension', [ExtensionController::class, 'extension_child']);

//Route::view('observation', 'frontend.forms.observation');
Route::get('observation', [ObservationController::class, 'observation']);

Route::view('new-root-cause-analysis', 'frontend.forms.new-root-cause-analysis');

Route::view('help-desk-incident', 'frontend.forms.help-desk-incident');

Route::view('review-management-report', 'frontend.review-management.review-management-report');



//  ===================== OOS OOT OOC Form Route====================================
Route::view('OOT_form', 'frontend.OOT.OOT_form');
Route::get('out_of_calibration', [OOCController::class, 'index'])->name('ooc.index');
Route::get('OOC/view', [OOCController::class, 'edit'])->name('ooc.edit');
Route::post('ooccreate', [OOCController::class, 'create'])->name('oocCreate');
Route::get('OutofCalibrationShow/{id}', [OOCController::class, 'OutofCalibrationShow'])->name('ShowOutofCalibration');
Route::post('updateOutOfCalibration/{id}', [OOCController::class, 'updateOutOfCalibration'])->name('OutOfCalibrationUpdate');
Route::post('OOCStateChange/{id}', [OOCController::class, 'OOCStateChange'])->name('StageChangeOOC');
Route::post('OOCStateChangetwo/{id}', [OOCController::class, 'OOCStateChangetwo'])->name('StageChangeOOCtwo');
Route::post('OOCStateCancel/{id}', [OOCController::class, 'OOCStateCancel'])->name('OOCCancel');
Route::post('RejectoocStateChange/{id}', [OOCController::class, 'RejectoocStateChange'])->name('RejectStateChangeOOC');
Route::post('OOCChildRoot/{id}', [OOCController::class, 'OOCChildRoot'])->name('o_o_c_root_child');
Route::post('OOCChildCapa/{id}', [OOCController::class, 'oo_c_capa_child'])->name('oo_c_capa_child');
Route::get('OOCAuditTrial/{id}', [OOCController::class, 'OOCAuditTrial'])->name('audittrialooc');
Route::get('auditDetailsooc/{id}', [OOCController::class, 'auditDetailsooc'])->name('OOCauditDetails');
Route::get('/rcms/ooc_Audit_Report/{id}', [OOCController::class, 'auditReportooc'])->name('ooc_Audit_Report');


// KSI Routes
Route::get('/get-process-open-records', [KSIController::class, 'getProcessCounts'])->name('api.getProcessCounts');
Route::get('/drill-chart-stages/{label}', [KSIController::class, 'drillChartStages'])->name('api.drillChartStages.chart');
Route::get('/drill-chart-date-distribution/{process}/{label}', [KSIController::class, 'drillChartDateDistribution'])->name('api.drillChartDateDistribution.chart');
Route::get('/api/action-item/stage-distribution', [KSIController::class, 'getActionItemStageDistribution'])->name('api.actionItem.stageDistribution');
Route::get('/api/audit-program/stage-distribution', [KSIController::class, 'getAuditProgramStageDistribution'])->name('api.AuditProgram.stageDistribution');
Route::get('/api/capa/stage-distribution', [KSIController::class, 'getCAPAStageDistribution'])->name('api.CAPA.stageDistribution');
Route::get('/api/calibration-management/stage-distribution', [KSIController::class, 'getCalibrationManagementStageDistribution'])->name('api.CalibrationManagement.stageDistribution');
Route::get('/api/change-control/stage-distribution', [KSIController::class, 'getChangeControlStageDistribution'])->name('api.ChangeControl.stageDistribution');
Route::get('/api/deviation/stage-distribution', [KSIController::class, 'getDeviationStageDistribution'])->name('api.Deviation.stageDistribution');
Route::get('/api/effectiveness-check/stage-distribution', [KSIController::class, 'getEffectivenessCheckStageDistribution'])->name('api.EffectivenessCheck.stageDistribution');
Route::get('/api/equipment-lcm/stage-distribution', [KSIController::class, 'getEquipmentLCMStageDistribution'])->name('api.EquipmentLCM.stageDistribution');
Route::get('/api/global-capa/stage-distribution', [KSIController::class, 'getGlobalCAPAStageDistribution'])->name('api.GlobalCAPA.stageDistribution');
Route::get('/api/global-change-control/stage-distribution', [KSIController::class, 'getGlobalChangeControlStageDistribution'])->name('api.GlobalChangeControl.stageDistribution');
Route::get('/api/incident/stage-distribution', [KSIController::class, 'getIncidentStageDistribution'])->name('api.Incident.stageDistribution');
Route::get('/api/internal-audit/stage-distribution', [KSIController::class, 'getInternalAuditStageDistribution'])->name('api.InternalAudit.stageDistribution');
Route::get('/api/lab-incident/stage-distribution', [KSIController::class, 'getLabIncidentStageDistribution'])->name('api.LabIncident.stageDistribution');
// Route::get('/api/oos-oot/stage-distribution', [KSIController::class, 'getOOSStageDistribution'])->name('api.OOS.stageDistribution');
Route::get('/api/preventive-maintenance/stage-distribution', [KSIController::class, 'getPreventiveMaintenanceStageDistribution'])->name('api.PreventiveMaintenance.stageDistribution');
Route::get('/api/risk-assessment/stage-distribution', [KSIController::class, 'getRiskAssessmentStageDistribution'])->name('api.RiskAssessment.stageDistribution');
Route::get('/api/root-cause-analysis/stage-distribution', [KSIController::class, 'getRootCauseAnalysisStageDistribution'])->name('api.RootCauseAnalysis.stageDistribution');
Route::get('/api/supplier/stage-distribution', [KSIController::class, 'getSupplierStageDistribution'])->name('api.Supplier.stageDistribution');
Route::get('/api/supplier-audit/stage-distribution', [KSIController::class, 'getSupplierAuditStageDistribution'])->name('api.SupplierAudit.stageDistribution');
Route::get('/api/monthly-distribution/{process}/{label}', [KSIController::class, 'fetchMonthlyDistribution'])->name('api.MonthlyDistribution');
Route::get('/drill-chart-logs/{process}/{label}', [KSIController::class, 'drillChartLogs'])->name('api.drillChartLogs.chart');
Route::get('/kpi-logs/{process}/{label}', [KSIController::class, 'fetchProcessData'])->name('kpi.logs');



Route::get('out_of_calibration_ooc', [OOCController::class, 'ooc']);


// Route::get('oos_form', [OOSController::class, 'index'])->name('oos.index');
// Route::get('oos_micro', [OOSMicroController::class, 'index'])->name('oos_micro.index');



//============================================ OOS MICRO ROUTE CLOSE ===================================
// Route::view('market_complaint_new', 'frontend.market_complaint.market_complaint_new')->name('market_complaint_new');


// ====================OOS/OOT======================================
Route::view('oos_oot_form', 'frontend.forms.OOS\OOT.oos_oot');
// ====================OOS/OOT======================================



// =================LOGS=========================================

Route::view('change_control_log', 'frontend.forms.Logs.changeControlLog');
Route::view('market_complaint_log', 'frontend.forms.Logs.Market-Complaint-registerLog');
Route::view('incident_log', 'frontend.forms.Logs.incidentLog');
Route::view('risk_management_log', 'frontend.forms.Logs.riskmanagementLog');
Route::view('errata_log', 'frontend.forms.Logs.errata_log');
Route::view('laboratory_log', 'frontend.forms.Logs.laboratoryIncidentLog');
Route::view('capa_log', 'frontend.forms.Logs.capa_log');
Route::view('non_conformance_log', 'frontend.forms.Logs.non_conformance_log');
Route::view('deviation_log', 'frontend.forms.Logs.deviation_log');
Route::view('OOC_log', 'frontend.forms.Logs.OOC_log');
Route::view('OOS_OOT_log', 'frontend.forms.Logs.OOS_OOT_log');
Route::view('Failure_invst_log', 'frontend.forms.Logs.Failure_investigation_Log');
Route::view('internal_audit_log', 'frontend.forms.Logs.Internal_audit_Log');

// =================LOGS=========================================




// ====================OOS/OOT======================================
Route::view('oos_oot_form', 'frontend.forms.OOS\OOT.oos_oot');
// ====================OOS/OOT======================================



/**
 * AJAX ROUTES
 */

Route::get('/sop/users/{id?}', [AjaxController::class, 'getSopTrainingUsers'])->name('sop_training_users');

// ========================Errata==================================
// Route::view('errata_new', 'frontend.errata.errata_new')->name('errata_new');
Route::view('errata_view', 'frontend.errata.errata_view');

// <<<<<<< HEAD

// ================EMPLOYEE & TRAINER===================

Route::post('/tms/employee', [EmployeeController::class, 'store'])->name('employee.store');
Route::post('/tms/trainer', [TrainerController::class, 'store'])->name('trainer.store');
Route::post('/tms/employee/{id}', [EmployeeController::class, 'update'])->name('employee.update');
Route::post('/tms/trainer/{id}', [TrainerController::class, 'update'])->name('trainer.update');
Route::get('employee_view/{id}', [EmployeeController::class, 'show'])->name('employee.show');
Route::get('trainer_qualification_view/{id}', [TrainerController::class, 'show'])->name('trainer_qualification.show');
Route::post('/tms/employee/sendstage/{id}', [EmployeeController::class, 'sendStage']);
Route::post('/tms/trainer/sendstage/{id}', [TrainerController::class, 'sendStage']);
Route::post('/tms/trainer/rejectStage/{id}', [TrainerController::class, 'rejectStage']);
Route::get('/getEmployeeDetails/{id}', [TrainerController::class, 'getEmployeeDetails']);

Route::get('/fetch-questionss/{documentId}', [TrainerController::class, 'fetchQuestionss']);
// Route::get('/training-questions/{id}', [TrainerController::class, 'trainingQuestion']);
Route::post('/save-answers', [TrainerController::class, 'saveAnswers']);
Route::get('/get-questions/{documentId}', [TrainerController::class, 'getQuestions']);


// TNI Employee =================================
Route::get('tniemployee_create', [TNIEmployeeController::class, 'index'])->name('tniemployee_create');
Route::post('tniemployee_store', [TNIEmployeeController::class, 'store'])->name('tniemployee.store');
Route::get('tniemployee/show/{id}', [TNIEmployeeController::class, 'show'])->name('tniemployee.show');
Route::put('tniemployee/update/{id}', [TNIEmployeeController::class, 'update'])->name('tniemployee_update');
Route::post('tniemployee/sendstage/{id}', [TNIEmployeeController::class, 'sendStage'])->name('sendStage');
Route::post('tniemployee/cancelstage/{id}', [TNIEmployeeController::class, 'cancelStage'])->name('cancelStage');

//end=======================================

//new one
Route::post('tms/induction/sendstage/{id}', [InductionTrainingController::class, 'sendStage']);
Route::post('tms/induction/cancelstage/{id}', [InductionTrainingController::class, 'cancelStage']);

// =======
Route::get('Tni_create', [TNIController::class, 'index'])->name('Tni_create');
// Route::get('Tni_view/{id}', [EmployeeController::class, 'show'])->name('employee.show');
// Route::post('/tms/employee/{id}', [TNIController::class, 'update'])->name('employee.update');
Route::view('Tni_view', 'frontend.TMS.TNI_TNA.Tni_view');

Route::post('OOCAuditReview/{id}', [OOCController::class, 'OOCAuditReview'])->name('OOCAuditReview');
Route::post('RejectStateChangeTwo/{id}', [OOCController::class, 'RejectStateChangeTwo'])->name('RejectStateChangeTwo');
Route::post('OOCChildExtension/{id}', [OOCController::class, 'OOCChildExtension'])->name('OOCChildExtension');
Route::post('OOCChildAction/{id}', [OOCController::class, 'OOCChildAction'])->name('OOCChildAction');
Route::get('employee_new', [EmployeeController::class, 'createEmp'])->name('employee_new');
//===
Route::post('errata/create{id}', [ErrataController::class, 'create'])->name('errata.create');
Route::post('errata/store', [ErrataController::class, 'store'])->name('errata.store');
Route::get('errata/show/{id}', [ErrataController::class, 'show'])->name('errata.show');
// Route::get('errata/edit/{id}', [ErrataController::class, 'edit'])->name('errata.edit');
Route::put('errata/update/{id}', [Erratacontroller::class, 'update'])->name('errata.update');
Route::get('errataaudittrail/{id}', [ErrataController::class, 'AuditTrial'])->name('errata.audittrail');
Route::get('errataAuditInner/{id}', [ErrataController::class, 'auditDetailsErrata'])->name('errataauditdetails');
Route::post('/errata/cancel/{id}', [ErrataController::class, 'erratacancelstage'])->name('errata.cancel');
Route::get('errata_new', [ErrataController::class, 'index'])->name('errata_new');
Route::get('/errata/{id}',[Erratacontroller::class,'audit_trail_filter'])->name('api.ERRATA.filter');
// ----------------------Stages----------------------------------------

Route::get('/supplier_audit_index', [SupplierAuditController::class, 'supplier_audit'])->name('supplier_audit_index');
Route::get('showSupplierAudit/{id}', [SupplierAuditController::class, 'show'])->name('showSupplierAudit');
Route::post('supplier_audit_store', [SupplierAuditController::class, 'create'])->name('supplier_audit_store');
Route::post('updateSupplierAudit/{id}', [SupplierAuditController::class, 'update'])->name('updateSupplierAudit');
Route::post('SupplierAuditStateChange_view/{id}', [SupplierAuditController::class, 'SupplierAuditStateChange'])->name('SupplierAuditStateChange_view');
Route::post('SupplierAuditRejectState/{id}', [SupplierAuditController::class, 'SupplierAuditRejectState'])->name('SupplierAuditRejectState');
Route::post('CancelStateSupplierAudit/{id}', [SupplierAuditController::class, 'CancelStateSupplierAudit'])->name('CancelStateSupplierAudit');
Route::get('AuditTrialSupplierShow/{id}', [SupplierAuditController::class, 'AuditTrialSupplierShow'])->name('ShowexternalAuditTrials');
Route::get('ExternalAuditTrialDetails/{id}', [SupplierAuditController::class, 'AuditTrialExternalDetails'])->name('ExternalAuditTrialDetailsShow');
Route::post('child_external_Supplier/{id}', [SupplierAuditController::class, 'child_external_Supplier'])->name('child_external_Supplier');
Route::get('rcms/auditReport/{id}', [SupplierAuditController::class, 'auditReport'])->name('SupplierAuditTrialReport');
Route::get('rcms/singleReport/{id}', [SupplierAuditController::class, 'singleReport'])->name('SupplierSingleReport');
Route::get('SupplierAuditActivityLog/{id}', [SupplierAuditController::class, 'supplierAuditActivityLog']);


// extensionchild========================
// Route::view('extension_new', 'frontend.extension.extension_new');
// Route::view('extension_view', 'frontend.extension.extension_view');
Route::get('extension-new', [ExtensionNewController::class, 'index']);
Route::post('extension_new', [ExtensionNewController::class, 'store'])->name('extension_new.store');
Route::get('extension_newshow/{id}', [ExtensionNewController::class, 'show']);
Route::get('/extension/export-csv', [ExtensionNewController::class, 'exportCsv'])->name('export.csv.extension');
Route::get('/extension/export-excel', [ExtensionNewController::class, 'exportExcel'])->name('export.excel.extension');

Route::put('extension_new/{id}', [ExtensionNewController::class, 'update'])->name('extension_new.update');
Route::post('extension_send_stage/{id}', [ExtensionNewController::class, 'sendstage'])->name('extension_send_stage');
Route::post('extension_reject_stage/{id}', [ExtensionNewController::class, 'rejectStage'])->name('extension_reject_stage');
Route::post('moreinfoState_extension/{id}', [ExtensionNewController::class, 'moreinfoStateChange'])->name('moreinfoState_extension');
Route::post('RejectState_extension/{id}', [ExtensionNewController::class, 'reject'])->name('RejectState_extension');
Route::post('send-cqa/{id}', [ExtensionNewController::class, 'sendCQA'])->name('send-cqa');
Route::post('send-approved/{id}', [ExtensionNewController::class, 'sendApproved'])->name('send-approved');
Route::get('extension-filter-data/{id}', [ExtensionNewController::class, 'audit_trail_filter'])->name('extension-filter');
// Route::get('RejectState_extension/{id}', [ExtensionNewController::class, 'reject'])->name('RejectState_extension');


Route::get('trainer_qualification', [TrainerController::class, 'index'])->name('trainer_qualification');

Route::get('/test-sms', function() {
    // Account details
	$apiKey = urlencode('NTE3ODc4NDk0ZTRiNjI1MTY1NjI3NDRjNzc3NDZiNjg=');
	
	// Message details
	$numbers = array(919425959395, 917354654474);
	$sender = urlencode('VIDYAGXP');
	$message = rawurlencode('You are absent today. Aage se dhyan rakhna gandu');
 
	$numbers = implode(',', $numbers);
 
	// Prepare data for POST request
	$data = array('apikey' => $apiKey, 'numbers' => $numbers, "sender" => $sender, "message" => $message);
 
	// Send the POST request with cURL
	$ch = curl_init('https://api.textlocal.in/send/');
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$response = curl_exec($ch);
	curl_close($ch);
	
	// Process your response here
	return $response;
});
// ====================SOP Index==============
Route::view('sop-index-show', 'frontend.sop-index.sop-index-show');
Route::view('capa-show', 'frontend.sop-index.capa-show');
Route::view('extensions-show', 'frontend.sop-index.extensions-show');
Route::view('cc-show', 'frontend.sop-index.cc-index-show');
Route::view('rca-show', 'frontend.sop-index.rca-show');
Route::view('action-item-show', 'frontend.sop-index.action-item-show');
Route::view('effectiveness-checks', 'frontend.sop-index.effectiveness-checks-show');



// Route::get('cc_show', [ReportController::class, 'index']);


//=====================================================================
// >>>>>>> B-backup



// ================================= Supplier Audit========================================================
// Route::view('supplier_audit', 'frontend.New_forms.supplier_audit');
// Route::get('/regulatory_inspection_index', [RegulatoryController::class, 'regulatory_inspection'])->name('regulatory_inspection_index');
// Route::get('showregulatory/{id}', [RegulatoryController::class, 'show'])->name('showregulatory');
// Route::post('regulatory_audit_store', [RegulatoryController::class, 'create'])->name('regulatory_audit_store');
// Route::post('regulatoryUpdate/{id}', [RegulatoryController::class, 'update'])->name('regulatoryUpdate');
// Route::post('SupplierAuditStateChange_view/{id}', [RegulatoryController::class, 'SupplierAuditStateChange'])->name('SupplierAuditStateChange_view');
// Route::post('RejectStateAuditee/{id}', [RegulatoryController::class, 'RejectStateAuditee'])->name('RejectStateAuditee');
// Route::post('CancelStateRegulatoryInspection/{id}', [RegulatoryController::class, 'CancelStateRegulatoryInspection'])->name('CancelStateRegulatoryInspection');
// Route::get('AuditTrialSupplierShow/{id}', [RegulatoryController::class, 'AuditTrialSupplier'])->name('ShowexternalAuditTrials');
// Route::get('ExternalAuditTrialDetails/{id}', [RegulatoryController::class, 'AuditTrialExternalDetails'])->name('ExternalAuditTrialDetailsShow');
// Route::post('child_external_Supplier/{id}', [RegulatoryController::class, 'child_external_Supplier'])->name('child_external_Supplier');
// Route::get('rcms/auditReport/{id}', [RegulatoryController::class, 'auditReport'])->name('SupplierAuditTrialReport');
// Route::get('rcms/regulatorySingleReport/show/{id}', [RegulatoryController::class, 'singleReportShow'])->name('regulatory.single.report.show');
// Route::get('rcms/regulatorySingleReport/{id}', [RegulatoryController::class, 'regulatorySingleReport'])->name('regulatorySingleReport');
// Route::get('rcms/regulatoryInspectionFamilyReport/{id}', [RegulatoryController::class, 'familyReport'])->name('regulatoryInspectionFamilyReport');


//=================Critical-Action================================
Route::get('critical-action', [CriticalActionController::class,'index'])->name('critical-action');
Route::post('critical-action-store', [CriticalActionController::class,'store'])->name('critical-action-store');
Route::get('critical-action-view/{id}', [CriticalActionController::class,'show'])->name('critical-action-view');
Route::put('critical-action-update/{id}', [CriticalActionController::class,'update'])->name('critical-action-update');
Route::post('send-At/{id}', [CriticalActionController::class, 'stageChange']);
Route::post('critical-action-cancelstage/{id}', [CriticalActionController::class, 'actionStageCancel']);
Route::get('critical-action-audittrialshow/{id}', [CriticalActionController::class, 'actionItemAuditTrialShow'])->name('critial.showActionItemAuditTrial');
Route::get('critical-action-SingleReport/{id}', [CriticalActionController::class, 'singleReport'])->name('critial.actionitemSingleReport');
Route::get('critical-action-AuditReport/{id}', [CriticalActionController::class, 'auditReport'])->name('critial.actionitemAuditReport');
// EquipmentLifecycleManagementController
Route::get('EquipmentInformation', [EquipmentLifecycleManagementController::class, 'index']);
Route::get('showEquipmentInfo/{id}', [EquipmentLifecycleManagementController::class, 'show'])->name('showEquipmentInfo');
Route::post('EquipmentInfo_store', [EquipmentLifecycleManagementController::class, 'EquipmentInfo_store'])->name('EquipmentInfo_store');
Route::post('updateEquipmentInfo/{id}', [EquipmentLifecycleManagementController::class, 'update'])->name('updateEquipmentInfo');
Route::post('EquipmentStateChange/{id}', [EquipmentLifecycleManagementController::class, 'EquipmentStateChange'])->name('EquipmentStateChange');
Route::post('RejectEquipment/{id}', [EquipmentLifecycleManagementController::class, 'RejectEquipment'])->name('RejectEquipment');
Route::post('EquipmentCancel/{id}', [EquipmentLifecycleManagementController::class, 'EquipmentCancel'])->name('EquipmentCancel');
Route::post('RejectEquipmentReQualification/{id}', [EquipmentLifecycleManagementController::class, 'RejectEquipmentReQualification'])->name('RejectEquipmentReQualification');
Route::get('EquipmentInfoAuditTrail/{id}', [EquipmentLifecycleManagementController::class, 'EquipmentInfoAuditTrail'])->name('EquipmentInfoAuditTrail');
Route::post('equipmentChild/{id}', [EquipmentLifecycleManagementController::class, 'equipmentChild'])->name('equipmentChild');

  //****************************************Equipment Lifecycle Log**************************************** */
  Route::get('export-csvequipment', [EquipmentLifecycleManagementController::class, 'equipment_exportcsv'])->name('export.equipment.csv');
  Route::get('export-excelequipment', [EquipmentLifecycleManagementController::class, 'equipment_exportExcel'])->name('export.equipment.excel');
  
  Route::get('export-csvanalytics', [AnalyticsController::class, 'analytics_exportcsv'])->name('export.analytics.csv');
  Route::get('export-excelanalytics', [AnalyticsController::class, 'analytics_exportExcel'])->name('export.analytics.excel');
  
 // Limscountdashshboard
 Route::get('Limsanalyticsdashboard', [LimsDashboardController::class, 'index']);



Route::get('analyst_qualification', [AnalystController::class, 'index'])->name('analyst_qualification');

//=====================================================================
// >>>>>>> B-backup

Route::post('RCAChildRoot/{id}', [RootCauseController::class, 'RCAChildRoot'])->name('R_C_A_root_child');
// ====================induction training =================
Route::get('job_training',[JobTrainingController::class ,'index'])->name('job_training');
Route::get('job_training/show/{id}',[JobTrainingController::class ,'edit'])->name('job_training_view');
Route::post('tms/jobTraining/cancelstage/{id}',[JobTrainingController::class ,'cancelStage']);
Route::get('/get-sop-description/{id}', [JobTrainingController::class, 'getSopDescription']);

Route::get('/fetch-questions/{documentId}', [JobTrainingController::class, 'fetchQuestions']);

Route::get('trainingQuestions/{id}/', [JobTrainingController::class, 'trainingQuestions']);
Route::get('/training_certificate', [JobTrainingController::class, 'showCertificate']);


Route::post('job_trainingcreate', [JobTrainingController::class, 'store'])->name('job_trainingcreate');
Route::put('job_trainingupdate/{id}', [JobTrainingController::class, 'update'])->name('job_trainingupdate');
Route::get('/employees/{id}', [JobTrainingController::class, 'getEmployeeDetail']);
// Route::get('job_training-details/{id}', [JobTrainingController::class, 'viewrendersop']);
Route::get('job_training-details/{id}/{total_minimum_time}/{per_screen_running_time}/{job_training_id}/{sop_spent_time}', [JobTrainingController::class, 'viewrendersop']);
Route::get('tni_matrix_training-details/{id}/{total_minimum_time}/{per_screen_running_time}/{job_training_id}/{sop_spent_time}', [TNIController::class, 'viewrendersop']);

Route::get('question_training/{id}', [JobTrainingController::class, 'questionrendersop']);
Route::get('on_the_job_question_training/{id}/{job_id}', [JobTrainingController::class, 'questionshow']);
Route::get('job_training_certificate/{id}', [JobTrainingController::class, 'showJobCertificate']);

Route::post('/check-answer-otj', [JobTrainingController::class, 'checkAnswerOtj'])->name('check_answer_otj');



// ============================================
// ====================Classroom Based Training =================
Route::get('classroom_training',[ClassroomTrainingController::class ,'index'])->name('classroom_training');
Route::get('classroom_training/show/{id}',[ClassroomTrainingController::class ,'edit'])->name('classroom_training_view');
Route::post('tms/classroomTraining/cancelstage/{id}',[ClassroomTrainingController::class ,'cancelStage']);
Route::get('/get-sop-description/{id}', [ClassroomTrainingController::class, 'getSopDescription']);

Route::get('/fetch-questions/{documentId}', [ClassroomTrainingController::class, 'fetchQuestions']);

Route::get('trainingQuestions/{id}/', [ClassroomTrainingController::class, 'trainingQuestions']);
Route::get('/training_certificate', [ClassroomTrainingController::class, 'showCertificate']);
Route::get('classroom_training_certificate/{id}', [ClassroomTrainingController::class, 'showClassroomCertificate']);


Route::post('classroom_trainingcreate', [ClassroomTrainingController::class, 'store'])->name('classroom_trainingcreate');
Route::put('classroom_trainingupdate/{id}', [ClassroomTrainingController::class, 'update'])->name('classroom_trainingupdate');
Route::get('/employees/{id}', [ClassroomTrainingController::class, 'getEmployeeDetail']);
Route::get('classroom_training-details/{id}/{total_minimum_time}/{per_screen_running_time}/{job_training_id}/{sop_spent_time}', [ClassroomTrainingController::class, 'viewrendersop']);
Route::get('question_training/{id}', [ClassroomTrainingController::class, 'questionrendersop']);
Route::get('on_the_classroom_question_training/{id}/{job_id}', [ClassroomTrainingController::class, 'questionshow']);

Route::get('classroom_training_certificate/{id}', [ClassroomTrainingController::class, 'showClassroomCertificate']);

Route::post('/check-answer-classroom', [ClassroomTrainingController::class, 'checkAnswerOtj'])->name('check_answer_classroom');
Route::post('/check-answer-sop', [TMSController::class, 'checkAnswerSOP'])->name('check_answer_sop');



// Graph
Route::get('training-analytics', [TMSController::class, 'analyticsShow'])->name('training_analytics');
// Route::get('designation-analytics', [TMSController::class, 'designationanalyticsShow']);
Route::get('documents/viewpdfdocument/{id}', action: [DocumentController::class, 'viewPdfDocument']);
Route::get('equipmentlifecycle-training-detail/{id}/{total_minimum_time}/{per_screen_running_time}/{job_training_id}/{sop_spent_time}', [EquipmentLifecycleManagementController::class, 'viewrendersop']);
Route::post('save-equipmentlifecycle-reading-time', [EquipmentLifecycleManagementController::class, 'saveReadingTime']);
Route::get('equipmentQuestionShow/{documentNumber}/{equipmentId}', [EquipmentLifecycleManagementController::class, 'equipmentQuestionShow']);
Route::post('/check-answer-equipment', [EquipmentLifecycleManagementController::class, 'checkAnswerequipment'])->name('check_answer_equipment');

 
// ----------------------------------Receipt--------------------------------

Route::get('receipt', [ ReceiptController::class, 'index'])->name('receipt');
Route::post('receipt_store', [ ReceiptController::class, 'receipt_store'])->name('receipt_store');
Route::get('showreceipt/{id}', [ ReceiptController::class, 'show'])->name('showreceipt');
Route::post('updatereceipt/{id}', [ ReceiptController::class, 'update'])->name('updatereceipt');
Route::post('receiptStateChange/{id}', [ ReceiptController::class, 'receiptStateChange'])->name('receiptStateChange');
Route::post('receiptSecondStateChange/{id}', [ ReceiptController::class, 'receiptSecondStateChange'])->name('receiptSecondStateChange');
Route::post('receiptCancel/{id}',  [ ReceiptController::class, 'receiptCancel'])->name('receiptCancel');
Route::post('MoreInfoReceipt/{id}', [ ReceiptController::class, 'MoreInfoReceipt'])->name('MoreInfoReceipt');
Route::get('dissolutionreport/{id}', [ ReceiptController::class, 'dissolution_report'])->name('dissolutionreport');
Route::get('detailstandardanalysis/{id}', [ ReceiptController::class, 'detailstandardanalysis'])->name('detailstandardanalysis');
Route::get('AssayTestingReport/{id}', [ReceiptController::class, 'AssayTestingReport'])->name('AssayTestingReport');
Route::get('ReceiptAuditTrail/{id}', [ ReceiptController::class, 'ReceiptAuditTrail'])->name('ReceiptAuditTrail');
Route::get('ReceiptAuditReport/{id}', [ReceiptController::class, 'Receipt_auditreport'])->name('ReceiptAuditReport');
Route::get('ReceiptSingleReport/{id}', [ReceiptController::class, 'Receipt_singlereport'])->name('ReceiptSingleReport');


// ============================== Task Management =========================================
Route::get('task-management', [ TaskManagementController::class, 'task_management'])->name('task_management');
Route::post('task-management-store', [TaskManagementController::class, 'task_management_store'])->name('task_management_store');
Route::get('task_management_show/{id}', [TaskManagementController::class, 'task_management_show'])->name('task_management_show');
Route::post('task_management_update/{id}', [ TaskManagementController::class, 'taskManagementUpdate'])->name('task_management_update');
Route::get('TaskManagementAuditTrail/{id}', [ TaskManagementController::class, 'AuditTrailTask'])->name('TaskManagementAuditTrail');
Route::post('taskManagementSendStage/{id}', [TaskManagementController::class, 'taskManagementSendStage'])->name('taskManagementSendStage');



Route::get('/companies', [CompanyController::class, 'index']);
Route::post('/companies', [CompanyController::class, 'store']);
Route::post('/companies/{id}/holidays', [CompanyController::class, 'storeHolidays']);
// Route::get('/companies/{id}/holidays', [CompanyController::class, 'storeHolidays']);
Route::get('/companies/{id}/holidays', [CompanyController::class, 'getHolidays']);
Route::delete('/holidays/{id}', [CompanyController::class, 'deleteHoliday']);
Route::get('/holidays', [CompanyController::class, 'showHolidays'])->name('showHolidays');



