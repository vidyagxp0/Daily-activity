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
        border-bottom: 2px solid #bfd0f2;
        margin-bottom: 10px;
        color: #bfd0f2;
    }

    .inner-block th,
    .inner-block td {
        vertical-align: baseline;
    }

    .table_bg {
        background: #eca03557;
    }
</style>

<body>

    <header>
        <table>
            <tr>
                <td class="w-70 head">
                    EHS & Environment Sustainability Activity Log
                </td>
                <td class="w-30">
                    <div class="logo">
                        <img src="https://www.cphi-online.com/Medicef%20Logo-comp306798.jpg" alt=""
                            class="w-50">
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
                    {{ Helpers::getDivisionName($data->division_id) }}/EE/{{ $data->created_at->format('Y') }}/{{ $data->record ? str_pad($data->record, 4, '0', STR_PAD_LEFT) : '' }}
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
                                    <strong style="color: #bfd0f2">Submit By:</strong><br>
                                    {{ $data->Submit_By ?? 'Not Applicable' }}
                                </td>
                                <td>
                                    <strong style="color: #bfd0f2">Submit On:</strong><br>
                                    @php
                                        $SubmitTime = $data->Submit_On;
                                        $timeArray = explode(' | ', $SubmitTime);
                                        $timeInIST = $timeArray[0] ?? 'No IST Time Available';
                                        $timeInGMT = $timeArray[1] ?? 'No GMT Time Available';
                                        $isIndia = auth()->user()->timezone === 'Asia/Kolkata';
                                        echo $isIndia ? $timeInIST : $timeInGMT;
                                    @endphp
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <strong style="color: #bfd0f2">Submit Comments:</strong><br>
                                    {{ $data->Submit_Comment ?? 'Not Applicable' }}
                                </td>
                            </tr>

                            <!-- Within Limits By and On -->
                            <tr>
                                <td>
                                    <strong style="color: #bfd0f2">Cancel By:</strong><br>
                                    {{ $data->Cancelled_By ?? 'Not Applicable' }}
                                </td>
                                <td>
                                    <strong style="color: #bfd0f2">Cancel On:</strong><br>
                                    @php
                                        $CancelTime = $data->Cancelled_On;
                                        $timeArray = explode(' | ', $CancelTime);
                                        $timeInIST = $timeArray[0] ?? 'No IST Time Available';
                                        $timeInGMT = $timeArray[1] ?? 'No GMT Time Available';
                                        $isIndia = auth()->user()->timezone === 'Asia/Kolkata';
                                        echo $isIndia ? $timeInIST : $timeInGMT;
                                    @endphp
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <strong style="color: #bfd0f2">Cancel Comment:</strong><br>
                                    {{ $data->Cancelled_Comment ?? 'Not Applicable' }}
                                </td>
                            </tr>

                            <!-- Out of Limits By and On -->
                            <tr>
                                <td>
                                    <strong style="color: #bfd0f2">Review Complete By:</strong><br>
                                    {{ $data->Review_Complete_By ?? 'Not Applicable' }}
                                </td>
                                <td>
                                    <strong style="color: #bfd0f2">Review Complete On:</strong><br>
                                    @php
                                        $ReviewCompleteTime = $data->Review_Complete_On;
                                        $timeArray = explode(' | ', $ReviewCompleteTime);
                                        $timeInIST = $timeArray[0] ?? 'No IST Time Available';
                                        $timeInGMT = $timeArray[1] ?? 'No GMT Time Available';
                                        $isIndia = auth()->user()->timezone === 'Asia/Kolkata';
                                        echo $isIndia ? $timeInIST : $timeInGMT;
                                    @endphp
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <strong style="color: #bfd0f2">Review Complete Comment:</strong><br>
                                    {{ $data->Review_Complete_Comment ?? 'Not Applicable' }}
                                </td>
                            </tr>

                            <!-- Complete Actions By and On -->
                            <tr>
                                <td>
                                    <strong style="color: #bfd0f2">More Information Required By:</strong><br>
                                    {{ $data->More_Info_Required_By ?? 'Not Applicable' }}
                                </td>
                                <td>
                                    <strong style="color: #bfd0f2">More Information Required On:</strong><br>
                                    @php
                                        $MoreInfoRequiredTime = $data->more_info_required_on;
                                        $timeArray = explode(' | ', $MoreInfoRequiredTime);
                                        $timeInIST = $timeArray[0] ?? 'No IST Time Available';
                                        $timeInGMT = $timeArray[1] ?? 'No GMT Time Available';
                                        $isIndia = auth()->user()->timezone === 'Asia/Kolkata';
                                        echo $isIndia ? $timeInIST : $timeInGMT;
                                    @endphp
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <strong style="color: #bfd0f2">More Information Required Comment:</strong><br>
                                    {{ $data->More_Info_Required_Comment ?? 'Not Applicable' }}
                                </td>
                            </tr>

                            <!-- Additional Work Required By and On -->
                            <tr>
                                <td>
                                    <strong style="color: #bfd0f2">Cancel By:</strong><br>
                                    {{ $data->Cancel_By ?? 'Not Applicable' }}
                                </td>
                                <td>
                                    <strong style="color: #bfd0f2">Cancel On:</strong><br>
                                    @php
                                        $CancelTime = $data->Cancel_On;
                                        $timeArray = explode(' | ', $CancelTime);
                                        $timeInIST = $timeArray[0] ?? 'No IST Time Available';
                                        $timeInGMT = $timeArray[1] ?? 'No GMT Time Available';
                                        $isIndia = auth()->user()->timezone === 'Asia/Kolkata';
                                        echo $isIndia ? $timeInIST : $timeInGMT;
                                    @endphp
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <strong style="color: #bfd0f2">Cancel Comment:</strong><br>
                                    {{ $data->Cancel_Comment ?? 'Not Applicable' }}
                                </td>
                            </tr>

                            <!-- QA Approval By and On -->
                            <tr>
                                <td>
                                    <strong style="color: #bfd0f2">Complete Investigation By:</strong><br>
                                    {{ $data->Complete_Investigation_By ?? 'Not Applicable' }}
                                </td>
                                <td>
                                    <strong style="color: #bfd0f2">Complete Investigation On:</strong><br>
                                    @php
                                        $CompleteInvestigationTime = $data->Complete_Investigation_On;
                                        $timeArray = explode(' | ', $CompleteInvestigationTime);
                                        $timeInIST = $timeArray[0] ?? 'No IST Time Available';
                                        $timeInGMT = $timeArray[1] ?? 'No GMT Time Available';
                                        $isIndia = auth()->user()->timezone === 'Asia/Kolkata';
                                        echo $isIndia ? $timeInIST : $timeInGMT;
                                    @endphp
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <strong style="color: #bfd0f2">Complete Investigation Comment:</strong><br>
                                    {{ $data->Complete_Investigation_Comment ?? 'Not Applicable' }}
                                </td>
                            </tr>

                            <!-- Cancel By and On -->
                            <tr>
                                <td>
                                    <strong style="color: #bfd0f2">More Investigation Required By:</strong><br>
                                    {{ $data->More_Investigation_Req_By ?? 'Not Applicable' }}
                                </td>
                                <td>
                                    <strong style="color: #bfd0f2">More Investigation Required On:</strong><br>
                                    @php
                                        $MoreInvestigationReqTime = $data->More_Investigation_Req_On;
                                        $timeArray = explode(' | ', $MoreInvestigationReqTime);
                                        $timeInIST = $timeArray[0] ?? 'No IST Time Available';
                                        $timeInGMT = $timeArray[1] ?? 'No GMT Time Available';
                                        $isIndia = auth()->user()->timezone === 'Asia/Kolkata';
                                        echo $isIndia ? $timeInIST : $timeInGMT;
                                    @endphp
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <strong style="color: #bfd0f2">More Investigation Required Comment:</strong><br>
                                    {{ $data->More_Investigation_Req_Comment ?? 'Not Applicable' }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong style="color: #bfd0f2">Analysis Complete By:</strong><br>
                                    {{ $data->Analysis_Complete_By ?? 'Not Applicable' }}
                                </td>
                                <td>
                                    <strong style="color: #bfd0f2">Analysis Complete On:</strong><br>
                                    @php
                                        $AnalysisCompleteTime = $data->Analysis_Complete_On;
                                        $timeArray = explode(' | ', $AnalysisCompleteTime);
                                        $timeInIST = $timeArray[0] ?? 'No IST Time Available';
                                        $timeInGMT = $timeArray[1] ?? 'No GMT Time Available';
                                        $isIndia = auth()->user()->timezone === 'Asia/Kolkata';
                                        echo $isIndia ? $timeInIST : $timeInGMT;
                                    @endphp
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <strong style="color: #bfd0f2">Analysis Complete Comment:</strong><br>
                                    {{ $data->Analysis_Complete_Comment ?? 'Not Applicable' }}
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <strong style="color: #bfd0f2">Training Required By:</strong><br>
                                    {{ $data->Training_required_by ?? 'Not Applicable' }}
                                </td>
                                <td>
                                    <strong style="color: #bfd0f2">Training Required On:</strong><br>
                                    @php
                                        $TrainingRequiredTime = $data->Training_required_on;
                                        $timeArray = explode(' | ', $TrainingRequiredTime);
                                        $timeInIST = $timeArray[0] ?? 'No IST Time Available';
                                        $timeInGMT = $timeArray[1] ?? 'No GMT Time Available';
                                        $isIndia = auth()->user()->timezone === 'Asia/Kolkata';
                                        echo $isIndia ? $timeInIST : $timeInGMT;
                                    @endphp
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <strong style="color: #bfd0f2">Training Required Comment:</strong><br>
                                    {{ $data->Training_required_comment ?? 'Not Applicable' }}
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <strong style="color: #bfd0f2">Training Complete By:</strong><br>
                                    {{ $data->Training_complete_by ?? 'Not Applicable' }}
                                </td>
                                <td>
                                    <strong style="color: #bfd0f2">Training Complete On:</strong><br>
                                    @php
                                        $TrainingCompleteTime = $data->Training_complete_on;
                                        $timeArray = explode(' | ', $TrainingCompleteTime);
                                        $timeInIST = $timeArray[0] ?? 'No IST Time Available';
                                        $timeInGMT = $timeArray[1] ?? 'No GMT Time Available';
                                        $isIndia = auth()->user()->timezone === 'Asia/Kolkata';
                                        echo $isIndia ? $timeInIST : $timeInGMT;
                                    @endphp
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <strong style="color: #bfd0f2">Training Complete Comment:</strong><br>
                                    {{ $data->Training_complete_comment ?? 'Not Applicable' }}
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <strong style="color: #bfd0f2">Propose Plan By:</strong><br>
                                    {{ $data->Propose_Plan_By ?? 'Not Applicable' }}
                                </td>
                                <td>
                                    <strong style="color: #bfd0f2">Propose Plan On:</strong><br>
                                    @php
                                        $ProposePlanTime = $data->Propose_Plan_On;
                                        $timeArray = explode(' | ', $ProposePlanTime);
                                        $timeInIST = $timeArray[0] ?? 'No IST Time Available';
                                        $timeInGMT = $timeArray[1] ?? 'No GMT Time Available';
                                        $isIndia = auth()->user()->timezone === 'Asia/Kolkata';
                                        echo $isIndia ? $timeInIST : $timeInGMT;
                                    @endphp
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <strong style="color: #bfd0f2">Propose Plan Comment:</strong><br>
                                    {{ $data->Propose_Plan_Comment ?? 'Not Applicable' }}
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <strong style="color: #bfd0f2">Reject By:</strong><br>
                                    {{ $data->Reject_By ?? 'Not Applicable' }}
                                </td>
                                <td>
                                    <strong style="color: #bfd0f2">Reject On:</strong><br>
                                    @php
                                        $RejectTime = $data->Reject_On;
                                        $timeArray = explode(' | ', $RejectTime);
                                        $timeInIST = $timeArray[0] ?? 'No IST Time Available';
                                        $timeInGMT = $timeArray[1] ?? 'No GMT Time Available';
                                        $isIndia = auth()->user()->timezone === 'Asia/Kolkata';
                                        echo $isIndia ? $timeInIST : $timeInGMT;
                                    @endphp
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <strong style="color: #bfd0f2">Reject Comment:</strong><br>
                                    {{ $data->Reject_Comment ?? 'Not Applicable' }}
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <strong style="color: #bfd0f2">Approve Plan By:</strong><br>
                                    {{ $data->Approve_Plan_By ?? 'Not Applicable' }}
                                </td>
                                <td>
                                    <strong style="color: #bfd0f2">Approve Plan On:</strong><br>
                                    @php
                                        $ApprovePlanTime = $data->Approve_Plan_On;
                                        $timeArray = explode(' | ', $ApprovePlanTime);
                                        $timeInIST = $timeArray[0] ?? 'No IST Time Available';
                                        $timeInGMT = $timeArray[1] ?? 'No GMT Time Available';
                                        $isIndia = auth()->user()->timezone === 'Asia/Kolkata';
                                        echo $isIndia ? $timeInIST : $timeInGMT;
                                    @endphp
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <strong style="color: #bfd0f2">Approve Plan Comment:</strong><br>
                                    {{ $data->Approve_Plan_Comment ?? 'Not Applicable' }}
                                </td>
                            </tr>


                            <tr>
                                <td>
                                    <strong style="color: #bfd0f2">More Information Required By:</strong><br>
                                    {{ $data->More_Infomation_By ?? 'Not Applicable' }}
                                </td>
                                <td>
                                    <strong style="color: #bfd0f2">More Information Required On:</strong><br>
                                    @php
                                        $MoreInfomationTime = $data->More_Infomation_On;
                                        $timeArray = explode(' | ', $MoreInfomationTime);
                                        $timeInIST = $timeArray[0] ?? 'No IST Time Available';
                                        $timeInGMT = $timeArray[1] ?? 'No GMT Time Available';
                                        $isIndia = auth()->user()->timezone === 'Asia/Kolkata';
                                        echo $isIndia ? $timeInIST : $timeInGMT;
                                    @endphp
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <strong style="color: #bfd0f2">More Information Required Comment:</strong><br>
                                    {{ $data->More_Infomation_Comment ?? 'Not Applicable' }}
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <strong style="color: #bfd0f2">All CAPA Closed By:</strong><br>
                                    {{ $data->All_CAPA_Closed_By ?? 'Not Applicable' }}
                                </td>
                                <td>
                                    <strong style="color: #bfd0f2">All CAPA Closed On:</strong><br>
                                    @php
                                        $AllCAPAClosedTime = $data->All_CAPA_Closed_On;
                                        $timeArray = explode(' | ', $AllCAPAClosedTime);
                                        $timeInIST = $timeArray[0] ?? 'No IST Time Available';
                                        $timeInGMT = $timeArray[1] ?? 'No GMT Time Available';
                                        $isIndia = auth()->user()->timezone === 'Asia/Kolkata';
                                        echo $isIndia ? $timeInIST : $timeInGMT;
                                    @endphp
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <strong style="color: #bfd0f2">All CAPA Closed Comment:</strong><br>
                                    {{ $data->All_CAPA_Closed_Comment ?? 'Not Applicable' }}
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
