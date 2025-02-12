    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Vidyagxp - Software</title>
        <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    </head>

    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
        }

        .w-5 {
            width: 5%;
        }

        .w-10 {
            width: 10%;
        }

        .w-15 {
            width: 15%;
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
            font-size: 0.7rem;
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
            counter-increment: page;

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
            text-align: center;

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

        .allow-wb {
            word-break: break-all;
            word-wrap: break-word;
        }
    </style>

    <body>

        <header>
        
            <div style="display: flex; align-items: center; justify-content: space-between; width: 100%;">
                <!-- Left logo -->
                <div style="width: 5%; text-align: left;">
                    <img src="https://navin.mydemosoftware.com/public/admin/assets/images/connexo.png" 
                         alt="Left Logo" 
                         style="height: 30px; width: auto; margin-bottom: -15px !important;">
                </div>
                
            
                <!-- Center title -->
                <div style="text-align: center; font-weight: bold;">
                    Training Need Identification Matrix
                </div>
            
                <!-- Right logo -->
                <div style="text-align: right; margin-left: auto;">
                    {{-- <img src="https://media.licdn.com/dms/image/v2/C4E0BAQFbURQWpKn58A/company-logo_200_200/company-logo_200_200/0/1630619488370/symbiotec_pharmalab_pvt_ltd__logo?e=2147483647&v=beta&t=ijLmHrqtD-uAkL-S29EmQlvC3709-6BC7VvU19lcbTM" 
                         alt="Right Logo" 
                         style="height: 90px; max-width: 100%; margin-top: -9.9% !important;"> --}}
                </div>
                
            </div>
            
            
            
            
            
        </header>
        <br>

        <div class="inner-block" style="margin-top: -70px !important;">
            <div class="content-table">
                <div class="block">
                    <div class="head">

                        <div class="border-table">
                            <table>
                                <tr>
                                    <td class="w-30">
                                        <strong>Location: </strong> @if($TniData->division_id == "P1")  P1(Indore Location) @elseif($TniData->division_id == "P2") P2(Pithampure Location) @elseif($TniData->division_id == "P4") P4(Ujjain Site) @else C1(China Plant) @endif
                                    </td>
                                    <td class="w-40">
                                        <strong>Department & Area: </strong>{{ $TniData->department }}
                                    </td>
                                    <td class="w-30">
                                        <strong>TNI No.: </strong> {{ $TniData->division_id }}/TNI/{{ $TniData->department_code }}/{{ $TniData->created_at->format('Y') }}/R{{ $TniData->version_count }}
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div class="border-table" style="margin-top: 15px;">
                            <table>
                                <tr class="">
                                    <th class="w-5">S.N.</th>
                                    <th class="w-15">SOP No.</th>
                                    <th class="w-15">SOP Title</th>
                                    <th class="w-15">Designation</th>
                                    <th class="w-15">Training Type	</th>
                                    <th class="w-15">Start Date	</th>
                                    <th class="w-15">End Date	</th>
                                    
                                </tr>
                                @php $counter = 1; @endphp
                                @foreach($gridData as $document)
                                {{-- @php
                                    dd($document);
                                @endphp --}}
                                    <tr>
                                        <td>{{ $counter++ }}</td>
                                        <td>{{ $document['sop_numbers'] ?? '' }}</td>
                                        <td>{{ $document['documentName'] ?? '' }}</td>
                                        <td>{{ $document['designation'] ?? '' }}</td>
                                        <td>{{ $document['trainingType'] ?? '' }}</td>
                                        <td>{{Helpers::getdateFormat ($document['startDate']) ?? '' }}</td>
                                        <td>{{ Helpers::getdateFormat($document['endDate']) ?? '' }}</td>


                                    </tr>
                                @endforeach
                            </table>
                        </div>


                    
                        <div class="border-table" style="margin-top: 15px;">
                            <table>
                                <tr>
                                    <th class="w-20">
                                        TNI Matrix
                                    </th>
                                    <th class="w-60">
                                        Prepared By Concerned dept.
                                    </th>
                                    <th class="w-60">
                                        Reviewed By(Head/Designee:Concerned  dept.)
                                    </th>
                                    <th class="w-60">
                                        Approved By(Head/Designee-QA)
                                    </th>
                                </tr>

                                <tr>
                                    <td>
                                        Name
                                    </td>
                                    <td>
                                        @if ($TniData->submitted_by) {{ $TniData->submitted_by }} @else Not Applicable @endif
                                    </td>
                                    <td>
                                        @if ($TniData->reviewed_by) {{ $TniData->reviewed_by }} @else Not Applicable @endif
                                    </td>
                                    <td>
                                        @if ($TniData->approved_by) {{ $TniData->approved_by }} @else Not Applicable @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Designation
                                    </td>
                                    <td>
                                        {{-- @if ($TniData->submitted_by) {{ $TniData->submitted_by }} @else Not Applicable @endif --}}
                                        Senior Officer
                                    </td>
                                    <td>
                                        {{-- @if ($TniData->reviewed_by) {{ $TniData->reviewed_by }} @else Not Applicable @endif --}}
                                        Senior Officer

                                    </td>
                                    <td>
                                        {{-- @if ($TniData->approved_by) {{ $TniData->approved_by }} @else Not Applicable @endif --}}
                                        Senior Officer

                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        Department
                                    </td>
                                    <td>
                                        @if ($TniData->department) {{ $TniData->department }} @else Not Applicable @endif
                                    </td>
                                    <td>
                                        @if ($TniData->department) {{ $TniData->department }} @else Not Applicable @endif
                                    </td>
                                    <td>
                                        @if ($TniData->department) {{ $TniData->department }} @else Not Applicable @endif
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        Sign & Date
                                    </td>
                                    <td>
                                        @if ($TniData->submitted_on) {{ Helpers::getdateFormat($TniData->submitted_on) }} @else Not Applicable @endif
                                    </td>
                                    <td>
                                        @if ($TniData->reviewed_on) {{Helpers::getdateFormat( $TniData->reviewed_on) }} @else Not Applicable @endif
                                    </td>
                                    <td>
                                        @if ($TniData->approved_on) {{Helpers::getdateFormat ($TniData->approved_on) }} @else Not Applicable @endif
                                    </td>
                                </tr>
                                

                            </table>
                        </div>
                    </div>
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

                </tr>
            </table>
        </footer>
        

    </body>

    </html>
