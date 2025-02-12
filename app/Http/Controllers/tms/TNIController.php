<?php

namespace App\Http\Controllers\tms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TNI;
use App\Models\TNIMatrixData;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Helpers;
use Dompdf\Dompdf;
use PDF;
use App\Models\Training;
use App\Models\Quize;
use App\Models\Question;
use App\Models\EmpTrainingQuizResult;
use App\Models\QuestionariesGrid;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Crypt;

use App\Models\{Document, TNIGrid, TniAuditTrail, RoleGroup};

class TNIController extends Controller
{
    public function create()
    {
        $Tni = TNI::all();
        $documents = Document::all();
        return view('frontend.TMS.TNI.create', compact('Tni', 'documents'));
    }

    public function store(Request $request)
    {
        $versionCount = TNI::where(['division_id' => $request->division_id, "department_code" => $request->department_code])->count();
        $lastCount = TNI::where(['division_id' => $request->division_id, "department_code" => $request->department_code])->value('version_count');

        $Tni = new TNI();
        $Tni->division_id = $request->division_id;
        $Tni->department_code = $request->department_code;
        $Tni->department = Helpers::getFullDepartmentName($request->department_code);
        $Tni->status = "Opened";
        $Tni->stage = 1;
        $Tni->initiator_id = Auth::user()->id;
        $Tni->initiation_date = $request->initiation_date;
        $Tni->start_date = $request->start_date;
        $Tni->end_date = $request->end_date;
        if($versionCount == 0){
            $Tni->version_count = 0;
        } else {
            $Tni->version_count = $lastCount + 1;
        }

        $Tni->save();

        $trainingPlan = TNIGrid::where(['tni_id' => $Tni->id, 'identifier' => "TrainingPlan"])->firstOrCreate();
        $trainingPlan->tni_id = $Tni->id;
        $trainingPlan->identifier = "TrainingPlan";
        $trainingPlanData = $request->trainingPlanData;

        foreach ($trainingPlanData as &$trainingItem) {
            if (isset($trainingItem['documentNumber']) && is_array($trainingItem['documentNumber'])) {
                $trainingItem['documentNumber'] = implode(',', $trainingItem['documentNumber']);
            }

            if (isset($trainingItem['designation']) && is_array($trainingItem['designation'])) {
                $trainingItem['designation'] = implode(',', $trainingItem['designation']);
            }
            $trainingItem['sop_spent_time'] = 0;
        }
        $trainingPlan->data = $trainingPlanData;
        // dd($trainingPlan->data);
        $trainingPlan->save();


        // $trainingPlan = TNIGrid::where(['tni_id' => $Tni->id, 'identifier' => "TrainingPlan"])->firstOrCreate();
        // $trainingPlan->tni_id = $Tni->id;
        // $trainingPlan->identifier = "TrainingPlan";
        // $trainingPlanData = $request->trainingPlanData;
        // foreach ($trainingPlanData as &$trainingItem) {
        //     if (isset($trainingItem['documentNumber']) && is_array($trainingItem['documentNumber'])) {
        //         $trainingItem['documentNumber'] = implode(',', $trainingItem['documentNumber']);
        //     }
        // }
        // $trainingPlan->data = $trainingPlanData;
        // $trainingPlan->save();


        toastr()->success('Form Submitted Successfully !!');
        return redirect(url('TMS'));
    }

    public function show($id){

        $data = TNI::find($id);
         $tniGrid = TNIGrid::where(['tni_id' => $id, 'identifier' => "TrainingPlan"])->first();
        $existingData = json_decode($tniGrid->data, true);

        if (is_array($existingData)) {
            foreach ($existingData as $key => $row) {
                if (isset($row['documentNumber'])) {
                    $existingData[$key]['selectedDocuments'] = explode(',', $row['documentNumber']);
                } elseif (is_array($row) && isset($row[0]['documentNumber'])) {
                    $existingData[$key]['selectedDocuments'] = explode(',', $row[0]['documentNumber']);
                } else {
                    $existingData[$key]['selectedDocuments'] = [];
                }
            }
        } else {
            $existingData = [];
        }
        $documents = Document::all();
        return view('frontend.TMS.TNI.view',compact('data','tniGrid', 'documents', 'existingData'));
    }

