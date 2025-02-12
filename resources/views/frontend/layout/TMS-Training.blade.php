<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <title>Vidyagxp - Software</title>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css"
        integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  
    

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <script src="https://cdn.tiny.cloud/1/nlsiabbt295w89cjmcocv6qjdg3k7ozef0q9meowv2nkwyd3/tinymce/6/tinymce.min.js">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <link rel="stylesheet" href="{{ asset('user/css/virtual-select.min.css') }}">
    <script src="{{ asset('user/js/virtual-select.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('user/css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.14.0/themes/base/jquery-ui.min.css" integrity="sha512-F8mgNaoH6SSws+tuDTveIu+hx6JkVcuLqTQ/S/KJaHJjGc8eUxIrBawMnasq2FDlfo7FYsD8buQXVwD+0upbcA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- For Training Calender -->
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css' rel='stylesheet' />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js'></script>
    {{-- @toastr_css --}}
</head>

<body>

<style>
        #calendar>div.fc-header-toolbar.fc-toolbar.fc-toolbar-ltr>div:nth-child(1)>button {
            text-transform: capitalize;
        }

        #calendar>div.fc-header-toolbar.fc-toolbar.fc-toolbar-ltr>div:nth-child(3)>div>button.fc-timeGridDay-button.fc-button.fc-button-primary {
            text-transform: capitalize;
        }

        #calendar>div.fc-header-toolbar.fc-toolbar.fc-toolbar-ltr>div:nth-child(3)>div>button.fc-timeGridWeek-button.fc-button.fc-button-primary {
            text-transform: capitalize;
        }

        #calendar>div.fc-header-toolbar.fc-toolbar.fc-toolbar-ltr>div:nth-child(3)>div>button.fc-timeGridWeek-button.fc-button.fc-button-primary {
            text-transform: capitalize;
        }

        #calendar>div.fc-header-toolbar.fc-toolbar.fc-toolbar-ltr>div:nth-child(3)>div>button.fc-dayGridMonth-button.fc-button.fc-button-primary.fc-button-active {
            text-transform: capitalize;
        }
    </style>

    <style>
        #tms-dashboard {
    padding: 20px 0px;
    background: #4274da;
    min-height: 0 !important;
}
        #create-record-button {
            display: none;
            margin-left: auto;
        }
        .cctab {
        display: flex;
        justify-content: left;
        margin-bottom: 20px;
        padding: 10px;
    }

    .cctablinks {
        background-color: #ffffff;
        border-radius: 5px;
        padding: 6px 12px;
        margin: 0 5px;
        cursor: pointer;
        font-size: 16px;
        color: #333;
        border: none;
    }

    .cctablinks:hover {
        background-color: #ddd;
        color: #000;
    }

    .cctablinks.active {
        background-color: #3a424b;
        /* background-color: #007bff; */
        color: white;
    }

    .cctabcontent {
        padding: 20px;
        border: 1px solid #ccc;
        border-top: none;
    }
    </style>

    <style>



      .table thead th {
            background-color: #4274daba; 
            color: rgb(2, 2, 2); 
        }
        
        .inner-block {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
    
        .heading-tms {
            font-size: 19px;
            font-weight: bold;
            color: #030303;
            margin-bottom: 15px;
        }
    
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
    
        .table th,
        .table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
    
        .table thead th {
            background-color: #4274daba;
            color: rgb(2, 2, 2);
        }
    
        .table tbody tr:hover {
            background-color: #f1f1f1;
        }
    
        /* Pagination Styles */
        .pagination {
            justify-content: center;
            margin-top: 15px;
        }
    
        .btn {
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
         
        }
    
        .btn-outline {
            background-color: transparent;
            border: 1px solid #4274da;
            color: #4274da;
            transition: background-color 0.3s, color 0.3s;
        }
    
        .btn-outline:hover {
            background-color: #4274da;
            color: white;
        }
    
        /* Responsive Styles */
        @media (max-width: 768px) {
            .table th,
            .table td {
                padding: 8px;
                font-size: 14px;
            }
    
            .heading-tms {
                font-size: 20px;
            }
        }
    </style>

    <header>

        {{-- Header Top --}}
                <div class="container-fluid header-top">
                    <div class="container text-center">
                        <div class="brand-name">Connexo</div>
                    </div>
                </div>
                <style>
                    .container {
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    height: 5vh; 
                }
        
                .brand-name {
                    color: white;
                    font-size: 17px; 
                    font-weight: bold; 
                    animation: fadeSlideIn 1.5s ease-out;
                    
                }
              
        
                </style>
        {{-- Header Middle --}}
            <div class="container-fluid header-middle">
                <div>
                    <div class="middle-head">
                        <div class="logo-container">
                            <div class="logo">
                                <img src="{{ asset('user/images/connexo.png') }}" alt="..." class="w-100 h-100"
                                    style="scale: 1">
                            </div>
                            <div class="logo" style="margin-left: 15px;">
                                {{-- <img  src="{{ asset('user/images/symbiotec_pharmalab_pvt_ltd__logo.jpg') }}" alt="..."class="w-100 h-100" style="filter: none; scale: 1.8; max-width: 70px; margin: auto; margin-top: 7px; margin-bottom: 20px;"> --}}
                            </div>
                            {{-- <div class="logo">
                                <img src="{{ asset('user/images/agio.jpg') }}" alt="..." class="w-100 h-100">
                            </div> --}}
                        </div>
                        <!-- <div class="search-bar">
                            <form action="#" class="w-100">
                                <label for="search"><i class="fa-solid fa-magnifying-glass"></i></label>
                                <input id="searchInput" type="text" name="search" placeholder="Search">
                                <div data-bs-toggle="modal" data-bs-target="#advanced-search">Advanced Search</div>
                            </form>
                        </div> -->
                        <div class="icon-grid">
                        
                            @if(Auth::guard('employee')->user())
                                <div class="icon-drop">
                                    <div class="icon">
                                        <i class="fa-solid fa-user-tie"></i>
                                        {{ Auth::guard('employee')->user()->employee_name }}
                                        <i class="fa-solid fa-angle-down"></i>
                                    </div>
                                    <div class="icon-block small-block">
                                        <div data-bs-toggle="modal" data-bs-target="#about-modal">
                                            <i class="fa-solid fa-info-circle"></i> About
                                        </div>
                                        <div>
                                            <i class="fa-solid fa-sign-out-alt"></i>
                                            <a href="{{ route('logout-employee') }}">Log Out</a>
                                        </div>
                                    </div>
                                </div>
                               
                                     <style>
                                    .icon-drop {
                                        position: relative;
                                        display: inline-block;
                                    }

                                    .icon {
                                        display: flex;
                                        align-items: center;
                                        justify-content: center;
                                        background: #4274da;
                                        color: #ffffff;
                                        padding: 10px 20px;
                                        border-radius: 25px;
                                        cursor: pointer;
                                        font-size: 16px;
                                        transition: background-color 0.3s ease;
                                    }

                                    .icon:hover {
                                        background-color: #4274da;
                                    }

                                    .icon i {
                                        margin: 0 5px;
                                    }

                                    .icon-block {
                                        position: absolute;
                                        top: 50px;
                                        right: 0;
                                        background: #ffffff;
                                        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                                        border-radius: 10px;
                                        display: none;
                                        flex-direction: column;
                                        min-width: 200px;
                                        z-index: 10;
                                    }

                                    .icon-drop:hover .icon-block {
                                        display: flex;
                                    }

                                    .icon-block div {
                                        display: flex;
                                        align-items: center;
                                        padding: 10px 15px;
                                        color: #343a40;
                                        font-size: 14px;
                                        text-decoration: none;
                                        cursor: pointer;
                                        transition: background-color 0.3s ease;
                                    }

                                    .icon-block div:hover {
                                        background-color: #f1f1f1;
                                    }

                                    .icon-block div i {
                                        margin-right: 10px;
                                        color: #4274da;
                                    }

                                    .icon-block div a {
                                        text-decoration: none;
                                        color: inherit;
                                        flex: 1;
                                    }

                                    .icon-block div a:hover {
                                        color: #4274da;
                                    }
                                </style>
                              
                            @else                        
                                <div class="icon-drop">
                                    <div class="icon">
                                        <i class="fa-solid fa-user-tie"></i>
                                        @if (Auth::user())
                                            {{ Auth::user()->name }}
                                        @else
                                            Amit Guru
                                        @endif
                                        <i class="fa-solid fa-angle-down"></i>
                                    </div>
                                    <div class="icon-block small-block">
                                        <div data-bs-toggle="modal" data-bs-target="#about-modal">About</div>
                                        <div><a href="/helpdesk-personnel">Helpdesk Personel</a></div>
                                        <div><a href="{{ route('logout') }}">Log Out</a></div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

 </header>


    <div id="tms-head">
        <div class="head">Learning Management System</div>
        <div class="link-list">
         
           
        </div>
    </div>

{{-- ======================================
                    DASHBOARD
    ======================================= --}}

    <div id="tms-dashboard">
        <div class="container-fluid">
            <div class="dashboard-container">
                <div class="inner-block main-block">
                    <div class="top">
                        <div class="d-flex align-items-center">
                            <div class="icon">
                                <i class="fa-solid fa-gauge-high"></i>
                            </div>
                                    <div class="name">
                                        <div>Dashboard</div>
                                        <div>LMS Employee Dashboard</div>
                                    </div>
                        </div>
                        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
                        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
                        
                        <div class="doc-links d-flex justify-content-between align-items-center mt-3">
                            <a href="training-graph" class="btn btn-outline-primary d-flex align-items-center mr-2">
                                <i class="fas fa-chart-bar mr-1"></i> Chart
                            </a>
                        
                            <a href="{{ url('induction-training-chart') }}" class="btn btn-outline-success d-flex align-items-center mr-2">
                                <i class="fas fa-user-graduate mr-1"></i> Employee Training Results
                            </a>
                        
                            <a href="javascript:window.location.reload(true)" class="btn btn-outline-secondary d-flex align-items-center">
                                <i class="fas fa-sync-alt mr-1"></i> Refresh
                            </a>
                        </div>


                    </div>
                </div>
                
                <div class="cctab">

                    <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">Assigned To Me</button>
                    <button class="cctablinks" onclick="openCity(event, 'CCForm2')">Training Calender</button>

                </div>
                    <style>

                    .cctab {
                        display: flex;
                        justify-content: flex-start;
                        gap: 10px; 
                        background-color: #f8f9fa; 
                        padding: 10px;
                        border-radius: 8px;
                        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                    }


                    .cctablinks {
                        background-color: #ffffff; 
                        color: #333333;
                        font-size: 16px; 
                        font-weight: bold; 
                        padding: 10px 20px; 
                        border: 1px solid #ddd; 
                        border-radius: 5px; 
                        cursor: pointer; 
                        transition: all 0.3s ease; 
                        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); 
                    }

                    .cctablinks.active {
                        background-color: #4274da; 
                        color: #ffffff; 
                        border-color: #4274da; 
                        box-shadow: 0 3px 6px rgba(0, 0, 0, 0.2); 
                    }


                    .cctablinks:hover {
                        background-color: #f0f0f0; 
                        color: #000000; 
                        transform: translateY(-2px); 
                        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.15); 
                    }


                    @media screen and (max-width: 768px) {
                        .cctab {
                            flex-wrap: wrap; 
                            gap: 8px; 
                        }

                        .cctablinks {
                            font-size: 14px; 
                            padding: 8px 15px; 
                        }
                    }

                    </style>



            </div>
        </div>
    </div>


    
    

            <div id="CCForm1" class="inner-block tms-block cctabcontent" style="margin-top:50px;">
                <div class="heading-tms">Induction Training</div>
              
                @php
                            
                    $documentsCollection = collect($useDocFromInductionTraining);

                  
                    $currentPage = request()->get('page', 1);

                    $perPage = 5;

                    $paginatedData = $documentsCollection->forPage($currentPage, $perPage);

                    $totalPages = ceil($documentsCollection->count() / $perPage);
                @endphp

                <div>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Sr.No.</th>
                                <th>Emp Code</th>
                                <th>Employee Name</th>
                                <th>Designation</th>
                                <th>SOP No.</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Remaining Attempts</th>
                                <th>Training Completion date</th>
                                <th>Preview SOP</th>
                                <th>Quiz</th>
                                <th>Certificate</th>
                               
                            </tr>
                        </thead>
                        <tbody id="searchTable">
                        @foreach ($paginatedData as $temp)
                            @php
                                $rowNumber = 1;
                            @endphp
                            @php
                                $getSOPNo = ['document_number_1', 'document_number_2', 'document_number_3', 'document_number_4', 'document_number_5','document_number_6', 'document_number_7', 'document_number_8', 'document_number_9', 'document_number_10', 'document_number_11', 'document_number_12', 'document_number_13', 'document_number_14', 'document_number_15','document_number_16'];
                                $dateValue = []; 

                                if ($temp) {
                                    foreach ($getSOPNo as $key => $document) {
                                      
                                        $startDateColumn = 'document_number_' .($key + 1);

                                      
                                        if (isset($temp->$startDateColumn) && !is_null($temp->$startDateColumn)) {
                                            $dateValue[] = $temp->$startDateColumn; 
                                        }
                                    }
                                }
                                    $inductionResult = DB::table('emp_training_quiz_results')->where(['training_id' => $temp->id, 'training_type' => "Induction Training", 'emp_id' => Auth::guard('employee')->user()->full_employee_id, 'result' => 'Pass'])->latest()->first();
                                    $encryptedTotalMinimumTime = Illuminate\Support\Facades\Crypt::encryptString($temp->total_minimum_time);
                                    $encryptedPerScreenRunningTime = Illuminate\Support\Facades\Crypt::encryptString($temp->per_screen_run_time);
                                    $encryptedPerSOPSpentTime = Illuminate\Support\Facades\Crypt::encryptString($temp->sop_spent_time);
                                    $commaSeparatedStartDates = implode(', ', $dateValue);
                                    $convertD = Illuminate\Support\Facades\Crypt::encryptString($commaSeparatedStartDates);
                            @endphp
                            @if($temp->stage >= 2)
                                <tr>
                                    <td>{{ $rowNumber++ }}</td>
                                    <td>{{ $temp->employee_id }}</td>
                                    <td>{{ Helpers::getEmpNameByCode($temp->employee_id) }}</td>
                                    <td>{{ $temp->designation }}</td>
                                    <td>{{ Helpers::getFormattedDocumentNumbers($commaSeparatedStartDates) }}</td>
                                    <td>{{  Helpers::getdateFormat($temp->start_date) }}</td>
                                    <td>{{  Helpers::getdateFormat($temp->end_date) }}</td>
                                    <td>{{ $temp->attempt_count == -1 ? 0 : $temp->attempt_count }}</td>
                                    <td>{{ $inductionResult ? Helpers::getdateFormat1($inductionResult->created_at): "-" }}</td>

                                    @if(($temp->per_screen_run_time * 60) > $temp->sop_spent_time)
                                    <td><a href="{{ url('induction_training-details', ['start_dates' => $convertD, 'total_time' => $encryptedTotalMinimumTime, 'screen_time' => $encryptedPerScreenRunningTime, 'job_training_id' => $temp->id, 'sop_spent_time' => $encryptedPerSOPSpentTime]) }}"><i class="fa-solid fa-eye"></i></a></td>

                                    @else
                                    <td>The Viewing Period For This SOP Has Expired</td> 
                                    @endif
                                    @if(($temp->total_minimum_time * 60) <= $temp->sop_spent_time)
                                    <td>
                                        @if ($inductionResult && $inductionResult->result == "Pass")
                                            Pass
                                        @elseif($temp->attempt_count <= 0)
                                            Attempts completed (Failed)
                                        @else
                                            <button type="button" class="btn btn-outline" style="background-color: #4274da; color: white;" onclick="window.location.href='/induction_question_training/{{$commaSeparatedStartDates}}/{{$temp->id}}';">
                                                Attempt Quiz
                                            </button>
                                        @endif

                                    </td>
                                    @else
                                    <td>Please Review The SOP Before Attempting The Quiz.</td>
                                    @endif
                                    <td>
                                        @if($temp->stage >=6)
                                            <button type="button" class="btn btn-outline" style="background-color: #4274da; color: white;" 
                                                    onclick="window.location.href='/induction_training_certificate/{{$temp->employee_id}}';">
                                                <i class="fa fa-certificate"></i>
                                            </button>
                                        @endif 
                                    </td>
                                    
                                
                                </tr>
                            @endif
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Pagination Links -->
                    <nav>
                        <ul class="pagination justify-content-center">
                            <!-- Previous Page Link -->
                            <li class="page-item {{ $currentPage == 1 ? 'disabled' : '' }}">
                                <a class="page-link" href="?page={{ $currentPage - 1 }}">Previous</a>
                            </li>

                            <!-- Page Number Links -->
                            @for ($page = 1; $page <= $totalPages; $page++)
                                <li class="page-item {{ $currentPage == $page ? 'active' : '' }}">
                                    <a class="page-link" href="?page={{ $page }}">{{ $page }}</a>
                                </li>
                            @endfor

                            <!-- Next Page Link -->
                            <li class="page-item {{ $currentPage == $totalPages ? 'disabled' : '' }}">
                                <a class="page-link" href="?page={{ $currentPage + 1 }}">Next</a>
                            </li>
                        </ul>
                    </nav>
                </div>

                <div class="heading-tms">On The Job Training</div>
            
                    @php
                            
                    $documentsCollection = collect($useDocFromJobTraining);

                    $currentPage = request()->get('page', 1);

                    $perPage = 5;

                    $paginatedData = $documentsCollection->forPage($currentPage, $perPage);

                    $totalPages = ceil($documentsCollection->count() / $perPage);

                @endphp

                <div>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Sr.No.</th>
                                <th>Emp Code</th>
                                <th>Employee Name</th>
                                <th>SOP No.</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Remaining Attempts</th>
                                <th>My Training Completion date</th>
                                <th>Preview SOP</th>
                                <th>Quiz</th>
                                <th>Certificate</th>
                            </tr>
                        </thead>
                        <tbody id="searchTable">
                            @foreach ($paginatedData as $temp)
                            @php
                                $rowNumber = 1;
                            @endphp
                            @php
                                $getSOPNo = ['reference_document_no_1', 'reference_document_no_2', 'reference_document_no_3', 'reference_document_no_4', 'reference_document_no_5'];
                                $dateValue = null; // Variable to store the date
                            if ($temp) {
                                        foreach ($getSOPNo as $key => $subject) {
                                            // Construct the corresponding startdate column name
                                            $startDateColumn = 'reference_document_no_' . ($key + 1); // This will create startdate_1, startdate_2, etc.

                                            // Check if the start date exists and is not null
                                            if (isset($temp->$startDateColumn) && !is_null($temp->$startDateColumn)) {
                                                $dateValue[] = $temp->$startDateColumn; // Add the date to the array
                                            }
                                        }
                                    }
                                    
                                    $encryptedTotalMinimumTime = Illuminate\Support\Facades\Crypt::encryptString($temp->total_minimum_time);
                                    $encryptedPerScreenRunningTime = Illuminate\Support\Facades\Crypt::encryptString($temp->per_screen_running_time);
                                    $encryptedPerSOPSpentTime = Illuminate\Support\Facades\Crypt::encryptString($temp->sop_spent_time);
                                    $commaSeparatedStartDates = implode(', ', $dateValue);
                                    $convertD = Illuminate\Support\Facades\Crypt::encryptString($commaSeparatedStartDates);
                                    
                                    $jobTrainingResult = DB::table('emp_training_quiz_results')->where(['training_id' => $temp->id, 'training_type' => "On The Job Training", 'emp_id' => Auth::guard('employee')->user()->full_employee_id, 'result' => 'Pass'])->latest()->first();
                                    
                            @endphp
                            @if($temp->stage >= 3)
                            <tr>
                                <td>{{ $rowNumber++ }}</td>
                                <td>{{ $temp->employee_id }}</td>
                                <td>{{ $temp->name }}</td>
                                <td>{{ Helpers::getFormattedDocumentNumbers($commaSeparatedStartDates) }}</td>
                                <td>{{  Helpers::getdateFormat($temp->start_date) }}</td>
                                <td>{{  Helpers::getdateFormat($temp->end_date) }}</td>
                                <td>{{ $temp->attempt_count == -1 ? 0 : $temp->attempt_count }}</td>
                                <td>{{ $jobTrainingResult ? Helpers::getdateFormat1($jobTrainingResult->created_at): "-" }}</td>

                                @if(($temp->per_screen_running_time * 60) > $temp->sop_spent_time)
                                <td><a href="{{ url('job_training-details', ['start_dates' => $convertD, 'total_time' => $encryptedTotalMinimumTime, 'screen_time' => $encryptedPerScreenRunningTime, 'job_training_id' => $temp->id, 'sop_spent_time' => $encryptedPerSOPSpentTime]) }}"><i class="fa-solid fa-eye"></i></a></td>
                                @else
                                <td>The Viewing Period For This SOP Has Expired</td> 
                                @endif
                                
                                    @if(($temp->total_minimum_time * 60) <= $temp->sop_spent_time)
                                    <td>
                                        @if ($jobTrainingResult && $jobTrainingResult->result == "Pass")
                                            Pass
                                        @elseif($temp->attempt_count <= 0)
                                            Attempts completed (Failed)
                                        @else
                                            <button type="button" class="btn btn-outline" style="background-color: #4274da; color: white;" onclick="window.location.href='/on_the_job_question_training/{{$commaSeparatedStartDates}}/{{$temp->id}}';">
                                                Attempt Quiz
                                            </button>
                                        @endif

                                    </td>
                                    @else
                                    <td>Please Review The SOP Before Attempting The Quiz.</td>
                                    @endif
     
                                @if($temp->stage >=5)
                                        <td>
                                            <button type="button" class="btn btn-outline" style="background-color: #4274da; color: white;"
                                                onclick="window.location.href='/job_training_certificate/{{$temp->id}}';"> 
                                                <i class="fa fa-certificate"></i>
                                            </button>
                                        </td>
                                    @endif   
                                                         
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                    </table>


                    <!-- Pagination Links -->
                    <nav>
                        <ul class="pagination justify-content-center">
                            <!-- Previous Page Link -->
                            <li class="page-item {{ $currentPage == 1 ? 'disabled' : '' }}">
                                <a class="page-link" href="?page={{ $currentPage - 1 }}">Previous</a>
                            </li>

                            <!-- Page Number Links -->
                            @for ($page = 1; $page <= $totalPages; $page++)
                                <li class="page-item {{ $currentPage == $page ? 'active' : '' }}">
                                    <a class="page-link" href="?page={{ $page }}">{{ $page }}</a>
                                </li>
                            @endfor

                            <!-- Next Page Link -->
                            <li class="page-item {{ $currentPage == $totalPages ? 'disabled' : '' }}">
                                <a class="page-link" href="?page={{ $currentPage + 1 }}">Next</a>
                            </li>
                        </ul>
                    </nav>
                </div>

                <div class="heading-tms">Classroom Training</div>
            
                    @php
                    
                    $documentsCollection = collect($useDocFromClassroom);

                    $currentPage = request()->get('page', 1);

                    $perPage = 5;

                    $paginatedData = $documentsCollection->forPage($currentPage, $perPage);

                    $totalPages = ceil($documentsCollection->count() / $perPage);

                @endphp

                <div>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Sr.No.</th>
                                <th>Emp Code</th>
                                <th>Employee Name</th>
                                <th>SOP No.</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Remaining Attempts</th>
                                <th>My Training Completion date</th>
                                <th>Preview SOP</th>
                                <th>Quiz</th>
                                <th>Certificate</th>
                            </tr>
                        </thead>
                        <tbody id="searchTable">
                            
                            @foreach ($paginatedData as $temp)
                            @php
                                $rowNumber = 1;
                            @endphp
                            @php
                                
                                $getSOPNo = ['reference_document_no_1', 'reference_document_no_2', 'reference_document_no_3', 'reference_document_no_4', 'reference_document_no_5'];
                                $dateValue = []; // Initialize as an empty array, not null
                                if ($temp) {
                                    foreach ($getSOPNo as $key => $subject) {
                                        // Construct the corresponding startdate column name
                                        $startDateColumn = 'reference_document_no_' . ($key + 1); // This will create reference_document_no_1, reference_document_no_2, etc.

                                        // Check if the start date exists and is not null
                                        if (isset($temp->$startDateColumn) && !is_null($temp->$startDateColumn)) {
                                            $dateValue[] = $temp->$startDateColumn; // Add the date to the array
                                        }
                                    }
                                }
                                $encryptedTotalMinimumTime = Illuminate\Support\Facades\Crypt::encryptString($temp->total_minimum_time);
                                $encryptedPerScreenRunningTime = Illuminate\Support\Facades\Crypt::encryptString($temp->per_screen_running_time);
                                $encryptedPerSOPSpentTime = Illuminate\Support\Facades\Crypt::encryptString($temp->sop_spent_time);

                                // Join the non-null start dates into a comma-separated string
                                $commaSeparatedStartDates = implode(', ', $dateValue);
                                $convertD = Illuminate\Support\Facades\Crypt::encryptString($commaSeparatedStartDates);
                                $jobTrainingResult = DB::table('emp_training_quiz_results')->where([
                                    'training_id' => $temp->id, 
                                    'training_type' => "Classroom Training", 
                                    'emp_id' => Auth::guard('employee')->user()->full_employee_id, 
                                    'result' => 'Pass'
                                ])->latest()->first();
                            @endphp

                            @if($temp->stage >= 3)
                            <tr>
                                <td>{{ $rowNumber++ }}</td>
                                <td>{{ $temp->employee_id }}</td>
                                <td>{{ $temp->name }}</td>
                                <td>{{ Helpers::getFormattedDocumentNumbers($commaSeparatedStartDates) }}</td>
                                <td>{{  Helpers::getdateFormat($temp->start_date) }}</td>
                                <td>{{  Helpers::getdateFormat($temp->end_date) }}</td>
                                <td>{{ $temp->attempt_count == -1 ? 0 : $temp->attempt_count }}</td>
                                <td>{{ $jobTrainingResult ? Helpers::getdateFormat1($jobTrainingResult->created_at): "-" }}</td>
                                
                                @if(($temp->per_screen_running_time * 60) > $temp->sop_spent_time)
                                <td><a href="{{ url('classroom_training-details', ['start_dates' => $convertD, 'total_time' => $encryptedTotalMinimumTime, 'screen_time' => $encryptedPerScreenRunningTime, 'classroom_training_id' => $temp->id, 'sop_spent_time' => $encryptedPerSOPSpentTime]) }}"><i class="fa-solid fa-eye"></i></a></td>
                                @else
                                <td>The Viewing Period For This SOP Has Expired</td> 
                                @endif

                                @if(($temp->total_minimum_time * 60) <= $temp->sop_spent_time)
                                <td>
                                    @if ($jobTrainingResult && $jobTrainingResult->result == "Pass")
                                        Pass
                                    @elseif($temp->attempt_count <= 0)
                                        Attempts completed (Failed)
                                    @else
                                        <button type="button" class="btn btn-outline" style="background-color: #4274da; color: white;" onclick="window.location.href='/on_the_classroom_question_training/{{$commaSeparatedStartDates}}/{{$temp->id}}';">
                                            Attempt Quiz
                                        </button>
                                    @endif

                                </td>
                                @else
                                  <td>Please Review The SOP Before Attempting The Quiz.</td>
                                @endif
                                @if($temp->stage >=5)
                                        <td>
                                            <button type="button" class="btn btn-outline" style="background-color: #4274da; color: white;"
                                                onclick="window.location.href='/classroom_training_certificate/{{$temp->id}}';"> 
                                                <i class="fa fa-certificate"></i>
                                            </button>
                                        </td>
                                    @endif   
                                                         
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Pagination Links -->
                    <nav>
                        <ul class="pagination justify-content-center">
                            <!-- Previous Page Link -->
                            <li class="page-item {{ $currentPage == 1 ? 'disabled' : '' }}">
                                <a class="page-link" href="?page={{ $currentPage - 1 }}">Previous</a>
                            </li>

                            <!-- Page Number Links -->
                            @for ($page = 1; $page <= $totalPages; $page++)
                                <li class="page-item {{ $currentPage == $page ? 'active' : '' }}">
                                    <a class="page-link" href="?page={{ $page }}">{{ $page }}</a>
                                </li>
                            @endfor

                            <!-- Next Page Link -->
                            <li class="page-item {{ $currentPage == $totalPages ? 'disabled' : '' }}">
                                <a class="page-link" href="?page={{ $currentPage + 1 }}">Next</a>
                            </li>
                        </ul>
                    </nav>
                </div>
   
                <div class="heading-tms">SOP Training</div>
                <br>
                 @php
                     // Convert the array to a collection
                     $documentsCollection = collect($trainingData);

                     // Set the current page from the URL or default to 1
                     $currentPage = request()->get('page', 1);

                     // Number of items per page
                     $perPage = 5;

                     // Slice the collection to get only the items for the current page
                     $paginatedData = $documentsCollection->forPage($currentPage, $perPage);

                     // Calculate total pages based on the total number of items and perPage limit
                     $totalPages = ceil($documentsCollection->count() / $perPage);
                 @endphp

                 <div>
                     <table class="table table-bordered">
                         <thead>
                             <tr>
                                <th>Sr.No.</th>
                                 <th>Training Plan</th>
                                 <th>SOP No.</th>
                                 <th>Trainer Name</th>
                                 <th>Overall Training Status</th>
                                 <th>Remaining Attempt</th>
                                 <th>My Training Completion date</th>
                                 <th>Preview SOP</th>
                                 <th>Quiz</th>
                             </tr>
                         </thead>
                         <tbody id="searchTable">
                             @foreach ($paginatedData as $temp)
                             {{-- {{ dd($temp) }} --}}
                             @php
                                $rowNumber = 1;
                            @endphp
                             @php
                                $encryptedTotalMinimumTime = Illuminate\Support\Facades\Crypt::encryptString($temp->total_minimum_time);
                                $encryptedPerScreenRunningTime = Illuminate\Support\Facades\Crypt::encryptString($temp->per_screen_run_time);
                                $encryptedPerSOPSpentTime = Illuminate\Support\Facades\Crypt::encryptString($temp->sop_spent_time);

                                // Join the non-null start dates into a comma-separated string
                                // $commaSeparatedStartDates = implode(', ', $temp->sop_id);
                                $convertD = Illuminate\Support\Facades\Crypt::encryptString($temp->sop_id);
                                     $jobTrainingResult = DB::table('emp_training_quiz_results')->where([
                                    'training_id' => $temp->id, 
                                    'training_type' => "SOP Training", 
                                    'emp_id' => Auth::guard('employee')->user()->full_employee_id, 
                                    'result' => 'Pass'
                                ])->latest()->first();

                                    $training = DB::table('trainings')->where('id', $temp->training_id)->latest()->first();
                             @endphp
                             <tr>
                                <td>{{ $rowNumber++ }}</td>
                                 <td>{{ $temp->training_name }}</td>
                                 <td>{{ $temp->sop_id }}</td>
                                 <td>{{ $temp->trainer_id }}</td>
                                 <td>{{ $training ? $training->status : '-' }}</td>
                                    <td>{{ $temp->attempt_count }}</td>
                                 {{-- <td>{{ $trainingStatusCheck ? \Carbon\Carbon::parse($trainingStatusCheck->created_at)->format('d M Y') : '-' }}</td> --}}
                                 <td>{{ $jobTrainingResult ? Helpers::getdateFormat1($jobTrainingResult->created_at): "-" }}</td>

                                 @if(($temp->per_screen_run_time * 60) > $temp->sop_spent_time)
                                    <td><a href="{{ url('sop_training_details', ['start_dates' => $temp->sop_id, 'total_time' => $encryptedTotalMinimumTime, 'screen_time' => $encryptedPerScreenRunningTime, 'sop_training_id' => $temp->id, 'sop_spent_time' => $encryptedPerSOPSpentTime]) }}"><i class="fa-solid fa-eye"></i></a></td>
                                @else
                                    <td>The Viewing Period For This SOP Has Expired</td> 
                                @endif

                                @if(($temp->total_minimum_time * 60) <= $temp->sop_spent_time)
                                <td>
                                    @if ($jobTrainingResult && $jobTrainingResult->result == "Pass")
                                        Pass
                                    @elseif($temp->attempt_count <= 0)
                                        Attempts completed (Failed)
                                    @else
                                        <button type="button" class="btn btn-outline" style="background-color: #4274da; color: white;" onclick="window.location.href='/sop_question_training/{{$temp->quize}}/{{$temp->id}}';">
                                            Attempt Quiz
                                        </button>
                                    @endif

                                </td>
                                @else
                                  <td>Please Review The SOP Before Attempting The Quiz.</td>
                                @endif
                             </tr>
                             @endforeach
                         </tbody>
                     </table>

                     <!-- Pagination Links -->
                     <nav>
                         <ul class="pagination justify-content-center">
                             <!-- Previous Page Link -->
                             <li class="page-item {{ $currentPage == 1 ? 'disabled' : '' }}">
                                 <a class="page-link" href="?page={{ $currentPage - 1 }}">Previous</a>
                             </li>

                             <!-- Page Number Links -->
                             @for ($page = 1; $page <= $totalPages; $page++)
                                 <li class="page-item {{ $currentPage == $page ? 'active' : '' }}">
                                     <a class="page-link" href="?page={{ $page }}">{{ $page }}</a>
                                 </li>
                             @endfor

                             <!-- Next Page Link -->
                             <li class="page-item {{ $currentPage == $totalPages ? 'disabled' : '' }}">
                                 <a class="page-link" href="?page={{ $currentPage + 1 }}">Next</a>
                             </li>
                         </ul>
                     </nav>
                 </div>

             
        <div class="heading-tms">Job Role Training</div>
        @php
            $documentsCollection = collect($useDocFromDepartmentRole);
            $currentPage = request()->get('page', 1);
            $perPage = 5;
            $paginatedData = $documentsCollection->forPage($currentPage, $perPage);
            $totalPages = ceil($documentsCollection->count() / $perPage);
        @endphp

        <div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Sr.No.</th>
                        <th>Emp Code</th>
                        <th>Employee Name</th>
                        <th>Department</th>
                        <th>Doc. Number</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Remaining Attempts</th>
                        <th>Training Completion date</th>
                        <th>Preview SOP</th>
                        <th>Attempt Quiz</th>
                        {{-- <th>Certificate</th> --}}
                    </tr>
                </thead>
                <tbody id="searchTable">
                    @php
                        $rowNumber = 1;
                    @endphp
                    @foreach ($departmentRoles as $temp)
                        @if ($temp->employee_code == Auth::guard('employee')->user()->full_employee_id && $temp->training_effective == true)
                            @php
                                $documentNumbers = explode(',', $temp->document_number);
                            @endphp
                            
                            @foreach ($documentNumbers as $document)
                                @php
                                    $document = trim($document);
                                    // Fetch existing quiz results for the specific document number
                                    $quizResult = DB::table('emp_training_quiz_results')
                                        ->where([
                                            'training_id' => $temp->id,
                                            'training_type' => "Department Wise Job Role",
                                            'emp_id' => Auth::guard('employee')->user()->full_employee_id,
                                            'document_number' => $document, 
                                        ])
                                        ->latest()
                                        ->first();

                                    // Count how many attempts have been made for this specific document
                                    $attemptsMade = DB::table('emp_training_quiz_results')
                                        ->where([
                                            'training_id' => $temp->id,
                                            'emp_id' => Auth::guard('employee')->user()->full_employee_id,
                                            'document_number' => $document
                                        ])
                                        ->count();

                                    $encryptedTotalMinimumTime = Illuminate\Support\Facades\Crypt::encryptString($temp->total_minimum_time);
                                    $encryptedPerScreenRunningTime = Illuminate\Support\Facades\Crypt::encryptString($temp->per_screen_run_time);
                                    $encryptedPerSOPSpentTime = Illuminate\Support\Facades\Crypt::encryptString($temp->sop_spent_time);
                                    $commaSeparatedStartDates = implode(', ', $documentNumbers);
                                    $convertD = Illuminate\Support\Facades\Crypt::encryptString($commaSeparatedStartDates);

                                    // Calculate remaining attempts based on the total attempts and the attempts made so far
                                    $remainingAttempts = $temp->attempt_count - $attemptsMade;
                                    // Ensure remaining attempts cannot go below 0
                                    $remainingAttempts = max($remainingAttempts, 0);
                                @endphp

                                <tr>
                                    <td>{{ $rowNumber++ }}</td>
                                    <td>{{ $temp->employee_code }}</td>
                                    <td>{{ Helpers::getNameById($temp->employee_name) }}</td>
                                    <td>{{ Helpers::getFullDepartmentName($temp->department) }}</td>
                                    <td>{{ Helpers::getFormattedDocumentNumbers($document) }}</td>
                                    <td>{{ Helpers::getdateFormat($temp->start_date) }}</td>
                                    <td>{{ Helpers::getdateFormat($temp->end_date) }}</td>
                                    <td>{{ $quizResult ? (3- $quizResult->attempt_number) : 3}}</td>

                                    {{-- <td>{{ $quizResult ? Helpers::getdateFormat1($quizResult->created_at) : "-" }}</td> --}}
                                    <td>
                                        @if($quizResult && $quizResult->result == "Pass")
                                            {{Helpers::getdateFormat1($quizResult->created_at)}}
                                        @else
                                        -
                                        @endif  
                                    </td>
                                    @if(($temp->per_screen_run_time * 60) > $temp->sop_spent_time)
                                        <td><a href="{{ url('department_wise_training-details', ['start_dates' => $convertD, 'total_time' => $encryptedTotalMinimumTime, 'screen_time' => $encryptedPerScreenRunningTime, 'job_training_id' => $temp->id, 'sop_spent_time' => $encryptedPerSOPSpentTime]) }}"><i class="fa-solid fa-eye"></i></a></td>        
                                    @else
                                        <td>The Viewing Period For This SOP Has Expired</td> 
                                    @endif
   
                                    @if(($temp->total_minimum_time * 60) <= $temp->sop_spent_time)
                                        <td>
                                            @if ($quizResult && $quizResult->result == "Pass")
                                                Pass
                                            @elseif($quizResult && (3 - $quizResult->attempt_number) <= 0)
                                                Attempts completed (Failed)
                                            @else
                                                <button type="button" class="btn btn-outline" style="background-color: #4274da; color: white;"
                                                        onclick="window.location.href='/departmentwisequestionshow/{{ $document }}/{{ $temp->id }}';">
                                                    Attempt Quiz
                                                </button>
                                            @endif

                                        </td>
                                    @else
                                        <td>Please Review The SOP Before Attempting The Quiz.</td>
                                    @endif
                                </tr>
                            @endforeach
                        @endif
                    @endforeach
                </tbody>
            </table>



    <!-- Pagination Links -->
    <nav>
        <ul class="pagination justify-content-center">
            <li class="page-item {{ $currentPage == 1 ? 'disabled' : '' }}">
                <a class="page-link" href="?page={{ $currentPage - 1 }}">Previous</a>
            </li>
            @for ($page = 1; $page <= $totalPages; $page++)
                <li class="page-item {{ $currentPage == $page ? 'active' : '' }}">
                    <a class="page-link" href="?page={{ $page }}">{{ $page }}</a>
                </li>
            @endfor
            <li class="page-item {{ $currentPage == $totalPages ? 'disabled' : '' }}">
                <a class="page-link" href="?page={{ $currentPage + 1 }}">Next</a>
            </li>
        </ul>
    </nav>
