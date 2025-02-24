@extends('frontend.layout.main')
@section('container')
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
    <style>
        .sticky-buttons div {
             /*background: #4274da;*/
             background: #de8d0a;
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    
    @php
        $users = DB::table('users')->get();
        
    @endphp

    <div class="form-field-head">

        <div class="division-bar">
            <strong>Site Division/Project</strong> :
            {{ Helpers::getDivisionName($data->division_id) }} / Lab Incident
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
                        $userRoles = DB::table('user_roles')->where(['user_id' => Auth::user()->id, 'q_m_s_divisions_id' => $data->division_id])->get();
                        $userRoleIds = $userRoles->pluck('q_m_s_roles_id')->toArray();
                    @endphp
                        {{-- <button class="button_theme1" onclick="window.print();return false;"
                            class="new-doc-btn">Print</button> --}}
                        <button class="button_theme1"> <a class="text-white"
                                href="{{ route('audittrialLabincident', $data->id) }}"> Audit Trail </a> </button>

                        @if ($data->stage == 1 && (in_array(3, $userRoleIds) || in_array(18, $userRoleIds)))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Submit
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-modal">
                                Cancel
                            </button>
                        @elseif($data->stage == 2 && (in_array(4, $userRoleIds) || in_array(18, $userRoleIds)))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Verification Complete
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#child-modal3">
                                Child
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#rejection-modal">
                                Request More Info
                            </button>
                        @elseif($data->stage == 3 && (in_array(9, $userRoleIds) || in_array(18, $userRoleIds)))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Preliminary Investigation
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#rejection-modal">
                                Request More Info
                            </button>
                             <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#child-modal1">
                                Child
                            </button>


                        @elseif($data->stage == 4 && (in_array(9, $userRoleIds) || in_array(18, $userRoleIds)))

                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#rejection-modal">
                            Request More Info
                        </button>
                        <button class="button_theme1" name="assignable_cause_identification" data-bs-toggle="modal" data-bs-target="#signature-modal">
                            Assignable Cause Identification
                        </button>
                        <button class="button_theme1" name="no_assignable_cause_identification" data-bs-toggle="modal" data-bs-target="#signature-modal1">
                            No Assignable Cause Identification
                        </button>
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#child-modal3">
                            Child
                        </button>

                        {{-- <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                All Activities Completed
                            </button> --}}
                        @elseif($data->stage == 5 && (in_array(3, $userRoleIds) || in_array(18, $userRoleIds)))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Solution Validation
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#rejection-modal">
                                Request More Info
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#child-modal3">
                                Child
                            </button>
                            
                        @elseif($data->stage == 6 && (in_array(3, $userRoleIds) || in_array(18, $userRoleIds)))
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                            Extended Inv. Complete
                        </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#rejection-modal">
                                Request More Info
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#child-modal3">
                                Child
                            </button>
                        @elseif($data->stage == 7 && (in_array(3, $userRoleIds) || in_array(18, $userRoleIds) || in_array(7, $userRoleIds)))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                All Action Approved
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#rejection-modal">
                                Request More Info
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#child-modal3">
                                Child
                            </button>
                         @elseif($data->stage == 8 && (in_array(9, $userRoleIds) || in_array(18, $userRoleIds) || in_array(7, $userRoleIds)))
                            {{-- <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Pending Approval
                            </button> --}}
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#rejection-modal">
                                Request More Info
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Assessment Completed
                            </button>
                          

                            @elseif($data->stage == 9 && (in_array(9, $userRoleIds) || in_array(18, $userRoleIds) || in_array(7, $userRoleIds)))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Closure Completed
                            </button>

                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#rejection-modal">
                                Request More Info
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#child-modal">
                                Child
                            </button>

                            <!-- <button class="button_theme1"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}">
                                    Exit
                                </a> </button> -->
                        @endif
                        <button class="button_theme1"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}"> Exit
                            </a> </button>

                    </div>
                    <div class="sticky-buttons">
                        <div>
                            <a type="button" class="" data-toggle="modal" data-target="#myModal3">
                                <svg width="18" height="24" viewBox="0 0 384 512" xmlns="http://www.w3.org/2000/svg">
                                    <path fill="#ffffff" d="M369.9 97.9L286 14C277 5 264.8-.1 252.1-.1H48C21.5 0 0 21.5 0 48v416c0 26.5 21.5 48 48 48h288c26.5 0 48-21.5 48-48V131.9c0-12.7-5.1-25-14.1-34M332.1 128H256V51.9zM48 464V48h160v104c0 13.3 10.7 24 24 24h104v288zm220.1-208c-5.7 0-10.6 4-11.7 9.5c-20.6 97.7-20.4 95.4-21 103.5c-.2-1.2-.4-2.6-.7-4.3c-.8-5.1.3.2-23.6-99.5c-1.3-5.4-6.1-9.2-11.7-9.2h-13.3c-5.5 0-10.3 3.8-11.7 9.1c-24.4 99-24 96.2-24.8 103.7c-.1-1.1-.2-2.5-.5-4.2c-.7-5.2-14.1-73.3-19.1-99c-1.1-5.6-6-9.7-11.8-9.7h-16.8c-7.8 0-13.5 7.3-11.7 14.8c8 32.6 26.7 109.5 33.2 136c1.3 5.4 6.1 9.1 11.7 9.1h25.2c5.5 0 10.3-3.7 11.6-9.1l17.9-71.4c1.5-6.2 2.5-12 3-17.3l2.9 17.3c.1.4 12.6 50.5 17.9 71.4c1.3 5.3 6.1 9.1 11.6 9.1h24.7c5.5 0 10.3-3.7 11.6-9.1c20.8-81.9 30.2-119 34.5-136c1.9-7.6-3.8-14.9-11.6-14.9h-15.8z" />
                                </svg>
                            </a>
                        </div>
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
                                <div class="active"  style="width: 8% ">Pending Incident Verification </div>
                            @else
                                <div class="">Pending Incident Verification</div>
                            @endif

                            @if ($data->stage >= 3)
                                <div class="active">Pending Preliminary Investigation</div>
                            @else
                                <div class="">Pending Preliminary Investigation</div>
                            @endif

                            @if ($data->stage >= 4)
                                <div class="active">Evaluation of Finding</div>
                            @else
                                <div class="">Evaluation of Finding</div>
                            @endif
                            @if ($data->stage >= 5)
                                <div class="active">Pending Solution & Sample Test</div>
                            @else
                                <div class="">Pending Solution & Sample Test</div>
                            @endif
                            @if ($data->stage >= 6)
                                <div class="active">Pending Extended Investigation</div>
                            @else
                                <div class="">Pending Extended Investigation</div>
                            @endif
                            @if ($data->stage >= 7)
                                <div class="active">CAPA Initiation & Approval</div>
                            @else
                                <div class="">CAPA Initiation & Approval</div>
                            @endif
                             @if ($data->stage >= 8)
                                <div class="active">Final QA/Head Assessment</div>
                            @else
                                <div class="">Final QA/Head Assessment</div>
                            @endif
                            @if ($data->stage >= 9)
                                <div class="active">Pending Approval</div>
                            @else
                                <div class="">Pending Approval</div>
                            @endif

                            @if ($data->stage >= 10)
                                <div class="bg-danger" >Closed - Done</div>
                            @else
                                <div class="">Closed - Done</div>
                            @endif
                    @endif



                </div>

                <div class="modal right fade" id="myModal3" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-titles ml-10">Lab Incident Workflow</h4>
                            </div>
                            <div  style="" class="modal-body main-new-workflow">
                                <Div class="button-box">
                                    @if ($data->stage == 0)
                                    <div class="">
                                        <div class="mini_buttons  bg-danger">Closed-Cancelled</div>
                                    @else
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
                                        Pending Incident Verification
                                    </div> 
                                    @else
                                    <div  class="mini_buttons">
                                        Pending Incident Verification
                                    </div>
                                    @endif
                                    <div class="down-logo">
                                        <img class="dawn_arrow" src="{{ asset('user/images/down.gif') }}" alt="..."
                                            class="w-100 h-100">
        
                                    </div>
                                    @if ($data->stage >= 3)
                                    <div  class="active">
                                        Pending Preliminary Investigation
                                    </div>
                                    @else
                                    <div  class="mini_buttons">
                                        Pending Preliminary Investigation
                                    </div>
                                    @endif
                                    <div class="down-logo">
                                        <img class="dawn_arrow" src="{{ asset('user/images/down.gif') }}" alt="..."
                                            class="w-100 h-100">
        
                                    </div>
                                    @if ($data->stage >= 4)
    
                                    <div  class="active">
                                       Evaluation of Finding
                                    </div>
                                    @else
                                    <div  class="mini_buttons">
                                       Evaluation of Finding
                                    </div>
                                    @endif
    
                                    <div class="down-logo">
                                        <img class="dawn_arrow" src="{{ asset('user/images/down.gif') }}" alt="..."
                                            class="w-100 h-100">
        
                                    </div>
                                    @if ($data->stage >= 5)
    
                                    <div  class="active">
                                        Pending Solution & Sample Test
                                    </div>
                                    @else
                                    <div  class="mini_buttons">
                                        Pending Solution & Sample Test
                                    </div>
                                    @endif
    
                                    <div class="down-logo">
                                        <img class="dawn_arrow" src="{{ asset('user/images/down.gif') }}" alt="..."
                                            class="w-100 h-100">
        
                                    </div>
                                    @if ($data->stage >= 6)
    
                                    <div  class="active">
                                        Pending Extended Investigation
                                    </div>
                                    @else
                                    <div  class="mini_buttons">
                                        Pending Extended Investigation
                                    </div>
                                    @endif
    
                                    <div class="down-logo">
                                        <img class="dawn_arrow" src="{{ asset('user/images/down.gif') }}" alt="..."
                                            class="w-100 h-100">
        
                                    </div>
                                    @if ($data->stage >= 7)
    
                                    <div  class="active">
                                        CAPA Initiation & Approval
                                    </div>
                                    @else
                                    <div  class="mini_buttons">
                                        CAPA Initiation & Approval
                                    </div>
                                    @endif
    
                                    <div class="down-logo">
                                        <img class="dawn_arrow" src="{{ asset('user/images/down.gif') }}" alt="..."
                                            class="w-100 h-100">
        
                                    </div>
                                    @if ($data->stage >= 8)
    
                                    <div  class="active">
                                        Final QA/Head Assessment
                                    </div>
                                    @else
                                    <div  class="mini_buttons">
                                        Final QA/Head Assessment
                                    </div>
                                    @endif

                                    <div class="down-logo">
                                        <img class="dawn_arrow" src="{{ asset('user/images/down.gif') }}" alt="..."
                                            class="w-100 h-100">
        
                                    </div>
                                    @if ($data->stage >= 9)
    
                                    <div  class="active">
                                        Pending Approval
                                    </div>
                                    @else
                                    <div  class="mini_buttons">
                                        Pending Approval
                                    </div>
                                    @endif
    
                                    <div class="down-logo">
                                        <img class="dawn_arrow" src="{{ asset('user/images/down.gif') }}" alt="..."
                                            class="w-100 h-100">
        
                                    </div>
                                    @if ($data->stage >= 10)
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
                {{-- @endif --}}
                {{-- ---------------------------------------------------------------------------------------- --}}
            </div>
        </div>

    </div>
    {{-- ======================================
                    DATA FIELDS
    ======================================= --}}
    <div id="change-control-fields">
        <div class="container-fluid">

            <!-- Tab links -->
            <div class="cctab">
                <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">General Information</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm2')">Immediate Actions</button>
                {{-- <button class="cctablinks" onclick="openCity(event, 'CCForm3')">Extension</button> --}}
                <button class="cctablinks" onclick="openCity(event, 'CCForm8')">Incident Details</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm9')">Investigation Details</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm4')">CAPA</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm5')">QA Review</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm6')">QA Head/Designee Approval</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm10')">System Suitability Failure Incidence</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm11')">Closure</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm7')">Activity Log</button>
            </div>

            <form action="{{ route('LabIncidentUpdate', $data->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                <div id="step-form">

                    <!-- General information content -->
                    <div id="CCForm1" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="RLS Record Number"><b>Record Number</b></label>
                                        <input disabled type="text" name="record_number" id="record_number"
                                            value="{{ Helpers::getDivisionName(session()->get('division')) }}/LI/{{ Helpers::year($data->created_at) }}/{{ $data->record }}">
                                         {{-- <div class="static">QMS-EMEA/CAPA/{{ date('y') }}/{{ $record_number }}</div> --}}
                                    </div>

                                    {{-- <div class="group-input">
                                        <label for="RLS Record Number"><b>Record Number</b></label>
                                        <input disabled type="text" name="record_number" id="record_number" 
                                            value="---/LI/{{ date('y') }}/{{ $record_number }}"></div> --}}
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Division Code"><b>Site/Location Code</b></label>
                                        <input readonly type="text" name="division_code" {{ $data->stage == 0 || $data->stage == 10 ? "disabled" : "" }} value="{{ Helpers::getDivisionName($data->division_id) }}">
                                        {{-- <div class="static">{{ Helpers::getDivisionName(session()->get('division')) }}</div> --}}
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Initiator"><b>Initiator</b></label>
                                        {{-- <div class="static">{{ Auth::user()->name }}</div> --}}
                                        <input disabled type="text" name="division_code" {{ $data->stage == 0 || $data->stage == 10 ? "disabled" : "" }}
                                            value="{{ $data->initiator_name }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Date Due"><b>Date of Initiation</b></label>
                                        <input disabled type="text" name="intiation_date" {{ $data->stage == 0 || $data->stage == 10 ? "disabled" : "" }}
                                         value="{{ Helpers::getdateFormat($data->intiation_date)}}" >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="group-input">
                                        <label for="search">
                                            Assigned To <span class="text-danger"></span>
                                        </label>
                                        <select id="select-state" placeholder="Select..." name="assign_to" {{ $data->stage == 0 || $data->stage == 10 ? "disabled" : "" }}>
                                            <option value="">Select Assigned To</option>
                                            @foreach ($users as $value)
                                                <option @if ($data->assign_to == $value->id) selected @endif value="{{ $value->id }}">{{ $value->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('assign_to')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Date Due"> Due Date</label>
                                        <div><small class="text-primary">Please mention expected date of completion</small>
                                        </div>
                                        <div class="calenderauditee">
                                            <input type="text" id="due_date" readonly
                                                placeholder="DD-MMM-YYYY" value="{{ Helpers::getdateFormat($data->due_date) }}" {{ $data->stage == 0 || $data->stage == 10 ? 'disabled' : ''}}/>
                                            <input type="date" name="due_date" {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : ''}}  min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input"
                                                oninput="handleDateInput(this, 'due_date')" />
                                        </div>
                                    </div>
                                </div>


                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Short Description">Short Description<span
                                                class="text-danger">*</span></label><span id="rchars">255</span>
                                        characters remaining

                                        <input name="short_desc" id="docname" type="text" value="{{ $data->short_desc }}" maxlength="255" required  {{ $data->stage == 0 || $data->stage == 10 ? "disabled" : "" }}>
                                    </div>
                                    <p id="docnameError" style="color:red">**Short Description is required</p>

                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="priority_data">Priority</label>
                                        <select name="priority_data" placeholder="Select Reference Records"
                                            data-search="false" data-silent-initial-value-set="true"
                                            id="priority_data">
                                            <option value="">--Select--</option>
                                            <option {{ $data->priority_data == 'High' ? 'selected' : '' }}
                                                value="High">High</option>
                                            <option {{ $data->priority_data == 'Medium' ? 'selected' : '' }}
                                                value="Medium">Medium</option>
                                            <option {{ $data->priority_data == 'Low' ? 'selected' : '' }}
                                                value="Low">Low</option>
                                        </select>
                                    </div>
                                </div>

                                 {{-- Table --}}

                                 <div class="col-12">
                                    <div class="group-input">
                                        <label for="Product">Product Name</label>
                                        <input  type="text" id="product_name" name="product_name"  {{ $data->stage == 0 || $data->stage == 13 ? 'disabled' : '' }} value="{{ $data->product_name }}" maxlength="255">
                                    </div>
                                </div>


                        <div class="col-12">
                            <div class="group-input" id="IncidentRow">
                                <label for="audit-incident-grid">
                                    Incident Investigation Report
                                    <button type="button" name="audit-incident-grid" id="IncidentAdd">+</button>
                                    <span class="text-primary" data-bs-toggle="modal"
                                        data-bs-target="#observation-field-instruction-modal"
                                        style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                        (Launch Instruction)
                                    </span>
                                </label>

                                <table class="table table-bordered" id="onservation-incident-table">
                                    <thead>
                                        <tr>
                                            <th>Sr. No.</th>
                                            <th>Name of Product</th>
                                            <th>B No./A.R. No.</th>
                                            <th>Remarks</th>
                                            <th>Action</th>


                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $serialNumber = 1;
                                        @endphp
                                              @foreach ($report->data as  $r)
                                              
                                                    <tr>
                                            {{-- <td style="width: 6%"><input type="text" name="investrecord[0][s_no]" value="{{ $r['s_no']}}"> --}}
                                              <td style="width: 6%"> {{ $serialNumber++ }} </td>
                                           
                                              <td><input type="text"{{ $data->stage == 0 || $data->stage == 10 ? "disabled" : "" }} name="investrecord[{{$loop->index}}][name_of_product]" value=" {{$r['name_of_product']}}">
                                               </td>                                           
                                            <td><input type="text" {{ $data->stage == 0 || $data->stage == 10 ? "disabled" : "" }} name="investrecord[{{$loop->index}}][batch_no]" value="{{$r['batch_no']}}"></td>
                                             <td><input type="text" {{ $data->stage == 0 || $data->stage == 10 ? "disabled" : "" }} name="investrecord[{{$loop->index}}][remarks]" value="{{$r['remarks']}}" ></td>
                                             <td><button class="removeRowBtn">Remove</button>
    
                                        </tr>
                                       @endforeach
                                     </tbody>
                                </table>
                </div>
                            </div>
    
    
    
                  <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        var selectField = document.getElementById('Facility_Equipment');
                        var inputsToToggle = [];
    
                        // Add elements with class 'facility-name' to inputsToToggle
                        var facilityNameInputs = document.getElementsByClassName('facility-name');
                        for (var i = 0; i < facilityNameInputs.length; i++) {
                            inputsToToggle.push(facilityNameInputs[i]);
                        }
    
                        // Add elements with class 'id-number' to inputsToToggle
                        var idNumberInputs = document.getElementsByClassName('id-number');
                        for (var j = 0; j < idNumberInputs.length; j++) {
                            inputsToToggle.push(idNumberInputs[j]);
                        }
    
                        // Add elements with class 'remarks' to inputsToToggle
                        var remarksInputs = document.getElementsByClassName('remarks');
                        for (var k = 0; k < remarksInputs.length; k++) {
                            inputsToToggle.push(remarksInputs[k]);
                        }
    
    
                        selectField.addEventListener('change', function() {
                            var isRequired = this.value === 'yes';
                            console.log(this.value, isRequired, 'value');
    
                            inputsToToggle.forEach(function(input) {
                                input.required = isRequired;
                                console.log(input.required, isRequired, 'input req');
                            });
    
                            document.getElementById('facilityRow').style.display = isRequired ? 'block' : 'none';
                            // Show or hide the asterisk icon based on the selected value
                            var asteriskIcon = document.getElementById('asteriskInvi');
                            asteriskIcon.style.display = isRequired ? 'inline' : 'none';
                        });
                    });
                    </script>
    
    
    <script>
        $(document).ready(function() {
            let investdetails = 1;
            $('#IncidentAdd').click(function(e) {
                function generateTableRow(serialNumber) {
                    var users = @json($users);
    
                    var html =
                        '<tr>' +
                        '<td><input type="text"  name="investrecord[][s_no]" value="' + serialNumber +
                        '" disabled></td>' +
                        '<td><input type="text" name="investrecord['+ investdetails +'][name_of_product]" value=""></td/>' +
                        '<td><input type="text" name="investrecord['+ investdetails +'][batch_no]" value=""></td>' +
                        '<td><input type="text" name="investrecord['+ investdetails +'][remarks]" value=""></td>' +
                        '<td><button class="removeRowBtn">Remove</button></td>' +
    
    
                        '</tr>';
    
                    for (var i = 0; i < users.length; i++) {
                        html += '<option value="' + users[i].id + '">' + users[i].name + '</option>';
                    }
    
                    html += '</select></td>' +
    
                        '</tr>';

                        investdetails++;
                    return html;
                }
    
                var tableBody = $('#onservation-incident-table tbody');
                var rowCount = tableBody.children('tr').length;
                var newRow = generateTableRow(rowCount + 1);
                tableBody.append(newRow);
            });
            $(document).on('click', '.removeRowBtn', function() {
        $(this).closest('tr').remove();
    });
        });
    </script>
    
    
    
    
    
                            {{-- new added table --}}

                        {{-- New Added --}}
                        <div class="col-lg-12">
                            <div class="group-input" id="incident_involved_others_gi">
                                <label for="incident_involved_others_gi">Instrument Involved<span
                                        class="text-danger d-none">*</span></label>
                                <textarea {{ $data->stage == 0 || $data->stage == 10 ? "disabled" : "" }} name="incident_involved_others_gi" class="tiny">{{ $data->incident_involved_others_gi }}</textarea>
                            </div>

                        </div>

                        <div class="col-lg-4">
                            <div class="group-input" id="stage_stage_gi">
                                <label for="stage_stage_gi">Stage<span
                                        class="text-danger d-none">*</span></label>
                                <input type="text" name="stage_stage_gi" {{ $data->stage == 0 || $data->stage == 10 ? "disabled" : "" }} value="{{ $data->stage_stage_gi }}">
                            </div>

                        </div><br>

                        <div class="col-lg-4">
                            <div class="group-input" id="incident_stability_cond_gi">
                                <label for="incident_stability_cond_gi">Stability Condition (If Applicable)<span
                                        class="text-danger d-none">*</span></label>
                                <input type="text" name="incident_stability_cond_gi" {{ $data->stage == 0 || $data->stage == 10 ? "disabled" : "" }} value="{{ $data->incident_stability_cond_gi }}">
                            </div>

                        </div>

                        <div class="col-lg-4">
                            <div class="group-input" id="incident_interval_others_gi">
                                <label for="incident_interval_others_gi">Interval (If Applicable)<span
                                        class="text-danger d-none">*</span></label>
                                <input type="text" name="incident_interval_others_gi" {{ $data->stage == 0 || $data->stage == 10 ? "disabled" : "" }} value="{{ $data->incident_interval_others_gi }}">
                            </div>

                        </div>

                        <div class="col-lg-6">
                            <div class="group-input" id="test_gi">
                                <label for="test_gi">Test<span
                                        class="text-danger d-none">*</span></label>
                                <input type="text" name="test_gi" {{ $data->stage == 0 || $data->stage == 10 ? "disabled" : "" }} value="{{ $data->test_gi }}" >
                            </div>

                        </div>
                          
                        
                        {{-- <div class="col-lg-6">
                            <div class="group-input" id="incident_date_analysis_gi">
                                <label for="incident_date_analysis_gi">Date of Analysis<span
                                        class="text-danger d-none">*</span></label>
                                <input type="date" name="incident_date_analysis_gi" id="incident_date_analysis_gi" value="{{ $data->incident_date_analysis_gi }}">
                            </div>

                        </div>
                        <script>
                            function formatDate(input) {
                                var dateValue = new Date(input.value);
                                var day = dateValue.getDate();
                                var month = dateValue.toLocaleString('default', { month: 'long' });
                                var year = dateValue.getFullYear();
                                var formattedDate = day + '-' + month + '-' + year;
                                input.value = formattedDate;
                            }
                        </script> --}}

                        <div class="col-lg-6 new-date-data-field">
                            <div class="group-input input-date">
                                <label for="Date Due"> Date Of Analysis</label>
                                <div><small class="text-primary">Please mention expected date of completion</small>
                                </div>
                                <div class="calenderauditee">
                                    <input type="text" id="incident_date_analysis_gi" readonly
                                        placeholder="DD-MMM-YYYY" value="{{ Helpers::getdateFormat($data->incident_date_analysis_gi) }}"/>
                                    <input type="date" name="incident_date_analysis_gi" {{ $data->stage == 0 || $data->stage == 10 ? "disabled" : "" }}  class="hide-input"
                                        oninput="handleDateInput(this, 'incident_date_analysis_gi')" />
                                </div>
                            </div>
                        </div>
                        

                        

                        <div class="col-lg-6">
                            <div class="group-input" id="incident_specification_no_gi">
                                <label for="Incident_specification_no">Specification Number<span
                                        class="text-danger d-none">*</span></label>
                                <input type="text" name="incident_specification_no_gi" {{ $data->stage == 0 || $data->stage == 10 ? "disabled" : "" }} value="{{ $data->incident_specification_no_gi }}">
                            </div>

                        </div>
                        <div class="col-lg-6">
                            <div class="group-input" id="incident_stp_no_gi">
                                <label for="incident_stp_no_gi">STP Number<span
                                        class="text-danger d-none">*</span></label>
                                <input type="text" name="incident_stp_no_gi"  {{ $data->stage == 0 || $data->stage == 10 ? "disabled" : "" }} value="{{ $data->incident_stp_no_gi }}">
                            </div>

                        </div>

                        {{-- <div class="col-lg-6">
                            <div class="group-input" id="Incident_name_analyst_no_gi">
                                <label for="Incident_name_analyst_no">Name Of Analyst<span
                                        class="text-danger d-none">*</span></label>
                                <input type="text" name="Incident_name_analyst_no_gi" value="{{ $data->Incident_name_analyst_no_gi }}">
                            </div>

                        </div> --}}

                        {{-- <div class="col-lg-6">
                            <div class="group-input" id="incident_date_incidence_gi">
                                <label for="Incident_date_incidence">Date Of Incidence akash<span
                                        class="text-danger d-none">*</span></label>
                                <input type="date" name="incident_date_incidence_gi" value="{{ $data->incident_date_incidence_gi }}">
                            </div>

                        </div> --}}

                        <div class="col-lg-12 new-date-data-field">
                            <div class="group-input input-date">
                                <label for="Date Due">Date Of Incidence</label>
                                <div><small class="text-primary">Please mention expected date of completion</small>
                                </div>
                                <div class="calenderauditee">
                                    <input type="text" id="incident_date_incidence_gi" readonly
                                        placeholder="DD-MMM-YYYY" value="{{ Helpers::getdateFormat($data->incident_date_incidence_gi) }}"/>
                                    <input type="date" name="incident_date_incidence_gi" {{ $data->stage == 0 || $data->stage == 10 ? "disabled" : "" }} class="hide-input"
                                        oninput="handleDateInput(this, 'incident_date_incidence_gi')" />
                                </div>
                            </div>
                        </div>
                        
                        

                        <div class="col-lg-12">
                            <div class="group-input" id="description_incidence_gi">
                                <label for="Description_incidence"> Description Of Incidence<span
                                        class="text-danger d-none">*</span></label>
                                <textarea name="description_incidence_gi" {{ $data->stage == 0 || $data->stage == 10 ? "disabled" : "" }} class="tiny">{{ $data->description_incidence_gi }}</textarea>
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="group-input">
                                <label for="search">
                                    Analyst Name <span class="text-danger"></span>
                                </label>
                                <select id="select-state" placeholder="Select..." name="analyst_sign_date_gi" {{ $data->stage == 0 || $data->stage == 10 ? "disabled" : "" }}>
                                    <option value="">Select a value</option>
                                    @foreach ($users as $key=> $value)
                                        <option  @if ($data->analyst_sign_date_gi == $value->id) selected @endif  value="{{ $value->id }}">{{ $value->name }}</option>
                                    @endforeach
                                </select>
                                <input type="hidden" id="analyst_sign_date_gi_changed" name="analyst_sign_date_gi_changed" value="0">
                                @error('analyst_sign_date_gi')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="group-input">
                                <label for="search">
                                    Section Head Name <span class="text-danger"></span>
                                </label>
                                <select id="select-state" placeholder="Select..." name="section_sign_date_gi" {{ $data->stage == 0 || $data->stage == 10 ? "disabled" : "" }} onchange="markFieldAsChanged('section_sign_date_gi_changed')">
                                    {{-- <option value="">Select a value</option> --}}
                                    @foreach ($users as $key => $value)
                                        <option @if ($data->section_sign_date_gi == $value->id) selected @endif value="{{ $value->id }}">{{ $value->name }}</option>
                                    @endforeach
                                </select>
                                <input type="hidden" id="section_sign_date_gi_changed" name="section_sign_date_gi_changed" value="0">
                                @error('section_sign_date_gi')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <script>
                            document.addEventListener('DOMContentLoaded', (event) => {
                                const originalValue = document.querySelector('#select-state').value;
                                document.querySelector('#section_sign_date_gi_changed').value = '0';
                            });
                        
                            function markFieldAsChanged(hiddenInputId) {
                                document.getElementById(hiddenInputId).value = '1';
                            }
                        </script>
                        
                        

                


                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="severity-level">Severity Level</label>
                                        <span class="text-primary">Severity levels in a QMS record gauge issue seriousness, guiding priority for corrective actions. Ranging from low to high, they ensure quality standards and mitigate critical risks.</span>
                                        <select name="severity_level2" {{ $data->stage == 0 || $data->stage == 10 ? "disabled" : "" }} >
                                            <option value="0">-- Select --</option>
                                            <option @if ($data->severity_level2=='minor') selected @endif  value="minor">Minor</option>
                                            <option @if ($data->severity_level2=='major') selected @endif value="major">Major</option>
                                            <option @if ($data->severity_level2=='critical') selected @endif value="critical">Critical</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- <div class="col-lg-6">
                             <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Date of Occurance">Date of Occurance</label>
                                        <input type="date" name="occurance_date" value="{{ $data->occurance_date }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Due Date">Due Date</label>
                                        <input type="date" name="due_date" value="{{ $data->due_date }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Assigned to">Assigned to</label>
                                        <select name="assigend">
                                            @foreach($users as $value)
                                                <option value="{{ $value->id }}">{{ $value->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                </div>-->
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Incident Category">Incident Category</label>
                                        <select {{ $data->stage == 0 || $data->stage == 10 ? "disabled" : "" }} name="Incident_Category">
                                            <option value="">Enter Your Selection Here</option>
                                            <option value="Biological" @if ($data->Incident_Category== 'Biological') selected @endif>
                                                Biological
                                            </option>
                                            <option value="Chemical" @if ($data->Incident_Category== 'Chemical') selected @endif>
                                                Chemical
                                            </option>
                                            <option value="Others" @if ($data->Incident_Category== 'Others') selected @endif>
                                                Others
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                            <div class="group-input" id="initiated_through_req1">
                                                <label for="Incident_Category_others">Others<span
                                                        class="text-danger d-none">*</span></label>
                                                <textarea name="Incident_Category_others" {{ $data->stage == 0 || $data->stage == 10 ? "disabled" : "" }} class="tiny">{{ $data->Incident_Category_others }}</textarea>
                                            </div>
                                        </div>
                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="Invocation Type">Invocation Type</label>
                                        <select  name="Invocation_Type" {{ $data->stage == 0 || $data->stage == 10 ? "disabled" : "" }}>
                                            <option value="">Enter Your Selection Here</option>
                                            <option value="1" @if ($data->Invocation_Type== '1') selected @endif>1
                                            </option>
                                            <option value="2" @if ($data->Invocation_Type== '2') selected @endif>2
                                            </option>
                                            <option value="3" @if ($data->Invocation_Type== '3') selected @endif>3
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="Initial Attachments">Initial Attachment</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                        {{-- <input type="file" id="myfile" name="Initial_Attachment" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}
                                            value="{{ $data->Initial_Attachment }}"> --}}
                                            <div class="file-attachment-field">
                                                <div class="file-attachment-list" id="attachments_gi">
                                                    @if ($data->attachments_gi)
                                                    @foreach (json_decode($data->attachments_gi) as $file)
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
                                                    <input {{ $data->stage == 0 || $data->stage == 10 ? "disabled" : "" }} type="file" id="attachments_gi" name="attachments_gi[]"
                                                        oninput="addMultipleFiles(this, 'attachments_gi')" multiple>
                                                </div>
                                            </div>
                                    </div>
                                </div>

                                



                            </div>
                            <div class="button-block">
                                <button type="submit" id="ChangesaveButton" class="saveButton" {{ $data->stage == 0 || $data->stage == 10 ? "disabled" : "" }}>Save</button>
                                <button type="button" id="ChangeNextButton" class="nextButton">Next</button>
                                <button type="button"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}"> Exit </a> </button>
                            </div>
                        </div>
                    </div>

                    <div id="CCForm2" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Immediate_action">Immediate Action</label>
                                        <textarea name="immediate_action_ia" {{ $data->stage == 0 || $data->stage == 10 ? "disabled" : "" }} class="tiny">{{$data->immediate_action_ia}}</textarea>
                                    </div>
                                </div>
                                
                                {{-- <div class="col-lg-6">
                                    <div class="group-input" id="immediate_date_ia">
                                        <label for="immediate_date_ia">Analyst Sign/Date akash mishra<span
                                                class="text-danger d-none">*</span></label>
                                        <input type="date" name="immediate_date_ia" value="{{$data->immediate_date_ia}}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input" id="section_date_ia">
                                        <label for="section_date_ia">Section Head Sign/Date<span
                                                class="text-danger d-none">*</span></label>
                                        <input type="date" name="section_date_ia" value="{{$data->section_date_ia}}">
                                    </div>
                                </div> --}}
                               <div class="col-12">
                                <div class="group-input">
                                    <label for="detail investigation ">Detail Investigation / Probable Root Cause</label>
                                <textarea name="details_investigation_ia" {{ $data->stage == 0 || $data->stage == 10 ? "disabled" : "" }} class="tiny">{{$data->details_investigation_ia}}</textarea>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="group-input">
                                <label for="proposed corrective action ">Proposed Corrective Action/Corrective Action Taken</label>
                            <textarea name="proposed_correctivei_ia" {{ $data->stage == 0 || $data->stage == 10 ? "disabled" : "" }} class="tiny">{{$data->proposed_correctivei_ia}}</textarea>
                        </div>
                     </div>


                     <div class="col-12">
                        <div class="group-input">
                            <label for="Repeat Analysis Plan ">Repeat Analysis Plan</label>
                        <textarea name="repeat_analysis_plan_ia" {{ $data->stage == 0 || $data->stage == 10 ? "disabled" : "" }} class="tiny">{{$data->repeat_analysis_plan_ia}}</textarea>
                      </div>
                         </div>


                          {{-- selection field --}}
                
                          
                         
                {{-- selection field --}}
                <div class="col-12">
                    <div class="group-input">
                        <label for="Result Of Repeat Analysis ">Result Of Repeat Analysis</label>
                    <textarea name="result_of_repeat_analysis_ia" {{ $data->stage == 0 || $data->stage == 10 ? "disabled" : "" }} class="tiny">{{$data->result_of_repeat_analysis_ia}}</textarea>
                </div>
            </div>
            <div class="col-12">
                <div class="group-input">
                    <label for="Corrective and Preventive Action">Corrective and Preventive Action</label>
                <textarea name="corrective_and_preventive_action_ia" {{ $data->stage == 0 || $data->stage == 10 ? "disabled" : "" }} class="tiny">{{$data->corrective_and_preventive_action_ia}}</textarea>
            </div>
        </div>
        <div class="col-12">
            <div class="group-input">
                <label for="CAPA Number">CAPA Number</label>
            <input type="text" name="capa_number_im" {{ $data->stage == 0 || $data->stage == 10 ? "disabled" : "" }} value="{{$data->capa_number_im}}">
        </div>
         </div>

         <div class="col-12">
            <div class="group-input">
                <label for="Investigation Summary">Investigation Summary</label>
            <textarea name="investigation_summary_ia" {{ $data->stage == 0 || $data->stage == 10 ? "disabled" : "" }} class="tiny">{{$data->investigation_summary_ia}}</textarea>
        </div>
    </div>



    {{-- type of incidence --}}

    <div class="col-lg-12">
        <div class="group-input">
            <label for="Type Of Incidence"><b>Type Of Incidence</b></label>
            <select name="type_incidence_ia" {{ $data->stage == 0 || $data->stage == 10 ? "disabled" : "" }} id="initiator_group">
                <option value="">-- Select --</option>
                <option value="Analyst Error" {{ $data->type_incidence_ia == 'Analyst Error' ? 'selected' : '' }}>Analyst Error</option>
                <option value="Instrument Error" {{ $data->type_incidence_ia == 'Instrument Error' ? 'selected' : '' }}>Instrument Error</option>
                <option value="Atypical Error" {{ $data->type_incidence_ia == 'Atypical Error' ? 'selected' : '' }}>Atypical Error</option>
            </select>
        </div>
    </div>
    
    {{-- type of incidence --}}


                {{-- selection field --}}
                
                <div class="col-md-6">
                    <div class="group-input">
                        <label for="search">
                            Investigator(QC) <span class="text-danger"></span>
                        </label>
                        <select id="select-state" placeholder="Select..." name="investigator_qc" {{ $data->stage == 0 || $data->stage == 10 ? "disabled" : "" }}>
                            <option value="">Select a value</option>
                            @foreach ($users as $key=> $value)
                                <option  @if ($data->investigator_qc == $value->id) selected @endif  value="{{ $value->id }}">{{ $value->name }}</option>
                            @endforeach
                        </select>
                        @error('investigator_qc')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="group-input">
                        <label for="search">
                            QC Review <span class="text-danger"></span>
                        </label>
                        <select id="select-state" placeholder="Select..." name="qc_review_to" {{ $data->stage == 0 || $data->stage == 10 ? "disabled" : "" }}>
                            <option value="">Select a value</option>
                            @foreach ($users as $key=> $value)
                                <option  @if ($data->qc_review_to == $value->id) selected @endif  value="{{ $value->id }}">{{ $value->name }}</option>
                            @endforeach
                        </select>
                        @error('qc_review_to')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                 {{-- <div class="col-md-4">
                    <div class="group-input">
                        <label for="search">
                            QC Approved By <span class="text-danger"></span>
                        </label>
                        <select id="select-state" placeholder="Select..." name="qc_approved_to" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}>
                            <option value="">Select a value</option>
                            @foreach ($users as $key=> $value)
                                <option  @if ($data->qc_approved_to == $value->id) selected @endif  value="{{ $value->id }}">{{ $value->name }}</option>
                            @endforeach
                        </select>
                        @error('qc_approved_to')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div> --}}

                {{-- selection field --}}



                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Attachments">Attachments</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                        {{-- <input type="file" id="myfile" name="Attachments"> --}}
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="attachments_ia">
                                                @if ($data->attachments_ia)
                                                @foreach (json_decode($data->attachments_ia) as $file)
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
                                                <input {{ $data->stage == 0 || $data->stage == 10 ? "disabled" : "" }} type="file" id="attachments_ia" name="attachments_ia[]"
                                                    oninput="addMultipleFiles(this, 'attachments_ia')" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="button-block">
                                <button type="submit" class="saveButton">Save</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white"> Exit </a> </button>
                            </div>
                        </div>
                    </div>

                     {{-- extension --}}
                     <div id="CCForm3" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                         <div class="row">
                             <div class="group-input">
                                 <div class="col-12 sub-head">
                                     First Extension
                                 </div>

                             </div>

                             <div class="col-12">
                                 <div class="group-input">
                                     <label for="Incident Details">Reason For Extension</label>
                                     <textarea name="reasoon_for_extension_e" class="tiny">{{$data->reasoon_for_extension_e}}</textarea>
                                 </div>
                             </div>
 
                             {{-- <div class="col-6">
                                 <div class="group-input">
                                 <label for="extension date">Extension Date (if required)</label>
                                 <input type="date" name="extension_date_esc" id="extension_date" value="{{$data->extension_date_esc}}">
                                 </div>
                             </div> --}}

                             <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Date Due"> Extension Date</label>
                                    <div><small class="text-primary">Please mention expected date of completion</small>
                                    </div>
                                    <div class="calenderauditee">
                                        <input type="text" id="extension_date_esc" readonly
                                            placeholder="DD-MMM-YYYY" value="{{ Helpers::getdateFormat($data->extension_date_esc) }}"/>
                                        <input type="date" name="extension_date_esc"  class="hide-input"
                                            oninput="handleDateInput(this, 'extension_date_esc')" />
                                    </div>
                                </div>
                            </div>



                            
                                
                             {{-- <div class="col-6">
                                 <div class="group-input">
                                 <label for="extension date">Extension Initiator Date</label>
                                 <input type="date" name="extension_date_initiator" id="extension_date" value="{{$data->extension_date_initiator}}">
                                 </div>
                             </div> --}}


                             <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Date Due"> Extension Initiator Date</label>
                                    <div><small class="text-primary">Please mention expected date of completion</small>
                                    </div>
                                    <div class="calenderauditee">
                                        <input type="text" id="extension_date_initiator" readonly
                                            placeholder="DD-MMM-YYYY" value="{{ Helpers::getdateFormat($data->extension_date_initiator) }}" />
                                        <input type="date" name="extension_date_initiator" class="hide-input"
                                            oninput="handleDateInput(this, 'extension_date_initiator')" />
                                    </div>
                                </div>
                            </div>
                             {{-- person field --}}

                             {{-- <div class="col-md-6">
                                <div class="group-input">
                                    <label for="search">
                                        Extension HOD <span class="text-danger"></span>
                                    </label>
                                    <select id="select-state" placeholder="Select..." name="assign_to" >
                                        <option value="">Select a value</option>
                                        @foreach ($users as $key=> $value)
                                            <option  @if ($data->assign_to == $value->id) selected @endif  value="{{ $value->id }}">{{ $value->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('assign_to')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div> --}}

                            {{-- <div class="col-md-6">
                                <div class="group-input">
                                    <label for="search">
                                        Extension Approved By <span class="text-danger"></span>
                                    </label>
                                    <select id="select-state" placeholder="Select..." name="assign_to" >
                                        <option value="">Select a value</option>
                                        @foreach ($users as $key=> $value)
                                            <option  @if ($data->assign_to == $value->id) selected @endif  value="{{ $value->id }}">{{ $value->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('assign_to')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div> --}}






                           </div>
                           <div class="row">
                                <div class="group-input">
                                      <div class="col-12 sub-head">
                                    Second Extension
                                    </div>
                                </div>
                              <div class="col-12">
                                  <div class="group-input">
                                 <label for="reason for extension sc">Reason For Extension</label>
                                 <textarea name="reasoon_for_extension_esc" class="tiny">{{$data->reasoon_for_extension_esc}}</textarea>
                                 </div>
                              </div>
 
                           
                              {{-- <div class="col-6">
                                 <div class="group-input">
                                  <label for="extension date">Extension Date (if required)</label>
                                   <input type="date" name="extension_date_e" id="extension_date__sc" value="{{$data->extension_date_e}}">
                                 </div>
                              </div> --}}

                              <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Date Due"> Extension Date</label>
                                    <div><small class="text-primary">Please mention expected date of completion</small>
                                    </div>
                                    <div class="calenderauditee">
                                        <input type="text" id="extension_date_e" readonly
                                            placeholder="DD-MMM-YYYY" value="{{ Helpers::getdateFormat($data->extension_date_e) }}" />
                                        <input type="date" name="extension_date_e"  class="hide-input"
                                            oninput="handleDateInput(this, 'extension_date_e')" />
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Date Due"> Extension Initiator Date</label>
                                    <div><small class="text-primary">Please mention expected date of completion</small>
                                    </div>
                                    <div class="calenderauditee">
                                        <input type="text" id="extension_date_idsc" readonly
                                            placeholder="DD-MMM-YYYY" value="{{ Helpers::getdateFormat($data->extension_date_idsc) }}" >
                                        <input type="date" name="extension_date_idsc"  class="hide-input"
                                            oninput="handleDateInput(this, 'extension_date_idsc')" />
                                    </div>
                                </div>
                            </div>

                                 {{-- <div class="col-md-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="extension_date_idsc">Extension Initiator Date <span class="text-danger"></span></label> --}}
                                        {{-- <p class="text-primary">Last date this record should be closed by</p> --}}
                                
                                        {{-- <div class="calenderauditee">
                                            <input type="date" id="extension_date_idsc_display" 
                                                placeholder="DD-MMM-YYYY" />
                                            <input type="date" id="extension_date_idsc" name="extension_date_idsc"
                                                class="hide-input" oninput="handleDateInput(this)" />
                                        </div>
                                        
                                    </div> --}}
                      {{--           </div> --}}
                      


                                    
    
                                                {{-- person field --}}
                                                

                                                {{-- <div class="col-md-6">
                                                    <div class="group-input">
                                                        <label for="search">
                                                            Extension Approved By <span class="text-danger"></span>
                                                        </label>
                                                        <select id="select-state" placeholder="Select..." name="qc_approved_to" >
                                                            <option value="">Select a value</option>
                                                            @foreach ($users as $key=> $value)
                                                                <option  @if ($data->qc_approved_to == $value->id) selected @endif  value="{{ $value->id }}">{{ $value->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('qc_approved_to')
                                                            <p class="text-danger">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                </div> --}}

                           </div>

                           {{-- third section --}}

                           <div class="row">
                             <div class="group-input">
                                   <div class="col-12 sub-head">
                                 Third Extension
                                 </div>
                             </div>
                           <div class="col-12">
                               <div class="group-input">
                              <label for="reason for extension tc">Reason For Extension</label>
                              <textarea name="reasoon_for_extension_tc" class="tiny">{{$data->reasoon_for_extension_tc}}</textarea>
                              </div>
                           </div>
 
                        
                           
                           <div class="col-lg-6 new-date-data-field">
                            <div class="group-input input-date">
                                <label for="Date Due"> Extension Date</label>
                                <div><small class="text-primary">Please mention expected date of completion</small>
                                </div>
                                <div class="calenderauditee">
                                    <input type="text" id="extension_date__tc" readonly
                                        placeholder="DD-MMM-YYYY" value="{{ Helpers::getdateFormat($data->extension_date__tc) }}"/>
                                    <input type="date" name="extension_date__tc"   class="hide-input"
                                        oninput="handleDateInput(this, 'extension_date__tc')" />
                                </div>
                            </div>
                        </div>
                         
                              

                              <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Date Due"> Extension Initiator Date</label>
                                    <div><small class="text-primary">Please mention expected date of completion</small>
                                    </div>
                                    <div class="calenderauditee">
                                        <input type="text" id="extension_date_idtc" readonly
                                            placeholder="DD-MMM-YYYY" value="{{ Helpers::getdateFormat($data->extension_date_idtc) }}" />
                                        <input type="date" name="extension_date_idtc"  class="hide-input"
                                            oninput="handleDateInput(this, 'extension_date_idtc')" />
                                    </div>
                                </div>
                            </div>
                                    {{-- person field --}}

                                    <div class="col-md-6">
                                        {{-- <div class="group-input">
                                            <label for="search">
                                                Extension Approved By QA <span class="text-danger"></span>
                                            </label>
                                            <select id="select-state" placeholder="Select..." name="assign_to" >
                                                <option value="">Select a value</option>
                                                @foreach ($users as $key=> $value)
                                                    <option  @if ($data->assign_to == $value->id) selected @endif  value="{{ $value->id }}">{{ $value->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('assign_to')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div> --}}
                                    </div>

                                    <div class="col-md-4">
                                        {{-- <div class="group-input">
                                            <label for="search">
                                                Extension Approved By CQA <span class="text-danger"></span>
                                            </label>
                                            <select id="select-state" placeholder="Select..." name="assign_to" >
                                                <option value="">Select a value</option>
                                                @foreach ($users as $key=> $value)
                                                    <option  @if ($data->assign_to == $value->id) selected @endif  value="{{ $value->id }}">{{ $value->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('assign_to')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div> --}}
                                    </div>
                        </div>
                        <div class="col-12">
                         <div class="group-input">
                             <label for="Attachments">Extension Attachments</label>
                             <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                             <div class="file-attachment-field">
                                <div class="file-attachment-list" id="extension_attachments_e">
                                    @if ($data->extension_attachments_e)
                                    @foreach (json_decode($data->extension_attachments_e) as $file)
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
                                    <input  type="file" id="extension_attachments_e" name="extension_attachments_e[]"
                                        oninput="addMultipleFiles(this, 'extension_attachments_e')" multiple>
                                </div>
                            </div>
                         </div>
                     </div>
                     <div class="button-block">
                         <button type="submit" class="saveButton">Save</button>
                         <button type="button" class="backButton" onclick="previousStep()">Back</button>
                         <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                         <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white"> Exit </a> </button>
                     </div>



                        </div>
                     </div>





                    <!-- Incident Details content -->
                    <div id="CCForm8" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Incident Details">Incident Details</label>
                                        <textarea name="Incident_Details" {{ $data->stage == 0 || $data->stage == 10 ? "disabled" : "" }} class="tiny">{{ $data->Incident_Details }}</textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Document Details ">Document Details</label>
                                        <textarea name="Document_Details" {{ $data->stage == 0 || $data->stage == 10 ? "disabled" : "" }} class="tiny">{{ $data->Document_Details }}</textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Instrument Details">Instrument Details</label>
                                        <textarea name="Instrument_Details" {{ $data->stage == 0 || $data->stage == 10 ? "disabled" : "" }} class="tiny">{{ $data->Instrument_Details }}</textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Involved Personnel">Involved Personnel</label>
                                        <textarea name="Involved_Personnel" {{ $data->stage == 0 || $data->stage == 10 ? "disabled" : "" }} class="tiny">{{ $data->Involved_Personnel }}</textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Product Details,If Any">Product Details,If Any</label>
                                        <textarea name="Product_Details" {{ $data->stage == 0 || $data->stage == 10 ? "disabled" : "" }} class="tiny">{{ $data->Product_Details }}</textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Supervisor Review Comments">Supervisor Review Comments</label>
                                        <textarea name="Supervisor_Review_Comments" {{ $data->stage == 0 || $data->stage == 10 ? "disabled" : "" }} class="tiny">{{ $data->Supervisor_Review_Comments }}</textarea>
                                    </div>
                                </div>
                                
                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="ccf_attachments">Attachment</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                        {{-- <input type="file" id="myfile" name="Initial_Attachment" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}
                                            value="{{ $data->Initial_Attachment }}"> --}}
                                            <div class="file-attachment-field">
                                                <div class="file-attachment-list" id="ccf_attachments">
                                                    @if ($data->ccf_attachments)
                                                    @foreach (json_decode($data->ccf_attachments) as $file)
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
                                                <div class="add-btn ">
                                                    <div>Add</div>
                                                    <input {{ $data->stage == 0 || $data->stage == 10 ? "disabled" : "" }} type="file" id="ccf_attachments" name="ccf_attachments[]"
                                                        oninput="addMultipleFiles(this, 'ccf_attachments')" multiple>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                                {{-- <div class="col-12 sub-head">
                                    Cancelation
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Cancelation Remarks">Cancelation Remarks</label>
                                        <textarea name="Cancelation_Remarks" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}>{{ $data->Cancelation_Remarks }}</textarea>
                                    </div>
                                </div> --}}
                            </div>
                            <div class="button-block">
                                <button type="submit" class="saveButton" {{ $data->stage == 0 || $data->stage == 10 ? "disabled" : "" }}>Save</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                <button type="button"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}"> Exit </a> </button>
                            </div>
                        </div>
                    </div>

                    <!-- Investigation Details content -->
                    <div id="CCForm9" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                {{-- <div class="col-12 sub-head">
                                    Questionnaire
                                </div>  --}}
                                {{-- <div class="col-12">
                                    <div class="group-input">
                                        <label for="INV Questionnaire">INV Questionnaire</label>
                                        <div class="static">Question datafield</div>
                                    </div>
                                </div> --}}
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Inv Attachments">Inv Attachment</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                        {{-- <input type="file" id="myfile" name="Inv_Attachment" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}
                                            value="{{ $data->Inv_Attachment }}"> --}}
                                            <div class="file-attachment-field">
                                                <div class="file-attachment-list" id="Inv_Attachment">
                                                    @if ($data->Inv_Attachment)
                                                    @foreach (json_decode($data->Inv_Attachment) as $file)
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
                                                    <input {{ $data->stage == 0 || $data->stage == 10 ? "disabled" : "" }} type="file" id="myfile" name="Inv_Attachment[]"
                                                        oninput="addMultipleFiles(this, 'Inv_Attachment')" multiple>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Investigation Details ">Investigation Details</label>
                                        <textarea name="Investigation_Details" {{ $data->stage == 0 || $data->stage == 10 ? "disabled" : "" }} class="tiny">{{ $data->Investigation_Details }}</textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Action Taken">Action Taken</label>
                                        <textarea name="Action_Taken" {{ $data->stage == 0 || $data->stage == 10 ? "disabled" : "" }} class="tiny">{{ $data->Action_Taken }}</textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Root Cause">Root Cause</label>
                                        <textarea name="Root_Cause" {{ $data->stage == 0 || $data->stage == 10 ? "disabled" : "" }} class="tiny">{{ $data->Root_Cause }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="button-block">
                                <button type="submit" class="saveButton" {{ $data->stage == 0 || $data->stage == 10 ? "disabled" : "" }}>Save</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                <button type="button"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}"> Exit </a> </button>
                            </div>
                        </div>
                    </div>

                    <!-- CAPA content -->
                    <div id="CCForm4" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                               <div class="col-12">
                                    <div class="group-input">
                                        <label for="Currective Action">Capa</label>
                                        <textarea name="capa_capa" {{ $data->stage == 0 || $data->stage == 10 ? "disabled" : "" }} class="tiny">{{ $data->capa_capa }}</textarea>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Currective Action">Corrective Action</label>
                                        <textarea name="Currective_Action" {{ $data->stage == 0 || $data->stage == 10 ? "disabled" : "" }} class="tiny">{{ $data->Currective_Action }}</textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Preventive Action">Preventive Action</label>
                                        <textarea name="Preventive_Action" {{ $data->stage == 0 || $data->stage == 10 ? "disabled" : "" }} class="tiny">{{ $data->Preventive_Action }}</textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Corrective & Preventive Action">Corrective & Preventive Action</label>
                                        <textarea name="Corrective_Preventive_Action" {{ $data->stage == 0 || $data->stage == 10 ? "disabled" : "" }} class="tiny">{{ $data->Corrective_Preventive_Action }}</textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="CAPA Attachments">CAPA Attachment</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                        {{-- <input type="file" id="myfile" name="CAPA_Attachment" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}
                                            value="{{ $data->CAPA_Attachment }}"> --}}
                                            <div class="file-attachment-field">
                                                <div class="file-attachment-list" id="CAPA_Attachment">
                                                    @if ($data->CAPA_Attachment)
                                                    @foreach (json_decode($data->CAPA_Attachment) as $file)
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
                                                    <input {{ $data->stage == 0 || $data->stage == 10 ? "disabled" : "" }} type="file" id="myfile" name="CAPA_Attachment[]"
                                                        oninput="addMultipleFiles(this, 'CAPA_Attachment')" multiple>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                            <div class="button-block">
                                <button type="submit" class="saveButton" {{ $data->stage == 0 || $data->stage == 10 ? "disabled" : "" }}>Save</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                <button type="button"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}"> Exit </a> </button>
                            </div>
                        </div>
                    </div>

                    <!-- QA Review content -->
                    <div id="CCForm5" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="QA Review Comments">QA Review Comments</label>
                                        <textarea name="QA_Review_Comments" {{ $data->stage == 0 || $data->stage == 10 ? "disabled" : "" }} class="tiny">{{ $data->QA_Review_Comments }}</textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="QA Head Attachments">QA Review Attachment</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                        {{-- <input type="file" id="myfile" name="QA_Head_Attachment" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}
                                            value="{{ $data->QA_Head_Attachment }}"> --}}
                                            <div class="file-attachment-field">
                                                <div class="file-attachment-list" id="QA_Head_Attachment">
                                                    @if ($data->QA_Head_Attachment)
                                                    @foreach (json_decode($data->QA_Head_Attachment) as $file)
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
                                                    <input {{ $data->stage == 0 || $data->stage == 10 ? "disabled" : "" }} type="file" id="myfile" name="QA_Head_Attachment[]"
                                                        oninput="addMultipleFiles(this, 'QA_Head_Attachment')" multiple>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                            <div class="button-block">
                                <button type="submit" class="saveButton" {{ $data->stage == 0 || $data->stage == 10 ? "disabled" : "" }}>Save</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                <button type="button"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}"> Exit </a> </button>
                            </div>
                        </div>
                    </div>

                    <!-- QA Head/Designee Approval content -->
                    <div id="CCForm6" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                <div class="col-12 sub-head">
                                    Closure
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="QA Head/Designee Comments">QA Head/Designee Comments</label>
                                        <textarea name="QA_Head" {{ $data->stage == 0 || $data->stage == 10 ? "disabled" : "" }} class="tiny">{{ $data->QA_Head }}</textarea>
                                    </div>
                                </div>
                            <div class="col-lg-6">
                                    <!-- <div class="group-input">
                                        <label for="Effectiveness Check required?">Effectiveness Check
                                            required?</label>
                                        <select name="Effectiveness_Check" {{ $data->stage == 0 || $data->stage == 10 ? "disabled" : "" }}>
                                            <option value="">Enter Your Selection Here</option>
                                            <option value="yes" @if ($data->Effectiveness_Check == 'yes') selected @endif>yes
                                            </option>
                                            <option value="no" @if ($data->Effectiveness_Check == 'no') selected @endif>no
                                            </option>
                                        </select>
                                    </div> -->
                                </div>
                                <!-- <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Effect.Chesk Creation Date">Effect.Chesk Creation Date</label>
                                        <input type="date" name="effect_check_date" {{ $data->stage == 0 || $data->stage == 10 ? "readonly" : "" }}
                                            value="{{ $data->effect_check_date }}">
                                    </div>
                                </div>  -->
                                 <!-- <div class="col-lg-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Date Due">Effectiveness Check Creation Date</label>
                                        <div class="calenderauditee">
                                            <input type="text" id="effectivess_check_creation_date" readonly
                                                placeholder="DD-MMM-YYYY" {{ $data->stage == 0 || $data->stage == 10 ? "disabled" : "" }} value="{{ Helpers::getdateFormat($data->effectivess_check_creation_date) }}"/>
                                            <input type="date" name="effectivess_check_creation_date"  value="{{ $data->effectivess_check_creation_date }} "class="hide-input"
                                                oninput="handleDateInput(this, 'effectivess_check_creation_date')" />
                                        </div>
                                    </div>
                                </div>  -->
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Incident Type">Incident Type</label>
                                        <select name="Incident_Type" {{ $data->stage == 0 || $data->stage == 10 ? "disabled" : "" }}>
                                            <option value="">Enter Your Selection Here</option>
                                            <option value="Type A" @if ($data->Incident_Type == 'Type A') selected @endif>Type A
                                            </option>
                                            <option value="Type B" @if ($data->Incident_Type == 'Type B') selected @endif>Type B
                                            </option>
                                            <option value="Type C" @if ($data->Incident_Type == 'Type C') selected @endif>Type c
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Conclusion">Conclusion</label>
                                        <textarea name="Conclusion"{{ $data->stage == 0 || $data->stage == 10 ? "disabled" : "" }} class="tiny">{{ $data->Conclusion }}</textarea>
                                    </div>
                                </div>
                                <div class="col-12 sub-head">
                                    Extension Justification
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="due_date_extension">Due Date Extension Justification</label>
                                        <div><small class="text-primary">Please Mention justification if due date is crossed</small></div>
                                        {{-- <span id="rchar">240</span> --}}
                                        {{-- characters remaining --}}
                                        <textarea name="due_date_extension" id="duedoc" type="text"    maxlength="240"{{ $data->stage == 0 || $data->stage == 10 ? "disabled" : "" }} class="tiny">{{$data->due_date_extension}}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="button-block">
                                <button type="submit" class="saveButton" {{ $data->stage == 0 || $data->stage == 10 ? "disabled" : "" }}>Save</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                <button type="button"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}"> Exit </a> </button>
                            </div>
                        </div>
                    </div>

                    {{-- System Suitability Failure Inicidence --}}

                    <div id="CCForm10" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                                <div class="row">
                                                             {{-- Table --}}


                                                             








                            {{-- Table --}}









                            {{-- Table --}}
                            <!----------------------------------------------------------new table-------------------------------------------------------------------------->

                        {{-- new added table --}}
                        <div class="col-12">
                        <div class="group-input" id="suitabilityRow">
                            <label for="audit-agenda-grid">
                                System Suitability Failure Incidence
                                <button type="button" name="audit-agenda-grid" id="ObservationAdd">+</button>
                                <span class="text-primary" data-bs-toggle="modal"
                                    data-bs-target="#observation-field-instruction-modal"
                                    style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                    (Launch Instruction)
                                </span>
                            </label>

                            <table class="table table-bordered" id="onservation-field-table">
                                <thead>
                                    <tr>
                                        <th style="width: 6%">Sr. No.</th>
                                        <th>Name of Product</th>
                                        <th>B No./A.R. No.</th>
                                        <th>Remarks</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                     $suitabilityNumber = 1;
                                    @endphp
                                          @foreach ($systemSutData->data as  $lab)
                                                <tr>
                                                    <td>{{ $suitabilityNumber++ }}</td>
                                        {{-- <td><input type="text" name="investigation[0][s_no]" value=" {{ $lab['s_no']}}">
                                           </td> --}}

                                          <td><input type="text" {{ $data->stage == 0 || $data->stage == 10 ? "disabled" : "" }} name="investigation[{{$loop->index}}][name_of_product_ssfi]" value=" {{isset($lab['name_of_product_ssfi']) ? $lab['name_of_product_ssfi']:''}}"></td>
                                          <td><input type="text" {{ $data->stage == 0 || $data->stage == 10 ? "disabled" : "" }} name="investigation[{{$loop->index}}][batch_no_ssfi]" value=" {{isset($lab['batch_no_ssfi']) ? $lab['batch_no_ssfi']:''}}"></td>
                                          <td><input type="text" {{ $data->stage == 0 || $data->stage == 10 ? "disabled" : "" }} name="investigation[{{$loop->index}}][remarks_ssfi]" value=" {{isset($lab['remarks_ssfi']) ? $lab['remarks_ssfi' ]:''}}"></td>
                                          <td><button class="removeRowBtn">Remove</button></td>

                                        {{-- <td><input type="text" name="investigation[0][batch_no_ssfi]" value="{{$lab['batch_no_ssfi']}}"></td> --}}
                                         {{-- <td><input type="text" name="investigation[0][remarks_ssfi]" value="{{$lab['remarks_ssfi']}}" ></td> --}}


                                    </tr>
                                   @endforeach
                                 </tbody>
                            </table>
                        </div>
                        </div>



              <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var selectField = document.getElementById('Facility_Equipment');
                    var inputsToToggle = [];

                    // Add elements with class 'facility-name' to inputsToToggle
                    var facilityNameInputs = document.getElementsByClassName('facility-name');
                    for (var i = 0; i < facilityNameInputs.length; i++) {
                        inputsToToggle.push(facilityNameInputs[i]);
                    }

                    // Add elements with class 'id-number' to inputsToToggle
                    var idNumberInputs = document.getElementsByClassName('id-number');
                    for (var j = 0; j < idNumberInputs.length; j++) {
                        inputsToToggle.push(idNumberInputs[j]);
                    }

                    // Add elements with class 'remarks' to inputsToToggle
                    var remarksInputs = document.getElementsByClassName('remarks');
                    for (var k = 0; k < remarksInputs.length; k++) {
                        inputsToToggle.push(remarksInputs[k]);
                    }


                    selectField.addEventListener('change', function() {
                        var isRequired = this.value === 'yes';
                        console.log(this.value, isRequired, 'value');

                        inputsToToggle.forEach(function(input) {
                            input.required = isRequired;
                            console.log(input.required, isRequired, 'input req');
                        });

                        document.getElementById('facilityRow').style.display = isRequired ? 'block' : 'none';
                        // Show or hide the asterisk icon based on the selected value
                        var asteriskIcon = document.getElementById('asteriskInvi');
                        asteriskIcon.style.display = isRequired ? 'inline' : 'none';
                    });
                });
            </script>


