@extends('frontend.rcms.layout.main_rcms')
@section('rcms_container')
    @php
        $users = DB::table('users')->select('id', 'name')->get();

    @endphp

    <style>
        #step-form>div {
            display: none
        }

        #step-form>div:nth-child(1) {
            display: block;
        }

        .hide-input {
            display: none !important;
        }

        .remove-file {
            cursor: pointer;
        }
    </style>
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

        .form-control {
            margin-bottom: 20px;
        }

        div[class^="VIp"] {
            display: none;
        }

        #change-control-view>div.container-fluid>div.inner-block.state-block>div.status>div>div {
            font-size: 12px;
        }

        /* #change-control-view > div.container-fluid > div.inner-block.state-block > div.status > div > div.active{
                            font-size: 12px;

                        } */
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"
        integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    @if (Session::has('swal'))
        <script>
            swal("{{ Session::get('swal')['title'] }}", "{{ Session::get('swal')['message'] }}",
                "{{ Session::get('swal')['type'] }}")
        </script>
    @endif
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


                <div class="slogan">
                    @php
                        $name = DB::table('q_m_s_divisions')
                            ->where('id', $data->id)
                            ->value('name');
                    @endphp
                    <strong>Site Division / Project </strong>:
                    {{ Helpers::getDivisionName($Sanction->division_id) }} / Sanction
                </div>
            </div>
        </div>
    </div>

    <!-- /* Change Control View Data Fields */ -->

    <div id="change-control-view">
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
                                includedLanguages: 'af,am,ar,az,be,bg,bn,bs,ca,ceb,co,cs,cy,da,de,el,en,eo,es,et,eu,fa,fi,fr,fy,ga,gd,gl,gu,ha,haw,he,hi,hmn,hr,ht,hu,hy,id,ig,is,it,ja,jw,ka,kk,km,kn,ko,ku,ky,la,lb,lo,lt,lv,mg,mi,mk,ml,mn,mr,ms,mt,my,ne,nl,no,ny,pa,pl,ps,pt,ro,ru,sd,si,sk,sl,sm,sn,so,sq,sr,st,su,sv,sw,ta,te,tg,th,tl,tr,uk,ur,uz,vi,xh,yi,yo,zh-CN,zh-TW,zu',
                                layout: google.translate.TranslateElement.InlineLayout.SIMPLE
                            }, 'google_translate_element');
                        }
                    </script>
                    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit">
                    </script>

                    <div class="d-flex" style="gap:20px;">

                        <?php
                        $userRoles = DB::table('user_roles')
                            ->where(['user_id' => Auth::user()->id, 'q_m_s_divisions_id' => $data->division_id])
                            ->get();
                        $userRoleIds = $userRoles->pluck('q_m_s_roles_id')->toArray();
                        ?>

                        <button class="button_theme1"> <a class="text-white"
                                href="{{ url('SanctionAuditTrail', $data->id) }}"> Audit Trail </a> </button>

                        @if ($Sanction->stage == 1 && (in_array(13, $userRoleIds) || in_array(18, $userRoleIds)))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-modal">
                                Cancel
                            </button>
                        @else
                        @endif
                        <button class="button_theme1"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}"> Exit
                            </a> </button>
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

                </div>
                <div class="status">

                    @if ($data->stage == 0)
                        <div class="progress-bars">
                            <div class="bg-danger">Closed-Cancelled</div>
                        </div>
                    @else
                        <div class="progress-bars" style="margin-bottom: 16px;">
                            @if ($data->stage >= 1)
                                <div class="active">Opened</div>
                            @else
                                <div class="">Opened</div>
                            @endif
                            @if ($data->stage >= 2)
                                <div class="active bg-danger">Closed</div>
                            @else
                                <div class="">Closed</div>
                            @endif

                        </div>
                    @endif
                </div>
                <div class="top-block">
                    <div><strong> Record Name :&nbsp;</strong>Sanction</div>
                    <div><strong> Site :&nbsp;</strong>{{ Helpers::getDivisionName($data->division_id) }}</div>
                    <div><strong> Current Status :&nbsp;</strong>{{ $data->status }}</div>
                    <div><strong> Initiated By :&nbsp;</strong>{{ Helpers::getInitiatorName($data->initiator_id) }}</div>
                </div>
            </div>
            <div class="modal right fade" id="myModal3" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-titles ml-10">Sanction Workflow</h4>
                        </div>
                        <div style="" class="modal-body main-new-workflow">
                            <Div class="button-box">
                                @if ($data->stage == 0)
                                    <div class="">
                                        <div class="mini_buttons  bg-danger">Closed-Cancelled</div>
                                    @else
                                        @if ($data->stage >= 1)
                                            <div class="active">
                                                Opened
                                            </div>
                                        @else
                                            <div class="mini_buttons">Opened</div>
                                        @endif
                                        <div class="down-logo">
                                            <img class="dawn_arrow" src="{{ asset('user/images/down.gif') }}" alt="..."
                                                class="w-100 h-100">
                                        </div>
                                        @if ($data->stage >= 2)
                                            <div class="active bg-danger">
                                                Closed
                                            </div>
                                        @else
                                            <div class="mini_buttons">
                                                Closed
                                            </div>
                                        @endif
                                @endif
                            </Div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="control-list">
            @php
                $users = DB::table('users')->get();
            @endphp
            <div id="change-control-fields">
                <div class="container-fluid">
                    <!-- Tab links -->
                    <div class="cctab">
                        <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">General
                            Information</button>
                        <button class="cctablinks" onclick="openCity(event, 'CCForm2')">Activity Log</button>
                    </div>

                    <form id="CCFormInput" action="{{ route('updateSanction', $data->id) }}" method="POST"
                        enctype="multipart/form-data">
                        <input type="hidden" name="stage" id="stage" value="{{ $data->stage }}">

                        @csrf
                        {{-- @method('PUT') --}}

                        <!-- Tab content -->
                        <div id="step-form">

                            <div id="CCForm1" class="inner-block cctabcontent">
                                <div class="inner-block-content">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="RLS Record Number"><b>Record Number</b></label>
                                                <input readonly type="text" name="record_number"
                                                    value="{{ $Sanction->record_number }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Division Code"><b>Site/Location Code</b></label>
                                                <input readonly type="text" name="division_code"
                                                    value="{{ Helpers::getDivisionName($Sanction->division_id) }}">
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Initiator"><b>Initiator</b></label>
                                                <input type="hidden" name="initiator_id">
                                                <input readonly type="text" value="{{ $Sanction->initiator_name }} ">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input ">
                                                <label for="Date Due"><b>Date of Initiation</b></label>
                                                <input disabled type="text" value="{{ date('d-M-Y') }}"
                                                    name="intiation_date">
                                                <input type="hidden" value="{{ date('Y-m-d') }}" name="intiation_date">
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Assigned to">Assigned to</label>
                                                <select name="assign_to"
                                                    {{ $Sanction->stage == 0 || $Sanction->stage == 2 ? 'disabled' : '' }}>
                                                    <option value="">-- Select --</option>
                                                    @foreach ($users as $key => $value)
                                                        <option value="{{ $value->id }}"
                                                            @if ($data->assign_to == $value->id) selected @endif>
                                                            {{ $value->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="group-input">
                                                <label for="due-date">Due Date <span class="text-danger"></span></label>
                                                <div><small class="text-primary">If revising Due Date, kindly mention
                                                        revision reason in "Due Date Extension Justification" data
                                                        field.</small></div>
                                                <input readonly type="text"
                                                    value="{{ Helpers::getdateFormat($Sanction->due_date) }}"
                                                    name="due_date"{{ $Sanction->stage == 0 || $Sanction->stage == 2 ? 'disabled' : '' }}>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Short Description">Short Description<span
                                                        class="text-danger">*</span></label><span id="rchars"
                                                    class="text-primary">255 </span><span class="text-primary"> characters
                                                    remaining</span>
                                                <div class="relative-container">
                                                    <input name="short_description" id="docname" type="text"
                                                        value="{{ $Sanction->short_description }}" maxlength="255"
                                                        required
                                                        {{ $Sanction->stage == 0 || $Sanction->stage == 2 ? 'disabled' : '' }}>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Type">Type</label>
                                                <div><small class="text-primary">Type of sanction</small></div>
                                                <select name="Type" id="Type"
                                                    {{ $Sanction->stage == 0 || $Sanction->stage == 2 ? 'disabled' : '' }}>
                                                    <option value="">-- Select --</option>
                                                    <option value="Conditional Fining Report"
                                                        {{ $Sanction->Type == 'Conditional Fining Report' ? 'selected' : '' }}>
                                                        Conditional Fining Report</option>
                                                    <option value="Fine"
                                                        {{ $Sanction->Type == 'Fine' ? 'selected' : '' }}>Fine</option>
                                                    <option value="Formal Warning"
                                                        {{ $Sanction->Type == 'Formal Warning' ? 'selected' : '' }}>Formal
                                                        Warning</option>
                                                    <option value="Official Report"
                                                        {{ $Sanction->Type == 'Official Report' ? 'selected' : '' }}>
                                                        Official Report</option>
                                                    <option value="Warning"
                                                        {{ $Sanction->Type == 'Warning' ? 'selected' : '' }}>Warning
                                                    </option>
                                                    <option value="Other"
                                                        {{ $Sanction->Type == 'Other' ? 'selected' : '' }}>Other</option>
                                                    <option value="N/A"
                                                        {{ $Sanction->Type == 'N/A' ? 'selected' : '' }}>N/A</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Attached File">Attached File</label>
                                                <div><small class="text-primary">Please Attach all relevant or supporting
                                                        documents</small></div>

                                                <div class="file-attachment-field">
                                                    <div class="file-attachment-list" id="Attached_File">
                                                        @if ($Sanction->Attached_File)
                                                            @foreach (json_decode($Sanction->Attached_File) as $file)
                                                                <h6 type="button" class="file-container text-dark"
                                                                    style="background-color: rgb(243, 242, 240);">
                                                                    <b>{{ $file }}</b>
                                                                    <a href="{{ asset('upload/' . $file) }}"
                                                                        target="_blank"><i class="fa fa-eye text-primary"
                                                                            style="font-size:20px; margin-right:-10px;"></i></a>
                                                                    <a type="button" class="remove-file"
                                                                        data-file-name="{{ $file }}"><i
                                                                            class="fa-solid fa-circle-xmark"
                                                                            style="color:red; font-size:20px;"></i></a>
                                                                </h6>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                    <div class="add-btn">
                                                        <div>Add</div>
                                                        <input
                                                            {{ $Sanction->stage == 0 || $Sanction->stage == 2 ? 'disabled' : '' }}
                                                            type="file" id="myfile" name="Attached_File[]"
                                                            oninput="addMultipleFiles(this, 'Attached_File')" multiple>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Description">Description</label>
                                                <textarea name="Description" id="Description" {{ $Sanction->stage == 0 || $Sanction->stage == 2 ? 'disabled' : '' }}>{{ $Sanction->Description }}</textarea>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Authority Type">Authority Type</label>
                                                <select name="Authority_Type" id="Authority_Type"
                                                    {{ $Sanction->stage == 0 || $Sanction->stage == 2 ? 'disabled' : '' }}>
                                                    <option value="">-- Select --</option>
                                                    <option value="Life Science"
                                                        {{ $Sanction->Authority_Type == 'Life Science' ? 'selected' : '' }}>
                                                        Life Science</option>
                                                    <option value="Food Safety"
                                                        {{ $Sanction->Authority_Type == 'Food Safety' ? 'selected' : '' }}>
                                                        Food Safety</option>
                                                    <option value="Health and Safety"
                                                        {{ $Sanction->Authority_Type == 'Health and Safety' ? 'selected' : '' }}>
                                                        Health and Safety</option>
                                                    <option value="Financial"
                                                        {{ $Sanction->Authority_Type == 'Financial' ? 'selected' : '' }}>
                                                        Financial</option>
                                                    <option value="Other"
                                                        {{ $Sanction->Authority_Type == 'Other' ? 'selected' : '' }}>Other
                                                    </option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Authority">Authority</label>
                                                <select name="Authority" id="Authority"
                                                    {{ $Sanction->stage == 0 || $Sanction->stage == 2 ? 'disabled' : '' }}>
                                                    <option value="">-- Select --</option>
                                                    <option value="NIOSH"
                                                        {{ $Sanction->Authority == 'NIOSH' ? 'selected' : '' }}>NIOSH
                                                    </option>
                                                    <option value="Congressional Office of Compliance"
                                                        {{ $Sanction->Authority == 'Congressional Office of Compliance' ? 'selected' : '' }}>
                                                        Congressional Office of Compliance</option>
                                                    <option value="OSHA"
                                                        {{ $Sanction->Authority == 'OSHA' ? 'selected' : '' }}>OSHA
                                                    </option>
                                                    <option value="EU-OSHA"
                                                        {{ $Sanction->Authority == 'EU-OSHA' ? 'selected' : '' }}>EU-OSHA
                                                    </option>
                                                    <option value="Health And Safety Executive"
                                                        {{ $Sanction->Authority == 'Health And Safety Executive' ? 'selected' : '' }}>
                                                        Health And Safety Executive</option>
                                                    <option value="International Labour Organisation"
                                                        {{ $Sanction->Authority == 'International Labour Organisation' ? 'selected' : '' }}>
                                                        International Labour Organisation</option>
                                                    <option value="Canadian Centre for Occupational Health and Safety"
                                                        {{ $Sanction->Authority == 'Canadian Centre for Occupational Health and Safety' ? 'selected' : '' }}>
                                                        Canadian Centre for Occupational Health and Safety</option>
                                                    <option value="ASCC"
                                                        {{ $Sanction->Authority == 'ASCC' ? 'selected' : '' }}>ASCC
                                                    </option>
                                                    <option value="KOSHA"
                                                        {{ $Sanction->Authority == 'KOSHA' ? 'selected' : '' }}>KOSHA
                                                    </option>
                                                    <option value="National Institute of Occupational Health"
                                                        {{ $Sanction->Authority == 'National Institute of Occupational Health' ? 'selected' : '' }}>
                                                        National Institute of Occupational Health</option>
                                                    <option value="Other"
                                                        {{ $Sanction->Authority == 'Other' ? 'selected' : '' }}>Other
                                                    </option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Fine">Fine</label>
                                                <input type="Number" name="Fine" id="Fine" min="0"
                                                    value="{{ $Sanction->Fine }}"
                                                    {{ $Sanction->stage == 0 || $Sanction->stage == 2 ? 'disabled' : '' }}>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Currency">Currency</label>
                                                <select name="Currency" id="Currency" data-search="false"
                                                    data-silent-initial-value-set="true"
                                                    {{ $Sanction->stage == 0 || $Sanction->stage == 2 ? 'disabled' : '' }}>
                                                    <option value="">-- Select --</option>
                                                    <option value="USD"
                                                        {{ $Sanction->Currency == 'USD' ? 'selected' : '' }}>United States
                                                        Dollar (USD)</option>
                                                    <option value="EUR"
                                                        {{ $Sanction->Currency == 'EUR' ? 'selected' : '' }}>Euro (EUR)
                                                    </option>
                                                    <option value="JPY"
                                                        {{ $Sanction->Currency == 'JPY' ? 'selected' : '' }}>Japanese Yen
                                                        (JPY)</option>
                                                    <option value="GBP"
                                                        {{ $Sanction->Currency == 'GBP' ? 'selected' : '' }}>British Pound
                                                        Sterling (GBP)</option>
                                                    <option value="AUD"
                                                        {{ $Sanction->Currency == 'AUD' ? 'selected' : '' }}>Australian
                                                        Dollar (AUD)</option>
                                                    <option value="CAD"
                                                        {{ $Sanction->Currency == 'CAD' ? 'selected' : '' }}>Canadian
                                                        Dollar (CAD)</option>
                                                    <option value="CHF"
                                                        {{ $Sanction->Currency == 'CHF' ? 'selected' : '' }}>Swiss Franc
                                                        (CHF)</option>
                                                    <option value="CNY"
                                                        {{ $Sanction->Currency == 'CNY' ? 'selected' : '' }}>Chinese Yuan
                                                        (CNY)</option>
                                                    <option value="INR"
                                                        {{ $Sanction->Currency == 'INR' ? 'selected' : '' }}>Indian Rupee
                                                        (INR)</option>
                                                    <option value="RUB"
                                                        {{ $Sanction->Currency == 'RUB' ? 'selected' : '' }}>Russian Ruble
                                                        (RUB)</option>
                                                    <option value="BRL"
                                                        {{ $Sanction->Currency == 'BRL' ? 'selected' : '' }}>Brazilian Real
                                                        (BRL)</option>
                                                    <option value="ZAR"
                                                        {{ $Sanction->Currency == 'ZAR' ? 'selected' : '' }}>South African
                                                        Rand (ZAR)</option>
                                                    <option value="MXN"
                                                        {{ $Sanction->Currency == 'MXN' ? 'selected' : '' }}>Mexican Peso
                                                        (MXN)</option>
                                                    <option value="SGD"
                                                        {{ $Sanction->Currency == 'SGD' ? 'selected' : '' }}>Singapore
                                                        Dollar (SGD)</option>
                                                    <option value="HKD"
                                                        {{ $Sanction->Currency == 'HKD' ? 'selected' : '' }}>Hong Kong
                                                        Dollar (HKD)</option>
                                                    <option value="NZD"
                                                        {{ $Sanction->Currency == 'NZD' ? 'selected' : '' }}>New Zealand
                                                        Dollar (NZD)</option>
                                                    <option value="KRW"
                                                        {{ $Sanction->Currency == 'KRW' ? 'selected' : '' }}>South Korean
                                                        Won (KRW)</option>
                                                    <option value="SEK"
                                                        {{ $Sanction->Currency == 'SEK' ? 'selected' : '' }}>Swedish Krona
                                                        (SEK)</option>
                                                    <option value="NOK"
                                                        {{ $Sanction->Currency == 'NOK' ? 'selected' : '' }}>Norwegian
                                                        Krone (NOK)</option>
                                                    <option value="DKK"
                                                        {{ $Sanction->Currency == 'DKK' ? 'selected' : '' }}>Danish Krone
                                                        (DKK)</option>
                                                    <option value="MYR"
                                                        {{ $Sanction->Currency == 'MYR' ? 'selected' : '' }}>Malaysian
                                                        Ringgit (MYR)</option>
                                                    <option value="THB"
                                                        {{ $Sanction->Currency == 'THB' ? 'selected' : '' }}>Thai Baht
                                                        (THB)</option>
                                                    <option value="IDR"
                                                        {{ $Sanction->Currency == 'IDR' ? 'selected' : '' }}>Indonesian
                                                        Rupiah (IDR)</option>
                                                    <option value="PHP"
                                                        {{ $Sanction->Currency == 'PHP' ? 'selected' : '' }}>Philippine
                                                        Peso (PHP)</option>
                                                    <option value="AED"
                                                        {{ $Sanction->Currency == 'AED' ? 'selected' : '' }}>United Arab
                                                        Emirates Dirham (AED)</option>
                                                    <option value="SAR"
                                                        {{ $Sanction->Currency == 'SAR' ? 'selected' : '' }}>Saudi Riyal
                                                        (SAR)</option>
                                                    <option value="TRY"
                                                        {{ $Sanction->Currency == 'TRY' ? 'selected' : '' }}>Turkish Lira
                                                        (TRY)</option>
                                                    <option value="EGP"
                                                        {{ $Sanction->Currency == 'EGP' ? 'selected' : '' }}>Egyptian Pound
                                                        (EGP)</option>
                                                </select>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="button-block">
                                        <button type="submit" class="saveButton">Save</button>
                                        <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                        {{-- <button type="button"> <a class="text-white"
                                                href="{{ url('rcms/qms-dashboard') }}">Exit</a> </button> --}}
                                    </div>
                                </div>
                            </div>

                            <div id="CCForm2" class="inner-block cctabcontent">
                                <div class="inner-block-content">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Cancel By">Cancel By</label>
                                                <div class="static">{{ $Sanction->Cancel_By }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Cancel On">Cancel On</label>
                                                <div class="static">{{ $Sanction->Cancel_On }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Cancel Comment">Cancel Comment</label>
                                                <div class="static">{{ $Sanction->Cancel_Comment }}</div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="button-block">
                                        <button type="submit" class="saveButton">Save</button>
                                        <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                        {{-- <button type="submit">Submit</button> --}}
                                        {{-- <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}"
                                                class="text-white">
                                                Exit </a> </button> --}}
                                    </div>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>

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

                <form action="{{ url('SanctionCancel', $Sanction->id) }}" method="POST">
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
                            <input type="comment" name="comments">
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="submit" data-bs-dismiss="modal">Submit</button>
                        <button type="button" data-bs-dismiss="modal">Close</button>

                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <style>
        #productTable,
        #materialTable {
            display: none;
        }
    </style>

    <script>
        wow = new WOW({
            boxClass: 'wow', // default
            animateClass: 'animated', // default
            offset: 0, // default
            mobile: true, // default
            live: true // default
        })
        wow.init();
    </script>


    <script>
        VirtualSelect.init({
            ele: '#related_records, #reviewer_person_value, #risk_assessment_related_record, #concerned_department_review'
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
        $(document).ready(function() {
            $('#add-input').click(function() {
                var lastInput = $('.bar input:last');
                var newInput = $('<input type="text" name="review_comment">');
                lastInput.after(newInput);
            });
        });
    </script>

    <!-- Example Blade View -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>

    @if (session()->has('errorMessages'))
        <script>
            // Create an array to hold all the error messages
            var errorMessages = @json(session()->get('errorMessages'));

            if (!Array.isArray(errorMessages)) {
                errorMessages = [errorMessages];
            }

            errorMessages = errorMessages.map(function(message) {
                return '<div class="seperator">==================================================</div>' +
                    '<div class="slogan"><div>This form was not submitted because of the following errors.</div><div>Please correct the errors and re-submit.</div></div>' +
                    '<div class="data">This Activity cannot be performed, as there are some blank required fields.</div>' +
                    '<div class="message">' + message + '</div>';
            });

            Swal.fire({
                icon: '',
                title: 'Connexo DMS Says',
                html: errorMessages.join(''),

                showCloseButton: true, // Display a close button
                customClass: {
                    title: 'my-title-class', // Add a custom CSS class to the title
                    htmlContainer: 'my-html-class text-danger', // Add a custom CSS class to the popup content
                },
                confirmButtonColor: '#3085d6', // Customize the confirm button color
            });
        </script>
        @php session()->forget('errorMessages'); @endphp
    @endif






    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
    </script>

    <script>
        $(document).on('click', '.removeRowBtn', function() {
            $(this).closest('tr').remove();
        })
    </script>
    <script>
        // JavaScript
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

    <script>
        $(document).ready(function() {
            $('.remove-file').click(function() {
                const removeId = $(this).data('remove-id')
                console.log('removeId', removeId);
                $('#' + removeId).remove();
            })
        })
    </script>

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

@endsection