</div>




<div class="heading-tms">TNI Matrix Training</div>

@php
    // Paginate the data array
    $documentsCollection = collect($tniMg);
    $currentPage = request()->get('page', 1);
    $perPage = 5;
    $paginatedData = $documentsCollection->forPage($currentPage, $perPage);
    $totalPages = ceil($documentsCollection->count() / $perPage);

    // Employee designation
    $myDesg = Auth::guard('employee')->user()->job_title;
@endphp

        <div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Sr.No.</th>
                        <th>Designation</th>
                        <th>Doc. Number</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Remaining Attempts</th>
                        <th>Training Completion Date</th>
                        <th>Preview SOP</th>
                        <th>Attempt Quiz</th>
                    </tr>
                </thead>
                <tbody id="searchTable">
                    @php $rowNumber = 1; @endphp

                    @foreach ($paginatedData as $temp)
                        @php
                            $document = $temp->documentNumber;
                            
                            $quizResult = DB::table('emp_training_quiz_results')
                                ->where([
                                    'training_id' => $temp->id,
                                    'training_type' => "TNI Matrix",
                                    'emp_id' => Auth::guard('employee')->user()->id,
                                    'document_number' => $document,
                                ])
                                ->latest()
                                ->first();       

                                $encryptedTotalMinimumTime = Illuminate\Support\Facades\Crypt::encryptString($temp->total_minimum_time);
                                            $encryptedPerScreenRunningTime = Illuminate\Support\Facades\Crypt::encryptString($temp->per_screen_run_time);
                                            $encryptedPerSOPSpentTime = Illuminate\Support\Facades\Crypt::encryptString($temp->sop_spent_time);                                            
                                            $convertD = Illuminate\Support\Facades\Crypt::encryptString($document);

                            // Count attempts made for the specific document
                            $attemptsMade = DB::table('emp_training_quiz_results')
                                ->where([
                                    'training_id' => $temp->id,
                                    'emp_id' => Auth::guard('employee')->user()->full_employee_id,
                                    'document_number' => $document,
                                ])
                                ->count();

                            // Calculate remaining attempts
                            $remainingAttempts = max($temp->attempt_count - $attemptsMade, 0);

                            // Convert designation list to an array
                            $designationList = explode(',', $temp['designation']);
                            
                            // Check if employee's designation is in the designation list
                            $checkDesignation = in_array(trim($myDesg), array_map('trim', $designationList));
                        @endphp

                        @if ($checkDesignation)
                            <tr>
                                <td>{{ $rowNumber++ }}</td>
                                <td>{{ $temp['designation'] }}</td>
                                <td>{{ Helpers::getFormattedDocumentNumbers($document) }}</td>
                                <td>{{ \Carbon\Carbon::parse($temp->startDate)->format('d-m-Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($temp->endDate)->format('d-m-Y') }}</td>
                                <td>{{ $remainingAttempts }}</td>
                                <td>
                                    @if($quizResult && $quizResult->result == "Pass")
                                        {{ Helpers::getdateFormat1($quizResult->created_at) }}
                                    @else
                                        -
                                    @endif
                                </td>
                                @if(($temp->per_screen_run_time * 60) > $temp->sop_spent_time)
                                    <td><a href="{{ url('tni_matrix_training-details', ['start_dates' => $convertD, 'total_time' => $encryptedTotalMinimumTime, 'screen_time' => $encryptedPerScreenRunningTime, 'job_training_id' => $temp->id, 'sop_spent_time' => $encryptedPerSOPSpentTime]) }}"><i class="fa-solid fa-eye"></i></a></td>
                                @else
                                    <td>The Viewing Period For This SOP Has Expired</td> 
                                @endif
                                @if(($temp->total_minimum_time * 60) <= $temp->sop_spent_time)
                                    <td>
                                        @if ($quizResult && $quizResult->result == "Pass")
                                            Pass
                                        @elseif ($quizResult && ((3 - $quizResult->attempt_number) <= 0))
                                            Attempts completed (Failed)
                                        @else
                                            <button type="button" class="btn btn-outline" style="background-color: #4274da; color: white;"
                                                    onclick="window.location.href='/tnimatrixequestionshow/{{ $document }}/{{ $temp['id'] }}';">
                                                Attempt Quiz
                                            </button>
                                        @endif
                                    </td>
                                @else
                                <td>Please Review The SOP Before Attempting The Quiz.</td>
                                @endif
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>



            <!-- Pagination Links -->
            <nav>
                <ul class="pagination justify-content-center">
                    <li class="page-item {{ $currentPage == 1 ? 'disabled' : '' }}">
                        <a class="page-link" href="?page={{ $currentPage - 1 }}">Previous</a>
                    </li>
                    @for ($page = 1; $page <= $totalPages; $page++)
                        <li class="page-item {{ $currentPage == $page ? 'active' : '' }}">
                            <a class="page-link" href="?page={{ $page }}">{{ $page }}</a>
                        </li>
                    @endfor
                    <li class="page-item {{ $currentPage == $totalPages ? 'disabled' : '' }}">
                        <a class="page-link" href="?page={{ $currentPage + 1 }}">Next</a>
                    </li>
                </ul>
            </nav>
        </div>



{{-- ////////////////////////////Change Control Training///////////////////////// --}}

<div class="heading-tms">Change Control Training</div>
                @php
                    $documentsCollection = collect($ccTrainingData);
                    $currentPage = request()->get('page', 1);
                    $perPage = 5;
                    $paginatedData = $documentsCollection->forPage($currentPage, $perPage);
                    $totalPages = ceil($documentsCollection->count() / $perPage);

                @endphp
                <div>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Sr.No.</th>
                                <th>Emp Code</th>
                                <th>Employee Name</th>
                                <th>Department</th>
                                <th>Doc. Number</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Remaining Attempts</th>
                                <th>Training Completion date</th>
                                <th>Preview SOP</th>
                                <th>Attempt Quiz</th>
                            </tr>
                        </thead>
                        <tbody>
                        @php $rowNumber = 1; @endphp
                            @foreach($paginatedData as $record)
                            @php
                            $document = $record->documentNumber;
                            $encryptedTotalMinimumTime = Illuminate\Support\Facades\Crypt::encryptString($record->total_minimum_time);
                                $encryptedPerScreenRunningTime = Illuminate\Support\Facades\Crypt::encryptString($record->per_screen_run_time);
                                $encryptedPerSOPSpentTime = Illuminate\Support\Facades\Crypt::encryptString($record->sop_spent_time);
                                $convertD = Illuminate\Support\Facades\Crypt::encryptString($record->documentNumber);     

                                $quizResult = DB::table('emp_training_quiz_results')
                                    ->where([
                                        'training_id' => $record->id,
                                        'training_type' => "Change Control SOP Training",
                                        'emp_id' => Auth::guard('employee')->user()->id,
                                        'document_number' => $document,
                                    ])
                                    ->latest()
                                    ->first();       
                            @endphp
                                <tr>
                                    <td>{{ $rowNumber++ }}</td>
                                    <td> 
                                        {{ $record->full_employee_id ?? 'N/A'}}
                                    </td>
                                    <td>
                                        {{ $record->employee_name ?? 'N/A'}}
                                    </td>
                                    <td>
                                        {{ Helpers::getFullDepartmentName($record->department) ?? 'N/A'}}
                                    </td>
                                    <td>{{ $record->documentName ?? 'N/A' }}</td>
                                    <td>{{ Helpers::getdateFormat($record->startDate) ?? 'N/A' }}</td>
                                    <td>{{ Helpers::getdateFormat($record->endDate) ?? 'N/A' }}</td>
                                    <td>{{ $record->trainingAttempt ?? 'N/A' }}</td>
                                    <td>
                                        @if($quizResult && $quizResult->result == "Pass")
                                            {{ Helpers::getdateFormat1($quizResult->created_at) }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    @if(($record->per_screen_run_time * 60) > $record->sop_spent_time)
                                        <td><a href="{{ url('change-control-training-detail', ['start_dates' => $convertD, 'total_time' => $encryptedTotalMinimumTime, 'screen_time' => $encryptedPerScreenRunningTime, 'job_training_id' => $record->id, 'sop_spent_time' => $encryptedPerSOPSpentTime]) }}"><i class="fa-solid fa-eye"></i></a></td>
                                    @else
                                        <td>The Viewing Period For This SOP Has Expired</td> 
                                    @endif
                                    
                                        @php
                                            $quizResult = DB::table('emp_training_quiz_results')
                                            ->where([
                                                'training_id' => $record->id,
                                                'training_type' => "Change Control SOP Training",
                                                'emp_id' => $record->trainees,
                                                'document_number' => $record->documentNumber,
                                                'result' => 'Pass'
                                            ])
                                            ->latest()
                                            ->first();
                                        @endphp
                                         @if(($record->total_minimum_time * 60) <= $record->sop_spent_time)
                                            <td>
                                                @if ($quizResult && $quizResult->result == "Pass")
                                                    Pass
                                                @elseif($record->trainingAttempt <= 0)
                                                    Attempts completed (Failed)
                                                @else
                                                    <button type="button" class="btn btn-outline" style="background-color: #4274da; color: white;"
                                                            onclick="window.location.href='/changeControlQuestionShow/{{ $record->documentNumber }}/{{ $record->id }}';">
                                                        Attempt Quiz
                                                    </button>
                                                @endif
                                        </td>
                                         @else
                                           <td>Please Review The SOP Before Attempting The Quiz.</td>
                                         @endif
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                    <nav>
                        <ul class="pagination justify-content-center">
                            <li class="page-item {{ $currentPage == 1 ? 'disabled' : '' }}">
                                <a class="page-link" href="?page={{ $currentPage - 1 }}">Previous</a>
                            </li>
                            @for ($page = 1; $page <= $totalPages; $page++)
                                <li class="page-item {{ $currentPage == $page ? 'active' : '' }}">
                                    <a class="page-link" href="?page={{ $page }}">{{ $page }}</a>
                                </li>
                            @endfor
                            <li class="page-item {{ $currentPage == $totalPages ? 'disabled' : '' }}">
                                <a class="page-link" href="?page={{ $currentPage + 1 }}">Next</a>
                            </li>
                        </ul>
                    </nav>
                </div>

    {{-- ///// TNI Employee Training /////--}}

    <div class="heading-tms">TNI Employee Training</div>
        @php
            $documentsCollection = collect($tniEmp);
            $currentPage = request()->get('page', 1);
            $perPage = 5;
            $paginatedData = $documentsCollection->forPage($currentPage, $perPage);
            $totalPages = ceil($documentsCollection->count() / $perPage);
        @endphp

        <div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Sr.No.</th>
                        <th>Emp Code</th>
                        <th>Employee Name</th>
                        <th>Department</th>
                        <th>Doc. Number</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Remaining Attempts</th>
                        <th>Training Completion date</th>
                        <th>Preview SOP</th>
                        <th>Attempt Quiz</th>
                        {{-- <th>Certificate</th> --}}
                    </tr>
                </thead>
                <tbody id="searchTable">
                    @php
                        $rowNumber = 1;
                    @endphp
                    @foreach ($tniEmp as $temp)
                        @if ($temp->employee_code == Auth::guard('employee')->user()->full_employee_id)
                            @php
                                $documentNumbers = explode(',', $temp->document_number);
                            @endphp
                            
                            @foreach ($documentNumbers as $document)
                                @php
                                    $document = trim($document);
                                    
                                    $quizResult = DB::table('emp_training_quiz_results')
                                        ->where([
                                            'training_id' => $temp->id,
                                            'training_type' => "TNI Employee",
                                            'emp_id' => Auth::guard('employee')->user()->full_employee_id,
                                            'document_number' => $document, 
                                        ])
                                        ->latest()
                                        ->first();
                                    

                                    // Count how many attempts have been made for this specific document
                                    $attemptsMade = DB::table('emp_training_quiz_results')
                                        ->where([
                                            'training_id' => $temp->id,
                                            'emp_id' => Auth::guard('employee')->user()->full_employee_id,
                                            'document_number' => $document
                                        ])
                                        ->count();

                                    $encryptedTotalMinimumTime = Illuminate\Support\Facades\Crypt::encryptString($temp->total_minimum_time);
                                    $encryptedPerScreenRunningTime = Illuminate\Support\Facades\Crypt::encryptString($temp->per_screen_run_time);
                                    $encryptedPerSOPSpentTime = Illuminate\Support\Facades\Crypt::encryptString($temp->sop_spent_time);
                                    $commaSeparatedStartDates = implode(', ', $documentNumbers);
                                    $convertD = Illuminate\Support\Facades\Crypt::encryptString($commaSeparatedStartDates);

                                    // Calculate remaining attempts based on the total attempts and the attempts made so far
                                    $remainingAttempts = $temp->attempt_count - $attemptsMade;
                                    // Ensure remaining attempts cannot go below 0
                                    $remainingAttempts = max($remainingAttempts, 0);
                                @endphp

                                <tr>
                                    <td>{{ $rowNumber++ }}</td>
                                    <td>{{ $temp->employee_code }}</td>
                                    <td>{{ $temp->employee_name }}</td>
                                    <td>{{ $temp->department }}</td>
                                    <td>{{ Helpers::getFormattedDocumentNumbers($document) }}</td>
                                    <td>{{ Helpers::getdateFormat($temp->startdate) }}</td>
                                    <td>{{ Helpers::getdateFormat($temp->enddate) }}</td>
                                    <td>{{ $quizResult ? 3 - $quizResult->attempt_number : 3}}</td>

                                    {{-- <td>{{ $quizResult ? Helpers::getdateFormat1($quizResult->created_at) : "-" }}</td> --}}
                                    <td>
                                        @if($quizResult && $quizResult->result == "Pass")
                                            {{Helpers::getdateFormat1($quizResult->created_at)}}
                                        @else
                                        -
                                        @endif  
                                    </td>

                                    @if(($temp->per_screen_run_time_1 * 60) > $temp->sop_spent_time_1)
                                        <td><a href="{{ url('tni_sop_details', ['start_dates' => $convertD, 'total_time' => $encryptedTotalMinimumTime, 'screen_time' => $encryptedPerScreenRunningTime, 'tni_emp_training_id' => $temp->id, 'sop_spent_time_1' => $encryptedPerSOPSpentTime]) }}"><i class="fa-solid fa-eye"></i></a></td>  
                                    @else
                                        <td>The Viewing Period For This SOP Has Expired</td> 
                                    @endif
   
                                    @if(($temp->total_minimum_time_1 * 60) <= $temp->sop_spent_time_1)
                                        <td>
                                            @if ($quizResult && $quizResult->result == "Pass")
                                                Pass
                                            @elseif($quizResult && $quizResult->attempt_number <= 0)
                                                Attempts completed (Failed)
                                            @else
                                                <button type="button" class="btn btn-outline" style="background-color: #4274da; color: white;"
                                                        onclick="window.location.href='/tniquestionshow/{{ $document }}/{{ $temp->id }}';">
                                                    Attempt Quiz
                                                </button>
                                            @endif

                                        </td>
                                    @else
                                        <td>Please Review The SOP Before Attempting The Quiz.</td>
                                    @endif
                                </tr>
                            @endforeach
                        @endif
                    @endforeach
                </tbody>
            </table>



    <!-- Pagination Links -->
    <nav>
        <ul class="pagination justify-content-center">
            <li class="page-item {{ $currentPage == 1 ? 'disabled' : '' }}">
                <a class="page-link" href="?page={{ $currentPage - 1 }}">Previous</a>
            </li>
            @for ($page = 1; $page <= $totalPages; $page++)
                <li class="page-item {{ $currentPage == $page ? 'active' : '' }}">
                    <a class="page-link" href="?page={{ $page }}">{{ $page }}</a>
                </li>
            @endfor
            <li class="page-item {{ $currentPage == $totalPages ? 'disabled' : '' }}">
                <a class="page-link" href="?page={{ $currentPage + 1 }}">Next</a>
            </li>
        </ul>
    </nav>
</div>


         </div>
      </div>
      </div>




     <div id="CCForm2" class="inner-block tms-block cctabcontent" style="margin-top:50px;">
        <div class="heading-tms">Training Calender</div>

        <div id="document">
            <div class="container-fluid">
                <div class="dashboard-container">
                    <div class="row">
                        <div class="col-xl-12 col-lg-12">
                            <div class="document-left-block">
                                <div class="inner-block table-block">

                                    <div id="calendar"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>


        {{-- <script>
            $(document).ready(function() {
                var calendarEl = document.getElementById('calendar');
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth', // Show monthly view
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay'
                    },
                    events: @json($trainingStartDates), // Pass your events as JSON
                });
                calendar.render();
            })
        </script> --}}
        <script>
            $(document).ready(function() {
                var calendarEl = document.getElementById('calendar');
                
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay'
                    },
                    events: @json($trainingStartDates),
                    
                    eventClick: function(info) {
                        info.jsEvent.preventDefault();
                        window.location.href = '/tms-training?title=' + info.event.title;
                    }
                });

                calendar.render();
            });
        </script>
    </div>

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

            // Find the index of the clicked tab button
            const index = Array.from(cctablinks).findIndex(button => button === evt.currentTarget);

            // Update the currentStep to the index of the clicked tab
            currentStep = index;
        }
    </script>


            </div>
            
            
</body>
</html>