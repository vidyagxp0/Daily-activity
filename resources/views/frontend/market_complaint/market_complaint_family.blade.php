<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>VidyaGxP - Software</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
</head>

<style>
    body {
        font-family: 'Roboto', sans-serif;
        margin: 0;
        padding: 0;
        min-height: 100vh;
    }

    .w-10 {
        width: 10%;
    }

    .w-20 {
        width: 20%;
    }

    .w-25 {
        width: 25%;
    }

    .w-30 {
        width: 30%;
    }

    .w-40 {
        width: 40%;
    }

    .w-50 {
        width: 50%;
    }

    .w-60 {
        width: 60%;
    }

    .w-70 {
        width: 70%;
    }

    .w-80 {
        width: 80%;
    }

    .w-90 {
        width: 90%;
    }

    .w-100 {
        width: 100%;
    }

    .h-100 {
        height: 100%;
    }

    header table,
    header th,
    header td,
    footer table,
    footer th,
    footer td,
    .border-table table,
    .border-table th,
    .border-table td {
        border: 1px solid black;
        border-collapse: collapse;
        font-size: 0.9rem;
        vertical-align: middle;
    }

    table {
        width: 100%;
    }

    th,
    td {
        padding: 10px;
        text-align: left;
    }

    footer .head,
    header .head {
        text-align: center;
        font-weight: bold;
        font-size: 1.2rem;
    }

    @page {
        size: A4;
        margin-top: 160px;
        margin-bottom: 60px;
    }

    header {
        position: fixed;
        top: -140px;
        left: 0;
        width: 100%;
        display: block;
        height: 100px;
    }

    footer {
        width: 100%;
        position: fixed;
        display: block;
        bottom: -40px;
        left: 0;
        font-size: 0.9rem;
    }

    footer td {
        text-align: center;
    }

    .Summer {
        font-weight: bold;
        font-size: 14px;
    }

    .inner-block {
        padding: 10px;
    }

    .inner-block tr {
        font-size: 0.8rem;
    }

    .inner-block .block {
        margin-bottom: 30px;
    }

    .inner-block .block-head {
        font-weight: bold;
        font-size: 1.1rem; 
        padding-bottom: 5px;
        border-bottom: 2px solid #4274da;
        margin-bottom: 10px;
        color: #4274da;
    }

    .inner-block th,
    .inner-block td {
        vertical-align: baseline;
    }

    .table_bg {
        background: #4274da57;
    }
</style>

<body>

    <header>
        <table>
            <tr>
                <td class="w-70 head">
                 Complaint Management Family Report
                </td>
                <td class="w-20">
                    <div class="logo">
                        <img src="https://www.cphi-online.com/Medicef%20Logo-comp306798.jpg" alt="" class="w-80">
                    </div>
                </td>
            </tr>
        </table>
 
        <table>
            <tr>
                <td class="w-30">
                    Complaint Management No
                </td>
                <td class="w-40">
                   {{ Helpers::divisionNameForQMS($data->division_id) }}/MC/{{ Helpers::year($data->created_at) }}/{{ str_pad($data->record, 4, '0', STR_PAD_LEFT) }}
                </td>
                <td class="w-30">
                    <strong>Record No.</strong> {{ str_pad($data->record, 4, '0', STR_PAD_LEFT) }}
                </td>
            </tr>
        </table>
    </header>

    <footer>
        <table>
            <tr>
                <td class="w-30">
                    <strong>Printed On :</strong> {{ date('d-M-Y') }}
                </td>
                <td class="w-40">
                    <strong>Printed By :</strong> {{ Auth::user()->name }}
                </td>
             </tr>
        </table>
    </footer>
<br>
@php
use Carbon\Carbon;
            
