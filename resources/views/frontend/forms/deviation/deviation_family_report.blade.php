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
                    Deviation Family Report
                </td>
                <td class="w-20" >
                    <div class="logo">
                        <img src="https://www.cphi-online.com/Medicef%20Logo-comp306798.jpg" alt="" class="w-80">
                    </div>
                </td>
            </tr>
        </table>
        <table>
            <tr>
                <td class="w-30">
                    <strong> Deviation No.</strong>
                </td>
                <td class="w-40">
                    {{ Helpers::divisionNameForQMS($data->division_id) }}/{{ Helpers::year($data->created_at) }}/{{ str_pad($data->record, 4, '0', STR_PAD_LEFT) }}
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
                    <tr> {{ $data->created_at }} added by {{ $data->originator }}
                        <th class="w-20">Site/Location Code</th>
                        <td class="w-30"> {{ Helpers::getDivisionName(session()->get('division')) }}</td>
                        <th class="w-20">Initiator</th>
                        <td class="w-30">{{ Helpers::getInitiatorName($data->initiator_id) }}</td>
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Date of Initiation</th>
                        {{-- <td class="w-30">@if{{ Helpers::getdateFormat($data->intiation_date) }} @else Not Applicable @endif</td> --}}
                        {{-- <td class="w-30">@if (Helpers::getdateFormat($data->intiation_date)) {{ Helpers::getdateFormat($data->intiation_date) }} @else Not Applicable @endif</td> --}}
                        <td class="w-30">{{ $data->created_at ? $data->created_at->format('d-M-Y') : '' }} </td>

                        <th class="w-20">Due Date</th>
                        <td class="w-30">
                            @if ($data->due_date)
                                {{ $data->due_date }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Department</th>
                        <td class="w-30">
                            @if ($data->Initiator_Group)
                                {{ Helpers::getFullDepartmentName($data->Initiator_Group) }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Short Description</th>
                        <td class="w-30">
                            @if ($data->short_description)
                                {{ $data->short_description }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        {{-- <th class="w-20">Department Code</th> --}}
                        {{-- <td class="w-30">@if ($data->initiator_group_code){{ $data->initiator_group_code }} @else Not Applicable @endif</td> --}}
                    </tr>
                    <tr>
                        <th class="w-20"> Repeat Deviation?</th>
                        <td class="w-30">
                            @if ($data->short_description_required)
                                {{ $data->short_description_required }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20"> Repeat Nature</th>
                        <td class="w-30">
                            @if ($data->nature_of_repeat)
                                {{ $data->nature_of_repeat }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                    </tr>
                    <tr>
                        <th class="w-20"> Deviation Observed On</th>
                        <td class="w-30">
                            @if ($data->Deviation_date)
                                {{ $data->Deviation_date }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20"> Deviation Observed On (Time)</th>
                        <td class="w-30">
                            @if ($data->deviation_time)
                                {{ $data->deviation_time }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                    </tr>
                    <tr>
                        <th class="w-20"> Delay Justification</th>
                        <td class="w-30"></td>
                        <th class="w-20">Deviation Observed by</th>
                        @php
                            $facilityIds = explode(',', $data->Facility);
                            $users = $facilityIds ? DB::table('users')->whereIn('id', $facilityIds)->get() : [];
                        @endphp

                        <td>
                            @if ($facilityIds && count($users) > 0)
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" selected>{{ $user->name }}</option>
                                @endforeach
                            @else
                                Not Applicable
                            @endif
                        </td>


                        {{-- <td class="w-30">@if ($data->Facility){{ $data->Facility }} @else Not Applicable @endif</td> --}}

                    </tr>

                    <tr>
                        <th class="w-20">Deviation Reported On </th>
                        <td class="w-30">
                            @if ($data->Deviation_reported_date)
                                {{ $data->Deviation_reported_date }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Deviation Related To</th>
                        <td class="w-30">
                            @if ($data->audit_type)
                                {{ $data->audit_type }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>

                        <th class="w-20"> Others</th>
                        <td class="w-30">
                            @if ($data->others)
                                {{ $data->others }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Facility/ Equipment/ Instrument/ System Details Required?</th>
                        <td class="w-30">
                            @if ($data->Facility_Equipment)
                                {{ $data->Facility_Equipment }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                    </tr>
                    <tr>

                        <th class="w-20">Document Details Required?</th>
                        <td class="w-30">
                            @if ($data->Document_Details_Required)
                                {{ $data->Document_Details_Required }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Description of Deviation</th>
                        <td class="w-30">
                            @if ($data->Description_Deviation)
                                {{ strip_tags($data->Description_Deviation) }}
                            @else
                                Not Applicable
                            @endif
                        </td>


                    </tr>


                    {{-- <tr> --}}
                    {{-- <th class="w-20">Name of Product & Batch No</th> --}}
                    {{-- <td class="w-30">@if ($data->Product_Batch){{ ($data->Product_Batch) }} @else Not Applicable @endif</td> --}}
                    {{-- </tr> --}}

                    <tr>
                        <th class="w-20">Immediate Action (if any)</th>
                        <td class="w-30">
                            @if ($data->Immediate_Action)
                                {{ strip_tags($data->Immediate_Action) }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Preliminary Impact of Deviation</th>
                        <td class="w-30">
                            @if ($data->Preliminary_Impact)
                                {{strip_tags($data->Preliminary_Impact) }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
      
                    </table>
   
        
        <div class="block">
            <div class="block-head">
                Description of Deviation
         </div>
         <div class="border-table">
        <table>
                <tr class="table_bg">
                    <th class="w-20" >5W/2H</th>
                    <th class="w-80"  >Remarks</th>
                </tr>
            
                <tr>
                    <td class="w-20" style="background-color: #91b4f7;">What</td>
                    <td class="w-80" >{{$data->what}}</td>
                </tr>
                <tr>
                    <td class="w-20" style="background-color: #91b4f7;">Why</td>
                    <td class="w-80">{{$data->why_why}}</td>
                </tr>
                <tr>
                    <td class="w-20" style="background-color: #91b4f7;">Where</td>
                    <td class="w-80">{{$data->where_where}}</td>
                </tr>
                <tr>
                    <td class="w-20" style="background-color: #91b4f7;">When</td>
                    <td class="w-80">{{$data->when_when}}</td>
                </tr>
                <tr>
                    <td class="w-20" style="background-color: #91b4f7;">Who</td>
                    <td class="w-80">{{$data->who}}</td>
                </tr>
                <tr>
                    <td class="w-20" style="background-color: #91b4f7;">How</td>
                    <td class="w-80">{{$data->how}}</td>
                </tr>
                <tr>
                    <td class="w-20" style="background-color: #91b4f7;">How much</td>
                    <td class="w-80">{{$data->how_much}}</td>
                </tr>
          
        </table>
    </div>
    </div>



                

                <div class="block">
                    <div class="block-head">
                        Facility/ Equipment/ Instrument/ System Details
                    </div>
                    <div class="border-table">
                        <table>
                            <tr class="table_bg">
                                <th class="w-10">Sr. No.</th>
                                <th class="w-25">Name</th>
                                <th class="w-25">ID Number</th>
                                <th class="w-25">Remarks</th>

                            </tr>
                            @if (!empty($grid_data->IDnumber))
                                @foreach (unserialize($grid_data->IDnumber) as $key => $dataDemo)
                                    <tr>
                                        <td class="w-15">{{ $loop->index + 1 }}</td>
                                        <td class="w-15">
                                            {{ unserialize($grid_data->facility_name)[$key] ? unserialize($grid_data->facility_name)[$key] : 'Not Applicable' }}
                                        </td>
                                        <td class="w-15">
                                            {{ unserialize($grid_data->IDnumber)[$key] ? unserialize($grid_data->IDnumber)[$key] : 'Not Applicable' }}
                                        </td>
                                        <td class="w-15">
                                            {{ unserialize($grid_data->Remarks)[$key] ? unserialize($grid_data->Remarks)[$key] : 'Not Applicable' }}
                                        </td>

                                    </tr>
                                @endforeach
                            @else
                                <tr>
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
                        Document Details
                    </div>
                    <div class="border-table">
                        <table>
                            <tr class="table_bg">
                                <th class="w-10">Sr. No.</th>
                                <th class="w-25">Number</th>
                                <th class="w-25">Reference Document Name</th>
                                <th class="w-25">Remarks</th>

                            </tr>
                            @if (!empty($grid_data1->Number))
                                @foreach (unserialize($grid_data1->Number) as $key => $dataDemo)
                                    <tr>
                                        <td class="w-15">{{ $loop->index + 1 }}</td>
                                        <td class="w-15">
                                            {{ unserialize($grid_data1->Number)[$key] ? unserialize($grid_data1->Number)[$key] : 'Not Applicable' }}
                                        </td>
                                        <td class="w-15">
                                            {{ unserialize($grid_data1->ReferenceDocumentName)[$key] ? unserialize($grid_data1->ReferenceDocumentName)[$key] : 'Not Applicable' }}
                                        </td>
                                        <td class="w-15">
                                            {{ unserialize($grid_data1->Document_Remarks)[$key] ? unserialize($grid_data1->Document_Remarks)[$key] : 'Not Applicable' }}
                                        </td>

                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td>Not Applicable</td>
                                    <td>Not Applicable</td>
                                    <td>Not Applicable</td>
                                    <td>Not Applicable</td>

                                </tr>
                            @endif
                        </table>
                    </div>
                </div>
                {{-- ==================================new Added=================== --}}
                <div class="block">
                    <div class="block-head">
                        Product/Batch Details
                    </div>
                    <div class="border-table">
                        <table>
                            <tr class="table_bg">
                                <th class="w-10">Sr. No.</th>
                                <th class="w-25">Product</th>
                                <th class="w-25">Stage</th>
                                <th class="w-25">Batch No.</th>

                            </tr>
                            @if (!empty($grid_data1->Number))
                                @foreach (unserialize($grid_data1->Number) as $key => $dataDemo)
                                    <tr>
                                        <td class="w-15">{{ $loop->index + 1 }}</td>
                                        <td class="w-15">
                                            {{ unserialize($grid_data1->Number)[$key] ? unserialize($grid_data1->Number)[$key] : 'Not Applicable' }}
                                        </td>
                                        <td class="w-15">
                                            {{ unserialize($grid_data1->ReferenceDocumentName)[$key] ? unserialize($grid_data1->ReferenceDocumentName)[$key] : 'Not Applicable' }}
                                        </td>
                                        <td class="w-15">
                                            {{ unserialize($grid_data1->Document_Remarks)[$key] ? unserialize($grid_data1->Document_Remarks)[$key] : 'Not Applicable' }}
                                        </td>

                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td>Not Applicable</td>
                                    <td>Not Applicable</td>
                                    <td>Not Applicable</td>
                                    <td>Not Applicable</td>

                                </tr>
                            @endif
                        </table>
                    </div>
                </div>

                <div class="border-table">
                    <div class="block-head">
                        Initial Attachments
                    </div>
                    <table>

                        <tr class="table_bg">
                            <th class="w-20">S.N.</th>
                            <th class="w-60">Attachment</th>
                        </tr>
                        @if ($data->Audit_file)
                            @foreach (json_decode($data->Audit_file) as $key => $file)
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
                <!-- {{-- ==================================      --}} -->

                <div class="block">
                    <div class="block-head">
                        HOD Review
                    </div>
                    <table>
                        <tr>
                            <th class="w-30">HOD Remarks</th>
                            <td class="w-20">
                                @if ($data->HOD_Remarks)
                                    {{ strip_tags($data->HOD_Remarks) }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>
                    </table>
                    <div class="border-table">
                        <div class="block-head">
                            HOD Attachments
                        </div>
                        <table>

                            <tr class="table_bg">
                                <th class="w-20">S.N.</th>
                                <th class="w-60">Attachment</th>
                            </tr>
                            @if ($data->Audit_file)
                                @foreach (json_decode($data->Audit_file) as $key => $file)
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
                    QA Initial Review
                </div>
                <table>

                    <tr>
                        <th class="w-20">Initial Deviation category</th>
                        <td class="w-30">
                            @if ($data->Deviation_category)
                                {{ $data->Deviation_category }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Justification for categorization</th>
                        <td class="w-30">
                            @if ($data->Justification_for_categorization)
                                {{ strip_tags($data->Justification_for_categorization) }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Investigation Required?</th>
                        <td class="w-30">
                            @if ($data->Investigation_required)
                                {{ $data->Investigation_required }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Investigation Details</th>
                        <td class="w-30">
                            @if ($data->Investigation_Details)
                                {{ $data->Investigation_Details }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        {{-- <th class="w-20">Customer Notification Required ?</th> --}}
                        {{-- <td class="w-30">@if ($data->Customer_notification){{$data->Customer_notification}}@else Not Applicable @endif</td> --}}
                        {{-- <th class="w-20">Customers</th> --}}
                        {{-- <td class="w-30">@if ($data->customers){{ $data->customers }}@else Not Applicable @endif</td> --}}
                        {{-- @php
                            $customer = DB::table('customer-details')->where('id', $data->customers)->first();
                            $customer_name = $customer ? $customer->customer_name : 'Not Applicable';
                        @endphp --}}

                        {{-- <td>
                        @if ($data->customers)
                            {{ $customer_name }}
                        @else
                            Not Applicable
                        @endif
                    </td> --}}
                    </tr>

                    <tr>
                        {{-- <th class="w-20">Related Records</th> --}}
                        {{-- <td class="w-30">@if ($data->related_records){{$data->related_records }}@else Not Applicable @endif</td> --}}
                        <th class="w-20">QA Initial Remarks</th>
                        <td class="w-30">
                            @if ($data->QAInitialRemark)
                                {{ strip_tags($data->QAInitialRemark) }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                    </tr>

                </table>
            </div>

            <div class="border-table">
                <div class="block-head">
                    QA Initial Attachments
                </div>
                <table>

                    <tr class="table_bg">
                        <th class="w-20">S.N.</th>
                        <th class="w-60">Attachment</th>
                    </tr>
                    @if ($data->Initial_attachment)
                        @foreach (json_decode($data->Initial_attachment) as $key => $file)
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
                        CFT
                    </div>
                    <div class="head">
                        <div class="block-head">
                            Production
                        </div>
                        <table>

                            <tr>

                                <th class="w-20">Production Review Required ?
                                </th>
                                <td class="w-30">
                                    <div>
                                        @if ($data1->Production_Review)
                                            {{ $data1->Production_Review }}
                                        @else
                                            Not Applicable
                                        @endif
                                    </div>
                                </td>
                                <th class="w-20">Production Person</th>
                                <td class="w-30">
                                    <div>
                                        @if ($data1->Production_person)
                                            {{ $data1->Production_person }}
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
                                        @if ($data1->Production_assessment)
                                            {{ $data1->Production_assessment }}
                                        @else
                                            Not Applicable
                                        @endif
                                    </div>
                                </td>
                                <th class="w-20">Production Feedback</th>
                                <td class="w-30">
                                    <div>
                                        @if ($data1->Production_feedback)
                                            {{ $data1->Production_feedback }}
                                        @else
                                            Not Applicable
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            <tr>

                                <th class="w-20">Production Review Completed By</th>
                                <td class="w-30">
                                    <div>
                                        @if ($data1->Production_Review_Completed_By)
                                            {{ $data1->production_by }}
                                        @else
                                            Not Applicable
                                        @endif
                                    </div>
                                </td>
                                <th class="w-20">Production Review Completed On</th>
                                <td class="w-30">
                                    <div>
                                        @if ($data1->production_on)
                                            {{ $data1->production_on }}
                                        @else
                                            Not Applicable
                                        @endif
                                    </div>
                                </td>
                            </tr>

                        </table>
                    </div>
                    <div class="border-table">
                        <div class="block-">
                            Production Attachments
                        </div>
                        <table>

                            <tr class="table_bg">
                                <th class="w-20">S.N.</th>
                                <th class="w-60">Attachment</th>
                            </tr>
                            @if ($data1->production_attachment)
                                @foreach (json_decode($data1->production_attachment) as $key => $file)
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
                                Warehouse
                            </div>
                            <table>

                                <tr>

                                    <th class="w-20">Warehouse Review Required ?
                                    </th>
                                    <td class="w-30">
                                        <div>
                                            @if ($data1->Warehouse_review)
                                                {{ $data1->Warehouse_review }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </div>
                                    </td>
                                    <th class="w-20">Warehouse Person</th>
                                    <td class="w-30">
                                        <div>
                                            @if ($data1->Warehouse_notification)
                                                {{ $data1->Warehouse_notification }}
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
                                            @if ($data1->Warehouse_assessment)
                                                {{ $data1->Warehouse_assessment }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </div>
                                    </td>
                                    <th class="w-20">Warehouse Feedback</th>
                                    <td class="w-30">
                                        <div>
                                            @if ($data1->Warehouse_feedback)
                                                {{ $data1->Warehouse_feedback }}
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
                                            @if ($data1->Warehouse_by)
                                                {{ $data1->Warehouse_by }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </div>
                                    </td>
                                    <th class="w-20">Warehouse Review Completed On</th>
                                    <td class="w-30">
                                        <div>
                                            @if ($data1->Warehouse_Review_Completed_On)
                                                {{ $data1->Warehouse_Review_Completed_On }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="border-table">
                            <div class="block-">
                                Production Attachments 2
                            </div>
                            <table>

                                <tr class="table_bg">
                                    <th class="w-20">S.N.</th>
                                    <th class="w-60">Attachment</th>
                                </tr>
                                @if ($data1->Warehouse_attachment)
                                    @foreach (json_decode($data1->Warehouse_attachment) as $key => $file)
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
                                Quality Control
                            </div>
                            <table>

                                <tr>

                                    <th class="w-20">Quality Control Review Required ?
                                    </th>
                                    <td class="w-30">
                                        <div>
                                            @if ($data1->Quality_review)
                                                {{ $data1->Quality_review }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </div>
                                    </td>
                                    <th class="w-20">Quality Control Person</th>
                                    <td class="w-30">
                                        <div>
                                            @if ($data1->Quality_Control_Person)
                                                {{ $data1->Quality_Control_Person }}
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
                                            @if ($data1->Quality_Control_assessment)
                                                {{ $data1->Quality_Control_assessment }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </div>
                                    </td>
                                    <th class="w-20">Quality Control Feedback</th>
                                    <td class="w-30">
                                        <div>
                                            @if ($data1->Quality_Control_feedback)
                                                {{ $data1->Quality_Control_feedback }}
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
                                            @if ($data1->QualityAssurance__by)
                                                {{ $data1->QualityAssurance__by }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </div>
                                    </td>
                                    <th class="w-20">Quality Review Completed On</th>
                                    <td class="w-30">
                                        <div>
                                            @if ($data1->Quality_Control_on)
                                                {{ $data1->Quality_Control_on }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="border-table">
                            <div class="block-">
                                Quality Control Attachments
                            </div>
                            <table>

                                <tr class="table_bg">
                                    <th class="w-20">S.N.</th>
                                    <th class="w-60">Attachment</th>
                                </tr>
                                @if ($data1->Quality_Control_attachment)
                                    @foreach (json_decode($data1->Quality_Control_attachment) as $key => $file)
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
                                Quality Assurance
                            </div>
                            <table>

                                <tr>

                                    <th class="w-20">Quality Assurance Review Required ?
                                    </th>
                                    <td class="w-30">
                                        <div>
                                            @if ($data1->Quality_Assurance)
                                                {{ $data1->Quality_Assurance }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </div>
                                    </td>
                                    <th class="w-20">Quality Assurance Person</th>
                                    <td class="w-30">
                                        <div>
                                            @if ($data1->QualityAssurance_person)
                                                {{ $data1->QualityAssurance_person }}
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
                                            @if ($data1->QualityAssurance_assessment)
                                                {{ $data1->QualityAssurance_assessment }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </div>
                                    </td>
                                    <th class="w-20">Quality Assurance feedback Feedback</th>
                                    <td class="w-30">
                                        <div>
                                            @if ($data1->Quality_Assurance_feedback)
                                                {{ $data1->Quality_Assurance_feedback }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                <tr>

                                    <th class="w-20">Quality Assurance Review Completed By</th>
                                    <td class="w-30">
                                        <div>
                                            @if ($data1->QualityAssurance_by)
                                                {{ $data1->QualityAssurance_by }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </div>
                                    </td>
                                    <th class="w-20">Quality Assurance Review Completed On</th>
                                    <td class="w-30">
                                        <div>
                                            @if ($data1->QualityAssurance_on)
                                                {{ $data1->QualityAssurance_on }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="border-table">
                            <div class="block-">
                                Quality Assurance Attachments
                            </div>
                            <table>

                                <tr class="table_bg">
                                    <th class="w-20">S.N.</th>
                                    <th class="w-60">Attachment</th>
                                </tr>
                                @if ($data1->Quality_Assurance_attachment)
                                    @foreach (json_decode($data1->Quality_Assurance_attachment) as $key => $file)
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
                                            @if ($data1->Engineering_review)
                                                {{ $data1->Engineering_review }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </div>
                                    </td>
                                    <th class="w-20">Engineering Person</th>
                                    <td class="w-30">
                                        <div>
                                            @if ($data1->Engineering_person)
                                                {{ $data1->Engineering_person }}
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
                                            @if ($data1->Engineering_assessment)
                                                {{ $data1->Engineering_assessment }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </div>
                                    </td>
                                    <th class="w-20">Engineering Feedback</th>
                                    <td class="w-30">
                                        <div>
                                            @if ($data1->Engineering_feedback)
                                                {{ $data1->Engineering_feedback }}
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
                                            @if ($data1->Engineering_by)
                                                {{ $data1->Engineering_by }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </div>
                                    </td>
                                    <th class="w-20"> Engineering Review Completed On</th>
                                    <td class="w-30">
                                        <div>
                                            @if ($data1->Engineering_on)
                                                {{ $data1->Engineering_on }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="border-table">
                            <div class="block-">
                                Engineering Attachments
                            </div>
                            <table>

                                <tr class="table_bg">
                                    <th class="w-20">S.N.</th>
                                    <th class="w-60">Attachment</th>
                                </tr>
                                @if ($data1->Engineering_attachment)
                                    @foreach (json_decode($data1->Engineering_attachment) as $key => $file)
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
                                Analytical Development Laboratory
                            </div>
                            <table>

                                <tr>

                                    <th class="w-20">Analytical Development Laboratory Review Required ?
                                    </th>
                                    <td class="w-30">
                                        <div>
                                            @if ($data1->Analytical_Development_review)
                                                {{ $data1->Analytical_Development_review }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </div>
                                    </td>
                                    <th class="w-20">Analytical Development Laboratory Person</th>
                                    <td class="w-30">
                                        <div>
                                            @if ($data1->Analytical_Development_person)
                                                {{ $data1->Analytical_Development_person }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </div>
                                    </td>
                                </tr>

                                <tr>

                                    <th class="w-20">Impact Assessment (By Analytical Development Laboratory)</th>
                                    <td class="w-30">
                                        <div>
                                            @if ($data1->Analytical_Development_assessment)
                                                {{ $data1->Analytical_Development_assessment }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </div>
                                    </td>
                                    <th class="w-20">Analytical Development Laboratory Feedback</th>
                                    <td class="w-30">
                                        <div>
                                            @if ($data1->Analytical_Development_feedback)
                                                {{ $data1->Analytical_Development_feedback }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                <tr>

                                    <th class="w-20">Analytical Development Laboratory Review Completed By</th>
                                    <td class="w-30">
                                        <div>
                                            @if ($data1->Analytical_Development_by)
                                                {{ $data1->Analytical_Development_by }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </div>
                                    </td>
                                    <th class="w-20">Analytical Development Laboratory Review Completed On</th>
                                    <td class="w-30">
                                        <div>
                                            @if ($data1->Analytical_Development_on)
                                                {{ $data1->Analytical_Development_on }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="border-table">
                            <div class="block-">
                                Analytical Development Laboratory Attachments
                            </div>
                            <table>

                                <tr class="table_bg">
                                    <th class="w-20">S.N.</th>
                                    <th class="w-60">Attachment</th>
                                </tr>
                                @if ($data1->Analytical_Development_attachment)
                                    @foreach (json_decode($data1->Analytical_Development_attachment) as $key => $file)
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
                                Process Development Laboratory / Kilo Lab
                            </div>
                            <table>

                                <tr>

                                    <th class="w-20">Process Development Laboratory / Kilo Lab Review Required ?
                                    </th>
                                    <td class="w-30">
                                        <div>
                                            @if ($data1->Kilo_Lab_review)
                                                {{ $data1->Kilo_Lab_review }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </div>
                                    </td>
                                    <th class="w-20">Process Development Laboratory / Kilo Lab Person</th>
                                    <td class="w-30">
                                        <div>
                                            @if ($data1->Kilo_Lab_person)
                                                {{ $data1->Kilo_Lab_person }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </div>
                                    </td>
                                </tr>

                                <tr>

                                    <th class="w-20">Impact Assessment (By Process Development Laboratory / Kilo Lab)
                                        </th>
                                    <td class="w-30">
                                        <div>
                                            @if ($data1->Kilo_Lab_assessment)
                                                {{ $data1->Kilo_Lab_assessment }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </div>
                                    </td>
                                    <th class="w-20">Process Development Laboratory / Kilo Lab Feedback</th>
                                    <td class="w-30">
                                        <div>
                                            @if ($data1->Kilo_Lab_feedback)
                                                {{ $data1->Kilo_Lab_feedback }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                <tr>

                                    <th class="w-20">Process Development Laboratory / Kilo Lab Review Completed By
                                    </th>
                                    <td class="w-30">
                                        <div>
                                            @if ($data1->Kilo_Lab_attachment_by)
                                                {{ $data1->Kilo_Lab_attachment_by }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </div>
                                    </td>
                                    <th class="w-20">Process Development Laboratory / Kilo Lab Review Completed On
                                    </th>
                                    <td class="w-30">
                                        <div>
                                            @if ($data1->Kilo_Lab_attachment_on)
                                                {{ $data1->Kilo_Lab_attachment_on }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="border-table">
                            <div class="block-">
                                Process Development
                            </div>
                            <table>

                                <tr class="table_bg">
                                    <th class="w-20">S.N.</th>
                                    <th class="w-60">Attachment</th>
                                </tr>
                                @if ($data1->Kilo_Lab_attachment)
                                    @foreach (json_decode($data1->Kilo_Lab_attachment) as $key => $file)
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
                                Technology Transfer / Design
                            </div>
                            <table>

                                <tr>

                                    <th class="w-20">Technology Transfer / Design Review Required ?
                                    </th>
                                    <td class="w-30">
                                        <div>
                                            @if ($data1->Technology_transfer_review)
                                                {{ $data1->Technology_transfer_review }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </div>
                                    </td>
                                    <th class="w-20">Technology Transfer / Design Person</th>
                                    <td class="w-30">
                                        <div>
                                            @if ($data1->Technology_transfer_person)
                                                {{ $data1->Technology_transfer_person }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </div>
                                    </td>
                                </tr>

                                <tr>

                                    <th class="w-20">Impact Assessment (By Technology Transfer / Design)</th>
                                    <td class="w-30">
                                        <div>
                                            @if ($data1->Technology_transfer_assessment)
                                                {{ $data1->Technology_transfer_assessment }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </div>
                                    </td>
                                    <th class="w-20">Technology Transfer / Design Feedback</th>
                                    <td class="w-30">
                                        <div>
                                            @if ($data1->Technology_transfer_feedback)
                                                {{ $data1->Technology_transfer_feedback }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                <tr>

                                    <th class="w-20">Technology Transfer / Design Review Completed By</th>
                                    <td class="w-30">
                                        <div>
                                            @if ($data1->Technology_transfer_by)
                                                {{ $data1->Technology_transfer_by }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </div>
                                    </td>
                                    <th class="w-20"> Technology Transfer / Design Review Completed On</th>
                                    <td class="w-30">
                                        <div>
                                            @if ($data1->Technology_transfer_on)
                                                {{ $data1->Technology_transfer_on }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="border-table">
                            <div class="block-">
                                Technology Transfer / Design Attachments
                            </div>
                            <table>

                                <tr class="table_bg">
                                    <th class="w-20">S.N.</th>
                                    <th class="w-60">Attachment</th>
                                </tr>
                                @if ($data1->Technology_transfer_attachment)
                                    @foreach (json_decode($data1->Technology_transfer_attachment) as $key => $file)
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
                                Environment, Health & Safety
                            </div>
                            <table>

                                <tr>

                                    <th class="w-20">Environment, Health & Safety Review Required ?
                                    </th>
                                    <td class="w-30">
                                        <div>
                                            @if ($data1->Environment_Health_review)
                                                {{ $data1->Environment_Health_review }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </div>
                                    </td>
                                    <th class="w-20">Environment, Health & Safety Person</th>
                                    <td class="w-30">
                                        <div>
                                            @if ($data1->Environment_Health_Safety_person)
                                                {{ $data1->Environment_Health_Safety_person }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </div>
                                    </td>
                                </tr>

                                <tr>

                                    <th class="w-20">Impact Assessment (By Environment, Health & Safety)</th>
                                    <td class="w-30">
                                        <div>
                                            @if ($data1->Health_Safety_assessment)
                                                {{ $data1->Health_Safety_assessment }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </div>
                                    </td>
                                    <th class="w-20">Environment, Health & Safety Feedback</th>
                                    <td class="w-30">
                                        <div>
                                            @if ($data1->Health_Safety_feedback)
                                                {{ $data1->Health_Safety_feedback }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                <tr>

                                    <th class="w-20">Environment, Health & Safety Review Completed By</th>
                                    <td class="w-30">
                                        <div>
                                            @if ($data1->production_by)
                                                {{ $data1->Human_Resource_by }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </div>
                                    </td>
                                    <th class="w-20"> Environment, Health & Safety Review Completed On</th>
                                    <td class="w-30">
                                        <div>
                                            @if ($data1->Human_Resource_on)
                                                {{ $data1->Human_Resource_on }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="border-table">
                            <div class="block-">
                                Environment, Health & Safety Attachments
                            </div>
                            <table>

                                <tr class="table_bg">
                                    <th class="w-20">S.N.</th>
                                    <th class="w-60">Attachment</th>
                                </tr>
                                @if ($data1->Human_Resource_attachment)
                                    @foreach (json_decode($data1->Human_Resource_attachment) as $key => $file)
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
                                Human Resource & Administration
                            </div>
                            <table>

                                <tr>

                                    <th class="w-20">Human Resource & Administration Review Required ?
                                    </th>
                                    <td class="w-30">
                                        <div>
                                            @if ($data1->Human_Resource_review)
                                                {{ $data1->Human_Resource_review }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </div>
                                    </td>
                                    <th class="w-20">Human Resource & Administration Person</th>
                                    <td class="w-30">
                                        <div>
                                            @if ($data1->Human_Resource_person)
                                                {{ $data1->Human_Resource_person }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </div>
                                    </td>
                                </tr>

                                <tr>

                                    <th class="w-20">Impact Assessment (By Human Resource & Administration)</th>
                                    <td class="w-30">
                                        <div>
                                            @if ($data1->Human_Resource_assessment)
                                                {{ $data1->Human_Resource_assessment }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </div>
                                    </td>
                                    <th class="w-20">Human Resource & Administration Feedback</th>
                                    <td class="w-30">
                                        <div>
                                            @if ($data1->Human_Resource_feedback)
                                                {{ $data1->Human_Resource_feedback }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                <tr>

                                    <th class="w-20">Human Resource & Administration Review Completed By</th>
                                    <td class="w-30">
                                        <div>
                                            @if ($data1->Human_Resource_by)
                                                {{ $data1->production_by }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </div>
                                    </td>
                                    <th class="w-20"> Human Resource & Administration Review Completed On</th>
                                    <td class="w-30">
                                        <div>
                                            @if ($data1->production_on)
                                                {{ $data1->production_on }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="border-table">
                            <div class="block-">
                                Human Resource & Administration Attachments
                            </div>
                            <table>

                                <tr class="table_bg">
                                    <th class="w-20">S.N.</th>
                                    <th class="w-60">Attachment</th>
                                </tr>
                                @if ($data1->Initial_attachment)
                                    @foreach (json_decode($data1->Initial_attachment) as $key => $file)
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
                    ---
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
                                            @if ($data1->Information_Technology_review)
                                                {{ $data1->Information_Technology_review }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </div>
                                    </td>
                                    <th class="w-20">Information Technology Person</th>
                                    <td class="w-30">
                                        <div>
                                            @if ($data1->Information_Technology_person)
                                                {{ $data1->Information_Technology_person }}
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
                                            @if ($data1->Information_Technology_assessment)
                                                {{ $data1->Information_Technology_assessment }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </div>
                                    </td>
                                    <th class="w-20">Information Technology Feedback</th>
                                    <td class="w-30">
                                        <div>
                                            @if ($data1->Information_Technology_feedback)
                                                {{ $data1->Information_Technology_feedback }}
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
                                            @if ($data1->Information_Technology_by)
                                                {{ $data1->Information_Technology_by }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </div>
                                    </td>
                                    <th class="w-20"> Information Technology Review Completed On</th>
                                    <td class="w-30">
                                        <div>
                                            @if ($data1->Information_Technology_on)
                                                {{ $data1->Information_Technology_on }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="border-table">
                            <div class="block-">
                                Information Technology Attachments
                            </div>
                            <table>

                                <tr class="table_bg">
                                    <th class="w-20">S.N.</th>
                                    <th class="w-60">Attachment</th>
                                </tr>
                                @if ($data1->Information_Technology_attachment)
                                    @foreach (json_decode($data1->Information_Technology_attachment) as $key => $file)
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
                                Project Management

                            </div>
                            <table>

                                <tr>

                                    <th class="w-20">Project Management Review Required ?
                                    </th>
                                    <td class="w-30">
                                        <div>
                                            @if ($data1->Project_management_review)
                                                {{ $data1->Project_management_review }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </div>
                                    </td>
                                    <th class="w-20">Project Management Person</th>
                                    <td class="w-30">
                                        <div>
                                            @if ($data1->Project_management_person)
                                                {{ $data1->Project_management_person }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </div>
                                    </td>
                                </tr>

                                <tr>

                                    <th class="w-20">Impact Assessment (By Project Management)</th>
                                    <td class="w-30">
                                        <div>
                                            @if ($data1->Project_management_assessment)
                                                {{ $data1->Project_management_assessment }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </div>
                                    </td>
                                    <th class="w-20">Project Management Feedback</th>
                                    <td class="w-30">
                                        <div>
                                            @if ($data1->Project_management_feedback)
                                                {{ $data1->Project_management_feedback }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                <tr>

                                    <th class="w-20">Project Management Review Completed By</th>
                                    <td class="w-30">
                                        <div>
                                            @if ($data1->Project_management_by)
                                                {{ $data1->Project_management_by }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </div>
                                    </td>
                                    <th class="w-20"> Project Management Review Completed On</th>
                                    <td class="w-30">
                                        <div>
                                            @if ($data1->Project_management_on)
                                                {{ $data1->Project_management_on }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="border-table">
                            <div class="block-">
                                Project Management Attachments
                            </div>
                            <table>

                                <tr class="table_bg">
                                    <th class="w-20">S.N.</th>
                                    <th class="w-60">Attachment</th>
                                </tr>
                                @if ($data1->Project_management_attachment)
                                    @foreach (json_decode($data1->Project_management_attachment) as $key => $file)
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
                                            @if ($data1->Other1_review)
                                                {{ $data1->Other1_review }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </div>
                                    </td>
                                    <th class="w-20">Other's 1 Person</th>
                                    <td class="w-30">
                                        <div>
                                            @if ($data1->Other1_person)
                                                {{ $data1->Other1_person }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </div>
                                    </td>
                                    <th class="w-20">Other's 1 Department</th>
                                    <td class="w-30">
                                        <div>
                                            @if ($data1->Other1_Department_person)
                                                {{ $data1->Other1_Department_person }}
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
                                            @if ($data1->Other1_assessment)
                                                {{ $data1->Other1_assessment }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </div>
                                    </td>
                                    <th class="w-20">Other's 1 Feedback</th>
                                    <td class="w-30">
                                        <div>
                                            @if ($data1->Other1_feedback)
                                                {{ $data1->Other1_feedback }}
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
                                            @if ($data1->Other1_by)
                                                {{ $data1->Other1_by }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </div>
                                    </td>
                                    <th class="w-20"> Other's 1 Review Completed On</th>
                                    <td class="w-30">
                                        <div>
                                            @if ($data1->Other1_on)
                                                {{ $data1->Other1_on }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="border-table">
                            <div class="block-">
                                Other's 1 Attachments
                            </div>
                            <table>

                                <tr class="table_bg">
                                    <th class="w-20">S.N.</th>
                                    <th class="w-60">Attachment</th>
                                </tr>
                                @if ($data1->Other1_attachment)
                                    @foreach (json_decode($data1->Other1_attachment) as $key => $file)
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
                                            @if ($data1->Other2_review)
                                                {{ $data1->Other2_review }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </div>
                                    </td>
                                    <th class="w-20">Other's 2 Person</th>
                                    <td class="w-30">
                                        <div>
                                            @if ($data1->Other2_person)
                                                {{ $data1->Other2_person }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </div>
                                    </td>
                                    <th class="w-20">Other's 2 Department</th>
                                    <td class="w-30">
                                        <div>
                                            @if ($data1->Other2_Department_person)
                                                {{ $data1->Other2_Department_person }}
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
                                            @if ($data1->Other2_assessment)
                                                {{ $data1->Other2_assessment }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </div>
                                    </td>
                                    <th class="w-20">Other's 2 Feedback</th>
                                    <td class="w-30">
                                        <div>
                                            @if ($data1->Other2_feedback)
                                                {{ $data1->Other2_feedback }}
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
                                            @if ($data1->Other2_by)
                                                {{ $data1->Other2_by }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </div>
                                    </td>
                                    <th class="w-20"> Other's 2 Review Completed On</th>
                                    <td class="w-30">
                                        <div>
                                            @if ($data1->Other2_on)
                                                {{ $data1->Other2_on }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="border-table">
                            <div class="block-">
                                Other's 2 Attachments
                            </div>
                            <table>

                                <tr class="table_bg">
                                    <th class="w-20">S.N.</th>
                                    <th class="w-60">Attachment</th>
                                </tr>
                                @if ($data1->Other2_attachment)
                                    @foreach (json_decode($data1->Other2_attachment) as $key => $file)
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
                                            @if ($data1->Other3_review)
                                                {{ $data1->Other3_review }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </div>
                                    </td>
                                    <th class="w-20">Other's 3 Person</th>
                                    <td class="w-30">
                                        <div>
                                            @if ($data1->Other3_person)
                                                {{ $data1->Other3_person }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </div>
                                    </td>
                                    <th class="w-20">Other's 3 Department</th>
                                    <td class="w-30">
                                        <div>
                                            @if ($data1->Other3_Department_person)
                                                {{ $data1->Other3_Department_person }}
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
                                            @if ($data1->Other3_assessment)
                                                {{ $data1->Other3_assessment }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </div>
                                    </td>
                                    <th class="w-20">Other's 3 Feedback</th>
                                    <td class="w-30">
                                        <div>
                                            @if ($data1->Other3_feedback)
                                                {{ $data1->Other3_feedback }}
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
                                            @if ($data1->Other3_by)
                                                {{ $data1->Other3_by }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </div>
                                    </td>
                                    <th class="w-20"> Other's 3 Review Completed On</th>
                                    <td class="w-30">
                                        <div>
                                            @if ($data1->Other3_on)
                                                {{ $data1->Other3_on }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="border-table">
                            <div class="block-">
                                Other's 3 Attachments
                            </div>
                            <table>

                                <tr class="table_bg">
                                    <th class="w-20">S.N.</th>
                                    <th class="w-60">Attachment</th>
                                </tr>
                                @if ($data1->Other3_attachment)
                                    @foreach (json_decode($data1->Other3_attachment) as $key => $file)
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
                                            @if ($data1->Other4_review)
                                                {{ $data1->Other4_review }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </div>
                                    </td>
                                    <th class="w-20">Other's 4 Person</th>
                                    <td class="w-30">
                                        <div>
                                            @if ($data1->Other4_person)
                                                {{ $data1->Other4_person }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </div>
                                    </td>
                                    <th class="w-20">Other's 4 Department</th>
                                    <td class="w-30">
                                        <div>
                                            @if ($data1->Other4_Department_person)
                                                {{ $data1->Other4_Department_person }}
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
                                            @if ($data1->Other4_assessment)
                                                {{ $data1->Other4_assessment }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </div>
                                    </td>
                                    <th class="w-20">Other's 4 Feedback</th>
                                    <td class="w-30">
                                        <div>
                                            @if ($data1->Other4_feedback)
                                                {{ $data1->Other4_feedback }}
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
                                            @if ($data1->Other4_by)
                                                {{ $data1->Other4_by }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </div>
                                    </td>
                                    <th class="w-20"> Other's 4 Review Completed On</th>
                                    <td class="w-30">
                                        <div>
                                            @if ($data1->Other4_on)
                                                {{ $data1->Other4_on }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="border-table">
                            <div class="block-">
                                Other's 4 Attachments
                            </div>
                            <table>

                                <tr class="table_bg">
                                    <th class="w-20">S.N.</th>
                                    <th class="w-60">Attachment</th>
                                </tr>
                                @if ($data1->Other4_attachment)
                                    @foreach (json_decode($data1->Other4_attachment) as $key => $file)
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
                                            @if ($data1->Other5_review)
                                                {{ $data1->Other5_review }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </div>
                                    </td>
                                    <th class="w-20">Other's 5 Person</th>
                                    <td class="w-30">
                                        <div>
                                            @if ($data1->Other5_person)
                                                {{ $data1->Other5_person }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </div>
                                    </td>
                                    <th class="w-20">Other's 5 Department</th>
                                    <td class="w-30">
                                        <div>
                                            @if ($data1->Other5_Department_person)
                                                {{ $data1->Other5_Department_person }}
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
                                            @if ($data1->Other5_assessment)
                                                {{ $data1->Other5_assessment }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </div>
                                    </td>
                                    <th class="w-20">Other's 5 Feedback</th>
                                    <td class="w-30">
                                        <div>
                                            @if ($data1->Other5_feedback)
                                                {{ $data1->Other5_feedback }}
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
                                            @if ($data1->Other5_by)
                                                {{ $data1->Other5_by }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </div>
                                    </td>
                                    <th class="w-20"> Other's 5 Review Completed On</th>
                                    <td class="w-30">
                                        <div>
                                            @if ($data1->Other5_on)
                                                {{ $data1->Other5_on }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="border-table">
                            <div class="block-">
                                Other's 5 Attachments
                            </div>
                            <table>

                                <tr class="table_bg">
                                    <th class="w-20">S.N.</th>
                                    <th class="w-60">Attachment</th>
                                </tr>
                                @if ($data1->Other5_attachment)
                                    @foreach (json_decode($data1->Other5_attachment) as $key => $file)
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

                    <!-- **************************INVESTIGATION TAB START******************************* -->

                    <div class="block">
                        <div class="head">
                            <div class="block-head">
                                Investigation
                            </div>
                            <table>
                                <tr>
                                    <th class="w-20">Proposed Due Date
                                    </th>
                                    <td class="w-30">
                                        <div>
                                            @if ($investigationExtension && $investigationExtension->investigation_proposed_due_date) {{  Helpers::getdateFormat($investigationExtension->investigation_proposed_due_date)  }} @else Not Applicable @endif
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="w-20">Description of Event
                                    </th>
                                    <td class="w-30">
                                        <div>
                                            @if ($data->Discription_Event) {{ strip_tags($data->Discription_Event) }} @else Not Applicable @endif
                                        </div>
                                    </td>
                                    <th class="w-20">Objective</th>
                                    <td class="w-30">
                                        <div>
                                            @if ($data->objective) {{ strip_tags($data->objective) }} @else Not Applicable @endif
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="w-20">Scope</th>
                                    <td class="w-80">
                                        <div>
                                            @if ($data->scope) {{ strip_tags($data->scope) }} @else Not Applicable @endif
                                        </div>
                                    </td>
                                    <th class="w-20">Immediate Action</th>
                                    <td class="w-30">
                                        <div>
                                            @if ($data->imidiate_action) {{ strip_tags($data->imidiate_action) }} @else Not Applicable @endif
                                        </div>
                                    </td>
                                </tr>

                                <!-- {{-- <tr> --}} -->


                                <!-- {{-- <th class="w-20">CAPA Type?</th> --}}
                                {{-- <td class="w-30">
                            <div>
                                @if ($data->capa_type){{ $data->capa_type }}@else Not Applicable @endif
                            </div>
                        </td> --}} -->
                                <!-- {{-- </tr> --}} -->
                                <tr>

                                    <th class="w-20">CAPA Description</th>
                                    <td class="w-30">
                                        <div>
                                            @if ($data->CAPA_Description)
                                                {{ $data->CAPA_Description }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </div>
                                    </td>
                                    <th class="w-20">Post Categorization Of Deviationt</th>
                                    <td class="w-30">
                                        <div>
                                            @if ($data->Post_Categorization)
                                                {{ $data->Post_Categorization }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="w-20"> Justification For Revised category
                                    </th>
                                    <td class="w-30">
                                        <div>
                                            @if ($data->Investigation_Of_Review)
                                                {{ strip_tags($data->Investigation_Of_Review) }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <th class="w-20">Investigation Approach</th>
                                    <td class="w-30">
                                        <div>
                                            <!-- @if ($data->Investigation_Of_Review)
                                            {{ $data->Investigation_Of_Review }}
                                            @else
                                            Not Applicable
                                            @endif -->
                                        </div>
                                    </td>

                                </tr>
                            </table>

                            <div class="border-table" style="margin-bottom: 15px;">
                            <div class="block-" style="margin-bottom:5px; font-weight:bold;">Investigation team and Responsibilities</div>
                                <table>
                                    <tr class="table_bg">
                                        <th class="w-20">S.N.</th>
                                        <th class="w-60">Investigation Team</th>
                                        <th class="w-60">Responsibility</th>
                                        <th class="w-60">Remarks</th>
                                    </tr>
                                    <tbody>
                                        @if($investigation_data && is_array($investigation_data))
                                            @php
                                                $serialNumber = 1;
                                                // Get all users and map them by id
                                                $users = DB::table('users')->pluck('name', 'id')->all();
                                            @endphp
                                            @foreach($investigation_data as $investigation_item)
                                                <tr>
                                                    <td class="w-20">{{ $serialNumber++ }}</td>
                                                    <td class="w-20">
                                                        {{ isset($users[$investigation_item['teamMember']]) ? $users[$investigation_item['teamMember']] : 'Unknown User' }}
                                                    </td>
                                                    <td class="w-20">{{ $investigation_item['responsibility'] }}</td>
                                                    <td class="w-20">{{ $investigation_item['remarks'] }}</td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td class="w-20">1</td>
                                                <td class="w-20">Not Applicable</td>
                                                <td class="w-20">Not Applicable</td>
                                                <td class="w-20">Not Applicable</td>
                                            </tr>
                                        @endif
        </tbody>
    </table>
</div>

                            <div class="border-table" style="margin-bottom: 15px;">
                                <div class="block-" style="margin-bottom:5px; font-weight:bold;">
                                    Root Cause
                                </div>
                                <table>
                                    <tr class="table_bg">
                                        <th class="w-20">S.N.</th>
                                        <th class="w-60">Root Cause Category</th>
                                        <th class="w-60">Root Cause Sub-Category</th>
                                        <th class="w-60">Others</th>
                                        <th class="w-60">Probability</th>
                                        <th class="w-60">Remark</th>
                                    </tr>

                                    <tbody>
                                    {{-- @if($root_cause_data && is_array($root_cause_data))
                                        @php
                                            $serialNumber = 1;
                                        @endphp
                                        @foreach($root_cause_data as $rootCause_data)
                                            <tr>
                                                <td class="w-20">{{ $serialNumber++ }}</td>
                                                <td class="w-20">{{ $rootCause_data['rootCauseCategory'] }}</td>
                                                <td class="w-20">{{ $rootCause_data['rootCauseSubCategory'] }}</td>
                                                <td class="w-20">{{ $rootCause_data['ifOthers'] }}</td>
                                                <td class="w-20">{{ $rootCause_data['probability'] }}</td>
                                                <td class="w-20">{{ $rootCause_data['remarks'] }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                            <tr>
                                                <td class="w-20">1</td>
                                                <td class="w-20">Not Applicable</td>
                                                <td class="w-20">Not Applicable</td>
                                                <td class="w-20">Not Applicable</td>
                                                <td class="w-20">Not Applicable</td>
                                                <td class="w-20">Not Applicable</td>
                                            </tr>
                                    @endif --}}
                                </tbody>
                                </table>
                            </div>

                            <div class="border-table" style="margin-bottom: 15px;">
                                <div class="block-head">
                                    Why Why Chart
                                </div>

                                <!-- *********************** WHY 1 *********************** -->
                                <div class="block-" style="margin-bottom:5px; font-weight:bold;">
                                    Why 1
                                </div>

                                <table>
                                    <tr>
                                        <th class="w-20">Problem Statement</th>
                                        <td class="w-30">
                                            <div>
                                                @if ($why_data && $why_data['problem_statement'])
                                                    {{ $why_data['problem_statement'] }}
                                                @else
                                                    Not Applicable
                                                @endif
                                            </div>
                                        </td>
                                        <th class="w-20">Root Cause</th>
                                        <td class="w-30">
                                            <div>
                                                @if ($why_data && $why_data['root-cause'])
                                                    {{ $why_data['root-cause'] }}
                                                @else
                                                    Not Applicable
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                                <table>
                                    <tr class="table_bg">
                                        <th class="w-20">S.N.</th>
                                        <th class="w-60">Description</th>
                                    </tr>
                                    <tbody>
                                        @if($why_data && is_array($why_data['why_1']))
                                        @php
                                            $serialNumber = 1;
                                        @endphp
                                            @foreach($why_data['why_1'] as $whyData)
                                                <tr>
                                                    <td class="w-20">{{ $serialNumber++ }}</td>
                                                    <td class="w-20">{{ $whyData }}</td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td class="w-20">1</td>
                                                <td class="w-20">Not Applicable</td>
                                            </tr>
                                        @endif                                        
                                    </tbody>
                                </table>


                                <!-- *********************** WHY 2 *********************** -->
                                <div class="block-" style="margin-bottom:5px;  font-weight:bold;">
                                    Why 2
                                </div>
                                <table>
                                    <tr class="table_bg">
                                        <th class="w-20">S.N.</th>
                                        <th class="w-60">Description</th>
                                    </tr>
                                    <tbody>
                                        @if($why_data && is_array($why_data['why_2']))
                                        @php
                                            $serialNumber = 1;
                                        @endphp
                                            @foreach($why_data['why_2'] as $whyData)
                                                <tr>
                                                    <td class="w-20">{{ $serialNumber++ }}</td>
                                                    <td class="w-20">{{ $whyData }}</td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td class="w-20">1</td>
                                                <td class="w-20">Not Applicable</td>
                                            </tr>
                                        @endif                                        
                                    </tbody>
                                </table>


                                <!-- *********************** WHY 3 *********************** -->
                                <div class="block-" style="margin-bottom:5px;  font-weight:bold;">
                                    Why 3
                                </div>
                                <table>
                                    <tr class="table_bg">
                                        <th class="w-20">S.N.</th>
                                        <th class="w-60">Description</th>
                                    </tr>
                                    <tbody>
                                        @if($why_data && is_array($why_data['why_3']))
                                        @php
                                            $serialNumber = 1;
                                        @endphp
                                            @foreach($why_data['why_3'] as $whyData)
                                                <tr>
                                                    <td class="w-20">{{ $serialNumber++ }}</td>
                                                    <td class="w-20">{{ $whyData }}</td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td class="w-20">1</td>
                                                <td class="w-20">Not Applicable</td>
                                            </tr>
                                        @endif                                        
                                    </tbody>
                                </table>


                                <!-- *********************** WHY 4 *********************** -->
                                <div class="block-" style="margin-bottom:5px; font-weight:bold;">
                                    Why 4
                                </div>
                                <table>
                                    <tr class="table_bg">
                                        <th class="w-20">S.N.</th>
                                        <th class="w-60">Description</th>
                                    </tr>
                                    <tbody>
                                        @if($why_data && is_array($why_data['why_4']))
                                        @php
                                            $serialNumber = 1;
                                        @endphp
                                            @foreach($why_data['why_4'] as $whyData)
                                                <tr>
                                                    <td class="w-20">{{ $serialNumber++ }}</td>
                                                    <td class="w-20">{{ $whyData }}</td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td class="w-20">1</td>
                                                <td class="w-20">Not Applicable</td>
                                            </tr>
                                        @endif                                        
                                    </tbody>
                                </table>


                                <!-- *********************** WHY 5 *********************** -->
                                <div class="block-" style="margin-bottom:5px; font-weight:bold;">
                                    Why 5
                                </div>
                                <table>
                                    <tr class="table_bg">
                                        <th class="w-20">S.N.</th>
                                        <th class="w-60">Description</th>
                                    </tr>
                                    <tbody>
                                        @if($why_data && is_array($why_data['why_5']))
                                        @php
                                            $serialNumber = 1;
                                        @endphp
                                            @foreach($why_data['why_5'] as $whyData)
                                                <tr>
                                                    <td class="w-20">{{ $serialNumber++ }}</td>
                                                    <td class="w-20">{{ $whyData }}</td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td class="w-20">1</td>
                                                <td class="w-20">Not Applicable</td>
                                            </tr>
                                        @endif                                        
                                    </tbody>
                                </table>
                            </div>

                            <div class="border-table" style="margin-bottom: 15px;">
                                <div class="block-" style="margin-bottom: 5px; font-weight:bold;">
                                    Category of Human Error
                                </div>
                                <table>
                                    <tr class="table_bg">
                                        <th class="w-20">S.N.</th>
                                        <th class="w-60">Gap Category</th>
                                        <th class="w-60">Issues</th>
                                        <th class="w-60">Actions</th>
                                        <th class="w-60">Remark</th>
                                    </tr>

                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>Attention</td>
                                            <td>{{ $data->attention_issues}}</td>
                                            <td>{{ $data->attention_actions}}</td>
                                            <td>{{ $data->attention_remarks}}</td>
                                        </tr>

                                        <tr>
                                            <td>2</td>
                                            <td>Understanding</td>
                                            <td>{{ $data->understanding_issues}}</td>
                                            <td>{{ $data->understanding_actions}}</td>
                                            <td>{{ $data->understanding_remarks}}</td>
                                        </tr>

                                        <tr>
                                            <td>3</td>
                                            <td>Procedural</td>
                                            <td>{{ $data->procedural_issues}}</td>
                                            <td>{{ $data->procedural_actions}}</td>
                                            <td>{{ $data->procedural_remarks}}</td>
                                        </tr>

                                        <tr>
                                            <td>4</td>
                                            <td>Behavioral</td>
                                            <td>{{ $data->behavioiral_issues}}</td>
                                            <td>{{ $data->behavioiral_actions}}</td>
                                            <td>{{ $data->behavioiral_remarks}}</td>
                                        </tr>

                                        <tr>
                                            <td>5</td>
                                            <td>Skill</td>
                                            <td>{{ $data->skill_issues}}</td>
                                            <td>{{ $data->skill_actions}}</td>
                                            <td>{{ $data->skill_remarks}}</td>
                                        </tr>                                        
                                    </tbody>
                                </table>
                            </div>

                            <div class="border-table" style="margin-bottom: 15px;">
                                <div class="block-" style="margin-bottom: 5px; font-weight:bold;">
                                    Is/Is Not Analysis
                                </div>
                                <table>
                                    <tr class="table_bg">
                                        <th class="w-20">&nbsp;</th>
                                        <th class="w-60">Will Be</th>
                                        <th class="w-60">Will Not Be</th>
                                        <th class="w-60">Rationale</th>
                                    </tr>

                                    <tbody>
                                        <tr>
                                            <td>What</td>
                                            <td>{{ $data->what_will_be }}</td>
                                            <td>{{ $data->what_will_not_be}}</td>
                                            <td>{{ $data->what_rationable}}</td>
                                        </tr>

                                        <tr>
                                            <td>Where</td>
                                            <td>{{ $data->where_will_be}}</td>
                                            <td>{{ $data->where_will_not_be}}</td>
                                            <td>{{ $data->where_rationable}}</td>
                                        </tr>

                                        <tr>
                                            <td>When</td>
                                            <td>{{ $data->when_will_be}}</td>
                                            <td>{{ $data->when_will_not_be}}</td>
                                            <td>{{ $data->when_rationable}}</td>
                                        </tr>

                                        <tr>
                                            <td>Coverage</td>
                                            <td>{{ $data->coverage_will_be}}</td>
                                            <td>{{ $data->coverage_will_not_be}}</td>
                                            <td>{{ $data->coverage_rationable}}</td>
                                        </tr>

                                        <tr>
                                            <td>Who</td>
                                            <td>{{ $data->who_will_be}}</td>
                                            <td>{{ $data->who_will_not_be}}</td>
                                            <td>{{ $data->who_rationable}}</td>
                                        </tr>                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="border-table">
                            <div class="block-head">
                                Investigation Attachment
                            </div>
                            <table>

                                <tr class="table_bg">
                                    <th class="w-20">S.N.</th>
                                    <th class="w-60">Attachment</th>
                                </tr>
                                @if ($data->Investigation_attachment)
                                    @foreach (json_decode($data->Investigation_attachment) as $key => $file)
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
                        <div class="border-table">
                            <div class="block-head">
                                CAPA Attachment
                            </div>
                            <table>

                                <tr class="table_bg">
                                    <th class="w-20">S.N.</th>
                                    <th class="w-60">Attachment</th>
                                </tr>
                                @if ($data->Capa_attachment)
                                    @foreach (json_decode($data->Capa_attachment) as $key => $file)
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
                            <div class="block-head">
                                QA Final Review
                            </div>
                            <table>

                                <tr>
                                    <th class="w-20">QA Feedbacks</th>
                                    <td class="w-30">
                                        @if ($data->QA_Feedbacks)
                                            {{ strip_tags($data->QA_Feedbacks) }}
                                        @else
                                            Not Applicable
                                        @endif
                                    </td>

                            </table>
                        </div>
                        <div class="border-table">
                            <div class="block-head">
                                QA Attachments
                            </div>
                            <table>

                                <tr class="table_bg">
                                    <th class="w-20">S.N.</th>
                                    <th class="w-60">Attachment</th>
                                </tr>
                                @if ($data->QA_attachments)
                                    @foreach (json_decode($data->QA_attachments) as $key => $file)
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

                    <!-- **************************INVESTIGATION TAB ENDS******************************** -->



                    <!-- **************************QRM TAB START******************************* -->

                    <div class="block">
                        <div class="head">
                            <div class="block-head">
                                QRM
                            </div>
                            <table>
                                <tr>
                                    <th class="w-20">Proposed Due Date
                                    </th>
                                    <td class="w-30">
                                        <div>
                                            @if ($qrmExtension && $qrmExtension->qrm_proposed_due_date) {{ Helpers::getdateFormat($qrmExtension->qrm_proposed_due_date) }} @else Not Applicable @endif
                                        </div>
                                    </td>
                                    <th class="w-20">Conclusion</th>
                                    <td class="w-30">
                                        <div>
                                            @if ($data->Conclusion) {{ strip_tags($data->Conclusion) }} @else Not Applicable @endif
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="w-20">Identified Risk</th>
                                    <td class="w-80">
                                        <div>
                                            @if ($data->Identified_Risk) {{ strip_tags($data->Identified_Risk) }} @else Not Applicable @endif
                                        </div>
                                    </td>
                                    <th class="w-20">Severity Rate</th>
                                    <td class="w-30">
                                        <div>
                                            @if ($data->severity_rate) {{ $data->severity_rate }} @else Not Applicable @endif
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <th class="w-20">Occurrence</th>
                                    <td class="w-80">
                                        <div>
                                            @if ($data->Occurrence) {{ $data->Occurrence }} @else Not Applicable @endif
                                        </div>
                                    </td>
                                    <th class="w-20">Detection</th>
                                    <td class="w-30">
                                        <div>
                                            @if ($data->detection) {{ $data->detection }} @else Not Applicable @endif
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <th class="w-20">RPN</th>
                                    <td class="w-80">
                                        <div>
                                            @if ($data->rpn) {{ $data->rpn }} @else Not Applicable @endif
                                        </div>
                                    </td>
                                </tr>
                            </table>

                            <div class="border-table">
                                <div class="block-" style="margin:bottom:5px;">
                                    Failure Mode and Effect Analysis
                                </div>
                                <table>
                                    <tr class="table_bg">
                                        <th>Row #</th>
                                        <th>Risk Factor</th>
                                        <th>Risk element </th>
                                        <th>Probable cause of risk element</th>
                                        <th>Existing Risk Controls</th>
                                        <th>Initial Severity- H(3)/M(2)/L(1)</th>
                                    </tr>

                                    <tbody>
                                        @if ($grid_data_qrms && is_array($grid_data_qrms->data))
                                             @php
                                                $serialNumber = 1;
                                            @endphp
                                            @foreach ($grid_data_qrms->data as $grid_item)
                                            <tr>
                                                <td>{{$serialNumber++}}</td>
                                                <td>{{$grid_item['risk_factor']}}</td>
                                                <td>{{$grid_item['risk_element']}}</td>
                                                <td>{{$grid_item['probale_of_risk_element']}}</td>
                                                <td>{{$grid_item['existing_risk_control']}}</td>
                                                <td>{{$grid_item['initial_severity']}}</td>
                                            </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td class="w-20">1</td>
                                                <td class="w-20">Not Applicable</td>
                                                <td class="w-20">Not Applicable</td>
                                                <td class="w-20">Not Applicable</td>
                                                <td class="w-20">Not Applicable</td>
                                                <td class="w-20">Not Applicable</td>
                                            </tr>`
                                        @endif
                                    </tbody>
                                </table>


                                <table style="margin-top:10px;">
                                    <tr class="table_bg">
                                        <th>Row #</th>
                                        <th>Initial Probability- H(3)/M(2)/L(1)</th>
                                        <th>Initial Detectability- H(1)/M(2)/L(3)</th>
                                        <th>Initial RPN</th>
                                        <th>Risk Acceptance (Y/N)</th>
                                        <th>Proposed Additional Risk control measure</th>
                                    </tr>
                                    <tbody>
                                        @if ($grid_data_qrms && is_array($grid_data_qrms->data))
                                            @php
                                                $serialNumber = 1;
                                            @endphp
                                            @foreach ($grid_data_qrms->data as $grid_item)
                                                <tr>
                                                    <td>{{$serialNumber++}}</td>
                                                    <td>{{$grid_item['initial_probability']}}</td>
                                                    <td>{{$grid_item['initial_detectability']}}</td>
                                                    <td>{{$grid_item['initial_rpn']}}</td>
                                                    <td>{{$grid_item['risk_acceptance']}}</td>
                                                    <td>{{$grid_item['proposed_additional_risk_control']}}</td>
                                                </tr>                                                
                                            @endforeach
                                        @else
                                            <tr>
                                                <td class="w-20">1</td>
                                                <td class="w-20">Not Applicable</td>
                                                <td class="w-20">Not Applicable</td>
                                                <td class="w-20">Not Applicable</td>
                                                <td class="w-20">Not Applicable</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>

                                <table style="margin-top:10px;">
                                    <tr class="table_bg">
                                        <th>Row #</th>
                                        <th>Residual Severity- H(3)/M(2)/L(1)</th>
                                        <th>Residual Probability- H(3)/M(2)/L(1)</th>
                                        <th>Residual Detectability- H(1)/M(2)/L(3)</th>
                                        <th>Residual RPN</th>
                                        <th>Risk Acceptance (Y/N)</th>
                                        <th>Mitigation proposal</th>
                                    </tr> 

                                    <tbody>
                                        @if ($grid_data_qrms && is_array($grid_data_qrms->data))
                                            @php
                                                $serialNumber = 1;
                                            @endphp
                                            @foreach ($grid_data_qrms->data as $grid_item)
                                                <tr>
                                                    <td>{{$serialNumber++}}</td>
                                                    <td>{{$grid_item['residual_severity']}}</td>
                                                    <td>{{$grid_item['residual_probability']}}</td>
                                                    <td>{{$grid_item['residual_detectability']}}</td>
                                                    <td>{{$grid_item['residual_rpn']}}</td>
                                                    <td>{{$grid_item['risk_acceptance']}}</td>
                                                    <td>{{$grid_item['mitigation_proposal']}}</td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td class="w-20">1</td>
                                                <td class="w-20">Not Applicable</td>
                                                <td class="w-20">Not Applicable</td>
                                                <td class="w-20">Not Applicable</td>
                                                <td class="w-20">Not Applicable</td>
                                                <td class="w-20">Not Applicable</td>
                                            </tr>`
                                        @endif
                                    </tbody>
                                </table>

                               
                            </div>

                            <div class="border-table">
                                <div class="block-" style=" font-weight:bold; margin-bottom:5px;">
                                    Risk Matrix
                                </div>
                                <table>

                                    <tr class="table_bg">
                                        <th class="w-20">S.N.</th>
                                        <th class="w-60">Risk Assessment</th>
                                        <th class="w-60">Review Schedule</th>
                                        <th class="w-60">Actual Reviewed On</th>
                                        <th class="w-60">Recorded By Sign and Date</th>
                                        <th class="w-60">Remark</th>
                                    </tr>
                                    <tbody>
                                        @if($grid_data_matrix_qrms && is_array($grid_data_matrix_qrms->data))
                                            @php
                                                $serialNumber = 1;
                                            @endphp
                                            @foreach($grid_data_matrix_qrms->data as $matrix_grid_data)
                                                <tr>
                                                    <td>{{ $serialNumber }}</td>
                                                    <td>{{ $matrix_grid_data['risk_Assesment'] }}</td>
                                                    <td>{{ $matrix_grid_data['review_schedule'] }}</td>
                                                    <td>{{ $matrix_grid_data['actual_reviewed'] }}</td>
                                                    <td>{{ $matrix_grid_data['recorded_by'] }}</td>
                                                    <td>{{ $matrix_grid_data['remark'] }}</td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td class="w-20">1</td>
                                                <td class="w-20">Not Applicable</td>
                                                <td class="w-20">Not Applicable</td>
                                                <td class="w-20">Not Applicable</td>
                                                <td class="w-20">Not Applicable</td>
                                                <td class="w-20">Not Applicable</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- **************************QRM TAB ENDS******************************** -->


                    <!-- **************************CAAP TAB START******************************* -->

                    <div class="block">
                        <div class="head">
                            <div class="block-head">
                                CAPA
                            </div>
                            <table>
                                <tr>
                                    <th class="w-20">Proposed Due Date
                                    </th>
                                    <td class="w-30">
                                        <div>
                                            @if ($capaExtension && $capaExtension->capa_proposed_due_date) {{ $capaExtension->capa_proposed_due_date }} @else Not Applicable @endif
                                        </div>
                                    </td>
                                    <th class="w-20">Name of the Department</th>
                                    <td class="w-30">
                                        <div>
                                            @if ($data->department_capa) {{ $data->department_capa }} @else Not Applicable @endif
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="w-20">Source of CAPA</th>
                                    <td class="w-80">
                                        <div>
                                            @if ($data->source_of_capa) {{ $data->source_of_capa }} @else Not Applicable @endif
                                        </div>
                                    </td>
                                    <th class="w-20">Description of Discrepancy</th>
                                    <td class="w-30">
                                        <div>
                                            @if ($data->Description_of_Discrepancy) {{ strip_tags($data->Description_of_Discrepancy) }} @else Not Applicable @endif
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <th class="w-20">Root Cause</th>
                                    <td class="w-80">
                                        <div>
                                            @if ($data->capa_root_cause) {{ strip_tags($data->capa_root_cause) }} @else Not Applicable @endif
                                        </div>
                                    </td>
                                    <th class="w-20">Immediate Action Taken</th>
                                    <td class="w-30">
                                        <div>
                                            @if ($data->Immediate_Action_Take) {{ strip_tags($data->Immediate_Action_Take) }} @else Not Applicable @endif
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <th class="w-20">Corrective Action Details</th>
                                    <td class="w-80">
                                        <div>
                                            @if ($data->Corrective_Action_Details) {{ strip_tags($data->Corrective_Action_Details) }} @else Not Applicable @endif
                                        </div>
                                    </td>

                                    <th class="w-20">Preventive Action Details</th>
                                    <td class="w-80">
                                        <div>
                                            @if ($data->Preventive_Action_Details) {{ strip_tags($data->Preventive_Action_Details) }} @else Not Applicable @endif
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <th class="w-20">Target Completion Date</th>
                                    <td class="w-80">
                                        <div>
                                            @if ($data->capa_completed_date) {{ $data->capa_completed_date }} @else Not Applicable @endif
                                        </div>
                                    </td>

                                    <th class="w-20">Interim Control</th>
                                    <td class="w-80">
                                        <div>
                                            @if ($data->Interim_Control) {{ strip_tags($data->Interim_Control) }} @else Not Applicable @endif
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <th class="w-20">Corrective Action Taken</th>
                                    <td class="w-80">
                                        <div>
                                            @if ($data->Corrective_Action_Taken) {{ strip_tags($data->Corrective_Action_Taken) }} @else Not Applicable @endif
                                        </div>
                                    </td>

                                    <th class="w-20">Preventive Action Taken</th>
                                    <td class="w-80">
                                        <div>
                                            @if ($data->Preventive_action_Taken) {{ strip_tags($data->Preventive_action_Taken) }} @else Not Applicable @endif
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <th class="w-20">CAPA Closure Comments</th>
                                    <td class="w-80">
                                        <div>
                                            @if ($data->CAPA_Closure_Comments) {{ strip_tags($data->CAPA_Closure_Comments) }} @else Not Applicable @endif
                                        </div>
                                    </td>

                                    <th class="w-20">CAPA Closure Attachment</th>
                                    <td class="w-80">
                                        <div>
                                            @if ($data->CAPA_Closure_attachment) {{ $data->CAPA_Closure_attachment }} @else Not Applicable @endif
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <th class="w-20">Source Document</th>
                                    <td class="w-80">
                                        <div>
                                            @if ($data->source_doc) {{ $data->source_doc }} @else Not Applicable @endif
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- **************************CAPA TAB ENDS******************************** -->


                    <div class="block">
                        <div class="head">
                            <div class="block-head">
                                Investigation & CAPA
                            </div>
                            <table>

                                <tr>

                                    <th class="w-20">Investigation Summary
                                    </th>
                                    <td class="w-30">
                                        <div>
                                            @if ($data->Investigation_Summary)
                                                {{ $data->Investigation_Summary }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </div>
                                    </td>
                                    <th class="w-20">Impact Assessment</th>
                                    <td class="w-30">
                                        <div>
                                            @if ($data->Impact_assessment)
                                                {{ $data->Impact_assessment }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="w-20">Root cause</th>
                                    <td class="w-80">
                                        <div>
                                            @if ($data->Root_cause)
                                                {{ $data->Root_cause }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </div>
                                    </td>
                                    <th class="w-20">CAPA Required ?</th>
                                    <td class="w-30">
                                        <div>
                                            @if ($data->CAPA_Rquired)
                                                {{ $data->CAPA_Rquired }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </div>
                                    </td>
                                </tr>

                                {{-- <tr> --}}


                                {{-- <th class="w-20">CAPA Type?</th> --}}
                                {{-- <td class="w-30">
                                        <div>
                                            @if ($data->capa_type){{ $data->capa_type }}@else Not Applicable @endif
                                        </div>
                                    </td> --}}
                                {{-- </tr> --}}
                                <tr>

                                    <th class="w-20">CAPA Description</th>
                                    <td class="w-30">
                                        <div>
                                            @if ($data->CAPA_Description)
                                                {{ $data->CAPA_Description }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </div>
                                    </td>
                                    <th class="w-20">Post Categorization Of Deviationt</th>
                                    <td class="w-30">
                                        <div>
                                            @if ($data->Post_Categorization)
                                                {{ $data->Post_Categorization }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                <tr>

                                    <th class="w-20"> Justification For Revised category
                                    </th>
                                    <td class="w-30">
                                        <div>
                                            @if ($data->Investigation_Of_Review)
                                                {{ strip_tags($data->Investigation_Of_Review) }}
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
                                Investigation Attachment
                            </div>
                            <table>

                                <tr class="table_bg">
                                    <th class="w-20">S.N.</th>
                                    <th class="w-60">Attachment</th>
                                </tr>
                                @if ($data->Investigation_attachment)
                                    @foreach (json_decode($data->Investigation_attachment) as $key => $file)
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
                        <div class="border-table">
                            <div class="block-head">
                                CAPA Attachment
                            </div>
                            <table>

                                <tr class="table_bg">
                                    <th class="w-20">S.N.</th>
                                    <th class="w-60">Attachment</th>
                                </tr>
                                @if ($data->Capa_attachment)
                                    @foreach (json_decode($data->Capa_attachment) as $key => $file)
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
                            <div class="block-head">
                                QA Final Review
                            </div>
                            <table>

                                <tr>
                                    <th class="w-20">QA Feedbacks</th>
                                    <td class="w-30">
                                        @if ($data->QA_Feedbacks)
                                            {{ strip_tags($data->QA_Feedbacks) }}
                                        @else
                                            Not Applicable
                                        @endif
                                    </td>

                            </table>
                        </div>
                        <div class="border-table">
                            <div class="block-head">
                                QA Attachments
                            </div>
                            <table>

                                <tr class="table_bg">
                                    <th class="w-20">S.N.</th>
                                    <th class="w-60">Attachment</th>
                                </tr>
                                @if ($data->QA_attachments)
                                    @foreach (json_decode($data->QA_attachments) as $key => $file)
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
                            QAH/Designee Approval
                        </div>
                        <table>

                            <tr>
                                <th class="w-20">Closure Comments</th>
                                <td class="w-30">
                                    @if ($data->Closure_Comments)
                                        {{ strip_tags($data->Closure_Comments) }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                                <th class="w-20">Disposition of Batch</th>
                                <td class="w-30">
                                    @if ($data->Disposition_Batch)
                                        {{ strip_tags($data->Disposition_Batch) }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>

                        </table>
                    </div>
                    <div class="border-table">
                        <div class="block-head">
                            Closure Attachments
                        </div>
                        <table>

                            <tr class="table_bg">
                                <th class="w-20">S.N.</th>
                                <th class="w-60">Attachment</th>
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
            </div>


            <div class="block">
                <div class="block-head">
                    Activity Log
                </div>
                <table>
                    <tr>
                        <th class="w-20">Submit By</th>
                        <td class="w-30">{{ $data->submit_by }}</td>
                        <th class="w-20">Submit On</th>
                        <td class="w-30">{{ $data->submit_on }}</td>
                        <th class="w-20">Submit Comments</th>
                        <td class="w-30">{{ $data->submit_comment }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">HOD Review Complete By</th>
                        <td class="w-30">{{ $data->HOD_Review_Complete_By }}</td>
                        <th class="w-20">HOD Review Complete On</th>
                        <td class="w-30">{{ $data->HOD_Review_Complete_On }}</td>
                        <th class="w-20">HOD Review Comments</th>
                        <td class="w-30">{{ $data->HOD_Review_Comments }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">QA Initial Review Complete by</th>
                        <td class="w-30">{{ $data->QA_Initial_Review_Complete_By }}</td>
                        <th class="w-20">QA Initial Review Complete On</th>
                        <td class="w-30">{{ Helpers::getdateFormat($data->QA_Initial_Review_Complete_On) }}</td>
                        <th class="w-20">QA Initial Review Comments</th>
                        <td class="w-30">{{ $data->QA_Initial_Review_Comments }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">CFT Review Complete By</th>
                        <td class="w-30">{{ $data->CFT_Review_Complete_By }}</td>
                        <th class="w-20">CFT Review Complete On</th>
                        <td class="w-30">{{ $data->CFT_Review_Complete_On }}</td>
                        <th class="w-20">CFT Review Comments</th>
                        <td class="w-30">{{ $data->CFT_Review_Comments }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">QA Final Review Complete By</th>
                        <td class="w-30">{{ $data->QA_Final_Review_Complete_By }}</td>
                        <th class="w-20">QA Final Review Complete On</th>
                        <td class="w-30">{{ $data->QA_Final_Review_Complete_On }}</td>
                        <th class="w-20">QA Final Review Comments</th>
                        <td class="w-30">{{ $data->QA_Final_Review_Comments }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Approved By</th>
                        <td class="w-30">{{ $data->Approved_By }}</td>
                        <th class="w-20">Approved ON</th>
                        <td class="w-30">{{ $data->Approved_On }}</td>
                        <th class="w-20">Approved Comments</th>
                        <td class="w-30">{{ $data->Approved_Comments }}</td>



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

</body>

</html>
