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
                Risk Assesment Single Report
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
                    <strong>Risk Assesment No.</strong>
                </td>
                <td class="w-40">
                       {{ Helpers::getDivisionName($data->division_id) }}/RA/{{ date('Y') }}/{{ str_pad($data->record, 4, '0', STR_PAD_LEFT) }}</td>
            
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
                {{--<td class="w-30">
                    <strong>Page :</strong> 1 of 1
                </td>--}}
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
                        {{ Helpers::getDivisionName($data->division_id) }}/RA/{{ date('Y') }}/{{ str_pad($data->record, 4, '0', STR_PAD_LEFT) }}                </td>
                        <th class="w-20">Site/Location Code</th>
                        <td class="w-30">
                        {{ Helpers::getDivisionName($data->division_id) }}
                        </td>
                    </tr>
                    <tr>  {{ $data->created_at }} added by {{ $data->originator }}
                        <th class="w-20">Initiator</th>
                        <td class="w-30">{{ $data->originator }}</td>
                        <th class="w-20">Date of Initiation</th>
                        <td class="w-30">{{ Helpers::getdateFormat($data->created_at) }}</td>
                    </tr>
                    <tr>
                        <!-- <th class="w-20">Site/Location Code</th>
                        <td class="w-30">@if($data->division_code){{ $data->division_code }} @else Not Applicable @endif</td> -->
                        <th class="w-20">Assigned To</th>
                        <td class="w-30">@if($data->assign_to){{ Helpers::getInitiatorName($data->assign_to) }} @else Not Applicable @endif</td>                   </tr>
                    <tr>
                        <th class="w-20">Severity Level</th>
                        <td class="w-30">@if($data->severity2_level){{ $data->severity2_level}} @else Not Applicable @endif</td>
                        <th class="w-20">Due Date</th>
                        <td class="w-80"> @if($data->due_date){{ $data->due_date }} @else Not Applicable @endif</td>
                        {{--<th class="w-20">State/District</th>
                        <td class="w-30">@if($data->state){{ $data->state }} @else Not Applicable @endif</td>--}}
                    </tr>
                    <tr>
                        <th class="w-20">Initiator Group</th>
                        <td class="w-30">@if($data->Initiator_Group){{ Helpers::getInitiatorGroupFullName($data->Initiator_Group) }} @else Not Applicable @endif</td>
                        <th class="w-20">Initiator Group Code</th>
                        <td class="w-30">@if($data->initiator_group_code){{ $data->initiator_group_code }} @else Not Applicable @endif</td>
                    </tr>
                    {{--<tr>--}}
                        {{--  <th class="w-20">Team Members</th>
                        <td class="w-30">@if($data->team_members){{ Helpers::getInitiatorName($data->team_members) }}@else Not Applicable @endif</td>  --}}
                        
                    {{--</tr>--}}
                    <tr>
                        <th class="w-20">Risk/Opportunity Description</th>
                        <td class="w-80">@if($data->description){{ $data->description }} @else Not Applicable @endif</td>
                    </tr> 
                    {{--<tr> 
                      
                        <th class="w-20">Risk/Opportunity Comments</th>
                        <td class="w-80">@if($data->comments){{ $data->comments }} @else Not Applicable @endif</td>
                    </tr>--}}
                    <tr>
                     {{--  {{dd($data->departments)}}  --}}
                         <th class="w-20">Department(s)</th>
                         <td class="w-80">@if($data->departments){{  ($data->departments )}}@else Not Applicable @endif</td>
                    </tr>
                       {{--  <td class="w-80">
                            @php
                                $departments = Helpers::getDepartmentNameWithString($data->departments);
                            @endphp

                            {{dd($departments)}}
                            @if(!empty($departments))
                                {{ implode(',', $departments) }}
                            @else
                                Not Applicable
                            @endif
                        </td>  --}}
                        <tr>
                        <th class="w-20"> Short Description</th>
                        <td class="w-30">@if($data->short_description){{ $data->short_description }} @else Not Applicable @endif</td>
                    </tr>
                    <tr>
                            <th class="w-20">Type</th>
                            <td class="w-80">@if($data->type){{ $data->type }}@else Not Applicable @endif</td>
                    </tr>      
                    <tr>      
                            <th class="w-20">Risk/Opportunity Comments</th>
                            <td class="w-80">@if($data->comments){{ $data->comments }}@else Not Applicable @endif</td>
                        
                    </tr>
                    <tr>
                            <th class="w-20">Priority Level</th>
                            <td class="w-80">@if($data->priority_level){{ $data->priority_level }}@else Not Applicable @endif</td>
                            <th class="w-20">Source of Risk/Opportunity</th>
                            <td class="w-80">@if($data->source_of_risk){{ $data->source_of_risk }}@else Not Applicable @endif</td>
                        </tr>
                    
                </table>
            </div>

            <div class="border-table">
                <div class="block-head">
                    Initial Attachment
                </div>
                <table>

                    <tr class="table_bg">
                        <th class="w-20">S.N.</th>
                        <th class="w-60">Batch No</th>
                    </tr>
                        @if($data->capa_attachment)
                        @foreach(json_decode($data->capa_attachment) as $key => $file)
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
        {{--</div>--}}

          <br>
           
            <div class="block">
                <div class="block-head">
                    Risk/Opportunity details
                </div>
                <table>
                    <tr>
                            <th class="w-20">Department(s)</th>
                            <td class="w-80">@if($data->departments2){{ ($data->departments2) }}@else Not Applicable @endif</td>
                            <th class="w-20">Source of Risk</th>
                            <td class="w-80">@if($data->source_of_risk){{ $data->source_of_risk }}@else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">Site Name</th>
                        <td class="w-30">{{ $data->site_name ?? 'Not Applicable' }}</td>
                        
                        <th class="w-20">Building</th>
                        <td class="w-30">{{ $data->building ?? 'Not Applicable' }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Floor</th>
                        <td class="w-30">{{ $data->floor ?? 'Not Applicable' }}</td>
                        
                        <th class="w-20">Duration</th>
                        <td class="w-30">{{ $data->duration ?? 'Not Applicable' }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Hazard</th>
                        <td class="w-30">{{ $data->hazard ?? 'Not Applicable' }}</td>
                        
                        <th class="w-20">Room</th>
                        <td class="w-30">{{ $data->room ?? 'Not Applicable' }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Regulatory Climate</th>
                        <td class="w-30">{{ $data->regulatory_climate ?? 'Not Applicable' }}</td>
                        
                        <th class="w-20">Number of Employees</th>
                        <td class="w-30">{{ $data->Number_of_employees ?? 'Not Applicable' }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Room</th>
                        <td class="w-30">{{ $data->room2 ?? 'Not Applicable' }}</td>
                        
                        <th class="w-20">Risk Management Strategy</th>
                        <td class="w-30">{{ $data->risk_management_strategy ?? 'Not Applicable' }}</td>
                    </tr>

                   </table>
                </div>
            </div>

           <div class="block">
                <div class="block-head">
                    Work Group Assignment
                </div>
                <table>
                    <tr>
                        <th class="w-20">Scheduled Start Date</th>
                        <td class="w-30">@if($data->schedule_start_date1){{ Helpers::getdateFormat($data->schedule_start_date1) }}@else Not Applicable @endif</td>
                        <th class="w-20">Scheduled End Date</th>
                        <td class="w-30">@if($data->schedule_end_date1){{ Helpers::getdateFormat($data->schedule_end_date1) }}@else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-50">Estimated Man-Hours</th>
                        <td class="w-50">@if($data->estimated_man_hours){{ $data->estimated_man_hours }}@else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">Estimated Cost</th>
                        <td class="w-30">@if($data->estimated_cost){{ $data->estimated_cost }}@else Not Applicable @endif</td>
                        <th class="w-20">Currency</th>
                        <td class="w-30">@if($data->currency){{ $data->currency }}@else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">Justification/Rationale</th>
                        <td class="w-30">@if($data->justification){{ $data->justification }}@else Not Applicable @endif</td>
                        
                    </tr>
                    <!-- <tr>
                        <th class="w-20">Action Plan</th>
                        <td class="w-30">@if($data->action_plan){{ $data->action_plan }}@else Not Applicable @endif</td>
                        <th class="w-20"></th>
                        <td class="w-30">@if($data->work_group_attachments){{ $data->work_group_attachments}}@else Not Applicable @endif</td>
                    </tr> -->
                </table>


             <div class="block-head">
                Action Plan
                </div>
                <div class="border-table">
                    <table>
                        <thead>
                            <tr class="table_bg">
                                <th>Row #</th>
                                <th>Action</th>
                                <th>Responsible</th>
                                <th>Deadline</th>
                                <th>Item Static</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($action_plan)
                                @php
                                    // Safely unserialize fields with fallback to empty arrays
                                    $actions = @unserialize($action_plan->action) ?: [];
                                    $responsibles = @unserialize($action_plan->responsible) ?: [];
                                    $deadlines = @unserialize($action_plan->deadline) ?: [];
                                    $itemStatics = @unserialize($action_plan->item_static) ?: [];
                                @endphp

                                @foreach ($actions as $key => $action)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $action }}</td>
                                        
                                        {{-- Responsible person --}}
                                        <td>
                                        {{ Helpers::getInitiatorName($responsibles[$key] ?? 'N/A') }}
                                        </td>
                                        
                                        {{-- Deadline --}}
                                        <td>{{ Helpers::getdateFormat($deadlines[$key]) ?? 'N/A' }}</td>
                                        
                                        {{-- Item Static --}}
                                        <td>{{ $itemStatics[$key] ?? '' }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5">No data available.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

<br>
                <div class="border-table">
                    <div class="block-head">
                    Work Group Attachments
                    </div>
                    <table>

                        <tr class="table_bg">
                            <th class="w-20">S.N.</th>
                            <th class="w-60">Batch No</th>
                        </tr>
                            @if($data->reference)
                            @foreach(json_decode($data->reference) as $key => $file)
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
                      Risk/Opportunity Analysis
                    </div>
                    <table>
                      <tr>
                        <th class="w-20">Root Cause Methodology</th>
                        <td class="w-80">
                        @if($data->root_cause_methodology)
                         @php
                             $method = explode(',',$data->root_cause_methodology);

                         @endphp 
                        @if(in_array('1',$method))
                             Why-Why Chart,<br>
                         @endif   
                          @if (in_array('2',$method))
                               Failure Mode and Efect Analysis,<br>
                          @endif
                         
                         @if (in_array('3',$method))
                             Fishbone or Ishikawa Diagram,<br>
                         @endif
                         @if (in_array('4',$method))
                            Is/Is Not Analysis,<br>
                         @endif
                        
                        @else Not Applicable 
                        
                        @endif
                        
                        </td>
                        </tr>
                        <tr>
                        <th class="w-20">Root Cause Description</th>
                        <td class="w-80">@if($data->root_cause_description){{ $data->root_cause_description}}@else Not Applicable @endif</td>
                       </tr>
                        <tr>
                           <th class="w-20">Investigation Summary</th>
                           <td class="w-80">@if($data->investigation_summary){{ $data->investigation_summary }}@else Not Applicable @endif</td>
                        </tr>
                        <tr>
                            <th class="w-20">Severity Rate</th>
                            <td class="w-80">
                                <div>
                                    @if($data->severity_rate)
                                        @switch($data->severity_rate)
                                            @case(1)
                                                Negligible
                                                @break
                                            @case(2)
                                                Moderate
                                                @break
                                            @case(3)
                                                Major
                                                @break
                                            @case(4)
                                                Fatal
                                                @break
                                            @default
                                                Not Applicable
                                        @endswitch
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th class="w-20">Occurrence</th>
                            <td class="w-80">
                                <div>
                                    @if($data->occurrence)
                                        @switch($data->occurrence)
                                            @case(1)
                                                Very Likely
                                                @break
                                            @case(2)
                                                Likely
                                                @break
                                            @case(3)
                                                Unlikely
                                                @break
                                            @case(4)
                                                Rare
                                                @break
                                            @case('Extremely Unlikely')
                                                Extremely Unlikely
                                                @break
                                            @default
                                                Not Applicable
                                        @endswitch
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th class="w-20">Detection</th>
                            <td class="w-80">
                                <div>
                                    @if($data->detection)
                                        @switch($data->detection)
                                            @case(1)
                                                Very Likely
                                                @break
                                            @case(2)
                                                Likely
                                                @break
                                            @case(3)
                                                Unlikely
                                                @break
                                            @case(4)
                                                Rare
                                                @break
                                            @case(5)
                                                Impossible
                                                @break
                                            @default
                                                Not Applicable
                                        @endswitch
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th class="w-20">RPN</th>
                            <td class="w-80">
                                <div>
                                    @if($data->rpn)
                                        {{ $data->rpn }}
                                    @else
                                        Not Applicable
                                    @endif
                                </div>
                            </td>
                        </tr>
                    </table>



                    <style>
                    .tableFMEA {
                        width: 100%;
                        border-collapse: collapse;
                        font-size: 7px;
                        table-layout: fixed; /* Ensures columns are evenly distributed */
                    }

                    .thFMEA,
                    .tdFMEA {
                        border: 1px solid black;
                        padding: 5px;
                        word-wrap: break-word;
                        text-align: center;
                        vertical-align: middle;
                        font-size: 6px; /* Apply the same font size for all cells */
                    }

                    /* Rotating specific headers */
                    .rotate {
                        transform: rotate(-90deg);
                        white-space: nowrap;
                        width: 10px;
                        height: 100px;
                    }

                    /* Ensure the "Traceability Document" column fits */
                    .tdFMEA:last-child,
                    .thFMEA:last-child {
                        width: 80px; /* Allocate more space for "Traceability Document" */
                    }

                    /* Adjust for smaller screens to fit */
                    @media (max-width: 1200px) {
                        .tdFMEA:last-child,
                        .thFMEA:last-child {
                            font-size: 6px;
                            width: 70px; /* Shrink width further for smaller screens */
                        }
                    }

                </style>

<div class="block-head">Failure Mode And Effect Analysis</div>
<div class="table-responsive">
    <table class="tableFMEA">
        <thead>
            <tr class="table_bg">
                <th class="thFMEA">Row #</th>
                <th class="thFMEA">Risk Factor</th>
                <th class="thFMEA">Risk Element</th>
                <th class="thFMEA">Probable Cause</th>
                <th class="thFMEA">Existing Risk Controls</th>
                <th class="thFMEA">Initial Severity</th>
                <th class="thFMEA">Initial Probability</th>
                <th class="thFMEA">Initial Detectability</th>
                <th class="thFMEA">Initial RPN</th>
                <th class="thFMEA">Risk Acceptance</th>
                <th class="thFMEA">Proposed Risk Control</th>
                <th class="thFMEA">Residual Severity</th>
                <th class="thFMEA">Residual Probability</th>
                <th class="thFMEA">Residual Detectability</th>
                <th class="thFMEA">Residual RPN</th>
                <th class="thFMEA">Final Acceptance</th>
                <th class="thFMEA">Mitigation Proposal</th>
            </tr>
        </thead>
        <tbody>
            @if ($riskEffectAnalysis)
                @php
                    // Safely unserialize and initialize all necessary fields
                    $riskFactors = @unserialize($riskEffectAnalysis->risk_factor) ?: [];
                    $riskElements = @unserialize($riskEffectAnalysis->risk_element) ?: [];
                    $problemCauses = @unserialize($riskEffectAnalysis->problem_cause) ?: [];
                    $existingRiskControls = @unserialize($riskEffectAnalysis->existing_risk_control) ?: [];
                    $initialSeverities = @unserialize($riskEffectAnalysis->initial_severity) ?: [];
                    $initialProbabilities = @unserialize($riskEffectAnalysis->initial_probability) ?: [];
                    $initialDetectabilities = @unserialize($riskEffectAnalysis->initial_detectability) ?: [];
                    $initialRPNs = @unserialize($riskEffectAnalysis->initial_rpn) ?: [];
                    $riskAcceptances = @unserialize($riskEffectAnalysis->risk_acceptance) ?: [];
                    $proposedRiskControls = @unserialize($riskEffectAnalysis->risk_control_measure) ?: [];
                    $residualSeverities = @unserialize($riskEffectAnalysis->residual_severity) ?: [];
                    $residualProbabilities = @unserialize($riskEffectAnalysis->residual_probability) ?: [];
                    $residualDetectabilities = @unserialize($riskEffectAnalysis->residual_detectability) ?: [];
                    $residualRPNs = @unserialize($riskEffectAnalysis->residual_rpn) ?: [];
                    $finalAcceptances = @unserialize($riskEffectAnalysis->risk_acceptance2) ?: [];
                    $mitigationProposals = @unserialize($riskEffectAnalysis->mitigation_proposal) ?: [];
                @endphp

                @foreach ($riskFactors as $key => $riskFactor)
                    <tr>
                        <td class="tdFMEA">{{ $key + 1 }}</td>
                        <td class="tdFMEA">{{ $riskFactor }}</td>
                        <td class="tdFMEA">{{ $riskElements[$key] ?? '' }}</td>
                        <td class="tdFMEA">{{ $problemCauses[$key] ?? '' }}</td>
                        <td class="tdFMEA">{{ $existingRiskControls[$key] ?? '' }}</td>
                        <td class="tdFMEA">{{ $initialSeverities[$key] ?? '' }}</td>
                        <td class="tdFMEA">{{ $initialProbabilities[$key] ?? '' }}</td>
                        <td class="tdFMEA">{{ $initialDetectabilities[$key] ?? '' }}</td>
                        <td class="tdFMEA">{{ $initialRPNs[$key] ?? '' }}</td>
                        <td class="tdFMEA">{{ $riskAcceptances[$key] ?? '' }}</td>
                        <td class="tdFMEA">{{ $proposedRiskControls[$key] ?? '' }}</td>
                        <td class="tdFMEA">{{ $residualSeverities[$key] ?? '' }}</td>
                        <td class="tdFMEA">{{ $residualProbabilities[$key] ?? '' }}</td>
                        <td class="tdFMEA">{{ $residualDetectabilities[$key] ?? '' }}</td>
                        <td class="tdFMEA">{{ $residualRPNs[$key] ?? '' }}</td>
                        <td class="tdFMEA">{{ $finalAcceptances[$key] ?? '' }}</td>
                        <td class="tdFMEA">{{ $mitigationProposals[$key] ?? '' }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="17" class="tdFMEA">No data available.</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>






                    <div class="block-head">
                        Fishbone or Ishikawa Diagram 
                    </div>
                    <table>
                    - <tr>
                        <th class="w-20">Measurement</th>
                        {{-- <td class="w-80">@if($riskgrdfishbone->measurement){{ $riskgrdfishbone->measurement }}@else Not Applicable @endif</td> --}}
                             <td class="w-80">
                            @php
                                $measurement = unserialize($riskgrdfishbone->measurement);
                            @endphp
                            
                            @if(is_array($measurement))
                                @foreach($measurement as $value)
                                    {{ htmlspecialchars($value) }}
                                @endforeach
                            @elseif(is_string($measurement))
                                {{ htmlspecialchars($measurement) }}
                            @else
                                Not Applicable
                            @endif
                              </td>
                        <th class="w-20">Materials</th>
                        {{-- <td class="w-80">@if($riskgrdfishbone->materials){{ $riskgrdfishbone->materials }}@else Not Applicable @endif</td> --}}
                             <td class="w-80">
                            @php
                                $materials = unserialize($riskgrdfishbone->materials);
                            @endphp
                            
                            @if(is_array($materials))
                                @foreach($materials as $value)
                                    {{ htmlspecialchars($value) }}
                                @endforeach
                            @elseif(is_string($materials))
                                {{ htmlspecialchars($materials) }}
                            @else
                                Not Applicable
                            @endif
                               </td>
                        
                    </tr>
                       <tr>
                        <th class="w-20">Methods</th>
                        {{-- <td class="w-80">@if($riskgrdfishbone->methods){{ $riskgrdfishbone->methods }}@else Not Applicable @endif</td> --}}
                           <td class="w-80">
                            @php
                                $methods = unserialize($riskgrdfishbone->methods);
                            @endphp
                            
                            @if(is_array($methods))
                                @foreach($methods as $value)
                                    {{ htmlspecialchars($value) }}
                                @endforeach
                            @elseif(is_string($methods))
                                {{ htmlspecialchars($methods) }}
                            @else
                                Not Applicable
                            @endif
                           </td>
                        <th class="w-20">Environment</th>
                        {{-- <td class="w-80">@if($riskgrdfishbone->environment){{ $riskgrdfishbone->environment }}@else Not Applicable @endif</td> --}}
                            <td class="w-80">
                            @php
                                $environment = unserialize($riskgrdfishbone->environment);
                            @endphp
                            
                            @if(is_array($environment))
                                @foreach($environment as $value)
                                    {{ htmlspecialchars($value) }}
                                @endforeach
                            @elseif(is_string($environment))
                                {{ htmlspecialchars($environment) }}
                            @else
                                Not Applicable
                            @endif
                            </td>
                    </tr>
                    <tr>
                        <th class="w-20">Manpower</th>
                        {{-- <td class="w-80">@if($riskgrdfishbone->manpower){{ $riskgrdfishbone->manpower }}@else Not Applicable @endif</td> --}}
                            <td class="w-80">
                            @php
                                $manpower = unserialize($riskgrdfishbone->manpower);
                            @endphp
                            
                            @if(is_array($manpower))
                                @foreach($manpower as $value)
                                    {{ htmlspecialchars($value) }}
                                @endforeach
                            @elseif(is_string($manpower))
                                {{ htmlspecialchars($manpower) }}
                            @else
                                Not Applicable
                            @endif
                           </td>
                        <th class="w-20">Machine</th>
                        {{-- <td class="w-80">@if($riskgrdfishbone->machine){{ $riskgrdfishbone->machine }}@else Not Applicable @endif</td> --}}
                          <td class="w-80">
                            @php
                                $machine = unserialize($riskgrdfishbone->machine);
                               // dd($machine);
                            @endphp
                            
                            @if(is_array($machine))
                                @foreach($machine as $value)
                                    {{ htmlspecialchars($value) }}
                                @endforeach
                            @elseif(is_string($machine))
                                {{ htmlspecialchars($machine) }}
                            @else
                                Not Applicable
                            @endif
                          </td>
                    </tr>
                    <tr>
                        <th class="w-20">Problem Statement1</th>
                        <td class="w-80">
                        @if($riskgrdfishbone->problem_statement)
                        
                        {{ $riskgrdfishbone->problem_statement }}
                        @else 
                        Not Applicable
                         @endif</td>
                      
                    </tr> 
             </table>
                        
             <div class="block-head">
                Why-Why Chart 
            </div>
            <table>
            - <tr>
                <th class="w-20">Problem Statement</th>
                <td class="w-80">@if($riskgrdwhy_chart->why_problem_statement){{ $riskgrdwhy_chart->why_problem_statement }}@else Not Applicable @endif</td>
                <th class="w-20">Why 1 </th>
                {{-- <td class="w-80">@if($riskgrdwhy_chart->why_1){{ $riskgrdwhy_chart->why_1 }}@else Not Applicable @endif</td> --}}
                <td class="w-80">
                    @php
                        $why_1 = unserialize($riskgrdwhy_chart->why_1);
                    @endphp
                    
                    @if(is_array($why_1))
                        @foreach($why_1 as $value)
                            {{ htmlspecialchars($value) }}
                        @endforeach
                    @elseif(is_string($why_1))
                        {{ htmlspecialchars($why_1) }}
                    @else
                        Not Applicable
                    @endif
                      </td>
            </tr>
               <tr>
                <th class="w-20">Why 2</th>
                {{-- <td class="w-80">@if($riskgrdwhy_chart->why_2){{ $riskgrdwhy_chart->why_2 }}@else Not Applicable @endif</td> --}}
                <td class="w-80">
                    @php
                        $why_2 = unserialize($riskgrdwhy_chart->why_2);
                    @endphp
                    
                    @if(is_array($why_2))
                        @foreach($why_2 as $value)
                            {{ htmlspecialchars($value) }}
                        @endforeach
                    @elseif(is_string($why_2))
                        {{ htmlspecialchars($why_2) }}
                    @else
                        Not Applicable
                    @endif
                      </td>
                <th class="w-20">Why 3</th>
                {{-- <td class="w-80">@if($riskgrdwhy_chart->why_3){{ $riskgrdwhy_chart->why_3 }}@else Not Applicable @endif</td> --}}
                <td class="w-80">
                    @php
                        $why_3 = unserialize($riskgrdwhy_chart->why_3);
                    @endphp
                    
                    @if(is_array($why_3))
                        @foreach($why_3 as $value)
                            {{ htmlspecialchars($value) }}
                        @endforeach
                    @elseif(is_string($why_3))
                        {{ htmlspecialchars($why_3) }}
                    @else
                        Not Applicable
                    @endif
                      </td>
            </tr>
            <tr>
                <th class="w-20">Why 4</th>
                {{-- <td class="w-80">@if($riskgrdwhy_chart->why_4){{ $riskgrdwhy_chart->why_4 }}@else Not Applicable @endif</td> --}}
                <td class="w-80">
                    @php
                        $why_4 = unserialize($riskgrdwhy_chart->why_4);
                    @endphp
                    
                    @if(is_array($why_4))
                        @foreach($why_4 as $value)
                            {{ htmlspecialchars($value) }}
                        @endforeach
                    @elseif(is_string($why_4))
                        {{ htmlspecialchars($why_4) }}
                    @else
                        Not Applicable
                    @endif
                      </td>
                <th class="w-20">Why5</th>
                {{-- <td class="w-80">@if($riskgrdwhy_chart->why_4){{ $riskgrdwhy_chart->why_4 }}@else Not Applicable @endif</td> --}}
                <td class="w-80">
                    @php
                        $why_5 = unserialize($riskgrdwhy_chart->why_5);
                    @endphp
                    
                    @if(is_array($why_5))
                        @foreach($why_5 as $value)
                            {{ htmlspecialchars($value) }}
                        @endforeach
                    @elseif(is_string($why_5))
                        {{ htmlspecialchars($why_5) }}
                    @else
                        Not Applicable
                    @endif
                      </td>
            </tr>
            <tr>
                <th class="w-20">Root Cause :	</th>
                <td class="w-80">@if($riskgrdwhy_chart->why_root_cause){{ $riskgrdwhy_chart->why_root_cause }}@else Not Applicable @endif</td>
              
            </tr> 
     </table>

<div>     
     <div class="block-head">
        Is/Is Not Analysis
    </div>

    <table>
    <tr>
    <th class="w-20">What Will Be</th>
    <td class="w-80">@if($riskgrdwhat_who_where->what_will_be) {!! nl2br(e($riskgrdwhat_who_where->what_will_be)) !!} @else Not Applicable @endif</td>
    <th class="w-20">What Will Not Be</th>
    <td class="w-80">@if($riskgrdwhat_who_where->what_will_not_be) {!! nl2br(e($riskgrdwhat_who_where->what_will_not_be)) !!} @else Not Applicable @endif</td>
   
   </tr>
    <tr>
    <th class="w-20">What Will Rationale</th>
    <td class="w-80">@if($riskgrdwhat_who_where->what_rationable) {!! nl2br(e($riskgrdwhat_who_where->what_rationable)) !!} @else Not Applicable @endif</td>
    
    <th class="w-20">Where Will Be</th>
    <td class="w-80">@if($riskgrdwhat_who_where->where_will_be) {!! nl2br(e($riskgrdwhat_who_where->where_will_be)) !!} @else Not Applicable @endif</td>
    </tr>
    <tr>

        <th class="w-20">Where Will Not Be</th>
        <td class="w-80">@if($riskgrdwhat_who_where->where_will_not_be) {!! nl2br(e($riskgrdwhat_who_where->where_will_not_be)) !!} @else Not Applicable @endif</td>
        <th class="w-20">Where Will Rationale</th>
        <td class="w-80">@if($riskgrdwhat_who_where->where_rationable) {!! nl2br(e($riskgrdwhat_who_where->where_rationable)) !!} @else Not Applicable @endif</td>
    
    </tr>
    <tr>
        <th class="w-20">When Will Be</th>
        <td class="w-80">@if($riskgrdwhat_who_where->when_will_be) {!! nl2br(e($riskgrdwhat_who_where->when_will_be)) !!} @else Not Applicable @endif</td>
        <th class="w-20">When Will Not Be</th>
        <td class="w-80">@if($riskgrdwhat_who_where->when_will_not_be) {!! nl2br(e($riskgrdwhat_who_where->when_will_not_be)) !!} @else Not Applicable @endif</td>
    </tr>
    <tr> 
        <th class="w-20">When Will Rationale</th>
        <td class="w-80">@if($riskgrdwhat_who_where->when_rationable) {!! nl2br(e($riskgrdwhat_who_where->when_rationable)) !!} @else Not Applicable @endif</td>
   
        <th class="w-20">Coverage Will Be</th>
        <td class="w-80">@if($riskgrdwhat_who_where->coverage_will_be) {!! nl2br(e($riskgrdwhat_who_where->coverage_will_be)) !!} @else Not Applicable @endif</td>
    </tr>
    <tr>   
       
        <th class="w-20">Coverage Will Not Be</th>
        <td class="w-80">@if($riskgrdwhat_who_where->coverage_will_not_be) {!! nl2br(e($riskgrdwhat_who_where->coverage_will_not_be)) !!} @else Not Applicable @endif</td>
    </tr>
    <tr>  
        <th class="w-20">Coverage Will Rationale</th>
        <td class="w-80">@if($riskgrdwhat_who_where->coverage_rationable) {!! nl2br(e($riskgrdwhat_who_where->coverage_rationable)) !!} @else Not Applicable @endif</td>
    </tr>
    <tr>
        <th class="w-20">Who Will Be</th>
        <td class="w-80">@if($riskgrdwhat_who_where->who_will_be) {!! nl2br(e($riskgrdwhat_who_where->who_will_be)) !!} @else Not Applicable @endif</td>
        <th class="w-20">Who Will Not Be</th>
        <td class="w-80">@if($riskgrdwhat_who_where->who_will_not_be) {!! nl2br(e($riskgrdwhat_who_where->who_will_not_be)) !!} @else Not Applicable @endif</td>
    </tr>
    <tr>   
       
        <th class="w-20">Who Will Rationale</th>
        <td class="w-80">@if($riskgrdwhat_who_where->who_rationable) {!! nl2br(e($riskgrdwhat_who_where->who_rationable)) !!} @else Not Applicable @endif</td>
    </tr>
    
    </table>        

 </div>              

            <!-- <div class="block">
                <div class="head">
                    <div class="block-head">
                       Risk/Opportunity Analysis
                    </div>
                    <table>
                     <tr>
                        <th class="w-20">Root Cause Methodology</th>
                        <td class="w-30">
                            @if($data->root_cause_methodology)
                             @php
                                 $methogies= explode(',',$data->root_cause_methodology);
                             @endphp
                              @if(in_array('1',$methogies))
                                  Why-Why Chart<br>
                              @endif
                              @if(in_array('2',$methogies))
                                   Failure Mode and Efect Analysis<br>
                              @endif
                              @if(in_array('3',$methogies))
                                  Fishbone or Ishikawa Diagram<br>
                              @endif

                             @if(in_array('4',$methogies))
                                  Is/Is Not Analysis<br>
                              @endif


                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">Root Cause Description</th>
                        <td class="w-30">@if($data->root_cause_description){{ $data->root_cause_description }}@else Not Applicable @endif</td>
                    </tr>

                        <tr>
                           <th class="w-20">Investigation Summary</th>
                           <td class="w-30">@if($data->investigation_summary){{ $data->investigation_summary }}@else Not Applicable @endif</td>
                        </tr>
                        <tr>
                            <th class="w-20">Severity Rate
                            </th>
                            <td class="w-80">
                                <div>
                                    @if($data->severity_rate){{ $data->severity_rate }}@else Not Applicable @endif
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th class="w-20">Occurrence
                            </th>
                            <td class="w-80">
                                <div>
                                    @if($data->occurrence){{ $data->occurrence }}@else Not Applicable @endif
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th class="w-20">Detection
                            </th>
                            <td class="w-80">
                                <div>
                                    @if($data->detection){{ $data->detection }}@else Not Applicable @endif
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th class="w-20">RPN
                            </th>
                            <td class="w-80">
                                <div>
                                    @if($data->rpn){{ $data->rpn }}@else Not Applicable @endif
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
</div> -->
            <div class="block">
                <div class="head">
                    <div class="block-head">
                     Residual Risk
                    </div>
                    <table>
                    <tr>
                        <th class="w-20">Residual Risk</th>
                        <td class="w-30">@if($data->residual_risk){{ $data->residual_risk }}@else Not Applicable @endif</td>
                        <th class="w-20">Residual Risk Impact</th>
                        <td class="w-30">
                            @if($data->residual_risk_impact)
                            
                                @switch($data->residual_risk_impact)
                                    @case(1)
                                        High
                                        @break
                                    @case(2)
                                        Low
                                        @break
                                    @case(3)
                                        Medium
                                        @break
                                    @case(4)
                                        None
                                        @break
                                    @default
                                        Not Applicable
                                @endswitch
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Residual Risk Probability</th>
                        <td class="w-30">
                            @if($data->residual_risk_probability)
                                @switch($data->residual_risk_probability)
                                    @case(1)
                                        High
                                        @break
                                    @case(2)
                                        Medium
                                        @break
                                    @case(3)
                                        Low
                                        @break
                                    @default
                                        Not Applicable
                                @endswitch
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Residual Detection</th>
                        <td class="w-30">
                        @if ($data->detection2)
                            @switch($data->detection2)
                                @case(5)
                                    Impossible
                                    @break
                            @case(4)
                                    Rare
                                    @break
                            @case(3)
                                    Unlikely
                                    @break
                            @case(2)
                                    Likely
                                    @break
                                @case(1)
                                    Very Likely
                                    @break
                            
                                @default
                                Not Applicable     
                            @endswitch
                            @else
                            Not Applicable  
                        @endif
                        </td>
                        <th class="w-20">Residual RPN</th>
                        <td class="w-30">@if($data->rpn2){{ $data->rpn2 }}@else Not Applicable @endif</td>
                    </tr>                  
                    <tr>
                        <th class="w-20">Comments</th>
                        <td class="w-30">@if($data->comments2){{ $data->comments2 }}@else Not Applicable @endif</td>
                        
                    </tr>
                    
                  </table>
                </div>
            </div>

            <div class="block">
                <div class="head">
                    <div class="block-head">
                    Risk Analysis
                    </div>
                    <table>
                    <tr>
                        <th class="w-20">Severity Rate</th>
                        <td class="w-30">@if($data->severity_rate){{ $data->severity_rate }}@else Not Applicable @endif</td>
                        <th class="w-20">Occurrence</th>
                        <td class="w-30">
                        @if ($data->occurrence)
                            @switch($data->occurrence)
                                @case(5)
                                    Impossible
                                    @break
                            @case(4)
                                    Rare
                                    @break
                            @case(3)
                                    Unlikely
                                    @break
                            @case(2)
                                    Likely
                                    @break
                                @case(1)
                                    Very Likely
                                    @break
                            
                                @default
                                Not Applicable     
                            @endswitch
                            @else
                            Not Applicable  
                        @endif
                        </td>
                    </tr>
                    
                    <tr>
                        <th class="w-20">Detection</th>
                        <td class="w-30">
                        @if ($data->detection)
                            @switch($data->detection)
                                @case(5)
                                    Impossible
                                    @break
                            @case(4)
                                    Rare
                                    @break
                            @case(3)
                                    Unlikely
                                    @break
                            @case(2)
                                    Likely
                                    @break
                                @case(1)
                                    Very Likely
                                    @break
                            
                                @default
                                Not Applicable     
                            @endswitch
                            @else
                            Not Applicable  
                        @endif
                        </td>
                        <th class="w-20">RPN</th>
                        <td class="w-30">@if($data->rpn){{ $data->rpn }}@else Not Applicable @endif</td>
                    </tr>                  
                   
                    
                  </table>
                </div>
            </div>

            
            <div class="block">
                <div class="head">
                    <div class="block-head">
                      Risk Mitigation
                    </div>
                    <table>
                    <tr>
                        <th class="w-20">Mitigation Required</th>
                        <td class="w-30">@if($data->mitigation_required){{ $data->mitigation_required }}@else Not Applicable @endif</td>
                        <th class="w-20">Mitigation Plan</th>
                        <td class="w-30">@if($data->mitigation_plan){{ $data->mitigation_plan}}@else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">Scheduled End Date</th>
                        <td class="w-30">@if($data->mitigation_due_date){{ Helpers::getdateFormat($data->mitigation_due_date) }}@else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">Status of Mitigation</th>
                        <td class="w-30">@if($data->mitigation_status){{ $data->mitigation_status }}@else Not Applicable @endif</td>
                        <th class="w-20">Mitigation Status Comments</th>
                        <td class="w-30">@if($data->mitigation_status_comments){{ $data->mitigation_status_comments}}@else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">Impact</th>
                        <td class="w-30">@if($data->impact){{ $data->impact }}@else Not Applicable @endif</td>
                        <th class="w-20">Criticality</th>
                        <td class="w-30">@if($data->criticality){{ $data->criticality}}@else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">Impact Analysis</th>
                        <td class="w-80">@if($data->impact_analysis){{ $data->impact_analysis }}@else Not Applicable @endif</td>
                        <th class="w-20">Risk Analysis</th>
                        <td class="w-80">@if($data->risk_analysis){{ $data->risk_analysis}}@else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">Reference Record</th>
                        <td class="w-30">@if($data->refrence_record){{ Helpers::getDivisionName($data->refrence_record) }}/RA/{{ date('Y') }}/{{ Helpers::recordFormat($data->record) }}@else Not Applicable @endif</td>
                        <th class="w-20">Due Date Extension Justification</th>
                        <td class="w-80">@if($data->due_date_extension){{ $data->due_date_extension}}@else Not Applicable @endif</td>
                    </tr>
                  </table>
                </div>
            </div>
            
<div class="block-head">
    Mitigation Plan Details
</div>

<div class="border-table">
    <table>
        <thead>
            <tr class="table_bg">
                <th>Row #</th>
                <th>Mitigation Steps</th>
                <th>Deadline</th>
                <th>Responsible Person</th>
                <th>Status</th>
                <th>Remarks</th>
            </tr>
        </thead>
        <tbody>
            @if ($mitigationData)
                @php
                    // Safely unserialize fields with fallback to empty arrays
                    $mitigationSteps = @unserialize($mitigationData->mitigation_steps) ?: [];
                    $deadlines = @unserialize($mitigationData->deadline2) ?: [];
                    $responsiblePersons = @unserialize($mitigationData->responsible_person) ?: [];
                    $statuses = @unserialize($mitigationData->status) ?: [];
                    $remarks = @unserialize($mitigationData->remark) ?: [];
                @endphp

                @foreach ($mitigationSteps as $key => $step)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $step }}</td>
                        <td>{{ $deadlines[$key] ?? '' }}</td>
                        <td>{{ Helpers::getInitiatorName($responsiblePersons[$key]) ?? '' }}</td>
                        <td>{{ $statuses[$key] ?? '' }}</td>
                        <td>{{ $remarks[$key] ?? '' }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="6">No data available.</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>


 <div class="block">
                <div class="block-head">
                    Activity Log
                </div>
                <table>
                    <tr>
                        <th class="w-20">Submit By</th>
                        <td class="w-30">{{ $data->submitted_by }}</td>
                        <th class="w-20">Submit On</th>
                        <td class="w-30">{{ Helpers::getdateFormat($data->submitted_on) }}</td>
                        <th class="w-20">Submit Comment</th>
                        <td class="w-30">{{ $data->submitted_comment }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Evaluation Complete By</th>
                        <td class="w-30">{{ $data->evaluated_by }}</td>
                        <th class="w-20">Evaluation Complete On</th>
                        <td class="w-30">{{ Helpers::getdateFormat($data->evaluated_on) }}</td>
                        <th class="w-20">Evaluation Complete Comment</th>
                        <td class="w-30">{{ $data->evaluated_comment }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Action Plan Complete By</th>
                        <td class="w-30">{{ $data->plan_complete_by }}</td>
                        <th class="w-20">Action Plan Complete On</th>
                        <td class="w-30">{{ Helpers::getdateFormat($data->plan_complete_on) }}</td>
                        <th class="w-20">Action Plan Complete Comment</th>
                        <td class="w-30">{{ $data->plan_complete_on }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Action Plan Approved By</th>
                        <td class="w-30">{{ $data->plan_approved_by }}</td>
                        <th class="w-20">Action Plan Approved On</th>
                        <td class="w-30">{{ Helpers::getdateFormat($data->plan_approved_on) }}</td>
                        <th class="w-20">Action Plan Approved Comment</th>
                        <td class="w-30">{{ $data->plan_approved_comment }}</td>
                    </tr>
                    

                    <tr>
                        <th class="w-20">All Actions Completed By</th>
                        <td class="w-30">{{ $data->actions_completed_by }}</td>
                        <th class="w-20">All Actions Completed On</th>
                        <td class="w-30">{{ Helpers::getdateFormat($data->actions_completed_on) }}</td>
                        <th class="w-20">All Actions Completed Comment</th>
                        <td class="w-30">{{ $data->actions_completed_comment }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Residual Risk Evaluation Completed By</th>
                        <td class="w-30">{{ $data->risk_analysis_completed_by }}</td>
                        <th class="w-20">Residual Risk Evaluation Completed On</th>
                        <td class="w-30">{{ Helpers::getdateFormat($data->risk_analysis_completed_on) }}</td>
                        <th class="w-20">Residual Risk Evaluation Completed Comment</th>
                        <td class="w-30">{{ $data->risk_analysis_completed_comment }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Cancel By</th>
                        <td class="w-30">{{ $data->cancelled_by }}</td>
                        <th class="w-20">Cancel On</th>
                        <td class="w-30">{{ Helpers::getdateFormat($data->cancelled_on) }}</td>
                        <th class="w-20">Cancel Comment</th>
                        <td class="w-30">{{ $data->cancelled_comment }}</td>
                    </tr>
                   


                </table>
            </div>
        </div>
    </div>

    

  

</body>

</html>
