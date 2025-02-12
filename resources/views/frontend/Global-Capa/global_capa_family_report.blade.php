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
                    Global CAPA Family Report
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
                    <strong>Global CAPA No.</strong>
                </td>
                <td class="w-40">
                    {{ Helpers::divisionNameForQMS($data->division_id) }}/Global CAPA/{{ Helpers::year($data->created_at) }}/{{ str_pad($data->record, 4, '0', STR_PAD_LEFT) }}
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
                        <td class="w-80">
                            {{ Helpers::divisionNameForQMS($data->division_id) }}/{{ Helpers::year($data->created_at) }}/Global CAPA/{{ str_pad($data->record, 4, '0', STR_PAD_LEFT) }}
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
                    <td class="w-80">{{ $data->plan_proposed_by }}</td>

                    <th class="w-20">Propose Plan On</th>
                    <td class="w-80">{{ $data->plan_proposed_on }}</td>

                    <th class="w-20">Propose Plan Comment</th>
                    <td class="w-80">{{ $data->comment }}</td>
                </tr>


                <tr>
                    <th class="w-20">QA/CQA Review Completed By</th>
                    <td class="w-80">{{ $data->qa_review_completed_by }}</td>

                    <th class="w-20">QA/CQA Review Completed On</th>
                    <td class="w-80">{{ $data->qa_review_completed_on }}</td>
                    
                    <th class="w-20">QA/CQA Review Completed Comment</th>
                    <td class="w-80">{{ $data->qa_comment }}</td>
                </tr>


                <tr>
                    <th class="w-20">HOD Review Completed By</th>
                    <td class="w-80">{{ $data->hod_review_completed_by }}</td>

                    <th class="w-20">HOD Review Completed On</th>
                    <td class="w-80">{{ $data->hod_review_completed_on }}</td>

                    <th class="w-20">HOD Review Completed Comment</th>
                    <td class="w-80">{{ $data->hod_comment }}</td>
                </tr>


                <tr>
                    <th class="w-20">Cancelled By</th>
                    <td class="w-80">{{ $data->cancelled_by }}</td>

                    <th class="w-20">Cancelled On</th>
                    <td class="w-80">{{ $data->cancelled_on }}</td>

                    <th class="w-20">Cancelled Comment</th>
                    <td class="w-80">{{ $data->cancelled_on_comment }}</td>
                </tr>


                <tr>
                    <th class="w-20">Completed By</th>
                    <td class="w-80">{{ $data->completed_by }}</td>

                    <th class="w-20">Completed On</th>
                    <td class="w-80">{{ $data->completed_on }}</td>

                    <th class="w-20">Completed Comment</th>
                    <td class="w-80">{{ $data->comment }}</td>
                </tr>


                <tr>
                    <th class="w-20">Approved By</th>
                    <td class="w-80">{{ $data->approved_by }}</td>

                    <th class="w-20">Approved On</th>
                    <td class="w-80">{{ $data->approved_on }}</td>

                    <th class="w-20">Approved Comment</th>
                    <td class="w-80">{{ $data->approved_comment }}</td>
                </tr>


                <tr>
                    <th class="w-20">Completed By</th>
                    <td class="w-80">{{ $data->completed_by }}</td>

                    <th class="w-20">Completed On</th>
                    <td class="w-80">{{ $data->completed_on }}</td>

                    <th class="w-20">Completed Comment</th>
                    <td class="w-80">{{ $data->com_comment }}</td>
                </tr>


                <tr>
                    <th class="w-20">HOD Final Review Completed By</th>
                    <td class="w-80">{{ $data->hod_final_review_completed_by }}</td>

                    <th class="w-20">HOD Final Review Completed On</th>
                    <td class="w-80">{{ $data->hod_final_review_completed_on }}</td>

                    <th class="w-20">HOD Final Review Completed Comment</th>
                    <td class="w-80">{{ $data->final_comment }}</td>
                </tr>


                <tr>
                    <th class="w-20">QA/CQA Closure Review Completed By</th>
                    <td class="w-80">{{ $data->qa_closure_review_completed_by }}</td>

                    <th class="w-20">QA/CQA Closure Review Completed On</th>
                    <td class="w-80">{{ $data->qa_closure_review_completed_on }}</td>

                    <th class="w-20">QA/CQA Closure Review Completed Comment</th>
                    <td class="w-80">{{ $data->qa_closure_comment }}</td>
                </tr>


                <tr>
                    <th class="w-20">QA/CQA Approval Completed By</th>
                    <td class="w-80">{{ $data->qah_approval_completed_by }}</td>

                    <th class="w-20">QA/CQA Approval Completed On</th>
                    <td class="w-80">{{ $data->qah_approval_completed_on }}</td>

                    <th class="w-20">QA/CQA Approval Completed Comment</th>
                    <td class="w-80">{{ $data->qah_comment }}</td>
                </tr>

            </table>
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
