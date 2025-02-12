<!DOCTYPE html>
<html>
<head>
    
    <style>
        @page {
            margin: 20px; /* Set page margin */
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .table-container {
            position:relative;
            top : 3%;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: auto; /* Allow table to adjust column widths automatically */
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
            font-size: 12px; /* Reduce font size to ensure columns fit */
        }

        th {
            background-color: #f2f2f2;
        }

        /* Ensure that the second part of the table starts on a new page */
        .page-break {
            page-break-before: always;
        }

        .w-30 {
    width: 200px; /* Fixed width of 150 pixels */
}

.w-40 {
    width: 100px; /* Fixed width of 200 pixels */
}

    </style>
</head>
<header>
        <table>
            <tr>
                <td class="w-50 head">
               <strong> Extension Log Report </strong>
                </td>

                <td class="w-50">
                <div class="logo">
                    <img src="{{ asset('user/images/vidhyagxp.png') }}"alt="" class=" h-80" style="width: 200px;" >
                </div>
            </td>
            </tr>
            </table>
    </header>

<body>
    <!-- <h2 style="text-align: center;">Corrective and Preventive Action Log Report</h2> -->

    <div class="table-container">
        <!-- First table with first 6 columns -->
        <table>
            <thead>
                <tr>
                <th>Sr.No.</th>
                <th>Extension No.</th>
                <th>Division</th>
                <th>Priority</th>
                <th>Short Description</th>
                <th>Initiation Date</th>
                <th>Due Date</th>
                <th>Related Records</th>
                <th>Extension Closing Date</th>
                <th>Status</th>
                </tr>
            </thead>
            <tbody>
            @php
                use Carbon\Carbon;
            @endphp
            @foreach($FilterDDD as $action_item) 
            <tr>
                <td>{{$loop->index + 1}}</td>
                <td>{{$action_item->division ? $action_item->division->name : ' Not Applicable '}}/EXT/{{ date('Y') }}/{{ str_pad($action_item->record, 4, '0', STR_PAD_LEFT)}}</td>
                <td>{{$action_item->division ? $action_item->division->name : ' Not Applicable '}}</td>
                <td>{{ $action_item->priority_data ? $action_item->priority_data : ' Not Applicable ' }}</td>
                <td>{{$action_item->short_description}}</td>
                <td>{{$action_item->initiation_date ? $action_item->initiation_date:'Not Applicable'}}</td>
                <td>{{$action_item->current_due_date ? Carbon::parse($action_item->current_due_date)->format('d-M-Y') : ' Not Applicable '}}</td>
                <td>{{$action_item->related_records ? $action_item->related_records : ' Not Applicable'}}</td> 
               <td>{{$action_item->qah_approval_completed_on ? Carbon::parse($action_item->qah_approval_completed_on)->format('d-M-Y') : ' Not Applicable '}}</td>
                <td>{{$action_item->status ? $action_item->status : ' Not Applicable '}}</td>    
           </tr>
           @endforeach
    


    
    <footer>
        <table style ="    position:relative;
        top:95%;">
            <tr>
                <td class="w-30">
                    <strong>Printed By :</strong> 
                </td>
                <td class="w-40">
                    <strong>Printed On :</strong> 
                </td>

            </tr>
        </table>
    </footer>
    <style>
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

    </style>
</body>
</html>
