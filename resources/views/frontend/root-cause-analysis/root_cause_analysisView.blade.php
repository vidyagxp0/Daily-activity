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


{{--<style>
    .modal.left .modal-dialog {
        position: fixed;
        margin: auto;
        width: 300px; /* Adjust the width as per your need */
        height: 100%;
        left: 0;
        top: 0;
        transform: translate3d(0%, 0, 0);
    }

    .modal.left .modal-content {
        height: 100%;
        overflow-y: auto;
    }

    .modal.left.fade .modal-dialog {
        left: -300px; /* Match the width of the modal-dialog */
        transition: opacity 0.3s linear, left 0.3s ease-out;
    }

    .modal.left.fade.show .modal-dialog {
        left: 0;
    }

    .sticky-buttons {
        position: fixed;
        top: 50%; /* Centers vertically */
        left: 20px;
        transform: translateY(-50%); /* Adjust for exact center */
        z-index: 1050;
    }

    .sticky-buttons a {
        display: inline-block;
        padding: 10px;
        background-color: #007bff;
        border-radius: 50%;
        color: #fff;
        text-align: center;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    }

    .mini_buttons {
        padding: 10px;
        margin: 5px 0;
        text-align: center;
        border-radius: 5px;
    }

    .down-logo {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100px;
        width: 50px;
        margin: 0 auto;
    }

    .dawn_arrow {
        transform: rotate(90deg);
        width: 30px;
        height: 30px;
    }
</style>--}}


    {{--<style>
        .modal.left .modal-dialog {
                position: fixed;
                margin: auto;
                width: 300px; /* Adjust the width as per your need */
                height: 100%;
                left: 0;
                top: 0;
                transform: translate3d(0%, 0, 0);
            }

            .modal.left .modal-content {
                height: 100%;
                overflow-y: auto;
            }

            .modal.left.fade .modal-dialog {
                left: -300px; /* Match the width of the modal-dialog */
                transition: opacity 0.3s linear, left 0.3s ease-out;
            }

            .modal.left.fade.show .modal-dialog {
                left: 0;
            }

            .sticky-buttons {
                position: fixed;
                top: 10px;
                left: 20px;
                z-index: 1050;
            }

            .sticky-buttons a {
                display: inline-block;
                padding: 10px;
                background-color: #007bff;
                border-radius: 50%;
                color: #fff;
                text-align: center;
                box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            }

            .mini_buttons {
                padding: 10px;
                margin: 5px 0;
                text-align: center;
                border-radius: 5px;
                /* color: #000; */
            }

            .down-logo {
                display: flex;
                flex-direction: column; /* Ensures items are stacked vertically */
                align-items: center; /* Centers the image horizontally */
                justify-content: center; /* Centers the image vertically */
                height: 100px; /* Adjust height as needed */
                width: 50px; /* Adjust width as needed */
                margin: 0 auto; /* Centers the entire container */
            }

            .dawn_arrow {
                transform: rotate(90deg); /* Rotates the arrow to make it vertical */
                width: 30px; /* Adjust size as needed */
                height: 30px; /* Adjust size as needed */
            }
    </style>--}}



    {{--Side Bar Workflow CSS start--}}

    <style>
        .sticky-buttons div {
             background: #de8d0a;
             /*background: #4274da;*/
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
                    {{--Side Bar Workflow CSS end--}}
    

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
            function addWhyField(con_class, name) {
                let mainBlock = document.querySelector('.why-why-chart')
                let container = mainBlock.querySelector(`.${con_class}`)
                let textarea = document.createElement('textarea')
                textarea.setAttribute('name', name);
                container.append(textarea)
            }
        </script>

        <div class="form-field-head">
            <div class="division-bar">
                <strong>Site Division/Project</strong> :
                {{ Helpers::getDivisionName($data->division_id) }} / Root Cause Analysis
            </div>
        </div>
        @php
            $users = DB::table('users')->get();
        @endphp

        <!-- ======================================
                                                                                                                                                                                                                                                                                                                                                                        DATA FIELDS
                                                                                                                                                                                                                                                                                                                                                        ======================================= -->
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
                                $userRoles = DB::table('user_roles')
                                    ->where(['user_id' => Auth::user()->id, 'q_m_s_divisions_id' => $data->division_id])
                                    ->get();
                                $userRoleIds = $userRoles->pluck('q_m_s_roles_id')->toArray();
                            @endphp
                            {{-- <button class="button_theme1" onclick="window.print();return false;"
                                class="new-doc-btn">Print</button> --}}
                            <button class="button_theme1"> <a class="text-white"
                                    href="{{ url('rootAuditTrial', $data->id) }}">
                                    Audit Trail </a> </button>

                            @if ($data->stage == 1 && (in_array(3, $userRoleIds) || in_array(18, $userRoleIds)))
                                <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                    Acknowledge
                                </button>
                                <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-modal">
                                    Cancel
                                </button>
                            @elseif($data->stage == 2 && (in_array(7, $userRoleIds) || in_array(18, $userRoleIds)))
                                <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#rejection-modal">
                                    More Info Required
                                </button>
                                <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                    HOD Review Complete
                                </button>
                            @elseif($data->stage == 3 && (in_array(7, $userRoleIds) || in_array(18, $userRoleIds)))
                                <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#rejection-modal">
                                    More Info Required
                                </button>
                                <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                    QA/CQA Review Complete
                                </button>
                            @elseif($data->stage == 4)
                                <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#rejection-modal">
                                    More Info Required
                                </button>
                                <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                    Submit
                                </button>

                                <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#child-modal">
                                    Child

                                </button>
                            @elseif($data->stage == 5)
                                <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#rejection-modal">
                                    More Info Required

                                </button>
                                <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                    HOD Final Review Complete

                                </button>
                            @elseif($data->stage == 6 && (in_array(7, $userRoleIds) || in_array(18, $userRoleIds)))
                                <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#rejection-modal">
                                    More Information
                                    Required
                                </button>
                                <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                    Final QA/CQA Review Complete
                                </button>
                            @elseif($data->stage == 7 && (in_array(7, $userRoleIds) || in_array(18, $userRoleIds)))
                                <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#rejection-modal">
                                    More Information
                                    Required
                                </button>
                                <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                    QAH/CQAH Closure
                                </button>
                            @endif
                            <button class="button_theme1"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}">
                                    Exit
                                </a> </button>

                        </div>
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
                        {{-- <div>
                                <a type="button" class="" data-toggle="modal" data-target="#myModal4">
                                  <svg width="24" height="24" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                                    <path fill="#ffffff" d="M25.01 49v46H103V49zM153 49v46h78V49zm128 0v46h78V49zm128 0v46h78V49zM55.01 113v64H119v46h18v-46h64v-64h-18v46H73.01v-46zM311 113v64h64v46h18v-46h64v-64h-18v46H329v-46zM89.01 241v46H167v-46zM345 241v46h78v-46zm-226 64v48h128v46h18v-46h128v-48h-18v30H137v-30zm98 112v46h78v-46z"/>
                                  </svg>
                                </a>
                            </div> --}}
                    </div>
    
                    <div class="modal right fade" id="myModal3" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-titles ml-10">Root Cause Analysis Workflow</h4>
                                </div>
                                <div  style="" class="modal-body main-new-workflow">
                                    <Div class="button-box">
                                        @if ($data->stage == 0)
                                            <div class="progress-bars">
                                                <div class="bg-danger">Closed-Cancelled</div>
                                            </div>
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
                                            HOD Review
                                        </div> 
                                        @else
                                        <div  class="mini_buttons">
                                            HOD Review
                                        </div>
                                        @endif
                                        <div class="down-logo">
                                            <img class="dawn_arrow" src="{{ asset('user/images/down.gif') }}" alt="..."
                                                class="w-100 h-100">
            
                                        </div>
                                        @if ($data->stage >= 3)
                                        <div  class="active">
                                            Initial QA/CQA Review
                                        </div>
                                        @else
                                        <div  class="mini_buttons">
                                            Initial QA/CQA Review
                                        </div>
                                        @endif
                                        <div class="down-logo">
                                            <img class="dawn_arrow" src="{{ asset('user/images/down.gif') }}" alt="..."
                                                class="w-100 h-100">
            
                                        </div>
                                        @if ($data->stage >= 4)
        
                                        <div  class="active">
                                           Investigation In progress
                                        </div>
                                        @else
                                        <div  class="mini_buttons">
                                           Investigation In progress
                                        </div>
                                        @endif
        
                                        <div class="down-logo">
                                            <img class="dawn_arrow" src="{{ asset('user/images/down.gif') }}" alt="..."
                                                class="w-100 h-100">
            
                                        </div>
                                        @if ($data->stage >= 5)
        
                                        <div  class="active">
                                            HOD Final Review
                                        </div>
                                        @else
                                        <div  class="mini_buttons">
                                            HOD Final Review
                                        </div>
                                        @endif
        
                                        <div class="down-logo">
                                            <img class="dawn_arrow" src="{{ asset('user/images/down.gif') }}" alt="..."
                                                class="w-100 h-100">
            
                                        </div>
                                        @if ($data->stage >= 6)
        
                                        <div  class="active">
                                            Final QA/CQA Review
                                        </div>
                                        @else
                                        <div  class="mini_buttons">
                                            Final QA/CQA Review
                                        </div>
                                        @endif
        
                                        <div class="down-logo">
                                            <img class="dawn_arrow" src="{{ asset('user/images/down.gif') }}" alt="..."
                                                class="w-100 h-100">
            
                                        </div>
                                        @if ($data->stage >= 7)
        
                                        <div  class="active">
                                            QAH/CQAH Final Review
                                        </div>
                                        @else
                                        <div  class="mini_buttons">
                                            QAH/CQAH Final Review
                                        </div>
                                        @endif
        
                                        <div class="down-logo">
                                            <img class="dawn_arrow" src="{{ asset('user/images/down.gif') }}" alt="..."
                                                class="w-100 h-100">
            
                                        </div>
                                        
                                        @if ($data->stage >= 8)
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
                                    <div class="active">HOD Review</div>
                                @else
                                    <div class="">HOD Review</div>
                                @endif
                                @if ($data->stage >= 3)
                                    <div class="active">Initial QA/CQA Review</div>
                                @else
                                    <div class="">Initial QA/CQA Review</div>
                                @endif


                                @if ($data->stage >= 4)
                                    <div class="active">Investigation in Progress </div>
                                @else
                                    <div class="">Investigation in Progress</div>
                                @endif
                                @if ($data->stage >= 5)
                                    <div class="active">HOD Final Review</div>
                                @else
                                    <div class="">HOD Final Review</div>
                                @endif


                                {{-- @if ($data->stage >= 3)
                                    <div class="active">Pending Group Review Discussion</div>
                                @else
                                    <div class="">Pending Group Review Discussion</div>
                                @endif

                                @if ($data->stage >= 4)
                                    <div class="active">Pending Group Review</div>
                                @else
                                    <div class="">Pending Group Review</div>
                                @endif --}}


                                @if ($data->stage >= 6)
                                    <div class="active">Final QA/CQA Review </div>
                                @else
                                    <div class="">Final QA/CQA Review </div>
                                @endif
                                @if ($data->stage >= 7)
                                    <div class="active">QAH/CQAH Final Review</div>
                                @else
                                    <div class="">QAH/CQAH Final Review</div>
                                @endif
                                @if ($data->stage >= 8)
                                    <div class="bg-danger">Closed - Done</div>
                                @else
                                    <div class="">Closed - Done</div>
                                @endif
                            </div>
                        @endif


                    </div>

                </div>
            </div>


            <div id="change-control-fields">

                <div class="container-fluid">

                    <!-- Tab links -->
                    <div class="cctab">
                        <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">General Information</button>
                        <button class="cctablinks" onclick="openCity(event, 'CCForm5')">Investigation</button>
                        <button class="cctablinks" onclick="openCity(event, 'CCForm4')">QA Review</button>
                        <button class="cctablinks" onclick="openCity(event, 'CCForm2')">Investigation & Root Cause</button>
                        {{-- <button class="cctablinks" onclick="openCity(event, 'CCForm9')">Investigation & Root Cause</button> --}}
                        <button class="cctablinks" onclick="openCity(event, 'CCForm10')">HOD Final Review</button>
                        <button class="cctablinks" onclick="openCity(event, 'CCForm11')">QA Final Review</button>
                        <button class="cctablinks" onclick="openCity(event, 'CCForm12')">QAH/CQAH Final Review</button>




                        <!-- {{-- <button class="cctablinks" onclick="openCity(event, 'CCForm4')">Environmental Monitoring</button> --}}
                                                                                                                                                                                                                                                                                                                                                                        {{-- <button class="cctablinks" onclick="openCity(event, 'CCForm5')">Lab Investigation Remark</button> --}}
                                                                                                                                                                                                                                                                                                                                                                        {{-- <button class="cctablinks" onclick="openCity(event, 'CCForm6')">QC Head/Designee Eval Comments</button> --}} -->
                        <button class="cctablinks" onclick="openCity(event, 'CCForm7')">Activity Log</button>
                    </div>

                    <form action="{{ route('root_update', $data->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div id="step-form">

                            <div id="CCForm1" class="inner-block cctabcontent">
                                <div class="inner-block-content">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="RLS Record Number"><b>Record Number</b></label>
                                                <input disabled type="text" name="record_number"
                                                    value="{{ Helpers::getDivisionName(session()->get('division')) }}/RCA/{{ date('Y') }}/{{ str_pad($data->record, 4, '0', STR_PAD_LEFT) }}">
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Division Code"><b>Site/Location Code</b></label>
                                                <input readonly type="text" name="division_code"
                                                    {{ $data->stage == 0 || $data->stage == 11 ? 'disabled' : '' }}
                                                    value="{{ Helpers::getDivisionName($data->division_id) }}">
                                                {{-- <div class="static">{{ Helpers::getDivisionName(session()->get('division')) }}</div> --}}
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Initiator"><b>Initiator</b></label>
                                                <input type="hidden" name="initiator_id">
                                                {{-- <div class="static">{{ $data->initiator_name }} </div> --}}
                                                <input disabled type="text" value="{{ $data->initiator_name }} ">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input ">
                                                <label for="Date Due"><b>Date of Initiation</b></label>
                                                <input disabled type="text" value="{{ date('d-M-Y') }}"
                                                    name="intiation_date">
                                                <input type="hidden" value="{{ date('d-m-Y') }}" name="intiation_date">
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Initiator Group">Initiator Department </label>
                                                <select name="initiator_Group"
                                                    {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}
                                                    id="initiator_group">
                                                    {{-- <option value="0">-- Select --</option> --}}
                                                    <option value="">-- Select --</option>
                                                    <option value="CQA"
                                                        @if ($data->initiator_Group == 'CQA') selected @endif>Corporate Quality
                                                        Assurance</option>
                                                    <option value="QA"
                                                        @if ($data->initiator_Group == 'QA') selected @endif>Quality Assurance
                                                    </option>
                                                    <option value="QC"
                                                        @if ($data->initiator_Group == 'QC') selected @endif>Quality Control
                                                    </option>
                                                    <option value="QCM"
                                                        @if ($data->initiator_Group == 'QCM') selected @endif>Quality Control
                                                        (Microbiology department)
                                                    </option>
                                                    <option value="PG"
                                                        @if ($data->initiator_Group == 'PG') selected @endif>Production
                                                        General</option>
                                                    <option value="PL"
                                                        @if ($data->initiator_Group == 'PL') selected @endif>Production Liquid
                                                        Orals</option>
                                                    <option value="PT"
                                                        @if ($data->initiator_Group == 'PT') selected @endif>Production Tablet
                                                        and Powder</option>
                                                    <option value="PE"
                                                        @if ($data->initiator_Group == 'PE') selected @endif>Production
                                                        External (Ointment, Gels, Creams and Liquid)</option>
                                                    <option value="PC"
                                                        @if ($data->initiator_Group == 'PC') selected @endif>Production
                                                        Capsules</option>
                                                    <option value="PI"
                                                        @if ($data->initiator_Group == 'PI') selected @endif>Production
                                                        Injectable</option>
                                                    <option value="EN"
                                                        @if ($data->initiator_Group == 'EN') selected @endif>Engineering
                                                    </option>
                                                    <option value="HR"
                                                        @if ($data->initiator_Group == 'HR') selected @endif>Human Resource
                                                    </option>
                                                    <option value="ST"
                                                        @if ($data->initiator_Group == 'ST') selected @endif>Store</option>
                                                    <option value="ED"
                                                        @if ($data->initiator_Group == 'EP') selected @endif>Electronic Data
                                                        Processing
                                                    </option>
                                                    <option value="FD"
                                                        @if ($data->initiator_Group == 'FD') selected @endif>Formulation
                                                        Development
                                                    </option>
                                                    <option value="AL"
                                                        @if ($data->initiator_Group == 'AL') selected @endif>Analytical
                                                        research and Development Laboratory
                                                    </option>
                                                    <option value="PD"
                                                        @if ($data->initiator_Group == 'PD') selected @endif>Packaging
                                                        Development
                                                    </option>

                                                    <option value="PU"
                                                        @if ($data->initiator_Group == 'PD') selected @endif>Purchase
                                                        Department
                                                    </option>
                                                    <option value="DC"
                                                        @if ($data->initiator_Group == 'DC') selected @endif>Document Cell
                                                    </option>
                                                    <option value="RA"
                                                        @if ($data->initiator_Group == 'RA') selected @endif>Regulatory
                                                        Affairs
                                                    </option>
                                                    <option value="PV"
                                                        @if ($data->initiator_Group == 'PV') selected @endif>
                                                        Pharmacovigilance
                                                    </option>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Initiator Group Code">Initiator Department Code</label>
                                                <input readonly type="text"
                                                    name="initiator_group_code"{{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}
                                                    value="{{ $data->initiator_Group }}" id="initiator_group_code"
                                                    readonly>
                                                {{-- <div class="static"></div> --}}
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
                                                    maxlength="255" required
                                                    {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}
                                                    value="{{ $data->short_description }}">
                                                    @component('frontend.forms.language-model')
                                                @endcomponent
                                                </div>
                                            </div>
                                            <p id="docnameError" style="color:red">**Short Description is required</p>

                                        </div>
{{--
                                        <div class="col-md-6">
                                            <div class="group-input">
                                                <label for="due-date">Due Date <span class="text-danger"></span></label>
                                                <div><small class="text-primary">If revising Due Date, kindly mention revision reason in "Due Date Extension Justification" data field.</small></div>
                                                <input readonly type="text" {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}
                                                    value="{{ Helpers::getdateFormat($data->due_date) }}"  
                                                    name="due_date">

                                            </div>
                                        </div>--}}


                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="severity-level">Severity Level</label>
                                                <span class="text-primary">Severity levels in a QMS record gauge issue
                                                    seriousness, guiding priority for corrective actions. Ranging from low
                                                    to
                                                    high, they ensure quality standards and mitigate critical risks.</span>
                                                <select {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}
                                                    name="severity_level">
                                                    <option value="0">-- Select --</option>
                                                    <option @if ($data->severity_level == 'minor') selected @endif
                                                        value="minor">
                                                        Minor</option>
                                                    <option @if ($data->severity_level == 'major') selected @endif
                                                        value="major">
                                                        Major</option>
                                                    <option @if ($data->severity_level == 'critical') selected @endif
                                                        value="critical">Critical</option>
                                                </select>
                                                {{-- <option value="minor">Minor</option>
                                                    <option value="major">Major</option>
                                                    <option value="critical">Critical</option>
                                                </select> --}}
                                            </div>
                                        </div>
                                        {{--  <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="search">
                                                    Assigned To <span class="text-danger"></span>
                                                </label>
                                                <select id="select-state" placeholder="Select..." name="assign_to"
                                                    {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}  required>
                                                    <option value="">Select a value</option>
                                                    @foreach ($users as $key => $value)
                                                        <option value="{{ $value->id }}"
                                                            @if ($data->assign_to == $value->id) selected @endif>
                                                            {{ $value->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('assign_to')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>  --}}

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

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="select-state">Department Head <span
                                                        class="text-danger">*</span></label>
                                                <select id="select-state" placeholder="Select..." name="assign_to"
                                                    {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}
                                                    required>
                                                    <option value="">Select a value</option>
                                                    @foreach ($users as $key => $value)
                                                        <option value="{{ $value->id }}"
                                                            @if ($data->assign_to == $value->id) selected @endif>
                                                            {{ $value->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('assign_to')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="select-state">QA Reviewer <span
                                                        class="text-danger">*</span></label>
                                                <select id="select-state" placeholder="Select..." name="qa_reviewer"
                                                    {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}
                                                    required>
                                                    <option value="">Select a value</option>
                                                    @foreach ($users as $key => $value)
                                                        <option value="{{ $value->id }}"
                                                            @if ($data->qa_reviewer == $value->id) selected @endif>
                                                            {{ $value->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('qa_reviewer')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>


                                        <div class="col-lg-6 new-date-data-field">
                                            <div class="group-input input-date">
                                                <label for="Due Date"> Due Date</label>
                                                <div><small class="text-primary">If revising Due Date, kindly mention
                                                        revision
                                                        reason in "Due Date Extension Justification" data field.</small>
                                                </div>
                                                <div class="calenderauditee">
                                                    <input disabled type="text" id="due_date" readonly
                                                        placeholder="DD-MMM-YYYY"
                                                        value="{{ $data->due_date ? \Carbon\Carbon::parse($data->due_date)->format('d-M-Y') : '' }}" />
                                                    <input type="date" name="due_date"
                                                        {{ $data->stage == 0 || $data->stage > 1 ? 'disabled' : '' }}
                                                        min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                                        value="{{ Helpers::getdateFormat($data->due_date) }}"
                                                        class="hide-input" oninput="handleDateInput(this, 'due_date')" />
                                                </div>
                                                {{-- <input type="text" id="due_date" name="due_date"
                                                    placeholder="DD-MMM-YYYY" value="{{ Helpers::getdateFormat($data->due_date) }}"min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" />
                                                <!-- <input type="date" name="due_date" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : ''}} min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" --> --}}

                                            </div>
                                        </div>











                                        <!-- <div class="col-lg-6">
                                                                                                                                                                                                                                                                                                                                                                                            <div class="group-input">
                                                                                                                                                                                                                                                                                                                                                                                                <label for="Initiator Group"><b>Initiator Group</b></label>
                                                                                                                                                                                                                                                                                                                                                                                                <select name="initiatorGroup" {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}
                                                                                                                                                                                                                                                                                                                                                                                                    id="initiator-group">
                                                                                                                                                                                                                                                                                                                                                                                                    <option value="CQA"
                                                                                                                                                                                                                                                                                                                                                                                                        @if ($data->initiatorGroup == 'CQA') selected @endif>Corporate
                                                                                                                                                                                                                                                                                                                                                                                                        Quality Assurance</option>
                                                                                                                                                                                                                                                                                                                                                                                                    <option value="QAB"
                                                                                                                                                                                                                                                                                                                                                                                                        @if ($data->initiatorGroup == 'QAB') selected @endif>Quality
                                                                                                                                                                                                                                                                                                                                                                                                        Assurance Biopharma</option>
                                                                                                                                                                                                                                                                                                                                                                                                    <option value="CQC"
                                                                                                                                                                                                                                                                                                                                                                                                        @if ($data->initiatorGroup == 'CQC') selected @endif>Central
                                                                                                                                                                                                                                                                                                                                                                                                        Quality Control</option>
                                                                                                                                                                                                                                                                                                                                                                                                    <option value="CQC"
                                                                                                                                                                                                                                                                                                                                                                                                        @if ($data->initiatorGroup == 'CQC') selected @endif>Manufacturing
                                                                                                                                                                                                                                                                                                                                                                                                    </option>
                                                                                                                                                                                                                                                                                                                                                                                                    <option value="PSG"
                                                                                                                                                                                                                                                                                                                                                                                                        @if ($data->initiatorGroup == 'PSG') selected @endif>Plasma
                                                                                                                                                                                                                                                                                                                                                                                                        Sourcing Group</option>
                                                                                                                                                                                                                                                                                                                                                                                                    <option value="CS"
                                                                                                                                                                                                                                                                                                                                                                                                        @if ($data->initiatorGroup == 'CS') selected @endif>Central
                                                                                                                                                                                                                                                                                                                                                                                                        Stores</option>
                                                                                                                                                                                                                                                                                                                                                                                                    <option value="ITG"
                                                                                                                                                                                                                                                                                                                                                                                                        @if ($data->initiatorGroup == 'ITG') selected @endif>Information
                                                                                                                                                                                                                                                                                                                                                                                                        Technology Group</option>
                                                                                                                                                                                                                                                                                                                                                                                                    <option value="MM"
                                                                                                                                                                                                                                                                                                                                                                                                        @if ($data->initiatorGroup == 'MM') selected @endif>Molecular
                                                                                                                                                                                                                                                                                                                                                                                                        Medicine</option>
                                                                                                                                                                                                                                                                                                                                                                                                    <option value="CL"
                                                                                                                                                                                                                                                                                                                                                                                                        @if ($data->initiatorGroup == 'CL') selected @endif>Central
                                                                                                                                                                                                                                                                                                                                                                                                        Laboratory</option>
                                                                                                                                                                                                                                                                                                                                                                                                    <option value="TT"
                                                                                                                                                                                                                                                                                                                                                                                                        @if ($data->initiatorGroup == 'TT') selected @endif>Tech
                                                                                                                                                                                                                                                                                                                                                                                                        team</option>
                                                                                                                                                                                                                                                                                                                                                                                                    <option value="QA"
                                                                                                                                                                                                                                                                                                                                                                                                        @if ($data->initiatorGroup == 'QA') selected @endif>Quality
                                                                                                                                                                                                                                                                                                                                                                                                        Assurance</option>
                                                                                                                                                                                                                                                                                                                                                                                                    <option value="QM"
                                                                                                                                                                                                                                                                                                                                                                                                        @if ($data->initiatorGroup == 'QM') selected @endif>Quality
                                                                                                                                                                                                                                                                                                                                                                                                        Management</option>
                                                                                                                                                                                                                                                                                                                                                                                                    <option value="IA"
                                                                                                                                                                                                                                                                                                                                                                                                        @if ($data->initiatorGroup == 'IA') selected @endif>IT
                                                                                                                                                                                                                                                                                                                                                                                                        Administration</option>
                                                                                                                                                                                                                                                                                                                                                                                                    <option value="ACC"
                                                                                                                                                                                                                                                                                                                                                                                                        @if ($data->initiatorGroup == 'ACC') selected @endif>Accounting
                                                                                                                                                                                                                                                                                                                                                                                                    </option>
                                                                                                                                                                                                                                                                                                                                                                                                    <option value="LOG"
                                                                                                                                                                                                                                                                                                                                                                                                        @if ($data->initiatorGroup == 'LOG') selected @endif>Logistics
                                                                                                                                                                                                                                                                                                                                                                                                    </option>
                                                                                                                                                                                                                                                                                                                                                                                                    <option value="SM"
                                                                                                                                                                                                                                                                                                                                                                                                        @if ($data->initiatorGroup == 'SM') selected @endif>Senior
                                                                                                                                                                                                                                                                                                                                                                                                        Management</option>
                                                                                                                                                                                                                                                                                                                                                                                                    <option value="BA"
                                                                                                                                                                                                                                                                                                                                                                                                        @if ($data->initiatorGroup == 'BA') selected @endif>Business
                                                                                                                                                                                                                                                                                                                                                                                                        Administration</option>

                                                                                                                                                                                                                                                                                                                                                                                                </select>
                                                                                                                                                                                                                                                                                                                                                                                            </div>
                                                                                                                                                                                                                                                                                                                                                                                        </div>
                                                                                                                                                                                                                                                                                                                                                                                        <div class="col-lg-6">
                                                                                                                                                                                                                                                                                                                                                                                            <div class="group-input">
                                                                                                                                                                                                                                                                                                                                                                                                <label for="Initiator Group Code">Initiator Group Code</label>
                                                                                                                                                                                                                                                                                                                                                                                                <input type="text" name="initiator_group_code"
                                                                                                                                                                                                                                                                                                                                                                                                    {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}
                                                                                                                                                                                                                                                                                                                                                                                                    value="{{ $data->initiator_Group }}" disabled>
                                                                                                                                                                                                                                                                                                                                                                                            </div>
                                                                                                                                                                                                                                                                                                                                                                                        </div>
                                                                                                                                                                                                                                                                                                                                                                                        <div class="col-12">
                                                                                                                                                                                                                                                                                                                                                                                            <div class="group-input">
                                                                                                                                                                                                                                                                                                                                                                                                <label for="Short Description">Short Description <span
                                                                                                                                                                                                                                                                                                                                                                                                        class="text-danger">*</span></label>
                                                                                                                                                                                                                                                                                                                                                                                                <div><small class="text-primary">Please mention brief summary</small></div>
                                                                                                                                                                                                                                                                                                                                                                                                <textarea name="short_description" {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>{{ $data->short_description }}</textarea>
                                                                                                                                                                                                                                                                                                                                                                                            </div>
                                                                                                                                                                                                                                                                                                                                                                                        </div> -->
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Initiator Group">Initiated Through</label>
                                                <div><small class="text-primary">Please select related information</small>
                                                </div>
                                                <select {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}
                                                    name="initiated_through"
                                                    onchange="otherController(this.value, 'others', 'initiated_through_req')">
                                                    <option value="">-- select --</option>
                                                    <option @if ($data->initiated_through == 'recall') selected @endif
                                                        value="recall">
                                                        Recall</option>
                                                    <option @if ($data->initiated_through == 'return') selected @endif
                                                        value="return">
                                                        Return</option>
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
                                                        value="others">
                                                        Others</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input" id="initiated_through_req">
                                                <label for="If Other">Others<span
                                                        class="text-danger d-none">*</span></label>
                                                        <div class="relative-container">
                                                <textarea {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }} class="tiny" name="initiated_if_other">{{ $data->initiated_if_other }}</textarea>
                                                @component('frontend.forms.language-model')
                                                @endcomponent
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Type">Type</label>
                                                <select name="Type" id="Type"
                                                    {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>
                                                    <option value="">-- Select --</option>

                                                    <option value="Process"
                                                        @if ($data->Type == 'Process') selected @endif>Process</option>
                                                    <option value="Document"
                                                        @if ($data->Type == 'Document') selected @endif>Document
                                                    </option>
                                                    <option value="Equipment"
                                                        @if ($data->Type == 'Equipment') selected @endif>Equipment
                                                    </option>
                                                    <option value="Instrument"
                                                        @if ($data->Type == 'Instrument') selected @endif>Instrument
                                                    </option>


                                                    <option value="Facilities"
                                                        @if ($data->Type == 'Facilities') selected @endif>Facilities
                                                    </option>
                                                    <option value="Other"
                                                        @if ($data->Type == 'Other') selected @endif>
                                                        Other</option>
                                                    <option value="Stability"
                                                        @if ($data->Type == 'Stability') selected @endif>Stability
                                                    </option>
                                                    <option value="Raw Material"
                                                        @if ($data->Type == 'Raw Material') selected @endif>Raw Material
                                                    </option>
                                                    <option value="Clinical Production"
                                                        @if ($data->Type == 'Clinical Production') selected @endif>Clinical
                                                        Production
                                                    </option>
                                                    <option value="Commercial Production"
                                                        @if ($data->Type == 'Commercial Production') selected @endif>Commercial
                                                        Production</option>
                                                    <option value="Labeling"
                                                        @if ($data->Type == 'Labeling') selected @endif>Labeling
                                                    </option>
                                                    <option value="Laboratory"
                                                        @if ($data->Type == 'Laboratory') selected @endif>Laboratory
                                                    </option>
                                                    <option value="Utilities"
                                                        @if ($data->Type == 'Utilities') selected @endif>Utilities
                                                    </option>
                                                    <option value="Validation"
                                                        @if ($data->Type == 'Validation') selected @endif>Validation
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        {{--  <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="priority_level">Priority Level</label>
                                                <div><small class="text-primary">Choose high if Immidiate actions are
                                                        </small></div>

                                                <select {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }} name="priority_level">
                                                    
                                                    <option value="0">-- Select --</option>
                                                    <option @if ($data->priority_level == 'low') selected @endif
                                                    value="low">Low</option>
                                                    <option  @if ($data->priority_level == 'medium') selected @endif
                                                    value="medium">Medium</option>
                                                    <option @if ($data->priority_level == 'high') selected @endif
                                                    value="high">High</option>
                                                </select>
                                            </div>
                                        </div>  --}}
                                        {{-- <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="investigators">Additional Investigators</label>
                                                <select  name="investigators" placeholder="Select Investigators"
                                                {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}  name="investigators" placeholder="Select Investigators"
                                                    data-search="false" data-silent-initial-value-set="true" id="investigators">
                                                    <option value="">Select Investigators</option>
                                                    <option @if ($data->investigators == '1') selected @endif value="1">Amit Guru</option>
                                                    <option @if ($data->investigators == '2') selected @endif value="2">Shaleen Mishra</option>
                                                    <option @if ($data->investigators == '3') selected @endif value="3">Madhulika Mishra</option>
                                                    <option @if ($data->investigators == '4') selected @endif value="4"> Patel</option>
                                                    <option @if ($data->investigators == '5') selected @endif value="5">Harsh Mishra</option>
                                                </select>
                                            </div>
                                        </div> --}}

                                        <div class="col-lg-12">
                                            <div class="group-input">
                                                <label for="department">Responsible Department</label>
                                                @php
                                                    $storedDepartments = $data->department; // Ensure this field name matches your database column
                                                    $selectedDepartments = explode(',', $storedDepartments);
                                                    // Split the comma-separated string into an array

                                                    // dd($selectedDepartments);
                                                @endphp

                                                <select multiple name="departments[]" placeholder="Select Department(s)"
                                                    data-search="false" data-silent-initial-value-set="true"
                                                    id="department"
                                                    {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>
                                                    <option value="Work Instruction"
                                                        @if (in_array('Work Instruction', $selectedDepartments)) selected @endif>Work Instruction
                                                    </option>
                                                    <option value="Quality Assurance"
                                                        @if (in_array('Quality Assurance', $selectedDepartments)) selected @endif>Quality
                                                        Assurance
                                                    </option>
                                                    <option value="Specifications"
                                                        @if (in_array('Specifications', $selectedDepartments)) selected @endif>Specifications
                                                    </option>
                                                    <option value="Production"
                                                        @if (in_array('Production', $selectedDepartments)) selected @endif>Production
                                                    </option>
                                                </select>
                                            </div>
                                        </div>


                                        <div class="col-12">
                                            <div class="sub-head">Investigation details</div>
                                        </div>
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="description">Description</label>
                                                <div class="relative-container">
                                                <textarea name="description" {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }} class="tiny">{{ $data->description }}</textarea>
                                                @component('frontend.forms.language-model')
                                                @endcomponent
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="comments">Comments</label>
                                                <div class="relative-container">
                                                <textarea name="comments"{{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }} class="tiny">{{ $data->comments }}</textarea>
                                                @component('frontend.forms.language-model')
                                                @endcomponent
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Inv Attachments">Initial Attachment</label>
                                                <div>
                                                    <small class="text-primary">
                                                        Please Attach all relevant or supporting documents
                                                    </small>
                                                </div>
                                                <div class="file-attachment-field">
                                                    <div disabled class="file-attachment-list"
                                                        id="root_cause_initial_attachment">
                                                        @if ($data->root_cause_initial_attachment)
                                                            @foreach (json_decode($data->root_cause_initial_attachment) as $file)
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

                                                        <input type="file" id="myfile"
                                                            name="root_cause_initial_attachment[]"{{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}
                                                            oninput="addMultipleFiles(this, 'root_cause_initial_attachment')"
                                                            multiple>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- <div class="col-12">
                                                                                                                                                                                                                                                                                                                                                                                            <div class="group-input">
                                                                                                                                                                                                                                                                                                                                                                                                <label for="severity-level">Sevrity Level</label>
                                                                                                                                                                                                                                                                                                                                                                                                <select name="severity-level">
                                                                                                                                                                                                                                                                                                                                                                                                    <option value="0">-- Select --</option>
                                                                                                                                                                                                                                                                                                                                                                                                    <option value="minor">Minor</option>
                                                                                                                                                                                                                                                                                                                                                                                                    <option value="major">Major</option>
                                                                                                                                                                                                                                                                                                                                                                                                    <option value="critical">Critical</option>
                                                                                                                                                                                                                                                                                                                                                                                                </select>
                                                                                                                                                                                                                                                                                                                                                                                            </div>
                                                                                                                                                                                                                                                                                                                                                                                        </div>  -->

                                        {{--  <div class="col-12">
                                <div class="group-input">
                                <label for="related_url">Related URL</label>
                            <input name="related_url" {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }} value="{{ $data->related_url }}">
                        </div>  --}}
                                    </div>

                                    <div class="button-block">
                                        <button type="submit" id="ChangesaveButton" class="saveButton" {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>Save</button>
                                        <button type="button" id="ChangeNextButton" class="nextButton">Next</button>
                                        <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}"
                                                class="text-white"> Exit </a> </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="CCForm5" class="inner-block cctabcontent">
                            <div class="inner-block-content">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="group-input">
                                            <label for="objective">Objective</label>
                                            <div class="relative-container">
                                            <textarea name="objective"{{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }} class="tiny">{{ $data->objective }}</textarea>
                                            @component('frontend.forms.language-model')
                                                @endcomponent
                                                </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="group-input">
                                            <label for="scope">Scope</label>
                                            <div class="relative-container">
                                            <textarea name="scope"{{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }} class="tiny">{{ $data->scope }}</textarea>
                                            @component('frontend.forms.language-model')
                                                @endcomponent
                                                </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="group-input">
                                            <label for="problem_statement">Problem Statement</label>
                                            <div class="relative-container">
                                            <textarea name="problem_statement_rca"{{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }} class="tiny">{{ $data->problem_statement_rca }}</textarea>
                                            @component('frontend.forms.language-model')
                                                @endcomponent
                                                </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="group-input">
                                            <label for="requirement">Background</label>
                                            <div class="relative-container">
                                            <textarea name="requirement"{{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }} class="tiny">{{ $data->requirement }}</textarea>
                                            @component('frontend.forms.language-model')
                                                @endcomponent
                                                </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="group-input">
                                            <label for="immediate_action">Immediate Action</label>
                                            <div class="relative-container">
                                            <textarea name="immediate_action"{{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }} class="tiny">{{ $data->immediate_action }}</textarea>
                                            @component('frontend.forms.language-model')
                                                @endcomponent
                                                </div>
                                        </div>
                                    </div>
                                    {{-- <div class="col-lg-12">
                                        <div class="group-input">
                                            <label for="investigation_team">Investigation Team</label>
                                            <select id="investigation_team" name="investigation_team"
                                                {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}
                                                class="form-control">
                                                <option value="">Select a member of the Investigation Team</option>
                                                @foreach ($users as $user)
                                                    <option value="{{ $user->id }}"
                                                        @if ($data->investigation_team == $user->id) selected @endif>
                                                        {{ $user->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('investigation_team')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div> --}}
                                    {{--<div class="col-lg-12">
                                        <div class="group-input">
                                            <label for="investigation_team">Investigation Team</label>
                                            <select id="investigation_team" name="investigation_team[]" multiple
                                                {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}
                                                class="form-control">
                                                <option value="">Select members of the Investigation Team</option>
                                                @foreach ($users as $user)
                                                    <option value="{{ $user->id }}" 
                                                        {{ in_array($user->id, explode(',', $data->investigation_team ?? '')) ? 'selected' : '' }}>
                                                        {{ $user->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('investigation_team')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>--}}


                                    <div class="col-lg-12">
                                        <div class="group-input">
                                            <label for="investigation_team">Investigation Team</label>
                                    
                                            <select name="investigation_team[]" id="investigation_team" multiple 
                                            {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>
                                                <option value="">Select a value</option>
                                                @if ($users->isNotEmpty())
                                                    @foreach ($users as $value)
                                                        <option 
                                                            {{ in_array($value->name, (array) old('investigation_team', explode(',', $data->investigation_team))) ? 'selected' : '' }} 
                                                            value="{{ $value->name }}">
                                                            {{ $value->name }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="group-input">
                                            <label for="root-cause-methodology">Root Cause Methodology</label>
                                            @php
                                                $selectedMethodologies = explode(',', $data->root_cause_methodology);
                                            @endphp
                                            <select name="root_cause_methodology[]" multiple
                                                {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}
                                                id="root-cause-methodology">
                                                <option value="Why-Why Chart"
                                                    @if (in_array('Why-Why Chart', $selectedMethodologies)) selected @endif>Why-Why Chart
                                                </option>
                                                <option value="Failure Mode and Effect Analysis"
                                                    @if (in_array('Failure Mode and Effect Analysis', $selectedMethodologies)) selected @endif>Failure Mode and
                                                    Effect
                                                    Analysis</option>
                                                <option value="Fishbone or Ishikawa Diagram"
                                                    @if (in_array('Fishbone or Ishikawa Diagram', $selectedMethodologies)) selected @endif>Fishbone or Ishikawa
                                                    Diagram</option>
                                                <option value="Is/Is Not Analysis"
                                                    @if (in_array('Is/Is Not Analysis', $selectedMethodologies)) selected @endif>Is/Is Not Analysis
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="group-input">
                                            <label for="root_cause">
                                                Root Cause
                                                <button type="button"
                                                    onclick="add4Input_case('root-cause-first-table')"{{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>+</button>
                                            </label>
                                            <div class="table-responsive">
                                                <table class="table table-bordered" id="root-cause-first-table">
                                                    <thead>
                                                        <tr>
                                                            <th style="width:5%">Row #</th>
                                                            <th>Root Cause Category</th>
                                                            <th>Root Cause Sub-Category</th>
                                                            <th>Probability</th>
                                                            <th>Remarks</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if (!empty($data->Root_Cause_Category))
                                                            @foreach (unserialize($data->Root_Cause_Category) as $key => $Root_Cause_Category)
                                                                <tr>
                                                                    <td><input disabled type="text"
                                                                            name="serial_number[]"{{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}
                                                                            value="{{ $key + 1 }}">
                                                                    </td>
                                                                    <td><input type="text"
                                                                            name="Root_Cause_Category[]"{{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}
                                                                            value="{{ unserialize($data->Root_Cause_Category)[$key] ? unserialize($data->Root_Cause_Category)[$key] : '' }}">
                                                                    </td>
                                                                    <td><input type="text"
                                                                            name="Root_Cause_Sub_Category[]"{{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}
                                                                            value="{{ unserialize($data->Root_Cause_Sub_Category)[$key] ? unserialize($data->Root_Cause_Sub_Category)[$key] : '' }}">
                                                                    </td>
                                                                    <td><input type="text"
                                                                            name="Probability[]"{{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}
                                                                            value="{{ unserialize($data->Probability)[$key] ? unserialize($data->Probability)[$key] : '' }}">
                                                                    </td>
                                                                    <td><input type="text"
                                                                            name="Remarks[]"{{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}
                                                                            value="{{ unserialize($data->Remarks)[$key] ?? null }}">
                                                                    </td>
                                                                    <td><button type="text" class="removeRowBtn"
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

                                    {{--  <div class="col-12 sub-head"></div>  --}}
                                    <div class="col-12 mb-4" id="fmea-section" style="display:none;">

                                        <div class="group-input">
                                            <label for="agenda">
                                                Failure Mode and Effect Analysis<button type="button" name="agenda"
                                                    onclick="addRootCauseAnalysisRiskAssessment1('risk-assessment-risk-management')"{{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>+</button>
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
                                                                PQ)
                                                            </th>
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
                                                                            {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>
                                                                    </td>
                                                                    <td><input name="risk_element[]" type="text"
                                                                            value="{{ unserialize($data->risk_element)[$key] ?? null }}"
                                                                            {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>
                                                                    </td>
                                                                    <td><input name="problem_cause[]" type="text"
                                                                            value="{{ unserialize($data->problem_cause)[$key] ?? null }}"
                                                                            {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>
                                                                    </td>
                                                                    <td><input name="existing_risk_control[]"
                                                                            type="text"
                                                                            value="{{ unserialize($data->existing_risk_control)[$key] ?? null }}"
                                                                            {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>
                                                                    </td>
                                                                    <td>
                                                                        <select onchange="calculateInitialResult(this)"
                                                                            class="fieldR" name="initial_severity[]"
                                                                            {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>
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
                                                                        </select>
                                                                    </td>
                                                                    <td>
                                                                        <select onchange="calculateInitialResult(this)"
                                                                            class="fieldP" name="initial_detectability[]"
                                                                            {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>
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
                                                                        </select>
                                                                    </td>
                                                                    <td>
                                                                        <select onchange="calculateInitialResult(this)"
                                                                            class="fieldN" name="initial_probability[]"
                                                                            {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>
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
                                                                        </select>
                                                                    </td>
                                                                    <td>
                                                                        <input name="initial_rpn[]" class='initial-rpn'
                                                                            disabled="text"
                                                                            value="{{ unserialize($data->initial_rpn)[$key] ?? null }}">
                                                                    </td>
                                                                    <td>
                                                                        <select onchange="calculateInitialResult(this)"
                                                                            class="fieldR" name="risk_acceptance[]"
                                                                            {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>
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
                                                                            {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>
                                                                    </td>
                                                                    <td>
                                                                        <select onchange="calculateResidualResult(this)"
                                                                            class="residual-fieldR"
                                                                            name="residual_severity[]"
                                                                            {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>
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
                                                                        </select>
                                                                    </td>
                                                                    <td>
                                                                        <select onchange="calculateResidualResult(this)"
                                                                            class="residual-fieldP"
                                                                            name="residual_probability[]"
                                                                            {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>
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
                                                                        </select>
                                                                    </td>
                                                                    <td>
                                                                        <select onchange="calculateResidualResult(this)"
                                                                            class="residual-fieldN"
                                                                            name="residual_detectability[]"
                                                                            {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>
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
                                                                        </select>
                                                                    </td>
                                                                    <td>
                                                                        <input name="residual_rpn[]" class='residual-rpn'
                                                                            disabled="text"
                                                                            value="{{ unserialize($data->residual_rpn)[$key] ?? null }}">
                                                                    </td>
                                                                    <td>
                                                                        <select onchange="calculateInitialResult(this)"
                                                                            class="fieldR" name="risk_acceptance2[]"
                                                                            {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>
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
                                                                            {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>
                                                                    </td>
                                                                    <td><button type="text" class="removeRowBtn"
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
                                    {{--  <div class="col-12 sub-head"></div>  --}}
                                    <div class="col-12" id="fishbone-section" style="display:none;">
                                        <div class="group-input">
                                            <label for="fishbone">
                                                Fishbone or Ishikawa Diagram
                                                <button type="button" name="agenda"
                                                    onclick="addFishBone('.top-field-group', '.bottom-field-group')" {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>+</button>
                                                <button type="button" name="agenda" class="fishbone-del-btn" {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}
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
                                                            @if (!empty($data->measurement))
                                                                @foreach (unserialize($data->measurement) as $key => $measure)
                                                                    <div><input type="text"
                                                                            value="{{ $measure }}"
                                                                            name="measurement[]"{{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>
                                                                    </div>
                                                                    <div><input type="text"
                                                                            value="{{ unserialize($data->materials)[$key] ? unserialize($data->materials)[$key] : '' }}"
                                                                            name="materials[]"{{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>
                                                                    </div>
                                                                    <div><input type="text"
                                                                            value="{{ unserialize($data->methods)[$key] ?? null }}"
                                                                            name="methods[]"{{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>
                                                                    </div>
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="mid"></div>
                                                    <div class="bottom-field-group">
                                                        <div class="grid-field fields bottom-field">
                                                            @if (!empty($data->environment))
                                                                @foreach (unserialize($data->environment) as $key => $measure)
                                                                    <div><input type="text"
                                                                            value="{{ $measure }}"
                                                                            name="environment[]"{{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>
                                                                    </div>
                                                                    <div><input type="text"
                                                                            value="{{ unserialize($data->manpower)[$key] ? unserialize($data->manpower)[$key] : '' }}"
                                                                            name="manpower[]"{{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>
                                                                    </div>
                                                                    <div><input type="text"
                                                                            value="{{ unserialize($data->machine)[$key] ? unserialize($data->machine)[$key] : '' }}"
                                                                            name="machine[]"{{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>
                                                                    </div>
                                                                @endforeach
                                                            @endif

                                                        </div>
                                                    </div>
                                                    <div class="grid-field field-name">
                                                        <div>Environment</div>
                                                        <div>Manpower</div>
                                                        <div>Machine</div>
                                                    </div>
                                                </div>
                                                <div class="right-group">
                                                    <div class="field-name">
                                                        Problem Statement
                                                    </div>
                                                    <div class="field">
                                                        <textarea name="problem_statement"{{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>{{ $data->problem_statement }}</textarea>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- HTML -->
                                    {{--<button id="add-field-btn" 
                                    onclick="addWhyField('container-class', 'fieldName')" 
                                    style="cursor: pointer;">+</button>--}}
{{--
                                    <script>
                                    function addWhyField(containerClass, fieldName) {
                                    // Check if the stage is 0 or 8
                                    if (stage == 0 || stage == 8) {
                                        alert("Adding fields is disabled for this stage.");
                                        return;
                                    }

                                    let container = document.querySelector('.' + containerClass);

                                    // Create the textarea
                                    let textarea = document.createElement('textarea');
                                    textarea.name = fieldName;

                                    // Create the remove button
                                    let removeButton = document.createElement('span');
                                    removeButton.innerText = 'Remove';
                                    removeButton.style.cursor = 'pointer';
                                    removeButton.style.color = 'red';
                                    removeButton.onclick = function () {
                                        removeWhyField(this);
                                    };

                                    // Create a wrapper for the textarea and the remove button
                                    let fieldWrapper = document.createElement('div');
                                    fieldWrapper.classList.add('why-field-wrapper');
                                    fieldWrapper.appendChild(textarea);
                                    fieldWrapper.appendChild(removeButton);

                                    // Append the new field wrapper to the container
                                    container.appendChild(fieldWrapper);
                                    }

                                    function removeWhyField(button) {
                                    let fieldWrapper = button.parentNode; // Get the wrapper div
                                    fieldWrapper.remove(); // Remove the wrapper div, which removes the textarea and the remove button
                                    }

                                    // Set the stage dynamically (example: replace this with your actual logic)
                                    let stage = 0;

                                    // Disable the button in stages 0 or 8
                                    document.addEventListener("DOMContentLoaded", function () {
                                    const addFieldBtn = document.getElementById("add-field-btn");
                                    if (stage == 0 || stage == 8) {
                                        addFieldBtn.style.cursor = "not-allowed";
                                        addFieldBtn.disabled = true; // Use disabled attribute for better accessibility
                                    }
                                    });
                                    </script>--}}

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

                                            // Create a wrapper for the textarea and the remove button
                                            let fieldWrapper = document.createElement('div');
                                            fieldWrapper.classList.add('why-field-wrapper');
                                            fieldWrapper.appendChild(textarea);
                                            fieldWrapper.appendChild(removeButton);

                                            // Append the new field wrapper to the container
                                            container.appendChild(fieldWrapper);
                                        }

                                        function removeWhyField(button) {
                                            let fieldWrapper = button.parentNode; // Get the wrapper div
                                            fieldWrapper.remove(); // Remove the wrapper div, which removes the textarea and the remove button
                                        }
                                    </script>
                                    {{--  <div class="col-12 sub-head"></div>  --}}
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
                                                                <textarea name="why_problem_statement">{{ $data->why_problem_statement }}</textarea>
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
                                                                                    <span class="remove-field {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}" 
                                                                                        onclick="{{ $data->stage == 0 || $data->stage == 8 ? '' : 'removeWhyField(this)' }}" 
                                                                                        style="cursor: {{ $data->stage == 0 || $data->stage == 8 ? 'not-allowed' : 'pointer' }}; color: red;">
                                                                                      Remove
                                                                                  </span>
                                                                                  
                                                                                    {{--<span class="remove-field"
                                                                                        onclick="removeWhyField(this)"
                                                                                        style="cursor:pointer; color:red;" {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>Remove</span>--}}
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
                                                            <th style="background: #0039bd85">Coverage</th>
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


                                </div>
                                <div class="button-block">
                                    <button type="submit" class="saveButton"
                                        {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>Save</button>
                                    <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                    <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                    <button type="button"> <a class="text-white"
                                            href="{{ url('rcms/qms-dashboard') }}">
                                            Exit </a> </button>
                                </div>
                            </div>
                        </div>
                        <div id="CCForm4" class="inner-block cctabcontent">
                            <div class="inner-block-content">
                                <!-- <div class="sub-head">
                                                                                                                                                                                                                                                                                                                                                                                        CFT Feedback
                                                                                                                                                                                                                                                                                                                                                                                    </div>  -->
                                <div class="row">

                                    <div class="col-lg-12">
                                        <div class="group-input">
                                            <label for="comments">QA Review Comments</label>
                                            <div class="relative-container">
                                            <textarea name="cft_comments_new"{{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }} class="tiny">{{ $data->cft_comments_new }}</textarea>
                                            @component('frontend.forms.language-model')
                                                @endcomponent
                                                </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="group-input">
                                            <label for="comments">QA Review Attachment</label>
                                            <div><small class="text-primary">Please Attach all relevant or supporting
                                                    documents</small></div>
                                            <div class="file-attachment-field">
                                                <div disabled class="file-attachment-list" id="cft_attchament_new">
                                                    {{-- @if (!is_null($data->cft_attchament_new) && is_array(json_decode($data->cft_attchament_new))) --}}
                                                    @if ($data->cft_attchament_new)
                                                        @foreach (json_decode($data->cft_attchament_new) as $file)
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
                                                        {{-- @endif --}}
                                                    @endif
                                                </div>
                                                <div class="add-btn">
                                                    <div>Add</div>
                                                    <input type="file" id="myfile"
                                                        name="cft_attchament_new[]"{{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}
                                                        oninput="addMultipleFiles(this, 'cft_attchament_new')" multiple>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="button-block">
                                    <button type="submit" class="saveButton" {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>Save</button>
                                    <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                    <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                    <button type="button"> <a class="text-white"
                                            href="{{ url('rcms/qms-dashboard') }}">
                                            Exit </a> </button>

                                </div>
                            </div>
                        </div>


                        <div id="CCForm2" class="inner-block cctabcontent">
                            <div class="inner-block-content">
                                <div class="row">

                                    {{-- <div class="col-lg-12">
                                        <div class="group-input">
                                            <label for="investigation_tool">Investigation Tool</label>
                                            <textarea name="investigation_tool"{{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>{{ $data->investigation_tool }}</textarea>
                                        </div>
                                    </div> --}}
                                    <div class="col-lg-12">
                                        <div class="group-input">
                                            <label for="root_cause">Root Cause</label>
                                            <div class="relative-container">
                                            <textarea name="root_cause"{{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }} class="tiny">{{ $data->root_cause }}</textarea>
                                            @component('frontend.forms.language-model')
                                                @endcomponent
                                                </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="group-input">
                                            <label for="impact_risk_assessment">Impact / Risk Assessment</label>
                                            <div class="relative-container">
                                            <textarea name="impact_risk_assessment"{{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }} class="tiny">{{ $data->impact_risk_assessment }}</textarea>
                                            @component('frontend.forms.language-model')
                                                @endcomponent
                                                </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="group-input">
                                            <label for="capa">CAPA</label>
                                            <div class="relative-container">
                                            <textarea name="capa"{{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }} class="tiny">{{ $data->capa }}</textarea>
                                            @component('frontend.forms.language-model')
                                                @endcomponent
                                                </div>
                                        </div>
                                    </div>


                                    <div class="col-12">
                                        <div class="group-input">
                                            <label for="root_cause_description">Root Cause Description</label>
                                            <div class="relative-container">
                                            <textarea name="root_cause_description_rca"{{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }} class="tiny">{{ $data->root_cause_description_rca }}</textarea>
                                            @component('frontend.forms.language-model')
                                                @endcomponent
                                                </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="group-input">
                                            <label for="investigation_summary">Investigation Summary</label>
                                            <div class="relative-container">
                                            <textarea name="investigation_summary_rca"{{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }} class="tiny">{{ $data->investigation_summary_rca }}</textarea>
                                            @component('frontend.forms.language-model')
                                                @endcomponent
                                                </div>
                                        </div>
                                    </div>

                                    {{--  <div class="col-lg-12">
                                                    <div class="group-input">
                                                        <label for="investigation_summary">Investigation Summary</label>
                                                        <textarea name="investigation_summary"></textarea>
                                                    </div>
                                                </div>
                                            </div>  --}}

                                    <div class="col-lg-12">
                                        <div class="group-input">
                                            <label for="comments">Investigation Attachment
                                                <div><small class="text-primary">Please Attach all relevant or supporting
                                                        documents</small></div>
                                                <div class="file-attachment-field">
                                                    <div disabled class="file-attachment-list"
                                                        id="root_cause_initial_attachment_rca">
                                                        {{-- @if (!is_null($data->cft_attchament_new) && is_array(json_decode($data->cft_attchament_new))) --}}
                                                        @if ($data->root_cause_initial_attachment_rca)
                                                            @foreach (json_decode($data->root_cause_initial_attachment_rca) as $file)
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
                                                            {{-- @endif --}}
                                                        @endif
                                                    </div>
                                                    <div class="add-btn">
                                                        <div>Add</div>
                                                        <input type="file" id="myfile"
                                                            name="root_cause_initial_attachment_rca[]"{{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}
                                                            oninput="addMultipleFiles(this, 'root_cause_initial_attachment_rca')"
                                                            multiple>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>



                                </div>

                                <div class="button-block">
                                    <button type="submit" class="saveButton"
                                        {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>Save</button>
                                    <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                    <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                    <button type="button"> <a class="text-white"
                                            href="{{ url('rcms/qms-dashboard') }}">
                                            Exit </a> </button>
                                </div>
                            </div>
                        </div>



                        <div id="CCForm10" class="inner-block cctabcontent">
                            <div class="inner-block-content">
                                <!-- <div class="sub-head">
                                                                                                                                                                                                                                                                                                                                                                                        CFT Feedback
                                                                                                                                                                                                                                                                                                                                                                                    </div>  -->
                                <div class="row">

                                    <div class="col-lg-12">
                                        <div class="group-input">
                                            <label for="comments">HOD Final Review Comments</label>
                                            <div class="relative-container">
                                            <textarea name="hod_final_comments"{{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }} class="tiny">{{ $data->hod_final_comments }}</textarea>
                                            @component('frontend.forms.language-model')
                                                @endcomponent
                                                </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="group-input">
                                            <label for="comments">HOD Final Review Attachment</label>
                                            <div><small class="text-primary">Please Attach all relevant or supporting
                                                    documents</small></div>
                                            <div class="file-attachment-field">
                                                <div disabled class="file-attachment-list" id="hod_final_attachments">
                                                    {{-- @if (!is_null($data->cft_attchament_new) && is_array(json_decode($data->cft_attchament_new))) --}}
                                                    @if ($data->hod_final_attachments)
                                                        @foreach (json_decode($data->hod_final_attachments) as $file)
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
                                                        {{-- @endif --}}
                                                    @endif
                                                </div>
                                                <div class="add-btn">
                                                    <div>Add</div>
                                                    <input type="file" id="myfile"
                                                        name="hod_final_attachments[]"{{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}
                                                        oninput="addMultipleFiles(this, 'hod_final_attachments')" multiple>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="button-block">
                                    <button type="submit" class="saveButton" {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>Save</button>
                                    <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                    <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                    <button type="button"> <a class="text-white"
                                            href="{{ url('rcms/qms-dashboard') }}">
                                            Exit </a> </button>

                                </div>
                            </div>
                        </div>
                        <div id="CCForm11" class="inner-block cctabcontent">
                            <div class="inner-block-content">
                                <!-- <div class="sub-head">
                                                                                                                                                                                                                                                                                                                                                                                CFT Feedback
                                                                                                                                                                                                                                                                                                                                                                            </div>  -->
                                <div class="row">

                                    <div class="col-lg-12">
                                        <div class="group-input">
                                            <label for="comments">QA Final Review Comments</label>
                                            <div class="relative-container">
                                            <textarea name="qa_final_comments"{{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }} class="tiny">{{ $data->qa_final_comments }}</textarea>
                                            @component('frontend.forms.language-model')
                                                @endcomponent
                                                </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="group-input">
                                            <label for="comments">QA Final Review Attachment</label>
                                            <div><small class="text-primary">Please Attach all relevant or supporting
                                                    documents</small></div>
                                            <div class="file-attachment-field">
                                                <div disabled class="file-attachment-list" id="qa_final_attachments">
                                                    {{-- @if (!is_null($data->cft_attchament_new) && is_array(json_decode($data->cft_attchament_new))) --}}
                                                    @if ($data->qa_final_attachments)
                                                        @foreach (json_decode($data->qa_final_attachments) as $file)
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
                                                        {{-- @endif --}}
                                                    @endif
                                                </div>
                                                <div class="add-btn">
                                                    <div>Add</div>
                                                    <input type="file" id="myfile"
                                                        name="qa_final_attachments[]"{{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}
                                                        oninput="addMultipleFiles(this, 'qa_final_attachments')" multiple>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="button-block">
                                    <button type="submit" class="saveButton" {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>Save</button>
                                    <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                    <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                    <button type="button"> <a class="text-white"
                                            href="{{ url('rcms/qms-dashboard') }}">
                                            Exit </a> </button>

                                </div>
                            </div>
                        </div>
                        <div id="CCForm12" class="inner-block cctabcontent">
                            <div class="inner-block-content">
                                <!-- <div class="sub-head">
                                                                                                                                                                                                                                                                                                                                                                                CFT Feedback
                                                                                                                                                                                                                                                                                                                                                                            </div>  -->
                                <div class="row">

                                    <div class="col-lg-12">
                                        <div class="group-input">
                                            <label for="comments">QAH/CQAH Final Review Comments</label>
                                            <div class="relative-container">
                                            <textarea name="qah_final_comments"{{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }} class="tiny">{{ $data->qah_final_comments }}</textarea>
                                            @component('frontend.forms.language-model')
                                                @endcomponent
                                                </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="group-input">
                                            <label for="comments">QAH/CQAH Final Review Attachment</label>
                                            <div><small class="text-primary">Please Attach all relevant or supporting
                                                    documents</small></div>
                                            <div class="file-attachment-field">
                                                <div disabled class="file-attachment-list" id="qah_final_attachments">
                                                    {{-- @if (!is_null($data->cft_attchament_new) && is_array(json_decode($data->cft_attchament_new))) --}}
                                                    @if ($data->qah_final_attachments)
                                                        @foreach (json_decode($data->qah_final_attachments) as $file)
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
                                                        {{-- @endif --}}
                                                    @endif
                                                </div>
                                                <div class="add-btn">
                                                    <div>Add</div>
                                                    <input type="file" id="myfile"
                                                        name="qah_final_attachments[]"{{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}
                                                        oninput="addMultipleFiles(this, 'qah_final_attachments')" multiple>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="button-block">
                                    <button type="submit" class="saveButton" {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>Save</button>
                                    <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                    <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                    <button type="button"> <a class="text-white"
                                            href="{{ url('rcms/qms-dashboard') }}">
                                            Exit </a> </button>

                                </div>
                            </div>
                        </div>


                        <div id="CCForm7" class="inner-block cctabcontent">
                            <div class="inner-block-content">
                            
                            <div class="sub-head">Activity Log</div> 

                            
                            <div class="d-flex align-item-end justify-content-end">
                
                                <button style="margin-bottom:20px;" class="button_theme1"> <a
                                        class="text-white"
                                        href="{{ url('rcms/rootActivityPdf', $data->id) }}"> Print </a>
                                </button>
                             </div>
                
                                                   <div class="printable-content">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered">
                                                                <tbody>
                                                                    <tr>
                                                                        <td>
                                                                            <strong>Acknowledge By :</strong><br>
                                                                            {{ $data->acknowledge_by }}
                                                                        </td>
                                                                        <td>
                                                                            <strong>Acknowledge On :</strong><br>
                                                                            {{ $data->acknowledge_on }}
                                                                        </td>
                                                                    </tr>
                
                                                                    <tr>
                                                                        <td colspan="2">
                                                                            <strong>Acknowledge Comment :</strong><br>
                                                                            {{ $data->ack_comments ?? 'Not Applicable'}}
                                                                        </td>
                                                                    </tr>
                
                
                                                                    <tr>
                                                                        <td>
                                                                            <strong>HOD Review Complete By :</strong><br>
                                                                            {{ $data->HOD_Review_Complete_By }}
                                                                        </td>
                                                                        <td>
                                                                            <strong>HOD Review Complete On:</strong><br>
                                                                            {{ $data->HOD_Review_Complete_On }}
                                                                        </td>
                                                                    </tr>
                
                                                                    <tr>
                                                                        <td colspan="2">
                                                                            <strong>HOD Review Complete Comment:</strong><br>
                                                                            {{ $data->HOD_Review_Complete_Comment ?? 'Not Applicable' }}
                                                                        </td>
                                                                    </tr>
                
                                                                    <tr>
                                                                        <td>
                                                                            <strong>QA/CQA Review Complete By By :</strong><br>
                                                                            {{ $data->QQQA_Review_Complete_By }}
                                                                        </td>
                                                                        <td>
                                                                            <strong>QA/CQA Review Complete On :</strong><br>
                                                                            {{ $data->QQQA_Review_Complete_On }}
                                                                        </td>
                                                                    </tr>
                
                                                                    <tr>
                                                                        <td colspan="2">
                                                                            <strong>QA/CQA Review Complete Comment :</strong><br>
                                                                            {{ $data->QAQQ_Review_Complete_comment ?? 'Not Applicable' }}
                                                                        </td>
                                                                    </tr>
                
                
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
                                                                            <strong>Submit Comment :</strong><br>
                                                                            {{ $data->qa_comments_new ?? 'Not Applicable' }}
                                                                        </td>
                                                                    </tr>
                                                                                                                 
                
                                                                    <tr>
                                                                        <td>
                                                                            <strong>HOD Final Review Complete By :</strong><br>
                                                                            {{ $data->HOD_Final_Review_Complete_By}}
                                                                        </td>
                                                                        <td>
                                                                            <strong>HOD Final Review Complete On :</strong><br>
                                                                            {{ $data->HOD_Final_Review_Complete_On }}
                                                                        </td>
                                                                    </tr>
                
                                                                    <tr>
                                                                        <td colspan="2">
                                                                            <strong>HOD Final Review Complete Comment :</strong><br>
                                                                            {{ $data->HOD_Final_Review_Complete_Comment ?? 'Not Applicable' }}
                                                                        </td>
                                                                    </tr>
                
                                                                
                                                                    <tr>
                                                                        <td>
                                                                            <strong>Final QA/CQA Review Complete By :</strong><br>
                                                                            {{ $data->Final_QA_Review_Complete_By }}
                                                                        </td>
                                                                        <td>
                                                                            <strong>Final QA/CQA Review Complete On :</strong><br>
                                                                            {{ $data->Final_QA_Review_Complete_On }}
                                                                        </td>
                                                                    </tr>
                
                                                                    <tr>
                                                                        <td colspan="2">
                                                                            <strong>Final QA/CQA Review Comment :</strong><br>
                                                                            {{ $data->Final_QA_Review_Complete_Comment ?? 'Not Applicable' }}
                                                                        </td>
                                                                    </tr>
                

                                                                    <tr>
                                                                        <td>
                                                                            <strong>QAH/CQAH Closure By :</strong><br>
                                                                            {{ $data->evaluation_complete_by }}
                                                                        </td>
                                                                        <td>
                                                                            <strong>QAH/CQAH Closure On :</strong><br>
                                                                            {{ $data->evaluation_complete_on }}
                                                                        </td>
                                                                    </tr>
                
                                                                    <tr>
                                                                        <td colspan="2">
                                                                            <strong>QAH/CQAH Closure Comment :</strong><br>
                                                                            {{ $data->evalution_Closure_comment ?? 'Not Applicable' }}
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
                                                                            {{ $data->cancel_comment ?? 'Not Applicable' }}
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
                

                        {{--<div id="CCForm7" class="inner-block cctabcontent">
                            <div class="inner-block-content">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="group-input">
                                            <label for="acknowledge_by">Acknowledge By</label>
                                            <div class="static">{{ $data->acknowledge_by }}</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="group-input">
                                            <label for="acknowledge_on">Acknowledge On</label>
                                            <div class="static">{{ $data->acknowledge_on }}</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="group-input">
                                            <label for="ack_comments">Acknowledge Comment</label>
                                            <div class="static">{{ $data->ack_comments }}</div>
                                        </div>
                                    </div>
                                   

                                    <div class="col-lg-4">
                                        <div class="group-input">
                                            <label for="HOD_Review_Complete_By">HOD Review Complete By</label>
                                            <div class="static">{{ $data->HOD_Review_Complete_By }}</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="group-input">
                                            <label for="HOD_Review_Complete_On">HOD Review Complete On</label>
                                            <div class="static">{{ $data->HOD_Review_Complete_On }}</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="group-input">
                                            <label for="Comments">HOD Review Complete Comment</label>
                                            <div class="static">{{ $data->HOD_Review_Complete_Comment }}</div>
                                        </div>
                                    </div>
                                   
                                    <div class="col-lg-4">
                                        <div class="group-input">
                                            <label for="QQQA_Review_Complete_By">QA/CQA Review Complete By</label>
                                            <div class="static">{{ $data->QQQA_Review_Complete_By }}</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="group-input">
                                            <label for="QQQA_Review_Complete_On">QA/CQA Review Complete On</label>
                                            <div class="static">{{ $data->QQQA_Review_Complete_On }}</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="group-input">
                                            <label for="Comments">QA/CQA Review Complete Comment</label>
                                            <div class="static">{{ $data->QAQQ_Review_Complete_comment }}</div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-4">
                                        <div class="group-input">
                                            <label for="submitted_by">Submit By</label>
                                            <div class="static">{{ $data->submitted_by }}</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="group-input">
                                            <label for="submitted_on">Submit On</label>
                                            <div class="static">{{ $data->submitted_on }}</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="group-input">
                                            <label for="Comments">Submit Comment</label>
                                            <div class="static">{{ $data->qa_comments_new }}</div>
                                        </div>
                                    </div>
                                    

                                    <div class="col-lg-4">
                                        <div class="group-input">
                                            <label for="HOD_Final_Review_Complete_By">HOD Final Review Complete By</label>
                                            <div class="static">{{ $data->HOD_Final_Review_Complete_By }}</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="group-input">
                                            <label for="HOD_Final_Review_Complete_On">HOD Final Review Complete On</label>
                                            <div class="static">{{ $data->HOD_Final_Review_Complete_On }}</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="group-input">
                                            <label for="Comments">HOD Final Review Complete Comment</label>
                                            <div class="static">{{ $data->HOD_Final_Review_Complete_Comment }}</div>
                                        </div>
                                    </div>
                                   
                                    <div class="col-lg-4">
                                        <div class="group-input">
                                            <label for="Final_QA_Review_Complete_By">Final QA/CQA Review Complete
                                                By</label>
                                            <div class="static">{{ $data->Final_QA_Review_Complete_By }}</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="group-input">
                                            <label for="Final_QA_Review_Complete_On">Final QA/CQA Review Complete
                                                On</label>
                                            <div class="static">{{ $data->Final_QA_Review_Complete_On }}</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="group-input">
                                            <label for="Comments">Final QA/CQA Review Comment</label>
                                            <div class="static">{{ $data->Final_QA_Review_Complete_Comment }}</div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-4">
                                        <div class="group-input">
                                            <label for="evaluation_complete_by">QAH/CQAH Closure By</label>
                                            <div class="static">{{ $data->evaluation_complete_by }}</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="group-input">
                                            <label for="evaluation_complete_on">QAH/CQAH Closure On</label>
                                            <div class="static">{{ $data->evaluation_complete_on }}</div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="group-input">
                                            <label for="evalution_Closure_comment">QAH/CQAH Closure Comment</label>
                                            <div class="static">{{ $data->evalution_Closure_comment }}</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="group-input">
                                            <label for="Cancelled By">Cancel By</label>
                                            <div class="static">{{ $data->cancelled_by }}</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="group-input">
                                            <label for="Cancelled On">Cancel On</label>
                                            <div class="static">{{ $data->cancelled_on }}</div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="group-input">
                                            <label for="Comments">Cancel Comment</label>
                                            <div class="static">{{ $data->cancel_comment }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="button-block">
                                    <button type="submit" class="saveButton"
                                        {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>Save</button>
                                    <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                    
                                    <button type="button"> <a class="text-white"
                                            href="{{ url('rcms/qms-dashboard') }}">
                                            Exit </a> </button>
                                </div>
                            </div>
                        </div>--}}
                </div>
                </form>
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

                    <form action="{{ route('root_reject', $data->id) }}" method="POST">
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
        <div class="modal fade" id="cancel-modal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">E-Signature</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <form action="{{ route('root_Cancel', $data->id) }}" method="POST">
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
                        <div class="modal-footer">
                            <button type="submit" data-bs-dismiss="modal">Submit</button>
                            <button type="button" data-bs-dismiss="modal">Close</button>
                            {{-- <button>Close</button> --}}
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
                    <form action="{{ route('R_C_A_root_child', $data->id) }}" method="POST">
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
                            {{-- <div class="group-input">
                            <label for="root-item">
                            <input type="radio" name="revision" id="root-item" value="effectiveness-check">
                                Effectiveness check
                            </label>
                        </div> --}}
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


        <div class="modal fade" id="signature-modal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">E-Signature</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('root_send_stage', $data->id) }}" method="POST">
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

        <style>
            #step-form>div {
                display: none
            }

            #step-form>div:nth-child(1) {
                display: block;
            }
        </style>

        <script>
            $(document).on('click', '.removeRowBtn', function() {
                $(this).closest('tr').remove();
            })
        </script>
        <script>
            // ================================ FOUR INPUTS
            function add4Input_case(tableId) {
                var table = document.getElementById(tableId);
                var currentRowCount = table.rows.length;
                var newRow = table.insertRow(currentRowCount);

                newRow.setAttribute("id", "row" + currentRowCount);
                var cell1 = newRow.insertCell(0);
                cell1.innerHTML = currentRowCount;

                var cell2 = newRow.insertCell(1);
                cell2.innerHTML = "<input type='text' name='Root_Cause_Category[]'>";

                var cell3 = newRow.insertCell(2);
                cell3.innerHTML = "<input type='text'  name='Root_Cause_Sub_Category[]'>";

                var cell4 = newRow.insertCell(3);
                cell4.innerHTML = "<input type='text'  name='Probability[]''>";

                var cell5 = newRow.insertCell(4);
                cell5.innerHTML = "<input type='text'  name='Remarks[]'>";

                var cell6 = newRow.insertCell(5);
                cell6.innerHTML = "<button type='text' class='removeRowBtn' name='Action[]' readonly>Remove</button>";

                for (var i = 1; i < currentRowCount; i++) {
                    var row = table.rows[i];
                    row.cells[0].innerHTML = i;
                }
            }

            function addRootCauseAnalysisRiskAssessment1(tableId) {
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
        </script>
        <script>
            VirtualSelect.init({
                ele: '#investigators, #department, #root-cause-methodology,#investigation_team'
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
            VirtualSelect.init({
                ele: '#departments, #team_members, #training-require, #impacted_objects'
            });
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
            document.getElementById('initiator_group').addEventListener('change', function() {
                var selectedValue = this.value;
                document.getElementById('initiator_group_code').value = selectedValue;
            });

            function setCurrentDate(item) {
                if (item == 'yes') {
                    $('#effect_check_date').val('{{ date('d-M-Y') }}');
                } else {
                    $('#effect_check_date').val('');
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

        <script>
            var maxLength = 255;
            $('#docname').keyup(function() {
                var textlen = maxLength - $(this).val().length;
                $('#rchars').text(textlen);
            });
        </script>


        {{--  <script>
        $(document).ready(function() {
            $('#root-cause-methodology').on('change', function() {
                var selectedValues = $(this).val();
                $('#why-why-chart-section').hide();
                $('#fmea-section').hide();
                $('#fishbone-section').hide();
                $('#is-is-not-section').hide();

                if (selectedValues.includes('Why-Why Chart')) {
                    $('#why-why-chart-section').show();
                }
                if (selectedValues.includes('Failure Mode and Effect Analysis')) {
                    $('#fmea-section').show();
                }
                if (selectedValues.includes('Fishbone or Ishikawa Diagram')) {
                    $('#fishbone-section').show();
                }
                if (selectedValues.includes('Is/Is Not Analysis')) {
                    $('#is-is-not-section').show();
                }
            });
        });
    </script>    --}}


        <script>
            $(document).ready(function() {
                $('#root-cause-methodology').on('change', function() {
                    var selectedValues = $(this).val() || [];

                    // Hide all sections initially
                    $('#why-why-chart-section').hide();
                    $('#fmea-section').hide();
                    $('#fishbone-section').hide();
                    $('#is-is-not-section').hide();

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
                        }
                        if (value === 'Is/Is Not Analysis') {
                            $('#is-is-not-section').show();
                        }
                    });
                });

                // Trigger the change event on page load to show the correct sections based on initial values
                $('#root-cause-methodology').trigger('change');
            });
        </script>

     {{--Side Bar Workflow script start--}}

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
        
    {{--Side Bar Workflow script end--}}

    {{--<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>--}}

    @endsection
