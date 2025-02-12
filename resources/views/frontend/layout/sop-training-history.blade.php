@extends('frontend.layout.main')
@section('container')
    @php
        $users = DB::table('users')->select('id', 'name')->where('active', 1)->get();
        $userRoles = DB::table('user_roles')->select('user_id')->where('q_m_s_roles_id', 4)->distinct()->get();
        $departments = DB::table('departments')->select('id', 'name')->get();
        $divisions = DB::table('q_m_s_divisions')->select('id', 'name')->get();

        $userIds = DB::table('user_roles')->where('q_m_s_roles_id', 4)->distinct()->pluck('user_id');

        $userNames = DB::table('users')->whereIn('id', $userIds)->pluck('name');

        $userDetails = DB::table('users')->whereIn('id', $userIds)->select('id', 'name')->get();
   
    @endphp
    <style>
        textarea.note-codable {
            display: none !important;
        }

        header {
            display: none;
        }
        .time{
            display: flex;
    justify-content: center;
        }
    </style>


    <!-- @error('email')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror

                @error('emp_id')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror -->

    <script>
        $(document).ready(function() {
            $('#ObservationAdd').click(function(e) {
                function generateTableRow(serialNumber) {

                    var html =
                        '<tr>' +
                        '<td><input disabled type="text" name="jobResponsibilities[' + serialNumber +
                        '][serial]" value="' + serialNumber +
                        '"></td>' +
                        '<td><input type="text" name="jobResponsibilities[' + serialNumber +
                        '][job]"></td>' +
                        '<td><input type="text" class="Document_Remarks" name="jobResponsibilities[' +
                        serialNumber + '][remarks]"></td>' +


                        '</tr>';

                    return html;
                }

                var tableBody = $('#job-responsibilty-table tbody');
                var rowCount = tableBody.children('tr').length;
                var newRow = generateTableRow(rowCount + 1);
                tableBody.append(newRow);
            });
        });
    </script>
    <div class="form-field-head">
        <div class="pr-id training-title">
            SOP Training History Record
        </div>
    </div>
    <style>
       .header {
    display: flex;
    justify-content: space-between; 
    align-items: center; 
    width: 100%; 
}

.left {
    flex: 1; 
    text-align: left; 
}

.center {
    flex: 1; 
    text-align: center;
}

