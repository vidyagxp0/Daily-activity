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
                    Sample Management II Single Report
                </td>
                <td class="w-30">
                    <div class="logo">
                        <img src="{{ asset('user/images/vidhyagxp.png') }}" alt="logo" class="w-80 ">
                    </div>
                </td>
            </tr>
        </table>
        <table>
            <tr>
                <td class="w-30">
                    <strong>Sample Management No.</strong>
                </td>
                <td class="w-40">
                    {{ Helpers::getDivisionName(session()->get('division')) . "/SP/" . date('Y') . "/" . str_pad($data->record, 4, '0', STR_PAD_LEFT); }}
                    {{--{{ Helpers::divisionNameForQMS($data->division_id) }}/RCA/{{ Helpers::year($data->created_at) }}/{{ str_pad($data->record, 4, '0', STR_PAD_LEFT) }}--}}
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
                        <th class="w-20">Initiator</th>
                        <td class="w-30">{{ Helpers::getInitiatorName($data->initiator_id) }}</td>
                        <th class="w-20">Record Number</th>
                        <td class="w-80">
                            {{--{{ Helpers::divisionNameForQMS($data->division_id) }}/RCA/{{ Helpers::year($data->created_at) }}/{{ str_pad($data->record, 4, '0', STR_PAD_LEFT) }}--}}
                         {{ Helpers::getDivisionName(session()->get('division')) . "/Sample Management/" . date('Y') . "/" . str_pad($data->record, 4, '0', STR_PAD_LEFT); }}

                    </tr>
                    <tr>
                        <th class="w-20">Location/Lab Code</th>
                        <td class="w-30">
                            @if ($data->division_code)
                                {{ $data->division_code }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Date Of Initiation</th>
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
                    
                </table>

                {{-- 1 grid --}}
                <div class="border-table tbl-bottum">
                    <div class="block-head">
                        Sample Management
                    </div>
                    <table>
                        <tr class="table_bg">
                            <th class="w-10">Row #</th>
                            <th class="w-20">Sample Plan ID</th>
                            <th class="w-30">Sample Plan</th>
                            <th class="w-30">Sample Name</th>
                            <th class="w-30">Sample Type</th>
                        </tr>

                        <tbody>
                            @if ($certificationData && is_array($certificationData))
                                @foreach ($certificationData as $gridData)
                                    <tr>
                                        <td>
                                        {{ $loop->index + 1 }}
                                        </td>
                                        <td>
                                          {{ isset($gridData['samplePlanId']) ? $gridData['samplePlanId'] : '' }}
                                        </td>
                                        <td>
                                        {{ isset($gridData['samplePlan']) ? $gridData['samplePlan'] : '' }}
                                        </td>
                                        <td>
                                            {{ isset($gridData['samplePlanName']) ? $gridData['samplePlanName'] : '' }}
                                        </td>
                                        <td>
                                            {{ isset($gridData['sampleType']) ? $gridData['sampleType'] : '' }}
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td style="width: 60px;"><input type="text"
                                            name="certificationData[0][serial]" value="1" readonly>
                                    </td>
                                    <td><input type="text" name="certificationData[0][samplePlanId]"></td>
                                    <td><input type="text"
                                            name="certificationData[0][samplePlan]"></td>
                                    <td><input type="text"
                                            name="certificationData[0][samplePlanName]"></td>
                                    <td><input type="text"
                                            name="certificationData[0][sampleType]"></td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                {{-- 2 grid --}}
                <div class="border-table tbl-bottum">
                    <table>
                        <tr class="table_bg">
                            <th class="w-10">Row #</th>
                            <th class="w-30">Product / Material Name</th>
                            <th class="w-30">Batch/Lot Number</th>
                            <th class="w-30">Sample Priority</th>
                            <th class="w-30">Sample Quantity</th>
                            <th class="w-30">Quantity Withdrawn</th>
                            <th class="w-30">Current Quantity</th>

                        </tr>
                        <tbody>
                            @if ($certificationData && is_array($certificationData))
                                @foreach ($certificationData as $gridData)
                                    <tr>
                                        <td>
                                        {{ $loop->index + 1 }}
                                        </td>
                                        <td>
                                          {{ isset($gridData['productmaterial']) ? $gridData['productmaterial'] : '' }}
                                        </td>
                                        <td>
                                        {{ isset($gridData['batchNumber']) ? $gridData['batchNumber'] : '' }}
                                        </td>
                                        <td>
                                            {{ isset($gridData['samplePriority']) ? $gridData['samplePriority'] : '' }}
                                        </td>
                                        
                                        <td>
                                            {{ isset($gridData['sampleQuantity']) ? $gridData['sampleQuantity'] : '' }}
                                        </td>
                                        <td>
                                            {{ isset($gridData['quantityWithdrawn']) ? $gridData['quantityWithdrawn'] : '' }}
                                        </td>
                                        <td>
                                            {{ isset($gridData['currentQuantity']) ? $gridData['currentQuantity'] : '' }}
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td style="width: 60px;"><input type="text"
                                            name="certificationData[0][serial]" value="1" readonly>
                                    </td>
                                    <td><input type="text" name="certificationData[0][productmaterial]"></td>
                                    <td><input type="text"
                                            name="certificationData[0][batchNumber]"></td>
                                    <td><input type="text"
                                            name="certificationData[0][samplePriority]"></td>
                                    <td><input type="text"
                                            name="certificationData[0][sampleQuantity]"></td>
                                    <td><input type="text"
                                            name="certificationData[0][quantityWithdrawn]"></td>
                                    <td><input type="text"
                                            name="certificationData[0][currentQuantity]"></td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
               
                {{--3 Grid --}}
                <div class="border-table tbl-bottum">
                    <table>
                        <tr class="table_bg">
                            <th class="w-10">Row #</th>
                            <th class="w-30">UOM</th>
                            <th class="w-20">Market</th>
                            <th class="w-30">Specification ID</th>
                            <th class="w-30">Specification Attachment</th>
                        </tr>
                        <tbody>
                            @if ($certificationData && is_array($certificationData))
                                @foreach ($certificationData as $gridData)
                                    <tr>
                                        <td>
                                        {{ $loop->index + 1 }}
                                        </td>
                                        <td>
                                          {{ isset($gridData['UOM']) ? $gridData['UOM'] : '' }}
                                        </td>
                                        <td>
                                        {{ isset($gridData['market']) ? $gridData['market'] : '' }}
                                        </td>
                                        <td>
                                            {{ isset($gridData['specificationId']) ? $gridData['specificationId'] : '' }}
                                        </td>

                                        <td> 
                                            @if(isset($gridData['specificationAttach_path']) && $gridData['specificationAttach_path'])
                                                <a href="{{ asset('uploads/' . $gridData['specificationAttach_path']) }}" target="_blank">
                                                    {{ $gridData['specificationAttach_path'] }}
                                                </a>
                                            @else
                                                {{ '' }}
                                            @endif
                                        </td>
                                     
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td style="width: 60px;"><input type="text"
                                            name="certificationData[0][serial]" value="1" readonly>
                                    </td>
                                    <td><input type="text" name="certificationData[0][UOM]"></td>
                                    <td><input type="text"
                                            name="certificationData[0][market]"></td>
                                    <td><input type="text"
                                            name="certificationData[0][specificationId]"></td>
                                    <td><input type="text"
                                            name="certificationData[0][specificationAttach]"></td>

                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                {{--4 Grid --}}
                <div class="border-table tbl-bottum">
                    <table>
                        <tr class="table_bg">
                            <th class="w-10">Row #</th>
                            <th class="w-20">STP ID</th>
                            <th class="w-30">STP Attachment</th>
                            <th class="w-30">Test Name</th>
                            <th class="w-30">Test Method</th>
                            <th class="w-30">Test Parameters</th>

                        </tr>
                        <tbody>
                            @if ($certificationData && is_array($certificationData))
                                @foreach ($certificationData as $gridData)
                                    <tr>
                                        <td>
                                        {{ $loop->index + 1 }}
                                        </td>
                                        <td>
                                          {{ isset($gridData['STPId']) ? $gridData['STPId'] : '' }}
                                        </td>
                                        <td>
                                            @if(isset($gridData['STPAttach_path']) && $gridData['STPAttach_path'])
                                                <a href="{{ asset('uploads/' . $gridData['STPAttach_path']) }}" target="_blank">
                                                    {{ $gridData['STPAttach_path'] }}
                                                </a>
                                            @else
                                                {{ '' }}
                                            @endif
                                        </td>
                                        <td>
                                            {{ isset($gridData['testName']) ? $gridData['testName'] : '' }}
                                        </td>
                                        <td>
                                            {{ isset($gridData['testMethod']) ? $gridData['testMethod'] : '' }}
                                        </td>
                                        <td>
                                            {{ isset($gridData['testParameter']) ? $gridData['testParameter'] : '' }}
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td style="width: 60px;"><input type="text"
                                            name="certificationData[0][serial]" value="1" readonly>
                                    </td>
                                    <td><input type="text" name="certificationData[0][STPId]"></td>
                                    <td><input type="text"
                                            name="certificationData[0][STPAttach]"></td>
                                    <td><input type="text"
                                            name="certificationData[0][testName]"></td>
                                    <td><input type="text"
                                            name="certificationData[0][testMethod]"></td>
                                    <td><input type="text"
                                            name="certificationData[0][testParameter]"></td>        
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                {{--5 Grid --}}
                <div class="border-table tbl-bottum">
                    <table>
                        <tr class="table_bg">
                            <th class="w-10">Row #</th>
                            <th class="w-30">Testing Frequency</th>
                            <th class="w-30">Testing Location</th>
                            <th class="w-20">LSL</th>
                            <th class="w-20">USL</th>
                            <th class="w-30">Testing Deadline</th>
                        </tr>
                        <tbody>
                            @if ($certificationData && is_array($certificationData))
                                @foreach ($certificationData as $gridData)
                                    <tr>
                                        <td>
                                        {{ $loop->index + 1 }}
                                        </td>
                                        <td>
                                          {{ isset($gridData['testingFrequency']) ? $gridData['testingFrequency'] : '' }}
                                        </td>
                                        <td>
                                            {{ $locations[$gridData['testingLocation']] ?? '' }}
                                        </td>
                                        
                                        <td>
                                            {{ isset($gridData['LSL']) ? $gridData['LSL'] : '' }}
                                        </td>

                                        <td>
                                            {{ isset($gridData['USL']) ? $gridData['USL'] : '' }}
                                        </td>                                        

                                        <td>
                                            {{ isset($gridData['testingDeadline']) ? Helpers::getdateFormat($gridData['testingDeadline']) : '' }}
                                        </td>
                                        
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td style="width: 60px;"><input type="text"
                                            name="certificationData[0][serial]" value="1" readonly>
                                    </td>
                                    <td><input type="text" name="certificationData[0][testingFrequency]"></td>
                                    <td><input type="text"
                                            name="certificationData[0][testingLocation]"></td>
                                    <td><input type="text"
                                            name="certificationData[0][LSL]"></td>
                                    <td><input type="text"
                                            name="certificationData[0][USL]"></td>
                                 
                                    <td><input type="text"
                                            name="certificationData[0][testingDeadline]"></td>             
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                {{--6 Grid --}}
                <div class="border-table tbl-bottum">
                    <table>
                        <tr class="table_bg">
                            <th class="w-10">Row #</th>
                            <th class="w-30">Planner Name</th>
                            <th class="w-30">Sample Source</th>
                            <th class="w-20">Planned Date</th>
                            <th class="w-20">Start Date</th>
                 
                        </tr>
                        <tbody>
                            @if ($certificationData && is_array($certificationData))
                                @foreach ($certificationData as $gridData)
                                    <tr>
                                        <td>
                                        {{ $loop->index + 1 }}
                                        </td>
                                        <td>
                                          {{ isset($gridData['plannerName']) ? $gridData['plannerName'] : '' }}
                                        </td>
                                        <td>
                                        {{ isset($gridData['sampleSource']) ? $gridData['sampleSource'] : '' }}
                                        </td>
                                        <td>
                                            {{ isset($gridData['plannedDate']) ? Helpers::getdateFormat($gridData['plannedDate']) : '' }}
                                        </td>

                                        <td>
                                            {{ isset($gridData['startDate']) ? Helpers::getdateFormat($gridData['startDate']) : '' }}
                                        </td>                                                                                
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td style="width: 60px;"><input type="text"
                                            name="certificationData[0][serial]" value="1" readonly>
                                    </td>
                                    <td><input type="text" name="certificationData[0][plannerName]"></td>
                                    <td><input type="text"
                                            name="certificationData[0][sampleSource]"></td>
                                    <td><input type="text"
                                            name="certificationData[0][plannedDate]"></td>
                                    <td><input type="text"
                                            name="certificationData[0][startDate]"></td>     
                                    
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                {{--7 Grid --}}
                <div class="border-table tbl-bottum">
                    <table>
                        <tr class="table_bg">
                            <th class="w-10">Row #</th>
                            <th class="w-30">Delay Justification</th>
                            <th class="w-30">Lab Technician</th>
                            <th class="w-30">Sample Cost Estimation</th>
                            <th class="w-30">Resource Utilization</th>
                        </tr>
                        <tbody>

                            @php
                                $labTechnicianName = '';
                                if (!empty($gridData['labTechnician'])) {
                                    foreach ($analystData as $item) {
                                        if ($item->userId == $gridData['labTechnician']) {
                                            $labTechnicianName = $item->userName;
                                            break;
                                        }
                                    }
                                }
                            @endphp



                            @if ($certificationData && is_array($certificationData))
                                @foreach ($certificationData as $gridData)
                                
                                    <tr>
                                        <td>
                                        {{ $loop->index + 1 }}
                                        </td>
                                        <td>
                                          {{ isset($gridData['delayJustification']) ? $gridData['delayJustification'] : '' }}
                                        </td>
                                        {{-- <td>
                                        {{ isset($gridData['labTechnician']) ? $gridData['labTechnician'] : '' }}
                                        </td> --}}
                                        <td>
                                            {{ $labTechnicianName }}
                                        </td>

                                        <td>
                                            {{ isset($gridData['sampleCostEstimation']) ? $gridData['sampleCostEstimation'] : '' }}
                                        </td>

                                        <td>
                                            {{ isset($gridData['resourceUtilization']) ? $gridData['resourceUtilization'] : '' }}
                                        </td>                                                                                
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td style="width: 60px;"><input type="text"
                                            name="certificationData[0][serial]" value="1" readonly>
                                    </td>
                                    <td><input type="text" name="certificationData[0][delayJustification]"></td>
                                    <td><input type="text"
                                            name="certificationData[0][labTechnician]"></td>
                                    <td><input type="text"
                                            name="certificationData[0][sampleCostEstimation]"></td>
                                    <td><input type="text"
                                            name="certificationData[0][resourceUtilization]"></td>     
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                {{--8 Grid --}}
                <div class="border-table tbl-bottum">
                    <table>
                        <tr class="table_bg">
                            <th class="w-10">Row #</th>
                            <th class="w-25">Sample Collection Date</th>
                            <th class="w-30">Supporting Documents</th>
                            <th class="w-30">Analysis Type</th>
                            <th class="w-20">Result</th>
                      
                        </tr>
                        <tbody>
                            @if ($certificationData && is_array($certificationData))
                                @foreach ($certificationData as $gridData)
                                    <tr>
                                        <td>
                                           {{ $loop->index + 1 }}
                                        </td>
                                        <td>
                                            {{ isset($gridData['sampleCollectionDate']) ? Helpers::getdateFormat($gridData['sampleCollectionDate']) : '' }}
                                        </td>
                                        <td>
                                            @if(isset($gridData['supportingDocumentGI_path']) && $gridData['supportingDocumentGI_path'])
                                                <a href="{{ asset('uploads/' . $gridData['supportingDocumentGI_path']) }}" target="_blank">
                                                    {{ $gridData['supportingDocumentGI_path'] }}
                                                </a>
                                            @else
                                                {{ '' }}
                                            @endif
                                        </td>
                                        <td>
                                            {{ isset($gridData['analysisType']) ? $gridData['analysisType'] : '' }}
                                        </td>
                                        <td>
                                            {{ isset($gridData['results']) ? $gridData['results'] : '' }}
                                        </td>
                                                                                                      
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td style="width: 60px;"><input type="text"
                                            name="certificationData[0][serial]" value="1" readonly>
                                    </td>
                                    <td><input type="text" name="certificationData[0][sampleCollectionDate]"></td>
                                    <td><input type="text"
                                            name="certificationData[0][supportingDocumentGI]"></td>
                                    <td><input type="text"
                                            name="certificationData[0][analysisType]"></td>
                                    <td><input type="text"
                                            name="certificationData[0][results]"></td>
                                     
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>


                {{--8.1.1 Grid --}}
                <div class="border-table tbl-bottum">
                    <table>
                        <tr class="table_bg">
                            <th class="w-10">Row #</th>
                            <th class="w-30">Analysis Result</th>
                            <th class="w-30">Analyst</th>
                            <th class="w-30">Reagent</th>
                            <th class="w-30">Testing Start Date</th>
                        </tr>
                        <tbody>

                            @php
                                $analystName = '';
                                if (!empty($gridData['analyst'])) {
                                    foreach ($analystData as $item) {
                                        if ($item->userId == $gridData['analyst']) {
                                            $analystName = $item->userName;
                                            break;
                                        }
                                    }
                                }

                       

                                $reagentNames = [];
                                    if (!empty($gridData['reagent'])) {
                                        $reagentNames = explode(',', $gridData['reagent']); // Explode comma-separated values
                                    }
                            @endphp

                            {{-- $reagentNames = [];
                                if (!empty($gridData['reagent'])) {
                                    $reagentIds = explode(',', $gridData['reagent']);
                                    foreach ($reagentData as $item) {
                                        if (in_array($item->id, $reagentIds)) {
                                            $reagentNames[] = $item->name;
                                        }
                                    }
                                } --}}
                            @if ($certificationData && is_array($certificationData))
                                @foreach ($certificationData as $gridData)
                                    <tr>
                                        <td>
                                           {{ $loop->index + 1 }}
                                        </td>
                                        
                                        <td>
                                            {{ isset($gridData['analysisResult']) ? $gridData['analysisResult'] : '' }}
                                        </td>   
                                        {{-- <td>
                                            {{ isset($gridData['analyst']) ? $gridData['analyst'] : '' }}
                                        </td>  --}}
                                        <td>
                                            {{ $analystName }}
                                        </td>
                                        {{-- <td>
                                            {{ isset($gridData['reagent']) ? $gridData['reagent'] : '' }}
                                        </td>     --}}
                                        <td>
                                            {{ !empty($reagentNames) ? implode(', ', $reagentNames) : 'No reagents selected' }}
                                        </td>

                                        <td>
                                          {{ isset($gridData['testingStartDate']) ? Helpers::formatDateTime($gridData['testingStartDate']) : '' }}
                                        </td>                                                                           
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td style="width: 60px;"><input type="text"
                                            name="certificationData[0][serial]" value="1" readonly>
                                    </td>
                                 
                                    <td><input type="text"
                                            name="certificationData[0][analysisResult]"></td>
                                    <td><input type="text"
                                            name="certificationData[0][analyst]"></td>
                                    <td><input type="text"
                                            name="certificationData[0][reagent]"></td> 
                                    <td><input type="text"
                                            name="certificationData[0][testingStartDate]"></td>            
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                {{--9 Grid --}}
                <div class="border-table tbl-bottum">
                    <table>
                        <tr class="table_bg">
                            <th class="w-10">Row #</th>
                            <th class="w-30">Testing End Date</th>
                            <th class="w-30">Analysis Status</th>
                            <th class="w-30">Pass/Fail</th>
                            <th class="w-30">Instruction for other Analyst</th>

                        </tr>
                        <tbody>
                            @if ($certificationData && is_array($certificationData))
                                @foreach ($certificationData as $gridData)
                                    <tr>
                                        <td>
                                        {{ $loop->index + 1 }}
                                        </td>
                            
                                        <td>
                                            {{ isset($gridData['testingEndDate']) ? Helpers::formatDateTime($gridData['testingEndDate']) : '' }}
                                        </td>
                                        <td>
                                          {{ isset($gridData['analysisStatus']) ? $gridData['analysisStatus'] : '' }}
                                        </td>
                                        <td>
                                            {{ isset($gridData['passFail']) ? $gridData['passFail'] : '' }}
                                        </td>    
                                        <td>
                                            {{ isset($gridData['analystInstruction']) ? $gridData['analystInstruction'] : '' }}
                                        </td>                                                                              
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td style="width: 60px;"><input type="text"
                                            name="certificationData[0][serial]" value="1" readonly>
                                    </td>

                                    <td><input type="text"
                                            name="certificationData[0][testingEndDate]"></td>
                                    <td><input type="text" name="certificationData[0][analysisStatus]"></td>
                                    <td><input type="text"
                                            name="certificationData[0][passFail]"></td>  
                                    <td><input type="text"
                                            name="certificationData[0][analystInstruction]"></td>     
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                {{--10 Grid --}}
                <div class="border-table tbl-bottum">
                    <table>
                        <tr class="table_bg">
                            <th class="w-10">Row #</th>
                            <th class="w-20">Test Plan Id</th>
                            <th class="w-30">Turnaround Time (TAT)</th>
                            <th class="w-30">Sample Retesting Date</th>
                            <th class="w-30">Review Due Date</th>
                        </tr>
                        <tbody>
                            @if ($certificationData && is_array($certificationData))
                                @foreach ($certificationData as $gridData)
                                    <tr>
                                        <td>
                                        {{ $loop->index + 1 }}
                                        </td>
                                        <td>
                                          {{ isset($gridData['testPlanId']) ? $gridData['testPlanId'] : '' }}
                                        </td>
                                        <td>
                                          {{ isset($gridData['turaroundTime']) ? $gridData['turaroundTime'] : '' }}
                                        </td>
                                        <td>
                                            {{ isset($gridData['sampleRetestingDate']) ? Helpers::getdateFormat($gridData['sampleRetestingDate']) : '' }}
                                        </td>
                                        <td>
                                            {{ isset($gridData['reviewDate']) ? Helpers::getdateFormat($gridData['reviewDate']) : '' }}
                                        </td>                                                                                
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td style="width: 60px;"><input type="text"
                                            name="certificationData[0][serial]" value="1" readonly>
                                    </td>
                                    <td><input type="text" name="certificationData[0][testPlanId]"></td>
                                    <td><input type="text"
                                            name="certificationData[0][turaroundTime]"></td>
                                    <td><input type="text"
                                            name="certificationData[0][sampleRetestingDate]"></td>
                                    <td><input type="text"
                                            name="certificationData[0][reviewDate]"></td>     
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                {{--11 Grid --}}
                <div class="border-table tbl-bottum">
                    <table>
                        <tr class="table_bg">
                            <th class="w-10">Row #</th>
                            <th class="w-30">Sample Storage Location</th>
                            <th class="w-30">Transportation Method</th>
                            <th class="w-30">Sample Preparation Method</th>
                            <th class="w-30">Sample Packaging Details</th>
                        </tr>
                        <tbody>
                            @if ($certificationData && is_array($certificationData))
                                @foreach ($certificationData as $gridData)
                                    <tr>
                                        <td>
                                        {{ $loop->index + 1 }}
                                        </td>
                                        {{-- <td>
                                          {{ isset($gridData['sampleStorageLocation']) ? $gridData['sampleStorageLocation'] : '' }}
                                        </td> --}}
                                        <td>
                                            {{ $locations[$gridData['sampleStorageLocation']] ?? '' }}
                                        </td>
                                        <td>
                                          {{ isset($gridData['transportationMethod']) ? $gridData['transportationMethod'] : '' }}
                                        </td>
                                        <td>
                                            {{ isset($gridData['samplePreprationMethod']) ? $gridData['samplePreprationMethod'] : '' }}
                                        </td>
                                        <td>
                                            {{ isset($gridData['samplePackagingDetail']) ? $gridData['samplePackagingDetail'] : '' }}
                                        </td>                                                                                
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td style="width: 60px;"><input type="text"
                                            name="certificationData[0][serial]" value="1" readonly>
                                    </td>
                                    <td><input type="text" name="certificationData[0][sampleStorageLocation]"></td>
                                    <td><input type="text"
                                            name="certificationData[0][transportationMethod]"></td>
                                    <td><input type="text"
                                            name="certificationData[0][samplePreprationMethod]"></td>
                                    <td><input type="text"
                                            name="certificationData[0][samplePackagingDetail]"></td>     
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                {{--12 Grid --}}
                <div class="border-table tbl-bottum">
                    <table>
                        <tr class="table_bg">
                            <th class="w-10">Row #</th>
                            <th class="w-30">Sample Label</th>
                            <th class="w-30">Regulatory Requirements</th>
                            <th class="w-30">Quality Control Checks</th>
                            <th class="w-30">Control Sample Reference</th>
                        </tr>
                        <tbody>
                            @if ($certificationData && is_array($certificationData))
                                @foreach ($certificationData as $gridData)
                                    <tr>
                                        <td>
                                        {{ $loop->index + 1 }}
                                        </td>
                                        <td>
                                          {{ isset($gridData['sampleLabel']) ? $gridData['sampleLabel'] : '' }}
                                        </td>
                                        <td>
                                          {{ isset($gridData['regulatoryRequirement']) ? $gridData['regulatoryRequirement'] : '' }}
                                        </td>
                                        <td>
                                            {{ isset($gridData['qualityControlCheck']) ? $gridData['qualityControlCheck'] : '' }}
                                        </td>
                                        <td>
                                            {{ isset($gridData['controlSamplePreference']) ? $gridData['controlSamplePreference'] : '' }}
                                        </td>                                                                                
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td style="width: 60px;"><input type="text"
                                            name="certificationData[0][serial]" value="1" readonly>
                                    </td>
                                    <td><input type="text" name="certificationData[0][sampleLabel]"></td>
                                    <td><input type="text"
                                            name="certificationData[0][regulatoryRequirement]"></td>
                                    <td><input type="text"
                                            name="certificationData[0][qualityControlCheck]"></td>
                                    <td><input type="text"
                                            name="certificationData[0][controlSamplePreference]"></td>     
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                {{--13 Grid --}}
                <div class="border-table tbl-bottum">
                    <table>
                        <tr class="table_bg">
                            <th class="w-10">Row #</th>
                            <th class="w-30">Control Sample</th>
                            <th class="w-30">Reference Sample</th>
                            <th class="w-30">Sample Integrity Status</th>
                            <th class="w-30">Assigned Department</th>
                        </tr>
                        <tbody>
                            @if ($certificationData && is_array($certificationData))
                                @foreach ($certificationData as $gridData)
                                    <tr>
                                        <td>
                                        {{ $loop->index + 1 }}
                                        </td>
                                        <td>
                                          {{ isset($gridData['controlSample']) ? $gridData['controlSample'] : '' }}
                                        </td>
                                        <td>
                                          {{ isset($gridData['referenceSample']) ? $gridData['referenceSample'] : '' }}
                                        </td>
                                        <td>
                                            {{ isset($gridData['sampleIntegrityStatus']) ? $gridData['sampleIntegrityStatus'] : '' }}
                                        </td>
                                        <td>
                                            {{ isset($gridData['assignedDepartment']) ? Helpers::getNewInitiatorGroupFullName($gridData['assignedDepartment']) : '' }}
                                        </td>
                                                                             
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td style="width: 60px;"><input type="text"
                                            name="certificationData[0][serial]" value="1" readonly>
                                    </td>
                                    <td><input type="text" name="certificationData[0][controlSample]"></td>
                                    <td><input type="text"
                                            name="certificationData[0][referenceSample]"></td>
                                    <td><input type="text"
                                            name="certificationData[0][sampleIntegrityStatus]"></td>
                                    <td><input type="text"
                                            name="certificationData[0][assignedDepartment]"></td>     
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                {{--14 Grid --}}
                <div class="border-table tbl-bottum">
                    <table>
                        <tr class="table_bg">
                            <th class="w-10">Row #</th>
                            <th class="w-30">Risk Assessment</th>
                            <th class="w-30">Supervisor</th>
                            <th class="w-30">Instruments Reserved</th>
                            <th class="w-30">Lab Availability</th>
                        </tr>
                        <tbody>
                            @if ($certificationData && is_array($certificationData))
                                @foreach ($certificationData as $gridData)
                                    <tr>
                                        <td>
                                        {{ $loop->index + 1 }}
                                        </td>
                                        <td>
                                          {{ isset($gridData['riskAssessment']) ? $gridData['riskAssessment'] : '' }}
                                        </td>
                                        <td>
                                          {{ isset($gridData['supervisor']) ? $gridData['supervisor'] : '' }}
                                        </td>
                                        <td>
                                            {{ isset($gridData['instrumentReserved']) ? $gridData['instrumentReserved'] : '' }}
                                        </td>
                                        <td>
                                            {{ isset($gridData['labAvailability']) ? $gridData['labAvailability'] : '' }}
                                        </td>                                                                                
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td style="width: 60px;"><input type="text"
                                            name="certificationData[0][serial]" value="1" readonly>
                                    </td>
                                    <td><input type="text" name="certificationData[0][riskAssessment]"></td>
                                    <td><input type="text"
                                            name="certificationData[0][supervisor]"></td>
                                    <td><input type="text"
                                            name="certificationData[0][instrumentReserved]"></td>
                                    <td><input type="text"
                                            name="certificationData[0][labAvailability]"></td>     
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                {{--15 Grid --}}
                <div class="border-table tbl-bottum">
                    <table>
                        <tr class="table_bg">
                            <th class="w-10">Row #</th>
                            <th class="w-30">Sample Date</th>
                            <th class="w-30">Sample Movement History</th>
                            <th class="w-30">Testing Progress</th>
                            <th class="w-30">Alerts/Notifications</th>
                        </tr>
                        <tbody>
                            @if ($certificationData && is_array($certificationData))
                                @foreach ($certificationData as $gridData)
                                    <tr>
                                        <td>
                                        {{ $loop->index + 1 }}
                                        </td>
                                        <td>
                                          {{ isset($gridData['sampleDate']) ? Helpers::getdateFormat($gridData['sampleDate']) : '' }}
                                        </td>
                                        <td>
                                          {{ isset($gridData['sampleMovementHistory']) ? $gridData['sampleMovementHistory'] : '' }}
                                        </td>
                                        <td>
                                            {{ isset($gridData['testingProcess']) ? $gridData['testingProcess'] : '' }}
                                        </td>
                                        <td>
                                            {{ isset($gridData['alertNotification']) ? $gridData['alertNotification'] : '' }}
                                        </td>                                                                                
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td style="width: 60px;"><input type="text"
                                            name="certificationData[0][serial]" value="1" readonly>
                                    </td>
                                    <td><input type="text" name="certificationData[0][sampleDate]"></td>
                                    <td><input type="text"
                                            name="certificationData[0][sampleMovementHistory]"></td>
                                    <td><input type="text"
                                            name="certificationData[0][testingProcess]"></td>
                                    <td><input type="text"
                                            name="certificationData[0][alertNotification]"></td>     
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                {{--16 Grid --}}
                <div class="border-table tbl-bottum">
                    <table>
                        <tr class="table_bg">
                            <th class="w-10">Row #</th>
                            <th class="w-30">Deviation Logs</th>
                            <th class="w-30">Comments/Notes</th>
                            <th class="w-30">Attachment</th>
                            <th class="w-30">Sampling Frequency</th>
                        </tr>
                        <tbody>
                            @if ($certificationData && is_array($certificationData))
                                @foreach ($certificationData as $gridData)
                                    <tr>
                                        <td>
                                        {{ $loop->index + 1 }}
                                        </td>
                                        <td>
                                          {{ isset($gridData['deviationLogs']) ? $gridData['deviationLogs'] : '' }}
                                        </td>
                                        <td>
                                          {{ isset($gridData['commentsLog']) ? $gridData['commentsLog'] : '' }}
                                        </td>
                                        <td>
                                            @if(isset($gridData['attachment_path']) && $gridData['attachment_path'])
                                                <a href="{{ asset('uploads/' . $gridData['attachment_path']) }}" target="_blank">
                                                    {{ $gridData['attachment_path'] }}
                                                </a>
                                            @else
                                                {{ '' }}
                                            @endif
                                        <td>
                                            {{ isset($gridData['samplingFrequency']) ? $gridData['samplingFrequency'] : '' }}
                                        </td>                                                                                
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td style="width: 60px;"><input type="text"
                                            name="certificationData[0][serial]" value="1" readonly>
                                    </td>
                                    <td><input type="text" name="certificationData[0][deviationLogs]"></td>
                                    <td><input type="text"
                                            name="certificationData[0][commentsLog]"></td>
                                    <td><input type="text"
                                            name="certificationData[0][attachment_path]"></td>
                                    <td><input type="text"
                                            name="certificationData[0][samplingFrequency]"></td>     
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                {{--17 Grid --}}
                <div class="border-table tbl-bottum">
                    <table>
                        <tr class="table_bg">
                            <th class="w-10">Row #</th>
                            <th class="w-30">Stability Study Type</th>
                            <th class="w-30">Supporting Documents</th>
                            <th class="w-30">Stability Status</th>
                        </tr>
                        <tbody>
                            @if ($certificationData && is_array($certificationData))
                                @foreach ($certificationData as $gridData)
                                    <tr>
                                        <td>
                                        {{ $loop->index + 1 }}
                                        </td>
                                        <td>
                                          {{ isset($gridData['stabilityStudyType']) ? $gridData['stabilityStudyType'] : '' }}
                                        </td>
                                        <td> 
                                            @if(isset($gridData['supportingDocumentSampleAnalysis_path']) && $gridData['supportingDocumentSampleAnalysis_path'])
                                                <a href="{{ asset('uploads/' . $gridData['supportingDocumentSampleAnalysis_path']) }}" target="_blank">
                                                    {{ $gridData['supportingDocumentSampleAnalysis_path'] }}
                                                </a>
                                            @else
                                                {{ '' }}
                                            @endif
                                        </td>
                                        
                                        <td>
                                            {{ isset($gridData['stabilityStatus']) ? $gridData['stabilityStatus'] : '' }}
                                        </td>  

                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td style="width: 60px;"><input type="text"
                                            name="certificationData[0][serial]" value="1" readonly>
                                    </td>
                                    <td><input type="text" name="certificationData[0][stabilityStudyType]"></td>
                                    <td><input type="text" name="certificationData[0][supportingDocumentSampleAnalysis_path]"></td>
                                    
                                    <td><input type="text"
                                            name="certificationData[0][stabilityStatus]"></td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                {{--18 Grid --}}
                <div class="border-table tbl-bottum">
                    <table>
                        <tr class="table_bg">
                            <th class="w-10">Row #</th>
                            <th class="w-30">Stability Study Protocol</th>
                            <th class="w-30">Stability Protocol Approval Date</th>
                            <th class="w-30">Country of Regulatory Submissions</th>
                        </tr>
                        <tbody>
                            @if ($certificationData && is_array($certificationData))
                                @foreach ($certificationData as $gridData)
                                    <tr>
                                        <td>
                                        {{ $loop->index + 1 }}
                                        </td>
                                        <td> 
                                            @if(isset($gridData['stabilityProtocolAttach_path']) && $gridData['stabilityProtocolAttach_path'])
                                                <a href="{{ asset('/' . $gridData['stabilityProtocolAttach_path']) }}" target="_blank">
                                                    {{ $gridData['stabilityProtocolAttach_path'] }}
                                                </a>
                                            @else
                                                {{ '' }}
                                            @endif
                                        </td>
                                        <td>
                                          {{ isset($gridData['stabilityApprovalDate']) ? Helpers::getdateFormat($gridData['stabilityApprovalDate']) : '' }}
                                        </td>
                                        <td>
                                          {{ isset($gridData['countryOfRegulatorySubmision']) ? $gridData['countryOfRegulatorySubmision'] : '' }}
                                        </td>                                        
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td style="width: 60px;"><input type="text"
                                            name="certificationData[0][serial]" value="1" readonly>
                                    </td>
                                    <td><input type="text"
                                               name="certificationData[0][stabilityProtocolAttach_path]"></td>
                                    <td><input type="text" name="certificationData[0][stabilityApprovalDate]"></td>
                                    <td><input type="text"
                                            name="certificationData[0][countryOfRegulatorySubmision]"></td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                {{--19 Grid --}}
                <div class="border-table tbl-bottum">
                    <table>
                        <tr class="table_bg">
                            <th class="w-10">Row #</th>
                            <th class="w-30">ICH Zone</th>
                            <th class="w-30">Photostability Testing Results</th>
                            <th class="w-30">Reconstitution Stability</th>
                            <th class="w-30">Testing Interval (Months)</th>

                        </tr>
                        <tbody>
                            @if ($certificationData && is_array($certificationData))
                                @foreach ($certificationData as $gridData)
                                    <tr>
                                        <td>
                                        {{ $loop->index + 1 }}
                                        </td>
                                        <td>
                                            {{ isset($gridData['ICHZone']) ? $gridData['ICHZone'] : '' }}
                                        </td>   
                                        
                                        <td>
                                            {{ isset($gridData['photostabilityTestingResult']) ? $gridData['photostabilityTestingResult'] : '' }}
                                        </td>
                                        <td>
                                          {{ isset($gridData['reconstitutionStability']) ? $gridData['reconstitutionStability'] : '' }}
                                        </td>
                                        <td>
                                          {{ isset($gridData['testingInterval']) ? $gridData['testingInterval'] : '' }}
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td style="width: 60px;"><input type="text"
                                            name="certificationData[0][serial]" value="1" readonly>
                                    </td>
                                    <td><input type="text"
                                            name="certificationData[0][ICHZone]"></td>
                                    <td><input type="text"
                                            name="certificationData[0][photostabilityTestingResult]"></td> 
                                    <td><input type="text" name="certificationData[0][reconstitutionStability]"></td>
                                    <td><input type="text"
                                            name="certificationData[0][testingInterval]"></td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>



                {{--20 Grid --}}
                <div class="border-table tbl-bottum">
                    <table>
                        <tr class="table_bg">
                            <th class="w-10">Row #</th>
                            <th class="w-30">Shelf Life Recommendation</th>
                            <th class="w-30">Stability Attachment</th>
                            <th class="w-30">Reviewer/Approver</th>
                        </tr>
                        <tbody>
                            @if ($certificationData && is_array($certificationData))
                                @foreach ($certificationData as $gridData)
                                    <tr>
                                        <td>
                                        {{ $loop->index + 1 }}
                                        </td>
                                        {{-- <td>
                                          {{ isset($gridData['reviewerApprover']) ? $gridData['reviewerApprover'] : '' }}
                                        </td> --}}
                                        <td>
                                            {{ isset($gridData['shelfLifeRecommendation']) ? $gridData['shelfLifeRecommendation'] : '' }}
                                        </td>   
                                        
                                        <td> 
                                            @if(isset($gridData['stabilityAttachment_path']) && $gridData['stabilityAttachment_path'])
                                                <a href="{{ asset('uploads/' . $gridData['stabilityAttachment_path']) }}" target="_blank">
                                                    {{ $gridData['stabilityAttachment_path'] }}
                                                </a>
                                            @else
                                                {{ '' }}
                                            @endif
                                        </td>
                                        <td>
                                            {{ isset($gridData['reviewerApprover']) && isset($users[$gridData['reviewerApprover']]) 
                                                ? $users[$gridData['reviewerApprover']] 
                                                : 'N/A' }}
                                        </td>                   
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td style="width: 60px;"><input type="text"
                                            name="certificationData[0][serial]" value="1" readonly>
                                    </td>
                                    <td><input type="text"
                                            name="certificationData[0][shelfLifeRecommendation]"></td>
                                    <td><input type="text"
                                            name="certificationData[0][stabilityAttachment_path]"></td> 
                                    <td><input type="text" name="certificationData[0][reviewerApprover]"></td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                {{--21 Grid --}}
                <div class="border-table tbl-bottum">
                    <table>
                        <tr class="table_bg">
                            <th class="w-10">Row #</th>
                            <th class="w-30">Sample Desposion</th>
                            <th class="w-30">Reviewer Comment</th>
                            <th class="w-30">Review Date</th>
                            <th class="w-30">Supervisor Attachment</th>
                    
                        </tr>
                        <tbody>
                            @if ($certificationData && is_array($certificationData))
                                @foreach ($certificationData as $gridData)
                                    <tr>
                                        <td>
                                        {{ $loop->index + 1 }}
                                        </td>
                                        <td>
                                          {{ isset($gridData['sampleDesposion']) ? $gridData['sampleDesposion'] : '' }}
                                        </td>
                                        <td>
                                            {{ isset($gridData['reviewerComment']) ? $gridData['reviewerComment'] : '' }}
                                        </td>   
                                        
                                        <td>
                                            {{ isset($gridData['supervisorReviewDate']) ? Helpers::getdateFormat($gridData['supervisorReviewDate']) : '' }}
                                        </td>
                                        <td> 
                                            @if(isset($gridData['supervisorAttach_path']) && $gridData['supervisorAttach_path'])
                                                <a href="{{ asset('uploads/' . $gridData['supervisorAttach_path']) }}" target="_blank">
                                                    {{ $gridData['supervisorAttach_path'] }}
                                                </a>
                                            @else
                                                {{ '' }}
                                            @endif
                                        </td>
                                       
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td style="width: 60px;"><input type="text"
                                            name="certificationData[0][serial]" value="1" readonly>
                                    </td>
                                    <td><input type="text"
                                            name="certificationData[0][sampleDesposion]"></td>
                                    <td><input type="text"
                                            name="certificationData[0][reviewerComment]"></td>
                                    <td><input type="text"
                                            name="certificationData[0][supervisorReviewDate]"></td>  
                                    <td><input type="text" name="certificationData[0][supervisorAttach_path]"></td>
                              
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                {{--22 Grid --}}
                <div class="border-table tbl-bottum">
                    <table>
                        <tr class="table_bg">
                            <th class="w-10">Row #</th>
                            <th class="w-30">QA Reviewer/Approver</th>
                            <th class="w-30">QA Reviewer Comment</th>
                            <th class="w-30">QA Review Date</th>
                            <th class="w-30">QA Attachment</th>
                        
                        </tr>
                        <tbody>
                            @if ($certificationData && is_array($certificationData))
                                @foreach ($certificationData as $gridData)
                                    <tr>
                                        <td>
                                        {{ $loop->index + 1 }}
                                        </td>
                                        <td>
                                            {{ isset($gridData['QAreviewerApprover']) && isset($users[$gridData['QAreviewerApprover']]) 
                                                ? $users[$gridData['QAreviewerApprover']] 
                                                : 'N/A' }}
                                       
                                        </td>
                                        <td>
                                            {{ isset($gridData['QAreviewerComment']) ? $gridData['QAreviewerComment'] : '' }}
                                        </td>   
                                        
                                        <td>
                                            {{ isset($gridData['QAreviewDate']) ? Helpers::getdateFormat($gridData['QAreviewDate']) : '' }}
                                        </td>
                                        <td> 
                                            @if(isset($gridData['QAsupervisorAttach_path']) && $gridData['QAsupervisorAttach_path'])
                                                <a href="{{ asset('uploads/' . $gridData['QAsupervisorAttach_path']) }}" target="_blank">
                                                    {{ $gridData['QAsupervisorAttach_path'] }}
                                                </a>
                                            @else
                                                {{ '' }}
                                            @endif
                                        </td>
                
                                
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td style="width: 60px;"><input type="text"
                                            name="certificationData[0][serial]" value="1" readonly>
                                    </td>
                                    <td><input type="text"
                                            name="certificationData[0][QAreviewerApprover]"></td>
                                    <td><input type="text"
                                            name="certificationData[0][QAreviewerComment]"></td>
                                    <td><input type="text"
                                            name="certificationData[0][QAreviewDate]"></td>   
                                    <td><input type="text" name="certificationData[0][QAsupervisorAttach_path]"></td>
                                 
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                {{--23 Grid --}}
                <div class="border-table tbl-bottum">
                    <table>
                        <tr class="table_bg">
                            <th class="w-10">Row #</th>
                            <th class="w-20">Destruction Due On</th>
                            <th class="w-20">Destruction Date</th>
                            <th class="w-30">Destricted By</th>
                            <th class="w-30">Remarks</th>
                        </tr>
                        <tbody>
                            @if ($certificationData && is_array($certificationData))
                                @foreach ($certificationData as $gridData)
                                    <tr>
                                        <td>
                                        {{ $loop->index + 1 }}
                                        </td>
                                        <td>
                                          {{ isset($gridData['destructionDueOn']) ? Helpers::getdateFormat($gridData['destructionDueOn']) : '' }}
                                        </td>
                                        <td>
                                            {{ isset($gridData['desctructionDate']) ? Helpers::getdateFormat($gridData['desctructionDate']) : '' }}
                                        </td>   
                                        
                                        <td>
                                            {{ isset($gridData['destructedBy']) ? $gridData['destructedBy'] : '' }}
                                        </td>
                                        <td>
                                            {{ isset($gridData['destructionRemarks']) ? $gridData['destructionRemarks'] : '' }}
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td style="width: 60px;"><input type="text"
                                            name="certificationData[0][serial]" value="1" readonly>
                                    </td>
                                    <td><input type="text"
                                            name="certificationData[0][destructionDueOn]"></td>
                                    <td><input type="text"
                                            name="certificationData[0][desctructionDate]"></td>
                                    <td><input type="text"
                                            name="certificationData[0][destructedBy]"></td>  
                                    <td><input type="text"
                                            name="certificationData[0][destructionRemarks]"></td>           
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

            <div class="block">
                <div class="block-head">
                    Supervisor Review
                </div>
                <!-- @php
                    use App\Models\User;

                    $reviewerApproverName = 'Not Applicable';
                    if ($data->reviewer_approver) {
                        $user = User::where('id', $data->reviewer_approver)->first();
                        if ($user) {
                            $reviewerApproverName = $user->name;
                        }
                    }
                @endphp -->





                <table>
                    <!-- <tr>
                        <th class="w-20">Reviewer/Approver</th>
                        <td class="w-80" colspan="3">
                            @if ($data->reviewer_approver)
                                {{ $data->reviewer_approver }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr> -->


                    <tr>
                        <th class="w-20">Reviewer/Approver</th>
                        <td class="w-80" colspan="3">
                            {{ $data->reviewer_approver 
                                ? (App\Models\User::where('id', $data->reviewer_approver)->value('name') ?? 'Not Applicable') 
                                : 'Not Applicable' }}
                        </td>
                    </tr>





                    <tr>
                    <th class="w-20">Reviewer Comment</th>
                        <td class="w-80" colspan="3">
                            @if ($data->reviewer_comment)
                                {{ $data->reviewer_comment }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Review Date</th>
                        <td class="w-80" colspan="3">
                            @if ($data->review_date)
                                {{ Helpers::getdateFormat($data->review_date) }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                </table>

                <div class="border-table">
                    <div class="block-head">
                    Supportive Attachments
                    </div>
                    <table>
                        <tr class="table_bg">
                            <th class="w-20">S.N.</th>
                            <th class="w-60">Batch No</th>
                        </tr>
                        @if ($data->supervisor_attachment)
                            @foreach (json_decode($data->supervisor_attachment) as $key => $file)
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

                <div class="block-head mt-1">
                    QA Review
                </div>

                <!-- @php
               

                    $qaReviewerApproverName = 'Not Applicable';
                    if ($data->QA_reviewer_approver) {
                        $user = User::where('id', $data->QA_reviewer_approver)->first();
                        if ($user) {
                            $qaReviewerApproverName = $user->name;
                        }
                    }
                @endphp -->
                <table>
                    <tr>
                        <!-- <th class="w-20">QA Reviewer/Approver</th>
                        <td class="w-80" colspan="3">
                            @if ($data->QA_reviewer_approver)
                                {{ $data->QA_reviewer_approver }}
                            @else
                                Not Applicable
                            @endif
                        </td> -->
                        
                        <th class="w-20">QA Reviewer/Approver</th>
                        <td class="w-80" colspan="3">
                        {{ $data->QA_reviewer_approver 
                                ? (App\Models\User::where('id', $data->QA_reviewer_approver)->value('name') ?? 'Not Applicable') 
                                : 'Not Applicable' }}
                        </td>
                    </tr>
                    

                    <tr>
                    <th class="w-20">QA Reviewer Comment</th>
                        <td class="w-80" colspan="3">
                            @if ($data->QA_reviewer_comment)
                                {{ $data->QA_reviewer_comment }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">QA Review Date</th>
                        <td class="w-80" colspan="3">
                            @if ($data->QA_review_date)
                                {{ Helpers::getdateFormat($data->QA_review_date) }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                    </tr>
                </table>
                <div class="border-table">
                    <div class="block-head">
                      QA Attachment
                    </div>
                    <table>
                        <tr class="table_bg">
                            <th class="w-20">S.N.</th>
                            <th class="w-60">Batch No</th>
                        </tr>
                        @if ($data->QA_attachment)
                            @foreach (json_decode($data->QA_attachment) as $key => $file)
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
                Activity log
            </div>
            <table>

                <tr>
                    <th class="w-20">Sample Registration By</th>
                    <td class="w-30">
                        @if ($data->sample_registration_by)
                            {{ $data->sample_registration_by }}
                        @else
                            Not Applicable
                        @endif
                    </td>
                    <th class="w-20">Sample Registration On</th>
                    <td class="w-30">
                        @if ($data->sample_registration_on)
                            {{ Helpers::getdateFormat($data->sample_registration_on) }}
                        @else
                            Not Applicable
                        @endif
                    </td>
               
                    <th class="w-20">Sample Registration Comment</th>
                    <td class="w-80">
                        @if ($data->sample_registration_comment)
                            {{ $data->sample_registration_comment }}
                        @else
                            Not Applicable
                        @endif
                    </td>
                </tr>
                <tr>
                    <th class="w-20">Analysis Complete By</th>
                <td class="w-30">
                    @if ($data->analysis_complete_by)
                        {{ $data->analysis_complete_by }}
                    @else
                        Not Applicable
                    @endif
                </td>
                <th class="w-20">Analysis Complete On</th>
                <td class="w-30">
                    @if ($data->analysis_complete_on)
                        {{ Helpers::getdateFormat($data->analysis_complete_on) }}
                    @else
                        Not Applicable
                    @endif
                </td>
                <th class="w-20">Analysis Complete Comment</th>
                <td class="w-80">
                    @if ($data->analysis_complete_comment)
                        {{ $data->analysis_complete_comment }}
                    @else
                        Not Applicable
                    @endif
                </td>
                </tr>

                <tr>
                    <th class="w-20">Supervisor Review Complete By</th>
                    <td class="w-30">
                        @if ($data->supervisor_review_by)
                            {{ $data->supervisor_review_by }}
                        @else
                            Not Applicable
                        @endif
                    </td>
                    <th class="w-20">Supervisor Review Complete On</th>
                    <td class="w-30">
                        @if ($data->supervisor_review_on)
                            {{ Helpers::getdateFormat($data->supervisor_review_on) }}
                        @else
                            Not Applicable
                        @endif
                    </td>
                    <th class="w-20">Supervisor Review Complete Comment</th>
                    <td class="w-80">
                        @if ($data->supervisor_review_comment)
                            {{ $data->supervisor_review_comment }}
                        @else
                            Not Applicable
                        @endif
                    </td>
                </tr>

                <tr>
                    <th class="w-20">QA Review Complete By</th>
                    <td class="w-30">
                        @if ($data->QA_Review_by)
                            {{ $data->QA_Review_by }}
                        @else
                            Not Applicable
                        @endif
                    </td>
                    <th class="w-20">QA Review Complete On</th>
                    <td class="w-30">
                        @if ($data->QA_Review_on)
                            {{ Helpers::getdateFormat($data->QA_Review_on) }}
                        @else
                            Not Applicable
                        @endif
                    </td>
                    <th class="w-20">QA Review Complete Comment</th>
                    <td class="w-30">
                        @if ($data->QA_Review_comment)
                            {{ $data->QA_Review_comment }}
                        @else
                            Not Applicable
                        @endif
                    </td>
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
