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

    .tbl-bottum {
        margin-bottom: 20px
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
</style>

<body>

    <header>
        <table>
            <tr>
                <td class="w-70 head">
                    Sampling Stability Single Report
                </td>
                <td class="w-30">
                    <div class="logo">
                        {{--<img src="https://www.medicefpharma.com/wp-content/uploads/2020/06/medicef-logo-new1.png" alt="logo" class="w-80 ">--}}
                    </div>
                </td>
            </tr>
        </table>
        <table>
            <tr>
                <td class="w-30">
                    <strong>Sampling Stability No.</strong>
                </td>
                <td class="w-40">
                    {{--{{ Helpers::getDivisionName(session()->get('division')) . "/SS/" . date('Y') . "/" . str_pad($data->record, 4, '0', STR_PAD_LEFT); }}--}}
                    {{ Helpers::divisionNameForQMS($data->division_id) }}/SS/{{ date('Y') }}/{{ str_pad($data->record, 4, '0', STR_PAD_LEFT) }}
                </td>
                <td class="w-30">
                    <strong>Record No.</strong> {{ str_pad($data->record, 4, '0', STR_PAD_LEFT) }}
                </td>
            </tr>
        </table>
    </header>

    <div class="inner-block">
        <div class="content-table">
            <div class="block">
                <div class="block-head">
                    Sample Registration
                </div>
                <table>
                    <tr> {{ $data->created_at }} added by {{ $data->originator }}
                        <th class="w-20">Record Number</th>
                        <td class="w-80">
                            {{ Helpers::divisionNameForQMS($data->division_id) }}/SS/{{ date('Y') }}/{{ str_pad($data->record, 4, '0', STR_PAD_LEFT) }}
                        </td>
                        <th class="w-20">Site/Location Code</th>
                        <td class="w-30">
                            @if ($data->division_code)
                                {{ $data->division_code }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">Initiator</th>
                        <td class="w-30">{{ Auth::user()->name }}</td>
                        <th class="w-20">Date of Initiation</th>
                        <td class="w-80">{{ Helpers::getdateFormat($data->intiation_date) }}</td>

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
                    <tr>

                        <th class="w-20">Initiator Group</th>
                        <td class="w-80">
                            @if ($data->Initiator_Group)
                                {{ Helpers::getInitiatorGroupFullName($data->Initiator_Group) }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Initiator Group Code</th>
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
                            @if ($data->short_desc)
                                {{ $data->short_desc }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                    </tr>

                    <tr>{{-- <th class="w-20">Additional Investigators</th> <td class="w-30">@if ($data->investigators){{ $data->investigators }}@else Not Applicable @endif</td> --}}
                        <th class="w-20">Sample Plan ID</th>
                        <td class="w-30">
                            @if ($data->samplePlanId)
                                {{ $data->samplePlanId }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Sample ID</th>
                        <td class="w-80">
                            @if ($data->sampleId)
                                {{ $data->sampleId }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                    </tr>
                    <tr>{{-- <th class="w-20">Additional Investigators</th> <td class="w-30">@if ($data->investigators){{ $data->investigators }}@else Not Applicable @endif</td> --}}
                        <th class="w-20">Sample Name</th>
                        <td class="w-30">
                            @if ($data->sampleName)
                                {{ $data->sampleName }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Sample Type</th>
                        <td class="w-80">
                            @if ($data->sampleType)
                                {{ $data->sampleType }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                    </tr>
                </table>
                <div class="inner-block">
                    <label
                        class="Summer"style="font-weight: bold; font-size: 13px; display: inline-block; width: 75px;">
                        Product / Material Name</label>
                    <span style="font-size: 0.8rem; margin-left: 60px;">
                        @if ($data->productMaterialName)
                            {{ $data->productMaterialName }}
                        @else
                            Not Applicable
                        @endif
                    </span>
                </div>

                <table>
                    <tr>
                        <th class="w-20">Batch/Lot Number</th>
                        <td class="w-30">
                            @if ($data->batchLotNumber)
                                {{ $data->batchLotNumber }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Sample Priority</th>
                        <td class="w-80">
                            @if ($data->samplePriority)
                                {{ $data->samplePriority }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                    </tr>
                    <tr>
                        <th class="w-20">Sample Quantity</th>
                        <td class="w-80">
                            @if ($data->sampleQuantity)
                                {{ $data->sampleQuantity }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">UOM</th>
                        <td class="w-80">
                            @if ($data->UOM)
                                {{ $data->UOM }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">Market</th>
                        <td class="w-80">
                            @if ($data->market)
                                {{ $data->market }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                       
                    </tr>
                </table>

                <div class="inner-block">
                    <label
                        class="Summer"style="font-weight: bold; font-size: 13px; display: inline-block; width: 75px;">
                        Sample Barcode</label>
                    <span style="font-size: 0.8rem; margin-left: 60px;">
                        @if ($data->sampleBarCode)
                            {{ $data->sampleBarCode }}
                        @else
                            Not Applicable
                        @endif
                    </span>
                </div>

                <table>
                    <tr>
                        <th class="w-20">Specification Id</th>
                        <td class="w-30">
                            @if ($data->specificationId)
                                {{ $data->specificationId }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">STP Id</th>
                        <td class="w-80">
                            @if ($data->stpId)
                                {{ $data->stpId }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                    </tr>
                    <tr>
                        <th class="w-20">Test Name</th>
                        <td class="w-80">
                            @if ($data->testName)
                                {{ $data->testName }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    
                </table>


                <div class="border-table">
                    <div class="block-head">
                        Specification Attachment
                    </div>
                    <table>

                        <tr class="table_bg">
                            <th class="w-20">S.N.</th>
                            <th class="w-60">Batch No</th>
                        </tr>
                        @if ($data->specification_attachment)
                            @foreach (json_decode($data->specification_attachment) as $key => $file)
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
                        STP Attachment
                    </div>
                    <table>
    
                        <tr class="table_bg">
                            <th class="w-20">S.N.</th>
                            <th class="w-60">Batch No</th>
                        </tr>
                        @if ($data->stp_attachment)
                            @foreach (json_decode($data->stp_attachment) as $key => $file)
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
    

                <table>
                    <tr>
                        <th class="w-20">Test Method</th>
                        <td class="w-30">
                            @if ($data->testMethod)
                                {{ $data->testMethod }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Test Parameters</th>
                        <td class="w-80">
                            @if ($data->testParameter)
                                {{ $data->testParameter }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Testing Frequency</th>
                        <td class="w-80">
                            @if ($data->testingFrequency)
                                {{ $data->testingFrequency }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                    </tr>
                    <tr>
                        <th class="w-20">Testing Location</th>
                        <td class="w-80">
                            @if ($data->testingLocation)
                                {{ $data->testingLocation }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">Select Required Instruments</th>
                        <td class="w-80">
                            @if ($data->requiredInstrument)
                                {{ $data->requiredInstrument }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">LSL</th>
                        <td class="w-80">
                            @if ($data->lsl)
                                {{ $data->lsl }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                    </tr>

                    <tr>
                        <th class="w-20">Test Grouping</th>
                        <td class="w-80">
                            @if ($data->testGrouping)
                                {{ $data->testGrouping }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">USL</th>
                        <td class="w-80">
                            @if ($data->usl)
                                {{ $data->usl }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Lab Technician</th>
                        <td class="w-80">
                            @if ($data->labTechnician)
                                {{ $data->labTechnician }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                    </tr>

                    <tr>
                        <th class="w-20">Sample Cost Estimation</th>
                        <td class="w-80">
                            @if ($data->sampleCostEstimation)
                                {{ $data->sampleCostEstimation }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Resource Utilization</th>
                        <td class="w-80">
                            @if ($data->resourceUtilization)
                                {{ $data->resourceUtilization }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                    </tr>

                    <tr>
                        <th class="w-20">Assigned Department</th>
                        <td class="w-80">
                            @if ($data->assignedDepartment)
                                {{ $data->assignedDepartment }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Test Grouping</th>
                        <td class="w-80">
                            @if ($data->testGrouping_ii)
                                {{ $data->testGrouping_ii }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                    </tr>
                    <tr>
                        <th class="w-20">Sample Collection Date</th>
                        <td class="w-80">
                            @if ($data->sampleCollectionDate)
                                {{ Helpers::getdateFormat($data->sampleCollectionDate) }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                </table>

            </div>

            <div class="border-table">
                <div class="block-head">
                    Supportive Attachment
                </div>
                <table>

                    <tr class="table_bg">
                        <th class="w-20">S.N.</th>
                        <th class="w-60">Batch No</th>
                    </tr>
                    @if ($data->suupportive_attachment_gi)
                        @foreach (json_decode($data->suupportive_attachment_gi) as $key => $file)
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
                    Sample Analysis
                </div>

                {{--<div class="border-table tbl-bottum ">
                    <div class="block-head">
                        Instrument Details
                    </div>
                    <table>
                        <tr class="table_bg">
                        <th class="w-10">Row #</th>
                        <th class="w-30">Test Parameter</th>
                        <th class="w-30">LSL</th>
                        <th class="w-30">USL</th>
                        <th class="w-30">Result</th>
                        <th class="w-30">Remarks</th>
                       
                        </tr>
                       
                        @if (!empty($data->instrumentdetails))
                            @foreach (unserialize($data->instrumentdetails) as $key => $instrumentdetails)
                                <tr>
                                    <td class="w-10">{{ $key + 1 }}</td>
                                    <td class="w-30">
                                        {{ unserialize($data->instrumentdetails)[$key] ? unserialize($data->instrumentdetails)[$key] : '' }}
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
                </div>--}}

                <table>
                    <tr>
                        <th class="w-20">Analysis Type</th>
                        <td class="w-30">
                            @if ($data->analysisType)
                                {{ $data->analysisType }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Analysis Result</th>
                        <td class="w-30">
                            @if ($data->analysisResult)
                                {{ $data->analysisResult }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Analysis Date</th>
                        <td class="w-80">
                            @if ($data->analysisDate)
                                {{ Helpers::getdateFormat($data->analysisDate) }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Testing Start Date</th>
                        <td class="w-80">
                            @if ($data->testingStartDate)
                                {{ Helpers::getdateFormat($data->testingStartDate) }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                    </tr>
                    <tr>
                        <th class="w-20">Delay Justification</th>
                        <td class="w-80">
                            @if ($data->delayJustification)
                                {{ $data->delayJustification }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        
                    </tr>

                    <tr>
                        <th class="w-20">Testing End Date</th>
                        <td class="w-80">
                            @if ($data->testingEndDate)
                                {{ Helpers::getdateFormat($data->testingEndDate) }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Testing Outcome</th>
                        <td class="w-80">
                            @if ($data->testingOutCome)
                                {{ $data->testingOutCome }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                    </tr>

                    <tr>
                        <th class="w-20">Pass/Fail</th>
                        <td class="w-80">
                            @if ($data->passFail)
                                {{ $data->passFail }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    
                        <th class="w-20">Test Plan ID</th>
                        <td class="w-80">
                            @if ($data->testPlanId)
                                {{ $data->testPlanId }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Turnaround Time (TAT)</th>
                        <td class="w-80">
                            @if ($data->turnAroundTime)
                                {{ $data->turnAroundTime }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                    </tr>

                    <tr>
                        <th class="w-20">Sample Retesting Date</th>
                        <td class="w-80">
                            @if ($data->sampleRetestingDate)
                                {{ Helpers::getdateFormat($data->sampleRetestingDate) }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Review Date</th>
                        <td class="w-80">
                            @if ($data->reviewDate)
                                {{ Helpers::getdateFormat($data->reviewDate) }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                    </tr>

                    <tr>
                        <th class="w-20">Sample Storage Location</th>
                        <td class="w-80">
                            @if ($data->sampleStorageLocation)
                                {{ $data->sampleStorageLocation }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Transportation Method</th>
                        <td class="w-80">
                            @if ($data->transportationMethod)
                                {{ $data->transportationMethod }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                    </tr>
                    <tr>
                        <th class="w-20">Sample Preparation Method</th>
                        <td class="w-80">
                            @if ($data->samplePreparationMethod)
                                {{ $data->samplePreparationMethod }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">Sample Packaging Details</th>
                        <td class="w-80">
                            @if ($data->samplePackagingDetail)
                                {{ $data->samplePackagingDetail }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Regulatory Requirements</th>
                        <td class="w-80">
                            @if ($data->regulatoryRequirement)
                                {{ $data->regulatoryRequirement }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">Sample Label</th>
                        <td class="w-80">
                            @if ($data->sampleLabel)
                                {{ $data->sampleLabel }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Quality Control Checks</th>
                        <td class="w-80">
                            @if ($data->qualityControlCheck)
                                {{ $data->qualityControlCheck }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                    </tr>

                    <tr>
                        <th class="w-20">Control Sample Reference</th>
                        <td class="w-80">
                            @if ($data->controlSampleReference)
                                {{ $data->controlSampleReference }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Reference Sample</th>
                        <td class="w-80">
                            @if ($data->referencesample)
                                {{ $data->referencesample }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                    </tr>

                    <tr>
                        <th class="w-20">Control Sample</th>
                        <td class="w-80">
                            @if ($data->controlSample)
                                {{ $data->controlSample }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Sample Integrity Status</th>
                        <td class="w-80">
                            @if ($data->sampleIntegrityStatus)
                                {{ $data->sampleIntegrityStatus }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                    </tr>

                    <tr>
                        <th class="w-20">Assigned Department</th>
                        <td class="w-80">
                            @if ($data->assignedDepartmentII)
                                {{ $data->assignedDepartmentII }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Supervisor</th>
                        <td class="w-80">
                            @if ($data->supervisor)
                                {{ $data->supervisor }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                    </tr>
                    <tr>
                        <th class="w-20">Risk Assessment</th>
                        <td class="w-80">
                            @if ($data->riskAssessment)
                                {{ $data->riskAssessment }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Instruments Reserved</th>
                        <td class="w-80">
                            @if ($data->instruments_reserved)
                                {{ $data->instruments_reserved }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Lab Availability</th>
                        <td class="w-80">
                            @if ($data->lab_availability)
                                {{ $data->lab_availability }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                    </tr>

                    <tr>
                        <th class="w-20">Sample Date</th>
                        <td class="w-80">
                            @if ($data->sample_date)
                                {{ Helpers::getdateFormat($data->sample_date) }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Sampling Frequency</th>
                        <td class="w-80">
                            @if ($data->samplingFrequency)
                                {{ $data->samplingFrequency }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                    </tr>
                    <tr>
                        <th class="w-20">Sample Movement History</th>
                        <td class="w-80">
                            @if ($data->sample_movement_history)
                                {{ $data->sample_movement_history }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">Testing Progress</th>
                        <td class="w-80">
                            @if ($data->testing_progress)
                                {{ $data->testing_progress }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Deviation Logs</th>
                        <td class="w-80">
                            @if ($data->deviation_logs)
                                {{ $data->deviation_logs }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Comments/Notes</th>
                        <td class="w-80">
                            @if ($data->commentNotes)
                                {{ $data->commentNotes }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">Sample Disposition</th>
                        <td class="w-80">
                            @if ($data->sampleDisposition)
                                {{ $data->sampleDisposition }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    
                </table>
                </div>
                 <div class="border-table">
                    <div class="block-head">
                        Attachment
                    </div>
                    <table>

                        <tr class="table_bg">
                            <th class="w-20">S.N.</th>
                            <th class="w-60">Batch No</th>
                        </tr>
                        @if ($data->suupportive_attachment_gi)
                            @foreach (json_decode($data->suupportive_attachment_gi) as $key => $file)
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
                        Supportive Attachment
                    </div>
                    <table>

                        <tr class="table_bg">
                            <th class="w-20">S.N.</th>
                            <th class="w-60">Batch No</th>
                        </tr>
                        @if ($data->suupportive_attachment_gi)
                            @foreach (json_decode($data->suupportive_attachment_gi) as $key => $file)
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
               
                

                <div class="block-head">
                    Supervisor Review
                </div>

                <table>
                    <tr>
                        <th class="w-20">Reviewer/Approver</th>
                        <td class="w-80">
                            @if ($data->reviewerApprover)
                                {{ $data->reviewerApprover }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    
                        <th class="w-20">Review Date</th>
                        <td class="w-80">
                            @if ($data->reviewDate)
                                {{ Helpers::getdateFormat($data->reviewDate) }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Reviewer Comment</th>
                        <td class="w-80">
                            @if ($data->reviewerComment)
                                {{ $data->reviewerComment }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    
                </table>
            {{--</div>
        </div>--}}

        <div class="block">
            <div class="block-head">
                Stability Information
            </div>

            <table>


                <tr>
                    <th class="w-20">Stability Study Type</th>
                    <td class="w-80">
                        @if ($data->stabilityStudyType)
                            {{ $data->stabilityStudyType }}
                        @else
                            Not Applicable
                        @endif
                    </td>
                
                    <th class="w-20">ICH Zone</th>
                    <td class="w-80">
                        @if ($data->ichZone)
                            {{ $data->ichZone }}
                        @else
                            Not Applicable
                        @endif
                    </td>
                </tr>
                <tr>
                    <th class="w-20">Sample Disposition</th>
                    <td class="w-80">
                        @if ($data->sampleDisposition)
                            {{ $data->sampleDisposition }}
                        @else
                            Not Applicable
                        @endif
                    </td>
                
                    <th class="w-20">Photostability Testing Results</th>
                    <td class="w-80">
                        @if ($data->photostabilityResults)
                            {{ $data->photostabilityResults }}
                        @else
                            Not Applicable
                        @endif
                    </td>
                </tr>
                <tr>
                    <th class="w-20">Reconstitution Stability</th>
                    <td class="w-80">
                        @if ($data->reconstitutionStability)
                            {{ $data->reconstitutionStability }}
                        @else
                            Not Applicable
                        @endif
                    </td>
                
                    <th class="w-20">Stability Protocol Approval Date</th>
                    <td class="w-80">
                        @if ($data->protocolApprovalDate)
                            {{ Helpers::getdateFormat($data->protocolApprovalDate) }}
                        @else
                            Not Applicable
                        @endif
                    </td>
                </tr>
                
                
                <tr>
                    <th class="w-20">Testing Interval (months)</th>
                    <td class="w-80">
                        @if ($data->testingInterval)
                            {{ $data->testingInterval }}
                        @else
                            Not Applicable
                        @endif
                    </td>
                
                    <th class="w-20">Country of Regulatory Submissions</th>
                    <td class="w-80">
                        @if ($data->regulatoryCountry)
                            {{ $data->regulatoryCountry }}
                        @else
                            Not Applicable
                        @endif
                    </td>
                </tr>

                <tr>
                    <th class="w-20">Shelf Life Recommendation</th>
                    <td class="w-80">
                        @if ($data->shelfLife)
                            {{ $data->shelfLife }}
                        @else
                            Not Applicable
                        @endif
                    </td>
                </tr>
            
            </table>
        </div>

        <div class="block">
            <div class="block-head">
                QA Review
            </div>

            <table>

                <tr>
                    <th class="w-20">QA Reviewer/Approver</th>
                    <td class="w-80">
                        @if ($data->qaReviewerApprover)
                            {{ $data->qaReviewerApprover }}
                        @else
                            Not Applicable
                        @endif
                    </td>
                
                    <th class="w-20">QA Review Date</th>
                    <td class="w-80">
                        @if ($data->qaReviewDate)
                            {{ Helpers::getdateFormat($data->qaReviewDate) }}
                        @else
                            Not Applicable
                        @endif
                    </td>
                </tr>
                <tr>
                    <th class="w-20">QA Reviewer Comment</th>
                    <td class="w-80">
                        @if ($data->qaReviewerComment)
                            {{ $data->qaReviewerComment }}
                        @else
                            Not Applicable
                        @endif
                    </td>
                </tr>
                
            </table>
        </div>
        
        <div class="block">
            <div class="block-head">
                QA Review
            </div>

            <table>

                <tr>
                    <th class="w-20">Initiator Name</th>
                    <td class="w-80">
                        @if ($data->initiatorName)
                            {{ $data->initiatorName }}
                        @else
                            Not Applicable
                        @endif
                    </td>
                
                    <th class="w-20">Lab Technician Name</th>
                    <td class="w-80">
                        @if ($data->labTechnicianName)
                            {{ $data->labTechnicianName }}
                        @else
                            Not Applicable
                        @endif
                    </td>
                </tr>
                <tr>
                    <th class="w-20">Date of Initiation</th>
                    <td class="w-80">
                        @if ($data->dateOfInitiation)
                            {{ Helpers::getdateFormat($data->dateOfInitiation) }}
                        @else
                            Not Applicable
                        @endif
                    </td>
                    <th class="w-20">Date of Lab Technician Review</th>
                    <td class="w-80">
                        @if ($data->dateOfLabTechReview)
                            {{ Helpers::getdateFormat($data->dateOfLabTechReview) }}
                        @else
                            Not Applicable
                        @endif
                    </td>
                </tr>

                <tr>
                    <th class="w-20">Supervisor Name</th>
                    <td class="w-80">
                        @if ($data->supervisorName)
                            {{ $data->supervisorName }}
                        @else
                            Not Applicable
                        @endif
                    </td>
                
                    <th class="w-20">QA Review</th>
                    <td class="w-80">
                        @if ($data->qaReview)
                            {{ $data->qaReview }}
                        @else
                            Not Applicable
                        @endif
                    </td>
                </tr>
                <tr>
                    <th class="w-20">Date of Supervision Review</th>
                    <td class="w-80">
                        @if ($data->dateOfSupervisionReview)
                            {{ Helpers::getdateFormat($data->dateOfSupervisionReview) }}
                        @else
                            Not Applicable
                        @endif
                    </td>
                    <th class="w-20">Date of QA Review</th>
                    <td class="w-80">
                        @if ($data->dateOfQaReview)
                            {{ Helpers::getdateFormat($data->dateOfQaReview) }}
                        @else
                            Not Applicable
                        @endif
                    </td>
                </tr>
                
            </table>
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
               
                    <th class="w-20">Acknowledge Comment</th>
                    <td class="w-80">
                        @if ($data->ack_comments)
                            {{ $data->ack_comments }}
                        @else
                            Not Applicable
                        @endif
                    </td>
                </tr>
                <tr>
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
                <th class="w-20">HOD Review Complete Comment</th>
                <td class="w-80">
                    @if ($data->HOD_Review_Complete_Comment)
                        {{ $data->HOD_Review_Complete_Comment }}
                    @else
                        Not Applicable
                    @endif
                </td>
                </tr>

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
                    <th class="w-20">QA/CQA Review Complete Comment</th>
                    <td class="w-80">
                        @if ($data->QAQQ_Review_Complete_comment)
                            {{ $data->QAQQ_Review_Complete_comment }}
                        @else
                            Not Applicable
                        @endif
                    </td>
                </tr>

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
                    <th class="w-20">Submit Comment</th>
                    <td class="w-30">
                        @if ($data->qa_comments_new)
                            {{ $data->qa_comments_new }}
                        @else
                            Not Applicable
                        @endif
                    </td>
                </tr>

                <tr>
                    <th class="w-20">HOD Final Review Complete By</th>
                    <td class="w-30">@if ($data->HOD_Final_Review_Complete_By)
                        {{ $data->HOD_Final_Review_Complete_By }}
                    @else
                        Not Applicable
                    @endif
                    </td>
                    <th class="w-20">HOD Final Review Complete On</th>
                    <td class="w-30">
                        @if ($data->HOD_Final_Review_Complete_On)
                            {{ $data->HOD_Final_Review_Complete_On }}
                        @else
                            Not Applicable
                        @endif
                        </td>
                    <th class="w-20">
                        HOD Final Review Complete Comment</th>
                    <td class="w-30">
                        @if ($data->HOD_Final_Review_Complete_Comment)
                            {{ $data->HOD_Final_Review_Complete_Comment }}
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

                
                {{-- <th class="w-20">QA Review Completed Comment</th>
                        <td class="w-80"> @if ($data->qA_review_complete_comment) {{ $data->qA_review_complete_comment }} @else Not Applicable @endif</td> --}}

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
                    <th class="w-20"> Final QA/CQA Review Complete By</th>
                    <td class="w-30">
                        @if ($data->Final_QA_Review_Complete_By)
                            {{ $data->Final_QA_Review_Complete_By }}
                        @else
                            Not Applicable
                        @endif
                    </td>
                    <th class="w-20"> Final QA/CQA Review Complete On</th>
                    <td class="w-30">
                        @if ($data->Final_QA_Review_Complete_On)
                            {{ Helpers::getdateFormat($data->Final_QA_Review_Complete_On) }}
                        @else
                            Not Applicable
                        @endif
                    </td>
                    <th class="w-20">Final QA/CQA Review Complete Comment</th>
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
                        QAH/CQAH Closure Comment</th>
                    <td class="w-80">
                        @if ($data->Final_QA_Review_Complete_Comment)
                            {{ $data->evalution_Closure_comment }}
                        @else
                            Not Applicable
                        @endif
                    </td>
                </tr>
                <tr>
                    <th class="w-20">Cancel By
                    </th>
                    <td class="w-30">
                        @if ($data->cancelled_by)
                            {{ $data->cancelled_by }}
                        @else
                            Not Applicable
                        @endif
                    <th class="w-20">
                        Cancel On</th>
                    <td class="w-30">
                        @if ($data->cancelled_on)
                            {{ $data->cancelled_on }}
                        @else
                            Not Applicable
                        @endif
                    <th class="w-20">
                        Cancel Comment</th>
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

</body>

</html>
