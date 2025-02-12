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
                    {{ Helpers::getDivisionName($equipment->division_id) }} / Equipment/Instrument Lifecycle Management
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

                    {{-- <div class="d-flex" style="gap:20px;">

                        <?php
                        $userRoles = DB::table('user_roles')->where(['user_id' => Auth::user()->id, 'q_m_s_divisions_id' => $data->division_id])->get();
                        $userRoleIds = $userRoles->pluck('q_m_s_roles_id')->toArray();
                       ?>
                        
                    </div> --}}
                    <div class="d-flex" style="gap:20px;">
                        @php
                            $userRoles = DB::table('user_roles')
                                ->where(['user_id' => Auth::user()->id, 'q_m_s_divisions_id' => $data->division_id])
                                ->get();
                            $userRoleIds = $userRoles->pluck('q_m_s_roles_id')->toArray();
                        @endphp
                        {{-- <button class="button_theme1" onclick="window.print();return false;"
                            class="new-doc-btn">Print</button> --}}
                        <button class="button_theme1"> <a class="text-white"
                                href="{{ url('EquipmentInfoAuditTrail', $data->id) }}">
                                Audit Trail </a> </button>

                        @if ($data->stage == 1 && (in_array(3, $userRoleIds) || in_array(18, $userRoleIds)))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Submit
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-modal">
                                Cancel
                            </button>
                        @elseif($data->stage == 2 && (in_array(7, $userRoleIds) || in_array(18, $userRoleIds)))
                            
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                               Supervisor Approval
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-modal">
                                Cancel
                            </button>
                        @elseif($data->stage == 3 && (in_array(7, $userRoleIds) || in_array(18, $userRoleIds)))
                            <!-- <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#rejection-modal">
                                More Info Required
                            </button> -->
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#rejection-modal">
                                More Information Required
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Complete Qualification
                            </button>
                        @elseif($data->stage == 4)
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#rejection-modal">
                                Request More Information
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Start Training
                            </button>
                            {{-- <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Complete Training
                            </button> --}}

                            <!-- <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#child-modal">
                                Child

                            </button> -->
                        @elseif($data->stage == 5)
                            {{-- <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#rejection-modal">
                                Re-Qualification

                            </button> --}}
                            
                            // <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                            //     Complete Training
                            // </button>
                        @elseif($data->stage == 6)
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#rejection-modal">
                                Re-Qualification

                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                 QA Approval

                            </button>
                        @elseif($data->stage == 7 && (in_array(7, $userRoleIds) || in_array(18, $userRoleIds)))
                            <!-- <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#rejection-modal">
                                More Information
                                Required
                            </button> -->
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#child-modal">
                                Child
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Take Out of Service
                            </button>
                        @elseif($data->stage == 8 && (in_array(7, $userRoleIds) || in_array(18, $userRoleIds)))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#rejection-modal">
                                Re-Activate
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Forward to Storage
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#rejection-modal-requalification">
                                Re-Qualification

                            </button>
                        @elseif($data->stage == 9 && (in_array(7, $userRoleIds) || in_array(18, $userRoleIds)))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Retire
                            </button>
                        @endif
                        <button class="button_theme1"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}">
                                Exit
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
                {{-- <div class="status">
                   
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
                </div> --}}
                <div class="status">
                    <div class="head">Current Status</div>
                    {{-- ------------------------------By Pankaj-------------------------------- --}}
                    @if ($data->stage == 0)
                        <div class="progress-bars">
                            <div class="bg-danger">Closed-Cancelled</div>
                        </div>
                    @else
                        <div class="progress-bars d-flex">
                            @if ($data->stage >= 1)
                                <div class="active">Opened</div>
                            @else
                                <div class="">Opened</div>
                            @endif
                            @if ($data->stage >= 2)
                                <div class="active">Supervisor Review</div>
                            @else
                                <div class="">Supervisor Review</div>
                            @endif
                            @if ($data->stage >= 3)
                                <div class="active">Pending Qualification</div>
                            @else
                                <div class="">Pending Qualification</div>
                            @endif


                            @if ($data->stage >= 4)
                                <div class="active">Pending Training </div>
                            @else
                                <div class="">Pending Training</div>
                            @endif
                            @if ($data->stage >= 5)
                                <div class="active">Training Evalution </div>
                            @else
                                <div class="">Training Evalution</div>
                            @endif
                            @if ($data->stage >= 6)
                                <div class="active">Pending QA Approval</div>
                            @else
                                <div class="">Pending QA Approval</div>
                            @endif
                            @if ($data->stage >= 7)
                                <div class="active">Active Equipment</div>
                            @else
                                <div class="">Active Equipment</div>
                            @endif
                            @if ($data->stage >= 8)
                                <div class="active">Out of Service</div>
                            @else
                                <div class="">Out of Service</div>
                            @endif
                            @if ($data->stage >= 9)
                                <div class="active">In Storage</div>
                            @else
                                <div class="">In Storage</div>
                            @endif
                            @if ($data->stage >= 10)
                                <div class="bg-danger">Closed - Retired</div>
                            @else
                                <div class="">Closed - Retired</div>
                            @endif
                        </div>
                    @endif


                </div>
                <br>
                <div class="top-block">
                    <div><strong> Record Name :&nbsp;</strong>Equipment/Instrument Lifecycle Management</div>
                    <div><strong> Site :&nbsp;</strong>{{ Helpers::getDivisionName($data->division_id) }}</div>
                    <div><strong> Current Status :&nbsp;</strong>{{ $data->status }}</div>
                    <div><strong> Initiated By :&nbsp;</strong>{{ Helpers::getInitiatorName($data->initiator_id) }}</div>
                </div>
            </div>
            <div class="modal right fade" id="myModal3" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-titles ml-10">Equipment/Instrument Lifecycle Management Workflow</h4>
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
                                            <img class="dawn_arrow" src="{{ asset('user/images/down.gif') }}"
                                                alt="..." class="w-100 h-100">
                                        </div>
                                        @if ($data->stage >= 2)
                                            <div class="active">
                                                Supervisor Review
                                            </div>
                                        @else
                                            <div class="mini_buttons">Supervisor Review</div>
                                        @endif
                                        <div class="down-logo">
                                            <img class="dawn_arrow" src="{{ asset('user/images/down.gif') }}"
                                                alt="..." class="w-100 h-100">
                                        </div>
                                        @if ($data->stage >= 3)
                                            <div class="active">
                                                Pending Qualification
                                            </div>
                                        @else
                                            <div class="mini_buttons">Pending Qualification</div>
                                        @endif
                                        <div class="down-logo">
                                            <img class="dawn_arrow" src="{{ asset('user/images/down.gif') }}"
                                                alt="..." class="w-100 h-100">
                                        </div>
                                        @if ($data->stage >= 4)
                                            <div class="active">
                                                Pending Training
                                            </div>
                                        @else
                                            <div class="mini_buttons">Pending Training</div>
                                        @endif
                                        <div class="down-logo">
                                            <img class="dawn_arrow" src="{{ asset('user/images/down.gif') }}"
                                                alt="..." class="w-100 h-100">
                                        </div>
                                        @if ($data->stage >= 5)
                                            <div class="active">
                                                Training Evalution
                                            </div>
                                        @else
                                            <div class="mini_buttons">Training Evalution</div>
                                        @endif
                                        <div class="down-logo">
                                            <img class="dawn_arrow" src="{{ asset('user/images/down.gif') }}"
                                                alt="..." class="w-100 h-100">
                                        </div>
                                        @if ($data->stage >= 6)
                                            <div class="active">
                                                Pending QA Approval
                                            </div>
                                        @else
                                            <div class="mini_buttons">Pending QA Approval</div>
                                        @endif
                                        <div class="down-logo">
                                            <img class="dawn_arrow" src="{{ asset('user/images/down.gif') }}"
                                                alt="..." class="w-100 h-100">
                                        </div>
                                        @if ($data->stage >= 7)
                                            <div class="active">
                                                Active Equipment
                                            </div>
                                        @else
                                            <div class="mini_buttons">Active Equipment</div>
                                        @endif
                                        <div class="down-logo">
                                            <img class="dawn_arrow" src="{{ asset('user/images/down.gif') }}"
                                                alt="..." class="w-100 h-100">
                                        </div>
                                        @if ($data->stage >= 8)
                                            <div class="active">
                                                Out of Service
                                            </div>
                                        @else
                                            <div class="mini_buttons">Out of Service</div>
                                        @endif
                                        <div class="down-logo">
                                            <img class="dawn_arrow" src="{{ asset('user/images/down.gif') }}"
                                                alt="..." class="w-100 h-100">
                                        </div>
                                        @if ($data->stage >= 9)
                                            <div class="active">
                                                In Storage
                                            </div>
                                        @else
                                            <div class="mini_buttons">In Storage</div>
                                        @endif
                                        <div class="down-logo">
                                            <img class="dawn_arrow" src="{{ asset('user/images/down.gif') }}"
                                                alt="..." class="w-100 h-100">
                                        </div>
                                        @if ($data->stage >= 10)
                                            <div class="active bg-danger">
                                                Closed - Retired
                                            </div>
                                        @else
                                            <div class="mini_buttons">
                                                Closed - Retired
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
                        <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">Equipment/Instrument Information</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm2')">Qualification Details</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm3')">Calibration Details</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm4')">Preventive Maintenance Details</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm5')">Spare Part Information</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm6')">Training Details</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm7')">Supervisor Review</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm8')">QA Review</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm9')">Equipment/Instrument Retirement</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm10')">Activity Log</button>
                    </div>

                    <form id="CCFormInput" action="{{ route('updateEquipmentInfo', $data->id) }}" method="POST"
                        enctype="multipart/form-data">
                        <input type="hidden" name="stage" id="stage" value="{{ $data->stage }}">

                        @csrf
                        {{-- @method('PUT') --}}

                        <!-- Tab content -->
                        {{-- <div id="step-form"> --}}
                        <div>

                            <div id="CCForm1" class="inner-block cctabcontent">
                                <div class="inner-block-content">
                                    <div class="row">

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="RLS Record Number"><b>Record Number</b></label>
                                                <input readonly type="text" name="record_number"
                                                    value="{{ $equipment->record_number }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Division Code"><b>Site/Location Code</b></label>
                                                <input readonly type="text" name="division_code"
                                                    value="{{ Helpers::getDivisionName($equipment->division_id) }}">
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Initiator"><b>Initiator</b></label>
                                                <input type="hidden" name="initiator_id">
                                                <input readonly type="text" value="{{ $equipment->initiator_name }} ">
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
                                                    {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }}>
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
                                                <input readonly type="text"
                                                    value="{{ Helpers::getdateFormat($equipment->due_date) }}"
                                                    name="due_date"{{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }}>
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
                                                        value="{{ $equipment->short_description }}" maxlength="255"
                                                        required
                                                        {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }}>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>
                                           
                                       
                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="equipment_id">Equipment/Instrument ID/Tag Number</label>
                                                <input type="number" name="equipment_id" value="{{ $equipment->equipment_id }}" min="0" {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }}/>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Equipment/Instrument_Name/Description">Equipment/Instrument Name/Description</label>
                                                <div class="relative-container">                                                    
                                                    <input type="text" name="equipment_name_description" value="{{ $equipment->equipment_name_description }}" {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }}/>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Manufacturer">Manufacturer</label>
                                                <div class="relative-container">                                                    
                                                    <input type="text" name="manufacturer" value="{{ $equipment->manufacturer }}" {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }}/>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Model_Number">Model Number</label>
                                                <input type="number" min="0" name="model_number" value="{{ $equipment->model_number }}" {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }} />
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Serial_Number">Serial Number</label>
                                                <input type="number" min="0" name="serial_number" value="{{ $equipment->serial_number }}" {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }} />
                                            </div>
                                        </div>
         
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Location">Location</label>
                                                <div class="relative-container">                                                    
                                                    <textarea name="location" {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }}>{{ $equipment->location }}</textarea>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 new-date-data-field">
                                            <div class="group-input input-date">
                                                <label for="Purchase Date">Purchase Date</label>
                                                <div class="calenderauditee">                                     
                                                    <input type="text"  id="purchase_date"  readonly placeholder="DD-MMM-YYYY" value="{{ Helpers::getdateFormat($equipment->purchase_date) }}"
                                                        {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }}/>
                                                    <input type="date" id="purchase_date_checkdate" name="purchase_date" max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }} value="{{ $equipment->purchase_date }}" class="hide-input"
                                                    oninput="handleDateInput(this, 'purchase_date');checkDate('purchase_date_checkdate','purchase_date1_checkdate')"/>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 new-date-data-field">
                                            <div class="group-input input-date">
                                                <label for="Installation Date">Installation Date</label>
                                                <div class="calenderauditee">                                     
                                                    <input type="text"  id="installation_date"  readonly placeholder="DD-MMM-YYYY" value="{{ Helpers::getdateFormat($equipment->installation_date) }}"
                                                        {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }}/>
                                                    <input type="date" id="installation_date_checkdate" name="installation_date" max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }} value="{{ $equipment->installation_date }}" class="hide-input"
                                                    oninput="handleDateInput(this, 'installation_date');checkDate('installation_date_checkdate','installation_date1_checkdate')"/>
                                                </div>
                                            </div>
                                        </div>  
                                        
                                        <div class="col-lg-6 new-date-data-field">
                                            <div class="group-input input-date">
                                                <label for="Warranty Expiration Date">Warranty Expiration Date</label>
                                                <div class="calenderauditee">                                     
                                                    <input type="text"  id="warranty_expiration_date"  readonly placeholder="DD-MMM-YYYY" value="{{ Helpers::getdateFormat($equipment->warranty_expiration_date) }}"
                                                        {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }}/>
                                                    <input type="date" id="warranty_expiration_date_checkdate" name="warranty_expiration_date" max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }} value="{{ $equipment->warranty_expiration_date }}" class="hide-input"
                                                    oninput="handleDateInput(this, 'warranty_expiration_date');checkDate('warranty_expiration_date_checkdate','warranty_expiration_date1_checkdate')"/>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="criticality_level">Criticality Level </label>
                                                <select name="criticality_level" id="criticality_level" {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }}>
                                                    <option value="">-- Select --</option>
                                                    <option value="High" {{ $equipment->criticality_level == 'High' ? 'selected' : '' }}>High</option>
                                                    <option value="Medium" {{ $equipment->criticality_level == 'Medium' ? 'selected' : '' }}>Medium</option>
                                                    <option value="Low" {{ $equipment->criticality_level == 'Low' ? 'selected' : '' }}>Low</option>                                                   
                                                </select>
                                            </div>
                                        </div>
        
                                        <div class="col-lg-12">
                                            <div class="group-input">
                                                <label for="asset_type">Asset Type</label>
                                                <select name="asset_type" id="asset_type" {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }}>
                                                    <option value="">-- Select --</option>
                                                    <option value="Reactors" {{ $equipment->asset_type == 'Reactors' ? 'selected' : '' }}>Reactors</option>
                                                    <option value="Mixers/Blenders" {{ $equipment->asset_type == 'Mixers/Blenders' ? 'selected' : '' }}>Mixers/Blenders</option>
                                                    <option value="Granulators" {{ $equipment->asset_type == 'Granulators' ? 'selected' : '' }}>Granulators</option>                                                   
                                                    <option value="Compressors" {{ $equipment->asset_type == 'Compressors' ? 'selected' : '' }}>Compressors</option>                                                   
                                                    <option value="Coating Machines" {{ $equipment->asset_type == 'Coating Machines' ? 'selected' : '' }}>Coating Machines</option>                                                   
                                                    <option value="Sterilizers" {{ $equipment->asset_type == 'Sterilizers' ? 'selected' : '' }}>Sterilizers</option>                                                   
                                                    <option value="Centrifuges" {{ $equipment->asset_type == 'Centrifuges' ? 'selected' : '' }}>Centrifuges</option>                                                   
                                                    <option value="Dryers" {{ $equipment->asset_type == 'Dryers' ? 'selected' : '' }}>Dryers</option>
                                                </select>
                                            </div>
                                        </div>
                                       
        
                                       
        
        
                                    </div>
                                    <div class="button-block">
                                        <button type="submit" class="saveButton">Save</button>
                                        <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                        <button type="button"> <a class="text-white"
                                                href="{{ url('rcms/qms-dashboard') }}">Exit</a> </button>
                                    </div>
                                </div>
                            </div>
                           
        
                            <div id="CCForm2" class="inner-block cctabcontent">
                                <div class="inner-block-content">
                                    <div class="row">
                                   
                                    <div class="col-12">
                                        <div class="group-input">
                                            <label for="Description">URS Description</label>
                                            <div class="relative-container">                                                    
                                                <textarea name="urs_description" id="urs_description" {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }}>{{ $equipment->urs_description }}</textarea>
                                                @component('frontend.forms.language-model')
                                                @endcomponent
                                            </div>
                                        </div>
                                    </div>
        
                                    <div class="col-12">
                                        <div class="group-input">
                                            <label for="Description">Initial/Business/System Level Risk Assessment Details</label>
                                            <div class="relative-container">                                                    
                                                <textarea name="system_level_risk_assessment_details" id="system_level_risk_assessment_details" {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }}>{{ $equipment->system_level_risk_assessment_details }}</textarea>
                                                @component('frontend.forms.language-model')
                                                @endcomponent
                                            </div>
                                        </div>
                                    </div>
                                   
                                    <div class="col-12 mb-4">
                                <div class="group-input">
                                    <label for="agenda">
                                        Failure Mode and Effect Analysis
                                        <button type="button" name="agenda"
                                            onclick="addRootCauseAnalysisRiskAssessment('risk-assessment-risk-management')" {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }}>+</button>
                                        <!-- <span class="text-primary" style="font-size: 0.8rem; font-weight: 400;">
                                            (Launch Instruction)
                                        </span> -->
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
                                                    <th>Proposed Additional Risk control measure (Mandatory for Risk
                                                        elements having RPN>4)</th>
                                                    <th>Residual Severity- H(3)/M(2)/L(1)</th>
                                                    <th>Residual Probability- H(3)/M(2)/L(1)</th>
                                                    <th>Residual Detectability- H(1)/M(2)/L(3)</th>
                                                    <th>Residual RPN</th>
                                                    <th>Risk Acceptance (Y/N)</th>
                                                    <th>Mitigation proposal (Mention either CAPA reference number, IQ,
                                                        OQ or
                                                        PQ)</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                        @if (!empty($data->risk_factor))
                                                            @foreach (unserialize($data->risk_factor) as $key => $riskFactor)
                                                                {{--  @dd($key, $riskFactor)  --}}

                                                                <tr>
                                                                    <td>{{ $key + 1 }}</td>
                                                                    <td><input name="risk_factor[]" type="text"
                                                                            value="{{ $riskFactor }}"
                                                                            {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }}>
                                                                    </td>
                                                                    <td><input name="risk_element[]" type="text"
                                                                            value="{{ unserialize($data->risk_element)[$key] ?? null }}"
                                                                            {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }}>
                                                                    </td>
                                                                    <td><input name="problem_cause[]" type="text"
                                                                            value="{{ unserialize($data->problem_cause)[$key] ?? null }}"
                                                                            {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }}>
                                                                    </td>
                                                                    <td><input name="existing_risk_control[]"
                                                                            type="text"
                                                                            value="{{ unserialize($data->existing_risk_control)[$key] ?? null }}"
                                                                            {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }}>
                                                                    </td>
                                                                    <td>
                                                                        <select onchange="calculateInitialResult(this)"
                                                                            class="fieldR" name="initial_severity[]"
                                                                            {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }}>
                                                                            <option value="">-- Select --</option>
                                                                            <option value="1"
                                                                                {{ (unserialize($data->initial_severity)[$key] ?? null) == 1 ? 'selected' : '' }}>
                                                                                1</option>
                                                                            <option value="2"
                                                                                {{ (unserialize($data->initial_severity)[$key] ?? null) == 2 ? 'selected' : '' }}>
                                                                                2</option>
                                                                            <option value="3"
                                                                                {{ (unserialize($data->initial_severity)[$key] ?? null) == 3 ? 'selected' : '' }}>
                                                                                3</option>
                                                                            <!-- <option value="4"
                                                                                {{ (unserialize($data->initial_severity)[$key] ?? null) == 4 ? 'selected' : '' }}>
                                                                                4-Critical</option>
                                                                            <option value="5"
                                                                                {{ (unserialize($data->initial_severity)[$key] ?? null) == 5 ? 'selected' : '' }}>
                                                                                5-Catastrophic</option> -->
                                                                        </select>
                                                                    </td>
                                                                    <td>
                                                                        <select onchange="calculateInitialResult(this)"
                                                                            class="fieldP" name="initial_detectability[]"
                                                                            {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }}>
                                                                            <option value="">-- Select --</option>
                                                                            <option value="1"
                                                                                {{ (unserialize($data->initial_detectability)[$key] ?? null) == 1 ? 'selected' : '' }}>
                                                                                1</option>
                                                                            <option value="2"
                                                                                {{ (unserialize($data->initial_detectability)[$key] ?? null) == 2 ? 'selected' : '' }}>
                                                                                2</option>
                                                                            <option value="3"
                                                                                {{ (unserialize($data->initial_detectability)[$key] ?? null) == 3 ? 'selected' : '' }}>
                                                                                3</option>
                                                                            <!-- <option value="4"
                                                                                {{ (unserialize($data->initial_detectability)[$key] ?? null) == 4 ? 'selected' : '' }}>
                                                                                4-Likely</option>
                                                                            <option value="5"
                                                                                {{ (unserialize($data->initial_detectability)[$key] ?? null) == 5 ? 'selected' : '' }}>
                                                                                5-Almost certain (every time)</option> -->
                                                                        </select>
                                                                    </td>
                                                                    <td>
                                                                        <select onchange="calculateInitialResult(this)"
                                                                            class="fieldN" name="initial_probability[]"
                                                                            {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }}>
                                                                            <option value="">-- Select --</option>
                                                                            <option value="1"
                                                                                {{ (unserialize($data->initial_probability)[$key] ?? null) == 1 ? 'selected' : '' }}>
                                                                                1</option>
                                                                            <option value="2"
                                                                                {{ (unserialize($data->initial_probability)[$key] ?? null) == 2 ? 'selected' : '' }}>
                                                                                2</option>
                                                                            <option value="3"
                                                                                {{ (unserialize($data->initial_probability)[$key] ?? null) == 3 ? 'selected' : '' }}>
                                                                                3</option>
                                                                            <!-- <option value="4"
                                                                                {{ (unserialize($data->initial_probability)[$key] ?? null) == 4 ? 'selected' : '' }}>
                                                                                4-Unlikely to detect</option>
                                                                            <option value="5"
                                                                                {{ (unserialize($data->initial_probability)[$key] ?? null) == 5 ? 'selected' : '' }}>
                                                                                5-Not detectable</option> -->
                                                                        </select>
                                                                    </td>
                                                                    <td>
                                                                        <input name="initial_rpn[]" class='initial-rpn'
                                                                            readonly
                                                                            value="{{ unserialize($data->initial_rpn)[$key] ?? null }}">
                                                                    </td>
                                                                    <td>
                                                                        <select onchange="calculateInitialResult(this)"
                                                                            class="fieldR" name="risk_acceptance[]"
                                                                            {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }}>
                                                                            <option value="">-- Select --</option>
                                                                            <option value="Y"
                                                                                {{ (unserialize($data->risk_acceptance)[$key] ?? null) == 'Y' ? 'selected' : '' }}>
                                                                                Y</option>
                                                                            <option value="N"
                                                                                {{ (unserialize($data->risk_acceptance)[$key] ?? null) == 'N' ? 'selected' : '' }}>
                                                                                N</option>
                                                                        </select>
                                                                    </td>
                                                                    <td>
                                                                        <input name="risk_control_measure[]"
                                                                            type="text"
                                                                            value="{{ unserialize($data->risk_control_measure)[$key] ?? null }}"
                                                                            {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }}>
                                                                    </td>
                                                                    <td>
                                                                        <select onchange="calculateResidualResult(this)"
                                                                            class="residual-fieldR"
                                                                            name="residual_severity[]"
                                                                            {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }}>
                                                                            <option value="">-- Select --</option>
                                                                            <option value="1"
                                                                                {{ (unserialize($data->residual_severity)[$key] ?? null) == 1 ? 'selected' : '' }}>
                                                                                1</option>
                                                                            <option value="2"
                                                                                {{ (unserialize($data->residual_severity)[$key] ?? null) == 2 ? 'selected' : '' }}>
                                                                                2</option>
                                                                            <option value="3"
                                                                                {{ (unserialize($data->residual_severity)[$key] ?? null) == 3 ? 'selected' : '' }}>
                                                                                3</option>
                                                                            <!-- <option value="4"
                                                                                {{ (unserialize($data->residual_severity)[$key] ?? null) == 4 ? 'selected' : '' }}>
                                                                                4-Critical</option>
                                                                            <option value="5"
                                                                                {{ (unserialize($data->residual_severity)[$key] ?? null) == 5 ? 'selected' : '' }}>
                                                                                5-Catastrophic</option> -->
                                                                        </select>
                                                                    </td>
                                                                    <td>
                                                                        <select onchange="calculateResidualResult(this)"
                                                                            class="residual-fieldP"
                                                                            name="residual_probability[]"
                                                                            {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }}>
                                                                            <option value="">-- Select --</option>
                                                                            <option value="1"
                                                                                {{ (unserialize($data->residual_probability)[$key] ?? null) == 1 ? 'selected' : '' }}>
                                                                                1</option>
                                                                            <option value="2"
                                                                                {{ (unserialize($data->residual_probability)[$key] ?? null) == 2 ? 'selected' : '' }}>
                                                                                2</option>
                                                                            <option value="3"
                                                                                {{ (unserialize($data->residual_probability)[$key] ?? null) == 3 ? 'selected' : '' }}>
                                                                                3</option>
                                                                            <!-- <option value="4"
                                                                                {{ (unserialize($data->residual_probability)[$key] ?? null) == 4 ? 'selected' : '' }}>
                                                                                4-Likely</option>
                                                                            <option value="5"
                                                                                {{ (unserialize($data->residual_probability)[$key] ?? null) == 5 ? 'selected' : '' }}>
                                                                                5-Almost certain (every time)</option> -->
                                                                        </select>
                                                                    </td>
                                                                    <td>
                                                                        <select onchange="calculateResidualResult(this)"
                                                                            class="residual-fieldN"
                                                                            name="residual_detectability[]"
                                                                            {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }}>
                                                                            <option value="">-- Select --</option>
                                                                            <option value="1"
                                                                                {{ (unserialize($data->residual_detectability)[$key] ?? null) == 1 ? 'selected' : '' }}>
                                                                                1</option>
                                                                            <option value="2"
                                                                                {{ (unserialize($data->residual_detectability)[$key] ?? null) == 2 ? 'selected' : '' }}>
                                                                                2</option>
                                                                            <option value="3"
                                                                                {{ (unserialize($data->residual_detectability)[$key] ?? null) == 3 ? 'selected' : '' }}>
                                                                                3</option>
                                                                            <!-- <option value="4"
                                                                                {{ (unserialize($data->residual_detectability)[$key] ?? null) == 4 ? 'selected' : '' }}>
                                                                                4-Unlikely to detect</option>
                                                                            <option value="5"
                                                                                {{ (unserialize($data->residual_detectability)[$key] ?? null) == 5 ? 'selected' : '' }}>
                                                                                5-Not detectable</option> -->
                                                                        </select>
                                                                    </td>
                                                                    <td>
                                                                        <input name="residual_rpn[]" class='residual-rpn'
                                                                            readonly
                                                                            value="{{ unserialize($data->residual_rpn)[$key] ?? null }}">
                                                                    </td>
                                                                    <td>
                                                                        <select onchange="calculateInitialResult(this)"
                                                                            class="fieldR" name="risk_acceptance2[]"
                                                                            {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }}>
                                                                            <option value="">-- Select --</option>
                                                                            <option value="Y"
                                                                                {{ (unserialize($data->risk_acceptance2)[$key] ?? null) == 'Y' ? 'selected' : '' }}>
                                                                                Y</option>
                                                                            <option value="N"
                                                                                {{ (unserialize($data->risk_acceptance2)[$key] ?? null) == 'N' ? 'selected' : '' }}>
                                                                                N</option>
                                                                        </select>
                                                                    </td>
                                                                    <td>
                                                                        <input name="mitigation_proposal[]" type="text"
                                                                            value="{{ unserialize($data->mitigation_proposal)[$key] ?? null }}"
                                                                            {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }}>
                                                                    </td>
                                                                    <td><button type="text" class="removeRowBtn"
                                                                            {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }}>Remove</button>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @endif
                                                    </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                                    <div class="col-12">
                                        <div class="group-input">
                                            <label for="Supporting Documents">Supporting Documents</label>
                                            <div><small class="text-primary">Please Attach all relevant or supporting
                                                    documents</small></div>

                                            <div class="file-attachment-field">
                                                <div class="file-attachment-list" id="supporting_documents">
                                                    @if ($equipment->supporting_documents)
                                                        @foreach (json_decode($equipment->supporting_documents) as $file)
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
                                                        {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }}
                                                        type="file" id="myfile" name="supporting_documents[]"
                                                        oninput="addMultipleFiles(this, 'supporting_documents')" multiple>
                                                </div>
                                            </div>
                                        </div>
                                    </div>       
                                       
        
                                    <div class="col-12">
                                        <div class="group-input">
                                            <label for="Description">FRS Description</label>
                                            <div class="relative-container">                                                    
                                                <textarea name="frs_description" id="frs_description" {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }}>{{ $equipment->frs_description }}</textarea>
                                                @component('frontend.forms.language-model')
                                                @endcomponent
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="group-input">
                                            <label for="FRS Attachment">FRS Attachment</label>
                                            <div><small class="text-primary">Please Attach all relevant or supporting
                                                    documents</small></div>

                                            <div class="file-attachment-field">
                                                <div class="file-attachment-list" id="frs_attachment">
                                                    @if ($equipment->frs_attachment)
                                                        @foreach (json_decode($equipment->frs_attachment) as $file)
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
                                                        {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }}
                                                        type="file" id="myfile" name="frs_attachment[]"
                                                        oninput="addMultipleFiles(this, 'frs_attachment')" multiple>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
        
        
                                    <div class="col-12">
                                        <div class="group-input">
                                            <label for="Description">Functional Risk Assessment Details</label>
                                            <div class="relative-container">                                                    
                                                <textarea name="functional_risk_assessment_details" id="functional_risk_assessment_details" {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }}>{{ $equipment->functional_risk_assessment_details }}</textarea>
                                                @component('frontend.forms.language-model')
                                                @endcomponent
                                            </div>
                                        </div>
                                    </div>
        
                                    <div class="col-12">
                                        <div class="sub-head">Installation Qualification (IQ)</div>

                                    </div>
                                    <div class="col-6">
                                        <div class="group-input">
                                                <label for="Type">IQ Test Plan</label>
                                                <select name="iq_test_plan" id="iq_test_plan" {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }}>
                                                    <option value="">-- Select --</option>
                                                    <option value="Electrical" {{ $equipment->iq_test_plan == 'Electrical' ? 'selected' : '' }}>Electrical</option>
                                                    <option value="Mechanical" {{ $equipment->iq_test_plan == 'Mechanical' ? 'selected' : '' }}>Mechanical</option>
                                                    <option value="Environmental" {{ $equipment->iq_test_plan == 'Environmental' ? 'selected' : '' }}>Environmental</option>                                                    
                                                </select>
                                            </div>
                                    </div>  
                                   
                                    <div class="col-6">
                                        <div class="group-input">
                                            <label for="Description">IQ Protocol</label>
                                            <div class="relative-container">                                                    
                                                <input name="iq_protocol" id="iq_protocol" value="{{ $equipment->iq_protocol }}" {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }}/>
                                                @component('frontend.forms.language-model')
                                                @endcomponent
                                            </div>
                                        </div>
                                    </div>
        
                                    <div class="col-6">
                                        <div class="group-input">
                                            <label for="Description">IQ Execution</label>
                                            <div class="relative-container">                                                    
                                                <input name="iq_execution" id="iq_execution" value="{{ $equipment->iq_execution }}" {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }} />
                                                @component('frontend.forms.language-model')
                                                @endcomponent
                                            </div>
                                        </div>
                                    </div>
        
                                    <div class="col-6">
                                        <div class="group-input">
                                            <label for="Description">IQ Report</label>
                                            <div class="relative-container">                                                    
                                                <input name="iq_report" id="iq_report" value="{{ $equipment->iq_report }}" {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }} />
                                                @component('frontend.forms.language-model')
                                                @endcomponent
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 mb-4">
                                        <div class="group-input">
                                            <label for="agenda">
                                            Equipment/Instrument Qualification Attachment (IQ)
                                                <button type="button" name="agenda"
                                                    onclick="addIQAttachment('qualification-iq')">+</button>
                                            </label>
                                                <table class="table table-bordered"
                                                    id="qualification-iq">
                                                    <thead>
                                                        <tr>
                                                            <th>Sr. No.</th>
                                                            <th>Document Name</th>
                                                            <th>Document ID</th>
                                                            <th>Remarks</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if (!empty($equipgrid->doc_name_IQ))
                                                            @foreach (unserialize($equipgrid->doc_name_IQ) as $key => $riskFactor)
                                                                <tr>
                                                                    <td>{{ $key + 1 }}</td>
                                                                    <td><input name="doc_name_IQ[]" type="text"
                                                                            value="{{ $riskFactor }}"
                                                                            {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }}>
                                                                    </td>
                                                                    <td><input name="doc_id_IQ[]" type="text"
                                                                            value="{{ unserialize($equipgrid->doc_id_IQ)[$key] ?? null }}"
                                                                            {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }}>
                                                                    </td>
                                                                    <td><input name="doc_remark_IQ[]" type="text"
                                                                            value="{{ unserialize($equipgrid->doc_remark_IQ)[$key] ?? null }}"
                                                                            {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }}>
                                                                    </td>
                                                                    <td><button type="text" class="removeRowBtn"
                                                                            {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }}>Remove</button>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @endif
                                                    </tbody>
                                                </table>
                                        </div>
                                    </div>
        
        
                                        <div class="col-12">
                                            <div class="sub-head">Design Qualification (DQ)</div>
                                            <div class="group-input">
                                                <label for="Type">DQ Test Plan</label>
                                                <select name="dq_test_plan" id="dq_test_plan" {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }}>
                                                    <option value="">-- Select --</option>
                                                    <option value="Electrical" {{ $equipment->dq_test_plan == 'Electrical' ? 'selected' : '' }}>Electrical</option>
                                                    <option value="Mechanical" {{ $equipment->dq_test_plan == 'Mechanical' ? 'selected' : '' }}>Mechanical</option>
                                                    <option value="Environmental" {{ $equipment->dq_test_plan == 'Environmental' ? 'selected' : '' }}>Environmental</option>                                                   
                                                
                                                </select>
                                            </div>
                                        </div>  
                                       
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Description">DQ Protocol</label>
                                                <div class="relative-container">                                                    
                                                    <input name="dq_protocol" id="dq_protocol" value="{{ $equipment->dq_protocol }}" {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }} />
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>
        
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Description">DQ Execution</label>
                                                <div class="relative-container">                                                    
                                                    <input name="dq_execution" id="dq_execution" value="{{ $equipment->dq_execution }}" {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }} />
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>
        
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Description">DQ Report</label>
                                                <div class="relative-container">                                                    
                                                    <input name="dq_report" id="dq_report" value="{{ $equipment->dq_report }}" {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }} />
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 mb-4">
                                            <div class="group-input">
                                                <label for="agenda">
                                                Equipment/Instrument Qualification Attachment (DQ)
                                                    <button type="button" name="agenda"
                                                        onclick="add_DQ_Attachment('qualification-DQ')">+</button>
                                                </label>
                                                    <table class="table table-bordered"
                                                        id="qualification-DQ">
                                                        <thead>
                                                            <tr>
                                                                <th>Sr. No.</th>
                                                                <th>Document Name</th>
                                                                <th>Document ID</th>
                                                                <th>Remarks</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @if (!empty($equipgrid->doc_name_DQ))
                                                                @foreach (unserialize($equipgrid->doc_name_DQ) as $key => $riskFactor_dq)
                                                                    <tr>
                                                                        <td>{{ $key + 1 }}</td>
                                                                        <td><input name="doc_name_DQ[]" type="text"
                                                                                value="{{ $riskFactor_dq }}"
                                                                                {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }}>
                                                                        </td>
                                                                        <td><input name="doc_id_DQ[]" type="text"
                                                                                value="{{ unserialize($equipgrid->doc_id_DQ)[$key] ?? null }}"
                                                                                {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }}>
                                                                        </td>
                                                                        <td><input name="doc_remark_DQ[]" type="text"
                                                                                value="{{ unserialize($equipgrid->doc_remark_DQ)[$key] ?? null }}"
                                                                                {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }}>
                                                                        </td>
                                                                        <td><button type="text" class="removeRowBtn"
                                                                                {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }}>Remove</button>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            @endif
                                                        </tbody>
                                                    </table>
                                            </div>
                                        </div>
        
                                        <div class="col-12">
                                            <div class="sub-head">Operational Qualification (OQ)</div>
                                            <div class="group-input">
                                                <label for="Description">OQ Test Plan</label>
                                                <div class="relative-container">                                                    
                                                    <input name="oq_test_plan" id="oq_test_plan" value="{{ $equipment->oq_test_plan }}" {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }} />
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>  
                                       
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Description">OQ Protocol</label>
                                                <div class="relative-container">                                                    
                                                    <input name="oq_protocol" id="oq_protocol" value="{{ $equipment->oq_protocol }}" {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }} />
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>
        
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Description">OQ Execution</label>
                                                <div class="relative-container">                                                    
                                                    <input name="oq_execution" id="oq_execution" value="{{ $equipment->oq_execution }}" {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }} />
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>
        
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Description">OQ Report</label>
                                                <div class="relative-container">                                                    
                                                    <input name="oq_report" id="oq_report" value="{{ $equipment->oq_report }}"></input>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 mb-4">
                                            <div class="group-input">
                                                <label for="agenda">
                                                Equipment/Instrument Qualification Attachment (OQ)
                                                    <button type="button" name="agenda"
                                                        onclick="add_OQ_Attachment('qualification-OQ')">+</button>
                                                </label>
                                                    <table class="table table-bordered"
                                                        id="qualification-OQ">
                                                        <thead>
                                                            <tr>
                                                                <th>Sr. No.</th>
                                                                <th>Document Name</th>
                                                                <th>Document ID</th>
                                                                <th>Remarks</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @if (!empty($equipgrid->doc_name_OQ))
                                                                    @foreach (unserialize($equipgrid->doc_name_OQ) as $key => $riskFactor_oq)
                                                                        <tr>
                                                                            <td>{{ $key + 1 }}</td>
                                                                            <td><input name="doc_name_OQ[]" type="text"
                                                                                    value="{{ $riskFactor_oq }}"
                                                                                    {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }}>
                                                                            </td>
                                                                            <td><input name="doc_id_OQ[]" type="text"
                                                                                    value="{{ unserialize($equipgrid->doc_id_OQ)[$key] ?? null }}"
                                                                                    {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }}>
                                                                            </td>
                                                                            <td><input name="doc_remark_OQ[]" type="text"
                                                                                    value="{{ unserialize($equipgrid->doc_remark_OQ)[$key] ?? null }}"
                                                                                    {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }}>
                                                                            </td>
                                                                            <td><button type="text" class="removeRowBtn"
                                                                                    {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }}>Remove</button>
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                @endif
                                                        </tbody>
                                                    </table>
                                            </div>
                                        </div>        
        
                                        <div class="col-12">
                                            <div class="sub-head">Performance Qualification (PQ)</div>
                                            <div class="group-input">
                                                <label for="Description">PQ Test Plan</label>
                                                <div class="relative-container">                                                    
                                                    <input name="pq_test_plan" id="pq_test_plan" value="{{ $equipment->pq_test_plan }}"></input>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>  
                                       
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Description">PQ Protocol</label>
                                                <div class="relative-container">                                                    
                                                    <input name="pq_protocol" id="pq_protocol" value="{{ $equipment->pq_protocol }}"></input>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>
        
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Description">PQ Execution</label>
                                                <div class="relative-container">                                                    
                                                    <input name="pq_execution" id="pq_execution" value="{{ $equipment->pq_execution }}"></input>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>
        
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Description">PQ Report</label>
                                                <div class="relative-container">                                                    
                                                    <input name="pq_report" id="pq_report" value="{{ $equipment->pq_report }}"></input>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 mb-4">
                                            <div class="group-input">
                                                <label for="agenda">
                                                Equipment/Instrument Qualification Attachment (PQ)
                                                    <button type="button" name="agenda"
                                                        onclick="add_PQ_Attachment('qualification-PQ')">+</button>
                                                </label>
                                                    <table class="table table-bordered"
                                                        id="qualification-PQ">
                                                        <thead>
                                                            <tr>
                                                                <th>Sr. No.</th>
                                                                <th>Document Name</th>
                                                                <th>Document ID</th>
                                                                <th>Remarks</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @if (!empty($equipgrid->doc_name_PQ))
                                                                    @foreach (unserialize($equipgrid->doc_name_PQ) as $key => $riskFactor_pq)
                                                                        <tr>
                                                                            <td>{{ $key + 1 }}</td>
                                                                            <td><input name="doc_name_PQ[]" type="text"
                                                                                    value="{{ $riskFactor_pq }}"
                                                                                    {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }}>
                                                                            </td>
                                                                            <td><input name="doc_id_PQ[]" type="text"
                                                                                    value="{{ unserialize($equipgrid->doc_id_PQ)[$key] ?? null }}"
                                                                                    {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }}>
                                                                            </td>
                                                                            <td><input name="doc_remark_PQ[]" type="text"
                                                                                    value="{{ unserialize($equipgrid->doc_remark_PQ)[$key] ?? null }}"
                                                                                    {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }}>
                                                                            </td>
                                                                            <td><button type="text" class="removeRowBtn"
                                                                                    {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }}>Remove</button>
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                @endif
                                                        </tbody>
                                                    </table>
                                            </div>
                                        </div>        
        
                                    <div class="col-12">
                                        <div class="group-input">
                                            <label for="Description">Migration Details</label>
                                            <div class="relative-container">                                                    
                                                <textarea name="migration_details" id="migration_details">{{ $equipment->migration_details }}</textarea>
                                                @component('frontend.forms.language-model')
                                                @endcomponent
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="group-input">
                                            <label for="Migration Attachment">Migration Attachment</label>
                                            <div><small class="text-primary">Please Attach all relevant or supporting
                                                    documents</small></div>

                                            <div class="file-attachment-field">
                                                <div class="file-attachment-list" id="migration_attachment">
                                                    @if ($equipment->migration_attachment)
                                                        @foreach (json_decode($equipment->migration_attachment) as $file)
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
                                                        {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }}
                                                        type="file" id="myfile" name="migration_attachment[]"
                                                        oninput="addMultipleFiles(this, 'migration_attachment')" multiple>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
        
                                        
                                    <div class="col-12">
                                        <div class="group-input">
                                            <label for="Description">Configuration Specification Details</label>
                                            <div class="relative-container">                                                    
                                                <textarea name="configuration_specification_details" id="configuration_specification_details">{{ $equipment->configuration_specification_details }}</textarea>
                                                @component('frontend.forms.language-model')
                                                @endcomponent
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="group-input">
                                            <label for="Configuration Specification Attachment">Configuration Specification Attachment</label>
                                            <div><small class="text-primary">Please Attach all relevant or supporting
                                                    documents</small></div>

                                            <div class="file-attachment-field">
                                                <div class="file-attachment-list" id="configuration_specification_attachment">
                                                    @if ($equipment->configuration_specification_attachment)
                                                        @foreach (json_decode($equipment->configuration_specification_attachment) as $file)
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
                                                        {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }}
                                                        type="file" id="myfile" name="configuration_specification_attachment[]"
                                                        oninput="addMultipleFiles(this, 'configuration_specification_attachment')" multiple>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                
                                    <div class="col-12">
                                        <div class="group-input">
                                            <label for="Description">Rquirement Traceability Details</label>
                                            <div class="relative-container">                                                    
                                                <textarea name="requirement_traceability_details" id="requirement_traceability_details">{{ $equipment->requirement_traceability_details }}</textarea>
                                                @component('frontend.forms.language-model')
                                                @endcomponent
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="group-input">
                                            <label for="Requirement Traceability Attachment">Requirement Traceability Attachment</label>
                                            <div><small class="text-primary">Please Attach all relevant or supporting
                                                    documents</small></div>

                                            <div class="file-attachment-field">
                                                <div class="file-attachment-list" id="requirement_traceability_attachment">
                                                    @if ($equipment->requirement_traceability_attachment)
                                                        @foreach (json_decode($equipment->requirement_traceability_attachment) as $file)
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
                                                        {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }}
                                                        type="file" id="myfile" name="requirement_traceability_attachment[]"
                                                        oninput="addMultipleFiles(this, 'requirement_traceability_attachment')" multiple>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
        
        
                                    <div class="col-12">
                                        <div class="group-input">
                                            <label for="Description">Validation Summary Report</label>
                                            <div class="relative-container">                                                    
                                                <textarea name="validation_summary_report" id="validation_summary_report">{{ $equipment->validation_summary_report }}</textarea>
                                                @component('frontend.forms.language-model')
                                                @endcomponent
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 new-date-data-field">
                                        <div class="group-input input-date">
                                            <label for="Periodic Qualification Pending On">Periodic Qualification Pending On</label>
                                            <div class="calenderauditee">                                     
                                                <input type="text"  id="periodic_qualification_pending_on"  readonly placeholder="DD-MMM-YYYY" value="{{ Helpers::getdateFormat($equipment->periodic_qualification_pending_on) }}"
                                                    {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }}/>
                                                <input type="date" id="periodic_qualification_pending_on_checkdate" name="periodic_qualification_pending_on" max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }} value="{{ $equipment->periodic_qualification_pending_on }}" class="hide-input"
                                                oninput="handleDateInput(this, 'periodic_qualification_pending_on');checkDate('periodic_qualification_pending_on_checkdate','periodic_qualification_pending_on1_checkdate')"/>
                                            </div>
                                        </div>
                                    </div>
        
        
                                    <div class="col-12">
                                        <div class="group-input">
                                            <label for="Description">Periodic Qualification Notification (Days)</label>
                                            <input type="number" min="0" name="periodic_qualification_notification" id="periodic_qualification_notification" value="{{ $equipment->periodic_qualification_notification }}"></input>
                                        </div>
                                    </div>
        
                                    </div>
                                    <div class="button-block">
                                        <button type="submit" class="saveButton">Save</button>
                                        <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                        <button type="submit">Submit</button>
                                        <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                                                Exit </a> </button>
                                    </div>
                                </div>
                            </div>
        
        
                            <div id="CCForm3" class="inner-block cctabcontent">
                                <div class="inner-block-content">
                                    <div class="row">
                                        
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Date Due">Calibration Standard Reference</label>
                                                <div class="relative-container">
                                                    <input type="text" name="calibration_standard_preference" value="{{ $equipment->calibration_standard_preference }}">
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>
                                        
        
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Zone">Calibration Frequency</label>
                                                <select name="callibration_frequency">
                                                    <option value="">Select Calibration Frequency</option>
                                                    <option value="Weekly" {{ $equipment->callibration_frequency == 'Weekly' ? 'selected' : '' }}>Weekly</option>
                                                    <option value="Fortnightly" {{ $equipment->callibration_frequency == 'Fortnightly' ? 'selected' : '' }}>Fortnightly</option>
                                                    <option value="Monthly" {{ $equipment->callibration_frequency == 'Monthly' ? 'selected' : '' }}>Monthly</option>                                                   
                                                    <option value="Quarterly" {{ $equipment->callibration_frequency == 'Quarterly' ? 'selected' : '' }}>Quarterly</option>
                                                    <option value="Half Yearly" {{ $equipment->callibration_frequency == 'Half Yearly' ? 'selected' : '' }}>Half Yearly</option>
                                                    <option value="Annually" {{ $equipment->callibration_frequency == 'Annually' ? 'selected' : '' }}>Annually</option>                                                   
                                                    <option value="Once in Two Years" {{ $equipment->callibration_frequency == 'Once in Two Years' ? 'selected' : '' }}>Once in Two Years</option>                                                   
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 new-date-data-field">
                                            <div class="group-input input-date">
                                                <label for="Last Calibration Date">Last Calibration Date</label>
                                                <div class="calenderauditee">                                     
                                                    <input type="text"  id="last_calibration_date"  readonly placeholder="DD-MMM-YYYY" value="{{ Helpers::getdateFormat($equipment->last_calibration_date) }}"
                                                        {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }}/>
                                                    <input type="date" id="last_calibration_date_checkdate" name="last_calibration_date" max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }} value="{{ $equipment->last_calibration_date }}" class="hide-input"
                                                    oninput="handleDateInput(this, 'last_calibration_date');checkDate('last_calibration_date_checkdate','next_calibration_date_checkdate')"/>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 new-date-data-field">
                                            <div class="group-input input-date">
                                                <label for="Next Calibration Date">Next Calibration Date</label>
                                                <div class="calenderauditee">                                     
                                                    <input type="text"  id="next_calibration_date"  readonly placeholder="DD-MMM-YYYY" value="{{ Helpers::getdateFormat($equipment->next_calibration_date) }}"
                                                        {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }}/>
                                                    <input type="date" id="next_calibration_date_checkdate" name="next_calibration_date" max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }} value="{{ $equipment->next_calibration_date }}" class="hide-input"
                                                    oninput="handleDateInput(this, 'next_calibration_date');checkDate('last_calibration_date_checkdate','next_calibration_date_checkdate')"/>
                                                </div>
                                            </div>
                                        </div>
        
        
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Details">Calibration Due Reminder</label>
                                                <input type="number" name="calibration_due_reminder" value="{{ $equipment->calibration_due_reminder }}" min="0">
                                            </div>
                                        </div>
        
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Details">Calibration Method/Procedure</label>
                                                <div class="relative-container">
                                                    <textarea name="calibration_method_procedure">{{ $equipment->calibration_method_procedure }}</textarea>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>
                                        

                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Calibration Procedure Reference/Document">Calibration Procedure Reference/Document</label>
                                                <div><small class="text-primary">Please Attach all relevant or supporting
                                                        documents</small></div>
    
                                                <div class="file-attachment-field">
                                                    <div class="file-attachment-list" id="calibration_procedure_attach">
                                                        @if ($equipment->calibration_procedure_attach)
                                                            @foreach (json_decode($equipment->calibration_procedure_attach) as $file)
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
                                                            {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }}
                                                            type="file" id="myfile" name="calibration_procedure_attach[]"
                                                            oninput="addMultipleFiles(this, 'calibration_procedure_attach')" multiple>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
        
        
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Date Due">Calibration Standards Used</label>
                                                <div class="relative-container">
                                                    <input type="text" name="calibration_used" value="{{ $equipment->calibration_used }}">
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>
                                        
        
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Date Due">Calibration Parameters</label>
                                                <select name="calibration_parameter">
                                                    <option value="">--Select--</option>
                                                    <option value="Temperature" {{ $equipment->calibration_parameter == 'Temperature' ? 'selected' : '' }}>Temperature</option>
                                                    <option value="Pressure" {{ $equipment->calibration_parameter == 'Pressure' ? 'selected' : '' }}>Pressure</option>
                                                    <option value="Flow Rate" {{ $equipment->calibration_parameter == 'Flow Rate' ? 'selected' : '' }}>Flow Rate</option>
                                                </select>
                                                {{-- <input type="text" name="calibration_parameter" value="{{ $equipment->calibration_parameter }}"> --}}
                                            </div>
                                        </div>
        
                                        <div class="col-lg-12">
                                            <div class="group-input">
                                                <label for="Zone">Unscheduled or Event Based Calibration?</label>
                                                <select name="event_based_calibration">
                                                    <option value="">--Select--</option>
                                                    <option value="Yes" {{ $equipment->event_based_calibration == 'Yes' ? 'selected' : '' }}>Yes</option>
                                                    <option value="No" {{ $equipment->event_based_calibration == 'No' ? 'selected' : '' }}>No</option>
                                                </select>
                                            </div>
                                        </div>
        
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Details">Reason for Unscheduled or Event Based Calibration</label>
                                                <div class="relative-container">
                                                    <textarea name="event_based_calibration_reason">{{ $equipment->event_based_calibration_reason }}</textarea>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>
                                        
        
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Date Due">Event Reference No.</label>
                                                <input type="number" name="event_refernce_no" value="{{ $equipment->event_refernce_no }}" min="0">
                                            </div>
                                        </div>
        
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Date Due">Calibration Checklist</label>
                                                <div class="relative-container">
                                                    <input type="text" name="calibration_checklist" value="{{ $equipment->calibration_checklist }}">
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>
                                        
        
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Date Due">Calibration Results</label>
                                                <div class="relative-container">
                                                    <input type="text" name="calibration_result" value="{{ $equipment->calibration_result }}">
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>
                                        
        
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Date Due">Calibration Certificate Number</label>
                                                <input type="number" name="calibration_certificate_result" value="{{ $equipment->calibration_certificate_result }}" min="0">
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Calibration Certificate Attachment">Calibration Certificate Attachment</label>
                                                <div><small class="text-primary">Please Attach all relevant or supporting
                                                        documents</small></div>
    
                                                <div class="file-attachment-field">
                                                    <div class="file-attachment-list" id="calibration_certificate">
                                                        @if ($equipment->calibration_certificate)
                                                            @foreach (json_decode($equipment->calibration_certificate) as $file)
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
                                                            {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }}
                                                            type="file" id="myfile" name="calibration_certificate[]"
                                                            oninput="addMultipleFiles(this, 'calibration_certificate')" multiple>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
        
               
        
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Date Due">Calibrated By</label>
                                                <div class="relative-container">
                                                    <input type="text" name="calibrated_by" value="{{ $equipment->calibrated_by }}">
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>
                                        
        
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Date Due">Calibration Due Alert</label>
                                                <div class="relative-container">
                                                    <input type="text" name="calibration_due_alert" value="{{ $equipment->calibration_due_alert }}">
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>
                                        
        
                                        <div class="col-lg-12">
                                            <div class="group-input">
                                                <label for="Date Due">Cost of Calibration</label>
                                                <div class="relative-container">
                                                    <input type="text" name="calibration_cost" value="{{ $equipment->calibration_cost }}">
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>
                                        
        
        
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Details">Calibration Comments/Observations</label>
                                                <div class="relative-container">
                                                    <textarea name="calibration_comments">{{ $equipment->calibration_comments }}</textarea>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
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
        
                            <!-- Water Consumption Detail ****************************-->
                            <div id="CCForm4" class="inner-block cctabcontent">
                                <div class="inner-block-content">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Zone">PM Schedule</label>
                                                <select name="pm_schedule">
                                                    <option value="">Select PM Schedule</option>
                                                    <option value="Weekly" {{ $equipment->pm_schedule == 'Weekly' ? 'selected' : '' }}>Weekly</option>
                                                    <option value="Fortnightly" {{ $equipment->pm_schedule == 'Fortnightly' ? 'selected' : '' }}>Fortnightly</option>
                                                    <option value="Monthly" {{ $equipment->pm_schedule == 'Monthly' ? 'selected' : '' }}>Monthly</option>                                                   
                                                    <option value="Quarterly" {{ $equipment->pm_schedule == 'Quarterly' ? 'selected' : '' }}>Quarterly</option>
                                                    <option value="Half Yearly" {{ $equipment->pm_schedule == 'Half Yearly' ? 'selected' : '' }}>Half Yearly</option>
                                                    <option value="Annually" {{ $equipment->pm_schedule == 'Annually' ? 'selected' : '' }}>Annually</option>                                                   
                                                    <option value="Once in Two Years" {{ $equipment->pm_schedule == 'Once in Two Years' ? 'selected' : '' }}>Once in Two Years</option>                                                   
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="col-lg-6 new-date-data-field">
                                            <div class="group-input input-date">
                                                <label for="Last Preventive Maintenance Date">Last Preventive Maintenance Date</label>
                                                <div class="calenderauditee">                                     
                                                    <input type="text"  id="last_pm_date"  readonly placeholder="DD-MMM-YYYY" value="{{ Helpers::getdateFormat($equipment->last_pm_date) }}"
                                                        {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }}/>
                                                    <input type="date" id="last_pm_date_checkdate" name="last_pm_date" max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }} value="{{ $equipment->last_pm_date }}" class="hide-input"
                                                    oninput="handleDateInput(this, 'last_pm_date');checkDate('last_pm_date_checkdate','next_pm_date_checkdate_checkdate')"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 new-date-data-field">
                                            <div class="group-input input-date">
                                                <label for="Next Preventive Maintenance Date">Next Preventive Maintenance Date</label>
                                                <div class="calenderauditee">                                     
                                                    <input type="text"  id="next_pm_date"  readonly placeholder="DD-MMM-YYYY" value="{{ Helpers::getdateFormat($equipment->next_pm_date) }}"
                                                        {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }}/>
                                                    <input type="date" id="next_pm_date_checkdate" name="next_pm_date" max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }} value="{{ $equipment->next_pm_date }}" class="hide-input"
                                                    oninput="handleDateInput(this, 'next_pm_date');checkDate('last_pm_date_checkdate','next_pm_date_checkdate_checkdate')"/>
                                                </div>
                                            </div>
                                        </div>
        
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Corrective Action">PM Task Description</label>
                                                <div class="relative-container">
                                                    <textarea name="pm_task_description">{{ $equipment->pm_task_description }}</textarea>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-lg-12">
                                            <div class="group-input">
                                                <label for="search">Unscheduled or Event Based Preventive Maintenance?</label>
                                                <select name="event_based_PM">
                                                    <option value="">--Select--</option>
                                                    <option value="Yes" {{ $equipment->event_based_PM == 'Yes' ? 'selected' : '' }}>Yes</option>
                                                    <option value="No" {{ $equipment->event_based_PM == 'No' ? 'selected' : '' }}>No</option>
                                                </select>
                                            </div>
                                        </div>
        
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Corrective Action">Reason for Unscheduled or Event Based Preventive Maintenance</label>
                                                <div class="relative-container">
                                                    <textarea name="eventbased_pm_reason">{{ $equipment->eventbased_pm_reason }}</textarea>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>
                                        
        
                                        <div class="col-lg-12">
                                            <div class="group-input">
                                                <label for="Date Due">Event Reference No.</label>
                                                <input type="number" name="PMevent_refernce_no" value="{{ $equipment->PMevent_refernce_no }}" min="0">
                                            </div>
                                        </div>  
                                        
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="PM Procedure Reference/Document">PM Procedure Reference/Document</label>
                                                <div><small class="text-primary">Please Attach all relevant or supporting
                                                        documents</small></div>
    
                                                <div class="file-attachment-field">
                                                    <div class="file-attachment-list" id="pm_procedure_document">
                                                        @if ($equipment->pm_procedure_document)
                                                            @foreach (json_decode($equipment->pm_procedure_document) as $file)
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
                                                            {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }}
                                                            type="file" id="myfile" name="pm_procedure_document[]"
                                                            oninput="addMultipleFiles(this, 'pm_procedure_document')" multiple>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
        
                                        <div class="col-lg-12">
                                            <div class="group-input">
                                                <label for="Date Due">Performed By</label>
                                                <div class="relative-container">
                                                    <input type="text" name="pm_performed_by" value="{{ $equipment->pm_performed_by }}">
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>
                                        
        
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Corrective Action">Maintenance Comments/Observations</label>
                                                <div class="relative-container">
                                                    <textarea name="maintenance_observation">{{ $equipment->maintenance_observation }}</textarea>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>
                                        
        
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Date Due">Parts Replaced During Maintenance</label>
                                                <div class="relative-container">
                                                    <input type="text" name="replaced_parts" value="{{ $equipment->replaced_parts }}">
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>
                                        
        
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Date Due">Maintenance Work Order Number</label>
                                                <input type="number" name="work_order_number" value="{{ $equipment->work_order_number }}" min="0">
                                            </div>
                                        </div>
        
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Date Due">PM Checklist</label>
                                                <div class="relative-container">
                                                    <input type="text" name="pm_checklist" value="{{ $equipment->pm_checklist }}">
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Date Due">Emergency Maintenance Flag</label>
                                                <div class="relative-container">
                                                    <input type="text" name="emergency_flag_maintenance" value="{{ $equipment->emergency_flag_maintenance }}">
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>
                                        
        
                                        <div class="col-lg-12">
                                            <div class="group-input">
                                                <label for="Date Due">Cost of Maintenance</label>
                                                <input type="number" name="cost_of_maintenance" value="{{ $equipment->cost_of_maintenance }}" min="0">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="button-block">
                                        <button type="submit" class="saveButton">Save</button>
                                        <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                        <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                        <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">Exit</a></button>
                                    </div>
                                </div>
                            </div>

                            <div id="CCForm5" class="inner-block cctabcontent">
                                <div class="inner-block-content">
                                    <div class="row">
                                        <div class="col-12 mb-4">
                                            <div class="group-input">
                                                <label for="hazop">
                                                    Spare Part Information
                                                    <button type="button" id="sparePartAdd">+</button>
                                                    <span class="text-primary" style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                                        (Launch Instruction)
                                                    </span>
                                                </label>
                                                <div class="table-responsive">
                                                    <table class="table table-bordered" id="sparePartInformation" style="width: 100%;">
                                                        <thead>
                                                            <tr style="text-align: center; vertical-align: middle; padding: 20px;">
                                                                <th rowspan="3">Row #</th>
                                                                <th colspan="17" rowspan="2">Spare Part Details</th>
                                                                <th colspan="11" rowspan="2">Inventory Information</th>
                                                                <th colspan="7" rowspan="2">Supplier Information</th>
                                                                <th rowspan="3">Action</th>
                                                            </tr>
                                                            <tr></tr>
                                                            <tr style="text-align: center; vertical-align: middle; padding: 20px;">
                                                                <th>Equipment/Instrument Name</th>
                                                                <th>Equipment/Instrument ID</th>
                                                                <th>Part ID/Code</th>
                                                                <th>Part Name/Description</th>
                                                                <th>Manufacturer</th>
                                                                <th>Model/Type Number</th>
                                                                <th>Serial Number</th>
                                                                <th>OEM (Original Equipment Manufacturer)</th>
                                                                <th>Part Category</th>
                                                                <th>Part Group</th>
                                                                <th>Part Dimensions</th>
                                                                <th>Material/Composition</th>
                                                                <th>Weight</th>
                                                                <th>Color</th>
                                                                <th>Part Lifecycle Stage</th>
                                                                <th>Part Status</th>
                                                                <th>Availability</th>
                                                                <th>Quantity on Hand</th>
                                                                <th>Quantity on Order</th>
                                                                <th>Reorder Point</th>
                                                                <th>Safety Stock</th>
                                                                <th>Minimum Order Quantity</th>
                                                                <th>Lead Time</th>
                                                                <th>Stock Location</th>
                                                                <th>Bin Number</th>
                                                                <th>Stock Keeping Unit (SKU)</th>
                                                                <th>Lot Number/Batch Number</th>
                                                                <th>Expiry Date</th>
                                                                <th>Supplier/Vendor Name</th>
                                                                <th>Supplier Contact Information</th>
                                                                <th>Supplier Lead Time</th>
                                                                <th>Supplier Price</th>
                                                                <th>Supplier Part Number</th>
                                                                <th>Supplier Warranty Information</th>
                                                                <th>Supplier Performance Metrics</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @if ($sparepart && count($sparepart->data))
                                                                @foreach ($sparepart->data as $index => $part)
                                                                    <tr>
                                                                        <td><input disabled type="text" name="spare_part[{{ $index }}][serial]" value="{{ $index + 1 }}"></td>
                                                                        <td><input type="text" name="spare_part[{{ $index }}][equipment_name]" value="{{ $part['equipment_name'] }}"></td>
                                                                        <td><input type="number" name="spare_part[{{ $index }}][equipment_id]" value="{{ $part['equipment_id'] }}"></td>
                                                                        <td><input type="number" name="spare_part[{{ $index }}][part_id]" value="{{ $part['part_id'] }}"></td>
                                                                        <td><input type="text" name="spare_part[{{ $index }}][part_name]" value="{{ $part['part_name'] }}"></td>
                                                                        <td><input type="text" name="spare_part[{{ $index }}][manufacturer]" value="{{ $part['manufacturer'] }}"></td>
                                                                        <td><input type="number" name="spare_part[{{ $index }}][model_type]" value="{{ $part['model_type'] }}"></td>
                                                                        <td><input type="number" name="spare_part[{{ $index }}][serial_number]" value="{{ $part['serial_number'] }}"></td>
                                                                        <td><input type="text" name="spare_part[{{ $index }}][oem]" value="{{ $part['oem'] }}"></td>
                                                                        <td><input type="text" name="spare_part[{{ $index }}][part_category]" value="{{ $part['part_category'] }}"></td>
                                                                        <td><input type="text" name="spare_part[{{ $index }}][part_group]" value="{{ $part['part_group'] }}"></td>
                                                                        <td><input type="text" name="spare_part[{{ $index }}][part_dimensions]" value="{{ $part['part_dimensions'] }}"></td>
                                                                        <td><input type="text" name="spare_part[{{ $index }}][material]" value="{{ $part['material'] }}"></td>
                                                                        <td><input type="number" name="spare_part[{{ $index }}][weight]" value="{{ $part['weight'] }}"></td>
                                                                        <td><input type="text" name="spare_part[{{ $index }}][color]" value="{{ $part['color'] }}"></td>
                                                                        <td><input type="text" name="spare_part[{{ $index }}][lifecycle_stage]" value="{{ $part['lifecycle_stage'] }}"></td>
                                                                        <td><input type="text" name="spare_part[{{ $index }}][status]" value="{{ $part['status'] }}"></td>
                                                                        <td><input type="text" name="spare_part[{{ $index }}][availability]" value="{{ $part['availability'] }}"></td>
                                                                        <td><input type="number" name="spare_part[{{ $index }}][quantity_on_hand]" value="{{ $part['quantity_on_hand'] }}"></td>
                                                                        <td><input type="number" name="spare_part[{{ $index }}][quantity_on_order]" value="{{ $part['quantity_on_order'] }}"></td>
                                                                        <td><input type="text" name="spare_part[{{ $index }}][reorder_point]" value="{{ $part['reorder_point'] }}"></td>
                                                                        <td><input type="text" name="spare_part[{{ $index }}][safety_stock]" value="{{ $part['safety_stock'] }}"></td>
                                                                        <td><input type="number" name="spare_part[{{ $index }}][minimum_order_quantity]" value="{{ $part['minimum_order_quantity'] }}"></td>
                                                                        <td><input type="number" name="spare_part[{{ $index }}][lead_time]" value="{{ $part['lead_time'] }}"></td>
                                                                        <td><input type="text" name="spare_part[{{ $index }}][stock_location]" value="{{ $part['stock_location'] }}"></td>
                                                                        <td><input type="number" name="spare_part[{{ $index }}][bin_number]" value="{{ $part['bin_number'] }}"></td>
                                                                        <td><input type="text" name="spare_part[{{ $index }}][sku]" value="{{ $part['sku'] }}"></td>
                                                                        <td><input type="number" name="spare_part[{{ $index }}][lot_number]" value="{{ $part['lot_number'] }}"></td>
                                                                        <td><input type="date" name="spare_part[{{ $index }}][expiry_date]" value="{{ $part['expiry_date'] }}"></td>
                                                                        <td><input type="text" name="spare_part[{{ $index }}][supplier_name]" value="{{ $part['supplier_name'] }}"></td>
                                                                        <td><input type="text" name="spare_part[{{ $index }}][supplier_contact]" value="{{ $part['supplier_contact'] }}"></td>
                                                                        <td><input type="number" name="spare_part[{{ $index }}][supplier_lead_time]" value="{{ $part['supplier_lead_time'] }}"></td>
                                                                        <td><input type="number" name="spare_part[{{ $index }}][supplier_price]" value="{{ $part['supplier_price'] }}"></td>
                                                                        <td><input type="number" name="spare_part[{{ $index }}][supplier_part_number]" value="{{ $part['supplier_part_number'] }}"></td>
                                                                        <td><input type="text" name="spare_part[{{ $index }}][supplier_warranty]" value="{{ $part['supplier_warranty'] }}"></td>
                                                                        <td><input type="text" name="spare_part[{{ $index }}][supplier_metrics]" value="{{ $part['supplier_metrics'] }}"></td>
                                                                        <td><button type="button" class="removeSpareRow">Remove</button></td>
                                                                    </tr>
                                                                @endforeach
                                                            @else
                                                                <tr>
                                                                    <td><input disabled type="text" name="spare_part[0][serial]" value="1"></td>
                                                                    <td><input type="text" name="spare_part[0][equipment_name]" value=""></td>
                                                                    <td><input type="number" name="spare_part[0][equipment_id]" value=""></td>
                                                                    <td><input type="number" name="spare_part[0][part_id]" value=""></td>
                                                                    <td><input type="text" name="spare_part[0][part_name]" value=""></td>
                                                                    <td><input type="text" name="spare_part[0][manufacturer]" value=""></td>
                                                                    <td><input type="number" name="spare_part[0][model_type]" value=""></td>
                                                                    <td><input type="number" name="spare_part[0][serial_number]" value=""></td>
                                                                    <td><input type="text" name="spare_part[0][oem]" value=""></td>
                                                                    <td><input type="text" name="spare_part[0][part_category]" value=""></td>
                                                                    <td><input type="text" name="spare_part[0][part_group]" value=""></td>
                                                                    <td><input type="text" name="spare_part[0][part_dimensions]" value=""></td>
                                                                    <td><input type="text" name="spare_part[0][material]" value=""></td>
                                                                    <td><input type="number" name="spare_part[0][weight]" value=""></td>
                                                                    <td><input type="text" name="spare_part[0][color]" value=""></td>
                                                                    <td><input type="text" name="spare_part[0][lifecycle_stage]" value=""></td>
                                                                    <td><input type="text" name="spare_part[0][status]" value=""></td>
                                                                    <td><input type="text" name="spare_part[0][availability]" value=""></td>
                                                                    <td><input type="number" name="spare_part[0][quantity_on_hand]" value=""></td>
                                                                    <td><input type="number" name="spare_part[0][quantity_on_order]" value=""></td>
                                                                    <td><input type="text" name="spare_part[0][reorder_point]" value=""></td>
                                                                    <td><input type="text" name="spare_part[0][safety_stock]" value=""></td>
                                                                    <td><input type="number" name="spare_part[0][minimum_order_quantity]" value=""></td>
                                                                    <td><input type="number" name="spare_part[0][lead_time]" value=""></td>
                                                                    <td><input type="text" name="spare_part[0][stock_location]" value=""></td>
                                                                    <td><input type="number" name="spare_part[0][bin_number]" value=""></td>
                                                                    <td><input type="text" name="spare_part[0][sku]" value=""></td>
                                                                    <td><input type="number" name="spare_part[0][lot_number]" value=""></td>
                                                                    <td><input type="date" name="spare_part[0][expiry_date]" value=""></td>
                                                                    <td><input type="text" name="spare_part[0][supplier_name]" value=""></td>
                                                                    <td><input type="text" name="spare_part[0][supplier_contact]" value=""></td>
                                                                    <td><input type="number" name="spare_part[0][supplier_lead_time]" value=""></td>
                                                                    <td><input type="number" name="spare_part[0][supplier_price]" value=""></td>
                                                                    <td><input type="number" name="spare_part[0][supplier_part_number]" value=""></td>
                                                                    <td><input type="text" name="spare_part[0][supplier_warranty]" value=""></td>
                                                                    <td><input type="text" name="spare_part[0][supplier_metrics]" value=""></td>
                                                                    <td><button type="button" class="removeSpareRow">Remove</button></td>
                                                                </tr>
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <script>
                                            document.addEventListener("DOMContentLoaded", function() {
                                                // Add a new spare part row
                                                const addSparePartBtn = document.getElementById("sparePartAdd");
                                                const sparePartTableBody = document.querySelector("#sparePartInformation tbody");
                                        
                                                // Function to add a new row
                                                function addNewSparePartRow() {
                                                    const rowCount = sparePartTableBody.rows.length;
                                                    const newRow = document.createElement("tr");
                                        
                                                    // Add new row content (you can adjust it as per your table structure)
                                                    newRow.innerHTML = `
                                                        <td><input disabled type="text" name="spare_part[${rowCount}][serial]" value="${rowCount + 1}"></td>
                                                        <td><input type="text" name="spare_part[${rowCount}][equipment_name]" value=""></td>
                                                        <td><input type="number" name="spare_part[${rowCount}][equipment_id]" value=""></td>
                                                        <td><input type="number" name="spare_part[${rowCount}][part_id]" value=""></td>
                                                        <td><input type="text" name="spare_part[${rowCount}][part_name]" value=""></td>
                                                        <td><input type="text" name="spare_part[${rowCount}][manufacturer]" value=""></td>
                                                        <td><input type="number" name="spare_part[${rowCount}][model_type]" value=""></td>
                                                        <td><input type="number" name="spare_part[${rowCount}][serial_number]" value=""></td>
                                                        <td><input type="text" name="spare_part[${rowCount}][oem]" value=""></td>
                                                        <td><input type="text" name="spare_part[${rowCount}][part_category]" value=""></td>
                                                        <td><input type="text" name="spare_part[${rowCount}][part_group]" value=""></td>
                                                        <td><input type="text" name="spare_part[${rowCount}][part_dimensions]" value=""></td>
                                                        <td><input type="text" name="spare_part[${rowCount}][material]" value=""></td>
                                                        <td><input type="number" name="spare_part[${rowCount}][weight]" value=""></td>
                                                        <td><input type="text" name="spare_part[${rowCount}][color]" value=""></td>
                                                        <td><input type="text" name="spare_part[${rowCount}][lifecycle_stage]" value=""></td>
                                                        <td><input type="text" name="spare_part[${rowCount}][status]" value=""></td>
                                                        <td><input type="text" name="spare_part[${rowCount}][availability]" value=""></td>
                                                        <td><input type="number" name="spare_part[${rowCount}][quantity_on_hand]" value=""></td>
                                                        <td><input type="number" name="spare_part[${rowCount}][quantity_on_order]" value=""></td>
                                                        <td><input type="text" name="spare_part[${rowCount}][reorder_point]" value=""></td>
                                                        <td><input type="text" name="spare_part[${rowCount}][safety_stock]" value=""></td>
                                                        <td><input type="number" name="spare_part[${rowCount}][minimum_order_quantity]" value=""></td>
                                                        <td><input type="number" name="spare_part[${rowCount}][lead_time]" value=""></td>
                                                        <td><input type="text" name="spare_part[${rowCount}][stock_location]" value=""></td>
                                                        <td><input type="number" name="spare_part[${rowCount}][bin_number]" value=""></td>
                                                        <td><input type="text" name="spare_part[${rowCount}][sku]" value=""></td>
                                                        <td><input type="number" name="spare_part[${rowCount}][lot_number]" value=""></td>
                                                        <td><input type="date" name="spare_part[${rowCount}][expiry_date]" value=""></td>
                                                        <td><input type="text" name="spare_part[${rowCount}][supplier_name]" value=""></td>
                                                        <td><input type="text" name="spare_part[${rowCount}][supplier_contact]" value=""></td>
                                                        <td><input type="number" name="spare_part[${rowCount}][supplier_lead_time]" value=""></td>
                                                        <td><input type="number" name="spare_part[${rowCount}][supplier_price]" value=""></td>
                                                        <td><input type="number" name="spare_part[${rowCount}][supplier_part_number]" value=""></td>
                                                        <td><input type="text" name="spare_part[${rowCount}][supplier_warranty]" value=""></td>
                                                        <td><input type="text" name="spare_part[${rowCount}][supplier_metrics]" value=""></td>
                                                        <td><button type="button" class="removeSpareRow">Remove</button></td>
                                                    `;
                                                    sparePartTableBody.appendChild(newRow);
                                        
                                                    // Add event listener to remove the row
                                                    newRow.querySelector('.removeSpareRow').addEventListener('click', function() {
                                                        newRow.remove();
                                                    });
                                                }
                                        
                                                // Add event listener for the 'Add' button
                                                addSparePartBtn.addEventListener("click", addNewSparePartRow);
                                        
                                                // Remove a row
                                                sparePartTableBody.addEventListener('click', function(e) {
                                                    if (e.target.classList.contains('removeSpareRow')) {
                                                        const row = e.target.closest('tr');
                                                        row.remove();
                                                    }
                                                });
                                            });
                                        </script>
                                    </div>
                                    <div class="button-block">
                                        <button type="submit" class="saveButton">Save</button>
                                        <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                        <button type="button"> <a class="text-white"
                                                href="{{ url('rcms/qms-dashboard') }}">Exit</a> </button>
                                    </div>
                                </div>
                            </div>
        
                            <!-- Emission to Water ****************************-->
                            <div id="CCForm6" class="inner-block cctabcontent">
                                <div class="inner-block-content">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="audit-agenda-grid">
                                                    Training Details
                                                    <button type="button" id="addTrainingPlan">+</button>
                                                </label>
            
                                                <table class="table table-bordered" id="addTrainingPlanTable">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 5%;">Row#</th>
                                                            <th style="width: 15%;">Training Topic</th>
                                                            <th style="width: 10%;">SOP Title</th>
                                                            <th>SOP No.</th>
                                                            <th>SOP Type</th>   
                                                            <th style="width: 10%;">Training Type</th>                                                 
                                                            <th>Trainee</th>                                                 
                                                            <th>Start Date</th>                                                 
                                                            <th>End Date</th>                                                 
                                                            <th>Trainer</th>
                                                            <th>Training Attempt</th>
                                                            <th>Attachment</th>
                                                            <th>Minimum Sop View Time(in min)</th>
                                                            <th>Maximum Sop View Time(in min)</th>
                                                            <th style="width: 5%;">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($trainingPlanData as $index => $item)                                                  
                                                            <tr>
                                                                <td>
                                                                    <input disabled type="text" name="trainingPlanData[{{ $index }}][serial]" value="{{ (int)$index + 1 }}">
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="trainingPlanData[{{ $index }}][trainingTopic]" value="{{ $item['trainingTopic'] }}" {{ $data->stage == 4 ? '' : 'readonly' }}>
                                                                </td>
                                                                <td>
                                                                    <select name="trainingPlanData[{{ $index }}][documentNumber]" id="documentPlan_{{ $index }}" class="training-select" {{ $data->stage == 4 ? '' : 'readonly' }}>
                                                                        <option value="">-- Select --</option>
                                                                        @foreach ($documents as $document)
                                                                            <option value="{{ $document->id }}" {{ $item['documentNumber'] == $document->id ? 'selected' : '' }}> {{ $document->document_name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </td>                                                        
                                                                <td>
                                                                    <input type="text" class="doc_number" name="trainingPlanData[{{ $index }}][documentName]" readonly value="{{ $item['documentName'] ?? '' }}">
                                                                </td>  
                                                                <td>
                                                                    <input type="text" class="sop_type" name="trainingPlanData[{{ $index }}][sopType]" value="{{ $item['sopType'] }}" readonly>
                                                                </td>                                                     
                                                                <td>
                                                                    <select name="trainingPlanData[{{ $index }}][trainingType]" {{ $data->stage == 4 ? '' : 'readonly' }}>
                                                                        <option value="">-- Select --</option>
                                                                        <option value="Read & Understand" @if(isset($item['trainingType']) && $item['trainingType'] == 'Read & Understand') selected @endif>Read & Understand</option>
                                                                        <option value="Read & Understand with Questions" @if(isset($item['trainingType']) && $item['trainingType'] == 'Read & Understand with Questions') selected @endif>Read & Understand with Questions</option>
                                                                        <option value="Classroom Training" @if(isset($item['trainingType']) && $item['trainingType'] == 'Classroom Training') selected @endif>Classroom Training</option>
                                                                        {{-- <option value="On Job Training" @if(isset($item['trainingType']) && $item['trainingType'] == 'On Job Training') selected @endif>On Job Training</option>
                                                                        <option value="External Training" @if(isset($item['trainingType']) && $item['trainingType'] == 'External Training') selected @endif>External Training</option>
                                                                        <option value="Refresher Training" @if(isset($item['trainingType']) && $item['trainingType'] == 'Refresher Training') selected @endif>Refresher Training</option>
                                                                        <option value="Retraining" @if(isset($item['trainingType']) && $item['trainingType'] == 'Retraining') selected @endif>Retraining</option> --}}
                                                                    </select>
                                                                </td>   
                                                                <td>
                                                                    <select name="trainingPlanData[{{ $index }}][trainees]" readonly>
                                                                        <option value="">-- Select --</option>
                                                                        @foreach ($users as $employee)
                                                                            <option value="{{ $employee->id }}" {{ $item['trainees'] == $employee->id ? 'selected' : '' }}>{{ $employee->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <input type="date" name="trainingPlanData[{{ $index }}][startDate]" value="{{ $item['startDate'] ?? '' }}" {{ $data->stage == 4 ? '' : 'readonly' }}>
                                                                </td>  
                                                                <td>
                                                                    <input type="date" name="trainingPlanData[{{ $index }}][endDate]" value="{{ $item['endDate'] }}" {{ $data->stage == 4 ? '' : 'readonly' }}>
                                                                </td> 
                                                                <td>
                                                                    <select name="trainingPlanData[{{ $index }}][trainer]" {{ $data->stage == 4 ? '' : 'readonly' }}>
                                                                        <option value="">-- Select --</option>
                                                                        @foreach ($users as $user)
                                                                            <option value="{{ $user->id }}" {{ $item['trainer'] == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </td> 
                                                                <td>
                                                                    <input type="number" {{ $data->stage == 4 ? '' : 'readonly' }} name="trainingPlanData[{{ $index }}][trainingAttempt]" min="0" value="{{ $item['trainingAttempt'] }}">
                                                                </td>
                                                                <td>
                                                                    <input type="file" name="trainingPlanData[{{ $index }}][file]" class="file-picker" {{ $data->stage == 4 ? '' : 'readonly' }}> <br>
                                                                    @if(!empty($item['file_path']))
                                                                        <a href="{{ asset($item['file_path']) }}" target="_blank">{{ basename($item['file_path']) }}</a>
                                                                        <input type="hidden" name="trainingPlanData[{{ $index }}][file_path]" value="{{ $item['file_path'] }}">
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    <input type="number" name="trainingPlanData[{{ $index }}][total_minimum_time]" value="{{ $item['total_minimum_time'] }}" min="0" {{ $data->stage == 4 ? '' : 'readonly' }}>
                                                                </td>
                                                                <td>
                                                                    <input type="number" name="trainingPlanData[{{ $index }}][per_screen_run_time]" value="{{ $item['per_screen_run_time'] }}" min="0" {{ $data->stage == 4 ? '' : 'readonly' }}>
                                                                </td>
                                                                <td><button type="button" class="removeRowBtn">Remove</button></td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
            
                                        <script>
                                            $(document).ready(function() {
                                                let trainingPlanIndex = {{ $trainingPlanData && is_array($trainingPlanData) ? count($trainingPlanData) : 0 }};
                                                console.log(trainingPlanIndex, "ddaskdhashds");
                                                
            
                                                function updateTrainingPlanIndex() {
                                                    trainingPlanIndex = $('#addTrainingPlanTable tbody tr').length;
                                                }
            
                                                updateTrainingPlanIndex();
            
                                                $('#addTrainingPlan').click(function(e) {
                                                    function generateTableRow(index) {
                                                        var documents = @json($documents);
                                                        var documentOptionHtml = '<option value="">-- Select --</option>';
                                                        documents.forEach(document => {
                                                            documentOptionHtml += `<option value="${document.id}">${document.document_name}</option>`;
                                                        });
            
                                                        var users = @json($users);
                                                        var employeeOptionHtml = '<option value="">-- Select --</option>';
                                                        users.forEach(employee => {
                                                            employeeOptionHtml += `<option value="${employee.id}">${employee.name}</option>`;
                                                        });
            
                                                        var users = @json($users);
                                                        var userOptionHtml = '<option value="">-- Select --</option>';
                                                        users.forEach(user => {
                                                            userOptionHtml += `<option value="${user.id}">${user.name}</option>`;
                                                        });
            
                                                        var html = `
                                                            <tr>
                                                                <td><input disabled type="text" name="trainingPlanData[${trainingPlanIndex}][serial]" value="${trainingPlanIndex + 1}"></td>
                                                                <td><input type="text" name="trainingPlanData[${trainingPlanIndex}][trainingTopic]"></td>
                                                                <td><select id="documentPlan_${trainingPlanIndex}" class="training-select" name="trainingPlanData[${trainingPlanIndex}][documentNumber]">${documentOptionHtml}</select></td>
                                                                <td><input type="text" class="doc_number" name="trainingPlanData[${trainingPlanIndex}][documentName]" readonly></td>
                                                                <td><input type="text" class="sop_type" name="trainingPlanData[${trainingPlanIndex}][sopType]" readonly></td>
                                                                <td><select name="trainingPlanData[${trainingPlanIndex}][trainingType]">
                                                                    <option value="">-- Select --</option>
                                                                    <option value="Read & Understand">Read & Understand</option>
                                                                    <option value="Read & Understand with Questions">Read & Understand with Questions</option>
                                                                    <option value="Classroom Training">Classroom Training</option>
                                                                    
                                                                </select></td>
                                                                <td><select name="trainingPlanData[${trainingPlanIndex}][trainees]">${employeeOptionHtml}</select></td>
                                                                <td><input type="date" name="trainingPlanData[${trainingPlanIndex}][startDate]"></td>
                                                                <td><input type="date" name="trainingPlanData[${trainingPlanIndex}][endDate]"></td>
                                                                <td><select name="trainingPlanData[${trainingPlanIndex}][trainer]">${userOptionHtml}</select></td>
                                                                <td><input type="number" name="trainingPlanData[${trainingPlanIndex}][trainingAttempt]" value="3" readonly></td>
                                                                <td><input type="file" name="trainingPlanData[${trainingPlanIndex}][file]" class="file-picker"></td>
                                                                <td><input type="number" name="trainingPlanData[${trainingPlanIndex}][total_minimum_time]"></td>
                                                                <td><input type="number" name="trainingPlanData[${trainingPlanIndex}][per_screen_run_time]"></td>
                                                                <td><button type="button" class="removeRowBtn">Remove</button></td>
                                                            </tr>`;
            
                                                        return html;
                                                    }
            
                                                    updateTrainingPlanIndex();
            
                                                    var tableBody = $('#addTrainingPlanTable tbody');
                                                    var newRow = generateTableRow(trainingPlanIndex);
                                                    tableBody.append(newRow);
            
                                                    trainingPlanIndex++;
            
                                                    tableBody.find('.training-select').last().change(function() {
                                                        var row = $(this).closest('tr');
                                                        fetchAndDisplayTitles($(this), row);
                                                    });
                                                });
            
                                                function fetchAndDisplayTitles(selectElement, row) {
                                                    var documentIds = selectElement.val();
                                                    var titles = [];
            
                                                    if (documentIds) {
                                                        if (typeof documentIds === 'string') {
                                                            documentIds = [documentIds];
                                                        }
            
                                                        var fetchTitlePromises = documentIds.map(function(documentId) {
                                                            return $.ajax({
                                                                url: '/rcms/document-detail/' + documentId,
                                                                method: 'GET'
                                                            });
                                                        });
            
                                                        $.when.apply($, fetchTitlePromises).done(function() {
                                                            var docNumbers = [];
                                                            var sopTypes = [];
                                                            
                                                            if (Array.isArray(arguments[0])) {
                                                                for (var i = 0; i < arguments.length; i++) {
                                                                    var response = arguments[i][0];
                                                                    docNumbers.push(response.doc_number);
                                                                    sopTypes.push(response.sop_type);
                                                                }
                                                            } else {
                                                                docNumbers.push(arguments[0]['doc_number']);
                                                                sopTypes.push(arguments[0]['sop_type']);
                                                            }
                                                            row.find('input.doc_number').val(docNumbers.join(', '));
                                                            row.find('input.sop_type').val(sopTypes.join(', '));
                                                        }).fail(function() {
                                                            alert('Failed to fetch Document Detail details.');
                                                        });
                                                    } else {
                                                        row.find('input.doc_number').val('');
                                                        row.find('input.sop_type').val('');
                                                    }
                                                }
            
                                                $(document).on('click', '.removeRowBtn', function() {
                                                    $(this).closest('tr').remove();
                                                    updateTrainingPlanIndex();
                                                });
                                            });
                                        </script>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="search">Training Required?</label>
                                                <select name="training_required">
                                                    <option value="">--Select--</option>
                                                    <option value="Yes" {{ $equipment->training_required == 'Yes' ? 'selected' : '' }}>Yes</option>
                                                    <option value="No" {{ $equipment->training_required == 'No' ? 'selected' : '' }}>No</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Initiator">Training Type</label>
                                                <div class="relative-container">
                                                    <input type="text" name="training_type" value="{{ $equipment->training_type }}">
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>
                                        
        
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Corrective Action">Training Description</label>
                                                <div class="relative-container">
                                                    <textarea name="trining_description">{{ $equipment->trining_description }}</textarea>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>
                                              
                                        

                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Training Attachment">Training Attachment</label>
                                                <div><small class="text-primary">Please Attach all relevant or supporting
                                                        documents</small></div>
    
                                                <div class="file-attachment-field">
                                                    <div class="file-attachment-list" id="training_attachment">
                                                        @if ($equipment->training_attachment)
                                                            @foreach (json_decode($equipment->training_attachment) as $file)
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
                                                            {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }}
                                                            type="file" id="myfile" name="training_attachment[]"
                                                            oninput="addMultipleFiles(this, 'training_attachment')" multiple>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
        
                                    </div>
                                    <div class="button-block">
                                        <button type="submit" class="saveButton">Save</button>
                                        <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                        <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                        <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">Exit</a></button>
                                    </div>
                                </div>
                            </div>
        
                            <!-- Emission to Air ****************************-->
                            <div id="CCForm7" class="inner-block cctabcontent">
                                <div class="inner-block-content">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Corrective Action">Supervisor Review Comments</label>
                                                <div class="relative-container">
                                                    <textarea name="supervisor_comment">{{ $equipment->supervisor_comment }}</textarea>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    

                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Supervisor Documents">Supervisor Documents</label>
                                                <div><small class="text-primary">Please Attach all relevant or supporting
                                                        documents</small></div>
    
                                                <div class="file-attachment-field">
                                                    <div class="file-attachment-list" id="Supervisor_document">
                                                        @if ($equipment->Supervisor_document)
                                                            @foreach (json_decode($equipment->Supervisor_document) as $file)
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
                                                            {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }}
                                                            type="file" id="myfile" name="Supervisor_document[]"
                                                            oninput="addMultipleFiles(this, 'Supervisor_document')" multiple>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
        
                                        
        
                                    </div>
                                    <div class="button-block">
                                        <button type="submit" class="saveButton">Save</button>
                                        <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                        <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                        <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">Exit</a></button>
                                    </div>
                                </div>
                            </div>
        
                            <!-- Chemical Waste ****************************-->
                            <div id="CCForm8" class="inner-block cctabcontent">
                                <div class="inner-block-content">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Corrective Action">QA Review Comments</label>
                                                <div class="relative-container">
                                                    <textarea name="QA_comment">{{ $equipment->QA_comment }}</textarea>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>
                                        

                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="QA Documents">QA Documents</label>
                                                <div><small class="text-primary">Please Attach all relevant or supporting
                                                        documents</small></div>
    
                                                <div class="file-attachment-field">
                                                    <div class="file-attachment-list" id="QA_document">
                                                        @if ($equipment->QA_document)
                                                            @foreach (json_decode($equipment->QA_document) as $file)
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
                                                            {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }}
                                                            type="file" id="myfile" name="QA_document[]"
                                                            oninput="addMultipleFiles(this, 'QA_document')" multiple>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
        
                                        
                                    </div>
                                    <div class="button-block">
                                        <button type="submit" class="saveButton">Save</button>
                                        <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                        <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                        <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">Exit</a></button>
                                    </div>
                                </div>
                            </div>
        
                            <div id="CCForm9" class="inner-block cctabcontent">
                                <div class="inner-block-content">
                                    <div class="row">
        
                                        <div class="col-lg-12">
                                            <div class="group-input">
                                                <label for="Equipment Lifecycle Stage">Equipment/Instrument Lifecycle Stage</label>
                                                <select name="Equipment_Lifecycle_Stage">
                                                    <option value="">Select a value</option>
                                                    <option value="In-use" {{ $equipment->Equipment_Lifecycle_Stage == 'In-use' ? 'selected' : '' }}>In-use</option>
                                                    <option value="Out-of-service" {{ $equipment->Equipment_Lifecycle_Stage == 'Out-of-service' ? 'selected' : '' }}>Out-of-service</option>
                                                    <option value="Retired" {{ $equipment->Equipment_Lifecycle_Stage == 'Retired' ? 'selected' : '' }}>Retired</option>
                                                
                                                </select>
                                            </div>
                                        </div>
        
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Expected Useful Life">Expected Useful Life</label>
                                                <div class="relative-container">
                                                    <textarea name="Expected_Useful_Life">{{ $equipment->Expected_Useful_Life }}</textarea>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-lg-12 new-date-data-field">
                                            <div class="group-input input-date">
                                                <label for="End-of-life Date">End-of-life Date</label>
                                                <div class="calenderauditee">
                                                    <input type="text" id="End_of_life_Date" readonly
                                                        placeholder="DD-MMM-YYYY" />
                                                    <input type="date" id="End_of_life_Date_checkdate" name="End_of_life_Date" max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"  class="hide-input"
                                                        oninput="handleDateInput(this, 'End_of_life_Date');checkDate('End_of_life_Date_checkdate','End_of_life_Date1_checkdate')" />
                                                </div>
                                            </div>
                                        </div>
        
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Decommissioning and Disposal Records">Decommissioning and Disposal Records</label>
                                                <div class="relative-container">
                                                    <textarea name="Decommissioning_and_Disposal_Records">{{ $equipment->Decommissioning_and_Disposal_Records }}</textarea>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>
                                        
        
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Replacement History">Replacement History</label>
                                                <div class="relative-container">
                                                    <textarea name="Replacement_History">{{ $equipment->Replacement_History }}</textarea>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>
                                        
        
        
                                        
                                    </div>
                                    <div class="button-block">
                                        <button type="submit" class="saveButton">Save</button>
                                        <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                        <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                        <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">Exit</a></button>
                                    </div>
                                </div>
                            </div>
        
                            <div id="CCForm10" class="inner-block cctabcontent">
                                <div class="inner-block-content">
                                    <div class="sub-head">Activity Log</div>

                                    <div class="d-flex align-item-end justify-content-end">
                                           

                                            <button style="margin-bottom:20px;" class="button_theme1"> <a
                                                    class="text-white"
                                                    href="{{ url('rcms/equipmemntactivityreport', $equipment->id) }}"> Print </a>
                                            </button>
                                    </div>

                                    <div class="printable-content">
                                        <div class="row">
                                          
                                        </div>

                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <strong>Submit By:</strong><br>
                                                            {{ $equipment->submit_by }}
                                                        </td>
                                                        <td>
                                                            <strong>Submit On:</strong><br>
                                                            {{-- {{ $data->submit_on}} --}}
                                                            @php
                                                            $utcTime = $data->submit_on ?? null;
                    
                                                            if ($utcTime) {
                                                                try {
                                                                    $istTime = \Carbon\Carbon::parse($utcTime, 'UTC')
                                                                        ->setTimezone('Asia/Kolkata')
                                                                        ->format('d-M-Y H:i:s T');
                                                                    echo $istTime;
                                                                } catch (\Exception $e) {
                                                                    echo 'Invalid Date Format';
                                                                }
                                                            } else {
                                                                echo 'No Time Available';
                                                            }
                                                        @endphp
                                                        </td>
                                                    </tr>

                                                    <!-- Row for Submit Comments -->
                                                    <tr>
                                                        <td colspan="2">
                                                            <strong>Submit Comments:</strong><br>
                                                            {{ $equipment->submit_comment ?? 'Not Applicable' }}
                                                        </td>
                                                    </tr>

                                                    <!-- Add more rows for other data -->
                                                    <tr>
                                                        <td>
                                                            <strong>Cancel By:</strong><br>
                                                            {{ $equipment->cancel_By }}
                                                        </td>
                                                        <td>
                                                            <strong>Cancel On:</strong><br>
                                                            {{-- {{$equipment->cancel_On}} --}}
                                                            @php
                                                            $utcTime = $data->cancel_On ?? null;

                                                            if ($utcTime) {
                                                                try {
                                                                    $istTime = \Carbon\Carbon::parse($utcTime, 'UTC')
                                                                        ->setTimezone('Asia/Kolkata')
                                                                        ->format('d-M-Y H:i:s T');
                                                                    echo $istTime;
                                                                } catch (\Exception $e) {
                                                                    echo 'Invalid Date Format';
                                                                }
                                                            } else {
                                                                echo 'No Time Available';
                                                            }
                                                        @endphp
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td colspan="2">
                                                            <strong>Cancel Comment:</strong><br>
                                                            {{ $equipment->cancel_comment ?? 'Not Applicable' }}
                                                        </td>
                                                    </tr>


                                                     <!-- Add more rows for other data -->
                                                     <tr>
                                                        <td>
                                                            <strong>Supervisor Approval By:</strong><br>
                                                            {{ $equipment->Supervisor_Approval_by }}
                                                        </td>
                                                        <td>
                                                            <strong>Supervisor Approval On:</strong><br>
                                                            @php
                                                            $utcTime = $data->Supervisor_Approval_on ?? null;

                                                            if ($utcTime) {
                                                                try {
                                                                    $istTime = \Carbon\Carbon::parse($utcTime, 'UTC')
                                                                        ->setTimezone('Asia/Kolkata')
                                                                        ->format('d-M-Y H:i:s T');
                                                                    echo $istTime;
                                                                } catch (\Exception $e) {
                                                                    echo 'Invalid Date Format';
                                                                }
                                                            } else {
                                                                echo 'No Time Available';
                                                            }
                                                        @endphp
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td colspan="2">
                                                            <strong>Supervisor Approval Comment:</strong><br>
                                                            {{ $equipment->Supervisor_Approval_comment ?? 'Not Applicable' }}
                                                        </td>
                                                    </tr>


                                                     <!-- Add more rows for other data -->
                                                     <tr>
                                                        <td>
                                                            <strong>More Information Required By:</strong><br>
                                                            {{ $equipment->More_Info_by }}
                                                        </td>
                                                        <td>
                                                            <strong>More Information Required On:</strong><br>
                                                            @php
                                                            $utcTime = $data->More_Info_on ?? null;

                                                            if ($utcTime) {
                                                                try {
                                                                    $istTime = \Carbon\Carbon::parse($utcTime, 'UTC')
                                                                        ->setTimezone('Asia/Kolkata')
                                                                        ->format('d-M-Y H:i:s T');
                                                                    echo $istTime;
                                                                } catch (\Exception $e) {
                                                                    echo 'Invalid Date Format';
                                                                }
                                                            } else {
                                                                echo 'No Time Available';
                                                            }
                                                        @endphp
                                                    </tr>

                                                    <tr>
                                                        <td colspan="2">
                                                            <strong>More Information Required Comment:</strong><br>
                                                            {{ $equipment->More_Info_comment ?? 'Not Applicable' }}
                                                        </td>
                                                    </tr>


                                                      <!-- Add more rows for other data -->
                                                      <tr>
                                                        <td>
                                                            <strong>Complete Qualification By:</strong><br>
                                                            {{ $equipment->Complete_Qualification_by }}
                                                        </td>
                                                        <td>
                                                            <strong>Complete Qualification On:</strong><br>
                                                            @php
                                                            $utcTime = $data->Complete_Qualification_on ?? null;

                                                            if ($utcTime) {
                                                                try {
                                                                    $istTime = \Carbon\Carbon::parse($utcTime, 'UTC')
                                                                        ->setTimezone('Asia/Kolkata')
                                                                        ->format('d-M-Y H:i:s T');
                                                                    echo $istTime;
                                                                } catch (\Exception $e) {
                                                                    echo 'Invalid Date Format';
                                                                }
                                                            } else {
                                                                echo 'No Time Available';
                                                            }
                                                        @endphp
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td colspan="2">
                                                            <strong>Complete Qualification Comment:</strong><br>
                                                            {{ $equipment->Complete_Qualification_comment ?? 'Not Applicable' }}
                                                        </td>
                                                    </tr>

                                                     <!-- Add more rows for other data -->
                                                     <tr>
                                                        <td>
                                                            <strong>Complete Training By:</strong><br>
                                                            {{ $equipment->Complete_Training_by }}
                                                        </td>
                                                        <td>
                                                            <strong>Complete Training On:</strong><br>
                                                            @php
                                                            $utcTime = $data->Complete_Training_on ?? null;

                                                            if ($utcTime) {
                                                                try {
                                                                    $istTime = \Carbon\Carbon::parse($utcTime, 'UTC')
                                                                        ->setTimezone('Asia/Kolkata')
                                                                        ->format('d-M-Y H:i:s T');
                                                                    echo $istTime;
                                                                } catch (\Exception $e) {
                                                                    echo 'Invalid Date Format';
                                                                }
                                                            } else {
                                                                echo 'No Time Available';
                                                            }
                                                        @endphp
                                                            
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td colspan="2">
                                                            <strong>Complete Training Comment:</strong><br>
                                                            {{ $equipment->Complete_Training_comment ?? 'Not Applicable' }}
                                                        </td>
                                                    </tr>

                                                      <!-- Add more rows for other data -->
                                                      <tr>
                                                        <td>
                                                            <strong>Request More Information By:</strong><br>
                                                            {{ $equipment->More_Info_by_sec_by }}
                                                        </td>
                                                        <td>
                                                            <strong>Request More Information On:</strong><br>
                                                            @php
                                                            $utcTime = $data->More_Info_by_sec_on ?? null;

                                                            if ($utcTime) {
                                                                try {
                                                                    $istTime = \Carbon\Carbon::parse($utcTime, 'UTC')
                                                                        ->setTimezone('Asia/Kolkata')
                                                                        ->format('d-M-Y H:i:s T');
                                                                    echo $istTime;
                                                                } catch (\Exception $e) {
                                                                    echo 'Invalid Date Format';
                                                                }
                                                            } else {
                                                                echo 'No Time Available';
                                                            }
                                                        @endphp
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td colspan="2">
                                                            <strong>Request More Information Comment:</strong><br>
                                                            {{ $equipment->More_Info_by_sec_comment ?? 'Not Applicable' }}
                                                        </td>
                                                    </tr>


                                                     <!-- Add more rows for other data -->
                                                     <tr>
                                                        <td>
                                                            <strong>QA Approval By:</strong><br>
                                                            {{ $equipment->Take_Out_of_Service_by }}
                                                        </td>
                                                        <td>
                                                            <strong>QA Approval On:</strong><br>
                                                            @php
                                                            $utcTime = $data->Take_Out_of_Service_on ?? null;

                                                            if ($utcTime) {
                                                                try {
                                                                    $istTime = \Carbon\Carbon::parse($utcTime, 'UTC')
                                                                        ->setTimezone('Asia/Kolkata')
                                                                        ->format('d-M-Y H:i:s T');
                                                                    echo $istTime;
                                                                } catch (\Exception $e) {
                                                                    echo 'Invalid Date Format';
                                                                }
                                                            } else {
                                                                echo 'No Time Available';
                                                            }
                                                        @endphp
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td colspan="2">
                                                            <strong>QA Approval Comment:</strong><br>
                                                            {{ $equipment->Take_Out_of_Service_comment ?? 'Not Applicable' }}
                                                        </td>
                                                    </tr>

                                                     <!-- Add more rows for other data -->
                                                     <tr>
                                                        <td>
                                                            <strong>Re-Qualification By:</strong><br>
                                                            {{ $equipment->Re_Qualification_by }}
                                                        </td>
                                                        <td>
                                                            <strong>Re-Qualification On:</strong><br>
                                                            @php
                                                            $utcTime = $data->Re_Qualification_on ?? null;

                                                            if ($utcTime) {
                                                                try {
                                                                    $istTime = \Carbon\Carbon::parse($utcTime, 'UTC')
                                                                        ->setTimezone('Asia/Kolkata')
                                                                        ->format('d-M-Y H:i:s T');
                                                                    echo $istTime;
                                                                } catch (\Exception $e) {
                                                                    echo 'Invalid Date Format';
                                                                }
                                                            } else {
                                                                echo 'No Time Available';
                                                            }
                                                        @endphp
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td colspan="2">
                                                            <strong>Re-Qualification Comment:</strong><br>
                                                            {{ $equipment->Re_Qualification_comment ?? 'Not Applicable' }}
                                                        </td>
                                                    </tr>

                                                      <!-- Add more rows for other data -->
                                                      <tr>
                                                        <td>
                                                            <strong>Take Out of Service By:</strong><br>
                                                            {{ $equipment->Forward_to_Storage_by }}
                                                        </td>
                                                        <td>
                                                            <strong>Take Out of Service On:</strong><br>
                                                            @php
                                                            $utcTime = $data->Forward_to_Storage_on ?? null;

                                                            if ($utcTime) {
                                                                try {
                                                                    $istTime = \Carbon\Carbon::parse($utcTime, 'UTC')
                                                                        ->setTimezone('Asia/Kolkata')
                                                                        ->format('d-M-Y H:i:s T');
                                                                    echo $istTime;
                                                                } catch (\Exception $e) {
                                                                    echo 'Invalid Date Format';
                                                                }
                                                            } else {
                                                                echo 'No Time Available';
                                                            }
                                                        @endphp
                                                           
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td colspan="2">
                                                            <strong>Take Out of Service Comment:</strong><br>
                                                            {{ $equipment->Forward_to_Storage_comment ?? 'Not Applicable' }}
                                                        </td>
                                                    </tr>


                                                     <!-- Add more rows for other data -->
                                                     <tr>
                                                        <td>
                                                            <strong>Forward to Storage By:</strong><br>
                                                            {{ $equipment->Forward_to_Storage_by }}
                                                        </td>
                                                        <td>
                                                            <strong>Forward to Storage On:</strong><br>
                                                            @php
                                                            $utcTime = $data->Forward_to_Storage_on ?? null;

                                                            if ($utcTime) {
                                                                try {
                                                                    $istTime = \Carbon\Carbon::parse($utcTime, 'UTC')
                                                                        ->setTimezone('Asia/Kolkata')
                                                                        ->format('d-M-Y H:i:s T');
                                                                    echo $istTime;
                                                                } catch (\Exception $e) {
                                                                    echo 'Invalid Date Format';
                                                                }
                                                            } else {
                                                                echo 'No Time Available';
                                                            }
                                                        @endphp
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td colspan="2">
                                                            <strong>Forward to Storage Comment:</strong><br>
                                                            {{ $equipment->Forward_to_Storage_comment ?? 'Not Applicable' }}
                                                        </td>
                                                    </tr>


                                                      <!-- Add more rows for other data -->
                                                      <tr>
                                                        <td>
                                                            <strong>Re-Activate By:</strong><br>
                                                            {{ $equipment->Re_Active_by }}
                                                        </td>
                                                        <td>
                                                            <strong>Re-Activate On:</strong><br>
                                                            @php
                                                            $utcTime = $data->Re_Active_on ?? null;

                                                            if ($utcTime) {
                                                                try {
                                                                    $istTime = \Carbon\Carbon::parse($utcTime, 'UTC')
                                                                        ->setTimezone('Asia/Kolkata')
                                                                        ->format('d-M-Y H:i:s T');
                                                                    echo $istTime;
                                                                } catch (\Exception $e) {
                                                                    echo 'Invalid Date Format';
                                                                }
                                                            } else {
                                                                echo 'No Time Available';
                                                            }
                                                        @endphp
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td colspan="2">
                                                            <strong>Re-Activate Comment:</strong><br>
                                                            {{ $equipment->Re_Active_comment ?? 'Not Applicable' }}
                                                        </td>
                                                    </tr>


                                                      <!-- Add more rows for other data -->
                                                      <tr>
                                                        <td>
                                                            <strong>Re-Qualification By:</strong><br>
                                                            {{ $equipment->Re_Qualification_by_sec }}
                                                        </td>
                                                        <td>
                                                            <strong>Re-Qualification On:</strong><br>
                                                            @php
                                                            $utcTime = $data->Re_Qualification_on_sec ?? null;

                                                            if ($utcTime) {
                                                                try {
                                                                    $istTime = \Carbon\Carbon::parse($utcTime, 'UTC')
                                                                        ->setTimezone('Asia/Kolkata')
                                                                        ->format('d-M-Y H:i:s T');
                                                                    echo $istTime;
                                                                } catch (\Exception $e) {
                                                                    echo 'Invalid Date Format';
                                                                }
                                                            } else {
                                                                echo 'No Time Available';
                                                            }
                                                        @endphp
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td colspan="2">
                                                            <strong>Re-Qualification Comment:</strong><br>
                                                            {{ $equipment->Re_Qualification_comment_sec ?? 'Not Applicable' }}
                                                        </td>
                                                    </tr>


                                                     <!-- Add more rows for other data -->
                                                     <tr>
                                                        <td>
                                                            <strong>Retire By:</strong><br>
                                                            {{ $equipment->retire_by }}
                                                        </td>
                                                        <td>
                                                            <strong>Retire On:</strong><br>
                                                            @php
                                                            $utcTime = $data->retire_on ?? null;

                                                            if ($utcTime) {
                                                                try {
                                                                    $istTime = \Carbon\Carbon::parse($utcTime, 'UTC')
                                                                        ->setTimezone('Asia/Kolkata')
                                                                        ->format('d-M-Y H:i:s T');
                                                                    echo $istTime;
                                                                } catch (\Exception $e) {
                                                                    echo 'Invalid Date Format';
                                                                }
                                                            } else {
                                                                echo 'No Time Available';
                                                            }
                                                        @endphp
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td colspan="2">
                                                            <strong>Retire Comment:</strong><br>
                                                            {{ $equipment->retire_comment ?? 'Not Applicable' }}
                                                        </td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="button-block">
                                        <button type="submit" class="saveButton">Save</button>
                                        <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                        <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">Exit</a></button>
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

    <div class="modal fade" id="signature-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">E-Signature</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('EquipmentStateChange', $equipment->id) }}" method="POST">
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
                    <div class="modal-footer">
                        <button type="submit" data-bs-dismiss="modal">Submit</button>
                        <button type="button" data-bs-dismiss="modal">Close</button>
                        {{-- <button>Close</button> --}}
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

                <form action="{{ route('RejectEquipment', $equipment->id) }}" method="POST">
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
                    {{-- <div class="modal-footer">
                            <button type="submit" data-bs-dismiss="modal">Submit</button>
                            <button>Close</button>
                        </div> --}}
                    <div class="modal-footer">
                        <button type="submit">Submit</button>
                        <button type="button" data-bs-dismiss="modal">Close</button>

                    </div>
                </form>
            </div>
        </div>
    </div>





    <div class="modal fade" id="rejection-modal-requalification">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">E-Signature</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form action="{{ route('RejectEquipmentReQualification', $equipment->id) }}" method="POST">
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
                    {{-- <div class="modal-footer">
                            <button type="submit" data-bs-dismiss="modal">Submit</button>
                            <button>Close</button>
                        </div> --}}
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
                <form action="{{ route('equipmentChild', $equipment->id) }}" method="POST">
                    @csrf
                    
                    <div class="modal-body">
                        <div class="group-input">
                            
                                <label for="major">
                                    <input type="radio" name="child_type" id="major" value="Preventive Maintenance">
                                    Preventive Maintenance
                                </label>                           
                            
                                <label for="major">
                                    <input type="radio" name="child_type" id="major" value="Calibration Management">
                                    Calibration Management
                                </label>
                                
                                <label for="major">
                                    <input type="radio" name="child_type" id="major" value="Deviation">
                                    Deviation
                                </label>

                                <label for="major">
                                    <input type="radio" name="child_type" id="major" value="Action Item">
                                    Action Item
                                </label>

                                <label for="major">
                                    <input type="radio" name="child_type" id="major" value="Change Control">
                                    Change Control
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





    <div class="modal fade" id="cancel-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">E-Signature</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form action="{{ url('EquipmentCancel', $equipment->id) }}" method="POST">
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
        VirtualSelect.init({
            ele: '#investigators, #department, #investigation_team, #root_cause_methodology'
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

        function add4Input(tableId) {
            var table = document.getElementById(tableId);
            var currentRowCount = table.rows.length;
            var newRow = table.insertRow(currentRowCount);
            newRow.setAttribute("id", "row" + currentRowCount);
            var cell1 = newRow.insertCell(0);
            cell1.innerHTML = currentRowCount;

            var cell2 = newRow.insertCell(1);
            cell2.innerHTML = "<input type='text' name='Root_Cause_Category[]'>";

            var cell3 = newRow.insertCell(2);
            cell3.innerHTML = "<input type='text' name='Root_Cause_Sub_Category[]'>";

            var cell4 = newRow.insertCell(3);
            cell4.innerHTML = "<input type='text' name='Probability[]'>";

            var cell5 = newRow.insertCell(4);
            cell5.innerHTML = "<input type='text' name='Remarks[]'>";

            let cell6 = newRow.insertCell(5);
            cell6.innerHTML = "<button type='text' class='removeRowBtn' name='Action[]' readonly>Remove</button>";

            for (var i = 1; i < currentRowCount; i++) {
                var row = table.rows[i];
                row.cells[0].innerHTML = i;
            }
        }

        function addRootCauseAnalysisRiskAssessment(tableId) {
            var table = document.getElementById(tableId);
            var currentRowCount = table.rows.length;
            var newRow = table.insertRow(currentRowCount);
            newRow.setAttribute("id", "row" + currentRowCount);
            var cell1 = newRow.insertCell(0);
            cell1.innerHTML = currentRowCount;

            var cell2 = newRow.insertCell(1);
            cell2.innerHTML = "<input name='risk_factor[]' type='text'>";

            var cell3 = newRow.insertCell(2);
            cell3.innerHTML = "<input name='risk_element[]' type='text'>";

            var cell4 = newRow.insertCell(3);
            cell4.innerHTML = "<input name='problem_cause[]' type='text'>";

            var cell5 = newRow.insertCell(4);
            cell5.innerHTML = "<input name='existing_risk_control[]' type='text'>";

            var cell6 = newRow.insertCell(5);
            cell6.innerHTML =
                "<select onchange='calculateInitialResult(this)' class='fieldR' name='initial_severity[]'><option value=''>-- Select --</option><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option></select>";

            var cell7 = newRow.insertCell(6);
            cell7.innerHTML =
                "<select onchange='calculateInitialResult(this)' class='fieldP' name='initial_probability[]'><option value=''>-- Select --</option><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option></select>";

            var cell8 = newRow.insertCell(7);
            cell8.innerHTML =
                "<select onchange='calculateInitialResult(this)' class='fieldN' name='initial_detectability[]'><option value=''>-- Select --</option><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option></select>";

            var cell9 = newRow.insertCell(8);
            cell9.innerHTML = "<input name='initial_rpn[]' type='text' class='initial-rpn'  >";

            var cell10 = newRow.insertCell(9);
            cell10.innerHTML =
                "<select name='risk_acceptance[]'><option value=''>-- Select --</option><option value='N'>N</option><option value='Y'>Y</option></select>";

            var cell11 = newRow.insertCell(10);
            cell11.innerHTML = "<input name='risk_control_measure[]' type='text'>";

            var cell12 = newRow.insertCell(11);
            cell12.innerHTML =
                "<select onchange='calculateResidualResult(this)' class='residual-fieldR' name='residual_severity[]'><option value=''>-- Select --</option><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option></select>";

            var cell13 = newRow.insertCell(12);
            cell13.innerHTML =
                "<select onchange='calculateResidualResult(this)' class='residual-fieldP' name='residual_probability[]'><option value=''>-- Select --</option><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option></select>";

            var cell14 = newRow.insertCell(13);
            cell14.innerHTML =
                "<select onchange='calculateResidualResult(this)' class='residual-fieldN' name='residual_detectability[]'><option value=''>-- Select --</option><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option></select>";

            var cell15 = newRow.insertCell(14);
            cell15.innerHTML = "<input name='residual_rpn[]' type='text' class='residual-rpn' >";

            var cell16 = newRow.insertCell(15);
            cell16.innerHTML =
                "<select name='risk_acceptance2[]'><option value=''>-- Select --</option><option value='N'>N</option><option value='Y'>Y</option></select>";

            var cell17 = newRow.insertCell(16);
            cell17.innerHTML = "<input name='mitigation_proposal[]' type='text'>";

            var cell18 = newRow.insertCell(17);
            cell18.innerHTML = "<button type='text' class='removeRowBtn' name='Action[]' readonly>Remove</button>";

            for (var i = 1; i < currentRowCount; i++) {
                var row = table.rows[i];
                row.cells[0].innerHTML = i;
            }
        }



        function addIQAttachment(tableId) {
            var table = document.getElementById(tableId);
            var currentRowCount = table.rows.length;
            var newRow = table.insertRow(currentRowCount);
            newRow.setAttribute("id", "row" + currentRowCount);
            var cell1 = newRow.insertCell(0);
            cell1.innerHTML = currentRowCount;

            var cell2 = newRow.insertCell(1);
            cell2.innerHTML = "<input name='doc_name_IQ[]' type='text'>";

            var cell3 = newRow.insertCell(2);
            cell3.innerHTML = "<input name='doc_id_IQ[]' type='text'>";

            var cell4 = newRow.insertCell(3);
            cell4.innerHTML = "<input name='doc_remark_IQ[]' type='text'>";

            var cell5 = newRow.insertCell(4);
            cell5.innerHTML = "<button type='button' class='removeRowBtn' onclick='removeRow(this)'>Remove</button>";

            for (var i = 1; i < currentRowCount; i++) {
                var row = table.rows[i];
                row.cells[0].innerHTML = i;
            }
        }


        function add_DQ_Attachment(tableId) {
            var table = document.getElementById(tableId);
            var currentRowCount = table.rows.length;
            var newRow = table.insertRow(currentRowCount);
            newRow.setAttribute("id", "row" + currentRowCount);
            var cell1 = newRow.insertCell(0);
            cell1.innerHTML = currentRowCount;

            var cell2 = newRow.insertCell(1);
            cell2.innerHTML = "<input name='doc_name_DQ[]' type='text'>";

            var cell3 = newRow.insertCell(2);
            cell3.innerHTML = "<input name='doc_id_DQ[]' type='text'>";

            var cell4 = newRow.insertCell(3);
            cell4.innerHTML = "<input name='doc_remark_DQ[]' type='text'>";

            var cell5 = newRow.insertCell(4);
            cell5.innerHTML = "<button type='button' class='removeRowBtn' onclick='removeRow(this)'>Remove</button>";

            for (var i = 1; i < currentRowCount; i++) {
                var row = table.rows[i];
                row.cells[0].innerHTML = i;
            }
        }


        function add_OQ_Attachment(tableId) {
            var table = document.getElementById(tableId);
            var currentRowCount = table.rows.length;
            var newRow = table.insertRow(currentRowCount);
            newRow.setAttribute("id", "row" + currentRowCount);
            var cell1 = newRow.insertCell(0);
            cell1.innerHTML = currentRowCount;

            var cell2 = newRow.insertCell(1);
            cell2.innerHTML = "<input name='doc_name_OQ[]' type='text'>";

            var cell3 = newRow.insertCell(2);
            cell3.innerHTML = "<input name='doc_id_OQ[]' type='text'>";

            var cell4 = newRow.insertCell(3);
            cell4.innerHTML = "<input name='doc_remark_OQ[]' type='text'>";

            var cell5 = newRow.insertCell(4);
            cell5.innerHTML = "<button type='button' class='removeRowBtn' onclick='removeRow(this)'>Remove</button>";

            for (var i = 1; i < currentRowCount; i++) {
                var row = table.rows[i];
                row.cells[0].innerHTML = i;
            }
        }

        function add_PQ_Attachment(tableId) {
            var table = document.getElementById(tableId);
            var currentRowCount = table.rows.length;
            var newRow = table.insertRow(currentRowCount);
            newRow.setAttribute("id", "row" + currentRowCount);
            var cell1 = newRow.insertCell(0);
            cell1.innerHTML = currentRowCount;

            var cell2 = newRow.insertCell(1);
            cell2.innerHTML = "<input name='doc_name_PQ[]' type='text'>";

            var cell3 = newRow.insertCell(2);
            cell3.innerHTML = "<input name='doc_id_PQ[]' type='text'>";

            var cell4 = newRow.insertCell(3);
            cell4.innerHTML = "<input name='doc_remark_PQ[]' type='text'>";

            var cell5 = newRow.insertCell(4);
            cell5.innerHTML = "<button type='button' class='removeRowBtn' onclick='removeRow(this)'>Remove</button>";

            for (var i = 1; i < currentRowCount; i++) {
                var row = table.rows[i];
                row.cells[0].innerHTML = i;
            }
        }



        function removeRow(button) {
            var row = button.closest("tr");
            row.parentNode.removeChild(row);

            // Update Sr. No for all rows after removing
            var table = document.getElementById("qualification-iq");
            for (var i = 1; i < table.rows.length; i++) {
                table.rows[i].cells[0].innerHTML = i;
            }
        }



        function addHAZOPRiskAssessment(tableId) {
            var table = document.getElementById(tableId);
            var currentRowCount = table.rows.length; // Get the current number of rows including the header row
            
            // Insert a new row at the end of the table body (not in the header)
            var newRow = table.getElementsByTagName('tbody')[0].insertRow(); 

            // Set the row's ID
            newRow.setAttribute("id", "row" + currentRowCount);
            
            // Insert a cell for the row number (first column)
            var cell1 = newRow.insertCell(0);
            cell1.innerHTML = currentRowCount; // Row number based on current row count
            
            // Insert cells for HAZOP data fields (middle columns)
            var cell2 = newRow.insertCell(1);
            cell2.setAttribute('colspan', '2');
            cell2.innerHTML = "<input name='deviation[]' type='text' colspan='2' {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }}>";
            
            var cell3 = newRow.insertCell(2);
            cell3.setAttribute('colspan', '2');
            cell3.innerHTML = "<input name='session[]' type='text' {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }}>";
            
            var cell4 = newRow.insertCell(3);
            cell4.setAttribute('colspan', '2');
            cell4.innerHTML = "<input name='causes[]' type='text' {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }}>";
            
            var cell5 = newRow.insertCell(4);
            cell5.setAttribute('colspan', '2');
            cell5.innerHTML = "<input name='consequences[]' type='text' {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }}>";
            
            var cell6 = newRow.insertCell(5);
            cell6.setAttribute('colspan', '2');
            cell6.innerHTML = "<input name='category[]' type='text' {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }}>";
            
            var cell7 = newRow.insertCell(6);
            cell7.innerHTML = "<input name='risk_or_S[]' type='text' {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }}>";
            
            var cell8 = newRow.insertCell(7);
            cell8.innerHTML = "<input name='risk_or_F[]' type='text' {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }}>";
            
            var cell9 = newRow.insertCell(8);
            cell9.innerHTML = "<input name='risk_or_RR[]' type='text' {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }}>";
            
            var cell10 = newRow.insertCell(9);
            cell10.setAttribute('colspan', '2');
            cell10.innerHTML = "<input name='risk_enablers[]' type='text' {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }}>";
            
            var cell11 = newRow.insertCell(10);
            cell11.innerHTML = "<input name='risk_CR_S[]' type='text' {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }}>";
            
            var cell12 = newRow.insertCell(11);
            cell12.innerHTML = "<input name='risk_CR_F[]' type='text' {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }}>";
            
            var cell13 = newRow.insertCell(12);
            cell13.innerHTML = "<input name='risk_CR_RR[]' type='text' {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }}>";

            var cell14 = newRow.insertCell(13);
            cell14.setAttribute('colspan', '2');
            cell14.innerHTML = "<input name='safeguards_sensor_tag_nr[]' type='text' {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }}>";

            var cell15 = newRow.insertCell(14);
            cell15.setAttribute('colspan', '2');
            cell15.innerHTML = "<input name='safeguards_tag_nr[]' type='text' {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }}>";

            var cell16 = newRow.insertCell(15);
            cell16.setAttribute('colspan', '2');
            cell16.innerHTML = "<input name='safeguards_action[]' type='text' {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }}>";

            var cell17 = newRow.insertCell(16);
            cell17.setAttribute('colspan', '2');
            cell17.innerHTML = "<input name='safeguards_effective_action[]' type='text' {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }}>";

            var cell18 = newRow.insertCell(17);
            cell18.setAttribute('colspan', '2');
            cell18.innerHTML = "<input name='safeguards_other_safeguards[]' type='text' {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }}>";

            var cell19 = newRow.insertCell(18);
            cell19.setAttribute('colspan', '2');
            cell19.innerHTML = "<input name='critical_safeguards_description[]' type='text' {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }}>";

            var cell20 = newRow.insertCell(19);
            cell20.innerHTML = "<input name='critical_safeguards_type[]' type='text' {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }}>";

            var cell21 = newRow.insertCell(20);
            cell21.innerHTML = "<input name='critical_safeguards_rrf[]' type='text' {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }}>";

            var cell22 = newRow.insertCell(21);
            cell22.innerHTML = "<input name='risk_rating_s[]' type='text' {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }}>";

            var cell23 = newRow.insertCell(22);
            cell23.innerHTML = "<input name='risk_rating_f[]' type='text' {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }}>";

            var cell24 = newRow.insertCell(23);
            cell24.innerHTML = "<input name='risk_rating_rr[]' type='text' {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }}>";

            var cell25 = newRow.insertCell(24);
            cell25.setAttribute('colspan', '3');
            cell25.innerHTML = "<input name='hazop_recommendations[]' type='text' {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }}>";

            var cell26 = newRow.insertCell(25);
            cell26.setAttribute('colspan', '3');
            cell26.innerHTML = "<input name='responsibility_for_recommendations[]' type='text' {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }}>";

            var cell27 = newRow.insertCell(26);
            cell27.innerHTML = "<input name='risk_rating_after_s[]' type='text' {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }}>";

            var cell28 = newRow.insertCell(27);
            cell28.innerHTML = "<input name='risk_rating_after_f[]' type='text' {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }}>";

            var cell29 = newRow.insertCell(28);
            cell29.innerHTML = "<input name='risk_rating_after_rr[]' type='text' {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }}>";
            

            // Insert a cell for the action (Remove button) (last column)
            var cell30 = newRow.insertCell(29);
            cell30.setAttribute('colspan', '2');
            cell30.innerHTML = "<button type='button' onclick='removeHAZOPRow(this)' class='removeRowBtn' {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }}>Remove</button>";

            // Update row numbers after adding a new row
            updateRowNumbers(table);
        }

        function removeHAZOPRow(button) {
            // Get the row to remove
            var row = button.closest("tr");
            var table = row.parentNode;
            row.parentNode.removeChild(row);

            // After removing, update the row numbers again
            updateRowNumbers(table);
        }

        function updateRowNumbers(table) {
            // Update the row number for each row in the tbody (excluding the header)
            var rows = table.getElementsByTagName('tbody')[0].rows;
            for (var i = 0; i < rows.length; i++) {
                rows[i].cells[0].innerHTML = i + 1;  // Set the row number
            }
        }


    </script>

    <script>
        function calculateInitialResult(selectElement) {
            let row = selectElement.closest('tr');
            let R = parseFloat(row.querySelector('.fieldR').value) || 0;
            let P = parseFloat(row.querySelector('.fieldP').value) || 0;
            let N = parseFloat(row.querySelector('.fieldN').value) || 0;
            let result = R * P * N;
            row.querySelector('.initial-rpn').value = result;
        }
    </script>

    <script>
        function calculateResidualResult(selectElement) {
            let row = selectElement.closest('tr');
            let R = parseFloat(row.querySelector('.residual-fieldR').value) || 0;
            let P = parseFloat(row.querySelector('.residual-fieldP').value) || 0;
            let N = parseFloat(row.querySelector('.residual-fieldN').value) || 0;
            let result = R * P * N;
            row.querySelector('.residual-rpn').value = result;
        }
    </script>


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

<script>
    function addSparePartInformation(tableId) {
        var table = document.getElementById(tableId);
        var currentRowCount = table.rows.length;
        var newRow = table.insertRow(currentRowCount);
        newRow.setAttribute("id", "row" + currentRowCount);

        var cell1 = newRow.insertCell(0);
        cell1.innerHTML = currentRowCount;

        var cell2 = newRow.insertCell(1);
        cell2.setAttribute('colspan', '2');
        cell2.innerHTML = "<input name='SpareEquipment_Name[]' type='text'>";

        var cell3 = newRow.insertCell(2);
        cell3.setAttribute('colspan', '2');
        cell3.innerHTML = "<input name='SpareEquipment_ID[]' type='number' min='0'>";

        var cell4 = newRow.insertCell(3);
        cell4.setAttribute('colspan', '2');
        cell4.innerHTML = "<input name='SparePart_ID[]' type='number' min='0'>";

        var cell5 = newRow.insertCell(4);
        cell5.setAttribute('colspan', '2');
        cell5.innerHTML = "<input name='SparePart_Name[]' type='text'>";

        var cell6 = newRow.insertCell(5);
        cell6.setAttribute('colspan', '2');
        cell6.innerHTML = "<input name='SpareManufacturer[]' type='text'>";

        var cell7 = newRow.insertCell(6);
        cell7.setAttribute('colspan', '2');
        cell7.innerHTML = "<input name='SpareModel_Number[]' type='number' min='0'>";

        var cell8 = newRow.insertCell(7);
        cell8.setAttribute('colspan', '2');
        cell8.innerHTML = "<input name='SpareSerial_Number[]' type='number' min='0'>";

        var cell9 = newRow.insertCell(8);
        cell9.setAttribute('colspan', '2');
        cell9.innerHTML = "<input name='SpareOEM[]' type='text'>";

        var cell10 = newRow.insertCell(9);
        cell10.setAttribute('colspan', '2');
        cell10.innerHTML = "<input name='SparePart_Category[]' type='text'>";

        var cell11 = newRow.insertCell(10);
        cell11.setAttribute('colspan', '2');
        cell11.innerHTML = "<input name='SparePart_Group[]' type='text'>";

        var cell12 = newRow.insertCell(11);
        cell12.setAttribute('colspan', '2');
        cell12.innerHTML = "<input name='SparePart_Dimensions[]' type='text'>";

        var cell13 = newRow.insertCell(12);
        cell13.setAttribute('colspan', '2');
        cell13.innerHTML = "<input name='SpareMaterial[]' type='text'>";

        var cell14 = newRow.insertCell(13);
        cell14.setAttribute('colspan', '2');
        cell14.innerHTML = "<input name='SpareWeight[]' type='number' min='0'>";

        var cell15 = newRow.insertCell(14);
        cell15.setAttribute('colspan', '2');
        cell15.innerHTML = "<input name='SpareColor[]' type='text'>";

        var cell16 = newRow.insertCell(15);
        cell16.setAttribute('colspan', '2');
        cell16.innerHTML = "<input name='SparePart_Lifecycle_Stage[]' type='text'>";

        var cell17 = newRow.insertCell(16);
        cell17.setAttribute('colspan', '2');
        cell17.innerHTML = "<input name='SparePart_Status[]' type='text'>";

        var cell18 = newRow.insertCell(17);
        cell18.setAttribute('colspan', '2');
        cell18.innerHTML = "<input name='SpareAvailability[]' type='text'>";

        var cell19 = newRow.insertCell(18);
        cell19.setAttribute('colspan', '2');
        cell19.innerHTML = "<input name='SpareQuantity_on_Hand[]' type='number' min='0'>";

        var cell20 = newRow.insertCell(19);
        cell20.setAttribute('colspan', '2');
        cell20.innerHTML = "<input name='SpareQuantity_on_Order[]' type='number' min='0'>";

        var cell21 = newRow.insertCell(20);
        cell21.setAttribute('colspan', '2');
        cell21.innerHTML = "<input name='SpareReorder_Point[]' type='text'>";

        var cell22 = newRow.insertCell(21);
        cell22.setAttribute('colspan', '2');
        cell22.innerHTML = "<input name='SpareSafety_Stock[]' type='text'>";

        var cell23 = newRow.insertCell(22);
        cell23.setAttribute('colspan', '2');
        cell23.innerHTML = "<input name='SpareMinimum_Order_Quantity[]' type='number' min='0'>";

        var cell24 = newRow.insertCell(23);
        cell24.setAttribute('colspan', '2');
        cell24.innerHTML = "<input name='SpareLead_Time[]' type='number' min='0'>";

        var cell25 = newRow.insertCell(24);
        cell25.setAttribute('colspan', '2');
        cell25.innerHTML = "<input name='SpareStock_Location[]' type='text'>";

        var cell26 = newRow.insertCell(25);
        cell26.setAttribute('colspan', '2');
        cell26.innerHTML = "<input name='SpareBin_Number[]' type='number' min='0'>";

        var cell27 = newRow.insertCell(26);
        cell27.setAttribute('colspan', '2');
        cell27.innerHTML = "<input name='SpareStock_Keeping_Unit[]' type='text'>";

        var cell28 = newRow.insertCell(27);
        cell28.setAttribute('colspan', '2');
        cell28.innerHTML = "<input name='SpareLot_Number[]' type='number' min='0'>";

        var cell29 = newRow.insertCell(28);
        cell29.setAttribute('colspan', '2');
        cell29.innerHTML = "<input name='SpareExpiry_Date[]' type='text'>";

        var cell30 = newRow.insertCell(29);
        cell30.setAttribute('colspan', '2');
        cell30.innerHTML = "<input name='SpareSupplier_Name[]' type='text'>";

        var cell31 = newRow.insertCell(30);
        cell31.setAttribute('colspan', '2');
        cell31.innerHTML = "<input name='SpareSupplier_Contact_Information[]' type='text'>";

        var cell32 = newRow.insertCell(31);
        cell32.setAttribute('colspan', '2');
        cell32.innerHTML = "<input name='SpareSupplier_Lead_Time[]' type='number' min='0'>";

        var cell33 = newRow.insertCell(32);
        cell33.setAttribute('colspan', '2');
        cell33.innerHTML = "<input name='SpareSupplier_Price[]' type='number' min='0'>";

        var cell34 = newRow.insertCell(33);
        cell34.setAttribute('colspan', '2');
        cell34.innerHTML = "<input name='SpareSupplier_Part_Number[]' type='number' min='0'>";

        var cell35 = newRow.insertCell(34);
        cell35.setAttribute('colspan', '2');
        cell35.innerHTML = "<input name='SpareSupplier_Warranty_Information[]' type='text'>";

        var cell36 = newRow.insertCell(35);
        cell36.setAttribute('colspan', '2');
        cell36.innerHTML = "<input name='SpareSupplier_Performance_Metrics[]' type='text'>";

        var cell37 = newRow.insertCell(36);
        cell37.setAttribute('colspan', '2');
        cell37.innerHTML =
            "<button type='button' onclick='removeSparePartRow(this)' class='removeRowBtn'>Remove</button>";

        // Update row numbers
        for (var i = 1; i < table.rows.length; i++) {
            table.rows[i].cells[0].innerHTML = i;
        }
    }


    function removeSparePartRow(button) {
        // Get the row to remove
        var row = button.closest("tr");
        var table = row.parentNode;
        row.parentNode.removeChild(row);

        // After removing, update the row numbers again
        updateRowNumbers(table);
    }

    function updateRowNumbers(table) {
        // Update the row number for each row in the tbody (excluding the header)
        var rows = table.getElementsByTagName('tbody')[0].rows;
        for (var i = 0; i < rows.length; i++) {
            rows[i].cells[0].innerHTML = i + 1; // Set the row number
        }
    }
</script>

@endsection
