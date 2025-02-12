@extends('frontend.layout.main')
@section('container')
    <style>
        textarea.note-codable {
            display: none !important;
        }

        header {
            display: none;
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>

    <div class="form-field-head">
        <div class="pr-id">
            List Of Qualified Trainers
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
                <form action="{{ route('List.qualified.trainers') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <!-- Form content -->
                    <div id="step-form">
                        <div id="CCForm1" class="inner-block cctabcontent">
                            <div class="inner-block-content">
                                <div class="pm-certificate-logos text-center">
                                    <img src="{{ asset('user/images/connexo.png') }}" alt="connexo Logo" class="logo logo-left">
                                    <p class="center" style="margin-left: 98px; font-size: 24px; font-weight: bold; white-space: nowrap;">List Of Qualified Trainers</p>
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
                                        max-width: 124px; 
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
                               
                                    {{-- <div class="col-lg-12 d-flex justify-content-between align-items-center">
                                        <div class="group-input">
                                            <strong>Location:</strong> <span>P1 (Indore Location)</span>
                                        </div>
                                        <div class="group-input">
                                            <strong>Department/Area:</strong> <span>Quality Control </span>
                                        </div>
                                        <div class="group-input">
                                            <strong>Doc.No.:</strong> <span>SOP/QC/0001/R1234</span>
                                        </div>
                                    </div> --}}
                                        {{-- <div class="col-lg-12 d-flex justify-content-between align-items-center">
                                            <div class="group-input">
                                                <strong>Location:</strong> <span>{{ $employees->site_code }}</span>
                                            </div>
                                            <div class="group-input">
                                                <strong>Name of Dept & Area:</strong> <span>{{ $employees->site_division_2 }}</span>
                                            </div>
                                        </div> --}}
                                    <br>
                                    <br>


                                    {{-- <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Prefix">Year<span class="text-danger">*</span></label>
                                        <select name="site_division">
                                            <option value="">Select Year</option>
                                            <option value="2024">2024</option>
                                            <option value="2025">2025</option>
                                            <option value="2026">2026</option>
                                            <option value="2027">2027</option>
                                            <option value="2028">2028</option>
                                            <option value="2029">2029</option>
                                            <option value="2030">2030</option>
                                            <option value="2031">2031</option>
                                            <option value="2032">2032</option>
                                            <option value="2033">2033</option>
                                            <option value="2034">2034</option>
                                        </select>
                                    </div>
                                </div> --}}
                                    {{-- <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Joining Date">Name Of Dept & Area<span
                                        class="text-danger">*</span></label>
                                        <select name="site_division">
                                                <option value="">Select Department & Area</option>
                                                <option value="CQA">Corporate Quality Assurance</option>
                                                <option value="QA">Quality Assurance</option>
                                                <option value="QC">Quality Control</option>
                                                <option value="QM">Quality Control (Microbiology department)</option>
                                                <option value="PG">Production General</option>
                                                <option value="PL">Production Liquid Orals</option>
                                                <option value="PT">Production Tablet and Powder</option>
                                                <option value="PE">Production External (Ointment, Gels, Creams and Liquid)</option>
                                                <option value="PC">Production Capsules</option>
                                                <option value="PI">Production Injectable</option>
                                                <option value="EN">Engineering</option>
                                                <option value="HR">Human Resource</option>
                                                <option value="ST">Store</option>
                                                <option value="IT">Electronic Data Processing</option>
                                                <option value="FD">Formulation Development</option>
                                                <option value="AL">Analytical research and Development Laboratory</option>
                                                <option value="PD">Packaging Development</option>
                                                <option value="PU">Purchase Department</option>
                                                <option value="DC">Document Cell</option>
                                                <option value="RA">Regulatory Affairs</option>
                                                <option value="PV">Pharmacovigilance</option>
                                        </select>
                                    </div>
                                </div> --}}
                                    {{-- @php 
                                        // Fetch all documents
                                        $dataAll = DB::table('documents')->get();
                                    @endphp --}}
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <table id="example1" class="table table-bordered table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>Sr. No.</th>
                                                            <th>Name of Trainer</th>
                                                            <th>Employee code</th>
                                                            <th>Designation</th>
                                                            <th>Qualification</th>
                                                            <th>Total Experience(in Year)</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($trainers->sortbyDesc('id') as $index => $trainer)
                                                            @if ($trainer->stage >= 6)
                                                            <tr>
                                                                <td>{{ $index + 1 }}</td>
                                                                <!-- <td><a href="{{ url('trainer_qualification_view', $trainer->id) }}">000{{ $trainer->id }}</a></td> -->
                                                                <td>{{ $trainer->employee_name ? $trainer->employee_name : 'NA' }}</td>
                                                                <td>{{ $trainer->employee_id ? $trainer->employee_id : 'NA' }}</td>
                                                                <td>{{ $trainer->designation }}
                                                                </td>
                                                                {{-- <td>{{ $trainer->trainer ? $trainer->trainer: 'NA' }}</td> --}}
                                                               {{-- <td>{{ $trainer->status == "Closed-Done" ? "Qualified" : ($trainer->status == "Closed-Reject" ? "Not Qualified" : '-') }}</td> --}}
                                                                <td>{{ $trainer->qualification }}</td>
                                                                {{--<td><a href="{{ url('trainer_qualification_view', $trainer->id) }}"><i
                                                                            class="fa-solid fa-pencil" style="color: #355cab;"></i></a></td> --}}
                    
                                                                <td>{{ $trainer->experience }}</td>
                                                               {{-- <td>
                                                                    @if ($trainer->initial_attachment)
                                                                        <a href="{{ asset('upload/' . $trainer->initial_attachment) }}"
                                                                            target="_blank" download>
                                                                            {{ $trainer->initial_attachment }} <i class="fas fa-download"></i>
                                                                        </a>
                                                                    @else
                                                                        NA
                                                                    @endif
                                                                </td> --}}
                                                                <!-- <td>{{ $trainer->status }}</td> -->
                                                            </tr>
                                                        @endif
                                                        @endforeach
                        
                                                    </tbody>
                                                   {{-- <tbody>
                                                        <tr>
                                                            <td>1</td>
                                                            <td>Saurav Kumar</td>
                                                            <td>PW1234</td>
                                                            <td>Senior Trainer</td>
                                                            <td>MSc in Education</td>
                                                            <td>10</td>
                                                        </tr>
                                                        <tr>
                                                            <td>2</td>
                                                            <td>Himanshu Patil</td>
                                                            <td>PW12345</td>
                                                            <td>Assistant Trainer</td>
                                                            <td>Bachelor's in Psychology</td>
                                                            <td>5</td>
                                                        </tr>
                                                        <tr>
                                                            <td>3</td>
                                                            <td>Vikash Prajapati</td>
                                                            <td>PW12</td>
                                                            <td>Lead Trainer</td>
                                                            <td>PhD in Sociology</td>
                                                            <td>15</td>
                                                        </tr>
                                                        <tr>
                                                            <td>4</td>
                                                            <td>Happy Singh</td>
                                                            <td>PW1</td>
                                                            <td>Training Coordinator</td>
                                                            <td>MBA</td>
                                                            <td>8</td>
                                                        </tr>
                                                        <tr>
                                                            <td>5</td>
                                                            <td>Harsh</td>
                                                            <td>PW1234567</td>
                                                            <td>Technical Trainer</td>
                                                            <td>B.Tech in Computer Science</td>
                                                            <td>6</td>
                                                        </tr>
                                                    </tbody> --}}

                                    
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                           {{-- <div class="mt-1" style="padding-left: 20px;">
                                Note: Training of each subject shall be imparted to applicable employee at least once in a
                                year. Mention 'P' in Training Plan for Training scheduling month.
                            </div> --}}
                            <div></div>
                            <br>
                            <div class="col-11 mt-4 d-flex justify-content-between align-items-center">
                                <!-- First "Prepared by" section -->
                                <div class="text-center" style="flex: 1;text-align: left;">
                                    <strong>Himanshu Patil</strong><br>
                                    <span>Prepared by <br>Sign & Date: 25-oct-2024 <br>(Concerned dept.)</span>
                                </div>

                                <!-- Second "Prepared by" section -->
                                <div class="text-center" style="flex: 1;text-align: left;">
                                    <strong>Himanshu Patil</strong><br>
                                    <span>Reviewed by <br>Sign & Date: 25-oct-2024 <br>(Head/Designee of concerned dept.)</span>
                                </div>


                                <div class="text-center" style="flex: 1;text-align: left;">
                                    <strong>Himanshu Patil </strong><br>
                                    <span>Approved by <br>Sign & Date: 25-oct-2024 <br>(Head QA/Designee)</span>
                                </div>
                            </div>


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
                filename: 'List-of-Qualified-Trainers.pdf',
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
                    pdf.text(text, 10, 1.8);  // Left aligned (10 is the X position), 100px down from top (1.0)
                }
    
                // Save the PDF after setting the page numbers
                pdf.save('List-of-Qualified-Trainers.pdf');
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
