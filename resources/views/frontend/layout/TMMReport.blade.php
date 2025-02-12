@extends('frontend.layout.main')
@section('container')
    <style>
        textarea.note-codable {
            display: none !important;
        }

        header {
            display: none;
        }

        td {
            font-size: 14px;
        }
    </style>
    <style>
        .header {
     display: flex;
     justify-content: space-between; /* Space out the elements */
     align-items: center; /* Center vertically */
     width: 100%; /* Full width */
    }
    
    .left {
     flex: 1; /* Allow the left item to take available space */
     text-align: left; /* Align text to the left */
    }
    
    .center {
     flex: 1; /* Allow the center item to take available space */
     text-align: center; /* Center text */
    }
    
    .right {
     flex: 1; /* Allow the right item to take available space */
     text-align: right; /* Align text to the right */
    }
    
     </style>

    <!-- Include html2pdf.js library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>

    <div class="form-field-head">
        <div class="pr-id">
            Training Module Numbering Log
        </div>
    </div>
    <div id="change-control-fields">
        <div class="container-fluid">

            <!-- Export Button -->
            <div class="d-flex justify-content-between mb-3">
                <button id="exportPDF" class="btn btn-primary">Export to PDF</button>
                <a href="{{ url('TMS') }}" class="btn btn-primary text-white text-decoration-none">Exit</a>
            </div>

            <!-- Tab links -->
            <div class="cctab"></div>

            <!-- The section you want to export as PDF -->
            <div id="pdf-content">
                <form action="{{ route('TMMNumberingLog') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <!-- Form content -->
                    <div id="step-form">
                        <div id="CCForm1" class="inner-block cctabcontent">
                            <div class="inner-block-content">
                                <div class="pm-certificate-logos text-center">
                                    <img src="{{ asset('user/images/connexo.png') }}" alt="connexo Logo" class="logo logo-left">
                                    <p class="center" style="margin-left: 98px; font-size: 24px; font-weight: bold; white-space: nowrap;">Training Module Numbering Log
                                    </p>
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
                                        max-width: 150px; 
                                    }
                                
                                    .logo-left {
                                        transform: scale(1.2);
                                        margin-bottom: 14px;
                                    }
                                
                                    .logo-right {
                                        transform: scale(1.2); 
                                        margin-right: 65px;
                                    }
                                </style>
                                <div class="row">
                                    {{-- <strong style="display: flex; justify-content: end;" class="nsme">Page i of 1</strong>
                                    <br><br>
                                    <div class="col-lg-12 d-flex justify-content-center align-items-center">
                                        <div class="header">
                                            <div class="left"><span class="fw-bold">SOP No. </span> CQA-024 </div>
                                            <strong class="right">Format No: </strong> CQA-F-024E-R0
                                        </div>
                                    </div> --}}
                                    <br>
                                    <div class="col-lg-12 d-flex justify-content-between align-items-center">
                                        <div class="group-input">
                                            <strong>Location:</strong> <span>P1 (Indore Location)</span>
                                        </div>
                                    </div>
                                    <br>
                                    <br>


                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <table id="example1" class="table table-bordered table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>Name Of Dept.</th>
                                                            <th>Name / Title of Module</th>
                                                            <th>Module No.</th>
                                                            <th>Sign & Date</th>
                                                            <th>Rev. No.</th>
                                                            <th>Sign & Date</th>
                                                            <th>Rev. No.</th>
                                                            <th>Sign & Date</th>
                                                            <th>Rev. No.</th>
                                                            <th>Sign & Date</th>
                                                            <th>Rev. No.</th>
                                                            <th>Sign & Date</th>
                                                            <th>Remarks</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>HR</td>
                                                            <td>Induction Training</td>
                                                            <td>M001</td>
                                                            <td>Himanshu Patil - 15-01-2024</td>
                                                            <td>1</td>
                                                            <td>Himanshu Patil - 18-02-2024</td>
                                                            <td>2</td>
                                                            <td>Vikash Prajapati - 20-03-2024</td>
                                                            <td>3</td>
                                                            <td>Himanshu Patil - 25-04-2024</td>
                                                            <td>4</td>
                                                            <td>Vikash Prajapati - 30-05-2024</td>
                                                            <td>Initial Training Completed</td>
                                                        </tr>
                                                        <tr>
                                                            <td>IT</td>
                                                            <td>System Security</td>
                                                            <td>M002</td>
                                                            <td>Vikash Prajapati - 20-01-2024</td>
                                                            <td>1</td>
                                                            <td>Himanshu Patil - 22-02-2024</td>
                                                            <td>2</td>
                                                            <td>Vikash Prajapati - 25-03-2024</td>
                                                            <td>3</td>
                                                            <td>Himanshu Patil - 29-04-2024</td>
                                                            <td>4</td>
                                                            <td>Vikash Prajapati - 02-06-2024</td>
                                                            <td>Revised with updates</td>
                                                        </tr>
                                                        <tr>
                                                            <td>QA</td>
                                                            <td>Quality Standards</td>
                                                            <td>M003</td>
                                                            <td>Himanshu Patil - 25-01-2024</td>
                                                            <td>1</td>
                                                            <td>Himanshu Patil - 05-03-2024</td>
                                                            <td>2</td>
                                                            <td>Vikash Prajapati - 10-04-2024</td>
                                                            <td>3</td>
                                                            <td>Himanshu Patil - 15-05-2024</td>
                                                            <td>4</td>
                                                            <td>Vikash Prajapati - 20-06-2024</td>
                                                            <td>Revised SOP included</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Finance</td>
                                                            <td>Compliance Training</td>
                                                            <td>M004</td>
                                                            <td>Vikash Prajapati - 30-01-2024</td>
                                                            <td>1</td>
                                                            <td>Himanshu Patil - 08-03-2024</td>
                                                            <td>2</td>
                                                            <td>Vikash Prajapati - 12-04-2024</td>
                                                            <td>3</td>
                                                            <td>Himanshu Patil - 18-05-2024</td>
                                                            <td>4</td>
                                                            <td>Vikash Prajapati - 22-06-2024</td>
                                                            <td>Additional clauses added</td>
                                                        </tr>
                                                        <tr>
                                                            <td>R&D</td>
                                                            <td>Research Ethics</td>
                                                            <td>M005</td>
                                                            <td>Himanshu Patil - 05-02-2024</td>
                                                            <td>1</td>
                                                            <td>Himanshu Patil - 10-03-2024</td>
                                                            <td>2</td>
                                                            <td>Vikash Prajapati - 14-04-2024</td>
                                                            <td>3</td>
                                                            <td>Himanshu Patil - 20-05-2024</td>
                                                            <td>4</td>
                                                            <td>Vikash Prajapati - 25-06-2024</td>
                                                            <td>Extended revision schedule</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Production</td>
                                                            <td>Equipment Handling</td>
                                                            <td>M006</td>
                                                            <td>Vikash Prajapati - 10-02-2024</td>
                                                            <td>1</td>
                                                            <td>Himanshu Patil - 12-03-2024</td>
                                                            <td>2</td>
                                                            <td>Vikash Prajapati - 18-04-2024</td>
                                                            <td>3</td>
                                                            <td>Himanshu Patil - 25-05-2024</td>
                                                            <td>4</td>
                                                            <td>Vikash Prajapati - 30-06-2024</td>
                                                            <td>Safety protocols updated</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Sales</td>
                                                            <td>Product Knowledge</td>
                                                            <td>M007</td>
                                                            <td>Himanshu Patil - 15-02-2024</td>
                                                            <td>1</td>
                                                            <td>Himanshu Patil - 15-03-2024</td>
                                                            <td>2</td>
                                                            <td>Vikash Prajapati - 20-04-2024</td>
                                                            <td>3</td>
                                                            <td>Himanshu Patil - 28-05-2024</td>
                                                            <td>4</td>
                                                            <td>Vikash Prajapati - 05-07-2024</td>
                                                            <td>Updated with new product</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Marketing</td>
                                                            <td>Branding Strategies</td>
                                                            <td>M008</td>
                                                            <td>Vikash Prajapati - 20-02-2024</td>
                                                            <td>1</td>
                                                            <td>Himanshu Patil - 18-03-2024</td>
                                                            <td>2</td>
                                                            <td>Vikash Prajapati - 22-04-2024</td>
                                                            <td>3</td>
                                                            <td>Himanshu Patil - 01-06-2024</td>
                                                            <td>4</td>
                                                            <td>Vikash Prajapati - 10-07-2024</td>
                                                            <td>Revised for new strategies</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Logistics</td>
                                                            <td>Inventory Management</td>
                                                            <td>M009</td>
                                                            <td>Himanshu Patil - 25-02-2024</td>
                                                            <td>1</td>
                                                            <td>Himanshu Patil - 22-03-2024</td>
                                                            <td>2</td>
                                                            <td>Vikash Prajapati - 01-05-2024</td>
                                                            <td>3</td>
                                                            <td>Himanshu Patil - 05-06-2024</td>
                                                            <td>4</td>
                                                            <td>Vikash Prajapati - 15-07-2024</td>
                                                            <td>Revised for supply chain</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Admin</td>
                                                            <td>Facility Maintenance</td>
                                                            <td>M010</td>
                                                            <td>Vikash Prajapati - 01-03-2024</td>
                                                            <td>1</td>
                                                            <td>Himanshu Patil - 01-04-2024</td>
                                                            <td>2</td>
                                                            <td>Vikash Prajapati - 05-05-2024</td>
                                                            <td>3</td>
                                                            <td>Himanshu Patil - 10-06-2024</td>
                                                            <td>4</td>
                                                            <td>Vikash Prajapati - 20-07-2024</td>
                                                            <td>Additional maintenance notes</td>
                                                        </tr>
                                                    </tbody>



                                                    {{-- <tbody>
                                                        @foreach ($topic as $key => $value)
                                                            <tr>
                                                                <td>{{ $key + 1 }}.</td>
                                                                <td>{{ $value->traning_plan_name }}</td>

                                                                <!-- Multi-select checkbox for SOP selection -->
                                                                <td>
                                                                    @foreach ($dataAll as $dat)
                                                                        <div>
                                                                            <input type="checkbox" name="dataAll[{{ $value->id }}][]" value="{{ $dat->id }}" id="doc_{{ $dat->id }}"
                                                                                   onclick="updateSOPSelection('{{ $value->id }}', '{{ $dat->id }}', '{{ $dat->created_at }}')">
                                                                            <label for="doc_{{ $dat->id }}">
                                                                                {{ $dat->sop_type_short }}/{{ $dat->department_id }}/000{{ $dat->id }}/R{{ $dat->major }}
                                                                            </label>
                                                                        </div>
                                                                    @endforeach
                                                                </td>

                                                                <!-- Display SOP counts dynamically for each month for the current row -->
                                                                <td id="month-1-{{ $value->id }}">0</td> <!-- Jan -->
                                                                <td id="month-2-{{ $value->id }}">0</td> <!-- Feb -->
                                                                <td id="month-3-{{ $value->id }}">0</td> <!-- Mar -->
                                                                <td id="month-4-{{ $value->id }}">0</td> <!-- Apr -->
                                                                <td id="month-5-{{ $value->id }}">0</td> <!-- May -->
                                                                <td id="month-6-{{ $value->id }}">0</td> <!-- Jun -->
                                                                <td id="month-7-{{ $value->id }}">0</td> <!-- Jul -->
                                                                <td id="month-8-{{ $value->id }}">0</td> <!-- Aug -->
                                                                <td id="month-9-{{ $value->id }}">0</td> <!-- Sep -->
                                                                <td id="month-10-{{ $value->id }}">0</td> <!-- Oct -->
                                                                <td id="month-11-{{ $value->id }}">0</td> <!-- Nov -->
                                                                <td id="month-12-{{ $value->id }}">0</td> <!-- Dec -->
                                                            </tr>
                                                        @endforeach
                                                    </tbody> --}}
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div></div>
                            <br>



                            <br>
                            <br>
                            <br><br>
                            <br><br><br>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- PDF Export Script -->
    {{-- <script>
        document.getElementById('exportPDF').addEventListener('click', function() {
            var element = document.getElementById('pdf-content');

            // Dynamically add a title before generating the PDF
            var title = document.createElement('h1');
            title.innerText = 'Training Module Numbering Log'; // Set your title
            title.style.textAlign = 'center'; // Center the title
            title.style.fontSize = '24px'; // Set font size
            title.style.fontWeight = 'bold'; // Set font weight
            title.style.marginBottom = '20px'; // Add margin below the title
            title.style.color = '#333'; // Set the text color (optional)

            element.prepend(title); // Add the title at the beginning of the content

            var opt = {
                margin: 0.2,
                filename: 'Training_Module_Numbering_Log.pdf',
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
                filename: 'Training_Module_Numbering_Log.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 3 },
                jsPDF: { unit: 'in', format: 'letter', orientation: 'landscape' }
            };
    
            html2pdf().set(opt).from(element).toPdf().get('pdf').then(function (pdf) {
                var totalPages = pdf.internal.getNumberOfPages(); // Correct way to get total number of pages
    
                // Set font style for page numbers (can be customized)
                pdf.setFont('times', 'bold');
                pdf.setFontSize(10);    // Set font size
    
                // Loop through each page and add page number at the left side, 100px from top
                for (var i = 1; i <= totalPages; i++) {
                    pdf.setPage(i);
                    var text = "Page " + i + " of " + totalPages;
    
                    // Add page number at the left side, 100px from top
                    pdf.text(text, 10.21, 1.8);  // Left aligned (10 is the X position), 100px down from top (1.0)
                }
    
                // Save the PDF after setting the page numbers
                pdf.save('Training_Module_Numbering_Log.pdf');
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

        // Event listener for checkboxes to track selected SOPs
        document.querySelectorAll('input[type="checkbox"]').forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                const rowId = checkbox.closest('tr').getAttribute(
                    'data-row-id'); // Assuming row has a data attribute for the ID
                const sopId = checkbox.value; // SOP ID from the checkbox value
                const sopCreatedAt = checkbox.getAttribute(
                    'data-created-at'); // Assuming you set a data attribute for creation date

                updateSOPSelection(rowId, sopId, sopCreatedAt);
            });
        });
    </script>
@endsection
