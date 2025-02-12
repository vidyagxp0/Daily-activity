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
    <!-- --- --------adding scroll css -->
    <style>
        /* Wrapper for horizontal scrolling */
        .cctab-wrapper {
            overflow-x: auto;
            white-space: nowrap;
            display: flex;
            width: 100%;
            border-bottom: 1px solid #ccc;
            scrollbar-width: thin;
            /* For modern browsers */
            scrollbar-color: #000 #fff;
            /* Thumb color and track color */
        }

        /* Custom scrollbar for webkit browsers */
        .cctab-wrapper::-webkit-scrollbar {
            height: 8px;
            /* Scrollbar height */
        }

        .cctab-wrapper::-webkit-scrollbar-track {
            background: #fff;
            /* Scrollbar track color */
        }

        .cctab-wrapper::-webkit-scrollbar-thumb {
            background-color: #007bff;
            /* Scrollbar thumb color */
            border-radius: 5px;
            /* Rounded corners for the thumb */
        }

        /* Tabs container */
        .cctab {
            display: inline-flex;
            gap: 5px;
            /* Space between tabs */
            width: max-content;
            /* Allows horizontal scrolling if tabs overflow */
            flex-shrink: 0;
            /* Prevent tabs from shrinking */
        }

        /* Individual tab button styles */
        .cctablinks {
            display: inline-block;
            padding: 10px 15px;
            border: none;
            background-color: #f1f1f1;
            color: #333;
            cursor: pointer;
            text-align: center;
            white-space: nowrap;
            flex-shrink: 0;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .cctablinks:hover {
            background-color: #ddd;
        }

        .cctablinks.active {
            background-color: #007bff;
            color: #fff;
        }
    </style>
    <!-- --- ------------------ -->
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
                    {{ Helpers::getDivisionName($EHS->division_id) }} / EHS & Environment Sustainability
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
                        $userRoles = DB::table('user_roles')
                            ->where(['user_id' => Auth::user()->id, 'q_m_s_divisions_id' => $data->division_id])
                            ->get();
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
                        <button class="button_theme1"> <a class="text-white" href="{{ route('ehsAuditTrail', $EHS->id) }}">
                                Audit Trail </a> </button>

                        @if ($EHS->stage == 1 && (in_array(13, $userRoleIds) || in_array(18, $userRoleIds)))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Submit
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-modal">
                                Cancel
                            </button>
                        @elseif($EHS->stage == 2 && (in_array(12, $userRoleIds) || in_array(18, $userRoleIds)))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Review Complete
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#more-info-required-modal">
                                More Information Required
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-modal">
                                Cancel
                            </button>
                        @elseif($EHS->stage == 3 && (in_array(12, $userRoleIds) || in_array(18, $userRoleIds)))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Complete Investigation
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#child-modal">
                                Child
                            </button>
                        @elseif($EHS->stage == 4 && (in_array(11, $userRoleIds) || in_array(18, $userRoleIds)))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Analysis Complete
                            </button>

                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#more-info-required-modal">
                                More Investigation Required
                            </button>
                        @elseif($EHS->stage == 5 && (in_array(3, $userRoleIds) || in_array(18, $userRoleIds) || in_array(11, $userRoleIds)))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Training Required
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#child-modal">
                                Child
                            </button>
                        @elseif($EHS->stage == 6 && (in_array(3, $userRoleIds) || in_array(18, $userRoleIds) || in_array(11, $userRoleIds)))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Training Complete
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#more-info-required-modal">
                                More Information Required
                            </button>
                        @elseif($EHS->stage == 7 && (in_array(3, $userRoleIds) || in_array(18, $userRoleIds) || in_array(11, $userRoleIds)))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Propose Plan
                            </button>
                        @elseif($EHS->stage == 8 && (in_array(11, $userRoleIds) || in_array(18, $userRoleIds)))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Approve Plan
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#more-info-required-modal">
                                Reject
                            </button>
                        @elseif($EHS->stage == 9 && (in_array(11, $userRoleIds) || in_array(18, $userRoleIds)))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                All CAPA Closed
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#more-info-required-modal">
                                More Information Required
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
                    @if ($EHS->stage == 0)
                        <div class="progress-bars">
                            <div class="bg-danger">Closed-Cancelled</div>
                        </div>
                    @else
                        <div class="progress-bars d-flex">
                            @if ($EHS->stage >= 1)
                                <div class="active">Opened</div>
                            @else
                                <div class="">Opened</div>
                            @endif
                            @if ($EHS->stage >= 2)
                                <div class="active">Pending Review</div>
                            @else
                                <div class="">Pending Review</div>
                            @endif
                            @if ($EHS->stage >= 3)
                                <div class="active">Pending Investigation</div>
                            @else
                                <div class="">Pending Investigation</div>
                            @endif
                            @if ($EHS->stage >= 4)
                                <div class="active">Root Cause and Risk Analysis</div>
                            @else
                                <div class="">Root Cause and Risk Analysis</div>
                            @endif
                            @if ($EHS->stage >= 5)
                                <div class="active">Pending Action Planning</div>
                            @else
                                <div class="">Pending Action Planning</div>
                            @endif
                            @if ($EHS->stage >= 6)
                                <div class="active">Pending Training</div>
                            @else
                                <div class="">Pending Training</div>
                            @endif
                            @if ($EHS->stage >= 7)
                                <div class="active">Training Complete</div>
                            @else
                                <div class="">Training Complete</div>
                            @endif
                            @if ($EHS->stage >= 8)
                                <div class="active">Pending Approval</div>
                            @else
                                <div class="">Pending Approval</div>
                            @endif
                            @if ($EHS->stage >= 9)
                                <div class="active">CAPA Execution in Progres</div>
                            @else
                                <div class="">CAPA Execution in Progres</div>
                            @endif

                            @if ($EHS->stage >= 10)
                                <div class="active bg-danger" @if ($EHS->stage == 10)  @endif>Closed - Done
                                </div>
                            @else
                                <div class="" @if ($EHS->stage == 10)  @endif>Closed - Done</div>
                            @endif

                        </div>
                    @endif


                </div>
                <br>
                <div class="top-block">
                    <div><strong> Record Name:&nbsp;</strong>EHS & Environment Sustainability</div>
                    <div><strong> Site:&nbsp;</strong>{{ Helpers::getDivisionName(session()->get('division')) }}</div>
                    <div><strong> Current Status:&nbsp;</strong>{{ $EHS->status }}</div>
                    <div><strong> Initiated By:&nbsp;</strong>{{ Helpers::getInitiatorName($EHS->initiator_id) }}</div>
                </div>
            </div>
            <div class="modal right fade" id="myModal3" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-titles ml-10">EHS & Environment Sustainability Workflow</h4>
                        </div>
                        <div style="" class="modal-body main-new-workflow">
                            <Div class="button-box">
                                @if ($EHS->stage == 0)
                                    <div class="">
                                        <div class="mini_buttons  bg-danger">Closed-Cancelled</div>
                                    @else
                                        @if ($EHS->stage >= 1)
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
                                        @if ($EHS->stage >= 2)
                                            <div class="active">
                                                Pending Review
                                            </div>
                                        @else
                                            <div class="mini_buttons">
                                                Pending Review
                                            </div>
                                        @endif
                                        <div class="down-logo">
                                            <img class="dawn_arrow" src="{{ asset('user/images/down.gif') }}"
                                                alt="..." class="w-100 h-100">

                                        </div>
                                        @if ($EHS->stage >= 3)
                                            <div class="active">
                                                Pending Investigation
                                            </div>
                                        @else
                                            <div class="mini_buttons">
                                                Pending Investigation
                                            </div>
                                        @endif
                                        <div class="down-logo">
                                            <img class="dawn_arrow" src="{{ asset('user/images/down.gif') }}"
                                                alt="..." class="w-100 h-100">

                                        </div>
                                        @if ($EHS->stage >= 4)
                                            <div class="active">
                                                Root Cause and Risk Analysis
                                            </div>
                                        @else
                                            <div class="mini_buttons">
                                                Root Cause and Risk Analysis
                                            </div>
                                        @endif

                                        <div class="down-logo">
                                            <img class="dawn_arrow" src="{{ asset('user/images/down.gif') }}"
                                                alt="..." class="w-100 h-100">

                                        </div>
                                        @if ($EHS->stage >= 5)
                                            <div class="active">
                                                Pending Action Planning
                                            </div>
                                        @else
                                            <div class="mini_buttons">
                                                Pending Action Planning
                                            </div>
                                        @endif
                                        <div class="down-logo">
                                            <img class="dawn_arrow" src="{{ asset('user/images/down.gif') }}"
                                                alt="..." class="w-100 h-100">

                                        </div>
                                        @if ($EHS->stage >= 6)
                                            <div class="active">
                                                Pending Training
                                            </div>
                                        @else
                                            <div class="mini_buttons">
                                                Pending Training
                                            </div>
                                        @endif
                                        <div class="down-logo">
                                            <img class="dawn_arrow" src="{{ asset('user/images/down.gif') }}"
                                                alt="..." class="w-100 h-100">

                                        </div>
                                        @if ($EHS->stage >= 7)
                                            <div class="active">
                                                Training Complete
                                            </div>
                                        @else
                                            <div class="mini_buttons">
                                                Training Complete
                                            </div>
                                        @endif

                                        <div class="down-logo">
                                            <img class="dawn_arrow" src="{{ asset('user/images/down.gif') }}"
                                                alt="..." class="w-100 h-100">

                                        </div>
                                        @if ($EHS->stage >= 8)
                                            <div class="active">
                                                Pending Approval
                                            </div>
                                        @else
                                            <div class="mini_buttons">
                                                Pending Approval
                                            </div>
                                        @endif

                                        <div class="down-logo">
                                            <img class="dawn_arrow" src="{{ asset('user/images/down.gif') }}"
                                                alt="..." class="w-100 h-100">

                                        </div>
                                        @if ($EHS->stage >= 9)
                                            <div class="active">
                                                CAPA Execution in Progress
                                            </div>
                                        @else
                                            <div class="mini_buttons">
                                                CAPA Execution in Progress
                                            </div>
                                        @endif

                                        <div class="down-logo">
                                            <img class="dawn_arrow" src="{{ asset('user/images/down.gif') }}"
                                                alt="..." class="w-100 h-100">

                                        </div>

                                        @if ($EHS->stage >= 10)
                                            <div class=" mini_buttons bg-danger">Closed - Done</div>
                                        @else
                                            <div class="mini_buttons">Closed - Done </div>
                                        @endif
                                @endif
                            </Div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="control-list">
            {{-- ------------------------------- --}}

            {{-- ======================================
                    DATA FIELDS
    ======================================= --}}

            @php
                $users = DB::table('users')->get();
            @endphp

            <div id="change-control-fields">
                <div class="container-fluid">

                    <!-- Tab links -->
                    <div class="cctab-wrapper">
                        <div class="cctab">
                            <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">EHS Event</button>
                            <button class="cctablinks" onclick="openCity(event, 'CCForm2')">Detailed Information</button>
                            <button class="cctablinks" onclick="openCity(event, 'CCForm3')">Damage Information</button>
                            <button class="cctablinks" onclick="openCity(event, 'CCForm4')">Investigation Summary</button>
                            <button class="cctablinks" onclick="openCity(event, 'CCForm5')">Root Cause And Risk
                                Analysis</button>
                            <button class="cctablinks" onclick="openCity(event, 'CCForm6')">Employee and Personnel
                                Information</button>
                            <button class="cctablinks" onclick="openCity(event, 'CCForm7')">Regulatory Compliance
                                Data</button>
                            <button class="cctablinks" onclick="openCity(event, 'CCForm8')">Incident and Accident
                                Reporting</button>
                            <button class="cctablinks" onclick="openCity(event, 'CCForm9')">Chemical and Hazardous
                                Materials Management</button>
                            <button class="cctablinks" onclick="openCity(event, 'CCForm10')">Workplace Safety and
                                Environment Monitoring</button>
                            <button class="cctablinks" onclick="openCity(event, 'CCForm11')">Health and Occupational
                                Safety</button>
                            <button class="cctablinks" onclick="openCity(event, 'CCForm12')">Emergency Preparedness and
                                Response</button>
                            <button class="cctablinks" onclick="openCity(event, 'CCForm13')">Waste Management</button>
                            <button class="cctablinks" onclick="openCity(event, 'CCForm14')">Training and
                                Awareness</button>
                            <button class="cctablinks" onclick="openCity(event, 'CCForm15')">Environmental Impact
                                Data</button>
                            <button class="cctablinks" onclick="openCity(event, 'CCForm16')">Energy Consumption</button>
                            <button class="cctablinks" onclick="openCity(event, 'CCForm17')">Carbon Emissions (Greenhouse
                                Gases)</button>
                            <button class="cctablinks" onclick="openCity(event, 'CCForm18')">Water Usage</button>
                            <button class="cctablinks" onclick="openCity(event, 'CCForm19')">Sustainable
                                Procurement</button>
                            <button class="cctablinks" onclick="openCity(event, 'CCForm20')">Transportation and
                                Logistics</button>
                            <button class="cctablinks" onclick="openCity(event, 'CCForm21')">Biodiversity and Land
                                Use</button>
                            <button class="cctablinks" onclick="openCity(event, 'CCForm22')">Environmental Certifications
                                & Compliance</button>
                            <button class="cctablinks" onclick="openCity(event, 'CCForm23')">Environmental Impact and Risk
                                Assessment</button>
                            <button class="cctablinks" onclick="openCity(event, 'CCForm24')">Risk Management and Hazard
                                Identification</button>
                            <button class="cctablinks" onclick="openCity(event, 'CCForm25')">Audit and Inspection
                                Records</button>
                            <button class="cctablinks" onclick="openCity(event, 'CCForm26')">Sustainability and Corporate
                                Social Responsibility (CSR)</button>
                            <button class="cctablinks" onclick="openCity(event, 'CCForm27')">Analytics and
                                Reporting</button>
                            <button class="cctablinks" onclick="openCity(event, 'CCForm28')">Sustainability Goals and
                                Metrics</button>
                            <button class="cctablinks" onclick="openCity(event, 'CCForm29')">Employee Engagement and
                                Education</button>
                            <button class="cctablinks" onclick="openCity(event, 'CCForm30')">Community Engagement and
                                Social Responsibility</button>
                            <button class="cctablinks" onclick="openCity(event, 'CCForm31')">Activity Log</button>
                        </div>
                    </div>

                    <form action="{{ route('updateEhs_event', $EHS->id) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div id="step-form">

                            <!-- General information content -->
                            <div id="CCForm1" class="inner-block cctabcontent">
                                <div class="inner-block-content">
                                    <div class="sub-head">
                                        General Information
                                    </div>
                                    <div class="row">

                                        @if (!empty($parent_id))
                                            <input type="hidden" name="parent_id" value="{{ $parent_id }}">
                                            <input type="hidden" name="parent_type" value="{{ $parent_type }}">
                                        @endif
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="RLS Record Number"><b>Record Number</b></label>
                                                <input type="hidden" name="record_number">
                                                <input readonly type="text" {{-- value="{{ Helpers::getDivisionName($EHS->division_id) }}/EE/{{ Helpers::year($EHS->created_at) }}/{{ $EHS->record_number }}" --}}
                                                    value="{{ $EHS->record_number }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Division Code"><b>Site/Location Code</b></label>
                                                <input readonly type="text" name="division_code"
                                                    value="{{ Helpers::getDivisionName($EHS->division_id) }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Initiator"><b>Initiator</b></label>
                                                <input type="hidden" name="initiator_id">
                                                <input readonly type="text" value="{{ $EHS->initiator_name }} ">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Date Due">Date of Initiation</label>
                                                <input readonly type="text"
                                                    value="{{ Helpers::getdateFormat($EHS->intiation_date) }}"
                                                    name="intiation_date"{{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>

                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Assigned to">Assigned to</label>
                                                <select name="assign_to"
                                                    {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>
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
                                                <label for="due-date">Due Date<span class="text-danger">*</span></label>
                                                {{-- <div><small class="text-primary">If revising Due Date, kindly mention revision reason in "Due Date Extension Justification" data field.</small></div> --}}
                                                <input readonly type="text"
                                                    value="{{ Helpers::getdateFormat($EHS->due_date) }}"
                                                    name="due_date"{{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>
                                            </div>
                                        </div>


                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Short Description">Short Description<span
                                                        class="text-danger">*</span></label><span
                                                    id="rchars">255</span>
                                                characters remaining
                                                <div class="relative-container">
                                                    <input name="short_description" id="docname" type="text"
                                                        value="{{ $EHS->short_description }}" maxlength="255" required
                                                        {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                            <p id="docnameError" style="color:red">**Short Description is required</p>

                                        </div>
                                        <div class="sub-head">
                                            EHS Event Details
                                        </div>
                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Type">Type</label>
                                                <div><small class="text-primary">Event Type</small></div>
                                                <select name="Type" id="Type" data-search="false"
                                                    data-silent-initial-value-set="true"
                                                    {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>
                                                    <option value="">-- Select --</option>
                                                    <option value="Accident"
                                                        {{ $EHS->Type == 'Accident' ? 'selected' : '' }}>Accident</option>
                                                    <option value="General Event"
                                                        {{ $EHS->Type == 'General Event' ? 'selected' : '' }}>General Event
                                                    </option>
                                                    <option value="Incident"
                                                        {{ $EHS->Type == 'Incident' ? 'selected' : '' }}>Incident</option>
                                                    <option value="Near Miss"
                                                        {{ $EHS->Type == 'Near Miss' ? 'selected' : '' }}>Near Miss
                                                    </option>
                                                    <option value="Self Assessment"
                                                        {{ $EHS->Type == 'Self Assessment' ? 'selected' : '' }}>Self
                                                        Assessment</option>
                                                    <option value="Other" {{ $EHS->Type == 'Other' ? 'selected' : '' }}>
                                                        Other</option>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Incident Sub Type">Incident Sub Type</label>
                                                <select name="Incident_Sub_Type" id="Incident_Sub_Type"
                                                    data-search="false" data-silent-initial-value-set="true"
                                                    {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>
                                                    <option value="">-- Select --</option>
                                                    <option value="Accident"
                                                        {{ $EHS->Incident_Sub_Type == 'Accident' ? 'selected' : '' }}>
                                                        Accident</option>
                                                    <option value="Car Accident"
                                                        {{ $EHS->Incident_Sub_Type == 'Car Accident' ? 'selected' : '' }}>
                                                        Car Accident</option>
                                                    <option value="Injury"
                                                        {{ $EHS->Incident_Sub_Type == 'Injury' ? 'selected' : '' }}>Injury
                                                    </option>
                                                    <option value="Barricade of Roads/Safety Means"
                                                        {{ $EHS->Incident_Sub_Type == 'Barricade of Roads/Safety Means' ? 'selected' : '' }}>
                                                        Barricade of Roads/Safety Means</option>
                                                    <option value="Break In"
                                                        {{ $EHS->Incident_Sub_Type == 'Break In' ? 'selected' : '' }}>Break
                                                        In</option>
                                                    <option value="Cuts/Stabs/Brushes"
                                                        {{ $EHS->Incident_Sub_Type == 'Cuts/Stabs/Brushes' ? 'selected' : '' }}>
                                                        Cuts/Stabs/Brushes</option>
                                                    <option value="Electricity"
                                                        {{ $EHS->Incident_Sub_Type == 'Electricity' ? 'selected' : '' }}>
                                                        Electricity</option>
                                                    <option value="Falling/Launched Parts"
                                                        {{ $EHS->Incident_Sub_Type == 'Falling/Launched Parts' ? 'selected' : '' }}>
                                                        Falling/Launched Parts</option>
                                                    <option value="Falling/Stumbling/Working On Height"
                                                        {{ $EHS->Incident_Sub_Type == 'Falling/Stumbling/Working On Height' ? 'selected' : '' }}>
                                                        Falling/Stumbling/Working On Height</option>
                                                    <option value="Fire Prevention Equipment/Fire"
                                                        {{ $EHS->Incident_Sub_Type == 'Fire Prevention Equipment/Fire' ? 'selected' : '' }}>
                                                        Fire Prevention Equipment/Fire</option>
                                                    <option value="Hazardous Substances"
                                                        {{ $EHS->Incident_Sub_Type == 'Hazardous Substances' ? 'selected' : '' }}>
                                                        Hazardous Substances</option>
                                                    <option value="Hot Substances/Parts"
                                                        {{ $EHS->Incident_Sub_Type == 'Hot Substances/Parts' ? 'selected' : '' }}>
                                                        Hot Substances/Parts</option>
                                                    <option value="Housekeeping"
                                                        {{ $EHS->Incident_Sub_Type == 'Housekeeping' ? 'selected' : '' }}>
                                                        Housekeeping</option>
                                                    <option value="Inappropriate Behaviour"
                                                        {{ $EHS->Incident_Sub_Type == 'Inappropriate Behaviour' ? 'selected' : '' }}>
                                                        Inappropriate Behaviour</option>
                                                    <option value="Lifting/Hoisting"
                                                        {{ $EHS->Incident_Sub_Type == 'Lifting/Hoisting' ? 'selected' : '' }}>
                                                        Lifting/Hoisting</option>
                                                    <option value="Lock Out/Tag Out/Safeguarding"
                                                        {{ $EHS->Incident_Sub_Type == 'Lock Out/Tag Out/Safeguarding' ? 'selected' : '' }}>
                                                        Lock Out/Tag Out/Safeguarding</option>
                                                    <option value="Maintenance/Inspection"
                                                        {{ $EHS->Incident_Sub_Type == 'Maintenance/Inspection' ? 'selected' : '' }}>
                                                        Maintenance/Inspection</option>
                                                    <option value="Physical Overload"
                                                        {{ $EHS->Incident_Sub_Type == 'Physical Overload' ? 'selected' : '' }}>
                                                        Physical Overload</option>
                                                    <option value="Property Damage"
                                                        {{ $EHS->Incident_Sub_Type == 'Property Damage' ? 'selected' : '' }}>
                                                        Property Damage</option>
                                                    <option value="Rotating Parts"
                                                        {{ $EHS->Incident_Sub_Type == 'Rotating Parts' ? 'selected' : '' }}>
                                                        Rotating Parts</option>
                                                    <option value="Spills"
                                                        {{ $EHS->Incident_Sub_Type == 'Spills' ? 'selected' : '' }}>Spills
                                                    </option>
                                                    <option value="Stolen Property"
                                                        {{ $EHS->Incident_Sub_Type == 'Stolen Property' ? 'selected' : '' }}>
                                                        Stolen Property</option>
                                                    <option value="Stucks"
                                                        {{ $EHS->Incident_Sub_Type == 'Stucks' ? 'selected' : '' }}>Stucks
                                                    </option>
                                                    <option value="Technical Failure"
                                                        {{ $EHS->Incident_Sub_Type == 'Technical Failure' ? 'selected' : '' }}>
                                                        Technical Failure</option>
                                                    <option value="Training"
                                                        {{ $EHS->Incident_Sub_Type == 'Training' ? 'selected' : '' }}>
                                                        Training</option>
                                                    <option value="Transport Equipment"
                                                        {{ $EHS->Incident_Sub_Type == 'Transport Equipment' ? 'selected' : '' }}>
                                                        Transport Equipment</option>
                                                    <option value="Vandalism"
                                                        {{ $EHS->Incident_Sub_Type == 'Vandalism' ? 'selected' : '' }}>
                                                        Vandalism</option>
                                                    <option value="Work Permits/TRA/LRMA"
                                                        {{ $EHS->Incident_Sub_Type == 'Work Permits/TRA/LRMA' ? 'selected' : '' }}>
                                                        Work Permits/TRA/LRMA</option>
                                                    <option value="Work-related Illness"
                                                        {{ $EHS->Incident_Sub_Type == 'Work-related Illness' ? 'selected' : '' }}>
                                                        Work-related Illness</option>
                                                    <option value="Other Environmental"
                                                        {{ $EHS->Incident_Sub_Type == 'Other Environmental' ? 'selected' : '' }}>
                                                        Other Environmental</option>
                                                    <option value="Other"
                                                        {{ $EHS->Incident_Sub_Type == 'Other' ? 'selected' : '' }}>Other
                                                    </option>

                                                </select>
                                            </div>
                                        </div>

                                        <div><small class="text-primary">Event Date And time</small></div>

                                        <div class="col-lg-6 new-date-data-field">
                                            <div class="group-input input-date">
                                                <label for="Date Occurred">Date Occurred</label>
                                                <div class="calenderauditee">
                                                    <input type="text" id="Date_Occurred" readonly
                                                        placeholder="DD-MMM-YYYY"
                                                        value="{{ Helpers::getdateFormat($EHS->Date_Occurred) }}"
                                                        {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }} />
                                                    <input type="date" id="Date_Occurred_checkdate"
                                                        name="Date_Occurred"
                                                        max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                                        {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}
                                                        value="{{ $EHS->Date_Occurred }}" class="hide-input"
                                                        oninput="handleDateInput(this, 'Date_Occurred');checkDate('Date_Occurred_checkdate','Date_Occurred1_checkdate')" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Time Occurred">Time Occurred</label>
                                                <input type="time" name="Time_Occurred" id="Time_Occurred"
                                                    value="{{ $EHS->Time_Occurred }}"
                                                    {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Attached File">Attached File</label>
                                                <div><small class="text-primary">Please Attach all relevant or supporting
                                                        documents</small></div>

                                                <div class="file-attachment-field">
                                                    <div class="file-attachment-list" id="Attached_File">
                                                        @if ($EHS->Attached_File)
                                                            @foreach (json_decode($EHS->Attached_File) as $file)
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
                                                        <input {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}
                                                            type="file" id="myfile" name="Attached_File[]"
                                                            oninput="addMultipleFiles(this, 'Attached_File')" multiple>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Similar Incidents">Similar Incidents</label>
                                                <select name="Similar_Incidents" id="Similar_Incidents"
                                                    data-search="false" data-silent-initial-value-set="true"
                                                    {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>
                                                    <option value="">-- Select --</option>
                                                    <option value="Yes"
                                                        {{ $EHS->Similar_Incidents == 'Yes' ? 'selected' : '' }}>Yes
                                                    </option>
                                                    <option value="No"
                                                        {{ $EHS->Similar_Incidents == 'No' ? 'selected' : '' }}>No</option>
                                                    <option value="Na"
                                                        {{ $EHS->Similar_Incidents == 'Na' ? 'selected' : '' }}>Na</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 new-date-data-field">
                                            <div class="group-input input-date">
                                                <label for="Date Of Reporting">Date Of Reporting</label>
                                                <div class="calenderauditee">
                                                    <input type="text" id="Date_Of_Reporting" readonly
                                                        placeholder="DD-MMM-YYYY"
                                                        value="{{ Helpers::getdateFormat($EHS->Date_Of_Reporting) }}"
                                                        {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }} />
                                                    <input type="date" id="Date_Of_Reporting_checkdate"
                                                        name="Date_Of_Reporting"
                                                        max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                                        {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}
                                                        value="{{ $EHS->Date_Of_Reporting }}" class="hide-input"
                                                        oninput="handleDateInput(this, 'Date_Of_Reporting');checkDate('Date_Of_Reporting_checkdate','Date_Of_Reporting1_checkdate')" />
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-6">
                                            <div class="group-input">
                                                <label for="Reporter">Reporter</label>
                                                <select id="Reporter" placeholder="Select..." name="Reporter"
                                                    {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>
                                                    <option value="">-- Select --</option>
                                                    @foreach ($users as $key => $value)
                                                        <option value="{{ $value->id }}"
                                                            @if ($data->Reporter == $value->id) selected @endif>
                                                            {{ $value->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>


                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Description">Description</label>
                                                <div class="relative-container">
                                                    <textarea name="Description" id="Description" {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>{{ $EHS->Description }}</textarea>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Immediate Actions">Immediate Actions</label>
                                                <div class="relative-container">
                                                    <textarea name="Immediate_Actions" id="Immediate_Actions"
                                                        {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>{{ $EHS->Immediate_Actions }}</textarea>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="button-block">
                                        <button type="submit" id="ChangesaveButton" class="saveButton">Save</button>
                                        <button type="button" id="ChangeNextButton" class="nextButton">Next</button>
                                        <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}"
                                                class="text-white">
                                                Exit </a> </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Audit Planning content -->
                            <div id="CCForm2" class="inner-block cctabcontent">
                                <div class="inner-block-content">
                                    <div class="row">

                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Accident Type">Accident Type</label>
                                                <select name="Accident_Type" id="Accident_Type" data-search="false"
                                                    data-silent-initial-value-set="true"
                                                    {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>
                                                    <option value="">-- Select --</option>
                                                    <option value="Fatality"
                                                        {{ $EHS->Accident_Type == 'Fatality' ? 'selected' : '' }}>Fatality
                                                    </option>
                                                    <option value="First Aid"
                                                        {{ $EHS->Accident_Type == 'First Aid' ? 'selected' : '' }}>First
                                                        Aid</option>
                                                    <option value="Lost Time Injury"
                                                        {{ $EHS->Accident_Type == 'Lost Time Injury' ? 'selected' : '' }}>
                                                        Lost Time Injury</option>
                                                    <option value="Medical Treatment"
                                                        {{ $EHS->Accident_Type == 'Medical Treatment' ? 'selected' : '' }}>
                                                        Medical Treatment</option>
                                                    <option value="Restricted Work"
                                                        {{ $EHS->Accident_Type == 'Restricted Work' ? 'selected' : '' }}>
                                                        Restricted Work</option>
                                                    <option value="Other"
                                                        {{ $EHS->Accident_Type == 'Other' ? 'selected' : '' }}>Other
                                                    </option>
                                                    <option value="Na"
                                                        {{ $EHS->Accident_Type == 'Na' ? 'selected' : '' }}>Na</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="OSHA Reportable">OSHA Reportable</label>
                                                <select name="OSHA_Reportable" id="OSHA_Reportable" data-search="false"
                                                    data-silent-initial-value-set="true"
                                                    {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>
                                                    <option value="">-- Select --</option>
                                                    <option value="Yes"
                                                        {{ $EHS->OSHA_Reportable == 'Yes' ? 'selected' : '' }}>Yes
                                                    </option>
                                                    <option value="No"
                                                        {{ $EHS->OSHA_Reportable == 'No' ? 'selected' : '' }}>No</option>
                                                    <option value="Na"
                                                        {{ $EHS->OSHA_Reportable == 'Na' ? 'selected' : '' }}>Na</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 new-date-data-field">
                                            <div class="group-input input-date">
                                                <label for="First Lost Work Date">First Lost Work Date</label>
                                                <div class="calenderauditee">
                                                    <input type="text" id="First_Lost_Work_Date" readonly
                                                        placeholder="DD-MMM-YYYY"
                                                        value="{{ Helpers::getdateFormat($EHS->First_Lost_Work_Date) }}"
                                                        {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }} />
                                                    <input type="date" id="First_Lost_Work_Date_checkdate"
                                                        name="First_Lost_Work_Date"
                                                        {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}
                                                        value="{{ $data->First_Lost_Work_Date }}" class="hide-input"
                                                        oninput="handleDateInput(this, 'First_Lost_Work_Date');checkDate('First_Lost_Work_Date_checkdate','Last_Lost_Work_Date_checkdate')" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 new-date-data-field">
                                            <div class="group-input  input-date">
                                                <label for="Last Lost Work Date">Last Lost Work Date</label>
                                                <div class="calenderauditee">
                                                    <input type="text" id="Last_Lost_Work_Date" readonly
                                                        placeholder="DD-MMM-YYYY"
                                                        value="{{ Helpers::getdateFormat($EHS->Last_Lost_Work_Date) }}"
                                                        {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }} />
                                                    <input type="date" id="Last_Lost_Work_Date_checkdate"
                                                        name="Last_Lost_Work_Date"
                                                        {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}
                                                        value="{{ $data->Last_Lost_Work_Date }}" class="hide-input"
                                                        oninput="handleDateInput(this, 'Last_Lost_Work_Date');checkDate('First_Lost_Work_Date_checkdate','Last_Lost_Work_Date_checkdate')" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 new-date-data-field">
                                            <div class="group-input input-date">
                                                <label for="First Restricted Work Date">First Restricted Work Date</label>
                                                <div class="calenderauditee">
                                                    <input type="text" id="First_Restricted_Work_Date" readonly
                                                        placeholder="DD-MMM-YYYY"
                                                        value="{{ Helpers::getdateFormat($EHS->First_Restricted_Work_Date) }}"
                                                        {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }} />
                                                    <input type="date" id="First_Restricted_Work_Date_checkdate"
                                                        name="First_Restricted_Work_Date"
                                                        {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}
                                                        value="{{ $EHS->First_Restricted_Work_Date }}"
                                                        class="hide-input"
                                                        oninput="handleDateInput(this, 'First_Restricted_Work_Date');checkDate('First_Restricted_Work_Date_checkdate','Last_Restricted_Work_Date_checkdate')" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 new-date-data-field">
                                            <div class="group-input  input-date">
                                                <label for="Last Restricted Work Date">Last Restricted Work Date</label>
                                                <div class="calenderauditee">
                                                    <input type="text" id="Last_Restricted_Work_Date" readonly
                                                        placeholder="DD-MMM-YYYY"
                                                        value="{{ Helpers::getdateFormat($EHS->Last_Restricted_Work_Date) }}"
                                                        {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }} />
                                                    <input type="date" id="Last_Restricted_Work_Date_checkdate"
                                                        name="Last_Restricted_Work_Date"
                                                        {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}
                                                        value="{{ $EHS->Last_Restricted_Work_Date }}" class="hide-input"
                                                        oninput="handleDateInput(this, 'Last_Restricted_Work_Date');checkDate('First_Restricted_Work_Date_checkdate','Last_Restricted_Work_Date_checkdate')" />
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Vehicle Type">Vehicle Type</label>
                                                <select name="Vehicle_Type" id="Vehicle_Type" data-search="false"
                                                    data-silent-initial-value-set="true"
                                                    {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>
                                                    <option value="">-- Select --</option>
                                                    <option value="Alfa Romeo"
                                                        {{ $EHS->Vehicle_Type == 'Alfa Romeo' ? 'selected' : '' }}>Alfa
                                                        Romeo</option>
                                                    <option value="Asquith"
                                                        {{ $EHS->Vehicle_Type == 'Asquith' ? 'selected' : '' }}>Asquith
                                                    </option>
                                                    <option value="Audi"
                                                        {{ $EHS->Vehicle_Type == 'Audi' ? 'selected' : '' }}>Audi</option>
                                                    <option value="Aston Martin"
                                                        {{ $EHS->Vehicle_Type == 'Aston Martin' ? 'selected' : '' }}>Aston
                                                        Martin</option>
                                                    <option value="Bentley"
                                                        {{ $EHS->Vehicle_Type == 'Bentley' ? 'selected' : '' }}>Bentley
                                                    </option>
                                                    <option value="BMW"
                                                        {{ $EHS->Vehicle_Type == 'BMW' ? 'selected' : '' }}>BMW</option>
                                                    <option value="British Leyland"
                                                        {{ $EHS->Vehicle_Type == 'British Leyland' ? 'selected' : '' }}>
                                                        British Leyland</option>
                                                    <option value="Buick"
                                                        {{ $EHS->Vehicle_Type == 'Buick' ? 'selected' : '' }}>Buick
                                                    </option>
                                                    <option value="Cadillac"
                                                        {{ $EHS->Vehicle_Type == 'Cadillac' ? 'selected' : '' }}>Cadillac
                                                    </option>
                                                    <option value="Chevrolet"
                                                        {{ $EHS->Vehicle_Type == 'Chevrolet' ? 'selected' : '' }}>
                                                        Chevrolet</option>
                                                    <option value="Chrysler"
                                                        {{ $EHS->Vehicle_Type == 'Chrysler' ? 'selected' : '' }}>Chrysler
                                                    </option>
                                                    <option value="Citroën"
                                                        {{ $EHS->Vehicle_Type == 'Citroën' ? 'selected' : '' }}>Citroën
                                                    </option>
                                                    <option value="Daewoo"
                                                        {{ $EHS->Vehicle_Type == 'Daewoo' ? 'selected' : '' }}>Daewoo
                                                    </option>
                                                    <option value="Daf"
                                                        {{ $EHS->Vehicle_Type == 'Daf' ? 'selected' : '' }}>Daf</option>
                                                    <option value="Daihatsu"
                                                        {{ $EHS->Vehicle_Type == 'Daihatsu' ? 'selected' : '' }}>Daihatsu
                                                    </option>
                                                    <option value="Daimler"
                                                        {{ $EHS->Vehicle_Type == 'Daimler' ? 'selected' : '' }}>Daimler
                                                    </option>
                                                    <option value="Dodge"
                                                        {{ $EHS->Vehicle_Type == 'Dodge' ? 'selected' : '' }}>Dodge
                                                    </option>
                                                    <option value="Ferrari"
                                                        {{ $EHS->Vehicle_Type == 'Ferrari' ? 'selected' : '' }}>Ferrari
                                                    </option>
                                                    <option value="Fiat"
                                                        {{ $EHS->Vehicle_Type == 'Fiat' ? 'selected' : '' }}>Fiat</option>
                                                    <option value="Ford"
                                                        {{ $EHS->Vehicle_Type == 'Ford' ? 'selected' : '' }}>Ford</option>
                                                    <option value="Genesis"
                                                        {{ $EHS->Vehicle_Type == 'Genesis' ? 'selected' : '' }}>Genesis
                                                    </option>
                                                    <option value="GMC"
                                                        {{ $EHS->Vehicle_Type == 'GMC' ? 'selected' : '' }}>GMC</option>
                                                    <option value="Honda"
                                                        {{ $EHS->Vehicle_Type == 'Honda' ? 'selected' : '' }}>Honda
                                                    </option>
                                                    <option value="Hummer"
                                                        {{ $EHS->Vehicle_Type == 'Hummer' ? 'selected' : '' }}>Hummer
                                                    </option>
                                                    <option value="Hyundai"
                                                        {{ $EHS->Vehicle_Type == 'Hyundai' ? 'selected' : '' }}>Hyundai
                                                    </option>
                                                    <option value="Infiniti"
                                                        {{ $EHS->Vehicle_Type == 'Infiniti' ? 'selected' : '' }}>Infiniti
                                                    </option>
                                                    <option value="Isuzu"
                                                        {{ $EHS->Vehicle_Type == 'Isuzu' ? 'selected' : '' }}>Isuzu
                                                    </option>
                                                    <option value="Jaguar"
                                                        {{ $EHS->Vehicle_Type == 'Jaguar' ? 'selected' : '' }}>Jaguar
                                                    </option>
                                                    <option value="Jeep"
                                                        {{ $EHS->Vehicle_Type == 'Jeep' ? 'selected' : '' }}>Jeep</option>
                                                    <option value="Kia"
                                                        {{ $EHS->Vehicle_Type == 'Kia' ? 'selected' : '' }}>Kia</option>
                                                    <option value="Koenigsegg"
                                                        {{ $EHS->Vehicle_Type == 'Koenigsegg' ? 'selected' : '' }}>
                                                        Koenigsegg</option>
                                                    <option value="Lamborghini"
                                                        {{ $EHS->Vehicle_Type == 'Lamborghini' ? 'selected' : '' }}>
                                                        Lamborghini</option>
                                                    <option value="Land Rover"
                                                        {{ $EHS->Vehicle_Type == 'Land Rover' ? 'selected' : '' }}>Land
                                                        Rover</option>
                                                    <option value="Lexus"
                                                        {{ $EHS->Vehicle_Type == 'Lexus' ? 'selected' : '' }}>Lexus
                                                    </option>
                                                    <option value="Lincoln"
                                                        {{ $EHS->Vehicle_Type == 'Lincoln' ? 'selected' : '' }}>Lincoln
                                                    </option>
                                                    <option value="Lotus"
                                                        {{ $EHS->Vehicle_Type == 'Lotus' ? 'selected' : '' }}>Lotus
                                                    </option>
                                                    <option value="Maserati"
                                                        {{ $EHS->Vehicle_Type == 'Maserati' ? 'selected' : '' }}>Maserati
                                                    </option>
                                                    <option value="Mazda"
                                                        {{ $EHS->Vehicle_Type == 'Mazda' ? 'selected' : '' }}>Mazda
                                                    </option>
                                                    <option value="McLaren"
                                                        {{ $EHS->Vehicle_Type == 'McLaren' ? 'selected' : '' }}>McLaren
                                                    </option>
                                                    <option value="Mercedes-Benz"
                                                        {{ $EHS->Vehicle_Type == 'Mercedes-Benz' ? 'selected' : '' }}>
                                                        Mercedes-Benz</option>
                                                    <option value="Mini"
                                                        {{ $EHS->Vehicle_Type == 'Mini' ? 'selected' : '' }}>Mini</option>
                                                    <option value="Mitsubishi"
                                                        {{ $EHS->Vehicle_Type == 'Mitsubishi' ? 'selected' : '' }}>
                                                        Mitsubishi</option>
                                                    <option value="Nissan"
                                                        {{ $EHS->Vehicle_Type == 'Nissan' ? 'selected' : '' }}>Nissan
                                                    </option>
                                                    <option value="Pagani"
                                                        {{ $EHS->Vehicle_Type == 'Pagani' ? 'selected' : '' }}>Pagani
                                                    </option>
                                                    <option value="Peugeot"
                                                        {{ $EHS->Vehicle_Type == 'Peugeot' ? 'selected' : '' }}>Peugeot
                                                    </option>
                                                    <option value="Porsche"
                                                        {{ $EHS->Vehicle_Type == 'Porsche' ? 'selected' : '' }}>Porsche
                                                    </option>
                                                    <option value="Ram"
                                                        {{ $EHS->Vehicle_Type == 'Ram' ? 'selected' : '' }}>Ram</option>
                                                    <option value="Renault"
                                                        {{ $EHS->Vehicle_Type == 'Renault' ? 'selected' : '' }}>Renault
                                                    </option>
                                                    <option value="Rolls-Royce"
                                                        {{ $EHS->Vehicle_Type == 'Rolls-Royce' ? 'selected' : '' }}>
                                                        Rolls-Royce</option>
                                                    <option value="Saab"
                                                        {{ $EHS->Vehicle_Type == 'Saab' ? 'selected' : '' }}>Saab</option>
                                                    <option value="Scion"
                                                        {{ $EHS->Vehicle_Type == 'Scion' ? 'selected' : '' }}>Scion
                                                    </option>
                                                    <option value="Seat"
                                                        {{ $EHS->Vehicle_Type == 'Seat' ? 'selected' : '' }}>Seat</option>
                                                    <option value="Škoda"
                                                        {{ $EHS->Vehicle_Type == 'Škoda' ? 'selected' : '' }}>Škoda
                                                    </option>
                                                    <option value="Smart"
                                                        {{ $EHS->Vehicle_Type == 'Smart' ? 'selected' : '' }}>Smart
                                                    </option>
                                                    <option value="Subaru"
                                                        {{ $EHS->Vehicle_Type == 'Subaru' ? 'selected' : '' }}>Subaru
                                                    </option>
                                                    <option value="Suzuki"
                                                        {{ $EHS->Vehicle_Type == 'Suzuki' ? 'selected' : '' }}>Suzuki
                                                    </option>
                                                    <option value="Tata"
                                                        {{ $EHS->Vehicle_Type == 'Tata' ? 'selected' : '' }}>Tata</option>
                                                    <option value="Tesla"
                                                        {{ $EHS->Vehicle_Type == 'Tesla' ? 'selected' : '' }}>Tesla
                                                    </option>
                                                    <option value="Toyota"
                                                        {{ $EHS->Vehicle_Type == 'Toyota' ? 'selected' : '' }}>Toyota
                                                    </option>
                                                    <option value="Volkswagen"
                                                        {{ $EHS->Vehicle_Type == 'Volkswagen' ? 'selected' : '' }}>
                                                        Volkswagen</option>
                                                    <option value="Volvo"
                                                        {{ $EHS->Vehicle_Type == 'Volvo' ? 'selected' : '' }}>Volvo
                                                    </option>
                                                    <option value="Zenvo"
                                                        {{ $EHS->Vehicle_Type == 'Zenvo' ? 'selected' : '' }}>Zenvo
                                                    </option>
                                                    <option value="Other"
                                                        {{ $EHS->Vehicle_Type == 'Other' ? 'selected' : '' }}>Other
                                                    </option>

                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Vehicle Number">Vehicle Number</label>
                                                <input type="text" name="Vehicle_Number"
                                                    value="{{ $EHS->Vehicle_Number }}">
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Litigation">Litigation</label>
                                                <select name="Litigation" id="Litigation" data-search="false"
                                                    data-silent-initial-value-set="true"
                                                    {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>
                                                    <option value="">-- Select --</option>
                                                    <option value="Yes"
                                                        {{ $EHS->Litigation == 'Yes' ? 'selected' : '' }}>Yes</option>
                                                    <option value="No"
                                                        {{ $EHS->Litigation == 'No' ? 'selected' : '' }}>No</option>
                                                    <option value="Na"
                                                        {{ $EHS->Litigation == 'Na' ? 'selected' : '' }}>Na</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Department">Department</label>
                                                <select name="Department" id="Department" data-search="false"
                                                    data-silent-initial-value-set="true"
                                                    {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>
                                                    <option value="">-- Select --</option>
                                                    <option value="Calibration Lab"
                                                        {{ $EHS->Department == 'Calibration Lab' ? 'selected' : '' }}>
                                                        Calibration Lab</option>
                                                    <option value="Engineering"
                                                        {{ $EHS->Department == 'Engineering' ? 'selected' : '' }}>
                                                        Engineering</option>
                                                    <option value="Facilities"
                                                        {{ $EHS->Department == 'Facilities' ? 'selected' : '' }}>
                                                        Facilities</option>
                                                    <option value="Lab"
                                                        {{ $EHS->Department == 'Lab' ? 'selected' : '' }}>Lab</option>
                                                    <option value="Labeling"
                                                        {{ $EHS->Department == 'Labeling' ? 'selected' : '' }}>Labeling
                                                    </option>
                                                    <option value="Manufacturing"
                                                        {{ $EHS->Department == 'Manufacturing' ? 'selected' : '' }}>
                                                        Manufacturing</option>
                                                    <option value="Quality Assurance"
                                                        {{ $EHS->Department == 'Quality Assurance' ? 'selected' : '' }}>
                                                        Quality Assurance</option>
                                                    <option value="Quality Control"
                                                        {{ $EHS->Department == 'Quality Control' ? 'selected' : '' }}>
                                                        Quality Control</option>
                                                    <option value="Regulatory Affairs"
                                                        {{ $EHS->Department == 'Regulatory Affairs' ? 'selected' : '' }}>
                                                        Regulatory Affairs</option>
                                                    <option value="Security"
                                                        {{ $EHS->Department == 'Security' ? 'selected' : '' }}>Security
                                                    </option>
                                                    <option value="Training"
                                                        {{ $EHS->Department == 'Training' ? 'selected' : '' }}>Training
                                                    </option>
                                                    <option value="IT"
                                                        {{ $EHS->Department == 'IT' ? 'selected' : '' }}>IT</option>
                                                    <option value="Application Engineering"
                                                        {{ $EHS->Department == 'Application Engineering' ? 'selected' : '' }}>
                                                        Application Engineering</option>
                                                    <option value="Trading"
                                                        {{ $EHS->Department == 'Trading' ? 'selected' : '' }}>Trading
                                                    </option>
                                                    <option value="Research"
                                                        {{ $EHS->Department == 'Research' ? 'selected' : '' }}>Research
                                                    </option>
                                                    <option value="Sales"
                                                        {{ $EHS->Department == 'Sales' ? 'selected' : '' }}>Sales</option>
                                                    <option value="Finance"
                                                        {{ $EHS->Department == 'Finance' ? 'selected' : '' }}>Finance
                                                    </option>
                                                    <option value="Systems"
                                                        {{ $EHS->Department == 'Systems' ? 'selected' : '' }}>Systems
                                                    </option>
                                                    <option value="Administrative"
                                                        {{ $EHS->Department == 'Administrative' ? 'selected' : '' }}>
                                                        Administrative</option>
                                                    <option value="M&A"
                                                        {{ $EHS->Department == 'M&A' ? 'selected' : '' }}>M&A</option>
                                                    <option value="R&D"
                                                        {{ $EHS->Department == 'R&D' ? 'selected' : '' }}>R&D</option>
                                                    <option value="Human Resources"
                                                        {{ $EHS->Department == 'Human Resources' ? 'selected' : '' }}>
                                                        Human Resources</option>
                                                    <option value="Banking"
                                                        {{ $EHS->Department == 'Banking' ? 'selected' : '' }}>Banking
                                                    </option>
                                                    <option value="Marketing"
                                                        {{ $EHS->Department == 'Marketing' ? 'selected' : '' }}>Marketing
                                                    </option>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="sub-head">
                                            Involved Persons
                                        </div>
                                        <div class="col-md-6">
                                            <div class="group-input">
                                                <label for="Employees Involved">Employees Involved</label>
                                                <select id="Employees_Involved" placeholder="Select..."
                                                    name="Employees_Involved"
                                                    {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>
                                                    <option value="">-- Select --</option>
                                                    @foreach ($users as $key => $value)
                                                        <option value="{{ $value->id }}"
                                                            @if ($data->Employees_Involved == $value->id) selected @endif>
                                                            {{ $value->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="group-input">
                                                <label for="Involved Contractors">Involved Contractors</label>
                                                <select id="Involved_Contractors" placeholder="Select..."
                                                    name="Involved_Contractors"
                                                    {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>
                                                    <option value="">-- Select --</option>
                                                    @foreach ($users as $key => $value)
                                                        <option value="{{ $value->id }}"
                                                            @if ($data->Involved_Contractors == $value->id) selected @endif>
                                                            {{ $value->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="group-input">
                                                <label for="Attorneys Involved">Attorneys Involved</label>
                                                <select id="Attorneys_Involved" placeholder="Select..."
                                                    name="Attorneys_Involved"
                                                    {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>
                                                    <option value="">-- Select --</option>
                                                    @foreach ($users as $key => $value)
                                                        <option value="{{ $value->id }}"
                                                            @if ($data->Attorneys_Involved == $value->id) selected @endif>
                                                            {{ $value->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="root_cause">
                                                    Witnesses Information
                                                    <button type="button"
                                                        {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}
                                                        name="audit-incident-grid"
                                                        id="Witnesses_Information_Add">+</button>
                                                    <span class="text-primary" data-bs-toggle="modal"
                                                        data-bs-target="#observation-field-instruction-modal"
                                                        style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                                        (Launch Instruction)
                                                    </span>
                                                </label>

                                                <table class="table table-bordered"
                                                    id="Witnesses_Information_Add_field_table">
                                                    <thead>
                                                        <tr>
                                                            <th>Row#</th>
                                                            <th>Witness Name</th>
                                                            <th>Witness Type</th>
                                                            <th>Item Description</th>
                                                            <th>Comment</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                            $serialNumber = 1;
                                                        @endphp
                                                        @foreach ($WitnessesInfo->data1 as $oogrid)
                                                            <tr>
                                                                <td disabled>{{ $serialNumber++ }}</td>
                                                                <td>
                                                                    <input type="text"
                                                                        {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}
                                                                        name="WitnessesInformation[{{ $loop->index }}][Witness_Name]"
                                                                        value="{{ $oogrid['Witness_Name'] }}">
                                                                </td>
                                                                <td>
                                                                    <input type="text"
                                                                        {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}
                                                                        name="WitnessesInformation[{{ $loop->index }}][Witness_Type]"
                                                                        value="{{ $oogrid['Witness_Type'] }}">
                                                                </td>
                                                                <td>
                                                                    <input type="text"
                                                                        {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}
                                                                        name="WitnessesInformation[{{ $loop->index }}][Item_Description]"
                                                                        value="{{ $oogrid['Item_Description'] }}">
                                                                </td>
                                                                <td>
                                                                    <input type="text"
                                                                        {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}
                                                                        name="WitnessesInformation[{{ $loop->index }}][Comment]"
                                                                        value="{{ $oogrid['Comment'] }}">
                                                                </td>

                                                                <td>
                                                                    <button class="removeRowBtn"
                                                                        {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>Remove</button>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <script>
                                            $(document).ready(function() {
                                                let investdetails = 1;
                                                $('#Witnesses_Information_Add').click(function(e) {
                                                    function generateTableRow(serialNumber) {
                                                        var html =
                                                            '<tr>' +
                                                            '<td><input disabled type="text" style ="width:15px" value="' + serialNumber +
                                                            '"></td>' +
                                                            '<td><input type="text"  {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}  name="WitnessesInformation[' +
                                                            investdetails + '][Witness_Name]" value=""></td>' +
                                                            '<td><input type="text"  {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}  name="WitnessesInformation[' +
                                                            investdetails + '][Witness_Type]" value=""></td>' +
                                                            '<td><input type="text"  {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }} name="WitnessesInformation[' +
                                                            investdetails + '][Item_Description]" value=""></td>' +
                                                            '<td><input type="text"  {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}  name="WitnessesInformation[' +
                                                            investdetails + '][Comment]" value=""></td>' +
                                                            '<td><button class="removeRowBtn"  {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>Remove</button>' +

                                                            '</tr>';
                                                        investdetails++; // Increment the row number here
                                                        return html;
                                                    }

                                                    var tableBody = $('#Witnesses_Information_Add_field_table tbody');
                                                    var rowCount = tableBody.children('tr').length;
                                                    var newRow = generateTableRow(rowCount + 1);
                                                    tableBody.append(newRow);
                                                });
                                                $(document).on('click', '.removeRowBtn', function() {
                                                    $(this).closest('tr').remove();
                                                });
                                            });
                                        </script>


                                        <div class="col-md-6">
                                            <div class="group-input">
                                                <label for="Lead Investigator">Lead Investigator</label>
                                                <select id="Lead_Investigator" placeholder="Select..."
                                                    name="Lead_Investigator"
                                                    {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>
                                                    <option value="">-- Select --</option>
                                                    @foreach ($users as $key => $value)
                                                        <option value="{{ $value->id }}"
                                                            @if ($data->Lead_Investigator == $value->id) selected @endif>
                                                            {{ $value->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="group-input">
                                                <label for="Line Operator">Line Operator</label>
                                                <select id="Line_Operator" placeholder="Select..." name="Line_Operator"
                                                    {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>
                                                    <option value="">-- Select --</option>
                                                    @foreach ($users as $key => $value)
                                                        <option value="{{ $value->id }}"
                                                            @if ($data->Line_Operator == $value->id) selected @endif>
                                                            {{ $value->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="group-input">
                                                <label for="Reporter">Reporter</label>
                                                <select id="Reporter2" placeholder="Select..." name="Reporter2"
                                                    {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>
                                                    <option value="">-- Select --</option>
                                                    @foreach ($users as $key => $value)
                                                        <option value="{{ $value->id }}"
                                                            @if ($data->Reporter2 == $value->id) selected @endif>
                                                            {{ $value->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="group-input">
                                                <label for="Supervisor">Supervisor</label>
                                                <select id="Supervisor" placeholder="Select..." name="Supervisor"
                                                    {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>
                                                    <option value="">-- Select --</option>
                                                    @foreach ($users as $key => $value)
                                                        <option value="{{ $value->id }}"
                                                            @if ($data->Supervisor == $value->id) selected @endif>
                                                            {{ $value->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="sub-head">
                                            Near Miss And Measures
                                        </div>
                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Unsafe Situation">Unsafe Situation</label>
                                                <select name="Unsafe_Situation" id="Unsafe_Situation" data-search="false"
                                                    data-silent-initial-value-set="true"
                                                    {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>
                                                    <option value="">-- Select --</option>
                                                    <option value="Yes"
                                                        {{ $EHS->Unsafe_Situation == 'Yes' ? 'selected' : '' }}>Yes
                                                    </option>
                                                    <option value="No"
                                                        {{ $EHS->Unsafe_Situation == 'No' ? 'selected' : '' }}>No</option>
                                                    <option value="Na"
                                                        {{ $EHS->Unsafe_Situation == 'Na' ? 'selected' : '' }}>Na</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Safeguarding Measure Taken">Safeguarding Measure Taken</label>
                                                <select name="Safeguarding_Measure_Taken" id="Safeguarding_Measure_Taken"
                                                    data-search="false" data-silent-initial-value-set="true"
                                                    {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>
                                                    <option value="">-- Select --</option>
                                                    <option value="Company Rules"
                                                        {{ $EHS->Safeguarding_Measure_Taken == 'Company Rules' ? 'selected' : '' }}>
                                                        Company Rules</option>
                                                    <option value="Design and Modification"
                                                        {{ $EHS->Safeguarding_Measure_Taken == 'Design and Modification' ? 'selected' : '' }}>
                                                        Design and Modification</option>
                                                    <option value="Emergency Planning"
                                                        {{ $EHS->Safeguarding_Measure_Taken == 'Emergency Planning' ? 'selected' : '' }}>
                                                        Emergency Planning</option>
                                                    <option value="General Promotion"
                                                        {{ $EHS->Safeguarding_Measure_Taken == 'General Promotion' ? 'selected' : '' }}>
                                                        General Promotion</option>
                                                    <option value="Incident Analysis"
                                                        {{ $EHS->Safeguarding_Measure_Taken == 'Incident Analysis' ? 'selected' : '' }}>
                                                        Incident Analysis</option>
                                                    <option value="Incident Investigation"
                                                        {{ $EHS->Safeguarding_Measure_Taken == 'Incident Investigation' ? 'selected' : '' }}>
                                                        Incident Investigation</option>
                                                    <option value="Individual Communication"
                                                        {{ $EHS->Safeguarding_Measure_Taken == 'Individual Communication' ? 'selected' : '' }}>
                                                        Individual Communication</option>
                                                    <option value="Management Training"
                                                        {{ $EHS->Safeguarding_Measure_Taken == 'Management Training' ? 'selected' : '' }}>
                                                        Management Training</option>
                                                    <option value="Occupational Health"
                                                        {{ $EHS->Safeguarding_Measure_Taken == 'Occupational Health' ? 'selected' : '' }}>
                                                        Occupational Health</option>
                                                    <option value="Personal Protection"
                                                        {{ $EHS->Safeguarding_Measure_Taken == 'Personal Protection' ? 'selected' : '' }}>
                                                        Personal Protection</option>
                                                    <option value="Planning of Inspections"
                                                        {{ $EHS->Safeguarding_Measure_Taken == 'Planning of Inspections' ? 'selected' : '' }}>
                                                        Planning of Inspections</option>
                                                    <option value="Planning of Task Observations"
                                                        {{ $EHS->Safeguarding_Measure_Taken == 'Planning of Task Observations' ? 'selected' : '' }}>
                                                        Planning of Task Observations</option>
                                                    <option value="Policy"
                                                        {{ $EHS->Safeguarding_Measure_Taken == 'Policy' ? 'selected' : '' }}>
                                                        Policy</option>
                                                    <option value="Positioning"
                                                        {{ $EHS->Safeguarding_Measure_Taken == 'Positioning' ? 'selected' : '' }}>
                                                        Positioning</option>
                                                    <option value="Procedures and Task Analysis"
                                                        {{ $EHS->Safeguarding_Measure_Taken == 'Procedures and Task Analysis' ? 'selected' : '' }}>
                                                        Procedures and Task Analysis</option>
                                                    <option value="Procurement Procedure"
                                                        {{ $EHS->Safeguarding_Measure_Taken == 'Procurement Procedure' ? 'selected' : '' }}>
                                                        Procurement Procedure</option>
                                                    <option value="Program Evaluation"
                                                        {{ $EHS->Safeguarding_Measure_Taken == 'Program Evaluation' ? 'selected' : '' }}>
                                                        Program Evaluation</option>
                                                    <option value="Safety Meetings"
                                                        {{ $EHS->Safeguarding_Measure_Taken == 'Safety Meetings' ? 'selected' : '' }}>
                                                        Safety Meetings</option>
                                                    <option value="Safety Out of Work"
                                                        {{ $EHS->Safeguarding_Measure_Taken == 'Safety Out of Work' ? 'selected' : '' }}>
                                                        Safety Out of Work</option>
                                                    <option value="Training of Employees"
                                                        {{ $EHS->Safeguarding_Measure_Taken == 'Training of Employees' ? 'selected' : '' }}>
                                                        Training of Employees</option>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="sub-head">
                                            Environmental Information
                                        </div>
                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Environmental Category">Environmental Category</label>
                                                <select name="Environmental_Category" id="Environmental_Category"
                                                    data-search="false" data-silent-initial-value-set="true"
                                                    {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>
                                                    <option value="">-- Select --</option>
                                                    <option value="Air"
                                                        {{ $EHS->Environmental_Category == 'Air' ? 'selected' : '' }}>Air
                                                    </option>
                                                    <option value="Dust"
                                                        {{ $EHS->Environmental_Category == 'Dust' ? 'selected' : '' }}>
                                                        Dust</option>
                                                    <option value="Noise"
                                                        {{ $EHS->Environmental_Category == 'Noise' ? 'selected' : '' }}>
                                                        Noise</option>
                                                    <option value="Smell"
                                                        {{ $EHS->Environmental_Category == 'Smell' ? 'selected' : '' }}>
                                                        Smell</option>
                                                    <option value="Soil"
                                                        {{ $EHS->Environmental_Category == 'Soil' ? 'selected' : '' }}>
                                                        Soil</option>
                                                    <option value="Water"
                                                        {{ $EHS->Environmental_Category == 'Water' ? 'selected' : '' }}>
                                                        Water</option>
                                                    <option value="N/A"
                                                        {{ $EHS->Environmental_Category == 'N/A' ? 'selected' : '' }}>N/A
                                                    </option>

                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Special Weather Conditions">Special Weather Conditions</label>
                                                <select name="Special_Weather_Conditions" id="Special_Weather_Conditions"
                                                    data-search="false" data-silent-initial-value-set="true"
                                                    {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>
                                                    <option value="">-- Select --</option>
                                                    <option value="Earthquake"
                                                        {{ $EHS->Special_Weather_Conditions == 'Earthquake' ? 'selected' : '' }}>
                                                        Earthquake</option>
                                                    <option value="Fog"
                                                        {{ $EHS->Special_Weather_Conditions == 'Fog' ? 'selected' : '' }}>
                                                        Fog</option>
                                                    <option value="High Temperature"
                                                        {{ $EHS->Special_Weather_Conditions == 'High Temperature' ? 'selected' : '' }}>
                                                        High Temperature</option>
                                                    <option value="Snowfall"
                                                        {{ $EHS->Special_Weather_Conditions == 'Snowfall' ? 'selected' : '' }}>
                                                        Snowfall</option>
                                                    <option value="Low Temperature"
                                                        {{ $EHS->Special_Weather_Conditions == 'Low Temperature' ? 'selected' : '' }}>
                                                        Low Temperature</option>
                                                    <option value="Rain"
                                                        {{ $EHS->Special_Weather_Conditions == 'Rain' ? 'selected' : '' }}>
                                                        Rain</option>
                                                    <option value="Slippery"
                                                        {{ $EHS->Special_Weather_Conditions == 'Slippery' ? 'selected' : '' }}>
                                                        Slippery</option>
                                                    <option value="Snow"
                                                        {{ $EHS->Special_Weather_Conditions == 'Snow' ? 'selected' : '' }}>
                                                        Snow</option>
                                                    <option value="Storm"
                                                        {{ $EHS->Special_Weather_Conditions == 'Storm' ? 'selected' : '' }}>
                                                        Storm</option>
                                                    <option value="Thunder / Lightning"
                                                        {{ $EHS->Special_Weather_Conditions == 'Thunder / Lightning' ? 'selected' : '' }}>
                                                        Thunder / Lightning</option>
                                                    <option value="Wind"
                                                        {{ $EHS->Special_Weather_Conditions == 'Wind' ? 'selected' : '' }}>
                                                        Wind</option>
                                                    <option value="N/A"
                                                        {{ $EHS->Special_Weather_Conditions == 'N/A' ? 'selected' : '' }}>
                                                        N/A</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Source Of Release Or Spill">Source Of Release Or Spill</label>
                                                <select name="Source_Of_Release_Or_Spill" id="Source_Of_Release_Or_Spill"
                                                    data-search="false" data-silent-initial-value-set="true"
                                                    {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>
                                                    <option value="">-- Select --</option>
                                                    <option value="Laboratory"
                                                        {{ $EHS->Source_Of_Release_Or_Spill == 'Laboratory' ? 'selected' : '' }}>
                                                        Laboratory</option>
                                                    <option value="Manufacturing Plant"
                                                        {{ $EHS->Source_Of_Release_Or_Spill == 'Manufacturing Plant' ? 'selected' : '' }}>
                                                        Manufacturing Plant</option>
                                                    <option value="Nuclear Plant"
                                                        {{ $EHS->Source_Of_Release_Or_Spill == 'Nuclear Plant' ? 'selected' : '' }}>
                                                        Nuclear Plant</option>
                                                    <option value="Oil Tanker"
                                                        {{ $EHS->Source_Of_Release_Or_Spill == 'Oil Tanker' ? 'selected' : '' }}>
                                                        Oil Tanker</option>
                                                    <option value="Waste Management"
                                                        {{ $EHS->Source_Of_Release_Or_Spill == 'Waste Management' ? 'selected' : '' }}>
                                                        Waste Management</option>
                                                    <option value="Other"
                                                        {{ $EHS->Source_Of_Release_Or_Spill == 'Other' ? 'selected' : '' }}>
                                                        Other</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Cause Of Release Or Spill">Cause Of Release Or Spill</label>
                                                <select name="Cause_Of_Release_Or_Spill" id="Cause_Of_Release_Or_Spill"
                                                    data-search="false" data-silent-initial-value-set="true"
                                                    {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>
                                                    <option value="">-- Select --</option>
                                                    <option value="Equipment Failure"
                                                        {{ $EHS->Cause_Of_Release_Or_Spill == 'Equipment Failure' ? 'selected' : '' }}>
                                                        Equipment Failure</option>
                                                    <option value="Carelessness"
                                                        {{ $EHS->Cause_Of_Release_Or_Spill == 'Carelessness' ? 'selected' : '' }}>
                                                        Carelessness</option>
                                                    <option value="Natural Causes"
                                                        {{ $EHS->Cause_Of_Release_Or_Spill == 'Natural Causes' ? 'selected' : '' }}>
                                                        Natural Causes</option>
                                                    <option value="Not Known"
                                                        {{ $EHS->Cause_Of_Release_Or_Spill == 'Not Known' ? 'selected' : '' }}>
                                                        Not Known</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Threat Caused By Release/Spill">Threat Caused By
                                                    Release/Spill</label>
                                                <div class="relative-container">
                                                    <input type="text" name="Threat_Caused_By_Release_Spill"
                                                        value="{{ $EHS->Threat_Caused_By_Release_Spill }}"
                                                        {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Environment Evacuation Ordered">Environment Evacuation
                                                    Ordered</label>
                                                <select name="Environment_Evacuation_Ordered"
                                                    id="Environment_Evacuation_Ordered" data-search="false"
                                                    data-silent-initial-value-set="true"
                                                    {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>
                                                    <option value="">-- Select --</option>
                                                    <option value="Yes"
                                                        {{ $EHS->Environment_Evacuation_Ordered == 'Yes' ? 'selected' : '' }}>
                                                        Yes</option>
                                                    <option value="No"
                                                        {{ $EHS->Environment_Evacuation_Ordered == 'No' ? 'selected' : '' }}>
                                                        No</option>
                                                    <option value="Na"
                                                        {{ $EHS->Environment_Evacuation_Ordered == 'Na' ? 'selected' : '' }}>
                                                        Na</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 new-date-data-field">
                                            <div class="group-input input-date">
                                                <label for="Date of Samples Taken">Date of Samples Taken</label>
                                                <div class="calenderauditee">
                                                    <input type="text" id="Date_Samples_Taken" readonly
                                                        placeholder="DD-MMM-YYYY"
                                                        value="{{ Helpers::getdateFormat($EHS->Date_Samples_Taken) }}"
                                                        {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }} />
                                                    <input type="date" id="Date_Samples_Taken_checkdate"
                                                        name="Date_Samples_Taken"
                                                        {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}
                                                        value="{{ $EHS->Date_Samples_Taken }}" class="hide-input"
                                                        oninput="handleDateInput(this, 'Date_Samples_Taken');checkDate('Date_Samples_Taken_checkdate','Date_Samples_Taken1_checkdate')" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Agencys Notified">Agencys Notified</label>
                                                <select name="Agencys_Notified" id="Agencys_Notified" data-search="false"
                                                    data-silent-initial-value-set="true"
                                                    {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>
                                                    <option value="">-- Select --</option>
                                                    <option value="EPA"
                                                        {{ $EHS->Agencys_Notified == 'EPA' ? 'selected' : '' }}>EPA
                                                    </option>
                                                    <option value="DEP"
                                                        {{ $EHS->Agencys_Notified == 'DEP' ? 'selected' : '' }}>DEP
                                                    </option>
                                                    <option value="Hazmat"
                                                        {{ $EHS->Agencys_Notified == 'Hazmat' ? 'selected' : '' }}>Hazmat
                                                    </option>
                                                    <option value="ATF"
                                                        {{ $EHS->Agencys_Notified == 'ATF' ? 'selected' : '' }}>ATF
                                                    </option>
                                                    <option value="FBI"
                                                        {{ $EHS->Agencys_Notified == 'FBI' ? 'selected' : '' }}>FBI
                                                    </option>
                                                    <option value="National Guard"
                                                        {{ $EHS->Agencys_Notified == 'National Guard' ? 'selected' : '' }}>
                                                        National Guard</option>
                                                    <option value="State Police"
                                                        {{ $EHS->Agencys_Notified == 'State Police' ? 'selected' : '' }}>
                                                        State Police</option>
                                                    <option value="Local Police"
                                                        {{ $EHS->Agencys_Notified == 'Local Police' ? 'selected' : '' }}>
                                                        Local Police</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="root_cause">
                                                    Material Released
                                                    <button type="button"
                                                        {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}
                                                        name="audit-incident-grid" id="Material_Released_Add">+</button>
                                                    <span class="text-primary" data-bs-toggle="modal"
                                                        data-bs-target="#observation-field-instruction-modal"
                                                        style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                                        (Launch Instruction)
                                                    </span>
                                                </label>

                                                <table class="table table-bordered"
                                                    id="Material_Released_Add_field_table">
                                                    <thead>
                                                        <tr>
                                                            <th>Row#</th>
                                                            <th>Type Of Materials Released</th>
                                                            <th>Quantity Of Materials Released</th>
                                                            <th>Medium Affected By Released</th>
                                                            <th>Health Risk?</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                            $serialNumber = 1;
                                                        @endphp
                                                        @foreach ($MaterialReleasedInfo->data1 as $oogrid)
                                                            <tr>
                                                                <td disabled>{{ $serialNumber++ }}</td>
                                                                <td>
                                                                    <input type="text"
                                                                        {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}
                                                                        name="MaterialReleased[{{ $loop->index }}][Type_Of_Materials_Released]"
                                                                        value="{{ $oogrid['Type_Of_Materials_Released'] }}">
                                                                </td>
                                                                <td>
                                                                    <input type="text"
                                                                        {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}
                                                                        name="MaterialReleased[{{ $loop->index }}][Quantity_Of_Materials_Released]"
                                                                        value="{{ $oogrid['Quantity_Of_Materials_Released'] }}">
                                                                </td>
                                                                <td>
                                                                    <input type="text"
                                                                        {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}
                                                                        name="MaterialReleased[{{ $loop->index }}][Medium_Affected_By_Released]"
                                                                        value="{{ $oogrid['Medium_Affected_By_Released'] }}">
                                                                </td>
                                                                <td>
                                                                    <input type="text"
                                                                        {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}
                                                                        name="MaterialReleased[{{ $loop->index }}][Health_Risk]"
                                                                        value="{{ $oogrid['Health_Risk'] }}">
                                                                </td>

                                                                <td>
                                                                    <button class="removeRowBtn"
                                                                        {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>Remove</button>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <script>
                                            $(document).ready(function() {
                                                let investdetails = 1;
                                                $('#Material_Released_Add').click(function(e) {
                                                    function generateTableRow(serialNumber) {
                                                        var html =
                                                            '<tr>' +
                                                            '<td><input disabled type="text" style ="width:15px" value="' + serialNumber +
                                                            '"></td>' +
                                                            '<td><input type="text"  {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}  name="MaterialReleased[' +
                                                            investdetails + '][Type_Of_Materials_Released]" value=""></td>' +
                                                            '<td><input type="text"  {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}  name="MaterialReleased[' +
                                                            investdetails + '][Quantity_Of_Materials_Released]" value=""></td>' +
                                                            '<td><input type="text"  {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }} name="MaterialReleased[' +
                                                            investdetails + '][Medium_Affected_By_Released]" value=""></td>' +
                                                            '<td><input type="text"  {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}  name="MaterialReleased[' +
                                                            investdetails + '][Health_Risk]" value=""></td>' +
                                                            '<td><button class="removeRowBtn"  {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>Remove</button>' +

                                                            '</tr>';
                                                        investdetails++; // Increment the row number here
                                                        return html;
                                                    }

                                                    var tableBody = $('#Material_Released_Add_field_table tbody');
                                                    var rowCount = tableBody.children('tr').length;
                                                    var newRow = generateTableRow(rowCount + 1);
                                                    tableBody.append(newRow);
                                                });
                                                $(document).on('click', '.removeRowBtn', function() {
                                                    $(this).closest('tr').remove();
                                                });
                                            });
                                        </script>

                                        <div class="sub-head">
                                            Fire Incident
                                        </div>

                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Fire Category">Fire Category</label>
                                                <select name="Fire_Category" id="Fire_Category" data-search="false"
                                                    data-silent-initial-value-set="true"
                                                    {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>
                                                    <option value="">-- Select --</option>
                                                    <option value="Explosion"
                                                        {{ $EHS->Fire_Category == 'Explosion' ? 'selected' : '' }}>
                                                        Explosion</option>
                                                    <option value="Fermentation"
                                                        {{ $EHS->Fire_Category == 'Fermentation' ? 'selected' : '' }}>
                                                        Fermentation</option>
                                                    <option value="Flames"
                                                        {{ $EHS->Fire_Category == 'Flames' ? 'selected' : '' }}>Flames
                                                    </option>
                                                    <option value="Smoke"
                                                        {{ $EHS->Fire_Category == 'Smoke' ? 'selected' : '' }}>Smoke
                                                    </option>
                                                    <option value="Other"
                                                        {{ $EHS->Fire_Category == 'Other' ? 'selected' : '' }}>Other
                                                    </option>
                                                    <option value="NA"
                                                        {{ $EHS->Fire_Category == 'NA' ? 'selected' : '' }}>NA</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Fire Evacuation Ordered ?">Fire Evacuation Ordered ?</label>
                                                <select name="Fire_Evacuation_Ordered" id="Fire_Evacuation_Ordered"
                                                    data-search="false" data-silent-initial-value-set="true"
                                                    {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>
                                                    <option value="">-- Select --</option>
                                                    <option value="Yes"
                                                        {{ $EHS->Fire_Evacuation_Ordered == 'Yes' ? 'selected' : '' }}>Yes
                                                    </option>
                                                    <option value="No"
                                                        {{ $EHS->Fire_Evacuation_Ordered == 'No' ? 'selected' : '' }}>No
                                                    </option>
                                                    <option value="Na"
                                                        {{ $EHS->Fire_Evacuation_Ordered == 'Na' ? 'selected' : '' }}>Na
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Combat By">Combat By</label>
                                                <select name="Combat_By" id="Combat_By" data-search="false"
                                                    data-silent-initial-value-set="true"
                                                    {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>
                                                    <option value="">-- Select --</option>
                                                    <option value="Contractor"
                                                        {{ $EHS->Combat_By == 'Contractor' ? 'selected' : '' }}>Contractor
                                                    </option>
                                                    <option value="Fire Brigade"
                                                        {{ $EHS->Combat_By == 'Fire Brigade' ? 'selected' : '' }}>Fire
                                                        Brigade</option>
                                                    <option value="Own Personnel"
                                                        {{ $EHS->Combat_By == 'Own Personnel' ? 'selected' : '' }}>Own
                                                        Personnel</option>
                                                    <option value="Other"
                                                        {{ $EHS->Combat_By == 'Other' ? 'selected' : '' }}>Other</option>
                                                    <option value="NA"
                                                        {{ $EHS->Combat_By == 'NA' ? 'selected' : '' }}>NA</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Fire Fighting Equipment Used">Fire Fighting Equipment
                                                    Used</label>
                                                <div class="relative-container">
                                                    <input type="text" name="Fire_Fighting_Equipment_Used"
                                                        value="{{ $EHS->Fire_Fighting_Equipment_Used }}"
                                                        {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>

                                        <div class="sub-head">
                                            Event Location
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Zone">Zone</label>
                                                <select name="zone" id="zone" data-search="false"
                                                    data-silent-initial-value-set="true"
                                                    {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>
                                                    <option value="">Enter Your Selection Here</option>
                                                    <option value="Asia" {{ $EHS->zone == 'Asia' ? 'selected' : '' }}>
                                                        Asia</option>
                                                    <option value="Europe"
                                                        {{ $EHS->zone == 'Europe' ? 'selected' : '' }}>Europe</option>
                                                    <option value="Africa"
                                                        {{ $EHS->zone == 'Africa' ? 'selected' : '' }}>Africa</option>
                                                    <option value="Central America"
                                                        {{ $EHS->zone == 'Central America' ? 'selected' : '' }}>Central
                                                        America</option>
                                                    <option value="South America"
                                                        {{ $EHS->zone == 'South America' ? 'selected' : '' }}>South
                                                        America</option>
                                                    <option value="Oceania"
                                                        {{ $EHS->zone == 'Oceania' ? 'selected' : '' }}>Oceania</option>
                                                    <option value="North America"
                                                        {{ $EHS->zone == 'North America' ? 'selected' : '' }}>North
                                                        America</option>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Country">Country</label>
                                                <select name="country" class="form-select country"
                                                    aria-label="Default select example" onchange="loadStates()"
                                                    {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>
                                                    <option value="">Select Country</option>
                                                    <option value="{{ $EHS->country }}" selected>{{ $EHS->country }}
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="State">State</label>
                                                <select name="state" class="form-select state"
                                                    aria-label="Default select example" onchange="loadCities()"
                                                    {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>
                                                    <option value="{{ $EHS->state }}" selected>{{ $EHS->state }}
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="City">City</label>
                                                <select name="city" class="form-select city"
                                                    aria-label="Default select example"
                                                    {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>
                                                    <option value="{{ $EHS->city }}" selected>{{ $EHS->city }}
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <script>
                                            var config = {
                                                cUrl: 'https://api.countrystatecity.in/v1',
                                                ckey: 'NHhvOEcyWk50N2Vna3VFTE00bFp3MjFKR0ZEOUhkZlg4RTk1MlJlaA=='
                                            };

                                            var countrySelect = document.querySelector('.country'),
                                                stateSelect = document.querySelector('.state'),
                                                citySelect = document.querySelector('.city');

                                            var selectedCountry = "{{ $data->country }}";
                                            var selectedState = "{{ $data->state }}";
                                            var selectedCity = "{{ $data->city }}";

                                            function loadCountries() {
                                                let apiEndPoint = `${config.cUrl}/countries`;

                                                $.ajax({
                                                    url: apiEndPoint,
                                                    headers: {
                                                        "X-CSCAPI-KEY": config.ckey
                                                    },
                                                    success: function(data) {
                                                        data.forEach(country => {
                                                            const option = document.createElement('option');
                                                            option.value = country.name;
                                                            option.textContent = country.name;
                                                            option.dataset.code = country
                                                                .iso2;
                                                            if (country.name === selectedCountry) {
                                                                option.selected = true;
                                                            }
                                                            countrySelect.appendChild(option);
                                                        });
                                                        loadStates();
                                                    },
                                                    error: function(xhr, status, error) {
                                                        console.error('Error loading countries:', error);
                                                    }
                                                });
                                            }

                                            function loadStates() {
                                                stateSelect.disabled = false;
                                                stateSelect.innerHTML = '<option value="">Select State</option>';

                                                const selectedCountryCode = countrySelect.options[countrySelect.selectedIndex].dataset.code;

                                                $.ajax({
                                                    url: `${config.cUrl}/countries/${selectedCountryCode}/states`,
                                                    headers: {
                                                        "X-CSCAPI-KEY": config.ckey
                                                    },
                                                    success: function(data) {
                                                        data.forEach(state => {
                                                            const option = document.createElement('option');
                                                            option.value = state.name;
                                                            option.textContent = state.name;
                                                            option.dataset.code = state
                                                                .iso2;
                                                            if (state.name === selectedState) {
                                                                option.selected = true;
                                                            }
                                                            stateSelect.appendChild(option);
                                                        });

                                                        loadCities();
                                                    },
                                                    error: function(xhr, status, error) {
                                                        console.error('Error loading states:', error);
                                                    }
                                                });
                                            }

                                            function loadCities() {
                                                citySelect.disabled = false;
                                                citySelect.innerHTML = '<option value="">Select City</option>';

                                                const selectedCountryCode = countrySelect.options[countrySelect.selectedIndex].dataset.code;
                                                const selectedStateCode = stateSelect.options[stateSelect.selectedIndex].dataset.code;

                                                $.ajax({
                                                    url: `${config.cUrl}/countries/${selectedCountryCode}/states/${selectedStateCode}/cities`,
                                                    headers: {
                                                        "X-CSCAPI-KEY": config.ckey
                                                    },
                                                    success: function(data) {
                                                        data.forEach(city => {
                                                            const option = document.createElement('option');
                                                            option.value = city.name;
                                                            option.textContent = city.name;
                                                            if (city.name === selectedCity) {
                                                                option.selected = true;
                                                            }
                                                            citySelect.appendChild(option);
                                                        });

                                                        // Apply disabling logic based on stage after all data is loaded
                                                        if ({{ $data->stage }} == 6 || {{ $data->stage }} == 0) {
                                                            $("#target :input").not(".backButton, .nextButton").prop("disabled", true);
                                                        }


                                                    },
                                                    error: function(xhr, status, error) {
                                                        console.error('Error loading cities:', error);
                                                    }
                                                });
                                            }

                                            $(document).ready(function() {
                                                loadCountries();
                                            });
                                        </script>

                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Site Name">Site Name</label>
                                                <select name="Site_Name" id="Site_Name" data-search="false"
                                                    data-silent-initial-value-set="true"
                                                    {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>
                                                    <option value="">-- Select --</option>
                                                    <option value="Complex A"
                                                        {{ $EHS->Site_Name == 'Complex A' ? 'selected' : '' }}>Complex A
                                                    </option>
                                                    <option value="Marketing A"
                                                        {{ $EHS->Site_Name == 'Marketing A' ? 'selected' : '' }}>Marketing
                                                        A</option>
                                                    <option value="Mountain View"
                                                        {{ $EHS->Site_Name == 'Mountain View' ? 'selected' : '' }}>
                                                        Mountain View</option>
                                                    <option value="Ocean View"
                                                        {{ $EHS->Site_Name == 'Ocean View' ? 'selected' : '' }}>Ocean View
                                                    </option>
                                                    <option value="Building 1"
                                                        {{ $EHS->Site_Name == 'Building 1' ? 'selected' : '' }}>Building 1
                                                    </option>
                                                    <option value="Building 2"
                                                        {{ $EHS->Site_Name == 'Building 2' ? 'selected' : '' }}>Building 2
                                                    </option>
                                                    <option value="Parkside"
                                                        {{ $EHS->Site_Name == 'Parkside' ? 'selected' : '' }}>Parkside
                                                    </option>
                                                    <option value="Central Plaza"
                                                        {{ $EHS->Site_Name == 'Central Plaza' ? 'selected' : '' }}>Central
                                                        Plaza</option>
                                                    <option value="Riverside"
                                                        {{ $EHS->Site_Name == 'Riverside' ? 'selected' : '' }}>Riverside
                                                    </option>
                                                    <option value="Sunset Ridge"
                                                        {{ $EHS->Site_Name == 'Sunset Ridge' ? 'selected' : '' }}>Sunset
                                                        Ridge</option>
                                                    <option value="Hilltop Site"
                                                        {{ $EHS->Site_Name == 'Hilltop Site' ? 'selected' : '' }}>Hilltop
                                                        Site</option>
                                                    <option value="Seaside Office"
                                                        {{ $EHS->Site_Name == 'Seaside Office' ? 'selected' : '' }}>
                                                        Seaside Office</option>
                                                    <option value="City Square"
                                                        {{ $EHS->Site_Name == 'City Square' ? 'selected' : '' }}>City
                                                        Square</option>
                                                    <option value="Tech Park"
                                                        {{ $EHS->Site_Name == 'Tech Park' ? 'selected' : '' }}>Tech Park
                                                    </option>
                                                    <option value="Other"
                                                        {{ $EHS->Site_Name == 'Other' ? 'selected' : '' }}>Other</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Building">Building</label>
                                                <select name="Building" id="Building" data-search="false"
                                                    data-silent-initial-value-set="true"
                                                    {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>
                                                    <option value="">-- Select --</option>
                                                    <option value="A"
                                                        {{ $EHS->Building == 'A' ? 'selected' : '' }}>A</option>
                                                    <option value="B"
                                                        {{ $EHS->Building == 'B' ? 'selected' : '' }}>B</option>
                                                    <option value="C"
                                                        {{ $EHS->Building == 'C' ? 'selected' : '' }}>C</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Floor">Floor</label>
                                                <select name="Floor" id="Floor" data-search="false"
                                                    data-silent-initial-value-set="true"
                                                    {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>
                                                    <option value="">-- Select --</option>
                                                    <option value="1" {{ $EHS->Floor == '1' ? 'selected' : '' }}>1
                                                    </option>
                                                    <option value="2" {{ $EHS->Floor == '2' ? 'selected' : '' }}>2
                                                    </option>
                                                    <option value="3" {{ $EHS->Floor == '3' ? 'selected' : '' }}>3
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Room">Room</label>
                                                <select name="Room" id="Room" data-search="false"
                                                    data-silent-initial-value-set="true"
                                                    {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>
                                                    <option value="">-- Select --</option>
                                                    <option value="101" {{ $EHS->Room == '101' ? 'selected' : '' }}>
                                                        101</option>
                                                    <option value="102" {{ $EHS->Room == '102' ? 'selected' : '' }}>
                                                        102</option>
                                                    <option value="103" {{ $EHS->Room == '103' ? 'selected' : '' }}>
                                                        103</option>
                                                    <option value="201" {{ $EHS->Room == '201' ? 'selected' : '' }}>
                                                        201</option>
                                                    <option value="202" {{ $EHS->Room == '202' ? 'selected' : '' }}>
                                                        202</option>
                                                    <option value="203" {{ $EHS->Room == '203' ? 'selected' : '' }}>
                                                        203</option>
                                                    <option value="301" {{ $EHS->Room == '301' ? 'selected' : '' }}>
                                                        301</option>
                                                    <option value="302" {{ $EHS->Room == '302' ? 'selected' : '' }}>
                                                        302</option>
                                                    <option value="303" {{ $EHS->Room == '303' ? 'selected' : '' }}>
                                                        303</option>

                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="group-input">
                                                <label for="Location">Location</label>
                                                <div class="relative-container">
                                                    <input type="text" name="Location" id="Location"
                                                        value="{{ $EHS->Location }}"
                                                        {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="button-block">
                                        <button type="submit" class="saveButton">Save</button>
                                        <button type="button" class="backButton"
                                            onclick="previousStep()">Back</button>
                                        <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                        <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}"
                                                class="text-white"> Exit </a> </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Audit Preparation content -->
                            <div id="CCForm3" class="inner-block cctabcontent">
                                <div class="inner-block-content">
                                    <div class="sub-head">
                                        Victim Information
                                    </div>
                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="group-input">
                                                <label for="Victim">Victim</label>
                                                <select id="Victim" placeholder="Select..." name="Victim"
                                                    {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>
                                                    <option value="">-- Select --</option>
                                                    @foreach ($users as $key => $value)
                                                        <option value="{{ $value->id }}"
                                                            @if ($data->Victim == $value->id) selected @endif>
                                                            {{ $value->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Medical Treatment ?(Y/N)">Medical Treatment ?(Y/N)</label>
                                                <select name="Medical_Treatment" id="Medical_Treatment"
                                                    data-search="false" data-silent-initial-value-set="true"
                                                    {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>
                                                    <option value="">-- Select --</option>
                                                    <option value="Yes"
                                                        {{ $EHS->Medical_Treatment == 'Yes' ? 'selected' : '' }}>Yes
                                                    </option>
                                                    <option value="No"
                                                        {{ $EHS->Medical_Treatment == 'No' ? 'selected' : '' }}>No
                                                    </option>
                                                    <option value="Na"
                                                        {{ $EHS->Medical_Treatment == 'Na' ? 'selected' : '' }}>Na
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Victim Position">Victim Position</label>
                                                <select name="Victim_Position" id="Victim_Position"
                                                    data-search="false" data-silent-initial-value-set="true"
                                                    {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>
                                                    <option value="">-- Select --</option>
                                                    <option value="Cleaner"
                                                        {{ $EHS->Victim_Position == 'Cleaner' ? 'selected' : '' }}>Cleaner
                                                    </option>
                                                    <option value="Driver Internal Transport"
                                                        {{ $EHS->Victim_Position == 'Driver Internal Transport' ? 'selected' : '' }}>
                                                        Driver Internal Transport</option>
                                                    <option value="Employee"
                                                        {{ $EHS->Victim_Position == 'Employee' ? 'selected' : '' }}>
                                                        Employee</option>
                                                    <option value="Executive Manager"
                                                        {{ $EHS->Victim_Position == 'Executive Manager' ? 'selected' : '' }}>
                                                        Executive Manager</option>
                                                    <option value="Loader"
                                                        {{ $EHS->Victim_Position == 'Loader' ? 'selected' : '' }}>Loader
                                                    </option>
                                                    <option value="Machinist"
                                                        {{ $EHS->Victim_Position == 'Machinist' ? 'selected' : '' }}>
                                                        Machinist</option>
                                                    <option value="Maintenance Engineer"
                                                        {{ $EHS->Victim_Position == 'Maintenance Engineer' ? 'selected' : '' }}>
                                                        Maintenance Engineer</option>
                                                    <option value="Manager"
                                                        {{ $EHS->Victim_Position == 'Manager' ? 'selected' : '' }}>Manager
                                                    </option>
                                                    <option value="Office Employee"
                                                        {{ $EHS->Victim_Position == 'Office Employee' ? 'selected' : '' }}>
                                                        Office Employee</option>
                                                    <option value="Office Personnel"
                                                        {{ $EHS->Victim_Position == 'Office Personnel' ? 'selected' : '' }}>
                                                        Office Personnel</option>
                                                    <option value="Production Employee"
                                                        {{ $EHS->Victim_Position == 'Production Employee' ? 'selected' : '' }}>
                                                        Production Employee</option>
                                                    <option value="Quality Assurance"
                                                        {{ $EHS->Victim_Position == 'Quality Assurance' ? 'selected' : '' }}>
                                                        Quality Assurance</option>
                                                    <option value="Quality Inspector"
                                                        {{ $EHS->Victim_Position == 'Quality Inspector' ? 'selected' : '' }}>
                                                        Quality Inspector</option>
                                                    <option value="Sorter"
                                                        {{ $EHS->Victim_Position == 'Sorter' ? 'selected' : '' }}>Sorter
                                                    </option>
                                                    <option value="Substitute Driver"
                                                        {{ $EHS->Victim_Position == 'Substitute Driver' ? 'selected' : '' }}>
                                                        Substitute Driver</option>
                                                    <option value="Technical Personnel"
                                                        {{ $EHS->Victim_Position == 'Technical Personnel' ? 'selected' : '' }}>
                                                        Technical Personnel</option>
                                                    <option value="Truck Driver"
                                                        {{ $EHS->Victim_Position == 'Truck Driver' ? 'selected' : '' }}>
                                                        Truck Driver</option>
                                                    <option value="Unloader"
                                                        {{ $EHS->Victim_Position == 'Unloader' ? 'selected' : '' }}>
                                                        Unloader</option>
                                                    <option value="Uploader"
                                                        {{ $EHS->Victim_Position == 'Uploader' ? 'selected' : '' }}>
                                                        Uploader</option>
                                                    <option value="Warehouse Assistant"
                                                        {{ $EHS->Victim_Position == 'Warehouse Assistant' ? 'selected' : '' }}>
                                                        Warehouse Assistant</option>
                                                    <option value="Yard Supervisor"
                                                        {{ $EHS->Victim_Position == 'Yard Supervisor' ? 'selected' : '' }}>
                                                        Yard Supervisor</option>
                                                    <option value="NA"
                                                        {{ $EHS->Victim_Position == 'NA' ? 'selected' : '' }}>NA</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Victim Relation To Company">Victim Relation To Company</label>
                                                <select name="Victim_Relation_To_Company"
                                                    id="Victim_Relation_To_Company" data-search="false"
                                                    data-silent-initial-value-set="true"
                                                    {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>
                                                    <option value="">-- Select --</option>
                                                    <option value="Contractor"
                                                        {{ $EHS->Victim_Relation_To_Company == 'Contractor' ? 'selected' : '' }}>
                                                        Contractor</option>
                                                    <option value="Own"
                                                        {{ $EHS->Victim_Relation_To_Company == 'Own' ? 'selected' : '' }}>
                                                        Own</option>
                                                    <option value="Temporarily Hired"
                                                        {{ $EHS->Victim_Relation_To_Company == 'Temporarily Hired' ? 'selected' : '' }}>
                                                        Temporarily Hired</option>
                                                    <option value="Third Party"
                                                        {{ $EHS->Victim_Relation_To_Company == 'Third Party' ? 'selected' : '' }}>
                                                        Third Party</option>
                                                    <option value="NA"
                                                        {{ $EHS->Victim_Relation_To_Company == 'NA' ? 'selected' : '' }}>
                                                        NA</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Hospitalization">Hospitalization</label>
                                                <select name="Hospitalization" id="Hospitalization"
                                                    data-search="false" data-silent-initial-value-set="true"
                                                    {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>
                                                    <option value="">-- Select --</option>
                                                    <option value="Yes"
                                                        {{ $EHS->Hospitalization == 'Yes' ? 'selected' : '' }}>Yes
                                                    </option>
                                                    <option value="No"
                                                        {{ $EHS->Hospitalization == 'No' ? 'selected' : '' }}>No</option>
                                                    <option value="Na"
                                                        {{ $EHS->Hospitalization == 'Na' ? 'selected' : '' }}>Na</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Hospital Name">Hospital Name</label>
                                                <div class="relative-container">
                                                    <input type="text" name="Hospital_Name" id="Hospital_Name"
                                                        value="{{ $EHS->Hospital_Name }}"
                                                        {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 new-date-data-field">
                                            <div class="group-input input-date">
                                                <label for="Date Of Treatment">Date Of Treatment</label>
                                                <div class="calenderauditee">
                                                    <input type="text" id="Date_Of_Treatment" readonly
                                                        placeholder="DD-MMM-YYYY"
                                                        value="{{ Helpers::getdateFormat($EHS->Date_Of_Treatment) }}"
                                                        {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }} />
                                                    <input type="date" id="Date_Of_Treatment_checkdate"
                                                        name="Date_Of_Treatment"
                                                        {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}
                                                        value="{{ $EHS->Date_Of_Treatment }}" class="hide-input"
                                                        oninput="handleDateInput(this, 'Date_Of_Treatment');checkDate('Date_Of_Treatment_checkdate','Date_Of_Treatment1_checkdate')" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Victim Treated By">Victim Treated By</label>
                                                <input type="text" name="Victim_Treated_By" id="Victim_Treated_By"
                                                    value="{{ $EHS->Victim_Treated_By }}"
                                                    {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Medical Treatment Description">Medical Treatment
                                                    Description</label>
                                                <div class="relative-container">
                                                    <textarea name="Medical_Treatment_Description" id="Medical_Treatment_Description"
                                                        {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>{{ $EHS->Medical_Treatment_Description }}</textarea>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>
                                        <div class="sub-head">
                                            Physical Damage
                                        </div>

                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Injury Type">Injury Type</label>
                                                <select name="Injury_Type" id="Injury_Type" data-search="false"
                                                    data-silent-initial-value-set="true"
                                                    {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>
                                                    <option value="">-- Select --</option>
                                                    <option value="Amputation"
                                                        {{ $EHS->Injury_Type == 'Amputation' ? 'selected' : '' }}>
                                                        Amputation</option>
                                                    <option value="Bruise"
                                                        {{ $EHS->Injury_Type == 'Bruise' ? 'selected' : '' }}>Bruise
                                                    </option>
                                                    <option value="Burn"
                                                        {{ $EHS->Injury_Type == 'Burn' ? 'selected' : '' }}>Burn</option>
                                                    <option value="Contusion"
                                                        {{ $EHS->Injury_Type == 'Contusion' ? 'selected' : '' }}>Contusion
                                                    </option>
                                                    <option value="Cut"
                                                        {{ $EHS->Injury_Type == 'Cut' ? 'selected' : '' }}>Cut</option>
                                                    <option value="Death"
                                                        {{ $EHS->Injury_Type == 'Death' ? 'selected' : '' }}>Death
                                                    </option>
                                                    <option value="Dislocation"
                                                        {{ $EHS->Injury_Type == 'Dislocation' ? 'selected' : '' }}>
                                                        Dislocation</option>
                                                    <option value="Fracture"
                                                        {{ $EHS->Injury_Type == 'Fracture' ? 'selected' : '' }}>Fracture
                                                    </option>
                                                    <option value="Hearing Loss"
                                                        {{ $EHS->Injury_Type == 'Hearing Loss' ? 'selected' : '' }}>
                                                        Hearing Loss</option>
                                                    <option value="Injury"
                                                        {{ $EHS->Injury_Type == 'Injury' ? 'selected' : '' }}>Injury
                                                    </option>
                                                    <option value="Internal Trauma"
                                                        {{ $EHS->Injury_Type == 'Internal Trauma' ? 'selected' : '' }}>
                                                        Internal Trauma</option>
                                                    <option value="Minor Burns"
                                                        {{ $EHS->Injury_Type == 'Minor Burns' ? 'selected' : '' }}>Minor
                                                        Burns</option>
                                                    <option value="Needle Puncture"
                                                        {{ $EHS->Injury_Type == 'Needle Puncture' ? 'selected' : '' }}>
                                                        Needle Puncture</option>
                                                    <option value="No Injuries"
                                                        {{ $EHS->Injury_Type == 'No Injuries' ? 'selected' : '' }}>No
                                                        Injuries</option>
                                                    <option value="Other / Multiple Injuries"
                                                        {{ $EHS->Injury_Type == 'Other / Multiple Injuries' ? 'selected' : '' }}>
                                                        Other / Multiple Injuries</option>
                                                    <option value="Poisoning"
                                                        {{ $EHS->Injury_Type == 'Poisoning' ? 'selected' : '' }}>Poisoning
                                                    </option>
                                                    <option value="Respiratory Condition"
                                                        {{ $EHS->Injury_Type == 'Respiratory Condition' ? 'selected' : '' }}>
                                                        Respiratory Condition</option>
                                                    <option value="Scrape"
                                                        {{ $EHS->Injury_Type == 'Scrape' ? 'selected' : '' }}>Scrape
                                                    </option>
                                                    <option value="Seizure"
                                                        {{ $EHS->Injury_Type == 'Seizure' ? 'selected' : '' }}>Seizure
                                                    </option>
                                                    <option value="Skin Disorder"
                                                        {{ $EHS->Injury_Type == 'Skin Disorder' ? 'selected' : '' }}>Skin
                                                        Disorder</option>
                                                    <option value="Skin Reaction"
                                                        {{ $EHS->Injury_Type == 'Skin Reaction' ? 'selected' : '' }}>Skin
                                                        Reaction</option>
                                                    <option value="Sprain"
                                                        {{ $EHS->Injury_Type == 'Sprain' ? 'selected' : '' }}>Sprain
                                                    </option>
                                                    <option value="NA"
                                                        {{ $EHS->Injury_Type == 'NA' ? 'selected' : '' }}>NA</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Number Of Injuries">Number Of Injuries</label>
                                                <input type="Number" name="Number_Of_Injuries"
                                                    id="Number_Of_Injuries" min="0"
                                                    value="{{ $EHS->Number_Of_Injuries }}"
                                                    {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Type Of Injuries">Type Of Injuries</label>
                                                <select name="Type_Of_Injuries" id="Type_Of_Injuries"
                                                    data-search="false" data-silent-initial-value-set="true"
                                                    {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>
                                                    <option value="">-- Select --</option>
                                                    <option value="Amputation"
                                                        {{ $EHS->Type_Of_Injuries == 'Amputation' ? 'selected' : '' }}>
                                                        Amputation</option>
                                                    <option value="Bruise"
                                                        {{ $EHS->Type_Of_Injuries == 'Bruise' ? 'selected' : '' }}>Bruise
                                                    </option>
                                                    <option value="Burn"
                                                        {{ $EHS->Type_Of_Injuries == 'Burn' ? 'selected' : '' }}>Burn
                                                    </option>
                                                    <option value="Contusion"
                                                        {{ $EHS->Type_Of_Injuries == 'Contusion' ? 'selected' : '' }}>
                                                        Contusion</option>
                                                    <option value="Cut"
                                                        {{ $EHS->Type_Of_Injuries == 'Cut' ? 'selected' : '' }}>Cut
                                                    </option>
                                                    <option value="Death"
                                                        {{ $EHS->Type_Of_Injuries == 'Death' ? 'selected' : '' }}>Death
                                                    </option>
                                                    <option value="Dislocation"
                                                        {{ $EHS->Type_Of_Injuries == 'Dislocation' ? 'selected' : '' }}>
                                                        Dislocation</option>
                                                    <option value="Fracture"
                                                        {{ $EHS->Type_Of_Injuries == 'Fracture' ? 'selected' : '' }}>
                                                        Fracture</option>
                                                    <option value="Hearing Loss"
                                                        {{ $EHS->Type_Of_Injuries == 'Hearing Loss' ? 'selected' : '' }}>
                                                        Hearing Loss</option>
                                                    <option value="Injury"
                                                        {{ $EHS->Type_Of_Injuries == 'Injury' ? 'selected' : '' }}>Injury
                                                    </option>
                                                    <option value="Internal Trauma"
                                                        {{ $EHS->Type_Of_Injuries == 'Internal Trauma' ? 'selected' : '' }}>
                                                        Internal Trauma</option>
                                                    <option value="Minor Burns"
                                                        {{ $EHS->Type_Of_Injuries == 'Minor Burns' ? 'selected' : '' }}>
                                                        Minor Burns</option>
                                                    <option value="Needle Puncture"
                                                        {{ $EHS->Type_Of_Injuries == 'Needle Puncture' ? 'selected' : '' }}>
                                                        Needle Puncture</option>
                                                    <option value="No Injuries"
                                                        {{ $EHS->Type_Of_Injuries == 'No Injuries' ? 'selected' : '' }}>No
                                                        Injuries</option>
                                                    <option value="Other / Multiple Injuries"
                                                        {{ $EHS->Type_Of_Injuries == 'Other / Multiple Injuries' ? 'selected' : '' }}>
                                                        Other / Multiple Injuries</option>
                                                    <option value="Poisoning"
                                                        {{ $EHS->Type_Of_Injuries == 'Poisoning' ? 'selected' : '' }}>
                                                        Poisoning</option>
                                                    <option value="Respiratory Condition"
                                                        {{ $EHS->Type_Of_Injuries == 'Respiratory Condition' ? 'selected' : '' }}>
                                                        Respiratory Condition</option>
                                                    <option value="Scrape"
                                                        {{ $EHS->Type_Of_Injuries == 'Scrape' ? 'selected' : '' }}>Scrape
                                                    </option>
                                                    <option value="Seizure"
                                                        {{ $EHS->Type_Of_Injuries == 'Seizure' ? 'selected' : '' }}>
                                                        Seizure</option>
                                                    <option value="Skin Disorder"
                                                        {{ $EHS->Type_Of_Injuries == 'Skin Disorder' ? 'selected' : '' }}>
                                                        Skin Disorder</option>
                                                    <option value="Skin Reaction"
                                                        {{ $EHS->Type_Of_Injuries == 'Skin Reaction' ? 'selected' : '' }}>
                                                        Skin Reaction</option>
                                                    <option value="Sprain"
                                                        {{ $EHS->Type_Of_Injuries == 'Sprain' ? 'selected' : '' }}>Sprain
                                                    </option>
                                                    <option value="NA"
                                                        {{ $EHS->Type_Of_Injuries == 'NA' ? 'selected' : '' }}>NA</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Injured Body Parts">Injured Body Parts</label>
                                                <select name="Injured_Body_Parts" id="Injured_Body_Parts"
                                                    data-search="false" data-silent-initial-value-set="true"
                                                    {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>
                                                    <option value="">-- Select --</option>
                                                    <option value="Neck"
                                                        {{ $EHS->Injured_Body_Parts == 'Neck' ? 'selected' : '' }}>Neck
                                                    </option>
                                                    <option value="Ankle"
                                                        {{ $EHS->Injured_Body_Parts == 'Ankle' ? 'selected' : '' }}>Ankle
                                                    </option>
                                                    <option value="Arm"
                                                        {{ $EHS->Injured_Body_Parts == 'Arm' ? 'selected' : '' }}>Arm
                                                    </option>
                                                    <option value="Leg"
                                                        {{ $EHS->Injured_Body_Parts == 'Leg' ? 'selected' : '' }}>Leg
                                                    </option>
                                                    <option value="Chest"
                                                        {{ $EHS->Injured_Body_Parts == 'Chest' ? 'selected' : '' }}>Chest
                                                    </option>
                                                    <option value="Hand"
                                                        {{ $EHS->Injured_Body_Parts == 'Hand' ? 'selected' : '' }}>Hand
                                                    </option>
                                                    <option value="Head"
                                                        {{ $EHS->Injured_Body_Parts == 'Head' ? 'selected' : '' }}>Head
                                                    </option>
                                                    <option value="Knee"
                                                        {{ $EHS->Injured_Body_Parts == 'Knee' ? 'selected' : '' }}>Knee
                                                    </option>
                                                    <option value="Wrist"
                                                        {{ $EHS->Injured_Body_Parts == 'Wrist' ? 'selected' : '' }}>Wrist
                                                    </option>
                                                    <option value="Back"
                                                        {{ $EHS->Injured_Body_Parts == 'Back' ? 'selected' : '' }}>Back
                                                    </option>
                                                    <option value="Skull"
                                                        {{ $EHS->Injured_Body_Parts == 'Skull' ? 'selected' : '' }}>Skull
                                                    </option>
                                                    <option value="Shoulder"
                                                        {{ $EHS->Injured_Body_Parts == 'Shoulder' ? 'selected' : '' }}>
                                                        Shoulder</option>
                                                    <option value="Elbow"
                                                        {{ $EHS->Injured_Body_Parts == 'Elbow' ? 'selected' : '' }}>Elbow
                                                    </option>
                                                    <option value="Foot"
                                                        {{ $EHS->Injured_Body_Parts == 'Foot' ? 'selected' : '' }}>Foot
                                                    </option>
                                                    <option value="Finger"
                                                        {{ $EHS->Injured_Body_Parts == 'Finger' ? 'selected' : '' }}>
                                                        Finger</option>
                                                    <option value="Other"
                                                        {{ $EHS->Injured_Body_Parts == 'Other' ? 'selected' : '' }}>Other
                                                    </option>
                                                    <option value="NA"
                                                        {{ $EHS->Injured_Body_Parts == 'NA' ? 'selected' : '' }}>NA
                                                    </option>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Type Of Illness">Type Of Illness</label>
                                                <select name="Type_Of_Illness" id="Type_Of_Illness"
                                                    data-search="false" data-silent-initial-value-set="true"
                                                    {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>
                                                    <option value="">-- Select --</option>
                                                    <option value="Hearing Loss"
                                                        {{ $EHS->Type_Of_Illness == 'Hearing Loss' ? 'selected' : '' }}>
                                                        Hearing Loss</option>
                                                    <option value="Injury"
                                                        {{ $EHS->Type_Of_Illness == 'Injury' ? 'selected' : '' }}>Injury
                                                    </option>
                                                    <option value="Poisoning"
                                                        {{ $EHS->Type_Of_Illness == 'Poisoning' ? 'selected' : '' }}>
                                                        Poisoning</option>
                                                    <option value="Respiratory Condition"
                                                        {{ $EHS->Type_Of_Illness == 'Respiratory Condition' ? 'selected' : '' }}>
                                                        Respiratory Condition</option>
                                                    <option value="Skin Disorder"
                                                        {{ $EHS->Type_Of_Illness == 'Skin Disorder' ? 'selected' : '' }}>
                                                        Skin Disorder</option>
                                                    <option value="All Other Illnesses"
                                                        {{ $EHS->Type_Of_Illness == 'All Other Illnesses' ? 'selected' : '' }}>
                                                        All Other Illnesses</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Permanent Disability?">Permanent Disability?</label>
                                                <select name="Permanent_Disability" id="Permanent_Disability"
                                                    data-search="false" data-silent-initial-value-set="true"
                                                    {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>
                                                    <option value="">-- Select --</option>
                                                    <option value="Yes"
                                                        {{ $EHS->Permanent_Disability == 'Yes' ? 'selected' : '' }}>Yes
                                                    </option>
                                                    <option value="No"
                                                        {{ $EHS->Permanent_Disability == 'No' ? 'selected' : '' }}>No
                                                    </option>
                                                    <option value="Na"
                                                        {{ $EHS->Permanent_Disability == 'Na' ? 'selected' : '' }}>Na
                                                    </option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="sub-head">
                                            Damage Information
                                        </div>
                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Damage Category">Damage Category</label>
                                                <select name="Damage_Category" id="Damage_Category"
                                                    data-search="false" data-silent-initial-value-set="true"
                                                    {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>
                                                    <option value="">-- Select --</option>
                                                    <option value="Barrier / Fence"
                                                        {{ $EHS->Damage_Category == 'Barrier / Fence' ? 'selected' : '' }}>
                                                        Barrier / Fence</option>
                                                    <option value="Building"
                                                        {{ $EHS->Damage_Category == 'Building' ? 'selected' : '' }}>
                                                        Building</option>
                                                    <option value="Equipment"
                                                        {{ $EHS->Damage_Category == 'Equipment' ? 'selected' : '' }}>
                                                        Equipment</option>
                                                    <option value="Pavement"
                                                        {{ $EHS->Damage_Category == 'Pavement' ? 'selected' : '' }}>
                                                        Pavement</option>
                                                    <option value="Tools"
                                                        {{ $EHS->Damage_Category == 'Tools' ? 'selected' : '' }}>Tools
                                                    </option> <!-- Corrected "No" to "Tools" -->
                                                    <option value="Vehicle"
                                                        {{ $EHS->Damage_Category == 'Vehicle' ? 'selected' : '' }}>Vehicle
                                                    </option>
                                                    <option value="Other"
                                                        {{ $EHS->Damage_Category == 'Other' ? 'selected' : '' }}>Other
                                                    </option>
                                                    <option value="NA"
                                                        {{ $EHS->Damage_Category == 'NA' ? 'selected' : '' }}>NA</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Related Equipment">Related Equipment</label>
                                                <div class="relative-container">
                                                    <input type="text" name="Related_Equipment"
                                                        id="Related_Equipment" value="{{ $EHS->Related_Equipment }}"
                                                        {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Estimated Amount Of Damage">Estimated Amount Of Damage</label>
                                                <input type="Number" name="Estimated_Amount_Of_Damage"
                                                    id="Estimated_Amount_Of_Damage" min="0"
                                                    value="{{ $EHS->Estimated_Amount_Of_Damage }}"
                                                    {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Currency">Currency</label>
                                                <select name="Currency" id="Currency" data-search="false"
                                                    data-silent-initial-value-set="true"
                                                    {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>
                                                    <option value="">-- Select --</option>
                                                    <option value="USD"
                                                        {{ $EHS->Currency == 'USD' ? 'selected' : '' }}>United States
                                                        Dollar (USD)</option>
                                                    <option value="EUR"
                                                        {{ $EHS->Currency == 'EUR' ? 'selected' : '' }}>Euro (EUR)
                                                    </option>
                                                    <option value="JPY"
                                                        {{ $EHS->Currency == 'JPY' ? 'selected' : '' }}>Japanese Yen (JPY)
                                                    </option>
                                                    <option value="GBP"
                                                        {{ $EHS->Currency == 'GBP' ? 'selected' : '' }}>British Pound
                                                        Sterling (GBP)</option>
                                                    <option value="AUD"
                                                        {{ $EHS->Currency == 'AUD' ? 'selected' : '' }}>Australian Dollar
                                                        (AUD)</option>
                                                    <option value="CAD"
                                                        {{ $EHS->Currency == 'CAD' ? 'selected' : '' }}>Canadian Dollar
                                                        (CAD)</option>
                                                    <option value="CHF"
                                                        {{ $EHS->Currency == 'CHF' ? 'selected' : '' }}>Swiss Franc (CHF)
                                                    </option>
                                                    <option value="CNY"
                                                        {{ $EHS->Currency == 'CNY' ? 'selected' : '' }}>Chinese Yuan (CNY)
                                                    </option>
                                                    <option value="INR"
                                                        {{ $EHS->Currency == 'INR' ? 'selected' : '' }}>Indian Rupee (INR)
                                                    </option>
                                                    <option value="RUB"
                                                        {{ $EHS->Currency == 'RUB' ? 'selected' : '' }}>Russian Ruble
                                                        (RUB)</option>
                                                    <option value="BRL"
                                                        {{ $EHS->Currency == 'BRL' ? 'selected' : '' }}>Brazilian Real
                                                        (BRL)</option>
                                                    <option value="ZAR"
                                                        {{ $EHS->Currency == 'ZAR' ? 'selected' : '' }}>South African Rand
                                                        (ZAR)</option>
                                                    <option value="MXN"
                                                        {{ $EHS->Currency == 'MXN' ? 'selected' : '' }}>Mexican Peso (MXN)
                                                    </option>
                                                    <option value="SGD"
                                                        {{ $EHS->Currency == 'SGD' ? 'selected' : '' }}>Singapore Dollar
                                                        (SGD)</option>
                                                    <option value="HKD"
                                                        {{ $EHS->Currency == 'HKD' ? 'selected' : '' }}>Hong Kong Dollar
                                                        (HKD)</option>
                                                    <option value="NZD"
                                                        {{ $EHS->Currency == 'NZD' ? 'selected' : '' }}>New Zealand Dollar
                                                        (NZD)</option>
                                                    <option value="KRW"
                                                        {{ $EHS->Currency == 'KRW' ? 'selected' : '' }}>South Korean Won
                                                        (KRW)</option>
                                                    <option value="SEK"
                                                        {{ $EHS->Currency == 'SEK' ? 'selected' : '' }}>Swedish Krona
                                                        (SEK)</option>
                                                    <option value="NOK"
                                                        {{ $EHS->Currency == 'NOK' ? 'selected' : '' }}>Norwegian Krone
                                                        (NOK)</option>
                                                    <option value="DKK"
                                                        {{ $EHS->Currency == 'DKK' ? 'selected' : '' }}>Danish Krone (DKK)
                                                    </option>
                                                    <option value="MYR"
                                                        {{ $EHS->Currency == 'MYR' ? 'selected' : '' }}>Malaysian Ringgit
                                                        (MYR)</option>
                                                    <option value="THB"
                                                        {{ $EHS->Currency == 'THB' ? 'selected' : '' }}>Thai Baht (THB)
                                                    </option>
                                                    <option value="IDR"
                                                        {{ $EHS->Currency == 'IDR' ? 'selected' : '' }}>Indonesian Rupiah
                                                        (IDR)</option>
                                                    <option value="PHP"
                                                        {{ $EHS->Currency == 'PHP' ? 'selected' : '' }}>Philippine Peso
                                                        (PHP)</option>
                                                    <option value="AED"
                                                        {{ $EHS->Currency == 'AED' ? 'selected' : '' }}>United Arab
                                                        Emirates Dirham (AED)</option>
                                                    <option value="SAR"
                                                        {{ $EHS->Currency == 'SAR' ? 'selected' : '' }}>Saudi Riyal (SAR)
                                                    </option>
                                                    <option value="TRY"
                                                        {{ $EHS->Currency == 'TRY' ? 'selected' : '' }}>Turkish Lira (TRY)
                                                    </option>
                                                    <option value="EGP"
                                                        {{ $EHS->Currency == 'EGP' ? 'selected' : '' }}>Egyptian Pound
                                                        (EGP)</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Insurance Company Involved?">Insurance Company
                                                    Involved?</label>
                                                <select name="Insurance_Company_Involved"
                                                    id="Insurance_Company_Involved" data-search="false"
                                                    data-silent-initial-value-set="true"
                                                    {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>
                                                    <option value="">-- Select --</option>
                                                    <option value="Yes"
                                                        {{ $EHS->Insurance_Company_Involved == 'Yes' ? 'selected' : '' }}>
                                                        Yes</option>
                                                    <option value="No"
                                                        {{ $EHS->Insurance_Company_Involved == 'No' ? 'selected' : '' }}>
                                                        No</option>
                                                    <option value="Na"
                                                        {{ $EHS->Insurance_Company_Involved == 'Na' ? 'selected' : '' }}>
                                                        Na</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Denied By Insurance Company">Denied By Insurance
                                                    Company</label>
                                                <select name="Denied_By_Insurance_Company"
                                                    id="Denied_By_Insurance_Company" data-search="false"
                                                    data-silent-initial-value-set="true"
                                                    {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>
                                                    <option value="">-- Select --</option>
                                                    <option value="Yes"
                                                        {{ $EHS->Denied_By_Insurance_Company == 'Yes' ? 'selected' : '' }}>
                                                        Yes</option>
                                                    <option value="No"
                                                        {{ $EHS->Denied_By_Insurance_Company == 'No' ? 'selected' : '' }}>
                                                        No</option>
                                                    <option value="Na"
                                                        {{ $EHS->Denied_By_Insurance_Company == 'Na' ? 'selected' : '' }}>
                                                        Na</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Damage Details">Damage Details</label>
                                                <div class="relative-container">
                                                    <textarea name="Damage_Details" id="Damage_Details" {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>{{ $EHS->Damage_Details }}</textarea>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="button-block">
                                        <button type="submit" class="saveButton">Save</button>
                                        <button type="button" class="backButton"
                                            onclick="previousStep()">Back</button>
                                        <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                        <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}"
                                                class="text-white">
                                                Exit </a> </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Audit Execution content -->
                            <div id="CCForm4" class="inner-block cctabcontent">
                                <div class="inner-block-content">

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Actual Amount Of Damage">Actual Amount Of Damage</label>
                                                <input type="Number" name="Actual_Amount_Of_Damage"
                                                    id="Actual_Amount_Of_Damage" min="0"
                                                    value="{{ $EHS->Actual_Amount_Of_Damage }}"
                                                    {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Currency">Currency</label>
                                                <select name="Currency2" id="Currency2" data-search="false"
                                                    data-silent-initial-value-set="true"
                                                    {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>
                                                    <option value="">-- Select --</option>
                                                    <option value="USD"
                                                        {{ $EHS->Currency2 == 'USD' ? 'selected' : '' }}>United States
                                                        Dollar (USD)</option>
                                                    <option value="EUR"
                                                        {{ $EHS->Currency2 == 'EUR' ? 'selected' : '' }}>Euro (EUR)
                                                    </option>
                                                    <option value="JPY"
                                                        {{ $EHS->Currency2 == 'JPY' ? 'selected' : '' }}>Japanese Yen
                                                        (JPY)</option>
                                                    <option value="GBP"
                                                        {{ $EHS->Currency2 == 'GBP' ? 'selected' : '' }}>British Pound
                                                        Sterling (GBP)</option>
                                                    <option value="AUD"
                                                        {{ $EHS->Currency2 == 'AUD' ? 'selected' : '' }}>Australian Dollar
                                                        (AUD)</option>
                                                    <option value="CAD"
                                                        {{ $EHS->Currency2 == 'CAD' ? 'selected' : '' }}>Canadian Dollar
                                                        (CAD)</option>
                                                    <option value="CHF"
                                                        {{ $EHS->Currency2 == 'CHF' ? 'selected' : '' }}>Swiss Franc (CHF)
                                                    </option>
                                                    <option value="CNY"
                                                        {{ $EHS->Currency2 == 'CNY' ? 'selected' : '' }}>Chinese Yuan
                                                        (CNY)</option>
                                                    <option value="INR"
                                                        {{ $EHS->Currency2 == 'INR' ? 'selected' : '' }}>Indian Rupee
                                                        (INR)</option>
                                                    <option value="RUB"
                                                        {{ $EHS->Currency2 == 'RUB' ? 'selected' : '' }}>Russian Ruble
                                                        (RUB)</option>
                                                    <option value="BRL"
                                                        {{ $EHS->Currency2 == 'BRL' ? 'selected' : '' }}>Brazilian Real
                                                        (BRL)</option>
                                                    <option value="ZAR"
                                                        {{ $EHS->Currency2 == 'ZAR' ? 'selected' : '' }}>South African
                                                        Rand (ZAR)</option>
                                                    <option value="MXN"
                                                        {{ $EHS->Currency2 == 'MXN' ? 'selected' : '' }}>Mexican Peso
                                                        (MXN)</option>
                                                    <option value="SGD"
                                                        {{ $EHS->Currency2 == 'SGD' ? 'selected' : '' }}>Singapore Dollar
                                                        (SGD)</option>
                                                    <option value="HKD"
                                                        {{ $EHS->Currency2 == 'HKD' ? 'selected' : '' }}>Hong Kong Dollar
                                                        (HKD)</option>
                                                    <option value="NZD"
                                                        {{ $EHS->Currency2 == 'NZD' ? 'selected' : '' }}>New Zealand
                                                        Dollar (NZD)</option>
                                                    <option value="KRW"
                                                        {{ $EHS->Currency2 == 'KRW' ? 'selected' : '' }}>South Korean Won
                                                        (KRW)</option>
                                                    <option value="SEK"
                                                        {{ $EHS->Currency2 == 'SEK' ? 'selected' : '' }}>Swedish Krona
                                                        (SEK)</option>
                                                    <option value="NOK"
                                                        {{ $EHS->Currency2 == 'NOK' ? 'selected' : '' }}>Norwegian Krone
                                                        (NOK)</option>
                                                    <option value="DKK"
                                                        {{ $EHS->Currency2 == 'DKK' ? 'selected' : '' }}>Danish Krone
                                                        (DKK)</option>
                                                    <option value="MYR"
                                                        {{ $EHS->Currency2 == 'MYR' ? 'selected' : '' }}>Malaysian Ringgit
                                                        (MYR)</option>
                                                    <option value="THB"
                                                        {{ $EHS->Currency2 == 'THB' ? 'selected' : '' }}>Thai Baht (THB)
                                                    </option>
                                                    <option value="IDR"
                                                        {{ $EHS->Currency2 == 'IDR' ? 'selected' : '' }}>Indonesian Rupiah
                                                        (IDR)</option>
                                                    <option value="PHP"
                                                        {{ $EHS->Currency2 == 'PHP' ? 'selected' : '' }}>Philippine Peso
                                                        (PHP)</option>
                                                    <option value="AED"
                                                        {{ $EHS->Currency2 == 'AED' ? 'selected' : '' }}>United Arab
                                                        Emirates Dirham (AED)</option>
                                                    <option value="SAR"
                                                        {{ $EHS->Currency2 == 'SAR' ? 'selected' : '' }}>Saudi Riyal (SAR)
                                                    </option>
                                                    <option value="TRY"
                                                        {{ $EHS->Currency2 == 'TRY' ? 'selected' : '' }}>Turkish Lira
                                                        (TRY)</option>
                                                    <option value="EGP"
                                                        {{ $EHS->Currency2 == 'EGP' ? 'selected' : '' }}>Egyptian Pound
                                                        (EGP)</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Investigation Summary">Investigation Summary</label>
                                                <div class="relative-container">
                                                    <textarea name="Investigation_Summary" id="Investigation_Summary"
                                                        {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>{{ $EHS->Investigation_Summary }}</textarea>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Conclusion">Conclusion</label>
                                                <div class="relative-container">
                                                    <textarea name="Conclusion" id="Conclusion" {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>{{ $EHS->Conclusion }}</textarea>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="button-block">
                                        <button type="submit" class="saveButton">Save</button>
                                        <button type="button" class="backButton"
                                            onclick="previousStep()">Back</button>
                                        <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                        <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}"
                                                class="text-white">
                                                Exit </a> </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Audit Response & Closure content -->
                            <div id="CCForm5" class="inner-block cctabcontent">
                                <div class="inner-block-content">
                                    <div class="row">
                                        <div class="sub-head">
                                            Root Cause Analysis
                                        </div>
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="root-cause-methodology">Root Cause Methodology</label>
                                                @php
                                                    $selectedMethodologies = explode(',', $EHS->root_cause_methodology);
                                                @endphp
                                                <select name="root_cause_methodology[]" multiple
                                                    {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}
                                                    id="root-cause-methodology">
                                                    <option value="Why-Why Chart"
                                                        @if (in_array('Why-Why Chart', $selectedMethodologies)) selected @endif>Why-Why Chart
                                                    </option>
                                                    <option value="Failure Mode and Effect Analysis"
                                                        @if (in_array('Failure Mode and Effect Analysis', $selectedMethodologies)) selected @endif>Failure Mode and
                                                        Effect
                                                        Analysis</option>
                                                    <option value="Fishbone or Ishikawa Diagram"
                                                        @if (in_array('Fishbone or Ishikawa Diagram', $selectedMethodologies)) selected @endif>Fishbone or
                                                        Ishikawa
                                                        Diagram</option>
                                                    <option value="Is/Is Not Analysis"
                                                        @if (in_array('Is/Is Not Analysis', $selectedMethodologies)) selected @endif>Is/Is Not
                                                        Analysis
                                                    </option>
                                                    <option value="Rootcauseothers"
                                                        @if (in_array('Rootcauseothers', $selectedMethodologies)) selected @endif>Others
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        {{-- <div class="col-6">
                                            <div id="rootCause" class="group-input" style="display: none;">
                                                <label for="otherFieldsUser">Other (Root Cause Methodology)</label>
                                                <textarea name="other_root_cause_methodology" id="summernote"></textarea>
                                            </div>
                                        </div> --}}

                                        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

                                        <script>
                                            $(document).ready(function() {
                                                // Function to check the current value of the select and toggle the input field
                                                function toggleOtherField() {
                                                    const selectedVals = $('#root-cause-methodology').val();
                                                    if (selectedVals && selectedVals.includes('Other_Detail')) {
                                                        $('#rootCause').show();
                                                    } else {
                                                        $('#rootCause').hide();
                                                    }
                                                }

                                                // Bind the change event to the select field
                                                $('#root-cause-methodology').change(function() {
                                                    toggleOtherField();
                                                });

                                                // Check the current value when the page loads
                                                toggleOtherField();
                                            });
                                        </script>


                                        <div class="col-12 mb-4" id="fmea-section" style="display:none;">
                                            <div class="group-input">
                                                <label for="agenda">
                                                    Failure Mode and Effect Analysis
                                                    <button type="button" name="agenda"
                                                        onclick="addRootCauseAnalysisRiskAssessment('risk-assessment-risk-management')"
                                                        {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>+</button>
                                                </label>
                                                <div class="table-responsive">
                                                    <table class="table table-bordered" style="width: 200%"
                                                        id="risk-assessment-risk-management">
                                                        <thead>
                                                            <tr>
                                                                <th colspan="1"style="text-align:center;"></th>
                                                                <th colspan="2"style="text-align:center;">Risk
                                                                    Identification</th>
                                                                <th colspan="1"style="text-align:center;">Risk Analysis
                                                                </th>
                                                                <th colspan="4"style="text-align:center;">Risk
                                                                    Evaluation</th>
                                                                <th colspan="1"style="text-align:center;">Risk Control
                                                                </th>
                                                                <th colspan="6"style="text-align:center;">Risk
                                                                    Evaluation</th>
                                                                <th colspan="2"style="text-align:center;"></th>
                                                            </tr>
                                                            <tr>
                                                                <th>Row #</th>
                                                                <th>Activity</th>
                                                                <th>Possible Risk/Failure (Identified Risk)</th>
                                                                <th>Consequences of Risk/Potential Causes</th>
                                                                <th>Severity (S)</th>
                                                                <th>Probability (P)</th>
                                                                <th>Detection (D)</th>
                                                                <th>RPN</th>
                                                                <th>Control Measures recommended/ Risk mitigation proposed
                                                                </th>
                                                                <th>Severity (S)</th>
                                                                <th>Probability (P)</th>
                                                                <th>Detection (D)</th>
                                                                <th>Risk Level (RPN)</th>
                                                                <th>Category of Risk Level (Low, Medium and High)</th>
                                                                <th>Risk Acceptance (Y/N)</th>
                                                                <th>Traceability document</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @if (!empty($EHS->risk_factor))
                                                                @foreach (unserialize($EHS->risk_factor) as $key => $riskFactor)
                                                                    <tr>
                                                                        <td>{{ $key + 1 }}</td>
                                                                        <td><input name="risk_factor[]" type="text"
                                                                                value="{{ $riskFactor }}"
                                                                                {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>
                                                                        </td>
                                                                        <td><input name="risk_element[]"type="text"
                                                                                value="{{ unserialize($EHS->risk_element)[$key] ?? null }}"
                                                                                {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>
                                                                        </td>
                                                                        <td><input name="problem_cause[]" type="text"
                                                                                value="{{ unserialize($EHS->problem_cause)[$key] ?? null }}"
                                                                                {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>
                                                                        </td>

                                                                        <td>
                                                                            <select
                                                                                onchange="calculateInitialResult(this)"
                                                                                class="fieldR" name="initial_severity[]"
                                                                                {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>
                                                                                <option value="">-- Select --
                                                                                </option>
                                                                                <option value="1"
                                                                                    {{ (unserialize($EHS->initial_severity)[$key] ?? null) == 1 ? 'selected' : '' }}>
                                                                                    1-Insignificant</option>
                                                                                <option value="2"
                                                                                    {{ (unserialize($EHS->initial_severity)[$key] ?? null) == 2 ? 'selected' : '' }}>
                                                                                    2-Minor</option>
                                                                                <option value="3"
                                                                                    {{ (unserialize($EHS->initial_severity)[$key] ?? null) == 3 ? 'selected' : '' }}>
                                                                                    3-Major</option>
                                                                                <option value="4"
                                                                                    {{ (unserialize($EHS->initial_severity)[$key] ?? null) == 4 ? 'selected' : '' }}>
                                                                                    4-Critical</option>
                                                                                <option value="5"
                                                                                    {{ (unserialize($EHS->initial_severity)[$key] ?? null) == 5 ? 'selected' : '' }}>
                                                                                    5-Catastrophic</option>
                                                                            </select>
                                                                        </td>
                                                                        <td>
                                                                            <select
                                                                                onchange="calculateInitialResult(this)"
                                                                                class="fieldP"
                                                                                name="initial_detectability[]"
                                                                                {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>
                                                                                <option value="">-- Select --
                                                                                </option>
                                                                                <option value="1"
                                                                                    {{ (unserialize($EHS->initial_detectability)[$key] ?? null) == 1 ? 'selected' : '' }}>
                                                                                    1-Very rare</option>
                                                                                <option value="2"
                                                                                    {{ (unserialize($EHS->initial_detectability)[$key] ?? null) == 2 ? 'selected' : '' }}>
                                                                                    2-Unlikely</option>
                                                                                <option value="3"
                                                                                    {{ (unserialize($EHS->initial_detectability)[$key] ?? null) == 3 ? 'selected' : '' }}>
                                                                                    3-Possibly</option>
                                                                                <option value="4"
                                                                                    {{ (unserialize($EHS->initial_detectability)[$key] ?? null) == 4 ? 'selected' : '' }}>
                                                                                    4-Likely</option>
                                                                                <option value="5"
                                                                                    {{ (unserialize($EHS->initial_detectability)[$key] ?? null) == 5 ? 'selected' : '' }}>
                                                                                    5-Almost certain (every time)</option>
                                                                            </select>
                                                                        </td>
                                                                        <td>
                                                                            <select
                                                                                onchange="calculateInitialResult(this)"
                                                                                class="fieldN"
                                                                                name="initial_probability[]"
                                                                                {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>
                                                                                <option value="">-- Select --
                                                                                </option>
                                                                                <option value="1"
                                                                                    {{ (unserialize($EHS->initial_probability)[$key] ?? null) == 1 ? 'selected' : '' }}>
                                                                                    1-Always detected</option>
                                                                                <option value="2"
                                                                                    {{ (unserialize($EHS->initial_probability)[$key] ?? null) == 2 ? 'selected' : '' }}>
                                                                                    2-Likely to detect</option>
                                                                                <option value="3"
                                                                                    {{ (unserialize($EHS->initial_probability)[$key] ?? null) == 3 ? 'selected' : '' }}>
                                                                                    3-Possible to detect</option>
                                                                                <option value="4"
                                                                                    {{ (unserialize($EHS->initial_probability)[$key] ?? null) == 4 ? 'selected' : '' }}>
                                                                                    4-Unlikely to detect</option>
                                                                                <option value="5"
                                                                                    {{ (unserialize($EHS->initial_probability)[$key] ?? null) == 5 ? 'selected' : '' }}>
                                                                                    5-Not detectable</option>
                                                                            </select>
                                                                        </td>
                                                                        <td><input name="initial_rpn[]" type="text"
                                                                                class='initial-rpn'
                                                                                value="{{ unserialize($EHS->initial_rpn)[$key] ?? null }}"
                                                                                readonly
                                                                                {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>
                                                                        </td>
                                                                        <td><input name="risk_control_measure[]"
                                                                                type="text"
                                                                                value="{{ unserialize($EHS->risk_control_measure)[$key] ?? null }}"
                                                                                {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>
                                                                        </td>
                                                                        <td>
                                                                            <select
                                                                                onchange="calculateResidualResult(this)"
                                                                                class="residual-fieldR"
                                                                                name="residual_severity[]"
                                                                                {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>
                                                                                <option value="">-- Select --
                                                                                </option>
                                                                                <option value="1"
                                                                                    {{ (unserialize($EHS->residual_severity)[$key] ?? null) == 1 ? 'selected' : '' }}>
                                                                                    1-Insignificant</option>
                                                                                <option value="2"
                                                                                    {{ (unserialize($EHS->residual_severity)[$key] ?? null) == 2 ? 'selected' : '' }}>
                                                                                    2-Minor</option>
                                                                                <option value="3"
                                                                                    {{ (unserialize($EHS->residual_severity)[$key] ?? null) == 3 ? 'selected' : '' }}>
                                                                                    3-Major</option>
                                                                                <option value="4"
                                                                                    {{ (unserialize($EHS->residual_severity)[$key] ?? null) == 4 ? 'selected' : '' }}>
                                                                                    4-Critical</option>
                                                                                <option value="5"
                                                                                    {{ (unserialize($EHS->residual_severity)[$key] ?? null) == 5 ? 'selected' : '' }}>
                                                                                    5-Catastrophic</option>
                                                                            </select>
                                                                        </td>
                                                                        <td>
                                                                            <select
                                                                                onchange="calculateResidualResult(this)"
                                                                                class="residual-fieldP"
                                                                                name="residual_probability[]"
                                                                                {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>
                                                                                <option value="">-- Select --
                                                                                </option>
                                                                                <option value="1"
                                                                                    {{ (unserialize($EHS->residual_probability)[$key] ?? null) == 1 ? 'selected' : '' }}>
                                                                                    1-Very rare</option>
                                                                                <option value="2"
                                                                                    {{ (unserialize($EHS->residual_probability)[$key] ?? null) == 2 ? 'selected' : '' }}>
                                                                                    2-Unlikely</option>
                                                                                <option value="3"
                                                                                    {{ (unserialize($EHS->residual_probability)[$key] ?? null) == 3 ? 'selected' : '' }}>
                                                                                    3-Possibly</option>
                                                                                <option value="4"
                                                                                    {{ (unserialize($EHS->residual_probability)[$key] ?? null) == 4 ? 'selected' : '' }}>
                                                                                    4-Likely</option>
                                                                                <option value="5"
                                                                                    {{ (unserialize($EHS->residual_probability)[$key] ?? null) == 5 ? 'selected' : '' }}>
                                                                                    5-Almost certain (every time)</option>
                                                                            </select>
                                                                        </td>
                                                                        <td>
                                                                            <select
                                                                                onchange="calculateResidualResult(this)"
                                                                                class="residual-fieldN"
                                                                                name="residual_detectability[]"
                                                                                {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>
                                                                                <option value="">-- Select --
                                                                                </option>
                                                                                <option value="1"
                                                                                    {{ (unserialize($EHS->residual_detectability)[$key] ?? null) == 1 ? 'selected' : '' }}>
                                                                                    1-Always detected</option>
                                                                                <option value="2"
                                                                                    {{ (unserialize($EHS->residual_detectability)[$key] ?? null) == 2 ? 'selected' : '' }}>
                                                                                    2-Likely to detect</option>
                                                                                <option value="3"
                                                                                    {{ (unserialize($EHS->residual_detectability)[$key] ?? null) == 3 ? 'selected' : '' }}>
                                                                                    3-Possible to detect</option>
                                                                                <option value="4"
                                                                                    {{ (unserialize($EHS->residual_detectability)[$key] ?? null) == 4 ? 'selected' : '' }}>
                                                                                    4-Unlikely to detect</option>
                                                                                <option value="5"
                                                                                    {{ (unserialize($EHS->residual_detectability)[$key] ?? null) == 5 ? 'selected' : '' }}>
                                                                                    5-Not detectable</option>
                                                                            </select>
                                                                        </td>
                                                                        <td><input name="residual_rpn[]" type="text"
                                                                                class='residual-rpn'
                                                                                value="{{ unserialize($EHS->residual_rpn)[$key] ?? null }}"
                                                                                readonly></td>
                                                                        <td>
                                                                            <input name="risk_acceptance[]" readonly
                                                                                class="risk-acceptance"
                                                                                value="{{ unserialize($EHS->risk_acceptance)[$key] ?? '' }}"
                                                                                readonly
                                                                                {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>
                                                                        </td>
                                                                        <td>
                                                                            <select name="risk_acceptance2[]"
                                                                                {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>
                                                                                <option value="">-- Select --
                                                                                </option>
                                                                                <option value="N"
                                                                                    {{ (unserialize($EHS->risk_acceptance2)[$key] ?? null) == 'N' ? 'selected' : '' }}>
                                                                                    N</option>
                                                                                <option value="Y"
                                                                                    {{ (unserialize($EHS->risk_acceptance2)[$key] ?? null) == 'Y' ? 'selected' : '' }}>
                                                                                    Y</option>
                                                                            </select>
                                                                        </td>
                                                                        <td><input name="mitigation_proposal[]"
                                                                                type="text"
                                                                                value="{{ unserialize($EHS->mitigation_proposal)[$key] ?? null }}"
                                                                                {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>
                                                                        </td>
                                                                        <td> <button class="btn btn-dark removeBtn"
                                                                                {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>Remove</button>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12" id="fishbone-section" style="display:none;">
                                            <div class="group-input">
                                                <label for="fishbone">
                                                    Fishbone or Ishikawa Diagram
                                                    <button type="button" name="agenda"
                                                        onclick="addFishBone('.top-field-group', '.bottom-field-group')"{{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>+</button>
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
                                                                @if (!empty($EHS->measurement))
                                                                    @foreach (unserialize($EHS->measurement) as $key => $measure)
                                                                        <div><input type="text"
                                                                                value="{{ $measure }}"
                                                                                name="measurement[]"{{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>
                                                                        </div>
                                                                        <div><input type="text"
                                                                                value="{{ unserialize($EHS->materials)[$key] ? unserialize($EHS->materials)[$key] : '' }}"
                                                                                name="materials[]"{{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>
                                                                        </div>
                                                                        <div><input type="text"
                                                                                value="{{ unserialize($EHS->methods)[$key] ?? null }}"
                                                                                name="methods[]"{{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>
                                                                        </div>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="mid"></div>
                                                        <div class="bottom-field-group">
                                                            <div class="grid-field fields bottom-field">
                                                                @if (!empty($EHS->environment))
                                                                    @foreach (unserialize($EHS->environment) as $key => $measure)
                                                                        <div><input type="text"
                                                                                value="{{ $measure }}"
                                                                                name="environment[]"{{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>
                                                                        </div>
                                                                        <div><input type="text"
                                                                                value="{{ unserialize($EHS->manpower)[$key] ? unserialize($EHS->manpower)[$key] : '' }}"
                                                                                name="manpower[]"{{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>
                                                                        </div>
                                                                        <div><input type="text"
                                                                                value="{{ unserialize($EHS->machine)[$key] ? unserialize($EHS->machine)[$key] : '' }}"
                                                                                name="machine[]"{{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>
                                                                        </div>
                                                                    @endforeach
                                                                @endif

                                                            </div>
                                                        </div>
                                                        <div class="grid-field field-name">
                                                            <div>Mother Environment</div>
                                                            <div>Man</div>
                                                            <div>Machine</div>
                                                        </div>
                                                    </div>
                                                    <div class="right-group">
                                                        <div class="field-name">
                                                            Problem Statement
                                                        </div>
                                                        <div class="field">
                                                            {{-- <textarea name="problem_statement"{{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>{{ $EHS->problem_statement }}</textarea> --}}

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12" id="HideInference" style="display:none;">
                                            <div class="group-input">
                                                <label for="Inference">
                                                    Inference
                                                    <button type="button"
                                                        onclick="addInference('Inference')"{{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>+</button>
                                                </label>
                                                <div class="table-responsive">
                                                    <table class="table table-bordered" id="Inference">
                                                        <thead>
                                                            <tr>
                                                                <th style="width:5%">Row #</th>
                                                                <th>Type</th>
                                                                <th>Remarks</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @if (!empty($data->inference_type) && !empty($data->inference_remarks))
                                                                @php
                                                                    $inference_types = unserialize(
                                                                        $data->inference_type,
                                                                    );
                                                                    $inference_remarks = unserialize(
                                                                        $data->inference_remarks,
                                                                    );
                                                                @endphp

                                                                @foreach ($inference_types as $key => $inference_type)
                                                                    <tr>
                                                                        <td>
                                                                            <input disabled type="text"
                                                                                name="serial_number[]"
                                                                                value="{{ $key + 1 }}"
                                                                                {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>
                                                                        </td>
                                                                        <td>
                                                                            <select name="inference_type[]"
                                                                                {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>
                                                                                <option value="">-- Select --
                                                                                </option>
                                                                                <option value="Measurement"
                                                                                    {{ $inference_type == 'Measurement' ? 'selected' : '' }}>
                                                                                    Measurement</option>
                                                                                <option value="Materials"
                                                                                    {{ $inference_type == 'Materials' ? 'selected' : '' }}>
                                                                                    Materials</option>
                                                                                <option value="Methods"
                                                                                    {{ $inference_type == 'Methods' ? 'selected' : '' }}>
                                                                                    Methods</option>
                                                                                <option value=" Mother Environment"
                                                                                    {{ $inference_type == ' Mother Environment' ? 'selected' : '' }}>
                                                                                    Mother Environment</option>
                                                                                <option value="Man"
                                                                                    {{ $inference_type == 'Manp' ? 'selected' : '' }}>
                                                                                    Manp</option>
                                                                                <option value="Machine"
                                                                                    {{ $inference_type == 'Machine' ? 'selected' : '' }}>
                                                                                    Machine</option>
                                                                            </select>
                                                                        </td>
                                                                        <td>
                                                                            <input type="text"
                                                                                name="inference_remarks[]"
                                                                                value="{{ $inference_remarks[$key] ?? '' }}"
                                                                                {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>
                                                                        </td>
                                                                        <td>
                                                                            <button type="button" class="removeRowBtn"
                                                                                {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>Remove</button>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            @endif
                                                        </tbody>

                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <script>
                                            function addWhyField(containerClass, fieldName) {
                                                let container = document.querySelector('.' + containerClass);

                                                // Create the textarea
                                                let textarea = document.createElement('textarea');
                                                textarea.name = fieldName;

                                                // Create the remove button
                                                let removeButton = document.createElement('span');
                                                removeButton.innerText = 'Remove';
                                                removeButton.style.cursor = 'pointer';
                                                removeButton.style.color = 'red';
                                                removeButton.onclick = function() {
                                                    removeWhyField(this);
                                                };

                                                let fieldWrapper = document.createElement('div');
                                                fieldWrapper.classList.add('why-field-wrapper');
                                                fieldWrapper.appendChild(textarea);
                                                fieldWrapper.appendChild(removeButton);

                                                container.appendChild(fieldWrapper);
                                            }

                                            function removeWhyField(button) {
                                                let fieldWrapper = button.parentNode; // Get the wrapper div
                                                fieldWrapper.remove(); // Remove the wrapper div, which removes the textarea and the remove button
                                            }
                                        </script>
                                        <div class="col-12" id="why-why-chart-section" style="display:none;">
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
                                                                <th style="width:150px;">Problem Statement</th>
                                                                <td>
                                                                    <textarea name="why_problem_statement" {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>{{ $data->why_problem_statement }}</textarea>
                                                                </td>
                                                            </tr>

                                                            @foreach (range(1, 5) as $why_number)
                                                                <tr class="why-row">
                                                                    <th style="width:150px; color: #393cd4;">
                                                                        Why {{ $why_number }}
                                                                        <span
                                                                            onclick="addWhyField('why_{{ $why_number }}_block', 'why_{{ $why_number }}[]')"
                                                                            {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>+</span>
                                                                    </th>
                                                                    <td>
                                                                        <div class="why_{{ $why_number }}_block">
                                                                            @if (!empty($data['why_' . $why_number]))
                                                                                @foreach (unserialize($data['why_' . $why_number]) as $key => $measure)
                                                                                    <div class="why-field-wrapper">
                                                                                        <textarea name="why_{{ $why_number }}[]" {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>{{ $measure }}</textarea>
                                                                                        <span class="remove-field"
                                                                                            onclick="removeWhyField(this)"
                                                                                            style="cursor:pointer; color:red;">Remove</span>
                                                                                    </div>
                                                                                @endforeach
                                                                            @endif
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @endforeach

                                                            <tr style="background: #0080006b;">
                                                                <th style="width:150px;">Root Cause :</th>
                                                                <td>
                                                                    <textarea name="why_root_cause"{{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>{{ $data->why_root_cause }}</textarea>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 sub-head"></div>

                                        <div class="col-12" id="is-is-not-section" style="display:none;">
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
                                                                    <textarea name="what_will_be" {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>{{ $data->what_will_be }}</textarea>
                                                                </td>
                                                                <td>
                                                                    <textarea name="what_will_not_be" {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>{{ $data->what_will_not_be }}</textarea>
                                                                </td>
                                                                <td>
                                                                    <textarea name="what_rationable"{{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}> {{ $data->what_rationable }}</textarea>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th style="background: #0039bd85">Where</th>
                                                                <td>
                                                                    <textarea name="where_will_be"{{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}> {{ $data->where_will_be }}</textarea>
                                                                </td>
                                                                <td>
                                                                    <textarea name="where_will_not_be"{{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}> {{ $data->where_will_not_be }}</textarea>
                                                                </td>
                                                                <td>
                                                                    <textarea name="where_rationable"{{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}> {{ $data->where_rationable }}</textarea>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th style="background: #0039bd85">When</th>
                                                                <td>
                                                                    <textarea name="when_will_be"{{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}> {{ $data->when_will_be }}</textarea>
                                                                </td>
                                                                <td>
                                                                    <textarea name="when_will_not_be"{{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>{{ $data->when_will_not_be }}</textarea>
                                                                </td>
                                                                <td>
                                                                    <textarea name="when_rationable"{{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}> {{ $data->when_rationable }}</textarea>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th style="background: #0039bd85">Why</th>
                                                                <td>
                                                                    <textarea name="coverage_will_be"{{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}> {{ $data->coverage_will_be }}</textarea>
                                                                </td>
                                                                <td>
                                                                    <textarea name="coverage_will_not_be"{{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}> {{ $data->coverage_will_not_be }}</textarea>
                                                                </td>
                                                                <td>
                                                                    <textarea name="coverage_rationable"{{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}> {{ $data->coverage_rationable }}</textarea>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th style="background: #0039bd85">Who</th>
                                                                <td>
                                                                    <textarea name="who_will_be"{{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}> {{ $data->who_will_be }}</textarea>
                                                                </td>
                                                                <td>
                                                                    <textarea name="who_will_not_be"{{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}> {{ $data->who_will_not_be }}</textarea>
                                                                </td>
                                                                <td>
                                                                    <textarea name="who_rationable"{{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}> {{ $data->who_rationable }}</textarea>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="root_cause">
                                                    Root Cause
                                                    <button type="button"
                                                        {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}
                                                        name="audit-incident-grid" id="Root_Cause_Add">+</button>
                                                    <span class="text-primary" data-bs-toggle="modal"
                                                        data-bs-target="#observation-field-instruction-modal"
                                                        style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                                        (Launch Instruction)
                                                    </span>
                                                </label>

                                                <table class="table table-bordered" id="Root_Cause_Add_field_table">
                                                    <thead>
                                                        <tr>
                                                            <th>Row#</th>
                                                            <th>Root Cause Category</th>
                                                            <th>Root Cause Sub Category</th>
                                                            <th>Probability</th>
                                                            <th>Comments</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                            $serialNumber = 1;
                                                        @endphp
                                                        @foreach ($RootCauseInfo->data1 as $oogrid)
                                                            <tr>
                                                                <td disabled>{{ $serialNumber++ }}</td>
                                                                <td>
                                                                    <input type="text"
                                                                        {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}
                                                                        name="RootCause[{{ $loop->index }}][Root_Cause_Category]"
                                                                        value="{{ $oogrid['Root_Cause_Category'] }}">
                                                                </td>
                                                                <td>
                                                                    <input type="text"
                                                                        {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}
                                                                        name="RootCause[{{ $loop->index }}][Root_Cause_Sub_Category]"
                                                                        value="{{ $oogrid['Root_Cause_Sub_Category'] }}">
                                                                </td>
                                                                <td>
                                                                    <input type="text"
                                                                        {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}
                                                                        name="RootCause[{{ $loop->index }}][Probability]"
                                                                        value="{{ $oogrid['Probability'] }}">
                                                                </td>
                                                                <td>
                                                                    <input type="text"
                                                                        {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}
                                                                        name="RootCause[{{ $loop->index }}][Comments]"
                                                                        value="{{ $oogrid['Comments'] }}">
                                                                </td>

                                                                <td>
                                                                    <button class="removeRowBtn"
                                                                        {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>Remove</button>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <script>
                                            $(document).ready(function() {
                                                let investdetails = 1;
                                                $('#Root_Cause_Add').click(function(e) {
                                                    function generateTableRow(serialNumber) {
                                                        var html =
                                                            '<tr>' +
                                                            '<td><input disabled type="text" style ="width:15px" value="' + serialNumber +
                                                            '"></td>' +
                                                            '<td><input type="text"  {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}  name="RootCause[' +
                                                            investdetails + '][Root_Cause_Category]" value=""></td>' +
                                                            '<td><input type="text"  {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}  name="RootCause[' +
                                                            investdetails + '][Root_Cause_Sub_Category]" value=""></td>' +
                                                            '<td><input type="text"  {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }} name="RootCause[' +
                                                            investdetails + '][Probability]" value=""></td>' +
                                                            '<td><input type="text"  {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}  name="RootCause[' +
                                                            investdetails + '][Comments]" value=""></td>' +
                                                            '<td><button class="removeRowBtn"  {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>Remove</button>' +

                                                            '</tr>';
                                                        investdetails++; // Increment the row number here
                                                        return html;
                                                    }

                                                    var tableBody = $('#Root_Cause_Add_field_table tbody');
                                                    var rowCount = tableBody.children('tr').length;
                                                    var newRow = generateTableRow(rowCount + 1);
                                                    tableBody.append(newRow);
                                                });
                                                $(document).on('click', '.removeRowBtn', function() {
                                                    $(this).closest('tr').remove();
                                                });
                                            });
                                        </script>

                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Root Cause Description">Root Cause Description</label>
                                                <div class="relative-container">
                                                    <textarea name="Root_Cause_Description" {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>{{ $EHS->Root_Cause_Description }}</textarea>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>

                                        <div class="sub-head">
                                            Risk Factors
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Safety Impact Probability">Safety Impact Probability</label>
                                                <select name="Safety_Impact_Probability" id="safetyProbability"
                                                    onchange='calculateRiskAnalysis("safety")'
                                                    {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>
                                                    <option value="">Enter Your Selection Here</option>
                                                    <option value="1"
                                                        {{ $EHS->Safety_Impact_Probability == '1' ? 'selected' : '' }}>Low
                                                        - Almost Improbable (1)</option>
                                                    <option value="2"
                                                        {{ $EHS->Safety_Impact_Probability == '2' ? 'selected' : '' }}>
                                                        Medium - Occasional (2)</option>
                                                    <option value="3"
                                                        {{ $EHS->Safety_Impact_Probability == '3' ? 'selected' : '' }}>
                                                        High - Frequent (3)</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Safety Impact Severity">Safety Impact Severity</label>
                                                <select name="Safety_Impact_Severity" id="safetySeverity"
                                                    onchange='calculateRiskAnalysis("safety")'
                                                    {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>
                                                    <option value="">Enter Your Selection Here</option>
                                                    <option value="1"
                                                        {{ $EHS->Safety_Impact_Severity == '1' ? 'selected' : '' }}>
                                                        Negligible (1)</option>
                                                    <option value="2"
                                                        {{ $EHS->Safety_Impact_Severity == '2' ? 'selected' : '' }}>
                                                        Marginal (2)</option>
                                                    <option value="3"
                                                        {{ $EHS->Safety_Impact_Severity == '3' ? 'selected' : '' }}>
                                                        Critical (3)</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Legal Impact Probability">Legal Impact Probability</label>
                                                <select name="Legal_Impact_Probability" id="legalProbability"
                                                    onchange='calculateRiskAnalysis("legal")'
                                                    {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>
                                                    <option value="">Enter Your Selection Here</option>
                                                    <option value="1"
                                                        {{ $EHS->Legal_Impact_Probability == '1' ? 'selected' : '' }}>Low
                                                        - Almost Improbable (1)</option>
                                                    <option value="2"
                                                        {{ $EHS->Legal_Impact_Probability == '2' ? 'selected' : '' }}>
                                                        Medium - Occasional (2)</option>
                                                    <option value="3"
                                                        {{ $EHS->Legal_Impact_Probability == '3' ? 'selected' : '' }}>High
                                                        - Frequent (3)</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Legal Impact Severity">Legal Impact Severity</label>
                                                <select name="Legal_Impact_Severity" id="legalSeverity"
                                                    onchange='calculateRiskAnalysis("legal")'
                                                    {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>
                                                    <option value="">Enter Your Selection Here</option>
                                                    <option value="1"
                                                        {{ $EHS->Legal_Impact_Severity == '1' ? 'selected' : '' }}>
                                                        Negligible (1)</option>
                                                    <option value="2"
                                                        {{ $EHS->Legal_Impact_Severity == '2' ? 'selected' : '' }}>
                                                        Marginal (2)</option>
                                                    <option value="3"
                                                        {{ $EHS->Legal_Impact_Severity == '3' ? 'selected' : '' }}>
                                                        Critical (3)</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Business Impact Probability">Business Impact
                                                    Probability</label>
                                                <select name="Business_Impact_Probability" id="businessProbability"
                                                    onchange='calculateRiskAnalysis("business")'
                                                    {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>
                                                    <option value="">Enter Your Selection Here</option>
                                                    <option value="1"
                                                        {{ $EHS->Business_Impact_Probability == '1' ? 'selected' : '' }}>
                                                        Low - Almost Improbable (1)</option>
                                                    <option value="2"
                                                        {{ $EHS->Business_Impact_Probability == '2' ? 'selected' : '' }}>
                                                        Medium - Occasional (2)</option>
                                                    <option value="3"
                                                        {{ $EHS->Business_Impact_Probability == '3' ? 'selected' : '' }}>
                                                        High - Frequent (3)</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Business Impact Severity">Business Impact Severity</label>
                                                <select name="Business_Impact_Severity" id="businessSeverity"
                                                    onchange='calculateRiskAnalysis("business")'
                                                    {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>
                                                    <option value="">Enter Your Selection Here</option>
                                                    <option value="1"
                                                        {{ $EHS->Business_Impact_Severity == '1' ? 'selected' : '' }}>
                                                        Negligible (1)</option>
                                                    <option value="2"
                                                        {{ $EHS->Business_Impact_Severity == '2' ? 'selected' : '' }}>
                                                        Marginal (2)</option>
                                                    <option value="3"
                                                        {{ $EHS->Business_Impact_Severity == '3' ? 'selected' : '' }}>
                                                        Critical (3)</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Revenue Impact Probability">Revenue Impact Probability</label>
                                                <select name="Revenue_Impact_Probability" id="revenueProbability"
                                                    onchange='calculateRiskAnalysis("revenue")'
                                                    {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>
                                                    <option value="">Enter Your Selection Here</option>
                                                    <option value="1"
                                                        {{ $EHS->Revenue_Impact_Probability == '1' ? 'selected' : '' }}>
                                                        Low - Almost Improbable (1)</option>
                                                    <option value="2"
                                                        {{ $EHS->Revenue_Impact_Probability == '2' ? 'selected' : '' }}>
                                                        Medium - Occasional (2)</option>
                                                    <option value="3"
                                                        {{ $EHS->Revenue_Impact_Probability == '3' ? 'selected' : '' }}>
                                                        High - Frequent (3)</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Revenue Impact Severity">Revenue Impact Severity</label>
                                                <select name="Revenue_Impact_Severity" id="revenueSeverity"
                                                    onchange='calculateRiskAnalysis("revenue")'
                                                    {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>
                                                    <option value="">Enter Your Selection Here</option>
                                                    <option value="1"
                                                        {{ $EHS->Revenue_Impact_Severity == '1' ? 'selected' : '' }}>
                                                        Negligible (1)</option>
                                                    <option value="2"
                                                        {{ $EHS->Revenue_Impact_Severity == '2' ? 'selected' : '' }}>
                                                        Marginal (2)</option>
                                                    <option value="3"
                                                        {{ $EHS->Revenue_Impact_Severity == '3' ? 'selected' : '' }}>
                                                        Critical (3)</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Brand Impact Probability">Brand Impact Probability</label>
                                                <select name="Brand_Impact_Probability" id="brandProbability"
                                                    onchange='calculateRiskAnalysis("brand")'
                                                    {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>
                                                    <option value="">Enter Your Selection Here</option>
                                                    <option value="1"
                                                        {{ $EHS->Brand_Impact_Probability == '1' ? 'selected' : '' }}>Low
                                                        - Almost Improbable (1)</option>
                                                    <option value="2"
                                                        {{ $EHS->Brand_Impact_Probability == '2' ? 'selected' : '' }}>
                                                        Medium - Occasional (2)</option>
                                                    <option value="3"
                                                        {{ $EHS->Brand_Impact_Probability == '3' ? 'selected' : '' }}>High
                                                        - Frequent (3)</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Brand Impact Severity">Brand Impact Severity</label>
                                                <select name="Brand_Impact_Severity" id="brandSeverity"
                                                    onchange='calculateRiskAnalysis("brand")'
                                                    {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>
                                                    <option value="">Enter Your Selection Here</option>
                                                    <option value="1"
                                                        {{ $EHS->Brand_Impact_Severity == '1' ? 'selected' : '' }}>
                                                        Negligible (1)</option>
                                                    <option value="2"
                                                        {{ $EHS->Brand_Impact_Severity == '2' ? 'selected' : '' }}>
                                                        Marginal (2)</option>
                                                    <option value="3"
                                                        {{ $EHS->Brand_Impact_Severity == '3' ? 'selected' : '' }}>
                                                        Critical (3)</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="sub-head">
                                            Calculated Risk And Further Actions
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Safety Impact Risk">Safety Impact Risk</label>
                                                <input type="text" name="Safety_Impact_Risk" id="safetyRisk"
                                                    value="{{ $EHS->Safety_Impact_Risk }}" readonly
                                                    {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <div><small class="text-success">1: Acceptable - Risk negligible, further
                                                        Effort not justified; consider product improvement</small></div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Legal Impact Risk">Legal Impact Risk</label>
                                                <input type="text" name="Legal_Impact_Risk" id="legalRisk"
                                                    value="{{ $EHS->Legal_Impact_Risk }}" readonly
                                                    {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <div><small class="text-primary">2: Mostly Acceptable - Risk negligible,
                                                        further Effort not justified; consider product improvement</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Business Impact Risk">Business Impact Risk</label>
                                                <input type="text" name="Business_Impact_Risk" id="businessRisk"
                                                    value="{{ $EHS->Business_Impact_Risk }}" readonly
                                                    {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <div><small class="text-info">3-4: Tolerable - Risk can be acceptable,
                                                        further Effort can be in case of safety issues; consider
                                                        CAPA</small></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Revenue Impact Risk">Revenue Impact Risk</label>
                                                <input type="text" name="Revenue_Impact_Risk" id="revenueRisk"
                                                    value="{{ $EHS->Revenue_Impact_Risk }}" readonly
                                                    {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <div><small class="text-warning">'6: Mostly Unacceptable - Risk not
                                                        justified with few exceptions; CAPA will be created</small></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Brand Impact Risk">Brand Impact Risk</label>
                                                <input type="text" name="Brand_Impact_Risk" id="brandRisk"
                                                    value="{{ $EHS->Brand_Impact_Risk }}" readonly
                                                    {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <div><small class="text-danger">9: Unacceptable - Risk not justified; CAPA
                                                        will be created</small></div>
                                            </div>
                                        </div>

                                        <div class="sub-head">
                                            General Risk Information
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Impact">Impact</label>
                                                <select name="Impact" id="Impact" data-search="false"
                                                    data-silent-initial-value-set="true"
                                                    {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>
                                                    <option value="">-- Select --</option>
                                                    <option value="High"
                                                        {{ $EHS->Impact == 'High' ? 'selected' : '' }}>High</option>
                                                    <option value="Medium"
                                                        {{ $EHS->Impact == 'Medium' ? 'selected' : '' }}>Medium</option>
                                                    <option value="Low"
                                                        {{ $EHS->Impact == 'Low' ? 'selected' : '' }}>Low</option>
                                                    <option value="None"
                                                        {{ $EHS->Impact == 'None' ? 'selected' : '' }}>None</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Impact Analysis">Impact Analysis</label>
                                                <div class="relative-container">
                                                    <textarea name="Impact_Analysis" id="Impact_Analysis"
                                                        {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>{{ $EHS->Impact_Analysis }}</textarea>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Recommended Actions">Recommended Actions</label>
                                                <div class="relative-container">
                                                    <textarea name="Recommended_Actions" id="Recommended_Actions"
                                                        {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>{{ $EHS->Recommended_Actions }}</textarea>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Comments">Comments</label>
                                                <div class="relative-container">
                                                    <textarea name="Comments2" id="Comments2" {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>{{ $EHS->Comments2 }}</textarea>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Direct Cause">Direct Cause</label>
                                                <select name="Direct_Cause" id="Direct_Cause" data-search="false"
                                                    data-silent-initial-value-set="true"
                                                    {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>
                                                    <option value="">-- Select --</option>
                                                    <option value="Act is Unsafe"
                                                        {{ $EHS->Direct_Cause == 'Act is Unsafe' ? 'selected' : '' }}>Act
                                                        is Unsafe</option>
                                                    <option value="Procedures / Instructions Not Followed"
                                                        {{ $EHS->Direct_Cause == 'Procedures / Instructions Not Followed' ? 'selected' : '' }}>
                                                        Procedures / Instructions Not Followed</option>
                                                    <option value="Incorrect Stacking / Loading"
                                                        {{ $EHS->Direct_Cause == 'Incorrect Stacking / Loading' ? 'selected' : '' }}>
                                                        Incorrect Stacking / Loading</option>
                                                    <!-- Corrected "Incorect" to "Incorrect" -->
                                                    <option value="Wrong Positioning"
                                                        {{ $EHS->Direct_Cause == 'Wrong Positioning' ? 'selected' : '' }}>
                                                        Wrong Positioning</option>
                                                    <option value="Incorrect Lifting / Bending"
                                                        {{ $EHS->Direct_Cause == 'Incorrect Lifting / Bending' ? 'selected' : '' }}>
                                                        Incorrect Lifting / Bending</option>
                                                    <option value="Wrong Posture / Work Position"
                                                        {{ $EHS->Direct_Cause == 'Wrong Posture / Work Position' ? 'selected' : '' }}>
                                                        Wrong Posture / Work Position</option>
                                                    <option value="Work On / Near Moving Parts"
                                                        {{ $EHS->Direct_Cause == 'Work On / Near Moving Parts' ? 'selected' : '' }}>
                                                        Work On / Near Moving Parts</option>
                                                    <option value="Joking / Distraction"
                                                        {{ $EHS->Direct_Cause == 'Joking / Distraction' ? 'selected' : '' }}>
                                                        Joking / Distraction</option>
                                                    <!-- Corrected "Jokiing" to "Joking" -->
                                                    <option value="Use of Alcohol / Drugs"
                                                        {{ $EHS->Direct_Cause == 'Use of Alcohol / Drugs' ? 'selected' : '' }}>
                                                        Use of Alcohol / Drugs</option>
                                                    <option value="Work Without Permission"
                                                        {{ $EHS->Direct_Cause == 'Work Without Permission' ? 'selected' : '' }}>
                                                        Work Without Permission</option>
                                                    <option value="No warnings Given"
                                                        {{ $EHS->Direct_Cause == 'No warnings Given' ? 'selected' : '' }}>
                                                        No warnings Given</option>
                                                    <option value="Equipment Not Secured / Locked / Safeguarded"
                                                        {{ $EHS->Direct_Cause == 'Equipment Not Secured / Locked / Safeguarded' ? 'selected' : '' }}>
                                                        Equipment Not Secured / Locked / Safeguarded</option>
                                                    <!-- Corrected "Scured" to "Secured" -->
                                                    <option value="Incorrect Work Pace"
                                                        {{ $EHS->Direct_Cause == 'Incorrect Work Pace' ? 'selected' : '' }}>
                                                        Incorrect Work Pace</option>
                                                    <!-- Corrected "Incorrect Work PAce" to "Incorrect Work Pace" -->
                                                    <option value="Safety Device Bypassed"
                                                        {{ $EHS->Direct_Cause == 'Safety Device Bypassed' ? 'selected' : '' }}>
                                                        Safety Device Bypassed</option>
                                                    <option value="Use Of Defective Tools / Equipment"
                                                        {{ $EHS->Direct_Cause == 'Use Of Defective Tools / Equipment' ? 'selected' : '' }}>
                                                        Use Of Defective Tools / Equipment</option>
                                                    <option value="Misuse of Tools / Equipment"
                                                        {{ $EHS->Direct_Cause == 'Misuse of Tools / Equipment' ? 'selected' : '' }}>
                                                        Misuse of Tools / Equipment</option>
                                                    <option value="No / Wrong PPE Usage"
                                                        {{ $EHS->Direct_Cause == 'No / Wrong PPE Usage' ? 'selected' : '' }}>
                                                        No / Wrong PPE Usage</option> <!-- Corrected "Ppe" to "PPE" -->
                                                    <option value="Condition is Unsafe"
                                                        {{ $EHS->Direct_Cause == 'Condition is Unsafe' ? 'selected' : '' }}>
                                                        Condition is Unsafe</option>
                                                    <option value="Inadequate Signs / Covers"
                                                        {{ $EHS->Direct_Cause == 'Inadequate Signs / Covers' ? 'selected' : '' }}>
                                                        Inadequate Signs / Covers</option>
                                                    <option value="Substances in Atmosphere"
                                                        {{ $EHS->Direct_Cause == 'Substances in Atmosphere' ? 'selected' : '' }}>
                                                        Substances in Atmosphere</option>
                                                    <option value="Radiation Hazard"
                                                        {{ $EHS->Direct_Cause == 'Radiation Hazard' ? 'selected' : '' }}>
                                                        Radiation Hazard</option>
                                                    <option value="Noise"
                                                        {{ $EHS->Direct_Cause == 'Noise' ? 'selected' : '' }}>Noise
                                                    </option>
                                                    <option value="Toxic Exposure"
                                                        {{ $EHS->Direct_Cause == 'Toxic Exposure' ? 'selected' : '' }}>
                                                        Toxic Exposure</option>
                                                    <option value="Temperature / Humidity Out of Range"
                                                        {{ $EHS->Direct_Cause == 'Temperature / Humidity Out of Range' ? 'selected' : '' }}>
                                                        Temperature / Humidity Out of Range</option>
                                                    <!-- Corrected "Humadity" to "Humidity" -->
                                                    <option value="Inadequate Luminosity"
                                                        {{ $EHS->Direct_Cause == 'Inadequate Luminosity' ? 'selected' : '' }}>
                                                        Inadequate Luminosity</option>
                                                    <option value="Inadequate Ventilation"
                                                        {{ $EHS->Direct_Cause == 'Inadequate Ventilation' ? 'selected' : '' }}>
                                                        Inadequate Ventilation</option>
                                                    <option value="Inadequate Personnel Protection Equipment"
                                                        {{ $EHS->Direct_Cause == 'Inadequate Personnel Protection Equipment' ? 'selected' : '' }}>
                                                        Inadequate Personnel Protection Equipment</option>
                                                    <option value="Defective / Inadequate Tools / Equipment"
                                                        {{ $EHS->Direct_Cause == 'Defective / Inadequate Tools / Equipment' ? 'selected' : '' }}>
                                                        Defective / Inadequate Tools / Equipment</option>
                                                    <option value="Limited Space / Access"
                                                        {{ $EHS->Direct_Cause == 'Limited Space / Access' ? 'selected' : '' }}>
                                                        Limited Space / Access</option>
                                                    <option value="Accumulation of Material"
                                                        {{ $EHS->Direct_Cause == 'Accumulation of Material' ? 'selected' : '' }}>
                                                        Accumulation of Material</option>
                                                    <!-- Corrected "Accumalation" to "Accumulation" -->
                                                    <option value="Inadequate Warning Detection"
                                                        {{ $EHS->Direct_Cause == 'Inadequate Warning Detection' ? 'selected' : '' }}>
                                                        Inadequate Warning Detection</option>
                                                    <option value="Fire / Explosion Hazard"
                                                        {{ $EHS->Direct_Cause == 'Fire / Explosion Hazard' ? 'selected' : '' }}>
                                                        Fire / Explosion Hazard</option>
                                                    <option value="Bad Housekeeping"
                                                        {{ $EHS->Direct_Cause == 'Bad Housekeeping' ? 'selected' : '' }}>
                                                        Bad Housekeeping</option>
                                                    <option value="Floor / Surface Condition"
                                                        {{ $EHS->Direct_Cause == 'Floor / Surface Condition' ? 'selected' : '' }}>
                                                        Floor / Surface Condition</option>
                                                    <option value="Other"
                                                        {{ $EHS->Direct_Cause == 'Other' ? 'selected' : '' }}>Other
                                                    </option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Safeguarding Measure Taken">Safeguarding Measure Taken</label>
                                                <select name="Safeguarding_Measure_Taken2"
                                                    id="Safeguarding_Measure_Taken2" data-search="false"
                                                    data-silent-initial-value-set="true"
                                                    {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>
                                                    <option value="">-- Select --</option>
                                                    <option value="Company Rules"
                                                        {{ $EHS->Safeguarding_Measure_Taken2 == 'Company Rules' ? 'selected' : '' }}>
                                                        Company Rules</option>
                                                    <option value="Design and Modification"
                                                        {{ $EHS->Safeguarding_Measure_Taken2 == 'Design and Modification' ? 'selected' : '' }}>
                                                        Design and Modification</option>
                                                    <option value="Emergency Planning"
                                                        {{ $EHS->Safeguarding_Measure_Taken2 == 'Emergency Planning' ? 'selected' : '' }}>
                                                        Emergency Planning</option>
                                                    <option value="General Promotion"
                                                        {{ $EHS->Safeguarding_Measure_Taken2 == 'General Promotion' ? 'selected' : '' }}>
                                                        General Promotion</option>
                                                    <option value="Incident Analysis"
                                                        {{ $EHS->Safeguarding_Measure_Taken2 == 'Incident Analysis' ? 'selected' : '' }}>
                                                        Incident Analysis</option>
                                                    <option value="Incident Investigation"
                                                        {{ $EHS->Safeguarding_Measure_Taken2 == 'Incident Investigation' ? 'selected' : '' }}>
                                                        Incident Investigation</option>
                                                    <option value="Individual Communication"
                                                        {{ $EHS->Safeguarding_Measure_Taken2 == 'Individual Communication' ? 'selected' : '' }}>
                                                        Individual Communication</option>
                                                    <option value="Management Training"
                                                        {{ $EHS->Safeguarding_Measure_Taken2 == 'Management Training' ? 'selected' : '' }}>
                                                        Management Training</option>
                                                    <option value="Occupational Health"
                                                        {{ $EHS->Safeguarding_Measure_Taken2 == 'Occupational Health' ? 'selected' : '' }}>
                                                        Occupational Health</option>
                                                    <option value="Personal Protection"
                                                        {{ $EHS->Safeguarding_Measure_Taken2 == 'Personal Protection' ? 'selected' : '' }}>
                                                        Personal Protection</option>
                                                    <option value="Planning of Inspections"
                                                        {{ $EHS->Safeguarding_Measure_Taken2 == 'Planning of Inspections' ? 'selected' : '' }}>
                                                        Planning of Inspections</option>
                                                    <option value="Planning of Task Observations"
                                                        {{ $EHS->Safeguarding_Measure_Taken2 == 'Planning of Task Observations' ? 'selected' : '' }}>
                                                        Planning of Task Observations</option>
                                                    <option value="Policy"
                                                        {{ $EHS->Safeguarding_Measure_Taken2 == 'Policy' ? 'selected' : '' }}>
                                                        Policy</option>
                                                    <option value="Positioning"
                                                        {{ $EHS->Safeguarding_Measure_Taken2 == 'Positioning' ? 'selected' : '' }}>
                                                        Positioning</option>
                                                    <option value="Procedures and Task Analysis"
                                                        {{ $EHS->Safeguarding_Measure_Taken2 == 'Procedures and Task Analysis' ? 'selected' : '' }}>
                                                        Procedures and Task Analysis</option>
                                                    <option value="Procurement Procedure"
                                                        {{ $EHS->Safeguarding_Measure_Taken2 == 'Procurement Procedure' ? 'selected' : '' }}>
                                                        Procurement Procedure</option>
                                                    <option value="Program Evaluation"
                                                        {{ $EHS->Safeguarding_Measure_Taken2 == 'Program Evaluation' ? 'selected' : '' }}>
                                                        Program Evaluation</option>
                                                    <option value="Safety Meetings"
                                                        {{ $EHS->Safeguarding_Measure_Taken2 == 'Safety Meetings' ? 'selected' : '' }}>
                                                        Safety Meetings</option>
                                                    <option value="Safety Out of Work"
                                                        {{ $EHS->Safeguarding_Measure_Taken2 == 'Safety Out of Work' ? 'selected' : '' }}>
                                                        Safety Out of Work</option>
                                                    <option value="Training of Employees"
                                                        {{ $EHS->Safeguarding_Measure_Taken2 == 'Training of Employees' ? 'selected' : '' }}>
                                                        Training of Employees</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="sub-head">
                                            Risk Analysis
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="group-input">
                                                    <label for="Severity Rate">Severity Rate</label>
                                                    <select name="severity_rate" id="analysisR"
                                                        onchange='calculateRiskAnalysis2(this)'
                                                        {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>
                                                        <option value="">Enter Your Selection Here</option>
                                                        <option value="1"
                                                            {{ $EHS->severity_rate == '1' ? 'selected' : '' }}>Negligible
                                                        </option>
                                                        <option value="2"
                                                            {{ $EHS->severity_rate == '2' ? 'selected' : '' }}>Minor
                                                        </option>
                                                        <option value="3"
                                                            {{ $EHS->severity_rate == '3' ? 'selected' : '' }}>Moderate
                                                        </option>
                                                        <option value="4"
                                                            {{ $EHS->severity_rate == '4' ? 'selected' : '' }}>Major
                                                        </option>
                                                        <option value="5"
                                                            {{ $EHS->severity_rate == '5' ? 'selected' : '' }}>Fatal
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="group-input">
                                                    <label for="Occurrence">Occurrence</label>
                                                    <select name="occurrence" id="analysisP"
                                                        onchange='calculateRiskAnalysis2(this)'
                                                        {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>
                                                        <option value="">Enter Your Selection Here</option>
                                                        <option value="5"
                                                            {{ $EHS->occurrence == '5' ? 'selected' : '' }}>Extremely
                                                            Unlikely</option>
                                                        <option value="4"
                                                            {{ $EHS->occurrence == '4' ? 'selected' : '' }}>Rare</option>
                                                        <option value="3"
                                                            {{ $EHS->occurrence == '3' ? 'selected' : '' }}>Unlikely
                                                        </option>
                                                        <option value="2"
                                                            {{ $EHS->occurrence == '2' ? 'selected' : '' }}>Likely
                                                        </option>
                                                        <option value="1"
                                                            {{ $EHS->occurrence == '1' ? 'selected' : '' }}>Very Likely
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="group-input">
                                                    <label for="Detection">Detection</label>
                                                    <select name="detection" id="analysisN"
                                                        onchange='calculateRiskAnalysis2(this)'
                                                        {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>
                                                        <option value="">Enter Your Selection Here</option>
                                                        <option value="5"
                                                            {{ $EHS->detection == '5' ? 'selected' : '' }}>Impossible
                                                        </option>
                                                        <option value="4"
                                                            {{ $EHS->detection == '4' ? 'selected' : '' }}>Rare</option>
                                                        <option value="3"
                                                            {{ $EHS->detection == '3' ? 'selected' : '' }}>Unlikely
                                                        </option>
                                                        <option value="2"
                                                            {{ $EHS->detection == '2' ? 'selected' : '' }}>Likely</option>
                                                        <option value="1"
                                                            {{ $EHS->detection == '1' ? 'selected' : '' }}>Very Likely
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="group-input">
                                                    <label for="RPN">RPN</label>
                                                    <div><small class="text-primary">Auto - Calculated</small></div>
                                                    <input type="text" name="rpn" id="analysisRPN"
                                                        value="{{ $EHS->rpn }}" readonly
                                                        {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Risk Analysis">Risk Analysis</label>
                                                <div class="relative-container">
                                                    <textarea name="Risk_Analysis" id="Risk_Analysis" {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>{{ $EHS->Risk_Analysis }}</textarea>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Critically">Critically</label>
                                                <select name="Critically" id="Critically" data-search="false"
                                                    data-silent-initial-value-set="true"
                                                    {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>
                                                    <option value="">-- Select --</option>
                                                    <option value="High"
                                                        {{ $EHS->Critically == 'High' ? 'selected' : '' }}>High</option>
                                                    <option value="Medium"
                                                        {{ $EHS->Critically == 'Medium' ? 'selected' : '' }}>Medium
                                                    </option>
                                                    <option value="Low"
                                                        {{ $EHS->Critically == 'Low' ? 'selected' : '' }}>Low</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Inform Local Authority?">Inform Local Authority?</label>
                                                <select name="Inform_Local_Authority" id="Inform_Local_Authority"
                                                    data-search="false" data-silent-initial-value-set="true"
                                                    {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>
                                                    <option value="">-- Select --</option>
                                                    <option value="Yes"
                                                        {{ $EHS->Inform_Local_Authority == 'Yes' ? 'selected' : '' }}>Yes
                                                    </option>
                                                    <option value="No"
                                                        {{ $EHS->Inform_Local_Authority == 'No' ? 'selected' : '' }}>No
                                                    </option>
                                                    <option value="Na"
                                                        {{ $EHS->Inform_Local_Authority == 'Na' ? 'selected' : '' }}>Na
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Authority Type">Authority Type</label>
                                                <select name="Authority_Type" id="Authority_Type" data-search="false"
                                                    data-silent-initial-value-set="true"
                                                    {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>
                                                    <option value="">-- Select --</option>
                                                    <option value="Life Science"
                                                        {{ $EHS->Authority_Type == 'Life Science' ? 'selected' : '' }}>
                                                        Life Science</option>
                                                    <option value="Food Safety"
                                                        {{ $EHS->Authority_Type == 'Food Safety' ? 'selected' : '' }}>Food
                                                        Safety</option>
                                                    <option value="Health and Safety"
                                                        {{ $EHS->Authority_Type == 'Health and Safety' ? 'selected' : '' }}>
                                                        Health and Safety</option>
                                                    <option value="Financial"
                                                        {{ $EHS->Authority_Type == 'Financial' ? 'selected' : '' }}>
                                                        Financial</option>
                                                    <option value="Other"
                                                        {{ $EHS->Authority_Type == 'Other' ? 'selected' : '' }}>Other
                                                    </option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Authority Notified">Authority Notified</label>
                                                <select name="Authority_Notified" id="Authority_Notified"
                                                    data-search="false" data-silent-initial-value-set="true"
                                                    {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>
                                                    <option value="">-- Select --</option>
                                                    <option value="Yes"
                                                        {{ $EHS->Authority_Notified == 'Yes' ? 'selected' : '' }}>Yes
                                                    </option>
                                                    <option value="No"
                                                        {{ $EHS->Authority_Notified == 'No' ? 'selected' : '' }}>No
                                                    </option>
                                                    <option value="Na"
                                                        {{ $EHS->Authority_Notified == 'Na' ? 'selected' : '' }}>Na
                                                    </option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Other Authority">Other Authority</label>
                                                <div class="relative-container">
                                                    <textarea name="Other_Authority" id="Other_Authority"
                                                        {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>{{ $EHS->Other_Authority }}</textarea>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="button-block">
                                        <button type="submit" class="saveButton">Save</button>
                                        <button type="button" class="backButton"
                                            onclick="previousStep()">Back</button>
                                        <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                        <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}"
                                                class="text-white">
                                                Exit </a> </button>
                                    </div>
                                </div>
                            </div>

                            <div id="CCForm6" class="inner-block cctabcontent">
                                <div class="inner-block-content">

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Employee ID">Employee ID</label>
                                                <input type="Number" name="employee_id" id="employee_id"
                                                    min="0" value="{{ $EHS->employee_id }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Employee Name">Employee Name</label>
                                                <div class="relative-container">
                                                    <input type="text" name="employee_name" id="employee_name"
                                                        value="{{ $EHS->employee_name }}">
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Designation">Designation</label>
                                                <div class="relative-container">
                                                    <input type="text" name="designation" id="designation"
                                                        value="{{ $EHS->designation }}">
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Department">Department</label>
                                                <select name="department2" id="department2" data-search="false"
                                                    data-silent-initial-value-set="true"
                                                    {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}>
                                                    <option value="">-- Select --</option>
                                                    <option value="Calibration Lab"
                                                        {{ $EHS->department2 == 'Calibration Lab' ? 'selected' : '' }}>
                                                        Calibration Lab</option>
                                                    <option value="Engineering"
                                                        {{ $EHS->department2 == 'Engineering' ? 'selected' : '' }}>
                                                        Engineering</option>
                                                    <option value="Facilities"
                                                        {{ $EHS->department2 == 'Facilities' ? 'selected' : '' }}>
                                                        Facilities</option>
                                                    <option value="Lab"
                                                        {{ $EHS->department2 == 'Lab' ? 'selected' : '' }}>Lab</option>
                                                    <option value="Labeling"
                                                        {{ $EHS->department2 == 'Labeling' ? 'selected' : '' }}>Labeling
                                                    </option>
                                                    <option value="Manufacturing"
                                                        {{ $EHS->department2 == 'Manufacturing' ? 'selected' : '' }}>
                                                        Manufacturing</option>
                                                    <option value="Quality Assurance"
                                                        {{ $EHS->department2 == 'Quality Assurance' ? 'selected' : '' }}>
                                                        Quality Assurance</option>
                                                    <option value="Quality Control"
                                                        {{ $EHS->department2 == 'Quality Control' ? 'selected' : '' }}>
                                                        Quality Control</option>
                                                    <option value="Regulatory Affairs"
                                                        {{ $EHS->department2 == 'Regulatory Affairs' ? 'selected' : '' }}>
                                                        Regulatory Affairs</option>
                                                    <option value="Security"
                                                        {{ $EHS->department2 == 'Security' ? 'selected' : '' }}>Security
                                                    </option>
                                                    <option value="Training"
                                                        {{ $EHS->department2 == 'Training' ? 'selected' : '' }}>Training
                                                    </option>
                                                    <option value="IT"
                                                        {{ $EHS->department2 == 'IT' ? 'selected' : '' }}>IT</option>
                                                    <option value="Application Engineering"
                                                        {{ $EHS->department2 == 'Application Engineering' ? 'selected' : '' }}>
                                                        Application Engineering</option>
                                                    <option value="Trading"
                                                        {{ $EHS->department2 == 'Trading' ? 'selected' : '' }}>Trading
                                                    </option>
                                                    <option value="Research"
                                                        {{ $EHS->department2 == 'Research' ? 'selected' : '' }}>Research
                                                    </option>
                                                    <option value="Sales"
                                                        {{ $EHS->department2 == 'Sales' ? 'selected' : '' }}>Sales
                                                    </option>
                                                    <option value="Finance"
                                                        {{ $EHS->department2 == 'Finance' ? 'selected' : '' }}>Finance
                                                    </option>
                                                    <option value="Systems"
                                                        {{ $EHS->department2 == 'Systems' ? 'selected' : '' }}>Systems
                                                    </option>
                                                    <option value="Administrative"
                                                        {{ $EHS->department2 == 'Administrative' ? 'selected' : '' }}>
                                                        Administrative</option>
                                                    <option value="M&A"
                                                        {{ $EHS->department2 == 'M&A' ? 'selected' : '' }}>M&A</option>
                                                    <option value="R&D"
                                                        {{ $EHS->department2 == 'R&D' ? 'selected' : '' }}>R&D</option>
                                                    <option value="Human Resources"
                                                        {{ $EHS->department2 == 'Human Resources' ? 'selected' : '' }}>
                                                        Human Resources</option>
                                                    <option value="Banking"
                                                        {{ $EHS->department2 == 'Banking' ? 'selected' : '' }}>Banking
                                                    </option>
                                                    <option value="Marketing"
                                                        {{ $EHS->department2 == 'Marketing' ? 'selected' : '' }}>Marketing
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Phone Number">Phone Number</label>
                                                <input type="text" id="phone_number" name="phone_number"
                                                    placeholder="Enter employee phone Number"
                                                    value="{{ $EHS->phone_number }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Email">Email</label>
                                                <input type="email" id="email" name="email"
                                                    placeholder="Enter employee email" value="{{ $EHS->email }}">
                                                @if ($errors->has('email'))
                                                    <span style="color: red;">{{ $errors->first('email') }}</span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-lg-6 new-date-data-field">
                                            <div class="group-input input-date">
                                                <label for="Date of Joining">Date of Joining</label>
                                                <div class="calenderauditee">
                                                    <input type="text" id="date_of_joining" readonly
                                                        placeholder="DD-MMM-YYYY"
                                                        value="{{ Helpers::getdateFormat($EHS->date_of_joining) }}"
                                                        {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }} />
                                                    <input type="date" id="date_of_joining_checkdate"
                                                        name="date_of_joining"
                                                        max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                                        {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}
                                                        value="{{ $EHS->date_of_joining }}" class="hide-input"
                                                        oninput="handleDateInput(this, 'date_of_joining');checkDate('date_of_joining_checkdate','date_of_joining1_checkdate')" />
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Safety Training Records">Safety Training Records</label>
                                                <select name="safety_training_records" id="safety_training_records">
                                                    <option value="">-- Select --</option>
                                                    <option value="Date Of Completion"
                                                        {{ $EHS->safety_training_records == 'Date Of Completion' ? 'selected' : '' }}>
                                                        Date Of Completion</option>
                                                    <option value="Trainer Name"
                                                        {{ $EHS->safety_training_records == 'Trainer Name' ? 'selected' : '' }}>
                                                        Trainer Name</option>
                                                    <option value="Course Details"
                                                        {{ $EHS->safety_training_records == 'Course Details' ? 'selected' : '' }}>
                                                        Course Details</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Medical History">Medical History</label>
                                                <select name="medical_history" id="medical_history">
                                                    <option value="">-- Select --</option>
                                                    <option value="Work Related Illnesses"
                                                        {{ $EHS->medical_history == 'Work Related Illnesses' ? 'selected' : '' }}>
                                                        Work Related Illnesses</option>
                                                    <option value="Injuries"
                                                        {{ $EHS->medical_history == 'Injuries' ? 'selected' : '' }}>
                                                        Injuries</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Personal Protective Equipment (PPE) Compliance">Personal
                                                    Protective Equipment (PPE) Compliance</label>
                                                <div class="relative-container">
                                                    <input type="text"
                                                        name="personal_protective_equipment_compliance"
                                                        id="personal_protective_equipment_compliance"
                                                        value="{{ $EHS->personal_protective_equipment_compliance }}">
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="group-input">
                                                <label for="Emergency Contacts">Emergency Contacts</label>
                                                <input type="text" id="emergency_contacts"
                                                    name="emergency_contacts"
                                                    placeholder="Enter Employee Emergency Contacts"
                                                    value="{{ $EHS->emergency_contacts }}">
                                            </div>
                                        </div>

                                    </div>
                                    <div class="button-block">
                                        <button type="submit" class="saveButton">Save</button>
                                        <button type="button" class="backButton"
                                            onclick="previousStep()">Back</button>
                                        <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                        <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}"
                                                class="text-white">
                                                Exit </a> </button>
                                    </div>
                                </div>
                            </div>

                            <div id="CCForm7" class="inner-block cctabcontent">
                                <div class="inner-block-content">

                                    <div class="row">
                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Compliance Standards/Regulations">Compliance
                                                    Standards/Regulations</label>
                                                <select name="compliance_standards_regulations"
                                                    id="compliance_standards_regulations">
                                                    <option value="">-- Select --</option>
                                                    <option value="ISO 14001"
                                                        {{ $EHS->compliance_standards_regulations == 'ISO 14001' ? 'selected' : '' }}>
                                                        ISO 14001</option>
                                                    <option value="ISO 45001"
                                                        {{ $EHS->compliance_standards_regulations == 'ISO 45001' ? 'selected' : '' }}>
                                                        ISO 45001</option>
                                                    <option value="Drug and Cosmetics Act"
                                                        {{ $EHS->compliance_standards_regulations == 'Drug and Cosmetics Act' ? 'selected' : '' }}>
                                                        Drug and Cosmetics Act</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Regulatory Authority/Agency ">Regulatory Authority/Agency
                                                </label>
                                                <select name="regulatory_authority_agency"
                                                    id="regulatory_authority_agency">
                                                    <option value="">-- Select --</option>
                                                    <option value="CPCB"
                                                        {{ $EHS->regulatory_authority_agency == 'CPCB' ? 'selected' : '' }}>
                                                        CPCB</option>
                                                    <option value="FSSAI"
                                                        {{ $EHS->regulatory_authority_agency == 'FSSAI' ? 'selected' : '' }}>
                                                        FSSAI</option>
                                                    <option value="MoEF"
                                                        {{ $EHS->regulatory_authority_agency == 'MoEF' ? 'selected' : '' }}>
                                                        MoEF</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 new-date-data-field">
                                            <div class="group-input input-date">
                                                <label for="Inspection Dates and Reports">Inspection Dates and
                                                    Reports</label>
                                                <div class="calenderauditee">
                                                    <input type="text" id="inspection_dates_and_reports" readonly
                                                        placeholder="DD-MMM-YYYY"
                                                        value="{{ Helpers::getdateFormat($EHS->inspection_dates_and_reports) }}"
                                                        {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }} />
                                                    <input type="date" id="inspection_dates_and_reports_checkdate"
                                                        name="inspection_dates_and_reports"
                                                        max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                                        {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}
                                                        value="{{ $EHS->inspection_dates_and_reports }}"
                                                        class="hide-input"
                                                        oninput="handleDateInput(this, 'inspection_dates_and_reports');checkDate('inspection_dates_and_reports_checkdate','inspection_dates_and_reports1_checkdate')" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Audit/Inspection Results">Audit/Inspection Results</label>
                                                <select name="audit_inspection_results" id="audit_inspection_results">
                                                    <option value="">-- Select --</option>
                                                    <option value="Internal Audits"
                                                        {{ $EHS->audit_inspection_results == 'Internal Audits' ? 'selected' : '' }}>
                                                        Internal Audits</option>
                                                    <option value="External Audits"
                                                        {{ $EHS->audit_inspection_results == 'External Audits' ? 'selected' : '' }}>
                                                        External Audits</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Non-compliance Issues">Non-compliance Issues</label>
                                                <select name="non_compliance_issues" id="non_compliance_issues">
                                                    <option value="">-- Select --</option>
                                                    <option value="Date"
                                                        {{ $EHS->non_compliance_issues == 'Date' ? 'selected' : '' }}>
                                                        Date</option>
                                                    <option value="Description"
                                                        {{ $EHS->non_compliance_issues == 'Description' ? 'selected' : '' }}>
                                                        Description</option>
                                                    <option value="Resolution Status"
                                                        {{ $EHS->non_compliance_issues == 'Resolution Status' ? 'selected' : '' }}>
                                                        Resolution Status</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Environmental Permits">Environmental Permits</label>
                                                <select name="environmental_permits" id="environmental_permits">
                                                    <option value="">-- Select --</option>
                                                    <option value="Waste Disposal"
                                                        {{ $EHS->environmental_permits == 'Waste Disposal' ? 'selected' : '' }}>
                                                        Waste Disposal</option>
                                                    <option value="Water Discharge Permits"
                                                        {{ $EHS->environmental_permits == 'Water Discharge Permits' ? 'selected' : '' }}>
                                                        Water Discharge Permits</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="group-input">
                                                <label for="Workplace Safety Certifications">Workplace Safety
                                                    Certifications</label>
                                                <div class="relative-container">
                                                    <input type="number" id="workplace_safety_certifications"
                                                        name="workplace_safety_certifications"
                                                        value="{{ $EHS->workplace_safety_certifications }}">
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="button-block">
                                        <button type="submit" class="saveButton">Save</button>
                                        <button type="button" class="backButton"
                                            onclick="previousStep()">Back</button>
                                        <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                        <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}"
                                                class="text-white">
                                                Exit </a> </button>
                                    </div>
                                </div>
                            </div>

                            <div id="CCForm8" class="inner-block cctabcontent">
                                <div class="inner-block-content">

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="group-input">
                                                <label for="Incident ID">Incident ID</label>
                                                <input type="Number" name="incident_id" id="incident_id"
                                                    min="0" value="{{ $EHS->incident_id }}">
                                            </div>
                                        </div>
                                        <div><small class="text-primary">Date and Time of Incident</small></div>


                                        <div class="col-lg-6 new-date-data-field">
                                            <div class="group-input input-date">
                                                <label for="Date of Incident">Date of Incident</label>
                                                <div class="calenderauditee">
                                                    <input type="text" id="date_of_incident" readonly
                                                        placeholder="DD-MMM-YYYY"
                                                        value="{{ Helpers::getdateFormat($EHS->date_of_incident) }}"
                                                        {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }} />
                                                    <input type="date" id="date_of_incident_checkdate"
                                                        name="date_of_incident"
                                                        max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                                        {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}
                                                        value="{{ $EHS->date_of_incident }}" class="hide-input"
                                                        oninput="handleDateInput(this, 'date_of_incident');checkDate('date_of_incident_checkdate','date_of_incident1_checkdate')" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Time of Incident">Time of Incident</label>
                                                <input type="time" name="time_of_incident"
                                                    value="{{ $EHS->time_of_incident }}">
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Type of Incident">Type of Incident</label>
                                                <select name="type_of_incident" id="type_of_incident">
                                                    <option value="">-- Select --</option>
                                                    <option value="Accident"
                                                        {{ $EHS->type_of_incident == 'Accident' ? 'selected' : '' }}>
                                                        Accident</option>
                                                    <option value="Near Miss"
                                                        {{ $EHS->type_of_incident == 'Near Miss' ? 'selected' : '' }}>
                                                        Near Miss</option>
                                                    <option value="Chemical Spill"
                                                        {{ $EHS->type_of_incident == 'Chemical Spill' ? 'selected' : '' }}>
                                                        Chemical Spill</option>
                                                    <option value="Fire"
                                                        {{ $EHS->type_of_incident == 'Fire' ? 'selected' : '' }}>Fire
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Incident Severity">Incident Severity</label>
                                                <select name="incident_severity" id="incident_severity">
                                                    <option value="">-- Select --</option>
                                                    <option value="Minor"
                                                        {{ $EHS->incident_severity == 'Minor' ? 'selected' : '' }}>Minor
                                                    </option>
                                                    <option value="Moderate"
                                                        {{ $EHS->incident_severity == 'Moderate' ? 'selected' : '' }}>
                                                        Moderate</option>
                                                    <option value="Severe"
                                                        {{ $EHS->incident_severity == 'Severe' ? 'selected' : '' }}>
                                                        Severe</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Location of Incident">Location of Incident</label>
                                                <div class="relative-container">
                                                    <input type="text" name="location_of_incident"
                                                        value="{{ $EHS->location_of_incident }}">
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Affected Personnel">Affected Personnel</label>
                                                <select name="affected_personnel" id="affected_personnel">
                                                    <option value="">-- Select --</option>
                                                    <option value="Names"
                                                        {{ $EHS->affected_personnel == 'Names' ? 'selected' : '' }}>Names
                                                    </option>
                                                    <option value="Departments"
                                                        {{ $EHS->affected_personnel == 'Departments' ? 'selected' : '' }}>
                                                        Departments</option>
                                                    <option value="Injury Type"
                                                        {{ $EHS->affected_personnel == 'Injury Type' ? 'selected' : '' }}>
                                                        Injury Type</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Root Cause Analysis">Root Cause Analysis</label>
                                                <div class="relative-container">
                                                    <input type="text" name="root_cause_analysis"
                                                        value="{{ $EHS->root_cause_analysis }}">
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Corrective and Preventive Actions (CAPA)">Corrective and
                                                    Preventive Actions (CAPA)</label>
                                                <div class="relative-container">
                                                    <input type="text" name="corrective_and_preventive_actions"
                                                        value="{{ $EHS->corrective_and_preventive_actions }}">
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Investigation Reports">Investigation Reports</label>
                                                <div class="relative-container">
                                                    <input type="text" name="investigation_reports"
                                                        value="{{ $EHS->investigation_reports }}">
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Injury Severity and Report">Injury Severity and Report</label>
                                                <select name="injury_severity_and_report"
                                                    id="injury_severity_and_report">
                                                    <option value="">-- Select --</option>
                                                    <option value="First Aid"
                                                        {{ $EHS->injury_severity_and_report == 'First Aid' ? 'selected' : '' }}>
                                                        First Aid</option>
                                                    <option value="Medical Treatment"
                                                        {{ $EHS->injury_severity_and_report == 'Medical Treatment' ? 'selected' : '' }}>
                                                        Medical Treatment</option>
                                                    <option value="Hospitalization"
                                                        {{ $EHS->injury_severity_and_report == 'Hospitalization' ? 'selected' : '' }}>
                                                        Hospitalization</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Incident Resolution Status">Incident Resolution Status</label>
                                                <select name="incident_resolution_status"
                                                    id="incident_resolution_status">
                                                    <option value="">-- Select --</option>
                                                    <option value="Resolved"
                                                        {{ $EHS->incident_resolution_status == 'Resolved' ? 'selected' : '' }}>
                                                        Resolved</option>
                                                    <option value="Pending"
                                                        {{ $EHS->incident_resolution_status == 'Pending' ? 'selected' : '' }}>
                                                        Pending</option>
                                                    <option value="Under Investigation"
                                                        {{ $EHS->incident_resolution_status == 'Under Investigation' ? 'selected' : '' }}>
                                                        Under Investigation</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="button-block">
                                        <button type="submit" class="saveButton">Save</button>
                                        <button type="button" class="backButton"
                                            onclick="previousStep()">Back</button>
                                        <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                        <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}"
                                                class="text-white">
                                                Exit </a> </button>
                                    </div>
                                </div>
                            </div>

                            <div id="CCForm9" class="inner-block cctabcontent">
                                <div class="inner-block-content">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="root_cause">
                                                    Chemical and Hazardous Materials Management
                                                    <button type="button"
                                                        {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}
                                                        name="audit-incident-grid"
                                                        id="Chemical_and_Hazardous_Materials_Management_Add">+</button>
                                                    <span class="text-primary" data-bs-toggle="modal"
                                                        data-bs-target="#observation-field-instruction-modal"
                                                        style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                                        (Launch Instruction)
                                                    </span>
                                                </label>

                                                <table class="table table-bordered"
                                                    id="Chemical_and_Hazardous_Materials_Management_Add_field_table">
                                                    <thead>
                                                        <tr>
                                                            <th>Row#</th>
                                                            <th>Chemical Name</th>
                                                            <th>CAS Number</th>
                                                            <th>Material Safety Data Sheet (MSDS)</th>
                                                            <th>Quantity Stored</th>
                                                            <th>Safety Stock Level</th>
                                                            <th>Hazard Classification</th>
                                                            <th>Spill/Leak Containment Plan</th>
                                                            <th>Personal Protective Equipment Required for Handling</th>
                                                            <th>Waste Disposal Guidelines</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                            $serialNumber = 1;
                                                        @endphp
                                                        @foreach ($ChemicalandHazardous->data1 as $oogrid)
                                                            <tr>
                                                                <td disabled>{{ $serialNumber++ }}</td>
                                                                <td>
                                                                    <input type="text"
                                                                        {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}
                                                                        name="ChemicalAndHazardousMaterials[{{ $loop->index }}][Chemical_Name]"
                                                                        value="{{ $oogrid['Chemical_Name'] }}">
                                                                </td>
                                                                <td>
                                                                    <input type="number"
                                                                        {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}
                                                                        name="ChemicalAndHazardousMaterials[{{ $loop->index }}][CAS_Number]"
                                                                        value="{{ $oogrid['CAS_Number'] }}">
                                                                </td>
                                                                <td>
                                                                    <input type="text"
                                                                        {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}
                                                                        name="ChemicalAndHazardousMaterials[{{ $loop->index }}][Material_Safety_Data_Sheet]"
                                                                        value="{{ $oogrid['Material_Safety_Data_Sheet'] }}">
                                                                </td>
                                                                <td>
                                                                    <input type="number"
                                                                        {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}
                                                                        name="ChemicalAndHazardousMaterials[{{ $loop->index }}][Quantity_Stored]"
                                                                        value="{{ $oogrid['Quantity_Stored'] }}">
                                                                </td>
                                                                <td>
                                                                    <input type="text"
                                                                        {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}
                                                                        name="ChemicalAndHazardousMaterials[{{ $loop->index }}][Safety_Stock_Level]"
                                                                        value="{{ $oogrid['Safety_Stock_Level'] }}">
                                                                </td>
                                                                <td>
                                                                    <input type="text"
                                                                        {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}
                                                                        name="ChemicalAndHazardousMaterials[{{ $loop->index }}][Hazard_Classification]"
                                                                        value="{{ $oogrid['Hazard_Classification'] }}">
                                                                </td>
                                                                <td>
                                                                    <input type="text"
                                                                        {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}
                                                                        name="ChemicalAndHazardousMaterials[{{ $loop->index }}][Spill_Leak_Containment_Plan]"
                                                                        value="{{ $oogrid['Spill_Leak_Containment_Plan'] }}">
                                                                </td>
                                                                <td>
                                                                    <input type="text"
                                                                        {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}
                                                                        name="ChemicalAndHazardousMaterials[{{ $loop->index }}][Personal_Protective_Equipment]"
                                                                        value="{{ $oogrid['Personal_Protective_Equipment'] }}">
                                                                </td>
                                                                <td>
                                                                    <input type="text"
                                                                        {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}
                                                                        name="ChemicalAndHazardousMaterials[{{ $loop->index }}][Waste_Disposal_Guidelines]"
                                                                        value="{{ $oogrid['Waste_Disposal_Guidelines'] }}">
                                                                </td>

                                                                <td>
                                                                    <button class="removeRowBtn"
                                                                        {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>Remove</button>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <script>
                                            $(document).ready(function() {
                                                let investdetails = 1;
                                                $('#Chemical_and_Hazardous_Materials_Management_Add').click(function(e) {
                                                    function generateTableRow(serialNumber) {
                                                        var html =
                                                            '<tr>' +
                                                            '<td><input disabled type="text" style ="width:15px" value="' + serialNumber +
                                                            '"></td>' +
                                                            '<td><input type="text"  {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}  name="ChemicalAndHazardousMaterials[' +
                                                            investdetails + '][Chemical_Name]" value=""></td>' +
                                                            '<td><input type="number"  {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}  name="ChemicalAndHazardousMaterials[' +
                                                            investdetails + '][CAS_Number]" value=""></td>' +
                                                            '<td><input type="text"  {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }} name="ChemicalAndHazardousMaterials[' +
                                                            investdetails + '][Material_Safety_Data_Sheet]" value=""></td>' +
                                                            '<td><input type="number"  {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}  name="ChemicalAndHazardousMaterials[' +
                                                            investdetails + '][Quantity_Stored]" value=""></td>' +
                                                            '<td><input type="text"  {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}  name="ChemicalAndHazardousMaterials[' +
                                                            investdetails + '][Safety_Stock_Level]" value=""></td>' +
                                                            '<td><input type="text"  {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}  name="ChemicalAndHazardousMaterials[' +
                                                            investdetails + '][Hazard_Classification]" value=""></td>' +
                                                            '<td><input type="text"  {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }} name="ChemicalAndHazardousMaterials[' +
                                                            investdetails + '][Spill_Leak_Containment_Plan]" value=""></td>' +
                                                            '<td><input type="text"  {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}  name="ChemicalAndHazardousMaterials[' +
                                                            investdetails + '][Personal_Protective_Equipment]" value=""></td>' +
                                                            '<td><input type="text"  {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}  name="ChemicalAndHazardousMaterials[' +
                                                            investdetails + '][Waste_Disposal_Guidelines]" value=""></td>' +
                                                            '<td><button class="removeRowBtn"  {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>Remove</button>' +

                                                            '</tr>';
                                                        investdetails++; // Increment the row number here
                                                        return html;
                                                    }

                                                    var tableBody = $('#Chemical_and_Hazardous_Materials_Management_Add_field_table tbody');
                                                    var rowCount = tableBody.children('tr').length;
                                                    var newRow = generateTableRow(rowCount + 1);
                                                    tableBody.append(newRow);
                                                });
                                                $(document).on('click', '.removeRowBtn', function() {
                                                    $(this).closest('tr').remove();
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

                            <div id="CCForm10" class="inner-block cctabcontent">
                                <div class="inner-block-content">

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="group-input">
                                                <label for="Workplace Safety Audits">Workplace Safety Audits</label>
                                                <div class="relative-container">
                                                    <textarea type="text" name="workplace_safety_audits" id="workplace_safety_audits">{{ $EHS->workplace_safety_audits }}</textarea>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Hazardous Area Identification">Hazardous Area
                                                    Identification</label>
                                                <select name="hazardous_area_identification"
                                                    id="hazardous_area_identification">
                                                    <option value="">-- Select --</option>
                                                    <option value="Zones for Flammable Materials"
                                                        {{ $EHS->hazardous_area_identification == 'Zones for Flammable Materials' ? 'selected' : '' }}>
                                                        Zones for Flammable Materials</option>
                                                    <option value="High Voltage Areas"
                                                        {{ $EHS->hazardous_area_identification == 'High Voltage Areas' ? 'selected' : '' }}>
                                                        High Voltage Areas</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Ventilation Systems Monitoring">Ventilation Systems
                                                    Monitoring</label>
                                                <select name="ventilation_systems_monitoring"
                                                    id="ventilation_systems_monitoring">
                                                    <option value="">-- Select --</option>
                                                    <option value="Air Quality"
                                                        {{ $EHS->ventilation_systems_monitoring == 'Air Quality' ? 'selected' : '' }}>
                                                        Air Quality</option>
                                                    <option value="Exhaust Systems"
                                                        {{ $EHS->ventilation_systems_monitoring == 'Exhaust Systems' ? 'selected' : '' }}>
                                                        Exhaust Systems</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Noise Levels Monitoring">Noise Levels Monitoring</label>
                                                <input type="text" name="noise_levels_monitoring"
                                                    value="{{ $EHS->noise_levels_monitoring }}">
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Lighting and Temperature Monitoring">Lighting and Temperature
                                                    Monitoring</label>
                                                <input type="text" name="lighting_and_temperature_monitoring"
                                                    value="{{ $EHS->lighting_and_temperature_monitoring }}">
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Personal Monitoring (Health and Safety Data)">Personal
                                                    Monitoring (Health and Safety Data)</label>
                                                <select name="personal_monitoring" id="personal_monitoring">
                                                    <option value="">-- Select --</option>
                                                    <option value="Fatigue Management"
                                                        {{ $EHS->personal_monitoring == 'Fatigue Management' ? 'selected' : '' }}>
                                                        Fatigue Management</option>
                                                    <option value="Exposure Limits"
                                                        {{ $EHS->personal_monitoring == 'Exposure Limits' ? 'selected' : '' }}>
                                                        Exposure Limits</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Ergonomics Data">Ergonomics Data</label>
                                                <select name="ergonomics_data" id="ergonomics_data">
                                                    <option value="">-- Select --</option>
                                                    <option value="Workplace Layout"
                                                        {{ $EHS->ergonomics_data == 'Workplace Layout' ? 'selected' : '' }}>
                                                        Workplace Layout</option>
                                                    <option value="Workstation Setup"
                                                        {{ $EHS->ergonomics_data == 'Workstation Setup' ? 'selected' : '' }}>
                                                        Workstation Setup</option>
                                                    <option value="Equipment Usage"
                                                        {{ $EHS->ergonomics_data == 'Equipment Usage' ? 'selected' : '' }}>
                                                        Equipment Usage</option>
                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="button-block">
                                        <button type="submit" class="saveButton">Save</button>
                                        <button type="button" class="backButton"
                                            onclick="previousStep()">Back</button>
                                        <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                        <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}"
                                                class="text-white">
                                                Exit </a> </button>
                                    </div>
                                </div>
                            </div>
                            <div id="CCForm11" class="inner-block cctabcontent">
                                <div class="inner-block-content">

                                    <div class="row">
                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Employee Health Records">Employee Health Records</label>
                                                <select name="Employee_Health_Records" id="Employee_Health_Records">
                                                    <option value="">-- Select --</option>
                                                    <option value="Pre-employment"
                                                        {{ $EHS->Employee_Health_Records == 'Pre-employment' ? 'selected' : '' }}>
                                                        Pre-employment</option>
                                                    <option value="Routine Health Check-ups"
                                                        {{ $EHS->Employee_Health_Records == 'Routine Health Check-ups' ? 'selected' : '' }}>
                                                        Routine Health Check-ups</option>
                                                    <option value="Occupational Diseases"
                                                        {{ $EHS->Employee_Health_Records == 'Occupational Diseases' ? 'selected' : '' }}>
                                                        Occupational Diseases</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Occupational Exposure Limits">Occupational Exposure
                                                    Limits</label>
                                                <select name="Occupational_Exposure_Limits"
                                                    id="Occupational_Exposure_Limits">
                                                    <option value="">-- Select --</option>
                                                    <option value="PEL"
                                                        {{ $EHS->Occupational_Exposure_Limits == 'PEL' ? 'selected' : '' }}>
                                                        PEL</option>
                                                    <option value="TLV for Hazardous Substances"
                                                        {{ $EHS->Occupational_Exposure_Limits == 'TLV for Hazardous Substances' ? 'selected' : '' }}>
                                                        TLV for Hazardous Substances</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Vaccination Records">Vaccination Records</label>
                                                <div class="relative-container">
                                                    <input type="text" name="Vaccination_Records"
                                                        value="{{ $EHS->Vaccination_Records }}">
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Pre-employment and Routine Health Screenings">Pre-employment
                                                    and Routine Health Screenings</label>
                                                <div class="relative-container">
                                                    <input type="text"
                                                        name="Pre_employment_and_Routine_Health_Screenings"
                                                        value="{{ $EHS->Pre_employment_and_Routine_Health_Screenings }}">
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Workplace Injury and Illness Reporting">Workplace Injury and
                                                    Illness Reporting</label>
                                                <div class="relative-container">
                                                    <input type="text" name="Workplace_Injury_and_Illness_Reporting"
                                                        value="{{ $EHS->Workplace_Injury_and_Illness_Reporting }}">
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Absenteeism Data">Absenteeism Data</label>
                                                <div class="relative-container">
                                                    <input type="text" name="Absenteeism_Data"
                                                        value="{{ $EHS->Absenteeism_Data }}">
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Safety Drills and Training Records">Safety Drills and Training
                                                    Records</label>
                                                <div class="relative-container">
                                                    <input type="text" name="Safety_Drills_and_Training_Records"
                                                        value="{{ $EHS->Safety_Drills_and_Training_Records }}">
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="First Aid and Emergency Response Records">First Aid and
                                                    Emergency Response Records</label>
                                                <div class="relative-container">
                                                    <input type="text"
                                                        name="First_Aid_and_Emergency_Response_Records"
                                                        value="{{ $EHS->First_Aid_and_Emergency_Response_Records }}">
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="button-block">
                                        <button type="submit" class="saveButton">Save</button>
                                        <button type="button" class="backButton"
                                            onclick="previousStep()">Back</button>
                                        <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                        <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}"
                                                class="text-white">
                                                Exit </a> </button>
                                    </div>
                                </div>
                            </div>

                            <div id="CCForm12" class="inner-block cctabcontent">
                                <div class="inner-block-content">

                                    <div class="row">

                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Emergency Plan">Emergency Plan</label>
                                                <select name="Emergency_Plan" id="Emergency_Plan">
                                                    <option value="">-- Select --</option>
                                                    <option value="Evacuation Procedures"
                                                        {{ $EHS->Emergency_Plan == 'Evacuation Procedures' ? 'selected' : '' }}>
                                                        Evacuation Procedures</option>
                                                    <option value="Fire Safety Plans"
                                                        {{ $EHS->Emergency_Plan == 'Fire Safety Plans' ? 'selected' : '' }}>
                                                        Fire Safety Plans</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Emergency Contacts">Emergency Contacts</label>
                                                <select name="Emergency_Contacts2" id="Emergency_Contacts2">
                                                    <option value="">-- Select --</option>
                                                    <option value="Fire Department"
                                                        {{ $EHS->Emergency_Contacts2 == 'Fire Department' ? 'selected' : '' }}>
                                                        Fire Department</option>
                                                    <option value="Medical Team"
                                                        {{ $EHS->Emergency_Contacts2 == 'Medical Team' ? 'selected' : '' }}>
                                                        Medical Team</option>
                                                    <option value="First Responders"
                                                        {{ $EHS->Emergency_Contacts2 == 'First Responders' ? 'selected' : '' }}>
                                                        First Responders</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Emergency Equipment">Emergency Equipment</label>
                                                <select name="Emergency_Equipment" id="Emergency_Equipment">
                                                    <option value="">-- Select --</option>
                                                    <option value="Location and Maintenance of Fire Extinguishers"
                                                        {{ $EHS->Emergency_Equipment == 'Location and Maintenance of Fire Extinguishers' ? 'selected' : '' }}>
                                                        Location and Maintenance of Fire Extinguishers</option>
                                                    <option value="First Aid Kits"
                                                        {{ $EHS->Emergency_Equipment == 'First Aid Kits' ? 'selected' : '' }}>
                                                        First Aid Kits</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Incident Simulation Drills">Incident Simulation Drills</label>
                                                <select name="Incident_Simulation_Drills"
                                                    id="Incident_Simulation_Drills">
                                                    <option value="">-- Select --</option>
                                                    <option value="Date"
                                                        {{ $EHS->Incident_Simulation_Drills == 'Date' ? 'selected' : '' }}>
                                                        Date</option>
                                                    <option value="Type"
                                                        {{ $EHS->Incident_Simulation_Drills == 'Type' ? 'selected' : '' }}>
                                                        Type</option>
                                                    <option value="Results"
                                                        {{ $EHS->Incident_Simulation_Drills == 'Results' ? 'selected' : '' }}>
                                                        Results</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Response Time Metrics">Response Time Metrics</label>
                                                <div class="relative-container">
                                                    <input type="text" name="Response_Time_Metrics"
                                                        value="{{ $EHS->Response_Time_Metrics }}">
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Evacuation Routes and Assembly Points">Evacuation Routes and
                                                    Assembly Points</label>
                                                <div class="relative-container">
                                                    <input type="text" name="Evacuation_Routes_and_Assembly_Points"
                                                        value="{{ $EHS->Evacuation_Routes_and_Assembly_Points }}">
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="button-block">
                                        <button type="submit" class="saveButton">Save</button>
                                        <button type="button" class="backButton"
                                            onclick="previousStep()">Back</button>
                                        <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                        <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}"
                                                class="text-white">
                                                Exit </a> </button>
                                    </div>
                                </div>
                            </div>

                            <div id="CCForm13" class="inner-block cctabcontent">
                                <div class="inner-block-content">
                                    <div class="row">

                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="root_cause">
                                                    Waste Management
                                                    <button type="button"
                                                        {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}
                                                        name="audit-incident-grid" id="Waste_Management_Add">+</button>
                                                    <span class="text-primary" data-bs-toggle="modal"
                                                        data-bs-target="#observation-field-instruction-modal"
                                                        style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                                        (Launch Instruction)
                                                    </span>
                                                </label>

                                                <table class="table table-bordered"
                                                    id="Waste_Management_Add_field_table">
                                                    <thead>
                                                        <tr>
                                                            <th>Row#</th>
                                                            <th>Total Waste Generated (kg or tons)</th>
                                                            <th>Waste Type</th>
                                                            <th>Waste Disposal Method</th>
                                                            <th>Waste Recycling Rate</th>
                                                            <th>Waste to Landfill</th>
                                                            <th>Waste Reduction Initiatives</th>
                                                            <th>Hazardous Waste Management</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                            $serialNumber = 1;
                                                        @endphp
                                                        @foreach ($WasteManagementInfo->data1 as $oogrid)
                                                            <tr>
                                                                <td disabled>{{ $serialNumber++ }}</td>
                                                                <td>
                                                                    <input type="number"
                                                                        {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}
                                                                        name="WasteManagement[{{ $loop->index }}][Total_Waste_Generated]"
                                                                        value="{{ $oogrid['Total_Waste_Generated'] }}">
                                                                </td>
                                                                <td>
                                                                    <input type="text"
                                                                        {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}
                                                                        name="WasteManagement[{{ $loop->index }}][Waste_Type]"
                                                                        value="{{ $oogrid['Waste_Type'] }}">
                                                                </td>
                                                                <td>
                                                                    <input type="text"
                                                                        {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}
                                                                        name="WasteManagement[{{ $loop->index }}][Waste_Disposal_Method]"
                                                                        value="{{ $oogrid['Waste_Disposal_Method'] }}">
                                                                </td>
                                                                <td>
                                                                    <input type="number"
                                                                        {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}
                                                                        name="WasteManagement[{{ $loop->index }}][Waste_Recycling_Rate]"
                                                                        value="{{ $oogrid['Waste_Recycling_Rate'] }}">
                                                                </td>
                                                                <td>
                                                                    <input type="number"
                                                                        {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}
                                                                        name="WasteManagement[{{ $loop->index }}][Waste_to_Landfill]"
                                                                        value="{{ $oogrid['Waste_to_Landfill'] }}">
                                                                </td>
                                                                <td>
                                                                    <input type="text"
                                                                        {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}
                                                                        name="WasteManagement[{{ $loop->index }}][Waste_Reduction_Initiatives]"
                                                                        value="{{ $oogrid['Waste_Reduction_Initiatives'] }}">
                                                                </td>
                                                                <td>
                                                                    <input type="text"
                                                                        {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}
                                                                        name="WasteManagement[{{ $loop->index }}][Hazardous_Waste_Management]"
                                                                        value="{{ $oogrid['Hazardous_Waste_Management'] }}">
                                                                </td>

                                                                <td>
                                                                    <button class="removeRowBtn"
                                                                        {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>Remove</button>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <script>
                                            $(document).ready(function() {
                                                let investdetails = 1;
                                                $('#Waste_Management_Add').click(function(e) {
                                                    function generateTableRow(serialNumber) {
                                                        var html =
                                                            '<tr>' +
                                                            '<td><input disabled type="text" style ="width:15px" value="' + serialNumber +
                                                            '"></td>' +
                                                            '<td><input type="number"  {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}  name="WasteManagement[' +
                                                            investdetails + '][Total_Waste_Generated]" value=""></td>' +
                                                            '<td><input type="text"  {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}  name="WasteManagement[' +
                                                            investdetails + '][Waste_Type]" value=""></td>' +
                                                            '<td><input type="text"  {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }} name="WasteManagement[' +
                                                            investdetails + '][Waste_Disposal_Method]" value=""></td>' +
                                                            '<td><input type="number"  {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}  name="WasteManagement[' +
                                                            investdetails + '][Waste_Recycling_Rate]" value=""></td>' +
                                                            '<td><input type="number"  {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}  name="WasteManagement[' +
                                                            investdetails + '][Waste_to_Landfill]" value=""></td>' +
                                                            '<td><input type="text"  {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}  name="WasteManagement[' +
                                                            investdetails + '][Waste_Reduction_Initiatives]" value=""></td>' +
                                                            '<td><input type="text"  {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }} name="WasteManagement[' +
                                                            investdetails + '][Hazardous_Waste_Management]" value=""></td>' +
                                                            '<td><button class="removeRowBtn"  {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>Remove</button>' +

                                                            '</tr>';
                                                        investdetails++; // Increment the row number here
                                                        return html;
                                                    }

                                                    var tableBody = $('#Waste_Management_Add_field_table tbody');
                                                    var rowCount = tableBody.children('tr').length;
                                                    var newRow = generateTableRow(rowCount + 1);
                                                    tableBody.append(newRow);
                                                });
                                                $(document).on('click', '.removeRowBtn', function() {
                                                    $(this).closest('tr').remove();
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

                            <div id="CCForm14" class="inner-block cctabcontent">
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
                                                                    <input disabled type="text"
                                                                        name="trainingPlanData[{{ $index }}][serial]"
                                                                        value="{{ (int) $index + 1 }}">
                                                                </td>
                                                                <td>
                                                                    <input type="text"
                                                                        name="trainingPlanData[{{ $index }}][trainingTopic]"
                                                                        value="{{ $item['trainingTopic'] }}"
                                                                        {{ $data->stage == 4 ? '' : 'readonly' }}>
                                                                </td>
                                                                <td>
                                                                    <select
                                                                        name="trainingPlanData[{{ $index }}][documentNumber]"
                                                                        id="documentPlan_{{ $index }}"
                                                                        class="training-select"
                                                                        {{ $data->stage == 4 ? '' : 'readonly' }}>
                                                                        <option value="">-- Select --</option>
                                                                        @foreach ($documents as $document)
                                                                            <option value="{{ $document->id }}"
                                                                                {{ $item['documentNumber'] == $document->id ? 'selected' : '' }}>
                                                                                {{ $document->document_name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="doc_number"
                                                                        name="trainingPlanData[{{ $index }}][documentName]"
                                                                        readonly
                                                                        value="{{ $item['documentName'] ?? '' }}">
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="sop_type"
                                                                        name="trainingPlanData[{{ $index }}][sopType]"
                                                                        value="{{ $item['sopType'] }}" readonly>
                                                                </td>
                                                                <td>
                                                                    <select
                                                                        name="trainingPlanData[{{ $index }}][trainingType]"
                                                                        {{ $data->stage == 4 ? '' : 'readonly' }}>
                                                                        <option value="">-- Select --</option>
                                                                        <option value="Read & Understand"
                                                                            @if (isset($item['trainingType']) && $item['trainingType'] == 'Read & Understand') selected @endif>
                                                                            Read & Understand</option>
                                                                        <option value="Read & Understand with Questions"
                                                                            @if (isset($item['trainingType']) && $item['trainingType'] == 'Read & Understand with Questions') selected @endif>
                                                                            Read & Understand with Questions</option>
                                                                        <option value="Classroom Training"
                                                                            @if (isset($item['trainingType']) && $item['trainingType'] == 'Classroom Training') selected @endif>
                                                                            Classroom Training</option>
                                                                        <option value="On Job Training"
                                                                            @if (isset($item['trainingType']) && $item['trainingType'] == 'On Job Training') selected @endif>
                                                                            On Job Training</option>
                                                                        <option value="External Training"
                                                                            @if (isset($item['trainingType']) && $item['trainingType'] == 'External Training') selected @endif>
                                                                            External Training</option>
                                                                        <option value="Refresher Training"
                                                                            @if (isset($item['trainingType']) && $item['trainingType'] == 'Refresher Training') selected @endif>
                                                                            Refresher Training</option>
                                                                        <option value="Retraining"
                                                                            @if (isset($item['trainingType']) && $item['trainingType'] == 'Retraining') selected @endif>
                                                                            Retraining</option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <select
                                                                        name="trainingPlanData[{{ $index }}][trainees]"
                                                                        readonly>
                                                                        <option value="">-- Select --</option>
                                                                        @foreach ($users as $employee)
                                                                            <option value="{{ $employee->id }}"
                                                                                {{ $item['trainees'] == $employee->id ? 'selected' : '' }}>
                                                                                {{ $employee->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <input type="date"
                                                                        name="trainingPlanData[{{ $index }}][startDate]"
                                                                        value="{{ $item['startDate'] ?? '' }}"
                                                                        {{ $data->stage == 4 ? '' : 'readonly' }}>
                                                                </td>
                                                                <td>
                                                                    <input type="date"
                                                                        name="trainingPlanData[{{ $index }}][endDate]"
                                                                        value="{{ $item['endDate'] }}"
                                                                        {{ $data->stage == 4 ? '' : 'readonly' }}>
                                                                </td>
                                                                <td>
                                                                    <select
                                                                        name="trainingPlanData[{{ $index }}][trainer]"
                                                                        {{ $data->stage == 4 ? '' : 'readonly' }}>
                                                                        <option value="">-- Select --</option>
                                                                        @foreach ($users as $user)
                                                                            <option value="{{ $user->id }}"
                                                                                {{ $item['trainer'] == $user->id ? 'selected' : '' }}>
                                                                                {{ $user->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <input type="text"
                                                                        {{ $data->stage == 4 ? '' : 'readonly' }}
                                                                        name="trainingPlanData[{{ $index }}][trainingAttempt]"
                                                                        value="{{ $item['trainingAttempt'] }}">
                                                                </td>
                                                                <td>
                                                                    <input type="file"
                                                                        name="trainingPlanData[{{ $index }}][file]"
                                                                        class="file-picker"
                                                                        {{ $data->stage == 4 ? '' : 'readonly' }}> <br>
                                                                    @if (!empty($item['file_path']))
                                                                        <a href="{{ asset($item['file_path']) }}"
                                                                            target="_blank">{{ basename($item['file_path']) }}</a>
                                                                        <input type="hidden"
                                                                            name="trainingPlanData[{{ $index }}][file_path]"
                                                                            value="{{ $item['file_path'] }}">
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    <input type="text"
                                                                        name="trainingPlanData[{{ $index }}][total_minimum_time]"
                                                                        value="{{ $item['total_minimum_time'] }}"
                                                                        {{ $data->stage == 4 ? '' : 'readonly' }}>
                                                                </td>
                                                                <td>
                                                                    <input type="text"
                                                                        name="trainingPlanData[{{ $index }}][per_screen_run_time]"
                                                                        value="{{ $item['per_screen_run_time'] }}"
                                                                        {{ $data->stage == 4 ? '' : 'readonly' }}>
                                                                </td>
                                                                <td><button type="button"
                                                                        class="removeRowBtn">Remove</button></td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <script>
                                            $(document).ready(function() {
                                                let trainingPlanIndex =
                                                    {{ $trainingPlanData && is_array($trainingPlanData) ? count($trainingPlanData) : 0 }};
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
                                                            documentOptionHtml +=
                                                                `<option value="${document.id}">${document.document_name}</option>`;
                                                        });

                                                        var users = @json($users);
                                                        var employeeOptionHtml = '<option value="">-- Select --</option>';
                                                        users.forEach(employee => {
                                                            employeeOptionHtml +=
                                                                `<option value="${employee.id}">${employee.name}</option>`;
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
                                                                <td><input type="text" name="trainingPlanData[${trainingPlanIndex}][trainingAttempt]" value="3" readonly></td>
                                                                <td><input type="file" name="trainingPlanData[${trainingPlanIndex}][file]" class="file-picker"></td>
                                                                <td><input type="text" name="trainingPlanData[${trainingPlanIndex}][total_minimum_time]"></td>
                                                                <td><input type="text" name="trainingPlanData[${trainingPlanIndex}][per_screen_run_time]"></td>
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

                                    </div>
                                    <div class="button-block">
                                        <button type="submit" class="saveButton">Save</button>
                                        <button type="button" class="backButton"
                                            onclick="previousStep()">Back</button>
                                        <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                        <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}"
                                                class="text-white">Exit</a></button>
                                    </div>
                                </div>
                            </div>

                            <div id="CCForm15" class="inner-block cctabcontent">
                                <div class="inner-block-content">

                                    <div class="row">

                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Energy Consumption">Energy Consumption</label>
                                                <select name="Energy_Consumption" id="Energy_Consumption">
                                                    <option value="">-- Select --</option>
                                                    <option value="Electricity"
                                                        {{ $EHS->Energy_Consumption == 'Electricity' ? 'selected' : '' }}>
                                                        Electricity</option>
                                                    <option value="Gas"
                                                        {{ $EHS->Energy_Consumption == 'Gas' ? 'selected' : '' }}>Gas
                                                    </option>
                                                    <option value="Water"
                                                        {{ $EHS->Energy_Consumption == 'Water' ? 'selected' : '' }}>Water
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Greenhouse Gas Emissions">Greenhouse Gas Emissions</label>
                                                <select name="Greenhouse_Gas_Emissions" id="Greenhouse_Gas_Emissions">
                                                    <option value="">-- Select --</option>
                                                    <option value="CO2"
                                                        {{ $EHS->Greenhouse_Gas_Emissions == 'CO2' ? 'selected' : '' }}>
                                                        CO2</option>
                                                    <option value="NOx"
                                                        {{ $EHS->Greenhouse_Gas_Emissions == 'NOx' ? 'selected' : '' }}>
                                                        NOx</option>
                                                    <option value="Particulate Matter"
                                                        {{ $EHS->Greenhouse_Gas_Emissions == 'Particulate Matter' ? 'selected' : '' }}>
                                                        Particulate Matter</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Wastewater Discharge">Wastewater Discharge</label>
                                                <select name="Wastewater_Discharge" id="Wastewater_Discharge">
                                                    <option value="">-- Select --</option>
                                                    <option value="Quality and Quantity"
                                                        {{ $EHS->Wastewater_Discharge == 'Quality and Quantity' ? 'selected' : '' }}>
                                                        Quality and Quantity</option>
                                                    <option value="Compliance with Standards"
                                                        {{ $EHS->Wastewater_Discharge == 'Compliance with Standards' ? 'selected' : '' }}>
                                                        Compliance with Standards</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Air Quality Monitoring ">Air Quality Monitoring </label>
                                                <div class="relative-container">
                                                    <input type="text" name="Air_Quality_Monitoring"
                                                        value="{{ $EHS->Air_Quality_Monitoring }}">
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Environmental Sustainability Projects">Environmental
                                                    Sustainability Projects</label>
                                                <div class="relative-container">
                                                    <input type="text" name="Environmental_Sustainability_Projects"
                                                        value="{{ $EHS->Environmental_Sustainability_Projects }}">
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="button-block">
                                        <button type="submit" class="saveButton">Save</button>
                                        <button type="button" class="backButton"
                                            onclick="previousStep()">Back</button>
                                        <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                        <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}"
                                                class="text-white">
                                                Exit </a> </button>
                                    </div>
                                </div>
                            </div>

                            <div id="CCForm16" class="inner-block cctabcontent">
                                <div class="inner-block-content">
                                    <div class="row">


                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Impact">Energy Type</label>
                                                <select name="enargy_type" id="enargy_type">
                                                    <option value="">-- Select --</option>
                                                    <option value="Electricity"
                                                        {{ $EHS->enargy_type == 'Electricity' ? 'selected' : '' }}>
                                                        Electricity</option>
                                                    <option value="Natural Gas"
                                                        {{ $EHS->enargy_type == 'Natural Gas' ? 'selected' : '' }}>
                                                        Natural Gas</option>
                                                    <option value="Renewable Energy"
                                                        {{ $EHS->enargy_type == 'Renewable Energy' ? 'selected' : '' }}>
                                                        Renewable Energy</option>
                                                    <option value="Fuel"
                                                        {{ $EHS->enargy_type == 'Fuel' ? 'selected' : '' }}>Fuel</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Impact">Energy Source</label>
                                                <select name="enargy_source" id="enargy_source">
                                                    <option value="">-- Select --</option>
                                                    <option value="Grid"
                                                        {{ $EHS->enargy_source == 'Grid' ? 'selected' : '' }}>Grid
                                                    </option>
                                                    <option value="Renewable"
                                                        {{ $EHS->enargy_source == 'Renewable' ? 'selected' : '' }}>
                                                        Renewable</option>
                                                    <option value="On-Site Generation"
                                                        {{ $EHS->enargy_source == 'On-Site Generation' ? 'selected' : '' }}>
                                                        On-Site Generation</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Comments">Energy Usage (kWh)</label>
                                                <div class="relative-container">
                                                    <input name="energy_usage" id="energy_usage"
                                                        value="{{ $EHS->energy_usage }}"></input>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Comments">Energy Intensity</label>
                                                <div class="relative-container">
                                                    <input name="energy_intensity" id="energy_intensity"
                                                        value="{{ $EHS->energy_intensity }}"></input>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Comments">Peak Demand (kW)</label>
                                                <div class="relative-container">
                                                    <input name="peak_demand" id="peak_demand"
                                                        value="{{ $EHS->peak_demand }}"></input>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Comments">Energy Efficiency</label>
                                                <div class="relative-container">
                                                    <input name="energy_efficiency" id="energy_efficiency"
                                                        value="{{ $EHS->energy_efficiency }}"></input>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>



                                    </div>
                                    <div class="button-block">
                                        <button type="submit" class="saveButton">Save</button>
                                        <button type="button" class="backButton"
                                            onclick="previousStep()">Back</button>
                                        <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                        <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}"
                                                class="text-white">
                                                Exit </a> </button>
                                    </div>
                                </div>
                            </div>
                            <!-- --- ------------- -->

                            <div id="CCForm17" class="inner-block cctabcontent">
                                <div class="inner-block-content">
                                    <div class="row">

                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Comments">CO2 Emissions (kg/tons)</label>
                                                <div class="relative-container">
                                                    <input name="co_emissions" id="co_emissions"
                                                        value="{{ $EHS->co_emissions }}"></input>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Comments">Greenhouse Gas Emissions (GHG)</label>
                                                <div class="relative-container">
                                                    <textarea name="greenhouse_ges_emmission" id="greenhouse_ges_emmission">{{ $EHS->greenhouse_ges_emmission }}</textarea>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Comments">Scope 1 Emissions</label>
                                                <div class="relative-container">
                                                    <input name="scope_one_emission" id="scope_one_emission"
                                                        value="{{ $EHS->scope_one_emission }}"></input>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Comments">Scope 2 Emissions</label>
                                                <div class="relative-container">
                                                    <input name="scope_two_emission" id="scope_two_emission"
                                                        value="{{ $EHS->scope_two_emission }}"></input>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Comments">Scope 3 Emissions</label>
                                                <div class="relative-container">
                                                    <input name="scope_three_emission" id="scope_three_emission"
                                                        value="{{ $EHS->scope_three_emission }}"></input>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Comments">Carbon Intensity</label>
                                                <div class="relative-container">
                                                    <input name="carbon_intensity" id="carbon_intensity"
                                                        value="{{ $EHS->carbon_intensity }}"></input>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>

                                        <!-- <div class="col-lg-6">
                                                        <div class="group-input">
                                                            <label for="Impact">Energy Source</label>
                                                            <select name="enargy_source" id="enargy_source">
                                                                <option value="">-- Select --</option>
                                                                <option value="Grid">Grid</option>
                                                                <option value="Renewable">Renewable</option>
                                                                <option value="On-Site Generation">On-Site Generation</option>
                                                            </select>
                                                        </div>
                                                    </div> -->





                                    </div>
                                    <div class="button-block">
                                        <button type="submit" class="saveButton">Save</button>
                                        <button type="button" class="backButton"
                                            onclick="previousStep()">Back</button>
                                        <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                        <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}"
                                                class="text-white">
                                                Exit </a> </button>
                                    </div>
                                </div>
                            </div>

                            <!-- --- ------------ -->
                            <div id="CCForm18" class="inner-block cctabcontent">
                                <div class="inner-block-content">
                                    <div class="row">

                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Comments">Water Consumption (m³ or liters)</label>
                                                <div class="relative-container">
                                                    <input name="water_consumption" id="water_consumption"
                                                        value="{{ $EHS->water_consumption }}"></input>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Impact">Water Source</label>
                                                <select name="water_source" id="water_source">
                                                    <option value="">-- Select --</option>
                                                    <option value="Municipal Water"
                                                        {{ $EHS->water_source == 'Municipal Water' ? 'selected' : '' }}>
                                                        Municipal Water</option>
                                                    <option value="Groundwater"
                                                        {{ $EHS->water_source == 'Groundwater' ? 'selected' : '' }}>
                                                        Groundwater</option>
                                                    <option value="Recycled Water"
                                                        {{ $EHS->water_source == 'Recycled Water' ? 'selected' : '' }}>
                                                        Recycled Water</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Comments">Water Efficiency</label>
                                                <div class="relative-container">
                                                    <input name="water_effeciency" id="water_effeciency"
                                                        value="{{ $EHS->water_effeciency }}"></input>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Comments">Water Discharge (m³ or liters)</label>
                                                <div class="relative-container">
                                                    <input name="water_discharge" id="water_discharge"
                                                        value="{{ $EHS->water_discharge }}"></input>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Comments">Waste Water Treatment</label>
                                                <div class="relative-container">
                                                    <textarea name="waste_water_treatment" id="waste_water_treatment">{{ $EHS->waste_water_treatment }}</textarea>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Comments">Rainwater Harvesting</label>
                                                <div class="relative-container">
                                                    <input name="rainwater_harvesting" id="rainwater_harvesting"
                                                        value="{{ $EHS->rainwater_harvesting }}"></input>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="button-block">
                                        <button type="submit" class="saveButton">Save</button>
                                        <button type="button" class="backButton"
                                            onclick="previousStep()">Back</button>
                                        <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                        <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}"
                                                class="text-white">
                                                Exit </a> </button>
                                    </div>
                                </div>
                            </div>

                            <!-- ---- ------- -->

                            <div id="CCForm19" class="inner-block cctabcontent">
                                <div class="inner-block-content">
                                    <div class="row">

                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Comments">Sustainable Products Purchased</label>
                                                <div class="relative-container">
                                                    <input name="sustainable_product_purchased"
                                                        id="sustainable_product_purchased"
                                                        value="{{ $EHS->sustainable_product_purchased }}"></input>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Comments">Supplier Sustainability</label>
                                                <div class="relative-container">
                                                    <textarea name="supplier_sustainability" id="supplier_sustainability">{{ $EHS->supplier_sustainability }}</textarea>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Comments">Sustainable Packaging</label>
                                                <div class="relative-container">
                                                    <input name="sustainable_packaing" id="sustainable_packaing"
                                                        value="{{ $EHS->sustainable_packaing }}"></input>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Comments">Local Sourcing</label>
                                                <div class="relative-container">
                                                    <input name="local_sourcing" id="local_sourcing"
                                                        value="{{ $EHS->local_sourcing }}"></input>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Comments">Fair Trade or Certification Labels</label>
                                                <div class="relative-container">
                                                    <textarea name="fair_trade" id="fair_trade">{{ $EHS->fair_trade }}</textarea>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>


                                        <!-- <div class="col-lg-6">
                                                        <div class="group-input">
                                                            <label for="Impact">Water Source</label>
                                                            <select name="water_source" id="water_source">
                                                                <option value="">-- Select --</option>
                                                                <option value="Municipal Water">Municipal Water</option>
                                                                <option value="Groundwater">Groundwater</option>
                                                                <option value="Recycled Water">Recycled Water</option>
                                                            </select>
                                                        </div>
                                                    </div> -->






                                    </div>
                                    <div class="button-block">
                                        <button type="submit" class="saveButton">Save</button>
                                        <button type="button" class="backButton"
                                            onclick="previousStep()">Back</button>
                                        <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                        <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}"
                                                class="text-white">
                                                Exit </a> </button>
                                    </div>
                                </div>
                            </div>

                            <!-- --- ----- -->
                            <div id="CCForm20" class="inner-block cctabcontent">
                                <div class="inner-block-content">
                                    <div class="row">

                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Comments">Fuel Consumption</label>
                                                <div class="relative-container">
                                                    <input name="fuel_consumption" id="fuel_consumption"
                                                        value="{{ $EHS->fuel_consumption }}"></input>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Impact">Vehicle Type</label>
                                                <select name="Vehicle_Type1" id="Vehicle_Type1">
                                                    <option value="">-- Select --</option>
                                                    <option value="Electric Vehicles"
                                                        {{ $EHS->Vehicle_Type1 == 'Electric Vehicles' ? 'selected' : '' }}>
                                                        Electric Vehicles</option>
                                                    <option value="Hybrid Vehicles"
                                                        {{ $EHS->Vehicle_Type1 == 'Hybrid Vehicles' ? 'selected' : '' }}>
                                                        Hybrid Vehicles</option>
                                                    <option value="Fossil Fuel-Powered Vehicles"
                                                        {{ $EHS->Vehicle_Type1 == 'Fossil Fuel-Powered Vehicles' ? 'selected' : '' }}>
                                                        Fossil Fuel-Powered Vehicles</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Comments">Fleet Emissions</label>
                                                <div class="relative-container">
                                                    <input name="fleet_emissions" id="fleet_emissions"
                                                        value="{{ $EHS->fleet_emissions }}"></input>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Comments">Miles Traveled</label>
                                                <div class="relative-container">
                                                    <input name="miles_traveled" id="miles_traveled"
                                                        value="{{ $EHS->miles_traveled }}"></input>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Comments">Freight and Shipping</label>
                                                <div class="relative-container">
                                                    <textarea name="freight_and_shipping" id="freight_and_shipping">{{ $EHS->freight_and_shipping }}</textarea>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Comments">Carbon Offset Programs</label>
                                                <div class="relative-container">
                                                    <textarea name="carbon_pffset_programs" id="carbon_pffset_programs">{{ $EHS->carbon_pffset_programs }}</textarea>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="button-block">
                                        <button type="submit" class="saveButton">Save</button>
                                        <button type="button" class="backButton"
                                            onclick="previousStep()">Back</button>
                                        <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                        <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}"
                                                class="text-white">
                                                Exit </a> </button>
                                    </div>
                                </div>
                            </div>

                            <!-- ---- ------- -->

                            <div id="CCForm21" class="inner-block cctabcontent">
                                <div class="inner-block-content">
                                    <div class="row">

                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Comments">Land Area Impacted (m² or hectares)</label>
                                                <div class="relative-container">
                                                    <input name="land_area_impacted" id="land_area_impacted"
                                                        value="{{ $EHS->land_area_impacted }}"></input>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Comments">Protected Areas</label>
                                                <div class="relative-container">
                                                    <input name="protected_areas" id="protected_areas"
                                                        value="{{ $EHS->protected_areas }}"></input>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Comments">Deforestation</label>
                                                <div class="relative-container">
                                                    <input name="deforestation" id="deforestation"
                                                        value="{{ $EHS->deforestation }}"></input>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Comments">Habitat Preservation</label>
                                                <div class="relative-container">
                                                    <textarea name="habitat_preservation" id="habitat_preservation">{{ $EHS->habitat_preservation }}</textarea>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Comments">Biodiversity Initiatives</label>
                                                <div class="relative-container">
                                                    <textarea name="biodiversity_initiatives" id="biodiversity_initiatives">{{ $EHS->biodiversity_initiatives }}</textarea>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>


                                        <!-- <div class="col-lg-6">
                                                        <div class="group-input">
                                                            <label for="Impact">Vehicle Type</label>
                                                            <select name="water_source" id="water_source">
                                                                <option value="">-- Select --</option>
                                                                <option value="Electric Vehicles">Electric Vehicles</option>
                                                                <option value="Hybrid Vehicles">Hybrid Vehicles</option>
                                                                <option value="Fossil Fuel-Powered Vehicles">Fossil Fuel-Powered Vehicles</option>
                                                            </select>
                                                        </div>
                                                    </div> -->






                                    </div>
                                    <div class="button-block">
                                        <button type="submit" class="saveButton">Save</button>
                                        <button type="button" class="backButton"
                                            onclick="previousStep()">Back</button>
                                        <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                        <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}"
                                                class="text-white">
                                                Exit </a> </button>
                                    </div>
                                </div>
                            </div>

                            <!-- --- ------ -->

                            <div id="CCForm22" class="inner-block cctabcontent">
                                <div class="inner-block-content">
                                    <div class="row">

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Impact">Certifications</label>
                                                <select name="certifications" id="certifications">
                                                    <option value="">-- Select --</option>
                                                    <option value="ISO 14001"
                                                        {{ $EHS->certifications == 'ISO 14001' ? 'selected' : '' }}>ISO
                                                        14001</option>
                                                    <option value="LEED"
                                                        {{ $EHS->certifications == 'LEED' ? 'selected' : '' }}>LEED
                                                    </option>
                                                    <option value="Fair Trade"
                                                        {{ $EHS->certifications == 'Fair Trade' ? 'selected' : '' }}>Fair
                                                        Trade</option>
                                                    <option value="Other"
                                                        {{ $EHS->certifications == 'Other' ? 'selected' : '' }}>Other
                                                    </option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Comments">Regulatory Compliance</label>
                                                <div class="relative-container">
                                                    <textarea name="regulatory_compliance" id="regulatory_compliance">{{ $EHS->regulatory_compliance }}</textarea>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Comments">Audits</label>
                                                <div class="relative-container">
                                                    <input name="audits" id="audits"
                                                        value="{{ $EHS->audits }}"></input>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>



                                    </div>
                                    <div class="button-block">
                                        <button type="submit" class="saveButton">Save</button>
                                        <button type="button" class="backButton"
                                            onclick="previousStep()">Back</button>
                                        <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                        <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}"
                                                class="text-white">
                                                Exit </a> </button>
                                    </div>
                                </div>
                            </div>

                            <!-- ---- ----- -->

                            <div id="CCForm23" class="inner-block cctabcontent">
                                <div class="inner-block-content">
                                    <div class="row">

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Impact">Environmental Risk</label>
                                                <select name="enviromental_risk" id="enviromental_risk">
                                                    <option value="">-- Select --</option>
                                                    <option value="Pollution"
                                                        {{ $EHS->enviromental_risk == 'Pollution' ? 'selected' : '' }}>
                                                        Pollution</option>
                                                    <option value="Accidents"
                                                        {{ $EHS->enviromental_risk == 'Accidents' ? 'selected' : '' }}>
                                                        Accidents</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Comments">Impact Assessment</label>
                                                <div class="relative-container">
                                                    <textarea name="impact_assessment" id="impact_assessment">{{ $EHS->impact_assessment }}</textarea>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Impact">Climate Change Adaptation</label>
                                                <select name="climate_change_adaptation" id="climate_change_adaptation">
                                                    <option value="">-- Select --</option>
                                                    <option value="Flooding"
                                                        {{ $EHS->climate_change_adaptation == 'Flooding' ? 'selected' : '' }}>
                                                        Flooding</option>
                                                    <option value="Heatwaves"
                                                        {{ $EHS->climate_change_adaptation == 'Heatwaves' ? 'selected' : '' }}>
                                                        Heatwaves</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Comments">Carbon Footprint</label>
                                                <div class="relative-container">
                                                    <input name="carbon_footprint" id="carbon_footprint"
                                                        value="{{ $EHS->carbon_footprint }}"></input>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="button-block">
                                        <button type="submit" class="saveButton">Save</button>
                                        <button type="button" class="backButton"
                                            onclick="previousStep()">Back</button>
                                        <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                        <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}"
                                                class="text-white">
                                                Exit </a> </button>
                                    </div>
                                </div>
                            </div>
                            <!-- ----- ----- -->

                            <div id="CCForm24" class="inner-block cctabcontent">
                                <div class="inner-block-content">
                                    <div class="row">

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Impact">Risk Assessment Data</label>
                                                <select name="Risk_Assessment_Data" id="Risk_Assessment_Data">
                                                    <option value="">-- Select --</option>
                                                    <option value="Likelihood"
                                                        {{ $EHS->Risk_Assessment_Data == 'Likelihood' ? 'selected' : '' }}>
                                                        Likelihood</option>
                                                    <option value="Impact"
                                                        {{ $EHS->Risk_Assessment_Data == 'Impact' ? 'selected' : '' }}>
                                                        Impact</option>
                                                    <option value="Mitigation Measures"
                                                        {{ $EHS->Risk_Assessment_Data == 'Mitigation Measures' ? 'selected' : '' }}>
                                                        Mitigation Measures</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Impact">Hazard ID Reports </label>
                                                <select name="hazard_id_reports" id="hazard_id_reports">
                                                    <option value="">-- Select --</option>
                                                    <option value="Hazardous Operations"
                                                        {{ $EHS->hazard_id_reports == 'Hazardous Operations' ? 'selected' : '' }}>
                                                        Hazardous Operations</option>
                                                    <option value="Chemical Exposure"
                                                        {{ $EHS->hazard_id_reports == 'Chemical Exposure' ? 'selected' : '' }}>
                                                        Chemical Exposure</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-12 mb-4">
                                            <div class="group-input">
                                                <label for="agenda">
                                                    Failure Mode and Effect Analysis
                                                    <button type="button" name="agenda"
                                                        onclick="addRootRiskAssessment('risk-management')">+</button>
                                                    <span class="text-primary"
                                                        style="font-size: 0.8rem; font-weight: 400;">
                                                        (Launch Instruction)
                                                    </span>
                                                </label>
                                                <div class="table-responsive">
                                                    <table class="table table-bordered" style="width: 200%"
                                                        id="risk-management">
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
                                                            @if (!empty($EHS->risk_factor1))
                                                                @foreach (unserialize($EHS->risk_factor1) as $key => $riskFactor)
                                                                    <tr>
                                                                        <td>{{ $key + 1 }}</td>
                                                                        <td><input name="risk_factor1[]" type="text"
                                                                                value="{{ $riskFactor }}"
                                                                                {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>
                                                                        </td>
                                                                        <td><input name="risk_element1[]"type="text"
                                                                                value="{{ unserialize($EHS->risk_element1)[$key] ?? null }}"
                                                                                {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>
                                                                        </td>
                                                                        <td><input name="problem_cause1[]"
                                                                                type="text"
                                                                                value="{{ unserialize($EHS->problem_cause1)[$key] ?? null }}"
                                                                                {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>
                                                                        </td>
                                                                        <td><input name="existing_risk_control1[]"
                                                                                type="text"
                                                                                value="{{ unserialize($EHS->existing_risk_control1)[$key] ?? null }}"
                                                                                {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>
                                                                        </td>

                                                                        <td>
                                                                            <select
                                                                                onchange="calculateInitialResult(this)"
                                                                                class="fieldR"
                                                                                name="initial_severity1[]"
                                                                                {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>
                                                                                <option value="">-- Select --
                                                                                </option>
                                                                                <option value="1"
                                                                                    {{ (unserialize($EHS->initial_severity1)[$key] ?? null) == 1 ? 'selected' : '' }}>
                                                                                    1-Insignificant</option>
                                                                                <option value="2"
                                                                                    {{ (unserialize($EHS->initial_severity1)[$key] ?? null) == 2 ? 'selected' : '' }}>
                                                                                    2-Minor</option>
                                                                                <option value="3"
                                                                                    {{ (unserialize($EHS->initial_severity1)[$key] ?? null) == 3 ? 'selected' : '' }}>
                                                                                    3-Major</option>
                                                                                <option value="4"
                                                                                    {{ (unserialize($EHS->initial_severity1)[$key] ?? null) == 4 ? 'selected' : '' }}>
                                                                                    4-Critical</option>
                                                                                <option value="5"
                                                                                    {{ (unserialize($EHS->initial_severity1)[$key] ?? null) == 5 ? 'selected' : '' }}>
                                                                                    5-Catastrophic</option>
                                                                            </select>
                                                                        </td>
                                                                        <td>
                                                                            <select
                                                                                onchange="calculateInitialResult(this)"
                                                                                class="fieldP"
                                                                                name="initial_detectability1[]"
                                                                                {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>
                                                                                <option value="">-- Select --
                                                                                </option>
                                                                                <option value="1"
                                                                                    {{ (unserialize($EHS->initial_detectability1)[$key] ?? null) == 1 ? 'selected' : '' }}>
                                                                                    1-Very rare</option>
                                                                                <option value="2"
                                                                                    {{ (unserialize($EHS->initial_detectability1)[$key] ?? null) == 2 ? 'selected' : '' }}>
                                                                                    2-Unlikely</option>
                                                                                <option value="3"
                                                                                    {{ (unserialize($EHS->initial_detectability1)[$key] ?? null) == 3 ? 'selected' : '' }}>
                                                                                    3-Possibly</option>
                                                                                <option value="4"
                                                                                    {{ (unserialize($EHS->initial_detectability1)[$key] ?? null) == 4 ? 'selected' : '' }}>
                                                                                    4-Likely</option>
                                                                                <option value="5"
                                                                                    {{ (unserialize($EHS->initial_detectability1)[$key] ?? null) == 5 ? 'selected' : '' }}>
                                                                                    5-Almost certain (every time)</option>
                                                                            </select>
                                                                        </td>
                                                                        <td>
                                                                            <select
                                                                                onchange="calculateInitialResult(this)"
                                                                                class="fieldN"
                                                                                name="initial_probability1[]"
                                                                                {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>
                                                                                <option value="">-- Select --
                                                                                </option>
                                                                                <option value="1"
                                                                                    {{ (unserialize($EHS->initial_probability1)[$key] ?? null) == 1 ? 'selected' : '' }}>
                                                                                    1-Always detected</option>
                                                                                <option value="2"
                                                                                    {{ (unserialize($EHS->initial_probability1)[$key] ?? null) == 2 ? 'selected' : '' }}>
                                                                                    2-Likely to detect</option>
                                                                                <option value="3"
                                                                                    {{ (unserialize($EHS->initial_probability1)[$key] ?? null) == 3 ? 'selected' : '' }}>
                                                                                    3-Possible to detect</option>
                                                                                <option value="4"
                                                                                    {{ (unserialize($EHS->initial_probability1)[$key] ?? null) == 4 ? 'selected' : '' }}>
                                                                                    4-Unlikely to detect</option>
                                                                                <option value="5"
                                                                                    {{ (unserialize($EHS->initial_probability1)[$key] ?? null) == 5 ? 'selected' : '' }}>
                                                                                    5-Not detectable</option>
                                                                            </select>
                                                                        </td>
                                                                        <td><input name="initial_rpn1[]" type="text"
                                                                                class='initial-rpn'
                                                                                value="{{ unserialize($EHS->initial_rpn1)[$key] ?? null }}"
                                                                                readonly
                                                                                {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>
                                                                        </td>
                                                                        <td><input name="risk_control_measure1[]"
                                                                                type="text"
                                                                                value="{{ unserialize($EHS->risk_control_measure1)[$key] ?? null }}"
                                                                                {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>
                                                                        </td>
                                                                        <td>
                                                                            <select
                                                                                onchange="calculateResidualResult(this)"
                                                                                class="residual-fieldR"
                                                                                name="residual_severity1[]"
                                                                                {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>
                                                                                <option value="">-- Select --
                                                                                </option>
                                                                                <option value="1"
                                                                                    {{ (unserialize($EHS->residual_severity1)[$key] ?? null) == 1 ? 'selected' : '' }}>
                                                                                    1-Insignificant</option>
                                                                                <option value="2"
                                                                                    {{ (unserialize($EHS->residual_severity1)[$key] ?? null) == 2 ? 'selected' : '' }}>
                                                                                    2-Minor</option>
                                                                                <option value="3"
                                                                                    {{ (unserialize($EHS->residual_severity1)[$key] ?? null) == 3 ? 'selected' : '' }}>
                                                                                    3-Major</option>
                                                                                <option value="4"
                                                                                    {{ (unserialize($EHS->residual_severity1)[$key] ?? null) == 4 ? 'selected' : '' }}>
                                                                                    4-Critical</option>
                                                                                <option value="5"
                                                                                    {{ (unserialize($EHS->residual_severity1)[$key] ?? null) == 5 ? 'selected' : '' }}>
                                                                                    5-Catastrophic</option>
                                                                            </select>
                                                                        </td>
                                                                        <td>
                                                                            <select
                                                                                onchange="calculateResidualResult(this)"
                                                                                class="residual-fieldP"
                                                                                name="residual_probability1[]"
                                                                                {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>
                                                                                <option value="">-- Select --
                                                                                </option>
                                                                                <option value="1"
                                                                                    {{ (unserialize($EHS->residual_probability1)[$key] ?? null) == 1 ? 'selected' : '' }}>
                                                                                    1-Very rare</option>
                                                                                <option value="2"
                                                                                    {{ (unserialize($EHS->residual_probability1)[$key] ?? null) == 2 ? 'selected' : '' }}>
                                                                                    2-Unlikely</option>
                                                                                <option value="3"
                                                                                    {{ (unserialize($EHS->residual_probability1)[$key] ?? null) == 3 ? 'selected' : '' }}>
                                                                                    3-Possibly</option>
                                                                                <option value="4"
                                                                                    {{ (unserialize($EHS->residual_probability1)[$key] ?? null) == 4 ? 'selected' : '' }}>
                                                                                    4-Likely</option>
                                                                                <option value="5"
                                                                                    {{ (unserialize($EHS->residual_probability1)[$key] ?? null) == 5 ? 'selected' : '' }}>
                                                                                    5-Almost certain (every time)</option>
                                                                            </select>
                                                                        </td>
                                                                        <td>
                                                                            <select
                                                                                onchange="calculateResidualResult(this)"
                                                                                class="residual-fieldN"
                                                                                name="residual_detectability1[]"
                                                                                {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>
                                                                                <option value="">-- Select --
                                                                                </option>
                                                                                <option value="1"
                                                                                    {{ (unserialize($EHS->residual_detectability1)[$key] ?? null) == 1 ? 'selected' : '' }}>
                                                                                    1-Always detected</option>
                                                                                <option value="2"
                                                                                    {{ (unserialize($EHS->residual_detectability1)[$key] ?? null) == 2 ? 'selected' : '' }}>
                                                                                    2-Likely to detect</option>
                                                                                <option value="3"
                                                                                    {{ (unserialize($EHS->residual_detectability1)[$key] ?? null) == 3 ? 'selected' : '' }}>
                                                                                    3-Possible to detect</option>
                                                                                <option value="4"
                                                                                    {{ (unserialize($EHS->residual_detectability1)[$key] ?? null) == 4 ? 'selected' : '' }}>
                                                                                    4-Unlikely to detect</option>
                                                                                <option value="5"
                                                                                    {{ (unserialize($EHS->residual_detectability1)[$key] ?? null) == 5 ? 'selected' : '' }}>
                                                                                    5-Not detectable</option>
                                                                            </select>
                                                                        </td>
                                                                        <td><input name="residual_rpn1[]" type="text"
                                                                                class='residual-rpn'
                                                                                value="{{ unserialize($EHS->residual_rpn1)[$key] ?? null }}"
                                                                                readonly></td>
                                                                        <td>
                                                                            <input name="risk_acceptance1[]" readonly
                                                                                class="risk-acceptance"
                                                                                value="{{ unserialize($EHS->risk_acceptance1)[$key] ?? '' }}"
                                                                                readonly
                                                                                {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>
                                                                        </td>
                                                                        <td>
                                                                            <select name="risk_acceptance3[]"
                                                                                {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>
                                                                                <option value="">-- Select --
                                                                                </option>
                                                                                <option value="N"
                                                                                    {{ (unserialize($EHS->risk_acceptance3)[$key] ?? null) == 'N' ? 'selected' : '' }}>
                                                                                    N</option>
                                                                                <option value="Y"
                                                                                    {{ (unserialize($EHS->risk_acceptance3)[$key] ?? null) == 'Y' ? 'selected' : '' }}>
                                                                                    Y</option>
                                                                            </select>
                                                                        </td>
                                                                        <td><input name="mitigation_proposal1[]"
                                                                                type="text"
                                                                                value="{{ unserialize($EHS->mitigation_proposal1)[$key] ?? null }}"
                                                                                {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>
                                                                        </td>
                                                                        <td> <button class="btn btn-dark removeRowBtn"
                                                                                {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>Remove</button>
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
                                                <label for="Comments">Risk Mitigation Plan</label>
                                                <div class="relative-container">
                                                    <textarea name="risk_migration_plan" id="risk_migration_plan">{{ $EHS->risk_migration_plan }}</textarea>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Comments">Corrective Actions</label>
                                                <div class="relative-container">
                                                    <textarea name="corrective_action" id="corrective_action">{{ $EHS->corrective_action }}</textarea>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>




                                    </div>
                                    <div class="button-block">
                                        <button type="submit" class="saveButton">Save</button>
                                        <button type="button" class="backButton"
                                            onclick="previousStep()">Back</button>
                                        <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                        <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}"
                                                class="text-white">
                                                Exit </a> </button>
                                    </div>
                                </div>
                            </div>

                            <!-- --- ---------- -->

                            <div id="CCForm25" class="inner-block cctabcontent">
                                <div class="inner-block-content">
                                    <div class="row">

                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Comments">Audit ID</label>
                                                <div class="relative-container">
                                                    <input name="audit_id" id="audit_id"
                                                        value="{{ $EHS->audit_id }}"></input>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Impact">Audit Type</label>
                                                <select name="Audit_Type" id="Audit_Type">
                                                    <option value="">-- Select --</option>
                                                    <option value="Internal"
                                                        {{ $EHS->Audit_Type == 'Internal' ? 'selected' : '' }}>Internal
                                                    </option>
                                                    <option value="External"
                                                        {{ $EHS->Audit_Type == 'External' ? 'selected' : '' }}>External
                                                    </option>
                                                    <option value="Regulatory"
                                                        {{ $EHS->Audit_Type == 'Regulatory' ? 'selected' : '' }}>
                                                        Regulatory</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 new-date-data-field">
                                            <div class="group-input input-date">
                                                <label for="Warranty Expiration Date">Audit Date</label>
                                                <div class="calenderauditee">
                                                    <input type="text" id="audit_date" readonly
                                                        placeholder="DD-MMM-YYYY"
                                                        value="{{ Helpers::getdateFormat($EHS->audit_date) }}" />
                                                    <input type="date" id="audit_date_checkdate" name="audit_date"
                                                        value="{{ Helpers::getdateFormat($EHS->audit_date) }}"
                                                        max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                                        class="hide-input"
                                                        oninput="handleDateInput(this, 'audit_date');checkDate('audit_date_checkdate','warranty_expiration_date_checkdate')" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Impact">Audit Scope</label>
                                                <select name="audit_scope" id="audit_scope">
                                                    <option value="">-- Select --</option>
                                                    <option value="Departments"
                                                        {{ $EHS->audit_scope == 'Departments' ? 'selected' : '' }}>
                                                        Departments</option>
                                                    <option value="Facilities"
                                                        {{ $EHS->audit_scope == 'Facilities' ? 'selected' : '' }}>
                                                        Facilities</option>
                                                    <option value="Processes"
                                                        {{ $EHS->audit_scope == 'Processes' ? 'selected' : '' }}>
                                                        Processes</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Comments">Findings and Observations</label>
                                                <div class="relative-container">
                                                    <textarea name="finding_and_observation" id="finding_and_observation">{{ $EHS->finding_and_observation }}</textarea>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Comments">Corrective Action Plans</label>
                                                <div class="relative-container">
                                                    <textarea name="corrective_action_plans" id="corrective_action_plans">{{ $EHS->corrective_action_plans }}</textarea>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Comments">Follow-up Audit Results</label>
                                                <div class="relative-container">
                                                    <textarea name="follow_up_audit_result" id="follow_up_audit_result">{{ $EHS->follow_up_audit_result }}</textarea>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>



                                    </div>
                                    <div class="button-block">
                                        <button type="submit" class="saveButton">Save</button>
                                        <button type="button" class="backButton"
                                            onclick="previousStep()">Back</button>
                                        <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                        <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}"
                                                class="text-white">
                                                Exit </a> </button>
                                    </div>
                                </div>
                            </div>
                            <!-- ----  -------- -->

                            <div id="CCForm26" class="inner-block cctabcontent">
                                <div class="inner-block-content">
                                    <div class="row">

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Impact">Sustainability Initiatives</label>
                                                <select name="sustainability_initiatives"
                                                    id="sustainability_initiatives">
                                                    <option value="">-- Select --</option>
                                                    <option value="Waste Reduction"
                                                        {{ $EHS->sustainability_initiatives == 'Waste Reduction' ? 'selected' : '' }}>
                                                        Waste Reduction</option>
                                                    <option value="Energy Savings"
                                                        {{ $EHS->sustainability_initiatives == 'Energy Savings' ? 'selected' : '' }}>
                                                        Energy Savings</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Impact">CSR Activities </label>
                                                <select name="csr_activities" id="csr_activities">
                                                    <option value="">-- Select --</option>
                                                    <option value="Employee Engagement"
                                                        {{ $EHS->csr_activities == 'Employee Engagement' ? 'selected' : '' }}>
                                                        Employee Engagement</option>
                                                    <option value="Environmental Programs"
                                                        {{ $EHS->csr_activities == 'Environmental Programs' ? 'selected' : '' }}>
                                                        Environmental Programs</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Comments">Sustainability Reporting</label>
                                                <div class="relative-container">
                                                    <textarea name="sustainability_reporting" id="sustainability_reporting">{{ $EHS->sustainability_reporting }}</textarea>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Comments">Public Relations/Community Engagement
                                                    Reports</label>
                                                <textarea name="public_relation_report" id="public_relation_report">{{ $EHS->public_relation_report }}</textarea>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="button-block">
                                        <button type="submit" class="saveButton">Save</button>
                                        <button type="button" class="backButton"
                                            onclick="previousStep()">Back</button>
                                        <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                        <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}"
                                                class="text-white">
                                                Exit </a> </button>
                                    </div>
                                </div>
                            </div>
                            <!-- ---- ----- -->

                            <div id="CCForm27" class="inner-block cctabcontent">
                                <div class="inner-block-content">
                                    <div class="row">

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Impact">Dashboards </label>
                                                <select name="Dashboards" id="Dashboards">
                                                    <option value="">-- Select --</option>
                                                    <option value="Incidents">Incidents</option>
                                                    <option value="Compliance Status"
                                                        {{ $EHS->Dashboards == 'Compliance Status' ? 'selected' : '' }}>
                                                        Compliance Status</option>
                                                    <option value="Safety Performance"
                                                        {{ $EHS->Dashboards == 'Safety Performance' ? 'selected' : '' }}>
                                                        Safety Performance</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Impact">Key Performance Indicators (KPIs)</label>
                                                <select name="key_performance_indicators"
                                                    id="key_performance_indicators">
                                                    <option value="">-- Select --</option>
                                                    <option value="Incident Rate"
                                                        {{ $EHS->key_performance_indicators == 'Incident Rate' ? 'selected' : '' }}>
                                                        Incident Rate</option>
                                                    <option value="PPE Compliance Rate"
                                                        {{ $EHS->key_performance_indicators == 'PPE Compliance Rate' ? 'selected' : '' }}>
                                                        PPE Compliance Rate</option>
                                                    <option value="Training Completion Rate"
                                                        {{ $EHS->key_performance_indicators == 'Training Completion Rate' ? 'selected' : '' }}>
                                                        Training Completion Rate</option>
                                                </select>
                                            </div>
                                        </div>


                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Impact">Trend Analysis</label>
                                                <select name="trend_analysis" id="trend_analysis">
                                                    <option value="">-- Select --</option>
                                                    <option value="Safety"
                                                        {{ $EHS->trend_analysis == 'Safety' ? 'selected' : '' }}>Safety
                                                    </option>
                                                    <option value="Incidents"
                                                        {{ $EHS->trend_analysis == 'Incidents' ? 'selected' : '' }}>
                                                        Incidents</option>
                                                    <option value="Environmental Impact"
                                                        {{ $EHS->trend_analysis == 'Environmental Impact' ? 'selected' : '' }}>
                                                        Environmental Impact</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Impact">Data Export Functionality</label>
                                                <select name="data_export_functionality" id="data_export_functionality">
                                                    <option value="">-- Select --</option>
                                                    <option value="PDF"
                                                        {{ $EHS->data_export_functionality == 'PDF' ? 'selected' : '' }}>
                                                        PDF </option>
                                                    <option value="Excel"
                                                        {{ $EHS->data_export_functionality == 'Excel' ? 'selected' : '' }}>
                                                        Excel</option>
                                                    <option value="CSV"
                                                        {{ $EHS->data_export_functionality == 'CSV' ? 'selected' : '' }}>
                                                        CSV</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Comments">Monthly/Quarterly/Annual Reports</label>
                                                <div class="relative-container">
                                                    <textarea name="monthly_annual_reports" id="monthly_annual_reports">{{ $EHS->monthly_annual_reports }}</textarea>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="button-block">
                                        <button type="submit" class="saveButton">Save</button>
                                        <button type="button" class="backButton"
                                            onclick="previousStep()">Back</button>
                                        <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                        <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}"
                                                class="text-white">
                                                Exit </a> </button>
                                    </div>
                                </div>
                            </div>
                            <!-- ---- ----- -->

                            <div id="CCForm28" class="inner-block cctabcontent">
                                <div class="inner-block-content">
                                    <div class="row">

                                        <div class="col-lg-12">
                                            <div class="group-input">
                                                <label for="Impact">KPIs (Key Performance Indicators)</label>
                                                <select name="KPIs" id="KPIs">
                                                    <option value="">-- Select --</option>
                                                    <option value="Energy Savings"
                                                        {{ $EHS->KPIs == 'Energy Savings' ? 'selected' : '' }}>Energy
                                                        Savings</option>
                                                    <option value="Emission Reductions"
                                                        {{ $EHS->KPIs == 'Emission Reductions' ? 'selected' : '' }}>
                                                        Emission Reductions</option>
                                                    <option value="Water Conservation"
                                                        {{ $EHS->KPIs == 'Water Conservation' ? 'selected' : '' }}>Water
                                                        Conservation</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Comments">Sustainability Targets</label>
                                                <div class="relative-container">
                                                    <textarea name="sustainability_targets" id="sustainability_targets">{{ $EHS->sustainability_targets }}</textarea>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Comments">Progress Towards Goals</label>
                                                <div class="relative-container">
                                                    <textarea name="progress_towards_goals" id="progress_towards_goals">{{ $EHS->progress_towards_goals }}</textarea>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Goal Name">Goal Name</label>
                                                <div class="relative-container">
                                                    <textarea name="Goal_Name" id="Goal_Name">{{ $EHS->Goal_Name }}</textarea>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Goal Description">Goal Description</label>
                                                <div class="relative-container">
                                                    <textarea name="Goal_Description" id="Goal_Description">{{ $EHS->Goal_Description }}</textarea>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Responsible Department">Responsible Department</label>
                                                <select name="Responsible_Department" id="Responsible_Department">
                                                    <option value="">-- Select --</option>
                                                    <option value="Operations"
                                                        {{ $EHS->Responsible_Department == 'Operations' ? 'selected' : '' }}>
                                                        Operations</option>
                                                    <option value="R&D"
                                                        {{ $EHS->Responsible_Department == 'R&D' ? 'selected' : '' }}>R&D
                                                    </option>
                                                    <option value="Compliance"
                                                        {{ $EHS->Responsible_Department == 'Compliance' ? 'selected' : '' }}>
                                                        Compliance</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 new-date-data-field">
                                            <div class="group-input input-date">
                                                <label for="Goal Timeframe">Goal Timeframe</label>
                                                <div class="calenderauditee">
                                                    <input type="text" id="Goal_Timeframe" readonly
                                                        placeholder="DD-MMM-YYYY"
                                                        value="{{ Helpers::getdateFormat($EHS->Goal_Timeframe) }}"
                                                        {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }} />
                                                    <input type="date" id="Goal_Timeframe_checkdate"
                                                        name="Goal_Timeframe"
                                                        {{ $EHS->stage == 0 || $EHS->stage == 8 ? 'disabled' : '' }}
                                                        value="{{ $EHS->Goal_Timeframe }}" class="hide-input"
                                                        oninput="handleDateInput(this, 'Goal_Timeframe');checkDate('Goal_Timeframe_checkdate','Goal_Timeframe1_checkdate')" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="group-input">
                                                <label for="Region">Region</label>
                                                <select name="Region" id="Region">
                                                    <option value="">-- Select --</option>
                                                    <option value="Global"
                                                        {{ $EHS->Region == 'Global' ? 'selected' : '' }}>Global</option>
                                                    <option value="North America"
                                                        {{ $EHS->Region == 'North America' ? 'selected' : '' }}>North
                                                        America</option>
                                                    <option value="Europe"
                                                        {{ $EHS->Region == 'Europe' ? 'selected' : '' }}>Europe</option>
                                                    <option value="Asia-Pacific"
                                                        {{ $EHS->Region == 'Asia-Pacific' ? 'selected' : '' }}>
                                                        Asia-Pacific</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="sub-head">
                                            Energy Use
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Energy Source">Energy Source</label>
                                                <select name="Energy_Source" id="Energy_Source">
                                                    <option value="">-- Select --</option>
                                                    <option value="Renewable (e.g., Solar, Wind, Hydro)"
                                                        {{ $EHS->Energy_Source == 'Renewable (e.g., Solar, Wind, Hydro)' ? 'selected' : '' }}>
                                                        Renewable (e.g., Solar, Wind, Hydro)</option>
                                                    <option value="Non-Renewable (e.g., Coal, Oil, Gas)"
                                                        {{ $EHS->Energy_Source == 'Non-Renewable (e.g., Coal, Oil, Gas)' ? 'selected' : '' }}>
                                                        Non-Renewable (e.g., Coal, Oil, Gas)</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Energy Consumption (MWh)">Energy Consumption (MWh)</label>
                                                <input type="number" name="Energy_Consumption2"
                                                    value="{{ $EHS->Energy_Consumption2 }}">
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Energy Efficiency Target (%)">Energy Efficiency Target
                                                    (%)</label>
                                                <input type="number" name="Energy_Efficiency_Target"
                                                    value="{{ $EHS->Energy_Efficiency_Target }}">
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Renewable Energy Usage Target (%)">Renewable Energy Usage
                                                    Target (%)</label>
                                                <input type="number" name="Renewable_Energy_Usage_Target"
                                                    value="{{ $EHS->Renewable_Energy_Usage_Target }}">
                                            </div>
                                        </div>

                                        <div class="sub-head">
                                            Carbon Emissions
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Emission Source">Emission Source</label>
                                                <select name="Emission_Source" id="Emission_Source">
                                                    <option value="">-- Select --</option>
                                                    <option value="Scope 1 (Direct Emissions)"
                                                        {{ $EHS->Emission_Source == 'Scope 1 (Direct Emissions)' ? 'selected' : '' }}>
                                                        Scope 1 (Direct Emissions)</option>
                                                    <option value="Scope 2 (Indirect Emissions)"
                                                        {{ $EHS->Emission_Source == 'Scope 2 (Indirect Emissions)' ? 'selected' : '' }}>
                                                        Scope 2 (Indirect Emissions)</option>
                                                    <option value="Scope 3 (Supply Chain Emissions)"
                                                        {{ $EHS->Emission_Source == 'Scope 3 (Supply Chain Emissions)' ? 'selected' : '' }}>
                                                        Scope 3 (Supply Chain Emissions)</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Carbon Footprint (Metric Tons CO2e)">Carbon Footprint (Metric
                                                    Tons CO2e)</label>
                                                <input type="number" name="Carbon_Footprint2"
                                                    value="{{ $EHS->Carbon_Footprint2 }}">
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Reduction Target (%)">Reduction Target (%)</label>
                                                <input type="number" name="Reduction_Target"
                                                    value="{{ $EHS->Reduction_Target }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Offset Mechanisms">Offset Mechanisms</label>
                                                <select name="Offset_Mechanisms" id="Offset_Mechanisms">
                                                    <option value="">-- Select --</option>
                                                    <option value="Reforestation"
                                                        {{ $EHS->Offset_Mechanisms == 'Reforestation' ? 'selected' : '' }}>
                                                        Reforestation</option>
                                                    <option value="Carbon Credits"
                                                        {{ $EHS->Offset_Mechanisms == 'Carbon Credits' ? 'selected' : '' }}>
                                                        Carbon Credits</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="sub-head">
                                            Water Conservation
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Water Source">Water Source</label>
                                                <select name="Water_Source2" id="Water_Source2">
                                                    <option value="">-- Select --</option>
                                                    <option value="Groundwater"
                                                        {{ $EHS->Water_Source2 == 'Groundwater' ? 'selected' : '' }}>
                                                        Groundwater</option>
                                                    <option value="Surface Water"
                                                        {{ $EHS->Water_Source2 == 'Surface Water' ? 'selected' : '' }}>
                                                        Surface Water</option>
                                                    <option value="Recycled Water"
                                                        {{ $EHS->Water_Source2 == 'Recycled Water' ? 'selected' : '' }}>
                                                        Recycled Water</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Water Consumption (m³)">Water Consumption (m³)</label>
                                                <input type="number" name="Water_Consumption2"
                                                    value="{{ $EHS->Water_Consumption2 }}">
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Water Efficiency Target (%)">Water Efficiency Target
                                                    (%)</label>
                                                <input type="number" name="Water_Efficiency_Target"
                                                    value="{{ $EHS->Water_Efficiency_Target }}">
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Recycled Water Usage Target (%)">Recycled Water Usage Target
                                                    (%)</label>
                                                <input type="number" name="Recycled_Water_Usage_Target"
                                                    value="{{ $EHS->Recycled_Water_Usage_Target }}">
                                            </div>
                                        </div>

                                        <div class="sub-head">
                                            Waste Management
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Waste Type">Waste Type</label>
                                                <select name="Waste_Type" id="Waste_Type">
                                                    <option value="">-- Select --</option>
                                                    <option value="Hazardous"
                                                        {{ $EHS->Waste_Type == 'Hazardous' ? 'selected' : '' }}>Hazardous
                                                    </option>
                                                    <option value="Non-Hazardous"
                                                        {{ $EHS->Waste_Type == 'Non-Hazardous' ? 'selected' : '' }}>
                                                        Non-Hazardous</option>
                                                    <option value="E-Waste"
                                                        {{ $EHS->Waste_Type == 'E-Waste' ? 'selected' : '' }}>E-Waste
                                                    </option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Waste Quantity (kg)">Waste Quantity (kg)</label>
                                                <input type="number" name="Waste_Quantity"
                                                    value="{{ $EHS->Waste_Quantity }}">
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Recycling Rate Target (%)">Recycling Rate Target (%)</label>
                                                <input type="number" name="Recycling_Rate_Target"
                                                    value="{{ $EHS->Recycling_Rate_Target }}">
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Disposal Methods">Disposal Methods</label>
                                                <select name="Disposal_Methods" id="Disposal_Methods">
                                                    <option value="">-- Select --</option>
                                                    <option value="Landfill"
                                                        {{ $EHS->Disposal_Methods == 'Landfill' ? 'selected' : '' }}>
                                                        Landfill</option>
                                                    <option value="Recycling"
                                                        {{ $EHS->Disposal_Methods == 'Recycling' ? 'selected' : '' }}>
                                                        Recycling</option>
                                                    <option value="Composting"
                                                        {{ $EHS->Disposal_Methods == 'Composting' ? 'selected' : '' }}>
                                                        Composting</option>
                                                    <option value="Incineration"
                                                        {{ $EHS->Disposal_Methods == 'Incineration' ? 'selected' : '' }}>
                                                        Incineration</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="sub-head">
                                            Biodiversity
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Protected Areas Covered (ha)">Protected Areas Covered
                                                    (ha)</label>
                                                <input type="number" name="Protected_Areas_Covered"
                                                    value="{{ $EHS->Protected_Areas_Covered }}">
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Species Monitored">Species Monitored</label>
                                                <div class="relative-container">
                                                    <input type="text" name="Species_Monitored"
                                                        value="{{ $EHS->Species_Monitored }}">
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Habitat Restoration Target (ha)">Habitat Restoration Target
                                                    (ha)</label>
                                                <input type="number" name="Habitat_Restoration_Target"
                                                    value="{{ $EHS->Habitat_Restoration_Target }}">
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Biodiversity Index Score">Biodiversity Index Score</label>
                                                <input type="number" name="Biodiversity_Index_Score"
                                                    value="{{ $EHS->Biodiversity_Index_Score }}">
                                            </div>
                                        </div>

                                        <div class="sub-head">
                                            Sustainable Procurement
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="group-input">
                                                <label for="Supplier Compliance">Supplier Compliance</label>
                                                <select name="Supplier_Compliance" id="Supplier_Compliance">
                                                    <option value="">-- Select --</option>
                                                    <option value="ISO 14001 Certified"
                                                        {{ $EHS->Supplier_Compliance == 'ISO 14001 Certified' ? 'selected' : '' }}>
                                                        ISO 14001 Certified</option>
                                                    <option value="No Certification"
                                                        {{ $EHS->Supplier_Compliance == 'No Certification' ? 'selected' : '' }}>
                                                        No Certification</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Percentage of Sustainable Products (%)">Percentage of
                                                    Sustainable Products (%)</label>
                                                <input type="number" name="Percentage_of_Sustainable_Products"
                                                    value="{{ $EHS->Percentage_of_Sustainable_Products }}">
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Local Sourcing Target (%)">Local Sourcing Target (%)</label>
                                                <div class="relative-container">
                                                    <input type="text" name="Local_Sourcing_Target"
                                                        value="{{ $EHS->Local_Sourcing_Target }}">
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>

                                        <div class="sub-head">
                                            Circular Economy Metrics
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Product Life Extension Target (%)">Product Life Extension
                                                    Target (%)</label>
                                                <input type="number" name="Product_Life_Extension_Target"
                                                    value="{{ $EHS->Product_Life_Extension_Target }}">
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Material Reusability (%)">Material Reusability (%)</label>
                                                <input type="number" name="Material_Reusability"
                                                    value="{{ $EHS->Material_Reusability }}">
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="group-input">
                                                <label for="Recycled Material Usage (%)">Recycled Material Usage
                                                    (%)</label>
                                                <input type="number" name="Recycled_Material_Usage"
                                                    value="{{ $EHS->Recycled_Material_Usage }}">
                                            </div>
                                        </div>

                                        <div class="sub-head">
                                            Policy Alignment
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="SDG Alignment">SDG Alignment</label>
                                                <select name="SDG_Alignment" id="SDG_Alignment">
                                                    <option value="">-- Select --</option>
                                                    <option value="SDG 6: Clean Water and Sanitation"
                                                        {{ $EHS->SDG_Alignment == 'SDG 6: Clean Water and Sanitation' ? 'selected' : '' }}>
                                                        SDG 6: Clean Water and Sanitation</option>
                                                    <option value="SDG 7: Affordable and Clean Energy"
                                                        {{ $EHS->SDG_Alignment == 'SDG 7: Affordable and Clean Energy' ? 'selected' : '' }}>
                                                        SDG 7: Affordable and Clean Energy</option>
                                                    <option value="SDG 12: Responsible Consumption and Production"
                                                        {{ $EHS->SDG_Alignment == 'SDG 12: Responsible Consumption and Production' ? 'selected' : '' }}>
                                                        SDG 12: Responsible Consumption and Production</option>
                                                    <option value="SDG 13: Climate Action"
                                                        {{ $EHS->SDG_Alignment == 'SDG 13: Climate Action' ? 'selected' : '' }}>
                                                        SDG 13: Climate Action</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Compliance Status">Compliance Status</label>
                                                <select name="Compliance_Status" id="Compliance_Status">
                                                    <option value="">-- Select --</option>
                                                    <option value="Compliant"
                                                        {{ $EHS->Compliance_Status == 'Compliant' ? 'selected' : '' }}>
                                                        Compliant</option>
                                                    <option value="Partially Compliant"
                                                        {{ $EHS->Compliance_Status == 'Partially Compliant' ? 'selected' : '' }}>
                                                        Partially Compliant</option>
                                                    <option value="Non-Compliant"
                                                        {{ $EHS->Compliance_Status == 'Non-Compliant' ? 'selected' : '' }}>
                                                        Non-Compliant</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="sub-head">
                                            Reporting and Monitoring
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Progress Measurement Frequency">Progress Measurement
                                                    Frequency</label>
                                                <select name="Progress_Measurement_Frequency"
                                                    id="Progress_Measurement_Frequency">
                                                    <option value="">-- Select --</option>
                                                    <option value="Monthly"
                                                        {{ $EHS->Progress_Measurement_Frequency == 'Monthly' ? 'selected' : '' }}>
                                                        Monthly</option>
                                                    <option value="Quarterly"
                                                        {{ $EHS->Progress_Measurement_Frequency == 'Quarterly' ? 'selected' : '' }}>
                                                        Quarterly</option>
                                                    <option value="Annually"
                                                        {{ $EHS->Progress_Measurement_Frequency == 'Annually' ? 'selected' : '' }}>
                                                        Annually</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Recycled Material Usage (%)">Recycled Material Usage
                                                    (%)</label>
                                                <div class="relative-container">
                                                    <input type="text" name="Recycled_Material_Usage1"
                                                        value="{{ $EHS->Recycled_Material_Usage1 }}">
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="group-input">
                                                <label for="Current Progress (%)">Current Progress (%)</label>
                                                <input type="number" name="Current_Progress"
                                                    value="{{ $EHS->Biodiversity_Index_Score }}">
                                            </div>
                                        </div>

                                    </div>
                                    <div class="button-block">
                                        <button type="submit" class="saveButton">Save</button>
                                        <button type="button" class="backButton"
                                            onclick="previousStep()">Back</button>
                                        <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                        <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}"
                                                class="text-white">
                                                Exit </a> </button>
                                    </div>
                                </div>
                            </div>
                            <!-- ---- ------ -->

                            <div id="CCForm29" class="inner-block cctabcontent">
                                <div class="inner-block-content">
                                    <div class="row">

                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Comments">Training Programs</label>
                                                <div class="relative-container">
                                                    <input name="training_programs" id="training_programs"
                                                        value="{{ $EHS->training_programs }}"></input>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Comments">Employee Involvement</label>
                                                <div class="relative-container">
                                                    <input name="employee_involcement" id="employee_involcement"
                                                        value="{{ $EHS->employee_involcement }}"></input>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Comments">Sustainability Awareness</label>
                                                <div class="relative-container">
                                                    <textarea name="sustainability_awareness" id="sustainability_awareness">{{ $EHS->sustainability_awareness }}</textarea>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="button-block">
                                        <button type="submit" class="saveButton">Save</button>
                                        <button type="button" class="backButton"
                                            onclick="previousStep()">Back</button>
                                        <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                        <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}"
                                                class="text-white">
                                                Exit </a> </button>
                                    </div>
                                </div>
                            </div>
                            <!-- ----- ------- -->

                            <div id="CCForm30" class="inner-block cctabcontent">
                                <div class="inner-block-content">
                                    <div class="row">


                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Impact">Community Projects</label>
                                                <select name="community_project" id="community_project">
                                                    <option value="">-- Select --</option>
                                                    <option value="Tree Planting"
                                                        {{ $EHS->community_project == 'Tree Planting' ? 'selected' : '' }}>
                                                        Tree Planting</option>
                                                    <option value="Water Conservation"
                                                        {{ $EHS->community_project == 'Water Conservation' ? 'selected' : '' }}>
                                                        Water Conservation</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Impact">Partnerships</label>
                                                <select name="Partnerships" id="Partnerships">
                                                    <option value="">-- Select --</option>
                                                    <option value="Collaboration With NGOs"
                                                        {{ $EHS->Partnerships == 'Collaboration With NGOs' ? 'selected' : '' }}>
                                                        Collaboration With NGOs</option>
                                                    <option value="Government Bodies"
                                                        {{ $EHS->Partnerships == 'Government Bodies' ? 'selected' : '' }}>
                                                        Government Bodies</option>
                                                    <option value="Other Organizations"
                                                        {{ $EHS->Partnerships == 'Other Organizations' ? 'selected' : '' }}>
                                                        Other Organizations</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Impact">Social Impact</label>
                                                <select name="social_impact" id="social_impact">
                                                    <option value="">-- Select --</option>
                                                    <option value="Social Equity"
                                                        {{ $EHS->social_impact == 'Social Equity' ? 'selected' : '' }}>
                                                        Social Equity</option>
                                                    <option value="Diversity"
                                                        {{ $EHS->social_impact == 'Diversity' ? 'selected' : '' }}>
                                                        Diversity</option>
                                                    <option value="Local Development"
                                                        {{ $EHS->social_impact == 'Local Development' ? 'selected' : '' }}>
                                                        Local Development</option>
                                                </select>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="button-block">
                                        <button type="submit" class="saveButton">Save</button>
                                        <button type="button" class="backButton"
                                            onclick="previousStep()">Back</button>
                                        <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                        <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}"
                                                class="text-white">
                                                Exit </a> </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Activity Log content -->
                            <div id="CCForm31" class="inner-block cctabcontent">
                                <div class="inner-block-content">
                                    <div class="sub-head">Activity Log</div>

                                    <div class="d-flex align-item-end justify-content-end">
                                        <a class="text-white" href="{{ url('EHSActivityLog', $data->id) }}">
                                            <button type="button" class="button_theme1" style="margin-bottom: 20px;">
                                                Print
                                            </button>
                                        </a>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Submit By">Submit By</label>
                                                <div class="static">{{ $EHS->Submit_By }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Submit On">Submit On</label>
                                                <div class="static">{{ $EHS->Submit_On }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Submit Comment">Submit Comment</label>
                                                <div class="static">{{ $EHS->Submit_Comment }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Cancel By">Cancel By</label>
                                                <div class="static">{{ $EHS->Cancelled_By }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Cancel On">Cancel On</label>
                                                <div class="static">{{ $EHS->Cancelled_On }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Cancel Comment">Cancel Comment</label>
                                                <div class="static">{{ $EHS->Cancelled_Comment }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Review Complete By">Review Complete By</label>
                                                <div class="static">{{ $EHS->Review_Complete_By }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Review Complete On">Review Complete On</label>
                                                <div class="static">{{ $EHS->Review_Complete_On }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Review Complete Comment">Review Complete Comment</label>
                                                <div class="static"> {{ $EHS->Review_Complete_Comment }}</div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="More Information Required By">More Information Required
                                                    By</label>
                                                <div class="static">{{ $EHS->More_Info_Required_By }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="More Information Required On">More Information Required
                                                    On</label>
                                                <div class="static">{{ $EHS->more_info_required_on }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="More Information Required Comment">More Information Required
                                                    Comment</label>
                                                <div class="static">{{ $EHS->More_Info_Required_Comment }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Cancel By">Cancel By</label>
                                                <div class="static">{{ $EHS->Cancel_By }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Cancel On">Cancel On</label>
                                                <div class="static">{{ $EHS->Cancel_On }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Cancel Comment">Cancel Comment</label>
                                                <div class="static">{{ $EHS->Cancel_Comment }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Complete Investigation By">Complete Investigation By</label>
                                                <div class="static">{{ $EHS->Complete_Investigation_By }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Complete Investigation On">Complete Investigation On</label>
                                                <div class="static">{{ $EHS->Complete_Investigation_On }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Complete Investigation Comment">Complete Investigation
                                                    Comment</label>
                                                <div class="static">{{ $EHS->Complete_Investigation_Comment }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="More Investigation Required By">More Investigation Required
                                                    By</label>
                                                <div class="static">{{ $EHS->More_Investigation_Req_By }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="More Investigation Required On">More Investigation Required
                                                    On</label>
                                                <div class="static">{{ $EHS->More_Investigation_Req_On }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="More Investigation Required Comment">More Investigation
                                                    Required Comment</label>
                                                <div class="static">{{ $EHS->More_Investigation_Req_Comment }}</div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Analysis Complete By">Analysis Complete By</label>
                                                <div class="static">{{ $EHS->Analysis_Complete_By }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Analysis Complete On">Analysis Complete On</label>
                                                <div class="static">{{ $EHS->Analysis_Complete_On }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Analysis Complete Comment">Analysis Complete Comment</label>
                                                <div class="static">{{ $EHS->Analysis_Complete_Comment }}</div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Training Required By">Training Required By</label>
                                                <div class="static">{{ $EHS->Training_required_by }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Training Required On">Training Required On</label>
                                                <div class="static">{{ $EHS->Training_required_on }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Training Required Comment">Training Required Comment</label>
                                                <div class="static">{{ $EHS->Training_required_comment }}</div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Training Complete By">Training Complete By</label>
                                                <div class="static">{{ $EHS->Training_complete_by }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Training Complete On">Training Complete On</label>
                                                <div class="static">{{ $EHS->Training_complete_on }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Training Complete Comment">Training Complete Comment</label>
                                                <div class="static">{{ $EHS->Training_complete_comment }}</div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Propose Plan By">Propose Plan By</label>
                                                <div class="static">{{ $EHS->Propose_Plan_By }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Propose Plan On">Propose Plan On</label>
                                                <div class="static">{{ $EHS->Propose_Plan_On }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Propose Plan Comment">Propose Plan Comment</label>
                                                <div class="static">{{ $EHS->Propose_Plan_Comment }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Reject By">Reject By</label>
                                                <div class="static">{{ $EHS->Reject_By }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Reject On">Reject On</label>
                                                <div class="static">{{ $EHS->Reject_On }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Reject Comment">Reject Comment</label>
                                                <div class="static">{{ $EHS->Reject_Comment }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Approve Plan By">Approve Plan By</label>
                                                <div class="static">{{ $EHS->Approve_Plan_By }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Approve Plan On">Approve Plan On</label>
                                                <div class="static">{{ $EHS->Approve_Plan_On }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Approve Plan Comment">Approve Plan Comment</label>
                                                <div class="static">{{ $EHS->Approve_Plan_Comment }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="More Information Required By">More Information Required
                                                    By</label>
                                                <div class="static">{{ $EHS->More_Infomation_By }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="More Information Required On">More Information Required
                                                    On</label>
                                                <div class="static">{{ $EHS->More_Infomation_On }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="More Information Required Comment">More Information Required
                                                    Comment</label>
                                                <div class="static">{{ $EHS->More_Infomation_Comment }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="All CAPA Closed By">All CAPA Closed By</label>
                                                <div class="static">{{ $EHS->All_CAPA_Closed_By }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="All CAPA Closed On">All CAPA Closed On</label>
                                                <div class="static">{{ $EHS->All_CAPA_Closed_On }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="All CAPA Closed Comment">All CAPA Closed Comment</label>
                                                <div class="static">{{ $EHS->All_CAPA_Closed_Comment }}</div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="button-block">
                                        <button type="submit" class="saveButton">Save</button>
                                        <button type="button" class="backButton"
                                            onclick="previousStep()">Back</button>
                                        <button type="submit">Submit</button>
                                        <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}"
                                                class="text-white">
                                                Exit </a> </button>
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
                <form action="{{ route('ehsEventStateChange', $EHS->id) }}" method="POST">
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

    <div class="modal fade" id="more-info-required-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">E-Signature</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form action="{{ route('ehsMoreInfo', $EHS->id) }}" method="POST">
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
                            <input type="text" class="form-control" name="username" required>
                        </div>
                        <div class="group-input">
                            <label for="password">Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" name="password" required>
                        </div>
                        <div class="group-input">
                            <label for="comment">Comment <span class="text-danger">*</span></label>
                            <input type="comment" class="form-control" name="comment" required>
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <!-- <div class="modal-footer">
                                    <button type="submit" data-bs-dismiss="modal">Submit</button>
                                    <button>Close</button>
                                </div> -->
                    <div class="modal-footer">
                        <button type="submit">
                            Submit
                        </button>
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

                <form action="{{ url('EHSCancel', $EHS->id) }}" method="POST">
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
                            <input type="comment" name="comment"required>
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <!-- <div class="modal-footer">
                                <button type="submit" data-bs-dismiss="modal">Submit</button>
                                <button>Close</button>
                            </div> -->
                    <div class="modal-footer">
                        <button type="submit">Submit</button>
                        <button data-bs-dismiss="modal">Close</button>
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

                <form action="{{ url('ehsEventRejectState', $EHS->id) }}" method="POST">
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
                <form action="{{ route('ehsChild', $EHS->id) }}" method="POST">
                    @csrf
                    <!-- Modal body -->
                    {{-- <div class="modal-body">
                        <div class="group-input">
                            <label></lable>
                            <label for="major">
                                <input type="radio" name="child_type" value="RCA">
                                RCA
                            </label>
                        </div>
                    </div> --}}
                    <div class="modal-body">
                        <div class="group-input">
                            @if ($EHS->stage == 3)
                                <label for="major">
                                    <input type="radio" name="child_type" id="major" value="RCA">
                                    RCA
                                </label>
                            @endif

                            @if ($EHS->stage == 5)
                                <label for="major">
                                    <input type="radio" name="child_type" id="major" value="CAPA">
                                    CAPA
                                </label>

                                <label for="major">
                                    <input type="radio" name="child_type" id="major" value="Sanction">
                                    Sanction
                                </label>

                                <label for="major">
                                    <input type="radio" name="child_type" id="major" value="RCA">
                                    RCA
                                </label>

                                <label for="major">
                                    <input type="radio" name="child_type" id="major" value="Action Item">
                                    Action Item
                                </label>
                                <label for="major">
                                    <input type="radio" name="child_type" id="major" value="Risk Assessment">
                                    Risk Assessment
                                </label>

                                <label for="major">
                                    <input type="radio" name="child_type" id="major" value="Internal Audit">
                                    Internal Audit
                                </label>

                                <label for="major">
                                    <input type="radio" name="child_type" id="major" value="External Audit">
                                    External Audit
                                </label>
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
        function calculateRiskAnalysis(type) {
            const probability = parseInt(document.getElementById(type + 'Probability').value);
            const severity = parseInt(document.getElementById(type + 'Severity').value);

            if (!isNaN(probability) && !isNaN(severity)) {
                const risk = probability * severity;

                // Mapping risk values to their corresponding descriptions
                let riskDescription = '';
                switch (risk) {
                    case 1:
                        riskDescription = '1: Acceptable';
                        break;
                    case 2:
                        riskDescription = '2: Mostly Acceptable';
                        break;
                    case 3:
                        riskDescription = '3: Tolerable';
                        break;
                    case 4:
                        riskDescription = '4: Tolerable';
                        break;
                    case 6:
                        riskDescription = '6: Mostly Unacceptable';
                        break;
                    case 9:
                        riskDescription = '9: Unacceptable';
                        break;
                    default:
                        riskDescription = 'Out of Range';
                }

                document.getElementById(type + 'Risk').value = riskDescription;
            } else {
                // Clear the field if selections are incomplete
                document.getElementById(type + 'Risk').value = '';
            }
        }
    </script>
    <script>
        function calculateRiskAnalysis2() {
            // Get the values of Severity Rate, Occurrence, and Detection
            const severity = document.getElementById("analysisR").value;
            const occurrence = document.getElementById("analysisP").value;
            const detection = document.getElementById("analysisN").value;

            // Ensure all values are selected and not empty
            if (severity && occurrence && detection) {
                // Calculate RPN by multiplying the values
                const rpn = parseInt(severity) * parseInt(occurrence) * parseInt(detection);
                // Set the calculated RPN value in the input field
                document.getElementById("analysisRPN").value = rpn;
            } else {
                // If any value is missing, clear the RPN field
                document.getElementById("analysisRPN").value = '';
            }
        }
    </script>

    <script>
        $(document).ready(function() {
            $('#root-cause-methodology').on('change', function() {
                var selectedValues = $(this).val() || [];

                // Hide all sections initially
                $('#why-why-chart-section').hide();
                $('#fmea-section').hide();
                $('#fishbone-section').hide();
                $('#HideInference').hide();
                $('#is-is-not-section').hide();
                $('#root-cause-others').hide();


                // Show sections based on the selected values
                selectedValues.forEach(function(value) {
                    if (value === 'Why-Why Chart') {
                        $('#why-why-chart-section').show();
                    }
                    if (value === 'Failure Mode and Effect Analysis') {
                        $('#fmea-section').show();
                    }
                    if (value === 'Fishbone or Ishikawa Diagram') {
                        $('#fishbone-section').show();
                        $('#HideInference').show();
                    }
                    if (value === 'Is/Is Not Analysis') {
                        $('#is-is-not-section').show();
                    }
                    if (selectedValues.includes('Rootcauseothers')) {
                        $('#root-cause-others').show();
                    }
                });
            });

            // Trigger the change event on page load to show the correct sections based on initial values
            $('#root-cause-methodology').trigger('change');
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#root-cause-methodology').on('change', function() {
                var selectedValues = $(this).val() || [];

                // Hide all sections initially
                $('#why-why-chart-section').hide();
                $('#fmea-section').hide();
                $('#fishbone-section').hide();
                $('#HideInference').hide();
                $('#is-is-not-section').hide();
                $('#root-cause-others').hide();


                // Show sections based on the selected values
                selectedValues.forEach(function(value) {
                    if (value === 'Why-Why Chart') {
                        $('#why-why-chart-section').show();
                    }
                    if (value === 'Failure Mode and Effect Analysis') {
                        $('#fmea-section').show();
                    }
                    if (value === 'Fishbone or Ishikawa Diagram') {
                        $('#fishbone-section').show();
                        $('#HideInference').show();
                    }
                    if (value === 'Is/Is Not Analysis') {
                        $('#is-is-not-section').show();
                    }
                    if (selectedValues.includes('Rootcauseothers')) {
                        $('#root-cause-others').show();
                    }
                });
            });

            // Trigger the change event on page load to show the correct sections based on initial values
            $('#root-cause-methodology').trigger('change');
        });
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
        function addInference(tableId) {
            var table = document.getElementById(tableId);
            var currentRowCount = table.rows.length;
            var newRow = table.insertRow(currentRowCount);

            newRow.setAttribute("id", "row" + currentRowCount);
            var cell1 = newRow.insertCell(0);
            cell1.innerHTML = currentRowCount;

            var cell2 = newRow.insertCell(1);
            cell2.innerHTML =
                "<select name='inference_type[]'><option value=''>-- Select --</option><option value='Measurement'>Measurement</option><option value='Materials'>Materials</option><option value='Methods'>Methods</option><option value='Mother Environment'>Mother Environment</option><option value='Man'>Man</option><option value='Machine'>Machine</option></select>";

            var cell3 = newRow.insertCell(2);
            cell3.innerHTML = "<input type='text'  name='inference_remarks[]'>";

            var cell4 = newRow.insertCell(3);
            cell4.innerHTML = "<button type='text' class='removeRowBtn' name='Action[]' readonly>Remove</button>";

            for (var i = 1; i < currentRowCount; i++) {
                var row = table.rows[i];
                row.cells[0].innerHTML = i;
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
        function addRootCauseAnalysisRiskAssessment(tableId) {
            var table = document.getElementById(tableId);
            var currentRowCount = table.children[1].rows.length;
            var newRow = table.children[1].insertRow(currentRowCount);
            newRow.setAttribute("id", "row" + currentRowCount);
            var cell1 = newRow.insertCell(0);
            cell1.innerHTML = currentRowCount + 1;

            var cell2 = newRow.insertCell(1);
            cell2.innerHTML = "<input name='risk_factor[]' type='text'>";

            var cell3 = newRow.insertCell(2);
            cell3.innerHTML = "<input name='risk_element[]' type='text'>";

            var cell4 = newRow.insertCell(3);
            cell4.innerHTML = "<input name='problem_cause[]' type='text'>";

            // var cell5 = newRow.insertCell(4);
            // cell5.innerHTML = "<input name='existing_risk_control[]' type='text'>";

            var cell5 = newRow.insertCell(4);
            cell5.innerHTML =
                "<select onchange='calculateInitialResult(this)' class='fieldR' name='initial_severity[]'><option value=''>-- Select --</option><option value='1'>1-Insignificant</option><option value='2'>2-Minor</option><option value='3'>3-Major</option><option value='4'>4-Critical</option><option value='5'>5-Catastrophic</option></select>";
            // "<input name='initial_severity[]' type='text'>";


            var cell6 = newRow.insertCell(5);
            cell6.innerHTML =
                "<select onchange='calculateInitialResult(this)' class='fieldP' name='initial_probability[]'><option value=''>-- Select --</option><option value='1'>1-Very rare</option><option value='2'>2-Unlikely</option><option value='3'>3-Possibly</option><option value='4'>4-Likely</option><option value='5'>5-Almost certain (every time)</option></select>";

            var cell7 = newRow.insertCell(6);
            cell7.innerHTML =
                "<select onchange='calculateInitialResult(this)' class='fieldN' name='initial_detectability[]'><option value=''>-- Select --</option><option value='1'>1-Always detected</option><option value='2'>2-Likely to detect</option><option value='3'>3-Possible to detect</option><option value='4'>4-Unlikely to detect</option><option value='5'>5-Not detectable</option></select>";

            var cell8 = newRow.insertCell(7);
            cell8.innerHTML = "<input name='initial_rpn[]' type='text' class='initial-rpn' readonly>";

            // var cell10 = newRow.insertCell(9);
            // cell10.innerHTML =
            //     "<select name='risk_acceptance[]'><option value=''>-- Select --</option><option value='N'>N</option><option value='Y'>Y</option></select>";

            var cell19 = newRow.insertCell(8);
            cell19.innerHTML = "<input name='risk_control_measure[]' type='text'>";

            var cell10 = newRow.insertCell(9);
            cell10.innerHTML =
                "<select onchange='calculateResidualResult(this)' class='residual-fieldR' name='residual_severity[]'><option value=''>-- Select --</option><option value='1'>1-Insignificant</option><option value='2'>2-Minor</option><option value='3'>3-Major</option><option value='4'>4-Critical</option><option value='5'>5-Catastrophic</option></select>";

            var cell11 = newRow.insertCell(10);
            cell11.innerHTML =
                "<select onchange='calculateResidualResult(this)' class='residual-fieldP' name='residual_probability[]'><option value=''>-- Select --</option><option value='1'>1-Very rare</option><option value='2'>2-Unlikely</option><option value='3'>3-Possibly</option><option value='4'>4-Likely</option><option value='5'>5-Almost certain (every time)</option></select>";

            var cell12 = newRow.insertCell(11);
            cell12.innerHTML =
                "<select onchange='calculateResidualResult(this)' class='residual-fieldN' name='residual_detectability[]'><option value=''>-- Select --</option><option value='1'>1-Always detected</option><option value='2'>2-Likely to detect</option><option value='3'>3-Possible to detect</option><option value='4'>4-Unlikely to detect</option><option value='5'>5-Not detectable</option></select>";

            var cell13 = newRow.insertCell(12);
            cell13.innerHTML = "<input name='residual_rpn[]' type='text' class='residual-rpn' readonly>";
            var cell14 = newRow.insertCell(13);
            cell14.innerHTML =
                "<select name='risk_acceptance[]' class='risk-acceptance' readonly>" +
                "<option value=''>-- Select --</option>" +
                "<option value='Low'>Low</option>" +
                "<option value='Medium'>Medium</option>" +
                "<option value='High'>High</option>" +
                "</select>";

            var cell15 = newRow.insertCell(14);
            cell15.innerHTML =
                "<select name='risk_acceptance2[]'><option value=''>-- Select --</option><option value='N'>N</option><option value='Y'>Y</option></select>";

            var cell16 = newRow.insertCell(15);
            cell16.innerHTML = "<input name='mitigation_proposal[]' type='text'>";

            var cell17 = newRow.insertCell(16);
            cell17.innerHTML = "<button type='text' class='removeRowBtn' name='Action[]' readonly>Remove</button>";

            for (var i = 0; i < currentRowCount - 1; i++) {
                var row = table.children[1].rows[i];
                row.cells[0].innerHTML = i + 1;
            }
        }
    </script>
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
