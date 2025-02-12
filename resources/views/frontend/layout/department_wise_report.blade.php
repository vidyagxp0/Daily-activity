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
     position: fixed;
        top: -140px;
        left: 0;
        width: 100%;
        display: block;
    }
    header table,
    header th,
    header td,
    footer table,
    footer th,
    footer td,
    .border-table table,
    .border-table th,
    .border-table td {
        border: 1px solid black;
        border-collapse: collapse;
        font-size: 0.9rem;
        vertical-align: middle;
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
            Job Role Training History
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
                <form action="{{ route('yearly.training') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <!-- Form content -->
                    <div id="step-form">
                        <div id="CCForm1" class="inner-block cctabcontent">
                            <div class="inner-block-content">
                                <div class="pm-certificate-logos text-center">
                                    <img src="{{ asset('user/images/connexo.png') }}" alt="connexo Logo" class="logo logo-left">
                                    <p class="center" style="margin-left: 98px; font-size: 24px; font-weight: bold; white-space: nowrap;">DEPARTMENT WISE EMPLOYEES JOB ROLE</p>
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
                              
                                <div class="row">
                                    {{-- <strong style="display: flex; justify-content: end;" class="nsme">Page 1 of 1</strong>
                                    <br> --}}
                                    {{-- <div class="header">
                                        <div class="left"><span class="fw-bold">SOP No. </span> CQA-024 </div>
                                        <strong class="right">Format No: </strong> CQA-F-024L-R0
                                         <div class="pm-certificate-logos text-center">
                                            <img src="{{ asset('user/images/connexo.png') }}" alt="connexo Logo" class="logo logo-left">
                                            <p class="center" style="margin-left: 98px; font-size: 24px; font-weight: bold; white-space: nowrap;">DEPARTMENT WISE EMPLOYEES JOB ROLE</p>
                                            <img src="{{ asset('user/images/symbiotec_pharmalab_pvt_ltd__logo.jpg') }}" alt="Vidhya GxP Logo" class="logo logo-left">
                                   </div> --}}

                                    </div>
                                    <br>
                                  {{-- <div class="col-lg-12 d-flex justify-content-between align-items-center">
                                    <div class="group-input">
                                        <strong>Location:</strong> <span>Indore</span>
                                    </div>
                                    <div class="group-input">
                                        <strong>Department & Section / Area:</strong> <span>Quality Control </span>
                                    </div>
                                    <div class="group-input">
                                        <strong>Year:</strong> <span>2024</span>
                                    </div>

                                    <div class="group-input">
                                        <strong>Doc. No:</strong> <span></span>
                                    </div>
                                </div> --}}
                                @if(isset($dpwe[0]))
                                        <div class="col-lg-12 d-flex justify-content-between align-items-center">
                                            <div class="group-input">
                                                <strong>Location:</strong> <span>{{ $dpwe[0]->location }}</span>
                                            </div>
                                            <div class="group-input">
                                                <strong>Department & Section/Area:</strong> <span>{{ Helpers::getDepartmentNameFromCode($dpwe[0]->department) }}</span>
                                            </div>
                                            <div class="group-input">
                                                <strong>Year:</strong> <span>{{ $dpwe[0]->year }}</span>
                                            </div>
                                        </div>
                                    @else
                                        <p>No Data Found</p>
                                    @endif
                                    <br>
                                    <br>

                                    

                                    @php 
                                        // Fetch all documents
                                        $dataAll = DB::table('documents')->get();
                                    @endphp
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <table id="example1" class="table table-bordered table-striped" style="border: 1px solid black;" >
                                                    <thead>
                                                        <tr>
                                                            <th>Sr. No.</th>
                                                            <th>Name of Employee</th>
                                                            <th>Employee Code</th>
                                                            <th>SOP Number</th>
                                                            <th>Job role as per Job description</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($dpwe as $key => $value)
                                                            <tr>
                                                                <td>{{ $key + 1 }}.</td>
                                                                <td>{{ Helpers::getEmployeeNameFromId($value->employee_name) }}</td>
                                                                <td>{{ $value->employee_code }}</td>
                                                    
                                                                <td>
                                                                    @foreach ($dataAll as $dat)
                                                                        <div>
                                                                            <label>
                                                                                {{ $dat->sop_type_short }}/{{ $dat->department_id }}/000{{ $dat->id }}/R{{ $dat->major }}
                                                                            </label>
                                                                        </div>
                                                                    @endforeach
                                                                </td>
                                                    
                                                                <td>
                                                                    @if (!empty($selectedJobRoles))
                                                                        <span>{{ implode(', ', $selectedJobRoles) }}</span>
                                                                    @else
                                                                        <span class="text-muted">No roles selected</span>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                    
                                                    
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>                      
                            </div>
                            {{-- <div class="mt-1" style="padding-left: 20px;">
                               <strong> Tick mark (✔) in respective employee job role wherever applicable and mention 'NA' wherever not applicable
                               </strong>
                            </div> --}}
                            <div></div>
                            <br>
                            <div class="col-11 mt-4 d-flex justify-content-between align-items-center">
                                <!-- First "Prepared by" section -->
                                <div class="text-center" style="flex: 1;">
                                    <strong>Himanshu Patil</strong><br>
                                    <span>Prepared by (Sign & Date):23/10/24 <br>(Concerned dept.)</span>
                                </div>
                            
                                <!-- Second "Prepared by" section -->
                                <div class="text-center" style="flex: 1;">
                                    <strong>Himanshu Patil</strong><br>
                                    <span>Reviewed by (Sign & Date):23/10/24 <br>(Concerned dept.)</span>
                                </div>



                                <div class="text-center" style="flex: 1;">
                                    <strong>Himanshu Patil </strong><br>
                                    <span>Approved by (Sign & Date):23/10/24 <br>(Head /Designee of Concerned Dept.)</span>
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
                filename: 'Department_Wise_Employees_Job_Role.pdf',
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
                    pdf.text(text, 10., 1.8);  // Left aligned (10 is the X position), 100px down from top (1.0)
                }
    
                // Save the PDF after setting the page numbers
                pdf.save('Department_Wise_Employees_Job_Role.pdf');
            });
        });
    </script>
    
         
@endsection
