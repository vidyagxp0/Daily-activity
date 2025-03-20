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
        .table-responsive::-webkit-scrollbar {
            height: 20px;
        }
        #change-control-fields .inner-block .group-input table thead th {
            background: #6495f8;
            /* background: #00a5c1; */
            color: white;
        }
        button {
            border: 0;
            background: #6495f8;
            /* background: #00a5c1; */
            color: white;
            border: 2px solid black;
            transition: all 0.3s linear;
            border-radius: 5px;
        }
    </style>

    <style>
        .time-required {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .time-required input {
            width: 70px;
            text-align: center;
            border: 1px solid #ccc;
        }

    </style>

    
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
    background-color:#4274da; 
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
                background-color:#eba746; 
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

    <style>
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

        #change-control-fields>div>div.inner-block.state-block>div.status>div.progress-bars.d-flex>div:nth-child(6) {
            border-radius: 0px 20px 20px 0px;

        }

        .new_style {
            width: 100%;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        #change-control-view>div.container-fluid>div.inner-block.state-block>div.status>div.progress-bars>div.canceled {
            border-radius: 20px;
        }

    </style>

    <div class="form-field-head">
        <div class="division-bar">
            <strong>Site Division/Project</strong> :
            {{ Helpers::getDivisionName(session()->get('division')) }} / Task Management
        </div>
    </div>

    @php
        $users = DB::table('users')->get();
    @endphp


<!-- ------ ----------------------------------------- -->
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
                        <?php
                        $userRoles = DB::table('user_roles')->where(['user_id' => Auth::user()->id, 'q_m_s_divisions_id' => $data->division_id])->get();
                        $userRoleIds = $userRoles->pluck('q_m_s_roles_id')->toArray();
                       ?>
                                <button class="button_theme1"> <a class="text-white" href="{{ route('TaskManagementAuditTrail', $data->id) }}">
                                Audit Trail </a> </button>

                        @if ($data->stage == 1)
                            <a href="#signature-modal"><button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Send For Review
                            </button> </a>
                            <a href="#cancel-modal"><button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-modal">
                                Cancel
                            </button> </a>
                            
                        @elseif($data->stage == 2)
                           
                            <a href="#moreinfo-modal"> <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#moreinfo-modal">
                            Request More Info
                            </button></a>
                            <a href="#signature-modal"> <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                            Reviewed
                            </button></a>
                           
                        @elseif($data->stage == 3)
                            <a href="#moreinfo-modal"> <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#moreinfo-modal">
                            Request More Info
                            </button></a>
                           <a href="#signature-modal"> <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Approved
                            </button></a>
                        

                        @endif
                         <a class="button_theme1 text-white" href="{{ url('rcms/qms-dashboard') }}"> Exit
                            </a>
                    </div>
                </div>

                    <!-- ----- -------------------- -->

                <div class="status">
                    <div class="head">Current Status</div>
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
                                <div class="active">In Review</div>
                            @else
                                <div class="">In Review</div>
                            @endif
                            @if ($data->stage >= 3)
                                <div class="active">In Approve</div>
                            @else
                                <div class="">In Approve</div>
                            @endif

                            @if ($data->stage >= 4)
                                <div class="active bg-danger">Closed - Done</div>
                            @else
                                <div class="">Closed - Done</div>
                            @endif

                        </div>
                    @endif
                </div>


                <div class="top-block mt-2">
                    <div><strong> Record Name:&nbsp;</strong>Presentation Grid </div>
                    <div><strong> Site:&nbsp;</strong>{{ Helpers::getDivisionName($data->division_id) }}</div>
                    <div><strong> Current Status:&nbsp;</strong>{{ $data->status }}</div>
                    <div><strong> Initiated By:&nbsp;</strong>{{ Helpers::getInitiatorName($data->initiator_id) }}</div>
                </div>
                
                {{-- @endif --}}
                {{-- ---------------------------------------------------------------------------------------- --}}
            </div>
            <div class="modal right fade" id="myModal3" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-titles ml-10"> Workflow</h4>
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
                                        Review
                                    </div> 
                                @else
                                    <div  class="mini_buttons">
                                        Review
                                    </div>
                                @endif
                                    <div class="down-logo">
                                        <img class="dawn_arrow" src="{{ asset('user/images/down.gif') }}" alt="..."
                                            class="w-100 h-100">
        
                                    </div>
                                @if ($data->stage >= 3)
                                    <div  class="active">
                                       Approved
                                    </div>
                                @else
                                    <div  class="mini_buttons">
                                       Approved
                                    </div>
                                @endif
                                    <div class="down-logo">
                                        <img class="dawn_arrow" src="{{ asset('user/images/down.gif') }}" alt="..."
                                            class="w-100 h-100">
        
                                    </div>
                                @if ($data->stage >= 4)
                                    <div  class="active">
                                        Closed-Done
                                    </div>
                                @else
                                    <div  class="mini_buttons">
                                        Closed-Done
                                    </div>
                                @endif
                                    <div class="down-logo">
                                        <img class="dawn_arrow" src="{{ asset('user/images/down.gif') }}" alt="..."
                                            class="w-100 h-100">
        
                                    </div> 
                              
                                @endif   
                            </Div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
