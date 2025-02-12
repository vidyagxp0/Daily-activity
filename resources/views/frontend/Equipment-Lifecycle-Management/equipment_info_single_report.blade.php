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

    .tbl-bottum {
        margin-bottom: 20px
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
                    Equipment/Instrument Lifecycle Management Single Report
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

  

</body>

</html>
