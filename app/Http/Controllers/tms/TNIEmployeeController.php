<?php

namespace App\Http\Controllers\tms;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Document;
use App\Models\DocumentTraining;
use App\Models\Training;
use App\Models\Quize;
use App\Models\Question;
use App\Models\EmpTrainingQuizResult;
use App\Models\TNIEmployee;
use App\Models\TniEmployeeDocument;
use App\Models\User;
use PDF;
use Helpers;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class TNIEmployeeController extends Controller
{
    public  function index(){
        $employees = DB::table('employees')->get(); 
        $data = Document::all();
        $firstEmployeeId = $employees->first()->full_employee_id ?? ''; 
        return view('frontend.TMS.TNIEmployee.tniemployee_create',compact('firstEmployeeId','data'));
    }

    public function store(Request $request)
    { 
        $TniEmployee = new TNIEmployee();

        $TniEmployee->stage = '1';
        $TniEmployee->status = 'Opened';
        $TniEmployee->employee_name = $request->employee_name;
        $TniEmployee->employee_names = $request->employee_names;
        $TniEmployee->employee_code = $request->employee_code;
        $TniEmployee->department = $request->department;
        $TniEmployee->designation = $request->designation;
        $TniEmployee->job_role = $request->job_role;
        $TniEmployee->joining_date = $request->joining_date;
        // dd($request->joining_date);

        for ($i = 1; $i <= 5; $i++) {
            $TniEmployee->{"document_number_$i"} = $request->input("document_number_$i");
            $TniEmployee->{"document_title_$i"} = $request->input("document_title_$i");
            $TniEmployee->{"startdate_$i"} = $request->input("startdate_$i");
            $TniEmployee->{"enddate_$i"} = $request->input("enddate_$i");

            $TniEmployee->{"total_minimum_time_$i"} = $request->input("total_minimum_time_$i");
            $TniEmployee->{"per_screen_run_time_$i"} = $request->input("per_screen_run_time_$i");
        }

        $TniEmployee->save();

        toastr()->success("Record is created Successfully");
        return redirect(url('TMS'));
    }

    public function show($id){
        $tniemployee = TNIEmployee::find($id);
        $data = Document::all();
        return view('frontend.TMS.TNIEmployee.tniemployee_view', compact('tniemployee', 'data', 'id'));
    }

    public function update(Request $request, $id)
    { 
        $tniemployee = TNIEmployee::find($id);
        
        // $tniemployee->employee_name = $request->employee_name;
        // $tniemployee->employee_names = $request->employee_names;
        $tniemployee->employee_code = $request->employee_code;
        // $tniemployee->department = $request->department;
        $tniemployee->designation = $request->designation;
        $tniemployee->job_role = $request->job_role;
        $tniemployee->hod_remark = $request->hod_remark;
        $tniemployee->acknowledge = $request->acknowledge;

        for ($i = 1; $i <= 5; $i++) {
            $tniemployee->{"document_number_$i"} = $request->input("document_number_$i");
            $tniemployee->{"document_title_$i"} = $request->input("document_title_$i");
            $tniemployee->{"startdate_$i"} = $request->input("startdate_$i");
            $tniemployee->{"enddate_$i"} = $request->input("enddate_$i");

            $tniemployee->{"total_minimum_time_$i"} = $request->input("total_minimum_time_$i");
            $tniemployee->{"per_screen_run_time_$i"} = $request->input("per_screen_run_time_$i");
        }

        if ($request->hasFile('hod_attachment')) {
            $file = $request->file('hod_attachment');
            $name = $request->employee_id . 'hod_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
            $file->move('upload/', $name);
            $tniemployee->hod_attachment = $name;
        }

        if ($request->hasFile('acknowledge_attachment')) {
            $file = $request->file('acknowledge_attachment');
            $name = $request->employee_id . 'acknowledge_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
            $file->move('upload/', $name);
            $tniemployee->acknowledge_attachment = $name;
        }

        $tniemployee->save();

        toastr()->success("Record is update Successfully");
        return redirect()->back();
    }

    public function sendStage(Request $request, $id)
    {
        try {

            if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
                $tniemployee = TNIEmployee::find($id);

                if ($tniemployee->stage == 1) {
                    $tniemployee->stage = "2";
                    $tniemployee->status = "Pending Acknowledge from Employee";
                    $tniemployee->submit_by = Auth::user()->name;
                    $tniemployee->submit_on = Carbon::now()->format('Y-m-d');
                    $tniemployee->submit_comment = $request->comment;
                
                    $tniemployee->update();
                
                    return back();
                }     
            

                if ($tniemployee->stage == 2) {
                    $tniemployee->stage = "3";
                    $tniemployee->status = "Pending Approved";
                    $tniemployee->acknowledge_by = Auth::user()->name;
                    $tniemployee->acknowledge_on = Carbon::now()->format('d-m-Y');
                    $tniemployee->acknowledge_comment = $request->comment;


                    $tniemployee->update();
                    return back();
                }
             

                if ($tniemployee->stage == 3) {
                    $tniemployee->stage = "4";
                    $tniemployee->status = "Closed - Done";
                    $tniemployee->approved_by = Auth::user()->name;
                    $tniemployee->approved_on = Carbon::now()->format('d-m-Y');
                    $tniemployee->approved_comment = $request->comment;


                    for ($i = 1; $i <= 5; $i++) {
                        $documentNumber = $tniemployee->{"document_number_$i"};
                        $documentTitle = $tniemployee->{"document_title_$i"};
                        $startDate = $tniemployee->{"startdate_$i"};
                        $endDate = $tniemployee->{"enddate_$i"};
                        $totalMinimumTime = $tniemployee->{"total_minimum_time_$i"};
                        $perScreenRunTime = $tniemployee->{"per_screen_run_time_$i"};
                
                        if ($documentNumber) {
                            TniEmployeeDocument::create([
                                'employee_id' => $tniemployee->id,
                                'employee_name' => $tniemployee->employee_name,
                                'employee_code' => $tniemployee->employee_code,
                                'department' => $tniemployee->department,
                                'designation' => $tniemployee->designation,
                                'job_role' => $tniemployee->job_role,
                                'joining_date' => $tniemployee->joining_date,
                                'total_minimum_time' => $totalMinimumTime,
                                'per_screen_run_time' => $perScreenRunTime,
                                'document_number' => $documentNumber,
                                'document_title' => $documentTitle,
                                'startdate' => $startDate,
                                'enddate' => $endDate,
                                'training_effective' => true,
                            ]);
                        }
                    }

                    $tniemployee->update();
                    return back();
                }

            }
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function cancelStage(Request $request, $id)
    {
        try {

            if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
                $tniemployee = TNIEmployee::find($id);

                if ($tniemployee->stage == 2) {
                    $tniemployee->stage = "1";
                    $tniemployee->status = "Opened";
                    $tniemployee->cancel_by = Auth::user()->name;
                    $tniemployee->cancel_on = Carbon::now()->format('d-m-Y');
                    $tniemployee->cancel_comment = $request->comments;

                    $tniemployee->update();
                    return back();
                }

                if ($tniemployee->stage == 3) {
                    $tniemployee->stage = "2";
                    $tniemployee->status = "Pending Acknowledge from Employee";
                    $tniemployee->acknowledge_cancel_by = Auth::user()->name;
                    $tniemployee->acknowledge_cancel_on = Carbon::now()->format('d-m-Y');
                    $tniemployee->acknowledge_cancel_comment = $request->comments;

                    $tniemployee->update();
                    return back();
                }
              
            }
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    public static function tniEmployeeReport($id)
    {
        $data = TNIEmployee::find($id);
        $document = Document::all();

        if (!empty($data)) {
            $data->originator_id = User::where('id', $data->initiator_id)->value('name');

            $formattedDocuments = [];

            for ($i = 1; $i <= 5; $i++) {
                $documentNumber = $data->{'document_number_' . $i};
    
                if ($documentNumber) {
                    $document = Document::find($documentNumber);
                    $formattedDocuments[$i] = $document ? 
                        "{$document->sop_type_short}/{$document->department_id}/" . 
                        str_pad($document->id, 4, '0', STR_PAD_LEFT) . 
                        "/R{$document->major}" : 'Not Applicable';
                } else {
                    $formattedDocuments[$i] = 'Not Applicable';
                }
            }
    
            $data->formatted_document_1 = $formattedDocuments[1];
            $data->formatted_document_2 = $formattedDocuments[2];
            $data->formatted_document_3 = $formattedDocuments[3];
            $data->formatted_document_4 = $formattedDocuments[4];
            $data->formatted_document_5 = $formattedDocuments[5];

            $pdf = App::make('dompdf.wrapper');
            $time = Carbon::now();
            $pdf = PDF::loadview('frontend.TMS.TNIEmployee.tni_emp_report', compact('data'))
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

    // public function viewrendersoptniemp($id){
    //     return view('frontend.TMS.TNIEmployee.tni_emp_sop', compact('id'));
    // }

    public function viewrendersoptniemp($id, $total_minimum_time, $per_screen_running_time, $tni_emp_training_id, $sop_spent_time){
        $id = Crypt::decryptString($id);
        $totalMinimumTime = Crypt::decryptString($total_minimum_time);
        $perScreenRunningTime = Crypt::decryptString($per_screen_running_time);
        $sop_spent_time = Crypt::decryptString($sop_spent_time);
        // dd($id, $totalMinimumTime, $perScreenRunningTime, $sop_spent_time, $tni_emp_training_id);
        return view('frontend.TMS.TNIEmployee.tni_emp_sop', compact('id', 'totalMinimumTime', 'perScreenRunningTime', 'tni_emp_training_id', 'sop_spent_time'));
    }

    public function tniquestionshow($sopids, $tniempid)
    {
        $tniempid = TniEmployeeDocument::find($tniempid);
        
        $tniempid->attempt_count = $tniempid->attempt_count == -1 ? 0 : ($tniempid->attempt_count == 0 ? 0 : $tniempid->attempt_count - 1);
        $tniempid->save();
        $singleSOPId = $sopids;
        $sopids = array_map('trim', explode(',', $sopids));

        $questions = Question::whereIn('document_id', $sopids)
            ->inRandomOrder() 
            ->take(10)      
            ->get();

            
        $document_number = $tniempid->document_number ?? null;

        return view('frontend.TMS.TNIEmployee.tni_emp_question_show', compact('questions', 'document_number', 'singleSOPId','tniempid'));
    }

    public function checkAnswerTni(Request $request)
    {
        $allQuestions = Question::where('document_id', $request->document_number)
                                ->inRandomOrder()
                                ->get();
    
        $document_number = $request->input('document_number');
        
        $filteredQuestions = $allQuestions->filter(function ($question) {
            return in_array($question->type, ['Single Selection Questions', 'Multi Selection Questions']);
        });
    
        $questions = $filteredQuestions->take(10);
    
        $correctCount = 0;
        $totalQuestions = count($questions);
    
        foreach ($questions as $question) {
            $userAnswer = $request->input('question_' . $question->id);
            $correctAnswers = unserialize($question->answers);
            $questionType = $question->type;
    
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
    
        $score = ($correctCount / $totalQuestions) * 100;
        $result = $score >= 80 ? 'Pass' : 'Fail';
    
        $existingResult = EmpTrainingQuizResult::where([
            ['training_id', '=', $request->training_id],
            ['document_number', '=', $document_number],
            ['emp_id', '=', $request->emp_id]
        ])->latest()->first();
    

        $attemptNumber = $existingResult ? $existingResult->attempt_number + 1 : 1;
    
        $storeResult = new EmpTrainingQuizResult();
        $storeResult->emp_id = $request->emp_id;
        $storeResult->training_id = $request->training_id;
        $storeResult->employee_name = $request->employee_name;
        $storeResult->training_type = "TNI Employee";
        $storeResult->correct_answers = $correctCount;
        $storeResult->incorrect_answers = $totalQuestions - $correctCount;
        $storeResult->total_questions = $totalQuestions;
        $storeResult->score = $score . "%";
        $storeResult->result = $result;
        $storeResult->attempt_number = $attemptNumber; 
        $storeResult->document_number = $document_number;
        $storeResult->save();
    
        return view('frontend.TMS.TNIEmployee.tni_emp_quiz_result', [
            'totalQuestions' => $totalQuestions,
            'correctCount' => $correctCount,
            'score' => $score,
            'result' => $result,
            'document_number' => $document_number
        ]);
    }

}
