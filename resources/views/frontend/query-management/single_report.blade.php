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
                    Query Management Single Report
                </td>
                <td class="w-30">
                    <div class="logo">
                        <img src="https://vidyagxp.com/vidyaGxp_logo.png" alt="" class="w-100">
                    </div>
                </td>
            </tr>
        </table>
        <table>
            <tr>
                <td class="w-30">
                    <strong>Query Management No.</strong>
                </td>
                <td class="w-40">
                    {{ Helpers::getDivisionName($data->division_id) }}/QM/{{ $data->created_at->format('Y') }}/{{ $data->record ? str_pad($data->record, 4, '0', STR_PAD_LEFT) : '' }}
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
                <div class="block-head">
                    General Information
                </div>
                <table>
                    <tr>
                        <th class="w-20">Query ID</th>
                        <td class="w-30">
                            {{ Helpers::getDivisionName($data->division_id) }}/QM/{{ $data->created_at->format('Y') }}/{{ str_pad($data->record, 4, '0', STR_PAD_LEFT) }}
                        </td>

                        <th class="w-20">Division Code</th>
                        <td class="w-30">{{ Helpers::getDivisionName($data->division_id) }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Submitter Name</th>
                        <td class="w-30">{{ $data->originator }}</td>

                        <th class="w-20">Submission Date</th>
                        <td class="w-30">{{ Helpers::getDateFormat($data->initiation_date) }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Due Date</th>
                        <td class="w-30">
                            @if ($data->due_date)
                                {{ Helpers::getdateFormat($data->due_date) }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">Short Description</th>
                        <td class="w-80" colspan="3">
                            @if ($data->short_description)
                                {{ $data->short_description }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">Reference Document</th>
                        <td class="w-30">
                            @if ($data->reference_document)
                                {{ $data->reference_document }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">Volume</th>
                        <td class="w-30">
                            @if ($data->query_volume)
                                {{ $data->query_volume }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">Query Medium</th>
                        <td class="w-30">
                            @if ($data->query_medium)
                                {{ $data->query_medium }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">Assigned Reviewer</th>
                        <td class="w-30">
                            @if ($data->assign_to)
                                {{ Helpers::getInitiatorName($data->assign_to) }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">Contact Person Mail ID</th>
                        <td class="w-30">
                            @if ($data->contact_mailId)
                                {{ $data->contact_mailId }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">Contact Person Phone No.</th>
                        <td class="w-30">
                            @if ($data->contact_mobile)
                                {{ $data->contact_mobile }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">Affiliation</th>
                        <td class="w-30">
                            @if ($data->affiliation)
                                {{ $data->affiliation }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">Supply From</th>
                        <td class="w-30">
                            @if ($data->supply_from)
                                {{ $data->supply_from }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                </table>
            </div>

            <div class="border-table">
                <div class="block-head">
                    Mail Attachment
                </div>
                <table>
                    <tr class="table_bg">
                        <th class="w-20">S.N.</th>
                        <th class="w-60">Attachment</th>
                    </tr>
                    @if ($data->mail_attachment)
                        @foreach (json_decode($data->mail_attachment) as $key => $file)
                            <tr>
                                <td class="w-20">{{ $key + 1 }}</td>
                                <td class="w-20"><a href="{{ asset('upload/' . $file) }}"
                                        target="_blank"><b>{{ $file }}</b></a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td class="w-20">1</td>
                            <td class="w-20">Not Applicable</td>
                        </tr>
                    @endif
                </table>
            </div>

            <div class="border-table">
                <div class="block-head">
                    Initial Attachment
                </div>
                <table>
                    <tr class="table_bg">
                        <th class="w-20">S.N.</th>
                        <th class="w-60">Attachment</th>
                    </tr>
                    @if ($data->initial_attachment)
                        @foreach (json_decode($data->initial_attachment) as $key => $file)
                            <tr>
                                <td class="w-20">{{ $key + 1 }}</td>
                                <td class="w-20"><a href="{{ asset('upload/' . $file) }}"
                                        target="_blank"><b>{{ $file }}</b></a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td class="w-20">1</td>
                            <td class="w-20">Not Applicable</td>
                        </tr>
                    @endif
                </table>
            </div>

            <!-- Admin 1 Review -->
            <div class="block">
                <div class="block-head">
                    Admin 1 Review
                </div>
                <table>
                    <tr>
                        <th class="w-20">Admin 1 Review</th>
                        <td class="w-80" colspan="3">
                            @if ($data->reviewer_comment)
                                {{ $data->reviewer_comment }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                </table>
            </div>

            <div class="border-table">
                <div class="block-head">
                    Admin 1 Attachment
                </div>
                <table>
                    <tr class="table_bg">
                        <th class="w-20">S.N.</th>
                        <th class="w-60">Attachment</th>
                    </tr>
                    @if ($data->reviewer_attachment)
                        @foreach (json_decode($data->reviewer_attachment) as $key => $file)
                            <tr>
                                <td class="w-20">{{ $key + 1 }}</td>
                                <td class="w-20"><a href="{{ asset('upload/' . $file) }}"
                                        target="_blank"><b>{{ $file }}</b></a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td class="w-20">1</td>
                            <td class="w-20">Not Applicable</td>
                        </tr>
                    @endif
                </table>
            </div>

            <!-- Admin 2 Review -->

            <div class="block">
                <div class="block-head">
                    Admin 2 Review
                </div>
                <table>
                    <tr>
                        <th class="w-20">Admin 2 Review</th>
                        <td class="w-80" colspan="3">
                            @if ($data->admin1_comment)
                                {{ $data->admin1_comment }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                </table>
            </div>

            <div class="border-table">
                <div class="block-head">
                    Admin 2 Attachment
                </div>
                <table>
                    <tr class="table_bg">
                        <th class="w-20">S.N.</th>
                        <th class="w-60">Attachment</th>
                    </tr>
                    @if ($data->admin1_attachment)
                        @foreach (json_decode($data->admin1_attachment) as $key => $file)
                            <tr>
                                <td class="w-20">{{ $key + 1 }}</td>
                                <td class="w-20"><a href="{{ asset('upload/' . $file) }}"
                                        target="_blank"><b>{{ $file }}</b></a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td class="w-20">1</td>
                            <td class="w-20">Not Applicable</td>
                        </tr>
                    @endif
                </table>
            </div>

            <!-- Admin 2 Review Ends -->

            <!-- HOD Details -->

            <div class="block">
                <div class="block-head">
                    HOD Review
                </div>
                <table>
                    <tr>
                        <th class="w-20">HOD Comments</th>
                        <td class="w-80" colspan="3">
                            @if ($data->HOD_comment)
                                {{ $data->HOD_comment }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                </table>
            </div>

            <div class="border-table">
                <div class="block-head">
                    HOD Attachment
                </div>
                <table>
                    <tr class="table_bg">
                        <th class="w-20">S.N.</th>
                        <th class="w-60">Attachment</th>
                    </tr>
                    @if ($data->HOD_attachment)
                        @foreach (json_decode($data->HOD_attachment) as $key => $file)
                            <tr>
                                <td class="w-20">{{ $key + 1 }}</td>
                                <td class="w-20"><a href="{{ asset('upload/' . $file) }}"
                                        target="_blank"><b>{{ $file }}</b></a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td class="w-20">1</td>
                            <td class="w-20">Not Applicable</td>
                        </tr>
                    @endif
                </table>
            </div>


            <!-- Outcome -->
            <div class="block">
                <div class="block-head">
                    Outcome
                </div>
                <table>
                    <tr>
                        <th class="w-20">Resolution Status</th>
                        <td class="w-30">
                            {{$data->resolution_status }}
                        </td>

                        <th class="w-20">Category Tags</th>
                        <td class="w-30">{{ $data->category_tags }}</td>
                    </tr>

                    <tr>
                        <th class="w-20">Response Details</th>
                        <td class="w-80" colspan="3">
                            @if ($data->response_details)
                                {{ $data->response_details }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">Follow-up Actions</th>
                        <td class="w-80" colspan="3">
                            @if ($data->followup_action)
                                {{ $data->followup_action }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                </table>
            </div>

            <div class="border-table">
                <div class="block-head">
                    Supporting Documents
                </div>
                <table>
                    <tr class="table_bg">
                        <th class="w-20">S.N.</th>
                        <th class="w-60">Attachment</th>
                    </tr>
                    @if ($data->supporting_doc)
                        @foreach (json_decode($data->supporting_doc) as $key => $file)
                            <tr>
                                <td class="w-20">{{ $key + 1 }}</td>
                                <td class="w-20"><a href="{{ asset('upload/' . $file) }}"
                                        target="_blank"><b>{{ $file }}</b></a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td class="w-20">1</td>
                            <td class="w-20">Not Applicable</td>
                        </tr>
                    @endif
                </table>
            </div>            
        </div>
    </div>
</body>

</html>
