<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>VidyaGxP - Software</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
</head>

<style>
    body {
        font-family: 'Roboto', sans-serif;
        margin: 0;
        padding: 0;
        min-height: 100vh;
    }

    .w-10 {
        width: 10%;
    }

    .w-20 {
        width: 20%;
    }

    .w-25 {
        width: 25%;
    }

    .w-30 {
        width: 30%;
    }

    .w-40 {
        width: 40%;
    }

    .w-50 {
        width: 50%;
    }

    .w-60 {
        width: 60%;
    }

    .w-70 {
        width: 70%;
    }

    .w-80 {
        width: 80%;
    }

    .w-90 {
        width: 90%;
    }

    .w-100 {
        width: 100%;
    }

    .h-100 {
        height: 100%;
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

    table {
        width: 100%;
    }

    th,
    td {
        padding: 10px;
        text-align: left;
    }

    footer .head,
    header .head {
        text-align: center;
        font-weight: bold;
        font-size: 1.2rem;
    }

    @page {
        size: A4;
        margin-top: 160px;
        margin-bottom: 60px;
    }

    header {
        position: fixed;
        top: -140px;
        left: 0;
        width: 100%;
        display: block;
    }

    footer {
        width: 100%;
        position: fixed;
        display: block;
        bottom: -40px;
        left: 0;
        font-size: 0.9rem;
    }

    footer td {
        text-align: center;
    }

    .inner-block {
        padding: 10px;
    }

    .inner-block tr {
        font-size: 0.8rem;
    }

    .inner-block .block {
        margin-bottom: 30px;
    }

    .inner-block .block-head {
        font-weight: bold;
        font-size: 1.1rem;
        padding-bottom: 5px;
        border-bottom: 2px solid #4274da;
        margin-bottom: 10px;
        color: #4274da;
    }

    .inner-block th,
    .inner-block td {
        vertical-align: baseline;
    }

    .table_bg {
        background: #4274da57;
    }
</style>

<body>

    <header>
        <table>
            <tr>
                <td class="w-70 head">
                    Sample Management I Single Report
                </td>
                <td class="w-30">
                    <div class="logo">
                        <img src="https://navin.mydemosoftware.com/public/user/images/logo.png" alt=""
                            class="w-60">
                    </div>
                </td>
            </tr>
        </table>
        <table>
            <tr>
                <td class="w-30">
                    <strong> Sample Management No.</strong>
                </td>
                <td class="w-40">
                    {{ $data->record_number }}
                </td>
                <td class="w-30">
                    <strong>Record No.</strong> {{ str_pad($data->record, 4, '0', STR_PAD_LEFT) }}
                </td>
            </tr>
        </table>
    </header>
    <footer>
        <table>
            <tr>
                <td class="w-30">
                    <strong>Printed On :</strong> {{ date('d-M-Y') }}
                </td>
                <td class="w-40">
                    <strong>Printed By :</strong> {{ Auth::user()->name }}
                </td>
            </tr>
        </table>
    </footer>
    
    <div class="inner-block">
        <div class="content-table">
            <div class="block">
                <div class="block-head">
                    Receipt of the Sample at IPC
                </div>
                <table>
                    <tr> {{ $data->created_at }} added by {{ $data->originator }}
                        <th class="w-20">Division</th>
                        <td class="w-30"> {{ Helpers::getFullDivisionName($data->receipt_division) }}</td>
                        <th class="w-20">Reception Diary Number</th>
                        <td class="w-30">{{ $data->record_number }}</td>
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Mode of Receipt</th>
                        <td class="w-30">{{ $data->mode_receipt}} </td>

                        <th class="w-20">Others</th>
                        <td class="w-30">
                            @if ($data->other_mode)
                                {{ $data->other_mode}}
                            @else
                                Not Applicable
                            @endif
                        </td>   
                    </tr>

                    <tr>
                        <th class="w-20"> Due Date</th>
                        <td class="w-30">
                            @if ($data->due_date)
                            {{ \Carbon\Carbon::parse($data->due_date)->format('d-M-Y') }}
                        @else
                            Not Applicable
                        @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">Date</th>
                        <td class="w-30">
                            @if ($data->intiation_date)
                            {{ \Carbon\Carbon::parse($data->intiation_date)->format('d-M-Y') }}
                        @else
                            Not Applicable
                        @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">Received From</th>
                        <td class="w-30">
                            @if ($data->received_from)
                                {{ $data->received_from}}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">Brief Description of Sample</th>
                        <td class="w-30">
                            @if ($data->brief_description)
                                {{ $data->brief_description }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                   
                    <tr>
                        <th class="w-20">Source of sample</th>
                        <td class="w-30">
                            @if ($data->source_of_sample)
                               {{ $data->source_of_sample }}
                            @else
                               Not Applicable
                            @endif
                        </td>

                        <th class="w-20">Date of Review</th>
                        <td class="w-30">
                            @if ($data->date_of_review)
                                {{ \Carbon\Carbon::parse($data->date_of_review)->format('d-M-Y') }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                    </tr>
                    <tr>
                        <th class="w-20">Stakeholder's Email Address</th>
                        <td class="w-30">
                           @if ($data->stakeholder_email)
                              {{ $data->stakeholder_email }}
                           @else
                              Not Applicable
                            @endif
                        </td>

                        <th class="w-20">Stakeholder's Contact Number</th>
                        <td class="w-30"> 
                            @if ($data->stakeholder_contact)
                               {{ $data->stakeholder_contact }}
                            @else
                               Not Applicable
                            @endif
                        </td>
                       
                    </tr>
                
                </table>
            </div>
           
            <div class="block">
                <div class="block-head">
                    Receipt at Division
                </div>
                <table>
                    <tr>
                        <th class="w-20">Date of Receipt</th>
                        <td class="w-30">
                            @if ($data->date_of_receipt)
                                {{ \Carbon\Carbon::parse($data->date_of_receipt)->format('d-M-Y') }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        
                        <th class="w-20">Receptionist Diary Number</th>
                        <td class="w-30">
                            @if ($data->receptionist_diary)
                                {{ $data->receptionist_diary }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        
                    </tr>

                    <tr>
                        <th class="w-20">Received From</th>
                        <td class="w-30">
                            @if ($data->received_from_1)
                                {{ $data->received_from_1 }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">Brief Description of Sample</th>
                        <td class="w-30">
                            @if ($data->brief_description_of_sample_1)
                                {{ $data->brief_description_of_sample_1 }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">Sample type</th>
                        <td class="w-30">
                            @php
                                $sampleTypeNames = [
                                    'N' => 'New Drug Substance',
                                    'I' => 'Indian Pharmacopoeia Reference Standard',
                                    'T' => 'Proficiency Testing',
                                    'C' => 'Inter Laboratory Comparison',
                                    'P' => 'Phytopharmaceutical',
                                    'M' => 'Miscellaneous',
                                    '0' => 'Others',
                                ];
                            @endphp
                            @if ($data->sample_type && array_key_exists($data->sample_type, $sampleTypeNames))
                                {{ $sampleTypeNames[$data->sample_type] }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                </table>
                
                <div class="border-table">
                    <div class="block-head">
                        Attachment
                    </div>
                    <table>

                        <tr class="table_bg">
                            <th class="w-20">S.N.</th>
                            <th class="w-60">Attachment</th>
                        </tr>
                        @if ($data->attachment_receptionist)
                            @foreach (json_decode($data->attachment_receptionist) as $key => $file)
                                <tr>
                                    <td class="w-20">{{ $key + 1 }}</td>
                                    <td class="w-20"><a href="{{ asset('upload/' . $file) }}"
                                            target="_blank"><b>{{ $file }}</b></a> </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td class="w-20">1</td>
                                <td class="w-20">Not Applicable</td>
                            </tr>
                        @endif

                    </table>
                </div>
            </div>
            
            <div class="block">
                <div class="block-head">
                    Receipt by Sample Coordinator
                </div>

                <div class="border-table">
                    <table>
                        <tr class="table_bg">
                            <th class="w-10">Sr No.</th>
                            <th class="w-25">Assignment Of Date</th>
                            <th class="w-25">Analytical Receipt (AR) Number</th>
                            <th class="w-25">Sample Name</th>
                            <th class="w-25">Batch Number</th>
                        </tr>

                        @php
                            $productmateIndex = 0;
                        @endphp

                        @if ($ReceiptCoordinatorGrid && is_array($ReceiptCoordinatorGrid->data))
                            @foreach ($ReceiptCoordinatorGrid->data as $index => $Prodmateriyal)
                                <tr>
                                    <td>{{ ++$productmateIndex }}</td>
                                    <td>{{ $Prodmateriyal['assignment_date'] ?? '' }}</td>
                                    <td>{{ $Prodmateriyal['analytical_receipt'] ?? '' }}</td>
                                    <td>{{ $Prodmateriyal['sample_name'] ?? '' }}</td>
                                    <td>{{ $Prodmateriyal['Batch'] ?? '' }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5">Not Applicable</td>
                            </tr>
                        @endif
                    </table>
                </div>
            </div>
            
            <div class="block">
                <div class="border-table">
                    <table>
                        <tr class="table_bg">
                            <th class="w-10">Sr No.</th>
                            <th class="w-25">Sample Quantity</th>
                            <th class="w-25">Manufacturing Date</th>
                            <th class="w-25">Expiry Date</th>
                            <th class="w-25">Recommended Storage Conditions</th>
                            <th class="w-25">Physical Observation</th>
                            <th class="w-25">Remarks</th>
                        </tr>

                        @php
                            $productmateIndex = 0;
                        @endphp

                        @if ($ReceiptCoordinatorGrid && is_array($ReceiptCoordinatorGrid->data))
                            @foreach ($ReceiptCoordinatorGrid->data as $index => $Prodmateriyal)
                                <tr>
                                    <td>{{ ++$productmateIndex }}</td>
                                    <td>{{ $Prodmateriyal['sample_quantity'] ?? '' }}</td>
                                    <td>
                                        {{ $Prodmateriyal['manufacturing_date'] 
                                            ? \Carbon\Carbon::parse($Prodmateriyal['manufacturing_date'])->format('d-M-Y') 
                                            : '' }}
                                    </td>
                                    <td>
                                        {{ $Prodmateriyal['expiry_date'] 
                                            ? \Carbon\Carbon::parse($Prodmateriyal['expiry_date'])->format('d-M-Y') 
                                            : '' }}
                                    </td>
                                    <td>{{ $Prodmateriyal['recommended_storage'] ?? '' }}</td>
                                    <td>{{ $Prodmateriyal['physical_observation'] ?? '' }}</td>
                                    <td>{{ $Prodmateriyal['Remarks'] ?? '' }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7">Not Applicable</td>
                            </tr>
                        @endif
                    </table>
                </div>
            </div>
            
            <table>
                <tr>
                    <th class="w-20">Sample Coordinator Comment</th>
                        <td class="w-80">
                            @if ($data->Sample_coordinator_Comment)
                                {{ $data->Sample_coordinator_Comment }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                </tr>
            </table>

            
            <div class="border-table">
                <div class="block-head">
                    Sample Coordinator Attachment
                </div>
                <table>
                    <tr class="table_bg">
                        <th class="w-20">S.N.</th>
                        <th class="w-60">Attachment</th>
                    </tr>
                    @if ($data->Sample_coordinator_attachment)
                        @foreach (json_decode($data->Sample_coordinator_attachment) as $key => $file)
                            <tr>
                                <td class="w-20">{{ $key + 1 }}</td>
                                <td class="w-20"><a href="{{ asset('upload/' . $file) }}"
                                        target="_blank"><b>{{ $file }}</b></a> </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td class="w-20">1</td>
                            <td class="w-20">Not Applicable</td>
                        </tr>
                    @endif

                </table>
            </div>
            


            <div class="block">
                <div class="block-head">
                    Allocation of Sample for Analysis
                </div>

                <table>
                    <tr>
                        <th class="w-20">Analysis Type</th>
                        <td class="w-80">
                            @if ($data->analysis_type)
                                {{ $data->analysis_type }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                
                        <th class="w-20">Selection of Specifications or Standard Test Protocols (STPs)</th>
                        <td class="w-80">
                            @if ($data->specifications)
                                {{ $data->specifications }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    
                    <tr>
                        <th class="w-20">Details</th>
                        <td class="w-80">
                            @if ($data->details)
                                {{ $data->details }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                </table>

                <div class="border-table">
                    <div class="block-head">
                        Attachment
                    </div>
                    <table>

                        <tr class="table_bg">
                            <th class="w-20">S.N.</th>
                            <th class="w-60">Attachment</th>
                        </tr>
                        @if ($data->attachment_analysis)
                            @foreach (json_decode($data->attachment_analysis) as $key => $file)
                                <tr>
                                    <td class="w-20">{{ $key + 1 }}</td>
                                    <td class="w-20"><a href="{{ asset('upload/' . $file) }}"
                                            target="_blank"><b>{{ $file }}</b></a> </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td class="w-20">1</td>
                                <td class="w-20">Not Applicable</td>
                            </tr>
                        @endif

                    </table>
                </div>
            </div>

           
            <div class="block">
                <div class="block-head">
                   Sample Analysis
                </div>
                
                <table>
                    <tr>
                        <th class="w-20">Acknowledgement</th>
                        <td class="w-80">
                            @if ($data->Acknowledgement)
                                {{ $data->Acknowledgement }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        
                        <th class="w-20">MOA Change Needed</th>
                        <td class="w-80">
                            @if ($data->moa_change_needed)
                                {{ $data->moa_change_needed}}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">MOA Change Details</th>
                        <td class="w-80">
                            @if ($data->moa_change_details)
                                {{ $data->moa_change_details }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">Analysis Start Date</th>
                        <td class="w-80">
                            @if ($data->analysis_start_date)
                                {{ $data->analysis_start_date }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">Analysis End Date</th>
                        <td class="w-80">
                            @if ($data->analysis_end_date)
                                {{ $data->analysis_end_date }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">Turn Around Time (TAT)</th>
                        <td class="w-80">
                            @if ($data->turn_around_time)
                                {{ $data->turn_around_time }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                </table>
            </div>

            <div class="block">
                <div class="block-head">
                    Sample Coordinator
                </div>
                <div class="border-table">
                    <!-- First Table: Basic Details -->
                    <table>
                        <tr class="table_bg">
                            <th class="w-10">Sr No.</th>
                            <th class="w-15">Assignment Of Date</th>
                            <th class="w-15">Analytical Receipt (AR) Number</th>
                            <th class="w-15">Sample Name</th>
                            <th class="w-15">Batch Number</th>
                            <th class="w-15">Sample Quantity</th>
                        </tr>

                        @php
                            $productmateIndex = 0;
                        @endphp

                        @if ($ReceiptCoordinatorGrid && is_array($ReceiptCoordinatorGrid->data))
                            @foreach ($ReceiptCoordinatorGrid->data as $index => $Prodmateriyal)
                                <tr>
                                    <td>{{ ++$productmateIndex }}</td>
                                    <td>{{ $Prodmateriyal['assignment_date'] ?? '' }}</td>
                                    <td>{{ $Prodmateriyal['analytical_receipt'] ?? '' }}</td>
                                    <td>{{ $Prodmateriyal['sample_name'] ?? '' }}</td>
                                    <td>{{ $Prodmateriyal['Batch'] ?? '' }}</td>
                                    <td>{{ $Prodmateriyal['sample_quantity'] ?? '' }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6">Not Applicable</td>
                            </tr>
                        @endif
                    </table>
                </div>
            </div>

            <div class="block">
                <div class="border-table">
                    <!-- Second Table: Analytical Details -->
                    <table>
                        <tr class="table_bg">
                            <th class="w-10">Sr No.</th>
                            <th class="w-15">Manufacturing Date</th>
                            <th class="w-15">Expiry Date</th>
                            <th class="w-5">Recommended Storage Conditions</th>
                            <th class="w-5">Physical Observation</th>
                            <th class="w-5">Remarks</th>
                        </tr>

                        @php
                            $productmateIndex = 0;
                        @endphp
                        
                        @if ($ReceiptCoordinatorGrid && is_array($ReceiptCoordinatorGrid->data))
                            @foreach ($ReceiptCoordinatorGrid->data as $index => $Prodmateriyal)
                                <tr>
                                    <td>{{ ++$productmateIndex }}</td>
                                    <td>
                                        {{ $Prodmateriyal['manufacturing_date'] 
                                            ? \Carbon\Carbon::parse($Prodmateriyal['manufacturing_date'])->format('d-M-Y') 
                                            : '' }}
                                    </td>
                                    <td>
                                        {{ $Prodmateriyal['expiry_date'] 
                                            ? \Carbon\Carbon::parse($Prodmateriyal['expiry_date'])->format('d-M-Y') 
                                            : '' }}
                                    </td>
                                    <td>{{ $Prodmateriyal['recommended_storage'] ?? '' }}</td>
                                    <td>{{ $Prodmateriyal['physical_observation'] ?? '' }}</td>
                                    <td>{{ $Prodmateriyal['Remarks'] ?? '' }}</td>

                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6">Not Applicable</td>
                            </tr>
                        @endif
                    </table>
                </div>
            </div>

            <div class="block">
                <div class="border-table">
                    <!-- Third Table: Analytical Details -->
                    <table>
                        <tr class="table_bg">
                            <th class="w-10">Sr No.</th>
                            <th class="w-5">LSL</th>
                            <th class="w-5">USL</th>
                            <th class="w-5">Observed Value</th>
                            <th class="w-5">Analyst Name</th>
                        </tr>

                        @php
                            $productmateIndex = 0;
                        @endphp
                        
                        @if ($ReceiptCoordinatorGrid && is_array($ReceiptCoordinatorGrid->data))
                            @foreach ($ReceiptCoordinatorGrid->data as $index => $Prodmateriyal)
                                <tr>
                                    <td>{{ ++$productmateIndex }}</td>
                                    <td>{{ $Prodmateriyal['LSL'] ?? '' }}</td>
                                    <td>{{ $Prodmateriyal['USL'] ?? '' }}</td>
                                    <td>{{ $Prodmateriyal['observed_value'] ?? '' }}</td>
                                    <td>{{ $Prodmateriyal['analyst_name'] ?? '' }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5">Not Applicable</td>
                            </tr>
                        @endif
                    </table>
                </div>
            </div>
            
            

            <div class="block">
                <div class="block-head">
                   Review-1
                </div>
                <table>
                    <tr>
                       <th class="w-20">Review-1 Assesment</th>
                        <td class="w-80">
                            @if ($data->review_1_assesment)
                                {{ $data->review_1_assesment }}
                            @else
                                Not Applicable
                            @endif
                        </td> 
                    </tr>
                    
                    <tr>
                       <th class="w-20">Review-1 Comment</th>
                        <td class="w-80">
                            @if ($data->Review1_Comment)
                                {{ $data->Review1_Comment }}
                            @else
                                Not Applicable
                            @endif
                        </td> 
                    </tr>
                </table>

                <div class="border-table">
                    <div class="block-head">
                        Review-1 Attachment
                    </div>
                    <table>
                        <tr class="table_bg">
                            <th class="w-20">S.N.</th>
                            <th class="w-60">Attachment</th>
                        </tr>
                        @if ($data->review1_attachment)
                            @foreach (json_decode($data->review1_attachment) as $key => $file)
                                <tr>
                                    <td class="w-20">{{ $key + 1 }}</td>
                                    <td class="w-20"><a href="{{ asset('upload/' . $file) }}"
                                            target="_blank"><b>{{ $file }}</b></a> </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td class="w-20">1</td>
                                <td class="w-20">Not Applicable</td>
                            </tr>
                        @endif

                    </table>
                </div>
            </div>

            <div class="block">
                <div class="block-head">
                   Review-2
                </div>
                <table>
                    <tr>
                       <th class="w-20">Review-2 Assesment</th>
                        <td class="w-80">
                            @if ($data->review_2_assesment)
                                {{ $data->review_2_assesment }}
                            @else
                                Not Applicable
                            @endif
                        </td> 
                    </tr>
                    
                    <tr>
                       <th class="w-20">Review-2 Comment</th>
                        <td class="w-80">
                            @if ($data->Review2_Comment)
                                {{ $data->Review2_Comment }}
                            @else
                                Not Applicable
                            @endif
                        </td> 
                    </tr>
                </table>

                <div class="border-table">
                    <div class="block-head">
                        Review-2 Attachment
                    </div>
                    <table>
                        <tr class="table_bg">
                            <th class="w-20">S.N.</th>
                            <th class="w-60">Attachment</th>
                        </tr>
                        @if ($data->review2_attachment)
                            @foreach (json_decode($data->review2_attachment) as $key => $file)
                                <tr>
                                    <td class="w-20">{{ $key + 1 }}</td>
                                    <td class="w-20"><a href="{{ asset('upload/' . $file) }}"
                                            target="_blank"><b>{{ $file }}</b></a> </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td class="w-20">1</td>
                                <td class="w-20">Not Applicable</td>
                            </tr>
                        @endif

                    </table>
                </div>
            </div>

            <div class="block">
                <div class="block-head">
                   Approver
                </div>
                <table>
                    <tr>
                       <th class="w-20">Assesment Of Approver</th>
                        <td class="w-80">
                            @if ($data->approver_assesment)
                                {{ $data->approver_assesment }}
                            @else
                                Not Applicable
                            @endif
                        </td> 
                    </tr>
                    
                    <tr>
                       <th class="w-20">Approver Comment</th>
                        <td class="w-80">
                            @if ($data->approver_Comment)
                                {{ $data->approver_Comment }}
                            @else
                                Not Applicable
                            @endif
                        </td> 
                    </tr>
                </table>

                <div class="border-table">
                    <div class="block-head">
                        Approver Attachment
                    </div>
                    <table>
                        <tr class="table_bg">
                            <th class="w-20">S.N.</th>
                            <th class="w-60">Attachment</th>
                        </tr>
                        @if ($data->approver_attachment)
                            @foreach (json_decode($data->approver_attachment) as $key => $file)
                                <tr>
                                    <td class="w-20">{{ $key + 1 }}</td>
                                    <td class="w-20"><a href="{{ asset('upload/' . $file) }}"
                                            target="_blank"><b>{{ $file }}</b></a> </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td class="w-20">1</td>
                                <td class="w-20">Not Applicable</td>
                            </tr>
                        @endif

                    </table>
                </div>
            </div>
            
            
            <div class="block">
                <div class="block-head">
                    Activity Log
                </div>
                <table>
                    <tr>
                        <th class="w-20">Sample Receive By</th>
                        <td class="w-30">{{ $data->pending_front_offiece_review_by }}</td>
                        <th class="w-20">Sample Receive On</th>
                        <td class="w-30"> {{ $data->pending_front_offiece_review_on }}</td>
                        <th class="w-20">Sample Receive Comment</th>
                        <td class="w-30">{{ $data->pending_front_offiece_review_comment }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Cancel By</th>
                        <td class="w-30">{{ $data->Cancel_By }}</td>
                        <th class="w-20">Cancel On</th>
                        <td class="w-30">{{ $data->Cancel_On }}</td>
                        <th class="w-20">Cancel Comment</th>
                        <td class="w-30">{{ $data->Cancel_Comment }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Transfer To Sample Coordinator By</th>
                        <td class="w-30">{{ $data->pending_Review_by_sample_coordinator }}</td>
                        <th class="w-20">Transfer To Sample Coordinator On</th>
                        <td class="w-30">{{ $data->pending_Review_on_sample_coordinator}}</td>
                        <th class="w-20">Transfer To Sample Coordinator Comment</th>
                        <td class="w-30">{{ $data->pending_Review_comment_sample_coordinator }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Review Completed By Sample Coordinator</th>
                        <td class="w-30">{{ $data->pending_allocation_sample_coordinator_by }}</td>
                        <th class="w-20">Review Completed By Sample Coordinator On</th>
                        <td class="w-30">{{ $data->pending_allocation_sample_coordinator_on }}</td>
                        <th class="w-20">Review Completed By Sample Coordinator Comment</th>
                        <td class="w-30">{{ $data->pending_allocation_sample_coordinator_comment }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Allocation of Sample for Analysis Completed By</th>
                        <td class="w-30">{{ $data->pending_sample_acknowledgement_by }}</td>
                        <th class="w-20">Allocation of Sample for Analysis Completed On</th>
                        <td class="w-30">{{ $data->pending_sample_acknowledgement_on }}</td>
                        <th class="w-20">Allocation of Sample for Analysis Completed Comment</th>
                        <td class="w-30">{{ $data->pending_sample_acknowledgement_comment }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Start Analysis By</th>
                        <td class="w-30">{{ $data->Pending_sample_analysis_by }}</td>
                        <th class="w-20">Start Analysis On</th>
                        <td class="w-30">{{ $data->Pending_sample_analysis_on }}</td>
                        <th class="w-20">Start Analysis Comment</th>
                        <td class="w-30">{{ $data->Pending_sample_analysis_comment }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Analysis Complete By</th>
                        <td class="w-30">{{ $data->closed_done1_by }}</td>
                        <th class="w-20">Analysis Complete On</th>
                        <td class="w-30">{{ $data->closed_done1_on }}</td>
                        <th class="w-20">Analysis Complete Comment</th>
                        <td class="w-30">{{ $data->closed_done1_comment }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Analysis Completed & Verification Required By</th>
                        <td class="w-30">{{ $data->pending_verification1_by }}</td>
                        <th class="w-20">Analysis Completed & Verification Required On</th>
                        <td class="w-30">{{ $data->pending_verification1_on }}</td>
                        <th class="w-20">Analysis Completed & Verification Required Comment</th>
                        <td class="w-30">{{ $data->pending_verification1_comment }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Verification for Review-1 Complete By</th>
                        <td class="w-30">{{ $data->pending_verification2_by }}</td>
                        <th class="w-20">Verification for Review-1 Complete On</th>
                        <td class="w-30">{{ $data->pending_verification2_on }}</td>
                        <th class="w-20">Verification for Review-1 Complete Comment</th>
                        <td class="w-30">{{ $data->pending_verification2_comment }}</td>
                    </tr>

                    <tr>
                        <th class="w-20">Verification for Review-2 Complete By</th>
                        <td class="w-30">{{ $data->pending_verification_approve_by }}</td>
                        <th class="w-20">Verification for Review-2 Complete On</th>
                        <td class="w-30">{{ $data->pending_verification_approve_on }}</td>
                        <th class="w-20">Verification for Review-2 Complete Comment</th>
                        <td class="w-30">{{ $data->pending_verification_approve_comment }}</td>
                    </tr>

                    <tr>
                        <th class="w-20">Approval Complete By</th>
                        <td class="w-30">{{ $data->closed_done2_by }}</td>
                        <th class="w-20">Approval Complete On</th>
                        <td class="w-30">{{ $data->closed_done2_on }}</td>
                        <th class="w-20">Approval Complete Comment</th>
                        <td class="w-30">{{ $data->closed_done2_comment }}</td>
                    </tr>



                </table>
            </div>
        </div>
    </div>

  

</body>

</html>
