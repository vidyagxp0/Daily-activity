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
        border-bottom: 2px solid #de6b13;
        margin-bottom: 10px;
        color: #de6b13;
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
                   Supplier Activity Log
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
                    {{ Helpers::divisionNameForQMS($data->division_id) }}/Deviation/{{ Helpers::year($data->created_at) }}/{{ str_pad($data->record, 4, '0', STR_PAD_LEFT) }}
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
                                <strong style="color:#de6b13" style="color:#de6b13">Need for Sourcing of Starting Material By :</strong><br>
                                    {{ $data->submitted_by }}
                                </td>
                                <td>
                                    <strong style="color:#de6b13">Need for Sourcing of Starting Material On :</strong><br>
                                    {{-- $data->submitted_on --}}

                                    @php
                                        $utcTime = $data->submitted_on ?? null;

                                        if ($utcTime) {
                                            try {
                                                $istTime = \Carbon\Carbon::parse($utcTime, 'UTC')
                                                    ->setTimezone('Asia/Kolkata')
                                                    ->format('d-M-Y H:i:s T');
                                                echo $istTime;
                                            } catch (\Exception $e) {
                                                echo 'Invalid Date Format';
                                            }
                                        } else {
                                            echo 'No Time Available';
                                        }
                                    @endphp
                                </td>
                            </tr>

                            <tr>
                                <td colspan="2">
                                    <strong style="color:#de6b13">Need for Sourcing of Starting Material Comment :</strong><br>
                                    {{ $data->submitted_comment ?? 'Not Applicable' }}
                                </td>
                            </tr>


                            <tr>
                                <td>
                                    <strong style="color:#de6b13">Approved by Contract Giver By :</strong><br>
                                    {{  $data->approvedBy_contract_giver_by  }}
                                </td>
                                <td>
                                    <strong style="color:#de6b13">Approved by Contract Giver On:</strong><br>
                                    {{-- $data->approvedBy_contract_giver_on --}}

                                    @php
                                        $utcTime = $data->approvedBy_contract_giver_on ?? null;

                                        if ($utcTime) {
                                            try {
                                                $istTime = \Carbon\Carbon::parse($utcTime, 'UTC')
                                                    ->setTimezone('Asia/Kolkata')
                                                    ->format('d-M-Y H:i:s T');
                                                echo $istTime;
                                            } catch (\Exception $e) {
                                                echo 'Invalid Date Format';
                                            }
                                        } else {
                                            echo 'No Time Available';
                                        }
                                    @endphp
                                </td>
                            </tr>

                            <tr>
                                <td colspan="2">
                                    <strong style="color:#de6b13">Approved by Contract Giver Comment :</strong><br>
                                    {{ $data->approvedBy_contract_giver_comment ?? 'Not Applicable' }}
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <strong style="color:#de6b13">Request Justified By :</strong><br>
                                    {{ $data->request_justified_by }}
                                </td>
                                <td>
                                    <strong style="color:#de6b13">Request Justified On :</strong><br>
                                    {{-- $data->request_justified_on --}}

                                    @php
                                        $utcTime = $data->request_justified_on ?? null;

                                        if ($utcTime) {
                                            try {
                                                $istTime = \Carbon\Carbon::parse($utcTime, 'UTC')
                                                    ->setTimezone('Asia/Kolkata')
                                                    ->format('d-M-Y H:i:s T');
                                                echo $istTime;
                                            } catch (\Exception $e) {
                                                echo 'Invalid Date Format';
                                            }
                                        } else {
                                            echo 'No Time Available';
                                        }
                                    @endphp
                                </td>
                            </tr>

                            <tr>
                                <td colspan="2">
                                    <strong style="color:#de6b13">Request Justified Comment :</strong><br>
                                    {{ $data->request_justified_comment ?? 'Not Applicable' }}
                                </td>
                            </tr>


                            <tr>
                                <td>
                                    <strong style="color:#de6b13">Request Not Justified By :</strong><br>
                                    {{ $data->request_not_justified_by }}
                                </td>
                                <td>
                                    <strong style="color:#de6b13">Request Not Justified On :</strong><br>
                                    {{-- $data->request_not_justified_on }}

                                    @php
                                        $utcTime = $data->request_not_justified_on ?? null;

                                        if ($utcTime) {
                                            try {
                                                $istTime = \Carbon\Carbon::parse($utcTime, 'UTC')
                                                    ->setTimezone('Asia/Kolkata')
                                                    ->format('d-M-Y H:i:s T');
                                                echo $istTime;
                                            } catch (\Exception $e) {
                                                echo 'Invalid Date Format';
                                            }
                                        } else {
                                            echo 'No Time Available';
                                        }
                                    @endphp
                                </td>
                            </tr>

                            <tr>
                                <td colspan="2">
                                    <strong style="color:#de6b13">Request Not Justified Comment :</strong><br>
                                    {{ $data->request_not_justified_comment ?? 'Not Applicable' }}
                                </td>
                            </tr>


                            <tr>
                                <td>
                                    <strong style="color:#de6b13">Pre-Purchase Sample Required By :</strong><br>
                                    {{ $data->prepurchase_sample_by}}
                                </td>
                                <td>
                                    <strong style="color:#de6b13">Pre-Purchase Sample Required On :</strong><br>
                                    {{-- $data->prepurchase_sample_on --}}

                                    @php
                                        $utcTime = $data->prepurchase_sample_on ?? null;

                                        if ($utcTime) {
                                            try {
                                                $istTime = \Carbon\Carbon::parse($utcTime, 'UTC')
                                                    ->setTimezone('Asia/Kolkata')
                                                    ->format('d-M-Y H:i:s T');
                                                echo $istTime;
                                            } catch (\Exception $e) {
                                                echo 'Invalid Date Format';
                                            }
                                        } else {
                                            echo 'No Time Available';
                                        }
                                    @endphp
                                </td>
                            </tr>

                            <tr>
                                <td colspan="2">
                                    <strong style="color:#de6b13">Pre-Purchase Sample Required Comment :</strong><br>
                                    {{ $data->prepurchase_sample_comment ?? 'Not Applicable' }}
                                </td>
                            </tr>


                            <tr>
                                <td>
                                    <strong style="color:#de6b13">Pre-Purchase Sample Not Required By :</strong><br>
                                    {{ $data->prepurchase_sample_notRequired_by }}
                                </td>
                                <td>
                                    <strong style="color:#de6b13">Pre-Purchase Sample Not Required On :</strong><br>
                                    {{-- $data->prepurchase_sample_notRequired_on --}}

                                    @php
                                        $utcTime = $data->prepurchase_sample_notRequired_on ?? null;

                                        if ($utcTime) {
                                            try {
                                                $istTime = \Carbon\Carbon::parse($utcTime, 'UTC')
                                                    ->setTimezone('Asia/Kolkata')
                                                    ->format('d-M-Y H:i:s T');
                                                echo $istTime;
                                            } catch (\Exception $e) {
                                                echo 'Invalid Date Format';
                                            }
                                        } else {
                                            echo 'No Time Available';
                                        }
                                    @endphp
                                </td>
                            </tr>

                            <tr>
                                <td colspan="2">
                                    <strong style="color:#de6b13">Pre-Purchase Sample Not Required Comment :</strong><br>
                                    {{ $data->prepurchase_sample_notRequired_comment ?? 'Not Applicable' }}
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <strong style="color:#de6b13">Purchase Sample Request Ack. by Dep. :</strong><br>
                                    {{ $data->pendigPurchaseSampleRequested_by  }}
                                </td>
                                <td>
                                    <strong style="color:#de6b13">Purchase Sample Request Ack. by Dep. On :</strong><br>
                                    {{-- $data->pendigPurchaseSampleRequested_on --}}

                                    @php
                                        $utcTime = $data->pendigPurchaseSampleRequested_on ?? null;

                                        if ($utcTime) {
                                            try {
                                                $istTime = \Carbon\Carbon::parse($utcTime, 'UTC')
                                                    ->setTimezone('Asia/Kolkata')
                                                    ->format('d-M-Y H:i:s T');
                                                echo $istTime;
                                            } catch (\Exception $e) {
                                                echo 'Invalid Date Format';
                                            }
                                        } else {
                                            echo 'No Time Available';
                                        }
                                    @endphp
                                </td>
                            </tr>

                            <tr>
                                <td colspan="2">
                                    <strong style="color:#de6b13">Purchase Sample Request Ack. by Dep. Comment :</strong><br>
                                    {{ $data->pendigPurchaseSampleRequested_comment ?? 'Not Applicable' }}
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <strong style="color:#de6b13">Purchase Sample Analysis Satisfactory By :</strong><br>
                                    {{ $data->purchaseSampleanalysis_by }}
                                </td>
                                <td>
                                    <strong style="color:#de6b13">Purchase Sample Analysis Satisfactory On :</strong><br>
                                    {{-- $data->purchaseSampleanalysis_on --}}

                                    @php
                                        $utcTime = $data->purchaseSampleanalysis_on ?? null;

                                        if ($utcTime) {
                                            try {
                                                $istTime = \Carbon\Carbon::parse($utcTime, 'UTC')
                                                    ->setTimezone('Asia/Kolkata')
                                                    ->format('d-M-Y H:i:s T');
                                                echo $istTime;
                                            } catch (\Exception $e) {
                                                echo 'Invalid Date Format';
                                            }
                                        } else {
                                            echo 'No Time Available';
                                        }
                                    @endphp
                                </td>
                            </tr>

                            <tr>
                                <td colspan="2">
                                    <strong style="color:#de6b13">Purchase Sample Analysis Satisfactory Comment :</strong><br>
                                    {{ $data->purchaseSampleanalysis_comment ?? 'Not Applicable' }}
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <strong style="color:#de6b13">Purchase Sample Analysis Not Satisfactory By:</strong><br>
                                    {{ $data->purchaseSampleanalysisNotSatisfactory_by }}
                                </td>
                                <td>
                                    <strong style="color:#de6b13">Purchase Sample Analysis Not Satisfactory On :</strong><br>
                                    {{-- $data->purchaseSampleanalysisNotSatisfactory_on --}}

                                    @php
                                        $utcTime = $data->purchaseSampleanalysisNotSatisfactory_on ?? null;

                                        if ($utcTime) {
                                            try {
                                                $istTime = \Carbon\Carbon::parse($utcTime, 'UTC')
                                                    ->setTimezone('Asia/Kolkata')
                                                    ->format('d-M-Y H:i:s T');
                                                echo $istTime;
                                            } catch (\Exception $e) {
                                                echo 'Invalid Date Format';
                                            }
                                        } else {
                                            echo 'No Time Available';
                                        }
                                    @endphp
                                </td>
                            </tr>

                            <tr>
                                <td colspan="2">
                                    <strong style="color:#de6b13">Purchase Sample Analysis Not Satisfactory Comment :</strong><br>
                                    {{ $data->purchaseSampleanalysisNotSatisfactory_comment ?? 'Not Applicable' }}
                                </td>
                            </tr>



                            <tr>
                                <td>
                                    <strong style="color:#de6b13">F&D Review Completed By :</strong><br>
                                            {{ $data->FdReviewCompleted_by }}
                                </td>
                                <td>
                                    <strong style="color:#de6b13">F&D Review Completed On :</strong><br>
                                    {{-- $data->FdReviewCompleted_on --}}

                                    @php
                                        $utcTime = $data->FdReviewCompleted_on ?? null;

                                        if ($utcTime) {
                                            try {
                                                $istTime = \Carbon\Carbon::parse($utcTime, 'UTC')
                                                    ->setTimezone('Asia/Kolkata')
                                                    ->format('d-M-Y H:i:s T');
                                                echo $istTime;
                                            } catch (\Exception $e) {
                                                echo 'Invalid Date Format';
                                            }
                                        } else {
                                            echo 'No Time Available';
                                        }
                                    @endphp
                                </td>
                            </tr>

                            <tr>
                                <td colspan="2">
                                    <strong style="color:#de6b13">F&D Review Completed Comment :</strong><br>
                                    {{ $data->FdReviewCompleted_comment ?? 'Not Applicable' }}
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <strong style="color:#de6b13">Acknowledgement By Purchase Dept. By :</strong><br>
                                    {{  $data->acknowledgByPD_by}}
                                </td>
                                <td>
                                    <strong style="color:#de6b13">Acknowledgement By Purchase Dept. On :</strong><br>
                                    {{-- $data->acknowledgByPD_on  --}}

                                    @php
                                        $utcTime = $data->acknowledgByPD_on ?? null;

                                        if ($utcTime) {
                                            try {
                                                $istTime = \Carbon\Carbon::parse($utcTime, 'UTC')
                                                    ->setTimezone('Asia/Kolkata')
                                                    ->format('d-M-Y H:i:s T');
                                                echo $istTime;
                                            } catch (\Exception $e) {
                                                echo 'Invalid Date Format';
                                            }
                                        } else {
                                            echo 'No Time Available';
                                        }
                                    @endphp
                                </td>
                            </tr>

                            <tr>
                                <td colspan="2">
                                    <strong style="color:#de6b13">Acknowledgement By Purchase Dept. Comment :</strong><br>
                                    {{ $data->acknowledgByPD_comment ?? 'Not Applicable' }}
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <strong style="color:#de6b13">All Requirements Fulfilled By :</strong><br>
                                    {{  $data->requirementFullfilled_by}}
                                </td>
                                <td>
                                    <strong style="color:#de6b13">All Requirements Fulfilled On :</strong><br>
                                    {{-- $data->requirementFullfilled_on --}}

                                    @php
                                        $utcTime = $data->requirementFullfilled_on ?? null;

                                        if ($utcTime) {
                                            try {
                                                $istTime = \Carbon\Carbon::parse($utcTime, 'UTC')
                                                    ->setTimezone('Asia/Kolkata')
                                                    ->format('d-M-Y H:i:s T');
                                                echo $istTime;
                                            } catch (\Exception $e) {
                                                echo 'Invalid Date Format';
                                            }
                                        } else {
                                            echo 'No Time Available';
                                        }
                                    @endphp
                                </td>
                            </tr>

                            <tr>
                                <td colspan="2">
                                    <strong style="color:#de6b13">All Requirements Fulfilled Comment :</strong><br>
                                    {{ $data->requirementFullfilled_comment ?? 'Not Applicable' }}
                                </td>
                            </tr>


                            <tr>
                                <td>
                                    <strong style="color:#de6b13">All Requirements Not Fulfilled By :</strong><br>
                                    {{ $data->requiredNotFulfilled_by }}
                                </td>
                                <td>
                                    <strong style="color:#de6b13">All Requirements Not Fulfilled On :</strong><br>
                                    {{-- $data->requiredNotFulfilled_on --}}

                                    @php
                                        $utcTime = $data->requiredNotFulfilled_on ?? null;

                                        if ($utcTime) {
                                            try {
                                                $istTime = \Carbon\Carbon::parse($utcTime, 'UTC')
                                                    ->setTimezone('Asia/Kolkata')
                                                    ->format('d-M-Y H:i:s T');
                                                echo $istTime;
                                            } catch (\Exception $e) {
                                                echo 'Invalid Date Format';
                                            }
                                        } else {
                                            echo 'No Time Available';
                                        }
                                    @endphp
                                </td>
                            </tr>

                            <tr>
                                <td colspan="2">
                                    <strong style="color:#de6b13">All Requirements Not Fulfilled Comment :</strong><br>
                                    {{  $data->requiredNotFulfilled_comment ?? 'Not Applicable' }}
                                </td>
                            </tr>


                            <tr>
                                <td>
                                    <strong style="color:#de6b13">Risk Rating Observed as High By :</strong><br>
                                    {{  $data->riskRatingObservedAsHigh_by }}
                                </td>
                                <td>
                                    <strong style="color:#de6b13">Risk Rating Observed as High On :</strong><br>
                                    {{-- $data->riskRatingObservedAsHigh_on  --}}

                                    @php
                                        $utcTime = $data->riskRatingObservedAsHigh_on ?? null;

                                        if ($utcTime) {
                                            try {
                                                $istTime = \Carbon\Carbon::parse($utcTime, 'UTC')
                                                    ->setTimezone('Asia/Kolkata')
                                                    ->format('d-M-Y H:i:s T');
                                                echo $istTime;
                                            } catch (\Exception $e) {
                                                echo 'Invalid Date Format';
                                            }
                                        } else {
                                            echo 'No Time Available';
                                        }
                                    @endphp
                                </td>
                            </tr>

                            <tr>
                                <td colspan="2">
                                    <strong style="color:#de6b13">Risk Rating Observed as High Comment :</strong><br>
                                    {{ $data->riskRatingObservedAsHigh_comment ?? 'Not Applicable' }}
                                </td>
                            </tr>

                                    
                            <tr>
                                <td>
                                    <strong style="color:#de6b13">Risk Rating Observed as Low By :</strong><br>
                                    {{ $data->riskRatingObservedAsLow_by }}
                                </td>
                                <td>
                                    <strong style="color:#de6b13">Risk Rating Observed as Low On :</strong><br>
                                    {{-- $data->riskRatingObservedAsLow_on  --}}

                                    @php
                                        $utcTime = $data->riskRatingObservedAsLow_on ?? null;

                                        if ($utcTime) {
                                            try {
                                                $istTime = \Carbon\Carbon::parse($utcTime, 'UTC')
                                                    ->setTimezone('Asia/Kolkata')
                                                    ->format('d-M-Y H:i:s T');
                                                echo $istTime;
                                            } catch (\Exception $e) {
                                                echo 'Invalid Date Format';
                                            }
                                        } else {
                                            echo 'No Time Available';
                                        }
                                    @endphp
                                </td>
                            </tr>

                            <tr>
                                <td colspan="2">
                                    <strong style="color:#de6b13">Risk Rating Observed as Low Comment :</strong><br>
                                    {{ $data->riskRatingObservedAsLow_comment ?? 'Not Applicable' }}
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <strong style="color:#de6b13">Manufacturer Audit Passed By :</strong><br>
                                    {{ $data->manufacturerAuditPassed_by }}
                                </td>
                                <td>
                                    <strong style="color:#de6b13">Manufacturer Audit Passed On :</strong><br>
                                    {{-- $data->manufacturerAuditPassed_on --}}

                                    @php
                                        $utcTime = $data->manufacturerAuditPassed_on ?? null;

                                        if ($utcTime) {
                                            try {
                                                $istTime = \Carbon\Carbon::parse($utcTime, 'UTC')
                                                    ->setTimezone('Asia/Kolkata')
                                                    ->format('d-M-Y H:i:s T');
                                                echo $istTime;
                                            } catch (\Exception $e) {
                                                echo 'Invalid Date Format';
                                            }
                                        } else {
                                            echo 'No Time Available';
                                        }
                                    @endphp
                                </td>
                            </tr>

                            <tr>
                                <td colspan="2">
                                    <strong style="color:#de6b13">Manufacturer Audit Passed Comment :</strong><br>
                                    {{ $data->manufacturerAuditPassed_comment ?? 'Not Applicable' }}
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <strong style="color:#de6b13">Initiate Periodic Revaluation By :</strong><br>
                                    {{ $data->periodicRevolutionInitiated_by }}
                                </td>
                                <td>
                                    <strong style="color:#de6b13">Initiate Periodic Revaluation On :</strong><br>
                                    {{-- $data->periodicRevolutionInitiated_on --}}

                                    @php
                                        $utcTime = $data->periodicRevolutionInitiated_on ?? null;

                                        if ($utcTime) {
                                            try {
                                                $istTime = \Carbon\Carbon::parse($utcTime, 'UTC')
                                                    ->setTimezone('Asia/Kolkata')
                                                    ->format('d-M-Y H:i:s T');
                                                echo $istTime;
                                            } catch (\Exception $e) {
                                                echo 'Invalid Date Format';
                                            }
                                        } else {
                                            echo 'No Time Available';
                                        }
                                    @endphp
                                </td>
                            </tr>

                            <tr>
                                <td colspan="2">
                                    <strong style="color:#de6b13">Initiate Periodic Revaluation Comment :</strong><br>
                                    {{ $data->periodicRevolutionInitiated_comment ?? 'Not Applicable' }}
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <strong style="color:#de6b13">Risk Rating Observed as High/Medium By :</strong><br>
                                    {{ $data->riskRatingObservedAsHighMedium_by }}
                                </td>
                                <td>
                                    <strong style="color:#de6b13">Risk Rating Observed as High/Medium On :</strong><br>
                                    {{-- $data->riskRatingObservedAsHighMedium_on --}}

                                    @php
                                        $utcTime = $data->riskRatingObservedAsHighMedium_on ?? null;

                                        if ($utcTime) {
                                            try {
                                                $istTime = \Carbon\Carbon::parse($utcTime, 'UTC')
                                                    ->setTimezone('Asia/Kolkata')
                                                    ->format('d-M-Y H:i:s T');
                                                echo $istTime;
                                            } catch (\Exception $e) {
                                                echo 'Invalid Date Format';
                                            }
                                        } else {
                                            echo 'No Time Available';
                                        }
                                    @endphp
                                </td>
                            </tr>

                            <tr>
                                <td colspan="2">
                                    <strong style="color:#de6b13">Risk Rating Observed as High/Medium Comment :</strong><br>
                                    {{ $data->riskRatingObservedAsHighMedium_comment ?? 'Not Applicable' }}
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <strong style="color:#de6b13">Risk Rating Observed as Low By :</strong><br>
                                    {{ $data->riskRatingObservedLow_by }}
                                </td>
                                <td>
                                    <strong style="color:#de6b13">Risk Rating Observed as Low On :</strong><br>
                                    {{-- $data->riskRatingObservedLow_on --}}

                                    @php
                                        $utcTime = $data->riskRatingObservedLow_on ?? null;

                                        if ($utcTime) {
                                            try {
                                                $istTime = \Carbon\Carbon::parse($utcTime, 'UTC')
                                                    ->setTimezone('Asia/Kolkata')
                                                    ->format('d-M-Y H:i:s T');
                                                echo $istTime;
                                            } catch (\Exception $e) {
                                                echo 'Invalid Date Format';
                                            }
                                        } else {
                                            echo 'No Time Available';
                                        }
                                    @endphp
                                </td>
                            </tr>

                            <tr>
                                <td colspan="2">
                                    <strong style="color:#de6b13">Risk Rating Observed as Low Comment :</strong><br>
                                    {{ $data->riskRatingObservedLow_comment ?? 'Not Applicable' }}
                                </td>
                            </tr>


                            <tr>
                                <td>
                                    <strong style="color:#de6b13">Manufacturer Audit Failed By :</strong><br>
                                    {{ $data->pendingManufacturerAuditFailed_by }}
                                </td>
                                <td>
                                    <strong style="color:#de6b13">Manufacturer Audit Failed On :</strong><br>
                                    {{-- $data->pendingManufacturerAuditFailed_on --}}

                                    @php
                                        $utcTime = $data->pendingManufacturerAuditFailed_on ?? null;

                                        if ($utcTime) {
                                            try {
                                                $istTime = \Carbon\Carbon::parse($utcTime, 'UTC')
                                                    ->setTimezone('Asia/Kolkata')
                                                    ->format('d-M-Y H:i:s T');
                                                echo $istTime;
                                            } catch (\Exception $e) {
                                                echo 'Invalid Date Format';
                                            }
                                        } else {
                                            echo 'No Time Available';
                                        }
                                    @endphp
                                </td>
                            </tr>

                            <tr>
                                <td colspan="2">
                                    <strong style="color:#de6b13">Manufacturer Audit Failed Comment :</strong><br>
                                    {{ $data->pendingManufacturerAuditFailed_comment ?? 'Not Applicable' }}
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