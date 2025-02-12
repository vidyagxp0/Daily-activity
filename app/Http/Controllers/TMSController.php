<?php

namespace App\Http\Controllers;
use App\Models\ClassroomTraining;
use App\Models\DepartmentWiseEmployees;
use App\Models\TrainingSopEmployee;
use App\Models\YearlyTrainingPlanner;

use Illuminate\Support\Facades\Auth;
use App\Models\Document;
use App\Models\Department;
use App\Models\Training;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\Models\DocumentType;
use App\Models\EmpTrainingQuizResult;
use App\Models\UserRole;
use App\Models\DocumentTraining;
use App\Http\Controllers\Controller;
use App\Models\DocumentHistory;
use App\Models\Question;
use App\Models\Quize;
use App\Models\RoleGroup;
use App\Models\Employee;
use App\Models\JobTraining;
use App\Models\TrainingGrid;
use App\Models\ChangeControlTrainingData;
use App\Models\JobDescription;
use App\Models\TrainingAudit;
use App\Models\TrainingHistory;
use App\Models\TrainingStatus;
use App\Models\Induction_training;
use App\Models\Scorm;
use App\Models\TNIEmployee;
use App\Models\TNI;
use App\Models\TNIMatrixData;
use App\Models\DepartmentDocumentNumbers;
use App\Models\TniEmployeeDocument;
use App\Models\TNIGrid;
use App\Models\TrainerQualification;
use App\Models\TrainingMaterialManagement;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Helpers;
use Illuminate\Support\Facades\DB;
use PDF;
use Illuminate\Support\Facades\Http;
use App\Models\EquipmentLifecycleManagementTrainingData;

