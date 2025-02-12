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
                    Change Control Family Report
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
                    <strong>Change Control No.</strong>
                </td>
                <td class="w-40">
                    {{ Helpers::divisionNameForQMS($data->division_id) }}/CC/{{ Helpers::year($data->created_at) }}/{{ str_pad($data->record, 4, '0', STR_PAD_LEFT) }}
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
                {{-- <td class="w-30">
                    <strong>Page :</strong> 1 of 1
                </td> --}}
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

                <label class="head-number" for="Justification">Justification</label>
                <div class="div-data">
                    @if ($data->risk_identification)
                        {{ $data->risk_identification }}
                    @else
                        Not Applicable
                    @endif
                </div>

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

                <label class="head-number" for="Impact On Operations">Impact On Operations</label>
                <div class="div-data">
                    @if ($fields->impact_operations)
                        {{ $fields->impact_operations }}
                    @else
                        Not Applicable
                    @endif
                </div>

                <label class="head-number" for="Impact On Product Quality">Impact On Product Quality</label>
                <div class="div-data">
                    @if ($fields->impact_product_quality)
                        {{ $fields->impact_product_quality }}
                    @else
                        Not Applicable
                    @endif
                </div>

                <label class="head-number" for="Regulatory Impact">Regulatory Impact</label>
                <div class="div-data">
                    @if ($fields->regulatory_impact)
                        {{ $fields->regulatory_impact }}
                    @else
                        Not Applicable
                    @endif
                </div>

                <label class="head-number" for="Risk Level">Risk Level</label>
                <div class="div-data">
                    @if ($fields->risk_level)
                        {{ $fields->risk_level }}
                    @else
                        Not Applicable
                    @endif
                </div>

                <label class="head-number" for="Validation Requirement">Validation Requirement</label>
                <div class="div-data">
                    @if ($fields->validation_requirment)
                        {{ $fields->validation_requirment }}
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
                    @if ($cc_cfts->hod_assessment_comments)
                        {{ $cc_cfts->hod_assessment_comments }}
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
                        @if ($cc_cfts->hod_assessment_attachment)
                            @foreach (json_decode($cc_cfts->hod_assessment_attachment) as $key => $file)
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
                    @if ($docdetail->current_practice)
                        {{ $docdetail->current_practice }}
                    @else
                        Not Applicable
                    @endif
                </div>

                <label class="head-number" for="Proposed Change">Proposed Change</label>
                <div class="div-data">
                    @if ($docdetail->proposed_change)
                        {{ $docdetail->proposed_change }}
                    @else
                        Not Applicable
                    @endif
                </div>

                <label class="head-number" for="Reason For Change">Reason For Change</label>
                <div class="div-data">
                    @if ($docdetail->reason_change)
                        {{ $docdetail->reason_change }}
                    @else
                        Not Applicable
                    @endif
                </div>

                <label class="head-number" for="Any Other Comments">Any Other Comments</label>
                <div class="div-data">
                    @if ($docdetail->other_comment)
                        {{ $docdetail->other_comment }}
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
                    @if ($review->qa_comments)
                        {{ $review->qa_comments }}
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


                    <div class="head">
                        {{-- <div class="block-head">
                            RA Review
                        </div>
                        <table>
                              <tr>
                                <th class="w-20">RA Review Required ?
                                </th>
                                <td class="w-30">
                                    <div>
                                        @if ($cftData->RA_Review)
                                            {{ $cftData->RA_Review }}
                                        @else
                                            Not Applicable
                                        @endif
                                    </div>
                                </td>
                                <th class="w-20">RA Person</th>
                                <td class="w-30">
                                    <div>
                                        @if ($cftData->RA_person)
                                            {{ $cftData->RA_person }}
                                        @else
                                            Not Applicable
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="w-20">Impact Assessment (By RA)</th>
                                <td class="w-80">
                                    <div>
                                        @if ($cftData->RA_assessment)
                                            {{ $cftData->RA_assessment }}
                                        @else
                                            Not Applicable
                                        @endif
                                    </div>
                                </td>
                                <th class="w-20">RA Feedback</th>
                                <td class="w-80">
                                    <div>
                                        @if ($cftData->RA_feedback)
                                            {{ $cftData->RA_feedback }}
                                        @else
                                            Not Applicable
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="w-20">RA Review Completed By</th>
                                <td class="w-30">
                                    <div>
                                        @if ($cftData->RA_by)
                                            {{ $cftData->RA_by }}
                                        @else
                                            Not Applicable
                                        @endif
                                    </div>
                                </td>
                                <th class="w-20">RA Review Completed On</th>
                                <td class="w-30">
                                    <div>
                                        @if ($cftData->RA_on)
                                            {{ $cftData->RA_on }}
                                        @else
                                            Not Applicable
                                        @endif
                                    </div>
                                </td>
                            </tr>  
                        </table>
                    </div> --}}
                        {{--  <div class="border-table">
                        <div class="block-head">
                            RA Attachments
                        </div>
                        <table>

                            <tr class="table_bg">
                                <th class="w-20">S.N.</th>
                                <th class="w-60">Attachment</th>
                            </tr>
                            @if ($cftData->RA_attachment)
                                @foreach (json_decode($cftData->RA_attachment) as $key => $file)
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
                    </div>  --}}
                    </div>
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
            <div class="head">
                <div class="block-head">
                    Production (Tablet/Capsule/Powder)
                </div>
                <table>
                    <tr>
                        <th class="w-20">Production Tablet Required ?
                        </th>
                        <td class="w-30">
                            <div>
                                @if ($cftData->Production_Table_Review)
                                    {{ $cftData->Production_Table_Review }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </td>
                        <th class="w-20">Production Tablet Person</th>
                        <td class="w-30">
                            <div>
                                @if ($cftData->Production_Table_Person)
                                    {{ $cftData->Production_Table_Person }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Impact Assessment (By Production Tablet)</th>
                        <td class="w-30">
                            <div>
                                @if ($cftData->Production_Table_Assessment)
                                    {{ $cftData->Production_Table_Assessment }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </td>
                        <th class="w-20">Production Tablet Feedback</th>
                        <td class="w-30">
                            <div>
                                @if ($cftData->Production_Table_Feedback)
                                    {{ $cftData->Production_Table_Feedback }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Production Tablet Completed By</th>
                        <td class="w-30">
                            <div>
                                @if ($cftData->Production_Table_By)
                                    {{ $cftData->Production_Table_By }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </td>
                        <th class="w-20">Production Tablet Completed On</th>
                        <td class="w-30">
                            <div>
                                @if ($cftData->Production_Table_On)
                                    {{ $cftData->Production_Table_On }}
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
                    Production Tablet Attachments
                </div>
                <table>

                    <tr class="table_bg">
                        <th class="w-20">S.N.</th>
                        <th class="w-60">Attachment</th>
                    </tr>
                    @if ($cftData->Production_Table_Attachment)
                        @foreach (json_decode($cftData->Production_Table_Attachment) as $key => $file)
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
                    Production (Liquid/Ointment)
                </div>
                <table>
                    <tr>
                        <th class="w-20">Production Liquid Required ?
                        </th>
                        <td class="w-30">
                            <div>
                                @if ($cftData->ProductionLiquid_Review)
                                    {{ $cftData->ProductionLiquid_Review }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </td>
                        <th class="w-20">Production Liquid Person</th>
                        <td class="w-30">
                            <div>
                                @if ($cftData->ProductionLiquid_person)
                                    {{ $cftData->ProductionLiquid_person }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Impact Assessment (By Production Liquid)</th>
                        <td class="w-30">
                            <div>
                                @if ($cftData->ProductionLiquid_assessment)
                                    {{ $cftData->ProductionLiquid_assessment }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </td>
                        <th class="w-20">Production Liquid Feedback</th>
                        <td class="w-30">
                            <div>
                                @if ($cftData->ProductionLiquid_feedback)
                                    {{ $cftData->ProductionLiquid_feedback }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Production Liquid Completed By</th>
                        <td class="w-30">
                            <div>
                                @if ($cftData->ProductionLiquid_by)
                                    {{ $cftData->ProductionLiquid_by }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </td>
                        <th class="w-20">Production Liquid Completed On</th>
                        <td class="w-30">
                            <div>
                                @if ($cftData->ProductionLiquid_on)
                                    {{ $cftData->ProductionLiquid_on }}
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
                    Production Liquid Attachments
                </div>
                <table>

                    <tr class="table_bg">
                        <th class="w-20">S.N.</th>
                        <th class="w-60">Attachment</th>
                    </tr>
                    @if ($cftData->ProductionLiquid_attachment)
                        @foreach (json_decode($cftData->ProductionLiquid_attachment) as $key => $file)
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
                    Production Injection
                </div>
                <table>
                    <tr>
                        <th class="w-20">Production Injection Required ?
                        </th>
                        <td class="w-30">
                            <div>
                                @if ($cftData->Production_Injection_Review)
                                    {{ $cftData->Production_Injection_Review }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </td>
                        <th class="w-20">Production Injection Person</th>
                        <td class="w-30">
                            <div>
                                @if ($cftData->Production_Injection_Person)
                                    {{ $cftData->Production_Injection_Person }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Impact Assessment (By Production Injection)</th>
                        <td class="w-30">
                            <div>
                                @if ($cftData->Production_Injection_Assessment)
                                    {{ $cftData->Production_Injection_Assessment }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </td>
                        <th class="w-20">Production Injection Feedback</th>
                        <td class="w-30">
                            <div>
                                @if ($cftData->Production_Injection_Feedback)
                                    {{ $cftData->Production_Injection_Feedback }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Production Injection Completed By</th>
                        <td class="w-30">
                            <div>
                                @if ($cftData->Production_Injection_By)
                                    {{ $cftData->Production_Injection_By }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </td>
                        <th class="w-20">Production Injection Completed On</th>
                        <td class="w-30">
                            <div>
                                @if ($cftData->Production_Injection_On)
                                    {{ $cftData->Production_Injection_On }}
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
                    Production Injection Attachments
                </div>
                <table>

                    <tr class="table_bg">
                        <th class="w-20">S.N.</th>
                        <th class="w-60">Attachment</th>
                    </tr>
                    @if ($cftData->Production_Injection_Attachment)
                        @foreach (json_decode($cftData->Production_Injection_Attachment) as $key => $file)
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
                    Stores
                </div>
                <table>
                    <tr>
                        <th class="w-20">Stores Required ?
                        </th>
                        <td class="w-30">
                            <div>
                                @if ($cftData->Store_Review)
                                    {{ $cftData->Store_Review }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </td>
                        <th class="w-20">Stores Person</th>
                        <td class="w-30">
                            <div>
                                @if ($cftData->Store_person)
                                    {{ $cftData->Store_person }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Impact Assessment (By Stores)</th>
                        <td class="w-30">
                            <div>
                                @if ($cftData->Store_assessment)
                                    {{ $cftData->Store_assessment }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </td>
                        <th class="w-20">Stores Feedback</th>
                        <td class="w-30">
                            <div>
                                @if ($cftData->Store_feedback)
                                    {{ $cftData->Store_feedback }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Stores Completed By</th>
                        <td class="w-30">
                            <div>
                                @if ($cftData->Store_by)
                                    {{ $cftData->Store_by }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </td>
                        <th class="w-20">Stores Completed On</th>
                        <td class="w-30">
                            <div>
                                @if ($cftData->Store_on)
                                    {{ $cftData->Store_on }}
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
                    Stores Attachments
                </div>
                <table>

                    <tr class="table_bg">
                        <th class="w-20">S.N.</th>
                        <th class="w-60">Attachment</th>
                    </tr>
                    @if ($cftData->Store_attachment)
                        @foreach (json_decode($cftData->Store_attachment) as $key => $file)
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
                                    @if ($cftData->QualityAssurance__by)
                                        {{ $cftData->QualityAssurance__by }}
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
                                @if ($cftData->CorporateQualityAssurance_Review)
                                    {{ $cftData->CorporateQualityAssurance_Review }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </td>
                        <th class="w-20">Corporate Quality Assurance Person</th>
                        <td class="w-30">
                            <div>
                                @if ($cftData->CorporateQualityAssurance_person)
                                    {{ $cftData->CorporateQualityAssurance_person }}
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
                                @if ($cftData->CorporateQualityAssurance_by)
                                    {{ $cftData->CorporateQualityAssurance_by }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </td>
                        <th class="w-20">Corporate Quality Assurance Completed On</th>
                        <td class="w-30">
                            <div>
                                @if ($cftData->CorporateQualityAssurance_on)
                                    {{ $cftData->CorporateQualityAssurance_on }}
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
                    @if ($cftData->CorporateQualityAssurance_attachment)
                        @foreach (json_decode($cftData->CorporateQualityAssurance_attachment) as $key => $file)
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
                        Safety
                    </div>
                    <table>

                        <tr>

                            <th class="w-20">Safety Review Required ?
                            </th>
                            <td class="w-30">
                                <div>
                                    @if ($cftData->Environment_Health_review)
                                        {{ $cftData->Environment_Health_review }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                            <th class="w-20">Safety Person</th>
                            <td class="w-30">
                                <div>
                                    @if ($cftData->Environment_Health_Safety_person)
                                        {{ $cftData->Environment_Health_Safety_person }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                        </tr>

                        <tr>

                            <th class="w-20">Impact Assessment (By Safety)</th>
                            <td class="w-30">
                                <div>
                                    @if ($cftData->Health_Safety_assessment)
                                        {{ $cftData->Health_Safety_assessment }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                            <th class="w-20">Safety Feedback</th>
                            <td class="w-30">
                                <div>
                                    @if ($cftData->Health_Safety_feedback)
                                        {{ $cftData->Health_Safety_feedback }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                        </tr>
                        <tr>

                            <th class="w-20">Safety Review Completed By</th>
                            <td class="w-30">
                                <div>
                                    @if ($cftData->production_by)
                                        {{ $cftData->Human_Resource_by }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                            <th class="w-20"> Safety Review Completed On</th>
                            <td class="w-30">
                                <div>
                                    @if ($cftData->Human_Resource_on)
                                        {{ $cftData->Human_Resource_on }}
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
                        Safety Attachments
                    </div>
                    <table>

                        <tr class="table_bg">
                            <th class="w-20">S.N.</th>
                            <th class="w-60">Attachment</th>
                        </tr>
                        @if ($cftData->Human_Resource_attachment)
                            @foreach (json_decode($cftData->Human_Resource_attachment) as $key => $file)
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
                        Information Technology

                    </div>
                    <table>

                        <tr>

                            <th class="w-20">Information Technology Review Required ?
                            </th>
                            <td class="w-30">
                                <div>
                                    @if ($cftData->Information_Technology_review)
                                        {{ $cftData->Information_Technology_review }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                            <th class="w-20">Information Technology Person</th>
                            <td class="w-30">
                                <div>
                                    @if ($cftData->Information_Technology_person)
                                        {{ $cftData->Information_Technology_person }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                        </tr>

                        <tr>

                            <th class="w-20">Impact Assessment (By Information Technology)</th>
                            <td class="w-30">
                                <div>
                                    @if ($cftData->Information_Technology_assessment)
                                        {{ $cftData->Information_Technology_assessment }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                            <th class="w-20">Information Technology Feedback</th>
                            <td class="w-30">
                                <div>
                                    @if ($cftData->Information_Technology_feedback)
                                        {{ $cftData->Information_Technology_feedback }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                        </tr>
                        <tr>

                            <th class="w-20">Information Technology Review Completed By</th>
                            <td class="w-30">
                                <div>
                                    @if ($cftData->Information_Technology_by)
                                        {{ $cftData->Information_Technology_by }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                            <th class="w-20"> Information Technology Review Completed On</th>
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
                        Information Technology Attachments
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

            <div class="block">
                <div class="head">
                    <div class="block-head">
                        Contract Giver
                    </div>
                    <table>
                        <tr>
                            <th class="w-20">Contract Giver Required ?
                            </th>
                            <td class="w-30">
                                <div>
                                    @if ($cftData->ContractGiver_Review)
                                        {{ $cftData->ContractGiver_Review }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                            <th class="w-20">Contract Giver Person</th>
                            <td class="w-30">
                                <div>
                                    @if ($cftData->ContractGiver_person)
                                        {{ $cftData->ContractGiver_person }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th class="w-20">Impact Assessment (By Contract Giver)</th>
                            <td class="w-30">
                                <div>
                                    @if ($cftData->ContractGiver_assessment)
                                        {{ $cftData->ContractGiver_assessment }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                            <th class="w-20">Contract Giver Feedback</th>
                            <td class="w-30">
                                <div>
                                    @if ($cftData->ContractGiver_feedback)
                                        {{ $cftData->ContractGiver_feedback }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th class="w-20">Contract Giver Completed By</th>
                            <td class="w-30">
                                <div>
                                    @if ($cftData->ContractGiver_by)
                                        {{ $cftData->ContractGiver_by }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                            <th class="w-20">Contract Giver Completed On</th>
                            <td class="w-30">
                                <div>
                                    @if ($cftData->ContractGiver_on)
                                        {{ $cftData->ContractGiver_on }}
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
                        Contract Giver Attachments
                    </div>
                    <table>

                        <tr class="table_bg">
                            <th class="w-20">S.N.</th>
                            <th class="w-60">Attachment</th>
                        </tr>
                        @if ($cftData->ContractGiver_attachment)
                            @foreach (json_decode($cftData->ContractGiver_attachment) as $key => $file)
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
                                @if ($cc_cfts->RA_data_person)
                                    {{ $cc_cfts->RA_data_person }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </td>
                        <th class="w-20">QA/CQA Head Approval Person</th>
                        <td class="w-30">
                            <div>
                                @if ($cc_cfts->QA_CQA_person)
                                    {{ $cc_cfts->QA_CQA_person }}
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
                        @if ($cc_cfts->RA_attachment_second)
                            @foreach (json_decode($cc_cfts->RA_attachment_second) as $key => $file)
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
                        @if ($cc_cfts->qa_cqa_comments)
                            {{ $cc_cfts->qa_cqa_comments }}
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
                            @if ($cc_cfts->qa_cqa_attach)
                                @foreach (json_decode($cc_cfts->qa_cqa_attach) as $key => $file)
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
                        @if ($evaluation->qa_eval_comments)
                            {{ $evaluation->qa_eval_comments }}
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
                            @if ($evaluation->qa_eval_attach)
                                @foreach (json_decode($evaluation->qa_eval_attach) as $key => $file)
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
                        @if ($cc_cfts->intial_update_comments)
                            {{ $cc_cfts->intial_update_comments }}
                        @else
                            Not Applicable
                        @endif
                    </div>
                    {{-- <table>
                            <tr>
                                <th class="w-20">Initiator Update Comments</th>
                                <td>
                                    <div>
                                        {{ $cc_cfts->intial_update_comments ?? 'Not Applicable' }}
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
                            @if ($cc_cfts->intial_update_attach)
                                @foreach (json_decode($cc_cfts->intial_update_attach) as $key => $file)
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
                        @if ($cc_cfts->hod_final_review_comment)
                            {{ $cc_cfts->hod_final_review_comment }}
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
                            @if ($cc_cfts->hod_final_review_attach)
                                @foreach (json_decode($cc_cfts->hod_final_review_attach) as $key => $file)
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
                        @if ($cc_cfts->implementation_verification_comments)
                            {{ $cc_cfts->implementation_verification_comments }}
                        @else
                            Not Applicable
                        @endif
                    </div>

                    <label class="head-number" for="Training Feedback">Training Feedback</label>
                    <div class="div-data">
                        @if ($approcomments->feedback)
                            {{ $approcomments->feedback }}
                        @else
                            Not Applicable
                        @endif
                    </div>
                    {{-- <table>
                            <tr>
                                <th class="w-20">Implementation Verification Comments</th>
                                <td>
                                    <div>
                                        {{ $cc_cfts->implementation_verification_comments ?? 'Not Applicable' }}
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
                            @if ($approcomments->tran_attach)
                                @foreach (json_decode($approcomments->tran_attach) as $key => $file)
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
                        @if ($closure->qa_closure_comments)
                            {{ $closure->qa_closure_comments }}
                        @else
                            Not Applicable
                        @endif
                    </div>

                    {{-- <table>
                            <tr>
                                <th class="w-20">QA Closure Comments</th>
                                <td>
                                    <div>
                                        {{ $closure->qa_closure_comments ?? 'Not Applicable' }}
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
                            @if ($closure->attach_list)
                                @foreach (json_decode($closure->attach_list) as $key => $file)
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
                                        {{ Helpers::divisionNameForQMS($data->site_location_code) }}/Ext/{{ Helpers::year($data->created_at) }}/{{ str_pad($data->record_number, 4, '0', STR_PAD_LEFT) }}
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
                                <th class="w-20">Comment</th>
                                <td class="w-80">{{ $data->submit_comment }}</td>
                            </tr>
                            <tr>
                                <th class="w-20">Cancel By</th>
                                <td class="w-80">{{ $data->reject_by }}</td>
                                <th class="w-20">Cancel On</th>
                                <td class="w-80">{{ $data->reject_on }}</td>
                            </tr>
                            <tr>
                                <th class="w-20">Comment</th>
                                <td class="w-80">{{ $data->reject_comment }}</td>
                            </tr>
                            <tr>
                                <th class="w-20">More Information Required By</th>
                                <td class="w-80">{{ $data->more_info_review_by }}</td>
                                <th class="w-20">More Information Required On</th>
                                <td class="w-80">{{ $data->more_info_review_on }}</td>
                            </tr>
                            <tr>
                                <th class="w-20">Comment</th>
                                <td class="w-80">{{ $data->more_info_review_comment }}</td>
                            </tr>
                            <tr>
                                <th class="w-20">Review By</th>
                                <td class="w-80">{{ $data->submit_by_review }}</td>
                                <th class="w-20">Review On</th>
                                <td class="w-80">{{ $data->submit_on_review }}</td>
                            </tr>
                            <tr>
                                <th class="w-20">Comment</th>
                                <td class="w-80">{{ $data->submit_comment_review }}</td>
                            </tr>
                            <tr>
                                <th class="w-20">Reject By</th>
                                <td class="w-80">{{ $data->submit_by_inapproved }}</td>
                                <th class="w-20">Reject On</th>
                                <td class="w-80">{{ $data->submit_on_inapproved }}</td>
                            </tr>
                            <tr>
                                <th class="w-20">Comment</th>
                                <td class="w-80">{{ $data->submit_commen_inapproved }}</td>
                            </tr>
                            <tr>
                                <th class="w-20">More Information Required By</th>
                                <td class="w-80">{{ $data->more_info_inapproved_by }}</td>
                                <th class="w-20">More Information Required On</th>
                                <td class="w-80">{{ $data->more_info_inapproved_on }}</td>
                            </tr>
                            <tr>
                                <th class="w-20">Comment</th>
                                <td class="w-80">{{ $data->more_info_inapproved_comment }}</td>
                            </tr>
                            <tr>
                                <th class="w-20">Send for CQA By</th>
                                <td class="w-80">{{ $data->send_cqa_by }}</td>
                                <th class="w-20">Send for CQA On</th>
                                <td class="w-80">{{ $data->send_cqa_on }}</td>
                            </tr>
                            <tr>
                                <th class="w-20">Comment</th>
                                <td class="w-80">{{ $data->send_cqa_comment }}</td>
                            </tr>
                            <tr>
                                <th class="w-20">Approved By</th>
                                <td class="w-80">{{ $data->submit_by_approved }}</td>
                                <th class="w-20">Approved On</th>
                                <td class="w-80">{{ $data->submit_on_approved }}</td>
                            </tr>
                            <tr>
                                <th class="w-20">Comment</th>
                                <td class="w-80">{{ $data->submit_comment_approved }}</td>
                            </tr>
                            <tr>
                                <th class="w-20">CQA Approval Complete By</th>
                                <td class="w-80">{{ $data->cqa_approval_by }}</td>
                                <th class="w-20">CQA Approval Complete On</th>
                                <td class="w-80">{{ $data->cqa_approval_on }}</td>
                            </tr>
                            <tr>
                                <th class="w-20">Comment</th>
                                <td class="w-80">{{ $data->cqa_approval_comment }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        @endforeach
    @endif

    @if (count($RCA) > 0)
        @foreach ($RCA as $data)
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
                                            <td class="w-30">{{ unserialize($data->risk_element)[$key] ?? null }}
                                            </td>
                                            <td class="w-30">{{ unserialize($data->problem_cause)[$key] ?? null }}
                                            </td>
                                            <td class="w-30">
                                                {{ unserialize($data->existing_risk_control)[$key] ?? null }}
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
                                            <td class="w-30">{{ unserialize($data->initial_detectability)[$key] }}
                                            </td>
                                            <td class="w-30">{{ unserialize($data->initial_probability)[$key] }}
                                            </td>
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
                                    <th class="w-30">Proposed Additional Risk control measure (Mandatory for Risk
                                        elements
                                        having RPN>4)</th>
                                    <th class="w-30">Residual Severity- H(3)/M(2)/L(1)</th>
                                    <th class="w-30">Residual Probability- H(3)/M(2)/L(1)</th>
                                </tr>
                                @if (!empty($data->risk_factor))
                                    @foreach (unserialize($data->risk_factor) as $key => $riskFactor)
                                        <tr>
                                            <td class="w-10">{{ $key + 1 }}</td>
                                            <td class="w-30">{{ unserialize($data->risk_acceptance)[$key] }}</td>
                                            <td class="w-30">{{ unserialize($data->risk_control_measure)[$key] }}
                                            </td>
                                            <td class="w-30">{{ unserialize($data->residual_severity)[$key] }}
                                            </td>
                                            <td class="w-30">{{ unserialize($data->residual_probability)[$key] }}
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
                                    <th class="w-30">Residual Detectability- H(1)/M(2)/L(3)</th>
                                    <th class="w-30">Residual RPN</th>
                                    <th class="w-30">Risk Acceptance (Y/N)</th>
                                    <th class="w-30">Mitigation proposal (Mention either CAPA reference number, IQ,
                                        OQ or PQ)
                                    </th>
                                </tr>
                                @if (!empty($data->risk_factor))
                                    @foreach (unserialize($data->risk_factor) as $key => $riskFactor)
                                        <tr>
                                            <td class="w-10">{{ $key + 1 }}</td>
                                            <td class="w-30">
                                                {{ unserialize($data->residual_detectability)[$key] }}
                                            </td>
                                            <td class="w-30">{{ unserialize($data->residual_rpn)[$key] }}</td>
                                            <td class="w-30">{{ unserialize($data->risk_acceptance2)[$key] }}</td>
                                            <td class="w-30">{{ unserialize($data->mitigation_proposal)[$key] }}
                                            </td>
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
                        <label class="Summer"
                            style="font-weight: bold; font-size: 13px; display: inline-block; width: 75px;">
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
                        <label class="Summer"
                            style="font-weight: bold; font-size: 13px; display: inline-block; width: 75px;">
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
                        <label class="Summer"
                            style="font-weight: bold; font-size: 13px; display: inline-block; width: 75px;">
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
                        <label class="Summer"
                            style="font-weight: bold; font-size: 13px; display: inline-block; width: 75px;">
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
                        <tr>
                            {{--   <th class="w-20">More information Required By</th>
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


                        <tr>
                            <th class="w-20">HOD Final Review Completed By</th>
                            <td class="w-30">{{ $data->hod_final_review_completed_by }}</td>
                            <th class="w-20">HOD Final Review Completed On</th>
                            <td class="w-30">{{ $data->hod_final_review_completed_on }}</td>
                            <th class="w-20">
                                Comment</th>
                            <td class="w-30">{{ $data->HOD_Final_Review_Complete_Comment }}</td>
                        </tr>

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

    @if (count($CAPA) > 0)
        @foreach ($CAPA as $data)
            <center>
                <h3>CAPA Report</h3>
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
                                <td class="w-80">{{ $departments[$data->initiator_Group] ?? 'Not Application' }}
                                </td>

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