    public function update(Request $request, $id)
    {
        $Tni = TNI::find($id);

        // $trainingPlan = TNIGrid::where(['tni_id' => $id, 'identifier' => "TrainingPlan"])->first();
        // if (!$trainingPlan) {
        //     return response()->json(['message' => 'Training plan not found'], 404);
        // }
        // $trainingPlanData = $request->trainingPlanData;
        // foreach ($trainingPlanData as &$trainingItem) {
        //     if (isset($trainingItem['documentNumber']) && is_array($trainingItem['documentNumber'])) {
        //         $trainingItem['documentNumber'] = implode(',', $trainingItem['documentNumber']);
        //     }
        // }
        // $trainingPlan->data = $trainingPlanData;
        // $trainingPlan->save();

        $trainingPlan = TNIGrid::where(['tni_id' => $id, 'identifier' => "TrainingPlan"])->first();
        if (!$trainingPlan) {
            return response()->json(['message' => 'Training plan not found'], 404);
        }

        $trainingPlanData = $request->trainingPlanData;

        foreach ($trainingPlanData as &$trainingItem) {
            if (isset($trainingItem['documentNumber']) && is_array($trainingItem['documentNumber'])) {
                $trainingItem['documentNumber'] = implode(',', $trainingItem['documentNumber']);
            }

            if (isset($trainingItem['designation']) && is_array($trainingItem['designation'])) {
                $trainingItem['designation'] = implode(',', $trainingItem['designation']);
            }
        }

        $trainingPlan->data = $trainingPlanData;
        $trainingPlan->save();


        toastr()->success('Record Update Successfully !!');
        return back();
    }


    public function getDocumentDetail($documentId)
    {
        $docdetail = Document::find($documentId);

        if ($docdetail) {
            $sopNumbers = $docdetail->sop_type_short . '/' . $docdetail->department_id . '/000' . $docdetail->id . '/R' . $docdetail->major;
            return response()->json([
                'sop_numbers' => $sopNumbers,
                'sops' => $docdetail->document_name,
                'created_at' => $docdetail->created_at->format('d-M-Y'),
            ]);
        }

        return response()->json([
            'sop_numbers' => '',
            'sops' => '',
            'created_at' => '',
            'message' => 'Document not found',
        ], 404);
    }

