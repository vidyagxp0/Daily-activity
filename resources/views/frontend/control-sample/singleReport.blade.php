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
        top: -155px;
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
                  Control Sample Single Report
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
                    <strong>Control Sample No.</strong>
                </td>
                <td class="w-40">
                {{ Helpers::getDivisionName($data->division_id) }}/CS/{{ date('Y') }}/{{ str_pad($data->record, 4, '0', STR_PAD_LEFT) }}                </td>
                <td class="w-30">
                    <strong>Record No.</strong> {{ str_pad($data->record, 4, '0', STR_PAD_LEFT) }}
                </td>
            </tr>
        </table>
    </header>

    <div class="inner-block">
        <div class="content-table">
            <div class="block">
                <div class="block-head">
                    General Information
                </div>
                <table>
                 <tr>
                        <th class="w-20">Record Number</th>
                        <td class="w-30"> 
                        {{ Helpers::getDivisionName($data->division_id) }}/CS/{{ date('Y') }}/{{ str_pad($data->record, 4, '0', STR_PAD_LEFT) }}                </td>
                        <th class="w-20">Site/Location Code</th>
                        <td class="w-30">
                        {{ Helpers::getDivisionName($data->division_id) }}
                        </td>
                    </tr>
                
                    <tr>  {{ $data->created_at }} added by {{ $data->originator }}
                    <th class="w-20">Initiator</th>
                        <td class="w-30">{{ Helpers::getInitiatorName($data->initiator_id) }}</td>
                        <th class="w-20">Date of Initiation</th>
                        <td class="w-30">{{ Helpers::getdateFormat($data->intiation_date) }}</td>
                    </tr>

                    <tr>
                        <th class="w-20">Assigned To</th>
                        <td class="w-30">@if($data->assign_to){{ Helpers::getInitiatorName($data->assign_to) }} @else Not Applicable @endif</td>
                        <th class="w-20">Due Date</th>
                        <td class="w-30"> @if($data->due_date){{Helpers::getdateFormat( $data->due_date) }} @else Not Applicable @endif</td>
                
                   
                    </tr>
                  
                    <tr>
                        <th class="w-20">Short Description</th>
                        <td class="w-30"> @if($data->short_description){{ $data->short_description }}@else Not Applicable @endif</td>
                    </tr>
                    
        

                </table>
                <div class="border-table">
                    <div class="block-head">
                    Supportive Attachment
                    </div>
                    <table>

                        <tr class="table_bg">
                            <th class="w-20">S.N.</th>
                            <th class="w-60">Batch No</th>
                        </tr>
                            @if($data->supportive_attachment)
                            @foreach(json_decode($data->supportive_attachment) as $key => $file)
                        <tr>
                            <td class="w-20">{{ $key + 1 }}</td>
                            <td class="w-20"><a href="{{ asset('upload/' . $file) }}" target="_blank"><b>{{ $file }}</b></a> </td>
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
            


           
                <!-- <div class="border-table">
                    <div class="block-head">
                        Report Attachment
                    </div>
                    <table>

                        <tr class="table_bg">
                            <th class="w-20">S.N.</th>
                            <th class="w-60">Batch No</th>
                        </tr>
                            @if($data->report_file)
                            @foreach(json_decode($data->report_file) as $key => $file)
                                <tr>
                                    <td class="w-20">{{ $key + 1 }}</td>
                                    <td class="w-20"><a href="{{ asset('upload/' . $file) }}" target="_blank"><b>{{ $file }}</b></a> </td>
                                </tr>
                            @endforeach
                            @else
                        <tr>
                            <td class="w-20">1</td>
                            <td class="w-20">Not Applicable</td>
                        </tr>
                        @endif

                    </table>
                </div> -->


                <div class="border-table tbl-bottum" >
                    <div class="block-head" style="margin-top: 2%;">
                        Control Sample Grid
                    </div>
                
                    @if ($controlsampleData && is_array($controlsampleData))
                        
                        <!-- First Table -->
                        <table style="margin-bottom: 5%;">
                            <thead>
                                <tr class="table_bg">
                                    <th class="w-10">Row #</th>
                                    <th class="w-30">Product Name</th>
                                    <th class="w-30">Product Code</th>
                                    <th class="w-30">Sample Type</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($controlsampleData as $gridData)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $gridData['product_name'] ?? '' }}</td>
                                        <td>{{ $gridData['product_code'] ?? '' }}</td>
                                        <td>{{ $gridData['sample_type'] ?? '' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td><input type="text" name="controlsampleData[0][product_name]" value=""></td>
                                        <td><input type="text" name="controlsampleData[0][product_code]" value=""></td>
                                        <td><input type="text" name="controlsampleData[0][sample_type]" value=""></td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                
                        <!-- Second Table -->
                        <table style="margin-bottom: 5%;">
                            <thead>
                                <tr class="table_bg">
                                    <th class="w-10">Row #</th>
                                    <th class="w-30">Market</th>
                                    <th class="w-30">Ar No</th>
                                    <th class="w-30">Batch Number</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($controlsampleData as $gridData)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $gridData['market'] ?? '' }}</td>
                                        <td>{{ $gridData['ar_number'] ?? '' }}</td>
                                        <td>{{ $gridData['batch_number'] ?? '' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td><input type="text" name="controlsampleData[0][market]" value=""></td>
                                        <td><input type="text" name="controlsampleData[0][ar_number]" value=""></td>
                                        <td><input type="text" name="controlsampleData[0][batch_number]" value=""></td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                
                        <!-- Third Table -->
                        <table style="margin-bottom: 5%;">
                            <thead>
                                <tr class="table_bg">
                                    <th class="w-10">Row #</th>
                                    <th class="w-30">Manufacturing Date</th>
                                    <th class="w-30">Expiry Date</th>
                                    <th class="w-30">Quantity</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($controlsampleData as $gridData)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{Helpers::getdateFormat( $gridData['manufacturing_date']) ?? '' }}</td>
                                        <td>{{Helpers::getdateFormat( $gridData['expiry_date']) ?? '' }}</td>
                                        <td>{{ $gridData['quantity'] ?? '' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td><input type="text" name="controlsampleData[0][manufacturing_date]" value=""></td>
                                        <td><input type="text" name="controlsampleData[0][expiry_date]" value=""></td>
                                        <td><input type="text" name="controlsampleData[0][quantity]" value=""></td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                
                        <!-- Fourth Table -->
                        <table style="margin-bottom: 5%;">
                            <thead>
                                <tr class="table_bg">
                                    <th class="w-10">Row #</th>
                                    <th class="w-30">Unit of Measurement (UOM)</th>
                                    <th class="w-30">Visual Inspection Scheduled On</th>
                                    <th class="w-30">Quantity Withdrawn</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($controlsampleData as $gridData)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $gridData['unit_of_measurment'] ?? '' }}</td>
                                        <td>{{ $gridData['vi_scheduled_on'] ?? '' }}</td>
                                        <td>{{ $gridData['quantity_withdrawn'] ?? '' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td><input type="text" name="controlsampleData[0][unit_of_measurment]" value=""></td>
                                        <td><input type="text" name="controlsampleData[0][vi_scheduled_on]" value=""></td>
                                        <td><input type="text" name="controlsampleData[0][quantity_withdrawn]" value=""></td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                
                        <!-- Fifth Table -->
                        <table style="margin-bottom: 5%;">
                            <thead>
                                <tr class="table_bg">
                                    <th class="w-10">Row #</th>
                                    <th class="w-30">Reason For Withdrawal</th>
                                    <th class="w-30">Current Quantity</th>
                                    <th class="w-30">Storage Location</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($controlsampleData as $gridData)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $gridData['reason_for_withdrawal'] ?? '' }}</td>
                                        <td>{{ $gridData['current_quantity'] ?? '' }}</td>
                                        <td>{{ $gridData['storage_location'] ?? '' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td><input type="text" name="controlsampleData[0][reason_for_withdrawal]" value=""></td>
                                        <td><input type="text" name="controlsampleData[0][current_quantity]" value=""></td>
                                        <td><input type="text" name="controlsampleData[0][storage_location]" value=""></td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                
                        <!-- Sixth Table -->
                        <table style="margin-bottom: 5%;">
                            <thead>
                                <tr class="table_bg">
                                    <th class="w-10">Row #</th>
                                    <th class="w-30">Storage Condition</th>
                                    <th class="w-30">Inspection Date</th>
                                    <th class="w-30">Inspection Detail</th>

                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($controlsampleData as $gridData)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $gridData['storage_condition'] ?? '' }}</td>
                                        <td>{{ Helpers::getdateFormat($gridData['inspection_date']) ?? '' }}</td>
                                        <td>{{ $gridData['inspection_detail'] ?? '' }}</td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td><input type="text" name="controlsampleData[0][storage_condition]" value=""></td>
                                        <td><input type="text" name="controlsampleData[0][inspection_date]" value=""></td>
                                        <td><input type="text" name="controlsampleData[0][inspection_detail]" value=""></td>

                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <!-- seventh Table -->
                        <table style="margin-bottom: 5%;">
                            <thead>
                                <tr class="table_bg">
                                    <th class="w-10">Row #</th>
                                    <th class="w-30">Inspection Done By</th>
                                    <th class="w-30">Destruction Due On</th>
                                    <th class="w-30">Destruction Date</th>

                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($controlsampleData as $gridData)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $gridData['inspection_done_by'] ?? '' }}</td>
                                        <td>{{ $gridData['destruction_due_on'] ?? '' }}</td>
                                        <td>{{Helpers::getdateFormat( $gridData['destruction_date'] )?? '' }}</td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td><input type="text" name="controlsampleData[0][inspection_done_by]" value=""></td>
                                        <td><input type="text" name="controlsampleData[0][destruction_due_on]" value=""></td>
                                        <td><input type="text" name="controlsampleData[0][destruction_date]" value=""></td>

                                    </tr>
                                @endforelse
                            </tbody>
                        </table style="margin-bottom: 5%;">
                        <!-- Eight Table -->
                        <table>
                            <thead>
                                <tr class="table_bg">
                                    <th class="w-10">Row #</th>
                                    <th class="w-30">Destroyed By</th>
                                    <th class="w-30">Neutralizing Agent</th>
                                    <th class="w-30">Instruction for destruction</th>
                                    <th class="w-30">Remarks</th>

                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($controlsampleData as $gridData)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $gridData['destroyed_by'] ?? '' }}</td>
                                        <td>{{ $gridData['neutralizing_agent'] ?? '' }}</td>
                                        <td>{{ $gridData['instruct_of_destrct'] ?? '' }}</td>
                                        <td>{{ $gridData['remarks'] ?? '' }}</td>


                                    </tr>
                                @empty
                                    <tr>
                                        <td><input type="text" name="controlsampleData[0][destroyed_by]" value=""></td>
                                        <td><input type="text" name="controlsampleData[0][neutralizing_agent]" value=""></td>
                                        <td><input type="text" name="controlsampleData[0][instruct_of_destrct]" value=""></td>
                                        <td><input type="text" name="controlsampleData[0][remarks]" value=""></td>


                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                
                    @else
                        <p>No certification data available.</p>
                    @endif
                </div>
                

            <div class="block">
                <div class="block-head">
                    Activity Log
                </div>
                <table>
                    <tr>
                        <th class="w-20">submit By</th>
                        <td class="w-30">{{ $data->submit_by ?? 'Not Applicable' }}</td>
                        <th class="w-20">submit On</th>
                        <td class="w-30">{{ Helpers::getdateFormat($data->submit_on)?? 'Not Applicable' }}</td>

                        <th class="w-20">submit Comment</th>
                        <td class="w-30">{{ $data->submit_comment ?? 'Not Applicable'}}</td>
                    </tr>
                   
                    <tr>
                        <th class="w-20">Control Sample Inspection Completed by</th>
                        <td class="w-30">{{ $data->control_sample_insp_by  ?? 'Not Applicable'}}</td>
                        <th class="w-20">Control Sample Inspection Completed On</th>
                        <td class="w-30">{{ Helpers::getdateFormat($data->control_sample_insp_on) ?? 'Not Applicable' }}</td>
                        <th class="w-20">Control Sample Inspection Completed Comment</th>
                        <td class="w-30">{{ $data->control_sample_ins_comment  ?? 'Not Applicable' }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">More Information By</th>
                        <td class="w-30">{{ $data->more_info_by  ?? 'Not Applicable'}}</td>
                        <th class="w-20">More Information On</th>
                        <td class="w-30">{{ Helpers::getdateFormat($data->more_info_on) ?? 'Not Applicable' }}</td>
                        <th class="w-20">More Information Comment</th>
                        <td class="w-30">{{ $data->more_info_comment  ?? 'Not Applicable'}}</td>
                    </tr>

                    
                    <tr>
                        <th class="w-20">Distraction Complete By</th>
                        <td class="w-30">{{ $data->distraction_complete_by  ?? 'Not Applicable' }}</td>
                        <th class="w-20">Distraction Complete On</th>
                        <td class="w-30">{{ Helpers::getdateFormat($data->distraction_complete_on)  ?? 'Not Applicable' }}</td>
                        <th class="w-20">Distraction Complete Comment</th>
                        <td class="w-30">{{ $data->distraction_complete_comment  ?? 'Not Applicable'}}</td>
                    </tr>

                    <tr>
                        <th class="w-20">More Information By</th>
                        <td class="w-30">{{ $data->more_info_second_by  ?? 'Not Applicable'}}</td>
                        <th class="w-20">More Information On</th>
                        <td class="w-30">{{ Helpers::getdateFormat($data->more_info_second_on) ?? 'Not Applicable' }}</td>
                        <th class="w-20">More Information Comment</th>
                        <td class="w-30">{{ $data->more_info_second_comment  ?? 'Not Applicable'}}</td>
                    </tr>

                    

                </table>
                                


                
                                
                                
                
            </div>
        </div>
    </div>

    <footer>
        <table>
            <tr>
                <td class="w-30">
                    <strong>Printed On :</strong> {{ date('d-M-Y') }}
                </td>
                <td class="w-40">
                    <strong>Printed By :</strong> {{ Auth::user()->name }}
                </td>
                {{-- <td class="w-30">
                    <strong>Page :</strong> 1 of 1
                </td> --}}
            </tr>
        </table>
    </footer>

</body>

</html>
