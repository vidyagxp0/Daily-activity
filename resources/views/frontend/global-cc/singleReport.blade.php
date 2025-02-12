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
                   Global Change Control Single Report
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
                    <strong> Global Change Control No.</strong>
                </td>
                <td class="w-40">
                    {{ Helpers::getDivisionName($data->division_id) }}/CC/{{ date('Y') }}/{{ $data->record ? str_pad($data->record, 4, '0', STR_PAD_LEFT) : '' }}
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
                            {{ Helpers::getDivisionName($data->division_id) }}/CC/{{ date('Y') }}/{{ $data->record ? str_pad($data->record, 4, '0', STR_PAD_LEFT) : '' }}
                        </td>
                        <th class="w-20">Division Code</th>
                        <td class="w-30">{{ Helpers::getDivisionName($data->division_id) }}</td>
                    </tr>
                    <tr> On {{ Helpers::getDateFormat($data->created_at) }} added by {{ $data->originator }}
                        <th class="w-20">Initiator</th>
                        <td class="w-30">{{ $data->originator }}</td>
                        <th class="w-20">Date Initiation</th>
                        <td class="w-30">{{ Helpers::getDateFormat($data->intiation_date) }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Due Date</th>
                        <td class="w-30">
                            @if ($data->due_date)
                                {{ $data->due_date }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Initiaton Department</th>
                        <td class="w-30">
                            @if ($data->Initiator_Group)
                                {{ Helpers::getFullDepartmentName($data->Initiator_Group) }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">Initiation Department Code</th>
                        <td class="w-30">
                            @if ($data->initiator_group_code)
                                {{ $data->initiator_group_code }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Risk Assessment Required</th>
                        <td class="w-30">
                            @if ($data->risk_assessment_required)
                                {{ $data->risk_assessment_required }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                </table>

                {{-- <label class="head-number" for="Justification">Justification</label>
                <div class="div-data">
                    @if ($data->risk_identification)
                        {{ $data->risk_identification }}
                    @else
                        Not Applicable
                    @endif
                </div> --}}

                <table>
                    <tr>
                        <th class="w-20">HOD Person</th>
                        <td class="w-80">
                            @if ($data->hod_person)
                                {{ Helpers::getInitiatorName($data->hod_person) }}
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


                {{-- <table>
                    <tr>
                        <th class="w-20">Type Of Change</th>
                        <td class="w-80">
                            @if ($data->type_of_change)
                                {{ $data->type_of_change }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                </table> --}}

                <label class="head-number" for="Validation Requirement">Validation Requirement</label>
                <div class="div-data">
                    @if ($data->validation_requirment)
                        {{ $data->validation_requirment }}
                    @else
                        Not Applicable
                    @endif
                </div>

                <table>
                    <tr>
                        <th class="w-20">Product/Material</th>
                        <td class="w-80">
                            @if ($data->product_name)
                                {{ $data->product_name }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <th class="w-20">Priority</th>
                        <td class="w-30">
                            @if ($data->priority_data)
                                {{ $data->priority_data }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">Change Related To</th>
                        <td class="w-30">
                            @if ($data->severity)
                                {{ $data->severity }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                </table>

                <label class="head-number" for="Please specify">Please specify</label>
                <div class="div-data">
                    @if ($data->Occurance)
                        {{ $data->Occurance }}
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
                    </tr>
                </table>

                <label class="head-number" for="Others">Others</label>
                <div class="div-data">
                    @if ($data->initiated_through_req)
                        {{ $data->initiated_through_req }}
                    @else
                        Not Applicable
                    @endif
                </div>

                <table>
                    <tr>
                        <th class="w-20">Repeat</th>
                        <td class="w-30">
                            @if ($data->repeat)
                                {{ $data->repeat }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                </table>

                <label class="head-number" for="Repeat Nature">Repeat Nature</label>
                <div class="div-data">
                    @if ($data->repeat_nature)
                        {{ $data->repeat_nature }}
                    @else
                        Not Applicable
                    @endif
                </div>

                <table>
                    <tr>
                        <th class="w-20">Nature of Change</th>
                        <td class="w-30">
                            @if ($data->doc_change)
                                {{ $data->doc_change }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                </table>

                <label class="head-number" for="If Others">If Others</label>
                <div class="div-data">
                    @if ($data->If_Others)
                        {{ $data->If_Others }}
                    @else
                        Not Applicable
                    @endif
                </div>

                <div class="border-table">
                    <div class="block-head">
                        Initial Attachment
                    </div>
                    <table>

                        <tr class="table_bg">
                            <th class="w-20">S.N.</th>
                            <th class="w-60">Attachment</th>
                        </tr>
                        @if ($data->in_attachment)
                            @foreach (json_decode($data->in_attachment) as $key => $file)
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
                    Risk Assessment
                </div>

                <label class="head-number" for="Related Records">Related Records</label>
                <div class="div-data">
                    @if ($data->risk_assessment_related_record)
                        {{ str_replace(',', ', ', $data->risk_assessment_related_record) }}
                    @else
                        Not Applicable
                    @endif
                </div>

                <table>
                    <tr>
                        <th class="w-20">comments</th>
                        <td class="w-80" colspan="3">
                            @if ($data->migration_action)
                                {{ $data->migration_action }}
                            @else
                                Not Applicable
                            @endif

                        </td>
                    </tr>
                </table>

                <div class="border-table">
                    <div class="block-head">
                        Risk Assessment Attachment
                    </div>
                    <table>

                        <tr class="table_bg">
                            <th class="w-20">S.N.</th>
                            <th class="w-60">Attachment</th>
                        </tr>
                        @if ($data->risk_assessment_atch)
                            @foreach (json_decode($data->risk_assessment_atch) as $key => $file)
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
                    Initial HOD Review
                </div>

                <label class="head-number" for="HOD Assessment Comments">HOD Assessment Comments</label>
                <div class="div-data">
                    @if ($data->hod_assessment_comments)
                        {{ $data->hod_assessment_comments }}
                    @else
                        Not Applicable
                    @endif
                </div>

                <div class="border-table">
                    <div class="block-head">
                        HOD Assessment Attachments
                    </div>
                    <table>

                        <tr class="table_bg">
                            <th class="w-20">S.N.</th>
                            <th class="w-60">Attachment</th>
                        </tr>
                        @if ($data->hod_assessment_attachment)
                            @foreach (json_decode($data->hod_assessment_attachment) as $key => $file)
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
                    Change Details
                </div>

                <label class="head-number" for="Current Practice">Current Practice</label>
                <div class="div-data">
                    @if ($data->current_practice)
                        {{ $data->current_practice }}
                    @else
                        Not Applicable
                    @endif
                </div>

                <label class="head-number" for="Proposed Change">Proposed Change</label>
                <div class="div-data">
                    @if ($data->proposed_change)
                        {{ $data->proposed_change }}
                    @else
                        Not Applicable
                    @endif
                </div>

                <label class="head-number" for="Reason For Change">Reason For Change</label>
                <div class="div-data">
                    @if ($data->reason_change)
                        {{ $data->reason_change }}
                    @else
                        Not Applicable
                    @endif
                </div>

                <label class="head-number" for="Any Other Comments">Any Other Comments</label>
                <div class="div-data">
                    @if ($data->other_comment)
                        {{ $data->other_comment }}
                    @else
                        Not Applicable
                    @endif
                </div>


            </div>

            <div class="block">
                <div class="block-head">
                    QA/CQA Review
                </div>
                <table>

                    <tr>
                        {{-- <th class="w-20">CFT Reviewer Person</th>
                            <td class="w-30">{{ $data->due_days }}</td> --}}


                        <th class="w-20">Classification of Change</th>
                        <td class="w-80">
                            @if ($data->severity_level1)
                                {{ $data->severity_level1 }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                </table>

                <label class="head-number" for="QA Initial Review Comments">QA Initial Review Comments</label>
                <div class="div-data">
                    @if ($data->qa_review_comments)
                        {{$data->qa_review_comments }}
                    @else
                        Not Applicable
                    @endif
                </div>

                <label class="head-number" for="Related Records">Related Records</label>
                <div class="div-data">
                    @if ($data->related_records)
                        {{ $data->initiated_if_other }}
                        {{ str_replace(',', ', ', $data->related_records) }}
                    @else
                        Not Applicable
                    @endif
                </div>


                {{-- <tr>
                            <th class="w-20">Related Records</th>
                            <td class="w-80">
                                {{ Helpers::getDivisionName($data->division_id) }}/CC/{{ date('Y') }}/{{ str_pad($review->related_records, 4, '0', STR_PAD_LEFT) }}
                            </td>
                        </tr> --}}

                <div class="border-table">
                    <div class="block-head">
                        QA Attachments
                    </div>
                    <table>

                        <tr class="table_bg">
                            <th class="w-20">S.N.</th>
                            <th class="w-60">Attachment</th>
                        </tr>
                        @if ($data->qa_head)
                            @foreach (json_decode($data->qa_head) as $key => $file)
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
                <div class="head">
                    <div class="block-head">
                        CFT
                    </div>
                </div>
            </div>

            <div class="head">
                <div class="block-head">
                    Production
                </div>
                <table>
                    <tr>
                        <th class="w-20">Production Required ?
                        </th>
                        <td class="w-30">
                            <div>
                                @if ($cftData->Production_Review)
                                    {{ $cftData->Production_Review }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </td>
                        <th class="w-20">Production Person</th>
                        <td class="w-30">
                            <div>
                                @if ($cftData->Production_person)
                                    {{ Helpers::getInitiatorName($cftData->Production_person) }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Impact Assessment (By Production)</th>
                        <td class="w-30">
                            <div>
                                @if ($cftData->Production_assessment)
                                    {{ $cftData->Production_assessment }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </td>
                        <th class="w-20">Production Feedback</th>
                        <td class="w-30">
                            <div>
                                @if ($cftData->Production_feedback)
                                    {{ $cftData->Production_feedback }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Production Completed By</th>
                        <td class="w-30">
                            <div>
                                @if ($cftData->Production_by)
                                    {{ $cftData->Production_by }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </td>
                        <th class="w-20">Production Completed On</th>
                        <td class="w-30">
                            <div>
                                @if ($cftData->production_on)
                                    {{ $cftData->production_on }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="border-table">
                <div class="block-head">
                    Production Attachments
                </div>
                <table>

                    <tr class="table_bg">
                        <th class="w-20">S.N.</th>
                        <th class="w-60">Attachment</th>
                    </tr>
                    @if ($cftData->production_attachment)
                        @foreach (json_decode($cftData->production_attachment) as $key => $file)
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

            
            <div class="block">
                <div class="head">
                    <div class="block-head">
                        Quality Control
                    </div>
                    <table>

                        <tr>

                            <th class="w-20">Quality Control Review Required ?
                            </th>
                            <td class="w-30">
                                <div>
                                    @if ($cftData->Quality_review)
                                        {{ $cftData->Quality_review }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                            <th class="w-20">Quality Control Person</th>
                            <td class="w-30">
                                <div>
                                    @if ($cftData->Quality_Control_Person)
                                        {{ $cftData->Quality_Control_Person }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                        </tr>

                        <tr>

                            <th class="w-20">Impact Assessment (By Quality Control)</th>
                            <td class="w-30">
                                <div>
                                    @if ($cftData->Quality_Control_assessment)
                                        {{ $cftData->Quality_Control_assessment }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                            <th class="w-20">Quality Control Feedback</th>
                            <td class="w-30">
                                <div>
                                    @if ($cftData->Quality_Control_feedback)
                                        {{ $cftData->Quality_Control_feedback }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                        </tr>
                        <tr>

                            <th class="w-20">Quality Review Completed By</th>
                            <td class="w-30">
                                <div>
                                    @if ($cftData->Quality_Control_by)
                                        {{ $cftData->Quality_Control_by }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                            <th class="w-20">Quality Review Completed On</th>
                            <td class="w-30">
                                <div>
                                    @if ($cftData->Quality_Control_on)
                                        {{ $cftData->Quality_Control_on }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="border-table">
                    <div class="block-head">
                        Quality Control Attachments
                    </div>
                    <table>

                        <tr class="table_bg">
                            <th class="w-20">S.N.</th>
                            <th class="w-60">Attachment</th>
                        </tr>
                        @if ($cftData->Quality_Control_attachment)
                            @foreach (json_decode($cftData->Quality_Control_attachment) as $key => $file)
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
                <div class="head">
                    <div class="block-head">
                        Warehouse
                    </div>
                    <table>

                        <tr>

                            <th class="w-20">Warehouse Review Required ?
                            </th>
                            <td class="w-30">
                                <div>
                                    @if ($cftData->Warehouse_review)
                                        {{ $cftData->Warehouse_review }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                            <th class="w-20">Warehouse Person</th>
                            <td class="w-30">
                                <div>
                                    @if ($cftData->Warehouse_person)
                                        {{ $cftData->Warehouse_person }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                        </tr>

                        <tr>

                            <th class="w-20">Impact Assessment (By Warehouse)</th>
                            <td class="w-30">
                                <div>
                                    @if ($cftData->Warehouse_assessment)
                                        {{ $cftData->Warehouse_assessment }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                            <th class="w-20">Warehouse Feedback</th>
                            <td class="w-30">
                                <div>
                                    @if ($cftData->Warehouse_feedback)
                                        {{ $cftData->Warehouse_feedback }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                        </tr>
                        <tr>

                            <th class="w-20">Warehouse Review Completed By</th>
                            <td class="w-30">
                                <div>
                                    @if ($cftData->Warehouse_by)
                                        {{ $cftData->Warehouse_by }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                            <th class="w-20">Warehouse Review Completed On</th>
                            <td class="w-30">
                                <div>
                                    @if ($cftData->Warehouse_on)
                                        {{ $cftData->Warehouse_on }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="border-table">
                    <div class="block-head">
                        Warehouse Attachments
                    </div>
                    <table>

                        <tr class="table_bg">
                            <th class="w-20">S.N.</th>
                            <th class="w-60">Attachment</th>
                        </tr>
                        @if ($cftData->Warehouse_attachment)
                            @foreach (json_decode($cftData->Warehouse_attachment) as $key => $file)
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
                <div class="head">
                    <div class="block-head">
                        Engineering
                    </div>
                    <table>
                        <tr>
                            <th class="w-20">Engineering Review Required ?
                            </th>
                            <td class="w-30">
                                <div>
                                    @if ($cftData->Engineering_review)
                                        {{ $cftData->Engineering_review }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                            <th class="w-20">Engineering Person</th>
                            <td class="w-30">
                                <div>
                                    @if ($cftData->Engineering_person)
                                        {{ $cftData->Engineering_person }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                        </tr>

                        <tr>

                            <th class="w-20">Impact Assessment (By Engineering)</th>
                            <td class="w-30">
                                <div>
                                    @if ($cftData->Engineering_assessment)
                                        {{ $cftData->Engineering_assessment }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                            <th class="w-20">Engineering Feedback</th>
                            <td class="w-30">
                                <div>
                                    @if ($cftData->Engineering_feedback)
                                        {{ $cftData->Engineering_feedback }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                        </tr>
                        <tr>

                            <th class="w-20">Engineering Review Completed By</th>
                            <td class="w-30">
                                <div>
                                    @if ($cftData->Engineering_by)
                                        {{ $cftData->Engineering_by }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                            <th class="w-20"> Engineering Review Completed On</th>
                            <td class="w-30">
                                <div>
                                    @if ($cftData->Engineering_on)
                                        {{ $cftData->Engineering_on }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="border-table">
                    <div class="block-head">
                        Engineering Attachments
                    </div>
                    <table>

                        <tr class="table_bg">
                            <th class="w-20">S.N.</th>
                            <th class="w-60">Attachment</th>
                        </tr>
                        @if ($cftData->Engineering_attachment)
                            @foreach (json_decode($cftData->Engineering_attachment) as $key => $file)
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

            <div class="head">
                <div class="block-head">
                    Research & Development
                </div>
                <table>
                    <tr>
                        <th class="w-20">Research & Development Required ?
                        </th>
                        <td class="w-30">
                            <div>
                                @if ($cftData->ResearchDevelopment_Review)
                                    {{ $cftData->ResearchDevelopment_Review }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </td>
                        <th class="w-20">Research & Development Person</th>
                        <td class="w-30">
                            <div>
                                @if ($cftData->ResearchDevelopment_person)
                                    {{ $cftData->ResearchDevelopment_person }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Impact Assessment (By Research & Development)</th>
                        <td class="w-30">
                            <div>
                                @if ($cftData->ResearchDevelopment_assessment)
                                    {{ $cftData->ResearchDevelopment_assessment }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </td>
                        <th class="w-20">Research & Development Feedback</th>
                        <td class="w-30">
                            <div>
                                @if ($cftData->ResearchDevelopment_feedback)
                                    {{ $cftData->ResearchDevelopment_feedback }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Research & Development Completed By</th>
                        <td class="w-30">
                            <div>
                                @if ($cftData->ResearchDevelopment_by)
                                    {{ $cftData->ResearchDevelopment_by }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </td>
                        <th class="w-20">Research & Development Completed On</th>
                        <td class="w-30">
                            <div>
                                @if ($cftData->ResearchDevelopment_on)
                                    {{ $cftData->ResearchDevelopment_on }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="border-table">
                <div class="block-head">
                    Research & Development Attachments
                </div>
                <table>

                    <tr class="table_bg">
                        <th class="w-20">S.N.</th>
                        <th class="w-60">Attachment</th>
                    </tr>
                    @if ($cftData->ResearchDevelopment_attachment)
                        @foreach (json_decode($cftData->ResearchDevelopment_attachment) as $key => $file)
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

            
            <div class="head">
                <div class="block-head">
                    Regulatory Affairs
                </div>
                <table>
                    <tr>
                        <th class="w-20">Regulatory Affairs Required ?
                        </th>
                        <td class="w-30">
                            <div>
                                @if ($cftData->RegulatoryAffair_Review)
                                    {{ $cftData->RegulatoryAffair_Review }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </td>
                        <th class="w-20">Regulatory Affairs Person</th>
                        <td class="w-30">
                            <div>
                                @if ($cftData->RegulatoryAffair_person)
                                    {{ $cftData->RegulatoryAffair_person }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Impact Assessment (By Regulatory Affairs)</th>
                        <td class="w-30">
                            <div>
                                @if ($cftData->RegulatoryAffair_assessment)
                                    {{ $cftData->RegulatoryAffair_assessment }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </td>
                        <th class="w-20">Regulatory Affairs Feedback</th>
                        <td class="w-30">
                            <div>
                                @if ($cftData->RegulatoryAffair_feedback)
                                    {{ $cftData->RegulatoryAffair_feedback }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Regulatory Affairs Completed By</th>
                        <td class="w-30">
                            <div>
                                @if ($cftData->RegulatoryAffair_by)
                                    {{ $cftData->RegulatoryAffair_by }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </td>
                        <th class="w-20">Regulatory Affairs Completed On</th>
                        <td class="w-30">
                            <div>
                                @if ($cftData->RegulatoryAffair_on)
                                    {{ $cftData->RegulatoryAffair_on }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="border-table">
                <div class="block-head">
                    Regulatory Affairs Attachments
                </div>
                <table>

                    <tr class="table_bg">
                        <th class="w-20">S.N.</th>
                        <th class="w-60">Attachment</th>
                    </tr>
                    @if ($cftData->RegulatoryAffair_attachment)
                        @foreach (json_decode($cftData->RegulatoryAffair_attachment) as $key => $file)
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

            
            <div class="head">
                <div class="block-head">
                    Corporate Quality Assurance
                </div>
                <table>
                    <tr>
                        <th class="w-20">Corporate Quality Assurance Required ?
                        </th>
                        <td class="w-30">
                            <div>
                                @if ($cftData->CQA_Review)
                                    {{ $cftData->CQA_Review }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </td>
                        <th class="w-20">Corporate Quality Assurance Person</th>
                        <td class="w-30">
                            <div>
                                @if ($cftData->CQA_person)
                                    {{ $cftData->CQA_person }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Impact Assessment (By Corporate Quality Assurance)</th>
                        <td class="w-30">
                            <div>
                                @if ($cftData->CorporateQualityAssurance_assessment)
                                    {{ $cftData->CorporateQualityAssurance_assessment }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </td>
                        <th class="w-20">Corporate Quality Assurance Feedback</th>
                        <td class="w-30">
                            <div>
                                @if ($cftData->CorporateQualityAssurance_feedback)
                                    {{ $cftData->CorporateQualityAssurance_feedback }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Corporate Quality Assurance Completed By</th>
                        <td class="w-30">
                            <div>
                                @if ($cftData->CQA_by)
                                    {{ $cftData->CQA_by }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </td>
                        <th class="w-20">Corporate Quality Assurance Completed On</th>
                        <td class="w-30">
                            <div>
                                @if ($cftData->CQA_on)
                                    {{ $cftData->CQA_on }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="border-table">
                <div class="block-head">
                    Corporate Quality Assurance Attachments
                </div>
                <table>

                    <tr class="table_bg">
                        <th class="w-20">S.N.</th>
                        <th class="w-60">Attachment</th>
                    </tr>
                    @if ($cftData->CQA_attachment)
                        @foreach (json_decode($cftData->CQA_attachment) as $key => $file)
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

            
            <div class="head">
                <div class="block-head">
                    Microbiology
                </div>
                <table>
                    <tr>
                        <th class="w-20">Microbiology Required ?
                        </th>
                        <td class="w-30">
                            <div>
                                @if ($cftData->Microbiology_Review)
                                    {{ $cftData->Microbiology_Review }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </td>
                        <th class="w-20">Microbiology Person</th>
                        <td class="w-30">
                            <div>
                                @if ($cftData->Microbiology_person)
                                    {{ $cftData->Microbiology_person }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Impact Assessment (By Microbiology)</th>
                        <td class="w-30">
                            <div>
                                @if ($cftData->Microbiology_assessment)
                                    {{ $cftData->Microbiology_assessment }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </td>
                        <th class="w-20">Microbiology Feedback</th>
                        <td class="w-30">
                            <div>
                                @if ($cftData->Microbiology_feedback)
                                    {{ $cftData->Microbiology_feedback }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Microbiology Completed By</th>
                        <td class="w-30">
                            <div>
                                @if ($cftData->Microbiology_by)
                                    {{ $cftData->Microbiology_by }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </td>
                        <th class="w-20">Microbiology Completed On</th>
                        <td class="w-30">
                            <div>
                                @if ($cftData->Microbiology_on)
                                    {{ $cftData->Microbiology_on }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="border-table">
                <div class="block-head">
                    Microbiology Attachments
                </div>
                <table>

                    <tr class="table_bg">
                        <th class="w-20">S.N.</th>
                        <th class="w-60">Attachment</th>
                    </tr>
                    @if ($cftData->Microbiology_attachment)
                        @foreach (json_decode($cftData->Microbiology_attachment) as $key => $file)
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

            <div class="block">
                <div class="head">
                    <div class="block-head">
                        System IT

                    </div>
                    <table>

                        <tr>

                            <th class="w-20">System IT Review Required ?
                            </th>
                            <td class="w-30">
                                <div>
                                    @if ($cftData->SystemIT_Review)
                                        {{ $cftData->SystemIT_Review }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                            <th class="w-20">System IT Person</th>
                            <td class="w-30">
                                <div>
                                    @if ($cftData->SystemIT_person)
                                        {{ $cftData->SystemIT_person }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <th class="w-20">System IT Comment</th>
                            <td class="w-80">
                                <div>
                                    @if ($cftData->SystemIT_comment)
                                        {{ $cftData->SystemIT_comment }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                        </tr>
                        
                        <tr>

                            <th class="w-20">System IT Review Completed By</th>
                            <td class="w-30">
                                <div>
                                    @if ($cftData->Information_Technology_by)
                                        {{ $cftData->Information_Technology_by }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                            <th class="w-20"> System IT Review Completed On</th>
                            <td class="w-30">
                                <div>
                                    @if ($cftData->Information_Technology_on)
                                        {{ $cftData->Information_Technology_on }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="border-table">
                    <div class="block-head">
                        System IT Attachments
                    </div>
                    <table>

                        <tr class="table_bg">
                            <th class="w-20">S.N.</th>
                            <th class="w-60">Attachment</th>
                        </tr>
                        @if ($cftData->Information_Technology_attachment)
                            @foreach (json_decode($cftData->Information_Technology_attachment) as $key => $file)
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


            <div class="head">
                <div class="block-head">
                    Quality Assurance
                </div>
                <table>
                    <tr>
                        <th class="w-20">Quality Assurance Required ?
                        </th>
                        <td class="w-30">
                            <div>
                                @if ($cftData->Quality_Assurance_Review)
                                    {{ $cftData->Quality_Assurance_Review }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </td>
                        <th class="w-20">Quality Assurance Person</th>
                        <td class="w-30">
                            <div>
                                @if ($cftData->QualityAssurance_person)
                                    {{ $cftData->QualityAssurance_person }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Impact Assessment (By Quality Assurance)</th>
                        <td class="w-30">
                            <div>
                                @if ($cftData->QualityAssurance_assessment)
                                    {{ $cftData->QualityAssurance_assessment }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </td>
                        <th class="w-20">Quality Assurance Feedback</th>
                        <td class="w-30">
                            <div>
                                @if ($cftData->QualityAssurance_feedback)
                                    {{ $cftData->QualityAssurance_feedback }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Quality Assurance Completed By</th>
                        <td class="w-30">
                            <div>
                                @if ($cftData->QualityAssurance_by)
                                    {{ $cftData->QualityAssurance_by }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </td>
                        <th class="w-20">Quality Assurance Completed On</th>
                        <td class="w-30">
                            <div>
                                @if ($cftData->QualityAssurance_on)
                                    {{ $cftData->QualityAssurance_on }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="border-table">
                <div class="block-head">
                    Quality Assurance Attachments
                </div>
                <table>

                    <tr class="table_bg">
                        <th class="w-20">S.N.</th>
                        <th class="w-60">Attachment</th>
                    </tr>
                    @if ($cftData->Quality_Assurance_attachment)
                        @foreach (json_decode($cftData->Quality_Assurance_attachment) as $key => $file)
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

            

            
            <div class="block">
                <div class="head">
                    <div class="block-head">
                        Human Resource
                    </div>
                    <table>
                        <tr>
                            <th class="w-20">Human Resource Review Required ?
                            </th>
                            <td class="w-30">
                                <div>
                                    @if ($cftData->Human_Resource_review)
                                        {{ $cftData->Human_Resource_review }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                            <th class="w-20">Human Resource Person</th>
                            <td class="w-30">
                                <div>
                                    @if ($cftData->Human_Resource_person)
                                        {{ $cftData->Human_Resource_person }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                        </tr>

                        <tr>

                            <th class="w-20">Impact Assessment (By Human Resource)</th>
                            <td class="w-30">
                                <div>
                                    @if ($cftData->Human_Resource_assessment)
                                        {{ $cftData->Human_Resource_assessment }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                            <th class="w-20">Human Resource Feedback</th>
                            <td class="w-30">
                                <div>
                                    @if ($cftData->Human_Resource_feedback)
                                        {{ $cftData->Human_Resource_feedback }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                        </tr>
                        <tr>

                            <th class="w-20">Human Resource Review Completed By</th>
                            <td class="w-30">
                                <div>
                                    @if ($cftData->Human_Resource_by)
                                        {{ $cftData->production_by }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                            <th class="w-20"> Human Resource Review Completed On</th>
                            <td class="w-30">
                                <div>
                                    @if ($cftData->production_on)
                                        {{ $cftData->production_on }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="border-table">
                    <div class="block-head">
                        Human Resource Attachments
                    </div>
                    <table>

                        <tr class="table_bg">
                            <th class="w-20">S.N.</th>
                            <th class="w-60">Attachment</th>
                        </tr>
                        @if ($cftData->Initial_attachment)
                            @foreach (json_decode($cftData->Initial_attachment) as $key => $file)
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
                <div class="head">
                    <div class="block-head">
                        Other's 1 ( Additional Person Review From Departments If Required)
                    </div>
                    <table>

                        <tr>

                            <th class="w-20">Other's 1 Review Required ?
                            </th>
                            <td class="w-30">
                                <div>
                                    @if ($cftData->Other1_review)
                                        {{ $cftData->Other1_review }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                            <th class="w-20">Other's 1 Person</th>
                            <td class="w-30">
                                <div>
                                    @if ($cftData->Other1_person)
                                        {{ $cftData->Other1_person }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                            <th class="w-20">Other's 1 Department</th>
                            <td class="w-30">
                                <div>
                                    @if ($cftData->Other1_Department_person)
                                        {{ $cftData->Other1_Department_person }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                        </tr>

                        <tr>

                            <th class="w-20">Impact Assessment (By Other's 1)</th>
                            <td class="w-30">
                                <div>
                                    @if ($cftData->Other1_assessment)
                                        {{ $cftData->Other1_assessment }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                            <th class="w-20">Other's 1 Feedback</th>
                            <td class="w-30">
                                <div>
                                    @if ($cftData->Other1_feedback)
                                        {{ $cftData->Other1_feedback }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                        </tr>
                        <tr>

                            <th class="w-20">Other's 1 Review Completed By</th>
                            <td class="w-30">
                                <div>
                                    @if ($cftData->Other1_by)
                                        {{ $cftData->Other1_by }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                            <th class="w-20"> Other's 1 Review Completed On</th>
                            <td class="w-30">
                                <div>
                                    @if ($cftData->Other1_on)
                                        {{ $cftData->Other1_on }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="border-table">
                    <div class="block-head">
                        Other's 1 Attachments
                    </div>
                    <table>

                        <tr class="table_bg">
                            <th class="w-20">S.N.</th>
                            <th class="w-60">Attachment</th>
                        </tr>
                        @if ($cftData->Other1_attachment)
                            @foreach (json_decode($cftData->Other1_attachment) as $key => $file)
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
                <div class="head">
                    <div class="block-head">
                        Other's 2 ( Additional Person Review From Departments If Required)
                    </div>
                    <table>

                        <tr>

                            <th class="w-20">Other's 2 Review Required ?
                            </th>
                            <td class="w-30">
                                <div>
                                    @if ($cftData->Other2_review)
                                        {{ $cftData->Other2_review }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                            <th class="w-20">Other's 2 Person</th>
                            <td class="w-30">
                                <div>
                                    @if ($cftData->Other2_person)
                                        {{ $cftData->Other2_person }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                            <th class="w-20">Other's 2 Department</th>
                            <td class="w-30">
                                <div>
                                    @if ($cftData->Other2_Department_person)
                                        {{ $cftData->Other2_Department_person }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                        </tr>

                        <tr>

                            <th class="w-20">Impact Assessment (By Other's 2)</th>
                            <td class="w-30">
                                <div>
                                    @if ($cftData->Other2_assessment)
                                        {{ $cftData->Other2_assessment }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                            <th class="w-20">Other's 2 Feedback</th>
                            <td class="w-30">
                                <div>
                                    @if ($cftData->Other2_feedback)
                                        {{ $cftData->Other2_feedback }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                        </tr>
                        <tr>

                            <th class="w-20">Other's 2 Review Completed By</th>
                            <td class="w-30">
                                <div>
                                    @if ($cftData->Other2_by)
                                        {{ $cftData->Other2_by }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                            <th class="w-20"> Other's 2 Review Completed On</th>
                            <td class="w-30">
                                <div>
                                    @if ($cftData->Other2_on)
                                        {{ $cftData->Other2_on }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="border-table">
                    <div class="block-head">
                        Other's 2 Attachments
                    </div>
                    <table>

                        <tr class="table_bg">
                            <th class="w-20">S.N.</th>
                            <th class="w-60">Attachment</th>
                        </tr>
                        @if ($cftData->Other2_attachment)
                            @foreach (json_decode($cftData->Other2_attachment) as $key => $file)
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
                <div class="head">
                    <div class="block-head">
                        Other's 3 ( Additional Person Review From Departments If Required)
                    </div>
                    <table>

                        <tr>

                            <th class="w-20">Other's 3 Review Required ?
                            </th>
                            <td class="w-30">
                                <div>
                                    @if ($cftData->Other3_review)
                                        {{ $cftData->Other3_review }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                            <th class="w-20">Other's 3 Person</th>
                            <td class="w-30">
                                <div>
                                    @if ($cftData->Other3_person)
                                        {{ $cftData->Other3_person }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                            <th class="w-20">Other's 3 Department</th>
                            <td class="w-30">
                                <div>
                                    @if ($cftData->Other3_Department_person)
                                        {{ $cftData->Other3_Department_person }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                        </tr>

                        <tr>

                            <th class="w-20">Impact Assessment (By Other's 3)</th>
                            <td class="w-30">
                                <div>
                                    @if ($cftData->Other3_assessment)
                                        {{ $cftData->Other3_assessment }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                            <th class="w-20">Other's 3 Feedback</th>
                            <td class="w-30">
                                <div>
                                    @if ($cftData->Other3_feedback)
                                        {{ $cftData->Other3_feedback }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                        </tr>
                        <tr>

                            <th class="w-20">Other's 3 Review Completed By</th>
                            <td class="w-30">
                                <div>
                                    @if ($cftData->Other3_by)
                                        {{ $cftData->Other3_by }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                            <th class="w-20"> Other's 3 Review Completed On</th>
                            <td class="w-30">
                                <div>
                                    @if ($cftData->Other3_on)
                                        {{ $cftData->Other3_on }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="border-table">
                    <div class="block-head">
                        Other's 3 Attachments
                    </div>
                    <table>

                        <tr class="table_bg">
                            <th class="w-20">S.N.</th>
                            <th class="w-60">Attachment</th>
                        </tr>
                        @if ($cftData->Other3_attachment)
                            @foreach (json_decode($cftData->Other3_attachment) as $key => $file)
                                <tr>
                                    <td class="w-20">{{ $key + 1 }}</td>
                                    <td class="w-20"><a href="{{ asset('upload/' . $file) }}"
                                            target="_blank"><b>{{ $file }}</b></a> </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td class="w-20">4</td>
                                <td class="w-20">Not Applicable</td>
                            </tr>
                        @endif

                    </table>
                </div>
            </div>

            <div class="block">
                <div class="head">
                    <div class="block-head">
                        Other's 4 ( Additional Person Review From Departments If Required)
                    </div>
                    <table>

                        <tr>

                            <th class="w-20">Other's 4 Review Required ?
                            </th>
                            <td class="w-30">
                                <div>
                                    @if ($cftData->Other4_review)
                                        {{ $cftData->Other4_review }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                            <th class="w-20">Other's 4 Person</th>
                            <td class="w-30">
                                <div>
                                    @if ($cftData->Other4_person)
                                        {{ $cftData->Other4_person }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                            <th class="w-20">Other's 4 Department</th>
                            <td class="w-30">
                                <div>
                                    @if ($cftData->Other4_Department_person)
                                        {{ $cftData->Other4_Department_person }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                        </tr>

                        <tr>

                            <th class="w-20">Impact Assessment (By Other's 4)</th>
                            <td class="w-30">
                                <div>
                                    @if ($cftData->Other4_assessment)
                                        {{ $cftData->Other4_assessment }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                            <th class="w-20">Other's 4 Feedback</th>
                            <td class="w-30">
                                <div>
                                    @if ($cftData->Other4_feedback)
                                        {{ $cftData->Other4_feedback }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                        </tr>
                        <tr>

                            <th class="w-20">Other's 4 Review Completed By</th>
                            <td class="w-30">
                                <div>
                                    @if ($cftData->Other4_by)
                                        {{ $cftData->Other4_by }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                            <th class="w-20"> Other's 4 Review Completed On</th>
                            <td class="w-30">
                                <div>
                                    @if ($cftData->Other4_on)
                                        {{ $cftData->Other4_on }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="border-table">
                    <div class="block-head">
                        Other's 4 Attachments
                    </div>
                    <table>

                        <tr class="table_bg">
                            <th class="w-20">S.N.</th>
                            <th class="w-60">Attachment</th>
                        </tr>
                        @if ($cftData->Other4_attachment)
                            @foreach (json_decode($cftData->Other4_attachment) as $key => $file)
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
                <div class="head">
                    <div class="block-head">
                        Other's 5 ( Additional Person Review From Departments If Required)
                    </div>
                    <table>

                        <tr>

                            <th class="w-20">Other's 5 Review Required ?
                            </th>
                            <td class="w-30">
                                <div>
                                    @if ($cftData->Other5_review)
                                        {{ $cftData->Other5_review }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                            <th class="w-20">Other's 5 Person</th>
                            <td class="w-30">
                                <div>
                                    @if ($cftData->Other5_person)
                                        {{ $cftData->Other5_person }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                            <th class="w-20">Other's 5 Department</th>
                            <td class="w-30">
                                <div>
                                    @if ($cftData->Other5_Department_person)
                                        {{ $cftData->Other5_Department_person }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                        </tr>

                        <tr>

                            <th class="w-20">Impact Assessment (By Other's 5)</th>
                            <td class="w-30">
                                <div>
                                    @if ($cftData->Other5_assessment)
                                        {{ $cftData->Other5_assessment }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                            <th class="w-20">Other's 5 Feedback</th>
                            <td class="w-30">
                                <div>
                                    @if ($cftData->Other5_feedback)
                                        {{ $cftData->Other5_feedback }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                        </tr>
                        <tr>

                            <th class="w-20">Other's 5 Review Completed By</th>
                            <td class="w-30">
                                <div>
                                    @if ($cftData->Other5_by)
                                        {{ $cftData->Other5_by }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                            <th class="w-20"> Other's 5 Review Completed On</th>
                            <td class="w-30">
                                <div>
                                    @if ($cftData->Other5_on)
                                        {{ $cftData->Other5_on }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>

                <div class="border-table">
                    <div class="block-head">
                        Other's 5 Attachments
                    </div>
                    <table>

                        <tr class="table_bg">
                            <th class="w-20">S.N.</th>
                            <th class="w-60">Attachment</th>
                        </tr>
                        @if ($cftData->Other5_attachment)
                            @foreach (json_decode($cftData->Other5_attachment) as $key => $file)
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
                <table>
                    <tr>
                        <th class="w-20">RA Head Person</th>
                        <td class="w-30">
                            <div>
                                @if ($data->RA_data_person)
                                    {{ $data->RA_data_person }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </td>
                        <th class="w-20">QA/CQA Head Approval Person</th>
                        <td class="w-30">
                            <div>
                                @if ($data->QA_CQA_person)
                                    {{ $data->QA_CQA_person }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </td>
                    </tr>
                </table>
                <label class="head-number" for="QA Final Review Comments">QA Final Review Comments</label>
                <div class="div-data">
                    @if ($cftData->qa_final_comments)
                        {{ $cftData->qa_final_comments }}
                        {{-- {{ str_replace(',', ', ', $data->initiated_if_other) }} --}}
                    @else
                        Not Applicable
                    @endif
                </div>

                <div class="border-table">
                    <div class="block-head">
                        QA Final Review Attachments
                    </div>
                    <table>

                        <tr class="table_bg">
                            <th class="w-20">S.N.</th>
                            <th class="w-60">Attachment</th>
                        </tr>
                        @if ($cftData->qa_final_attach)
                            @foreach (json_decode($cftData->qa_final_attach) as $key => $file)
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
                    RA
                </div>

                <label class="head-number" for="RA Comment">RA Comment</label>
                <div class="div-data">
                    @if ($data->ra_tab_comments)
                        {{ $data->ra_tab_comments }}
                    @else
                        Not Applicable
                    @endif
                </div>


                <div class="border-table">
                    <div class="block-head">
                        RA Attachments
                    </div>
                    <table>

                        <tr class="table_bg">
                            <th class="w-20">S.N.</th>
                            <th class="w-60">Attachment</th>
                        </tr>
                        @if ($data->RA_attachment_second)
                            @foreach (json_decode($data->RA_attachment_second) as $key => $file)
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
                <div class="head">
                    <div class="block-head">
                        QA/CQA Designee Approval
                    </div>

                    <label class="head-number" for="QA/CQA Head/Manager Designee Approval Comments">QA/CQA
                        Head/Manager Designee Approval Comments</label>
                    <div class="div-data">
                        @if ($data->qa_cqa_comments)
                            {{ $data->qa_cqa_comments }}
                        @else
                            Not Applicable
                        @endif
                    </div>
                    {{-- <table>
                        <tr>
                            <th class="w-20">QA/CQA Head/Manager Designee Approval Comments</th>
                            <td class="w-30">
                                <div>
                                    @if ($data->Production_Injection_Attachment)
                                        {{ $data->Production_Injection_Attachment }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                        </tr>
                        </table> --}}



                    <div class="border-table">
                        <div class="block-head">
                            QA/CQA Head/Manager Designee Approval Attachments
                        </div>
                        <table>

                            <tr class="table_bg">
                                <th class="w-20">S.N.</th>
                                <th class="w-60">Attachment</th>
                            </tr>
                            @if ($data->qa_cqa_attach)
                                @foreach (json_decode($data->qa_cqa_attach) as $key => $file)
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
                <div class="head">
                    <div class="block-head">
                        Evaluation Details
                    </div>

                    <label class="head-number" for="QA Evaluation Comments">QA Evaluation Comments</label>
                    <div class="div-data">
                        @if ($data->qa_eval_comments)
                            {{ $data->qa_eval_comments }}
                        @else
                            Not Applicable
                        @endif
                    </div>


                    <div class="border-table">
                        <div class="block-head">
                            QA Evaluation Attachments
                        </div>
                        <table>

                            <tr class="table_bg">
                                <th class="w-20">S.N.</th>
                                <th class="w-60">QA Evaluation Attachments</th>
                            </tr>
                            @if ($data->qa_eval_attach)
                                @foreach (json_decode($data->qa_eval_attach) as $key => $file)
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
                <div class="head">
                    <div class="block-head">
                        Initiator Update
                    </div>
                    <label class="head-number" for="Initiator Update Comments">Initiator Update Comments</label>
                    <div class="div-data">
                        @if ($data->intial_update_comments)
                            {{ $data->intial_update_comments }}
                        @else
                            Not Applicable
                        @endif
                    </div>
                    {{-- <table>
                            <tr>
                                <th class="w-20">Initiator Update Comments</th>
                                <td>
                                    <div>
                                        {{ $data->intial_update_comments ?? 'Not Applicable' }}
                                    </div>
                                </td>
                            </tr>
                        </table> --}}


                    <div class="border-table">
                        <div class="block-head">
                            Initiator Update Attachments
                        </div>
                        <table>

                            <tr class="table_bg">
                                <th class="w-20">S.N.</th>
                                <th class="w-60">Initiator Update Attachments</th>
                            </tr>
                            @if ($data->intial_update_attach)
                                @foreach (json_decode($data->intial_update_attach) as $key => $file)
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
                <div class="head">
                    <div class="block-head">
                        HOD Final Review
                    </div>
                    <label class="head-number" for="HOD Final Review Comments">HOD Final Review Comments</label>
                    <div class="div-data">
                        @if ($data->hod_final_review_comment)
                            {{ $data->hod_final_review_comment }}
                        @else
                            Not Applicable
                        @endif
                    </div>

                    <div class="border-table">
                        <div class="block-head">
                            HOD Final Review Attachments
                        </div>
                        <table>

                            <tr class="table_bg">
                                <th class="w-20">S.N.</th>
                                <th class="w-60">HOD Final Review Attachments</th>
                            </tr>
                            @if ($data->hod_final_review_attach)
                                @foreach (json_decode($data->hod_final_review_attach) as $key => $file)
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
                <div class="head">
                    <div class="block-head">
                        Implementation Verification
                    </div>
                    <label class="head-number" for="Implementation Verification Comments">Implementation
                        Verification Comments</label>
                    <div class="div-data">
                        @if ($data->implementation_verification_comments)
                            {{ $data->implementation_verification_comments }}
                        @else
                            Not Applicable
                        @endif
                    </div>

                    <label class="head-number" for="Training Feedback">Training Feedback</label>
                    <div class="div-data">
                        @if ($data->feedback)
                            {{ $data->feedback }}
                        @else
                            Not Applicable
                        @endif
                    </div>
                    {{-- <table>
                            <tr>
                                <th class="w-20">Implementation Verification Comments</th>
                                <td>
                                    <div>
                                        {{ $data->implementation_verification_comments ?? 'Not Applicable' }}
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="w-20">Training Feedback</th>
                                <td>
                                    <div>
                                        {{ $approcomments->feedback ?? 'Not Applicable' }}
                                    </div>
                                </td>
                            </tr>
                        </table> --}}


                    <div class="border-table">
                        <div class="block-head">
                            Implementation Verification Attachments
                        </div>
                        <table>

                            <tr class="table_bg">
                                <th class="w-20">S.N.</th>
                                <th class="w-60">Implementation Verification Attachments</th>
                            </tr>
                            @if ($data->tran_attach)
                                @foreach (json_decode($data->tran_attach) as $key => $file)
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
                <div class="head">
                    <div class="block-head">
                        Change Closure
                    </div>

                    <label class="head-number" for="QA Closure Comments">QA Closure Comments</label>
                    <div class="div-data">
                        @if ($data->qa_closure_comments)
                            {{ $data->qa_closure_comments }}
                        @else
                            Not Applicable
                        @endif
                    </div>

                    {{-- <table>
                            <tr>
                                <th class="w-20">QA Closure Comments</th>
                                <td>
                                    <div>
                                        {{ $data->qa_closure_comments ?? 'Not Applicable' }}
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="w-20">Due Date Extension Justification</th>
                                <td>
                                    <div>
                                        {{ $data->due_date_extension ?? 'Not Applicable' }}
                                    </div>
                                </td>
                            </tr>
                        </table> --}}


                    <div class="border-table">
                        <div class="block-head">
                            List Of Attachments
                        </div>
                        <table>

                            <tr class="table_bg">
                                <th class="w-20">S.N.</th>
                                <th class="w-60">List Of Attachments</th>
                            </tr>
                            @if ($data->attach_list)
                                @foreach (json_decode($data->attach_list) as $key => $file)
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
                    <label class="head-number" for="Due Date Extension Justification">Due Date Extension
                        Justification</label>
                    <div class="div-data">
                        @if ($data->due_date_extension)
                            {{ $data->due_date_extension }}
                        @else
                            Not Applicable
                        @endif
                    </div>
                </div>
            </div>

            <div class="block">
                <div class="block-head">
                    Activity Log
                </div>
                <table>
                    <tr>
                        <th class="w-20">Submitted By</th>
                        <td class="w-30">
                            <div class="static">{{ $data->submit_by }}</div>
                        </td>
                        <th class="w-20">Submitted On</th>
                        <td class="w-30">
                            <div class="static">{{ $data->submit_on }}</div>
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20" colspan="3">Submitted Comment</th>
                        <td class="w-30">
                            <div class="static">{{ $data->submit_comment }}</div>
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">HOD Assessment Complete By</th>
                        <td class="w-30">
                            <div class="static">{{ $data->hod_review_by }}</div>
                        </td>
                        <th class="w-20">HOD Assessment Complete On</th>
                        <td class="w-30">
                            <div class="static">{{ $data->hod_review_on }}</div>
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20" colspan="3">HOD Comment</th>
                        <td class="w-30">
                            <div class="static">{{ $data->hod_review_comment }}</div>
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">QA/CQA Initial Assessment Complete By</th>
                        <td class="w-30">
                            <div class="static">{{ $data->QA_initial_review_by }}</div>
                        </td>
                        <th class="w-20">QA/CQA Initial Assessment Complete On</th>
                        <td class="w-30">
                            <div class="static">{{ $data->QA_initial_review_on }}</div>
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20" colspan="3">QA/CQA Initial Assessment Comment</th>
                        <td class="w-30">
                            <div class="static">{{ $data->QA_initial_review_comment }}</div>
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">CFT Review Complete By :</th>
                        <td class="w-30">
                            <div class="static">{{ $data->pending_RA_review_by }}</div>
                        </td>
                        <th class="w-20">CFT Review Complete On </th>
                        <td class="w-30">
                            <div class="static">{{ $data->pending_RA_review_on }}</div>
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20" colspan="3">CFT Review Comments </th>
                        <td class="w-30">
                            <div class="static">{{ $data->pending_RA_review_comment }}</div>
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20"> QA/CQA Final Review Complete By :</th>
                        <td class="w-30">
                            <div class="static">{{ $data->QA_final_review_by }}</div>
                        </td>
                        <th class="w-20"> QA/CQA Final Review Complete On :</th>
                        <td class="w-30">
                            <div class="static">{{ $data->QA_final_review_on }}</div>
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20" colspan="3">QA/CQA Final Review Comments :</th>
                        <td class="w-30">
                            <div class="static">{{ $data->QA_final_review_comment }}</div>
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">RA Approval Required By :</th>
                        <td class="w-30">
                            <div class="static">{{ $data->RA_review_required_by }}</div>
                        </td>
                        <th class="w-20">RA Approval Required On:</th>
                        <td class="w-30">
                            <div class="static">{{ $data->RA_review_required_on }}</div>
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20" colspan="3">RA Approval Required Comments </th>
                        <td class="w-30">
                            <div class="static">{{ $data->RA_review_required_comment }}</div>
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">RA Approval Complete By :</th>
                        <td class="w-30">
                            <div class="static">{{ $data->RA_review_completed_by }}</div>
                        </td>
                        <th class="w-20">RA Approval Complete On :</th>
                        <td class="w-30">
                            <div class="static">{{ $data->RA_review_completed_on }}</div>
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20" colspan="3">RA Approval Comments</th>
                        <td class="w-30">
                            <div class="static">{{ $data->RA_review_completed_comment }}</div>
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">QA/CQA Head/Manager Designee Approval:</th>
                        <td class="w-30">
                            <div class="static">{{ $data->RA_review_completed_by }}</div>
                        </td>
                        <th class="w-20">QA/CQA Head/Manager Designee Approval On :</th>
                        <td class="w-30">
                            <div class="static">{{ $data->RA_review_completed_on }}</div>
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20" colspan="3">QA/CQA Head/Manager Designee Approval Comments</th>
                        <td class="w-30">
                            <div class="static">{{ $data->RA_review_completed_comment }}</div>
                        </td>
                    </tr>


                    

                    {{-- <tr>
                        <th class="w-20">Initiator Updated Completed By</th>
                        <td class="w-30">
                            <div class="static">
                                @if ($commnetData->initiator_update_complete_by)
                                    {{ $commnetData->initiator_update_complete_by }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </td>
                        <th class="w-20">Initiator Updated Completed On </th>
                        <td class="w-30">
                            <div class="static">
                                @if ($commnetData->initiator_update_complete_on)
                                    {{ $commnetData->initiator_update_complete_on }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20" colspan="3">Initiator Updated Completed Comments :</th>
                        <td class="w-30">
                            <div class="static">
                                @if ($commnetData->initiator_update_complete_comment)
                                    {{ $commnetData->initiator_update_complete_comment }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </td>
                    </tr> --}}


                   

                    {{-- <tr>
                        <th class="w-20">Send For Final QA/CQA Head Approval By </th>
                        <td class="w-30">
                            <div class="static">{{ $commnetData->send_for_final_qa_head_approval }}</div>
                        </td>
                        <th class="w-20"> Send For Final QA/CQA Head Approval On </th>
                        <td class="w-30">
                            <div class="static">{{ $commnetData->send_for_final_qa_head_approval_on }}</div>
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20" colspan="3">Send For Final QA/CQA Head Approval Comments</th>
                        <td class="w-30">
                            <div class="static">{{ $commnetData->send_for_final_qa_head_approval_comment }}</div>
                        </td>
                    </tr> --}}

                    <tr>
                        <th class="w-20">Pending Initiator Updated Completed By : </th>
                        <td class="w-30">
                            <div class="static">{{ $data->initiator_update_complete_by }}</div>
                        </td>
                        <th class="w-20">Pending Initiator Updated Completed On  : </th>
                        <td class="w-30">
                            <div class="static">{{ $data->initiator_update_complete_on }}</div>
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20" colspan="3">Pending Initiator Updated Completed Comments :</th>
                        <td class="w-30">
                            <div class="static">{{ $data->initiator_update_complete_comment }}</div>
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">HOD Final Review Complete By </th>
                        <td class="w-30">
                            <div class="static">{{ $data->closure_approved_by }}</div>
                        </td>
                        <th class="w-20"> HOD Final Review Complete On </th>
                        <td class="w-30">
                            <div class="static">{{ $data->closure_approved_on }}</div>
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20" colspan="3">HOD Final Review Complete Comments </th>
                        <td class="w-30">
                            <div class="static">{{ $data->closure_approved_comment }}</div>
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">Send For Final QA/CQA Head Approval By </th>
                        <td class="w-30">
                            <div class="static">{{ $data->send_for_final_qa_head_approval }}</div>
                        </td>
                        <th class="w-20"> Send For Final QA/CQA Head Approval On </th>
                        <td class="w-30">
                            <div class="static">{{ $data->send_for_final_qa_head_approval_on }}</div>
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20" colspan="3">Send For Final QA/CQA Head Approval Comments </th>
                        <td class="w-30">
                            <div class="static">{{ $data->send_for_final_qa_head_approval_comment }}</div>
                        </td>
                    </tr>
                   
                    {{-- <tr>
                        <th class="w-20">Approved By : </th>
                        <td class="w-30">
                            <div class="static">{{ $data->approved_by }}</div>
                        </td>
                        <th class="w-20">Approved On :</th>
                        <td class="w-30">
                            <div class="static">{{ $data->approved_on }}</div>
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20" colspan="3">Approved Comments :</th>
                        <td class="w-30">
                            <div class="static">{{ $data->approved_comment }}</div>
                        </td>
                    </tr> --}}

                    <tr>
                        <th class="w-20">Closure Approved By : </th>
                        <td class="w-30">
                            <div class="static">{{ $data->closure_approved_by }}</div>
                        </td>
                        <th class="w-20">Closure Approved On : </th>
                        <td class="w-30">
                            <div class="static">{{ $data->closure_approved_on }}</div>
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20" colspan="3">Closure Approved Comments :</th>
                        <td class="w-30">
                            <div class="static">{{ $data->closure_approved_comment }}</div>
                        </td>
                    </tr>
                </table>
            </div>

        </div>
    </div>


</body>

</html>
