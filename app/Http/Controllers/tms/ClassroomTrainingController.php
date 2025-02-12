<?php

namespace App\Http\Controllers\tms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ClassroomTraining;
use App\Models\EmpTrainingQuizResult;
use App\Models\DocumentTraining;
use App\Models\Training;
use App\Models\Quize;
use App\Models\Question;
use App\Models\ClassroomTrainingGrid;
use App\Models\Department;
use App\Models\ClassroomTrainingAudits;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\App;
use PDF;
use App\Models\SetDivision;
use App\Models\RoleGroup;
use App\Models\QMSProcess;
use App\Models\User;
use App\Models\Employee;
use App\Models\Document;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;

class ClassroomTrainingController extends Controller
{

    public function index()
    {

        $data = Document::all();
        // $hods = DB::table('user_roles')
        //     ->join('users', 'user_roles.user_id', '=', 'users.id')
        //     ->select('user_roles.q_m_s_processes_id', 'users.id', 'users.role', 'users.name')
        //     ->where('user_roles.q_m_s_processes_id', $process->id)
        //     ->where('user_roles.q_m_s_roles_id', 4)
        //     ->groupBy('user_roles.q_m_s_processes_id', 'users.id', 'users.role', 'users.name')
        //     ->get();
        $hods = User::get();
        $delegate = User::get();

        $ClassroomTraining = ClassroomTraining::all();
        $employees = Employee::all();

        return view('frontend.TMS.Classroom_Training.classroom_training', compact('ClassroomTraining','data','hods','delegate','employees'));
    }


public function fetchQuestions($id)
{
    $document_training = DocumentTraining::where('document_id', $id)->first();
    if ($document_training) {
        $training = Training::find($document_training->training_plan); 
        if ($training && $training->training_plan_type == "Read & Understand with Questions") {
            $quize = Quize::find($training->quize);
            $questions = explode(',', $quize->question);
            $question_list = [];

            foreach ($questions as $question_id) {
                $question = Question::find($question_id);
                if ($question) {
                    $json_options = unserialize($question->options);
                    $options = [];
                    foreach ($json_options as $key => $value) {
                        $options[chr(97 + $key)] = $value; // Format options
                    }
                    $question->options = $options;
                    $question_list[] = $question;
                }
            }
            return response()->json($question_list); // Return questions array as JSON
        }
    }
    return response()->json([]); // Return empty array if no questions found
}

public function trainingQuestions($id){

    $document = Document::find($id);
    $document_training = DocumentTraining::where('document_id',$id)->first();
    $training = Training::find($document_training->training_plan);
    if($training->training_plan_type == "Read & Understand with Questions"){
        $quize = Quize::find($training->quize);
        $data = explode(',',$quize->question);
        // dd($document_training);
        $array = [];

        for($i = 0; $i<count($data); $i++){
            $question = Question::find($data[$i]);
            $question->id = $i+1;
            $json_option = unserialize($question->options);
            $options = [];
            foreach($json_option as $key => $value){
                $options[chr(97 + $key)] = $value;
            }
            $question->options = array($options);
            $ans = unserialize($question->answers);
            $question->answers = implode("", $ans);
            $question->score = 0;
            $question->status = "";

            array_push($array,$question);
        }
         $data_array = implode(',',$array);

        return view('frontend.TMS.Job_Training.quize',compact('document','data_array','quize'));
   }
   else{
    toastr()->error('Training not specified');
    return back();
   }
}


    public function getEmployeeDetail($id)
    {
        $employee = Employee::find($id);
        return response()->json($employee);
    }


    public function getSopDescription($id)
{
    $document = Document::find($id); // Document ka model use karein
    
    if ($document) {
        return response()->json([
            'short_description' => $document->short_description // Short description field ka naam use karein
        ]);
    }

    return response()->json(['short_description' => ''], 404);
}


