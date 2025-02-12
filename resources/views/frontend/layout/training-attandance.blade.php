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
.w-100 {
        width: 100%;
    }
 </style>
    <!-- Include html2pdf.js library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>

    <div class="form-field-head">
        <div class="pr-id">
            Training Attandance 
        </div>
    </div>
    <div id="change-control-fields">
        <div class="container-fluid">

            <!-- Export Button -->
            {{-- <div class="text-right mb-3">
                <button id="exportPDF" class="btn btn-primary">Export to PDF</button>
            </div> --}}
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
                                <div class="row">
                                    <div style="margin-top: -27px;" class="logo">
                                        <img style="width: 130px; margin-right: 1210px;" src="https://navin.mydemosoftware.com/public/admin/assets/images/connexo.png" alt="text">
                                        {{-- <img style="width: 90px;" src="https://media.licdn.com/dms/image/v2/C4E0BAQFbURQWpKn58A/company-logo_200_200/company-logo_200_200/0/1630619488370/symbiotec_pharmalab_pvt_ltd__logo?e=2147483647&v=beta&t=ijLmHrqtD-uAkL-S29EmQlvC3709-6BC7VvU19lcbTM" alt="text"> --}}
                                    </div>
                                    <div style="text-align: right; margin-left: -30px;">
                                        <strong>Page i of i</strong>
                                    </div>                                                                                                          
                                    <div class="row">
                                        <div class="header">
                                            <div class="left"><span class="fw-bold">SOP No. </span> CQA-024 </div>
                                            <h4 class="center" style="margin-left: 98px;">Training Attandance Record</h4>
                                            <strong class="right">Format No: </strong> CQA-F-024E-R0
                                        </div>
                                    <br><br><br><br>
                                        <div class="col-lg-12 mb-3">
                                            <div class="border p-3"> <!-- Added border and padding -->
                                                <div class="row"> <!-- Row to align columns properly -->
                                                    
                                                    
                                                    <style>
                                                        .training-input {
                                                            display: flex;
                                                            align-items: center; 
                                                        }

                                                        .training-input label {
                                                            margin-right: 10px;
                                                            flex: 0 0 auto; 
                                                        }

                                                        .training-input .input-group {
                                                            flex: 1; 
                                                        }

                                                    </style>
                                                    
                                                    <div class="col-lg-6 mb-3">
                                                        <div class="group-input">
                                                            <label for="training_date"><strong>Date Of Training:</strong> <span style="font-weight: 400" id="training_date"></span></label>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-lg-6 mb-3">
                                                        <div class="group-input">
                                                            <label for="training_type"><strong>Type Of Training:</strong> <span  style="font-weight: 400" id="training_type"></span></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 mb-3">
                                                        <div class="training-input mb-3">
                                                            <label for="topic"><strong>Training Subject/Topic:</strong></label>
                                                            <div class="input-group">
                                                                <select name="topic" id="topic" class="form-control custom-select" onchange="updateSelectedTopic()">
                                                                    <option value="">Select Training Topic</option>
                                                                    @foreach($topic as $val)
                                                                        <option value="{{ $val->id }}">{{ $val->traning_plan_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 mb-3">
                                                        <div class="group-input">
                                                            <label for="ref_doc"><strong>Ref. Doc. No.:</strong> <span  style="font-weight: 400" id="ref_doc"></span></label>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-lg-6 mb-3">
                                                        <div class="group-input">
                                                            <label for="trainer_name"><strong>Name Of Faculty/Trainer:</strong> <span  style="font-weight: 400" id="trainer_name"></span></label>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-lg-6 mb-3">
                                                        <div class="group-input">
                                                            <label for="training_duration"><strong>Training Duration:</strong> <span  style="font-weight: 400" id="training_duration"></span></label>
                                                        </div>
                                                    </div>
                                                    
                                                    <style>
                                                        .group-input {
                                                            display: flex;
                                                            justify-content: space-between;
                                                            align-items: center;
                                                        }

                                                        .group-input label {
                                                            flex: 1;
                                                            margin: 0; 
                                                        }

                                                        .group-input span {
                                                            margin-left: 10px; 
                                                            font-weight: bold;
                                                        }

                                                        .custom-select {
                                                        appearance: none; 
                                                        -webkit-appearance: none;
                                                        -moz-appearance: none;
                                                        
                                                        border: none; 
                                                        background-color: transparent; 
                                                        
                                                        width: 100%; 
                                                        padding: 5px 0; 
                                                        
                                                        font-size: 16px; 
                                                        color: #333; 
                                                    }

                                                    .custom-select:focus {
                                                        outline: none; 
                                                        border-bottom: 1px solid #007BFF; 
                                                    }

                                                    .custom-select option {
                                                        color: #000; 
                                                    }

                                                  
                                                    .custom-select::after {
                                                        content: '';
                                                        position: absolute;
                                                        right: 10px;
                                                        top: 50%;
                                                        transform: translateY(-50%);
                                                        border-left: 5px solid transparent;
                                                        border-right: 5px solid transparent;
                                                        border-top: 5px solid #000; 
                                                        pointer-events: none;
                                                    }
                                                    .group-input {
                                                    margin-bottom: 20px; 
                                                }

                                                .group-input label {
                                                    display: block; 
                                                    font-weight: bold;
                                                    margin-bottom: 5px; 
                                                }

                                                .training-value {
                                                    font-size: 16px; 
                                                    color: #333;
                                                    background-color: #f9f9f9; 
                                                    padding: 10px; 
                                                    border-radius: 4px; 
                                                    border: 1px solid #ddd; 
                                                } 


                                                    </style>
                                                    <script>
                                                        // JavaScript to handle data filtering based on selection
                                                        var trainingData = {
                                                            @foreach($topic as $val)
                                                                "{{ $val->id }}": {
                                                                    "training_start_date": "{{ Helpers::getdateFormat($val->training_start_date) }}",
                                                                    "training_end_date": "{{ Helpers::getdateFormat($val->training_end_date) }}",
                                                                    "training_plan_type": "{{ $val->training_plan_type }}",
                                                                    "sops": "{{ $val->sops }}",
                                                                    "trainer_name": "{{ Helpers::getInitiatorName($val->trainner_id) }}"
                                                                },
                                                            @endforeach
                                                        };
                                                    
                                                        // When the topic is changed, update the fields with related data
                                                        document.getElementById('topic').addEventListener('change', function() {
                                                            var topicId = this.value;
                                                    
                                                            if (topicId && trainingData[topicId]) {
                                                                var data = trainingData[topicId];
                                                                document.getElementById('training_date').innerText = data.training_start_date; // Only the start date
                                                                document.getElementById('training_type').innerText = data.training_plan_type;
                                                                document.getElementById('ref_doc').innerText = data.sops;
                                                                document.getElementById('trainer_name').innerText = data.trainer_name;
                                                                document.getElementById('training_duration').innerText = 'From ' + data.training_start_date + ' To ' + data.training_end_date;
                                                            } else {
                                                                // Clear fields if no valid topic is selected
                                                                document.getElementById('training_date').innerText = '';
                                                                document.getElementById('training_type').innerText = '';
                                                                document.getElementById('ref_doc').innerText = '';
                                                                document.getElementById('trainer_name').innerText = '';
                                                                document.getElementById('training_duration').innerText = '';
                                                            }
                                                        });
                                                    </script>
                                                    
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        
                                    
                                    @php 
                                        // Fetch all documents
                                        $dataAll = DB::table('documents')->get();
                                    @endphp
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <table id="example1" class="table table-bordered table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>Sr. No.</th>
                                                            <th>Name Of Trainee</th>
                                                            <th>Emp. Code</th>
                                                            <th>Designation</th>
                                                            <th>Dept.</th>
                                                            <th>Trainee Sign & Date</th>
                                                            <th>Remark</th>
                                                           
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($topic as $key => $value)
                                                            <tr>
                                                                <td>{{ $key + 1 }}.</td>
                                                                <td>Himanshu Patil</td>
                                                                <td>01</td>
                                                                <td>Trainee</td>
                                                                <td>Quality Control</td>
                                                                <td>23-Oct-2024</td>
                                                                <td>Send induction-Training On</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>                      
                            </div>
                            <br>
                            <br>
                            <div class="col-lg-12 d-flex justify-content-end align-items-center">
                                <div class="group-input">
                                    <strong>Trainer/ Faculty (Sign & Date)</strong> <span>_________________</span>
                                </div>
                            </div>
                            
                            <br>
                            <br>
                            <br>
                            <br>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- PDF Export Script -->
    <script>
        document.getElementById('exportPDF').addEventListener('click', function() {
            var element = document.getElementById('pdf-content');
    
            // Dynamically add a title before generating the PDF
            var title = document.createElement('h1');
            // title.innerText = 'Training Attendance Report'; // Set your title
            title.style.textAlign = 'center';  // Center the title
            title.style.fontSize = '24px';     // Set font size
            title.style.fontWeight = 'bold';   // Set font weight
            title.style.marginBottom = '20px'; // Add margin below the title
            title.style.color = '#333';        // Set the text color (optional)
    
            element.prepend(title); // Add the title at the beginning of the content
    
            var opt = {
                margin: 0.2,
                filename: 'Training_Attandance.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2 },
                jsPDF: { unit: 'in', format: 'letter', orientation: 'landscape' }
            };
    
            html2pdf().set(opt).from(element).save().then(function() {
                // Remove the title after saving PDF to keep the original content intact
                element.removeChild(title);
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
                    rowSOPs.push({ id: sopId, createdAt: sopCreatedAt }); // Add the SOP with its creation date
                }

                // Update the SOP counts for this row
                updateSOPCounts(rowId);
            }

            // Function to update SOP counts for a specific row based on its selected SOPs
            function updateSOPCounts(rowId) {
                // Reset all counts to 0 for the given row
                const monthCounts = {1: 0, 2: 0, 3: 0, 4: 0, 5: 0, 6: 0, 7: 0, 8: 0, 9: 0, 10: 0, 11: 0, 12: 0};

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
                    const rowId = checkbox.closest('tr').getAttribute('data-row-id'); // Assuming row has a data attribute for the ID
                    const sopId = checkbox.value; // SOP ID from the checkbox value
                    const sopCreatedAt = checkbox.getAttribute('data-created-at'); // Assuming you set a data attribute for creation date

                    updateSOPSelection(rowId, sopId, sopCreatedAt);
                });
            });
    </script>
    
@endsection
