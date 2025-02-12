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
        border: 1px solid black;
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
                    Activity Log
                </td>
                <td class="w-30">
                    <div class="logo">
                        <img src="https://www.cphi-online.com/Medicef%20Logo-comp306798.jpg" alt="" class="w-50">
                    </div>
                </td>
            </tr>
        </table>
        <table>
            <tr>
                <td class="w-30">
                    <strong>Activity Log No.</strong>
                </td>
                <td class="w-40">
                    {{ Helpers::getDivisionName($data->division_id) }}/CM/{{ $data->created_at->format('Y') }}/{{ $data->record ? str_pad($data->record, 4, '0', STR_PAD_LEFT) : '' }}
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
                <div class="block-head">Activity Log</div>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tbody>
                            <!-- Initiate Calibration By and On -->
                            <tr>
                                <td>
                                    <strong style="color: #4274da">Initiate Calibration By:</strong><br>
                                    {{ $calibration->Initiate_Calibration_by }}
                                </td>
                                <td>
                                    <strong style="color: #4274da">Initiate Calibration On:</strong><br>
                                    @php
                                        $initiateTime = $calibration->Initiate_Calibration_on;
                                        $timeArray = explode(' | ', $initiateTime);
                                        $timeInIST = $timeArray[0] ?? 'No IST Time Available';
                                        $timeInGMT = $timeArray[1] ?? 'No GMT Time Available';
                                        $isIndia = auth()->user()->timezone === 'Asia/Kolkata';
                                        echo $isIndia ? $timeInIST : $timeInGMT;
                                    @endphp
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <strong style="color: #4274da">Initiate Calibration Comments:</strong><br>
                                    {{ $calibration->Initiate_Calibration_comments ?? 'Not Applicable' }}
                                </td>
                            </tr>
    
                            <!-- Within Limits By and On -->
                            <tr>
                                <td>
                                    <strong style="color: #4274da">Within Limits By:</strong><br>
                                    {{ $calibration->Within_Limits_by }}
                                </td>
                                <td>
                                    <strong style="color: #4274da">Within Limits On:</strong><br>
                                    @php
                                        $withinLimitsTime = $calibration->Within_Limits_on;
                                        $timeArray = explode(' | ', $withinLimitsTime);
                                        $timeInIST = $timeArray[0] ?? 'No IST Time Available';
                                        $timeInGMT = $timeArray[1] ?? 'No GMT Time Available';
                                        $isIndia = auth()->user()->timezone === 'Asia/Kolkata';
                                        echo $isIndia ? $timeInIST : $timeInGMT;
                                    @endphp
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <strong style="color: #4274da">Within Limits Comment:</strong><br>
                                    {{ $calibration->Within_Limits_comment ?? 'Not Applicable' }}
                                </td>
                            </tr>
    
                            <!-- Out of Limits By and On -->
                            <tr>
                                <td>
                                    <strong style="color: #4274da">Out of Limits By:</strong><br>
                                    {{ $calibration->Out_of_Limits_by }}
                                </td>
                                <td>
                                    <strong style="color: #4274da">Out of Limits On:</strong><br>
                                    @php
                                        $outOfLimitsTime = $calibration->Out_of_Limits_on;
                                        $timeArray = explode(' | ', $outOfLimitsTime);
                                        $timeInIST = $timeArray[0] ?? 'No IST Time Available';
                                        $timeInGMT = $timeArray[1] ?? 'No GMT Time Available';
                                        $isIndia = auth()->user()->timezone === 'Asia/Kolkata';
                                        echo $isIndia ? $timeInIST : $timeInGMT;
                                    @endphp
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <strong style="color: #4274da">Out of Limits Comment:</strong><br>
                                    {{ $calibration->Out_of_Limits_comment ?? 'Not Applicable' }}
                                </td>
                            </tr>
    
                            <!-- Complete Actions By and On -->
                            <tr>
                                <td>
                                    <strong style="color: #4274da">Complete Actions By:</strong><br>
                                    {{ $calibration->Complete_Actions_by }}
                                </td>
                                <td>
                                    <strong style="color: #4274da">Complete Actions On:</strong><br>
                                    @php
                                        $completeActionsTime = $calibration->Complete_Actions_on;
                                        $timeArray = explode(' | ', $completeActionsTime);
                                        $timeInIST = $timeArray[0] ?? 'No IST Time Available';
                                        $timeInGMT = $timeArray[1] ?? 'No GMT Time Available';
                                        $isIndia = auth()->user()->timezone === 'Asia/Kolkata';
                                        echo $isIndia ? $timeInIST : $timeInGMT;
                                    @endphp
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <strong style="color: #4274da">Complete Actions Comment:</strong><br>
                                    {{ $calibration->Complete_Actions_comment ?? 'Not Applicable' }}
                                </td>
                            </tr>
    
                            <!-- Additional Work Required By and On -->
                            <tr>
                                <td>
                                    <strong style="color: #4274da">Additional Work Required By:</strong><br>
                                    {{ $calibration->Additional_Work_Required_by }}
                                </td>
                                <td>
                                    <strong style="color: #4274da">Additional Work Required On:</strong><br>
                                    @php
                                        $additionalWorkTime = $calibration->Additional_Work_Required_on;
                                        $timeArray = explode(' | ', $additionalWorkTime);
                                        $timeInIST = $timeArray[0] ?? 'No IST Time Available';
                                        $timeInGMT = $timeArray[1] ?? 'No GMT Time Available';
                                        $isIndia = auth()->user()->timezone === 'Asia/Kolkata';
                                        echo $isIndia ? $timeInIST : $timeInGMT;
                                    @endphp
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <strong style="color: #4274da">Additional Work Required Comment:</strong><br>
                                    {{ $calibration->Additional_Work_Required_comment ?? 'Not Applicable' }}
                                </td>
                            </tr>
    
                            <!-- QA Approval By and On -->
                            <tr>
                                <td>
                                    <strong style="color: #4274da">QA Approval By:</strong><br>
                                    {{ $calibration->QA_Approval_by }}
                                </td>
                                <td>
                                    <strong style="color: #4274da">QA Approval On:</strong><br>
                                    @php
                                        $qaApprovalTime = $calibration->QA_Approval_on;
                                        $timeArray = explode(' | ', $qaApprovalTime);
                                        $timeInIST = $timeArray[0] ?? 'No IST Time Available';
                                        $timeInGMT = $timeArray[1] ?? 'No GMT Time Available';
                                        $isIndia = auth()->user()->timezone === 'Asia/Kolkata';
                                        echo $isIndia ? $timeInIST : $timeInGMT;
                                    @endphp
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <strong style="color: #4274da">QA Approval Comment:</strong><br>
                                    {{ $calibration->QA_Approval_comment ?? 'Not Applicable' }}
                                </td>
                            </tr>
    
                            <!-- Cancel By and On -->
                            <tr>
                                <td>
                                    <strong style="color: #4274da">Cancel By:</strong><br>
                                    {{ $calibration->Cancel_by }}
                                </td>
                                <td>
                                    <strong style="color: #4274da">Cancel On:</strong><br>
                                    @php
                                        $cancelTime = $calibration->Cancel_on;
                                        $timeArray = explode(' | ', $cancelTime);
                                        $timeInIST = $timeArray[0] ?? 'No IST Time Available';
                                        $timeInGMT = $timeArray[1] ?? 'No GMT Time Available';
                                        $isIndia = auth()->user()->timezone === 'Asia/Kolkata';
                                        echo $isIndia ? $timeInIST : $timeInGMT;
                                    @endphp
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <strong style="color: #4274da">Cancel Comment:</strong><br>
                                    {{ $calibration->Cancel_comment ?? 'Not Applicable' }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
</body>

</html>