class TMSController extends Controller
{
    public function index(){
        // return dd(Helpers::checkRoles(6));
        $inductionTraining = Induction_training::get();
        $tniemployee = TNIEmployee::get();
        $jobTraining = JobDescription::get();
        $jobTraining = JobDescription::get();
        $trainingTMM = TrainingMaterialManagement::get();
        $employees = Employee::get();
        $employees = DB::table('employees')->get();
        $departmentwise = DepartmentWiseEmployees::get();
        $Tni = TNI::orderByDesc('id')->get();
        $dataYTP = YearlyTrainingPlanner::get();
        $jobTrainings = JobTraining::get();
        $classroomtraining = ClassroomTraining::get();
        $scormData = Scorm::get();
        $equipmentTraining = EquipmentLifecycleManagementTrainingData::where('trainees', Auth::user()->id)->leftjoin('users','users.id','equipment_lifecycle_management_training_data.trainees')->get(['equipment_lifecycle_management_training_data.*', 'users.name',  'users.departmentid']);

        if(Helpers::checkRoles(6)){
            $documents = DocumentTraining::where('trainer', Auth::user()->id)->with('root_document')->orderByDesc('id')->get();
           if($documents){
               foreach($documents as $temp){

                $temp->training = Document::find($temp->document_id);
                if($temp->training){
                    $temp->document_type_name = DocumentType::where('id',$temp->training->document_type_id)->value('name');
                    $temp->typecode = DocumentType::where('id',$temp->training->document_type_id)->value('typecode');
                    // $temp->division_name = QMSDivision::where('id',$temp->training->id)->value('name');
                    // $temp->division_name= {{ Helpers::getDivisionName($_GET['id'])}
                    $temp->division_name = Helpers::getDivisionName( $temp->training->division_id);
                    $temp->year = Carbon::parse($temp->training->created_at)->format('Y');
                    $temp->major = $temp->training->major;
                    $temp->minor = $temp->training->minor;


                }


            }
           }

            $due = DocumentTraining::where('trainer',Auth::user()->id)->where('status',"Past-due")->orderByDesc('id')->get();
            if(!empty($due)){
                foreach($due as $temp){
                $temp->training = Document::find($temp->document_id);
                if($temp->training){
                $temp->document_type_name = DocumentType::where('id',$temp->training->document_type_id)->value('name');
                $temp->typecode = DocumentType::where('id',$temp->training->document_type_id)->value('typecode');
                // $temp->division_name = QMSDivision::where('id',$temp->training->id)->value('name');
                $temp->division_name = Helpers::getDivisionName($temp->training->id);
                }
            }

            }

            $pending = DocumentTraining::where('trainer',Auth::user()->id)->where('status',"Pending")->orderByDesc('id')->get();
            if($pending){
                foreach($pending as $temp){

                $temp->training = Document::find($temp->document_id);
                 if($temp->training){
                $temp->document_type_name = DocumentType::where('id',$temp->training->document_type_id)->value('name');
                $temp->typecode = DocumentType::where('id',$temp->training->document_type_id)->value('typecode');
                // $temp->division_name = QMSDivision::where('id',$temp->training->division_id)->value('name');
                $temp->division_name = Helpers::getDivisionName($temp->training->id);
                 }
            }


            }

            $complete = DocumentTraining::where('trainer',Auth::user()->id)->where('status',"Complete")->orderByDesc('id')->get();
            if($complete){
                 foreach($complete as $temp){

                $temp->training = Document::find($temp->document_id);
                 if($temp->training){
                $temp->document_type_name = DocumentType::where('id',$temp->training->document_type_id)->value('name');
                $temp->typecode = DocumentType::where('id',$temp->training->document_type_id)->value('typecode');
                // $temp->division_name = QMSDivision::where('id',$temp->training->id)->value('name');
                $temp->division_name = Helpers::getDivisionName($temp->training->id);
                 }
            }
            }

            $documents2 =[];
            if (Helpers::checkRoles(1) || Helpers::checkRoles(2) || Helpers::checkRoles(3) || Helpers::checkRoles(4)|| Helpers::checkRoles(5) || Helpers::checkRoles(7) || Helpers::checkRoles(8))
            {
                $train = [];
                // $useDocFromJobTraining = JobTraining::where('employee_id' , 'PW1')->get();
                // $useDocFromInductionTraining = Induction_training::where('employee_id' , 'PW1')->get();
                    $training = Training::all();
                    foreach($training as $temp){
                    $data = explode(',',$temp->trainees);
                    if(count($data) > 0){
                        foreach($data as $datas){
                            if($datas == Auth::user()->id){
                                array_push($train,$temp);
                            }
                        }
                    }
                }

           if(count($train)>0){
            foreach($train as $temp){
                $explode = explode(',',$temp->sops);
                foreach($explode as $data_temp){
                    $doc = Document::find($data_temp);
                    array_push($documents2,$doc);
                }
            }
           }
           if(!empty($documents2)){
            foreach($documents2 as $temp){
                if($temp){
                    $temp->traningstatus = DocumentTraining::where('document_id',$temp->id)->first();

                }
            }
           }
            }

            // $employees = Employee::get();
            // dd($employees);

            $trainers = TrainerQualification::get();
            return view('frontend.TMS.dashboard', compact('Tni',  'documents2','documents','due','pending','complete', 'employees', 'trainers', 'inductionTraining', 'classroomtraining', 'jobTrainings','trainingTMM','tniemployee','departmentwise','dataYTP','scormData', 'equipmentTraining'));
        }
        else{
            $train = [];
            $employees = Employee::get();
           $training = Training::all();
           foreach($training as $temp){
           $data = explode(',',$temp->trainees);
           if(count($data) > 0){
            foreach($data as $datas){
                if($datas == Auth::user()->id){
                    array_push($train,$temp);
                }
            }
           }
           }
           $documents =[];
           if(count($train)>0){
            foreach($train as $temp){
                $explode = explode(',',$temp->sops);
                foreach($explode as $data_temp){
                    $doc = Document::find($data_temp);
                    array_push($documents,$doc);
                }
            }
           }
           if(!empty($documents)){
            foreach($documents as $temp){
                if($temp){
                    $temp->traningstatus = DocumentTraining::where('document_id',$temp->id)->first();

                }
            }
           }
           $documents2 =$documents;
           return view('frontend.TMS.dashboard',compact('documents','documents2','employees'));

        }
    }
    public function create(){
        if(Helpers::checkRoles(6) || Helpers::checkRoles(3)){

            $quize = Quize::where('trainer_id', Auth::user()->id)->get();
            $due = DocumentTraining::where('trainer', Auth::user()->id)->whereIn('status', ["Past-due", 'Assigned', 'Complete'])->get();
            $traineesPerson = UserRole::where(['q_m_s_roles_id' => 6])->distinct()->pluck('user_id');
            $employees = DB::table('employees')->get();
            foreach($due as $temp){
                $temp->training = Document::find($temp->document_id);
                if($temp->training){
                    $temp->originator = User::where('id',$temp->training->originator_id)->value('name');
                    $temp->document_type_name = DocumentType::where('id',$temp->training->document_type_id)->value('name');
                    $temp->typecode = DocumentType::where('id',$temp->training->document_type_id)->value('typecode');
                    // $temp->division_name = QMSDivision::where('id',$temp->training->division_id)->value('name');
                    $temp->division_name = Helpers::getDivisionName($temp->training->division_id);
                    $temp->major = $temp->training->major;
                    $temp->minor = $temp->training->minor;
                    $temp->year = Carbon::parse($temp->training->created_at)->format('Y');
                }
            }

            $users = User::where('role', '!=', 6)->get();

            foreach($users as $data){
                $data->department = Department::where('id',$data->departmentid)->value('name');
            }

            return view('frontend.TMS.create-training',compact('due','users','quize', 'traineesPerson','employees'));
        }else{
            abort(404);
        }
    }
    public function store(Request $request){
        if(Helpers::checkRoles(6)){
            $this->validate($request,[
                'traning_plan_name' =>'required|unique:trainings,traning_plan_name',
                'training_plan_type'=>'required',
                'effective_criteria'=>'required',
                'sops'=>'required',
                // 'trainees'=>'required',
              ]);
            $training = new Training();
            $training->trainner_id = Auth::user()->id;
            $training->site_division = $request->site_division;
            $training->traning_plan_name = $request->traning_plan_name;
            $training->training_plan_type = $request->training_plan_type;
            $training->effective_criteria = $request->effective_criteria;
            $training->trainee_criteria = $request->trainee_criteria;
            $training->quize = $request->quize;
            $training->training_start_date = $request->training_start_date;
            $training->training_end_date = $request->training_end_date;
            $training->assessment_required = $request->assessment_required;
            $training->department = implode(',', $request->department);
            $training->employee_name = implode(',', $request->employee_name);
            $training->desc = $request->desc;
            $training->Trainer = Auth::user()->id;
            $training->External_Trainer = $request->External_Trainer;
            $training->total_minimum_time = $request->total_minimum_time;
            $training->per_screen_run_time = $request->per_screen_run_time;

            $training->sops = !empty($request->sops) ? implode(',', $request->sops) : '';
            $training->classRoom_training = !empty($request->classRoom_training) ? implode(',', $request->classRoom_training) : '';
            // $training->trainees = !empty($request->trainees) ? implode(',', $request->trainees) : '';
            $training->trainees = implode(',', $request->trainees);

            if (!empty($request->training_attachment) && $request->file('training_attachment')) {
                $files = [];
                foreach ($request->file('training_attachment') as $file) {
                    $name = $request->traning_plan_name . 'training_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] =  $name; // Store the file path
                }
                // Save the file paths in the database
                $training->training_attachment = json_encode($files);
            }
            $training->save();          
            if($request->employee_name[0] != null){
                foreach (explode(',',$request->employee_name[0]) as $empId) {
                    // Create a new record for each employee
                    $trainingSopEmp = new TrainingSopEmployee();
                    $trainingSopEmp->training_id = $training->id; // Assuming you already have the $training object
                    $trainingSopEmp->training_name = $training->traning_plan_name; // Assuming $training has a 'name' attribute
                    $trainingSopEmp->sop_id = $training->sops; // Assuming you have the sop_id
                    $trainingSopEmp->training_type = $training->training_plan_type; // You can replace this if needed
                    $trainingSopEmp->emp_id = $empId; // Assign each employee ID individually
                    $trainingSopEmp->startDate = $training->training_start_date; // Assuming you have start_date from the request
                    $trainingSopEmp->endDate = $training->training_end_date; // Assuming you have end_date from the request
                    $trainingSopEmp->trainer = $training->trainner_id; // Assuming trainer_id comes from the request
                    $trainingSopEmp->total_minimum_time = $training->total_minimum_time; // Assuming this value comes from the request
                    $trainingSopEmp->per_screen_run_time = $training->per_screen_run_time; // Assuming this value comes from the request
                    $trainingSopEmp->sop_spent_time = $training->sop_spent_time; // Assuming this value comes from the request
                    $trainingSopEmp->attempt_count = 3; // Assuming this value comes from the request
                    $trainingSopEmp->quize = $training->quize; // Assuming this value comes from the request
                    $trainingSopEmp->status = 'Pending'; // Default value set to 'Pending'
                
                    // Save the record to the database for each employee
                    $trainingSopEmp->save();
                }
            }
            ////////////////////For Generating Meeting////////////////////////

            if ($request->training_plan_type === 'CBT') {
                try {
                    $response = Http::post('https://mms.mydemosoftware.com/api/generate/meeting', [

                        'initiator_id' => auth()->id(),
                        'initiator_name' => Auth::user()->name,
                        'initiator_email' => Auth::user()->email,
                        'schedule_start' => $request->training_start_date,
                        'schedule_end' => $request->training_end_date,
                        'desc' => $request->desc,
                        'users' => []
                    ]);

                    if ($response->failed()) {
                        return back()->withErrors('Failed to create meeting: ' . $response->body());
                    }

                } catch (\Exception $e) {
                    return back()->withErrors('Error creating meeting: ' . $e->getMessage());
                }
            }

            //////////////////////////////////////////////////////////////////

            $TrainingHistory = new TrainingHistory();
            $TrainingHistory->plan_id = $training->id;
            $TrainingHistory->sop_id = $training->sops;
            $TrainingHistory->activity_type = "Training plan created !";
            $TrainingHistory->previous = "Null";
            $TrainingHistory->current = $training->traning_plan_name;
            $TrainingHistory->comment = $request->document_name_comment;
            $TrainingHistory->user_id = Auth::user()->id;
            $TrainingHistory->user_name = Auth::user()->name;
            $TrainingHistory->origin_state = "Assigned";
            $TrainingHistory->save();

            if (!empty($request->sops) && is_array($request->sops)) {
                foreach ($request->sops as $data) {
                    $sop = DocumentTraining::where('document_id', $data)->first();

                    if ($sop) {

                        $sop->status = "Assigned";
                        $sop->training_plan = $training->id;
                        $sop->update();
                        $history = new DocumentHistory();
                        $history->document_id = $data;
                        $history->activity_type = "Training Assigned";
                        $history->previous = "No training plan";
                        $history->current = $training->training_plan_name;
                        $history->comment = "Training Assigned by training coordinator " . Auth::user()->name;
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->origin_state = "Pending-Training";
                        $history->save();
                    }
                }
            }



            // foreach($request->sops as $data){
            //     $sop =  DocumentTraining::where('document_id',$data)->first();
            //     $sop->status = "Assigned";
            //     $sop->training_plan = $training->id;
            //     $sop->update();
            //     $history = new DocumentHistory();
            //     $history->document_id = $data;
            //     $history->activity_type = "Training Assigned";
            //     $history->previous = "No training plan";
            //     $history->current = $training->training_plan_name;
            //     $history->comment = "Training Assigned by training coordinator " . Auth::user()->name;
            //     $history->user_id = Auth::user()->id;
            //     $history->user_name = Auth::user()->name;
            //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            //     $history->origin_state = "Pending-Training";
            //     $history->save();

            // }
            // foreach($request->trainees as $trainee){
            //     $user = User::find($trainee);
            //     try {
            //         Mail::send('mail.assign-training', ['document' => $training],
            //           function ($message) use ($user) {
            //                   $message->to($user->email)
            //                   ->subject("Training is assigned to you.");

            //           });
            //     } catch (\Exception $e) {
            //         // log later on
            //     }
            // }
            toastr()->success('Training Plan created successfully');
            return redirect('TMS/show');
        }
    }
    public function show(){
        if(Helpers::checkRoles(6)){
            $trainning = Training::where('trainner_id',Auth::user()->id)->get();
            $employees = DB::table('employees')->get();

            return view('frontend.TMS.manage-training',compact('trainning','employees'));
        }
    }
    public function viewTraining($id,$sopId){
        $doc = Document::find($sopId);
        $employees = DB::table('employees')->get();
        if(Helpers::checkRoles(6)){
            if (Helpers::checkRoles(1) || Helpers::checkRoles(2) || Helpers::checkRoles(3) || Helpers::checkRoles(4)|| Helpers::checkRoles(5) || Helpers::checkRoles(7) || Helpers::checkRoles(8))
            {
                $trainning = Training::find($id);
                $trainning->trainer = User::find($trainning->trainner_id);
                if(!empty($trainning->trainer)){
                    return view('frontend.TMS.document-view',compact('trainning','sopId', 'doc', 'employees'));
                }

            }
            $trainning = Training::where('trainner_id',Auth::user()->id)->get();
            return view('frontend.TMS.manage-training',compact('trainning', 'doc'));
        }
        else{
            $trainning = Training::find($id);
            $trainning->trainer = User::find($trainning->trainner_id);
            return view('frontend.TMS.document-view',compact('trainning','sopId', 'doc', 'employees'));
        }
    }
    public function training($id){

       $document = Document::find($id);
       $document_training = DocumentTraining::where('document_id',$id)->first();
       $training = Training::find($document_training->training_plan);
       $countAudit = TrainingAudit::where('trainee_id',Auth::user()->id)->where('sop_id',$id)->count();
       $audit = new TrainingAudit();
       $audit->trainee_id = Auth::user()->id;
       $audit->training_id = $document_training->training_plan;
       $audit->sop_id = $id;
       $audit->save();
       if($countAudit <= 2000 ){
            $TrainingHistory = new TrainingHistory();
            $TrainingHistory->plan_id = $training->id;
            $TrainingHistory->sop_id = $id;
            $TrainingHistory->activity_type = "Training Attempts of SOP " .$document->document_name;
            $TrainingHistory->previous = "SOP" .$training->status;
            $TrainingHistory->current ="Training Attempts of SOP " .$document->document_name;
            $TrainingHistory->comment = "NULL";
            $TrainingHistory->user_id = Auth::user()->id;
            $TrainingHistory->user_name = Auth::user()->name;
            $TrainingHistory->origin_state = "Assigned";
            $TrainingHistory->save();

        return view('frontend.TMS.training-page',compact('document','training'));
       }
       else{
        toastr()->warning('Your max attempts limit is breached');
        return back();
       }
    //    elseif($training->training_plan_type == "Read & Understand with Questions"){
    //     $quize = Quize::find($training->quize);
    //     $data = explode(',',$quize->question);
    //     $array = [];

    //     for($i = 0; $i<count($data); $i++){
    //         $question = Question::find($data[$i]);
    //         $question->id = $i+1;
    //         $json_option = unserialize($question->options);
    //         $options = [];
    //         foreach($json_option as $key => $value){
    //             $options[chr(97 + $key)] = $value;
    //         }
    //         $question->options = array($options);
    //         $ans = unserialize($question->answers);
    //         $question->answers = implode("", $ans);
    //         $question->score = 0;
    //         $question->status = "";
    //         // $json_answer = unserialize($question->answers);
    //         // $answers = [];
    //         // foreach($json_answer as $key => $value){
    //         //     $answers[chr(97 + $key)] = $value;
    //         // }
    //         // $question->answers = array($answers);
    //         array_push($array,$question);
    //     }
    //    $data_array = implode(',',$array);

    //     return view('frontend.TMS.question-training',compact('document','data_array','quize'));


    //    }

    }
    public function trainingQuestion($id){
        $document = Document::find($id);
        $document_training = DocumentTraining::where('document_id',$id)->first();
        $training = Training::find($document_training->training_plan);
        if($training->training_plan_type == "Read & Understand with Questions"){
            $quize = Quize::find($training->quize);
            $data = explode(',',$quize->question);
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
                // $json_answer = unserialize($question->answers);
                // $answers = [];
                // foreach($json_answer as $key => $value){
                //     $answers[chr(97 + $key)] = $value;
                // }
                // $question->answers = array($answers);
                array_push($array,$question);
            }
             $data_array = implode(',',$array);

            return view('frontend.TMS.example',compact('document','data_array','quize'));


       }
       else{
        toastr()->error('Training not specified');
        return back();
       }
    }

    // public function trainingSubmitData(Request $request,$id){


    // }
    public function trainingStatus(Request $request,$id){

        if(Auth::user()->email == $request->email && Hash::check($request->password,Auth::user()->password)){
            $document = DocumentTraining::where('document_id',$id)->first();
            $document->train = Training::find($document->training_plan);
            $trainingStatus = new TrainingStatus();
            $trainingStatus->user_id = Auth::user()->id;
            $trainingStatus->sop_id = $id;
            $trainingStatus->training_id = $document->training_plan;
            $trainingStatus->status = "Complete";
            $trainingStatus->save();
            $TrainingHistory = new TrainingHistory();
            $TrainingHistory->plan_id =  $document->training_plan;
            $TrainingHistory->sop_id =  $id;
            $TrainingHistory->activity_type = "Training Complete by " . Auth::user()->name;
            $TrainingHistory->previous = "Assigned";
            $TrainingHistory->current ="Complete";
            $TrainingHistory->comment = "NULL";
            $TrainingHistory->user_id = Auth::user()->id;
            $TrainingHistory->user_name = Auth::user()->name;
            $TrainingHistory->origin_state = "Assigned";
            $TrainingHistory->save();
            $history = new DocumentHistory();
            $history->document_id = $id;
            $history->activity_type = "Training Complete";
            $history->previous ="Training pending";
            $history->current = "Training Completed by " .Auth::user()->name;
            $history->comment = "Training Completed by " .Auth::user()->name;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = "Pending-Training";
            $history->save();
            $criteria = $this->effective($id);
            if(count(TrainingStatus::where('sop_id',$id)->where('training_id',$document->training_plan)->where('status',"Complete")->get()) >= $criteria){
                $document = DocumentTraining::where('document_id',$id)->first();
                $document->status = "Complete";
                $document->update();
                $history = new DocumentHistory();
                $history->document_id = $id;
                $history->activity_type = "Training Complete";
                $history->previous ="Training pending";
                $history->current = "Training Completed by " ."All trainees";
                $history->comment = "Training Completed by " ."All trainees";
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = "Pending-Training";
                $history->save();
                $TrainingHistory = new TrainingHistory();
                $TrainingHistory->plan_id =  $document->training_plan;
                $TrainingHistory->sop_id =  $id;
                $TrainingHistory->activity_type = "Training Complete for one Document ";
                $TrainingHistory->previous = "Assigned";
                $TrainingHistory->current ="Complete";
                $TrainingHistory->comment = "NULL";
                $TrainingHistory->user_id = Auth::user()->id;
                $TrainingHistory->user_name = Auth::user()->name;
                $TrainingHistory->origin_state = "Assigned";
                $TrainingHistory->save();
                $document->doc = Document::find($id);
                $document->doc->stage = 10;
                $document->doc->status = "Effective";
                $document->doc->update();
                $user_data = User::find($document->doc->originator_id);
                try {
                    Mail::send('mail.complete-training', ['document' => $document],
                      function ($message) use ($user_data) {
                              $message->to($user_data->email)
                              ->subject("Training is Completed.");

                      });
                } catch (\Exception $e) {
                    // log
                }

                try {
                    Mail::send('mail.effective', ['document' => $document],
                    function ($message) use ($user_data) {
                            $message->to($user_data->email)
                            ->subject("Document Effective Now.");
                    });
                } catch (\Exception $e) {
                    // log
                }

                $doc = Training::find($document->training_plan);
                $sop = explode(',',$doc->sops);

                if(count($sop) > 0){
                    $trainingArray = [];
                    foreach($sop as $sops){
                        $documentTrain = DocumentTraining::where('document_id',$sops)->where('status',"Complete")->first();
                        array_push($trainingArray,$documentTrain);
                    }
                    if(count($trainingArray) == count($sop)){
                        $document->train = Training::find($document->training_plan);
                        $document->train->status = "Complete";
                        $document->train->update();
                        $user = User::find($document->train->trainner_id);
                        try {
                            Mail::send('mail.training', ['document' => $document],
                              function ($message) use ($user) {
                                      $message->to($user->email)
                                      ->subject("Training is Completed.");

                              });
                        } catch (\Exception $e) {
                            //
                        }
                              $TrainingHistory = new TrainingHistory();
                              $TrainingHistory->plan_id =  $document->training_plan;
                              $TrainingHistory->sop_id =  $document->train->sops;
                              $TrainingHistory->activity_type = "Training Complete for all SOPs";
                              $TrainingHistory->previous = "Assigned";
                              $TrainingHistory->current ="Complete";
                              $TrainingHistory->comment = "NULL";
                              $TrainingHistory->user_id = Auth::user()->id;
                              $TrainingHistory->user_name = Auth::user()->name;
                              $TrainingHistory->origin_state = "Assigned";
                              $TrainingHistory->save();
                    }
                }
                toastr()->success('Training Complete Successfully !!');
                return redirect()->route('TMS.index');
            }
            else{
                $user = User::find($document->train->trainner_id);
                 try {
                    Mail::send('mail.training', ['document' => $document],
                    function ($message) use ($user) {
                            $message->to($user->email)
                            ->subject("Training is Completed by ".Auth::user()->name. " .");

                    });
                 } catch (\Exception $e) {
                    //
                 }
                  toastr()->success('Training Complete Successfully !!');
                  return redirect()->route('TMS.index');
            }



        }
        else{
            toastr()->error('E-signature not match');
            return back();
        }

     }

     public function effective($id){
        $documentTraining = DocumentTraining::where('document_id', $id)->first();
        $training = Training::find($documentTraining->training_plan);

        $trainees = explode(',',$training->trainees);
        $criteria = (count($trainees) * ($training->effective_criteria)/100);
        return $criteria;
     }

     public function notification($id){
        $document = Training::find($id);
        $document->trainner_id = User::where('id',$document->trainner_id)->first();
        $document->trainees = explode(',',$document->trainees);
        return view('frontend.training-notification',compact('document'));
    }



    public function edit($id){
        $train = Training::find($id);
        $traineesPerson = UserRole::where(['q_m_s_roles_id' => 6])->distinct()->pluck('user_id');
        $savedDepartmentId = explode(',', $train->department);
        $savedEmployeeIds = explode(',', $train->employee_name);
        $savedUserIds = explode(',', $train->trainees);

        $employees = DB::table('employees')->get();

        if(Helpers::checkRoles(6)){

            $quize = Quize::where('trainer_id', Auth::user()->id)->get();
            $due = DocumentTraining::where('trainer',Auth::user()->id)->where('status',"Past-due")->get();
            foreach($due as $temp){
                $temp->training = Document::find($temp->document_id);
                if($temp->training){
                $temp->originator = User::where('id',$temp->training->originator_id)->value('name');
                $temp->document_type_name = DocumentType::where('id',$temp->training->document_type_id)->value('name');
                $temp->typecode = DocumentType::where('id',$temp->training->document_type_id)->value('typecode');
                // $temp->division_name = QMSDivision::where('id',$temp->training->division_id)->value('name');
                $temp->division_name = Helpers::getDivisionName($temp->training->id);

                }
            }
            $users = User::where('role', '!=', 6)->get();
            foreach($users as $data){
                $data->department = Department::where('id',$data->departmentid)->value('name');
            }
            return view('frontend.TMS.edit-training',compact('due','users','quize','train', 'traineesPerson', 'savedDepartmentId', 'employees','savedEmployeeIds','savedUserIds'));
        }
    }

    public function update(Request $request, $id){
        $last = Training::find($id);
        if(Helpers::checkRoles(6)){
            $this->validate($request,[
                'traning_plan_name' =>'required',
                'training_plan_type'=>'required',
                'effective_criteria'=>'required',
              ]);

            $training = Training::find($id);
            $training->trainner_id = Auth::user()->id;
            $training->site_division = $request->site_division;
            $training->traning_plan_name = $request->traning_plan_name;
            $training->training_plan_type = $request->training_plan_type;
            $training->effective_criteria = $request->effective_criteria;
            $training->trainee_criteria = $request->trainee_criteria;
            $training->quize = $request->quize;
            $training->training_start_date = $request->training_start_date;
            $training->training_end_date = $request->training_end_date;
            $training->assessment_required = $request->assessment_required;
            $training->department = implode(',', $request->department);
            $training->employee_name = implode(',', $request->employee_name);
            $training->External_Trainer = $request->External_Trainer;
            $training->total_minimum_time = $request->total_minimum_time;
            $training->per_screen_run_time = $request->per_screen_run_time;

            // $training->sops = implode(',',$request->sops);
            // $training->classRoom_training = implode(',',$request->classRoom_training);
            $training->trainees = implode(',',$request->trainees);
            if($request->classRoom_training){
                $training->classRoom_training = implode(',',$request->classRoom_training);
            }
            if($request->sops){
                $training->sops = implode(',',$request->sops);
            }
            if($request->trainees){
                $training->trainees = implode(',',$request->trainees);
            }
            if (!empty ($request->training_attachment)) {
                $files = [];

                if ($training->training_attachment) {
                    $files = is_array(json_decode($training->training_attachment)) ? $training->training_attachment : [];
                }

                if ($request->hasfile('training_attachment')) {
                    foreach ($request->file('training_attachment') as $file) {
                        $name = $request->traning_plan_name . 'training_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                        $file->move('upload/', $name);
                        $files[] = $name;
                    }
                }
                $training->training_attachment = json_encode($files);
            }
            $training->update();

            if($request->employee_name[0] != null){
                foreach (explode(',',$request->employee_name[0]) as $empId) {
                    // Create a new record for each employee
                    $trainingSopEmp = new TrainingSopEmployee();
                    $trainingSopEmp->training_id = $training->id; // Assuming you already have the $training object
                    $trainingSopEmp->training_name = $training->traning_plan_name; // Assuming $training has a 'name' attribute
                    $trainingSopEmp->sop_id = $training->sops; // Assuming you have the sop_id
                    $trainingSopEmp->training_type = $training->training_plan_type; // You can replace this if needed
                    $trainingSopEmp->emp_id = $empId; // Assign each employee ID individually
                    $trainingSopEmp->startDate = $training->training_start_date; // Assuming you have start_date from the request
                    $trainingSopEmp->endDate = $training->training_end_date; // Assuming you have end_date from the request
                    $trainingSopEmp->trainer = $training->trainner_id; // Assuming trainer_id comes from the request
                    $trainingSopEmp->total_minimum_time = $training->total_minimum_time; // Assuming this value comes from the request
                    $trainingSopEmp->per_screen_run_time = $training->per_screen_run_time; // Assuming this value comes from the request
                    $trainingSopEmp->sop_spent_time = $training->sop_spent_time; // Assuming this value comes from the request
                    $trainingSopEmp->attempt_count = 3; // Assuming this value comes from the request
                    $trainingSopEmp->quize = $training->quize; // Assuming this value comes from the request
                    $trainingSopEmp->status = 'Pending'; // Default value set to 'Pending'
                
                    // Save the record to the database for each employee
                    $trainingSopEmp->save();
                }
            }
            if($training->traning_plan_name !== $last->traning_plan_name || !empty($request->traning_plan_comment)){
                $TrainingHistory = new TrainingHistory();
                $TrainingHistory->plan_id = $training->id;
                $TrainingHistory->sop_id = $training->sops;
                $TrainingHistory->activity_type = "Training plan Name";
                $TrainingHistory->previous = $last->traning_plan_name;
                $TrainingHistory->current = $training->traning_plan_name;
                $TrainingHistory->comment = $request->traning_plan_comment;
                $TrainingHistory->user_id = Auth::user()->id;
                $TrainingHistory->user_name = Auth::user()->name;
                $TrainingHistory->origin_state = "Assigned";
                $TrainingHistory->save();
            }
            if($training->training_plan_type !== $last->training_plan_type || !empty($request->training_plan_type_comment)){
                $TrainingHistory = new TrainingHistory();
                $TrainingHistory->plan_id = $training->id;
                $TrainingHistory->sop_id = $training->sops;
                $TrainingHistory->activity_type = "Training plan Type";
                $TrainingHistory->previous = $last->training_plan_type;
                $TrainingHistory->current = $training->training_plan_type;
                $TrainingHistory->comment = $request->training_plan_type_comment;
                $TrainingHistory->user_id = Auth::user()->id;
                $TrainingHistory->user_name = Auth::user()->name;
                $TrainingHistory->origin_state = "Assigned";
                $TrainingHistory->save();
            }
            if($training->effective_criteria !== $last->effective_criteria || !empty($request->effective_criteria_comment)){
                $TrainingHistory = new TrainingHistory();
                $TrainingHistory->plan_id = $training->id;
                $TrainingHistory->sop_id = $training->sops;
                $TrainingHistory->activity_type = "Effective criteria";
                $TrainingHistory->previous = $last->effective_criteria;
                $TrainingHistory->current = $training->effective_criteria;
                $TrainingHistory->comment = $request->effective_criteria_comment;
                $TrainingHistory->user_id = Auth::user()->id;
                $TrainingHistory->user_name = Auth::user()->name;
                $TrainingHistory->origin_state = "Assigned";
                $TrainingHistory->save();
            }

            if($training->quize !== $last->quize || !empty($request->quize_comment)){
                $TrainingHistory = new TrainingHistory();
                $TrainingHistory->plan_id = $training->id;
                $TrainingHistory->sop_id = $training->sops;
                $TrainingHistory->activity_type = "Quize";
                $TrainingHistory->previous = $last->quize;
                $TrainingHistory->current = $training->quize;
                $TrainingHistory->comment = $request->quize_comment;
                $TrainingHistory->user_id = Auth::user()->id;
                $TrainingHistory->user_name = Auth::user()->name;
                $TrainingHistory->origin_state = "Assigned";
                $TrainingHistory->save();
            }

            if($training->sops !== $last->sops || !empty($request->sops_comment)){
                $TrainingHistory = new TrainingHistory();
                $TrainingHistory->plan_id = $training->id;
                $TrainingHistory->sop_id = $training->sops;
                $TrainingHistory->activity_type = "Sops";
                $TrainingHistory->previous = $last->sops;
                $TrainingHistory->current = $training->sops;
                $TrainingHistory->comment = $request->sops_comment;
                $TrainingHistory->user_id = Auth::user()->id;
                $TrainingHistory->user_name = Auth::user()->name;
                $TrainingHistory->origin_state = "Assigned";
                $TrainingHistory->save();
            }

            if($training->trainees !== $last->trainees || !empty($request->trainees_comment)){
                $TrainingHistory = new TrainingHistory();
                $TrainingHistory->plan_id = $training->id;
                $TrainingHistory->sop_id = $training->trainees;
                $TrainingHistory->activity_type = "Trainees";
                $TrainingHistory->previous = $last->trainees;
                $TrainingHistory->current = $training->trainees;
                $TrainingHistory->comment = $request->trainees_comment;
                $TrainingHistory->user_id = Auth::user()->id;
                $TrainingHistory->user_name = Auth::user()->name;
                $TrainingHistory->origin_state = "Assigned";
                $TrainingHistory->save();
            }
            if($last->sops){
                $sop_data = explode(',',$last->sops);
                foreach($sop_data as $data){
                    if($training->traning_plan_name !== $last->traning_plan_name || !empty($request->traning_plan_comment)){
                        $history = new DocumentHistory();
                        $history->document_id = $data;
                        $history->activity_type = "Training plan Name";
                        $history->previous = $last->traning_plan_name;
                        $history->current = $training->training_plan_name;
                        $history->comment = $request->traning_plan_comment;
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->origin_state = "Pending-Training";
                        $history->save();
                    }
                    if($training->training_plan_type !== $last->training_plan_type || !empty($request->training_plan_type_comment)){
                        $history = new DocumentHistory();
                        $history->document_id = $data;
                        $history->activity_type = "Training plan Type";
                        $history->previous = $last->training_plan_type;
                        $history->current = $training->training_plan_type;
                        $history->comment = $request->training_plan_type_comment;
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->origin_state = "Pending-Training";
                        $history->save();
                    }

                    if($training->effective_criteria !== $last->effective_criteria || !empty($request->effective_criteria_comment)){
                        $history = new DocumentHistory();
                        $history->document_id = $data;
                        $history->activity_type = "Effective criteria";
                        $history->previous = $last->effective_criteria;
                        $history->current = $training->effective_criteria;
                        $history->comment = $request->effective_criteria_comment;
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->origin_state = "Pending-Training";
                        $history->save();
                    }

                    if($training->quize !== $last->quize || !empty($request->quize_comment)){
                        $history = new DocumentHistory();
                        $history->document_id = $data;
                        $history->activity_type = "quize";
                        $history->previous = $last->quize;
                        $history->current = $training->quize;
                        $history->comment = $request->quize_comment;
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->origin_state = "Pending-Training";
                        $history->save();
                    }

                    if($training->trainees !== $last->trainees || !empty($request->trainees_comment)){
                        $history = new DocumentHistory();
                        $history->document_id = $data;
                        $history->activity_type = "Trainees";
                        $history->previous = $last->trainees;
                        $history->current = $training->trainees;
                        $history->comment = $request->trainees_comment;
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->origin_state = "Pending-Training";
                        $history->save();
                    }

                }
            }

            if($request->trainees){
                foreach($request->trainees as $trainee){
                    $user = User::find($trainee);
                    try {
                        Mail::send('mail.assign-training', ['document' => $training],
                        function ($message) use ($user) {
                                $message->to($user->email)
                                ->subject("Training is assigned to you.");

                        });
                    } catch (\Exception $e) {
                        //
                    }
                }
           }
            toastr()->success('Training Plan updated successfully');
            return redirect('TMS/show');
        }
    }


    function auditTrial($id){
        $audit = TrainingHistory::where('plan_id',$id)->orderByDESC('id')->get()->unique('activity_type');
        $today = Carbon::now()->format('d-m-y');
        $document = Training::find($id);

        $document->originator = User::where('id',$document->trainner_id)->value('name');
        return view('frontend.TMS.audit-trial',compact('audit','document','today'));
      }

      function auditDetails($id){
        $detail = TrainingHistory::find($id);
        $detail_data = TrainingHistory::where('activity_type', $detail->activity_type)->where('plan_id',$detail->plan_id)->latest()->get();
        $doc = Training::where('id',$detail->plan_id)->first();

        $doc->origiator_name = User::find($doc->trainner_id);
      return view('frontend.change-control.audit-trial-inner',compact('detail','doc','detail_data'));
    }







    //---------------------------------------------------EXAMPLE---------------------------

    public function example($id){
        $document = Document::find($id);
        $document_training = DocumentTraining::where('document_id',$id)->first();
        $training = Training::find($document_training->training_plan);
        if($training->training_plan_type == "Read & Understand with Questions"){
            $quize = Quize::find($training->quize);
            $data = explode(',',$quize->question);

            $data_array = [];
            for($i = 0; $i < count($data); $i++){
                //question
                $question = Question::find($data[$i]);
                $question->id = $i+1;

                //Options
                $json_option = unserialize($question->options);
                $options = [];
                foreach($json_option as $key => $value){
                    if(!is_null($value)){
                        array_push($options,$value);
                    }
                }
                $question->choices =$options;
                //Answers
                $json_answer = unserialize($question->answers);
                $answers = [];


                if($question->type == "Exact Match Questions"){
                    foreach($json_answer as $key => $value){
                       $answers = $value;
                    }
                }
                elseif($question->type == "Multi Selection Questions"){
                    foreach($json_answer as $key => $value){
                        foreach($options as $key1 => $option){
                            if($key1 == $value){
                            array_push($answers,$key);
                            }
                        }

                    }
                }
                elseif($question->type == "Single Selection Questions"){

                    foreach($json_answer as $key => $value){
                        foreach($options as $key1 => $option){
                            if($key1 == $value){
                              $answers = intval($value);

                            }
                        }

                    }
                }

                 $question->answer = $answers;
                array_push($data_array,$question);
            }
            //  $data_array = implode(',',$array);
             return $data_array;
        //    return view('frontend.TMS.example',compact('document','data_array','quize'));


       }
       else{
        toastr()->error('Training not specified');
        return back();
       }
    }

    public function trainingOverallStatus($id){
        $training = Training::where('id', $id)->latest()->first();

        if (!$training) {
            toastr()->error('Training plan not found');
            return back();
        }

        // Extract SOP IDs from the comma-separated string
        $sopIds = explode(',', $training->sops);
        $userIds = explode(',', $training->employee_name);

        // Query SOP records
        $sops = Document::whereIn('id', $sopIds)->get();
        $trainingUsers = Employee::whereIn('id', $userIds)->get();
        $trainingEmpResult = TrainingSopEmployee::where('training_id', $id)->get();

        $allEmpResults = collect(); // Initialize an empty collection to store results

        foreach ($trainingEmpResult as $result) {
            $empResults = EmpTrainingQuizResult::where([
                'training_type' => 'SOP Training',
                'training_id' => $result->id,
            ])->get();

            // Merge results into the collection
            $allEmpResults = $allEmpResults->merge($empResults);
        }

        // Query Training Status records for the given training ID and SOP IDs
        // $trainingStatus = TrainingStatus::where('training_id', $id)
        //                                  ->whereIn('sop_id', $sopIds)
        //                                  ->get();


        return view('frontend.TMS.training-overall-status',compact('sops','training','trainingUsers', 'allEmpResults', 'trainingEmpResult'));
    }





    public function TMSTraining(Request $request, $id = null)
    {
            $trainingStartDates = [];
            $today = \Carbon\Carbon::today();
            $loggedInUserId = Auth::guard('employee')->user()->id;

            ChangeControlTrainingData::where('trainees', $loggedInUserId)->get()->each(function ($query) use (&$trainingStartDates, $today) {
                $end_date = \Carbon\Carbon::parse($query->endDate);
                $daysLeft = $today->diffInDays($end_date, false);

                if ($daysLeft > 7) {
                    $backgroundColor = 'green';
                } elseif ($daysLeft > 1 && $daysLeft <= 7) {
                    $backgroundColor = 'yellow';
                } else {
                    $backgroundColor = 'red';
                }

                $trainingStartDates[] = [
                    'type' => 'CC',
                    'title' => 'Change Control Training',
                    'start' => $end_date->toDateString(),
                    'backgroundColor' => $backgroundColor
                ];
            });

            Induction_training::where('name_employee', $loggedInUserId)->get()->each(function ($query) use (&$trainingStartDates, $today) {
                $end_date = \Carbon\Carbon::parse($query->end_date);
                $daysLeft = $today->diffInDays($end_date, false);

                if ($daysLeft > 7) {
                    $backgroundColor = 'green';
                } elseif ($daysLeft > 1 && $daysLeft <= 7) {
                    $backgroundColor = 'yellow';
                } else {
                    $backgroundColor = 'red';
                }

                $trainingStartDates[] = [
                    'type' => 'Induction',
                    'title' => 'Induction Training',
                    'start' => $end_date->toDateString(),
                    'backgroundColor' => $backgroundColor
                ];
            });

            JobTraining::where('employee_id', Auth::guard('employee')->user()->full_employee_id)->get()->each(function ($query) use (&$trainingStartDates, $today) {
                $end_date = \Carbon\Carbon::parse($query->end_date);
                $daysLeft = $today->diffInDays($end_date, false);

                if ($daysLeft > 7) {
                    $backgroundColor = 'green';
                } elseif ($daysLeft > 1 && $daysLeft <= 7) {
                    $backgroundColor = 'yellow';
                } else {
                    $backgroundColor = 'red';
                }

                $trainingStartDates[] = [
                    'type' => 'On The Job',
                    'title' => 'On The Job Training',
                    'start' => $end_date->toDateString(),
                    'backgroundColor' => $backgroundColor
                ];
            });

            ClassroomTraining::where('name', Auth::guard('employee')->user()->employee_name)->get()->each(function ($query) use (&$trainingStartDates, $today) {
                $end_date = \Carbon\Carbon::parse($query->end_date);
                $daysLeft = $today->diffInDays($end_date, false);

                if ($daysLeft > 7) {
                    $backgroundColor = 'green';
                } elseif ($daysLeft > 1 && $daysLeft <= 7) {
                    $backgroundColor = 'yellow';
                } else {
                    $backgroundColor = 'red';
                }

                $trainingStartDates[] = [
                    'type' => 'Classroom',
                    'title' => 'Classroom Training',
                    'start' => $end_date->toDateString(),
                    'backgroundColor' => $backgroundColor
                ];
            });

            $emplloyeeDesg = Auth::guard('employee')->user()->job_title;
            $TNIData = TNIMatrixData::all();
            if(!empty($TNIData)){
                foreach($TNIData as $data){
                    $designationList = explode(',', $data['designation']);
                    $checkDesignation = in_array(trim($emplloyeeDesg), array_map('trim', $designationList));
                    if($checkDesignation){
                        try {
                            TNIMatrixData::get()->each(function ($query) use (&$trainingStartDates, $today) {
                                $end_date = \Carbon\Carbon::parse($query->endDate);
                                $daysLeft = $today->diffInDays($end_date, false);
                
                                if ($daysLeft > 7) {
                                    $backgroundColor = 'green';
                                } elseif ($daysLeft > 1 && $daysLeft <= 7) {
                                    $backgroundColor = 'yellow';
                                } else {
                                    $backgroundColor = 'red';
                                }
                
                                $trainingStartDates[] = [
                                    'type' => 'Designation',
                                    'title' => 'Designation Training',
                                    'start' => $end_date->toDateString(),
                                    'backgroundColor' => $backgroundColor
                                ];
                            });
                        } catch (\Throwable $th) {
                            // dd($th);
                        }
                    }
                }
            }


            $getEmployeeData = Auth::guard('employee')->user();
            $getEmpJob = $getEmployeeData->emp_job;
            $jobRoleData = DepartmentDocumentNumbers::all();
            foreach ($jobRoleData as $jobRole) {
                $jobRoleList = explode(',', $jobRole['job_role']);
                $checkDesignation = in_array(trim($getEmpJob), array_map('trim', $jobRoleList));
                if($checkDesignation && Auth::guard('employee')->user()->id == $jobRole->employee_name){
                    try {
                        DepartmentDocumentNumbers::get()->each(function ($query) use (&$trainingStartDates, $today) {
                            $end_date = \Carbon\Carbon::parse($query->end_date);
                            $daysLeft = $today->diffInDays($end_date, false);
            
                            if ($daysLeft > 7) {
                                $backgroundColor = 'green';
                            } elseif ($daysLeft > 1 && $daysLeft <= 7) {
                                $backgroundColor = 'yellow';
                            } else {
                                $backgroundColor = 'red';
                            }
            
                            $trainingStartDates[] = [
                                'type' => 'Job Role',
                                'title' => 'Job Role Training',
                                'start' => $end_date->toDateString(),
                                'backgroundColor' => $backgroundColor
                            ];
                        });
                    } catch (\Throwable $th) {
                        //throw $th;
                    }
                }
            }


            // return dd(Helpers::checkRoles(6));
            $inductionTraining = Induction_training::get();
            $jobTraining = JobDescription::get();
            $jobTrainings = JobTraining::get();
            $changeControlTraining = TrainingGrid::get();


            $userId = Auth::guard('employee')->user()->id;
            $ccTrainingData = ChangeControlTrainingData::where('trainees', $userId)->leftjoin('employees','employees.id','change_control_training_datas.trainees')->get(['change_control_training_datas.*', 'employees.full_employee_id', 'employees.employee_name', 'employees.department']);

            // $filteredData = [];

            // foreach ($data as $record) {
            //     $matchingData = $record ? (is_array($record->data) ? $record->data : json_decode($record->data, true)) : [];
            
            //     $filteredMatchingData = array_filter($matchingData, function($item) use ($userId) {
            //         return $item['trainees'] == $userId;
            //     });
            
            //     if ($filteredMatchingData) {
            //         $employee = Employee::find($userId);
            
            //         $filteredData[] = [
            //             'id' => $record->id,
            //             'identifier' => $record->identifier,
            //             'matchingData' => $filteredMatchingData,
            //             'employee' => $employee
            //         ];
            //     }
            // }

            // dd($matchingData);
            



            // $userTraineeId = Auth::id();
            // $records = TrainingGrid::all();
            // $filteredData = [];

            // foreach ($records as $record) {
            //     $trainingData = json_decode($record->data, true);
            //     $matchingData = array_filter($trainingData, function ($item) use ($userTraineeId) {
            //         return $item['trainees'] == $userTraineeId;
            //     });

            //     if (!empty($matchingData)) {
            //         $filteredData[] = [
            //             'id' => $record->id,
            //             'cc_id' => $record->cc_id,
            //             'identifier' => $record->identifier,
            //             'matchingData' => $matchingData
            //         ];
            //     }
            // }


            // return $changeControlTraining

            $departmentRoles = DepartmentDocumentNumbers::get();
            $classroomtraining = ClassroomTraining::get();
            $tniMatrixGrid = TNIGrid::get();
            
            $tniMg = TNIMatrixData::where('department', Helpers::getDepartmentNameFromCode(Auth::guard('employee')->user()->department))->get();
            $tniEmp = TniEmployeeDocument::get();

            
                $documents = DocumentTraining::where('trainer', Auth::guard('employee')->user()->employee_name)->with('root_document')->orderByDesc('id')->get();
               if($documents){
                   foreach($documents as $temp){

                    $temp->training = Document::find($temp->document_id);
                    if($temp->training){
                        $temp->document_type_name = DocumentType::where('id',$temp->training->document_type_id)->value('name');
                        $temp->typecode = DocumentType::where('id',$temp->training->document_type_id)->value('typecode');
                        // $temp->division_name = QMSDivision::where('id',$temp->training->id)->value('name');
                        // $temp->division_name= {{ Helpers::getDivisionName($_GET['id'])}
                        $temp->division_name = Helpers::getDivisionName( $temp->training->division_id);
                        $temp->year = Carbon::parse($temp->training->created_at)->format('Y');
                        $temp->major = $temp->training->major;
                        $temp->minor = $temp->training->minor;


                    }


                }
               }



                $due = DocumentTraining::where('trainer',Auth::guard('employee')->user()->employee_name)->where('status',"Past-due")->orderByDesc('id')->get();
                if(!empty($due)){
                    foreach($due as $temp){
                    $temp->training = Document::find($temp->document_id);
                    if($temp->training){
                    $temp->document_type_name = DocumentType::where('id',$temp->training->document_type_id)->value('name');
                    $temp->typecode = DocumentType::where('id',$temp->training->document_type_id)->value('typecode');
                    // $temp->division_name = QMSDivision::where('id',$temp->training->id)->value('name');
                    $temp->division_name = Helpers::getDivisionName($temp->training->id);
                    }
                }

                }

                $pending = DocumentTraining::where('trainer',Auth::guard('employee')->user()->employee_name)->where('status',"Pending")->orderByDesc('id')->get();
                if($pending){
                    foreach($pending as $temp){

                    $temp->training = Document::find($temp->document_id);
                     if($temp->training){
                    $temp->document_type_name = DocumentType::where('id',$temp->training->document_type_id)->value('name');
                    $temp->typecode = DocumentType::where('id',$temp->training->document_type_id)->value('typecode');
                    // $temp->division_name = QMSDivision::where('id',$temp->training->division_id)->value('name');
                    $temp->division_name = Helpers::getDivisionName($temp->training->id);
                     }
                }


                }

                $complete = DocumentTraining::where('trainer',Auth::guard('employee')->user()->employee_name)->where('status',"Complete")->orderByDesc('id')->get();
                if($complete){
                     foreach($complete as $temp){

                    $temp->training = Document::find($temp->document_id);
                     if($temp->training){
                    $temp->document_type_name = DocumentType::where('id',$temp->training->document_type_id)->value('name');
                    $temp->typecode = DocumentType::where('id',$temp->training->document_type_id)->value('typecode');
                    // $temp->division_name = QMSDivision::where('id',$temp->training->id)->value('name');
                    $temp->division_name = Helpers::getDivisionName($temp->training->id);
                     }
                }
                }

                $documents2 =[];
                    $train = [];
                    $useDocFromJobTraining = JobTraining::where('employee_id' , Auth::guard('employee')->user()->full_employee_id)->get();
                    $useDocFromClassroom = ClassroomTraining::where('employee_id', Auth::guard('employee')->user()->full_employee_id)->get();
                    $useDocFromInductionTraining = Induction_training::where('employee_id' , Auth::guard('employee')->user()->full_employee_id)->get();

                    $useDocFromDepartmentRole = DepartmentWiseEmployees::where('employee_code' , Auth::guard('employee')->user()->full_employee_id)->get();
                    $useDocFromTNIm = TNIMatrixData::where('tni_id' , Auth::guard('employee')->user()->job_title)->get();

                        $training = Training::all();
                        foreach($training as $temp){
                        $data = explode(',',$temp->trainees);
                        if(count($data) > 0){
                            foreach($data as $datas){
                                if($datas == Auth::user()->id){
                                    array_push($train,$temp);
                                }
                            }
                        }
                    }

                    if(count($train)>0){
                        foreach($train as $temp){
                            $explode = explode(',',$temp->sops);
                            foreach($explode as $data_temp){
                                $doc = Document::find($data_temp);
                                array_push($documents2,$doc);
                            }
                        }
                    }
                    if(!empty($documents2)){
                        foreach($documents2 as $temp){
                            if($temp){
                                $temp->traningstatus = DocumentTraining::where('document_id',$temp->id)->first();

                            }
                        }
                    }

                $employees = Employee::get();
                $trainingData = TrainingSopEmployee::where(['emp_id' => Auth::guard('employee')->user()->id])->get();
// dd($trainingData/);
                $trainers = TrainerQualification::get();
                return view('frontend.layout.TMS-Training', compact('useDocFromJobTraining', 'useDocFromClassroom', 'useDocFromInductionTraining', 'documents2','documents','due','pending','complete', 'employees', 'trainers', 'inductionTraining', 'jobTrainings','departmentRoles','useDocFromDepartmentRole','tniMg','useDocFromTNIm','ccTrainingData','changeControlTraining','tniMatrixGrid', 'trainingStartDates','tniEmp', 'trainingData'));


    }

    public function YearlyTraining(Request $request)
    {
        $trainings = [];
        $topic = Training::all();
        $planner = YearlyTrainingPlanner::all();
        // dd($users);
        return view('frontend.layout.Yearly-Training', compact('trainings','topic','planner'));

    }

    public function YearlyTrainingPost(Request $request)
    {
        $trainings = [];
        $topic = Training::all();
        $department_location = YearlyTrainingPlanner::all();
        $planner = YearlyTrainingPlanner::where('site_division', $request->input('site_division_1'))->where('department', $request->input('site_division_2'))->where('year', $request->input('site_division_3'))->get();
        // dd($request->all());
        return view('frontend.layout.Yearly-Training', compact('trainings','topic','planner','department_location'));

    }

    public function EmployeeTrainingHistory(Request $request)
    {
        $trainings = [];
        $topic = Training::all();
        $employees = Employee::all();
        return view('frontend.layout.employee-training-history', compact('trainings','topic','employees'));

    }
    
    public function TrainingHistory(Request $request)
    {
        $employee = Employee::find(1);
        // Retrieve the selected values from the request
        $employeeId = $request->input('employee_id');
        $trainingType = $request->input('training_type');
        $department = $request->input('department');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Initialize an empty collection to store filtered data
        $filteredData = collect();
        $selectedCode = Helpers::getEmpNameById($employeeId);
        $historyTraining = EmpTrainingQuizResult::where(['emp_id'=> $selectedCode, 'training_type' => $trainingType])->get();

        // Check the selected training type and perform the respective query
        if ($trainingType == "Induction Training" && $historyTraining) {
            foreach($historyTraining as $history){
                $query = Induction_training::find( $history->training_id);
                if ($startDate) {
                    $query->where('start_date', '>=', $startDate);
                }
    
                if ($endDate) {
                    $query->where('end_date', '<=', $endDate);
                }
                $history->trainingDetails = $query;
            }

        } elseif ($trainingType == "On The Job Training" && $historyTraining) {
            foreach($historyTraining as $history){
                $query = JobTraining::find( $history->training_id);
                if ($startDate) {
                    $query->where('start_date', '>=', $startDate);

                }
    
                if ($endDate) {
                    $query->where('end_date', '<=', $endDate);

                }
                $history->trainingDetails = $query;
            }
        } elseif ($trainingType == "Classroom Training" && $historyTraining) {
            foreach($historyTraining as $history){
                $query = ClassroomTraining::find( $history->training_id);
                if ($startDate) {
                    $query->where('start_date', '>=', $startDate);
                }
    
                if ($endDate) {
                    $query->where('end_date', '<=', $endDate);
                }
                $history->trainingDetails = $query;
            }
        }
        return view('frontend.layout.employee-training-history', ['trainings' => $historyTraining, 'trainingType'=>$trainingType, 'department'=>$department, 'employeeId'=>$employeeId, 'endDate'=>$endDate, 'startDate'=>$startDate]);
    }

    public function SOPTrainingHistory(Request $request)
    {
        $trainings = [];
        $topic = Training::all();
        $employees = Employee::all();
        return view('frontend.layout.sop-training-history', compact('trainings','topic','employees'));

    }

    public function SOPHistory(Request $request)
    {
        $employee = Employee::find(1);
        // Retrieve the selected values from the request
        $sopId = $request->input('sop_id');
        $trainingType = $request->input('training_type');
        $department = $request->input('department');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $filteredRecords = collect();

        $filteredData = collect();
        $selectedCode = Helpers::getEmpNameById(1);

        $historyTraining = EmpTrainingQuizResult::where(['emp_id'=> $selectedCode, 'training_type' => $trainingType])->get();

        if ($trainingType == "Induction Training") {
            // Fetch induction training records for the specified department
            $inductionTrainingDepartment = Induction_training::where('department', $department)->get();

            foreach ($inductionTrainingDepartment as $key => $value) {
                $getSOPNo = [
                    'document_number_1', 'document_number_2', 'document_number_3', 'document_number_4', 'document_number_5',
                    'document_number_6', 'document_number_7', 'document_number_8', 'document_number_9', 'document_number_10',
                    'document_number_11', 'document_number_12', 'document_number_13', 'document_number_14', 'document_number_15',
                    'document_number_16'
                ];
                $inductionTrainingDoc = []; // Array to hold SOP document numbers

                if ($value) {
                    foreach ($getSOPNo as $key => $document) {
                        $documentColumn = 'document_number_' . ($key + 1);

                        // Collect all non-null document numbers
                        if (isset($value->$documentColumn) && !is_null($value->$documentColumn)) {
                            $inductionTrainingDoc[] = $value->$documentColumn;
                        }
                    }
                }

               // Check if the requested SOP ID exists in the array
                if (in_array($sopId, $inductionTrainingDoc)) {
                    // Filter records based on start_date and end_date
                    $query = Induction_training::where('id', $value->id);

                    if ($startDate) {
                        $query->where('start_date', '>=', $startDate);
                    }

                    if ($endDate) {
                        $query->where('end_date', '<=', $endDate);
                    }

                    $filteredRecord = $query->first(); // Fetch the filtered record

                    if ($filteredRecord) {
                        $filteredRecords->push($filteredRecord); // Add to the filtered collection
                    }
                }
            }
        }  elseif ($trainingType == "On The Job Training") {
            // Fetch induction training records for the specified department
            $OnTheJobTrainingDepartment = JobTraining::where('department', $department)->get();

            foreach ($OnTheJobTrainingDepartment as $key => $value) {
                $getSOPNo = [
                    'reference_document_no_1', 'reference_document_no_2', 'reference_document_no_3', 'reference_document_no_4', 'reference_document_no_5'
                ];
                $OnTheJobTrainingDoc = []; // Array to hold SOP document numbers

                if ($value) {
                    foreach ($getSOPNo as $key => $document) {
                        $documentColumn = 'reference_document_no_' . ($key + 1);

                        // Collect all non-null document numbers
                        if (isset($value->$documentColumn) && !is_null($value->$documentColumn)) {
                            $OnTheJobTrainingDoc[] = $value->$documentColumn;
                        }
                    }
                }

               // Check if the requested SOP ID exists in the array
                if (in_array($sopId, $OnTheJobTrainingDoc)) {
                    // Filter records based on start_date and end_date
                    $query = JobTraining::where('id', $value->id);

                    if ($startDate) {
                        $query->where('start_date', '>=', $startDate);
                    }

                    if ($endDate) {
                        $query->where('end_date', '<=', $endDate);
                    }

                    $filteredRecord = $query->first(); // Fetch the filtered record

                    if ($filteredRecord) {
                        $filteredRecords->push($filteredRecord); // Add to the filtered collection
                    }
                }
            }
        }  elseif ($trainingType == "Classroom Training") {
            // Fetch induction training records for the specified department
            $ClassroomTrainingDepartment = ClassroomTraining::where('department', $department)->get();

            foreach ($ClassroomTrainingDepartment as $key => $value) {
                $getSOPNo = [
                    'reference_document_no_1', 'reference_document_no_2', 'reference_document_no_3', 'reference_document_no_4', 'reference_document_no_5'
                ];
                $ClassroomTrainingDoc = []; // Array to hold SOP document numbers

                if ($value) {
                    foreach ($getSOPNo as $key => $document) {
                        $documentColumn = 'reference_document_no_' . ($key + 1);

                        // Collect all non-null document numbers
                        if (isset($value->$documentColumn) && !is_null($value->$documentColumn)) {
                            $ClassroomTrainingDoc[] = $value->$documentColumn;
                        }
                    }
                }

               // Check if the requested SOP ID exists in the array
                if (in_array($sopId, $ClassroomTrainingDoc)) {
                    // Filter records based on start_date and end_date
                    $query = ClassroomTraining::where('id', $value->id);

                    if ($startDate) {
                        $query->where('start_date', '>=', $startDate);
                    }

                    if ($endDate) {
                        $query->where('end_date', '<=', $endDate);
                    }

                    $filteredRecord = $query->first(); // Fetch the filtered record

                    if ($filteredRecord) {
                        $filteredRecords->push($filteredRecord); // Add to the filtered collection
                    }
                }
            }
        }

        // dd($filteredRecords);
        return view('frontend.layout.sop-training-history', ['trainings' => $historyTraining, 'trainingType'=>$trainingType, 'department'=>$department, 'employeeId'=>$sopId, 'endDate'=>$endDate, 'startDate'=>$startDate]);
    }

    public function TrainingAttandance(Request $request)
    {
        $trainings = [];
        $topic = Training::all();
        // dd($users);
        return view('frontend.layout.training-attandance', compact('trainings','topic'));

    }

    public function Listofqualifiedtrainers(Request $request)
    {
        // $trainings = [];
        // $topic = Training::all();
        // $employees = Employee::all();
        $trainers = TrainerQualification::get();
        return view('frontend.layout.list-of-qualified-trainers',compact('trainers'));

    }

    public function ListofqualifiedtrainersPost(Request $request)
    {
        // $trainings = [];
        // $topic = Training::all();
        // $employees = Employee::all();
        // $trainers = TrainerQualification::get();
        $trainers = TrainerQualification::where('site_code', $request->input('site_code'))->where('department', $request->input('site_division_2'))->get();
        // dd( $request->all());
        return view('frontend.layout.list-of-qualified-trainers',compact('trainers'));

    }

    public function TrainingModuleNumberingLog(Request $request)
    {

        $trainingTMM = TrainingMaterialManagement::all();
        return view('frontend.layout.TMMReport', compact('trainingTMM'));
    }

    public function TNIMatrix()
    {

        return view('frontend.layout.TNIMatrix');
    }

    public function analyticsShow(){

        
        /******* Calender Data Starts ********/
        $trainingStartDates = [];
        $today = \Carbon\Carbon::today();

        ChangeControlTrainingData::get()->each(function ($query) use (&$trainingStartDates, $today) {
            $end_date = \Carbon\Carbon::parse($query->endDate);
            $daysLeft = $today->diffInDays($end_date, false);

            if ($daysLeft > 7) {
                $backgroundColor = 'green';
            } elseif ($daysLeft > 1 && $daysLeft <= 7) {
                $backgroundColor = 'yellow';
            } else {
                $backgroundColor = 'red';
            }

            $trainingStartDates[] = [
                'type' => 'CC',
                'title' => 'Change Control Training',
                'start' => $end_date->toDateString(),
                'backgroundColor' => $backgroundColor
            ];
        });

        Induction_training::get()->each(function ($query) use (&$trainingStartDates, $today) {
            $end_date = \Carbon\Carbon::parse($query->end_date);
            $daysLeft = $today->diffInDays($end_date, false);

            if ($daysLeft > 7) {
                $backgroundColor = 'green';
            } elseif ($daysLeft > 1 && $daysLeft <= 7) {
                $backgroundColor = 'yellow';
            } else {
                $backgroundColor = 'red';
            }

            $trainingStartDates[] = [
                'type' => 'Induction',
                'title' => 'Induction Training',
                'start' => $end_date->toDateString(),
                'backgroundColor' => $backgroundColor
            ];
        });

        JobTraining::get()->each(function ($query) use (&$trainingStartDates, $today) {
            $end_date = \Carbon\Carbon::parse($query->end_date);
            $daysLeft = $today->diffInDays($end_date, false);

            if ($daysLeft > 7) {
                $backgroundColor = 'green';
            } elseif ($daysLeft > 1 && $daysLeft <= 7) {
                $backgroundColor = 'yellow';
            } else {
                $backgroundColor = 'red';
            }

            $trainingStartDates[] = [
                'type' => 'On The Job',
                'title' => 'On The Job Training',
                'start' => $end_date->toDateString(),
                'backgroundColor' => $backgroundColor
            ];
        });

        ClassroomTraining::get()->each(function ($query) use (&$trainingStartDates, $today) {
            $end_date = \Carbon\Carbon::parse($query->end_date);
            $daysLeft = $today->diffInDays($end_date, false);

            if ($daysLeft > 7) {
                $backgroundColor = 'green';
            } elseif ($daysLeft > 1 && $daysLeft <= 7) {
                $backgroundColor = 'yellow';
            } else {
                $backgroundColor = 'red';
            }

            $trainingStartDates[] = [
                'type' => 'Classroom',
                'title' => 'Classroom Training',
                'start' => $end_date->toDateString(),
                'backgroundColor' => $backgroundColor
            ];
        });

        TNIMatrixData::get()->each(function ($query) use (&$trainingStartDates, $today) {
            $end_date = \Carbon\Carbon::parse($query->endDate);
            $daysLeft = $today->diffInDays($end_date, false);

            if ($daysLeft > 7) {
                $backgroundColor = 'green';
            } elseif ($daysLeft > 1 && $daysLeft <= 7) {
                $backgroundColor = 'yellow';
            } else {
                $backgroundColor = 'red';
            }

            $trainingStartDates[] = [
                'type' => 'Designation',
                'title' => 'Designation Training',
                'start' => $end_date->toDateString(),
                'backgroundColor' => $backgroundColor
            ];
        });

        DepartmentDocumentNumbers::get()->each(function ($query) use (&$trainingStartDates, $today) {
            $end_date = \Carbon\Carbon::parse($query->end_date);
            $daysLeft = $today->diffInDays($end_date, false);

            if ($daysLeft > 7) {
                $backgroundColor = 'green';
            } elseif ($daysLeft > 1 && $daysLeft <= 7) {
                $backgroundColor = 'yellow';
            } else {
                $backgroundColor = 'red';
            }

            $trainingStartDates[] = [
                'type' => 'Job Role',
                'title' => 'Job Role Training',
                'start' => $end_date->toDateString(),
                'backgroundColor' => $backgroundColor
            ];
        });
        // ==================
        //Pending empplpoyee
        $pendingInductionTrainingModel = Induction_training::where('stage', '<=', 2)
        ->select('name_employee', DB::raw('count(*) as pending_training_count'))
        ->groupBy('name_employee')
        ->orderby('name_employee')
        ->get();

        $pendingInductionTraining = [];

        foreach ($pendingInductionTrainingModel as $pending) {
            $newArray = [
                'name_employee' => Helpers::getEmpName($pending->name_employee),
                'pending_training_count' => $pending->pending_training_count
            ];
            array_push($pendingInductionTraining, $newArray);
        }
        $completeInductionTraining = EmpTrainingQuizResult::where([
            'training_type' => 'Induction Training', 
            'result' => 'Pass'
        ])
            ->select('emp_id', DB::raw('count(*) as training_count')) // Count the training attempts
            ->groupBy('emp_id') // Group by employee ID
            ->get();
    
            $completeInductionTraining = $completeInductionTraining->map(function ($item) {
                // Assuming Helpers::getEmpNameByCode($code) is a function that returns the employee name
                $item->emp_name = Helpers::getEmpNameByCode($item->emp_id); // Adding 'emp_name' to the result
                return $item;
            });

        // ---OTJ------- 
        $pendingOTJTrainingModel = JobTraining::where('stage', '<=', 3)
        ->select('employee_id', DB::raw('count(*) as pending_training_count'))
        ->groupBy('employee_id')
        ->orderby('employee_id')
        ->get();

        $pendingOTJTraining = [];

        foreach ($pendingOTJTrainingModel as $pending) {
            $newArray = [
                'name_employee' => Helpers::getEmpNameByCode($pending->employee_id),
                'pending_training_count' => $pending->pending_training_count
            ];
            array_push($pendingOTJTraining, $newArray);
        }

        $completeOTJTraining = EmpTrainingQuizResult::where([
            'training_type' => 'On The Job Training', 
            'result' => 'Pass'
        ])
            ->select('emp_id', DB::raw('count(*) as training_count')) // Count the training attempts
            ->groupBy('emp_id') // Group by employee ID
            ->get();
            $completeOTJTraining = $completeOTJTraining->map(function ($item) {
                // Assuming Helpers::getEmpNameByCode($code) is a function that returns the employee name
                $item->emp_name = Helpers::getEmpNameByCode($item->emp_id); // Adding 'emp_name' to the result
                return $item;
            });
            // -------------------------- 

            $pendingClassroomTrainingModel = ClassroomTraining::where('stage', '<=', 3)
            ->select('employee_id', DB::raw('count(*) as pending_training_count'))
            ->groupBy('employee_id')
            ->orderby('employee_id')
            ->get();

            $pendingClassroomTraining = [];

            foreach ($pendingClassroomTrainingModel as $pending) {
                $newArray = [
                    'name_employee' => Helpers::getEmpNameByCode($pending->employee_id),
                    'pending_training_count' => $pending->pending_training_count
                ];
                array_push($pendingClassroomTraining, $newArray);
            }

            $completeClassroomTraining = EmpTrainingQuizResult::where([
                'training_type' => 'Classroom Training', 
                'result' => 'Pass'
            ])
                ->select('emp_id', DB::raw('count(*) as training_count')) // Count the training attempts
                ->groupBy('emp_id') // Group by employee ID
                ->get();

                $completeClassroomTraining = $completeClassroomTraining->map(function ($item) {
                    // Assuming Helpers::getEmpNameByCode($code) is a function that returns the employee name
                    $item->emp_name = Helpers::getEmpNameByCode($item->emp_id); // Adding 'emp_name' to the result
                    return $item;
                });

        // ------------------------



        // Induction Training Data
            $pendingInductionDepartment = Induction_training::where('stage', '<=', 2)
            ->select('department', DB::raw('count(*) as pending_training_count'))
            ->groupBy('department')
            ->orderby('department')
            ->get();

        $pendingInductionDepartmentTraining = [];
        foreach ($pendingInductionDepartment as $pending) {
            $newArray = [
                'department' => $pending->department,
                'pending_training_count' => $pending->pending_training_count
            ];
            array_push($pendingInductionDepartmentTraining, $newArray);
        }
        $completeInductionDepartment = EmpTrainingQuizResult::where([
            'training_type' => 'Induction Training',
            'result' => 'Pass'
        ])
            ->select('department', DB::raw('count(*) as training_count'))
            ->groupBy('department')
            ->get();


        // OTJ Training Data
        $pendingOTJTrainingDepartment = JobTraining::where('stage', '<=', 3)
            ->select('department', DB::raw('count(*) as pending_training_count'))
            ->groupBy('department')
            ->orderby('department')
            ->get();

        $pendingOTJDepartment = [];
        foreach ($pendingOTJTrainingDepartment as $pending) {
            $newArray = [
                'department' => $pending->department,
                'pending_training_count' => $pending->pending_training_count
            ];
            array_push($pendingOTJDepartment, $newArray);
        }

        $completeOTJDepartment = EmpTrainingQuizResult::where([
            'training_type' => 'On The Job Training',
            'result' => 'Pass'
        ])
            ->select('department', DB::raw('count(*) as training_count'))
            ->groupBy('department')
            ->get();

        // Classroom Training Data
        $pendingClassroomTrainingDepartment = ClassroomTraining::where('stage', '<=', 3)
            ->select('department', DB::raw('count(*) as pending_training_count'))
            ->groupBy('department')
            ->orderby('department')
            ->get();

        $pendingClassroomDepartment = [];
        foreach ($pendingClassroomTrainingDepartment as $pending) {
            $newArray = [
                'department' => $pending->department,
                'pending_training_count' => $pending->pending_training_count
            ];
            array_push($pendingClassroomDepartment, $newArray);
        }

        $completeClassroomDepartment = EmpTrainingQuizResult::where([
            'training_type' => 'Classroom Training',
            'result' => 'Pass'
        ])
            ->select('department', DB::raw('count(*) as training_count'))
            ->groupBy('department')
            ->get();

        // ---------------------------------------------
        $totalMaterials = TrainingMaterialManagement::count();
        $totalEmployees = Employee::count();
        $activeEmployees = Employee::where('stage','>',1)->count();
        $tmmData = TrainingMaterialManagement::select('prepared_by', DB::raw('count(*) as total'))
            ->groupBy('prepared_by')
            ->get();
            // Prepare data for the bar chart (optional, depending on the charting library)
        $TMMchartData = [
            'labels' => $tmmData->map(fn($item) => Helpers::getInitiatorName($item->prepared_by))->toArray(),
            'data' => $tmmData->pluck('total')->toArray(),
        ];

        $tmmByType = TrainingMaterialManagement::select('Type_of_Material', DB::raw('count(*) as total'))
        ->groupBy('Type_of_Material')
        ->get();

        $tmmTypeChartData = [
            'labels' => $tmmByType->pluck('Type_of_Material')->toArray(),
            'data' => $tmmByType->map(fn($item) => round(($item->total / $totalMaterials) * 100, 1))->toArray(),
        ];

        $results = EmpTrainingQuizResult::all(); 
        // Prepare metrics arrays
        $trainingMetrics = [
            'Induction Training' => ['pass' => 0, 'fail' => 0, 'total_score' => 0, 'attempts' => 0, 'count' => 0],
            'On the Job Training' => ['pass' => 0, 'fail' => 0, 'total_score' => 0, 'attempts' => 0, 'count' => 0],
            'Classroom Training' => ['pass' => 0, 'fail' => 0, 'total_score' => 0, 'attempts' => 0, 'count' => 0],
        ];
    
        // Calculate the metrics
        foreach ($results as $result) {
            $type = $result->training_type;
            if (isset($trainingMetrics[$type])) {
                $trainingMetrics[$type]['count'] += 1;
                $trainingMetrics[$type]['total_score'] += intval($result->score);
                $trainingMetrics[$type]['attempts'] += $result->attempt_number;
                $trainingMetrics[$type][$result->result === 'Pass' ? 'pass' : 'fail'] += 1;
            }
        }
    
        // Calculate averages
        foreach ($trainingMetrics as $type => &$metrics) {
            if ($metrics['count'] > 0) {
                $metrics['avg_score'] = $metrics['total_score'] / $metrics['count'];
                $metrics['avg_attempts'] = $metrics['attempts'] / $metrics['count'];
            }
        }

        // Group by trainer_id and count the number of training plans created
        $trainerChart = Training::select('trainner_id', DB::raw('count(*) as training_plan_count'))
        ->groupBy('trainner_id')
        ->get();

        // Map the results to format them correctly for the chart
        $trainerData = $trainerChart->map(function($item) {
        return [
            'trainer_name' => Helpers::getInitiatorName($item->trainner_id), // Convert trainner_id to trainer name
            'training_plan_count' => $item->training_plan_count
        ];
        });
        return view('frontend.TMS.analytics_training', compact('trainingMetrics', 'TMMchartData', 'tmmTypeChartData', 'activeEmployees', 'totalEmployees', 'pendingInductionTraining','completeInductionTraining','completeClassroomTraining','completeOTJTraining','pendingOTJTraining', 'pendingClassroomTraining', 'pendingInductionDepartmentTraining','trainingStartDates',
        'completeInductionDepartment',
        'pendingOTJDepartment',
        'completeOTJDepartment',
        'pendingClassroomDepartment',
        'trainerData',
        'completeClassroomDepartment'));
    }

    // public function designationanalyticsShow() {
    //     dd($this->designationTrainingCount());
    // }
    
    public function designationTrainingCount(Request $request) {
        $department = $request->department;
        $division = $request->division;
    
        $allDesignations = [
            'Trainee', 'Officer', 'Senior Officer', 'Executive', 'Senior Executive', 
            'Assistant Manager', 'Manager', 'Senior General Manager', 'Senior Manager', 
            'Deputy General Manager', 'Assistant General Manager and General Manager', 
            'Head Quality', 'VP Quality', 'Plant Head'
        ];
    
        $trainingCount = array_fill_keys($allDesignations, 0); // Initialize count
    
        $designationTraining = TNIMatrixData::get();
        
        foreach ($designationTraining as $train) {
            $designations = explode(',', $train->designation);
            foreach ($designations as $desig) {
                $desig = trim($desig);
                if (array_key_exists($desig, $trainingCount)) {
                    $trainingCount[$desig]++;
                }
            }
        }
    
        $nonZeroTrainingCount = array_filter($trainingCount, fn($count) => $count > 0);
        // Prepare employee count per designation
        $designationWiseUsersCount = [];
        foreach ($nonZeroTrainingCount as $designation => $count) {
            $designationWiseUsersCount[$designation] = Employee::where('job_title', $designation)
                ->where('department', $department)
                ->count();
        }

        
        return view('frontend.TMS.designation-wise', compact('allDesignations', 'trainingCount', 'designationWiseUsersCount', 'nonZeroTrainingCount'));
    }
    
    
    
    

    public function showChart()
    {

        return view('frontend.layout.training_chart');
    }


    /*************** Employee Training Chart Function Starts ***************/
    
    public function ShowInductionChart()
{
    $empId = Auth::guard('employee')->user();

    if ($empId) {
        // Get all induction training records for the employee
        $inductionTraining = Induction_training::where('name_employee', $empId->id)->get();
        $jobTraining = JobTraining::where('employee_id', $empId->full_employee_id)->get();
        $classroomTraining = ClassroomTraining::where('employee_id', $empId->full_employee_id)->get();

        // Initialize counts for each type of training
        $inductionTrainingCount = $inductionTraining->count();
        $jobTrainingCount = $jobTraining->count();
        $classroomTrainingCount = $classroomTraining->count();
        
        // Initialize pass, fail, and pending counts for each training type
        $inductionPassCount = 0;
        $inductionFailCount = 0;
        $inductionPendingCount = 0;
        
        $jobPassCount = 0;
        $jobFailCount = 0;
        $jobPendingCount = 0;
        
        $classroomPassCount = 0;
        $classroomFailCount = 0;
        $classroomPendingCount = 0;

        // Count for Induction Training
        foreach ($inductionTraining as $induction) {
            $resultComplete = EmpTrainingQuizResult::where([
                'training_type' => 'Induction Training',
                'training_id' => $induction->id
            ])->latest()->first(); // Using `first` since we expect one result per training

            if ($resultComplete) {
                if ($resultComplete->result == "Pass") {
                    $inductionPassCount += 1;
                } elseif ($resultComplete->result == "Fail" && $resultComplete->attempt_number == 1) {
                    $inductionFailCount += 1;
                }
                else {
                    $inductionPendingCount += 1;
                }
            } else {
                $inductionPendingCount += 1;
            }
        }

        // Count for On-the-Job Training
        foreach ($jobTraining as $jobtraining) {
            $resultComplete = EmpTrainingQuizResult::where([
                'training_type' => 'On The Job Training',
                'training_id' => $jobtraining->id
            ])->latest()->first(); // Using `first` since we expect one result per training

            if ($resultComplete) {
                if ($resultComplete->result == "Pass") {
                    $jobPassCount += 1;
                } elseif ($resultComplete->result == "Fail" && $resultComplete->attempt_number == 1) {
                    $jobFailCount += 1;
                }
                else {
                    $jobPendingCount += 1;
                }
            } else {
                $jobPendingCount += 1;
            }
        }

        // Count for Classroom Training
        foreach ($classroomTraining as $classroomtraining) {
            $resultComplete = EmpTrainingQuizResult::where([
                'training_type' => 'Classroom Training',
                'training_id' => $classroomtraining->id
            ])->latest()->first(); // Using `first` since we expect one result per training

            if ($resultComplete) {
                if ($resultComplete->result == "Pass") {
                    $classroomPassCount += 1;
                } elseif ($resultComplete->result == "Fail" && $resultComplete->attempt_number == 1) {
                    $classroomFailCount += 1;
                }
                else {
                    $classroomPendingCount += 1;
                }
            } else {
                $classroomPendingCount += 1;
            }
        }

        // Prepare data for the bar chart
        $chartData = [
            'induction' => [
                'total' => $inductionTrainingCount,
                'pass' => $inductionPassCount,
                'fail' => $inductionFailCount,
                'pending' => $inductionPendingCount,
            ],
            'job' => [
                'total' => $jobTrainingCount,
                'pass' => $jobPassCount,
                'fail' => $jobFailCount,
                'pending' => $jobPendingCount,
            ],
            'classroom' => [
                'total' => $classroomTrainingCount,
                'pass' => $classroomPassCount,
                'fail' => $classroomFailCount,
                'pending' => $classroomPendingCount,
            ],
        ];

        // Pass data to the view
        return view('frontend.layout.training_child', compact('chartData'));
    }

    return redirect()->back()->with('error', 'Employee not found');
}

