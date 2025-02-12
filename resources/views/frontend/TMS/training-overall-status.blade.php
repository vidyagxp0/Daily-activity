@extends('frontend.layout.main')
@section('container')
    @if (Helpers::checkRoles(6))
        @include('frontend.TMS.head')
    @endif

    <style>
    .inner-block {
        margin-bottom: 20px;
        padding: 20px;
        box-shadow: 12px 12px 24px #b2b8c9, -12px -12px 24px #f0f8ff;
        background: #ffffff;
        overflow: hidden;
    }

    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
        padding: 10px 0;
    }

    .logo-left, .logo-right {
        width: 130px;
    }

    .center h4 {
        margin: 0;
        font-size: 1.5em;
        text-align: center;
        flex-grow: 1;
    }

    .form-field-heads {
        text-align: center; 
        margin-bottom: 20px;
    }
    .form-field-heads .pr-id h4 {
        font-weight: bold;
        font-size: 1.5em;
        margin: 0;
    }
 
    .form-container {
        border: 2px solid black;
        padding: 20px;
        border-radius: 5px;
    }

    /* .underline {
        display: inline-block;
        width: calc(100% - 150px);
        border-bottom: 1px solid black;
        height: 1.5em;
        vertical-align: middle;
        margin-left: 10px;
    } */

    /* .full-width-underline {
        display: inline-block;
        width: calc(100% - 200px); 
        border-bottom: 1px solid black;
        height: 1.5em;
        vertical-align: middle;
        margin-left: 10px;
    }

    .inline-underline {
        display: inline-block;
        width: 40%;
        border-bottom: 1px solid black;
        height: 1.5em;
        vertical-align: middle;
        margin-left: 5px;
    } */

    .table-bordered {
        border: 2px solid black; 
    }
    .table-bordered th,
    .table-bordered td {
        border: 1px solid black;
    }
</style>     


{{-- {{  dd($training, $trainingUsers); }} --}}
{{-- {{  dd($training); }} --}}

  
         <div id="training-document-view">
            <div class="text-right mb-3" style="text-align: left; display: flex; justify-content: space-between;">
                <button id="exportPDF" class="btn btn-primary" style="margin-left: 10px;">Export to PDF</button>
                <a href="{{ url('TMS') }}" class="btn btn-primary text-white text-decoration-none" style="margin-right: 10px;">Exit</a>
            </div>

             <div class="container-fluid">
        <div class="inner-block">
            <div class="pm-certificate-logos text-center">
                <img src="{{ asset('user/images/connexo.png') }}" alt="connexo Logo" class="logo logo-left">
                <p class="center" style="margin-left: 98px; font-size: 24px; font-weight: bold; white-space: nowrap;">TRAINING ATTENDANCE RECORD</p>
                {{-- <img src="{{ asset('user/images/symbiotec_pharmalab_pvt_ltd__logo.jpg') }}" alt="Vidhya GxP Logo" class="logo logo-left" style="max-height: 104px;"> --}}
            </div>

            
            
            <div style="text-align: right; margin-left: -30px;">
                <strong>Page i of 1</strong>
                <br>
                <strong class="right">Format No:</strong> CQA-F-024E-R0
            </div>   
            <div class="header">
                <div class="left"><span class="fw-bold">SOP No. </span> CQA-024 </div>
                
            </div>
            
            <div id="pdf-content">
                <div class="form-field-heads">
                    {{-- <div class="pr-id">
                       <h4>TRAINNG ATTENDANCE RECORD</h4> 
                    </div> --}}
                </div>
                <br>
               
            <div class="form-container">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <strong>Date of Training:</strong>
                        <span class="underline">{{($training['created_at'])->format('Y-m-d') ?? 'N/A' }}</span>

                    </div>
            
                    <div class="col-md-6 mb-3">
                        <strong>Type of training:</strong>
                        <span class="underline">{{ $training['training_plan_type'] ?? 'N/A' }}</span>
                    </div>
            
                    <div class="col-md-6 mb-3">
                        <strong>Training subject/topic:</strong>
                        <span class="full-width-underline">{{ $training['traning_plan_name'] ?? 'N/A' }}</span>
                    </div>
            
                    <div class="col-md-6 mb-3">
                        <strong>Ref. Doc. No.:</strong>
                        <span class="underline">{{ $training['sops'] ?? 'N/A' }}</span>
                    </div>
            
                    <div class="col-md-6 mb-3">
                        <strong>Name of faculty/trainer:</strong>&nbsp;&nbsp;&nbsp;&nbsp;{{ Helpers::getInitiatorName($training['Trainer']) ?? 'N/A' }}

                        <span class="underlines"></span>
                    </div>
            
                    <div class="col-md-6 mb-3">
                        <strong>Training duration (From:</strong>
                        <span class="inline-underline">{{ ($training['created_at'])->format('Y-m-d') ?? 'N/A' }}</span>
                        <strong>To:</strong>
                        <span class="inline-underline">    {{ $training['training_end_date'] ? \Carbon\Carbon::parse($training['training_end_date'])->format('Y-m-d') : 'N/A' }}
                        </span>)
                    </div>
                </div>
            </div>
            
            
               <br>   
               <style>
                .table-bordered {
                    border: 2px solid black; 
                }
                .table-bordered th,
                .table-bordered td {
                    border: 1px solid black;
                }
            </style>         
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Sr.NO.</th>
                            <th>Name of Trainee</th>
                            <th>EmpCode</th>
                            <th>Designation</th>
                            <th>Dept.</th>
                            <th>Status</th>
                            <th>Completed On</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($trainingUsers as $index => $user)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $user->employee_name }}</td>
                                <td>{{ $user->full_employee_id }}</td>
                                <td>{{ $user->job_title }}</td>
                                <td>{{ $user->department }}</td>
                                @php
                                    // Find the latest record for the current user
                                    $userResult = $allEmpResults
                                                    ->where('emp_id', $user->full_employee_id) // Filter by emp_id
                                                    ->sortByDesc('created_at')                // Sort by latest record
                                                    ->first();                                // Get the first record
                                @endphp
                                <td>
                                    @if ($userResult && $userResult->result == 'Pass')
                                        Pass
                                    @elseif ($userResult && ($userResult->result == 'Fail' || $userResult->attempt_number == 3))
                                        Fail
                                    @else
                                        Pending
                                    @endif
                                </td>
                                <td>
                                    @if ($userResult && $userResult->result == 'Pass')
                                        {{ $userResult->created_at }}
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                
                        {{-- Handle case when no data is found --}}
                        @if ($trainingUsers->isEmpty())
                        <tr>
                            <td colspan="7" class="text-center">No data available</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
                
            </div>
        </div>
        <br>
        <br>
        <div class="col-lg-12 d-flex justify-content-end align-items-center">
            <div class="group-input">
                <strong>Trainer/ Faculty (Sign & Date):</strong> <span>{{ Helpers::getInitiatorName($training['Trainer']) ?? 'N/A' }}</span>
            </div>
        </div>
     </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>

    <script>
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
                filename: 'Qualified_trainers_list.pdf',
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
    </script>
@endsection
