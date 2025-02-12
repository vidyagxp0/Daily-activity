@extends('frontend.layout.main')
@section('container')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function addFishBone(top, bottom) {
            let mainBlock = document.querySelector('.fishbone-ishikawa-diagram');
            let topBlock = mainBlock.querySelector(top)
            let bottomBlock = mainBlock.querySelector(bottom)

            let topField = document.createElement('div')
            topField.className = 'grid-field fields top-field'

            let measurement = document.createElement('div')
            let measurementInput = document.createElement('input')
            measurementInput.setAttribute('type', 'text')
            measurementInput.setAttribute('name', 'measurement[]')
            measurement.append(measurementInput)
            topField.append(measurement)

            let materials = document.createElement('div')
            let materialsInput = document.createElement('input')
            materialsInput.setAttribute('type', 'text')
            materialsInput.setAttribute('name', 'materials[]')
            materials.append(materialsInput)
            topField.append(materials)

            let methods = document.createElement('div')
            let methodsInput = document.createElement('input')
            methodsInput.setAttribute('type', 'text')
            methodsInput.setAttribute('name', 'methods[]')
            methods.append(methodsInput)
            topField.append(methods)

            topBlock.prepend(topField)

            let bottomField = document.createElement('div')
            bottomField.className = 'grid-field fields bottom-field'

            let environment = document.createElement('div')
            let environmentInput = document.createElement('input')
            environmentInput.setAttribute('type', 'text')
            environmentInput.setAttribute('name', 'environment[]')
            environment.append(environmentInput)
            bottomField.append(environment)

            let manpower = document.createElement('div')
            let manpowerInput = document.createElement('input')
            manpowerInput.setAttribute('type', 'text')
            manpowerInput.setAttribute('name', 'manpower[]')
            manpower.append(manpowerInput)
            bottomField.append(manpower)

            let machine = document.createElement('div')
            let machineInput = document.createElement('input')
            machineInput.setAttribute('type', 'text')
            machineInput.setAttribute('name', 'machine[]')
            machine.append(machineInput)
            bottomField.append(machine)

            bottomBlock.append(bottomField)
        }

        function deleteFishBone(top, bottom) {
            let mainBlock = document.querySelector('.fishbone-ishikawa-diagram');
            let topBlock = mainBlock.querySelector(top)
            let bottomBlock = mainBlock.querySelector(bottom)
            if (topBlock.firstChild) {
                topBlock.removeChild(topBlock.firstChild);
            }
            if (bottomBlock.lastChild) {
                bottomBlock.removeChild(bottomBlock.lastChild);
            }
        }
    </script>
    <script>
        function addWhyField(con_class, name) {
            let mainBlock = document.querySelector('.why-why-chart')
            let container = mainBlock.querySelector(`.${con_class}`)
            let textarea = document.createElement('textarea')
            textarea.setAttribute('name', name);
            container.append(textarea)
        }
    </script>
    <script>
        function calculateInitialResult(selectElement) {
            let row = selectElement.closest('tr');
            let R = parseFloat(row.querySelector('.fieldR').value) || 0;
            let P = parseFloat(row.querySelector('.fieldP').value) || 0;
            let N = parseFloat(row.querySelector('.fieldN').value) || 0;
            let result = R * P * N;

            // Update the result field within the row
            row.querySelector('.initial-rpn').value = result;
        }
    </script>
    <script>
        function calculateResidualResult(selectElement) {
            // Get the row containing the changed select element
            let row = selectElement.closest('tr');

            // Get values from select elements within the row
            let R = parseFloat(row.querySelector('.residual-fieldR').value) || 0;
            let P = parseFloat(row.querySelector('.residual-fieldP').value) || 0;
            let N = parseFloat(row.querySelector('.residual-fieldN').value) || 0;

            // Perform the calculation
            let result = R * P * N;

            // Update the result field within the row
            row.querySelector('.residual-rpn').value = result;
        }
    </script>
    <script>
        function calculateRiskAnalysis(selectElement) {
            // Get the row containing the changed select element
            let row = selectElement.closest('tr');

            // Get values from select elements within the row
            let R = parseFloat(document.getElementById('analysisR').value) || 0;
            let P = parseFloat(document.getElementById('analysisP').value) || 0;
            let N = parseFloat(document.getElementById('analysisN').value) || 0;

            // Perform the calculation
            let result = R * P * N;

            // Update the result field within the row
            document.getElementById('analysisRPN').value = result;
        }
    </script>
    <script>
        function calculateRiskAnalysis2(selectElement) {
            // Get the row containing the changed select element
            let row = selectElement.closest('tr');

            // Get values from select elements within the row
            let R = parseFloat(document.getElementById('analysisR2').value) || 0;
            let P = parseFloat(document.getElementById('analysisP2').value) || 0;
            let N = parseFloat(document.getElementById('analysisN2').value) || 0;

            // Perform the calculation
            let result = R * P * N;

            // Update the result field within the row
            document.getElementById('analysisRPN2').value = result;
        }
    </script>

