<?php

namespace App\Http\Controllers;

use App\Models\DepartmentWiseEmployees;
use App\Models\Employee;
use App\Models\Document;
use Crypt;
use Helpers;
use App\Models\DocumentTraining;
use App\Models\Training;
use App\Models\Quize;
use App\Models\Question;
use App\Models\EmpTrainingQuizResult;
use App\Models\QuestionariesGrid;
use App\Models\DepartmentDocumentNumbers;
use App\Models\DWSEAuditTrail;
use App\Models\RoleGroup;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\App;
use App\Models\User;
use PDF;
use Carbon\Carbon;


class DepartmentWiseController extends Controller
{

        public function index(){
            $emp = Employee::all();
            $data = Document::all();
            $users = User::all();
            return view('frontend.TMS.department-wise.create',compact('emp','data','users'));
        }

        public function fetchEmployees(Request $request)
        {
            $department = $request->query('department');
            $employees = Employee::where('department', $department)->get(['id', 'employee_name']);

            return response()->json($employees);
        }

        public function create(Request $request)
        {
            $data = new DepartmentWiseEmployees(); 
            $data->location = $request->location;
            $data->Prepared_by = $request->Prepared_by;
            $data->Prepared_date = $request->Prepared_date;
            $data->total_minimum_time = $request->total_minimum_time ?? 0;
            $data->per_screen_run_time = $request->per_screen_run_time ?? 0;
            $data->reviewer = $request->reviewer;
            $data->approver = $request->approver;
            $data->start_date = $request->start_date;
            $data->end_date = $request->end_date;
            $data->department = $request->department;
            $data->document_number = implode(',', $request->document_number);

            $data->year = $request->year;
            $data->employee_name = $request->employee_name;
            $data->employee_code = Helpers::getEmpNameById($request->employee_name);
            $data->job_role = $request->job_role;

            $data->status = "Opened";
            $data->stage = 1;

            $data->save();

            return redirect(url('TMS'));

            
        }
    


            public function show($id)
        {
            $employees = Employee::select('id', 'employee_name', 'full_employee_id')->get();
            $emp = Employee::all();

            $dwe = DepartmentWiseEmployees::find($id);
            $ref_doc = Document::all();

            $employees = Employee::where('department', $dwe->department)->get();

            // $selectedJobRoles = explode(',', $dwe->job_role);
            $selectedJobRoles = $dwe->job_role ? explode(',', $dwe->job_role) : [];


            $selectedDocumentNumbers = $dwe->document_number ? explode(',', $dwe->document_number) : [];
            // $selectedDocumentNumbers = $dwe->document_number ? json_decode($dwe->document_number, true) : [];


            return view('frontend.TMS.department-wise.department_wise_view', compact('employees', 'dwe', 'emp', 'ref_doc', 'selectedJobRoles', 'selectedDocumentNumbers'));
        }


            public function update(Request $request, $id)
        {
            $data = DepartmentWiseEmployees::findOrFail($id);

            $data->location = $request->location;
            $data->Prepared_by = $request->Prepared_by;
            $data->Prepared_date = $request->Prepared_date;
            $data->total_minimum_time = $request->total_minimum_time ?? 0;
            $data->per_screen_run_time = $request->per_screen_run_time ?? 0;
            $data->department = $request->department;
            $data->reviewer = $request->reviewer;
            $data->approver = $request->approver;
            $data->start_date = $request->start_date;
            $data->end_date = $request->end_date;
            // // $data->total_minimum_time = $request->total_minimum_time ?? 0;
            // // $data->per_screen_run_time = $request->per_screen_run_time ?? 0;
            $data->reviewer_remark = $request->reviewer_remark;
            $data->reviewer_remark_attachment = $request->reviewer_remark_attachment;
            // $data->document_number = $request->document_number;
            $data->document_number = implode(',', $request->document_number); 
            $data->year = $request->year;
            $data->employee_name = $request->employee_name;
            $data->employee_code = Helpers::getEmpNameById($request->employee_name);
            $data->job_role = implode(',', $request->job_role); 

            if ($request->hasFile('reviewer_remark_attachment')) {
                $file = $request->file('reviewer_remark_attachment');
                $name = $request->employee_id . 'reviewer_remark_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                $file->move('upload/', $name);
                $data->reviewer_remark_attachment = $name;
            }

            if ($request->hasFile('approval_remark_attachment')) {
                $file = $request->file('approval_remark_attachment');
                $name = $request->employee_id . 'approval_remark_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                $file->move('upload/', $name);
                $data->approval_remark_attachment = $name;
            }

            $data->save();

            return redirect()->route('departmentwise_view', ['id' => $id])->with('success', 'Record updated successfully');
        }



