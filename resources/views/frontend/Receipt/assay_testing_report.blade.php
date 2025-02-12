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

    /* @page {
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
    } */

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
        padding-left: 8px;
    }

    .div-data {
        font-size: 13px;
        padding-left: 8px;
        margin-bottom: 20px;
    }

    @page {
        size: A4;
       
    }

    header {
        position: fixed;
        top: 0px;
        left: 0;
        width: 100%;
        z-index:1000;
    }

    footer {
        width: 100%;
        position: fixed;
        bottom: 0px;
        left: 0;
        z-index:1000;
        font-size: 0.9rem;
    } 
    body{
        margin-top: 160px;
        margin-bottom: 20px;
    }
</style>

<body>   

    <header>
        <table>
            <tr>
                <td rowspan="3" class="w-20">
                    <div class="logo">
                        <img src="https://navin.mydemosoftware.com/public/user/images/logo.png" alt=""
                            class="w-100">
                    </div>
                </td>
                <td colspan="2" class="text-center"></td>
            </tr>
            <tr>
                <td colspan="2">
                    <strong>Division: </strong> {{ Helpers::getFullDivisionName($data->receipt_division) }}
                </td>                
            </tr>
            <tr>
                <td class="w-50">
                    <strong>Title:</strong> {{$data->objective_assay}} – Assay Test Analysis Report
                </td>
                <td class="w-30">
                    <strong>Date:</strong> {{ date('d-M-Y') }}
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
                <p><strong>Objective:</strong> 
                    {{-- To Verify Assay Test method of  --}}
                    {{$data->objective_assay}}</p>                
                <p><strong>Background:</strong> {{$data->background_assay}}</p>
                <p><strong>Method:</strong> 
                    {{-- As per Annexure-1   --}}
                    {{$data->method_assay}}</p>
            </div>

            <div class="block">
                <div class="block-head">
                    Details of Standards and Samples:
                </div>
                <div class="border-table">
                    <table>                            
                        <thead>                                
                            <tr class="table_bg" style="text-align: center; vertical-align: middle; padding: 20px;">
                                <th>S.No.</th>
                                <th>Reg. No.</th>
                                <th>Date</th>
                                <th>Name of Standards/ Samples</th>
                                <th>Received From</th>                                
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $productmateIndex = 0;
                                $decodedData = !empty($dataGrid->data) ? json_decode($dataGrid->data, true) : []; 
                            @endphp
                            @if (!empty($decodedData) && is_array($decodedData))
                                @foreach ($decodedData as $index => $Prodmaterial)
                                    <tr>
                                        <td>{{ ++$productmateIndex }}</td>
                                        <td>{{ array_key_exists('product_name_ca', $Prodmaterial) ? $Prodmaterial['product_name_ca'] : '' }}</td>
                                        <td>{{ Helpers::getdateFormat($Prodmaterial['batch_no_pmd_ca']) ?? 'NA' }}</td>                                            
                                        <td>{{ array_key_exists('batch_size_pmd_ca', $Prodmaterial) ? $Prodmaterial['batch_size_pmd_ca'] : '' }}</td>
                                        <td>{{ array_key_exists('pack_profile_pmd_ca', $Prodmaterial) ? $Prodmaterial['pack_profile_pmd_ca'] : '' }}</td>                                        
                                    </tr>
                                @endforeach                            
                            @endif                  
                        </tbody>                       
                    </table>
                </div>                
            </div>
            <div class="block">
                <div class="border-table">
                    <table>                            
                        <thead>                                
                            <tr class="table_bg" style="text-align: center; vertical-align: middle; padding: 20px;">
                                <th>S.No.</th>                                
                                <th>Qty.</th>
                                <th>Batch No./ Company Name</th>
                                <th>Mfg. Date</th>
                                <th>Exp. Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $productmateIndex = 0;
                                $decodedData = !empty($dataGrid->data) ? json_decode($dataGrid->data, true) : []; 
                            @endphp
                            @if (!empty($decodedData) && is_array($decodedData))
                                @foreach ($decodedData as $index => $Prodmaterial)
                                    <tr>
                                        <td>{{ ++$productmateIndex }}</td>                                        
                                        <td>{{ array_key_exists('released_quantity_pmd_ca', $Prodmaterial) ? $Prodmaterial['released_quantity_pmd_ca'] : '' }}</td>
                                        <td>{{ array_key_exists('remarks_ca', $Prodmaterial) ? $Prodmaterial['remarks_ca'] : '' }}</td>
                                        <td>{{ Helpers::getdateFormat($Prodmaterial['mfg_date_pmd_ca']) ?? 'NA' }}</td>
                                        <td>{{ Helpers::getdateFormat($Prodmaterial['expiry_date_pmd_ca']) ?? 'NA' }}</td>
                                    </tr>
                                @endforeach                            
                            @endif                  
                        </tbody>                       
                    </table>
                </div>
            </div>           

            <div class="block">
                <div class="block-head">
                    Details of Chemicals and Reagents:
                </div>
                <div class="border-table">
                    <table>                            
                        <thead>                                
                            <tr class="table_bg" style="text-align: center; vertical-align: middle; padding: 20px;">
                                <th>S.No.</th>
                                <th>Name of Chemicals/ Reagents</th>
                                <th>Make</th>
                                <th>Batch No./ Lot No.</th>
                                <th>Mfg. Date</th>
                                <th>Exp. Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $productmateIndex = 0;
                                $decodedData1 = !empty($dataGrid2->data) ? json_decode($dataGrid2->data, true) : [];
                            @endphp        
                            @if (!empty($decodedData1) && is_array($decodedData1))
                                @foreach ($decodedData1 as $index => $Prodmaterial)
                                    <tr>
                                        <td>{{ ++$productmateIndex }}</td>
                                        <td>{{ array_key_exists('names_rrv', $Prodmaterial) ? $Prodmaterial['names_rrv'] : '' }}</td>
                                        <td>{{ array_key_exists('department_rrv', $Prodmaterial) ? $Prodmaterial['department_rrv'] : '' }}</td>
                                        <td>{{ array_key_exists('sign_rrv', $Prodmaterial) ? $Prodmaterial['sign_rrv'] : '' }}</td>        
                                        <td>{{ Helpers::getdateFormat($Prodmaterial['mfg_date_pmd']) ?? 'NA' }}</td>
                                        <td>{{ Helpers::getdateFormat($Prodmaterial['expiry_date_pmd']) ?? 'NA' }}</td>
                                    </tr>
                                @endforeach
                            @endif                  
                        </tbody>                       
                    </table>
                </div>
            </div>

            <div class="block">
                <div class="block-head">
                    Details of Instruments Used:
                </div>
                <div class="border-table">
                    <table>                            
                        <thead>                                
                            <tr class="table_bg" style="text-align: center; vertical-align: middle; padding: 20px;">
                                <th>S.No.</th>
                                <th>Name of Instrument</th>
                                <th>Instrument ID</th>
                                <th>Calibration On</th>
                                <th>Calibration Due</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $productmateIndex = 0;
                                $decodedData2 = !empty($dataGrid3->data) ? json_decode($dataGrid3->data, true) : [];
                            @endphp        
                            @if (!empty($decodedData2) && is_array($decodedData2))
                                @foreach ($decodedData2 as $index => $Prodmaterial)
                                    <tr>
                                        <td>{{ ++$productmateIndex }}</td>
                                        <td>{{ array_key_exists('names_instrument', $Prodmaterial) ? $Prodmaterial['names_instrument'] : '' }}</td>
                                        <td>{{ array_key_exists('instrument_id', $Prodmaterial) ? $Prodmaterial['instrument_id'] : '' }}</td>
                                        <td>{{ Helpers::getdateFormat($Prodmaterial['callobration_on_date']) ?? 'NA' }}</td>
                                        <td>{{ Helpers::getdateFormat($Prodmaterial['callobration_due_date']) ?? 'NA' }}</td>
                                    </tr>
                                @endforeach   
                            @endif                  
                        </tbody>                       
                    </table>
                </div>
            </div>

            <div class="block">
                <div class="block-head">
                    Assay Test Results:
                </div> 
                <div class="border-table">
                    <table>                            
                        <thead>                                
                            <tr class="table_bg" style="text-align: center; vertical-align: middle; padding: 20px;">
                                <th>S.No.</th>
                                <th>Name of Sample</th>
                                <th>Result (%)</th>
                                <th>Limit (%)</th>
                                <th>Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $productmateIndex = 0;
                                $decodedData3 = !empty($dataGrid4->data) ? json_decode($dataGrid4->data, true) : [];
                            @endphp
        
                            @if (!empty($decodedData3) && is_array($decodedData3))
                                @foreach ($decodedData3 as $index => $Prodmaterial)
                                    <tr>
                                        <td>{{ ++$productmateIndex }}</td>
                                        <td>{{ array_key_exists('names_of_sample', $Prodmaterial) ? $Prodmaterial['names_of_sample'] : '' }}</td>
                                        <td>{{ array_key_exists('result', $Prodmaterial) ? $Prodmaterial['result'] : '' }}</td>
                                        <td>{{ array_key_exists('limit', $Prodmaterial) ? $Prodmaterial['limit'] : '' }}</td>
                                        <td>{{ array_key_exists('remarks', $Prodmaterial) ? $Prodmaterial['remarks'] : '' }}</td>
                                    </tr>
                                @endforeach                           
                            @endif                                                    
                        </tbody>                       
                    </table>                    
                </div>
            </div>

            <div class="block">
                <p>
                    <strong>Conclusion:</strong>
                    @if ($data->conclusion_assay)
                        {{ $data->conclusion_assay }}
                    @else
                        Not Applicable
                    @endif
                </p>
            </div>
            <br>
            <div>
                <table>
                    <tr>
                        <td class="w-50" style="padding-left: 50px">
                            <strong>Analyst Name <br>
                                    (Designation)
                            </strong> <br>
                            {{ Auth::user()->name }}
                        </td>
                        <td class="w-50" style="padding-left: 100px">
                            <strong>Reviewer name (1)<br>
                                (Designation)
                            </strong> <br>
                            {{ Auth::user()->name }}
                        </td>
                    </tr>
                    <tr>
                        <td class="w-50" style="padding-left: 50px">
                            <strong>Reviewer name (2)<br>
                                (Designation)
                            </strong> <br> 
                            {{ Auth::user()->name }}
                        </td>
                        <td class="w-50" style="padding-left: 100px">
                            <strong>Approver Name (HOD)<br>
                                (Designation)
                            </strong> <br>
                            {{ Auth::user()->name }}
                        </td>
                    </tr>
                </table>

            </div>
            
            
        </div>
    </div>

</body>

</html>
