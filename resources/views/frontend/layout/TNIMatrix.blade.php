@extends('frontend.layout.main')
@section('container')
    <style>
        textarea.note-codable {
            display: none !important;
        }

        header {
            display: none;
        }

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

        #example1 {
            border-collapse: collapse; 
            width: 100%;
        }

        #example1 th, #example1 td {
            border: 1px solid black;
            padding: 8px; 
            text-align: left; 
        }

        #example1 th {
            background-color: #f2f2f2;
        }
        
    </style>

    <!-- Include html2pdf.js library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>

    <div class="form-field-head">
        <div class="pr-id">
            Training Need Identification Matrix
        </div>
    </div>
    <div id="change-control-fields">
        <div class="container-fluid">

            
            <!-- Export Button -->
            <div class="d-flex justify-content-between mb-3">
                <button id="exportPDF" class="btn btn-primary">Export to PDF</button>
                <a href="{{ url('TMS') }}" class="btn btn-primary text-white text-decoration-none">Exit</a>
            </div>


            
            <!-- The section you want to export as PDF -->
            <div id="pdf-content">
                <form action="{{ route('yearly.training') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div id="step-form">
                        <div id="CCForm1" class="inner-block cctabcontent">
                            <div class="logo-header d-flex justify-content-between">
                            
                            
                                <img style="margin-top: 32px; height: 41px;" src="https://navin.mydemosoftware.com/public/admin/assets/images/connexo.png" alt="text">
                                {{-- <img style="width: 90px; margin-right: 30px;" src="https://media.licdn.com/dms/image/v2/C4E0BAQFbURQWpKn58A/company-logo_200_200/company-logo_200_200/0/1630619488370/symbiotec_pharmalab_pvt_ltd__logo?e=2147483647&v=beta&t=ijLmHrqtD-uAkL-S29EmQlvC3709-6BC7VvU19lcbTM" alt="text"> --}}

         
                            
                            </div>
                            
                            <div class="inner-block-content">
                                <div class="row">
                                    {{-- <strong style="display: flex; justify-content: end;" class="nsme">Page i of i</strong> --}}
                                    <br>
                                    <div class="header">
                                        {{-- <div class="left"><span class="fw-bold">SOP No. </span> CQA-024 </div>
                                        <p class="center" style="margin-left: 98px; font-size: 24px; font-weight: bold; white-space: nowrap;">Training Need Identification Matrix</p>


                                        <strong class="right">Format No: </strong> CQA-F-024C-R0 --}}
                                    </div>
                                    <br><br><br>
                                    <div class="col-lg-12 d-flex justify-content-between align-items-center">
                                        <div class="group-input">
                                            <strong>Location:</strong> <span>Indore</span>
                                        </div>
                                        <div class="group-input">
                                            <strong>Department & Area:</strong> <span>Department</span>
                                        </div>
                                        <div class="group-input">
                                            <strong>TNI No:</strong> <span>1</span>
                                        </div>
                                    </div>
                                    <br><br>
                                    
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <table id="example1" class="table table-bordered table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>Sr. No</th>
                                                            <th>SOP No.</th>
                                                            <th>SOP Title</th>
                                                            <th>Job Role</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>1</td>
                                                            <td>SOP/QA/001/R1</td>
                                                            <td>Introduction to Quality Control</td>
                                                            <td>Quality Assurance Manager, Quality Assurance Manager, Quality Assurance Manager</td>
                                                        </tr>
                                                        <tr>
                                                            <td>2</td>
                                                            <td>SOP/QA/001/R2</td>
                                                            <td>Document Control Procedure</td>
                                                            <td>Documentation Specialist, Documentation Specialist, Documentation Specialist</td>
                                                        </tr>
                                                        <tr>
                                                            <td>3</td>
                                                            <td>SOP/QA/001/R3</td>
                                                            <td>Employee Training Guidelines</td>
                                                            <td>Training Coordinator, Training Coordinator, Training Coordinator</td>
                                                        </tr>
                                                        <tr>
                                                            <td>4</td>
                                                            <td>SOP/QA/001/R4</td>
                                                            <td>Incident Reporting Procedures</td>
                                                            
                                                            <td>Health and Safety Officer</td>
                                                        </tr>
                                                        <tr>
                                                            <td>5</td>
                                                            <td>SOP/QA/001/R5</td>
                                                            <td>Equipment Maintenance Procedures</td>
                                                         
                                                            <td>Maintenance Technician, Maintenance Technician Maintenance Technician</td>
                                                            
                                                        </tr>
                                                        
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <br><br>
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <table id="example1" class="table table-bordered table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>TNI Matrix</th>
                                                            <th>Prepared by <br>Concerned dept.</th>
                                                            <th>Reviewed by <br>(Head/Designee: Concerned dept.)</th>
                                                            <th>Approved by <br>(Head/Designee-QA)</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td style="font-weight: bold;">Name</td>
                                                            <td>Quality Control</td>
                                                            <td>James Anderson, Head of Quality Control</td>
                                                            <td>Emily Johnson, QA Manager</td>
                                                        </tr>
                                                        <tr>
                                                            <td style="font-weight: bold;">Designation</td>
                                                            <td>Document Control</td>
                                                            <td>Sarah Thompson, Head of Documentation</td>
                                                            <td>David Wilson, QA Manager</td>
                                                        </tr>
                                                        <tr>
                                                            <td style="font-weight: bold;">Department</td>
                                                            <td>Employee Training</td>
                                                            <td>Linda Roberts, Training Coordinator</td>
                                                            <td>Michael Harris, QA Director</td>
                                                        </tr>
                                                        <tr>
                                                            <td style="font-weight: bold;"> Sign & Date</td>
                                                            <td>Health and Safety</td>
                                                            <td>Daniel Lewis, Health and Safety Officer</td>
                                                            <td>Susan Clark, QA Lead</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    
                                </div>                      
                            </div>
                          
                            <br>
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

          
            var title = document.createElement('h1');
            title.style.textAlign = 'center';  
            title.style.fontSize = '24px';   
            title.style.fontWeight = 'bold';   
            title.style.marginBottom = '20px'; 
            title.style.color = '#333';      

            element.prepend(title); 

            var opt = {
                margin: 0.2,
                filename: 'Training-Need-Identification-Matrix.pdf',
                image: { type: 'jpeg', quality: 0.98 }, 
                html2canvas: { scale: 2 },
                jsPDF: { unit: 'in', format: 'letter', orientation: 'landscape' }
            };

            html2pdf().set(opt).from(element).save().then(function() {
        
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
                filename: 'Training-Need-Identification-Matrix.pdf',
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
                    pdf.text(text, 10.15, 1.8);  // Left aligned (10 is the X position), 100px down from top (1.0)
                }
    
                // Save the PDF after setting the page numbers
                pdf.save('Training-Need-Identification-Matrix.pdf');
            });
        });
    </script>
    
@endsection
