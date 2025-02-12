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

    .head-number {
        font-weight: bold;
        font-size: 13px;
        padding-left: 10px;
    }

    .div-data {
        font-size: 13px;
        padding-left: 10px;
        margin-bottom: 10px;
    }
</style>

<body>
    <header>
        <table>
            <tr>
                <td class="w-70 head">
                    Equipment/Instrument Lifecycle Management Family Report
                </td>
                <td class="w-30">
                    <div class="logo">
                        <img src="https://www.cphi-online.com/Medicef%20Logo-comp306798.jpg" alt="" class="w-60">
                    </div>
                </td>
            </tr>
        </table>
        <table>
            <tr>
                <td class="w-30">
                    <strong>Equipment/Instrument Lifecycle Management No.</strong>
                </td>
                <td class="w-40">
                    {{ Helpers::divisionNameForQMS($data->division_id) }}/EI/{{ Helpers::year($data->created_at) }}/{{ str_pad($data->record, 4, '0', STR_PAD_LEFT) }}
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
                {{-- <td class="w-30">
                    <strong>Page :</strong> 1 of 1
                </td> --}}
            </tr>
        </table>
    </footer>

    <div class="inner-block">
        <div class="content-table">
            <div class="block">
                <div class="block-head">
                    Equipment Information
                </div>
                <table>
                    <tr> {{ $data->created_at }} added by {{ $data->originator }}
                        <th class="w-20">Record Number</th>
                        <td class="w-80">
                            {{ Helpers::divisionNameForQMS($data->division_id) }}/RCA/{{ Helpers::year($data->created_at) }}/{{ str_pad($data->record, 4, '0', STR_PAD_LEFT) }}
                        <th class="w-20">Site/Location Code</th>
                        <td class="w-80">
                            @if ($data->division_id)
                                {{ Helpers::getDivisionName($data->division_id) }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Initiator</th>
                        <td class="w-80">{{ Helpers::getInitiatorName($data->initiator_id) }}</td>
                        <th class="w-20">Date of Initiation</th>
                        <td class="w-80">{{ Helpers::getdateFormat($data->created_at) }}</td>

                    </tr>
                    <tr>

                        <th class="w-20">Assigned To</th>
                        <td class="w-80">
                            @if ($data->assign_to)
                                {{ Helpers::getInitiatorName($data->assign_to) }}
                            @else
                            Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Due Date</th>
                        <td class="w-80">
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

                        <th class="w-20">Equipment/Instrument ID/Tag Number</th>
                        <td class="w-80">
                            @if ($data->equipment_id)
                                {{ $data->equipment_id }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Equipment/Instrument Name/Description</th>
                        <td class="w-80">
                            @if ($data->equipment_name_description)
                                {{ $data->equipment_name_description }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                    </tr>

                    <tr>
                        <th class="w-20">Manufacturer</th>
                        <td class="w-80">
                            @if ($data->manufacturer)
                                {{ $data->manufacturer }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Model Number</th>
                        <td class="w-80">
                            @if ($data->model_number)
                                {{ $data->model_number }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Serial Number</th>
                        <td class="w-80">
                            @if ($data->serial_number)
                                {{ $data->serial_number }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Location</th>
                        <td class="w-80">
                            @if ($data->location)
                                {{ $data->location }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">Purchase Date</th>
                        <td class="w-80">
                            @if ($data->purchase_date)
                                {{ $data->purchase_date }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Installation Date</th>
                        <td class="w-80">
                            @if ($data->installation_date)
                                {{ $data->installation_date }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">Warranty Expiration Date</th>
                        <td class="w-80">
                            @if ($data->warranty_expiration_date)
                                {{ $data->warranty_expiration_date }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Criticality Level</th>
                        <td class="w-80">
                            @if ($data->criticality_level)
                                {{ $data->criticality_level }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Asset Type</th>
                        <td class="w-80">
                            @if ($data->asset_type)
                                {{ $data->asset_type }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                </table>

                <div class="block">
                    <div class="block-head">
                        QA Final Review
                    </div>
                    <table>
                        <tr>
                            <th class="w-20">URS Description</th>
                            <td class="w-80" colspan="3">
                                @if ($data->urs_description)
                                    {{ $data->urs_description }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th class="w-20">Initial/Business/System Level Risk Assessment Details</th>
                            <td class="w-80" colspan="3">
                                @if ($data->system_level_risk_assessment_details)
                                    {{ $data->system_level_risk_assessment_details }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>

                <div class="border-table  tbl-bottum">
                    <div class="block-head">
                        Failure Mode and Effect Analysis
                    </div>
                    <table>

                        <tr class="table_bg">
                            <th class="w-10">Row #</th>
                            <th class="w-30">Risk Factor</th>
                            <th class="w-30">Risk element</th>
                            <th class="w-30">Probable cause of risk element</th>
                            <th class="w-30">Existing Risk Controls</th>
                        </tr>
                        {{-- @if ($data->root_cause_initial_attachment)
                                @foreach (json_decode($data->root_cause_initial_attachment) as $key => $file)
                                    <tr>
                                        <td class="w-20">{{ $key + 1 }}</td>
                                        <td class="w-20"><a href="{{ asset('upload/' . $file) }}" target="_blank"><b>{{ $file }}</b></a> </td>
                                    </tr>
                                @endforeach
                                @else --}}
                        @if (!empty($data->risk_factor))
                            @foreach (unserialize($data->risk_factor) as $key => $riskFactor)
                                <tr>
                                    <td class="w-10">{{ $key + 1 }}</td>
                                    <td class="w-30">{{ $riskFactor }}</td>
                                    <td class="w-30">{{ unserialize($data->risk_element)[$key] ?? null }}</td>
                                    <td class="w-30">{{ unserialize($data->problem_cause)[$key] ?? null }}</td>
                                    <td class="w-30">{{ unserialize($data->existing_risk_control)[$key] ?? null }}
                                    </td>
                                </tr>
                            @endforeach
                        @else
                        @endif

                    </table>

                </div>
                </table>
                <div class="border-table  tbl-bottum">
                    <table>
                        <tr class="table_bg">
                            <th class="w-10">Row #</th>
                            <th class="w-30">Initial Severity- H(3)/M(2)/L(1)</th>
                            <th class="w-30">Initial Probability- H(3)/M(2)/L(1)</th>
                            <th class="w-30">Initial Detectability- H(1)/M(2)/L(3)</th>
                            <th class="w-30">Initial RPN</th>
                        </tr>
                        @if (!empty($data->risk_factor))
                            @foreach (unserialize($data->risk_factor) as $key => $riskFactor)
                                <tr>
                                    <td class="w-10">{{ $key + 1 }}</td>
                                    <td class="w-30">{{ unserialize($data->initial_severity)[$key] }}</td>
                                    <td class="w-30">{{ unserialize($data->initial_detectability)[$key] }}</td>
                                    <td class="w-30">{{ unserialize($data->initial_probability)[$key] }}</td>
                                    <td class="w-30">{{ unserialize($data->initial_rpn)[$key] }}</td>
                                </tr>
                            @endforeach
                        @else
                        @endif
                    </table>
                </div>
                <div class="border-table  tbl-bottum">
                    <table>
                        <tr class="table_bg">
                            <th class="w-10">Row #</th>
                            <th class="w-30">Risk Acceptance (Y/N)</th>
                            <th class="w-30">Proposed Additional Risk control measure (Mandatory for Risk elements
                                having RPN>4)</th>
                            <th class="w-30">Residual Severity- H(3)/M(2)/L(1)</th>
                            <th class="w-30">Residual Probability- H(3)/M(2)/L(1)</th>
                        </tr>
                        @if (!empty($data->risk_factor))
                            @foreach (unserialize($data->risk_factor) as $key => $riskFactor)
                                <tr>
                                    <td class="w-10">{{ $key + 1 }}</td>
                                    <td class="w-30">{{ unserialize($data->risk_acceptance)[$key] }}</td>
                                    <td class="w-30">{{ unserialize($data->risk_control_measure)[$key] }}</td>
                                    <td class="w-30">{{ unserialize($data->residual_severity)[$key] }}</td>
                                    <td class="w-30">{{ unserialize($data->residual_probability)[$key] }}</td>
                                </tr>
                            @endforeach
                        @else
                        @endif
                    </table>
                </div>
                <div class="border-table  tbl-bottum">
                    <table>
                        <tr class="table_bg">
                            <th class="w-10">Row #</th>
                            <th class="w-30">Residual Detectability- H(1)/M(2)/L(3)</th>
                            <th class="w-30">Residual RPN</th>
                            <th class="w-30">Risk Acceptance (Y/N)</th>
                            <th class="w-30">Mitigation proposal (Mention either CAPA reference number, IQ, OQ or PQ)
                            </th>
                        </tr>
                        @if (!empty($data->risk_factor))
                            @foreach (unserialize($data->risk_factor) as $key => $riskFactor)
                                <tr>
                                    <td class="w-10">{{ $key + 1 }}</td>
                                    <td class="w-30">{{ unserialize($data->residual_detectability)[$key] }}</td>
                                    <td class="w-30">{{ unserialize($data->residual_rpn)[$key] }}</td>
                                    <td class="w-30">{{ unserialize($data->risk_acceptance2)[$key] }}</td>
                                    <td class="w-30">{{ unserialize($data->mitigation_proposal)[$key] }}</td>
                                </tr>
                            @endforeach
                        @else
                        @endif
                    </table>
                </div>
                
                <div class="border-table">
                    <div class="block-head">
                        Supporting Documents
                    </div>
                    <table>

                        <tr class="table_bg">
                            <th class="w-20">S.N.</th>
                            <th class="w-60">Batch No</th>
                        </tr>
                        @if ($data->supporting_documents)
                            @foreach (json_decode($data->supporting_documents) as $key => $file)
                                <tr>
                                    <td class="w-20">{{ $key + 1 }}</td>
                                    <td class="w-20"><a href="{{ asset('upload/' . $file) }}"
                                            target="_blank"><b>{{ $file }}</b></a> </td>
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

                <table>
                        <tr>
                            <th class="w-20">FRS Description</th>
                            <td class="w-80" colspan="3">
                                @if ($data->frs_description)
                                    {{ $data->frs_description }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr> 
                </table>

                <div class="border-table">
                    <div class="block-head">
                        FRS Attachment
                    </div>
                    <table>

                        <tr class="table_bg">
                            <th class="w-20">S.N.</th>
                            <th class="w-60">Batch No</th>
                        </tr>
                        @if ($data->frs_attachment)
                            @foreach (json_decode($data->frs_attachment) as $key => $file)
                                <tr>
                                    <td class="w-20">{{ $key + 1 }}</td>
                                    <td class="w-20"><a href="{{ asset('upload/' . $file) }}"
                                            target="_blank"><b>{{ $file }}</b></a> </td>
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

                <table>
                        <tr>
                            <th class="w-20">Functional Risk Assessment Details</th>
                            <td class="w-80" colspan="3">
                                @if ($data->functional_risk_assessment_details)
                                    {{ $data->functional_risk_assessment_details }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr> 
                </table>

                <div class="block">
                    <div class="block-head">
                    Installation Qualification (IQ)
                    </div>
                    <table>
                        <tr>
                            <th class="w-20">IQ Test Plan</th>
                            <td class="w-80">
                                @if ($data->iq_test_plan)
                                    {{ $data->iq_test_plan }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                            <th class="w-20">IQ Protocol</th>
                            <td class="w-80">
                                @if ($data->iq_protocol)
                                    {{ $data->iq_protocol }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th class="w-20">IQ Execution</th>
                            <td class="w-80">
                                @if ($data->iq_execution)
                                    {{ $data->iq_execution }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                            <th class="w-20">IQ Report</th>
                            <td class="w-80">
                                @if ($data->iq_report)
                                    {{ $data->iq_report }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>

                <div class="border-table">
                    <div class="block-head">
                    Equipment Qualification Attachment
                    </div>
                    <table>

                        <tr class="table_bg">
                            <th class="w-20">S.N.</th>
                            <th class="w-60">Batch No</th>
                        </tr>
                        @if ($data->iq_attachment)
                            @foreach (json_decode($data->iq_attachment) as $key => $file)
                                <tr>
                                    <td class="w-20">{{ $key + 1 }}</td>
                                    <td class="w-20"><a href="{{ asset('upload/' . $file) }}"
                                            target="_blank"><b>{{ $file }}</b></a> </td>
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
                    <div class="block-head">
                    Design Qualification (DQ)
                    </div>
                    <table>
                        <tr>
                            <th class="w-20">DQ Test Plan</th>
                            <td class="w-80">
                                @if ($data->dq_test_plan)
                                    {{ $data->dq_test_plan }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                            <th class="w-20">DQ Protocol</th>
                            <td class="w-80">
                                @if ($data->dq_protocol)
                                    {{ $data->dq_protocol }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th class="w-20">DQ Execution</th>
                            <td class="w-80">
                                @if ($data->dq_execution)
                                    {{ $data->dq_execution }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                            <th class="w-20">DQ Report</th>
                            <td class="w-80">
                                @if ($data->dq_report)
                                    {{ $data->dq_report }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>

                <div class="border-table">
                    <div class="block-head">
                        Equipment Qualification Attachment
                    </div>
                    <table>

                        <tr class="table_bg">
                            <th class="w-20">S.N.</th>
                            <th class="w-60">Batch No</th>
                        </tr>
                        @if ($data->dq_attachment)
                            @foreach (json_decode($data->dq_attachment) as $key => $file)
                                <tr>
                                    <td class="w-20">{{ $key + 1 }}</td>
                                    <td class="w-20"><a href="{{ asset('upload/' . $file) }}"
                                            target="_blank"><b>{{ $file }}</b></a> </td>
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
                    <div class="block-head">
                    Operational Qualification (OQ)
                    </div>
                    <table>
                        <tr>
                            <th class="w-20">OQ Test Plan</th>
                            <td class="w-80">
                                @if ($data->oq_test_plan)
                                    {{ $data->oq_test_plan }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                            <th class="w-20">OQ Protocol</th>
                            <td class="w-80">
                                @if ($data->oq_protocol)
                                    {{ $data->oq_protocol }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th class="w-20">OQ Execution</th>
                            <td class="w-80">
                                @if ($data->oq_execution)
                                    {{ $data->oq_execution }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                            <th class="w-20">OQ Report</th>
                            <td class="w-80">
                                @if ($data->oq_report)
                                    {{ $data->oq_report }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>

                <div class="border-table">
                    <div class="block-head">
                        Equipment Qualification Attachment
                    </div>
                    <table>

                        <tr class="table_bg">
                            <th class="w-20">S.N.</th>
                            <th class="w-60">Batch No</th>
                        </tr>
                        @if ($data->oq_attachment)
                            @foreach (json_decode($data->oq_attachment) as $key => $file)
                                <tr>
                                    <td class="w-20">{{ $key + 1 }}</td>
                                    <td class="w-20"><a href="{{ asset('upload/' . $file) }}"
                                            target="_blank"><b>{{ $file }}</b></a> </td>
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
                    <div class="block-head">
                    Performance Qualification (PQ)
                    </div>
                    <table>
                        <tr>
                            <th class="w-20">PQ Test Plan</th>
                            <td class="w-80">
                                @if ($data->pq_test_plan)
                                    {{ $data->pq_test_plan }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                            <th class="w-20">PQ Protocol</th>
                            <td class="w-80">
                                @if ($data->pq_protocol)
                                    {{ $data->pq_protocol }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th class="w-20">PQ Execution</th>
                            <td class="w-80">
                                @if ($data->pq_execution)
                                    {{ $data->pq_execution }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                            <th class="w-20">PQ Report</th>
                            <td class="w-80">
                                @if ($data->pq_report)
                                    {{ $data->pq_report }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>

                <div class="border-table">
                    <div class="block-head">
                    Equipment Qualification Attachment
                    </div>
                    <table>

                        <tr class="table_bg">
                            <th class="w-20">S.N.</th>
                            <th class="w-60">Batch No</th>
                        </tr>
                        @if ($data->pq_attachment)
                            @foreach (json_decode($data->pq_attachment) as $key => $file)
                                <tr>
                                    <td class="w-20">{{ $key + 1 }}</td>
                                    <td class="w-20"><a href="{{ asset('upload/' . $file) }}"
                                            target="_blank"><b>{{ $file }}</b></a> </td>
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


                <table>
                    <tr>
                            <th class="w-20">Migration Details</th>
                            <td class="w-80" colspan="3">
                                @if ($data->migration_details)
                                    {{ $data->migration_details }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                    </tr>
                </table>

                <div class="border-table">
                    <div class="block-head">
                    Migration Attachment
                    </div>
                    <table>

                        <tr class="table_bg">
                            <th class="w-20">S.N.</th>
                            <th class="w-60">Batch No</th>
                        </tr>
                        @if ($data->migration_attachment)
                            @foreach (json_decode($data->migration_attachment) as $key => $file)
                                <tr>
                                    <td class="w-20">{{ $key + 1 }}</td>
                                    <td class="w-20"><a href="{{ asset('upload/' . $file) }}"
                                            target="_blank"><b>{{ $file }}</b></a> </td>
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

                <table>
                    <tr>
                        <th class="w-20">Configuration Specification Details</th>
                        <td class="w-80" colspan="3">
                            @if ($data->configuration_specification_details)
                                {{ $data->configuration_specification_details }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                </table>

                <div class="border-table">
                    <div class="block-head">
                        Configuration Specification Attachment
                    </div>
                    <table>

                        <tr class="table_bg">
                            <th class="w-20">S.N.</th>
                            <th class="w-60">Batch No</th>
                        </tr>
                        @if ($data->configuration_specification_attachment)
                            @foreach (json_decode($data->configuration_specification_attachment) as $key => $file)
                                <tr>
                                    <td class="w-20">{{ $key + 1 }}</td>
                                    <td class="w-20"><a href="{{ asset('upload/' . $file) }}"
                                            target="_blank"><b>{{ $file }}</b></a> </td>
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


                <table>
                    <tr>
                        <th class="w-20">Rquirement Traceability Details</th>
                        <td class="w-80" colspan="3">
                            @if ($data->requirement_traceability_details)
                                {{ $data->requirement_traceability_details }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                </table>

                <div class="border-table">
                    <div class="block-head">
                    Requirement Traceability Attachment
                    </div>
                    <table>

                        <tr class="table_bg">
                            <th class="w-20">S.N.</th>
                            <th class="w-60">Batch No</th>
                        </tr>
                        @if ($data->requirement_traceability_attachment)
                            @foreach (json_decode($data->requirement_traceability_attachment) as $key => $file)
                                <tr>
                                    <td class="w-20">{{ $key + 1 }}</td>
                                    <td class="w-20"><a href="{{ asset('upload/' . $file) }}"
                                            target="_blank"><b>{{ $file }}</b></a> </td>
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

                <table>
                    <tr>
                        <th class="w-20">Validation Summary Report</th>
                        <td class="w-80" colspan="3">
                            @if ($data->validation_summary_report)
                                {{ $data->validation_summary_report }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                </table>

                <table>
                    <tr>
                        <th class="w-20">Periodic Qualification Pending On</th>
                        <td class="w-80">
                            @if ($data->periodic_qualification_pending_on)
                                {{ $data->periodic_qualification_pending_on }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Periodic Qualification Notification (Days)</th>
                        <td class="w-80">
                            @if ($data->periodic_qualification_notification)
                                {{ $data->periodic_qualification_notification }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                </table>


                <div class="block">
                    <div class="block-head">
                    Calibration Details
                    </div>
                    <table>
                        <tr>
                            <th class="w-20">Calibration Standard Reference</th>
                            <td class="w-80">
                                @if ($data->calibration_standard_preference)
                                    {{ $data->calibration_standard_preference }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                            <th class="w-20">Calibration Frequency</th>
                            <td class="w-80">
                                @if ($data->callibration_frequency)
                                    {{ $data->callibration_frequency }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th class="w-20">Last Calibration Date</th>
                            <td class="w-80">
                                @if ($data->last_calibration_date)
                                    {{ $data->last_calibration_date }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                            <th class="w-20">Next Calibration Date</th>
                            <td class="w-80">
                                @if ($data->next_calibration_date)
                                    {{ $data->next_calibration_date }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th class="w-20">Calibration Due Reminder</th>
                            <td class="w-80">
                                @if ($data->calibration_due_reminder)
                                    {{ $data->calibration_due_reminder }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th class="w-20">Calibration Method/Procedure</th>
                            <td class="w-80" colspan="3">
                                @if ($data->calibration_method_procedure)
                                    {{ $data->calibration_method_procedure }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>
                    </table>


                    <div class="border-table">
                        <div class="block-head">
                            Calibration Procedure Reference/Document
                        </div>
                        <table>

                            <tr class="table_bg">
                                <th class="w-20">S.N.</th>
                                <th class="w-60">Batch No</th>
                            </tr>
                            @if ($data->calibration_procedure_attach)
                                @foreach (json_decode($data->calibration_procedure_attach) as $key => $file)
                                    <tr>
                                        <td class="w-20">{{ $key + 1 }}</td>
                                        <td class="w-20"><a href="{{ asset('upload/' . $file) }}"
                                                target="_blank"><b>{{ $file }}</b></a> </td>
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

                    <table>
                        <tr>
                            <th class="w-20">Calibration Standards Used</th>
                            <td class="w-80">
                                @if ($data->calibration_used)
                                    {{ $data->calibration_used }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                            <th class="w-20">Calibration Parameters</th>
                            <td class="w-80">
                                @if ($data->calibration_parameter)
                                    {{ $data->calibration_parameter }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th class="w-20">Unscheduled or Event Based Calibration?</th>
                            <td class="w-80">
                                @if ($data->event_based_calibration)
                                    {{ $data->event_based_calibration }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th class="w-20">Reason for Unscheduled or Event Based Calibration</th>
                            <td class="w-80" colspan="3">
                                @if ($data->event_based_calibration_reason)
                                    {{ $data->event_based_calibration_reason }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th class="w-20">Event Reference No.</th>
                            <td class="w-80">
                                @if ($data->event_refernce_no)
                                    {{ $data->event_refernce_no }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                            <th class="w-20">Calibration Checklist</th>
                            <td class="w-80">
                                @if ($data->calibration_checklist)
                                    {{ $data->calibration_checklist }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th class="w-20">Calibration Results</th>
                            <td class="w-80">
                                @if ($data->calibration_result)
                                    {{ $data->calibration_result }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                            <th class="w-20">Calibration Certificate Number </th>
                            <td class="w-80">
                                @if ($data->calibration_certificate_result)
                                    {{ $data->calibration_certificate_result }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>
                    </table>

                    <div class="border-table">
                        <div class="block-head">
                        Calibration Certificate Attachment
                        </div>
                        <table>

                            <tr class="table_bg">
                                <th class="w-20">S.N.</th>
                                <th class="w-60">Batch No</th>
                            </tr>
                            @if ($data->calibration_certificate)
                                @foreach (json_decode($data->calibration_certificate) as $key => $file)
                                    <tr>
                                        <td class="w-20">{{ $key + 1 }}</td>
                                        <td class="w-20"><a href="{{ asset('upload/' . $file) }}"
                                                target="_blank"><b>{{ $file }}</b></a> </td>
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

                    <table>
                        <tr>
                            <th class="w-20">Calibrated By </th>
                            <td class="w-80">
                                @if ($data->calibrated_by)
                                    {{ $data->calibrated_by }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                            <th class="w-20">Calibration Due Alert</th>
                            <td class="w-80">
                                @if ($data->calibration_due_alert)
                                    {{ $data->calibration_due_alert }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th class="w-20">Cost of Calibration</th>
                            <td class="w-80">
                                @if ($data->calibration_cost)
                                    {{ $data->calibration_cost }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th class="w-20">Calibration Comments/Observations</th>
                            <td class="w-80" colspan="3">
                                @if ($data->calibration_comments)
                                    {{ $data->calibration_comments }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>
                    </table>

                </div>  
                <!-- ---  -------------- -->

                <div class="block">
                    <div class="block-head">
                    Calibration Details
                    </div>
                    <table>
                        <tr>
                            <th class="w-20">PM Schedule </th>
                            <td class="w-80">
                                @if ($data->pm_schedule)
                                    {{ $data->pm_schedule }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                            <th class="w-20">Last Preventive Maintenance Date</th>
                            <td class="w-80">
                                @if ($data->last_pm_date)
                                    {{ $data->last_pm_date }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th class="w-20">Next Preventive Maintenance Date </th>
                            <td class="w-80">
                                @if ($data->next_pm_date)
                                    {{ $data->next_pm_date }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                            <th class="w-20">Unscheduled or Event Based Preventive Maintenance?</th>
                            <td class="w-80">
                                @if ($data->event_based_PM)
                                    {{ $data->event_based_PM }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th class="w-20">PM Task Description</th>
                            <td class="w-80" colspan="3">
                                @if ($data->pm_task_description)
                                    {{ $data->pm_task_description }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th class="w-20">Reason for Unscheduled or Event Based Preventive Maintenance</th>
                            <td class="w-80" colspan="3">
                                @if ($data->eventbased_pm_reason)
                                    {{ $data->eventbased_pm_reason }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th class="w-20">Event Reference No.</th>
                            <td class="w-80">
                                @if ($data->PMevent_refernce_no)
                                    {{ $data->PMevent_refernce_no }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>
                    </table>

                    <div class="border-table">
                        <div class="block-head">
                        PM Procedure Reference/Document
                        </div>
                        <table>

                            <tr class="table_bg">
                                <th class="w-20">S.N.</th>
                                <th class="w-60">Batch No</th>
                            </tr>
                            @if ($data->pm_procedure_document)
                                @foreach (json_decode($data->pm_procedure_document) as $key => $file)
                                    <tr>
                                        <td class="w-20">{{ $key + 1 }}</td>
                                        <td class="w-20"><a href="{{ asset('upload/' . $file) }}"
                                                target="_blank"><b>{{ $file }}</b></a> </td>
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

                    <table>
                        <tr>
                            <th class="w-20">Performed By</th>
                            <td class="w-80">
                                @if ($data->pm_performed_by)
                                    {{ $data->pm_performed_by }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                            <th class="w-20">Parts Replaced During Maintenance</th>
                            <td class="w-80">
                                @if ($data->replaced_parts)
                                    {{ $data->replaced_parts }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th class="w-20">Maintenance Work Order Number</th>
                            <td class="w-80">
                                @if ($data->work_order_number)
                                    {{ $data->work_order_number }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                            <th class="w-20">PM Checklist</th>
                            <td class="w-80">
                                @if ($data->pm_checklist)
                                    {{ $data->pm_checklist }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th class="w-20">Emergency Maintenance Flag</th>
                            <td class="w-80">
                                @if ($data->emergency_flag_maintenance)
                                    {{ $data->emergency_flag_maintenance }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                            <th class="w-20">Cost of Maintenance</th>
                            <td class="w-80">
                                @if ($data->cost_of_maintenance)
                                    {{ $data->cost_of_maintenance }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th class="w-20">Maintenance Comments/Observations</th>
                            <td class="w-80" colspan="3">
                                @if ($data->maintenance_observation)
                                    {{ $data->maintenance_observation }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>
                    </table>

                </div>
                
                <!-- ------------- -->

                <div class="block">
                    <div class="block-head">
                    Training Details
                    </div>
                    <table>
                        <tr>
                            <th class="w-20">Training Required?</th>
                            <td class="w-80">
                                @if ($data->training_required)
                                    {{ $data->training_required }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                            <th class="w-20">Training Type</th>
                            <td class="w-80">
                                @if ($data->training_type)
                                    {{ $data->training_type }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr> 
                        <tr>
                            <th class="w-20">Training Description</th>
                            <td class="w-80" colspan="3">
                                @if ($data->trining_description)
                                    {{ $data->trining_description }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>
                    </table>

                    <div class="border-table">
                        <div class="block-head">
                        Training Attachment
                        </div>
                        <table>

                            <tr class="table_bg">
                                <th class="w-20">S.N.</th>
                                <th class="w-60">Batch No</th>
                            </tr>
                            @if ($data->training_attachment)
                                @foreach (json_decode($data->training_attachment) as $key => $file)
                                    <tr>
                                        <td class="w-20">{{ $key + 1 }}</td>
                                        <td class="w-20"><a href="{{ asset('upload/' . $file) }}"
                                                target="_blank"><b>{{ $file }}</b></a> </td>
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

                <!-- ------         -->
                <div class="block">
                    <div class="block-head">
                    Supervisor Review
                    </div>
                    <table>
                        <tr>
                            <th class="w-20">Supervisor Review Comments</th>
                            <td class="w-80" colspan="3">
                                @if ($data->supervisor_comment)
                                    {{ $data->supervisor_comment }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>
                    </table>

                    <div class="border-table">
                        <div class="block-head">
                        Supervisor Documents
                        </div>
                        <table>

                            <tr class="table_bg">
                                <th class="w-20">S.N.</th>
                                <th class="w-60">Batch No</th>
                            </tr>
                            @if ($data->Supervisor_document)
                                @foreach (json_decode($data->Supervisor_document) as $key => $file)
                                    <tr>
                                        <td class="w-20">{{ $key + 1 }}</td>
                                        <td class="w-20"><a href="{{ asset('upload/' . $file) }}"
                                                target="_blank"><b>{{ $file }}</b></a> </td>
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

                <!-- -----    -------- -->

                <div class="block">
                    <div class="block-head">
                    QA Review
                    </div>
                    <table>
                        <tr>
                            <th class="w-20">QA Review Comments</th>
                            <td class="w-80" colspan="3">
                                @if ($data->QA_comment)
                                    {{ $data->QA_comment }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>
                    </table>

                    <div class="border-table">
                        <div class="block-head">
                        QA Documents
                        </div>
                        <table>

                            <tr class="table_bg">
                                <th class="w-20">S.N.</th>
                                <th class="w-60">Batch No</th>
                            </tr>
                            @if ($data->QA_document)
                                @foreach (json_decode($data->QA_document) as $key => $file)
                                    <tr>
                                        <td class="w-20">{{ $key + 1 }}</td>
                                        <td class="w-20"><a href="{{ asset('upload/' . $file) }}"
                                                target="_blank"><b>{{ $file }}</b></a> </td>
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

                <!-- ---- --------- -->

                <div class="block">
                    <div class="block-head">
                    Equipment Retirement
                    </div>
                    <table>
                        <tr>
                            <th class="w-20">Equipment Lifecycle Stage</th>
                            <td class="w-80">
                                @if ($data->Equipment_Lifecycle_Stage)
                                    {{ $data->Equipment_Lifecycle_Stage }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                            <th class="w-20">End-of-life Date</th>
                            <td class="w-80">
                                @if ($data->End_of_life_Date)
                                    {{ $data->End_of_life_Date }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>
                        <tr>
                         <th class="w-20">Expected Useful Life</th>
                            <td class="w-80" colspan="3">
                                @if ($data->Expected_Useful_Life)
                                    {{ $data->Expected_Useful_Life }}
                                @else
                                    Not Applicable
                                @endif
                            </td> 
                        </tr>

                        <tr>
                         <th class="w-20">Decommissioning and Disposal Records</th>
                            <td class="w-80" colspan="3">
                                @if ($data->Decommissioning_and_Disposal_Records)
                                    {{ $data->Decommissioning_and_Disposal_Records }}
                                @else
                                    Not Applicable
                                @endif
                            </td> 
                        </tr>

                        <tr>
                         <th class="w-20">Replacement History</th>
                            <td class="w-80" colspan="3">
                                @if ($data->Replacement_History)
                                    {{ $data->Replacement_History }}
                                @else
                                    Not Applicable
                                @endif
                            </td> 
                        </tr>
                    </table>
                </div>

                <!-- ----------  ------ -->

                <div class="block">
                    <div class="block-head">
                        Activity log
                    </div>
                    <table>

                        <tr>
                            <th class="w-20">Submit By</th>
                            <td class="w-30">
                                @if ($data->submit_by)
                                    {{ $data->submit_by }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                            <th class="w-20">Submit On</th>
                            <td class="w-30">
                                @if ($data->submit_on)
                                    {{ Helpers::getdateFormat($data->submit_on) }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                            <th class="w-20">Submit Comment</th>
                            <td class="w-80">
                                @if ($data->submit_comments)
                                    {{ $data->submit_comments }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        <tr>

                        <tr>
                            <th class="w-20">Cancelled By</th>
                            <td class="w-30">
                                @if ($data->cancel_By)
                                    {{ $data->cancel_By }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                            <th class="w-20">Cancelled On</th>
                            <td class="w-30">
                                @if ($data->cancel_On)
                                    {{ Helpers::getdateFormat($data->cancel_On) }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                            <th class="w-20">Cancelled Comment</th>
                            <td class="w-80">
                                @if ($data->cancel_comment)
                                    {{ $data->cancel_comment }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        <tr>

                        <tr>
                            <th class="w-20">Supervisor Approval By</th>
                            <td class="w-30">
                                @if ($data->Supervisor_Approval_by)
                                    {{ $data->Supervisor_Approval_by }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                            <th class="w-20">Supervisor Approval On</th>
                            <td class="w-30">
                                @if ($data->Supervisor_Approval_on)
                                    {{ Helpers::getdateFormat($data->Supervisor_Approval_on) }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                            <th class="w-20">Supervisor Approval Comment</th>
                            <td class="w-80">
                                @if ($data->Supervisor_Approval_comment)
                                    {{ $data->Supervisor_Approval_comment }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        <tr>

                        <tr>
                            <th class="w-20">More Information Required By</th>
                            <td class="w-30">
                                @if ($data->More_Info_by)
                                    {{ $data->More_Info_by }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                            <th class="w-20">More Information Required On</th>
                            <td class="w-30">
                                @if ($data->More_Info_on)
                                    {{ Helpers::getdateFormat($data->More_Info_on) }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                            <th class="w-20">More Information Required Comment</th>
                            <td class="w-80">
                                @if ($data->More_Info_comment)
                                    {{ $data->More_Info_comment }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        <tr>

                        <tr>
                            <th class="w-20">Complete Qualification By</th>
                            <td class="w-30">
                                @if ($data->Complete_Qualification_by)
                                    {{ $data->Complete_Qualification_by }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                            <th class="w-20">Complete Qualification On</th>
                            <td class="w-30">
                                @if ($data->Complete_Qualification_on)
                                    {{ Helpers::getdateFormat($data->Complete_Qualification_on) }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                            <th class="w-20">Complete Qualification Comment</th>
                            <td class="w-80">
                                @if ($data->Complete_Qualification_comment)
                                    {{ $data->Complete_Qualification_comment }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        <tr>

                        <tr>
                            <th class="w-20">Complete Training By</th>
                            <td class="w-30">
                                @if ($data->Complete_Training_by)
                                    {{ $data->Complete_Training_by }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                            <th class="w-20">Complete Training On</th>
                            <td class="w-30">
                                @if ($data->Complete_Training_on)
                                    {{ Helpers::getdateFormat($data->Complete_Training_on) }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                            <th class="w-20">Complete Training Comment</th>
                            <td class="w-80">
                                @if ($data->Complete_Training_comment)
                                    {{ $data->Complete_Training_comment }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        <tr>

                        <tr>
                            <th class="w-20">Request More Information By</th>
                            <td class="w-30">
                                @if ($data->More_Info_by_sec_by)
                                    {{ $data->More_Info_by_sec_by }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                            <th class="w-20">Request More Information On</th>
                            <td class="w-30">
                                @if ($data->More_Info_by_sec_on)
                                    {{ Helpers::getdateFormat($data->More_Info_by_sec_on) }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                            <th class="w-20">Request More Information Comment</th>
                            <td class="w-80">
                                @if ($data->More_Info_by_sec_comment)
                                    {{ $data->More_Info_by_sec_comment }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        <tr>

                        <tr>
                            <th class="w-20">QA Approval By</th>
                            <td class="w-30">
                                @if ($data->Take_Out_of_Service_by)
                                    {{ $data->Take_Out_of_Service_by }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                            <th class="w-20">QA Approval On</th>
                            <td class="w-30">
                                @if ($data->Take_Out_of_Service_on)
                                    {{ Helpers::getdateFormat($data->Take_Out_of_Service_on) }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                            <th class="w-20">QA Approval Comment</th>
                            <td class="w-80">
                                @if ($data->Take_Out_of_Service_comment)
                                    {{ $data->Take_Out_of_Service_comment }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        <tr>

                        <tr>
                            <th class="w-20">Re-Qualification By</th>
                            <td class="w-30">
                                @if ($data->Re_Qualification_by)
                                    {{ $data->Re_Qualification_by }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                            <th class="w-20">Re-Qualification On</th>
                            <td class="w-30">
                                @if ($data->Re_Qualification_on)
                                    {{ Helpers::getdateFormat($data->Re_Qualification_on) }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                            <th class="w-20">Re-Qualification Comment</th>
                            <td class="w-80">
                                @if ($data->Re_Qualification_comment)
                                    {{ $data->Re_Qualification_comment }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        <tr>

                        <tr>
                            <th class="w-20">Take Out of Service By</th>
                            <td class="w-30">
                                @if ($data->Forward_to_Storage_by)
                                    {{ $data->Forward_to_Storage_by }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                            <th class="w-20">Take Out of Service On</th>
                            <td class="w-30">
                                @if ($data->Forward_to_Storage_on)
                                    {{ Helpers::getdateFormat($data->Forward_to_Storage_on) }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                            <th class="w-20">Take Out of Service Comment</th>
                            <td class="w-80">
                                @if ($data->Forward_to_Storage_comment)
                                    {{ $data->Forward_to_Storage_comment }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        <tr>

                        <tr>
                            <th class="w-20">Forward to Storage By</th>
                            <td class="w-30">
                                @if ($data->forword_storage_by)
                                    {{ $data->forword_storage_by }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                            <th class="w-20">Forward to Storage On</th>
                            <td class="w-30">
                                @if ($data->forword_storage_on)
                                    {{ Helpers::getdateFormat($data->forword_storage_on) }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                            <th class="w-20">Forward to Storage Comment</th>
                            <td class="w-80">
                                @if ($data->forword_storage_comment)
                                    {{ $data->forword_storage_comment }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        <tr>

                        <tr>
                            <th class="w-20">Re-Activate By</th>
                            <td class="w-30">
                                @if ($data->Re_Active_by)
                                    {{ $data->Re_Active_by }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                            <th class="w-20">Re-Activate On</th>
                            <td class="w-30">
                                @if ($data->Re_Active_on)
                                    {{ Helpers::getdateFormat($data->Re_Active_on) }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                            <th class="w-20">Re-Activate Comment</th>
                            <td class="w-80">
                                @if ($data->Re_Active_comment)
                                    {{ $data->Re_Active_comment }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        <tr>

                        <tr>
                            <th class="w-20">Re-Qualification By</th>
                            <td class="w-30">
                                @if ($data->Re_Qualification_by_sec)
                                    {{ $data->Re_Qualification_by_sec }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                            <th class="w-20">Re-Qualification On</th>
                            <td class="w-30">
                                @if ($data->Re_Qualification_on_sec)
                                    {{ Helpers::getdateFormat($data->Re_Qualification_on_sec) }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                            <th class="w-20">Re-Qualification Comment</th>
                            <td class="w-80">
                                @if ($data->Re_Qualification_comment_sec)
                                    {{ $data->Re_Qualification_comment_sec }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        <tr>

                        <tr>
                            <th class="w-20">Retire By</th>
                            <td class="w-30">
                                @if ($data->retire_by)
                                    {{ $data->retire_by }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                            <th class="w-20">Retire On</th>
                            <td class="w-30">
                                @if ($data->retire_on)
                                    {{ Helpers::getdateFormat($data->retire_on) }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                            <th class="w-20">Retire Comment</th>
                            <td class="w-80">
                                @if ($data->retire_comment)
                                    {{ $data->retire_comment }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        <tr>
                    </table>
                </div>
        

                <!-- ----- ------- -->

            </div>

      </div>
    </div>

    @if (count($Preventive_Maintenance) > 0)
        @foreach ($Preventive_Maintenance as $data)
            <center>
                <h3>Preventive Maintenance Report</h3>
            </center>

            <div class="inner-block">
                <div class="content-table">
                    <div class="block">
                        <div class="block-head">
                            General Information
                        </div>
                        <table>
                            <tr> {{ $data->created_at }} added by {{ $data->originator }}
                                <th class="w-20">Record Number</th>
                                <td class="w-80">
                                    {{ Helpers::divisionNameForQMS($data->division_id) }}/PM/{{ Helpers::year($data->created_at) }}/{{ str_pad($data->record, 4, '0', STR_PAD_LEFT) }}
                                <th class="w-20">Site/Location Code</th>
                                <td class="w-80">
                                    @if ($data->division_id)
                                        {{ Helpers::getDivisionName($data->division_id) }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th class="w-20">Initiator</th>
                                <td class="w-80">{{ Auth::user()->name }} </td>
                                <th class="w-20">Date of Initiation</th>
                                <td class="w-80">{{ Helpers::getdateFormat($data->created_at) }}</td>
                            </tr>
                            <tr>
                                <th class="w-20">Site/Location Code</th>
                                <td class="w-80">{{ $data->division ? $data->division : '-' }}</td>
        
                                <th class="w-20">Assigned To</th>
                                <td class="w-80">
                                    @isset($data->assign_to)
                                        {{ Helpers::getInitiatorName($data->assign_to) }}
                                    @else
                                        Not Applicable
                                    @endisset
        
                            </tr>
                            <tr>
                                <th class="w-20">Due Date</th>
                                <td class="w-80">
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
                                <th class="w-20">PM Schedule</th>
                                <td class="w-80">
                                    @if ($data->pm_schedule)
                                        {{ $data->pm_schedule }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                                <th class="w-20">Last Preventive Maintenance Date</th>
                                <td class="w-80">
                                    @if ($data->last_pm_date)
                                        {{ Helpers::getdateFormat($data->last_pm_date) }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                            </tr>
        
        
                            <tr>
                                <th class="w-20">PM Task Description</th>
                                <td class="w-80" colspan="3">
                                    @if ($data->pm_task_description)
                                        {{ $data->pm_task_description }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                            </tr>
        
                            <tr>
                                <th class="w-20">Unscheduled or Event Based Preventive Maintenance?</th>
                                <td class="w-80">
                                    @if ($data->event_based_PM)
                                        {{ $data->event_based_PM }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                                <th class="w-20">Next Preventive Maintenance Date</th>
                                <td class="w-80">
                                    @if ($data->next_pm_date)
                                        {{ Helpers::getdateFormat($data->next_pm_date) }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                            </tr>
        
                            <tr>
                                <th class="w-20">Reason for Unscheduled or Event Based Preventive Maintenance</th>
                                <td class="w-80" colspan="3">
                                    @if ($data->eventbased_pm_reason)
                                        {{ $data->eventbased_pm_reason }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                            </tr>
        
        
                            <tr>
                                <th class="w-20">Event Reference No.</th>
                                <td class="w-80">
                                    @if ($data->PMevent_refernce_no)
                                        {{ $data->PMevent_refernce_no }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                            </tr>
                        </table>
        
                        <div class="border-table">
                            <div class="block-head">
                                PM Procedure Reference/Document
                            </div>
                            <table>
        
                                <tr class="table_bg">
                                    <th class="w-20">S.N.</th>
                                    <th class="w-60">Batch No</th>
                                </tr>
                                @if ($data->pm_procedure_document)
                                    @foreach (json_decode($data->pm_procedure_document) as $key => $file)
                                        <tr>
                                            <td class="w-20">{{ $key + 1 }}</td>
                                            <td class="w-20"><a href="{{ asset('upload/' . $file) }}"
                                                    target="_blank"><b>{{ $file }}</b></a> </td>
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
        
                        <table>
        
                            <tr>
        
                                <th class="w-20">Maintenance Comments/Observations</th>
                                <td class="w-80" colspan="3">
                                    @if ($data->maintenance_observation)
                                        {{ $data->maintenance_observation }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                            </tr>
        
                            <tr>
        
                                <th class="w-20">Parts Replaced During Maintenance</th>
                                <td class="w-80" colspan="3">
                                    @if ($data->replaced_parts)
                                        {{ $data->replaced_parts }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                            </tr>
                            <tr>
        
                                <th class="w-20">Performed By</th>
                                <td class="w-80" colspan="3">
                                    @if ($data->pm_performed_by)
                                        {{ $data->pm_performed_by }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                            </tr>
        
                            <tr>
                                <th class="w-20">Maintenance Work Order Number</th>
                                <td class="w-80">
                                    @if ($data->work_order_number)
                                        {{ $data->work_order_number }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th class="w-20">PM Checklist</th>
                                <td class="w-80" colspan="3">
                                    @if ($data->pm_checklist)
                                        {{ $data->pm_checklist }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                            </tr>
        
                            <tr>
                                <th class="w-20">Emergency Maintenance Flag</th>
                                <td class="w-80" colspan="3">
                                    @if ($data->emergency_flag_maintenance)
                                        {{ $data->emergency_flag_maintenance }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th class="w-20">Cost of Maintenance</th>
                                <td class="w-80">
                                    @if ($data->cost_of_maintenance)
                                        {{ $data->cost_of_maintenance }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                            </tr>
        
                        </table>
                    </div>
                    <div class="block">
                        <div class="block-head">
                            Activity log
                        </div>
                        <table>
        
                            <tr>
                                <th class="w-20">Submit By</th>
                                <td class="w-30">
                                    @if ($data->submit_by)
                                        {{ $data->submit_by }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                                <th class="w-20">Submit On</th>
                                <td class="w-30">
                                    @if ($data->submit_on)
                                        {{ Helpers::getdateFormat($data->submit_on) }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                            </tr>
        
                            <tr>
                                <th class="w-20">Submit Comment</th>
                                <td class="w-80">
                                    @if ($data->submit_comments)
                                        {{ $data->submit_comments }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                            <tr>
        
                            <tr>
                                <th class="w-20">Cancelled By</th>
                                <td class="w-30">
                                    @if ($data->cancel_By)
                                        {{ $data->cancel_By }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                                <th class="w-20">Cancelled On</th>
                                <td class="w-30">
                                    @if ($data->cancel_On)
                                        {{ Helpers::getdateFormat($data->cancel_On) }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                            </tr>
        
                            <tr>
                                <th class="w-20">Cancelled Comment</th>
                                <td class="w-80">
                                    @if ($data->cancel_comment)
                                        {{ $data->cancel_comment }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                            <tr>
        
                            <tr>
                                <th class="w-20">Supervisor Approval By</th>
                                <td class="w-30">
                                    @if ($data->Supervisor_Approval_by)
                                        {{ $data->Supervisor_Approval_by }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                                <th class="w-20">Supervisor Approval On</th>
                                <td class="w-30">
                                    @if ($data->Supervisor_Approval_on)
                                        {{ Helpers::getdateFormat($data->Supervisor_Approval_on) }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                            </tr>
        
                            <tr>
                                <th class="w-20">Supervisor Approval Comment</th>
                                <td class="w-80">
                                    @if ($data->Supervisor_Approval_comment)
                                        {{ $data->Supervisor_Approval_comment }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                            <tr>
        
                            <tr>
                                <th class="w-20">Complete By</th>
                                <td class="w-30">
                                    @if ($data->Complete_by)
                                        {{ $data->Complete_by }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                                <th class="w-20">Complete On</th>
                                <td class="w-30">
                                    @if ($data->Complete_on)
                                        {{ Helpers::getdateFormat($data->Complete_on) }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                            </tr>
        
                            <tr>
                                <th class="w-20">Complete Comment</th>
                                <td class="w-80">
                                    @if ($data->Complete_comment)
                                        {{ $data->Complete_comment }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                            <tr>
        
                            <tr>
                                <th class="w-20">Additional Work Required By</th>
                                <td class="w-30">
                                    @if ($data->additional_work_by)
                                        {{ $data->additional_work_by }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                                <th class="w-20">Additional Work Required On</th>
                                <td class="w-30">
                                    @if ($data->additional_work_on)
                                        {{ Helpers::getdateFormat($data->additional_work_on) }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                            </tr>
        
                            <tr>
                                <th class="w-20">Additional Work Required Comment</th>
                                <td class="w-80">
                                    @if ($data->additional_work_comment)
                                        {{ $data->additional_work_comment }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                            <tr>
        
                            <tr>
                                <th class="w-20">QA Approval By</th>
                                <td class="w-30">
                                    @if ($data->qa_approval_by)
                                        {{ $data->qa_approval_by }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                                <th class="w-20">QA Approval On</th>
                                <td class="w-30">
                                    @if ($data->qa_approval_on)
                                        {{ Helpers::getdateFormat($data->qa_approval_on) }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                            </tr>
        
                            <tr>
                                <th class="w-20">QA Approval Comment</th>
                                <td class="w-80">
                                    @if ($data->qa_approval_comment)
                                        {{ $data->qa_approval_comment }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                            <tr>
        
                        </table>
                    </div>
                </div>
            </div>
        @endforeach
    @endif

    @if (count($Calibration_Management) > 0)
        @foreach ($Calibration_Management as $data)
            <center>
                <h3>Calibration Management Report</h3>
            </center>

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
            
        @endforeach
    @endif


    @if (count($Deviation) > 0)
    @foreach ($Deviation as $data)
    <center>
        <h3>Deviation Report</h3>
    </center>
    <div class="inner-block">
        <div class="content-table">
            <div class="block">
                <div class="block-head">
                    General Information
                </div>
                <table>
                    <tr> {{ $data->created_at }} added by {{ $data->originator }}
                        <th class="w-20">Site/Location Code</th>
                        <td class="w-30"> {{ Helpers::getDivisionName(session()->get('division')) }}</td>
                        <th class="w-20">Initiator</th>
                        <td class="w-30">{{ Helpers::getInitiatorName($data->initiator_id) }}</td>
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Date of Initiation</th>
                        {{-- <td class="w-30">@if{{ Helpers::getdateFormat($data->intiation_date) }} @else Not Applicable @endif</td> --}}
                        {{-- <td class="w-30">@if (Helpers::getdateFormat($data->intiation_date)) {{ Helpers::getdateFormat($data->intiation_date) }} @else Not Applicable @endif</td> --}}
                        <td class="w-30">{{ $data->created_at ? $data->created_at->format('d-M-Y') : '' }} </td>

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
                        <th class="w-20">Department</th>
                        <td class="w-30">
                            @if ($data->Initiator_Group)
                                {{ Helpers::getFullDepartmentName($data->Initiator_Group) }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Short Description</th>
                        <td class="w-30">
                            @if ($data->short_description)
                                {{ $data->short_description }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        {{-- <th class="w-20">Department Code</th> --}}
                        {{-- <td class="w-30">@if ($data->initiator_group_code){{ $data->initiator_group_code }} @else Not Applicable @endif</td> --}}
                    </tr>
                    <tr>
                        <th class="w-20"> Repeat Deviation?</th>
                        <td class="w-30">
                            @if ($data->short_description_required)
                                {{ $data->short_description_required }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20"> Repeat Nature</th>
                        <td class="w-30">
                            @if ($data->nature_of_repeat)
                                {{ $data->nature_of_repeat }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                    </tr>
                    <tr>
                        <th class="w-20"> Deviation Observed On</th>
                        <td class="w-30">
                            @if ($data->Deviation_date)
                                {{ \Carbon\Carbon::parse($data->Deviation_date)->format('d-M-Y')}}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20"> Deviation Observed On (Time)</th>
                        <td class="w-30">
                            @if ($data->deviation_time)
                                {{ $data->deviation_time }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                    </tr>
                    <tr>
                        <th class="w-20"> Delay Justification</th>
                        <td class="w-30">@if ($data->Delay_Justification){{ $data->Delay_Justification }} @else Not Applicable @endif</td>
                        <th class="w-20">Deviation Observed by</th>
                        {{-- @php
                            $facilityIds = explode(',', $data->Facility);
                            $users = $facilityIds ? DB::table('users')->whereIn('id', $facilityIds)->get() : [];
                        @endphp

                        <td>
                            @if ($facilityIds && count($users) > 0)
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" selected>{{ $user->name }}</option>
                                @endforeach
                            @else
                                Not Applicable
                            @endif
                        </td> --}}


                        <td class="w-30">@if ($data->Facility){{ $data->Facility }} @else Not Applicable @endif</td>

                    </tr>

                    <tr>
                        <th class="w-20">Deviation Reported On </th>
                        <td class="w-30">
                            @if ($data->Deviation_reported_date)
                                {{ \Carbon\Carbon::parse($data->Deviation_reported_date)->format('d-M-Y') }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Deviation Related To</th>
                        <td class="w-30">
                            @if ($data->audit_type)
                                {{ $data->audit_type }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>

                        <th class="w-20"> Others</th>
                        <td class="w-30">
                            @if ($data->others)
                                {{ $data->others }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Facility/ Equipment/ Instrument/ System Details Required?</th>
                        <td class="w-30">
                            @if ($data->Facility_Equipment)
                                {{ $data->Facility_Equipment }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                    </tr>
                    <tr>

                        <th class="w-20">Document Details Required?</th>
                        <td class="w-30">
                            @if ($data->Document_Details_Required)
                                {{ $data->Document_Details_Required }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Description of Deviation</th>
                        <td class="w-30">
                            @if ($data->Description_Deviation)
                                {{ strip_tags($data->Description_Deviation) }}
                            @else
                                Not Applicable
                            @endif
                        </td>


                    </tr>


                    {{-- <tr> --}}
                    {{-- <th class="w-20">Name of Product & Batch No</th> --}}
                    {{-- <td class="w-30">@if ($data->Product_Batch){{ ($data->Product_Batch) }} @else Not Applicable @endif</td> --}}
                    {{-- </tr> --}}

                    <tr>
                        <th class="w-20">Immediate Action (if any)</th>
                        <td class="w-30">
                            @if ($data->Immediate_Action)
                                {{ strip_tags($data->Immediate_Action) }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Preliminary Impact of Deviation</th>
                        <td class="w-30">
                            @if ($data->Preliminary_Impact)
                                {{strip_tags($data->Preliminary_Impact) }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
      
                    </table>
   
        
        <div class="block">
            <div class="block-head">
                Description of Deviation
         </div>
         <div class="border-table">
        <table>
                <tr class="table_bg">
                    <th class="w-20" >5W/2H</th>
                    <th class="w-80"  >Remarks</th>
                </tr>
            
                <tr>
                    <td class="w-20" style="background-color: #91b4f7;">What</td>
                    <td class="w-80" >{{$data->what}}</td>
                </tr>
                <tr>
                    <td class="w-20" style="background-color: #91b4f7;">Why</td>
                    <td class="w-80">{{$data->why_why}}</td>
                </tr>
                <tr>
                    <td class="w-20" style="background-color: #91b4f7;">Where</td>
                    <td class="w-80">{{$data->where_where}}</td>
                </tr>
                <tr>
                    <td class="w-20" style="background-color: #91b4f7;">When</td>
                    <td class="w-80">{{$data->when_when}}</td>
                </tr>
                <tr>
                    <td class="w-20" style="background-color: #91b4f7;">Who</td>
                    <td class="w-80">{{$data->who}}</td>
                </tr>
                <tr>
                    <td class="w-20" style="background-color: #91b4f7;">How</td>
                    <td class="w-80">{{$data->how}}</td>
                </tr>
                <tr>
                    <td class="w-20" style="background-color: #91b4f7;">How much</td>
                    <td class="w-80">{{$data->how_much}}</td>
                </tr>
          
        </table>
    </div>
    @endforeach
    @endif

   

    {{-- @if (!empty($ActionItem) && count($ActionItem) > 0) 
    @if (count($ActionItem) > 0)    --}}
    @if (!empty($Action_Item) && $Action_Item->count() > 0)
        @foreach ($Action_Item as $data)
            <center>
                <h3>Action Item Report</h3>
            </center>

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
                                    @if ($data->record)
                                        {{ Helpers::divisionNameForQMS($data->division_id) }}/AI/{{ Helpers::year($data->created_at) }}/{{ str_pad($data->record, 4, '0', STR_PAD_LEFT) }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                                <th class="w-20">Division Code</th>
                                <td class="w-30">
                                    @if ($data->division_id)
                                        {{ Helpers::getDivisionName($data->division_id) }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                            </tr>
        
                            <tr> {{ $data->created_at }} added by {{ $data->originator }}
                                <th class="w-20">Initiator</th>
                                <td class="w-30">{{ Helpers::getInitiatorName($data->initiator_id) }}</td>
                                <th class="w-20">Date of Initiation</th>
                                <td class="w-30">{{ Helpers::getdateFormat($data->created_at) }}</td>
                            </tr>
        
                            <tr>
                                <th class="w-20">Parent Record Number</th>
                                <td class="w-30">
                                    @if ($data->parent_record_number)
                                        {{ $data->parent_record_number }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                                <th class="w-20">Assigned To</th>
                                <td class="w-30">
                                    @if ($data->assign_to)
                                        {{ Helpers::getInitiatorName($data->assign_to) }}
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
                                <th class="w-20">Priority</th>
                                <td class="w-30">
                                    @if ($data->priority_data)
                                        {{ $data->priority_data }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                            </tr>
                        </table>
        
                        <label class="head-number" for="Short Description">Short Description</label>
                        <div class="div-data">
                            @if ($data->short_description)
                                {{ $data->short_description }}
                            @else
                                Not Applicable
                            @endif
                        </div>
        
                        <label class="head-number" for="Action Item Related Records">Action Item Related Records</label>
                        <div class="div-data">
                            @if ($data->Reference_Recores1)
                                {{ str_replace(',', ', ', $data->Reference_Recores1) }}
                            @else
                                Not Applicable
                            @endif
                        </div>
        
                        <table>
                            <tr>
                                <th class="w-20">HOD Persons</th>
                                <td class="w-80">
                                    @if ($data->hod_preson)
                                        {{ $data->hod_preson }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                            </tr>
                        </table>
        
                        <table>
                            <tr>
                                <th class="w-20">Responsible Department</th>
                                <td class="w-80">
                                    @if ($data->departments)
                                        {{ Helpers::getFullDepartmentName($data->departments) }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                            </tr>
                        </table>
        
                        <label class="head-number" for="Description">Description</label>
                        <div class="div-data">
                            @if ($data->description)
                                {{ $data->description }}
                            @else
                                Not Applicable
                            @endif
                        </div>
        
                        <div class="block-head">
                            File Attachments
                        </div>
                        <div class="border-table">
                            <table>
                                <tr class="table_bg">
                                    <th class="w-20">S.N.</th>
                                    <th class="w-60">File</th>
                                </tr>
                                @if ($data->file_attach)
                                    @php $files = json_decode($data->file_attach); @endphp
                                    @if (count($files) > 0)
                                        @foreach ($files as $key => $file)
                                            <tr>
                                                <td class="w-20">{{ $key + 1 }}</td>
                                                <td class="w-60"><a href="{{ asset('upload/' . $file) }}"
                                                        target="_blank"><b>{{ $file }}</b></a></td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td class="w-20">1</td>
                                            <td class="w-60">Not Applicable</td>
                                        </tr>
                                    @endif
                                @else
                                    <tr>
                                        <td class="w-20">1</td>
                                        <td class="w-60">Not Applicable</td>
                                    </tr>
                                @endif
                            </table>
                        </div>
        
                    </div>
        
                    <div class="block">
                        <div class="block-head">
                            Post Completion
                        </div>
        
                        <label class="head-number" for="Action Taken">Action Taken</label>
                        <div class="div-data">
                            @if ($data->action_taken)
                                {{ $data->action_taken }}
                            @else
                                Not Applicable
                            @endif
                        </div>
                        <table>
                            <tr>
                                <th class="w-20">Action Start Date</th>
                                <td class="w-30">
                                    @if ($data->start_date)
                                        {{ Helpers::getdateFormat($data->start_date) }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                                <th class="w-20">Actual End Date</th>
                                <td class="w-30">
                                    @if ($data->end_date)
                                        {{ Helpers::getdateFormat($data->end_date) }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                            </tr>
                        </table>
        
                        <label class="head-number" for="Comments">Comments</label>
                        <div class="div-data">
                            @if ($data->comments)
                                {{ $data->comments }}
                            @else
                                Not Applicable
                            @endif
                        </div>
        
        
                        <div class="block-head">
                            Completion Attachments
                        </div>
                        <div class="border-table">
                            <table>
                                <tr class="table_bg">
                                    <th class="w-20">S.N.</th>
                                    <th class="w-60">File</th>
                                </tr>
                                @if ($data->Support_doc)
                                    @php $files = json_decode($data->Support_doc); @endphp
                                    @if (count($files) > 0)
                                        @foreach ($files as $key => $file)
                                            <tr>
                                                <td class="w-20">{{ $key + 1 }}</td>
                                                <td class="w-60"><a href="{{ asset('upload/' . $file) }}"
                                                        target="_blank"><b>{{ $file }}</b></a></td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td class="w-20">1</td>
                                            <td class="w-60">Not Applicable</td>
                                        </tr>
                                    @endif
                                @else
                                    <tr>
                                        <td class="w-20">1</td>
                                        <td class="w-60">Not Applicable</td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                    </div>
        
                    <div class="block">
                        <div class="block-head">
                            Action Approval
                        </div>
        
                        <label class="head-number" for="QA Review Comments">QA Review Comments</label>
                        <div class="div-data">
                            @if ($data->qa_comments)
                                {{ $data->qa_comments }}
                            @else
                                Not Applicable
                            @endif
                        </div>
        
                    </div>
        
                    <div class="block">
                        <div class="block-head">
                            Extension Justification
                        </div>
                        <table>
                            <tr>
                                <th class="w-20">Due Date Extension Justification</th>
                                <td class="w-80">
                                    @if ($data->due_date_extension)
                                        {{ $data->due_date_extension }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                            </tr>
                        </table>
        
                        <div class="block-head">
                            Action Approval Attachment
                        </div>
                        <div class="border-table">
                            <table>
                                <tr class="table_bg">
                                    <th class="w-20">S.N.</th>
                                    <th class="w-60">File</th>
                                </tr>
                                @if ($data->final_attach)
                                    @php $files = json_decode($data->final_attach); @endphp
                                    @if (count($files) > 0)
                                        @foreach ($files as $key => $file)
                                            <tr>
                                                <td class="w-20">{{ $key + 1 }}</td>
                                                <td class="w-60"><a href="{{ asset('upload/' . $file) }}"
                                                        target="_blank"><b>{{ $file }}</b></a></td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td class="w-20">1</td>
                                            <td class="w-60">Not Applicable</td>
                                        </tr>
                                    @endif
                                @else
                                    <tr>
                                        <td class="w-20">1</td>
                                        <td class="w-60">Not Applicable</td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                    </div>
        
                    <div class="block" style="margin-top: 15px;">
                        <div class="block-head">
                            Activity Log
                        </div>
                        <table>
                            <tr>
                                <th class="w-20">Submitted By</th>
                                <td class="w-80">{{ $data->submitted_by }}</td>
                                <th class="w-20">Submitted On</th>
                                <td class="w-80">{{ $data->submitted_on }}</td>
                                <th class="w-20">Submitted Comment</th>
                                <td class="w-80">{{ $data->submitted_comment }}</td>
                            </tr>
        
        
                            <tr>
                                <th class="w-20">Cancelled By</th>
                                <td class="w-80">{{ $data->cancelled_by }}</td>
                                <th class="w-20">Cancelled On</th>
                                <td class="w-80">{{ $data->cancelled_on }}</td>
                                <th class="w-20">Cancelled Comment</th>
                                <td class="w-80">{{ $data->cancelled_comment }}</td>
                            </tr>
        
                            <tr>
                                <th class="w-20">Acknowledge By</th>
                                <td class="w-80">{{ $data->acknowledgement_by }}</td>
                                <th class="w-20">Acknowledge On</th>
                                <td class="w-80">{{ $data->acknowledgement_on }}</td>
                                <th class="w-20">Acknowledge Comment</th>
                                <td class="w-80">{{ $data->acknowledgement_comment }}</td>
                            </tr>
        
                            <tr>
                                <th class="w-20">Work Completion By</th>
                                <td class="w-80">{{ $data->work_completion_by }}</td>
                                <th class="w-20">Work Completion On</th>
                                <td class="w-80">{{ $data->work_completion_on }}</td>
                                <th class="w-20">Work Completion Comment</th>
                                <td class="w-80">{{ $data->work_completion_comment }}</td>
                            </tr>
        
                            <tr>
                                <th class="w-20">QA/CQA Verification By</th>
                                <td class="w-80">{{ $data->qa_varification_by }}</td>
                                <th class="w-20">QA/CQA Verification On</th>
                                <td class="w-80">{{ $data->qa_varification_on }}</td>
                                <th class="w-20">QA/CQA Verification Comment</th>
                                <td class="w-80">{{ $data->qa_varification_comment }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        @endforeach
    @endif

   

    @if (count($Change_Control) > 0)
        @foreach ($Change_Control as $data)
            <center>
                <h3>Change Control Report</h3>
            </center>

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
                            {{ Helpers::getDivisionName($data->division_id) }}/CC/{{ date('Y') }}/{{ $data->record ? str_pad($data->record, 4, '0', STR_PAD_LEFT) : '' }}
                        </td>
                        <th class="w-20">Division Code</th>
                        <td class="w-30">{{ Helpers::getDivisionName($data->division_id) }}</td>
                    </tr>
                    <tr> On {{ Helpers::getDateFormat($data->created_at) }} added by {{ $data->originator }}
                        <th class="w-20">Initiator</th>
                        <td class="w-30">{{ $data->originator }}</td>
                        <th class="w-20">Date Initiation</th>
                        <td class="w-30">{{ Helpers::getDateFormat($data->intiation_date) }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Due Date</th>
                        <td class="w-30">
                            @if ($data->due_date)
                                {{ $data->due_date }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Initiaton Department</th>
                        <td class="w-30">
                            @if ($data->Initiator_Group)
                                {{ Helpers::getFullDepartmentName($data->Initiator_Group) }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">Initiation Department Code</th>
                        <td class="w-30">
                            @if ($data->initiator_group_code)
                                {{ $data->initiator_group_code }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Risk Assessment Required</th>
                        <td class="w-30">
                            @if ($data->risk_assessment_required)
                                {{ $data->risk_assessment_required }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                </table>

                <label class="head-number" for="Justification">Justification</label>
                <div class="div-data">
                    @if ($data->risk_identification)
                        {{ $data->risk_identification }}
                    @else
                        Not Applicable
                    @endif
                </div>

                <table>
                    <tr>
                        <th class="w-20">HOD Person</th>
                        <td class="w-80">
                            @if ($data->hod_person)
                                {{ Helpers::getInitiatorName($data->hod_person) }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                </table>

                <label class="head-number" for="Short Description">Short Description</label>
                <div class="div-data">
                    @if ($data->short_description)
                        {{ $data->short_description }}
                    @else
                        Not Applicable
                    @endif
                </div>


                {{-- <table>
                    <tr>
                        <th class="w-20">Type Of Change</th>
                        <td class="w-80">
                            @if ($data->type_of_change)
                                {{ $data->type_of_change }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                </table> --}}

                {{-- <label class="head-number" for="Validation Requirement">Validation Requirement</label>
                <div class="div-data">
                    @if ($fields->validation_requirment)
                        {{ $fields->validation_requirment }}
                    @else
                        Not Applicable
                    @endif
                </div> --}}
                <label class="head-number" for="Validation Requirement">Validation Requirement</label>
                    <div class="div-data">
                        @if (!is_null($fields) && $fields->validation_requirment)
                            {{ $fields->validation_requirment }}
                        @else
                            Not Applicable
                        @endif
                    </div>

                <table>
                    <tr>
                        <th class="w-20">Product/Material</th>
                        <td class="w-80">
                            @if ($data->product_name)
                                {{ $data->product_name }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <th class="w-20">Priority</th>
                        <td class="w-30">
                            @if ($data->priority_data)
                                {{ $data->priority_data }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">Change Related To</th>
                        <td class="w-30">
                            @if ($data->severity)
                                {{ $data->severity }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                </table>

                <label class="head-number" for="Please specify">Please specify</label>
                <div class="div-data">
                    @if ($data->Occurance)
                        {{ $data->Occurance }}
                    @else
                        Not Applicable
                    @endif
                </div>


                <table>
                    <tr>
                        <th class="w-20">Initiated Through</th>
                        <td class="w-80">
                            @if ($data->initiated_through)
                                {{ $data->initiated_through }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                </table>

                <label class="head-number" for="Others">Others</label>
                <div class="div-data">
                    @if ($data->initiated_through_req)
                        {{ $data->initiated_through_req }}
                    @else
                        Not Applicable
                    @endif
                </div>

                <table>
                    <tr>
                        <th class="w-20">Repeat</th>
                        <td class="w-30">
                            @if ($data->repeat)
                                {{ $data->repeat }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                </table>

                <label class="head-number" for="Repeat Nature">Repeat Nature</label>
                <div class="div-data">
                    @if ($data->repeat_nature)
                        {{ $data->repeat_nature }}
                    @else
                        Not Applicable
                    @endif
                </div>

                <table>
                    <tr>
                        <th class="w-20">Nature of Change</th>
                        <td class="w-30">
                            @if ($data->doc_change)
                                {{ $data->doc_change }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                </table>

                <label class="head-number" for="If Others">If Others</label>
                <div class="div-data">
                    @if ($data->If_Others)
                        {{ $data->If_Others }}
                    @else
                        Not Applicable
                    @endif
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
                        @if ($data->in_attachment)
                            @foreach (json_decode($data->in_attachment) as $key => $file)
                                <tr>
                                    <td class="w-20">{{ $key + 1 }}</td>
                                    <td class="w-20"><a href="{{ asset('upload/' . $file) }}"
                                            target="_blank"><b>{{ $file }}</b></a> </td>
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

              <div class="block">
                <div class="block-head">
                    Risk Assessment
                </div>

                <label class="head-number" for="Related Records">Related Records</label>
                <div class="div-data">
                    @if ($data->risk_assessment_related_record)
                        {{ str_replace(',', ', ', $data->risk_assessment_related_record) }}
                    @else
                        Not Applicable
                    @endif
                </div>

                <table>
                    <tr>
                        <th class="w-20">comments</th>
                        <td class="w-80" colspan="3">
                            @if ($data->migration_action)
                                {{ $data->migration_action }}
                            @else
                                Not Applicable
                            @endif

                        </td>
                    </tr>
                </table>

                <div class="border-table">
                    <div class="block-head">
                        Risk Assessment Attachment
                    </div>
                    <table>

                        <tr class="table_bg">
                            <th class="w-20">S.N.</th>
                            <th class="w-60">Attachment</th>
                        </tr>
                        @if ($data->risk_assessment_atch)
                            @foreach (json_decode($data->risk_assessment_atch) as $key => $file)
                                <tr>
                                    <td class="w-20">{{ $key + 1 }}</td>
                                    <td class="w-20"><a href="{{ asset('upload/' . $file) }}"
                                            target="_blank"><b>{{ $file }}</b></a> </td>
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

            <div class="block">
                <div class="block-head">
                    Initial HOD Review
                </div>

                <label class="head-number" for="HOD Assessment Comments">HOD Assessment Comments</label>
                <div class="div-data">
                    @if (!is_null($cc_cfts) && $cc_cfts->hod_assessment_comments)
                        {{ $cc_cfts->hod_assessment_comments }}
                    @else
                        Not Applicable
                    @endif
                </div>
                

                <div class="border-table">
                    <div class="block-head">
                        HOD Assessment Attachments
                    </div>
                    <table>

                        <tr class="table_bg">
                            <th class="w-20">S.N.</th>
                            <th class="w-60">Attachment</th>
                        </tr>
                        {{-- @if ($cc_cfts->hod_assessment_attachment)
                            @foreach (json_decode($cc_cfts->hod_assessment_attachment) as $key => $file)
                                <tr>
                                    <td class="w-20">{{ $key + 1 }}</td>
                                    <td class="w-20"><a href="{{ asset('upload/' . $file) }}"
                                            target="_blank"><b>{{ $file }}</b></a> </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td class="w-20">1</td>
                                <td class="w-20">Not Applicable</td>
                            </tr>
                        @endif --}}
                        @if (!is_null($cc_cfts) && $cc_cfts->hod_assessment_attachment)
                            @foreach (json_decode($cc_cfts->hod_assessment_attachment) as $key => $file)
                                <tr>
                                    <td class="w-20">{{ $key + 1 }}</td>
                                    <td class="w-20">
                                        <a href="{{ asset('upload/' . $file) }}" target="_blank"><b>{{ $file }}</b></a>
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

            <div class="block">
                <div class="block-head">
                    Change Details
                </div>

                <label class="head-number" for="Current Practice">Current Practice</label>
                <div class="div-data">
                    @if (!is_null($docdetail) && $docdetail->current_practice)
                        {{ $docdetail->current_practice }}
                    @else
                        Not Applicable
                    @endif
                </div>
                

                <label class="head-number" for="Proposed Change">Proposed Change</label>
                <div class="div-data">
                    @if (!is_null($docdetail) && $docdetail->proposed_change)
                        {{ $docdetail->proposed_change }}
                    @else
                        Not Applicable
                    @endif
                </div>
                
                <label class="head-number" for="Reason For Change">Reason For Change</label>
                <div class="div-data">
                    @if (!is_null($docdetail) && $docdetail->reason_change)
                        {{ $docdetail->reason_change }}
                    @else
                        Not Applicable
                    @endif
                </div>
                
                <label class="head-number" for="Any Other Comments">Any Other Comments</label>
                <div class="div-data">
                    @if (!is_null($docdetail) && $docdetail->other_comment)
                        {{ $docdetail->other_comment }}
                    @else
                        Not Applicable
                    @endif
                </div>
                

            </div>

            <div class="block">
                <div class="block-head">
                    QA/CQA Review
                </div>
                <table>

                    <tr>
                        {{-- <th class="w-20">CFT Reviewer Person</th>
                            <td class="w-30">{{ $data->due_days }}</td> --}}


                        <th class="w-20">Classification of Change</th>
                        <td class="w-80">
                            @if ($data->severity_level1)
                                {{ $data->severity_level1 }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                </table>

                <label class="head-number" for="QA Initial Review Comments">QA Initial Review Comments</label>
                <div class="div-data">
                    @if (!is_null($review) && $review->qa_comments)
                        {{ $review->qa_comments }}
                    @else
                        Not Applicable
                    @endif
                </div>
                

                <label class="head-number" for="Related Records">Related Records</label>
                <div class="div-data">
                    @if ($data->related_records)
                        {{ $data->initiated_if_other }}
                        {{ str_replace(',', ', ', $data->related_records) }}
                    @else
                        Not Applicable
                    @endif
                </div>


                {{-- <tr>
                            <th class="w-20">Related Records</th>
                            <td class="w-80">
                                {{ Helpers::getDivisionName($data->division_id) }}/CC/{{ date('Y') }}/{{ str_pad($review->related_records, 4, '0', STR_PAD_LEFT) }}
                            </td>
                        </tr> --}}

                <div class="border-table">
                    <div class="block-head">
                        QA Attachments
                    </div>
                    <table>

                        <tr class="table_bg">
                            <th class="w-20">S.N.</th>
                            <th class="w-60">Attachment</th>
                        </tr>
                        @if ($data->qa_head)
                            @foreach (json_decode($data->qa_head) as $key => $file)
                                <tr>
                                    <td class="w-20">{{ $key + 1 }}</td>
                                    <td class="w-20"><a href="{{ asset('upload/' . $file) }}"
                                            target="_blank"><b>{{ $file }}</b></a> </td>
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

            <div class="block">
                <div class="head">
                    <div class="block-head">
                        CFT
                    </div>
                </div>
            </div>

            <div class="head">
                <div class="block-head">
                    Production
                </div>
                <table>
                    <tr>
                        <th class="w-20">Production Required ?
                        </th>
                        <td class="w-30">
                            <div>
                                @if (!is_null($cftData) && $cftData->Production_Review)
                                    {{ $cftData->Production_Review }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </td>
                        
                        <th class="w-20">Production Person</th>
                        <td class="w-30">
                            <div>
                                @if (!is_null($cftData) && $cftData->Production_person)
                                    {{ Helpers::getInitiatorName($cftData->Production_person) }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </td>
                        
                    </tr>
                    <tr>
                        <th class="w-20">Impact Assessment (By Production)</th>
                        <td class="w-30">
                            <div>
                                @if (!is_null($cftData) && $cftData->Production_assessment)
                                    {{ $cftData->Production_assessment }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </td>
                        
                        <th class="w-20">Production Feedback</th>
                        <td class="w-30">
                            <div>
                                @if (!is_null($cftData) && $cftData->Production_feedback)
                                    {{ $cftData->Production_feedback }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </td>
                        
                    </tr>
                    <tr>
                        <th class="w-20">Production Completed By</th>
                        <td class="w-30">
                            <div>
                                @if (!is_null($cftData) && $cftData->Production_by)
                                    {{ $cftData->Production_by }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </td>
                        
                        <th class="w-20">Production Completed On</th>
                        <td class="w-30">
                            <div>
                                @if (!is_null($cftData) && $cftData->production_on)
                                    {{ $cftData->production_on }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </td>
                        
                    </tr>
                </table>
            </div>
            <div class="border-table">
                <div class="block-head">
                    Production Attachments
                </div>
                <table>

                    <tr class="table_bg">
                        <th class="w-20">S.N.</th>
                        <th class="w-60">Attachment</th>
                    </tr>
                    @if (!is_null($cftData) && $cftData->production_attachment)
                    @foreach (json_decode($cftData->production_attachment) as $key => $file)
                        <tr>
                            <td class="w-20">{{ $key + 1 }}</td>
                            <td class="w-20"><a href="{{ asset('upload/' . $file) }}" target="_blank"><b>{{ $file }}</b></a></td>
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
                <div class="head">
                    <div class="block-head">
                        Quality Control
                    </div>
                    <table>

                        <tr>
                            <th class="w-20">Quality Control Review Required ?</th>
                            <td class="w-30">
                                <div>
                                    @if (!is_null($cftData) && $cftData->Quality_review)
                                        {{ $cftData->Quality_review }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                            <th class="w-20">Quality Control Person</th>
                            <td class="w-30">
                                <div>
                                    @if (!is_null($cftData) && $cftData->Quality_Control_Person)
                                        {{ $cftData->Quality_Control_Person }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                        </tr>
                        
                        <tr>
                            <th class="w-20">Impact Assessment (By Quality Control)</th>
                            <td class="w-30">
                                <div>
                                    @if (!is_null($cftData) && $cftData->Quality_Control_assessment)
                                        {{ $cftData->Quality_Control_assessment }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                            <th class="w-20">Quality Control Feedback</th>
                            <td class="w-30">
                                <div>
                                    @if (!is_null($cftData) && $cftData->Quality_Control_feedback)
                                        {{ $cftData->Quality_Control_feedback }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                        </tr>
                        
                        <tr>
                            <th class="w-20">Quality Review Completed By</th>
                            <td class="w-30">
                                <div>
                                    @if (!is_null($cftData) && $cftData->Quality_Control_by)
                                        {{ $cftData->Quality_Control_by }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                            <th class="w-20">Quality Review Completed On</th>
                            <td class="w-30">
                                <div>
                                    @if (!is_null($cftData) && $cftData->Quality_Control_on)
                                        {{ $cftData->Quality_Control_on }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                        </tr>
                        
                    </table>
                </div>
                <div class="border-table">
                    <div class="block-head">
                        Quality Control Attachments
                    </div>
                    <table>

                        <tr class="table_bg">
                            <th class="w-20">S.N.</th>
                            <th class="w-60">Attachment</th>
                        </tr>
                        @if (!is_null($cftData) && $cftData->Quality_Control_attachment)
                        @foreach (json_decode($cftData->Quality_Control_attachment) as $key => $file)
                            <tr>
                                <td class="w-20">{{ $key + 1 }}</td>
                                <td class="w-20"><a href="{{ asset('upload/' . $file) }}" target="_blank"><b>{{ $file }}</b></a></td>
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


            <div class="block">
                <div class="head">
                    <div class="block-head">
                        Warehouse
                    </div>
                    <table>

                        <tr>
                            <th class="w-20">Warehouse Review Required ?</th>
                            <td class="w-30">
                                <div>
                                    @if (!is_null($cftData) && $cftData->Warehouse_review)
                                        {{ $cftData->Warehouse_review }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                            <th class="w-20">Warehouse Person</th>
                            <td class="w-30">
                                <div>
                                    @if (!is_null($cftData) && $cftData->Warehouse_person)
                                        {{ $cftData->Warehouse_person }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                        </tr>
                        
                        <tr>
                            <th class="w-20">Impact Assessment (By Warehouse)</th>
                            <td class="w-30">
                                <div>
                                    @if (!is_null($cftData) && $cftData->Warehouse_assessment)
                                        {{ $cftData->Warehouse_assessment }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                            <th class="w-20">Warehouse Feedback</th>
                            <td class="w-30">
                                <div>
                                    @if (!is_null($cftData) && $cftData->Warehouse_feedback)
                                        {{ $cftData->Warehouse_feedback }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                        </tr>
                        
                        <tr>
                            <th class="w-20">Warehouse Review Completed By</th>
                            <td class="w-30">
                                <div>
                                    @if (!is_null($cftData) && $cftData->Warehouse_by)
                                        {{ $cftData->Warehouse_by }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                            <th class="w-20">Warehouse Review Completed On</th>
                            <td class="w-30">
                                <div>
                                    @if (!is_null($cftData) && $cftData->Warehouse_on)
                                        {{ $cftData->Warehouse_on }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                        </tr>
                        
                    </table>
                </div>
                <div class="border-table">
                    <div class="block-head">
                        Warehouse Attachments
                    </div>
                    <table>

                        <tr class="table_bg">
                            <th class="w-20">S.N.</th>
                            <th class="w-60">Attachment</th>
                        </tr>
                        @if (!is_null($cftData) && $cftData->Warehouse_attachment)
                        @foreach (json_decode($cftData->Warehouse_attachment) as $key => $file)
                            <tr>
                                <td class="w-20">{{ $key + 1 }}</td>
                                <td class="w-20"><a href="{{ asset('upload/' . $file) }}" target="_blank"><b>{{ $file }}</b></a></td>
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

            <div class="block">
                <div class="head">
                    <div class="block-head">
                        Engineering
                    </div>
                    <table>
                        <tr>
                            <th class="w-20">Engineering Review Required ?</th>
                            <td class="w-30">
                                <div>
                                    @if (!is_null($cftData) && $cftData->Engineering_review)
                                        {{ $cftData->Engineering_review }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                            <th class="w-20">Engineering Person</th>
                            <td class="w-30">
                                <div>
                                    @if (!is_null($cftData) && $cftData->Engineering_person)
                                        {{ $cftData->Engineering_person }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                        </tr>
                        
                        <tr>
                            <th class="w-20">Impact Assessment (By Engineering)</th>
                            <td class="w-30">
                                <div>
                                    @if (!is_null($cftData) && $cftData->Engineering_assessment)
                                        {{ $cftData->Engineering_assessment }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                            <th class="w-20">Engineering Feedback</th>
                            <td class="w-30">
                                <div>
                                    @if (!is_null($cftData) && $cftData->Engineering_feedback)
                                        {{ $cftData->Engineering_feedback }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                        </tr>
                        
                        <tr>
                            <th class="w-20">Engineering Review Completed By</th>
                            <td class="w-30">
                                <div>
                                    @if (!is_null($cftData) && $cftData->Engineering_by)
                                        {{ $cftData->Engineering_by }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                            <th class="w-20">Engineering Review Completed On</th>
                            <td class="w-30">
                                <div>
                                    @if (!is_null($cftData) && $cftData->Engineering_on)
                                        {{ $cftData->Engineering_on }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                        </tr>
                        
                    </table>
                </div>
                <div class="border-table">
                    <div class="block-head">
                        Engineering Attachments
                    </div>
                    <table>

                        <tr class="table_bg">
                            <th class="w-20">S.N.</th>
                            <th class="w-60">Attachment</th>
                        </tr>
                        @if (!is_null($cftData) && $cftData->Engineering_attachment)
                        @foreach (json_decode($cftData->Engineering_attachment) as $key => $file)
                            <tr>
                                <td class="w-20">{{ $key + 1 }}</td>
                                <td class="w-20"><a href="{{ asset('upload/' . $file) }}" target="_blank"><b>{{ $file }}</b></a></td>
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

            <div class="head">
                <div class="block-head">
                    Research & Development
                </div>
                <table>
                    <tr>
                        <th class="w-20">Research & Development Required ?</th>
                        <td class="w-30">
                            <div>
                                @if (!is_null($cftData) && $cftData->ResearchDevelopment_Review)
                                    {{ $cftData->ResearchDevelopment_Review }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </td>
                        <th class="w-20">Research & Development Person</th>
                        <td class="w-30">
                            <div>
                                @if (!is_null($cftData) && $cftData->ResearchDevelopment_person)
                                    {{ $cftData->ResearchDevelopment_person }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </td>
                    </tr>
                    
                    <tr>
                        <th class="w-20">Impact Assessment (By Research & Development)</th>
                        <td class="w-30">
                            <div>
                                @if (!is_null($cftData) && $cftData->ResearchDevelopment_assessment)
                                    {{ $cftData->ResearchDevelopment_assessment }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </td>
                        <th class="w-20">Research & Development Feedback</th>
                        <td class="w-30">
                            <div>
                                @if (!is_null($cftData) && $cftData->ResearchDevelopment_feedback)
                                    {{ $cftData->ResearchDevelopment_feedback }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </td>
                    </tr>
                    
                    <tr>
                        <th class="w-20">Research & Development Completed By</th>
                        <td class="w-30">
                            <div>
                                @if (!is_null($cftData) && $cftData->ResearchDevelopment_by)
                                    {{ $cftData->ResearchDevelopment_by }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </td>
                        <th class="w-20">Research & Development Completed On</th>
                        <td class="w-30">
                            <div>
                                @if (!is_null($cftData) && $cftData->ResearchDevelopment_on)
                                    {{ $cftData->ResearchDevelopment_on }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </td>
                    </tr>
                    
                </table>
            </div>
            <div class="border-table">
                <div class="block-head">
                    Research & Development Attachments
                </div>
                <table>

                    <tr class="table_bg">
                        <th class="w-20">S.N.</th>
                        <th class="w-60">Attachment</th>
                    </tr>
                    @if (!is_null($cftData) && $cftData->ResearchDevelopment_attachment)
                    @foreach (json_decode($cftData->ResearchDevelopment_attachment) as $key => $file)
                        <tr>
                            <td class="w-20">{{ $key + 1 }}</td>
                            <td class="w-20"><a href="{{ asset('upload/' . $file) }}" target="_blank"><b>{{ $file }}</b></a></td>
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

            
            <div class="head">
                <div class="block-head">
                    Regulatory Affairs
                </div>
                <table>
                    <tr>
                        <th class="w-20">Regulatory Affairs Required ?</th>
                        <td class="w-30">
                            <div>
                                @if (!is_null($cftData) && !is_null($cftData->RegulatoryAffair_Review))
                                    {{ $cftData->RegulatoryAffair_Review }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </td>
                        <th class="w-20">Regulatory Affairs Person</th>
                        <td class="w-30">
                            <div>
                                @if (!is_null($cftData) && !is_null($cftData->RegulatoryAffair_person))
                                    {{ $cftData->RegulatoryAffair_person }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </td>
                    </tr>
                    
                    <tr>
                        <th class="w-20">Impact Assessment (By Regulatory Affairs)</th>
                        <td class="w-30">
                            <div>
                                @if (!is_null($cftData) && !is_null($cftData->RegulatoryAffair_assessment))
                                    {{ $cftData->RegulatoryAffair_assessment }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </td>
                        <th class="w-20">Regulatory Affairs Feedback</th>
                        <td class="w-30">
                            <div>
                                @if (!is_null($cftData) && !is_null($cftData->RegulatoryAffair_feedback))
                                    {{ $cftData->RegulatoryAffair_feedback }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </td>
                    </tr>
                    
                    <tr>
                        <th class="w-20">Regulatory Affairs Completed By</th>
                        <td class="w-30">
                            <div>
                                @if (!is_null($cftData) && !is_null($cftData->RegulatoryAffair_by))
                                    {{ $cftData->RegulatoryAffair_by }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </td>
                        <th class="w-20">Regulatory Affairs Completed On</th>
                        <td class="w-30">
                            <div>
                                @if (!is_null($cftData) && !is_null($cftData->RegulatoryAffair_on))
                                    {{ $cftData->RegulatoryAffair_on }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </td>
                    </tr>
                    
                </table>
            </div>
            <div class="border-table">
                <div class="block-head">
                    Regulatory Affairs Attachments
                </div>
                <table>

                    <tr class="table_bg">
                        <th class="w-20">S.N.</th>
                        <th class="w-60">Attachment</th>
                    </tr>
                    @if (!is_null($cftData) && $cftData->RegulatoryAffair_attachment)
                    @foreach (json_decode($cftData->RegulatoryAffair_attachment) as $key => $file)
                        <tr>
                            <td class="w-20">{{ $key + 1 }}</td>
                            <td class="w-20"><a href="{{ asset('upload/' . $file) }}" target="_blank"><b>{{ $file }}</b></a></td>
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

            
            <div class="head">
                <div class="block-head">
                    Corporate Quality Assurance
                </div>
                <table>
                    <tr>
                        <th class="w-20">Corporate Quality Assurance Required ?</th>
                        <td class="w-30">
                            <div>
                                @if (!is_null($cftData) && $cftData->CQA_Review)
                                    {{ $cftData->CQA_Review }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </td>
                        <th class="w-20">Corporate Quality Assurance Person</th>
                        <td class="w-30">
                            <div>
                                @if (!is_null($cftData) && $cftData->CQA_person)
                                    {{ $cftData->CQA_person }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </td>
                    </tr>
                    
                    <tr>
                        <th class="w-20">Impact Assessment (By Corporate Quality Assurance)</th>
                        <td class="w-30">
                            <div>
                                @if (!is_null($cftData) && $cftData->CorporateQualityAssurance_assessment)
                                    {{ $cftData->CorporateQualityAssurance_assessment }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </td>
                        <th class="w-20">Corporate Quality Assurance Feedback</th>
                        <td class="w-30">
                            <div>
                                @if (!is_null($cftData) && $cftData->CorporateQualityAssurance_feedback)
                                    {{ $cftData->CorporateQualityAssurance_feedback }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </td>
                    </tr>
                    
                    <tr>
                        <th class="w-20">Corporate Quality Assurance Completed By</th>
                        <td class="w-30">
                            <div>
                                @if (!is_null($cftData) && $cftData->CQA_by)
                                    {{ $cftData->CQA_by }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </td>
                        <th class="w-20">Corporate Quality Assurance Completed On</th>
                        <td class="w-30">
                            <div>
                                @if (!is_null($cftData) && $cftData->CQA_on)
                                    {{ $cftData->CQA_on }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </td>
                    </tr>
                    
                </table>
            </div>
            <div class="border-table">
                <div class="block-head">
                    Corporate Quality Assurance Attachments
                </div>
                <table>

                    <tr class="table_bg">
                        <th class="w-20">S.N.</th>
                        <th class="w-60">Attachment</th>
                    </tr>
                    @if (!is_null($cftData) && $cftData->CQA_attachment)
                    @foreach (json_decode($cftData->CQA_attachment) as $key => $file)
                        <tr>
                            <td class="w-20">{{ $key + 1 }}</td>
                            <td class="w-20"><a href="{{ asset('upload/' . $file) }}" target="_blank"><b>{{ $file }}</b></a></td>
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

            
            <div class="head">
                <div class="block-head">
                    Microbiology
                </div>
                <table>
                    <tr>
                        <th class="w-20">Microbiology Required ?</th>
                        <td class="w-30">
                            <div>
                                @if (!is_null($cftData) && $cftData->Microbiology_Review)
                                    {{ $cftData->Microbiology_Review }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </td>
                        <th class="w-20">Microbiology Person</th>
                        <td class="w-30">
                            <div>
                                @if (!is_null($cftData) && $cftData->Microbiology_person)
                                    {{ $cftData->Microbiology_person }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </td>
                    </tr>
                    
                    <tr>
                        <th class="w-20">Impact Assessment (By Microbiology)</th>
                        <td class="w-30">
                            <div>
                                @if (!is_null($cftData) && $cftData->Microbiology_assessment)
                                    {{ $cftData->Microbiology_assessment }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </td>
                        <th class="w-20">Microbiology Feedback</th>
                        <td class="w-30">
                            <div>
                                @if (!is_null($cftData) && $cftData->Microbiology_feedback)
                                    {{ $cftData->Microbiology_feedback }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </td>
                    </tr>
                    
                    <tr>
                        <th class="w-20">Microbiology Completed By</th>
                        <td class="w-30">
                            <div>
                                @if (!is_null($cftData) && $cftData->Microbiology_by)
                                    {{ $cftData->Microbiology_by }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </td>
                        <th class="w-20">Microbiology Completed On</th>
                        <td class="w-30">
                            <div>
                                @if (!is_null($cftData) && $cftData->Microbiology_on)
                                    {{ $cftData->Microbiology_on }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </td>
                    </tr>
                    
                </table>
            </div>
            <div class="border-table">
                <div class="block-head">
                    Microbiology Attachments
                </div>
                <table>

                    <tr class="table_bg">
                        <th class="w-20">S.N.</th>
                        <th class="w-60">Attachment</th>
                    </tr>
                    @if (!is_null($cftData) && $cftData->Microbiology_attachment)
                    @foreach (json_decode($cftData->Microbiology_attachment) as $key => $file)
                        <tr>
                            <td class="w-20">{{ $key + 1 }}</td>
                            <td class="w-20"><a href="{{ asset('upload/' . $file) }}" target="_blank"><b>{{ $file }}</b></a></td>
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
                <div class="head">
                    <div class="block-head">
                        System IT

                    </div>
                    <table>

                        <tr>
                            <th class="w-20">System IT Review Required ?</th>
                            <td class="w-30">
                                <div>
                                    @if (!is_null($cftData) && $cftData->SystemIT_Review)
                                        {{ $cftData->SystemIT_Review }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                            <th class="w-20">System IT Person</th>
                            <td class="w-30">
                                <div>
                                    @if (!is_null($cftData) && $cftData->SystemIT_person)
                                        {{ $cftData->SystemIT_person }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                        </tr>
                        
                        <tr>
                            <th class="w-20">System IT Comment</th>
                            <td class="w-80">
                                <div>
                                    @if (!is_null($cftData) && $cftData->SystemIT_comment)
                                        {{ $cftData->SystemIT_comment }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                        </tr>
                        
                        <tr>
                            <th class="w-20">System IT Review Completed By</th>
                            <td class="w-30">
                                <div>
                                    @if (!is_null($cftData) && $cftData->Information_Technology_by)
                                        {{ $cftData->Information_Technology_by }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                            <th class="w-20"> System IT Review Completed On</th>
                            <td class="w-30">
                                <div>
                                    @if (!is_null($cftData) && $cftData->Information_Technology_on)
                                        {{ $cftData->Information_Technology_on }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                        </tr>
                        
                    </table>
                </div>
                <div class="border-table">
                    <div class="block-head">
                        System IT Attachments
                    </div>
                    <table>

                        <tr class="table_bg">
                            <th class="w-20">S.N.</th>
                            <th class="w-60">Attachment</th>
                        </tr>
                        @if (!is_null($cftData) && $cftData->Information_Technology_attachment)
                        @foreach (json_decode($cftData->Information_Technology_attachment) as $key => $file)
                            <tr>
                                <td class="w-20">{{ $key + 1 }}</td>
                                <td class="w-20"><a href="{{ asset('upload/' . $file) }}" target="_blank"><b>{{ $file }}</b></a> </td>
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


            <div class="head">
                <div class="block-head">
                    Quality Assurance
                </div>
                <table>
                    <tr>
                        <th class="w-20">Quality Assurance Required ?</th>
                        <td class="w-30">
                            <div>
                                @if (!is_null($cftData) && $cftData->Quality_Assurance_Review)
                                    {{ $cftData->Quality_Assurance_Review }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </td>
                        <th class="w-20">Quality Assurance Person</th>
                        <td class="w-30">
                            <div>
                                @if (!is_null($cftData) && $cftData->QualityAssurance_person)
                                    {{ $cftData->QualityAssurance_person }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Impact Assessment (By Quality Assurance)</th>
                        <td class="w-30">
                            <div>
                                @if (!is_null($cftData) && $cftData->QualityAssurance_assessment)
                                    {{ $cftData->QualityAssurance_assessment }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </td>
                        <th class="w-20">Quality Assurance Feedback</th>
                        <td class="w-30">
                            <div>
                                @if (!is_null($cftData) && $cftData->QualityAssurance_feedback)
                                    {{ $cftData->QualityAssurance_feedback }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Quality Assurance Completed By</th>
                        <td class="w-30">
                            <div>
                                @if (!is_null($cftData) && $cftData->QualityAssurance_by)
                                    {{ $cftData->QualityAssurance_by }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </td>
                        <th class="w-20">Quality Assurance Completed On</th>
                        <td class="w-30">
                            <div>
                                @if (!is_null($cftData) && $cftData->QualityAssurance_on)
                                    {{ $cftData->QualityAssurance_on }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </td>
                    </tr>
                    
                </table>
            </div>

            <div class="border-table">
                <div class="block-head">
                    Quality Assurance Attachments
                </div>
                <table>

                    <tr class="table_bg">
                        <th class="w-20">S.N.</th>
                        <th class="w-60">Attachment</th>
                    </tr>
                    @if (!is_null($cftData) && $cftData->Quality_Assurance_attachment)
                    @foreach (json_decode($cftData->Quality_Assurance_attachment) as $key => $file)
                        <tr>
                            <td class="w-20">{{ $key + 1 }}</td>
                            <td class="w-20">
                                <a href="{{ asset('upload/' . $file) }}" target="_blank">
                                    <b>{{ $file }}</b>
                                </a> 
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
                <div class="head">
                    <div class="block-head">
                        Human Resource
                    </div>
                    <table>
                        <tr>
                            <th class="w-20">Human Resource Review Required ?</th>
                            <td class="w-30">
                                <div>
                                    @if (!is_null($cftData) && $cftData->Human_Resource_review)
                                        {{ $cftData->Human_Resource_review }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                            <th class="w-20">Human Resource Person</th>
                            <td class="w-30">
                                <div>
                                    @if (!is_null($cftData) && $cftData->Human_Resource_person)
                                        {{ $cftData->Human_Resource_person }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                        </tr>
                        
                        <tr>
                            <th class="w-20">Impact Assessment (By Human Resource)</th>
                            <td class="w-30">
                                <div>
                                    @if (!is_null($cftData) && $cftData->Human_Resource_assessment)
                                        {{ $cftData->Human_Resource_assessment }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                            <th class="w-20">Human Resource Feedback</th>
                            <td class="w-30">
                                <div>
                                    @if (!is_null($cftData) && $cftData->Human_Resource_feedback)
                                        {{ $cftData->Human_Resource_feedback }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                        </tr>
                        
                        <tr>
                            <th class="w-20">Human Resource Review Completed By</th>
                            <td class="w-30">
                                <div>
                                    @if (!is_null($cftData) && $cftData->Human_Resource_by)
                                        {{ $cftData->Human_Resource_by }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                            <th class="w-20">Human Resource Review Completed On</th>
                            <td class="w-30">
                                <div>
                                    @if (!is_null($cftData) && $cftData->Human_Resource_on)
                                        {{ $cftData->Human_Resource_on }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                        </tr>
                        
                    </table>
                </div>
                <div class="border-table">
                    <div class="block-head">
                        Human Resource Attachments
                    </div>
                    <table>

                        <tr class="table_bg">
                            <th class="w-20">S.N.</th>
                            <th class="w-60">Attachment</th>
                        </tr>
                        @if (!is_null($cftData) && $cftData->Initial_attachment)
                        @foreach (json_decode($cftData->Initial_attachment) as $key => $file)
                            <tr>
                                <td class="w-20">{{ $key + 1 }}</td>
                                <td class="w-20"><a href="{{ asset('upload/' . $file) }}" target="_blank"><b>{{ $file }}</b></a></td>
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





            

            <div class="block">
                <div class="head">
                    <div class="block-head">
                        Other's 1 ( Additional Person Review From Departments If Required)
                    </div>
                    <table>

                        <tr>
                            <th class="w-20">Other's 1 Review Required ?</th>
                            <td class="w-30">
                                <div>
                                    @if (!is_null($cftData) && $cftData->Other1_review)
                                        {{ $cftData->Other1_review }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                            <th class="w-20">Other's 1 Person</th>
                            <td class="w-30">
                                <div>
                                    @if (!is_null($cftData) && $cftData->Other1_person)
                                        {{ $cftData->Other1_person }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                            <th class="w-20">Other's 1 Department</th>
                            <td class="w-30">
                                <div>
                                    @if (!is_null($cftData) && $cftData->Other1_Department_person)
                                        {{ $cftData->Other1_Department_person }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                        </tr>
                        
                        <tr>
                            <th class="w-20">Impact Assessment (By Other's 1)</th>
                            <td class="w-30">
                                <div>
                                    @if (!is_null($cftData) && $cftData->Other1_assessment)
                                        {{ $cftData->Other1_assessment }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                            <th class="w-20">Other's 1 Feedback</th>
                            <td class="w-30">
                                <div>
                                    @if (!is_null($cftData) && $cftData->Other1_feedback)
                                        {{ $cftData->Other1_feedback }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                        </tr>
                        
                        <tr>
                            <th class="w-20">Other's 1 Review Completed By</th>
                            <td class="w-30">
                                <div>
                                    @if (!is_null($cftData) && $cftData->Other1_by)
                                        {{ $cftData->Other1_by }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                            <th class="w-20">Other's 1 Review Completed On</th>
                            <td class="w-30">
                                <div>
                                    @if (!is_null($cftData) && $cftData->Other1_on)
                                        {{ $cftData->Other1_on }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                        </tr>
                        
                    </table>
                </div>
                <div class="border-table">
                    <div class="block-head">
                        Other's 1 Attachments
                    </div>
                    <table>

                        <tr class="table_bg">
                            <th class="w-20">S.N.</th>
                            <th class="w-60">Attachment</th>
                        </tr>
                        @if (!is_null($cftData) && $cftData->Other1_attachment)
                        @foreach (json_decode($cftData->Other1_attachment) as $key => $file)
                            <tr>
                                <td class="w-20">{{ $key + 1 }}</td>
                                <td class="w-20"><a href="{{ asset('upload/' . $file) }}" target="_blank"><b>{{ $file }}</b></a></td>
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

            <div class="block">
                <div class="head">
                    <div class="block-head">
                        Other's 2 ( Additional Person Review From Departments If Required)
                    </div>
                    <table>

                        <tr>
                            <th class="w-20">Other's 2 Review Required ?</th>
                            <td class="w-30">
                                <div>
                                    @if (!is_null($cftData) && $cftData->Other2_review)
                                        {{ $cftData->Other2_review }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                            <th class="w-20">Other's 2 Person</th>
                            <td class="w-30">
                                <div>
                                    @if (!is_null($cftData) && $cftData->Other2_person)
                                        {{ $cftData->Other2_person }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                            <th class="w-20">Other's 2 Department</th>
                            <td class="w-30">
                                <div>
                                    @if (!is_null($cftData) && $cftData->Other2_Department_person)
                                        {{ $cftData->Other2_Department_person }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                        </tr>
                        
                        <tr>
                            <th class="w-20">Impact Assessment (By Other's 2)</th>
                            <td class="w-30">
                                <div>
                                    @if (!is_null($cftData) && $cftData->Other2_assessment)
                                        {{ $cftData->Other2_assessment }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                            <th class="w-20">Other's 2 Feedback</th>
                            <td class="w-30">
                                <div>
                                    @if (!is_null($cftData) && $cftData->Other2_feedback)
                                        {{ $cftData->Other2_feedback }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                        </tr>
                        
                        <tr>
                            <th class="w-20">Other's 2 Review Completed By</th>
                            <td class="w-30">
                                <div>
                                    @if (!is_null($cftData) && $cftData->Other2_by)
                                        {{ $cftData->Other2_by }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                            <th class="w-20">Other's 2 Review Completed On</th>
                            <td class="w-30">
                                <div>
                                    @if (!is_null($cftData) && $cftData->Other2_on)
                                        {{ $cftData->Other2_on }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                        </tr>
                        
                    </table>
                </div>
                <div class="border-table">
                    <div class="block-head">
                        Other's 2 Attachments
                    </div>
                    <table>

                        <tr class="table_bg">
                            <th class="w-20">S.N.</th>
                            <th class="w-60">Attachment</th>
                        </tr>
                        @if (!is_null($cftData) && $cftData->Other2_attachment)
                        @foreach (json_decode($cftData->Other2_attachment) as $key => $file)
                            <tr>
                                <td class="w-20">{{ $key + 1 }}</td>
                                <td class="w-20">
                                    <a href="{{ asset('upload/' . $file) }}" target="_blank"><b>{{ $file }}</b></a>
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

            <div class="block">
                <div class="head">
                    <div class="block-head">
                        Other's 3 ( Additional Person Review From Departments If Required)
                    </div>
                    <table>

                        <tr>
                            <th class="w-20">Other's 3 Review Required ?</th>
                            <td class="w-30">
                                <div>
                                    @if (!is_null($cftData) && $cftData->Other3_review)
                                        {{ $cftData->Other3_review }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                            <th class="w-20">Other's 3 Person</th>
                            <td class="w-30">
                                <div>
                                    @if (!is_null($cftData) && $cftData->Other3_person)
                                        {{ $cftData->Other3_person }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                            <th class="w-20">Other's 3 Department</th>
                            <td class="w-30">
                                <div>
                                    @if (!is_null($cftData) && $cftData->Other3_Department_person)
                                        {{ $cftData->Other3_Department_person }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                        </tr>
                        
                        <tr>
                            <th class="w-20">Impact Assessment (By Other's 3)</th>
                            <td class="w-30">
                                <div>
                                    @if (!is_null($cftData) && $cftData->Other3_assessment)
                                        {{ $cftData->Other3_assessment }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                            <th class="w-20">Other's 3 Feedback</th>
                            <td class="w-30">
                                <div>
                                    @if (!is_null($cftData) && $cftData->Other3_feedback)
                                        {{ $cftData->Other3_feedback }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                        </tr>
                        
                        <tr>
                            <th class="w-20">Other's 3 Review Completed By</th>
                            <td class="w-30">
                                <div>
                                    @if (!is_null($cftData) && $cftData->Other3_by)
                                        {{ $cftData->Other3_by }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                            <th class="w-20">Other's 3 Review Completed On</th>
                            <td class="w-30">
                                <div>
                                    @if (!is_null($cftData) && $cftData->Other3_on)
                                        {{ $cftData->Other3_on }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                        </tr>
                        
                    </table>
                </div>
                <div class="border-table">
                    <div class="block-head">
                        Other's 3 Attachments
                    </div>
                    <table>

                        <tr class="table_bg">
                            <th class="w-20">S.N.</th>
                            <th class="w-60">Attachment</th>
                        </tr>
                        @if (!is_null($cftData) && $cftData->Other3_attachment)
                        @foreach (json_decode($cftData->Other3_attachment) as $key => $file)
                            <tr>
                                <td class="w-20">{{ $key + 1 }}</td>
                                <td class="w-20"><a href="{{ asset('upload/' . $file) }}" target="_blank"><b>{{ $file }}</b></a> </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td class="w-20">4</td>
                            <td class="w-20">Not Applicable</td>
                        </tr>
                    @endif
                    

                    </table>
                </div>
            </div>

            <div class="block">
                <div class="head">
                    <div class="block-head">
                        Other's 4 ( Additional Person Review From Departments If Required)
                    </div>
                    <table>

                        <tr>
                            <th class="w-20">Other's 4 Review Required ?</th>
                            <td class="w-30">
                                <div>
                                    @if (!is_null($cftData) && $cftData->Other4_review)
                                        {{ $cftData->Other4_review }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                            <th class="w-20">Other's 4 Person</th>
                            <td class="w-30">
                                <div>
                                    @if (!is_null($cftData) && $cftData->Other4_person)
                                        {{ $cftData->Other4_person }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                            <th class="w-20">Other's 4 Department</th>
                            <td class="w-30">
                                <div>
                                    @if (!is_null($cftData) && $cftData->Other4_Department_person)
                                        {{ $cftData->Other4_Department_person }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                        </tr>
                        
                        <tr>
                            <th class="w-20">Impact Assessment (By Other's 4)</th>
                            <td class="w-30">
                                <div>
                                    @if (!is_null($cftData) && $cftData->Other4_assessment)
                                        {{ $cftData->Other4_assessment }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                            <th class="w-20">Other's 4 Feedback</th>
                            <td class="w-30">
                                <div>
                                    @if (!is_null($cftData) && $cftData->Other4_feedback)
                                        {{ $cftData->Other4_feedback }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                        </tr>
                        
                        <tr>
                            <th class="w-20">Other's 4 Review Completed By</th>
                            <td class="w-30">
                                <div>
                                    @if (!is_null($cftData) && $cftData->Other4_by)
                                        {{ $cftData->Other4_by }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                            <th class="w-20">Other's 4 Review Completed On</th>
                            <td class="w-30">
                                <div>
                                    @if (!is_null($cftData) && $cftData->Other4_on)
                                        {{ $cftData->Other4_on }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                        </tr>
                        
                    </table>
                </div>
                <div class="border-table">
                    <div class="block-head">
                        Other's 4 Attachments
                    </div>
                    <table>

                        <tr class="table_bg">
                            <th class="w-20">S.N.</th>
                            <th class="w-60">Attachment</th>
                        </tr>
                        @if (!is_null($cftData) && $cftData->Other4_attachment)
                        @foreach (json_decode($cftData->Other4_attachment) as $key => $file)
                            <tr>
                                <td class="w-20">{{ $key + 1 }}</td>
                                <td class="w-20"><a href="{{ asset('upload/' . $file) }}" target="_blank"><b>{{ $file }}</b></a> </td>
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

            <div class="block">
                <div class="head">
                    <div class="block-head">
                        Other's 5 ( Additional Person Review From Departments If Required)
                    </div>
                    <table>

                        <tr>

                            <th class="w-20">Other's 5 Review Required ?</th>
                            <td class="w-30">
                                <div>
                                    @if (!is_null($cftData) && $cftData->Other5_review)
                                        {{ $cftData->Other5_review }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                            <th class="w-20">Other's 5 Person</th>
                            <td class="w-30">
                                <div>
                                    @if (!is_null($cftData) && $cftData->Other5_person)
                                        {{ $cftData->Other5_person }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                            <th class="w-20">Other's 5 Department</th>
                            <td class="w-30">
                                <div>
                                    @if (!is_null($cftData) && $cftData->Other5_Department_person)
                                        {{ $cftData->Other5_Department_person }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                        </tr>
                        
                        <tr>
                        
                            <th class="w-20">Impact Assessment (By Other's 5)</th>
                            <td class="w-30">
                                <div>
                                    @if (!is_null($cftData) && $cftData->Other5_assessment)
                                        {{ $cftData->Other5_assessment }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                            <th class="w-20">Other's 5 Feedback</th>
                            <td class="w-30">
                                <div>
                                    @if (!is_null($cftData) && $cftData->Other5_feedback)
                                        {{ $cftData->Other5_feedback }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                        </tr>
                        
                        <tr>
                        
                            <th class="w-20">Other's 5 Review Completed By</th>
                            <td class="w-30">
                                <div>
                                    @if (!is_null($cftData) && $cftData->Other5_by)
                                        {{ $cftData->Other5_by }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                            <th class="w-20">Other's 5 Review Completed On</th>
                            <td class="w-30">
                                <div>
                                    @if (!is_null($cftData) && $cftData->Other5_on)
                                        {{ $cftData->Other5_on }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                        </tr>
                        
                    </table>
                </div>

                <div class="border-table">
                    <div class="block-head">
                        Other's 5 Attachments
                    </div>
                    <table>

                        <tr class="table_bg">
                            <th class="w-20">S.N.</th>
                            <th class="w-60">Attachment</th>
                        </tr>
                        @if (!is_null($cftData) && $cftData->Other5_attachment)
                        @foreach (json_decode($cftData->Other5_attachment) as $key => $file)
                            <tr>
                                <td class="w-20">{{ $key + 1 }}</td>
                                <td class="w-20"><a href="{{ asset('upload/' . $file) }}" target="_blank"><b>{{ $file }}</b></a></td>
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

            <div class="block">
                <div class="block-head">
                    QA Final Review
                </div>
                <table>
                    <tr>
                        <th class="w-20">RA Head Person</th>
                        <td class="w-30">
                            <div>
                                @if (!is_null($cc_cfts) && $cc_cfts->RA_data_person)
                                    {{ $cc_cfts->RA_data_person }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </td>
                        <th class="w-20">QA/CQA Head Approval Person</th>
                        <td class="w-30">
                            <div>
                                @if (!is_null($cc_cfts) && !is_null($cc_cfts->QA_CQA_person))
                                {{ $cc_cfts->QA_CQA_person }}
                            @else
                                Not Applicable
                            @endif
                            
                            </div>
                        </td>
                    </tr>
                    
                </table>
                <label class="head-number" for="QA Final Review Comments">QA Final Review Comments</label>
                <div class="div-data">
                    @if (!is_null($cftData) && !is_null($cftData->qa_final_comments))
                    {{ $cftData->qa_final_comments }}
                @else
                    Not Applicable
                @endif
                
                </div>

                <div class="border-table">
                    <div class="block-head">
                        QA Final Review Attachments
                    </div>
                    <table>

                        <tr class="table_bg">
                            <th class="w-20">S.N.</th>
                            <th class="w-60">Attachment</th>
                        </tr>
                        @if (!is_null($cftData) && !is_null($cftData->qa_final_attach))
                        @foreach (json_decode($cftData->qa_final_attach) as $key => $file)
                            <tr>
                                <td class="w-20">{{ $key + 1 }}</td>
                                <td class="w-20"><a href="{{ asset('upload/' . $file) }}" target="_blank"><b>{{ $file }}</b></a></td>
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

            <div class="block">
                <div class="block-head">
                    RA
                </div>

                <label class="head-number" for="RA Comment">RA Comment</label>
                <div class="div-data">
                    @if (!is_null($data->ra_tab_comments))
                    {{ $data->ra_tab_comments }}
                @else
                    Not Applicable
                @endif
                
                </div>


                <div class="border-table">
                    <div class="block-head">
                        RA Attachments
                    </div>
                    <table>

                        <tr class="table_bg">
                            <th class="w-20">S.N.</th>
                            <th class="w-60">Attachment</th>
                        </tr>
                        @if ($cc_cfts->RA_attachment_second)
                            @foreach (json_decode($cc_cfts->RA_attachment_second) as $key => $file)
                                <tr>
                                    <td class="w-20">{{ $key + 1 }}</td>
                                    <td class="w-20"><a href="{{ asset('upload/' . $file) }}"
                                            target="_blank"><b>{{ $file }}</b></a> </td>
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

            <div class="block">
                <div class="head">
                    <div class="block-head">
                        QA/CQA Designee Approval
                    </div>

                    <label class="head-number" for="QA/CQA Head/Manager Designee Approval Comments">QA/CQA
                        Head/Manager Designee Approval Comments</label>
                    <div class="div-data">
                        @if ($cc_cfts->qa_cqa_comments)
                            {{ $cc_cfts->qa_cqa_comments }}
                        @else
                            Not Applicable
                        @endif
                    </div>
                    {{-- <table>
                        <tr>
                            <th class="w-20">QA/CQA Head/Manager Designee Approval Comments</th>
                            <td class="w-30">
                                <div>
                                    @if ($data->Production_Injection_Attachment)
                                        {{ $data->Production_Injection_Attachment }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                        </tr>
                        </table> --}}



                    <div class="border-table">
                        <div class="block-head">
                            QA/CQA Head/Manager Designee Approval Attachments
                        </div>
                        <table>

                            <tr class="table_bg">
                                <th class="w-20">S.N.</th>
                                <th class="w-60">Attachment</th>
                            </tr>
                            @if ($cc_cfts->qa_cqa_attach)
                                @foreach (json_decode($cc_cfts->qa_cqa_attach) as $key => $file)
                                    <tr>
                                        <td class="w-20">{{ $key + 1 }}</td>
                                        <td class="w-20"><a href="{{ asset('upload/' . $file) }}"
                                                target="_blank"><b>{{ $file }}</b></a> </td>
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

            <div class="block">
                <div class="head">
                    <div class="block-head">
                        Evaluation Details
                    </div>

                    <label class="head-number" for="QA Evaluation Comments">QA Evaluation Comments</label>
                    <div class="div-data">
                        @if ($evaluation->qa_eval_comments)
                            {{ $evaluation->qa_eval_comments }}
                        @else
                            Not Applicable
                        @endif
                    </div>


                    <div class="border-table">
                        <div class="block-head">
                            QA Evaluation Attachments
                        </div>
                        <table>

                            <tr class="table_bg">
                                <th class="w-20">S.N.</th>
                                <th class="w-60">QA Evaluation Attachments</th>
                            </tr>
                            @if ($evaluation->qa_eval_attach)
                                @foreach (json_decode($evaluation->qa_eval_attach) as $key => $file)
                                    <tr>
                                        <td class="w-20">{{ $key + 1 }}</td>
                                        <td class="w-20"><a href="{{ asset('upload/' . $file) }}"
                                                target="_blank"><b>{{ $file }}</b></a> </td>
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

            <div class="block">
                <div class="head">
                    <div class="block-head">
                        Initiator Update
                    </div>
                    <label class="head-number" for="Initiator Update Comments">Initiator Update Comments</label>
                    <div class="div-data">
                        @if ($cc_cfts->intial_update_comments)
                            {{ $cc_cfts->intial_update_comments }}
                        @else
                            Not Applicable
                        @endif
                    </div>
                    {{-- <table>
                            <tr>
                                <th class="w-20">Initiator Update Comments</th>
                                <td>
                                    <div>
                                        {{ $cc_cfts->intial_update_comments ?? 'Not Applicable' }}
                                    </div>
                                </td>
                            </tr>
                        </table> --}}


                    <div class="border-table">
                        <div class="block-head">
                            Initiator Update Attachments
                        </div>
                        <table>

                            <tr class="table_bg">
                                <th class="w-20">S.N.</th>
                                <th class="w-60">Initiator Update Attachments</th>
                            </tr>
                            @if ($cc_cfts->intial_update_attach)
                                @foreach (json_decode($cc_cfts->intial_update_attach) as $key => $file)
                                    <tr>
                                        <td class="w-20">{{ $key + 1 }}</td>
                                        <td class="w-20"><a href="{{ asset('upload/' . $file) }}"
                                                target="_blank"><b>{{ $file }}</b></a> </td>
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

            <div class="block">
                <div class="head">
                    <div class="block-head">
                        HOD Final Review
                    </div>
                    <label class="head-number" for="HOD Final Review Comments">HOD Final Review Comments</label>
                    <div class="div-data">
                        @if ($cc_cfts->hod_final_review_comment)
                            {{ $cc_cfts->hod_final_review_comment }}
                        @else
                            Not Applicable
                        @endif
                    </div>

                    <div class="border-table">
                        <div class="block-head">
                            HOD Final Review Attachments
                        </div>
                        <table>

                            <tr class="table_bg">
                                <th class="w-20">S.N.</th>
                                <th class="w-60">HOD Final Review Attachments</th>
                            </tr>
                            @if ($cc_cfts->hod_final_review_attach)
                                @foreach (json_decode($cc_cfts->hod_final_review_attach) as $key => $file)
                                    <tr>
                                        <td class="w-20">{{ $key + 1 }}</td>
                                        <td class="w-20"><a href="{{ asset('upload/' . $file) }}"
                                                target="_blank"><b>{{ $file }}</b></a> </td>
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

            <div class="block">
                <div class="head">
                    <div class="block-head">
                        Implementation Verification
                    </div>
                    <label class="head-number" for="Implementation Verification Comments">Implementation
                        Verification Comments</label>
                    <div class="div-data">
                        @if ($cc_cfts->implementation_verification_comments)
                            {{ $cc_cfts->implementation_verification_comments }}
                        @else
                            Not Applicable
                        @endif
                    </div>

                    <label class="head-number" for="Training Feedback">Training Feedback</label>
                    <div class="div-data">
                        @if ($approcomments->feedback)
                            {{ $approcomments->feedback }}
                        @else
                            Not Applicable
                        @endif
                    </div>
                    {{-- <table>
                            <tr>
                                <th class="w-20">Implementation Verification Comments</th>
                                <td>
                                    <div>
                                        {{ $cc_cfts->implementation_verification_comments ?? 'Not Applicable' }}
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="w-20">Training Feedback</th>
                                <td>
                                    <div>
                                        {{ $approcomments->feedback ?? 'Not Applicable' }}
                                    </div>
                                </td>
                            </tr>
                        </table> --}}


                    <div class="border-table">
                        <div class="block-head">
                            Implementation Verification Attachments
                        </div>
                        <table>

                            <tr class="table_bg">
                                <th class="w-20">S.N.</th>
                                <th class="w-60">Implementation Verification Attachments</th>
                            </tr>
                            @if ($approcomments->tran_attach)
                                @foreach (json_decode($approcomments->tran_attach) as $key => $file)
                                    <tr>
                                        <td class="w-20">{{ $key + 1 }}</td>
                                        <td class="w-20"><a href="{{ asset('upload/' . $file) }}"
                                                target="_blank"><b>{{ $file }}</b></a> </td>
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

            <div class="block">
                <div class="head">
                    <div class="block-head">
                        Change Closure
                    </div>

                    <label class="head-number" for="QA Closure Comments">QA Closure Comments</label>
                    <div class="div-data">
                        @if ($closure->qa_closure_comments)
                            {{ $closure->qa_closure_comments }}
                        @else
                            Not Applicable
                        @endif
                    </div>

                    {{-- <table>
                            <tr>
                                <th class="w-20">QA Closure Comments</th>
                                <td>
                                    <div>
                                        {{ $closure->qa_closure_comments ?? 'Not Applicable' }}
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="w-20">Due Date Extension Justification</th>
                                <td>
                                    <div>
                                        {{ $data->due_date_extension ?? 'Not Applicable' }}
                                    </div>
                                </td>
                            </tr>
                        </table> --}}


                    <div class="border-table">
                        <div class="block-head">
                            List Of Attachments
                        </div>
                        <table>

                            <tr class="table_bg">
                                <th class="w-20">S.N.</th>
                                <th class="w-60">List Of Attachments</th>
                            </tr>
                            @if ($closure->attach_list)
                                @foreach (json_decode($closure->attach_list) as $key => $file)
                                    <tr>
                                        <td class="w-20">{{ $key + 1 }}</td>
                                        <td class="w-20"><a href="{{ asset('upload/' . $file) }}"
                                                target="_blank"><b>{{ $file }}</b></a> </td>
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
                    <label class="head-number" for="Due Date Extension Justification">Due Date Extension
                        Justification</label>
                    <div class="div-data">
                        @if ($data->due_date_extension)
                            {{ $data->due_date_extension }}
                        @else
                            Not Applicable
                        @endif
                    </div>
                </div>
            </div>

            <div class="block">
                <div class="block-head">
                    Activity Log
                </div>
                <table>
                    <tr>
                        <th class="w-20">Submitted By</th>
                        <td class="w-30">
                            <div class="static">{{ $data->submit_by }}</div>
                        </td>
                        <th class="w-20">Submitted On</th>
                        <td class="w-30">
                            <div class="static">{{ $data->submit_on }}</div>
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20" colspan="3">Submitted Comment</th>
                        <td class="w-30">
                            <div class="static">{{ $data->submit_comment }}</div>
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">HOD Assessment Complete By</th>
                        <td class="w-30">
                            <div class="static">{{ $data->hod_review_by }}</div>
                        </td>
                        <th class="w-20">HOD Assessment Complete On</th>
                        <td class="w-30">
                            <div class="static">{{ $data->hod_review_on }}</div>
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20" colspan="3">HOD Comment</th>
                        <td class="w-30">
                            <div class="static">{{ $data->hod_review_comment }}</div>
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">QA/CQA Initial Assessment Complete By</th>
                        <td class="w-30">
                            <div class="static">{{ $data->QA_initial_review_by }}</div>
                        </td>
                        <th class="w-20">QA/CQA Initial Assessment Complete On</th>
                        <td class="w-30">
                            <div class="static">{{ $data->QA_initial_review_on }}</div>
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20" colspan="3">QA/CQA Initial Assessment Comment</th>
                        <td class="w-30">
                            <div class="static">{{ $data->QA_initial_review_comment }}</div>
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">CFT Review Complete By :</th>
                        <td class="w-30">
                            <div class="static">{{ $data->pending_RA_review_by }}</div>
                        </td>
                        <th class="w-20">CFT Review Complete On </th>
                        <td class="w-30">
                            <div class="static">{{ $data->pending_RA_review_on }}</div>
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20" colspan="3">CFT Review Comments </th>
                        <td class="w-30">
                            <div class="static">{{ $data->pending_RA_review_comment }}</div>
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">RA Approval Complete By :</th>
                        <td class="w-30">
                            <div class="static">{{ $data->RA_review_completed_by }}</div>
                        </td>
                        <th class="w-20">RA Approval Complete On :</th>
                        <td class="w-30">
                            <div class="static">{{ $data->RA_review_completed_on }}</div>
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20" colspan="3">RA Approval Comments</th>
                        <td class="w-30">
                            <div class="static">{{ $data->RA_review_completed_comment }}</div>
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20"> QA/CQA Final Review Complete By :</th>
                        <td class="w-30">
                            <div class="static">{{ $data->QA_final_review_by }}</div>
                        </td>
                        <th class="w-20"> QA/CQA Final Review Complete On :</th>
                        <td class="w-30">
                            <div class="static">{{ $data->QA_final_review_on }}</div>
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20" colspan="3">QA/CQA Final Review Comments :</th>
                        <td class="w-30">
                            <div class="static">{{ $data->QA_final_review_comment }}</div>
                        </td>
                    </tr>



                    <tr>
                        <th class="w-20">Approved By : </th>
                        <td class="w-30">
                            <div class="static">{{ $data->approved_by }}</div>
                        </td>
                        <th class="w-20">Approved On :</th>
                        <td class="w-30">
                            <div class="static">{{ $data->approved_on }}</div>
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20" colspan="3">Approved Comments :</th>
                        <td class="w-30">
                            <div class="static">{{ $data->approved_comment }}</div>
                        </td>
                    </tr>

                    {{-- <tr>
                        <th class="w-20">Initiator Updated Completed By</th>
                        <td class="w-30">
                            <div class="static">
                                @if ($commnetData->initiator_update_complete_by)
                                    {{ $commnetData->initiator_update_complete_by }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </td>
                        <th class="w-20">Initiator Updated Completed On </th>
                        <td class="w-30">
                            <div class="static">
                                @if ($commnetData->initiator_update_complete_on)
                                    {{ $commnetData->initiator_update_complete_on }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20" colspan="3">Initiator Updated Completed Comments :</th>
                        <td class="w-30">
                            <div class="static">
                                @if ($commnetData->initiator_update_complete_comment)
                                    {{ $commnetData->initiator_update_complete_comment }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </td>
                    </tr> --}}


                    <tr>
                        <th class="w-20">HOD Final Review Complete By </th>
                        <td class="w-30">
                            <div class="static">{{ $data->closure_approved_by }}</div>
                        </td>
                        <th class="w-20"> HOD Final Review Complete On </th>
                        <td class="w-30">
                            <div class="static">{{ $data->closure_approved_on }}</div>
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20" colspan="3">HOD Final Review Complete Comments </th>
                        <td class="w-30">
                            <div class="static">{{ $data->closure_approved_comment }}</div>
                        </td>
                    </tr>

                    {{-- <tr>
                        <th class="w-20">Send For Final QA/CQA Head Approval By </th>
                        <td class="w-30">
                            <div class="static">{{ $commnetData->send_for_final_qa_head_approval }}</div>
                        </td>
                        <th class="w-20"> Send For Final QA/CQA Head Approval On </th>
                        <td class="w-30">
                            <div class="static">{{ $commnetData->send_for_final_qa_head_approval_on }}</div>
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20" colspan="3">Send For Final QA/CQA Head Approval Comments</th>
                        <td class="w-30">
                            <div class="static">{{ $commnetData->send_for_final_qa_head_approval_comment }}</div>
                        </td>
                    </tr> --}}
                    <tr>
                        <th class="w-20">Closure Approved By : </th>
                        <td class="w-30">
                            <div class="static">{{ $data->closure_approved_by }}</div>
                        </td>
                        <th class="w-20">Closure Approved On : </th>
                        <td class="w-30">
                            <div class="static">{{ $data->closure_approved_on }}</div>
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20" colspan="3">Closure Approved Comments :</th>
                        <td class="w-30">
                            <div class="static">{{ $data->closure_approved_comment }}</div>
                        </td>
                    </tr>
                </table>
            </div>

        </div>
    </div>
        @endforeach
    @endif

</body>

</html>
