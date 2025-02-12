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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>

    <div class="form-field-head">
        <div class="pr-id">
            Yearly Training Planner
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
                            <div class="inner-block-content">
                                <div class="pm-certificate-logos text-center">
                                    <img src="{{ asset('user/images/connexo.png') }}" alt="connexo Logo" class="logo logo-left">
                                    <p class="center" style="margin-left: 98px; font-size: 24px; font-weight: bold; white-space: nowrap;">Yearly Training Planner</p>
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
                
                                {{-- <div class="row">
                                    <strong style="display: flex; justify-content: end;" class="nsme">Page i of i</strong>
                                    <br>
                                    <div class="header">
                                        <div class="left"><span class="fw-bold">SOP No. </span> CQA-024 </div>
                                      
                                        <strong class="right">Format No: </strong> CQA-F-024J-R0
                                    </div>
                                    <br>
                                    <br> --}}
                                    
                                    @if(isset($planner[0]))
                                        <div class="col-lg-12 d-flex justify-content-between align-items-center">
                                            <div class="group-input">
                                                <strong>Location:</strong> <span>{{ $planner[0]->site_division }}</span>
                                            </div>
                                            <div class="group-input">
                                                <strong>Name of Dept & Area:</strong> <span>{{ Helpers::getDepartmentNameFromCode($planner[0]->department) }}</span>
                                            </div>
                                            <div class="group-input">
                                                <strong>Year:</strong> <span>{{ $planner[0]->year }}</span>
                                            </div>
                                        </div>
                                    @else
                                        <p>No Data Found</p>
                                    @endif

                                    <br><br>
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <table id="example1" class="table table-bordered table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>Sr. No.</th>
                                                            <th>Topic/Subject</th>
                                                            <th>Ref. No.</th>
                                                            {{-- <th>Start Date</th> --}}
                                                            <th>Jan</th>
                                                            <th>Feb</th>
                                                            <th>Mar</th>
                                                            <th>Apr</th>
                                                            <th>May</th>
                                                            <th>Jun</th>
                                                            <th>Jul</th>
                                                            <th>Aug</th>
                                                            <th>Sep</th>
                                                            <th>Oct</th>
                                                            <th>Nov</th>
                                                            <th>Dec</th>
                                                        </tr>
                                                    </thead>                 
                                                    <tbody>
                                                        @foreach ($planner as $key => $value)
                                                        @php
                                                           
                                                            $monthlyCounts = DB::table('yearly_training_planners')
                                                                ->select(
                                                                    'document_number',
                                                                    DB::raw('MONTH(start_date) as month'),
                                                                    DB::raw('COUNT(*) as count')
                                                                )
                                                                ->groupBy('document_number', 'month')
                                                                ->get();
                                                            $counts = [];

                                                            foreach ($monthlyCounts as $record) {
                                                                $counts[$record->document_number][$record->month] = $record->count;
                                                            }
                                                        @endphp
                                                            <tr>
                                                                <td>{{ $key + 1 }}.</td>
                                                                <td>{{ $value->topic }}</td>
                                                                <td>{{ Helpers::getFormattedDocumentNumbers($value->document_number) }}</td>
                                                                {{-- <td>{{ $value->start_date }}</td> --}}
                                                                <td id="month-1-{{ $value->id }}">
                                                                    {{ $counts[$value->document_number][1] ?? 0 }} <!-- Jan -->
                                                                </td>
                                                                <td id="month-2-{{ $value->id }}">
                                                                    {{ $counts[$value->document_number][2] ?? 0 }} <!-- Feb -->
                                                                </td>
                                                                <td id="month-3-{{ $value->id }}">
                                                                    {{ $counts[$value->document_number][3] ?? 0 }} <!-- Mar -->
                                                                </td>
                                                                <td id="month-4-{{ $value->id }}">
                                                                    {{ $counts[$value->document_number][4] ?? 0 }} <!-- Apr -->
                                                                </td>
                                                                <td id="month-5-{{ $value->id }}">
                                                                    {{ $counts[$value->document_number][5] ?? 0 }} <!-- May -->
                                                                </td>
                                                                <td id="month-6-{{ $value->id }}">
                                                                    {{ $counts[$value->document_number][6] ?? 0 }} <!-- Jun -->
                                                                </td>
                                                                <td id="month-7-{{ $value->id }}">
                                                                    {{ $counts[$value->document_number][7] ?? 0 }} <!-- Jul -->
                                                                </td>
                                                                <td id="month-8-{{ $value->id }}">
                                                                    {{ $counts[$value->document_number][8] ?? 0 }} <!-- Aug -->
                                                                </td>
                                                                <td id="month-9-{{ $value->id }}">
                                                                    {{ $counts[$value->document_number][9] ?? 0 }} <!-- Sep -->
                                                                </td>
                                                                <td id="month-10-{{ $value->id }}">
                                                                    {{ $counts[$value->document_number][10] ?? 0 }} <!-- Oct -->
                                                                </td>
                                                                <td id="month-11-{{ $value->id }}">
                                                                    {{ $counts[$value->document_number][11] ?? 0 }} <!-- Nov -->
                                                                </td>
                                                                <td id="month-12-{{ $value->id }}">
                                                                    {{ $counts[$value->document_number][12] ?? 0 }} <!-- Dec -->
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

                            
                            <div class="mt-1" style="padding-left: 20px;">
                                Note: Training of each subject shall be imparted to applicable employee at least once in a year. Mention 'P' in Training Plan for Training scheduling month.
                            </div>
                            <div></div>
                            <br>
                            <div class="col-11 mt-4 d-flex justify-content-between align-items-center">
                                <div class="text-center" style="flex: 1;">
                                    <strong>Himanshu Patil</strong><br>
                                    <span>Prepared by (Sign & Date):23/10/24 <br>(Concerned dept.)</span>
                                </div>
                                <div class="text-center" style="flex: 1;">
                                    <strong>Himanshu Patil</strong><br>
                                    <span>Authorized by (Sign & Date):23/10/24 <br>(Head/Designee of concerned dept.)</span>
                                </div>
                                <div class="text-center" style="flex: 1;">
                                    <strong>Himanshu Patil </strong><br>
                                    <span>Approved by (Sign & Date):23/10/24 <br>(Head QA/Designee)</span>
                                </div>
                            </div>
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
                filename: 'Yearly_Training_Planner.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 3 },
                jsPDF: { unit: 'in', format: 'letter', orientation: 'landscape' }
            };
    
            html2pdf().set(opt).from(element).toPdf().get('pdf').then(function (pdf) {
                var totalPages = pdf.internal.getNumberOfPages(); // Correct way to get total number of pages
    
                // Set font style for page numbers (can be customized)
                pdf.setFont('times', 'bold');
                pdf.setFontSize(12);  
    
                // Loop through each page and add page number at the left side, 100px from top
                for (var i = 1; i <= totalPages; i++) {
                    pdf.setPage(i);
                    var text = "Page " + i + " of " + totalPages;
    
                    // Add page number at the left side, 100px from top
                    pdf.text(text, 10.04, 2.1);  
                }
    
                // Save the PDF after setting the page numbers
                pdf.save('Yearly_Training_Planner.pdf');
            });
        });
    </script>
    

    
    


<style>
  
    #pdf-content img {
        max-width: 100px; 
        height: auto;
    }


    #pdf-content table {
        width: 100%;
        border-collapse: collapse;
    }

    #pdf-content th, #pdf-content td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: center;
        font-size: 12px; 
    }

    .pm-certificate-logos {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .logo {
        max-width: 80px; 
    }

    .header, .footer {
        display: flex;
        justify-content: space-between;
    }
    #pdf-content table {
    width: 100%;
    border-collapse: collapse;
    border: 1px solid black; 
}

#pdf-content th, #pdf-content td {
    border: 1px solid black; 
    padding: 8px;
    text-align: center;
    font-size: 12px; 
}


</style>

@endsection