        public function stageChange(Request $request, $id){
        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $dwse = DepartmentWiseEmployees::find($id);
            $lastDocument = DepartmentWiseEmployees::find($id);

            if ($dwse->stage == 1) {
                $dwse->stage = "2";
                $dwse->status = "In Review";
                $dwse->submitted_by = Auth::user()->name;
                $dwse->submitted_on = Carbon::now();
                $dwse->submitted_comment = $request->comment;

                $history = new DWSEAuditTrail();
                $history->dwse_id = $id;
                $history->activity_type = 'Submit By, Submit On';
                if (is_null($lastDocument->submitted_by) || $lastDocument->submitted_by === '') {
                    $history->previous = "NULL";
                } else {
                    $history->previous = $lastDocument->submitted_by . ' , ' . $lastDocument->submitted_on;
                }
                $history->current = $dwse->submitted_by . ' , ' . $dwse->submitted_on;
                if (is_null($lastDocument->submitted_by) || $lastDocument->submitted_on === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->action = 'Submit';
                $history->comment = $request->comments;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to = "In Review";
                $history->change_from = $lastDocument->status;
                $history->stage = '';
                $history->save();
                $dwse->update();
                return back();
            }

            if ($dwse->stage == 2) {
                $dwse->stage = "3";
                $dwse->status = "For Approval";
                $dwse->reviewed_by = Auth::user()->name;
                $dwse->reviewed_on = Carbon::now();
                $dwse->reviewed_comment = $request->comment;

                $history = new DWSEAuditTrail();
                $history->dwse_id = $id;
                $history->activity_type = 'Reviewed By, Reviewed On';
                if (is_null($lastDocument->reviewed_by) || $lastDocument->reviewed_by === '') {
                    $history->previous = "NULL";
                } else {
                    $history->previous = $lastDocument->reviewed_by . ' , ' . $lastDocument->reviewed_on;
                }
                $history->current = $dwse->reviewed_by . ' , ' . $dwse->reviewed_on;
                if (is_null($lastDocument->reviewed_by) || $lastDocument->reviewed_on === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->action = 'Reviewed';
                $history->comment = $request->comments;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to = "For Approval";
                $history->change_from = $lastDocument->status;
                $history->stage = '';
                $history->save();

                $dwse->update();
                return back();
            }

            if ($dwse->stage == 3) {
                $dwse->stage = "4";
                $dwse->status = "Closed - Done";
                $dwse->approved_by = Auth::user()->name;
                $dwse->approved_on = Carbon::now();
                $dwse->approved_comment = $request->comment;

                $dwse->training_effective = true;

                $history = new DWSEAuditTrail();
                $history->dwse_id = $id;
                $history->activity_type = 'Approved By, Approved On';
                if (is_null($lastDocument->approved_by) || $lastDocument->approved_by === '') {
                    $history->previous = "NULL";
                } else {
                    $history->previous = $lastDocument->approved_by . ' , ' . $lastDocument->approved_on;
                }
                $history->current = $dwse->approved_by . ' , ' . $dwse->approved_on;
                if (is_null($lastDocument->approved_by) || $lastDocument->approved_on === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->action = 'Approved';
                $history->comment = $request->comments;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to = "Closed - Done";
                $history->change_from = $lastDocument->status;
                $history->stage = '';
                $history->save();

                $documentNumbers = explode(',', $dwse->document_number);

                foreach ($documentNumbers as $docNumber) {
                    
                    $docData = new DepartmentDocumentNumbers();
                    $docData->department_employee_id = $dwse->id;
                    $docData->location = $dwse->location;
                    $docData->Prepared_by = $dwse->Prepared_by;
                    $docData->Prepared_date = $dwse->Prepared_date;
                    $docData->total_minimum_time = $dwse->total_minimum_time ?? 0;
                    $docData->per_screen_run_time = $dwse->per_screen_run_time ?? 0;
                    $docData->reviewer = $dwse->reviewer;
                    $docData->approver = $dwse->approver;
                    $docData->start_date = $dwse->start_date;
                    $docData->end_date = $dwse->end_date;
                    $docData->department = $dwse->department;
                    $docData->document_number = $docNumber;
                    $docData->year = $dwse->year;
                    $docData->training_effective = true;
                    $docData->employee_name = $dwse->employee_name;
                    $docData->employee_code = $dwse->employee_code;
                    $docData->job_role = $dwse->job_role;
                    $docData->save();
                }

                $dwse->update();
                return back();
            }
            } else {
                toastr()->error('E-signature Not match');
                return back();
            }
        }

    

        public function stageReject(Request $request, $id)
        {
            if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $dwse = DepartmentWiseEmployees::find($id);
            $lastDocument = DepartmentWiseEmployees::find($id);
    
            if ($dwse->stage == 1) {
                $dwse->stage = "0";
                $dwse->status = "Closed-Cancelled";
                $dwse->cancelled_by = Auth::user()->name;
                $dwse->cancelled_on = Carbon::now();
                $dwse->cancelled_comment = $request->comment;
    
                $dwse->update();
                return back();
            }
    
            if ($dwse->stage == 2) {
                $dwse->stage = "1";
                $dwse->status = "Opened";
                $dwse->inReviewToOpened_by = Auth::user()->name;
                $dwse->inReviewToOpened_on = Carbon::now();
                $dwse->inReviewToOpened_comment = $request->comment;
    
                $dwse->update();
                return back();
            }
    
            if ($dwse->stage == 3) {
                $dwse->stage = "2";
                $dwse->status = "In Review";
                $dwse->approvalToReview_by = Auth::user()->name;
                $dwse->approvalToReview_on = Carbon::now();
                $dwse->approvalToReview_comment = $request->comment;
    
                $dwse->update();
                return back();
            }
            } else {
                toastr()->error('E-signature Not match');
                return back();
            }
        }

        public function report($id)
        {
                $data = DepartmentWiseEmployees::find($id);
                if (!empty($data)) {
                    $data->originator_id = User::where('id', $data->initiator_id)->value('name');
                    $pdf = App::make('dompdf.wrapper');
                    $time = Carbon::now();
                    $pdf = PDF::loadView('frontend.TMS.department-wise.departmentreport', compact('data'))
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
                    $canvas->page_script('$pdf->set_opacity(0.1,"Multiply");');
                    $canvas->page_text($width / 4, $height / 2, $data->status, null, 25, [0, 0, 0], 2, 6, -20);
                    return $pdf->stream('example.pdf' . $id . '.pdf');
                }
        }

        public function department_wise_report(Request $request)
        {
            $department = [];
            $dpwe= DepartmentWiseEmployees::all();
            return view('frontend.layout.department_wise_report', compact('dpwe','department'));

        }

        public function viewrendersopjobrole($id){
            return view('frontend.TMS.department-wise.department_wise_details', compact('id'));
        }


        
        // public function departmentwisequestionshow($sopids, $departmentwiseid){
        //     $departmentwiseid = DepartmentWiseEmployees::find($departmentwiseid);
        //     $departmentwiseid->attempt_count = $departmentwiseid->attempt_count == -1 ? 0 : ( $departmentwiseid->attempt_count == 0 ? 0 : $departmentwiseid->attempt_count - 1);
        //     $departmentwiseid->save();
            
        //     $sopids = array_map('trim', explode(',', $sopids));
    
        //     $questions = Question::whereIn('document_id', $sopids)
        //     ->inRandomOrder() 
        //     ->take(10)      
        //     ->get();

        //     $document_number = $departmentwiseid->document_number ?? null; 
        //     // Dump the questions for debugging
        //         return view('frontend.TMS.department-wise.department_wise_question_answer', compact('questions', 'departmentwiseid','document_number'));
        // }
    
        // public function checkAnswerDepartmentWise(Request $request)
        // {
    
        //     $allQuestions = Question::inRandomOrder()->get();
    
        //     // Filter questions to include only Single and Multi Selection Questions
        //     $filteredQuestions = $allQuestions->filter(function ($question) {
        //         return in_array($question->type, ['Single Selection Questions', 'Multi Selection Questions']);
        //     });
    
        //     // Take the first 10 questions from the filtered list
        //     $questions = $filteredQuestions->take(10);
    
        //     $correctCount = 0; // Initialize correct answer count
        //     $totalQuestions = count($questions); // Total number of selected questions (should be 10)
    
        //     foreach ($questions as $question) {
        //         // Retrieve user's answer for each question
        //         $userAnswer = $request->input('question_' . $question->id);
        //         $correctAnswers = unserialize($question->answers); // Correct answers for the question
        //         $questionType = $question->type;
    
        //         if ($questionType === 'Single Selection Questions') {
        //             // If it's a single selection question, check if the user's answer matches the correct answer
        //             if ($userAnswer == $correctAnswers[0]) {
        //                 $correctCount++;
        //             }
        //         } elseif ($questionType === 'Multi Selection Questions') {
        //             // If it's a multi-selection question, check if the user's answer matches exactly with the correct answer set
        //             if (is_array($userAnswer)) {
        //                 // Check if the user's answer matches exactly with the correct answer set
        //                 if (count(array_diff($correctAnswers, $userAnswer)) === 0 && count(array_diff($userAnswer, $correctAnswers)) === 0) {
        //                     $correctCount++;
        //                 }
        //             }
        //         }
        //     }
    
        //     // Calculate the correct percentage for the 10 questions
        //     $score = ($correctCount / $totalQuestions) * 100; // This will be based on 10 questions
    
        
        //     $result = $score >= 80 ? 'Pass' : 'Fail';
    
        //     if($request->attempt_count == 0 || $result == 'Pass'){
        //         $deptwise = DepartmentWiseEmployees::find($request->training_id);
        //         // $induction->stage = 3;
        //         // $induction->status = "Evaluation";
        //         $deptwise->update();
        //     }
    
        //         $storeResult = new EmpTrainingQuizResult();
        //         $storeResult->emp_id = $request->emp_id;
        //         $storeResult->training_id = $request->training_id;
        //         $storeResult->employee_name = $request->employee_name;
        //         $storeResult->training_type = "Department Wise Job Role";
        //         $storeResult->correct_answers = $correctCount;
        //         $storeResult->incorrect_answers = $totalQuestions - $correctCount;
        //         $storeResult->total_questions = $totalQuestions;
        //         $storeResult->score = $score."%";
        //         $storeResult->result = $result;
        //         $storeResult->attempt_number = $request->attempt_count + 1;
        //         $storeResult->save();        
    
        //     return view('frontend.TMS.department-wise.department_wise_quize_result', [
        //         'totalQuestions' => $totalQuestions, // Total questions shown
        //         'correctCount' => $correctCount, // Number of correctly answered questions
        //         'score' => $score, // Final score for these 10 questions
        //         'result' => $result // Pass or Fail based on 80%
        //     ]);
        // }



        public function departmentwisequestionshow($sopids, $departmentwiseid)
        {
            $departmentwiseid = DepartmentWiseEmployees::find($departmentwiseid);
            
            $departmentwiseid->attempt_count = $departmentwiseid->attempt_count == -1 ? 0 : ($departmentwiseid->attempt_count == 0 ? 0 : $departmentwiseid->attempt_count - 1);
            $departmentwiseid->save();
            $singleSOPId = $sopids;
            $sopids = array_map('trim', explode(',', $sopids));

            // $questions = Question::whereIn('document_id', $sopids)
            //     ->where('document_id', $departmentwiseid->document_number)
            //     ->inRandomOrder() 
            //     ->take(10)      
            //     ->get();
            $questions = Question::whereIn('document_id', $sopids)
                ->inRandomOrder() 
                ->take(10)      
                ->get();

                
            $document_number = $departmentwiseid->document_number ?? null;

            return view('frontend.TMS.department-wise.department_wise_question_answer', compact('questions', 'departmentwiseid', 'document_number', 'singleSOPId'));
        }

        public function checkAnswerDepartmentWise(Request $request)
        {
            // Fetch all questions based on the training_id (training_id corresponds to department-wise job role)
            $allQuestions = Question::where('document_id', $request->document_number)
                                    ->inRandomOrder()
                                    ->get();
        
            $document_number = $request->input('document_number');
            
            // Filter questions to include only Single and Multi Selection Questions
            $filteredQuestions = $allQuestions->filter(function ($question) {
                return in_array($question->type, ['Single Selection Questions', 'Multi Selection Questions']);
            });
        
            // Take the first 10 questions from the filtered list
            $questions = $filteredQuestions->take(10);
        
            $correctCount = 0; // Initialize correct answer count
            $totalQuestions = count($questions); // Total number of selected questions (should be 10)
        
            // Iterate over the questions and check answers
            foreach ($questions as $question) {
                $userAnswer = $request->input('question_' . $question->id);
                $correctAnswers = unserialize($question->answers); // Correct answers for the question
                $questionType = $question->type;
        
                // Check answer based on question type
                if ($questionType === 'Single Selection Questions') {
                    if ($userAnswer == $correctAnswers[0]) {
                        $correctCount++;
                    }
                } elseif ($questionType === 'Multi Selection Questions') {
                    if (is_array($userAnswer)) {
                        if (count(array_diff($correctAnswers, $userAnswer)) === 0 && count(array_diff($userAnswer, $correctAnswers)) === 0) {
                            $correctCount++;
                        }
                    }
                }
            }
        
            // Calculate score based on correct answers
            $score = ($correctCount / $totalQuestions) * 100;
            $result = $score >= 80 ? 'Pass' : 'Fail';
        
            // Retrieve the last EmpTrainingQuizResult entry for the specific training_id and document_number
            $existingResult = EmpTrainingQuizResult::where([
                ['training_id', '=', $request->training_id],
                ['document_number', '=', $document_number],
                ['emp_id', '=', $request->emp_id]
            ])->latest()->first();
        
            // If no existing result found, set attempt_number to 1, otherwise increment the last attempt number for this specific document_number
            $attemptNumber = $existingResult ? $existingResult->attempt_number + 1 : 1;
        
            // Save the result in the emp_training_quiz_results table
            $storeResult = new EmpTrainingQuizResult();
            $storeResult->emp_id = $request->emp_id;
            $storeResult->training_id = $request->training_id;
            $storeResult->employee_name = $request->employee_name;
            $storeResult->training_type = "Department Wise Job Role";
            $storeResult->correct_answers = $correctCount;
            $storeResult->incorrect_answers = $totalQuestions - $correctCount;
            $storeResult->total_questions = $totalQuestions;
            $storeResult->score = $score . "%";
            $storeResult->result = $result;
            $storeResult->attempt_number = $attemptNumber; // Save the attempt number for the specific document_number
            $storeResult->document_number = $document_number; // Store document_number
            $storeResult->save();
        
            return view('frontend.TMS.department-wise.department_wise_quize_result', [
                'totalQuestions' => $totalQuestions,
                'correctCount' => $correctCount,
                'score' => $score,
                'result' => $result,
                'document_number' => $document_number
            ]);
        }
        
        
        
        
        


        public function DepartmentWisePost(Request $request)
        {
            $department = [];
            $selectedJobRoles = $request->input('job_role');

            // Ensure $selectedJobRoles is an array
            if (!is_array($selectedJobRoles)) {
                $selectedJobRoles = explode(',', $selectedJobRoles); // Convert comma-separated string to array
            }

            $dpwe = DepartmentDocumentNumbers::where('location', $request->input('site_division_1'))
                ->where('department', $request->input('site_division_2'))
                ->get();
            
            if ($request->input('year')) {
                $dpwe = $dpwe->where('year', $request->input('year'));  // No need for '=='
            }
            if($request->input('job_role')){
                // Iterate through the dpwe collection to find matching records
                $matchingRecords = $dpwe->filter(function ($record) use ($selectedJobRoles) {
                    $jobRolesArray = explode(',', $record->job_role); // Split job_role string into an array
                    return count(array_intersect($selectedJobRoles, $jobRolesArray)) > 0; // Check if there is an intersection
                });
            }

            // Display the matching records
            // dd(vars: $matchingRecords);

            return view('frontend.layout.department_wise_report',['dpwe' => $matchingRecords ?? $dpwe,], compact('dpwe','department','selectedJobRoles'));

        }

        public function saveReadingTime(Request $request)
        {
            $sop_spent_time = $request->input('sop_spent_time');
            $id = $request->input('id');
            $jobTraining = DepartmentDocumentNumbers::findOrFail($id);
    
            $jobTraining->sop_spent_time = $sop_spent_time;
            $jobTraining->update();
    
            return response()->json(['success' => true]);
        }

        public function viewrendersopdepartment($id, $total_minimum_time, $per_screen_running_time, $job_training_id, $sop_spent_time){
            $id = Crypt::decryptString($id);
            $totalMinimumTime = Crypt::decryptString($total_minimum_time);
            $perScreenRunningTime = Crypt::decryptString($per_screen_running_time);
            $sop_spent_time = Crypt::decryptString($sop_spent_time);


            return view('frontend.TMS.department-wise.department_wise_details', compact('id', 'totalMinimumTime', 'perScreenRunningTime', 'job_training_id', 'sop_spent_time'));
        }


}
