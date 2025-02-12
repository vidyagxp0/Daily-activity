@extends('frontend.layout.main')
@section('container')
    @php
        $users = DB::table('users')->select('id', 'name')->where('active', 1)->get();
        $userRoles = DB::table('user_roles')->select('user_id')->where('q_m_s_roles_id', 4)->distinct()->get();
        $departments = DB::table('departments')->select('id', 'name')->get();
        $divisions = DB::table('q_m_s_divisions')->select('id', 'name')->get();

        $userIds = DB::table('user_roles')->where('q_m_s_roles_id', 4)->distinct()->pluck('user_id');

        // Step 3: Use the plucked user_id values to get the names from the users table
        $userNames = DB::table('users')->whereIn('id', $userIds)->pluck('name');

        // If you need both id and name, use the select method and get
        $userDetails = DB::table('users')->whereIn('id', $userIds)->select('id', 'name')->get();
        // dd ($userIds,$userNames, $userDetails);
    @endphp
    <style>
        textarea.note-codable {
            display: none !important;
        }

        header {
            display: none;
        }

        .remove-file {
            color: white;
            cursor: pointer;
            margin-left: 10px;
        }

        .remove-file :hover {
            color: white;
        }

        .progress-bars div {
            flex: 1 1 auto;
            border: 1px solid grey;
            padding: 5px;
            text-align: center;
            position: relative;
            /* border-right: none; */
            background: white;
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

        /* #change-control-fields>div>div.inner-block.state-block>div.status>div.progress-bars.d-flex>div:nth-child(4) {
                                                                                                                                                                                                                                                                                                                                        border-radius: 0px 20px 20px 0px;

                                                                                                                                                                                                                                                                                                                                    } */
        .new-moreinfo {
            width: 100%;
            border-radius: 5px;
            margin-bottom: 13px;
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
    </style>

    <div class="form-field-head">
        <div class="division-bar">
            <strong>Site Division/Project</strong> :
            {{ Helpers::getDivisionName($extensionNew->site_location_code) }} /
            Extension
        </div>
    </div>
    {{-- ======================================
                    DATA FIELDS
    ======================================= --}}
    <div id="change-control-fields">
        <div class="container-fluid">

            <div class="inner-block state-block">

                <div class="d-flex justify-content-between align-items-center">
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
                    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit">
                    </script>
                    <script>
                        $(document).ready(function() {
                            setTimeout(() => {
                                $('body').css('top', '0');
                            }, 5000);
                        })
                    </script>
                    @php
                        $userRoles = DB::table('user_roles')
                            ->where([
                                'user_id' => Auth::user()->id,
                                'q_m_s_divisions_id' => $extensionNew->site_location_code,
                            ])
                            ->get();
                        $userRoleIds = $userRoles->pluck('q_m_s_roles_id')->toArray();
                    @endphp
                    <div class="d-flex" style="gap:20px;">
                        {{-- <button class="button_theme1" onclick="window.print();return false;"
                            class="new-doc-btn">Print</button> --}}
                        <button class="button_theme1"> <a class="text-white"
                                href="{{ url('rcms/audit_trailNew', $extensionNew->id) }}"> Audit Trail </a> </button>
                        @if ($extensionNew->stage == 1 && (in_array(3, $userRoleIds) || in_array(18, $userRoleIds)))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Submit
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#reject-required-modal">
                                Cancel
                            </button>
                        @elseif($extensionNew->stage == 2 && (in_array(10, $userRoleIds) || in_array(18, $userRoleIds)))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Review
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#more-info-required-modal">
                                More Info Required
                            </button>
                        @elseif($extensionNew->stage == 3 && (in_array(10, $userRoleIds) || in_array(18, $userRoleIds)))
                            {{-- <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                               Approved
                            </button> --}}
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-approved-modal">
                                Approved
                            </button>
                            @if (Helpers::getChildData($extensionNew->parent_id, 'LabIncident') == 3)
                                <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-cqa-modal">
                                    Send for CQA
                                </button>
                            @elseif(Helpers::getChildData($extensionNew->parent_id, 'Deviation') == 3)
                                <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-cqa-modal">
                                    Send for CQA
                                </button>
                            @elseif(Helpers::getChildData($extensionNew->parent_id, 'OOC') == 3)
                                <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-cqa-modal">
                                    Send for CQA
                                </button>
                            @elseif(Helpers::getChildData($extensionNew->parent_id, 'OOT') == 3)
                                <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-cqa-modal">
                                    Send for CQA
                                </button>
                            @elseif(Helpers::getChildData($extensionNew->parent_id, 'Management Review') == 3)
                                <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-cqa-modal">
                                    Send for CQA
                                </button>
                            @elseif(Helpers::getChildData($extensionNew->parent_id, 'CAPA') == 3)
                                <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-cqa-modal">
                                    Send for CQA
                                </button>
                            @elseif(Helpers::getChildData($extensionNew->parent_id, 'Action Item') == 3)
                                <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-cqa-modal">
                                    Send for CQA
                                </button>
                            @elseif(Helpers::getChildData($extensionNew->parent_id, 'Resampling') == 3)
                                <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-cqa-modal">
                                    Send for CQA
                                </button>
                            @elseif(Helpers::getChildData($extensionNew->parent_id, 'Observation') == 3)
                                <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-cqa-modal">
                                    Send for CQA
                                </button>
                            @elseif(Helpers::getChildData($extensionNew->parent_id, 'RCA') == 3)
                                <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-cqa-modal">
                                    Send for CQA
                                </button>
                            @elseif(Helpers::getChildData($extensionNew->parent_id, 'Risk Assesment') == 3)
                                <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-cqa-modal">
                                    Send for CQA
                                </button>
                            @elseif(Helpers::getChildData($extensionNew->parent_id, 'Management Review') == 3)
                                <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-cqa-modal">
                                    Send for CQA
                                </button>
                            @elseif(Helpers::getChildData($extensionNew->parent_id, 'External Audit') == 3)
                                <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-cqa-modal">
                                    Send for CQA
                                </button>
                            @elseif(Helpers::getChildData($extensionNew->parent_id, 'Internal Audit') == 3)
                                <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-cqa-modal">
                                    Send for CQA
                                </button>
                            @elseif(Helpers::getChildData($extensionNew->parent_id, 'Audit Program') == 3)
                                <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-cqa-modal">
                                    Send for CQA
                                </button>
                            @elseif(Helpers::getChildData($extensionNew->parent_id, 'CC') == 3)
                                <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-cqa-modal">
                                    Send for CQA
                                </button>
                            @elseif(Helpers::getChildData($extensionNew->parent_id, 'New Documnet') == 3)
                                <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-cqa-modal">
                                    Send for CQA
                                </button>
                            @elseif(Helpers::getChildData($extensionNew->parent_id, 'Effectiveness Check') == 3)
                                <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-cqa-modal">
                                    Send for CQA
                                </button>
                            @elseif(Helpers::getChildData($extensionNew->parent_id, 'OOS Micro') == 3)
                                <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-cqa-modal">
                                    Send for CQA
                                </button>
                            @elseif(Helpers::getChildData($extensionNew->parent_id, 'OOS Chemical') == 3)
                                <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-cqa-modal">
                                    Send for CQA
                                </button>
                            @elseif(Helpers::getChildData($extensionNew->parent_id, 'Market Complaint') == 3)
                                <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-cqa-modal">
                                    Send for CQA
                                </button>
                            @elseif(Helpers::getChildData($extensionNew->parent_id, 'Failure Investigation') == 3)
                                <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-cqa-modal">
                                    Send for CQA
                                </button>
                            @endif
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Reject
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal"
                                data-bs-target="#more-info-required-modal">
                                More Info Required
                            </button>
                        @elseif($extensionNew->stage == 5 && (in_array(10, $userRoleIds) || in_array(18, $userRoleIds)))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-cqa-modal">
                                CQA Approval Complete
                            </button>
                            {{-- <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#more-info-required-modal">
                                More Info Required
                            </button> --}}
                        @endif
                        <a class="text-white" href="{{ url('rcms/qms-dashboard') }}"><button class="button_theme1"> Exit
                            </button> </a>
                    </div>
                </div>
                <div class="main-head">Record Workflow </div>
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
                                <h4 class="modal-titles ml-10">Equipment/Instrument Lifecycle Management Workflow</h4>
                            </div>
                            <div style="" class="modal-body main-new-workflow">
                                <Div class="button-box">
                                    @if ($extensionNew->stage == 0)
                                        <div class="">
                                            <div class="mini_buttons  bg-danger">Closed-Cancelled</div>
                                        @else
                                            @if ($extensionNew->stage >= 1)
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
                                            @if ($extensionNew->stage >= 2)
                                                <div class="active">
                                                    In Review
                                                </div>
                                            @else
                                                <div class="mini_buttons">In Review</div>
                                            @endif
                                            <div class="down-logo">
                                                <img class="dawn_arrow" src="{{ asset('user/images/down.gif') }}"
                                                    alt="..." class="w-100 h-100">
                                            </div>
                                            @if ($extensionNew->stage >= 3)
                                                <div class="active">
                                                    In Approved
                                                </div>
                                            @else
                                                <div class="mini_buttons">In Approved</div>
                                            @endif
                                            <div class="down-logo">
                                                <img class="dawn_arrow" src="{{ asset('user/images/down.gif') }}"
                                                    alt="..." class="w-100 h-100">
                                            </div>
                                            @if ($extensionNew->stage >= 4)
                                                <div class="active">
                                                    In CQA Approval
                                                </div>
                                            @else
                                                <div class="mini_buttons">In CQA Approval</div>
                                            @endif
                                            <div class="down-logo">
                                                <img class="dawn_arrow" src="{{ asset('user/images/down.gif') }}"
                                                    alt="..." class="w-100 h-100">
                                            </div>
                                           
                                            @if ($extensionNew->stage >= 10)
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
                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
                <style>
                    .sticky-buttons div {
                         background: #4274da;
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
                <div class="status">
                    <div class="head">Current Status</div>
                    @if ($extensionNew->stage == 0)
                        <div class="progress-bars">
                            <div class="bg-danger">Closed-Cancelled</div>
                        </div>
                    @else
                        <div class="progress-bars d-flex">
                            @if ($extensionNew->stage >= 1)
                                <div class="active">Opened</div>
                            @else
                                <div class="">Opened</div>
                            @endif

                            @if ($extensionNew->stage >= 2)
                                <div class="active">In Review</div>
                            @else
                                <div class="">In Review</div>
                            @endif

                            @if ($extensionNew->stage >= 3)
                                <div class="active">In Approved</div>
                            @else
                                <div class="">In Approved</div>
                            @endif
                            <div style="display: none" class=""> In CQA Approval</div>

                            @if ($extensionNew->stage == 4)
                                <div class="bg-danger">Closed - Reject</div>
                                <div style="display: none" class="">Closed - Done</div>
                                <div style="display: none" class=""> In CQA Approval</div>
                            @elseif($extensionNew->stage == 1 || $extensionNew->stage == 2 || $extensionNew->stage == 3)
                                <div class=""> Closed - Reject</div>
                            @else
                                <div class="" style="display: none"> Closed - Reject</div>
                            @endif
                            @if ($extensionNew->stage == 5)
                                <div class="bg-danger" style="display: none">Closed - Reject</div>
                                <div class="active"> In CQA Approval</div>
                            @endif
                            @if ($extensionNew->stage >= 6)
                                <div class="bg-danger" style="display: none">Closed - Reject</div>
                                <div style="display: none" class=""> In CQA Approval</div>

                                <div class="bg-danger">Closed - Done</div>
                            @endif
                        </div>
                    @endif
                </div>
                {{-- @endif --}}
                {{-- ---------------------------------------------------------------------------------------- --}}
            </div>
            <!-- Tab links -->
            <div class="cctab">

                <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">General Information</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm2')">HOD review </button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm3')">QA Approval</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm6')">Activity Log</button>
            </div>
            <form action="{{ route('extension_new.update', $extensionNew->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <!-- Tab content -->
                <div id="step-form">

                    <div id="CCForm1" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                @if (!empty($parent_id))
                                    <input type="hidden" name="parent_id" value="{{ $parent_id }}">
                                    <input type="hidden" name="parent_type" value="{{ $parent_type }}">
                                    <input type="hidden" name="parent_record" value="{{ $parent_record }}">
                                @endif
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="RLS Record Number"><b>Record Number</b></label>
                                        <input disabled type="text" name="record_number"
                                            value="{{ Helpers::getDivisionName($extensionNew->site_location_code) }}/Ext/{{ Helpers::year($extensionNew->created_at) }}/{{ str_pad($extensionNew->record_number, 4, '0', STR_PAD_LEFT) }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Division Code"><b>Site/Location Code</b></label>
                                        <input disabled type="text" name="site_location" id="site_location"
                                            value="{{ Helpers::getDivisionName($extensionNew->site_location_code) }}">
                                        <input type="hidden" name="site_location_code" id="site_location_code"
                                            value="{{ session()->get('division') }}">
                                        {{-- <div class="static">{{ Helpers::getDivisionName(session()->get('division')) }}</div> --}}
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Initiator"><b>Initiator</b></label>
                                        {{-- <input type="hidden" value="{{ Auth::user()->name }}" name="initiator" id="initiator"> --}}
                                        <input disabled type="text" name="initiator" id="initiator"
                                            value="{{ Auth::user()->name }}">
                                    </div>
                                </div>
                                @php
                                    // Calculate the due date (30 days from the initiation date)
                                    $initiationDate = date('Y-m-d'); // Current date as initiation date
                                    $dueDate = date('Y-m-d', strtotime($initiationDate . '+30 days')); // Due date
                                @endphp
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Date of Initiation"><b>Date of Initiation</b></label>
                                        <input readonly type="text"
                                            value="{{ Helpers::getdateFormat($extensionNew->initiation_date) }}"
                                            name="initiation_date" id="initiation_date"
                                            style="background-color: light-dark(rgba(239, 239, 239, 0.3), rgba(59, 59, 59, 0.3))">
                                        {{-- <input type="hidden" value="{{ date('Y-m-d') }}" name="initiation_date_hidden"> --}}
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Short Description">
                                            Short Description<span class="text-danger">*</span>
                                        </label>
                                        <span id="rchars">255</span> Characters remaining
                                        <div class="relative-container">
                                            <input id="docname" type="text" name="short_description"
                                                value="{{ $extensionNew->short_description }}" maxlength="255" required>
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                    {{-- @error('short_description')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror --}}
                                </div>

                                <script>
                                    var maxLength = 255;
                                    $('#docname').keyup(function() {
                                        var textlen = maxLength - $(this).val().length;
                                        $('#rchars').text(textlen);
                                    });
                                </script>
                                <!-- <div class="col-lg-6">
                                                                                                                                                                                                                                                                                                                                                            <div class="group-input">
                                                                                                                                                                                                                                                                                                                                                                <label for="Assigned To">HOD review  </label>
                                                                                                                                                                                                                                                                                                                                                                <select id="choices-multiple-remove" class="choices-multiple-reviewe"
                                                                                                                                                                                                                                                                                                                                                                    name="reviewers" placeholder="Select Reviewers" >
                                                                                                                                                                                                                                                                                                                                                                    <option value="">-- Select --</option>
                                                                                                                                                                                                                                                                                                                                                                    @if (!empty($reviewers))
    @foreach ($reviewers as $lan)
    @if (Helpers::checkUserRolesreviewer($lan))
    <option value="{{ $lan->id }}" @if ($lan->id == $extensionNew->reviewers) selected @endif>
                                                                                                                                                                                                                                                                                                                                                                                    {{ $lan->name }}
                                                                                                                                                                                                                                                                                                                                                                                </option>
    @endif
    @endforeach
    @endif
                                                                                                                                                                                                                                                                                                                                                                </select>
                                                                                                                                                                                                                                                                                                                                                            </div>
                                                                                                                                                                                                                                                                                                                                                        </div> -->


                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Assigned To">HOD Reviewer</label>
                                        <select id="choices-multiple-remove" class="choices-multiple-reviewe"
                                            name="reviewers" placeholder="Select Reviewers"
                                            {{ $extensionNew->stage == 0 || $extensionNew->stage == 4 ? 'disabled' : '' }}>
                                            <option value="">-- Select --</option>
                                            @if (!empty(Helpers::getHODDropdown()))
                                                @foreach (Helpers::getHODDropdown() as $listHod)
                                                    <option value="{{ $listHod['id'] }}"
                                                        @if ($listHod['id'] == $extensionNew->reviewers) selected @endif>
                                                        {{ $listHod['name'] }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="priority_data">Priority</label>
                                        <select name="priority_data" placeholder="Select Reference Records"
                                            data-search="false" data-silent-initial-value-set="true" id="priority_data">
                                            <option value="">--Select--</option>
                                            <option {{ $extensionNew->priority_data == 'High' ? 'selected' : '' }}
                                                value="High">High</option>
                                            <option {{ $extensionNew->priority_data == 'Medium' ? 'selected' : '' }}
                                                value="Medium">Medium</option>
                                            <option {{ $extensionNew->priority_data == 'Low' ? 'selected' : '' }}
                                                value="Low">Low</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="severity-level">Initial Categorization </label>
                                        <select name="initial_categorization" id="initial_categorization">
                                            <option value="">-- Select --</option>
                                            <option @if ($extensionNew->initial_categorization == 'minor') selected @endif
                                                value="minor">Minor</option>
                                            <option @if ($extensionNew->initial_categorization == 'major') selected @endif
                                                value="major">Major</option>
                                            <option @if ($extensionNew->initial_categorization == 'critical') selected @endif
                                                value="critical">Critical</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- <div class="col-lg-6">
                                                                                                                                                                                                                                                                                                                                                            <div class="group-input">
                                                                                                                                                                                                                                                                                                                                                                <label for="Assigned To">QA approval </label>
                                                                                                                                                                                                                                                                                                                                                                <select id="choices-multiple-remove-but" class="choices-multiple-reviewer"
                                                                                                                                                                                                                                                                                                                                                                    name="approvers" placeholder="Select Approvers" >
                                                                                                                                                                                                                                                                                                                                                                    <option value="">-- Select --</option>
                                                                                                                                                                                                                                                                                                                                                                    @if (!empty($approvers))
    @foreach ($approvers as $lan)
    @if (Helpers::checkUserRolesApprovers($lan))
    <option value="{{ $lan->id }}" @if ($lan->id == $extensionNew->approvers) selected @endif>
                                                                                                                                                                                                                                                                                                                                                                                    {{ $lan->name }}
                                                                                                                                                                                                                                                                                                                                                                                </option>
    @endif
    @endforeach
    @endif
                                                                                                                                                                                                                                                                                                                                                                </select>
                                                                                                                                                                                                                                                                                                                                                            </div>
                                                                                                                                                                                                                                                                                                                                                        </div> -->
                                {{-- <div class="col-12">
                                    <div class="group-input">
                                        <label for="related_records">Related Records</label>

                                        <select multiple name="related_records[]" placeholder="Select Reference Records"
                                            data-silent-initial-value-set="true" id="related_records">

                                            @foreach ($relatedRecords as $record)
                                                <option value="{{ $record->id }}">
                                                    {{ Helpers::getDivisionName($record->division_id) }}/{{ Helpers::year($record->created_at) }}/{{ Helpers::record($record->record) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div> --}}
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="related_records">Related Records</label>

                                        <!-- Virtual Select Dropdown -->
                                        <div id="related_records" class="virtual-select">
                                            <select multiple name="related_records[]" data-silent-initial-value-set="true"
                                                data-search="false" data-placeholder="Select Reference Records">
                                                @if (!empty($relatedRecords))
                                                    @foreach ($relatedRecords as $records)
                                                        @php
                                                            $recordValue =
                                                                Helpers::getDivisionName(
                                                                    $records->division_id ||
                                                                        $records->division ||
                                                                        $records->division_code ||
                                                                        $records->site_location_code,
                                                                ) .
                                                                '/' .
                                                                $records->process_name .
                                                                '/' .
                                                                date('Y') .
                                                                '/' .
                                                                Helpers::recordFormat($records->record);

                                                            $selected = in_array(
                                                                $recordValue,

                                                                explode(',', $extensionNew->related_records),
                                                            )
                                                                ? 'selected'
                                                                : '';
                                                        @endphp
                                                        <option value="{{ $recordValue }}" {{ $selected }}>
                                                            {{ $recordValue }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>





                                <!-- Add the Virtual Select CSS and JS -->
                                <script>
                                    < link href = "https://cdn.jsdelivr.net/npm/virtual-select@2.0.0/dist/virtual-select.min.css"
                                    rel = "stylesheet" >
                                </script>
                                <script src="https://cdn.jsdelivr.net/npm/virtual-select@2.0.0/dist/virtual-select.min.js"></script>

                                <!-- Initialize the Virtual Select -->
                                <script>
                                    VirtualSelect.init({
                                        ele: '#related_records select', // Target the select element
                                        multiple: true, // Allow multiple selections
                                        search: false, // Disable search (set to true if needed)
                                        placeholder: 'Select Reference Records', // Placeholder text
                                        silentInitialValueSet: true // Silent initial value set
                                    });
                                </script>





                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Assigned To">QA Approval </label>
                                        <select id="choices-multiple-remove-but" class="choices-multiple-reviewer"
                                            name="approvers" placeholder="Select Approvers"
                                            {{ $extensionNew->stage == 0 || $extensionNew->stage == 4 ? 'disabled' : '' }}>
                                            <option value="">-- Select --</option>

                                            @if (!empty($users))
                                                @foreach ($users as $lan)
                                                    <option value="{{ $lan->id }}"
                                                        @if ($lan->id == $extensionNew->approvers) selected @endif>
                                                        {{ $lan->name }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Actual Start Date">Current Due Date (Parent)</label>
                                        <div class="calenderauditee">

                                            <input type="text" id="current_due_date"
                                                value="{{ Helpers::getdateFormat($extensionNew->current_due_date) }}"
                                                readonly placeholder="DD-MMM-YYYY" />
                                            <input type="date" name="current_due_date"
                                                min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                                value="{{ $extensionNew->current_due_date }}" class="hide-input"
                                                oninput="handleDateInput(this, 'current_due_date')" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Actual Start Date">Proposed Due Date</label>
                                        <div class="calenderauditee">
                                            <input type="text" id="proposed_due_date"
                                                value="{{ Helpers::getdateFormat($extensionNew->proposed_due_date) }}"
                                                readonly placeholder="DD-MMM-YYYY" />
                                            <input type="date" name="proposed_due_date"
                                                min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                                value="{{ $extensionNew->proposed_due_date }}" class="hide-input"
                                                oninput="handleDateInput(this, 'proposed_due_date')" />
                                        </div>
                                    </div>
                                </div>

                                <script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        function updateProposedDueDateMin() {
                                            var currentDueDateInput = document.querySelector('input[name="current_due_date"]');
                                            var proposedDueDateInput = document.querySelector('input[name="proposed_due_date"]');

                                            if (currentDueDateInput && proposedDueDateInput) {
                                                var currentDueDateValue = currentDueDateInput.value;
                                                if (currentDueDateValue) {
                                                    proposedDueDateInput.setAttribute('min', currentDueDateValue);
                                                } else {
                                                    proposedDueDateInput.setAttribute('min', new Date().toISOString().split('T')[0]);
                                                }
                                            }
                                        }
                                        updateProposedDueDateMin();
                                        document.querySelector('input[name="current_due_date"]').addEventListener('change',
                                            updateProposedDueDateMin);
                                    });
                                </script>

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Short Description">Description</label>
                                        <div class="relative-container">
                                            <textarea id="docname" name="description">{{ $extensionNew->description }}</textarea>
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                    {{-- @error('short_description')
    <div class="text-danger">{{ $message }}</div>
    @enderror --}}
                                </div>

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Short Description">Justification / Reason</label>
                                        <div class="relative-container">
                                            <textarea id="docname" name="justification_reason">{{ $extensionNew->justification_reason }}</textarea>
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                    {{-- @error('short_description')
    <div class="text-danger">{{ $message }}</div>
    @enderror --}}
                                </div>

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Attachment">Attachments</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting
                                                documents</small></div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="file_attachment_extension">
                                                @if ($extensionNew->file_attachment_extension)
                                                    @foreach (json_decode($extensionNew->file_attachment_extension) as $file)
                                                        <h6 type="button" class="file-container text-dark"
                                                            style="background-color: rgb(243, 242, 240);">
                                                            <b>{{ $file }}</b>
                                                            <a href="{{ asset('upload/' . $file) }}" target="_blank"><i
                                                                    class="fa fa-eye text-primary"
                                                                    style="font-size:20px; margin-right:-10px;"></i></a>
                                                            <a type="button" class="remove-file"
                                                                data-file-name="{{ $file }}"><i
                                                                    class="fa-solid fa-circle-xmark"
                                                                    style="color:red; font-size:20px;"></i></a>
                                                            <input type="hidden"
                                                                name="existing_file_attachment_extension[]"
                                                                value="{{ $file }}">
                                                        </h6>
                                                    @endforeach
                                                @endif
                                            </div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input
                                                    {{ $extensionNew->stage == 0 || $extensionNew->stage == 7 || $extensionNew->stage == 8 || $extensionNew->stage == 9 ? 'disabled' : '' }}
                                                    type="file" id="myfile" name="file_attachment_extension[]"
                                                    oninput="addMultipleFiles(this, 'file_attachment_extension')" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Hidden field to keep track of files to be deleted -->
                                <input type="hidden" id="deleted_file_attachment_extension"
                                    name="deleted_file_attachment_extension" value="">

                                <script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        const removeButtons = document.querySelectorAll('.remove-file');

                                        removeButtons.forEach(button => {
                                            button.addEventListener('click', function() {
                                                const fileName = this.getAttribute('data-file-name');
                                                const fileContainer = this.closest('.file-container');

                                                // Hide the file container
                                                if (fileContainer) {
                                                    fileContainer.style.display = 'none';
                                                    // Remove hidden input associated with this file
                                                    const hiddenInput = fileContainer.querySelector('input[type="hidden"]');
                                                    if (hiddenInput) {
                                                        hiddenInput.remove();
                                                    }

                                                    // Add the file name to the deleted files list
                                                    const deletedFilesInput = document.getElementById(
                                                        'deleted_file_attachment_extension');
                                                    let deletedFiles = deletedFilesInput.value ? deletedFilesInput.value.split(
                                                        ',') : [];
                                                    deletedFiles.push(fileName);
                                                    deletedFilesInput.value = deletedFiles.join(',');
                                                }
                                            });
                                        });
                                    });
                                </script>

                            </div>
                            <div class="button-block">
                                <button type="submit" id="ChangesaveButton" class="saveButton">Save</button>

                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>

                                <button type="button"> <a href="{{ url('TMS') }}" class="text-white">
                                        Exit </a> </button>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- reviewer content -->
                <div id="CCForm2" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">
                            <div class="col-lg-12">
                            <div class="group-input">
                                <label for="Assigned To">HOD Remarks</label>
                                <div class="relative-container">
                                    <textarea name="reviewer_remarks" id="reviewer_remarks" cols="30">{{ $extensionNew->reviewer_remarks }}</textarea>
                                    @component('frontend.forms.language-model')
                                    @endcomponent
                                </div>
                            </div>
                        </div>

                            {{-- <div class="col-12">
                            <div class="group-input">
                                <label for="Guideline Attachment">Reviewer Attachment  </label>
                                <div><small class="text-primary">Please Attach all relevant or supporting
                                        documents</small></div>
                                <div class="file-attachment-field">
                                    <div class="file-attachment-list" id="file_attachment_reviewer"></div>
                                    <div class="add-btn">
                                        <div>Add</div>
                                        <input type="file" id="myfile" name="file_attachment_reviewer[]"
                                            oninput="addMultipleFiles(this, 'file_attachment_reviewer')" multiple>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                            <div class="col-12">
                                <div class="group-input">
                                    <label for="HOD Attachment">HOD Attachments</label>
                                    <div><small class="text-primary">Please Attach all relevant or supporting
                                            documents</small></div>
                                    <div class="file-attachment-field">
                                        <div class="file-attachment-list" id="file_attachment_reviewer">
                                            @if ($extensionNew->file_attachment_reviewer)
                                                @foreach (json_decode($extensionNew->file_attachment_reviewer) as $file)
                                                    <h6 type="button" class="file-container text-dark"
                                                        style="background-color: rgb(243, 242, 240);">
                                                        <b>{{ $file }}</b>
                                                        <a href="{{ asset('upload/' . $file) }}" target="_blank"><i
                                                                class="fa fa-eye text-primary"
                                                                style="font-size:20px; margin-right:-10px;"></i></a>
                                                        <a type="button" class="remove-file"
                                                            data-file-name="{{ $file }}"><i
                                                                class="fa-solid fa-circle-xmark"
                                                                style="color:red; font-size:20px;"></i></a>
                                                        <input type="hidden" name="existing_file_attachment_reviewer[]"
                                                            value="{{ $file }}">
                                                    </h6>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input
                                                {{ $extensionNew->stage == 0 || $extensionNew->stage == 7 || $extensionNew->stage == 8 || $extensionNew->stage == 9 ? 'disabled' : '' }}
                                                type="file" id="myfile" name="file_attachment_reviewer[]"
                                                oninput="addMultipleFiles(this, 'file_attachment_reviewer')" multiple>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Hidden field to keep track of files to be deleted -->
                            <input type="hidden" id="deleted_file_attachment_reviewer"
                                name="deleted_file_attachment_reviewer" value="">

                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    const removeButtons = document.querySelectorAll('.remove-file');

                                    removeButtons.forEach(button => {
                                        button.addEventListener('click', function() {
                                            const fileName = this.getAttribute('data-file-name');
                                            const fileContainer = this.closest('.file-container');

                                            // Hide the file container
                                            if (fileContainer) {
                                                fileContainer.style.display = 'none';
                                                // Remove hidden input associated with this file
                                                const hiddenInput = fileContainer.querySelector('input[type="hidden"]');
                                                if (hiddenInput) {
                                                    hiddenInput.remove();
                                                }

                                                // Add the file name to the deleted files list
                                                const deletedFilesInput = document.getElementById(
                                                    'deleted_file_attachment_reviewer');
                                                let deletedFiles = deletedFilesInput.value ? deletedFilesInput.value.split(
                                                    ',') : [];
                                                deletedFiles.push(fileName);
                                                deletedFilesInput.value = deletedFiles.join(',');
                                            }
                                        });
                                    });
                                });
                            </script>

                        </div>
                        <div class="button-block">
                            <button type="submit" id="ChangesaveButton" class="saveButton">Save</button>
                            <button type="button" class="backButton" onclick="previousStep()">Back</button>
                            <button type="button" class="nextButton" onclick="nextStep()">Next</button>

                            <button type="button"> <a href="{{ url('TMS') }}" class="text-white">
                                    Exit </a> </button>
                        </div>
                    </div>
                </div>
                <!-- Approver-->
                <div id="CCForm3" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">
                            <div class="col-lg-6">
                                                <div class="group-input">
                                                    <label for="priority_data">Post Categorization</label>
                                                    <select name="post_categorization" placeholder="Select Reference Records"
                                                        data-search="false" data-silent-initial-value-set="true"
                                                        id="post_categorization" >
                                                        <option value="">--Select--</option>
                                                        <option {{ $extensionNew->post_categorization == 'major' ? 'selected' : '' }}
                                                            value="major">Major</option>
                                                        <option {{ $extensionNew->post_categorization == 'minor' ? 'selected' : '' }}
                                                            value="minor">Minor</option>
                                                        <option {{ $extensionNew->post_categorization == 'critical' ? 'selected' : '' }}
                                                            value="critical">Critical</option>
                                                    </select>
                                                </div>
                                            </div>
                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Assigned To">QA Remarks</label>
                                    <div class="relative-container">
                                        <textarea name="approver_remarks" id="approver_remarks" cols="30">{{ $extensionNew->approver_remarks }}</textarea>
                                        @component('frontend.forms.language-model')
                                        @endcomponent
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label for="QA Attachments">QA Attachments</label>
                                    <div><small class="text-primary">Please Attach all relevant or supporting
                                            documents</small></div>
                                    <div class="file-attachment-field">
                                        <div class="file-attachment-list" id="file_attachment_approver">
                                            @if ($extensionNew->file_attachment_approver)
                                                @foreach (json_decode($extensionNew->file_attachment_approver) as $file)
                                                    <h6 class="file-container text-dark"
                                                        style="background-color: rgb(243, 242, 240);">
                                                        <b>{{ $file }}</b>
                                                        <a href="{{ asset('upload/' . $file) }}" target="_blank"><i
                                                                class="fa fa-eye text-primary"
                                                                style="font-size:20px; margin-right:-10px;"></i></a>
                                                        <a class="remove-file" data-file-name="{{ $file }}"><i
                                                                class="fa-solid fa-circle-xmark"
                                                                style="color:red; font-size:20px;"></i></a>
                                                        <input type="hidden" name="existing_file_attachment_approver[]"
                                                            value="{{ $file }}">
                                                    </h6>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input
                                                {{ $extensionNew->stage == 0 || $extensionNew->stage == 7 || $extensionNew->stage == 8 || $extensionNew->stage == 9 ? 'disabled' : '' }}
                                                type="file" id="HOD_Attachments" name="file_attachment_approver[]"
                                                oninput="addMultipleFiles(this, 'file_attachment_approver')" multiple>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Hidden field to keep track of files to be deleted -->
                            <input type="hidden" id="deleted_file_attachment_approver"
                                name="deleted_file_attachment_approver" value="">

                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    const removeButtons = document.querySelectorAll('.remove-file');

                                    removeButtons.forEach(button => {
                                        button.addEventListener('click', function() {
                                            const fileName = this.getAttribute('data-file-name');
                                            const fileContainer = this.closest('.file-container');

                                            // Hide the file container
                                            if (fileContainer) {
                                                fileContainer.style.display = 'none';
                                                // Remove hidden input associated with this file
                                                const hiddenInput = fileContainer.querySelector('input[type="hidden"]');
                                                if (hiddenInput) {
                                                    hiddenInput.remove();
                                                }

                                                // Add the file name to the deleted files list
                                                const deletedFilesInput = document.getElementById(
                                                    'deleted_file_attachment_approver');
                                                let deletedFiles = deletedFilesInput.value ? deletedFilesInput.value.split(
                                                    ',') : [];
                                                deletedFiles.push(fileName);
                                                deletedFilesInput.value = deletedFiles.join(',');
                                            }
                                        });
                                    });
                                });
                            </script>

                        </div>
                        <div class="button-block">
                            <button type="submit" id="ChangesaveButton" class="saveButton">Save</button>
                            <button type="button" class="backButton" onclick="previousStep()">Back</button>
                            <button type="button" class="nextButton" onclick="nextStep()">Next</button>

                            <button type="button">
                                <a href="{{ url('TMS') }}" class="text-white">
                                    Exit </a> </button>
                        </div>
                    </div>
                </div>
                <!-- Activity Log content -->
                <div id="CCForm6" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="sub-head">Activity Log</div>

                                    <div class="d-flex align-item-end justify-content-end">
                                           

                                            <button style="margin-bottom:20px;" class="button_theme1"> <a
                                                    class="text-white"
                                                    href="{{ url('rcms/extensionactivityreport', $extensionNew->id) }}"> Print </a>
                                            </button>
                                    </div>

                            
                                    <div class="printable-content">
                                        <div class="row">
                                          
                                        </div>

                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <tbody>
                                                    <!-- Row for Initiate extensionNew By and Initiate extensionNew On -->
                                                    <tr>
                                                        <td>
                                                            <strong>Submit By:</strong><br>
                                                            {{ $extensionNew->submit_by }}
                                                        </td>
                                                        <td>
                                                            <strong>Submit On:</strong><br>
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
                                                            {{ $extensionNew->submit_comment ?? 'Not Applicable' }}
                                                        </td>
                                                    </tr>

                                                    <!-- Add more rows for other data -->
                                                    <tr>
                                                        <td>
                                                            <strong>Cancel By:</strong><br>
                                                            {{ $extensionNew->reject_by }}
                                                        </td>
                                                        <td>
                                                            <strong>Cancel On:</strong><br>
                                                           @php
                                                            $utcTime = $data->reject_on ?? null;
                    
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
                                                            {{ $extensionNew->reject_comment ?? 'Not Applicable' }}
                                                        </td>
                                                    </tr>


                                                  

                                                    <!-- More Information Required Section -->
                                            <tr>
                                                <td>
                                                    <strong>More Information Required By:</strong><br>
                                                    {{ $extensionNew->more_info_review_by }}
                                                </td>
                                                <td>
                                                    <strong>More Information Required On:</strong><br>
                                                    @php
                                                            $utcTime = $data->more_info_review_on ?? null;
                    
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
                                                    <strong>More Information Required Comment:</strong><br>
                                                    {{ $extensionNew->more_info_review_comment ?? 'Not Applicable' }}
                                                </td>
                                            </tr>

                                            <!-- Review Section -->
                                            <tr>
                                                <td>
                                                    <strong>Review By:</strong><br>
                                                    {{ $extensionNew->submit_by_review }}
                                                </td>
                                                <td>
                                                    <strong>Review On:</strong><br>
                                                    @php
                                                            $utcTime = $data->submit_on_review ?? null;
                    
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
                                                    <strong>Review Comment:</strong><br>
                                                    {{ $extensionNew->submit_comment_review ?? 'Not Applicable' }}
                                                </td>
                                            </tr>

                                            <!-- Reject Section -->
                                            <tr>
                                                <td>
                                                    <strong>Reject By:</strong><br>
                                                    {{ $extensionNew->submit_by_inapproved }}
                                                </td>
                                                <td>
                                                    <strong>Reject On:</strong><br>
\                                                    @php
                                                            $utcTime = $data->submit_on_inapproved ?? null;
                    
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
                                                    <strong>Reject Comment:</strong><br>
                                                    {{ $extensionNew->submit_commen_inapproved ?? 'Not Applicable' }}
                                                </td>
                                            </tr>




                                            <!--  rejectAdd more rows for other data -->
                                            <tr>
                                                <td>
                                                    <strong>More Information Required By:</strong><br>
                                                    {{ $extensionNew->more_info_inapproved_by }}
                                                </td>
                                                <td>
                                                    <strong>More Information Required On:</strong><br>
                                                  @php
                                                            $utcTime = $data->more_info_inapproved_on ?? null;
                    
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
                                                    <strong>More Information Required Comment:</strong><br>
                                                    {{ $extensionNew->more_info_inapproved_comment ?? 'Not Applicable' }}
                                                </td>
                                            </tr>



                                            <!-- CQA Section -->
                                            <tr>
                                                <td>
                                                    <strong>Send for CQA By:</strong><br>
                                                    {{ $extensionNew->send_cqa_by }}
                                                </td>
                                                <td>
                                                    <strong>Send for CQA On:</strong><br>
                                                    @php
                                                            $utcTime = $data->send_cqa_on ?? null;
                    
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
                                                    <strong>Send for CQA Comment:</strong><br>
                                                    {{ $extensionNew->send_cqa_comment ?? 'Not Applicable' }}
                                                </td>
                                            </tr>

                                            <!-- Approval Section -->
                                            <tr>
                                                <td>
                                                    <strong>Approved By:</strong><br>
                                                    {{ $extensionNew->submit_by_approved }}
                                                </td>
                                                <td>
                                                    <strong>Approved On:</strong><br>
                                                    @php
                                                            $utcTime = $data->submit_on_approved ?? null;
                    
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
                                                    <strong>Approved Comment:</strong><br>
                                                    {{ $extensionNew->submit_comment_approved ?? 'Not Applicable' }}
                                                </td>
                                            </tr>

                                            <!-- CQA Approval Section -->
                                            <tr>
                                                <td>
                                                    <strong>CQA Approval Complete By:</strong><br>
                                                    {{ $extensionNew->cqa_approval_by }}
                                                </td>
                                                <td>
                                                    <strong>CQA Approval Complete On:</strong><br>
                                                    @php
                                                            $utcTime = $data->cqa_approval_on ?? null;
                    
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
                                                    <strong>CQA Approval Complete Comment:</strong><br>
                                                    {{ $extensionNew->cqa_approval_comment ?? 'Not Applicable' }}
                                                </td>
                                            </tr>


                                                    
                                                  
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
            </form>
        </div>
    </div>
    <div class="modal fade" id="signature-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">E-Signature</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('extension_send_stage', $extensionNew->id) }}" method="POST"
                    id="signatureModalForm">
                    @csrf
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
                    <div class="modal-footer">
                        <button type="submit" class="signatureModalButton">
                            <div class="spinner-border spinner-border-sm signatureModalSpinner" style="display: none"
                                role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                            Submit
                        </button>
                        <button type="button" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="signature-cqa-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">E-Signature</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('send-cqa', $extensionNew->id) }}" method="POST" id="signatureModalForm">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3 text-justify">
                            Please select a meaning and a outcome for this task and enter your username
                            and password for this task. You are performing an electronic signature,
                            which is legally binding equivalent of a hand written signature.
                        </div>
                        <div class="group-input">
                            <label for="username">Username <span class="text-danger">*</span></label>
                            <input class="new-moreinfo" type="text" name="username" required>
                        </div>
                        <div class="group-input">
                            <label for="password">Password <span class="text-danger">*</span></label>
                            <input class="new-moreinfo" type="password" name="password" required>
                        </div>
                        <div class="group-input">
                            <label for="comment">Comment</label>
                            <input class="new-moreinfo" type="comment" name="comment">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="signatureModalButton">
                            <div class="spinner-border spinner-border-sm signatureModalSpinner" style="display: none"
                                role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                            Submit
                        </button>
                        <button type="button" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="signature-approved-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">E-Signature</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('send-approved', $extensionNew->id) }}" method="POST" id="signatureModalForm">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3 text-justify">
                            Please select a meaning and a outcome for this task and enter your username
                            and password for this task. You are performing an electronic signature,
                            which is legally binding equivalent of a hand written signature.
                        </div>
                        <div class="group-input">
                            <label for="username">Username <span class="text-danger">*</span></label>
                            <input class="new-moreinfo" type="text" name="username" required>
                        </div>
                        <div class="group-input">
                            <label for="password">Password <span class="text-danger">*</span></label>
                            <input class="new-moreinfo" type="password" name="password" required>
                        </div>
                        <div class="group-input">
                            <label for="comment">Comment</label>
                            <input class="new-moreinfo" type="comment" name="comment">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="signatureModalButton">
                            <div class="spinner-border spinner-border-sm signatureModalSpinner" style="display: none"
                                role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                            Submit
                        </button>
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

                <form action="{{ route('moreinfoState_extension', $extensionNew->id) }}" method="POST">
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
                            <input class="new-moreinfo" type="text" name="username" required>
                        </div>
                        <div class="group-input">
                            <label for="password">Password <span class="text-danger">*</span></label>
                            <input class="new-moreinfo" type="password" name="password" required>
                        </div>
                        <div class="group-input">
                            <label for="comment">Comment <span class="text-danger">*</span></label>
                            <input class="new-moreinfo" type="comment" name="comment" required>
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
    <div class="modal fade" id="reject-required-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">E-Signature</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form action="{{ route('RejectState_extension', $extensionNew->id) }}" method="POST">
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
                            <input class="new-moreinfo" type="text" name="username" required>
                        </div>
                        <div class="group-input">
                            <label for="password">Password <span class="text-danger">*</span></label>
                            <input class="new-moreinfo" type="password" name="password" required>
                        </div>
                        <div class="group-input">
                            <label for="comment">Comment <span class="text-danger">*</span></label>
                            <input class="new-moreinfo" type="comment" name="comment" required>
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
    <script>
        console.log('Script working')

        $(document).ready(function() {


            function submitForm() {

                let auditForm = document.getElementById('auditForm');


                console.log('sumitting form')

                document.querySelectorAll('.saveAuditFormBtn').forEach(function(button) {
                    button.disabled = true;
                })

                document.querySelectorAll('.auditFormSpinner').forEach(function(spinner) {
                    spinner.style.display = 'flex';
                })

                extensionForm.submit();
            }


        });

        document.addEventListener('DOMContentLoaded', function() {
            var signatureForm = document.getElementById('signatureModalForm');

            signatureForm.addEventListener('submit', function(e) {

                var submitButton = signatureForm.querySelector('.signatureModalButton');
                var spinner = signatureForm.querySelector('.signatureModalSpinner');

                submitButton.disabled = true;

                spinner.style.display = 'inline-block';
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            var signatureForm = document.getElementById('pendingInitiatorForm');

            signatureForm.addEventListener('submit', function(e) {

                var submitButton = signatureForm.querySelector('.pendingInitiatorModalButton');
                var spinner = signatureForm.querySelector('.pendingInitiatorModalSpinner');

                submitButton.disabled = true;

                spinner.style.display = 'inline-block';
            });
        });


        // =========================
        wow = new WOW({
            boxClass: 'wow', // default
            animateClass: 'animated', // default
            offset: 0, // default
            mobile: true, // default
            live: true // default
        })
        wow.init();
    </script>
    {{--  <script>
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

        const saveButtons = document.querySelectorAll('.saveButton');
        const form = document.getElementById('step-form');


    </script>  --}}
    <script>
        VirtualSelect.init({
            ele: '#Facility, #Group, #Audit, #Auditee ,#relatedRecords, #designee, #hod,#'
        });
    </script>


    <script>
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
        document.addEventListener('DOMContentLoaded', function() {
            const removeButtons = document.querySelectorAll('.remove-file');

            removeButtons.forEach(button => {
                button.addEventListener('click', function() {
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
@endsection
