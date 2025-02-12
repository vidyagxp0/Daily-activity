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
        border-bottom: 2px solid #de8d0a;
        margin-bottom: 10px;
        color: #de8d0a;
        /*color: #4274da;*/
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
                    Lab Incident Activity Log
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
                    {{ Helpers::divisionNameForQMS($data->division_id) }}/LI/{{ date('Y') }}/{{ str_pad($data->record, 4, '0', STR_PAD_LEFT) }}
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
                                    <strong style="color: #de8d0a">Submit By :</strong><br>
                                    {{ $data->submitted_by }}
                                </td>
                                <td>
                                    <strong style="color: #de8d0a">Submit On :</strong><br>
                                    {{ $data->submitted_on }}
                                </td>
                            </tr>

                            <tr>
                                <td colspan="2">
                                    <strong style="color: #de8d0a">Submit Comments :</strong><br>
                                    {{ $data->comment}}
                                </td>
                            </tr>


                            <tr>
                                <td>
                                    <strong style="color: #de8d0a">Verification Complete By :</strong><br>
                                    {{ $data->verification_complete_completed_by }}
                                </td>
                                <td>
                                    <strong style="color: #de8d0a">Verification Complete On :</strong><br>
                                    {{ $data->verification_completed_on }}
                                </td>
                            </tr>

                            <tr>
                                <td colspan="2">
                                    <strong style="color: #de8d0a">Verification Complete Comment:</strong><br>
                                    {{ $data->verification_complete_comment ?? 'Not Applicable' }}
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <strong style="color: #de8d0a">Preliminary Investigation Completed By :</strong><br>
                                    {{ $data->preliminary_completed_by }}
                                </td>
                                <td>
                                    <strong style="color: #de8d0a">Preliminary Investigation Completed On :</strong><br>
                                    {{ $data->preliminary_completed_on }}
                                </td>
                            </tr>

                            <tr>
                                <td colspan="2">
                                    <strong style="color: #de8d0a">Preliminary Investigation Completed Comment :</strong><br>
                                    {{ $data->preliminary_completed_comment ?? 'Not Applicable' }}
                                </td>
                            </tr>


                            <tr>
                                <td>
                                    <strong style="color: #de8d0a">Assignable Cause Identification Completed By :</strong><br>
                                    {{ $data->all_activities_completed_by}}
                                </td>
                                <td>
                                    <strong style="color: #de8d0a">Assignable Cause Identification Completed On :</strong><br>
                                    {{ $data->all_activities_completed_on }}
                                </td>
                            </tr>

                            <tr>
                                <td colspan="2">
                                    <strong style="color: #de8d0a">Assignable Cause Identification Completed Comment :</strong><br>
                                    {{ $data->all_activities_completed_comment ?? 'Not Applicable' }}
                                </td>
                            </tr>


                            <tr>
                                <td>
                                    <strong style="color: #de8d0a">No Assignable Cause Identification Completed By :</strong><br>
                                    {{ $data->no_assignable_cause_by }}
                                </td>
                                <td>
                                    <strong style="color: #de8d0a">No Assignable Cause Identification Completed On :</strong><br>
                                    {{ $data->no_assignable_cause_on }}
                                </td>
                            </tr>

                            <tr>
                                <td colspan="2">
                                    <strong style="color: #de8d0a">No Assignable Cause Identification Completed Comment :</strong><br>
                                    {{ $data->no_assignable_cause_comment ?? 'Not Applicable' }}
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <strong style="color: #de8d0a">Extended Inv Completed By :</strong><br>
                                    {{ $data->extended_inv_complete_by }}
                                </td>
                                <td>
                                    <strong style="color: #de8d0a">Extended Inv Completed On :</strong><br>
                                    {{ $data->extended_inv_complete_on }}
                                </td>
                            </tr>

                            <tr>
                                <td colspan="2">
                                    <strong style="color: #de8d0a">Extended Inv Completed Comment :</strong><br>
                                    {{ $data->extended_inv_comment ?? 'Not Applicable' }}
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <strong style="color: #de8d0a">Solution Validation Completed By :</strong><br>
                                    {{ $data->review_completed_by }}
                                </td>
                                <td>
                                    <strong style="color: #de8d0a">Solution Validation Completed On :</strong><br>
                                    {{ $data->review_completed_on }}
                                </td>
                            </tr>

                            <tr>
                                <td colspan="2">
                                    <strong style="color: #de8d0a">Solution Validation Completed Comment :</strong><br>
                                    {{ $data->solution_validation_comment ?? 'Not Applicable' }}
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <strong style="color: #de8d0a">All Action Approved Completed By :</strong><br>
                                    {{ $data->all_actiion_approved_by }}
                                </td>
                                <td>
                                    <strong style="color: #de8d0a">All Action Approved Completed On :</strong><br>
                                    {{ $data->all_actiion_approved_on }}
                                </td>
                            </tr>

                            <tr>
                                <td colspan="2">
                                    <strong style="color: #de8d0a">All Action Approved Completed Comment :</strong><br>
                                    {{ $data->all_action_approved_comment ?? 'Not Applicable' }}
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <strong style="color: #de8d0a">Assessment Completed By :</strong><br>
                                    {{ $data->assesment_completed_by }}
                                </td>
                                <td>
                                    <strong style="color: #de8d0a">Assessment Completed On :</strong><br>
                                    {{ $data->assesment_completed_on }}
                                </td>
                            </tr>

                            <tr>
                                <td colspan="2">
                                    <strong style="color: #de8d0a">Assessment Completed Comment :</strong><br>
                                    {{ $data->assessment_comment ?? 'Not Applicable' }}
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <strong style="color: #de8d0a">Closure Completed By :</strong><br>
                                    {{ $data->closure_completed_by }}
                                </td>
                                <td>
                                    <strong style="color: #de8d0a">Closure Completed On :</strong><br>
                                    {{ $data->closure_completed_on }}
                                </td>
                            </tr>

                            <tr>
                                <td colspan="2">
                                    <strong style="color: #de8d0a">Closure Completed Comment :</strong><br>
                                    {{ $data->closure_comment ?? 'Not Applicable' }}
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <strong style="color: #de8d0a">Cancel By :</strong><br>
                                    {{ $data->cancelled_by }}
                                </td>
                                <td>
                                    <strong style="color: #de8d0a">Cancel By On :</strong><br>
                                    {{ $data->cancelled_on }}
                                </td>
                            </tr>

                            <tr>
                                <td colspan="2">
                                    <strong style="color: #de8d0a">Cancel Comment Comment :</strong><br>
                                    {{ $data->cancelled_comment ?? 'Not Applicable' }}
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