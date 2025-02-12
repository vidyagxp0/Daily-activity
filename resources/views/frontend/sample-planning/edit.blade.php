@extends('frontend.layout.main')
@section('container')
    @php
        $users = DB::table('users')->select('id', 'name')->get();
        $locations = DB::table('q_m_s_divisions')->select('id', 'name')->get();
    @endphp
    <style>
        textarea.note-codable {
            display: none !important;
        }

        header {
            display: none;
        }
    </style>
    <style>
        .mini-modal {
            display: none;
            position: absolute;
            z-index: 1;
            padding: 10px;
            background-color: #fefefe;
            border: 1px solid #888;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 200px;
            /* Adjust width as needed */
        }

        .mini-modal-content {
            background-color: #fefefe;
            padding: 10px;
            border-radius: 4px;
        }
        #change-control-fields .inner-block .group-input table input, #change-control-fields .inner-block .group-input table select{
            border: 1px solid black;
            padding: 4px
        }

        .mini-modal-content h2 {
            font-size: 16px;
            margin-top: 0;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 20px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
        }
    </style>
        <style>
        textarea.note-codable {
            display: none !important;
        }
        #request_for > div > div {
            z-index: 3 !important;
        }

        header {
            display: none;
        }

        .custom-file-upload {
            background-color: #007bff;
            color: white;
            padding: 6px 12px;
            cursor: pointer;
            border-radius: 4px;
            margin-right: 10px;
        }

        #fileName {
            font-family: Arial, sans-serif;
            font-size: 14px;
            color: #333;
        }
    </style>
    <style>
        textarea.note-codable {
            display: none !important;
        }

        header {
            display: none;
        }

        .custom-select {
            border: 1px solid black !important;
            height: 32px;
            margin-top: -11px;
        }
    </style>
    <style>
        .progress-bars div {
            flex: 1 1 auto;
            border: 1px solid grey;
            padding: 5px;
            text-align: center;
            position: relative;
            /* border-right: none; */
            background: white;
            font-size: 12px;

        }

        .state-block {
            padding: 20px;
            margin-bottom: 20px;
        }

        .progress-bars div.active {
            background: green;
            font-weight: bold;
        }

        #change-control-fields>div>div.inner-block.state-block>div.status>div.progress-bars.d-flex>div:nth-child(1) {
            border-radius: 20px 0px 0px 20px;
        }

        #change-control-fields>div>div.inner-block.state-block>div.status>div.progress-bars.d-flex>div:nth-child(14) {
            border-radius: 0px 20px 20px 0px;
        }
    </style>

    <style>
        .collapsible-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            padding: 10px;
            /* background-color: #f8f9fa; */
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-top: 10px;
        }

        .collapsible-header .title {
            font-weight: bold;
            color: #007bff;
            text-decoration: none;
            flex-grow: 1;
            font-size: 18px;
        }

        .collapsible-header .icon {
            font-size: 20px;
            transition: transform 0.3s;
        }

        .collapsible-header.collapsed .icon {
            transform: rotate(180deg);
        }

        .collapsible-content {
            padding: 15px;
            border: 1px solid #ddd;
            border-top: none;
            border-radius: 0 0 4px 4px;
        }
    </style>


    <style>
        textarea.note-codable {
            display: none !important;
        }

        header {
            display: none;
        }

        .sub-main-head {
            display: flex;
            justify-content: space-evenly;
        }

        .Activity-type {
            margin-bottom: 7px;
        }

        /* .sub-head {
                                margin-left: 280px;
                                margin-right: 280px;
                                color: #4274da;
                                border-bottom: 2px solid #4274da;
                                padding-bottom: 5px;
                                margin-bottom: 20px;
                                font-weight: bold;
                                font-size: 1.2rem;

                            } */
        .launch_extension {
            background: #4274da;
            color: white;
            border: 0;
            padding: 4px 15px;
            border: 1px solid #4274da;
            transition: all 0.3s linear;
        }

        .main_head_modal li {
            margin-bottom: 10px;
        }

        .extension_modal_signature {
            display: block;
            width: 100%;
            border: 1px solid #837f7f;
            border-radius: 5px;
        }

        .main_head_modal {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .create-entity {
            background: #323c50;
            padding: 10px 15px;
            color: white;
            margin-bottom: 20px;

        }

        .bottom-buttons {
            display: flex;
            justify-content: flex-end;
            margin-right: 300px;
            margin-top: 50px;
            gap: 20px;
        }

        .text-danger {
            margin-top: -22px;
            padding: 4px;
            margin-bottom: 3px;
        }

        /* .saveButton:disabled{
                                    background: black!important;
                                    border:  black!important;

                                } */

        .main-danger-block {
            display: flex;
        }

        .swal-modal {
            scale: 0.7 !important;
        }

        .swal-icon {
            scale: 0.8 !important;
        }

        .custom-select {
            border: 1px solid black !important;
            height: 32px;
            margin-top: -11px;
        }

        .custom-date-picker {
            height: 35px;
            border: 1px solid black !important;
            padding: 11px !important;
        }

        .custom-border {
            border: 1px solid black !important;
            /* padding: 10px;
                            margin-bottom: 10px;
                            margin-top: 10px; */
        }
        .highlight {
      background-color: yellow!important;
      border: 2px solid orange!important;
      color: #000!important;
    }
    </style>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"
       integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA=="
       crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <div class="mini-modal">
        <div class="mini-modal-content">
            <span class="close">&times;</span>
            <h2>Select Language</h2>
            <select id="language-select">
                <option value="en-us">English</option>
                <option value="hi-in">Hindi</option>
                <option value="te-in">Telugu</option>
                <option value="fr-fr">French</option>
                <option value="es-es">Spanish</option>
                <option value="zh-cn">Chinese (Mandarin)</option>
                <option value="ja-jp">Japanese</option>
                <option value="de-de">German</option>
                <option value="ru-ru">Russian</option>
                <option value="ko-kr">Korean</option>
                <option value="it-it">Italian</option>
                <option value="pt-br">Portuguese (Brazil)</option>
                <option value="ar-sa">Arabic</option>
                <option value="bn-in">Bengali</option>
                <option value="pa-in">Punjabi</option>
                <option value="mr-in">Marathi</option>
                <option value="gu-in">Gujarati</option>
                <option value="ur-pk">Urdu</option>
                <option value="ta-in">Tamil</option>
                <option value="kn-in">Kannada</option>
                <option value="ml-in">Malayalam</option>
                <option value="or-in">Odia</option>
                <option value="as-in">Assamese</option>
                <!-- Add more languages as needed -->
            </select>
            <button id="select-language-btn">Select</button>
        </div>
    </div>
    </div>
    </div>
    </div>



    <script>
        function otherController(value, checkValue, blockID) {
            let block = document.getElementById(blockID)
            let blockTextarea = block.getElementsByTagName('textarea')[0];
            let blockLabel = block.querySelector('label span.text-danger');
            if (value === checkValue) {
                blockLabel.classList.remove('d-none');
                blockTextarea.setAttribute('required', 'required');
            } else {
                blockLabel.classList.add('d-none');
                blockTextarea.removeAttribute('required');
            }
        }
    </script>

    @php
        $division = DB::table('divisions')->get();
    @endphp

    <div class="form-field-head">
        <div class="division-bar">
            <strong>Site Division/Project</strong> :
                {{ Helpers::getDivisionName(session()->get('division')) }} / Sample Management II
        </div>
    </div>
    <div id="change-control-fields">
        <div class="container-fluid">

        <div class="inner-block state-block">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="language-sleect d-flex" style="align-items: center; gap: 20px;">
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

                    <div class="d-flex" style="gap:20px;">

                        @php
                        $userRoles = DB::table('user_roles')
                            ->where(['user_id' => Auth::user()->id, 'q_m_s_divisions_id' => $data->division_id])
                            ->get();
                        $userRoleIds = $userRoles->pluck('q_m_s_roles_id')->toArray();
                        $cftRolesAssignUsers = collect($userRoleIds);
                    @endphp

                        <button class="button_theme1"> <a class="text-white" href="{{ url('rcms/sample-planning-audit-trail', $data->id) }}"> Audit Trail </a> </button>

                        @if ($data->stage == 1 && Helpers::check_roles($data->division_id, 'Sample Management', 3))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Sample Registration
                            </button>
                        @elseif($data->stage == 2 && Helpers::check_roles($data->division_id, 'Sample Management', 80))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#rejection-modal">
                                More Information Required
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Analysis Complete
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#child-modal">
                                Child
                            </button>
                        @elseif($data->stage == 3 && Helpers::check_roles($data->division_id, 'Sample Management', 14))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#rejection-modal">
                                More Information Required
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Supervisor Review Complete
                            </button>
                        @elseif($data->stage == 4 && Helpers::check_roles($data->division_id, 'Sample Management', 7))                                  
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#rejection-modal">
                                More Information Required
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                QA Review Complete
                            </button>
                        @else
                        
                        @endif
                        <button class="button_theme1"> <a class="text-white" href="{{ url('rcms/lims-dashboard') }}"> Exit </a> </button>
                    </div>
                   
                </div>
                  
                 <div class="status">
                    @if ($data->stage == 0)
                        <div class="progress-bars">
                            <div class="bg-danger">Closed-Cancelled</div>
                        </div>
                     @else
                        <div class="progress-bars d-flex" style="margin-bottom: 16px;">
                            @if ($data->stage >= 1)
                                <div class="active">Opened</div>
                            @else
                                <div class="">Opened</div>
                            @endif
                            @if ($data->stage >= 2)
                                <div class="active">Pending Analysis</div>
                            @else
                                <div class="">Pending Analysis</div>
                            @endif
                            @if ($data->stage >= 3)
                                <div class="active">Pending Supervisor Review</div>
                            @else
                                <div class="">Pending Supervisor Review</div>
                            @endif
                            @if ($data->stage >= 4)
                                <div class="active">Pending QA Review</div>
                            @else
                                <div class="">Pending QA Review</div>
                            @endif
                            @if ($data->stage >= 5)
                                <div class="bg-danger active">Closed - Done</div>
                            @else
                                <div class="">Closed - Done</div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
    
            <!-- Tab links -->
            <div class="cctab">
                <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">Sample Registration</button>
                <!-- <button class="cctablinks" onclick="openCity(event, 'CCForm2')">Sample Analysis</button> -->
                <button class="cctablinks" onclick="openCity(event, 'CCForm3')">Supervisor Review</button>
                <!-- <button class="cctablinks" onclick="openCity(event, 'CCForm4')">Stability Information</button> -->
                <button class="cctablinks" onclick="openCity(event, 'CCForm5')">QA Review</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm6')">Activity Log</button>
            </div>

            <script>
                $(document).ready(function() {
                    setTimeout(() => {
                        $('body').css('top', '0');
                    }, 5000);
                })
            </script>
            <form id="auditform" class="mainform" action="{{ route('update-sample-planning', $data->id) }}" method="post"
                enctype="multipart/form-data">
                @csrf
                <div id="step-form">

                    <!-- General information content -->
                    <div id="CCForm1" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="RLS Record Number"><b>Record Number</b></label>
                                        <input disabled type="text" name="record_number"
                                            value="{{ Helpers::getDivisionName(session()->get('division')) }}/Sample Management/{{ date('Y') }}/{{ $data->record }}">
                                        <input type="hidden" name="recordNumber"
                                            value="{{ Helpers::getDivisionName(session()->get('division')) }}/Sample Management/{{ date('Y') }}/{{ $data->record }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Division Code"><b>Location/Lab Code</b></label>
                                        <input disabled type="text"
                                            value="{{ Helpers::getDivisionName($data->division_id) }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Initiator"><b>Initiator</b></label>
                                        <input disabled type="text" value="{{ Helpers::getInitiatorName($data->initiator_id) }}">

                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input ">
                                        <label for="Due Date"><b>Date of Initiation</b></label>
                                        <input readonly type="text" value="{{ Helpers::getdateFormat($data->intiation_date) }}">
                                    </div>
                                </div>
                                <!-- <div class="col-md-6">
                                    <div class="group-input">
                                        <label for="search">
                                            Assigned To <span class="text-danger"></span>
                                        </label>
                                        <select id="select-state" placeholder="Select..." name="assign_to">
                                            <option value="">Select a value</option>
                                            @foreach ($users as $user)
                                                <option @if($data->assign_to == $user->id) selected @endif value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div> -->

                                <div class="col-lg-6">
                                    <div class="group-input ">
                                        <label for="Due Date"><b>Due Date</b></label>
                                        <input readonly type="text" value="{{ $data->due_date }}">
                                    </div>
                                </div>

                                <!-- <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Initiator Group"><b>Initiator Group</b></label>
                                        <select name="Initiator_Group" id="initiator_group">
                                            <option value="">-- Select --</option>
                                            <option value="CQA" @if ($data->Initiator_Group == 'CQA') selected @endif>
                                                Corporate Quality Assurance
                                            </option>
                                            <option value="QAB" @if ($data->Initiator_Group == 'QAB') selected @endif>
                                                Quality Assurance Biopharma
                                            </option>
                                            <option value="CQC" @if ($data->Initiator_Group == 'CQC') selected @endif>
                                                Central Quality Control
                                            </option>
                                            <option value="MANU" @if ($data->Initiator_Group == 'MANU') selected @endif>
                                                Manufacturing
                                            </option>
                                            <option value="PSG" @if ($data->Initiator_Group == 'PSG') selected @endif>
                                                Plasma Sourcing Group
                                            </option>
                                            <option value="CS" @if ($data->Initiator_Group == 'CS') selected @endif>
                                                Central Stores
                                            </option>
                                            <option value="ITG" @if ($data->Initiator_Group == 'ITG') selected @endif>
                                                Information Technology Group
                                            </option>
                                            <option value="MM" @if ($data->Initiator_Group == 'MM') selected @endif>
                                                Molecular Medicine
                                            </option>
                                            <option value="CL" @if ($data->Initiator_Group == 'CL') selected @endif>
                                                Central Laboratory
                                            </option>
                                            <option value="TT" @if ($data->Initiator_Group == 'TT') selected @endif>
                                                Tech Team
                                            </option>
                                            <option value="QA" @if ($data->Initiator_Group == 'QA') selected @endif>
                                                Quality Assurance
                                            </option>
                                            <option value="QM" @if ($data->Initiator_Group == 'QM') selected @endif>
                                                Quality Management
                                            </option>
                                            <option value="IA" @if ($data->Initiator_Group == 'IA') selected @endif>
                                                IT Administration
                                            </option>
                                            <option value="ACC" @if ($data->Initiator_Group == 'ACC') selected @endif>
                                                Accounting
                                            </option>
                                            <option value="LOG" @if ($data->Initiator_Group == 'LOG') selected @endif>
                                                Logistics
                                            </option>
                                            <option value="SM" @if ($data->Initiator_Group == 'SM') selected @endif>
                                                Senior Management
                                            </option>
                                            <option value="BA" @if ($data->Initiator_Group == 'BA') selected @endif>
                                                Business Administration
                                            </option>
                                        </select>
                                    </div>
                                </div>


                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Initiator Group Code">Initiator Group Code</label>
                                        <input type="text" name="initiator_group_code" id="initiator_group_code"
                                            value="{{ $data->initiator_group_code }}" readonly>
                                    </div>
                                </div> -->

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="short_description">Short Description<span class="text-danger">*</span></label>
                                        <span id='rchars' class="text-primary">255<span> characters remaining
                                        <div class="relative-container">
                                            <input id="short_description" value="{{ $data->short_description }}" id="docname" type="text"
                                                class="mic-input" name="short_description" maxlength="255"
                                                required>
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>


                                
                            <div class="col-12">
                                <div class="group-input">
                                    <label style="display: flex; justify-content:space-between" for="audit-agenda-grid">
                                      <div>
                                        Sample Management
                                        <button type="button" id="addSamplePlanning">+</button>
                                      </div>
                                        <div style="display: flex;" class="search-head">
                                            <div>
                                                <input type="text" id="searchInput" name="search_input" placeholder="Search content...">
            
                                            </div>
                                            <div>
                                                <p style="border: 1px solid black;border-radius: 5px; margin-left: 14px;" id="searchButton" class="btn">Search</p>
                                            </div>
                                          </div>
                                    </label>
                                    <script>
                                        $('#searchButton').click(function(e) {
                                          e.preventDefault();
                                          console.log('starting search')
                                          const input = $('input[name=search_input]').val().toLowerCase();
                                          const table = document.querySelector("table");
                                          const rows = table.querySelectorAll("thead tr");
                                          let found = false;
                                      
                                          // Remove previous highlights
                                          table.querySelectorAll(".highlight").forEach(cell => {
                                            cell.classList.remove("highlight");
                                          });
                                      
                                          console.log('rowing search', input)
                                          // Search for the value
                                          for (const row of rows) {
                                            for (const cell of row.cells) {
                                                console.log('cell', cell)
                                                console.log('cell data', cell.textContent.toLowerCase())
                                              if (cell.textContent.toLowerCase().includes(input) && input !== "") {
                                                cell.classList.add("highlight"); // Highlight cell
                                      
                                                if (!found) {
                                                    console.log('first cell found')
                                                  // Scroll to the matching cell
                                                  const container = document.querySelector(".table-container");
                                                  const cellPosition = cell.getBoundingClientRect();
                                                  const containerPosition = container.getBoundingClientRect();
                                      
                                                  // Adjust scroll to bring the cell into view
                                                  container.scrollTop += cellPosition.top - containerPosition.top - 50;
                                                  container.scrollLeft += cellPosition.left - containerPosition.left - 50;
                                      
                                                  found = true;
                                                }
                                              }
                                            }
                                          }
                                      
                                          if (!found && input !== "") {
                                            alert("No matches found!");
                                          }
                                        })
                                        
                                      </script>
                                         
                                    <div class="responsive-table table-container" style="overflow-x: auto; width: 100% !important;">
                                        <table class="table table-bordered" id="editSamplePlanningTable">
                                            <thead>
                                                <tr>
                                                    <th colspan="36" style="background: rgb(0, 191, 255);">Sample Registration</th>
                                                    <th colspan="39" style="background: rgb(255, 102, 102);">Sample Analysis</th>
                                                    <th colspan="10" style="background: rgb(52, 162, 143);">Stability Information</th>
                                                    <th colspan="5" style="background: rgb(255, 232, 91);">Supervisor Review</th>
                                                    <th colspan="9" style="background: rgb(120, 148, 255);">QA Review</th>
                                                </tr>

                                                <tr>
                                                    <th >#</th>
                                                    <th><div style="min-width: 200px;">Sample Plan ID</div></th>
                                                    <th><div style="min-width: 200px;">Sample Plan</div></th>
                                                    <th><div style="min-width: 200px;">Sample Name</div></th>
                                                    <th><div style="min-width: 200px;">Sample Type</div></th>
                                                    <th><div style="min-width: 200px;">Product / Material Name</div></th>
                                                    <th><div style="min-width: 200px;">Product / Material Code</div></th>
                                                    <th><div style="min-width: 100px;">Batch/Lot Number</div></th>
                                                    <th><div style="min-width: 200px;">Sample Priority</div></th>
                                                    <th><div style="min-width: 150px;">Sample Quantity</div></th>
                                                    <th><div style="min-width: 150px;">Quantity Withdrawn</div></th>
                                                    <th><div style="min-width: 150px;">Current Quantity</div></th>
                                                    <th><div style="min-width: 200px;">UOM</div></th>
                                                    <th><div style="min-width: 200px;">Market</div></th>
                                                    <th><div style="min-width: 200px;">Specification ID</div></th>
                                                    <th><div style="min-width: 200px;">Specification Attachment</div></th>
                                                    <th><div style="min-width: 200px;">STP ID</div></th>
                                                    <th><div style="min-width: 200px;">STP Attachment</div></th>
                                                    <th><div style="min-width: 200px;">Test Name</div></th>
                                                    <th><div style="min-width: 200px;">Test Method</div></th>
                                                    <th><div style="min-width: 200px;">Test Parameters</div></th>
                                                    <th><div style="min-width: 200px;">Testing Frequency</div></th>
                                                    <th><div style="min-width: 200px;">Testing Location</div></th>
                                                    <th><div style="min-width: 100px;">LSL</div></th>
                                                    <th><div style="min-width: 100px;">USL</div></th>
                                                    <th><div style="min-width: 200px;">Testing Deadline</div></th>
                                                    <th><div style="min-width: 200px;">Planner Name</div></th>
                                                    <th><div style="min-width: 200px;">Sample Source</div></th>
                                                    <th><div style="min-width: 200px;">Planned Date</div></th>
                                                    <th><div style="min-width: 200px;">Start Date</div></th>
                                                    <th><div style="min-width: 300px;">Delay Justification</div></th>
                                                    <th><div style="min-width: 200px;">Lab Technician</div></th>
                                                    <th><div style="min-width: 200px;">Sample Cost Estimation</div></th>
                                                    <th><div style="min-width: 200px;">Resource Utilization</div></th>
                                                    <th><div style="min-width: 200px;">Sample Collection Date</div></th>
                                                    <th><div style="min-width: 200px;">Supporting Documents</div></th>


                                                    <th><div style="min-width: 200px;">Analysis Type</div></th>
                                                    <th><div style="min-width: 100px;">Result</div></th>
                                                    <th><div style="min-width: 200px;">Analysis Result</div></th>
                                                    <th><div style="min-width: 200px;">Analyst</div></th>
                                                    <th><div style="min-width: 200px;">Reagent</div></th>
                                                    <th><div style="min-width: 200px;">Testing Start Date</div></th>
                                                    <th><div style="min-width: 200px;">Testing End Date</div></th>
                                                    <th><div style="min-width: 100px;">Analysis Status</div></th>
                                                    <th><div style="min-width: 100px;">Pass/Fail</div></th>
                                                    <th><div style="min-width: 300px;">Instruction for Other Analyst</div></th>
                                                    <th><div style="min-width: 100px;">Test Plan Id</div></th>
                                                    <th><div style="min-width: 200px;">Turnaround Time (TAT)</div></th>
                                                    <th><div style="min-width: 200px;">Sample Retesting Date</div></th>
                                                    <th><div style="min-width: 200px;">Review Due Date</div></th>
                                                    <th><div style="min-width: 200px;">Sample Storage Location</div></th>
                                                    <th><div style="min-width: 200px;">Transportation Method</div></th>
                                                    <th><div style="min-width: 300px;">Sample Preparation Method</div></th>
                                                    <th><div style="min-width: 300px;">Sample Packaging Details</div></th>
                                                    <th><div style="min-width: 200px;">Sample Label</div></th>
                                                    <th><div style="min-width: 300px;">Regulatory Requirements</div></th>
                                                    <th><div style="min-width: 200px;">Quality Control Checks</div></th>
                                                    <th><div style="min-width: 200px;">Control Sample Reference</div></th>
                                                    <th><div style="min-width: 200px;">Control Sample</div></th>
                                                    <th><div style="min-width: 200px;">Reference Sample</div></th>
                                                    <th><div style="min-width: 200px;">Sample Integrity Status</div></th>
                                                    <th><div style="min-width: 200px;">Assigned Department</div></th>
                                                    <th><div style="min-width: 200px;">Risk Assessment</div></th>
                                                    <th><div style="min-width: 200px;">Supervisor</div></th>
                                                    <th><div style="min-width: 350px;">Instruments Reserved</div></th>
                                                    <th><div style="min-width: 200px;">Lab Availability</div></th>
                                                    <th><div style="min-width: 200px;">Sample Date</div></th>
                                                    <th><div style="min-width: 200px;">Sample Movement History</div></th>
                                                    <th><div style="min-width: 200px;">Testing Progress</div></th>
                                                    <th><div style="min-width: 200px;">Alerts/Notifications</div></th>
                                                    <th><div style="min-width: 200px;">Deviation Logs</div></th>
                                                    <th><div style="min-width: 200px;">Comments/Notes</div></th>
                                                    <th><div style="min-width: 200px;">Attachment</div></th>
                                                    <th><div style="min-width: 200px;">Sampling Frequency</div></th>
                                                    <th><div style="min-width: 200px;">Stability Study Type</div></th>
                                                    <th><div style="min-width: 200px;">Supporting Documents</div></th>

                                                    <!-- Stability Review -->
                                                    <th><div style="min-width: 200px;">Stability Status</div></th>
                                                    <th><div style="min-width: 200px;">Stability Study Protocol</div></th>
                                                    <th><div style="min-width: 200px;">Stability Protocol Approval Date</div></th>
                                                    <th><div style="min-width: 200px;">Country of Regulatory Submissions</div></th>
                                                    <th><div style="min-width: 200px;">ICH Zone</div></th>
                                                    <th><div style="min-width: 200px;">Photostability Testing Results</div></th>
                                                    <th><div style="min-width: 200px;">Reconstitution Stability</div></th>
                                                    <th><div style="min-width: 200px;">Testing Interval (Months)</div></th>
                                                    <th><div style="min-width: 200px;">Shelf Life Recommendation</div></th>
                                                    <th><div style="min-width: 200px;">Stability Attachment</div></th>


                                                    <!-- Supervisor Review -->
                                                    <th><div style="min-width: 200px;">Reviewer/Approver</div></th>
                                                    <th><div style="min-width: 200px;">Sample Desposion</div></th>
                                                    <th><div style="min-width: 300px;">Reviewer Comment</div></th>
                                                    <th><div style="min-width: 200px;">Review Date</div></th>
                                                    <th><div style="min-width: 200px;">Supervisor Attachment</div></th>


                                                    <!-- QA Review -->
                                                    <th><div style="min-width: 200px;">QA Reviewer/Approver</div></th>
                                                    <th><div style="min-width: 300px;">QA Reviewer Comment</div></th>
                                                    <th><div style="min-width: 200px;">QA Review Date</div></th>
                                                    <th><div style="min-width: 200px;">QA Attachment</div></th>

                                                    <th><div style="min-width: 200px;">Destruction Due On</div></th>
                                                    <th><div style="min-width: 200px;">Destruction Date</div></th>
                                                    <th><div style="min-width: 200px;">Destricted By</div></th>
                                                    <th><div style="min-width: 300px;">Remarks</div></th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(!empty($planningGrid) && is_array($planningGrid->data))
                                                    @foreach ($planningGrid->data as $key => $row)
                                                    @php
                                                        $selectedInstruments = isset($row['instrumentReserved']) ? explode(',', $row['instrumentReserved']) : [];
                                                        $selectedLabTechnician = isset($row['labTechnician']) ? explode(',', $row['labTechnician']) : [];
                                                        $selectedanalyst = isset($row['analyst']) ? explode(',', $row['analyst']) : [];
                                                        $selectedReagent = isset($row['reagent']) ? explode(',', $row['reagent']) : [];
                                                    @endphp 
                                                        <tr>
                                                            <td class="row-index">{{ $key + 1 }}</td>
                                                            <td><input type="number" name="samplePlanningData[{{ $key }}][samplePlanId]" value="{{ $row['samplePlanId'] }}" readonly></td>
                                                            <td><input type="text" name="samplePlanningData[{{ $key }}][samplePlan]" value="{{ $row['samplePlan'] }}"></td>
                                                            <td><input type="text" name="samplePlanningData[{{ $key }}][samplePlanName]" value="{{ $row['samplePlanName'] }}"></td>
                                                            <td><input type="text" name="samplePlanningData[{{ $key }}][sampleType]" value="{{ $row['sampleType'] }}"></td>
                                                            <td><input type="text" name="samplePlanningData[{{ $key }}][productmaterial]" value="{{ $row['productmaterial'] }}"></td>
                                                            <td><input type="text" name="samplePlanningData[{{ $key }}][productmaterialCode]" value="{{ $row['productmaterialCode'] }}"></td>
                                                            <td><input type="text" name="samplePlanningData[{{ $key }}][batchNumber]" value="{{ $row['batchNumber'] }}"></td>
                                                            <td>
                                                                <select name="samplePlanningData[{{ $key }}][samplePriority]">
                                                                    <option {{ $row['samplePriority'] == 'Select Value' ? 'selected' : '' }}>Select Value</option>
                                                                    <option {{ $row['samplePriority'] == 'High' ? 'selected' : '' }} value="High">High</option>
                                                                    <option {{ $row['samplePriority'] == 'Medium' ? 'selected' : '' }} value="Medium">Medium</option>
                                                                    <option {{ $row['samplePriority'] == 'Low' ? 'selected' : '' }} value="Low">Low</option>
                                                                </select>
                                                            </td>
                                                            <td><input type="text" name="samplePlanningData[{{ $key }}][sampleQuantity]" value="{{ $row['sampleQuantity'] }}" class="sampleQuantity"></td>
                                                            <td><input type="text" name="samplePlanningData[{{ $key }}][quantityWithdrawn]" value="{{ $row['quantityWithdrawn'] }}" class="quantityWithdrawn"></td>
                                                            <td><input type="text" name="samplePlanningData[{{ $key }}][currentQuantity]" value="{{ $row['currentQuantity'] }}" class="currentQuantity"></td>
                                                            <td>
                                                                <select name="samplePlanningData[{{ $key }}][UOM]">
                                                                    <option {{ $row['UOM'] == 'Select Value' ? 'selected' : '' }}>Select Value</option>
                                                                    <option {{ $row['UOM'] == 'Pieces' ? 'selected' : '' }} value="Pieces">Pieces</option>
                                                                    <option {{ $row['UOM'] == 'Kilograms' ? 'selected' : '' }} value="Kilograms">Kilograms</option>
                                                                    <option {{ $row['UOM'] == 'Liters' ? 'selected' : '' }} value="Liters">Liters</option>
                                                                    <option {{ $row['UOM'] == 'Meters' ? 'selected' : '' }} value="Meters">Meters</option>
                                                                    <option {{ $row['UOM'] == 'Cubic Meters' ? 'selected' : '' }} value="Cubic Meters">Cubic Meters</option>
                                                                    <option {{ $row['UOM'] == 'Grams' ? 'selected' : '' }} value="Grams">Grams</option>
                                                                    <option {{ $row['UOM'] == 'Milliliters' ? 'selected' : '' }} value="Milliliters">Milliliters</option>
                                                                    <option {{ $row['UOM'] == 'Dozens' ? 'selected' : '' }} value="Dozens">Dozens</option>
                                                                    <option {{ $row['UOM'] == 'Percent' ? 'selected' : '' }} value="Percent">Percent</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="samplePlanningData[{{ $key }}][market]">
                                                                    <option value="">Select a country</option>
                                                                    <option value="Afghanistan" {{ $row['market'] == 'Afghanistan' ? 'selected' : '' }}>Afghanistan</option>
                                                                    <option value="Albania" {{ $row['market'] == 'Albania' ? 'selected' : '' }}>Albania</option>
                                                                    <option value="Algeria" {{ $row['market'] == 'Algeria' ? 'selected' : '' }}>Algeria</option>
                                                                    <option value="American Samoa" {{ $row['market'] == 'American Samoa' ? 'selected' : '' }}>American Samoa</option>
                                                                    <option value="Andorra" {{ $row['market'] == 'Andorra' ? 'selected' : '' }}>Andorra</option>
                                                                    <option value="Angola" {{ $row['market'] == 'Angola' ? 'selected' : '' }}>Angola</option>
                                                                    <option value="Argentina" {{ $row['market'] == 'Argentina' ? 'selected' : '' }}>Argentina</option>
                                                                    <option value="Armenia" {{ $row['market'] == 'Armenia' ? 'selected' : '' }}>Armenia</option>
                                                                    <option value="Australia" {{ $row['market'] == 'Australia' ? 'selected' : '' }}>Australia</option>
                                                                    <option value="Austria" {{ $row['market'] == 'Austria' ? 'selected' : '' }}>Austria</option>
                                                                    <option value="Bahrain" {{ $row['market'] == 'Bahrain' ? 'selected' : '' }}>Bahrain</option>
                                                                    <option value="Bangladesh" {{ $row['market'] == 'Bangladesh' ? 'selected' : '' }}>Bangladesh</option>
                                                                    <option value="Barbados" {{ $row['market'] == 'Barbados' ? 'selected' : '' }}>Barbados</option>
                                                                    <option value="Belarus" {{ $row['market'] == 'Belarus' ? 'selected' : '' }}>Belarus</option>
                                                                    <option value="Belgium" {{ $row['market'] == 'Belgium' ? 'selected' : '' }}>Belgium</option>
                                                                    <option value="Belize" {{ $row['market'] == 'Belize' ? 'selected' : '' }}>Belize</option>
                                                                    <option value="Benin" {{ $row['market'] == 'Benin' ? 'selected' : '' }}>Benin</option>
                                                                    <option value="Bhutan" {{ $row['market'] == 'Bhutan' ? 'selected' : '' }}>Bhutan</option>
                                                                    <option value="Bolivia" {{ $row['market'] == 'Bolivia' ? 'selected' : '' }}>Bolivia</option>
                                                                    <option value="Botswana" {{ $row['market'] == 'Botswana' ? 'selected' : '' }}>Botswana</option>
                                                                    <option value="Brazil" {{ $row['market'] == 'Brazil' ? 'selected' : '' }}>Brazil</option>
                                                                    <option value="Bulgaria" {{ $row['market'] == 'Bulgaria' ? 'selected' : '' }}>Bulgaria</option>
                                                                    <option value="Colombia" {{ $row['market'] == 'Colombia' ? 'selected' : '' }}>Colombia</option>
                                                                    <option value="Croatia" {{ $row['market'] == 'Croatia' ? 'selected' : '' }}>Croatia</option>
                                                                    <option value="Czech Republic" {{ $row['market'] == 'Czech Republic' ? 'selected' : '' }}>Czech Republic</option>
                                                                    <option value="Denmark" {{ $row['market'] == 'Denmark' ? 'selected' : '' }}>Denmark</option>
                                                                    <option value="Canada" {{ $row['market'] == 'Canada' ? 'selected' : '' }}>Canada</option>
                                                                    <option value="Egypt" {{ $row['market'] == 'Egypt' ? 'selected' : '' }}>Egypt</option>
                                                                    <option value="Finland" {{ $row['market'] == 'Finland' ? 'selected' : '' }}>Finland</option>
                                                                    <option value="France" {{ $row['market'] == 'France' ? 'selected' : '' }}>France</option>
                                                                    <option value="Germany" {{ $row['market'] == 'Germany' ? 'selected' : '' }}>Germany</option>
                                                                    <option value="India" {{ $row['market'] == 'India' ? 'selected' : '' }}>India</option>
                                                                    <option value="Italy" {{ $row['market'] == 'Italy' ? 'selected' : '' }}>Italy</option>
                                                                    <option value="Japan" {{ $row['market'] == 'Japan' ? 'selected' : '' }}>Japan</option>
                                                                    <option value="Mexico" {{ $row['market'] == 'Mexico' ? 'selected' : '' }}>Mexico</option>
                                                                    <option value="Netherlands" {{ $row['market'] == 'Netherlands' ? 'selected' : '' }}>Netherlands</option>
                                                                    <option value="New Zealand" {{ $row['market'] == 'New Zealand' ? 'selected' : '' }}>New Zealand</option>
                                                                    <option value="Nigeria" {{ $row['market'] == 'Nigeria' ? 'selected' : '' }}>Nigeria</option>
                                                                    <option value="Pakistan" {{ $row['market'] == 'Pakistan' ? 'selected' : '' }}>Pakistan</option>
                                                                    <option value="Poland" {{ $row['market'] == 'Poland' ? 'selected' : '' }}>Poland</option>
                                                                    <option value="Russia" {{ $row['market'] == 'Russia' ? 'selected' : '' }}>Russia</option>
                                                                    <option value="Saudi Arabia" {{ $row['market'] == 'Saudi Arabia' ? 'selected' : '' }}>Saudi Arabia</option>
                                                                    <option value="Spain" {{ $row['market'] == 'Spain' ? 'selected' : '' }}>Spain</option>
                                                                    <option value="Sweden" {{ $row['market'] == 'Sweden' ? 'selected' : '' }}>Sweden</option>
                                                                    <option value="Switzerland" {{ $row['market'] == 'Switzerland' ? 'selected' : '' }}>Switzerland</option>
                                                                    <option value="Turkey" {{ $row['market'] == 'Turkey' ? 'selected' : '' }}>Turkey</option>
                                                                    <option value="United Kingdom" {{ $row['market'] == 'United Kingdom' ? 'selected' : '' }}>United Kingdom</option>
                                                                    <option value="United States" {{ $row['market'] == 'United States' ? 'selected' : '' }}>United States</option>
                                                                </select>
                                                            </td>
                                                            <td><input type="text" name="samplePlanningData[{{ $key }}][specificationId]" value="{{ $row['specificationId'] }}"></td>
                                                            <td>
                                                                <input type="file" name="samplePlanningData[{{ $key }}][specificationAttach]">
                                                                @if(!empty($row['specificationAttach_path']))
                                                                    <a style="color: blue; font-weight: bold; margin-top: 10px;" href="{{ asset($row['specificationAttach_path']) }}" target="_blank">{{ basename($row['specificationAttach_path']) }}</a>
                                                                    <input type="hidden" name="samplePlanningData[{{ $key }}][specificationAttach_path]" value="{{ $row['specificationAttach_path'] }}">
                                                                @endif
                                                            </td>
                                                            <td><input type="text" name="samplePlanningData[{{ $key }}][STPId]" value="{{ $row['STPId'] }}"></td>
                                                            <td>
                                                                <input type="file" name="samplePlanningData[{{ $key }}][STPAttach]">
                                                                @if(!empty($row['STPAttach_path']))
                                                                    <a style="color: blue; font-weight: bold; margin-top: 10px;" href="{{ asset($row['STPAttach_path']) }}" target="_blank">{{ basename($row['STPAttach_path']) }}</a>
                                                                    <input type="hidden" name="samplePlanningData[{{ $key }}][STPAttach_path]" value="{{ $row['STPAttach_path'] }}">
                                                                @endif
                                                            </td>
                                                            <td><input type="text" name="samplePlanningData[{{ $key }}][testName]" value="{{ $row['testName'] }}"></td>
                                                            <td><input type="text" name="samplePlanningData[{{ $key }}][testMethod]" value="{{ $row['testMethod'] }}"></td>
                                                            <td><input type="text" name="samplePlanningData[{{ $key }}][testParameter]" value="{{ $row['testParameter'] }}"></td>
                                                            <td><input type="text" name="samplePlanningData[{{ $key }}][testingFrequency]" value="{{ $row['testingFrequency'] }}"></td>
                                                            <td>
                                                                <select name="samplePlanningData[{{ $key }}][testingLocation]">
                                                                    <option value="">Select Location</option>
                                                                    @if(!empty($locations))
                                                                        @foreach($locations as $location)
                                                                            <option @if($row['testingLocation'] == $location->id) selected @endif value="{{ $location->id }}">{{ $location->name }}</option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                            </td>
                                                            <td><input type="number" name="samplePlanningData[{{ $key }}][LSL]" value="{{ $row['LSL'] }}" class="lsl-field" id="lsl_{{ $key }}" oninput="validateEditInput({{ $key }})"></td>
                                                            <td><input type="number" name="samplePlanningData[{{ $key }}][USL]" value="{{ $row['USL'] }}" class="usl-field" id="usl_{{ $key }}" oninput="validateEditInput({{ $key }})"></td>

                                                            <td>
                                                                <div class="col-md-6 new-date-data-field">
                                                                    <div class="group-input input-date">
                                                                        <div class="calenderauditee">
                                                                            <input type="text" id="testingDeadline" readonly placeholder="DD-MMM-YYYY" value="{{ Helpers::getdateFormat($row['testingDeadline']) }}" />
                                                                            <input type="date" name="samplePlanningData[{{ $key }}][testingDeadline]"
                                                                                min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                                                                value="{{ $row['testingDeadline'] }}"
                                                                                class="hide-input" oninput="handleDateInput(this, 'testingDeadline')" />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>

                                                            <td><input type="text" name="samplePlanningData[{{ $key }}][plannerName]" value="{{ $row['plannerName'] }}"></td>
                                                            <td><input type="text" name="samplePlanningData[{{ $key }}][sampleSource]" value="{{ $row['sampleSource'] }}"></td>
                                                            <td>
                                                                <div class="col-md-6 new-date-data-field">
                                                                    <div class="group-input input-date">
                                                                        <div class="calenderauditee">
                                                                            <input type="text" id="plannedDate" readonly placeholder="DD-MMM-YYYY" value="{{ Helpers::getdateFormat($row['plannedDate']) }}" />
                                                                            <input type="date" name="samplePlanningData[{{ $key }}][plannedDate]"
                                                                                min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                                                                value="{{ $row['plannedDate'] }}"
                                                                                class="hide-input" oninput="handleDateInput(this, 'plannedDate')" />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="col-md-6 new-date-data-field">
                                                                    <div class="group-input input-date">
                                                                        <div class="calenderauditee">
                                                                            <input type="text" id="startDate" readonly placeholder="DD-MMM-YYYY" value="{{ Helpers::getdateFormat($row['startDate']) }}" />
                                                                            <input type="date" name="samplePlanningData[{{ $key }}][startDate]"
                                                                                min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                                                                value="{{ $row['startDate'] }}"
                                                                                class="hide-input" oninput="handleDateInput(this, 'startDate')" />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <textarea name="samplePlanningData[{{ $key }}][delayJustification]">{{ $row['delayJustification'] }}</textarea>
                                                            </td>
                                                            <td>
                                                                <select name="samplePlanningData[{{ $key }}][labTechnician]" multiple id="labTechnicians">
                                                                    @if(!empty($analystData))
                                                                        @foreach($analystData as $item)
                                                                            <option {{ in_array($item->userId, $selectedLabTechnician) ? 'selected' : '' }} value="{{ $item->userId }}">{{ $item->userName }}</option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                            </td>
                                                            <td><input type="text" name="samplePlanningData[{{ $key }}][sampleCostEstimation]" value="{{ $row['sampleCostEstimation'] }}"></td>
                                                            <td><input type="text" name="samplePlanningData[{{ $key }}][resourceUtilization]" value="{{ $row['resourceUtilization'] }}"></td>
                                                            <td>
                                                                <div class="col-md-6 new-date-data-field">
                                                                    <div class="group-input input-date">
                                                                        <div class="calenderauditee">
                                                                            <input type="text" id="sampleCollectionDate" readonly placeholder="DD-MMM-YYYY" value="{{ Helpers::getdateFormat($row['sampleCollectionDate']) }}"/>
                                                                            <input type="date" name="samplePlanningData[{{ $key }}][sampleCollectionDate]"
                                                                                min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                                                                value="{{ $row['sampleCollectionDate'] }}"
                                                                                class="hide-input" oninput="handleDateInput(this, 'sampleCollectionDate')" />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <input type="file" name="samplePlanningData[{{ $key }}][supportingDocumentGI]">
                                                                @if(!empty($row['supportingDocumentGI_path']))
                                                                    <a style="color: blue; font-weight: bold; margin-top: 10px;" href="{{ asset($row['supportingDocumentGI_path']) }}" target="_blank">{{ basename($row['supportingDocumentGI_path']) }}</a>
                                                                    <input type="hidden" name="samplePlanningData[{{ $key }}][supportingDocumentGI_path]" value="{{ $row['supportingDocumentGI_path'] }}">
                                                                @endif
                                                            </td>

                                                            <td><input type="text" name="samplePlanningData[{{ $key }}][analysisType]" value="{{ $row['analysisType'] }}"></td>
                                                            <td><input type="number" name="samplePlanningData[{{ $key }}][results]" value="{{ $row['results'] }}"  class="results-field" id="results_{{ $key }}" oninput="validateEditInput({{ $key }})"></td>
                                                            <td><input type="text" name="samplePlanningData[{{ $key }}][analysisResult]" value="{{ $row['analysisResult'] }}" id="analysisresults_{{ $key }}" oninput="validateEditInput({{ $key }})" readonly></td>
                                                            <script>
                                                                function validateEditInput(rowIndex) {
                                                                    var lsl = parseFloat(document.getElementById('lsl_' + rowIndex).value);
                                                                    var usl = parseFloat(document.getElementById('usl_' + rowIndex).value);
                                                                    var resultField = document.getElementById('results_' + rowIndex);
                                                                    var analysisresults = document.getElementById('analysisresults_' + rowIndex);
                                                                    var result = parseFloat(resultField.value);

                                                                    if (event && event.target && event.target.id === 'results_' + rowIndex) {
                                                                        if (isNaN(lsl) || isNaN(usl) || isNaN(result)) {
                                                                            resultField.style.borderColor = '';
                                                                            resultField.style.color = '';
                                                                            analysisresults.style.backgroundColor = '';
                                                                            return;
                                                                        }

                                                                        if (result >= lsl && result <= usl) {
                                                                            resultField.style.borderColor = 'green';
                                                                            resultField.style.color = 'green';
                                                                            analysisresults.style.backgroundColor = 'green';
                                                                        } else {
                                                                            resultField.style.borderColor = 'red';
                                                                            resultField.style.color = 'red';
                                                                            analysisresults.style.backgroundColor = 'red';
                                                                        }
                                                                    } else {
                                                                        if (!isNaN(lsl) && !isNaN(usl) && !isNaN(result)) {
                                                                            if (result >= lsl && result <= usl) {
                                                                                resultField.style.borderColor = 'green';
                                                                                resultField.style.color = 'green';
                                                                                analysisresults.style.backgroundColor = 'green';
                                                                            } else {
                                                                                resultField.style.borderColor = 'red';
                                                                                resultField.style.color = 'red';
                                                                                analysisresults.style.backgroundColor ='red';
                                                                            }
                                                                        }
                                                                    }
                                                                }

                                                                document.querySelectorAll('.results-field').forEach(function(field) {
                                                                    field.addEventListener('input', validateEditInput);
                                                                });

                                                                window.addEventListener('load', function() {
                                                                    document.querySelectorAll('.results-field').forEach(function(field) {
                                                                        validateEditInput({ rowIndex: field.id.split('_')[1] });
                                                                    });
                                                                });
                                                            </script>

                                                            <!-- <td>
                                                                <div class="col-md-6 new-date-data-field">
                                                                    <div class="group-input input-date">
                                                                        <div class="calenderauditee">
                                                                            <input type="text" id="testingStartDate" readonly placeholder="DD-MMM-YYYY" value="{{ Helpers::getdateFormat($row['testingStartDate']) }}"/>
                                                                            <input type="date" name="samplePlanningData[{{ $key }}][testingStartDate]"
                                                                                min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                                                                value="{{ $row['testingStartDate'] }}"
                                                                                class="hide-input" oninput="handleDateInput(this, 'testingStartDate')" />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td> -->

                                                            <td>
                                                                <select name="samplePlanningData[{{ $key }}][analyst]" multiple id="analystData">
                                                                    @if(!empty($analystData))
                                                                        @foreach($analystData as $item)
                                                                            <option {{ in_array($item->userId, $selectedanalyst) ? 'selected' : '' }} value="{{ $item->userId }}">{{ $item->userName }}</option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select multiple name="samplePlanningData[0][reagent]" id="reagentData">
                                                                    @if(!empty($filteredData))
                                                                        @foreach($filteredData as $item)
                                                                            <option {{ in_array($item['name'], $selectedReagent) ? 'selected' : '' }} value="{{ $item['name'] }}">{{ $item['name'] }}</option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <div class="col-md-6 new-date-data-field">
                                                                    <div class="group-input input-date">
                                                                        <div class="calenderauditee">
                                                                            <input style="width: 150px;" type="text" id="testingStartDate" readonly placeholder="DD-MMM-YYYY HH:mm" 
                                                                                value="{{ Helpers::formatDateTime($row['testingStartDate'], 'd-M-Y H:i') }}" />

                                                                            <input type="datetime-local" name="samplePlanningData[{{ $key }}][testingStartDate]"
                                                                                min="{{ \Carbon\Carbon::now()->format('Y-m-d\TH:i') }}"
                                                                                class="hide-input" oninput="handleDateInput(this, 'testingStartDate')" />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="col-md-6 new-date-data-field">
                                                                    <div class="group-input input-date">
                                                                        <div class="calenderauditee">
                                                                            <input style="width: 150px;" type="text" id="testingEndDate" readonly placeholder="DD-MMM-YYYY HH:mm" 
                                                                                value="{{ Helpers::formatDateTime($row['testingEndDate'], 'd-M-Y H:i') }}" />

                                                                            <input type="datetime-local" name="samplePlanningData[{{ $key }}][testingEndDate]"
                                                                                min="{{ \Carbon\Carbon::now()->format('Y-m-d\TH:i') }}"
                                                                                class="hide-input" oninput="handleDateInput(this, 'testingEndDate')" />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>

                                                            <td>
                                                                <select name="samplePlanningData[{{ $key }}][analysisStatus]">
                                                                    <option {{ $row['analysisStatus'] == 'Select Value' ? 'selected' : '' }}>Select Value</option>
                                                                    <option value="Not Yet Started" {{ $row['analysisStatus'] == 'Not Yet Started' ? 'selected' : '' }}>Not Yet Started</option>
                                                                    <option value="Started" {{ $row['analysisStatus'] == 'Started' ? 'selected' : '' }}>Started</option>
                                                                    <option value="Completed" {{ $row['analysisStatus'] == 'Completed' ? 'selected' : '' }}>Completed</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="samplePlanningData[{{ $key }}][passFail]">
                                                                    <option {{ $row['passFail'] == 'Select Value' ? 'selected' : '' }}>Select Value</option>
                                                                    <option value="Pass" {{ $row['passFail'] == 'Pass' ? 'selected' : '' }}>Pass</option>
                                                                    <option value="Fail" {{ $row['passFail'] == 'Fail' ? 'selected' : '' }}>Fail</option>
                                                                    <option value="Not Yet" {{ $row['passFail'] == 'Not Yet' ? 'selected' : '' }}>Not Yet</option>
                                                                    <option value="Under Investigation" {{ $row['passFail'] == 'Under Investigation' ? 'selected' : '' }}>Under Investigation</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <textarea name="samplePlanningData[{{ $key }}][analystInstruction]" value="{{ $row['analystInstruction'] }}">{{ $row['analystInstruction'] }}</textarea>
                                                            </td>
                                                            <td><input type="number" name="samplePlanningData[{{ $key }}][testPlanId]" value="{{ $row['testPlanId'] }}"></td>
                                                            <td><input type="text" name="samplePlanningData[{{ $key }}][turaroundTime]" value="{{ $row['turaroundTime'] }}"></td>
                                                            <td>
                                                                <div class="col-md-6 new-date-data-field">
                                                                    <div class="group-input input-date">
                                                                        <div class="calenderauditee">
                                                                            <input type="text" id="sampleRetestingDate" readonly placeholder="DD-MMM-YYYY" value="{{ Helpers::getdateFormat($row['sampleRetestingDate']) }}"/>
                                                                            <input type="date" name="samplePlanningData[{{ $key }}][sampleRetestingDate]"
                                                                                min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                                                                value="{{ $row['sampleRetestingDate'] }}"
                                                                                class="hide-input" oninput="handleDateInput(this, 'sampleRetestingDate')" />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="col-md-6 new-date-data-field">
                                                                    <div class="group-input input-date">
                                                                        <div class="calenderauditee">
                                                                            <input type="text" id="reviewDate" readonly placeholder="DD-MMM-YYYY" value="{{ Helpers::getdateFormat($row['reviewDate']) }}"/>
                                                                            <input type="date" name="samplePlanningData[{{ $key }}][reviewDate]"
                                                                                min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                                                                value="{{ $row['reviewDate'] }}"
                                                                                class="hide-input" oninput="handleDateInput(this, 'reviewDate')" />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <select name="samplePlanningData[{{ $key }}][sampleStorageLocation]">
                                                                    <option value="">Select Location</option>
                                                                    @if(!empty($locations))
                                                                        @foreach($locations as $location)
                                                                            <option @if($row['sampleStorageLocation'] == $location->id) selected @endif value="{{ $location->id }}">{{ $location->name }}</option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                            </td>
                                                            <td><input type="text" name="samplePlanningData[{{ $key }}][transportationMethod]" value="{{ $row['transportationMethod'] }}"></td>
                                                            <td>
                                                                <textarea name="samplePlanningData[{{ $key }}][samplePreprationMethod]" value="{{ $row['samplePreprationMethod'] }}">{{ $row['samplePreprationMethod'] }}</textarea>
                                                            </td>
                                                            <td>
                                                                <textarea type="text" name="samplePlanningData[{{ $key }}][samplePackagingDetail]" value="{{ $row['samplePackagingDetail'] }}">{{ $row['samplePackagingDetail'] }}</textarea>
                                                            </td>
                                                            <td><input type="text" name="samplePlanningData[{{ $key }}][sampleLabel]" value="{{ $row['sampleLabel'] }}"></td>
                                                            <td>
                                                                <textarea name="samplePlanningData[{{ $key }}][regulatoryRequirement]" value="{{ $row['regulatoryRequirement'] }}">{{ $row['regulatoryRequirement'] }}</textarea>
                                                            </td>
                                                            <td><input type="text" name="samplePlanningData[{{ $key }}][qualityControlCheck]" value="{{ $row['qualityControlCheck'] }}"></td>
                                                            <td><input type="text" name="samplePlanningData[{{ $key }}][controlSamplePreference]" value="{{ $row['controlSamplePreference'] }}"></td>
                                                            <td><input type="text" name="samplePlanningData[{{ $key }}][controlSample]" value="{{ $row['controlSample'] }}"></td>
                                                            <td><input type="text" name="samplePlanningData[{{ $key }}][referenceSample]" value="{{ $row['referenceSample'] }}"></td>
                                                            <td><input type="text" name="samplePlanningData[{{ $key }}][sampleIntegrityStatus]" value="{{ $row['sampleIntegrityStatus'] }}"></td>
                                                            <td>
                                                                <select name="samplePlanningData[{{ $key }}][assignedDepartment]">
                                                                    <option {{ $row['assignedDepartment'] == 'Select Value' ? 'selected' : '' }}>Select Value</option>
                                                                    <option {{ $row['assignedDepartment'] == 'CQA' ? 'selected' : '' }} value="CQA">Corporate Quality Assurance</option>
                                                                    <option {{ $row['assignedDepartment'] == 'QAB' ? 'selected' : '' }} value="QAB">Quality Assurance Biopharma</option>
                                                                    <option {{ $row['assignedDepartment'] == 'CQC' ? 'selected' : '' }} value="CQC">Central Quality Control</option>
                                                                    <option {{ $row['assignedDepartment'] == 'MANU' ? 'selected' : '' }} value="MANU">Manufacturing</option>
                                                                    <option {{ $row['assignedDepartment'] == 'PSG' ? 'selected' : '' }} value="PSG">Plasma Sourcing Group</option>
                                                                    <option {{ $row['assignedDepartment'] == 'CS' ? 'selected' : '' }} value="CS">Central Stores</option>
                                                                    <option {{ $row['assignedDepartment'] == 'ITG' ? 'selected' : '' }} value="ITG">Information Technology Group</option>
                                                                    <option {{ $row['assignedDepartment'] == 'MM' ? 'selected' : '' }} value="MM">Molecular Medicine</option>
                                                                    <option {{ $row['assignedDepartment'] == 'CL' ? 'selected' : '' }} value="CL">Central Laboratory</option>
                                                                    <option {{ $row['assignedDepartment'] == 'TT' ? 'selected' : '' }} value="TT">Tech Team</option>
                                                                    <option {{ $row['assignedDepartment'] == 'QA' ? 'selected' : '' }} value="QA">Quality Assurance</option>
                                                                    <option {{ $row['assignedDepartment'] == 'QM' ? 'selected' : '' }} value="QM">Quality Management</option>
                                                                    <option {{ $row['assignedDepartment'] == 'IA' ? 'selected' : '' }} value="IA">IT Administration</option>
                                                                    <option {{ $row['assignedDepartment'] == 'ACC' ? 'selected' : '' }} value="ACC">Accounting</option>
                                                                    <option {{ $row['assignedDepartment'] == 'LOG' ? 'selected' : '' }} value="LOG">Logistics</option>
                                                                    <option {{ $row['assignedDepartment'] == 'SM' ? 'selected' : '' }} value="SM">Senior Management</option>
                                                                    <option {{ $row['assignedDepartment'] == 'BA' ? 'selected' : '' }} value="BA">Business Administration</option>
                                                                </select>
                                                            </td>
                                                            <td><input type="text" name="samplePlanningData[{{ $key }}][riskAssessment]" value="{{ $row['riskAssessment'] }}"></td>
                                                            <td><input type="text" name="samplePlanningData[{{ $key }}][supervisor]" value="{{ $row['supervisor'] }}"></td>
                                                            <td>
                                                                <select name="samplePlanningData[{{ $key }}][instrumentReserved]" multiple id="instrumentReserved_{{ $key }}" class="instrument-select">
                                                                    <option value="High-Performance Liquid Chromatography (HPLC)" @if(in_array('High-Performance Liquid Chromatography (HPLC)', $selectedInstruments)) selected @endif>High-Performance Liquid Chromatography (HPLC)</option>
                                                                    <option value="Gas Chromatography (GC)" @if(in_array('Gas Chromatography (GC)', $selectedInstruments)) selected @endif>Gas Chromatography (GC)</option>
                                                                    <option value="Thin-Layer Chromatography (TLC)" @if(in_array('Thin-Layer Chromatography (TLC)', $selectedInstruments)) selected @endif>Thin-Layer Chromatography (TLC)</option>
                                                                    <option value="Ultra-Performance Liquid Chromatography (UPLC)" @if(in_array('Ultra-Performance Liquid Chromatography (UPLC)', $selectedInstruments)) selected @endif>Ultra-Performance Liquid Chromatography (UPLC)</option>
                                                                    <option value="Ion Chromatography" @if(in_array('Ion Chromatography', $selectedInstruments)) selected @endif>Ion Chromatography</option>
                                                                    <option value="Ultraviolet-Visible Spectrophotometer (UV-Vis)" @if(in_array('Ultraviolet-Visible Spectrophotometer (UV-Vis)', $selectedInstruments)) selected @endif>Ultraviolet-Visible Spectrophotometer (UV-Vis)</option>
                                                                    <option value="Infrared Spectrophotometer (IR)" @if(in_array('Infrared Spectrophotometer (IR)', $selectedInstruments)) selected @endif>Infrared Spectrophotometer (IR)</option>
                                                                    <option value="Fourier-Transform Infrared Spectroscopy (FTIR)" @if(in_array('Fourier-Transform Infrared Spectroscopy (FTIR)', $selectedInstruments)) selected @endif>Fourier-Transform Infrared Spectroscopy (FTIR)</option>
                                                                    <option value="Nuclear Magnetic Resonance Spectroscopy (NMR)" @if(in_array('Nuclear Magnetic Resonance Spectroscopy (NMR)', $selectedInstruments)) selected @endif>Nuclear Magnetic Resonance Spectroscopy (NMR)</option>
                                                                    <option value="Mass Spectrometer (MS)" @if(in_array('Mass Spectrometer (MS)', $selectedInstruments)) selected @endif>Mass Spectrometer (MS)</option>
                                                                    <option value="Raman Spectrometer" @if(in_array('Raman Spectrometer', $selectedInstruments)) selected @endif>Raman Spectrometer</option>
                                                                    <option value="Optical Microscope" @if(in_array('Optical Microscope', $selectedInstruments)) selected @endif>Optical Microscope</option>
                                                                    <option value="Scanning Electron Microscope (SEM)" @if(in_array('Scanning Electron Microscope (SEM)', $selectedInstruments)) selected @endif>Scanning Electron Microscope (SEM)</option>
                                                                    <option value="Transmission Electron Microscope (TEM)" @if(in_array('Transmission Electron Microscope (TEM)', $selectedInstruments)) selected @endif>Transmission Electron Microscope (TEM)</option>
                                                                    <option value="Particle Size Analyzer" @if(in_array('Particle Size Analyzer', $selectedInstruments)) selected @endif>Particle Size Analyzer</option>
                                                                    <option value="Differential Scanning Calorimeter (DSC)" @if(in_array('Differential Scanning Calorimeter (DSC)', $selectedInstruments)) selected @endif>Differential Scanning Calorimeter (DSC)</option>
                                                                    <option value="Thermogravimetric Analyzer (TGA)" @if(in_array('Thermogravimetric Analyzer (TGA)', $selectedInstruments)) selected @endif>Thermogravimetric Analyzer (TGA)</option>
                                                                    <option value="pH Meter" @if(in_array('pH Meter', $selectedInstruments)) selected @endif>pH Meter</option>
                                                                    <option value="Conductivity Meter" @if(in_array('Conductivity Meter', $selectedInstruments)) selected @endif>Conductivity Meter</option>
                                                                    <option value="Karl Fischer Titrator" @if(in_array('Karl Fischer Titrator', $selectedInstruments)) selected @endif>Karl Fischer Titrator</option>
                                                                    <option value="Potentiometer" @if(in_array('Potentiometer', $selectedInstruments)) selected @endif>Potentiometer</option>
                                                                    <option value="Polarimeter" @if(in_array('Polarimeter', $selectedInstruments)) selected @endif>Polarimeter</option>
                                                                    <option value="Dissolution Tester" @if(in_array('Dissolution Tester', $selectedInstruments)) selected @endif>Dissolution Tester</option>
                                                                    <option value="Disintegration Tester" @if(in_array('Disintegration Tester', $selectedInstruments)) selected @endif>Disintegration Tester</option>
                                                                    <option value="Tablet Hardness Tester" @if(in_array('Tablet Hardness Tester', $selectedInstruments)) selected @endif>Tablet Hardness Tester</option>
                                                                    <option value="Friability Tester" @if(in_array('Friability Tester', $selectedInstruments)) selected @endif>Friability Tester</option>
                                                                    <option value="Moisture Analyzer" @if(in_array('Moisture Analyzer', $selectedInstruments)) selected @endif>Moisture Analyzer</option>
                                                                    <option value="X-Ray Diffraction (XRD)" @if(in_array('X-Ray Diffraction (XRD)', $selectedInstruments)) selected @endif>X-Ray Diffraction (XRD)</option>
                                                                    <option value="High-Performance Thin-Layer Chromatography (HPTLC)" @if(in_array('High-Performance Thin-Layer Chromatography (HPTLC)', $selectedInstruments)) selected @endif>High-Performance Thin-Layer Chromatography (HPTLC)</option>
                                                                    <option value="Refractometer" @if(in_array('Refractometer', $selectedInstruments)) selected @endif>Refractometer</option>
                                                                </select>
                                                            </td>
                                                            
                                                            <td><input type="text" name="samplePlanningData[{{ $key }}][labAvailability]" value="{{ $row['labAvailability'] }}"></td>
                                                            <td>
                                                                <div class="col-md-6 new-date-data-field">
                                                                    <div class="group-input input-date">
                                                                        <div class="calenderauditee">
                                                                            <input type="text" id="sampleDate" readonly placeholder="DD-MMM-YYYY"  value="{{ Helpers::getdateFormat($row['sampleDate']) }}"/>
                                                                            <input type="date" name="samplePlanningData[{{ $key }}][sampleDate]"
                                                                                min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                                                                value="{{ $row['sampleDate'] }}"
                                                                                class="hide-input" oninput="handleDateInput(this, 'sampleDate')" />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td><input type="text" name="samplePlanningData[{{ $key }}][sampleMovementHistory]" value="{{ $row['sampleMovementHistory'] }}"></td>
                                                            <td>
                                                                <select name="samplePlanningData[{{ $key }}][testingProcess]">
                                                                    <option {{ $row['testingProcess'] == 'Select Value' ? 'selected' : '' }}>Select Value</option>
                                                                    <option value="Not Yet" {{ $row['testingProcess'] == 'Not Yet' ? 'selected' : '' }}>Not Yet</option>
                                                                    <option value="WIP" {{ $row['testingProcess'] == 'WIP' ? 'selected' : '' }}>WIP</option>
                                                                    <option value="Completed" {{ $row['testingProcess'] == 'Completed' ? 'selected' : '' }}>Completed</option>
                                                                </select>
                                                            </td>
                                                            <td><input type="text" name="samplePlanningData[{{ $key }}][alertNotification]" value="{{ $row['alertNotification'] }}"></td>
                                                            <td><input type="text" name="samplePlanningData[{{ $key }}][deviationLogs]" value="{{ $row['deviationLogs'] }}"></td>
                                                            <td><input type="text" name="samplePlanningData[{{ $key }}][commentsLog]" value="{{ $row['commentsLog'] }}"></td>
                                                            <td>
                                                                <input type="file" name="samplePlanningData[{{ $key }}][attachment]">
                                                                @if(!empty($row['attachment_path']))
                                                                    <a style="color: blue; font-weight: bold; margin-top: 10px;" href="{{ asset($row['attachment_path']) }}" target="_blank">{{ basename($row['attachment_path']) }}</a>
                                                                    <input type="hidden" name="samplePlanningData[{{ $key }}][attachment_path]" value="{{ $row['attachment_path'] }}">
                                                                @endif
                                                            </td>
                                                            <td><input type="text" name="samplePlanningData[{{ $key }}][samplingFrequency]" value="{{ $row['samplingFrequency'] }}"></td>
                                                            <td><input type="text" name="samplePlanningData[{{ $key }}][stabilityStudyType]" value="{{ $row['stabilityStudyType'] }}"></td>
                                                            <td>
                                                                <input type="file" name="samplePlanningData[{{ $key }}][supportingDocumentSampleAnalysis]">
                                                                @if(!empty($row['supportingDocumentSampleAnalysis_path']))
                                                                    <a style="color: blue; font-weight: bold; margin-top: 10px;" href="{{ asset($row['supportingDocumentSampleAnalysis_path']) }}" target="_blank">{{ basename($row['supportingDocumentSampleAnalysis_path']) }}</a>
                                                                    <input type="hidden" name="samplePlanningData[{{ $key }}][supportingDocumentSampleAnalysis_path]" value="{{ $row['supportingDocumentSampleAnalysis_path'] }}">
                                                                @endif
                                                            </td>

                                                            <td>
                                                                <select name="samplePlanningData[{{ $key }}][stabilityStatus]">
                                                                    <option {{ $row['stabilityStatus'] == 'Select Value' ? 'selected' : '' }}>Select Value</option>
                                                                    <option value="Long Term" {{ $row['stabilityStatus'] == 'Long Term' ? 'selected' : '' }}>Long Term</option>
                                                                    <option value="Accelerated" {{ $row['stabilityStatus'] == 'Accelerated' ? 'selected' : '' }}>Accelerated</option>
                                                                    <option value="Intermmediate" {{ $row['stabilityStatus'] == 'Intermmediate' ? 'selected' : '' }}>Intermmediate</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <input type="file" name="samplePlanningData[{{ $key }}][stabilityProtocolAttach]">
                                                                @if(!empty($row['stabilityProtocolAttach_path']))
                                                                    <a style="color: blue; font-weight: bold; margin-top: 10px;" href="{{ asset($row['stabilityProtocolAttach_path']) }}" target="_blank">{{ basename($row['stabilityProtocolAttach_path']) }}</a>
                                                                    <input type="hidden" name="samplePlanningData[{{ $key }}][stabilityProtocolAttach_path]" value="{{ $row['stabilityProtocolAttach_path'] }}">
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <div class="col-md-6 new-date-data-field">
                                                                    <div class="group-input input-date">
                                                                        <div class="calenderauditee">
                                                                            <input type="text" id="stabilityApprovalDate" readonly placeholder="DD-MMM-YYYY" value="{{ Helpers::getdateFormat($row['stabilityApprovalDate']) }}"/>
                                                                            <input type="date" name="samplePlanningData[{{ $key }}][stabilityApprovalDate]"
                                                                                min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                                                                value="{{ $row['stabilityApprovalDate'] }}"
                                                                                class="hide-input" oninput="handleDateInput(this, 'stabilityApprovalDate')" />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td><input type="text" name="samplePlanningData[{{ $key }}][countryOfRegulatorySubmision]" value="{{ $row['countryOfRegulatorySubmision'] }}"></td>
                                                            <td><input type="text" name="samplePlanningData[{{ $key }}][ICHZone]" value="{{ $row['ICHZone'] }}"></td>
                                                            <td><input type="text" name="samplePlanningData[{{ $key }}][photostabilityTestingResult]" value="{{ $row['photostabilityTestingResult'] }}"></td>
                                                            <td><input type="text" name="samplePlanningData[{{ $key }}][reconstitutionStability]" value="{{ $row['reconstitutionStability'] }}"></td>
                                                            <td><input type="text" name="samplePlanningData[{{ $key }}][testingInterval]" value="{{ $row['testingInterval'] }}"></td>
                                                            <td><input type="text" name="samplePlanningData[{{ $key }}][shelfLifeRecommendation]" value="{{ $row['shelfLifeRecommendation'] }}"></td>
                                                            <td>
                                                                <input type="file" name="samplePlanningData[{{ $key }}][stabilityAttachment]">
                                                                @if(!empty($row['stabilityAttachment_path']))
                                                                    <a style="color: blue; font-weight: bold; margin-top: 10px;" href="{{ asset($row['stabilityAttachment_path']) }}" target="_blank">{{ basename($row['stabilityAttachment_path']) }}</a>
                                                                    <input type="hidden" name="samplePlanningData[{{ $key }}][stabilityAttachment_path]" value="{{ $row['stabilityAttachment_path'] }}">
                                                                @endif
                                                            </td>
                                                            
                                                            <td>
                                                                <select name="samplePlanningData[{{ $key }}][reviewerApprover]">
                                                                    <option value="">Select User</option>
                                                                    @if(!empty($users))
                                                                        @foreach($users as $user)
                                                                            <option @if($row['reviewerApprover'] == $user->id) selected @endif value="{{ $user->id }}">{{ $user->name }}</option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                            </td>
                                                            <td><input type="text" name="samplePlanningData[{{ $key }}][sampleDesposion]" value="{{ $row['sampleDesposion'] }}"></td>
                                                            <td>
                                                                <textarea name="samplePlanningData[{{ $key }}][reviewerComment]">{{ $row['reviewerComment'] }}</textarea>
                                                            </td>
                                                            <td>
                                                                <div class="col-md-6 new-date-data-field">
                                                                    <div class="group-input input-date">
                                                                        <div class="calenderauditee">
                                                                            <input type="text" id="supervisorReviewDate" readonly placeholder="DD-MMM-YYYY" value="{{ Helpers::getdateFormat($row['supervisorReviewDate']) }}"/>
                                                                            <input type="date" name="samplePlanningData[{{ $key }}][supervisorReviewDate]"
                                                                                min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                                                                value="{{ $row['supervisorReviewDate'] }}"
                                                                                class="hide-input" oninput="handleDateInput(this, 'supervisorReviewDate')" />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <input type="file" name="samplePlanningData[{{ $key }}][supervisorAttach]">
                                                                @if(!empty($row['supervisorAttach_path']))
                                                                    <a style="color: blue; font-weight: bold; margin-top: 10px;" href="{{ asset($row['supervisorAttach_path']) }}" target="_blank">{{ basename($row['supervisorAttach_path']) }}</a>
                                                                    <input type="hidden" name="samplePlanningData[{{ $key }}][supervisorAttach_path]" value="{{ $row['supervisorAttach_path'] }}">
                                                                @endif
                                                            </td>

                                                            <td>
                                                                <select name="samplePlanningData[{{ $key }}][QAreviewerApprover]">
                                                                    <option value="">Select User</option>
                                                                    @if(!empty($users))
                                                                        @foreach($users as $user)
                                                                            <option @if($row['QAreviewerApprover'] == $user->id) selected @endif value="{{ $user->id }}">{{ $user->name }}</option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <textarea name="samplePlanningData[{{ $key }}][QAreviewerComment]">{{ $row['QAreviewerComment'] }}</textarea>
                                                            </td>
                                                            <td>
                                                                <div class="col-md-6 new-date-data-field">
                                                                    <div class="group-input input-date">
                                                                        <div class="calenderauditee">
                                                                            <input type="text" id="QAreviewDate" readonly placeholder="DD-MMM-YYYY" value="{{ Helpers::getdateFormat($row['QAreviewDate']) }}"/>
                                                                            <input type="date" name="samplePlanningData[{{ $key }}][QAreviewDate]"
                                                                                min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                                                                value="{{ $row['QAreviewDate'] }}"
                                                                                class="hide-input" oninput="handleDateInput(this, 'QAreviewDate')" />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <input type="file" name="samplePlanningData[{{ $key }}][QAsupervisorAttach]">
                                                                @if(!empty($row['QAsupervisorAttach_path']))
                                                                    <a style="color: blue; font-weight: bold; margin-top: 10px;" href="{{ asset($row['QAsupervisorAttach_path']) }}" target="_blank">{{ basename($row['QAsupervisorAttach_path']) }}</a>
                                                                    <input type="hidden" name="samplePlanningData[{{ $key }}][QAsupervisorAttach_path]" value="{{ $row['QAsupervisorAttach_path'] }}">
                                                                @endif
                                                            </td>

                                                            <td>
                                                                <div class="col-md-6 new-date-data-field">
                                                                    <div class="group-input input-date">
                                                                        <div class="calenderauditee">
                                                                            <input type="text" id="destructionDueOn" readonly placeholder="DD-MMM-YYYY" value="{{ Helpers::getdateFormat($row['destructionDueOn']) }}"/>
                                                                            <input type="date" name="samplePlanningData[{{ $key }}][destructionDueOn]"
                                                                                min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                                                                value="{{ $row['destructionDueOn'] }}"
                                                                                class="hide-input" oninput="handleDateInput(this, 'destructionDueOn')" />
                                                                        </div> 
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="col-md-6 new-date-data-field">
                                                                    <div class="group-input input-date">
                                                                        <div class="calenderauditee">
                                                                            <input type="text" id="desctructionDate" readonly placeholder="DD-MMM-YYYY" value="{{ Helpers::getdateFormat($row['desctructionDate']) }}"/>
                                                                            <input type="date" name="samplePlanningData[{{ $key }}][desctructionDate]"
                                                                                min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                                                                value="{{ $row['desctructionDate'] }}"
                                                                                class="hide-input" oninput="handleDateInput(this, 'desctructionDate')" />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td><input type="text" name="samplePlanningData[{{ $key }}][destructedBy]" value="{{ $row['destructedBy'] }}"></td>
                                                            <td>
                                                                <textarea name="samplePlanningData[{{ $key }}][destructionRemarks]">{{ $row['destructionRemarks'] }}</textarea>
                                                            </td>
                                                            <td><button type="button" class="removeRowBtn">Remove</button></td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <script>
                                $(document).on('input', '.quantityWithdrawn', function() {
                                    var row = $(this).closest('tr');
                                    var quantity = parseFloat(row.find('.sampleQuantity').val()) || 0;
                                    var withdrawn = parseFloat($(this).val()) || 0;
                                    var currentQuantity = quantity - withdrawn;
                                    row.find('.currentQuantity').val(currentQuantity);
                                });

                                document.addEventListener('DOMContentLoaded', function () {
                                    function updateAnalysisResultColor(lslField, uslField, analysisField) {
                                        const lsl = parseFloat(lslField.value || 0);
                                        const usl = parseFloat(uslField.value || 0);

                                        if (usl > lsl) {
                                            analysisField.style.backgroundColor = 'red';
                                        } else {
                                            analysisField.style.backgroundColor = 'green';
                                        }
                                    }

                                    // Function to initialize the row's fields
                                    function initializeRow(row) {
                                        const lslField = row.querySelector('.lsl-field');
                                        const uslField = row.querySelector('.usl-field');
                                        const analysisField = row.querySelector('.analysis-field');

                                        if (lslField && uslField && analysisField) {
                                            updateAnalysisResultColor(lslField, uslField, analysisField);

                                            lslField.addEventListener('input', function () {
                                                updateAnalysisResultColor(lslField, uslField, analysisField);
                                            });

                                            uslField.addEventListener('input', function () {
                                                updateAnalysisResultColor(lslField, uslField, analysisField);
                                            });
                                        }
                                    }

                                    document.querySelectorAll('tr').forEach(row => {
                                        initializeRow(row);
                                    });
                                });
                            </script>

                            <script>
                                function validateDynamicInput(rowIndex) {
                                    var lsl = parseFloat(document.getElementById('lsl_' + rowIndex).value);
                                    var usl = parseFloat(document.getElementById('usl_' + rowIndex).value);
                                    var resultField = document.getElementById('results_' + rowIndex);
                                    var analysisresults = document.getElementById('analysisresults_' + rowIndex);
                                    var result = parseFloat(resultField.value);

                                    if (event && event.target && event.target.id === 'results_' + rowIndex) {
                                        if (isNaN(lsl) || isNaN(usl) || isNaN(result)) {
                                            resultField.style.borderColor = '';
                                            resultField.style.color = '';
                                            analysisresults.style.backgroundColor = '';
                                            return;
                                        }

                                        if (result >= lsl && result <= usl) {
                                            resultField.style.borderColor = 'green';
                                            resultField.style.color = 'green';
                                            analysisresults.style.backgroundColor = 'green';
                                        } else {
                                            resultField.style.borderColor = 'red';
                                            resultField.style.color = 'red';
                                            analysisresults.style.backgroundColor = 'red';
                                        }
                                    }
                                }

                                window.addEventListener('load', function() {
                                    var dynamicFields = document.querySelectorAll('.results-field');
                                    dynamicFields.forEach(function(field, index) {
                                        validateDynamicInput(index);
                                        field.addEventListener('input', function() {
                                            validateDynamicInput(index);
                                        });
                                    });
                                });

                                document.addEventListener("DOMContentLoaded", function () {
                                    let rowIndex = {{ count($planningGrid->data) ?? 0 }};
                                    let nextSamplePlanId = {{ !empty($planningGrid->data) ? max(array_column($planningGrid->data, 'samplePlanId')) + 1 : 1001 }};
                                    const users = @json($users->toArray() ?? []);
                                    const locations = @json($locations->toArray() ?? []);
                                    const labTechnicians = @json($analystData->toArray() ?? []);
                                    const analysts = @json($analystData->toArray() ?? []);
                                    const reagentDatas = @json($filteredData ?? []);

                                    document.getElementById("addSamplePlanning").addEventListener("click", function () {
                                        const tableBody = document.querySelector("#editSamplePlanningTable tbody");
                                        const newRow = document.createElement("tr");

                                        let userOptions = `<option value="">Select User</option>`;
                                        if (Array.isArray(users)) {
                                            users.forEach(user => {
                                                userOptions += `<option value="${user.id}">${user.name}</option>`;
                                            });
                                        } else {
                                            console.warn("Users data is not an array");
                                        }

                                        let locationOptions = `<option value="">Select Location</option>`;
                                        if (Array.isArray(locations)) {
                                            locations.forEach(location => {
                                                locationOptions += `<option value="${location.id}">${location.name}</option>`;
                                            });
                                        } else {
                                            console.warn("Locations data is not an array");
                                        }

                                        let labTechnicianOptions = `<option value="">Select Lab Technician</option>`;
                                        if (Array.isArray(labTechnicians)) {
                                            labTechnicians.forEach(labTechnician => {
                                                labTechnicianOptions += `<option value="${labTechnician.userId}">${labTechnician.userName}</option>`;
                                            });
                                        } else {
                                            console.warn("Technician data is not an array");
                                        }

                                        let analystOptions = `<option value="">Select Analyst</option>`;
                                        if (Array.isArray(analysts)) {
                                            analysts.forEach(analyst => {
                                                analystOptions += `<option value="${analyst.userId}">${analyst.userName}</option>`;
                                            });
                                        } else {
                                            console.warn("Analyst data is not an array");
                                        }

                                        let reagentOptions = `<option value="">Select Used Quality</option>`;
                                        if (Array.isArray(reagentDatas)) {
                                            reagentDatas.forEach(item => {
                                                reagentOptions += `<option value="${item.name}">${item.name}</option>`;
                                            });
                                        } else {
                                            console.warn("Filtered data is not an array");
                                        }

                                        newRow.innerHTML = `
                                            <td class="row-index">${rowIndex + 1}</td>
                                            <td><input type="number" name="samplePlanningData[${rowIndex}][samplePlanId]" value="${nextSamplePlanId}" readonly></td>
                                            <td><input type="text" name="samplePlanningData[${rowIndex}][samplePlan]"></td>
                                            <td><input type="text" name="samplePlanningData[${rowIndex}][samplePlanName]"></td>
                                            <td><input type="text" name="samplePlanningData[${rowIndex}][sampleType]"></td>
                                            <td><input type="text" name="samplePlanningData[${rowIndex}][productmaterial]"></td>
                                            <td><input type="text" name="samplePlanningData[${rowIndex}][productmaterialCode]"></td>
                                            <td><input type="text" name="samplePlanningData[${rowIndex}][batchNumber]"></td>
                                            <td>
                                                <select name="samplePlanningData[${rowIndex}][samplePriority]">
                                                     <option value="">Select Priority</option>
                                                    <option value="High">High</option>
                                                    <option value="Medium">Medium</option>
                                                    <option value="Low">Low</option>
                                                </select>
                                            </td>
                                            <td><input type="text" name="samplePlanningData[${rowIndex}][sampleQuantity]" class="sampleQuantity"></td>
                                            <td><input type="text" name="samplePlanningData[${rowIndex}][quantityWithdrawn]" class="quantityWithdrawn"></td>
                                            <td><input type="text" name="samplePlanningData[${rowIndex}][currentQuantity]" class="currentQuantity"></td>
                                            <td>
                                                <select name="samplePlanningData[${rowIndex}][UOM]">
                                                    <option value="">Select UOM</option>
                                                    <option value="Pieces">Pieces</option>
                                                    <option value="Kilograms">Kilograms</option>
                                                    <option value="Liters">Liters</option>
                                                    <option value="Meters">Meters</option>
                                                    <option value="Cubic Meters">Cubic Meters</option>
                                                    <option value="Grams">Grams</option>
                                                    <option value="Milliliters">Milliliters</option>
                                                    <option value="Dozens">Dozens</option>
                                                    <option value="Percent ">Percent </option>
                                                </select>
                                            </td>
                                            <td>
                                                <select name="samplePlanningData[${rowIndex}][market]">
                                                    <option value="">Select a country</option>
                                                    <option value="Afghanistan">Afghanistan</option>
                                                    <option value="Albania">Albania</option>
                                                    <option value="Algeria">Algeria</option>
                                                    <option value="American Samoa">American Samoa</option>
                                                    <option value="Andorra">Andorra</option>
                                                    <option value="Angola">Angola</option>
                                                    <option value="Argentina">Argentina</option>
                                                    <option value="Armenia">Armenia</option>
                                                    <option value="Australia">Australia</option>
                                                    <option value="Austria">Austria</option>
                                                    <option value="Bahrain">Bahrain</option>
                                                    <option value="Bangladesh">Bangladesh</option>
                                                    <option value="Barbados">Barbados</option>
                                                    <option value="Belarus">Belarus</option>
                                                    <option value="Belgium">Belgium</option>
                                                    <option value="Belize">Belize</option>
                                                    <option value="Benin">Benin</option>
                                                    <option value="Bhutan">Bhutan</option>
                                                    <option value="Bolivia">Bolivia</option>
                                                    <option value="Botswana">Botswana</option>
                                                    <option value="Brazil">Brazil</option>
                                                    <option value="Bulgaria">Bulgaria</option>
                                                    <option value="Colombia">Colombia</option>
                                                    <option value="Croatia">Croatia</option>
                                                    <option value="Czech Republic">Czech Republic</option>
                                                    <option value="Denmark">Denmark</option>
                                                    <option value="Canada">Canada</option>
                                                    <option value="Egypt">Egypt</option>
                                                    <option value="Finland">Finland</option>
                                                    <option value="France">France</option>
                                                    <option value="Germany">Germany</option>
                                                    <option value="India">India</option>
                                                    <option value="Italy">Italy</option>
                                                    <option value="Japan">Japan</option>
                                                    <option value="Mexico">Mexico</option>
                                                    <option value="Netherlands">Netherlands</option>
                                                    <option value="New Zealand">New Zealand</option>
                                                    <option value="Nigeria">Nigeria</option>
                                                    <option value="Pakistan">Pakistan</option>
                                                    <option value="Poland">Poland</option>
                                                    <option value="Russia">Russia</option>
                                                    <option value="Saudi Arabia">Saudi Arabia</option>
                                                    <option value="Spain">Spain</option>
                                                    <option value="Sweden">Sweden</option>
                                                    <option value="Switzerland">Switzerland</option>
                                                    <option value="Turkey">Turkey</option>
                                                    <option value="United Kingdom">United Kingdom</option>
                                                    <option value="United States">United States</option>
                                                </select>
                                            </td>
                                            <td><input type="text" name="samplePlanningData[${rowIndex}][specificationId]"></td>
                                            <td><input type="file" name="samplePlanningData[${rowIndex}][specificationAttach]"></td>
                                            <td><input type="text" name="samplePlanningData[${rowIndex}][STPId]"></td>
                                            <td><input type="file" name="samplePlanningData[${rowIndex}][STPAttach]"></td>
                                            <td><input type="text" name="samplePlanningData[${rowIndex}][testName]"></td>
                                            <td><input type="text" name="samplePlanningData[${rowIndex}][testMethod]"></td>
                                            <td><input type="text" name="samplePlanningData[${rowIndex}][testParameter]"></td>
                                            <td><input type="text" name="samplePlanningData[${rowIndex}][testingFrequency]"></td>
                                            <td>
                                                <select name="samplePlanningData[${rowIndex}][testingLocation]">
                                                    ${locationOptions}
                                                </select>
                                            </td>
                                            <td><input type="number" name="samplePlanningData[${rowIndex}][LSL]" class="lsl-field" id="lsl_${rowIndex}" oninput="validateDynamicInput(${rowIndex})"></td>
                                            <td><input type="number" name="samplePlanningData[${rowIndex}][USL]" class="usl-field" id="usl_${rowIndex}" oninput="validateDynamicInput(${rowIndex})"></td>

                                            <td>
                                                <div class="col-md-6 new-date-data-field">
                                                    <div class="group-input input-date">
                                                        <div class="calenderauditee">
                                                            <input type="text" id="testingDeadline${rowIndex}" readonly placeholder="DD-MMM-YYYY" />
                                                            <input type="date" name="samplePlanningData[${rowIndex}][testingDeadline]"
                                                                min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="{{ $row['testingDeadline'] }}"
                                                                class="hide-input" oninput="handleDateInput(this, 'testingDeadline${rowIndex}')" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>


                                            <td><input type="text" name="samplePlanningData[${rowIndex}][plannerName]"></td>
                                            <td><input type="text" name="samplePlanningData[${rowIndex}][sampleSource]"></td>
                                            <td>
                                                <div class="col-md-6 new-date-data-field">
                                                    <div class="group-input input-date">
                                                        <div class="calenderauditee">
                                                            <input type="text" id="plannedDate${rowIndex}" readonly placeholder="DD-MMM-YYYY" />
                                                            <input type="date" name="samplePlanningData[${rowIndex}][plannedDate]"
                                                                min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="{{ $row['plannedDate'] }}"
                                                                class="hide-input" oninput="handleDateInput(this, 'plannedDate${rowIndex}')" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="col-md-6 new-date-data-field">
                                                    <div class="group-input input-date">
                                                        <div class="calenderauditee">
                                                            <input type="text" id="startDate${rowIndex}" readonly placeholder="DD-MMM-YYYY" />
                                                            <input type="date" name="samplePlanningData[${rowIndex}][startDate]"
                                                                min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="{{ $row['startDate'] }}"
                                                                class="hide-input" oninput="handleDateInput(this, 'startDate${rowIndex}')" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <textarea name="samplePlanningData[${rowIndex}][delayJustification]"></textarea>
                                            </td>
                                            <td>
                                                <select multiple id="labTechnicians_${rowIndex}" name="samplePlanningData[${rowIndex}][labTechnician]">
                                                    ${labTechnicianOptions}
                                                </select>
                                            </td>
                                            <td><input type="text" name="samplePlanningData[${rowIndex}][sampleCostEstimation]"></td>
                                            <td><input type="text" name="samplePlanningData[${rowIndex}][resourceUtilization]"></td>
                                            <td>
                                                <div class="col-md-6 new-date-data-field">
                                                    <div class="group-input input-date">
                                                        <div class="calenderauditee">
                                                            <input type="text" id="sampleCollectionDate${rowIndex}" readonly placeholder="DD-MMM-YYYY" />
                                                            <input type="date" name="samplePlanningData[${rowIndex}][sampleCollectionDate]"
                                                                min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="{{ $row['sampleCollectionDate'] }}"
                                                                class="hide-input" oninput="handleDateInput(this, 'sampleCollectionDate${rowIndex}')" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><input type="file" name="samplePlanningData[${rowIndex}][supportingDocumentGI]"></td>

                                            <td>
                                                <input type="text" name="samplePlanningData[${rowIndex}][analysisType]">
                                            </td>
                                            <td><input type="number" name="samplePlanningData[${rowIndex}][results]"  class="results-field" id="results_${rowIndex}" oninput="validateDynamicInput(${rowIndex})"></td>
                                            <td>
                                                <input type="text" name="samplePlanningData[${rowIndex}][analysisResult]" id="analysisresults_${rowIndex}" readonly>
                                            </td>
                                            
                                            <td>
                                                <select multiple id="analystData_${rowIndex}" name="samplePlanningData[${rowIndex}][analyst]">
                                                    ${analystOptions}
                                                </select>
                                            </td>
                                            <td>
                                                <select multiple id="reagentDatas_${rowIndex}" name="samplePlanningData[${rowIndex}][reagent]">
                                                    ${reagentOptions}
                                                </select>
                                            </td>
                                            <td>
                                                <div class="col-md-6 new-date-data-field">
                                                    <div class="group-input input-date">
                                                        <div class="calenderauditee">
                                                            <input type="text" 
                                                                id="testingStartDate${rowIndex}" 
                                                                readonly  style="width: 150px;"
                                                                placeholder="DD-MMM-YYYY HH:mm" 
                                                                value="{{ Helpers::formatDateTime($row['testingStartDate'] ?? '') }}" />
                                                            <input type="datetime-local" 
                                                                name="samplePlanningData[${rowIndex}][testingStartDate]" 
                                                                min="{{ \Carbon\Carbon::now()->format('Y-m-d\TH:i') }}"
                                                                class="hide-input" 
                                                                oninput="handleDateInput(this, 'testingStartDate${rowIndex}')" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="col-md-6 new-date-data-field">
                                                    <div class="group-input input-date">
                                                        <div class="calenderauditee">
                                                            <input type="text" style="width: 150px;"
                                                                id="testingEndDate${rowIndex}" 
                                                                readonly 
                                                                placeholder="DD-MMM-YYYY HH:mm" 
                                                                value="{{ Helpers::formatDateTime($row['testingEndDate'] ?? '') }}" />
                                                            <input type="datetime-local" 
                                                                name="samplePlanningData[${rowIndex}][testingEndDate]" 
                                                                min="{{ \Carbon\Carbon::now()->format('Y-m-d\TH:i') }}"
                                                                class="hide-input" 
                                                                oninput="handleDateInput(this, 'testingEndDate${rowIndex}')" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <select name="samplePlanningData[${rowIndex}][analysisStatus]">
                                                    <option value="">Select Value</option>
                                                    <option value="Not Yet Started">Not Yet Started</option>
                                                    <option value="Started">Started</option>
                                                    <option value="Completed">Completed</option>
                                                </select>
                                            </td>
                                            <td>
                                                <select name="samplePlanningData[${rowIndex}][passFail]">
                                                    <option>Select Value</option>
                                                    <option value="Pass">Pass</option>
                                                    <option value="Fail">Fail</option>
                                                    <option value="Not Yet">Not Yet</option>
                                                    <option value="Under Investigation">Under Investigation</option>
                                                </select>
                                            </td>
                                            <td>
                                                <textarea name="samplePlanningData[${rowIndex}][analystInstruction]"></textarea>
                                            </td>
                                            <td>
                                                <input type="number" name="samplePlanningData[${rowIndex}][testPlanId]">
                                            </td>
                                            <td>
                                                <input type="text" name="samplePlanningData[${rowIndex}][turaroundTime]">
                                            </td>
                                            <td>
                                                <div class="col-md-6 new-date-data-field">
                                                    <div class="group-input input-date">
                                                        <div class="calenderauditee">
                                                            <input type="text" id="sampleRetestingDate${rowIndex}" readonly placeholder="DD-MMM-YYYY" />
                                                            <input type="date" name="samplePlanningData[${rowIndex}][sampleRetestingDate]"
                                                                min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="{{ $row['sampleRetestingDate'] }}"
                                                                class="hide-input" oninput="handleDateInput(this, 'sampleRetestingDate${rowIndex}')" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="col-md-6 new-date-data-field">
                                                    <div class="group-input input-date">
                                                        <div class="calenderauditee">
                                                            <input type="text" id="reviewDate${rowIndex}" readonly placeholder="DD-MMM-YYYY" />
                                                            <input type="date" name="samplePlanningData[${rowIndex}][reviewDate]"
                                                                min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="{{ $row['reviewDate'] }}"
                                                                class="hide-input" oninput="handleDateInput(this, 'reviewDate${rowIndex}')" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                             <td>
                                                <select name="samplePlanningData[${rowIndex}][sampleStorageLocation]">
                                                    ${locationOptions}
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" name="samplePlanningData[${rowIndex}][transportationMethod]">
                                            </td>
                                            <td>
                                                <textarea name="samplePlanningData[${rowIndex}][samplePreprationMethod]"></textarea>
                                            </td>
                                            <td>
                                                <textarea name="samplePlanningData[${rowIndex}][samplePackagingDetail]"></textarea>
                                            </td>
                                            <td>
                                                <input type="text" name="samplePlanningData[${rowIndex}][sampleLabel]">
                                            </td>
                                            <td>
                                                <textarea name="samplePlanningData[${rowIndex}][regulatoryRequirement]"></textarea>
                                            </td>
                                            <td>
                                                <input type="text" name="samplePlanningData[${rowIndex}][qualityControlCheck]">
                                            </td>
                                            <td>
                                                <input type="text" name="samplePlanningData[${rowIndex}][controlSamplePreference]">
                                            </td>
                                            <td>
                                                <input type="text" name="samplePlanningData[${rowIndex}][controlSample]">
                                            </td>
                                            <td>
                                                <input type="text" name="samplePlanningData[${rowIndex}][referenceSample]">
                                            </td>
                                            <td>
                                                <input type="text" name="samplePlanningData[${rowIndex}][sampleIntegrityStatus]">
                                            </td>
                                            <td>
                                                <select name="samplePlanningData[${rowIndex}][assignedDepartment]">
                                                    <option value="">Select Department</option>
                                                    <option value="CQA">Corporate Quality Assurance</option>
                                                    <option value="QAB">Quality Assurance Biopharma</option>
                                                    <option value="CQC">Central Quality Control</option>
                                                    <option value="MANU">Manufacturing</option>
                                                    <option value="PSG">Plasma Sourcing Group</option>
                                                    <option value="CS">Central Stores</option>
                                                    <option value="ITG">Information Technology Group</option>
                                                    <option value="MM">Molecular Medicine</option>
                                                    <option value="CL">Central Laboratory</option>
                                                    <option value="TT">Tech Team</option>
                                                    <option value="QA">Quality Assurance</option>
                                                    <option value="QM">Quality Management</option>
                                                    <option value="IA">IT Administration</option>
                                                    <option value="ACC">Accounting</option>
                                                    <option value="LOG">Logistics</option>
                                                    <option value="SM">Senior Management</option>
                                                    <option value="BA">Business Administration</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" name="samplePlanningData[${rowIndex}][riskAssessment]">
                                            </td>
                                            <td>
                                                <input type="text" name="samplePlanningData[${rowIndex}][supervisor]">
                                            </td>
                                            <td>
                                                <select name="samplePlanningData[${rowIndex}][instrumentReserved]" mutiple id="instrumentReserved_${rowIndex}">
                                                    <option value="">Select Option</option>
                                                    <option value="High-Performance Liquid Chromatography (HPLC)">High-Performance Liquid Chromatography (HPLC)</option>
                                                    <option value="Gas Chromatography (GC)">Gas Chromatography (GC)</option>
                                                    <option value="Thin-Layer Chromatography (TLC)">Thin-Layer Chromatography (TLC)</option>
                                                    <option value="Ultra-Performance Liquid Chromatography (UPLC)">Ultra-Performance Liquid Chromatography (UPLC)</option>
                                                    <option value="Ion Chromatography">Ion Chromatography</option>
                                                    <option value="Ultraviolet-Visible Spectrophotometer (UV-Vis)">Ultraviolet-Visible Spectrophotometer (UV-Vis)</option>
                                                    <option value="Infrared Spectrophotometer (IR)">Infrared Spectrophotometer (IR)</option>
                                                    <option value="Fourier-Transform Infrared Spectroscopy (FTIR)">Fourier-Transform Infrared Spectroscopy (FTIR)</option>
                                                    <option value="Atomic Absorption Spectroscopy (AAS)">Atomic Absorption Spectroscopy (AAS)</option>
                                                    <option value="Nuclear Magnetic Resonance Spectroscopy (NMR)">Nuclear Magnetic Resonance Spectroscopy (NMR)</option>
                                                    <option value="Mass Spectrometer (MS)">Mass Spectrometer (MS)</option>
                                                    <option value="Raman Spectrometer">Raman Spectrometer</option>
                                                    <option value="Optical Microscope">Optical Microscope</option>
                                                    <option value="Scanning Electron Microscope (SEM)">Scanning Electron Microscope (SEM)</option>
                                                    <option value="Transmission Electron Microscope (TEM)">Transmission Electron Microscope (TEM)</option>
                                                    <option value="Particle Size Analyzer">Particle Size Analyzer</option>
                                                    <option value="Differential Scanning Calorimeter (DSC)">Differential Scanning Calorimeter (DSC)</option>
                                                    <option value="Thermogravimetric Analyzer (TGA)">Thermogravimetric Analyzer (TGA)</option>
                                                    <option value="pH Meter">pH Meter</option>
                                                    <option value="Conductivity Meter">Conductivity Meter</option>
                                                    <option value="Karl Fischer Titrator">Karl Fischer Titrator</option>
                                                    <option value="Potentiometer">Potentiometer</option>
                                                    <option value="Trainee">Trainee</option>
                                                    <option value="Polarimeter">Polarimeter</option>
                                                    <option value="Dissolution Tester">Dissolution Tester</option>
                                                    <option value="Disintegration Tester">Disintegration Tester</option>
                                                    <option value="Tablet Hardness Tester">Tablet Hardness Tester</option>
                                                    <option value="Friability Tester">Friability Tester</option>
                                                    <option value="Moisture Analyzer">Moisture Analyzer</option>
                                                    <option value="X-Ray Diffraction (XRD)">X-Ray Diffraction (XRD)</option>
                                                    <option value="High-Performance Thin-Layer Chromatography (HPTLC)">High-Performance Thin-Layer Chromatography (HPTLC)</option>
                                                    <option value="Refractometer">Refractometer</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" name="samplePlanningData[${rowIndex}][labAvailability]">
                                            </td>
                                            <td>
                                                <div class="col-md-6 new-date-data-field">
                                                    <div class="group-input input-date">
                                                        <div class="calenderauditee">
                                                            <input type="text" id="sampleDate${rowIndex}" readonly placeholder="DD-MMM-YYYY" />
                                                            <input type="date" name="samplePlanningData[${rowIndex}][sampleDate]"
                                                                min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="{{ $row['sampleDate'] }}"
                                                                class="hide-input" oninput="handleDateInput(this, 'sampleDate${rowIndex}')" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <input type="text" name="samplePlanningData[${rowIndex}][sampleMovementHistory]">
                                            </td>
                                            <td>
                                                <select name="samplePlanningData[${rowIndex}][testingProcess]">
                                                    <option value="">Select Process</option>
                                                    <option value="Not Yet">Not Yet</option>
                                                    <option value="WIP">WIP</option>
                                                    <option value="Completed">Completed</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" name="samplePlanningData[${rowIndex}][alertNotification]">
                                            </td>
                                            <td>
                                                <input type="text" name="samplePlanningData[${rowIndex}][deviationLogs]">
                                            </td>
                                            <td>
                                                <input type="text" name="samplePlanningData[${rowIndex}][commentsLog]">
                                            </td>
                                            <td>
                                                <input type="file" name="samplePlanningData[${rowIndex}][attachment]">
                                            </td>
                                            <td>
                                                <input type="text" name="samplePlanningData[${rowIndex}][samplingFrequency]">
                                            </td>
                                            <td>
                                                <input type="text" name="samplePlanningData[${rowIndex}][stabilityStudyType]">
                                            </td>
                                            <td>
                                                <input type="text" name="samplePlanningData[${rowIndex}][supportingDocumentSampleAnalysis]">
                                            </td>

                                            <td>
                                                <select name="samplePlanningData[${rowIndex}][stabilityStatus]">
                                                    <option>Select Value</option>
                                                    <option value="Long Term">Long Term</option>
                                                    <option value="Accelerated">Accelerated</option>
                                                    <option value="Intermmediate">Intermmediate</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="file" name="samplePlanningData[${rowIndex}][stabilityProtocolAttach]">
                                            </td>
                                            <td>
                                                <div class="col-md-6 new-date-data-field">
                                                    <div class="group-input input-date">
                                                        <div class="calenderauditee">
                                                            <input type="text" id="stabilityApprovalDate${rowIndex}" readonly placeholder="DD-MMM-YYYY" />
                                                            <input type="date" name="samplePlanningData[${rowIndex}][stabilityApprovalDate]"
                                                                min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="{{ $row['stabilityApprovalDate'] }}"
                                                                class="hide-input" oninput="handleDateInput(this, 'stabilityApprovalDate${rowIndex}')" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <input type="text" name="samplePlanningData[${rowIndex}][countryOfRegulatorySubmision]">
                                            </td>
                                            <td>
                                                <input type="text" name="samplePlanningData[${rowIndex}][ICHZone]">
                                            </td>
                                            <td>
                                                <input type="text" name="samplePlanningData[${rowIndex}][photostabilityTestingResult]">
                                            </td>
                                            <td>
                                                <input type="text" name="samplePlanningData[${rowIndex}][reconstitutionStability]">
                                            </td>
                                            <td>
                                                <input type="text" name="samplePlanningData[${rowIndex}][testingInterval]">
                                            </td>
                                            <td>
                                                <input type="text" name="samplePlanningData[${rowIndex}][shelfLifeRecommendation]">
                                            </td>
                                            <td>
                                                <input type="file" name="samplePlanningData[${rowIndex}][stabilityAttachment]">
                                            </td>

                                            <td>
                                                <select name="samplePlanningData[${rowIndex}][reviewerApprover]">
                                                    ${userOptions}
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" name="samplePlanningData[${rowIndex}][sampleDesposion]">
                                            </td>
                                            <td>
                                                <textarea name="samplePlanningData[${rowIndex}][reviewerComment]"></textarea>
                                            </td>
                                            <td>
                                                <div class="col-md-6 new-date-data-field">
                                                    <div class="group-input input-date">
                                                        <div class="calenderauditee">
                                                            <input type="text" id="supervisorReviewDate${rowIndex}" readonly placeholder="DD-MMM-YYYY" />
                                                            <input type="date" name="samplePlanningData[${rowIndex}][supervisorReviewDate]"
                                                                min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="{{ $row['supervisorReviewDate'] }}"
                                                                class="hide-input" oninput="handleDateInput(this, 'supervisorReviewDate${rowIndex}')" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <input type="file" name="samplePlanningData[${rowIndex}][supervisorAttach]">
                                            </td>

                                            <td>
                                                <select name="samplePlanningData[${rowIndex}][QAreviewerApprover]">
                                                    ${userOptions}
                                                </select>
                                            </td>
                                            <td>
                                                <textarea name="samplePlanningData[${rowIndex}][QAreviewerComment]"></textarea>
                                            </td>
                                            <td>
                                                <div class="col-md-6 new-date-data-field">
                                                    <div class="group-input input-date">
                                                        <div class="calenderauditee">
                                                            <input type="text" id="QAreviewDate${rowIndex}" readonly placeholder="DD-MMM-YYYY" />
                                                            <input type="date" name="samplePlanningData[${rowIndex}][QAreviewDate]"
                                                                min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="{{ $row['QAreviewDate'] }}"
                                                                class="hide-input" oninput="handleDateInput(this, 'QAreviewDate${rowIndex}')" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <input type="file" name="samplePlanningData[${rowIndex}][QAsupervisorAttach]">
                                            </td>

                                            <td>
                                                <div class="col-md-6 new-date-data-field">
                                                    <div class="group-input input-date">
                                                        <div class="calenderauditee">
                                                            <input type="text" id="destructionDueOn${rowIndex}" readonly placeholder="DD-MMM-YYYY" />
                                                            <input type="date" name="samplePlanningData[${rowIndex}][destructionDueOn]"
                                                                min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                                                class="hide-input" oninput="handleDateInput(this, 'destructionDueOn${rowIndex}')" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="col-md-6 new-date-data-field">
                                                    <div class="group-input input-date">
                                                        <div class="calenderauditee">
                                                            <input type="text" id="desctructionDate${rowIndex}" readonly placeholder="DD-MMM-YYYY" />
                                                            <input type="date" name="samplePlanningData[${rowIndex}][desctructionDate]"
                                                                min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                                                class="hide-input" oninput="handleDateInput(this, 'desctructionDate${rowIndex}')" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <input type="text" name="samplePlanningData[${rowIndex}][destructedBy]">
                                            </td>
                                            <td>
                                                <textarea name="samplePlanningData[${rowIndex}][destructionRemarks]"></textarea>
                                            </td>

                                            <td><button type="button" class="removeRowBtn">Remove</button></td>
                                        `;
                                        tableBody.appendChild(newRow);
                                        rowIndex++;
                                        nextSamplePlanId++;
                                        VirtualSelect.init({
                                            ele: '#instrumentReserved_' + (rowIndex - 1),
                                            multiple: true
                                        });
                                        VirtualSelect.init({
                                            ele: '#labTechnicians_' + (rowIndex - 1),
                                            multiple: true
                                        });
                                        VirtualSelect.init({
                                            ele: '#analystData_' + (rowIndex - 1),
                                            multiple: true
                                        });
                                        VirtualSelect.init({
                                            ele: '#reagentDatas_' + (rowIndex - 1),
                                            multiple: true
                                        });
                                    });


                                    document.addEventListener("click", function (e) {
                                        if (e.target && e.target.classList.contains("removeRowBtn")) {
                                            const row = e.target.closest("tr");
                                            row.remove();
                                        }
                                    });
                                });
                            </script>


                                <!-- <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Sample Plan ID">Sample Plan ID</label>
                                        <input type="number" name="sample_plan_id" value="{{ $data->sample_plan_id }}">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Sample Plan ID">Sample Plan</label>
                                        <input type="text" name="sample_plan" value="{{ $data->sample_plan }}">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Sample Plan ID">Sample Name</label>
                                        <input type="text" name="sample_name" value="{{ $data->sample_name }}">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Sample Plan ID">Sample Type</label>
                                        <input type="text" name="sample_type" value="{{ $data->sample_type }}">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Sample Plan ID">Product / Material Name</label>
                                        <input type="text" name="product_name" value="{{ $data->product_name }}">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Sample Plan ID">Batch/Lot Number</label>
                                        <input type="text" name="batch_number" value="{{ $data->batch_number }}">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Sample Plan ID">Sample Priority</label>
                                        <select name="sample_priority">
                                            <option value="">Select Priority Level</option>
                                            <option value="Low" @if($data->sample_priority == "Low") selected @endif>Low</option>
                                            <option value="Medium" @if($data->sample_priority == "Medium") selected @endif>Medium</option>
                                            <option value="High" @if($data->sample_priority == "High") selected @endif>High</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Sample Plan ID">Sample Quantity</label>
                                        <input type="number" name="sample_quantity" value="{{ $data->sample_quantity }}">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Sample Plan ID">UOM</label>
                                        <select name="UOM">
                                            <option value="">Select Priority Level</option>
                                            <option value="gm" @if($data->sample_priority == "gm") selected @endif>gm</option>
                                            <option value="ml" @if($data->sample_priority == "ml") selected @endif>ml</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Market">Market</label>
                                        <input type="text" name="market" value="{{ $data->market }}">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Specification Id">Specification Id</label>
                                        <input type="text" name="specification_id" value="{{ $data->specification_id }}">
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="file Attachments">Specification Attachments</label>
                                        <div> <small class="text-primary">Please Attach all relevant or supporting documents</small> </div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="specification_attachment">
                                                @if ($data->specification_attachment)
                                                    @foreach (json_decode($data->specification_attachment) as $file)
                                                        <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                            <b>{{ $file }}</b>
                                                            <a href="{{ asset('upload/' . $file) }}" target="_blank">
                                                                <i class="fa fa-eye text-primary" style="font-size:20px; margin-right:-10px;"></i>
                                                            </a>
                                                            <a type="button" class="remove-file" data-file-name="{{ $file }}">
                                                                <i class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i>
                                                            </a>
                                                        </h6>
                                                    @endforeach
                                                @endif
                                            </div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="hoddfile" name="specification_attachment[]" oninput="addMultipleFiles(this, 'specification_attachment')" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="STP Id">STP Id</label>
                                        <input type="text" name="STP_id" value="{{ $data->STP_id }}">
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="file Attachments">STP Attachments</label>
                                        <div> <small class="text-primary">Please Attach all relevant or supporting documents</small> </div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="STP_attachment">
                                                @if ($data->STP_attachment)
                                                    @foreach (json_decode($data->STP_attachment) as $file)
                                                        <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                            <b>{{ $file }}</b>
                                                            <a href="{{ asset('upload/' . $file) }}" target="_blank">
                                                                <i class="fa fa-eye text-primary" style="font-size:20px; margin-right:-10px;"></i>
                                                            </a>
                                                            <a type="button" class="remove-file" data-file-name="{{ $file }}">
                                                                <i class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i>
                                                            </a>
                                                        </h6>
                                                    @endforeach
                                                @endif
                                            </div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="hoddfile" name="STP_attachment[]" oninput="addMultipleFiles(this, 'STP_attachment')" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Test Name">Test Name</label>
                                        <input type="text" name="test_name" value="{{ $data->test_name }}">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Test Method">Test Method</label>
                                        <input type="text" name="test_method" value="{{ $data->test_method }}">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Test Parameters">Test Parameters</label>
                                        <select name="test_parameter">
                                            <option>Select Tests</option>
                                            <option value="Description" @if($data->test_parameter == "Description") selected @endif>Description</option>
                                            <option value="Weight Of 20 tablets" @if($data->test_parameter == "Weight Of 20 tablets") selected @endif>Weight Of 20 tablets</option>
                                            <option value="Average Weight ( mg )" @if($data->test_parameter == "Average Weight ( mg )") selected @endif>Average Weight ( mg )</option>
                                            <option value="Thickness" @if($data->test_parameter == "Thickness") selected @endif>Thickness</option>
                                            <option value="Disintigration Time" @if($data->test_parameter == "Disintigration Time") selected @endif>Disintigration Time</option>
                                            <option value="Hardness" @if($data->test_parameter == "Hardness") selected @endif>Hardness</option>
                                            <option value="Diameter" @if($data->test_parameter == "Diameter") selected @endif>Diameter</option>
                                            <option value="Friability" @if($data->test_parameter == "Friability") selected @endif>Friability</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Testing Frequency">Testing Frequency</label>
                                        <input type="text" name="testing_frequency" value="{{ $data->testing_frequency }}">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Testing Location">Testing Location</label>
                                        <input type="text" name="testing_location" value="{{ $data->testing_location }}">
                                    </div>
                                </div> -->

                                <!-- <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Test Grouping">Test Grouping</label>
                                        <input type="text" name="test_grouping" value="{{ $data->test_grouping }}">
                                    </div>
                                </div> -->

                                <!-- <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="LSL">LSL</label>
                                        <input type="text" name="LSL" value="{{ $data->LSL }}">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="USL">USL</label>
                                        <input type="text" name="USL" value="{{ $data->USL }}">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Testing Deadline">Testing Deadline</label>
                                        <input type="date" name="testing_deadline" value="{{ $data->testing_deadline }}">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Planner Name">Planner Name</label>
                                        <input type="text" name="planner_name" value="{{ $data->planner_name }}">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Sample Source">Sample Source</label>
                                        <input type="text" name="sample_source" value="{{ $data->sample_source }}">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Planned Date">Planned Date</label>
                                        <input type="date" name="planned_date" value="{{ $data->planned_date }}">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Lab Technician">Lab Technician</label>
                                        <input type="text" name="lab_technician" value="{{ $data->lab_technician }}">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Sample Cost Estimation">Sample Cost Estimation</label>
                                        <input type="text" name="sample_cost_estimation" value="{{ $data->sample_cost_estimation }}">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Resource Utilization">Resource Utilization</label>
                                        <input type="text" name="resource_utilization" value="{{ $data->resource_utilization }}">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Assigned Department">Assigned Department</label>
                                        <input type="text" name="assigned_department" value="{{ $data->assigned_department }}">
                                    </div>
                                </div> -->

                                <!-- <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Test Grouping">Test Grouping</label>
                                        <input type="text" name="test_grouping2" value="{{ $data->test_grouping2 }}">
                                    </div>
                                </div> -->

                                <!-- <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Sample Collection Date">Sample Collection Date</label>
                                        <input type="date" name="sample_collection_date" value="{{ $data->sample_collection_date }}">
                                    </div>
                                </div> -->
                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="delay_justification">Comment</label>
                                        <div class="relative-container">
                                            <textarea class="tiny" name="samplePreprationComment">{{ $data->samplePreprationComment }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="file Attachments">Supporting Document</label>
                                        <div> <small class="text-primary">Please Attach all relevant or supporting documents</small> </div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="supportive_attachment">
                                                @if ($data->supportive_attachment)
                                                    @foreach (json_decode($data->supportive_attachment) as $file)
                                                        <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                            <b>{{ $file }}</b>
                                                            <a href="{{ asset('upload/' . $file) }}" target="_blank">
                                                                <i class="fa fa-eye text-primary" style="font-size:20px; margin-right:-10px;"></i>
                                                            </a>
                                                            <a type="button" class="remove-file" data-file-name="{{ $file }}">
                                                                <i class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i>
                                                            </a>
                                                        </h6>
                                                    @endforeach
                                                @endif
                                            </div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="hoddfile" name="supportive_attachment[]" oninput="addMultipleFiles(this, 'supportive_attachment')" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="button-block">
                                <button type="submit" id="ChangesaveButton" class="saveButton on-submit-disable-button ">Save</button>
                                <button type="button" id="ChangeNextButton" class="nextButton">Next</button>
                                <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white"> Exit </a> </button>
                            </div>
                        </div>
                    </div>


                    <!-- <div id="CCForm2" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Analysis Type">Analysis Type</label>
                                        <input type="text" name="analysis_type" value="{{ $data->analysis_type }}">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Analysis Result">Analysis Result</label>
                                        <input type="text" name="analysis_result" value="{{ $data->analysis_result }}">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Analysis Date">Analysis Date</label>
                                        <input type="date" name="analysis_date" value="{{ $data->analysis_date }}">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Testing Start Date">Testing Start Date</label>
                                        <input type="date" name="testin_start_date" value="{{ $data->testin_start_date }}">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Testing End Date">Testing End Date</label>
                                        <input type="date" name="testin_End_date" value="{{ $data->testin_End_date }}">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="delay_justification">Delay Justification</label>
                                        <div class="relative-container">
                                            <textarea name="delay_justification">{{ $data->delay_justification }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Testing Outcome">Testing End Date</label>
                                        <input type="date" name="testin_outcome" value="{{ $data->testin_outcome }}">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Pass/Fail">Pass/Fail</label>
                                        <select name="pass_fail">
                                            <option value="">Select Value</option>
                                            <option value="Pass" @if($data->pass_fail == "Pass") selected @endif>Pass</option>
                                            <option value="Fail" @if($data->pass_fail == "Fail") selected @endif>Fail</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Test Plan Id">Test Plan Id</label>
                                        <input type="text" name="test_plan_id" value="{{ $data->test_plan_id }}">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Turnaround Time (TAT)">Turnaround Time (TAT)</label>
                                        <input type="text" name="turnaround_time" value="{{ $data->turnaround_time }}">
                                    </div>
                                </div>


                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Sample Retesting Date">Sample Retesting Date</label>
                                        <input type="date" name="retesting_date" value="{{ $data->retesting_date }}">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Review Date">Review Date</label>
                                        <input type="date" name="review_date" value="{{ $data->review_date }}">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Sample Storage Location">Sample Storage Location</label>
                                        <input type="text" name="storage_location" value="{{ $data->storage_location }}">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Transportation Method">Transportation Method</label>
                                        <input type="text" name="transportation_method" value="{{ $data->transportation_method }}">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="delay_justification">Sample Preparation Method</label>
                                        <div class="relative-container">
                                            <textarea name="sample_prepration_method">{{ $data->sample_prepration_method }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="delay_justification">Sample Packaging Details</label>
                                        <div class="relative-container">
                                            <textarea name="sample_packaging_detail">{{ $data->sample_packaging_detail }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Sample Label">Sample Label</label>
                                        <input type="text" name="sample_lable" value="{{ $data->sample_lable }}">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Regulatory Requirements">Regulatory Requirements</label>
                                        <div class="relative-container">
                                            <textarea name="regulatory_requirement">{{ $data->regulatory_requirement }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Quality Control Checks">Quality Control Checks</label>
                                        <input type="text" name="quality_control_checks" value="{{ $data->quality_control_checks }}">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Control Sample Reference">Control Sample Reference</label>
                                        <input type="text" name="control_sample_reference" value="{{ $data->control_sample_reference }}">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Control Sample">Control Sample</label>
                                        <input type="text" name="control_sample" value="{{ $data->control_sample }}">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Reference Sample">Reference Sample</label>
                                        <input type="text" name="reference_sample" value="{{ $data->reference_sample }}">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Sample Integrity Status">Sample Integrity Status</label>
                                        <select name="sample_integrity_status">
                                            <option value="">Select Status</option>
                                            <option value="Intact" @if($data->sample_integrity_status == "Intact") selected @endif>Intact</option>
                                            <option value="Compromised" @if($data->sample_integrity_status == "Compromised") selected @endif>Compromised</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Assigned Department">Assigned Department</label>
                                        <input type="text" name="assigned_department" value="{{ $data->assigned_department }}">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Risk Assessment">Risk Assessment</label>
                                        <div class="relative-container">
                                            <textarea name="risk_assessment">{{ $data->risk_assessment }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Supervisor">Supervisor</label>
                                        <input type="text" name="supervisor" value="{{ $data->supervisor }}">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Instruments Reserved">Instruments Reserved</label>
                                        <input type="text" name="instruments_reserved" value="{{ $data->instruments_reserved }}">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Lab Availability">Lab Availability</label>
                                        <input type="text" name="lab_availability" value="{{ $data->lab_availability }}">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Sample Date">Sample Date</label>
                                        <input type="date" name="sample_date" value="{{ $data->sample_date }}">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Sample Movement History">Sample Movement History</label>
                                        <div class="relative-container">
                                            <textarea name="sample_movement_history">{{ $data->sample_movement_history }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Testing Progress">Testing Progress</label>
                                        <div class="relative-container">
                                            <textarea name="testing_process">{{ $data->testing_process }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Alerts/Notifications">Alerts/Notifications</label>
                                        <div class="relative-container">
                                            <textarea name="alert_notification">{{ $data->alert_notification }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Deviation Logs">Deviation Logs</label>
                                        <div class="relative-container">
                                            <textarea name="deviation_logs">{{ $data->deviation_logs }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Comments/Notes">Comments/Notes</label>
                                        <div class="relative-container">
                                            <textarea name="comments_logs">{{ $data->comments_logs }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="file Attachments">Attachments</label>
                                        <div> <small class="text-primary">Please Attach all relevant or supporting documents</small> </div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="sample_analysis_attachment">
                                                @if ($data->sample_analysis_attachment)
                                                    @foreach (json_decode($data->sample_analysis_attachment) as $file)
                                                        <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                            <b>{{ $file }}</b>
                                                            <a href="{{ asset('upload/' . $file) }}" target="_blank">
                                                                <i class="fa fa-eye text-primary" style="font-size:20px; margin-right:-10px;"></i>
                                                            </a>
                                                            <a type="button" class="remove-file" data-file-name="{{ $file }}">
                                                                <i class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i>
                                                            </a>
                                                        </h6>
                                                    @endforeach
                                                @endif
                                            </div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="hoddfile" name="sample_analysis_attachment[]" oninput="addMultipleFiles(this, 'sample_analysis_attachment')" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Sampling Frequency">Sampling Frequency</label>
                                        <input type="text" name="sampling_frequency" value="{{ $data->sampling_frequency }}">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Stability Study Type">Stability Study Type</label>
                                        <select name="stability_type">
                                            <option value="">Select Status</option>
                                            <option value="Retained" @if($data->stability_type == "Retained") selected @endif>Retained</option>
                                            <option value="Disposed" @if($data->stability_type == "Disposed") selected @endif>Disposed</option>
                                            <option value="Returned" @if($data->stability_type == "Returned") selected @endif>Returned</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label for="file Attachments">Supporting Document</label>
                                    <div> <small class="text-primary">Please Attach all relevant or supporting documents</small> </div>
                                    <div class="file-attachment-field">
                                        <div class="file-attachment-list" id="supportivesample_analysis_attachment">
                                            @if ($data->supportivesample_analysis_attachment)
                                                @foreach (json_decode($data->supportivesample_analysis_attachment) as $file)
                                                    <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                        <b>{{ $file }}</b>
                                                        <a href="{{ asset('upload/' . $file) }}" target="_blank">
                                                            <i class="fa fa-eye text-primary" style="font-size:20px; margin-right:-10px;"></i>
                                                        </a>
                                                        <a type="button" class="remove-file" data-file-name="{{ $file }}">
                                                            <i class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i>
                                                        </a>
                                                    </h6>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input type="file" id="hoddfile" name="supportivesample_analysis_attachment[]" oninput="addMultipleFiles(this, 'supportivesample_analysis_attachment')" multiple>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="button-block">
                                <button type="submit" id="ChangesaveButton" class="saveButton on-submit-disable-button ">Save</button>
                                <button type="button" id="ChangeNextButton" class="nextButton">Next</button>
                                <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white"> Exit </a> </button>
                            </div>
                        </div>
                    </div> -->

                    <div id="CCForm3" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="Reviewer/Approver">Reviewer/Approver</label>
                                        <select name="reviewer_approver" id="">
                                            <option value="">Select Reviewer/Approver</option>
                                            @if(!empty($users))
                                                @foreach($users as $user)
                                                    <option @if($data->reviewer_approver == $user->id) selected @endif value="{{ $user->id }}">{{ $user->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <!-- <input type="text" name="reviewer_approver" value="{{ $data->reviewer_approver }}"> -->
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="Reviewer Comment">Reviewer Comment</label>
                                        <div class="relative-container">
                                            <textarea class="tiny" name="reviewer_comment">{{ $data->reviewer_comment }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Review Date">Review Date</label>
                                        <input type="date" name="review_date" value="{{ $data->review_date }}">
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="file Attachments">Supervisor Attachments</label>
                                        <div> <small class="text-primary">Please Attach all relevant or supporting documents</small> </div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="supervisor_attachment">
                                                @if ($data->supervisor_attachment)
                                                    @foreach (json_decode($data->supervisor_attachment) as $file)
                                                        <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                            <b>{{ $file }}</b>
                                                            <a href="{{ asset('upload/' . $file) }}" target="_blank">
                                                                <i class="fa fa-eye text-primary" style="font-size:20px; margin-right:-10px;"></i>
                                                            </a>
                                                            <a type="button" class="remove-file" data-file-name="{{ $file }}">
                                                                <i class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i>
                                                            </a>
                                                        </h6>
                                                    @endforeach
                                                @endif
                                            </div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="hoddfile" name="supervisor_attachment[]" oninput="addMultipleFiles(this, 'supervisor_attachment')" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="button-block">
                                <button type="submit" id="ChangesaveButton" class="saveButton on-submit-disable-button ">Save</button>
                                <button type="button" id="ChangeNextButton" class="nextButton">Next</button>
                                <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white"> Exit </a> </button>
                            </div>
                        </div>
                    </div>

                    <!-- <div id="CCForm4" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Stability Study Type">Stability Status</label>
                                        <select name="stability_status">
                                            <option value="">Select Status</option>
                                            <option value="Long Term" @if($data->stability_status == "Long Term") selected @endif>Long Term</option>
                                            <option value="Accelerated" @if($data->stability_status == "Accelerated") selected @endif>Accelerated</option>
                                            <option value="Intermediate" @if($data->stability_status == "Intermediate") selected @endif>Intermediate</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="file Attachments">Stability Study Protocol</label>
                                        <div> <small class="text-primary">Please Attach all relevant or supporting documents</small> </div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="stability_protocol">
                                                @if ($data->stability_protocol)
                                                    @foreach (json_decode($data->stability_protocol) as $file)
                                                        <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                            <b>{{ $file }}</b>
                                                            <a href="{{ asset('upload/' . $file) }}" target="_blank">
                                                                <i class="fa fa-eye text-primary" style="font-size:20px; margin-right:-10px;"></i>
                                                            </a>
                                                            <a type="button" class="remove-file" data-file-name="{{ $file }}">
                                                                <i class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i>
                                                            </a>
                                                        </h6>
                                                    @endforeach
                                                @endif
                                            </div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="hoddfile" name="stability_protocol[]" oninput="addMultipleFiles(this, 'stability_protocol')" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Stability Protocol Approval Date">Stability Protocol Approval Date</label>
                                        <input type="date" name="stability_protocol_date" value="{{ $data->stability_protocol_date }}">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Country of Regulatory Submissions">Country of Regulatory Submissions</label>
                                        <input type="text" name="submission_country" value="{{ $data->submission_country }}">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="ICH ZoneICH Zone">ICH ZoneICH Zone</label>
                                        <input type="text" name="zone" value="{{ $data->zone }}">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Photostability Testing Results">Photostability Testing Results</label>
                                        <input type="text" name="testing_result" value="{{ $data->testing_result }}">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Reconstitution Stability">Reconstitution Stability</label>
                                        <input type="text" name="reconstitution_stability" value="{{ $data->reconstitution_stability }}">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Testing Interval (Months)">Testing Interval (Months)</label>
                                        <select name="testing_interval" id="testing_interval">
                                            <option value="">Select Interval</option>
                                            <?php for ($i = 0; $i <= 60; $i++): ?>
                                                <option value="<?= $i ?>" 
                                                    <?= isset($data->testing_interval) && $data->testing_interval == $i ? 'selected' : '' ?>>
                                                    <?= $i ?> Month
                                                </option>
                                            <?php endfor; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Shelf Life Recommendation">Shelf Life Recommendation</label>
                                        <input type="text" name="shelf_life_recommedation" value="{{ $data->shelf_life_recommedation }}">
                                    </div>
                                </div>
                                
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="file Attachments">Stability Attachment</label>
                                        <div> <small class="text-primary">Please Attach all relevant or supporting documents</small> </div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="stability_attachment">
                                                @if ($data->stability_attachment)
                                                    @foreach (json_decode($data->stability_attachment) as $file)
                                                        <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                            <b>{{ $file }}</b>
                                                            <a href="{{ asset('upload/' . $file) }}" target="_blank">
                                                                <i class="fa fa-eye text-primary" style="font-size:20px; margin-right:-10px;"></i>
                                                            </a>
                                                            <a type="button" class="remove-file" data-file-name="{{ $file }}">
                                                                <i class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i>
                                                            </a>
                                                        </h6>
                                                    @endforeach
                                                @endif
                                            </div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="hoddfile" name="stability_attachment[]" oninput="addMultipleFiles(this, 'stability_attachment')" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="button-block">
                                <button type="submit" id="ChangesaveButton" class="saveButton on-submit-disable-button ">Save</button>
                                <button type="button" id="ChangeNextButton" class="nextButton">Next</button>
                                <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white"> Exit </a> </button>
                            </div>
                        </div>
                    </div> -->

                    <div id="CCForm5" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="QA Reviewer/Approver">QA Reviewer/Approver</label>
                                        <select name="QA_reviewer_approver" id="">
                                            <option value="">Select QA Reviewer/Approver</option>
                                            @if(!empty($users))
                                                @foreach($users as $user)
                                                    <option @if($data->QA_reviewer_approver == $user->id) selected @endif value="{{ $user->id }}">{{ $user->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <!-- <input type="text" name="QA_reviewer_approver" value="{{ $data->QA_reviewer_approver }}"> -->
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="QA Reviewer Comment">QA Reviewer Comment</label>
                                        <div class="relative-container">
                                            <textarea class="tiny" name="QA_reviewer_comment">{{ $data->QA_reviewer_comment }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="QA Review Date">QA Review Date</label>
                                        <input type="date" name="QA_review_date" value="{{ $data->QA_review_date }}">
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="file Attachments">QA Attachment</label>
                                        <div> <small class="text-primary">Please Attach all relevant or supporting documents</small> </div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="QA_attachment">
                                                @if ($data->QA_attachment)
                                                    @foreach (json_decode($data->QA_attachment) as $file)
                                                        <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                            <b>{{ $file }}</b>
                                                            <a href="{{ asset('upload/' . $file) }}" target="_blank">
                                                                <i class="fa fa-eye text-primary" style="font-size:20px; margin-right:-10px;"></i>
                                                            </a>
                                                            <a type="button" class="remove-file" data-file-name="{{ $file }}">
                                                                <i class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i>
                                                            </a>
                                                        </h6>
                                                    @endforeach
                                                @endif
                                            </div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="hoddfile" name="QA_attachment[]" oninput="addMultipleFiles(this, 'QA_attachment')" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="button-block">
                                <button type="submit" id="ChangesaveButton" class="saveButton on-submit-disable-button ">Save</button>
                                <button type="button" id="ChangeNextButton" class="nextButton">Next</button>
                                <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white"> Exit </a> </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Activity Log content -->
                <div id="CCForm6" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="Audit Schedule On">Sample Registration By</label>
                                    <div class="static">{{ $data->sample_registration_by }}</div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="Audit Schedule On">Sample Registration On</label>
                                    <div class="static">{{ $data->sample_registration_on }}</div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="Audit Schedule On">Sample Registration Comment</label>
                                    <div class="static">{{ $data->sample_registration_comment }}</div>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="Audit Preparation Completed On">Analysis Complete By</label>
                                    <div class="static">{{ $data->analysis_complete_by }}</div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="Audit Preparation Completed On">Analysis Complete On</label>
                                    <div class="static">{{ $data->analysis_complete_on }}</div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="Audit Schedule On">Analysis Complete Comment</label>
                                    <div class="static">{{ $data->analysis_complete_comment }}</div>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="Audit Mgr.more Info Reqd By">Supervisor Review Complete By</label>
                                    <div class="static">{{ $data->supervisor_review_by }}</div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="Audit Mgr.more Info Reqd On">Supervisor Review Complete On</label>
                                    <div class="static">{{ $data->supervisor_review_on }}</div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="Audit Schedule On">Supervisor Review Complete Comment</label>
                                    <div class="static">{{ $data->supervisor_review_comment }}</div>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="Cancelled By">QA Review Complete By</label>
                                    <div class="static">{{ $data->QA_Review_by }}</div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="Cancelled On">QA Review Complete On</label>
                                    <div class="static">{{ $data->QA_Review_on }}</div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="Audit Schedule On">QA Review Complete Comment</label>
                                    <div class="static">{{ $data->QA_Review_comment }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="button-block">
                            <!-- <button type="submit" class="saveButton">Save</button> -->
                            <button type="button" class="backButton" onclick="previousStep()">Back</button>
                            <!-- <button type="submit">Submit</button> -->
                            <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                                    Exit </a> </button>
                        </div>
                    </div>
                </div>

        </div>
        </form>

    </div>
    </div>


    <div class="modal fade" id="child-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Child</h4>
                </div>
                <form action="{{ url('rcms/sample-planning-child', $data->id) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="group-input">
                            <label for="minor">
                                <input type="radio" name="revision" id="minor" value="lab-incident">
                                Lab Incident
                            </label>
                            <label for="minor">
                                <input type="radio" name="revision" id="minor" value="action-item">
                                Action Item
                            </label>
                            <label for="minor">
                                <input type="radio" name="revision" id="minor" value="RCA">
                                RCA
                            </label>
                            <label for="minor">
                                <input type="radio" name="revision" id="minor" value="CAPA">
                                CAPA
                            </label>
                            <label for="minor">
                                <input type="radio" name="revision" id="minor" value="OOS-OOT">
                                OOS
                            </label>
                            <label for="minor">
                                <input type="radio" name="revision" id="minor" value="OOS-OOT">
                                OOT
                            </label>
                            <label for="minor">
                                <input type="radio" name="revision" id="minor" value="due-date-extension">
                                Due Date Extension
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-bs-dismiss="modal">Close</button>
                        <button type="submit">Continue</button>
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

                <form action="{{ url('rcms/sample-planning-rejectStage', $data->id) }}" method="POST">
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
                            <input type="comment" name="comments" required>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" data-bs-dismiss="modal">Submit</button>
                        <button type="button" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
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
                <form action="{{ url('rcms/sample-planning-sendStage', $data->id) }}" method="POST">
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
                            <input type="comment" name="comments">
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="submit" data-bs-dismiss="modal">Submit</button>
                        <button type="button" data-bs-dismiss="modal">Close</button>
                        {{-- <button>Close</button> --}}
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
        document.getElementById('myfile').addEventListener('change', function() {
            var fileListDiv = document.querySelector('.file-list');
            fileListDiv.innerHTML = ''; // Clear previous entries

            for (var i = 0; i < this.files.length; i++) {
                var file = this.files[i];
                var listItem = document.createElement('div');
                listItem.textContent = file.name;
                fileListDiv.appendChild(listItem);
            }
        });
    </script>


    <script>
        VirtualSelect.init({
            ele: '#labTechnicians, #Group, #Audit, #analystData ,#reagentData'
        });

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
        var maxLength = 255;
        $('#docname').keyup(function() {
            var textlen = maxLength - $(this).val().length;
            $('#rchars').text(textlen);
        });
    </script>
    <!-- Add the following script at the end of your HTML -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const supplierAgencies = document.getElementById('supplier_agencies');
            const othersGroup = document.getElementById('external_agencies_req');
            const othersField = document.getElementById('others');
            const othersLabel = othersField.previousElementSibling;

            function toggleOthersField(value) {
                if (value === 'others') {
                    othersGroup.style.display = 'block';
                    othersField.required = true;
                    othersLabel.querySelector('span').classList.remove('d-none');
                } else {
                    othersGroup.style.display = 'none';
                    othersField.required = false;
                    othersLabel.querySelector('span').classList.add('d-none');
                }
            }

            // Initial check
            toggleOthersField(supplierAgencies.value);

            // Add event listener
            supplierAgencies.addEventListener('change', function() {
                toggleOthersField(this.value);
            });
        });
    </script>

    <!-- for Voice Access -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const recognition = new(window.SpeechRecognition || window.webkitSpeechRecognition)();
            const docnameInput = document.getElementById('docname');
            const startRecordBtn = document.getElementById('start-record-btn');

            recognition.continuous = false;
            recognition.interimResults = false;
            recognition.lang = 'en-US';

            startRecordBtn.addEventListener('click', function() {
                recognition.start();
            });

            recognition.onresult = function(event) {
                const transcript = event.results[0][0].transcript;
                docnameInput.value += transcript;
            };

            recognition.onerror = function(event) {
                console.error(event.error);
            };
        });
    </script>
    <script>
        < link rel = "stylesheet"
        href = "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" >
    </script>



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize speech recognition
            const recognition = new(window.SpeechRecognition || window.webkitSpeechRecognition)();
            recognition.continuous = false;
            recognition.interimResults = false;
            recognition.lang = 'en-US';

            // Function to start speech recognition and append result to the target element
            function startRecognition(targetElement) {
                recognition.start();
                recognition.onresult = function(event) {
                    const transcript = event.results[0][0].transcript;
                    targetElement.value += transcript;
                };
                recognition.onerror = function(event) {
                    console.error(event.error);
                };
            }


        });
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize speech recognition
            const recognition = new(window.SpeechRecognition || window.webkitSpeechRecognition)();
            recognition.continuous = false;
            recognition.interimResults = false;
            recognition.lang = 'en-US';

            // Function to start speech recognition and append result to the target element
            function startRecognition(targetElement) {
                recognition.start();
                recognition.onresult = function(event) {
                    const transcript = event.results[0][0].transcript;
                    targetElement.value += transcript;
                };
                recognition.onerror = function(event) {
                    console.error(event.error);
                };
            }

            function toggleOthersField(selectedValue) {
                const container = document.getElementById('external_agencies_req');
                if (selectedValue === 'others') {
                    container.classList.remove('d-none');
                } else {
                    container.classList.add('d-none');
                }
            }
        })
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize speech recognition
            const recognition = new(window.SpeechRecognition || window.webkitSpeechRecognition)();
            recognition.continuous = false;
            recognition.interimResults = false;
            recognition.lang = 'en-US';

            // Function to start speech recognition and append result to the target element
            function startRecognition(targetElement) {
                recognition.start();
                recognition.onresult = function(event) {
                    const transcript = event.results[0][0].transcript;
                    targetElement.value += transcript;
                };
                recognition.onerror = function(event) {
                    console.error(event.error);
                };
            }

            function toggleOthersField(selectedValue) {
                const container = document.getElementById('external_agencies_req');
                if (selectedValue === 'others') {
                    container.classList.remove('d-none');
                } else {
                    container.classList.add('d-none');
                }
            }
        });
    </script>



    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <script>
        $(document).ready(function() {
            let audio = null;
            let selectedLanguage = 'en-us'; // Default language
            let inputText = '';

            // When the user clicks the button, open the mini modal
            $(document).on('click', '.speak-btn', function() {
                let inputField = $(this).siblings('textarea, input');
                inputText = inputField.val();
                let modal = $(this).siblings('.mini-modal');
                if (inputText) {
                    // Store the input field element
                    $(modal).data('inputField', inputField);
                    modal.css({
                        display: 'block',
                        top: $(this).position().top - modal.outerHeight() - 10,
                        left: $(this).position().left + $(this).outerWidth() - modal.outerWidth()
                    });
                }
            });

            // When the user clicks on <span> (x), close the mini modal
            $(document).on('click', '.close', function() {
                $(this).closest('.mini-modal').css('display', 'none');
            });

            // When the user selects a language and clicks the button
            $(document).on('click', '#select-language-btn', function(event) {
                event.preventDefault(); // Prevent form submission
                let modal = $(this).closest('.mini-modal');
                selectedLanguage = modal.find('#language-select').val();
                let inputField = modal.data('inputField');
                let textToSpeak = inputText;

                if (textToSpeak) {
                    if (audio) {
                        audio.pause();
                        audio.currentTime = 0;
                    }

                    // Translate the text before converting to speech
                    translateText(textToSpeak, selectedLanguage.split('-')[0]).then(translatedText => {
                        const apiKey = '2273705f1f6f434194956a200a586470';
                        const url =
                            `https://api.voicerss.org/?key=${apiKey}&hl=${selectedLanguage}&src=${encodeURIComponent(translatedText)}&r=0&c=WAV&f=44khz_16bit_stereo`;
                        audio = new Audio(url);
                        audio.play();
                        audio.onended = function() {
                            audio = null;
                        };
                    });

                }

                modal.css('display', 'none');
            });

            // Speech-to-Text functionality
            const recognition = new(window.SpeechRecognition || window.webkitSpeechRecognition)();
            recognition.continuous = false;
            recognition.interimResults = false;
            recognition.lang = 'en-US';

            function startRecognition(targetElement) {
                recognition.start();
                recognition.onresult = function(event) {
                    const transcript = event.results[0][0].transcript;
                    targetElement.value += transcript;
                };
                recognition.onerror = function(event) {
                    console.error(event.error);
                };
            }


            async function translateText(text, targetLanguage) {
                const url = 'https://text-translator2.p.rapidapi.com/translate';
                const data = new FormData();
                data.append('source_language', 'en');
                data.append('target_language', targetLanguage);
                data.append('text', text);

                const options = {
                    method: 'POST',
                    headers: {
                        'x-rapidapi-key': '5246c9098fmshc966ee7f6cea588p14a110jsn3979434fe858',
                        'x-rapidapi-host': 'text-translator2.p.rapidapi.com'
                    },
                    body: data
                };

                const response = await fetch(url, options);
                const result = await response.json();
                return result.data.translatedText;
            }

            // Update remaining characters
            $('#docname').on('input', function() {
                const remaining = 255 - $(this).val().length;
                $('#rchars').text(remaining);
            });

            // Initialize remaining characters count
            const remaining = 255 - $('#docname').val().length;
            $('#rchars').text(remaining);
        });
    </script>


    <style>
        #external_agencies_req {
            display: none;
        }
    </style>
    <script>
        $(document).ready(function() {

            $('.mainform').on('submit', function(e) {
                $('.on-submit-disable-button').prop('disabled', true);
            });

            $('.instrument-select').each(function() {
                VirtualSelect.init({
                    ele: '#' + $(this).attr('id'),
                    multiple: true
                });
            });
        })
    </script>
@endsection