@endphp
    <div class="inner-block">
        <div class="content-table">
            <div class="block">
                <div class="block-head">
                    General Information
                </div>
                <table>
                   
                    <tr>
                    <th class="w-20">Initiator</th>
                    <td class="w-30">{{ $data->originator }}</td>

                    <th class="w-20">Due Date</th>
                    <td class="w-30">{{ \Carbon\Carbon::parse($data->due_date_gi)->format('j-M-Y') }}</td>

                        
                        
                    </tr>

                    <tr>
                        <th class="w-20">Division Code</th>
                    <td class="w-30">{{ Helpers::getDivisionName(session()->get('division')) }}</td>

                    <th class="w-20">Initiator Group</th>
                    @php
                        $departments = [
                            'CQA' => 'Corporate Quality Assurance',
                            'QAB' => 'Quality Assurance Biopharma',
                            'CQC' => 'Central Quality Control',
                            'PSG' => 'Plasma Sourcing Group',
                            'CS' => 'Central Stores',
                            'ITG' => 'Information Technology Group',
                            'MM' => 'Molecular Medicine',
                            'CL' => 'Central Laboratory',
                            'TT' => 'Tech Team',
                            'QA' => 'Quality Assurance',
                            'QM' => 'Quality Management',
                            'IA' => 'IT Administration',
                            'ACC' => 'Accounting',
                            'LOG' => 'Logistics',
                            'SM' => 'Senior Management',
                            'BA' => 'Business Administration',
                        ];
                    @endphp
                    <td class="w-80">{{ $departments[$data->initiator_group] ?? 'Unknown Department' }}</td>
                        
                    </tr>
                    <tr>

 
                        <th class="w-20">Initiator Group Code</th>
                        <td class="w-30">{{ $data->initiator_group_code_gi ?? 'Not Applicable' }}</td>
                        
                        {{-- <th class="w-20">If Other</th>
                        <td class="w-30">{{ $data->if_other_gi ?? 'Not Applicable' }}</td> --}}
                    </tr>
                </table>
               
                <table
                    <tr>

                        <th class="w-20">Complainant</th>
                        <td class="w-30">
                        @isset($data->complainant_gi) 
                        {{ Helpers::getInitiatorName($data->complainant_gi) }} 
                        @else 
                        Not Applicable 
                        @endisset
                        </td>

                    <th class="w-20">Initiated Through</th>
                    <td class="w-30">{{ $data->initiated_through_gi ?? 'Not Applicable' }}</td>
                        
                    </tr>

                    <tr>
                        <th class="w-20">Date Of Initiation</th>
                        <td class="w-30">{{ Helpers::getdateFormat($data->created_at) }}</td>

                      
                       
                        <th class="w-20">Is Repeat</th>
                        <td class="w-30">{{ $data->is_repeat_gi ?? 'Not Applicable' }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Repeat Nature</th>
                        <td class="w-30">{{ $data->repeat_nature_gi ?? 'Not Applicable' }}</td>
                        {{-- <th class="w-20"> Short Description</th>
                        <td class="w-30">{{ $data->description_gi ?? 'Not Applicable' }}</td> --}}
                    </tr>
                </table>
                <label class="Summer" for="">Short Description</label>
                <div>
                    @if ($data->description_gi)
                        {!! $data->description_gi !!}
                    @else
                        Not Applicable
                    @endif
                </div>
                <table>
                    <tr>

                            <th class="w-20">Priority</th>
                        <td class="w-30">{{ $data->priority_data ?? 'Not Applicable' }}</td>
                            
                        <th class="w-20">Complaint Reported On</th>
                        <td class="w-30">{{ $data->complaint_reported_on_gi ? \Carbon\Carbon::parse($data->complaint_reported_on_gi)->format('j-M-Y') : 'Not Applicable' }}
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Details Of Nature Market Complaint</th>
                        <td class="w-30">{{ $data->details_of_nature_market_complaint_gi ?? 'Not Applicable' }}</td>
                        <th class="w-20">Categorization Of Complaint</th>
                        <td class="w-30">{{ $data->categorization_of_complaint_gi ?? 'Not Applicable' }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Review Of Complaint Sample</th>
                        <td class="w-30">{{ $data->review_of_complaint_sample_gi ?? 'Not Applicable' }}</td>
                        
                        <th class="w-20">Review of Control Sample</th>
                       <td class="w-30">{{ $data->review_of_control_sample_gi ?? 'Not Applicable' }}</td></tr>
                    </tr>
                    <tr>
                    <tr>
                        <th class="w-20">Review Of Batch Manufacturing Record (BMR)</th>
                        <td class="w-30">{{ $data->review_of_batch_manufacturing_record_BMR_gi ?? 'Not Applicable' }}</td>
                        <th class="w-20">Review Of Raw Materials Used In Batch Manufacturing</th>
                        <td class="w-30">{{ $data->review_of_raw_materials_used_in_batch_manufacturing_gi ?? 'Not Applicable' }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Review Of Batch Packing Record (BPR)</th>
                        <td class="w-30">{{ $data->review_of_Batch_Packing_record_bpr_gi ?? 'Not Applicable' }}</td>
                        <th class="w-20">Review Of Packing Materials Used In Batch Packing</th>
                        <td class="w-30">{{ $data->review_of_packing_materials_used_in_batch_packing_gi ?? 'Not Applicable' }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Review Of Analytical Data</th>
                        <td class="w-30">{{ $data->review_of_analytical_data_gi ?? 'Not Applicable' }}</td>
                        <th class="w-20">Review Of Training Record Of Concern Persons</th>
                        <td class="w-30">{{ $data->review_of_training_record_of_concern_persons_gi ?? 'Not Applicable' }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Review Of Equipment/Instrument Qualification & Calibration Record</th>
                        <td class="w-30">{{ $data->rev_eq_inst_qual_calib_record_gi ?? 'Not Applicable' }}</td>
                        <th class="w-20">Review Of Equipment Breakdown And Maintenance Record</th>
                        <td class="w-30">{{ $data->review_of_equipment_break_down_and_maintainance_record_gi ?? 'Not Applicable' }}</td>
                     
                    </tr>
                    <tr>
                        <th class="w-20">Review Of Past History Of Product</th>
                        <td class="w-30">{{ $data->review_of_past_history_of_product_gi ?? 'Not Applicable' }}</td>
                        <th class="w-20">Information Attachment</th>
                        <td class="w-30">
                            @if($data->initial_attachment_gi)
                                <a href="{{ asset('upload/' . $data->initial_attachment_gi) }}" target="_blank">{{ $data->initial_attachment_gi }}</a>
                            @else
                                Not Attached
                            @endif
                        </td>
                    </tr>
                </table>
            </div>

            <div class="block">
                <div class="block-head">
                    HOD/Suprervisor Review
                </div>
                <table>

                    <tr>
                        <th class="w-20">Conclusion</th>
                        <td class="w-30">{{ $data->conclusion_hodsr ?? 'Not Applicable' }}</td>
                        <th class="w-20">Root Cause Analysis</th>
                        <td class="w-30">{{ $data->root_cause_analysis_hodsr ?? 'Not Applicable' }}</td>
                    </tr>

                    <tr>
                        <th class="w-20">The Most Probable Root Causes Identified of the Complaint Are as Below</th>
                        <td class="w-30">{{ $data->probable_root_causes_complaint_hodsr ?? 'Not Applicable' }}</td>
                        <th class="w-20">Impact Assessment</th>
                        <td class="w-30">{{ $data->impact_assessment_hodsr ?? 'Not Applicable' }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Corrective Action</th>
                        <td class="w-30">{{ $data->corrective_action_hodsr ?? 'Not Applicable' }}</td>
                        <th class="w-20">Preventive Action</th>
                        <td class="w-30">{{ $data->preventive_action_hodsr ?? 'Not Applicable' }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Summary and Conclusion</th>
                        <td class="w-30">{{ $data->summary_and_conclusion_hodsr ?? 'Not Applicable' }}</td>
                        <th class="w-20">Comments (If Any)</th>
                        <td class="w-30">{{ $data->comments_if_any_hodsr ?? 'Not Applicable' }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">HOD Attachment</th>
                        <td class="w-30">
                            @if($data->initial_attachment_hodsr)
                                <a href="{{ asset('upload/' . $data->initial_attachment_hodsr) }}" target="_blank">{{ $data->initial_attachment_hodsr }}</a>
                            @else
                                Not Attached
                            @endif
                        </td>
                    </tr>

                </table>
            </div>
            <div class="block">
                <div class="block-head">
                    Complaint Acknowledgement
                </div>
                <table>




                    <tr>
                        <th class="w-20">Manufacturer Name & Address</th>
                        <td class="w-30">{{ $data->manufacturer_name_address_ca ?? 'Not Applicable' }}</td>
                        <th class="w-20">Complaint Sample Required</th>
                        <td class="w-30">{{ $data->complaint_sample_required_ca ?? 'Not Applicable' }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Complaint Sample Status</th>
                        <td class="w-30">
                            {{ $data->complaint_sample_status_ca 
                                ? \Carbon\Carbon::parse($data->complaint_sample_status_ca)->format('j-M-Y') 
                                : 'Not Applicable' 
                            }}
                        </td>
                        
                        <th class="w-20">Brief Description of Complaint</th>
                        <td class="w-30">{{ $data->brief_description_of_complaint_ca ?? 'Not Applicable' }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Batch Record Review Observation</th>
                        <td class="w-30">{{ $data->batch_record_review_observation_ca ?? 'Not Applicable' }}</td>
                        <th class="w-20">Analytical Data Review Observation</th>
                        <td class="w-30">{{ $data->analytical_data_review_observation_ca ?? 'Not Applicable' }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Retention Sample Review Observation</th>
                        <td class="w-30">{{ $data->retention_sample_review_observation_ca ?? 'Not Applicable' }}</td>
                        <th class="w-20">Stability Study Data Review</th>
                        <td class="w-30">{{ $data->stability_study_data_review_ca ?? 'Not Applicable' }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">QMS Events If Any Review Observation</th>
                        <td class="w-30">{{ $data->qms_events_ifany_review_observation_ca ?? 'Not Applicable' }}</td>
                        <th class="w-20">Repeated Complaints Queries For Product</th>
                        <td class="w-30">{{ $data->repeated_complaints_queries_for_product_ca ?? 'Not Applicable' }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Interpretation on Complaint Sample If Received</th>
                        <td class="w-30">{{ $data->interpretation_on_complaint_sample_ifrecieved_ca ?? 'Not Applicable' }}</td>
                        <th class="w-20">Comments (If Any)</th>
                        <td class="w-30">{{ $data->comments_ifany_ca ?? 'Not Applicable' }}</td>
                    </tr>

                    <tr>
                        <th class="w-20">Acknowledgement Attachment</th>
                        <td class="w-30">
                            @if($data->initial_attachment_ca)
                                <a href="{{ asset('upload/' . $data->initial_attachment_ca) }}" target="_blank">{{ $data->initial_attachment_ca }}</a>
                            @else
                                Not Attached
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
            <div class="block">
                <div class="block-head">
                    Closure
                </div>
                <table>

                    <tr>
                        <th class="w-20">Closure Comment</th>
                        <td class="w-30">{{ $data->closure_comment_c ?? 'Not Applicable' }}</td>
                     </tr>
                    <tr>
                        <th class="w-20">Closure Attachment</th>
                        <td class="w-30">
                            @if($data->initial_attachment_c)
                                <a href="{{ asset('upload/' . $data->initial_attachment_c) }}" target="_blank">{{ $data->initial_attachment_c }}</a>
                            @else
                                Not Attached
                            @endif
                        </td>
                    </tr>
   
                </table>
            </div>


            <div class="block">
                <div class="block-head">
                    Activity Log
                </div>
                <table>
                    <tr>
                        <th class="w-20">Submitted By</th>
                        <td class="w-30">{{ $data->submitted_by }}</td>
                        <th class="w-20">Submitted On</th>
                        <td class="w-30">{{ $data->submitted_on }}</td>

                        <th class="w-20">Comment</th>
                        <td class="w-30">{{ $data->submitted_comment }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Complete Review By :</th>
                        <td class="w-30">{{  $data->complete_review_by }}</td>
                        <th class="w-20">Complete Review On :</th>
                        <td class="w-30">{{ $data->complete_review_on }}</td>

                        <th class="w-20">Comment</th>
                        <td class="w-30">{{ $data->complete_review_comment }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Investigation Completed By</th>
                        <td class="w-30">{{ $data->investigation_completed_by }}</td>
                        <th class="w-20">Investigation Completed On</th>
                        <td class="w-30">{{ $data->investigation_completed_on}}</td>
                        <th class="w-20">Comment</th>
                        <td class="w-30">{{ $data->investigation_completed_comment }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Propose Plan By :</th>
                        <td class="w-30">{{ $data->propose_plan_by }}</td>
                        <th class="w-20">Propose Plan On :</th>
                        <td class="w-30">{{ $data->propose_plan_on }}</td>
                        <th class="w-20">Comment :</th>
                        <td class="w-30">{{ $data->propose_plan_comment }}</td>

                    </tr>

                    <tr>
                        <th class="w-20">Approve Plan By</th>
                        <td class="w-30">{{ $data->approve_plan_by }}</td>
                        <th class="w-20">Approve Plan On</th>
                        <td class="w-30">{{ $data->approve_plan_on }}</td>
                        <th class="w-20">Comment :</th>
                        <td class="w-30">{{ $data->approve_plan_comment }}</td>

                    </tr>
                    <tr>
                        <th class="w-20">All CAPA Closed By</th>
                        <td class="w-30">{{ $data->all_capa_closed_by }}</td>
                        <th class="w-20">All CAPA Closed On</th>
                        <td class="w-30">{{ $data->all_capa_closed_on }}</td>
                        <th class="w-20">Comment :</th>
                        <td class="w-30">{{ $data->all_capa_closed_comment }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Closure Done By</th>
                        <td class="w-30">{{ $data->closed_done_by }}</td>
                        <th class="w-20">Closure Done On</th>
                        <td class="w-30">{{ $data->closed_done_on }}</td>
                        <th class="w-20">Comment :</th>
                        <td class="w-30">{{ $data->closed_done_comment }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Cancelled By</th>
                        <td class="w-30">{{ $data->cancelled_by }}</td>
                        <th class="w-20">Cancelled On</th>
                        <td class="w-30">{{ $data->cancelled_on }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>


    @if (count($RootCause) > 0)
        @foreach ($RootCause as $data)
            <center>
                <h3>Root Cause Analysis Report</h3>
            </center>

            <div class="inner-block">
             <div class="content-table">
              <div class="block">
                <div class="block-head">
                    General Information
                </div>
                <table>
                    <tr> {{ $data->created_at }} added by {{ $data->originator }}
                        <th class="w-20">Initiator</th>
                        <td class="w-30">{{ Helpers::getInitiatorName($data->initiator_id) }}</td>
                        <th class="w-20">Record Number</th>
                        <td class="w-80">
                            {{ Helpers::divisionNameForQMS($data->division_id) }}/RCA/{{ Helpers::year($data->created_at) }}/{{ str_pad($data->record, 4, '0', STR_PAD_LEFT) }}


                    </tr>
                    <tr>
                        <th class="w-20">Site/Location Code</th>
                        <td class="w-30">
                            @if ($data->division_code)
                                {{ $data->division_code }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Date Initiation</th>
                        <td class="w-80">{{ Helpers::getdateFormat($data->created_at) }}</td>

                    </tr>
                    <tr>

                        <th class="w-20">Due Date</th>
                        <td class="w-30">
                            @if ($data->due_date)
                                {{ Helpers::getdateFormat($data->due_date) }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Assigned To</th>
                        <td class="w-80">
                            @if ($data->assign_to)
                                {{ Helpers::getInitiatorName($data->assign_to) }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                    </tr>
                    <tr>

                        <th class="w-20">Initiator Department</th>
                        <td class="w-80">
                            @if ($data->initiator_Group)
                                {{ Helpers::getInitiatorGroupFullName($data->initiator_Group) }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Initiator Department Code</th>
                        <td class="w-30">
                            @if ($data->initiator_group_code)
                                {{ $data->initiator_group_code }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                    </tr>
                    <tr>
                        <th class="w-20">Short Description</th>
                        <td class="w-30" colspan="3">
                            @if ($data->short_description)
                                {{ $data->short_description }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                    </tr>

                    <tr>{{-- <th class="w-20">Additional Investigators</th> <td class="w-30">@if ($data->investigators){{ $data->investigators }}@else Not Applicable @endif</td> --}}
                        <th class="w-20">Severity Level</th>
                        <td class="w-30">
                            @if ($data->severity_level)
                                {{ $data->severity_level }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Initiated Through</th>
                        <td class="w-80">
                            @if ($data->initiated_through)
                                {{ $data->initiated_through }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                    </tr>
                    <tr>{{-- <th class="w-20">Additional Investigators</th> <td class="w-30">@if ($data->investigators){{ $data->investigators }}@else Not Applicable @endif</td> --}}
                        <th class="w-20">Department Head</th>
                        <td class="w-30">
                            @if ($data->assign_to)
                                {{ Helpers::getInitiatorName($data->assign_to) }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">QA Reviewer</th>
                        <td class="w-80">
                            @if ($data->qa_reviewer)
                                {{ Helpers::getInitiatorName($data->qa_reviewer) }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                    </tr>
                    </table>
                    <div class="inner-block">
                        <label
                            class="Summer"style="font-weight: bold; font-size: 13px; display: inline-block; width: 75px;">
                            Others</label>
                        <span style="font-size: 0.8rem; margin-left: 60px;">
                            @if ($data->initiated_if_other)
                                {{ $data->initiated_if_other }}
                            @else
                                Not Applicable
                            @endif
                        </span>
                    </div>

                    <table>
                        <tr>
                            <th class="w-20">Type</th>
                            <td class="w-30">
                                @if ($data->Type)
                                    {{ $data->Type }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                            <th class="w-20">Priority Level</th>
                            <td class="w-80">
                                @if ($data->priority_level)
                                    {{ $data->priority_level }}
                                @else
                                    Not Applicable
                                @endif
                            </td>

                        </tr>
                        <tr>
                            <th class="w-20">Department(s)</th>
                            <td class="w-80">
                                @if ($data->department)
                                    {{ $data->department }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>
                    </table>
                    <div class="inner-block">
                        <label
                            class="Summer"style="font-weight: bold; font-size: 13px; display: inline-block; width: 75px;">
                            Description</label>
                        <span style="font-size: 0.8rem; margin-left: 60px;">
                            @if ($data->description)
                                {{ $data->description }}
                            @else
                                Not Applicable
                            @endif
                        </span>
                    </div>

                    <div class="inner-block">
                        <label
                            class="Summer"style="font-weight: bold; font-size: 13px; display: inline-block; width: 75px;">
                            Comments</label>
                        <span style="font-size: 0.8rem; margin-left: 60px;">
                            @if ($data->comments)
                                {{ $data->comments }}
                            @else
                                Not Applicable
                            @endif
                        </span>
                    </div>


                    <table>
                        <tr>

                            <th class="w-20">Related URL</th>
                            <td class="w-80" colspan="3">
                                @if ($data->related_url)
                                    {{ $data->related_url }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>

                    </table>
                    <div class="border-table">
                        <div class="block-head">
                            Initial Attachment
                        </div>
                        <table>

                            <tr class="table_bg">
                                <th class="w-20">S.N.</th>
                                <th class="w-60">Batch No</th>
                            </tr>
                            @if ($data->root_cause_initial_attachment)
                                @foreach (json_decode($data->root_cause_initial_attachment) as $key => $file)
                                    <tr>
                                        <td class="w-20">{{ $key + 1 }}</td>
                                        <td class="w-20"><a href="{{ asset('upload/' . $file) }}"
                                                target="_blank"><b>{{ $file }}</b></a> </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td class="w-20">1</td>
                                    <td class="w-20">Not Applicable</td>
                                </tr>
                            @endif

                        </table>
                    </div>

                    </div>
                    <div class="block">
                    <div class="block-head">
                        Investigation & Root Cause
                    </div>


                    <div class="inner-block">
                        <label
                            class="Summer"style="font-weight: bold; font-size: 13px; display: inline-block; width: 75px;">
                            Root Cause Methodology </label>
                        <span style="font-size: 0.8rem; margin-left: 60px;">
                            @if ($data->root_cause_methodology)
                                {{ $data->root_cause_methodology }}
                            @else
                                Not Applicable
                            @endif
                        </span>
                    </div>
                    <div class="inner-block">
                        <label
                            class="Summer"style="font-weight: bold; font-size: 13px; display: inline-block; width: 75px;">
                            Root Cause Description</label>
                        <span style="font-size: 0.8rem; margin-left: 60px;">
                            @if ($data->root_cause_description)
                                {{ $data->root_cause_description }}
                            @else
                                Not Applicable
                            @endif
                        </span>
                    </div>
                    <div class="inner-block">
                        <label
                            class="Summer"style="font-weight: bold; font-size: 13px; display: inline-block; width: 75px;">
                            Investigation Summary</label>
                        <span style="font-size: 0.8rem; margin-left: 60px;">
                            @if ($data->investigation_summary)
                                {{ $data->investigation_summary }}
                            @else
                                Not Applicable
                            @endif
                        </span>
                    </div>
                    <!-- <tr>
                                <th class="w-20">Attachments</th>
                                <td class="w-80">
                    @if ($data->attachments)
                    <a href="{{ asset('upload/document/', $data->attachments) }}">{{ $data->attachments }}
                    @else
                    Not Applicable
                    @endif
                    </td>
                    </tr> -->
                    {{-- <tr>
                                <th class="w-20">Comments</th>
                                <td class="w-80">@if ($data->comments){{ $data->comments }}@else Not Applicable @endif</td>
                            </tr>
                        --}}
                    </table>
                    <div class="border-table tbl-bottum ">
                        <div class="block-head">
                            Root Cause
                        </div>
                        <table>

                            <tr class="table_bg">
                                <th class="w-10">Row #</th>
                                <th class="w-30">Root Cause Category</th>
                                <th class="w-30">Root Cause Sub-Category</th>
                                <th class="w-30">Probability</th>
                                <th class="w-30">Remarks</th>
                            </tr>
                            {{-- @if ($data->root_cause_initial_attachment)
                                    @foreach (json_decode($data->root_cause_initial_attachment) as $key => $file)
                                        <tr>
                                            <td class="w-20">{{ $key + 1 }}</td>
                                            <td class="w-20"><a href="{{ asset('upload/' . $file) }}" target="_blank"><b>{{ $file }}</b></a> </td>
                                        </tr>
                                    @endforeach
                                    @else --}}
                            @if (!empty($data->Root_Cause_Category))
                                @foreach (unserialize($data->Root_Cause_Category) as $key => $Root_Cause_Category)
                                    <tr>
                                        <td class="w-10">{{ $key + 1 }}</td>
                                        <td class="w-30">
                                            {{ unserialize($data->Root_Cause_Category)[$key] ? unserialize($data->Root_Cause_Category)[$key] : '' }}
                                        </td>
                                        <td class="w-30">
                                            {{ unserialize($data->Root_Cause_Sub_Category)[$key] ? unserialize($data->Root_Cause_Sub_Category)[$key] : '' }}
                                        </td>
                                        <td class="w-30">
                                            {{ unserialize($data->Probability)[$key] ? unserialize($data->Probability)[$key] : '' }}
                                        </td>
                                        <td class="w-30">{{ unserialize($data->Remarks)[$key] ?? null }}</td>
                                    </tr>
                                @endforeach
                            @else
                            @endif

                        </table>
                    </div>

                    <div class="border-table  tbl-bottum">
                        <div class="block-head">
                            Failure Mode and Effect Analysis
                        </div>
                        <table>

                            <tr class="table_bg">
                                <th class="w-10">Row #</th>
                                <th class="w-30">Risk Factor</th>
                                <th class="w-30">Risk element</th>
                                <th class="w-30">Probable cause of risk element</th>
                                <th class="w-30">Existing Risk Controls</th>
                            </tr>
                            {{-- @if ($data->root_cause_initial_attachment)
                                    @foreach (json_decode($data->root_cause_initial_attachment) as $key => $file)
                                        <tr>
                                            <td class="w-20">{{ $key + 1 }}</td>
                                            <td class="w-20"><a href="{{ asset('upload/' . $file) }}" target="_blank"><b>{{ $file }}</b></a> </td>
                                        </tr>
                                    @endforeach
                                    @else --}}
                            @if (!empty($data->risk_factor))
                                @foreach (unserialize($data->risk_factor) as $key => $riskFactor)
                                    <tr>
                                        <td class="w-10">{{ $key + 1 }}</td>
                                        <td class="w-30">{{ $riskFactor }}</td>
                                        <td class="w-30">{{ unserialize($data->risk_element)[$key] ?? null }}</td>
                                        <td class="w-30">{{ unserialize($data->problem_cause)[$key] ?? null }}</td>
                                        <td class="w-30">{{ unserialize($data->existing_risk_control)[$key] ?? null }}
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                            @endif

                        </table>

                        </div>
                        <div class="border-table  tbl-bottum">
                            <table>
                                <tr class="table_bg">
                                    <th class="w-10">Row #</th>
                                    <th class="w-30">Initial Severity- H(3)/M(2)/L(1)</th>
                                    <th class="w-30">Initial Probability- H(3)/M(2)/L(1)</th>
                                    <th class="w-30">Initial Detectability- H(1)/M(2)/L(3)</th>
                                    <th class="w-30">Initial RPN</th>
                                </tr>
                                @if (!empty($data->risk_factor))
                                    @foreach (unserialize($data->risk_factor) as $key => $riskFactor)
                                        <tr>
                                            <td class="w-10">{{ $key + 1 }}</td>
                                            <td class="w-30">{{ unserialize($data->initial_severity)[$key] }}</td>
                                            <td class="w-30">{{ unserialize($data->initial_detectability)[$key] }}</td>
                                            <td class="w-30">{{ unserialize($data->initial_probability)[$key] }}</td>
                                            <td class="w-30">{{ unserialize($data->initial_rpn)[$key] }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                @endif
                            </table>
                        </div>
                        <div class="border-table  tbl-bottum">
                            <table>
                                <tr class="table_bg">
                                    <th class="w-10">Row #</th>
                                    <th class="w-30">Risk Acceptance (Y/N)</th>
                                    <th class="w-30">Proposed Additional Risk control measure (Mandatory for Risk elements
                                        having RPN>4)</th>
                                    <th class="w-30">Residual Severity- H(3)/M(2)/L(1)</th>
                                    <th class="w-30">Residual Probability- H(3)/M(2)/L(1)</th>
                                </tr>
                                @if (!empty($data->risk_factor))
                                    @foreach (unserialize($data->risk_factor) as $key => $riskFactor)
                                        <tr>
                                            <td class="w-10">{{ $key + 1 }}</td>
                                            <td class="w-30">{{ unserialize($data->risk_acceptance)[$key] }}</td>
                                            <td class="w-30">{{ unserialize($data->risk_control_measure)[$key] }}</td>
                                            <td class="w-30">{{ unserialize($data->residual_severity)[$key] }}</td>
                                            <td class="w-30">{{ unserialize($data->residual_probability)[$key] }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                @endif
                            </table>
                        </div>
                        <div class="border-table  tbl-bottum">
                            <table>
                                <tr class="table_bg">
                                    <th class="w-10">Row #</th>
                                    <th class="w-30">Residual Detectability- H(1)/M(2)/L(3)</th>
                                    <th class="w-30">Residual RPN</th>
                                    <th class="w-30">Risk Acceptance (Y/N)</th>
                                    <th class="w-30">Mitigation proposal (Mention either CAPA reference number, IQ, OQ or PQ)
                                    </th>
                                </tr>
                                @if (!empty($data->risk_factor))
                                    @foreach (unserialize($data->risk_factor) as $key => $riskFactor)
                                        <tr>
                                            <td class="w-10">{{ $key + 1 }}</td>
                                            <td class="w-30">{{ unserialize($data->residual_detectability)[$key] }}</td>
                                            <td class="w-30">{{ unserialize($data->residual_rpn)[$key] }}</td>
                                            <td class="w-30">{{ unserialize($data->risk_acceptance2)[$key] }}</td>
                                            <td class="w-30">{{ unserialize($data->mitigation_proposal)[$key] }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                @endif
                            </table>
                        </div>

                        <div class="block-head">
                            Fishbone or Ishikawa Diagram
                        </div>
                        <table>
                            - <tr>
                                <th class="w-20">Measurement</th>
                                {{-- <td class="w-80">@if ($riskgrdfishbone->measurement){{ $riskgrdfishbone->measurement }}@else Not Applicable @endif</td> --}}
                                <td class="w-80">
                                    @php
                                        $measurement = unserialize($data->measurement);
                                    @endphp

                                    @if (is_array($measurement))
                                        @foreach ($measurement as $value)
                                            {{ htmlspecialchars($value) }}
                                        @endforeach
                                    @elseif(is_string($measurement))
                                        {{ htmlspecialchars($measurement) }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                                <th class="w-20">Materials</th>
                                {{-- <td class="w-80">@if ($data->materials){{ $data->materials }}@else Not Applicable @endif</td> --}}
                                <td class="w-80">
                                    @php
                                        $materials = unserialize($data->materials);
                                    @endphp

                                    @if (is_array($materials))
                                        @foreach ($materials as $value)
                                            {{ htmlspecialchars($value) }}
                                        @endforeach
                                    @elseif(is_string($materials))
                                        {{ htmlspecialchars($materials) }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>

                            </tr>
                            <tr>
                                <th class="w-20">Methods</th>
                                {{-- <td class="w-80">@if ($data->methods){{ $data->methods }}@else Not Applicable @endif</td> --}}
                                <td class="w-80">
                                    @php
                                        $methods = unserialize($data->methods);
                                    @endphp

                                    @if (is_array($methods))
                                        @foreach ($methods as $value)
                                            {{ htmlspecialchars($value) }}
                                        @endforeach
                                    @elseif(is_string($methods))
                                        {{ htmlspecialchars($methods) }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                                <th class="w-20">Environment</th>
                                {{-- <td class="w-80">@if ($data->environment){{ $data->environment }}@else Not Applicable @endif</td> --}}
                                <td class="w-80">
                                    @php
                                        $environment = unserialize($data->environment);
                                    @endphp

                                    @if (is_array($environment))
                                        @foreach ($environment as $value)
                                            {{ htmlspecialchars($value) }}
                                        @endforeach
                                    @elseif(is_string($environment))
                                        {{ htmlspecialchars($environment) }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th class="w-20">Manpower</th>
                                {{-- <td class="w-80">@if ($data->manpower){{ $data->manpower }}@else Not Applicable @endif</td> --}}
                                <td class="w-80">
                                    @php
                                        $manpower = unserialize($data->manpower);
                                    @endphp

                                    @if (is_array($manpower))
                                        @foreach ($manpower as $value)
                                            {{ htmlspecialchars($value) }}
                                        @endforeach
                                    @elseif(is_string($manpower))
                                        {{ htmlspecialchars($manpower) }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                                <th class="w-20">Machine</th>
                                {{-- <td class="w-80">@if ($data->machine){{ $data->machine }}@else Not Applicable @endif</td> --}}
                                <td class="w-80">
                                    @php
                                        $machine = unserialize($data->machine);
                                    @endphp

                                    @if (is_array($machine))
                                        @foreach ($machine as $value)
                                            {{ htmlspecialchars($value) }}
                                        @endforeach
                                    @elseif(is_string($machine))
                                        {{ htmlspecialchars($machine) }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                            </tr>

                        </table>
                        <div class="inner-block">
                            <label
                                class="Summer"style="font-weight: bold; font-size: 13px; display: inline-block; width: 75px;">
                                Problem Statement1</label>
                            <span style="font-size: 0.8rem; margin-left: 60px;">
                                @if ($data->problem_statement)
                                    {{ $data->problem_statement }}
                                @else
                                    Not Applicable
                                @endif
                            </span>
                        </div>

                        <div class="block-head mt-1">
                            Why-Why Chart
                        </div>

                        <div class="inner-block">
                            <label
                                class="Summer"style="font-weight: bold; font-size: 13px; display: inline-block; width: 75px;">
                                Problem Statement</label>
                            <span style="font-size: 0.8rem; margin-left: 60px;">
                                @if ($data->why_problem_statement)
                                    {{ $data->why_problem_statement }}
                                @else
                                    Not Applicable
                                @endif
                            </span>
                        </div>


                        <table>


                            <tr>

                                <th class="w-20">Why 1 </th>
                                {{-- <td class="w-80">@if ($data->why_1){{ $data->why_1 }}@else Not Applicable @endif</td> --}}
                                <td class="w-80">
                                    @php
                                        $why_1 = unserialize($data->why_1);
                                    @endphp

                                    @if (is_array($why_1))
                                        @foreach ($why_1 as $value)
                                            {{ htmlspecialchars($value) }}
                                        @endforeach
                                    @elseif(is_string($why_1))
                                        {{ htmlspecialchars($why_1) }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th class="w-20">Why 2</th>
                                {{-- <td class="w-80">@if ($data->why_2){{ $data->why_2 }}@else Not Applicable @endif</td> --}}
                                <td class ="w-80">
                                    @php
                                        $why_2 = unserialize($data->why_2);
                                    @endphp

                                    @if (is_array($why_2))
                                        @foreach ($why_2 as $value)
                                            {{ htmlspecialchars($value) }}
                                        @endforeach
                                    @elseif(is_string($why_2))
                                        {{ htmlspecialchars($why_2) }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                            </tr>
                            <tr>

                                <th class="w-20">Why 3</th>
                                {{-- <td class="w-80">@if ($data->why_3){{ $data->why_3 }}@else Not Applicable @endif</td> --}}
                                <td class="w-80">
                                    @php
                                        $why_3 = unserialize($data->why_3);
                                    @endphp

                                    @if (is_array($why_3))
                                        @foreach ($why_3 as $value)
                                            {{ htmlspecialchars($value) }}
                                        @endforeach
                                    @elseif(is_string($why_3))
                                        {{ htmlspecialchars($why_3) }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th class="w-20">Why 4</th>
                                {{-- <td class="w-80">@if ($data->why_4){{ $data->why_4 }}@else Not Applicable @endif</td> --}}
                                <td class="w-80">
                                    @php
                                        $why_4 = unserialize($data->why_4);
                                    @endphp

                                    @if (is_array($why_4))
                                        @foreach ($why_4 as $value)
                                            {{ htmlspecialchars($value) }}
                                        @endforeach
                                    @elseif(is_string($why_4))
                                        {{ htmlspecialchars($why_4) }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                            </tr>
                            <tr>

                                <th class="w-20">Why5</th>
                                {{-- <td class="w-80">@if ($data->why_4){{ $data->why_4 }}@else Not Applicable @endif</td> --}}
                                <td class="w-80" colspan="3">
                                    @php
                                        $why_5 = unserialize($data->why_5);
                                    @endphp

                                    @if (is_array($why_5))
                                        @foreach ($why_5 as $value)
                                            {{ htmlspecialchars($value) }}
                                        @endforeach
                                    @elseif(is_string($why_5))
                                        {{ htmlspecialchars($why_5) }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                            </tr>
                        </table>

                        <div class="inner-block">
                            <label class="Summer"
                                style="font-weight: bold; font-size: 13px; display: inline-block; width: 75px;">
                                Root Cause :</label>
                            <span style="font-size: 0.8rem; margin-left: 60px;">
                                @if ($data->why_root_cause)
                                    {{ $data->why_root_cause }}
                                @else
                                    Not Applicable
                                @endif
                            </span>
                        </div>
                        <div class="block-head">
                            Is/Is Not Analysis
                        </div>



                        <table>
                            <tr>
                                <th class="w-20">What Will Be</th>
                                <td class="w-80">
                                    @if ($data->what_will_be)
                                        {{ $data->what_will_be }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th class="w-20">What Will Not Be </th>
                                <td class="w-80">
                                    @if ($data->what_will_not_be)
                                        {{ $data->what_will_not_be }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th class="w-20">What Will Rationale </th>
                                <td class="w-80">
                                    @if ($data->what_rationable)
                                        {{ $data->what_rationable }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th class="w-20">Where Will Be</th>
                                <td class="w-80">
                                    @if ($data->where_will_be)
                                        {{ $data->where_will_be }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th class="w-20">Where Will Not Be </th>
                                <td class="w-80">
                                    @if ($data->where_will_not_be)
                                        {{ $data->where_will_not_be }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th class="w-20">Where Will Rationale </th>
                                <td class="w-80">
                                    @if ($data->where_rationable)
                                        {{ $data->where_rationable }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>

                            <tr>
                                <th class="w-20">When Will Be</th>
                                <td class="w-80">
                                    @if ($data->when_will_be)
                                        {{ $data->when_will_be }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th class="w-20">When Will Not Be </th>
                                <td class="w-80">
                                    @if ($data->when_will_not_be)
                                        {{ $data->when_will_not_be }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th class="w-20">When Will Rationale </th>
                                <td class="w-80">
                                    @if ($data->when_rationable)
                                        {{ $data->when_rationable }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th class="w-20">Coverage Will Be</th>
                                <td class="w-80">
                                    @if ($data->coverage_will_be)
                                        {{ $data->coverage_will_be }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th class="w-20">Coverage Will Not Be </th>
                                <td class="w-80">
                                    @if ($data->coverage_will_not_be)
                                        {{ $data->coverage_will_not_be }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th class="w-20">Coverage Will Rationale </th>
                                <td class="w-80">
                                    @if ($data->coverage_rationable)
                                        {{ $data->coverage_rationable }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th class="w-20">Who Will Be</th>
                                <td class="w-80">
                                    @if ($data->who_will_be)
                                        {{ $data->who_will_be }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                            </tr>

                            <tr>

                                <th class="w-20">Who Will Not Be </th>
                                <td class="w-80">
                                    @if ($data->who_will_not_be)
                                        {{ $data->who_will_not_be }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                            </tr>
                            <tr>

                                <th class="w-20">Who Will Rationale </th>
                                <td class="w-80">
                                    @if ($data->who_rationable)
                                        {{ $data->who_rationable }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>

                            </tr>
                        </table>
                    </div>
                </div>
                <div class="block">
                    <div class="block-head">
                        Investigation
                    </div>

                    <table>


                        <tr>
                            <th class="w-20">Objective</th>
                            <td class="w-80">
                                @if ($data->objective)
                                    {{ $data->objective }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th class="w-20">Scope</th>
                            <td class="w-80">
                                @if ($data->scope)
                                    {{ $data->scope }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th class="w-20">Problem Statement</th>
                            <td class="w-80">
                                @if ($data->problem_statement_rca)
                                    {{ $data->problem_statement_rca }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th class="w-20">Background</th>
                            <td class="w-80">
                                @if ($data->requirement)
                                    {{ $data->requirement }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th class="w-20">Immediate Action</th>
                            <td class="w-80">
                                @if ($data->immediate_action)
                                    {{ $data->immediate_action }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th class="w-20">Investigation Team</th>
                            <td class="w-80">
                                @if ($data->investigation_team)
                                    {{ Helpers::getInitiatorName($data->investigation_team) }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>
                        {{-- <tr>
                            <th class="w-20">Investigation Tool</th>
                            <td class="w-80">
                                @if ($data->investigation_tool)
                                    {{ $data->investigation_tool }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr> --}}
                        <tr>
                            <th class="w-20">Root Cause</th>
                            <td class="w-80">
                                @if ($data->root_cause)
                                    {{ $data->root_cause }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th class="w-20">Impact / Risk Assessment</th>
                            <td class="w-80">
                                @if ($data->impact_risk_assessment)
                                    {{ $data->impact_risk_assessment }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th class="w-20">CAPA</th>
                            <td class="w-80">
                                @if ($data->capa)
                                    {{ $data->capa }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th class="w-20">Investigation Summary</th>
                            <td class="w-80">
                                @if ($data->investigation_summary_rca)
                                    {{ $data->investigation_summary_rca }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>



                    </table>
                    <div class="border-table">
                        <div class="block-head">
                            Investigation Attachment

                        </div>
                        <table>

                            <tr class="table_bg">
                                <th class="w-20">S.N.</th>
                                <th class="w-60">Batch No</th>
                            </tr>
                            @if ($data->root_cause_initial_attachment_rca)
                                @foreach (json_decode($data->root_cause_initial_attachment_rca) as $key => $file)
                                    <tr>
                                        <td class="w-20">{{ $key + 1 }}</td>
                                        <td class="w-20"><a href="{{ asset('upload/' . $file) }}"
                                                target="_blank"><b>{{ $file }}</b></a> </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td class="w-20">1</td>
                                    <td class="w-20">Not Applicable</td>
                                </tr>
                            @endif

                        </table>
                    </div>
                </div>
                <div class="block">
                    <div class="block-head">
                        QA Review
                    </div>
                    <div class="inner-block">
                        <label class="Summer" style="font-weight: bold; font-size: 13px; display: inline-block; width: 75px;">
                            QA Review Comments</label>
                        <span style="font-size: 0.8rem; margin-left: 60px;">
                            @if ($data->cft_comments_new)
                                {{ $data->cft_comments_new }}
                            @else
                                Not Applicable
                            @endif
                        </span>
                    </div>
                    <div class="border-table">
                        <div class="block-head">
                            QA Review Attachment

                        </div>
                        <table>

                            <tr class="table_bg">
                                <th class="w-20">S.N.</th>
                                <th class="w-60">Batch No</th>
                            </tr>
                            @if ($data->cft_attchament_new)
                                @foreach (json_decode($data->cft_attchament_new) as $key => $file)
                                    <tr>
                                        <td class="w-20">{{ $key + 1 }}</td>
                                        <td class="w-20"><a href="{{ asset('upload/' . $file) }}"
                                                target="_blank"><b>{{ $file }}</b></a> </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td class="w-20">1</td>
                                    <td class="w-20">Not Applicable</td>
                                </tr>
                            @endif

                        </table>
                    </div>

                </div>
                <div class="block">
                    <div class="block-head">
                        HOD Final Review
                    </div>
                    <div class="inner-block">
                        <label class="Summer" style="font-weight: bold; font-size: 13px; display: inline-block; width: 75px;">
                            HOD Final Review Comments</label>
                        <span style="font-size: 0.8rem; margin-left: 60px;">
                            @if ($data->hod_final_comments)
                                {{ $data->hod_final_comments }}
                            @else
                                Not Applicable
                            @endif
                        </span>
                    </div>
                    <div class="border-table">
                        <div class="block-head">
                            HOD Final Review Attachment

                        </div>
                        <table>

                            <tr class="table_bg">
                                <th class="w-20">S.N.</th>
                                <th class="w-60">Batch No</th>
                            </tr>
                            @if ($data->hod_final_attachments)
                                @foreach (json_decode($data->hod_final_attachments) as $key => $file)
                                    <tr>
                                        <td class="w-20">{{ $key + 1 }}</td>
                                        <td class="w-20"><a href="{{ asset('upload/' . $file) }}"
                                                target="_blank"><b>{{ $file }}</b></a> </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td class="w-20">1</td>
                                    <td class="w-20">Not Applicable</td>
                                </tr>
                            @endif

                        </table>
                    </div>

                </div>
                <div class="block">
                    <div class="block-head">
                        QA Final Review
                    </div>
                    <div class="inner-block">
                        <label class="Summer" style="font-weight: bold; font-size: 13px; display: inline-block; width: 75px;">
                            QA Final Review Comments</label>
                        <span style="font-size: 0.8rem; margin-left: 60px;">
                            @if ($data->qa_final_comments)
                                {{ $data->qa_final_comments }}
                            @else
                                Not Applicable
                            @endif
                        </span>
                    </div>
                    <div class="border-table">
                        <div class="block-head">
                            QA Final Review Attachment

                        </div>
                        <table>

                            <tr class="table_bg">
                                <th class="w-20">S.N.</th>
                                <th class="w-60">Batch No</th>
                            </tr>
                            @if ($data->qa_final_attachments)
                                @foreach (json_decode($data->qa_final_attachments) as $key => $file)
                                    <tr>
                                        <td class="w-20">{{ $key + 1 }}</td>
                                        <td class="w-20"><a href="{{ asset('upload/' . $file) }}"
                                                target="_blank"><b>{{ $file }}</b></a> </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td class="w-20">1</td>
                                    <td class="w-20">Not Applicable</td>
                                </tr>
                            @endif

                        </table>
                    </div>

                </div>
                <div class="block">
                    <div class="block-head">
                        QAH/CQAH Final Review
                    </div>
                    <div class="inner-block">
                        <label class="Summer" style="font-weight: bold; font-size: 13px; display: inline-block; width: 75px;">
                            QAH/CQAH Final Review Comments</label>
                        <span style="font-size: 0.8rem; margin-left: 60px;">
                            @if ($data->qah_final_comments)
                                {{ $data->qah_final_comments }}
                            @else
                                Not Applicable
                            @endif
                        </span>
                    </div>
                    <div class="border-table">
                        <div class="block-head">
                            QAH/CQAH Final Review Attachment

                        </div>
                        <table>

                            <tr class="table_bg">
                                <th class="w-20">S.N.</th>
                                <th class="w-60">Batch No</th>
                            </tr>
                            @if ($data->qah_final_attachments)
                                @foreach (json_decode($data->qah_final_attachments) as $key => $file)
                                    <tr>
                                        <td class="w-20">{{ $key + 1 }}</td>
                                        <td class="w-20"><a href="{{ asset('upload/' . $file) }}"
                                                target="_blank"><b>{{ $file }}</b></a> </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td class="w-20">1</td>
                                    <td class="w-20">Not Applicable</td>
                                </tr>
                            @endif

                        </table>
                    </div>

                </div>


                <div class="block">
                    <div class="block-head">
                        Activity log
                    </div>
                    <table>

                        <tr>
                            <th class="w-20">Acknowledge By</th>
                            <td class="w-30">
                                @if ($data->acknowledge_by)
                                    {{ $data->acknowledge_by }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                            <th class="w-20">Acknowledge On</th>
                            <td class="w-30">
                                @if ($data->acknowledge_on)
                                    {{ Helpers::getdateFormat($data->acknowledge_on) }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        <tr>
                            <th class="w-20"> Comment</th>
                            <td class="w-80">
                                @if ($data->acknowledge_comment)
                                    {{ $data->acknowledge_comment }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>

                        {{-- <tr>
                                <th class="w-20"> More Info Required By
                                </th>
                                <td class="w-30">{{ $data->More_Info_hrc_by }}</td>
                                <th class="w-20">
                                    More Info Required On</th>
                                <td class="w-30">{{ $data->More_Info_hrc_on }}</td>
                                <th class="w-20">
                                    Comment</th>
                                <td class="w-30">{{ $data->More_Info_hrc_comment }}</td>
                            </tr> --}}

                        <tr>
                            <th class="w-20">QA/CQA Review Complete By</th>
                            <td class="w-30">
                                @if ($data->QQQA_Review_Complete_By)
                                    {{ $data->QQQA_Review_Complete_By }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                            <th class="w-20">QA/CQA Review Complete On</th>
                            <td class="w-30">
                                @if ($data->QQQA_Review_Complete_On)
                                    {{ Helpers::getdateFormat($data->QQQA_Review_Complete_On) }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                            <th class="w-20">Sumitted Comment</th>
                            <td class="w-80">
                                @if ($data->QAQQ_Review_Complete_comment)
                                    {{ $data->QAQQ_Review_Complete_comment }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>
                        {{-- <tr>
                                <th class="w-20">More information Required By</th>
                                <td class="w-30"> @if ($data->More_Info_qac_by) {{ $data->More_Info_qac_by }} @else Not Applicable @endif</td>
                                <th class="w-20">More information Required On</th>
                                <td class="w-30"> @if ($data->More_Info_qac_on) {{ Helpers::getdateFormat($data->More_Info_qac_on) }} @else Not Applicable @endif</td>
                                <th class="w-20">More information Required Comment</th>
                            <td class="w-80"> @if ($data->More_Info_qac_comment) {{ $data->More_Info_qac_comment }} @else Not Applicable @endif</td>
                            
                            </tr> --}}
                        {{-- <tr>
                                <th class="w-20">Sumitted Comment</th>
                                <td class="w-80"> @if ($data->submitted_comment) {{ $data->submitted_comment }} @else Not Applicable @endif</td>
                            </tr> --}}
                        {{-- <th class="w-20">More information Required Comment</th>
                            <td class="w-80"> @if ($data->More_Info_qac_comment) {{ $data->More_Info_qac_comment }} @else Not Applicable @endif</td> --}}

                        <th class="w-20">HOD Review Complete By</th>
                        <td class="w-30">
                            @if ($data->HOD_Review_Complete_By)
                                {{ $data->HOD_Review_Complete_By }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">HOD Review Complete On</th>
                        <td class="w-30">
                            @if ($data->HOD_Review_Complete_On)
                                {{ Helpers::getdateFormat($data->HOD_Review_Complete_On) }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20"> Comment</th>
                        <td class="w-80">
                            @if ($data->HOD_Review_Complete_Comment)
                                {{ $data->HOD_Review_Complete_Comment }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        {{-- <th class="w-20">QA Review Completed Comment</th>
                                <td class="w-80"> @if ($data->qA_review_complete_comment) {{ $data->qA_review_complete_comment }} @else Not Applicable @endif</td> --}}
                        </tr>

                        {{-- <tr>
                                <th class="w-20"> More Info Required By
                                </th>
                                <td class="w-30">{{ $data->More_Info_hrc_by }}</td>
                                <th class="w-20">
                                    More Info Required On</th>
                                <td class="w-30">{{ $data->More_Info_hrc_on }}</td>
                                <th class="w-20">
                                    Comment</th>
                                <td class="w-30">{{ $data->More_Info_hrc_comment }}</td>
                            </tr>
                        --}}
                        <tr>
                            <th class="w-20">Submit By</th>
                            <td class="w-30">
                                @if ($data->submitted_by)
                                    {{ $data->submitted_by }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                            <th class="w-20">Submit On</th>
                            <td class="w-30">
                                @if ($data->submitted_on)
                                    {{ Helpers::getdateFormat($data->submitted_on) }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                            <th class="w-20"> Comment</th>
                            <td class="w-30">
                                @if ($data->qa_comments_new)
                                    {{ $data->qa_comments_new }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>

                        {{-- <tr>
                                <th class="w-20"> More Info Required By
                                </th>
                                <td class="w-30">{{ $data->More_Info_sub_by }}</td>
                                <th class="w-20">
                                    More Info Required On</th>
                                <td class="w-30">{{ $data->More_Info_sub_on }}</td>
                                <th class="w-20">
                                    Comment</th>
                                <td class="w-30">{{ $data->More_Info_sub_comment }}</td>
                            </tr> --}}
                        <tr>
                            <th class="w-20">HOD Final Review Completed By</th>
                            <td class="w-30">{{ $data->hod_final_review_completed_by }}</td>
                            <th class="w-20">HOD Final Review Completed On</th>
                            <td class="w-30">{{ $data->hod_final_review_completed_on }}</td>
                            <th class="w-20">
                                Comment</th>
                            <td class="w-30">{{ $data->HOD_Final_Review_Complete_Comment }}</td>
                        </tr>
                        {{-- <tr>
                                <th class="w-20">More Info Required By
                                </th>
                                <td class="w-30">{{ $data->More_Info_hfr_by }}</td>
                                <th class="w-20">
                                    More Info Required On</th>
                                <td class="w-30">{{ $data->More_Info_hfr_on }}</td>
                                <th class="w-20">
                                    Comment</th>
                                <td class="w-30">{{ $data->More_Info_hfr_comment }}</td>
                            </tr> --}}
                        <tr>
                            <th class="w-20"> FinalQA/CQA Review Complete By</th>
                            <td class="w-30">
                                @if ($data->Final_QA_Review_Complete_By)
                                    {{ $data->Final_QA_Review_Complete_By }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                            <th class="w-20"> FinalQA/CQA Review Complete On</th>
                            <td class="w-30">
                                @if ($data->Final_QA_Review_Complete_On)
                                    {{ Helpers::getdateFormat($data->Final_QA_Review_Complete_On) }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                            <th class="w-20"> Comment</th>
                            <td class="w-80">
                                @if ($data->evalution_Closure_comment)
                                    {{ $data->Final_QA_Review_Complete_Comment }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>
                        {{-- <tr>
                                <th class="w-20">More information Required By</th>
                                <td class="w-30"> @if ($data->qA_review_complete_by) {{ $data->qA_review_complete_by }} @else Not Applicable @endif</td>
                                <th class="w-20">More information Required On</th>
                                <td class="w-30"> @if ($data->qA_review_complete_on) {{ Helpers::getdateFormat($data->qA_review_complete_on) }} @else Not Applicable @endif</td>
                                <th class="w-20">More information Required Comment</th>
                            <td class="w-80"> @if ($data->qA_review_complete_comment) {{ $data->qA_review_complete_comment }} @else Not Applicable @endif</td>
                            
                            </tr> --}}
                        <tr>
                            <th class="w-20">QAH/CQAH Closure By</th>
                            <td class="w-30">
                                @if ($data->evaluation_complete_by)
                                    {{ $data->evaluation_complete_by }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                            <th class="w-20">QAH/CQAH Closure On</th>
                            <td class="w-30">
                                @if ($data->evaluation_complete_on)
                                    {{ Helpers::getdateFormat($data->evaluation_complete_on) }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                            <th class="w-20">
                                Comment</th>
                            <td class="w-80">
                                @if ($data->Final_QA_Review_Complete_Comment)
                                    {{ $data->evalution_Closure_comment }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th class="w-20">Cancelled By
                            </th>
                            <td class="w-30">
                                @if ($data->cancelled_by)
                                    {{ $data->cancelled_by }}
                                @else
                                    Not Applicable
                                @endif
                            <th class="w-20">
                                Cancelled On</th>
                            <td class="w-30">
                                @if ($data->cancelled_on)
                                    {{ $data->cancelled_on }}
                                @else
                                    Not Applicable
                                @endif
                            <th class="w-20">
                                Comments</th>
                            <td class="w-30">
                                @if ($data->cancel_comment)
                                    {{ $data->cancel_comment }}
                                @else
                                    Not Applicable
                                @endif
                        </tr>

                    </table>
                </div>
            </div>
            </div>

        @endforeach
    @endif


    @if (count($capa) > 0)
        @foreach ($capa as $data)
            <center>
                <h3>Capa Report</h3>
            </center>

            <div class="inner-block">
                <div class="content-table">
                    <div class="block">
                        <div class="block-head">
                            General Information
                        </div>
                        <table>

                            <tr>
                                <th class="w-20">Record Number</th>
                                <td class="w-80">
                                    {{ Helpers::divisionNameForQMS($data->division_id) }}/{{ Helpers::year($data->created_at) }}/CAPA/{{ str_pad($data->record, 4, '0', STR_PAD_LEFT) }}
                                </td>
                                <th class="w-20">Site/Location Code</th>
                                <td class="w-80">
                                    @if ($data->division_id)
                                        {{ Helpers::getDivisionName($data->division_id) }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                            </tr>

                            <tr> {{ $data->created_at }} added by {{ $data->originator }}
                                <th class="w-20">Initiator</th>
                                <td class="w-80">{{ $data->originator }}</td>
                                <th class="w-20">Date of Initiation</th>
                                <td class="w-80">{{ Helpers::getdateFormat($data->intiation_date) }}</td>
                            </tr>
                            <tr>
                                <th class="w-20">Assigned To</th>
                                <td class="w-80">
                                    @if ($data->assign_to)
                                        {{ $data->assign_to }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                                <th class="w-20">Due Date</th>
                                <td class="w-80">
                                    @if ($data->due_date)
                                        {{ Helpers::getdateFormat($data->due_date) }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                            </tr>

                            <tr>
                                <th class="w-20">Department Group</th>
                                @php
                                    $departments = [
                                        'CQA' => 'Corporate Quality Assurance',
                                        'QAB' => 'Quality Assurance Biopharma',
                                        'CQC' => 'Central Quality Control',
                                        'PSG' => 'Plasma Sourcing Group',
                                        'CS' => 'Central Stores',
                                        'ITG' => 'Information Technology Group',
                                        'MM' => 'Molecular Medicine',
                                        'CL' => 'Central Laboratory',
                                        'TT' => 'Tech Team',
                                        'QA' => 'Quality Assurance',
                                        'QM' => 'Quality Management',
                                        'IA' => 'IT Administration',
                                        'ACC' => 'Accounting',
                                        'LOG' => 'Logistics',
                                        'SM' => 'Senior Management',
                                        'BA' => 'Business Administration',
                                    ];
                                @endphp
                                <td class="w-80">{{ $departments[$data->initiator_Group] ?? 'Not Application' }}</td>

                                <th class="w-20">Department Group Code</th>
                                <td class="w-80">
                                    @if ($data->initiator_group_code)
                                        {{ $data->initiator_group_code }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                            </tr>
                        </table>

                        <label class="head-number" for="Short Description">Short Description</label>
                        <div class="div-data">
                            @if ($data->short_description)
                                {{ $data->short_description }}
                            @else
                                Not Applicable
                            @endif
                        </div>

                        <label class="head-number" for="Product Name">Product Name</label>
                        <div class="div-data">
                            @if ($data->product_name)
                                {{ $data->product_name }}
                            @else
                                Not Applicable
                            @endif
                        </div>

                        <label class="head-number" for="CAPA Source & Number">CAPA Source & Number</label>
                        <div class="div-data">
                            @if ($data->capa_source_number)
                                {{ $data->capa_source_number }}
                            @else
                                Not Applicable
                            @endif
                        </div>

                        <table>
                            <tr>
                                <th class="w-20">Initiated Through</th>
                                <td class="w-80">
                                    @if ($data->initiated_through)
                                        {{ $data->initiated_through }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                                <th class="w-20">Others</th>
                                <td class="w-80">
                                    @if ($data->initiated_through_req)
                                        {{ $data->initiated_through_req }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th class="w-20">Repeat</th>
                                <td class="w-80">
                                    @if ($data->repeat)
                                        {{ $data->repeat }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                                <th class="w-20">Repeat Nature</th>
                                <td class="w-80">
                                    @if ($data->repeat_nature)
                                        {{ $data->repeat_nature }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                            </tr>
                        </table>

                        <label class="head-number" for="Problem Description">Problem Description</label>
                        <div class="div-data">
                            @if ($data->problem_description)
                                {{ $data->problem_description }}
                            @else
                                Not Applicable
                            @endif
                        </div>

                        <table>
                            <tr>
                                <th class="w-20">CAPA Team</th>
                                <td class="w-80">
                                    @if ($data->capa_team)
                                        {{ $capa_teamNamesString }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>

                                <th class="w-20">Reference Records</th>
                                <td class="w-80">
                                    @if ($data->capa_related_record)
                                        {{ str_replace(',', ', ', $data->capa_related_record) }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                            </tr>
                        </table>
                        <label class="head-number" for="Initial Observation">Initial Observation</label>
                        <div class="div-data">
                            @if ($data->initial_observation)
                                {{ $data->initial_observation }}
                            @else
                                Not Applicable
                            @endif
                        </div>

                        <table>
                            <tr>
                                <th class="w-20">Interim Containnment</th>
                                <td class="w-80">
                                    @if ($data->interim_containnment)
                                        {{ $data->interim_containnment }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                            </tr>
                        </table>

                        <label class="head-number" for="Containment Comments">Containment Comments</label>
                        <div class="div-data">
                            @if ($data->containment_comments)
                                {{ $data->containment_comments }}
                            @else
                                Not Applicable
                            @endif
                        </div>

                        <div class="block-head">
                            Capa Attachement
                        </div>
                        <div class="border-table">
                            <table>
                                <tr class="table_bg">
                                    <th class="w-20">S.N.</th>
                                    <th class="w-60">File </th>
                                </tr>
                                @if ($data->capa_attachment)
                                    @foreach (json_decode($data->capa_attachment) as $key => $file)
                                        <tr>
                                            <td class="w-20">{{ $key + 1 }}</td>
                                            <td class="w-20"><a href="{{ asset('upload/' . $file) }}"
                                                    target="_blank"><b>{{ $file }}</b></a> </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td class="w-20">1</td>
                                        <td class="w-20">Not Applicable</td>
                                    </tr>
                                @endif

                            </table>
                        </div>

                        <label class="head-number" for="Investigation">Investigation</label>
                        <div class="div-data">
                            @if ($data->investigation)
                                {{ $data->investigation }}
                            @else
                                Not Applicable
                            @endif
                        </div>

                        <label class="head-number" for="Root Cause Analysis">Root Cause Analysis</label>
                        <div class="div-data">
                            @if ($data->rcadetails)
                                {{ $data->rcadetails }}
                            @else
                                Not Applicable
                            @endif
                        </div>

                    </div>

                    <div class="block">
                        <div class="block-head">
                            Equipment/Material Info
                        </div>
                        <table>
                            <tr>
                                <th class="w-20">Severity Level</th>
                                <td class="w-80">
                                    @if ($data->severity_level_form)
                                        {{ $data->severity_level_form }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="block">
                        <div class="block-head">
                            Other type CAPA Details
                        </div>
                        <table>
                            <tr>
                                <th class="w-20">Details</th>
                                <td class="w-80">
                                    @if ($data->details_new)
                                        {{ $data->details_new }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>

                    {{-- <div class="block">
                        <div class="block-head">
                        Product Material Details
                        </div>
                        <div class="border-table">
                            <table>
                                <tr class="table_bg">
                                <th class="w-20">SR no.</th>
                                    <th class="w-20">Product Material Name</th>
                                    <th class="w-20">Product Batch Number</th>
                                    <th class="w-20">Product Date Of Manufacturing</th>
                                    <th class="w-20">Product Date Of Expiry</th>
                                    <th class="w-20">Product Batch Disposition</th>
                                    <th class="w-20">Product Remark</th>
                                    <th class="w-20">Product Batch Status</th>
                                </tr>
                                @if ($data->Material_Details->material_name)
                                @foreach (unserialize($data->Material_Details->material_name) as $key => $dataDemo)
                                <tr>
                                    <td class="w-15">{{ $dataDemo ? $key + 1  : "Not Applicable" }}</td>
                                    <td class="w-15">{{ unserialize($data->Material_Details->material_name)[$key] ?  unserialize($data->Material_Details->material_name)[$key]: "Not Applicable"}}</td>
                                    <td class="w-15">{{unserialize($data->Material_Details->material_batch_no)[$key] ?  unserialize($data->Material_Details->material_batch_no)[$key] : "Not Applicable" }}</td>
                                    <td class="w-5">{{unserialize($data->Material_Details->material_mfg_date)[$key] ?  unserialize($data->Material_Details->material_mfg_date)[$key] : "Not Applicable" }}</td>
                                    <td class="w-15">{{unserialize($data->Material_Details->material_expiry_date)[$key] ?  unserialize($data->Material_Details->material_expiry_date)[$key] : "Not Applicable" }}</td>
                                    <td class="w-15">{{unserialize($data->Material_Details->material_batch_desposition)[$key] ?  unserialize($data->Material_Details->material_batch_desposition)[$key] : "Not Applicable" }}</td>
                                    <td class="w-15">{{unserialize($data->Material_Details->material_remark)[$key] ?  unserialize($data->Material_Details->material_remark)[$key] : "Not Applicable" }}</td>
                                    <td class="w-15">{{unserialize($data->Material_Details->material_batch_status)[$key] ?  unserialize($data->Material_Details->material_batch_status)[$key] : "Not Applicable" }}</td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td>Not Applicable</td>
                                    <td>Not Applicable</td>
                                    <td>Not Applicable</td>
                                    <td>Not Applicable</td>
                                    <td>Not Applicable</td>
                                    <td>Not Applicable</td>
                                    <td>Not Applicable</td>
                                    <td>Not Applicable</td>
                                </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                    <div class="block">
                        <div class="block-head">
                            Equipment/Instruments Details
                        </div>
                        <div>
                            <table>
                                <tr class="table_bg">
                                    <th class="w-25">SR no.</th>
                                    <th class="w-25">Equipment/Instruments Name</th>
                                    <th class="w-25">Equipment/Instruments ID</th>
                                    <th class="w-25">Equipment/Instruments Comments</th>
                                </tr>
                                @if ($data->Instruments_Details->equipment)
                                @foreach (unserialize($data->Instruments_Details->equipment) as $key => $dataDemo)
                                <tr>
                                    <td class="w-15">{{ $dataDemo ? $key +1  : "Not Applicable" }}</td>

                                    <td class="w-15">{{ $dataDemo ? $dataDemo : "Not Applicable"}}</td>
                                    <td class="w-15">{{unserialize($data->Instruments_Details->equipment_instruments)[$key] ?  unserialize($data->Instruments_Details->equipment_instruments)[$key] : "Not Applicable" }}</td>
                                    <td class="w-15">{{unserialize($data->Instruments_Details->equipment_comments)[$key] ?  unserialize($data->Instruments_Details->equipment_comments)[$key] : "Not Applicable" }}</td>

                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td>Not Applicable</td>
                                    <td>Not Applicable</td>
                                    <td>Not Applicable</td>
                                    <td>Not Applicable</td>

                                @endif
                            </table>
                        </div>
                    </div> --}}




                    <div class="block">
                        <div class="block-head">
                            CAPA Details
                        </div>
                        <table>
                            <tr>
                                <th class="w-20">CAPA Type</th>
                                <td class="w-80">
                                    @if ($data->capa_type)
                                        {{ $data->capa_type }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                            </tr>
                        </table>

                        <label class="head-number" for="Corrective Action">Corrective Action</label>
                        <div class="div-data">
                            @if ($data->corrective_action)
                                {{ $data->corrective_action }}
                            @else
                                Not Applicable
                            @endif
                        </div>

                        <label class="head-number" for="Preventive Action">Preventive Action</label>
                        <div class="div-data">
                            @if ($data->preventive_action)
                                {{ $data->preventive_action }}
                            @else
                                Not Applicable
                            @endif
                        </div>

                        <div class="block-head">
                            File Attachment
                        </div>
                        <div class="border-table">
                            <table>
                                <tr class="table_bg">
                                    <th class="w-20">S.N.</th>
                                    <th class="w-60">File </th>
                                </tr>
                                @if ($data->capafileattachement)
                                    @foreach (json_decode($data->capafileattachement) as $key => $file)
                                        <tr>
                                            <td class="w-20">{{ $key + 1 }}</td>
                                            <td class="w-20"><a href="{{ asset('upload/' . $file) }}"
                                                    target="_blank"><b>{{ $file }}</b></a> </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td class="w-20">1</td>
                                        <td class="w-20">Not Applicable</td>
                                    </tr>
                                @endif

                            </table>
                        </div>
                    </div>


                    <div class="block">
                        <div class="block-head">
                            HOD Review
                        </div>
                        <div>
                            <table>
                                <tr>
                                    <th class="w-20">HOD Remark</th>
                                    <td class="w-80">
                                        @if ($data->hod_remarks)
                                            {{ $data->hod_remarks }}
                                        @else
                                            Not Applicable
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div class="block-head">
                            HOD Review Attachement
                        </div>
                        <div class="border-table">
                            <table>
                                <tr class="table_bg">
                                    <th class="w-20">S.N.</th>
                                    <th class="w-60">File </th>
                                </tr>
                                @if ($data->hod_attachment)
                                    @foreach (json_decode($data->hod_attachment) as $key => $file)
                                        <tr>
                                            <td class="w-20">{{ $key + 1 }}</td>
                                            <td class="w-20"><a href="{{ asset('upload/' . $file) }}"
                                                    target="_blank"><b>{{ $file }}</b></a> </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td class="w-20">1</td>
                                        <td class="w-20">Not Applicable</td>
                                    </tr>
                                @endif

                            </table>
                        </div>
                    </div>


                    <div class="block">
                        <div class="block-head">
                            QA Review
                        </div>
                        <div>
                            <table>
                                <tr>
                                    <th class="w-20">CAPA QA Review</th>
                                    <td class="w-80">
                                        @if ($data->capa_qa_comments)
                                            {{ $data->capa_qa_comments }}
                                        @else
                                            Not Applicable
                                        @endif
                                    </td>
                                </tr>
                            </table>

                            <div class="block-head">
                                QA Attachment
                            </div>
                            <div class="border-table">
                                <table>
                                    <tr class="table_bg">
                                        <th class="w-20">S.N.</th>
                                        <th class="w-60">File </th>
                                    </tr>
                                    @if ($data->qa_attachment)
                                        @foreach (json_decode($data->qa_attachment) as $key => $file)
                                            <tr>
                                                <td class="w-20">{{ $key + 1 }}</td>
                                                <td class="w-20"><a href="{{ asset('upload/' . $file) }}"
                                                        target="_blank"><b>{{ $file }}</b></a> </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td class="w-20">1</td>
                                            <td class="w-20">Not Applicable</td>
                                        </tr>
                                    @endif

                                </table>
                            </div>
                        </div>
                    </div>


                    <br>
                    <div class="block">
                        <div class="block-head">
                            CAPA Closure
                        </div>
                        <table>
                            <tr>
                                <th class="w-20">
                                    QA Head Review & Closure
                                </th>
                                <td class="w-80">
                                    @if ($data->qa_review)
                                        {{ $data->qa_review }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th class="w-20">Due Date Extension Justification</th>
                                <td class="w-80">
                                    @if ($data->due_date_extension)
                                        {{ $data->due_date_extension }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                            </tr>
                        </table>

                        <div class="block-head">
                            Closure Attachment
                        </div>
                        <div class="border-table">
                            <table>
                                <tr class="table_bg">
                                    <th class="w-20">S.N.</th>
                                    <th class="w-60">File </th>
                                </tr>
                                @if ($data->closure_attachment)
                                    @foreach (json_decode($data->closure_attachment) as $key => $file)
                                        <tr>
                                            <td class="w-20">{{ $key + 1 }}</td>
                                            <td class="w-20"><a href="{{ asset('upload/' . $file) }}"
                                                    target="_blank"><b>{{ $file }}</b></a> </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td class="w-20">1</td>
                                        <td class="w-20">Not Applicable</td>
                                    </tr>
                                @endif

                            </table>
                        </div>
                    </div>

                    <div class="block">

                        <div class="block-head">
                            HOD Final Review
                        </div>
                        <div>
                            <table>
                                <tr>
                                    <th class="w-20">HOD Final Review Comment</th>
                                    <td class="w-80">
                                        @if ($data->hod_final_review)
                                            {{ $data->hod_final_review }}
                                        @else
                                            Not Applicable
                                        @endif
                                    </td>
                                </tr>
                            </table>
                            <div class="block-head">
                                HOD Final Review Attachment
                            </div>
                            <div class="border-table">
                                <table>
                                    <tr class="table_bg">
                                        <th class="w-20">S.N.</th>
                                        <th class="w-60">File </th>
                                    </tr>
                                    @if ($data->hod_final_attachment)
                                        @foreach (json_decode($data->hod_final_attachment) as $key => $file)
                                            <tr>
                                                <td class="w-20">{{ $key + 1 }}</td>
                                                <td class="w-20"><a href="{{ asset('upload/' . $file) }}"
                                                        target="_blank"><b>{{ $file }}</b></a> </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td class="w-20">1</td>
                                            <td class="w-20">Not Applicable</td>
                                        </tr>
                                    @endif

                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="block">
                        <div class="block-head">
                            QA/CQA Closure Review
                        </div>
                        <div>
                            <table>
                                <tr>
                                    <th class="w-20">QA/CQA Closure Review Comment</th>
                                    <td class="w-80">
                                        @if ($data->qa_cqa_qa_comments)
                                            {{ $data->qa_cqa_qa_comments }}
                                        @else
                                            Not Applicable
                                        @endif
                                    </td>
                                </tr>
                            </table>

                            <div class="block-head">
                                QA/CQA Closure Review Attachment
                            </div>
                            <div class="border-table">
                                <table>
                                    <tr class="table_bg">
                                        <th class="w-20">S.N.</th>
                                        <th class="w-60">File </th>
                                    </tr>
                                    @if ($data->qa_closure_attachment)
                                        @foreach (json_decode($data->qa_closure_attachment) as $key => $file)
                                            <tr>
                                                <td class="w-20">{{ $key + 1 }}</td>
                                                <td class="w-20"><a href="{{ asset('upload/' . $file) }}"
                                                        target="_blank"><b>{{ $file }}</b></a> </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td class="w-20">1</td>
                                            <td class="w-20">Not Applicable</td>
                                        </tr>
                                    @endif

                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="block">
                        <div class="block-head">
                            QAH/CQAH Approval
                        </div>
                        <div>
                            <table>
                                <tr>
                                    <th class="w-20">QAH/CQAH Approval Comment</th>
                                    <td class="w-80">
                                        @if ($data->qah_cq_comments)
                                            {{ $data->qah_cq_comments }}
                                        @else
                                            Not Applicable
                                        @endif
                                    </td>
                                </tr>
                            </table>

                            <div class="block-head">
                                QAH/CQAH Approval Attachment
                            </div>
                            <div class="border-table">
                                <table>
                                    <tr class="table_bg">
                                        <th class="w-20">S.N.</th>
                                        <th class="w-60">File </th>
                                    </tr>
                                    @if ($data->qah_cq_attachment)
                                        @foreach (json_decode($data->qah_cq_attachment) as $key => $file)
                                            <tr>
                                                <td class="w-20">{{ $key + 1 }}</td>
                                                <td class="w-20"><a href="{{ asset('upload/' . $file) }}"
                                                        target="_blank"><b>{{ $file }}</b></a> </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td class="w-20">1</td>
                                            <td class="w-20">Not Applicable</td>
                                        </tr>
                                    @endif

                                </table>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="block">
                    <div class="block-head">
                        Activity Log
                    </div>
                    <table>
                        <tr>
                            <th class="w-20">Propose Plan By</th>
                            <td class="w-30">{{ $data->plan_proposed_by }}</td>

                            <th class="w-20">Propose Plan On</th>
                            <td class="w-30">{{ $data->plan_proposed_on }}</td>
                        </tr>

                        <tr>
                            <th class="w-20">Comment</th>
                            <td class="w-80">{{ $data->comment }}</td>
                        </tr>

                        <tr>
                            <th class="w-20">QA/CQA Review Completed By</th>
                            <td class="w-30">{{ $data->qa_review_completed_by }}</td>

                            <th class="w-20">QA/CQA Review Completed On</th>
                            <td class="w-30">{{ $data->qa_review_completed_on }}</td>
                        </tr>

                        <tr>
                            <th class="w-20">Comment</th>
                            <td class="w-80">{{ $data->qa_comment }}</td>
                        </tr>

                        <tr>
                            <th class="w-20">HOD Review Completed By</th>
                            <td class="w-30">{{ $data->hod_review_completed_by }}</td>

                            <th class="w-20">HOD Review Completed On</th>
                            <td class="w-30">{{ $data->hod_review_completed_on }}</td>
                        </tr>

                        <tr>
                            <th class="w-20">Comment</th>
                            <td class="w-80">{{ $data->hod_comment }}</td>
                        </tr>

                        <tr>
                            <th class="w-20">Cancelled By</th>
                            <td class="w-30">{{ $data->cancelled_by }}</td>

                            <th class="w-20">Cancelled On</th>
                            <td class="w-30">{{ $data->cancelled_on }}</td>
                        </tr>

                        <tr>
                            <th class="w-20">Comment</th>
                            <td class="w-80">{{ $data->cancelled_on_comment }}</td>
                        </tr>

                        <tr>
                            <th class="w-20">Completed By</th>
                            <td class="w-30">{{ $data->completed_by }}</td>

                            <th class="w-20">Completed On</th>
                            <td class="w-30">{{ $data->completed_on }}</td>
                        </tr>

                        <tr>
                            <th class="w-20">Comment</th>
                            <td class="w-80">{{ $data->comment }}</td>
                        </tr>

                        <tr>
                            <th class="w-20">Approved By</th>
                            <td class="w-30">{{ $data->approved_by }}</td>

                            <th class="w-20">Approved On</th>
                            <td class="w-30">{{ $data->approved_on }}</td>
                        </tr>

                        <tr>
                            <th class="w-20">Comment</th>
                            <td class="w-80">{{ $data->approved_comment }}</td>
                        </tr>

                        <tr>
                            <th class="w-20">Completed By</th>
                            <td class="w-30">{{ $data->completed_by }}</td>

                            <th class="w-20">Completed On</th>
                            <td class="w-30">{{ $data->completed_on }}</td>
                        </tr>

                        <tr>
                            <th class="w-20">Comment</th>
                            <td class="w-80">{{ $data->com_comment }}</td>
                        </tr>

                        <tr>
                            <th class="w-20">HOD Final Review Completed By</th>
                            <td class="w-30">{{ $data->hod_final_review_completed_by }}</td>

                            <th class="w-20">HOD Final Review Completed On</th>
                            <td class="w-30">{{ $data->hod_final_review_completed_on }}</td>
                        </tr>

                        <tr>
                            <th class="w-20">Comment</th>
                            <td class="w-80">{{ $data->final_comment }}</td>
                        </tr>

                        <tr>
                            <th class="w-20">QA/CQA Closure Review Completed By</th>
                            <td class="w-30">{{ $data->qa_closure_review_completed_by }}</td>

                            <th class="w-20">QA/CQA Closure Review Completed On</th>
                            <td class="w-30">{{ $data->qa_closure_review_completed_on }}</td>
                        </tr>

                        <tr>
                            <th class="w-20">Comment</th>
                            <td class="w-80">{{ $data->qa_closure_comment }}</td>
                        </tr>

                        <tr>
                            <th class="w-20">QA/CQA Approval Completed By</th>
                            <td class="w-30">{{ $data->qah_approval_completed_by }}</td>

                            <th class="w-20">QA/CQA Approval Completed On</th>
                            <td class="w-30">{{ $data->qah_approval_completed_on }}</td>

                            <th class="w-20">Comment</th>
                            <td class="w-30">{{ $data->qah_comment }}</td>
                        </tr>

                    </table>
                </div>
            </div>

        @endforeach
    @endif

    @if (count($ActionItem) > 0)
        @foreach ($ActionItem as $data)
            <center>
                <h3>Action Item Report</h3>
            </center>

            <div class="inner-block">
                <div class="content-table">
                    <div class="block">
                        <div class="block-head">
                            General Information
                        </div>
                        <table>
                            <tr>
                                <th class="w-20">Record Number</th>
                                <td class="w-30">
                                    @if ($data->record)
                                        {{ Helpers::divisionNameForQMS($data->division_id) }}/AI/{{ Helpers::year($data->created_at) }}/{{ str_pad($data->record, 4, '0', STR_PAD_LEFT) }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                                <th class="w-20">Division Code</th>
                                <td class="w-30">
                                    @if ($data->division_id)
                                        {{ Helpers::getDivisionName($data->division_id) }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                            </tr>

                            <tr> {{ $data->created_at }} added by {{ $data->originator }}
                                <th class="w-20">Initiator</th>
                                <td class="w-30">{{ Helpers::getInitiatorName($data->initiator_id) }}</td>
                                <th class="w-20">Date of Initiation</th>
                                <td class="w-30">{{ Helpers::getdateFormat($data->created_at) }}</td>
                            </tr>

                            <tr>
                                <th class="w-20">Parent Record Number</th>
                                <td class="w-30">
                                    @if ($data->parent_record_number)
                                        {{ $data->parent_record_number }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                                <th class="w-20">Assigned To</th>
                                <td class="w-30">
                                    @if ($data->assign_to)
                                        {{ Helpers::getInitiatorName($data->assign_to) }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                            </tr>


                            <tr>
                                <th class="w-20">Due Date</th>
                                <td class="w-30">
                                    @if ($data->due_date)
                                        {{ Helpers::getdateFormat($data->due_date) }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                            </tr>
                        </table>

                        <label class="head-number" for="Short Description">Short Description</label>
                        <div class="div-data">
                            @if ($data->short_description)
                                {{ $data->short_description }}
                            @else
                                Not Applicable
                            @endif
                        </div>

                        <label class="head-number" for="Action Item Related Records">Action Item Related
                            Records</label>
                        <div class="div-data">
                            @if ($data->Reference_Recores1)
                                {{ str_replace(',', ', ', $data->Reference_Recores1) }}
                            @else
                                Not Applicable
                            @endif
                        </div>

                        <table>
                            <tr>
                                <th class="w-20">HOD Persons</th>
                                <td class="w-80">
                                    @if ($data->hod_preson)
                                        {{ $data->hod_preson }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                            </tr>
                        </table>

                        <table>
                            <tr>
                                <th class="w-20">Responsible Department</th>
                                <td class="w-80">
                                    @if ($data->departments)
                                        {{ $data->departments }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                            </tr>
                        </table>

                        <label class="head-number" for="Description">Description</label>
                        <div class="div-data">
                            @if ($data->description)
                                {{ $data->description }}
                            @else
                                Not Applicable
                            @endif
                        </div>

                        <div class="block-head">
                            File Attachments
                        </div>
                        <div class="border-table">
                            <table>
                                <tr class="table_bg">
                                    <th class="w-20">S.N.</th>
                                    <th class="w-60">File</th>
                                </tr>
                                @if ($data->file_attach)
                                    @php $files = json_decode($data->file_attach); @endphp
                                    @if (count($files) > 0)
                                        @foreach ($files as $key => $file)
                                            <tr>
                                                <td class="w-20">{{ $key + 1 }}</td>
                                                <td class="w-60"><a href="{{ asset('upload/' . $file) }}"
                                                        target="_blank"><b>{{ $file }}</b></a></td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td class="w-20">1</td>
                                            <td class="w-60">Not Applicable</td>
                                        </tr>
                                    @endif
                                @else
                                    <tr>
                                        <td class="w-20">1</td>
                                        <td class="w-60">Not Applicable</td>
                                    </tr>
                                @endif
                            </table>
                        </div>

                    </div>

                    <div class="block">
                        <div class="block-head">
                            Post Completion
                        </div>

                        <label class="head-number" for="Action Taken">Action Taken</label>
                        <div class="div-data">
                            @if ($data->action_taken)
                                {{ $data->action_taken }}
                            @else
                                Not Applicable
                            @endif
                        </div>
                        <table>
                            <tr>
                                <th class="w-20">Action Start Date</th>
                                <td class="w-30">
                                    @if ($data->start_date)
                                        {{ Helpers::getdateFormat($data->start_date) }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                                <th class="w-20">Actual End Date</th>
                                <td class="w-30">
                                    @if ($data->end_date)
                                        {{ Helpers::getdateFormat($data->end_date) }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                            </tr>
                        </table>

                        <label class="head-number" for="Comments">Comments</label>
                        <div class="div-data">
                            @if ($data->comments)
                                {{ $data->comments }}
                            @else
                                Not Applicable
                            @endif
                        </div>


                        <div class="block-head">
                            Completion Attachments
                        </div>
                        <div class="border-table">
                            <table>
                                <tr class="table_bg">
                                    <th class="w-20">S.N.</th>
                                    <th class="w-60">File</th>
                                </tr>
                                @if ($data->Support_doc)
                                    @php $files = json_decode($data->Support_doc); @endphp
                                    @if (count($files) > 0)
                                        @foreach ($files as $key => $file)
                                            <tr>
                                                <td class="w-20">{{ $key + 1 }}</td>
                                                <td class="w-60"><a href="{{ asset('upload/' . $file) }}"
                                                        target="_blank"><b>{{ $file }}</b></a></td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td class="w-20">1</td>
                                            <td class="w-60">Not Applicable</td>
                                        </tr>
                                    @endif
                                @else
                                    <tr>
                                        <td class="w-20">1</td>
                                        <td class="w-60">Not Applicable</td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                    </div>

                    <div class="block">
                        <div class="block-head">
                            Action Approval
                        </div>

                        <label class="head-number" for="QA Review Comments">QA Review Comments</label>
                        <div class="div-data">
                            @if ($data->qa_comments)
                                {{ $data->qa_comments }}
                            @else
                                Not Applicable
                            @endif
                        </div>

                    </div>

                    <div class="block">
                        <div class="block-head">
                            Extension Justification
                        </div>
                        <table>
                            <tr>
                                <th class="w-20">Due Date Extension Justification</th>
                                <td class="w-80">
                                    @if ($data->due_date_extension)
                                        {{ $data->due_date_extension }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                            </tr>
                        </table>

                        <div class="block-head">
                            Action Approval Attachment
                        </div>
                        <div class="border-table">
                            <table>
                                <tr class="table_bg">
                                    <th class="w-20">S.N.</th>
                                    <th class="w-60">File</th>
                                </tr>
                                @if ($data->final_attach)
                                    @php $files = json_decode($data->final_attach); @endphp
                                    @if (count($files) > 0)
                                        @foreach ($files as $key => $file)
                                            <tr>
                                                <td class="w-20">{{ $key + 1 }}</td>
                                                <td class="w-60"><a href="{{ asset('upload/' . $file) }}"
                                                        target="_blank"><b>{{ $file }}</b></a></td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td class="w-20">1</td>
                                            <td class="w-60">Not Applicable</td>
                                        </tr>
                                    @endif
                                @else
                                    <tr>
                                        <td class="w-20">1</td>
                                        <td class="w-60">Not Applicable</td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                    </div>

                    <div class="block" style="margin-top: 15px;">
                        <div class="block-head">
                            Activity Log
                        </div>
                        <table>
                            <tr>
                                <th class="w-20">Submitted By</th>
                                <td class="w-80">{{ $data->submitted_by }}</td>
                                <th class="w-20">Submitted On</th>
                                <td class="w-80">{{ $data->submitted_on }}</td>
                            </tr>

                            <tr>
                                <th class="w-20">Comment</th>
                                <td class="w-80">{{ $data->submitted_comment }}</td>
                            </tr>

                            <tr>
                                <th class="w-20">Cancelled By</th>
                                <td class="w-80">{{ $data->cancelled_by }}</td>
                                <th class="w-20">Cancelled On</th>
                                <td class="w-80">{{ $data->cancelled_on }}</td>
                            </tr>

                            <tr>
                                <th class="w-20">Comment</th>
                                <td class="w-80">{{ $data->cancelled_comment }}</td>
                            </tr>

                            <tr>
                                <th class="w-20">Acknowledge By</th>
                                <td class="w-80">{{ $data->acknowledgement_by }}</td>
                                <th class="w-20">Acknowledge On</th>
                                <td class="w-80">{{ $data->acknowledgement_on }}</td>
                            </tr>

                            <tr>
                                <th class="w-20">Comment</th>
                                <td class="w-80">{{ $data->acknowledgement_comment }}</td>
                            </tr>

                            <tr>
                                <th class="w-20">Work Completion By</th>
                                <td class="w-80">{{ $data->work_completion_by }}</td>
                                <th class="w-20">Work Completion On</th>
                                <td class="w-80">{{ $data->work_completion_on }}</td>
                            </tr>

                            <tr>
                                <th class="w-20">Comment</th>
                                <td class="w-80">{{ $data->work_completion_comment }}</td>
                            </tr>

                            <tr>
                                <th class="w-20">QA/CQA Verification By</th>
                                <td class="w-80">{{ $data->qa_varification_by }}</td>
                                <th class="w-20">QA/CQA Verification On</th>
                                <td class="w-80">{{ $data->qa_varification_on }}</td>
                            </tr>

                            <tr>
                                <th class="w-20">Comment</th>
                                <td class="w-80">{{ $data->qa_varification_comment }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        @endforeach
    @endif

    @if (count($EffectivenessCheck) > 0)
        @foreach ($EffectivenessCheck as $data)
            <center>
                <h3>Effectiveness Check Report</h3>
            </center>

            <div class="inner-block">
                <div class="content-table">
                    <div class="block">
                        <div class="block-head">
                            General Information
                        </div>
                        <table>
                            <tr>
                                <th class="w-20">Record Number</th>
                                <td class="w-30">
                                    @if ($data->record)
                                        {{ Helpers::divisionNameForQMS($data->division_id) }}/EC/{{ Helpers::year($data->created_at) }}/{{ str_pad($data->record, 4, '0', STR_PAD_LEFT) }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                                <th class="w-20">Site/Location Code</th>
                                <td class="w-30">
                                    @if ($data->division_id)
                                        {{ Helpers::getDivisionName($data->division_id) }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                            </tr>

                            <tr> {{ $data->created_at }} added by {{ $data->originator }}
                                <th class="w-20">Initiator</th>
                                <td class="w-30">{{ Helpers::getInitiatorName($data->initiator_id) }}</td>
                                <th class="w-20">Date of Initiation</th>
                                <td class="w-30">{{ Helpers::getdateFormat($data->created_at) }}</td>
                            </tr>

                            <tr>
                                <th class="w-20">Assigned To</th>
                                <td class="w-30">
                                    @if ($data->assign_to)
                                        {{ $data->assign_to }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                                <th class="w-20">Due Date</th>
                                <td class="w-80">
                                    @if ($data->due_date)
                                        {{ Helpers::getdateFormat($data->due_date) }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>

                            </tr>
                            <tr>
                                <th class="w-20">Short Description</th>
                                <td class="w-80">
                                    @if ($data->short_description)
                                        {{ $data->short_description }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                            </tr>
                        </table>

                        <div class="block-head">
                            Effectiveness Planning Information
                        </div>
                        <table>

                            <tr>
                                <th class="w-20">Effectiveness check Plan</th>
                                <td class="w-80">
                                    @if ($data->Effectiveness_check_Plan)
                                        {{ $data->Effectiveness_check_Plan }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                            </tr>
                        </table>
                        <div class="block-head">
                            Attachments
                        </div>
                        <div class="border-table">
                            <table>
                                <tr class="table_bg">
                                    <th class="w-20">S.N.</th>
                                    <th class="w-60">File </th>
                                </tr>
                                @if ($data->Attachments)
                                    @foreach (json_decode($data->Attachments) as $key => $file)
                                        <tr>
                                            <td class="w-20">{{ $key + 1 }}</td>
                                            <td class="w-20"><a href="{{ asset('upload/' . $file) }}"
                                                    target="_blank"><b>{{ $file }}</b></a> </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td class="w-20">1</td>
                                        <td class="w-20">Not Applicable</td>
                                    </tr>
                                @endif

                            </table>
                        </div>
                        </table>
                    </div>


                    <div class="block-head">
                        Effectiveness Summary
                    </div>
                    <table>
                        <tr>
                            <th class="w-20">Effectiveness Summary</th>
                            <td class="w-80">
                                @if ($data->effect_summary)
                                    {{ $data->effect_summary }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>
                    </table>
                    <div class="block-head">
                        Effectiveness Check Results
                    </div>
                    <table>
                        <tr>
                            <th class="w-20">Effectiveness Results</th>
                            <td class="w-80">
                                @if ($data->Effectiveness_Results)
                                    {{ $data->Effectiveness_Results }}
                                @else
                                    Not Applicable
                                @endif
                            </td>

                        </tr>
                    </table>
                    <div class="block-head">
                        Attachments
                    </div>
                    <div class="border-table">
                        <table>
                            <tr class="table_bg">
                                <th class="w-20">S.N.</th>
                                <th class="w-60">File </th>
                            </tr>
                            @if ($data->Attachments)
                                @foreach (json_decode($data->Attachments) as $key => $file)
                                    <tr>
                                        <td class="w-20">{{ $key + 1 }}</td>
                                        <td class="w-20"><a href="{{ asset('upload/' . $file) }}"
                                                target="_blank"><b>{{ $file }}</b></a> </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td class="w-20">1</td>
                                    <td class="w-20">Not Applicable</td>
                                </tr>
                            @endif

                        </table>
                    </div>

                    {{-- <div class="block-head">
                               Reopen
                            </div> --}}
                    {{-- <table>
                             <tr>
                                <th class="w-20">Addendum Comments</th>
                                <td class="w-80">@if ($data->Addendum_Comments){{ $data->Addendum_Comments }}@else Not Applicable @endif</td>
                               
                              </tr>
                          </table> --}}
                    {{-- <div class="block-head">
                            Addendum Attachment
                            </div>
                              <div class="border-table">
                                <table>
                                    <tr class="table_bg">
                                        <th class="w-20">S.N.</th>
                                        <th class="w-60">File </th>
                                    </tr>
                                        @if ($data->Addendum_Attachment)
                                        @foreach (json_decode($data->Addendum_Attachment) as $key => $file)
                                            <tr>
                                                <td class="w-20">{{ $key + 1 }}</td>
                                                <td class="w-20"><a href="{{ asset('upload/' . $file) }}" target="_blank"><b>{{ $file }}</b></a> </td>
                                            </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td class="w-20">1</td>
                                            <td class="w-20">Not Applicable</td>
                                        </tr>
                                    @endif
        
                                </table>
                              </div> --}}

                    <div class="block-head">
                        Reference Info comments
                    </div>
                    <table>
                        <tr>
                            <th class="w-20">Comments</th>
                            <td class="w-80">
                                @if ($data->Comments)
                                    {{ $data->Comments }}
                                @else
                                    Not Applicable
                                @endif
                            </td>

                        </tr>
                    </table>
                    <div class="block-head">
                        Attachment
                    </div>
                    <div class="border-table">
                        <table>
                            <tr class="table_bg">
                                <th class="w-20">S.N.</th>
                                <th class="w-60">File </th>
                            </tr>
                            @if ($data->Attachment)
                                @foreach (json_decode($data->Attachment) as $key => $file)
                                    <tr>
                                        <td class="w-20">{{ $key + 1 }}</td>
                                        <td class="w-20"><a href="{{ asset('upload/' . $file) }}"
                                                target="_blank"><b>{{ $file }}</b></a> </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td class="w-20">1</td>
                                    <td class="w-20">Not Applicable</td>
                                </tr>
                            @endif

                        </table>
                    </div>
                    {{-- <div class="block-head">
                              Reference Records
                            </div>
                              <div class="border-table">
                                <table>
                                    <tr class="table_bg">
                                        <th class="w-20">S.N.</th>
                                        <th class="w-60">File </th>
                                    </tr>
                                        @if ($data->refer_record)
                                        @foreach (json_decode($data->refer_record) as $key => $file)
                                            <tr>
                                                <td class="w-20">{{ $key + 1 }}</td>
                                                <td class="w-20"><a href="{{ asset('upload/' . $file) }}" target="_blank"><b>{{ $file }}</b></a> </td>
                                            </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td class="w-20">1</td>
                                            <td class="w-20">Not Applicable</td>
                                        </tr>
                                    @endif
        
                                </table>
                              </div> --}}
                    <div class="block">
                        <div class="block-head">
                            Activity Log
                        </div>
                        <table>
                            <tr>
                                <th class="w-20">Submit by
                                </th>
                                <td class="w-30">{{ $data->submit_by }}</td>
                                <th class="w-20">
                                    Submit On</th>
                                <td class="w-30">{{ $data->submit_on }}</td>
                                <th class="w-20">
                                    Submit Comment</th>
                                <td class="w-30">{{ $data->submit_comment }}</td>
                            </tr>
                            <tr>
                                <th class="w-20">Acknowledge Complete by
                                </th>
                                <td class="w-30">{{ $data->work_complition_by }}</td>
                                <th class="w-20">
                                    Acknowledge Complete On</th>
                                <td class="w-30">{{ $data->work_complition_on }}</td>
                                <th class="w-20">
                                    Acknowledge Complete Comment</th>
                                <td class="w-30">{{ $data->work_complition_comment }}</td>
                            </tr>
                            <tr>
                                <th class="w-20"> Complete By
                                </th>
                                <td class="w-30">{{ $data->effectiveness_check_complete_by }}</td>
                                <th class="w-20">
                                    Complete On</th>
                                <td class="w-30">{{ $data->effectiveness_check_complete_on }}</td>
                                <th class="w-20">
                                    Complete Comment</th>
                                <td class="w-30">{{ $data->effectiveness_check_complete_comment }}</td>
                            </tr>
                            <tr>
                                <th class="w-20">HOD Review Complete By
                                </th>
                                <td class="w-30">{{ $data->hod_review_complete_by }}</td>
                                <th class="w-20">
                                    HOD Review Complete On</th>
                                <td class="w-30">{{ $data->hod_review_complete_on }}</td>
                                <th class="w-20">
                                    HOD Review Complete Comment</th>
                                <td class="w-30">{{ $data->hod_review_complete_comment }}</td>
                            </tr>
                            <tr>
                                <th class="w-20">Not Effective By
                                </th>
                                <td class="w-30">{{ $data->qa_review_complete_by }}</td>
                                <th class="w-20">
                                    Not Effective On</th>
                                <td class="w-30">{{ $data->qa_review_complete_on }}</td>
                                <th class="w-20">
                                    Not Effective Comment</th>
                                <td class="w-30">{{ $data->qa_review_complete_comment }}</td>
                            </tr>
                            <tr>
                                <th class="w-20">Not Effective Approval Complete By
                                </th>
                                <td class="w-30">{{ $data->not_effective_approval_complete_by }}</td>
                                <th class="w-20">
                                    Not Effective Approval Complete On</th>
                                <td class="w-30">{{ $data->not_effective_approval_complete_on }}</td>
                                <th class="w-20">
                                    Not Effective Approval Complete Comment</th>
                                <td class="w-30">{{ $data->not_effective_approval_complete_comment }}</td>
                            </tr>
                            <tr>
                                <th class="w-20">Effective by
                                </th>
                                <td class="w-30">{{ $data->effective_by }}</td>
                                <th class="w-20">
                                    Effective On</th>
                                <td class="w-30">{{ $data->effective_on }}</td>
                                <th class="w-20">
                                    Effective Comment</th>
                                <td class="w-30">{{ $data->effective_comment }}</td>
                            </tr>

                            <tr>
                                <th class="w-20">Effective Approval Complete By
                                </th>
                                <td class="w-30">{{ $data->effective_approval_complete_by }}</td>
                                <th class="w-20">
                                    Effective Approval Complete On</th>
                                <td class="w-30">{{ $data->effective_approval_complete_on }}</td>
                                <th class="w-20">
                                    Effective Approval Complete Comment</th>
                                <td class="w-30">{{ $data->effective_approval_complete_comment }}</td>
                            </tr>



                            <tr>
                                <th class="w-20">Cancel By
                                </th>
                                <td class="w-30">{{ $data->closed_cancelled_by }}</td>
                                <th class="w-20">
                                    Cancel On</th>
                                <td class="w-30">{{ $data->closed_cancelled_on }}</td>
                                <th class="w-20">
                                    Cancel Comment</th>
                                <td class="w-30">{{ $data->closed_cancelled_comment }}</td>
                            </tr>

                        </table>
                    </div>
                </div>
            </div>
        @endforeach
    @endif

      



</body>

</html>