{{--Side Bar Workflow CSS start--}}
<style>
    .sticky-buttons div {
         background: #de8d0a;
         /*background: #4274da;*/
         width: 40px;
         height: 40px;
         display: grid;
         place-items: center;
         border-radius: 0 5px 5px 0;
     }
        .sticky-buttons {
                    position: fixed;
                    top: 50%;
                    left: 0;
                    transform: translate(0, -50%);
                    display: grid;
                    gap: 10px;
                    z-index: 5;
                }
        .btn-position{
                top:50%;
                left:50%;
                transform:translate(-50%, -50%);
                position:absolute;
                }
            .modal.right.fade.in .modal-dialog {
            right:0 !important;
            transform: translateX(-50%);
            }
        
        .modal.right .modal-content {
        height:100%;
        overflow:auto;
        border-radius:0;
        }
        
        .modal.right .modal-dialog {
                position: fixed;
                margin: auto;
                height: 100%;
                -webkit-transform: translate3d(0%, 0, 0);
                -ms-transform: translate3d(0%, 0, 0);
                -o-transform: translate3d(0%, 0, 0);
                transform: translate3d(0%, 0, 0);
                }
        
        .modal.right.fade.in .modal-dialog {
        transform: translateX(0%);
        }
        .modal.right.fade .modal-dialog {
        
        -webkit-transition: opacity 0.3s linear, right 0.3s ease-out;
        -moz-transition: opacity 0.3s linear, right 0.3s ease-out;
        -o-transition: opacity 0.3s linear, right 0.3s ease-out;
        transition: opacity 0.3s linear, right 0.3s ease-out;
        width: 340px;
        }
                        
            
            .modal.right .modal-header {
            background-color:#bfd0f2; 
            display: flex;
            justify-content: center;
            color:#fff
        }
            .modal.right .modal-header::after {content:""; display:inline-block;}
            .modal.right .close {text-shadow:none; opacity:1; color:#ff4d4d; font-size:26px}
        /*  form-control  */
            
            .form-control {border-radius:0; box-shadow:none}
            .form-control:focus {box-shadow:none}
            
            
        /*  Button  */
        
            
            .btn {border-radius:0}
        
            .down-logo {
            display: flex;
            justify-content: center;
        }
        .dawn_arrow {
            /* position: absolute; */
            top: 100%;
            left: 50%;
            transform: rotate(90deg) translate(-12%, 23px);
            width: 50px;
            height: 50px;
            margin-left: 42px;
        }
        
                /* scrollbar */
                ::-webkit-scrollbar {
                    width: 5px;
                    height: 5px;
                }
                
                ::-webkit-scrollbar-track {
                    -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
                    -webkit-border-radius: 15px;
                    border-radius: 15px;
                }
                
                ::-webkit-scrollbar-thumb {
                    -webkit-border-radius: 15px;
                    border-radius: 15px;
                    background: rgba(255, 255, 255, 0.3);
                    -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.5);
                }
                
                ::-webkit-scrollbar-thumb:window-inactive {
                    background: rgba(255, 255, 255, 0.3);
                }
            
                    .mini_buttons{
                        /* background: #1aa71a; */
                        display: flex;
                        border: 1px solid;
                        padding: 5px;
                        width: 250px;
                        border-radius: 10px;
                        justify-content: center;
                    }
                    .button-box .active{
                        background: #1aa71a;
                        display: flex;
                        border: 1px solid;
                        border-radius: 10px;
                        padding: 7px;
                        width: 250px;
                        justify-content: center;
                    }
                    .main-new-workflow{
                        display: flex;
                        justify-content: center;
                    }
                    .state-block .top-block {
                        background: #4274da;
                        color: white;
                        display: grid;
                        grid-template-columns: repeat(4, 1fr);
                    }
                    .state-block .top-block div {
                        padding: 10px 20px;
                        border-right: 1px dashed #ffffff;
                        font-size: 0.9rem;
                    }

                </style>
{{--Side Bar Workflow CSS end--}}


    <style>
        textarea.note-codable {
            display: none !important;
        }

        header {
            display: none;
        }
        iframe#\:2\.container {
        /* display: none; */
        height: 0px !important;
        background: #4274da !important;
    }
    img.goog-te-gadget-icon {
        display: none;
    }
    .skiptranslate.goog-te-gadget {
        margin-bottom: 0px;
    }
    div#google_translate_element {
        border: none;
    }
    .VIpgJd-ZVi9od-aZ2wEe-wOHMyf.VIpgJd-ZVi9od-aZ2wEe-wOHMyf-ti6hGc {
        display: none;
    }
    </style>

    @php
        $users = DB::table('users')->get();
    @endphp

    <div class="form-field-head">

        <div class="division-bar">
            <strong>Site Division/Project</strong> :
            {{ Helpers::getDivisionName($data->division_id) }} / Risk Assessment
        </div>
    </div>

    {{-- ---------------------- --}}
    <div id="change-control-view">
        <div class="container-fluid">

            <div class="inner-block state-block">
                <div class="language-sleect d-flex" style="align-items: center; gap: 20px; margin-left: 20px;">
                    <div>Select Language </div>
                <div class="main-head" id="google_translate_element"></div>
                </div>
                            
                <script type="text/javascript">
                    function googleTranslateElementInit() {
                        new google.translate.TranslateElement({
                            pageLanguage: 'en',
                            includedLanguages: 'en,es,fr,de,zh,hi,ar,pt,ja,ru',
                            layout: google.translate.TranslateElement.InlineLayout.SIMPLE
                        }, 'google_translate_element');
                    }
                </script>                                            
                <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
                <script>
                    $(document).ready(function() {
                        setTimeout(() => {
                            $('body').css('top', '0');
                        }, 5000);
                    })
                </script>
                <div class="d-flex justify-content-between align-items-center">
                    <div class="main-head">Record Workflow </div>

                    <div class="d-flex" style="gap:20px;">
                        @php
                        $userRoles = DB::table('user_roles')->where(['user_id' => Auth::user()->id])->get();
                        $userRoleIds = $userRoles->pluck('q_m_s_roles_id')->toArray(); 
                    @endphp
                        {{-- <a href="{{route('riskSingleReport', $data->id)}}"><button class="button_theme1"
                            class="new-doc-btn">Print</button></a> --}}

                        <button class="button_theme1"> <a class="text-white" href="{{ url('riskAuditTrial', $data->id) }}">
                                Audit Trail </a> </button>

                        @if ($data->stage == 1 && (in_array(3, $userRoleIds) || in_array(18, $userRoleIds)))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Submit
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-modal">
                                Cancel
                            </button>
                        @elseif($data->stage == 2 && (in_array(4, $userRoleIds) || in_array(18, $userRoleIds)))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#rejection-modal">
                                More Information Required
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Evaluation Complete
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-modal">
                                Cancel
                            </button>
                        @elseif($data->stage == 3 && (in_array(16, $userRoleIds) || in_array(18, $userRoleIds)))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Action Plan Complete
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#rejection-modal">
                                Request More Info
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#child-modal">
                                Child
                            </button>

                        @elseif($data->stage == 4 && (in_array(4, $userRoleIds) || in_array(18, $userRoleIds)))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Action Plan Approved
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#rejection-modal">
                                Reject Action Plan
                            </button>
                        @elseif($data->stage == 5 && (in_array(7, $userRoleIds) || in_array(18, $userRoleIds)))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                All Actions Completed
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#child-modal">
                                Child
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#rejection-modal">
                                Request More Info
                            </button>
                        @elseif($data->stage == 6 && (in_array(7, $userRoleIds) || in_array(18, $userRoleIds)))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Residual Risk Evaluation Completed
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#rejection-modal">
                                More Actions Needed
                            </button>
                        @endif
                        <button class="button_theme1"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}"> Exit
                            </a> </button>


                    </div>

                </div>


                <div class="status">
                    <div class="head">Current Status</div>
                    {{-- ------------------------------By Pankaj-------------------------------- --}}
                    @if ($data->stage == 0)
                        <div class="progress-bars">
                            <div class="bg-danger">Closed-Cancelled</div>
                        </div>
                    @else
                        <div class="progress-bars">
                            @if ($data->stage >= 1)
                                <div class="active">Opened</div>
                            @else
                                <div class="">Opened</div>
                            @endif

                            @if ($data->stage >= 2)
                                <div class="active">Risk Analysis & Work Group Assignment </div>
                            @else
                                <div class="">Risk Analysis & Work Group Assignment</div>
                            @endif

                            @if ($data->stage >= 3)
                                <div class="active">Risk Processing & Action Plan </div>
                            @else
                                <div class="">Risk Processing & Action Plan</div>
                            @endif

                            @if ($data->stage >= 4)
                                <div class="active">Pending HOD Approval </div>
                            @else
                                <div class="">Pending HOD Approval </div>
                            @endif


                            @if ($data->stage >= 5)
                                <div class="active">Actions Items in Progress</div>
                            @else
                                <div class="">Actions Items in Progress</div>
                            @endif
                            @if ($data->stage >= 6)
                                <div class="active">Residual Risk Evaluation</div>
                            @else
                                <div class="">Residual Risk Evaluation</div>
                            @endif
                            @if ($data->stage >= 7)
                                <div class="bg-danger">Closed - Done</div>
                            @else
                                <div class="">Closed - Done</div>
                            @endif
                    @endif


                </div>
                {{-- @endif --}}
                {{-- ---------------------------------------------------------------------------------------- --}}
            </div>
        </div>

        <div class="control-list">





            {{-- ======================================
                    DATA FIELDS
    ======================================= --}}
            <div id="change-control-fields">
                <div class="container-fluid">

                    <!-- Tab links -->
                    <div class="cctab">
                        <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">Risk/Opportunity Assessment</button>
                        <button class="cctablinks" onclick="openCity(event, 'CCForm2')">Risk/Opportunity details </button>
                        <button class="cctablinks" onclick="openCity(event, 'CCForm3')">Work Group Assignment</button>
                        <button class="cctablinks" onclick="openCity(event, 'CCForm4')">Risk/Opportunity Analysis</button>
                        <button class="cctablinks" onclick="openCity(event, 'CCForm5')">Residual Risk</button>
                        <button class="cctablinks" onclick="openCity(event, 'CCForm6')">Risk Mitigation</button>
                        <button class="cctablinks" onclick="openCity(event, 'CCForm7')">Activity Log</button>
                    </div>

                    <form action="{{ route('riskUpdate', $data->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div id="step-form">

                            <!-- Risk Management Tab content -->
                            <div id="CCForm1" class="inner-block cctabcontent">
                                <div class="inner-block-content">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="RLS Record Number"><b>Record Number</b></label>
                                                <input disabled type="text" name="record_number"
                                                    value="{{ Helpers::getDivisionName($data->division_id) }}/RA/{{ date('Y') }}/{{ str_pad($data->record, 4, '0', STR_PAD_LEFT) }}">
 
                                                    {{--{{ Helpers::getDivisionName($data->division_id) }}/RA/{{ Helpers::year($data->created_at) }}/{{ $data->record }}">--}}
                                                {{-- <div class="static">QMS-EMEA/CAPA/{{ date('Y') }}/{{ $record_number }}</div> --}}
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Division Code"><b>Site/Location Code</b></label>
                                                <input readonly type="text" name="division_code"
                                                    value=" {{ Helpers::getDivisionName($data->division_id) }}">
                                                {{-- <div class="static">{{ Helpers::getDivisionName(session()->get('division')) }}</div> --}}
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Initiator"><b>Initiator</b></label>
                                                {{-- <div class="static">{{ Auth::user()->name }}</div> --}}
                                                <input disabled type="text" name="initiator_id"
                                                    value="{{ $data->initiator_name }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Date Due"><b>Date of Initiation</b></label>
                                                <input disabled type="text"
                                                    value="{{ Helpers::getdateFormat($data->intiation_date) }}"
                                                    name="intiation_date">
                                                {{-- <input type="hidden" value="{{ $data->intiation_date }}" name="intiation_date"> --}}

                                                {{-- <div class="static">{{ date('d-M-Y') }}</div> --}}
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="group-input">
                                                <label for="search">
                                                    Assigned To <span class="text-danger"></span>
                                                </label>
                                                <select id="select-state" {{Helpers::isRiskAssessment($data->stage)}} placeholder="Select..." name="assign_to"
                                                    {{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}>
                                                    <option value="">Select a value</option>
                                                    @foreach ($users as $key => $value)
                                                        <option value="{{ $value->id }}"
                                                            @if ($data->assign_to == $value->id) selected @endif>
                                                            {{ $value->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('assign_to')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="group-input">
                                                <label for="due-date">Due Date <span class="text-danger"></span></label>
                                                <div><small class="text-primary">If revising Due Date, kindly mention revision reason in "Due Date Extension Justification" data field.</small></div>
                                                <input {{Helpers::isRiskAssessment($data->stage)}} readonly type="text"
                                                    value="{{ Helpers::getdateFormat($data->due_date) }}"  
                                                    name="due_date">
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Initiator Group"><b>Initiator Group</b></label>
                                                <select {{Helpers::isRiskAssessment($data->stage)}} name="Initiator_Group" {{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}
                                                     id="initiator_group">
                                                    <option Value="">--Select Group--</option>
                                                    <option value="CQA"
                                                        @if ($data->Initiator_Group== 'CQA') selected @endif>Corporate
                                                        Quality Assurance</option>
                                                    <option value="QAB"
                                                        @if ($data->Initiator_Group== 'QAB') selected @endif>Quality
                                                        Assurance Biopharma</option>
                                                    <option value="CQC"
                                                        @if ($data->Initiator_Group== 'CQC') selected @endif>Central
                                                        Quality Control</option>
                                                    <option value="MANU"
                                                        @if ($data->Initiator_Group== 'MANU') selected @endif>Manufacturing
                                                    </option>
                                                    <option value="PSG"
                                                        @if ($data->Initiator_Group== 'PSG') selected @endif>Plasma
                                                        Sourcing Group</option>
                                                    <option value="CS"
                                                        @if ($data->Initiator_Group== 'CS') selected @endif>Central
                                                        Stores</option>
                                                    <option value="ITG"
                                                        @if ($data->Initiator_Group== 'ITG') selected @endif>Information
                                                        Technology Group</option>
                                                    <option value="MM"
                                                        @if ($data->Initiator_Group== 'MM') selected @endif>Molecular
                                                        Medicine</option>
                                                    <option value="CL"
                                                        @if ($data->Initiator_Group== 'CL') selected @endif>Central
                                                        Laboratory</option>
                                                    <option value="TT"
                                                        @if ($data->Initiator_Group== 'TT') selected @endif>Tech
                                                        team</option>
                                                    <option value="QA"
                                                        @if ($data->Initiator_Group== 'QA') selected @endif>Quality
                                                        Assurance</option>
                                                    <option value="QM"
                                                        @if ($data->Initiator_Group== 'QM') selected @endif>Quality
                                                        Management</option>
                                                    <option value="IA"
                                                        @if ($data->Initiator_Group== 'IA') selected @endif>IT
                                                        Administration</option>
                                                    <option value="ACC"
                                                        @if ($data->Initiator_Group== 'ACC') selected @endif>Accounting
                                                    </option>
                                                    <option value="LOG"
                                                        @if ($data->Initiator_Group== 'LOG') selected @endif>Logistics
                                                    </option>
                                                    <option value="SM"
                                                        @if ($data->Initiator_Group== 'SM') selected @endif>Senior
                                                        Management</option>
                                                    <option value="BA"
                                                        @if ($data->Initiator_Group== 'BA') selected @endif>Business
                                                        Administration</option>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Initiator Group Code">Initiator Group Code</label>
                                                <input {{Helpers::isRiskAssessment($data->stage)}} type="text" name="initiator_group_code" 
                                                    value="{{ $data->Initiator_Group}}" id="initiator_group_code"
                                                    readonly>
                                            </div>
                                        </div>
                                        {{-- <div class="col-12">
                                            <div class="group-input">
                                                <label for="Short Description">Short Description <span
                                                        class="text-danger">*</span></label>
                                                        <div><small class="text-primary">Please mention brief summary</small></div>
                                                <textarea name="short_description" {{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} id="short_desc">{{ $data->short_description }}</textarea>
                                            </div>
                                        </div> --}}
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Short Description">Short Description<span
                                                        class="text-danger">*</span></label><span id="rchars">255</span>
                                                characters remaining
                                                <div class="relative-container">
                                                <input name="short_description"   id="docname" type="text" value="{{ $data->short_description }}" maxlength="255" required  {{ $data->stage == 0 || $data->stage == 7 ? "disabled" : "" }}>
                                                @component('frontend.forms.language-model', ['readonly' => $data->stage == 0 || $data->stage == 8])
                                                @endcomponent
                                                </div>
                                            </div>
                                                  {{-- <p id="docnameError" style="color:red">**Short Description is required</p> --}}
                                        </div>
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="severity-level">Severity Level</label>
                                                <span class="text-primary">Severity levels in a QMS record gauge issue seriousness, guiding priority for corrective actions. Ranging from low to high, they ensure quality standards and mitigate critical risks.</span>
                                                <select {{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} name="severity2_level">
                                                    <option  value="0">-- Select --</option>
                                                    <option @if ($data->severity2_level == 'minor') selected @endif
                                                     value="minor">Minor</option>
                                                    <option  @if ($data->severity2_level == 'major') selected @endif 
                                                    value="major">Major</option>
                                                    <option @if ($data->severity2_level == 'critical') selected @endif
                                                    value="critical">Critical</option>
                                                </select>
                                            </div>
                                        </div>
                                        {{-- --------------------------------------- --}}
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Department(s)">Department(s)</label>

                                                @php
    
                                                    $storedDepartments = $data->departments; 

                                                
                                                    $selectedDepartments = explode(',', $storedDepartments);
                                                @endphp
                                                {{--  <select multiple name="departments[]" placeholder="Select Departments"
                                                    data-search="false" data-silent-initial-value-set="true"
                                                    id="departments" class="new_first_department"
                                                    {{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}>
                                                    <option value="">Select Department</option>
                                                    <option value="1"
                                                        {{ in_array('1', explode(',', $data->departments)) ? 'selected' : '' }}>
                                                        QA</option>
                                                    <option value="2"
                                                        {{ in_array('2', explode(',', $data->departments)) ? 'selected' : '' }}>
                                                        QC</option>
                                                    <option value="3"
                                                        {{ in_array('3', explode(',', $data->departments)) ? 'selected' : '' }}>
                                                        R&D</option>
                                                    <option value="4"
                                                        {{ in_array('4', explode(',', $data->departments)) ? 'selected' : '' }}>
                                                        Manufacturing</option>
                                                    <option value="5"
                                                        {{ in_array('5', explode(',', $data->departments)) ? 'selected' : '' }}>
                                                        Warehouse</option>

                                                </select>  --}}


                                                 <select name="departments[]" placeholder="Select Departments" data-search="false"
                                                        data-silent-initial-value-set="true" id="departments" multiple>
                                                    {{--<option value="">Select Department</option>--}}
                                                    <option value="QA" {{ in_array('QA', $selectedDepartments) ? 'selected' : '' }}>QA</option>
                                                    <option value="QC" {{ in_array('QC', $selectedDepartments) ? 'selected' : '' }}>QC</option>
                                                    <option value="R&D" {{ in_array('R&D', $selectedDepartments) ? 'selected' : '' }}>R&D</option>
                                                    <option value="Wet Chemistry Area" {{ in_array('Wet Chemistry Area', $selectedDepartments) ? 'selected' : '' }}>Wet Chemistry Area</option>
                                                    <option value="Warehouse" {{ in_array('Warehouse', $selectedDepartments) ? 'selected' : '' }}>Warehouse</option>
                                                    <option value="Molecular Area" {{ in_array('Molecular Area', $selectedDepartments) ? 'selected' : '' }}>Molecular Area</option>
                                                    <option value="Microbiology Area" {{ in_array('Microbiology Area', $selectedDepartments) ? 'selected' : '' }}>Microbiology Area</option>
                                                    <option value="Instrumental Area" {{ in_array('Instrumental Area', $selectedDepartments) ? 'selected' : '' }}>Instrumental Area</option>
                                                    <option value="Administration" {{ in_array('Administration', $selectedDepartments) ? 'selected' : '' }}>Administration</option>
                                                    <option value="Financial Department" {{ in_array('Financial Department', $selectedDepartments) ? 'selected' : '' }}>Financial Department</option>
                                                </select>
                                            </div>
                                        </div>
                                        <script>
                                            $(document).ready(function() {
                                                $('#departments').change(function() {
                                                    var selectedOptions = $(this).val();
                                                    console.log('selectedOptions', selectedOptions);
                                                    document.querySelector('#departments').setValue(selectedOptions);
                                                });
                                            });
                                        </script>
                                        
                                        {{-- <div class="col-12">
                                            <div class="group-input">
                                                <label for="Team Members">Team Members</label>
                                                <select multiple name="team_members[]" placeholder="Select Team Members"
                                                    data-search="false" data-silent-initial-value-set="true"
                                                    id="team_members"
                                                    {{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}>
                                                    <option value="">select team member</option>
                                                    <option value="1"
                                                        {{ in_array('1', explode(',', $data->team_members)) ? 'selected' : '' }}>
                                                        Amit Guru</option>
                                                    <option value="2"
                                                        {{ in_array('2', explode(',', $data->team_members)) ? 'selected' : '' }}>
                                                        Anshul Patel</option>
                                                    <option value="3"
                                                        {{ in_array('3', explode(',', $data->team_members)) ? 'selected' : '' }}>
                                                        Vikash Prajapati</option>
                                                    <option value="4"
                                                        {{ in_array('4', explode(',', $data->team_members)) ? 'selected' : '' }}>
                                                        Amit Patel</option>
                                                    <option value="5"
                                                        {{ in_array('5', explode(',', $data->team_members)) ? 'selected' : '' }}>
                                                        Shaleen Mishra</option>
                                                    <option value="6"
                                                        {{ in_array('6', explode(',', $data->team_members)) ? 'selected' : '' }}>
                                                        Madhulika Mishra</option>

                                                </select>
                                            </div>
                                        </div> --}}
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Sourcd of Risk">Source of Risk/Opportunity</label>
                                                <select name="source_of_risk" id="source_of_risk"
                                                    {{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}>
                                                    <option value="">Enter Your Selection Here</option>
                                                    <option {{ $data->source_of_risk == 'Audit' ? 'selected' : '' }}
                                                        value="Audit">Audit</option>
                                                    <option {{ $data->source_of_risk == 'Complaint' ? 'selected' : '' }}
                                                        value="Complaint">Complaint</option>
                                                    <option {{ $data->source_of_risk == 'Employee' ? 'selected' : '' }}
                                                        value="Employee">Employee</option>
                                                    <option {{ $data->source_of_risk == 'Other' ? 'selected' : '' }}
                                                        value="Other">Other</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Type..">Type</label>
                                                <select name="type" id="type"
                                                    {{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}>
                                                    <option value="">Enter Your Selection Here</option>
                                                    <option {{ $data->type == 'Other' ? 'selected' : '' }} value="Other">
                                                        Other</option>
                                                    <option {{ $data->type == 'Business Risk' ? 'selected' : '' }}
                                                        value="Business Risk">Business Risk</option>
                                                    <option {{ $data->type == 'Customer-Related Risk(Complaint)' ? 'selected' : '' }}
                                                        value="Customer-Related Risk(Complaint)">Customer-Related Risk(Complaint)
                                                    </option>
                                                    <option {{ $data->type == 'Opportunity' ? 'selected' : '' }}
                                                        value="Opportunity">Opportunity
                                                    </option>
                                                    <option {{ $data->type == 'Market' ? 'selected' : '' }}
                                                        value="Market">Market</option>
                                                    <option {{ $data->type == 'Operational Risk' ? 'selected' : '' }}
                                                        value="Operational Risk">Operational Risk</option>
                                                    <option {{ $data->type == 'Strategic Risk' ? 'selected' : '' }}
                                                        value="Strategic Risk">Strategic Risk</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Priority Level">Priority Level</label>
                                                <select name="priority_level" id="priority_level"
                                                    {{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}>
                                                    <option value="">Enter Your Selection Here</option>
                                                    <option {{ $data->priority_level == 'High' ? 'selected' : '' }}
                                                        value="High">High</option>
                                                    <option {{ $data->priority_level == 'medium' ? 'selected' : '' }}
                                                        value="medium">medium</option>
                                                    <option {{ $data->priority_level == 'Low' ? 'selected' : '' }}
                                                        value="Low">Low</option>
                                                </select>
                                            </div>
                                        </div>
                                        {{-- <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Zone">Zone</label>
                                                <select name="zone" id="zone"
                                                    {{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}>
                                                    <option value="{{ $data->zone }}">Enter Your Selection Here</option>
                                                    <option {{ $data->zone == 'Asia' ? 'selected' : '' }} value="Asia">
                                                        Asia</option>
                                                    <option {{ $data->zone == 'Europe' ? 'selected' : '' }}
                                                        value="Europe">Europe</option>
                                                    <option {{ $data->zone == 'Africa' ? 'selected' : '' }}
                                                        value="Africa">Africa</option>
                                                    <option {{ $data->zone == 'Central_America' ? 'selected' : '' }}
                                                        value="Central_America">Central America</option>
                                                    <option {{ $data->zone == 'South_America' ? 'selected' : '' }}
                                                        value="South_America">South America</option>
                                                    <option {{ $data->zone == 'Oceania' ? 'selected' : '' }}
                                                        value="Oceania">Oceania</option>
                                                    <option {{ $data->zone == 'North_America' ? 'selected' : '' }}
                                                        value="North_America">North America</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Country">Country</label>
                                                <select name="country" class="countries" id="country" {{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}>
                                                    <option value="{{ $data->country }}">Select Country</option>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="State/District">State/District</label>
                                                <select name="state" class="states" id="stateId" {{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}>
                                                    <option value="{{ $data->state }}">Select State</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="City">City</label>
                                                <select name="city" class="cities" id="city" {{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}>
                                                    <option value="{{ $data->city }}">Select City</option>

                                                </select>
                                            </div>
                                        </div> --}}
                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Description">Risk/Opportunity Description</label>
                                                <div class="relative-container">
                                                <textarea name="description" class="tiny" {{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} id="description">{{ $data->description }}</textarea>
                                                @component('frontend.forms.language-model', ['readonly' => $data->stage == 0 || $data->stage == 8])
                                                @endcomponent
                                                </div>
                                            </div>
                                        </div>
                                       
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Comments">Risk/Opportunity Comments</label>
                                                <div class="relative-container">
                                                <textarea name="comments" class="tiny" {{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} id="comments">{{ $data->comments }}</textarea>
                                                @component('frontend.forms.language-model', ['readonly' => $data->stage == 0 || $data->stage == 8])
                                                @endcomponent
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="CAPA Attachments">Initial Attachment</label>
                                                <div><small class="text-primary">Please Attach all relevant or supporting
                                                        documents</small></div>
                                                {{-- <input multiple type="file" id="myfile" name="capa_attachment[]"> --}}
                                                <div class="file-attachment-field">
                                                    <div class="file-attachment-list" id="capa_attachment">
                                                        @if ($data->capa_attachment)
                                                            @foreach(json_decode($data->capa_attachment) as $file)
                                                            <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                                <b>{{ $file }}</b>
                                                                <a href="{{ asset('upload/' . $file) }}" target="_blank"><i class="fa fa-eye text-primary" style="font-size:20px; margin-right:-10px;"></i></a>
                                                                <a type="button" class="remove-file" data-file-name="{{ $file }}"><i class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i></a>
                                                            </h6>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                    <div class="add-btn">
                                                        <div>Add</div>
                                                        <input type="file" id="myfile" name="capa_attachment[]"
                                                            oninput="addMultipleFiles(this, 'capa_attachment')" multiple>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    </div>
                                    <div class="button-block">
                                        <button type="submit" id="ChangeSaveButton" class="saveButton"
                                            {{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}>Save</button>
                                        <button type="button" id="ChangeNextButton" class="nextButton">Next</button>
                                        <button type="button"> <a class="text-white"
                                                href="{{ url('rcms/qms-dashboard') }}"> Exit </a> </button>
                                    </div>
                                </div>

                            </div>

                            <!-- Risk Details content -->
                            <div id="CCForm2" class="inner-block cctabcontent">
                                <div class="inner-block-content">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Department(s)">Department(s)</label>

                                                @php
                                                
                                                    $storedDepartments2 = $data->departments2; 

                                                
                                                    $selectedDepartments2 = explode(',', $storedDepartments2);
                                                @endphp

                                                {{--  <select multiple name="departments2[]" placeholder="Select Departments"
                                                    data-search="false" data-silent-initial-value-set="true"
                                                    id="departments2" class="new_department"
                                                    {{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}>
                                                    <option value="">Select Department</option>
                                                    <option value="1"
                                                        {{ in_array('1', explode(',', $data->departments2)) ? 'selected' : '' }}>
                                                        QA</option>
                                                    <option value="2"
                                                        {{ in_array('2', explode(',', $data->departments2)) ? 'selected' : '' }}>
                                                        QC</option>
                                                    <option value="3"
                                                        {{ in_array('3', explode(',', $data->departments2)) ? 'selected' : '' }}>
                                                        R&D</option>
                                                    <option value="4"
                                                        {{ in_array('4', explode(',', $data->departments2)) ? 'selected' : '' }}>
                                                        Manufacturing</option>
                                                    <option value="5"
                                                        {{ in_array('5', explode(',', $data->departments2)) ? 'selected' : '' }}>
                                                        Warehouse</option>
                                                </select>  --}}


                                                  <select multiple name="departments2[]" placeholder="Select Departments"
                                                    data-search="false" data-silent-initial-value-set="true"
                                                    id="departments2" class="new_department"
                                                    {{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}>
                                                    {{--<option value="">Select Department</option>--}}
                                                    <option value="QA" {{ in_array('QA', $selectedDepartments2) ? 'selected' : '' }}>QA</option>
                                                    <option value="QC" {{ in_array('QC', $selectedDepartments2) ? 'selected' : '' }}>QC</option>
                                                    <option value="R&D" {{ in_array('R&D', $selectedDepartments2) ? 'selected' : '' }}>R&D</option>
                                                    <option value="Wet Chemistry Area" {{ in_array('Wet Chemistry Area', $selectedDepartments2) ? 'selected' : '' }}>Wet Chemistry Area</option>
                                                    <option value="Warehouse" {{ in_array('Warehouse', $selectedDepartments2) ? 'selected' : '' }}>Warehouse</option>
                                                    <option value="Molecular Area" {{ in_array('Molecular Area', $selectedDepartments2) ? 'selected' : '' }}>Molecular Area</option>
                                                    <option value="Microbiology Area" {{ in_array('Microbiology Area', $selectedDepartments2) ? 'selected' : '' }}>Microbiology Area</option>
                                                    <option value="Instrumental Area" {{ in_array('Instrumental Area', $selectedDepartments2) ? 'selected' : '' }}>Instrumental Area</option>
                                                    <option value="Administration" {{ in_array('Administration', $selectedDepartments2) ? 'selected' : '' }}>Administration</option>
                                                    <option value="Financial Department" {{ in_array('Financial Department', $selectedDepartments2) ? 'selected' : '' }}>Financial Department</option>
                                                </select>
                                            </div>
                                        </div>

                                        <script>
                                            $(document).ready(function() {
                                                $('#departments2').change(function() {
                                                    var selectedOptions = $(this).val();
                                                    console.log('selectedOptions', selectedOptions);
                                                    document.querySelector('#departments2').setValue(selectedOptions);
                                                });
                                            });
                                        </script>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Sourcd of Risk">Source of Risk</label>
                                                <select name="source_of_risk2" id="sourcd_of_risk"
                                                    {{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}>
                                                    <option value="">Enter Your Selection Here</option>
                                                    <option {{ $data->source_of_risk2 == 'Audit' ? 'selected' : '' }}
                                                        value="Audit">Audit</option>
                                                    <option {{ $data->source_of_risk2 == 'Complaint' ? 'selected' : '' }}
                                                        value="Complaint">Complaint</option>
                                                    <option {{ $data->source_of_risk2 == 'Employee' ? 'selected' : '' }}
                                                        value="Employee">Employee</option>
                                                    <option {{ $data->source_of_risk2 == 'Other' ? 'selected' : '' }}
                                                        value="Other">Other</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Site Name">Site Name</label>
                                               <select name="site_name" id="site_name" {{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}>
                                                    <option value="">Enter Your Selection Here</option>
                                                    <option value="City MFR A" {{ $data->site_name == 'City MFR A' ? 'selected' : '' }}>City MFR A</option>
                                                    <option value="City MFR B" {{ $data->site_name == 'City MFR B' ? 'selected' : '' }}>City MFR B</option>
                                                    <option value="City MFR C" {{ $data->site_name == 'City MFR C' ? 'selected' : '' }}>City MFR C</option>
                                                    <option value="Complex A" {{ $data->site_name == 'Complex A' ? 'selected' : '' }}>Complex A</option>
                                                    <option value="Complex B" {{ $data->site_name == 'Complex B' ? 'selected' : '' }}>Complex B</option>
                                                    <option value="Marketing A" {{ $data->site_name == 'Marketing A' ? 'selected' : '' }}>Marketing A</option>
                                                    <option value="Marketing B" {{ $data->site_name == 'Marketing B' ? 'selected' : '' }}>Marketing B</option>
                                                    <option value="Marketing C" {{ $data->site_name == 'Marketing C' ? 'selected' : '' }}>Marketing C</option>
                                                    <option value="Oceanside" {{ $data->site_name == 'Oceanside' ? 'selected' : '' }}>Oceanside</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Building.">Building.</label>
                                                <select name="building" id="building"
                                                    {{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}>
                                                    <option value="">Enter Your Selection Here</option>
                                                    <option {{ $data->building == 'A' ? 'selected' : '' }} value="A">
                                                        A</option>
                                                    <option {{ $data->building == 'B' ? 'selected' : '' }} value="B">
                                                        B</option>
                                                    <option {{ $data->building == 'C' ? 'selected' : '' }} value="C">
                                                        C</option>
                                                    <option {{ $data->building == 'D' ? 'selected' : '' }} value="D">
                                                        D</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Floor...">Floor</label>
                                                <select name="floor" id="floor"
                                                    {{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}>
                                                    <option value="">Enter Your Selection Here</option>
                                                    <option {{ $data->floor == 'First' ? 'selected' : '' }}
                                                        value="First">First</option>
                                                    <option {{ $data->floor == 'Second' ? 'selected' : '' }}
                                                        value="Second">Second</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Room">Room</label>
                                                <select name="room" id="room"
                                                    {{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}>
                                                    <option value="">Enter Your Selection Here</option>
                                                    <option {{ $data->room == 'C-101' ? 'selected' : '' }} value="C-101">
                                                        C-101</option>
                                                    <option {{ $data->room == 'C-202' ? 'selected' : '' }} value="C-202">
                                                        C-202</option>
                                                </select>
                                            </div>
                                        </div>
                                        {{-- <div class="col-lg-12">
                                            <div class="group-input">
                                                <label for="Reference Recores">Related Record</label>
                                                <select {{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} multiple id="related_record" name="related_record[]" id="">
                                                    <option value="">--Select---</option>
                                                    @foreach ($old_record as $new)
                                                        <option value="{{ $new->id }}" {{ in_array($new->id, explode(',', $data->refrence_record)) ? 'selected' : '' }}>
                                                            {{ Helpers::getDivisionName($new->division_id) }}/RA/{{date('Y')}}/{{ Helpers::recordFormat($new->record) }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div> --}}

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Duration">Duration</label>
                                               <select name="duration" id="duration">
                                                    <option value="">Enter Your Selection Here</option>
                                                    <option value="2 hours" {{ $data->duration == '2 hours' ? 'selected' : '' }}>2 hours</option>
                                                    <option value="4 hours" {{ $data->duration == '4 hours' ? 'selected' : '' }}>4 hours</option>
                                                    <option value="8 hours" {{ $data->duration == '8 hours' ? 'selected' : '' }}>8 hours</option>
                                                    <option value="16 hours" {{ $data->duration == '16 hours' ? 'selected' : '' }}>16 hours</option>
                                                    <option value="24 hours" {{ $data->duration == '24 hours' ? 'selected' : '' }}>24 hours</option>
                                                    <option value="36 hours" {{ $data->duration == '36 hours' ? 'selected' : '' }}>36 hours</option>
                                                    <option value="72 hours" {{ $data->duration == '72 hours' ? 'selected' : '' }}>72 hours</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Hazard">Hazard</label>
                                                    <select name="hazard" id="hazard">
                                                        <option value="">Enter Your Selection Here</option>
                                                        <option value="Confined Space" {{ $data->hazard == 'Confined Space' ? 'selected' : '' }}>Confined Space</option>
                                                        <option value="Electrical" {{ $data->hazard == 'Electrical' ? 'selected' : '' }}>Electrical</option>
                                                        <option value="Energy use" {{ $data->hazard == 'Energy use' ? 'selected' : '' }}>Energy use</option>
                                                        <option value="Ergonomics" {{ $data->hazard == 'Ergonomics' ? 'selected' : '' }}>Ergonomics</option>
                                                        <option value="Machine Guarding" {{ $data->hazard == 'Machine Guarding' ? 'selected' : '' }}>Machine Guarding</option>
                                                        <option value="Material Storage" {{ $data->hazard == 'Material Storage' ? 'selected' : '' }}>Material Storage</option>
                                                        <option value="Material use" {{ $data->hazard == 'Material use' ? 'selected' : '' }}>Material use</option>
                                                        <option value="Pressure" {{ $data->hazard == 'Pressure' ? 'selected' : '' }}>Pressure</option>
                                                        <option value="Thermal" {{ $data->hazard == 'Thermal' ? 'selected' : '' }}>Thermal</option>
                                                        <option value="Water use" {{ $data->hazard == 'Water use' ? 'selected' : '' }}>Water use</option>
                                                    </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Room">Room</label>
                                             <select name="room2" id="room2">
                                                <option value="">Enter Your Selection Here</option>
                                                <option value="Automation" {{ $data->room2 == 'Automation' ? 'selected' : '' }}>Automation</option>
                                                <option value="Biochemistry" {{ $data->room2 == 'Biochemistry' ? 'selected' : '' }}>Biochemistry</option>
                                                <option value="Blood Collection" {{ $data->room2 == 'Blood Collection' ? 'selected' : '' }}>Blood Collection</option>
                                                <option value="Enter Yo" {{ $data->room2 == 'Enter Yo' ? 'selected' : '' }}>Enter Yo</option>
                                                <option value="Buffer Preparation" {{ $data->room2 == 'Buffer Preparation' ? 'selected' : '' }}>Buffer Preparation</option>
                                                <option value="Bulk Fill" {{ $data->room2 == 'Bulk Fill' ? 'selected' : '' }}>Bulk Fill</option>
                                                <option value="Calibration" {{ $data->room2 == 'Calibration' ? 'selected' : '' }}>Calibration</option>
                                                <option value="Component Manufacturing" {{ $data->room2 == 'Component Manufacturing' ? 'selected' : '' }}>Component Manufacturing</option>
                                                <option value="Computer" {{ $data->room2 == 'Computer' ? 'selected' : '' }}>Computer</option>
                                                <option value="Computer / Automated Systems" {{ $data->room2 == 'Computer / Automated Systems' ? 'selected' : '' }}>Computer / Automated Systems</option>
                                                <option value="Despensing Donor Suitability" {{ $data->room2 == 'Despensing Donor Suitability' ? 'selected' : '' }}>Despensing Donor Suitability</option>
                                                <option value="Filling" {{ $data->room2 == 'Filling' ? 'selected' : '' }}>Filling</option>
                                                <option value="Filtration" {{ $data->room2 == 'Filtration' ? 'selected' : '' }}>Filtration</option>
                                                <option value="Formulation" {{ $data->room2 == 'Formulation' ? 'selected' : '' }}>Formulation</option>
                                                <option value="Incoming QA" {{ $data->room2 == 'Incoming QA' ? 'selected' : '' }}>Incoming QA</option>
                                                <option value="Hazard" {{ $data->room2 == 'Hazard' ? 'selected' : '' }}>Hazard</option>
                                                <option value="Laboratory" {{ $data->room2 == 'Laboratory' ? 'selected' : '' }}>Laboratory</option>
                                                <option value="Laboratory Support Facility" {{ $data->room2 == 'Laboratory Support Facility' ? 'selected' : '' }}>Laboratory Support Facility</option>
                                                <option value="Enter Your" {{ $data->room2 == 'Enter Your' ? 'selected' : '' }}>Enter Your</option>
                                                <option value="Lot Release" {{ $data->room2 == 'Lot Release' ? 'selected' : '' }}>Lot Release</option>
                                                <option value="Manufacturing" {{ $data->room2 == 'Manufacturing' ? 'selected' : '' }}>Manufacturing</option>
                                                <option value="Materials Management" {{ $data->room2 == 'Materials Management' ? 'selected' : '' }}>Materials Management</option>
                                                <option value="Room" {{ $data->room2 == 'Room' ? 'selected' : '' }}>Room</option>
                                                <option value="Operations" {{ $data->room2 == 'Operations' ? 'selected' : '' }}>Operations</option>
                                                <option value="Packaging" {{ $data->room2 == 'Packaging' ? 'selected' : '' }}>Packaging</option>
                                                <option value="Plant Engineering" {{ $data->room2 == 'Plant Engineering' ? 'selected' : '' }}>Plant Engineering</option>
                                                <option value="Enter Your Sele" {{ $data->room2 == 'Enter Your Sele' ? 'selected' : '' }}>Enter Your Sele</option>
                                                <option value="Njown" {{ $data->room2 == 'Njown' ? 'selected' : '' }}>Njown</option>
                                                <option value="Powder Filling" {{ $data->room2 == 'Powder Filling' ? 'selected' : '' }}>Powder Filling</option>
                                                <option value="Process Development" {{ $data->room2 == 'Process Development' ? 'selected' : '' }}>Process Development</option>
                                                <option value="Product Distribution" {{ $data->room2 == 'Product Distribution' ? 'selected' : '' }}>Product Distribution</option>
                                                <option value="Product Testing" {{ $data->room2 == 'Product Testing' ? 'selected' : '' }}>Product Testing</option>
                                                <option value="Production Purification" {{ $data->room2 == 'Production Purification' ? 'selected' : '' }}>Production Purification</option>
                                                <option value="QA" {{ $data->room2 == 'QA' ? 'selected' : '' }}>QA</option>
                                                <option value="QA Laboratory Quality Control" {{ $data->room2 == 'QA Laboratory Quality Control' ? 'selected' : '' }}>QA Laboratory Quality Control</option>
                                                <option value="Quality Control / Assurance" {{ $data->room2 == 'Quality Control / Assurance' ? 'selected' : '' }}>Quality Control / Assurance</option>
                                                <option value="Sanitization" {{ $data->room2 == 'Sanitization' ? 'selected' : '' }}>Sanitization</option>
                                                <option value="Shipping/Distribution Storage/Distribution" {{ $data->room2 == 'Shipping/Distribution Storage/Distribution' ? 'selected' : '' }}>Shipping/Distribution Storage/Distribution</option>
                                                <option value="Storage and Distribution" {{ $data->room2 == 'Storage and Distribution' ? 'selected' : '' }}>Storage and Distribution</option>
                                            </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Regulatory Climate">Regulatory Climate</label>
                                               <select name="regulatory_climate" id="regulatory_climate">
                                                <option value="">Enter Your Selection Here</option>
                                                <option value="0. No significant regulatory issues affecting operation" {{ $data->regulatory_climate == '0. No significant regulatory issues affecting operation' ? 'selected' : '' }}>0. No significant regulatory issues affecting operation</option>
                                                <option value="1. Some regulatory or enforcement changes potentially affecting operation are anticipated" {{ $data->regulatory_climate == '1. Some regulatory or enforcement changes potentially affecting operation are anticipated' ? 'selected' : '' }}>1. Some regulatory or enforcement changes potentially affecting operation are anticipated</option>
                                                <option value="2. A few regulatory or enforcement changes affect operations" {{ $data->regulatory_climate == '2. A few regulatory or enforcement changes affect operations' ? 'selected' : '' }}>2. A few regulatory or enforcement changes affect operations</option>
                                                <option value="3. Regulatory and enforcement changes affect operation" {{ $data->regulatory_climate == '3. Regulatory and enforcement changes affect operation' ? 'selected' : '' }}>3. Regulatory and enforcement changes affect operation</option>
                                                <option value="4. Significant programatic regulatory and enforcement changes affect operation" {{ $data->regulatory_climate == '4. Significant programatic regulatory and enforcement changes affect operation' ? 'selected' : '' }}>4. Significant programatic regulatory and enforcement changes affect operation</option>
                                               </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Number of Employees">Number of Employees</label>
                                                 <select name="Number_of_employees" id="Number_of_employees">
                                                    <option value="">Enter Your Selection Here</option>
                                                    <option value="0-50" {{ $data->Number_of_employees == '0-50' ? 'selected' : '' }}>0-50</option>
                                                    <option value="50-100" {{ $data->Number_of_employees == '50-100' ? 'selected' : '' }}>50-100</option>
                                                    <option value="100-200" {{ $data->Number_of_employees == '100-200' ? 'selected' : '' }}>100-200</option>
                                                    <option value="200-300" {{ $data->Number_of_employees == '200-300' ? 'selected' : '' }}>200-300</option>
                                                    <option value="300-500" {{ $data->Number_of_employees == '300-500' ? 'selected' : '' }}>300-500</option>
                                                    <option value="500-1000" {{ $data->Number_of_employees == '500-1000' ? 'selected' : '' }}>500-1000</option>
                                                    <option value="1000+" {{ $data->Number_of_employees == '1000+' ? 'selected' : '' }}>1000+</option>
                                                 </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Risk Management Strategy">Risk Management Strategy</label>
                                                    <select name="risk_management_strategy" id="risk_management_strategy">
                                                        <option value="">Enter Your Selection Here</option>
                                                        <option value="Accept" {{ $data->risk_management_strategy == 'Accept' ? 'selected' : '' }}>Accept</option>
                                                        <option value="Avoid the Risk" {{ $data->risk_management_strategy == 'Avoid the Risk' ? 'selected' : '' }}>Avoid the Risk</option>
                                                        <option value="Mitigate" {{ $data->risk_management_strategy == 'Mitigate' ? 'selected' : '' }}>Mitigate</option>
                                                        <option value="Transfer" {{ $data->risk_management_strategy == 'Transfer' ? 'selected' : '' }}>Transfer</option>
                                                    </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="button-block">
                                        <button type="submit" class="saveButton"
                                            {{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}>Save</button>
                                        <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                        <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                        <button type="button"> <a class="text-white"
                                                href="{{ url('rcms/qms-dashboard') }}"> Exit </a> </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Work Group Assignment content -->
                            <div id="CCForm3" class="inner-block cctabcontent">
                                <div class="inner-block-content">
                                    <div class="sub-head">
                                        Assignment Details
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 new-date-data-field">
                                            <div class="group-input input-date">
                                                <label for="Scheduled Start Date">Scheduled Start Date</label>
                                                <div class="calenderauditee">
                                                    <input type="text" id="schedule_start_date" readonly value="{{ Helpers::getdateFormat($data->schedule_start_date1) }}" 
                                                        placeholder="DD-MMM-YYYY" />
                                                    <input type="date" id="schedule_start_date_checkdate" name="schedule_start_date1" value="{{ $data->schedule_start_date1 }}" {{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} class="hide-input" 
                                                        oninput="handleDateInput(this, 'schedule_start_date');checkDate('schedule_start_date_checkdate','schedule_end_date_checkdate')" />
                                                </div>
                                                {{-- <input type="date" name="schedule_start_date1" value="{{$data->schedule_start_date1}}"> --}}
                                            </div>
                                        </div>
                                        <div class="col-lg-6 new-date-data-field">
                                            <div class="group-input input-date">
                                                <label for="Scheduled End Date">Scheduled End Date</label>
                                                <div class="calenderauditee">
                                                    <input type="text" id="schedule_end_date" readonly value="{{ Helpers::getdateFormat($data->schedule_end_date1) }}" 
                                                        placeholder="DD-MMM-YYYY" />
                                                    <input type="date" id="schedule_end_date_checkdate" name="schedule_end_date1" value="{{ $data->schedule_end_date1 }}" {{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} class="hide-input"
                                                        oninput="handleDateInput(this, 'schedule_end_date');checkDate('schedule_start_date_checkdate','schedule_end_date_checkdate')" />
                                                </div>
                                                {{-- <input type="date" name="schedule_end_date1" value="{{$data->schedule_end_date}}"> --}}
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Estimated Man-Hours">Estimated Man-Hours</label>
                                                <div class="relative-container">
                                                <input type="text" name="estimated_man_hours" id="estimated_man_hours"
                                                    {{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}
                                                    value="{{ $data->estimated_man_hours }}">
                                                    @component('frontend.forms.language-model', ['readonly' => $data->stage == 0 || $data->stage == 8])
                                                @endcomponent
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Estimated Cost">Estimated Cost</label>
                                                <div class="relative-container">
                                                <input type="text" name="estimated_cost" id="estimated_cost"
                                                    {{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}
                                                    value="{{ $data->estimated_cost }}">
                                                    @component('frontend.forms.language-model', ['readonly' => $data->stage == 0 || $data->stage == 8])
                                                @endcomponent
                                                </div>
                                            </div>
                                        </div>
                                        {{-- <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Supervisor">Supervisor</label>
                                                <div class="static">shaleen</div>
                                            </div>
                                        </div> --}}
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Currency">Currency</label>
                                                <select name="currency" id="currency" {{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}>
                                                    <option value="">Enter Your Selection Here</option>
                                                    <option value="ARS-Argentine Peso" {{ $data->currency == 'ARS-Argentine Peso' ? 'selected' : '' }}>ARS-Argentine Peso</option>
                                                    <option value="AUD-Australian Dollar" {{ $data->currency == 'AUD-Australian Dollar' ? 'selected' : '' }}>AUD-Australian Dollar</option>
                                                    <option value="BRL-Brazilian Real" {{ $data->currency == 'BRL-Brazilian Real' ? 'selected' : '' }}>BRL-Brazilian Real</option>
                                                    <option value="CAD-Canadian Dollar" {{ $data->currency == 'CAD-Canadian Dollar' ? 'selected' : '' }}>CAD-Canadian Dollar</option>
                                                    <option value="CHF-Swiss Franc" {{ $data->currency == 'CHF-Swiss Franc' ? 'selected' : '' }}>CHF-Swiss Franc</option>
                                                    <option value="CNY-Chinese Yuan" {{ $data->currency == 'CNY-Chinese Yuan' ? 'selected' : '' }}>CNY-Chinese Yuan</option>
                                                    <option value="EUR-Euro" {{ $data->currency == 'EUR-Euro' ? 'selected' : '' }}>EUR-Euro</option>
                                                    <option value="HKD-Hong Kong Dollar" {{ $data->currency == 'HKD-Hong Kong Dollar' ? 'selected' : '' }}>HKD-Hong Kong Dollar</option>
                                                    <option value="ILS-Israeli New Sheqel" {{ $data->currency == 'ILS-Israeli New Sheqel' ? 'selected' : '' }}>ILS-Israeli New Sheqel</option>
                                                    <option value="INR-Indian Rupee" {{ $data->currency == 'INR-Indian Rupee' ? 'selected' : '' }}>INR-Indian Rupee</option>
                                                    <option value="JPY-Japanese Yen" {{ $data->currency == 'JPY-Japanese Yen' ? 'selected' : '' }}>JPY-Japanese Yen</option>
                                                    <option value="KRW-South Korean Won" {{ $data->currency == 'KRW-South Korean Won' ? 'selected' : '' }}>KRW-South Korean Won</option>
                                                    <option value="MXN-Mexican Peso" {{ $data->currency == 'MXN-Mexican Peso' ? 'selected' : '' }}>MXN-Mexican Peso</option>
                                                    <option value="RUB-Russian Rouble" {{ $data->currency == 'RUB-Russian Rouble' ? 'selected' : '' }}>RUB-Russian Rouble</option>
                                                    <option value="SAR-Saudi Riyal" {{ $data->currency == 'SAR-Saudi Riyal' ? 'selected' : '' }}>SAR-Saudi Riyal</option>
                                                    <option value="TRY-Turkish Lira" {{ $data->currency == 'TRY-Turkish Lira' ? 'selected' : '' }}>TRY-Turkish Lira</option>
                                                    <option value="USD-US Dollar" {{ $data->currency == 'USD-US Dollar' ? 'selected' : '' }}>USD-US Dollar</option>
                                                    <option value="XAG-Silver" {{ $data->currency == 'XAG-Silver' ? 'selected' : '' }}>XAG-Silver</option>
                                                    <option value="XAU-Gold" {{ $data->currency == 'XAU-Gold' ? 'selected' : '' }}>XAU-Gold</option>
                                                    <option value="XPD-Palladium" {{ $data->currency == 'XPD-Palladium' ? 'selected' : '' }}>XPD-Palladium</option>
                                                    <option value="XPT-Platinum" {{ $data->currency == 'XPT-Platinum' ? 'selected' : '' }}>XPT-Platinum</option>
                                                </select>
                                            </div>
                                        </div>
                                        {{-- <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Team Members">Team Members</label>
                                                <select multiple name="team_members2[]" placeholder="Select Team Members"
                                                    data-search="false" data-silent-initial-value-set="true"
                                                    id="team_members"
                                                    {{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}>
                                                    <option value="1"
                                                        {{ in_array('1', explode(',', $data->team_members2)) ? 'selected' : '' }}>
                                                        Amit Guru</option>
                                                    <option value="2"
                                                        {{ in_array('2', explode(',', $data->team_members2)) ? 'selected' : '' }}>
                                                        Anshul Patel</option>
                                                    <option value="3"
                                                        {{ in_array('3', explode(',', $data->team_members2)) ? 'selected' : '' }}>
                                                        Vikash Prajapati</option>
                                                    <option value="4"
                                                        {{ in_array('4', explode(',', $data->team_members2)) ? 'selected' : '' }}>
                                                        Amit Patel</option>
                                                    <option value="5"
                                                        {{ in_array('5', explode(',', $data->team_members2)) ? 'selected' : '' }}>
                                                        Shaleen Mishra</option>
                                                    <option value="6"
                                                        {{ in_array('6', explode(',', $data->team_members2)) ? 'selected' : '' }}>
                                                        Madhulika Mishra</option>
                                                </select>
                                            </div>
                                        </div> --}}
                                        {{-- <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Training Requirement">Training Requirement</label>
                                                <select multiple name="training_require"
                                                    placeholder="Select Training Requirement" data-search="false"
                                                    data-silent-initial-value-set="true" id="team_members"
                                                    {{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}>
                                                    <option value="1">ABC</option>
                                                    <option value="1">ABC</option>
                                                    <option value="1">ABC</option>
                                                    <option value="1">ABC</option>

                                                </select>
                                            </div>
                                        </div> --}}
                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Justification / Rationale">Justification / Rationale</label>
                                                <div class="relative-container">
                                                <textarea name="justification" class="tiny" {{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} id="justification">{{ $data->justification }} </textarea>
                                                @component('frontend.forms.language-model', ['readonly' => $data->stage == 0 || $data->stage == 8])
                                                @endcomponent
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="sub-head">
                                        Action Plan
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Product/Material">
                                                    Action Plan<button type="button" name="ann" id="action_plan"
                                                        {{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}>+</button>
                                                </label>
                                                <table class="table table-bordered" id="action_plan_details">
                                                    <thead>
                                                        <tr>
                                                            <th style="width:78px;">Row #</th>
                                                            <th>Action</th>
                                                            <th>Responsible</th>
                                                            <th>Deadline</th>
                                                            <th>Item status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody {{Helpers::isRiskAssessment($data->stage)}} >
                                                        @foreach (unserialize($action_plan->action) as $key => $temps)
                                                            <tr>
                                                                <td><input disabled type="text" name="serial_number[]"
                                                                        value="{{ $key + 1 }}"></td>
                                                                <td><input type="text" name="action[]"
                                                                        value="{{ $temps ? $temps : ' ' }}"></td>
                                                                {{-- <td><input type="text" name="responsible[]"
                                                                        value="{{ unserialize($action_plan->responsible)[$key] ? unserialize($action_plan->responsible)[$key] : '' }}">
                                                                </td> --}}
                                                                <td> <select id="select-state" placeholder="Select..."
                                                                    name="responsible[]">
                                                                    <option value="">Select a value</option>
                                                                    @foreach ($users as $value)
                                                                        <option
                                                                            {{ unserialize($action_plan->responsible)[$key] ? (unserialize($action_plan->responsible)[$key] == $value->id ? 'selected' : ' ') : '' }}
                                                                            value="{{ $value->id }}">
                                                                            {{ $value->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select></td>
                                                                {{-- <td><input type="text" name="deadline[]"
                                                                        value="{{ unserialize($action_plan->deadline)[$key] ? unserialize($action_plan->deadline)[$key] : '' }}">
                                                                </td> --}}
                                                                <td><div class="group-input new-date-data-field mb-0">
                                                                    <div class="input-date "><div
                                                                    class="calenderauditee">
                                                                    <input type="text" id="deadline{{$key}}' + serialNumber +'" readonly placeholder="DD-MMM-YYYY" value="{{ Helpers::getdateFormat(unserialize($action_plan->deadline)[$key]) }}" />
                                                                    <input type="date" name="deadline[]" class="hide-input" value="{{ unserialize($action_plan->deadline)[$key] }}"
                                                                    oninput="handleDateInput(this, `deadline{{$key}}' + serialNumber +'`)" /></div></div></div></td>
                                                                
                                                                <td><input type="text" name="item_static[]"
                                                                        value="{{ unserialize($action_plan->item_static)[$key] ? unserialize($action_plan->item_static)[$key] : '' }}">
                                                                </td>
                                                                <td><button type="text" class="removeRowBtn">Remove</button></td>
                                                            </tr>
                                                        @endforeach

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        {{-- <div class="col-lg-12">
                                            <div class="group-input">
                                                <label for="Report Attachments">Work Group Attachments</label>
                                                <div class="file-attachment-field">
                                                    <div class="file-attachment-list" id="reference"></div>
                                                    <div class="add-btn">
                                                        <div>Add</div>
                                                        <input type="file" id="myfile" name="reference[]"
                                                            oninput="addMultipleFiles(this, 'reference')" multiple>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> --}}
                                        <div class="col-lg-12">
                                            <div class="group-input">
                                                <label for="File Attachments">Work Group Attachments</label>
                                                <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                                    <div class="file-attachment-field">
                                                        <div class="file-attachment-list" id="reference">
                                                            @if ($data->reference)
                                                            @foreach(json_decode($data->reference) as $file)
                                                            <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                                <b>{{ $file }}</b>
                                                                <a href="{{ asset('upload/' . $file) }}" target="_blank"><i class="fa fa-eye text-primary" style="font-size:20px; margin-right:-10px;"></i></a>
                                                                <a type="button" class="remove-file" data-file-name="{{ $file }}"><i class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i></a>
                                                            </h6>
                                                       @endforeach
                                                            @endif
                                                        </div>
                                                        <div class="add-btn">
                                                            <div>Add</div>
                                                            <input  {{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} type="file" id="myfile" name="reference[]"
                                                                oninput="addMultipleFiles(this, 'reference')" multiple>
                                                        </div>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="button-block">
                                        <button type="submit" class="saveButton"
                                            {{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}>Save</button>
                                        <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                        <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                        <button type="button"> <a class="text-white"
                                                href="{{ url('rcms/qms-dashboard') }}"> Exit </a> </button>
                                    </div>
                                </div>
                            </div>

                            <!-- General information content -->
                            <div id="CCForm4" class="inner-block cctabcontent">
                                <div class="inner-block-content">
                                    <div class="sub-head">
                                        RCA Results
                                    </div>

                                    {{--  {{dd($data->root_cause_methodology) }}  --}}
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="root-cause-methodology">Hazard Analysis (HACCP)</label>
                                                <div class="relative-container">
                                                <textarea name="hazard_analysis" class="tiny">{{$data->hazard_analysis}}</textarea>
                                                @component('frontend.forms.language-model', ['readonly' => $data->stage == 0 || $data->stage == 8])
                                                @endcomponent
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="root-cause-methodology">Root Cause Methodology</label>
                                                <select  name="root_cause_methodology[]" multiple {{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}
                                                    placeholder="-- Select --" data-search="false"
                                                    data-silent-initial-value-set="true" id="root-cause-methodology">
                                                    {{-- <option value="0">-- Select --</option> --}}
                                                    <option value="1"
                                                        {{ in_array('1', explode(',', $data->root_cause_methodology)) ? 'selected' : '' }}>
                                                        Why-Why Chart</option>
                                                    <option value="2"
                                                        {{ in_array('2', explode(',', $data->root_cause_methodology)) ? 'selected' : '' }}>
                                                        Failure Mode and Efect Analysis</option>
                                                    <option value="3"
                                                        {{ in_array('3', explode(',', $data->root_cause_methodology)) ? 'selected' : '' }}>
                                                        Fishbone or Ishikawa Diagram</option>
                                                    <option value="4"
                                                        {{ in_array('4', explode(',', $data->root_cause_methodology)) ? 'selected' : '' }}>
                                                        Is/Is Not Analysis</option>


                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 sub-head"></div>
                                        <div class="col-12 mb-4">
                                            <div class="group-input">
                                                <label for="agenda">
                                                    Failure Mode and Effect Analysis<button type="button" name="agenda"
                                                        onclick="addRiskAssessment('risk-assessment-risk-management')">+</button>
                                                </label>
                                                <div class="table-responsive">
                                                    <table class="table table-bordered" style="width: 200%"
                                                        id="risk-assessment-risk-management">
                                                        <thead>
                                                            <tr>
                                                                <th>Row #</th>
                                                                <th>Risk Factor</th>
                                                                <th>Risk element </th>
                                                                <th>Probable cause of risk element</th>
                                                                <th>Existing Risk Controls</th>
                                                                <th>Initial Severity- H(3)/M(2)/L(1)</th>
                                                                <th>Initial Probability- H(3)/M(2)/L(1)</th>
                                                                <th>Initial Detectability- H(1)/M(2)/L(3)</th>
                                                                <th>Initial RPN</th>
                                                                <th>Risk Acceptance (Y/N)</th>
                                                                <th>Proposed Additional Risk control measure (Mandatory for
                                                                    Risk
                                                                    elements having RPN>4)</th>
                                                                <th>Residual Severity- H(3)/M(2)/L(1)</th>
                                                                <th>Residual Probability- H(3)/M(2)/L(1)</th>
                                                                <th>Residual Detectability- H(1)/M(2)/L(3)</th>
                                                                <th>Residual RPN</th>
                                                                <th>Risk Acceptance (Y/N)</th>
                                                                <th>Mitigation proposal (Mention either CAPA reference
                                                                    number, IQ,
                                                                    OQ or
                                                                    PQ)</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @if (!empty($riskEffectAnalysis->risk_factor))
                                                                @foreach (unserialize($riskEffectAnalysis->risk_factor) as $key => $riskFactor)
                                                                <tr>
                                                                    <td>{{ $key + 1 }}</td>
                                                                    <td><input name="risk_factor[]" type="text" value="{{ $riskFactor }}" ></td>
                                                                    <td><input name="risk_element[]" type="text" value="{{ unserialize($riskEffectAnalysis->risk_element)[$key] ?? null }}" >
                                                                    </td>
                                                                    <td> <input name="problem_cause[]" type="text" value="{{ unserialize($riskEffectAnalysis->problem_cause)[$key] ?? null }}" >
                                                                    </td>
                                                                    <td><input name="existing_risk_control[]" type="text" value="{{ unserialize($riskEffectAnalysis->existing_risk_control)[$key] ?? null }}" >
                                                                    </td>
                                                                    <td><select onchange="calculateInitialResult(this)" class="fieldR" name="initial_severity[]">
                                                                            <option value="">-- Select --</option>
                                                                            <option value="1" {{ (unserialize($riskEffectAnalysis->initial_severity)[$key] ?? null)== 1 ? 'selected' :''}}>1</option>
                                                                            <option value="2"  {{ (unserialize($riskEffectAnalysis->initial_severity)[$key] ?? null)== 2 ? 'selected' :''}}>2</option>
                                                                            <option value="3"  {{ (unserialize($riskEffectAnalysis->initial_severity)[$key] ?? null)== 3 ? 'selected' :''}}>3</option>
                                                                        </select>
                                                                    </td>
                                                                    <td>
                                                                        <select onchange="calculateInitialResult(this)" class="fieldP" name="initial_detectability[]">
                                                                            <option value="">-- Select --</option>
                                                                            <option value="1" {{ (unserialize($riskEffectAnalysis->initial_detectability)[$key] ?? null)== 1 ? 'selected' :''}}>1</option>
                                                                            <option value="2"  {{ (unserialize($riskEffectAnalysis->initial_detectability)[$key] ?? null)== 2 ? 'selected' :''}}>2</option>
                                                                            <option value="3"  {{ (unserialize($riskEffectAnalysis->initial_detectability)[$key] ?? null)== 3 ? 'selected' :''}}>3</option>
                                                                        </select>
                                                                    </td>
                                                                    <td>
                                                                        <select onchange="calculateInitialResult(this)" class="fieldN" name="initial_probability[]">
                                                                            <option value="">-- Select --</option>
                                                                            <option value="1" {{ (unserialize($riskEffectAnalysis->initial_probability)[$key] ?? null)== 1 ? 'selected' :''}}>1</option>
                                                                            <option value="2"  {{ (unserialize($riskEffectAnalysis->initial_probability)[$key] ?? null)== 2 ? 'selected' :''}}>2</option>
                                                                            <option value="3"  {{ (unserialize($riskEffectAnalysis->initial_probability)[$key] ?? null)== 3 ? 'selected' :''}}>3</option>
                                                                        </select>
                                                                    </td>
                                                                    <td>
                                                                        {{-- <input name="initial_rpn[]" type="text"  class='initial-rpn' value="{{ unserialize($riskEffectAnalysis->initial_rpn)[$key] ?? null }}" > --}}
                                                                        <input name="initial_rpn[]" type="text" class='residual-rpn' value="{{ unserialize($riskEffectAnalysis->initial_rpn)[$key] ?? null }}" >

                                                                    </td>
                                                                    <td>
                                                                        <input name="risk_acceptance[]" type="text" value="{{ unserialize($riskEffectAnalysis->risk_acceptance)[$key] ?? null }}" >
                                                                    </td>
                                                                    <td>
                                                                        <input name="risk_control_measure[]" type="text" value="{{ unserialize($riskEffectAnalysis->risk_control_measure)[$key] ?? null }}" >
                                                                         
                                                                    </td>
                                                                    <td>
                                                                        <select onchange="calculateResidualResult(this)" class="residual-fieldR" name="residual_severity[]">
                                                                            <option value="">-- Select --</option>
                                                                            <option value="1" {{ (unserialize($riskEffectAnalysis->residual_severity)[$key] ?? null)== 1 ? 'selected' :''}}>1</option>
                                                                            <option value="2"  {{ (unserialize($riskEffectAnalysis->residual_severity)[$key] ?? null)== 2 ? 'selected' :''}}>2</option>
                                                                            <option value="3"  {{ (unserialize($riskEffectAnalysis->residual_severity)[$key] ?? null)== 3 ? 'selected' :''}}>3</option>
                                                                        </select>
                                                                        
                                                                    </td>
                                                                    <td>
                                                                        <select onchange="calculateResidualResult(this)" class="residual-fieldP" name="residual_probability[]">
                                                                            <option value="">-- Select --</option>
                                                                            <option value="1" {{ (unserialize($riskEffectAnalysis->residual_probability)[$key] ?? null)== 1 ? 'selected' :''}}>1</option>
                                                                            <option value="2"  {{ (unserialize($riskEffectAnalysis->residual_probability)[$key] ?? null)== 2 ? 'selected' :''}}>2</option>
                                                                            <option value="3"  {{ (unserialize($riskEffectAnalysis->residual_probability)[$key] ?? null)== 3 ? 'selected' :''}}>3</option>
                                                                        </select>
                                                                         
                                                                    </td>
    
                                                                    <td>
                                                                        <select onchange="calculateResidualResult(this)" class="residual-fieldN" name="residual_detectability[]">
                                                                            <option value="">-- Select --</option>
                                                                            <option value="1" {{ (unserialize($riskEffectAnalysis->residual_detectability)[$key] ?? null)== 1 ? 'selected' :''}}>1</option>
                                                                            <option value="2"  {{ (unserialize($riskEffectAnalysis->residual_detectability)[$key] ?? null)== 2 ? 'selected' :''}}>2</option>
                                                                            <option value="3"  {{ (unserialize($riskEffectAnalysis->residual_detectability)[$key] ?? null)== 3 ? 'selected' :''}}>3</option>
                                                                        </select>
                                                                    </td>
                                                                    <td>
                                                                         <input name="residual_rpn[]" type="text" class='residual-rpn' value="{{ unserialize($riskEffectAnalysis->residual_rpn)[$key] ?? null }}" >
                                                                    </td>
                                                                    <td>
                                                                        <select onchange="calculateInitialResult(this)" class="fieldR" name="risk_acceptance2[]">
                                                                            <option value="">-- Select --</option>
                                                                            <option value="Y" {{ (unserialize($riskEffectAnalysis->risk_acceptance2)[$key] ?? null)== 'Y' ? 'selected' :''}}>Y</option>
                                                                            <option value="N"  {{ (unserialize($riskEffectAnalysis->risk_acceptance2)[$key] ?? null)== 'N' ? 'selected' :''}}>N</option>
                                                                         </select>
                                                                    </td>
                                                                    <td>
                                                                        <input name="mitigation_proposal[]" type="text" value="{{ unserialize($riskEffectAnalysis->mitigation_proposal)[$key] ?? null }}" >
                                                                    </td>
                                                                    <td> <button class="btn btn-dark removeBtn">Remove</button> </td>
                                                                </tr>    
                                                                @endforeach
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 sub-head"></div>
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="fishbone">
                                                    Fishbone or Ishikawa Diagram
                                                    <button type="button" name="agenda"
                                                        onclick="addFishBone('.top-field-group', '.bottom-field-group')">+</button>
                                                    <button type="button" name="agenda" class="fishbone-del-btn"
                                                        onclick="deleteFishBone('.top-field-group', '.bottom-field-group')">
                                                        <i class="fa-solid fa-trash-can"></i>
                                                    </button>
                                                    <span class="text-primary" data-bs-toggle="modal"
                                                        data-bs-target="#fishbone-instruction-modal"
                                                        style="font-size: 0.8rem; font-weight: 400;">
                                                        (Launch Instruction)
                                                    </span>
                                                </label>
                                                <div class="fishbone-ishikawa-diagram">
                                                    <div class="left-group">
                                                        <div class="grid-field field-name">
                                                            <div>Measurement</div>
                                                            <div>Materials</div>
                                                            <div>Methods</div>
                                                        </div>
                                                        <div class="top-field-group">
                                                            <div class="grid-field fields top-field">
                                                                @if (!empty($fishbone->measurement))
                                                                    @foreach (unserialize($fishbone->measurement) as $key => $measure)
                                                                        <div><input {{Helpers::isRiskAssessment($data->stage)}} type="text"
                                                                                value="{{ $measure }}"
                                                                                name="measurement[]"></div>
                                                                        <div><input {{Helpers::isRiskAssessment($data->stage)}} type="text"
                                                                                value="{{ unserialize($fishbone->materials)[$key] ? unserialize($fishbone->materials)[$key] : '' }}"
                                                                                name="materials[]"></div>
                                                                        <div><input {{Helpers::isRiskAssessment($data->stage)}} type="text"
                                                                                value="{{ unserialize($fishbone->methods)[$key] ? unserialize($fishbone->methods)[$key] : '' }}"
                                                                                name="methods[]"></div>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="mid"></div>
                                                        <div class="bottom-field-group">
                                                            <div class="grid-field fields bottom-field">
                                                                @if (!empty($fishbone->environment))
                                                                    @foreach (unserialize($fishbone->environment) as $key => $measure)
                                                                        <div><input {{Helpers::isRiskAssessment($data->stage)}} type="text"
                                                                                value="{{ $measure }}"
                                                                                name="environment[]"></div>
                                                                        <div><input {{Helpers::isRiskAssessment($data->stage)}} type="text"
                                                                                value="{{ unserialize($fishbone->manpower)[$key] ? unserialize($fishbone->manpower)[$key] : '' }}"
                                                                                name="manpower[]"></div>
                                                                        <div><input {{Helpers::isRiskAssessment($data->stage)}} type="text"
                                                                                value="{{ unserialize($fishbone->machine)[$key] ? unserialize($fishbone->machine)[$key] : '' }}"
                                                                                name="machine[]"></div>
                                                                    @endforeach
                                                                @endif

                                                            </div>
                                                        </div>
                                                        <div class="grid-field field-name">
                                                            <div>Environment</div>
                                                            <div>Manpower</div>
                                                            <div>Machine</div>
                                                        </div>
                                                    </div>
                                                    <div class="right-group">
                                                        <div class="field-name">
                                                            Problem Statement
                                                        </div>
                                                        <div class="field">

                                                            <textarea {{Helpers::isRiskAssessment($data->stage)}} name="problem_statement">{{ $fishbone->problem_statement }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 sub-head"></div>
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="why-why-chart">
                                                    Why-Why Chart
                                                    <span class="text-primary" data-bs-toggle="modal"
                                                        data-bs-target="#why_chart-instruction-modal"
                                                        style="font-size: 0.8rem; font-weight: 400;">
                                                        (Launch Instruction)
                                                    </span>
                                                </label>
                                                <div class="why-why-chart">
                                                    <table class="table table-bordered">
                                                        <tbody>
                                                            <tr style="background: #f4bb22">
                                                                <th style="width:150px;">Problem Statement :</th>
                                                                <td>

                                                                    <textarea {{Helpers::isRiskAssessment($data->stage)}} name="why_problem_statement">{{ $whyChart->why_problem_statement }}</textarea>
                                                                </td>
                                                            </tr>
                                                            <tr class="why-row">
                                                                <th style="width:150px; color: #393cd4;">
                                                                    Why 1 <span
                                                                        onclick="addWhyField('why_1_block', 'why_1[]')">+</span>
                                                                </th>
                                                                <td>
                                                                    <div class="why_1_block">
                                                                        @if (!empty($whyChart->why_1))
                                                                            @foreach (unserialize($whyChart->why_1) as $key => $measure)
                                                                                <textarea {{Helpers::isRiskAssessment($data->stage)}} name="why_1[]">{{ $measure }}</textarea>
                                                                            @endforeach
                                                                        @endif

                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr class="why-row">
                                                                <th style="width:150px; color: #393cd4;">
                                                                    Why 2 <span
                                                                        onclick="addWhyField('why_2_block', 'why_2[]')">+</span>
                                                                </th>
                                                                <td>
                                                                    <div class="why_2_block">
                                                                        @if (!empty($whyChart->why_2))
                                                                            @foreach (unserialize($whyChart->why_2) as $key => $measure)
                                                                                <textarea {{Helpers::isRiskAssessment($data->stage)}} name="why_2[]">{{ $measure }}</textarea>
                                                                            @endforeach
                                                                        @endif
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr class="why-row">
                                                                <th style="width:150px; color: #393cd4;">
                                                                    Why 3 <span
                                                                        onclick="addWhyField('why_3_block', 'why_3[]')">+</span>
                                                                </th>
                                                                <td>
                                                                    <div class="why_3_block">
                                                                        @if (!empty($whyChart->why_3))
                                                                            @foreach (unserialize($whyChart->why_3) as $key => $measure)
                                                                                <textarea {{Helpers::isRiskAssessment($data->stage)}} name="why_3[]">{{ $measure }}</textarea>
                                                                            @endforeach
                                                                        @endif
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr class="why-row">
                                                                <th style="width:150px; color: #393cd4;">
                                                                    Why 4 <span
                                                                        onclick="addWhyField('why_4_block', 'why_4[]')">+</span>
                                                                </th>
                                                                <td>
                                                                    <div class="why_4_block">
                                                                        @if (!empty($whyChart->why_4))
                                                                            @foreach (unserialize($whyChart->why_4) as $key => $measure)
                                                                                <textarea {{Helpers::isRiskAssessment($data->stage)}} name="why_4[]">{{ $measure }}</textarea>
                                                                            @endforeach
                                                                        @endif
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr class="why-row">
                                                                <th style="width:150px; color: #393cd4;">
                                                                    Why 5 <span
                                                                        onclick="addWhyField('why_5_block', 'why_5[]')">+</span>
                                                                </th>
                                                                <td>
                                                                    <div class="why_5_block">
                                                                        @if (!empty($whyChart->why_5))
                                                                            @foreach (unserialize($whyChart->why_5) as $key => $measure)
                                                                                <textarea {{Helpers::isRiskAssessment($data->stage)}} name="why_5[]">{{ $measure }}</textarea>
                                                                            @endforeach
                                                                        @endif
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr style="background: #0080006b;">
                                                                <th style="width:150px;">Root Cause :</th>
                                                                <td>
                                                                    <textarea {{Helpers::isRiskAssessment($data->stage)}} name="why_root_cause">{{ $whyChart->why_root_cause }}</textarea>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 sub-head"></div>
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="why-why-chart">
                                                    Is/Is Not Analysis
                                                    <span class="text-primary" data-bs-toggle="modal"
                                                        data-bs-target="#is_is_not-instruction-modal"
                                                        style="font-size: 0.8rem; font-weight: 400;">
                                                        (Launch Instruction)
                                                    </span>
                                                </label>
                                                <div class="why-why-chart">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>&nbsp;</th>
                                                                <th>Will Be</th>
                                                                <th>Will Not Be</th>
                                                                <th>Rationale</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <th style="background: #0039bd85">What</th>
                                                                <td>
                                                                    <textarea {{Helpers::isRiskAssessment($data->stage)}} name="what_will_be">{{ $what_who_where->what_will_be }}</textarea>
                                                                </td>
                                                                <td>
                                                                    <textarea {{Helpers::isRiskAssessment($data->stage)}} name="what_will_not_be">{{ $what_who_where->what_will_not_be }}</textarea>
                                                                </td>
                                                                <td>
                                                                    <textarea {{Helpers::isRiskAssessment($data->stage)}} name="what_rationable"> {{ $what_who_where->what_rationable }}</textarea>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th style="background: #0039bd85">Where</th>
                                                                <td>
                                                                    <textarea {{Helpers::isRiskAssessment($data->stage)}} name="where_will_be"> {{ $what_who_where->where_will_be }}</textarea>
                                                                </td>
                                                                <td>
                                                                    <textarea {{Helpers::isRiskAssessment($data->stage)}} name="where_will_not_be"> {{ $what_who_where->where_will_be }}</textarea>
                                                                </td>
                                                                <td>
                                                                    <textarea  {{Helpers::isRiskAssessment($data->stage)}} name="where_rationable"> {{ $what_who_where->where_will_be }}</textarea>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th style="background: #0039bd85">When</th>
                                                                <td>
                                                                    <textarea {{Helpers::isRiskAssessment($data->stage)}} name="when_will_be"> {{ $what_who_where->when_will_be }}</textarea>
                                                                </td>
                                                                <td>
                                                                    <textarea {{Helpers::isRiskAssessment($data->stage)}} name="when_will_not_be">{{ $what_who_where->when_will_not_be }}</textarea>
                                                                </td>
                                                                <td>
                                                                    <textarea {{Helpers::isRiskAssessment($data->stage)}} name="when_rationable"> {{ $what_who_where->when_rationable }}</textarea>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th style="background: #0039bd85">Coverage</th>
                                                                <td>
                                                                    <textarea {{Helpers::isRiskAssessment($data->stage)}} name="coverage_will_be"> {{ $what_who_where->coverage_will_be }}</textarea>
                                                                </td>
                                                                <td>
                                                                    <textarea {{Helpers::isRiskAssessment($data->stage)}} name="coverage_will_not_be"> {{ $what_who_where->coverage_will_not_be }}</textarea>
                                                                </td>
                                                                <td>
                                                                    <textarea {{Helpers::isRiskAssessment($data->stage)}} name="coverage_rationable"> {{ $what_who_where->coverage_rationable }}</textarea>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th style="background: #0039bd85">Who</th>
                                                                <td>
                                                                    <textarea {{Helpers::isRiskAssessment($data->stage)}} name="who_will_be"> {{ $what_who_where->who_will_be }}</textarea>
                                                                </td>
                                                                <td>
                                                                    <textarea {{Helpers::isRiskAssessment($data->stage)}} name="who_will_not_be"> {{ $what_who_where->who_will_not_be }}</textarea>
                                                                </td>
                                                                <td>
                                                                    <textarea {{Helpers::isRiskAssessment($data->stage)}} name="who_rationable"> {{ $what_who_where->who_rationable }}</textarea>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 sub-head"></div>
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="root_cause_description">Root Cause Description</label>
                                                <div class="relative-container">
                                                <textarea {{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} name="root_cause_description" class="tiny">{{ $data->root_cause_description }}</textarea>
                                                @component('frontend.forms.language-model', ['readonly' => $data->stage == 0 || $data->stage == 8])
                                                @endcomponent
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="investigation_summary">Investigation Summary</label>
                                                <div class="relative-container">
                                                <textarea {{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} name="investigation_summary" class="tiny">{{ $data->investigation_summary }}</textarea>
                                                @component('frontend.forms.language-model', ['readonly' => $data->stage == 0 || $data->stage == 8])
                                                @endcomponent
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="sub-head">
                                        Risk Analysis
                                    </div>
                                    <div class="row">
                                     <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Severity Rate">Severity Rate</label>
                                                <select name="severity_rate" id="analysisR" onchange='calculateRiskAnalysis(this)'
                                                    {{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}>
                                                    <option value="">Enter Your Selection Here</option>
                                                    <option {{ $data->severity_rate == 1 ? 'selected' : '' }}
                                                        value="1">Negligible</option>
                                                    <option {{ $data->severity_rate == 2 ? 'selected' : '' }}
                                                        value="2">Moderate</option>
                                                    <option {{ $data->severity_rate == 3 ? 'selected' : '' }}
                                                        value="3">Major</option>
                                                    <option {{ $data->severity_rate == 4 ? 'selected' : '' }}
                                                        value="4">Fatal</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Occurrence">Occurrence</label>
                                                <select name="occurrence" id="analysisP" onchange='calculateRiskAnalysis(this)'
                                                    {{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}>
                                                    <option value="">Enter Your Selection Here</option>
                                                    <option
                                                        {{ $data->occurrence == 'Extremely Unlikely' ? 'selected' : '' }}
                                                        value="Extremely Unlikely">Extremely Unlikely</option>
                                                    <option {{ $data->occurrence == '4' ? 'selected' : '' }}
                                                        value="4">Rare</option>
                                                    <option {{ $data->occurrence == '3' ? 'selected' : '' }}
                                                        value="3">Unlikely</option>
                                                    <option {{ $data->occurrence == '2' ? 'selected' : '' }}
                                                        value="2">Likely</option>
                                                    <option {{ $data->occurrence == '1' ? 'selected' : '' }}
                                                        value="1">Very Likely</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Detection">Detection</label>
                                                <select name="detection" id="analysisN" onchange='calculateRiskAnalysis(this)'
                                                    {{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}>
                                                    <option value="">Enter Your Selection Here</option>
                                                    <option {{ $data->detection == '5' ? 'selected' : '' }}
                                                        value="5">Impossible</option>
                                                    <option {{ $data->detection == '4' ? 'selected' : '' }}
                                                        value="4">Rare</option>
                                                    <option {{ $data->detection == '3' ? 'selected' : '' }}
                                                        value="3">Unlikely</option>
                                                    <option {{ $data->detection == '2' ? 'selected' : '' }}
                                                        value="2">Likely</option>
                                                    <option {{ $data->detection == '1' ? 'selected' : '' }}
                                                        value="1">Very Likely</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="RPN">RPN</label>
                                                <div><small class="text-primary">Auto - Calculated</small></div>
                                                <div class="relative-container">
                                                    <input readonly type="text" name="rpn" id="analysisRPN" value="{{$data->rpn}}">
                                                    @component('frontend.forms.language-model', ['readonly' => $data->stage == 0 || $data->stage == 8])
                                                    @endcomponent
                                                    </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="button-block">
                                        <button type="submit" class="saveButton"
                                            {{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}>Save</button>
                                        <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                        <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                        <button type="button"> <a class="text-white"
                                                href="{{ url('rcms/qms-dashboard') }}"> Exit </a> </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Residual Risk content -->
                            <div id="CCForm5" class="inner-block cctabcontent">
                                <div class="inner-block-content">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Residual Risk">Residual Risk</label>
                                                <div class="relative-container">
                                                <input type="text" name="residual_risk" id="residual_risk"
                                                    {{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}
                                                    value="{{ $data->residual_risk }}">
                                                    @component('frontend.forms.language-model')
                                                @endcomponent
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Residual Risk Impact">Residual Risk Impact</label>
                                                <select name="residual_risk_impact" id="analysisR2" {{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}
                                                onchange='calculateRiskAnalysis2(this)'>
                                                    <option value="">Enter Your Selection Here</option>
                                                    <option value="1" {{ $data->residual_risk_impact == '1' ? 'selected' : '' }}>High</option>
                                                    <option value="2" {{ $data->residual_risk_impact == '2' ? 'selected' : '' }}>Low</option>
                                                    <option value="3" {{ $data->residual_risk_impact == '3' ? 'selected' : '' }}>Medium</option>
                                                    <option value="4" {{ $data->residual_risk_impact == '4' ? 'selected' : '' }}>None</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Residual Risk Probability">Residual Risk Probability</label>
                                                <select name="residual_risk_probability" id="analysisP2" {{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} onchange='calculateRiskAnalysis2(this)'>
                                                    <option value="">Enter Your Selection Here</option>
                                                    <option value="1" {{ $data->residual_risk_probability == '1' ? 'selected' : '' }}>High</option>
                                                    <option value="2" {{ $data->residual_risk_probability == '2' ? 'selected' : '' }}>Medium</option>
                                                    <option value="3" {{ $data->residual_risk_probability == '3' ? 'selected' : '' }}>Low</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Detection">Residual Detection</label>
                                                <select name="detection2" id="analysisN2" {{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} onchange='calculateRiskAnalysis2(this)'>
                                                    <option value="">Enter Your Selection Here</option>
                                                    <option value="5" {{ $data->detection2 == '5' ? 'selected' : '' }}>Impossible</option>
                                                    <option value="4" {{ $data->detection2 == '4' ? 'selected' : '' }}>Rare</option>
                                                    <option value="3" {{ $data->detection2 == '3' ? 'selected' : '' }}>Unlikely</option>
                                                    <option value="2" {{ $data->detection2 == '2' ? 'selected' : '' }}>Likely</option>
                                                    <option value="1" {{ $data->detection2 == '1' ? 'selected' : '' }}>Very Likely</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="RPN">Residual RPN</label>
                                                <div><small class="text-primary">Auto - Calculated</small></div>
                                                <div class="relative-container">
                                                <input readonly type="text" name="rpn2" id="analysisRPN2" value="{{$data->rpn2}}">
                                                @component('frontend.forms.language-model', ['readonly' => $data->stage == 0 || $data->stage == 8])
                                                @endcomponent
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Comments">Comments</label>
                                                <div class="relative-container">
                                                <textarea name="comments2" id="comments2" {{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} class="tiny">{{ $data->comments2 }}</textarea>
                                                @component('frontend.forms.language-model', ['readonly' => $data->stage == 0 || $data->stage == 8])
                                                @endcomponent
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- ----------------------------------------------- --}}
                                    <div class="button-block">
                                        <button type="submit" class="saveButton"
                                            {{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}>Save</button>
                                        <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                        <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                        <button type="button"> <a class="text-white"
                                                href="{{ url('rcms/qms-dashboard') }}"> Exit </a> </button>
                                    </div>
                                </div>
                            </div>

                            <div id="CCForm6" class="inner-block cctabcontent">
                                <div class="inner-block-content">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="group-input">
                                                {{-- <label for="mitigation_plan_details">
                                                    Mitigation Plan Details<button type="button" name="ann"  {{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}
                                                        onclick="add5Input('mitigation_plan_details')">+</button>
                                                </label> --}}
                                                <label for="mitigation_plan_details">
                                                    Mitigation Plan Details<button type="button" name="ann"
                                                        id="mitigation_plan_deatails">+</button>
                                                </label>
                                                <table class="table table-bordered" id="mitigation_plan_deatails_details">
                                                    <thead>
                                                        <tr>
                                                            <th>Row #</th>
                                                            <th>Mitigation Steps</th>
                                                            <th>
                                                                Deadline
                                                                {{-- Input Type Date --}}
                                                            </th>
                                                            <th>
                                                                Responsible Person
                                                                {{-- Person type Data Field --}}
                                                            </th>
                                                            <th>Status</th>
                                                            <th>Remarks</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach (unserialize($mitigation_plan_details->mitigation_steps) as $key => $temps)
                                                        <tr>
                                                            <td><input disabled type="text" name="serial_number[]"
                                                                    value="{{ $key + 1 }}"></td>
                                                            <td><input type="text" name="mitigation_steps[]"
                                                                    value="{{ $temps ? $temps : ' ' }}"></td>
                                                            {{-- <td><input type="date" name="deadline2[]"
                                                                    value="{{ unserialize($mitigation_plan_details->deadline2)[$key] ? unserialize($mitigation_plan_details->deadline2)[$key] : '' }}">
                                                            </td> --}}
                                                            <td><div class="group-input new-date-data-field mb-0">
                                                                <div class="input-date "><div class="calenderauditee">
                                                                <input type="text" id="deadline2{{$key}}' + serialNumber +'" readonly placeholder="DD-MMM-YYYY" value="{{ Helpers::getdateFormat(unserialize($mitigation_plan_details->deadline2)[$key]) }}" />
                                                                <input type="date" name="deadline2[]" class="hide-input" value="{{ unserialize($mitigation_plan_details->deadline2)[$key] }}"
                                                                oninput="handleDateInput(this, `deadline2{{$key}}' + serialNumber +'`)" /></div></div></div></td>
                                                            {{-- <td><input type="text" name="responsible_person[]"
                                                                    value="{{ unserialize($mitigation_plan_details->responsible_person)[$key] ? unserialize($mitigation_plan_details->responsible_person)[$key] : '' }}">
                                                            </td> --}}
                                                            <td> <select id="select-state" placeholder="Select..."
                                                                name="responsible_person[]">
                                                                <option value="">Select a Value</option>
                                                                @foreach ($users as $value)
                                                                    <option
                                                                        {{ unserialize($mitigation_plan_details->responsible_person)[$key] ? (unserialize($mitigation_plan_details->responsible_person)[$key] == $value->id ? 'selected' : ' ') : '' }}
                                                                        value="{{ $value->id }}">
                                                                        {{ $value->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select></td>
                                                            <td><input type="text" name="status[]"
                                                                    value="{{ unserialize($mitigation_plan_details->status)[$key] ? unserialize($mitigation_plan_details->status)[$key] : '' }}">
                                                            </td>
                                                            <td><input type="text" name="remark[]"
                                                                    value="{{ unserialize($mitigation_plan_details->remark)[$key] ? unserialize($mitigation_plan_details->remark)[$key] : '' }}">
                                                            </td>
                                                            <td><button type="text" class="removeRowBtn">Remove</button></td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="sub-head">Risk Mitigation</div>
                                        </div>
                                        {{-- <div class="col-12">
                                            <div class="group-input">
                                                <label for="mitigation-required">Mitigation Required</label>
                                                <div class="check-input">
                                                    <label for="yes">
                                                        <input selected type="radio" name="mitigation_required" id="yes">
                                                        Yes
                                                    </label>
                                                    <label for="no">
                                                        <input selected type="radio" name="mitigation_required" id="no">
                                                        No
                                                    </label>
                                                </div>
                                            </div>
                                        </div> --}}

                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="mitigation">Mitigation Required</label>
                                                <select name="mitigation_required" placeholder="Select Departments" {{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} data-search="false"
                                                    data-silent-initial-value-set="true" id="" >
                                                    <option value="">Select Mitigation </option>
                                                    <option value="yes"  {{ $data->mitigation_required == 'yes' ? 'selected' : '' }}>Yes</option>
                                                    <option value="no"  {{ $data->mitigation_status == 'no' ? 'selected' : '' }}>No</option>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="mitigation-plan">Mitigation Plan</label>
                                                <div class="relative-container">
                                                <textarea {{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} name="mitigation_plan" class="tiny">{{ $data->mitigation_plan }}</textarea>
                                                @component('frontend.forms.language-model', ['readonly' => $data->stage == 0 || $data->stage == 8])
                                                @endcomponent
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 new-date-data-field">
                                            <div class="group-input input-date">
                                                <label for="mitigation-due-date">Scheduled End Date</label>
                                                <div class="calenderauditee">
                                                    <input type="text" id="mitigation_due_date" readonly value="{{ Helpers::getdateFormat($data->mitigation_due_date)}}"
                                                        name="mitigation_due_date" placeholder="DD-MMM-YYYY" />
                                                    <input type="date" name="mitigation_due_date" {{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} value="{{ $data->mitigation_due_date }}" class="hide-input"  
                                                        oninput="handleDateInput(this, 'mitigation_due_date')" />
                                                </div>
                                                {{-- <input type="date" name="mitigation_due_date"
                                                    value="{{ $data->mitigation_due_date }}"> --}}
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="mitigation-status">Status of Mitigation</label>
                                                <select name="mitigation_status" {{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}>
                                                    <option value="">-- Select --</option>
                                                    <option value="Green Status"
                                                        {{ $data->mitigation_status == 'Green Status' ? 'selected' : '' }}>Green
                                                        Status</option>
                                                    <option value="Amber Status"
                                                        {{ $data->mitigation_status == 'Amber Status' ? 'selected' : '' }}>Amber
                                                        Status</option>
                                                    <option value="Red Staus"
                                                        {{ $data->mitigation_status == 'Red Staus' ? 'selected' : '' }}>Red
                                                        Staus</option>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="mitigation-status-comments">Mitigation Status Comments</label>
                                                <div class="relative-container">
                                                <textarea {{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} name="mitigation_status_comments">{{ $data->mitigation_status_comments }}</textarea>
                                                @component('frontend.forms.language-model', ['readonly' => $data->stage == 0 || $data->stage == 8])
                                                @endcomponent
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="sub-head">Overall Assessment</div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="impact">Impact</label>
                                                <select name="impact" {{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}>
                                                    <option value="">-- Select --</option>
                                                    <option value="High"
                                                        {{ $data->impact == 'High' ? 'selected' : '' }}>High</option>
                                                    <option value="Medium"
                                                        {{ $data->impact == 'Medium' ? 'selected' : '' }}>Medium</option>
                                                    <option value="Low"
                                                        {{ $data->impact == 'Low' ? 'selected' : '' }}>Low</option>
                                                    <option value="None"
                                                        {{ $data->impact == 'None' ? 'selected' : '' }}>None</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="criticality">Criticality</label>
                                                <select name="criticality" {{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}>
                                                    <option value="">-- Select --</option>
                                                    <option value="High"
                                                        {{ $data->criticality == 'High' ? 'selected' : '' }}>High</option>
                                                    <option value="Medium"
                                                        {{ $data->criticality == 'Medium' ? 'selected' : '' }}>Medium
                                                    </option>
                                                    <option value="Low"
                                                        {{ $data->criticality == 'Low' ? 'selected' : '' }}>Low</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="impact-analysis">Impact Analysis</label>
                                                <div class="relative-container">
                                                <textarea {{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} name="impact_analysis" class="tiny">{{ $data->impact_analysis }}</textarea>
                                                @component('frontend.forms.language-model', ['readonly' => $data->stage == 0 || $data->stage == 8])
                                                @endcomponent
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="risk-analysis">Risk Analysis</label>
                                                <div class="relative-container">
                                                <textarea {{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} name="risk_analysis" class="tiny">{{ $data->risk_analysis }}</textarea>
                                                @component('frontend.forms.language-model', ['readonly' => $data->stage == 0 || $data->stage == 8])
                                                @endcomponent
                                                </div>
                                            </div>
                                        </div>
                                        {{-- <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="severity">Severity</label>
                                                <select name="severity">
                                                    <option value="0">-- Select --</option>
                                                    <option value="Negligible"
                                                        {{ $data->severity == 'Negligible' ? 'selected' : '' }}>Negligible
                                                    </option>
                                                    <option value="Minor"
                                                        {{ $data->severity == 'Minor' ? 'selected' : '' }}>Minor</option>
                                                    <option value="Moderate"
                                                        {{ $data->severity == 'Moderate' ? 'selected' : '' }}>Moderate
                                                    </option>
                                                    <option value="Major"
                                                        {{ $data->severity == 'Major' ? 'selected' : '' }}>Major</option>
                                                    <option value="Fatal"
                                                        {{ $data->severity == 'Fatal' ? 'selected' : '' }}>Fatal</option>
                                                </select>
                                            </div>
                                        </div> --}}
                                        {{-- <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="occurance">Occurance</label>
                                                <select name="occurance">
                                                    <option value="0">-- Select --</option>
                                                    <option value="Extremely_Unlikely">Extremely Unlikely</option>
                                                    <option value="Rare"
                                                        {{ $data->occurance == 'Rare' ? 'selected' : '' }}>Rare</option>
                                                    <option value="Unlikely"
                                                        {{ $data->occurance == 'Unlikely' ? 'selected' : '' }}>Unlikely
                                                    </option>
                                                    <option value="Likely"
                                                        {{ $data->occurance == 'Likely' ? 'selected' : '' }}>Likely
                                                    </option>
                                                    <option value="Very_Likely"
                                                        {{ $data->occurance == 'Very_Likely' ? 'selected' : '' }}>Very
                                                        Likely</option>
                                                </select>
                                            </div>
                                        </div> --}}
                                        {{--<div class="col-lg-12">
                                            <div class="group-input">
                                                <label for="Reference Recores">Reference Record</label>
                                                <select {{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} multiple id="reference_record" name="refrence_record[]" id="">
                                                    @foreach ($old_record as $new)
                                                        <option value="{{ $new->id }}" {{ in_array($new->id, explode(',', $data->refrence_record)) ? 'selected' : '' }}>
                                                            {{ Helpers::getDivisionName($new->division_id) }}/RA/{{ date('Y') }}/{{ Helpers::recordFormat($new->record) }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>--}}


                                        <div class="col-lg-12">
                                            <div class="group-input">
                                                <label for="Reference Recores">Reference Record</label>
                                                <select {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}
                                                    multiple id="reference_record" name="refrence_record[]" id="">
    
                                                @if (!empty($old_record))
                                                    @foreach ($old_record as $new)
                                                        @php
                                                        
                                                            $recordValue =
                                                                Helpers::getDivisionName($new->division_id) .
                                                                '/RA/' .
                                                                date('Y') .
                                                                '/' .
                                                                Helpers::recordFormat($new->record);
    
                                                                
                                                            $selected = in_array(
                                                                $recordValue,
                                                                explode(',', $data->refrence_record),
                                                            )
                                                                ? 'selected'
                                                                : '';
                                                             //  dd($recordValue);
                                                        @endphp
                                                        <option value="{{ $recordValue }}" {{ $selected }}>
                                                            {{ $recordValue }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
    
                                    </div>
                                        <div class="col-12 sub-head">
                                            Extension Justification
                                        </div>
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="due_date_extension">Due Date Extension Justification</label>
                                                <div><small class="text-primary">Please Mention justification if due date is crossed</small></div>
                                                <div class="relative-container">
                                                <textarea {{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} name="due_date_extension" class="tiny">{{$data->due_date_extension}}</textarea>
                                                @component('frontend.forms.language-model', ['readonly' => $data->stage == 0 || $data->stage == 8])
                                                @endcomponent
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="button-block">
                                        <button type="submit" class="saveButton">Save</button>
                                        <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                        <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                        <button type="button"> <a class="text-white"> Exit </a> </button>
                                    </div>
                                </div>
                            </div>

                            <div id="CCForm7" class="inner-block cctabcontent">
                                <div class="inner-block-content">
                    
                                <div class="sub-head">Activity Log</div>
                    
                                    <div class="d-flex align-item-end justify-content-end">
                    
                                            <button style="margin-bottom:20px;" class="button_theme1"> <a
                                                    class="text-white"
                                                    href="{{ url('rcms/riskActivityPdf', $data->id) }}"> Print </a>
                                            </button>
                                    </div>
                    
                    
                                    <div class="printable-content">
                                        
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                    <tbody>
                                                                        <tr>
                                                                            <td>
                                                                                <strong>Submit By :</strong><br>
                                                                                {{ $data->submitted_by }}
                                                                            </td>
                                                                            <td>
                                                                                <strong>Submit On :</strong><br>
                                                                                {{ $data->submitted_on }}
                                                                            </td>
                                                                        </tr>
                    
                                                                        <tr>
                                                                            <td colspan="2">
                                                                                <strong>Submit Comments :</strong><br>
                                                                                {{ $data->submitted_comment}}
                                                                            </td>
                                                                        </tr>
                    
                    
                                                                        <tr>
                                                                            <td>
                                                                                <strong>Evaluation Complete By :</strong><br>
                                                                                {{ $data->evaluated_by }}
                                                                            </td>
                                                                            <td>
                                                                                <strong>Evaluation Complete On:</strong><br>
                                                                                {{ $data->evaluated_on }}
                                                                            </td>
                                                                        </tr>
                    
                                                                        <tr>
                                                                            <td colspan="2">
                                                                                <strong>Evaluation Complete Comment:</strong><br>
                                                                                {{ $data->evaluated_comment ?? 'Not Applicable' }}
                                                                            </td>
                                                                        </tr>
                                                                        
                                                                        <tr>
                                                                            <td>
                                                                                <strong>Action Plan Complete By :</strong><br>
                                                                                {{ $data->plan_complete_by }}
                                                                            </td>
                                                                            <td>
                                                                                <strong>Action Plan Complete On :</strong><br>
                                                                                {{ $data->plan_complete_on }}
                                                                            </td>
                                                                        </tr>
                    
                                                                        <tr>
                                                                            <td colspan="2">
                                                                                <strong>Action Plan Complete Comment :</strong><br>
                                                                                {{ $data->plan_complete_comment ?? 'Not Applicable' }}
                                                                            </td>
                                                                        </tr>
                                                                       
                    
                                                                        <tr>
                                                                            <td>
                                                                                <strong>Action Plan Approved By :</strong><br>
                                                                                {{ $data->plan_approved_by }}
                                                                            </td>
                                                                            <td>
                                                                                <strong>Action Plan Approved On :</strong><br>
                                                                                {{ $data->plan_approved_on }}
                                                                            </td>
                                                                        </tr>
                    
                                                                        <tr>
                                                                            <td colspan="2">
                                                                                <strong>Action Plan Approved Comment :</strong><br>
                                                                                {{ $data->plan_approved_comment ?? 'Not Applicable' }}
                                                                            </td>
                                                                        </tr>
                                                                        
                    
                                                                        <tr>
                                                                            <td>
                                                                                <strong>All Actions Completed By :</strong><br>
                                                                                {{ $data->actions_completed_by}}
                                                                            </td>
                                                                            <td>
                                                                                <strong>All Actions Completed On :</strong><br>
                                                                                {{ $data->actions_completed_on }}
                                                                            </td>
                                                                        </tr>
                    
                                                                        <tr>
                                                                            <td colspan="2">
                                                                                <strong>All Actions Completed Comment :</strong><br>
                                                                                {{ $data->actions_completed_comment ?? 'Not Applicable' }}
                                                                            </td>
                                                                        </tr>
                                                                       
                    
                                                                        <tr>
                                                                            <td>
                                                                                <strong>Residual Risk Evaluation Completed By :</strong><br>
                                                                                {{ $data->risk_analysis_completed_by }}
                                                                            </td>
                                                                            <td>
                                                                                <strong>Residual Risk Evaluation Completed On :</strong><br>
                                                                                {{ $data->risk_analysis_completed_on }}
                                                                            </td>
                                                                        </tr>
                    
                                                                        <tr>
                                                                            <td colspan="2">
                                                                                <strong>Residual Risk Evaluation Completed Comment :</strong><br>
                                                                                {{ $data->risk_analysis_completed_comment ?? 'Not Applicable' }}
                                                                            </td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td>
                                                                                <strong>Cancel By :</strong><br>
                                                                                {{ $data->cancelled_by }}
                                                                            </td>
                                                                            <td>
                                                                                <strong>Cancel On :</strong><br>
                                                                                {{ $data->cancelled_on }}
                                                                            </td>
                                                                        </tr>
                    
                                                                        <tr>
                                                                            <td colspan="2">
                                                                                <strong>Cancel Comment :</strong><br>
                                                                                {{ $data->cancelled_comment ?? 'Not Applicable' }}
                                                                            </td>
                                                                        </tr>
                
                    
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                    
                    
                                      
                                    <div class="button-block">
                                        <button type="submit"{{ $data->stage == 0 || $data->stage == 7 || $data->stage == 9 ? 'disabled' : '' }}
                                            class="saveButton saveAuditFormBtn d-flex" style="align-items: center;">
                                            <div class="spinner-border spinner-border-sm auditFormSpinner" style="display: none"
                                                role="status">
                                                <span class="sr-only">Loading...</span>
                                            </div>
                                            Save
                                        </button>
                                        <a href="/rcms/qms-dashboard">
                                            <button type="button"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}
                                                class="backButton">Back</button>
                                        </a>
                                        <button type="button"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}> <a
                                                href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                                                Exit </a> </button>
                                    </div>
                                </div>
                            </div>
                    
                    



                            <!-- Signatures content -->
                            {{--<div id="CCForm7" class="inner-block cctabcontent">
                                <div class="inner-block-content">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Submitted By..">Submit By</label>
                                                <div class="static">{{ $data->submitted_by }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Submitted On">Submit On</label>
                                                <div class="static">{{ $data->submitted_on }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Submitted On">Submit Comment</label>
                                                <div class="static">{{ $data->submitted_comment }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Evaluated By">Evaluation Complete By</label>
                                                <div class="static">{{ $data->evaluated_by }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Evaluated On">Evaluation Complete On</label>
                                                <div class="static">{{ $data->evaluated_on }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Evaluated On">Evaluation Complete Comment</label>
                                                <div class="static">{{ $data->evaluated_comment }}</div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Plan Approved By">Action Plan Complete By</label>
                                                <div class="static">{{ $data->plan_complete_by }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Plan Approved On">Action Plan Complete On</label>
                                                <div class="static">{{ $data->plan_complete_on }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Plan Approved On">Action Plan Complete Comment</label>
                                                <div class="static">{{ $data->plan_complete_comment }}</div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Risk Analysis Completed By">Action Plan Approved By</label>
                                                <div class="static">{{ $data->plan_approved_by }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Risk Analysis Completed On">Action Plan Approved On</label>
                                                <div class="static">{{ $data->plan_approved_on }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Risk Analysis Completed On">Action Plan Approved Comment</label>
                                                <div class="static">{{ $data->plan_approved_comment }}</div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Cancel">All Actions Completed By</label>
                                                <div class="static">{{ $data->actions_completed_by }}</div>
                                            </div>
                                        </div> 
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Cancel">All Actions Completed On</label>
                                                <div class="static">{{ $data->actions_completed_on }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Cancel">All Actions Completed Comment</label>
                                                <div class="static">{{ $data->actions_completed_comment }}</div>
                                            </div>
                                        </div> 
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Cancel">Residual Risk Evaluation Completed By</label>
                                                <div class="static">{{ $data->risk_analysis_completed_by }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Cancel">Residual Risk Evaluation Completed On</label>
                                                <div class="static">{{ $data->risk_analysis_completed_on }}</div>
                                            </div>
                                        </div> 
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Cancel">Residual Risk Evaluation Completed Comment</label>
                                                <div class="static">{{ $data->risk_analysis_completed_comment }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Cancel">Cancel By</label>
                                                <div class="static">{{ $data->cancelled_by }}</div>
                                            </div>
                                        </div> 
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Cancel">Cancel On</label>
                                                <div class="static">{{ $data->cancelled_on }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Cancel">Cancel Comment</label>
                                                <div class="static">{{ $data->cancelled_comment }}</div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="button-block">
                                        <button type="submit" class="saveButton"
                                            {{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}>Save</button>
                                        <button type="button" class="backButton"
                                            onclick="previousStep()">Back</button>
                                        {{--<button type="submit"
                                            {{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}>Submit</button>
                                        <button type="button"> <a class="text-white"
                                                href="{{ url('rcms/qms-dashboard') }}"> Exit </a> </button>
                                    </div>
                                </div>
                            </div>--}}

                        </div>
                    </form>

                </div>
            </div>

                <div class="sticky-buttons">
                    <div>
                        <a type="button" class="" data-toggle="modal" data-target="#myModal3">
                            <svg width="18" height="24" viewBox="0 0 384 512" xmlns="http://www.w3.org/2000/svg">
                                <path fill="#ffffff"
                                    d="M369.9 97.9L286 14C277 5 264.8-.1 252.1-.1H48C21.5 0 0 21.5 0 48v416c0 26.5 21.5 48 48 48h288c26.5 0 48-21.5 48-48V131.9c0-12.7-5.1-25-14.1-34M332.1 128H256V51.9zM48 464V48h160v104c0 13.3 10.7 24 24 24h104v288zm220.1-208c-5.7 0-10.6 4-11.7 9.5c-20.6 97.7-20.4 95.4-21 103.5c-.2-1.2-.4-2.6-.7-4.3c-.8-5.1.3.2-23.6-99.5c-1.3-5.4-6.1-9.2-11.7-9.2h-13.3c-5.5 0-10.3 3.8-11.7 9.1c-24.4 99-24 96.2-24.8 103.7c-.1-1.1-.2-2.5-.5-4.2c-.7-5.2-14.1-73.3-19.1-99c-1.1-5.6-6-9.7-11.8-9.7h-16.8c-7.8 0-13.5 7.3-11.7 14.8c8 32.6 26.7 109.5 33.2 136c1.3 5.4 6.1 9.1 11.7 9.1h25.2c5.5 0 10.3-3.7 11.6-9.1l17.9-71.4c1.5-6.2 2.5-12 3-17.3l2.9 17.3c.1.4 12.6 50.5 17.9 71.4c1.3 5.3 6.1 9.1 11.6 9.1h24.7c5.5 0 10.3-3.7 11.6-9.1c20.8-81.9 30.2-119 34.5-136c1.9-7.6-3.8-14.9-11.6-14.9h-15.8z" />
                            </svg>
                        </a>
                    </div>

                </div>

                <div class="modal right fade" id="myModal3" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-titles ml-10">Risk Assessment Workflow</h4>
                            </div>
                            <div style="" class="modal-body main-new-workflow">
                                <Div class="button-box">
                                @if ($data->stage == 0)
                                    <div class="progress-bars">
                                        <div class="bg-danger">Closed-Cancelled</div>
                                    </div>
                                @else
                                    <div class="progress-bars" style="font-size: 15px;">
                                    @if ($data->stage >= 1)
                                    <div  class="active">
                                        Opened
                                    </div>
                                    @else
                                    <div class="mini_buttons">Opened</div>
                                    @endif
                                    <div class="down-logo">
                                        <img class="dawn_arrow" src="{{ asset('user/images/down.gif') }}" alt="..." class="w-100 h-100">
                                    </div>
                                    @if ($data->stage >= 2)
    
                                    <div  class="active">
                                        Risk Analysis & Work Group Assignment
                                    </div> 
                                    @else
                                    <div  class="mini_buttons">
                                        Risk Analysis & Work Group Assignment
                                    </div>
                                    @endif
                                    <div class="down-logo">
                                        <img class="dawn_arrow" src="{{ asset('user/images/down.gif') }}" alt="..."
                                            class="w-100 h-100">
        
                                    </div>
                                    @if ($data->stage >= 3)
                                    <div  class="active">
                                        Risk Processing & Action Plan
                                    </div>
                                    @else
                                    <div  class="mini_buttons">
                                        Risk Processing & Action Plan
                                    </div>
                                    @endif
                                    <div class="down-logo">
                                        <img class="dawn_arrow" src="{{ asset('user/images/down.gif') }}" alt="..."
                                            class="w-100 h-100">
        
                                    </div>
                                    @if ($data->stage >= 4)
    
                                    <div  class="active">
                                       Pending HOD Approval
                                    </div>
                                    @else
                                    <div  class="mini_buttons">
                                       Pending HOD Approval
                                    </div>
                                    @endif
    
                                    <div class="down-logo">
                                        <img class="dawn_arrow" src="{{ asset('user/images/down.gif') }}" alt="..."
                                            class="w-100 h-100">
        
                                    </div>
                                    @if ($data->stage >= 5)
    
                                    <div  class="active">
                                        Actions Items in Progress
                                    </div>
                                    @else
                                    <div  class="mini_buttons">
                                        Actions Items in Progress
                                    </div>
                                    @endif
    
                                    <div class="down-logo">
                                        <img class="dawn_arrow" src="{{ asset('user/images/down.gif') }}" alt="..."
                                            class="w-100 h-100">
        
                                    </div>
                                    @if ($data->stage >= 6)
    
                                    <div  class="active">
                                        Residual Risk Evaluation
                                    </div>
                                    @else
                                    <div  class="mini_buttons">
                                        Residual Risk Evaluation
                                    </div>
                                    @endif
    
                                    <div class="down-logo">
                                        <img class="dawn_arrow" src="{{ asset('user/images/down.gif') }}" alt="..."
                                            class="w-100 h-100">
        
                                    </div>
                                    
                                
                                    @if ($data->stage >= 7)
                                    <div class=" mini_buttons bg-danger">Closed - Done</div>
                                @else
                                    <div class="mini_buttons">Closed - Done </div>
                                @endif
                                @endif    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="modal fade" id="signature-modal">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">E-Signature</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <form action="{{ route('riskAssesmentStateUpdate', $data->id) }}" method="POST">
                            @csrf
                            <!-- Modal body -->
                            <div class="modal-body">
                                <div class="mb-3 text-justify">
                                    Please select a meaning and a outcome for this task and enter your username
                                    and password for this task. You are performing an electronic signature,
                                    which is legally binding equivalent of a hand written signature.
                                </div>
                                <div class="group-input">
                                    <label for="username">Username <span class="text-danger">*</span></label>
                                    <input type="text" name="username" required>
                                </div>
                                <div class="group-input">
                                    <label for="password">Password <span class="text-danger">*</span></label>
                                    <input type="password" name="password" required>
                                </div>
                                <div class="group-input">
                                    <label for="comment">Comment</label>
                                    <input type="comment" name="comment">
                                </div>
                            </div>

                            <!-- Modal footer -->
                            <!-- <div class="modal-footer">
                                <button type="submit" data-bs-dismiss="modal">Submit</button>
                                <button type="button" data-bs-dismiss="modal">Close</button>
                            </div> -->
                            <div class="modal-footer">
                              <button type="submit">Submit</button>
                                <button type="button" data-bs-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="rejection-modal">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">E-Signature</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <form action="{{ url('reject_Risk', $data->id) }}" method="POST">
                            @csrf
                            <!-- Modal body -->
                            <div class="modal-body">
                                <div class="mb-3 text-justify">
                                    Please select a meaning and a outcome for this task and enter your username
                                    and password for this task. You are performing an electronic signature,
                                    which is legally binding equivalent of a hand written signature.
                                </div>
                                <div class="group-input">
                                    <label for="username">Username <span class="text-danger">*</span></label>
                                    <input type="text" name="username" required>
                                </div>
                                <div class="group-input">
                                    <label for="password">Password <span class="text-danger">*</span></label>
                                    <input type="password" name="password" required>
                                </div>
                                <div class="group-input">
                                    <label for="comment">Comment <span class="text-danger">*</span></label>
                                    <input type="comment" name="comment" required>
                                </div>
                            </div>

                            <!-- Modal footer -->
                            <!-- <div class="modal-footer">
                                <button type="submit" data-bs-dismiss="modal">Submit</button>
                                <button>Close</button>
                            </div> -->
                            <div class="modal-footer">
                              <button type="submit">Submit</button>
                                <button type="button" data-bs-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="cancel-modal">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">E-Signature</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <form action="{{ url('cancel_Risk', $data->id) }}" method="POST">
                            @csrf
                            <!-- Modal body -->
                            <div class="modal-body">
                                <div class="mb-3 text-justify">
                                    Please select a meaning and a outcome for this task and enter your username
                                    and password for this task. You are performing an electronic signature,
                                    which is legally binding equivalent of a hand written signature.
                                </div>
                                <div class="group-input">
                                    <label for="username">Username <span class="text-danger">*</span></label>
                                    <input type="text" name="username" required>
                                </div>
                                <div class="group-input">
                                    <label for="password">Password <span class="text-danger">*</span></label>
                                    <input type="password" name="password" required>
                                </div>
                                <div class="group-input">
                                    <label for="comment">Comment <span class="text-danger">*</span></label>
                                    <input type="comment" name="comment" required>
                                </div>
                            </div>

                            <!-- Modal footer -->
                            <!-- <div class="modal-footer">
                                <button type="submit" data-bs-dismiss="modal">Submit</button>
                                <button>Close</button>
                            </div> -->
                            <div class="modal-footer">
                              <button type="submit">Submit</button>
                                <button type="button" data-bs-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="child-modal">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Child</h4>
                        </div>
                        <form action="{{ route('riskAssesmentChild', $data->id) }}" method="POST">
                            @csrf
                            <!-- Modal body -->
                            <div class="modal-body">
                                <div class="group-input">
                                    <label for="major">
                                        <input type="radio" name="revision" id="major" value="Action-Item">
                                        Create Action Item
                                    </label>


                                </div>

                            </div>

                            <!-- Modal footer -->
                            <div class="modal-footer">
                                <button type="button" data-bs-dismiss="modal">Close</button>
                                <button type="submit">Continue</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>


            <style>
                #step-form>div {
                    display: none
                }

                #step-form>div:nth-child(1) {
                    display: block;
                }
            </style>
            <script>
                $(document).ready(function() {
                    $('#action_plan').click(function(e) {
                        function generateTableRow(serialNumber) {
                            var users = @json($users);
                            console.log(users);
                            var html =
                            '<tr>' +
                                '<td><input disabled type="text" name="serial_number[]" value="' + serialNumber + '"></td>' +
                                '<td><input type="text" name="action[]"></td>' +
                                '<td><select name="responsible[]">' +
                                    '<option value="">Select a value</option>';

                                for (var i = 0; i < users.length; i++) {
                                    html += '<option value="' + users[i].id + '">' + users[i].name + '</option>';
                                }

                                html += '</select></td>' +
                                // '<td><input type="date" name="deadline[]"></td>' +
                                '<td><div class="group-input new-date-data-field mb-0"><div class="input-date "><div class="calenderauditee"><input type="text" id="deadline' + serialNumber +'" readonly placeholder="DD-MMM-YYYY" /><input type="date" name="deadline[]" class="hide-input" oninput="handleDateInput(this, `deadline' + serialNumber +'`)" /></div></div></div></td>'
                                 +
                                '<td><input type="text" name="item_static[]"></td>' +
                                '<td><button type="text" class="removeRowBtn">Remove</button></td>' +
                                '</tr>';



                            return html;
                        }

                        var tableBody = $('#action_plan_details tbody');
                        var rowCount = tableBody.children('tr').length;
                        var newRow = generateTableRow(rowCount + 1);
                        tableBody.append(newRow);
                    });
                    $('#mitigation_plan_deatails').click(function(e) {
                        function generateTableRow(serialNumber) {
                            var users = @json($users);
                            // console.log(users);
                            var html =
                            '<tr>' +
                                '<td><input disabled type="text" name="serial_number[]" value="' + serialNumber + '"></td>' +
                                '<td><input type="text" name="mitigation_steps[]"></td>' +
                                // '<td><input type="date" name="deadline2[]"></td>' +
                                '<td><div class="group-input new-date-data-field mb-0"><div class="input-date "><div class="calenderauditee"><input type="text" id="deadline2' + serialNumber +'" readonly placeholder="DD-MMM-YYYY" /><input type="date" name="deadline2[]" class="hide-input" oninput="handleDateInput(this, `deadline2' + serialNumber +'`)" /></div></div></div></td>'
                                  +
                                '<td><select name="responsible_person[]">' +
                                    '<option value="">Select a value</option>';

                                for (var i = 0; i < users.length; i++) {
                                    html += '<option value="' + users[i].id + '">' + users[i].name + '</option>';
                                }

                                html += '</select></td>' +
                                '<td><input type="text" name="status[]"></td>' +
                                '<td><input type="text" name="remark[]"></td>' +
                                '<td><button type="text" class="removeRowBtn">Remove</button></td>'+
                                
                                '</tr>';

                            return html;
                        }

                        var tableBody = $('#mitigation_plan_deatails_details tbody');
                        var rowCount = tableBody.children('tr').length;
                        var newRow = generateTableRow(rowCount + 1);
                        tableBody.append(newRow);
                    });
                });
            </script>

            <script>
                VirtualSelect.init({
                    ele: '#Facility, #Group, #Audit, #Auditee, #root-cause-methodology, #reference_record, #related_record'
                });



            $(document).on('click', '.removeBtn', function() {
                console.log('click ');
                $(this).closest('tr').remove();
            })
                function openCity(evt, cityName) {
                    var i, cctabcontent, cctablinks;
                    cctabcontent = document.getElementsByClassName("cctabcontent");
                    for (i = 0; i < cctabcontent.length; i++) {
                        cctabcontent[i].style.display = "none";
                    }
                    cctablinks = document.getElementsByClassName("cctablinks");
                    for (i = 0; i < cctablinks.length; i++) {
                        cctablinks[i].className = cctablinks[i].className.replace(" active", "");
                    }
                    document.getElementById(cityName).style.display = "block";
                    evt.currentTarget.className += " active";
                }



                function openCity(evt, cityName) {
                    var i, cctabcontent, cctablinks;
                    cctabcontent = document.getElementsByClassName("cctabcontent");
                    for (i = 0; i < cctabcontent.length; i++) {
                        cctabcontent[i].style.display = "none";
                    }
                    cctablinks = document.getElementsByClassName("cctablinks");
                    for (i = 0; i < cctablinks.length; i++) {
                        cctablinks[i].className = cctablinks[i].className.replace(" active", "");
                    }
                    document.getElementById(cityName).style.display = "block";
                    evt.currentTarget.className += " active";

                    // Find the index of the clicked tab button
                    const index = Array.from(cctablinks).findIndex(button => button === evt.currentTarget);

                    // Update the currentStep to the index of the clicked tab
                    currentStep = index;
                }

                const saveButtons = document.querySelectorAll(".saveButton");
                const nextButtons = document.querySelectorAll(".nextButton");
                const form = document.getElementById("step-form");
                const stepButtons = document.querySelectorAll(".cctablinks");
                const steps = document.querySelectorAll(".cctabcontent");
                let currentStep = 0;

                function nextStep() {
                    // Check if there is a next step
                    if (currentStep < steps.length - 1) {
                        // Hide current step
                        steps[currentStep].style.display = "none";

                        // Show next step
                        steps[currentStep + 1].style.display = "block";

                        // Add active class to next button
                        stepButtons[currentStep + 1].classList.add("active");

                        // Remove active class from current button
                        stepButtons[currentStep].classList.remove("active");

                        // Update current step
                        currentStep++;
                    }
                }

                function previousStep() {
                    // Check if there is a previous step
                    if (currentStep > 0) {
                        // Hide current step
                        steps[currentStep].style.display = "none";

                        // Show previous step
                        steps[currentStep - 1].style.display = "block";

                        // Add active class to previous button
                        stepButtons[currentStep - 1].classList.add("active");

                        // Remove active class from current button
                        stepButtons[currentStep].classList.remove("active");

                        // Update current step
                        currentStep--;
                    }
                }
            </script>
             <script>
                document.getElementById('initiator_group').addEventListener('change', function() {
                    var selectedValue = this.value;
                    document.getElementById('initiator_group_code').value = selectedValue;
                });
            </script>

            <script>
                VirtualSelect.init({
                    ele: '#departments,#departments2, #team_members, #training-require, #impacted_objects'
                });
            </script>
            <script>
                $(document).ready(function() {
                    var loc = new locationInfo();
                    var countryDropdown = $("#country"); 
                    var desiredValue = '{{$data->country}}'; 
                     setTimeout(function() {
                        countryDropdown.find('option[value="{{$data->country}}"]').prop('selected', true);
                         var countryId = jQuery("option:selected", this).attr('countryid');
                            if(countryId != ''){
                                loc.getStates(countryId);
                            }
                            else{
                                jQuery(".states option:gt(0)").remove();
                            }
                        var stateDropdown = $("#state");     
                        stateDropdown.find('option[value="{{$data->state}}"]').prop('selected', true);
                        var stateId = jQuery("option:selected", this).attr('stateid');
                        if(stateId != ''){
                            loc.getCities(stateId);
                        }
                        else{
                            jQuery(".cities option:gt(0)").remove();
                        }
                        var cityDropdown = $("#city");     
                        cityDropdown.find('option[value="{{$data->city}}"]').prop('selected', true);
                    }, 1000);
                });
                function calculateRiskAnalysis(selectElement) {
                    // Get the row containing the changed select element
                    let row = selectElement.closest('tr');

                    // Get values from select elements within the row
                    let R = parseFloat(document.getElementById('analysisR').value) || 0;
                    let P = parseFloat(document.getElementById('analysisP').value) || 0;
                    let N = parseFloat(document.getElementById('analysisN').value) || 0;

                    // Perform the calculation
                    let result = R * P * N;

                    // Update the result field within the row
                    document.getElementById('analysisRPN').value = result;
                }
            </script>
            <script>
                var maxLength = 255;
                $('#docname').keyup(function() {
                    var textlen = maxLength - $(this).val().length;
                    $('#rchars').text(textlen);});
            </script>
               <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const removeButtons = document.querySelectorAll('.remove-file');
    
                    removeButtons.forEach(button => {
                        button.addEventListener('click', function () {
                            const fileName = this.getAttribute('data-file-name');
                            const fileContainer = this.closest('.file-container');
    
                            // Hide the file container
                            if (fileContainer) {
                                fileContainer.style.display = 'none';
                            }
                        });
                    });
                });
            </script>


        <script>
        $(document).on('click', '.removeRowBtn', function() {
           
            $(this).closest('tr').remove();
        })
    </script>


        {{--Side Bar Workflow script start--}}

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

        {{--Side Bar Workflow script end--}}
        @endsection
