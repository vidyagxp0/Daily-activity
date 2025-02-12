@extends('frontend.rcms.layout.main_rcms')
@section('rcms_container')
    @php
        $users = DB::table('users')->select('id', 'name')->get();
        $Allusers = DB::table('users')->select('id', 'name')->get();
       
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

        .remove-file{
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
        .form-control{
            margin-bottom: 20px;
        }

        div[class^="VIp"] {
            display: none;
        }

        #change-control-view > div.container-fluid > div.inner-block.state-block > div.status > div > div{
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
                        $name = DB::table('q_m_s_divisions')->where('id', $data->id)->value('name');
                    @endphp
                    <strong>Site Division / Project </strong>:
                    {{$division->name}} / Global Change Control
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
                        $cftRolesAssignUsers = collect($userRoleIds); //->contains(fn ($roleId) => $roleId >= 22 && $roleId <= 33);

                        $cftUsers = DB::table('global_change_controls_cfts')
                            ->where(['cc_id' => $data->id])
                            ->first();
                            
                        $columns = [
                            'Production_person',
                            'Quality_Control_Person',
                            'Warehouse_person',
                            'Engineering_person',
                            'ResearchDevelopment_person',
                            'RegulatoryAffair_person',
                            'CQA_person',
                            'Microbiology_person',
                            'QualityAssurance_person',
                            'SystemIT_person',
                            'Human_Resource_person',
                            'Other1_person',
                            'Other2_person',
                            'Other3_person',
                            'Other4_person',
                            'Other5_person',
                        ];

                        $valuesArray = [];

                        foreach ($columns as $column) {
                            $value = $cftUsers->$column;
                            if ($value !== null && $value != 0) {
                                $valuesArray[] = $value;
                            }
                        }
                        $cftCompleteUser = DB::table('global_change_controls_responses')
                            ->whereIn('status', ['In-progress', 'Completed'])
                            ->where('cc_id', $data->id)
                            ->where('cft_user_id', Auth::user()->id)
                            ->whereNull('deleted_at')
                            ->first();

                    @endphp

                        <button class="button_theme1"> <a class="text-white" href="{{ url('rcms/global-cc-audit-trail', $data->id) }}"> Audit Trail </a> </button>

                        @if ($data->stage == 1 && Helpers::check_roles($data->division_id, 'Global Change Control', 3))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Submit
                            </button>
                        @elseif($data->stage == 2 && Helpers::check_roles($data->division_id, 'Global Change Control', 4))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#rejection-modal">
                                More Information Required
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                HOD Assessment Complete
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-modal">
                                Cancel
                            </button>
                        @elseif($data->stage == 3 &&  Helpers::check_roles($data->division_id, 'Global Change Control', 7))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#rejection-modal">
                                More Information Required
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                QA/CQA Initial Assessment Complete
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#child-modal">
                                Child
                            </button>
                        @elseif($data->stage == 4 && (in_array(5, $userRoleIds) || in_array(18, $userRoleIds) || in_array(Auth::user()->id, $valuesArray)))
                            @if (!$cftCompleteUser)                                   
                                <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#rejection-modal">
                                    More Information Required
                                </button>
                                <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                    CFT Review Complete
                                 </button>
                            @endif
                        @elseif($data->stage == 5 && Helpers::check_roles($data->division_id, 'Global Change Control', 18))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                External Review Completed
                            </button>
                        @elseif($data->stage == 6 && Helpers::check_roles($data->division_id, 'Global Change Control', 7))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                RA Approval Required
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#opened-state-modal">
                                Send to Initiator
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#child-modal">
                                Child
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#hod-modal">
                                Send to HOD
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#initalQA-review-modal">
                                Send to QA/CQA Initial Review
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#qa-head-approval">
                                QA/CQA Final Review Complete
                            </button>
                        @elseif($data->stage == 7 && Helpers::check_roles($data->division_id, 'Global Change Control', 18))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                RA Approval Complete
                            </button>
                        @elseif($data->stage == 8 && Helpers::check_roles($data->division_id, 'Global Change Control', 39))
                            
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#rejection-modal">
                                More Information Required
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#send-post-implementation">
                                Approved
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#send-reject">
                                Rejected
                            </button>
                        @elseif ($data->stage == 10 && Helpers::check_roles($data->division_id, 'Global Change Control', 3))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#send-post-implementation">
                                Initiator Updated Completed
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#child-modal-stage_8">
                                Child
                            </button>
                        @elseif ($data->stage == 11 && Helpers::check_roles($data->division_id, 'Global Change Control', 4))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#send-post-implementation">
                                HOD Final Review Complete
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#rejection-modal">
                                More Information Required
                            </button>
                        @elseif ($data->stage == 12 && Helpers::check_roles($data->division_id, 'Global Change Control', 7))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#send-post-implementation">
                                Send For Final QA/CQA Head Approval
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#rejection-modal">
                                More Information Required
                            </button>    

                            @elseif ($data->stage == 13 && Helpers::check_roles($data->division_id, 'Global Change Control', 39))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#send-post-implementation">
                                Closure Approved
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#rejection-modal">
                                More Information Required
                            </button>
                            @elseif ($data->stage == 14 && Helpers::check_roles($data->division_id, 'Global Change Control', 39))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#child_effective_ness">
                                Child
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
                                    <path fill="#ffffff" d="M369.9 97.9L286 14C277 5 264.8-.1 252.1-.1H48C21.5 0 0 21.5 0 48v416c0 26.5 21.5 48 48 48h288c26.5 0 48-21.5 48-48V131.9c0-12.7-5.1-25-14.1-34M332.1 128H256V51.9zM48 464V48h160v104c0 13.3 10.7 24 24 24h104v288zm220.1-208c-5.7 0-10.6 4-11.7 9.5c-20.6 97.7-20.4 95.4-21 103.5c-.2-1.2-.4-2.6-.7-4.3c-.8-5.1.3.2-23.6-99.5c-1.3-5.4-6.1-9.2-11.7-9.2h-13.3c-5.5 0-10.3 3.8-11.7 9.1c-24.4 99-24 96.2-24.8 103.7c-.1-1.1-.2-2.5-.5-4.2c-.7-5.2-14.1-73.3-19.1-99c-1.1-5.6-6-9.7-11.8-9.7h-16.8c-7.8 0-13.5 7.3-11.7 14.8c8 32.6 26.7 109.5 33.2 136c1.3 5.4 6.1 9.1 11.7 9.1h25.2c5.5 0 10.3-3.7 11.6-9.1l17.9-71.4c1.5-6.2 2.5-12 3-17.3l2.9 17.3c.1.4 12.6 50.5 17.9 71.4c1.3 5.3 6.1 9.1 11.6 9.1h24.7c5.5 0 10.3-3.7 11.6-9.1c20.8-81.9 30.2-119 34.5-136c1.9-7.6-3.8-14.9-11.6-14.9h-15.8z" />
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
                    @elseif($data->stage == 9)
                        <div class="progress-bars">
                            <div class="bg-danger">Closed - Rejected</div>
                        </div>
                    @else
                      
                        <div class="progress-bars" style="margin-bottom: 16px;">
                            @if ($data->stage >= 1)
                                <div class="active">Opened</div>
                            @else
                                <div class="">Opened</div>
                            @endif
                            @if ($data->stage >= 2)
                                <div class="active">HOD Assessment</div>
                            @else
                                <div class="">HOD Assessment</div>
                            @endif
                            @if ($data->stage >= 3)
                                <div class="active">QA/CQA Initial Assessment</div>
                            @else
                                <div class="">QA/CQA Initial Assessment</div>
                            @endif
                            @if ($data->stage >= 4)
                                <div class="active">CFT Assessment</div>
                            @else
                                <div class="">CFT Assessment</div>
                            @endif
                            @if ($data->stage >= 5)
                                <div class="active">External Review</div>
                            @else
                                <div class="">External Review</div>
                            @endif

                            @if ($data->stage >= 6)
                                <div class="active">QA/CQA Final Review</div>
                            @else
                                <div class="">QA/CQA Final Review</div>
                            @endif
                            
                            @if ($data->stage >= 7)
                                <div class="active">Pending RA Approval</div>
                            @else
                                <div class="">Pending RA Approval</div>
                            @endif
                            @if ($data->stage >= 8)
                                <div class="active">QA/CQA Head/Manager Designee Approval</div>
                            @else
                                <div class="">QA/CQA Head/Manager Designee Approval</div>
                            @endif

                            @if ($data->stage >= 10)
                                <div class="active" @if($data->stage == 9) style="display: none" @endif>Pending Initiator Update</div>
                            @else
                                <div class="" @if($data->stage == 9) style="display: none" @endif>Pending Initiator Update</div>
                            @endif

                            @if ($data->stage >= 11)
                                <div class="active" @if($data->stage == 9) style="display: none" @endif>HOD Final Review</div>
                            @else
                                <div class="" @if($data->stage == 9) style="display: none" @endif>HOD Final Review</div>
                            @endif

                            @if ($data->stage >= 12)
                                <div class="active" @if($data->stage == 9) style="display: none" @endif>Implementation Verification by QA/CQA</div>
                            @else
                                <div class="" @if($data->stage == 9) style="display: none" @endif>Implementation Verification by QA/CQA</div>
                            @endif

                            @if ($data->stage >= 13)
                                <div class="active" @if($data->stage == 9) style="display: none" @endif>QA/CQA Closure Approval</div>
                            @else
                                <div class="" @if($data->stage == 9) style="display: none" @endif>QA/CQA Closure Approval</div>
                            @endif



                            @if ($data->stage >= 14)
                                <div class="active bg-danger" @if($data->stage == 9) style="display: none" @endif>Closed - Done</div>
                            @else
                                <div class="" @if($data->stage == 9) style="display: none" @endif>Closed - Done</div>
                            @endif
                        </div>
                    @endif
                </div> 
                <div class="top-block">
                    <div><strong> Record Name :&nbsp;</strong>Change Control</div>
                    <div><strong> Site :&nbsp;</strong>{{ Helpers::getDivisionName($data->division_id) }}</div>
                    <div><strong> Current Status :&nbsp;</strong>{{ $data->status }}</div>
                    <div><strong> Initiated By :&nbsp;</strong>{{ Helpers::getInitiatorName($data->initiator_id) }}</div>
                </div>
            </div>
            <div class="modal right fade" id="myModal3" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-titles ml-10">Change Control Workflow</h4>
                        </div>
                        <div  style="" class="modal-body main-new-workflow">
                            <Div class="button-box">
                                @if ($data->stage == 0)
                                <div class="">
                                    <div class="mini_buttons  bg-danger">Closed-Cancelled</div>
                                </div>
                                @elseif ($data->stage == 9)
                                <div class="">
                                    <div class="mini_buttons  bg-danger">Rejected</div>
                                </div>
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
                              HOD Assessment
                                </div>
                                @else
                                <div  class="mini_buttons">
                              HOD Assessment
                                </div>
                                @endif
                                <div class="down-logo">
                                    <img class="dawn_arrow" src="{{ asset('user/images/down.gif') }}" alt="..."
                                        class="w-100 h-100">
    
                                </div>
                                @if ($data->stage >= 3)
                                <div  class="active">
                                    QA/CQA Initial Assessment
                                </div>
                                @else
                                <div  class="mini_buttons">
                                    QA/CQA Initial Assessment
                                </div>
                                @endif
                                <div class="down-logo">
                                    <img class="dawn_arrow" src="{{ asset('user/images/down.gif') }}" alt="..."
                                        class="w-100 h-100">
    
                                </div>
                                @if ($data->stage >= 4)

                                <div  class="active">
                                    CFT Assessment
                                </div>
                                @else
                                <div  class="mini_buttons">
                                    CFT Assessment
                                </div>
                                @endif
                                <div class="down-logo">
                                    <img class="dawn_arrow" src="{{ asset('user/images/down.gif') }}" alt="..."
                                        class="w-100 h-100">
    
                                </div>
                                @if ($data->stage >= 5)

                                <div  class="active">
                                External Review
                                </div>
                                @else
                                <div  class="mini_buttons">
                                External Review
                                </div>
                                @endif
                                <div class="down-logo">
                                    <img class="dawn_arrow" src="{{ asset('user/images/down.gif') }}" alt="..."
                                        class="w-100 h-100">
    
                                </div>
                                @if ($data->stage >= 6)

                                <div  class="active">
                                    QA/CQA Final Review
                                </div>
                                @else
                                <div  class="mini_buttons">
                                    QA/CQA Final Review
                                </div>
                                @endif
                                <div class="down-logo">
                                    <img class="dawn_arrow" src="{{ asset('user/images/down.gif') }}" alt="..."
                                        class="w-100 h-100">
    
                                </div>
                                @if ($data->stage >= 7)

                                <div  class="active">
                                    Pending RA Approval
                                </div>
                                @else
                                <div  class="mini_buttons">
                                    Pending RA Approval
                                </div>
                                @endif
                                <div class="down-logo">
                                    <img class="dawn_arrow" src="{{ asset('user/images/down.gif') }}" alt="..."
                                        class="w-100 h-100">
    
                                </div>
                                @if ($data->stage >= 8)
                                <div class="active" @if($data->stage == 9) style="display: none" @endif>QA/CQA Head/Manager Designee Approval</div>
                                @else
                                    <div class="mini_buttons" @if($data->stage == 9) style="display: none" @endif>QA/CQA Head/Manager Designee Approval</div>
                                @endif

                                <div class="down-logo">
                                    <img class="dawn_arrow" src="{{ asset('user/images/down.gif') }}" alt="..."
                                        class="w-100 h-100">
    
                                </div>
                                @if ($data->stage >= 10)
                                <div class="active" @if($data->stage == 9) style="display: none" @endif>Pending Initiator Update</div>
                                @else
                                    <div class="mini_buttons" @if($data->stage == 9) style="display: none" @endif>Pending Initiator Update</div>
                                @endif
                                <div class="down-logo">
                                    <img class="dawn_arrow" src="{{ asset('user/images/down.gif') }}" alt="..."
                                        class="w-100 h-100">
    
                                </div>
                                @if ($data->stage >= 11)
                                <div class="active" @if($data->stage == 9) style="display: none" @endif>HOD Final Review</div>
                                @else
                                    <div class="mini_buttons" @if($data->stage == 9) style="display: none" @endif>HOD Final Review</div>
                                @endif
                                <div class="down-logo">
                                    <img class="dawn_arrow" src="{{ asset('user/images/down.gif') }}" alt="..."
                                        class="w-100 h-100">
    
                                </div>
                                @if ($data->stage >= 12)
                                <div class="active" @if($data->stage == 9) style="display: none" @endif>Implementation Verification by QA/CQA</div>
                                @else
                                    <div class="mini_buttons" @if($data->stage == 9) style="display: none" @endif>Implementation Verification by QA/CQA</div>
                                @endif
                               

                                <div class="down-logo">
                                    <img class="dawn_arrow" src="{{ asset('user/images/down.gif') }}" alt="..."
                                        class="w-100 h-100">
    
                                </div>
                                @if ($data->stage >= 13)
                                <div class="active" @if($data->stage == 9) style="display: none" @endif>QA/CQA Closure Approval</div>
                                @else
                                    <div class="mini_buttons" @if($data->stage == 9) style="display: none" @endif>QA/CQA Closure Approval</div>
                                @endif

                                <div class="down-logo">
                                    <img class="dawn_arrow" src="{{ asset('user/images/down.gif') }}" alt="..." class="w-100 h-100">
                                </div>
                                @if ($data->stage >= 14)
                                <div class="active bg-danger" @if($data->stage == 9) style="display: none" @endif>Closed - Done</div>
                                @else
                                    <div class="mini_buttons" @if($data->stage == 9) style="display: none" @endif>Closed - Done</div>
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
                            <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">General Information</button>
                            <button class="cctablinks" onclick="openCity(event, 'CCForm18')">Impact Assessment</button>
                            <button class="cctablinks" onclick="openCity(event, 'CCForm7')" style="display: none" id="riskAssessmentButton">Risk Assessment</button>
                            <button class="cctablinks" onclick="openCity(event, 'CCForm12')">Initial HOD Review</button>
                            <button class="cctablinks" onclick="openCity(event, 'CCForm2')">Change Details</button>
                       
                            <button class="cctablinks" onclick="openCity(event, 'CCForm3')">QA/CQA Review</button>
                            <button class="cctablinks" onclick="openCity(event, 'CCForm11')">CFT</button>
                            <button class="cctablinks " onclick="openCity(event, 'CCForm19')">External Review</button>
                            <button class="cctablinks" onclick="openCity(event, 'CCForm14')">QA Final Review</button>
                            <button class="cctablinks" onclick="openCity(event, 'CCForm15')"  style="display: none" id="actionButton">RA</button>
                            <button class="cctablinks" onclick="openCity(event, 'CCForm17')">QA/CQA Designee Approval</button>
                           
                            <button class="cctablinks" onclick="openCity(event, 'CCForm4')">Evaluation</button>
                            <button class="cctablinks" onclick="openCity(event, 'CCForm5')"> Initiator Update</button>
                            <button class="cctablinks" onclick="openCity(event, 'CCForm6')">HOD Final review</button>
                            <button class="cctablinks" onclick="openCity(event, 'CCForm16')">Implementation Verification</button>
                            <button class="cctablinks" onclick="openCity(event, 'CCForm9')">Change Closure</button>
                            <button class="cctablinks" onclick="openCity(event, 'CCForm10')">Activity Log</button>
                        </div>

                        <form id="CCFormInput" action="{{ route('global-cc-update', $data->id) }}" method="POST"
                            enctype="multipart/form-data">
                        <input type="hidden" name="stage" id="stage" value="{{ $data->stage }}" >

                            @csrf
                            @method('PUT')

                            <!-- Tab content -->
                            <div id="step-form">

                                <div id="CCForm1" class="inner-block cctabcontent">
                                    <div class="inner-block-content">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="group-input">
                                                    <label for="rls">Record Number</label>
                                                    <div class="static">
                                                        @if($data->stage >= 3)
                                                            <input type="text" disabled value="{{ Helpers::getDivisionName($data->division_id) }}/CC/{{ date('Y') }}/{{ str_pad($data->record, 4, '0', STR_PAD_LEFT) }}">
                                                            <input type="hidden" name="record_number"  value="{{ Helpers::getDivisionName($data->division_id) }}/CC/{{ date('Y') }}/{{ str_pad($data->record, 4, '0', STR_PAD_LEFT) }}">
                                                        @endif
                                                        @if($data->record_number != null)
                                                            <input type="hidden" placeholder="{{ $data->record_number }}" readonly >
                                                        @else
                                                            <input type="text" placeholder="Record Number" readonly >
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="group-input">
                                                    <label for="Division Code"><b>Division Code</b></label>
                                                    <input readonly type="text" name="division_code"
                                                        value="{{ Helpers::getDivisionName($data->division_id) }}">
                                                </div>
                                            </div>
                                            
                                            <div class="col-lg-6">
                                                <div class="group-input">
                                                    <label for="Initiator">Initiator</label>
                                                    <div class="static"><input readonly type="text"
                                                            value="{{ Helpers::getInitiatorName($data->initiator_id) }}"></div>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="group-input">
                                                    <label for="date_initiation">Date of Initiation</label>
                                                    <div class="static"><input readonly type="text" value="{{ Helpers::getdateFormat($data->intiation_date) }}"></div>
                                                </div>
                                            </div>

                                            <div class="col-lg-6 new-date-data-field">
                                                <div class="group-input input-date">
                                                    <label for="Due Date"> Due Date</label>
                                                    <div>
                                                        <small class="text-primary">If revising Due Date, kindly mention the revision
                                                            reason in the "Due Date Extension Justification" data field.</small>
                                                    </div>
                                                    <div class="calenderauditee">
                                                        @php
                                                            $formattedDate = str_contains('NaN-undefined-NaN', $data->due_date) ? '' : Helpers::getdateFormat($data->due_date);
                                                        @endphp
                                                        <input type="text" id="due_date" name="due_date" placeholder="Select Due Date" value="{{ $formattedDate }}" />
                                                    </div>
                                                    <script>
                                                        $(document).ready(function() {
                                                            $("#due_date").datepicker({
                                                                dateFormat: "dd-M-yy",
                                                                // Do not set a default date, let the user select it
                                                                onClose: function(dateText, inst) {
                                                                    if (!dateText) {
                                                                        $(this).val('');  // Ensure input stays empty if no date is selected
                                                                    }
                                                                }
                                                            });
                                                        });
                                                    </script>
                                                </div>
                                            </div>
                                                
                                            <div class="col-lg-6">
                                                <div class="group-input">
                                                    <label for="initiator-group">Initiation Department</label>
                                                    <select name="Initiator_Group" id="initiator_group" >
                                                        <option value="">-- Select --</option>
                                                        <option value="CQA"
                                                            @if ($data->Initiator_Group == 'CQA') selected @endif>Corporate Quality Assurance</option>
                                                        <option value="QA"
                                                            @if ($data->Initiator_Group == 'QA') selected @endif>Quality Assurance</option>
                                                        <option value="QC"
                                                            @if ($data->Initiator_Group == 'QC') selected @endif>Quality Control</option>
                                                        <option value="QM"
                                                            @if ($data->Initiator_Group == 'QM') selected @endif>Quality Control (Microbiology department)
                                                        </option>
                                                        <option value="PG"
                                                            @if ($data->Initiator_Group == 'PG') selected @endif>Production General</option>
                                                        <option value="PL"
                                                            @if ($data->Initiator_Group == 'PL') selected @endif>Production Liquid Orals</option>
                                                        <option value="PT"
                                                            @if ($data->Initiator_Group == 'PT') selected @endif>Production Tablet and Powder</option>
                                                        <option value="PE"
                                                            @if ($data->Initiator_Group == 'PE') selected @endif>Production External (Ointment, Gels, Creams and Liquid)</option>
                                                        <option value="PC"
                                                            @if ($data->Initiator_Group == 'PC') selected @endif>Production Capsules</option>
                                                        <option value="PI"
                                                            @if ($data->Initiator_Group == 'PI') selected @endif>Production Injectable</option>
                                                        <option value="EN"
                                                            @if ($data->Initiator_Group == 'EN') selected @endif>Engineering</option>
                                                        <option value="HR"
                                                            @if ($data->Initiator_Group == 'HR') selected @endif>Human Resource</option>
                                                        <option value="ST"
                                                            @if ($data->Initiator_Group == 'ST') selected @endif>Store</option>
                                                        <option value="IT"
                                                            @if ($data->Initiator_Group == 'IT') selected @endif>Electronic Data Processing
                                                        </option>
                                                        <option value="FD"
                                                            @if ($data->Initiator_Group == 'FD') selected @endif>Formulation  Development
                                                        </option>
                                                        <option value="AL"
                                                            @if ($data->Initiator_Group == 'AL') selected @endif>Analytical research and Development Laboratory
                                                        </option>
                                                        <option value="PD"
                                                            @if ($data->Initiator_Group == 'PD') selected @endif>Packaging Development
                                                        </option>

                                                        <option value="PU"
                                                            @if ($data->Initiator_Group == 'PU') selected @endif>Purchase Department
                                                        </option>
                                                        <option value="DC"
                                                            @if ($data->Initiator_Group == 'DC') selected @endif>Document Cell
                                                        </option>
                                                        <option value="RA"
                                                            @if ($data->Initiator_Group == 'RA') selected @endif>Regulatory Affairs
                                                        </option>
                                                        <option value="PV"
                                                            @if ($data->Initiator_Group == 'PV') selected @endif>Pharmacovigilance
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <input type="hidden" name="Initiator_Group" value="{{ $data->Initiator_Group }}" >

                                            <div class="col-lg-6">
                                                <div class="group-input">
                                                    <label for="Initiation Group Code">Initiation Department Code</label>
                                                    <input type="text" name="initiator_group_code"
                                                        value="{{ $data->Initiator_Group }}" id="initiator_group_code"
                                                        readonly>
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

                                                <script>
                                                $(document).ready(function() {
                                                    function toggleButtons() {
                                                        var selectedValue = $('#RA_head_required').val();
                                                        
                                                        console.log("Selected value:", selectedValue); // Debugging output

                                                        if (selectedValue === 'Yes') {
                                                            $('#actionButton').show();           
                                                            $('#pendingRAApproval').show();  
                                                            console.log("show"); // Debugging output
                                                        } else {
                                                            $('#actionButton').hide();         
                                                            $('#pendingRAApproval').hide();     
                                                            console.log("hide"); // Debugging output
                                                        }
                                                    }

                                                    // Handle change event
                                                    $('#RA_head_required').on('change', function() {
                                                        toggleButtons();
                                                    });

                                                    // Handle initial state
                                                    toggleButtons();
                                                });
                                                </script>

                                            <div class="col-lg-6">
                                                <div class="group-input">
                                                    <label for="Risk Assessment Required">Risk Assessment Required? </label>
                                                    <select name="risk_assessment_required" id="risk_assessment_required" {{ $data->stage == 0 || $data->stage == 13 ? 'readonly' : '' }} >
                                                        <option value="">-- Select --</option>
                                                        <option @if ($data->risk_assessment_required == 'yes') selected @endif value='yes'>Yes</option>
                                                        <option @if ($data->risk_assessment_required == 'no') selected @endif value='no'>No</option>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            <div class="col-lg-6" id="justification_div" style="display:none;">
                                                <div class="group-input">
                                                    <label for="Justification">Justification</label>
                                                    <div class="relative-container">
                                                        <textarea name="risk_identification" id="justification" rows="2" placeholder="Provide justification if risk assessment is not required." >{{ $data->risk_identification ?? '' }}</textarea>                                                    
                                                        @component('frontend.forms.language-model', ['readonly' => $data->stage == 0 || $data->stage == 13])
                                                        @endcomponent
                                                    </div>
                                                </div>
                                            </div>

                                            @php
                                                $userRoles = DB::table('user_roles')
                                                    ->where([
                                                        'q_m_s_roles_id' => 4,
                                                        'q_m_s_divisions_id' => $data->division_id,
                                                    ])
                                                    ->get();
                                                $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                                $users = DB::table('users')->whereIn('id', $userRoleIds)->get();
                                            @endphp

                                            <div class="col-lg-6">
                                                <div class="group-input">
                                                    <label for="hod_person">HOD Person</label>
                                                    <select name="hod_person" id="hod_person" {{ $data->stage == 0 || $data->stage == 13 ? 'readonly' : '' }} >
                                                        <option value="">Select HOD Persion</option>
                                                        @if($users)
                                                            @foreach($users as $user)
                                                                <option value="{{ $user->id }}" @if ($user->id == $data->hod_person) selected @endif>{{ $user->name }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="group-input">
                                                    <label for="Short Description">Short Description<span
                                                            class="text-danger">*</span></label><span id="rchars"
                                                        class="text-primary">255 </span><span class="text-primary">
                                                        characters remaining</span>

                                                        <div class="relative-container">
                                                            <input name="short_description" id="docname" type="text" maxlength="255" required type="text" 
                                                        {{ $data->stage == 0 || $data->stage == 13 ? 'readonly' : '' }} value="{{ $data->short_description }}">
                                                            @component('frontend.forms.language-model', ['readonly' => $data->stage == 0 || $data->stage == 13])
                                                            @endcomponent
                                                        </div>                                                    
                                                </div>
                                                <p id="docnameError" style="color:red">**Short Description is required</p>

                                            </div>
                                            
                                            <div class="col-lg-12">
                                                <div class="group-input" id="validation_requirment">
                                                    <label for="validation_requirment">Validation Requirement</label>
                                                    <div class="relative-container">
                                                        <textarea name="validation_requirment" >{{ $fields->validation_requirment }}</textarea>
                                                        @component('frontend.forms.language-model', ['readonly' => $data->stage == 0 || $data->stage == 13])
                                                        @endcomponent
                                                    </div>                                                   
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="group-input">
                                                    <label for="priority_data">Priority</label>
                                                    <select name="priority_data" placeholder="Select Reference Records"
                                                        data-search="false" data-silent-initial-value-set="true"
                                                        id="priority_data" >
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
                                            
                                            <div class="col-12">
                                                <div class="group-input">
                                                    <label for="Product">Product/Material</label>
                                                    <div class="relative-container">
                                                        <input  type="text" id="product_name" name="product_name"  {{ $data->stage == 0 || $data->stage == 13 ? 'readonly' : '' }} value="{{ $data->product_name }}" maxlength="255">                                                
                                                        @component('frontend.forms.language-model', ['readonly' => $data->stage == 0 || $data->stage == 13])
                                                        @endcomponent
                                                    </div>
                                                    </div>
                                            </div>
                                            
                                             <div class="col-lg-6">
                                                <div class="group-input">
                                                    <label for="change_related_to">Change Related To</label>
                                                    <select name="severity" id="change_related_to"   {{ $data->stage == 0 || $data->stage == 13 ? 'readonly' : '' }}>
                                                        <option value="">-- Select --</option>
                                                        <option value="process" {{ old('severity', $data->severity ?? '') == 'process' ? 'selected' : '' }}>Process</option>
                                                        <option value="facility" {{ old('severity', $data->severity ?? '') == 'facility' ? 'selected' : '' }}>Facility</option>
                                                        <option value="utility" {{ old('severity', $data->severity ?? '') == 'utility' ? 'selected' : '' }}>Utility</option>
                                                        <option value="equipment" {{ old('severity', $data->severity ?? '') == 'equipment' ? 'selected' : '' }}>Equipment</option>
                                                        <option value="document" {{ old('severity', $data->severity ?? '') == 'document' ? 'selected' : '' }}>Document</option>
                                                        <option value="other" {{ old('severity', $data->severity ?? '') == 'other' ? 'selected' : '' }}>Other</option>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            <!-- Textbox for 'Other' option -->
                                            <div class="col-lg-6" id="other_specify_div" style="display:none;">
                                                <div class="group-input">
                                                    <label for="other_specify">Please specify</label>
                                                    <div class="relative-container">
                                                        <input  type="text" name="Occurance" id="other_specify" value="{{ $data->Occurance ?? '' }}" placeholder="Specify if Other is selected">                                                    
                                                        @component('frontend.forms.language-model', ['readonly' => $data->stage == 0 || $data->stage == 13])
                                                        @endcomponent
                                                    </div>                                                    
                                                </div>
                                            </div>
                                            
                                            <script>
                                                $(document).ready(function() {
                                                    function toggleOtherSpecifyField() {
                                                        var changeRelatedTo = $('#change_related_to').val();
                                                        if (changeRelatedTo === 'other') {
                                                            $('#other_specify_div').show();
                                                        } else {
                                                            $('#other_specify_div').hide();
                                                        }
                                                    }
                                            
                                                    toggleOtherSpecifyField(); // Initial check
                                            
                                                    // Update field visibility on dropdown change
                                                    $('#change_related_to').change(function() {
                                                        toggleOtherSpecifyField();
                                                    });
                                                });
                                            </script>
                                            

                                            <div class="col-lg-6">
                                                <div class="group-input">
                                                    <label for="Initiator Group">Initiated Through</label>
                                                    <div><small class="text-primary">Please select related
                                                            information</small></div>
                                                    <select name="initiated_through"
                                                        onchange="otherController(this.value, 'others', 'initiated_through_req')"  {{ $data->stage == 0 || $data->stage == 13 ? 'readonly' : '' }}>
                                                        <option value="">Enter Your Selection Here</option>
                                                        <option @if ($data->initiated_through == 'recall') selected @endif
                                                            value="recall">Recall</option>
                                                        <option @if ($data->initiated_through == 'return') selected @endif
                                                            value="return">Return</option>
                                                        <option @if ($data->initiated_through == 'deviation') selected @endif
                                                            value="deviation">Deviation</option>
                                                        <option @if ($data->initiated_through == 'complaint') selected @endif
                                                            value="complaint">Complaint</option>
                                                        <option @if ($data->initiated_through == 'regulatory') selected @endif
                                                            value="regulatory">Regulatory</option>
                                                        <option @if ($data->initiated_through == 'lab-incident') selected @endif
                                                            value="lab-incident">Lab Incident</option>
                                                        <option @if ($data->initiated_through == 'improvement') selected @endif
                                                            value="improvement">Improvement</option>
                                                        <option @if ($data->initiated_through == 'others') selected @endif
                                                            value="others">Others</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="group-input" id="initiated_through_req">
                                                    <label for="initiated_through">Others<span
                                                            class="text-danger d-none">*</span></label>
                                                            <div class="relative-container">
                                                                <textarea  name="initiated_through_req"  {{ $data->stage == 0 || $data->stage == 13 ? 'readonly' : '' }}>{{ $data->initiated_through_req }}</textarea>                                                
                                                                @component('frontend.forms.language-model', ['readonly' => $data->stage == 0 || $data->stage == 13])
                                                                @endcomponent
                                                            </div>
                                                    </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="group-input">
                                                    <label for="repeat">Repeat</label>
                                                    <div><small class="text-primary">Please select yes if it is has
                                                            recurred in past six months</small></div>
                                                    <select name="repeat" 
                                                        onchange="otherController(this.value, 'yes', 'repeat_nature')"  {{ $data->stage == 0 || $data->stage == 13 ? 'readonly' : '' }}>
                                                        <option value="">Enter Your Selection Here</option>
                                                        <option @if ($data->repeat == 'yes') selected @endif
                                                            value="yes">Yes</option>
                                                        <option @if ($data->repeat == 'no') selected @endif
                                                            value="no">No</option>
                                                        <option @if ($data->repeat == 'na') selected @endif
                                                            value="na">NA</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="group-input" id="repeat_nature">
                                                    <label for="repeat_nature">Repeat Nature<span
                                                            class="text-danger d-none">*</span></label>
                                                            <div class="relative-container">
                                                                <textarea  name="repeat_nature"  {{ $data->stage == 0 || $data->stage == 13 ? 'readonly' : '' }}>{{ $data->repeat_nature }}</textarea>                                                
                                                                @component('frontend.forms.language-model', ['readonly' => $data->stage == 0 || $data->stage == 13])
                                                                @endcomponent
                                                            </div>
                                                    </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="group-input">
                                                    <label for="nature-change">Nature Of Change</label>
                                                    <select  name="doc_change"  {{ $data->stage == 0 || $data->stage == 13 ? 'readonly' : '' }}>
                                                        <option value="">-- Select --</option>
                                                        <option {{ $data->doc_change == 'Temporary' ? 'selected' : '' }}
                                                            value="Temporary">Temporary
                                                        </option>
                                                        <option {{ $data->doc_change == 'Permanent' ? 'selected' : '' }}
                                                            value="Permanent">Permanent
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="group-input">
                                                    <label for="others">If Others</label>
                                                    <div class="relative-container">
                                                        <textarea  name="others">{{ $data->If_Others }}</textarea>
                                                        @component('frontend.forms.language-model', ['readonly' => $data->stage == 0 || $data->stage == 13])
                                                        @endcomponent
                                                    </div>                                                    
                                                </div>
                                            </div>

                                            @if ($data->in_attachment)
                                                @foreach (json_decode($data->in_attachment) as $file)
                                                    <input id="initialFile-{{ $loop->index }}" type="hidden"
                                                        name="existing_initial_files[{{ $loop->index }}]"
                                                        value="{{ $file }}">
                                                @endforeach
                                            @endif

                                            <div class="col-lg-12">
                                                <div class="group-input">
                                                    <label for="others">Initial attachment</label>
                                                    <div><small class="text-primary">Please Attach all relevant or
                                                            supporting documents</small></div>
                                                    <div class="file-attachment-field">
                                                        <div readonly class="file-attachment-list" id="in_attachment">
                                                            @if ($data->in_attachment)
                                                                @foreach (json_decode($data->in_attachment) as $file)
                                                                    <h6 type="button" class="file-container text-dark"
                                                                        style="background-color: rgb(243, 242, 240);">
                                                                        <b>{{ $file }}</b>
                                                                        <a href="{{ asset('upload/' . $file) }}"
                                                                            target="_blank"><i
                                                                                class="fa fa-eye text-primary"
                                                                                style="font-size:20px; margin-right:-10px;"></i></a>
                                                                        <a type="button" class="remove-file"
                                                                            data-remove-id="initialFile-{{ $loop->index }}"
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
                                                                {{ $data->stage == 0 || $data->stage == 13 ? 'readonly' : '' }}
                                                                type="file" id="myfile" name="in_attachment[]"
                                                                oninput="addMultipleFiles(this, 'in_attachment')" multiple>
                                                        </div>

                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="button-block">
                                            <button type="submit" class="saveButton">Save</button>
                                            <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                            <button type="button" style=" justify-content: center; width: 4rem; margin-left: 1px;;">
                                                <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">Exit</a>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div id="CCForm18" class="inner-block cctabcontent">
                                    <div class="inner-block-content">
                                        <label style="font-weight: bold;" for="Audit Attachments">Impact Assessment</label>
                                        
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="group-input">
                                                    <div class="why-why-chart">
                                                        <table class="table table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th style="width: 5%;">Sr.No.</th>
                                                                    <th style="width: 20%;">Change in(Item)</th>
                                                                    <th style="width: 30%;">Impact On(Due to change in item)</th>
                                                                    <th style="width: 20%;">Supportive Data / Justification Required</th>
                                                                    <th style="width: 20%;">Remarks</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>
                                                                        1.1
                                                                    </td>
                                                                    <td>
                                                                        Mfg. Formula / Components and composition
                                                                    </td>
                                                                    <td>
                                                                        <ul>
                                                                            <li>Batch Manufacturing Record</li>
                                                                            <li>Training</li>
                                                                            <li>Stability Studies/Shelf Life</li>
                                                                            <li>Label Claim of Printed PM</li>
                                                                            <li>Regulatory Approval</li>
                                                                            <li>Product Permission</li>
                                                                            <li>Process Validation</li>
                                                                            <li>Partial Analytical Method Validation (e.g., In case of change in color of tablet, placebo
                                                                                interference should be checked)</li>
                                                                            <li>FP Specification & ATP</li>
                                                                            <li>In-process Specification & ATP</li>
                                                                            <li>Stability Protocol</li>
                                                                            <li>Bill of Raw Material</li>
                                                                            <li>Cleaning Validation</li>
                                                                            <li>Customer Approval</li>
                                                                            <li>Change of MBR, PBR</li>
                                                                        </ul>
                                                                    </td>
                                                                    <td>In process & FP analytical trend Supportive data received from F&D Scientific rationale</td>
                                                                    <td>
                                                                        <div style="margin: auto; display: flex; justify-content: center;">
                                                                            <textarea  name="remark_que1" style="border-radius: 7px; border: 1.5px solid black;">{{ $getImpactData->remark_que1 }}</textarea>
                                                                        </div>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td>
                                                                        1.1.1
                                                                    </td>
                                                                    <td>
                                                                        Manufacturing Site
                                                                    </td>
                                                                    <td>
                                                                        <ul>
                                                                            <li>Batch Manufacturing Record</li>
                                                                            <li>Analytical Documents</li>
                                                                            <li>Training</li>
                                                                            <li>Process Validation</li>
                                                                        </ul>
                                                                    </td>
                                                                    <td>
                                                                        Same working principle of machines/equipment Equipment Qualification Scientific rational. Equipment
                                                                        equivalence
                                                                    </td>
                                                                    <td>
                                                                        <div style="margin: auto; display: flex; justify-content: center;">
                                                                            <textarea  name="remark_que2" style="border-radius: 7px; border: 1.5px solid black;">{{ $getImpactData->remark_que2 }}</textarea>
                                                                        </div>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td>
                                                                    1.1.2
                                                                    </td>
                                                                    <td>
                                                                        Batch size
                                                                    </td>
                                                                    <td>
                                                                        <ul>
                                                                            <li>Batch Manufacturing Record</li>
                                                                            <li>Training</li>
                                                                            <li>Process Validation</li>
                                                                            <li>Bill of Raw Material</li>
                                                                            <li>Regulatory Approval</li>
                                                                            <li>Revision of MFR and/or MPR</li>
                                                                            <li>Equipment Design and Qualification Status</li>
                                                                        </ul>
                                                                    </td>
                                                                    <td>
                                                                        In process & FP analytical trend
                                                                    </td>
                                                                    <td>
                                                                        <div style="margin: auto; display: flex; justify-content: center;">
                                                                            <textarea  name="remark_que3" style="border-radius: 7px; border: 1.5px solid black;">{{ $getImpactData->remark_que3 }}</textarea>
                                                                        </div>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td>
                                                                    1.1.3
                                                                    </td>
                                                                    <td>
                                                                        Critical manufacturing equipment/
                                                                    </td>
                                                                    <td>
                                                                        <ul>
                                                                            <li>Batch Manufacturing Record</li>
                                                                            <li>Training</li>
                                                                            <li>Equipment Equivalence (Operating Principle, Design, Operating Parameters, Manufacturing
                                                                                Capacity), Impact on Product</li>
                                                                        </ul>
                                                                    </td>

                                                                    <td>
                                                                        Calibration of the equipment. Equipment Qualification Equipment equivalence
                                                                    </td>
                                                                    <td>
                                                                        <div style="margin: auto; display: flex; justify-content: center;">
                                                                            <textarea  name="remark_que4" style="border-radius: 7px; border: 1.5px solid black;">{{ $getImpactData->remark_que4 }}</textarea>
                                                                        </div>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td>
                                                                    1.1.4
                                                                    </td>
                                                                    <td>
                                                                        Cleaning Procedure
                                                                    </td>
                                                                    <td>
                                                                        <ul>
                                                                            <li>Cleaning Validation</li>
                                                                        </ul>
                                                                    </td>

                                                                    <td>
                                                                        Cleaning validation/ Verification protocol
                                                                    </td>
                                                                    <td>
                                                                        <div style="margin: auto; display: flex; justify-content: center;">
                                                                            <textarea  name="remark_que5" style="border-radius: 7px; border: 1.5px solid black;">{{ $getImpactData->remark_que5 }}</textarea>
                                                                        </div>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td>
                                                                    1.1.5
                                                                    </td>
                                                                    <td>
                                                                        Mfg. procedure
                                                                    </td>
                                                                    <td>
                                                                        <ul>
                                                                            <li>Batch Manufacturing Record</li>
                                                                            <li>Training</li>
                                                                            <li>Stability Studies/Shelf Life</li>
                                                                        </ul>
                                                                    </td>

                                                                    <td>
                                                                        In process & FP analytical Trend Supportive data received from F&D
                                                                    </td>
                                                                    <td>
                                                                        <div style="margin: auto; display: flex; justify-content: center;">
                                                                            <textarea  name="remark_que6" style="border-radius: 7px; border: 1.5px solid black;">{{ $getImpactData->remark_que6 }}</textarea>
                                                                        </div>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td>
                                                                    1.1.6
                                                                    </td>
                                                                    <td>
                                                                        Instrument / machine
                                                                    </td>
                                                                    <td>
                                                                        <ul>
                                                                            <li>Standard Operating Procedure (SOP)</li>
                                                                            <li>Training to the Chemist/Analyst</li>
                                                                            <li>Master BMR/Analytical Documents</li>
                                                                        </ul>
                                                                    </td>
                                                                    <td>
                                                                        Supportive data to prove no impact on core quality
                                                                    </td>
                                                                    <td>
                                                                        <div style="margin: auto; display: flex; justify-content: center;">
                                                                            <textarea  name="remark_que7" style="border-radius: 7px; border: 1.5px solid black;">{{ $getImpactData->remark_que7 }}</textarea>
                                                                        </div>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td>
                                                                    1.1.7
                                                                    </td>
                                                                    <td>
                                                                        FP Specification
                                                                    </td>
                                                                    <td>
                                                                        <ul>
                                                                            <li>FP STP</li>
                                                                            <li>Stability Protocol</li>
                                                                            <li>Training to the Analyst</li>
                                                                            <li>Method Validation</li>
                                                                            <li>FP Template/LIMS</li>
                                                                            <li>Batch Manufacturing Record</li>
                                                                        </ul>
                                                                    </td>
                                                                    <td>
                                                                        Any supportive document received from F&D FP analytical trend / historical data Change in Pharmacopoeial
                                                                        limit / method. Comparative data study
                                                                    </td>
                                                                    <td>
                                                                        <div style="margin: auto; display: flex; justify-content: center;">
                                                                            <textarea  name="remark_que8" style="border-radius: 7px; border: 1.5px solid black;">{{ $getImpactData->remark_que8 }}</textarea>
                                                                        </div>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td>
                                                                    1.1.8
                                                                    </td>
                                                                    <td>
                                                                        Test method
                                                                    </td>
                                                                    <td>
                                                                        <ul>
                                                                            <li>ATP (Analytical Test Procedure)</li>
                                                                            <li>Training to Analyst</li>
                                                                            <li>Impact on Available Lots/Batches</li>
                                                                            <li>Analytical Method Validation</li>
                                                                            <li>Analytical Tech Transfer</li>
                                                                        </ul>
                                                                    </td>
                                                                    <td>
                                                                        Supportive data from F&D Any Pharmacopoeial reference Comparative study data
                                                                    </td>
                                                                    <td>
                                                                        <div style="margin: auto; display: flex; justify-content: center;">
                                                                            <textarea  name="remark_que9" style="border-radius: 7px; border: 1.5px solid black;">{{ $getImpactData->remark_que9 }}</textarea>
                                                                        </div>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td>
                                                                    1.1.9
                                                                    </td>
                                                                    <td>
                                                                        Stability protocol
                                                                    </td>
                                                                    <td>
                                                                        <ul>
                                                                            <li>Stability Specification</li>
                                                                            <li>Stability Analytical Test Procedure</li>
                                                                            <li>Training to Analyst</li>
                                                                        </ul>
                                                                    </td>
                                                                    <td>
                                                                        Any supportive document received from F&D. Change in Pharmacopoeial limit / method.
                                                                    </td>
                                                                    <td>
                                                                        <div style="margin: auto; display: flex; justify-content: center;">
                                                                            <textarea  name="remark_que10" style="border-radius: 7px; border: 1.5px solid black;">{{ $getImpactData->remark_que10 }}</textarea>
                                                                        </div>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td>
                                                                    1.1.10
                                                                    </td>
                                                                    <td>
                                                                        RM specification
                                                                    </td>
                                                                    <td>
                                                                        <ul>
                                                                            <li>RM Standard Test Procedure</li>
                                                                            <li>Raw Material Inventory System</li>
                                                                            <li>RM Directory/Sample Justification Sheet</li>
                                                                            <li>BMR and BOM</li>
                                                                            <li>Label Claim of Printed Packing Material, if Applicable</li>
                                                                            <li>Training to the Analyst</li>
                                                                            <li>Method Validation</li>
                                                                            <li>RM Template</li>
                                                                        </ul>
                                                                    </td>
                                                                    <td>
                                                                        RM analytical trend. Any supportive document received from F&D Change in Pharmacopoeial limit
                                                                        Comparative data study RM analytical trend/ historical data
                                                                    </td>
                                                                    <td>
                                                                        <div style="margin: auto; display: flex; justify-content: center;">
                                                                            <textarea  name="remark_que11" style="border-radius: 7px; border: 1.5px solid black;">{{ $getImpactData->remark_que11 }}</textarea>
                                                                        </div>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td>
                                                                    1.1.11
                                                                    </td>
                                                                    <td>
                                                                        In the process specification/ control specification
                                                                    </td>
                                                                    <td>
                                                                        <ul>
                                                                            <li>In Process Analytical Test Procedure</li>
                                                                            <li>Batch Manufacturing Record</li>
                                                                            <li>Training to the Analyst</li>
                                                                            <li>Process Validation</li>
                                                                            <li>Cleaning Validation</li>
                                                                            <li>Stability Studies</li>
                                                                            <li>Regulatory Approval</li>
                                                                            <li>Revision of Specification</li>
                                                                            <li>Customer Approval</li>
                                                                            <li>Impact on Controlling/Monitoring Instrument</li>
                                                                        </ul>
                                                                    </td>
                                                                    <td>
                                                                        In process analytical trend Any supportive document received from F&D Comparative study data
                                                                    </td>
                                                                    <td>
                                                                        <div style="margin: auto; display: flex; justify-content: center;">
                                                                            <textarea  name="remark_que12" style="border-radius: 7px; border: 1.5px solid black;">{{ $getImpactData->remark_que12 }}</textarea>
                                                                        </div>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td>
                                                                    1.1.12
                                                                    </td>
                                                                    <td>
                                                                        Secondary(printed/ un-printed) packaging material
                                                                    </td>
                                                                    <td>
                                                                        <ul>
                                                                            <li>Batch Packing Record</li>
                                                                            <li>Packing Material Specification and ATP</li>
                                                                            <li>Pack Profile</li>
                                                                            <li>Training to the Analyst</li>
                                                                            <li>Packaging Material Inventory System</li>
                                                                        </ul>
                                                                    </td>
                                                                    <td>
                                                                        Copy of revised artwork of printed pkg. material.Justification for the change
                                                                    </td>
                                                                    <td>
                                                                        <div style="margin: auto; display: flex; justify-content: center;">
                                                                            <textarea  name="remark_que13" style="border-radius: 7px; border: 1.5px solid black;">{{ $getImpactData->remark_que13 }}</textarea>
                                                                        </div>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td>
                                                                    1.1.13
                                                                    </td>
                                                                    <td>
                                                                        Shelf Life
                                                                    </td>
                                                                    <td>
                                                                        <ul>
                                                                            <li>Master BMR</li>
                                                                            <li>Stability Study / Stability Protocol</li>
                                                                            <li>Change in Specification</li>
                                                                            <li>Customer Approval</li>
                                                                            <li>Regulatory Approval or Effect on Specification (Material Sampling & Handling Sheet)</li>
                                                                        </ul>
                                                                    </td>
                                                                    <td>
                                                                        Supportive data from F&D Supportive stability study
                                                                    </td>
                                                                    <td>
                                                                        <div style="margin: auto; display: flex; justify-content: center;">
                                                                            <textarea  name="remark_que14" style="border-radius: 7px; border: 1.5px solid black;">{{ $getImpactData->remark_que14 }}</textarea>
                                                                        </div>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td>
                                                                    1.1.14
                                                                    </td>
                                                                    <td>
                                                                        RM Source / Supplier
                                                                    </td>
                                                                    <td>
                                                                        <ul>
                                                                            <li>Stability Study (If Active)</li>
                                                                            <li>Stability Protocol</li>
                                                                            <li>Vendor Approval</li>
                                                                            <li>Regulatory Effect</li>
                                                                            <li>API Specification and ATPs</li>
                                                                            <li>Inclusion of Vendor in Approved Vendor List</li>
                                                                            <li>Process Validation</li>
                                                                            <li>Vendor Qualification</li>
                                                                            <li>Method Transfer, If Required</li>
                                                                        </ul>
                                                                    </td>
                                                                    <td>
                                                                        Comparative study between different RM lot Comparative study of finished product manufactured from these
                                                                        RM
                                                                    </td>
                                                                    <td>
                                                                        <div style="margin: auto; display: flex; justify-content: center;">
                                                                            <textarea  name="remark_que15" style="border-radius: 7px; border: 1.5px solid black;">{{ $getImpactData->remark_que15 }}</textarea>
                                                                        </div>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td>
                                                                    1.1.15
                                                                    </td>
                                                                    <td>
                                                                        Any standard formats / System
                                                                    </td>
                                                                    <td>
                                                                        <ul>
                                                                            <li>Standard Operating Procedure(SOP). Training to the analyst.</li>
                                                                        </ul>
                                                                    </td>
                                                                    <td>

                                                                        Any audit comments. Reference of any incidence report Supportive trend / literature.
                                                                    </td>
                                                                    <td>
                                                                        <div style="margin: auto; display: flex; justify-content: center;">
                                                                            <textarea  name="remark_que16" style="border-radius: 7px; border: 1.5px solid black;">{{ $getImpactData->remark_que16 }}</textarea>
                                                                        </div>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td>
                                                                    1.1.16
                                                                    </td>
                                                                    <td>
                                                                        Change in item code of API/ Excipient / Intermediate/ Raw material
                                                                    </td>
                                                                    <td>
                                                                        <ul>
                                                                            <li>All Products BMR/BOM in Which Material is Used</li>
                                                                            <li>ERP</li>
                                                                            <li>Spec/ATP/Stability Protocol</li>
                                                                            <li>Package Insert/Label/Foil</li>
                                                                            <li>Process Validation Protocol</li>
                                                                            <li>Vendor Qualification</li>
                                                                            <li>Identification of Affected Stock for HOLD</li>
                                                                            <li>Identification of Affected Stock for Rejection</li>
                                                                            <li>Regulatory Approval</li>
                                                                            <li>Revision of Finished Product Specification</li>
                                                                            <li>Revision of Raw Material Specification</li>
                                                                            <li>Revision of Specification of Packing Material</li>
                                                                        </ul>
                                                                    </td>
                                                                    <td>
                                                                        Supportive data to prove no impact on FP quality
                                                                    </td>
                                                                    <td>
                                                                        <div style="margin: auto; display: flex; justify-content: center;">
                                                                            <textarea  name="remark_que17" style="border-radius: 7px; border: 1.5px solid black;">{{ $getImpactData->remark_que17 }}</textarea>
                                                                        </div>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td>
                                                                    1.1.17
                                                                    </td>
                                                                    <td>
                                                                        Inclusion of new pack size
                                                                    </td>
                                                                    <td>
                                                                        <ul>
                                                                            <li>Revision of Stability Protocol</li>
                                                                            <li>Stability Study</li>
                                                                            <li>Process Validation</li>
                                                                            <li>Packing Order</li>
                                                                            <li>Revision of Pack Style</li>
                                                                            <li>Processing of Artwork</li>
                                                                        </ul>
                                                                    </td>
                                                                    <td>
                                                                        Marketing requirement
                                                                    </td>
                                                                    <td>
                                                                        <div style="margin: auto; display: flex; justify-content: center;">
                                                                            <textarea  name="remark_que18" style="border-radius: 7px; border: 1.5px solid black;">{{ $getImpactData->remark_que18 }}</textarea>
                                                                        </div>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td>
                                                                    1.1.18
                                                                    </td>
                                                                    <td>
                                                                        Change in Tablet Description: Addition /deletion of break line / quarter line Change in embossing /
                                                                        debossing Change in shape of break line (fish shape /straight line)
                                                                    </td>
                                                                    <td>
                                                                        <ul>
                                                                            <li>Trial to Break the Tablets</li>
                                                                            <li>One Batch Dissolution / CU of Half Tablet – One-Time Study</li>
                                                                            <li>Friability</li>
                                                                            <li>Package Insert</li>
                                                                            <li>Stability Protocol</li>
                                                                            <li>BMR</li>
                                                                            <li>Process Validation Protocol (Exhibit/Stability)</li>
                                                                            <li>Reporting Category as per SUPAC</li>
                                                                            <li>Information to FDA</li>
                                                                        </ul>
                                                                    </td>
                                                                    <td>
                                                                        F&D recommendation
                                                                    </td>
                                                                    <td>
                                                                        <div style="margin: auto; display: flex; justify-content: center;">
                                                                            <textarea  name="remark_que19" style="border-radius: 7px; border: 1.5px solid black;">{{ $getImpactData->remark_que19 }}</textarea>
                                                                        </div>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td>
                                                                    1.1.19
                                                                    </td>
                                                                    <td>
                                                                        Inclusion or deletion of pack size or count per bottle
                                                                    </td>
                                                                    <td>
                                                                        <ul>
                                                                            <li>Package Insert (National Drug Code)</li>
                                                                            <li>Packing Order</li>
                                                                            <li>Pack Style</li>
                                                                        </ul>
                                                                    </td>
                                                                    <td>
                                                                        Marketing requirement.
                                                                    </td>
                                                                    <td>
                                                                        <div style="margin: auto; display: flex; justify-content: center;">
                                                                            <textarea  name="remark_que20" style="border-radius: 7px; border: 1.5px solid black;">{{ $getImpactData->remark_que20 }}</textarea>
                                                                        </div>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td>
                                                                    1.1.20
                                                                    </td>
                                                                    <td>
                                                                        Existing Product/ Equipment/ Discontinuation
                                                                    </td>
                                                                    <td>
                                                                        <ul>
                                                                            <li>Cleaning Validation for Worst Case Identification/MACO Calculations</li>
                                                                            <li>Rejection of Raw Material/Packing Material Stock or Transfer to Other Location Decision for
                                                                                Continuation of Stability Study</li>
                                                                            <li>Updation of Product Planning</li>
                                                                            <li>To Cancel the Order of Raw Materials/Packing Materials</li>
                                                                            <li>Update of Cleaning Validation Matrix</li>
                                                                            <li>Retrieval of Operational Copies of SOP</li>
                                                                            <li>Update Calibration Calendar, PM Calendar, RQ Calendar, Inventory List</li>
                                                                        </ul>
                                                                    </td>
                                                                    <td>
                                                                        Product discontinuation instruction details
                                                                    </td>
                                                                    <td>
                                                                        <div style="margin: auto; display: flex; justify-content: center;">
                                                                            <textarea  name="remark_que21" style="border-radius: 7px; border: 1.5px solid black;">{{ $getImpactData->remark_que21 }}</textarea>
                                                                        </div>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td>
                                                                    1.1.21
                                                                    </td>
                                                                    <td>
                                                                        Site Transfer
                                                                    </td>
                                                                    <td>
                                                                        <ul>
                                                                            <li>Availability of Identical Equipment</li>
                                                                            <li>VMP/Facility</li>
                                                                            <li>Qualification/Equipment/Critical Utility Qualification</li>
                                                                            <li>Whether Batch Size has been Changed</li>
                                                                            <li>Process Validation</li>
                                                                            <li>Cleaning Validation</li>
                                                                            <li>Analytical Method Transfer/Mfg. Tech Transfer</li>
                                                                            <li>Stability Study</li>
                                                                            <li>MF/MBR Revision</li>
                                                                            <li>Availability of Manufacturing License</li>
                                                                            <li>Approval by Regulatory</li>
                                                                            <li>Resource Adequacy in Terms of Manpower and Infrastructure</li>
                                                                        </ul>
                                                                    </td>
                                                                    <td>
                                                                        Product information
                                                                    </td>
                                                                    <td>
                                                                        <div style="margin: auto; display: flex; justify-content: center;">
                                                                            <textarea   name="remark_que22" style="border-radius: 7px; border: 1.5px solid black;">{{ $getImpactData->remark_que22 }}</textarea>
                                                                        </div>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td>
                                                                    1.1.22
                                                                    </td>
                                                                    <td>
                                                                        New Product
                                                                    </td>
                                                                    <td>
                                                                        <ul>
                                                                            <li>Vendor Qualification</li>
                                                                            <li>Availability of Regulatory Approval</li>
                                                                            <li>Stability Study</li>
                                                                            <li>Inclusion of Vendor in Approved Vendor List</li>
                                                                            <li>Approval of MF and MI (Manufacturing Instructions)</li>
                                                                            <li>Approval PO (Packaging Order) and PI (Packaging Instruction)</li>
                                                                            <li>Process Validation</li>
                                                                            <li>Availability of Scale-Up Report</li>
                                                                            <li>Availability of Test Batch/Exhibit Batch Monitoring Report</li>
                                                                            <li>Cleaning Validation</li>
                                                                            <li>Resource Adequacy in Terms of Human Resources and Infrastructure Requirements</li>
                                                                            <li>Impact on Contamination/Containment Issues</li>
                                                                            <li>Analytical Test Method Development Verification/Validation</li>
                                                                        </ul>
                                                                    </td>
                                                                    <td>
                                                                        Product details
                                                                    </td>
                                                                    <td>
                                                                        <div style="margin: auto; display: flex; justify-content: center;">
                                                                            <textarea   name="remark_que23" style="border-radius: 7px; border: 1.5px solid black;">{{ $getImpactData->remark_que23 }}</textarea>
                                                                        </div>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td>1.1.23

                                                                    </td>
                                                                    <td>
                                                                        New equipment
                                                                    </td>
                                                                    <td>
                                                                        <ul>
                                                                            <li>Identical Equipment</li>
                                                                            <li>Design Qualification</li>
                                                                            <li>Installation Qualification</li>
                                                                            <li>Utilities Requirements</li>
                                                                            <li>Operational Qualification</li>
                                                                            <li>Performance Qualification</li>
                                                                            <li>Operation and Cleaning SOP</li>
                                                                            <li>Cleaning Validation</li>
                                                                            <li>Process Validation</li>
                                                                            <li>Revision of MI/PI</li>
                                                                            <li>Preventive Maintenance SOP</li>
                                                                            <li>Calibration of SOP</li>
                                                                            <li>Stability Studies</li>
                                                                            <li>Equipment Equivalence</li>
                                                                            <li>Regulatory Approval</li>
                                                                            <li>Update in Equipment Inventory/RQ (Re-Qualification) Calendar</li>
                                                                            <li>Update in Calibration Calendar</li>
                                                                            <li>Update in Preventive Maintenance Calendar</li>
                                                                            <li>Equipment Log</li>
                                                                            <li>Sterilization SOP</li>
                                                                            <li>Update Equipment Layout</li>
                                                                            <li>Update Validation Matrix (VMP)</li>
                                                                            <li>Microbiology (e.g. Media Fill, EM)</li>
                                                                            <li>Special Training</li>
                                                                            <li>Specialized Resources</li>
                                                                            <li>Revision to As-Built Engineering Diagrams</li>
                                                                        </ul>
                                                                    </td>
                                                                    <td>
                                                                        Equipment qualification
                                                                    </td>
                                                                    <td>
                                                                        <div style="margin: auto; display: flex; justify-content: center;">
                                                                            <textarea  name="remark_que24" style="border-radius: 7px; border: 1.5px solid black;">{{ $getImpactData->remark_que24 }}</textarea>
                                                                        </div>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td>
                                                                    1.1.24
                                                                    </td>
                                                                    <td>
                                                                        hange in Equipment
                                                                    </td>
                                                                    <td>
                                                                        <ul>
                                                                            <li>Utilities Requirements</li>
                                                                            <li>Cleaning Validation</li>
                                                                            <li>Process Validation</li>
                                                                            <li>Revision of MI/PI</li>
                                                                            <li>Stability Studies</li>
                                                                            <li>Equipment Equivalence</li>
                                                                            <li>Regulatory Approval</li>
                                                                            <li>Update in Equipment Inventory/RQ (Re-Qualification) Calendar</li>
                                                                            <li>Update in Calibration Calendar</li>
                                                                            <li>Update in Preventive Maintenance Calendar</li>
                                                                            <li>Equipment Log/History Record</li>
                                                                            <li>Supplementary Qualification or IQ/OQ/PQ</li>
                                                                        </ul>
                                                                    </td>
                                                                    <td>
                                                                        Change in facility
                                                                    </td>
                                                                    <td>
                                                                        <div style="margin: auto; display: flex; justify-content: center;">
                                                                            <textarea  name="remark_que25" style="border-radius: 7px; border: 1.5px solid black;">{{ $getImpactData->remark_que25 }}</textarea>
                                                                        </div>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td>
                                                                    1.1.25
                                                                    </td>
                                                                    <td>
                                                                        Change in Layout/Facility
                                                                    </td>
                                                                    <td>
                                                                        <li>Is There a Change in Layout</li>
                                                                        <li>Environment Control as per Specialization (HVAC)</li>
                                                                        <li>Area Qualification/Re-Qualification</li>
                                                                        <li>Contamination/Cross Contamination</li>
                                                                        <li>Special Training</li>
                                                                        <li>Impact on Available Resources</li>
                                                                        <li>Approval of Regulatory Agency</li>
                                                                        <li>Revision to As-Built Engineering Diagrams</li>
                                                                    </td>
                                                                    <td>
                                                                        Changes in Site master file
                                                                    </td>
                                                                    <td>
                                                                        <div style="margin: auto; display: flex; justify-content: center;">
                                                                            <textarea  name="remark_que26" style="border-radius: 7px; border: 1.5px solid black;">{{ $getImpactData->remark_que26 }}</textarea>
                                                                        </div>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td>
                                                                    1.1.26
                                                                    </td>
                                                                    <td>
                                                                        Change in utility equipment
                                                                    </td>
                                                                    <td>
                                                                        <ul>
                                                                            <li>Supplementary Qualification or IQ/OQ/PQ</li>
                                                                            <li>Update in Calibration Calendar</li>
                                                                            <li>Update in Preventive Maintenance Calendar</li>
                                                                            <li>Revision to As-Built Engineering Diagrams</li>
                                                                        </ul>
                                                                    </td>
                                                                    <td>
                                                                        Change in utility equipment
                                                                    </td>
                                                                    <td>
                                                                        <div style="margin: auto; display: flex; justify-content: center;">
                                                                            <textarea  name="remark_que27" style="border-radius: 7px; border: 1.5px solid black;">{{ $getImpactData->remark_que27 }}</textarea>
                                                                        </div>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td>
                                                                    1.1.27
                                                                    </td>
                                                                    <td>
                                                                        Change in art work/Packaging material/Labelling change
                                                                    </td>
                                                                    <td>
                                                                        <ul>
                                                                            <li>Revision of PO/PI</li>
                                                                            <li>Revision of Artwork</li>
                                                                            <li>Revision of Packaging Specification</li>
                                                                            <li>Regulatory Approval</li>
                                                                            <li>Identification of Affected Stock for HOLD and Blocking of Existing Code for Further Ordering
                                                                            </li>
                                                                            <li>Destruction of Negative/Plates at Vendor End</li>
                                                                            <li>Marketing Approval</li>
                                                                            <li>Identification of Affected Stocks for Rejection</li>
                                                                        </ul>
                                                                    </td>
                                                                    <td>
                                                                        Art work
                                                                    </td>
                                                                    <td>
                                                                        <div style="margin: auto; display: flex; justify-content: center;">
                                                                            <textarea  name="remark_que28" style="border-radius: 7px; border: 1.5px solid black;">{{ $getImpactData->remark_que28 }}</textarea>
                                                                        </div>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td>
                                                                    1.1.28
                                                                    </td>
                                                                    <td>
                                                                        Change in Vendor
                                                                    </td>
                                                                    <td>
                                                                        <ul>
                                                                            <li>API Specs and STPs</li>
                                                                            <li>Method Transfer, If Required</li>
                                                                            <li>Vendor Qualification</li>
                                                                            <li>Inclusion of Vendor in Approved Vendor List</li>
                                                                            <li>Stability Study</li>
                                                                            <li>Regulatory Approval Available</li>
                                                                            <li>Process Validation</li>
                                                                        </ul>
                                                                    </td>
                                                                    <td>
                                                                        Vendor qualification
                                                                    </td>
                                                                    <td>
                                                                        <div style="margin: auto; display: flex; justify-content: center;">
                                                                            <textarea name="remark_que29" style="border-radius: 7px; border: 1.5px solid black;">{{ $getImpactData->remark_que29 }}</textarea>
                                                                        </div>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td>
                                                                    1.1.29
                                                                    </td>
                                                                    <td>
                                                                        Change in Document (Specification/ STP/ SOP/ Protocol)
                                                                    </td>
                                                                    <td>
                                                                        <ul>
                                                                            <li>Document Revision</li>
                                                                            <li>Regulatory Approval</li>
                                                                            <li>Training</li>
                                                                        </ul>
                                                                    </td>
                                                                    <td>
                                                                        System implementation
                                                                    </td>
                                                                    <td>
                                                                        <div style="margin: auto; display: flex; justify-content: center;">
                                                                            <textarea  name="remark_que30" style="border-radius: 7px; border: 1.5px solid black;">{{ $getImpactData->remark_que30 }}</textarea>
                                                                        </div>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td>
                                                                    1.1.30
                                                                    </td>
                                                                    <td>
                                                                        Regulatory agency
                                                                    </td>
                                                                    <td>
                                                                        <ul>
                                                                            <li>Any requirement of regulatory agency</li>
                                                                        </ul>
                                                                    </td>
                                                                    <td>
                                                                        Regulatory requirement
                                                                    </td>
                                                                    <td>
                                                                        <div style="margin: auto; display: flex; justify-content: center;">
                                                                            <textarea  name="remark_que31" style="border-radius: 7px; border: 1.5px solid black;">{{ $getImpactData->remark_que31 }}</textarea>
                                                                        </div>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td>
                                                                    1.1.31
                                                                    </td>
                                                                    <td>
                                                                        Personal and General Issues
                                                                    </td>
                                                                    <td>
                                                                        <ul>
                                                                            <li>Customer Requirement</li>
                                                                            <li>Marketing Requirement</li>
                                                                        </ul>
                                                                    </td>
                                                                    <td>
                                                                        Requirement
                                                                    </td>
                                                                    <td>
                                                                        <div style="margin: auto; display: flex; justify-content: center;">
                                                                            <textarea  name="remark_que32" style="border-radius: 7px; border: 1.5px solid black;">{{ $getImpactData->remark_que32 }}</textarea>
                                                                        </div>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td>
                                                                    1.1.32
                                                                    </td>
                                                                    <td>
                                                                        GxP Computer system
                                                                    </td>
                                                                    <td>
                                                                        <ul>
                                                                            <li>Change in GxP Category 3, 4, 5 Computer Systems, Revision of SOP</li>
                                                                            <li>Change in Infrastructure Components</li>
                                                                            <li>Supplementary Qualification or IQ/OQ/PQ</li>
                                                                        </ul>
                                                                    </td>
                                                                    <td>
                                                                        Computer system qualification
                                                                    </td>
                                                                    <td>
                                                                        <div style="margin: auto; display: flex; justify-content: center;">
                                                                            <textarea  name="remark_que33" style="border-radius: 7px; border: 1.5px solid black;">{{ $getImpactData->remark_que33 }}</textarea>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                
                                        <!-- Save and Navigation buttons -->
                                        <div class="button-block">
                                            <button type="submit" id="ChangesaveButton" class="saveButton">Save</button>
                                            <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                            <button type="button" id="ChangeNextButton" class="nextButton" onclick="nextStep()">Next</button>
                                            <button type="button">
                                                <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">Exit</a>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div id="CCForm7" class="inner-block cctabcontent">
                                    <div class="inner-block-content">
                                        <div class="sub-head">
                                            Risk Assessment
                                        </div>

                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="risk_assessment_related_record">Related Records</label>
                                                <select  multiple id="risk_assessment_related_record" name="risk_assessment_related_record[]" placeholder="Select Reference Records" 
                                                        data-search="false" data-silent-initial-value-set="true"  {{ $data->stage == 0 || $data->stage == 13 ? 'readonly' : '' }}>
                                                    @foreach ($preRiskAssessment as $prix)
                                                        <option value="{{ $prix->id }}"
                                                            {{ in_array($prix->id, explode(',', $data->risk_assessment_related_record)) ? 'selected' : '' }}>
                                                            {{ Helpers::getDivisionName($prix->division_id) }}/Risk-Assessment/{{ Helpers::year($prix->created_at) }}/{{ Helpers::record($prix->record) }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        
                                            <div class="col-12">
                                                <div class="group-input">
                                                    <label for="migration-action">comments</label>
                                                    <textarea  name="migration_action"  {{ $data->stage == 0 || $data->stage == 13 ? 'readonly' : '' }}>{{ $data->migration_action }}</textarea>
                                                </div>
                                            </div>

                                            @if ($data->risk_assessment_atch)
                                                @foreach (json_decode($data->risk_assessment_atch) as $file)
                                                    <input id="riskAssessmentFile-{{ $loop->index }}" type="hidden"
                                                        name="existinRiskAssessmentFile[{{ $loop->index }}]"
                                                        value="{{ $file }}">
                                                @endforeach
                                            @endif
                                            <div class="group-input">
                                                <label for="tran-attach">Risk Assessment Attachment</label>
                                                <div class="file-attachment-field">
                                                    <div class="file-attachment-list" id="risk_assessment_atch">
                                                        @if ($data->risk_assessment_atch)
                                                            @foreach (json_decode($data->risk_assessment_atch) as $file)
                                                                <h6 type="button" class="file-container text-dark"
                                                                    style="background-color: rgb(243, 242, 240);">
                                                                    <b>{{ $file }}</b>
                                                                    <a href="{{ asset('upload/' . $file) }}"
                                                                        target="_blank"><i class="fa fa-eye text-primary"
                                                                            style="font-size:20px; margin-right:-10px;"></i></a>
                                                                    <a type="button" class="remove-file"                                                                    
                                                                            data-remove-id="riskAssessmentFile-{{ $loop->index }}"
                                                                            data-file-name="{{ $file }}"><i
                                                                            class="fa-solid fa-circle-xmark"
                                                                            style="color:red; font-size:20px;"></i></a>
                                                                </h6>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                    <div class="add-btn">
                                                        <div>Add</div>
                                                        <input type="file" id="myfile" name="risk_assessment_atch[]"
                                                            oninput="addMultipleFiles(this, 'risk_assessment_atch')"  {{ $data->stage == 0 || $data->stage == 13 ? 'readonly' : '' }} multiple>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                        <div class="button-block">
                                            <button type="submit" class="saveButton">Save</button>
                                            <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                            <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                            <button type="button" style=" justify-content: center; width: 4rem; margin-left: 1px;;">
                                                <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">Exit</a>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div id="CCForm12" class="inner-block cctabcontent">
                                    <div class="inner-block-content">
                                        <div class="sub-head">
                                        HOD Assessment 
                                        </div>
                                        <div class="group-input">
                                            <label for="qa-eval-comments">HOD Assessment Comments  @if($data->stage == 2) <span class="text-danger">*</span>@endif
                                        </label>
                                        <div class="relative-container">
                                            <textarea name="hod_assessment_comments"  {{ $data->stage == 0 || $data->stage == 13 ? 'readonly' : '' }} >{{$data->hod_assessment_comments}}</textarea>
                                            @component('frontend.forms.language-model', ['readonly' => $data->stage == 0 || $data->stage == 13])
                                            @endcomponent
                                        </div>                                            
                                        </div>

                                        @if ($data->hod_assessment_attachment)
                                                @foreach (json_decode($data->hod_assessment_attachment) as $file)
                                                    <input id="hodAssessmentAttachmentFile-{{ $loop->index }}" type="hidden"
                                                        name="existinQAFile[{{ $loop->index }}]"
                                                        value="{{ $file }}">
                                                @endforeach
                                            @endif
                                            <div class="col-lg-12">
                                                <div class="group-input">
                                                    <label for="qa head">HOD Assessment Attachments</label>
                                                    <div class="file-attachment-field">
                                                    <div class="file-attachment-list" id="hod_assessment_attachment">
                                                @if (!empty($data->hod_assessment_attachment))
                                                    @foreach (json_decode($data->hod_assessment_attachment) as $file)
                                                        <h6 class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                            <b>{{ $file }}</b>
                                                            <a href="{{ asset('upload/' . $file) }}" target="_blank">
                                                                <i class="fa fa-eye text-primary" style="font-size:20px; margin-right:-10px;"></i>
                                                            </a>
                                                            <a class="remove-file" data-remove-id="hodAttachmentFile-{{ $loop->index }}" data-file-name="{{ $file }}">
                                                                <i class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i>
                                                            </a>
                                                        </h6>
                                                    @endforeach
                                                @endif
                                            </div>

                                                        <div class="add-btn">
                                                            <div>Add</div>
                                                            <input type="file" id="myfile" name="hod_assessment_attachment[]" 
                                                                oninput="addMultipleFiles(this, 'hod_assessment_attachment')" multiple {{ $data->stage == 0 || $data->stage == 8 || $data->stage == 13 ? 'readonly' : '' }}>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>  


                                        </div>
                                        <div class="button-block">
                                            <button type="submit" class="saveButton">Save</button>
                                            <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                            <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                            <button type="button" style=" justify-content: center; width: 4rem; margin-left: 1px;;">
                                                <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">Exit</a>
                                            </button>
                                        </div>
                                    </div>
                                
                                <div id="CCForm2" class="inner-block cctabcontent">
                                    <div class="inner-block-content">
                                        <div class="sub-head">
                                            Change Details
                                        </div>
                                        <div class="row">
                                            
                                           

                                            <div class="col-12">
                                                <div class="group-input">
                                                    <label for="current-practice">
                                                        Current Practice
                                                    </label>
                                                    <div class="relative-container">
                                                        <textarea  name="current_practice"  {{ $data->stage == 0 || $data->stage == 13 ? 'readonly' : '' }}>{{ $data->current_practice }}</textarea>
                                                        @component('frontend.forms.language-model', ['readonly' => $data->stage == 0 || $data->stage == 13])
                                                        @endcomponent
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="group-input">
                                                    <label for="proposed_change">
                                                        Proposed Change
                                                    </label>
                                                    <div class="relative-container">
                                                        <textarea  name="proposed_change"  {{ $data->stage == 0 || $data->stage == 13 ? 'readonly' : '' }}>{{ $data->proposed_change }}</textarea>
                                                        @component('frontend.forms.language-model', ['readonly' => $data->stage == 0 || $data->stage == 13])
                                                        @endcomponent
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="group-input">
                                                    <label for="reason_change">
                                                        Reason for Change
                                                    </label>
                                                    <div class="relative-container">
                                                        <textarea  name="reason_change"  {{ $data->stage == 0 || $data->stage == 13 ? 'readonly' : '' }}>{{ $data->reason_change }}</textarea>
                                                        @component('frontend.forms.language-model', ['readonly' => $data->stage == 0 || $data->stage == 13])
                                                        @endcomponent
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="group-input">
                                                    <label for="other_comment">
                                                        Any Other Comments
                                                    </label>
                                                    <div class="relative-container">
                                                        <textarea  name="other_comment"  {{ $data->stage == 0 || $data->stage == 13 ? 'readonly' : '' }}>{{ $data->other_comment }}</textarea>
                                                        @component('frontend.forms.language-model', ['readonly' => $data->stage == 0 || $data->stage == 13])
                                                        @endcomponent
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <div class="button-block">
                                            <button type="submit" class="saveButton">Save</button>
                                            <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                            <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                            <button type="button" style=" justify-content: center; width: 4rem; margin-left: 1px;;">
                                                <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">Exit</a>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                                <script>
                                    $(document).ready(function() {
                                        // Event listener for the remove file button
                                        $(document).on('click', '.remove-file', function() {
                                            $(this).closest('.file-container').remove();
                                        });
                                    });
                                </script>

                                <div id="CCForm3" class="inner-block cctabcontent">
                                    <div class="inner-block-content">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="group-input">
                                                    <label for="severity-level">Classification of Change @if($data->stage == 3) <span class="text-danger">*</span>@endif</label>
                                                    <select name="severity_level1" {{ $data->stage == 0 || $data->stage == 8 || $data->stage == 13 ? 'readonly' : '' }}>
                                                        <option value="">-- Select --</option>
                                                        <option @if ($data->severity_level1 == 'minor') selected @endif
                                                            value="minor">Minor</option>
                                                        <option @if ($data->severity_level1 == 'major') selected @endif
                                                            value="major">Major</option>
                                                        <option @if ($data->severity_level1 == 'critical') selected @endif
                                                            value="critical">Critical</option>
                                                    </select>
                                                </div>
                                            </div>

                                            @php 
                                                $getExternalUsers = DB::table('user_roles')->where(['q_m_s_roles_id' => '79'])->select(['user_id', DB::raw('MAX(q_m_s_divisions_id) as q_m_s_divisions_id')])->groupBy('user_id')->get();
                                                $userIds = collect($getExternalUsers)->pluck('user_id')->toArray();
                                                $getExternalUser = DB::table('users')->whereIn('id', $userIds)->select('id', 'name', 'email')->get();
                                            @endphp
                                            <div class="col-12">
                                                <div class="group-input">
                                                    <label for="risk_assessment_related_record">External Review User</label>
                                                    <select multiple id="external_mutipleusers" name="external_users[]"
                                                        placeholder="Select External User" data-search="false"
                                                        data-silent-initial-value-set="true">
                                                        @foreach ($getExternalUser as $users)
                                                            <option value="{{ $users->id }}" {{ in_array($users->id, explode(',', $data->external_users)) ? 'selected' : '' }}>
                                                                {{ $users->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="group-input">
                                                    <label for="qa_comments">QA Initial Review Comments @if($data->stage == 3) <span class="text-danger">*</span>@endif</label>
                                                    <div class="relative-container">
                                                        <textarea  name="qa_review_comments" {{ $data->stage == 0 || $data->stage == 8 || $data->stage == 13 ? 'readonly' : '' }}>{{ $data->qa_review_comments }}</textarea>
                                                        @component('frontend.forms.language-model', ['readonly' => $data->stage == 0 || $data->stage == 8 || $data->stage == 13])
                                                        @endcomponent
                                                    </div>
                                                    
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="group-input">
                                                    <label for="related_records">Related Records</label>
                                                    <select{{ $data->stage == 0 || $data->stage == 8 || $data->stage == 13 ? 'readonly' : '' }}
                                                        multiple id="related_records" name="related_records[]"
                                                        placeholder="Select Reference Records" data-search="false"
                                                        data-silent-initial-value-set="true">
                                                        @foreach ($pre as $prix)
                                                            <option value="{{ $prix->id }}" {{ in_array($prix->id, explode(',', $data->related_records)) ? 'selected' : '' }}>
                                                                {{ Helpers::getDivisionName($prix->division_id) }}/Change-Control/{{ Helpers::year($prix->created_at) }}/{{ Helpers::record($prix->record) }}
                                                            </option>
                                                           
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>



                                         @if ($data->qa_head)
                                                @foreach (json_decode($data->qa_head) as $file)
                                                    <input id="QaAttachmentFile-{{ $loop->index }}" type="hidden"
                                                        name="existinQAFile[{{ $loop->index }}]"
                                                        value="{{ $file }}">
                                                @endforeach
                                            @endif
                                            <div class="col-lg-12">
                                                <div class="group-input">
                                                    <label for="qa head">QA Attachments</label>
                                                    <div class="file-attachment-field">
                                                        <div class="file-attachment-list" id="qa_head">
                                                            @if ($data->qa_head)
                                                                @foreach (json_decode($data->qa_head) as $file)
                                                                    <h6 type="button" class="file-container text-dark"
                                                                        style="background-color: rgb(243, 242, 240);">
                                                                        <b>{{ $file }}</b>
                                                                        <a href="{{ asset('upload/' . $file) }}"
                                                                            target="_blank"><i
                                                                                class="fa fa-eye text-primary"
                                                                                style="font-size:20px; margin-right:-10px;"></i></a>
                                                                        <a type="button" class="remove-file"
                                                                            data-remove-id="QaAttachmentFile-{{ $loop->index }}"
                                                                            data-file-name="{{ $file }}"><i
                                                                                class="fa-solid fa-circle-xmark"
                                                                                style="color:red; font-size:20px;"></i></a>
                                                                    </h6>
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                        <div class="add-btn">
                                                            <div>Add</div>
                                                            <input type="file" id="myfile" name="qa_head[]" 
                                                                oninput="addMultipleFiles(this, 'qa_head')" multiple {{ $data->stage == 0 || $data->stage == 8 || $data->stage == 13 ? 'readonly' : '' }}>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>  


                                        </div>
                                        <div class="button-block">
                                            <button type="submit" class="saveButton">Save</button>
                                            <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                            <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                            <button type="button" style=" justify-content: center; width: 4rem; margin-left: 1px;;">
                                                <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">Exit</a>
                                            </button>
                                        </div>
                                    </div>
                                </div>


                                
                                <div id="CCForm11" class="inner-block cctabcontent">
                                    <div class="inner-block-content">
                                        <div class="row">

                                            <div class="sub-head">
                                                Production
                                            </div>
                                            @php
                                                $data1 = DB::table('global_change_controls_cfts')
                                                    ->where('cc_id', $data->id)
                                                    ->first();
                                            @endphp
                                            <script>
                                                $(document).ready(function() {
                                                    @if($data1->Production_Review !== 'yes')
                                                        $('.p_erson').hide();
                                                        $('[name="Production_Review"]').change(function() {
                                                            if ($(this).val() === 'yes') {
                                                                $('.p_erson').show();
                                                                $('.p_erson span').show();
                                                            } else {
                                                                $('.p_erson').hide();
                                                                $('.p_erson span').hide();
                                                            }
                                                        });
                                                    @endif
                                                });
                                            </script>
                                            @if($data->stage == 3 || $data->stage == 4)
                                                <div class="col-lg-6">
                                                    <div class="group-input">
                                                        <label for="Production Review">Production Review Required ?<span class="text-danger">*</span></label>
                                                        <select name="Production_Review" id="Production_Review" required @if ($data->stage == 4) readonly @endif>
                                                            <option value="">-- Select --</option>
                                                            <option @if($data1->Production_Review == "yes") selected @endif value="yes">Yes</option>
                                                            <option @if($data1->Production_Review == "no") selected @endif value="no">No</option>
                                                            <option @if($data1->Production_Review == "na") selected @endif value="na">NA</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                @php
                                                    $userRoles = DB::table('user_roles')
                                                    ->where([
                                                        'q_m_s_roles_id' => 22,
                                                        'q_m_s_divisions_id' => $data->division_id,
                                                    ])->get();
                                                    $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                                    $users = DB::table('users')->whereIn('id', $userRoleIds)->get();
                                                @endphp

                                                <div class="col-lg-6 p_erson">
                                                    <div class="group-input">
                                                        <label for="Production person">Production Person <span id="asteriskPT1"
                                                                    style="display: {{ $data1->Production_Review == 'yes' && $data->stage == 4 ? 'inline' : 'none' }}"
                                                                    class="text-danger">*</span></label>
                                                        <select name="Production_person" id="Production_person" @if ($data->stage == 4) readonly @endif>
                                                            <option value="">-- Select --</option>
                                                            @foreach ($users as $user)
                                                                <option value="{{ $user->id }}" @if($data1->Production_person == $user->id) selected @endif>{{ $user->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Any Other Specify -->
                                                <div class="col-md-12 mb-3 p_erson">
                                                    <div class="group-input">
                                                        <label for="Production_assessment">Production Assessment<span id="asteriskPT2"
                                                                    style="display: {{ $data1->Production_Review == 'yes' && $data->stage == 4 ? 'inline' : 'none' }}"
                                                                    class="text-danger">*</span></label>
                                                        <textarea class="" name="Production_assessment" id="summernote-17" @if ($data1->Production_Review == 'yes' && $data->stage == 4) required @endif
                                                        @if ($data->stage == 3 || (isset($data1->Production_person) && Auth::user()->id != $data1->Production_person)) readonly @endif value="{{ $data1->Production_assessment }}">{{ $data1->Production_assessment }}</textarea>
                                                    </div>
                                                </div>

                                                <div class="col-md-12 mb-3 p_erson">
                                                    <div class="group-input">
                                                        <label for="Production assessment">Production Feedback <span id="asteriskPT2"
                                                                    style="display: {{ $data1->Production_Review == 'yes' && $data->stage == 4 ? 'inline' : 'none' }}"
                                                                    class="text-danger">*</span></label>
                                                        <div><small class="text-primary">Please insert "NA" in the data field if it does
                                                                not require completion</small></div>
                                                        <textarea class="" name="Production_feedback" id="summernote-17" @if ($data1->Production_Review == 'yes' && $data->stage == 4) required @endif
                                                        @if ($data->stage == 3 || (isset($data1->Production_person) && Auth::user()->id != $data1->Production_person)) readonly @endif value="{{ $data1->Production_feedback }}">{{ $data1->Production_feedback }}</textarea>
                                                    </div>
                                                </div>


                                                <div class="col-12 p_erson">
                                                    <div class="group-input">
                                                        <label for="Production Tablet attachment">Production Attachments</label>
                                                        <div><small class="text-primary">Please Attach all relevant or supporting
                                                                documents</small></div>
                                                        <div class="file-attachment-field">
                                                            <div readonly class="file-attachment-list" id="production_attachment">
                                                                @if ($data1->production_attachment)
                                                                    @foreach (json_decode($data1->production_attachment) as $file)
                                                                        <h6 type="button" class="file-container text-dark"
                                                                            style="background-color: rgb(243, 242, 240);">
                                                                            <b>{{ $file }}</b>
                                                                            <a href="{{ asset('upload/' . $file) }}" target="_blank"><i
                                                                                    class="fa fa-eye text-primary"
                                                                                    style="font-size:20px; margin-right:-10px;"></i></a>
                                                                            <a type="button" class="remove-file" data-file-name="{{ $file }}"><i
                                                                                    class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i></a>
                                                                        </h6>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                            <div class="add-btn">
                                                                <div>Add</div>
                                                                <input {{ $data->stage == 0 || $data->stage == 8 ? 'readonly' : '' }} type="file"
                                                                    id="myfile"
                                                                    name="production_attachment[]"{{ $data->stage == 0 || $data->stage == 8 ? 'readonly' : '' }}
                                                                    oninput="addMultipleFiles(this, 'production_attachment')" multiple>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 mb-3 p_erson">
                                                    <div class="group-input">
                                                        <label for="Production Tablet Completed By">Production Completed By</label>
                                                        <input readonly type="text" value="{{ $data1->Production_by }}"
                                                            name="Production_by"{{ $data->stage == 0 || $data->stage == 8 ? 'readonly' : '' }} id="Production_by">
                                                    </div>
                                                </div>

                                                <div class="col-6 mb-3 p_erson new-date-data-field">
                                                    <div class="group-input input-date">
                                                        <label for="Production Tablet Completed On">Production Completed On</label>
                                                        <div class="calenderauditee">
                                                            <input type="text" id="production_on" readonly
                                                                placeholder="DD-MMM-YYYY"
                                                                value="{{ Helpers::getdateFormat($data1->production_on) }}" />
                                                            <input readonly type="date" name="production_on"
                                                                min="{{ \Carbon\Carbon::now()->format('d-M-Y') }}" value=""
                                                                class="hide-input"
                                                                oninput="handleDateInput(this, 'production_on')" />
                                                        </div>
                                                        @error('production_on')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            @else
                                                <div class="col-lg-6">
                                                    <div class="group-input">
                                                        <label for="Production Review">Production Review Required ?</label>
                                                        <select name="Production_Review" id="Production_Review" readonly>
                                                            <option value="">-- Select --</option>
                                                            <option @if($data1->Production_Review == "yes") selected @endif value="yes">Yes</option>
                                                            <option @if($data1->Production_Review == "no") selected @endif value="no">No</option>
                                                            <option @if($data1->Production_Review == "na") selected @endif value="na">NA</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                @php
                                                    $userRoles = DB::table('user_roles')
                                                    ->where([
                                                        'q_m_s_roles_id' => 22,
                                                        'q_m_s_divisions_id' => $data->division_id,
                                                    ])->get();
                                                    $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                                    $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                                                @endphp

                                                <div class="col-lg-6 p_erson">
                                                    <div class="group-input">
                                                        <label for="Production person">Production Person</label>
                                                        <select name="Production_person" id="Production_person" readonly>
                                                            <option value="">-- Select --</option>
                                                            @foreach ($users as $user)
                                                                <option value="{{ $user->id }}" @if($data1->Production_person == $user->id) selected @endif>{{ $user->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Any Other Specify -->
                                                <div class="col-md-12 mb-3 p_erson">
                                                    <div class="group-input">
                                                        <label for="Production_assessment">Production Assessment</label>
                                                        <textarea class="" name="Production_assessment" id="summernote-17" readonly value="{{ $data1->Production_assessment }}">{{ $data1->Production_assessment }}</textarea>
                                                    </div>
                                                </div>

                                                <div class="col-md-12 mb-3 p_erson">
                                                    <div class="group-input">
                                                        <label for="Production assessment">Production Feedback</label>
                                                        <div><small class="text-primary">Please insert "NA" in the data field if it does
                                                                not require completion</small></div>
                                                        <textarea class="" name="Production_feedback" id="summernote-17" readonly value="{{ $data1->Production_feedback }}">{{ $data1->Production_feedback }}</textarea>
                                                    </div>
                                                </div>

                                                <div class="col-12 p_erson">
                                                    <div class="group-input">
                                                        <label for="Production Tablet attachment">Production Attachments</label>
                                                        <div><small class="text-primary">Please Attach all relevant or supporting
                                                                documents</small></div>
                                                        <div class="file-attachment-field">
                                                            <div readonly class="file-attachment-list" id="production_attachment">
                                                                @if ($data1->production_attachment)
                                                                    @foreach (json_decode($data1->production_attachment) as $file)
                                                                        <h6 type="button" class="file-container text-dark"
                                                                            style="background-color: rgb(243, 242, 240);">
                                                                            <b>{{ $file }}</b>
                                                                            <a href="{{ asset('upload/' . $file) }}" target="_blank"><i
                                                                                    class="fa fa-eye text-primary"
                                                                                    style="font-size:20px; margin-right:-10px;"></i></a>
                                                                            <a type="button" class="remove-file" data-file-name="{{ $file }}"><i
                                                                                    class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i></a>
                                                                        </h6>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                            <div class="add-btn">
                                                                <div>Add</div>
                                                                <input readonly {{ $data->stage == 0 || $data->stage == 8 ? 'readonly' : '' }} type="file"
                                                                    id="myfile" name="production_attachment[]" oninput="addMultipleFiles(this, 'production_attachment')"
                                                                    multiple>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3 p_erson">
                                                    <div class="group-input">
                                                        <label for="Production Tablet Completed By">Production Completed By</label>
                                                        <input readonly type="text" value="{{ $data1->Production_by }}" name="Production_by" id="Production_by">
                                                    </div>
                                                </div>
                                                <div class="col-6 mb-3 p_erson new-date-data-field">
                                                    <div class="group-input input-date">
                                                        <label for="Production Tablet Completed On">Production Completed On</label>
                                                        <div class="calenderauditee">
                                                            <input type="text" id="production_on" readonly
                                                                placeholder="DD-MMM-YYYY"
                                                                value="{{ Helpers::getdateFormat($data1->production_on) }}" />
                                                            <input readonly type="date" name="production_on"
                                                                min="{{ \Carbon\Carbon::now()->format('d-M-Y') }}" value=""
                                                                class="hide-input"
                                                                oninput="handleDateInput(this, 'production_on')" />
                                                        </div>
                                                        @error('production_on')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            @endif
                                            
                                            <!-- Quality Control Department -->
                                            <div class="sub-head">
                                                Quality Control
                                            </div>
                                            <script>
                                                $(document).ready(function() {
                                                    @if($data1->Quality_review !== 'yes')
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
                                                    @endif
                                                });
                                            </script>

                                            @php
                                                $data1 = DB::table('global_change_controls_cfts')->where('cc_id', $data->id)->first();
                                            @endphp

                                            @if($data->stage == 3 || $data->stage == 4)

                                                <!-- Quality Control Review Required -->
                                                <div class="col-lg-6">
                                                    <div class="group-input">
                                                        <label for="Quality Control Review Required">Quality Control Review Required ?<span class="text-danger">*</span></label>
                                                        <select name="Quality_review" id="Quality_review" @if ($data->stage == 4) readonly @endif>
                                                            <option value="">-- Select --</option>
                                                            <option value="yes" @if($data1->Quality_review == "yes") selected @endif>Yes</option>
                                                            <option value="no" @if($data1->Quality_review == "no") selected @endif>No</option>
                                                            <option value="na" @if($data1->Quality_review == "na") selected @endif>NA</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                @php
                                                    $userRoles = DB::table('user_roles')
                                                    ->where([
                                                        'q_m_s_roles_id' => 24,
                                                        'q_m_s_divisions_id' => $data->division_id,
                                                    ])->get();
                                                    $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                                    $users = DB::table('users')->whereIn('id', $userRoleIds)->get();
                                                @endphp

                                                <!-- Quality Control Person -->
                                                <div class="col-lg-6 quality_control">
                                                    <div class="group-input">
                                                        <label for="Quality Control Person">Quality Control Person <span class="text-danger" style="display: {{ $data1->Quality_review == 'yes' && $data->stage == 4 ? 'inline' : 'none' }}">*</span></label>
                                                        <select name="Quality_Control_Person" id="Quality_Control_Person" @if ($data->stage == 4) readonly @endif>
                                                            <option value="">-- Select --</option>
                                                            @foreach ($users as $user)
                                                                <option value="{{ $user->id }}" @if($data1->Quality_Control_Person == $user->id) selected @endif>{{ $user->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Any Other Specify -->
                                                <div class="col-md-12 mb-3 quality_control">
                                                    <div class="group-input">
                                                        <label for="Quality_Control_assessment">Quality Control Assessment <span class="text-danger" style="display: {{ $data1->Quality_review == 'yes' && $data->stage == 4 ? 'inline' : 'none' }}">*</span></label>
                                                        <textarea class="" name="Quality_Control_assessment" id="summernote-17" @if ($data1->Quality_review == 'yes' && $data->stage == 4) required @endif
                                                            @if ($data->stage == 3 || (isset($data1->Quality_Control_Person) && Auth::user()->id != $data1->Quality_Control_Person)) readonly @endif>{{ $data1->Quality_Control_assessment }}</textarea>
                                                    </div>
                                                </div>

                                                <div class="col-md-12 mb-3 quality_control">
                                                    <div class="group-input">
                                                        <label for="Quality_Control_feedback">Quality Control Feedback <span class="text-danger" style="display: {{ $data1->Quality_review == 'yes' && $data->stage == 4 ? 'inline' : 'none' }}">*</span></label>
                                                        <textarea class="" name="Quality_Control_feedback" id="summernote-17" @if ($data1->Quality_review == 'yes' && $data->stage == 4) required @endif
                                                            @if ($data->stage == 3 || (isset($data1->Quality_Control_Person) && Auth::user()->id != $data1->Quality_Control_Person)) readonly @endif>{{ $data1->Quality_Control_feedback }}</textarea>
                                                    </div>
                                                </div>

                                                <div class="col-12 quality_control">
                                                    <div class="group-input">
                                                        <label for="Production Tablet attachment">Quality Control Attachments</label>
                                                        <div><small class="text-primary">Please Attach all relevant or supporting
                                                                documents</small></div>
                                                        <div class="file-attachment-field">
                                                            <div readonly class="file-attachment-list" id="Quality_Control_attachment">
                                                                @if ($data1->Quality_Control_attachment)
                                                                    @foreach (json_decode($data1->Quality_Control_attachment) as $file)
                                                                        <h6 type="button" class="file-container text-dark"
                                                                            style="background-color: rgb(243, 242, 240);">
                                                                            <b>{{ $file }}</b>
                                                                            <a href="{{ asset('upload/' . $file) }}" target="_blank"><i
                                                                                    class="fa fa-eye text-primary"
                                                                                    style="font-size:20px; margin-right:-10px;"></i></a>
                                                                            <a type="button" class="remove-file" data-file-name="{{ $file }}"><i
                                                                                    class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i></a>
                                                                        </h6>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                            <div class="add-btn">
                                                                <div>Add</div>
                                                                <input {{ $data->stage == 0 || $data->stage == 8 ? 'readonly' : '' }} type="file"
                                                                    id="myfile"
                                                                    name="Quality_Control_attachment[]"{{ $data->stage == 0 || $data->stage == 8 ? 'readonly' : '' }}
                                                                    oninput="addMultipleFiles(this, 'Quality_Control_attachment')" multiple>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Completed By -->
                                                <div class="col-md-6 mb-3 quality_control">
                                                    <div class="group-input">
                                                        <label for="productionfeedback">Quality Control Review Completed By</label>
                                                        <input readonly type="text" value="{{ $data1->Quality_Control_by }}" name="Quality_Control_by">
                                                    </div>
                                                </div>

                                                <!-- Completed On -->
                                                <div class="col-lg-6 new-date-data-field quality_control">
                                                    <div class="group-input input-date">
                                                        <label for="Quality Control Review Completed On">Quality Control Review Completed On</label>
                                                        <div class="calenderauditee">
                                                            <input type="text" id="Quality_Control_on" readonly placeholder="DD-MM-YYYY" value="{{ Helpers::getdateFormat($data1->Quality_Control_on) }}" />
                                                            <input readonly type="date" name="Quality_Control_on" min="{{ \Carbon\Carbon::now()->format('d-M-Y') }}" class="hide-input"
                                                                oninput="handleDateInput(this, 'Quality_Control_on')" />
                                                        </div>
                                                    </div>
                                                </div>

                                            @else
                                                <!-- Else block for readonly fields when the stage is not 3 or 4 -->

                                                <!-- Quality Control Review Required -->
                                                <div class="col-lg-6">
                                                    <div class="group-input">
                                                        <label for="Quality Control Review Required">Quality Control Review Required ?</label>
                                                        <select name="Quality_review" id="Quality_review" readonly>
                                                            <option value="">-- Select --</option>
                                                            <option value="yes" @if($data1->Quality_review == "yes") selected @endif>Yes</option>
                                                            <option value="no" @if($data1->Quality_review == "no") selected @endif>No</option>
                                                            <option value="na" @if($data1->Quality_review == "na") selected @endif>NA</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Quality Control Person -->
                                                <div class="col-lg-6 quality_control">
                                                    <div class="group-input">
                                                        <label for="Quality Control Person">Quality Control Person</label>
                                                        <select name="Quality_Control_Person" id="Quality_Control_Person" readonly>
                                                            <option value="">-- Select --</option>
                                                            @foreach ($users as $user)
                                                                <option value="{{ $user->id }}" @if($data1->Quality_Control_Person == $user->id) selected @endif>{{ $user->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Quality Control Assessment -->
                                                <div class="col-md-12 mb-3 quality_control">
                                                    <div class="group-input">
                                                        <label for="Quality_Control_assessment">Quality Control Assessment</label>
                                                        <textarea class="" name="Quality_Control_assessment" id="summernote-17" readonly>{{ $data1->Quality_Control_assessment }}</textarea>
                                                    </div>
                                                </div>

                                                <!-- Quality Control Feedback -->
                                                <div class="col-md-12 mb-3 quality_control">
                                                    <div class="group-input">
                                                        <label for="Quality_Control_assessment">Quality Control Feedback</label>
                                                        <textarea class="" name="Quality_Control_feedback" id="summernote-17" readonly>{{ $data1->Quality_Control_feedback }}</textarea>
                                                    </div>
                                                </div>

                                                <!-- Attachments -->
                                                <div class="col-lg-12 quality_control">
                                                    <div class="group-input">
                                                        <label for="Quality Control Attachments">Quality Control Attachments</label>
                                                        <div class="file-attachment-list" id="Quality_Control_attachment">
                                                            @if ($data1->Quality_Control_attachment)
                                                                @foreach (json_decode($data1->Quality_Control_attachment) as $file)
                                                                    <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                                        <b>{{ $file }}</b>
                                                                        <a href="{{ asset('upload/' . $file) }}" target="_blank"><i class="fa fa-eye text-primary" style="font-size:20px; margin-right:-10px;"></i></a>
                                                                        <a type="button" class="remove-file" data-file-name="{{ $file }}"><i class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i></a>
                                                                    </h6>
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Completed By -->
                                                <div class="col-md-6 mb-3 quality_control">
                                                    <div class="group-input">
                                                        <label for="productionfeedback">Quality Control Review Completed By</label>
                                                        <input readonly type="text" value="{{ $data1->Quality_Control_by }}" name="Quality_Control_by">
                                                    </div>
                                                </div>

                                                <!-- Completed On -->
                                                <div class="col-lg-6 new-date-data-field quality_control">
                                                    <div class="group-input input-date">
                                                        <label for="Quality Control Review Completed On">Quality Control Review Completed On</label>
                                                        <div class="calenderauditee">
                                                            <input type="text" id="Quality_Control_on" readonly placeholder="DD-MM-YYYY" value="{{ Helpers::getdateFormat($data1->Quality_Control_on) }}" />
                                                            <input readonly type="date" name="Quality_Control_on" min="{{ \Carbon\Carbon::now()->format('d-M-Y') }}" class="hide-input"
                                                                oninput="handleDateInput(this, 'Quality_Control_on')" />
                                                        </div>
                                                    </div>
                                                </div>

                                            @endif

                                            <div class="sub-head">
                                                Warehouse
                                            </div>
                                            <script>
                                                $(document).ready(function() {
                                                    @if($data1->Warehouse_review !== 'yes')
                                                        $('.warehouse').hide();
                                                        $('[name="Warehouse_review"]').change(function() {
                                                            if ($(this).val() === 'yes') {
                                                                $('.warehouse').show();
                                                                $('.warehouse span').show();
                                                            } else {
                                                                $('.warehouse').hide();
                                                                $('.warehouse span').hide();
                                                            }
                                                        });
                                                    @endif
                                                });
                                            </script>

                                            @php
                                                $data1 = DB::table('global_change_controls_cfts')->where('cc_id', $data->id)->first();
                                            @endphp

                                            @if($data->stage == 3 || $data->stage == 4)
                                                <!-- Warehouse Review Required -->
                                                <div class="col-lg-6">
                                                    <div class="group-input">
                                                        <label for="Warehouse Review">Warehouse Review Required ?<span class="text-danger">*</span></label>
                                                        <select name="Warehouse_review" id="Warehouse_review" @if ($data->stage == 4) readonly @endif>
                                                            <option value="">-- Select --</option>
                                                            <option value="yes" @if($data1->Warehouse_review == "yes") selected @endif>Yes</option>
                                                            <option value="no" @if($data1->Warehouse_review == "no") selected @endif>No</option>
                                                            <option value="na" @if($data1->Warehouse_review == "na") selected @endif>NA</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                @php
                                                    $userRoles = DB::table('user_roles')
                                                    ->where([
                                                        'q_m_s_roles_id' => 23,
                                                        'q_m_s_divisions_id' => $data->division_id,
                                                    ])->get();
                                                    $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                                    $users = DB::table('users')->whereIn('id', $userRoleIds)->get();
                                                @endphp

                                                <!-- Warehouse Person -->
                                                <div class="col-lg-6 warehouse">
                                                    <div class="group-input">
                                                        <label for="Warehouse Person">Warehouse Person <span class="text-danger" style="display: {{ $data1->Warehouse_review == 'yes' && $data->stage == 4 ? 'inline' : 'none' }}">*</span></label>
                                                        <select name="Warehouse_person" id="Warehouse_person" @if ($data->stage == 4) readonly @endif>
                                                            <option value="">-- Select --</option>
                                                            @foreach ($users as $user)
                                                                <option value="{{ $user->id }}" @if($data1->Warehouse_person == $user->id) selected @endif>{{ $user->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Any Other Specify -->
                                                <div class="col-md-12 mb-3 warehouse">
                                                    <div class="group-input">
                                                        <label for="Warehouse_assessment">Warehouse Assessment <span class="text-danger" style="display: {{ $data1->Warehouse_review == 'yes' && $data->stage == 4 ? 'inline' : 'none' }}">*</span></label>
                                                        <textarea class="" name="Warehouse_assessment" id="summernote-17" @if ($data1->Warehouse_review == 'yes' && $data->stage == 4) required @endif
                                                                @if ($data->stage == 3 || (isset($data1->Warehouse_person) && Auth::user()->id != $data1->Warehouse_person)) readonly @endif>{{ $data1->Warehouse_assessment }}</textarea>
                                                    </div>
                                                </div>

                                                <div class="col-md-12 mb-3 warehouse">
                                                    <div class="group-input">
                                                        <label for="Warehouse_feedback">Warehouse Feedback <span class="text-danger" style="display: {{ $data1->Warehouse_review == 'yes' && $data->stage == 4 ? 'inline' : 'none' }}">*</span></label>
                                                        <textarea class="" name="Warehouse_feedback" id="summernote-17" @if ($data1->Warehouse_review == 'yes' && $data->stage == 4) required @endif
                                                                @if ($data->stage == 3 || (isset($data1->Warehouse_person) && Auth::user()->id != $data1->Warehouse_person)) readonly @endif>{{ $data1->Warehouse_feedback }}</textarea>
                                                    </div>
                                                </div>

                                                <div class="col-12 warehouse">
                                                    <div class="group-input">
                                                        <label for="Production Tablet attachment">Warehouse Attachments</label>
                                                        <div><small class="text-primary">Please Attach all relevant or supporting
                                                                documents</small></div>
                                                        <div class="file-attachment-field">
                                                            <div readonly class="file-attachment-list" id="Warehouse_attachment">
                                                                @if ($data1->Warehouse_attachment)
                                                                    @foreach (json_decode($data1->Warehouse_attachment) as $file)
                                                                        <h6 type="button" class="file-container text-dark"
                                                                            style="background-color: rgb(243, 242, 240);">
                                                                            <b>{{ $file }}</b>
                                                                            <a href="{{ asset('upload/' . $file) }}" target="_blank"><i
                                                                                    class="fa fa-eye text-primary"
                                                                                    style="font-size:20px; margin-right:-10px;"></i></a>
                                                                            <a type="button" class="remove-file" data-file-name="{{ $file }}"><i
                                                                                    class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i></a>
                                                                        </h6>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                            <div class="add-btn">
                                                                <div>Add</div>
                                                                <input {{ $data->stage == 0 || $data->stage == 8 ? 'readonly' : '' }} type="file"
                                                                    id="myfile"
                                                                    name="Warehouse_attachment[]"{{ $data->stage == 0 || $data->stage == 8 ? 'readonly' : '' }}
                                                                    oninput="addMultipleFiles(this, 'Warehouse_attachment')" multiple>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Completed By -->
                                                <div class="col-md-6 mb-3 warehouse">
                                                    <div class="group-input">
                                                        <label for="Warehouse_by">Warehouse Review Completed By</label>
                                                        <input readonly type="text" value="{{ $data1->Warehouse_by }}" name="Warehouse_by">
                                                    </div>
                                                </div>

                                                <!-- Completed On -->
                                                <div class="col-lg-6 new-date-data-field warehouse">
                                                    <div class="group-input input-date">
                                                        <label for="Warehouse_on">Warehouse Review Completed On</label>
                                                        <div class="calenderauditee">
                                                            <input type="text" id="Warehouse_on" readonly placeholder="DD-MM-YYYY" value="{{ Helpers::getdateFormat($data1->Warehouse_on) }}" />
                                                            <input readonly type="date" name="Warehouse_on" min="{{ \Carbon\Carbon::now()->format('d-M-Y') }}" class="hide-input"
                                                                oninput="handleDateInput(this, 'Warehouse_on')" />
                                                        </div>
                                                    </div>
                                                </div>
                                            @else

                                                <div class="col-lg-6">
                                                    <div class="group-input">
                                                        <label for="Warehouse Review">Warehouse Review Required ?</label>
                                                        <select name="Warehouse_review" id="Warehouse_review" readonly>
                                                            <option value="">-- Select --</option>
                                                            <option value="yes" @if($data1->Warehouse_review == "yes") selected @endif>Yes</option>
                                                            <option value="no" @if($data1->Warehouse_review == "no") selected @endif>No</option>
                                                            <option value="na" @if($data1->Warehouse_review == "na") selected @endif>NA</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Warehouse Person -->
                                                <div class="col-lg-6 warehouse">
                                                    <div class="group-input">
                                                        <label for="Warehouse Person">Warehouse Person</label>
                                                        <select name="Warehouse_person" id="Warehouse_person" readonly>
                                                            <option value="">-- Select --</option>
                                                            @foreach ($users as $user)
                                                                <option value="{{ $user->id }}" @if($data1->Warehouse_person == $user->id) selected @endif>{{ $user->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Warehouse Assessment -->
                                                <div class="col-md-12 mb-3 warehouse">
                                                    <div class="group-input">
                                                        <label for="Warehouse_assessment">Warehouse Assessment</label>
                                                        <textarea class="" name="Warehouse_assessment" id="summernote-17" readonly>{{ $data1->Warehouse_assessment }}</textarea>
                                                    </div>
                                                </div>

                                                <!-- Warehouse Feedback -->
                                                <div class="col-md-12 mb-3 warehouse">
                                                    <div class="group-input">
                                                        <label for="Warehouse_assessment">Warehouse Feedback</label>
                                                        <textarea class="" name="Warehouse_feedback" id="summernote-17" readonly>{{ $data1->Warehouse_feedback }}</textarea>
                                                    </div>
                                                </div>

                                                <!-- Attachments -->
                                                <div class="col-lg-12 warehouse">
                                                    <div class="group-input">
                                                        <label for="Warehouse_attachment">Warehouse Attachments</label>
                                                        <div class="file-attachment-list" id="Warehouse_attachment">
                                                            @if ($data1->Warehouse_attachment)
                                                                @foreach (json_decode($data1->Warehouse_attachment) as $file)
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
                                                            <input readonly type="file" id="myfile" name="Warehouse_attachment[]" oninput="addMultipleFiles(this, 'Warehouse_attachment')" multiple>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Completed By -->
                                                <div class="col-md-6 mb-3 warehouse">
                                                    <div class="group-input">
                                                        <label for="Warehouse_by">Warehouse Review Completed By</label>
                                                        <input readonly type="text" value="{{ $data1->Warehouse_by }}" name="Warehouse_by">
                                                    </div>
                                                </div>

                                                <!-- Completed On -->
                                                <div class="col-lg-6 new-date-data-field warehouse">
                                                    <div class="group-input input-date">
                                                        <label for="Warehouse_on">Warehouse Review Completed On</label>
                                                        <div class="calenderauditee">
                                                            <input type="text" id="Warehouse_on" readonly placeholder="DD-MM-YYYY" value="{{ Helpers::getdateFormat($data1->Warehouse_on) }}" />
                                                            <input readonly type="date" name="Warehouse_on" min="{{ \Carbon\Carbon::now()->format('d-M-Y') }}" class="hide-input"
                                                                oninput="handleDateInput(this, 'Warehouse_on')" />
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                        
                                            <!-- Engineering Department -->
                                            <div class="sub-head">
                                                Engineering
                                            </div>
                                            <script>
                                                $(document).ready(function() {
                                                    @if($data1->Engineering_review !== 'yes')
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
                                                    @endif
                                                });
                                            </script>

                                            @php
                                                $data1 = DB::table('global_change_controls_cfts')->where('cc_id', $data->id)->first();
                                            @endphp

                                            @if($data->stage == 3 || $data->stage == 4)

                                                <!-- Engineering Review Required -->
                                                <div class="col-lg-6">
                                                    <div class="group-input">
                                                        <label for="Engineering Review Required">Engineering Review Required ?<span class="text-danger">*</span></label>
                                                        <select name="Engineering_review" id="Engineering_review" @if ($data->stage == 4) readonly @endif>
                                                            <option value="">-- Select --</option>
                                                            <option value="yes" @if($data1->Engineering_review == "yes") selected @endif>Yes</option>
                                                            <option value="no" @if($data1->Engineering_review == "no") selected @endif>No</option>
                                                            <option value="na" @if($data1->Engineering_review == "na") selected @endif>NA</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                @php
                                                    $userRoles = DB::table('user_roles')
                                                    ->where([
                                                        'q_m_s_roles_id' => 25,
                                                        'q_m_s_divisions_id' => $data->division_id,
                                                    ])->get();
                                                    $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                                    $users = DB::table('users')->whereIn('id', $userRoleIds)->get();
                                                @endphp

                                                <!-- Engineering Person -->
                                                <div class="col-lg-6 engineering">
                                                    <div class="group-input">
                                                        <label for="Engineering Person">Engineering Person <span class="text-danger" style="display: {{ $data1->Engineering_review == 'yes' && $data->stage == 4 ? 'inline' : 'none' }}">*</span></label>
                                                        <select name="Engineering_person" id="Engineering_person" @if ($data->stage == 4) readonly @endif>
                                                            <option value="">-- Select --</option>
                                                            @foreach ($users as $user)
                                                                <option value="{{ $user->id }}" @if($data1->Engineering_person == $user->id) selected @endif>{{ $user->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Impact Assessment -->
                                                <div class="col-md-12 mb-3 engineering">
                                                    <div class="group-input">
                                                        <label for="Impact Assessment4">Engineering Assessment<span class="text-danger" style="display: {{ $data1->Engineering_review == 'yes' && $data->stage == 4 ? 'inline' : 'none' }}">*</span></label>
                                                        <textarea class="" name="Engineering_assessment" id="summernote-25" @if ($data1->Engineering_review == 'yes' && $data->stage == 4) required @endif
                                                            @if ($data->stage == 3 || (isset($data1->Engineering_person) && Auth::user()->id != $data1->Engineering_person)) readonly @endif>{{ $data1->Engineering_assessment }}</textarea>
                                                    </div>
                                                </div>

                                                <!-- Feedback -->
                                                <div class="col-md-12 mb-3 engineering">
                                                    <div class="group-input">
                                                        <label for="Impact Assessment4">Engineering Feedback<span class="text-danger" style="display: {{ $data1->Engineering_review == 'yes' && $data->stage == 4 ? 'inline' : 'none' }}">*</span></label>
                                                        <textarea class="" name="Engineering_feedback" id="summernote-25" @if ($data1->Engineering_review == 'yes' && $data->stage == 4) required @endif
                                                            @if ($data->stage == 3 || (isset($data1->Engineering_person) && Auth::user()->id != $data1->Engineering_person)) readonly @endif>{{ $data1->Engineering_feedback }}</textarea>
                                                    </div>
                                                </div>

                                                <div class="col-12 engineering">
                                                    <div class="group-input">
                                                        <label for="Production Tablet attachment">Engineering Attachments</label>
                                                        <div><small class="text-primary">Please Attach all relevant or supporting
                                                                documents</small></div>
                                                        <div class="file-attachment-field">
                                                            <div readonly class="file-attachment-list" id="Engineering_attachment">
                                                                @if ($data1->Engineering_attachment)
                                                                    @foreach (json_decode($data1->Engineering_attachment) as $file)
                                                                        <h6 type="button" class="file-container text-dark"
                                                                            style="background-color: rgb(243, 242, 240);">
                                                                            <b>{{ $file }}</b>
                                                                            <a href="{{ asset('upload/' . $file) }}" target="_blank"><i
                                                                                    class="fa fa-eye text-primary"
                                                                                    style="font-size:20px; margin-right:-10px;"></i></a>
                                                                            <a type="button" class="remove-file" data-file-name="{{ $file }}"><i
                                                                                    class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i></a>
                                                                        </h6>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                            <div class="add-btn">
                                                                <div>Add</div>
                                                                <input {{ $data->stage == 0 || $data->stage == 8 ? 'readonly' : '' }} type="file"
                                                                    id="myfile"
                                                                    name="Engineering_attachment[]"{{ $data->stage == 0 || $data->stage == 8 ? 'readonly' : '' }}
                                                                    oninput="addMultipleFiles(this, 'Engineering_attachment')" multiple>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Engineering Review Completed By -->
                                                <div class="col-md-6 mb-3 engineering">
                                                    <div class="group-input">
                                                        <label for="Engineering Review Completed By">Engineering Review Completed By</label>
                                                        <input readonly type="text" value="{{ $data1->Engineering_by }}" name="Engineering_by">
                                                    </div>
                                                </div>

                                                <!-- Engineering Review Completed On -->
                                                <div class="col-lg-6 new-date-data-field engineering">
                                                    <div class="group-input input-date">
                                                        <label for="Engineering Review Completed On">Engineering Review Completed On</label>
                                                        <div class="calenderauditee">
                                                            <input type="text" id="Engineering_on" readonly placeholder="DD-MM-YYYY" value="{{ Helpers::getdateFormat($data1->Engineering_on) }}" />
                                                            <input readonly type="date" name="Engineering_on" min="{{ \Carbon\Carbon::now()->format('d-M-Y') }}" class="hide-input"
                                                                oninput="handleDateInput(this, 'Engineering_on')" />
                                                        </div>
                                                    </div>
                                                </div>

                                            @else
                                                <!-- Else block for readonly fields when the stage is not 3 or 4 -->

                                                <!-- Engineering Review Required -->
                                                <div class="col-lg-6">
                                                    <div class="group-input">
                                                        <label for="Engineering Review Required">Engineering Review Required ?</label>
                                                        <select name="Engineering_review" id="Engineering_review" readonly>
                                                            <option value="">-- Select --</option>
                                                            <option value="yes" @if($data1->Engineering_review == "yes") selected @endif>Yes</option>
                                                            <option value="no" @if($data1->Engineering_review == "no") selected @endif>No</option>
                                                            <option value="na" @if($data1->Engineering_review == "na") selected @endif>NA</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Engineering Person -->
                                                <div class="col-lg-6 engineering">
                                                    <div class="group-input">
                                                        <label for="Engineering Person">Engineering Person</label>
                                                        <select name="Engineering_person" id="Engineering_person" readonly>
                                                            <option value="">-- Select --</option>
                                                            @foreach ($users as $user)
                                                                <option value="{{ $user->id }}" @if($data1->Engineering_person == $user->id) selected @endif>{{ $user->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Impact Assessment -->
                                                <div class="col-md-12 mb-3 engineering">
                                                    <div class="group-input">
                                                        <label for="Impact Assessment4">Engineering Assessment</label>
                                                        <textarea class="" name="Engineering_assessment" id="summernote-25" readonly>{{ $data1->Engineering_assessment }}</textarea>
                                                    </div>
                                                </div>

                                                <div class="col-md-12 mb-3 engineering">
                                                    <div class="group-input">
                                                        <label for="Impact Assessment4">Engineering Feedback</label>
                                                        <textarea class="" name="Engineering_feedback" id="summernote-25" readonly>{{ $data1->Engineering_feedback }}</textarea>
                                                    </div>
                                                </div>

                                                <div class="col-12 engineering">
                                                    <div class="group-input">
                                                        <label for="Production Tablet attachment">Engineering Attachments</label>
                                                        <div><small class="text-primary">Please Attach all relevant or supporting
                                                                documents</small></div>
                                                        <div class="file-attachment-field">
                                                            <div readonly class="file-attachment-list" id="Engineering_attachment">
                                                                @if ($data1->Engineering_attachment)
                                                                    @foreach (json_decode($data1->Engineering_attachment) as $file)
                                                                        <h6 type="button" class="file-container text-dark"
                                                                            style="background-color: rgb(243, 242, 240);">
                                                                            <b>{{ $file }}</b>
                                                                            <a href="{{ asset('upload/' . $file) }}" target="_blank"><i
                                                                                    class="fa fa-eye text-primary"
                                                                                    style="font-size:20px; margin-right:-10px;"></i></a>
                                                                            <a type="button" class="remove-file" data-file-name="{{ $file }}"><i
                                                                                    class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i></a>
                                                                        </h6>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                            <div class="add-btn">
                                                                <div>Add</div>
                                                                <input readonly {{ $data->stage == 0 || $data->stage == 8 ? 'readonly' : '' }} type="file"
                                                                    id="myfile"
                                                                    name="Engineering_attachment[]"{{ $data->stage == 0 || $data->stage == 8 ? 'readonly' : '' }}
                                                                    oninput="addMultipleFiles(this, 'Engineering_attachment')" multiple>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Engineering Review Completed By -->
                                                <div class="col-md-6 mb-3 engineering">
                                                    <div class="group-input">
                                                        <label for="Engineering Review Completed By">Engineering Review Completed By</label>
                                                        <input readonly type="text" value="{{ $data1->Engineering_by }}" name="Engineering_by">
                                                    </div>
                                                </div>

                                                <!-- Engineering Review Completed On -->
                                                <div class="col-lg-6 new-date-data-field engineering">
                                                    <div class="group-input input-date">
                                                        <label for="Engineering Review Completed On">Engineering Review Completed On</label>
                                                        <div class="calenderauditee">
                                                            <input type="text" id="Engineering_on" readonly placeholder="DD-MM-YYYY" value="{{ Helpers::getdateFormat($data1->Engineering_on) }}" />
                                                            <input readonly type="date" name="Engineering_on" min="{{ \Carbon\Carbon::now()->format('d-M-Y') }}" class="hide-input"
                                                                oninput="handleDateInput(this, 'Engineering_on')" />
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif


                                            <!-- Research & Development Department -->
                                            <div class="sub-head">
                                                Research & Development
                                            </div>

                                            <script>
                                                $(document).ready(function() {
                                                    @if($data1->ResearchDevelopment_Review !== 'yes')
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
                                                    @endif
                                                });
                                            </script>

                                            @php
                                                $data1 = DB::table('global_change_controls_cfts')->where('cc_id', $data->id)->first();
                                                $userRoles = DB::table('user_roles')
                                                    ->where([
                                                        'q_m_s_roles_id' => 55,
                                                        'q_m_s_divisions_id' => $data->division_id,
                                                    ])->get();
                                                $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                                $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                                            @endphp

                                            @if($data->stage == 3 || $data->stage == 4)
                                                <div class="col-lg-6">
                                                    <div class="group-input">
                                                        <label for="Research Development">Research Development Review Required ?<span class="text-danger">*</span></label>
                                                        <select name="ResearchDevelopment_Review" id="ResearchDevelopment_Review" @if ($data->stage == 4) readonly @endif>
                                                            <option value="">-- Select --</option>
                                                            <option value="yes" @if($data1->ResearchDevelopment_Review == "yes") selected @endif>Yes</option>
                                                            <option value="no" @if($data1->ResearchDevelopment_Review == "no") selected @endif>No</option>
                                                            <option value="na" @if($data1->ResearchDevelopment_Review == "na") selected @endif>NA</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-lg-6 researchDevelopment">
                                                    <div class="group-input">
                                                        <label for="Research Development Person">Research Development Person</label>
                                                        <select name="ResearchDevelopment_person" class="ResearchDevelopment_person" id="ResearchDevelopment_person" @if ($data->stage == 4) readonly @endif>
                                                            <option value="">-- Select --</option>
                                                            @foreach ($users as $user)
                                                                <option value="{{ $user->id }}" @if($data1->ResearchDevelopment_person == $user->id) selected @endif>{{ $user->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Any Other Specify -->
                                                <div class="col-md-12 mb-3 researchDevelopment">
                                                    <div class="group-input">
                                                        <label for="ResearchDevelopment_assessment">Research Development Assessment</label>
                                                        <textarea class="" name="ResearchDevelopment_assessment" id="summernote-17" @if ($data1->ResearchDevelopment_Review == 'yes' && $data->stage == 4) required @endif
                                                        @if ($data->stage == 3 || (isset($data1->ResearchDevelopment_person) && Auth::user()->id != $data1->ResearchDevelopment_person)) readonly @endif>{{ $data1->ResearchDevelopment_assessment }}</textarea>
                                                    </div>
                                                </div>

                                                <!-- Impact Assessment -->
                                                <div class="col-md-12 mb-3 researchDevelopment">
                                                    <div class="group-input">
                                                        <label for="Research Development assessment">Research Development Feedback</label>
                                                        <textarea class="summernote" name="ResearchDevelopment_feedback" id="summernote-17" @if ($data1->ResearchDevelopment_Review == 'yes' && $data->stage == 4) required @endif
                                                        @if ($data->stage == 3 || (isset($data1->ResearchDevelopment_person) && Auth::user()->id != $data1->ResearchDevelopment_person)) readonly @endif>{{ $data1->ResearchDevelopment_feedback }}</textarea>
                                                    </div>
                                                </div>

                                                <div class="col-12 researchDevelopment">
                                                    <div class="group-input">
                                                        <label for="Production Tablet attachment">Research Development Attachments</label>
                                                        <div><small class="text-primary">Please Attach all relevant or supporting
                                                                documents</small></div>
                                                        <div class="file-attachment-field">
                                                            <div readonly class="file-attachment-list" id="ResearchDevelopment_attachment">
                                                                @if ($data1->ResearchDevelopment_attachment)
                                                                    @foreach (json_decode($data1->ResearchDevelopment_attachment) as $file)
                                                                        <h6 type="button" class="file-container text-dark"
                                                                            style="background-color: rgb(243, 242, 240);">
                                                                            <b>{{ $file }}</b>
                                                                            <a href="{{ asset('upload/' . $file) }}" target="_blank"><i
                                                                                    class="fa fa-eye text-primary"
                                                                                    style="font-size:20px; margin-right:-10px;"></i></a>
                                                                            <a type="button" class="remove-file" data-file-name="{{ $file }}"><i
                                                                                    class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i></a>
                                                                        </h6>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                            <div class="add-btn">
                                                                <div>Add</div>
                                                                <input {{ $data->stage == 0 || $data->stage == 8 ? 'readonly' : '' }} type="file"
                                                                    id="myfile"
                                                                    name="ResearchDevelopment_attachment[]"{{ $data->stage == 0 || $data->stage == 8 ? 'readonly' : '' }}
                                                                    oninput="addMultipleFiles(this, 'ResearchDevelopment_attachment')" multiple>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Research Development Completed By -->
                                                <div class="col-md-6 mb-3 researchDevelopment">
                                                    <div class="group-input">
                                                        <label for="Research Development Completed By">Research Development Completed By</label>
                                                        <input readonly type="text" name="ResearchDevelopment_by" value="{{ $data1->ResearchDevelopment_by }}">
                                                    </div>
                                                </div>

                                                <!-- Research Development Completed On -->
                                                <div class="col-lg-6 researchDevelopment">
                                                    <div class="group-input">
                                                        <label for="Research Development Completed On">Research Development Completed On</label>
                                                        <div class="calenderauditee">
                                                            <input type="text" id="ResearchDevelopment_on" readonly placeholder="DD-MM-YYYY" value="{{ Helpers::getdateFormat($data1->ResearchDevelopment_on) }}" />
                                                            <input readonly type="date" name="ResearchDevelopment_on" min="{{ \Carbon\Carbon::now()->format('d-M-Y') }}" class="hide-input"
                                                            oninput="handleDateInput(this, 'ResearchDevelopment_on')" />
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="col-lg-6">
                                                    <div class="group-input">
                                                        <label for="Research Development">Research Development Review Required ?</label>
                                                        <select name="ResearchDevelopment_Review" id="ResearchDevelopment_Review" readonly>
                                                            <option value="">-- Select --</option>
                                                            <option value="yes" @if($data1->ResearchDevelopment_Review == "yes") selected @endif>Yes</option>
                                                            <option value="no" @if($data1->ResearchDevelopment_Review == "no") selected @endif>No</option>
                                                            <option value="na" @if($data1->ResearchDevelopment_Review == "na") selected @endif>NA</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Research Development Person -->
                                                <div class="col-lg-6 researchDevelopment">
                                                    <div class="group-input">
                                                        <label for="Research Development Person">Research Development Person</label>
                                                        <select name="ResearchDevelopment_person" id="ResearchDevelopment_person" readonly>
                                                            <option value="">-- Select --</option>
                                                            @foreach ($users as $user)
                                                                <option value="{{ $user->id }}" @if($data1->ResearchDevelopment_person == $user->id) selected @endif>{{ $user->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Any Other Specify -->
                                                <div class="col-md-12 mb-3 researchDevelopment">
                                                    <div class="group-input">
                                                        <label for="ResearchDevelopment_assessment">Research Development Assessment</label>
                                                        <textarea class="" name="ResearchDevelopment_assessment" id="summernote-17" readonly>{{ $data1->ResearchDevelopment_assessment }}</textarea>
                                                    </div>
                                                </div>

                                                <!-- Impact Assessment -->
                                                <div class="col-md-12 mb-3 researchDevelopment">
                                                    <div class="group-input">
                                                        <label for="Research Development assessment">Research Development Feedback</label>
                                                        <textarea class="summernote" name="ResearchDevelopment_feedback" id="summernote-17" readonly>{{ $data1->ResearchDevelopment_feedback }}</textarea>
                                                    </div>
                                                </div>

                                                <div class="col-12 researchDevelopment">
                                                    <div class="group-input">
                                                        <label for="Production Tablet attachment">Research Development Attachments</label>
                                                        <div><small class="text-primary">Please Attach all relevant or supporting
                                                                documents</small></div>
                                                        <div class="file-attachment-field">
                                                            <div readonly class="file-attachment-list" id="ResearchDevelopment_attachment">
                                                                @if ($data1->ResearchDevelopment_attachment)
                                                                    @foreach (json_decode($data1->ResearchDevelopment_attachment) as $file)
                                                                        <h6 type="button" class="file-container text-dark"
                                                                            style="background-color: rgb(243, 242, 240);">
                                                                            <b>{{ $file }}</b>
                                                                            <a href="{{ asset('upload/' . $file) }}" target="_blank"><i
                                                                                    class="fa fa-eye text-primary"
                                                                                    style="font-size:20px; margin-right:-10px;"></i></a>
                                                                            <a type="button" class="remove-file" data-file-name="{{ $file }}"><i
                                                                                    class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i></a>
                                                                        </h6>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                            <div class="add-btn">
                                                                <div>Add</div>
                                                                <input readonly {{ $data->stage == 0 || $data->stage == 8 ? 'readonly' : '' }} type="file"
                                                                    id="myfile"
                                                                    name="ResearchDevelopment_attachment[]"{{ $data->stage == 0 || $data->stage == 8 ? 'readonly' : '' }}
                                                                    oninput="addMultipleFiles(this, 'ResearchDevelopment_attachment')" multiple>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Research Development Completed By -->
                                                <div class="col-md-6 mb-3 researchDevelopment">
                                                    <div class="group-input">
                                                        <label for="Research Development Completed By">Research Development Completed By</label>
                                                        <input readonly type="text" name="ResearchDevelopment_by" value="{{ $data1->ResearchDevelopment_by }}">
                                                    </div>
                                                </div>

                                                <!-- Research Development Completed On -->
                                                <div class="col-lg-6 researchDevelopment">
                                                    <div class="group-input">
                                                        <label for="Research Development Completed On">Research Development Completed On</label>
                                                        <div class="calenderauditee">
                                                            <input type="text" id="ResearchDevelopment_on" readonly placeholder="DD-MM-YYYY" value="{{ Helpers::getdateFormat($data1->ResearchDevelopment_on) }}" />
                                                            <input readonly type="date" name="ResearchDevelopment_on" min="{{ \Carbon\Carbon::now()->format('d-M-Y') }}" class="hide-input"
                                                            oninput="handleDateInput(this, 'ResearchDevelopment_on')" />
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                            <!-- Regulatory Affair Department -->
                                            <div class="sub-head">
                                                Regulatory Affair
                                            </div>
                                            @php
                                                $data1 = DB::table('global_change_controls_cfts')
                                                    ->where('cc_id', $data->id)
                                                    ->first();
                                            @endphp
                                            <script>
                                                $(document).ready(function() {
                                                    @if($data1->RegulatoryAffair_Review !== 'yes')
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
                                                    @endif
                                                });
                                            </script>

                                            @if($data->stage == 3 || $data->stage == 4)
                                                <div class="col-lg-6">
                                                    <div class="group-input">
                                                        <label for="RegulatoryAffair">Regulatory Affair Required ?<span class="text-danger">*</span></label>
                                                        <select name="RegulatoryAffair_Review" id="RegulatoryAffair_Review" @if($data->stage == 4) readonly @endif>
                                                            <option value="">-- Select --</option>
                                                            <option @if($data1->RegulatoryAffair_Review == 'yes') selected @endif value="yes">Yes</option>
                                                            <option @if($data1->RegulatoryAffair_Review == 'no') selected @endif value="no">No</option>
                                                            <option @if($data1->RegulatoryAffair_Review == 'na') selected @endif value="na">NA</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                @php
                                                    $userRoles = DB::table('user_roles')
                                                        ->where([
                                                            'q_m_s_roles_id' => 57,
                                                            'q_m_s_divisions_id' => $data->division_id,
                                                        ])->get();
                                                    $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                                    $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); 
                                                @endphp

                                                <div class="col-lg-6 RegulatoryAffair">
                                                    <div class="group-input">
                                                        <label for="Regulatory Affair notification">Regulatory Affair Person</label>
                                                        <select name="RegulatoryAffair_person" id="RegulatoryAffair_person" @if($data->stage == 4) readonly @endif>
                                                            <option value="">-- Select --</option>
                                                            @foreach ($users as $user)
                                                                <option value="{{ $user->id }}" @if($data1->RegulatoryAffair_person == $user->id) selected @endif>{{ $user->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-12 mb-3 RegulatoryAffair">
                                                    <div class="group-input">
                                                        <label for="Regulatory Affair assessment">Regulatory Affair Assessment</label>
                                                        <textarea class="summernote RegulatoryAffair_assessment" name="RegulatoryAffair_assessment" id="summernote-17"
                                                            @if($data1->RegulatoryAffair_Review == 'yes' && $data->stage == 4) required @endif
                                                            @if($data->stage == 3 || (isset($data1->RegulatoryAffair_person) && Auth::user()->id != $data1->RegulatoryAffair_person)) readonly @endif>{{ $data1->RegulatoryAffair_assessment }}</textarea>
                                                    </div>
                                                </div>

                                                <div class="col-md-12 mb-3 RegulatoryAffair">
                                                    <div class="group-input">
                                                        <label for="Regulatory Affair assessment">Regulatory Affair Feedback</label>
                                                        <textarea class="summernote" name="RegulatoryAffair_feedback" id="summernote-17"
                                                            @if($data1->RegulatoryAffair_Review == 'yes' && $data->stage == 4) required @endif
                                                            @if($data->stage == 3 || (isset($data1->RegulatoryAffair_person) && Auth::user()->id != $data1->RegulatoryAffair_person)) readonly @endif>{{ $data1->RegulatoryAffair_feedback }}</textarea>
                                                    </div>
                                                </div>

                                                <div class="col-12 RegulatoryAffair">
                                                    <div class="group-input">
                                                        <label for="Regulatory Affair attachment">Regulatory Affair Attachments</label>
                                                        <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                                        <div class="file-attachment-field">
                                                            <div class="file-attachment-list" id="RegulatoryAffair_attachment">
                                                                @if($data1->RegulatoryAffair_attachment)
                                                                    @foreach(json_decode($data1->RegulatoryAffair_attachment) as $file)
                                                                        <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                                            <b>{{ $file }}</b>
                                                                            <a href="{{ asset('upload/' . $file) }}" target="_blank"><i class="fa fa-eye text-primary"
                                                                                    style="font-size: 20px; margin-right: -10px;"></i></a>
                                                                            <a type="button" class="remove-file" data-file-name="{{ $file }}"><i
                                                                                    class="fa-solid fa-circle-xmark" style="color: red; font-size: 20px;"></i></a>
                                                                        </h6>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                            <div class="add-btn">
                                                                <div>Add</div>
                                                                <input type="file" id="myfile" name="RegulatoryAffair_attachment[]" multiple 
                                                                    @if($data->stage == 0 || $data->stage == 8) readonly @endif 
                                                                    oninput="addMultipleFiles(this, 'RegulatoryAffair_attachment')">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 mb-3 RegulatoryAffair">
                                                    <div class="group-input">
                                                        <label for="Regulatory Affair Completed By">Regulatory Affair Completed By</label>
                                                        <input readonly type="text" name="RegulatoryAffair_by" value="{{ $data1->RegulatoryAffair_by }}">
                                                    </div>
                                                </div>

                                                <div class="col-lg-6 new-date-data-field RegulatoryAffair">
                                                    <div class="group-input input-date">
                                                        <label for="Regulatory Affair Completed On">Regulatory Affair Completed On</label>
                                                        <div class="calenderauditee">
                                                            <input type="text" id="RegulatoryAffair_on" readonly placeholder="DD-MM-YYYY" 
                                                                value="{{ Helpers::getdateFormat($data1->RegulatoryAffair_on) }}" />
                                                            <input readonly type="date" name="RegulatoryAffair_on" class="hide-input" 
                                                                oninput="handleDateInput(this, 'RegulatoryAffair_on')" />
                                                        </div>
                                                    </div>
                                                </div>

                                            @else
                                                <div class="col-lg-6">
                                                    <div class="group-input">
                                                        <label for="RegulatoryAffair">Regulatory Affair Required?</label>
                                                        <select name="RegulatoryAffair_Review" id="RegulatoryAffair_Review" readonly>
                                                            <option value="">-- Select --</option>
                                                            <option @if($data1->RegulatoryAffair_Review == 'yes') selected @endif value="yes">Yes</option>
                                                            <option @if($data1->RegulatoryAffair_Review == 'no') selected @endif value="no">No</option>
                                                            <option @if($data1->RegulatoryAffair_Review == 'na') selected @endif value="na">NA</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-lg-6 RegulatoryAffair">
                                                    <div class="group-input">
                                                        <label for="Regulatory Affair notification">Regulatory Affair Person</label>
                                                        <select name="RegulatoryAffair_person" id="RegulatoryAffair_person" readonly>
                                                            <option value="">-- Select --</option>
                                                            @foreach ($users as $user)
                                                                <option value="{{ $user->id }}" @if($data1->RegulatoryAffair_person == $user->id) selected @endif>{{ $user->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-12 mb-3 RegulatoryAffair">
                                                    <div class="group-input">
                                                        <label for="Regulatory Affair assessment">Regulatory Affair Assessment</label>
                                                        <textarea class="summernote" name="RegulatoryAffair_assessment" id="summernote-17" readonly>{{ $data1->RegulatoryAffair_assessment }}</textarea>
                                                    </div>
                                                </div>

                                                <div class="col-md-12 mb-3 RegulatoryAffair">
                                                    <div class="group-input">
                                                        <label for="Regulatory Affair assessment">Regulatory Affair Feedback</label>
                                                        <textarea class="summernote" name="RegulatoryAffair_feedback" id="summernote-17" readonly>{{ $data1->RegulatoryAffair_feedback }}</textarea>
                                                    </div>
                                                </div>

                                                <div class="col-12 RegulatoryAffair">
                                                    <div class="group-input">
                                                        <label for="Regulatory Affair attachment">Regulatory Affair Attachments</label>
                                                        <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                                        <div class="file-attachment-field">
                                                            <div class="file-attachment-list" id="RegulatoryAffair_attachment">
                                                                @if($data1->RegulatoryAffair_attachment)
                                                                    @foreach(json_decode($data1->RegulatoryAffair_attachment) as $file)
                                                                        <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                                            <b>{{ $file }}</b>
                                                                            <a href="{{ asset('upload/' . $file) }}" target="_blank"><i class="fa fa-eye text-primary"
                                                                                    style="font-size: 20px; margin-right: -10px;"></i></a>
                                                                            <a type="button" class="remove-file" data-file-name="{{ $file }}"><i
                                                                                    class="fa-solid fa-circle-xmark" style="color: red; font-size: 20px;"></i></a>
                                                                        </h6>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                            <div class="add-btn">
                                                                <div>Add</div>
                                                                <input readonly type="file" id="myfile" name="RegulatoryAffair_attachment[]" multiple 
                                                                    @if($data->stage == 0 || $data->stage == 8) readonly @endif
                                                                    oninput="addMultipleFiles(this, 'RegulatoryAffair_attachment')">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 mb-3 RegulatoryAffair">
                                                    <div class="group-input">
                                                        <label for="Regulatory Affair Completed By">Regulatory Affair Completed By</label>
                                                        <input readonly type="text" name="RegulatoryAffair_by" readonly value="{{ $data1->RegulatoryAffair_by }}">
                                                    </div>
                                                </div>

                                                <div class="col-lg-6 new-date-data-field RegulatoryAffair">
                                                    <div class="group-input input-date">
                                                        <label for="Regulatory Affair Completed On">Regulatory Affair Completed On</label>
                                                        <div class="calenderauditee">
                                                            <input type="text" id="RegulatoryAffair_on" readonly placeholder="DD-MM-YYYY" 
                                                                value="{{ Helpers::getdateFormat($data1->RegulatoryAffair_on) }}" />
                                                            <input readonly type="date" name="RegulatoryAffair_on" class="hide-input" 
                                                                oninput="handleDateInput(this, 'RegulatoryAffair_on')" />
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif


                                            <!-- CQA Department -->
                                                @php
                                                    $data1 = DB::table('global_change_controls_cfts')
                                                        ->where('cc_id', $data->id)
                                                        ->first();
                                                @endphp
                                                <div class="sub-head">
                                                    CQA
                                                </div>
                                                <script>
                                                    $(document).ready(function() {
                                                        @if($data1->CQA_Review !== 'yes')
                                                            $('.cqa_person').hide();
                                                            $('[name="CQA_Review"]').change(function() {
                                                                if ($(this).val() === 'yes') {
                                                                    $('.cqa_person').show();
                                                                    $('.cqa_person span').show();
                                                                } else {
                                                                    $('.cqa_person').hide();
                                                                    $('.cqa_person span').hide();
                                                                }
                                                            });
                                                        @endif
                                                    });
                                                </script>

                                            @if($data->stage == 3 || $data->stage == 4)

                                                <!-- CQA Review -->
                                                <div class="col-lg-6">
                                                    <div class="group-input">
                                                        <label for="CQA Review">CQA Review Required ?<span class="text-danger">*</span></label>
                                                        <select name="CQA_Review" id="CQA_Review" @if($data->stage == 4) readonly @endif>
                                                            <option value="">-- Select --</option>
                                                            <option @if($data1->CQA_Review == 'yes') selected @endif value="yes">Yes</option>
                                                            <option @if($data1->CQA_Review == 'no') selected @endif value="no">No</option>
                                                            <option @if($data1->CQA_Review == 'na') selected @endif value="na">NA</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                @php
                                                    $userRoles = DB::table('user_roles')
                                                        ->where([
                                                            'q_m_s_roles_id' => 58,
                                                            'q_m_s_divisions_id' => $data->division_id,
                                                        ])->get();
                                                    $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                                    $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); 
                                                @endphp

                                                <!-- CQA Person -->
                                                <div class="col-lg-6 cqa_person">
                                                    <div class="group-input">
                                                        <label for="CQA person">CQA Person</label>
                                                        <select name="CQA_person" id="CQA_person" @if($data->stage == 4) readonly @endif>
                                                            <option value="">-- Select --</option>
                                                            @foreach ($users as $user)
                                                                <option value="{{ $user->id }}" @if($data1->CQA_person == $user->id) selected @endif>{{ $user->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- CQA Comment -->
                                                <div class="col-md-12 mb-3 cqa_person">
                                                    <div class="group-input">
                                                        <label for="CQA assessment">CQA Comment</label>
                                                        <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>
                                                        <textarea class="" name="CQA_comment" id="summernote-19"
                                                            @if($data1->CQA_Review == 'yes' && $data->stage == 4) required @endif
                                                            @if($data->stage == 3 || (isset($data1->CQA_person) && Auth::user()->id != $data1->CQA_person)) readonly @endif>{{ $data1->CQA_comment }}</textarea>
                                                    </div>
                                                </div>

                                                <!-- CQA Attachments -->
                                                <div class="col-lg-12 cqa_person">
                                                    <div class="group-input">
                                                        <label for="CQA attachment">CQA Attachments</label>
                                                        <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                                        <div class="file-attachment-field">
                                                            <div class="file-attachment-list" id="CQA_attachment">
                                                                @if($data1->CQA_attachment)
                                                                    @foreach(json_decode($data1->CQA_attachment) as $file)
                                                                        <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                                            <b>{{ $file }}</b>
                                                                            <a href="{{ asset('upload/' . $file) }}" target="_blank"><i class="fa fa-eye text-primary"
                                                                                    style="font-size: 20px; margin-right: -10px;"></i></a>
                                                                            <a type="button" class="remove-file" data-file-name="{{ $file }}"><i
                                                                                    class="fa-solid fa-circle-xmark" style="color: red; font-size: 20px;"></i></a>
                                                                        </h6>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                            <div class="add-btn">
                                                                <div>Add</div>
                                                                <input type="file" id="myfile" name="CQA_attachment[]" multiple 
                                                                    @if($data->stage == 0 || $data->stage == 8) readonly @endif 
                                                                    oninput="addMultipleFiles(this, 'CQA_attachment')">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- CQA Review Completed By -->
                                                <div class="col-md-6 mb-3 cqa_person">
                                                    <div class="group-input">
                                                        <label for="CQA Review Completed By">CQA Review Completed By</label>
                                                        <input readonly type="text" name="CQA_by" value="{{ $data1->CQA_by }}">
                                                    </div>
                                                </div>

                                                <!-- CQA Review Completed On -->
                                                <div class="col-lg-6 new-date-data-field cqa_person">
                                                    <div class="group-input input-date">
                                                        <label for="CQA Review Completed On">CQA Review Completed On</label>
                                                        <div class="calenderauditee">
                                                            <input type="text" id="CQA_on" readonly placeholder="DD-MM-YYYY" 
                                                                value="{{ Helpers::getdateFormat($data1->CQA_on) }}" />
                                                            <input readonly type="date" name="CQA_on" class="hide-input" 
                                                                oninput="handleDateInput(this, 'CQA_on')" />
                                                        </div>
                                                    </div>
                                                </div>

                                            @else

                                                <!-- CQA Review (Disabled) -->
                                                <div class="col-lg-6">
                                                    <div class="group-input">
                                                        <label for="CQA Review">CQA Review Required?</label>
                                                        <select name="CQA_Review" id="CQA_Review" readonly>
                                                            <option value="">-- Select --</option>
                                                            <option @if($data1->CQA_Review == 'yes') selected @endif value="yes">Yes</option>
                                                            <option @if($data1->CQA_Review == 'no') selected @endif value="no">No</option>
                                                            <option @if($data1->CQA_Review == 'na') selected @endif value="na">NA</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- CQA Person (Disabled) -->
                                                <div class="col-lg-6 cqa_person">
                                                    <div class="group-input">
                                                        <label for="CQA person">CQA Person</label>
                                                        <select name="CQA_person" id="CQA_person" readonly>
                                                            <option value="">-- Select --</option>
                                                            @foreach ($users as $user)
                                                                <option value="{{ $user->id }}" @if($data1->CQA_person == $user->id) selected @endif>{{ $user->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- CQA Comment (Disabled) -->
                                                <div class="col-md-12 mb-3 cqa_person">
                                                    <div class="group-input">
                                                        <label for="CQA assessment">CQA Comment</label>
                                                        <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>
                                                        <textarea class="" name="CQA_comment" id="summernote-19" readonly>{{ $data1->CQA_comment }}</textarea>
                                                    </div>
                                                </div>

                                                <!-- CQA Attachments (Disabled) -->
                                                <div class="col-lg-12 cqa_person">
                                                    <div class="group-input">
                                                        <label for="CQA attachment">CQA Attachments</label>
                                                        <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                                        <div class="file-attachment-field">
                                                            <div class="file-attachment-list" id="CQA_attachment">
                                                                @if($data1->CQA_attachment)
                                                                    @foreach(json_decode($data1->CQA_attachment) as $file)
                                                                        <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                                            <b>{{ $file }}</b>
                                                                            <a href="{{ asset('upload/' . $file) }}" target="_blank"><i class="fa fa-eye text-primary"
                                                                                    style="font-size: 20px; margin-right: -10px;"></i></a>
                                                                            <a type="button" class="remove-file" data-file-name="{{ $file }}"><i
                                                                                    class="fa-solid fa-circle-xmark" style="color: red; font-size: 20px;"></i></a>
                                                                        </h6>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- CQA Review Completed By (Disabled) -->
                                                <div class="col-md-6 mb-3 cqa_person">
                                                    <div class="group-input">
                                                        <label for="CQA Review Completed By">CQA Review Completed By</label>
                                                        <input readonly type="text" value="{{ $data1->CQA_by }}" name="CQA_by" readonly>
                                                    </div>
                                                </div>

                                                <!-- CQA Review Completed On (Disabled) -->
                                                <div class="col-lg-6 new-date-data-field cqa_person">
                                                    <div class="group-input input-date">
                                                        <label for="CQA Review Completed On">CQA Review Completed On</label>
                                                        <div class="calenderauditee">
                                                            <input type="text" id="CQA_on" readonly placeholder="DD-MM-YYYY"
                                                                value="{{ Helpers::getdateFormat($data1->CQA_on) }}" />
                                                            <input readonly type="date" name="CQA_on" class="hide-input" readonly />
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                            <!-- Microbiology Department -->
                                            @php
                                                $data1 = DB::table('global_change_controls_cfts')
                                                    ->where('cc_id', $data->id)
                                                    ->first();
                                            @endphp
                                            <div class="sub-head">
                                                Microbiology
                                            </div>
                                            <script>
                                                $(document).ready(function() {
                                                    @if($data1->Microbiology_Review !== 'yes')
                                                        $('.microbiology_person').hide();
                                                        $('[name="Microbiology_Review"]').change(function() {
                                                            if ($(this).val() === 'yes') {
                                                                $('.microbiology_person').show();
                                                                $('.microbiology_person span').show();
                                                            } else {
                                                                $('.microbiology_person').hide();
                                                                $('.microbiology_person span').hide();
                                                            }
                                                        });
                                                    @endif
                                                });
                                            </script>
                                            @if($data->stage == 3 || $data->stage == 4)

                                            <!-- Microbiology Review -->
                                            <div class="col-lg-6">
                                                <div class="group-input">
                                                    <label for="Microbiology Review">Microbiology Review Required ?<span class="text-danger">*</span></label>
                                                    <select name="Microbiology_Review" id="Microbiology_Review" @if($data->stage == 4) readonly @endif>
                                                        <option value="">-- Select --</option>
                                                        <option @if($data1->Microbiology_Review == 'yes') selected @endif value="yes">Yes</option>
                                                        <option @if($data1->Microbiology_Review == 'no') selected @endif value="no">No</option>
                                                        <option @if($data1->Microbiology_Review == 'na') selected @endif value="na">NA</option>
                                                    </select>
                                                </div>
                                            </div>

                                            @php
                                                $userRoles = DB::table('user_roles')
                                                    ->where([
                                                        'q_m_s_roles_id' => 56,
                                                        'q_m_s_divisions_id' => $data->division_id,
                                                    ])->get();
                                                $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                                $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); 
                                            @endphp

                                            <!-- Microbiology Person -->
                                            <div class="col-lg-6 microbiology_person">
                                                <div class="group-input">
                                                    <label for="Microbiology person">Microbiology Person</label>
                                                    <select name="Microbiology_person" id="Microbiology_person" @if($data->stage == 4) readonly @endif>
                                                        <option value="">-- Select --</option>
                                                        @foreach ($users as $user)
                                                            <option value="{{ $user->id }}" @if($data1->Microbiology_person == $user->id) selected @endif>{{ $user->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Microbiology Comment -->
                                            <div class="col-md-12 mb-3 microbiology_person">
                                                <div class="group-input">
                                                    <label for="Microbiology comment">Microbiology Assessment</label>
                                                    <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>
                                                    <textarea class="" name="Microbiology_assessment" id="summernote-19"
                                                        @if($data1->Microbiology_Review == 'yes' && $data->stage == 4) required @endif
                                                        @if($data->stage == 3 || (isset($data1->Microbiology_person) && Auth::user()->id != $data1->Microbiology_person)) readonly @endif>{{ $data1->Microbiology_assessment }}</textarea>
                                                </div>
                                            </div>

                                            <div class="col-md-12 mb-3 microbiology_person">
                                                <div class="group-input">
                                                    <label for="Microbiology comment">Microbiology Feedback</label>
                                                    <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>
                                                    <textarea class="" name="Microbiology_feedback" id="summernote-19"
                                                        @if($data1->Microbiology_Review == 'yes' && $data->stage == 4) required @endif
                                                        @if($data->stage == 3 || (isset($data1->Microbiology_person) && Auth::user()->id != $data1->Microbiology_person)) readonly @endif>{{ $data1->Microbiology_feedback }}</textarea>
                                                </div>
                                            </div>

                                            <!-- Microbiology Attachments -->
                                            <div class="col-lg-12 microbiology_person">
                                                <div class="group-input">
                                                    <label for="Microbiology attachment">Microbiology Attachments</label>
                                                    <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                                    <div class="file-attachment-field">
                                                        <div class="file-attachment-list" id="Microbiology_attachment">
                                                            @if($data1->Microbiology_attachment)
                                                                @foreach(json_decode($data1->Microbiology_attachment) as $file)
                                                                    <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                                        <b>{{ $file }}</b>
                                                                        <a href="{{ asset('upload/' . $file) }}" target="_blank"><i class="fa fa-eye text-primary"
                                                                                style="font-size: 20px; margin-right: -10px;"></i></a>
                                                                        <a type="button" class="remove-file" data-file-name="{{ $file }}"><i
                                                                                class="fa-solid fa-circle-xmark" style="color: red; font-size: 20px;"></i></a>
                                                                    </h6>
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                        <div class="add-btn">
                                                            <div>Add</div>
                                                            <input type="file" id="myfile" name="Microbiology_attachment[]" multiple 
                                                                @if($data->stage == 0 || $data->stage == 8) readonly @endif 
                                                                oninput="addMultipleFiles(this, 'Microbiology_attachment')">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Microbiology Review Completed By -->
                                            <div class="col-md-6 mb-3 microbiology_person">
                                                <div class="group-input">
                                                    <label for="Microbiology Review Completed By">Microbiology Review Completed By</label>
                                                    <input readonly type="text" name="Microbiology_by" value="{{ $data1->Microbiology_by }}">
                                                </div>
                                            </div>

                                            <!-- Microbiology Review Completed On -->
                                            <div class="col-lg-6 new-date-data-field microbiology_person">
                                                <div class="group-input input-date">
                                                    <label for="Microbiology Review Completed On">Microbiology Review Completed On</label>
                                                    <div class="calenderauditee">
                                                        <input type="text" id="Microbiology_on" readonly placeholder="DD-MM-YYYY" 
                                                            value="{{ Helpers::getdateFormat($data1->Microbiology_on) }}" />
                                                        <input readonly type="date" name="Microbiology_on" class="hide-input" 
                                                            oninput="handleDateInput(this, 'Microbiology_on')" />
                                                    </div>
                                                </div>
                                            </div>

                                            @else

                                            <!-- Microbiology Review (Disabled) -->
                                            <div class="col-lg-6">
                                                <div class="group-input">
                                                    <label for="Microbiology Review">Microbiology Review Required?</label>
                                                    <select name="Microbiology_Review" id="Microbiology_Review" readonly>
                                                        <option value="">-- Select --</option>
                                                        <option @if($data1->Microbiology_Review == 'yes') selected @endif value="yes">Yes</option>
                                                        <option @if($data1->Microbiology_Review == 'no') selected @endif value="no">No</option>
                                                        <option @if($data1->Microbiology_Review == 'na') selected @endif value="na">NA</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Microbiology Person (Disabled) -->
                                            <div class="col-lg-6 microbiology_person">
                                                <div class="group-input">
                                                    <label for="Microbiology person">Microbiology Person</label>
                                                    <select name="Microbiology_person" id="Microbiology_person" readonly>
                                                        <option value="">-- Select --</option>
                                                        @foreach ($users as $user)
                                                            <option value="{{ $user->id }}" @if($data1->Microbiology_person == $user->id) selected @endif>{{ $user->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Microbiology Comment (Disabled) -->
                                            <div class="col-md-12 mb-3 microbiology_person">
                                                <div class="group-input">
                                                    <label for="Microbiology comment">Microbiology Assessment</label>
                                                    <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>
                                                    <textarea class="" name="Microbiology_assessment" id="summernote-19" readonly>{{ $data1->Microbiology_assessment }}</textarea>
                                                </div>
                                            </div>

                                            <div class="col-md-12 mb-3 microbiology_person">
                                                <div class="group-input">
                                                    <label for="Microbiology comment">Microbiology Feedback</label>
                                                    <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>
                                                    <textarea class="" name="Microbiology_feedback" id="summernote-19" readonly>{{ $data1->Microbiology_feedback }}</textarea>
                                                </div>
                                            </div>

                                            <!-- Microbiology Attachments (Disabled) -->
                                            <div class="col-lg-12 microbiology_person">
                                                <div class="group-input">
                                                    <label for="Microbiology attachment">Microbiology Attachments</label>
                                                    <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                                    <div class="file-attachment-list" id="Microbiology_attachment">
                                                        @if($data1->Microbiology_attachment)
                                                            @foreach(json_decode($data1->Microbiology_attachment) as $file)
                                                                <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                                    <b>{{ $file }}</b>
                                                                    <a href="{{ asset('upload/' . $file) }}" target="_blank"><i class="fa fa-eye text-primary"
                                                                            style="font-size: 20px; margin-right: -10px;"></i></a>
                                                                    <a type="button" class="remove-file" data-file-name="{{ $file }}"><i
                                                                            class="fa-solid fa-circle-xmark" style="color: red; font-size: 20px;"></i></a>
                                                                </h6>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Microbiology Review Completed By (Disabled) -->
                                            <div class="col-md-6 mb-3 microbiology_person">
                                                <div class="group-input">
                                                    <label for="Microbiology Review Completed By">Microbiology Review Completed By</label>
                                                    <input readonly type="text" name="Microbiology_by" value="{{ $data1->Microbiology_by }}">
                                                </div>
                                            </div>

                                            <!-- Microbiology Review Completed On (Disabled) -->
                                            <div class="col-lg-6 new-date-data-field microbiology_person">
                                                <div class="group-input input-date">
                                                    <label for="Microbiology Review Completed On">Microbiology Review Completed On</label>
                                                    <div class="calenderauditee">
                                                        <input type="text" id="Microbiology_on" readonly placeholder="DD-MM-YYYY" 
                                                            value="{{ Helpers::getdateFormat($data1->Microbiology_on) }}" />
                                                        <input readonly type="date" name="Microbiology_on" class="hide-input" readonly />
                                                    </div>
                                                </div>
                                            </div>
                                            @endif

                                            <!-- Sysyem IT Department -->
                                            @php
                                                $data1 = DB::table('global_change_controls_cfts')
                                                    ->where('cc_id', $data->id)
                                                    ->first();
                                            @endphp
                                            <div class="sub-head">
                                                System IT
                                            </div>
                                            <script>
                                                $(document).ready(function() {
                                                    @if($data1->SystemIT_Review !== 'yes')
                                                    $('.systemit_person').hide();

                                                    $('[name="SystemIT_Review"]').change(function() {
                                                        if ($(this).val() === 'yes') {
                                                            $('.systemit_person').show();
                                                            $('.systemit_person span').show();
                                                        } else {
                                                            $('.systemit_person').hide();
                                                            $('.systemit_person span').hide();
                                                        }
                                                    });
                                                    @endif
                                                });
                                            </script>
                                            @if($data->stage == 3 || $data->stage == 4)

                                            <!-- System IT Review -->
                                            <div class="col-lg-6">
                                                <div class="group-input">
                                                    <label for="System IT Review">System IT Review Required ?<span class="text-danger">*</span></label>
                                                    <select name="SystemIT_Review" id="SystemIT_Review" @if($data->stage == 4) readonly @endif>
                                                        <option value="">-- Select --</option>
                                                        <option @if($data1->SystemIT_Review == 'yes') selected @endif value="yes">Yes</option>
                                                        <option @if($data1->SystemIT_Review == 'no') selected @endif value="no">No</option>
                                                        <option @if($data1->SystemIT_Review == 'na') selected @endif value="na">NA</option>
                                                    </select>
                                                </div>
                                            </div>

                                            @php
                                                $userRoles = DB::table('user_roles')
                                                    ->where([
                                                        'q_m_s_roles_id' => 32,
                                                        'q_m_s_divisions_id' => $data->division_id,
                                                    ])->get();
                                                $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                                $users = DB::table('users')->whereIn('id', $userRoleIds)->get();
                                            @endphp

                                            <!-- System IT Person -->
                                            <div class="col-lg-6 systemit_person">
                                                <div class="group-input">
                                                    <label for="System IT person">System IT Person</label>
                                                    <select name="SystemIT_person" id="SystemIT_person" @if($data->stage == 4) readonly @endif>
                                                        <option value="">-- Select --</option>
                                                        @foreach ($users as $user)
                                                            <option value="{{ $user->id }}" @if($data1->SystemIT_person == $user->id) selected @endif>{{ $user->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- System IT Comment -->
                                            <div class="col-md-12 mb-3 systemit_person">
                                                <div class="group-input">
                                                    <label for="System IT comment">System IT Comment</label>
                                                    <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>
                                                    <textarea class="" name="SystemIT_comment" id="summernote-19"
                                                        @if($data1->SystemIT_Review == 'yes' && $data->stage == 4) required @endif
                                                        @if($data->stage == 3 || (isset($data1->SystemIT_person) && Auth::user()->id != $data1->SystemIT_person)) readonly @endif>{{ $data1->SystemIT_comment }}</textarea>
                                                </div>
                                            </div>

                                            <!-- System IT Attachments -->
                                            <div class="col-lg-12 systemit_person">
                                                <div class="group-input">
                                                    <label for="System IT attachment">System IT Attachments</label>
                                                    <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                                    <div class="file-attachment-field">
                                                        <div class="file-attachment-list" id="SystemIT_attachment">
                                                            @if($data1->SystemIT_attachment)
                                                                @foreach(json_decode($data1->SystemIT_attachment) as $file)
                                                                    <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                                        <b>{{ $file }}</b>
                                                                        <a href="{{ asset('upload/' . $file) }}" target="_blank"><i class="fa fa-eye text-primary" style="font-size: 20px; margin-right: -10px;"></i></a>
                                                                        <a type="button" class="remove-file" data-file-name="{{ $file }}"><i class="fa-solid fa-circle-xmark" style="color: red; font-size: 20px;"></i></a>
                                                                    </h6>
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                        <div class="add-btn">
                                                            <div>Add</div>
                                                            <input type="file" id="myfile" name="SystemIT_attachment[]" multiple
                                                                @if($data->stage == 0 || $data->stage == 8) readonly @endif
                                                                oninput="addMultipleFiles(this, 'SystemIT_attachment')">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- System IT Review Completed By -->
                                            <div class="col-md-6 mb-3 systemit_person">
                                                <div class="group-input">
                                                    <label for="System IT Review Completed By">System IT Review Completed By</label>
                                                    <input readonly type="text" name="SystemIT_by" value="{{ $data1->SystemIT_by }}">
                                                </div>
                                            </div>

                                            <!-- System IT Review Completed On -->
                                            <div class="col-lg-6 new-date-data-field systemit_person">
                                                <div class="group-input input-date">
                                                    <label for="System IT Review Completed On">System IT Review Completed On</label>
                                                    <div class="calenderauditee">
                                                        <input type="text" id="SystemIT_on" readonly placeholder="DD-MM-YYYY"
                                                            value="{{ Helpers::getdateFormat($data1->SystemIT_on) }}" />
                                                        <input readonly type="date" name="SystemIT_on" class="hide-input"
                                                            oninput="handleDateInput(this, 'SystemIT_on')" />
                                                    </div>
                                                </div>
                                            </div>

                                            @else

                                            <!-- System IT Review (Disabled) -->
                                            <div class="col-lg-6">
                                                <div class="group-input">
                                                    <label for="System IT Review">System IT Review Required?</label>
                                                    <select name="SystemIT_Review" id="SystemIT_Review" readonly>
                                                        <option value="">-- Select --</option>
                                                        <option @if($data1->SystemIT_Review == 'yes') selected @endif value="yes">Yes</option>
                                                        <option @if($data1->SystemIT_Review == 'no') selected @endif value="no">No</option>
                                                        <option @if($data1->SystemIT_Review == 'na') selected @endif value="na">NA</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- System IT Person (Disabled) -->
                                            <div class="col-lg-6 systemit_person">
                                                <div class="group-input">
                                                    <label for="System IT person">System IT Person</label>
                                                    <select name="SystemIT_person" id="SystemIT_person" readonly>
                                                        <option value="">-- Select --</option>
                                                        @foreach ($users as $user)
                                                            <option value="{{ $user->id }}" @if($data1->SystemIT_person == $user->id) selected @endif>{{ $user->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- System IT Comment (Disabled) -->
                                            <div class="col-md-12 mb-3 systemit_person">
                                                <div class="group-input">
                                                    <label for="System IT comment">System IT Comment</label>
                                                    <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>
                                                    <textarea class="" name="SystemIT_comment" id="summernote-19" readonly>{{ $data1->SystemIT_comment }}</textarea>
                                                </div>
                                            </div>

                                            <!-- System IT Attachments (Disabled) -->
                                            <div class="col-lg-12 systemit_person">
                                                <div class="group-input">
                                                    <label for="System IT attachment">System IT Attachments</label>
                                                    <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                                    <div class="file-attachment-list" id="SystemIT_attachment">
                                                        @if($data1->SystemIT_attachment)
                                                            @foreach(json_decode($data1->SystemIT_attachment) as $file)
                                                                <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                                    <b>{{ $file }}</b>
                                                                    <a href="{{ asset('upload/' . $file) }}" target="_blank"><i class="fa fa-eye text-primary" style="font-size: 20px; margin-right: -10px;"></i></a>
                                                                    <a type="button" class="remove-file" data-file-name="{{ $file }}"><i class="fa-solid fa-circle-xmark" style="color: red; font-size: 20px;"></i></a>
                                                                </h6>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- System IT Review Completed By (Disabled) -->
                                            <div class="col-md-6 mb-3 systemit_person">
                                                <div class="group-input">
                                                    <label for="System IT Review Completed By">System IT Review Completed By</label>
                                                    <input readonly type="text" name="SystemIT_by" value="{{ $data1->SystemIT_by }}" readonly>
                                                </div>
                                            </div>

                                            <!-- System IT Review Completed On (Disabled) -->
                                            <div class="col-lg-6 new-date-data-field systemit_person">
                                                <div class="group-input input-date">
                                                    <label for="System IT Review Completed On">System IT Review Completed On</label>
                                                    <div class="calenderauditee">
                                                        <input type="text" id="SystemIT_on" readonly placeholder="DD-MM-YYYY"
                                                            value="{{ Helpers::getdateFormat($data1->SystemIT_on) }}" />
                                                        <input readonly type="date" name="SystemIT_on" class="hide-input" readonly />
                                                    </div>
                                                </div>
                                            </div>
                                            @endif


                                            <!-- Quality Assurance Department -->
                                            @php
                                                $data1 = DB::table('global_change_controls_cfts')
                                                    ->where('cc_id', $data->id)
                                                    ->first();
                                            @endphp
                                            <div class="sub-head">
                                                Quality Assurance
                                            </div>
                                            <script>
                                                $(document).ready(function() {
                                                    @if($data1->Quality_Assurance_Review !== 'yes')
                                                    $('.quality_assurance').hide();

                                                    $('[name="Quality_Assurance_Review"]').change(function() {
                                                        if ($(this).val() === 'yes') {
                                                            $('.quality_assurance').show();
                                                            $('.quality_assurance span').show();
                                                        } else {
                                                            $('.quality_assurance').hide();
                                                            $('.quality_assurance span').hide();
                                                        }
                                                    });
                                                    @endif
                                                });
                                            </script>

                                            @if($data->stage == 3 || $data->stage == 4)
                                            <!-- Quality Assurance Review -->
                                            <div class="col-lg-6">
                                                <div class="group-input">
                                                    <label for="Customer notification">Quality Assurance Review Required ?<span class="text-danger">*</span></label>
                                                    <select name="Quality_Assurance_Review" id="QualityAssurance_review" @if($data->stage == 4) readonly @endif>
                                                        <option value="">-- Select --</option>
                                                        <option @if($data1->Quality_Assurance_Review == 'yes') selected @endif value="yes">Yes</option>
                                                        <option @if($data1->Quality_Assurance_Review == 'no') selected @endif value="no">No</option>
                                                        <option @if($data1->Quality_Assurance_Review == 'na') selected @endif value="na">NA</option>
                                                    </select>
                                                </div>
                                            </div>

                                            @php
                                                $userRoles = DB::table('user_roles')
                                                    ->where([
                                                        'q_m_s_roles_id' => 26,
                                                        'q_m_s_divisions_id' => $data->division_id,
                                                    ])->get();
                                                $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                                $users = DB::table('users')->whereIn('id', $userRoleIds)->get();
                                            @endphp

                                            <!-- Quality Assurance Person -->
                                            <div class="col-lg-6 quality_assurance">
                                                <div class="group-input">
                                                    <label for="Quality Assurance Person">Quality Assurance Person</label>
                                                    <select name="QualityAssurance_person" id="QualityAssurance_person" @if($data->stage == 4) readonly @endif>
                                                        <option value="">-- Select --</option>
                                                        @foreach ($users as $user)
                                                            <option value="{{ $user->id }}" @if($data1->QualityAssurance_person == $user->id) selected @endif>{{ $user->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Quality Assurance Comment -->
                                            <div class="col-md-12 mb-3 quality_assurance">
                                                <div class="group-input">
                                                    <label for="Impact Assessment3">Quality Assurance Assessment</label>
                                                    <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>
                                                    <textarea class="" name="QualityAssurance_assessment" id="summernote-23"
                                                        @if($data1->Quality_Assurance_Review == 'yes' && $data->stage == 4) required @endif
                                                        @if($data->stage == 3 || (isset($data1->QualityAssurance_person) && Auth::user()->id != $data1->QualityAssurance_person)) readonly @endif>{{ $data1->QualityAssurance_assessment }}</textarea>
                                                </div>
                                            </div>

                                            <div class="col-md-12 mb-3 quality_assurance">
                                                <div class="group-input">
                                                    <label for="Impact Assessment3">Quality Assurance Feedback</label>
                                                    <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>
                                                    <textarea class="" name="QualityAssurance_feedback" id="summernote-23"
                                                        @if($data1->Quality_Assurance_Review == 'yes' && $data->stage == 4) required @endif
                                                        @if($data->stage == 3 || (isset($data1->QualityAssurance_person) && Auth::user()->id != $data1->QualityAssurance_person)) readonly @endif>{{ $data1->QualityAssurance_feedback }}</textarea>
                                                </div>
                                            </div>

                                            <!-- Quality Assurance Attachments -->
                                            <div class="col-lg-12 quality_assurance">
                                                <div class="group-input">
                                                    <label for="Quality Assurance Attachments">Quality Assurance Attachments</label>
                                                    <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                                    <div class="file-attachment-field">
                                                        <div class="file-attachment-list" id="Quality_Assurance_attachment">
                                                            @if($data1->Quality_Assurance_attachment)
                                                                @foreach(json_decode($data1->Quality_Assurance_attachment) as $file)
                                                                    <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                                        <b>{{ $file }}</b>
                                                                        <a href="{{ asset('upload/' . $file) }}" target="_blank"><i class="fa fa-eye text-primary"
                                                                                style="font-size: 20px; margin-right: -10px;"></i></a>
                                                                        <a type="button" class="remove-file" data-file-name="{{ $file }}"><i class="fa-solid fa-circle-xmark"
                                                                                style="color: red; font-size: 20px;"></i></a>
                                                                    </h6>
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                        <div class="add-btn">
                                                            <div>Add</div>
                                                            <input type="file" id="myfile" name="Quality_Assurance_attachment[]" multiple
                                                                @if($data->stage == 0 || $data->stage == 8) readonly @endif
                                                                oninput="addMultipleFiles(this, 'Quality_Assurance_attachment')">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Quality Assurance Review Completed By -->
                                            <div class="col-md-6 mb-3 quality_assurance">
                                                <div class="group-input">
                                                    <label for="Quality Assurance Review Completed By">Quality Assurance Review Completed By</label>
                                                    <input readonly type="text" name="QualityAssurance_by" value="{{ $data1->QualityAssurance_by }}">
                                                </div>
                                            </div>

                                            <!-- Quality Assurance Review Completed On -->
                                            <div class="col-lg-6 new-date-data-field quality_assurance">
                                                <div class="group-input input-date">
                                                    <label for="Quality Assurance Review Completed On">Quality Assurance Review Completed On</label>
                                                    <div class="calenderauditee">
                                                        <input type="text" id="QualityAssurance_on" readonly placeholder="DD-MM-YYYY"
                                                            value="{{ Helpers::getdateFormat($data1->QualityAssurance_on) }}" />
                                                        <input readonly type="date" name="QualityAssurance_on" class="hide-input"
                                                            oninput="handleDateInput(this, 'QualityAssurance_on')" />
                                                    </div>
                                                </div>
                                            </div>

                                            @else

                                            <!-- Quality Assurance Review (Disabled) -->
                                            <div class="col-lg-6">
                                                <div class="group-input">
                                                    <label for="Customer notification">Quality Assurance Review Required?</label>
                                                    <select name="Quality_Assurance_Review" id="QualityAssurance_review" readonly>
                                                        <option value="">-- Select --</option>
                                                        <option @if($data1->Quality_Assurance_Review == 'yes') selected @endif value="yes">Yes</option>
                                                        <option @if($data1->Quality_Assurance_Review == 'no') selected @endif value="no">No</option>
                                                        <option @if($data1->Quality_Assurance_Review == 'na') selected @endif value="na">NA</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Quality Assurance Person (Disabled) -->
                                            <div class="col-lg-6 quality_assurance">
                                                <div class="group-input">
                                                    <label for="Quality Assurance Person">Quality Assurance Person</label>
                                                    <select name="QualityAssurance_person" id="QualityAssurance_person" readonly>
                                                        <option value="">-- Select --</option>
                                                        @foreach ($users as $user)
                                                            <option value="{{ $user->id }}" @if($data1->QualityAssurance_person == $user->id) selected @endif>{{ $user->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Quality Assurance Comment (Disabled) -->
                                            <div class="col-md-12 mb-3 quality_assurance">
                                                <div class="group-input">
                                                    <label for="Impact Assessment3">Quality Assurance Assessment</label>
                                                    <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>
                                                    <textarea class="" name="QualityAssurance_assessment" id="summernote-23" readonly>{{ $data1->QualityAssurance_assessment }}</textarea>
                                                </div>
                                            </div>

                                            <div class="col-md-12 mb-3 quality_assurance">
                                                <div class="group-input">
                                                    <label for="Impact Assessment3">Quality Assurance Feedback</label>
                                                    <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>
                                                    <textarea class="" name="QualityAssurance_feedback" id="summernote-23" readonly>{{ $data1->QualityAssurance_feedback }}</textarea>
                                                </div>
                                            </div>

                                            <!-- Quality Assurance Attachments (Disabled) -->
                                            <div class="col-lg-12 quality_assurance">
                                                <div class="group-input">
                                                    <label for="Quality Assurance Attachments">Quality Assurance Attachments</label>
                                                    <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                                    <div class="file-attachment-list" id="Quality_Assurance_attachment">
                                                        @if($data1->Quality_Assurance_attachment)
                                                            @foreach(json_decode($data1->Quality_Assurance_attachment) as $file)
                                                                <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                                    <b>{{ $file }}</b>
                                                                    <a href="{{ asset('upload/' . $file) }}" target="_blank"><i class="fa fa-eye text-primary"
                                                                            style="font-size: 20px; margin-right: -10px;"></i></a>
                                                                    <a type="button" class="remove-file" data-file-name="{{ $file }}"><i
                                                                            class="fa-solid fa-circle-xmark" style="color: red; font-size: 20px;"></i></a>
                                                                </h6>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Quality Assurance Review Completed By (Disabled) -->
                                            <div class="col-md-6 mb-3 quality_assurance">
                                                <div class="group-input">
                                                    <label for="Quality Assurance Review Completed By">Quality Assurance Review Completed By</label>
                                                    <input readonly type="text" name="QualityAssurance_by" value="{{ $data1->QualityAssurance_by }}" readonly>
                                                </div>
                                            </div>

                                            <!-- Quality Assurance Review Completed On (Disabled) -->
                                            <div class="col-lg-6 new-date-data-field quality_assurance">
                                                <div class="group-input input-date">
                                                    <label for="Quality Assurance Review Completed On">Quality Assurance Review Completed On</label>
                                                    <div class="calenderauditee">
                                                        <input type="text" id="QualityAssurance_on" readonly placeholder="DD-MM-YYYY"
                                                            value="{{ Helpers::getdateFormat($data1->QualityAssurance_on) }}" />
                                                        <input readonly type="date" name="QualityAssurance_on" class="hide-input" readonly />
                                                    </div>
                                                </div>
                                            </div>
                                            @endif


                                            <!-- Human Resource & Administration Department -->
                                            @php
                                                $data1 = DB::table('global_change_controls_cfts')
                                                    ->where('cc_id', $data->id)
                                                    ->first();
                                            @endphp
                                            <div class="sub-head">
                                                Human Resource & Administration
                                            </div>
                                            <script>
                                                $(document).ready(function() {
                                                    
                                                    @if($data1->Human_Resource_review !== 'yes')
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
                                                    @endif
                                                });
                                            </script>

                                            @if($data->stage == 3 || $data->stage == 4)

                                            <!-- Human Resource & Administration Review -->
                                            <div class="col-lg-6">
                                                <div class="group-input">
                                                    <label for="Administration Review Required">Human Resource & Administration Review Required ?<span class="text-danger">*</span></label>
                                                    <select name="Human_Resource_review" id="Human_Resource_review" @if($data->stage == 4) readonly @endif>
                                                        <option value="">-- Select --</option>
                                                        <option @if($data1->Human_Resource_review == 'yes') selected @endif value="yes">Yes</option>
                                                        <option @if($data1->Human_Resource_review == 'no') selected @endif value="no">No</option>
                                                        <option @if($data1->Human_Resource_review == 'na') selected @endif value="na">NA</option>
                                                    </select>
                                                </div>
                                            </div>

                                            @php
                                                $userRoles = DB::table('user_roles')
                                                    ->where([
                                                        'q_m_s_roles_id' => 31,
                                                        'q_m_s_divisions_id' => $data->division_id,
                                                    ])->get();
                                                $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                                $users = DB::table('users')->whereIn('id', $userRoleIds)->get();
                                            @endphp

                                            <!-- Human Resource & Administration Person -->
                                            <div class="col-lg-6 human_resources">
                                                <div class="group-input">
                                                    <label for="Administration Person">Human Resource & Administration Person</label>
                                                    <select name="Human_Resource_person" id="Human_Resource_person" @if($data->stage == 4) readonly @endif>
                                                        <option value="">-- Select --</option>
                                                        @foreach ($users as $user)
                                                            <option value="{{ $user->id }}" @if($data1->Human_Resource_person == $user->id) selected @endif>{{ $user->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Human Resource & Administration Comment -->
                                            <div class="col-md-12 mb-3 human_resources">
                                                <div class="group-input">
                                                    <label for="Impact Assessment9">Human Resource & Administration Assessment</label>
                                                    <textarea class="" name="Human_Resource_assessment" id="summernote-35"
                                                        @if($data1->Human_Resource_review == 'yes' && $data->stage == 4) required @endif
                                                        @if($data->stage == 3 || (isset($data1->Human_Resource_person) && Auth::user()->id != $data1->Human_Resource_person)) readonly @endif>{{ $data1->Human_Resource_assessment }}</textarea>
                                                </div>
                                            </div>

                                            <div class="col-md-12 mb-3 human_resources">
                                                <div class="group-input">
                                                    <label for="Impact Assessment9">Human Resource & Administration Feedback</label>
                                                    <textarea class="" name="Human_Resource_feedback" id="summernote-35"
                                                        @if($data1->Human_Resource_review == 'yes' && $data->stage == 4) required @endif
                                                        @if($data->stage == 3 || (isset($data1->Human_Resource_person) && Auth::user()->id != $data1->Human_Resource_person)) readonly @endif>{{ $data1->Human_Resource_feedback }}</textarea>
                                                </div>
                                            </div>

                                            <!-- Human Resource & Administration Attachments -->
                                            <div class="col-lg-12 human_resources">
                                                <div class="group-input">
                                                    <label for="Audit Attachments">Human Resource & Administration Attachments</label>
                                                    <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                                    <div class="file-attachment-field">
                                                        <div class="file-attachment-list" id="Human_Resource_attachment">
                                                            @if($data1->Human_Resource_attachment)
                                                                @foreach(json_decode($data1->Human_Resource_attachment) as $file)
                                                                    <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                                        <b>{{ $file }}</b>
                                                                        <a href="{{ asset('upload/' . $file) }}" target="_blank">
                                                                            <i class="fa fa-eye text-primary" style="font-size: 20px; margin-right: -10px;"></i>
                                                                        </a>
                                                                        <a type="button" class="remove-file" data-file-name="{{ $file }}">
                                                                            <i class="fa-solid fa-circle-xmark" style="color: red; font-size: 20px;"></i>
                                                                        </a>
                                                                    </h6>
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                        <div class="add-btn">
                                                            <div>Add</div>
                                                            <input type="file" id="myfile" name="Human_Resource_attachment[]" multiple
                                                                @if($data->stage == 0 || $data->stage == 8) readonly @endif
                                                                oninput="addMultipleFiles(this, 'Human_Resource_attachment')">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Human Resource & Administration Review Completed By -->
                                            <div class="col-md-6 mb-3 human_resources">
                                                <div class="group-input">
                                                    <label for="Administration Review Completed By">Human Resource & Administration Review Completed By</label>
                                                    <input readonly type="text" name="Human_Resource_by" value="{{ $data1->Human_Resource_by }}">
                                                </div>
                                            </div>

                                            <!-- Human Resource & Administration Review Completed On -->
                                            <div class="col-lg-6 new-date-data-field human_resources">
                                                <div class="group-input input-date">
                                                    <label for="Administration Review Completed On">Human Resource & Administration Review Completed On</label>
                                                    <div class="calenderauditee">
                                                        <input type="text" id="Human_Resource_on" readonly placeholder="DD-MM-YYYY"
                                                            value="{{ Helpers::getdateFormat($data1->Human_Resource_on) }}" />
                                                        <input readonly type="date" name="Human_Resource_on" class="hide-input"
                                                            oninput="handleDateInput(this, 'Human_Resource_on')" />
                                                    </div>
                                                </div>
                                            </div>

                                            @else

                                            <!-- Human Resource & Administration Review (Disabled) -->
                                            <div class="col-lg-6">
                                                <div class="group-input">
                                                    <label for="Administration Review Required">Human Resource & Administration Review Required?</label>
                                                    <select name="Human_Resource_review" id="Human_Resource_review" readonly>
                                                        <option value="">-- Select --</option>
                                                        <option @if($data1->Human_Resource_review == 'yes') selected @endif value="yes">Yes</option>
                                                        <option @if($data1->Human_Resource_review == 'no') selected @endif value="no">No</option>
                                                        <option @if($data1->Human_Resource_review == 'na') selected @endif value="na">NA</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Human Resource & Administration Person (Disabled) -->
                                            <div class="col-lg-6 human_resources">
                                                <div class="group-input">
                                                    <label for="Administration Person">Human Resource & Administration Person</label>
                                                    <select name="Human_Resource_person" id="Human_Resource_person" readonly>
                                                        <option value="">-- Select --</option>
                                                        @foreach ($users as $user)
                                                            <option value="{{ $user->id }}" @if($data1->Human_Resource_person == $user->id) selected @endif>{{ $user->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Human Resource & Administration Comment (Disabled) -->
                                            <div class="col-md-12 mb-3 human_resources">
                                                <div class="group-input">
                                                    <label for="Impact Assessment9">Human Resource & Administration Assessment</label>
                                                    <textarea class="" name="Human_Resource_assessment" id="summernote-35" readonly>{{ $data1->Human_Resource_assessment }}</textarea>
                                                </div>
                                            </div>

                                            <div class="col-md-12 mb-3 human_resources">
                                                <div class="group-input">
                                                    <label for="Impact Assessment9">Human Resource & Administration Feedback</label>
                                                    <textarea class="" name="Human_Resource_feedback" id="summernote-35" readonly>{{ $data1->Human_Resource_feedback }}</textarea>
                                                </div>
                                            </div>

                                            <!-- Human Resource & Administration Attachments (Disabled) -->
                                            <div class="col-lg-12 human_resources">
                                                <div class="group-input">
                                                    <label for="Audit Attachments">Human Resource & Administration Attachments</label>
                                                    <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                                    <div class="file-attachment-list" id="Human_Resource_attachment">
                                                        @if($data1->Human_Resource_attachment)
                                                            @foreach(json_decode($data1->Human_Resource_attachment) as $file)
                                                                <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                                    <b>{{ $file }}</b>
                                                                    <a href="{{ asset('upload/' . $file) }}" target="_blank">
                                                                        <i class="fa fa-eye text-primary" style="font-size: 20px; margin-right: -10px;"></i>
                                                                    </a>
                                                                    <a type="button" class="remove-file" data-file-name="{{ $file }}">
                                                                        <i class="fa-solid fa-circle-xmark" style="color: red; font-size: 20px;"></i>
                                                                    </a>
                                                                </h6>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Human Resource & Administration Review Completed By (Disabled) -->
                                            <div class="col-md-6 mb-3 human_resources">
                                                <div class="group-input">
                                                    <label for="Administration Review Completed By">Human Resource & Administration Review Completed By</label>
                                                    <input readonly type="text" name="Human_Resource_by" value="{{ $data1->Human_Resource_by }}" readonly>
                                                </div>
                                            </div>

                                            <!-- Human Resource & Administration Review Completed On (Disabled) -->
                                            <div class="col-lg-6 new-date-data-field human_resources">
                                                <div class="group-input input-date">
                                                    <label for="Administration Review Completed On">Human Resource & Administration Review Completed On</label>
                                                    <div class="calenderauditee">
                                                        <input type="text" id="Human_Resource_on" readonly placeholder="DD-MM-YYYY"
                                                            value="{{ Helpers::getdateFormat($data1->Human_Resource_on) }}" />
                                                        <input readonly type="date" name="Human_Resource_on" class="hide-input" readonly />
                                                    </div>
                                                </div>
                                            </div>
                                            @endif

                                            <!-- Other's 1 Department -->
                                            @php
                                                $data1 = DB::table('global_change_controls_cfts')
                                                    ->where('cc_id', $data->id)
                                                    ->first();
                                            @endphp
                                            <div class="sub-head">
                                                Other's 1 ( Additional Person Review From Departments If Required)
                                            </div>
                                            <script>
                                                $(document).ready(function() {
                                                    @if($data1->Other2_review !== 'yes')
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
                                                    @endif
                                                });
                                            </script>
                                            @if($data->stage == 3 || $data->stage == 4)

                                            <!-- Other's 1 Review -->
                                            <div class="col-lg-6">
                                                <div class="group-input">
                                                    <label for="Customer notification">Other's 1 Review Required ?</label>
                                                    <select name="Other1_review" id="Other1_review" @if($data->stage == 4) readonly @endif>
                                                        <option value="">-- Select --</option>
                                                        <option @if($data1->Other1_review == 'yes') selected @endif value="yes">Yes</option>
                                                        <option @if($data1->Other1_review == 'no') selected @endif value="no">No</option>
                                                        <option @if($data1->Other1_review == 'na') selected @endif value="na">NA</option>
                                                    </select>
                                                </div>
                                            </div>

                                            @php
                                                $userRoles = DB::table('user_roles')
                                                    ->where([
                                                        'q_m_s_roles_id' => 18,
                                                        'q_m_s_divisions_id' => $data->division_id,
                                                    ])->get();
                                                $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                                $users = DB::table('users')->whereIn('id', $userRoleIds)->get();
                                            @endphp

                                            <!-- Other's 1 Person -->
                                            <div class="col-lg-6 other1_reviews">
                                                <div class="group-input">
                                                    <label for="Customer notification">Other's 1 Person</label>
                                                    <select name="Other1_person" id="Other1_person" @if($data->stage == 4) readonly @endif>
                                                        <option value="">-- Select --</option>
                                                        @foreach ($Allusers as $user)
                                                            <option value="{{ $user->id }}" @if($data1->Other1_person == $user->id) selected @endif>{{ $user->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Other's 1 Department -->
                                            <div class="col-lg-12 other1_reviews">
                                                <div class="group-input">
                                                    <label for="Customer notification">Other's 1 Department</label>
                                                    <select name="Other1_Department_person" id="Other1_Department_person" @if($data->stage == 4) readonly @endif>
                                                        <option value="">-- Select --</option>
                                                        <option @if($data1->Other1_Department_person == 'Production') selected @endif value="Production">Production</option>
                                                        <option @if($data1->Other1_Department_person == 'Warehouse') selected @endif value="Warehouse">Warehouse</option>
                                                        <option @if($data1->Other1_Department_person == 'Quality_Control') selected @endif value="Quality_Control">Quality Control</option>
                                                        <option @if($data1->Other1_Department_person == 'Quality_Assurance_Review') selected @endif value="Quality_Assurance_Review">Quality Assurance</option>
                                                        <option @if($data1->Other1_Department_person == 'Engineering') selected @endif value="Engineering">Engineering</option>
                                                        <option @if($data1->Other1_Department_person == 'Analytical_Development_Laboratory') selected @endif value="Analytical_Development_Laboratory">Analytical Development Laboratory</option>
                                                        <option @if($data1->Other1_Department_person == 'Process_Development_Lab') selected @endif value="Process_Development_Lab">Process Development Lab</option>
                                                        <option @if($data1->Other1_Department_person == 'Technology transfer/Design') selected @endif value="Technology transfer/Design">Technology Transfer/Design</option>
                                                        <option @if($data1->Other1_Department_person == 'Environment, Health & Safety') selected @endif value="Environment, Health & Safety">Environment, Health & Safety</option>
                                                        <option @if($data1->Other1_Department_person == 'Human Resource & Administration') selected @endif value="Human Resource & Administration">Human Resource & Administration</option>
                                                        <option @if($data1->Other1_Department_person == 'Information Technology') selected @endif value="Information Technology">Information Technology</option>
                                                        <option @if($data1->Other1_Department_person == 'Project management') selected @endif value="Project management">Project management</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Other's 1 Comment -->
                                            <div class="col-md-12 mb-3 other1_reviews">
                                                <div class="group-input">
                                                    <label for="productionfeedback">Impact Assessment (By Other's 1)</label>
                                                    <textarea class="" name="Other1_assessment" id="summernote-41"
                                                        @if($data1->Other1_review == 'yes' && $data->stage == 4) required @endif
                                                        @if($data->stage == 3 || (isset($data1->Other1_person) && Auth::user()->id != $data1->Other1_person)) readonly @endif>{{ $data1->Other1_assessment }}</textarea>
                                                </div>
                                            </div>

                                            <!-- Other's 1 Attachments -->
                                            <div class="col-lg-12 other1_reviews">
                                                <div class="group-input">
                                                    <label for="Audit Attachments">Other's 1 Attachments</label>
                                                    <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                                    <div class="file-attachment-field">
                                                        <div class="file-attachment-list" id="Other1_attachment">
                                                            @if($data1->Other1_attachment)
                                                                @foreach(json_decode($data1->Other1_attachment) as $file)
                                                                    <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                                        <b>{{ $file }}</b>
                                                                        <a href="{{ asset('upload/' . $file) }}" target="_blank">
                                                                            <i class="fa fa-eye text-primary" style="font-size: 20px; margin-right: -10px;"></i>
                                                                        </a>
                                                                        <a type="button" class="remove-file" data-file-name="{{ $file }}">
                                                                            <i class="fa-solid fa-circle-xmark" style="color: red; font-size: 20px;"></i>
                                                                        </a>
                                                                    </h6>
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                        <div class="add-btn">
                                                            <div>Add</div>
                                                            <input type="file" id="myfile" name="Other1_attachment[]" multiple
                                                                @if($data->stage == 0 || $data->stage == 8) readonly @endif 
                                                                oninput="addMultipleFiles(this, 'Other1_attachment')">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Other's 1 Review Completed By -->
                                            <div class="col-md-6 mb-3 other1_reviews">
                                                <div class="group-input">
                                                    <label for="productionfeedback">Other's 1 Review Completed By</label>
                                                    <input readonly type="text" name="Other1_by" value="{{ $data1->Other1_by }}">
                                                </div>
                                            </div>

                                            <!-- Other's 1 Review Completed On -->
                                            <div class="col-lg-6 new-date-data-field other1_reviews">
                                                <div class="group-input input-date">
                                                    <label for="Review Completed On1">Other's 1 Review Completed On</label>
                                                    <div class="calenderauditee">
                                                        <input type="text" id="Other1_on" readonly placeholder="DD-MM-YYYY"
                                                            value="{{ Helpers::getdateFormat($data1->Other1_on) }}" />
                                                        <input readonly type="date" name="Other1_on" class="hide-input"
                                                            oninput="handleDateInput(this, 'Other1_on')" />
                                                    </div>
                                                </div>
                                            </div>

                                            @else

                                            <!-- Other's 1 Review (Disabled) -->
                                            <div class="col-lg-6">
                                                <div class="group-input">
                                                    <label for="Customer notification">Other's 1 Review Required?</label>
                                                    <select name="Other1_review" id="Other1_review" readonly>
                                                        <option value="">-- Select --</option>
                                                        <option @if($data1->Other1_review == 'yes') selected @endif value="yes">Yes</option>
                                                        <option @if($data1->Other1_review == 'no') selected @endif value="no">No</option>
                                                        <option @if($data1->Other1_review == 'na') selected @endif value="na">NA</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Other's 1 Person (Disabled) -->
                                            <div class="col-lg-6 other1_reviews">
                                                <div class="group-input">
                                                    <label for="Customer notification">Other's 1 Person</label>
                                                    <select name="Other1_person" id="Other1_person" readonly>
                                                        <option value="">-- Select --</option>
                                                        @foreach ($Allusers as $user)
                                                            <option value="{{ $user->id }}" @if($data1->Other1_person == $user->id) selected @endif>{{ $user->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Other's 1 Department (Disabled) -->
                                            <div class="col-lg-12 other1_reviews">
                                                <div class="group-input">
                                                    <label for="Customer notification">Other's 1 Department</label>
                                                    <select name="Other1_Department_person" id="Other1_Department_person" readonly>
                                                        <option value="">-- Select --</option>
                                                        <option @if($data1->Other1_Department_person == 'Production') selected @endif value="Production">Production</option>
                                                        <option @if($data1->Other1_Department_person == 'Warehouse') selected @endif value="Warehouse">Warehouse</option>
                                                        <option @if($data1->Other1_Department_person == 'Quality_Control') selected @endif value="Quality_Control">Quality Control</option>
                                                        <option @if($data1->Other1_Department_person == 'Quality_Assurance_Review') selected @endif value="Quality_Assurance_Review">Quality Assurance</option>
                                                        <option @if($data1->Other1_Department_person == 'Engineering') selected @endif value="Engineering">Engineering</option>
                                                        <option @if($data1->Other1_Department_person == 'Analytical_Development_Laboratory') selected @endif value="Analytical_Development_Laboratory">Analytical Development Laboratory</option>
                                                        <option @if($data1->Other1_Department_person == 'Process_Development_Lab') selected @endif value="Process_Development_Lab">Process Development Lab</option>
                                                        <option @if($data1->Other1_Department_person == 'Technology transfer/Design') selected @endif value="Technology transfer/Design">Technology Transfer/Design</option>
                                                        <option @if($data1->Other1_Department_person == 'Environment, Health & Safety') selected @endif value="Environment, Health & Safety">Environment, Health & Safety</option>
                                                        <option @if($data1->Other1_Department_person == 'Human Resource & Administration') selected @endif value="Human Resource & Administration">Human Resource & Administration</option>
                                                        <option @if($data1->Other1_Department_person == 'Information Technology') selected @endif value="Information Technology">Information Technology</option>
                                                        <option @if($data1->Other1_Department_person == 'Project management') selected @endif value="Project management">Project management</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Other's 1 Comment (Disabled) -->
                                            <div class="col-md-12 mb-3 other1_reviews">
                                                <div class="group-input">
                                                    <label for="productionfeedback">Impact Assessment (By Other's 1)</label>
                                                    <textarea class="" name="Other1_assessment" id="summernote-41" readonly>{{ $data1->Other1_assessment }}</textarea>
                                                </div>
                                            </div>

                                            <!-- Other's 1 Attachments (Disabled) -->
                                            <div class="col-lg-12 other1_reviews">
                                                <div class="group-input">
                                                    <label for="Audit Attachments">Other's 1 Attachments</label>
                                                    <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                                    <div class="file-attachment-list" id="Other1_attachment">
                                                        @if($data1->Other1_attachment)
                                                            @foreach(json_decode($data1->Other1_attachment) as $file)
                                                                <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                                    <b>{{ $file }}</b>
                                                                    <a href="{{ asset('upload/' . $file) }}" target="_blank">
                                                                        <i class="fa fa-eye text-primary" style="font-size: 20px; margin-right: -10px;"></i>
                                                                    </a>
                                                                    <a type="button" class="remove-file" data-file-name="{{ $file }}">
                                                                        <i class="fa-solid fa-circle-xmark" style="color: red; font-size: 20px;"></i>
                                                                    </a>
                                                                </h6>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Other's 1 Review Completed By (Disabled) -->
                                            <div class="col-md-6 mb-3 other1_reviews">
                                                <div class="group-input">
                                                    <label for="productionfeedback">Other's 1 Review Completed By</label>
                                                    <input readonly type="text" name="Other1_by" value="{{ $data1->Other1_by }}" readonly>
                                                </div>
                                            </div>

                                            <!-- Other's 1 Review Completed On (Disabled) -->
                                            <div class="col-lg-6 new-date-data-field other1_reviews">
                                                <div class="group-input input-date">
                                                    <label for="Review Completed On1">Other's 1 Review Completed On</label>
                                                    <div class="calenderauditee">
                                                        <input type="text" id="Other1_on" readonly placeholder="DD-MM-YYYY"
                                                            value="{{ Helpers::getdateFormat($data1->Other1_on) }}" />
                                                        <input readonly type="date" name="Other1_on" class="hide-input" readonly />
                                                    </div>
                                                </div>
                                            </div>
                                            @endif


                                            <!-- Others 2 Department -->
                                            @php
                                                $data1 = DB::table('global_change_controls_cfts')
                                                    ->where('cc_id', $data->id)
                                                    ->first();
                                            @endphp
                                            <div class="sub-head">
                                                Other's 2 ( Additional Person Review From Departments If Required)
                                            </div>
                                            <script>
                                                $(document).ready(function() {
                                                    @if($data1->Other2_review !== 'yes')
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
                                                    @endif
                                                });
                                            </script>
                                            @php
                                                $data1 = DB::table('global_change_controls_cfts')
                                                    ->where('cc_id', $data->id)
                                                    ->first();
                                            @endphp

                                            @if($data->stage == 3 || $data->stage == 4)

                                            <!-- Other's 2 Review -->
                                            <div class="col-lg-6">
                                                <div class="group-input">
                                                    <label for="Customer notification">Other's 2 Review Required ?</label>
                                                    <select name="Other2_review" id="Other2_review" @if($data->stage == 4) readonly @endif>
                                                        <option value="">-- Select --</option>
                                                        <option @if($data1->Other2_review == 'yes') selected @endif value="yes">Yes</option>
                                                        <option @if($data1->Other2_review == 'no') selected @endif value="no">No</option>
                                                        <option @if($data1->Other2_review == 'na') selected @endif value="na">NA</option>
                                                    </select>
                                                </div>
                                            </div>

                                            @php
                                                $userRoles = DB::table('user_roles')
                                                    ->where([
                                                        'q_m_s_roles_id' => 35,
                                                        'q_m_s_divisions_id' => $data->division_id,
                                                    ])->get();
                                                $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                                $users = DB::table('users')->whereIn('id', $userRoleIds)->get();
                                            @endphp

                                            <!-- Other's 2 Person -->
                                            <div class="col-lg-6 Other2_reviews">
                                                <div class="group-input">
                                                    <label for="Customer notification">Other's 2 Person</label>
                                                    <select name="Other2_person" id="Other2_person" @if($data->stage == 4) readonly @endif>
                                                        <option value="">-- Select --</option>
                                                        @foreach ($Allusers as $user)
                                                            <option value="{{ $user->id }}" @if($data1->Other2_person == $user->id) selected @endif>{{ $user->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Other's 2 Department -->
                                            <div class="col-lg-12 Other2_reviews">
                                                <div class="group-input">
                                                    <label for="Customer notification">Other's 2 Department</label>
                                                    <select name="Other2_Department_person" id="Other2_Department_person" @if($data->stage == 4) readonly @endif>
                                                        <option value="">-- Select --</option>
                                                        <option @if($data1->Other2_Department_person == 'Production') selected @endif value="Production">Production</option>
                                                        <option @if($data1->Other2_Department_person == 'Warehouse') selected @endif value="Warehouse">Warehouse</option>
                                                        <option @if($data1->Other2_Department_person == 'Quality_Control') selected @endif value="Quality_Control">Quality Control</option>
                                                        <option @if($data1->Other2_Department_person == 'Quality_Assurance') selected @endif value="Quality_Assurance">Quality Assurance</option>
                                                        <option @if($data1->Other2_Department_person == 'Engineering') selected @endif value="Engineering">Engineering</option>
                                                        <option @if($data1->Other2_Department_person == 'Analytical_Development_Laboratory') selected @endif value="Analytical_Development_Laboratory">Analytical Development Laboratory</option>
                                                        <option @if($data1->Other2_Department_person == 'Process_Development_Lab') selected @endif value="Process_Development_Lab">Process Development Laboratory / Kilo Lab</option>
                                                        <option @if($data1->Other2_Department_person == 'Technology transfer/Design') selected @endif value="Technology transfer/Design">Technology Transfer/Design</option>
                                                        <option @if($data1->Other2_Department_person == 'Environment, Health & Safety') selected @endif value="Environment, Health & Safety">Environment, Health & Safety</option>
                                                        <option @if($data1->Other2_Department_person == 'Human Resource & Administration') selected @endif value="Human Resource & Administration">Human Resource & Administration</option>
                                                        <option @if($data1->Other2_Department_person == 'Information Technology') selected @endif value="Information Technology">Information Technology</option>
                                                        <option @if($data1->Other2_Department_person == 'Project management') selected @endif value="Project management">Project management</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Other's 2 Comment -->
                                            <div class="col-md-12 mb-3 Other2_reviews">
                                                <div class="group-input">
                                                    <label for="Impact Assessment13">Impact Assessment (By Other's 2)</label>
                                                    <textarea class="" name="Other2_Assessment" id="summernote-43"
                                                        @if($data1->Other2_review == 'yes' && $data->stage == 4) required @endif
                                                        @if($data->stage == 3 || (isset($data1->Other2_person) && Auth::user()->id != $data1->Other2_person)) readonly @endif>{{ $data1->Other2_Assessment }}</textarea>
                                                </div>
                                            </div>

                                            <!-- Other's 2 Attachments -->
                                            <div class="col-lg-12 Other2_reviews">
                                                <div class="group-input">
                                                    <label for="Audit Attachments">Other's 2 Attachments</label>
                                                    <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                                    <div class="file-attachment-field">
                                                        <div class="file-attachment-list" id="Other2_attachment">
                                                            @if($data1->Other2_attachment)
                                                                @foreach(json_decode($data1->Other2_attachment) as $file)
                                                                    <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                                        <b>{{ $file }}</b>
                                                                        <a href="{{ asset('upload/' . $file) }}" target="_blank">
                                                                            <i class="fa fa-eye text-primary" style="font-size: 20px; margin-right: -10px;"></i>
                                                                        </a>
                                                                        <a type="button" class="remove-file" data-file-name="{{ $file }}">
                                                                            <i class="fa-solid fa-circle-xmark" style="color: red; font-size: 20px;"></i>
                                                                        </a>
                                                                    </h6>
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                        <div class="add-btn">
                                                            <div>Add</div>
                                                            <input type="file" id="myfile" name="Other2_attachment[]" multiple
                                                                @if($data->stage == 0 || $data->stage == 8) readonly @endif 
                                                                oninput="addMultipleFiles(this, 'Other2_attachment')">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Other's 2 Review Completed By -->
                                            <div class="col-md-6 mb-3 Other2_reviews">
                                                <div class="group-input">
                                                    <label for="Review Completed By2">Other's 2 Review Completed By</label>
                                                    <input readonly type="text" name="Other2_by" value="{{ $data1->Other2_by }}">
                                                </div>
                                            </div>

                                            <!-- Other's 2 Review Completed On -->
                                            <div class="col-lg-6 new-date-data-field Other2_reviews">
                                                <div class="group-input input-date">
                                                    <label for="Review Completed On2">Other's 2 Review Completed On</label>
                                                    <div class="calenderauditee">
                                                        <input type="text" id="Other2_on" readonly placeholder="DD-MM-YYYY"
                                                            value="{{ Helpers::getdateFormat($data1->Other2_on) }}" />
                                                        <input readonly type="date" name="Other2_on" class="hide-input"
                                                            oninput="handleDateInput(this, 'Other2_on')" />
                                                    </div>
                                                </div>
                                            </div>

                                            @else

                                            <!-- Other's 2 Review (Disabled) -->
                                            <div class="col-lg-6">
                                                <div class="group-input">
                                                    <label for="Customer notification">Other's 2 Review Required?</label>
                                                    <select name="Other2_review" id="Other2_review" readonly>
                                                        <option value="">-- Select --</option>
                                                        <option @if($data1->Other2_review == 'yes') selected @endif value="yes">Yes</option>
                                                        <option @if($data1->Other2_review == 'no') selected @endif value="no">No</option>
                                                        <option @if($data1->Other2_review == 'na') selected @endif value="na">NA</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Other's 2 Person (Disabled) -->
                                            <div class="col-lg-6 Other2_reviews">
                                                <div class="group-input">
                                                    <label for="Customer notification">Other's 2 Person</label>
                                                    <select name="Other2_person" id="Other2_person" readonly>
                                                        <option value="">-- Select --</option>
                                                        @foreach ($Allusers as $user)
                                                            <option value="{{ $user->id }}" @if($data1->Other2_person == $user->id) selected @endif>{{ $user->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Other's 2 Department (Disabled) -->
                                            <div class="col-lg-12 Other2_reviews">
                                                <div class="group-input">
                                                    <label for="Customer notification">Other's 2 Department</label>
                                                    <select name="Other2_Department_person" id="Other2_Department_person" readonly>
                                                        <option value="">-- Select --</option>
                                                        <option @if($data1->Other2_Department_person == 'Production') selected @endif value="Production">Production</option>
                                                        <option @if($data1->Other2_Department_person == 'Warehouse') selected @endif value="Warehouse">Warehouse</option>
                                                        <option @if($data1->Other2_Department_person == 'Quality_Control') selected @endif value="Quality_Control">Quality Control</option>
                                                        <option @if($data1->Other2_Department_person == 'Quality_Assurance') selected @endif value="Quality_Assurance">Quality Assurance</option>
                                                        <option @if($data1->Other2_Department_person == 'Engineering') selected @endif value="Engineering">Engineering</option>
                                                        <option @if($data1->Other2_Department_person == 'Analytical_Development_Laboratory') selected @endif value="Analytical_Development_Laboratory">Analytical Development Laboratory</option>
                                                        <option @if($data1->Other2_Department_person == 'Process_Development_Lab') selected @endif value="Process_Development_Lab">Process Development Laboratory / Kilo Lab</option>
                                                        <option @if($data1->Other2_Department_person == 'Technology transfer/Design') selected @endif value="Technology transfer/Design">Technology Transfer/Design</option>
                                                        <option @if($data1->Other2_Department_person == 'Environment, Health & Safety') selected @endif value="Environment, Health & Safety">Environment, Health & Safety</option>
                                                        <option @if($data1->Other2_Department_person == 'Human Resource & Administration') selected @endif value="Human Resource & Administration">Human Resource & Administration</option>
                                                        <option @if($data1->Other2_Department_person == 'Information Technology') selected @endif value="Information Technology">Information Technology</option>
                                                        <option @if($data1->Other2_Department_person == 'Project management') selected @endif value="Project management">Project management</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Other's 2 Comment (Disabled) -->
                                            <div class="col-md-12 mb-3 Other2_reviews">
                                                <div class="group-input">
                                                    <label for="Impact Assessment13">Impact Assessment (By Other's 2)</label>
                                                    <textarea class="" name="Other2_Assessment" id="summernote-43" readonly>{{ $data1->Other2_Assessment }}</textarea>
                                                </div>
                                            </div>

                                            <!-- Other's 2 Attachments (Disabled) -->
                                            <div class="col-lg-12 Other2_reviews">
                                                <div class="group-input">
                                                    <label for="Audit Attachments">Other's 2 Attachments</label>
                                                    <div class="file-attachment-list" id="Other2_attachment">
                                                        @if($data1->Other2_attachment)
                                                            @foreach(json_decode($data1->Other2_attachment) as $file)
                                                                <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                                    <b>{{ $file }}</b>
                                                                    <a href="{{ asset('upload/' . $file) }}" target="_blank">
                                                                        <i class="fa fa-eye text-primary" style="font-size: 20px; margin-right: -10px;"></i>
                                                                    </a>
                                                                    <a type="button" class="remove-file" data-file-name="{{ $file }}">
                                                                        <i class="fa-solid fa-circle-xmark" style="color: red; font-size: 20px;"></i>
                                                                    </a>
                                                                </h6>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Other's 2 Review Completed By (Disabled) -->
                                            <div class="col-md-6 mb-3 Other2_reviews">
                                                <div class="group-input">
                                                    <label for="Review Completed By2">Other's 2 Review Completed By</label>
                                                    <input readonly type="text" name="Other2_by" value="{{ $data1->Other2_by }}" readonly>
                                                </div>
                                            </div>

                                            <!-- Other's 2 Review Completed On (Disabled) -->
                                            <div class="col-lg-6 new-date-data-field Other2_reviews">
                                                <div class="group-input input-date">
                                                    <label for="Review Completed On2">Other's 2 Review Completed On</label>
                                                    <div class="calenderauditee">
                                                        <input type="text" id="Other2_on" readonly placeholder="DD-MM-YYYY"
                                                            value="{{ Helpers::getdateFormat($data1->Other2_on) }}" />
                                                        <input readonly type="date" name="Other2_on" class="hide-input" readonly />
                                                    </div>
                                                </div>
                                            </div>
                                            @endif



                                            <!-- Others 2 Department -->
                                            @php
                                                $data1 = DB::table('global_change_controls_cfts')
                                                    ->where('cc_id', $data->id)
                                                    ->first();
                                            @endphp
                                            <div class="sub-head">
                                                Other's 3 ( Additional Person Review From Departments If Required)
                                            </div>
                                            <script>
                                                $(document).ready(function() {
                                                    @if($data1->Other3_review !== 'yes')
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
                                                    @endif
                                                });
                                            </script>
                                            @php
                                                $data1 = DB::table('global_change_controls_cfts')
                                                    ->where('cc_id', $data->id)
                                                    ->first();
                                            @endphp

                                            @if ($data->stage == 3 || $data->stage == 4)

                                                <!-- Other's 3 Review -->
                                                <div class="col-lg-6">
                                                    <div class="group-input">
                                                        <label for="Customer notification">Other's 3 Review Required ?</label>
                                                        <select name="Other3_review" id="Other3_review" @if ($data->stage == 4) readonly @endif>
                                                            <option value="">-- Select --</option>
                                                            <option @if ($data1->Other3_review == 'yes') selected @endif value="yes">Yes</option>
                                                            <option @if ($data1->Other3_review == 'no') selected @endif value="no">No</option>
                                                            <option @if ($data1->Other3_review == 'na') selected @endif value="na">NA</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                @php
                                                    $userRoles = DB::table('user_roles')
                                                        ->where([
                                                            'q_m_s_roles_id' => 36,
                                                            'q_m_s_divisions_id' => $data->division_id,
                                                        ])
                                                        ->get();
                                                    $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                                    $users = DB::table('users')->whereIn('id', $userRoleIds)->get();
                                                @endphp

                                                <!-- Other's 3 Person -->
                                                <div class="col-lg-6 Other3_reviews">
                                                    <div class="group-input">
                                                        <label for="Customer notification">Other's 3 Person</label>
                                                        <select name="Other3_person" id="Other3_person" @if ($data->stage == 4) readonly @endif>
                                                            <option value="">-- Select --</option>
                                                            @foreach ($Allusers as $user)
                                                                <option value="{{ $user->id }}" @if ($data1->Other3_person == $user->id) selected @endif>
                                                                    {{ $user->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Other's 3 Department -->
                                                <div class="col-lg-12 Other3_reviews">
                                                    <div class="group-input">
                                                        <label for="Customer notification">Other's 3 Department</label>
                                                        <select name="Other3_Department_person" id="Other3_Department_person"
                                                            @if ($data->stage == 4) readonly @endif>
                                                            <option value="">-- Select --</option>
                                                            <option @if ($data1->Other3_Department_person == 'Production') selected @endif value="Production">Production</option>
                                                            <option @if ($data1->Other3_Department_person == 'Warehouse') selected @endif value="Warehouse">Warehouse</option>
                                                            <option @if ($data1->Other3_Department_person == 'Quality_Control') selected @endif value="Quality_Control">Quality Control
                                                            </option>
                                                            <option @if ($data1->Other3_Department_person == 'Quality_Assurance') selected @endif value="Quality_Assurance">Quality Assurance
                                                            </option>
                                                            <option @if ($data1->Other3_Department_person == 'Engineering') selected @endif value="Engineering">Engineering</option>
                                                            <option @if ($data1->Other3_Department_person == 'Analytical_Development_Laboratory') selected @endif value="Analytical_Development_Laboratory">
                                                                Analytical Development Laboratory</option>
                                                            <option @if ($data1->Other3_Department_person == 'Process_Development_Lab') selected @endif value="Process_Development_Lab">Process
                                                                Development Laboratory / Kilo Lab</option>
                                                            <option @if ($data1->Other3_Department_person == 'Technology transfer/Design') selected @endif value="Technology transfer/Design">
                                                                Technology Transfer/Design</option>
                                                            <option @if ($data1->Other3_Department_person == 'Environment, Health & Safety') selected @endif value="Environment, Health & Safety">
                                                                Environment, Health & Safety</option>
                                                            <option @if ($data1->Other3_Department_person == 'Human Resource & Administration') selected @endif value="Human Resource & Administration">
                                                                Human Resource & Administration</option>
                                                            <option @if ($data1->Other3_Department_person == 'Information Technology') selected @endif value="Information Technology">Information
                                                                Technology</option>
                                                            <option @if ($data1->Other3_Department_person == 'Project management') selected @endif value="Project management">Project
                                                                management</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Other's 3 Comment -->
                                                <div class="col-md-12 mb-3 Other3_reviews">
                                                    <div class="group-input">
                                                        <label for="Impact Assessment13">Impact Assessment (By Other's 3)</label>
                                                        <textarea class="" name="Other3_Assessment" id="summernote-43" @if ($data1->Other3_review == 'yes' && $data->stage == 4) required @endif
                                                            @if ($data->stage == 3 || (isset($data1->Other3_person) && Auth::user()->id != $data1->Other3_person)) readonly @endif>{{ $data1->Other3_Assessment }}</textarea>
                                                    </div>
                                                </div>

                                                <!-- Other's 3 Attachments -->
                                                <div class="col-lg-12 Other3_reviews">
                                                    <div class="group-input">
                                                        <label for="Audit Attachments">Other's 3 Attachments</label>
                                                        <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                                        <div class="file-attachment-field">
                                                            <div class="file-attachment-list" id="Other3_attachment">
                                                                @if ($data1->Other3_attachment)
                                                                    @foreach (json_decode($data1->Other3_attachment) as $file)
                                                                        <h6 type="button" class="file-container text-dark"
                                                                            style="background-color: rgb(243, 242, 240);">
                                                                            <b>{{ $file }}</b>
                                                                            <a href="{{ asset('upload/' . $file) }}" target="_blank">
                                                                                <i class="fa fa-eye text-primary" style="font-size: 20px; margin-right: -10px;"></i>
                                                                            </a>
                                                                            <a type="button" class="remove-file" data-file-name="{{ $file }}">
                                                                                <i class="fa-solid fa-circle-xmark" style="color: red; font-size: 20px;"></i>
                                                                            </a>
                                                                        </h6>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                            <div class="add-btn">
                                                                <div>Add</div>
                                                                <input type="file" id="myfile" name="Other3_attachment[]" multiple
                                                                    @if ($data->stage == 0 || $data->stage == 8) readonly @endif
                                                                    oninput="addMultipleFiles(this, 'Other3_attachment')">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Other's 3 Review Completed By -->
                                                <div class="col-md-6 mb-3 Other3_reviews">
                                                    <div class="group-input">
                                                        <label for="Review Completed By2">Other's 3 Review Completed By</label>
                                                        <input readonly type="text" name="Other3_by" value="{{ $data1->Other3_by }}">
                                                    </div>
                                                </div>

                                                <!-- Other's 3 Review Completed On -->
                                                <div class="col-lg-6 new-date-data-field Other3_reviews">
                                                    <div class="group-input input-date">
                                                        <label for="Review Completed On2">Other's 3 Review Completed On</label>
                                                        <div class="calenderauditee">
                                                            <input type="text" id="Other3_on" readonly placeholder="DD-MM-YYYY"
                                                                value="{{ Helpers::getdateFormat($data1->Other3_on) }}" />
                                                            <input readonly type="date" name="Other3_on" class="hide-input"
                                                                oninput="handleDateInput(this, 'Other3_on')" />
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <!-- Other's 3 Review (Disabled) -->
                                                <div class="col-lg-6">
                                                    <div class="group-input">
                                                        <label for="Customer notification">Other's 3 Review Required?</label>
                                                        <select name="Other3_review" id="Other3_review" readonly>
                                                            <option value="">-- Select --</option>
                                                            <option @if ($data1->Other3_review == 'yes') selected @endif value="yes">Yes</option>
                                                            <option @if ($data1->Other3_review == 'no') selected @endif value="no">No</option>
                                                            <option @if ($data1->Other3_review == 'na') selected @endif value="na">NA</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Other's 3 Person (Disabled) -->
                                                <div class="col-lg-6 Other3_reviews">
                                                    <div class="group-input">
                                                        <label for="Customer notification">Other's 3 Person</label>
                                                        <select name="Other3_person" id="Other3_person" readonly>
                                                            <option value="">-- Select --</option>
                                                            @foreach ($Allusers as $user)
                                                                <option value="{{ $user->id }}" @if ($data1->Other3_person == $user->id) selected @endif>
                                                                    {{ $user->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Other's 3 Department (Disabled) -->
                                                <div class="col-lg-12 Other3_reviews">
                                                    <div class="group-input">
                                                        <label for="Customer notification">Other's 3 Department</label>
                                                        <select name="Other3_Department_person" id="Other3_Department_person" readonly>
                                                            <option value="">-- Select --</option>
                                                            <option @if ($data1->Other3_Department_person == 'Production') selected @endif value="Production">Production</option>
                                                            <option @if ($data1->Other3_Department_person == 'Warehouse') selected @endif value="Warehouse">Warehouse</option>
                                                            <option @if ($data1->Other3_Department_person == 'Quality_Control') selected @endif value="Quality_Control">Quality Control
                                                            </option>
                                                            <option @if ($data1->Other3_Department_person == 'Quality_Assurance') selected @endif value="Quality_Assurance">Quality Assurance
                                                            </option>
                                                            <option @if ($data1->Other3_Department_person == 'Engineering') selected @endif value="Engineering">Engineering</option>
                                                            <option @if ($data1->Other3_Department_person == 'Analytical_Development_Laboratory') selected @endif value="Analytical_Development_Laboratory">
                                                                Analytical Development Laboratory</option>
                                                            <option @if ($data1->Other3_Department_person == 'Process_Development_Lab') selected @endif value="Process_Development_Lab">Process
                                                                Development Laboratory / Kilo Lab</option>
                                                            <option @if ($data1->Other3_Department_person == 'Technology transfer/Design') selected @endif value="Technology transfer/Design">
                                                                Technology Transfer/Design</option>
                                                            <option @if ($data1->Other3_Department_person == 'Environment, Health & Safety') selected @endif value="Environment, Health & Safety">
                                                                Environment, Health & Safety</option>
                                                            <option @if ($data1->Other3_Department_person == 'Human Resource & Administration') selected @endif value="Human Resource & Administration">
                                                                Human Resource & Administration</option>
                                                            <option @if ($data1->Other3_Department_person == 'Information Technology') selected @endif value="Information Technology">Information
                                                                Technology</option>
                                                            <option @if ($data1->Other3_Department_person == 'Project management') selected @endif value="Project management">Project
                                                                management</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Other's 3 Comment (Disabled) -->
                                                <div class="col-md-12 mb-3 Other3_reviews">
                                                    <div class="group-input">
                                                        <label for="Impact Assessment13">Impact Assessment (By Other's 3)</label>
                                                        <textarea class="" name="Other3_Assessment" id="summernote-43" readonly>{{ $data1->Other3_Assessment }}</textarea>
                                                    </div>
                                                </div>

                                                <!-- Other's 3 Attachments (Disabled) -->
                                                <div class="col-lg-12 Other3_reviews">
                                                    <div class="group-input">
                                                        <label for="Audit Attachments">Other's 3 Attachments</label>
                                                        <div class="file-attachment-list" id="Other3_attachment">
                                                            @if ($data1->Other3_attachment)
                                                                @foreach (json_decode($data1->Other3_attachment) as $file)
                                                                    <h6 type="button" class="file-container text-dark"
                                                                        style="background-color: rgb(243, 242, 240);">
                                                                        <b>{{ $file }}</b>
                                                                        <a href="{{ asset('upload/' . $file) }}" target="_blank">
                                                                            <i class="fa fa-eye text-primary" style="font-size: 20px; margin-right: -10px;"></i>
                                                                        </a>
                                                                        <a type="button" class="remove-file" data-file-name="{{ $file }}">
                                                                            <i class="fa-solid fa-circle-xmark" style="color: red; font-size: 20px;"></i>
                                                                        </a>
                                                                    </h6>
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Other's 3 Review Completed By (Disabled) -->
                                                <div class="col-md-6 mb-3 Other3_reviews">
                                                    <div class="group-input">
                                                        <label for="Review Completed By2">Other's 3 Review Completed By</label>
                                                        <input readonly type="text" name="Other3_by" value="{{ $data1->Other3_by }}" readonly>
                                                    </div>
                                                </div>

                                                <!-- Other's 3 Review Completed On (Disabled) -->
                                                <div class="col-lg-6 new-date-data-field Other3_reviews">
                                                    <div class="group-input input-date">
                                                        <label for="Review Completed On2">Other's 3 Review Completed On</label>
                                                        <div class="calenderauditee">
                                                            <input type="text" id="Other3_on" readonly placeholder="DD-MM-YYYY"
                                                                value="{{ Helpers::getdateFormat($data1->Other3_on) }}" />
                                                            <input readonly type="date" name="Other3_on" class="hide-input" readonly />
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif


                                            
                                            <!-- Others 4 Department -->
                                            @php
                                                $data1 = DB::table('global_change_controls_cfts')
                                                    ->where('cc_id', $data->id)
                                                    ->first();
                                            @endphp
                                            <div class="sub-head">
                                                Other's 4 ( Additional Person Review From Departments If Required)
                                            </div>
                                            <script>
                                                $(document).ready(function() {
                                                    @if($data1->Other4_review !== 'yes')
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
                                                    @endif
                                                });
                                            </script>
                                            @php
                                                $data1 = DB::table('global_change_controls_cfts')
                                                    ->where('cc_id', $data->id)
                                                    ->first();
                                            @endphp

                                            @if ($data->stage == 3 || $data->stage == 4)

                                                <!-- Other's 4 Review -->
                                                <div class="col-lg-6">
                                                    <div class="group-input">
                                                        <label for="Customer notification">Other's 4 Review Required ?</label>
                                                        <select name="Other4_review" id="Other4_review" @if ($data->stage == 4) readonly @endif>
                                                            <option value="">-- Select --</option>
                                                            <option @if ($data1->Other4_review == 'yes') selected @endif value="yes">Yes</option>
                                                            <option @if ($data1->Other4_review == 'no') selected @endif value="no">No</option>
                                                            <option @if ($data1->Other4_review == 'na') selected @endif value="na">NA</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                @php
                                                    $userRoles = DB::table('user_roles')
                                                        ->where([
                                                            'q_m_s_roles_id' => 37,
                                                            'q_m_s_divisions_id' => $data->division_id,
                                                        ])
                                                        ->get();
                                                    $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                                    $users = DB::table('users')->whereIn('id', $userRoleIds)->get();
                                                @endphp

                                                <!-- Other's 4 Person -->
                                                <div class="col-lg-6 Other4_reviews">
                                                    <div class="group-input">
                                                        <label for="Customer notification">Other's 4 Person</label>
                                                        <select name="Other4_person" id="Other4_person" @if ($data->stage == 4) readonly @endif>
                                                            <option value="">-- Select --</option>
                                                            @foreach ($Allusers as $user)
                                                                <option value="{{ $user->id }}" @if ($data1->Other4_person == $user->id) selected @endif>
                                                                    {{ $user->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Other's 4 Department -->
                                                <div class="col-lg-12 Other4_reviews">
                                                    <div class="group-input">
                                                        <label for="Customer notification">Other's 4 Department</label>
                                                        <select name="Other4_Department_person" id="Other4_Department_person"
                                                            @if ($data->stage == 4) readonly @endif>
                                                            <option value="">-- Select --</option>
                                                            <option @if ($data1->Other4_Department_person == 'Production') selected @endif value="Production">Production</option>
                                                            <option @if ($data1->Other4_Department_person == 'Warehouse') selected @endif value="Warehouse">Warehouse</option>
                                                            <option @if ($data1->Other4_Department_person == 'Quality_Control') selected @endif value="Quality_Control">Quality Control
                                                            </option>
                                                            <option @if ($data1->Other4_Department_person == 'Quality_Assurance') selected @endif value="Quality_Assurance">Quality Assurance
                                                            </option>
                                                            <option @if ($data1->Other4_Department_person == 'Engineering') selected @endif value="Engineering">Engineering</option>
                                                            <option @if ($data1->Other4_Department_person == 'Analytical_Development_Laboratory') selected @endif value="Analytical_Development_Laboratory">
                                                                Analytical Development Laboratory</option>
                                                            <option @if ($data1->Other4_Department_person == 'Process_Development_Lab') selected @endif value="Process_Development_Lab">Process
                                                                Development Laboratory / Kilo Lab</option>
                                                            <option @if ($data1->Other4_Department_person == 'Technology transfer/Design') selected @endif value="Technology transfer/Design">
                                                                Technology Transfer/Design</option>
                                                            <option @if ($data1->Other4_Department_person == 'Environment, Health & Safety') selected @endif value="Environment, Health & Safety">
                                                                Environment, Health & Safety</option>
                                                            <option @if ($data1->Other4_Department_person == 'Human Resource & Administration') selected @endif value="Human Resource & Administration">
                                                                Human Resource & Administration</option>
                                                            <option @if ($data1->Other4_Department_person == 'Information Technology') selected @endif value="Information Technology">Information
                                                                Technology</option>
                                                            <option @if ($data1->Other4_Department_person == 'Project management') selected @endif value="Project management">Project
                                                                management</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Other's 4 Comment -->
                                                <div class="col-md-12 mb-3 Other4_reviews">
                                                    <div class="group-input">
                                                        <label for="Impact Assessment13">Impact Assessment (By Other's 4)</label>
                                                        <textarea class="" name="Other4_Assessment" id="summernote-43" @if ($data1->Other4_review == 'yes' && $data->stage == 4) required @endif
                                                            @if ($data->stage == 3 || (isset($data1->Other4_person) && Auth::user()->id != $data1->Other4_person)) readonly @endif>{{ $data1->Other4_Assessment }}</textarea>
                                                    </div>
                                                </div>

                                                <!-- Other's 4 Attachments -->
                                                <div class="col-lg-12 Other4_reviews">
                                                    <div class="group-input">
                                                        <label for="Audit Attachments">Other's 4 Attachments</label>
                                                        <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                                        <div class="file-attachment-field">
                                                            <div class="file-attachment-list" id="Other4_attachment">
                                                                @if ($data1->Other4_attachment)
                                                                    @foreach (json_decode($data1->Other4_attachment) as $file)
                                                                        <h6 type="button" class="file-container text-dark"
                                                                            style="background-color: rgb(243, 242, 240);">
                                                                            <b>{{ $file }}</b>
                                                                            <a href="{{ asset('upload/' . $file) }}" target="_blank">
                                                                                <i class="fa fa-eye text-primary" style="font-size: 20px; margin-right: -10px;"></i>
                                                                            </a>
                                                                            <a type="button" class="remove-file" data-file-name="{{ $file }}">
                                                                                <i class="fa-solid fa-circle-xmark" style="color: red; font-size: 20px;"></i>
                                                                            </a>
                                                                        </h6>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                            <div class="add-btn">
                                                                <div>Add</div>
                                                                <input type="file" id="myfile" name="Other4_attachment[]" multiple
                                                                    @if ($data->stage == 0 || $data->stage == 8) readonly @endif
                                                                    oninput="addMultipleFiles(this, 'Other4_attachment')">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Other's 4 Review Completed By -->
                                                <div class="col-md-6 mb-3 Other4_reviews">
                                                    <div class="group-input">
                                                        <label for="Review Completed By2">Other's 4 Review Completed By</label>
                                                        <input readonly type="text" name="Other4_by" value="{{ $data1->Other4_by }}">
                                                    </div>
                                                </div>

                                                <!-- Other's 4 Review Completed On -->
                                                <div class="col-lg-6 new-date-data-field Other4_reviews">
                                                    <div class="group-input input-date">
                                                        <label for="Review Completed On2">Other's 4 Review Completed On</label>
                                                        <div class="calenderauditee">
                                                            <input type="text" id="Other4_on" readonly placeholder="DD-MM-YYYY"
                                                                value="{{ Helpers::getdateFormat($data1->Other4_on) }}" />
                                                            <input readonly type="date" name="Other4_on" class="hide-input"
                                                                oninput="handleDateInput(this, 'Other4_on')" />
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <!-- Other's 4 Review (Disabled) -->
                                                <div class="col-lg-6">
                                                    <div class="group-input">
                                                        <label for="Customer notification">Other's 4 Review Required?</label>
                                                        <select name="Other4_review" id="Other4_review" readonly>
                                                            <option value="">-- Select --</option>
                                                            <option @if ($data1->Other4_review == 'yes') selected @endif value="yes">Yes</option>
                                                            <option @if ($data1->Other4_review == 'no') selected @endif value="no">No</option>
                                                            <option @if ($data1->Other4_review == 'na') selected @endif value="na">NA</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Other's 4 Person (Disabled) -->
                                                <div class="col-lg-6 Other4_reviews">
                                                    <div class="group-input">
                                                        <label for="Customer notification">Other's 4 Person</label>
                                                        <select name="Other4_person" id="Other4_person" readonly>
                                                            <option value="">-- Select --</option>
                                                            @foreach ($Allusers as $user)
                                                                <option value="{{ $user->id }}" @if ($data1->Other4_person == $user->id) selected @endif>
                                                                    {{ $user->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Other's 4 Department (Disabled) -->
                                                <div class="col-lg-12 Other4_reviews">
                                                    <div class="group-input">
                                                        <label for="Customer notification">Other's 4 Department</label>
                                                        <select name="Other4_Department_person" id="Other4_Department_person" readonly>
                                                            <option value="">-- Select --</option>
                                                            <option @if ($data1->Other4_Department_person == 'Production') selected @endif value="Production">Production</option>
                                                            <option @if ($data1->Other4_Department_person == 'Warehouse') selected @endif value="Warehouse">Warehouse</option>
                                                            <option @if ($data1->Other4_Department_person == 'Quality_Control') selected @endif value="Quality_Control">Quality Control
                                                            </option>
                                                            <option @if ($data1->Other4_Department_person == 'Quality_Assurance') selected @endif value="Quality_Assurance">Quality Assurance
                                                            </option>
                                                            <option @if ($data1->Other4_Department_person == 'Engineering') selected @endif value="Engineering">Engineering</option>
                                                            <option @if ($data1->Other4_Department_person == 'Analytical_Development_Laboratory') selected @endif value="Analytical_Development_Laboratory">
                                                                Analytical Development Laboratory</option>
                                                            <option @if ($data1->Other4_Department_person == 'Process_Development_Lab') selected @endif value="Process_Development_Lab">Process
                                                                Development Laboratory / Kilo Lab</option>
                                                            <option @if ($data1->Other4_Department_person == 'Technology transfer/Design') selected @endif value="Technology transfer/Design">
                                                                Technology Transfer/Design</option>
                                                            <option @if ($data1->Other4_Department_person == 'Environment, Health & Safety') selected @endif value="Environment, Health & Safety">
                                                                Environment, Health & Safety</option>
                                                            <option @if ($data1->Other4_Department_person == 'Human Resource & Administration') selected @endif value="Human Resource & Administration">
                                                                Human Resource & Administration</option>
                                                            <option @if ($data1->Other4_Department_person == 'Information Technology') selected @endif value="Information Technology">Information
                                                                Technology</option>
                                                            <option @if ($data1->Other4_Department_person == 'Project management') selected @endif value="Project management">Project
                                                                management</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Other's 4 Comment (Disabled) -->
                                                <div class="col-md-12 mb-3 Other4_reviews">
                                                    <div class="group-input">
                                                        <label for="Impact Assessment13">Impact Assessment (By Other's 4)</label>
                                                        <textarea class="" name="Other4_Assessment" id="summernote-43" readonly>{{ $data1->Other4_Assessment }}</textarea>
                                                    </div>
                                                </div>

                                                <!-- Other's 4 Attachments (Disabled) -->
                                                <div class="col-lg-12 Other4_reviews">
                                                    <div class="group-input">
                                                        <label for="Audit Attachments">Other's 4 Attachments</label>
                                                        <div class="file-attachment-list" id="Other4_attachment">
                                                            @if ($data1->Other4_attachment)
                                                                @foreach (json_decode($data1->Other4_attachment) as $file)
                                                                    <h6 type="button" class="file-container text-dark"
                                                                        style="background-color: rgb(243, 242, 240);">
                                                                        <b>{{ $file }}</b>
                                                                        <a href="{{ asset('upload/' . $file) }}" target="_blank">
                                                                            <i class="fa fa-eye text-primary" style="font-size: 20px; margin-right: -10px;"></i>
                                                                        </a>
                                                                        <a type="button" class="remove-file" data-file-name="{{ $file }}">
                                                                            <i class="fa-solid fa-circle-xmark" style="color: red; font-size: 20px;"></i>
                                                                        </a>
                                                                    </h6>
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Other's 4 Review Completed By (Disabled) -->
                                                <div class="col-md-6 mb-3 Other4_reviews">
                                                    <div class="group-input">
                                                        <label for="Review Completed By2">Other's 4 Review Completed By</label>
                                                        <input readonly type="text" name="Other4_by" value="{{ $data1->Other4_by }}" readonly>
                                                    </div>
                                                </div>

                                                <!-- Other's 4 Review Completed On (Disabled) -->
                                                <div class="col-lg-6 new-date-data-field Other4_reviews">
                                                    <div class="group-input input-date">
                                                        <label for="Review Completed On2">Other's 4 Review Completed On</label>
                                                        <div class="calenderauditee">
                                                            <input type="text" id="Other4_on" readonly placeholder="DD-MM-YYYY"
                                                                value="{{ Helpers::getdateFormat($data1->Other4_on) }}" />
                                                            <input readonly type="date" name="Other4_on" class="hide-input" readonly />
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                            <!-- Others 2 Department -->
                                            @php
                                                $data1 = DB::table('global_change_controls_cfts')
                                                    ->where('cc_id', $data->id)
                                                    ->first();
                                            @endphp
                                            <div class="sub-head">
                                                Other's 5 ( Additional Person Review From Departments If Required)
                                            </div>
                                            <script>
                                                $(document).ready(function() {
                                                    @if($data1->Other5_review !== 'yes')
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
                                                    @endif
                                                });
                                            </script>
                                            @php
                                                $data1 = DB::table('global_change_controls_cfts')
                                                    ->where('cc_id', $data->id)
                                                    ->first();
                                            @endphp

                                            @if ($data->stage == 3 || $data->stage == 4)

                                                <!-- Other's 5 Review -->
                                                <div class="col-lg-6">
                                                    <div class="group-input">
                                                        <label for="Customer notification">Other's 5 Review Required ?</label>
                                                        <select name="Other5_review" id="Other5_review" @if ($data->stage == 4) readonly @endif>
                                                            <option value="">-- Select --</option>
                                                            <option @if ($data1->Other5_review == 'yes') selected @endif value="yes">Yes</option>
                                                            <option @if ($data1->Other5_review == 'no') selected @endif value="no">No</option>
                                                            <option @if ($data1->Other5_review == 'na') selected @endif value="na">NA</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                @php
                                                    $userRoles = DB::table('user_roles')
                                                        ->where([
                                                            'q_m_s_roles_id' => 37,
                                                            'q_m_s_divisions_id' => $data->division_id,
                                                        ])
                                                        ->get();
                                                    $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                                    $users = DB::table('users')->whereIn('id', $userRoleIds)->get();
                                                @endphp

                                                <!-- Other's 5 Person -->
                                                <div class="col-lg-6 Other5_reviews">
                                                    <div class="group-input">
                                                        <label for="Customer notification">Other's 5 Person</label>
                                                        <select name="Other5_person" id="Other5_person" @if ($data->stage == 4) readonly @endif>
                                                            <option value="">-- Select --</option>
                                                            @foreach ($Allusers as $user)
                                                                <option value="{{ $user->id }}" @if ($data1->Other5_person == $user->id) selected @endif>
                                                                    {{ $user->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Other's 5 Department -->
                                                <div class="col-lg-12 Other5_reviews">
                                                    <div class="group-input">
                                                        <label for="Customer notification">Other's 5 Department</label>
                                                        <select name="Other5_Department_person" id="Other5_Department_person"
                                                            @if ($data->stage == 4) readonly @endif>
                                                            <option value="">-- Select --</option>
                                                            <option @if ($data1->Other5_Department_person == 'Production') selected @endif value="Production">Production</option>
                                                            <option @if ($data1->Other5_Department_person == 'Warehouse') selected @endif value="Warehouse">Warehouse</option>
                                                            <option @if ($data1->Other5_Department_person == 'Quality_Control') selected @endif value="Quality_Control">Quality Control
                                                            </option>
                                                            <option @if ($data1->Other5_Department_person == 'Quality_Assurance') selected @endif value="Quality_Assurance">Quality Assurance
                                                            </option>
                                                            <option @if ($data1->Other5_Department_person == 'Engineering') selected @endif value="Engineering">Engineering</option>
                                                            <option @if ($data1->Other5_Department_person == 'Analytical_Development_Laboratory') selected @endif value="Analytical_Development_Laboratory">
                                                                Analytical Development Laboratory</option>
                                                            <option @if ($data1->Other5_Department_person == 'Process_Development_Lab') selected @endif value="Process_Development_Lab">Process
                                                                Development Laboratory / Kilo Lab</option>
                                                            <option @if ($data1->Other5_Department_person == 'Technology transfer/Design') selected @endif value="Technology transfer/Design">
                                                                Technology Transfer/Design</option>
                                                            <option @if ($data1->Other5_Department_person == 'Environment, Health & Safety') selected @endif value="Environment, Health & Safety">
                                                                Environment, Health & Safety</option>
                                                            <option @if ($data1->Other5_Department_person == 'Human Resource & Administration') selected @endif value="Human Resource & Administration">
                                                                Human Resource & Administration</option>
                                                            <option @if ($data1->Other5_Department_person == 'Information Technology') selected @endif value="Information Technology">Information
                                                                Technology</option>
                                                            <option @if ($data1->Other5_Department_person == 'Project management') selected @endif value="Project management">Project
                                                                management</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Other's 5 Comment -->
                                                <div class="col-md-12 mb-3 Other5_reviews">
                                                    <div class="group-input">
                                                        <label for="Impact Assessment13">Impact Assessment (By Other's 5)</label>
                                                        <textarea class="" name="Other5_Assessment" id="summernote-43" @if ($data1->Other5_review == 'yes' && $data->stage == 4) required @endif
                                                            @if ($data->stage == 3 || (isset($data1->Other5_person) && Auth::user()->id != $data1->Other5_person)) readonly @endif>{{ $data1->Other5_Assessment }}</textarea>
                                                    </div>
                                                </div>

                                                <!-- Other's 5 Attachments -->
                                                <div class="col-lg-12 Other5_reviews">
                                                    <div class="group-input">
                                                        <label for="Audit Attachments">Other's 5 Attachments</label>
                                                        <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                                        <div class="file-attachment-field">
                                                            <div class="file-attachment-list" id="Other5_attachment">
                                                                @if ($data1->Other5_attachment)
                                                                    @foreach (json_decode($data1->Other5_attachment) as $file)
                                                                        <h6 type="button" class="file-container text-dark"
                                                                            style="background-color: rgb(243, 242, 240);">
                                                                            <b>{{ $file }}</b>
                                                                            <a href="{{ asset('upload/' . $file) }}" target="_blank">
                                                                                <i class="fa fa-eye text-primary" style="font-size: 20px; margin-right: -10px;"></i>
                                                                            </a>
                                                                            <a type="button" class="remove-file" data-file-name="{{ $file }}">
                                                                                <i class="fa-solid fa-circle-xmark" style="color: red; font-size: 20px;"></i>
                                                                            </a>
                                                                        </h6>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                            <div class="add-btn">
                                                                <div>Add</div>
                                                                <input type="file" id="myfile" name="Other5_attachment[]" multiple
                                                                    @if ($data->stage == 0 || $data->stage == 8) readonly @endif
                                                                    oninput="addMultipleFiles(this, 'Other5_attachment')">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Other's 5 Review Completed By -->
                                                <div class="col-md-6 mb-3 Other5_reviews">
                                                    <div class="group-input">
                                                        <label for="Review Completed By2">Other's 5 Review Completed By</label>
                                                        <input readonly type="text" name="Other5_by" value="{{ $data1->Other5_by }}">
                                                    </div>
                                                </div>

                                                <!-- Other's 5 Review Completed On -->
                                                <div class="col-lg-6 new-date-data-field Other5_reviews">
                                                    <div class="group-input input-date">
                                                        <label for="Review Completed On2">Other's 5 Review Completed On</label>
                                                        <div class="calenderauditee">
                                                            <input type="text" id="Other5_on" readonly placeholder="DD-MM-YYYY"
                                                                value="{{ Helpers::getdateFormat($data1->Other5_on) }}" />
                                                            <input readonly type="date" name="Other5_on" class="hide-input"
                                                                oninput="handleDateInput(this, 'Other5_on')" />
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <!-- Other's 5 Review (Disabled) -->
                                                <div class="col-lg-6">
                                                    <div class="group-input">
                                                        <label for="Customer notification">Other's 5 Review Required?</label>
                                                        <select name="Other5_review" id="Other5_review" readonly>
                                                            <option value="">-- Select --</option>
                                                            <option @if ($data1->Other5_review == 'yes') selected @endif value="yes">Yes</option>
                                                            <option @if ($data1->Other5_review == 'no') selected @endif value="no">No</option>
                                                            <option @if ($data1->Other5_review == 'na') selected @endif value="na">NA</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Other's 5 Person (Disabled) -->
                                                <div class="col-lg-6 Other5_reviews">
                                                    <div class="group-input">
                                                        <label for="Customer notification">Other's 5 Person</label>
                                                        <select name="Other5_person" id="Other5_person" readonly>
                                                            <option value="">-- Select --</option>
                                                            @foreach ($Allusers as $user)
                                                                <option value="{{ $user->id }}" @if ($data1->Other5_person == $user->id) selected @endif>
                                                                    {{ $user->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Other's 5 Department (Disabled) -->
                                                <div class="col-lg-12 Other5_reviews">
                                                    <div class="group-input">
                                                        <label for="Customer notification">Other's 5 Department</label>
                                                        <select name="Other5_Department_person" id="Other5_Department_person" readonly>
                                                            <option value="">-- Select --</option>
                                                            <option @if ($data1->Other5_Department_person == 'Production') selected @endif value="Production">Production</option>
                                                            <option @if ($data1->Other5_Department_person == 'Warehouse') selected @endif value="Warehouse">Warehouse</option>
                                                            <option @if ($data1->Other5_Department_person == 'Quality_Control') selected @endif value="Quality_Control">Quality Control
                                                            </option>
                                                            <option @if ($data1->Other5_Department_person == 'Quality_Assurance') selected @endif value="Quality_Assurance">Quality Assurance
                                                            </option>
                                                            <option @if ($data1->Other5_Department_person == 'Engineering') selected @endif value="Engineering">Engineering</option>
                                                            <option @if ($data1->Other5_Department_person == 'Analytical_Development_Laboratory') selected @endif value="Analytical_Development_Laboratory">
                                                                Analytical Development Laboratory</option>
                                                            <option @if ($data1->Other5_Department_person == 'Process_Development_Lab') selected @endif value="Process_Development_Lab">Process
                                                                Development Laboratory / Kilo Lab</option>
                                                            <option @if ($data1->Other5_Department_person == 'Technology transfer/Design') selected @endif value="Technology transfer/Design">
                                                                Technology Transfer/Design</option>
                                                            <option @if ($data1->Other5_Department_person == 'Environment, Health & Safety') selected @endif value="Environment, Health & Safety">
                                                                Environment, Health & Safety</option>
                                                            <option @if ($data1->Other5_Department_person == 'Human Resource & Administration') selected @endif value="Human Resource & Administration">
                                                                Human Resource & Administration</option>
                                                            <option @if ($data1->Other5_Department_person == 'Information Technology') selected @endif value="Information Technology">Information
                                                                Technology</option>
                                                            <option @if ($data1->Other5_Department_person == 'Project management') selected @endif value="Project management">Project
                                                                management</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Other's 5 Comment (Disabled) -->
                                                <div class="col-md-12 mb-3 Other5_reviews">
                                                    <div class="group-input">
                                                        <label for="Impact Assessment13">Impact Assessment (By Other's 5)</label>
                                                        <textarea class="" name="Other5_Assessment" id="summernote-43" readonly>{{ $data1->Other5_Assessment }}</textarea>
                                                    </div>
                                                </div>

                                                <!-- Other's 5 Attachments (Disabled) -->
                                                <div class="col-lg-12 Other5_reviews">
                                                    <div class="group-input">
                                                        <label for="Audit Attachments">Other's 5 Attachments</label>
                                                        <div class="file-attachment-list" id="Other5_attachment">
                                                            @if ($data1->Other5_attachment)
                                                                @foreach (json_decode($data1->Other5_attachment) as $file)
                                                                    <h6 type="button" class="file-container text-dark"
                                                                        style="background-color: rgb(243, 242, 240);">
                                                                        <b>{{ $file }}</b>
                                                                        <a href="{{ asset('upload/' . $file) }}" target="_blank">
                                                                            <i class="fa fa-eye text-primary" style="font-size: 20px; margin-right: -10px;"></i>
                                                                        </a>
                                                                        <a type="button" class="remove-file" data-file-name="{{ $file }}">
                                                                            <i class="fa-solid fa-circle-xmark" style="color: red; font-size: 20px;"></i>
                                                                        </a>
                                                                    </h6>
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Other's 5 Review Completed By (Disabled) -->
                                                <div class="col-md-6 mb-3 Other5_reviews">
                                                    <div class="group-input">
                                                        <label for="Review Completed By2">Other's 5 Review Completed By</label>
                                                        <input readonly type="text" name="Other5_by" value="{{ $data1->Other5_by }}" readonly>
                                                    </div>
                                                </div>

                                                <!-- Other's 5 Review Completed On (Disabled) -->
                                                <div class="col-lg-6 new-date-data-field Other5_reviews">
                                                    <div class="group-input input-date">
                                                        <label for="Review Completed On2">Other's 5 Review Completed On</label>
                                                        <div class="calenderauditee">
                                                            <input type="text" id="Other5_on" readonly placeholder="DD-MM-YYYY"
                                                                value="{{ Helpers::getdateFormat($data1->Other5_on) }}" />
                                                            <input readonly type="date" name="Other5_on" class="hide-input" readonly />
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif



                                            
                                        </div>
                                        <div class="button-block">
                                            <button type="submit" class="saveButton">Save</button>
                                            <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                            <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                            <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                                                    Exit
                                                </a> </button>
                                        </div>

                                    </div>
                                </div>
                                </div>    
                                
                                <div id="CCForm19" class="inner-block cctabcontent">
                                    <div class="inner-block-content">
                                        <table class="table table-bordered" id="externalReviewTable">
                                            <thead>
                                                <tr>
                                                    <th>Sr. No.</th>
                                                    <th>User Name</th>
                                                    <th>Comment</th>
                                                    <th style="width: 10px;">Attachment</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                
                                            </tbody>

                                        </table>

                                        <div class="button-block">
                                            <button type="submit" class="saveButton">Save</button>
                                            <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                            <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                            <button type="button" style=" justify-content: center; width: 4rem; margin-left: 1px;;">
                                                <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">Exit</a>
                                            </button>
                                        </div>
                                    </div>
                                </div> 

                                <div id="CCForm14" class="inner-block cctabcontent">
                                    <div class="inner-block-content">
                                        <div class="row">
                                            <div class="sub-head">
                                                QA Final Review
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="group-input">
                                                    <label for="RA notification">RA Head Person 
                                                        @if($data->stage==5) <span class="text-danger">*</span>@endif
                                                    </label>
                                                    <select name="RA_data_person" class="RA_data_person" id="RA_head_required" 
                                                            {{ $data->stage == 0 || $data->stage == 13 ? 'readonly' : '' }}>
                                                        <option value="">--Select--</option>
                                                        <option @if ($data->RA_data_person == 'Yes') selected @endif value="Yes">Yes</option>
                                                        <option @if ($data->RA_data_person == 'No') selected @endif value="No">No</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="group-input">
                                                    <label for="RA notification">QA/CQA Head Approval Person
                                                    @if($data->stage==5) <span class="text-danger">*</span>@endif
                                                    <select name="QA_CQA_person" class="QA_CQA_person"
                                                        id="QA_CQA_person" {{ $data->stage == 0 || $data->stage == 13 ? 'readonly' : '' }}>
                                                        <option value="">-- Select --</option>
                                                        @foreach ($users as $user)
                                                            <option value="{{ $user->id }}" @if ($user->id == $data->QA_CQA_person) selected @endif>
                                                                {{ $user->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                        <div class="group-input">
                                            <label for="qa-eval-comments">QA Final Review Comments
                                                @if($data->stage==5) <span class="text-danger">*</span>@endif
                                            </label>
                                            <div class="relative-container">
                                                <textarea  name="qa_final_comments"{{ $data->stage == 0 || $data->stage == 13 ? 'readonly' : '' }} >{{ $data->qa_final_comments }}</textarea>
                                                @component('frontend.forms.language-model', ['readonly' => $data->stage == 0 || $data->stage == 13])
                                                @endcomponent
                                            </div>
                                            
                                        </div>

                                        @if ($data->qa_final_attach)
                                            @foreach (json_decode($data->qa_final_attach) as $file)
                                                <input id="productionInjectionAttachmentFile-{{ $loop->index }}" type="hidden"
                                                    name="existinProductionInjectionFile[{{ $loop->index }}]"
                                                    value="{{ $file }}">
                                            @endforeach
                                        @endif
                                        <div class="group-input">
                                            <label for="qa-eval-attach">QA Final Review Attachments</label>
                                            <div class="file-attachment-field">
                                                <div class="file-attachment-list" id="qa_final_attach">
                                                    @if ($data->qa_final_attach)
                                                        @foreach (json_decode($data->qa_final_attach) as $file)
                                                            <h6 type="button" class="file-container text-dark"
                                                                style="background-color: rgb(243, 242, 240);">
                                                                <b>{{ $file }}</b>
                                                                <a href="{{ asset('upload/' . $file) }}"
                                                                    target="_blank"><i class="fa fa-eye text-primary"
                                                                        style="font-size:20px; margin-right:-10px;"></i></a>
                                                                <a type="button" class="remove-file" data-remove-id="existinProductionLiquidFile-{{ $loop->index }}"
                                                                    data-file-name="{{ $file }}"><i
                                                                        class="fa-solid fa-circle-xmark"
                                                                        style="color:red; font-size:20px;"></i></a>
                                                            </h6>
                                                        @endforeach
                                                    @endif
                                                </div>
                                                <div class="add-btn">
                                                    <div>Add</div>
                                                    <input {{$data->stage == 13 || $data->stage == 0 || $data->stage == 6 ? 'readonly' : '' }}
                                                        type="file" id="myfile" name="qa_final_attach[]" 
                                                        oninput="addMultipleFiles(this, 'qa_final_attach')" multiple {{ $data->stage == 0 || $data->stage == 8 || $data->stage == 13 ? 'readonly' : '' }}>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                        <div class="button-block">
                                            <button type="submit" class="saveButton">Save</button>
                                            <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                            <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                            <button type="button" style=" justify-content: center; width: 4rem; margin-left: 1px;;">
                                                <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">Exit</a>
                                            </button>
                                        </div>
                                    </div>
                                </div> 
                            <!-- </div> -->
                            

                                <div id="CCForm15" class="inner-block cctabcontent">
                                    <div class="inner-block-content">
                                        <div class="sub-head">
                                            RA
                                        </div>
                                        <div class="col-md-12">
                                                    <div class="group-input">
                                                        <label for="RA feedback">RA Comment</label>
                                                    @if($data->stage==6) <span class="text-danger">*</span>@endif
                                                    <div><small class="text-primary">Please insert "NA" in the data field if it
                                                                does not require completion</small></div>
                                                        <textarea  class="tiny" name="ra_tab_comments" id="summernote-18">{{ isset($data1->ra_tab_comments) ? $data1->ra_tab_comments : '' }}</textarea>
                                                    </div>
                                                </div>

                                        <div class="col-12">
                                                <div class="group-input">
                                                    <label for="RA attachment">RA Attachments</label>
                                                    <div><small class="text-primary">Please Attach all relevant or supporting
                                                            documents</small></div>
                                                    <div class="file-attachment-field">
                                                        <div readonly class="file-attachment-list" id="RA_attachment">
                                                            @if ($data->RA_attachment_second)
                                                                @foreach (json_decode($data->RA_attachment_second) as $file)
                                                                    <h6 type="button" class="file-container text-dark"
                                                                        style="background-color: rgb(243, 242, 240);">
                                                                        <b>{{ $file }}</b>
                                                                        <a href="{{ asset('upload/' . $file) }}" target="_blank"><i
                                                                                class="fa fa-eye text-primary"
                                                                                style="font-size:20px; margin-right:-10px;"></i></a>
                                                                        <a type="button" class="remove-file" data-file-name="{{ $file }}"><i
                                                                                class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i></a>
                                                                    </h6>
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                        <div class="add-btn">
                                                            <div>Add</div>
                                                            <input {{ $data->stage == 0 || $data->stage == 13 ? 'readonly' : '' }} type="file"
                                                                id="myfile"
                                                                name="RA_attachment_second[]"{{ $data->stage == 0 || $data->stage == 13 ? 'readonly' : '' }}
                                                                oninput="addMultipleFiles(this, 'RA_attachment')" multiple>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="button-block">
                                            <button type="submit" class="saveButton">Save</button>
                                            <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                            <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                            <button type="button" style=" justify-content: center; width: 4rem; margin-left: 1px;;">
                                                <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">Exit</a>
                                            </button>
                                        </div>
                                    </div>
                                <!-- </div>     -->

                                <div id="CCForm17" class="inner-block cctabcontent">
                                    <div class="inner-block-content">
                                        <div class="sub-head">
                                        QA/CQA Head/Manager Designee Approval
                                        </div>
                                        <div class="group-input">
                                            <label for="qa-eval-comments">QA/CQA Head/Manager Designee Approval Comments</label>
                                            <div class="relative-container">
                                                <textarea  name="qa_cqa_comments"  {{ $data->stage == 0 || $data->stage == 8 || $data->stage == 13 ? 'readonly' : '' }}>{{$data->qa_cqa_comments}}</textarea>
                                                @component('frontend.forms.language-model', ['readonly' => $data->stage == 0 || $data->stage == 13])
                                                @endcomponent
                                            </div>
                                            
                                        </div>

                              
                                        @if ($data->qa_cqa_attach)
                                            @foreach (json_decode($data->qa_cqa_attach) as $file)
                                                <input id="productionInjectionAttachmentFile-{{ $loop->index }}" type="hidden"
                                                    name="existinProductionInjectionFile[{{ $loop->index }}]"
                                                    value="{{ $file }}">
                                            @endforeach
                                        @endif
                                        <div class="group-input">
                                            <label for="qa-eval-attach">QA/CQA Head/Manager Designee Approval Attachments</label>
                                            <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="qa_cqa_attach">
                                            @if (!empty($data->qa_cqa_attach))
                                                @foreach (json_decode($data->qa_cqa_attach) as $file)
                                                    <h6 class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                        <b>{{ $file }}</b>
                                                        <a href="{{ asset('upload/' . $file) }}" target="_blank">
                                                            <i class="fa fa-eye text-primary" style="font-size:20px; margin-right:-10px;"></i>
                                                        </a>
                                                        <a class="remove-file" data-remove-id="hodAttachmentFile-{{ $loop->index }}" data-file-name="{{ $file }}">
                                                            <i class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i>
                                                        </a>
                                                    </h6>
                                                @endforeach
                                            @endif
                                        </div>
                                                <div class="add-btn">
                                                    <div>Add</div>
                                                    <input {{ $data->stage == 0 || $data->stage == 6 ? 'readonly' : '' }}
                                                        type="file" id="myfile" name="qa_cqa_attach[]" 
                                                        oninput="addMultipleFiles(this, 'qa_cqa_attach')" multiple {{ $data->stage == 0 || $data->stage == 8 || $data->stage == 13 ? 'readonly' : '' }}>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="button-block">
                                            <button type="submit" class="saveButton">Save</button>
                                            <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                            <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                            <button type="button" style=" justify-content: center; width: 4rem; margin-left: 1px;;">
                                                <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">Exit</a>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div id="CCForm4" class="inner-block cctabcontent">
                                    <div class="inner-block-content">
                                        <div class="sub-head">
                                            Evaluation Detail
                                        </div>
                                        <div class="group-input">
                                            <label for="qa-eval-comments">QA Evaluation Comments</label>
                                            <div class="relative-container">
                                                <textarea  name="qa_eval_comments" {{ $data->stage == 0 || $data->stage == 8 || $data->stage == 13 ? 'readonly' : '' }}>{{ $data->qa_eval_comments }}</textarea>
                                                @component('frontend.forms.language-model', ['readonly' => $data->stage == 0 || $data->stage == 8 || $data->stage == 13])
                                                @endcomponent
                                            </div>
                                            
                                        </div>

                                        @if ($data->qa_final_attach)
                                            @foreach (json_decode($data->qa_final_attach) as $file)
                                                <input id="productionInjectionAttachmentFile-{{ $loop->index }}" type="hidden"
                                                    name="existinProductionInjectionFile[{{ $loop->index }}]"
                                                    value="{{ $file }}">
                                            @endforeach
                                        @endif
                                        <div class="group-input">
                                            <label for="qa-eval-attach">QA Evaluation Attachments</label>
                                            <div class="file-attachment-field">
                                                <div class="file-attachment-list" id="qa_eval_attach">
                                                    @if ($data->qa_eval_attach)
                                                        @foreach (json_decode($data->qa_eval_attach) as $file)
                                                            <h6 type="button" class="file-container text-dark"
                                                                style="background-color: rgb(243, 242, 240);">
                                                                <b>{{ $file }}</b>
                                                                <a href="{{ asset('upload/' . $file) }}"
                                                                    target="_blank"><i class="fa fa-eye text-primary"
                                                                        style="font-size:20px; margin-right:-10px;"></i></a>
                                                                <a type="button" class="remove-file" data-remove-id="existinProductionLiquidFile-{{ $loop->index }}"
                                                                    data-file-name="{{ $file }}"><i
                                                                        class="fa-solid fa-circle-xmark"
                                                                        style="color:red; font-size:20px;"></i></a>
                                                            </h6>
                                                        @endforeach
                                                    @endif
                                                </div>
                                                <div class="add-btn">
                                                    <div>Add</div>
                                                    <input {{ $data->stage == 0 || $data->stage == 6 ? 'readonly' : '' }}
                                                        type="file" id="myfile" name="qa_eval_attach[]" 
                                                        oninput="addMultipleFiles(this, 'qa_eval_attach')" multiple {{ $data->stage == 0 || $data->stage == 8 || $data->stage == 13 ? 'readonly' : '' }}>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                        <div class="button-block">
                                            <button type="submit" class="saveButton">Save</button>
                                            <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                            <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                            <button type="button" style=" justify-content: center; width: 4rem; margin-left: 1px;;">
                                                <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">Exit</a>
                                            </button>
                                        </div>
                                </div>                                

                                 

                                <div id="CCForm5" class="inner-block cctabcontent">
                                    <div class="inner-block-content">
                                        <div class="sub-head">
                                            Initiator Update
                                        </div>
                                        <div class="group-input">
                                            <label for="qa-eval-comments"> Initiator Update Comments @if($data->stage == 9) <span class="text-danger">*</span>@endif</label>
                                            <div class="relative-container">
                                                <textarea  name="intial_update_comments" {{ $data->stage == 0 || $data->stage == 13 ? 'readonly' : '' }}>{{$data->intial_update_comments}}</textarea>
                                                @component('frontend.forms.language-model', ['readonly' => $data->stage == 0 || $data->stage == 13])
                                                @endcomponent
                                            </div>
                                            </div>

                              
                                        @if ($data->intial_update_attach)
                                            @foreach (json_decode($data->intial_update_attach) as $file)
                                                <input id="productionInjectionAttachmentFile-{{ $loop->index }}" type="hidden"
                                                    name="existinProductionInjectionFile[{{ $loop->index }}]"
                                                    value="{{ $file }}">
                                            @endforeach
                                        @endif
                                        <div class="group-input">
                                            <label for="qa-eval-attach"> Initiator Update Attachments</label>
                                            <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="intial_update_attach">
                                                @if (!empty($data->intial_update_attach))
                                                    @foreach (json_decode($data->intial_update_attach) as $file)
                                                        <h6 class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                            <b>{{ $file }}</b>
                                                            <a href="{{ asset('upload/' . $file) }}" target="_blank">
                                                                <i class="fa fa-eye text-primary" style="font-size:20px; margin-right:-10px;"></i>
                                                            </a>
                                                            <a class="remove-file" data-remove-id="hodAttachmentFile-{{ $loop->index }}" data-file-name="{{ $file }}">
                                                                <i class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i>
                                                            </a>
                                                        </h6>
                                                    @endforeach
                                                @endif
                                            </div>                         
                                            <div class="add-btn">
                                                    <div>Add</div>
                                                    <input {{ $data->stage == 0 || $data->stage == 6 ? 'readonly' : '' }} 
                                                        type="file" id="myfile" name="intial_update_attach[]" 
                                                        oninput="addMultipleFiles(this, 'intial_update_attach')" multiple {{ $data->stage == 0 || $data->stage == 8 || $data->stage == 13 ? 'readonly' : '' }}>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="button-block">
                                            <button type="submit" class="saveButton">Save</button>
                                            <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                            <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                            <button type="button" style=" justify-content: center; width: 4rem; margin-left: 1px;;">
                                                <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">Exit</a>
                                            </button>
                                        </div>
                                    </div>
                                </div>  

                                <div id="CCForm6" class="inner-block cctabcontent">
                                    <div class="inner-block-content">
                                        <div class="sub-head">
                                        HOD Final Review 
                                        </div>
                                        <div class="group-input">
                                            <label for="qa-eval-comments">HOD Final Review Comments @if($data->stage == 10) <span class="text-danger">*</span>@endif</label>
                                            <div class="relative-container">
                                                <textarea  name="hod_final_review_comment" {{ $data->stage == 0 || $data->stage == 13 ? 'readonly' : '' }} >{{$data->hod_final_review_comment}}</textarea>
                                                @component('frontend.forms.language-model', ['readonly' => $data->stage == 0 || $data->stage == 13])
                                                @endcomponent
                                            </div>
                                            </div>

                           
                                        @if ($data->hod_final_review_attach)
                                            @foreach (json_decode($data->hod_final_review_attach) as $file)
                                                <input id="productionInjectionAttachmentFile-{{ $loop->index }}" type="hidden"
                                                    name="existinProductionInjectionFile[{{ $loop->index }}]"
                                                    value="{{ $file }}">
                                            @endforeach
                                        @endif
                                        <div class="group-input">
                                            <label for="qa-eval-attach">HOD Final Review Attachments</label>
                                            <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="hod_final_review_attach">
                                                    @if (!empty($data->hod_final_review_attach))
                                                        @foreach (json_decode($data->hod_final_review_attach) as $file)
                                                            <h6 class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                                <b>{{ $file }}</b>
                                                                <a href="{{ asset('upload/' . $file) }}" target="_blank">
                                                                    <i class="fa fa-eye text-primary" style="font-size:20px; margin-right:-10px;"></i>
                                                                </a>
                                                                <a class="remove-file" data-remove-id="hodAttachmentFile-{{ $loop->index }}" data-file-name="{{ $file }}">
                                                                    <i class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i>
                                                                </a>
                                                            </h6>
                                                        @endforeach
                                                    @endif
                                                </div>
                                                <div class="add-btn">
                                                    <div>Add</div>
                                                    <input {{ $data->stage == 0 || $data->stage == 6 ? 'readonly' : '' }}
                                                        type="file" id="myfile" name="hod_final_review_attach[]" 
                                                        oninput="addMultipleFiles(this, 'hod_final_review_attach')" multiple {{ $data->stage == 0 || $data->stage == 8 || $data->stage == 13 ? 'readonly' : '' }}>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="button-block">
                                            <button type="submit" class="saveButton">Save</button>
                                            <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                            <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                            <button type="button" style=" justify-content: center; width: 4rem; margin-left: 1px;;">
                                                <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">Exit</a>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div id="CCForm16" class="inner-block cctabcontent">
                                    <div class="inner-block-content">
                                        <div class="group-input">
                                            <label for="qa-appro-comments">Implementation Verification Comments @if($data->stage == 11) <span class="text-danger">*</span>@endif</label>
                                            <div class="relative-container">
                                                <textarea  name="implementation_verification_comments" {{ $data->stage == 0 || $data->stage == 8 || $data->stage == 13 ? 'readonly' : '' }}>{{ $data->implementation_verification_comments }}</textarea>
                                                @component('frontend.forms.language-model', ['readonly' => $data->stage == 0 || $data->stage == 8 || $data->stage == 13])
                                                @endcomponent
                                            </div>
                                            </div>
                                        <div class="group-input">
                                            <label for="feedback">Training Feedback</label>
                                            <div class="relative-container">
                                                <textarea  name="feedback" {{ $data->stage == 0 || $data->stage == 8 || $data->stage == 13 ? 'readonly' : '' }}>{{ $data->feedback }}</textarea>
                                                @component('frontend.forms.language-model', ['readonly' => $data->stage == 0 || $data->stage == 8 || $data->stage == 13])
                                                @endcomponent
                                            </div>
                                            </div>

                                        @if ($data->tran_attach)
                                            @foreach (json_decode($data->tran_attach) as $file)
                                                <input id="productionInjectionAttachmentFile-{{ $loop->index }}" type="hidden"
                                                    name="existinProductionInjectionFile[{{ $loop->index }}]"
                                                    value="{{ $file }}">
                                            @endforeach
                                        @endif
                                        <div class="group-input">
                                            <label for="tran-attach">Implementation Verification Attachments</label>
                                            <div class="file-attachment-field">
                                                <div class="file-attachment-list" id="tran_attach">
                                                    @if ($data->tran_attach)
                                                        @foreach (json_decode($data->tran_attach) as $file)
                                                            <h6 type="button" class="file-container text-dark"
                                                                style="background-color: rgb(243, 242, 240);">
                                                                <b>{{ $file }}</b>
                                                                <a href="{{ asset('upload/' . $file) }}"
                                                                    target="_blank"><i class="fa fa-eye text-primary"
                                                                        style="font-size:20px; margin-right:-10px;"></i></a>
                                                                <a type="button" class="remove-file" data-remove-id="existinProductionLiquidFile-{{ $loop->index }}"
                                                                    data-file-name="{{ $file }}"><i
                                                                        class="fa-solid fa-circle-xmark"
                                                                        style="color:red; font-size:20px;"></i></a>
                                                            </h6>
                                                        @endforeach
                                                    @endif
                                                </div>
                                                <div class="add-btn">
                                                    <div>Add</div>
                                                    <input type="file" id="myfile" name="tran_attach[]" 
                                                        oninput="addMultipleFiles(this, 'tran_attach')" multiple {{ $data->stage == 0 || $data->stage == 8 || $data->stage == 13 ? 'readonly' : '' }}>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="button-block">
                                            <button type="submit" class="saveButton">Save</button>
                                            <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                            <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                            <button type="button" style=" justify-content: center; width: 4rem; margin-left: 1px;;">
                                                <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">Exit</a>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div id="CCForm9" class="inner-block cctabcontent">
                                    <div class="inner-block-content">
                                        
                                <div class="group-input">
                                    <label for="qa-closure-comments">QA Closure Comments @if($data->stage == 13) <span class="text-danger">*</span>@endif</label>
                                    <div class="relative-container">
                                        <textarea name="qa_closure_comments" {{ $data->stage == 0 || $data->stage == 8 || $data->stage == 14 ? 'readonly' : '' }} >{{ $data->qa_closure_comments }}</textarea>
                                        @component('frontend.forms.language-model', ['readonly' => $data->stage == 0 || $data->stage == 8 || $data->stage == 14])
                                        @endcomponent
                                    </div>
                                </div>

                                @if ($data->attach_list)
                                    @foreach (json_decode($data->attach_list) as $file)
                                        <input id="trainingAttachmentFile-{{ $loop->index }}" type="hidden"
                                            name="existinTrainingFile[{{ $loop->index }}]"
                                            value="{{ $file }}">
                                    @endforeach
                                @endif
                                <div class="group-input">
                                    <label for="attach-list">List Of Attachments</label>
                                    <div class="file-attachment-field">
                                        <div class="file-attachment-list" id="attach_list">
                                            @if ($data->attach_list)
                                                @foreach (json_decode($data->attach_list) as $file)
                                                    <h6 type="button" class="file-container text-dark"
                                                        style="background-color: rgb(243, 242, 240);">
                                                        <b>{{ $file }}</b>
                                                        <a href="{{ asset('upload/' . $file) }}" target="_blank"><i
                                                                class="fa fa-eye text-primary"
                                                                style="font-size:20px; margin-right:-10px;"></i></a>
                                                        <a type="button" class="remove-file" data-remove-id="existinProductionLiquidFile-{{ $loop->index }}"
                                                            data-file-name="{{ $file }}"><i
                                                                class="fa-solid fa-circle-xmark"
                                                                style="color:red; font-size:20px;"></i></a>
                                                    </h6>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input type="file"  {{ $data->stage == 0 || $data->stage == 13 ? 'readonly' : '' }}  id="myfile" name="attach_list[]" 
                                                oninput="addMultipleFiles(this, 'attach_list')" multiple {{ $data->stage == 0 || $data->stage == 8 || $data->stage == 13 ? 'readonly' : '' }}>
                                        </div>
                                    </div>
                                </div>
                            <div class="col-12 sub-head">
                                Extension Justification
                            </div>
                            <div class="col-12">
                                <div class="group-input">
                                    <label for="due_date_extension">Due Date Extension Justification</label>
                                    <div class="relative-container">
                                        <textarea name="due_date_extension" {{ $data->stage == 0 || $data->stage == 8 || $data->stage == 13 ? 'readonly' : '' }} > {{ $due_date_extension }}</textarea>
                                        @component('frontend.forms.language-model', ['readonly' => $data->stage == 0 || $data->stage == 13])
                                        @endcomponent
                                    </div>
                                </div>
                    <div class="button-block">
                        <button type="submit" class="saveButton">Save</button>
                        <button type="button" class="backButton" onclick="previousStep()">Back</button>
                        <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                        <button type="button" style=" justify-content: center; width: 4rem; margin-left: 1px;;">
                            <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">Exit</a>
                        </button>
                    </div>
                </div>
            </div>
                                        </div>
            @php
                $product = DB::table('products')->get();
                $material = DB::table('materials')->get();
            @endphp

            <div id="CCForm10" class="inner-block cctabcontent">
                <div class="inner-block-content">
                   
                    <div class="row">
                        <div class="sub-head">Submission</div>
                        <div class="col-lg-3">
                            <div class="group-input">
                                <label for="submit by">Submit By :-</label>
                                <div class="static">{{ $data->submit_by }}</div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="group-input">
                                <label for="submit on">Submit On :-</label>
                                <div class="static">{{ $data->submit_on }}</div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input" style="width:1620px; height:100px; `padding:5px;">
                                <label for="submit comment">Submit Comments :-</label>
                                <div class="">{{ $data->submit_comment }}</div>
                            </div>
                        </div>

                        <div class="sub-head">HOD Assessment Complete</div>
                        <div class="col-lg-3">
                            <div class="group-input">
                                <label for="HOD Review Complete By">HOD Assessment Complete By :-</label>
                                <div class="static">{{ $data->hod_review_by }}</div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="group-input">
                                <label for="HOD Review Complete On">HOD Assessment Complete On :-</label>
                                <div class="static">{{ $data->hod_review_on }}</div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input" style=" ">
                                <label for="HOD Review Comments">HOD Assesment Comment :-</label>
                                <div class="">{{ $data->hod_review_comment }}</div>
                            </div>
                        </div>

                        {{--  <div class="sub-head">Sent to Initiator (From HOD)</div>
                        <div class="col-lg-3">
                            <div class="group-input">
                                <label for="HOD Review Complete By">Initiator Complete By :-</label>
                                <div class="static">{{ $data->hod_to_initiator_by }}</div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="group-input">
                                <label for="HOD Review Complete On">Initiator Complete On :-</label>
                                <div class="static">{{ $data->hod_to_initiator_on }}</div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input" style=" ">
                                <label for="HOD Review Comments">Initiator Comments :-</label>
                                <div class="">{{ $data->hod_to_initiator_comment }}</div>
                            </div>
                        </div>  --}}


                        <div class="sub-head">QA/CQA Initial Assessment Complete</div>
                        <div class="col-lg-3">
                            <div class="group-input">
                                <label for="QA Initial Review Complete By">QA/CQA Initial Assessment Complete By :-</label>
                                <div class="static">{{ $data->QA_initial_review_by }}</div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="group-input">
                                <label for="QA Initial Review Complete On">QA/CQA Initial Assessment Complete On :-</label>
                                <div class="static">{{ $data->QA_initial_review_on }}</div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input" style="width:1620px; height:100px; `padding:5px;">
                                <label for="QA Initial Review Comments">QA/CQA Initial Assesment Comments:-</label>
                                <div class="">{{ $data->QA_initial_review_comment }}</div>
                            </div>
                        </div>

                        <div class="sub-head">CFT Review Complete</div>
                        <div class="col-lg-3">
                            <div class="group-input">
                                <label for="CFT Review Complete By">CFT Review Complete By :-</label>
                                <div class="static">{{ $data->cft_review_by }}</div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="group-input">
                                <label for="CFT Review Complete On">CFT Review Complete On :-</label>
                                <div class="static">{{ $data->cft_review_on }}</div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input" style="width:1620px; height:100px; `padding:5px; ">
                                <label for="CFT Review Comments">CFT Review Comments :-</label>
                                <div class="">{{ $data->cft_review_comment }}</div>
                            </div>
                        </div>

                        <div class="sub-head"> QA/CQA Final Review Completed</div>
                        <div class="col-lg-3">
                            <div class="group-input">
                                <label for="QA Final Review Complete By"> QA/CQA Final Review Complete By :-</label>
                                <div class="static">{{ $data->QA_final_review_by }}</div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="group-input">
                                <label for="QA Final Review Complete On"> QA/CQAFinal Review Complete On :-</label>
                                <div class="static">{{ $data->QA_final_review_on }}</div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input" style="width:1620px; height:100px; `padding:5px; ">
                                <label for="QA Final Review Comments"> QA/CQA Final Review Comments :-</label>
                                <div class="">{{ $data->QA_final_review_comment }}</div>
                            </div>
                        </div>

                        <div class="sub-head">RA Approval Required</div>
                        <div class="col-lg-3">
                            <div class="group-input">
                                <label for="CFT Review Complete By">RA Approval Required By :-</label>
                                <div class="static">{{ $data->RA_review_required_by }}</div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="group-input">
                                <label for="CFT Review Complete On">RA Approval Required On :-</label>
                                <div class="static">{{ $data->RA_review_required_on }}</div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input" style="width:1620px; height:100px; `padding:5px; ">
                                <label for="CFT Review Comments">RA Approval Required Comments :-</label>
                                <div class="">{{ $data->RA_review_required_comment }}</div>
                            </div>
                        </div>


                        <div class="sub-head">RA Approval Complete</div>
                        <div class="col-lg-3">
                            <div class="group-input">
                                <label for="CFT Review Complete By">RA Approval Complete By :-</label>
                                <div class="static">{{ $data->RA_review_completed_by }}</div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="group-input">
                                <label for="CFT Review Complete On">RA Approval Complete On :-</label>
                                <div class="static">{{ $data->RA_review_completed_on }}</div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input" style="width:1620px; height:100px; `padding:5px; ">
                                <label for="CFT Review Comments"> RA Approval Comments :-</label>
                                <div class="">{{ $data->RA_review_completed_comment }}</div>
                            </div>
                        </div>

                                        

                        <div class="sub-head">QA/CQA Head/Manager Designee Approval</div>
                        <div class="col-lg-3">
                            <div class="group-input">
                                <label for="QA Final Review Complete By">QA/CQA Head/Manager Designee Approval By :-</label>
                                <div class="static">{{ $data->RA_review_completed_by }}</div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="group-input">
                                <label for="QA Final Review Complete On">QA/CQA Head/Manager Designee Approval On :-</label>
                                <div class="static">{{ $data->RA_review_completed_on }}</div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input" style="width:1620px; height:100px; `padding:5px; ">
                                <label for="QA Final Review Comments">QA/CQA Head/Manager Designee Approval Comments :-</label>
                                <div class="">{{ $data->RA_review_completed_comment }}</div>
                            </div>
                        </div>

                        @php
                        $commnetData = DB::table('change_control_comments')->where('cc_id', $data->id)->first();
                    @endphp
                    
                    <div class="sub-head">Pending Initiator Updated Completed</div>
                    
                    <div class="col-lg-3">
                        <div class="group-input">
                            <label for="QA Final Review Complete By">Pending Initiator Updated Completed By :-</label>
                            <div class="static">
                                {{ isset($commnetData->initiator_update_complete_by) ? $commnetData->initiator_update_complete_by : '' }}
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-3">
                        <div class="group-input">
                            <label for="QA Final Review Complete On">Pending Initiator Updated Completed On :-</label>
                            <div class="static">
                                {{ isset($commnetData->initiator_update_complete_on) ? $commnetData->initiator_update_complete_on : '' }}
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-6">
                        <div class="group-input" style="width:1620px; height:100px; padding:5px;">
                            <label for="QA Final Review Comments">Pending Initiator Updated Completed Comments :-</label>
                            <div class="">
                                {{ isset($commnetData->initiator_update_complete_comment) ? $commnetData->initiator_update_complete_comment : '' }}
                            </div>
                        </div>
                    </div>
                    


                    <div class="sub-head">HOD Final Review Complete</div>
                    <div class="col-lg-3">
                        <div class="group-input">
                            <label for="QA Final Review Complete By">  HOD Final Review Complete  By :-</label>
                            <div class="static">{{ $data->closure_approved_by }}</div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="group-input">
                            <label for="QA Final Review Complete On">  HOD Final Review Complete  On :-</label>
                            <div class="static">{{ $data->closure_approved_on }}</div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input" style="width:1620px; height:100px; `padding:5px; ">
                            <label for="QA Final Review Comments"> HOD Final Review Complete Comments :-</label>
                            <div class="">{{ $data->closure_approved_comment }}</div>
                        </div>
                    </div>


                        <div class="sub-head">Send For Final QA/CQA Head Approval
                            </div>
                        <div class="col-lg-3">
                            <div class="group-input">
                                <label for="QA Final Review Complete By">Send For Final QA/CQA Head Approval By :-</label>
                                <div class="static">{{ isset($commnetData->send_for_final_qa_head_approval) ? $commnetData->send_for_final_qa_head_approval: '' }}</div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="group-input">
                                <label for="QA Final Review Complete On">Send For Final QA/CQA Head Approval On :-</label>
                                <div class="static">{{isset($commnetData->send_for_final_qa_head_approval_on) ?$commnetData->send_for_final_qa_head_approval_on :''}}</div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input" style="width:1620px; height:100px; `padding:5px; ">
                                <label for="QA Final Review Comments">Send For Final QA/CQA Head Approval Comments :-</label>
                                <div class="">{{ isset($commnetData->send_for_final_qa_head_approval_comment) ? $commnetData->send_for_final_qa_head_approval_comment :'' }}</div>
                            </div>
                        </div>


                        <div class="sub-head">Closure Approved

                        </div>
                    <div class="col-lg-3">
                        <div class="group-input">
                            <label for="QA Final Review Complete By">Closure Approved By :-</label>
                            <div class="static">
                                {{ isset($commnetData->closure_approved_by) ? $commnetData->closure_approved_by : '' }}
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="group-input">
                            <label for="QA Final Review Complete On">Closure Approved On :-</label>
                            <div class="static">{{  isset($commnetData->closure_approved_on) ? $commnetData->closure_approved_on : ''}}</div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input" style="width:1620px; height:100px; `padding:5px; ">
                            <label for="QA Final Review Comments">Closure Approved Comments :-</label>
                            <div class="">{{ isset($commnetData->closure_approved_comment) ?$commnetData->closure_approved_comment :'' }}</div>
                        </div>
                    </div>

                        
                    </div>
                    <div class="button-block">
                        <button type="submit" class="saveButton">Save</button>
                        <button type="button" class="backButton" onclick="previousStep()">Back</button>
                        <button type="button" style=" justify-content: center; width: 4rem; margin-left: 1px;;">
                            <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">Exit</a>
                        </button>
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


    <div class="modal fade" id="child-modal1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Child</h4>
                </div>
                <form action="{{ route('extension_child', $cc_lid) }}" method="POST">
                    @csrf
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="group-input">
                            <label for="major">
                                <input type="radio" name="child_type" value="documents">
                                New Document
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


    <div class="modal fade" id="signature-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">E-Signature</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ url('rcms/send-stage', $cc_lid) }}" method="POST">
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

    <div id="division-modal" class="d-none">
        <div class="division-container">
            <div class="content-container">
                <form action="{{ route('division_submit') }}" method="post">
                    @csrf
                    <div class="division-tabs">
                        <div class="tab">
                            @php
                                $division = DB::table('divisions')->get();
                            @endphp
                            @foreach ($division as $temp)
                                <input type="hidden" value="{{ $temp->id }}" name="division_id" required>
                                <button class="divisionlinks"
                                    onclick="openDivision(event, {{ $temp->id }})">{{ $temp->name }}</button>
                            @endforeach

                        </div>
                        @php
                            $process = DB::table('processes')->get();
                        @endphp
                        @foreach ($process as $temp)
                            <div id="{{ $temp->division_id }}" class="divisioncontent">
                                @php
                                    $pro = DB::table('processes')
                                        ->where('division_id', $temp->division_id)
                                        ->get();
                                @endphp
                                @foreach ($pro as $test)
                                    <label for="process">
                                        <input type="radio" for="process" value="{{ $test->id }}"
                                            name="process_id" required> {{ $test->process_name }}
                                    </label>
                                @endforeach
                            </div>
                        @endforeach

                    </div>
                    <div class="button-container">
                        <button id="submit-division">Cancel</button>
                        <button id="submit-division" type="submit">Continue</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


            <div class="modal fade" id="effectiveness-check-modal">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Child</h4>
                        </div>
                        <form action="{{ route('CC-effectiveness-check', $data->id) }}" method="POST">
                            @csrf
                            <!-- Modal body -->
                            <div class="modal-body">
                                <div class="group-input">
                                    <label for="major">
                                        <input type="hidden" name="parent_name" value="CC">
                                        <input type="hidden" name="due_date" value="{{ $data->due_date }}">
                                        <input type="radio" name="child_type" value="effectiveness_check">
                                        Effectiveness Check
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


    <div class="modal fade" id="child-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Child</h4>
                </div>
                <form action="{{ url('rcms/child', $cc_lid) }}" method="POST">
                    @csrf
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="group-input">
                            
                            @if($data->stage == 3)
                                <label for="minor">
                                    <input type="radio" name="revision" id="minor" value="RCA">
                                    RCA
                                </label>
                                <label for="minor">
                                    <input type="radio" name="revision" id="minor" value="Extension">
                                    Extension
                                </label>
                            @endif
                            @if($data->stage == 5)
                                <label for="minor">
                                    <input type="radio" name="revision" id="minor" value="Capa">
                                    CAPA
                                </label>
                                <label for="minor">
                                    <input type="radio" name="revision" id="minor" value="Extension">
                                    Extension
                                </label>                            
                                <label for="minor">
                                    <input type="radio" name="revision" id="minor" value="Action-Item">
                                    Action Item
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


    <!-- modal for stage 9 child-modal-stage_8 start-->

    <div class="modal fade" id="child-modal-stage_8">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Child</h4>
                </div>
                <form action="{{ url('rcms/child', $cc_lid) }}" method="POST">
                    @csrf
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="group-input">
                            @if($data->stage == 9)
                            <div>
                                <label for="minor">
                                    <input type="radio" name="revision" id="minor" value="RCA">
                                    RCA
                                </label>
                            </div>
                            <div>   
                                <label for="minor">
                                    <input type="radio" name="revision" id="minor" value="Extension">
                                    Extension
                                </label> 
                            </div>   


                            @endif
                            @if($data->stage == 9)
                            <div>
                                <label for="minor">
                                    <input type="radio" name="revision" id="minor" value="Capa">
                                    CAPA
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





    <!-- modal for stage 9 child-modal-stage_8 End-->
    



    <div class="modal fade" id="child_effective_ness">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Child</h4>
                </div>
                <form action="{{ url('rcms/child', $cc_lid) }}" method="POST">
                    @csrf
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="group-input">
                            @if($data->stage == 13)
                                <div>
                                    <label for="minor">
                                        <input type="radio" name="revision" id="minor" value="Effective-Check">
                                        Effectiveness Check
                                    </label>

                                    <!-- <label for="minor">
                                        <input type="radio" name="revision" id="minor" value="New Document">
                                        New Document
                                    </label> -->
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




    <!-- /************ Open State Modal ***********/ -->
    <div class="modal fade" id="opened-state-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">E-Signature</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form action="{{ url('rcms/sendTo-initiator', $cc_lid) }}" method="POST">
                    @csrf
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
                            <input type="comment" class="form-control" name="comments" required>
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
    <!-- /************ Open State Modal ***********/ -->

    <!-- /************ Initial QA Modal ***********/ -->
    <div class="modal fade" id="initalQA-review-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">E-Signature</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form action="{{ url('rcms/sendTo-qaInitial', $cc_lid) }}" method="POST">
                    @csrf
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
                            <input type="comment" class="form-control" name="comments" required>
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
    <!-- /************ Initial QA Modal ***********/ -->

    <!-- /************ Sent to QA Head Approval Modal ***********/ -->
    <div class="modal fade" id="qa-head-approval">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">E-Signature</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form action="{{ url('rcms/qa-cqa-head-approval', $cc_lid) }}" method="POST">
                    @csrf
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
                            <label for="comment">Comment</label>
                            <input type="comment" class="form-control" name="comments">
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
    <!-- /************ Sent to QA Head Approval Modal ***********/ -->
    <div class="modal fade" id="send-reject">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">E-Signature</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form action="{{ url('rcms/closed-rejected', $cc_lid) }}" method="POST">
                    @csrf
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
                            <label for="comment">Comment<span class="text-danger">*</span></label>
                            <input type="comment" class="form-control" name="comments" required>
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
    <!-- /************ Sent to Post Implementation Modal ***********/ -->
    <div class="modal fade" id="send-post-implementation">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">E-Signature</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form action="{{ url('rcms/post-implementation', $cc_lid) }}" method="POST">
                    @csrf
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
                            <label for="comment">Comment</label>
                            <input type="comment" class="form-control" name="comments">
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
    <!-- /************ Sent to Post Implementation Modal ***********/ -->


    <!-- /************ HOD Modal ***********/ -->
    <div class="modal fade" id="hod-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">E-Signature</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form action="{{ url('rcms/sendTo-hod', $cc_lid) }}" method="POST">
                    @csrf
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
                            <input type="comment" class="form-control" name="comments" required>
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
    <!-- /************ HOD Modal ***********/ -->


    <div class="modal fade" id="rejection-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">E-Signature</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form action="{{ url('rcms/stage-reject', $cc_lid) }}" method="POST">
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

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="submit" data-bs-dismiss="modal">Submit</button>
                        <button type="button" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="cft-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">E-Signature</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form action="{{ url('rcms/send-cft-field', $cc_lid) }}" method="POST">
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
    <div class="modal fade" id="cancel-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">E-Signature</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form action="{{ url('rcms/closed-cancelled', $cc_lid) }}" method="POST">
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

    <script>
        $(document).ready(function () {
    
            $('#submitPrompt').click(async function () {
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
                        'https://api.openai.com/v1/chat/completions',
                        {
                            "model": "gpt-3.5-turbo",
                            "messages": [
                                {
                                    "role": "user",
                                    "content": `Generate a structured JSON response (string key: string value) with fields Impact On Operations, Impact On Product Quality, Regulatory Impact, Risk Level, Validation Requirement based on the Change Control description: "${docDescription}". Make content as lengthy as possible.`
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
        #productTable,
        #materialTable {
            display: none;
        }
    </style>

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
        document.addEventListener('DOMContentLoaded', function () {
            const currentStage = document.getElementById('stage').value;
            
            if (currentStage > 2)
            {
                const RA_Review = document.getElementById('RA_Review').value;
                const qualityAssurnce = document.getElementById('Quality_Assurance_Review').value;
                const Production_Table_Review = document.getElementById('Production_Table_Review').value;
            const ProductionLiquid_Review = document.getElementById('ProductionLiquid_Review').value;
            const Production_Injection_Review = document.getElementById('Production_Injection_Review').value;
            const Store_Review = document.getElementById('Store_Review').value;
            const Quality_review = document.getElementById('Quality_review').value;
            const ResearchDevelopment_Review = document.getElementById('ResearchDevelopment_Review').value;
            const Engineering_review = document.getElementById('Engineering_review').value;
            const Human_Resource_review = document.getElementById('Human_Resource_review').value;
            const Microbiology_Review = document.getElementById('Microbiology_Review').value;
            const RegulatoryAffair_Review = document.getElementById('RegulatoryAffair_Review').value;
            const CorporateQualityAssurance_Review = document.getElementById('CorporateQualityAssurance_Review').value;
            const Environment_Health_review = document.getElementById('Environment_Health_review').value;
            const Information_Technology_review = document.getElementById('Information_Technology_review').value;
            const ContractGiver_Review = document.getElementById('ContractGiver_Review').value;


            function updateFieldAttributes() {
                if (currentStage == 3) {
                    RA_Review.required = true;
                    qualityAssurnce.required = true;
                    Production_Table_Review.required = true;
                    ProductionLiquid_Review.required = true;
                    Production_Injection_Review.required = true;
                    Store_Review.required = true;
                    Quality_review.required = true;
                    ResearchDevelopment_Review.required = true;
                    Engineering_review.required = true;
                    Human_Resource_review.required = true;
                    Microbiology_Review.required = true;
                    RegulatoryAffair_Review.required = true;
                    CorporateQualityAssurance_Review.required = true;
                    Environment_Health_review.required = true;
                    Information_Technology_review.required = true;
                    ContractGiver_Review.required = true;

                    RA_Review.readonly = false;
                    qualityAssurnce.readonly = false;
                    Production_Table_Review.readonly = false;
                    ProductionLiquid_Review.readonly = false;
                    Production_Injection_Review.readonly = false;
                    Store_Review.readonly = false;
                    Quality_review.readonly = false;
                    ResearchDevelopment_Review.readonly = false;
                    Engineering_review.readonly = false;
                    Human_Resource_review.readonly = false;
                    Microbiology_Review.readonly = false;
                    RegulatoryAffair_Review.readonly = false;
                    CorporateQualityAssurance_Review.readonly = false;
                    Environment_Health_review.readonly = false;
                    Information_Technology_review.readonly = false;
                    ContractGiver_Review.readonly = false;
                } else if (currentStage == 4) {
                    RA_Review.required = false;
                    qualityAssurnce.required = false;
                    Production_Table_Review.required = false;
                    ProductionLiquid_Review.required = false;
                    Production_Injection_Review.required = false;
                    Store_Review.required = false;
                    Quality_review.required = false;
                    ResearchDevelopment_Review.required = false;
                    Engineering_review.required = false;
                    Human_Resource_review.required = false;
                    Microbiology_Review.required = false;
                    RegulatoryAffair_Review.required = false;
                    CorporateQualityAssurance_Review.required = false;
                    Environment_Health_review.required = false;
                    Information_Technology_review.required = false;
                    ContractGiver_Review.required = false;

                    RA_Review.readonly = true;
                    qualityAssurnce.readonly = true;
                    Production_Table_Review.readonly = true;
                    ProductionLiquid_Review.readonly = true;
                    Production_Injection_Review.readonly = true;
                    Store_Review.readonly = true;
                    Quality_review.readonly = true;
                    ResearchDevelopment_Review.readonly = true;
                    Engineering_review.readonly = true;
                    Human_Resource_review.readonly = true;
                    Microbiology_Review.readonly = true;
                    RegulatoryAffair_Review.readonly = true;
                    CorporateQualityAssurance_Review.readonly = true;
                    Environment_Health_review.readonly = true;
                    Information_Technology_review.readonly = true;
                    ContractGiver_Review.readonly = true;
                }
            }
            updateFieldAttributes();
            document.getElementById('CCFormInput').addEventListener('submit', function () {
                if (currentStage == 4) {
                    RA_Review.readonly = false;
                    qualityAssurnce.readonly = false;
                    Production_Table_Review.readonly = false;
                    ProductionLiquid_Review.readonly = false;
                    Production_Injection_Review.readonly = false;
                    Store_Review.readonly = false;
                    Quality_review.readonly = false;
                    ResearchDevelopment_Review.readonly = false;
                    Engineering_review.readonly = false;
                    Human_Resource_review.readonly = false;
                    Microbiology_Review.readonly = false;
                    RegulatoryAffair_Review.readonly = false;
                    CorporateQualityAssurance_Review.readonly = false;
                    Environment_Health_review.readonly = false;
                    Information_Technology_review.readonly = false;
                    ContractGiver_Review.readonly = false;
                }
            });
            }
        });
    </script>

    <script>
        VirtualSelect.init({
            ele: '#related_records, #reviewer_person_value, #risk_assessment_related_record, #external_mutipleusers'
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

    <script>
        $(document).ready(function() {
            var disableInputs = {{ $data->stage }}; // Replace with your condition

            if (disableInputs == 0 || disableInputs > 13) {
                // Disable all input fields within the form
                $('#CCFormInput :input:not(select)').prop('readonly', true);
                $('#CCFormInput select').prop('readonly', true);
            } else {
                // $('#CCFormInput :input').prop('readonly', false);
            }
        });
    </script>

  
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
