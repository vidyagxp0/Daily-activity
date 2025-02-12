
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
        color: #bfd0f2;
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
                        <!-- Row for Submitted By and Submitted On -->
                        <tr>
                            <td>
                                <strong style="color: #bfd0f2">Submit By :</strong><br>
                                {{ $data->submitted_by ?? 'Not Applicable' }}
                            </td>
                            <td>
                                <strong style="color: #bfd0f2">Submit On :</strong><br>
                                {{ $data->submitted_on ?? 'Not Applicable' }}
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2">
                                <strong style="color: #bfd0f2">Submit Comment :</strong><br>
                                {{ $data->submitted_comment ?? 'Not Applicable' }}
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <strong style="color: #bfd0f2">Cancelled By :</strong><br>
                                {{ $data->cancelled_by ?? 'Not Applicable' }}
                            </td>
                            <td>
                                <strong style="color: #bfd0f2">Cancelled On :</strong><br>
                                {{ $data->cancelled_on ?? 'Not Applicable' }}
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2">
                                <strong style="color: #bfd0f2">Cancelled Comment :</strong><br>
                                {{ $data->cancel_1_comment ?? 'Not Applicable' }}
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <strong style="color: #bfd0f2">Approved By :</strong><br>
                                {{ $data->approved_by ?? 'Not Applicable' }}
                            </td>
                            <td>
                                <strong style="color: #bfd0f2">Approved On :</strong><br>
                                {{ $data->approved_on ?? 'Not Applicable' }}
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2">
                                <strong style="color: #bfd0f2">Approved Comment :</strong><br>
                                {{ $data->approved_comment ?? 'Not Applicable' }}
                            </td>
                        </tr>



                        <tr>
                            <td>
                                <strong style="color: #bfd0f2">More Info Required By :</strong><br>
                                {{ $data->rejected_by ?? 'Not Applicable' }}
                            </td>
                            <td>
                                <strong style="color: #bfd0f2">More Info Required On :</strong><br>
                                {{ $data->rejected_on ?? 'Not Applicable' }}
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2">
                                <strong style="color: #bfd0f2">More Info Required Comment :</strong><br>
                                {{ $data->Reject_comment ?? 'Not Applicable' }}
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <strong style="color: #bfd0f2">Cancel By :</strong><br>
                                {{ $data->cancelled_by ?? 'Not Applicable' }}
                            </td>
                            <td>
                                <strong style="color: #bfd0f2">Cancel On :</strong><br>
                                {{ $data->cancelled_on ?? 'Not Applicable' }}
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2">
                                <strong style="color: #bfd0f2">Cancel Comment :</strong><br>
                                {{ $data->cancel_2_comment ?? 'Not Applicable' }}
                            </td>
                        </tr>


                       

                        <tr>
                            <td>
                                <strong style="color: #bfd0f2">Audit Completed By :</strong><br>
                                {{ $data->Audit_Completed_By ?? 'Not Applicable' }}
                            </td>
                            <td>
                                <strong style="color: #bfd0f2">Audit Completed On :</strong><br>
                                {{ $data->Audit_Completed_On ?? 'Not Applicable' }}
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2">
                                <strong style="color: #bfd0f2">Audit Completed Comment :</strong><br>
                                {{ $data->Audit_Completed_comment ?? 'Not Applicable' }}
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <strong style="color: #bfd0f2">Cancel By :</strong><br>
                                {{ $data->cancelled_by ?? 'Not Applicable' }}
                            </td>
                            <td>
                                <strong style="color: #bfd0f2">Cancel On :</strong><br>
                                {{ $data->cancelled_on ?? 'Not Applicable' }}
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2">
                                <strong style="color: #bfd0f2">Cancel Comment :</strong><br>
                                {{ $data->Reject_comment_2 ?? 'Not Applicable' }}
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