    public function store(Request $request)
    {
        // dd($request->all());

        $ClassroomTraining = new ClassroomTraining();

        $ClassroomTraining->stage = '1';
        $ClassroomTraining->status = 'Opened';
        $ClassroomTraining->name = $request->input('name');
        $ClassroomTraining->department = $request->input('department');
        $ClassroomTraining->location = $request->input('location');

        $ClassroomTraining->hod = $request->input('hod');
        $ClassroomTraining->empcode = $request->input('empcode');
        $ClassroomTraining->type_of_training = $request->input('type_of_training');
        $ClassroomTraining->start_date = $request->input('start_date');
        $ClassroomTraining->end_date = $request->input('end_date');

        $ClassroomTraining->sopdocument = $request->input('sopdocument');

        $ClassroomTraining->name_employee = $request->input('name_employee');
        $ClassroomTraining->job_description_no = $request->input('job_description_no');
        $ClassroomTraining->effective_date = $request->input('effective_date');
        $ClassroomTraining->employee_id = $request->input('employee_id');
        $ClassroomTraining->new_department = $request->input('new_department');
        $ClassroomTraining->designation = $request->input('designation');
        $ClassroomTraining->qualification = $request->input('qualification');
        $ClassroomTraining->date_joining = $request->input('date_joining');
        $ClassroomTraining->experience_if_any = $request->input('experience_if_any');
        $ClassroomTraining->experience_with_agio = $request->input('experience_with_agio');
        $ClassroomTraining->total_experience = $request->input('total_experience');
        $ClassroomTraining->reason_for_revision = $request->input('reason_for_revision');
        $ClassroomTraining->jd_type = $request->input('jd_type');
        $ClassroomTraining->revision_purpose = $request->input('revision_purpose');
        $ClassroomTraining->remark = $request->input('remark'); 
        $ClassroomTraining->evaluation_required = $request->input('evaluation_required');
        $ClassroomTraining->delegate = $request->input('delegate');
        $ClassroomTraining->selected_document_id = $request->input('selected_document_id');
        $ClassroomTraining->per_screen_running_time = $request->input('per_screen_running_time');
        $ClassroomTraining->total_minimum_time = $request->input('total_minimum_time');

        // if (!empty($request->supporting_attachments1	)) {
        //     $files = [];
        //     if ($request->hasFile('supporting_attachments1	')) {
        //         foreach ($request->file('supporting_attachments1	') as $file) {
        //             $name = $request->name . 'supporting_attachments1	' . uniqid() . '.' . $file->getClientOriginalExtension();
        //             $file->move(public_path('upload/'), $name);
        //             $files[] = $name;
        //         }
        //     }
        //     $ClassroomTraining->supporting_attachments1 = json_encode($files);
        // }


      $ClassroomTraining_id = $ClassroomTraining->id;

        $employeeJobGrid = ClassroomTrainingGrid::where(['jobTraining_id' => $ClassroomTraining_id, 'identifier' => 'jobResponsibilites'])->firstOrNew();
        $employeeJobGrid->jobTraining_id = $ClassroomTraining_id;
        $employeeJobGrid->identifier = 'jobResponsibilites';
        $employeeJobGrid->data = $request->jobResponsibilities;  

        $employeeJobGrid->save();

        for ($i = 1; $i <= 5; $i++) {
            $ClassroomTraining->{"subject_$i"} = $request->input("subject_$i");
            $ClassroomTraining->{"type_of_training_$i"} = $request->input("type_of_training_$i");
            $ClassroomTraining->{"reference_document_no_$i"} = $request->input("reference_document_no_$i");
            $ClassroomTraining->{"trainee_name_$i"} = $request->input("trainee_name_$i");
            $ClassroomTraining->{"trainer_$i"} = $request->input("trainer_$i");
            $attachmentKey = "supporting_attachments$i";
            if ($request->hasFile($attachmentKey)) {
                // Optionally delete the old file
                if ($ClassroomTraining->$attachmentKey) {
                    Storage::delete('public/' . $ClassroomTraining->$attachmentKey);
                }
    
                $file = $request->file($attachmentKey);
                $filePath = $file->store('attachments', 'public');
                $ClassroomTraining->$attachmentKey = $filePath;
            }

            if ($request->hasFile($attachmentKey)) {
                $file = $request->file($attachmentKey);
                $name = $request->name . 'attached' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                $file->move('upload/', $name);
                $ClassroomTraining->$attachmentKey = $name;
            }
            $ClassroomTraining->{"startdate_$i"} = $request->input("startdate_$i");
            $ClassroomTraining->{"enddate_$i"} = $request->input("enddate_$i");
        }

        // dd($ClassroomTraining);
        $ClassroomTraining->save();


        if (!empty($request->name)) {
            $validation2 = new ClassroomTrainingAudits();
            $validation2->job_id = $ClassroomTraining->id;
            $validation2->previous = "Null";
            $validation2->current = $request->name;
            $validation2->activity_type = 'Name';
            $validation2->user_id = Auth::user()->id;
            $validation2->user_name = Auth::user()->name;
            $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

            $validation2->change_to =   "Opened";
            $validation2->change_from = "Initiation";
            $validation2->action_name = 'Create';
            $validation2->save();
        }


        if (!empty($request->department)) {
            $validation2 = new ClassroomTrainingAudits();
            $validation2->job_id = $ClassroomTraining->id;
            $validation2->activity_type = 'Department';
            $validation2->previous = "Null";
            $validation2->current = $request->department;
            $validation2->comment = "NA";
            $validation2->user_id = Auth::user()->id;
            $validation2->user_name = Auth::user()->name;
            $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

            $validation2->change_to =   "Opened";
            $validation2->change_from = "Initiation";
            $validation2->action_name = 'Create';
            $validation2->save();
        }

        if (!empty($request->location)) {
            $validation2 = new ClassroomTrainingAudits();
            $validation2->job_id = $ClassroomTraining->id;
            $validation2->activity_type = 'Location';
            $validation2->previous = "Null";
            $validation2->current = $request->location;
            $validation2->comment = "NA";
            $validation2->user_id = Auth::user()->id;
            $validation2->user_name = Auth::user()->name;
            $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

            $validation2->change_to =   "Opened";
            $validation2->change_from = "Initiation";
            $validation2->action_name = 'Create';

            $validation2->save();
        }
        if (!empty($request->hod)) {
            $validation2 = new ClassroomTrainingAudits();
            $validation2->job_id = $ClassroomTraining->id;
            $validation2->activity_type = 'HOD';
            $validation2->previous = "Null";
            $validation2->current = $request->hod;
            $validation2->comment = "NA";
            $validation2->user_id = Auth::user()->id;
            $validation2->user_name = Auth::user()->name;
            $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

            $validation2->change_to =   "Opened";
            $validation2->change_from = "Initiation";
            $validation2->action_name = 'Create';

            $validation2->save();
        }



        toastr()->success('Job Training created successfully.');
        return redirect('TMS');
        // return redirect()->route('TMS')->with('success', '');
    }