public function jobTrainingCount(Request $request) {
    $department = $request->department;
    $division = $request->division;

    $jobTitles = [
        "Purchasing Manager",
        "IT Manager",
        "HR Manager",
        "Customer Support",
        "Project Manager",
        "Shift Technician",
        "Senior QA Officer",
        "Secretary/Administrator",
        "QA Officer",
        "Manager/Shift Manager",
        "GMT Trainer",
        "GMP Training Administrator",
        "Doc Control Officer",
        "Compliance Training Manager",
        "Cleaning Technician",
        "Administrator"
    ];

    $trainingCount = array_fill_keys($jobTitles, 0); // Initialize count

    $designationTraining = DepartmentDocumentNumbers::get();
    
    foreach ($designationTraining as $train) {
        $designations = explode(',', $train->job_role);
        foreach ($designations as $desig) {
            $desig = trim($desig);
            if (array_key_exists($desig, $trainingCount)) {
                $trainingCount[$desig]++;
            }
        }
    }

    $nonZeroTrainingCount = array_filter($trainingCount, fn($count) => $count > 0);
    // Prepare employee count per designation
    $designationWiseUsersCount = [];
    foreach ($nonZeroTrainingCount as $designation => $count) {
        $designationWiseUsersCount[$designation] = Employee::where('emp_job', $designation)
            ->where('department', $department)
            ->where('site_division', $division)
            ->count();
    }

    return view('frontend.TMS.job-role-wise', compact('jobTitles', 'trainingCount', 'designationWiseUsersCount', 'nonZeroTrainingCount'));
}
public function filterTrainingData(Request $request) {
    $location = $request->input('location');
    // dd($location);
    $department = $request->input('department');

    // Job roles
    $jobTitles = [
        "Purchasing Manager", "IT Manager", "HR Manager", "Customer Support", 
        "Project Manager", "Shift Technician", "Senior QA Officer", 
        "Secretary/Administrator", "QA Officer", "Manager/Shift Manager",
        "GMT Trainer", "GMP Training Administrator", "Doc Control Officer", 
        "Compliance Training Manager", "Cleaning Technician", "Administrator"
    ];

    $trainingCount = array_fill_keys($jobTitles, 0);

    // Fetch training data
    $designationTraining = DepartmentDocumentNumbers::get();

    foreach ($designationTraining as $train) {
        $designations = explode(',', $train->job_role);
        foreach ($designations as $desig) {
            $desig = trim($desig);
            if (array_key_exists($desig, $trainingCount)) {
                $trainingCount[$desig]++;
            }
        }
    }

    $nonZeroTrainingCount = array_filter($trainingCount, fn($count) => $count > 0);
// dd($nonZeroTrainingCount);
    $designationWiseUsersCount = [];
    foreach ($nonZeroTrainingCount as $designation => $count) {
        $designationWiseUsersCount[$designation] = Employee::where('emp_job', $designation)
            ->when($location, function($query) use ($location) {
                return $query->where('site_division', $location);
            })
            ->when($department, function($query) use ($department) {
                return $query->where('department', $department);
            })
            ->count();
    }

    return response()->json([
        'labels' => array_keys($nonZeroTrainingCount),
        'trainingData' => array_values($nonZeroTrainingCount),
        'employeeData' => array_values($designationWiseUsersCount)
    ]);
}



    public function showInductionTrainingChart()
    {
        $loggedInEmployee = Auth::guard('employee')->user();
        if (!$loggedInEmployee) {
            return redirect()->route('login')->with('error', 'You need to be logged in to access this page.');
        }

        $getEmployee = $loggedInEmployee->full_employee_id;

        $results = EmpTrainingQuizResult::where('emp_id', $getEmployee)
            ->whereIn('training_type', ['Induction Training', 'On The Job Training', 'Classroom Training','TNI Matrix','TNI Employee','Department Wise Job Role'])
            ->get();

        $latestResults = $results
            ->groupBy(['training_type', 'training_id'])
            ->map(function ($groupByTrainingId) {
                return $groupByTrainingId->map(function ($group) {
                    return $group->sortByDesc('created_at')->first();
                })->values();
            });

        $inductionTraining = $latestResults->get('Induction Training', collect([]));
        $onJobTraining = $latestResults->get('On The Job Training', collect([]));
        $classroomTraining = $latestResults->get('Classroom Training', collect([]));
        $tniMatrixTraining = $latestResults->get('TNI Matrix', collect([]));
        $tniemployeeTraining = $latestResults->get('TNI Employee', collect([]));
        $deparmentWiseTraining = $latestResults->get('TNI Employee', collect([]));

        return view('frontend.TMS.graph.employee-graph', [
            'inductionTraining' => $inductionTraining,
            'onJobTraining' => $onJobTraining,
            'classroomTraining' => $classroomTraining,
            'tniMatrixTraining' => $tniMatrixTraining,
            'tniemployeeTraining' => $tniemployeeTraining,
            'deparmentWiseTraining' => $deparmentWiseTraining,
            'hasInductionData' => $inductionTraining->isNotEmpty(),
            'hasOnJobData' => $onJobTraining->isNotEmpty(),
            'hasClassroomData' => $classroomTraining->isNotEmpty(),
            'hasTNIMatrixData' => $tniMatrixTraining->isNotEmpty(),
            'hastniemployeeData' => $tniemployeeTraining->isNotEmpty(),
            'hasdeparmentWiseTrainingData' => $deparmentWiseTraining->isNotEmpty(),
        ]);
    }




    public function viewrendersop($id, $total_minimum_time, $per_screen_run_time, $sop_training_id, $sop_spent_time){
        // $id = Crypt::decryptString($id);
        $totalMinimumTime = Crypt::decryptString($total_minimum_time);
        $perScreenRunningTime = Crypt::decryptString($per_screen_run_time);
        $sop_spent_time = Crypt::decryptString($sop_spent_time);
        // dd($id, $totalMinimumTime, $perScreenRunningTime, $sop_spent_time, $sop_training_id);
        return view('frontend.TMS.sop_training_detail', compact('id', 'totalMinimumTime', 'perScreenRunningTime', 'sop_training_id', 'sop_spent_time'));
    }

    public function questionshow($sopids, $sopid){
        $sopid = TrainingSopEmployee::find(id: $sopid);
        $sopid->attempt_count = $sopid->attempt_count == -1 ? 0 : ( $sopid->attempt_count == 0 ? 0 : $sopid->attempt_count - 1);

        $sopid->save();
        $sopids = array_map('trim', explode(',', $sopids));

        $quiz = Quize::find($sopid->quize);
        
        if ($quiz) {
            // Fetch questions based on the IDs stored in $quiz->question
            $questions = Question::whereIn('id', explode(',', $quiz->question)) // Assuming the question IDs are stored as a comma-separated string
                ->inRandomOrder() // Randomize the order of the questions
                ->take(10) // Limit to 10 questions
                ->get();
        }
        $questionCount = $questions->count();
        return view('frontend.TMS.SOP_Training.sop_question_answer', compact('questions', 'sopid', 'questionCount'));

    }

    public function checkAnswerSOP(Request $request)
    {
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
    
            // Dump and die to inspect the question's details    
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

        $training = TrainingSopEmployee::findOrFail($request->training_id);
        if($result == 'Pass'){
            $training->status = "Completed";
            $training->update();
        }
    
        // Store the result of the quiz attempt
        $storeResult = new EmpTrainingQuizResult();
        $storeResult->emp_id = $request->emp_id;
        $storeResult->training_id = $request->training_id;
        $storeResult->employee_name = $request->employee_name;
        $storeResult->training_type = "SOP Training";
        $storeResult->correct_answers = $correctCount;
        $storeResult->incorrect_answers = $totalQuestions - $correctCount;
        $storeResult->total_questions = $totalQuestions;
        $storeResult->score = $score . "%";
        $storeResult->result = $result;
        $storeResult->attempt_number = $request->attempt_count + 1;
        $storeResult->save();
    
        if ($request->attempt_count == 0 || $result == 'Pass') {

            
            $trainingAllEmp = TrainingSopEmployee::where('training_id', $training->training_id)->get();
            $trainingIds = $trainingAllEmp->pluck('id'); // Get all relevant training IDs

            $trainingMain = Training::findOrFail($training->training_id);

            $sopMain = Document::findOrFail($trainingMain->sops);

            // dd($training, $trainingAllEmp, $trainingMain, $sopMain);
            if ($trainingMain) {
                // Get all passed results for the specific training
                // Count employees with "Pass" status
                $resultCount = EmpTrainingQuizResult::where('training_type', 'SOP Training')
                ->whereIn('training_id', $trainingIds)
                ->where('result', 'Pass')
                ->count();

    
                // $resultCount = $resultAll->count();
                $totalEmployees = $trainingAllEmp->count();
    
                // Calculate pass percentage
                if ($totalEmployees > 0) {
                    $passPercentage = ($resultCount / $totalEmployees) * 100;
    
                    // Check if the pass percentage meets or exceeds the effective criteria
                    if ($passPercentage >= $trainingMain->effective_criteria) {
                        // Update the SOP stage to 'Effective'
                        $sopMain->stage = 10;
                        $sopMain->effective_date = Carbon::parse(now())->format('d-m-y');
                        $sopMain->next_review_date = Carbon::parse($sopMain->effective_date)->addYears($request->review_period)->format('d-m-Y');
                        $sopMain->status = 'Effective';
                        $sopMain->update();
                        $document = DocumentTraining::where('document_id',$training->sop_id)->first();
                        $document->status = "Complete";
                        $document->update();
                        $trainingMain->status = "Completed";
                        $trainingMain->update();
                        $training->status = "Completed";
                        $training->update();
                    }
                }
            }
        }
    
        return view('frontend.TMS.SOP_Training.sop_quiz_result', [
            'totalQuestions' => $totalQuestions,
            'correctCount' => $correctCount,
            'score' => $score,
            'result' => $result
        ]);
    }
    

