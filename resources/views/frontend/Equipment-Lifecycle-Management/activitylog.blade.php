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
                    {{ Helpers::getDivisionName($data->division_id) }}/ELM/{{ $data->created_at->format('Y') }}/{{ $data->record ? str_pad($data->record, 4, '0', STR_PAD_LEFT) : '' }}
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
                            <tr>
                                <td>
                                    <strong>Submit By:</strong><br>
                                    {{ $data->submit_by }}
                                </td>
                                <td>
                                    <strong>Submit On:</strong><br>
                                    {{ $data->submit_on}}
                                    {{-- @php
                                        $initiateTime = $data->submit_on;
                                        $timeArray = explode(' | ', $initiateTime);
                                        $timeInIST = isset($timeArray[0])
                                            ? $timeArray[0]
                                            : 'No IST Time Available';
                                        $timeInGMT = isset($timeArray[1])
                                            ? $timeArray[1]
                                            : 'No GMT Time Available';
                                        $isIndia = auth()->user()->timezone === 'Asia/Kolkata';
                                        echo $isIndia ? $timeInIST : $timeInGMT;
                                    @endphp --}}
                                </td>
                            </tr>

                            <!-- Row for Submit Comments -->
                            <tr>
                                <td colspan="2">
                                    <strong>Submit Comments:</strong><br>
                                    {{ $data->submit_comment ?? 'Not Applicable' }}
                                </td>
                            </tr>

                            <!-- Add more rows for other data -->
                            <tr>
                                <td>
                                    <strong>Cancel By:</strong><br>
                                    {{ $data->cancel_By }}
                                </td>
                                <td>
                                    <strong>Cancel On:</strong><br>
                                    {{$data->cancel_On}}
                                    {{-- @php
                                        $withinLimitsTime = $data->cancel_On;
                                        $timeArray = explode(' | ', $withinLimitsTime);
                                        $timeInIST = isset($timeArray[0])
                                            ? $timeArray[0]
                                            : 'No IST Time Available';
                                        $timeInGMT = isset($timeArray[1])
                                            ? $timeArray[1]
                                            : 'No GMT Time Available';
                                        $isIndia = auth()->user()->timezone === 'Asia/Kolkata';
                                        echo $isIndia ? $timeInIST : $timeInGMT;
                                    @endphp --}}
                                </td>
                            </tr>

                            <tr>
                                <td colspan="2">
                                    <strong>Cancel Comment:</strong><br>
                                    {{ $data->cancel_comment ?? 'Not Applicable' }}
                                </td>
                            </tr>


                             <!-- Add more rows for other data -->
                             <tr>
                                <td>
                                    <strong>Supervisor Approval By:</strong><br>
                                    {{ $data->Supervisor_Approval_by }}
                                </td>
                                <td>
                                    <strong>Supervisor Approval On:</strong><br>
                                    {{$data->Supervisor_Approval_on}}
                                    {{-- @php
                                        $withinLimitsTime = $data->Supervisor_Approval_on;
                                        $timeArray = explode(' | ', $withinLimitsTime);
                                        $timeInIST = isset($timeArray[0])
                                            ? $timeArray[0]
                                            : 'No IST Time Available';
                                        $timeInGMT = isset($timeArray[1])
                                            ? $timeArray[1]
                                            : 'No GMT Time Available';
                                        $isIndia = auth()->user()->timezone === 'Asia/Kolkata';
                                        echo $isIndia ? $timeInIST : $timeInGMT;
                                    @endphp --}}
                                </td>
                            </tr>

                            <tr>
                                <td colspan="2">
                                    <strong>Supervisor Approval Comment:</strong><br>
                                    {{ $data->Supervisor_Approval_comment ?? 'Not Applicable' }}
                                </td>
                            </tr>


                             <!-- Add more rows for other data -->
                             <tr>
                                <td>
                                    <strong>More Information Required By:</strong><br>
                                    {{ $data->More_Info_by }}
                                </td>
                                <td>
                                    <strong>More Information Required On:</strong><br>
                                    {{$data->More_Info_on}}
                                    {{-- @php
                                        $withinLimitsTime = $data->More_Info_on;
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
                                </td> --}}
                            </tr>

                            <tr>
                                <td colspan="2">
                                    <strong>More Information Required Comment:</strong><br>
                                    {{ $data->More_Info_comment ?? 'Not Applicable' }}
                                </td>
                            </tr>


                              <!-- Add more rows for other data -->
                              <tr>
                                <td>
                                    <strong>Complete Qualification By:</strong><br>
                                    {{ $data->Complete_Qualification_by }}
                                </td>
                                <td>
                                    <strong>Complete Qualification On:</strong><br>
                                    {{$data->Complete_Qualification_on}}
                                    {{-- @php
                                        $withinLimitsTime = $data->Complete_Qualification_on;
                                        $timeArray = explode(' | ', $withinLimitsTime);
                                        $timeInIST = isset($timeArray[0])
                                            ? $timeArray[0]
                                            : 'No IST Time Available';
                                        $timeInGMT = isset($timeArray[1])
                                            ? $timeArray[1]
                                            : 'No GMT Time Available';
                                        $isIndia = auth()->user()->timezone === 'Asia/Kolkata';
                                        echo $isIndia ? $timeInIST : $timeInGMT;
                                    @endphp --}}
                                </td>
                            </tr>

                            <tr>
                                <td colspan="2">
                                    <strong>Complete Qualification Comment:</strong><br>
                                    {{ $data->Complete_Qualification_comment ?? 'Not Applicable' }}
                                </td>
                            </tr>

                             <!-- Add more rows for other data -->
                             <tr>
                                <td>
                                    <strong>Complete Training By:</strong><br>
                                    {{ $data->Complete_Training_by }}
                                </td>
                                <td>
                                    <strong>Complete Training On:</strong><br>
                                    {{ $data->Complete_Training_on}}
                                    {{-- @php
                                        $withinLimitsTime = $data->Complete_Training_on;
                                        $timeArray = explode(' | ', $withinLimitsTime);
                                        $timeInIST = isset($timeArray[0])
                                            ? $timeArray[0]
                                            : 'No IST Time Available';
                                        $timeInGMT = isset($timeArray[1])
                                            ? $timeArray[1]
                                            : 'No GMT Time Available';
                                        $isIndia = auth()->user()->timezone === 'Asia/Kolkata';
                                        echo $isIndia ? $timeInIST : $timeInGMT;
                                    @endphp --}}
                                </td>
                            </tr>

                            <tr>
                                <td colspan="2">
                                    <strong>Complete Training Comment:</strong><br>
                                    {{ $data->Complete_Training_comment ?? 'Not Applicable' }}
                                </td>
                            </tr>

                              <!-- Add more rows for other data -->
                              <tr>
                                <td>
                                    <strong>Request More Information By:</strong><br>
                                    {{ $data->More_Info_by_sec_by }}
                                </td>
                                <td>
                                    <strong>Request More Information On:</strong><br>
                                    {{ $data->More_Info_by_sec_on}}
                                    {{-- @php
                                        $withinLimitsTime = $data->More_Info_by_sec_on;
                                        $timeArray = explode(' | ', $withinLimitsTime);
                                        $timeInIST = isset($timeArray[0])
                                            ? $timeArray[0]
                                            : 'No IST Time Available';
                                        $timeInGMT = isset($timeArray[1])
                                            ? $timeArray[1]
                                            : 'No GMT Time Available';
                                        $isIndia = auth()->user()->timezone === 'Asia/Kolkata';
                                        echo $isIndia ? $timeInIST : $timeInGMT;
                                    @endphp --}}
                                </td>
                            </tr>

                            <tr>
                                <td colspan="2">
                                    <strong>Request More Information Comment:</strong><br>
                                    {{ $data->More_Info_by_sec_comment ?? 'Not Applicable' }}
                                </td>
                            </tr>


                             <!-- Add more rows for other data -->
                             <tr>
                                <td>
                                    <strong>QA Approval By:</strong><br>
                                    {{ $data->Take_Out_of_Service_by }}
                                </td>
                                <td>
                                    <strong>QA Approval On:</strong><br>
                                    {{$data->Take_Out_of_Service_on}}
                                    {{-- @php
                                        $withinLimitsTime = $data->Take_Out_of_Service_on;
                                        $timeArray = explode(' | ', $withinLimitsTime);
                                        $timeInIST = isset($timeArray[0])
                                            ? $timeArray[0]
                                            : 'No IST Time Available';
                                        $timeInGMT = isset($timeArray[1])
                                            ? $timeArray[1]
                                            : 'No GMT Time Available';
                                        $isIndia = auth()->user()->timezone === 'Asia/Kolkata';
                                        echo $isIndia ? $timeInIST : $timeInGMT;
                                    @endphp --}}
                                </td>
                            </tr>

                            <tr>
                                <td colspan="2">
                                    <strong>QA Approval Comment:</strong><br>
                                    {{ $data->Take_Out_of_Service_comment ?? 'Not Applicable' }}
                                </td>
                            </tr>

                             <!-- Add more rows for other data -->
                             <tr>
                                <td>
                                    <strong>Re-Qualification By:</strong><br>
                                    {{ $data->Re_Qualification_by }}
                                </td>
                                <td>
                                    <strong>Re-Qualification On:</strong><br>
                                    {{$data->Re_Qualification_on}}
                                    {{-- @php
                                        $withinLimitsTime = $data->Re_Qualification_on;
                                        $timeArray = explode(' | ', $withinLimitsTime);
                                        $timeInIST = isset($timeArray[0])
                                            ? $timeArray[0]
                                            : 'No IST Time Available';
                                        $timeInGMT = isset($timeArray[1])
                                            ? $timeArray[1]
                                            : 'No GMT Time Available';
                                        $isIndia = auth()->user()->timezone === 'Asia/Kolkata';
                                        echo $isIndia ? $timeInIST : $timeInGMT;
                                    @endphp --}}
                                </td>
                            </tr>

                            <tr>
                                <td colspan="2">
                                    <strong>Re-Qualification Comment:</strong><br>
                                    {{ $data->Re_Qualification_comment ?? 'Not Applicable' }}
                                </td>
                            </tr>

                              <!-- Add more rows for other data -->
                              <tr>
                                <td>
                                    <strong>Take Out of Service By:</strong><br>
                                    {{ $data->Forward_to_Storage_by }}
                                </td>
                                <td>
                                    <strong>Take Out of Service On:</strong><br>
                                    {{ $data->Forward_to_Storage_on}}
                                    {{-- @php
                                        $withinLimitsTime = $data->Forward_to_Storage_on;
                                        $timeArray = explode(' | ', $withinLimitsTime);
                                        $timeInIST = isset($timeArray[0])
                                            ? $timeArray[0]
                                            : 'No IST Time Available';
                                        $timeInGMT = isset($timeArray[1])
                                            ? $timeArray[1]
                                            : 'No GMT Time Available';
                                        $isIndia = auth()->user()->timezone === 'Asia/Kolkata';
                                        echo $isIndia ? $timeInIST : $timeInGMT;
                                    @endphp --}}
                                </td>
                            </tr>

                            <tr>
                                <td colspan="2">
                                    <strong>Take Out of Service Comment:</strong><br>
                                    {{ $data->Forward_to_Storage_comment ?? 'Not Applicable' }}
                                </td>
                            </tr>


                             <!-- Add more rows for other data -->
                             <tr>
                                <td>
                                    <strong>Forward to Storage By:</strong><br>
                                    {{ $data->Forward_to_Storage_by }}
                                </td>
                                <td>
                                    <strong>Forward to Storage On:</strong><br>
                                    {{$data->Forward_to_Storage_on}}
                                    {{-- @php
                                        $withinLimitsTime = $data->Forward_to_Storage_on;
                                        $timeArray = explode(' | ', $withinLimitsTime);
                                        $timeInIST = isset($timeArray[0])
                                            ? $timeArray[0]
                                            : 'No IST Time Available';
                                        $timeInGMT = isset($timeArray[1])
                                            ? $timeArray[1]
                                            : 'No GMT Time Available';
                                        $isIndia = auth()->user()->timezone === 'Asia/Kolkata';
                                        echo $isIndia ? $timeInIST : $timeInGMT;
                                    @endphp --}}
                                </td>
                            </tr>

                            <tr>
                                <td colspan="2">
                                    <strong>Forward to Storage Comment:</strong><br>
                                    {{ $data->Forward_to_Storage_comment ?? 'Not Applicable' }}
                                </td>
                            </tr>


                              <!-- Add more rows for other data -->
                              <tr>
                                <td>
                                    <strong>Re-Activate By:</strong><br>
                                    {{ $data->Re_Active_by }}
                                </td>
                                <td>
                                    <strong>Re-Activate On:</strong><br>
                                    {{$data->Re_Active_on}}
                                    {{-- @php
                                        $withinLimitsTime = $data->Re_Active_on;
                                        $timeArray = explode(' | ', $withinLimitsTime);
                                        $timeInIST = isset($timeArray[0])
                                            ? $timeArray[0]
                                            : 'No IST Time Available';
                                        $timeInGMT = isset($timeArray[1])
                                            ? $timeArray[1]
                                            : 'No GMT Time Available';
                                        $isIndia = auth()->user()->timezone === 'Asia/Kolkata';
                                        echo $isIndia ? $timeInIST : $timeInGMT;
                                    @endphp --}}
                                </td>
                            </tr>

                            <tr>
                                <td colspan="2">
                                    <strong>Re-Activate Comment:</strong><br>
                                    {{ $data->Re_Active_comment ?? 'Not Applicable' }}
                                </td>
                            </tr>


                              <!-- Add more rows for other data -->
                              <tr>
                                <td>
                                    <strong>Re-Qualification By:</strong><br>
                                    {{ $data->Re_Qualification_by_sec }}
                                </td>
                                <td>
                                    <strong>Re-Qualification On:</strong><br>
                                    {{$data->Re_Qualification_on_sec}}
                                    {{-- @php
                                        $withinLimitsTime = $data->Re_Qualification_on_sec;
                                        $timeArray = explode(' | ', $withinLimitsTime);
                                        $timeInIST = isset($timeArray[0])
                                            ? $timeArray[0]
                                            : 'No IST Time Available';
                                        $timeInGMT = isset($timeArray[1])
                                            ? $timeArray[1]
                                            : 'No GMT Time Available';
                                        $isIndia = auth()->user()->timezone === 'Asia/Kolkata';
                                        echo $isIndia ? $timeInIST : $timeInGMT;
                                    @endphp --}}
                                </td>
                            </tr>

                            <tr>
                                <td colspan="2">
                                    <strong>Re-Qualification Comment:</strong><br>
                                    {{ $data->Re_Qualification_comment_sec ?? 'Not Applicable' }}
                                </td>
                            </tr>


                             <!-- Add more rows for other data -->
                             <tr>
                                <td>
                                    <strong>Retire By:</strong><br>
                                    {{ $data->retire_by }}
                                </td>
                                <td>
                                    <strong>Retire On:</strong><br>
                                    {{$data->retire_on}}
                                    {{-- @php
                                        $withinLimitsTime = $data->retire_on;
                                        $timeArray = explode(' | ', $withinLimitsTime);
                                        $timeInIST = isset($timeArray[0])
                                            ? $timeArray[0]
                                            : 'No IST Time Available';
                                        $timeInGMT = isset($timeArray[1])
                                            ? $timeArray[1]
                                            : 'No GMT Time Available';
                                        $isIndia = auth()->user()->timezone === 'Asia/Kolkata';
                                        echo $isIndia ? $timeInIST : $timeInGMT;
                                    @endphp --}}
                                </td>
                            </tr>

                            <tr>
                                <td colspan="2">
                                    <strong>Retire Comment:</strong><br>
                                    {{ $data->retire_comment ?? 'Not Applicable' }}
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