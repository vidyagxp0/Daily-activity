@extends('frontend.layout.main')
@section('container')

    
<div id="rcms-dashboard">
        <div class="container-fluid">
            <div class="dash-grid">


                <div>
                    <div class="inner-block scope-table" style="height: calc(100vh - 170px); padding: 0;">
                       <!-- <div class="grid-block">
                            <div class="group-input">
                                <label for="scope">Process</label>
                                <select id="scope" name="form">
                                    <option value="">All Records</option>
                                    @foreach ($uniqueProcessNames as $ultraprocess)
                                        <option value={{ $ultraprocess }}>{{ $ultraprocess }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="group-input">
                                <label for="query">Criteria</label>
                                <select id="query" name="stage">
                                    <option value="">All Records</option>
                                    <option value="Closed">Closed Records</option>
                                    <option value="Opened">Opened Records</option>
                                    <option value="Cancelled">Cancelled Records</option>
                                    <option value="">Initial Deviation Category= Minor</option>
                                    <option value="">Initial Deviation Category= Major</option>
                                    <option value="">Initial Deviation Category= Critical</option>
                                     <option value="">Post Categorization Of Deviation= Minor</option>
                                    <option value="">Post Categorization Of Deviation= Major</option>
                                    <option value="">Post Categorization Of Deviation= Critical</option>
                                </select>
                            </div>
                            <div class="item-btn" onclick="window.print()">Print</div>
                        </div> -->



                        <div class="main-scope-table table-container">
                        <div class="main-scope-table table-container">
                            <table class="table table-bordered" id="auditTable">
                                <thead class="table-header11">
                                    <tr>
                                        <th>ID</th>
                                        <th>Parent ID</th>
                                        <th>Division</th>
                                        <th>Process</th>
                                        <th>Initiated Through</th>
                                        <th class="td_desc">Short Description</th>
                                        <th>Date Opened</th>
                                        <th>Originator</th>
                                        <th> Due Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody id="searchTable">
                                    @php
                                        $table = json_encode($datag);
                                        $tables = json_decode($table);
                                        $total_count = count($datag);

                                    @endphp
                                    @foreach (collect($tables->data)->sortByDesc('date_open') as $datas)
                                        <tr>
                                            <td>
                                                @if ($datas->type == 'Change-Control')
                                                    <a href="{{ route('CC.show', $datas->id) }}" style="color: blue">
                                                        {{ str_pad(($total_count - $loop->index), 4, '0', STR_PAD_LEFT) }}
                                                    </a>
                                                    <a href="{{ url('rcms/qms-dashboard', $datas->id) }}/CC">
                                                        <div class="icon" onclick="showChild()" data-bs-toggle="tooltip"
                                                            title="Related Records">
                                                            {{-- <img src="{{ asset('user/images/single.png') }}" alt="..."
                                                                class="w-100 h-100"> --}}
                                                        </div>
                                                    </a>
                                                    {{-- -----------------------by pankaj-------------------- --}}
                                                @elseif ($datas->type == 'Internal-Audit')
                                                    <a href="{{ route('showInternalAudit', $datas->id) }}" style="color: blue">
                                                        {{ str_pad(($total_count - $loop->index), 4, '0', STR_PAD_LEFT) }}
                                                    </a>
                                                    @if (!empty($datas->parent_id))
                                                        <a
                                                            href="{{ url('rcms/qms-dashboard_new', $datas->id) }}/internal_audit">
                                                            <div class="icon" onclick="showChild()"
                                                                data-bs-toggle="tooltip" title="Related Records">
                                                                {{-- <img src="{{ asset('user/images/parent.png') }}"
                                                                    alt="..." class="w-100 h-100"> --}}
                                                            </div>
                                                        </a>
                                                    @endif
                                                                {{-- market complaint --}}

                                                @elseif ($datas->type == 'Market Complaint')
                                                    <a href="{{ route('marketcomplaint.marketcomplaint_view', $datas->id) }}" style="color: blue">
                                                        {{ str_pad(($total_count - $loop->index), 4, '0', STR_PAD_LEFT) }}
                                                    </a>
                                                    @if (!empty($datas->parent_id))
                                                        <a
                                                            href="{{ url('rcms/qms-dashboard_new', $datas->id) }}/internal_audit">
                                                            <div class="icon" onclick="showChild()"
                                                                data-bs-toggle="tooltip" title="Related Records">
                                                                {{-- <img src="{{ asset('user/images/parent.png') }}"
                                                                    alt="..." class="w-100 h-100"> --}}
                                                            </div>
                                                        </a>
                                                    @endif
                                                @elseif ($datas->type == 'Risk-Assesment')
                                                    <a href="{{ route('showRiskManagement', $datas->id) }}" style="color: blue">
                                                        {{ str_pad(($total_count - $loop->index), 4, '0', STR_PAD_LEFT) }}
                                                    </a>
                                                    @if (!empty($datas->parent_id))
                                                        <a
                                                            href="{{ url('rcms/qms-dashboard_new', $datas->id) }}/risk_assesment">
                                                            <div class="icon" onclick="showChild()"
                                                                data-bs-toggle="tooltip" title="Related Records">
                                                                {{-- <img src="{{ asset('user/images/parent.png') }}"
                                                                    alt="..." class="w-100 h-100"> --}}
                                                            </div>
                                                        </a>
                                                    @endif
                                                @elseif ($datas->type == 'Lab-Incident')
                                                    <a href="{{ route('ShowLabIncident', $datas->id) }}" style="color: blue">
                                                        {{ str_pad(($total_count - $loop->index), 4, '0', STR_PAD_LEFT) }}
                                                    </a>
                                                    @if (!empty($datas->parent_id))
                                                        <a
                                                            href="{{ url('rcms/qms-dashboard_new', $datas->id) }}/lab_incident">
                                                            <div class="icon" onclick="showChild()"
                                                                data-bs-toggle="tooltip" title="Related Records">
                                                                {{-- <img src="{{ asset('user/images/parent.png') }}"
                                                                    alt="..." class="w-100 h-100"> --}}
                                                            </div>
                                                        </a>
                                                    @endif

                                                @elseif ($datas->type == 'Incident')
                                                    <a href="{{ route('incident-show', $datas->id) }}" style="color: blue">
                                                        {{ str_pad(($total_count - $loop->index), 4, '0', STR_PAD_LEFT) }}
                                                    </a>
                                                    @if (!empty($datas->parent_id))
                                                        <a
                                                            href="{{ url('rcms/qms-dashboard_new', $datas->id) }}/lab_incident">
                                                            <div class="icon" onclick="showChild()"
                                                                data-bs-toggle="tooltip" title="Related Records">
                                                                {{-- <img src="{{ asset('user/images/parent.png') }}"
                                                                    alt="..." class="w-100 h-100"> --}}
                                                            </div>
                                                        </a>
                                                    @endif

                                                @elseif ($datas->type == 'Out Of Calibration')
                                                    <a href="{{ route('ShowOutofCalibration', $datas->id) }}" style="color: blue">
                                                        {{ str_pad(($total_count - $loop->index), 4, '0', STR_PAD_LEFT) }}
                                                    </a>
                                                    @if (!empty($datas->parent_id))
                                                        <a
                                                            href="{{ url('rcms/qms-dashboard_new', $datas->id) }}/Out_Of_Calibration">
                                                            <div class="icon" onclick="showChild()"
                                                                data-bs-toggle="tooltip" title="Related Records">
                                                                {{-- <img src="{{ asset('user/images/parent.png') }}"
                                                                    alt="..." class="w-100 h-100"> --}}
                                                            </div>
                                                        </a>
                                                    @endif
                                                @elseif ($datas->type == 'External-Audit')
                                                    <a href="{{ route('showExternalAudit', $datas->id) }}" style="color: blue">
                                                        {{ str_pad(($total_count - $loop->index), 4, '0', STR_PAD_LEFT) }}
                                                    </a>
                                                    @if (!empty($datas->parent_id))
                                                        <a
                                                            href="{{ url('rcms/qms-dashboard_new', $datas->id) }}/external_audit">
                                                            <div class="icon" onclick="showChild()"
                                                                data-bs-toggle="tooltip" title="Related Records">
                                                                {{-- <img src="{{ asset('user/images/parent.png') }}"
                                                                    alt="..." class="w-100 h-100"> --}}
                                                            </div>
                                                        </a>
                                                    @endif
                                                @elseif ($datas->type == 'Audit-Program')
                                                    <a href="{{ route('ShowAuditProgram', $datas->id) }}" style="color: blue">
                                                        {{ str_pad(($total_count - $loop->index), 4, '0', STR_PAD_LEFT) }}
                                                    </a>
                                                    @if (!empty($datas->parent_id))
                                                        <a
                                                            href="{{ url('rcms/qms-dashboard_new', $datas->id) }}/audit_program">
                                                            <div class="icon" onclick="showChild()"
                                                                data-bs-toggle="tooltip" title="Related Records">
                                                                {{-- <img src="{{ asset('user/images/parent.png') }}"
                                                                    alt="..." class="w-100 h-100"> --}}
                                                            </div>
                                                        </a>
                                                    @endif
                                                @elseif ($datas->type == 'Observation')
                                                    <a href="{{ route('showobservation', $datas->id) }}" style="color: blue">
                                                        {{ str_pad(($total_count - $loop->index), 4, '0', STR_PAD_LEFT) }}
                                                    </a>
                                                    @if (!empty($datas->parent_id))
                                                        <a
                                                            href="{{ url('rcms/qms-dashboard_new', $datas->id) }}/observation">
                                                            <div class="icon" onclick="showChild()"
                                                                data-bs-toggle="tooltip" title="Related Records">
                                                                {{-- <img src="{{ asset('user/images/parent.png') }}"
                                                                    alt="..." class="w-100 h-100"> --}}
                                                            </div>
                                                        </a>
                                                    @endif
                                                @elseif($datas->type == 'Action-Item')
                                                    <a href="{{ route('actionItem.show', $datas->id) }}" style="color: blue">
                                                        {{ str_pad(($total_count - $loop->index), 4, '0', STR_PAD_LEFT) }}
                                                    </a>
                                                    @if (!empty($datas->parent_id))
                                                        <a
                                                            href="{{ url('rcms/qms-dashboard_new', $datas->id) }}/action_item">
                                                            <div class="icon" onclick="showChild()"
                                                                data-bs-toggle="tooltip" title="Related Records">
                                                                {{-- <img src="{{ asset('user/images/parent.png') }}"
                                                                    alt="..." class="w-100 h-100"> --}}
                                                            </div>
                                                        </a>
                                                    @endif
                                                @elseif($datas->type == 'Extension')
                                                    <a href="{{ url('extension_newshow', $datas->id) }}" style="color: blue">
                                                        {{ str_pad(($total_count - $loop->index), 4, '0', STR_PAD_LEFT) }}
                                                    </a>
                                                    @if (!empty($datas->parent_id))
                                                        <a
                                                            href="{{ url('rcms/qms-dashboard_new', $datas->id) }}/extension">
                                                            <div class="icon" onclick="showChild()"
                                                                data-bs-toggle="tooltip" title="Related Records">
                                                            </div>
                                                        </a>
                                                    @endif
                                                @elseif($datas->type == 'Effectiveness-Check')
                                                    <a href="{{ route('effectiveness.show', $datas->id) }}" style="color: blue">
                                                        {{ str_pad(($total_count - $loop->index), 4, '0', STR_PAD_LEFT) }}
                                                    </a>
                                                    @if (!empty($datas->parent_id))
                                                        <a
                                                            href="{{ url('rcms/qms-dashboard_new', $datas->id) }}/effectiveness_check">
                                                            <div class="icon" onclick="showChild()"
                                                                data-bs-toggle="tooltip" title="Related Records">
                                                                {{-- <img src="{{ asset('user/images/parent.png') }}"
                                                                    alt="..." class="w-100 h-100"> --}}
                                                            </div>
                                                        </a>
                                                    @endif
                                                @elseif($datas->type == 'Capa')
                                                    <a href="{{ route('capashow', $datas->id) }}" style="color: blue">
                                                        {{ str_pad(($total_count - $loop->index), 4, '0', STR_PAD_LEFT) }}
                                                    </a>
                                                    @if (!empty($datas->parent_id))
                                                        <a href="{{ url('rcms/qms-dashboard_new', $datas->id) }}/capa">
                                                            <div class="icon" onclick="showChild()"
                                                                data-bs-toggle="tooltip" title="Related Records">
                                                                {{-- <img src="{{ asset('user/images/parent.png') }}"
                                                                    alt="..." class="w-100 h-100"> --}}
                                                            </div>
                                                        </a>
                                                    @endif
                                                {{-- @elseif($datas->type == 'OOS Chemical')
                                                    <a href="{{ route('oos.oos_view', $datas->id) }}" style="color: blue">
                                                        {{ str_pad(($total_count - $loop->index), 4, '0', STR_PAD_LEFT) }}
                                                    </a>
                                                    @if (!empty($datas->parent_id))
                                                        <a
                                                            href="{{ url('rcms/qms-dashboard_new', $datas->id) }}/management_review">
                                                            <div class="icon" onclick="showChild()"
                                                                data-bs-toggle="tooltip" title="Related Records">
                                                            </div>
                                                        </a>
                                                    @endif --}}
                                                @elseif($datas->type == 'OOS Chemical')
                                                    <a href="{{ route('oos.oos_view', $datas->id) }}" style="color: blue">
                                                        {{ str_pad(($total_count - $loop->index), 4, '0', STR_PAD_LEFT) }}
                                                    </a>
                                                    @if (!empty($datas->parent_id))
                                                        <a
                                                            href="{{ url('rcms/qms-dashboard_new', $datas->id) }}/errata">
                                                            <div class="icon" onclick="showChild()"
                                                                data-bs-toggle="tooltip" title="Related Records">
                                                                {{-- <img src="{{ asset('user/images/parent.png') }}"
                                                                    alt="..." class="w-100 h-100"> --}}
                                                            </div>
                                                        </a>
                                                    @endif
                                                @elseif($datas->type == 'ERRATA')
                                                    <a href="{{ route('errata.show', $datas->id) }}" style="color: blue">
                                                        {{ str_pad(($total_count - $loop->index), 4, '0', STR_PAD_LEFT) }}
                                                    </a>
                                                    @if (!empty($datas->parent_id))
                                                        <a
                                                            href="{{ url('rcms/qms-dashboard_new', $datas->id) }}/errata">
                                                            <div class="icon" onclick="showChild()"
                                                                data-bs-toggle="tooltip" title="Related Records">
                                                                {{-- <img src="{{ asset('user/images/parent.png') }}"
                                                                    alt="..." class="w-100 h-100"> --}}
                                                            </div>
                                                        </a>
                                                    @endif
                                                @elseif($datas->type == 'OOS Microbiology')
                                                    <a href="{{ route('oos_micro.edit', $datas->id) }}" style="color: blue">
                                                        {{ str_pad(($total_count - $loop->index), 4, '0', STR_PAD_LEFT) }}
                                                    </a>
                                                    @if (!empty($datas->parent_id))
                                                        <a href="{{ url('rcms/qms-dashboard_new', $datas->id) }}/capa">
                                                            <div class="icon" onclick="showChild()"
                                                                data-bs-toggle="tooltip" title="Related Records">
                                                                {{-- <img src="{{ asset('user/images/parent.png') }}"
                                                                    alt="..." class="w-100 h-100"> --}}
                                                            </div>
                                                        </a>
                                                    @endif

                                                @elseif($datas->type == 'ERRATA')
                                                    <a href="{{ route('errata.show', $datas->id) }}">
                                                        {{ str_pad(($total_count - $loop->index), 4, '0', STR_PAD_LEFT) }}{{ $datas->id }}
                                                    </a>
                                                    @if (!empty($datas->parent_id))
                                                        <a
                                                            href="{{ url('rcms/qms-dashboard_new', $datas->id) }}/management_review">
                                                            <div class="icon" onclick="showChild()"
                                                                data-bs-toggle="tooltip" title="Related Records">
                                                                {{-- <img src="{{ asset('user/images/parent.png') }}"
                                                                    alt="..." class="w-100 h-100"> --}}
                                                            </div>
                                                        </a>
                                                    @endif
                                                @elseif($datas->type == 'Management-Review')
                                                    <a href="{{ route('manageshow', $datas->id) }}" style="color: blue">
                                                        {{ str_pad(($total_count - $loop->index), 4, '0', STR_PAD_LEFT) }}
                                                    </a>
                                                    @if (!empty($datas->parent_id))
                                                        <a
                                                            href="{{ url('rcms/qms-dashboard_new', $datas->id) }}/management_review">
                                                            <div class="icon" onclick="showChild()"
                                                                data-bs-toggle="tooltip" title="Related Records">
                                                                {{-- <img src="{{ asset('user/images/parent.png') }}"
                                                                    alt="..." class="w-100 h-100"> --}}
                                                            </div>
                                                        </a>
                                                    @endif
                                                @elseif($datas->type == 'Deviation')
                                                    <a href="{{ route('devshow', $datas->id) }}" style="color: blue">
                                                        {{ str_pad(($total_count - $loop->index), 4, '0', STR_PAD_LEFT) }}
                                                    </a>
                                                    @if (!empty($datas->parent_id))
                                                        <a
                                                            href="{{ url('rcms/qms-dashboard_new', $datas->id) }}/deviation">
                                                            <div class="icon" onclick="showChild()"
                                                                data-bs-toggle="tooltip" title="Related Records">
                                                                {{-- <img src="{{ asset('user/images/parent.png') }}"
                                                                    alt="..." class="w-100 h-100"> --}}
                                                            </div>
                                                        </a>
                                                    @endif
                                                @elseif($datas->type == 'Deviation')
                                                    <a href="{{ route('devshow', $datas->id) }}" style="color: blue">
                                                        {{ str_pad(($total_count - $loop->index), 4, '0', STR_PAD_LEFT) }}
                                                    </a>
                                                    @if (!empty($datas->parent_id))
                                                        <a
                                                            href="{{ url('rcms/qms-dashboard_new', $datas->id) }}/deviation">
                                                            <div class="icon" onclick="showChild()"
                                                                data-bs-toggle="tooltip" title="Related Records">
                                                                {{-- <img src="{{ asset('user/images/parent.png') }}"
                                                                    alt="..." class="w-100 h-100"> --}}
                                                            </div>
                                                        </a>
                                                    @endif
                                                @elseif($datas->type == 'Failure Investigation')
                                                        <a href="{{ route('failure-investigation-show', $datas->id) }}" style="color: blue">
                                                            {{ str_pad(($total_count - $loop->index), 4, '0', STR_PAD_LEFT) }}
                                                        </a>
                                                        @if (!empty($datas->parent_id))
                                                            <a
                                                                href="{{ url('rcms/qms-dashboard_new', $datas->id) }}/deviation">
                                                                <div class="icon" onclick="showChild()"
                                                                    data-bs-toggle="tooltip" title="Related Records">
                                                                    {{-- <img src="{{ asset('user/images/parent.png') }}"
                                                                        alt="..." class="w-100 h-100"> --}}
                                                                </div>
                                                            </a>
                                                        @endif
                                                @elseif($datas->type == 'Non Conformance')
                                                        <a href="{{ route('non-conformance-show', $datas->id) }}" style="color: blue">
                                                            {{ str_pad(($total_count - $loop->index), 4, '0', STR_PAD_LEFT) }}
                                                        </a>
                                                        @if (!empty($datas->parent_id))
                                                            <a
                                                                href="{{ url('rcms/qms-dashboard_new', $datas->id) }}/deviation">
                                                                <div class="icon" onclick="showChild()"
                                                                    data-bs-toggle="tooltip" title="Related Records">
                                                                    {{-- <img src="{{ asset('user/images/parent.png') }}"
                                                                        alt="..." class="w-100 h-100"> --}}
                                                                </div>
                                                            </a>
                                                        @endif
                                                @elseif($datas->type == 'Root-Cause-Analysis')
                                                    <a href="{{ route('root_show', $datas->id) }}" style="color: blue">
                                                        {{ str_pad(($total_count - $loop->index), 4, '0', STR_PAD_LEFT) }}
                                                    </a>
                                                    @if (!empty($datas->parent_id))
                                                        <a
                                                            href="{{ url('rcms/qms-dashboard_new', $datas->id) }}/root_cause_analysis">
                                                            <div class="icon" onclick="showChild()"
                                                                data-bs-toggle="tooltip" title="Related Records">
                                                                {{-- <img src="{{ asset('user/images/parent.png') }}"
                                                                    alt="..." class="w-100 h-100"> --}}
                                                            </div>
                                                        </a>
                                                    @endif
                                                @elseif($datas->type == 'OOT')
                                                    <a href="{{ route('rcms/oot_view', $datas->id) }}" style="color: blue">
                                                        {{ str_pad(($total_count - $loop->index), 4, '0', STR_PAD_LEFT) }}
                                                    </a>
                                                    @if (!empty($datas->parent_id))
                                                        <a
                                                            href="{{ url('rcms/qms-dashboard_new', $datas->id) }}/root_cause_analysis">
                                                            <div class="icon" onclick="showChild()"
                                                                data-bs-toggle="tooltip" title="Related Records">
                                                                {{-- <img src="{{ asset('user/images/parent.png') }}"
                                                                    alt="..." class="w-100 h-100"> --}}
                                                            </div>
                                                        </a>
                                                    @endif
                                                @endif
                                            </td>
                                            @if ($datas->parent_id != null)
                                                        <td>
                                                            {{ str_pad($datas->parent_id, 4, '0', STR_PAD_LEFT) }}
                                                        </td>
                                                    @else
                                                        <td>
                                                            -
                                                        </td>
                                            @endif
                                            <td class="viewdetails" data-id="{{ $datas->id }}"
                                                data-type="{{ $datas->type }}" data-bs-toggle="modal"
                                                data-bs-target="#record-modal">
                                                @if ($datas->division_id)
                                                    {{ Helpers::getDivisionName($datas->division_id) }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="viewdetails" data-id="{{ $datas->id }}"
                                                data-type="{{ $datas->type }}" data-bs-toggle="modal"
                                                data-bs-target="#record-modal" style="{{ $datas->type == 'Capa' ? 'text-transform: uppercase' : '' }}">
                                                {{ $datas->type }}
                                            </td>

                                            <td class="viewdetails" data-id="{{ $datas->id }}"
                                                data-type="{{ $datas->type }}" data-bs-toggle="modal"
                                                data-bs-target="#record-modal">
                                                {{ ucwords(str_replace('_', ' ', $datas->initiated_through)) }}
                                            </td>

                                            <td id="short_width" class="viewdetails" data-id="{{ $datas->id }}"
                                                data-type="{{ $datas->type }}" data-bs-toggle="modal"
                                                data-bs-target="#record-modal">
                                                {{ $datas->short_description }}
                                            </td>
                                            @php
                                                $date = new \DateTime($datas->date_open);
                                                $formattedDate = $date->format('d-M-Y H:i:s');
                                            @endphp

                                            <td class="viewdetails" data-id="{{ $datas->id }}"
                                                data-type="{{ $datas->type }}" data-bs-toggle="modal"
                                                data-bs-target="#record-modal">
                                                {{ $formattedDate }}
                                            </td>
                                            <td class="viewdetails" data-id="{{ $datas->id }}"
                                                data-type="{{ $datas->type }}" data-bs-toggle="modal"
                                                data-bs-target="#record-modal">
                                                {{ Helpers::getInitiatorName($datas->initiator_id) }}
                                            </td>
                                            <td class="viewdetails" data-id="{{ $datas->id }}"
                                                data-type="{{ $datas->type }}" data-bs-toggle="modal"
                                                data-bs-target="#record-modal">
                                                @if (property_exists($datas, 'due_date'))
                                                    {{ $datas->type !== 'Extension' ? Helpers::getdateFormat($datas->due_date) : ''  }}
                                                @endif
                                            </td>
                                            <td class="viewdetails" data-id="{{ $datas->id }}"
                                                data-type="{{ $datas->type }}" data-bs-toggle="modal"
                                                data-bs-target="#record-modal">
                                                {{ $datas->stage }}
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
