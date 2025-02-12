@extends('frontend.rcms.layout.main_rcms')
@section('rcms_container')

<style>
    #rcms-dashboard > div > div > div > div > div.main-scope-table.table-container > div:nth-child(1) > div > div > div > p:nth-child(1){
        margin-bottom: 0rem !important;
    }
    .card{
        border: none;
        margin-top: 10px;
        box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
    }
    .card:hover{
        border: none;
        box-shadow: rgba(0, 0, 0, 0.16) 0px 10px 36px 0px, rgba(0, 0, 0, 0.06) 0px 0px 0px 1px;
    }
    .grid-body{
        display: grid;
        grid-template-columns: 1fr 2fr 1fr 1fr 1fr;
    }
    .notification-dot {
        height: 10px;
        width: 10px;
        border-radius: 50%;
        display: inline-block;
    }
    .green { background-color: green; }
    .red { background-color: red; }
</style>

<style>
        * {
            box-sizing: border-box;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
        }

        h2 {
            text-align: center;
            font-size: 18px;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 30px 0;
        }

        /* Table Styles */

        .table-wrapper {
            box-shadow: 0px 35px 50px rgba(0, 0, 0, 0.2);
        }

        .fl-table {
            border-radius: 5px;
            font-size: 12px;
            font-weight: normal;
            border: none;
            border-collapse: collapse;
            width: 100%;
            max-width: 100%;
            white-space: nowrap;
            background-color: white;
            table-layout: fixed;
            /* Added for fixed table layout */
        }

        .fl-table td,
        .fl-table th {
            text-align: center;
            padding: 8px;
            word-wrap: break-word;
            /* Allows text to break within the cell */
            white-space: normal;
            /* Allows text to wrap to a new line */
        }

        .fl-table td {
            border-right: 1px solid #f8f8f8;
            font-size: 12px;
        }

        .fl-table thead th {
            color: #000000;
            background: #4254be9e;
        }

        .fl-table thead th:nth-child(odd) {
            color: #000000;
            background: #4254be9e;
        }

        .fl-table tr:nth-child(even) {
            background: #F8F8F8;
        }

        /* Responsive */

        @media (max-width: 767px) {
            .fl-table {
                display: block;
                width: 100%;
            }

            .table-wrapper:before {
                content: "Scroll horizontally >";
                display: block;
                font-size: 11px;
                color: white;
                padding: 0 0 10px;
            }

            .fl-table thead,
            .fl-table tbody,
            .fl-table thead th {
                display: block;
            }

            .fl-table thead th:last-child {
                border-bottom: none;
            }

            .fl-table thead {
                float: left;
            }

            .fl-table tbody {
                width: auto;
                position: relative;
                overflow-x: auto;
            }

            .fl-table td,
            .fl-table th {
                padding: 20px .625em .625em .625em;
                height: 60px;
                vertical-align: middle;
                box-sizing: border-box;
                overflow-x: hidden;
                overflow-y: auto;
                width: 120px;
                font-size: 13px;
                font-family: sans-serif;
                text-overflow: ellipsis;
            }

            .fl-table thead th {
                text-align: left;
                border-bottom: 1px solid #f7f7f9;
            }

            .fl-table tbody tr {
                display: table-cell;
            }

            .fl-table tbody tr:nth-child(odd) {
                background: none;
            }

            .fl-table tr:nth-child(even) {
                background: transparent;
            }

            .fl-table tr td:nth-child(odd) {
                background: #F8F8F8;
                border-right: 1px solid #E6E4E4;
            }

            .fl-table tr td:nth-child(even) {
                border-right: 1px solid #E6E4E4;
            }

            .fl-table tbody td {
                display: block;
                text-align: center;
            }
        }

        body,
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Lora', serif;
        }

        #main-container {
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: left;
        }

        #main-container .notification-container {
            max-width: 1250px;
            width: 100%;
            padding: 20px;
            backdrop-filter: blur(10px);
            background: #86bceb27;
            border-top: 10px solid #8e9adf9e;
        }

        #main-container .logo {
            width: 475px;
            aspect-ratio: 1/0.3;
            height: 122px;
            margin-bottom: 30px;
        }

        #main-container .logo img {
            width: 100%;
            height: 100%;
        }

        #main-container .mail-content {
            text-align: justify;
            margin-bottom: 20px;
        }

        #main-container .bar {
            margin-bottom: 20px;
        }
    </style>

    <div id="main-container">
        <div class="notification-container mt-4" style="max-width: 1789px;">
            <div class="inner-block">
                <div style="display: flex; justify-content: space-between;" class="logo-container">

                    <div style="width: 60%;">
                        <p>{{ $data->process_name }} No.:-
                            @if($data->process_name == 'Extension')
                                {{ Helpers::getDivisionName($data->site_location_code) }}/{{ $data->site }}/{{ date('Y') }}/{{ Helpers::record($data->record_number) }}
                            @else
                                {{ Helpers::getDivisionName($data->division_id) }}/{{ $data->site }}/{{ date('Y') }}/{{ Helpers::record($data->record) }}
                            @endif
                        </p>

                        <p>Activity was performed on the below listed {{ $data->process_name }}.</p>

                        <p>
                            Originator Name :- {{ Helpers::getInitiatorName($data->initiator_id) }}
                        </p>

                        <p>Date Opened:- {{ $data->created_at->format('d-M-Y H:i:s') }}</p>

                        <p>Comment:- @if($data->comment) {{ $data->comment }} @else N/A @endif</p>

                    </div>
                    <div style="margin-left: 00px" class="logo">
                        <img src="https://vidyagxp.com/vidyaGxp_logo.png" alt="...">
                        <!-- <img src="https://www.agio-pharma.com/wp-content/uploads/2019/10/logo-agio.png" alt="..."> -->
                    </div>
                </div>
                <div class="mail-content" style="margin-top: 20px">
                    <div class="table-wrapper">
                        <table class="fl-table">
                            <thead>
                                <tr>
                                    <th style="width: 10%">Record ID</th>
                                    <th style="width: 10%">Division</th>
                                    <th style="width: 50%">Short Description</th>
                                    <th style="width: 10%">Due Date</th>
                                    <th style="width: 20%">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="text-align: left; border-right: groove;">
                                        {{ Helpers::record($data->record) }}
                                    </td>

                                    <td style="text-align: left; border-right: groove;">
                                        {{ Helpers::getDivisionName($data->division_id) }}
                                    </td>

                                    <td style="text-align: left; border-right: groove;">
                                        {{ $data->short_description }}
                                    </td>

                                    <td style="text-align: left; border-right: groove;">
                                        @if($data->due_date)
                                            {{ Helpers::getDateFormat($data->due_date) }}
                                        @else 
                                            N/A 
                                        @endif
                                    </td>
                                    <td style="text-align: left; border-right: groove;">{{ $data->status }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div style="margin-top: 20px">
                        This notification has been automatically generated by the VidyaGxP System.
                    </div>
                </div>
            </div>
        </div>
    </div>


    
@endsection