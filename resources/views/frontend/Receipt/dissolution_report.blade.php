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
                    <strong>Title:</strong> {{ $data->objective_dissolution }} – Dissolution Test Analysis Report
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
                    <p><strong>Objective:</strong> To Verify Dissolution Test method of {{$data->objective_dissolution}}.</p>                
                    <p><strong>Background:</strong> {{$data->background_dissolution}}</p>
                    <p><strong>Method:</strong> As per Annexure-1  {{$data->method_dissolution}}</p>
               </div>
                <div class="block">
                    <div class="block-head">
                        Details of Standards and Samples:
                    </div>
                    
                    <!-- Part 1: First Half of the Table -->
                    <div class="border-table">
                        <table>
                            <tr class="table_bg">
                                <th class="w-10">S.No</th>
                                <th class="w-25">Reg. No.</th>
                                <th class="w-25">Date</th>
                                <th class="w-25">Name of Standards/Samples</th>
                                <th class="w-25">Received From</th>
                            </tr>
                            @php
                                $productmateIndex = 0;
                                $dissolutionGrid1 = !empty($dissolutionGrid->data) ? json_decode($dissolutionGrid->data, true) : [];
                            @endphp    
                            @if (!empty($dissolutionGrid1) && is_array($dissolutionGrid1))
                                @foreach ($dissolutionGrid1 as $index => $Prodmateriyal)
                                    <tr>
                                        <td>{{ ++$productmateIndex }}</td>
                                        <td>
                                            {{ array_key_exists('product_name_ca', $Prodmateriyal) ? $Prodmateriyal['product_name_ca'] : '' }}
                                        </td>  
                                          
                                        <td>
                                            {{ $Prodmateriyal['batch_no_pmd_ca'] 
                                                ? \Carbon\Carbon::parse($Prodmateriyal['batch_no_pmd_ca'])->format('d-M-Y') 
                                                : '' }}
                                        </td>

                                        <td>
                                            {{ array_key_exists('batch_size_pmd_ca', $Prodmateriyal) ? $Prodmateriyal['batch_size_pmd_ca'] : '' }}
                                        </td>
                                        <td>
                                            {{ array_key_exists('pack_profile_pmd_ca', $Prodmateriyal) ? $Prodmateriyal['pack_profile_pmd_ca'] : '' }}
                                        </td>
                                        
                                        
                                    </tr>
                                @endforeach
                            @else
                                <tr>
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

                    <!-- Part 2: Second Half of the Table -->
                <div class="block">
                    <div class="border-table">
                        <table>
                            <tr class="table_bg">
                                <th class="w-10">S.No</th>
                                <th class="w-25">Qty.</th>
                                <th class="w-25">Batch No./Company Name</th>
                                <th class="w-25">Mfg. Date</th>
                                <th class="w-25">Exp. Date</th>
                            </tr> 
                            @php
                                $productmateIndex = 0;
                                $dissolutionGrid1 = !empty($dissolutionGrid->data) ? json_decode($dissolutionGrid->data, true) : [];
                            @endphp    
                            @if (!empty($dissolutionGrid1) && is_array($dissolutionGrid1))
                                @foreach ($dissolutionGrid1 as $index => $Prodmateriyal)
                                    <tr>
                                    <td>{{ ++$productmateIndex }}</td>
                                    <td>
                                            {{ array_key_exists('released_quantity_pmd_ca', $Prodmateriyal) ? $Prodmateriyal['released_quantity_pmd_ca'] : '' }}
                                        </td>
                                        <td>
                                            {{ array_key_exists('remarks_ca', $Prodmateriyal) ? $Prodmateriyal['remarks_ca'] : '' }}
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($Prodmateriyal['mfg_date_pmd_ca'])->format('d-M-Y') }}</td>

                                        <td>{{ \Carbon\Carbon::parse($Prodmateriyal['expiry_date_pmd_ca'])->format('d-M-Y') }}</td>

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
                         Details of Chemicals and Reagents:
                    </div>
                    <div class="border-table">
                        <table>
                            <tr class="table_bg">
                                <th class="w-10">S.No</th>
                                <th class="w-25">Name of Chemicals/Reagents</th>
                                <th class="w-25">Make</th>
                                <th class="w-25">Batch No./Lot No.</th>
                                <th class="w-25">Mfg. Date</th>
                                <th class="w-25">Exp. Date</th>

                            </tr>

                            @php
                                $productmateIndex = 0;
                                $dissolution2 = !empty($dissolutionGrid2->data) ? json_decode($dissolutionGrid2->data, true) : [];
                            @endphp

                            @if (!empty($dissolution2) && is_array($dissolution2))
                                 @foreach ($dissolution2 as $index => $Prodmateriyal)
                                    <tr>
                                        <td>{{ ++$productmateIndex }}</td>
                                        <td>
                                          {{ $Prodmateriyal['chemical_name'] ?? '' }}
                                        </td>
                                        <td>
                                            {{ $Prodmateriyal['make'] ?? '' }}
                                        </td>
                                        <td>
                                            {{ $Prodmateriyal['batch_lot_no'] ?? '' }}
                                        </td>
                                        <td>
                                            {{ $Prodmateriyal['mfg_date'] 
                                                ? \Carbon\Carbon::parse($Prodmateriyal['mfg_date'])->format('d-M-Y') 
                                                : '' }}
                                        </td>

                                        <td>
                                            {{ $Prodmateriyal['exp_date'] 
                                                ? \Carbon\Carbon::parse($Prodmateriyal['exp_date'])->format('d-M-Y') 
                                                : '' }}
                                        </td>

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
                                 </tr>
                            @endif
                        </table>
                    </div>
                </div>

                <div class="block">
                    <div class="block-head">
                       Details of Instruments Used:
                    </div>
                    <div class="border-table">
                        <table>
                            <tr class="table_bg">
                                <th class="w-10">S.No</th>
                                <th class="w-25">Name of Instrument</th>
                                <th class="w-25">Instrument ID</th>
                                <th class="w-25">Calibration On</th>
                                <th class="w-25">Calibration Due</th>
                            </tr>
                            @php
                                $productmateIndex = 0;
                                $dissolution_test = !empty($dissolutionGrid3->data) ? json_decode($dissolutionGrid3->data, true) : [];
                            @endphp

                            @if (!empty($dissolution_test) && is_array($dissolution_test))
                                @foreach ($dissolution_test as $index => $Prodmateriyal)
                                    <tr>
                                        <td>{{ ++$productmateIndex }}</td>
                                        <td>
                                           {{ $Prodmateriyal['instrument_name'] ?? '' }}
                                        </td>
                                        <td>
                                           {{ $Prodmateriyal['instrument_id'] ?? '' }}
                                        </td>

                                        <td>
                                            {{ $Prodmateriyal['calibration_on'] 
                                                ? \Carbon\Carbon::parse($Prodmateriyal['calibration_on'])->format('d-M-Y') 
                                                : '' }}
                                        </td>

                                        <td>
                                            {{ $Prodmateriyal['calibration_due'] 
                                                ? \Carbon\Carbon::parse($Prodmateriyal['calibration_due'])->format('d-M-Y') 
                                                : '' }}
                                        </td>

                                    </tr>
                                @endforeach
                            @else
                                <tr>
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
                        Dissolution Test Results:
                    </div>
                    <div class="border-table">
                        <table>
                            <!-- <tr class="table_bg">
                                <th class="w-25">Details</th>
                                <th class="w-25">Information</th>
                            </tr> -->
                            @php
                                $dissolution_test1 = !empty($dissolutionGrid4->data) ? json_decode($dissolutionGrid4->data, true) : [];
                            @endphp

                            @if (!empty($dissolution_test1) && is_array($dissolution_test1))
                                @foreach ($dissolution_test1 as $index => $testData)
                                    <tr>
                                        <td><label for="batch_no_{{ $index }}"><strong>Batch No. / Company Name</strong></label></td>
                                        <td>{{ $testData['batch_no'] ?? '' }}</td>
                                    </tr>
                                    <tr>
                                        <td><label for="timepoint_{{ $index }}"><strong>Timepoint</strong></label></td>
                                        <td>{{ $testData['timepoint'] ?? '' }}</td>
                                    </tr>
                                    <tr>
                                        <td><label for="minimum_{{ $index }}"><strong>Minimum</strong></label></td>
                                        <td>{{ $testData['minimum'] ?? '' }}</td>
                                    </tr>
                                    <tr>
                                        <td><label for="maximum_{{ $index }}"><strong>Maximum</strong></label></td>
                                        <td>{{ $testData['maximum'] ?? '' }}</td>
                                    </tr>
                                    <tr>
                                        <td><label for="average_{{ $index }}"><strong>Average</strong></label></td>
                                        <td>{{ $testData['average'] ?? '' }}</td>
                                    </tr>
                                    <tr>
                                        <td><label for="remarks_{{ $index }}"><strong>Remarks</strong></label></td>
                                        <td>{{ $testData['remarks'] ?? '' }}</td>
                                    </tr>
                                    <tr>
                                        <td><label for="limit_percent_{{ $index }}"><strong>Limit (%)</strong></label></td>
                                        <td>{{ $testData['limit_percent'] ?? '' }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                          <strong>Conclusion:</strong> Dissolution Test Results complies for the Batch (#{{ $testData['batch_no'] ?? 'Unknown Batch' }}).
                                        </td>
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
                                </tr>
                            @endif
                        </table>
                    </div>
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
