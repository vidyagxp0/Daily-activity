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
                                    <strong style="color: #4274da">Schedule Audit By:</strong><br>
                                    {{ $data->audit_schedule_by }}
                                </td>
                                <td>
                                    <strong style="color: #4274da">Audit Schedule On:</strong><br>
                                    @php
                                        $initiateTime = $data->audit_schedule_on;
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
                                    <strong style="color: #4274da">Comments:</strong><br>
                                    {{ $data->comment ?? 'Not Applicable' }}
                                </td>
                            </tr>
    
                            <!-- Within Limits By and On -->
                            <tr>
                                <td>
                                    <strong style="color: #4274da">Completed Audit Preparation By::</strong><br>
                                    {{$data->audit_preparation_completed_by }}
                                </td>
                                <td>
                                    <strong style="color: #4274da">Completed Audit Preparation On</strong><br>
                                    @php
                                        $withinLimitsTime = $data->audit_preparation_completed_on;
                                        $timeArray = explode(' | ', $withinLimitsTime);
                                        $timeInIST = isset($timeArray[0])
                                            ? $timeArray[0]
                                            : 'No IST Time Available';
                                        $timeInGMT = isset($timeArray[1])
                                            ? $timeArray[1]
                                            : 'No GMT Time Available';
                                        $isIndia = auth()->user()->timezone === 'Asia/Kolkata';
                                        echo $isIndia ? $timeInIST : $timeInGMT;
                                    @endphp
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <strong style="color: #4274da">Comment:</strong><br>
                                    {{ $data->audit_preparation_comment ?? 'Not Applicable' }}
                                </td>
                            </tr>
    
                          
                            <tr>
                                <td>
                                    <strong>Rejected By:</strong><br>
                                    {{ $data->rejected_by }}
                                </td>
                                <td>
                                    <strong>Rejected On:</strong><br>
                                    @php
                                        $outOfLimitsTime = $data->rejected_on;
                                        $timeArray = explode(' | ', $outOfLimitsTime);
                                        $timeInIST = isset($timeArray[0])
                                            ? $timeArray[0]
                                            : 'No IST Time Available';
                                        $timeInGMT = isset($timeArray[1])
                                            ? $timeArray[1]
                                            : 'No GMT Time Available';
                                        $isIndia = auth()->user()->timezone === 'Asia/Kolkata';
                                        echo $isIndia ? $timeInIST : $timeInGMT;
                                    @endphp
                                </td>
                            </tr>

                            <tr>
                                <td colspan="2">
                                    <strong>Comment:</strong><br>
                                    {{  $data->comment_rejected_comment  ?? 'Not Applicable' }}
                                </td>
                            </tr>
    
                            <tr>
                                <td>
                                    <strong>Cancelled By:</strong><br>
                                    {{ $data->cancelled_by }}
                                </td>
                                <td>
                                    <strong>Cancelled On:</strong><br>
                                    @php
                                        $completeActionsTime = $data->cancelled_on;
                                        $timeArray = explode(' | ', $completeActionsTime);
                                        $timeInIST = isset($timeArray[0])
                                            ? $timeArray[0]
                                            : 'No IST Time Available';
                                        $timeInGMT = isset($timeArray[1])
                                            ? $timeArray[1]
                                            : 'No GMT Time Available';
                                        $isIndia = auth()->user()->timezone === 'Asia/Kolkata';
                                        echo $isIndia ? $timeInIST : $timeInGMT;
                                    @endphp
                                </td>
                            </tr>

                            
                            <tr>
                                <td colspan="2">
                                    <strong> Comment:</strong><br>
                                    {{ $data->comment_cancelled_comment ?? 'Not Applicable' }}
                                </td>
                            </tr>
    
                            <tr>
                                <td>
                                    <strong>No CAPA Required By:</strong><br>
                                    {{ $data->audit_response_completed_by }}
                                </td>
                                <td>
                                    <strong>No CAPA Required On:</strong><br>
                                    @php
                                        $additionalWorkTime =
                                            $data->audit_response_completed_on;
                                        $timeArray = explode(' | ', $additionalWorkTime);
                                        $timeInIST = isset($timeArray[0])
                                            ? $timeArray[0]
                                            : 'No IST Time Available';
                                        $timeInGMT = isset($timeArray[1])
                                            ? $timeArray[1]
                                            : 'No GMT Time Available';
                                        $isIndia = auth()->user()->timezone === 'Asia/Kolkata';
                                        echo $isIndia ? $timeInIST : $timeInGMT;
                                    @endphp
                                </td>
                            </tr>

                            
                            <tr>
                                <td colspan="2">
                                    <strong>Additional Work Required Comment:</strong><br>
                                    {{ $data->audit_responce_comment ?? 'Not Applicable' }}
                                </td>
                            </tr>
    
                            
                            <tr>
                                <td>
                                    <strong>Issue Report
                                        By:</strong><br>
                                    {{ $data->audit_mgr_more_info_reqd_by }}
                                </td>
                                <td>
                                    <strong>Issue Report
                                        On:</strong><br>
                                    @php
                                        $qaApprovalTime =$data->audit_mgr_more_info_reqd_on;
                                        $timeArray = explode(' | ', $qaApprovalTime);
                                        $timeInIST = isset($timeArray[0])
                                            ? $timeArray[0]
                                            : 'No IST Time Available';
                                        $timeInGMT = isset($timeArray[1])
                                            ? $timeArray[1]
                                            : 'No GMT Time Available';
                                        $isIndia = auth()->user()->timezone === 'Asia/Kolkata';
                                        echo $isIndia ? $timeInIST : $timeInGMT;
                                    @endphp
                                </td>
                            </tr>

                            
                            <tr>
                                <td>
                                    <strong>CAPA Plan Proposed
                                        By:</strong><br>
                                    {{ $data->audit_observation_submitted_by }}
                                </td>
                                <td>
                                    <strong>Audit Observation Submitted On:</strong><br>
                                    @php
                                        $cancelTime = $data->audit_observation_submitted_on;
                                        $timeArray = explode(' | ', $cancelTime);
                                        $timeInIST = isset($timeArray[0])
                                            ? $timeArray[0]
                                            : 'No IST Time Available';
                                        $timeInGMT = isset($timeArray[1])
                                            ? $timeArray[1]
                                            : 'No GMT Time Available';
                                        $isIndia = auth()->user()->timezone === 'Asia/Kolkata';
                                        echo $isIndia ? $timeInIST : $timeInGMT;
                                    @endphp
                                </td>
                            </tr>

                            
                            <tr>
                                <td colspan="2">
                                    <strong>Comment:</strong><br>
                                    {{ $data->capa_execution_in_progress_comment ?? 'Not Applicable' }}
                                </td>

                            </tr>

                            <tr>
                                <td>
                                    <strong>Audit Lead More Info Reqd By:</strong><br>
                                    {{ $data->audit_lead_more_info_reqd_by }}
                                </td>
                                <td>
                                    <strong>Audit Observation Submitted On:</strong><br>
                                    @php
                                        $cancelTime = $data->audit_lead_more_info_reqd_on;
                                        $timeArray = explode(' | ', $cancelTime);
                                        $timeInIST = isset($timeArray[0])
                                            ? $timeArray[0]
                                            : 'No IST Time Available';
                                        $timeInGMT = isset($timeArray[1])
                                            ? $timeArray[1]
                                            : 'No GMT Time Available';
                                        $isIndia = auth()->user()->timezone === 'Asia/Kolkata';
                                        echo $isIndia ? $timeInIST : $timeInGMT;
                                    @endphp
                                </td>
                            </tr>
                            
                            <tr>
                                <td colspan="2">
                                    <strong>Comment:</strong><br>
                                    {{ $data->comment_closed_done_by_comment ?? 'Not Applicable' }}
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
