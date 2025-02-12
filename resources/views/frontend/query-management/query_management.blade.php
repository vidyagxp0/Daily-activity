@extends('frontend.rcms.layout.main_rcms')
@section('rcms_container')
    <style>
        header .header_rcms_bottom {
            display: none;
        }

        .calenderauditee {
            position: relative;
        }

        .new-date-data-field .input-date input.hide-input {
            position: absolute;
            top: 0;
            left: 0;
            opacity: 0;
        }

        .new-date-data-field input {
            border: 1px solid grey;
            border-radius: 5px;
            padding: 5px 15px;
            display: block;
            width: 100%;
            background: white;
        }

        .calenderauditee input::-webkit-calendar-picker-indicator {
            width: 100%;
        }

        .remove-file {
            cursor: pointer;
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

    <div id="rcms_form-head">
        <div class="container-fluid">
            <div class="inner-block">
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


                <div class="slogan">
                    <strong>Site Division / Project </strong>:
                    {{ Helpers::getDivisionName(session()->get('division')) }} / Query Management
                </div>
            </div>
        </div>
    </div>
    @php
        $users = DB::table('users')->get();
    @endphp
    <div id="change-control-fields">
        <div class="container-fluid">

            <div class="cctab">
                <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">General Information</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm2')">Admin 1 Review</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm3')">Admin 2 Review</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm4')">HOD Review</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm5')">CFT Review</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm6')">Outcome</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm7')">Activity Log</button>
            </div>
            <form action="{{ route('query-managements-store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- Tab content -->
                <div id="step-form">

                    @if (!empty($parent_id))
                        <input type="hidden" name="parent_id" value="{{ $parent_id }}">
                        <input type="hidden" name="parent_type" value="{{ $parent_type }}">
                    @endif

                    <div id="CCForm1" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                <div class="sub-head">
                                    Query Identification 
                                </div>
                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="RLS Record Number"><b>Query ID</b></label>
                                        <input type="text" disabled value="{{ Helpers::getDivisionName(session()->get('division')) }}/QM/{{ date('Y') }}/{{ str_pad($record_number, 4, '0', STR_PAD_LEFT) }}">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Division Code"><b>Division Code</b></label>
                                        <input disabled type="text" name="division_code"
                                            value="{{ Helpers::getDivisionName(session()->get('division')) }}">
                                        <input type="hidden" name="division_id" value="{{ session()->get('division') }}">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Initiator"><b>Submitter Name</b></label>
                                        <input disabled type="text" value="{{ Auth::user()->name }}">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input ">
                                        <label for="Date Due"><b>Submission Date</b></label>
                                        <input disabled type="text" value="{{ date('d-M-Y') }}" name="initiation_date">
                                        <input type="hidden" value="{{ date('Y-m-d') }}" name="initiation_date">
                                    </div>
                                </div>

                                <div class="col-lg-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Due Date"> Due Date <span class="text-danger">*</span></label>
                                        <div><small class="text-primary">If revising Due Date, kindly mention revision
                                                reason in "Due Date Extension Justification" data field.</small></div>
                                        <div class="calenderauditee">
                                            <input disabled type="text" id="due_date" readonly placeholder="DD-MMM-YYYY"
                                                required />
                                            <input type="date" name="due_date" required
                                                min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input"
                                                oninput="handleDateInput(this, 'due_date')" />
                                        </div>
                                    </div>
                                </div>

                                <script>
                                    $(document).ready(function() {
                                        function toggleRiskAssessmentAndJustification() {
                                            var riskAssessmentRequired = $('#risk_assessment_required').val();

                                            // Toggle Risk Assessment Button
                                            if (riskAssessmentRequired === 'yes') {
                                                $('#riskAssessmentButton').show();
                                                $('#justification_div').hide(); // Hide justification when "Yes" is selected
                                            } else if (riskAssessmentRequired === 'no') {
                                                $('#riskAssessmentButton').hide();
                                                $('#justification_div').show(); // Show justification when "No" is selected
                                            } else {
                                                $('#riskAssessmentButton').hide();
                                                $('#justification_div').hide(); // Hide everything if nothing is selected
                                            }
                                        }

                                        toggleRiskAssessmentAndJustification(); // Initial call to set the correct state

                                        // Call the function on dropdown change
                                        $('#risk_assessment_required').change(function() {
                                            toggleRiskAssessmentAndJustification();
                                        });
                                    });
                                </script>

                                <div class="sub-head">
                                    Query Details 
                                </div>

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Short Description">Short Description<span
                                                class="text-danger">*</span></label><span id="rchars"
                                            class="text-primary">255 </span><span class="text-primary"> characters
                                            remaining</span>
                                        <div class="relative-container">
                                            <input id="docname" type="text" name="short_description" maxlength="255"
                                                required>
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Related Records">Reference Document</label>
                                        <select multiple id="refrenece_document" name="reference_document[]"
                                            placeholder="Select Reference Records">

                                            @foreach ($preItem as $new)
                                                <option
                                                    value="{{ Helpers::getDivisionName($new->division_id) . '/QM/' . date('Y') . '/' . Helpers::recordFormat($new->record) }}">
                                                    {{ Helpers::getDivisionName($new->division_id) . '/QM/' . date('Y') . '/' . Helpers::recordFormat($new->record) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Short Description">Volume</label>
                                        <div class="relative-container">
                                            <select id="query_volume" name="query_volume">
                                                <option value="">Select Volume</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Short Description">Query Medium</label>
                                        <div class="relative-container">
                                            <select id="query_medium" name="query_medium">
                                                <option value="">Select Query Medium</option>
                                                <option value="Mail">Mail</option>
                                                <option value="Courier">Courier</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="qa-eval-attach">Mail Attachment</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting documents</small>
                                        </div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="mail_attachment"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="mail_attachment[]"
                                                    disabled oninput="addMultipleFiles(this, 'mail_attachment')" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Short Description">Assigned Reviewer</label>
                                        <div class="relative-container">
                                            <select id="assign_to" name="assign_to">
                                                <option value="">Select Assigned Reviewer</option>
                                                @if(!empty($users))
                                                    @foreach($users as $item)
                                                        <option value="{{ $item->id }}">{{ $item->name }}</option>                                                    
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="sub-head">
                                    Contact Information
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Short Description">Contact Person Mail ID</label>
                                        <div class="relative-container">
                                            <input id="contact_mailId" type="text" name="contact_mailId">
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Short Description">Contact Person Phone No.</label>
                                        <div class="relative-container">
                                            <input id="contact_mobile" type="text" name="contact_mobile">
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Short Description">Affiliation</label>
                                        <div class="relative-container">
                                            <input id="affiliation" type="text" name="affiliation">
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="qa-eval-attach">Initial Attachment</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting documents</small>
                                        </div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="initial_attachment"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="initial_attachment[]"
                                                    disabled oninput="addMultipleFiles(this, 'initial_attachment')" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="button-block">
                                <button type="submit" class="saveButton">Save</button>
                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                <button type="button"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}">Exit</a> </button>
                            </div>
                        </div>
                    </div>

                    <div id="CCForm2" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="sub-head">
                                Admin 1 Review
                            </div>
                            <div class="group-input">
                                <label for="qa-eval-comments">Admin 1 Comments</label>
                                <div class="relative-container">
                                    <textarea name="reviewer_comment"></textarea>
                                    @component('frontend.forms.language-model')
                                    @endcomponent
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="qa-eval-attach">Admin 1 Attachments</label>
                                    <div><small class="text-primary">Please Attach all relevant or supporting
                                            documents</small>
                                    </div>
                                    <div class="file-attachment-field">
                                        <div class="file-attachment-list" id="reviewer_attachment"></div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input type="file" id="myfile" name="reviewer_attachment[]"
                                                disabled oninput="addMultipleFiles(this, 'reviewer_attachment')"
                                                multiple>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="button-block">
                                <button type="submit" class="saveButton">Save</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                <button type="button"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}">
                                        Exit </a> </button>
                            </div>
                        </div>
                    </div>

                    <div id="CCForm3" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="sub-head">
                                Admin 2 Review
                            </div>
                            <div class="group-input">
                                <label for="qa-eval-comments">Admin 2 Comments</label>
                                <div class="relative-container">
                                    <textarea name="admin1_comment"></textarea>
                                    @component('frontend.forms.language-model')
                                    @endcomponent
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="qa-eval-attach">Admin 2 Attachments</label>
                                    <div><small class="text-primary">Please Attach all relevant or supporting
                                            documents</small>
                                    </div>
                                    <div class="file-attachment-field">
                                        <div class="file-attachment-list" id="admin1_attachment"></div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input type="file" id="myfile" name="admin1_attachment[]"
                                                disabled oninput="addMultipleFiles(this, 'admin1_attachment')"
                                                multiple>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="button-block">
                                <button type="submit" class="saveButton">Save</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                <button type="button"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}">
                                        Exit </a> </button>
                            </div>
                        </div>
                    </div>

                    <div id="CCForm4" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="sub-head">
                                HOD Review
                            </div>
                            <div class="group-input">
                                <label for="qa-eval-comments">HOD Comments</label>
                                <div class="relative-container">
                                    <textarea name="HOD_comment"></textarea>
                                    @component('frontend.forms.language-model')
                                    @endcomponent
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="qa-eval-attach">HOD Attachments</label>
                                    <div><small class="text-primary">Please Attach all relevant or supporting
                                            documents</small>
                                    </div>
                                    <div class="file-attachment-field">
                                        <div class="file-attachment-list" id="HOD_attachment"></div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input type="file" id="myfile" name="HOD_attachment[]"
                                                disabled oninput="addMultipleFiles(this, 'HOD_attachment')"
                                                multiple>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="button-block">
                                <button type="submit" class="saveButton">Save</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                <button type="button"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}">
                                        Exit </a> </button>
                            </div>
                        </div>
                    </div>

                    <div id="CCForm5" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                <script>
                                    $(document).ready(function() {
                                        $('.ra_review').hide();

                                        $('[name="RA_Review"]').change(function() {
                                            if ($(this).val() === 'yes') {

                                                $('.ra_review').show();
                                                $('.ra_review span').show();
                                            } else {
                                                $('.ra_review').hide();
                                                $('.ra_review span').hide();
                                            }
                                        });
                                    });
                                </script>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="RA Review"> RA Review</label>
                                        <select name="RA_Review" id="RA_Review" disabled>
                                            <option value="">-- Select --</option>
                                            <option value='yes'>Yes</option>
                                            <option value='no'>No</option>
                                            <option value='na'>NA</option>
                                        </select>
                                    </div>
                                </div>
                                @php
                                    $division = DB::table('q_m_s_divisions')
                                        ->where('name', Helpers::getDivisionName(session()->get('division')))
                                        ->first();
                                    $userRoles = DB::table('user_roles')
                                        ->where(['q_m_s_roles_id' => 22, 'q_m_s_divisions_id' => $division->id])
                                        ->get();
                                    $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                    $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                                @endphp
                                <div class="col-lg-6 ra_review">
                                    <div class="group-input">
                                        <label for="RA notification">RA Person</label>
                                        <select disabled name="RA_person" id="RA_person">
                                            <option value="">-- Select --</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}">
                                                    {{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3 ra_review">
                                    <div class="group-input">
                                        <label for="RA assessment">Impact Assessment (By RA) </label>
                                        <div><small class="text-primary">Please insert "NA" in the data field if it does
                                                not require completion</small></div>
                                        <textarea class="summernote RA_assessment" name="RA_assessment" id="summernote-17"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3 ra_review">
                                    <div class="group-input">
                                        <label for="RA feedback">RA Feedback</label>
                                        <div><small class="text-primary">Please insert "NA" in the data field if it does
                                                not require completion</small></div>
                                        <textarea class="summernote RA_feedback" name="RA_feedback" id="summernote-18"></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-12 ra_review">
                                    <div class="group-input">
                                        <label for="RA attachment"> RA Attachments</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting
                                                documents</small></div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="RA_attachment"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="RA_attachment[]"
                                                    oninput="addMultipleFiles(this, 'RA_attachment')" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3 ra_review">
                                    <div class="group-input">
                                        <label for="RA Review Completed By">RA Review Completed By</label>
                                        <input readonly type="text" name="RA_by" id="RA_by">
                                    </div>
                                </div>
                                <div class="col-lg-6 ra_review">
                                    <div class="group-input ">
                                        <label for="RA Review Completed On">RA Review Completed On</label>
                                        <input type="text" id="RA_on" readonly placeholder="DD-MMM-YYYY" />
                                        <input type="date" name="RA_on" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                            class="hide-input" oninput="handleDateInput(this, 'RA_on')" />
                                    </div>
                                </div>



                                <div class="sub-head">
                                    Quality Assurance
                                </div>
                                <script>
                                    $(document).ready(function() {
                                        $('.QualityAssurance').hide();

                                        $('[name="Quality_Assurance_Review"]').change(function() {
                                            if ($(this).val() === 'yes') {

                                                $('.QualityAssurance').show();
                                                $('.QualityAssurance span').show();
                                            } else {
                                                $('.QualityAssurance').hide();
                                                $('.QualityAssurance span').hide();
                                            }
                                        });
                                    });
                                </script>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Quality Assurance"> Quality Assurance</label>
                                        <select name="Quality_Assurance_Review" id="Quality_Assurance_Review" disabled>
                                            <option value="">-- Select --</option>
                                            <option value='yes'>Yes</option>
                                            <option value='no'>No</option>
                                            <option value='na'>NA</option>
                                        </select>

                                    </div>
                                </div>
                                @php
                                    $division = DB::table('q_m_s_divisions')
                                        ->where('name', Helpers::getDivisionName(session()->get('division')))
                                        ->first();
                                    $userRoles = DB::table('user_roles')
                                        ->where(['q_m_s_roles_id' => 22, 'q_m_s_divisions_id' => $division->id])
                                        ->get();
                                    $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                    $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                                @endphp
                                <div class="col-lg-6 QualityAssurance">
                                    <div class="group-input">
                                        <label for="Quality Assurance notification">Quality Assurance Person</label>
                                        <select name="QualityAssurance_Person" class="QualityAssurance_Person"
                                            id="QualityAssurance_Person">
                                            <option value="">-- Select --</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3 QualityAssurance">
                                    <div class="group-input">
                                        <label for="Quality Assurance assessment">Impact Assessment (By Quality
                                            Assurance)</label>
                                        <textarea class="summernote QualityAssurance_assessment" name="QualityAssurance_assessment" id="summernote-17"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3 QualityAssurance">
                                    <div class="group-input">
                                        <label for="Quality Assurance feedback">Quality Assurance Feedback</label>
                                        <textarea class="summernote QualityAssurance_feedback" name="QualityAssurance_feedback" id="summernote-18"></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-12 QualityAssurance">
                                    <div class="group-input">
                                        <label for="RA attachment"> Quality Assurance Attachments</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting
                                                documents</small></div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="Quality_Assurance_attachment"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="Quality_Assurance_attachment[]"
                                                    oninput="addMultipleFiles(this, 'Quality_Assurance_attachment')" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3 QualityAssurance">
                                    <div class="group-input">
                                        <label for="Quality Assurance Completed By">Quality Assurance Completed By</label>
                                        <input readonly type="text" name="QualityAssurance_by" id="QualityAssurance_by">
                                    </div>
                                </div>
                                <div class="col-lg-6 QualityAssurance">
                                    <div class="group-input ">
                                        <label for="Quality Assurance Completed On">Quality Assurance Completed On</label>
                                        <input type="date" id="QualityAssurance_on" name="QualityAssurance_on">
                                    </div>
                                </div>




                                <div class="sub-head">
                                    Production (Tablet/Capsule/Powder)
                                </div>
                                <script>
                                    $(document).ready(function() {
                                        $('.productionTable').hide();

                                        $('[name="Production_Table_Review"]').change(function() {
                                            if ($(this).val() === 'yes') {

                                                $('.productionTable').show();
                                                $('.productionTable span').show();
                                            } else {
                                                $('.productionTable').hide();
                                                $('.productionTable span').hide();
                                            }
                                        });
                                    });
                                </script>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Production Tablet"> Production Tablet</label>
                                        <select name="Production_Table_Review" id="Production_Table_Review" disabled>
                                            <option value="">-- Select --</option>
                                            <option value='yes'>
                                                Yes</option>
                                            <option value='no'>
                                                No</option>
                                            <option value='na'>
                                                NA</option>
                                        </select>

                                    </div>
                                </div>
                                @php
                                    $division = DB::table('q_m_s_divisions')
                                        ->where('name', Helpers::getDivisionName(session()->get('division')))
                                        ->first();
                                    $userRoles = DB::table('user_roles')
                                        ->where(['q_m_s_roles_id' => 22, 'q_m_s_divisions_id' => $division->id])
                                        ->get();
                                    $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                    $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                                @endphp
                                <div class="col-lg-6 productionTable">
                                    <div class="group-input">
                                        <label for="Production Tablet notification">Production Tablet Person</label>
                                        <select name="Production_Table_Person" class="Production_Table_Person"
                                            id="Production_Table_Person">
                                            <option value="">-- Select --</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3 productionTable">
                                    <div class="group-input">
                                        <label for="Production Tablet assessment">Impact Assessment (By Production
                                            Tablet)</label>
                                        <textarea class="summernote Production_Table_Assessment" name="Production_Table_Assessment" id="summernote-17"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3 productionTable">
                                    <div class="group-input">
                                        <label for="Production Tablet feedback">Production Tablet Feedback</label>
                                        <textarea class="summernote Production_Table_Feedback" name="Production_Table_Feedback" id="summernote-18"></textarea>
                                    </div>
                                </div>
                                <div class="col-12 productionTable">
                                    <div class="group-input">
                                        <label for="Production Tablet attachment">Production Tablet Attachments</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting
                                                documents</small></div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="Production_Table_Attachment"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="Production_Table_Attachment[]"
                                                    oninput="addMultipleFiles(this, 'Production_Table_Attachment')" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3 productionTable">
                                    <div class="group-input">
                                        <label for="Production Tablet Completed By">Production Tablet Completed By</label>
                                        <input readonly type="text" name="Production_Table_By" id="Production_Table_By">
                                    </div>
                                </div>
                                <div class="col-lg-6 productionTable">
                                    <div class="group-input ">
                                        <label for="Production Tablet Completed On">Production Tablet Completed On</label>
                                        <input type="date" id="Production_Table_On" name="Production_Table_On">
                                    </div>
                                </div>




                                <div class="sub-head">
                                    Production (Liquid/Ointment)
                                </div>
                                <script>
                                    $(document).ready(function() {
                                        $('.productionLiquid').hide();

                                        $('[name="ProductionLiquid_Review"]').change(function() {
                                            if ($(this).val() === 'yes') {

                                                $('.productionLiquid').show();
                                                $('.productionLiquid span').show();
                                            } else {
                                                $('.productionLiquid').hide();
                                                $('.productionLiquid span').hide();
                                            }
                                        });
                                    });
                                </script>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Production Liquid"> Production Liquid </label>
                                        <select name="ProductionLiquid_Review" id="ProductionLiquid_Review" disabled>
                                            <option value="">-- Select --</option>
                                            <option value='yes'>
                                                Yes</option>
                                            <option value='no'>
                                                No</option>
                                            <option value='na'>
                                                NA</option>
                                        </select>

                                    </div>
                                </div>
                                @php
                                    $division = DB::table('q_m_s_divisions')
                                        ->where('name', Helpers::getDivisionName(session()->get('division')))
                                        ->first();
                                    $userRoles = DB::table('user_roles')
                                        ->where(['q_m_s_roles_id' => 22, 'q_m_s_divisions_id' => $division->id])
                                        ->get();
                                    $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                    $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                                @endphp
                                <div class="col-lg-6 productionLiquid">
                                    <div class="group-input">
                                        <label for="Production Liquid notification">Production Liquid Person</label>
                                        <select name="ProductionLiquid_Person" class="ProductionLiquid_Person"
                                            id="ProductionLiquid_Person">
                                            <option value="">-- Select --</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3 productionLiquid">
                                    <div class="group-input">
                                        <label for="Production Liquid assessment">Impact Assessment (By Production
                                            Liquid)</label>
                                        <textarea class="summernote ProductionLiquid_assessment" name="ProductionLiquid_assessment" id="summernote-17"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3 productionLiquid">
                                    <div class="group-input">
                                        <label for="Production Liquid feedback">Production Liquid Feedback</label>
                                        <textarea class="summernote ProductionLiquid_feedback" name="ProductionLiquid_feedback" id="summernote-18"></textarea>
                                    </div>
                                </div>
                                <div class="col-12 productionLiquid">
                                    <div class="group-input">
                                        <label for="Production Liquid attachment">Production Liquid Attachments</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting
                                                documents</small></div> ProductionLiquid_attachment
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="ProductionLiquid_attachment"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="ProductionLiquid_attachment[]"
                                                    oninput="addMultipleFiles(this, 'ProductionLiquid_attachment')" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3 productionLiquid">
                                    <div class="group-input">
                                        <label for="Production Liquid Completed By">Production Liquid Completed By</label>
                                        <input readonly type="text" name="ProductionLiquid_by" id="ProductionLiquid_by">
                                    </div>
                                </div>
                                <div class="col-lg-6 productionLiquid">
                                    <div class="group-input ">
                                        <label for="Production Liquid Completed On">Production Liquid Completed On</label>
                                        <input type="date" id="ProductionLiquid_on" name="ProductionLiquid_on">
                                    </div>
                                </div>


                                <div class="sub-head">
                                    Production Injection
                                </div>
                                <script>
                                    $(document).ready(function() {
                                        $('.productionInjection').hide();

                                        $('[name="Production_Injection_Review"]').change(function() {
                                            if ($(this).val() === 'yes') {

                                                $('.productionInjection').show();
                                                $('.productionInjection span').show();
                                            } else {
                                                $('.productionInjection').hide();
                                                $('.productionInjection span').hide();
                                            }
                                        });
                                    });
                                </script>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Production Injection"> Production Injection </label>
                                        <select name="Production_Injection_Review" id="Production_Injection_Review" disabled>
                                            <option value="">-- Select --</option>
                                            <option value='yes'>
                                                Yes</option>
                                            <option value='no'>
                                                No</option>
                                            <option value='na'>
                                                NA</option>
                                        </select>

                                    </div>
                                </div>
                                @php
                                    $division = DB::table('q_m_s_divisions')
                                        ->where('name', Helpers::getDivisionName(session()->get('division')))
                                        ->first();
                                    $userRoles = DB::table('user_roles')
                                        ->where(['q_m_s_roles_id' => 22, 'q_m_s_divisions_id' => $division->id])
                                        ->get();
                                    $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                    $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                                @endphp
                                <div class="col-lg-6 productionInjection">
                                    <div class="group-input">
                                        <label for="Production Injection notification">Production Injection Person</label>
                                        <select class="Production_Injection_Person" id="Production_Injection_Person">
                                            <option value="">-- Select --</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3 productionInjection">
                                    <div class="group-input">
                                        <label for="Production Injection assessment">Impact Assessment (By Production
                                            Injection)</label>
                                        <textarea class="summernote Production_Injection_Assessment" name="Production_Injection_Assessment"
                                            id="summernote-17"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3 productionInjection">
                                    <div class="group-input">
                                        <label for="Production Injection feedback">Production Injection Feedback </label>
                                        <textarea class="summernote Production_Injection_Feedback" name="Production_Injection_Feedback" id="summernote-18"></textarea>
                                    </div>
                                </div>
                                <div class="col-12 productionInjection">
                                    <div class="group-input">
                                        <label for="Production Injection attachment">Production Injection
                                            Attachments</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting
                                                documents</small></div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="Production_Injection_Attachment"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="Production_Injection_Attachment[]"
                                                    oninput="addMultipleFiles(this, 'Production_Injection_Attachment')" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3 productionInjection">
                                    <div class="group-input">
                                        <label for="Production Injection Completed By">Production Injection Completed
                                            By</label>
                                        <input readonly type="text" name="Production_Injection_By" id="Production_Injection_By">
                                    </div>
                                </div>
                                <div class="col-lg-6 productionInjection">
                                    <div class="group-input ">
                                        <label for="Production Injection Completed On">Production Injection Completed
                                            On</label>
                                        <input type="date"id="Production_Injection_On" name="Production_Injection_On">
                                    </div>
                                </div>




                                <div class="sub-head">
                                    Stores
                                </div>
                                <script>
                                    $(document).ready(function() {
                                        $('.store').hide();

                                        $('[name="Store_Review"]').change(function() {
                                            if ($(this).val() === 'yes') {

                                                $('.store').show();
                                                $('.store span').show();
                                            } else {
                                                $('.store').hide();
                                                $('.store span').hide();
                                            }
                                        });
                                    });
                                </script>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Store"> Store</label>
                                        <select name="Store_Review" id="Store_Review" disabled>
                                            <option value="">-- Select --</option>
                                            <option value='yes'>
                                                Yes</option>
                                            <option value='no'>
                                                No</option>
                                            <option value='na'>
                                                NA</option>
                                        </select>

                                    </div>
                                </div>
                                @php
                                    $division = DB::table('q_m_s_divisions')
                                        ->where('name', Helpers::getDivisionName(session()->get('division')))
                                        ->first();
                                    $userRoles = DB::table('user_roles')
                                        ->where(['q_m_s_roles_id' => 23, 'q_m_s_divisions_id' => $division->id])
                                        ->get();
                                    $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                    $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                                @endphp
                                <div class="col-lg-6 store">
                                    <div class="group-input">
                                        <label for="Store notification">Store Person</label>
                                        <select name="Store_Person" class="Store_Person" id="Store_Person">
                                            <option value="">-- Select --</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3 store">
                                    <div class="group-input">
                                        <label for="Store assessment">Impact Assessment (By Store)</label>
                                        <textarea class="summernote Store_assessment" name="Store_assessment" id="summernote-17"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3 store">
                                    <div class="group-input">
                                        <label for="Store feedback">Store Feedback</label>
                                        <textarea class="summernote Store_feedback" name="Store_feedback" id="summernote-18"></textarea>
                                    </div>
                                </div>
                                <div class="col-12 store">
                                    <div class="group-input">
                                        <label for="Store attachment">Store Attachments</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting
                                                documents</small></div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="Store_attachment"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="Store_attachment[]"
                                                    oninput="addMultipleFiles(this, 'Store_attachment')" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3 store">
                                    <div class="group-input">
                                        <label for="Store Completed By">Store Completed By</label>
                                        <input readonly type="text" name="Store_by" id="Store_by">
                                    </div>
                                </div>
                                <div class="col-lg-6 store">
                                    <div class="group-input ">
                                        <label for="Store Completed On">Store Completed On</label>
                                        <input type="date"id="Store_on" name="Store_on">
                                    </div>
                                </div>


                                <div class="sub-head">
                                    Quality Control
                                </div>
                                <script>
                                    $(document).ready(function() {
                                        $('.quality_control').hide();

                                        $('[name="Quality_review"]').change(function() {
                                            if ($(this).val() === 'yes') {
                                                $('.quality_control').show();
                                                $('.quality_control span').show();
                                            } else {
                                                $('.quality_control').hide();
                                                $('.quality_control span').hide();
                                            }
                                        });
                                    });
                                </script>
                                <div class="col-lg-6 quality_control">
                                    <div class="group-input">
                                        <label for="Quality Control Review Required">Quality Control Review Required
                                            ?</label>
                                        <select name="Quality_review" id="Quality_review" disabled>
                                            <option value="">-- Select --</option>
                                            <option value="yes">Yes</option>
                                            <option value="no">No</option>
                                            <option value="na">NA</option>

                                        </select>

                                    </div>
                                </div>
                                @php
                                    $division = DB::table('q_m_s_divisions')
                                        ->where('name', Helpers::getDivisionName(session()->get('division')))
                                        ->first();
                                    $userRoles = DB::table('user_roles')
                                        ->where(['q_m_s_roles_id' => 24, 'q_m_s_divisions_id' => $division->id])
                                        ->get();
                                    $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                    $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                                @endphp
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Quality Control Person">Quality Control Person</label>
                                        <select name="Quality_Control_Person" id="Quality_Control_Person" disabled>
                                            <option value="">-- Select --</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>
                                <div class="col-md-12 mb-3 quality_control">
                                    <div class="group-input">
                                        <label for="Impact Assessment2">Impact Assessment (By Quality Control)</label>
                                        <textarea class="" name="Quality_Control_assessment" id="summernote-21">
                                                                            </textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3 quality_control">
                                    <div class="group-input">
                                        <label for="Quality Control Feedback">Quality Control Feedback</label>
                                        <textarea class="" name="Quality_Control_feedback" id="summernote-22">
                                                                            </textarea>
                                    </div>
                                </div>
                                <div class="col-lg-12 quality_control">
                                    <div class="group-input">
                                        <label for="Quality Control Attachments">Quality Control Attachments</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting
                                                documents</small></div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="Quality_Control_attachment"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="Quality_Control_attachment[]"
                                                    oninput="addMultipleFiles(this, 'Quality_Control_attachment')" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3 quality_control">
                                    <div class="group-input">
                                        <label for="productionfeedback">Quality Control Review Completed By</label>
                                        <input type="text" name="QualityAssurance__by" disabled>

                                    </div>
                                </div>
                                <div class="col-lg-6 new-date-data-field quality_control">
                                    <div class="group-input input-date">
                                        <label for="Quality Control Review Completed On">Quality Control Review Completed
                                            On</label>
                                        <div class="calenderauditee">
                                            <input type="text" id="Quality_Control_on" readonly placeholder="DD-MMM-YYYY" />
                                            <input type="date" name="Quality_Control_on"
                                                min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input"
                                                oninput="handleDateInput(this, 'Quality_Control_on')" />
                                        </div>
                                    </div>
                                </div>


                                <div class="sub-head">
                                    Research & Development
                                </div>
                                <script>
                                    $(document).ready(function() {
                                        $('.researchDevelopment').hide();

                                        $('[name="ResearchDevelopment_Review"]').change(function() {
                                            if ($(this).val() === 'yes') {

                                                $('.researchDevelopment').show();
                                                $('.researchDevelopment span').show();
                                            } else {
                                                $('.researchDevelopment').hide();
                                                $('.researchDevelopment span').hide();
                                            }
                                        });
                                    });
                                </script>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Research Development"> Research Development Required ?</label>
                                        <select name="ResearchDevelopment_Review" id="ResearchDevelopment_Review" disabled>
                                            <option value="">-- Select --</option>
                                            <option value='yes'>
                                                Yes</option>
                                            <option value='no'>
                                                No</option>
                                            <option value='na'>
                                                NA</option>
                                        </select>

                                    </div>
                                </div>
                                @php
                                    $division = DB::table('q_m_s_divisions')
                                        ->where('name', Helpers::getDivisionName(session()->get('division')))
                                        ->first();
                                    $userRoles = DB::table('user_roles')
                                        ->where(['q_m_s_roles_id' => 22, 'q_m_s_divisions_id' => $division->id])
                                        ->get();
                                    $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                    $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                                @endphp
                                <div class="col-lg-6 researchDevelopment">
                                    <div class="group-input">
                                        <label for="Research Development notification">Research Development Person</label>
                                        <select name="ResearchDevelopmentStore_Person" class="ResearchDevelopment_Person"
                                            id="ResearchDevelopment_Person">
                                            <option value="">-- Select --</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3 researchDevelopment">
                                    <div class="group-input">
                                        <label for="Research Development assessment">Impact Assessment (By Research
                                            Development)</label>
                                        <textarea class="summernote ResearchDevelopment_assessment" name="ResearchDevelopment_assessment" id="summernote-17"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3 researchDevelopment">
                                    <div class="group-input">
                                        <label for="Research Development feedback">Research Development Feedback</label>
                                        <textarea class="summernote ResearchDevelopment_feedback" name="ResearchDevelopment_feedback" id="summernote-18"></textarea>
                                    </div>
                                </div>
                                <div class="col-12 researchDevelopment">
                                    <div class="group-input">
                                        <label for="Research Development attachment">Research Development
                                            Attachments</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting
                                                documents</small></div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="ResearchDevelopment_attachment"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="ResearchDevelopment_attachment[]"
                                                    oninput="addMultipleFiles(this, 'ResearchDevelopment_attachment')" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3 researchDevelopment">
                                    <div class="group-input">
                                        <label for="Research Development Completed By">Research Development Completed
                                            By</label>
                                        <input readonly type="text" name="ResearchDevelopment_by" id="ResearchDevelopment_by">
                                    </div>
                                </div>
                                <div class="col-lg-6 researchDevelopment">
                                    <div class="group-input ">
                                        <label for="Research Development Completed On">Research Development Complete
                                            On</label>
                                        <input type="date" id="ResearchDevelopment_on" name="ResearchDevelopment_on">
                                    </div>
                                </div>


                                <div class="sub-head">
                                    Engineering
                                </div>
                                <script>
                                    $(document).ready(function() {
                                        $('.engineering').hide();

                                        $('[name="Engineering_review"]').change(function() {
                                            if ($(this).val() === 'yes') {
                                                $('.engineering').show();
                                                $('.engineering span').show();
                                            } else {
                                                $('.engineering').hide();
                                                $('.engineering span').hide();
                                            }
                                        });
                                    });
                                </script>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Engineering Review Required">Engineering Review Required ?</label>
                                        <select name="Engineering_review" id="Engineering_review" disabled>
                                            <option value="">-- Select --</option>
                                            <option value="yes">Yes</option>
                                            <option value="no">No</option>
                                            <option value="na">NA</option>
                                        </select>

                                    </div>
                                </div>
                                @php
                                    $division = DB::table('q_m_s_divisions')
                                        ->where('name', Helpers::getDivisionName(session()->get('division')))
                                        ->first();
                                    $userRoles = DB::table('user_roles')
                                        ->where(['q_m_s_roles_id' => 26, 'q_m_s_divisions_id' => $division->id])
                                        ->get();
                                    $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                    $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                                @endphp
                                <div class="col-lg-6 engineering">
                                    <div class="group-input">
                                        <label for="Engineering Person">Engineering Person</label>
                                        <select name="Engineering_person" id="Engineering_person">
                                            <option value="">-- Select --</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>
                                <div class="col-md-12 mb-3 engineering">
                                    <div class="group-input">
                                        <label for="Impact Assessment4">Impact Assessment (By Engineering)</label>
                                        <div><small class="text-primary">Please insert "NA" in the data field if it does
                                                not require completion</small></div>
                                        <textarea class="" name="Engineering_assessment" id="summernote-25">
                                                                            </textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3 engineering">
                                    <div class="group-input">
                                        <label for="productionfeedback">Engineering Feedback</label>
                                        <div><small class="text-primary">Please insert "NA" in the data field if it does
                                                not require completion</small></div>
                                        <textarea class="" name="Engineering_feedback" id="summernote-26">
                                                                            </textarea>
                                    </div>
                                </div>
                                <div class="col-lg-12 engineering">
                                    <div class="group-input">
                                        <label for="Audit Attachments">Engineering Attachments</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting
                                                documents</small></div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="Engineering_attachment"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="Engineering_attachment[]"
                                                    oninput="addMultipleFiles(this, 'Engineering_attachment')" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3 engineering">
                                    <div class="group-input">
                                        <label for="Engineering Review Completed By">Engineering Review Completed
                                            By</label>
                                        <input type="text" name="Engineering_by" id="Engineering_by" disabled>

                                    </div>
                                </div>
                                <div class="col-lg-6 new-date-data-field engineering">
                                    <div class="group-input input-date">
                                        <label for="Engineering Review Completed On">Engineering Review Completed
                                            On</label>
                                        <div class="calenderauditee">
                                            <input type="text" id="Engineering_on" readonly placeholder="DD-MMM-YYYY" />
                                            <input type="date" name="Engineering_on"
                                                min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input"
                                                oninput="handleDateInput(this, 'Engineering_on')" />
                                        </div>
                                    </div>
                                </div>




                                <div class="sub-head">
                                    Human Resource
                                </div>
                                <script>
                                    $(document).ready(function() {
                                        $('.human_resources').hide();

                                        $('[name="Human_Resource_review"]').change(function() {
                                            if ($(this).val() === 'yes') {
                                                $('.human_resources').show();
                                                $('.human_resources span').show();
                                            } else {
                                                $('.human_resources').hide();
                                                $('.human_resources span').hide();
                                            }
                                        });
                                    });
                                </script>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Administration Review Required">Human Resource
                                            Required ?</label>
                                        <select name="Human_Resource_review" id="Human_Resource_review" disabled>
                                            <option value="">-- Select --</option>
                                            <option value="yes">Yes</option>
                                            <option value="no">No</option>
                                            <option value="na">NA</option>

                                        </select>

                                    </div>
                                </div>
                                @php
                                    $division = DB::table('q_m_s_divisions')
                                        ->where('name', Helpers::getDivisionName(session()->get('division')))
                                        ->first();
                                    $userRoles = DB::table('user_roles')
                                        ->where(['q_m_s_roles_id' => 31, 'q_m_s_divisions_id' => $division->id])
                                        ->get();
                                    $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                    $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                                @endphp
                                <div class="col-lg-6 human_resources">
                                    <div class="group-input">
                                        <label for="Administration Person"> Human Resource Person</label>
                                        <select name="Human_Resource_person" id="Human_Resource_person">
                                            <option value="">-- Select --</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3 human_resources">
                                    <div class="group-input">
                                        <label for="Impact Assessment9">Impact Assessment (By Human Resource )</label>
                                        <textarea class="" name="Human_Resource_assessment" id="summernote-35"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3 human_resources">
                                    <div class="group-input">
                                        <label for="productionfeedback">Human Resource Feedback</label>
                                        <textarea class="" name="Human_Resource_feedback" id="summernote-36"></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-12 human_resources">
                                    <div class="group-input">
                                        <label for="Audit Attachments"> Human Resource
                                            Attachments</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting
                                                documents</small></div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="Human_Resource_attachment"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="Human_Resource_attachment[]"
                                                    oninput="addMultipleFiles(this, 'Human_Resource_attachment')" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3 human_resources">
                                    <div class="group-input">
                                        <label for="Administration Review Completed By"> Human Resource Review Completed
                                            By</label>
                                        <input type="text" name="Human_Resource_by" id="Human_Resource_by" disabled>

                                    </div>
                                </div>
                                <div class="col-lg-6 new-date-data-field human_resources">
                                    <div class="group-input input-date">
                                        <label for="Administration Review Completed On">Human Resource Review Completed
                                            On</label>
                                        <div class="calenderauditee">
                                            <input type="text" id="Human_Resource_on" readonly placeholder="DD-MMM-YYYY" />
                                            <input type="date" name="Human_Resource_on"
                                                min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input"
                                                oninput="handleDateInput(this, 'Human_Resource_on')" />
                                        </div>
                                    </div>
                                </div>



                                <div class="sub-head">
                                    Microbiology
                                </div>
                                <script>
                                    $(document).ready(function() {
                                        $('.Microbiology').hide();

                                        $('[name="Microbiology_Review"]').change(function() {
                                            if ($(this).val() === 'yes') {

                                                $('.Microbiology').show();
                                                $('.Microbiology span').show();
                                            } else {
                                                $('.Microbiology').hide();
                                                $('.Microbiology span').hide();
                                            }
                                        });
                                    });
                                </script>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Microbiology"> Microbiology Required ?</label>
                                        <select name="Microbiology_Review" id="Microbiology_Review" disabled>
                                            <option value="">-- Select --</option>
                                            <option value='yes'>
                                                Yes</option>
                                            <option value='no'>
                                                No</option>
                                            <option value='na'>
                                                NA</option>
                                        </select>

                                    </div>
                                </div>
                                @php
                                    $division = DB::table('q_m_s_divisions')
                                        ->where('name', Helpers::getDivisionName(session()->get('division')))
                                        ->first();
                                    $userRoles = DB::table('user_roles')
                                        ->where(['q_m_s_roles_id' => 22, 'q_m_s_divisions_id' => $division->id])
                                        ->get();
                                    $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                    $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                                @endphp
                                <!--  -->
                                <div class="col-md-12 mb-3 Microbiology">
                                    <div class="group-input">
                                        <label for="Microbiology assessment">Impact Assessment (By Microbiology)</label>
                                        <textarea class="summernote Microbiology_assessment" name="Microbiology_assessment" id="summernote-17"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3 Microbiology">
                                    <div class="group-input">
                                        <label for="Microbiology feedback">Microbiology Feedback</label>
                                        <textarea class="summernote Microbiology_feedback" name="Microbiology_feedback" id="summernote-18"></textarea>
                                    </div>
                                </div>
                                <div class="col-12 Microbiology">
                                    <div class="group-input">
                                        <label for="Microbiology attachment">Microbiology Attachments</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting
                                                documents</small></div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="Microbiology_attachment"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="Microbiology_attachment[]"
                                                    oninput="addMultipleFiles(this, 'Microbiology_attachment')" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3 Microbiology">
                                    <div class="group-input">
                                        <label for="Microbiology Completed By">Microbiology Completed By</label>
                                        <input readonly type="text" name="Microbiology_by" id="Microbiology_by">
                                    </div>
                                </div>
                                <div class="col-lg-6 Microbiology">
                                    <div class="group-input ">
                                        <label for="Microbiology Completed On">Microbiology Completed On</label>
                                        <input type="date" id="Microbiology_on" name="Microbiology_on">
                                    </div>
                                </div>



                                <div class="sub-head">
                                    Regulatory Affair
                                </div>
                                <script>
                                    $(document).ready(function() {
                                        $('.RegulatoryAffair').hide();

                                        $('[name="RegulatoryAffair_Review"]').change(function() {
                                            if ($(this).val() === 'yes') {

                                                $('.RegulatoryAffair').show();
                                                $('.RegulatoryAffair span').show();
                                            } else {
                                                $('.RegulatoryAffair').hide();
                                                $('.RegulatoryAffair span').hide();
                                            }
                                        });
                                    });
                                </script>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="RegulatoryAffair"> Regulatory Affair Required ?</label>
                                        <select name="RegulatoryAffair_Review" id="RegulatoryAffair_Review" disabled>
                                            <option value="">-- Select --</option>
                                            <option value='yes'>
                                                Yes</option>
                                            <option value='no'>
                                                No</option>
                                            <option value='na'>
                                                NA</option>
                                        </select>

                                    </div>
                                </div>
                                @php
                                    $division = DB::table('q_m_s_divisions')
                                        ->where('name', Helpers::getDivisionName(session()->get('division')))
                                        ->first();
                                    $userRoles = DB::table('user_roles')
                                        ->where(['q_m_s_roles_id' => 22, 'q_m_s_divisions_id' => $division->id])
                                        ->get();
                                    $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                    $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                                @endphp
                                <div class="col-lg-6 RegulatoryAffair">
                                    <div class="group-input">
                                        <label for="Regulatory Affair notification">Regulatory Affair Person</label>
                                        <select name="RegulatoryAffair_Person" class="RegulatoryAffair_Person"
                                            id="RegulatoryAffair_Person">
                                            <option value="">-- Select --</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3 RegulatoryAffair">
                                    <div class="group-input">
                                        <label for="Regulatory Affair assessment">Impact Assessment (By Regulatory
                                            Affair)</label>
                                        <textarea class="summernote RegulatoryAffair_assessment" name="RegulatoryAffair_assessment" id="summernote-17"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3 RegulatoryAffair">
                                    <div class="group-input">
                                        <label for="Regulatory Affair feedback">Regulatory Affair Feedback</label>
                                        <textarea class="summernote RegulatoryAffair_feedback" name="RegulatoryAffair_feedback" id="summernote-18"></textarea>
                                    </div>
                                </div>
                                <div class="col-12 RegulatoryAffair">
                                    <div class="group-input">
                                        <label for="Regulatory Affair attachment">Regulatory Affair Attachments</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting
                                                documents</small></div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="RegulatoryAffair_attachment"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="RegulatoryAffair_attachment[]"
                                                    oninput="addMultipleFiles(this, 'RegulatoryAffair_attachment')" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3 RegulatoryAffair">
                                    <div class="group-input">
                                        <label for="Regulatory Affair Completed By">Regulatory Affair Completed By</label>
                                        <input readonly type="text" name="RegulatoryAffair_by" id="RegulatoryAffair_by">
                                    </div>
                                </div>
                                <div class="col-lg-6 RegulatoryAffair">
                                    <div class="group-input ">
                                        <label for="Regulatory Affair Completed On">Regulatory Affair Completed On</label>
                                        <input type="date"id="RegulatoryAffair_on" name="RegulatoryAffair_on">
                                    </div>
                                </div>


                                <div class="sub-head">
                                    Corporate Quality Assurance
                                </div>
                                <script>
                                    $(document).ready(function() {
                                        $('.CQA').hide();

                                        $('[name="CorporateQualityAssurance_Review"]').change(function() {
                                            if ($(this).val() === 'yes') {

                                                $('.CQA').show();
                                                $('.CQA span').show();
                                            } else {
                                                $('.CQA').hide();
                                                $('.CQA span').hide();
                                            }
                                        });
                                    });
                                </script>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Corporate Quality Assurance"> Corporate Quality Assurance Required
                                            ?</label>
                                        <select name="CorporateQualityAssurance_Review" id="CorporateQualityAssurance_Review" disabled>
                                            <option value="">-- Select --</option>
                                            <option value='yes'>
                                                Yes</option>
                                            <option value='no'>
                                                No</option>
                                            <option value='na'>
                                                NA</option>
                                        </select>

                                    </div>
                                </div>
                                @php
                                    $division = DB::table('q_m_s_divisions')
                                        ->where('name', Helpers::getDivisionName(session()->get('division')))
                                        ->first();
                                    $userRoles = DB::table('user_roles')
                                        ->where(['q_m_s_roles_id' => 22, 'q_m_s_divisions_id' => $division->id])
                                        ->get();
                                    $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                    $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                                @endphp
                                <div class="col-lg-6 CQA">
                                    <div class="group-input">
                                        <label for="Corporate Quality Assurance notification">Corporate Quality Assurance
                                            Person</label>
                                        <select name="CorporateQualityAssurance_Person" class="CorporateQualityAssurance_Person"
                                            id="CorporateQualityAssurance_Person">
                                            <option value="">-- Select --</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3 CQA">
                                    <div class="group-input">
                                        <label for="Corporate Quality Assurance assessment">Impact Assessment (By
                                            Corporate Quality Assurance)</label>
                                        <textarea class="summernote CorporateQualityAssurance_assessment" readonly name="CorporateQualityAssurance_assessment"
                                            id="summernote-17"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3 CQA">
                                    <div class="group-input">
                                        <label for="Corporate Quality Assurance feedback">Corporate Quality Assurance
                                            Feedback</label>
                                        <textarea class="summernote CorporateQualityAssurance_feedback" name="CorporateQualityAssurance_feedback"
                                            id="summernote-18"></textarea>
                                    </div>
                                </div>
                                <div class="col-12 CQA">
                                    <div class="group-input">
                                        <label for="Corporate Quality Assurance attachment">Corporate Quality Assurance
                                            Attachments</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting
                                                documents</small></div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="CorporateQualityAssurance_attachment">
                                            </div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="CorporateQualityAssurance_attachment[]"
                                                    oninput="addMultipleFiles(this, 'CorporateQualityAssurance_attachment')" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3 CQA">
                                    <div class="group-input">
                                        <label for="Corporate Quality Assurance Completed By">Corporate Quality Assurance
                                            Completed By</label>
                                        <input readonly type="text" name="CorporateQualityAssurance_by"
                                            id="CorporateQualityAssurance_by">
                                    </div>
                                </div>
                                <div class="col-lg-6 CQA">
                                    <div class="group-input ">
                                        <label for="Corporate Quality Assurance Completed On">Corporate Quality Assurance
                                            Completed On</label>
                                        <input type="date"id="CorporateQualityAssurance_on" name="CorporateQualityAssurance_on">
                                    </div>
                                </div>


                                <div class="sub-head">
                                    Safety
                                </div>
                                <script>
                                    $(document).ready(function() {
                                        $('.environmental_health').hide();

                                        $('[name="Environment_Health_review"]').change(function() {
                                            if ($(this).val() === 'yes') {
                                                $('.environmental_health').show();
                                                $('.environmental_health span').show();
                                            } else {
                                                $('.environmental_health').hide();
                                                $('.environmental_health span').hide();
                                            }
                                        });
                                    });
                                </script>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Safety Review Required">Safety Review Required
                                            ?</label>
                                        <select name="Environment_Health_review" id="Environment_Health_review" disabled>
                                            <option value="">-- Select --</option>
                                            <option value="yes">Yes</option>
                                            <option value="no">No</option>
                                            <option value="na">NA</option>

                                        </select>

                                    </div>
                                </div>
                                @php
                                    $division = DB::table('q_m_s_divisions')
                                        ->where('name', Helpers::getDivisionName(session()->get('division')))
                                        ->first();
                                    $userRoles = DB::table('user_roles')
                                        ->where(['q_m_s_roles_id' => 30, 'q_m_s_divisions_id' => $division->id])
                                        ->get();
                                    $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                    $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                                @endphp
                                <div class="col-lg-6 environmental_health">
                                    <div class="group-input">
                                        <label for="Safety Person"> Safety Person</label>
                                        <select name="Environment_Health_Safety_person" id="Environment_Health_Safety_person">
                                            <option value="">-- Select --</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>
                                <div class="col-md-12 mb-3 environmental_health">
                                    <div class="group-input">
                                        <label for="Impact Assessment8">Impact Assessment (By Safety)</label>
                                        <textarea class="" name="Health_Safety_assessment" id="summernote-33">
                                                                            </textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3 environmental_health">
                                    <div class="group-input">
                                        <label for="productionfeedback">Safety Feedback</label>
                                        <textarea class="" name="Health_Safety_feedback" id="summernote-34">
                                                                            </textarea>
                                    </div>
                                </div>
                                <div class="col-lg-12 environmental_health">
                                    <div class="group-input">
                                        <label for="Audit Attachments"> Safety Attachments</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting
                                                documents</small></div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="Environment_Health_Safety_attachment">
                                            </div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="Environment_Health_Safety_attachment[]"
                                                    oninput="addMultipleFiles(this, 'Environment_Health_Safety_attachment')" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3 environmental_health">
                                    <div class="group-input">
                                        <label for="productionfeedback">Safety Review Completed
                                            By</label>
                                        <input type="text" name="Environment_Health_Safety_by" id="Environment_Health_Safety_by"
                                            disabled>

                                    </div>
                                </div>
                                <div class="col-lg-6 new-date-data-field environmental_health">
                                    <div class="group-input input-date">
                                        <label for="Safety Review Completed On">Safety Review
                                            Completed On</label>
                                        <div class="calenderauditee">
                                            <input type="text" id="Environment_Health_Safety_on" readonly
                                                placeholder="DD-MMM-YYYY" />
                                            <input type="date" name="Environment_Health_Safety_on"
                                                min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input"
                                                oninput="handleDateInput(this, 'Environment_Health_Safety_on')" />
                                        </div>
                                    </div>
                                </div>


                                <div class="sub-head">
                                    Information Technology
                                </div>
                                <script>
                                    $(document).ready(function() {
                                        $('.information_technology').hide();

                                        $('[name="Information_Technology_review"]').change(function() {
                                            if ($(this).val() === 'yes') {
                                                $('.information_technology').show();
                                                $('.information_technology span').show();
                                            } else {
                                                $('.information_technology').hide();
                                                $('.information_technology span').hide();
                                            }
                                        });
                                    });
                                </script>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Information Technology Review Required"> Information Technology Review
                                            Required ?</label>
                                        <select name=" Information_Technology_review" id=" Information_Technology_review" disabled>
                                            <option value="">-- Select --</option>
                                            <option value="yes">Yes</option>
                                            <option value="no">No</option>
                                            <option value="na">NA</option>

                                        </select>

                                    </div>
                                </div>
                                @php
                                    $division = DB::table('q_m_s_divisions')
                                        ->where('name', Helpers::getDivisionName(session()->get('division')))
                                        ->first();
                                    $userRoles = DB::table('user_roles')
                                        ->where(['q_m_s_roles_id' => 32, 'q_m_s_divisions_id' => $division->id])
                                        ->get();
                                    $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                    $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                                @endphp
                                <div class="col-lg-6 information_technology">
                                    <div class="group-input">
                                        <label for="Information Technology Person"> Information Technology Person</label>
                                        <select name=" Information_Technology_person" id=" Information_Technology_person">
                                            <option value="">-- Select --</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>
                                <div class="col-md-12 mb-3 information_technology">
                                    <div class="group-input">
                                        <label for="Impact Assessment10">Impact Assessment (By Information
                                            Technology)</label>
                                        <textarea class="" name="Information_Technology_assessment" id="summernote-37">
                                                                            </textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3 information_technology">
                                    <div class="group-input">
                                        <label for="Information Technology Feedback"> Information Technology
                                            Feedback</label>
                                        <textarea class="" name="Information_Technology_feedback" id="summernote-38">
                                                                            </textarea>
                                    </div>
                                </div>
                                <div class="col-lg-12 information_technology">
                                    <div class="group-input">
                                        <label for="Audit Attachments"> Information Technology Attachments</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting
                                                documents</small></div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="Information_Technology_attachment">
                                            </div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="Information_Technology_attachment[]"
                                                    oninput="addMultipleFiles(this, 'Information_Technology_attachment')" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3 information_technology">
                                    <div class="group-input">
                                        <label for="Information Technology Review Completed By"> Information Technology
                                            Review Completed By</label>
                                        <input type="text" name="Information_Technology_by" disabled>

                                    </div>
                                </div>
                                <div class="col-lg-6 new-date-data-field information_technology">
                                    <div class="group-input input-date">
                                        <label for="Information Technology Review Completed On">Information Technology
                                            Review Completed On</label>
                                        <div class="calenderauditee">
                                            <input type="text" id="Information_Technology_on" readonly placeholder="DD-MMM-YYYY" />
                                            <input type="date" name="Information_Technology_on"
                                                min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input"
                                                oninput="handleDateInput(this, 'Information_Technology_on')" />
                                        </div>
                                    </div>
                                </div>



                                <div class="sub-head">
                                    Contract Giver
                                </div>
                                <script>
                                    $(document).ready(function() {
                                        $('.ContractGiver').hide();

                                        $('[name="ContractGiver_Review"]').change(function() {
                                            if ($(this).val() === 'yes') {

                                                $('.ContractGiver').show();
                                                $('.ContractGiver span').show();
                                            } else {
                                                $('.ContractGiver').hide();
                                                $('.ContractGiver span').hide();
                                            }
                                        });
                                    });
                                </script>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Contract Giver"> Contract Giver Required ? </label>
                                        <select name="ContractGiver_Review" id="ContractGiver_Review" disabled>
                                            <option value="">-- Select --</option>
                                            <option value='yes'>
                                                Yes</option>
                                            <option value='no'>
                                                No</option>
                                            <option value='na'>
                                                NA</option>
                                        </select>

                                    </div>
                                </div>
                                @php
                                    $division = DB::table('q_m_s_divisions')
                                        ->where('name', Helpers::getDivisionName(session()->get('division')))
                                        ->first();
                                    $userRoles = DB::table('user_roles')
                                        ->where(['q_m_s_roles_id' => 22, 'q_m_s_divisions_id' => $division->id])
                                        ->get();
                                    $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                    $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                                @endphp
                                <div class="col-lg-6 store">
                                    <div class="group-input">
                                        <label for="Contract Giver notification">Contract Giver Person</label>
                                        <select name="ContractGiver_Person" class="ContractGiver_Person" id="ContractGiver_Person">
                                            <option value="">-- Select --</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}">
                                                    {{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3 store">
                                    <div class="group-input">
                                        <label for="Contract Giver assessment">Impact Assessment (By Contract
                                            Giver)</label>
                                        <textarea class="summernote ContractGiver_assessment" name="ContractGiver_assessment" id="summernote-17"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3 store">
                                    <div class="group-input">
                                        <label for="Contract Giver feedback">Contract Giver Feedback</label>
                                        <textarea class="summernote ContractGiver_feedback" name="ContractGiver_feedback" id="summernote-18"></textarea>
                                    </div>
                                </div>
                                <div class="col-12 store">
                                    <div class="group-input">
                                        <label for="Contract Giver attachment">Contract Giver Attachments</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting
                                                documents</small></div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="ContractGiver_attachment"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="ContractGiver_attachment[]"
                                                    oninput="addMultipleFiles(this, 'ContractGiver_attachment')" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3 store">
                                    <div class="group-input">
                                        <label for="Contract Giver Completed By">Contract Giver Completed
                                            By</label>
                                        <input readonly type="text" name="ContractGiver_by" id="ContractGiver_by">
                                    </div>
                                </div>
                                <div class="col-lg-6 store">
                                    <div class="group-input ">
                                        <label for="Contract Giver Completed On">Contract Giver Completed On</label>
                                        <input type="date"id="ContractGiver_on" name="ContractGiver_on">
                                    </div>
                                </div>


                                <div class="sub-head">
                                    Other's 1 ( Additional Person Review From Departments If Required)
                                </div>
                                <script>
                                    $(document).ready(function() {
                                        $('.other1_reviews').hide();

                                        $('[name="Other1_review"]').change(function() {
                                            if ($(this).val() === 'yes') {
                                                $('.other1_reviews').show();
                                                $('.other1_reviews span').show();
                                            } else {
                                                $('.other1_reviews').hide();
                                                $('.other1_reviews span').hide();
                                            }
                                        });
                                    });
                                </script>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Customer notification"> Other's 1 Review Required ?</label>
                                        <select name="Other1_review" id="Other1_review" disabled>
                                            <option value="">-- Select --</option>
                                            <option value="yes">Yes</option>
                                            <option value="no">No</option>
                                            <option value="na">NA</option>

                                        </select>

                                    </div>
                                </div>
                                @php
                                    $division = DB::table('q_m_s_divisions')
                                        ->where('name', Helpers::getDivisionName(session()->get('division')))
                                        ->first();
                                    $userRoles = DB::table('user_roles')
                                        ->where(['q_m_s_roles_id' => 34, 'q_m_s_divisions_id' => $division->id])
                                        ->get();
                                    $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                    $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                                @endphp
                                <div class="col-lg-6 other1_reviews">
                                    <div class="group-input">
                                        <label for="Customer notification"> Other's 1 Person</label>
                                        <select name="Other1_person" id="Other1_person">
                                            <option value="">-- Select --</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach

                                        </select>

                                    </div>
                                </div>
                                <div class="col-lg-12 other1_reviews">
                                    <div class="group-input">
                                        <label for="Customer notification"> Other's 1 Department</label>
                                        <select name="Other1_Department_person" id="Other1_Department_person">
                                            <option value="">-- Select --</option>
                                            <option value="Production">Production</option>
                                            <option value="Warehouse">Warehouse</option>
                                            <option value="Quality_Control">Quality Control</option>
                                            <option value="Quality_Assurance">Quality Assurance</option>
                                            <option value="Engineering">Engineering</option>
                                            <option value="Analytical_Development_Laboratory">Analytical Development
                                                Laboratory</option>
                                            <option value="Process_Development_Lab">Process Development Laboratory / Kilo
                                                Lab</option>
                                            <option value="Technology transfer/Design">Technology Transfer/Design</option>
                                            <option value="Environment, Health & Safety">Environment, Health & Safety
                                            </option>
                                            <option value="Human Resource & Administration">Human Resource &
                                                Administration</option>
                                            <option value="Information Technology">Information Technology</option>
                                            <option value="Project management">Project management</option>



                                        </select>

                                    </div>
                                </div>
                                <div class="col-md-12 mb-3 other1_reviews">
                                    <div class="group-input">
                                        <label for="productionfeedback">Impact Assessment (By Other's 1)</label>
                                        <textarea class="" name="Other1_assessment" id="summernote-41">
                                                                                </textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3 other1_reviews">
                                    <div class="group-input">
                                        <label for="productionfeedback"> Other's 1 Feedback</label>
                                        <textarea class="" name="Other1_feedback" id="summernote-42">
                                                                                </textarea>
                                    </div>
                                </div>
                                <div class="col-lg-12 other1_reviews">
                                    <div class="group-input">
                                        <label for="Audit Attachments"> Other's 1 Attachments</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting
                                                documents</small></div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="Other1_attachment"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="Other1_attachment[]"
                                                    oninput="addMultipleFiles(this, 'Other1_attachment')" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3 other1_reviews">
                                    <div class="group-input">
                                        <label for="productionfeedback"> Other's 1 Review Completed By</label>
                                        <input type="text" name="Other1_by" id="Other1_by" disabled>

                                    </div>
                                </div>
                                <div class="col-lg-6 new-date-data-field other1_reviews">
                                    <div class="group-input input-date">
                                        <label for="Review Completed On1">Other's 1 Review Completed On</label>
                                        <div class="calenderauditee">
                                            <input type="text" id="Other1_on" name="Other1_on" readonly placeholder="DD-MMM-YYYY" />
                                        </div>
                                    </div>
                                </div>



                                <div class="sub-head">
                                    Other's 2 ( Additional Person Review From Departments If Required)
                                </div>
                                <script>
                                    $(document).ready(function() {
                                        $('.Other2_reviews').hide();

                                        $('[name="Other2_review"]').change(function() {
                                            if ($(this).val() === 'yes') {
                                                $('.Other2_reviews').show();
                                                $('.Other2_reviews span').show();
                                            } else {
                                                $('.Other2_reviews').hide();
                                                $('.Other2_reviews span').hide();
                                            }
                                        });
                                    });
                                </script>
                                <div class="col-lg-6 ">
                                    <div class="group-input">
                                        <label for="Customer notification"> Other's 2 Review Required ?</label>
                                        <select name="Other2_review" id="Other2_review" disabled>
                                            <option value="">-- Select --</option>
                                            <option value="yes">Yes</option>
                                            <option value="no">No</option>
                                            <option value="na">NA</option>

                                        </select>

                                    </div>
                                </div>
                                @php
                                    $division = DB::table('q_m_s_divisions')
                                        ->where('name', Helpers::getDivisionName(session()->get('division')))
                                        ->first();
                                    $userRoles = DB::table('user_roles')
                                        ->where(['q_m_s_roles_id' => 35, 'q_m_s_divisions_id' => $division->id])
                                        ->get();
                                    $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                    $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                                @endphp
                                <div class="col-lg-6 Other2_reviews">
                                    <div class="group-input">
                                        <label for="Customer notification"> Other's 2 Person</label>
                                        <select name="Other2_person" id="Other2_person">
                                            <option value="">-- Select --</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach

                                        </select>

                                    </div>
                                </div>
                                <div class="col-lg-12 Other2_reviews">
                                    <div class="group-input">
                                        <label for="Customer notification"> Other's 2 Department</label>
                                        <select name="Other2_Department_person" id="Other2_Department_person">
                                            <option value="">-- Select --</option>
                                            <option value="Production">Production</option>
                                            <option value="Warehouse">Warehouse</option>
                                            <option value="Quality_Control">Quality Control</option>
                                            <option value="Quality_Assurance">Quality Assurance</option>
                                            <option value="Engineering">Engineering</option>
                                            <option value="Analytical_Development_Laboratory">Analytical Development
                                                Laboratory</option>
                                            <option value="Process_Development_Lab">Process Development Laboratory / Kilo
                                                Lab</option>
                                            <option value="Technology transfer/Design">Technology Transfer/Design</option>
                                            <option value="Environment, Health & Safety">Environment, Health & Safety
                                            </option>
                                            <option value="Human Resource & Administration">Human Resource &
                                                Administration</option>
                                            <option value="Information Technology">Information Technology</option>
                                            <option value="Project management">Project management</option>



                                        </select>

                                    </div>
                                </div>
                                <div class="col-md-12 mb-3 Other2_reviews">
                                    <div class="group-input">
                                        <label for="Impact Assessment13">Impact Assessment (By Other's 2)</label>
                                        <textarea class="" name="Other2_Assessment" id="summernote-43">
                                                                                </textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3 Other2_reviews">
                                    <div class="group-input">
                                        <label for="Feedback2"> Other's 2 Feedback</label>
                                        <textarea class="" name="Other2_feedback" id="summernote-44">
                                                                                </textarea>
                                    </div>
                                </div>
                                <div class="col-lg-12 Other2_reviews">
                                    <div class="group-input">
                                        <label for="Audit Attachments"> Other's 2 Attachments</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting
                                                documents</small></div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="Other2_attachment"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="Other2_attachment[]"
                                                    oninput="addMultipleFiles(this, 'Other2_attachment')" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3 Other2_reviews">
                                    <div class="group-input">
                                        <label for="Review Completed By2"> Other's 2 Review Completed By</label>
                                        <input type="text" name="Other2_by" disabled>

                                    </div>
                                </div>
                                <div class="col-lg-6 new-date-data-field Other2_reviews">
                                    <div class="group-input input-date">
                                        <label for="Review Completed On2">Other's 2 Review Completed On</label>
                                        <div class="calenderauditee">
                                            <input type="text" id="Other2_on" name="Other2_on" readonly
                                                placeholder="DD-MMM-YYYY" />
                                            {{-- <input type="date"  name="Other2_on" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input"
                                                                                            oninput="handleDateInput(this, 'Other2_on')" /> --}}
                                        </div>
                                    </div>
                                </div>



                                <div class="sub-head">
                                    Other's 3 ( Additional Person Review From Departments If Required)
                                </div>
                                <script>
                                    $(document).ready(function() {
                                        $('.Other3_reviews').hide();

                                        $('[name="Other3_review"]').change(function() {
                                            if ($(this).val() === 'yes') {
                                                $('.Other3_reviews').show();
                                                $('.Other3_reviews span').show();
                                            } else {
                                                $('.Other3_reviews').hide();
                                                $('.Other3_reviews span').hide();
                                            }
                                        });
                                    });
                                </script>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Customer notification"> Other's 3 Review Required ?</label>
                                        <select name="Other3_review" id="Other3_review" disabled>
                                            <option value="">-- Select --</option>
                                            <option value="yes">Yes</option>
                                            <option value="no">No</option>
                                            <option value="na">NA</option>

                                        </select>

                                    </div>
                                </div>
                                @php
                                    $division = DB::table('q_m_s_divisions')
                                        ->where('name', Helpers::getDivisionName(session()->get('division')))
                                        ->first();
                                    $userRoles = DB::table('user_roles')
                                        ->where(['q_m_s_roles_id' => 36, 'q_m_s_divisions_id' => $division->id])
                                        ->get();
                                    $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                    $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                                @endphp
                                <div class="col-lg-6 Other3_reviews">
                                    <div class="group-input">
                                        <label for="Customer notification"> Other's 3 Person</label>
                                        <select name="Other3_person" id="Other3_person">
                                            <option value="">-- Select --</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach

                                        </select>

                                    </div>
                                </div>
                                <div class="col-lg-12 Other3_reviews ">
                                    <div class="group-input">
                                        <label for="Customer notification"> Other's 3 Department</label>
                                        <select name="Other3_Department_person" id="Other3_Department_person">
                                            <option value="">-- Select --</option>
                                            <option value="Production">Production</option>
                                            <option value="Warehouse">Warehouse</option>
                                            <option value="Quality_Control">Quality Control</option>
                                            <option value="Quality_Assurance">Quality Assurance</option>
                                            <option value="Engineering">Engineering</option>
                                            <option value="Analytical_Development_Laboratory">Analytical Development
                                                Laboratory</option>
                                            <option value="Process_Development_Lab">Process Development Laboratory / Kilo
                                                Lab</option>
                                            <option value="Technology transfer/Design">Technology Transfer/Design</option>
                                            <option value="Environment, Health & Safety">Environment, Health & Safety
                                            </option>
                                            <option value="Human Resource & Administration">Human Resource &
                                                Administration</option>
                                            <option value="Information Technology">Information Technology</option>
                                            <option value="Project management">Project management</option>



                                        </select>

                                    </div>
                                </div>
                                <div class="col-md-12 mb-3 Other3_reviews">
                                    <div class="group-input">
                                        <label for="productionfeedback">Impact Assessment (By Other's 3)</label>
                                        <textarea class="" name="Other3_Assessment" id="summernote-45">
                                                                                </textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3 Other3_reviews">
                                    <div class="group-input">
                                        <label for="productionfeedback"> Other's 3 Feedback</label>
                                        <textarea class="" name="Other3_feedback" id="summernote-46">
                                                                                </textarea>
                                    </div>
                                </div>
                                <div class="col-lg-12 Other3_reviews">
                                    <div class="group-input">
                                        <label for="Audit Attachments"> Other's 3 Attachments</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting
                                                documents</small></div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="Other3_attachment"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="Other3_attachment[]"
                                                    oninput="addMultipleFiles(this, 'Other3_attachment')" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3 Other3_reviews">
                                    <div class="group-input">
                                        <label for="productionfeedback"> Other's 3 Review Completed By</label>
                                        <input type="text" name="Other3_by" disabled>

                                    </div>
                                </div>
                                <div class="col-lg-6 new-date-data-field Other3_reviews">
                                    <div class="group-input input-date">
                                        <label for="Review Completed On3">Other's 3 Review Completed On</label>
                                        <div class="calenderauditee">
                                            <input type="text" id="Other3_on" name="Other3_on" readonly
                                                placeholder="DD-MMM-YYYY" />
                                            {{-- <input type="date"  name="Other3_on" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input"
                                                                                            oninput="handleDateInput(this, 'Other3_on')" /> --}}
                                        </div>
                                    </div>
                                </div>




                                <div class="sub-head">
                                    Other's 4 ( Additional Person Review From Departments If Required)
                                </div>
                                <script>
                                    $(document).ready(function() {
                                        $('.Other4_reviews').hide();

                                        $('[name="Other4_review"]').change(function() {
                                            if ($(this).val() === 'yes') {
                                                $('.Other4_reviews').show();
                                                $('.Other4_reviews span').show();
                                            } else {
                                                $('.Other4_reviews').hide();
                                                $('.Other4_reviews span').hide();
                                            }
                                        });
                                    });
                                </script>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="review4"> Other's 4 Review Required ?</label>
                                        <select name="Other4_review" id="Other4_review" disabled>
                                            <option value="">-- Select --</option>
                                            <option value="yes">Yes</option>
                                            <option value="no">No</option>
                                            <option value="na">NA</option>

                                        </select>

                                    </div>
                                </div>
                                @php
                                    $division = DB::table('q_m_s_divisions')
                                        ->where('name', Helpers::getDivisionName(session()->get('division')))
                                        ->first();
                                    $userRoles = DB::table('user_roles')
                                        ->where(['q_m_s_roles_id' => 37, 'q_m_s_divisions_id' => $division->id])
                                        ->get();
                                    $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                    $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                                @endphp
                                <div class="col-lg-6 Other4_reviews">
                                    <div class="group-input">
                                        <label for="Person4"> Other's 4 Person</label>
                                        <select name="Other4_person" id="Other4_person">
                                            <option value="">-- Select --</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach

                                        </select>

                                    </div>
                                </div>
                                <div class="col-lg-12 Other4_reviews">
                                    <div class="group-input">
                                        <label for="Department4"> Other's 4 Department</label>
                                        <select name="Other4_Department_person" id="Other4_Department_person">
                                            <option value="">-- Select --</option>
                                            <option value="Production">Production</option>
                                            <option value="Warehouse">Warehouse</option>
                                            <option value="Quality_Control">Quality Control</option>
                                            <option value="Quality_Assurance">Quality Assurance</option>
                                            <option value="Engineering">Engineering</option>
                                            <option value="Analytical_Development_Laboratory">Analytical Development
                                                Laboratory</option>
                                            <option value="Process_Development_Lab">Process Development Laboratory / Kilo
                                                Lab</option>
                                            <option value="Technology transfer/Design">Technology Transfer/Design</option>
                                            <option value="Environment, Health & Safety">Environment, Health & Safety
                                            </option>
                                            <option value="Human Resource & Administration">Human Resource &
                                                Administration</option>
                                            <option value="Information Technology">Information Technology</option>
                                            <option value="Project management">Project management</option>



                                        </select>

                                    </div>
                                </div>
                                <div class="col-md-12 mb-3 Other4_reviews">
                                    <div class="group-input">
                                        <label for="Impact Assessment15">Impact Assessment (By Other's 4)</label>
                                        <textarea class="" name="Other4_Assessment" id="summernote-47">
                                                                                </textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3 Other4_reviews">
                                    <div class="group-input">
                                        <label for="feedback4"> Other's 4 Feedback</label>
                                        <textarea class="" name="Other4_feedback" id="summernote-48">
                                                                                </textarea>
                                    </div>
                                </div>
                                <div class="col-lg-12 Other4_reviews">
                                    <div class="group-input">
                                        <label for="Audit Attachments"> Other's 4 Attachments</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting
                                                documents</small></div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="Other4_attachment"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="Other4_attachment[]"
                                                    oninput="addMultipleFiles(this, 'Other4_attachment')" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3 Other4_reviews">
                                    <div class="group-input">
                                        <label for="Review Completed By4"> Other's 4 Review Completed By</label>
                                        <input type="text" name="Other4_by" disabled>

                                    </div>
                                </div>
                                <div class="col-lg-6 new-date-data-field Other4_reviews">
                                    <div class="group-input input-date">
                                        <label for="Review Completed On4">Other's 4 Review Completed On</label>
                                        <div class="calenderauditee">
                                            <input type="text" id="Other4_on" name="Other4_on" readonly
                                                placeholder="DD-MMM-YYYY" />
                                            {{-- <input type="date"  name="Other4_on" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input"
                                                                                            oninput="handleDateInput(this, 'Other4_on')" /> --}}
                                        </div>
                                    </div>
                                </div>


                                <div class="sub-head">
                                    Other's 5 ( Additional Person Review From Departments If Required)
                                </div>
                                <script>
                                    $(document).ready(function() {
                                        $('.Other5_reviews').hide();

                                        $('[name="Other5_review"]').change(function() {
                                            if ($(this).val() === 'yes') {
                                                $('.Other5_reviews').show();
                                                $('.Other5_reviews span').show();
                                            } else {
                                                $('.Other5_reviews').hide();
                                                $('.Other5_reviews span').hide();
                                            }
                                        });
                                    });
                                </script>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="review5"> Other's 5 Review Required ?</label>
                                        <select name="Other5_review" id="Other5_review" disabled>
                                            <option value="">-- Select --</option>
                                            <option value="yes">Yes</option>
                                            <option value="no">No</option>
                                            <option value="na">NA</option>

                                        </select>

                                    </div>
                                </div>
                                @php
                                    $division = DB::table('q_m_s_divisions')
                                        ->where('name', Helpers::getDivisionName(session()->get('division')))
                                        ->first();
                                    $userRoles = DB::table('user_roles')
                                        ->where(['q_m_s_roles_id' => 38, 'q_m_s_divisions_id' => $division->id])
                                        ->get();
                                    $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                    $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                                @endphp
                                <div class="col-lg-6 Other5_reviews">
                                    <div class="group-input">
                                        <label for="Person5">Other's 5 Person</label>
                                        <select name="Other5_person" id="Other5_person">
                                            <option value="">-- Select --</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach

                                        </select>

                                    </div>
                                </div>
                                <div class="col-lg-12 Other5_reviews">
                                    <div class="group-input">
                                        <label for="Department5"> Other's 5 Department</label>
                                        <select name="Other5_Department_person" id="Other5_Department_person">
                                            <option value="">-- Select --</option>
                                            <option value="Production">Production</option>
                                            <option value="Warehouse">Warehouse</option>
                                            <option value="Quality_Control">Quality Control</option>
                                            <option value="Quality_Assurance">Quality Assurance</option>
                                            <option value="Engineering">Engineering</option>
                                            <option value="Analytical_Development_Laboratory">Analytical Development
                                                Laboratory</option>
                                            <option value="Process_Development_Lab">Process Development Laboratory / Kilo
                                                Lab</option>
                                            <option value="Technology transfer/Design">Technology Transfer/Design</option>
                                            <option value="Environment, Health & Safety">Environment, Health & Safety
                                            </option>
                                            <option value="Human Resource & Administration">Human Resource &
                                                Administration</option>
                                            <option value="Information Technology">Information Technology</option>
                                            <option value="Project management">Project management</option>



                                        </select>

                                    </div>
                                </div>
                                <div class="col-md-12 mb-3 Other5_reviews">
                                    <div class="group-input">
                                        <label for="productionfeedback">Impact Assessment (By Other's 5)</label>
                                        <textarea class="" name="Other5_Assessment" id="summernote-49">
                                                                                </textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3 Other5_reviews">
                                    <div class="group-input">
                                        <label for="productionfeedback"> Other's 5 Feedback</label>
                                        <textarea class="" name="Other5_feedback" id="summernote-50">
                                                                                </textarea>
                                    </div>
                                </div>
                                <div class="col-lg-12 Other5_reviews">
                                    <div class="group-input">
                                        <label for="Audit Attachments"> Other's 5 Attachments</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting
                                                documents</small></div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="Other5_attachment"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="Other5_attachment[]"
                                                    oninput="addMultipleFiles(this, 'Other5_attachment')" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3 Other5_reviews">
                                    <div class="group-input">
                                        <label for="Review Completed By5"> Other's 5 Review Completed By</label>
                                        <input type="text" name="Other5_by" disabled>

                                    </div>
                                </div>
                                <div class="col-lg-6 new-date-data-field Other5_reviews">
                                    <div class="group-input input-date">
                                        <label for="Review Completed On5">Other's 5 Review Completed On</label>
                                        <div class="calenderauditee">
                                            <input type="text" id="Other5_on" name="Other5_on" readonly
                                                placeholder="DD-MMM-YYYY" />
                                            {{-- <input type="date"  name="Other5_on" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input"
                                                                                            oninput="handleDateInput(this, 'Other5_on')" /> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="button-block">
                                <button type="submit" id="ChangesaveButton"
                                    style=" justify-content: center; width: 4rem; margin-left: 1px;" class="saveButton">Save</button>
                                <a href="/rcms/qms-dashboard" style=" justify-content: center; width: 4rem; margin-left: 1px;">
                                    <button type="button" class="backButton">Back</button>
                                </a>
                                <button type="button" style=" justify-content: center; width: 4rem; margin-left: 1px;"
                                    id="ChangeNextButton" class="nextButton" onclick="nextStep()">Next</button>
                                <button type="button" style=" justify-content: center; width: 4rem; margin-left: 1px;">
                                    <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                                        Exit </a> </button>
                            </div>

                        </div>
                    </div>


                    <div id="CCForm6" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                <div class="sub-head">
                                    Outcome
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Short Description">Resolution Status</label>
                                        <div class="relative-container">
                                            <select id="resolution_status" name="resolution_status">
                                                <option value="">Select Resolution Status</option>
                                                <option value="Answered">Answered</option>
                                                <option value="Referred">Referred</option>
                                                <option value="Not Applicable">Not Applicable</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>                            

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Short Description">Category Tags</label>
                                        <div class="relative-container">
                                            <select id="category_tags" name="category_tags[]">
                                                <option value="">Select Category Tags</option>
                                                <option value="Tag 1">Tag 1</option>
                                                <option value="Tag 2">Tag 2</option>
                                                <option value="Tag 3">Tag 3</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="group-input">
                                    <label for="qa-eval-comments">Response Details</label>
                                    <div class="relative-container">
                                        <textarea name="response_details"></textarea>
                                        @component('frontend.forms.language-model')
                                        @endcomponent
                                    </div>
                                </div>

                                <div class="group-input">
                                    <label for="qa-eval-comments">Follow-up Actions</label>
                                    <div class="relative-container">
                                        <textarea name="followup_action"></textarea>
                                        @component('frontend.forms.language-model')
                                        @endcomponent
                                    </div>
                                </div>

                                <div class="col-lg-12 Other5_reviews">
                                    <div class="group-input">
                                        <label for="Audit Attachments">Supporting Documents</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting
                                                documents</small></div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="supporting_doc"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="supporting_doc[]"
                                                    oninput="addMultipleFiles(this, 'supporting_doc')" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="button-block">
                                <button type="submit" class="saveButton">Save</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                <button type="button"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}"> Exit </a> </button>
                            </div>
                        </div>
                    </div>

                    <div id="CCForm7" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="sub-head">
                                Electronic Signatures
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="submitted">Submit By</label>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="submitted">Submit On</label>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="submitted">HOD Review Complete By</label>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="submitted">HOD Review Complete On</label>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="submitted">Send to CFT/SME/QA Review By</label>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="submitted">Send to CFT/SME/QA Review On</label>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="submitted">CFT/SME/QA Review Not required By</label>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="submitted">CFT/SME/QA Review Not required On</label>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="submitted">Review Completed By</label>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="submitted">Review Completed On</label>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="submitted">Implemented By</label>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="submitted">Implemented On</label>
                                    </div>
                                </div>
                            </div>
                            <div class="button-block">
                                <button type="submit" value="save" name="submit" class="saveButton">Save</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                <button type="button"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}">
                                        Exit
                                    </a> </button>
                                <button type="submit">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>


            </form>
        </div>
    </div>

    <div class="modal fade" id="change-control-type-of-change-instruction-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title">Instructions</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <h4>1. Major Change:</h4>
                    <ul>
                        <li>A major change is usually a significant alteration that may have a substantial impact on the
                            product.</li>

                        <li>It might involve modifications to the manufacturing process, formulation, equipment, or other
                            critical aspects of production.</li>

                        <li>Major changes often require thorough assessment, validation, and regulatory approval before
                            implementation.</li>
                    </ul>


                    <h4>2. Minor Change:</h4>
                    <ul>

                        <li>A minor change is typically a less significant alteration, one that is unlikely to have a
                            substantial impact on product quality, safety, or efficacy.</li>

                        <li>Minor changes may include adjustments to documentation, labeling, or other non-critical aspects
                            that don't significantly affect the product's characteristics.</li>

                        <li>These changes may still require some level of evaluation and documentation but may not
                            necessitate the same level of scrutiny as major changes.</li>
                    </ul>


                    <h4>3. Critical Change:</h4>
                    <ul>

                        <li>A critical change is one that has the potential to significantly impact product quality, safety,
                            or efficacy and may require immediate attention.</li>

                        <li>These changes are often associated with unexpected events or deviations that need prompt
                            resolution to maintain product integrity.</li>

                        <li>Critical changes may require urgent assessment, corrective actions, and regulatory reporting.
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {

            $('#submitPrompt').click(async function() {
                let docDescription = $('input[name=short_description]').val().trim();
                if (docDescription === '') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Empty Input',
                        text: 'Please enter a document short description.',
                    });
                    return;
                }

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
                        'https://api.openai.com/v1/chat/completions', {
                            "model": "gpt-3.5-turbo",
                            "messages": [{
                                "role": "user",
                                "content": `Generate a structured JSON response (string key: string value) with fields Impact On Operations, Impact On Product Quality, Regulatory Impact, Risk Level, Validation Requirement based on the Change Control description: "${docDescription}". Make content as lengthy as possible.`
                            }]
                        }, {
                            headers: {
                                'Authorization': `Bearer ${open_ai_key}`,
                                'Content-Type': 'application/json'
                            }
                        }
                    );

                    Swal.close();

                    let content = response.data.choices[0].message.content;
                    let jsonResponse = JSON.parse(content);
                    console.log('data', jsonResponse)
                    populateFields(jsonResponse);
                    $('#customModal').modal('hide');

                } catch (error) {
                    console.log('error in ai generating response', error.message)
                }
            });

            function populateFields(data) {
                for (let section in data) {
                    let sectionData = data[section];

                    switch (section.toLowerCase()) {
                        case "impact on operations":
                            $("textarea[name='impact_operations']").val(sectionData);
                            break;

                        case "impact on product quality":
                            $("textarea[name='impact_product_quality']").val(sectionData);
                            break;

                        case "regulatory impact":
                            $("textarea[name='regulatory_impact']").val(sectionData);
                            break;

                        case "risk level":
                            $("textarea[name='risk_level']").val(sectionData);
                            break;

                        case "validation requirement":
                            $("textarea[name='validation_requirment']").val(sectionData);
                            break;

                        default:
                            console.warn(`No matching field found for section: ${section}`);
                    }
                }
            }

        });
    </script>

    <style>
        #step-form>div {
            display: none;
        }

        #step-form>div:nth-child(1) {
            display: block;
        }

        #productTable,
        #materialTable {
            display: none;
        }
    </style>

    <script>
        const productSelect = document.getElementById('productSelect');
        const productTable = document.getElementById('productTable');
        const materialSelect = document.getElementById('materialSelect');
        const materialTable = document.getElementById('materialTable');

        materialSelect.addEventListener('change', function() {
            if (materialSelect.value === 'yes') {
                materialTable.style.display = 'block';
            } else {
                materialTable.style.display = 'none';
            }
        });

        productSelect.addEventListener('change', function() {
            if (productSelect.value === 'yes') {
                productTable.style.display = 'block';
            } else {
                productTable.style.display = 'none';
            }
        });
    </script>

    <script>
        VirtualSelect.init({
            ele: '#related_records, #category_tags, #refrenece_document'
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
    {{-- var riskData = @json($riskData); --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() { //DISABLED PAST DATES IN APPOINTMENT DATE
            var dateToday = new Date();
            var month = dateToday.getMonth() + 1;
            var day = dateToday.getDate();
            var year = dateToday.getFullYear();

            if (month < 10)
                month = '0' + month.toString();
            if (day < 10)
                day = '0' + day.toString();

            var maxDate = year + '-' + month + '-' + day;

            $('#dueDate').attr('min', maxDate);
        });
    </script>

    <script>
        $(document).ready(function() {
            var aiText = $('.ai_text');


            console.log(riskData);
            $('#short_description').on('input', function() {
                var description = $(this).val().toLowerCase();
                var riskLevelSelectize = $('#risk_level')[0].selectize;
                // var aiText = $('#ai_text');

                var foundRiskLevel = false;
                for (var i = 0; i < riskData.length; i++) {
                    if (description.includes(riskData[i].keyword.toLowerCase())) {
                        riskLevelSelectize.setValue(riskData[i].risk_level, true);
                        aiText.show();
                        foundRiskLevel = true;
                        console.log(riskData[i].keyword);
                        break;
                    }
                }
                if (!foundRiskLevel) {
                    riskLevelSelectize.setValue('0', true);
                    aiText.hide();
                }
            });

            $('#risk_level').on('change', function() {
                if ($(this).val() !== '0') {
                    aiText.hide();
                }
            });
        });
    </script>
    <script>
        // JavaScript
        document.getElementById('initiator_group').addEventListener('change', function() {
            var selectedValue = this.value;
            document.getElementById('initiator_group_code').value = selectedValue;
        });
    </script>

    <style>
        .swal2-container.swal2-center.swal2-backdrop-show .swal2-icon.swal2-error.swal2-icon-show,
        .swal2-container.swal2-center.swal2-backdrop-show .selectize-control.swal2-select.single {
            display: none !important;
        }

        .swal2-container.swal2-center.swal2-backdrop-show #swal2-title {
            text-align: center;
            font-size: 1.5rem !important;
        }

        .swal2-container.swal2-center.swal2-backdrop-show .swal2-html-container.my-html-class {
            text-transform: capitalize !important;
        }
    </style>
    <script>
        var maxLength = 255;
        $('#docname').keyup(function() {
            var textlen = maxLength - $(this).val().length;
            $('#rchars').text(textlen);
        });
    </script>
    <script>
        $(document).ready(function() {
            // Event listener for the remove file button
            $(document).on('click', '.remove-file', function() {
                $(this).closest('.file-container').remove();
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const removeButtons = document.querySelectorAll('.remove-file');

            removeButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const fileName = this.getAttribute('data-file-name');
                    const fileContainer = this.parentElement;

                    // Hide the file container
                    if (fileContainer) {
                        fileContainer.style.display = 'none';
                    }
                });
            });
        });

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
@endsection