.right {
    flex: 1; 
    text-align: right; 
}

    </style>



    {{-- ======================================
                    DATA FIELDS
    ======================================= --}}
    <div id="change-control-fields">
        <div class="container-fluid">
         
            <div class="d-flex justify-content-between mb-3">
                <button id="exportPDF" class="btn btn-primary">Export to PDF</button>
                <a href="{{ url('TMS') }}" class="btn btn-primary text-white text-decoration-none">Exit</a>
            </div>
            <!-- Tab links -->
            <div class="cctab"></div>
    
            <form action="{{ url('SOP.Training.History') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- Tab content -->
                <div id="pdf-content">
                <div id="step-form">
                    <div id="CCForm1" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="pm-certificate-logos text-center">
                                <img src="{{ asset('user/images/connexo.png') }}" alt="connexo Logo" class="logo logo-left">
                                <p class="center" style="margin-left: 98px; font-size: 24px; font-weight: bold; white-space: nowrap;">SOP TRAINING HISTORY RECORD</p>
                                {{-- <img src="{{ asset('user/images/symbiotec_pharmalab_pvt_ltd__logo.jpg') }}" alt="Vidhya GxP Logo" class="logo logo-left"> --}}
                            </div>
                            <style>
                                .pm-certificate-logos {
                                    display: flex;
                                    justify-content: space-between;
                                    align-items: center;
                                    margin-bottom: 20px;
                                }
                            
                                .logo {
                                    max-width: 125px; 
                                }
                            
                                .logo-left {
                                    transform: scale(1.2);
                                    margin-bottom: 14px;
                                    margin-right: 15px;
                                }
                            
                                .logo-right {
                                    transform: scale(1.2); 
                                    margin-right: 65px;
                                }
                            </style>
                            
                            {{-- <div style="    display: flex; justify-content: end;" class="nsme">
                                <strong>Page i of i</strong>
                            </div> --}}
                            <div class="row">
                                {{-- <div class="header">
                                    <div class="left"><span class="fw-bold">SOP No. </span> CQA-024 </div>
                                    <strong class="right">Format No: </strong> CQA-F-024E-R1
                                </div>
                                <br> --}}
                                <br>


                                <style>
                                    .row {
                                        margin-right: 0;
                                        margin-left: 0;
                                    }
                                    .col-lg-6 {
                                        padding-right: 0;
                                        padding-left: 0;
                                    }
                                </style>
                                
                                <div class="row">
                                    <div class="col-lg-6">
                                        <table class="table table-bordered" style="border: 1px solid black;">
                                            {{-- <tr>
                                                <td><strong>Location:</strong></td>
                                                <td>P1(Indore)</td>
                                            </tr> --}}
                                            <tr>
                                                <td><strong>Employee Name:</strong></td>
                                                {{-- <td>{{ Helpers::getNameById($employeeId) }}</td> --}}
                                            </tr>
                                            <tr>
                                                <td><strong>Employee Code:</strong></td>
                                                <td>{{ Helpers::getEmpNameById($employeeId) }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Department & Area:</strong></td>
                                                <td>{{ $department }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-lg-6">
                                        <table class="table table-bordered" style="border: 1px solid black;">
                                            <tr>
                                                <td><strong>Designation:</strong></td>
                                                <td>{{ Helpers::getdesignationEmpById($employeeId) }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Start Date :</strong></td>
                                                <td>{{ Helpers::getdateFormat($startDate) }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>End Date :</strong></td>
                                                <td>{{ Helpers::getdateFormat($endDate) }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                
                                
                                @php
                                    // Fetch all documents
                                    $dataAll = DB::table('documents')->get();
                                @endphp
                                <style>
                                    .table-striped>tbody>tr:nth-of-type(odd)>* {
                                        --bs-table-accent-bg: var(--bs-table-striped-bg);
                                        color: var(--bs-table-striped-color);
                                    }
                                    
                                </style>
                                
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <table id="example1" class="table table-bordered table-striped" style="border: 1px solid black;">
                                                <thead >
                                                    <tr>
                                                        <th rowspan="2">Date of Training</th>
                                                        <th rowspan="2">Training Mode</th>
                                                        <th rowspan="2">Ref. Doc./SOP No.</th>
                                                        <th rowspan="2">Name of Trainer</th>
                                                        <th colspan="2"><span class="time">Time</span></th>
                                                        <th rowspan="2">Number of Attempt</th>
                                                        <th rowspan="2">Score(%)</th>
                                                        <th rowspan="2">Qualified (Y)/Not Qualified (N)</th>
                                                        <th rowspan="2">Employee (Sign & Date)</th>
                                                    </tr>
                                                    <tr>
                                                        <th>From</th>
                                                        <th>To</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($trainings as $training)
                                                    {{-- {{ dd($trainings);}} --}}
                                                    @if ($trainingType == "Induction Training")
                                                        @php
                                                        
                                                        $getSOPNo = ['document_number_1', 'document_number_2', 'document_number_3', 'document_number_4', 'document_number_5','document_number_6', 'document_number_7', 'document_number_8', 'document_number_9', 'document_number_10', 'document_number_11', 'document_number_12', 'document_number_13', 'document_number_14', 'document_number_15','document_number_16'];
                                                        $dateValue = null;
                                                         // Variable to store the date
                                                        if ($training) {
                                                                    foreach ($getSOPNo as $key => $subject) {
                                                                        // Construct the corresponding startdate column name
                                                                        $startDateColumn = 'document_number_' . ($key + 1); // This will create startdate_1, startdate_2, etc.

                                                                        // Check if the start date exists and is not null
                                                                        if (isset($training->trainingDetails->$startDateColumn) && !is_null($training->trainingDetails->$startDateColumn)) {
                                                                            $dateValue[] = $training->trainingDetails->$startDateColumn; // Add the date to the array
                                                                        }
                                                                    }
                                                                }
                                                                 // Use implode only if $dateValue has elements
                                                            $commaSeparatedStartDates = !empty($dateValue) ? implode(', ', $dateValue) : '';

                                                        @endphp
                                                         <tr>
                                                            <td>{{ Helpers::getdateFormat($training['created_at'] ?? '-') }}</td>
                                                            <td>Induction Training</td>
                                                            <td>{{ Helpers::getFormattedDocumentNumbers($commaSeparatedStartDates) }}</td>
                                                            <td>{{ $training['trainingDetails']['submit_by'] ?? '-' }}</td>
                                                            <td>{{ Helpers::getdateFormat($training['trainingDetails']['start_date'] ?? '-') }}</td>
                                                            <td>{{ Helpers::getdateFormat($training['trainingDetails']['end_date'] ?? '-') }}</td>
                                                            @php
                                                                $attemptNumber = (3 - $training['attempt_number']) + 1 ?? null;
                                                                $suffix = match($attemptNumber) {
                                                                    1 => 'st',
                                                                    2 => 'nd',
                                                                    3 => 'rd',
                                                                    default => ''
                                                                };
                                                            @endphp

                                                            <td>{{ $attemptNumber ? $attemptNumber . $suffix : '-' }}</td>
                                                            <td>{{ $training['score'] ?? '-' }}</td>
                                                            <td>
                                                                @if(isset($training['result']))
                                                                    {{ $training['result'] == 'Pass' ? 'Y' : 'N' }}
                                                                @else
                                                                    -
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if(isset($training['created_at']))
                                                                    {{ Helpers::getNameById($employeeId) }} <br> ({{ Helpers::getdateFormat($training['created_at']) }})
                                                                @else
                                                                    N/A
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endif

                                                    @if ($trainingType == "On The Job Training")
                                                        @php
                                                        
                                                        $getSOPNo = ['reference_document_no_1', 'reference_document_no_2', 'reference_document_no_3', 'reference_document_no_4', 'reference_document_no_5'];
                                                        $dateValue = null; // Variable to store the date
                                                        if ($training) {
                                                                    foreach ($getSOPNo as $key => $subject) {
                                                                        // Construct the corresponding startdate column name
                                                                        $startDateColumn = 'reference_document_no_' . ($key + 1); // This will create startdate_1, startdate_2, etc.

                                                                        // Check if the start date exists and is not null
                                                                        if (isset($training->trainingDetails->$startDateColumn) && !is_null($training->trainingDetails->$startDateColumn)) {
                                                                            $dateValue[] = $training->trainingDetails->$startDateColumn; // Add the date to the array
                                                                        }
                                                                    }
                                                                }
                                                                 // Use implode only if $dateValue has elements
                                                            $commaSeparatedStartDates = !empty($dateValue) ? implode(', ', $dateValue) : '';

                                                        @endphp
                                                         <tr>
                                                            <td>{{ Helpers::getdateFormat($training['created_at'] ?? '-') }}</td>
                                                            <td>On The Job Training</td>
                                                            <td>{{ Helpers::getFormattedDocumentNumbers($commaSeparatedStartDates) }}</td>
                                                            <td>{{ $training['trainingDetails']['submit_by'] ?? '-' }}</td>
                                                            <td>{{ Helpers::getdateFormat($training['trainingDetails']['start_date'] ?? '-') }}</td>
                                                            <td>{{ Helpers::getdateFormat($training['trainingDetails']['end_date'] ?? '-') }}</td>
                                                            @php
                                                                $attemptNumber = (3 - $training['attempt_number']) + 1 ?? null;
                                                                $suffix = match($attemptNumber) {
                                                                    1 => 'st',
                                                                    2 => 'nd',
                                                                    3 => 'rd',
                                                                    default => ''
                                                                };
                                                            @endphp

                                                            <td>{{ $attemptNumber ? $attemptNumber . $suffix : '-' }}</td>
                                                            <td>{{ $training['score'] ?? '-' }}</td>
                                                            <td>
                                                                @if(isset($training['result']))
                                                                    {{ $training['result'] == 'Pass' ? 'Y' : 'N' }}
                                                                @else
                                                                    -
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if(isset($training['created_at']))
                                                                    {{ Helpers::getNameById($employeeId) }} ({{ Helpers::getdateFormat($training['created_at']) }})
                                                                @else
                                                                    N/A
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endif

                                                    @if ($trainingType == "Classroom Training")
                                                    @php
                                                    
                                                    $getSOPNo = ['reference_document_no_1', 'reference_document_no_2', 'reference_document_no_3', 'reference_document_no_4', 'reference_document_no_5'];
                                                    $dateValue = null; // Variable to store the date
                                                    if ($training) {
                                                                foreach ($getSOPNo as $key => $subject) {
                                                                    // Construct the corresponding startdate column name
                                                                    $startDateColumn = 'reference_document_no_' . ($key + 1); // This will create startdate_1, startdate_2, etc.

                                                                    // Check if the start date exists and is not null
                                                                    if (isset($training->trainingDetails->$startDateColumn) && !is_null($training->trainingDetails->$startDateColumn)) {
                                                                            $dateValue[] = $training->trainingDetails->$startDateColumn; // Add the date to the array
                                                                        }
                                                                }
                                                            }
                                                             // Use implode only if $dateValue has elements
                                                        $commaSeparatedStartDates = !empty($dateValue) ? implode(', ', $dateValue) : '';

                                                    @endphp
                                                     <tr>
                                                        <td>{{ Helpers::getdateFormat($training['created_at'] ?? '-') }}</td>
                                                        <td>Classroom Training</td>
                                                        <td>{{ Helpers::getFormattedDocumentNumbers($commaSeparatedStartDates) }}</td>
                                                        <td>{{ $training['trainingDetails']['submit_by'] ?? '-' }}</td>
                                                        <td>{{ Helpers::getdateFormat($training['trainingDetails']['start_date'] ?? '-') }}</td>
                                                        <td>{{ Helpers::getdateFormat($training['trainingDetails']['end_date'] ?? '-') }}</td>
                                                        @php
                                                            $attemptNumber = (3 - $training['attempt_number']) + 1 ?? null;
                                                            $suffix = match($attemptNumber) {
                                                                1 => 'st',
                                                                2 => 'nd',
                                                                3 => 'rd',
                                                                default => ''
                                                            };
                                                        @endphp

                                                        <td>{{ $attemptNumber ? $attemptNumber . $suffix : '-' }}</td>
                                                        <td>{{ $training['score'] ?? '-' }}</td>
                                                        <td>
                                                            @if(isset($training['result']))
                                                                {{ $training['result'] == 'Pass' ? 'Y' : 'N' }}
                                                            @else
                                                                -
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if(isset($training['created_at']))
                                                                {{ Helpers::getNameById($employeeId) }} ({{ Helpers::getdateFormat($training['created_at']) }})
                                                            @else
                                                                N/A
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endif
                                                        
                                                    @endforeach
                                                </tbody>
                                                
                                            </table>
                                        </div>
                                    </div>
                                </div>
    
                                <div class="col-lg-12 d-flex justify-content-start align-items-center">
                                    <div class="group-input">
                                         <strong>"NA" shall be mentioned wherever not applicable.</strong>
                                         <br>
                                    </div>
                                </div>
    
                                <!-- /.col -->
    
                                <div class="col-lg-12 d-flex justify-content-end align-items-center">
                                    <div class="group-input">
                                         <span>__________________________________________</span>
                                         <br>
                                         Reviewed by (Sign & Date): Concerned dept
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
    
                    </div>
                </div>
              </div>
    
            </form>
        </div>
    </div>
    
    <!-- Add CSS for print -->
    <style>

        @media print {
    .training-title {
        display: none;
    }

}
        @media print {
            body {
                -webkit-print-color-adjust: exact;
                font-family: Arial, sans-serif;
            }
    
            .container-fluid {
                width: 100%;
            }
    
            table {
                width: 100%;
                border-collapse: collapse;
            }
    
            th, td {
                border: 1px solid black;
                padding: 8px;
                text-align: center;
                font-size: 12px;
                word-wrap: break-word;
            }
    
            th {
                background-color: #f2f2f2;
            }
    
            .card {
                border: none;
            }
    
            .d-flex {
                display: flex;
                justify-content: space-between;
            }
    
            .group-input {
                margin-bottom: 15px;
            }
    
            .btn, #change-control-fields .cctab {
                display: none;
            }
        }
    
        table {
            width: 100%;
            border-collapse: collapse;
        }
    
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }
    
        th {
            background-color: #f8f9fa;
        }
    
        .group-input {
            margin-bottom: 15px;
        }
    
    </style>
    
  
    

 

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>

    {{-- <script>
        document.getElementById('exportPDF').addEventListener('click', function() {
            var element = document.getElementById('pdf-content');

           
            var title = document.createElement('h1');
            title.style.textAlign = 'center'; 
            title.style.fontSize = '24px'; 
            title.style.fontWeight = 'bold'; 
            title.style.marginBottom = '20px'; 
            title.style.color = '#333'; 

            element.prepend(title); 

            var opt = {
                margin: 0.2,
                filename: 'Employee_Training_History_Record.pdf',
                image: {
                    type: 'jpeg',
                    quality: 0.98
                },
                html2canvas: {
                    scale: 2
                },
                jsPDF: {
                    unit: 'in',
                    format: 'letter',
                    orientation: 'landscape'
                }
            };

            html2pdf().set(opt).from(element).save().then(function() {
                // Remove the title after saving PDF to keep the original content intact
                element.removeChild(title);
            });
        });
    </script> --}}
<script>
    document.getElementById('exportPDF').addEventListener('click', function () {
        var element = document.getElementById('pdf-content');

        // Title customization
        var title = document.createElement('h1');
        title.style.textAlign = 'center';
        title.style.fontSize = '24px';
        title.style.fontWeight = 'bold';
        title.style.marginBottom = '20px';
        title.style.color = '#333';

        element.prepend(title); 

        var opt = {
            margin: 0.2,
            filename: 'SOP_Training_History_Record.pdf',
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: { scale: 3 },
            jsPDF: { unit: 'in', format: 'letter', orientation: 'landscape' }
        };

        html2pdf().set(opt).from(element).toPdf().get('pdf').then(function (pdf) {
            var totalPages = pdf.internal.getNumberOfPages(); // Correct way to get total number of pages

            // Set font style for page numbers (can be customized)
            pdf.setFont('times', 'bold');
            pdf.setFontSize(12);    // Set font size

            // Loop through each page and add page number at the left side, 100px from top
            for (var i = 1; i <= totalPages; i++) {
                pdf.setPage(i);
                var text = "Page " + i + " of " + totalPages;

                // Add page number at the left side, 100px from top
                pdf.text(text, 9.91, 1.77);  // Left aligned (10 is the X position), 100px down from top (1.0)
            }

            // Save the PDF after setting the page numbers
            pdf.save('SOP_Training_History_Record.pdf');
        });
    });
</script>

    <script>
        // Object to hold selected SOPs for each row (keyed by row ID)
        let selectedSOPsByRow = {};

        // Function to update SOP selection for a specific row
        function updateSOPSelection(rowId, sopId, sopCreatedAt) {
            if (!selectedSOPsByRow[rowId]) {
                selectedSOPsByRow[rowId] = []; // Initialize SOP array for this row if it doesn't exist
            }

            const rowSOPs = selectedSOPsByRow[rowId];
            const index = rowSOPs.findIndex(sop => sop.id === sopId);

            // If SOP is already selected, remove it; otherwise, add it
            if (index > -1) {
                rowSOPs.splice(index, 1); // Remove the SOP from the row's array
            } else {
                rowSOPs.push({
                    id: sopId,
                    createdAt: sopCreatedAt
                }); // Add the SOP with its creation date
            }

            // Update the SOP counts for this row
            updateSOPCounts(rowId);
        }

        // Function to update SOP counts for a specific row based on its selected SOPs
        function updateSOPCounts(rowId) {
            // Reset all counts to 0 for the given row
            const monthCounts = {
                1: 0,
                2: 0,
                3: 0,
                4: 0,
                5: 0,
                6: 0,
                7: 0,
                8: 0,
                9: 0,
                10: 0,
                11: 0,
                12: 0
            };

            // Get the selected SOPs for this row
            const rowSOPs = selectedSOPsByRow[rowId] || [];

            // Loop through selected SOPs and increment counts based on creation month
            rowSOPs.forEach(sop => {
                const createdAt = new Date(sop.createdAt);
                const month = createdAt.getMonth() + 1; // Get the month (0-based, so +1)
                monthCounts[month] += 1;
            });

            // Update the table cells with the new counts for this row
            for (let month = 1; month <= 12; month++) {
                document.getElementById('month-' + month + '-' + rowId).textContent = monthCounts[month];
            }
        }
    </script>



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Listen for any checkbox change in the document
            document.querySelectorAll('input[type="checkbox"]').forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    let selectedCheckboxes = document.querySelectorAll(
                        'input[type="checkbox"]:checked');
                    console.log('Selected checkboxes:', selectedCheckboxes.length);
                    // You can do more things here, like showing how many items were selected
                });
            });
        });
    </script>

    <script>
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
        function fetchEmployeeDetails() {
            var selectElement = document.getElementById('employee_name');
            var selectedOption = selectElement.options[selectElement.selectedIndex];
            var employeeName = selectedOption.value;
            var employeeCode = selectedOption.getAttribute('data-code');
            var department = selectedOption.getAttribute('data-department');
            var designation = selectedOption.getAttribute('data-designation');

            if (employeeName) {
                // Set the data in respective fields
                document.getElementById('employee_code').value = employeeCode || '';
                document.getElementById('department').value = department || 'NA';
                document.getElementById('designation').value = designation || 'NA';

                selectElement.value = employeeName;
            } else {
                document.getElementById('employee_code').value = '';
                document.getElementById('department').value = '';
                document.getElementById('designation').value = '';
            }
        }
    </script>
    
    <script>
        VirtualSelect.init({
            ele: '#Facility, #Group, #Audit, #Auditee ,#reference_record, #designee, #hod'
        });
    </script>
@endsection
