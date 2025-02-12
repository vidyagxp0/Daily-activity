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

    .head-number {
        font-weight: bold;
        font-size: 13px;
        padding-left: 10px;
    }

    .div-data {
        font-size: 13px;
        padding-left: 10px;
        margin-bottom: 10px;
    }
</style>

<body>

    <header>
        <table>
            <tr>
                <td class="w-70 head">
                    Lab Incident Family Report
                </td>
                <td class="w-30">
                    <div class="logo">
                        <img src="https://www.cphi-online.com/Medicef%20Logo-comp306798.jpg" alt="" class="w-80">
                    </div>
                </td>
            </tr>
        </table>
        <table>
            <tr>
                <td class="w-30">
                    <strong>Lab Incident No.</strong>
                </td>
                <td class="w-40">
                    {{ Helpers::getDivisionName(session()->get('division')) . "/LI/" . date('Y') . "/" . str_pad($data->record, 4, '0', STR_PAD_LEFT); }}

                  {{--{{ Helpers::getDivisionName(session()->get('division')) }}/LI/{{ $data->created_at->format('Y') }}/{{ str_pad($data->record, 4, '0', STR_PAD_LEFT) }}--}}
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
                <td class="w-30"><strong>Printed On :</strong> {{ date('d-M-Y') }}</td>
                <td class="w-40"><strong>Printed By :</strong> {{ Auth::user()->name }}</td>
                {{-- <td class="w-30"><strong>Page :</strong> 1 of 1</td> --}}
            </tr>
        </table>
    </footer>

    <div class="inner-block">
        <div class="content-table">
            <div class="block">
                <div class="block-head" style="margin: 2%">
                    General Information
                </div>
                <table >
                    <tr>
                        <th class="w-20">Record Number</th>
                        <td class="w-30">{{ Helpers::getDivisionName(session()->get('division')) }}/LI/{{ $data->created_at->format('Y') }}/{{ str_pad($data->record, 4, '0', STR_PAD_LEFT) }}</td>
                        <th class="w-20">Site/Location Code</th>
                        <td class="w-30">{{$data->division?$data->division:'-'}}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Initiator</th>
                        <td class="w-30">{{ $data->originator }}</td>
                        <th class="w-20">Date of Initiation</th>
                        <td class="w-30">{{ Helpers::getdateFormat($data->created_at) }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Assigned To</th>
                        <td class="w-30">@isset($data->assign_to) {{ Helpers::getInitiatorName($data->assign_to) }} @else Not Applicable @endisset</td>
                        <th class="w-20">Due Date</th>
                        <td class="w-30">@if(!empty($data->due_date)){{ Helpers::getdateFormat($data->due_date) }} @else Not Applicable  @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">Initiator Group</th>
                        <td class="w-30">@if($data->Initiator_Group){{ Helpers::getNewInitiatorGroupFullName($data->Initiator_Group) }} @else Not Applicable  @endif</td>
                        <th class="w-20">Initiator Group Code</th>
                        <td class="w-30">@if($data->initiator_group_code){{ $data->initiator_group_code }} @else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">Short Description</th>
                        <td class="w-30" colspan="3">
                            @if($data->short_desc){{ $data->short_desc }}@else Not Applicable @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Priority</th>
                        <td class="w-30">@if(!empty($data->priority_data)){{  $data->priority_data }} @else Not Applicable  @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">Product Name</th>
                        <td class="w-30" colspan="3">@if($data->product_name){{ $data->product_name }} @else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">Instrument Involved</th>
                        <td class="w-30" colspan="3">@if($data->incident_involved_others_gi){{ $data->incident_involved_others_gi }} @else Not Applicable @endif</td>
                    </tr>

                    <tr>
                        <th class="w-20">Stage</th>
                        <td class="w-30">@if($data->stage_stage_gi){{ $data->stage_stage_gi }}@else Not Applicable @endif</td>
                        <th class="w-20">Stability Condition</th>
                        <td class="w-30">@if($data->incident_stability_cond_gi){{ $data->incident_stability_cond_gi }}@else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">Interval</th>
                        <td class="w-30">@if($data->incident_interval_others_gi){{ $data->incident_interval_others_gi }}@else Not Applicable @endif</td>
                        <th class="w-20">Test</th>
                        <td class="w-30">@if($data->test_gi){{ $data->test_gi }}@else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">Date Of Analysis</th>
                        <td class="w-30">@if($data->incident_date_analysis_gi){{ Helpers::getdateFormat($data->incident_date_analysis_gi) }}@else Not Applicable @endif</td>
                        <th class="w-20">Specification Number</th>
                        <td class="w-30">@if($data->incident_specification_no_gi){{ $data->incident_specification_no_gi }}@else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">STP Number</th>
                        <td class="w-30">@if($data->incident_stp_no_gi){{ $data->incident_stp_no_gi }}@else Not Applicable @endif</td>
                        <!-- <th class="w-20">Name Of Analysis</th>
                        <td class="w-30">@if($data->Incident_name_analyst_no_gi){{ $data->Incident_name_analyst_no_gi }}@else Not Applicable @endif</td> -->
                        <th class="w-20">Date Of Incidence</th>
                        <td class="w-30">@if($data->incident_date_incidence_gi){{ Helpers::getdateFormat($data->incident_date_incidence_gi) }}@else Not Applicable @endif</td>
                    </tr>

                    <tr>
                        <th class="w-20">Description Of Incidence</th>
                        <td class="w-30" colspan="3">@if($data->description_incidence_gi){{ $data->description_incidence_gi }}@else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">Analyst Name</th>
                        <td class="w-30">@if($data->analyst_sign_date_gi){{ Helpers::getInitiatorName($data->analyst_sign_date_gi) }} @else Not Applicable @endif</td>
                        <th class="w-20">Section Head Name</th>
                         <td class="w-30">@isset($data->section_sign_date_gi) {{ Helpers::getInitiatorName($data->section_sign_date_gi) }} @else Not Applicable @endisset</td>

                    </tr>
                    <tr>
                        <th class="w-20">Severity Level</th>
                        <td class="w-30">@if(!empty($data->severity_level2)){{ $data->severity_level2 }} @else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">Incident Category</th>
                        <td class="w-30">@if($data->Incident_Category){{ $data->Incident_Category }}@else Not Applicable @endif</td>
                        <th class="w-20">Invocation Type</th>
                        <td class="w-30">@if($data->Invocation_Type){{ $data->Invocation_Type }}@else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">Others</th>
                        <td class="w-30" colspan="3">@if($data->Incident_Category_others){{ $data->Incident_Category_others }}@else Not Applicable @endif</td>
                    </tr>
                    {{--<tr>
                        <th class="w-20">Initial Attachment</th>
                        <td class="w-30">@if($data->attachments_gi)<a href="{{ asset('upload/document/',$data->attachments_gi) }}">{{ $data->attachments_gi }}</a>@else Not Applicable @endif</td>
                    </tr>--}}
                </table>
            </div>

            <div class="border-table">
                <div class="block-head">
                    Initial Attachment
                </div>
                <table>

                    <tr class="table_bg">
                        <th class="w-20">S.N.</th>
                        <th class="w-60">Batch No</th>
                    </tr>
                    @if ($data->attachments_gi)
                        @foreach (json_decode($data->attachments_gi) as $key => $file)
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

<br>
            <div class="block">
                <div class="block-head">
                    Incident Investigation Report
                </div>
                <div class="border-table">
                    <table>
                        <tr class="table_bg">
                            <th class="w-25">Sr. No.</th>
                            <th class="w-25">Name of Product</th>
                            <th class="w-25">B No./A.R. No.</th>
                            <th class="w-25">Remarks</th>
                        </tr>
                        @php $investreport = 1; @endphp
                        @foreach ($labgrid->data as $item)
                        <tr>
                            <td class="w-15">{{ $investreport++ }}</td>
                            <td class="w-15">{{ $item['name_of_product'] }}</td>
                            <td class="w-15">{{ $item['batch_no'] }}</td>
                            <td class="w-15">{{ $item['remarks'] }}</td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div> 

            <div class="block">
                <div class="block-head">
                    Immediate Action
                </div>
                <table>
                    <tr>
                        <th class="w-20">Immediate Action</th>
                        <td class="w-30" colspan="3">@if($data->immediate_action_ia){{ $data->immediate_action_ia }}@else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">Detail Investigation</th>
                        <td class="w-30" colspan="3">{{ $data->details_investigation_ia }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Proposed Corrective Action</th>
                        <td class="w-30" colspan="3">{{ $data->proposed_correctivei_ia }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Repeat Analysis Plan</th>
                        <td class="w-30" colspan="3">@if($data->repeat_analysis_plan_ia){{ $data->repeat_analysis_plan_ia }}@else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">Result Of Repeat Analysis</th>
                        <td class="w-30" colspan="3">@if($data->result_of_repeat_analysis_ia){{ $data->result_of_repeat_analysis_ia }}@else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">Corrective and Preventive Action</th>
                        <td class="w-30" colspan="3">@if($data->corrective_and_preventive_action_ia){{ $data->corrective_and_preventive_action_ia }}@else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">CAPA Number</th>
                        <td class="w-30">@if($data->capa_number_im){{ $data->capa_number_im }}@else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">Investigation Summary</th>
                        <td class="w-30" colspan="3">@if($data->investigation_summary_ia){{ $data->investigation_summary_ia }}@else Not Applicable @endif</td>
                    </tr>

                    <tr>
                        <th class="w-20">Type of Incidence</th>
                        <td class="w-30">@if($data->type_incidence_ia){{ $data->type_incidence_ia }}@else Not Applicable @endif</td>
                        <th class="w-20">Investigator</th>
                        <td class="w-30">@isset($data->investigator_qc) {{ Helpers::getInitiatorName($data->investigator_qc) }} @else Not Applicable @endisset</td>
                    </tr>
                    <tr>
                        <th class="w-20">QC Review</th>
                        <td class="w-30">@isset($data->qc_review_to) {{ Helpers::getInitiatorName($data->qc_review_to) }} @else Not Applicable @endisset</td>
                        {{--<th class="w-20">Attachments</th>
                        <td class="w-30">@if($data->attachments_ia)<a href="{{ asset('upload/document/',$data->attachments_ia) }}">{{ $data->attachments_ia }}</a>@else Not Applicable @endif</td>--}}
                    </tr>
                </table>
            </div>

            <div class="border-table">
                <div class="block-head">
                     Attachments
                </div>
                <table>

                    <tr class="table_bg">
                        <th class="w-20">S.N.</th>
                        <th class="w-60">Batch No</th>
                    </tr>
                    @if ($data->attachments_ia)
                        @foreach (json_decode($data->attachments_ia) as $key => $file)
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

        {{--</div>--}}



             <div class="block">
                <div class="block-head">
                     Incident Details
                </div>
                <table>
                    <tr>
                        <th class="w-20">Incident Details</th>
                        <td class="w-30" colspan="3">@if($data->Incident_Details){{ $data->Incident_Details }}@else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">Document Details</th>
                        <td class="w-30" colspan="3">@if($data->Document_Details){{ $data->Document_Details }}@else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">Instrument Details</th>
                        <td class="w-30" colspan="3">@if($data->Instrument_Details){{ $data->Instrument_Details }}@else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">Involved Personnel</th>
                        <td class="w-30" colspan="3">@if($data->Involved_Personnel){{ $data->Involved_Personnel }}@else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">Product Details,If Any</th>
                        <td class="w-30" colspan="3">@if($data->Product_Details){{ $data->Product_Details }}@else Not Applicable @endif</td>
                    </tr>
                    <tr>
                    <th class="w-20">Supervisor Review Comments</th>
                    <td class="w-30" colspan="3">@if($data->Supervisor_Review_Comments){{ $data->Supervisor_Review_Comments }}@else Not Applicable @endif</td>
                    </tr>
                    {{--<tr>
                        <th>Incident Details Attachment</th>
                        <td class="w-80">@if($data->ccf_attachments)<a href="{{ asset('upload/document/',$data->ccf_attachments) }}">{{ $data->ccf_attachments }}</a>@else Not Applicable @endif</td>
                    </tr>--}}
                </table>
             </div>
 
             <div class="border-table">
                <div class="block-head">
                    Incident Details Attachment
                </div>
                <table>

                    <tr class="table_bg">
                        <th class="w-20">S.N.</th>
                        <th class="w-60">Batch No</th>
                    </tr>
                    @if ($data->ccf_attachments)
                        @foreach (json_decode($data->ccf_attachments) as $key => $file)
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

<br>
                 <div class="block">
                    <div class="block-head">
                         Investigation Details
                     </div>
                     <table>
                       {{--<tr>
                           <th>Inv Attachment</th>
                           <td class="w-80">@if($data->Inv_Attachment)<a href="{{ asset('upload/document/',$data->Inv_Attachment) }}">{{ $data->Inv_Attachment }}</a>@else Not Applicable @endif</td>
                        </tr>--}}
                        <tr>
                             <th class="w-20">Investigation Details</th>
                             <td class="w-30" colspan="3">@if($data->Investigation_Details){{ $data->Investigation_Details }}@else Not Applicable @endif</td>
                        </tr>
                        <tr>
                             <th class="w-20">Action Taken</th>
                              <td class="w-30" colspan="3">@if($data->Action_Taken){{ $data->Action_Taken }}@else Not Applicable @endif</td>
                         </tr>
                         <tr>
                             <th class="w-20">Root Cause</th>
                             <td class="w-30" colspan="3">@if($data->Root_Cause){{ $data->Root_Cause }}@else Not Applicable @endif</td>
                         </tr>
                     </table>
                 </div>

                 <div class="border-table">
                    <div class="block-head">
                        Inv Attachment
                    </div>
                    <table>
    
                        <tr class="table_bg">
                            <th class="w-20">S.N.</th>
                            <th class="w-60">Batch No</th>
                        </tr>
                        @if ($data->Inv_Attachment)
                            @foreach (json_decode($data->Inv_Attachment) as $key => $file)
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

                <br>

                 <div class="block">
                    <div class="block-head">
                        Capa
                    </div>
                    <table>
                        <tr>
                            <th class="w-20">Capa</th>
                            <td class="w-30" colspan="3">@if($data->capa_capa){{ $data->capa_capa }}@else Not Applicable @endif</td>
                        </tr>
                        <tr>
                            <th class="w-20">Corrective Action</th>
                             <td class="w-30" colspan="3">@if($data->Currective_Action){{ $data->Currective_Action }}@else Not Applicable @endif</td>
                        </tr>
                        <tr>
                            <th class="w-20">Preventive Action</th>
                            <td class="w-30" colspan="3">@if($data->Preventive_Action){{ $data->Preventive_Action }}@else Not Applicable @endif</td>
                        </tr>
                        <tr>
                            <th class="w-20">Corrective & Preventive Action</th>
                            <td class="w-30" colspan="3">@if($data->Corrective_Preventive_Action){{ $data->Corrective_Preventive_Action }}@else Not Applicable @endif</td>
                        </tr>
                        {{--<tr>
                           <th>CAPA Attachment</th>
                           <td class="w-80">@if($data->CAPA_Attachment)<a href="{{ asset('upload/document/',$data->Inv_Attachment) }}">{{ $data->CAPA_Attachment }}</a>@else Not Applicable @endif</td>
                        </tr>--}}
                    </table>
                </div>

                <div class="border-table">
                    <div class="block-head">
                        CAPA Attachment
                    </div>
                    <table>
    
                        <tr class="table_bg">
                            <th class="w-20">S.N.</th>
                            <th class="w-60">Batch No</th>
                        </tr>
                        @if ($data->CAPA_Attachment)
                            @foreach (json_decode($data->CAPA_Attachment) as $key => $file)
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

                <br>

                <div class="block">
                    <div class="block-head">
                        QA Review
                    </div>
                    <table>
                        <tr>
                            <th class="w-20">QA Review Comments</th>
                            <td class="w-80">@if($data->QA_Review_Comments){{ $data->QA_Review_Comments }}@else Not Applicable @endif</td>
                        </tr>
                        {{--<tr>
                            <th class="w-20">QA Review Attachment</th>
                            <td class="w-80">@if($data->QA_Head_Attachment)<a href="{{ asset('upload/document/',$data->QA_Head_Attachment) }}">{{ $data->QA_Head_Attachment }}</a>@else Not Applicable @endif</td>
                        </tr>--}}
                        
                    </table>
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
                        @if ($data->QA_Head_Attachment)
                            @foreach (json_decode($data->QA_Head_Attachment) as $key => $file)
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

                <br>

                <div class="block">
                    <div class="block-head">
                        QA Head/Designee Approval
                    </div>
                    <table>
                        <tr>
                            <th class="w-20">QA Head/Designee Comments</th>
                            <td class="w-30" colspan="3">@if($data->QA_Head){{ $data->QA_Head }}@else Not Applicable @endif</td>
                        </tr>
                        <tr>
                            <th class="w-20">Incident Type</th>
                            <td class="w-30" colspan="3">@if($data->Incident_Type){{ $data->Incident_Type }}@else Not Applicable @endif</td>
                        </tr>
                        <tr>
                            <th class="w-20">Conclusion</th>
                            <td class="w-30" colspan="3">@if($data->Conclusion){{ $data->Conclusion }}@else Not Applicable @endif</td>
                        </tr>
                        <tr>
                            <th class="w-20">Due Date Extension Justification</th>
                            <td class="w-30" colspan="3">@if($data->due_date_extension){{ $data->due_date_extension }}@else Not Applicable @endif</td>
                        </tr>
                    </table>
                </div>
                
            @foreach ($labtab as $singlereport)
            <div class="block">
                <div class="block-head">
                    System Suitability Failure Incidence
                </div>
                <table>
                    <tr>
                        <th class="w-20">Instrument Involved</th>
                        <td class="w-30" colspan="3">@if($singlereport->involved_ssfi){{ $singlereport->involved_ssfi }}@else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">Stage</th>
                        <td class="w-30">{{ $singlereport->stage_stage_ssfi }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Stability Condition</th>
                        <td class="w-30">@if($singlereport->Incident_stability_cond_ssfi){{ $singlereport->Incident_stability_cond_ssfi }}@else Not Applicable @endif</td>
                        <th class="w-20">Interval</th>
                        <td class="w-30">@if($singlereport->Incident_interval_ssfi){{ $singlereport->Incident_interval_ssfi }}@else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">Test</th>
                        <td class="w-30">@if($singlereport->test_ssfi){{ $singlereport->test_ssfi }}@else Not Applicable @endif</td>
                        <th class="w-20">Date Of Analysis</th>
                        <td class="w-30">@if($singlereport->Incident_date_analysis_ssfi){{ Helpers::getdateFormat($singlereport->Incident_date_analysis_ssfi) }}@else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">Specification Number</th>
                        <td class="w-30">@if($singlereport->Incident_specification_ssfi){{ $singlereport->Incident_specification_ssfi }}@else Not Applicable @endif</td>
                        <th class="w-20">STP Number</th>
                        <td class="w-30">@if($singlereport->Incident_stp_ssfi){{ $singlereport->Incident_stp_ssfi }}@else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">Date Of Incidence</th>
                        <td class="w-30">
                            @if($singlereport->Incident_date_incidence_ssfi)
                                {{ Helpers::getdateFormat($singlereport->Incident_date_incidence_ssfi) }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">Description Of Incidence</th>
                        <td class="w-30" colspan="3">@if($singlereport->Description_incidence_ssfi){{ $singlereport->Description_incidence_ssfi }}@else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">QC Reviewer</th>
                        <td class="w-30">@isset($data->suit_qc_review_to) {{ Helpers::getInitiatorName($data->suit_qc_review_to) }} @else Not Applicable @endisset</td>
                    </tr>
                    <tr>
                        <th class="w-20">Detail Investigation</th>
                        <td class="w-30" colspan="3">@if($singlereport->Detail_investigation_ssfi){{ $singlereport->Detail_investigation_ssfi }}@else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">Proposed Corrective Action</th>
                        <td class="w-30" colspan="3">@if($singlereport->proposed_corrective_ssfi){{ $singlereport->proposed_corrective_ssfi }}@else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">Root Cause</th>
                        <td class="w-30" colspan="3">@if($singlereport->root_cause_ssfi){{ $singlereport->root_cause_ssfi }}@else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">Incident Summary</th>
                        <td class="w-30" colspan="3">@if($singlereport->incident_summary_ssfi){{ $singlereport->incident_summary_ssfi }}@else Not Applicable @endif</td>
                    </tr>
                    {{--<tr>
                        <th class="w-20">System Suitability Attachment</th>
                        <td class="w-30">@if($singlereport->system_suitable_attachments)<a href="{{ asset('upload/document/',$singlereport->system_suitable_attachments) }}">{{ $singlereport->system_suitable_attachments }}</a>@else Not Applicable @endif</td>
                    </tr>--}}
                </table>
            </div>

            <div class="border-table">
                <div class="block-head">
                    System Suitability Attachment
                </div>
                <table>

                    <tr class="table_bg">
                        <th class="w-20">S.N.</th>
                        <th class="w-60">Batch No</th>
                    </tr>
                    @if ($data->system_suitable_attachments)
                        @foreach (json_decode($data->system_suitable_attachments) as $key => $file)
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
<br>
            <div class="block">
                <div class="block-head">
                    System Suitability Failure Report
                </div>
                <div class="border-table">
                    <table>
                        <tr class="table_bg">
                            <th class="w-25">Sr. No.</th>
                            <th class="w-25">Name of Product</th>
                            <th class="w-25">B No./A.R. No.</th>
                            <th class="w-25">Remarks</th>
                        </tr>
                        @php $singlereport = 1; @endphp
                        @foreach ($labtab_grid->data as $itm)
                        <tr>
                            <td class="w-15">{{ $singlereport++ }}</td>
                            <td class="w-15">{{ $itm['name_of_product_ssfi'] }}</td>
                            <td class="w-15">{{ $itm['batch_no_ssfi'] }}</td>
                            <td class="w-15">{{ $itm['remarks_ssfi']}}</td>

                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>

            @endforeach


            <div class="block-head">
                Closure
            </div>
            <table>
                    <tr>
                        <th class="w-20">Closure Of Incident</th>
                        <td class="w-80">
                            @if($labnew->closure_incident_c)
                                {{ $labnew->closure_incident_c }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">QC Head Remark</th>
                        <td class="w-80">
                            @if($labnew->qc_hear_remark_c)
                                {{ $labnew->qc_hear_remark_c }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">QC Head Closure</th>
                        <td class="w-30">
                            @if($data->qc_head_closure)
                                {{ Helpers::getInitiatorName($data->qc_head_closure) }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">QA Head Remark</th>
                        <td class="w-30">
                            @if($labnew->qa_hear_remark_c)
                                {{ $labnew->qa_hear_remark_c }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    {{--<tr>
                        <th class="w-20">Closure Attachment</th>
                        <td class="w-30">
                            @if($labnew->closure_attachment_c)
                                {{ $labnew->closure_attachment_c }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>--}}
            </table>
            

            <div class="border-table">
                <div class="block-head">
                    Closure Attachment
                </div>
                <table>

                    <tr class="table_bg">
                        <th class="w-20">S.N.</th>
                        <th class="w-60">Batch No</th>
                    </tr>
                    @if ($data->closure_attachment_c)
                        @foreach (json_decode($data->closure_attachment_c) as $key => $file)
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
            

            <!-- <div class="block">
                <div class="block-head">
                    Attachments
                </div>
                <table>
                    <tr>
                        <th class="w-20">Initial Attachment</th>
                        <td class="w-80">@if($data->Initial_Attachment)<a href="{{ asset('upload/document/',$data->Initial_Attachment) }}">{{ $data->Initial_Attachment }}</a>@else Not Applicable @endif</td>
                        <th class="w-20">Attachment</th>
                        <td class="w-80">@if($data->Attachments)<a href="{{ asset('upload/document/',$data->Attachments) }}">{{ $data->Attachments }}</a>@else Not Applicable @endif</td>
                    </tr>
                    <tr>
                    </tr>
                    <tr>
                        <th class="w-20">Inv Attachment</th>
                        <td class="w-80">@if($data->Inv_Attachment)<a href="{{ asset('upload/document/',$data->Inv_Attachment) }}">{{ $data->Inv_Attachment }}</a>@else Not Applicable @endif</td>
                        <th class="w-20">CAPA Attachment</th>
                        <td class="w-80">@if($data->CAPA_Attachment)<a href="{{ asset('upload/document/',$data->CAPA_Attachment) }}">{{ $data->CAPA_Attachment }}</a>@else Not Applicable @endif</td>
                    </tr>
                    <tr>
                    </tr>
                </table>
            </div> -->

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
                        <th class="w-20">Submitted Comment</th>
                        <td class="w-30">{{ $data->comment }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Verification Complete By</th>
                        <td class="w-30">{{ $data->verification_complete_completed_by }}</td>
                        <th class="w-20">Verification Complete On</th>
                        <td class="w-30">{{ $data->verification_completed_on }}</td>
                        <th class="w-20">Verification Complete Comment</th>
                        <td class="w-30">{{ $data->verification_complete_comment }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Preliminary Investigation Completed By</th>
                        <td class="w-30">{{ $data->preliminary_completed_by }}</td>
                        <th class="w-20">Preliminary Investigation Completed On</th>
                        <td class="w-30">{{ $data->preliminary_completed_on}}</td>
                        <th class="w-20">Preliminary Investigation Comment</th>
                        <td class="w-30">{{ $data->preliminary_completed_comment}}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Assignable Cause Identification Completed By</th>
                        <td class="w-30">{{ $data->all_activities_completed_by }}</td>
                        <th class="w-20">Assignable Cause Identification Completed On</th>
                        <td class="w-30">{{ $data->all_activities_completed_on }}</td>
                        <th class="w-20">Assignable Cause Identification Completed Comment</th>
                        <td class="w-30">{{ $data->all_activities_completed_comment }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">No Assignable Cause Identification  Completed By</th>
                        <td class="w-30">{{ $data->no_assignable_cause_by }}</td>
                        <th class="w-20">No Assignable Cause Identification Completed On</th>
                        <td class="w-30">{{ $data->no_assignable_cause_on }}</td>
                        <th class="w-20">No Assignable Cause Identification Completed Comment</th>
                        <td class="w-30">{{ $data->no_assignable_cause_comment }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Extended Inv Completed By</th>
                        <td class="w-30">{{ $data->extended_inv_complete_by }}</td>
                        <th class="w-20">Extended Inv Completed On</th>
                        <td class="w-30">{{ $data->extended_inv_complete_on }}</td>
                        <th class="w-20">Extended Inv Completed Comment</th>
                        <td class="w-30">{{ $data->extended_inv_comment }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Solution Validation Completed By</th>
                        <td class="w-30">{{ $data->review_completed_by }}</td>
                        <th class="w-20">Solution Validation Completed On</th>
                        <td class="w-30">{{ $data->review_completed_on }}</td>
                        <th class="w-20">Solution Validation Completed Comment</th>
                        <td class="w-30">{{ $data->solution_validation_comment }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">All Action Approved Completed By</th>
                        <td class="w-30">{{ $data->all_actiion_approved_by }}</td>
                        <th class="w-20">All Action Approved Completed On</th>
                        <td class="w-30">{{ $data->all_actiion_approved_on }}</td>
                        <th class="w-20">All Action Approved Completed Comment</th>
                        <td class="w-30">{{ $data->all_action_approved_comment }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Assessment Completed By</th>
                        <td class="w-30">{{ $data->assesment_completed_by }}</td>
                        <th class="w-20">Assessment Completed On</th>
                        <td class="w-30">{{ $data->assesment_completed_on }}</td>
                        <th class="w-20">Assessment Completed Comment</th>
                        <td class="w-30">{{ $data->assessment_comment }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Closure Completed By</th>
                        <td class="w-30">{{ $data->closure_completed_by }}</td>
                        <th class="w-20">Closure Completed On</th>
                        <td class="w-30">{{ $data->closure_completed_on }}</td>
                        <th class="w-20">Closure Completed Comment</th>
                        <td class="w-30">{{ $data->closure_comment }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Cancelled By</th>
                        <td class="w-30">{{ $data->cancelled_by }}</td>
                        <th class="w-20">Cancelled On</th>
                        <td class="w-30">{{ $data->cancelled_on }}</td>
                        <th class="w-20">Cancelled Comment</th>
                        <td class="w-30">{{ $data->cancell_comment }}</td>
                    </tr>
                </table>
            </div>



            
            
               
                
               

            </div>
        </div>
    </div>

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
                                    {{ Helpers::getDivisionName(session()->get('division')) . "/AI/" . date('Y') . "/" . str_pad($data->record, 4, '0', STR_PAD_LEFT); }}

                                        {{--{{ Helpers::divisionNameForQMS($data->division_id) }}/AI/{{ Helpers::year($data->created_at) }}/{{ str_pad($data->record, 4, '0', STR_PAD_LEFT) }}--}}
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
        
                        <label class="head-number" for="Action Item Related Records">Action Item Related Records</label>
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
                                <th class="w-20">Submitted Comment</th>
                                <td class="w-80">{{ $data->submitted_comment }}</td>
                            </tr>
        
                            
                            <tr>
                                <th class="w-20">Acknowledge By</th>
                                <td class="w-80">{{ $data->acknowledgement_by }}</td>
                                <th class="w-20">Acknowledge On</th>
                                <td class="w-80">{{ $data->acknowledgement_on }}</td>
                            </tr>
        
                            <tr>
                                <th class="w-20">Acknowledge Comment</th>
                                <td class="w-80">{{ $data->acknowledgement_comment }}</td>
                            </tr>
        
                            <tr>
                                <th class="w-20">Work Completion By</th>
                                <td class="w-80">{{ $data->work_completion_by }}</td>
                                <th class="w-20">Work Completion On</th>
                                <td class="w-80">{{ $data->work_completion_on }}</td>
                            </tr>
        
                            <tr>
                                <th class="w-20">Work Completion Comment</th>
                                <td class="w-80">{{ $data->work_completion_comment }}</td>
                            </tr>
        
                            <tr>
                                <th class="w-20">QA/CQA Verification By</th>
                                <td class="w-80">{{ $data->qa_varification_by }}</td>
                                <th class="w-20">QA/CQA Verification On</th>
                                <td class="w-80">{{ $data->qa_varification_on }}</td>
                            </tr>
        
                            <tr>
                                <th class="w-20">QA/CQA Verification Comment</th>
                                <td class="w-80">{{ $data->qa_varification_comment }}</td>
                            </tr>

                            <tr>
                                <th class="w-20">Cancelled By</th>
                                <td class="w-80">{{ $data->cancelled_by }}</td>
                                <th class="w-20">Cancelled On</th>
                                <td class="w-80">{{ $data->cancelled_on }}</td>
                            </tr>
        
                            <tr>
                                <th class="w-20">Cancelled Comment</th>
                                <td class="w-80">{{ $data->cancelled_comment }}</td>
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
                                    {{ Helpers::getDivisionName(session()->get('division')) . "/CAPA/" . date('Y') . "/" . str_pad($data->record, 4, '0', STR_PAD_LEFT); }}

                                    {{--{{ Helpers::divisionNameForQMS($data->division_id) }}/{{ Helpers::year($data->created_at) }}/CAPA/{{ str_pad($data->record, 4, '0', STR_PAD_LEFT) }}--}}
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


    @if (count($Extension) > 0)
        @foreach ($Extension as $data)
            <center>
                <h3>Extension Report</h3>
            </center>

            <div class="inner-block">
                <div class="content-table">
                    <div class="block">
                        <div class="block-head">Extension Details</div>
                        <table>
                            <tr>
                                <th class="w-20">Record Number</th>
                                <td class="w-80">
                                    @if ($data->record_number)
                                    {{ Helpers::getDivisionName(session()->get('division')) . "/Ext/" . date('Y') . "/" . str_pad($data->record, 4, '0', STR_PAD_LEFT); }}

                                        {{--{{ Helpers::divisionNameForQMS($data->site_location_code) }}/Ext/{{ Helpers::year($data->created_at) }}/{{ str_pad($data->record_number, 4, '0', STR_PAD_LEFT) }}--}}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                                <th class="w-20">Site/Location Code</th>
                                <td class="w-80">
                                    @if ($data->site_location_code)
                                        {{ Helpers::getDivisionName($data->site_location_code) }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th class="w-20">Initiator</th>
                                <td class="w-80">{{ Helpers::getInitiatorName($data->initiator) }}</td>
                                <th class="w-20">Date of Initiation</th>
                                <td class="w-80">{{ Helpers::getdateFormat($data->created_at) }}</td>
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

                        <table>
                            <tr>
                                <th class="w-20">HOD Reviewer</th>
                                <td class="w-80">
                                    @if ($data->reviewers)
                                        {{ Helpers::getInitiatorName($data->reviewers) }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                                <th class="w-20">QA Approval</th>
                                <td class="w-80">
                                    @if ($data->approvers)
                                        {{ Helpers::getInitiatorName($data->approvers) }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                            </tr>
                        </table>

                        <label class="head-number" for="Related Records">Related Records</label>
                        <div class="div-data">
                            @if ($data->related_records)
                                {{ str_replace(',', ', ', $data->related_records) }}
                            @else
                                Not Applicable
                            @endif
                        </div>

                        <table>
                            <tr>
                                <th class="w-20">Current Due Date (Parent)</th>
                                <td class="w-80">
                                    @if ($data->current_due_date)
                                        {{ Helpers::getdateFormat($data->current_due_date) }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                                <th class="w-20">Proposed Due Date</th>
                                <td class="w-80">
                                    @if ($data->proposed_due_date)
                                        {{ Helpers::getdateFormat($data->proposed_due_date) }}
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

                        <label class="head-number" for="Justification / Reason">Justification / Reason</label>
                        <div class="div-data">
                            @if ($data->justification_reason)
                                {{ $data->justification_reason }}
                            @else
                                Not Applicable
                            @endif
                        </div>

                    </div>
                    <div class="block">
                        <div class="block-head">Attachments</div>
                        <div class="border-table">
                            <table>
                                <tr class="table_bg">
                                    <th class="w-20">S.N.</th>
                                    <th class="w-80">File</th>
                                </tr>
                                @if ($data->file_attachment_extension)
                                    @foreach (json_decode($data->file_attachment_extension) as $key => $file)
                                        <tr>
                                            <td class="w-20">{{ $key + 1 }}</td>
                                            <td class="w-80"><a href="{{ asset('upload/' . $file) }}"
                                                    target="_blank"><b>{{ $file }}</b></a></td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td class="w-20">1</td>
                                        <td class="w-80">Not Applicable</td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                    <div class="block">
                        <div class="block-head">HOD Review</div>
                        <table>

                            <tr>
                                <th class="w-20">HOD Remarks</th>
                                <td class="w-80">
                                    @if ($data->reviewer_remarks)
                                        {{ $data->reviewer_remarks }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                            </tr>

                        </table>
                    </div>
                    <div class="block">
                        <div class="block-head">HOD Attachments</div>
                        <div class="border-table">
                            <table>
                                <tr class="table_bg">
                                    <th class="w-20">S.N.</th>
                                    <th class="w-80">File</th>
                                </tr>
                                @if ($data->file_attachment_reviewer)
                                    @foreach (json_decode($data->file_attachment_reviewer) as $key => $file)
                                        <tr>
                                            <td class="w-20">{{ $key + 1 }}</td>
                                            <td class="w-80"><a href="{{ asset('upload/' . $file) }}"
                                                    target="_blank"><b>{{ $file }}</b></a></td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td class="w-20">1</td>
                                        <td class="w-80">Not Applicable</td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                    </div>

                    <div class="block">
                        <div class="block-head">QA Approval</div>
                        <table>

                            <tr>
                                <th class="w-20">QA Remarks</th>
                                <td class="w-80">
                                    @if ($data->approver_remarks)
                                        {{ $data->approver_remarks }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                            </tr>

                        </table>
                    </div>
                    <div class="block">
                        <div class="block-head">QA Attachments</div>
                        <div class="border-table">
                            <table>
                                <tr class="table_bg">
                                    <th class="w-20">S.N.</th>
                                    <th class="w-80">File</th>
                                </tr>
                                @if ($data->file_attachment_approver)
                                    @foreach (json_decode($data->file_attachment_approver) as $key => $file)
                                        <tr>
                                            <td class="w-20">{{ $key + 1 }}</td>
                                            <td class="w-80"><a href="{{ asset('upload/' . $file) }}"
                                                    target="_blank"><b>{{ $file }}</b></a></td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td class="w-20">1</td>
                                        <td class="w-80">Not Applicable</td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                    <div class="block">
                        <div class="block-head">Activity Log</div>
                        <table>
                            <tr>
                                <th class="w-20">Submit By</th>
                                <td class="w-80">{{ $data->submit_by }}</td>
                                <th class="w-20">Submit On</th>
                                <td class="w-80">{{ $data->submit_on }}</td>
                            </tr>
                            <tr>
                                <th class="w-20">Submit Comment</th>
                                <td class="w-80">{{ $data->submit_comment }}</td>
                            </tr>
                            <tr>
                                <th class="w-20">Cancel By</th>
                                <td class="w-80">{{ $data->reject_by }}</td>
                                <th class="w-20">Cancel On</th>
                                <td class="w-80">{{ $data->reject_on }}</td>
                            </tr>
                            <tr>
                                <th class="w-20">Cancel Comment</th>
                                <td class="w-80">{{ $data->reject_comment }}</td>
                            </tr>
                            <tr>
                                <th class="w-20">More Information Required By</th>
                                <td class="w-80">{{ $data->more_info_review_by }}</td>
                                <th class="w-20">More Information Required On</th>
                                <td class="w-80">{{ $data->more_info_review_on }}</td>
                            </tr>
                            <tr>
                                <th class="w-20">More Information Required Comment</th>
                                <td class="w-80">{{ $data->more_info_review_comment }}</td>
                            </tr>
                            <tr>
                                <th class="w-20">Review By</th>
                                <td class="w-80">{{ $data->submit_by_review }}</td>
                                <th class="w-20">Review On</th>
                                <td class="w-80">{{ $data->submit_on_review }}</td>
                            </tr>
                            <tr>
                                <th class="w-20">Review Comment</th>
                                <td class="w-80">{{ $data->submit_comment_review }}</td>
                            </tr>
                            <tr>
                                <th class="w-20">Reject By</th>
                                <td class="w-80">{{ $data->submit_by_inapproved }}</td>
                                <th class="w-20">Reject On</th>
                                <td class="w-80">{{ $data->submit_on_inapproved }}</td>
                            </tr>
                            <tr>
                                <th class="w-20">Reject Comment</th>
                                <td class="w-80">{{ $data->submit_commen_inapproved }}</td>
                            </tr>
                            <tr>
                                <th class="w-20">More Information Required By</th>
                                <td class="w-80">{{ $data->more_info_inapproved_by }}</td>
                                <th class="w-20">More Information Required On</th>
                                <td class="w-80">{{ $data->more_info_inapproved_on }}</td>
                            </tr>
                            <tr>
                                <th class="w-20">More Information Required Comment</th>
                                <td class="w-80">{{ $data->more_info_inapproved_comment }}</td>
                            </tr>
                            <tr>
                                <th class="w-20">Send for CQA By</th>
                                <td class="w-80">{{ $data->send_cqa_by }}</td>
                                <th class="w-20">Send for CQA On</th>
                                <td class="w-80">{{ $data->send_cqa_on }}</td>
                            </tr>
                            <tr>
                                <th class="w-20">Send for CQA Comment</th>
                                <td class="w-80">{{ $data->send_cqa_comment }}</td>
                            </tr>
                            <tr>
                                <th class="w-20">Approved By</th>
                                <td class="w-80">{{ $data->submit_by_approved }}</td>
                                <th class="w-20">Approved On</th>
                                <td class="w-80">{{ $data->submit_on_approved }}</td>
                            </tr>
                            <tr>
                                <th class="w-20">Approved Comment</th>
                                <td class="w-80">{{ $data->submit_comment_approved }}</td>
                            </tr>
                            <tr>
                                <th class="w-20">CQA Approval Complete By</th>
                                <td class="w-80">{{ $data->cqa_approval_by }}</td>
                                <th class="w-20">CQA Approval Complete On</th>
                                <td class="w-80">{{ $data->cqa_approval_on }}</td>
                            </tr>
                            <tr>
                                <th class="w-20">CQA Approval Complete Comment</th>
                                <td class="w-80">{{ $data->cqa_approval_comment }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        @endforeach
    @endif

    @if (count($RiskAssessment) > 0)
        @foreach ($RiskAssessment as $data)
            <center>
                <h3>Risk Assessment Report</h3>
            </center>
            <div class="inner-block">
        <div class="content-table">
            <div class="block">
                <div class="block-head">
                    General Information
                </div>
                <table>
                    <tr>  {{ $data->created_at }} added by {{ $data->originator }}
                        <th class="w-20">Initiator</th>
                        <td class="w-30">{{ $data->originator }}</td>
                        <th class="w-20">Date of Initiation</th>
                        <td class="w-30">{{ Helpers::getdateFormat($data->created_at) }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Site/Location Code</th>
                        <td class="w-30">@if($data->division_code){{ $data->division_code }} @else Not Applicable @endif</td>
                        <th class="w-20">Assigned To</th>
                        <td class="w-30">@if($data->assign_to){{ Helpers::getInitiatorName($data->assign_to) }} @else Not Applicable @endif</td>                   </tr>
                    <tr>
                        <th class="w-20">Severity Level</th>
                        <td class="w-30">@if($data->severity2_level){{ $data->severity2_level}} @else Not Applicable @endif</td>
                        <th class="w-20">State/District</th>
                        <td class="w-30">@if($data->state){{ $data->state }} @else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">Initiator Group</th>
                        <td class="w-30">@if($data->Initiator_Group){{ $data->Initiator_Group }} @else Not Applicable @endif</td>
                        <th class="w-20">Initiator Group Code</th>
                        <td class="w-30">@if($data->initiator_group_code){{ $data->initiator_group_code }} @else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        {{--  <th class="w-20">Team Members</th>
                        <td class="w-30">@if($data->team_members){{ Helpers::getInitiatorName($data->team_members) }}@else Not Applicable @endif</td>  --}}
                        <th class="w-20">Due Date</th>
                        <td class="w-80"> @if($data->due_date){{ $data->due_date }} @else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">Risk/Opportunity Description</th>
                        <td class="w-80">@if($data->description){{ $data->description }} @else Not Applicable @endif</td>
                    </tr> 
                    <tr> 
                      
                        <th class="w-20">Risk/Opportunity Comments</th>
                        <td class="w-80">@if($data->comments){{ $data->comments }} @else Not Applicable @endif</td>
                    </tr>
                    <tr>
                     {{--  {{dd($data->departments)}}  --}}
                         <th class="w-20">Department(s)</th>
                         <td class="w-80">@if($data->departments){{  ($data->departments )}}@else Not Applicable @endif</td>
                       {{--  <td class="w-80">
                            @php
                                $departments = Helpers::getDepartmentNameWithString($data->departments);
                            @endphp

                            {{dd($departments)}}
                            @if(!empty($departments))
                                {{ implode(',', $departments) }}
                            @else
                                Not Applicable
                            @endif
                        </td>  --}}
                        <th class="w-20"> Short Description</th>
                        <td class="w-30">@if($data->short_description){{ $data->short_description }} @else Not Applicable @endif</td>
                    </tr>
                    <tr>
                            <th class="w-20">Type</th>
                            <td class="w-80">@if($data->type){{ $data->type }}@else Not Applicable @endif</td>
                    </tr>      
                    <tr>      
                            <th class="w-20">Risk/Opportunity Comments</th>
                            <td class="w-80">@if($data->comments){{ $data->comments }}@else Not Applicable @endif</td>
                        
                    </tr>
                    <tr>
                            <th class="w-20">Priority Level</th>
                            <td class="w-80">@if($data->priority_level){{ $data->priority_level }}@else Not Applicable @endif</td>
                            <th class="w-20">Source of Risk/Opportunity</th>
                            <td class="w-80">@if($data->source_of_risk){{ $data->source_of_risk }}@else Not Applicable @endif</td>
                        </tr>
                    
                </table>
            </div>

           
                        <div class="block">
                <div class="block-head">
                    Risk/Opportunity details
                </div>
                <table>
                    <tr>
                            <th class="w-20">Department(s)</th>
                            <td class="w-80">@if($data->departments2){{ ($data->departments2) }}@else Not Applicable @endif</td>
                            <th class="w-20">Source of Risk</th>
                            <td class="w-80">@if($data->source_of_risk){{ $data->source_of_risk }}@else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">Site Name</th>
                        <td class="w-30">{{ $data->site_name ?? 'Not Applicable' }}</td>
                        
                        <th class="w-20">Building</th>
                        <td class="w-30">{{ $data->building ?? 'Not Applicable' }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Floor</th>
                        <td class="w-30">{{ $data->floor ?? 'Not Applicable' }}</td>
                        
                        <th class="w-20">Duration</th>
                        <td class="w-30">{{ $data->duration ?? 'Not Applicable' }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Hazard</th>
                        <td class="w-30">{{ $data->hazard ?? 'Not Applicable' }}</td>
                        
                        <th class="w-20">Room</th>
                        <td class="w-30">{{ $data->room ?? 'Not Applicable' }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Regulatory Climate</th>
                        <td class="w-30">{{ $data->regulatory_climate ?? 'Not Applicable' }}</td>
                        
                        <th class="w-20">Number of Employees</th>
                        <td class="w-30">{{ $data->Number_of_employees ?? 'Not Applicable' }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Room</th>
                        <td class="w-30">{{ $data->room2 ?? 'Not Applicable' }}</td>
                        
                        <th class="w-20">Risk Management Strategy</th>
                        <td class="w-30">{{ $data->risk_management_strategy ?? 'Not Applicable' }}</td>
                    </tr>

                   </table>
                </div>
            </div>

           <div class="block">
                <div class="block-head">
                    Work Group Assignment
                </div>
                <table>
                    <tr>
                        <th class="w-20">Scheduled Start Date</th>
                        <td class="w-30">@if($data->schedule_start_date1){{ $data->schedule_start_date1 }}@else Not Applicable @endif</td>
                        <th class="w-20">Scheduled End Date</th>
                        <td class="w-30">@if($data->schedule_end_date1){{ $data->schedule_end_date1 }}@else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-50">Estimated Man-Hours</th>
                        <td class="w-50">@if($data->estimated_man_hours){{ $data->estimated_man_hours }}@else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">Estimated Cost</th>
                        <td class="w-30">@if($data->estimated_cost){{ $data->estimated_cost }}@else Not Applicable @endif</td>
                        <th class="w-20">Currency</th>
                        <td class="w-30">@if($data->currency){{ $data->currency }}@else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">Justification/Rationale</th>
                        <td class="w-30">@if($data->justification){{ $data->justification }}@else Not Applicable @endif</td>
                        
                    </tr>
                    <!-- <tr>
                        <th class="w-20">Action Plan</th>
                        <td class="w-30">@if($data->action_plan){{ $data->action_plan }}@else Not Applicable @endif</td>
                        <th class="w-20"></th>
                        <td class="w-30">@if($data->work_group_attachments){{ $data->work_group_attachments}}@else Not Applicable @endif</td>
                    </tr> -->
                </table>
                <div class="border-table">
                    <div class="block-head">
                    Work Group Attachments
                    </div>
                    <table>

                        <tr class="table_bg">
                            <th class="w-20">S.N.</th>
                            <th class="w-60">Batch No</th>
                        </tr>
                            @if($data->reference)
                            @foreach(json_decode($data->reference) as $key => $file)
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
                </div>
            </div>
            <div class="block">
                <div class="head">
                    <div class="block-head">
                      Risk/Opportunity Analysis
                    </div>
                    <table>
                      <tr>
                        <th class="w-20">Root Cause Methodology</th>
                        <td class="w-80">
                        @if($data->root_cause_methodology)
                         @php
                             $method = explode(',',$data->root_cause_methodology);

                         @endphp 
                        @if(in_array('1',$method))
                             Why-Why Chart,<br>
                         @endif   
                          @if (in_array('2',$method))
                               Failure Mode and Efect Analysis,<br>
                          @endif
                         
                         @if (in_array('3',$method))
                             Fishbone or Ishikawa Diagram,<br>
                         @endif
                         @if (in_array('4',$method))
                            Is/Is Not Analysis,<br>
                         @endif
                        
                        @else Not Applicable 
                        
                        @endif
                        
                        </td>
                        </tr>
                        <tr>
                        <th class="w-20">Root Cause Description</th>
                        <td class="w-80">@if($data->root_cause_description){{ $data->root_cause_description}}@else Not Applicable @endif</td>
                       </tr>
                        <tr>
                           <th class="w-20">Investigation Summary</th>
                           <td class="w-80">@if($data->investigation_summary){{ $data->investigation_summary }}@else Not Applicable @endif</td>
                        </tr>
                        <tr>
                            <th class="w-20">Severity Rate</th>
                            <td class="w-80">
                                <div>
                                    @if($data->severity_rate)
                                        @switch($data->severity_rate)
                                            @case(1)
                                                Negligible
                                                @break
                                            @case(2)
                                                Moderate
                                                @break
                                            @case(3)
                                                Major
                                                @break
                                            @case(4)
                                                Fatal
                                                @break
                                            @default
                                                Not Applicable
                                        @endswitch
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th class="w-20">Occurrence</th>
                            <td class="w-80">
                                <div>
                                    @if($data->occurrence)
                                        @switch($data->occurrence)
                                            @case(1)
                                                Very Likely
                                                @break
                                            @case(2)
                                                Likely
                                                @break
                                            @case(3)
                                                Unlikely
                                                @break
                                            @case(4)
                                                Rare
                                                @break
                                            @case('Extremely Unlikely')
                                                Extremely Unlikely
                                                @break
                                            @default
                                                Not Applicable
                                        @endswitch
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th class="w-20">Detection</th>
                            <td class="w-80">
                                <div>
                                    @if($data->detection)
                                        @switch($data->detection)
                                            @case(1)
                                                Very Likely
                                                @break
                                            @case(2)
                                                Likely
                                                @break
                                            @case(3)
                                                Unlikely
                                                @break
                                            @case(4)
                                                Rare
                                                @break
                                            @case(5)
                                                Impossible
                                                @break
                                            @default
                                                Not Applicable
                                        @endswitch
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th class="w-20">RPN</th>
                            <td class="w-80">
                                <div>
                                    @if($data->rpn)
                                        {{ $data->rpn }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                        </tr>
                    </table>

                    <div class="block-head">
                        Fishbone or Ishikawa Diagram 
                    </div>
                    <table>
                    - <tr>
                        <th class="w-20">Measurement</th>
                        {{-- <td class="w-80">@if($riskgrdfishbone->measurement){{ $riskgrdfishbone->measurement }}@else Not Applicable @endif</td> --}}
                             <td class="w-80">
                            @php
                                $measurement = unserialize($riskgrdfishbone->measurement);
                            @endphp
                            
                            @if(is_array($measurement))
                                @foreach($measurement as $value)
                                    {{ htmlspecialchars($value) }}
                                @endforeach
                            @elseif(is_string($measurement))
                                {{ htmlspecialchars($measurement) }}
                            @else
                                Not Applicable
                            @endif
                              </td>
                        <th class="w-20">Materials</th>
                        {{-- <td class="w-80">@if($riskgrdfishbone->materials){{ $riskgrdfishbone->materials }}@else Not Applicable @endif</td> --}}
                             <td class="w-80">
                            @php
                                $materials = unserialize($riskgrdfishbone->materials);
                            @endphp
                            
                            @if(is_array($materials))
                                @foreach($materials as $value)
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
                        {{-- <td class="w-80">@if($riskgrdfishbone->methods){{ $riskgrdfishbone->methods }}@else Not Applicable @endif</td> --}}
                           <td class="w-80">
                            @php
                                $methods = unserialize($riskgrdfishbone->methods);
                            @endphp
                            
                            @if(is_array($methods))
                                @foreach($methods as $value)
                                    {{ htmlspecialchars($value) }}
                                @endforeach
                            @elseif(is_string($methods))
                                {{ htmlspecialchars($methods) }}
                            @else
                                Not Applicable
                            @endif
                           </td>
                        <th class="w-20">Environment</th>
                        {{-- <td class="w-80">@if($riskgrdfishbone->environment){{ $riskgrdfishbone->environment }}@else Not Applicable @endif</td> --}}
                            <td class="w-80">
                            @php
                                $environment = unserialize($riskgrdfishbone->environment);
                            @endphp
                            
                            @if(is_array($environment))
                                @foreach($environment as $value)
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
                        {{-- <td class="w-80">@if($riskgrdfishbone->manpower){{ $riskgrdfishbone->manpower }}@else Not Applicable @endif</td> --}}
                            <td class="w-80">
                            @php
                                $manpower = unserialize($riskgrdfishbone->manpower);
                            @endphp
                            
                            @if(is_array($manpower))
                                @foreach($manpower as $value)
                                    {{ htmlspecialchars($value) }}
                                @endforeach
                            @elseif(is_string($manpower))
                                {{ htmlspecialchars($manpower) }}
                            @else
                                Not Applicable
                            @endif
                           </td>
                        <th class="w-20">Machine</th>
                        {{-- <td class="w-80">@if($riskgrdfishbone->machine){{ $riskgrdfishbone->machine }}@else Not Applicable @endif</td> --}}
                          <td class="w-80">
                            @php
                                $machine = unserialize($riskgrdfishbone->machine);
                               // dd($machine);
                            @endphp
                            
                            @if(is_array($machine))
                                @foreach($machine as $value)
                                    {{ htmlspecialchars($value) }}
                                @endforeach
                            @elseif(is_string($machine))
                                {{ htmlspecialchars($machine) }}
                            @else
                                Not Applicable
                            @endif
                          </td>
                    </tr>
                    <tr>
                        <th class="w-20">Problem Statement1</th>
                        <td class="w-80">
                        @if($riskgrdfishbone->problem_statement)
                        
                        {{ $riskgrdfishbone->problem_statement }}
                        @else 
                        Not Applicable
                         @endif</td>
                      
                    </tr> 
             </table>
                        
             <div class="block-head">
                Why-Why Chart 
            </div>
            <table>
            - <tr>
                <th class="w-20">Problem Statement</th>
                <td class="w-80">@if($riskgrdwhy_chart->why_problem_statement){{ $riskgrdwhy_chart->why_problem_statement }}@else Not Applicable @endif</td>
                <th class="w-20">Why 1 </th>
                {{-- <td class="w-80">@if($riskgrdwhy_chart->why_1){{ $riskgrdwhy_chart->why_1 }}@else Not Applicable @endif</td> --}}
                <td class="w-80">
                    @php
                        $why_1 = unserialize($riskgrdwhy_chart->why_1);
                    @endphp
                    
                    @if(is_array($why_1))
                        @foreach($why_1 as $value)
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
                {{-- <td class="w-80">@if($riskgrdwhy_chart->why_2){{ $riskgrdwhy_chart->why_2 }}@else Not Applicable @endif</td> --}}
                <td class="w-80">
                    @php
                        $why_2 = unserialize($riskgrdwhy_chart->why_2);
                    @endphp
                    
                    @if(is_array($why_2))
                        @foreach($why_2 as $value)
                            {{ htmlspecialchars($value) }}
                        @endforeach
                    @elseif(is_string($why_2))
                        {{ htmlspecialchars($why_2) }}
                    @else
                        Not Applicable
                    @endif
                      </td>
                <th class="w-20">Why 3</th>
                {{-- <td class="w-80">@if($riskgrdwhy_chart->why_3){{ $riskgrdwhy_chart->why_3 }}@else Not Applicable @endif</td> --}}
                <td class="w-80">
                    @php
                        $why_3 = unserialize($riskgrdwhy_chart->why_3);
                    @endphp
                    
                    @if(is_array($why_3))
                        @foreach($why_3 as $value)
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
                {{-- <td class="w-80">@if($riskgrdwhy_chart->why_4){{ $riskgrdwhy_chart->why_4 }}@else Not Applicable @endif</td> --}}
                <td class="w-80">
                    @php
                        $why_4 = unserialize($riskgrdwhy_chart->why_4);
                    @endphp
                    
                    @if(is_array($why_4))
                        @foreach($why_4 as $value)
                            {{ htmlspecialchars($value) }}
                        @endforeach
                    @elseif(is_string($why_4))
                        {{ htmlspecialchars($why_4) }}
                    @else
                        Not Applicable
                    @endif
                      </td>
                <th class="w-20">Why5</th>
                {{-- <td class="w-80">@if($riskgrdwhy_chart->why_4){{ $riskgrdwhy_chart->why_4 }}@else Not Applicable @endif</td> --}}
                <td class="w-80">
                    @php
                        $why_5 = unserialize($riskgrdwhy_chart->why_5);
                    @endphp
                    
                    @if(is_array($why_5))
                        @foreach($why_5 as $value)
                            {{ htmlspecialchars($value) }}
                        @endforeach
                    @elseif(is_string($why_5))
                        {{ htmlspecialchars($why_5) }}
                    @else
                        Not Applicable
                    @endif
                      </td>
            </tr>
            <tr>
                <th class="w-20">Root Cause :	</th>
                <td class="w-80">@if($riskgrdwhy_chart->why_root_cause){{ $riskgrdwhy_chart->why_root_cause }}@else Not Applicable @endif</td>
              
            </tr> 
     </table>

<div>     
     <div class="block-head">
        Is/Is Not Analysis
    </div>

    <table>
    <tr>
    <th class="w-20">What Will Be</th>
    <td class="w-80">@if($riskgrdwhat_who_where->what_will_be) {!! nl2br(e($riskgrdwhat_who_where->what_will_be)) !!} @else Not Applicable @endif</td>
    <th class="w-20">What Will Not Be</th>
    <td class="w-80">@if($riskgrdwhat_who_where->what_will_not_be) {!! nl2br(e($riskgrdwhat_who_where->what_will_not_be)) !!} @else Not Applicable @endif</td>
   
   </tr>
    <tr>
    <th class="w-20">What Will Rationale</th>
    <td class="w-80">@if($riskgrdwhat_who_where->what_rationable) {!! nl2br(e($riskgrdwhat_who_where->what_rationable)) !!} @else Not Applicable @endif</td>
    
    <th class="w-20">Where Will Be</th>
    <td class="w-80">@if($riskgrdwhat_who_where->where_will_be) {!! nl2br(e($riskgrdwhat_who_where->where_will_be)) !!} @else Not Applicable @endif</td>
    </tr>
    <tr>

        <th class="w-20">Where Will Not Be</th>
        <td class="w-80">@if($riskgrdwhat_who_where->where_will_not_be) {!! nl2br(e($riskgrdwhat_who_where->where_will_not_be)) !!} @else Not Applicable @endif</td>
        <th class="w-20">Where Will Rationale</th>
        <td class="w-80">@if($riskgrdwhat_who_where->where_rationable) {!! nl2br(e($riskgrdwhat_who_where->where_rationable)) !!} @else Not Applicable @endif</td>
    
    </tr>
    <tr>
        <th class="w-20">When Will Be</th>
        <td class="w-80">@if($riskgrdwhat_who_where->when_will_be) {!! nl2br(e($riskgrdwhat_who_where->when_will_be)) !!} @else Not Applicable @endif</td>
        <th class="w-20">When Will Not Be</th>
        <td class="w-80">@if($riskgrdwhat_who_where->when_will_not_be) {!! nl2br(e($riskgrdwhat_who_where->when_will_not_be)) !!} @else Not Applicable @endif</td>
    </tr>
    <tr> 
        <th class="w-20">When Will Rationale</th>
        <td class="w-80">@if($riskgrdwhat_who_where->when_rationable) {!! nl2br(e($riskgrdwhat_who_where->when_rationable)) !!} @else Not Applicable @endif</td>
   
        <th class="w-20">Coverage Will Be</th>
        <td class="w-80">@if($riskgrdwhat_who_where->coverage_will_be) {!! nl2br(e($riskgrdwhat_who_where->coverage_will_be)) !!} @else Not Applicable @endif</td>
    </tr>
    <tr>   
       
        <th class="w-20">Coverage Will Not Be</th>
        <td class="w-80">@if($riskgrdwhat_who_where->coverage_will_not_be) {!! nl2br(e($riskgrdwhat_who_where->coverage_will_not_be)) !!} @else Not Applicable @endif</td>
    </tr>
    <tr>  
        <th class="w-20">Coverage Will Rationale</th>
        <td class="w-80">@if($riskgrdwhat_who_where->coverage_rationable) {!! nl2br(e($riskgrdwhat_who_where->coverage_rationable)) !!} @else Not Applicable @endif</td>
    </tr>
    <tr>
        <th class="w-20">Who Will Be</th>
        <td class="w-80">@if($riskgrdwhat_who_where->who_will_be) {!! nl2br(e($riskgrdwhat_who_where->who_will_be)) !!} @else Not Applicable @endif</td>
        <th class="w-20">Who Will Not Be</th>
        <td class="w-80">@if($riskgrdwhat_who_where->who_will_not_be) {!! nl2br(e($riskgrdwhat_who_where->who_will_not_be)) !!} @else Not Applicable @endif</td>
    </tr>
    <tr>   
       
        <th class="w-20">Who Will Rationale</th>
        <td class="w-80">@if($riskgrdwhat_who_where->who_rationable) {!! nl2br(e($riskgrdwhat_who_where->who_rationable)) !!} @else Not Applicable @endif</td>
    </tr>
    
    </table>        

 </div>              

            
            <div class="block">
                <div class="head">
                    <div class="block-head">
                     Residual Risk
                    </div>
                    <table>
                    <tr>
                        <th class="w-20">Residual Risk</th>
                        <td class="w-30">@if($data->residual_risk){{ $data->residual_risk }}@else Not Applicable @endif</td>
                        <th class="w-20">Residual Risk Impact</th>
                        <td class="w-30">
                            @if($data->residual_risk_impact)
                            
                                @switch($data->residual_risk_impact)
                                    @case(1)
                                        High
                                        @break
                                    @case(2)
                                        Low
                                        @break
                                    @case(3)
                                        Medium
                                        @break
                                    @case(4)
                                        None
                                        @break
                                    @default
                                        Not Applicable
                                @endswitch
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Residual Risk Probability</th>
                        <td class="w-30">
                            @if($data->residual_risk_probability)
                                @switch($data->residual_risk_probability)
                                    @case(1)
                                        High
                                        @break
                                    @case(2)
                                        Medium
                                        @break
                                    @case(3)
                                        Low
                                        @break
                                    @default
                                        Not Applicable
                                @endswitch
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Residual Detection</th>
                        <td class="w-30">
                        @if ($data->detection2)
                            @switch($data->detection2)
                                @case(5)
                                    Impossible
                                    @break
                            @case(4)
                                    Rare
                                    @break
                            @case(3)
                                    Unlikely
                                    @break
                            @case(2)
                                    Likely
                                    @break
                                @case(1)
                                    Very Likely
                                    @break
                            
                                @default
                                Not Applicable     
                            @endswitch
                            @else
                            Not Applicable  
                        @endif
                        </td>
                        <th class="w-20">Residual RPN</th>
                        <td class="w-30">@if($data->rpn2){{ $data->rpn2 }}@else Not Applicable @endif</td>
                    </tr>                  
                    <tr>
                        <th class="w-20">Comments</th>
                        <td class="w-30">@if($data->comments2){{ $data->comments2 }}@else Not Applicable @endif</td>
                        
                    </tr>
                    
                  </table>
                </div>
            </div>
            <div class="block">
                <div class="head">
                    <div class="block-head">
                      Risk Mitigation
                    </div>
                    <table>
                    <tr>
                        <th class="w-20">Mitigation Required</th>
                        <td class="w-30">@if($data->mitigation_required){{ $data->mitigation_required }}@else Not Applicable @endif</td>
                        <th class="w-20">Mitigation Plan</th>
                        <td class="w-30">@if($data->mitigation_plan){{ $data->mitigation_plan}}@else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">Scheduled End Date</th>
                        <td class="w-30">@if($data->mitigation_due_date){{ $data->mitigation_due_date }}@else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">Status of Mitigation</th>
                        <td class="w-30">@if($data->mitigation_status){{ $data->mitigation_status }}@else Not Applicable @endif</td>
                        <th class="w-20">Mitigation Status Comments</th>
                        <td class="w-30">@if($data->mitigation_status_comments){{ $data->mitigation_status_comments}}@else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">Impact</th>
                        <td class="w-30">@if($data->impact){{ $data->impact }}@else Not Applicable @endif</td>
                        <th class="w-20">Criticality</th>
                        <td class="w-30">@if($data->criticality){{ $data->criticality}}@else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">Impact Analysis</th>
                        <td class="w-80">@if($data->impact_analysis){{ $data->impact_analysis }}@else Not Applicable @endif</td>
                        <th class="w-20">Risk Analysis</th>
                        <td class="w-80">@if($data->risk_analysis){{ $data->risk_analysis}}@else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">Reference Record</th>
                        <td class="w-30">@if($data->refrence_record){{ Helpers::getDivisionName($data->refrence_record) }}/RA/{{ date('Y') }}/{{ Helpers::recordFormat($data->record) }}@else Not Applicable @endif</td>
                        <th class="w-20">Due Date Extension Justification</th>
                        <td class="w-80">@if($data->due_date_extension){{ $data->due_date_extension}}@else Not Applicable @endif</td>
                    </tr>
                  </table>
                </div>
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
                        <td class="w-30">{{ Helpers::getdateFormat($data->submitted_on) }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Evaluated By</th>
                        <td class="w-30">{{ $data->evaluated_by }}</td>
                        <th class="w-20">Evaluated On</th>
                        <td class="w-30">{{ Helpers::getdateFormat($data->evaluated_on) }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Plan Approved By</th>
                        <td class="w-30">{{ $data->plan_approved_by }}</td>
                        <th class="w-20">Plan Approved On</th>
                        <td class="w-30">{{ Helpers::getdateFormat($data->plan_approved_on) }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Risk Analysis Completed By</th>
                        <td class="w-30">{{ $data->risk_analysis_completed_by }}</td>
                        <th class="w-20">Risk Analysis Completed On</th>
                        <td class="w-30">{{ Helpers::getdateFormat($data->risk_analysis_completed_on) }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Cancelled By</th>
                        <td class="w-30">{{ $data->cancelled_by }}</td>
                        <th class="w-20">Cancelled On</th>
                        <td class="w-30">{{ Helpers::getdateFormat($data->cancelled_on) }}</td>
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
                                    {{ Helpers::getDivisionName(session()->get('division')) . "/EC/" . date('Y') . "/" . str_pad($data->record, 4, '0', STR_PAD_LEFT); }}

                                        {{--{{ Helpers::divisionNameForQMS($data->division_id) }}/EC/{{ Helpers::year($data->created_at) }}/{{ str_pad($data->record, 4, '0', STR_PAD_LEFT) }}--}}
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