    public function stageChange(Request $request, $id){
        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $tni = TNI::find($id);
            $lastDocument = TNI::find($id);

            if ($tni->stage == 1) {
                $tni->stage = "2";
                $tni->status = "In Review";
                $tni->submitted_by = Auth::user()->name;
                $tni->submitted_on = Carbon::now();
                $tni->submitted_comment = $request->comment;

                $history = new TniAuditTrail();
                $history->tni_id = $id;
                $history->activity_type = 'Submit By, Submit On';
                if (is_null($lastDocument->submitted_by) || $lastDocument->submitted_by === '') {
                    $history->previous = "NULL";
                } else {
                    $history->previous = $lastDocument->submitted_by . ' , ' . $lastDocument->submitted_on;
                }
                $history->current = $tni->submitted_by . ' , ' . $tni->submitted_on;
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

                // $list = Helpers::getInitiatorUserList($tni->division_id);
                //     foreach ($list as $u) {
                //         // if($u->q_m_s_divisions_id == $tni->division_id){
                //             $email = Helpers::getUserEmail($u->user_id);
                //                 if ($email !== null) {
                //                 try {
                //                     Mail::send(
                //                         'mail.view-mail',
                //                         ['data' => $tni, 'site'=>"Errata", 'history' => "Reject", 'process' => 'Errata', 'comment' => $request->comment, 'user'=> Auth::user()->name],
                //                         function ($message) use ($email, $tni) {
                //                             $message->to($email)
                //                             ->subject("Agio Notification: Errata, Record #" . str_pad($tni->record, 4, '0', STR_PAD_LEFT) . " - Activity: Reject Performed");
                //                         }
                //                     );
                //                 } catch(\Exception $e) {
                //                     info('Error sending mail', [$e]);
                //                 }
                //             }
                //         // }
                //     }

                $tni->update();
                return back();
            }

            if ($tni->stage == 2) {
                $tni->stage = "3";
                $tni->status = "For Approval";
                $tni->reviewed_by = Auth::user()->name;
                $tni->reviewed_on = Carbon::now();
                $tni->reviewed_comment = $request->comment;

                $history = new TniAuditTrail();
                $history->tni_id = $id;
                $history->activity_type = 'Reviewed By, Reviewed On';
                if (is_null($lastDocument->reviewed_by) || $lastDocument->reviewed_by === '') {
                    $history->previous = "NULL";
                } else {
                    $history->previous = $lastDocument->reviewed_by . ' , ' . $lastDocument->reviewed_on;
                }
                $history->current = $tni->reviewed_by . ' , ' . $tni->reviewed_on;
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

                // $list = Helpers::getInitiatorUserList($tni->division_id);
                //     foreach ($list as $u) {
                //         // if($u->q_m_s_divisions_id == $tni->division_id){
                //             $email = Helpers::getUserEmail($u->user_id);
                //                 if ($email !== null) {
                //                 try {
                //                     Mail::send(
                //                         'mail.view-mail',
                //                         ['data' => $tni, 'site'=>"Errata", 'history' => "Reject", 'process' => 'Errata', 'comment' => $request->comment, 'user'=> Auth::user()->name],
                //                         function ($message) use ($email, $tni) {
                //                             $message->to($email)
                //                             ->subject("Agio Notification: Errata, Record #" . str_pad($tni->record, 4, '0', STR_PAD_LEFT) . " - Activity: Reject Performed");
                //                         }
                //                     );
                //                 } catch(\Exception $e) {
                //                     info('Error sending mail', [$e]);
                //                 }
                //             }
                //         // }
                //     }

                $tni->update();
                return back();
            }

            if ($tni->stage == 3) {
                $tni->stage = "4";
                $tni->status = "Closed - Done";
                $tni->approved_by = Auth::user()->name;
                $tni->approved_on = Carbon::now();
                $tni->approved_comment = $request->comment;
            
                $history = new TniAuditTrail();
                $history->tni_id = $id;
                $history->activity_type = 'Approved By, Approved On';
                if (is_null($lastDocument->approved_by) || $lastDocument->approved_by === '') {
                    $history->previous = "NULL";
                } else {
                    $history->previous = $lastDocument->approved_by . ' , ' . $lastDocument->approved_on;
                }
                $history->current = $tni->approved_by . ' , ' . $tni->approved_on;
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
            
                $tniMg = TNIGrid::where('tni_id', $id)->latest()->first();

                if ($tniMg && !empty($tniMg->data)) {
                    $decodedData = json_decode($tniMg->data, true); // Decode JSON to array

                    if (is_array($decodedData)) { // Ensure decoding was successful
                        foreach ($decodedData as $document) {
                            TNIMatrixData::create([
                                'tni_id' => $id, 
                                'division' => Helpers::getDivisionLocation($tni->division_id), 
                                'documentNumber' => $document['documentNumber'] ?? null,
                                'documentName' => $document['documentName'] ?? null,
                                'designation' => $document['designation'] ?? null,
                                'department' => $tni->department ?? null,
                                'startDate' => $document['startDate'] ?? null,
                                'endDate' => $document['endDate'] ?? null,
                                'total_minimum_time' => $document['total_minimum_time'] ?? null,
                                'per_screen_run_time' => $document['per_screen_run_time'] ?? null,
                            ]);
                        }
                    } else {
                        // Handle error in case JSON decoding fails
                        dd('Failed to decode JSON data');
                    }
                }

                

                $tni->update();
                return back();
            }
        } else {
            toastr()->error('E-signature Not match');
            return back();
        }
    }

    public function stageReject(Request $request, $id){
        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $tni = TNI::find($id);
            $lastDocument = TNI::find($id);

            if ($tni->stage == 3) {
                $tni->stage = "2";
                $tni->status = "In Review";
                $tni->approvalToReview_by = Auth::user()->name;
                $tni->approvalToReview_on = Carbon::now();
                $tni->approvalToReview_comment = $request->comment;

                $history = new TniAuditTrail();
                $history->tni_id = $id;
                $history->activity_type = 'More Info Required By, More Info Required On';
                if (is_null($lastDocument->approvalToReview_by) || $lastDocument->approvalToReview_by === '') {
                    $history->previous = "NULL";
                } else {
                    $history->previous = $lastDocument->approvalToReview_by . ' , ' . $lastDocument->approvalToReview_on;
                }
                $history->current = $tni->approvalToReview_by . ' , ' . $tni->approvalToReview_on;
                if (is_null($lastDocument->approvalToReview_by) || $lastDocument->approvalToReview_on === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->action = 'More Info Required';
                $history->comment = $request->comments;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to = "In Review";
                $history->change_from = $lastDocument->status;
                $history->stage = '';
                $history->save();

                // $list = Helpers::getInitiatorUserList($tni->division_id);
                //     foreach ($list as $u) {
                //         // if($u->q_m_s_divisions_id == $tni->division_id){
                //             $email = Helpers::getUserEmail($u->user_id);
                //                 if ($email !== null) {
                //                 try {
                //                     Mail::send(
                //                         'mail.view-mail',
                //                         ['data' => $tni, 'site'=>"Errata", 'history' => "Reject", 'process' => 'Errata', 'comment' => $request->comment, 'user'=> Auth::user()->name],
                //                         function ($message) use ($email, $tni) {
                //                             $message->to($email)
                //                             ->subject("Agio Notification: Errata, Record #" . str_pad($tni->record, 4, '0', STR_PAD_LEFT) . " - Activity: Reject Performed");
                //                         }
                //                     );
                //                 } catch(\Exception $e) {
                //                     info('Error sending mail', [$e]);
                //                 }
                //             }
                //         // }
                //     }

                $tni->update();
                return back();
            }

            if ($tni->stage == 2) {
                $tni->stage = "1";
                $tni->status = "Opened";
                $tni->inReviewToOpened_by = Auth::user()->name;
                $tni->inReviewToOpened_on = Carbon::now();
                $tni->inReviewToOpened_comment = $request->comment;

                $history = new TniAuditTrail();
                $history->tni_id = $id;
                $history->activity_type = 'More Info Required By, More Info Required On';
                if (is_null($lastDocument->inReviewToOpened_by) || $lastDocument->inReviewToOpened_by === '') {
                    $history->previous = "NULL";
                } else {
                    $history->previous = $lastDocument->inReviewToOpened_by . ' , ' . $lastDocument->inReviewToOpened_on;
                }
                $history->current = $tni->inReviewToOpened_by . ' , ' . $tni->inReviewToOpened_on;
                if (is_null($lastDocument->inReviewToOpened_by) || $lastDocument->inReviewToOpened_on === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->action = 'More Info Required';
                $history->comment = $request->comments;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to = "Opened";
                $history->change_from = $lastDocument->status;
                $history->stage = '';
                $history->save();

                // $list = Helpers::getInitiatorUserList($tni->division_id);
                //     foreach ($list as $u) {
                //         // if($u->q_m_s_divisions_id == $tni->division_id){
                //             $email = Helpers::getUserEmail($u->user_id);
                //                 if ($email !== null) {
                //                 try {
                //                     Mail::send(
                //                         'mail.view-mail',
                //                         ['data' => $tni, 'site'=>"Errata", 'history' => "Reject", 'process' => 'Errata', 'comment' => $request->comment, 'user'=> Auth::user()->name],
                //                         function ($message) use ($email, $tni) {
                //                             $message->to($email)
                //                             ->subject("Agio Notification: Errata, Record #" . str_pad($tni->record, 4, '0', STR_PAD_LEFT) . " - Activity: Reject Performed");
                //                         }
                //                     );
                //                 } catch(\Exception $e) {
                //                     info('Error sending mail', [$e]);
                //                 }
                //             }
                //         // }
                //     }

                $tni->update();
                return back();
            }

            if ($tni->stage == 1) {
                $tni->stage = "0";
                $tni->status = "Closed - Cancelled";
                $tni->cancelled_by = Auth::user()->name;
                $tni->cancelled_on = Carbon::now();
                $tni->cancelled_comment = $request->comment;

                $history = new TniAuditTrail();
                $history->tni_id = $id;
                $history->activity_type = 'Cancel By, Cancel On';
                if (is_null($lastDocument->cancelled_by) || $lastDocument->cancelled_by === '') {
                    $history->previous = "NULL";
                } else {
                    $history->previous = $lastDocument->cancelled_by . ' , ' . $lastDocument->cancelled_on;
                }
                $history->current = $tni->cancelled_by . ' , ' . $tni->cancelled_on;
                if (is_null($lastDocument->cancelled_by) || $lastDocument->cancelled_on === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->action = 'Cancel';
                $history->comment = $request->comments;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to = "Closed - Cancelled";
                $history->change_from = $lastDocument->status;
                $history->stage = '';
                $history->save();

                // $list = Helpers::getInitiatorUserList($tni->division_id);
                //     foreach ($list as $u) {
                //         // if($u->q_m_s_divisions_id == $tni->division_id){
                //             $email = Helpers::getUserEmail($u->user_id);
                //                 if ($email !== null) {
                //                 try {
                //                     Mail::send(
                //                         'mail.view-mail',
                //                         ['data' => $tni, 'site'=>"Errata", 'history' => "Reject", 'process' => 'Errata', 'comment' => $request->comment, 'user'=> Auth::user()->name],
                //                         function ($message) use ($email, $tni) {
                //                             $message->to($email)
                //                             ->subject("Agio Notification: Errata, Record #" . str_pad($tni->record, 4, '0', STR_PAD_LEFT) . " - Activity: Reject Performed");
                //                         }
                //                     );
                //                 } catch(\Exception $e) {
                //                     info('Error sending mail', [$e]);
                //                 }
                //             }
                //         // }
                //     }

                $tni->update();
                return back();
            }
        } else {
            toastr()->error('E-signature Not match');
            return back();
        }
    }

     public function report($id)
    {
        $TniData = TNI::find($id);
        if (!empty($TniData)) {
            $grid = TniGrid::where(['tni_id' => $id, 'identifier' => "TrainingPlan"])->first();
            $gridData = json_decode($grid->data, true);
            $paginationData = TniGrid::paginate(1);
    
            foreach ($gridData as &$document) {
                $documentIds = explode(',', $document['documentNumber']);
    
                $sopNumbers = [];
                foreach ($documentIds as $documentId) {
                    $docDetail = Document::find(trim($documentId));
                    if ($docDetail) {
                        $sopNumber = $docDetail->sop_type_short . '/' . $docDetail->department_id . '/000' . $docDetail->id . '/R' . $docDetail->major;
                        $sopNumbers[] = $sopNumber;
                    }
                }
                $document['sop_numbers'] = implode(', ', $sopNumbers);
            }
    
            $pdf = App::make('dompdf.wrapper');
            $time = Carbon::now();
            $pdf = PDF::loadview('frontend.TMS.TNI.singleReport', compact(
                'TniData',
                'grid',
                'gridData',
                'paginationData'
            ))->setOptions([
                'defaultFont' => 'sans-serif',
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'isPhpEnabled' => true,
            ]);
            
            // Set paper size
            $pdf->setPaper('A4');
            $pdf->render();
            
            // Add header and page number at the top of each page
            $canvas = $pdf->getDomPDF()->getCanvas();
$width = $canvas->get_width();
$canvas->page_script(function ($pageNumber, $pageCount, $canvas, $fontMetrics) {
    $text = "Page $pageNumber of $pageCount";
    $font = $fontMetrics->getFont('sans-serif', 'normal');
    $fontSize = 10;
    $xPosition = 500; // Add 10px margin from the left
    $yPosition = $canvas->get_height() * 0.09; // 9% from the top
    $canvas->text($xPosition, $yPosition, $text, $font, $fontSize);

            });
    
            return $pdf->stream('SOP' . $id . '.pdf');
        }
    }


    public function viewrendersoptnimatrix($id){
        return view('frontend.TMS.TNI.tni_sop', compact('id'));
    }



    public function tnimatrixequestionshow($sopids, $tnimid)
    {
        $tnimid = TNIMatrixData::find($tnimid);
        
        $tnimid->attempt_count = $tnimid->attempt_count == -1 ? 0 : ($tnimid->attempt_count == 0 ? 0 : $tnimid->attempt_count - 1);
        $tnimid->save();
        $singleSOPId = $sopids;
        $sopids = array_map('trim', explode(',', $sopids));

        $questions = Question::whereIn('document_id', $sopids)
            ->inRandomOrder() 
            ->take(10)      
            ->get();

            
        $document_number = $tnimid->document_number ?? null;

        return view('frontend.TMS.TNI.tni_question_answer', compact('questions', 'tnimid', 'document_number', 'singleSOPId'));
    }

    public function checkAnswerTniMatrix(Request $request)
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
    
        // If no questions, handle division by zero
        if ($totalQuestions === 0) {
            return redirect()->back()->with('error', 'No questions available for this quiz.');
        }
    
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
    

        $training = TNIMatrixData::find($request->training_id);
        // Save the result in the emp_training_quiz_results table
        $storeResult = new EmpTrainingQuizResult();
        $storeResult->emp_id = $request->emp_id;
        $storeResult->training_id = $request->training_id;
        $storeResult->employee_name = $request->employee_name;
        $storeResult->designation = $request->designation;
        $storeResult->department = $training ? $training->department : null;
        $storeResult->training_type = "TNI Matrix";
        $storeResult->correct_answers = $correctCount;
        $storeResult->incorrect_answers = $totalQuestions - $correctCount;
        $storeResult->total_questions = $totalQuestions;
        $storeResult->score = $score . "%";
        $storeResult->result = $result;
        $storeResult->attempt_number = $attemptNumber; 
        $storeResult->document_number = $document_number; 
        $storeResult->save();
    
        return view('frontend.TMS.TNI.tni_quize_result', [
            'totalQuestions' => $totalQuestions,
            'correctCount' => $correctCount,
            'score' => $score,
            'result' => $result,
            'document_number' => $document_number
        ]);
    }

    public function viewrendersop($id, $total_minimum_time, $per_screen_running_time, $job_training_id, $sop_spent_time){
        $id = Crypt::decryptString($id);
        $totalMinimumTime = Crypt::decryptString($total_minimum_time);
        $perScreenRunningTime = Crypt::decryptString($per_screen_running_time);
        $sop_spent_time = Crypt::decryptString($sop_spent_time);
        return view('frontend.TMS.TNI.tni_matrix_details', compact('id', 'totalMinimumTime', 'perScreenRunningTime', 'job_training_id', 'sop_spent_time'));
    }

    public function saveReadingTime(Request $request)
    {
        $sop_spent_time = $request->input('sop_spent_time');
        $id = $request->input('id');
        $jobTraining = TNIMatrixData::findOrFail($id);

        $jobTraining->sop_spent_time = $sop_spent_time;
        $jobTraining->update();

        return response()->json(['success' => true]);
    }
    
    
}
