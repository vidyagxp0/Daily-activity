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

    <!-- Include html2pdf.js library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>

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

                                <div class="row">
                                    <strong style="display: flex; justify-content: end;" class="nsme">Page i of i</strong>
                                    <br>
                                    <div class="header">
                                        <div class="left"><span class="fw-bold">SOP No. </span> CQA-024 </div>
                                        <strong class="right">Format No: </strong> CQA-F-024L-R0
                                    </div>
                                    <br><br><br>

                                    <div class="col-lg-12 d-flex justify-content-between align-items-center">
                                        <div class="group-input">
                                            <strong>Location:</strong> <span>P1 (Indore Location)</span>
                                        </div>
                                        <div class="group-input">
                                            <strong>Department/Area:</strong> <span>Quality Control </span>
                                        </div>
                                        <div class="group-input">
                                            <strong>Doc.No.:</strong> <span>SOP/QC/0001/R1234</span>
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
                                                                <td>{{ $trainer->employee_name ? $trainer->employee_name : 'NA' }}</td>
                                                                <td>{{ $trainer->employee_id ? $trainer->employee_id : 'NA' }}</td>
                                                                <td>{{ $trainer->designation }}</td>
                                                                <td>{{ $trainer->qualification }}</td>
                                                                <td>{{ $trainer->experience }}</td>
                                                            </tr>
                                                        @endif
                                                        @endforeach
                                                    </tbody>
                                                </table>
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
    </div>

    <script>
        document.getElementById('exportPDF').addEventListener('click', function () {
            var element = document.getElementById('pdf-content');

            var opt = {
                margin: 0.2,
                filename: 'List-of-Qualified-Trainers.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 3 },
                jsPDF: { unit: 'in', format: 'letter', orientation: 'landscape' }
            };

            html2pdf().set(opt).from(element).toPdf().get('pdf').then(function (pdf) {
                var totalPages = pdf.internal.getNumberOfPages();
                for (var i = 1; i <= totalPages; i++) {
                    pdf.setPage(i);
                    pdf.setFontSize(10);
                    pdf.text('Page ' + i, pdf.internal.pageSize.width / 2, 10, { align: 'center' });
                }
            }).save();
        });
    </script>
@endsection
