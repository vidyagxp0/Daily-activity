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

        /* .hide-input {
                    display: none !important;
                } */

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

    <style>
        #change-control-fields .inner-block .group-input table input, #change-control-fields .inner-block .group-input table select{
            border: 1px solid black;
            padding: 4px
        }
    </style>

    <style>
        @media print {

            /* Hide everything during printing */
            body * {
                visibility: hidden;
            }

            /* Make only the printable content visible */
            .printable-content,
            .printable-content * {
                visibility: visible;
            }

            /* Position the printable content at the top-left */
            .printable-content {
                position: absolute;
                top: 0;
                left: 0;
            }

            /* Hide the print button during printing */
            .button_theme1 {
                display: none;
            }
        }
    </style>

<style>
    .hide-input {
        display: none;
    }
    .input-date {
        margin-bottom: 20px;
    }
    label {
        display: block;
        margin-bottom: 5px;
    }
    input[readonly] {
        padding: 8px;
        font-size: 16px;
        width: 100%;
        border: 1px solid #ccc;
        background-color: #f9f9f9;
    }
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
                    {{ Helpers::getDivisionName($controlSampleData->division_id) }} / Control Sample
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
                                href="{{ route('AuditTrialSampleControlShow', $data->id) }}"> Audit Trail </a> </button>

                        @if ($data->stage == 1 && Helpers::check_roles($data->division_id, 'Control Sample', 3))
                            {{-- <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-modal">
                                Cancel
                            </button> --}}
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Submit
                            </button>
                        @elseif ($data->stage == 2 && Helpers::check_roles($data->division_id, 'Control Sample', 3))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Control Sample Inspection Completed
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#modal1">
                                More Information required
                            </button>
                        @elseif ($data->stage == 3 && Helpers::check_roles($data->division_id, 'Calibration Management', 3))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Distraction Complete
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#modal1">
                                More Information required
                            </button>
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
                                <div class="active">Pending Inspection of Control Sample</div>
                            @else
                                <div class="">Pending Inspection of Control Sample</div>
                            @endif
                            @if ($data->stage >= 3)
                                <div class="active">Pending Distraction </div>
                            @else
                                <div class="">Pending Distraction </div>
                            @endif

                            @if ($data->stage >= 4)
                                <div class="active bg-danger">Closed-Done</div>
                            @else
                                <div class="">Closed-Done</div>
                            @endif

                        </div>
                    @endif
                </div>
                <div class="top-block">
                    <div><strong> Record Name :&nbsp;</strong>Control Sample Data</div>
                    <div><strong> Site :&nbsp;</strong>{{ Helpers::getDivisionName($data->division_id) }}</div>
                    <div><strong> Current Status :&nbsp;</strong>{{ $data->status }}</div>
                    <div><strong> Initiated By :&nbsp;</strong>{{ Helpers::getInitiatorName($data->initiator_id) }}</div>
                </div>
            </div>
            <div class="modal right fade" id="myModal3" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-titles ml-10">Calibration Management Workflow</h4>
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
                                            <div class="active">
                                                Pending Inspection of Control Sample
                                            </div>
                                        @else
                                            <div class="mini_buttons">
                                                Pending Inspection of Control Sample
                                            </div>
                                        @endif
                                        <div class="down-logo">
                                            <img class="dawn_arrow" src="{{ asset('user/images/down.gif') }}"
                                                alt="..." class="w-100 h-100">
                                        </div>
                                        @if ($data->stage >= 3)
                                            <div class="active">
                                                Pending Distraction
                                            </div>
                                        @else
                                            <div class="mini_buttons">
                                                Pending Distraction
                                            </div>
                                        @endif
                                        <div class="down-logo">
                                            <img class="dawn_arrow" src="{{ asset('user/images/down.gif') }}"
                                                alt="..." class="w-100 h-100">
                                        </div>

                                        <div class="down-logo">
                                            <img class="dawn_arrow" src="{{ asset('user/images/down.gif') }}"
                                                alt="..." class="w-100 h-100">
                                        </div>
                                        @if ($data->stage >= 4)
                                            <div class="active bg-danger">
                                                Closed - Done
                                            </div>
                                        @else
                                            <div class="mini_buttons">
                                                Closed - Done
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
                        <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">Control Sample</button>
                        <button class="cctablinks" onclick="openCity(event, 'CCForm2')">Activity Log</button>
                        {{-- <button class="cctablinks" onclick="openCity(event, 'CCForm3')">QA Review</button>
                        <button class="cctablinks" onclick="openCity(event, 'CCForm4')">Activity Log</button> --}}
                    </div>

                    <form id="CCFormInput" action="{{ route('UpdateControlsample', $data->id) }}" method="POST"
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
                                                    value="{{ $data->record_number }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Division Code"><b>Site/Location Code</b></label>
                                                <input readonly type="text" name="division_code"
                                                    value="{{ Helpers::getDivisionName($controlSampleData->division_id) }}">
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Initiator"><b>Initiator</b></label>
                                                <input type="hidden" name="initiator_id">
                                                <input readonly type="text"
                                                    value="{{ $controlSampleData->initiator_name }}">
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
                                                    {{ $controlSampleData->stage == 0 || $controlSampleData->stage == 9 ? 'disabled' : '' }}>
                                                    <option value="">-- Select --</option>
                                                    @foreach ($users as $key => $value)
                                                        <option value="{{ $value->id }}"
                                                            @if ($data->assign_to == $value->id) selected @endif>
                                                            {{ $value->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="due-date">Due Date <span class="text-danger"></span></label>
                                                <input readonly type="text"
                                                    value="{{ Helpers::getdateFormat($controlSampleData->due_date) }}"
                                                    name="due_date"{{ $controlSampleData->stage == 0 || $controlSampleData->stage == 3 ? 'disabled' : '' }}>
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
                                                        value="{{ $controlSampleData->short_description }}"
                                                        maxlength="255" required
                                                        {{ $controlSampleData->stage == 0 || $controlSampleData->stage == 3 ? 'disabled' : '' }}>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Division Code"><b>Sample Id</b></label>
                                                <input type="text" name="sample_id"
                                                    value="{{ $controlSampleData->sample_id }}">
                                            </div>
                                        </div>

                                        {{-- <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Product Name">Product Name</label>
                                                <input type="text" name="product_name"
                                                    value="{{ $controlSampleData->product_name }}">
                                            </div>
                                        </div> --}}

                                        {{-- <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Product Code">Product Code</label>
                                                <input type="text" name="product_code"
                                                    value="{{ $controlSampleData->product_code }}">
                                            </div>
                                        </div> --}}

                                        {{-- <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Product Code">Sample Type</label>
                                                <input type="text" name="sample_type"
                                                    value="{{ $controlSampleData->sample_type }}">
                                            </div>
                                        </div> --}}

                                        {{-- <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Product Code">AR Number</label>
                                                <input type="text" name="ar_number"
                                                    value="{{ $controlSampleData->ar_number }}">
                                            </div>
                                        </div> --}}

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Sample Type">Reagent Item Required?</label>
                                                <select name="reagion_item" id="">
                                                    <option @if ($controlSampleData->reagion_item == 'yes') selected @endif value='yes'>Yes</option>
                                                    <option @if ($controlSampleData->reagion_item == 'No') selected @endif value='No'>No</option>
                                                </select>
                                            </div>
                                        </div>

                                        {{-- <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="market">Market</label>
                                                <select name="market" id="market">
                                                    <option value="">Select a country</option>
                                                    <option @if ($controlSampleData->market == 'Afghanistan') selected @endif value='Afghanistan'>Afghanistan</option>
                                                    <option @if ($controlSampleData->market == 'Albania') selected @endif value='Albania'>Albania</option>
                                                    <option @if ($controlSampleData->market == 'Algeria') selected @endif value='Algeria'>Algeria</option>
                                                    <option @if ($controlSampleData->market == 'American Samoa') selected @endif value='American Samoa'>American Samoa</option>
                                                    <option @if ($controlSampleData->market == 'Andorra') selected @endif value='Andorra'>Andorra</option>
                                                    <option @if ($controlSampleData->market == 'Angola') selected @endif value='Angola'>Angola</option>
                                                    <option @if ($controlSampleData->market == 'Argentina') selected @endif value='Argentina'>Argentina</option>
                                                    <option @if ($controlSampleData->market == 'Armenia') selected @endif value='Armenia'>Armenia</option>
                                                    <option @if ($controlSampleData->market == 'Australia') selected @endif value='Australia'>Australia</option>
                                                    <option @if ($controlSampleData->market == 'Austria') selected @endif value='Austria'>Austria</option>
                                                    <option @if ($controlSampleData->market == 'Bahrain') selected @endif value='Bahrain'>Bahrain</option>
                                                    <option @if ($controlSampleData->market == 'Bangladesh') selected @endif value='Bangladesh'>Bangladesh</option>
                                                    <option @if ($controlSampleData->market == 'Barbados') selected @endif value='Barbados'>Barbados</option>
                                                    <option @if ($controlSampleData->market == 'Belarus') selected @endif value='Belarus'>Belarus</option>
                                                    <option @if ($controlSampleData->market == 'Belgium') selected @endif value='Belgium'>Belgium</option>
                                                    <option @if ($controlSampleData->market == 'Belize') selected @endif value='Belize'>Belize</option>
                                                    <option @if ($controlSampleData->market == 'Benin') selected @endif value='Benin'>Benin</option>
                                                    <option @if ($controlSampleData->market == 'Bhutan') selected @endif value='Bhutan'>Bhutan</option>
                                                    <option @if ($controlSampleData->market == 'Bolivia') selected @endif value='Bolivia'>Azerbaijan</option>
                                                    <option @if ($controlSampleData->market == 'Botswana') selected @endif value='Botswana'>Botswana</option>
                                                    <option @if ($controlSampleData->market == 'Brazil') selected @endif value='Brazil'>Brazil</option>
                                                    <option @if ($controlSampleData->market == 'Bulgaria') selected @endif value='Bulgaria'>Bulgaria</option>
                                                    <option @if ($controlSampleData->market == 'Colombia') selected @endif value='Colombia'>Colombia</option>
                                                    <option @if ($controlSampleData->market == 'Croatia') selected @endif value='Croatia'>Croatia</option>
                                                    <option @if ($controlSampleData->market == 'Czech Republic') selected @endif value='Czech Republic'>Czech Republic</option>
                                                    <option @if ($controlSampleData->market == 'Denmark') selected @endif value='Denmark'>Denmark</option>
                                                    <option @if ($controlSampleData->market == 'Canada') selected @endif value='Canada'>Canada</option>
                                                    <option @if ($controlSampleData->market == 'Egypt') selected @endif value='Egypt'>Egypt</option>
                                                    <option @if ($controlSampleData->market == 'Finland') selected @endif value='Finland'>Finland</option>
                                                    <option @if ($controlSampleData->market == 'France') selected @endif value='France'>France</option>
                                                    <option @if ($controlSampleData->market == 'Germany') selected @endif value='Germany'>Germany</option>
                                                    <option @if ($controlSampleData->market == 'India') selected @endif value='India'>India</option>
                                                    <option @if ($controlSampleData->market == 'Italy') selected @endif value='Italy'>Italy</option>
                                                    <option @if ($controlSampleData->market == 'Japan') selected @endif value='Japan'>Japan</option>
                                                    <option @if ($controlSampleData->market == 'Mexico') selected @endif value='Mexico'>Mexico</option>
                                                    <option @if ($controlSampleData->market == 'Netherlands') selected @endif value='Netherlands'>Netherlands</option>
                                                    <option @if ($controlSampleData->market == 'New Zealand') selected @endif value='New Zealand'>New Zealand</option>
                                                    <option @if ($controlSampleData->market == 'Nigeria') selected @endif value='Nigeria'>Nigeria</option>
                                                    <option @if ($controlSampleData->market == 'Pakistan') selected @endif value='Pakistan'>Pakistan</option>
                                                    <option @if ($controlSampleData->market == 'Poland') selected @endif value='Poland'>Poland</option>
                                                    <option @if ($controlSampleData->market == 'Russia') selected @endif value='Russia'>Russia</option>
                                                    <option @if ($controlSampleData->market == 'Saudi Arabia') selected @endif value='Saudi Arabia'>Saudi Arabia</option>
                                                    <option @if ($controlSampleData->market == 'Spain') selected @endif value='Spain'>Spain</option>
                                                    <option @if ($controlSampleData->market == 'Sweden') selected @endif value='Sweden'>Sweden</option>
                                                    <option @if ($controlSampleData->market == 'Switzerland') selected @endif value='Switzerland'>Switzerland</option>
                                                    <option @if ($controlSampleData->market == 'Turkey') selected @endif value='Turkey'>Turkey</option>
                                                    <option @if ($controlSampleData->market == 'United Kingdom') selected @endif value='United Kingdom'>United Kingdom</option>
                                                    <option @if ($controlSampleData->market == 'United States') selected @endif value='United States'>United States</option>

                                                </select> 
                                            </div>
                                        </div> --}}


                                        {{-- <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Product Code">Batch Number</label>
                                                <input type="text" name="batch_number"
                                                    value="{{ $controlSampleData->batch_number }}">
                                            </div>
                                        </div> --}}

                                        {{-- <div class="col-lg-6 new-date-data-field">
                                            <div class="group-input input-date">
                                                <label for="manufacturing_date">Manufacturing Date</label>
                                                <div class="calenderauditee">
                                                    <!-- Displaying formatted manufacturing date -->
                                                    <input type="text" id="manufacturing_date_display" readonly 
                                                        value="{{ Helpers::getdateFormat($controlSampleData->manufacturing_date) }}" 
                                                        placeholder="DD-MMM-YYYY" />
                                        
                                                    <!-- Hidden date input to allow date selection -->
                                                    <input type="date" id="manufacturing_date" name="manufacturing_date"
                                                        value="{{ $controlSampleData->manufacturing_date ? \Carbon\Carbon::parse($controlSampleData->manufacturing_date)->format('Y-m-d') : '' }}"
                                                        min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input"
                                                        oninput="handleDateInput(this, 'manufacturing_date_display')" />
                                                </div>
                                            </div>
                                        </div> --}}
                                        
                                        {{-- <div class="col-lg-6 new-date-data-field">
                                            <div class="group-input input-date">
                                                <label for="expiry_date">Expiry Date</label>
                                                <div class="calenderauditee">
                                                    <!-- Displaying formatted expiry date -->
                                                    <input type="text" id="expiry_date_display" readonly 
                                                        value="{{ Helpers::getdateFormat($controlSampleData->expiry_date) }}" 
                                                        placeholder="DD-MMM-YYYY" />
                                        
                                                    <!-- Hidden date input to allow date selection -->
                                                    <input type="date" id="expiry_date" name="expiry_date"
                                                        value="{{ $controlSampleData->expiry_date ? \Carbon\Carbon::parse($controlSampleData->expiry_date)->format('Y-m-d') : '' }}"
                                                        min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input"
                                                        oninput="handleDateInput(this, 'expiry_date_display')" />
                                                </div>
                                            </div>
                                        </div> --}}

                                        {{-- <script>
                                            function handleDateInput(dateInput, textInputId) {
                                                const date = new Date(dateInput.value);
                                                if (!isNaN(date)) {
                                                    const options = { day: '2-digit', month: 'short', year: 'numeric' };
                                                    const formattedDate = date.toLocaleDateString('en-GB', options).replace(/ /g, '-');
                                                    document.getElementById(textInputId).value = formattedDate;
                                                } else {
                                                    document.getElementById(textInputId).value = '';
                                                }
                                            }
                                        </script> --}}

                                        

                                       

                                        <div class="pt-2 group-input">
                                            <label for="audit-agenda-grid">
                                                Control Sample Grid
                                                <button type="button" name="audit-agenda-grid" id="ObservationAdd">+</button>
                                                <span class="text-primary" data-bs-toggle="modal" data-bs-target="#observation-field-instruction-modal"
                                                      style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                                    (Launch Instruction)
                                                </span>
                                            </label>
                                            <div class="table-responsive">
                                                <table class="table table-bordered" id="job-responsibilty-table" style="width: 100%;">
                                                    <thead>
                                                        <tr>
                                                            <th><div style="width: 80px">Row #</div></th>
                                                            <th><div style="width: 100px">Product Name </div></th>
                                                            <th><div style="width: 100px">Product Code</div></th>
                                                            <th><div style="width: 100px">Sample Type </div></th>
                                                            <th><div style="width: 100px">Market </div></th>
                                                            <th><div style="width: 100px">Ar No </div></th>
                                                            <th><div style="width: 100px">Batch Number </div></th>
                                                            <th><div style="width: 100px">Manufacturing Date</div></th>
                                                            <th><div style="width: 100px">Expiry Date</div></th>
                                                            <th><div style="width: 100px">Quantity </div></th>
                                                            <th><div style="width: 100px">Unit of Measurement (UOM)</div></th>
                                                            <th><div style="width: 100px">Visual Inspection Scheduled On </div></th>
                                                            <th><div style="width: 100px">Schedule Date </div></th>
                                                            <th><div style="width: 100px">Quantity Withdrawn </div></th>
                                                            <th><div style="width: 100px">Reason For Withdrawal </div></th>
                                                            <th><div style="width: 100px">Current Quantity </div></th>
                                                            <th><div style="width: 100px">Storage Location </div></th>
                                                            <th><div style="width: 100px">Storage Condition </div></th>
                                                            <th><div style="width: 100px">Inspection Date </div></th>
                                                            <th><div style="width: 100px">Inspection Detail </div></th>
                                                            <th><div style="width: 100px">Inspection Done By </div></th>
                                                            <th><div style="width: 100px">Destruction Due On </div></th>
                                                            <th><div style="width: 100px">Destruction Date </div></th>
                                                            <th><div style="width: 100px">Destroyed By </div></th>
                                                            <th><div style="width: 100px">Neutralizing Agent </div></th>
                                                            <th><div style="width: 100px">Instruction For Destruction </div></th>
                                                            <th><div style="width: 100px">Remarks </div></th>
                                                            <th><div style="width: 100px">Action </div></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php $serialNumber = 1; @endphp
                                                        @if ($ControlSampleGrid && is_array($ControlSampleGrid->data))
                                                            @foreach ($ControlSampleGrid->data as $key => $csgrid)
                                                                <tr>
                                                                    <td>{{ $serialNumber++ }}</td>
                                                                    <td><input type="text" name="ControlSampleGrid[{{ $key }}][product_name]" value="{{ $csgrid['product_name'] ?? '' }}" class="product_name"></td>
                                                                    <td><input type="text" name="ControlSampleGrid[{{ $key }}][product_code]" value="{{ $csgrid['product_code'] ?? '' }}" class="product_code"></td>
                                                                    <td><input type="text" name="ControlSampleGrid[{{ $key }}][sample_type]" value="{{ $csgrid['sample_type'] ?? '' }}" class="sample_type"></td>
                                                                    <td>
                                                                        <select name="ControlSampleGrid[{{ $key }}][market]">
                                                                            <option {{ ($csgrid['market'] ?? '') == 'Select Value' ? 'selected' : '' }}>Select Value</option>
                                                                            <option {{ ($csgrid['market'] ?? '') == 'Afghanistan' ? 'selected' : '' }} value="Afghanistan">Afghanistan</option>
                                                                            <option {{ ($csgrid['market'] ?? '') == 'Albania' ? 'selected' : '' }} value="Albania">Albania</option>
                                                                            <option {{ ($csgrid['market'] ?? '') == 'Algeria' ? 'selected' : '' }} value="Algeria">Algeria</option>
                                                                            <option {{ ($csgrid['market'] ?? '') == 'American Samoa' ? 'selected' : '' }} value="American Samoa">American Samoa</option>
                                                                            <option {{ ($csgrid['market'] ?? '') == 'Cubic Meters' ? 'selected' : '' }} value="Cubic Meters">Cubic Meters</option>
                                                                            <option {{ ($csgrid['market'] ?? '') == 'Andorra' ? 'selected' : '' }} value="Andorra">Andorra</option>
                                                                            <option {{ ($csgrid['market'] ?? '') == 'Angola' ? 'selected' : '' }} value="Angola">Angola</option>
                                                                            <option {{ ($csgrid['market'] ?? '') == 'Argentina' ? 'selected' : '' }} value="Argentina">Argentina</option>
                                                                            <option {{ ($csgrid['market'] ?? '') == 'Armenia' ? 'selected' : '' }} value="Armenia">Armenia</option>
                                                                            <option {{ ($csgrid['market'] ?? '') == 'Australia' ? 'selected' : '' }} value="Australia">Australia</option>
                                                                            <option {{ ($csgrid['market'] ?? '') == 'Austria' ? 'selected' : '' }} value="Austria">Austria</option>
                                                                            <option {{ ($csgrid['market'] ?? '') == 'Azerbaijan' ? 'selected' : '' }} value="Azerbaijan">Azerbaijan</option>
                                                                            <option {{ ($csgrid['market'] ?? '') == 'Bahrain' ? 'selected' : '' }} value="Bahrain">Bahrain</option>
                                                                            <option {{ ($csgrid['market'] ?? '') == 'Bangladesh' ? 'selected' : '' }} value="Bangladesh">Bangladesh</option>
                                                                            <option {{ ($csgrid['market'] ?? '') == 'Barbados' ? 'selected' : '' }} value="Barbados">Barbados</option>
                                                                            <option {{ ($csgrid['market'] ?? '') == 'Belgium' ? 'selected' : '' }} value="Belgium">Belgium</option>
                                                                            <option {{ ($csgrid['market'] ?? '') == 'Belize' ? 'selected' : '' }} value="Belize">Belize</option>
                                                                            <option {{ ($csgrid['market'] ?? '') == 'Benin' ? 'selected' : '' }} value="Benin">Benin</option>
                                                                            <option {{ ($csgrid['market'] ?? '') == 'Bhutan' ? 'selected' : '' }} value="Bhutan">Bhutan</option>
                                                                            <option {{ ($csgrid['market'] ?? '') == 'Bolivia' ? 'selected' : '' }} value="Bolivia">Bolivia</option>
                                                                            <option {{ ($csgrid['market'] ?? '') == 'Botswana' ? 'selected' : '' }} value="Botswana">Botswana</option>
                                                                            <option {{ ($csgrid['market'] ?? '') == 'Brazil' ? 'selected' : '' }} value="Brazil">Brazil</option>
                                                                            <option {{ ($csgrid['market'] ?? '') == 'Bulgaria' ? 'selected' : '' }} value="Bulgaria">Bulgaria</option>
                                                                            <option {{ ($csgrid['market'] ?? '') == 'Canada' ? 'selected' : '' }} value="Canada">Canada</option>
                                                                            <option {{ ($csgrid['market'] ?? '') == 'China' ? 'selected' : '' }} value="China">China</option>
                                                                            <option {{ ($csgrid['market'] ?? '') == 'Croatia' ? 'selected' : '' }} value="Croatia">Croatia</option>
                                                                            <option {{ ($csgrid['market'] ?? '') == 'Colombia' ? 'selected' : '' }} value="Colombia">Colombia</option>
                                                                            <option {{ ($csgrid['market'] ?? '') == 'Czech Republic' ? 'selected' : '' }} value="Czech Republic">Czech Republic</option>
                                                                            <option {{ ($csgrid['market'] ?? '') == 'Denmark' ? 'selected' : '' }} value="Denmark">Denmark</option>
                                                                            <option {{ ($csgrid['market'] ?? '') == 'Egypt' ? 'selected' : '' }} value="Egypt">Egypt</option>
                                                                            <option {{ ($csgrid['market'] ?? '') == 'Finland' ? 'selected' : '' }} value="Finland">Finland</option>
                                                                            <option {{ ($csgrid['market'] ?? '') == 'Croatia' ? 'selected' : '' }} value="Croatia">Croatia</option>
                                                                            <option {{ ($csgrid['market'] ?? '') == 'Czech Republic' ? 'selected' : '' }} value="Czech Republic">Czech Republic</option>
                                                                            <option {{ ($csgrid['market'] ?? '') == 'Denmark' ? 'selected' : '' }} value="Denmark">Denmark</option>
                                                                            <option {{ ($csgrid['market'] ?? '') == 'Egypt' ? 'selected' : '' }} value="Egypt">Egypt</option>
                                                                            <option {{ ($csgrid['market'] ?? '') == 'Germany' ? 'selected' : '' }} value="Germany">Germany</option>
                                                                            <option {{ ($csgrid['market'] ?? '') == 'India' ? 'selected' : '' }} value="India">India</option>
                                                                            <option {{ ($csgrid['market'] ?? '') == 'Italy' ? 'selected' : '' }} value="Italy">Italy</option>
                                                                            <option {{ ($csgrid['market'] ?? '') == 'Japan' ? 'selected' : '' }} value="Japan">Japan</option>
                                                                            <option {{ ($csgrid['market'] ?? '') == 'Mexico' ? 'selected' : '' }} value="Mexico">Mexico</option>
                                                                            <option {{ ($csgrid['market'] ?? '') == 'Netherlands' ? 'selected' : '' }} value="Netherlands">Netherlands</option>
                                                                            <option {{ ($csgrid['market'] ?? '') == 'New Zealand' ? 'selected' : '' }} value="New Zealand">New Zealand</option>
                                                                            <option {{ ($csgrid['market'] ?? '') == 'Pakistan' ? 'selected' : '' }} value="Pakistan">Pakistan</option>
                                                                            <option {{ ($csgrid['market'] ?? '') == 'Poland' ? 'selected' : '' }} value="Poland">Poland</option>
                                                                            <option {{ ($csgrid['market'] ?? '') == 'Russia' ? 'selected' : '' }} value="Russia">Russia</option>
                                                                            <option {{ ($csgrid['market'] ?? '') == 'Saudi Arabia' ? 'selected' : '' }} value="Saudi Arabia">Saudi Arabia</option>
                                                                            <option {{ ($csgrid['market'] ?? '') == 'Sweden' ? 'selected' : '' }} value="Sweden">Sweden</option>
                                                                            <option {{ ($csgrid['market'] ?? '') == 'Switzerland' ? 'selected' : '' }} value="Switzerland">Switzerland</option>
                                                                            <option {{ ($csgrid['market'] ?? '') == 'Turkey' ? 'selected' : '' }} value="Turkey">Turkey</option>
                                                                            <option {{ ($csgrid['market'] ?? '') == 'United Kingdom' ? 'selected' : '' }} value="United Kingdom">United Kingdom</option>
                                                                            <option {{ ($csgrid['market'] ?? '') == 'United States' ? 'selected' : '' }} value="United States">United States</option>
                                                                        </select>
                                                                    </td>
                                                                    <td><input type="text" name="ControlSampleGrid[{{ $key }}][ar_number]" value="{{ $csgrid['ar_number'] ?? '' }}" class="ar_number"></td>
                                                                    <td><input type="text" name="ControlSampleGrid[{{ $key }}][batch_number]" value="{{ $csgrid['batch_number'] ?? '' }}" class="batch_number"></td>
                                                                    <td><input type="text" class="datepicker" name="ControlSampleGrid[{{ $key }}][manufacturing_date]" placeholder="DD-MM-YYYY" value="{{ $csgrid['manufacturing_date'] ?? '' }}"></td>
                                                                    <td><input type="text" class="datepicker" name="ControlSampleGrid[{{ $key }}][expiry_date]" placeholder="DD-MM-YYYY" value="{{ $csgrid['expiry_date'] ?? '' }}"></td>
                                                                  
                                                                    <td><input type="text" name="ControlSampleGrid[{{ $key }}][quantity]" value="{{ $csgrid['quantity'] ?? '' }}" class="quantity"></td>
                                                                    <td>
                                                                        <select name="ControlSampleGrid[{{ $key }}][unit_of_measurment]">
                                                                            <option {{ ($csgrid['unit_of_measurment'] ?? '') == 'Select Value' ? 'selected' : '' }}>Select Value</option>
                                                                            <option {{ ($csgrid['unit_of_measurment'] ?? '') == 'Pieces' ? 'selected' : '' }} value="Pieces">Pieces</option>
                                                                            <option {{ ($csgrid['unit_of_measurment'] ?? '') == 'Kilograms' ? 'selected' : '' }} value="Kilograms">Kilograms</option>
                                                                            <option {{ ($csgrid['unit_of_measurment'] ?? '') == 'Liters' ? 'selected' : '' }} value="Liters">Liters</option>
                                                                            <option {{ ($csgrid['unit_of_measurment'] ?? '') == 'Meters' ? 'selected' : '' }} value="Meters">Meters</option>
                                                                            <option {{ ($csgrid['unit_of_measurment'] ?? '') == 'Cubic Meters' ? 'selected' : '' }} value="Cubic Meters">Cubic Meters</option>
                                                                            <option {{ ($csgrid['unit_of_measurment'] ?? '') == 'Grams' ? 'selected' : '' }} value="Grams">Grams</option>
                                                                            <option {{ ($csgrid['unit_of_measurment'] ?? '') == 'Milliliters' ? 'selected' : '' }} value="Milliliters">Milliliters</option>
                                                                            <option {{ ($csgrid['unit_of_measurment'] ?? '') == 'Dozens' ? 'selected' : '' }} value="Dozens">Dozens</option>
                                                                            <option {{ ($csgrid['unit_of_measurment'] ?? '') == 'Percent' ? 'selected' : '' }} value="Percent">Percent</option>
                                                                        </select>
                                                                    </td>

                                                                    <script>
                                                                        $(document).ready(function () {
                                                                            $(".datepicker").datepicker({
                                                                                dateFormat: "d-M-yy" 
                                                                            });
                                                                        });
                                                                    </script>
                                                                    <td><input type="text" class="datepicker" name="ControlSampleGrid[{{ $key }}][vi_scheduled_on]" placeholder="DD-MM-YYYY" value="{{ $csgrid['vi_scheduled_on'] ?? '' }}"></td>
                                                                    <td><input type="text" class="datepicker" name="ControlSampleGrid[{{ $key }}][schdeule_date]" placeholder="DD-MM-YYYY" value="{{ $csgrid['schdeule_date'] ?? '' }}"></td>
                                                                    <td><input type="text" name="ControlSampleGrid[{{ $key }}][quantity_withdrawn]" value="{{ $csgrid['quantity_withdrawn'] ?? '' }}" class="quantity_withdrawn"></td>
                                                                    <td><input type="text" name="ControlSampleGrid[{{ $key }}][reason_for_withdrawal]" value="{{ $csgrid['reason_for_withdrawal'] ?? '' }}" class="reason_for_withdrawal"></td>
                                                                    <td><input type="text" name="ControlSampleGrid[{{ $key }}][current_quantity]" value="{{ $csgrid['current_quantity'] ?? '' }}" class="current_quantity"></td>
                                                                    <td><input type="text" name="ControlSampleGrid[{{ $key }}][storage_location]" value="{{ $csgrid['storage_location'] ?? '' }}"></td>
                                                                    <td><input type="text" name="ControlSampleGrid[{{ $key }}][storage_condition]" value="{{ $csgrid['storage_condition'] ?? '' }}"></td>
                                                                    <td><input type="text" class="datepicker" name="ControlSampleGrid[{{ $key }}][inspection_date]" placeholder="DD-MM-YYYY" value="{{ $csgrid['inspection_date'] ?? '' }}"></td>
                                                                    <td><input type="text" name="ControlSampleGrid[{{ $key }}][inspection_detail]" value="{{ $csgrid['inspection_detail'] ?? '' }}"></td>
                                                                    <td><input type="text" name="ControlSampleGrid[{{ $key }}][inspection_done_by]" value="{{ $csgrid['inspection_done_by'] ?? '' }}"></td>
                                                                    <td><input type="text" class="datepicker" name="ControlSampleGrid[{{ $key }}][destruction_due_on]" placeholder="DD-MM-YYYY" value="{{ $csgrid['destruction_due_on'] ?? '' }}"></td>
                                                                    <td><input type="text" class="datepicker" name="ControlSampleGrid[{{ $key }}][destruction_date]" placeholder="DD-MM-YYYY" value="{{ $csgrid['destruction_date'] ?? '' }}"></td>
                                                                    <td><input type="text" name="ControlSampleGrid[{{ $key }}][destroyed_by]" value="{{ $csgrid['destroyed_by'] ?? '' }}"></td>
                                                                    <td><input type="text" name="ControlSampleGrid[{{ $key }}][neutralizing_agent]" value="{{ $csgrid['neutralizing_agent'] ?? '' }}"></td>
                                                                    <td><input type="text" name="ControlSampleGrid[{{ $key }}][instruct_of_destrct]" value="{{ $csgrid['instruct_of_destrct'] ?? '' }}"></td>
                                                                    <td><input type="text" name="ControlSampleGrid[{{ $key }}][remarks]" value="{{ $csgrid['remarks'] ?? '' }}"></td>
                                                                    <td><button type="button" class="removeRowBtn">Remove</button></td>
                                                                </tr>
                                                            @endforeach
                                                        @else
                                                            <tr>
                                                                <td colspan="18">No data available</td>
                                                            </tr>
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="supportive_attachment">Supportive Attachment</label>
                                                <div><small class="text-primary">Please Attach all relevant or supporting
                                                        documents</small></div>

                                                <div class="file-attachment-field">
                                                    <div class="file-attachment-list" id="supportive_attachment">
                                                        @if ($controlSampleData->supportive_attachment)
                                                            @foreach (json_decode($controlSampleData->supportive_attachment) as $file)
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
                                                            {{ $controlSampleData->stage == 0 || $controlSampleData->stage == 9 ? 'disabled' : '' }}
                                                            type="file" id="myfile" name="supportive_attachment[]"
                                                            oninput="addMultipleFiles(this, 'supportive_attachment')"
                                                            multiple>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="button-block">
                                            <button type="submit" id="ChangesaveButton" class="saveButton">Save</button>
                                            <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                            <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}"
                                                    class="text-white"> Exit </a> </button>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div id="CCForm2" class="inner-block cctabcontent">
                                    <div class="inner-block-content">

                                                
                                    <div class="sub-head">Activity Log</div>

                                    <div class="d-flex align-item-end justify-content-end">
                                
                                            <button style="margin-bottom:20px;" class="button_theme1"> <a
                                                    class="text-white"
                                                    href="{{ url('controlsampleActivitylog', $data->id) }}"> Print </a>
                                            </button>
                                    </div>


                                    <div class="printable-content">
                                    
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <tbody>
                                                <!-- Row for Initiate Calibration By and Initiate Calibration On -->
                                                <tr>
                                                    <td>
                                                        <strong>submit By :</strong><br>
                                                        {{ $data->submit_by ?? 'Not Applicable' }}
                                                    </td>
                                                    <td>
                                                        <strong>submit On :</strong><br>
                                                        {{ Helpers::getdateFormat($data->submit_on)?? 'Not Applicable' }}</td>

                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="2">
                                                        <strong>submit Comment :</strong><br>
                                                        {{ $data->submit_comment ?? 'Not Applicable'}}
                                                    </td>
                                                </tr>


                                                <tr>
                                                    <td>
                                                        <strong>Control Sample Inspection Completed By:</strong><br>
                                                        {{ $data->control_sample_insp_by  ?? 'Not Applicable'}}
                                                    </td>
                                                    <td>
                                                        <strong>Control Sample Inspection Completed On:</strong><br>
                                                        {{ Helpers::getdateFormat($data->control_sample_insp_on) ?? 'Not Applicable' }}
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="2">
                                                        <strong>Control Sample Inspection Completed Comment:</strong><br>
                                                        {{  $data->control_sample_ins_comment ?? 'Not Applicable' }}
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>
                                                        <strong>More Information By :</strong><br>
                                                        {{ $data->more_info_by ?? 'Not Applicable' }}
                                                    </td>
                                                    <td>
                                                        <strong>More Information On :</strong><br>
                                                        {{ Helpers::getdateFormat($data->more_info_on) ?? 'Not Applicable' }}
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="2">
                                                        <strong>More Information Comment :</strong><br>
                                                        {{ $data->more_info_comment ?? 'Not Applicable' }}
                                                    </td>
                                                </tr>


                                                <tr>
                                                    <td>
                                                        <strong>Distraction Complete By :</strong><br>
                                                        {{  $data->distraction_complete_by ?? 'Not Applicable'}}
                                                    </td>
                                                    <td>
                                                        <strong>Distraction Complete On :</strong><br>
                                                        {{ Helpers::getdateFormat($data->distraction_complete_on)  ?? 'Not Applicable' }}
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="2">
                                                        <strong>Distraction Complete Comment :</strong><br>
                                                        {{ $data->distraction_complete_comment ?? 'Not Applicable' }}
                                                    </td>
                                                </tr>


                                                <tr>
                                                    <td>
                                                        <strong>More Information By :</strong><br>
                                                        {{  $data->more_info_second_by ?? 'Not Applicable' }}
                                                    </td>
                                                    <td>
                                                        <strong>More Information On :</strong><br>
                                                        {{ Helpers::getdateFormat($data->more_info_second_on) ?? 'Not Applicable' }}
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="2">
                                                        <strong>More Information Comment :</strong><br>
                                                        {{ $data->more_info_second_comment ?? 'Not Applicable' }}
                                                    </td>
                                                </tr>


                                                <tr>
                                            

                                            </tbody>
                                        </table>
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

                <form action="{{ url('CalibrationCancel', $controlSampleData->id) }}" method="POST">
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
                            <label for="comment">Comment <span class="text-danger"></span></label>
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

    <div class="modal fade" id="modal1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">E-Signature</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('RejectControlSample', $data->id) }}" method="POST">
                    @csrf
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="mb-3 text-justify">
                            Please select a meaning and a outcome for this task and enter your username
                            and password for this task. You are performing an electronic signature,
                            which is legally binding equivalent of a hand written signature.
                        </div>
                        <div class="group-input">
                            <label for="username">Username<span class="text-danger">*</span></label>
                            <input type="text" name="username" required>
                        </div>
                        <div class="group-input">
                            <label for="password">Password<span class="text-danger">*</span></label>
                            <input type="password" name="password" required>
                        </div>
                        <div class="group-input">
                            <label for="comment">Comment<span class="text-danger">*</span></label>
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

    <div class="modal fade" id="signature-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">E-Signature</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ url('controlSampleStageChange', $data->id) }}" method="POST">
                    @csrf
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="mb-3 text-justify">
                            Please select a meaning and a outcome for this task and enter your username
                            and password for this task. You are performing an electronic signature,
                            which is legally binding equivalent of a hand written signature.
                        </div>
                        <div class="group-input">
                            <label for="username">Username<span class="text-danger">*</span></label>
                            <input type="text" name="username" required>
                        </div>
                        <div class="group-input">
                            <label for="password">Password<span class="text-danger">*</span></label>
                            <input type="password" name="password" required>
                        </div>
                        <div class="group-input">
                            <label for="comment">Comment<span class="text-danger">*</span></label>
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


    <div class="modal fade" id="child-model">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Child</h4>
                </div>
                <form action="{{ route('CalibrationChild', $data->id) }}" method="POST">
                    @csrf
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="group-input">
                            @if ($data->stage == 3)
                                <div>
                                    {{-- <label for="minor">
                                        <input type="radio" name="revision" id="minor" value="Effective-Check">
                                        Effectiveness Check
                                    </label> <br> --}}

                                    <label for="minor">
                                        <input type="radio" name="revision" id="minor" value="Action Item">
                                        Action Item
                                    </label>
                                </div>
                            @endif

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

    <!-----Control sample grid----->
        
    <script>
        $(document).ready(function() {
            $('#ObservationAdd').click(function(e) {
                function generateTableRow(serialNumber) {
                    $(document).ready(function () {
                        $(".datepicker").datepicker({
                            dateFormat: "d-M-yy" 
                        });
                    });
                    var html = '<tr>' +
                        '<td><input disabled type="text" name="ControlSampleGrid[' + serialNumber + '][serial]" value="' + serialNumber + '"></td>' +
                        '<td><input type="text" name="ControlSampleGrid[' + serialNumber + '][product_name]" class="product_name"></td>' +
                        '<td><input type="text" name="ControlSampleGrid[' + serialNumber + '][product_code]" class="product_code"></td>' +
                        '<td><input type="text" name="ControlSampleGrid[' + serialNumber + '][sample_type]" class="sample_type"></td>' +
                        '<td><select name="ControlSampleGrid[' + serialNumber +'][market]"><option value="">Select Country</option><option value="Afghanistan">Afghanistan</option><option value="Albania">Albania</option><option value="Algeria">Algeria</option><option value="American Samoa">American Samoa</option><option value="Andorra">Andorra</option><option value="Angola">Angola</option><option value="Argentina">Argentina</option><option value="Armenia">Armenia</option><option value="Austria">Austria</option><option value="Azerbaijan">Azerbaijan</option><option value="Bahrain">Bahrain</option> <option value="Bangladesh">Bangladesh</option> <option value="Barbados">Barbados</option> <option value="Belgium">Belgium</option> <option value="Belize">Belize</option> <option value="Benin">Benin</option> <option value="Bhutan">Bhutan</option> <option value="Bolivia">Bolivia</option> <option value="Botswana">Botswana</option> <option value="Brazil">Brazil</option> <option value="Bulgaria">Bulgaria</option> <option value="Canada">Canada</option> <option value="China">China</option><option value="Croatia">Croatia</option> <option value="Colombia">Colombia</option> <option value="Czech Republic">Czech Republic</option> <option value="Denmark">Denmark</option> <option value="Egypt">Egypt</option> <option value="Finland">Finland</option> <option value="Croatia">Croatia</option> <option value="Czech Republic">Czech Republic</option>  <option value="Denmark">Denmark</option> <option value="Egypt">Egypt</option> <option value="Germany">Germany</option> <option value="India">India</option><option value="Italy">Italy</option> <option value="Japan">Japan</option> <option value="Mexico">Mexico</option> <option value="Netherlands">Netherlands</option> <option value="New Zealand">New Zealand</option> <option value="Pakistan">Pakistan</option> <option value="Poland">Poland</option> <option value="Russia">Russia</option>  <option value="Saudi Arabia">Saudi Arabia</option> <option value="Sweden">Sweden</option> <option value="Switzerland">Switzerland</option> <option value="Turkey">Turkey</option> <option value="United Kingdom">United Kingdom</option>  <option value="United States">United States</option> </select></td>'+

                        '<td><input type="text" name="ControlSampleGrid[' + serialNumber + '][ar_number]" class="ar_number"></td>' +
                        '<td><input type="text" name="ControlSampleGrid[' + serialNumber + '][batch_number]" class="batch_number"></td>' +
                        '<td><input type="text" class="datepicker" name="ControlSampleGrid[' + serialNumber + '][manufacturing_date]" placeholder="DD-MM-YYYY"></td>' +
                        '<td><input type="text" class="datepicker" name="ControlSampleGrid[' + serialNumber + '][expiry_date]" placeholder="DD-MM-YYYY"></td>' +

                        '<td><input type="text" name="ControlSampleGrid[' + serialNumber + '][quantity]" class="quantity"></td>' +
                        '<td><select name="ControlSampleGrid[' + serialNumber +'][unit_of_measurment]"><option value="">Select UOM</option><option value="Pieces">Pieces</option><option value="Kilograms">Kilograms</option><option value="Liters">Liters</option><option value="Meters">Meters</option><option value="Cubic Meters">Cubic Meters</option><option value="Grams">Grams</option><option value="Milliliters">Milliliters</option><option value="Dozens">Dozens</option><option value="Percent ">Percent </option></select></td>'+
                        
                        '<td><input type="text" class="datepicker" name="ControlSampleGrid[' + serialNumber + '][vi_scheduled_on]" placeholder="DD-MM-YYYY"></td>' +
                        '<td><input type="text" class="datepicker" name="ControlSampleGrid[' + serialNumber + '][schdeule_date]" placeholder="DD-MM-YYYY"></td>' +
                        
                        '<td><input type="text" name="ControlSampleGrid[' + serialNumber + '][quantity_withdrawn]" class="quantity_withdrawn"></td>' +
                        '<td><input type="text" name="ControlSampleGrid[' + serialNumber + '][reason_for_withdrawal]" class="reason_for_withdrawal"></td>' +
                        '<td><input type="text" name="ControlSampleGrid[' + serialNumber + '][current_quantity]" class="current_quantity"></td>' +
                        '<td><input type="text" name="ControlSampleGrid[' + serialNumber + '][storage_location]"></td>' +
                        '<td><input type="text" name="ControlSampleGrid[' + serialNumber + '][storage_condition]"></td>' +
                        
                        '<td><input type="text" class="datepicker" name="ControlSampleGrid[' + serialNumber + '][inspection_date]" placeholder="DD-MM-YYYY"></td>' +

                        '<td><input type="text" name="ControlSampleGrid[' + serialNumber + '][inspection_detail]"></td>' +
                        '<td><input type="text" name="ControlSampleGrid[' + serialNumber + '][inspection_done_by]"></td>' +
                       
                        '<td><input type="text" class="datepicker" name="ControlSampleGrid[' + serialNumber + '][destruction_due_on]" placeholder="DD-MM-YYYY"></td>' +

                        '<td><input type="text" class="datepicker" name="ControlSampleGrid[' + serialNumber + '][destruction_date]" placeholder="DD-MM-YYYY"></td>' +

                        '<td><input type="text" name="ControlSampleGrid[' + serialNumber + '][destroyed_by]"></td>' +
                        '<td><input type="text" name="ControlSampleGrid[' + serialNumber + '][neutralizing_agent]"></td>' +
                        '<td><input type="text" name="ControlSampleGrid[' + serialNumber + '][instruct_of_destrct]"></td>' +
                        '<td><input type="text" name="ControlSampleGrid[' + serialNumber + '][remarks]"></td>' +
                        '<td><button type="button" class="removeRowBtn">Remove</button></td>' +
                        '</tr>';
            
                    return html;
                }
        
                var tableBody = $('#job-responsibilty-table tbody');
                var rowCount = tableBody.children('tr').length;
                var newRow = generateTableRow(rowCount + 1);
                tableBody.append(newRow);
            });
    
            // Handle quantity withdrawn and current quantity
                   $(document).on('input', '.quantity_withdrawn', function() {
                    var row = $(this).closest('tr');
                    var quantity = parseFloat(row.find('.quantity').val()) || 0;
                    var withdrawn = parseFloat($(this).val()) || 0;
                    var currentQuantity = quantity - withdrawn;
                    row.find('.current_quantity').val(currentQuantity);
                });
        
            // Handle remove row button
            $('#job-responsibilty-table').on('click', '.removeRowBtn', function() {
                $(this).closest('tr').remove();
            });
        
            // Function to handle date input changes
            $(document).on('click', '.date-picker-text', function() {
                var id = $(this).attr('id');
                var hiddenInputId = 'hidden_' + id;
                $('#' + hiddenInputId).click();
            });
        
            $(document).on('change', '.date-picker-hidden', function() {
                var hiddenInputId = $(this).attr('id');
                var textInputId = hiddenInputId.replace('hidden_', '');
                var dateValue = $(this).val();
                var formattedDate = formatDate(dateValue);
                $('#' + textInputId).val(formattedDate);
            });
        
            // Function to format date to DD-MM-YYYY
            function formatDate(dateString) {
                var date = new Date(dateString);
                var day = ("0" + date.getDate()).slice(-2);
                var month = ("0" + (date.getMonth() + 1)).slice(-2);
                var year = date.getFullYear();
                return day + "-" + month + "-" + year;
            }
        });
    </script>
        

    
        
    
    
    

    

@endsection
