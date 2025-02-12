@extends('frontend.layout.main')
@section('container')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
<style>
    #fr-logo {
        display: none;
    }

    .fr-logo {
        display: none;
    }

    textarea.note-codable {
        display: none !important;
    }

    header {
        display: none;
    }

    .group-input table input,
    .group-input table select {
        border: 0;
        margin: 0 !important;
        padding: 0 !important;
    }

    .sop-type-header {
        display: grid;
        grid-template-columns: 135px 1fr;
        border: 2px solid #000000;
        margin-bottom: 20px;
    }

    .main-head {
        display: grid;
        place-items: center;
        align-content: center;
        font-size: 1.2rem;
        font-weight: 700;
        border-left: 2px solid #000000;
    }

    .sub-head-2 {
        text-align: center;
        background: #4274da;
        margin-bottom: 20px;
        padding: 10px 20px;
        font-size: 1.5rem;
        color: #fff;
        border: 2px solid #000000;
        border-radius: 40px;
    }

    #displayField {
        border: 1px solid #f0f0f0;
        background: white;
        padding: 20px;
        position: relative;
        display: flex;
        align-items: center;
    }

    #displayField li {
        margin-left: 1rem;
        background-color: #f0f0f0;
        padding: 5px;
    }

    .close-icon {
        color: red;
        margin-left: auto;
        /* Pushes the icon to the right */
        cursor: pointer;
    }

    /* Floating Button Styles */
    .floating-btn {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: #175ab8;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            color: white;
            font-size: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .floating-btn:hover {
            transform: scale(1.1);
        }

        /* Custom Modal Animation */
        .modal.animate .modal-dialog {
            transform: translateY(100vh);
            transition: transform 0.4s ease-out;
        }

        .modal.animate.show .modal-dialog {
            transform: translateY(0);
        }

        /* Modal Styling */
        .modal-content {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.15);
        }

        .modal-header {
            background: linear-gradient(to right,12px 12px 24px #fae1c4, -12px -12px 24px #fde0bf));
            color: white;
        }

        .modal-header .btn-close {
            filter: brightness(80%);
        }

        .modal-header .btn-close:hover {
            filter: brightness(100%);
        }

        /* Modal Body Custom Styling */
        .modal-body {
            padding: 30px;
            font-size: 16px;
            color: #4e4e4e;
            line-height: 1.6;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .modal-body h5 {
            margin-bottom: 15px;
            font-weight: 600;
        }

        /* Primary Button Styling */
        .modal-footer .btn-primary {
            background-color: #175ab8;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .modal-footer .btn-primary:hover {
            background-color: #094292;
        }

        /* Animation for Floating Button */
        @keyframes buttonPop {
            0% { transform: scale(0); }
            100% { transform: scale(1); }
        }

        .floating-btn {
            animation: buttonPop 0.5s ease-out forwards;
        }
</style>
<?php $division_id = isset($_GET['id']) ? $_GET['id'] : ''; ?>
<div id="data-field-head">
    <div class="pr-id">
        New Document
    </div>
    @if(isset($_GET['id']))
    <div class="division-bar">
        <strong>Site Division/Project</strong> :
        {{ Helpers::getDivisionName($_GET['id'])}} / Document
        {{-- {{ $division->dname }} / {{ $division->pname }} --}}
    </div>
    @endif
</div>

<div id="data-fields">

    <div class="container-fluid">

        <div class="floating-btn" id="openModalButton">
            <i class="fa-solid fa-microchip"></i>            
        </div>


        <div class="modal animate fade" id="customModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="fas fa-brain"></i> AI-Powered EDMS</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h5>Welcome to AI-Enhanced EDMS</h5>
                        <p>Experience the future of Electronic Document Management with the power of Artificial Intelligence. Our system leverages advanced AI algorithms to streamline document handling, automate content generation, and enhance compliance.</p>
                        <p><b>Why Use AI in EDMS?</b></p>
                        <ul>
                            <li>Automated document classification and organization.</li>
                            <li>Intelligent data extraction and summarization.</li>
                            <li>Enhanced security with AI-based monitoring.</li>
                            <li>Real-time insights and analytics for better decision-making.</li>
                        </ul>
                        <div class="mb-4" style="width: 100%">
                            <label for="userPrompt" class="form-label">Tell us how we can help:</label>
                            <textarea id="userPrompt" class="form-control" name="ai_prompt" placeholder="Type your request here..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" id="submitPrompt" class="btn btn-primary">Submit Request</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab">
            <button class="tablinks active" onclick="openData(event, 'doc-info')" id="defaultOpen">General information</button>
            <button class="tablinks" onclick="openData(event, 'drafters')">Author Input</button>
            <button class="tablinks" onclick="openData(event, 'hodcft')">HODs Input</button>
            <button class="tablinks" onclick="openData(event, 'qa')">QA Input</button>
            <button class="tablinks" onclick="openData(event, 'reviewers')">Reviewer Input</button>
            <button class="tablinks" onclick="openData(event, 'approvers')">Approver Input</button>
            <button class="tablinks" onclick="openData(event, 'add-doc')">Training Information</button>
            <button class="tablinks" onclick="openData(event, 'doc-content')">Document Content</button>
            <!-- <button class="tablinks" onclick="openData(event, 'hod-remarks-tab')">HOD Remarks</button> -->
            <button class="tablinks" onclick="openData(event, 'annexures')">Annexures</button>
            <button class="tablinks" onclick="openData(event, 'distribution-retrieval')">Distribution & Retrieval</button>
            <button class="tablinks" onclick="openData(event, 'sign')">Signature</button>
            <button class="tablinks printdoc" style="float: right;" onclick="window.print();return false;">Print</button>
        </div>

        <form id="document-form" action="{{ route('documents.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div id="step-form">
                <!-- Tab content -->
                <div id="doc-info" class="tabcontent">

                    <div class="input-fields">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="group-input">
                                    <label for="originator">Originator</label>
                                    <div class="default-name">{{ Auth::user()->name }}</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="group-input">
                                    <label for="open-date">Date Opened</label>
                                    <div class="default-name"> {{ date('d-M-Y') }}</div>
                                </div>
                            </div>
                            {{-- <div class="col-md-4">
                                    <div class="group-input">
                                        <label for="record-num">Record Number</label>
                                        <div class="default-name">{{ $recordNumber }}
                        </div>
                    </div>
                </div> --}}

                <div class="col-lg-12">
                    <div class="group-input">
                        @if(isset($_GET['id']))
                        <label for="Division Code"><b>Site/Location Code</b></label>
                        <input readonly type="text" name="division_id" value="{{ Helpers::getDivisionName($_GET['id'])}}">
                        <input type="hidden" name="division_id" value="{{$_GET['id']}}">
                        @else
                        <label for="Division Code"><b>Site/Location Code </b></label>
                        <input readonly type="text" name="division_code" value="{{ Helpers::getDivisionName(session()->get('division')) }}">
                        <input type="hidden" name="division_id" value="{{ session()->get('division') }}">
                        @endif
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="group-input">
                        <label for="document_name-desc">Document Name<span class="text-danger">*</span></label><span id="rchars">255</span>
                        characters remaining
                        <div class="relative-container">                                            
                            <input id="docname" type="text" name="document_name" maxlength="255" required>
                            @component('frontend.forms.language-model')
                            @endcomponent
                        </div>
                    </div>
                    <p id="docnameError" style="color:red">**Document Name is required</p>

                </div>


                <div class="col-md-12">
                    <div class="group-input">
                        <label for="short-desc">Short Description<span class="text-danger">*</span></label>
                        <span id="new-rchars">255</span>
                        characters remaining
                        <div class="relative-container">                                            
                            <input type="text" id="short_desc" name="short_desc" maxlength="255">
                            @component('frontend.forms.language-model')
                            @endcomponent
                        </div>
                    </div>
                    <p id="short_descError" style="color:red">**Short description is required</p>

                </div>
                <div class="col-md-6">
                    <div class="group-input">
                        <label for="cc_reference_record">Change Control Reference Records</label>
                        <select id="choices-multiple-remove-button" class="choices-multiple-reviewer" name="cc_reference_record[]" placeholder="Select Reference Records" multiple>
                            @foreach ($ccrecord as $document)
                            <option value="{{ $document->id }}">
                                {{ Helpers::getDivisionName($document->division_id)}}/CC/{{date('Y')}}/{{Helpers::recordFormat($document->record)}}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">

                </div>
                <div class="col-md-6">
                    <div class="group-input">
                        <label for="doc-type">Document Type<span class="text-danger">*</span></label>
                        <select name="document_type_id" id="doc-type" required>
                            <option value="" selected>Enter your Selection</option>
                            @foreach (Helpers::getDocumentTypes() as $code => $type)
                            <option data-id="{{ $code }}" value="{{ $code }}">
                                {{ $type }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <p id="doc-typeError" style="color:red">** Document is required</p>

                </div>
                <div class="col-md-6">
                    <div class="group-input">
                        <label for="doc-code">Document Type Code</label>
                        <div class="default-name"> <span id="document_type_code">Not selected</span></div>
                    </div>
                </div>

                <div class="col-md-6 new-date-data-field">
                    <div class="group-input input-date">
                        <label for="due-date">Due Date <span class="text-danger">*</span></label>
                        <div><small class="text-primary">Kindly Fill Target Date of Completion</small>
                        </div>
                        <div class="calenderauditee">
                            <input type="text" name="due_dateDoc" id="due_dateDoc" readonly placeholder="DD-MMM-YYYY" />
                            <input type="date" id="due_dateDoc" name="due_dateDoc" pattern="\d{4}-\d{2}-\d{2}" class="hide-input" min="{{ Carbon\Carbon::today()->format('Y-m-d') }}" oninput="handleDateInput(this, 'due_dateDoc')" />
                        </div>
                    </div>
                    <p id="due_dateDocError" style="color:red">**Due Date is required</p>

                </div>
                <div class="col-md-2 new-date-data-field">
                    <div class="group-input ">
                        <label for="review-period">Priodic Review Notification (in days)</label>

                        <input type="number" name="priodic_review" id="priodic_review" style="margin-top: 25px;" value="" min="0">
                    </div>
                </div>
                <div class="col-md-12">
                                    <div class="group-input">
                                        <label for="depart-name">Department Name<span class="text-danger">*</span></label>
                                        <select name="department_id" id="depart-name" required>
                                            <option value="" selected>Enter your Selection</option>
                                            <option value="CQA" @if (old('department_id') == 'CQA') selected @endif>
                                                Corporate Quality Assurance</option>
                                            <option value="QAB" @if (old('department_id') == 'QAB') selected @endif>Quality
                                                Assurance Biopharma</option>
                                            <option value="CQC" @if (old('department_id') == 'CQA') selected @endif>Central
                                                Quality Control</option>
                                            <option value="MANU" @if (old('department_id') == 'MANU') selected @endif>
                                                Manufacturing</option>
                                            <option value="PSG" @if (old('department_id') == 'PSG') selected @endif>Plasma
                                                Sourcing Group</option>
                                            <option value="CS" @if (old('department_id') == 'CS') selected @endif>Central
                                                Stores</option>
                                            <option value="ITG" @if (old('department_id') == 'ITG') selected @endif>
                                                Information Technology Group</option>
                                            <option value="MM" @if (old('department_id') == 'MM') selected @endif>
                                                Molecular Medicine</option>
                                            <option value="CL" @if (old('department_id') == 'CL') selected @endif>
                                                Central Laboratory</option>
                                            <option value="TT" @if (old('department_id') == 'TT') selected @endif>Tech
                                                Team</option>
                                            <option value="QA" @if (old('department_id') == 'QA') selected @endif>
                                                Quality Assurance</option>
                                            <option value="QM" @if (old('department_id') == 'QM') selected @endif>
                                                Quality Management</option>
                                            <option value="IA" @if (old('department_id') == 'IA') selected @endif>IT
                                                Administration</option>
                                            <option value="ACC" @if (old('department_id') == 'ACC') selected @endif>
                                                Accounting</option>
                                            <option value="LOG" @if (old('department_id') == 'LOG') selected @endif>
                                                Logistics</option>
                                            <option value="SM" @if (old('department_id') == 'SM') selected @endif>
                                                Senior Management</option>
                                            <option value="BA" @if (old('department_id') == 'BA') selected @endif>
                                                Business Administration</option>
                                            <option value="others" @if (old('department_id') == 'others') selected @endif>
                                                Others</option>
                                            {{-- @foreach ($departments as $department)
                                                <option data-id="{{ $department->dc }}" value="{{ $department->id }}">
                                                    {{ $department->name }}</option>
                                            @endforeach --}}
                                        </select>
                                    </div>
                                    <p id="depart-nameError" style="color:red">** Department is required</p>
                                </div>
        <div class="col-6">
            <div class="group-input">
                <label for="major">Document Version <small>(Major)</small> <span class="text-danger">*</span>
                    <span class="text-primary" data-bs-toggle="modal" data-bs-target="#document-management-system-modal" style="font-size: 0.8rem; font-weight: 400;">
                        (Launch Instruction)
                    </span>
                </label>
                <input type="number" name="major" id="major" min="0" required>
            </div>
            {{-- <p id="majorError" style="color:red">** Department is required</p> --}}
        </div>

       <div class="col-6">
            <div class="group-input">
                <label for="minor">Document Version <small>(Minor)</small><span class="text-danger">*</span>
                    <span class="text-primary" data-bs-toggle="modal" data-bs-target="#document-management-system-modal-minor" style="font-size: 0.8rem; font-weight: 400;">
                        (Launch Instruction)
                    </span>
                </label>
                <input type="number" name="minor" id="minor" min="0" max="9" required>

            </div>
        </div> 


<div class="col-md-6">
    <div class="group-input">
        <label for="doc-lang">Document Language</label>
        <select name="document_language_id" id="doc-lang">
            <option value="" selected>Enter your Selection</option>
            @foreach ($documentLanguages as $lan)
            <option data-id="{{ $lan->lcode }}" value="{{ $lan->id }}">
                {{ $lan->lname }}
            </option>
            @endforeach
        </select>
    </div>
</div>
<div class="col-md-6">
    <div class="group-input">
        <label for="doc-lang">Document Language Code</label>
        <div class="default-name"><span id="document_language">Not selected</span></div>
    </div>
</div>
        
                <div class="col-md-5 new-date-data-field">
                    <div class="group-input input-date">
                        <label for="effective-date">Effective Date</label>
                        <div> <small class="text-primary">The effective date will be automatically populated once the record becomes effective</small></div>
                        <div class="calenderauditee">
                            <input type="text" name="effective_date" id="effective_date" placeholder="DD-MMM-YYYY" />
                            <input type="date" name="effective_date" id="effective_date" class="hide-input" min="{{ Carbon\Carbon::today()->format('Y-m-d') }}" oninput="handleDateInput(this, 'effective_date')" />
                        </div>
                    </div>
                </div>

                <div class="col-md-2 new-date-data-field">
                    <div class="group-input ">
                        <label for="review-period">Review Period (in years)</label>

                        <input type="number" name="review_period" id="review_period" style="margin-top: 25px;" value="3" min="0" oninput="validateInput(this)">
                    </div>
                </div>
                <script>
                    function validateInput(input) {
                        if (input.value < 0) {
                            input.value = 0;
                        }
                    }
                </script>

                <div class="col-md-5 new-date-data-field">
                    <div class="group-input input-date">
                        <label for="next_review_date">Next Review Date</label>
                        <div class="calenderauditee">
                            <input type="text" name="next_review_date" id="next_review_date" style="margin-top: 25px;" class="new_review_date_show" readonly placeholder="DD-MMM-YYYY" />
                            <input type="date" name="next_review_date" id="next_review_date" class="hide-input new_review_date_hide" readonly min="{{ Carbon\Carbon::today()->format('Y-m-d') }}" oninput="handleDateInput(this, 'next_review_date')" />
                        </div>
                    </div>
                </div>


                <div class="col-md-6">
                    <div class="group-input">
                        <label for="draft-doc">Attach Draft document</label>
                        <input type="file" name="attach_draft_doocument">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="group-input">
                        <label for="effective-doc">Attach Effective document</label>
                        <input type="file" name="attach_effective_docuement">
                    </div>
                </div>

            </div>
    </div>
    <div class="orig-head">
        Other Information
    </div>
    <div class="input-fields">
        <div class="row">
            <div class="col-md-6">
                <div class="group-input">
                    <label for="drafter">Author<span class="text-danger">*</span></label>
                    <select id="choices-multiple-remove-button" class="choices-multiple-reviewer" name="drafters[]" placeholder="Select Author" multiple required>
                        @if (!empty($drafter))
                        @foreach ($drafter as $lan)
                        @if(Helpers::checkUserRolesDrafter($lan))
                        <option value="{{ $lan->id }}">
                            {{ $lan->name }}
                        </option>
                        @endif
                        @endforeach
                        @endif
                    </select>
                </div>

            </div>

            <div class="col-md-6">
                <div class="group-input">
                    <label for="hods">HODs<span class="text-danger">*</span></label>
                    <select id="choices-multiple-remove-button" class="choices-multiple-reviewer" name="hods[]" placeholder="Select HODs" multiple required>
                        @foreach ($hods as $hod)
                        <option value="{{ $hod->id }}">
                            {{ $hod->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="group-input">
                    <label for="hods">QAs<span class="text-danger">*</span></label>
                    <select id="choices-multiple-remove-button" class="choices-multiple-reviewer" name="qa[]" placeholder="Select QAs" multiple required>
                        @foreach ($qa as $hod)
                        <option value="{{ $hod->id }}">
                            {{ $hod->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="group-input">
                    <label for="reviewers">Reviewers<span class="text-danger">*</span></label>
                    <select id="choices-multiple-remove-button" class="choices-multiple-reviewer" name="reviewers[]" placeholder="Select Reviewers" multiple required>
                        @if (!empty($reviewer))
                        @foreach ($reviewer as $lan)
                        @if(Helpers::checkUserRolesreviewer($lan))
                        <option value="{{ $lan->id }}">
                            {{ $lan->name }}
                        </option>
                        @endif
                        @endforeach
                        @endif
                    </select>

                </div>
                {{-- <p id="reviewerError" style="color:red">** Reviewers are required</p> --}}
            </div>
            <div class="col-md-6">
                <div class="group-input">
                    <label for="approvers">Approvers<span class="text-danger">*</span></label>
                    <select id="choices-multiple-remove-button" class="choices-multiple-reviewer" name="approvers[]" placeholder="Select Approvers" multiple required>
                        @if (!empty($approvers))
                        @foreach ($approvers as $lan)
                        @if(Helpers::checkUserRolesApprovers($lan))
                        <option value="{{ $lan->id }}">
                            {{ $lan->name }}
                        </option>
                        @endif
                        @endforeach
                        @endif
                    </select>
                </div>
                <p id="approverError" style="color:red">** Approvers are required</p>
            </div>


        </div>
    </div>
    <div class="orig-head">
        Product Material Information
    </div>
    <div class="input-fields">
        <div class="row">
            <div class="col-lg-6 mb-3">
                <div class="group-input">
                    <label for="Warehousefeedback">Product Material Name</label>
                    <input  type="text" name="product_material_name" >
                </div>
            </div>

            <div class="col-lg-6 mb-3">
                <div class="group-input">
                    <label for="Warehousefeedback">Product Material Type</label>
                    {{-- <input  type="text" name="product_material_type" > --}}
                    <select name="product_material_type">
                        <option value="">--Select--</option>
                        <option value="RM">RM</option>
                        <option value="PM">PM</option>
                        <option value="SPG">SPG</option>
                        <option value="FG">FG</option>
                    </select>
                </div>
            </div>
            <div class="col-lg-6 mb-3">
                <div class="group-input">
                    <label for="Warehousefeedback">Product Material Code</label>
                    <input  type="text" name="product_material_code" >
                </div>
            </div>
            <div class="col-lg-6 mb-3">
                <div class="group-input">
                    <label for="Warehousefeedback">Product Material Market</label>
                    <select name="product_material_market" id="product_material_market">
                        <option value="">--Select--</option>
                        <option value="Afghanistan">Afghanistan</option>
                        <option value="Albania">Albania</option>
                        <option value="Algeria">Algeria</option>
                        <option value="American Samoa">American Samoa</option>
                        <option value="Andorra">Andorra</option>
                        <option value="Angola">Angola</option>
                        <option value="Anguilla">Anguilla</option>
                        <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                        <option value="Argentina">Argentina</option>
                        <option value="Armenia">Armenia</option>
                        <option value="Aruba">Aruba</option>
                        <option value="Australia">Australia</option>
                        <option value="Austria">Austria</option>
                        <option value="Azerbaijan">Azerbaijan</option>
                        <option value="Bahamas">Bahamas</option>
                        <option value="Bahrain">Bahrain</option>
                        <option value="Bangladesh">Bangladesh</option>
                        <option value="Barbados">Barbados</option>
                        <option value="Belarus">Belarus</option>
                        <option value="Belgium">Belgium</option>
                        <option value="Belize">Belize</option>
                        <option value="Benin">Benin</option>
                        <option value="Bermuda">Bermuda</option>
                        <option value="Bhutan">Bhutan</option>
                        <option value="Bolivia">Bolivia</option>
                        <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
                        <option value="Botswana">Botswana</option>
                        <option value="Brazil">Brazil</option>
                        <option value="Brunei Darussalam">Brunei Darussalam</option>
                        <option value="Bulgaria">Bulgaria</option>
                        <option value="Burkina Faso">Burkina Faso</option>
                        <option value="Burundi">Burundi</option>
                        <option value="Cambodia">Cambodia</option>
                        <option value="Cameroon">Cameroon</option>
                        <option value="Canada">Canada</option>
                        <option value="Cape Verde">Cape Verde</option>
                        <option value="Cayman Islands">Cayman Islands</option>
                        <option value="Central African Republic">Central African Republic</option>
                        <option value="Chad">Chad</option>
                        <option value="Chile">Chile</option>
                        <option value="China">China</option>
                        <option value="Colombia">Colombia</option>
                        <option value="Comoros">Comoros</option>
                        <option value="Congo">Congo</option>
                        <option value="Congo (Democratic Republic)">Congo (Democratic Republic)</option>
                        <option value="Cook Islands">Cook Islands</option>
                        <option value="Costa Rica">Costa Rica</option>
                        <option value="Côte d'Ivoire">Côte d'Ivoire</option>
                        <option value="Croatia">Croatia</option>
                        <option value="Cuba">Cuba</option>
                        <option value="Cyprus">Cyprus</option>
                        <option value="Czech Republic">Czech Republic</option>
                        <option value="Denmark">Denmark</option>
                        <option value="Djibouti">Djibouti</option>
                        <option value="Dominica">Dominica</option>
                        <option value="Dominican Republic">Dominican Republic</option>
                        <option value="Ecuador">Ecuador</option>
                        <option value="Egypt">Egypt</option>
                        <option value="El Salvador">El Salvador</option>
                        <option value="Equatorial Guinea">Equatorial Guinea</option>
                        <option value="Eritrea">Eritrea</option>
                        <option value="Estonia">Estonia</option>
                        <option value="Ethiopia">Ethiopia</option>
                        <option value="Falkland Islands">Falkland Islands</option>
                        <option value="Faroe Islands">Faroe Islands</option>
                        <option value="Fiji">Fiji</option>
                        <option value="Finland">Finland</option>
                        <option value="France">France</option>
                        <option value="French Guiana">French Guiana</option>
                        <option value="French Polynesia">French Polynesia</option>
                        <option value="Gabon">Gabon</option>
                        <option value="Gambia">Gambia</option>
                        <option value="Georgia">Georgia</option>
                        <option value="Germany">Germany</option>
                        <option value="Ghana">Ghana</option>
                        <option value="Gibraltar">Gibraltar</option>
                        <option value="Greece">Greece</option>
                        <option value="Greenland">Greenland</option>
                        <option value="Grenada">Grenada</option>
                        <option value="Guadeloupe">Guadeloupe</option>
                        <option value="Guam">Guam</option>
                        <option value="Guatemala">Guatemala</option>
                        <option value="Guernsey">Guernsey</option>
                        <option value="Guinea">Guinea</option>
                        <option value="Guinea-Bissau">Guinea-Bissau</option>
                        <option value="Guyana">Guyana</option>
                        <option value="Haiti">Haiti</option>
                        <option value="Honduras">Honduras</option>
                        <option value="Hong Kong">Hong Kong</option>
                        <option value="Hungary">Hungary</option>
                        <option value="Iceland">Iceland</option>
                        <option value="India">India</option>
                        <option value="Indonesia">Indonesia</option>
                        <option value="Iran">Iran</option>
                        <option value="Iraq">Iraq</option>
                        <option value="Ireland">Ireland</option>
                        <option value="Israel">Israel</option>
                        <option value="Italy">Italy</option>
                        <option value="Jamaica">Jamaica</option>
                        <option value="Japan">Japan</option>
                        <option value="Jersey">Jersey</option>
                        <option value="Jordan">Jordan</option>
                        <option value="Kazakhstan">Kazakhstan</option>
                        <option value="Kenya">Kenya</option>
                        <option value="Kiribati">Kiribati</option>
                        <option value="Kuwait">Kuwait</option>
                        <option value="Kyrgyzstan">Kyrgyzstan</option>
                        <option value="Laos">Laos</option>
                        <option value="Latvia">Latvia</option>
                        <option value="Lebanon">Lebanon</option>
                        <option value="Lesotho">Lesotho</option>
                        <option value="Liberia">Liberia</option>
                        <option value="Libya">Libya</option>
                        <option value="Liechtenstein">Liechtenstein</option>
                        <option value="Lithuania">Lithuania</option>
                        <option value="Luxembourg">Luxembourg</option>
                        <option value="Macao">Macao</option>
                        <option value="North Macedonia">North Macedonia</option>
                        <option value="Madagascar">Madagascar</option>
                        <option value="Malawi">Malawi</option>
                        <option value="Malaysia">Malaysia</option>
                        <option value="Maldives">Maldives</option>
                        <option value="Mali">Mali</option>
                        <option value="Malta">Malta</option>
                        <option value="Marshall Islands">Marshall Islands</option>
                        <option value="Martinique">Martinique</option>
                        <option value="Mauritania">Mauritania</option>
                        <option value="Mauritius">Mauritius</option>
                        <option value="Mayotte">Mayotte</option>
                        <option value="Mexico">Mexico</option>
                        <option value="Micronesia">Micronesia</option>
                        <option value="Moldova">Moldova</option>
                        <option value="Monaco">Monaco</option>
                        <option value="Mongolia">Mongolia</option>
                        <option value="Montenegro">Montenegro</option>
                        <option value="Morocco">Morocco</option>
                        <option value="Mozambique">Mozambique</option>
                        <option value="Myanmar">Myanmar</option>
                        <option value="Namibia">Namibia</option>
                        <option value="Nauru">Nauru</option>
                        <option value="Nepal">Nepal</option>
                        <option value="Netherlands">Netherlands</option>
                        <option value="New Caledonia">New Caledonia</option>
                        <option value="New Zealand">New Zealand</option>
                        <option value="Nicaragua">Nicaragua</option>
                        <option value="Niger">Niger</option>
                        <option value="Nigeria">Nigeria</option>
                        <option value="Niue">Niue</option>
                        <option value="Norfolk Island">Norfolk Island</option>
                        <option value="North Korea">North Korea</option>
                        <option value="Northern Mariana Islands">Northern Mariana Islands</option>
                        <option value="Norway">Norway</option>
                        <option value="Oman">Oman</option>
                        <option value="Pakistan">Pakistan</option>
                        <option value="Palau">Palau</option>
                        <option value="Panama">Panama</option>
                        <option value="Papua New Guinea">Papua New Guinea</option>
                        <option value="Paraguay">Paraguay</option>
                        <option value="Peru">Peru</option>
                        <option value="Philippines">Philippines</option>
                        <option value="Pitcairn Islands">Pitcairn Islands</option>
                        <option value="Poland">Poland</option>
                        <option value="Portugal">Portugal</option>
                        <option value="Puerto Rico">Puerto Rico</option>
                        <option value="Qatar">Qatar</option>
                        <option value="Romania">Romania</option>
                        <option value="Russia">Russia</option>
                        <option value="Rwanda">Rwanda</option>
                        <option value="Réunion">Réunion</option>
                        <option value="Saint Barthélemy">Saint Barthélemy</option>
                        <option value="Saint Helena, Ascension and Tristan da Cunha">Saint Helena, Ascension and Tristan da Cunha</option>
                        <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
                        <option value="Saint Lucia">Saint Lucia</option>
                        <option value="Saint Martin (French part)">Saint Martin (French part)</option>
                        <option value="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option>
                        <option value="Saint Vincent and the Grenadines">Saint Vincent and the Grenadines</option>
                        <option value="Samoa">Samoa</option>
                        <option value="San Marino">San Marino</option>
                        <option value="Sao Tome and Principe">Sao Tome and Principe</option>
                        <option value="Saudi Arabia">Saudi Arabia</option>
                        <option value="Senegal">Senegal</option>
                        <option value="Serbia">Serbia</option>
                        <option value="Seychelles">Seychelles</option>
                        <option value="Sierra Leone">Sierra Leone</option>
                        <option value="Singapore">Singapore</option>
                        <option value="Sint Maarten (Dutch part)">Sint Maarten (Dutch part)</option>
                        <option value="Slovakia">Slovakia</option>
                        <option value="Slovenia">Slovenia</option>
                        <option value="Solomon Islands">Solomon Islands</option>
                        <option value="Somalia">Somalia</option>
                        <option value="South Africa">South Africa</option>
                        <option value="South Georgia and the South Sandwich Islands">South Georgia and the South Sandwich Islands</option>
                        <option value="South Korea">South Korea</option>
                        <option value="South Sudan">South Sudan</option>
                        <option value="Spain">Spain</option>
                        <option value="Sri Lanka">Sri Lanka</option>
                        <option value="Sudan">Sudan</option>
                        <option value="Suriname">Suriname</option>
                        <option value="Svalbard and Jan Mayen">Svalbard and Jan Mayen</option>
                        <option value="Eswatini">Eswatini</option>
                        <option value="Sweden">Sweden</option>
                        <option value="Switzerland">Switzerland</option>
                        <option value="Syria">Syria</option>
                        <option value="Taiwan">Taiwan</option>
                        <option value="Tajikistan">Tajikistan</option>
                        <option value="Tanzania">Tanzania</option>
                        <option value="Thailand">Thailand</option>
                        <option value="Timor-Leste">Timor-Leste</option>
                        <option value="Togo">Togo</option>
                        <option value="Tokelau">Tokelau</option>
                        <option value="Tonga">Tonga</option>
                        <option value="Trinidad and Tobago">Trinidad and Tobago</option>
                        <option value="Tunisia">Tunisia</option>
                        <option value="Turkey">Turkey</option>
                        <option value="Turkmenistan">Turkmenistan</option>
                        <option value="Tuvalu">Tuvalu</option>
                        <option value="Uganda">Uganda</option>
                        <option value="Ukraine">Ukraine</option>
                        <option value="United Arab Emirates">United Arab Emirates</option>
                        <option value="United Kingdom">United Kingdom</option>
                        <option value="United States">United States</option>
                        <option value="Uruguay">Uruguay</option>
                        <option value="Uzbekistan">Uzbekistan</option>
                        <option value="Vanuatu">Vanuatu</option>
                        <option value="Vatican City">Vatican City</option>
                        <option value="Venezuela">Venezuela</option>
                        <option value="Vietnam">Vietnam</option>
                        <option value="Western Sahara">Western Sahara</option>
                        <option value="Yemen">Yemen</option>
                        <option value="Zambia">Zambia</option>
                        <option value="Zimbabwe">Zimbabwe</option>
                    </select>
                </div>
            </div>

    <div class="orig-head">
        Initiator Information
    </div>
    <div class="input-fields">
        <div class="row">

            <div class="col-lg-12">
                <div class="group-input">
                    <label for="Audit Attachments">Initial Attachments</label>
                    <div><small class="text-primary">Please Attach all relevant or supporting
                            documents</small></div>
                    <div class="file-attachment-field">
                        <div class="file-attachment-list" id="initial_attachments"></div>
                        <div class="add-btn">
                            <div>Add</div>
                            <input disabled type="file" id="initial_attachments" name="initial_attachments[]" onclick="addMultipleFiles(this, 'initial_attachments')" multiple>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-3">
                <div class="group-input">
                    <label for="Warehousefeedback">Initiated By</label>
                    <input readonly type="text" name="initiated_by" id="initiated_by">

                </div>
            </div>

            <div class="col-lg-6 new-date-data-field warehouse">
                <div class="group-input input-date">
                    <label for="initiated On" style="font-weight: 100">Initiated On</label>
                    <div class="calenderauditee">
                        <input type="text" id="initiated_on" readonly placeholder="DD-MM-YYYY" />
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="button-block">
        <button type="submit" value="save" name="submit" id="DocsaveButton" class="saveButton">Save</button>
        <button type="button" class="nextButton" id="DocnextButton">Next</button>
        <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white"> Exit </a>
        </button>
    </div>
</div>
<div id="drafters" class="tabcontent">
    <div class="orig-head">
        Author Input
    </div>
    <div class="input-fields">
        <div class="row">
            <div class="col-lg-12">
                <div class="group-input">
                    <label for="comments">Drafter Remarks</label>
                    <textarea disabled name="drafter_remarks"></textarea>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="group-input">
                    <label for="Audit Attachments">Drafter Attachments</label>
                    <div><small class="text-primary">Please Attach all relevant or supporting
                            documents</small></div>
                    <div class="file-attachment-field">
                        <div class="file-attachment-list" id="drafter_attachments"></div>
                        <div class="add-btn">
                            <div>Add</div>
                            <input disabled type="file" id="drafter_attachments" name="drafter_attachments[]" onclick="addMultipleFiles(this, 'drafter_attachments')" multiple>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3 warehouse">
                <div class="group-input">
                    <label for="Warehousefeedback">Drafted By</label>
                    <input readonly type="text" name="drafted_by" id="drafted_by">

                </div>
            </div>

            <div class="col-lg-6 new-date-data-field warehouse">
                <div class="group-input input-date">
                    <label for="Drafted On">Drafted On</label>
                    <div class="calenderauditee">
                        <input type="text" id="drafted_on" readonly placeholder="DD-MM-YYYY" />
                        <input type="date" name="drafted_on" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input" oninput="handleDateInput(this, 'drafted_on')" />
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="button-block">
        <button type="submit" value="save" name="submit" id="DocsaveButton" class="saveButton">Save</button>
        <button type="button" class="backButton" onclick="previousStep()">Back</button>
        <button type="button" class="nextButton" id="DocnextButton" onclick="nextStep()">Next</button>
        <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white"> Exit </a>
        </button>
    </div>
</div>
<div id="hodcft" class="tabcontent">
    <div class="orig-head">
        HODs Input
    </div>
    <div class="input-fields">
        <div class="row">
            <div class="col-lg-12">
                <div class="group-input">
                    <label for="comments">HODs Remarks</label>
                    <textarea disabled name="hod_remarks"></textarea>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="group-input">
                    <label for="Audit Attachments">HODs Attachments</label>
                    <div><small class="text-primary">Please Attach all relevant or supporting
                            documents</small></div>
                    <div class="file-attachment-field">
                        <div class="file-attachment-list" id="hod_attachments"></div>
                        <div class="add-btn">
                            <div>Add</div>
                            <input disabled type="file" id="hod_attachments" name="hod_attachments[]" onclick="addMultipleFiles(this, 'hod_attachments')" multiple>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3 warehouse">
                <div class="group-input">
                    <label for="Warehousefeedback">HODs Completed By</label>
                    <input readonly type="text" name="hod_by" id="hod_by">

                </div>
            </div>

            <div class="col-lg-6 new-date-data-field warehouse">
                <div class="group-input input-date">
                    <label for="HODs Completed On">HODs Completed On</label>
                    <div class="calenderauditee">
                        <input type="text" id="hod_on" readonly placeholder="DD-MM-YYYY" />
                        <input type="date" name="hod_on" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input" oninput="handleDateInput(this, 'hod_on')" />
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="button-block">
        <button type="submit" value="save" name="submit" id="DocsaveButton" class="saveButton">Save</button>
        <button type="button" class="backButton" onclick="previousStep()">Back</button>
        <button type="button" class="nextButton" id="DocnextButton" onclick="nextStep()">Next</button>
        <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white"> Exit </a>
        </button>
    </div>
</div>
<div id="qa" class="tabcontent">
    <div class="orig-head">
        QA Input
    </div>
    <div class="input-fields">
        <div class="row">
            <div class="col-lg-12">
                <div class="group-input">
                    <label for="comments">QA Remarks</label>
                    <textarea disabled name="qa_remarks"></textarea>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="group-input">
                    <label for="Audit Attachments">QA Attachments</label>
                    <div><small class="text-primary">Please Attach all relevant or supporting
                            documents</small></div>
                    <div class="file-attachment-field">
                        <div class="file-attachment-list" id="qa_attachments"></div>
                        <div class="add-btn">
                            <div>Add</div>
                            <input disabled type="file" id="qa_attachments" name="qa_attachments[]" onclick="addMultipleFiles(this, 'qa_attachments')" multiple>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3 warehouse">
                <div class="group-input">
                    <label for="Warehousefeedback">QA Completed By</label>
                    <input readonly type="text" name="qa_by" id="qa_by">

                </div>
            </div>

            <div class="col-lg-6 new-date-data-field warehouse">
                <div class="group-input input-date">
                    <label for="QA Completed On">QA Completed On</label>
                    <div class="calenderauditee">
                        <input type="text" id="qa_on" readonly placeholder="DD-MM-YYYY" />
                        <input type="date" name="qa_on" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input" oninput="handleDateInput(this, 'qa_on')" />
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="button-block">
        <button type="submit" value="save" name="submit" id="DocsaveButton" class="saveButton">Save</button>
        <button type="button" class="backButton" onclick="previousStep()">Back</button>
        <button type="button" class="nextButton" id="DocnextButton" onclick="nextStep()">Next</button>
        <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white"> Exit </a>
        </button>
    </div>
</div>
<div id="reviewers" class="tabcontent">
    <div class="orig-head">
        Reviewer Input
    </div>
    <div class="input-fields">
        <div class="row">
            <div class="col-lg-12">
                <div class="group-input">
                    <label for="comments">Reviewer Remarks</label>
                    <textarea disabled name="reviewer_remarks"></textarea>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="group-input">
                    <label for="Audit Attachments">Reviewer Attachments</label>
                    <div><small class="text-primary">Please Attach all relevant or supporting
                            documents</small></div>
                    <div class="file-attachment-field">
                        <div class="file-attachment-list" id="reviewer_attachments"></div>
                        <div class="add-btn">
                            <div>Add</div>
                            <input disabled type="file" id="reviewer_attachments" name="reviewer_attachments[]" onclick="addMultipleFiles(this, 'reviewer_attachments')" multiple>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3 warehouse">
                <div class="group-input">
                    <label for="Warehousefeedback">Reviewer Completed By</label>
                    <input readonly type="text" name="reviewer_by" id="reviewer_by">

                </div>
            </div>

            <div class="col-lg-6 new-date-data-field warehouse">
                <div class="group-input input-date">
                    <label for="QA Completed On">Reviewer Completed On</label>
                    <div class="calenderauditee">
                        <input type="text" id="reviewer_on" readonly placeholder="DD-MM-YYYY" />
                        <input type="date" name="reviewer_on" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input" oninput="handleDateInput(this, 'reviewer_on')" />
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="button-block">
        <button type="submit" value="save" name="submit" id="DocsaveButton" class="saveButton">Save</button>
        <button type="button" class="backButton" onclick="previousStep()">Back</button>
        <button type="button" class="nextButton" id="DocnextButton" onclick="nextStep()">Next</button>
        <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white"> Exit </a>
        </button>
    </div>
</div>
<div id="approvers" class="tabcontent">
    <div class="orig-head">
        Approver Input
    </div>
    <div class="input-fields">
        <div class="row">
            <div class="col-lg-12">
                <div class="group-input">
                    <label for="comments">Approver Remarks</label>
                    <textarea disabled name="approver_remarks"></textarea>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="group-input">
                    <label for="Audit Attachments">Approver Attachments</label>
                    <div><small class="text-primary">Please Attach all relevant or supporting
                            documents</small></div>
                    <div class="file-attachment-field">
                        <div class="file-attachment-list" id="approver_attachments"></div>
                        <div class="add-btn">
                            <div>Add</div>
                            <input disabled type="file" id="approver_attachments" name="approver_attachments[]" onclick="addMultipleFiles(this, 'approver_attachments')" multiple>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3 warehouse">
                <div class="group-input">
                    <label for="Warehousefeedback">Approver Completed By</label>
                    <input readonly type="text" name="approver_by" id="approver_by">

                </div>
            </div>

            <div class="col-lg-6 new-date-data-field warehouse">
                <div class="group-input input-date">
                    <label for="QA Completed On">Approver Completed On</label>
                    <div class="calenderauditee">
                        <input type="text" id="approver_on" readonly placeholder="DD-MM-YYYY" />
                        <input type="date" name="approver_on" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input" oninput="handleDateInput(this, 'approver_on')" />
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="button-block">
        <button type="submit" value="save" name="submit" id="DocsaveButton" class="saveButton">Save</button>
        <button type="button" class="backButton" onclick="previousStep()">Back</button>
        <button type="button" class="nextButton" id="DocnextButton" onclick="nextStep()">Next</button>
        <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white"> Exit </a>
        </button>
    </div>
</div>



<div id="add-doc" class="tabcontent">
    <div class="orig-head">
        Training Information
    </div>
    <div class="input-fields">
        <div class="row">
            <div class="col-md-6">
                <div class="group-input">
                    <label for="train-require">Training Required?</label>
                    <select name="training_required" required>
                        <option value="">Enter your Selection</option>
                        <option value="yes">Yes</option>
                        <option value="no" selected>No</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="group-input">
                    <label for="link-doc">Trainer</label>
                    <select name="trainer">
                        <option value="" selected>Enter your Selection</option>
                        @foreach ($trainer as $temp)
                        @if(Helpers::checkUserRolestrainer($temp))
                        <option value="{{ $temp->id }}">{{ $temp->name }}</option>
                        @endif
                        @endforeach
                    </select>
                </div>
            </div>
            {{-- <div class="col-md-6">
                                <div class="group-input">
                                    <label for="launch-cbt">Launch CBT</label>
                                    <select name="cbt">
                                        <option value="" selected>Enter your Selection</option>
                                        <option value="1`">Lorem, ipsum.</option>
                                        <option value="1`">Lorem, ipsum.</option>
                                        <option value="1`">Lorem, ipsum.</option>
                                        <option value="1`">Lorem, ipsum.</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="training-type">Type</label>
                                    <select name="training-type">
                                        <option value="" selected>Enter your Selection</option>
                                        <option value="">Lorem, ipsum.</option>
                                        <option value="1`">Lorem, ipsum.</option>
                                        <option value="1`">Lorem, ipsum.</option>
                                    </select>
                                </div>
                            </div> --}}
            {{-- <div class="col-md-12">
                                    <div class="group-input">
                                        <label for="test">
                                            Test(0)<button type="button" name="test"
                                                onclick="addTrainRow('test')">+</button>
                                        </label>
                                        <table class="table-bordered table" id="test">
                                            <thead>
                                                <tr>
                                                    <th class="row-num">Row No.</th>
                                                    <th class="question">Question</th>
                                                    <th class="answer">Answer</th>
                                                    <th class="result">Result</th>
                                                    <th class="comment">Comment</th>
                                                    <th class="comment">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                </div> --}}
            {{-- <div class="col-md-12">
                                    <div class="group-input">
                                        <label for="test">
                                            Survey(0)<button type="button" name="reporting1"
                                                onclick="addTrainRow('survey')">+</button>
                                        </label>
                                        <table class="table-bordered table" id="survey">
                                            <thead>
                                                <tr>
                                                    <th class="row-num">Row No.</th>
                                                    <th class="question">Subject</th>
                                                    <th class="answer">Topic</th>
                                                    <th class="result">Rating</th>
                                                    <th class="comment">Comment</th>
                                                    <th class="comment">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                </div> --}}
            <div class="col-md-12">
                <div class="group-input">
                    <label for="comments">Comments</label>
                    <textarea name="comments"></textarea>
                </div>
            </div>
        </div>
    </div>
    <div class="button-block">
        <button type="submit" value="save" name="submit" id="DocsaveButton" class="saveButton">Save</button>
        <button type="button" class="backButton" onclick="previousStep()">Back</button>
        <button type="button" class="nextButton" id="DocnextButton" onclick="nextStep()">Next</button>
        <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white"> Exit </a>
        </button>
    </div>
</div>


<div id="doc-content" class="tabcontent">
    <div class="orig-head">
        Document Information
    </div>
    <div class="input-fields">
        <div class="row">
            <div class="col-md-12">
                <div class="group-input">
                    <label for="purpose">Objective</label>
                    <textarea class="myclassname" name="purpose"></textarea>
                </div>
            </div>
            <div class="col-md-12">
                <div class="group-input">
                    <label for="scope">Scope</label>
                    <textarea class="myclassname" name="scope"></textarea>
                </div>
            </div>

            <div class="col-md-12">
                <div class="group-input">

                    <label for="responsibility" id="responsibility">
                        Responsibility<button type="button" id="responsibilitybtnadd" name="button">+</button>
                        <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>
                    </label>

                    <div id="responsibilitydiv">
                        <div class="singleResponsibilityBlock">
                            <div class="row">
                                <div class="col-sm-10">
                                    <textarea  name="responsibility[]" class="myclassname"></textarea>
                                </div>
                                <div class="col-sm-1">
                                    <button class="btn btn-dark subResponsibilityAdd">+</button>
                                </div>
                                <div class="col-sm-1">
                                    <button class="btn btn-danger removeAllBlocks">Remove</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-md-12">
                <div class="group-input">

                    <label for="accountability" id="accountability">
                        Accountability<button type="button" id="accountabilitybtnadd" name="button">+</button>
                        <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>
                    </label>

                    <div id="accountabilitydiv">
                        <div class="singleAccountabilityBlock">
                            <div class="row">
                                <div class="col-sm-10">
                                    <textarea name="accountability[]" class="myclassname"></textarea>
                                </div>
                                <div class="col-sm-1">
                                    <button class="btn btn-dark subAccountabilityAdd">+</button>
                                </div>
                                <div class="col-sm-1">
                                    <button class="btn btn-danger removeAllBlocks">Remove</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-md-12">
                <div class="group-input">
                    <label for="references" id="references">
                        References<button type="button" id="referencesbtadd">+</button>
                    </label>
                    <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>
                    <div id="referencesdiv">
                        <div class="singleReferencesBlock">
                            <div class="row">
                                <div class="col-sm-10">
                                    <textarea name="references[]" class="myclassname"></textarea>
                                </div>
                                <div class="col-sm-1">
                                    <button class="btn btn-dark subReferencesAdd">+</button>
                                </div>
                                <div class="col-sm-1">
                                    <button class="btn btn-danger removeAllBlocks">Remove</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="group-input">
                    <label for="abbreviation" id="abbreviation">
                        Abbreviation<button type="button" id="abbreviationbtnadd" name="button">+</button>
                        <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>
                    </label>


                    <div id="abbreviationdiv">
                        <div class="singleAbbreviationBlock">
                            <div class="row">
                                <div class="col-sm-10">
                                    <textarea name="abbreviation[]" class="myclassname"></textarea>
                                </div>
                                <div class="col-sm-1">
                                    <button class="btn btn-dark subAbbreviationAdd">+</button>
                                </div>
                                <div class="col-sm-1">
                                    <button class="btn btn-danger removeAllBlocks">Remove</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>


            <div class="col-md-12">
                <div class="group-input">
                    <label for="abbreviation" id="definition">
                        Definition<button type="button" id="Definitionbtnadd" name="button">+</button>
                        <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>
                    </label>



                    <div id="definitiondiv">

                        <div class="singleDefinitionBlock">
                            <div class="row">
                                <div class="col-sm-10">
                                    <textarea name="defination[]" class="myclassname"></textarea>
                                </div>
                                <div class="col-sm-1">
                                    <button class="btn btn-dark subDefinitionAdd">+</button>
                                </div>
                                <div class="col-sm-1">
                                    <button class="btn btn-danger removeAllBlocks">Remove</button>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

            <div class="col-md-12">
                <div class="group-input">
                    <label for="reporting" id="newreport">
                        General Instructions<button type="button" id="materialsbtadd" name="button">+</button>
                        <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>
                    </label>

                    <div class="materialsBlock">
                        <div class="singleMaterialBlock">
                            <div class="row">
                                <div class="col-sm-10">
                                    <textarea name="materials_and_equipments[]" class="myclassname"></textarea>
                                </div>
                                <div class="col-sm-1">
                                    <button type="button" class="subMaterialsAdd" name="button">+</button>
                                </div>
                                <div class="col-sm-1">
                                    <button class="btn btn-danger removeAllBlocks">Remove</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-md-12 mb-3">
                <div class="group-input">
                    <label for="procedure">Procedure</label>
                    <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>
                    <textarea name="procedure" class="tiny">
                                    </textarea>
                </div>
            </div>



            <div class="col-md-12">
                <div class="group-input">
                    <label for="reporting" id="newreport">
                        Cross References<button type="button" id="reportingbtadd" name="button">+</button>
                    </label>
                    <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>

                    <div id="reportingdiv">
                        <div class="singleReportingBlock">
                            <div class="row">
                                <div class="col-sm-10">
                                    <textarea name="reporting[]" class="myclassname"></textarea>
                                </div>
                                <div class="col-sm-1">
                                    <button class="btn btn-dark subReportingAdd">+</button>
                                </div>
                                <div class="col-sm-1">
                                    <button class="btn btn-danger removeAllBlocks">Remove</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>



            <div class="col-md-12">
                <div class="group-input">
                    <label for="ann" id="ann">
                        Annexure<button type="button" id="annbtadd">+</button>
                    </label>
                    <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>

                    <div id="anndiv">
                        <div class="singleAnnexureBlock">
                            <div class="row">
                                <div class="col-sm-10">
                                    <textarea name="ann[]" class="myclassname"></textarea>
                                </div>
                                <div class="col-sm-1">
                                    <button class="btn btn-dark subAnnexureAdd">+</button>
                                </div>
                                <div class="col-sm-1">
                                    <button class="btn btn-danger removeAllBlocks">Remove</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="row reference-data">
                                            <div class="col-lg-6">
                                                <input type="text" name="reference-text">
                                            </div>
                                            <div class="col-lg-6">
                                                <input type="file" name="references" class="myclassname">
                                            </div>
                                        </div> --}}
                </div>
            </div>
            {{-- <div class="col-md-12">  ---By Aditya
                                    <div class="group-input">
                                        <label for="annexure">
                                            Annexure<button type="button" name="ann" id="annexurebtnadd">+</button>
                                        </label>
                                        <table class="table-bordered table" id="annexure">
                                            <div><small class="text-primary">Please mention brief summary</small></div>
                                            <thead>
                                                <tr>
                                                    <th class="sr-num">Sr. No.</th>
                                                    <th class="annx-num">Annexure No.</th>
                                                    <th class="annx-title">Title of Annexure</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><input disabled type="text" name="serial_number[]" value="1"></td>
                                                    <td><input type="text" name="annexure_number[]"></td>
                                                    <td><input type="text" name="annexure_data[]"></td>
                                                </tr>
                                                <div id="annexurediv"></div>
                                            </tbody>
                                        </table>
                                    </div>
                                </div> --}}
            {{-- <div class="col-md-12">
                                    <div class="group-input">
                                        <label for="test">
                                            Revision History<button type="button" name="reporting2"
                                                onclick="addRevRow('revision')">+</button>
                                        </label>
                                        <div><small class="text-primary">Please mention brief summary</small></div>
                                        <table class="table-bordered table" id="revision">
                                            <thead>
                                                <tr>
                                                    <th class="sop-num">SOP Revision No.</th>
                                                    <th class="dcrf-num">Change Control No./ DCRF No.</th>
                                                    <th class="changes">Changes</th>
                                                    <th class="deleteRow">&nbsp;</th> 
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><input type="text" id="rev-num0"></td>
                                                    <td><input type="text" id="control0"></td>
                                                    <td><input type="text" id="change0"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div> --}}
        </div>
    </div>
    <div class="button-block">
        <button type="submit" value="save" name="submit" id="DocsaveButton" class="saveButton">Save</button>
        <button type="button" class="backButton" onclick="previousStep()">Back</button>
        <button type="button" class="nextButton" onclick="nextStep()">Next</button>
        <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white"> Exit </a>
        </button>
    </div>
</div>

{{-- HOD REMARKS TAB START --}}
<div id="hod-remarks-tab" class="tabcontent">

    <div class="input-fields">
        <div class="group-input">
            <label for="hod-remark">HOD Comments</label>
            <textarea class="summernote" name="hod_comments"></textarea>
        </div>
    </div>

    <div class="input-fields">
        <div class="group-input">
            <label for="hod-attachments">HOD Attachments</label>
            <input type="file" name="hod_attachments[]" multiple>
        </div>
    </div>

    <div class="button-block">
        <button type="submit" value="save" name="submit" id="DocsaveButton" class="saveButton">Save</button>
        <button type="button" class="backButton" onclick="previousStep()">Back</button>
        <button type="button" class="nextButton" onclick="nextStep()">Next</button>
        <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white"> Exit </a>
        </button>
    </div>

</div>
{{-- HOD REMARKS TAB END --}}

<div id="annexures" class="tabcontent">
    <div class="input-fields">
        @for ($i = 1; $i <= 20; $i++) <div class="group-input">
            <label for="annexure-{{ $i }}">Annexure A-{{ $i }}</label>
            <textarea class="summernote" name="annexuredata[]" id="annexure-{{ $i }}"></textarea>
    </div>
    @endfor
</div>
<div class="button-block">
    <button type="submit" value="save" name="submit" class="saveButton">Save</button>
    <button type="button" class="backButton" onclick="previousStep()">Back</button>
    <button type="button" class="nextButton" onclick="nextStep()">Next</button>
    <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white"> Exit </a>
    </button>
</div>
</div>

<div id="distribution-retrieval" class="tabcontent">
    <div class="orig-head">
        Distribution & Retrieval
    </div>
    {{-- <div class="col-md-12 input-fields">
                            <div class="group-input">
                                <label for="distribution" id="distribution">
                                    Distribution & Retrieval<button type="button" id="distributionbtnadd" >+</button>
                                </label>
                                <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>
                                <input type="text" name="distribution[]" class="myclassname">
                                <div id="distributiondiv"></div>
                            </div>
                        </div> --}}
    <div class="input-fields">
        <div class="group-input">
            <label for="distriution_retrieval">
                Distribution & Retrieval
                <button type="button" name="    " onclick="addDistributionRetrieval('distribution-retrieval-grid')">+</button>
            </label>
            <div class="table-responsive retrieve-table">
                <table class="table table-bordered" id="distribution-retrieval-grid">
                    <thead>
                        <tr>
                            <th>Row </th>
                            <th>Document Title</th>
                            <th>Document Number</th>
                            <th>Document Printed By</th>
                            <th>Document Printed on</th>
                            <th>Number of Print Copies</th>
                            <th>Issuance Date</th>
                            <th>Issued To </th>
                            <th>Department/Location</th>
                            <th>Number of Issued Copies</th>
                            <th>Reason for Issuance</th>
                            <th>Retrieval Date</th>
                            <th>Retrieved By</th>
                            <th>Retrieved Person Department</th>
                            <th>Number of Retrieved Copies</th>
                            <th>Reason for Retrieval</th>
                            <th>Remarks</th>
                            <th>Document Distributed By</th>
                            <th>Document Distributed On</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- <tr>
                                                 <td><input type="text" Value="1" name="distribution[0][serial_number]" readonly>
                                                 </td>
                                                 <td><input type="text" name="distribution[0][document_title]">
                                                 </td>
                                                 <td><input type="number" name="distribution[0][document_number]">
                                                 </td>
                                                 <td><input type="text" name="distribution[0][document_printed_by]">
                                                 </td>
                                                 <td><input type="text" name="distribution[0][document_printed_on]">
                                                 </td>
                                                 <td><input type="number" name="distribution[0][document_printed_copies]">
                                                 </td>
                                                 <td><div class="group-input new-date-data-field mb-0">
                                                    <div class="input-date "><div
                                                     class="calenderauditee">
                                                    <input type="text" id="issuance_date' + serialNumber +'" readonly placeholder="DD-MMM-YYYY" />
                                                    <input type="date" name="distribution[0][issuance_date]" class="hide-input" 
                                                    oninput="handleDateInput(this, `issuance_date' + serialNumber +'`)" /></div></div></div>
                                                </td>
                                                
                                                    <td>
                                                        <select id="select-state" placeholder="Select..."
                                                            name="distribution[0][issuance_to]">
                                                            <option value='0'>-- Select --</option>
                                                            <option value='1'>Amit Guru</option>
                                                            <option value='2'>Shaleen Mishra</option>
                                                            <option value='3'>Madhulika Mishra</option>
                                                            <option value='4'>Amit Patel</option>
                                                            <option value='5'>Harsh Mishra</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select id="select-state" placeholder="Select..."
                                                            name="distribution[0][location]">
                                                            <option value='0'>-- Select --</option>
                                                            <option value='1'>Tech Team</option>
                                                            <option value='2'>Quality Assurance</option>
                                                            <option value='3'>Quality Management</option>
                                                            <option value='4'>IT Administration</option>
                                                            <option value='5'>Business Administration</option>
                                                        </select>
                                                    </td>    
                                                <td><input type="number" name="distribution[0][issued_copies]">
                                                </td>
                                                <td><input type="text" name="distribution[0][issued_reason]">
                                                </td>
                                                <td><div class="group-input new-date-data-field mb-0">
                                                    <div class="input-date "><div
                                                     class="calenderauditee">
                                                    <input type="text" id="retrieval_date' + serialNumber +'" readonly placeholder="DD-MMM-YYYY" />
                                                    <input type="date" name="distribution[0][retrieval_date]" class="hide-input" 
                                                    oninput="handleDateInput(this, `retrieval_date' + serialNumber +'`)" /></div></div></div>
                                                </td>
                                                <td>
                                                    <select id="select-state" placeholder="Select..."
                                                        name="distribution[0][retrieval_by]">
                                                        <option value="">Select a value</option>
                                                        <option value='1'>Amit Guru</option>
                                                        <option value='2'>Shaleen Mishra</option>
                                                        <option value='3'>Madhulika Mishra</option>
                                                        <option value='4'>Amit Patel</option>
                                                        <option value='5'>Harsh Mishra</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select id="select-state" placeholder="Select..."
                                                        name="distribution[0][retrieved_department]">
                                                        <option value='0'>-- Select --</option>
                                                        <option value='1'>Tech Team</option>
                                                        <option value='2'>Quality Assurance</option>
                                                        <option value='3'>Quality Management</option>
                                                        <option value='4'>IT Administration</option>
                                                        <option value='5'>Business Administration</option>
                                                    </select>
                                                </td>    
                                                <td><input type="number" name="distribution[0][retrieved_copies]">
                                                </td>
                                                <td><input type="text" name="distribution[0][retrieved_reason]">
                                                </td>
                                                <td><input type="text" name="distribution[0][remark]">
                                                </td>
                                                <td></td>
                                        </tr> --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="button-block">
        <button type="submit" value="save" name="submit" class="saveButton">Save</button>
        <button type="button" class="backButton" onclick="previousStep()">Back</button>
        <button type="button" class="nextButton" onclick="nextStep()">Next</button>
        <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white"> Exit </a>
        </button>
    </div>
</div>

{{-- <div id="print-download" class="tabcontent">
                        <div class="orig-head">
                            Print Permissions
                        </div>
                        <div class="input-fields">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="group-input">
                                        <label for="person-print">Person Print Permission</label>
                                        <select id="choices-multiple-remove-button" placeholder="Select Persons" multiple>
                                            <option value="HTML">HTML</option>
                                            <option value="Jquery">Jquery</option>
                                            <option value="CSS">CSS</option>
                                            <option value="Bootstrap 3">Bootstrap 3</option>
                                            <option value="Bootstrap 4">Bootstrap 4</option>
                                            <option value="Java">Java</option>
                                            <option value="Javascript">Javascript</option>
                                            <option value="Angular">Angular</option>
                                            <option value="Python">Python</option>
                                            <option value="Hybris">Hybris</option>
                                            <option value="SQL">SQL</option>
                                            <option value="NOSQL">NOSQL</option>
                                            <option value="NodeJS">NodeJS</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="group-input">
                                        <table class="table-bordered table">
                                            <thead>
                                                <th class="person">Person</th>
                                                <th class="permission">Daily</th>
                                                <th class="permission">Weekly</th>
                                                <th class="permission">Monthly</th>
                                                <th class="permission">Quarterly</th>
                                                <th class="permission">Annually</th>
                                            </thead>
                                            <tbody>
                                                <td class="person">
                                                    Amit Patel
                                                </td>
                                                <td class="permission">
                                                    6543
                                                </td>
                                                <td class="permission">
                                                    6543
                                                </td>
                                                <td class="permission">
                                                    6543
                                                </td>
                                                <td class="permission">
                                                    432
                                                </td>
                                                <td class="permission">
                                                    123
                                                </td>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="group-input">
                                        <label for="group-print">Group Print Permission</label>
                                        <select id="choices-multiple-remove-button" placeholder="Select Persons" multiple>
                                            <option value="HTML">HTML</option>
                                            <option value="Jquery">Jquery</option>
                                            <option value="CSS">CSS</option>
                                            <option value="Bootstrap 3">Bootstrap 3</option>
                                            <option value="Bootstrap 4">Bootstrap 4</option>
                                            <option value="Java">Java</option>
                                            <option value="Javascript">Javascript</option>
                                            <option value="Angular">Angular</option>
                                            <option value="Python">Python</option>
                                            <option value="Hybris">Hybris</option>
                                            <option value="SQL">SQL</option>
                                            <option value="NOSQL">NOSQL</option>
                                            <option value="NodeJS">NodeJS</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="group-input">
                                        <table class="table-bordered table">
                                            <thead>
                                                <th class="person">Group</th>
                                                <th class="permission">Daily</th>
                                                <th class="permission">Weekly</th>
                                                <th class="permission">Monthly</th>
                                                <th class="permission">Quarterly</th>
                                                <th class="permission">Annually</th>
                                            </thead>
                                            <tbody>
                                                <td class="person">
                                                    QA
                                                </td>
                                                <td class="permission">1</td>
                                                <td class="permission">
                                                    54
                                                </td>
                                                <td class="permission">
                                                    654
                                                </td>
                                                <td class="permission">
                                                    765
                                                </td>
                                                <td class="permission">
                                                    654
                                                </td>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="orig-head">
                            Download Permissions
                        </div>
                        <div class="input-fields">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="group-input">
                                        <label for="person-print">Person Download Permission</label>
                                        <select id="choices-multiple-remove-button" placeholder="Select Persons" multiple>
                                            <option value="HTML">HTML</option>
                                            <option value="Jquery">Jquery</option>
                                            <option value="CSS">CSS</option>
                                            <option value="Bootstrap 3">Bootstrap 3</option>
                                            <option value="Bootstrap 4">Bootstrap 4</option>
                                            <option value="Java">Java</option>
                                            <option value="Javascript">Javascript</option>
                                            <option value="Angular">Angular</option>
                                            <option value="Python">Python</option>
                                            <option value="Hybris">Hybris</option>
                                            <option value="SQL">SQL</option>
                                            <option value="NOSQL">NOSQL</option>
                                            <option value="NodeJS">NodeJS</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="group-input">
                                        <table class="table-bordered table">
                                            <thead>
                                                <th class="person">Person</th>
                                                <th class="permission">Daily</th>
                                                <th class="permission">Weekly</th>
                                                <th class="permission">Monthly</th>
                                                <th class="permission">Quarterly</th>
                                                <th class="permission">Annually</th>
                                            </thead>
                                            <tbody>
                                                <td class="person">
                                                    Amit Patel
                                                </td>
                                                <td class="permission">1</td>
                                                <td class="permission">
                                                    54
                                                </td>
                                                <td class="permission">
                                                    654
                                                </td>
                                                <td class="permission">
                                                    765
                                                </td>
                                                <td class="permission">
                                                    654
                                                </td>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="group-input">
                                        <label for="group-print">Group Download Permission</label>
                                        <select id="choices-multiple-remove-button" placeholder="Select Persons" multiple>
                                            <option value="HTML">HTML</option>
                                            <option value="Jquery">Jquery</option>
                                            <option value="CSS">CSS</option>
                                            <option value="Bootstrap 3">Bootstrap 3</option>
                                            <option value="Bootstrap 4">Bootstrap 4</option>
                                            <option value="Java">Java</option>
                                            <option value="Javascript">Javascript</option>
                                            <option value="Angular">Angular</option>
                                            <option value="Python">Python</option>
                                            <option value="Hybris">Hybris</option>
                                            <option value="SQL">SQL</option>
                                            <option value="NOSQL">NOSQL</option>
                                            <option value="NodeJS">NodeJS</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="group-input">
                                        <table class="table-bordered table">
                                            <thead>
                                                <th class="person">Group</th>
                                                <th class="permission">Daily</th>
                                                <th class="permission">Weekly</th>
                                                <th class="permission">Monthly</th>
                                                <th class="permission">Quarterly</th>
                                                <th class="permission">Annually</th>
                                            </thead>
                                            <tbody>
                                                <td class="person">
                                                    QA
                                                </td>
                                                <td class="permission">1</td>
                                                <td class="permission">
                                                    54
                                                </td>
                                                <td class="permission">
                                                    654
                                                </td>
                                                <td class="permission">
                                                    765
                                                </td>
                                                <td class="permission">
                                                    654
                                                </td>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="button-block">
                            <button type="submit" value="save" name="submit" class="saveButton">Save</button>
                            <button type="button" class="backButton" onclick="previousStep()">Back</button>
                            <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                            <button type="button"> <a  href="{{ url('rcms/qms-dashboard') }}" class="text-white" > Exit </a>
</button>
</div>
</div> --}}

<div id="sign" class="tabcontent">
    <div class="row">
        <div class="col-md-6">
            <div class="review-names">
                <div class="orig-head">
                    Originated By
                    {{-- Review Proposed By --}}
                </div>
            </div>
        </div>
        {{-- <div class="col-md-6">
                                <div class="review-names">
                                    <div class="orig-head">
                                        Review Proposed On
                                    </div>
                                </div>
                            </div> --}}
        <div class="col-md-6">
            <div class="review-names">
                <div class="orig-head">
                    Originated On
                    {{-- Document Reuqest Approved By --}}
                </div>
            </div>
        </div>
        {{-- <div class="col-md-6">
                                <div class="review-names">
                                    <div class="orig-head">
                                        Document Reuqest Approved On
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="review-names">
                                    <div class="orig-head">
                                        Document Writing Completed By
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="review-names">
                                    <div class="orig-head">
                                        Document Writing Completed On
                                    </div>
                                </div>
                            </div> --}}
        <div class="col-md-6">
            <div class="review-names">
                <div class="orig-head">
                    Reviewd By
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="review-names">
                <div class="orig-head">
                    Reviewd On
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="review-names">
                <div class="orig-head">
                    Approved By
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="review-names">
                <div class="orig-head">
                    Approved On
                </div>
            </div>
        </div>
    </div>
    <div class="button-block">
        <button type="submit" value="save" name="submit" class="saveButton">Save</button>
        <button type="button" class="backButton" onclick="previousStep()">Back</button>
        <button type="submit">Submit</button>
        <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white" href="#"> Exit </a> </button>
    </div>
</div>

</div>

</form>
</div>
</div>

{{-- ======================================
                  DIVISION MODAL

    ======================================= --}}
<style>
    #step-form>div {
        display: none
    }

    #step-form>div:nth-child(1) {
        display: block;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.tiny.cloud/1/8usfwobx3sqs3heqlt9411i4ewrmf5010l05mk2tyc5judc7/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function () {
        
        $('#openModalButton').click(function() {
            $('#customModal').modal('show');
        });

        $('#submitPrompt').click(async function () {
            let docDescription = $('textarea[name=ai_prompt]').val().trim();
            if (docDescription === '') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Empty Input',
                    text: 'Please enter a document short description.',
                });
                return;
            }
    
            // Show loading text
            Swal.fire({
                title: 'Generating AI Response...',
                html: 'Please wait while we gather insights based on your input. This might take a moment...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
    
            try {
                let open_ai_key = "{{ config('app.open_ai_key') }}";

                const response = await axios.post(
                    'https://api.openai.com/v1/chat/completions',
                    {
                        "model": "gpt-3.5-turbo",
                        "messages": [
                            {
                                "role": "user",
                                "content": `Generate a structured JSON response with fields Objective, Scope, Responsibility, Accountability, References, Abbreviation, Definition, General Instructions, Procedure (procedure can be html content and very detailed), and Cross References based on the document description: "${docDescription}". Make content as lengthy as possible.`
                            }
                        ]
                    },
                    {
                        headers: {
                            'Authorization': `Bearer ${open_ai_key}`,
                            'Content-Type': 'application/json'
                        }
                    }
                );
    
                // Close the loading alert
                Swal.close();
    
                // Parse the content received from OpenAI
                let content = response.data.choices[0].message.content;
                let jsonResponse = JSON.parse(content);
                console.log('data', jsonResponse)
                populateFields(jsonResponse);
                $('#customModal').modal('hide');

            } catch (error) {
                // Swal.fire({
                //     icon: 'error',
                //     title: 'Error Occurred',
                //     text: `Failed to retrieve the data: ${error.message}`,
                // });
                console.log('error in ai generating response', error.message)
            }
        });
    
        function populateFields(data) {
            // Populate each field based on its specific HTML structure
            for (let section in data) {
                let sectionData = data[section];

                switch (section.toLowerCase()) {
                    case "objective":
                        $("textarea[name='purpose']").val(sectionData);
                        break;

                    case "scope":
                        $("textarea[name='scope']").val(sectionData);
                        break;

                    case "procedure":
                        populateProcedureField(sectionData);

                        break;

                    case "responsibility":
                        populateDynamicField(sectionData, '#responsibilitybtnadd', "textarea[name='responsibility[]']");
                        break;

                    case "accountability":
                        populateDynamicField(sectionData, '#accountabilitybtnadd', "textarea[name='accountability[]']");
                        break;

                    case "references":
                        populateDynamicField(sectionData, '#referencesbtadd', "textarea[name='references[]']");
                        break;

                    case "abbreviation":
                        populateDynamicField(sectionData, '#abbreviationbtnadd', "textarea[name='abbreviation[]']");
                        break;

                    case "definition":
                        populateDynamicField(sectionData, '#Definitionbtnadd', "textarea[name='defination[]']");
                        break;

                    case "general instructions":
                        populateDynamicField(sectionData, '#materialsbtadd', "textarea[name='materials_and_equipments[]']");
                        break;

                    case "cross references":
                        populateDynamicField(sectionData, '#reportingbtadd', "textarea[name='reporting[]']");
                        break;

                    case "annexure":
                        populateDynamicField(sectionData, '#annbtadd', "textarea[name='ann[]']");
                        break;

                    default:
                        console.warn(`No matching field found for section: ${section}`);
                }
            }
        }

        // Function to populate fields dynamically based on the array data and trigger button clicks
        async function populateDynamicField(data, buttonSelector, fieldSelector) {
            // Check if the data is an array or a single string
            if (Array.isArray(data)) {
                // If data is an array, iterate through the array
                for (let i = 0; i < data.length; i++) {
                    if (i > 0) {
                        $(buttonSelector).click(); // Click to add a new field dynamically
                        await sleep(500); // Wait for field to be added before accessing it
                    }

                    // Insert each array element into its corresponding dynamically added field
                    if (typeof data[i] === 'object') {
                        $(`${fieldSelector}`).eq(i).val(formatObjectAsString(data[i]));
                    } else {
                        $(`${fieldSelector}`).eq(i).val(data[i]);
                    }
                }
            } else if (typeof data === 'string') {
                // If data is a single string, populate the first matching field
                $(`${fieldSelector}`).first().val(data);
            } else if (typeof data === 'object') {
                let i = 0;
                for (let key in data) {
                    if (i > 0) {
                        $(buttonSelector).click(); 
                        await sleep(500);
                    }
                    $(`${fieldSelector}`).eq(i).val(`${key} : ${data[key]}`);
                    i++;
                }

            }
        }

        function populateProcedureField(procedureContent) {
            if (typeof tinymce !== 'undefined' && tinymce.get(0)) {
                tinymce.get(0).setContent(procedureContent);
            }
        }


        // Utility function to format an object as a readable string
        function formatObjectAsString(objectData) {
            return Object.entries(objectData)
                .map(([key, value]) => `${capitalizeFirstLetter(key)}: ${value}`)
                .join('\n');
        }

        // Function to format procedure steps into a readable string
        function formatProcedureSteps(steps) {
            return steps.map(step => `${step.step}: ${step.substeps.join(', ')}`).join('\n');
        }

        // Function to capitalize the first letter of a string
        function capitalizeFirstLetter(string) {
            return string.charAt(0).toUpperCase() + string.slice(1);
        }

        // Utility function to introduce delay
        function sleep(ms) {
            return new Promise(resolve => setTimeout(resolve, ms));
        }
        });
</script>

<script>
    $(document).ready(function() {

        const api_key = '{{ config("app.open_ai_key") }}';

        const languages = [
            "Afrikaans", "Albanian", "Amharic", "Arabic", "Armenian", "Azerbaijani",
            "Basque", "Belarusian", "Bengali", "Bosnian", "Bulgarian",
            "Catalan", "Cebuano", "Chichewa", "Chinese (Simplified)", "Chinese (Traditional)",
            "Corsican", "Croatian", "Czech", "Danish", "Dutch", "English", "Esperanto", "Estonian",
            "Filipino", "Finnish", "French", "Frisian", "Galician", "Georgian", "German", "Greek",
            "Gujarati", "Haitian Creole", "Hausa", "Hawaiian", "Hebrew", "Hindi", "Hmong", "Hungarian",
            "Icelandic", "Igbo", "Indonesian", "Irish", "Italian", "Japanese", "Javanese", "Kannada",
            "Kazakh", "Khmer", "Kinyarwanda", "Korean", "Kurdish (Kurmanji)", "Kyrgyz",
            "Lao", "Latin", "Latvian", "Lithuanian", "Luxembourgish", "Macedonian", "Malagasy", "Malay",
            "Malayalam", "Maltese", "Maori", "Marathi", "Mongolian", "Myanmar (Burmese)", "Nepali",
            "Norwegian", "Odia (Oriya)", "Pashto", "Persian", "Polish", "Portuguese", "Punjabi", "Romanian",
            "Russian", "Samoan", "Scots Gaelic", "Serbian", "Sesotho", "Shona", "Sindhi", "Sinhala",
            "Slovak", "Slovenian", "Somali", "Spanish", "Sundanese", "Swahili", "Swedish",
            "Tajik", "Tamil", "Tatar", "Telugu", "Thai", "Turkish", "Turkmen", "Ukrainian", "Urdu",
            "Uyghur", "Uzbek", "Vietnamese", "Welsh", "Xhosa", "Yiddish", "Yoruba", "Zulu"
        ];

        const languageObjects = languages.map(language => ({
            title: language,
            prompt: `Translate this to ${language} language.`,
            selection: true
        }));

        // console.log(languageObjects);

        // $(document).ready(function(){
        //     var editor = new FroalaEditor('textarea.tiny', {
        //         key: "uXD2lC7C4B4D4D4J4B11dNSWXf1h1MDb1CF1PLPFf1C1EESFKVlA3C11A8D7D2B4B4G2D3J3==",
        //         imageUploadParam: 'image_param',
        //         imageUploadMethod: 'POST',
        //         imageMaxSize: 20 * 1024 * 1024,
        //         imageUploadURL: "{{ route('api.upload.file') }}",
        //         fileUploadParam: 'image_param',
        //         fileUploadURL: "{{ route('api.upload.file') }}",
        //         videoUploadParam: 'image_param',
        //         videoUploadURL: "{{ route('api.upload.file') }}",
        //         videoMaxSize: 500 * 1024 * 1024,
        //         toolbarButtons: {

        //             'moreText': {

        //                 'buttons': ['bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript', 'fontFamily', 'fontSize', 'textColor', 'backgroundColor', 'inlineClass', 'inlineStyle', 'clearFormatting']

        //             },

        //             'moreParagraph': {

        //                 'buttons': ['alignLeft', 'alignCenter', 'formatOLSimple', 'alignRight', 'alignJustify', 'formatOL', 'formatUL', 'paragraphFormat', 'paragraphStyle', 'lineHeight', 'outdent', 'indent', 'quote']

        //             },

        //             'moreRich': {

        //                 'buttons': ['insertLink', 'insertImage', 'insertVideo', 'insertTable', 'emoticons', 'fontAwesome', 'specialCharacters', 'embedly', 'insertFile', 'insertHR']

        //             },

        //             'moreMisc': {

        //                 'buttons': ['undo', 'redo', 'fullscreen', 'print', 'getPDF', 'spellChecker', 'selectAll', 'html', 'help'],

        //                 'align': 'right',

        //                 'buttonsVisible': 2

        //             }

        //         }

        //     });

        //     var disabledEditors = new FroalaEditor('textarea.tiny-disable', {
        //         key: "uXD2lC7C4B4D4D4J4B11dNSWXf1h1MDb1CF1PLPFf1C1EESFKVlA3C11A8D7D2B4B4G2D3J3==",
        //     }, function() {
        //         disabledEditors.edit.off();
        //     });

        // }) 
        // new FroalaEditor('.selector', {  toolbarButtons: {  'moreText': {    'buttons': ['bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript', 'fontFamily', 'fontSize', 'textColor', 'backgroundColor', 'inlineClass', 'inlineStyle', 'clearFormatting']  },  'moreParagraph': {    'buttons': ['alignLeft', 'alignCenter', 'formatOLSimple', 'alignRight', 'alignJustify', 'formatOL', 'formatUL', 'paragraphFormat', 'paragraphStyle', 'lineHeight', 'outdent', 'indent', 'quote']  },  'moreRich': {    'buttons': ['insertLink', 'insertImage', 'insertVideo', 'insertTable', 'emoticons', 'fontAwesome', 'specialCharacters', 'embedly', 'insertFile', 'insertHR']  },  'moreMisc': {    'buttons': ['undo', 'redo', 'fullscreen', 'print', 'getPDF', 'spellChecker', 'selectAll', 'html', 'help'],    'align': 'right',    'buttonsVisible': 2  }}});


        tinymce.init({
            selector: 'textarea.tiny', // Replace this CSS selector to match the placeholder element for TinyMCE
            plugins: 'ai preview powerpaste casechange importcss tinydrive searchreplace autolink autosave save directionality advcode visualblocks visualchars fullscreen link codesample table charmap pagebreak nonbreaking anchor tableofcontents insertdatetime advlist lists checklist wordcount tinymcespellchecker a11ychecker editimage help formatpainter permanentpen pageembed charmap mentions quickbars linkchecker emoticons advtable footnotes mergetags autocorrect typography advtemplate markdown',
            toolbar: 'undo redo | aidialog aishortcuts | charmap | blocks fontsizeinput | bold italic | align numlist bullist | link | table pageembed | lineheight  outdent indent | strikethrough forecolor backcolor formatpainter removeformat | emoticons checklist | code fullscreen preview | save print | pagebreak anchor codesample footnotes mergetags | addtemplate inserttemplate | addcomment showcomments | ltr rtl casechange | spellcheckdialog a11ycheck',
            ai_request: (request, respondWith) => {
                const openAiOptions = {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${api_key}`
                    },
                    body: JSON.stringify({
                        model: 'gpt-3.5-turbo',
                        temperature: 0.7,
                        max_tokens: 800,
                        messages: [{
                            role: 'user',
                            content: request.prompt
                        }],
                    })
                };
                respondWith.string((signal) => window.fetch('https://api.openai.com/v1/chat/completions', {
                        signal,
                        ...openAiOptions
                    })
                    .then(async (response) => {
                        if (response) {
                            const data = await response.json();
                            if (data.error) {
                                throw new Error(`${data.error.type}: ${data.error.message}`);
                            } else if (response.ok) {
                                // Extract the response content from the data returned by the API
                                return data?.choices[0]?.message?.content?.trim();
                            }
                        } else {
                            throw new Error('Failed to communicate with the AI');
                        }
                    })
                );
            },
            ai_shortcuts: [{
                    title: 'Translate',
                    subprompts: languageObjects
                },
                {
                    title: 'Summarize content',
                    prompt: 'Provide the key points and concepts in this content in a succinct summary.',
                    selection: true
                },
                {
                    title: 'Improve writing',
                    prompt: 'Rewrite this content with no spelling mistakes, proper grammar, and with more descriptive language, using best writing practices without losing the original meaning.',
                    selection: true
                },
                {
                    title: 'Simplify language',
                    prompt: 'Rewrite this content with simplified language and reduce the complexity of the writing, so that the content is easier to understand.',
                    selection: true
                },
                {
                    title: 'Expand upon',
                    prompt: 'Expand upon this content with descriptive language and more detailed explanations, to make the writing easier to understand and increase the length of the content.',
                    selection: true
                },
                {
                    title: 'Trim content',
                    prompt: 'Remove any repetitive, redundant, or non-essential writing in this content without changing the meaning or losing any key information.',
                    selection: true
                },
                {
                    title: 'Change tone',
                    subprompts: [{
                            title: 'Professional',
                            prompt: 'Rewrite this content using polished, formal, and respectful language to convey professional expertise and competence.',
                            selection: true
                        },
                        {
                            title: 'Casual',
                            prompt: 'Rewrite this content with casual, informal language to convey a casual conversation with a real person.',
                            selection: true
                        },
                        {
                            title: 'Direct',
                            prompt: 'Rewrite this content with direct language using only the essential information.',
                            selection: true
                        },
                        {
                            title: 'Confident',
                            prompt: 'Rewrite this content using compelling, optimistic language to convey confidence in the writing.',
                            selection: true
                        },
                        {
                            title: 'Friendly',
                            prompt: 'Rewrite this content using friendly, comforting language, to convey understanding and empathy.',
                            selection: true
                        },
                    ]
                },
                {
                    title: 'Change style',
                    subprompts: [{
                            title: 'Business',
                            prompt: 'Rewrite this content as a business professional with formal language.',
                            selection: true
                        },
                        {
                            title: 'Legal',
                            prompt: 'Rewrite this content as a legal professional using valid legal terminology.',
                            selection: true
                        },
                        {
                            title: 'Journalism',
                            prompt: 'Rewrite this content as a journalist using engaging language to convey the importance of the information.',
                            selection: true
                        },
                        {
                            title: 'Medical',
                            prompt: 'Rewrite this content as a medical professional using valid medical terminology.',
                            selection: true
                        },
                        {
                            title: 'Poetic',
                            prompt: 'Rewrite this content as a poem using poetic techniques without losing the original meaning.',
                            selection: true
                        },
                    ]
                }
            ],
            paste_data_images: true,
            images_upload_url: false,
            images_upload_handler: false,
            automatic_uploads: false

        });
    })
</script>
<script>
    VirtualSelect.init({
        ele: '#reference_record, #notify_to, #cc_reference_record'
    });

    $('#summernote').summernote({
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear', 'italic']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link', 'picture', 'video']],
            ['view', ['fullscreen', 'codeview', 'help']]
        ]
    });

    $('.summernote').summernote({
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear', 'italic']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link', 'picture', 'video']],
            ['view', ['fullscreen', 'codeview', 'help']]
        ]
    });

    let referenceCount = 1;

    function addReference() {
        referenceCount++;
        let newReference = document.createElement('div');
        newReference.classList.add('row', 'reference-data-' + referenceCount);
        newReference.innerHTML = `
            <div class="col-lg-6">
                <input type="text" name="reference-text">
            </div>
            <div class="col-lg-6">
                <input type="file"  name="references" class="myclassname">
            </div><div class="col-lg-6">
                <input type="file" name="references" class="myclassname">
            </div>
        `;
        let referenceContainer = document.querySelector('.reference-data');
        referenceContainer.parentNode.insertBefore(newReference, referenceContainer.nextSibling);
    }
</script>

<script>
    var maxLength = 255;
    $('#docname').keyup(function() {
        var textlen = maxLength - $(this).val().length;
        $('#rchars').text(textlen);
    });
</script>
<script>
    var maxLength = 255;
    $('#short_desc').keyup(function() {
        var textlen = maxLength - $(this).val().length;
        $('#new-rchars').text(textlen);
    });
</script>

<script>
    $(document).ready(function() {
        $('#document-form').validate({
            rules: {
                name: 'required',
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true,
                    minlength: 6
                }
            },
            // Add custom messages if needed
            messages: {
                name: 'Please enter your name',
                email: {
                    required: 'Please enter your email',
                    email: 'Please enter a valid email address'
                },
                password: {
                    required: 'Please enter a password',
                    minlength: 'Password must be at least 6 characters long'
                }
            },
            submitHandler: function(form) {
                form.submit(); // Submit the form if validation passes
            }
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#addButton').click(function() {
            var sourceValue = $('#sourceField').val().trim(); // Get the trimmed value from the source field
            if (!sourceValue) return; // Prevent adding empty values

            // Create a new list item with the source value and a close icon
            var newItem = $('<li>', {
                class: 'd-flex justify-content-between align-items-center'
            }).text(sourceValue);
            var closeButton = $('<span>', {
                text: '×',
                class: 'close-icon ms-2' // Bootstrap class for margin-left spacing
            }).appendTo(newItem);

            // Append the new list item to the display field
            $('#displayField').append(newItem);

            // Create a corresponding option in the hidden select
            var newOption = $('<option>', {
                value: sourceValue,
                text: sourceValue,
                selected: 'selected'
            }).appendTo('#keywords');

            // Clear the input field
            $('#sourceField').val('');

            // Add click event for the close icon
            closeButton.on('click', function() {
                var thisValue = $(this).parent().text().slice(0, -1); // Remove the '×' from the value
                $(this).parent().remove(); // Remove the parent list item on click
                $('#keywords option').filter(function() {
                    return $(this).val() === thisValue;
                }).remove(); // Also remove the corresponding option from the select
            });
        });


        // $('#addButton').click(function() {
        //     var sourceValue = $('#sourceField').val(); // Get the value from the source field
        //     var targetField = $(
        //         '.targetField'); // The target field where the data will be added and selected

        //     // Create a new option with the source value
        //     var newOption = $('<option>', {
        //         value: sourceValue,
        //         text: sourceValue,
        //     });

        //     // Append the new option to the target field
        //     targetField.append(newOption);

        //     // Set the new option as selected
        //     newOption.prop('selected', true);
        //     $('#sourceField').val('');
        // });
    });

    $(document).on('click', '.removeTag', function() {
        $(this).remove();
    });
</script>
<script>
    function openData(evt, cityName) {
        var i, cctabcontent, cctablinks;
        cctabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < cctabcontent.length; i++) {
            cctabcontent[i].style.display = "none";
        }
        cctablinks = document.getElementsByClassName("tablinks");
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
    const stepButtons = document.querySelectorAll(".tablinks");
    const steps = document.querySelectorAll(".tabcontent");
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
@endsection