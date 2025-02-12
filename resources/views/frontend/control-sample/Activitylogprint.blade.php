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
                        <img src="https://navin.mydemosoftware.com/public/user/images/logo.png" alt=""
                            class="w-60">
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
                {{ Helpers::getDivisionName($data->division_id) }}/CS/{{ date('Y') }}/{{ str_pad($data->record, 4, '0', STR_PAD_LEFT) }}                </td>
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
                                <strong style="color: #bfd0f2">submit By :</strong><br>
                                {{ $data->submit_by ?? 'Not Applicable' }}
                            </td>
                            <td>
                                <strong style="color: #bfd0f2">submit On :</strong><br>
                                {{ Helpers::getdateFormat($data->submit_on)?? 'Not Applicable' }}
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2">
                                <strong style="color: #bfd0f2">submit Comment :</strong><br>
                                {{ $data->submit_comment ?? 'Not Applicable' }}
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <strong style="color: #bfd0f2">Control Sample Inspection Completed  By :</strong><br>
                                {{ $data->control_sample_insp_by ?? 'Not Applicable' }}
                            </td>
                            <td>
                                <strong style="color: #bfd0f2">Control Sample Inspection Completed  On :</strong><br>
                                {{ Helpers::getdateFormat($data->control_sample_insp_on) ?? 'Not Applicable' }}
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2">
                                <strong style="color: #bfd0f2">Control Sample Inspection Completed  Comment :</strong><br>
                                {{ $data->control_sample_ins_comment ?? 'Not Applicable' }}
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <strong style="color: #bfd0f2">More Information By :</strong><br>
                                {{ $data->more_info_by ?? 'Not Applicable' }}
                            </td>
                            <td>
                                <strong style="color: #bfd0f2">More Information On :</strong><br>
                                {{ Helpers::getdateFormat($data->more_info_on) ?? 'Not Applicable' }}
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2">
                                <strong style="color: #bfd0f2">More Information Comment :</strong><br>
                                {{ $data->more_info_comment ?? 'Not Applicable' }}
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <strong style="color: #bfd0f2">Distraction Complete By :</strong><br>
                                {{ $data->distraction_complete_by  ?? 'Not Applicable' }}
                            </td>
                            <td>
                                <strong style="color: #bfd0f2">Distraction Complete On :</strong><br>
                                {{ Helpers::getdateFormat($data->distraction_complete_on)  ?? 'Not Applicable' }}
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2">
                                <strong style="color: #bfd0f2">Distraction Complete Comment :</strong><br>
                                {{ $data->distraction_complete_comment  ?? 'Not Applicable'}}
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <strong style="color: #bfd0f2">More Information By :</strong><br>
                                {{ $data->more_info_second_by ?? 'Not Applicable' }}
                            </td>
                            <td>
                                <strong style="color: #bfd0f2">More Information On :</strong><br>
                                {{ Helpers::getdateFormat($data->more_info_second_on) ?? 'Not Applicable' }}
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2">
                                <strong style="color: #bfd0f2">More Information Comment :</strong><br>
                                {{ $data->more_info_second_comment ?? 'Not Applicable' }}
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
