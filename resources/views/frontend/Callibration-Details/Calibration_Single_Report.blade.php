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
                    Calibration Management Single Report
                </td>
                <td class="w-30">
                    <div class="logo">
                        <img src="https://www.cphi-online.com/Medicef%20Logo-comp306798.jpg" alt="" class="w-80">
                    </div>
                </td>
            </tr>
        </table>
        <table>
            <tr>
                <td class="w-30">
                    <strong>Calibration Management No.</strong>
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
                <div class="block-head">
                    General Information
                </div>
                <table>
                    <tr>
                        <th class="w-20">Record Number</th>
                        <td class="w-30">
                            {{ Helpers::getDivisionName($data->division_id) }}/QM/{{ $data->created_at->format('Y') }}/{{ str_pad($data->record, 4, '0', STR_PAD_LEFT) }}
                        </td>

                        <th class="w-20">Division Code</th>
                        <td class="w-30">{{ Helpers::getDivisionName($data->division_id) }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Initiator</th>
                        <td class="w-30">{{ Helpers::getInitiatorName($data->initiator_id) }}</td>

                        <th class="w-20">Date of Initiation</th>
                        <td class="w-30">{{ Helpers::getDateFormat($data->intiation_date) }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Assign To</th>
                        <td class="w-30">
                            @if ($data->assign_to)
                                {{Helpers::getInitiatorName ($data->assign_to) }}
                            @else
                                Not Applicable
                            @endif
                        </td>
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
                        <th class="w-20">Calibration Standard Reference</th>
                        <td class="w-30">
                            @if ($data->calibration_standard_preference)
                                {{ $data->calibration_standard_preference }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">Calibration Frequency</th>
                        <td class="w-30">
                            @if ($data->callibration_frequency)
                                {{ $data->callibration_frequency }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">Last Calibration Date</th>
                        <td class="w-30">
                            @if ($data->last_calibration_date)
                                {{ Helpers::getdateFormat($data->last_calibration_date) }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">Next Calibration Date</th>
                        <td class="w-30">
                            @if ($data->next_calibration_date)
                                {{ Helpers::getdateFormat($data->next_calibration_date) }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">Calibration Due Reminder</th>
                        <td class="w-30">
                            @if ($data->calibration_due_reminder)
                                {{ $data->calibration_due_reminder }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">Calibration Method/Procedure</th>
                        <td class="w-30">
                            @if ($data->calibration_method_procedure)
                                {{ $data->calibration_method_procedure }}
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

                        <th class="w-20">Calibration Procedure Reference/Document</th>
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
                    Calibration Procedure Reference/Document
                </div>
                <table>
                    <tr class="table_bg">
                        <th class="w-20">S.N.</th>
                        <th class="w-60">Attachment</th>
                    </tr>
                    @if ($data->calibration_procedure_attach)
                        @foreach (json_decode($data->calibration_procedure_attach) as $key => $file)
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

            <div class="block">
                <table>
                    
                    <tr>
                        <th class="w-20">Calibration Standards Used</th>
                        <td class="w-30">
                            @if ($data->calibration_used)
                                {{ $data->calibration_used }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">Calibration Parameters</th>
                        <td class="w-30">
                            @if ($data->calibration_parameter)
                                {{ $data->calibration_parameter }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Unscheduled or Event Based Calibration?</th>
                        <td class="w-30">
                            @if ($data->event_based_calibration)
                                {{ $data->event_based_calibration }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">Reason for Unscheduled or Event Based Calibration</th>
                        <td class="w-30">
                            @if ($data->event_based_calibration_reason)
                                {{ $data->event_based_calibration_reason }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Event Reference No.</th>
                        <td class="w-30">
                            @if ($data->event_refernce_no)
                                {{ $data->event_refernce_no }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">Calibration Checklist</th>
                        <td class="w-30">
                            @if ($data->calibration_checklist)
                                {{ $data->calibration_checklist }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Calibration Results</th>
                        <td class="w-30">
                            @if ($data->calibration_result)
                                {{ $data->calibration_result }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">Calibration Certificate Number</th>
                        <td class="w-30">
                            @if ($data->calibration_certificate_result)
                                {{ $data->calibration_certificate_result }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    {{-- <div class="border-table">
                        <div class="block-head">
                            Calibration Certificate Attachment
                        </div>
                        <table>
                            <tr class="table_bg">
                                <th class="w-20">S.N.</th>
                                <th class="w-60">Attachment</th>
                            </tr>
                            @if ($data->Implementor_Attachment)
                                @foreach (json_decode($data->Implementor_Attachment) as $key => $file)
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
                    </div> --}}


                    <tr>
                        <th class="w-20">Calibrated By</th>
                        <td class="w-30">
                            @if ($data->equipment_id)
                                {{ $data->equipment_id }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">Calibration Due Alert</th>
                        <td class="w-30">
                            @if ($data->calibration_due_alert)
                                {{ $data->calibration_due_alert }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">Cost of Calibration</th>
                        <td class="w-30">
                            @if ($data->calibration_cost)
                                {{ $data->calibration_cost }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">Calibration Comments/Observations</th>
                        <td class="w-30">
                            @if ($data->calibration_comments)
                                {{ $data->calibration_comments }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                </table>
                <div class="border-table">
                    <div class="block-head"> Calibration Certificate Attachment </div>
                    <table>
                        <tr class="table_bg">
                            <th class="w-20">S.N.</th>
                            <th class="w-60">Attachment</th>
                        </tr>
                        @if ($data->calibration_certificate)
                            @foreach (json_decode($data->calibration_certificate) as $key => $file)
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

            <div class="block-head">
                Implementor Review
            </div>

            <table>
                <tr>
                    <th class="w-20">Implementor Review Comment</th>
                        <td class="w-30">
                            @if ($data->Imp_review_comm)
                                {{ $data->Imp_review_comm }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                </tr>               
            </table>

            <div class="border-table">
                <div class="block-head"> Implementor Review Attachment </div>
                <table>
                    <tr class="table_bg">
                        <th class="w-20">S.N.</th>
                        <th class="w-60">Attachment</th>
                    </tr>
                    @if ($data->Implementor_Attachment)
                        @foreach (json_decode($data->Implementor_Attachment) as $key => $file)
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

            <div class="block-head">
                QA Review
            </div>
            
            <table>
                <tr>
                    <th class="w-20">QA Review Comment</th>
                        <td class="w-30">
                            @if ($data->qa_rev_comm)
                                {{ $data->qa_rev_comm }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                </tr>              
            </table>

            <div class="border-table">
                <div class="block-head"> QA Review Attachmen </div>
                <table>
                    <tr class="table_bg">
                        <th class="w-20">S.N.</th>
                        <th class="w-60">Attachment</th>
                    </tr>
                    @if ($data->qa_rev_attachment)
                        @foreach (json_decode($data->qa_rev_attachment) as $key => $file)
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

            

            <div class="block">
                <div class="block-head">Activity Log</div>
                <table>
                    <tr>
                        <th class="w-20">Initiate Calibration By</th>
                        <td class="w-30">{{ $data->Initiate_Calibration_by }}</td>
                        <th class="w-20">Initiate Calibration On</th>
                        <td class="w-30">{{ $data->Initiate_Calibration_on }}</td>
                        <th class="w-20">Initiate Calibration Comments</th>
                        <td class="w-30">{{ $data->Initiate_Calibration_comments }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Within Limits By</th>
                        <td class="w-30">{{ $data->Within_Limits_by }}</td>
                        <th class="w-20">Within Limits On</th>
                        <td class="w-30">{{ Helpers::getdateFormat($data->Within_Limits_on) }}</td>
                        <th class="w-20">Within Limits Comment</th>
                        <td class="w-30">{{ $data->Within_Limits_comment }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">QA Approval By	</th>
                        <td class="w-30">{{ $data->QA_Approval_by	 }}</td>
                        <th class="w-20">QA Approval On</th>
                        <td class="w-30">{{ Helpers::getdateFormat($data->QA_Approval_on) }}</td>
                        <th class="w-20">QA Approval Comment</th>
                        <td class="w-30">{{ $data->QA_Approval_comment }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Out Of Limits By</th>
                        <td class="w-30">{{ $data->Out_of_Limits_by }}</td>
                        <th class="w-20">Out Of Limits On</th>
                        <td class="w-30">{{ Helpers::getdateFormat($data->Out_of_Limits_on) }}</td>
                        <th class="w-20">Out Of LimitsComment</th>
                        <td class="w-30">{{ $data->Out_of_Limits_comment }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Complete Actions By</th>
                        <td class="w-30">{{ $data->Complete_Actions_by }}</td>
                        <th class="w-20">Complete Actions On</th>
                        <td class="w-30">{{ Helpers::getdateFormat($data->Complete_Actions_on) }}</td>
                        <th class="w-20">Complete Actions Comment</th>
                        <td class="w-30">{{ $data->Complete_Actions_comment }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Additional Work Required By</th>
                        <td class="w-30">{{ $data->Additional_Work_Required_by }}</td>
                        <th class="w-20">Additional Work Required On</th>
                        <td class="w-30">{{ Helpers::getdateFormat($data->Additional_Work_Required_on) }}</td>
                        <th class="w-20">Additional Work Required Comment</th>
                        <td class="w-30">{{ $data->Additional_Work_Required_comment }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Cancel By</th>
                        <td class="w-30">{{ $data->cancel_by }}</td>
                        <th class="w-20">Cancel On</th>
                        <td class="w-30">{{ Helpers::getdateFormat($data->cancel_on) }}</td>
                        <th class="w-20">Cancel Comment</th>
                        <td class="w-30">{{ $data->cancel_comment }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Cancelled By</th>
                        <td class="w-30">{{ $data->cancelled_by }}</td>
                        <th class="w-20">Cancelled On</th>
                        <td class="w-30">{{ $data->cancelled_on }}</td>
                        <th class="w-20">Cancelled Comment</th>
                        <td class="w-30">{{ $data->cancelled_comment }}</td>
                    </tr>
                </table>
            </div>
            
           
        </div>
    </div>
</body>

</html>
