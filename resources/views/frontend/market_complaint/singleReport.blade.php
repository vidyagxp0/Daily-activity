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
                 Complaint Management Single Report
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

                    <th class="w-20">Initiated Through</th>
                    <td class="w-30">{{ $data->initiated_through_gi ?? 'Not Applicable' }}</td>
                </td>
                        
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



</body>

</html>