    public function edit($id)
    {

        $ClassroomTraining = ClassroomTraining::find($id);
        $data = Document::all();
        
        $record = ClassroomTraining::findOrFail($id);
        $savedSop = $record->sopdocument;
        $employees = Employee::all();
        
        $document_training = DocumentTraining::where('document_id', $id)->first();
         // Use optional() to avoid null errors when training_plan or quize is null
         $training = optional($document_training)->training_plan ? Training::find($document_training->training_plan) : null;
         $quize = optional($training)->quize ? Quize::find($training->quize) : null;
        // $training = Training::find($document_training->training_plan); 
        // $quize = Quize::find($training->quize);
        $employee_grid_data = ClassroomTrainingGrid::where(['jobTraining_id' => $id, 'identifier' => 'jobResponsibilites'])->first();

        // dd($ClassroomTraining);
        $departments = Department::all();
        $users = User::all();

        if (!$ClassroomTraining) {
            return redirect()->route('classroom_training.index')->with('error', 'Job Training not found');
        }
        return view('frontend.TMS.Classroom_Training.classroom_training_view', compact('ClassroomTraining', 'id', 'departments', 'users','data','savedSop','quize','training','document_training','employees','employee_grid_data'));
    }

    public function update(Request $request, $id)
    {
        // dd($request->all());
        $ClassroomTraining = ClassroomTraining::findOrFail($id);
        $lastDocument = ClassroomTraining::findOrFail($id);

        // Update fields
        $ClassroomTraining->name = $request->input('name');
        $ClassroomTraining->department = $request->input('department');
        $ClassroomTraining->location = $request->input('location');
        $ClassroomTraining->hod = $request->input('hod');

        $ClassroomTraining->empcode = $request->input('empcode');
        $ClassroomTraining->type_of_training = $request->input('type_of_training');
        $ClassroomTraining->start_date = $request->input('start_date');
        $ClassroomTraining->end_date = $request->input('end_date');
        $ClassroomTraining->sopdocument = $request->input('sopdocument');


        $ClassroomTraining->name_employee = $request->input('name_employee');
        $ClassroomTraining->job_description_no = $request->input('job_description_no');
        $ClassroomTraining->effective_date = $request->input('effective_date');
        $ClassroomTraining->employee_id = $request->input('employee_id');
        $ClassroomTraining->new_department = $request->input('new_department');
        $ClassroomTraining->designation = $request->input('designation');
        $ClassroomTraining->qualification = $request->input('qualification');
        $ClassroomTraining->date_joining = $request->input('date_joining');
        $ClassroomTraining->experience_if_any = $request->input('experience_if_any');
        $ClassroomTraining->experience_with_agio = $request->input('experience_with_agio');
        $ClassroomTraining->total_experience = $request->input('total_experience');
        $ClassroomTraining->reason_for_revision = $request->input('reason_for_revision');
        $ClassroomTraining->jd_type = $request->input('jd_type');
        $ClassroomTraining->revision_purpose = $request->input('revision_purpose');
        $ClassroomTraining->remark = $request->input('remark'); 
        $ClassroomTraining->evaluation_required = $request->input('evaluation_required');
        $ClassroomTraining->delegate = $request->input('delegate');

        $ClassroomTraining->evaluation_comment = $request->input('evaluation_comment');
        $ClassroomTraining->qa_review = $request->input('qa_review');
        $ClassroomTraining->qa_cqa_comment = $request->input('qa_cqa_comment');
        $ClassroomTraining->qa_cqa_head_comment = $request->input('qa_cqa_head_comment');
        $ClassroomTraining->final_review_comment = $request->input('final_review_comment');
        $ClassroomTraining->selected_document_id = $request->input('selected_document_id');
        $ClassroomTraining->per_screen_running_time = $request->input('per_screen_running_time');
        $ClassroomTraining->total_minimum_time = $request->input('total_minimum_time');


        // $employeeJobGrid = EmployeeGrid::where(['employee_id' => $employee_id, 'identifier' => 'jobResponsibilites'])->firstOrNew();
        // $employeeJobGrid->employee_id = $employee_id;
        // $employeeJobGrid->identifier = 'jobResponsibilites';
        // $employeeJobGrid->data = $request->jobResponsibilities;
        // $employeeJobGrid->save();

        if ($request->hasFile('qa_review_attachment')) {
            $file = $request->file('qa_review_attachment');
            $name = $request->employee_id . 'qa_review_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
            $file->move('upload/', $name);
            $ClassroomTraining->qa_review_attachment = $name;
        }

        if ($request->hasFile('qa_cqa_attachment')) {
            $file = $request->file('qa_cqa_attachment');
            $name = $request->employee_id . 'qa_cqa_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
            $file->move('upload/', $name);
            $ClassroomTraining->qa_cqa_attachment = $name;
        }

        if ($request->hasFile('evaluation_attachment')) {
            $file = $request->file('evaluation_attachment');
            $name = $request->employee_id . 'evaluation_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
            $file->move('upload/', $name);
            $ClassroomTraining->evaluation_attachment = $name;
        }

        if ($request->hasFile('qa_cqa_head_attachment')) {
            $file = $request->file('qa_cqa_head_attachment');
            $name = $request->employee_id . 'qa_cqa_head_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
            $file->move('upload/', $name);
            $ClassroomTraining->qa_cqa_head_attachment = $name;
        }

        if ($request->hasFile('final_review_attachment')) {
            $file = $request->file('final_review_attachment');
            $name = $request->employee_id . 'final_review_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
            $file->move('upload/', $name);
            $ClassroomTraining->final_review_attachment = $name;
        }


        $ClassroomTraining_id = $ClassroomTraining->id;

        $employeeJobGrid = ClassroomTrainingGrid::where(['jobTraining_id' => $ClassroomTraining_id, 'identifier' => 'jobResponsibilites'])->firstOrNew();
        $employeeJobGrid->jobTraining_id = $ClassroomTraining_id;
        $employeeJobGrid->identifier = 'jobResponsibilites';
        $employeeJobGrid->data = $request->jobResponsibilities;
        $employeeJobGrid->save();

        for ($i = 1; $i <= 5; $i++) {
            $ClassroomTraining->{"subject_$i"} = $request->input("subject_$i");
            $ClassroomTraining->{"type_of_training_$i"} = $request->input("type_of_training_$i");
            $ClassroomTraining->{"reference_document_no_$i"} = $request->input("reference_document_no_$i");
            $ClassroomTraining->{"trainee_name_$i"} = $request->input("trainee_name_$i");
            $ClassroomTraining->{"trainer_$i"} = $request->input("trainer_$i");
            
            $ClassroomTraining->{"startdate_$i"} = $request->input("startdate_$i");
            $ClassroomTraining->{"enddate_$i"} = $request->input("enddate_$i");
            $attachmentKey = "supporting_attachments$i";

            if ($request->hasFile($attachmentKey)) {
                $file = $request->file($attachmentKey);
                $name = $request->name . $attachmentKey . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                $file->move('upload/', $name);
                $ClassroomTraining->$attachmentKey = $name;
            }
        }

        $ClassroomTraining->save();

        if ($lastDocument->name != $request->name) {
            $validation2 = new ClassroomTrainingAudits();
            $validation2->job_id = $ClassroomTraining->id;
            $validation2->previous = $lastDocument->name;
            $validation2->current = $request->name;
            $validation2->activity_type = 'Name';
            $validation2->user_id = Auth::user()->id;
            $validation2->user_name = Auth::user()->name;
            $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

            $validation2->change_to =   "Not Applicable";
            $validation2->change_from = $lastDocument->status;
            if (is_null($lastDocument->name) || $lastDocument->name === '') {
                $validation2->action_name = 'New';
            } else {
                $validation2->action_name = 'Update';
            }
            $validation2->save();
        }


        if ($lastDocument->department != $request->department) {
            $validation2 = new ClassroomTrainingAudits();
            $validation2->job_id = $ClassroomTraining->id;
            $validation2->activity_type = 'Department';
            $validation2->previous = $lastDocument->department;
            $validation2->current = $request->department;
            $validation2->comment = "NA";
            $validation2->user_id = Auth::user()->id;
            $validation2->user_name = Auth::user()->name;
            $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

            $validation2->change_to =   "Not Applicable";
            $validation2->change_from = $lastDocument->status;
            if (is_null($lastDocument->department) || $lastDocument->department === '') {
                $validation2->action_name = 'New';
            } else {
                $validation2->action_name = 'Update';
            }
            $validation2->save();
        }

        if ($lastDocument->location != $request->location) {
            $validation2 = new ClassroomTrainingAudits();
            $validation2->job_id = $ClassroomTraining->id;
            $validation2->activity_type = 'Location';
            $validation2->previous = $lastDocument->location;
            $validation2->current = $request->location;
            $validation2->comment = "NA";
            $validation2->user_id = Auth::user()->id;
            $validation2->user_name = Auth::user()->name;
            $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

            $validation2->change_to =   "Opened";
            $validation2->change_from = $lastDocument->status;
            if (is_null($lastDocument->location) || $lastDocument->location === '') {
                $validation2->action_name = 'New';
            } else {
                $validation2->action_name = 'Update';
            }

            $validation2->save();
        }
        if ($lastDocument->hod != $request->hod) {
            $validation2 = new ClassroomTrainingAudits();
            $validation2->job_id = $ClassroomTraining->id;
            $validation2->activity_type = 'HOD';
            $validation2->previous = $lastDocument->hod;
            $validation2->current = $request->hod;
            $validation2->comment = "NA";
            $validation2->user_id = Auth::user()->id;
            $validation2->user_name = Auth::user()->name;
            $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

            $validation2->change_to =   "Not Applicable";
            $validation2->change_from = $lastDocument->status;
            if (is_null($lastDocument->hod) || $lastDocument->hod === '') {
                $validation2->action_name = 'New';
            } else {
                $validation2->action_name = 'Update';
            }
            $validation2->save();
        }

        return redirect()->back()->with('success', 'Job Training updated successfully.');
    }

