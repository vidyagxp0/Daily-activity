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
               <strong> OOC Log Report </strong>
                </td>

                <td class="w-50">
                <div class="logo">
                    <img src="data:image/png;base64,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" alt="Medicef Logo" style="width: 200px; height: auto;">

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
                <th style="width: 5%;">Sr.No.</th>
                <th>Initiation Date</th>
                <th>Record No.</th>
                <th>Division</th>
                <th>Department Name</th>
                <th>Short Descriptiobn</th>
                <th>Due Date</th>
                <th>Initiator</th>
                {{-- <th>Incident Related to</th>
                <th>Description of Incident</th>
                <th>Material / Product name</th>
                <th>Batch No.</th> --}}
                <th>Closing Date</th>
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
                <td>{{$action_item->intiation_date ? $action_item->intiation_date:'Not Applicable'}}</td>
                <td>{{$action_item->division ? $action_item->division->name : ' Not Applicable '}}/AI/{{ date('Y') }}/{{ str_pad($action_item->record, 4, '0', STR_PAD_LEFT)}}</td>
                <td>{{$action_item->division ? $action_item->division->name : ' Not Applicable '}}</td>
                <td>{{$action_item->short_description}}</td>
                <td>{{$action_item->due_date ? Carbon::parse($action_item->due_date)->format('d-M-Y') : ' Not Applicable '}}</td>
                <td>{{$action_item->initiator ? $action_item->initiator->name : ' Not Applicable '}}</td>
                <td>{{$action_item->effective_approval_complete_on ? Carbon::parse($action_item->effective_approval_complete_on)->format('d-M-Y') : ' Not Applicable '}}</td>
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