public function traininggraph()
    {
        
        return view('frontend.TMS.analytics_training', compact('totalEmployees', 'activeEmployees'));
    }
    
    public function filterDesignationTraining(Request $request) {
        $department = $request->department;
        $location = $request->location;
        $allDesignations = [
            'Trainee', 'Officer', 'Senior Officer', 'Executive', 'Senior Executive', 
            'Assistant Manager', 'Manager', 'Senior General Manager', 'Senior Manager', 
            'Deputy General Manager', 'Assistant General Manager and General Manager', 
            'Head Quality', 'VP Quality', 'Plant Head'
        ];

        $trainingCount = array_fill_keys($allDesignations, 0);
    
        // $designationTraining = TNIMatrixData::where('location', $location)
        $designationTraining = TNIMatrixData::where('division', Helpers::getDivisionCode($location))->where('department', Helpers::getDepartmentNameFromCode($department))->get();

        // dd($designationTraining);
    
        foreach ($designationTraining as $train) {
            $designations = explode(',', $train->designation);
            foreach ($designations as $desig) {
                $desig = trim($desig);
                if (array_key_exists($desig, $trainingCount)) {
                    $trainingCount[$desig]++;
                }
            }
        }
    
        $nonZeroTrainingCount = array_filter($trainingCount, fn($count) => $count > 0);
    
        $designationWiseUsersCount = [];
        foreach ($nonZeroTrainingCount as $designation => $count) {
            $designationWiseUsersCount[$designation] = Employee::where('job_title', $designation)
                ->where('department', $department)
                // ->where('location', $location)
                ->count();
        }
    
        return response()->json([
            'labels' => array_keys($nonZeroTrainingCount),
            'trainingData' => array_values($nonZeroTrainingCount),
            'employeeData' => array_values($designationWiseUsersCount),
        ]);
    }
    
}
