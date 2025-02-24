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

    <div class="form-field-head">
        <div class="division-bar">
            <strong>Site Division/Project</strong> :
            {{ "India" }} / Task Management
            {{-- KSA / Root Cause Analysis   --}}
            {{-- EHS-North America --}}
        </div>
    </div>

    @php
        $users = DB::table('users')->get();
    @endphp

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
            <div class="language-sleect d-flex" style="align-items: center; gap: 20px; margin-left: 20px;">
                <div>Select Language </div>
            <div class="main-head" id="google_translate_element"></div>
            </div>
            <div class="cctab">

                <button class="cctablinks" onclick="openCity(event, 'CCForm1')">General Information</button>
                <!-- <button class="cctablinks" onclick="openCity(event, 'CCForm3')">Activity Log</button> -->
            </div>


            <form  action="{{ route('task_management_store') }}" method="post" enctype="multipart/form-data">
                @csrf

                <div id="step-form">    
                    @if (!empty($parent_id))
                        <input type="hidden" name="parent_id" value="{{ $parent_id }}">
                        <input type="hidden" name="parent_type" value="{{ $parent_type }}">
                    @endif

                    <div id="CCForm1" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="RLS Record Number"><b>Record Number</b></label>
                                        <input disabled type="text" name="record_number"
                                            value="{{ Helpers::getDivisionName(session('division')) }} /{{ Auth::user()->name }}/{{ now()->format('d-M-Y') }}/{{ str_pad($record_number, 6, '0', STR_PAD_LEFT) }}">

                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="originator">Initiator</label>
                                        <input readonly type="text" name="originator_id"
                                            value="{{ Auth::user()->name }}" />
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input ">
                                        <label for="Date Due"><b>Date of Initiation</b></label>
                                        <input disabled type="text" value="{{ date('d-M-Y') }}" name="intiation_date">
                                        <input type="hidden" value="{{ date('d-m-Y') }}" name="intiation_date">
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

                               

                                <!-- =========================================================== -->
                                <div class="col-12 mb-4">
                                    <div class="group-input">
                                        <label for="agenda">
                                            Task Management
                                            <button type="button" name="agenda"
                                                id="task_manamegemnt_grid">+</button>
                                        </label>
                                        <div class="table-responsive">
                                            <table class="table table-bordered" style="width: 250%" id="task_Management_Table">
                                                <thead>
                                                    <tr style="text-align: center; vertical-align: middle; padding: 20px;">
                                                       
                                                        <th>Row #</th>
                                                        <th>Repo Name / Instance Name</th>
                                                        <th>Developer Name</th>
                                                        <th>Customer Name</th>
                                                        <th>Activities</th>
                                                        <th> Start Date</th>
                                                        <th>TCD task Completion Date</th>
                                                        <th>Time Required</th>
                                                        {{-- <th>TCD task Completion Date</th> --}}
                                                        {{-- <th>Status</th> --}}
                                                        <th>Work in Progress Details</th>
                                                        <th>Remaining Activity / Task</th>
                                                        <th>Time Required for Remaining Activity / Task</th>
                                                        <th>Testing Completed by Developer</th>
                                                        <th>Developer Testing Details</th>
                                                        <th>Remaining Work</th>
                                                        <th>Remaining Work Testing</th>
                                                        <th>Validation Team Name</th>
                                                        <th>Validation Team Remark</th>
                                                        <th>Configuration update as per Validation Team</th>
                                                        {{-- <th>Developer Name</th> --}}
                                                        {{-- <th> Start Date</th> --}}
                                                        <th>Revalidation Team Name</th>
                                                        <th>Revalidation Remark</th>
                                                        {{-- <th>Revalidation Team Name</th> --}}
                                                        {{-- <th>TCD</th> --}}
                                                        <th>Final Status</th>
                                                        <th>Completion Date</th>
                                                        <th>Reviewer Remarks</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <input disabled type="text" name="TaskManagementData[0][serial]" value="1">
                                                        </td>
                                                        <td>
                                                            
                                                            <select id="" placeholder="Select..." name="TaskManagementData[0][repo_name]">
                                                                <option value="">-- Select --</option>
                                                                <option value="agio_pre_prod">Agio_pre_prod</option>
                                                                <option value="annuh-pharma">Annuh-Pharma</option>
                                                                <option value="environmentallab">Environmentlab</option>
                                                                <option value="invoice-management">Invoice-Management</option>
                                                                <option value="lims-laravel">Lims-laravel</option>
                                                                <option value="Medicef-main">Medicef-Main</option>
                                                            > 
                                                        </td>
                                                        <td>
                                                            <select id="" placeholder="Select..." name="TaskManagementData[0][module_process]">
                                                                <option value="">-- Select --</option>
                                                                <option value="adtiyarajput">Aditya Rajput</option>
                                                                <option value="adtiyapatel">Aditya Patel</option>
                                                                <option value="AkashMishra">Akash Mishra</option>
                                                                <option value="Ashishverma">Ashish Verma</option>
                                                                <option value="Farhankhan">Farhan Khan</option>
                                                                <option value="Gauravpandit">Gaurav Pandit</option>
                                                                <option value="gauravmeena">Gaurav Meena</option>
                                                                <option value="Harsh_Sardiya">Harsh Sardiya</option>
                                                                <option value="Harsh_chhari">Harsh Chhari</option>
                                                                <option value="KuldeepPatel">Kuldeep Patel</option>
                                                                <option value="Lavesh Jain">Lavesh Jain</option>
                                                                <option value="Leeladharkurmi">Leeladhar Kurmi</option>
                                                                <option value="ManishMalviya">Manish Malviya</option>
                                                                <option value="Mayankrathore">Mayank Rathore</option>
                                                                <option value="monikachaurasiya">Monika Chaurasiya</option>
                                                                <option value="NavneetChoudhary">Navneet Choudhary</option>
                                                                <option value="Nickshaychouhan">Nickshay Chouhan</option>
                                                                <option value="nilesh_birla">Nilesh Birla</option>
                                                                <option value="Pankajchohan">Pankaj Chohan</option>
                                                                <option value="Pankajjat">Pankaj Jat</option>
                                                                <option value="ParmodKumar">Parmod Kumar</option>
                                                                <option value="Prabhjotbhatia">Prabhjot Bhatia</option>
                                                                <option value="Rajendrarajput">Rajendra Rajput</option>
                                                                <option value="Rahulawarkar">Rahul Awarkar</option>
                                                                <option value="Rupeshpatil">Rupesh Patil</option>
                                                                <option value="SauravKumar">Saurav Kumar</option>
                                                                <option value="Shivampatel">Shivam Patel</option>
                                                                <option value="Shreyadwivedi">Shreya Dwivedi</option>
                                                                <option value="Shrutidwivedi">Shruti Dwivedi</option>
                                                                <option value="Shubhammeena">Shubham Meena </option>
                                                                <option value="Snehabaldeva">Sneha Baldeva </option>
                                                                <option value="SunilPatel">Sunil Patel</option>
                                                                <option value="Swapnilpatil">Swapnil Patil</option>
                                                                <option value="Tushalpatel">Tushal Patel</option>
                                                                <option value="VaibhavAwarkar">Vaibhav Awarkar</option>
                                                            > 
                                                        </td>
                                                        <td>
                                                            <select id="" placeholder="Select..." name="TaskManagementData[0][activity_task]">
                                                                <option value="">-- Select --</option>
                                                                <option value="agio">Agio</option>
                                                                <option value="annuh">Annuh Pharma</option>
                                                                <option value="environmental">Environmental</option>
                                                                <option value="invoice">Invoice</option>
                                                                <option value="lims">Lims</option>
                                                                <option value="Medicef">Medicef</option>
                                                            > 
                                                        </td>
                                                        <td>
                                                            <input type="text" name="TaskManagementData[0][activity1_task]">
                                                        </td>
                                                        <td>
                                                            <input type="datetime-local" name="TaskManagementData[0][task_date_time]" class="datetimepicker">
                                                        </td>

                                                        <td>
                                                            <input type="datetime-local" name="TaskManagementData[0][testing_completed_by_developer_on]" class="datetimepicker">
                                                        </td>
                                                        
                                                        <td>
                                                            <div class="time-required">
                                                                <input type="number" id="days" placeholder="Enter days"  
                                                                    name="TaskManagementData[0][days]" value="0" 
                                                                    oninput="updateTime()" 
                                                                    style="border: 1px solid #000; padding: 5px; border-radius: 5px;">
                                                                Days
                                                                <input type="number" id="hours" placeholder="Enter hours" 
                                                                    name="TaskManagementData[0][hours]" value="0" 
                                                                    oninput="updateTime()" 
                                                                    style="border: 1px solid #000; padding: 5px; border-radius: 5px;">
                                                                Hours

                                                                <input type="number" id="minutes" placeholder="Enter minutes" 
                                                                    name="TaskManagementData[0][minutes]" value="0" 
                                                                    oninput="updateTime()" 
                                                                    style="border: 1px solid #000; padding: 5px; border-radius: 5px;">
                                                                Minutes
                                                            </div>

                                                        </td>

                                                        {{-- <td>
                                                            <select name="TaskManagementData[0][status]">
                                                                <option value="">-- Select --</option>
                                                                <option value="Yes">Yes</option>
                                                                <option value="No">No</option>
                                                                <option value="Work in Progress">Work in Progress</option>
                                                            </select>
                                                        </td> --}}
                                                        <td>
                                                            <input type="text" name="TaskManagementData[0][work_in_progress_detail]">
                                                        </td>
                                                        <td>
                                                            <input type="text" name="TaskManagementData[0][Remaining_task]">
                                                        </td>

                                                        <td>
                                                            <div class="time-required">
                                                                <input type="number" id="days" placeholder="Enter days"  
                                                                    name="TaskManagementData[0][days_second]" value="0" 
                                                                    oninput="updateTime()" 
                                                                    style="border: 1px solid #000; padding: 5px; border-radius: 5px;">
                                                                Days
                                

                                                                <input type="number" id="hours" placeholder="Enter hours" 
                                                                    name="TaskManagementData[0][hours_second]" value="0" 
                                                                    oninput="updateTime()" 
                                                                    style="border: 1px solid #000; padding: 5px; border-radius: 5px;">
                                                                Hours

                                                                <input type="number" id="minutes" placeholder="Enter minutes" 
                                                                    name="TaskManagementData[0][minutes_second]" value="0" 
                                                                    oninput="updateTime()" 
                                                                    style="border: 1px solid #000; padding: 5px; border-radius: 5px;">
                                                                Minutes
                                                            </div>

                                                        </td>
                                                        {{-- <td>
                                                            <select name="TaskManagementData[0][testing_completed_by_developer]">
                                                                <option value="">-- Select --</option>
                                                                <option value="Yes">Yes</option>
                                                                <option value="No">No</option>
                                                            </select>
                                                        </td> --}}
                                                        <td>
                                                            <input type="text" name="TaskManagementData[0][developer_testing_details]">
                                                        </td>
                                                        <td>
                                                            <input type="text" name="TaskManagementData[0][remaining_work]">
                                                        </td>
                                                        <td>
                                                            <input type="text" name="TaskManagementData[0][remaining_work_testing]">
                                                        </td>
                                                        <td>
                                                            <select id="" placeholder="Select..." name="TaskManagementData[0][validation_team_name]">
                                                                <option value="">-- Select --</option>
                                                                <option value="Configured  ">Work In Progress </option>
                                                                <option value="Not Completed">Not Completed</option>
                                                                <option value="Completed"> Completed</option>
                                                        </td>
                                                        <td>
                                                            <input type="text" name="TaskManagementData[0][validation_team_remark]">
                                                        </td>
                                                        <td>
                                                            <input type="text" name="TaskManagementData[0][configuration_update_validation_team]">
                                                        </td>
                                                        <td>
                                                            <input type="text" name="TaskManagementData[0][developer_name]">
                                                        </td>

                                                        {{-- <td>
                                                            <input type="datetime-local" name="TaskManagementData[0][task_date_time]" class="datetimepicker">
                                                        </td> --}}

                                                        <td>
                                                            <input type="text" name="TaskManagementData[0][revalidation_remark]">
                                                        </td>
                                                        <td>
                                                            <input type="text" name="TaskManagementData[0][revalidation_remark_team]">
                                                        </td>

                                                       
                                                        
                                                        <td>
                                                            <select name="TaskManagementData[0][final_status]" readonly>
                                                                <option value="">-- Select --</option>
                                                                <option value="Configured  ">Work In Progress </option>
                                                                <option value="Not Completed">Not Completed</option>
                                                                <option value="Completed"> Completed</option>
                                                            </select>
                                                        </td>
                                                        <!-- <td>
                                                            <input type="date" name="TaskManagementData[0][activity_config_final_date]">
                                                        </td> -->
                                                        <td>
                                                            <div class="new-date-data-field">
                                                                <div class="group-input input-date">
                                                                    <div class="calenderauditee">
                                                                        <input id="date_0_activity_config_final_date" type="text" name="TaskManagementData[0][activity_config_final_date]" placeholder="DD-MMM-YYYY" />
                                                                        <input type="date" name="TaskManagementData[0][activity_config_final_date]" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                                                            value="" id="date_0_activity_config_final_date" class="hide-input show_date"
                                                                            style="position: absolute; top: 0; left: 0; opacity: 0;" oninput="handleDateInput(this, 'date_0_activity_config_final_date')" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <input type="text" name="TaskManagementData[0][seniour_management_remark]">
                                                        </td>
                                                        <td><button type="button" class="removeRowBtn">Remove</button></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <script>
                                    document.addEventListener('DOMContentLoaded', function () {
                                        // Initialize Flatpickr for all input fields with class 'datetimepicker'
                                        flatpickr(".datetimepicker", {
                                            enableTime: true,
                                            dateFormat: "d-M-Y H:i",
                                            time_24hr: true
                                        });
                                    });
                                </script>

                                <script>
                                    $(document).ready(function() {
                                        let investdetails = 1;
                                        $('#task_manamegemnt_grid').click(function(e) {
                                            function generateTableRow(serialNumber) {
                                                var html =
                                                    '<tr>' +
                                                    '<td><input disabled type="text" style ="width:15px" value="' + serialNumber +'"></td>' +  
                                                  '<td><select name="TaskManagementData[' + investdetails + '][repo_name]">' +
                                                        '<option value="">-- Select --</option>'+
                                                                '<option value="agio_pre_prod">Agio_pre_prod</option>'+
                                                                '<option value="annuh-pharma">Annuh-Pharma</option>'+
                                                                '<option value="environmentallab">Environmentlab</option>'+
                                                                '<option value="invoice-management">invoice-management</option>'+
                                                                '<option value="lims-laravel">Lims-laravel</option>'+
                                                                '<option value="Medicef-main">Medicef-Main</option>'+                                                            
                                                    '</select></td>'+
                                                    '<td><select name="TaskManagementData[' + investdetails + '][module_process]">' +
                                                        '<option value="">-- Select --</option>'+
                                                                '<option value="adtiyarajput">Aditya Rajput</option>'+
                                                                '<option value="adtiyapatel">Aditya Patel</option>'+
                                                                '<option value="AkashMishra">Akash Mishra</option>'+
                                                                '<option value="Ashishverma">Ashish Verma</option>'+
                                                                '<option value="Farhankhan">Farhan Khan</option>'+
                                                                '<option value="Gauravpandit">Gaurav Pandit</option>'+
                                                                '<option value="gauravmeena">Gaurav Meena</option>'+
                                                                '<option value="Harsh_Sardiya">Harsh_Sardiya</option>'+
                                                                '<option value="Harsh_chhari">Harsh Chhari</option>'+
                                                                '<option value="KuldeepPatel">Kuldeep Patel</option>'+
                                                                '<option value="Lavesh Jain">Lavesh Jain</option>'+
                                                                '<option value="Leeladharkurmi">Leeladhar Kurmi</option>'+
                                                                '<option value="ManishMalviya">Manish Malviya</option>'+
                                                                '<option value="Mayankrathore">Mayank Rathore</option>'+
                                                                '<option value="monikachaurasiya">Monika Chaurasiya</option>'+
                                                                '<option value="NavneetChoudhary">Navneet Choudhary</option>'+
                                                                '<option value="Nickshaychouhan">Nickshay Chouhan</option>'+
                                                                '<option value="nilesh_birla">Nilesh Birla</option>'+
                                                                '<option value="Pankajchohan">Pankaj Chohan</option>'+
                                                                '<option value="Pankajjat">Pankaj Jat</option>'+
                                                                '<option value="ParmodKumar">Parmod Kumar</option>'+
                                                                '<option value="Prabhjotbhatia">Prabhjot Bhatia</option>'+
                                                                '<option value="Rajendrarajput">Rajendra Rajput</option>'+
                                                                '<option value="Rahulawarkar">Rahul Awarkar</option>'+
                                                                '<option value="Rupeshpatil">Rupesh Patil</option>'+
                                                                '<option value="SauravKumar">Saurav Kumar</option>'+
                                                                '<option value="Shivampatel">Shivam Patel</option>'+
                                                                '<option value="Shreyadwivedi">Shreya Dwivedi</option>'+
                                                                '<option value="Shrutidwivedi">Shruti Dwivedi</option>'+
                                                                '<option value="Shubhammeena">Shubham Meena </option>'+
                                                                '<option value="Snehabaldeva">Sneha Baldeva </option>'+
                                                                '<option value="SunilPatel">Sunil Patel</option>'+
                                                                '<option value="Swapnilpatil">Swapnil Patil</option>'+
                                                                '<option value="Tushalpatel">Tushal Patel</option>'+
                                                                '<option value="VaibhavAwarkar">Vaibhav Awarkar</option>'+                                                           
                                                    '</select></td>' +

                                                      '<td><select name="TaskManagementData[' + investdetails + '][activity_task]">' +
                                                        '<option value="">-- Select --</option>'+
                                                        '<option value="agio">Agio</option>'+
                                                                '<option value="annuh">Annuh Pharma</option>'+
                                                                '<option value="environmental">Environmental</option>'+
                                                                '<option value="invoice">Invoice</option>'+
                                                                '<option value="lims">Lims</option>'+
                                                                '<option value="Medicef">Medicef</option>'+                                                     
                                                    '</select></td>'+ 
                                                    '<td><input type="text" name="TaskManagementData[' + investdetails +'][activity1_task]" value=""></td>' +
                                                    '<td>' +
                                                            '<input type="datetime-local" name="TaskManagementData[' + investdetails +'][testing_completed_by_developer_on]" class="datetimepicker">' +
                                                    '</td>' +
                                                    '<td>' +
                                                            '<input type="datetime-local" name="TaskManagementData[' + investdetails +'][task_date_time]" class="datetimepicker">' +
                                                    '</td>' +
                                                    
                                                    '<td>' +
                                                        '<div class="time-required">' +
                                                            '<input type="number" id="days_' + investdetails + '" placeholder="Enter days" ' +
                                                            'oninput="updateTime(this)" name="TaskManagementData[' + investdetails + '][days]" ' +
                                                            'value="0" style="border: 1px solid #000; padding: 5px; border-radius: 5px;"> Days' +

                                                            '<input type="number" id="hours_' + investdetails + '" placeholder="Enter hours" ' +
                                                            'oninput="updateTime(this)" name="TaskManagementData[' + investdetails + '][hours]" ' +
                                                            'value="0" style="border: 1px solid #000; padding: 5px; border-radius: 5px;"> Hours' +

                                                            '<input type="number" id="minutes_' + investdetails + '" placeholder="Enter Minuts"' +
                                                            'oninput="updateTime(this)" name="TaskManagementData[' + investdetails + '][minutes]" ' +
                                                            'value="0" style="border: 1px solid #000; padding: 5px; border-radius: 5px;"> Minutes' +

                                                        '</div>' +
                                                    '</td>' +

                                                    '<td><input type="text" name="TaskManagementData[' + investdetails +'][work_in_progress_detail]" value=""></td>' +
                                                    '<td><input type="text" name="TaskManagementData[' + investdetails +'][Remaining_task]" value=""></td>' +
                                                    '<td>' +
                                                        '<div class="time-required">' +
                                                        '<input type="number" id="days_' + investdetails + '_second" placeholder="Enter days" ' +
                                                        'oninput="updateTime(this)" name="TaskManagementData[' + investdetails + '][days_second]" ' +
                                                        'value="0" style="border: 1px solid #000; padding: 5px; border-radius: 5px;"> Days' +

                                                        '<input type="number" id="hours_' + investdetails + '_second" placeholder="Enter hours" ' +
                                                        'oninput="updateTime(this)" name="TaskManagementData[' + investdetails + '][hours_second]" ' +
                                                        'value="0" style="border: 1px solid #000; padding: 5px; border-radius: 5px;"> Hours' +

                                                        '<input type="number" id="minutes_' + investdetails + '_second" placeholder="Enter Minuts"' +
                                                        'oninput="updateTime(this)" name="TaskManagementData[' + investdetails + '][minutes_second]" ' +
                                                        'value="0" style="border: 1px solid #000; padding: 5px; border-radius: 5px;"> Minutes' +
                                                    
                                                        '</div>' +
                                                    
                                                    '</td>' +
                                                    
                                                    '<td><input type="text" name="TaskManagementData[' + investdetails +'][developer_testing_details]" value=""></td>' +
                                                    '<td><input type="text" name="TaskManagementData[' + investdetails +'][remaining_work]" value=""></td>' +
                                                    '<td><input type="text" name="TaskManagementData[' + investdetails +'][remaining_work_testing]" value=""></td>' +

                                                    '<td><select name="TaskManagementData[' + investdetails + '][validation_team_name]">' +
                                                        '<option value="">-- Select --</option>'+
                                                                '<option value="Configured  ">Work In Progress </option>'+
                                                               '<option value="Not Completed">Not Completed</option>'+
                                                                '<option value="Completed"> Completed</option>'+
                                                    '</select></td>' +
                                                    

                                                    '<td><input type="text" name="TaskManagementData[' + investdetails +'][validation_team_remark]" value=""></td>' +
                                                    '<td><input type="text" name="TaskManagementData[' + investdetails +'][configuration_update_validation_team]" value=""></td>' +
                                                    '<td><input type="text" name="TaskManagementData[' + investdetails +'][revalidation_remark]" value=""></td>' +
                                                    '<td><input type="text" name="TaskManagementData[' + investdetails +'][revalidation_remark_team]" value=""></td>' +
                                                    '<td><input type="text" name="TaskManagementData[' + investdetails +'][task_date_time]" class="datetimepicker"></td>' +
                                                    

                                                   

                                                    '<td><select name="TaskManagementData[' + investdetails + '][final_status]">' +
                                                        ' <option value="">-- Select --</option>'+
                                                                '<option value="Configured  ">Work In Progress </option>'+
                                                               '<option value="Not Completed">Not Completed</option>'+
                                                                '<option value="Completed"> Completed</option>'+
                                                    '</select></td>' +


                                                    // '<td><input type="date" name="TaskManagementData[' + investdetails +
                                                    // '][activity_config_final_date]" value=""></td>' +


                                                    '<td><div class="new-date-data-field"><div class="group-input input-date"> <div class="calenderauditee"><input id="date_' + investdetails + '_activity_config_final_date" type="text" name="TaskManagementData[' + investdetails + '][activity_config_final_date]" placeholder="DD-MMM-YYYY" /> <input type="date" name="TaskManagementData[' + investdetails + '][activity_config_final_date]" min="{{ \Carbon\Carbon::now()->format("Y-m-d") }}" value="" id="date_' + investdetails + '_activity_config_final_date" class="hide-input show_date" style="position: absolute; top: 0; left: 0; opacity: 0;" oninput="handleDateInput(this, \'date_' + investdetails + '_activity_config_final_date\')" /> </div> </div></div></td>' +

                                                    '<td><input type="text" name="TaskManagementData[' + investdetails +
                                                    '][seniour_management_remark]" value=""></td>' +
                                                    
                                                    
                                                    '<td><button class="removeRowBtn">Remove</button>' +
                                                    '</tr>';
                                                investdetails++; // Increment the row number here
                                                return html;
                                            }

                                            var tableBody = $('#task_Management_Table tbody');
                                            var rowCount = tableBody.children('tr').length;
                                            var newRow = generateTableRow(rowCount + 1);
                                            tableBody.append(newRow);
                                        });
                                        $(document).on('click', '.removeRowBtn', function() {
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
                                        let days_second = parseInt(document.getElementById(`days_second${index}`).value) || 0;
                                        let hours_second = parseInt(document.getElementById(`hours_second${index}`).value) || 0;
                                        let minutes_second = parseInt(document.getElementById(`minutes_second${index}`).value) || 0;

                                        // Validate the inputs
                                        if (days < 0) {
                                            alert("Days cannot be negative.");
                                            document.getElementById(`days_${index}`).value = 0;
                                            document.getElementById(`days_second${index}`).value = 0; // Reset to 0
                                            return;
                                        }

                                        if (hours < 0 || hours > 23) {
                                            alert("Hours must be between 0 and 23.");
                                            document.getElementById(`hours_${index}`).value = 0;
                                            document.getElementById(`hours_second${index}`).value = 0; // Reset to 0
                                            return;
                                        }

                                        if (minutes < 0 || minutes > 59) {
                                            alert("Minutes must be between 0 and 59.");
                                            document.getElementById(`minutes_${index}`).value = 0;
                                            document.getElementById(`minutes_second${index}`).value = 0;// Reset to 0
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
                                <div class="group-input">
                                <label for="qa-eval-comments">Final Comments</label>
                                <div >
                                    <textarea name="final_comments" ></textarea>
                                    @component('frontend.forms.language-model')
                                    @endcomponent
                                </div>
                            </div>
                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="others">Supporting document</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting
                                                documents</small></div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="in_attachment"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="in_attachment" name="in_attachment[]"
                                                    oninput="addMultipleFiles(this, 'in_attachment')" multiple>

                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <!-- =========================================================== -->

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

                    <!-- <div id="CCForm3" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="acknowledge_by">Acknowledge By</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="acknowledge_on">Acknowledge On</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="ack_comments">Acknowledge Comment</label>
                                        <div class="static"></div>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="HOD_Review_Complete_By">HOD Review Complete By</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="HOD_Review_Complete_On">HOD Review Complete On</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Comments">HOD Review Complete Comment</label>
                                        <div class="static"></div>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="QQQA_Review_Complete_By">CFT Review Not Required By</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="QQQA_Review_Complete_On">CFT Review Not Required On</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Comments">CFT Review Not Required Comment</label>
                                        <div class="static"></div>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="QQQA_Review_Complete_By">QA/CQA Review Complete By</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="QQQA_Review_Complete_On">QA/CQA Review Complete On</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Comments">QA/CQA Review Complete Comment</label>
                                        <div class="static"></div>
                                    </div>
                                </div>



                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="QQQA_Review_Complete_By">CFT Review Complete By</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="QQQA_Review_Complete_On">CFT Review Complete On</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Comments">CFT Review Complete Comment</label>
                                        <div class="static"></div>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="QQQA_Review_Complete_By">Approved By</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="QQQA_Review_Complete_On">Approved On</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Comments">Approved Comment</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="submitted_by">Submit By</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="submitted_on">Submit On</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Comments">Submit Comment</label>
                                        <div class="static"></div>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="HOD_Final_Review_Complete_By">HOD Final Review Complete By</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="HOD_Final_Review_Complete_On">HOD Final Review Complete On</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Comments">HOD Final Review Complete Comment</label>
                                        <div class="static"></div>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Final_QA_Review_Complete_By">Final QA/CQA Review Complete By</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Final_QA_Review_Complete_On">Final QA/CQA Review Complete On</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Comments">Final QA/CQA Review Complete Comment</label>
                                        <div class="static"></div>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="evaluation_complete_by">QAH/CQAH Closure By</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="evaluation_complete_on">QAH/CQAH Closure On</label>
                                        <div class="static"></div>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="evalution_Closure_comment">QAH/CQAH Closure Comment</label>
                                        <div class="static"></div>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Cancelled By">Cancel By</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Cancelled On">Cancel On</label>
                                        <div class="static"></div>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Comments">Cancel Comment</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="button-block">
                                {{-- <button type="submit" class="saveButton">Save</button> --}}
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                {{-- <button type="submit">Submit</button> --}}
                                <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                                        Exit </a> </button>
                            </div>
                        </div>
                    </div> -->

                </div>
            </form>

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
@endsection