    public function sendStage(Request $request, $id)
    {
        try {
            if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
                $ClassroomTraining = ClassroomTraining::find($id);
                $lastClassroomTraining = ClassroomTraining::find($id);

                if ($ClassroomTraining->stage == 1) {
                    $ClassroomTraining->stage = "2";
                    $ClassroomTraining->status = "QA/CQA Head Approval";
                    $ClassroomTraining->submit_by = Auth::user()->name;
                    $ClassroomTraining->submit_on = Carbon::now()->format('d-m-Y');
                    $ClassroomTraining->submit_comment = $request->comment;

                    $history = new ClassroomTrainingAudits();
                    $history->job_id = $id;
                    $history->activity_type = 'Activity Log';
                    $history->current = $ClassroomTraining->qualified_by;
                    $history->comment = $request->comment;
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to = "QA/CQA Head Approval";
                    $history->change_from = $lastClassroomTraining->status;
                    $history->action = 'Submit';
                    $history->stage = 'Submited';
                    $history->save();

                    $ClassroomTraining->update();
                    return back();
                }

                if ($ClassroomTraining->stage == 2) {
                    $ClassroomTraining->stage = "3";
                    $ClassroomTraining->status = "Employee Answers";
                    $ClassroomTraining->approval_complete_by = Auth::user()->name;
                    $ClassroomTraining->approval_complete_on = Carbon::now()->format('d-m-Y');
                    $ClassroomTraining->approval_complete_comment = $request->comment;

                    $history = new ClassroomTrainingAudits();
                    $history->job_id = $id;
                    $history->activity_type = 'Activity Log';
                    $history->current = $ClassroomTraining->qualified_by;
                    $history->comment = $request->comment;
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to = "Employee Answers";
                    $history->change_from = $lastClassroomTraining->status;
                    $history->action = 'Approval Complete';
                    $history->stage = 'Submited';
                    $history->save();

                    $ClassroomTraining->update();
                    return back();
                }

                if ($ClassroomTraining->stage == 3) {
                    $ClassroomTraining->stage = "4";
                    $ClassroomTraining->status = "Evaluation";
                    $ClassroomTraining->answer_submit_by = Auth::user()->name;
                    $ClassroomTraining->answer_submit_on = Carbon::now()->format('d-m-Y');
                    $ClassroomTraining->answer_submit_comment = $request->comment;

                    $history = new ClassroomTrainingAudits();
                    $history->job_id = $id;
                    $history->activity_type = 'Activity Log';
                    $history->current = $ClassroomTraining->qualified_by;
                    $history->comment = $request->comment;
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to = "Evaluation";
                    $history->change_from = $lastClassroomTraining->status;
                    $history->action = 'Answer Submit';
                    $history->stage = 'Submited';
                    $history->save();

                    $ClassroomTraining->update();
                    return back();
                }

                // if ($ClassroomTraining->stage == 4) {
                //     $ClassroomTraining->stage = "5";
                //     $ClassroomTraining->status = "QA/CQA Approval";
                //     $history = new ClassroomTrainingAudits();
                //     $history->job_id = $id;
                //     $history->activity_type = 'Activity Log';
                //     $history->current = $ClassroomTraining->qualified_by;
                //     $history->comment = $request->comment;
                //     $history->user_id = Auth::user()->id;
                //     $history->user_name = Auth::user()->name;
                //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                //     $history->change_to = "QA/CQA Approval";
                //     $history->change_from = $lastClassroomTraining->status;
                //     $history->action = 'Review Complete';
                //     $history->stage = 'Submited';
                //     $history->save();

                //     $ClassroomTraining->update();
                //     return back();
                // }

                if ($ClassroomTraining->stage == 4) {
                    $ClassroomTraining->stage = "5";
                    $ClassroomTraining->status = "QA/CQA Head Final Review";
                    $ClassroomTraining->evaluation_complete_by = Auth::user()->name;
                    $ClassroomTraining->evaluation_complete_on = Carbon::now()->format('d-m-Y');
                    $ClassroomTraining->evaluation_complete_comment = $request->comment;

                    $history = new ClassroomTrainingAudits();
                    $history->job_id = $id;
                    $history->activity_type = 'Activity Log';
                    $history->current = $ClassroomTraining->qualified_by;
                    $history->comment = $request->comment;
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to = "QA/CQA Head Final Review";
                    $history->change_from = $lastClassroomTraining->status;
                    $history->action = 'Evaluation Complete';
                    $history->stage = 'Submited';
                    $history->save();

                    $ClassroomTraining->update();
                    return back();
                }

                if ($ClassroomTraining->stage == 5) {
                    $ClassroomTraining->stage = "6";
                    $ClassroomTraining->status = "Verification and Approval";
                    $ClassroomTraining->qa_head_review_complete_by = Auth::user()->name;
                    $ClassroomTraining->qa_head_review_complete_on = Carbon::now()->format('d-m-Y');
                    $ClassroomTraining->qa_head_review_complete_comment = $request->comment;
                    
                    $history = new ClassroomTrainingAudits();
                    $history->job_id = $id;
                    $history->activity_type = 'Activity Log';
                    $history->current = $ClassroomTraining->qualified_by;
                    $history->comment = $request->comment;
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to = "Verification and Approval";
                    $history->change_from = $lastClassroomTraining->status;
                    $history->action = 'QA/CQA Head Review Complete';
                    $history->stage = 'Submited';
                    $history->save();

                    $ClassroomTraining->update();
                    return back();
                }

                // if ($ClassroomTraining->stage == 6) {
                //     $ClassroomTraining->stage = "7";
                //     $ClassroomTraining->status = "QA/CQA Head Final Review";
                //     $history = new ClassroomTrainingAudits();
                //     $history->job_id = $id;
                //     $history->activity_type = 'Activity Log';
                //     $history->current = $ClassroomTraining->qualified_by;
                //     $history->comment = $request->comment;
                //     $history->user_id = Auth::user()->id;
                //     $history->user_name = Auth::user()->name;
                //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                //     $history->change_to = "QA/CQA Head Final Review";
                //     $history->change_from = $lastClassroomTraining->status;
                //     $history->action = 'Evaluation Complete';
                //     $history->stage = 'Submited';
                //     $history->save();

                //     $ClassroomTraining->update();
                //     return back();
                // }

                // if ($ClassroomTraining->stage == 7) {
                //     $ClassroomTraining->stage = "8";
                //     $ClassroomTraining->status = "Verification and Approval";
                //     $history = new ClassroomTrainingAudits();
                //     $history->job_id = $id;
                //     $history->activity_type = 'Activity Log';
                //     $history->current = $ClassroomTraining->qualified_by;
                //     $history->comment = $request->comment;
                //     $history->user_id = Auth::user()->id;
                //     $history->user_name = Auth::user()->name;
                //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                //     $history->change_to = "Verification and Approval";
                //     $history->change_from = $lastClassroomTraining->status;
                //     $history->action = 'QA/CQA Head Review Complete';
                //     $history->stage = 'Submited';
                //     $history->save();

                //     $ClassroomTraining->update();
                //     return back();
                // }

                if ($ClassroomTraining->stage == 6) {
                    $ClassroomTraining->stage = "7";
                    $ClassroomTraining->status = "Closed-Done";
                    $ClassroomTraining->verification_approval_complete_by = Auth::user()->name;
                    $ClassroomTraining->verification_approval_complete_on = Carbon::now()->format('d-m-Y');
                    $ClassroomTraining->verification_approval_complete_comment = $request->comment;

                    $history = new ClassroomTrainingAudits();
                    $history->job_id = $id;
                    $history->activity_type = 'Activity Log';
                    $history->current = $ClassroomTraining->qualified_by;
                    $history->comment = $request->comment;
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to = "Closed-Done";
                    $history->change_from = $lastClassroomTraining->status;
                    $history->action = 'Verification and Approval Complete';
                    $history->stage = 'Submited';
                    $history->save();

                    // $user = User::find($ClassroomTraining->hod);
                    // if ($user) {
                    //     Mail::send(
                    //         'mail.view-mail',
                    //         ['data' => $ClassroomTraining, 'site'=>"", 'history' => "Need for Sourcing of Starting Material ", 'process' => 'ClassroomTraining', 'comment' => $request->comments, 'user'=> Auth::user()->name],
                    //         function ($message) use ($user, $ClassroomTraining) {
                    //             $message->to($user->email)
                    //             ->subject("TMS Notification: Complete On the Job Training");
                    //         }
                    //     );
                    // }

                    $ClassroomTraining->update();
                    return back();
                }
            } else {
                toastr()->error('E-signature Not match');
                return back();
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
                $ClassroomTraining = ClassroomTraining::find($id);
                $lastClassroomTraining = ClassroomTraining::find($id);

                if ($ClassroomTraining->stage == 2) {
                    $ClassroomTraining->stage = "1";
                    $ClassroomTraining->status = "Opened";
                    $history = new ClassroomTrainingAudits();
                    $history->job_id = $id;
                    $history->activity_type = 'Activity Log';
                    $history->current = $ClassroomTraining->qualified_by;
                    $history->comment = $request->comment;
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to = "Opened";
                    $history->change_from = $lastClassroomTraining->status;
                    $history->action = 'Reject';
                    $history->stage = 'Submited';
                    $history->save();

                    $ClassroomTraining->update();
                    return back();
                }

              
            } else {
                toastr()->error('E-signature Not match');
                return back();
            }
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    public function classroomAuditTrial($id)
    {
        $ClassroomTraining = ClassroomTraining::find($id);
        $audit = ClassroomTrainingAudits::where('job_id', $id)->orderByDESC('id')->paginate();
        $today = Carbon::now()->format('d-m-y');
        $document = ClassroomTraining::where('id', $id)->first();
        $document->Initiation = User::where('id', $document->initiator_id)->value('name');
        return view('frontend.TMS.Classroom_Training.classroom_training_audit', compact('audit', 'document', 'today', 'ClassroomTraining'));
    }
   
    public static function jobReport($id)
    {
        $data = ClassroomTraining::find($id);
        if (!empty($data)) {
            $data->originator_id = User::where('id', $data->initiator_id)->value('name');
            $pdf = App::make('dompdf.wrapper');
            $time = Carbon::now();
            $pdf = PDF::loadview('frontend.TMS.Job_Training.job_report', compact('data'))
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

    public function viewrendersop($id, $total_minimum_time, $per_screen_running_time, $classroom_training_id, $sop_spent_time){
        $id = Crypt::decryptString($id);
        $totalMinimumTime = Crypt::decryptString($total_minimum_time);
        $perScreenRunningTime = Crypt::decryptString($per_screen_running_time);
        $sop_spent_time = Crypt::decryptString($sop_spent_time);
        // dd($id, $totalMinimumTime, $perScreenRunningTime, $sop_spent_time, $classroom_training_id);
        return view('frontend.TMS.classroom_training_detail', compact('id', 'totalMinimumTime', 'perScreenRunningTime', 'classroom_training_id', 'sop_spent_time'));
    }


    public function showClassroomCertificate($id)
    {        
        $ClassroomTraining = \App\Models\ClassroomTraining::where('id', $id)->first();
        
        if (!$ClassroomTraining) {
            return redirect()->back()->with('error', 'No training data found for this employee.');
        }
    
        $employee = \App\Models\Employee::where('employee_id', $ClassroomTraining->employee_id)->first();
    
        return view('frontend.TMS.Classroom_Training.classroom_training_certificate', compact('ClassroomTraining', 'employee'));
        
    }
    

    public function viewPdf($id)
    {

        $depaArr = ['ACC' => 'Accounting', 'ACC3' => 'Accounting',];
        $data = Document::find($id);
        //$data->department = Department::find($data->department_id);
        $department = Department::find(Auth::user()->departmentid);
        $document = Document::find($id);

        if ($department) {
            $data['department_name'] = $department->name;
        } else {
            $data['department_name'] = '';
        }
        $data->department = $department;

        $data['originator'] = User::where('id', $data->originator_id)->value('name');
        $data['originator_email'] = User::where('id', $data->originator_id)->value('email');
        $data['document_type_name'] = DocumentType::where('id', $data->document_type_id)->value('name');
        $data['document_type_code'] = DocumentType::where('id', $data->document_type_id)->value('typecode');

        $data['document_division'] = Division::where('id', $data->division_id)->value('name');
        $data['year'] = Carbon::parse($data->created_at)->format('Y');
        $data['document_content'] = DocumentContent::where('document_id', $id)->first();

        // pdf related work
        $pdf = App::make('dompdf.wrapper');
        $time = Carbon::now();

        // return view('frontend.documents.pdfpage', compact('data', 'time', 'document'))->render();
        // $pdf = PDF::loadview('frontend.documents.new-pdf', compact('data', 'time', 'document'))
        $pdf = PDF::loadview('frontend.documents.pdfpage', compact('data', 'time', 'document'))
            ->setOptions([
                'defaultFont' => 'sans-serif',
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'isPhpEnabled' => true,
            ]);
        $pdf->setPaper('A4');
        $pdf->render();
        $canvas = $pdf->getDomPDF()->getCanvas();
        $canvas->set_default_view('FitB');
        $height = $canvas->get_height();
        $width = $canvas->get_width();

        $canvas->page_script('$pdf->set_opacity(0.1,"Multiply");');

        $canvas->page_text(
            $width / 4,
            $height / 2,
            Helpers::getDocStatusByStage($data->stage),
            null,
            25,
            [0, 0, 0],
            2,
            6,
            -20
        );

        if ($data->documents) {

            $pdfArray = explode(',', $data->documents);
            foreach ($pdfArray as $pdfFile) {
                $existingPdfPath = public_path('upload/PDF/' . $pdfFile);
                $permissions = 0644; // Example permission value, change it according to your needs
                if (file_exists($existingPdfPath)) {
                    // Create a new Dompdf instance
                    $options = new Options();
                    $options->set('chroot', public_path());
                    $options->set('isPhpEnabled', true);
                    $options->set('isRemoteEnabled', true);
                    $options->set('isHtml5ParserEnabled', true);
                    $options->set('allowedFileExtensions', ['pdf']); // Allow PDF file extension

                    $dompdf = new Dompdf($options);

                    chmod($existingPdfPath, $permissions);

                    // Load the existing PDF file
                    $dompdf->loadHtmlFile($existingPdfPath);

                    // Render the PDF
                    $dompdf->render();

                    // Output the PDF to the browser
                    $dompdf->stream();
                }
            }
        }

        return $pdf->stream('SOP' . $id . '.pdf');
    }

    public function questionshow($sopids, $onthejobid){
        $onthejobid = ClassroomTraining::find($onthejobid);
        $onthejobid->attempt_count = $onthejobid->attempt_count == -1 ? 0 : ( $onthejobid->attempt_count == 0 ? 0 : $onthejobid->attempt_count - 1);

        $onthejobid->save();
        $sopids = array_map('trim', explode(',', $sopids));

        $questions = Question::whereIn('document_id', $sopids)
        ->inRandomOrder() // Randomize the order
        ->take(10)        // Limit to 10 records
        ->get();
        return view('frontend.TMS.Classroom_Training.classroom_question_Answer', compact('questions', 'onthejobid'));

    }

public function checkAnswerOTJ(Request $request)

{
    // Fetch all questions in a random order
    $allQuestions = Question::inRandomOrder()->get();

    // Filter questions to include only Single and Multi Selection Questions
    $filteredQuestions = $allQuestions->filter(function ($question) {
        return in_array($question->type, ['Single Selection Questions', 'Multi Selection Questions']);
    });

    // Take the first 10 questions from the filtered list
    $questions = $filteredQuestions->take(10);

    $correctCount = 0; // Initialize correct answer count
    $totalQuestions = $request->question_count; // Total number of selected questions (should be 10)

    foreach ($questions as $question) {
        // Retrieve user's answer for each question
        $userAnswer = $request->input('question_' . $question->id);
        $correctAnswers = unserialize($question->answers); // Correct answers for the question
        $questionType = $question->type;

        if ($questionType === 'Single Selection Questions') {
            // If it's a single selection question, check if the user's answer matches the correct answer
            if ($userAnswer == $correctAnswers[0]) {
                $correctCount++;
            }
        } elseif ($questionType === 'Multi Selection Questions') {
            // If it's a multi-selection question, check if the user's answer matches exactly with the correct answer set
            if (is_array($userAnswer)) {
                // Check if the user's answer matches exactly with the correct answer set
                if (count(array_diff($correctAnswers, $userAnswer)) === 0 && count(array_diff($userAnswer, $correctAnswers)) === 0) {
                    $correctCount++;
                }
            }
        }
    }

    // Calculate the correct percentage for the 10 questions
    $score = ($correctCount / $totalQuestions) * 100; // This will be based on 10 questions

   
    $result = $score >= 80 ? 'Pass' : 'Fail';

    if($request->attempt_count == 0 || $result == 'Pass'){
        $induction = ClassroomTraining::find($request->training_id);
        $induction->stage = 4;
        $induction->status = "Evaluation";
        $induction->update();
    }

        $storeResult = new EmpTrainingQuizResult();
        $storeResult->emp_id = $request->emp_id;
        $storeResult->training_id = $request->training_id;
        $storeResult->employee_name = $request->employee_name;
        $storeResult->department = $request->department;
        $storeResult->training_type = "Classroom Training";
        $storeResult->correct_answers = $correctCount;
        $storeResult->incorrect_answers = $totalQuestions - $correctCount;
        $storeResult->total_questions = $totalQuestions;
        $storeResult->score = $score."%";
        $storeResult->result = $result;
        $storeResult->attempt_number = $request->attempt_count + 1;
        $storeResult->save();       

    return view('frontend.TMS.Job_Training.job_quiz_result', [
        'totalQuestions' => $totalQuestions, // Total questions shown
        'correctCount' => $correctCount, // Number of correctly answered questions
        'score' => $score, // Final score for these 10 questions
        'result' => $result // Pass or Fail based on 80%
    ]);
}

public function showCertificate()
{
    // $employee = \App\Models\Employee::where('employee_id', $employee_id)->first();
    // $induction = \App\Models\Induction_training::where('employee_id', $employee_id)->first();

    return view('frontend.TMS.Classroom_Training.classroom_training_certificate');
}

public function saveReadingTime(Request $request)
{
    $sop_spent_time = $request->input('sop_spent_time');
    $id = $request->input('id');
    $ClassRoomTraining = ClassRoomTraining::findOrFail($id);

    $ClassRoomTraining->sop_spent_time = $sop_spent_time;
    $ClassRoomTraining->update();

    return response()->json(['success' => true]);
}


}
