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
                    {{ Helpers::getDivisionName($data->division_id) }}/EX/{{ $data->created_at->format('Y') }}/{{ $data->record ? str_pad($data->record, 4, '0', STR_PAD_LEFT) : '' }}
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
                            <!-- Row for Initiate extensionNew By and Initiate extensionNew On -->
                            <tr>
                                <td>
                                    <strong>Submit By:</strong><br>
                                    {{ $extensionNew->submit_by }}
                                </td>
                                <td>
                                    <strong>Submit On:</strong><br>
                                    {{$extensionNew->submit_on}}
                                    {{-- @php
                                    //     $initiateTime = $extensionNew->submit_on;
                                    //     $timeArray = explode(' | ', $initiateTime);
                                    //     $timeInIST = isset($timeArray[0])
                                    //         ? $timeArray[0]
                                    //         : 'No IST Time Available';
                                    //     $timeInGMT = isset($timeArray[1])
                                    //         ? $timeArray[1]
                                    //         : 'No GMT Time Available';
                                    //     $isIndia = auth()->user()->timezone === 'Asia/Kolkata';
                                    //     echo $isIndia ? $timeInIST : $timeInGMT;
                                    // @endphp
                                    --}}
                                </td>
                            </tr>

                            <!-- Row for Submit Comments -->
                            <tr>
                                <td colspan="2">
                                    <strong>Submit Comments:</strong><br>
                                    {{ $extensionNew->submit_comment ?? 'Not Applicable' }}
                                </td>
                            </tr>

                            <!-- Add more rows for other data -->
                            <tr>
                                <td>
                                    <strong>Cancel By:</strong><br>
                                    {{ $extensionNew->reject_by }}
                                </td>
                                <td>
                                    <strong>Cancel On:</strong><br>
                                   {{$extensionNew->reject_on}}
                                </td>
                            </tr>

                            <tr>
                                <td colspan="2">
                                    <strong>Cancel Comment:</strong><br>
                                    {{ $extensionNew->reject_comment ?? 'Not Applicable' }}
                                </td>
                            </tr>


                          

                            <!-- More Information Required Section -->
                    <tr>
                        <td>
                            <strong>More Information Required By:</strong><br>
                            {{ $extensionNew->more_info_review_by }}
                        </td>
                        <td>
                            <strong>More Information Required On:</strong><br>
                            {{ $extensionNew->more_info_review_on }}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <strong>More Information Required Comment:</strong><br>
                            {{ $extensionNew->more_info_review_comment ?? 'Not Applicable' }}
                        </td>
                    </tr>

                    <!-- Review Section -->
                    <tr>
                        <td>
                            <strong>Review By:</strong><br>
                            {{ $extensionNew->submit_by_review }}
                        </td>
                        <td>
                            <strong>Review On:</strong><br>
                            {{ $extensionNew->submit_on_review }}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <strong>Review Comment:</strong><br>
                            {{ $extensionNew->submit_comment_review ?? 'Not Applicable' }}
                        </td>
                    </tr>

                    <!-- Reject Section -->
                    <tr>
                        <td>
                            <strong>Reject By:</strong><br>
                            {{ $extensionNew->submit_by_inapproved }}
                        </td>
                        <td>
                            <strong>Reject On:</strong><br>
                            {{ $extensionNew->submit_on_inapproved }}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <strong>Reject Comment:</strong><br>
                            {{ $extensionNew->submit_commen_inapproved ?? 'Not Applicable' }}
                        </td>
                    </tr>




                    <!--  rejectAdd more rows for other data -->
                    <tr>
                        <td>
                            <strong>More Information Required By:</strong><br>
                            {{ $extensionNew->more_info_inapproved_by }}
                        </td>
                        <td>
                            <strong>More Information Required On:</strong><br>
                          {{$extensionNew->more_info_inapproved_on}}
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <strong>More Information Required Comment:</strong><br>
                            {{ $extensionNew->more_info_inapproved_comment ?? 'Not Applicable' }}
                        </td>
                    </tr>



                    <!-- CQA Section -->
                    <tr>
                        <td>
                            <strong>Send for CQA By:</strong><br>
                            {{ $extensionNew->send_cqa_by }}
                        </td>
                        <td>
                            <strong>Send for CQA On:</strong><br>
                            {{ $extensionNew->send_cqa_on }}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <strong>Send for CQA Comment:</strong><br>
                            {{ $extensionNew->send_cqa_comment ?? 'Not Applicable' }}
                        </td>
                    </tr>

                    <!-- Approval Section -->
                    <tr>
                        <td>
                            <strong>Approved By:</strong><br>
                            {{ $extensionNew->submit_by_approved }}
                        </td>
                        <td>
                            <strong>Approved On:</strong><br>
                            {{ $extensionNew->submit_on_approved }}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <strong>Approved Comment:</strong><br>
                            {{ $extensionNew->submit_comment_approved ?? 'Not Applicable' }}
                        </td>
                    </tr>

                    <!-- CQA Approval Section -->
                    <tr>
                        <td>
                            <strong>CQA Approval Complete By:</strong><br>
                            {{ $extensionNew->cqa_approval_by }}
                        </td>
                        <td>
                            <strong>CQA Approval Complete On:</strong><br>
                            {{ $extensionNew->cqa_approval_on }}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <strong>CQA Approval Complete Comment:</strong><br>
                            {{ $extensionNew->cqa_approval_comment ?? 'Not Applicable' }}
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