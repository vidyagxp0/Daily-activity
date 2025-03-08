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
            {{ "India" }} / Project Planner
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

                <!-- <button class="cctablinks" onclick="openCity(event, 'CCForm1')">General Information</button> -->
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

                    
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function () {
    let holidays = [];
    let weekends = [];

    // Fetch holidays & weekends when company is selected in the first row
    $(document).on("change", ".company_name", function () {
        let row = $(this).closest("tr");
        let companyId = $(this).val();

        if (!companyId) return;

        $.ajax({
            url: "{{ route('get.holidays.weekends') }}",
            type: "POST",
            data: { company_id: companyId, _token: "{{ csrf_token() }}" },
            success: function (response) {
                holidays = response.holidays;
                weekends = response.weekends;
            }
        });

        // Auto-fill company name in all subsequent rows
        $(".company_name").not(":first").val(companyId);
    });

    // Function to calculate End Date
    function calculateEndDate(row) {
        let startDate = row.find(".start_date").val();
        let days = parseInt(row.find(".no_of_days").val());

        if (!startDate || isNaN(days) || days <= 0) {
            row.find(".end_date").val('');
            return;
        }

        let currentDate = new Date(startDate);
        let remainingDays = days;

        while (remainingDays > 0) {
            currentDate.setDate(currentDate.getDate() + 1);
            let formattedDate = currentDate.toISOString().split('T')[0];
            let dayName = currentDate.toLocaleDateString('en-US', { weekday: 'long' });

            if (holidays.includes(formattedDate) || weekends.includes(dayName)) {
                continue;
            }

            remainingDays--;
        }

        row.find(".end_date").val(currentDate.toISOString().split('T')[0]);

        // Set the next row's start date as this row's end date + 1 day
        let nextRow = row.next("tr");
        if (nextRow.length) {
            let nextStartDate = new Date(currentDate);
            nextStartDate.setDate(nextStartDate.getDate() + 1);
            nextRow.find(".start_date").val(nextStartDate.toISOString().split('T')[0]);
        }
    }

    $(document).on("change", ".start_date, .no_of_days", function () {
        let row = $(this).closest("tr");
        calculateEndDate(row);
    });

    // Add New Row
    $(".addRow").click(function () {
        let rowIdx = $("#taskGrid tbody tr").length;
        let firstCompany = $("#taskGrid tbody tr:first .company_name").val();
        let lastEndDate = $("#taskGrid tbody tr:last .end_date").val();

        let newRow = `
            <tr>
                <td>${rowIdx + 1}</td>
                <td>
                    <select name="dataprojectplanner[${rowIdx}][company_name]" class="form-control company_name">
                        <option value="">-- Select --</option>
                        <option value="1" ${firstCompany == 1 ? "selected" : ""}>Medicef-Main</option>
                        <option value="2" ${firstCompany == 2 ? "selected" : ""}>Annuh-Pharma</option>
                        <option value="3" ${firstCompany == 3 ? "selected" : ""}>Environmentlab</option>
                        <option value="4" ${firstCompany == 4 ? "selected" : ""}>Invoice-Management</option>
                        <option value="5" ${firstCompany == 5 ? "selected" : ""}>Lims-laravel</option>
                        <option value="6" ${firstCompany == 6 ? "selected" : ""}>Agio_pre_prod</option>
                    </select>
                </td>
                <td><input type="text" name="dataprojectplanner[${rowIdx}][milestone]" class="form-control"></td>
                <td><input type="text" name="dataprojectplanner[${rowIdx}][functionality]" class="form-control"></td>
                <td><input type="number" name="dataprojectplanner[${rowIdx}][no_of_days]" class="form-control no_of_days"></td>
                <td><input type="date" name="dataprojectplanner[${rowIdx}][start_date]" class="form-control start_date" value="${lastEndDate ? new Date(new Date(lastEndDate).setDate(new Date(lastEndDate).getDate() + 1)).toISOString().split('T')[0] : ''}"></td>
                <td><input type="date" name="dataprojectplanner[${rowIdx}][end_date]" class="form-control end_date" readonly></td>
                <td><input type="text" name="dataprojectplanner[${rowIdx}][remarks]" class="form-control"></td>
                <td><input type="date" name="dataprojectplanner[${rowIdx}][actual_start_date]" class="form-control "></td>
                <td><input type="date" name="dataprojectplanner[${rowIdx}][actual_end_date]" class="form-control ]" ></td>
                <td><input type="file" name="dataprojectplanner[${rowIdx}][supporting_document]" class="form-control supporting_document"></td>
                <td><button type="button" class="btn btn-danger removeRow">-</button></td>
            </tr>`;

        $("#taskGrid tbody").append(newRow);
    });

    // Remove Row
    $(document).on("click", ".removeRow", function () {
        $(this).closest("tr").remove();
    });
});
</script>

<div class="container">
    <h2>Project Planner</h2>
    <form action="{{ route('task.store') }}" method="POST">
        @csrf
        <table class="table" id="taskGrid">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Company Name</th>
                    <th>Milestone</th>
                    <th>Functionality</th>
                    <th>No. of Days</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Remarks</th>
                    <th>Actual Start Date</th>
                    <th>Actual End Date</th>
                    <th>Supporting Documents</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>
                        <select name="dataprojectplanner[0][company_name]" class="form-control company_name">
                            <option value="">--Select--</option>
                            <option value="1">Medicef-Main</option>
                            <option value="2">Annuh-Pharma</option>
                            <option value="3">Environmentlab</option>
                            <option value="4">Invoice-Management</option>
                            <option value="5">Lims-laravel</option>
                            <option value="6">Agio_pre_prod</option>
                        </select>
                    </td>
                    <td><input type="text" name="dataprojectplanner[0][milestone]" class="form-control"></td>
                    <td><input type="text" name="dataprojectplanner[0][functionality]" class="form-control"></td>
                    <td><input type="number" name="dataprojectplanner[0][no_of_days]" class="form-control no_of_days"></td>
                    <td><input type="date" name="dataprojectplanner[0][start_date]" class="form-control start_date"></td>
                    <td><input type="date" name="dataprojectplanner[0][end_date]" class="form-control end_date" readonly></td>
                    <td><input type="text" name="dataprojectplanner[0][remarks]" class="form-control"></td>
                    <td><input type="date" name="dataprojectplanner[0][actual_start_date]" class="form-control "></td>
                    <td><input type="date" name="dataprojectplanner[0][actual_end_date]" class="form-control" ></td>
                    <td><input type="file" name="dataprojectplanner[0][supporting_document]" class="form-control supporting_document"></td>
                    <td><button type="button" class="btn btn-success addRow">+</button></td>
                </tr>
            </tbody>
        </table>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>

@endsection