<!-- --------- - ------------------------------------- -->    

    {{-- ======================================
                    DATA FIELDS
    ======================================= --}}
    <div id="change-control-fields">
        <div class="container-fluid">
            
                        
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

            <!-- Tab links -->
            <div class="cctab">

                <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">General Information</button>
                {{-- <button class="cctablinks" onclick="openCity(event, 'CCForm2')">Activity Log</button> --}}
            </div>


            <form  action="{{ route('task_management_update', $data->id) }}" method="post" enctype="multipart/form-data">
                @csrf

                <div id="step-form">
                    @if (!empty($parent_id))
                        <input type="hidden" name="parent_id" value="{{ $parent_id }}">
                        <input type="hidden" name="parent_type" value="{{ $parent_type }}">
                    @endif

                    <div id="CCForm1" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                    
                                <div class="group-input">
                                    <label for="RLS Record Number"><b>Record Number</b></label>
                                    <input disabled type="text" name="record_number" id="record_number"
                                        value="{{ Helpers::getDivisionName(session()->get('division')) }}/{{ Auth::user()->name }}/{{ \Carbon\Carbon::parse($data->created_at)->format('d-M-Y') }}/{{ $data->record }}">
                                </div>
                                
                                
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="originator">Initiator</label>
                                        <input readonly type="text" name="originator_id"
                                            value="{{ Auth::user()->name }}" />
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Date Due"><b>Date of Initiation</b></label>
                                        <input disabled type="text" name="intiation_date" {{ $data->stage == 0 || $data->stage == 4 ? "disabled" : "" }}
                                         value="{{ Helpers::getdateFormat($data->intiation_date)}}" >
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Division Code"><b>Division Code</b></label>
                                        @if(!empty($parent_id))
                                        <input readonly type="text" name="division_code" value="{{ Helpers::getDivisionName($parent_division_id) }}">
                                        <input type="hidden" name="division_id" value="{{ $parent_division_id }}">
                                    @else
                                        <input readonly type="text" name="division_code" value="{{ Helpers::getDivisionName(session()->get('division')) }}">
                                        <input type="hidden" name="division_id" value="{{ session()->get('division') }}">
                                    @endif
                                    </div>
                                </div>

                                {{-- <div class="col-12">
                                    <div class="group-input">
                                        <label for="Short Description">Short Description<span
                                                class="text-danger">*</span></label><span id="rchars">255</span>
                                        characters remaining
                                        <div class="relative-container">
                                        <input id="docname" type="text" name="short_description" value="{{ $data->short_description }}" maxlength="255"
                                            required>
                                        @component('frontend.forms.language-model')
                                        @endcomponent
                                    </div>
                                </div> --}}

                                <!-- =========================================================== -->
                                <div class="col-12 mb-4">
                                    <div class="group-input">
                                        <label for="agenda">
                                            Task Management
                                            <button type="button" name="agenda"
                                                id="task_manamegemnt_grid">+</button>
                                        </label><div class="table-responsive">
                                            <table class="table table-bordered" style="width: 250%" id="task_Management_Table">
                                                <thead>
                                                    
                                                        <tr style="text-align: center; vertical-align: middle; padding: 20px;">
                                                            <th>Row #</th>
                                                            <th>Topic</th>
                                                            <th>Category</th>
                                                            <th>Date</th>
                                                            <th>Speaker</th>
                                                            <th>Attachments</th>
                                                            <th> Remarks </th>
                                                            <th>Action</th>
                                                        </tr>
                                                    
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $serialNumber = 1;
                                                        $taskGridDataArray = json_decode(json_encode($TaskGridData->data), true) ?? [];
                                                    @endphp
                                        
                                                    @foreach ($taskGridDataArray as $taskGrid)
                                                        <tr style="text-align: center; vertical-align: middle; padding: 20px;">
                                                            <td disabled>{{ $serialNumber++ }}</td>
                                                            <td>
                                                                <textarea class="auto-resize-textarea" name="TaskManagementData[{{ $loop->index }}][activity1_task]">{{ $taskGrid['activity1_task'] ?? '' }}</textarea>
                                                            </td>
                                                            <td>
                                                                <select name="TaskManagementData[{{ $loop->index }}][validation_team_name]">
                                                                    <option value="" {{ empty($taskGrid['validation_team_name']) ? 'selected' : '' }}>-- Select --</option>
                                                                    <option value="GLP" {{ ($taskGrid['validation_team_name'] ?? '') === 'GLP' ? 'selected' : '' }}>GLP</option>
                                                                    <option value="GMP" {{ ($taskGrid['validation_team_name'] ?? '') === 'GMP' ? 'selected' : '' }}>GMP</option>
                                                                    <option value="GCP" {{ ($taskGrid['validation_team_name'] ?? '') === 'GCP' ? 'selected' : '' }}>GCP</option>
                                                                    <option value="GDP" {{ ($taskGrid['validation_team_name'] ?? '') === 'GDP' ? 'selected' : '' }}>GDP</option>
                                                                    <option value="GEP" {{ ($taskGrid['validation_team_name'] ?? '') === 'GEP' ? 'selected' : '' }}>GEP</option>
                                                                    <option value="Others" {{ ($taskGrid['validation_team_name'] ?? '') === 'Others' ? 'selected' : '' }}>Others</option>
                                                                </select>
                                                            </td>
                                                          
                                                            <td>
                                                                <input type="datetime-local" name="TaskManagementData[{{ $loop->index }}][testing_completed_by_developer_on]" value="{{ $taskGrid['testing_completed_by_developer_on'] ?? '' }}" class="datetimepicker">
                                                            </td>
                                                            <td>
                                                                <select name="TaskManagementData[{{ $loop->index }}][work_in_progress_detail]">
                                                                    <option value="">-- Select Speaker --</option>
                                                                    @foreach ($users as $user)
                                                                        <option value="{{ $user->id }}" 
                                                                            {{ ($taskGrid['work_in_progress_detail'] ?? '') == $user->id ? 'selected' : '' }}>
                                                                            {{ $user->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            
                                                         
                                                            <td>
                                                                <input type="file" name="TaskManagementData[{{ $loop->index }}][developer_testing_details]">
                                                                
                                                                @if (!empty($taskGrid['developer_testing_details']))
                                                                    <br>
                                                                    <a href="{{ asset($taskGrid['developer_testing_details']) }}" target="_blank">View File</a>
                                                                    <input type="hidden" name="TaskManagementData[{{ $loop->index }}][old_developer_testing_details]" value="{{ $taskGrid['developer_testing_details'] }}">
                                                                @endif
                                                            </td>
                                                            
                                                            

                                                            <td>
                                                                <textarea class="auto-resize-textarea" name="TaskManagementData[{{ $loop->index }}][remaining_work]">{{ $taskGrid['remaining_work'] ?? '' }}</textarea>
                                                            </td>
                                                          <td>
                                                                <button class="removeRowBtn">Remove</button>
                                                            </td>                                                           
                                                        </tr>
                                                    @endforeach
                                                </tbody>

                                            </table>
                                        </div>
                                    </div>
                                </div>

                              

                                <script>
                                    $(document).ready(function () {
                                        let investdetails = 1;
                                
                                        // Manually embed user data inside script
                                        let usersList = [
                                            @foreach ($users as $user)
                                                { id: "{{ $user->id }}", name: "{{ $user->name }}" },
                                            @endforeach
                                        ];
                                
                                        function generateTableRow(serialNumber) {
                                            let userOptions = '<option value="">-- Select Speaker --</option>';
                                            usersList.forEach(user => {
                                                userOptions += `<option value="${user.id}">${user.name}</option>`;
                                            });
                                
                                            var html =
                                                '<tr>' +
                                                '<td><input disabled type="text" style="width:15px" value="' + serialNumber + '"></td>' +
                                                '<td><textarea class="auto-resize-textarea" name="TaskManagementData[' + investdetails + '][activity1_task]"></textarea></td>' +
                                                '<td><select name="TaskManagementData[' + investdetails + '][validation_team_name]">' +
                                                '<option value="">-- Select --</option>' +
                                                '<option value="GLP">GLP</option>' +
                                                '<option value="GMP">GMP</option>' +
                                                '<option value="GCP">GCP</option>' +
                                                '<option value="GEP">GEP</option>' +
                                                '<option value="GDP">GDP</option>' +
                                                '<option value="Others">Others</option>' +
                                                '</select></td>' +
                                
                                                '<td><input type="datetime-local" name="TaskManagementData[' + investdetails + '][testing_completed_by_developer_on]" class="datetimepicker"></td>' +
                                
                                                // Speaker dropdown instead of Work in Progress Detail
                                                '<td><select name="TaskManagementData[' + investdetails + '][work_in_progress_detail]">' +
                                                userOptions +
                                                '</select></td>' +
                                
                                                '<td><input type="file" name="TaskManagementData[' + investdetails + '][developer_testing_details]" ></td>' +
                                                '<td><textarea class="auto-resize-textarea" name="TaskManagementData[' + investdetails + '][remaining_work]"></textarea></td>' +
                                
                                                '<td><button class="removeRowBtn">Remove</button></td>' +
                                                '</tr>';
                                            investdetails++; // Increment row count
                                            return html;
                                        }
                                
                                        $('#task_manamegemnt_grid').click(function (e) {
                                            var tableBody = $('#task_Management_Table tbody');
                                            var rowCount = tableBody.children('tr').length;
                                            var newRow = generateTableRow(rowCount + 1);
                                            tableBody.append(newRow);
                                        });
                                
                                        $(document).on('click', '.removeRowBtn', function () {
                                            $(this).closest('tr').remove();
                                        });
                                    });
                                </script>

                                <script>
                                    function updateTime(element) {
                                        // Extract the row index from the input field's ID
                                        let index = element.id.split('_')[1];

                                        // Get the values from the corresponding input fields
                                        let days = parseInt(document.getElementById(`days_${index}`).value) || 0;
                                        let hours = parseInt(document.getElementById(`hours_${index}`).value) || 0;
                                        let minutes = parseInt(document.getElementById(`minutes_${index}`).value) || 0;
                                        let days_second = parseInt(document.getElementById(`days_${index}_second`).value)||0;
                                        let hours_second = parseInt(document.getElementById(`hours_${index}_second`).value)||0;
                                        let minutes_second = parseInt(document.getElementById(`minutes_${index}_second`).value)||0;;

                                        // Validate the inputs
                                        if (days < 0) {
                                            alert("Days cannot be negative.");
                                            document.getElementById(`days_${index}`).value = 0; // Reset to 0
                                            return;
                                        }

                                        if (days_second < 0) {
                                            alert("Days cannot be negative.");
                                            document.getElementById(`days_${index}_second`).value = 0; // Reset to 0
                                            return;
                                        }

                                        if (hours < 0 || hours > 23) {
                                            alert("Hours must be between 0 and 23.");
                                            document.getElementById(`hours_${index}`).value = 0; // Reset to 0
                                            return;
                                        }

                                        if (hours_second < 0 || hours > 23) {
                                            alert("Hours must be between 0 and 23.");
                                            document.getElementById(`hours_${index}_second`).value = 0; // Reset to 0
                                            return;
                                        }


                                        if (minutes < 0 || minutes > 59) {
                                            alert("Minutes must be between 0 and 59.");
                                            document.getElementById(`minutes_${index}`).value = 0; // Reset to 0
                                            return;
                                        }
                                         
                                         if (minutes < 0 || minutes > 59) {
                                            alert("Minutes must be between 0 and 59.");
                                            document.getElementById(`minutes_${index}`).value = 0; // Reset to 0
                                            return;
                                        }


                                        // Convert everything to total minutes
                                        let totalMinutes = (days * 24 * 60) + (hours * 60) + minutes;

                                        // Convert back to days, hours, and minutes for display (if needed)
                                        let displayDays = Math.floor(totalMinutes / (24 * 60));
                                        let displayHours = Math.floor((totalMinutes % (24 * 60)) / 60);
                                        let displayMinutes = totalMinutes % 60;

                                        console.log(`Row ${index}: ${displayDays} Days, ${displayHours} Hours, ${displayMinutes} Minutes`);
                                    }

                                </script>


                                <!-- =========================================================== -->

                            </div>
                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="incident_involved_others_gi">Final Comments</label>
                                    <textarea name="final_comments">{{ $Task->final_comments }}</textarea>
                                </div>

                            </div>
                            <div class="group-input">
                            <label for="file-attachment-field">Supporting Documents </label>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="in_attachment">
                                                @if ($attachment->in_attachment)
                                                @foreach (json_decode($attachment->in_attachment) as $file)
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
                                                <input {{ $attachment->stage == 0 || $attachment->stage == 4 ? "disabled" : "" }} type="file" id="in_attachment" name="in_attachment[]"
                                                    oninput="addMultipleFiles(this, 'in_attachment')" multiple>
                                            </div>
                                        </div>
                                </div>
                            </div>

                            <div class="button-block">
                                <button type="submit" id="ChangesaveButton" class="saveButton">Save</button>
                                <button type="button" id="ChangeNextButton" class="nextButton">Next</button>
                                <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                                        Exit </a> </button>
                            </div>
                        </div>
                    </div>
                                </div>

            </form>

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
                <form action="{{ route('taskManagementSendStage', $data->id) }}" method="POST">
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
                    <div class="modal-footer">
                        <button type="submit">Submit</button>
                        <button type="button" data-bs-dismiss="modal">Close</button>
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
        $(document).on('click', '.removeRowBtn', function() {
            $(this).closest('tr').remove();
        })
    </script>
    <script>
        var maxLength = 255;
        $('#docname').keyup(function() {
            var textlen = maxLength - $(this).val().length;
            $('#rchars').text(textlen);
        });
    </script>
  <script>
     
    document.addEventListener('DOMContentLoaded', function () {
        const textareas = document.querySelectorAll('.auto-resize-textarea');
        textareas.forEach(textarea => {
            textarea.addEventListener('input', function() {
                this.style.height = 'auto'; // Reset the height
                this.style.height = (this.scrollHeight) + 'px'; // Set the height to the scroll height
            });

            // Trigger the input event to adjust the height initially (if there's content)
            textarea.dispatchEvent(new Event('input'));
        });
    });
</script>

@endsection
