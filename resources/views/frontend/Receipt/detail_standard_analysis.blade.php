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
                    <strong>Title:</strong>  {{$equipment->objective}} – Related Substances Test Analysis Report
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
                <p><strong>Objective:</strong> To Verify Assay Test method of {{$equipment->objective}}.</p>                
                <p><strong>Background:</strong> {{$equipment->background}}</p>
                <p><strong>Method:</strong> As per Annexure-1  {{ $equipment->method}}</p>
            </div>
            <div class="block">
                <div class="block-head">
                Details of Standards and Samples
                </div>

            <div>
                <table class="table table-bordered" style="width: 100%; border-collapse: collapse; border: 1px solid black;">
                    <thead>
                        <tr class="table_bg" style="border: 1px solid black;">
                            <th style="border: 1px solid black;">Row #</th>
                            <th style="border: 1px solid black;">Reg. No.</th>
                            <th style="border: 1px solid black;">Date</th>
                            <th style="border: 1px solid black;">Name of Standards/Samples</th>
                            <th style="border: 1px solid black;">Qty.</th>
                            <th style="border: 1px solid black;">Batch No./Company Name</th>
                            <th style="border: 1px solid black;">Mfg. Date</th>
                            <th style="border: 1px solid black;">Exp. Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!empty($Details_of_Standards) && !empty($Details_of_Standards->data) && is_array($Details_of_Standards->data))
                            @foreach ($Details_of_Standards->data as $index => $sample)
                                <tr style="border: 1px solid black;">
                                    <td style="border: 1px solid black;">{{ $index + 1 }}</td>
                                    <td style="border: 1px solid black;">{{ $sample['reg_no'] }}</td>
                                    <td style="border: 1px solid black;">{{ $sample['date'] }}</td>
                                    <td style="border: 1px solid black;">{{ $sample['name'] }}</td>
                                    <td style="border: 1px solid black;">{{ $sample['qty'] }}</td>
                                    <td style="border: 1px solid black;">{{ $sample['batch_company'] }}</td>
                                    <td style="border: 1px solid black;">{{ $sample['mfg_date'] }}</td>
                                    <td style="border: 1px solid black;">{{ $sample['exp_date'] }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr style="border: 1px solid black;">
                                <td colspan="8" style="border: 1px solid black; text-align: center;">No data found</td>
                            </tr>
                        @endif
                    </tbody>
                </table>

            </div>
            <br>
            <div>

                <div class="block-head">
                Details of Chemicals and Reagents:
                </div>


                <table class="table table-bordered" style="width: 100%; border-collapse: collapse; border: 1px solid black;">
                    <thead>
                        <tr class="table_bg" style="border: 1px solid black;">
                            <th style="border: 1px solid black;">Row #</th>
                            <th style="border: 1px solid black;">Name of Chemicals/ Reagents</th>
                            <th style="border: 1px solid black;">Make</th>
                            <th style="border: 1px solid black;">Batch No./ Lot No</th>
                            <th style="border: 1px solid black;">Mfg. Date</th>
                            <th style="border: 1px solid black;">Exp. Date</th>
                        </tr>
                    </thead>
                    <tbody>
                   

                            @if (!empty($Details_of_Chemicals) && !empty($Details_of_Chemicals->data) && is_array($Details_of_Chemicals->data))
                            @foreach ($Details_of_Chemicals->data as $index => $sample)
                                <tr style="border: 1px solid black;">
                                    <td style="border: 1px solid black;">{{ $index + 1 }}</td>
                                    <td style="border: 1px solid black;">{{ $sample['name'] }}</td>
                                    <td style="border: 1px solid black;">{{ $sample['make'] }}</td>
                                    <td style="border: 1px solid black;">{{ $sample['batch_lot_no'] }}</td>
                                    <td style="border: 1px solid black;">{{ $sample['mfg_date'] }}</td>
                                    <td style="border: 1px solid black;">{{ $sample['exp_date'] }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr style="border: 1px solid black;">
                                <td colspan="6" style="border: 1px solid black; text-align: center;">No data found</td>
                            </tr>
                        @endif
                    </tbody>
                </table>

                </div>


                <br>
            <div>

                <div class="block-head">
                Details of Instruments Used:
                </div>


                <table class="table table-bordered" style="width: 100%; border-collapse: collapse; border: 1px solid black;">
                    <thead>
                        <tr class="table_bg" style="border: 1px solid black;">
                            <th style="border: 1px solid black;">Row #</th>
                            <th style="border: 1px solid black;">Name of Instrument</th>
                            <th style="border: 1px solid black;">Instrument ID</th>
                            <th style="border: 1px solid black;">Calibration On</th>
                            <th style="border: 1px solid black;">Calibration Due</th>
                          
                        </tr>
                    </thead>
                    <tbody>
                            @if (!empty($Details_of_Instruments) && !empty($Details_of_Instruments->data) && is_array($Details_of_Instruments->data))
                            @foreach ($Details_of_Instruments->data as $index => $sample)
                                <tr style="border: 1px solid black;">
                                    <td style="border: 1px solid black;">{{ $index + 1 }}</td>
                                    <td style="border: 1px solid black;">{{ $sample['name'] }}</td>
                                    <td style="border: 1px solid black;">{{ $sample['id'] }}</td>
                                    <td style="border: 1px solid black;">{{ $sample['calibration_on'] }}</td>
                                    <td style="border: 1px solid black;">{{ $sample['calibration_due'] }}</td>
                                 
                                </tr>
                            @endforeach
                        @else
                            <tr style="border: 1px solid black;">
                                <td colspan="5" style="border: 1px solid black; text-align: center;">No data found</td>
                            </tr>
                        @endif
                    </tbody>
                </table>

                </div>




                <br>
            

                <div class="block-head">
                Related Substances Test Results:
                </div>


                <table class="table table-bordered" style="width: 100%; border-collapse: collapse; border: 1px solid black;">
                    <thead>
                        <tr class="table_bg" style="border: 1px solid black;">
                            <th style="border: 1px solid black;">Row #</th>
                            <th style="border: 1px solid black;">Sample Name/Batch No</th>
                            <th style="border: 1px solid black;">Relative Retention Time</th>
                            <th style="border: 1px solid black;">Name of Impurities</th>
                            <th style="border: 1px solid black;">Result (%)</th>
                            <th style="border: 1px solid black;">Limit (%)</th>
                            <th style="border: 1px solid black;">Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                            @if (!empty($Details_of_Related_Substances) && !empty($Details_of_Related_Substances->data) && is_array($Details_of_Related_Substances->data))
                            @foreach ($Details_of_Related_Substances->data as $index => $sample)
                                <tr style="border: 1px solid black;">
                                    <td style="border: 1px solid black;">{{ $index + 1 }}</td>
                                    <td style="border: 1px solid black;">{{ $sample['sample_name'] }}</td>
                                    <td style="border: 1px solid black;">{{ $sample['relative_retention_time'] }}</td>
                                    <td style="border: 1px solid black;">{{ $sample['impurities'] }}</td>
                                    <td style="border: 1px solid black;">{{ $sample['result'] }}</td>
                                    <td style="border: 1px solid black;">{{ $sample['limit'] }}</td>
                                    <td style="border: 1px solid black;">{{ $sample['remarks'] }}</td>
                                   
                                </tr>
                            @endforeach
                        @else
                            <tr style="border: 1px solid black;">
                                <td colspan="7" style="border: 1px solid black; text-align: center;">No data found</td>
                            </tr>
                        @endif
                    </tbody>
                  
                </table>
             
           </div>


           <div class="block">
                <p>
                    <strong>Conclusion:</strong>
                    <!-- @if ($data->conclusion_assay)
                        {{ $data->conclusion_assay }}
                    @else
                        Not Applicable
                    @endif -->
                     Related Substances Test Results complies for the Batch (#ABCD)
                </p>
            </div>

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