<script>
    $(document).ready(function() {
        let suitaBility = 1;
        $('#ObservationAdd').click(function(e) {
            function generateTableRow(serialNumber) {
                var users = @json($users);

                var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="serial[]" value="' + serialNumber +
                    '"></td>' +
                    '<td><input type="text" name="investigation['+ suitaBility +'][name_of_product_ssfi]" value=""></td/>' +
                    '<td><input type="text" name="investigation['+ suitaBility +'][batch_no_ssfi]" value=""></td>' +
                    '<td><input type="text" name="investigation['+ suitaBility +'][remarks_ssfi]" value=""></td>' +
                    '<td><button class="removeRowBtn">Remove</button></td>' +


                    '</tr>';

                for (var i = 0; i < users.length; i++) {
                    html += '<option value="' + users[i].id + '">' + users[i].name + '</option>';
                }

                html += '</select></td>' +

                    '</tr>';
                suitaBility++;
                return html;
            }

            var tableBody = $('#onservation-field-table tbody');
            var rowCount = tableBody.children('tr').length;
            var newRow = generateTableRow(rowCount + 1);
            tableBody.append(newRow);
        });
         $(document).on('click', '.removeRowBtn', function() {
        $(this).closest('tr').remove();
    });
    });
    </script>





                        {{-- new added table --}}
                            <!----------------------------------------------------------new table-------------------------------------------------------------------------->
{{--
                                                            @foreach( $labnew as $secondtab )
                                                                @endforeach --}}

                                                            {{-- New Added --}}
                                                            <div class="col-lg-12">
                                                                <div class="group-input" id="Incident_invlvolved_others">
                                                                    <label for="Incident_Involved">Instrument Involved<span
                                                                            class="text-danger d-none">*</span></label>
                                                                    <textarea name="involved_ssfi" {{ $data->stage == 0 || $data->stage == 10 ? "disabled" : "" }} class="tiny">{{$labnew->involved_ssfi}}{{ $data->instrument_involved_SSFI }}</textarea>
                                                                </div>

                                                            </div>


                                                            <div class="col-lg-4">
                                                                <div class="group-input" id="Incident_stage">
                                                                    <label for="Incident_stage">Stage<span
                                                                            class="text-danger d-none">*</span></label>
                                                                    <input type="text" name="stage_stage_ssfi"  {{ $data->stage == 0 || $data->stage == 10 ? "disabled" : "" }} value="{{$labnew->stage_stage_ssfi}}">
                                                                </div>

                                                            </div><br>
                                                            <div class="col-lg-4">
                                                                <div class="group-input" id="Incident_stability_cond">
                                                                    <label for="Incident_stability_cond">Stability Condition (If Applicable)<span
                                                                            class="text-danger d-none">*</span></label>
                                                                    <input type="text" name="Incident_stability_cond_ssfi" {{ $data->stage == 0 || $data->stage == 10 ? "disabled" : "" }}   value="{{$labnew->Incident_stability_cond_ssfi}}">
                                                                </div>

                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="group-input" id="interval_SSFI">
                                                                    <label for="Incident_interval_others">Interval (If Applicable)<span
                                                                            class="text-danger d-none">*</span></label>
                                                                    <input type="text" name="Incident_interval_ssfi" {{ $data->stage == 0 || $data->stage == 10 ? "disabled" : "" }}  value="{{$labnew->Incident_interval_ssfi}}">
                                                                </div>

                                                            </div>

                                                            <div class="col-lg-6">
                                                                <div class="group-input" id="test_SSFI">
                                                                    <label for="test_SSFI">Test<span
                                                                            class="text-danger d-none">*</span></label>
                                                                    <input type="text" name="test_ssfi" {{ $data->stage == 0 || $data->stage == 10 ? "disabled" : "" }}  value="{{$labnew->test_ssfi}}">
                                                                </div>

                                                            </div>
                            
                                                             
                                                            

                                                            <div class="col-lg-6 new-date-data-field">
                                                                <div class="group-input input-date">
                                                                    <label for="Date Due"> Date Of Analysis</label>
                                                                    <div><small class="text-primary">Please mention expected date of completion</small>
                                                                    </div>
                                                                    <div class="calenderauditee">
                                                                        <input type="text" id="Incident_date_analysis_ssfi" readonly
                                                                            placeholder="DD-MMM-YYYY" value="{{ Helpers::getdateFormat($labnew->Incident_date_analysis_ssfi) }}" />
                                                                        <input type="date" name="Incident_date_analysis_ssfi" {{ $data->stage == 0 || $data->stage == 10 ? "disabled" : "" }} class="hide-input"
                                                                            oninput="handleDateInput(this, 'Incident_date_analysis_ssfi')" />
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-6">
                                                                <div class="group-input" id="specification_number_SSFI">
                                                                    <label for="Incident_specification_no">Specification Number<span
                                                                            class="text-danger d-none">*</span></label>
                                                                    <input type="text" name="Incident_specification_ssfi" {{ $data->stage == 0 || $data->stage == 10 ? "disabled" : "" }}  value="{{$labnew->Incident_specification_ssfi}}">
                                                                </div>

                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="group-input" id="stp_number_SSFI">
                                                                    <label for="Incident_stp_no">STP Number<span
                                                                            class="text-danger d-none">*</span></label>
                                                                    <input type="text" name="Incident_stp_ssfi" {{ $data->stage == 0 || $data->stage == 10 ? "disabled" : "" }}  value="{{$labnew->Incident_stp_ssfi}}">
                                                                </div>

                                                            </div>

                                                            {{-- <div class="col-md-6">
                                                                <div class="group-input">
                                                                    <label for="search">
                                                                        Name Of Analyst<span class="text-danger"></span>
                                                                    </label>
                                                                    <select id="select-state" placeholder="Select..." name="name_of_analyst_SSFI" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}>
                                                                        <option value="">Select a value</option>
                                                                        @foreach ($users as $key=> $value)
                                                                            <option  @if ($data->name_of_analyst_SSFI == $value->id) selected @endif  value="{{ $value->id }}">{{ $value->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    @error('name_of_analyst_SSFI')
                                                                        <p class="text-danger">{{ $message }}</p>
                                                                    @enderror
                                                                </div>
                                                            </div> --}}
                                                            {{-- <div class="col-lg-4">
                                                                <div class="group-input">
                                                                    <label for="search">
                                                                        Name Of Analyst <span class="text-danger"></span>
                                                                    </label>
                                                                    <select id="select-state" placeholder="Select..." name="assign_to">
                                                                        <option value="">Select a value</option>
                                                                        @foreach ($users as $data)
                                                                            <option value="{{ $data->id }}">{{ $data->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    @error('assign_to')
                                                                        <p class="text-danger">{{ $message }}</p>
                                                                    @enderror
                                                                </div>
                            
                                                            </div> --}}
                                                            {{-- <div class="col-lg-4">
                                                                <div class="group-input" id="Incident_date_incidence">
                                                                    <label for="Incident_date_incidence">Date Of Incidence<span
                                                                            class="text-danger d-none">*</span></label>
                                                                    <input type="date" name="date_of_incidence_SSFI" value="{{ $data->date_of_incidence_SSFI}}" value="{{$labnew->Incident_date_incidence_ssfi}}">
                                                                </div>
                            
                                                            </div> --}}

                                                            <div class="col-lg-6 new-date-data-field">
                                                                <div class="group-input input-date">
                                                                    <label for="Date Due"> Date Of Incidence</label>
                                                                    <div><small class="text-primary">Please mention expected date of completion</small>
                                                                    </div>
                                                                    <div class="calenderauditee">
                                                                        <input type="text" id="Incident_date_incidence_ssfi" readonly
                                                                            placeholder="DD-MMM-YYYY" value="{{ Helpers::getdateFormat($labnew->Incident_date_incidence_ssfi) }}"/>
                                                                        <input type="date" name="Incident_date_incidence_ssfi" {{ $data->stage == 0 || $data->stage == 10 ? "disabled" : "" }}  class="hide-input"
                                                                            oninput="handleDateInput(this, 'Incident_date_incidence_ssfi')" />
                                                                    </div>
                                                                </div>
                                                            </div>




                                                            <div class="col-md-6">
                                                                <div class="group-input">
                                                                    <label for="search">
                                                                        QC Reviewer<span class="text-danger"></span>
                                                                    </label>
                                                                    <select id="select-state" placeholder="Select..." name="suit_qc_review_to" {{ $data->stage == 0 || $data->stage == 10 ? "disabled" : "" }}>
                                                                        <option value="">Select a value</option>
                                                                        @foreach ($users as $key=> $value)
                                                                            <option  @if ($data->suit_qc_review_to == $value->id) selected @endif  value="{{ $value->id }}">{{ $value->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    @error('suit_qc_review_to')
                                                                        <p class="text-danger">{{ $message }}</p>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12">
                                                                <div class="group-input" id="Description_incidence_ssfi">
                                                                    <label for="description_of_incidence_SSFI"> Description Of Incidence<span
                                                                            class="text-danger d-none">*</span></label>
                                                                    <textarea name="Description_incidence_ssfi" {{ $data->stage == 0 || $data->stage == 10 ? "disabled" : "" }} class="tiny">{{ $labnew->Description_incidence_ssfi }}</textarea>
                                                                </div>

                                                            </div>
                                                            <div class="col-lg-12">
                                                                <div class="group-input" id="Detail_investigation_ssfi">
                                                                    <label for="Detail_investigation"> Detail Investigation<span
                                                                            class="text-danger d-none">*</span></label>
                                                                    <textarea name="Detail_investigation_ssfi" {{ $data->stage == 0 || $data->stage == 10 ? "disabled" : "" }} class="tiny">{{$labnew->Detail_investigation_ssfi}}</textarea>
                                                                </div>

                                                            </div>

                                                            <div class="col-lg-12">
                                                                <div class="group-input" id="proposed corrective">
                                                                    <label for="Detail_investigation"> Proposed Corrective Action<span
                                                                            class="text-danger d-none">*</span></label>
                                                                    <textarea name="proposed_corrective_ssfi" {{ $data->stage == 0 || $data->stage == 10 ? "disabled" : "" }} class="tiny">{{$labnew->proposed_corrective_ssfi}}</textarea>
                                                                </div>

                                                            </div>

                                                            <div class="col-lg-12">
                                                                <div class="group-input" id="root cause">
                                                                    <label for="root_cause"> Root Cause<span
                                                                            class="text-danger d-none">*</span></label>
                                                                    <textarea name="root_cause_ssfi" {{ $data->stage == 0 || $data->stage == 10 ? "disabled" : "" }} class="tiny">{{$labnew->root_cause_ssfi}}</textarea>
                                                                </div>

                                                            </div>

                                                            <div class="col-lg-12">
                                                                <div class="group-input" id="incident_summary_ssfi">
                                                                    <label for="incident summary ssfi"> Incident Summary<span
                                                                            class="text-danger d-none">*</span></label>
                                                                    <textarea name="incident_summary_ssfi" {{ $data->stage == 0 || $data->stage == 10 ? "disabled" : "" }} class="tiny">{{$labnew->incident_summary_ssfi}}</textarea>
                                                                </div>

                                                            </div>
    
                                                            
                                    
                                                        {{-- <div class="col-md-6">
                                                            <div class="group-input">
                                                                  <label for="search">
                                                              Reviewed By(QC) <span class="text-danger"></span>
                                                            </label>
                                                            <select id="select-state" placeholder="Select..." name="assign_to">
                                                              <option value="">Select a value</option>
                                                              @foreach ($users as $data)
                                                                  <option value="{{ $data->id }}">{{ $data->name }}</option>
                                                              @endforeach
                                                           </select>
                                                            @error('assign_to')
                                                              <p class="text-danger">{{ $message }}</p>
                                                            @enderror
                                                                     </div>
                                                    </div> --}}

                                                    <div class="col-lg-12">
                                                        <div class="group-input">
                                                            <label for="system_suitable_attachments">Initial Attachment</label>
                                                            <div><small class="text-primary">Please attach all relevant or supporting documents</small></div>
                                                    
                                                            <div class="file-attachment-field">
                                                                <!-- Display existing files -->
                                                                <div class="file-attachment-list" id="system_suitable_attachments">
                                                                    @if ($labnew->system_suitable_attachments)
                                                                        @foreach (json_decode($labnew->system_suitable_attachments) as $file)
                                                                            <h6 class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                                                <b>{{ $file }}</b>
                                                                                <a href="{{ asset('upload/' . $file) }}" target="_blank">
                                                                                    <i class="fa fa-eye text-primary" style="font-size:20px; margin-right:-10px;"></i>
                                                                                </a>
                                                                                <a href="#" class="remove-file" data-file-name="{{ $file }}">
                                                                                    <i class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i>
                                                                                </a>
                                                                            </h6>
                                                                        @endforeach
                                                                    @endif
                                                                </div>
                                                    
                                                                <!-- Add new files -->
                                                                <div class="add-btn">
                                                                    {{--<i class="fa fa-plus-circle"></i>--}}
                                                                    <div>Add</div>
                                                                    <input 
                                                                        type="file" 
                                                                        id="system_suitable_attachments_input" 
                                                                        name="system_suitable_attachments[]" 
                                                                        oninput="addMultipleFiles(this, 'system_suitable_attachments')" 
                                                                        multiple>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                      

                                                    <div class="button-block">
                                                        <button type="submit" class="saveButton">Save</button>
                                                        <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                                        <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                                        <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white"> Exit </a> </button>
                                                    </div>




                                                            {{-- New Added --}}
                            </div>
                        </div>
                    </div>


                                              <!-- Closure Tab -->
                <div id="CCForm11" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="closure_incident">Closure Of Incident</label>
                                    <input type="text" name="closure_incident_c" {{ $data->stage == 0 || $data->stage == 10 ? "disabled" : "" }}  value="{{$labnew->closure_incident_c}}">
                                </div>

                            </div>
{{--
                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="affected documents closed"><b>Affected Documents Closed</b></label>
                                    <select name="Initiator_Group" id="initiator_group" name="affected_documents_closed">
                                        <option value="0">-- Select --</option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                        <option value="NA">NA</option>

                                    </select>
                                </div>
                            </div> --}}

                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="head remark"><b>QC Head Remark</b></label>
                                   <textarea name="qc_hear_remark_c" {{ $data->stage == 0 || $data->stage == 10 ? "disabled" : "" }} class="tiny">{{$labnew->qc_hear_remark_c}}</textarea>
                                </div>
                            </div>


                            {{-- <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="head remark"><b>QC Head Remark</b></label>
                                   <textarea name="qc_head_remark_closure">{{$data->qc_head_remark_closure>}}</textarea>
                                </div>
                            </div> --}}



                          
                        <div class="col-md-6">
                            <div class="group-input">
                                <label for="search">
                                    QC Head Closure <span class="text-danger"></span>
                                </label>
                                <select id="select-state" placeholder="Select..." name="qc_head_closure" {{ $data->stage == 0 || $data->stage == 10 ? "disabled" : "" }}>
                                    @foreach ($users as $value)
                                        <option @if ($data->qc_head_closure == $value->id) selected @endif value="{{ $value->id }}">{{ $value->name }}</option>
                                    @endforeach
                                </select>
                                @error('qc_head_closure')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>


                        {{-- <div class="col-lg-12">
                            <div class="group-input">
                                <label for=" qa head remark"><b>QC Head Closure</b></label>
                               <textarea name="qc_head_closure">{{$data->}}</textarea>
                            </div>
                        </div> --}}

                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for=" qa head remark"><b>QA Head Remark</b></label>
                               <textarea name="qa_hear_remark_c" {{ $data->stage == 0 || $data->stage == 10 ? "disabled" : "" }} class="tiny">{{$labnew->qa_hear_remark_c}}</textarea>
                            </div>
                        </div>


                        <div class="col-lg-12">
                            <div class="group-input">
                                <label for="closure_attachment_c">Closure Attachment</label>
                                <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                {{-- <input type="file" id="myfile" name="Initial_Attachment" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}
                                    value="{{ $data->Initial_Attachment }}"> --}}
                                    <div class="file-attachment-field">
                                        <div class="file-attachment-list" id="closure_attachment_c">
                                            @if ($labnew->closure_attachment_c)
                                            @foreach (json_decode($labnew->closure_attachment_c) as $file)
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
                                        <div class="add-btn ">
                                            <div>Add</div>
                                            <input {{ $data->stage == 0 || $data->stage == 10 ? "disabled" : "" }} type="file" id="closure_attachment_c" name="closure_attachment_c[]"
                                                oninput="addMultipleFiles(this, 'closure_attachment_c')" multiple>
                                        </div>
                                    </div>
                            </div>
                        </div>


                        <div class="button-block">
                            <button type="submit" class="saveButton">Save</button>
                            <button type="button" class="backButton" onclick="previousStep()">Back</button>
                            <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                            <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white"> Exit </a> </button>
                        </div>


                        </div>
                    </div>
            </div>


            <div id="CCForm7" class="inner-block cctabcontent">
                <div class="inner-block-content">
    
                <div class="sub-head">Activity Log</div>
    
                    <div class="d-flex align-item-end justify-content-end">
    
                            <button style="margin-bottom:20px;" class="button_theme1"> <a
                                    class="text-white"
                                    href="{{ url('rcms/labincident_activity_pdf', $data->id) }}"> Print </a>
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
                                                                {{ $data->comment}}
                                                            </td>
                                                        </tr>
    
    
                                                        <tr>
                                                            <td>
                                                                <strong>Verification Complete By :</strong><br>
                                                                {{ $data->verification_complete_completed_by }}
                                                            </td>
                                                            <td>
                                                                <strong>Verification Complete On:</strong><br>
                                                                {{ $data->verification_completed_on }}
                                                            </td>
                                                        </tr>
    
                                                        <tr>
                                                            <td colspan="2">
                                                                <strong>Verification Complete Comment:</strong><br>
                                                                {{ $data->verification_complete_comment ?? 'Not Applicable' }}
                                                            </td>
                                                        </tr>
                                                        
                                                        <tr>
                                                            <td>
                                                                <strong>Preliminary Investigation Completed By :</strong><br>
                                                                {{ $data->preliminary_completed_by }}
                                                            </td>
                                                            <td>
                                                                <strong>Preliminary Investigation Completed On :</strong><br>
                                                                {{ $data->preliminary_completed_on }}
                                                            </td>
                                                        </tr>
    
                                                        <tr>
                                                            <td colspan="2">
                                                                <strong>Preliminary Investigation Completed Comment :</strong><br>
                                                                {{ $data->preliminary_completed_comment ?? 'Not Applicable' }}
                                                            </td>
                                                        </tr>
                                                       
    
                                                        <tr>
                                                            <td>
                                                                <strong>Assignable Cause Identification Completed By :</strong><br>
                                                                {{ $data->all_activities_completed_by }}
                                                            </td>
                                                            <td>
                                                                <strong>Assignable Cause Identification Completed On :</strong><br>
                                                                {{ $data->all_activities_completed_on }}
                                                            </td>
                                                        </tr>
    
                                                        <tr>
                                                            <td colspan="2">
                                                                <strong>Assignable Cause Identification Completed Comment :</strong><br>
                                                                {{ $data->all_activities_completed_comment ?? 'Not Applicable' }}
                                                            </td>
                                                        </tr>
                                                        
    
                                                        <tr>
                                                            <td>
                                                                <strong>No Assignable Cause Identification Completed By :</strong><br>
                                                                {{ $data->no_assignable_cause_by}}
                                                            </td>
                                                            <td>
                                                                <strong>No Assignable Cause Identification Completed On :</strong><br>
                                                                {{ $data->no_assignable_cause_on }}
                                                            </td>
                                                        </tr>
    
                                                        <tr>
                                                            <td colspan="2">
                                                                <strong>No Assignable Cause Identification Completed Comment :</strong><br>
                                                                {{ $data->no_assignable_cause_comment ?? 'Not Applicable' }}
                                                            </td>
                                                        </tr>
                                                       
    
                                                        <tr>
                                                            <td>
                                                                <strong>Extended Inv Completed By :</strong><br>
                                                                {{ $data->extended_inv_complete_by }}
                                                            </td>
                                                            <td>
                                                                <strong>Extended Inv Completed On :</strong><br>
                                                                {{ $data->extended_inv_complete_on }}
                                                            </td>
                                                        </tr>
    
                                                        <tr>
                                                            <td colspan="2">
                                                                <strong>Extended Inv Completed Comment :</strong><br>
                                                                {{ $data->extended_inv_comment ?? 'Not Applicable' }}
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>
                                                                <strong>Solution Validation Completed By :</strong><br>
                                                                {{ $data->review_completed_by }}
                                                            </td>
                                                            <td>
                                                                <strong>Solution Validation Completed On :</strong><br>
                                                                {{ $data->review_completed_on }}
                                                            </td>
                                                        </tr>
    
                                                        <tr>
                                                            <td colspan="2">
                                                                <strong>Solution Validation Completed Comment :</strong><br>
                                                                {{ $data->solution_validation_comment ?? 'Not Applicable' }}
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>
                                                                <strong>All Action Approved Completed By :</strong><br>
                                                                {{ $data->all_actiion_approved_by }}
                                                            </td>
                                                            <td>
                                                                <strong>All Action Approved Completed On :</strong><br>
                                                                {{ $data->all_actiion_approved_on }}
                                                            </td>
                                                        </tr>
    
                                                        <tr>
                                                            <td colspan="2">
                                                                <strong>All Action Approved Completed Comment :</strong><br>
                                                                {{ $data->all_action_approved_comment ?? 'Not Applicable' }}
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>
                                                                <strong>Assessment Completed By :</strong><br>
                                                                {{ $data->assesment_completed_by }}
                                                            </td>
                                                            <td>
                                                                <strong>Assessment Completed On :</strong><br>
                                                                {{ $data->assesment_completed_on }}
                                                            </td>
                                                        </tr>
    
                                                        <tr>
                                                            <td colspan="2">
                                                                <strong>Assessment Completed Comment :</strong><br>
                                                                {{ $data->assessment_comment ?? 'Not Applicable' }}
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>
                                                                <strong>Closure Completed By :</strong><br>
                                                                {{ $data->closure_completed_by }}
                                                            </td>
                                                            <td>
                                                                <strong>Closure Completed On :</strong><br>
                                                                {{ $data->closure_completed_on }}
                                                            </td>
                                                        </tr>
    
                                                        <tr>
                                                            <td colspan="2">
                                                                <strong>Closure Completed Comment :</strong><br>
                                                                {{ $data->QA_head_approved_comment ?? 'Not Applicable' }}
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
                                                                {{ $data->cancell_comment ?? 'Not Applicable' }}
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
    

                    <!-- Activity Log content -->
                    {{--<div id="CCForm7" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                              
                                <div class="col-12 sub-head" style="font-size: 16px">
                                    Submitted
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Submitted By">Submitted By</label>
                                        <div class="static">{{ $data->submitted_by }}</div>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Submitted On">Submitted On</label>
                                        <div class="Date">{{ $data->submitted_on }}</div>
                                    </div>
                                </div>


                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Comment">Submitted Comment</label>
                                        <div class="static" >{{$data->comment}}</div>
                                    </div>
                                </div>
                            
                                <div class="col-12 sub-head"  style="font-size: 16px">
                                    Verification 
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Verification Complete">Verification Complete
                                            By</label>
                                        <div class="static">{{ $data->verification_complete_completed_by }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Incident Review Completed On">Verification Complete
                                            On</label>
                                        <div class="Date">{{ $data->verification_completed_on }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Comment">Verification Complete Comment</label>
                                        <div class="static">{{$data->verification_complete_comment}}</div>
                                    </div>
                                </div>
                                <div class="col-12 sub-head"  style="font-size: 16px">
                                    Preliminary Investigation
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Investigation Completed By"> Preliminary Investigation Completed By</label>
                                        <div class="static">{{ $data->preliminary_completed_by }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Investigation Completed On"> Preliminary Investigation Completed On</label>
                                        <div class="Date">{{ $data->preliminary_completed_on }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Comment">Preliminary Investigation Completed Comment</label>
                                        <div class="static">{{$data->preliminary_completed_comment}}</div>
                                    </div>
                                </div>
                                <div class="col-12 sub-head"  style="font-size: 16px">
                                    Assignable Cause Identification
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Assignable Cause Identification Completed">Assignable Cause Identification Completed By</label>
                                        <div class="static">{{ $data->all_activities_completed_by }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Assignable Cause Identification Completed">Assignable Cause Identification Completed On</label>
                                        <div class="Date">{{ $data->all_activities_completed_on }}</div>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Comment">Assignable Cause Identification Completed Comment</label>
                                        <div class="static">{{$data->all_activities_completed_comment}}</div>
                                    </div>
                                </div>
                                <div class="col-12 sub-head"  style="font-size: 16px">
                                    No Assignable Cause Identification
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="No Assignable Completed By">No Assignable Cause Identification  Completed By</label>
                                        <div class="static">{{$data->no_assignable_cause_by}}</div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="No Assignable Completed On">No Assignable Cause Identification Completed On</label>
                                        <div class="Date">{{$data->no_assignable_cause_on}}</div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Comment">No Assignable Cause Identification Completed Comment</label>
                                        <div class="static">{{$data->no_assignable_cause_comment}}</div>
                                    </div>
                                </div>
                                <div class="col-12 sub-head"  style="font-size: 16px">
                                    Extended Inv
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Extended Inv Completed By">Extended Inv Completed By</label>
                                        <div class="static">{{$data->extended_inv_complete_by}}</div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Extended Inv Completed On">Extended Inv Completed On</label>
                                        <div class="Date">{{$data->extended_inv_complete_on}}</div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Comment">Extended Inv Completed Comment</label>
                                        <div class="static">{{$data->extended_inv_comment}}</div>
                                    </div>
                                </div>
                                <div class="col-12 sub-head"  style="font-size: 16px">
                                    Solution Validation 
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Solution Validation Completed By">Solution Validation Completed By</label>
                                        <div class="static">{{$data->review_completed_by}}</div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Solution Validation Completed On">Solution Validation Completed On</label>
                                        <div class="Date">{{$data->review_completed_on}}</div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Comment">Solution Validation Completed Comment</label>
                                        <div class="static">{{$data->solution_validation_comment}}</div>
                                    </div>
                                </div>

                                <div class="col-12 sub-head"  style="font-size: 16px">
                                    All Action Approved
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="All Action Approved Completed By">All Action Approved Completed By</label>
                                        <div class="static">{{ $data->all_actiion_approved_by }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="All Action Approved Completed On">All Action Approved Completed On</label>
                                        <div class="Date">{{ $data->all_actiion_approved_on}}</div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Comment">All Action Approved Completed Comment</label>
                                        <div class="static">{{$data->all_action_approved_comment}}</div>
                                    </div>
                                </div>
                               
                               
                                <div class="col-12 sub-head"  style="font-size: 16px">
                                    Assessment 
                                </div>
                                 <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Assessment Completed By">Assessment Completed By</label>
                                        <div class="static">{{$data->assesment_completed_by}}</div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Assemssment Completed On">Assessment Completed On</label>
                                        <div class="Date">{{$data->assesment_completed_on}}</div>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Comment">Assessment Completed Comment</label>
                                        <div class="static">{{$data->assessment_comment}}</div>
                                    </div>
                                </div>
                                <div class="col-12 sub-head"  style="font-size: 16px">
                                    Closure
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Closure Completed By">Closure Completed By</label>
                                        <div class="static">{{$data->closure_completed_by}}</div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Closure Completed On">Closure Completed On</label>
                                        <div class="Date">{{$data->closure_completed_on}}</div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Comment">Closure Completed Comment</label>
                                        <div class="static">{{$data->closure_comment}}</div>
                                    </div>
                                </div>


                                <div class="col-12 sub-head"  style="font-size: 16px">
                                    Cancel
                                </div>

                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Cancelled By">Cancelled By</label>
                                        <div class="static">{{ $data->cancelled_by }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Cancelled On">Cancelled On</label>
                                        <div class="Date">{{ $data->cancelled_on }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Comment">Cancelled Comment</label>
                                        <div class="static">{{$data->cancell_comment}}</div>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="button-block">
                                <button type="submit" class="saveButton" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}>Save</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                <button type="submit" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}>Submit</button>
                                <button type="button"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}"> Exit </a> </button>
                            </div>
                        </div>
                    </div>--}}

                </div>
            </form>

        </div>
    </div>
    {{-- ----------------------modal------------- --}}

    <div class="modal fade" id="rejection-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">E-Signature</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ url('rcms/RejectStateChangeEsign', $data->id) }}" method="POST">
                    @csrf
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="mb-3 text-justify">
                            Please select a meaning and a outcome for this task and enter your username
                            and password for this task. You are performing an electronic signature,
                            which is legally binding equivalent of a hand written signature.
                        </div>
                        <div class="group-input">
                            <label for="username">Username  <span
                                class="text-danger">*</span></label>
                            <input type="text" name="username" required>
                        </div>
                        <div class="group-input">
                            <label for="password">Password  <span
                                class="text-danger">*</span></label>
                            <input type="password" name="password" required>
                        </div>
                        <div class="group-input">
                            <label for="comment">Comment <span
                                class="text-danger">*</span></label>
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
                <form action="{{ route('StageChangeLabIncident', $data->id) }}" method="POST">
                    @csrf
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="mb-3 text-justify">
                            Please select a meaning and a outcome for this task and enter your username
                            and password for this task. You are performing an electronic signature,
                            which is legally binding equivalent of a hand written signature.
                        </div>
                        <div class="group-input">
                            <label for="username">Username  <span
                                class="text-danger">*</span></label>
                            <input type="text" name="username" required>
                        </div>
                        <div class="group-input">
                            <label for="password">Password  <span
                                class="text-danger">*</span></label>
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

    <div class="modal fade" id="signature-modal1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">E-Signature</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('StageChangeLabtwo', $data->id) }}" method="POST">
                    @csrf
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="mb-3 text-justify">
                            Please select a meaning and a outcome for this task and enter your username
                            and password for this task. You are performing an electronic signature,
                            which is legally binding equivalent of a hand written signature.
                        </div>
                        <div class="group-input">
                            <label for="username">Username  <span
                                class="text-danger">*</span></label>
                            <input class="input_full_width" type="text" name="username" required>
                        </div>
                        <div class="group-input">
                            <label for="password">Password  <span
                                class="text-danger">*</span></label>
                            <input class="input_full_width" type="password" name="password" required>
                        </div>
                        <div class="group-input">
                            <label for="comment">Comment</label>
                            <input class="input_full_width" type="comment" name="comment">
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

                <form action="{{ route('LabIncidentCancel', $data->id) }}" method="POST">
                    @csrf
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="mb-3 text-justify">
                            Please select a meaning and a outcome for this task and enter your username
                            and password for this task. You are performing an electronic signature,
                            which is legally binding equivalent of a hand written signature.
                        </div>
                        <div class="group-input">
                            <label for="username">Username  <span
                                class="text-danger">*</span></label>
                            <input type="text" name="username" required>
                        </div>
                        <div class="group-input">
                            <label for="password">Password  <span
                                class="text-danger">*</span></label>
                            <input type="password" name="password" required>
                        </div>
                        <div class="group-input">
                            <label for="comment">Comment  <span
                                class="text-danger">*</span></label>
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
                <form action="{{ route('lab_incident_root_child', $data->id) }}" method="POST">
                    @csrf
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="group-input">
                            <label for="capa-child">
                                <input type="radio" name="revision" id="capa-child" value="capa-child">
                                CAPA
                            </label>
                        </div>
                        <div class="group-input">
                            <label for="root-item">
                                <input type="radio" name="revision" id="root-item" value="Action-Item">
                                Action Item
                            </label>
                        </div>
                        <div class="group-input">
                            <label for="root-item">
                             <input type="radio" name="revision" id="root-item" value="effectiveness-check">
                                Effectiveness check
                            </label>
                        </div>
                        <div class="group-input">
                            <label for="root-item">
                                <input type="radio" name="revision" id="root-item" value="Extension">
                                Extension
                            </label>
                        </div>
                        
                    </div>

                    <!-- Modal footer -->
                    <!-- <div class="modal-footer">
                        <button type="button" data-bs-dismiss="modal">Close</button>
                        <button type="submit">Continue</button>
                    </div> -->
                    <div class="modal-footer">
                              <button type="submit">Submit</button>
                             <button type="button" data-bs-dismiss="modal">Close</button>
                   </div>
                </form>

            </div>
        </div>
    </div>
    <div class="modal fade" id="child-modal2">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Child</h4>
                </div>
                <div class="modal-body">
                    <form action="{{ route('labincidentRisk_Child', $data->id) }}" method="POST">
                        @csrf
                        <div class="group-input">
                            
                        </div>
                        <div class="group-input">
                            <label for="root-item">
                                <input type="radio" name="revision" id="root-item" value="risk-Item">
                                Risk Assessment
                            </label>
                        </div>
                        <div class="group-input">
                            <label for="root-item">
                                <input type="radio" name="revision" id="root-item" value="Extension">
                                Extension
                            </label>
                        </div>
                        
                        <div class="modal-footer">
                            <button type="submit">Submit</button>
                            <button type="button" data-bs-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="child-modal3">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Child</h4>
                </div>
                <div class="modal-body">
                    <form action="{{ route('lab_incident_extension_child', $data->id) }}" method="POST">
                        @csrf
                        
                        <div class="group-input">
                            <label for="root-item">
                                <input type="radio" name="revision" id="root-item" value="Extension">
                                Extension
                            </label>
                        </div>
                        
                        <div class="modal-footer">
                            <button type="submit">Submit</button>
                            <button type="button" data-bs-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="child-modal1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Child</h4>
                </div>
                <div class="modal-body">
                    <form action="{{ route('lab_incident_capa_child', $data->id) }}" method="POST">
                        @csrf
                        <div class="group-input">
                            <label for="capa-child">
                                <input type="radio" name="revision" id="capa-child" value="capa-child">
                                CAPA
                            </label>
                        </div>
                        <div class="group-input">
                            <label for="root-item">
                                <input type="radio" name="revision" id="root-item" value="Action-Item">
                                Action Item
                            </label>
                        </div>
                        <div class="group-input">
                            <label for="root-item">
                                <input type="radio" name="revision" id="root-item" value="Extension">
                                Extension
                            </label>
                        </div>
                        
                        <div class="modal-footer">
                            <button type="submit">Submit</button>
                            <button type="button" data-bs-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
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
        .input_full_width{
            width: 100%;
    border-radius: 5px;
    margin-bottom: 10px;
        }
    </style>

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
        // JavaScript
        document.getElementById('initiator_group').addEventListener('change', function() {
            var selectedValue = this.value;
            document.getElementById('initiator_group_code').value = selectedValue;
        });
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
        var maxLength = 255;
        $('#docname').keyup(function() {
            var textlen = maxLength - $(this).val().length;
            if (textlen < 0) {
                textlen = 0;
            }
            $('#rchars').text(textlen);
        });
    </script>
        <script>
        var maxLength = 255;
        $('#duedoc').keyup(function() {
            var textlen = maxLength - $(this).val().length;
            $('#rchar').text(textlen);});
    </script>
<script>
    wow = new WOW(
                    {
                    boxClass:     'wow',      // default
                    animateClass: 'animated', // default
                    offset:       0,          // default
                    mobile:       true,       // default
                    live:         true        // default
                    }
                    )
                    wow.init();
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
var originalRecordNumber = document.getElementById('record_number').value;
var initialPlaceholder = '---';

document.getElementById('initiator_group').addEventListener('change', function() {
    var selectedValue = this.value;
    var recordNumberElement = document.getElementById('record_number');
    var initiatorGroupCodeElement = document.getElementById('initiator_group_code');

    // Update the initiator group code
    initiatorGroupCodeElement.value = selectedValue;

    // Update the record number by replacing the initial placeholder with the selected initiator group code
    var newRecordNumber = originalRecordNumber.replace(initialPlaceholder, selectedValue);
    recordNumberElement.value = newRecordNumber;

    // Update the original record number to keep track of changes
    originalRecordNumber = newRecordNumber;
    initialPlaceholder = selectedValue;
});
});

</script>
@endsection
